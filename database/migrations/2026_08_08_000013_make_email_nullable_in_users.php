<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Jadikan email nullable karena login menggunakan NIP, bukan email.
     */
    public function up(): void
    {
        // Hapus unique constraint email dulu sebelum ubah ke nullable
        Schema::table('users', function (Blueprint $table) {
            // Drop unique index jika ada
        });

        // Jadikan email nullable, tapi tetap unique (allow multiple null)
        DB::statement('ALTER TABLE users MODIFY COLUMN email VARCHAR(255) NULL DEFAULT NULL');

        // Pastikan nip NOT NULL dan unik (primary login identifier)
        DB::statement('ALTER TABLE users MODIFY COLUMN nip CHAR(18) NOT NULL');

        // Hapus akun tanpa NIP (Test User, dll)
        DB::table('users')->whereNull('nip')->orWhere('nip', '')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE users MODIFY COLUMN email VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE users MODIFY COLUMN nip CHAR(18) NULL DEFAULT NULL');
    }
};
