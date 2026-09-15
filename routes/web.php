<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminMonitoringController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JurnalMengajarController;
use App\Http\Controllers\JurnalPiketController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\JamPelajaranController;
use App\Http\Controllers\GuruPortalController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\ApprovalPublicController;
use App\Http\Controllers\WakaController;
use App\Http\Controllers\WakaSdmController;
use App\Http\Controllers\WakaKurikulumController;
use App\Http\Controllers\KepalaSekolahController;
use App\Http\Controllers\SatpamController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\SuratIzinSiswaController;
use App\Http\Controllers\GuruPiketController;
use App\Http\Controllers\TahunAjaranController;

// ─────────────────────────────────────────────────
// Public Auth Routes & Link Approval (Tanpa Ribet Login)
// ─────────────────────────────────────────────────
Route::get('/login',             [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',            [AuthController::class, 'login'])->name('login.post');
Route::get('/login/orang-tua',   [AuthController::class, 'showOrangTuaLoginForm'])->name('login.orang-tua');
Route::post('/login/orang-tua',  [AuthController::class, 'loginOrangTua'])->name('login.orang-tua.post');
Route::get('/login-petugas',     [AuthController::class, 'showPetugasLoginForm'])->name('login.petugas');
Route::post('/login-petugas',    [AuthController::class, 'loginPetugas'])->name('login.petugas.post');
Route::get('/register', function () {
    return redirect()->route('login')->with('error', 'Pendaftaran akun pengguna tidak dibuka secara publik. Seluruh akun pengguna dibuat dan diverifikasi oleh Administrator Tata Usaha (TU).');
})->name('register');
Route::post('/logout',           [AuthController::class, 'logout'])->name('logout');

// Public Link Persetujuan Unik (Waka, Kepsek & Wali Kelas)
Route::get('/approval/guru-izin/{token}',  [ApprovalPublicController::class, 'showGuruIzin'])->name('approval.guru-izin.show');
Route::post('/approval/guru-izin/{token}', [ApprovalPublicController::class, 'processGuruIzin'])->name('approval.guru-izin.process');
Route::get('/approval/dispen/{token}',     [ApprovalPublicController::class, 'showSiswaDispen'])->name('approval.siswa-dispen.show');
Route::post('/approval/dispen/{token}',    [ApprovalPublicController::class, 'processSiswaDispen'])->name('approval.siswa-dispen.process');

// Redirect root ke dashboard sesuai role
Route::get('/', function () {
    if (auth()->check()) {
        $authCtrl = new AuthController();
        return $authCtrl->redirectByRole(auth()->user());
    }
    return redirect()->route('login');
});

// ─────────────────────────────────────────────────
// Admin-Only Routes (auth + admin middleware)
// ─────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',  [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/export-csv', [AdminDashboardController::class, 'exportCsv'])->name('export-csv');

    // Manajemen Pengguna (Role TU)
    Route::get('/verifikasi-guru',                              [AdminDashboardController::class, 'verifikasiGuru'])->name('verifikasi-guru');
    Route::get('/pengguna',                                     [AdminDashboardController::class, 'verifikasiGuru'])->name('pengguna');
    Route::post('/verifikasi-guru/{id}/approve',                [AdminDashboardController::class, 'approveGuru'])->name('verifikasi-guru.approve');
    Route::post('/verifikasi-guru/{id}/reject',                 [AdminDashboardController::class, 'rejectGuru'])->name('verifikasi-guru.reject');
    Route::post('/verifikasi-guru/{id}/update-role',            [AdminDashboardController::class, 'updateRole'])->name('verifikasi-guru.update-role');
    Route::post('/users',                                       [AdminDashboardController::class, 'storeUser'])->name('users.store');
    Route::post('/users/generate-all-orang-tua',                 [AdminDashboardController::class, 'generateAllOrangTua'])->name('users.generate-all-orang-tua');
    Route::post('/users/{id}/reset-password',                   [AdminDashboardController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('/users/{id}/toggle-active',                    [AdminDashboardController::class, 'toggleActive'])->name('users.toggle-active');

    // Submenu Navigasi Guru & Piket Management
    Route::get('/guru-piket-list',                              [AdminDashboardController::class, 'guruPiketList'])->name('guru-piket');
    Route::post('/guru-piket',                                  [AdminDashboardController::class, 'storeGuruPiket'])->name('guru-piket.store');
    Route::delete('/guru-piket/{id}',                           [AdminDashboardController::class, 'destroyGuruPiket'])->name('guru-piket.destroy');
    Route::get('/guru-piket-trash',                             [AdminDashboardController::class, 'guruPiketTrash'])->name('guru-piket.trash');
    Route::post('/guru-piket-trash/{id}/restore',               [AdminDashboardController::class, 'restoreGuruPiket'])->name('guru-piket.restore');
    Route::delete('/guru-piket-trash/{id}/force-delete',        [AdminDashboardController::class, 'forceDeleteGuruPiket'])->name('guru-piket.force-delete');

    // Submenu Navigasi Wali Kelas Management
    Route::delete('/wali-kelas/destroy-batch',                 [AdminDashboardController::class, 'destroyBatchWaliKelas'])->name('wali-kelas.destroy-batch');
    Route::get('/wali-kelas-list',                              [AdminDashboardController::class, 'waliKelasList'])->name('wali-kelas-list');
    Route::post('/wali-kelas',                                  [AdminDashboardController::class, 'storeWaliKelas'])->name('wali-kelas.store');
    Route::post('/wali-kelas/bulk-assign',                      [AdminDashboardController::class, 'storeBulkWaliKelas'])->name('wali-kelas.bulk-assign');
    Route::delete('/wali-kelas/{id}',                           [AdminDashboardController::class, 'destroyWaliKelas'])->name('wali-kelas.destroy');
    Route::get('/wali-kelas-trash',                             [AdminDashboardController::class, 'waliKelasTrash'])->name('wali-kelas.trash');
    Route::post('/wali-kelas-trash/{id}/restore',               [AdminDashboardController::class, 'restoreWaliKelas'])->name('wali-kelas.restore');
    Route::delete('/wali-kelas-trash/{id}/force-delete',        [AdminDashboardController::class, 'forceDeleteWaliKelas'])->name('wali-kelas.force-delete');

    // User Soft Delete & Trash
    Route::delete('/users/destroy-batch',                       [AdminDashboardController::class, 'destroyBatchUsers'])->name('users.destroy-batch');
    Route::delete('/users/{id}',                                [AdminDashboardController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/users-trash',                                  [AdminDashboardController::class, 'usersTrash'])->name('users-trash');
    Route::post('/users-trash/{id}/restore',                    [AdminDashboardController::class, 'restoreUser'])->name('users-trash.restore');
    Route::match(['POST', 'DELETE'], '/users-trash/{id}/force-delete', [AdminDashboardController::class, 'forceDeleteUser'])->name('users-trash.force-delete');

    // Admin Profile
    Route::get('/profile',              [AdminDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile/update',      [AdminDashboardController::class, 'updateProfile'])->name('profile.update');

    // Monitoring Jurnal Mengajar
    Route::get('/jurnal-mengajar-admin',                  [AdminMonitoringController::class, 'jurnalMengajar'])->name('jurnal-mengajar');
    Route::get('/jurnal-mengajar-admin/export',           [AdminMonitoringController::class, 'jurnalMengajarExport'])->name('jurnal-mengajar.export');
    Route::get('/jurnal-mengajar-admin/print',            [AdminMonitoringController::class, 'jurnalMengajarCetak'])->name('jurnal-mengajar.print');
    Route::get('/jurnal-mengajar-admin/detail/{id}',      [AdminMonitoringController::class, 'jurnalMengajarDetail'])->name('jurnal-mengajar.detail');
    Route::get('/jurnal-mengajar-admin/print-detail/{id}', [AdminMonitoringController::class, 'jurnalMengajarCetakDetail'])->name('jurnal-mengajar.print-detail');
    Route::post('/jurnal-mengajar-admin/store',           [AdminMonitoringController::class, 'jurnalMengajarStore'])->name('jurnal-mengajar.store');
    Route::delete('/jurnal-mengajar-admin/{id}',          [AdminMonitoringController::class, 'jurnalMengajarDestroy'])->name('jurnal-mengajar.destroy');

    // Monitoring Jurnal Piket
    Route::get('/jurnal-piket-admin',                      [AdminMonitoringController::class, 'jurnalPiket'])->name('jurnal-piket');
    Route::post('/jurnal-piket-admin/store',              [AdminMonitoringController::class, 'jurnalPiketStore'])->name('jurnal-piket.store');
    Route::get('/jurnal-piket-admin/export',              [AdminMonitoringController::class, 'jurnalPiketExport'])->name('jurnal-piket.export');
    Route::get('/jurnal-piket-admin/print',               [AdminMonitoringController::class, 'jurnalPiketCetak'])->name('jurnal-piket.print');
    Route::get('/jurnal-piket-admin/trash',               [AdminMonitoringController::class, 'jurnalPiketTrash'])->name('jurnal-piket.trash');
    Route::get('/jurnal-piket-admin/{id}/detail',         [AdminMonitoringController::class, 'jurnalPiketDetail'])->name('jurnal-piket.detail');
    Route::post('/jurnal-piket-admin/{id}/update',        [AdminMonitoringController::class, 'jurnalPiketUpdate'])->name('jurnal-piket.update');
    Route::delete('/jurnal-piket-admin/{id}',             [AdminMonitoringController::class, 'jurnalPiketDestroy'])->name('jurnal-piket.destroy');
    Route::post('/jurnal-piket-admin/trash/{id}/restore',  [AdminMonitoringController::class, 'jurnalPiketRestore'])->name('jurnal-piket.restore');
    Route::match(['POST', 'DELETE'], '/jurnal-piket-admin/trash/{id}/force-delete', [AdminMonitoringController::class, 'jurnalPiketForceDelete'])->name('jurnal-piket.force-delete');

    // Monitoring Kehadiran Analytics
    Route::get('/monitoring-kehadiran',         [AdminMonitoringController::class, 'monitoringKehadiran'])->name('monitoring-kehadiran');

    // Manajemen Tahun Ajaran & Semester (Role TU)
    Route::get('/tahun-ajaran',                       [TahunAjaranController::class, 'index'])->name('tahun-ajaran.index');
    Route::post('/tahun-ajaran',                      [TahunAjaranController::class, 'store'])->name('tahun-ajaran.store');
    Route::get('/tahun-ajaran/export',                [TahunAjaranController::class, 'export'])->name('tahun-ajaran.export');
    Route::get('/tahun-ajaran/{id}',                  [TahunAjaranController::class, 'show'])->name('tahun-ajaran.show');
    Route::put('/tahun-ajaran/{id}',                  [TahunAjaranController::class, 'update'])->name('tahun-ajaran.update');
    Route::post('/tahun-ajaran/{id}/activate',        [TahunAjaranController::class, 'activate'])->name('tahun-ajaran.activate');
    Route::post('/tahun-ajaran/{id}/toggle-akses',    [TahunAjaranController::class, 'toggleAksesJurnal'])->name('tahun-ajaran.toggle-akses');
    Route::delete('/tahun-ajaran/destroy-batch',      [TahunAjaranController::class, 'destroyBatch'])->name('tahun-ajaran.destroy-batch');
    Route::delete('/tahun-ajaran/{id}',               [TahunAjaranController::class, 'destroy'])->name('tahun-ajaran.destroy');

    // Trash & Kotak Sampah Tahun Ajaran
    Route::get('/tahun-ajaran-trash',                 [TahunAjaranController::class, 'trash'])->name('tahun-ajaran.trash');
    Route::post('/tahun-ajaran-trash/{id}/restore',   [TahunAjaranController::class, 'restore'])->name('tahun-ajaran.restore');
    Route::post('/tahun-ajaran-trash/restore-batch',  [TahunAjaranController::class, 'restoreBatch'])->name('tahun-ajaran.restore-batch');
    Route::delete('/tahun-ajaran-trash/force-batch',  [TahunAjaranController::class, 'forceDeleteBatch'])->name('tahun-ajaran.force-delete-batch');
    Route::delete('/tahun-ajaran-trash/empty',        [TahunAjaranController::class, 'emptyTrash'])->name('tahun-ajaran.empty-trash');
    Route::delete('/tahun-ajaran-trash/{id}/force',   [TahunAjaranController::class, 'forceDelete'])->name('tahun-ajaran.force-delete');
});

// ─────────────────────────────────────────────────
// Authenticated Users (Multi-Role Routes)
// ─────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // ── Mode Masuk Ganda & Sakelar Peran Guru / Piket ──
    Route::get('/pilih-mode-masuk',           [AuthController::class, 'showPilihModeForm'])->name('auth.pilih-mode');
    Route::post('/switch-mode',                [AuthController::class, 'switchMode'])->name('auth.switch-mode');

    // ── Waka Portal ──
    Route::get('/waka/dashboard',             [WakaController::class, 'dashboard'])->name('waka.dashboard');
    Route::post('/waka/izin/{id}/approve',    [WakaController::class, 'approve'])->name('waka.izin.approve');
    Route::post('/waka/izin/{id}/reject',     [WakaController::class, 'reject'])->name('waka.izin.reject');
    Route::post('/waka/dispen/{id}/approve',  [WakaController::class, 'approveDispen'])->name('waka.dispen.approve');
    Route::post('/waka/dispen/{id}/reject',   [WakaController::class, 'rejectDispen'])->name('waka.dispen.reject');
    
    // Manajemen Data Siswa (Waka Kesiswaan)
    Route::get('/waka/siswa',                            [WakaController::class, 'siswa'])->name('waka.siswa');
    Route::post('/waka/siswa',                           [WakaController::class, 'storeSiswa'])->name('waka.siswa.store');
    Route::post('/waka/siswa/batch-store',               [WakaController::class, 'storeBatchSiswa'])->name('waka.siswa.batch-store');
    Route::get('/waka/siswa/download-template',          [WakaController::class, 'downloadTemplateSiswa'])->name('waka.siswa.download-template');
    Route::put('/waka/siswa/{id}',                       [WakaController::class, 'updateSiswa'])->name('waka.siswa.update');
    Route::delete('/waka/siswa/{id}',                    [WakaController::class, 'destroySiswa'])->name('waka.siswa.destroy');
    Route::post('/waka/siswa/batch-delete',              [WakaController::class, 'batchDeleteSiswa'])->name('waka.siswa.batch-delete');
    Route::get('/waka/siswa-trash',                      [WakaController::class, 'trashSiswa'])->name('waka.siswa.trash');
    Route::post('/waka/siswa-restore/{id}',              [WakaController::class, 'restoreSiswa'])->name('waka.siswa.restore');
    Route::post('/waka/siswa-batch-restore',             [WakaController::class, 'batchRestoreSiswa'])->name('waka.siswa.batch-restore');
    Route::delete('/waka/siswa-force-delete/{id}',       [WakaController::class, 'forceDeleteSiswa'])->name('waka.siswa.force-delete');
    Route::delete('/waka/siswa-empty-trash',             [WakaController::class, 'emptyTrashSiswa'])->name('waka.siswa.empty-trash');
    Route::post('/waka/siswa-trash/move-to-alumni-batch',[WakaController::class, 'moveToAlumniBatchSiswa'])->name('waka.siswa.move-to-alumni-batch');
    Route::post('/waka/siswa/{id}/move-to-alumni',       [WakaController::class, 'moveToAlumniSiswa'])->name('waka.siswa.move-to-alumni');
    Route::get('/waka/siswa-alumni',                     [WakaController::class, 'alumniSiswa'])->name('waka.siswa.alumni');
    Route::post('/waka/siswa-alumni/{id}/restore',       [WakaController::class, 'restoreFromAlumniSiswa'])->name('waka.siswa.restore-from-alumni');
    Route::post('/waka/siswa/{id}/toggle-active',        [WakaController::class, 'toggleActiveSiswa'])->name('waka.siswa.toggle-active');
    Route::get('/waka/siswa/{id}/detail',                [WakaController::class, 'detailSiswaJson'])->name('waka.siswa.detail');
    Route::get('/waka/siswa/export',                     [WakaController::class, 'exportSiswaCsv'])->name('waka.siswa.export');
    Route::get('/waka/siswa/print',                      [WakaController::class, 'printSiswa'])->name('waka.siswa.print');

    // Manajemen Jadwal Pelajaran (Waka Kesiswaan / Kurikulum)
    Route::get('/waka/jadwal',                      [WakaController::class, 'jadwal'])->name('waka.jadwal');
    Route::post('/waka/jadwal',                     [WakaController::class, 'storeJadwal'])->name('waka.jadwal.store');
    Route::post('/waka/jadwal/batch-store',         [WakaController::class, 'storeBatchJadwal'])->name('waka.jadwal.batch-store');
    Route::put('/waka/jadwal/{id}',                 [WakaController::class, 'updateJadwal'])->name('waka.jadwal.update');
    Route::delete('/waka/jadwal/{id}',              [WakaController::class, 'destroyJadwal'])->name('waka.jadwal.destroy');
    Route::post('/waka/jadwal/batch-delete',        [WakaController::class, 'batchDeleteJadwal'])->name('waka.jadwal.batch-delete');
    Route::get('/waka/jadwal-trash',                [WakaController::class, 'trashJadwal'])->name('waka.jadwal.trash');
    Route::post('/waka/jadwal-restore/{id}',        [WakaController::class, 'restoreJadwal'])->name('waka.jadwal.restore');
    Route::post('/waka/jadwal-batch-restore',       [WakaController::class, 'batchRestoreJadwal'])->name('waka.jadwal.batch-restore');
    Route::delete('/waka/jadwal-force-delete/{id}', [WakaController::class, 'forceDeleteJadwal'])->name('waka.jadwal.force-delete');
    Route::delete('/waka/jadwal-empty-trash',       [WakaController::class, 'emptyTrashJadwal'])->name('waka.jadwal.empty-trash');
    Route::get('/waka/jadwal/export',               [WakaController::class, 'exportJadwalCsv'])->name('waka.jadwal.export');
    Route::get('/waka/jadwal/print',                [WakaController::class, 'printJadwal'])->name('waka.jadwal.print');
    Route::get('/waka/jadwal/print-kelas/{id}',      [WakaController::class, 'printJadwalKelas'])->name('waka.jadwal.print-kelas');

    Route::get('/waka/persetujuan-izin',     [WakaController::class, 'persetujuanIzin'])->name('waka.persetujuan-izin');
    Route::get('/waka/rekap-jurnal',        [WakaController::class, 'rekapJurnal'])->name('waka.rekap-jurnal');
    Route::get('/waka/rekap-jurnal/export', [WakaController::class, 'exportRekapJurnal'])->name('waka.rekap-jurnal.export');
    Route::get('/waka/rekap-jurnal/print',  [WakaController::class, 'printRekapJurnal'])->name('waka.rekap-jurnal.print');
    Route::get('/waka/rekap-jurnal/{id}',   [WakaController::class, 'detailRekapJurnalJson'])->name('waka.rekap-jurnal.detail');
    Route::get('/waka/export-rekap',        [WakaController::class, 'exportRekapJurnal'])->name('waka.export-rekap');

    // Rekap Kehadiran Siswa (Waka Kesiswaan)
    Route::get('/waka/rekap-kehadiran',                  [WakaController::class, 'rekapKehadiranSiswa'])->name('waka.rekap-kehadiran');
    Route::get('/waka/rekap-kehadiran/export',           [WakaController::class, 'exportRekapKehadiranSiswa'])->name('waka.rekap-kehadiran.export');
    Route::get('/waka/rekap-kehadiran/print',            [WakaController::class, 'printRekapKehadiranSiswa'])->name('waka.rekap-kehadiran.print');
    Route::get('/waka/rekap-kehadiran/detail-siswa/{id}', [WakaController::class, 'detailPresensiSiswaJson'])->name('waka.rekap-kehadiran.detail-siswa');

    // Manajemen Pelanggaran Siswa (Waka Kesiswaan)
    Route::get('/waka/pelanggaran-siswa',                          [WakaController::class, 'pelanggaranSiswa'])->name('waka.pelanggaran-siswa');
    Route::post('/waka/pelanggaran-siswa',                         [WakaController::class, 'storePelanggaranSiswa'])->name('waka.pelanggaran-siswa.store');
    Route::put('/waka/pelanggaran-siswa/{id}',                     [WakaController::class, 'updatePelanggaranSiswa'])->name('waka.pelanggaran-siswa.update');
    Route::delete('/waka/pelanggaran-siswa/{id}',                  [WakaController::class, 'destroyPelanggaranSiswa'])->name('waka.pelanggaran-siswa.destroy');
    Route::post('/waka/pelanggaran-siswa/batch-delete',            [WakaController::class, 'batchDeletePelanggaranSiswa'])->name('waka.pelanggaran-siswa.batch-delete');
    Route::get('/waka/pelanggaran-siswa-trash',                    [WakaController::class, 'trashPelanggaranSiswa'])->name('waka.pelanggaran-siswa.trash');
    Route::post('/waka/pelanggaran-siswa-restore/{id}',            [WakaController::class, 'restorePelanggaranSiswa'])->name('waka.pelanggaran-siswa.restore');
    Route::post('/waka/pelanggaran-siswa-batch-restore',           [WakaController::class, 'batchRestorePelanggaranSiswa'])->name('waka.pelanggaran-siswa.batch-restore');
    Route::delete('/waka/pelanggaran-siswa-force-delete/{id}',     [WakaController::class, 'forceDeletePelanggaranSiswa'])->name('waka.pelanggaran-siswa.force-delete');
    Route::delete('/waka/pelanggaran-siswa-empty-trash',           [WakaController::class, 'emptyTrashPelanggaranSiswa'])->name('waka.pelanggaran-siswa.empty-trash');
    Route::get('/waka/pelanggaran-siswa/export',                   [WakaController::class, 'exportPelanggaranSiswaCsv'])->name('waka.pelanggaran-siswa.export');
    Route::get('/waka/pelanggaran-siswa/print',                    [WakaController::class, 'printPelanggaranSiswa'])->name('waka.pelanggaran-siswa.print');
    Route::get('/waka/pelanggaran-siswa/detail-json/{id}',         [WakaController::class, 'detailPelanggaranSiswaJson'])->name('waka.pelanggaran-siswa.detail-json');
    Route::post('/waka/pelanggaran-siswa/{id}/kirim-wa',           [WakaController::class, 'kirimWaPelanggaranSiswa'])->name('waka.pelanggaran-siswa.kirim-wa');

    // Manajemen Soft Delete & Trash Guru Izin (Waka)
    Route::delete('/waka/guru-izin/{id}',              [WakaController::class, 'destroyGuruIzin'])->name('waka.guru-izin.destroy');
    Route::post('/waka/guru-izin/batch-delete',        [WakaController::class, 'batchDeleteGuruIzin'])->name('waka.guru-izin.batch-delete');
    Route::get('/waka/guru-izin-trash',                [WakaController::class, 'trashGuruIzin'])->name('waka.guru-izin.trash');
    Route::post('/waka/guru-izin-restore/{id}',        [WakaController::class, 'restoreGuruIzin'])->name('waka.guru-izin.restore');
    Route::post('/waka/guru-izin-batch-restore',       [WakaController::class, 'batchRestoreGuruIzin'])->name('waka.guru-izin.batch-restore');
    Route::delete('/waka/guru-izin-force-delete/{id}', [WakaController::class, 'forceDeleteGuruIzin'])->name('waka.guru-izin.force-delete');
    Route::delete('/waka/guru-izin-empty-trash',       [WakaController::class, 'emptyTrashGuruIzin'])->name('waka.guru-izin.empty-trash');

    // Manajemen Soft Delete & Trash Siswa Dispen (Waka)
    Route::delete('/waka/siswa-dispen/{id}',              [WakaController::class, 'destroySiswaDispen'])->name('waka.siswa-dispen.destroy');
    Route::post('/waka/siswa-dispen/batch-delete',        [WakaController::class, 'batchDeleteSiswaDispen'])->name('waka.siswa-dispen.batch-delete');
    Route::get('/waka/siswa-dispen-trash',                [WakaController::class, 'trashSiswaDispen'])->name('waka.siswa-dispen.trash');
    Route::post('/waka/siswa-dispen-restore/{id}',        [WakaController::class, 'restoreSiswaDispen'])->name('waka.siswa-dispen.restore');
    Route::post('/waka/siswa-dispen-batch-restore',       [WakaController::class, 'batchRestoreSiswaDispen'])->name('waka.siswa-dispen.batch-restore');
    Route::delete('/waka/siswa-dispen-force-delete/{id}', [WakaController::class, 'forceDeleteSiswaDispen'])->name('waka.siswa-dispen.force-delete');
    Route::delete('/waka/siswa-dispen-empty-trash',       [WakaController::class, 'emptyTrashSiswaDispen'])->name('waka.siswa-dispen.empty-trash');

    // Manajemen Pengumuman Sekolah (Waka)
    Route::get('/waka/pengumuman',                      [WakaController::class, 'pengumuman'])->name('waka.pengumuman');
    Route::post('/waka/pengumuman',                     [WakaController::class, 'storePengumuman'])->name('waka.pengumuman.store');
    Route::put('/waka/pengumuman/{id}',                 [WakaController::class, 'updatePengumuman'])->name('waka.pengumuman.update');
    Route::delete('/waka/pengumuman/{id}',              [WakaController::class, 'destroyPengumuman'])->name('waka.pengumuman.destroy');
    Route::post('/waka/pengumuman-restore/{id}',        [WakaController::class, 'restorePengumuman'])->name('waka.pengumuman.restore');
    Route::delete('/waka/pengumuman-force-delete/{id}', [WakaController::class, 'forceDeletePengumuman'])->name('waka.pengumuman.force-delete');
    Route::delete('/waka/pengumuman-empty-trash',       [WakaController::class, 'emptyTrashPengumuman'])->name('waka.pengumuman.empty-trash');

    // ── Waka SDM Portal ──
    Route::prefix('waka-sdm')->name('waka-sdm.')->group(function () {
        Route::get('/dashboard',              [WakaSdmController::class, 'dashboard'])->name('dashboard');
        Route::get('/persetujuan-izin',      [WakaSdmController::class, 'persetujuanIzin'])->name('persetujuan-izin');
        Route::post('/izin/{id}/approve',     [WakaSdmController::class, 'approve'])->name('izin.approve');
        Route::post('/izin/{id}/reject',      [WakaSdmController::class, 'reject'])->name('izin.reject');
        
        // Soft delete & Trash Management Waka SDM
        Route::delete('/izin/{id}',               [WakaSdmController::class, 'destroy'])->name('izin.destroy');
        Route::post('/izin/batch-delete',         [WakaSdmController::class, 'batchDelete'])->name('izin.batch-delete');
        Route::get('/izin-trash',                 [WakaSdmController::class, 'trash'])->name('izin.trash');
        Route::post('/izin-restore/{id}',         [WakaSdmController::class, 'restore'])->name('izin.restore');
        Route::post('/izin-batch-restore',        [WakaSdmController::class, 'batchRestore'])->name('izin.batch-restore');
        Route::delete('/izin-force-delete/{id}',  [WakaSdmController::class, 'forceDelete'])->name('izin.force-delete');
        Route::delete('/izin-empty-trash',        [WakaSdmController::class, 'emptyTrash'])->name('izin.empty-trash');

        Route::get('/kehadiran-guru',        [WakaSdmController::class, 'kehadiranGuru'])->name('kehadiran-guru');
        Route::get('/kehadiran-guru/export', [WakaSdmController::class, 'exportKehadiran'])->name('kehadiran-guru.export');
        Route::get('/kehadiran-guru/print',  [WakaSdmController::class, 'printKehadiran'])->name('kehadiran-guru.print');
        Route::get('/data-guru',             [WakaSdmController::class, 'dataGuru'])->name('data-guru');
        Route::get('/data-guru/export',      [WakaSdmController::class, 'exportDataGuru'])->name('data-guru.export');
        Route::get('/data-guru/print',       [WakaSdmController::class, 'printDataGuru'])->name('data-guru.print');
        Route::get('/pengumuman',                  [WakaSdmController::class, 'pengumuman'])->name('pengumuman');
        Route::post('/pengumuman',                 [WakaSdmController::class, 'storePengumuman'])->name('pengumuman.store');
        Route::put('/pengumuman/{id}',             [WakaSdmController::class, 'updatePengumuman'])->name('pengumuman.update');
        Route::delete('/pengumuman/{id}',          [WakaSdmController::class, 'destroyPengumuman'])->name('pengumuman.destroy');
        Route::post('/pengumuman-restore/{id}',    [WakaSdmController::class, 'restorePengumuman'])->name('pengumuman.restore');
        Route::delete('/pengumuman-force/{id}',    [WakaSdmController::class, 'forceDeletePengumuman'])->name('pengumuman.force-delete');
        Route::delete('/pengumuman-empty-trash',   [WakaSdmController::class, 'emptyTrashPengumuman'])->name('pengumuman.empty-trash');
    });

    // ── Waka Kurikulum Portal ──
    Route::prefix('waka-kurikulum')->name('waka-kurikulum.')->group(function () {
        Route::get('/dashboard',              [WakaKurikulumController::class, 'dashboard'])->name('dashboard');
        
        // Persetujuan & Monitoring Permintaan Izin Guru (Waka Kurikulum)
        Route::get('/persetujuan-izin',            [WakaKurikulumController::class, 'persetujuanIzin'])->name('persetujuan-izin');
        Route::post('/izin/{id}/approve',          [WakaKurikulumController::class, 'approveIzin'])->name('izin.approve');
        Route::post('/izin/{id}/reject',           [WakaKurikulumController::class, 'rejectIzin'])->name('izin.reject');
        Route::post('/izin/batch-approve',         [WakaKurikulumController::class, 'batchApproveIzin'])->name('izin.batch-approve');
        Route::get('/izin/{id}/detail-json',       [WakaKurikulumController::class, 'detailIzinJson'])->name('izin.detail-json');
        Route::delete('/izin/{id}',                [WakaKurikulumController::class, 'destroyIzin'])->name('izin.destroy');
        Route::match(['POST', 'DELETE'], '/izin/batch-delete', [WakaKurikulumController::class, 'batchDeleteIzin'])->name('izin.batch-delete');
        Route::get('/persetujuan-izin-trash',      [WakaKurikulumController::class, 'trashIzin'])->name('persetujuan-izin.trash');
        Route::post('/izin-restore/{id}',          [WakaKurikulumController::class, 'restoreIzin'])->name('izin.restore');
        Route::post('/izin-batch-restore',         [WakaKurikulumController::class, 'batchRestoreIzin'])->name('izin.batch-restore');
        Route::delete('/izin-force/{id}',          [WakaKurikulumController::class, 'forceDeleteIzin'])->name('izin.force-delete');
        Route::delete('/izin-empty-trash',         [WakaKurikulumController::class, 'emptyTrashIzin'])->name('izin.empty-trash');
        Route::get('/guru-izin-tidak-hadir',       [WakaKurikulumController::class, 'persetujuanIzin'])->name('guru-izin-tidak-hadir');
        
        // Master Jadwal Pelajaran (Full Management)
        Route::get('/jadwal',                      [WakaKurikulumController::class, 'jadwal'])->name('jadwal');
        Route::post('/jadwal',                     [WakaKurikulumController::class, 'storeJadwal'])->name('jadwal.store');
        Route::post('/jadwal/batch-store',         [WakaKurikulumController::class, 'storeBatchJadwal'])->name('jadwal.batch-store');
        Route::put('/jadwal/{id}',                 [WakaKurikulumController::class, 'updateJadwal'])->name('jadwal.update');
        Route::delete('/jadwal/{id}',              [WakaKurikulumController::class, 'destroyJadwal'])->name('jadwal.destroy');
        Route::post('/jadwal/batch-delete',        [WakaKurikulumController::class, 'batchDeleteJadwal'])->name('jadwal.batch-delete');
        Route::get('/jadwal-trash',                [WakaKurikulumController::class, 'trashJadwal'])->name('jadwal.trash');
        Route::post('/jadwal-restore/{id}',        [WakaKurikulumController::class, 'restoreJadwal'])->name('jadwal.restore');
        Route::post('/jadwal-batch-restore',       [WakaKurikulumController::class, 'batchRestoreJadwal'])->name('jadwal.batch-restore');
        Route::delete('/jadwal-force-delete/{id}', [WakaKurikulumController::class, 'forceDeleteJadwal'])->name('jadwal.force-delete');
        Route::delete('/jadwal-empty-trash',       [WakaKurikulumController::class, 'emptyTrashJadwal'])->name('jadwal.empty-trash');
        Route::get('/jadwal/export',               [WakaKurikulumController::class, 'exportJadwalCsv'])->name('jadwal.export');
        Route::get('/jadwal/print',                [WakaKurikulumController::class, 'printJadwal'])->name('jadwal.print');
        Route::get('/jadwal/print-kelas/{id}',      [WakaKurikulumController::class, 'printJadwalKelas'])->name('jadwal.print-kelas');

        // Master Jadwal Guru Piket (Waka Kurikulum)
        Route::get('/jadwal-piket',                [WakaKurikulumController::class, 'jadwalPiket'])->name('jadwal-piket');
        Route::post('/jadwal-piket',               [WakaKurikulumController::class, 'simpanJadwalPiket'])->name('jadwal-piket.store');
        Route::post('/jadwal-piket/import',        [WakaKurikulumController::class, 'importJadwalPiket'])->name('jadwal-piket.import');
        Route::get('/jadwal-piket/export',         [WakaKurikulumController::class, 'exportJadwalPiket'])->name('jadwal-piket.export');
        Route::get('/jadwal-piket/print',          [WakaKurikulumController::class, 'printJadwalPiket'])->name('jadwal-piket.print');

        // Redirect mapel to dashboard (page removed per user request)
        Route::redirect('/mapel', '/waka-kurikulum/dashboard')->name('mapel');

        // Monitoring & Rekap Jurnal Mengajar KBM
        Route::get('/rekap-jurnal',                [WakaKurikulumController::class, 'rekapJurnal'])->name('rekap-jurnal');
        Route::get('/rekap-jurnal/export',         [WakaKurikulumController::class, 'exportRekapJurnal'])->name('rekap-jurnal.export');
        Route::get('/rekap-jurnal/print',          [WakaKurikulumController::class, 'printRekapJurnal'])->name('rekap-jurnal.print');
        Route::get('/rekap-jurnal/{id}',           [WakaKurikulumController::class, 'detailRekapJurnalJson'])->name('rekap-jurnal.detail');

        // Alokasi Jam Pelajaran
        Route::get('/jam-pelajaran',               [WakaKurikulumController::class, 'jamPelajaran'])->name('jam-pelajaran');
        Route::put('/jam-pelajaran/{id}',          [WakaKurikulumController::class, 'updateJamPelajaran'])->name('jam-pelajaran.update');
        Route::get('/jam-pelajaran/export',         [WakaKurikulumController::class, 'exportJamPelajaranCsv'])->name('jam-pelajaran.export');
        Route::get('/jam-pelajaran/print',          [WakaKurikulumController::class, 'printJamPelajaran'])->name('jam-pelajaran.print');

        // Pengumuman Kurikulum & Akademik
        Route::get('/pengumuman',                  [WakaKurikulumController::class, 'pengumuman'])->name('pengumuman');
        Route::post('/pengumuman',                 [WakaKurikulumController::class, 'storePengumuman'])->name('pengumuman.store');
        Route::get('/pengumuman/{id}/detail-json', [WakaKurikulumController::class, 'detailPengumumanJson'])->name('pengumuman.detail-json');
        Route::put('/pengumuman/{id}',             [WakaKurikulumController::class, 'updatePengumuman'])->name('pengumuman.update');
        Route::delete('/pengumuman/{id}',          [WakaKurikulumController::class, 'destroyPengumuman'])->name('pengumuman.destroy');
        Route::post('/pengumuman/batch-delete',    [WakaKurikulumController::class, 'batchDeletePengumuman'])->name('pengumuman.batch-delete');
        Route::post('/pengumuman-restore/{id}',    [WakaKurikulumController::class, 'restorePengumuman'])->name('pengumuman.restore');
        Route::post('/pengumuman/batch-restore',   [WakaKurikulumController::class, 'batchRestorePengumuman'])->name('pengumuman.batch-restore');
        Route::delete('/pengumuman-force/{id}',    [WakaKurikulumController::class, 'forceDeletePengumuman'])->name('pengumuman.force-delete');
        Route::delete('/pengumuman-empty-trash',   [WakaKurikulumController::class, 'emptyTrashPengumuman'])->name('pengumuman.empty-trash');
    });

    // ── Kepala Sekolah Portal ──
    Route::prefix('kepala-sekolah')->name('kepala-sekolah.')->group(function () {
        Route::get('/dashboard',              [KepalaSekolahController::class, 'dashboard'])->name('dashboard');
        Route::get('/persetujuan-izin',       [KepalaSekolahController::class, 'persetujuanIzin'])->name('persetujuan-izin');
        Route::post('/izin/{id}/approve',     [KepalaSekolahController::class, 'approve'])->name('izin.approve');
        Route::post('/izin/{id}/reject',      [KepalaSekolahController::class, 'reject'])->name('izin.reject');
        Route::post('/dispen/{id}/approve',   [KepalaSekolahController::class, 'approveDispen'])->name('dispen.approve');
        Route::post('/dispen/{id}/reject',    [KepalaSekolahController::class, 'rejectDispen'])->name('dispen.reject');
        
        Route::redirect('/kehadiran-guru', '/kepala-sekolah/persetujuan-izin')->name('kehadiran-guru');
        Route::get('/kehadiran-siswa',         [KepalaSekolahController::class, 'kehadiranSiswa'])->name('kehadiran-siswa');
        Route::get('/siswa-izin',              [KepalaSekolahController::class, 'siswaIzin'])->name('siswa-izin');
        Route::get('/jurnal-pembelajaran',             [KepalaSekolahController::class, 'jurnalPembelajaran'])->name('jurnal-pembelajaran');
        Route::get('/jurnal-pembelajaran/export',      [KepalaSekolahController::class, 'exportJurnalCsv'])->name('jurnal-pembelajaran.export');
        Route::get('/jurnal-pembelajaran/print',       [KepalaSekolahController::class, 'printJurnal'])->name('jurnal-pembelajaran.print');
        Route::get('/jurnal-pembelajaran/cetak-harian', [KepalaSekolahController::class, 'cetakJurnalHarian'])->name('jurnal-pembelajaran.cetak-harian');
        Route::get('/laporan',                 [KepalaSekolahController::class, 'laporan'])->name('laporan');
        Route::get('/laporan/export',          [KepalaSekolahController::class, 'exportLaporanCsv'])->name('laporan.export');
        Route::get('/laporan/print',           [KepalaSekolahController::class, 'printLaporan'])->name('laporan.print');
        Route::get('/guru-izin-tidak-hadir',                 [KepalaSekolahController::class, 'guruIzinTidakHadir'])->name('guru-izin-tidak-hadir');
        Route::delete('/guru-izin-tidak-hadir/{id}',         [KepalaSekolahController::class, 'destroyGuruIzin'])->name('guru-izin-tidak-hadir.destroy');
        Route::post('/guru-izin-tidak-hadir/bulk-delete',    [KepalaSekolahController::class, 'bulkDeleteGuruIzin'])->name('guru-izin-tidak-hadir.bulk-delete');
        Route::get('/guru-izin-tidak-hadir/trash',           [KepalaSekolahController::class, 'trashGuruIzin'])->name('guru-izin-tidak-hadir.trash');
        Route::post('/guru-izin-tidak-hadir/{id}/restore',   [KepalaSekolahController::class, 'restoreGuruIzin'])->name('guru-izin-tidak-hadir.restore');
        Route::post('/guru-izin-tidak-hadir/batch-restore',  [KepalaSekolahController::class, 'batchRestoreGuruIzin'])->name('guru-izin-tidak-hadir.batch-restore');
        Route::delete('/guru-izin-tidak-hadir/{id}/force',   [KepalaSekolahController::class, 'forceDeleteGuruIzin'])->name('guru-izin-tidak-hadir.force-delete');
        Route::delete('/guru-izin-tidak-hadir/empty-trash',  [KepalaSekolahController::class, 'emptyTrashGuruIzin'])->name('guru-izin-tidak-hadir.empty-trash');
    });

    // ── Satpam Portal ──
    Route::get('/satpam/dashboard',           [SatpamController::class, 'dashboard'])->name('satpam.dashboard');
    Route::get('/satpam/validasi',            [SatpamController::class, 'validasi'])->name('satpam.validasi');
    Route::get('/satpam/log-aktivitas',       [SatpamController::class, 'logAktivitas'])->name('satpam.log-aktivitas');
    Route::get('/satpam/lapor-siswa',         [SatpamController::class, 'laporSiswa'])->name('satpam.lapor-siswa');
    Route::get('/satpam/api/siswa-lapor/{id_siswa}', [SatpamController::class, 'getSiswaLaporDetails'])->name('satpam.api-siswa-lapor');
    Route::post('/satpam/lapor-siswa',        [SatpamController::class, 'storeLaporSiswa'])->name('satpam.store-lapor-siswa');
    Route::delete('/satpam/lapor-siswa/{id}', [SatpamController::class, 'destroyLaporSiswa'])->name('satpam.destroy-lapor-siswa');
    Route::post('/satpam/search',             [SatpamController::class, 'search'])->name('satpam.search');
    Route::post('/satpam/update-status/{id}', [SatpamController::class, 'updateStatus'])->name('satpam.update-status');
    Route::get('/satpam/api/live-dispen',     [SatpamController::class, 'livePoll'])->name('satpam.live-poll');

    // ── Dedicated Guru Piket Portal ──
    Route::prefix('guru-piket')->name('piket.')->group(function () {
        Route::get('/dashboard',              [GuruPiketController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengumuman',             [GuruPortalController::class, 'pengumuman'])->name('pengumuman');
        Route::get('/jurnal-mengajar',                   [GuruPiketController::class, 'jurnalMengajar'])->name('jurnal-mengajar');
        Route::get('/jurnal-mengajar/export',            [GuruPiketController::class, 'exportJurnalMengajarCsv'])->name('jurnal-mengajar.export');
        Route::get('/jurnal-mengajar/detail/{id}',       [GuruPiketController::class, 'detailJurnalMengajar'])->name('jurnal-mengajar.detail');
        Route::post('/jurnal-mengajar/tanda-tangan',     [GuruPiketController::class, 'simpanTandaTanganPiket'])->name('jurnal-mengajar.tanda-tangan');
        Route::post('/jurnal-mengajar/batal-tanda-tangan',[GuruPiketController::class, 'batalTandaTanganPiket'])->name('jurnal-mengajar.batal-tanda-tangan');
        Route::get('/jurnal-mengajar/cetak-harian',      [GuruPiketController::class, 'cetakRekapHarian'])->name('jurnal-mengajar.cetak-harian');
        Route::get('/guru-pengganti',                  [GuruPiketController::class, 'guruPengganti'])->name('guru-pengganti');
        Route::post('/guru-pengganti',                 [GuruPiketController::class, 'storeGuruPengganti'])->name('guru-pengganti.store');
        Route::put('/guru-pengganti/{id}',             [GuruPiketController::class, 'updateGuruPengganti'])->name('guru-pengganti.update');
        Route::delete('/guru-pengganti/{id}',          [GuruPiketController::class, 'destroyGuruPengganti'])->name('guru-pengganti.destroy');
        Route::delete('/guru-pengganti-bulk-delete',   [GuruPiketController::class, 'bulkDestroyGuruPengganti'])->name('guru-pengganti.bulk-delete');
        Route::get('/guru-pengganti/jadwal-guru',      [GuruPiketController::class, 'getJadwalGuruTidakHadir'])->name('guru-pengganti.jadwal-guru');
        Route::get('/guru-pengganti/piket-date',       [GuruPiketController::class, 'getPiketGuruByDate'])->name('guru-pengganti.piket-date');
        Route::post('/guru-pengganti/{id}/restore',    [GuruPiketController::class, 'restoreGuruPengganti'])->name('guru-pengganti.restore');
        Route::delete('/guru-pengganti/{id}/force',    [GuruPiketController::class, 'forceDeleteGuruPengganti'])->name('guru-pengganti.force-delete');
        Route::delete('/guru-pengganti-empty-trash',   [GuruPiketController::class, 'emptyTrashGuruPengganti'])->name('guru-pengganti.empty-trash');
        Route::get('/jadwal-hari-ini',        [GuruPiketController::class, 'jadwalHariIni'])->name('jadwal');
        Route::get('/rekap-kehadiran',        [GuruPiketController::class, 'rekapKehadiran'])->name('rekap-kehadiran');
        Route::get('/rekap-kehadiran/export', [GuruPiketController::class, 'exportRekapKehadiranCsv'])->name('rekap-kehadiran.export');
        Route::get('/rekap-kehadiran/print',  [GuruPiketController::class, 'printRekapKehadiran'])->name('rekap-kehadiran.print');
        // Fitur Pengisian Jurnal & Presensi untuk Guru Piket sebagai Guru Pengganti
        Route::get('/isi-jurnal-pengganti',   [GuruPiketController::class, 'isiJurnalPengganti'])->name('isi-jurnal-pengganti');
        Route::post('/isi-jurnal-pengganti',  [GuruPiketController::class, 'simpanJurnalPengganti'])->name('isi-jurnal-pengganti.store');
        // Fitur Permintaan Izin Guru (Guru Piket)
        Route::get('/permintaan-izin',                       [GuruPiketController::class, 'permintaanIzin'])->name('permintaan-izin');
        Route::post('/permintaan-izin',                      [GuruPiketController::class, 'storePermintaanIzin'])->name('permintaan-izin.store');
        Route::put('/permintaan-izin/{id}',                  [GuruPiketController::class, 'updatePermintaanIzin'])->name('permintaan-izin.update');
        Route::delete('/permintaan-izin/{id}',               [GuruPiketController::class, 'destroyPermintaanIzin'])->name('permintaan-izin.destroy');
        Route::delete('/permintaan-izin-bulk-delete',        [GuruPiketController::class, 'bulkDestroyPermintaanIzin'])->name('permintaan-izin.bulk-delete');
        Route::get('/permintaan-izin-trash',                 [GuruPiketController::class, 'trashPermintaanIzin'])->name('permintaan-izin.trash');
        Route::post('/permintaan-izin-trash/{id}/restore',   [GuruPiketController::class, 'restorePermintaanIzin'])->name('permintaan-izin.restore');
        Route::delete('/permintaan-izin-trash/{id}/force',   [GuruPiketController::class, 'forceDeletePermintaanIzin'])->name('permintaan-izin.force-delete');
        Route::delete('/permintaan-izin-empty-trash',        [GuruPiketController::class, 'emptyTrashPermintaanIzin'])->name('permintaan-izin.empty-trash');
        // Fitur Halaman Guru Izin Tidak Hadir (Resmi Disetujui Waka & Kepsek)
        Route::get('/guru-izin-tidak-hadir',                       [GuruPiketController::class, 'guruIzinTidakHadir'])->name('guru-izin-tidak-hadir');
        Route::delete('/guru-izin-tidak-hadir/{id}',               [GuruPiketController::class, 'destroyGuruIzinTidakHadir'])->name('guru-izin-tidak-hadir.destroy');
        Route::delete('/guru-izin-tidak-hadir-bulk-delete',        [GuruPiketController::class, 'bulkDestroyGuruIzinTidakHadir'])->name('guru-izin-tidak-hadir.bulk-delete');
        Route::get('/guru-izin-tidak-hadir-trash',                 [GuruPiketController::class, 'trashGuruIzinTidakHadir'])->name('guru-izin-tidak-hadir.trash');
        Route::post('/guru-izin-tidak-hadir-trash/{id}/restore',   [GuruPiketController::class, 'restoreGuruIzinTidakHadir'])->name('guru-izin-tidak-hadir.restore');
        Route::delete('/guru-izin-tidak-hadir-trash/{id}/force',   [GuruPiketController::class, 'forceDeleteGuruIzinTidakHadir'])->name('guru-izin-tidak-hadir.force-delete');
        Route::delete('/guru-izin-tidak-hadir-empty-trash',        [GuruPiketController::class, 'emptyTrashGuruIzinTidakHadir'])->name('guru-izin-tidak-hadir.empty-trash');

        // Fitur Dispensasi Siswa (Guru Piket)
        Route::get('/dispensasi-siswa',                       [GuruPiketController::class, 'dispensasiSiswa'])->name('dispensasi-siswa');
        Route::post('/dispensasi-siswa',                      [GuruPiketController::class, 'storeDispensasiSiswa'])->name('dispensasi-siswa.store');
        Route::put('/dispensasi-siswa/{id}',                  [GuruPiketController::class, 'updateDispensasiSiswa'])->name('dispensasi-siswa.update');
        Route::delete('/dispensasi-siswa/{id}',               [GuruPiketController::class, 'destroyDispensasiSiswa'])->name('dispensasi-siswa.destroy');
        Route::delete('/dispensasi-siswa-bulk-delete',        [GuruPiketController::class, 'bulkDestroyDispensasiSiswa'])->name('dispensasi-siswa.bulk-delete');
        Route::get('/dispensasi-siswa-trash',                 [GuruPiketController::class, 'trashDispensasiSiswa'])->name('dispensasi-siswa.trash');
        Route::post('/dispensasi-siswa-trash/{id}/restore',   [GuruPiketController::class, 'restoreDispensasiSiswa'])->name('dispensasi-siswa.restore');
        Route::delete('/dispensasi-siswa-trash/{id}/force',   [GuruPiketController::class, 'forceDeleteDispensasiSiswa'])->name('dispensasi-siswa.force-delete');
        Route::delete('/dispensasi-siswa-empty-trash',        [GuruPiketController::class, 'emptyTrashDispensasiSiswa'])->name('dispensasi-siswa.empty-trash');

        // Fitur Surat Izin Siswa (Guru Piket)
        Route::get('/surat-izin-siswa',                       [GuruPiketController::class, 'suratIzinSiswa'])->name('surat-izin-siswa');
        Route::post('/surat-izin-siswa',                      [GuruPiketController::class, 'storeSuratIzinSiswa'])->name('surat-izin-siswa.store');
        Route::put('/surat-izin-siswa/{id}',                  [GuruPiketController::class, 'updateSuratIzinSiswa'])->name('surat-izin-siswa.update');
        Route::delete('/surat-izin-siswa/{id}',               [GuruPiketController::class, 'destroySuratIzinSiswa'])->name('surat-izin-siswa.destroy');
        Route::delete('/surat-izin-siswa-bulk-delete',        [GuruPiketController::class, 'bulkDestroySuratIzinSiswa'])->name('surat-izin-siswa.bulk-delete');
        Route::get('/surat-izin-siswa-trash',                 [GuruPiketController::class, 'trashSuratIzinSiswa'])->name('surat-izin-siswa.trash');
        Route::post('/surat-izin-siswa-trash/{id}/restore',   [GuruPiketController::class, 'restoreSuratIzinSiswa'])->name('surat-izin-siswa.restore');
        Route::delete('/surat-izin-siswa-trash/{id}/force',   [GuruPiketController::class, 'forceDeleteSuratIzinSiswa'])->name('surat-izin-siswa.force-delete');
        Route::delete('/surat-izin-siswa-empty-trash',        [GuruPiketController::class, 'emptyTrashSuratIzinSiswa'])->name('surat-izin-siswa.empty-trash');

        // Fitur Siswa Telat (Guru Piket)
        Route::get('/siswa-telat',                            [GuruPiketController::class, 'siswaTelat'])->name('siswa-telat');
        Route::post('/siswa-telat',                           [GuruPiketController::class, 'storeSiswaTelat'])->name('siswa-telat.store');
        Route::put('/siswa-telat/{id}',                       [GuruPiketController::class, 'updateSiswaTelat'])->name('siswa-telat.update');
        Route::delete('/siswa-telat/destroy-batch',           [GuruPiketController::class, 'destroyBatchSiswaTelat'])->name('siswa-telat.destroy-batch');
        Route::delete('/siswa-telat/{id}',                    [GuruPiketController::class, 'destroySiswaTelat'])->name('siswa-telat.destroy');
        Route::get('/siswa-telat-trash',                      [GuruPiketController::class, 'trashSiswaTelat'])->name('siswa-telat.trash');
        Route::post('/siswa-telat-trash/{id}/restore',        [GuruPiketController::class, 'restoreSiswaTelat'])->name('siswa-telat.restore');
        Route::delete('/siswa-telat-trash/{id}/force',        [GuruPiketController::class, 'forceDeleteSiswaTelat'])->name('siswa-telat.force-delete');
        Route::delete('/siswa-telat-empty-trash',             [GuruPiketController::class, 'emptyTrashSiswaTelat'])->name('siswa-telat.empty-trash');
        Route::get('/api/siswa-schedule-guru/{id_siswa}',     [GuruPiketController::class, 'getSiswaScheduleAndGuru'])->name('siswa-telat.api-schedule-guru');
    });

    // ── Orang Tua Portal ──
    Route::get('/orang-tua/dashboard',           [OrangTuaController::class, 'dashboard'])->name('orang-tua.dashboard');
    Route::get('/orang-tua/monitoring-presensi', [OrangTuaController::class, 'monitoringPresensi'])->name('orang-tua.monitoring-presensi');
    Route::get('/orang-tua/api/monitoring-presensi', [OrangTuaController::class, 'apiMonitoringPresensi'])->name('orang-tua.api-monitoring-presensi');
    Route::get('/orang-tua/data-anak',           [OrangTuaController::class, 'dataAnak'])->name('orang-tua.data-anak');
    Route::get('/orang-tua/izin',                [OrangTuaController::class, 'izin'])->name('orang-tua.izin');
    Route::post('/orang-tua/izin',               [OrangTuaController::class, 'storeIzin'])->name('orang-tua.store-izin');
    Route::get('/orang-tua/laporan',             [OrangTuaController::class, 'laporan'])->name('orang-tua.laporan');

    // ── Portal Guru, Wali Kelas & Piket ──
    Route::get('/guru-dashboard',       [GuruPortalController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/guru-pengumuman',                            [GuruPortalController::class, 'pengumuman'])->name('guru.pengumuman');
    Route::post('/guru-pengumuman/mark-all-read',             [GuruPortalController::class, 'markAllPengumumanRead'])->name('guru.pengumuman.mark-all-read');
    Route::post('/guru-pengumuman/{id}/mark-read',            [GuruPortalController::class, 'markPengumumanRead'])->name('guru.pengumuman.mark-read');
    Route::post('/guru-pengumuman/{id}/toggle-read',          [GuruPortalController::class, 'togglePengumumanRead'])->name('guru.pengumuman.toggle-read');
    Route::delete('/guru-pengumuman/destroy-batch',           [GuruPortalController::class, 'destroyBatchPengumuman'])->name('guru.pengumuman.destroy-batch');
    Route::delete('/guru-pengumuman/{id}',                    [GuruPortalController::class, 'destroyPengumuman'])->name('guru.pengumuman.destroy');
    Route::get('/guru-pengumuman-trash',                      [GuruPortalController::class, 'trashPengumuman'])->name('guru.pengumuman.trash');
    Route::post('/guru-pengumuman-trash/{id}/restore',        [GuruPortalController::class, 'restorePengumuman'])->name('guru.pengumuman.restore');
    Route::delete('/guru-pengumuman-trash/{id}/force',        [GuruPortalController::class, 'forceDeletePengumuman'])->name('guru.pengumuman.force-delete');
    Route::get('/guru-jadwal',          [GuruPortalController::class, 'jadwalMengajar'])->name('guru.jadwal');
    Route::get('/guru-jadwal/export',   [GuruPortalController::class, 'exportJadwalCsv'])->name('guru.jadwal.export');
    Route::get('/guru-jadwal/print',    [GuruPortalController::class, 'printJadwal'])->name('guru.jadwal.print');
    Route::get('/guru-jurnal-harian',             [GuruPortalController::class, 'jurnalHarian'])->name('guru.jurnal-harian');
    Route::get('/guru-jurnal-detail/{id}',        [GuruPortalController::class, 'detailJurnalJson'])->name('guru.jurnal-detail-json');
    Route::post('/guru-jurnal-harian',            [GuruPortalController::class, 'simpanJurnalHarian'])->name('guru.jurnal-harian.store');
    Route::post('/guru-jurnal-harian/batal-kirim', [GuruPortalController::class, 'batalKirimJurnal'])->name('guru.jurnal-harian.batal-kirim');
    Route::get('/guru-absensi-siswa',                         [GuruPortalController::class, 'absensiSiswa'])->name('guru.absensi-siswa');
    Route::post('/guru-absensi-siswa',                        [GuruPortalController::class, 'simpanPresensiSiswa'])->name('guru.absensi-siswa.store');
    Route::get('/guru-nilai-siswa',                           [GuruPortalController::class, 'nilaiRapor'])->name('guru.nilai-rapor');
    Route::get('/guru-nilai-rapor',                           function() { return redirect()->route('guru.nilai-rapor'); });
    Route::post('/guru-nilai-siswa',                          [GuruPortalController::class, 'simpanNilai'])->name('guru.nilai-rapor.store');
    Route::get('/guru-nilai-siswa/export',                    [GuruPortalController::class, 'exportNilaiCsv'])->name('guru.nilai-rapor.export');
    Route::get('/guru-nilai-siswa/print',                     [GuruPortalController::class, 'printNilai'])->name('guru.nilai-rapor.print');
    Route::get('/guru-riwayat-jurnal',                        [GuruPortalController::class, 'riwayatJurnal'])->name('guru.riwayat-jurnal');
    Route::delete('/guru-riwayat-jurnal/{id}',                [GuruPortalController::class, 'destroyRiwayatJurnal'])->name('guru.riwayat-jurnal.destroy');
    Route::delete('/guru-riwayat-jurnal-batch/destroy',       [GuruPortalController::class, 'destroyBatchRiwayatJurnal'])->name('guru.riwayat-jurnal.destroy-batch');
    Route::get('/guru-riwayat-jurnal-trash',                  [GuruPortalController::class, 'trashRiwayatJurnal'])->name('guru.riwayat-jurnal.trash');
    Route::post('/guru-riwayat-jurnal-trash/{id}/restore',    [GuruPortalController::class, 'restoreRiwayatJurnal'])->name('guru.riwayat-jurnal.restore');
    Route::post('/guru-riwayat-jurnal-trash/restore-batch',   [GuruPortalController::class, 'restoreBatchRiwayatJurnal'])->name('guru.riwayat-jurnal.restore-batch');
    Route::post('/guru-riwayat-jurnal-trash/restore-all',     [GuruPortalController::class, 'restoreAllRiwayatJurnal'])->name('guru.riwayat-jurnal.restore-all');
    Route::delete('/guru-riwayat-jurnal-trash/{id}/force',    [GuruPortalController::class, 'forceDeleteRiwayatJurnal'])->name('guru.riwayat-jurnal.force-delete');
    Route::delete('/guru-riwayat-jurnal-trash/force-batch',   [GuruPortalController::class, 'forceDeleteBatchRiwayatJurnal'])->name('guru.riwayat-jurnal.force-delete-batch');
    Route::delete('/guru-riwayat-jurnal-empty-trash',         [GuruPortalController::class, 'emptyTrashRiwayatJurnal'])->name('guru.riwayat-jurnal.empty-trash');
    Route::get('/guru-kehadiran-kelas', [GuruPortalController::class, 'kehadiranKelas'])->name('guru.kehadiran-kelas');
    Route::get('/guru-kehadiran-harian-detail', [GuruPortalController::class, 'detailKehadiranHarianJson'])->name('guru.kehadiran-harian-detail-json');
    Route::get('/guru-siswa-detail/{id}', [GuruPortalController::class, 'detailSiswaWaliJson'])->name('guru.siswa-detail-json');
    
    // Manajemen Surat Izin / Sakit Siswa (Role Wali Kelas)
    Route::delete('/guru-surat-izin/{id}',                  [GuruPortalController::class, 'destroySuratIzinWali'])->name('guru.surat-izin.destroy');
    Route::delete('/guru-surat-izin-batch/destroy',         [GuruPortalController::class, 'destroyBatchSuratIzinWali'])->name('guru.surat-izin.destroy-batch');
    Route::get('/guru-surat-izin-trash',                    [GuruPortalController::class, 'trashSuratIzinWali'])->name('guru.surat-izin.trash');
    Route::post('/guru-surat-izin-trash/{id}/restore',      [GuruPortalController::class, 'restoreSuratIzinWali'])->name('guru.surat-izin.restore');
    Route::post('/guru-surat-izin-trash/restore-batch',     [GuruPortalController::class, 'restoreBatchSuratIzinWali'])->name('guru.surat-izin.restore-batch');
    Route::post('/guru-surat-izin-trash/restore-all',       [GuruPortalController::class, 'restoreAllSuratIzinWali'])->name('guru.surat-izin.restore-all');
    Route::delete('/guru-surat-izin-trash/{id}/force',      [GuruPortalController::class, 'forceDeleteSuratIzinWali'])->name('guru.surat-izin.force-delete');
    Route::delete('/guru-surat-izin-trash/force-batch',     [GuruPortalController::class, 'forceDeleteBatchSuratIzinWali'])->name('guru.surat-izin.force-delete-batch');
    Route::delete('/guru-surat-izin-empty-trash',           [GuruPortalController::class, 'emptyTrashSuratIzinWali'])->name('guru.surat-izin.empty-trash');
    Route::get('/guru-surat-izin-detail/{id}',              [GuruPortalController::class, 'detailSuratIzinWaliJson'])->name('guru.surat-izin.detail-json');

    Route::get('/guru-surat-dispen',                          [GuruPortalController::class, 'suratDispen'])->name('guru.surat-dispen');
    Route::delete('/guru-surat-dispen/{id}',                  [GuruPortalController::class, 'destroySuratDispen'])->name('guru.surat-dispen.destroy');
    Route::delete('/guru-surat-dispen-batch/destroy',         [GuruPortalController::class, 'destroyBatchSuratDispen'])->name('guru.surat-dispen.destroy-batch');
    Route::get('/guru-surat-dispen-trash',                    [GuruPortalController::class, 'trashSuratDispen'])->name('guru.surat-dispen.trash');
    Route::post('/guru-surat-dispen-trash/{id}/restore',      [GuruPortalController::class, 'restoreSuratDispen'])->name('guru.surat-dispen.restore');
    Route::post('/guru-surat-dispen-trash/restore-batch',     [GuruPortalController::class, 'restoreBatchSuratDispen'])->name('guru.surat-dispen.restore-batch');
    Route::post('/guru-surat-dispen-trash/restore-all',       [GuruPortalController::class, 'restoreAllSuratDispen'])->name('guru.surat-dispen.restore-all');
    Route::delete('/guru-surat-dispen-trash/{id}/force',      [GuruPortalController::class, 'forceDeleteSuratDispen'])->name('guru.surat-dispen.force-delete');
    Route::delete('/guru-surat-dispen-trash/force-batch',     [GuruPortalController::class, 'forceDeleteBatchSuratDispen'])->name('guru.surat-dispen.force-delete-batch');
    Route::delete('/guru-surat-dispen-empty-trash',           [GuruPortalController::class, 'emptyTrashSuratDispen'])->name('guru.surat-dispen.empty-trash');
    Route::get('/guru-surat-dispen/{id}/cetak',               [GuruPortalController::class, 'cetakSuratDispen'])->name('guru.surat-dispen.cetak');
    Route::get('/guru-surat-dispen-detail/{id}',              [GuruPortalController::class, 'detailSuratDispenWaliJson'])->name('guru.surat-dispen.detail-json');
    Route::post('/guru-surat-dispen/{id}/mark-read',          [GuruPortalController::class, 'markSuratDispenRead'])->name('guru.surat-dispen.mark-read');
    Route::post('/guru-surat-dispen/mark-all-read',           [GuruPortalController::class, 'markAllSuratDispenRead'])->name('guru.surat-dispen.mark-all-read');
    Route::get('/guru-export-rekap-csv', [GuruPortalController::class, 'exportRekapCsv'])->name('guru.export-rekap-csv');
    Route::get('/guru-permintaan-izin',                       [GuruPortalController::class, 'permintaanIzin'])->name('guru.permintaan-izin');
    Route::post('/guru-permintaan-izin',                      [GuruPortalController::class, 'storePermintaanIzin'])->name('guru.permintaan-izin.store');
    Route::put('/guru-permintaan-izin/{id}',                  [GuruPortalController::class, 'updatePermintaanIzin'])->name('guru.permintaan-izin.update');
    Route::delete('/guru-permintaan-izin/{id}',               [GuruPortalController::class, 'destroyPermintaanIzin'])->name('guru.permintaan-izin.destroy');
    Route::delete('/guru-permintaan-izin-batch/destroy',      [GuruPortalController::class, 'destroyBatchPermintaanIzin'])->name('guru.permintaan-izin.destroy-batch');
    Route::get('/guru-permintaan-izin-trash',                 [GuruPortalController::class, 'trashPermintaanIzin'])->name('guru.permintaan-izin.trash');
    Route::post('/guru-permintaan-izin-trash/{id}/restore',   [GuruPortalController::class, 'restorePermintaanIzin'])->name('guru.permintaan-izin.restore');
    Route::post('/guru-permintaan-izin-trash/restore-batch',  [GuruPortalController::class, 'restoreBatchPermintaanIzin'])->name('guru.permintaan-izin.restore-batch');
    Route::post('/guru-permintaan-izin-trash/restore-all',    [GuruPortalController::class, 'restoreAllPermintaanIzin'])->name('guru.permintaan-izin.restore-all');
    Route::delete('/guru-permintaan-izin-trash/{id}/force',   [GuruPortalController::class, 'forceDeletePermintaanIzin'])->name('guru.permintaan-izin.force-delete');
    Route::delete('/guru-permintaan-izin-trash/force-batch',  [GuruPortalController::class, 'forceDeleteBatchPermintaanIzin'])->name('guru.permintaan-izin.force-delete-batch');
    Route::redirect('/guru-beralih-ke-guru-piket', '/guru-dashboard')->name('guru.beralih-ke-guru-piket');

    // ── Data Master ──
    Route::get('/siswa/download-template',          [SiswaController::class, 'downloadTemplate'])->name('siswa.download-template');
    Route::post('/siswa/store-batch',                [SiswaController::class, 'storeBatch'])->name('siswa.store-batch');
    Route::delete('/siswa/destroy-batch',            [SiswaController::class, 'destroyBatch'])->name('siswa.destroy-batch');
    Route::delete('/siswa-trash/force-delete-batch', [SiswaController::class, 'forceDeleteBatch'])->name('siswa.force-delete-batch');
    Route::post('/siswa-trash/move-to-alumni-batch',  [SiswaController::class, 'moveToAlumniBatch'])->name('siswa.move-to-alumni-batch');
    Route::post('/siswa/{id}/move-to-alumni',        [SiswaController::class, 'moveToAlumni'])->name('siswa.move-to-alumni');
    Route::get('/siswa-alumni',                       [SiswaController::class, 'alumni'])->name('siswa.alumni');
    Route::post('/siswa-alumni/{id}/restore',         [SiswaController::class, 'restoreFromAlumni'])->name('siswa.restore-from-alumni');
    Route::post('/siswa/{id}/toggle-active',        [SiswaController::class, 'toggleActive'])->name('siswa.toggle-active');
    Route::resource('siswa', SiswaController::class);
    Route::get('/siswa-trash',                       [SiswaController::class, 'trash'])->name('siswa.trash');
    Route::post('/siswa/{id}/restore',               [SiswaController::class, 'restore'])->name('siswa.restore');
    Route::delete('/siswa/{id}/force-delete',        [SiswaController::class, 'forceDelete'])->name('siswa.force-delete');

    Route::post('/guru/store-batch',         [GuruController::class, 'storeBatch'])->name('guru.store-batch');
    Route::delete('/guru/destroy-batch',     [GuruController::class, 'destroyBatch'])->name('guru.destroy-batch');
    Route::post('/guru/{id}/toggle-active',  [GuruController::class, 'toggleActive'])->name('guru.toggle-active');
    Route::resource('guru', GuruController::class);
    Route::get('/guru-trash',                [GuruController::class, 'trash'])->name('guru.trash');
    Route::post('/guru/{id}/restore',        [GuruController::class, 'restore'])->name('guru.restore');
    Route::delete('/guru/{id}/force-delete', [GuruController::class, 'forceDelete'])->name('guru.force-delete');

    Route::delete('/kelas/destroy-batch',     [KelasController::class, 'destroyBatch'])->name('kelas.destroy-batch');
    Route::resource('kelas', KelasController::class);
    Route::get('/kelas-trash',                [KelasController::class, 'trash'])->name('kelas.trash');
    Route::post('/kelas/{id}/restore',        [KelasController::class, 'restore'])->name('kelas.restore');
    Route::delete('/kelas/{id}/force-delete', [KelasController::class, 'forceDelete'])->name('kelas.force-delete');

    Route::resource('jurusan', JurusanController::class);
    Route::get('/jurusan-trash',                [JurusanController::class, 'trash'])->name('jurusan.trash');
    Route::post('/jurusan/{id}/restore',        [JurusanController::class, 'restore'])->name('jurusan.restore');
    Route::delete('/jurusan/{id}/force-delete', [JurusanController::class, 'forceDelete'])->name('jurusan.force-delete');

    Route::delete('/mapel/destroy-batch',     [MapelController::class, 'destroyBatch'])->name('mapel.destroy-batch');
    Route::get('/mapel/generate-kode',        [MapelController::class, 'generateKodeApi'])->name('mapel.generate-kode');
    Route::get('/mapel/check-kode',           [MapelController::class, 'checkKodeApi'])->name('mapel.check-kode');
    Route::resource('mapel', MapelController::class);
    Route::get('/mapel-trash',                [MapelController::class, 'trash'])->name('mapel.trash');
    Route::post('/mapel/{id}/restore',        [MapelController::class, 'restore'])->name('mapel.restore');
    Route::delete('/mapel/{id}/force-delete', [MapelController::class, 'forceDelete'])->name('mapel.force-delete');

    Route::resource('ruangan', RuanganController::class);
    Route::get('/ruangan-trash',                [RuanganController::class, 'trash'])->name('ruangan.trash');
    Route::post('/ruangan/{id}/restore',        [RuanganController::class, 'restore'])->name('ruangan.restore');
    Route::delete('/ruangan/{id}/force-delete', [RuanganController::class, 'forceDelete'])->name('ruangan.force-delete');

    Route::delete('/jam-pelajaran/destroy-batch',     [JamPelajaranController::class, 'destroyBatch'])->name('jam-pelajaran.destroy-batch');
    Route::resource('jam-pelajaran', JamPelajaranController::class);
    Route::get('/jam-pelajaran-trash',                [JamPelajaranController::class, 'trash'])->name('jam-pelajaran.trash');
    Route::post('/jam-pelajaran/{id}/restore',        [JamPelajaranController::class, 'restore'])->name('jam-pelajaran.restore');
    Route::delete('/jam-pelajaran/{id}/force-delete', [JamPelajaranController::class, 'forceDelete'])->name('jam-pelajaran.force-delete');

    Route::get('/jadwal/download-template',     [JadwalController::class, 'downloadTemplate'])->name('jadwal.download-template');
    Route::post('/jadwal/store-batch',         [JadwalController::class, 'storeBatch'])->name('jadwal.store-batch');
    Route::delete('/jadwal/destroy-batch',      [JadwalController::class, 'destroyBatch'])->name('jadwal.destroy-batch');
    Route::resource('jadwal', JadwalController::class);
    Route::get('/jadwal-trash',                [JadwalController::class, 'trash'])->name('jadwal.trash');
    Route::post('/jadwal/{id}/restore',        [JadwalController::class, 'restore'])->name('jadwal.restore');
    Route::delete('/jadwal/{id}/force-delete', [JadwalController::class, 'forceDelete'])->name('jadwal.force-delete');

    // ── Jurnal Mengajar ──
    Route::get('/api/jadwal-siswa/{id_jadwal}',        [JurnalMengajarController::class, 'getSiswaByJadwal'])->name('jurnal-mengajar.get-siswa');
    Route::resource('jurnal-mengajar',                  JurnalMengajarController::class);
    Route::get('/jurnal-mengajar-trash',                [JurnalMengajarController::class, 'trash'])->name('jurnal-mengajar.trash');
    Route::post('/jurnal-mengajar/{id}/restore',        [JurnalMengajarController::class, 'restore'])->name('jurnal-mengajar.restore');
    Route::delete('/jurnal-mengajar/{id}/force-delete', [JurnalMengajarController::class, 'forceDelete'])->name('jurnal-mengajar.force-delete');

    // ── Workflow Guru Piket ──
    Route::post('/jurnal-piket/guru-izin',     [JurnalPiketController::class, 'storeGuruIzin'])->name('jurnal-piket.store-guru-izin');
    Route::post('/jurnal-piket/siswa-dispen',  [JurnalPiketController::class, 'storeSiswaDispen'])->name('jurnal-piket.store-siswa-dispen');
    Route::post('/surat-izin-siswa/store',     [SuratIzinSiswaController::class, 'store'])->name('surat-izin-siswa.store');
    Route::resource('jurnal-piket',                  JurnalPiketController::class);
    Route::get('/jurnal-piket-trash',                [JurnalPiketController::class, 'trash'])->name('jurnal-piket.trash');
    Route::post('/jurnal-piket/{id}/restore',        [JurnalPiketController::class, 'restore'])->name('jurnal-piket.restore');
    Route::delete('/jurnal-piket/{id}/force-delete', [JurnalPiketController::class, 'forceDelete'])->name('jurnal-piket.force-delete');

    // ── Pengaturan & CS ──
    Route::get('/pengaturan',                   [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan/profile',          [PengaturanController::class, 'updateProfile'])->name('pengaturan.update-profile');
    Route::post('/pengaturan/password',         [PengaturanController::class, 'updatePassword'])->name('pengaturan.update-password');
    Route::post('/pengaturan/preferences',      [PengaturanController::class, 'updatePreferences'])->name('pengaturan.update-preferences');
    Route::post('/pengaturan/system',           [PengaturanController::class, 'updateSystemSettings'])->name('pengaturan.update-system');

    Route::get('/customer-service',             [CustomerServiceController::class, 'index'])->name('customer-service.index');
    Route::post('/customer-service/chatbot/ask', [CustomerServiceController::class, 'askChatBot'])->name('customer-service.chatbot.ask');
    Route::post('/customer-service/store',      [CustomerServiceController::class, 'storeTicket'])->name('customer-service.store');
    Route::post('/customer-service/{id}/respond', [CustomerServiceController::class, 'respondTicket'])->name('customer-service.respond');
});
