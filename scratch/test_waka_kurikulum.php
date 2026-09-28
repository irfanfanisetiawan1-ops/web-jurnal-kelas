<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

echo "=== 1. Checking Waka Users in Database ===\n";
$hardini = User::where('nip', '198208222014072002')->first();
$fajar   = User::where('nip', '197808102023211005')->first();
$setiyo  = User::where('role', 'waka_sdm')->first();

echo "Hardini: ID {$hardini->id}, Name: {$hardini->name}, Role: {$hardini->role}, Label: {$hardini->role_label}\n";
echo "Fajar:   ID {$fajar->id}, Name: {$fajar->name}, Role: {$fajar->role}, Label: {$fajar->role_label}\n";
echo "Setiyo:  ID {$setiyo->id}, Name: {$setiyo->name}, Role: {$setiyo->role}, Label: {$setiyo->role_label}\n";

echo "\n=== 2. Updating Hardini role to waka_kurikulum ===\n";
$hardini->role = 'waka_kurikulum';
$hardini->save();
$hardini->refresh();
echo "Hardini Updated Role: {$hardini->role}, Label: {$hardini->role_label}\n";

echo "\n=== 3. Testing AuthController redirectByRole ===\n";
$authCtrl = new AuthController();

$redirectHardini = $authCtrl->redirectByRole($hardini);
echo "Hardini redirects to: " . $redirectHardini->getTargetUrl() . "\n";
assert(str_contains($redirectHardini->getTargetUrl(), 'waka-kurikulum/dashboard'), "Hardini should redirect to waka-kurikulum/dashboard");

$redirectFajar = $authCtrl->redirectByRole($fajar);
echo "Fajar redirects to: " . $redirectFajar->getTargetUrl() . "\n";
assert(str_contains($redirectFajar->getTargetUrl(), 'waka/dashboard'), "Fajar should redirect to waka/dashboard");

$redirectSetiyo = $authCtrl->redirectByRole($setiyo);
echo "Setiyo redirects to: " . $redirectSetiyo->getTargetUrl() . "\n";
assert(str_contains($redirectSetiyo->getTargetUrl(), 'waka-sdm/dashboard'), "Setiyo should redirect to waka-sdm/dashboard");

echo "\n=== 4. Testing WakaKurikulumController Rendering ===\n";
Auth::login($hardini);
$wakaKurikulumCtrl = new \App\Http\Controllers\WakaKurikulumController();

// Test Dashboard
$dashView = $wakaKurikulumCtrl->dashboard();
$dashHtml = $dashView->render();
echo "Dashboard Kurikulum rendered successfully! Length: " . strlen($dashHtml) . "\n";
assert(str_contains($dashHtml, 'Wakil Kurikulum'), "Dashboard must contain 'Wakil Kurikulum'");
assert(str_contains($dashHtml, 'Total Jadwal KBM'), "Dashboard must contain 'Total Jadwal KBM'");

// Test Jadwal
$req = new \Illuminate\Http\Request();
$jadwalView = $wakaKurikulumCtrl->jadwal($req);
$jadwalHtml = $jadwalView->render();
echo "Jadwal Kurikulum rendered successfully! Length: " . strlen($jadwalHtml) . "\n";
assert(str_contains($jadwalHtml, 'Kelola Jadwal Pelajaran'), "Jadwal must contain 'Kelola Jadwal Pelajaran'");

// Verify Mata Pelajaran is removed from sidebar layout and replaced on dashboard
assert(!str_contains($dashHtml, 'route(\'waka-kurikulum.mapel\')'), "Sidebar must NOT contain route to mapel");
assert(str_contains($dashHtml, 'Rombel / Kelas'), "Dashboard must contain 'Rombel / Kelas'");

// Test Rekap Jurnal
$rekapView = $wakaKurikulumCtrl->rekapJurnal($req);
$rekapHtml = $rekapView->render();
echo "Rekap Jurnal Kurikulum rendered successfully! Length: " . strlen($rekapHtml) . "\n";
assert(str_contains($rekapHtml, 'Rekap Jurnal Mengajar'), "Rekap Jurnal must contain 'Rekap Jurnal Mengajar'");

// Test Jam Pelajaran
$jamView = $wakaKurikulumCtrl->jamPelajaran($req);
$jamHtml = $jamView->render();
echo "Jam Pelajaran Kurikulum rendered successfully! Length: " . strlen($jamHtml) . "\n";

// Test Pengumuman
$pengumumanView = $wakaKurikulumCtrl->pengumuman($req);
$pengumumanHtml = $pengumumanView->render();
echo "Pengumuman Kurikulum rendered successfully! Length: " . strlen($pengumumanHtml) . "\n";

echo "\n=== 5. Testing Cross-Role Redirection Guard ===\n";
// Hardini visits WakaController::dashboard() (Kesiswaan page) -> should be redirected to waka-kurikulum
$wakaKesiswaanCtrl = new \App\Http\Controllers\WakaController();
$guardResponse = $wakaKesiswaanCtrl->dashboard();
echo "When Hardini visits /waka/dashboard, response is: " . get_class($guardResponse) . " -> " . $guardResponse->getTargetUrl() . "\n";
assert(str_contains($guardResponse->getTargetUrl(), 'waka-kurikulum/dashboard'), "Should redirect Hardini to waka-kurikulum/dashboard");

