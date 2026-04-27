<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'no_telepon',
        'foto_profil',
        'role',
        'provider',
        'status',
        'alasan_blokir',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'user_id');
    }

    // public function konfirmasi()
    // {
    //     return $this->hasMany(KonfirmasiLaporan::class, 'user_id');
    // }
}
