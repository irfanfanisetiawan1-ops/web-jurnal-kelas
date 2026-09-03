<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────────────────────────────────
        // 1. TU / Admin Account
        // NIP: 198001012005011000 | Password: admin123
        // ─────────────────────────────────────────────────────────────────────
        User::updateOrCreate(
            ['nip' => '198001012005011000'],
            [
                'name'              => 'Administrator Utama (TU)',
                'username'          => 'admin',
                'email'             => 'admin@sekolah.sch.id',
                'password'          => Hash::make('admin123'),
                'role'              => 'tu',
                'status_verifikasi' => 'verified',
                'id_guru'           => null,
            ]
        );

        // ─────────────────────────────────────────────────────────────────────
        // 2. Semua Guru dari tabel guru → buat/update akun user
        // ─────────────────────────────────────────────────────────────────────
        $guruAccounts = [
            [
                'nip'       => '198501012010011001',
                'nama'      => 'Umi Kulsum, S.Pd',
                'username'  => 'guru.umi',
                'email'     => 'umi@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '198702022011022002',
                'nama'      => 'Rina Marlina, S.Pd',
                'username'  => 'guru.rina',
                'email'     => 'rina@sekolah.sch.id',
                'role'      => 'wali_kelas',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199003032015031003',
                'nama'      => 'Petugas Piket',
                'username'  => 'piket',
                'email'     => 'piket@sekolah.sch.id',
                'role'      => 'piket',
                'password'  => 'piket123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199101012016012001',
                'nama'      => "Rifkotin Na'imah, S.Pd",
                'username'  => 'guru.rifkotin',
                'email'     => '199101012016012001@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199101022016012002',
                'nama'      => 'Mufatiroh, S.Ag',
                'username'  => 'guru.mufatiroh',
                'email'     => '199101022016012002@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199101032016012003',
                'nama'      => 'Ruly Dwi Setyaningrum, S.Kom',
                'username'  => 'guru.ruly',
                'email'     => '199101032016012003@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199101042016011004',
                'nama'      => 'Ilham Sungeidi, S.Pd',
                'username'  => 'guru.ilham',
                'email'     => '199101042016011004@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199101052016012005',
                'nama'      => 'Siswanti Purwaningsih, S.T., M.Pd',
                'username'  => 'guru.siswanti',
                'email'     => '199101052016012005@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199101062016011006',
                'nama'      => 'Eko Saputro, S.Pd',
                'username'  => 'guru.eko',
                'email'     => '199101062016011006@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199101072016012007',
                'nama'      => 'Dian Mawarti, S.Pd',
                'username'  => 'guru.dian',
                'email'     => '199101072016012007@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199101082016012008',
                'nama'      => 'Ratih Dian Irawati, SE',
                'username'  => 'guru.ratih',
                'email'     => '199101082016012008@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199101092016011009',
                'nama'      => 'Zainul Arifin, S.Pd',
                'username'  => 'guru.zainul',
                'email'     => '199101092016011009@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199101102016012010',
                'nama'      => 'Sri Subekti, S.Pd',
                'username'  => 'guru.sri',
                'email'     => '199101102016012010@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
            ],
            [
                'nip'       => '199101112016012011',
                'nama'      => 'Khuriyatul Kamila, S.Si',
                'username'  => 'guru.khuriyatul',
                'email'     => '199101112016012011@sekolah.sch.id',
                'role'      => 'guru',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
                'status'    => 'verified',
            ],
            [
                'nip'       => '123456781234567890',
                'nama'      => 'Sanim, S.Pd',
                'username'  => 'guru.sanim27',
                'email'     => 'sanim@sekolah.sch.id',
                'role'      => 'piket',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
                'status'    => 'pending',
            ],
            [
                'nip'       => '098765432112345678',
                'nama'      => 'Agung, S.Pd',
                'username'  => 'guru.agung12',
                'email'     => 'agung@sekolah.sch.id',
                'role'      => 'wali_kelas',
                'password'  => 'password123',
                'no_hp'     => '081234567890',
                'status'    => 'pending',
            ],
        ];

        foreach ($guruAccounts as $data) {
            // Pastikan ada di tabel guru
            $guru = Guru::updateOrCreate(
                ['nip' => $data['nip']],
                [
                    'nama_guru' => $data['nama'],
                    'no_hp'     => $data['no_hp'] ?? null,
                ]
            );

            // Buat/update akun user
            User::updateOrCreate(
                ['nip' => $data['nip']],
                [
                    'name'              => $data['nama'],
                    'username'          => $data['username'],
                    'email'             => $data['email'],
                    'password'          => Hash::make($data['password']),
                    'password_plain'    => $data['password'],
                    'role'              => $data['role'],
                    'status_verifikasi' => $data['status'] ?? 'verified',
                    'id_guru'           => $guru->id_guru,
                    'deleted_at'        => null,
                ]
            );
        }

        User::syncWaliKelasRoles();

        $this->command->info('✅ Seeder berhasil: ' . (count($guruAccounts) + 1) . ' akun dibuat/diperbarui.');
        $this->command->line('');
        $this->command->line('📋 Daftar akun login:');
        $this->command->line('   NIP: 198001012005011000  | Role: TU/Admin   | Password: admin123');
        $this->command->line('   NIP: 198501012010011001  | Role: Guru       | Password: password123');
        $this->command->line('   NIP: 198702022011022002  | Role: Wali Kelas | Password: password123');
        $this->command->line('   NIP: 199003032015031003  | Role: Piket      | Password: piket123');
        $this->command->line('   (+ 11 guru lainnya dengan password: password123)');
    }
}
