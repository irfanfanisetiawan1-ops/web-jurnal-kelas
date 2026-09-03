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
        if (!Schema::hasTable('siswa_telat')) {
            Schema::create('siswa_telat', function (Blueprint $table) {
                $table->id('id_siswa_telat');
                $table->unsignedBigInteger('id_siswa');
                $table->unsignedBigInteger('id_kelas')->nullable();
                $table->unsignedBigInteger('id_guru_mengajar')->nullable();
                $table->unsignedBigInteger('id_jadwal')->nullable();
                $table->unsignedBigInteger('id_guru_piket')->nullable();
                $table->unsignedBigInteger('id_pengumuman')->nullable();
                $table->date('tanggal');
                $table->string('jam_terlambat', 10);
                $table->text('alasan')->nullable();
                $table->text('tindakan_hukuman')->nullable();
                $table->string('status_notifikasi', 20)->default('terkirim');
                $table->timestamps();
                $table->softDeletes();

                $table->index('id_siswa');
                $table->index('id_kelas');
                $table->index('id_guru_mengajar');
                $table->index('tanggal');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_telat');
    }
};
