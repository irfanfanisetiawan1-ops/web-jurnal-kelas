<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Ruangan;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\JurnalMengajar;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Guru dari Screenshot
        $gurusData = [
            ['nip' => '198501012010011001', 'nama' => 'Umi Kulsum, S.Pd'],
            ['nip' => '198702022011022002', 'nama' => 'Rina Marlina, S.Pd'],
            ['nip' => '199003032015031003', 'nama' => 'Petugas Piket'],
            ['nip' => '199101012016012001', 'nama' => 'Rifkotin Na\'imah, S.Pd'],
            ['nip' => '199101022016012002', 'nama' => 'Mufatiroh, S.Ag'],
            ['nip' => '199101032016012003', 'nama' => 'Ruly Dwi Setyaningrum, S.Kom'],
            ['nip' => '199101042016011004', 'nama' => 'Ilham Sungeidi, S.Pd'],
            ['nip' => '199101052016012005', 'nama' => 'Siswanti Purwaningsih, S.T., M.Pd'],
            ['nip' => '199101062016011006', 'nama' => 'Eko Saputro, S.Pd'],
            ['nip' => '199101072016012007', 'nama' => 'Dian Mawarti, S.Pd'],
            ['nip' => '199101082016012008', 'nama' => 'Ratih Dian Irawati, SE'],
            ['nip' => '199101092016011009', 'nama' => 'Zainul Arifin, S.Pd'],
            ['nip' => '199101102016012010', 'nama' => 'Sri Subekti, S.Pd'],
            ['nip' => '199101112016012011', 'nama' => 'Khuriyatul Kamila, S.Si'],
        ];

        $gurus = [];
        foreach ($gurusData as $g) {
            $gurus[$g['nama']] = Guru::updateOrCreate(
                ['nip' => $g['nip']],
                ['nama_guru' => $g['nama'], 'no_hp' => '081234567890']
            );
        }

        // 2. Data Kelas & Wali Kelas
        $kelasList = [
            'XI RPL 1' => '198501012010011001', // Umi Kulsum
            'X TKI 1'  => null,
            'X TKI 2'  => null,
            'X RPL 1'  => null,
            'X RPL 2'  => null,
            'X TKJ 1'  => null,
            'X TKJ 2'  => null,
            'X BD 1'   => null,
            'X BD 2'   => null,
            'X BD 3'   => null,
            'X MP 1'   => null,
            'X MP 2'   => null,
            'X MP 3'   => null,
            'X AK 1'   => null,
            'X ULW'    => null,
        ];

        $kelases = [];
        foreach ($kelasList as $namaKls => $waliNip) {
            $kelases[$namaKls] = Kelas::updateOrCreate(
                ['nama_kelas' => $namaKls],
                ['wali_kelas' => $waliNip, 'jumlah_siswa' => 30]
            );
        }

        // 3. Data Mapel
        $mapelList = [
            'Dasar TKI',
            'Pendidikan Agama Islam dan Budi Pekerti',
            'Dasar PPLG',
            'Bahasa Indonesia',
            'PJOK',
            'Dasar TJKT',
            'Informatika',
            'BK',
            'Dasar PM',
            'IPAS',
            'Pendidikan Pancasila',
            'Konsentrasi RPL',
            'Koding dan Kecerdasan Artifisial',
        ];

        $mapels = [];
        foreach ($mapelList as $idx => $namaMpl) {
            $mapels[$namaMpl] = Mapel::updateOrCreate(
                ['nama_mapel' => $namaMpl],
                ['kode_mapel' => 'MPL-' . sprintf('%02d', $idx + 1)]
            );
        }

        // 4. Data Ruangan
        $ruangan = Ruangan::updateOrCreate(
            ['nama_ruangan' => 'Lab. AK ATAS'],
            ['jenis_ruangan' => 'Lab']
        );

        // 5. Data Siswa untuk XI RPL 1
        $siswaList = ['Ahmad Fauzi', 'Dewi Lestari', 'Rizky Pratama', 'Irfan Fani Setiawan'];
        foreach ($siswaList as $idx => $namaSwa) {
            Siswa::updateOrCreate(
                ['nisn' => '20260' . ($idx + 1)],
                ['nama_siswa' => $namaSwa, 'id_kelas' => $kelases['XI RPL 1']->id_kelas]
            );
        }

        // 6. Data Jadwal Mengajar Hari Ini (Jumat) - Sesuai Screenshot 4
        $schedulesData = [
            ['kls' => 'X TKI 1', 'guru' => 'Rifkotin Na\'imah, S.Pd', 'mapel' => 'Dasar TKI', 'mulai' => 2, 'selesai' => 4],
            ['kls' => 'X TKI 2', 'guru' => 'Mufatiroh, S.Ag', 'mapel' => 'Pendidikan Agama Islam dan Budi Pekerti', 'mulai' => 2, 'selesai' => 4],
            ['kls' => 'X RPL 1', 'guru' => 'Ruly Dwi Setyaningrum, S.Kom', 'mapel' => 'Dasar PPLG', 'mulai' => 2, 'selesai' => 5],
            ['kls' => 'X RPL 2', 'guru' => 'Umi Kulsum, S.Pd', 'mapel' => 'Bahasa Indonesia', 'mulai' => 2, 'selesai' => 3],
            ['kls' => 'X TKJ 1', 'guru' => 'Ilham Sungeidi, S.Pd', 'mapel' => 'PJOK', 'mulai' => 2, 'selesai' => 4],
            ['kls' => 'X TKJ 2', 'guru' => 'Siswanti Purwaningsih, S.T., M.Pd', 'mapel' => 'Dasar TJKT', 'mulai' => 2, 'selesai' => 5],
            ['kls' => 'X BD 1',  'guru' => 'Eko Saputro, S.Pd', 'mapel' => 'Informatika', 'mulai' => 2, 'selesai' => 5],
            ['kls' => 'X BD 2',  'guru' => 'Dian Mawarti, S.Pd', 'mapel' => 'BK', 'mulai' => 2, 'selesai' => 2],
            ['kls' => 'X BD 3',  'guru' => 'Ratih Dian Irawati, SE', 'mapel' => 'Dasar PM', 'mulai' => 2, 'selesai' => 5],
            ['kls' => 'X MP 1',  'guru' => 'Zainul Arifin, S.Pd', 'mapel' => 'PJOK', 'mulai' => 2, 'selesai' => 4],
            ['kls' => 'X MP 2',  'guru' => 'Sri Subekti, S.Pd', 'mapel' => 'IPAS', 'mulai' => 2, 'selesai' => 4],
            ['kls' => 'X MP 3',  'guru' => 'Khuriyatul Kamila, S.Si', 'mapel' => 'Pendidikan Pancasila', 'mulai' => 2, 'selesai' => 3],
        ];

        foreach ($schedulesData as $sd) {
            if (isset($kelases[$sd['kls']]) && isset($gurus[$sd['guru']]) && isset($mapels[$sd['mapel']])) {
                Jadwal::updateOrCreate(
                    [
                        'id_kelas' => $kelases[$sd['kls']]->id_kelas,
                        'id_guru'  => $gurus[$sd['guru']]->id_guru,
                        'hari'     => 'Jumat',
                    ],
                    [
                        'id_mapel'       => $mapels[$sd['mapel']]->id_mapel,
                        'id_ruangan'     => $ruangan->id_ruangan,
                        'id_jam_mulai'   => $sd['mulai'],
                        'id_jam_selesai' => $sd['selesai'],
                    ]
                );
            }
        }

        // 7. Schedule & Jurnal Umi Kulsum untuk XI RPL 1
        $jadwalUmi = Jadwal::updateOrCreate(
            [
                'id_kelas' => $kelases['XI RPL 1']->id_kelas,
                'id_guru'  => $gurus['Umi Kulsum, S.Pd']->id_guru,
                'hari'     => 'Jumat',
            ],
            [
                'id_mapel'       => $mapels['Konsentrasi RPL']->id_mapel,
                'id_ruangan'     => $ruangan->id_ruangan,
                'id_jam_mulai'   => 1,
                'id_jam_selesai' => 3,
            ]
        );

        JurnalMengajar::updateOrCreate(
            [
                'id_jadwal' => $jadwalUmi->id_jadwal,
                'tanggal'   => '2026-07-29',
            ],
            [
                'materi'                => 'Pengenalan konsep Object-Oriented Programming (OOP): class, object, attribute, dan method beserta implementasi sederhana menggunakan Java.',
                'status_kehadiran_guru' => 'Hadir',
                'catatan'               => 'Pembelajaran berjalan dengan sangat kondusif.',
            ]
        );
    }
}
