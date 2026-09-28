<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalGuruPiket;
use Carbon\Carbon;

class JadwalPiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 10 Siklus Rotasi Jadwal Guru Piket SMK Negeri 1 Boyolangu (8 guru per hari)
        $cycleGuruIds = [
            1 => [111, 123, 108, 64, 58, 106, 75, 120],  // Sulistyowati, Wiwik, Sri Kusumastuti, Lilik, Kasmi, Siti Munawaroh, Niken Dewi, Widodo
            2 => [117, 88, 72, 37, 103, 101, 26, 43],    // Tutut, Rika Okta, Mufatiroh, Elyana, Siswanti, Shinta, Dhuana, Erwan
            3 => [126, 125, 5, 25, 90, 66, 116, 56],     // Yuni, Yuli, Agus Pramono, Danang, Risqi Nur, Luluk, Tuhu, Istiana
            4 => [14, 112, 55, 57, 30, 11, 48, 2],       // Arif, Sunarti, Isti Mufadah, Joko Priyanto, Hanik, Andri, Fitria Renytasari, Agung Yulianto
            5 => [99, 68, 121, 115, 81, 87, 31, 67],     // Septiani, Martiin, Winarsih, Titin, Nurul Azizah, Rifkotin, Susakti, Lutfia
            6 => [89, 28, 119, 19, 118, 93, 109, 6],     // Rindang, Diana, Veronica, Ayu Puspitorini, Umi Kulsum, Ruly Dwi, Sri Rahayu, Agustina
            7 => [29, 86, 79, 146, 84, 85, 105, 35],     // Anik, Retno, Nur Eko, Sa'ad, Purwati, Ratih Dian, Siti Maisaroh, Dyah Esti
            8 => [107, 42, 17, 140, 77, 40, 61, 27],     // Siti Umiharsih, Erna, Astra Bella, Endang Ary, Ninik, Endik, Komariyah, Dian Mawarti
            9 => [124, 114, 83, 62, 138, 18, 78, 80],    // Yani, Titik, Pipit, Kurnila, Basuki, Atih Wilupi, Nishfu, Nur Nastutisari
            10 => [104, 82, 20, 34, 38, 33, 144, 32],    // Siti Khoiriyah, Peni, Badrus, Dwi Rini, Elysa, Dwi Nova, Mas'an, Dwi Kuswanto
        ];

        // Mapping 22 Hari Kerja September 2026 sesuai dokumen resmi
        $septemberMap = [
            '2026-09-01' => 1,
            '2026-09-02' => 2,
            '2026-09-03' => 3,
            '2026-09-04' => 4,
            '2026-09-07' => 5,
            '2026-09-08' => 6,
            '2026-09-09' => 7,
            '2026-09-10' => 8,
            '2026-09-11' => 9,
            '2026-09-14' => 10,
            '2026-09-15' => 1,
            '2026-09-16' => 2,
            '2026-09-17' => 3,
            '2026-09-18' => 4,
            '2026-09-21' => 5,
            '2026-09-22' => 6,
            '2026-09-23' => 7,
            '2026-09-24' => 8,
            '2026-09-25' => 9,
            '2026-09-28' => 10,
            '2026-09-29' => 1,
            '2026-09-30' => 2,
        ];

        $mapHariIndo = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        foreach ($septemberMap as $tglStr => $cNum) {
            $cDate = Carbon::parse($tglStr);
            $hari = $mapHariIndo[$cDate->format('l')] ?? 'Senin';
            $bulan = (int)$cDate->format('n');
            $tahun = (int)$cDate->format('Y');

            $guruIds = $cycleGuruIds[$cNum] ?? [];

            for ($slot = 1; $slot <= 8; $slot++) {
                $idGuru = $guruIds[$slot - 1] ?? null;

                JadwalGuruPiket::updateOrCreate(
                    [
                        'tanggal' => $tglStr,
                        'slot_ke' => $slot,
                    ],
                    [
                        'hari'    => $hari,
                        'bulan'   => $bulan,
                        'tahun'   => $tahun,
                        'id_guru' => $idGuru,
                    ]
                );
            }
        }
    }
}
