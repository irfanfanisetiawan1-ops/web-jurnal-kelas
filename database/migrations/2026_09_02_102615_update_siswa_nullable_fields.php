<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * - kota_lahir: nullable (opsional)
     * - alamat_lengkap: nullable (opsional)
     * - nis: panjang minimum tetap 3 (dicek di aplikasi), kolom tetap string
     * - Migrasi data lama: ubah '-' menjadi NULL di kota_lahir dan alamat_lengkap
     */
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->string('kota_lahir', 100)->nullable()->change();
            $table->text('alamat_lengkap')->nullable()->change();
        });

        // Bersihkan nilai '-' placeholder lama menjadi NULL
        DB::table('siswa')->where('kota_lahir', '-')->update(['kota_lahir' => null]);
        DB::table('siswa')->where('alamat_lengkap', '-')->update(['alamat_lengkap' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan NULL menjadi '-' untuk kompatibilitas jika perlu rollback
        DB::table('siswa')->whereNull('kota_lahir')->update(['kota_lahir' => '-']);
        DB::table('siswa')->whereNull('alamat_lengkap')->update(['alamat_lengkap' => '-']);

        Schema::table('siswa', function (Blueprint $table) {
            $table->string('kota_lahir', 100)->nullable(false)->default('')->change();
            $table->text('alamat_lengkap')->nullable(false)->default('')->change();
        });
    }
};
