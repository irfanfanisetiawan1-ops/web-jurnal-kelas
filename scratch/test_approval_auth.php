<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SiswaDispen;
use App\Models\User;
use App\Models\JadwalPiketWaka;

echo "=== Testing All 5 Piket Waka Teachers Authorization ===\n";

$testDates = [
    '2026-09-07' => 'Setiyo Winarko',
    '2026-09-01' => 'Niken Hari Pratiwi',
    '2026-09-02' => 'Hardini Indahing Budi',
    '2026-09-03' => 'Hendro Suwignyo',
    '2026-09-04' => 'Fajar Luthfianto',
];

foreach ($testDates as $date => $name) {
    $user = User::where('name', 'like', "%{$name}%")->first();
    if (!$user) {
        echo "User {$name} not found!\n";
        continue;
    }

    $isPiket = JadwalPiketWaka::isUserPiketWaka($user, $date);

    $dispen = new SiswaDispen([
        'id_user_waka' => $user->id,
        'tanggal' => $date,
        'status_waka' => 'pending'
    ]);

    $isAssignedWaka = ($dispen->id_user_waka && $user->id == $dispen->id_user_waka) ||
                      JadwalPiketWaka::isUserPiketWaka($user, $dispen->tanggal);

    $isValidWaka = ($user->role === 'waka_kesiswaan') || 
                   in_array($user->role, ['admin', 'tu', 'waka']) || 
                   $isAssignedWaka;

    echo "- {$date}: {$user->name} (Role: {$user->role}) => Piket: " . ($isPiket ? 'YES' : 'NO') . " | Authorized: " . ($isValidWaka ? 'SUCCESS' : 'FAILED') . "\n";
}
