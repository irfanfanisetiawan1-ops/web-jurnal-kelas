<?php

namespace App\Services;

use App\Models\GuruIzin;
use App\Models\SiswaDispen;
use App\Models\SiswaSuratIzin;
use App\Models\SiswaTelat;
use App\Models\Setting;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WhatsAppNotificationService
{
    /**
     * Format nomor HP ke standar internasional Indonesia (62xxx)
     */
    public static function formatPhoneNumber(?string $number): ?string
    {
        if (empty($number)) {
            return null;
        }

        $clean = preg_replace('/[^0-9]/', '', $number);
        if (empty($clean)) {
            return null;
        }

        if (str_starts_with($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        } elseif (str_starts_with($clean, '8')) {
            $clean = '62' . $clean;
        }

        return $clean;
    }

    /**
     * Kirim pesan teks via WhatsApp Gateway API (Fonnte, Wablas, atau Generic Webhook)
     *
     * @param string $phone Nomor tujuan (format 628xxx)
     * @param string $message Isi pesan
     * @return array Status pengiriman ['success' => bool, 'message' => string, 'response' => mixed]
     */
    public function sendMessage(string $phone, string $message): array
    {
        $targetPhone = self::formatPhoneNumber($phone);
        if (empty($targetPhone)) {
            Log::warning("[WhatsApp Chatbot] Nomor tujuan tidak valid atau kosong: '{$phone}'");
            return [
                'success' => false,
                'message' => "Nomor WhatsApp tidak valid: '{$phone}'",
                'code'    => 400,
            ];
        }

        $provider = Setting::getByKey('wa_gateway_provider') ?: env('WA_GATEWAY_PROVIDER', 'fonnte');
        $token    = trim((string)(Setting::getByKey('wa_gateway_token') ?: env('WA_GATEWAY_TOKEN', env('FONNTE_TOKEN', ''))));
        $apiUrl   = Setting::getByKey('wa_gateway_url') ?: env('WA_GATEWAY_URL', '');

        // Fallback jika URL gateway belum ditentukan sesuai provider
        if (empty($apiUrl)) {
            if ($provider === 'wablas') {
                $apiUrl = 'https://phone.wablas.com/api/send-message';
            } else {
                $apiUrl = 'https://api.fonnte.com/send';
            }
        }

        // Jika token belum diset (misal di lingkungan dev lokal), catat ke log dan kembalikan fallback graceful
        if (empty($token)) {
            Log::info("[WhatsApp Chatbot Fallback] Token API WhatsApp belum dikonfigurasi. Pesan dicatat ke internal log.\nTarget: {$targetPhone}\nPesan:\n{$message}");
            return [
                'success' => false,
                'message' => 'Token WhatsApp Gateway belum dikonfigurasi pada sistem. Pesan dicatat di log internal.',
                'code'    => 401,
            ];
        }

        try {
            if ($provider === 'wablas') {
                $response = Http::withHeaders([
                    'Authorization' => $token,
                ])->timeout(8)->asForm()->post($apiUrl, [
                    'phone'   => $targetPhone,
                    'message' => $message,
                ]);
            } else {
                // Default: Fonnte API
                $response = Http::withHeaders([
                    'Authorization' => $token,
                ])->timeout(8)->asForm()->post($apiUrl, [
                    'target'      => $targetPhone,
                    'message'     => $message,
                    'countryCode' => '62',
                ]);
            }

            if ($response->successful()) {
                $json = $response->json();
                if (is_array($json) && isset($json['status']) && $json['status'] === false) {
                    $reason = $json['reason'] ?? 'WhatsApp Gateway gagal memproses pesan';
                    Log::error("[WhatsApp Chatbot Failed] Gateway menolak pesan ke {$targetPhone}. Reason: {$reason}. Full: " . $response->body());
                    return [
                        'success'  => false,
                        'message'  => "WhatsApp Gateway Error: {$reason}",
                        'response' => $json,
                        'code'     => 422,
                    ];
                }

                Log::info("[WhatsApp Chatbot Success] Notifikasi berhasil dikirim ke {$targetPhone} via {$provider}. Response: " . $response->body());
                return [
                    'success'  => true,
                    'message'  => 'Pesan WhatsApp berhasil terkirim.',
                    'response' => $json ?? $response->body(),
                    'code'     => $response->status(),
                ];
            } else {
                Log::error("[WhatsApp Chatbot Error] Gagal kirim ke {$targetPhone}. Status: " . $response->status() . " Body: " . $response->body());
                return [
                    'success'  => false,
                    'message'  => 'WhatsApp Gateway merespons dengan status error: ' . $response->status(),
                    'response' => $response->body(),
                    'code'     => $response->status(),
                ];
            }
        } catch (\Throwable $e) {
            Log::error("[WhatsApp Chatbot Exception] Kendala koneksi/timeout saat mengirim WA ke {$targetPhone}: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Kendala koneksi atau timeout ke WhatsApp Gateway: ' . $e->getMessage(),
                'code'    => 500,
            ];
        }
    }

    /**
     * Mengambil data pejabat sekolah aktif beserta nomor HP dinamis dari DB
     */
    public function getPejabatSekolah(): array
    {
        // 1. Waka Kurikulum (role: waka_kurikulum atau waka)
        $wakaKurikulum = User::whereIn('role', ['waka_kurikulum', 'waka'])
            ->where(function ($q) {
                $q->whereNull('status_verifikasi')->orWhere('status_verifikasi', 'verified');
            })
            ->first();

        // 2. Waka SDM (role: waka_sdm)
        $wakaSdm = User::where('role', 'waka_sdm')
            ->where(function ($q) {
                $q->whereNull('status_verifikasi')->orWhere('status_verifikasi', 'verified');
            })
            ->first();

        // 3. Kepala Sekolah (role: kepala_sekolah)
        $kepsek = User::where('role', 'kepala_sekolah')
            ->where(function ($q) {
                $q->whereNull('status_verifikasi')->orWhere('status_verifikasi', 'verified');
            })
            ->first();

        return [
            'waka_kurikulum' => [
                'jabatan' => 'Waka Kurikulum',
                'user'    => $wakaKurikulum,
                'nama'    => $wakaKurikulum->name ?? 'Waka Kurikulum',
                'no_hp'   => $this->resolvePhoneNumber($wakaKurikulum),
            ],
            'waka_sdm' => [
                'jabatan' => 'Waka SDM',
                'user'    => $wakaSdm,
                'nama'    => $wakaSdm->name ?? 'Waka SDM',
                'no_hp'   => $this->resolvePhoneNumber($wakaSdm),
            ],
            'kepala_sekolah' => [
                'jabatan' => 'Kepala Sekolah',
                'user'    => $kepsek,
                'nama'    => $kepsek->name ?? 'Kepala Sekolah',
                'no_hp'   => $this->resolvePhoneNumber($kepsek),
            ],
        ];
    }

    /**
     * Resolusi nomor HP dari user atau relasi tabel guru jika di users kosong
     */
    public function resolvePhoneNumber(?User $user): ?string
    {
        if (!$user) {
            return null;
        }

        if (!empty($user->no_hp)) {
            return $user->no_hp;
        }

        if (!empty($user->id_guru)) {
            $guru = Guru::find($user->id_guru);
            if ($guru && !empty($guru->no_hp)) {
                return $guru->no_hp;
            }
        }

        if (!empty($user->nip)) {
            $guru = Guru::where('nip', $user->nip)->first();
            if ($guru && !empty($guru->no_hp)) {
                return $guru->no_hp;
            }
        }

        return null;
    }

    /**
     * Helper mendapatkan Base URL persetujuan (mendukung domain publik / tunneling / IP)
     */
    public static function getApprovalBaseUrl(): string
    {
        $customUrl = Setting::getByKey('app_public_url') ?: env('APP_PUBLIC_URL');
        if (!empty($customUrl)) {
            return rtrim($customUrl, '/');
        }

        $envAppUrl = env('APP_URL');
        if (!empty($envAppUrl) && !str_contains($envAppUrl, 'localhost') && !str_contains($envAppUrl, '127.0.0.1')) {
            return rtrim($envAppUrl, '/');
        }

        try {
            if (app()->runningInConsole() === false && request()) {
                $root = request()->root();
                if (!empty($root) && !str_contains($root, 'localhost') && !str_contains($root, '127.0.0.1')) {
                    return rtrim($root, '/');
                }
            }
        } catch (\Throwable $e) {}

        return 'http://web-jurnal-kelas.test';
    }

    public static function makeApprovalGuruIzinUrl(string $token): string
    {
        return self::getApprovalBaseUrl() . "/approval/guru-izin/{$token}";
    }

    public static function makeApprovalDispenUrl(string $token): string
    {
        return self::getApprovalBaseUrl() . "/approval/dispen/{$token}";
    }

    public static function makeSuratIzinNotificationUrl(int|string $id): string
    {
        return self::getApprovalBaseUrl() . "/pemberitahuan/surat-izin/{$id}";
    }

    public static function makeSiswaTelatNotificationUrl(int|string $id): string
    {
        return self::getApprovalBaseUrl() . "/pemberitahuan/siswa-telat/{$id}";
    }

    /**
     * Susun template pesan resmi Permintaan Izin Guru sesuai format spesifikasi
     */
    public function buildPesanIzinGuru(GuruIzin $izin, string $jabatanPenerima, string $approvalUrl): string
    {
        $namaGuru = $izin->guru->nama_guru ?? 'Guru Mengajar';
        $nipGuru  = !empty($izin->guru->nip) ? $izin->guru->nip : '-';

        $kategori = ($izin->kategori_izin === 'cuti' || str_contains(strtolower($izin->durasi ?? ''), 'cuti'))
            ? 'Cuti (>3 Hari)'
            : 'Izin Biasa';

        $tglMulaiFormatted   = Carbon::parse($izin->tanggal_mulai)->format('d/m/Y');
        $tglSelesaiFormatted = !empty($izin->tanggal_selesai)
            ? Carbon::parse($izin->tanggal_selesai)->format('d/m/Y')
            : $tglMulaiFormatted;

        $rentangTanggal = ($tglMulaiFormatted === $tglSelesaiFormatted)
            ? $tglMulaiFormatted
            : "{$tglMulaiFormatted} s/d {$tglSelesaiFormatted}";

        $alasan = $izin->alasan ?? '-';

        $tugas = $izin->tugas_dititipkan ?: ($izin->materi_dititipkan ?: '-');

        $approvalUrl = trim($approvalUrl);

        return "*[EDU JOURNAL - NOTIFIKASI IZIN GURU]*\n\n"
            . "Yth. Bapak/Ibu *{$jabatanPenerima}*,\n\n"
            . "Terdapat pengajuan izin ketidakhadiran baru guru yang memerlukan persetujuan Anda.\n\n"
            . "Berikut adalah detail datanya:\n"
            . "• Nama Guru : {$namaGuru}\n"
            . "• NIP       : {$nipGuru}\n"
            . "• Kategori  : {$kategori}\n"
            . "• Tanggal   : {$rentangTanggal}\n"
            . "• Alasan    : {$alasan}\n"
            . "• Tugas     : {$tugas}\n\n"
            . "Silakan verifikasi dan berikan persetujuan resmi melalui tautan di bawah ini:\n\n"
            . "{$approvalUrl}\n\n"
            . "Terima kasih.\n"
            . "-- Sistem Otomatisasi EDU Journal --";
    }

    /**
     * Susun template pesan resmi Dispensasi Siswa sesuai format spesifikasi
     */
    public function buildPesanDispensasiSiswa(SiswaDispen $dispen, string $namaWakaTujuan, string $approvalUrl): string
    {
        $kodeDispen = $dispen->kode_dispen;
        $namaSiswa  = $dispen->siswa->nama_siswa ?? 'Siswa';
        $kelasSiswa = $dispen->siswa->kelas->nama_kelas ?? ($dispen->kelas->nama_kelas ?? '-');

        $tglFormatted = Carbon::parse($dispen->tanggal)->format('d/m/Y');
        $jamKeluar    = $dispen->jam_keluar ?? '-';
        $jamKembali   = $dispen->jam_kembali ?? '-';
        $alasan       = $dispen->alasan ?? '-';
        $lokasi       = $dispen->tempat ?: '-';

        $approvalUrl = trim($approvalUrl);

        return "*[EDU JOURNAL - NOTIFIKASI DISPENSASI SISWA]*\n\n"
            . "Yth. Bapak/Ibu *{$namaWakaTujuan}*,\n\n"
            . "Terdapat permohonan izin dispensasi siswa baru yang memerlukan persetujuan Anda.\n\n"
            . "Berikut adalah detail datanya:\n"
            . "• Kode Dispen : {$kodeDispen}\n"
            . "• Nama Siswa  : {$namaSiswa}\n"
            . "• Kelas       : {$kelasSiswa}\n"
            . "• Tanggal     : {$tglFormatted}\n"
            . "• Jam Keluar  : {$jamKeluar} s/d {$jamKembali}\n"
            . "• Alasan      : {$alasan}\n"
            . "• Lokasi      : {$lokasi}\n\n"
            . "Silakan verifikasi dan berikan persetujuan resmi melalui tautan di bawah ini:\n\n"
            . "{$approvalUrl}\n\n"
            . "Terima kasih.\n"
            . "-- Sistem Otomatisasi EDU Journal --";
    }

    /**
     * ALUR CHATBOT MODUL A: Form "Permintaan Izin Guru"
     * Mengirim notifikasi WhatsApp otomatis ke 3 pihak sekaligus atau pejabat tertentu:
     * Waka Kurikulum, Waka SDM, dan Kepala Sekolah.
     */
    public function sendNotifikasiIzinGuru(GuruIzin $izin, ?string $approvalUrl = null, ?string $targetKey = null): array
    {
        $izin->loadMissing('guru');

        if (empty($approvalUrl)) {
            $token = $izin->token_approval;
            $approvalUrl = self::makeApprovalGuruIzinUrl($token);
        }

        $pejabatList = $this->getPejabatSekolah();
        $results = [];

        if (!empty($targetKey) && $targetKey !== 'all' && isset($pejabatList[$targetKey])) {
            $pejabatList = [$targetKey => $pejabatList[$targetKey]];
        }

        foreach ($pejabatList as $key => $pejabat) {
            $jabatan = $pejabat['jabatan'];
            $noHp    = $pejabat['no_hp'];
            $pesan   = $this->buildPesanIzinGuru($izin, $jabatan, $approvalUrl);

            if (!empty($noHp)) {
                $res = $this->sendMessage($noHp, $pesan);
                $results[$key] = [
                    'jabatan' => $jabatan,
                    'nama'    => $pejabat['nama'],
                    'no_hp'   => $noHp,
                    'status'  => ($res['success'] ?? false) ? 'sent' : 'failed',
                    'detail'  => $res,
                ];
            } else {
                Log::warning("[WhatsApp Chatbot] Pejabat {$jabatan} ({$pejabat['nama']}) belum memiliki nomor HP terdaftar.");
                $results[$key] = [
                    'jabatan' => $jabatan,
                    'nama'    => $pejabat['nama'],
                    'no_hp'   => null,
                    'status'  => 'no_phone',
                    'detail'  => ['message' => 'Nomor HP tidak terdaftar di database.'],
                ];
            }
        }

        return $results;
    }

    /**
     * ALUR CHATBOT MODUL B: Form "Dispensasi Siswa"
     * Mengirim notifikasi WhatsApp otomatis ke 1 orang (Waka Kesiswaan Tujuan).
     */
    public function sendNotifikasiDispensasiSiswa(SiswaDispen $dispen, ?string $approvalUrl = null): array
    {
        $dispen->loadMissing(['siswa.kelas', 'kelas', 'wakaUser']);

        if (empty($approvalUrl)) {
            $token = $dispen->token_wali_kelas;
            $approvalUrl = self::makeApprovalDispenUrl($token);
        }

        // Cari Waka Kesiswaan Tujuan
        $wakaUser = $dispen->wakaUser;
        if (!$wakaUser && !empty($dispen->id_user_waka)) {
            $wakaUser = User::find($dispen->id_user_waka);
        }
        if (!$wakaUser) {
            // Fallback ke pejabat Waka Kesiswaan aktif jika data historis belum terisi
            $wakaUser = User::where('role', 'waka_kesiswaan')
                ->where(function ($q) {
                    $q->whereNull('status_verifikasi')->orWhere('status_verifikasi', 'verified');
                })->first();
        }

        $namaWaka = $wakaUser->name ?? ($dispen->nama_waka ?: 'Waka Kesiswaan');
        $noHp     = ($wakaUser ? $this->resolvePhoneNumber($wakaUser) : null) ?: $dispen->no_hp_waka;

        $pesan = $this->buildPesanDispensasiSiswa($dispen, $namaWaka, $approvalUrl);

        if (!empty($noHp)) {
            $res = $this->sendMessage($noHp, $pesan);
            return [
                'jabatan' => 'Waka Kesiswaan',
                'nama'    => $namaWaka,
                'no_hp'   => $noHp,
                'status'  => ($res['success'] ?? false) ? 'sent' : 'failed',
                'detail'  => $res,
            ];
        } else {
            Log::warning("[WhatsApp Chatbot] Waka Kesiswaan Tujuan ({$namaWaka}) belum memiliki nomor HP.");
            return [
                'jabatan' => 'Waka Kesiswaan',
                'nama'    => $namaWaka,
                'no_hp'   => null,
                'status'  => 'no_phone',
                'detail'  => ['message' => 'Nomor HP Waka Kesiswaan tidak ditemukan di database.'],
            ];
        }
    }

    /**
     * Susun template pesan resmi Dispensasi Siswa untuk Petugas Satpam
     */
    public function buildPesanDispensasiKeSatpam(SiswaDispen $dispen, ?string $approverName = null, ?string $verificationUrl = null): string
    {
        $kodeDispen = $dispen->kode_dispen;
        $namaSiswa  = $dispen->siswa->nama_siswa ?? 'Siswa';
        $kelasSiswa = $dispen->siswa->kelas->nama_kelas ?? ($dispen->kelas->nama_kelas ?? '-');

        $tglFormatted = Carbon::parse($dispen->tanggal)->format('d/m/Y');
        $jamKeluar    = $dispen->jam_keluar ?? '-';
        $jamKembali   = $dispen->jam_kembali ?? '-';
        $alasan       = $dispen->alasan ?? '-';

        $approver = $approverName ?: ($dispen->nama_waka ?: 'Waka Kesiswaan');

        if (empty($verificationUrl)) {
            $verificationUrl = self::makeApprovalDispenUrl($dispen->token_wali_kelas);
        }

        $baseUrl = self::getApprovalBaseUrl();

        $lampiran = '';
        if (!empty($dispen->foto_siswa_live)) {
            $urlFoto = $baseUrl . '/' . ltrim($dispen->foto_siswa_live, '/');
            $lampiran .= "• Foto Siswa (Live Kamera):\n{$urlFoto}\n\n";
        }
        if (!empty($dispen->foto_kartu_identitas)) {
            $urlKartu = $baseUrl . '/' . ltrim($dispen->foto_kartu_identitas, '/');
            $lampiran .= "• Foto Kartu Pelajar:\n{$urlKartu}\n\n";
        }
        if (!empty($dispen->foto_surat_dispen)) {
            $urlSurat = $baseUrl . '/' . ltrim($dispen->foto_surat_dispen, '/');
            $lampiran .= "• Foto Surat Dispen:\n{$urlSurat}\n\n";
        }

        return "[EDU JOURNAL - NOTIFIKASI DISPENSASI SISWA UNTUK SATPAM]\n\n"
            . "Yth. Petugas Satpam Gerbang Sekolah,\n"
            . "Memberitahukan bahwa permohonan dispensasi siswa berikut telah DISETUJUI oleh Waka Kesiswaan ({$approver}):\n\n"
            . "• Kode Dispen : {$kodeDispen}\n"
            . "• Nama Siswa  : {$namaSiswa}\n"
            . "• Kelas       : {$kelasSiswa}\n"
            . "• Tanggal     : {$tglFormatted}\n"
            . "• Jam Izin    : {$jamKeluar} s/d {$jamKembali}\n"
            . "• Alasan      : {$alasan}\n\n"
            . ($lampiran ? "Dokumen & Foto Terlampir:\n{$lampiran}" : "")
            . "Silakan verifikasi detail dan status resmi dispensasi melalui tautan di bawah ini:\n\n"
            . "{$verificationUrl}\n\n"
            . "STATUS: TERVERIFIKASI & DISETUJUI WAKA KESISWAAN.\n"
            . "Petugas Satpam dapat mencocokkan fisik & wajah Siswa serta Kartu Pelajar dengan foto live terlampir, lalu membiarkan siswa keluar sekolah.\n\n"
            . "Terima kasih.\n"
            . "-- Sistem Otomatisasi EDU Journal --";
    }

    /**
     * ALUR CHATBOT: Notifikasi Dispensasi Siswa ke Petugas Satpam
     * Mengirim notifikasi WhatsApp otomatis ke Petugas Satpam setelah Waka Kesiswaan menyetujui permohonan.
     */
    public function sendNotifikasiDispensasiKeSatpam(SiswaDispen $dispen, ?string $approverName = null, ?string $verificationUrl = null): array
    {
        $dispen->loadMissing(['siswa.kelas', 'kelas', 'wakaUser']);

        if (empty($verificationUrl)) {
            $token = $dispen->token_wali_kelas;
            $verificationUrl = self::makeApprovalDispenUrl($token);
        }

        // Cari petugas Satpam terdaftar
        $satpamUsers = User::where('role', 'satpam')
            ->where(function ($q) {
                $q->whereNull('status_verifikasi')->orWhere('status_verifikasi', 'verified');
            })
            ->get();

        if ($satpamUsers->isEmpty()) {
            $satpamUsers = User::where('role', 'satpam')->get();
        }

        $pesan = $this->buildPesanDispensasiKeSatpam($dispen, $approverName, $verificationUrl);
        $results = [];
        $overallSuccess = false;

        foreach ($satpamUsers as $satpam) {
            $noHp = $this->resolvePhoneNumber($satpam);
            if (!empty($noHp)) {
                $res = $this->sendMessage($noHp, $pesan);
                $isSuccess = $res['success'] ?? false;
                if ($isSuccess) {
                    $overallSuccess = true;
                }
                $results[] = [
                    'jabatan' => 'Petugas Satpam',
                    'nama'    => $satpam->name,
                    'no_hp'   => $noHp,
                    'status'  => $isSuccess ? 'sent' : 'failed',
                    'detail'  => $res,
                ];
            } else {
                Log::warning("[WhatsApp Chatbot] Petugas Satpam ({$satpam->name}) belum memiliki nomor HP.");
                $results[] = [
                    'jabatan' => 'Petugas Satpam',
                    'nama'    => $satpam->name,
                    'no_hp'   => null,
                    'status'  => 'no_phone',
                    'detail'  => ['message' => 'Nomor HP Petugas Satpam tidak ditemukan di database.'],
                ];
            }
        }

        $primary = $results[0] ?? [
            'jabatan' => 'Petugas Satpam',
            'nama'    => 'Petugas Satpam',
            'no_hp'   => null,
            'status'  => 'no_phone',
            'detail'  => ['message' => 'Data Petugas Satpam tidak ditemukan di database.'],
        ];

        return [
            'success' => $overallSuccess,
            'pesan'   => $pesan,
            'primary' => $primary,
            'all'     => $results,
        ];
    }

    /**
     * Susun template pesan resmi Surat Izin Siswa untuk Wali Kelas
     */
    public function buildPesanSuratIzinWaliKelas(SiswaSuratIzin $surat, ?string $notificationUrl = null): string
    {
        $surat->loadMissing(['siswa.kelas.waliKelas', 'kelas.waliKelas', 'petugasPiket']);

        $namaSiswa = $surat->siswa->nama_siswa ?? 'Siswa';
        $nisSiswa  = $surat->siswa->nis ?? '-';
        $namaKelas = $surat->kelas->nama_kelas ?? ($surat->siswa->kelas->nama_kelas ?? '-');

        $waliKelas = $surat->kelas->waliKelas ?? ($surat->siswa->kelas->waliKelas ?? null);
        $waliNama  = $waliKelas->nama_guru ?? 'Wali Kelas';

        $tglMulaiFormatted   = Carbon::parse($surat->tanggal)->format('d/m/Y');
        $tglSelesaiFormatted = !empty($surat->tanggal_selesai)
            ? Carbon::parse($surat->tanggal_selesai)->format('d/m/Y')
            : $tglMulaiFormatted;

        $rentangTanggal = ($tglMulaiFormatted === $tglSelesaiFormatted)
            ? $tglMulaiFormatted
            : "{$tglMulaiFormatted} s/d {$tglSelesaiFormatted}";

        $durasiHari = $surat->durasi_hari ?: (max(1, Carbon::parse($surat->tanggal)->diffInDays(Carbon::parse($surat->tanggal_selesai ?? $surat->tanggal)) + 1));
        $durasiText = "{$durasiHari} Hari";

        $kategori   = $surat->kategori ?? 'Izin';
        $keterangan = $surat->keterangan ?: '-';

        $petugasNama = $surat->petugasPiket->name ?? 'Petugas Guru Piket';

        if (empty($notificationUrl)) {
            $notificationUrl = self::makeSuratIzinNotificationUrl($surat->id_surat_izin);
        }

        return "[EDU JOURNAL - NOTIFIKASI SURAT IZIN SISWA]\n\n"
            . "Assalamu'alaikum / Selamat Pagi Bapak/Ibu Wali Kelas {$waliNama} ({$namaKelas}),\n\n"
            . "Memberitahukan bahwa terdapat data surat izin / ketidakhadiran siswa dari kelas yang Bapak/Ibu ampu telah di-inputkan oleh Petugas Guru Piket:\n\n"
            . "• Nama Siswa         : {$namaSiswa}\n"
            . "• NIS                : {$nisSiswa}\n"
            . "• Kelas              : {$namaKelas}\n"
            . "• Kategori           : {$kategori}\n"
            . "• Tanggal Izin       : {$rentangTanggal} ({$durasiText})\n"
            . "• Keterangan / Alasan: {$keterangan}\n"
            . "• Status Presensi    : Terverifikasi (Auto-Sync Jurnal Mengajar)\n\n"
            . "Silakan lihat rincian pemberitahuan resmi dan dokumen bukti melalui tautan di bawah ini:\n\n"
            . "{$notificationUrl}\n\n"
            . "Data presensi di jurnal mengajar kelas telah otomatis disesuaikan secara real-time. Mohon Bapak/Ibu Wali Kelas dapat memantau kehadiran siswa tersebut.\n\n"
            . "Diinput oleh Petugas Piket: {$petugasNama}\n"
            . "Terima kasih.\n"
            . "-- Sistem Otomatisasi EDU Journal --";
    }

    /**
     * ALUR CHATBOT: Notifikasi Surat Izin Siswa ke Wali Kelas
     * Mengirim notifikasi WhatsApp otomatis ke Wali Kelas siswa bersangkutan.
     */
    public function sendNotifikasiSuratIzinKeWali(SiswaSuratIzin $surat, ?string $notificationUrl = null): array
    {
        $surat->loadMissing(['siswa.kelas.waliKelas', 'kelas.waliKelas', 'petugasPiket']);

        $waliKelas = $surat->kelas->waliKelas ?? ($surat->siswa->kelas->waliKelas ?? null);
        $namaWali  = $waliKelas->nama_guru ?? 'Wali Kelas';
        $namaKelas = $surat->kelas->nama_kelas ?? ($surat->siswa->kelas->nama_kelas ?? '-');

        // Cari nomor HP Wali Kelas dari user atau relasi guru
        $noHp = null;
        if ($waliKelas) {
            $userWali = User::where('id_guru', $waliKelas->id_guru)
                ->orWhere('nip', $waliKelas->nip)
                ->first();
            $noHp = $this->resolvePhoneNumber($userWali) ?: $waliKelas->no_hp;
        }

        if (empty($notificationUrl)) {
            $notificationUrl = self::makeSuratIzinNotificationUrl($surat->id_surat_izin);
        }

        $pesan = $this->buildPesanSuratIzinWaliKelas($surat, $notificationUrl);

        if (!empty($noHp)) {
            $res = $this->sendMessage($noHp, $pesan);
            return [
                'success'   => $res['success'] ?? false,
                'wali_nama' => $namaWali,
                'wali_hp'   => $noHp,
                'kelas'     => $namaKelas,
                'pesan'     => $pesan,
                'detail'    => $res,
            ];
        } else {
            Log::warning("[WhatsApp Chatbot] Wali Kelas {$namaWali} ({$namaKelas}) belum memiliki nomor HP.");
            return [
                'success'   => false,
                'wali_nama' => $namaWali,
                'wali_hp'   => null,
                'kelas'     => $namaKelas,
                'pesan'     => $pesan,
                'detail'    => ['message' => 'Nomor WhatsApp Wali Kelas belum terdaftar di sistem.'],
            ];
        }
    }

    /**
     * Susun template pesan resmi Keterlambatan Siswa untuk Guru Mengajar Target
     */
    public function buildPesanSiswaTelatGuruMengajar(SiswaTelat $telat, ?string $notificationUrl = null): string
    {
        $telat->loadMissing(['siswa.kelas', 'kelas', 'guruMengajar.mapel', 'guruPiket']);

        $guru      = $telat->guruMengajar;
        $namaGuru  = $guru->nama_guru ?? 'Guru Mengajar';
        $namaSiswa = $telat->siswa->nama_siswa ?? 'Siswa';
        $nisNisn   = ($telat->siswa->nis ?? '-') . ' / ' . ($telat->siswa->nisn ?? '-');
        $namaKelas = $telat->kelas->nama_kelas ?? ($telat->siswa->kelas->nama_kelas ?? '-');
        $jk        = $telat->siswa ? $telat->siswa->jenis_kelamin_teks : '-';
        $jamTeks   = $telat->jam_terlambat . ' WIB';
        $tglFmt    = Carbon::parse($telat->tanggal)->translatedFormat('d/m/Y');
        $alasan    = $telat->alasan ?: '-';
        $hukuman   = $telat->tindakan_hukuman ?: 'Pengarahan & kedisiplinan Guru Piket';
        $petugas   = $telat->guruPiket->name ?? 'Petugas Guru Piket';

        if (empty($notificationUrl)) {
            $notificationUrl = self::makeSiswaTelatNotificationUrl($telat->id_siswa_telat);
        }

        return "*PEMBERITAHUAN SISWA TERLAMBAT (GURU PIKET)*\n"
            . "SMK NEGERI 1 SAMPANG\n\n"
            . "Assalamu'alaikum / Selamat Pagi Bapak/Ibu Guru *{$namaGuru}*,\n\n"
            . "Memberitahukan bahwa siswa dari kelas Bapak/Ibu terlambat hadir di sekolah:\n\n"
            . "• Nama Siswa       : {$namaSiswa}\n"
            . "• NIS / NISN       : {$nisNisn}\n"
            . "• Kelas            : {$namaKelas}\n"
            . "• Jenis Kelamin    : {$jk}\n"
            . "• Jam Datang       : {$jamTeks}\n"
            . "• Tanggal          : {$tglFmt}\n"
            . "• Alasan           : {$alasan}\n"
            . "• Tindakan/Hukuman : {$hukuman}\n\n"
            . "Siswa saat ini telah melapor ke Guru Piket dan diarahkan memasuki kelas. Notifikasi web sistem telah dikirimkan ke Halaman Pengumuman Guru Mengajar.\n\n"
            . "Silakan lihat rincian pemberitahuan resmi keterlambatan siswa melalui tautan berikut:\n\n"
            . "{$notificationUrl}\n\n"
            . "Mohon Bapak/Ibu Guru Mengajar dapat menyesuaikan data presensi siswa di jurnal kelas.\n\n"
            . "Terima kasih.\n"
            . "• Petugas Piket: {$petugas}\n"
            . "-- Sistem Jurnal & Presensi SMKN 1 Sampang --";
    }

    /**
     * ALUR CHATBOT: Notifikasi Siswa Telat ke Guru Mengajar Target
     * Mengirim notifikasi WhatsApp otomatis ke Guru Mengajar di kelas saat ini.
     */
    public function sendNotifikasiSiswaTelatKeGuru(SiswaTelat $telat, ?string $notificationUrl = null): array
    {
        $telat->loadMissing(['siswa.kelas', 'kelas', 'guruMengajar.mapel', 'guruPiket']);

        $guru      = $telat->guruMengajar;
        $namaGuru  = $guru->nama_guru ?? 'Guru Mengajar';
        $namaKelas = $telat->kelas->nama_kelas ?? ($telat->siswa->kelas->nama_kelas ?? '-');

        // Cari nomor HP Guru dari user atau relasi guru
        $noHp = null;
        if ($guru) {
            $userGuru = User::where('id_guru', $guru->id_guru)
                ->orWhere('nip', $guru->nip)
                ->first();
            $noHp = $this->resolvePhoneNumber($userGuru) ?: $guru->no_hp;
        }

        if (empty($notificationUrl)) {
            $notificationUrl = self::makeSiswaTelatNotificationUrl($telat->id_siswa_telat);
        }

        $pesan = $this->buildPesanSiswaTelatGuruMengajar($telat, $notificationUrl);

        if (!empty($noHp)) {
            $res = $this->sendMessage($noHp, $pesan);
            return [
                'success'   => $res['success'] ?? false,
                'guru_nama' => $namaGuru,
                'guru_hp'   => $noHp,
                'kelas'     => $namaKelas,
                'pesan'     => $pesan,
                'detail'    => $res,
            ];
        } else {
            Log::warning("[WhatsApp Chatbot] Guru Mengajar {$namaGuru} belum memiliki nomor HP terdaftar.");
            return [
                'success'   => false,
                'guru_nama' => $namaGuru,
                'guru_hp'   => null,
                'kelas'     => $namaKelas,
                'pesan'     => $pesan,
                'detail'    => ['message' => 'Nomor WhatsApp Guru Mengajar belum terdaftar di sistem.'],
            ];
        }
    }

    /**
     * Susun template pesan resmi Permintaan Izin Guru ke Guru Piket via ChatBot WhatsApp
     */
    public function buildPesanPermintaanIzinKePiket(GuruIzin $izin, ?string $namaPiket = null, ?string $piketUrl = null): string
    {
        $namaGuru = $izin->guru->nama_guru ?? 'Guru Mengajar';
        $nipGuru  = !empty($izin->guru->nip) ? $izin->guru->nip : '-';

        $kategori = ($izin->kategori_izin === 'cuti' || str_contains(strtolower($izin->durasi ?? ''), 'cuti'))
            ? 'Cuti / Izin Khusus (>3 Hari)'
            : 'Izin Biasa (1 s/d 3 Hari)';

        $tglMulaiFormatted   = Carbon::parse($izin->tanggal_mulai)->format('d/m/Y');
        $tglSelesaiFormatted = !empty($izin->tanggal_selesai)
            ? Carbon::parse($izin->tanggal_selesai)->format('d/m/Y')
            : $tglMulaiFormatted;

        $rentangTanggal = ($tglMulaiFormatted === $tglSelesaiFormatted)
            ? $tglMulaiFormatted
            : "{$tglMulaiFormatted} s/d {$tglSelesaiFormatted}";

        $alasan = $izin->alasan ?? '-';
        $tugas  = $izin->tugas_dititipkan ?: ($izin->materi_dititipkan ?: '-');

        if (empty($piketUrl)) {
            $piketUrl = url('/guru-piket/permintaan-izin');
        }

        $sapaan = $namaPiket ? "Yth. Bapak/Ibu *{$namaPiket}* (Guru Piket)," : "Yth. Bapak/Ibu *Petugas Guru Piket*,";

        return "*[EDU JOURNAL - PEMBERITAHUAN PERMINTAAN IZIN GURU]*\n\n"
            . "{$sapaan}\n\n"
            . "Pemberitahuan bahwa terdapat permohonan izin tidak hadir mengajar baru yang diajukan oleh Guru Mengajar / Wali Kelas dan memerlukan verifikasi serta pengisian data oleh Guru Piket ke sistem.\n\n"
            . "Berikut adalah detail permohonan izin:\n"
            . "• Nama Pengaju : *{$namaGuru}*\n"
            . "• NIP          : {$nipGuru}\n"
            . "• Kategori     : {$kategori}\n"
            . "• Rentang Waktu: {$rentangTanggal}\n"
            . "• Alasan       : {$alasan}\n"
            . "• Titipan Tugas: {$tugas}\n\n"
            . "Mohon Bapak/Ibu Guru Piket dapat mengecek, memvalidasi, dan mengisikan data izin tersebut ke sistem Web EDU JOURNAL melalui tautan berikut:\n\n"
            . "{$piketUrl}\n\n"
            . "Terima kasih.\n"
            . "-- ChatBot WhatsApp EDU Journal --";
    }

    /**
     * ALUR CHATBOT: Mengirim notifikasi Permintaan Izin Guru ke WhatsApp Guru Piket
     *
     * @param GuruIzin $izin
     * @param string|null $targetPhone Nomor WA penerima khusus jika dipilih guru pengaju
     * @param string|null $piketUrl Link akses halaman Guru Piket
     * @return array
     */
    public function sendNotifikasiPermintaanIzinKePiket(GuruIzin $izin, ?string $targetPhone = null, ?string $piketUrl = null): array
    {
        $izin->loadMissing(['guru', 'guruPiket']);

        if (empty($piketUrl)) {
            $piketUrl = url('/guru-piket/permintaan-izin');
        }

        $targets = [];

        // 1. Jika nomor tujuan spesifik diinput/dipilih dari form
        if (!empty($targetPhone)) {
            $cleanTarget = self::formatPhoneNumber($targetPhone);
            if ($cleanTarget) {
                // Cari nama penerima jika ada di DB
                $userPiket = User::where(function($q) use ($targetPhone, $cleanTarget) {
                    $q->where('no_hp', $targetPhone)
                      ->orWhere('no_hp', 'LIKE', '%' . substr($cleanTarget, 2));
                })->first();

                $guruTarget = null;
                if (!$userPiket) {
                    $guruTarget = Guru::where(function($q) use ($targetPhone, $cleanTarget) {
                        $q->where('no_hp', $targetPhone)
                          ->orWhere('no_hp', 'LIKE', '%' . substr($cleanTarget, 2));
                    })->first();
                }

                $namaPenerima = $userPiket->name ?? ($guruTarget->nama_guru ?? 'Petugas Guru Piket');

                $targets[] = [
                    'nama'  => $namaPenerima,
                    'phone' => $cleanTarget,
                    'role'  => 'Guru Piket',
                ];
            }
        }

        // 2. Jika tidak ada target spesifik atau target belum terisi, cari Guru Piket hari ini / akun piket
        if (empty($targets)) {
            // A. Cek jadwal_guru_piket untuk tanggal izin atau hari ini
            $tglCari = $izin->tanggal_mulai ?: Carbon::now('Asia/Jakarta')->toDateString();
            try {
                $piketHariIni = \DB::table('jadwal_guru_piket')
                    ->join('guru', 'jadwal_guru_piket.id_guru', '=', 'guru.id_guru')
                    ->whereDate('jadwal_guru_piket.tanggal', $tglCari)
                    ->whereNotNull('guru.no_hp')
                    ->where('guru.no_hp', '!=', '')
                    ->select('guru.nama_guru', 'guru.no_hp', 'guru.nip')
                    ->get();

                foreach ($piketHariIni as $phi) {
                    $fPhone = self::formatPhoneNumber($phi->no_hp);
                    if ($fPhone && !in_array($fPhone, array_column($targets, 'phone'))) {
                        $targets[] = [
                            'nama'  => $phi->nama_guru,
                            'phone' => $fPhone,
                            'role'  => 'Guru Piket Hari Ini',
                        ];
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("[WhatsApp Chatbot] Query jadwal_guru_piket gagal: " . $e->getMessage());
            }

            // B. Cek User role piket
            $usersPiket = User::where('role', 'piket')
                ->whereNotNull('no_hp')
                ->where('no_hp', '!=', '')
                ->get();

            foreach ($usersPiket as $up) {
                $fPhone = self::formatPhoneNumber($up->no_hp);
                if ($fPhone && !in_array($fPhone, array_column($targets, 'phone'))) {
                    $targets[] = [
                        'nama'  => $up->name,
                        'phone' => $fPhone,
                        'role'  => 'Petugas Piket',
                    ];
                }
            }
        }

        if (empty($targets)) {
            Log::warning("[WhatsApp Chatbot] Tidak ditemukan nomor HP Guru Piket yang valid untuk izin ID: {$izin->id_guru_izin}");
            return [
                'success' => false,
                'status'  => 'failed',
                'message' => 'Tidak ditemukan nomor WhatsApp Guru Piket yang valid di sistem.',
                'results' => [],
            ];
        }

        $results = [];
        $hasSuccess = false;
        $recipientNames = [];
        $recipientPhones = [];

        foreach ($targets as $target) {
            $pesan = $this->buildPesanPermintaanIzinKePiket($izin, $target['nama'], $piketUrl);
            $sendRes = $this->sendMessage($target['phone'], $pesan);

            $isSent = ($sendRes['success'] ?? false) === true;
            if ($isSent) {
                $hasSuccess = true;
                $recipientNames[] = $target['nama'];
                $recipientPhones[] = $target['phone'];
            }

            $results[] = [
                'recipient' => $target['nama'],
                'phone'     => $target['phone'],
                'role'      => $target['role'],
                'status'    => $isSent ? 'sent' : 'failed',
                'detail'    => $sendRes,
            ];
        }

        return [
            'success'          => $hasSuccess,
            'status'           => $hasSuccess ? 'sent' : 'failed',
            'recipient_name'   => implode(', ', $recipientNames) ?: ($targets[0]['nama'] ?? 'Guru Piket'),
            'phone'            => implode(', ', $recipientPhones) ?: ($targets[0]['phone'] ?? '-'),
            'message'          => $hasSuccess
                ? 'Pesan pemberitahuan Permintaan Izin Guru berhasil dikirimkan oleh ChatBot WhatsApp ke Guru Piket: ' . implode(', ', $recipientNames)
                : 'Pesan pemberitahuan Permintaan Izin Guru via ChatBot WhatsApp ke Guru Piket (' . ($targets[0]['nama'] ?? 'Guru Piket') . '): ' . ($results[0]['detail']['message'] ?? 'Gateway belum merespons.'),
            'results'          => $results,
        ];
    }
}
