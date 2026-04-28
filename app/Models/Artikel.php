<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';

    protected $fillable = [
        'judul',
        'url_link',
        'konten',
        'thumbnail',
        'status',
        'user_id',
        'views',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
