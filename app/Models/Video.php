<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $table = 'video_edukasi';

    protected $fillable = [
        'judul',
        'deskripsi',
        'thumbnail',
        'file_video',
        'uploaded_by',
        'durasi_detik',
        'status',
        'dilihat',
    ];

    protected $casts = [
        'durasi_detik' => 'integer',
        'dilihat'      => 'integer',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getDurasiFormatAttribute()
    {
        if (!$this->durasi_detik) return '00:00';
        $m = floor($this->durasi_detik / 60);
        $s = $this->durasi_detik % 60;
        return sprintf('%02d:%02d', $m, $s);
    }
}