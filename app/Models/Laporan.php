<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan'; // opsional kalau nama tabel sama

    protected $fillable = [
        'judul',
        'isi',
        'user_id'
    ];
}