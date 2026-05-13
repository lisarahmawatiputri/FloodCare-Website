<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramDonasi extends Model
{
    protected $table = 'program_donasi';

    protected $fillable = [
        'nama_program',
        'deskripsi',
        'target_dana',
        'terkumpul',
        'foto',
        'status',
        'dibuat_oleh',
    ];

    protected $casts = [
        'target_dana' => 'decimal:2',
        'terkumpul' => 'decimal:2',
    ];

    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'program_donasi_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function getTargetDanaFormatAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->target_dana, 0, ',', '.');
    }

    public function getTerkumpulFormatAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->terkumpul, 0, ',', '.');
    }
}
