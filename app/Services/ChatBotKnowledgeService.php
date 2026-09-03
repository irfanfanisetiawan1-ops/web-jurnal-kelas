<?php

namespace App\Services;

use App\Models\User;
use App\Models\CsTicket;
use App\Models\Setting;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\JurnalMengajar;
use App\Models\SiswaDispen;
use Carbon\Carbon;

class ChatBotKnowledgeService
{
    /**
     * Dapatkan preset topik/pertanyaan cepat yang direkomendasikan berdasarkan role user (Tanpa Emoji & Tanpa Ikon / Bentuk).
     */
    public static function getQuickTopics(User $user): array
    {
        if ($user->isAdmin()) {
            return [
                ['label' => 'Status & Cek Tiket Saya', 'query' => 'cek status tiket cs saya'],
                ['label' => 'Kelola Data Master & Users', 'query' => 'bagaimana cara kelola data master dan verifikasi user'],
                ['label' => 'Reset Password Pengguna', 'query' => 'cara reset password pengguna atau guru'],
                ['label' => 'Set Wali Kelas & Piket', 'query' => 'cara mengatur wali kelas dan guru piket'],
                ['label' => 'Restore Data Terhapus', 'query' => 'cara mengembalikan data yang terhapus dari trash'],
                ['label' => 'Info Kontak CS Official', 'query' => 'info kontak hotline cs whatsapp dan email'],
            ];
        }

        if ($user->isWaliKelas()) {
            return [
                ['label' => 'Approval Surat Izin Siswa', 'query' => 'cara acc atau menyetujui surat izin sakit dispen siswa'],
                ['label' => 'Lihat Presensi Kelas Bimbingan', 'query' => 'cara melihat rekap presensi kelas bimbingan saya'],
                ['label' => 'Laporan Siswa dari Satpam', 'query' => 'bagaimana menerima dan menindaklanjuti laporan siswa dari satpam'],
                ['label' => 'Status Tiket Bantuan Saya', 'query' => 'cek status tiket cs saya'],
                ['label' => 'Surat Izin Tidak Muncul', 'query' => 'solusi surat izin siswa tidak muncul di menu approval'],
            ];
        }

        if ($user->isGuruPiket()) {
            return [
                ['label' => 'Isi Jurnal Piket Harian', 'query' => 'cara mengisi jurnal piket harian sekolah'],
                ['label' => 'Buat Dispensasi Siswa Keluar', 'query' => 'cara membuat izin dispensasi siswa keluar sekolah'],
                ['label' => 'Penugasan Guru Pengganti', 'query' => 'cara mengisi guru pengganti dan jurnal kelas pengganti'],
                ['label' => 'Rekap Kehadiran Hari Ini', 'query' => 'statistik presensi dan rekap hari ini'],
                ['label' => 'Status Tiket CS Saya', 'query' => 'cek status tiket cs saya'],
            ];
        }

        if ($user->isWaka()) {
            return [
                ['label' => 'Approval Level Waka', 'query' => 'cara menyetujui dispensasi siswa dan izin guru level waka'],
                ['label' => 'Monitoring Jurnal Mengajar', 'query' => 'cara memantau keterisian jurnal mengajar semua guru'],
                ['label' => 'Rekap Presensi Hari Ini', 'query' => 'statistik presensi dan rekap hari ini'],
                ['label' => 'Status Tiket CS Saya', 'query' => 'cek status tiket cs saya'],
            ];
        }

        if ($user->isKepalaSekolah()) {
            return [
                ['label' => 'Executive Dashboard Monitor', 'query' => 'cara membaca dashboard monitoring kepala sekolah'],
                ['label' => 'Pantau Kehadiran Guru', 'query' => 'cara melihat real time presensi mengajar guru hari ini'],
                ['label' => 'Laporan Presensi Sekolah', 'query' => 'cara mengunduh dan mengecek rekap presensi bulanan'],
                ['label' => 'Status Tiket CS Saya', 'query' => 'cek status tiket cs saya'],
            ];
        }

        if ($user->isOrangTua()) {
            return [
                ['label' => 'Pantau Kehadiran Anak', 'query' => 'cara melihat jurnal dan kehadiran harian anak saya'],
                ['label' => 'Pengajuan Surat Izin Anak', 'query' => 'cara mengajukan surat izin sakit atau acara keluarga untuk anak'],
                ['label' => 'Info Wali Kelas Anak', 'query' => 'siapa wali kelas bimbingan anak saya'],
                ['label' => 'Status Tiket CS Saya', 'query' => 'cek status tiket cs saya'],
                ['label' => 'Info CS & Hotline', 'query' => 'info kontak hotline cs whatsapp dan email'],
            ];
        }

        if ($user->isSatpam()) {
            return [
                ['label' => 'Scan Barcode Dispen Siswa', 'query' => 'cara scan atau validasi kode barcode dispensasi siswa'],
                ['label' => 'Lapor Kejadian Siswa ke WA', 'query' => 'cara melaporkan keterlambatan atau pelanggaran siswa ke wali kelas via whatsapp'],
                ['label' => 'Cek Status Tiket Saya', 'query' => 'cek status tiket cs saya'],
                ['label' => 'Barcode Terpakai / Kadaluarsa', 'query' => 'solusi barcode siswa sudah terpakai atau dispen belum di ACC'],
            ];
        }

        // Default Guru Mengajar
        return [
            ['label' => 'Cara Isi Jurnal Mengajar', 'query' => 'cara menginput dan mengisi jurnal mengajar harian'],
            ['label' => 'Presensi Kehadiran Siswa', 'query' => 'cara mengisi absensi siswa hadir sakit izin alpa'],
            ['label' => 'Cek Status Tiket Saya', 'query' => 'cek status tiket cs saya'],
            ['label' => 'Pengajuan Izin Tidak Hadir', 'query' => 'cara mengajukan surat izin atau sakit guru'],
            ['label' => 'Beralih ke Guru Piket', 'query' => 'cara beralih mode dari guru mengajar ke guru piket'],
            ['label' => 'Jurnal Gagal Disimpan / Bentrok', 'query' => 'solusi tidak bisa simpan jurnal karena jam mengajar sudah diisi'],
        ];
    }

