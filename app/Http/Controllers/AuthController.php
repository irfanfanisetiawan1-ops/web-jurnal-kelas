<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;

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

    // ─── Proses Login (NIP + Password) ────────────────────────────────────────

    public function login(Request $request)
    {
        $request->validate([
            'nip'      => 'required|numeric|digits:18',
            'password' => 'required|string',
        ], [
            'nip.required'      => 'NIP wajib diisi.',
            'nip.numeric'       => 'NIP harus berupa angka.',
            'nip.digits'        => 'NIP harus berisi tepat 18 digit angka.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $nip      = trim($request->input('nip'));
        $password = $request->input('password');

        // Cari user berdasarkan NIP di tabel users
        $user = User::where('nip', $nip)->whereNull('deleted_at')->first();

        // Jika tidak ditemukan di users, coba cari melalui tabel guru
        if (!$user) {
            $guru = Guru::where('nip', $nip)->first();
            if ($guru) {
                $user = User::where('id_guru', $guru->id_guru)->whereNull('deleted_at')->first();
            }
        }

        // Validasi user dan password
        if (!$user) {
            return back()->withInput($request->only('nip'))->with('error', 'NIP tidak ditemukan dalam sistem. Silakan hubungi Admin TU.');
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

    private function redirectByRole(User $user)
    {
        $roleLabel = $user->role_label;

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
        }

        // Guru, Wali Kelas, Piket → portal guru
        return redirect()->route('guru.dashboard')
            ->with('success', "Selamat datang, {$user->name}! Anda masuk sebagai {$roleLabel}.");
    }
}
