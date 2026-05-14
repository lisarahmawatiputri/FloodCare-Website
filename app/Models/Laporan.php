<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan_banjir';

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'foto_laporan',
        'latitude',
        'longitude',
        'alamat_lokasi',
        'tinggi_banjir_cm',
        'status_laporan',
        'jumlah_konfirmasi',
        'catatan_admin',
        'tingkat_risiko',
        'divalidasi_oleh',
    ];

    // Auto klasifikasi saat tinggi_banjir_cm diisi
    public static function klasifikasiRisiko(float $tinggi): string
    {
        if ($tinggi < 30)          return 'rendah';
        if ($tinggi < 80)          return 'sedang';
        if ($tinggi < 150)         return 'tinggi';
        return 'sangat_tinggi';
    }

    // Boot: otomatis set tingkat_risiko setiap kali create/update
    protected static function booted(): void
    {
        static::saving(function ($laporan) {
            if (!is_null($laporan->tinggi_banjir_cm)) {
                $laporan->tingkat_risiko = self::klasifikasiRisiko((float) $laporan->tinggi_banjir_cm);
            }
        });
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh');
    }

    public function konfirmasi()
    {
        return $this->hasMany(KonfirmasiLaporan::class, 'laporan_id');
    }
}