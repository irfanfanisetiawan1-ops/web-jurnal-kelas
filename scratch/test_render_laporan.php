<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\OrangTuaController;

echo "=== STARTING TEST ORANG TUA LAPORAN ===\n";
$user = User::where('role', 'orang_tua')->first();
auth()->login($user);

$request = new Request(['bulan' => 9, 'tahun' => 2026]);
$controller = new OrangTuaController();
$view = $controller->laporan($request);

echo "View name: " . $view->name() . "\n";
$rendered = $view->render();
echo "Rendered HTML length: " . strlen($rendered) . " bytes\n";
echo "SUCCESS: No errors in rendering Laporan Kehadiran!\n";
