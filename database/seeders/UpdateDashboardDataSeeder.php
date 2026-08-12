<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Ruangan;
use App\Models\Jadwal;
use App\Models\JurnalMengajar;
use Carbon\Carbon;

class UpdateDashboardDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan Ruangan Ada dengan jenis_ruangan valid ('Kelas Biasa', 'Lab', 'Ruang Praktik', 'Lainnya')
        $ruangan = Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Lab. RPL 1'],
            ['jenis_ruangan' => 'Lab']
        );

        $ruangan2 = Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Ruang Teori X-1'],
            ['jenis_ruangan' => 'Kelas Biasa']
        );

        // 2. Ambil List Guru, Kelas, Mapel
        $gurus   = Guru::all();
        $kelases = Kelas::all();
        $mapels  = Mapel::all();

        if ($gurus->isEmpty() || $kelases->isEmpty() || $mapels->isEmpty()) {
            return;
        }

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // 3. Buat / Update Jadwal Pelajaran untuk Setiap Hari Kerja (Senin - Jumat)
        foreach ($hariList as $hIdx => $hari) {
            foreach ($kelases->take(8) as $kIdx => $kls) {
                $guru  = $gurus[($hIdx + $kIdx) % $gurus->count()];
                $mapel = $mapels[($hIdx * 2 + $kIdx) % $mapels->count()];
                $ruang = ($kIdx % 2 == 0) ? $ruangan : $ruangan2;

                Jadwal::updateOrCreate(
                    [
                        'id_kelas' => $kls->id_kelas,
                        'hari'     => $hari,
                        'id_jam_mulai' => ($kIdx % 4) + 1,
                    ],
                    [
                        'id_guru'        => $guru->id_guru,
                        'id_mapel'       => $mapel->id_mapel,
                        'id_ruangan'     => $ruang->id_ruangan,
                        'id_jam_selesai' => (($kIdx % 4) + 1) + 2,
                    ]
                );
            }
        }

        // 4. Buat Jurnal Mengajar untuk 7 Hari Terakhir hingga Hari Ini (2026-08-09 / dynamic Carbon::today())
        $today = Carbon::today();
        $sampleTopics = [
            'Pengenalan konsep Algoritma dan Pemrograman Dasar.',
            'Praktikum Query Database MySQL & Modifikasi Schema Table.',
            'Pembahasan materi Keamanan Jaringan dan Firewall Cisco.',
            'Uji Kompetensi Dasar & Penilaian Harian Teori.',
            'Diskusi Kelompok Pengembangan Aplikasi Web Framework Laravel.',
            'Praktikum Desain Antarmuka Pengguna (UI/UX) dengan Figma.',
            'Studi Kasus Analisis Bisnis dan Manajemen Pemasaran Digital.',
        ];

        $allJadwals = Jadwal::all();

        for ($i = 6; $i >= 0; $i--) {
            $targetDate = $today->copy()->subDays($i);
            $dateStr = $targetDate->toDateString();
            $dayOfWeekIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$targetDate->dayOfWeek];

            $dayJadwals = Jadwal::where('hari', $dayOfWeekIndo)->get();

            if ($dayJadwals->count() > 0) {
                foreach ($dayJadwals as $jIdx => $jdw) {
                    // Isi sekitar 75% jurnal agar ada variasi sudah mengisi vs belum mengisi
                    if ($jIdx % 4 != 3) {
                        JurnalMengajar::updateOrCreate(
                            [
                                'id_jadwal' => $jdw->id_jadwal,
                                'tanggal'   => $dateStr,
                            ],
                            [
                                'materi'                => $sampleTopics[($i + $jIdx) % count($sampleTopics)],
                                'status_kehadiran_guru' => ($jIdx % 5 == 0) ? 'Izin' : 'Hadir',
                                'catatan'               => 'Pembelajaran terlaksana dengan tertib dan lancar.',
                            ]
                        );
                    }
                }
            } else {
                // Untuk hari libur (Minggu/Sabtu), buat 2-4 jurnal kegiatan ekstra/bimbingan
                $sampleDayJadwals = $allJadwals->take(4);
                foreach ($sampleDayJadwals as $jIdx => $jdw) {
                    if ($jIdx % 2 == 0) {
                        JurnalMengajar::updateOrCreate(
                            [
                                'id_jadwal' => $jdw->id_jadwal,
                                'tanggal'   => $dateStr,
                            ],
                            [
                                'materi'                => 'Pengayaan & Bimbingan Ekstrakurikuler.',
                                'status_kehadiran_guru' => 'Hadir',
                                'catatan'               => 'Sesi bimbingan tambahan.',
                            ]
                        );
                    }
                }
            }
        }
    }
}
