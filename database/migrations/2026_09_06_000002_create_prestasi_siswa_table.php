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
        if (!Schema::hasTable('prestasi_siswa')) {
            Schema::create('prestasi_siswa', function (Blueprint $table) {
                $table->id('id_prestasi');
                $table->integer('id_siswa');
                $table->integer('id_kelas')->nullable();
                $table->string('nama_prestasi');
                $table->string('kategori', 100)->default('Akademik'); // Akademik, Non-Akademik, Seni, Olahraga, Keagamaan
                $table->string('tingkat', 100)->default('Kabupaten/Kota'); // Sekolah, Kabupaten/Kota, Provinsi, Nasional, Internasional
                $table->string('peringkat', 100)->nullable(); // Juara 1, Juara 2, Juara 3, Harapan 1, Medali Emas, dll
                $table->date('tanggal_prestasi');
                $table->string('penyelenggara')->nullable();
                $table->text('keterangan')->nullable();
                $table->string('sertifikat_foto')->nullable();
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
        Schema::dropIfExists('prestasi_siswa');
    }
};
