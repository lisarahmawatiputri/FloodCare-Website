<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            // $table->unsignedBigInteger('user_id')->nullable(); // optional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};