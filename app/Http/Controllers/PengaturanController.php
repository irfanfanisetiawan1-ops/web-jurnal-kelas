<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use App\Models\User;

class PengaturanController extends Controller
{
    /**
     * Tampilkan halaman utama Pengaturan.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        // Data Guru & Kelas Perwalian (jika user adalah Guru/Wali Kelas/Guru Piket)
        $guru = $user->guru ?? \App\Models\Guru::where('nip', $user->nip)->first();
        $kelasWali = \App\Models\Kelas::where('wali_kelas', $user->nip ?? ($guru->nip ?? ''))->first();
        
        // Data Khusus Piket (jika user Guru Piket)
        $piketData = null;
        if ($user->isGuruPiket()) {
            $todayDate = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
            $piketData = [
                'total_jurnal_piket' => \App\Models\JurnalMengajar::whereDate('tanggal', $todayDate)->count(),
                'penugasan_aktif'    => \App\Models\PenugasanGuruPengganti::whereDate('tanggal', $todayDate)->count(),
                'guru_tidak_hadir'   => \App\Models\GuruIzin::whereDate('tanggal_mulai', '<=', $todayDate)
                    ->whereDate('tanggal_selesai', '>=', $todayDate)
                    ->count(),
            ];
        }

        // Data Khusus Wali Kelas (jika user Wali Kelas)
        $waliData = null;
        if ($user->isWaliKelas() || $kelasWali) {
            $todayDate = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
            $kelasId = $kelasWali->id_kelas ?? null;
            $waliData = [
                'nama_kelas'       => $kelasWali->nama_kelas ?? 'Belum Ditentukan',
                'total_siswa'      => $kelasWali ? $kelasWali->siswas()->count() : 0,
                'jurusan'          => $kelasWali && $kelasWali->jurusan ? $kelasWali->jurusan->nama_jurusan : '-',
                'ruangan'          => $kelasWali && $kelasWali->ruangan ? $kelasWali->ruangan->nama_ruangan : '-',
                'dispen_pending'   => $kelasId ? \App\Models\SiswaDispen::where('id_kelas', $kelasId)->where('status_wali_kelas', 'pending')->count() : 0,
                'surat_izin_today' => $kelasId ? \App\Models\SiswaSuratIzin::where('id_kelas', $kelasId)->whereDate('tanggal', $todayDate)->count() : 0,
            ];
        }

        // Data Khusus Guru Mengajar
        $guruDataMetrics = null;
        if ($guru) {
            $todayDate = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
            $todayMonth = \Carbon\Carbon::now('Asia/Jakarta')->month;
            $todayYear = \Carbon\Carbon::now('Asia/Jakarta')->year;
            $daysInIndo = [
                'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
            ];
            $todayHariIndo = $daysInIndo[\Carbon\Carbon::now('Asia/Jakarta')->format('l')] ?? '';

            $guruId = $guru->id_guru;
            $jurnalToday = \App\Models\JurnalMengajar::whereHas('jadwal', function($q) use ($guruId) {
                $q->where('id_guru', $guruId);
            })->whereDate('tanggal', $todayDate)->count();

            $jurnalMonth = \App\Models\JurnalMengajar::whereHas('jadwal', function($q) use ($guruId) {
                $q->where('id_guru', $guruId);
            })->whereMonth('tanggal', $todayMonth)->whereYear('tanggal', $todayYear)->count();

            $jadwalTodayCount = \App\Models\Jadwal::where('id_guru', $guruId)->where('hari', $todayHariIndo)->count();

            $guruDataMetrics = [
                'nama_mapel'         => $guru->mapel ? $guru->mapel->nama_mapel : 'Guru Mapel / Non-Spesifik',
                'jurnal_today'       => $jurnalToday,
                'jurnal_month'       => $jurnalMonth,
                'total_jadwal_today' => $jadwalTodayCount,
            ];
        }

        // Data Khusus Kepala Sekolah
        $kepsekData = null;
        if ($user->isKepalaSekolah()) {
            $todayDate = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
            $kepsekData = [
                'total_guru'          => \App\Models\Guru::count(),
                'total_siswa'         => \App\Models\Siswa::count(),
                'izin_pending_kepsek' => \App\Models\GuruIzin::whereIn('status_waka', ['approved', 'disetujui'])->where('status_kepsek', 'pending')->count(),
                'guru_izin_today'     => \App\Models\GuruIzin::whereDate('tanggal_mulai', '<=', $todayDate)->whereDate('tanggal_selesai', '>=', $todayDate)->count(),
                'jurnal_harian_today' => \App\Models\JurnalMengajar::whereDate('tanggal', $todayDate)->count(),
            ];
        }

        // Data Khusus Waka (Wakil Kepala Sekolah)
        $wakaData = null;
        if ($user->isWaka() || $user->isWakaSdm() || $user->isWakaKesiswaan()) {
            $todayDate = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
            $wakaData = [
                'total_guru'       => \App\Models\Guru::count(),
                'total_siswa'      => \App\Models\Siswa::count(),
                'izin_pending'     => \App\Models\GuruIzin::where('status_waka', 'pending')->count(),
                'dispen_pending'   => \App\Models\SiswaDispen::where('status_waka', 'pending')->count(),
                'total_jadwal'     => \App\Models\Jadwal::count(),
                'jurnal_today'     => \App\Models\JurnalMengajar::whereDate('tanggal', $todayDate)->count(),
                'total_pengumuman' => \App\Models\Pengumuman::where('kategori', '!=', 'Siswa Telat')->count(),
            ];
        }

        // Data Khusus Satpam Gerbang
        $satpamData = null;
        if ($user->isSatpam()) {
            $todayDate = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
            $dispenApprovedQuery = \App\Models\SiswaDispen::withTrashed()
                ->whereDate('tanggal', $todayDate)
                ->where(function($q) {
                    $q->where('status_waka', 'approved')
                      ->orWhere('status_wali_kelas', 'approved');
                });

            $satpamData = [
                'dispen_today'      => (clone $dispenApprovedQuery)->count(),
                'menunggu_validasi' => (clone $dispenApprovedQuery)->where('status_satpam', 'belum_keluar')->count(),
                'dizinkan_keluar'   => (clone $dispenApprovedQuery)->where('status_satpam', 'dizinkan_keluar')->count(),
                'sudah_kembali'     => (clone $dispenApprovedQuery)->where('status_satpam', 'sudah_kembali')->count(),
            ];
        }

        // Ambil data settings sistem (untuk Admin/TU, Piket, Wali Kelas, Kepsek, Satpam, Waka, Guru & preferensi)
        $systemSettings = [
            'cs_whatsapp'               => Setting::getByKey('cs_whatsapp', '6281234567890'),
            'cs_email'                  => Setting::getByKey('cs_email', 'cs.jurnal@edujournal.sch.id'),
            'cs_jam_kerja'              => Setting::getByKey('cs_jam_kerja', 'Senin - Jumat (07:00 - 15:30 WIB)'),
            'app_name'                  => Setting::getByKey('app_name', 'EDU JOURNAL'),
            'tahun_ajaran_aktif'        => Setting::getByKey('tahun_ajaran_aktif', '2026/2027'),
            'semester_aktif'            => Setting::getByKey('semester_aktif', 'Ganjil'),
            'notif_izin'                => Setting::getByKey('tu_notif_izin', '1'),
            'notif_jurnal_kosong'       => Setting::getByKey('tu_notif_jurnal_kosong', '1'),
            'notif_sistem'              => Setting::getByKey('tu_notif_sistem', '1'),
            'data_per_page'             => Setting::getByKey('tu_data_per_page', '25'),
            'confirm_delete'            => Setting::getByKey('tu_confirm_delete', '1'),
            'export_format'             => Setting::getByKey('tu_export_format', 'pdf'),
            // Preferensi Piket
            'piket_notif_guru_izin'     => Setting::getByKey('piket_notif_guru_izin', '1'),
            'piket_notif_jurnal_kosong' => Setting::getByKey('piket_notif_jurnal_kosong', '1'),
            'piket_notif_dispensasi'    => Setting::getByKey('piket_notif_dispensasi', '1'),
            'piket_notif_ringkasan'     => Setting::getByKey('piket_notif_ringkasan', '1'),
            'piket_mode_guru_pengganti' => Setting::getByKey('piket_mode_guru_pengganti', 'manual'),
            'piket_export_format'       => Setting::getByKey('piket_export_format', 'pdf'),
            'piket_data_per_page'       => Setting::getByKey('piket_data_per_page', '25'),
            // Preferensi Wali Kelas
            'wali_notif_izin'           => Setting::getByKey('wali_notif_izin', '1'),
            'wali_notif_dispensasi'     => Setting::getByKey('wali_notif_dispensasi', '1'),
            'wali_notif_rekap_harian'   => Setting::getByKey('wali_notif_rekap_harian', '1'),
            'wali_mode_dispen'          => Setting::getByKey('wali_mode_dispen', 'manual'),
            'wali_export_format'        => Setting::getByKey('wali_export_format', 'pdf'),
            'wali_data_per_page'        => Setting::getByKey('wali_data_per_page', '25'),
            // Preferensi Kepala Sekolah
            'kepsek_notif_izin'                  => Setting::getByKey('kepsek_notif_izin', '1'),
            'kepsek_notif_laporan_harian'        => Setting::getByKey('kepsek_notif_laporan_harian', '1'),
            'kepsek_notif_evaluasi_pembelajaran' => Setting::getByKey('kepsek_notif_evaluasi_pembelajaran', '1'),
            'kepsek_mode_approval'               => Setting::getByKey('kepsek_mode_approval', 'manual'),
            'kepsek_export_format'               => Setting::getByKey('kepsek_export_format', 'pdf'),
            'kepsek_data_per_page'               => Setting::getByKey('kepsek_data_per_page', '25'),
            // Preferensi Waka
            'waka_notif_izin'          => Setting::getByKey('waka_notif_izin', '1'),
            'waka_notif_jurnal_kosong' => Setting::getByKey('waka_notif_jurnal_kosong', '1'),
            'waka_notif_pengumuman'    => Setting::getByKey('waka_notif_pengumuman', '1'),
            'waka_mode_approval'       => Setting::getByKey('waka_mode_approval', 'manual'),
            'waka_export_format'       => Setting::getByKey('waka_export_format', 'pdf'),
            'waka_data_per_page'       => Setting::getByKey('waka_data_per_page', '25'),
            // Preferensi Satpam
            'satpam_notif_dispensasi'   => Setting::getByKey('satpam_notif_dispensasi', '1'),
            'satpam_beep_scan'          => Setting::getByKey('satpam_beep_scan', '1'),
            'satpam_auto_refresh'       => Setting::getByKey('satpam_auto_refresh', '1'),
            'satpam_data_per_page'      => Setting::getByKey('satpam_data_per_page', '25'),
            // Preferensi Guru Mengajar
            // Preferensi Guru Mengajar
            'guru_notif_izin'           => Setting::getByKey('guru_notif_izin', '1'),
            'guru_notif_jurnal'         => Setting::getByKey('guru_notif_jurnal', '1'),
            'guru_notif_dispensasi'     => Setting::getByKey('guru_notif_dispensasi', '1'),
            'guru_export_format'        => Setting::getByKey('guru_export_format', 'pdf'),
            'guru_data_per_page'        => Setting::getByKey('guru_data_per_page', '25'),
            // Preferensi Orang Tua
            'ortu_notif_kehadiran'      => Setting::getByKey('ortu_notif_kehadiran', '1'),
            'ortu_notif_izin'           => Setting::getByKey('ortu_notif_izin', '1'),
            'ortu_notif_laporan'        => Setting::getByKey('ortu_notif_laporan', '1'),
            'ortu_notif_pengumuman'     => Setting::getByKey('ortu_notif_pengumuman', '1'),
            'ortu_export_format'        => Setting::getByKey('ortu_export_format', 'pdf'),
        ];

        // Data Khusus Orang Tua
        $siswaOrangTua = null;
        $ortuMetrics = null;
        if ($user->isOrangTua()) {
            $siswaOrangTua = $user->siswa ?? \App\Models\Siswa::withoutGlobalScopes()
                ->where('id_siswa', $user->id_siswa)
                ->orWhere('nisn', $user->nip)
                ->orWhere('nis', $user->nip)
                ->first();

            if ($siswaOrangTua && !$user->id_siswa) {
                $user->update(['id_siswa' => $siswaOrangTua->id_siswa]);
            }

            if ($siswaOrangTua) {
                $siswaOrangTua->loadMissing(['kelas.jurusan', 'kelas.waliKelas', 'kelas.ruangan']);

                $currentMonth = \Carbon\Carbon::now('Asia/Jakarta')->month;
                $currentYear = \Carbon\Carbon::now('Asia/Jakarta')->year;

                $totalJurnalKelas = \App\Models\JurnalMengajar::whereHas('jadwal', function ($q) use ($siswaOrangTua) {
                    $q->where('id_kelas', $siswaOrangTua->id_kelas);
                })->whereMonth('tanggal', $currentMonth)
                  ->whereYear('tanggal', $currentYear)
                  ->count();

                $ketidakhadiran = \App\Models\JurnalDetailKetidakhadiran::where('id_siswa', $siswaOrangTua->id_siswa)
                    ->whereHas('jurnalMengajar', function ($q) use ($currentMonth, $currentYear) {
                        $q->whereMonth('tanggal', $currentMonth)
                          ->whereYear('tanggal', $currentYear);
                    })->get();

                $sakitCount = $ketidakhadiran->where('keterangan', 'Sakit')->count();
                $izinCount  = $ketidakhadiran->where('keterangan', 'Izin')->count();
                $alfaCount  = $ketidakhadiran->where('keterangan', 'Alpa')->count();
                $hadirCount = $totalJurnalKelas > 0 ? max(0, $totalJurnalKelas - ($sakitCount + $izinCount + $alfaCount)) : 0;
                $persenHadir = $totalJurnalKelas > 0 ? round(($hadirCount / $totalJurnalKelas) * 100) : 100;

                $totalSuratIzin = \App\Models\SiswaSuratIzin::where('id_siswa', $siswaOrangTua->id_siswa)->count();
                $totalDispen = \App\Models\SiswaDispen::where('id_siswa', $siswaOrangTua->id_siswa)->count();

                $ortuMetrics = [
                    'total_jurnal' => $totalJurnalKelas,
                    'hadir'        => $hadirCount,
                    'sakit'        => $sakitCount,
                    'izin'         => $izinCount,
                    'alfa'         => $alfaCount,
                    'persen_hadir' => $persenHadir,
                    'total_izin'   => $totalSuratIzin,
                    'total_dispen' => $totalDispen,
                    'wali_kelas'   => $siswaOrangTua->kelas && $siswaOrangTua->kelas->waliKelas ? $siswaOrangTua->kelas->waliKelas : null,
                ];
            }
        }

        // Tata letak layout adaptif sesuai role
        if ($user->isAdmin()) {
            $layout = 'layouts.admin';
        } elseif ($user->isKepalaSekolah()) {
            $layout = 'layouts.kepala_sekolah';
        } elseif ($user->isWakaSdm()) {
            $layout = 'layouts.waka_sdm';
        } elseif ($user->isWakaKurikulum()) {
            $layout = 'layouts.waka_kurikulum';
        } elseif ($user->isWaka() || $user->isWakaKesiswaan()) {
            $layout = 'layouts.waka';
        } elseif ($user->isOrangTua()) {
            $layout = 'layouts.orang_tua';
        } else {
            $layout = 'layouts.guru';
        }

        return view('pengaturan.index', compact('user', 'guru', 'kelasWali', 'piketData', 'waliData', 'guruDataMetrics', 'kepsekData', 'wakaData', 'satpamData', 'siswaOrangTua', 'ortuMetrics', 'systemSettings', 'layout'));
    }

    /**
     * Update profil pengguna.
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name'          => 'required|string|min:3|max:255',
            'email'         => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'no_hp'         => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'name.min'       => 'Nama lengkap minimal 3 karakter.',
            'email.email'    => 'Format alamat email tidak valid.',
            'email.unique'   => 'Email ini sudah digunakan oleh akun lain.',
            'no_hp.max'      => 'Nomor HP maksimal 20 karakter.',
            'foto.image'     => 'Berkas foto profil harus berupa gambar.',
            'foto.mimes'     => 'Format foto harus berupa jpeg, png, jpg, gif, atau webp.',
            'foto.max'       => 'Ukuran foto profil maksimal 2 MB.',
        ]);

        $updateData = [
            'name'          => $request->name,
            'email'         => $request->email,
            'no_hp'         => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
        ];

        // Hapus foto jika pengguna meminta hapus foto
        if ($request->boolean('remove_photo')) {
            if ($user->foto && file_exists(public_path('uploads/profile_photos/' . $user->foto))) {
                @unlink(public_path('uploads/profile_photos/' . $user->foto));
            }
            $updateData['foto'] = null;
        }

        // Upload foto profil baru jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/profile_photos');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Hapus foto lama jika ada
            if ($user->foto && file_exists($destinationPath . '/' . $user->foto)) {
                @unlink($destinationPath . '/' . $user->foto);
            }

            $file->move($destinationPath, $filename);
            $updateData['foto'] = $filename;
        }

        $user->update($updateData);

        // Sinkronisasi data ke tabel guru jika akun ini memiliki relasi data guru
        if ($user->id_guru || $user->nip) {
            $guru = $user->guru ?? \App\Models\Guru::where('nip', $user->nip)->first();
            if ($guru) {
                $guruData = [
                    'nama_guru'     => $request->name,
                    'no_hp'         => $request->no_hp,
                    'jenis_kelamin' => $request->jenis_kelamin,
                ];
                $guru->update($guruData);
            }
        }

        return redirect()->back()
            ->with('success', 'Profil Anda berhasil diperbarui!')
            ->with('active_tab', 'profile');
    }

    /**
     * Update password pengguna.
     */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'current_password'      => 'required|string',
            'password'              => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.min'              => 'Password baru minimal 6 karakter.',
            'password.confirmed'        => 'Konfirmasi password baru tidak cocok dengan password baru.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini salah. Silakan masukkan password akun Anda yang benar!'])
                ->withInput()
                ->with('active_tab', 'security');
        }

        $updatePassData = [
            'password' => Hash::make($request->password),
        ];
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'password_plain')) {
            $updatePassData['password_plain'] = $request->password;
        }
        $user->update($updatePassData);

        return redirect()->back()
            ->with('success', 'Password Anda berhasil diperbarui!')
            ->with('active_tab', 'security');
    }

    /**
     * Update preferensi & notifikasi pengguna.
     */
    public function updatePreferences(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $guru = $user->guru ?? \App\Models\Guru::where('nip', $user->nip)->first();
        $kelasWali = \App\Models\Kelas::where('wali_kelas', $user->nip ?? ($guru->nip ?? ''))->first();

        if ($user->isAdmin() || $user->isTu()) {
            Setting::setByKey('tu_notif_izin', $request->has('tu_notif_izin') ? '1' : '0', 'tu_pref', 'Notifikasi Verifikasi Izin');
            Setting::setByKey('tu_notif_jurnal_kosong', $request->has('tu_notif_jurnal_kosong') ? '1' : '0', 'tu_pref', 'Alert Jurnal Kosong');
            Setting::setByKey('tu_notif_sistem', $request->has('tu_notif_sistem') ? '1' : '0', 'tu_pref', 'Notifikasi Sistem & CS');
            Setting::setByKey('tu_data_per_page', $request->input('tu_data_per_page', '25'), 'tu_pref', 'Batas Data per Halaman');
            Setting::setByKey('tu_confirm_delete', $request->has('tu_confirm_delete') ? '1' : '0', 'tu_pref', 'Konfirmasi Sebelum Hapus');
            Setting::setByKey('tu_export_format', $request->input('tu_export_format', 'pdf'), 'tu_pref', 'Format Default Ekspor Laporan');
        } elseif ($user->isSatpam()) {
            Setting::setByKey('satpam_notif_dispensasi', $request->has('satpam_notif_dispensasi') ? '1' : '0', 'satpam_pref', 'Notifikasi Dispensasi Siswa');
            Setting::setByKey('satpam_beep_scan', $request->has('satpam_beep_scan') ? '1' : '0', 'satpam_pref', 'Suara Beep pada Scan Barcode');
            Setting::setByKey('satpam_auto_refresh', $request->has('satpam_auto_refresh') ? '1' : '0', 'satpam_pref', 'Auto Refresh Live Data Antrean Scanner');
            Setting::setByKey('satpam_data_per_page', $request->input('satpam_data_per_page', '25'), 'satpam_pref', 'Batas Data per Halaman');
        } elseif ($user->isGuruPiket()) {
            Setting::setByKey('piket_notif_guru_izin', $request->has('piket_notif_guru_izin') ? '1' : '0', 'piket_pref', 'Notifikasi Guru Tidak Hadir');
            Setting::setByKey('piket_notif_jurnal_kosong', $request->has('piket_notif_jurnal_kosong') ? '1' : '0', 'piket_pref', 'Alert Jurnal Belum Didaftarkan');
            Setting::setByKey('piket_notif_dispensasi', $request->has('piket_notif_dispensasi') ? '1' : '0', 'piket_pref', 'Notifikasi Dispensasi Siswa');
            Setting::setByKey('piket_notif_ringkasan', $request->has('piket_notif_ringkasan') ? '1' : '0', 'piket_pref', 'Laporan Ringkasan Harian Piket');
            Setting::setByKey('piket_mode_guru_pengganti', $request->input('piket_mode_guru_pengganti', 'manual'), 'piket_pref', 'Mode Penugasan Guru Pengganti');
            Setting::setByKey('piket_export_format', $request->input('piket_export_format', 'pdf'), 'piket_pref', 'Format Default Ekspor Rekap Piket');
            Setting::setByKey('piket_data_per_page', $request->input('piket_data_per_page', '25'), 'piket_pref', 'Jumlah Data per Halaman');
        } elseif ($user->isKepalaSekolah()) {
            Setting::setByKey('kepsek_notif_izin', $request->has('kepsek_notif_izin') ? '1' : '0', 'kepsek_pref', 'Notifikasi Persetujuan Final Izin Guru');
            Setting::setByKey('kepsek_notif_laporan_harian', $request->has('kepsek_notif_laporan_harian') ? '1' : '0', 'kepsek_pref', 'Laporan Eksekutif Ringkasan Harian');
            Setting::setByKey('kepsek_notif_evaluasi_pembelajaran', $request->has('kepsek_notif_evaluasi_pembelajaran') ? '1' : '0', 'kepsek_pref', 'Alert Evaluasi Keterlaksanaan Pembelajaran');
            Setting::setByKey('kepsek_mode_approval', $request->input('kepsek_mode_approval', 'manual'), 'kepsek_pref', 'Mode Persetujuan Izin Guru');
            Setting::setByKey('kepsek_export_format', $request->input('kepsek_export_format', 'pdf'), 'kepsek_pref', 'Format Default Ekspor Laporan Kepsek');
            Setting::setByKey('kepsek_data_per_page', $request->input('kepsek_data_per_page', '25'), 'kepsek_pref', 'Batas Data per Halaman Kepsek');
            Setting::setByKey('wali_data_per_page', $request->input('wali_data_per_page', '25'), 'wali_pref', 'Jumlah Data per Halaman Wali Kelas');
        } elseif ($user->isWaka() || $user->isWakaSdm() || $user->isWakaKesiswaan()) {
            Setting::setByKey('waka_notif_izin', $request->has('waka_notif_izin') ? '1' : '0', 'waka_pref', 'Notifikasi Pengajuan Izin Guru & Dispen Siswa');
            Setting::setByKey('waka_notif_jurnal_kosong', $request->has('waka_notif_jurnal_kosong') ? '1' : '0', 'waka_pref', 'Alert Monitoring Jurnal Belum Didaftarkan');
            Setting::setByKey('waka_notif_pengumuman', $request->has('waka_notif_pengumuman') ? '1' : '0', 'waka_pref', 'Notifikasi Broadcast Pengumuman Sekolah');
            Setting::setByKey('waka_mode_approval', $request->input('waka_mode_approval', 'manual'), 'waka_pref', 'Mode Persetujuan Izin Waka');
            Setting::setByKey('waka_export_format', $request->input('waka_export_format', 'pdf'), 'waka_pref', 'Format Default Ekspor Rekap Waka');
            Setting::setByKey('waka_data_per_page', $request->input('waka_data_per_page', '25'), 'waka_pref', 'Batas Data per Halaman Waka');
        } elseif ($user->isOrangTua()) {
            Setting::setByKey('ortu_notif_kehadiran', $request->has('ortu_notif_kehadiran') ? '1' : '0', 'ortu_pref', 'Notifikasi Kehadiran & Absensi Harian');
            Setting::setByKey('ortu_notif_izin', $request->has('ortu_notif_izin') ? '1' : '0', 'ortu_pref', 'Pemberitahuan Status Izin / Dispensasi');
            Setting::setByKey('ortu_notif_laporan', $request->has('ortu_notif_laporan') ? '1' : '0', 'ortu_pref', 'Laporan Rekap Bulanan Presensi Anak');
            Setting::setByKey('ortu_notif_pengumuman', $request->has('ortu_notif_pengumuman') ? '1' : '0', 'ortu_pref', 'Notifikasi Broadcast Informasi Sekolah');
            Setting::setByKey('ortu_export_format', $request->input('ortu_export_format', 'pdf'), 'ortu_pref', 'Format Default Ekspor Laporan Presensi Anak');
        } else {
            Setting::setByKey('guru_notif_izin', $request->has('guru_notif_izin') ? '1' : '0', 'guru_pref', 'Notifikasi Surat Izin/Sakit');
            Setting::setByKey('guru_notif_jurnal', $request->has('guru_notif_jurnal') ? '1' : '0', 'guru_pref', 'Notifikasi Pengingat Jurnal');
            Setting::setByKey('guru_notif_dispensasi', $request->has('guru_notif_dispensasi') ? '1' : '0', 'guru_pref', 'Notifikasi Dispensasi Siswa');
            Setting::setByKey('guru_export_format', $request->input('guru_export_format', 'pdf'), 'guru_pref', 'Format Default Ekspor Jurnal');
            Setting::setByKey('guru_data_per_page', $request->input('guru_data_per_page', '25'), 'guru_pref', 'Jumlah Data per Halaman');
        }

        return redirect()->route('pengaturan.index')
            ->with('success', 'Preferensi & pengaturan notifikasi Anda berhasil disimpan!')
            ->with('active_tab', 'preferences');
    }

    /**
     * Update pengaturan sistem (Khusus Admin / TU).
     */
    public function updateSystemSettings(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return redirect()->route('pengaturan.index')->with('error', 'Anda tidak memiliki hak akses untuk mengubah pengaturan sistem.');
        }

        $request->validate([
            'cs_whatsapp'        => 'required|string',
            'cs_email'           => 'required|email',
            'cs_jam_kerja'       => 'required|string',
            'app_name'           => 'required|string',
            'tahun_ajaran_aktif' => 'required|string',
            'semester_aktif'     => 'required|string',
        ]);

        Setting::setByKey('cs_whatsapp', preg_replace('/[^0-9]/', '', $request->cs_whatsapp), 'cs', 'Nomor WhatsApp CS');
        Setting::setByKey('cs_email', $request->cs_email, 'cs', 'Email Customer Service');
        Setting::setByKey('cs_jam_kerja', $request->cs_jam_kerja, 'cs', 'Jam Operasional CS');
        Setting::setByKey('app_name', $request->app_name, 'general', 'Nama Aplikasi');
        Setting::setByKey('tahun_ajaran_aktif', $request->tahun_ajaran_aktif, 'academic', 'Tahun Ajaran Aktif');
        Setting::setByKey('semester_aktif', $request->semester_aktif, 'academic', 'Semester Aktif');

        try {
            $matchTa = \App\Models\TahunAjaran::where('tahun_ajaran', $request->tahun_ajaran_aktif)
                ->where('semester', $request->semester_aktif)
                ->first();
            if ($matchTa) {
                $matchTa->activate();
            } else {
                $newTa = \App\Models\TahunAjaran::create([
                    'tahun_ajaran' => $request->tahun_ajaran_aktif,
                    'semester'     => $request->semester_aktif,
                    'is_aktif'     => true,
                    'buka_jurnal'  => true,
                ]);
                $newTa->activate();
            }
        } catch (\Throwable $e) {
            // Ignore if table not ready
        }

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan sistem & hotline CS berhasil disimpan!');
    }
}
