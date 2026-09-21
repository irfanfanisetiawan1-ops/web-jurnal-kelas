<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\GuruIzin;
use Carbon\Carbon;

echo "--- Inspecting Guru Izin Records ---\n";
$izins = GuruIzin::withTrashed()->with(['guru.mapel', 'guruPiket'])->get();

foreach ($izins as $i) {
    echo "ID: {$i->id_guru_izin} | Guru: " . ($i->guru->nama_guru ?? 'None') . " | Mulai: {$i->tanggal_mulai} | Selesai: {$i->tanggal_selesai} | Durasi: {$i->durasi} / {$i->durasi_hari} | Kat: {$i->kategori_izin} | Trashed: " . ($i->trashed() ? 'YES' : 'NO') . "\n";
    echo "  Status Waka: {$i->status_waka} | Kepsek: {$i->status_kepsek} | Final: {$i->status_final} | Pengganti: " . ($i->nama_guru_pengganti ?? $i->guruPiket->nama_guru ?? $i->nama_guru_piket ?? 'None') . "\n";
    echo "  Foto: {$i->foto_surat} | File: {$i->file_tugas}\n\n";
}
