<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa_dispen', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa_dispen', 'nip_guru_piket')) {
                $table->string('nip_guru_piket', 50)->nullable()->after('nama_guru_piket');
            }
            if (!Schema::hasColumn('siswa_dispen', 'tempat')) {
                $table->string('tempat', 255)->nullable()->after('alasan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswa_dispen', function (Blueprint $table) {
            if (Schema::hasColumn('siswa_dispen', 'nip_guru_piket')) {
                $table->dropColumn('nip_guru_piket');
            }
            if (Schema::hasColumn('siswa_dispen', 'tempat')) {
                $table->dropColumn('tempat');
            }
        });
    }
};
