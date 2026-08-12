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

// ─────────────────────────────────────────────────
// Public Auth Routes
// ─────────────────────────────────────────────────
Route::get('/login',    [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/register', function () {
    return redirect()->route('login')->with('error', 'Pendaftaran akun pengguna tidak dibuka secara publik. Seluruh akun pengguna dibuat dan diverifikasi oleh Administrator Tata Usaha (TU).');
})->name('register');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// Redirect root ke dashboard sesuai role
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('guru.dashboard');
    }
    return redirect()->route('login');
});

// ─────────────────────────────────────────────────
// Admin-Only Routes (auth + admin middleware)
// ─────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard & Ekspor CSV
    Route::get('/dashboard',  [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/export-csv', [AdminDashboardController::class, 'exportCsv'])->name('export-csv');

    // Manajemen Pengguna (Role TU)
    Route::get('/verifikasi-guru',                              [AdminDashboardController::class, 'verifikasiGuru'])->name('verifikasi-guru');
    Route::get('/pengguna',                                     [AdminDashboardController::class, 'verifikasiGuru'])->name('pengguna');
    Route::post('/verifikasi-guru/{id}/approve',                [AdminDashboardController::class, 'approveGuru'])->name('verifikasi-guru.approve');
    Route::post('/verifikasi-guru/{id}/reject',                 [AdminDashboardController::class, 'rejectGuru'])->name('verifikasi-guru.reject');
    Route::post('/verifikasi-guru/{id}/update-role',            [AdminDashboardController::class, 'updateRole'])->name('verifikasi-guru.update-role');
    Route::post('/users',                                       [AdminDashboardController::class, 'storeUser'])->name('users.store');
    Route::post('/users/{id}/reset-password',                   [AdminDashboardController::class, 'resetPassword'])->name('users.reset-password');

    // Submenu Navigasi Guru & Piket Management
    Route::get('/guru-piket-list',                              [AdminDashboardController::class, 'guruPiketList'])->name('guru-piket');
    Route::post('/guru-piket',                                  [AdminDashboardController::class, 'storeGuruPiket'])->name('guru-piket.store');
    Route::delete('/guru-piket/{id}',                           [AdminDashboardController::class, 'destroyGuruPiket'])->name('guru-piket.destroy');
    Route::get('/guru-piket-trash',                             [AdminDashboardController::class, 'guruPiketTrash'])->name('guru-piket.trash');
    Route::post('/guru-piket-trash/{id}/restore',               [AdminDashboardController::class, 'restoreGuruPiket'])->name('guru-piket.restore');
    Route::delete('/guru-piket-trash/{id}/force-delete',        [AdminDashboardController::class, 'forceDeleteGuruPiket'])->name('guru-piket.force-delete');

    // Submenu Navigasi Wali Kelas Management
    Route::get('/wali-kelas-list',                              [AdminDashboardController::class, 'waliKelasList'])->name('wali-kelas-list');
    Route::post('/wali-kelas',                                  [AdminDashboardController::class, 'storeWaliKelas'])->name('wali-kelas.store');
    Route::delete('/wali-kelas/{id}',                           [AdminDashboardController::class, 'destroyWaliKelas'])->name('wali-kelas.destroy');
    Route::get('/wali-kelas-trash',                             [AdminDashboardController::class, 'waliKelasTrash'])->name('wali-kelas.trash');
    Route::post('/wali-kelas-trash/{id}/restore',               [AdminDashboardController::class, 'restoreWaliKelas'])->name('wali-kelas.restore');
    Route::delete('/wali-kelas-trash/{id}/force-delete',        [AdminDashboardController::class, 'forceDeleteWaliKelas'])->name('wali-kelas.force-delete');

    // User Soft Delete & Trash
    Route::delete('/users/{id}',                                [AdminDashboardController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/users-trash',                                  [AdminDashboardController::class, 'usersTrash'])->name('users-trash');
    Route::post('/users-trash/{id}/restore',                    [AdminDashboardController::class, 'restoreUser'])->name('users-trash.restore');
    Route::match(['POST', 'DELETE'], '/users-trash/{id}/force-delete', [AdminDashboardController::class, 'forceDeleteUser'])->name('users-trash.force-delete');

    // Admin Profile
    Route::get('/profile',              [AdminDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile/update',      [AdminDashboardController::class, 'updateProfile'])->name('profile.update');

    // Monitoring Jurnal Mengajar (Admin View + Filter + Detail + Export + Store + Destroy)
    Route::get('/jurnal-mengajar-admin',                  [AdminMonitoringController::class, 'jurnalMengajar'])->name('jurnal-mengajar');
    Route::get('/jurnal-mengajar-admin/export',           [AdminMonitoringController::class, 'jurnalMengajarExport'])->name('jurnal-mengajar.export');
    Route::get('/jurnal-mengajar-admin/print',            [AdminMonitoringController::class, 'jurnalMengajarCetak'])->name('jurnal-mengajar.print');
    Route::get('/jurnal-mengajar-admin/detail/{id}',      [AdminMonitoringController::class, 'jurnalMengajarDetail'])->name('jurnal-mengajar.detail');
    Route::get('/jurnal-mengajar-admin/print-detail/{id}', [AdminMonitoringController::class, 'jurnalMengajarCetakDetail'])->name('jurnal-mengajar.print-detail');
    Route::post('/jurnal-mengajar-admin/store',           [AdminMonitoringController::class, 'jurnalMengajarStore'])->name('jurnal-mengajar.store');
    Route::delete('/jurnal-mengajar-admin/{id}',          [AdminMonitoringController::class, 'jurnalMengajarDestroy'])->name('jurnal-mengajar.destroy');

    // Monitoring & Management Jurnal Guru Piket (Admin/TU Full Control)
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

    // Monitoring Kehadiran Analytics & Charts
    Route::get('/monitoring-kehadiran',         [AdminMonitoringController::class, 'monitoringKehadiran'])->name('monitoring-kehadiran');
});

// ─────────────────────────────────────────────────
// Guru/Staff Routes (auth middleware)
// ─────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // ── Portal Guru, Wali Kelas & Piket ──
    Route::get('/guru-dashboard',       [GuruPortalController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/guru-riwayat-jurnal',  [GuruPortalController::class, 'riwayatJurnal'])->name('guru.riwayat-jurnal');
    Route::get('/guru-kehadiran-kelas', [GuruPortalController::class, 'kehadiranKelas'])->name('guru.kehadiran-kelas');

    // ── Data Master: Siswa ──
    Route::resource('siswa', SiswaController::class);
    Route::get('/siswa-trash',                [SiswaController::class, 'trash'])->name('siswa.trash');
    Route::post('/siswa/{id}/restore',        [SiswaController::class, 'restore'])->name('siswa.restore');
    Route::delete('/siswa/{id}/force-delete', [SiswaController::class, 'forceDelete'])->name('siswa.force-delete');

    // ── Data Master: Guru ──
    Route::resource('guru', GuruController::class);
    Route::get('/guru-trash',                [GuruController::class, 'trash'])->name('guru.trash');
    Route::post('/guru/{id}/restore',        [GuruController::class, 'restore'])->name('guru.restore');
    Route::delete('/guru/{id}/force-delete', [GuruController::class, 'forceDelete'])->name('guru.force-delete');

    // ── Data Master: Kelas ──
    Route::resource('kelas', KelasController::class);
    Route::get('/kelas-trash',                [KelasController::class, 'trash'])->name('kelas.trash');
    Route::post('/kelas/{id}/restore',        [KelasController::class, 'restore'])->name('kelas.restore');
    Route::delete('/kelas/{id}/force-delete', [KelasController::class, 'forceDelete'])->name('kelas.force-delete');

    // ── Data Master: Jurusan ──
    Route::resource('jurusan', JurusanController::class);
    Route::get('/jurusan-trash',                [JurusanController::class, 'trash'])->name('jurusan.trash');
    Route::post('/jurusan/{id}/restore',        [JurusanController::class, 'restore'])->name('jurusan.restore');
    Route::delete('/jurusan/{id}/force-delete', [JurusanController::class, 'forceDelete'])->name('jurusan.force-delete');

    // ── Data Master: Mata Pelajaran ──
    Route::resource('mapel', MapelController::class);
    Route::get('/mapel-trash',                [MapelController::class, 'trash'])->name('mapel.trash');
    Route::post('/mapel/{id}/restore',        [MapelController::class, 'restore'])->name('mapel.restore');
    Route::delete('/mapel/{id}/force-delete', [MapelController::class, 'forceDelete'])->name('mapel.force-delete');

    // ── Data Master: Ruangan ──
    Route::resource('ruangan', RuanganController::class);
    Route::get('/ruangan-trash',                [RuanganController::class, 'trash'])->name('ruangan.trash');
    Route::post('/ruangan/{id}/restore',        [RuanganController::class, 'restore'])->name('ruangan.restore');
    Route::delete('/ruangan/{id}/force-delete', [RuanganController::class, 'forceDelete'])->name('ruangan.force-delete');

    // ── Data Master: Master Jam Pelajaran ──
    Route::resource('jam-pelajaran', JamPelajaranController::class);
    Route::get('/jam-pelajaran-trash',                [JamPelajaranController::class, 'trash'])->name('jam-pelajaran.trash');
    Route::post('/jam-pelajaran/{id}/restore',        [JamPelajaranController::class, 'restore'])->name('jam-pelajaran.restore');
    Route::delete('/jam-pelajaran/{id}/force-delete', [JamPelajaranController::class, 'forceDelete'])->name('jam-pelajaran.force-delete');

    // ── Data Master: Jadwal ──
    Route::resource('jadwal', JadwalController::class);
    Route::get('/jadwal-trash',                [JadwalController::class, 'trash'])->name('jadwal.trash');
    Route::post('/jadwal/{id}/restore',        [JadwalController::class, 'restore'])->name('jadwal.restore');
    Route::delete('/jadwal/{id}/force-delete', [JadwalController::class, 'forceDelete'])->name('jadwal.force-delete');

    // ── Jurnal Mengajar (Guru) ──
    Route::get('/api/jadwal-siswa/{id_jadwal}',        [JurnalMengajarController::class, 'getSiswaByJadwal'])->name('jurnal-mengajar.get-siswa');
    Route::resource('jurnal-mengajar',                  JurnalMengajarController::class);
    Route::get('/jurnal-mengajar-trash',                [JurnalMengajarController::class, 'trash'])->name('jurnal-mengajar.trash');
    Route::post('/jurnal-mengajar/{id}/restore',        [JurnalMengajarController::class, 'restore'])->name('jurnal-mengajar.restore');
    Route::delete('/jurnal-mengajar/{id}/force-delete', [JurnalMengajarController::class, 'forceDelete'])->name('jurnal-mengajar.force-delete');

    // ── Jurnal Piket (Guru Piket) ──
    Route::resource('jurnal-piket',                  JurnalPiketController::class);
    Route::get('/jurnal-piket-trash',                [JurnalPiketController::class, 'trash'])->name('jurnal-piket.trash');
    Route::post('/jurnal-piket/{id}/restore',        [JurnalPiketController::class, 'restore'])->name('jurnal-piket.restore');
    Route::delete('/jurnal-piket/{id}/force-delete', [JurnalPiketController::class, 'forceDelete'])->name('jurnal-piket.force-delete');

    // ── Pengaturan (Semua Role) ──
    Route::get('/pengaturan',                   [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan/profile',          [PengaturanController::class, 'updateProfile'])->name('pengaturan.update-profile');
    Route::post('/pengaturan/password',         [PengaturanController::class, 'updatePassword'])->name('pengaturan.update-password');
    Route::post('/pengaturan/system',           [PengaturanController::class, 'updateSystemSettings'])->name('pengaturan.update-system');

    // ── Customer Service (Semua Role) ──
    Route::get('/customer-service',             [CustomerServiceController::class, 'index'])->name('customer-service.index');
    Route::post('/customer-service/store',      [CustomerServiceController::class, 'storeTicket'])->name('customer-service.store');
    Route::post('/customer-service/{id}/respond', [CustomerServiceController::class, 'respondTicket'])->name('customer-service.respond');
});
