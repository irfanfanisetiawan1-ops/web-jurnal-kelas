<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update ENUM role di tabel users untuk menyertakan 'waka_sdm'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('tu','admin','guru','wali_kelas','piket','waka','waka_sdm','satpam','kepala_sekolah','orang_tua') NOT NULL DEFAULT 'guru'");

        // 2. Buat / pastikan akun Waka SDM ada di tabel users
        $wakaSdmNip = '198204102009021003';
        $existing = DB::table('users')->where('nip', $wakaSdmNip)->orWhere('username', 'waka.sdm')->first();

        if (!$existing) {
            DB::table('users')->insert([
                'name'              => 'Drs. H. Bambang Hariyanto, M.Pd',
                'username'          => 'waka.sdm',
                'nip'               => $wakaSdmNip,
                'email'             => 'wakasdm@smea.sch.id',
                'no_hp'             => '081234567899',
                'jenis_kelamin'     => 'L',
                'role'              => 'waka_sdm',
                'status_verifikasi' => 'verified',
                'password'          => Hash::make('sdm123'),
                'password_plain'    => 'sdm123',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('role', 'waka_sdm')->delete();
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('tu','admin','guru','wali_kelas','piket','waka','satpam','kepala_sekolah','orang_tua') NOT NULL DEFAULT 'guru'");
    }
};
