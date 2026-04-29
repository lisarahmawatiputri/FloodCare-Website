<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->nullable();
            $table->text('konten');
            $table->string('thumbnail')->nullable();
            $table->string('penulis')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->enum('status', ['draft', 'dipublikasi', 'diarsip'])->default('draft');
            $table->unsignedBigInteger('dilihat')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('artikel');
    }
};