<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\GuruIzin;
use App\Models\SiswaDispen;
use App\Models\SiswaSuratIzin;
use App\Models\SiswaTelat;
use App\Models\User;
use App\Models\JadwalPiketWaka;
use App\Services\WhatsAppNotificationService;

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

        $rawInput = trim($request->nip_username);
        $cleanedDigits = preg_replace('/[^0-9]/', '', $rawInput);
        $loginInput = (strlen($cleanedDigits) === 18) ? $cleanedDigits : $rawInput;

        // 1. Verifikasi Format NIP jika seluruhnya angka (NIP PNS/ASN = 18 digit)
        if (ctype_digit($cleanedDigits) && strlen($cleanedDigits) !== 18 && strlen($rawInput) !== 18) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: Format NIP '{$rawInput}' tidak valid! (NIP PNS/ASN harus terdiri dari tepat 18 digit angka, saat ini: " . strlen($cleanedDigits) . " digit)."
            ])->withInput();
        }

        // 2. Verifikasi Ketersediaan User di tabel users (Data Pengguna Role TU)
        $user = User::where(function($q) use ($loginInput, $cleanedDigits) {
            $q->where('nip', $loginInput)
              ->orWhere('username', $loginInput)
              ->orWhere('email', $loginInput);
            if (!empty($cleanedDigits)) {
                $q->orWhere('nip', $cleanedDigits);
            }
        })->first();

        if (!$user) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: NIP / Username '{$rawInput}' tidak terdaftar pada data Pengguna sistem (Role TU)!"
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
                'auth' => "Verifikasi Gagal: Password akun yang Anda masukkan untuk NIP/Username '{$rawInput}' tidak sesuai dengan data Pengguna di database!"
            ])->withInput();
        }

        // 5. Verifikasi Otorisasi Peran / Jabatan
        if ($request->role_approver === 'waka') {
            $isValidWaka = ($user->role === 'waka') || (method_exists($user, 'isWakaKurikulum') && $user->isWakaKurikulum()) || in_array($user->role, ['admin', 'tu']);
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

        $rawInput = trim($request->nip_username);
        $cleanedDigits = preg_replace('/[^0-9]/', '', $rawInput);
        $loginInput = (strlen($cleanedDigits) === 18) ? $cleanedDigits : $rawInput;

        // 1. Verifikasi Format NIP jika digit angka 18
        if (ctype_digit($cleanedDigits) && strlen($cleanedDigits) !== 18 && strlen($rawInput) !== 18) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: Format NIP '{$rawInput}' tidak valid! (NIP PNS/ASN harus terdiri dari tepat 18 digit angka, saat ini: " . strlen($cleanedDigits) . " digit)."
            ])->withInput();
        }

        // 2. Verifikasi Ketersediaan User di tabel users (Data Pengguna Role TU)
        $user = User::where(function($q) use ($loginInput, $cleanedDigits) {
            $q->where('nip', $loginInput)
              ->orWhere('username', $loginInput)
              ->orWhere('email', $loginInput);
            if (!empty($cleanedDigits)) {
                $q->orWhere('nip', $cleanedDigits);
            }
        })->first();

        if (!$user) {
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: NIP / Username '{$rawInput}' tidak terdaftar pada data Pengguna sistem (Role TU)!"
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
                'auth' => "Verifikasi Gagal: Password akun yang Anda masukkan untuk NIP/Username '{$rawInput}' tidak sesuai dengan data Pengguna di database!"
            ])->withInput();
        }

        // 5. Verifikasi Otorisasi Waka Kesiswaan / Piket Waka Terjadwal
        $isAssignedWaka = ($dispen->id_user_waka && $user->id == $dispen->id_user_waka) ||
                          JadwalPiketWaka::isUserPiketWaka($user, $dispen->tanggal);

        $isValidWaka = ($user->role === 'waka_kesiswaan') || 
                       in_array($user->role, ['admin', 'tu', 'waka']) || 
                       $isAssignedWaka;

        if (!$isValidWaka) {
            $formattedTgl = \Carbon\Carbon::parse($dispen->tanggal)->translatedFormat('d F Y');
            return redirect()->back()->withErrors([
                'auth' => "Verifikasi Gagal: Akun '{$user->name}' (NIP: {$user->nip}) ber-role '{$user->role_label}', tidak memiliki kewenangan sebagai Waka Kesiswaan atau Piket Waka yang ditugaskan pada tanggal {$formattedTgl}. Silakan gunakan NIP & Password akun Waka Kesiswaan atau Guru Piket Waka yang sah."
            ])->withInput();
        }

        // 6. Validasi Alasan Penolakan jika Action = Rejected
        if ($request->action === 'rejected' && empty(trim($request->catatan))) {
            return redirect()->back()->withErrors([
                'catatan' => 'Alasan penolakan WAJIB diisi jika Anda menolak pengajuan dispensasi siswa ini.'
            ])->withInput();
        }

        // Update Data Dispensasi Siswa
        $approverRoleName = $isAssignedWaka ? "Piket Waka ({$user->name})" : 'Waka Kesiswaan';
        $dispen->status_waka = $request->action;
        $dispen->status_wali_kelas = $request->action;
        $dispen->catatan_waka = $request->catatan ?? ($request->action === 'approved' ? "Disetujui oleh {$approverRoleName}" : "Ditolak oleh {$approverRoleName}");
        $dispen->waktu_approval_waka = now();

        if ($request->action === 'approved') {
            $dispen->status_satpam = 'belum_keluar';
            $dispen->save();

            // Generate clean approval URL
            $linkDispenPage = WhatsAppNotificationService::makeApprovalDispenUrl($token);

            // Kirim notifikasi resmi secara otomatis ke Petugas Satpam via ChatBot WhatsApp
            $waService = app(WhatsAppNotificationService::class);
            $satpamResult = $waService->sendNotifikasiDispensasiKeSatpam($dispen, $user->name, $linkDispenPage);

            $pesanWaSatpam = $satpamResult['pesan'] ?? $waService->buildPesanDispensasiKeSatpam($dispen, $user->name, $linkDispenPage);

            $primarySatpam = $satpamResult['primary'] ?? null;
            $hpSatpam = $primarySatpam['no_hp'] ?? null;
            $hpSatpamFormatted = WhatsAppNotificationService::formatPhoneNumber($hpSatpam);

            $waSatpamUrl = !empty($hpSatpamFormatted)
                ? "https://api.whatsapp.com/send?phone={$hpSatpamFormatted}&text=" . urlencode($pesanWaSatpam)
                : "https://api.whatsapp.com/send?text=" . urlencode($pesanWaSatpam);

            $chatbotSuccess = $satpamResult['success'] ?? false;
            $namaSatpam = $primarySatpam['nama'] ?? 'Petugas Satpam';

            $suksesMsg = "Otentikasi Berhasil! Status persetujuan dispensasi siswa oleh Waka Kesiswaan ({$user->name}) telah DISETUJUI.";
            if ($chatbotSuccess) {
                $suksesMsg .= " Notifikasi resmi telah berhasil dikirimkan secara otomatis oleh ChatBot WhatsApp ke Petugas Satpam ({$namaSatpam} - {$hpSatpam}).";
            } else {
                $suksesMsg .= " Data dispensasi siswa telah diverifikasi dan diteruskan ke Portal Satpam.";
            }

            return redirect()->back()->with([
                'success'           => $suksesMsg,
                'wa_satpam_url'     => $waSatpamUrl,
                'pesan_wa_satpam'   => $pesanWaSatpam,
                'satpam_wa_result'  => $satpamResult,
                'chatbot_sent'      => $chatbotSuccess,
            ]);
        } else {
            $dispen->status_satpam = 'ditolak';
            $dispen->save();

            return redirect()->back()->with('success', "Otentikasi Berhasil! Permohonan dispensasi siswa telah DITOLAK oleh Waka Kesiswaan ({$user->name}) dengan alasan: \"{$request->catatan}\". Catatan penolakan akan tampil pada Halaman Guru Piket.");
        }
    }

    /**
     * Kirim ulang notifikasi dispensasi ke Satpam via ChatBot WhatsApp
     */
    public function resendNotifSatpam(Request $request, string $token)
    {
        $dispen = SiswaDispen::with(['siswa', 'kelas'])->where('token_wali_kelas', $token)->firstOrFail();

        if ($dispen->status_waka !== 'approved') {
            return redirect()->back()->withErrors([
                'auth' => 'Dispensasi siswa belum disetujui oleh Waka Kesiswaan, notifikasi ke Satpam belum dapat dikirim.'
            ]);
        }

        $linkDispenPage = WhatsAppNotificationService::makeApprovalDispenUrl($token);
        $waService = app(WhatsAppNotificationService::class);
        $satpamResult = $waService->sendNotifikasiDispensasiKeSatpam($dispen, $dispen->nama_waka, $linkDispenPage);

        $primarySatpam = $satpamResult['primary'] ?? null;
        $hpSatpam = $primarySatpam['no_hp'] ?? null;
        $namaSatpam = $primarySatpam['nama'] ?? 'Petugas Satpam';

        if ($satpamResult['success'] ?? false) {
            return redirect()->back()->with('success', "Notifikasi dispensasi berhasil dikirim ulang secara otomatis melalui ChatBot WhatsApp ke Petugas Satpam ({$namaSatpam} - {$hpSatpam}).");
        } else {
            $reason = $primarySatpam['detail']['message'] ?? 'Gagal memproses pesan ke WhatsApp Gateway';
            return redirect()->back()->withErrors([
                'auth' => "Gagal mengirim notifikasi ChatBot WhatsApp ke Satpam: {$reason}. Anda dapat menggunakan tombol Kirim Manual via WhatsApp di bawah."
            ]);
        }
    }

    /**
     * Tampilkan Halaman Publik Pemberitahuan Surat Izin Siswa (untuk Wali Kelas / Publik)
     */
    public function showSuratIzin($id)
    {
        $surat = SiswaSuratIzin::with(['siswa.kelas.waliKelas', 'kelas.waliKelas', 'petugasPiket'])->findOrFail($id);
        return view('approval.surat_izin_pemberitahuan', compact('surat'));
    }

    /**
     * Tampilkan Halaman Publik Pemberitahuan Siswa Terlambat (untuk Guru Mengajar / Publik)
     */
    public function showSiswaTelat($id)
    {
        $telat = SiswaTelat::with(['siswa.kelas', 'kelas', 'guruMengajar.mapel', 'guruPiket'])->findOrFail($id);
        return view('approval.siswa_telat_pemberitahuan', compact('telat'));
    }
}
