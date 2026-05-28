<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        Log::info('Midtrans notification masuk', $payload);

        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;

        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
            Log::warning('Payload Midtrans tidak lengkap', $payload);

            return response()->json([
                'success' => false,
                'message' => 'Payload Midtrans tidak lengkap',
            ], 400);
        }

        $serverKey = config('services.midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');

        if (!$serverKey) {
            Log::error('MIDTRANS_SERVER_KEY belum dikonfigurasi');

            return response()->json([
                'success' => false,
                'message' => 'Server key belum dikonfigurasi',
            ], 500);
        }

        $expectedSignature = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . $serverKey
        );

        if (!hash_equals($expectedSignature, $signatureKey)) {
            Log::warning('Signature Midtrans tidak valid', [
                'order_id' => $orderId,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Signature tidak valid',
            ], 403);
        }

        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;

        $statusBaru = $this->mapStatusPembayaran($transactionStatus, $fraudStatus);

        return DB::transaction(function () use (
            $orderId,
            $statusBaru,
            $paymentType,
            $transactionStatus,
            $fraudStatus,
            $payload
        ) {
            $donasi = Donasi::where('midtrans_order_id', $orderId)
                ->orWhere('kode_transaksi', $orderId)
                ->lockForUpdate()
                ->first();

            if (!$donasi) {
                Log::warning('Donasi tidak ditemukan untuk callback Midtrans', [
                    'order_id' => $orderId,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Donasi tidak ditemukan',
                ], 404);
            }

            $statusLama = $this->normalizeStatus($donasi->status_pembayaran);

            // Jangan downgrade kalau donasi sudah sukses.
            if ($statusLama === 'sukses' && $statusBaru !== 'sukses') {
                Log::info('Callback Midtrans diabaikan karena donasi sudah sukses', [
                    'order_id' => $orderId,
                    'status_lama' => $statusLama,
                    'status_baru' => $statusBaru,
                    'transaction_status' => $transactionStatus,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Donasi sudah sukses, callback diabaikan',
                ]);
            }

            if ($statusLama === $statusBaru) {
                Log::info('Status donasi tidak berubah dari callback Midtrans', [
                    'order_id' => $orderId,
                    'status' => $statusBaru,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Status donasi tidak berubah',
                ]);
            }

            $donasi->status_pembayaran = $statusBaru;
            $donasi->payment_type = $paymentType ?? $donasi->payment_type;
            $donasi->metode_pembayaran = $paymentType ?? $donasi->metode_pembayaran;
            $donasi->paid_at = $statusBaru === 'sukses'
                ? ($donasi->paid_at ?? now())
                : null;

            $donasi->save();

            $program = ProgramDonasi::lockForUpdate()->find($donasi->program_donasi_id);

            if ($program) {
                if ($statusLama !== 'sukses' && $statusBaru === 'sukses') {
                    $program->terkumpul = (float) $program->terkumpul + (float) $donasi->nominal;
                }

                if ($statusLama === 'sukses' && $statusBaru !== 'sukses') {
                    $program->terkumpul = max(
                        0,
                        (float) $program->terkumpul - (float) $donasi->nominal
                    );
                }

                $program->status = ((float) $program->terkumpul >= (float) $program->target_dana)
                    ? 'selesai'
                    : 'aktif';

                $program->save();
            }

            Log::info('Status pembayaran donasi berhasil diperbarui otomatis dari Midtrans', [
                'order_id' => $orderId,
                'donasi_id' => $donasi->id,
                'status_lama' => $statusLama,
                'status_baru' => $statusBaru,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_type' => $paymentType,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notification Midtrans berhasil diproses',
            ]);
        });
    }

    private function mapStatusPembayaran(?string $transactionStatus, ?string $fraudStatus): string
    {
        if ($transactionStatus === 'settlement') {
            return 'sukses';
        }

        if ($transactionStatus === 'capture') {
            return $fraudStatus === 'accept' ? 'sukses' : 'menunggu';
        }

        if ($transactionStatus === 'pending') {
            return 'menunggu';
        }

        if (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'], true)) {
            return 'gagal';
        }

        return 'menunggu';
    }

    private function normalizeStatus(?string $status): string
    {
        return match ($status) {
            'success', 'sukses', 'settlement' => 'sukses',
            'pending', 'menunggu', 'challenge' => 'menunggu',
            'failed', 'failure', 'deny', 'expire', 'cancel', 'gagal' => 'gagal',
            default => 'menunggu',
        };
    }
}
