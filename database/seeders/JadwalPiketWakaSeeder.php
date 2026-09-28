<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalPiketWaka;
use App\Models\Guru;
use App\Models\User;
use Carbon\Carbon;

class JadwalPiketWakaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Peta hari kerja untuk Piket Waka berdasarkan PDF Jadwal Piket September 2026:
        // Senin: Setiyo Winarko, S.Pd
        // Selasa: Niken Hari Pratiwi, S.Psi., M.Pd
        // Rabu: Hardini Indahing Budi, S.E., M.Pd.
        // Kamis: Hendro Suwignyo, ST
        // Jumat: Fajar Luthfianto, S.Pd

        $wakaMap = [
            'Monday' => [
                'nama' => 'Setiyo Winarko',
            ],
            'Tuesday' => [
                'nama' => 'Niken Hari Pratiwi',
            ],
            'Wednesday' => [
                'nama' => 'Hardini Indahing Budi',
            ],
            'Thursday' => [
                'nama' => 'Hendro Suwignyo',
            ],
            'Friday' => [
                'nama' => 'Fajar Luthfianto',
            ],
        ];

        // Resolve guru & user for each
        $resolvedMap = [];
        foreach ($wakaMap as $dayName => $info) {
            $guru = Guru::where('nama_guru', 'like', '%' . $info['nama'] . '%')->first();
            $user = null;
            if ($guru) {
                $user = User::where('id_guru', $guru->id_guru)
                    ->orWhere(function ($q) use ($guru) {
                        if (!empty($guru->nip)) {
                            $q->where('nip', $guru->nip);
                        }
                    })
                    ->orWhere('name', 'like', '%' . $info['nama'] . '%')
                    ->first();
            } else {
                $user = User::where('name', 'like', '%' . $info['nama'] . '%')->first();
            }

            $resolvedMap[$dayName] = [
                'id_guru' => $guru ? $guru->id_guru : null,
                'id_user' => $user ? $user->id : null,
                'nama_guru' => $guru ? $guru->nama_guru : ($user ? $user->name : $info['nama']),
            ];
        }

        $namaHariIndo = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        $year = 2026;
        $month = 9;
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day);
            $dayNameEn = $date->format('l');
            $dayNameId = $namaHariIndo[$dayNameEn] ?? $dayNameEn;

            // Hanya Senin - Jumat (Hari kerja sekolah)
            if (isset($resolvedMap[$dayNameEn])) {
                $teacherInfo = $resolvedMap[$dayNameEn];
                JadwalPiketWaka::updateOrCreate(
                    ['tanggal' => $date->toDateString()],
                    [
                        'hari'    => $dayNameId,
                        'bulan'   => $month,
                        'tahun'   => $year,
                        'id_guru' => $teacherInfo['id_guru'],
                        'id_user' => $teacherInfo['id_user'],
                        'catatan' => 'Jadwal Reguler Piket Waka ' . $dayNameId,
                    ]
                );
            }
        }
    }
}
