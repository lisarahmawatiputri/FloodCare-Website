<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

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

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production');
        Config::$isSanitized = (bool) config('midtrans.is_sanitized');
        Config::$is3ds = (bool) config('midtrans.is_3ds');

        return DB::transaction(function () use ($request, $user) {
            $orderId = 'DON-' . now()->format('YmdHis') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

            $donasiId = DB::table('donasi')->insertGetId([
                'user_id' => $user->id,
                'program_donasi_id' => $request->program_donasi_id,
                'nominal' => $request->amount,
                'metode_pembayaran' => 'midtrans',
                'status_pembayaran' => 'menunggu',
                'kode_transaksi' => $orderId,
                'midtrans_order_id' => $orderId,
                'pesan' => $request->pesan,
                'is_anonymous' => $request->boolean('is_anonymous'),
                'created_at' => now(),
                'updated_at' => now(),
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

            DB::table('donasi')
                ->where('id', $donasiId)
                ->update([
                    'snap_token' => $transaction->token,
                    'snap_url' => $transaction->redirect_url,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'message' => 'Transaksi donasi berhasil dibuat.',
                'donasi_id' => $donasiId,
                'order_id' => $orderId,
                'amount' => (int) $request->amount,
                'snap_token' => $transaction->token,
                'snap_url' => $transaction->redirect_url,
            ]);
        });
    }

    public function notification(Request $request)
{
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = (bool) config('midtrans.is_production');
    \Midtrans\Config::$isSanitized = (bool) config('midtrans.is_sanitized');
    \Midtrans\Config::$is3ds = (bool) config('midtrans.is_3ds');

    $notification = new \Midtrans\Notification();

    $orderId = $notification->order_id;
    $transactionStatus = $notification->transaction_status;
    $fraudStatus = $notification->fraud_status ?? null;
    $paymentType = $notification->payment_type ?? null;

    $status = 'menunggu';
    $paidAt = null;

    if ($transactionStatus === 'capture') {
        if ($fraudStatus === 'accept') {
            $status = 'sukses';
            $paidAt = now();
        }
    } elseif ($transactionStatus === 'settlement') {
        $status = 'sukses';
        $paidAt = now();
    } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failure'])) {
        $status = 'gagal';
    } elseif (in_array($transactionStatus, ['pending', 'challenge'])) {
        $status = 'menunggu';
    }

    return DB::transaction(function () use ($orderId, $status, $paidAt, $paymentType) {
        $donasi = DB::table('donasi')
            ->where('midtrans_order_id', $orderId)
            ->lockForUpdate()
            ->first();

        if (! $donasi) {
            return response()->json([
                'message' => 'Donasi tidak ditemukan.',
            ], 404);
        }

        $statusSebelumnya = $donasi->status_pembayaran;

        DB::table('donasi')
            ->where('id', $donasi->id)
            ->update([
                'status_pembayaran' => $status,
                'payment_type' => $paymentType,
                'paid_at' => $paidAt,
                'updated_at' => now(),
            ]);

        if ($status === 'sukses' && $statusSebelumnya !== 'sukses') {
            DB::table('program_donasi')
                ->where('id', $donasi->program_donasi_id)
                ->increment('terkumpul', $donasi->nominal);
        }

        return response()->json([
            'message' => 'Notification handled.',
            'order_id' => $orderId,
            'status' => $status,
        ]);
    });
}
}
