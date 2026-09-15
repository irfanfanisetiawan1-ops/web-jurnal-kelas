<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\JadwalGuruPiket;
use App\Models\TahunAjaran;
use Carbon\Carbon;

class AuthController extends Controller
{
    // ─── Show Login Form ──────────────────────────────────────────────────────

    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    // ─── Show Login Form Orang Tua ────────────────────────────────────────────

    public function showOrangTuaLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login_orang_tua');
    }

    // ─── Show Login Form Guru Piket & Satpam ──────────────────────────────────

    public function showPetugasLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login_petugas');
    }

    // ─── Proses Login (NIP / Username / Email + Password) ──────────────────────

    public function login(Request $request)
    {
        $request->validate([
            'nip'      => 'required|string',
            'password' => 'required|string',
        ], [
            'nip.required'      => 'NIP / Username / Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $identity = trim($request->input('nip'));
        $password = $request->input('password');

        // Cari user berdasarkan NIP, username, atau email di tabel users
        $user = User::where(function($q) use ($identity) {
            $q->where('nip', $identity)
              ->orWhere('username', $identity)
              ->orWhere('email', $identity);
        })->whereNull('deleted_at')->first();

        // Jika tidak ditemukan di users, coba cari melalui NIP tabel guru
        if (!$user) {
            $guru = Guru::where('nip', $identity)->first();
            if ($guru) {
                $user = User::where('id_guru', $guru->id_guru)->whereNull('deleted_at')->first();
            }
        }

        // Validasi user dan password
        if (!$user) {
            return back()->withInput($request->only('nip'))->with('error', 'Identitas NIP / Username / Email tidak ditemukan dalam sistem. Silakan hubungi Admin TU.');
        }

        if (!Hash::check($password, $user->password)) {
            return back()->withInput($request->only('nip'))->with('error', 'Password yang Anda masukkan salah.');
        }

        // Cek status keaktifan akun (ON / OFF)
        if (!$user->isActive()) {
            return back()->withInput($request->only('nip'))->with('error', 'Akun Anda sedang dinonaktifkan oleh Administrator TU. Silakan hubungi pihak Tata Usaha.');
        }

        // Cek status verifikasi
        if ($user->status_verifikasi === 'pending') {
            return back()->withInput($request->only('nip'))->with('error', 'Akun Anda sedang menunggu verifikasi oleh Administrator TU. Silakan hubungi pihak TU.');
        }

        if ($user->status_verifikasi === 'rejected') {
            return back()->withInput($request->only('nip'))->with('error', 'Akun Anda telah ditolak oleh Administrator. Silakan hubungi pihak sekolah untuk informasi lebih lanjut.');
        }

        // Login berhasil
        User::syncWaliKelasRoles();
        $user->refresh();

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Khusus Guru Mengajar / Wali Kelas: Cek apakah hari ini terjadwal sebagai Guru Piket oleh Waka Kurikulum
        if (in_array($user->role, ['guru', 'wali_kelas']) && JadwalGuruPiket::isUserPiketHariIni($user)) {
            $rememberMode = session('remember_mode_for_today');
            if ($rememberMode === 'piket') {
                return $this->doSwitchToPiket($user);
            } elseif ($rememberMode === 'guru') {
                return redirect()->route('guru.dashboard')
                    ->with('success', "Selamat datang kembali, {$user->name}! Anda masuk sebagai {$user->role_label}.");
            }

            return redirect()->route('auth.pilih-mode');
        }

        return $this->redirectByRole($user);
    }

    // ─── Proses Login Orang Tua (NISN + Password) ──────────────────────────────

    public function loginOrangTua(Request $request)
    {
        $request->validate([
            'nisn'     => 'required|numeric|digits:10',
            'password' => 'required|string',
        ], [
            'nisn.required'     => 'NISN wajib diisi.',
            'nisn.numeric'      => 'NISN harus berupa angka.',
            'nisn.digits'       => 'NISN harus berisi tepat 10 digit angka.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $nisn     = trim($request->input('nisn'));
        $password = $request->input('password');

        // Cari siswa berdasarkan NISN atau NIS
        $siswa = Siswa::withoutGlobalScopes()
            ->where('nisn', $nisn)
            ->orWhere('nis', $nisn)
            ->first();

        // Cari user dengan role orang_tua
        $user = User::where('role', 'orang_tua')
            ->where(function($q) use ($nisn, $siswa) {
                $q->where('nip', $nisn)
                  ->orWhere('username', $nisn)
                  ->orWhere('email', $nisn);
                if ($siswa) {
                    $q->orWhere('id_siswa', $siswa->id_siswa);
                }
            })
            ->whereNull('deleted_at')
            ->first();

        if (!$user) {
            return back()->withInput($request->only('nisn'))
                ->with('error', 'NISN Siswa tidak ditemukan atau belum terdaftar di akun Orang Tua. Silakan hubungi Admin TU.');
        }

        // Sinkronisasi id_siswa jika belum terpasang
        if ($siswa && empty($user->id_siswa)) {
            $user->update(['id_siswa' => $siswa->id_siswa]);
        }

        $isPassValid = Hash::check($password, $user->password);

        // Jika tidak lolos hash standar, cek apakah password cocok dengan variasi format tanggal lahir siswa
        if (!$isPassValid && $siswa && !empty($siswa->tanggal_lahir) && $siswa->tanggal_lahir !== '0000-00-00') {
            try {
                $tgl = \Carbon\Carbon::parse($siswa->tanggal_lahir);
                $variations = [
                    $tgl->format('Y-m-d'),
                    $tgl->format('d-m-Y'),
                    $tgl->format('d/m/Y'),
                    $tgl->format('dmY'),
                    $tgl->format('Ymd'),
                ];
                if (in_array(trim($password), $variations)) {
                    $isPassValid = true;
                }
            } catch (\Exception $e) {
                // Ignore parse error
            }
        }

        if (!$isPassValid) {
            return back()->withInput($request->only('nisn'))
                ->with('error', 'Password yang Anda masukkan salah.');
        }

        // Cek status keaktifan akun (ON / OFF)
        if (!$user->isActive()) {
            return back()->withInput($request->only('nisn'))
                ->with('error', 'Akun Orang Tua Anda sedang dinonaktifkan oleh Administrator TU. Silakan hubungi pihak Tata Usaha.');
        }

        if ($user->status_verifikasi === 'pending') {
            return back()->withInput($request->only('nisn'))
                ->with('error', 'Akun Orang Tua Anda sedang menunggu verifikasi oleh Administrator TU.');
        }

        if ($user->status_verifikasi === 'rejected') {
            return back()->withInput($request->only('nisn'))
                ->with('error', 'Akun Orang Tua Anda telah ditolak oleh Administrator. Silakan hubungi pihak sekolah.');
        }

        User::syncWaliKelasRoles();
        $user->refresh();

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    // ─── Proses Login Guru Piket & Satpam (Username + Password) ───────────────

    public function loginPetugas(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username petugas wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $username = trim($request->input('username'));
        $password = $request->input('password');

        // Cari user khusus role Guru Piket ('piket') atau Satpam ('satpam')
        $user = User::whereIn('role', ['piket', 'satpam'])
            ->where(function($q) use ($username) {
                $q->where('username', $username)
                  ->orWhere('nip', $username)
                  ->orWhere('email', $username);
            })
            ->whereNull('deleted_at')
            ->first();

        if (!$user) {
            return back()->withInput($request->only('username'))
                ->with('error', 'Username petugas tidak ditemukan atau Anda tidak memiliki hak akses Guru Piket / Satpam.');
        }

        if (!Hash::check($password, $user->password)) {
            return back()->withInput($request->only('username'))
                ->with('error', 'Password yang Anda masukkan salah.');
        }

        // Cek status keaktifan akun (ON / OFF)
        if (!$user->isActive()) {
            return back()->withInput($request->only('username'))
                ->with('error', 'Akun Petugas Anda sedang dinonaktifkan oleh Administrator TU. Silakan hubungi pihak Tata Usaha.');
        }

        // Cek status verifikasi
        if ($user->status_verifikasi === 'pending') {
            return back()->withInput($request->only('username'))
                ->with('error', 'Akun Petugas Anda sedang menunggu verifikasi oleh Administrator TU.');
        }

        if ($user->status_verifikasi === 'rejected') {
            return back()->withInput($request->only('username'))
                ->with('error', 'Akun Petugas Anda telah ditolak oleh Administrator. Silakan hubungi pihak sekolah.');
        }

        User::syncWaliKelasRoles();
        $user->refresh();

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    // ─── Halaman Register (Disabled) ─────────────────────────────────────────

    public function showRegisterForm()
    {
        return redirect()->route('login')->with('error', 'Pendaftaran akun pengguna tidak dibuka secara publik. Seluruh akun pengguna dibuat dan diverifikasi oleh Administrator Tata Usaha (TU).');
    }

    public function register(Request $request)
    {
        return redirect()->route('login')->with('error', 'Pendaftaran akun pengguna tidak dibuka secara publik. Seluruh akun pengguna dibuat dan diverifikasi oleh Administrator Tata Usaha (TU).');
    }

    // ─── Logout ───────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        $request->session()->forget(['original_guru_user_id', 'active_mode', 'remember_mode_for_today']);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->filled('redirect_to')) {
            $target = $request->input('redirect_to');
            if (in_array($target, ['login.petugas', 'petugas', 'piket', '/login-petugas'])) {
                return redirect()->route('login.petugas')->with('success', 'Anda telah berhasil keluar dari sistem. Silakan masuk menggunakan akun Petugas Piket.');
            }
            if (in_array($target, ['login.orang-tua', 'orang-tua', 'ortu'])) {
                return redirect()->route('login.orang-tua')->with('success', 'Anda telah berhasil keluar dari sistem.');
            }
        }

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    // ─── Mode Masuk Ganda & Sakelar Peran Guru / Piket ─────────────────────────

    /**
     * Tampilkan Halaman Antarmuka "Pilih Mode Masuk Sistem"
     */
    public function showPilihModeForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Jika sedang dalam sesi piket yang diswitch dari akun guru
        if ($user->role === 'piket' && session()->has('original_guru_user_id')) {
            $guruUser = User::find(session('original_guru_user_id')) ?? $user;
        } else {
            $guruUser = $user;
        }

        // Pastikan hanya guru yang terjadwal piket hari ini yang dapat mengakses halaman ini
        if (!JadwalGuruPiket::isUserPiketHariIni($guruUser)) {
            return $this->redirectByRole($user);
        }

        $now = Carbon::now('Asia/Jakarta');
        $activeTahunAjaran = TahunAjaran::getActive();

        $mapHariIndo = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];
        $daftarBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $hariNama = $mapHariIndo[$now->format('l')] ?? 'Senin';
        $tanggalStr = $hariNama . ', ' . $now->format('j') . ' ' . ($daftarBulan[(int)$now->format('n')] ?? '') . ' ' . $now->format('Y');

        // Data Guru & Mapel
        $guru = $guruUser->guru;
        if (!$guru && !empty($guruUser->nip)) {
            $guru = Guru::with(['mapel'])->where('nip', $guruUser->nip)->first();
        } elseif ($guru) {
            $guru->loadMissing(['mapel']);
        }

        $namaMapel = $guru && $guru->mapel ? $guru->mapel->nama_mapel : '-';
        $kelasWali = !empty($guruUser->nip) ? \App\Models\Kelas::where('wali_kelas', $guruUser->nip)->first() : null;
        if (!$kelasWali && $guru && !empty($guru->nip)) {
            $kelasWali = \App\Models\Kelas::where('wali_kelas', $guru->nip)->first();
        }
        $isWaliKelas = ($guruUser->role === 'wali_kelas') || !empty($kelasWali);
        $namaKelasWali = $kelasWali ? $kelasWali->nama_kelas : ($isWaliKelas ? 'Wali Kelas' : null);

        // Jadwal KBM Guru Hari Ini
        $jadwalHariIni = collect();
        if ($guru) {
            $jadwalHariIni = \App\Models\Jadwal::with(['kelas', 'mapel', 'jamMulai', 'jamSelesai'])
                ->where('id_guru', $guru->id_guru)
                ->where('hari', $hariNama)
                ->orderBy('id_jam_mulai', 'asc')
                ->get();
        }
        $totalJpHariIni = $jadwalHariIni->sum(fn($j) => $j->jumlah_jp ?? 1);
        $totalKelasHariIni = $jadwalHariIni->pluck('id_kelas')->unique()->count();

        // Slot Penugasan Guru Piket Hari Ini (Dari Waka Kurikulum)
        $slotInfo = JadwalGuruPiket::getSlotPiketHariIni($guruUser);

        // Rekan Tim Guru Piket yang Bertugas Hari Ini
        $targetDate = $now->toDateString();
        $semuaPetugasPiketHariIni = JadwalGuruPiket::with('guru.mapel')
            ->whereDate('tanggal', $targetDate)
            ->whereNotNull('id_guru')
            ->orderBy('slot_ke', 'asc')
            ->get();

        $curGuruId = $guru ? $guru->id_guru : $guruUser->id_guru;
        $rekanPiketHariIni = $semuaPetugasPiketHariIni->filter(function($row) use ($curGuruId) {
            return $row->id_guru != $curGuruId;
        });
        $totalPetugasPiket = $semuaPetugasPiketHariIni->count();

        return view('auth.pilih_mode', compact(
            'user',
            'guruUser',
            'guru',
            'namaMapel',
            'isWaliKelas',
            'namaKelasWali',
            'jadwalHariIni',
            'totalJpHariIni',
            'totalKelasHariIni',
            'slotInfo',
            'rekanPiketHariIni',
            'totalPetugasPiket',
            'now',
            'tanggalStr',
            'activeTahunAjaran'
        ));
    }

    /**
     * Proses Pemilihan Mode Masuk & Sakelar Peran Instan di Dashboard
     */
    public function switchMode(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:guru,piket',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $mode = $request->input('mode');
        $currentUser = Auth::user();

        if ($request->boolean('remember')) {
            session(['remember_mode_for_today' => $mode]);
        }

        if ($mode === 'guru') {
            // Jika saat ini sedang bertindak sebagai akun piket dan ada original_guru_user_id
            if ($currentUser->role === 'piket' && session()->has('original_guru_user_id')) {
                $origId = session('original_guru_user_id');
                $origUser = User::find($origId);

                if ($origUser) {
                    Auth::login($origUser);
                    session()->forget('original_guru_user_id');
                    session(['active_mode' => 'guru']);

                    return redirect()->route('guru.dashboard')
                        ->with('success', "Beralih ke ruang kerja Guru Mengajar ({$origUser->name}).");
                }
            }

            session(['active_mode' => 'guru']);
            return redirect()->route('guru.dashboard')
                ->with('success', "Selamat datang di ruang kerja Guru Mengajar.");
        }

        if ($mode === 'piket') {
            // Jika sudah di role piket, langsung arahkan ke dashboard piket
            if ($currentUser->role === 'piket') {
                return redirect()->route('piket.dashboard');
            }

            // Pastikan guru ini memang terjadwal piket hari ini
            if (!JadwalGuruPiket::isUserPiketHariIni($currentUser)) {
                return back()->with('error', 'Mohon maaf, Anda tidak terjadwal sebagai guru piket pada hari ini.');
            }

            return $this->doSwitchToPiket($currentUser);
        }

        return redirect()->route('guru.dashboard');
    }

    /**
     * Beralih ke Akun Role Guru Piket dengan Profil Tersinkronisasi Otomatis
     */
    public function doSwitchToPiket(User $guruUser)
    {
        $piketUser = User::where('role', 'piket')->first();

        if (!$piketUser) {
            // Jika belum ada user piket di database, buat user piket default
            $piketUser = User::create([
                'name'              => $guruUser->name,
                'username'          => 'piket',
                'nip'               => $guruUser->nip,
                'email'             => 'piket@smkn1boyolangu.sch.id',
                'password'          => Hash::make('piket123'),
                'password_plain'    => 'piket123',
                'role'              => 'piket',
                'status_verifikasi' => 'verified',
                'is_active'         => true,
                'id_guru'           => $guruUser->id_guru,
                'foto'              => $guruUser->foto,
            ]);
        } else {
            // Singkronkan data profil guru yang bertugas ke akun piket
            $guruObj = $guruUser->guru;
            $piketUser->name = $guruUser->name;
            $piketUser->id_guru = $guruUser->id_guru ?? optional($guruObj)->id_guru;
            if (!empty($guruUser->foto)) {
                $piketUser->foto = $guruUser->foto;
            }
            $piketUser->save();
        }

        $origId = $guruUser->id;
        Auth::login($piketUser);
        session(['original_guru_user_id' => $origId, 'active_mode' => 'piket']);

        return redirect()->route('piket.dashboard')
            ->with('success', "Selamat bertugas! Anda berhasil masuk sebagai Guru Piket ({$piketUser->name}).");
    }

    // ─── Helper: Redirect by Role ─────────────────────────────────────────────

    public function redirectByRole(User $user)
    {
        $roleLabel = $user->role_label;

        if ($user->isTu()) {
            return redirect()->route('admin.dashboard')
                ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
        }

        if ($user->isWakaKurikulum()) {
            return redirect()->route('waka-kurikulum.dashboard')
                ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
        }

        if ($user->isWakaSdm()) {
            return redirect()->route('waka-sdm.dashboard')
                ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
        }

        if ($user->isWakaKesiswaan()) {
            return redirect()->route('waka.dashboard')
                ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
        }

        if ($user->isKepalaSekolah()) {
            return redirect()->route('kepala-sekolah.dashboard')
                ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
        }

        if ($user->isSatpam()) {
            return redirect()->route('satpam.dashboard')
                ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
        }

        if ($user->isGuruPiket()) {
            return redirect()->route('piket.dashboard')
                ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
        }

        if ($user->isOrangTua()) {
            return redirect()->route('orang-tua.dashboard')
                ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
        }

        // Default Guru & Wali Kelas → portal guru
        return redirect()->route('guru.dashboard')
            ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
    }
}
