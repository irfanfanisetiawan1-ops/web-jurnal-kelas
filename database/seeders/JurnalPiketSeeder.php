<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JurnalPiket;
use App\Models\Guru;
use Carbon\Carbon;

class JurnalPiketSeeder extends Seeder
{
    public function run(): void
    {
        $guru = Guru::first();

        JurnalPiket::create([
            'tanggal'            => Carbon::today()->toDateString(),
            'id_guru'            => $guru ? $guru->id_guru : null,
            'nama_petugas_piket' => $guru ? $guru->nama_guru : 'Budi Santoso, S.Kom',
            'jam_piket'          => '07:00 - 15:00',
            'catatan_kejadian'   => 'Kegiatan belajar mengajar berjalan kondusif. 2 siswa terlambat telah diberi pengarahan dan izin masuk kelas.',
            'status_suasana'     => 'Kondusif',
        ]);

        JurnalPiket::create([
            'tanggal'            => Carbon::yesterday()->toDateString(),
            'id_guru'            => $guru ? $guru->id_guru : null,
            'nama_petugas_piket' => 'Rina Marlina, S.Pd',
            'jam_piket'          => '07:00 - 15:00',
            'catatan_kejadian'   => 'Penanganan siswa sakit di ruang UKS. Pembelajaran kelas X RPL 1 berjalan lancar.',
            'status_suasana'     => 'Kondusif',
        ]);
    }
}
