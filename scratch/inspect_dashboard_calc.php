<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\GuruIzin;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\SiswaDispen;
use App\Models\SiswaSuratIzin;
use App\Models\JurnalMengajar;
use App\Models\Jadwal;
use App\Models\JamPelajaran;
use Carbon\Carbon;

echo "--- Inspecting Current Dashboard Data ---\n";
$today = Carbon::today('Asia/Jakarta')->toDateString();
$totalGuru = Guru::count();
$totalSiswa = Siswa::count();
$pendingIzin = GuruIzin::with('guru.mapel')->where('status_kepsek', 'pending')->get();
$approvedIzin = GuruIzin::where('status_kepsek', 'approved')->get();

echo "Total Guru: {$totalGuru}\n";
echo "Total Siswa: {$totalSiswa}\n";
echo "Pending Izin Kepsek Count: " . $pendingIzin->count() . "\n";
foreach ($pendingIzin as $pi) {
    echo "  - {$pi->guru->nama_guru} ({$pi->guru->mapel->nama_mapel}) | {$pi->tanggal_mulai} | {$pi->alasan} | Waka: {$pi->status_waka} | WakaSDM: {$pi->status_waka_sdm}\n";
}
echo "Approved Izin Count: " . $approvedIzin->count() . "\n";
