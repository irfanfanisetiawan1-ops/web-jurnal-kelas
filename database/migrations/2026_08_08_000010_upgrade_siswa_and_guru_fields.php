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
        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'nis')) {
                $table->string('nis', 20)->nullable()->after('id_siswa');
            }
            if (!Schema::hasColumn('siswa', 'kota_lahir')) {
                $table->string('kota_lahir', 100)->nullable()->after('id_kelas');
            }
            if (!Schema::hasColumn('siswa', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('kota_lahir');
            }
            if (!Schema::hasColumn('siswa', 'alamat_lengkap')) {
                $table->text('alamat_lengkap')->nullable()->after('tanggal_lahir');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['nis', 'kota_lahir', 'tanggal_lahir', 'alamat_lengkap']);
        });
    }
};
