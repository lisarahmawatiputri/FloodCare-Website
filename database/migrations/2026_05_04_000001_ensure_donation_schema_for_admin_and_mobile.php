<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('program_donasi')) {
            Schema::create('program_donasi', function (Blueprint $table) {
                $table->id();
                $table->string('nama_program');
                $table->text('deskripsi')->nullable();
                $table->decimal('target_dana', 15, 2)->default(0);
                $table->decimal('terkumpul', 15, 2)->default(0);
                $table->string('foto')->nullable();
                $table->string('status')->default('aktif');
                $table->unsignedBigInteger('dibuat_oleh')->nullable()->index();
                $table->timestamps();
            });
        } else {
            Schema::table('program_donasi', function (Blueprint $table) {
                if (! Schema::hasColumn('program_donasi', 'nama_program')) {
                    $table->string('nama_program')->nullable();
                }

                if (! Schema::hasColumn('program_donasi', 'deskripsi')) {
                    $table->text('deskripsi')->nullable();
                }

                if (! Schema::hasColumn('program_donasi', 'target_dana')) {
                    $table->decimal('target_dana', 15, 2)->default(0);
                }

                if (! Schema::hasColumn('program_donasi', 'terkumpul')) {
                    $table->decimal('terkumpul', 15, 2)->default(0);
                }

                if (! Schema::hasColumn('program_donasi', 'foto')) {
                    $table->string('foto')->nullable();
                }

                if (! Schema::hasColumn('program_donasi', 'status')) {
                    $table->string('status')->default('aktif');
                }

                if (! Schema::hasColumn('program_donasi', 'dibuat_oleh')) {
                    $table->unsignedBigInteger('dibuat_oleh')->nullable()->index();
                }
            });
        }

        if (Schema::hasTable('donasi')) {
            Schema::table('donasi', function (Blueprint $table) {
                if (! Schema::hasColumn('donasi', 'user_id')) {
                    $table->unsignedBigInteger('user_id')->nullable()->index()->after('id');
                }

                if (! Schema::hasColumn('donasi', 'program_donasi_id')) {
                    $table->unsignedBigInteger('program_donasi_id')->nullable()->index()->after('user_id');
                }

                if (! Schema::hasColumn('donasi', 'kode_transaksi')) {
                    $table->string('kode_transaksi')->nullable()->unique()->after('program_donasi_id');
                }

                if (! Schema::hasColumn('donasi', 'nominal')) {
                    $table->decimal('nominal', 15, 2)->default(0)->after('kode_transaksi');
                }

                if (! Schema::hasColumn('donasi', 'pesan')) {
                    $table->text('pesan')->nullable()->after('nominal');
                }

                if (! Schema::hasColumn('donasi', 'is_anonymous')) {
                    $table->boolean('is_anonymous')->default(false)->after('pesan');
                }

                if (! Schema::hasColumn('donasi', 'metode_pembayaran')) {
                    $table->string('metode_pembayaran')->nullable()->after('is_anonymous');
                }

                if (! Schema::hasColumn('donasi', 'payment_type')) {
                    $table->string('payment_type')->nullable()->after('metode_pembayaran');
                }

                if (! Schema::hasColumn('donasi', 'status_pembayaran')) {
                    $table->string('status_pembayaran')->default('menunggu')->after('payment_type');
                }

                if (! Schema::hasColumn('donasi', 'paid_at')) {
                    $table->timestamp('paid_at')->nullable()->after('status_pembayaran');
                }

                if (! Schema::hasColumn('donasi', 'midtrans_order_id')) {
                    $table->string('midtrans_order_id')->nullable()->unique()->after('paid_at');
                }

                if (! Schema::hasColumn('donasi', 'snap_token')) {
                    $table->string('snap_token')->nullable()->after('midtrans_order_id');
                }

                if (! Schema::hasColumn('donasi', 'snap_url')) {
                    $table->text('snap_url')->nullable()->after('snap_token');
                }
            });
        }
    }

    public function down(): void
    {
        // Migration ini sengaja tidak drop kolom/tabel agar data donasi tidak hilang saat rollback.
    }
};
