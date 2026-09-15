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
        Schema::dropIfExists('jadwal_guru_piket');

        Schema::create('jadwal_guru_piket', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->index();
            $table->string('hari', 20);
            $table->unsignedTinyInteger('bulan')->index();
            $table->unsignedSmallInteger('tahun')->index();
            $table->unsignedTinyInteger('slot_ke'); // 1 sampai 8
            $table->integer('id_guru')->nullable()->index();
            $table->timestamps();

            $table->unique(['tanggal', 'slot_ke'], 'unique_tanggal_slot');
            $table->index(['tanggal', 'id_guru'], 'idx_tanggal_guru');
            $table->index(['bulan', 'tahun'], 'idx_bulan_tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_guru_piket');
    }
};
