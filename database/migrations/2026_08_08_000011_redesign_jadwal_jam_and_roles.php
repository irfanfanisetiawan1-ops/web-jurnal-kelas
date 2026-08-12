<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * - Update jadwal: jam_mulai & jam_selesai menjadi integer (nomor jam ke-)
     * - Update users role: tambah 'tu', 'piket', ubah enum
     * - Pastikan kelas punya wali_kelas via id_guru (bukan NIP)
     */
    public function up(): void
    {
        // 1. Ubah & rename jam_mulai dan jam_selesai di jadwal jika masih menggunakan nama lama
        if (Schema::hasColumn('jadwal', 'jam_mulai')) {
            DB::statement('ALTER TABLE jadwal MODIFY jam_mulai BIGINT UNSIGNED NULL');
            Schema::table('jadwal', function (Blueprint $table) {
                $table->renameColumn('jam_mulai', 'id_jam_mulai');
            });
        }

        if (Schema::hasColumn('jadwal', 'jam_selesai')) {
            DB::statement('ALTER TABLE jadwal MODIFY jam_selesai BIGINT UNSIGNED NULL');
            Schema::table('jadwal', function (Blueprint $table) {
                $table->renameColumn('jam_selesai', 'id_jam_selesai');
            });
        }

        // 3. Expand enum role users first to include all old & new values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('tu','admin','guru','piket','wali_kelas','guru_mapel','guru_piket') NOT NULL DEFAULT 'guru'");
        
        // Update existing data
        DB::statement("UPDATE users SET role = 'tu' WHERE role = 'admin'");
        DB::statement("UPDATE users SET role = 'guru' WHERE role = 'guru_mapel'");
        DB::statement("UPDATE users SET role = 'piket' WHERE role = 'guru_piket'");

        // Finalize enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('tu','admin','guru','piket','wali_kelas') NOT NULL DEFAULT 'guru'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal', 'id_jam_mulai')) {
                $table->renameColumn('id_jam_mulai', 'jam_mulai');
            }
            if (Schema::hasColumn('jadwal', 'id_jam_selesai')) {
                $table->renameColumn('id_jam_selesai', 'jam_selesai');
            }
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','guru_mapel','guru_piket','wali_kelas') NOT NULL DEFAULT 'guru_mapel'");
    }
};
