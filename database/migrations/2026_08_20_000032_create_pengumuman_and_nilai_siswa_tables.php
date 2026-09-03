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
        // 1. Tabel Pengumuman / Berita Sekolah
        if (!Schema::hasTable('pengumuman')) {
            Schema::create('pengumuman', function (Blueprint $table) {
                $table->id('id_pengumuman');
                $table->string('judul');
                $table->text('isi');
                $table->string('kategori')->default('Umum'); // Rapat, Ujian, Kegiatan, Perubahan Jadwal, Penugasan, Umum
                $table->unsignedBigInteger('id_kelas')->nullable();
                $table->string('jam_mengajar', 100)->nullable();
                $table->string('status', 50)->default('aktif'); // aktif, selesai, arsip
                $table->string('keterangan')->nullable();
                $table->unsignedBigInteger('id_guru')->nullable();
                $table->date('tanggal');
                $table->timestamps();
            });
        }

        // 2. Tabel Nilai & Rapor Siswa
        if (!Schema::hasTable('nilai_siswa')) {
            Schema::create('nilai_siswa', function (Blueprint $table) {
                $table->id('id_nilai');
                $table->integer('id_siswa');
                $table->integer('id_kelas');
                $table->integer('id_mapel');
                $table->integer('id_guru');
                $table->string('semester', 10)->default('1');
                $table->string('tahun_ajaran', 20)->default('2026/2027');
                $table->decimal('nilai_tugas', 5, 2)->default(0.00);
                $table->decimal('nilai_harian', 5, 2)->default(0.00);
                $table->decimal('nilai_uts', 5, 2)->default(0.00);
                $table->decimal('nilai_uas', 5, 2)->default(0.00);
                $table->decimal('nilai_akhir', 5, 2)->default(0.00);
                $table->char('predikat', 2)->default('B');
                $table->text('catatan')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_siswa');
        Schema::dropIfExists('pengumuman');
    }
};
