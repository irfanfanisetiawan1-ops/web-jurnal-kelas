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
        $user = Auth::user();
        
        // Ambil data settings sistem (untuk Admin/TU)
        $systemSettings = [
            'cs_whatsapp' => Setting::getByKey('cs_whatsapp', '6281234567890'),
            'cs_email' => Setting::getByKey('cs_email', 'cs.jurnal@esemkita.sch.id'),
            'cs_jam_kerja' => Setting::getByKey('cs_jam_kerja', 'Senin - Jumat (07:00 - 15:30 WIB)'),
            'app_name' => Setting::getByKey('app_name', 'Jurnal ESEMKITA'),
            'tahun_ajaran_aktif' => Setting::getByKey('tahun_ajaran_aktif', '2025/2026'),
            'semester_aktif' => Setting::getByKey('semester_aktif', 'Genap'),
        ];

        // Jika user admin/TU, gunakan layout admin, selainnya layout guru
        $layout = $user->isAdmin() ? 'layouts.admin' : 'layouts.guru';

        return view('pengaturan.index', compact('user', 'systemSettings', 'layout'));
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
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'name.min'       => 'Nama lengkap minimal 3 karakter.',
            'email.email'    => 'Format alamat email tidak valid.',
            'email.unique'   => 'Email ini sudah digunakan oleh akun lain.',
            'no_hp.max'      => 'Nomor HP maksimal 20 karakter.',
        ]);

        $user->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'no_hp'         => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        // Sinkronisasi data ke tabel guru jika akun ini memiliki relasi data guru
        if ($user->id_guru || $user->nip) {
            $guru = $user->guru ?? \App\Models\Guru::where('nip', $user->nip)->first();
            if ($guru) {
                $guruData = [
                    'nama_guru' => $request->name,
                ];
                if ($request->filled('no_hp')) {
                    $guruData['no_hp'] = $request->no_hp;
                }
                if ($request->has('jenis_kelamin')) {
                    $guruData['jenis_kelamin'] = $request->jenis_kelamin;
                }
                $guru->update($guruData);
            }
        }

        return redirect()->route('pengaturan.index')
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
            return redirect()->route('pengaturan.index')
                ->withErrors(['current_password' => 'Password saat ini salah. Silakan masukkan password akun Anda yang benar!'])
                ->withInput()
                ->with('active_tab', 'security');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('pengaturan.index')
            ->with('success', 'Password Anda berhasil diperbarui!')
            ->with('active_tab', 'security');
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

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan sistem & hotline CS berhasil disimpan!');
    }
}
