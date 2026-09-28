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
        if (!Schema::hasTable('jadwal_piket_waka')) {
            Schema::create('jadwal_piket_waka', function (Blueprint $table) {
                $table->id();
                $table->date('tanggal')->unique();
                $table->string('hari', 20);
                $table->unsignedTinyInteger('bulan'); // 1 - 12
                $table->unsignedSmallInteger('tahun'); // e.g. 2026
                $table->integer('id_guru')->nullable();
                $table->unsignedBigInteger('id_user')->nullable();
                $table->string('catatan', 255)->nullable();
                $table->timestamps();

                $table->index(['bulan', 'tahun']);
                $table->index('id_guru');
                $table->index('id_user');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_piket_waka');
    }
};
