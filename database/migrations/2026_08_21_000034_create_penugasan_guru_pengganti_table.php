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
        if (!Schema::hasTable('penugasan_guru_pengganti')) {
            Schema::create('penugasan_guru_pengganti', function (Blueprint $table) {
                $table->id('id_penugasan');
                $table->date('tanggal');
                $table->bigInteger('id_jadwal')->unsigned()->nullable();
                $table->integer('id_guru_tidak_hadir');
                $table->integer('id_guru_pengganti');
                $table->integer('id_kelas')->nullable();
                $table->string('jam_pelajaran', 100)->nullable();
                $table->text('catatan')->nullable();
                $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
                $table->bigInteger('id_petugas_piket')->unsigned()->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasan_guru_pengganti');
    }
};
