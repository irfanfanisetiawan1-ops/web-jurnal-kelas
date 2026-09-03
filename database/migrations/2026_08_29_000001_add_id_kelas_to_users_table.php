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
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'id_kelas')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('id_kelas')->nullable()->after('id_siswa');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'id_kelas')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('id_kelas');
            });
        }
    }
};