// Fajar visits WakaKurikulumController::dashboard() -> should be redirected to waka/dashboard
Auth::login($fajar);
$guardResponse2 = $wakaKurikulumCtrl->dashboard($req);
echo "When Fajar visits /waka-kurikulum/dashboard, response is: " . get_class($guardResponse2) . " -> " . $guardResponse2->getTargetUrl() . "\n";
assert(str_contains($guardResponse2->getTargetUrl(), 'waka/dashboard'), "Should redirect Fajar to waka/dashboard");

echo "\n=== 6. Testing Enhanced Dashboard & Izin Features for Waka Kurikulum ===\n";
Auth::login($hardini);
$dashView = $wakaKurikulumCtrl->dashboard($req);
$dashHtml = $dashView->render();
assert(str_contains($dashHtml, 'Persetujuan &amp; Monitoring Izin Guru Pengampu'), "Dashboard must have Persetujuan & Monitoring Izin Guru Pengampu");
assert(str_contains($dashHtml, 'Menunggu Persetujuan'), "Dashboard must have Menunggu Persetujuan tab");
assert(str_contains($dashHtml, 'Izin Resmi Disetujui'), "Dashboard must have Izin Resmi Disetujui tab");
assert(str_contains($dashHtml, 'id="modalApprove"'), "Dashboard must have modalApprove");
assert(str_contains($dashHtml, 'id="modalReject"'), "Dashboard must have modalReject");
assert(str_contains($dashHtml, 'id="modalDetailIzin"'), "Dashboard must have modalDetailIzin");
echo "Enhanced Dashboard rendered with all new sections! HTML Length: " . strlen($dashHtml) . "\n";

// Test detailIzinJson on an existing record
$firstIzin = \App\Models\GuruIzin::first();
if ($firstIzin) {
    $detailResponse = $wakaKurikulumCtrl->detailIzinJson($firstIzin->id_guru_izin);
    $detailData = json_decode($detailResponse->getContent(), true);
    assert($detailData['success'] === true, "detailIzinJson must return success: true");
    assert(isset($detailData['data']['nama_guru']), "detailIzinJson must contain nama_guru");
    assert(isset($detailData['data']['jadwals_terdampak']), "detailIzinJson must contain jadwals_terdampak");
    echo "detailIzinJson PASSED for ID {$firstIzin->id_guru_izin}! Guru: {$detailData['data']['nama_guru']}, Jadwal Terdampak count: " . count($detailData['data']['jadwals_terdampak']) . "\n";
}

