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
            if (!Schema::hasColumn('siswa_dispen', 'foto_siswa_live')) {
                $table->string('foto_siswa_live', 255)->nullable()->after('foto_kartu_identitas');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa_dispen', function (Blueprint $table) {
            if (Schema::hasColumn('siswa_dispen', 'foto_siswa_live')) {
                $table->dropColumn('foto_siswa_live');
            }
        });
    }
};
