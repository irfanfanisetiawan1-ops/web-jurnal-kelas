<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\GuruIzin;
use App\Models\SiswaDispen;
use App\Models\User;

class ApprovalPublicController extends Controller
{
    /**
     * Tampilkan Halaman Persetujuan Link Unik Izin Guru (Waka / Kepsek)
     */
    public function showGuruIzin($token)
    {
        $izin = GuruIzin::with('guru')->where('token_approval', $token)->firstOrFail();
        return view('approval.guru_izin', compact('izin'));
    }

    /**
     * Proses Persetujuan Waka / Kepsek Izin Guru via Link Token dengan Otentikasi NIP & Password
     */
    public function processGuruIzin(Request $request, $token)
    {
        $request->validate([
            'role_approver' => 'required|in:waka,waka_sdm,kepala_sekolah',
            'nip_username'  => 'required|string|min:3|max:50',
            'password'      => 'required|string|min:3|max:100',
            'action'        => 'required|in:approved,rejected',
            'catatan'       => 'nullable|string|max:500',
        ], [
            'role_approver.required' => 'Pilih peran/jabatan Anda terlebih dahulu.',
            'nip_username.required'  => 'Masukkan NIP atau Username Anda untuk verifikasi identitas.',
            'nip_username.min'       => 'NIP / Username minimal 3 karakter.',
            'nip_username.max'       => 'NIP / Username maksimal 50 karakter.',
            'password.required'      => 'Masukkan Password akun Anda untuk otentikasi.',
        ]);

        $izin = GuruIzin::where('token_approval', $token)->firstOrFail();

        // Cek jika peran yang dipilih sudah pernah memberikan keputusan
        if ($request->role_approver === 'waka' && $izin->status_waka !== 'pending') {
            return redirect()->back()->withErrors(['auth' => 'Waka Kurikulum sudah pernah memberikan respon persetujuan untuk pengajuan izin ini.'])->withInput();
        }
        if ($request->role_approver === 'waka_sdm' && $izin->status_waka_sdm !== 'pending') {
            return redirect()->back()->withErrors(['auth' => 'Waka SDM sudah pernah memberikan respon persetujuan untuk pengajuan izin ini.'])->withInput();
        }
        if ($request->role_approver === 'kepala_sekolah' && $izin->status_kepsek !== 'pending') {
            return redirect()->back()->withErrors(['auth' => 'Kepala Sekolah sudah pernah memberikan respon persetujuan untuk pengajuan izin ini.'])->withInput();
        }

        $loginInput = trim($request->nip_username);

        // 1. Verifikasi Format NIP jika seluruhnya angka (NIP PNS/ASN = 18 digit)
        if (ctype_digit($loginInput) && strlen($loginInput) !== 18) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: Format NIP '{$loginInput}' tidak valid! (NIP PNS/ASN harus terdiri dari tepat 18 digit angka, saat ini: " . strlen($loginInput) . " digit)."
            ])->withInput();
        }

        // 2. Verifikasi Ketersediaan User di tabel users (Data Pengguna Role TU)
        $user = User::where('nip', $loginInput)
            ->orWhere('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: NIP / Username '{$loginInput}' tidak terdaftar pada data Pengguna sistem (Role TU)!"
            ])->withInput();
        }

        // 3. Verifikasi Status Verifikasi Akun
        if (isset($user->status_verifikasi) && $user->status_verifikasi !== 'verified') {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: Akun '{$user->name}' belum berstatus Terverifikasi oleh Admin TU!"
            ])->withInput();
        }

        // 4. Verifikasi Password Akun
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: Password akun yang Anda masukkan untuk NIP/Username '{$loginInput}' tidak sesuai dengan data Pengguna di database!"
            ])->withInput();
        }

        // 5. Verifikasi Otorisasi Peran / Jabatan
        if ($request->role_approver === 'waka') {
            $isValidWaka = ($user->role === 'waka') || (method_exists($user, 'isWakaKurikulum') && $user->isWakaKurikulum()) || ($user->role === 'waka') || in_array($user->role, ['admin', 'tu']);
            if (!$isValidWaka) {
                return redirect()->back()->withErrors([
                    'auth' => "Verifikasi Gagal: Akun '{$user->name}' (NIP: {$user->nip}) ber-role '{$user->role_label}', tidak memiliki kewenangan sebagai Waka Kurikulum. Silakan gunakan NIP & Password akun Waka Kurikulum yang sah."
                ])->withInput();
            }
        } elseif ($request->role_approver === 'waka_sdm') {
            $isValidWakaSdm = ($user->role === 'waka_sdm') || (method_exists($user, 'isWakaSdm') && $user->isWakaSdm()) || in_array($user->role, ['admin', 'tu']);
            if (!$isValidWakaSdm) {
                return redirect()->back()->withErrors([
                    'auth' => "Verifikasi Gagal: Akun '{$user->name}' (NIP: {$user->nip}) ber-role '{$user->role_label}', tidak memiliki kewenangan sebagai Waka SDM. Silakan gunakan NIP & Password akun Waka SDM yang sah."
                ])->withInput();
            }
        } elseif ($request->role_approver === 'kepala_sekolah') {
            $isValidKepsek = ($user->role === 'kepala_sekolah') || (method_exists($user, 'isKepalaSekolah') && $user->isKepalaSekolah()) || in_array($user->role, ['admin', 'tu']);
            if (!$isValidKepsek) {
                return redirect()->back()->withErrors([
                    'auth' => "Verifikasi Gagal: Akun '{$user->name}' (NIP: {$user->nip}) ber-role '{$user->role_label}', tidak memiliki kewenangan sebagai Kepala Sekolah. Silakan gunakan NIP & Password akun Kepala Sekolah yang sah."
                ])->withInput();
            }
        }

        // 6. Proteksi Mandiri: Guru tidak boleh menyetujui izin dirinya sendiri
        if ($user->id_guru && $izin->id_guru && $user->id_guru == $izin->id_guru) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: Anda tidak dapat menyetujui/menolak permohonan izin Anda sendiri. Persetujuan harus dilakukan oleh pimpinan lain."
            ])->withInput();
        }

        // 7. Validasi Alasan Penolakan jika Action = Rejected
        if ($request->action === 'rejected' && empty(trim($request->catatan))) {
            return redirect()->back()->withErrors([
                'catatan' => 'Alasan penolakan wajib diisi jika Anda menolak pengajuan izin guru ini.'
            ])->withInput();
        }

        // 8. Update Status Persetujuan & Status Final
        if ($request->role_approver === 'waka') {
            $izin->status_waka = $request->action;
            $izin->catatan_waka = $request->catatan;
        } elseif ($request->role_approver === 'waka_sdm') {
            $izin->status_waka_sdm = $request->action;
            if (!empty($request->catatan)) {
                $izin->catatan_waka = $request->catatan;
            }
        } elseif ($request->role_approver === 'kepala_sekolah') {
            $izin->status_kepsek = $request->action;
            $izin->catatan_kepsek = $request->catatan;
        }

        // Kalkulasi Status Final
        if ($request->action === 'rejected') {
            $izin->status_final = 'rejected';
        } else {
            if ($request->role_approver === 'kepala_sekolah') {
                $izin->status_final = 'approved';
                if ($izin->status_waka === 'pending') $izin->status_waka = 'approved';
                if ($izin->status_waka_sdm === 'pending') $izin->status_waka_sdm = 'approved';
            } elseif ($izin->status_waka === 'approved' && $izin->status_waka_sdm === 'approved' && $izin->status_kepsek === 'approved') {
                $izin->status_final = 'approved';
            } else {
                $izin->status_final = 'pending';
            }
        }

        $izin->save();

        $roleLabel = match ($request->role_approver) {
            'waka'           => 'Waka Kurikulum',
            'waka_sdm'       => 'Waka SDM',
            'kepala_sekolah' => 'Kepala Sekolah',
            default          => 'Pimpinan',
        };

        $statusTeks = $request->action === 'approved' ? 'Disetujui' : 'Ditolak';

        return redirect()->back()->with('success', "Otentikasi Berhasil! Status persetujuan izin guru oleh {$roleLabel} ({$user->name}) telah disimpan ({$statusTeks}).");
    }

    /**
     * Tampilkan Halaman Persetujuan Link Unik Dispen Siswa (Waka)
     */
    public function showSiswaDispen($token)
    {
        $dispen = SiswaDispen::with(['siswa', 'kelas', 'jurnalPiket', 'wakaUser'])->where('token_wali_kelas', $token)->firstOrFail();
        return view('approval.siswa_dispen', compact('dispen'));
    }

    /**
     * Proses Persetujuan Waka via Link Token dengan Otentikasi NIP & Password
     */
    public function processSiswaDispen(Request $request, $token)
    {
        $request->validate([
            'nip_username'  => 'required|string|min:3|max:50',
            'password'      => 'required|string|min:3|max:100',
            'action'        => 'required|in:approved,rejected',
            'catatan'       => 'nullable|string|max:500',
        ], [
            'nip_username.required'  => 'Masukkan NIP atau Username Anda untuk verifikasi identitas Waka.',
            'nip_username.min'       => 'NIP / Username minimal 3 karakter.',
            'nip_username.max'       => 'NIP / Username maksimal 50 karakter.',
            'password.required'      => 'Masukkan Password akun Anda untuk otentikasi Waka.',
            'action.required'        => 'Pilih tindakan persetujuan (Setujui atau Tolak).',
        ]);

        $dispen = SiswaDispen::with(['siswa', 'kelas'])->where('token_wali_kelas', $token)->firstOrFail();

        // Cek jika sudah pernah di-respond
        if ($dispen->status_waka !== 'pending') {
            $statusTeks = $dispen->status_waka === 'approved' ? 'DISETUJUI' : 'DITOLAK';
            return redirect()->back()->withErrors([
                'auth' => "Pengajuan dispensasi siswa ini sudah pernah diproses ({$statusTeks}). Keputusan tidak dapat diubah kembali."
            ])->withInput();
        }

        $loginInput = trim($request->nip_username);

        // 1. Verifikasi Format NIP jika digit angka 18
        if (ctype_digit($loginInput) && strlen($loginInput) !== 18) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: Format NIP '{$loginInput}' tidak valid! (NIP PNS/ASN harus terdiri dari tepat 18 digit angka, saat ini: " . strlen($loginInput) . " digit)."
            ])->withInput();
        }

        // 2. Verifikasi Ketersediaan User di tabel users (Data Pengguna Role TU)
        $user = User::where('nip', $loginInput)
            ->orWhere('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: NIP / Username '{$loginInput}' tidak terdaftar pada data Pengguna sistem (Role TU)!"
            ])->withInput();
        }

        // 3. Verifikasi Status Verifikasi Akun
        if (isset($user->status_verifikasi) && $user->status_verifikasi !== 'verified') {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: Akun '{$user->name}' belum berstatus Terverifikasi oleh Admin TU!"
            ])->withInput();
        }

        // 4. Verifikasi Password Akun
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: Password akun yang Anda masukkan untuk NIP/Username '{$loginInput}' tidak sesuai dengan data Pengguna di database!"
            ])->withInput();
        }

        // 5. Verifikasi Otorisasi Waka
        $isValidWaka = ($user->role === 'waka') || (method_exists($user, 'isWaka') && $user->isWaka()) || in_array($user->role, ['admin', 'tu']);
        if (!$isValidWaka) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: Akun '{$user->name}' (NIP: {$user->nip}) ber-role '{$user->role_label}', tidak memiliki kewenangan sebagai Waka. Silakan gunakan NIP & Password akun Waka yang sah."
            ])->withInput();
        }

        // 6. Validasi Alasan Penolakan jika Action = Rejected
        if ($request->action === 'rejected' && empty(trim($request->catatan))) {
            return redirect()->back()->withErrors([
                'catatan' => 'Alasan penolakan WAJIB diisi jika Anda menolak pengajuan dispensasi siswa ini.'
            ])->withInput();
        }

        // Update Data Dispensasi Siswa
        $dispen->status_waka = $request->action;
        $dispen->status_wali_kelas = $request->action;
        $dispen->catatan_waka = $request->catatan ?? ($request->action === 'approved' ? 'Disetujui oleh Waka' : 'Ditolak oleh Waka');
        $dispen->waktu_approval_waka = now();

        if ($request->action === 'approved') {
            $dispen->status_satpam = 'belum_keluar';
            $dispen->save();
            $namaSiswa = $dispen->siswa->nama_siswa ?? 'Siswa';
            $namaKelas = $dispen->kelas->nama_kelas ?? '-';
            $jamRange  = ($dispen->jam_keluar ?? '00:00') . ' s/d ' . ($dispen->jam_kembali ?? '00:00');
            $tglIndo   = \Carbon\Carbon::parse($dispen->tanggal)->format('d-m-Y');

            $linkKartu = $dispen->foto_kartu_identitas ? asset($dispen->foto_kartu_identitas) : null;
            $linkSurat = $dispen->foto_surat_dispen ? asset($dispen->foto_surat_dispen) : null;
            $linkDispenPage = url("/approval/dispen/{$token}");

            $pesanWaSatpam = "OFFICIAL NOTIFIKASI DISPENSASI SISWA (EDU JOURNAL)\n"
                . "===============================================\n\n"
                . "Memberitahukan bahwa permohonan dispensasi siswa berikut telah DISETUJUI oleh Waka ({$user->name}):\n\n"
                . "* Kode Dispen: {$dispen->kode_dispen}\n"
                . "* Nama Siswa: {$namaSiswa}\n"
                . "* Kelas: {$namaKelas}\n"
                . "* Tanggal & Jam: {$tglIndo} ({$jamRange})\n"
                . "* Alasan Dispen: {$dispen->alasan}\n";

            if ($linkKartu) {
                $pesanWaSatpam .= "* Lihat Foto Kartu Pelajar: {$linkKartu}\n";
            }
            if ($linkSurat) {
                $pesanWaSatpam .= "* Lihat Surat Dispen Resmi: {$linkSurat}\n";
            }

            $pesanWaSatpam .= "\n* Link Verifikasi Detail: {$linkDispenPage}\n\n"
                . "STATUS: TERVERIFIKASI & DISETUJUI WAKA.\n"
                . "Petugas Satpam dapat mencocokkan fisik Kartu Identitas Siswa/Kartu Pelajar dengan foto terlampir, lalu membiarkan siswa keluar sekolah";

            $waSatpamUrl = "https://api.whatsapp.com/send?text=" . urlencode($pesanWaSatpam);

            return redirect()->back()->with([
                'success'         => "Otentikasi Berhasil! Status persetujuan dispensasi siswa oleh Waka ({$user->name}) telah DISETUJUI. Data siswa otomatis dikirim ke Portal Satpam.",
                'wa_satpam_url'   => $waSatpamUrl,
                'pesan_wa_satpam' => $pesanWaSatpam,
            ]);
        } else {
            $dispen->status_satpam = 'ditolak';
            $dispen->save();

            return redirect()->back()->with('success', "Otentikasi Berhasil! Permohonan dispensasi siswa telah DITOLAK oleh Waka ({$user->name}) dengan alasan: \"{$request->catatan}\". Catatan penolakan akan tampil pada Halaman Guru Piket.");
        }
    }
}
