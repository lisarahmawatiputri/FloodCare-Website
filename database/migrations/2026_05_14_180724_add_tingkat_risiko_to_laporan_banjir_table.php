<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('laporan_banjir', function (Blueprint $table) {
        $table->string('tingkat_risiko')->default('rendah')->after('tinggi_banjir_cm');
    });
}

public function down(): void
{
    Schema::table('laporan_banjir', function (Blueprint $table) {
        $table->dropColumn('tingkat_risiko');
    });
}
};