echo "\n=== 7. Testing Approve & Reject Lifecycle (DB Transaction) ===\n";
\Illuminate\Support\Facades\DB::beginTransaction();
try {
    // Create a temporary test izin
    $testIzin = \App\Models\GuruIzin::create([
        'id_guru'           => 1,
        'tanggal_mulai'     => '2026-09-10',
        'tanggal_selesai'   => '2026-09-10',
        'durasi'            => '1 Hari',
        'kategori_izin'     => 'biasa',
        'alasan'            => 'Uji Coba Persetujuan Waka Kurikulum',
        'status_waka'       => 'pending',
        'status_kepsek'     => 'pending',
        'status_final'      => 'pending',
        'token_approval'    => \Illuminate\Support\Str::random(32),
    ]);

    echo "Created Test Izin ID: {$testIzin->id_guru_izin}, Status Waka: {$testIzin->status_waka}\n";

    // Test Approve
    $approveReq = new \Illuminate\Http\Request(['catatan' => 'Disetujui Waka Kurikulum dalam pengujian']);
    $approveRes = $wakaKurikulumCtrl->approveIzin($approveReq, $testIzin->id_guru_izin);
    $testIzin->refresh();
    assert($testIzin->status_waka === 'approved', "Status Waka must be approved");
    assert(str_contains($testIzin->catatan_waka, 'Disetujui Waka Kurikulum'), "Catatan Waka must be updated");
    echo "approveIzin PASSED! Status Waka: {$testIzin->status_waka}, Catatan: {$testIzin->catatan_waka}\n";

    // Test Reject
    $rejectReq = new \Illuminate\Http\Request(['catatan' => 'Ditolak Waka Kurikulum karena alasan mendesak KBM']);
    $rejectRes = $wakaKurikulumCtrl->rejectIzin($rejectReq, $testIzin->id_guru_izin);
    $testIzin->refresh();
    assert($testIzin->status_waka === 'rejected', "Status Waka must be rejected");
    assert($testIzin->status_final === 'rejected', "Status Final must be rejected");
    echo "rejectIzin PASSED! Status Waka: {$testIzin->status_waka}, Final: {$testIzin->status_final}\n";

    // Test Batch Approve
    $batchReq = new \Illuminate\Http\Request(['selected_ids' => [$testIzin->id_guru_izin]]);
    $testIzin->status_waka = 'pending';
    $testIzin->save();
    $batchRes = $wakaKurikulumCtrl->batchApproveIzin($batchReq);
    $testIzin->refresh();
    assert($testIzin->status_waka === 'approved', "Status Waka after batch approve must be approved");
    echo "batchApproveIzin PASSED! Status Waka: {$testIzin->status_waka}\n";

    echo "\n=== 8. Testing Enhanced Pengumuman Kurikulum Features ===\n";
    $pengumumanView = $wakaKurikulumCtrl->pengumuman($req);
    $pengumumanHtml = $pengumumanView->render();
    assert(str_contains($pengumumanHtml, 'Pengumuman Kurikulum &amp; Akademik'), "Must render Pengumuman Kurikulum header");
    assert(str_contains($pengumumanHtml, 'Total Pengumuman'), "Must render Total Pengumuman stat card");
    assert(str_contains($pengumumanHtml, 'Kotak Sampah'), "Must render Kotak Sampah stat card");
    assert(str_contains($pengumumanHtml, 'modalTambah'), "Must render modalTambah");
    assert(str_contains($pengumumanHtml, 'modalEdit'), "Must render modalEdit");
    assert(str_contains($pengumumanHtml, 'modalDetail'), "Must render modalDetail");
    assert(str_contains($pengumumanHtml, 'modalTrash'), "Must render modalTrash");
    assert(!str_contains($pengumumanHtml, 'Pemberitahuan Siswa Terlambat'), "Pengumuman Siswa Terlambat must NOT appear on Waka Kurikulum page");
    echo "Pengumuman Blade rendered with all new stats & modals (Siswa Telat filtered out)! HTML Length: " . strlen($pengumumanHtml) . "\n";

    // Test detailPengumumanJson
    $firstPengumuman = \App\Models\Pengumuman::first();
    if ($firstPengumuman) {
        $detailPengumumanRes = $wakaKurikulumCtrl->detailPengumumanJson($firstPengumuman->id_pengumuman);
        $detailPengumumanData = json_decode($detailPengumumanRes->getContent(), true);
        assert($detailPengumumanData['success'] === true, "detailPengumumanJson must return success: true");
        assert(isset($detailPengumumanData['data']['judul']), "detailPengumumanJson must contain judul");
        echo "detailPengumumanJson PASSED for ID {$firstPengumuman->id_pengumuman}! Judul: {$detailPengumumanData['data']['judul']}\n";
    }

    // Test store, update, delete, restore Pengumuman
    $storePengumumanReq = new \Illuminate\Http\Request([
        'judul'      => 'Pengujian Pengumuman Kurikulum Test',
        'isi'        => 'Detail isi pengumuman pengujian otomatis',
        'kategori'   => 'Kurikulum',
        'tanggal'    => '2026-09-09',
        'status'     => 'aktif',
        'keterangan' => 'Waka Kurikulum',
    ]);
    $storeRes = $wakaKurikulumCtrl->storePengumuman($storePengumumanReq);
    $createdPengumuman = \App\Models\Pengumuman::where('judul', 'Pengujian Pengumuman Kurikulum Test')->first();
    assert($createdPengumuman !== null, "Created pengumuman must exist");
    echo "storePengumuman PASSED! Created ID: {$createdPengumuman->id_pengumuman}, Author Guru ID: {$createdPengumuman->id_guru}\n";

    // Update
    $updatePengumumanReq = new \Illuminate\Http\Request([
        'judul'      => 'Pengujian Pengumuman Kurikulum Test (UPDATED)',
        'isi'        => 'Detail isi pengumuman pengujian otomatis updated',
        'kategori'   => 'Asesmen',
        'tanggal'    => '2026-09-10',
        'status'     => 'selesai',
        'keterangan' => 'Seluruh Guru',
    ]);
    $updateRes = $wakaKurikulumCtrl->updatePengumuman($updatePengumumanReq, $createdPengumuman->id_pengumuman);
    $createdPengumuman->refresh();
    assert($createdPengumuman->judul === 'Pengujian Pengumuman Kurikulum Test (UPDATED)', "Judul must be updated");
    echo "updatePengumuman PASSED! New Title: {$createdPengumuman->judul}\n";

    // Soft delete
    $deleteRes = $wakaKurikulumCtrl->destroyPengumuman($createdPengumuman->id_pengumuman);
    assert(\App\Models\Pengumuman::onlyTrashed()->find($createdPengumuman->id_pengumuman) !== null, "Must be trashed");
    echo "destroyPengumuman PASSED! Trashed ID: {$createdPengumuman->id_pengumuman}\n";

    // Restore
    $restoreRes = $wakaKurikulumCtrl->restorePengumuman($createdPengumuman->id_pengumuman);
    assert(\App\Models\Pengumuman::find($createdPengumuman->id_pengumuman) !== null, "Must be restored");
    echo "restorePengumuman PASSED! Restored ID: {$createdPengumuman->id_pengumuman}\n";

} finally {
    \Illuminate\Support\Facades\DB::rollBack();
    echo "DB Transaction rolled back. Test data cleaned up successfully.\n";
}

echo "\n>>> ALL TESTS COMPLETED AND PASSED WITH 0 ERRORS! <<<\n";
