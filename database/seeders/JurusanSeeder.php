<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusanList = [
            ['id_jurusan' => 1, 'kode_jurusan' => 'TKI', 'nama_jurusan' => 'Teknik Kimia Industri'],
            ['id_jurusan' => 2, 'kode_jurusan' => 'RPL', 'nama_jurusan' => 'Rekayasa Perangkat Lunak / PPLG'],
            ['id_jurusan' => 3, 'kode_jurusan' => 'TKJ', 'nama_jurusan' => 'Teknik Komputer dan Jaringan / TJKT'],
            ['id_jurusan' => 4, 'kode_jurusan' => 'BD', 'nama_jurusan' => 'Bisnis Digital / Pemasaran'],
            ['id_jurusan' => 5, 'kode_jurusan' => 'MP', 'nama_jurusan' => 'Manajemen Perkantoran / MPLB'],
            ['id_jurusan' => 6, 'kode_jurusan' => 'AK', 'nama_jurusan' => 'Akuntansi / AKL'],
            ['id_jurusan' => 7, 'kode_jurusan' => 'ULW', 'nama_jurusan' => 'Usaha Layanan Wisata / ULP'],
            ['id_jurusan' => 8, 'kode_jurusan' => 'DKV', 'nama_jurusan' => 'Desain Komunikasi Visual'],
            ['id_jurusan' => 9, 'kode_jurusan' => 'PSPT', 'nama_jurusan' => 'Produksi dan Siaran Program Televisi / Broadcasting'],
            ['id_jurusan' => 10, 'kode_jurusan' => 'AN', 'nama_jurusan' => 'Animasi'],
        ];

        foreach ($jurusanList as $data) {
            Jurusan::updateOrCreate(
                ['kode_jurusan' => $data['kode_jurusan']],
                [
                    'id_jurusan' => $data['id_jurusan'],
                    'nama_jurusan' => $data['nama_jurusan']
                ]
            );
        }
    }
}
