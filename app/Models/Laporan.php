<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'judul',
        'isi',
        'deskripsi',
        'lokasi',
        'foto',
        'status',
        'user_id',
        'nama',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
