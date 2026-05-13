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
    Schema::create('videos', function (Blueprint $table) {
    $table->id();
    $table->string('judul', 50);
    $table->text('deskripsi')->nullable();
    $table->string('file_video');
    $table->string('thumbnail')->nullable();
    $table->integer('durasi_detik')->default(0);
    $table->enum('status', ['draft', 'dipublikasi', 'diarsip']);
    $table->unsignedBigInteger('uploaded_by');
    $table->integer('dilihat')->default(0);
    $table->timestamps();
});
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
