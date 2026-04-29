<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'file_video',
        'thumbnail',
        'durasi_detik',
        'status',
    ];

    protected $casts = [
        'durasi_detik' => 'integer',
    ];
}
