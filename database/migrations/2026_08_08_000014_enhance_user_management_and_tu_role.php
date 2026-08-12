<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ensure enum role users contains 'tu', 'admin', 'guru', 'piket', 'wali_kelas'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('tu','admin','guru','piket','wali_kelas') NOT NULL DEFAULT 'guru'");

        // 2. Ensure status_verifikasi contains 'pending', 'verified', 'rejected'
        DB::statement("ALTER TABLE users MODIFY COLUMN status_verifikasi ENUM('pending','verified','rejected') NOT NULL DEFAULT 'verified'");

        // 3. Update any old role values if exist
        DB::statement("UPDATE users SET role = 'guru' WHERE role = 'guru_mapel'");
        DB::statement("UPDATE users SET role = 'piket' WHERE role = 'guru_piket'");

        // 4. Ensure admin/tu accounts are verified
        DB::statement("UPDATE users SET status_verifikasi = 'verified' WHERE role IN ('tu', 'admin')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op or revert enum
    }
};