    /**
     * Helper aman untuk mendapatkan URL Route.
     */
    private static function getRouteUrl(string $routeName, string $fallbackUrl = '#'): string
    {
        try {
            return route($routeName);
        } catch (\Throwable $e) {
            return $fallbackUrl;
        }
    }

    /**
     * Jawab pertanyaan pengguna berdasarkan query dan konteks role (Tanpa Emoji & Tanpa Ikon / Bentuk).
     */
    public static function answerQuery(string $rawQuery, User $user): array
    {
        $query = strtolower(trim($rawQuery));

        // ── 1. REAL-TIME DATABASE DYNAMIC LOOKUPS ──

        // A. Cek Status Tiket CS Pengguna Saat Ini
        if (str_contains($query, 'status tiket') || str_contains($query, 'tiket saya') || str_contains($query, 'cek tiket')) {
            $myTickets = CsTicket::where('user_id', $user->id)->latest()->take(5)->get();

            if ($myTickets->isEmpty()) {
                return [
                    'status' => 'success',
                    'topic' => 'Cek Status Tiket CS Saya',
                    'reply' => "<strong>Status Tiket Bantuan CS Anda:</strong><br>
                        Saat ini Anda belum memiliki tiket bantuan yang pernah dikirimkan.<br>
                        Jika ada masalah atau pertanyaan teknis yang tidak terselesaikan oleh Asisten Virtual, silakan isi <strong>Form Kirim Kendala CS</strong> di bawah ini.",
                    'action_button' => [
                        'label' => 'Buat Tiket CS Baru',
                        'url' => '#form-tiket-cs',
                        'trigger_form' => true,
                    ],
                    'quick_suggestions' => ['Info Kontak CS Official', 'Cara Isi Jurnal Mengajar'],
                ];
            }

            $listHtml = "<ol style='margin-left: 18px; margin-top: 6px;'>";
            foreach ($myTickets as $t) {
                $statusBadge = match ($t->status) {
                    'pending'  => '<span style="color:#d97706; font-weight:700;">Pending</span>',
                    'diproses' => '<span style="color:#0284c7; font-weight:700;">Diproses</span>',
                    'selesai'  => '<span style="color:#16a34a; font-weight:700;">Selesai</span>',
                    default    => ucfirst($t->status),
                };
                $responseInfo = $t->tanggapan_admin 
                    ? "<br><div style='background:#f0fdf4; border-left:3px solid #22c55e; padding:6px 10px; margin-top:4px; font-size:12px; color:#166534;'><strong>Balasan CS:</strong> " . e($t->tanggapan_admin) . "</div>"
                    : "<br><span style='font-size:11.5px; color:#94a3b8; font-style:italic;'>Belum ada balasan dari Tim CS</span>";

                $listHtml .= "<li style='margin-bottom:8px;'><strong>Kode: {$t->ticket_code}</strong> - " . e($t->subjek) . "<br>Kategori: {$t->kategori} | Status: {$statusBadge} {$responseInfo}</li>";
            }
            $listHtml .= "</ol>";

            return [
                'status' => 'success',
                'topic' => 'Riwayat Tiket Bantuan CS Saya',
                'reply' => "<strong>Data Tiket CS Terkini Milik Anda (Live System Data):</strong><br>{$listHtml}",
                'action_button' => [
                    'label' => 'Buat Tiket CS Baru',
                    'url' => '#form-tiket-cs',
                    'trigger_form' => true,
                ],
                'quick_suggestions' => ['Info Kontak CS Official', 'Reset Password Pengguna'],
            ];
        }

        // B. Info Kontak Hotline CS Live Settings
        if (str_contains($query, 'info kontak cs') || str_contains($query, 'hotline') || str_contains($query, 'nomor cs') || str_contains($query, 'email cs')) {
            $waNum = Setting::getByKey('cs_whatsapp', '6281234567890');
            $email = Setting::getByKey('cs_email', 'cs.jurnal@edujournal.sch.id');
            $jamKerja = Setting::getByKey('cs_jam_kerja', 'Senin - Jumat (07:00 - 15:30 WIB)');

            $cleanWa = preg_replace('/[^0-9]/', '', $waNum);
            $waMessage = urlencode("Halo Customer Service EDU JOURNAL, saya {$user->name} ({$user->role_label}) ingin berkonsultasi:");
            $waLink = "https://wa.me/{$cleanWa}?text={$waMessage}";

            return [
                'status' => 'success',
                'topic' => 'Informasi Kontak CS Official',
                'reply' => "<strong>Informasi Kontak & Dukungan Resmi CS EDU JOURNAL:</strong><br>
                    <ul style='margin-left: 18px; margin-top: 6px;'>
                        <li><strong>Hotline WhatsApp:</strong> {$waNum}</li>
                        <li><strong>Email Support:</strong> {$email}</li>
                        <li><strong>Jam Kerja Layanan:</strong> {$jamKerja}</li>
                        <li><strong>Status Operasional:</strong> <span style='color:#16a34a; font-weight:800;'>CS Active & Online</span></li>
                    </ul>",
                'action_button' => [
                    'label' => 'Live Chat WhatsApp CS Direct',
                    'url' => $waLink,
                ],
                'quick_suggestions' => ['Status & Cek Tiket Saya', 'Cara Isi Jurnal Mengajar'],
            ];
        }

        // C. Profil & Akun User Terkini
        if (str_contains($query, 'profil saya') || str_contains($query, 'data akun saya') || str_contains($query, 'data pengguna')) {
            return [
                'status' => 'success',
                'topic' => 'Informasi Akun Pengguna',
                'reply' => "<strong>Detail Profil Akun Anda (Live System Data):</strong><br>
                    <ul style='margin-left: 18px; margin-top: 6px;'>
                        <li><strong>Nama Lengkap:</strong> {$user->name}</li>
                        <li><strong>Username / NIP / ID:</strong> " . ($user->username ?: ($user->nip ?: '-')) . "</li>
                        <li><strong>Role Sistem:</strong> {$user->role_label}</li>
                        <li><strong>Email:</strong> " . ($user->email ?: '-') . "</li>
                        <li><strong>No. HP:</strong> " . ($user->no_hp ?: '-') . "</li>
                        <li><strong>Status Akun:</strong> <span style='color:#16a34a; font-weight:700;'>Terverifikasi Aktif</span></li>
                    </ul>",
                'action_button' => ['label' => 'Buka Pengaturan Akun', 'url' => self::getRouteUrl('pengaturan.index', '/pengaturan')],
                'suggestions' => ['Reset Password Pengguna', 'Status & Cek Tiket Saya'],
            ];
        }

        // D. Statistik Presensi & Kegiatan Hari Ini
        if (str_contains($query, 'statistik presensi') || str_contains($query, 'rekap hari ini') || str_contains($query, 'kegiatan hari ini')) {
            $today = Carbon::today()->toDateString();
            $countJurnal = JurnalMengajar::whereDate('tanggal', $today)->count();
            $countDispen = SiswaDispen::whereDate('tanggal', $today)->count();

            return [
                'status' => 'success',
                'topic' => 'Statistik Presensi & Dispen Sekolah Hari Ini',
                'reply' => "<strong>Ringkasan Data Presensi Sekolah Hari Ini (" . date('d M Y') . "):</strong><br>
                    <ul style='margin-left: 18px; margin-top: 6px;'>
                        <li><strong>Total Jurnal Mengajar Terisi:</strong> {$countJurnal} Sesi Pelajaran</li>
                        <li><strong>Total Siswa Dispensasi Izin:</strong> {$countDispen} Siswa</li>
                        <li><strong>Status Sistem:</strong> Berjalan Lancar & Terkoneksi Real-time</li>
                    </ul>",
                'action_button' => ['label' => 'Buka Halaman Presensi', 'url' => self::getRouteUrl('guru.jurnal-harian', '/guru-jurnal-harian')],
                'suggestions' => ['Cara Isi Jurnal Mengajar', 'Buat Dispensasi Siswa Keluar'],
            ];
        }

        // E. Wali Kelas Bimbingan
        if (str_contains($query, 'wali kelas bimbingan') || str_contains($query, 'siapa wali kelas')) {
            $waliList = Kelas::whereNotNull('wali_kelas')->where('wali_kelas', '!=', '')->take(5)->get();
            $waliHtml = "<ul style='margin-left: 18px; margin-top: 6px;'>";
            foreach ($waliList as $kls) {
                $guru = Guru::where('nip', trim($kls->wali_kelas))->first();
                $namaWali = $guru->nama_guru ?? 'NIP: ' . $kls->wali_kelas;
                $waliHtml .= "<li><strong>Kelas {$kls->nama_kelas}:</strong> {$namaWali}</li>";
            }
            $waliHtml .= "</ul>";

            return [
                'status' => 'success',
                'topic' => 'Informasi Wali Kelas (Live System Data)',
                'reply' => "<strong>Daftar Penugasan Wali Kelas di Database:</strong><br>{$waliHtml}",
                'suggestions' => ['Approval Surat Izin Siswa', 'Status & Cek Tiket Saya'],
            ];
        }


        // ── 2. MATCHING KNOWLEDGE BASE MATRIX (TUTORIAL & TROUBLESHOOTING) ──
        $knowledge = self::getKnowledgeBase();

        $bestMatch = null;
        $highestScore = 0;

        foreach ($knowledge as $item) {
            // Cek role restriction jika ada
            if (isset($item['roles']) && !in_array('all', $item['roles'])) {
                $roleAllowed = false;
                foreach ($item['roles'] as $r) {
                    if ($r === 'admin' && $user->isAdmin()) $roleAllowed = true;
                    if ($r === 'guru' && $user->isGuru()) $roleAllowed = true;
                    if ($r === 'wali_kelas' && $user->isWaliKelas()) $roleAllowed = true;
                    if ($r === 'piket' && $user->isGuruPiket()) $roleAllowed = true;
                    if ($r === 'waka' && $user->isWaka()) $roleAllowed = true;
                    if ($r === 'kepala_sekolah' && $user->isKepalaSekolah()) $roleAllowed = true;
                    if ($r === 'orang_tua' && $user->isOrangTua()) $roleAllowed = true;
                    if ($r === 'satpam' && $user->isSatpam()) $roleAllowed = true;
                }
                if (!$roleAllowed) continue;
            }

            // Hitung skor pencocokan kata kunci
            $score = 0;
            foreach ($item['keywords'] as $kw) {
                if (str_contains($query, strtolower($kw))) {
                    $score += strlen($kw);
                }
            }

            if ($score > $highestScore) {
                $highestScore = $score;
                $bestMatch = $item;
            }
        }

        if ($bestMatch && $highestScore > 0) {
            return [
                'status' => 'success',
                'topic' => $bestMatch['title'],
                'reply' => $bestMatch['reply'],
                'action_button' => $bestMatch['action_button'] ?? null,
                'quick_suggestions' => $bestMatch['suggestions'] ?? [],
            ];
        }

        // Jawaban Standar jika tidak ada pencocokan pasti (Fallback)
        return [
            'status' => 'fallback',
            'topic' => 'Pusat Bantuan & Panduan Umum',
            'reply' => "Mohon maaf, saya belum menemukan jawaban spesifik untuk pertanyaan <em>\"" . e($rawQuery) . "\"</em>.<br><br>
                <strong>Saran Penanganan:</strong><br>
                1. Cobalah gunakan kata kunci sederhana seperti: <code>jurnal</code>, <code>absensi</code>, <code>surat izin</code>, <code>reset password</code>, <code>dispen</code>, atau <code>gagal simpan</code>.<br>
                2. Anda dapat memilih topik rekomendasi cepat di bagian atas chat.<br>
                3. Jika terdapat kendala teknis khusus, silakan isi <strong>Form Kirim Kendala CS</strong> di bawah atau hubungi WhatsApp CS Direct.",
            'action_button' => [
                'label' => 'Kirim Tiket Ke CS',
                'url' => '#form-tiket-cs',
                'trigger_form' => true,
            ],
            'quick_suggestions' => array_column(self::getQuickTopics($user), 'label'),
        ];
    }

