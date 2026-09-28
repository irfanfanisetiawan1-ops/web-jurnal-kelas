<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Siswa;
use App\Models\JurnalMengajar;
use App\Models\JurnalDetailKetidakhadiran;

$siswa = Siswa::find(957);
$jurnals = JurnalMengajar::whereHas('jadwal', function($q) use ($siswa) {
    $q->where('id_kelas', $siswa->id_kelas);
})->with(['jadwal.mapel', 'jadwal.guru', 'guruPengganti'])->orderBy('tanggal', 'desc')->get();

echo "Total Jurnal for Class {$siswa->id_kelas}: " . $jurnals->count() . "\n";
foreach ($jurnals as $j) {
    $abs = JurnalDetailKetidakhadiran::where('id_jurnal', $j->id_jurnal)->where('id_siswa', $siswa->id_siswa)->first();
    $status = $abs ? $abs->keterangan : 'Hadir';
    echo $j->tanggal . ' | ' . ($j->jadwal->mapel->nama_mapel ?? '-') . ' | Guru: ' . ($j->jadwal->guru->nama_guru ?? '-') . ' | Presensi: ' . $status . "\n";
}
