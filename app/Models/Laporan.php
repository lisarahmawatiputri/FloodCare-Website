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