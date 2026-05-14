<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonfirmasiLaporan extends Model
{
    protected $table = 'konfirmasi_laporan';

    public $timestamps = false;

    protected $fillable = [
        'laporan_id',
        'user_id',
        'is_akurat',
        'komentar',
        'created_at',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}