<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;

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

        if (!Hash::check($password, $user->password)) {
            return back()->withInput($request->only('nisn'))
                ->with('error', 'Password yang Anda masukkan salah.');
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
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    // ─── Helper: Redirect by Role ─────────────────────────────────────────────

    public function redirectByRole(User $user)
    {
        $roleLabel = $user->role_label;

        if ($user->isTu()) {
            return redirect()->route('admin.dashboard')
                ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
        }

        if ($user->isWakaSdm()) {
            return redirect()->route('waka-sdm.dashboard')
                ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
        }

        if ($user->isWaka()) {
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
