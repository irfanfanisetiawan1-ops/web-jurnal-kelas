<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Siswa;
use App\Models\JurnalMengajar;
use App\Models\JurnalDetailKetidakhadiran;
use App\Models\SiswaDispen;
use App\Models\SiswaTelat;
use App\Models\SiswaSuratIzin;
use Illuminate\Http\Request;
use App\Http\Controllers\OrangTuaController;

$user = User::where('role', 'orang_tua')->first();
auth()->login($user);

echo "Logged in as: {$user->name} ({$user->username})\n";

$request = new Request(['bulan' => 9, 'tahun' => 2026]);
$controller = new OrangTuaController();

$view = $controller->laporan($request);
echo "View name: " . $view->name() . "\n";
$data = $view->getData();
echo "Student: " . ($data['siswa']->nama_siswa ?? 'none') . "\n";
echo "Rekap Bulan: " . json_encode($data['rekapBulan']) . "\n";
echo "Rekap Harian count: " . count($data['rekapHarian'] ?? $data['laporanKehadiranHarian'] ?? []) . "\n";
echo "SUCCESS!\n";
