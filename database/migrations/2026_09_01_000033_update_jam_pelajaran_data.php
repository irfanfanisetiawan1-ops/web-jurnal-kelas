<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $newScheduleData = [
            [
                'id_jam' => 1,
                'jam_ke' => 'Jam Ke-1',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '07:40:00',
                'jam_mulai_jumat' => '07:00:00',
                'jam_selesai_jumat' => '07:30:00',
                'keterangan' => 'Upacara / Apel (Senin) | Pembiasaan (Jumat)',
            ],
            [
                'id_jam' => 2,
                'jam_ke' => 'Jam Ke-2',
                'jam_mulai' => '07:40:00',
                'jam_selesai' => '08:20:00',
                'jam_mulai_jumat' => '07:30:00',
                'jam_selesai_jumat' => '08:00:00',
                'keterangan' => 'Sesi Pembelajaran Pagi',
            ],
            [
                'id_jam' => 3,
                'jam_ke' => 'Jam Ke-3',
                'jam_mulai' => '08:20:00',
                'jam_selesai' => '09:00:00',
                'jam_mulai_jumat' => '08:00:00',
                'jam_selesai_jumat' => '08:30:00',
                'keterangan' => 'Sesi Pembelajaran Pagi',
            ],
            [
                'id_jam' => 4,
                'jam_ke' => 'Jam Ke-4',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '09:40:00',
                'jam_mulai_jumat' => '08:30:00',
                'jam_selesai_jumat' => '09:00:00',
                'keterangan' => 'Sesi Pembelajaran (Sebelum Istirahat 1 Senin-Kamis)',
            ],
            [
                'id_jam' => 5,
                'jam_ke' => 'Jam Ke-5',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '10:35:00',
                'jam_mulai_jumat' => '09:00:00',
                'jam_selesai_jumat' => '09:30:00',
                'keterangan' => 'Sesi Pembelajaran (Setelah Istirahat 1 Senin-Kamis / Sebelum Istirahat 1 Jumat)',
            ],
            [
                'id_jam' => 6,
                'jam_ke' => 'Jam Ke-6',
                'jam_mulai' => '10:35:00',
                'jam_selesai' => '11:10:00',
                'jam_mulai_jumat' => '09:50:00',
                'jam_selesai_jumat' => '10:20:00',
                'keterangan' => 'Sesi Pembelajaran Siang (Setelah Istirahat 1 Jumat)',
            ],
            [
                'id_jam' => 7,
                'jam_ke' => 'Jam Ke-7',
                'jam_mulai' => '11:10:00',
                'jam_selesai' => '11:45:00',
                'jam_mulai_jumat' => '10:20:00',
                'jam_selesai_jumat' => '10:50:00',
                'keterangan' => 'Sesi Pembelajaran Siang (Sebelum Istirahat 2 Senin-Kamis)',
            ],
            [
                'id_jam' => 8,
                'jam_ke' => 'Jam Ke-8',
                'jam_mulai' => '13:15:00',
                'jam_selesai' => '13:50:00',
                'jam_mulai_jumat' => '10:50:00',
                'jam_selesai_jumat' => '11:20:00',
                'keterangan' => 'Sesi Pembelajaran (Setelah ISHOMA Senin-Kamis / Sebelum Jumatan Jumat)',
            ],
            [
                'id_jam' => 9,
                'jam_ke' => 'Jam Ke-9',
                'jam_mulai' => '13:50:00',
                'jam_selesai' => '14:25:00',
                'jam_mulai_jumat' => '13:00:00',
                'jam_selesai_jumat' => '13:30:00',
                'keterangan' => 'Sesi Pembelajaran Sore (Setelah ISHOMA Jumat)',
            ],
            [
                'id_jam' => 10,
                'jam_ke' => 'Jam Ke-10',
                'jam_mulai' => '14:25:00',
                'jam_selesai' => '15:00:00',
                'jam_mulai_jumat' => '13:30:00',
                'jam_selesai_jumat' => '14:00:00',
                'keterangan' => 'Sesi Pembelajaran (Senin-Kamis Pulang pkl 15:00)',
            ],
            [
                'id_jam' => 11,
                'jam_ke' => 'Jam Ke-11',
                'jam_mulai' => null,
                'jam_selesai' => null,
                'jam_mulai_jumat' => '14:00:00',
                'jam_selesai_jumat' => '14:30:00',
                'keterangan' => 'Sesi Pembelajaran Khusus Jumat',
            ],
            [
                'id_jam' => 12,
                'jam_ke' => 'Jam Ke-12',
                'jam_mulai' => null,
                'jam_selesai' => null,
                'jam_mulai_jumat' => '14:30:00',
                'jam_selesai_jumat' => '15:00:00',
                'keterangan' => 'Sesi Pembelajaran Khusus Jumat (Kelas XI Pulang pkl 15:00)',
            ],
            [
                'id_jam' => 13,
                'jam_ke' => 'Jam Ke-13',
                'jam_mulai' => null,
                'jam_selesai' => null,
                'jam_mulai_jumat' => '15:00:00',
                'jam_selesai_jumat' => '15:30:00',
                'keterangan' => 'Sesi Pembelajaran Khusus Jumat (Kelas X Pulang pkl 15:30)',
            ],
        ];

        foreach ($newScheduleData as $row) {
            DB::table('jam_pelajaran')->updateOrInsert(
                ['id_jam' => $row['id_jam']],
                [
                    'jam_ke' => $row['jam_ke'],
                    'jam_mulai' => $row['jam_mulai'],
                    'jam_selesai' => $row['jam_selesai'],
                    'jam_mulai_jumat' => $row['jam_mulai_jumat'],
                    'jam_selesai_jumat' => $row['jam_selesai_jumat'],
                    'keterangan' => $row['keterangan'],
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
