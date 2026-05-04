<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ArtikelSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Hapus data artikel lama
        Artikel::truncate();

        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nama_lengkap' => 'Admin Artikel',
                'password' => Hash::make('password'),
            ]
        );

        Artikel::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);
    }
}
