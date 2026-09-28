<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Guru;
use App\Models\GuruIzin;

$gurus = Guru::all();
echo "Total Gurus: " . $gurus->count() . "\n";
foreach ($gurus as $g) {
    echo "  Guru ID: {$g->id_guru} | Nama: {$g->nama_guru} | NIP: {$g->nip}\n";
}

$orphanIzins = GuruIzin::withTrashed()->whereNull('id_guru')->orWhereDoesntHave('guru')->get();
echo "\nOrphan Izins: " . $orphanIzins->count() . "\n";
foreach ($orphanIzins as $oi) {
    echo "  Izin ID: {$oi->id_guru_izin} | current id_guru: {$oi->id_guru}\n";
    // Link to valid guru if available
    $sampleGuru = Guru::inRandomOrder()->first();
    if ($sampleGuru) {
        $oi->id_guru = $sampleGuru->id_guru;
        $oi->save();
        echo "    -> Linked to {$sampleGuru->nama_guru} (ID: {$sampleGuru->id_guru})\n";
    }
}
