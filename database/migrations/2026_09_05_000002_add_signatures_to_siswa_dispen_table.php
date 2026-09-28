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
        Schema::table('siswa_dispen', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa_dispen', 'ttd_siswa')) {
                $table->longText('ttd_siswa')->nullable()->after('foto_kartu_identitas');
            }
            if (!Schema::hasColumn('siswa_dispen', 'ttd_guru_piket')) {
                $table->longText('ttd_guru_piket')->nullable()->after('ttd_siswa');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa_dispen', function (Blueprint $table) {
            if (Schema::hasColumn('siswa_dispen', 'ttd_siswa')) {
                $table->dropColumn('ttd_siswa');
            }
            if (Schema::hasColumn('siswa_dispen', 'ttd_guru_piket')) {
                $table->dropColumn('ttd_guru_piket');
            }
        });
    }
};
