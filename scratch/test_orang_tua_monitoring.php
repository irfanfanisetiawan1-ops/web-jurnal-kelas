<?php
require 'c:/laragon/www/web-jurnal-kelas/vendor/autoload.php';
$app = require_once 'c:/laragon/www/web-jurnal-kelas/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Siswa;
use App\Http\Controllers\OrangTuaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

echo "=== STARTING ORANG TUA MONITORING PRESENSI TEST ===" . PHP_EOL;

// 1. Find an Orang Tua user
$orangTuaUser = User::where('role', 'orang_tua')->first();
if (!$orangTuaUser) {
    echo "No orang_tua user found in users table, checking fallback..." . PHP_EOL;
    $siswa = Siswa::first();
    $orangTuaUser = new User();
    $orangTuaUser->name = 'Orang Tua - ' . $siswa->nama_siswa;
    $orangTuaUser->role = 'orang_tua';
    $orangTuaUser->id_siswa = $siswa->id_siswa;
}

echo "Testing with User: " . $orangTuaUser->name . " (Role: " . $orangTuaUser->role . ", id_siswa: " . $orangTuaUser->id_siswa . ")" . PHP_EOL;
Auth::login($orangTuaUser);

$controller = new OrangTuaController();

// 2. Test GET Page
$req = new Request();
$resView = $controller->monitoringPresensi($req);

if ($resView instanceof \Illuminate\View\View) {
    echo "SUCCESS: monitoringPresensi returned View: " . $resView->getName() . PHP_EOL;
    $viewData = $resView->getData();
    echo "Student Name: " . ($viewData['siswa']->nama_siswa ?? 'None') . PHP_EOL;
    echo "Class: " . ($viewData['siswa']->kelas->nama_kelas ?? 'None') . PHP_EOL;
    echo "Timeline items: " . count($viewData['timelineKbm']) . PHP_EOL;
    echo "Summary: " . json_encode($viewData['summary']) . PHP_EOL;

    // Render HTML
    $renderedHtml = $resView->render();
    echo "SUCCESS: Blade rendered HTML length = " . strlen($renderedHtml) . " bytes." . PHP_EOL;
} else {
    echo "FAILED: monitoringPresensi did not return View!" . PHP_EOL;
}

// 3. Test API JSON endpoint
$reqApi = new Request();
$resApi = $controller->apiMonitoringPresensi($reqApi);
echo "SUCCESS: apiMonitoringPresensi returned status code: " . $resApi->getStatusCode() . PHP_EOL;
$apiData = $resApi->getData(true);
echo "API Data status: " . $apiData['status'] . ", timestamp: " . $apiData['timestamp'] . PHP_EOL;

echo "=== ORANG TUA MONITORING PRESENSI TEST COMPLETED SUCCESSFULLY! ===" . PHP_EOL;
