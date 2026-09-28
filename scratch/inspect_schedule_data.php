<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\JamPelajaran;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use Carbon\Carbon;

echo "--- Inspecting Database Schedule & Master Data ---\n";
echo "Total Jam Pelajaran: " . JamPelajaran::count() . "\n";
foreach (JamPelajaran::take(8)->get() as $jp) {
    echo "  Jam Ke: {$jp->jam_ke} | {$jp->jam_mulai} - {$jp->jam_selesai} | Hari: {$jp->hari}\n";
}

echo "\nTotal Kelas: " . Kelas::count() . "\n";
echo "Total Jadwal: " . Jadwal::count() . "\n";
echo "Total Guru: " . Guru::count() . "\n";

$todayHari = Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd');
$todayJadwalCount = Jadwal::where('hari', $todayHari)->count();
echo "Jadwal Hari Ini ({$todayHari}): {$todayJadwalCount}\n";
