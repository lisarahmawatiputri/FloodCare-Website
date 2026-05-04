<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('laporan')) {
            Schema::table('laporan', function (Blueprint $table) {
                if (! Schema::hasColumn('laporan', 'nama')) {
                    $table->string('nama')->nullable()->after('id');
                }

                if (! Schema::hasColumn('laporan', 'deskripsi')) {
                    $table->text('deskripsi')->nullable()->after('judul');
                }

                if (! Schema::hasColumn('laporan', 'lokasi')) {
                    $table->string('lokasi')->nullable()->after('deskripsi');
                }

                if (! Schema::hasColumn('laporan', 'foto')) {
                    $table->string('foto')->nullable()->after('lokasi');
                }

                if (! Schema::hasColumn('laporan', 'status')) {
                    $table->string('status')->default('menunggu')->after('foto');
                }

                if (! Schema::hasColumn('laporan', 'user_id')) {
                    $table->unsignedBigInteger('user_id')->nullable()->index()->after('status');
                }
            });
        }
    }

    public function down(): void
    {
        // Data laporan sengaja dipertahankan.
    }
};
