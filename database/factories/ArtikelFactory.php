<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Artikel>
 */
class ArtikelFactory extends Factory
{
    protected $model = Artikel::class;

    private $daerahJember = [
        'Kecamatan Jember',
        'Kecamatan Kaliwates',
        'Kecamatan Sumbersari',
        'Kecamatan Jenggawah',
        'Kecamatan Ledokombo',
        'Kecamatan Panti',
        'Kecamatan Rambipuji',
        'Kecamatan Ajung',
        'Kecamatan Bangsalsari',
        'Kecamatan Wuluhan',
    ];

    private $judulTopik = [
        'Cara Mengantisipasi Banjir di ',
        'Tanda-Tanda Dini Banjir di ',
        'Persiapan Menghadapi Musim Hujan di ',
        'Edukasi Evakuasi Mandiri di ',
        'Tips Selamat di Tengah Banjir ',
        'Perlindungan Harta Benda Saat Banjir di ',
        'Panduan Pasca Banjir untuk Masyarakat ',
        'Kesehatan Keluarga Saat Banjir di ',
        'Penyelamatan Diri di Sungai Bedadung ',
        'Kesiapsiagaan Bencana Banjir di ',
    ];

    private $isiArtikel = [
        'Banjir merupakan salah satu bencana alam yang sering terjadi di wilayah Kabupaten Jember, terutama di musim penghujan. Masyarakat perlu memahami cara-cara efektif untuk mengantisipasi banjir agar dapat meminimalkan kerugian harta benda dan jiwa. Berikut adalah langkah-langkah penting yang dapat dilakukan untuk mempersiapkan diri menghadapi banjir.',
        'Mengenali tanda-tanda dini banjir sangat penting untuk memberikan waktu yang cukup bagi masyarakat melakukan evakuasi. Beberapa indikasi yang perlu diperhatikan termasuk intensitas hujan yang tinggi, naiknya permukaan air sungai, dan perubahan cuaca yang ekstrem. Dengan memahami tanda-tanda ini, masyarakat dapat mengambil tindakan preventif lebih awal.',
        'Musim penghujan di Kabupaten Jember membawa risiko banjir yang cukup signifikan. Persiapan yang matang termasuk menyiapkan tas darurat, mengurangi barang-barang yang mudah terendam, dan mengetahui jalur evakuasi terdekat. Keluarga juga perlu membuat rencana komunikasi jika terjadi pemisahan selama evakuasi.',
        'Evakuasi mandiri adalah kemampuan untuk menyelamatkan diri sendiri dan keluarga tanpa menunggu bantuan dari pihak lain. Strategi ini sangat efektif untuk mengurangi beban tim penyelamat dan meningkatkan keselamatan pribadi. Latihan evakuasi secara berkala dapat meningkatkan kesiapan dan kepercayaan diri masyarakat.',
        'Ketika banjir terjadi, keselamatan diri menjadi prioritas utama. Hindari bergerak di air dengan arus yang kuat, gunakan jalur yang aman untuk bergerak, dan selalu gunakan alas kaki yang kuat. Jangan coba-coba melewati air yang dalam atau bergerak deras tanpa bantuan dan peralatan yang memadai.',
        'Melindungi harta benda berharga sebelum banjir datang adalah langkah cerdas untuk meminimalkan kerugian materiil. Simpan dokumen penting di tempat yang aman dan tahan air, pindahkan barang-barang berharga ke tempat yang lebih tinggi, dan catat inventaris harta benda untuk keperluan klaim asuransi.',
        'Setelah banjir surut, langkah pembersihan rumah harus dilakukan dengan hati-hati untuk mencegah penyakit. Gunakan perlengkapan perlindungan diri, bersihkan lumpur dengan air bersih yang mengalir, dan buang barang-barang yang sudah rusak parah. Ventilasi rumah dengan baik untuk mencegah pertumbuhan jamur.',
        'Kesehatan keluarga menjadi fokus utama saat terjadi banjir karena meningkatnya risiko penyakit menular. Pastikan ketersediaan air bersih yang cukup, jaga kebersihan pribadi dan lingkungan, dan segera konsultasi ke tenaga medis jika ada gejala penyakit. Vaksinasi tetanus juga direkomendasikan pasca banjir.',
        'Sungai Bedadung yang melintasi Kabupaten Jember berpotensi membanjiri area sekitarnya saat curah hujan tinggi. Masyarakat yang tinggal di sekitar sungai perlu lebih waspada dan memiliki rencana evakuasi yang matang. Monitor kondisi air sungai melalui berbagai sumber informasi yang tersedia.',
        'Kesiapsiagaan bencana banjir memerlukan koordinasi antara pemerintah, masyarakat, dan berbagai institusi. Edukasi rutin tentang mitigasi banjir, simulasi evakuasi, dan pemberdayaan masyarakat adalah kunci keberhasilan pengurangan risiko bencana. Bersama-sama kita dapat membangun komunitas yang lebih tangguh menghadapi banjir.',
    ];

    public function definition(): array
    {
        $daerah = $this->faker->randomElement($this->daerahJember);
        $judulTemplate = $this->faker->randomElement($this->judulTopik);
        $judul = $judulTemplate . $daerah;
        $konten = $this->faker->randomElement($this->isiArtikel);

        return [
            'judul' => $judul,
            'url_link' => 'https://floodcare.com/' . Str::slug($judul),
            'konten' => $konten . "\n\nWilayah: " . $daerah . ", Kabupaten Jember",
            'thumbnail' => null,
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'user_id' => 1,
            'views' => fake()->numberBetween(50, 500),
        ];
    }
}
