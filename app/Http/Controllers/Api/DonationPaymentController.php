<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class DonationPaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $request->validate([
            'program_donasi_id' => 'required|integer|exists:program_donasi,id',
            'amount' => 'required|integer|min:10000',
            'pesan' => 'nullable|string|max:500',
            'is_anonymous' => 'nullable|boolean',
        ]);

        $user = $request->user();

        $this->configureMidtrans();

        return DB::transaction(function () use ($request, $user) {
            $orderId = 'DON-' . now()->format('YmdHis') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

            $donasi = Donasi::create([
                'user_id' => $user->id,
                'program_donasi_id' => $request->program_donasi_id,
                'nominal' => $request->amount,
                'metode_pembayaran' => 'midtrans',
                'payment_type' => null,
                'status_pembayaran' => 'menunggu',
                'kode_transaksi' => $orderId,
                'midtrans_order_id' => $orderId,
                'snap_token' => null,
                'snap_url' => null,
                'pesan' => $request->pesan,
                'is_anonymous' => $request->boolean('is_anonymous'),
                'paid_at' => null,
            ]);

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $request->amount,
                ],
                'customer_details' => [
                    'first_name' => $user->nama_lengkap ?? 'Donatur',
                    'email' => $user->email,
                    'phone' => $user->no_telepon ?? '',
                ],
                'item_details' => [
                    [
                        'id' => 'DONASI-' . $request->program_donasi_id,
                        'price' => (int) $request->amount,
                        'quantity' => 1,
                        'name' => 'Donasi FloodCare',
                    ],
                ],
            ];

            $transaction = Snap::createTransaction($params);

            $donasi->update([
                'snap_token' => $transaction->token,
                'snap_url' => $transaction->redirect_url,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi donasi berhasil dibuat.',
                'donasi_id' => $donasi->id,
                'order_id' => $orderId,
                'amount' => (int) $request->amount,
                'snap_token' => $transaction->token,
                'snap_url' => $transaction->redirect_url,
            ]);
        });
    }

    public function notification(Request $request)
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
                'message' => 'Payload Midtrans tidak lengkap.',
            ], 400);
        }

        $serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');

        if (!$serverKey) {
            Log::error('MIDTRANS_SERVER_KEY belum dikonfigurasi.');

            return response()->json([
                'success' => false,
                'message' => 'Server key Midtrans belum dikonfigurasi.',
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
                'message' => 'Signature Midtrans tidak valid.',
            ], 403);
        }

        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;

        $statusBaru = $this->normalizeMidtransStatus($transactionStatus, $fraudStatus);

        return DB::transaction(function () use (
            $orderId,
            $statusBaru,
            $paymentType,
            $transactionStatus,
            $fraudStatus
        ) {
            $donasi = Donasi::where(function ($query) use ($orderId) {
                    $query->where('midtrans_order_id', $orderId)
                        ->orWhere('kode_transaksi', $orderId);
                })
                ->lockForUpdate()
                ->first();

            if (!$donasi) {
                Log::warning('Donasi tidak ditemukan untuk callback Midtrans', [
                    'order_id' => $orderId,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Donasi tidak ditemukan.',
                ], 404);
            }

            $statusLama = $this->normalizeLocalStatus($donasi->status_pembayaran);

            if ($statusLama === 'sukses' && $statusBaru !== 'sukses') {
                Log::info('Callback Midtrans diabaikan karena donasi sudah sukses', [
                    'order_id' => $orderId,
                    'donasi_id' => $donasi->id,
                    'status_lama' => $statusLama,
                    'status_baru' => $statusBaru,
                    'transaction_status' => $transactionStatus,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Donasi sudah sukses, callback diabaikan.',
                ]);
            }

            $donasi->update([
                'status_pembayaran' => $statusBaru,
                'payment_type' => $paymentType ?? $donasi->payment_type,
                'metode_pembayaran' => $paymentType ?? $donasi->metode_pembayaran,
                'paid_at' => $statusBaru === 'sukses'
                    ? ($donasi->paid_at ?? now())
                    : null,
            ]);

            $this->syncProgramDonationAmount($donasi, $statusLama, $statusBaru);

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
                'message' => 'Notification Midtrans berhasil diproses.',
                'order_id' => $orderId,
                'status' => $statusBaru,
            ]);
        });
    }

    public function simulateSuccess($id)
    {
        return DB::transaction(function () use ($id) {
            $donasi = Donasi::lockForUpdate()->findOrFail($id);

            $statusLama = $this->normalizeLocalStatus($donasi->status_pembayaran);

            if ($statusLama === 'sukses') {
                return response()->json([
                    'success' => false,
                    'message' => 'Donasi sudah pernah diproses.',
                ]);
            }

            $donasi->update([
                'status_pembayaran' => 'sukses',
                'paid_at' => $donasi->paid_at ?? now(),
            ]);

            $this->syncProgramDonationAmount($donasi, $statusLama, 'sukses');

            return response()->json([
                'success' => true,
                'message' => 'Donasi berhasil disimulasikan.',
                'donasi' => $donasi->fresh(),
            ]);
        });
    }

    public function history(Request $request)
    {
        $donations = DB::table('donasi')
            ->leftJoin('program_donasi', 'donasi.program_donasi_id', '=', 'program_donasi.id')
            ->where('donasi.user_id', $request->user()->id)
            ->select(
                'donasi.id',
                'donasi.program_donasi_id as program_id',
                'donasi.midtrans_order_id as order_id',
                'donasi.kode_transaksi',
                'donasi.nominal as amount',
                'donasi.status_pembayaran as status',
                'donasi.payment_type',
                'donasi.metode_pembayaran',
                'donasi.snap_token',
                'donasi.snap_url',
                'donasi.paid_at',
                'donasi.created_at',
                'donasi.updated_at',
                'program_donasi.nama_program as program_title',
                'program_donasi.foto as program_image'
            )
            ->orderByDesc('donasi.created_at')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Riwayat donasi berhasil diambil.',
            'data' => $donations,
        ]);
    }

    private function configureMidtrans(): void
    {
        Config::$serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = (bool) (config('midtrans.is_production') ?? env('MIDTRANS_IS_PRODUCTION', false));
        Config::$isSanitized = (bool) (config('midtrans.is_sanitized') ?? env('MIDTRANS_IS_SANITIZED', true));
        Config::$is3ds = (bool) (config('midtrans.is_3ds') ?? env('MIDTRANS_IS_3DS', true));
    }

    private function normalizeMidtransStatus(?string $transactionStatus, ?string $fraudStatus): string
    {
        if ($transactionStatus === 'settlement') {
            return 'sukses';
        }

        if ($transactionStatus === 'capture') {
            return $fraudStatus === 'accept' ? 'sukses' : 'menunggu';
        }

        if (in_array($transactionStatus, ['pending', 'challenge'], true)) {
            return 'menunggu';
        }

        if (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failure'], true)) {
            return 'gagal';
        }

        return 'menunggu';
    }

    private function normalizeLocalStatus(?string $status): string
    {
        return match ($status) {
            'success', 'sukses', 'settlement' => 'sukses',
            'pending', 'menunggu', 'challenge' => 'menunggu',
            'failed', 'failure', 'deny', 'expire', 'cancel', 'gagal' => 'gagal',
            default => 'menunggu',
        };
    }

    private function syncProgramDonationAmount(Donasi $donasi, string $statusLama, string $statusBaru): void
    {
        $program = ProgramDonasi::lockForUpdate()->find($donasi->program_donasi_id);

        if (!$program) {
            return;
        }

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
}
