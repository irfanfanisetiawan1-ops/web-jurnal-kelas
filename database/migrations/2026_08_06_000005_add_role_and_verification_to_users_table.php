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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'guru_mapel', 'guru_piket', 'wali_kelas'])->default('guru_mapel')->after('email');
            }
            if (!Schema::hasColumn('users', 'status_verifikasi')) {
                $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('verified')->after('role');
            }
            if (!Schema::hasColumn('users', 'id_guru')) {
                $table->integer('id_guru')->nullable()->after('status_verifikasi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'role', 'status_verifikasi', 'id_guru']);
        });
    }
};