    /**
     * Data Lengkap Basis Pengetahuan CS (Knowledge Base Matrix - Murni Tanpa Emoji & Tanpa Ikon).
     */
    private static function getKnowledgeBase(): array
    {
        return [
            // ── GURU MENGAJAR ──
            [
                'title' => 'Panduan Cara Mengisi Jurnal Mengajar Harian',
                'roles' => ['guru', 'wali_kelas', 'piket', 'admin'],
                'keywords' => ['isi jurnal', 'mengisi jurnal', 'buat jurnal', 'jurnal mengajar', 'cara jurnal', 'tambah jurnal', 'input jurnal'],
                'reply' => "<strong>Langkah-langkah Pengisian Jurnal Mengajar Harian:</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li>Buka menu <strong>Jurnal Harian</strong> di sidebar sebelah kiri.</li>
                        <li>Pilih <strong>Kelas</strong>, <strong>Mata Pelajaran</strong>, dan <strong>Jam Ke-</strong> sesuai jadwal mengajar Anda.</li>
                        <li>Tuliskan <strong>Materi Pembelajaran</strong> & <strong>Keterangan Pembelajaran</strong>.</li>
                        <li>Lakukan absensi status kehadiran siswa (Hadir, Sakit, Izin, Alpa). Siswa yang memiliki surat izin disetujui akan terisi otomatis.</li>
                        <li>Unggah foto dokumentasi kegiatan mengajar di kelas.</li>
                        <li>Klik tombol <strong>Simpan Jurnal Mengajar</strong>.</li>
                    </ol>
                    <div style='margin-top: 8px; background: #e0f2fe; padding: 8px 12px; border-radius: 8px; font-size: 12.5px; color: #0369a1;'>
                        <strong>Tips:</strong> Pastikan tanggal dan jam mengajar sudah sesuai dengan jadwal pelajaran Anda hari ini.
                    </div>",
                'action_button' => ['label' => 'Buka Form Jurnal Harian', 'url' => self::getRouteUrl('guru.jurnal-harian', '/guru-jurnal-harian')],
                'suggestions' => ['Jurnal Gagal Disimpan / Bentrok', 'Presensi Kehadiran Siswa', 'Gagal Upload Foto'],
            ],
            [
                'title' => 'Solusi Jurnal Mengajar Gagal Disimpan / Bentrok Jam',
                'roles' => ['guru', 'wali_kelas', 'piket', 'admin'],
                'keywords' => ['gagal simpan', 'tidak bisa simpan', 'jam bentrok', 'sudah diisi', 'error jurnal', 'gagal jurnal', 'bentrok'],
                'reply' => "<strong>Kenapa Jurnal Mengajar Tidak Bisa Disimpan?</strong><br>
                    Berikut penyebab utama dan cara mengatasinya:<br>
                    <ul style='margin-left: 18px; margin-top: 6px;'>
                        <li><strong>Penyebab 1: Jam Mengajar Sudah Terisi.</strong> Jurnal di kelas dan jam pelajaran tersebut sudah diinput oleh Anda atau Guru Pengganti sebelumnya. Solusi: Cek di <em>Riwayat Jurnal Mengajar</em> untuk mengedit jurnal yang sudah ada.</li>
                        <li><strong>Penyebab 2: Foto Terlalu Besar.</strong> Ukuran foto melebihi limit max 5MB. Solusi: Kurangi resolusi foto atau upload foto format JPG/PNG di bawah 5MB.</li>
                        <li><strong>Penyebab 3: Sesi Login Kadaluarsa.</strong> Halaman sudah terbuka terlalu lama. Solusi: Refresh halaman dan login kembali jika diperlukan.</li>
                    </ul>",
                'action_button' => ['label' => 'Cek Riwayat Jurnal Saya', 'url' => self::getRouteUrl('guru.riwayat-jurnal', '/guru-riwayat-jurnal')],
                'suggestions' => ['Cara Isi Jurnal Mengajar', 'Gagal Upload Foto'],
            ],
            [
                'title' => 'Cara Pengajuan Permintaan Izin Guru (Sakit / Cuti / Acara)',
                'roles' => ['guru', 'wali_kelas', 'piket', 'admin'],
                'keywords' => ['izin guru', 'guru izin', 'sakit guru', 'cuti guru', 'permintaan izin', 'pengajuan izin', 'acara guru'],
                'reply' => "<strong>Cara Mengajukan Surat Izin / Sakit untuk Guru:</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li>Masuk ke menu <strong>Permintaan Izin Saya</strong>.</li>
                        <li>Klik tombol <strong>+ Buat Permintaan Izin</strong>.</li>
                        <li>Pilih kategori izin (Sakit, Cuti, Keperluan Keluarga, Dinas Luar).</li>
                        <li>Isi Tanggal Mulai s/d Tanggal Selesai dan berikan Alasan Izin secara jelas.</li>
                        <li>Unggah foto/file bukti (Surat Dokter / Surat Tugas jika ada).</li>
                        <li>Klik <strong>Kirim Pengajuan</strong>. Status akan diproses oleh Guru Piket / Waka / Admin TU.</li>
                    </ol>",
                'action_button' => ['label' => 'Buka Permintaan Izin Guru', 'url' => self::getRouteUrl('guru.permintaan-izin', '/guru-permintaan-izin')],
                'suggestions' => ['Beralih ke Guru Piket', 'Penugasan Guru Pengganti'],
            ],
            [
                'title' => 'Cara Beralih Mode Ke Guru Piket',
                'roles' => ['guru', 'wali_kelas', 'piket', 'admin'],
                'keywords' => ['beralih piket', 'pindah piket', 'mode piket', 'masuk piket', 'jadi piket', 'guru piket hari ini'],
                'reply' => "<strong>Cara Beralih ke Role Guru Piket:</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li>Buka menu sidebar sebelah kiri atau klik menu profil di pojok kanan atas.</li>
                        <li>Pilih menu <strong>Beralih ke Guru Piket</strong>.</li>
                        <li>Jika NIP/Akun Anda ditugaskan sebagai Guru Piket hari ini, sistem akan otomatis beralih ke Dashboard Guru Piket.</li>
                        <li>Dari sana, Anda dapat mengelola jurnal piket, dispensasi siswa, dan penugasan guru pengganti.</li>
                    </ol>",
                'action_button' => ['label' => 'Beralih ke Guru Piket', 'url' => self::getRouteUrl('guru.beralih-ke-guru-piket', '/guru-beralih-ke-guru-piket')],
                'suggestions' => ['Isi Jurnal Piket Harian', 'Buat Dispensasi Siswa Keluar'],
            ],

            // ── WALI KELAS ──
            [
                'title' => 'Panduan Approval Surat Izin Siswa untuk Wali Kelas',
                'roles' => ['wali_kelas', 'admin'],
                'keywords' => ['acc surat', 'approval siswa', 'setujui izin', 'surat izin siswa', 'wali kelas approval', 'terima izin', 'acc izin'],
                'reply' => "<strong>Cara Menyetujui / Menolak Surat Izin Siswa (Wali Kelas):</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li>Buka menu <strong>Approval Surat Izin Siswa</strong> di dashboard Wali Kelas.</li>
                        <li>Anda akan melihat daftar surat izin yang dikirim oleh Orang Tua / Siswa.</li>
                        <li>Klik tombol <strong>Detail / Review</strong> untuk melihat surat dokter atau bukti izin.</li>
                        <li>Klik tombol <strong>ACC / Setujui</strong> (atau <strong>Tolak</strong> jika data tidak valid).</li>
                        <li>Setelah di-ACC, status presensi siswa pada Jurnal Mengajar dan Sistem Piket/Satpam akan otomatis ter-update menjadi Izin/Sakit.</li>
                    </ol>",
                'action_button' => ['label' => 'Ke Halaman Approval Surat Izin', 'url' => self::getRouteUrl('piket.surat-izin-siswa', '/guru-piket/surat-izin-siswa')],
                'suggestions' => ['Surat Izin Tidak Muncul', 'Lihat Presensi Kelas Bimbingan'],
            ],
            [
                'title' => 'Solusi Surat Izin Siswa Tidak Muncul di Menu Approval',
                'roles' => ['wali_kelas', 'admin'],
                'keywords' => ['izin tidak muncul', 'approval kosong', 'surat izin hilang', 'siswa izin tidak ada', 'tidak ada izin'],
                'reply' => "<strong>Mengapa Surat Izin Siswa Belum Muncul di Approval Wali Kelas?</strong><br>
                    <ul style='margin-left: 18px; margin-top: 6px;'>
                        <li><strong>NIP Wali Kelas Belum Terhubung:</strong> NIP Anda di akun pengguna belum sesuai dengan NIP penugasan Wali Kelas di Data Master Kelas. Minta Admin TU untuk melakukan sinkronisasi NIP Wali Kelas.</li>
                        <li><strong>Pengajuan Masih Draft:</strong> Orang Tua / Siswa belum menekan tombol kirim akhir pada form izin.</li>
                        <li><strong>Beda Kelas:</strong> Siswa yang mengajukan izin berada di kelas lain yang bukan kelas bimbingan Anda.</li>
                    </ul>",
                'action_button' => ['label' => 'Kirim Tiket Ke CS', 'url' => '#form-tiket-cs', 'trigger_form' => true],
                'suggestions' => ['Approval Surat Izin Siswa', 'Lihat Presensi Kelas Bimbingan'],
            ],

            // ── GURU PIKET ──
            [
                'title' => 'Panduan Fitur & Tugas Guru Piket',
                'roles' => ['piket', 'guru_piket', 'admin'],
                'keywords' => ['guru piket', 'jurnal piket', 'tugas piket', 'menu piket', 'piket harian', 'tugas guru piket'],
                'reply' => "<strong>Panduan Operasional Guru Piket Harian:</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li><strong>Beralih Mode Piket:</strong> Klik tombol <em>Beralih ke Role Guru Piket</em> di menu profil.</li>
                        <li><strong>Jurnal Piket:</strong> Buka menu <em>Jurnal Piket Harian</em> untuk menginput catatan kejadian, presensi guru tidak hadir, dan guru pengganti.</li>
                        <li><strong>Dispensasi Siswa:</strong> Buka menu <em>Dispensasi Siswa</em> untuk mengizinkan siswa keluar lingkungan sekolah saat jam pelajaran.</li>
                        <li><strong>Approval Permintaan Izin:</strong> Menyetujui pengajuan izin guru/siswa harian.</li>
                    </ol>",
                'action_button' => ['label' => 'Dashboard Guru Piket', 'url' => self::getRouteUrl('piket.dashboard', '/guru-piket/dashboard')],
                'suggestions' => ['Buat Dispensasi Siswa Keluar', 'Penugasan Guru Pengganti'],
            ],
            [
                'title' => 'Cara Membuat Izin Dispensasi Siswa (Guru Piket)',
                'roles' => ['piket', 'guru_piket', 'admin'],
                'keywords' => ['buat dispen', 'dispensasi siswa', 'izin keluar', 'barcode dispen', 'dispen keluar sekolah', 'tambah dispen'],
                'reply' => "<strong>Cara Menginput Dispensasi Siswa Keluar Sekolah:</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li>Masuk ke menu <strong>Dispensasi Siswa</strong> di portal Guru Piket.</li>
                        <li>Klik <strong>+ Tambah Dispensasi Siswa</strong>.</li>
                        <li>Cari dan pilih nama siswa serta kelasnya.</li>
                        <li>Tentukan <strong>Jam Keluar</strong>, estimasi <strong>Jam Kembali</strong>, dan <strong>Alasan Dispensasi</strong>.</li>
                        <li>Klik <strong>Simpan & Generate Barcode</strong>. Kode & Barcode unik akan dibuat secara otomatis untuk di-scan oleh Satpam Gerbang.</li>
                    </ol>",
                'action_button' => ['label' => 'Buka Dispensasi Siswa', 'url' => self::getRouteUrl('piket.dispensasi-siswa', '/guru-piket/dispensasi-siswa')],
                'suggestions' => ['Barcode Terpakai / Kadaluarsa', 'Penugasan Guru Pengganti'],
            ],

            // ── SATPAM GERBANG ──
            [
                'title' => 'Panduan Validasi Barcode Dispensasi Siswa oleh Satpam',
                'roles' => ['satpam', 'admin'],
                'keywords' => ['scan barcode', 'validasi dispen', 'satpam dispen', 'kode dispen', 'gerbang dispen', 'status satpam', 'scan satpam'],
                'reply' => "<strong>Cara Validasi Barcode & Kode Dispensasi di Portal Satpam:</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li>Buka portal <strong>Satpam Gerbang -> Validasi Dispen</strong>.</li>
                        <li>Gunakan Barcode Scanner atau ketikkan <strong>Kode Dispen / NISN Siswa</strong> di kolom pencarian.</li>
                        <li>Sistem akan menampilkan foto siswa, nama, kelas, alasan, dan status approval Waka/Wali Kelas.</li>
                        <li>Jika status valid (Approved), klik <strong>Izinkan Keluar</strong> saat siswa meninggalkan gerbang. Barcode akan otomatis kadaluarsa setelah digunakan.</li>
                        <li>Jika siswa telah kembali ke sekolah, update status menjadi <strong>Sudah Kembali</strong>.</li>
                    </ol>",
                'action_button' => ['label' => 'Buka Validasi Satpam', 'url' => self::getRouteUrl('satpam.validasi', '/satpam/validasi')],
                'suggestions' => ['Lapor Kejadian Siswa ke WA', 'Barcode Terpakai / Kadaluarsa'],
            ],
            [
                'title' => 'Cara Melaporkan Siswa Terlambat / Melanggar ke WA via Satpam',
                'roles' => ['satpam', 'admin'],
                'keywords' => ['lapor siswa', 'kirim wa satpam', 'terlambat satpam', 'pelanggaran siswa', 'satpam wa', 'lapor kejadian'],
                'reply' => "<strong>Cara Kirim Laporan Siswa ke Wali Kelas & Guru Piket via WhatsApp:</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li>Masuk ke menu <strong>Lapor Kejadian Siswa</strong> di Portal Satpam.</li>
                        <li>Pilih Nama Siswa dari daftar atau gunakan pencarian komprehensif.</li>
                        <li>Pilih Jenis Kejadian (Keterlambatan, Keluar Tanpa Izin, Pelanggaran Seragam, Dll).</li>
                        <li>Centang opsi <em>Kirim ke Wali Kelas</em> atau <em>Kirim ke Guru Piket</em>.</li>
                        <li>Klik <strong>Simpan Laporan</strong>. Sistem akan membuka WhatsApp secara otomatis dengan pesan formal terformat rapi berisi detail kejadian.</li>
                    </ol>",
                'action_button' => ['label' => 'Buka Lapor Siswa Satpam', 'url' => self::getRouteUrl('satpam.lapor-siswa', '/satpam/lapor-siswa')],
                'suggestions' => ['Scan Barcode Dispen Siswa', 'Barcode Terpakai / Kadaluarsa'],
            ],

            // ── ORANG TUA ──
            [
                'title' => 'Cara Pemantauan Kehadiran & Jurnal Anak oleh Orang Tua',
                'roles' => ['orang_tua', 'admin'],
                'keywords' => ['pantau anak', 'jurnal anak', 'presensi anak', 'kehadiran anak', 'orang tua pantau', 'akun orang tua', 'lihat anak'],
                'reply' => "<strong>Panduan Fitur Portal Orang Tua / Wali Murid:</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li><strong>Dashboard Utama:</strong> Menampilkan ringkasan kehadiran anak hari ini (Hadir, Sakit, Izin, Alpa) dan jurnal mata pelajaran yang sedang diikuti.</li>
                        <li><strong>Riwayat Presensi:</strong> Melihat statistik kehadiran bulanan anak.</li>
                        <li><strong>Pengajuan Surat Izin:</strong> Mengirimkan pemberitahuan jika anak sakit atau berhalangan hadir beserta unggahan foto surat dokter/keterangan.</li>
                        <li><strong>Kontak Wali Kelas:</strong> Menghubungi Wali Kelas bimbingan anak secara langsung.</li>
                    </ol>",
                'action_button' => ['label' => 'Dashboard Orang Tua', 'url' => self::getRouteUrl('orang-tua.dashboard', '/orang-tua/dashboard')],
                'suggestions' => ['Pengajuan Surat Izin Anak', 'Info CS & Hotline'],
            ],
            [
                'title' => 'Cara Mengajukan Surat Izin Sakit / Acara Keluarga Anak (Orang Tua)',
                'roles' => ['orang_tua', 'admin'],
                'keywords' => ['izin anak', 'surat izin anak', 'anak sakit', 'orang tua kirim izin', 'buat izin anak', 'izin ortu'],
                'reply' => "<strong>Langkah Pengajuan Surat Izin Anak oleh Orang Tua:</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li>Buka menu <strong>Permintaan Izin Anak</strong> di Dashboard Orang Tua.</li>
                        <li>Klik <strong>+ Buat Permintaan Izin</strong>.</li>
                        <li>Pilih Kategori Izin (Sakit / Acara Keluarga / Kepentingan Mendesak).</li>
                        <li>Isi Tanggal Izin dan Keterangan Alasan.</li>
                        <li>Unggah foto Surat Dokter / Surat Permohonan Orang Tua.</li>
                        <li>Klik <strong>Kirim Permintaan</strong>. Permohonan akan langsung masuk ke menu Approval Wali Kelas.</li>
                    </ol>",
                'action_button' => ['label' => 'Ajukan Surat Izin Anak', 'url' => self::getRouteUrl('orang-tua.izin', '/orang-tua/izin')],
                'suggestions' => ['Pantau Kehadiran Anak', 'Info CS & Hotline'],
            ],

            // ── ADMINISTRATOR & TU ──
            [
                'title' => 'Panduan Kelola Data Master & Users (Admin / TU)',
                'roles' => ['admin'],
                'keywords' => ['data master', 'kelola user', 'verifikasi guru', 'tambah kelas', 'tambah mapel', 'admin tu', 'master data'],
                'reply' => "<strong>Manajemen Data Master & Pengguna oleh Admin TU:</strong><br>
                    <ul style='margin-left: 18px; margin-top: 6px;'>
                        <li><strong>Verifikasi Guru:</strong> Buka <em>Data Master -> Verifikasi Guru</em> untuk menyetujui pendaftaran akun guru baru.</li>
                        <li><strong>Set Wali Kelas & Piket:</strong> Atur NIP Wali Kelas pada Data Kelas, dan tentukan NIP Guru Piket di Pengaturan Jam/Shift.</li>
                        <li><strong>Data Siswa & Kelas:</strong> Import data dari Excel atau tambah siswa manual.</li>
                        <li><strong>Trash / Sampah:</strong> Semua data terhapus masuk ke Trash (Users, Guru, Wali Kelas, Piket) dan dapat di-restore sewaktu-waktu.</li>
                    </ul>",
                'action_button' => ['label' => 'Dashboard Administrator', 'url' => self::getRouteUrl('admin.dashboard', '/admin/dashboard')],
                'suggestions' => ['Reset Password Pengguna', 'Restore Data Terhapus'],
            ],
            [
                'title' => 'Cara Reset Password Pengguna (Admin / TU)',
                'roles' => ['admin'],
                'keywords' => ['reset password', 'lupa password guru', 'ganti password user', 'admin reset password', 'sandi user'],
                'reply' => "<strong>Langkah Reset Password Pengguna oleh Admin TU:</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li>Masuk ke menu <strong>Data Users / Pengguna</strong>.</li>
                        <li>Cari NIP / Username / Nama pengguna yang lupa password.</li>
                        <li>Klik tombol <strong>Reset Password</strong> di sebelah kanan baris data.</li>
                        <li>Sistem akan mengembalikan password ke nilai default (misal: <code>piket123</code> atau password kustom yang Anda atur).</li>
                        <li>Beri tahu pengguna password baru mereka untuk segera diubah setelah login di menu Pengaturan Akun.</li>
                    </ol>",
                'action_button' => ['label' => 'Kelola Data Users', 'url' => self::getRouteUrl('admin.pengguna', '/admin/pengguna')],
                'suggestions' => ['Kelola Data Master & Users', 'Info Kontak CS Official'],
            ],
            [
                'title' => 'Cara Mengembalikan Data yang Terhapus dari Trash (Restore Data)',
                'roles' => ['admin'],
                'keywords' => ['restore data', 'trash', 'data terhapus', 'kembalikan data', 'sampah admin', 'restore guru'],
                'reply' => "<strong>Panduan Restore Data dari Trash (Soft Delete):</strong><br>
                    Data di EDU JOURNAL tidak hilang permanen saat dihapus, melainkan masuk ke Sampah/Trash.<br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li>Buka menu Trash sesuai kategori (misal: <em>Data Guru Trash</em>, <em>Wali Kelas Trash</em>, atau <em>Users Trash</em>).</li>
                        <li>Cari nama/data yang ingin dikembalikan.</li>
                        <li>Klik tombol <strong>Restore (Kembalikan)</strong>. Data akan aktif kembali di sistem secara instan.</li>
                        <li>Gunakan <strong>Force Delete</strong> hanya jika Anda benar-benar ingin menghapus data dari database secara permanen.</li>
                    </ol>",
                'action_button' => ['label' => 'Halaman Users Trash', 'url' => self::getRouteUrl('admin.users-trash', '/admin/users-trash')],
                'suggestions' => ['Kelola Data Master & Users', 'Reset Password Pengguna'],
            ],

            // ── WAKA & KEPALA SEKOLAH ──
            [
                'title' => 'Panduan Executive Dashboard & Rekap Laporan Sekolah',
                'roles' => ['waka', 'kepala_sekolah', 'admin'],
                'keywords' => ['executive dashboard', 'kepala sekolah', 'waka kurikulum', 'waka sdm', 'rekap bulanan', 'laporan presensi', 'pantau guru'],
                'reply' => "<strong>Panduan Fitur Executive & Pengawasan Kepala Sekolah / Waka:</strong><br>
                    <ul style='margin-left: 18px; margin-top: 6px;'>
                        <li><strong>Monitoring Kehadiran Real-time:</strong> Pantau persentase kehadiran guru mengajar dan siswa hari ini secara visual.</li>
                        <li><strong>Keterisian Jurnal:</strong> Melihat jurnal mana saja yang belum diisi oleh guru beserta catatan kendalanya.</li>
                        <li><strong>Approval Berjenjang:</strong> Menyetujui pengajuan izin/cuti guru atau dispensasi khusus siswa.</li>
                        <li><strong>Cetak & Eksport Laporan:</strong> Mengunduh rekapitulasi kehadiran bulanan atau semesteran untuk evaluasi manajerial.</li>
                    </ul>",
                'action_button' => ['label' => 'Dashboard Kepala Sekolah', 'url' => self::getRouteUrl('kepala-sekolah.dashboard', '/kepala-sekolah/dashboard')],
                'suggestions' => ['Approval Level Waka', 'Monitoring Jurnal Mengajar'],
            ],

            // ── UMUM & KENDALA TEKNIS ──
            [
                'title' => 'Kendala Lupa Password / Tidak Bisa Login',
                'roles' => ['all'],
                'keywords' => ['lupa password', 'tidak bisa login', 'gagal login', 'salah password', 'lupa akun', 'reset sandi', 'password salah'],
                'reply' => "<strong>Solusi Lupa Password / Gagal Login:</strong><br>
                    <ol style='margin-left: 18px; margin-top: 6px;'>
                        <li>Pastikan Username/NIP dan Password diketik dengan benar (perhatikan huruf besar/kecil).</li>
                        <li>Jika menggunakan password default awal sekolah, coba masukkan <code>piket123</code>.</li>
                        <li>Jika masih gagal, silakan hubungi <strong>Admin TU Sekolah</strong> atau kirim pesan via <strong>Live Chat WhatsApp CS</strong> untuk dilakukan reset password akun Anda.</li>
                    </ol>",
                'action_button' => ['label' => 'Live Chat WhatsApp CS', 'url' => 'https://wa.me/6281234567890'],
                'suggestions' => ['Cara Isi Jurnal Mengajar', 'Gagal Upload Foto'],
            ],
            [
                'title' => 'Solusi Gagal Upload Foto / Format Gambar Tidak Didukung',
                'roles' => ['all'],
                'keywords' => ['gagal upload', 'foto tidak bisa', 'format foto', 'ukuran foto', 'upload gambar error', 'gagal foto'],
                'reply' => "<strong>Solusi Gagal Unggah Foto Dokumentasi / Surat:</strong><br>
                    <ul style='margin-left: 18px; margin-top: 6px;'>
                        <li><strong>Ukuran File:</strong> Pastikan ukuran file gambar maksimal <strong>5 MB</strong>. Jika terlalu besar, lakukan kompresi foto terlebih dahulu.</li>
                        <li><strong>Format File:</strong> Format yang didukung adalah <code>.jpg</code>, <code>.jpeg</code>, <code>.png</code>, atau <code>.pdf</code> (khusus surat izin).</li>
                        <li><strong>Kamera HP:</strong> Jika menggunakan kamera langsung di HP browser, pastikan Anda telah mengizinkan akses Kamera (Permission: Allow Camera).</li>
                    </ul>",
                'suggestions' => ['Jurnal Gagal Disimpan / Bentrok', 'Cara Isi Jurnal Mengajar'],
            ],
        ];
    }
}
