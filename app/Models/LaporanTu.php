<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanTu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laporan_tu';

    protected $fillable = [
        'ticket_code',
        'nama_pelapor',
        'role_pelapor',
        'nomor_identitas',
        'no_wa',
        'email',
        'kategori_kendala',
        'judul_laporan',
        'deskripsi_kendala',
        'lampiran',
        'status',
        'tanggapan_admin',
        'responded_by',
        'responded_at',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
            'created_at'   => 'datetime',
            'updated_at'   => 'datetime',
        ];
    }

    /**
     * Admin/TU yang menanggapi laporan.
     */
    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    /**
     * Label role pelapor yang rapi dan tepat.
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role_pelapor) {
            'guru'            => 'Guru Mengajar',
            'wali_kelas'      => 'Wali Kelas',
            'guru_piket'      => 'Guru Piket',
            'waka_kesiswaan'  => 'Waka Kesiswaan',
            'waka_kurikulum'  => 'Waka Kurikulum',
            'waka_sdm'        => 'Waka SDM',
            'kepala_sekolah'  => 'Kepala Sekolah',
            'satpam'          => 'Satpam Gerbang',
            'orang_tua'       => 'Orang Tua',
            default           => ucfirst(str_replace('_', ' ', $this->role_pelapor ?? 'Pengguna')),
        };
    }

    /**
     * URL Lampiran yang aman & direct.
     */
    public function getLampiranUrlAttribute(): ?string
    {
        if (!$this->lampiran) {
            return null;
        }

        if (str_starts_with($this->lampiran, 'uploads/')) {
            return asset($this->lampiran);
        }
        if (str_starts_with($this->lampiran, 'lampiran_laporan_tu/')) {
            return asset('storage/' . $this->lampiran);
        }
        return asset('uploads/laporan_tu/' . $this->lampiran);
    }

    /**
     * Cek apakah lampiran adalah file gambar.
     */
    public function getIsImageLampiranAttribute(): bool
    {
        if (!$this->lampiran) {
            return false;
        }
        $ext = strtolower(pathinfo($this->lampiran, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
    }

    /**
     * Badge status HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'  => '<span class="status-badge status-pending"><i class="fa-solid fa-clock"></i> Menunggu</span>',
            'diproses' => '<span class="status-badge status-progress"><i class="fa-solid fa-spinner fa-spin"></i> Diproses</span>',
            'selesai'  => '<span class="status-badge status-success"><i class="fa-solid fa-circle-check"></i> Selesai</span>',
            'ditolak'  => '<span class="status-badge status-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>',
            default    => '<span class="status-badge status-pending">' . ucfirst($this->status) . '</span>',
        };
    }

    /**
     * Badge kategori HTML.
     */
    public function getKategoriBadgeAttribute(): string
    {
        $color = match ($this->kategori_kendala) {
            'Permintaan Pembuatan Akun Baru'     => '#2563eb', // blue
            'Lupa Kata Sandi / Reset Password'   => '#ea580c', // orange
            'Akun Terkunci / Gagal Login'        => '#dc2626', // red
            'Perubahan Data Profil'              => '#7c3aed', // purple
            'Kendala Jadwal & Presensi'          => '#0891b2', // cyan
            default                              => '#475569', // slate
        };

        return '<span class="kategori-badge" style="background:' . $color . '15; color:' . $color . '; border:1px solid ' . $color . '30;">' . e($this->kategori_kendala) . '</span>';
    }

    /**
     * Format nomor WA untuk link chat langsung (misal 628...).
     */
    public function getWaLinkAttribute(): string
    {
        $cleanWa = preg_replace('/[^0-9]/', '', (string)$this->no_wa);
        if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62' . substr($cleanWa, 1);
        }
        $pesan = urlencode("Halo {$this->nama_pelapor}, kami dari Administrator Tata Usaha (TU) EDU JOURNAL ingin menindaklanjuti laporan Anda [Tiket: {$this->ticket_code}] perihal: {$this->judul_laporan}.");
        return "https://wa.me/{$cleanWa}?text={$pesan}";
    }

    /**
     * Generate kode tiket acak yang unik.
     */
    public static function generateTicketCode(): string
    {
        $datePrefix = date('Ymd');
        $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
        $code = "LAP-{$datePrefix}-{$random}";

        while (self::where('ticket_code', $code)->exists()) {
            $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
            $code = "LAP-{$datePrefix}-{$random}";
        }

        return $code;
    }
}
