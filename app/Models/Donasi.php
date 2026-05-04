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

    protected $casts = [
        'is_anonymous' => 'boolean',
        'paid_at' => 'datetime',
        'nominal' => 'decimal:2',
    ];

    public function program()
    {
        return $this->belongsTo(ProgramDonasi::class, 'program_donasi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_pembayaran) {
            'sukses', 'success' => 'Sukses',
            'menunggu', 'pending' => 'Menunggu',
            'gagal', 'failed' => 'Gagal',
            default => ucfirst($this->status_pembayaran ?? '-'),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status_pembayaran) {
            'sukses', 'success' => 'success',
            'menunggu', 'pending' => 'warning',
            'gagal', 'failed' => 'danger',
            default => 'secondary',
        };
    }
}
