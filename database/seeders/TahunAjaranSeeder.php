<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;
use App\Models\Setting;
use Carbon\Carbon;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        if (TahunAjaran::withTrashed()->count() === 0) {
            $now = Carbon::now();

            // 1. 2026/2027 Ganjil (Aktif)
            TahunAjaran::create([
                'tahun_ajaran'    => '2026/2027',
                'semester'        => 'Ganjil',
                'periode_label'   => 'Juli - Desember 2026',
                'tanggal_mulai'   => '2026-07-15',
                'tanggal_selesai' => '2026-12-20',
                'is_aktif'        => true,
                'buka_jurnal'     => true,
                'keterangan'      => 'Tahun Ajaran Aktif Berjalan SMKN 1 Boyolangu.',
                'created_at'      => $now,
                'updated_at'      => $now,
            ]);

            // 2. 2025/2026 Genap
            TahunAjaran::create([
                'tahun_ajaran'    => '2025/2026',
                'semester'        => 'Genap',
                'periode_label'   => 'Januari - Juni 2026',
                'tanggal_mulai'   => '2026-01-05',
                'tanggal_selesai' => '2026-06-25',
                'is_aktif'        => false,
                'buka_jurnal'     => false,
                'keterangan'      => 'Arsip semester genap tahun ajaran lalu.',
                'created_at'      => $now->copy()->subMonths(6),
                'updated_at'      => $now->copy()->subMonths(6),
            ]);

            // 3. 2025/2026 Ganjil
            TahunAjaran::create([
                'tahun_ajaran'    => '2025/2026',
                'semester'        => 'Ganjil',
                'periode_label'   => 'Juli - Desember 2025',
                'tanggal_mulai'   => '2025-07-14',
                'tanggal_selesai' => '2025-12-19',
                'is_aktif'        => false,
                'buka_jurnal'     => false,
                'keterangan'      => 'Arsip semester ganjil tahun ajaran lalu.',
                'created_at'      => $now->copy()->subYear(),
                'updated_at'      => $now->copy()->subYear(),
            ]);

            // 4. 2024/2025 Genap
            TahunAjaran::create([
                'tahun_ajaran'    => '2024/2025',
                'semester'        => 'Genap',
                'periode_label'   => 'Januari - Juni 2025',
                'tanggal_mulai'   => '2025-01-06',
                'tanggal_selesai' => '2025-06-20',
                'is_aktif'        => false,
                'buka_jurnal'     => false,
                'keterangan'      => 'Arsip tahun ajaran 2024/2025.',
                'created_at'      => $now->copy()->subMonths(18),
                'updated_at'      => $now->copy()->subMonths(18),
            ]);

            // 5. 2024/2025 Ganjil
            TahunAjaran::create([
                'tahun_ajaran'    => '2024/2025',
                'semester'        => 'Ganjil',
                'periode_label'   => 'Juli - Desember 2024',
                'tanggal_mulai'   => '2024-07-15',
                'tanggal_selesai' => '2024-12-20',
                'is_aktif'        => false,
                'buka_jurnal'     => false,
                'keterangan'      => 'Arsip tahun ajaran 2024/2025 ganjil.',
                'created_at'      => $now->copy()->subYears(2),
                'updated_at'      => $now->copy()->subYears(2),
            ]);

            // 6. Data Sampah: 2023/2024 Genap
            $t1 = TahunAjaran::create([
                'tahun_ajaran'    => '2023/2024',
                'semester'        => 'Genap',
                'periode_label'   => 'Januari - Juni 2024',
                'tanggal_mulai'   => '2024-01-08',
                'tanggal_selesai' => '2024-06-21',
                'is_aktif'        => false,
                'buka_jurnal'     => false,
                'keterangan'      => 'Data arsip lama dipindahkan ke sampah.',
                'created_at'      => $now->copy()->subMonths(30),
                'updated_at'      => $now->copy()->subMonths(30),
            ]);
            $t1->delete();

            // 7. Data Sampah: 2023/2024 Ganjil
            $t2 = TahunAjaran::create([
                'tahun_ajaran'    => '2023/2024',
                'semester'        => 'Ganjil',
                'periode_label'   => 'Juli - Desember 2023',
                'tanggal_mulai'   => '2023-07-17',
                'tanggal_selesai' => '2023-12-22',
                'is_aktif'        => false,
                'buka_jurnal'     => false,
                'keterangan'      => 'Data arsip lama dipindahkan ke sampah.',
                'created_at'      => $now->copy()->subYears(3),
                'updated_at'      => $now->copy()->subYears(3),
            ]);
            $t2->delete();

            // Update settings table
            Setting::setByKey('tahun_ajaran_aktif', '2026/2027', 'academic', 'Tahun Ajaran Aktif');
            Setting::setByKey('semester_aktif', 'Ganjil', 'academic', 'Semester Aktif');
        }
    }
}