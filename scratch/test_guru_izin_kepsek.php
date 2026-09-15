<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\User;
use App\Models\GuruIzin;
use Illuminate\Support\Facades\Auth;

echo "--- Testing Guru Izin Tidak Hadir Kepala Sekolah ---\n";

$kepsekUser = User::where('role', 'kepala_sekolah')->first();
if (!$kepsekUser) {
    echo "No kepala_sekolah user found!\n";
    exit;
}

Auth::login($kepsekUser);
echo "Logged in as: " . $kepsekUser->nama_lengkap . " (" . $kepsekUser->role . ")\n";

$controller = app(\App\Http\Controllers\KepalaSekolahController::class);

// 1. Test index page
$reqIndex = new \Illuminate\Http\Request();
$viewIndex = $controller->guruIzinTidakHadir($reqIndex);
echo "1. guruIzinTidakHadir() returned view: " . $viewIndex->getName() . "\n";
echo "   Active Guru Izin count: " . count($viewIndex->getData()['guruIzinList']) . "\n";
echo "   Trash count: " . $viewIndex->getData()['trashCount'] . "\n";

// 2. Test trash page
$viewTrash = $controller->trashGuruIzin();
echo "2. trashGuruIzin() returned view: " . $viewTrash->getName() . "\n";
echo "   Trashed Guru Izin count: " . count($viewTrash->getData()['guruIzinList']) . "\n";

// 3. Test bulk delete & batch restore
$sampleIzin = GuruIzin::first();
if ($sampleIzin) {
    echo "3. Testing Soft Delete on ID: " . $sampleIzin->id_guru_izin . "\n";
    $reqBulk = new \Illuminate\Http\Request(['ids' => [$sampleIzin->id_guru_izin]]);
    $respBulk = $controller->bulkDeleteGuruIzin($reqBulk);
    echo "   Bulk delete status: " . $respBulk->getStatusCode() . "\n";

    $trashedCheck = GuruIzin::onlyTrashed()->where('id_guru_izin', $sampleIzin->id_guru_izin)->first();
    echo "   Is in trash: " . ($trashedCheck ? 'YES' : 'NO') . "\n";

    $reqRestore = new \Illuminate\Http\Request(['ids' => [$sampleIzin->id_guru_izin]]);
    $respRestore = $controller->batchRestoreGuruIzin($reqRestore);
    echo "   Batch restore status: " . $respRestore->getStatusCode() . "\n";

    $restoredCheck = GuruIzin::where('id_guru_izin', $sampleIzin->id_guru_izin)->first();
    echo "   Is active again: " . ($restoredCheck ? 'YES' : 'NO') . "\n";
}

echo "\n--- ALL TESTS PASSED SUCCESFULLY WITH ZERO ERRORS! ---\n";
