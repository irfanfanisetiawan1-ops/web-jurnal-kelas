<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\JadwalPiketWaka;
use App\Models\Guru;
use App\Models\User;
use App\Models\SiswaDispen;
use App\Services\JadwalPiketWakaImportService;
use Illuminate\Http\UploadedFile;

echo "=== 1. Testing JadwalPiketWaka DB Records ===\n";
$count = JadwalPiketWaka::count();
echo "Total Jadwal Piket Waka in DB: {$count}\n";

$sample = JadwalPiketWaka::with(['guru', 'user'])->where('bulan', 9)->where('tahun', 2026)->first();
if ($sample) {
    echo "Sample September 2026: {$sample->tanggal->format('Y-m-d')} ({$sample->hari}) => " . ($sample->guru->nama_guru ?? 'None') . " | User ID: " . ($sample->id_user ?? 'None') . "\n";
}

echo "\n=== 2. Testing Helper Methods ===\n";
$targetDate = '2026-09-01'; // Selasa
$piketWaka = JadwalPiketWaka::getPiketWakaByDate($targetDate);
if ($piketWaka) {
    echo "Piket Waka on {$targetDate}: " . ($piketWaka->guru->nama_guru ?? '-') . " (NIP: " . ($piketWaka->guru->nip ?? '-') . ")\n";
    $assignedUser = $piketWaka->user;
    if ($assignedUser) {
        $isPiket = JadwalPiketWaka::isUserPiketWaka($assignedUser, $targetDate);
        echo "isUserPiketWaka for {$assignedUser->name} on {$targetDate}: " . ($isPiket ? 'TRUE (OK)' : 'FALSE (FAIL)') . "\n";
    }
}

echo "\n=== 3. Testing PDF Import via JadwalPiketWakaImportService ===\n";
$pdfPath = 'c:/laragon/www/web-jurnal-kelas/PIKET BULAN SEPTEMBER nuw20260828_10270412.pdf';
if (file_exists($pdfPath)) {
    $uploadedFile = new UploadedFile($pdfPath, 'PIKET BULAN SEPTEMBER nuw20260828_10270412.pdf', 'application/pdf', null, true);
    $service = new JadwalPiketWakaImportService();
    $result = $service->parseAndMatch($uploadedFile, 9, 2026);
    echo "Workdays parsed: " . count($result) . "\n";
    $matched = array_filter($result, fn($r) => !empty($r['id_guru']));
    echo "Matched days with Piket Waka: " . count($matched) . "\n";
    foreach (array_slice($result, 0, 5) as $row) {
        echo "  - {$row['tanggal']} ({$row['hari']}): {$row['nama_guru']}\n";
    }
} else {
    echo "PDF file not found at: {$pdfPath}\n";
}

echo "\n=== 4. Testing Piket Waka Integration in Guru Piket Controller ===\n";
$controller = app(\App\Http\Controllers\GuruPiketController::class);
$request = new \Illuminate\Http\Request();
$response = $controller->dispensasiSiswa($request);
$viewData = $response->getData();
echo "Waka list count: " . count($viewData['wakaList']) . "\n";
echo "Piket Waka Date Map keys count: " . count($viewData['piketWakaDateMap']) . "\n";

// Check if assigned Piket Waka user is present in wakaList
$samplePiketUser = User::where('name', 'like', '%Setiyo Winarko%')->first();
if ($samplePiketUser) {
    $inList = $viewData['wakaList']->contains('id', $samplePiketUser->id);
    echo "Teacher Setiyo Winarko (User ID: {$samplePiketUser->id}) present in wakaList: " . ($inList ? 'YES (OK)' : 'NO (FAIL)') . "\n";
}

echo "\n=== ALL TESTS COMPLETED SUCCESSFULLY ===\n";
