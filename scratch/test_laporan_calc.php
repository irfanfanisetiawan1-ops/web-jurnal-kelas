<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Siswa;
use App\Models\JurnalMengajar;
use App\Models\JurnalDetailKetidakhadiran;
use App\Models\SiswaDispen;
use App\Models\SiswaTelat;
use App\Models\SiswaSuratIzin;
use Carbon\Carbon;

$siswa = Siswa::find(957);
$filterBulan = 9;
$filterTahun = 2026;

$jurnalsBulan = JurnalMengajar::whereHas('jadwal', function ($q) use ($siswa) {
    $q->where('id_kelas', $siswa->id_kelas);
})->whereMonth('tanggal', $filterBulan)
  ->whereYear('tanggal', $filterTahun)
  ->with(['jadwal.mapel', 'jadwal.guru', 'jadwal.ruangan', 'guruPengganti', 'detailKetidakhadiran' => function ($q) use ($siswa) {
      $q->where('id_siswa', $siswa->id_siswa);
  }])
  ->orderBy('tanggal', 'desc')
  ->orderBy('jam_ke', 'asc')
  ->get();

echo "Total Jurnal in 09/2026: " . $jurnalsBulan->count() . "\n";

$hadir = 0; $sakit = 0; $izin = 0; $alpa = 0; $dispen = 0;
foreach ($jurnalsBulan as $j) {
    $detail = $j->detailKetidakhadiran->first();
    $status = 'Hadir';
    if ($detail) {
        $status = ucfirst(strtolower($detail->keterangan));
    }
    if ($status === 'Hadir') $hadir++;
    elseif ($status === 'Sakit') $sakit++;
    elseif ($status === 'Izin') $izin++;
    elseif ($status === 'Alpa' || $status === 'Alpha') $alpa++;
    elseif ($status === 'Dispen') $dispen++;
}

echo "Hadir: $hadir, Sakit: $sakit, Izin: $izin, Alpa: $alpa, Dispen: $dispen\n";
echo "Total: " . ($hadir + $sakit + $izin + $alpa + $dispen) . "\n";
