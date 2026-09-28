<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\GuruPiketController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Mock login as guru piket & session errors
$userPiket = User::where('role', 'guru_piket')->first() ?? User::first();
Auth::login($userPiket);
\Illuminate\Support\Facades\View::share('errors', new \Illuminate\Support\ViewErrorBag);

$controller = app(GuruPiketController::class);
$request = Request::create('/guru-piket/dispensasi-siswa', 'GET');
$response = $controller->dispensasiSiswa($request);

$html = $response->render();

echo "=== TEST RENDER VIEW DISPENSASI SISWA ===" . PHP_EOL;
echo "HTML Length: " . strlen($html) . " bytes" . PHP_EOL;
echo "Contains Fajar Luthfianto: " . (str_contains($html, 'Fajar Luthfianto') ? 'YES' : 'NO') . PHP_EOL;
echo "Contains Waka Kesiswaan: " . (str_contains($html, '[Waka Kesiswaan]') ? 'YES' : 'NO') . PHP_EOL;
echo "Contains Piket Waka: " . (str_contains($html, '[Piket Waka]') ? 'YES' : 'NO') . PHP_EOL;
echo "=== VIEW RENDERED SUCCESSFULLY (200 OK) ===" . PHP_EOL;
