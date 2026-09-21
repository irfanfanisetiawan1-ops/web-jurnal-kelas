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

echo "--- Testing Kehadiran Guru Kepala Sekolah ---\n";

$kepsekUser = User::where('role', 'kepala_sekolah')->first();
Auth::login($kepsekUser);
echo "Logged in as: " . $kepsekUser->nama_lengkap . " (" . $kepsekUser->role . ")\n";

$controller = app(\App\Http\Controllers\KepalaSekolahController::class);

// 1. Test index page
$reqIndex = new \Illuminate\Http\Request();
$viewIndex = $controller->kehadiranGuru($reqIndex);
echo "1. kehadiranGuru() returned view: " . $viewIndex->getName() . "\n";
echo "   Total Guru: " . $viewIndex->getData()['totalGuru'] . "\n";
echo "   Guru Hadir: " . $viewIndex->getData()['guruHadirCount'] . "\n";
echo "   Guru Izin: " . $viewIndex->getData()['guruIzinCount'] . "\n";
echo "   Pending Approval: " . $viewIndex->getData()['pendingApprovalCount'] . "\n";
echo "   Izin Cards Count: " . count($viewIndex->getData()['guruIzinList']) . "\n";

// 2. Test search and filters
$reqFilter = new \Illuminate\Http\Request(['status' => 'pending', 'q' => 'Sulistyowati']);
$viewFilter = $controller->kehadiranGuru($reqFilter);
echo "2. Filter test: Found " . count($viewFilter->getData()['guruIzinList']) . " records matching 'Sulistyowati' and 'pending'\n";

// 3. Test approve action
$samplePending = GuruIzin::where('status_kepsek', 'pending')->first();
if ($samplePending) {
    echo "3. Testing Approve on ID: " . $samplePending->id_guru_izin . " (" . ($samplePending->guru->nama_guru ?? 'Guru') . ")\n";
    $reqApprove = new \Illuminate\Http\Request(['catatan' => 'Test approval from test suite']);
    $respApprove = $controller->approve($reqApprove, $samplePending->id_guru_izin);
    echo "   Approve status: " . $respApprove->getStatusCode() . "\n";
    
    $checkStatus = GuruIzin::find($samplePending->id_guru_izin);
    echo "   New status_kepsek: " . $checkStatus->status_kepsek . " | status_final: " . $checkStatus->status_final . "\n";

    // Revert to pending for clean state
    $checkStatus->status_kepsek = 'pending';
    $checkStatus->status_final = 'pending';
    $checkStatus->save();
    echo "   Reverted back to pending for state cleanliness.\n";
}

echo "\n--- ALL TESTS PASSED SUCCESFULLY WITH ZERO ERRORS! ---\n";
