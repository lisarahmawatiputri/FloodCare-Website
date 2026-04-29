<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Video::create([
            'judul' => 'Cara membuat perahu darurat saat banjir',
            'deskripsi' => 'Tutorial lengkap cara membuat perahu darurat menggunakan bahan-bahan sederhana yang tersedia di rumah saat banjir terjadi.',
            'durasi_detik' => 272,
            'status' => 'published',
            'thumbnail' => null,
            'file_video' => null,
        ]);

        Video::create([
            'judul' => 'Pertolongan pertama korban tenggelam',
            'deskripsi' => 'Panduan pertolongan pertama untuk korban tenggelam termasuk teknik pernapasan buatan dan penyelamatan yang aman.',
            'durasi_detik' => 435,
            'status' => 'published',
            'thumbnail' => null,
            'file_video' => null,
        ]);

        Video::create([
            'judul' => 'Evakuasi warga lansia & anak-anak',
            'deskripsi' => 'Tata cara yang benar dalam menggeser dan mengevakuasi warga lansia dan anak-anak ke lokasi yang lebih aman.',
            'durasi_detik' => 230,
            'status' => 'draft',
            'thumbnail' => null,
            'file_video' => null,
        ]);

        Video::create([
            'judul' => 'Memilih lokasi pengungsian yang aman',
            'deskripsi' => 'Kriteria dan cara memilih lokasi pengungsian yang aman dari banjir termasuk faktor ketinggian dan aksesibilitas.',
            'durasi_detik' => 322,
            'status' => 'published',
            'thumbnail' => null,
            'file_video' => null,
        ]);

        Video::create([
            'judul' => 'Tanda-tanda awal bahaya banjir',
            'deskripsi' => 'Mengenal tanda-tanda peringatan dini banjir agar Anda bisa melakukan persiapan dengan cepat.',
            'durasi_detik' => 185,
            'status' => 'published',
            'thumbnail' => null,
            'file_video' => null,
        ]);

        Video::create([
            'judul' => 'Penyimpanan bahan makanan saat banjir',
            'deskripsi' => 'Teknik penyimpanan bahan makanan agar tetap aman dan tahan lama ketika kondisi banjir.',
            'durasi_detik' => 198,
            'status' => 'draft',
            'thumbnail' => null,
            'file_video' => null,
        ]);
    }
}
