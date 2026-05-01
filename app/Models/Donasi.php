<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $table = 'donasi';

    protected $fillable = [
        'user_id',
        'program_donasi_id',
        'nominal',
        'pesan',
        'is_anonymous',
        'metode_pembayaran',
        'payment_type',
        'status_pembayaran',
        'paid_at',
        'kode_transaksi',
        'midtrans_order_id',
        'snap_token',
        'snap_url',
    ];
}
