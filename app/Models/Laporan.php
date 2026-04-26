<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan_banjir'; 
    protected $fillable = [
        'judul',
        'isi',
        'user_id'
    ];
}