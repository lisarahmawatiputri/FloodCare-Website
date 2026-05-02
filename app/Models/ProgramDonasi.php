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
}
