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
        if (Schema::hasTable('guru_izin') && !Schema::hasColumn('guru_izin', 'durasi')) {
            Schema::table('guru_izin', function (Blueprint $table) {
                $table->string('durasi', 100)->nullable()->after('tanggal_selesai');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('guru_izin') && Schema::hasColumn('guru_izin', 'durasi')) {
            Schema::table('guru_izin', function (Blueprint $table) {
                $table->dropColumn('durasi');
            });
        }
    }
};
