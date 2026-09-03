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
        if (Schema::hasTable('siswa') && !Schema::hasColumn('siswa', 'is_alumni')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->tinyInteger('is_alumni')->default(0)->after('alamat_lengkap');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('siswa') && Schema::hasColumn('siswa', 'is_alumni')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->dropColumn('is_alumni');
            });
        }
    }
};
