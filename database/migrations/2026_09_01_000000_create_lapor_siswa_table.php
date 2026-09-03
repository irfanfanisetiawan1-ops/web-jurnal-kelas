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
        if (!Schema::hasTable('lapor_siswa')) {
            Schema::create('lapor_siswa', function (Blueprint $table) {
                $table->id('id_lapor_siswa');
                $table->unsignedBigInteger('id_siswa');
                $table->unsignedBigInteger('id_kelas')->nullable();
                $table->unsignedBigInteger('id_siswa_dispen')->nullable();
                $table->unsignedBigInteger('id_satpam')->nullable();
                $table->string('jenis_kejadian', 100)->default('Terlambat Kembali dari Izin');
                $table->text('catatan')->nullable();
                $table->boolean('send_wali_kelas')->default(true);
                $table->boolean('send_guru_piket')->default(true);
                $table->string('status', 50)->default('terkirim'); // 'terkirim', 'draft'
                $table->timestamps();
                $table->softDeletes();

                $table->index('id_siswa');
                $table->index('id_kelas');
                $table->index('id_siswa_dispen');
                $table->index('id_satpam');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapor_siswa');
    }
};
