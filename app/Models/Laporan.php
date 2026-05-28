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

    public static function klasifikasiRisiko(float $tinggi): string
    {
        if ($tinggi < 30) {
            return 'rendah';
        }

        if ($tinggi < 80) {
            return 'sedang';
        }

        if ($tinggi < 150) {
            return 'tinggi';
        }

        return 'sangat_tinggi';
    }

    protected static function booted(): void
    {
        static::creating(function ($laporan) {

            if (
                empty($laporan->tingkat_risiko) &&
                !is_null($laporan->tinggi_banjir_cm)
            ) {

                $laporan->tingkat_risiko = self::klasifikasiRisiko(
                    (float) $laporan->tinggi_banjir_cm
                );
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI PELAPOR
    |--------------------------------------------------------------------------
    */

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function validator()
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KONFIRMASI
    |--------------------------------------------------------------------------
    */

    public function konfirmasi()
    {
        return $this->hasMany(
            KonfirmasiLaporan::class,
            'laporan_id'
        );
    }
}