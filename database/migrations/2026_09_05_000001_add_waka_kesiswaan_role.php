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
        // 1. Perbarui ENUM role di tabel users untuk menyertakan 'waka_kesiswaan'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('tu','admin','guru','wali_kelas','piket','waka','waka_kesiswaan','waka_sdm','satpam','kepala_sekolah','orang_tua') NOT NULL DEFAULT 'guru'");

        // 2. Perbarui akun Waka Kesiswaan: Fajar Luthfianto, S.Pd (NIP: 197808102023211005)
        $nipFajar = '197808102023211005';
        $userFajar = DB::table('users')->where('nip', $nipFajar)->first();

        if ($userFajar) {
            DB::table('users')->where('id', $userFajar->id)->update([
                'name'              => 'Fajar Luthfianto, S.Pd',
                'role'              => 'waka_kesiswaan',
                'password'          => Hash::make('kesiswaan123'),
                'password_plain'    => 'kesiswaan123',
                'status_verifikasi' => 'verified',
                'updated_at'        => now(),
            ]);
            $fajarUserId = $userFajar->id;
        } else {
            $fajarUserId = DB::table('users')->insertGetId([
                'name'              => 'Fajar Luthfianto, S.Pd',
                'username'          => 'waka.kesiswaan',
                'nip'               => $nipFajar,
                'email'             => 'wakakesiswaan@smea.sch.id',
                'role'              => 'waka_kesiswaan',
                'password'          => Hash::make('kesiswaan123'),
                'password_plain'    => 'kesiswaan123',
                'status_verifikasi' => 'verified',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // 3. Perbarui akun Waka Kurikulum: Hardini Indahing Budi, S.E., M.Pd. (NIP: 198208222014072002)
        $nipHardini = '198208222014072002';
        $userHardini = DB::table('users')->where('nip', $nipHardini)->first();

        if ($userHardini) {
            DB::table('users')->where('id', $userHardini->id)->update([
                'name'              => 'Hardini Indahing Budi, S.E., M.Pd.',
                'role'              => 'waka',
                'password'          => Hash::make('kurikulum123'),
                'password_plain'    => 'kurikulum123',
                'status_verifikasi' => 'verified',
                'updated_at'        => now(),
            ]);
        } else {
            DB::table('users')->insert([
                'name'              => 'Hardini Indahing Budi, S.E., M.Pd.',
                'username'          => 'waka.kurikulum',
                'nip'               => $nipHardini,
                'email'             => 'wakakurikulum@smea.sch.id',
                'role'              => 'waka',
                'password'          => Hash::make('kurikulum123'),
                'password_plain'    => 'kurikulum123',
                'status_verifikasi' => 'verified',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // 4. Alihkan referensi dispensasi siswa dari user lama (ID 26 dummy Fajar) ke akun Waka Kesiswaan (Fajar Luthfianto)
        DB::table('siswa_dispen')->where('id_user_waka', 26)->update([
            'id_user_waka' => $fajarUserId,
            'nama_waka'    => 'Fajar Luthfianto, S.Pd',
            'nip_waka'     => $nipFajar,
        ]);

        // 5. Hapus akun placeholder dummy lama ID 26 jika ada
        DB::table('users')->where('id', 26)->where('nip', '198005052008011005')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('tu','admin','guru','wali_kelas','piket','waka','waka_sdm','satpam','kepala_sekolah','orang_tua') NOT NULL DEFAULT 'guru'");
    }
};
