<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->string('midtrans_order_id')->nullable()->unique()->after('kode_transaksi');
            $table->string('snap_token')->nullable()->after('midtrans_order_id');
            $table->text('snap_url')->nullable()->after('snap_token');
            $table->string('payment_type')->nullable()->after('metode_pembayaran');
            $table->timestamp('paid_at')->nullable()->after('status_pembayaran');
            $table->text('pesan')->nullable()->after('nominal');
            $table->boolean('is_anonymous')->default(false)->after('pesan');
        });
    }

    public function down(): void
    {
        Schema::table('donasi', function (Blueprint $table) {
            $table->dropColumn([
                'midtrans_order_id',
                'snap_token',
                'snap_url',
                'payment_type',
                'paid_at',
                'pesan',
                'is_anonymous',
            ]);
        });
    }
};
