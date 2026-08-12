<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'nip',
        'email',
        'no_hp',
        'jenis_kelamin',
        'password',
        'role',
        'status_verifikasi',
        'id_guru',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function getJenisKelaminTeksAttribute(): string
    {
        $jk = $this->jenis_kelamin ?? ($this->guru->jenis_kelamin ?? null);
        if ($jk === 'L') return 'Laki-laki';
        if ($jk === 'P') return 'Perempuan';
        return '-';
    }

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    // ─── Role Helpers ─────────────────────────────────────────────────────────

    /**
     * Cek apakah user ber-role Tata Usaha (TU).
     */
    public function isTu(): bool
    {
        return $this->role === 'tu';
    }

    /**
     * TU dan Admin punya akses ke dashboard admin.
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'tu']);
    }

    /**
     * Semua guru (mengajar, wali kelas, piket) punya akses ke portal guru.
     */
    public function isTeacher(): bool
    {
        return in_array($this->role, ['guru', 'wali_kelas', 'piket']);
    }

    /**
     * Guru pengajar biasa dan wali kelas dapat mengisi jurnal mengajar.
     */
    public function isGuru(): bool
    {
        return in_array($this->role, ['guru', 'wali_kelas']);
    }

    /**
     * Petugas piket dapat mengisi jurnal piket.
     */
    public function isGuruPiket(): bool
    {
        return $this->role === 'piket';
    }

    /**
     * Wali kelas punya akses ke data kehadiran kelas.
     * Cek dari: role 'wali_kelas' ATAU terdaftar sebagai wali di tabel kelas.
     */
    public function isWaliKelas(): bool
    {
        if ($this->role === 'wali_kelas') {
            return true;
        }

        // Fallback: cek apakah NIP terdaftar sebagai wali_kelas di tabel kelas
        if ($this->nip) {
            return \App\Models\Kelas::where('wali_kelas', $this->nip)->exists();
        }

        return false;
    }

    /**
     * Akun sudah diverifikasi oleh Admin.
     */
    public function isVerified(): bool
    {
        return $this->status_verifikasi === 'verified';
    }

    /**
     * Mendapatkan label role yang ramah pengguna.
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'tu'         => 'Tata Usaha (Admin)',
            'admin'      => 'Administrator',
            'guru'       => 'Guru',
            'wali_kelas' => 'Wali Kelas',
            'piket'      => 'Petugas Piket',
            default      => ucfirst($this->role),
        };
    }
}
