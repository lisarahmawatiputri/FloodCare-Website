# FloodCare Website - Hasil Merge ZIP

Base utama: `FloodCare_website` milik Thomas.
Sumber perubahan: `FloodCare` milik teammate.

## Yang digabung

- CRUD admin Donasi/Program Donasi dari ZIP teammate masuk ke sisi website/admin.
- Route API mobile/Midtrans milik Thomas dipertahankan dan tidak diganti versi teammate.
- `routes/web.php` digabung manual agar route artikel, video, user, laporan lama tetap ada dan route donasi admin baru ikut masuk.
- `Donasi.php` dan `ProgramDonasi.php` digabung agar mendukung kebutuhan mobile/Midtrans dan CRUD admin website.
- View admin donasi ditambahkan/diperbaiki:
  - `resources/views/admin/donasi/index.blade.php`
  - `resources/views/admin/donasi/create.blade.php`
  - `resources/views/admin/donasi/program.blade.php`
  - `resources/views/admin/donasi/transaksi.blade.php`
  - `resources/views/admin/donasi/show.blade.php`
- File `show.blade.php` donasi dari teammate dibersihkan dari conflict marker Git.
- Migration pengaman ditambahkan untuk memastikan tabel/kolom donasi, program_donasi, dan laporan yang dibutuhkan tersedia.

## Yang sengaja tidak digabung mentah-mentah

- `routes/api.php` dari teammate tidak dipakai karena menghapus route mobile/Midtrans, Google Auth, OTP, dan program donasi API.
- File `.env` tidak disertakan di ZIP final demi keamanan. Pakai `.env` lokal milikmu sendiri.
- Folder `.git` tidak disertakan di ZIP final agar tidak bentrok dengan repo GitHub lokalmu.
- `node_modules` tidak disertakan. Jalankan `npm install` kalau dibutuhkan.

## Setelah extract

Jalankan di folder project:

```bash
composer install
npm install
php artisan migrate
php artisan storage:link
php artisan route:list
php artisan serve
```

Route penting yang sudah dicek:

- `admin.donasi.index`
- `admin.donasi.create`
- `admin.donasi.program`
- `admin.donasi.transaksi`
- `admin.donasi.show`
- `admin.donasi.updateStatus`
- `api/donations/pay`
- `api/midtrans/notification`
- `api/program-donasi`
- `api/auth/google`
- `api/forgot-password`
- `api/reset-password`
