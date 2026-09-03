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
            if (!Schema::hasColumn('siswa_dispen', 'foto_surat_dispen')) {
                $table->string('foto_surat_dispen', 255)->nullable()->after('alasan');
            }
            if (!Schema::hasColumn('siswa_dispen', 'foto_kartu_identitas')) {
                $table->string('foto_kartu_identitas', 255)->nullable()->after('foto_surat_dispen');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa_dispen', function (Blueprint $table) {
            if (Schema::hasColumn('siswa_dispen', 'foto_surat_dispen')) {
                $table->dropColumn('foto_surat_dispen');
            }
            if (Schema::hasColumn('siswa_dispen', 'foto_kartu_identitas')) {
                $table->dropColumn('foto_kartu_identitas');
            }
        });
    }
};
