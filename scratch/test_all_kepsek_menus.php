<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "--- Testing All Kepala Sekolah Menus & Views ---\n";

$kepsekUser = User::where('role', 'kepala_sekolah')->first();
Auth::login($kepsekUser);
echo "Logged in as: " . $kepsekUser->nama_lengkap . " (" . $kepsekUser->role . ")\n";

$controller = app(\App\Http\Controllers\KepalaSekolahController::class);

// 1. Dashboard
$viewDashboard = $controller->dashboard();
echo "1. dashboard() -> " . $viewDashboard->getName() . " [OK]\n";

// 2. Persetujuan Izin
$reqIzin = new \Illuminate\Http\Request();
$viewPersetujuan = $controller->persetujuanIzin($reqIzin);
echo "2. persetujuanIzin() -> " . $viewPersetujuan->getName() . " [OK]\n";

// 3. Guru Izin Tidak Hadir
$reqGuruIzin = new \Illuminate\Http\Request();
$viewGuruIzin = $controller->guruIzinTidakHadir($reqGuruIzin);
echo "3. guruIzinTidakHadir() -> " . $viewGuruIzin->getName() . " [OK]\n";

// 4. Kehadiran Siswa
$reqSiswa = new \Illuminate\Http\Request();
$viewKehadiranSiswa = $controller->kehadiranSiswa($reqSiswa);
echo "4. kehadiranSiswa() -> " . $viewKehadiranSiswa->getName() . " [OK]\n";

// 5. Siswa Izin & Dispen
$reqSiswaIzin = new \Illuminate\Http\Request();
$viewSiswaIzin = $controller->siswaIzin($reqSiswaIzin);
echo "5. siswaIzin() -> " . $viewSiswaIzin->getName() . " [OK]\n";

// 6. Jurnal Mengajar / Pembelajaran
$reqJurnal = new \Illuminate\Http\Request();
$viewJurnal = $controller->jurnalPembelajaran($reqJurnal);
echo "6. jurnalPembelajaran() -> " . $viewJurnal->getName() . " [OK]\n";

// 7. Laporan
$reqLaporan = new \Illuminate\Http\Request();
$viewLaporan = $controller->laporan($reqLaporan);
echo "7. laporan() -> " . $viewLaporan->getName() . " [OK]\n";

echo "\n--- ALL KEPALA SEKOLAH VIEWS & METHODS TESTED WITH ZERO ERRORS! ---\n";
