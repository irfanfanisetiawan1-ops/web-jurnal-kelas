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
        'foto',
        'password',
        'password_plain',
        'role',
        'status_verifikasi',
        'is_active',
        'id_guru',
        'id_siswa',
        'id_kelas',
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
            'is_active'         => 'boolean',
        ];
    }

    public function getDisplayPasswordAttribute(): string
    {
        if (!empty($this->password_plain)) {
            return $this->password_plain;
        }
        if ($this->role === 'orang_tua') {
            if ($this->siswa && !empty($this->siswa->tanggal_lahir) && $this->siswa->tanggal_lahir !== '0000-00-00') {
                return \Carbon\Carbon::parse($this->siswa->tanggal_lahir)->format('Y-m-d');
            }
            return 'ortu123';
        }
        if ($this->role === 'waka_kesiswaan') {
            return 'kesiswaan123';
        }
        if ($this->role === 'waka') {
            return 'kurikulum123';
        }
        if ($this->role === 'waka_sdm') {
            return 'sdm123';
        }
        if (in_array($this->role, ['piket', 'guru_piket'])) {
            return 'piket123';
        }
        return 'piket123';
    }

    public function getJenisKelaminTeksAttribute(): string
    {
        $jk = $this->jenis_kelamin ?? ($this->guru->jenis_kelamin ?? null);
        if ($jk === 'L') return 'Laki-laki';
        if ($jk === 'P') return 'Perempuan';
        return '-';
    }

    public function getNipAttribute($value): ?string
    {
        if ($this->role === 'piket' && session()->has('original_guru_user_id')) {
            $origUser = self::find(session('original_guru_user_id'));
            if ($origUser && !empty($origUser->attributes['nip'])) {
                return $origUser->attributes['nip'];
            }
        }
        return $value;
    }

    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto && file_exists(public_path('uploads/profile_photos/' . $this->foto))) {
            return asset('uploads/profile_photos/' . $this->foto);
        }
        return null;
    }

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    // ─── Role Helpers ─────────────────────────────────────────────────────────

    public function isTu(): bool
    {
        return in_array($this->role, ['tu', 'admin']);
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'tu']);
    }

    public function isTeacher(): bool
    {
        return in_array($this->role, ['guru', 'wali_kelas', 'piket']);
    }

    public function isGuru(): bool
    {
        return in_array($this->role, ['guru', 'wali_kelas']);
    }

    public function isGuruPiket(): bool
    {
        return $this->role === 'piket';
    }

    public function isWaliKelas(): bool
    {
        if (in_array($this->role, ['tu', 'admin', 'piket', 'guru_piket', 'waka', 'waka_kurikulum', 'waka_kesiswaan', 'waka_sdm', 'satpam', 'kepala_sekolah', 'orang_tua'])) {
            return false;
        }

        $nips = array_filter([$this->nip, optional($this->guru)->nip]);
        if (!empty($nips)) {
            return \App\Models\Kelas::whereIn('wali_kelas', $nips)->exists();
        }

        return $this->role === 'wali_kelas';
    }

    /**
     * Otomatisasi Sinkronisasi Role Guru Mengajar vs Wali Kelas
     * Mengubah role pengguna selain role khusus (TU, Piket, Waka, Kepsek, Satpam, Ortu)
     * menjadi 'wali_kelas' jika NIP-nya ditugaskan pada tabel kelas, atau 'guru' jika tidak.
     */
    public static function syncWaliKelasRoles(): void
    {
        $specialRoles = ['tu', 'admin', 'piket', 'guru_piket', 'waka', 'waka_kurikulum', 'waka_kesiswaan', 'waka_sdm', 'kepala_sekolah', 'satpam', 'orang_tua'];

        $activeKelas = \App\Models\Kelas::whereNotNull('wali_kelas')
            ->where('wali_kelas', '!=', '')
            ->get(['id_kelas', 'wali_kelas']);

        $assignedNipToKelasId = [];
        foreach ($activeKelas as $kls) {
            if ($kls->wali_kelas) {
                $assignedNipToKelasId[trim($kls->wali_kelas)] = $kls->id_kelas;
            }
        }

        $users = self::whereNotIn('role', $specialRoles)->get();

        foreach ($users as $u) {
            $userNip = trim($u->nip ?? '');
            $guruNip = $u->guru ? trim($u->guru->nip ?? '') : null;

            $assignedKelasId = null;
            if ($userNip && isset($assignedNipToKelasId[$userNip])) {
                $assignedKelasId = $assignedNipToKelasId[$userNip];
            } elseif ($guruNip && isset($assignedNipToKelasId[$guruNip])) {
                $assignedKelasId = $assignedNipToKelasId[$guruNip];
            }

            if ($assignedKelasId) {
                $needsUpdate = false;
                if ($u->role !== 'wali_kelas') {
                    $u->role = 'wali_kelas';
                    $needsUpdate = true;
                }
                if ($u->id_kelas != $assignedKelasId) {
                    $u->id_kelas = $assignedKelasId;
                    $needsUpdate = true;
                }
                if ($needsUpdate) {
                    $u->save();
                }
            } else {
                $needsUpdate = false;
                if ($u->role !== 'guru') {
                    $u->role = 'guru';
                    $needsUpdate = true;
                }
                if ($u->id_kelas !== null) {
                    $u->id_kelas = null;
                    $needsUpdate = true;
                }
                if ($needsUpdate) {
                    $u->save();
                }
            }
        }
    }

    public function isWaka(): bool
    {
        return in_array($this->role, ['waka', 'waka_kurikulum', 'waka_kesiswaan', 'waka_sdm']);
    }

    public function isWakaKurikulum(): bool
    {
        return in_array($this->role, ['waka', 'waka_kurikulum']);
    }

    public function isWakaKesiswaan(): bool
    {
        return $this->role === 'waka_kesiswaan';
    }

    public function isWakaSdm(): bool
    {
        return $this->role === 'waka_sdm';
    }

    public function isSatpam(): bool
    {
        return $this->role === 'satpam';
    }

    public function isKepalaSekolah(): bool
    {
        return $this->role === 'kepala_sekolah';
    }

    public function isOrangTua(): bool
    {
        return $this->role === 'orang_tua';
    }

    public function isVerified(): bool
    {
        return $this->status_verifikasi === 'verified';
    }

    public function isActive(): bool
    {
        return (bool) ($this->is_active ?? true);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'tu'             => 'Admin TU',
            'admin'          => 'Administrator TU',
            'guru'           => 'Guru Mengajar',
            'wali_kelas'     => 'Wali Kelas',
            'piket'          => 'Guru Piket',
            'waka', 'waka_kurikulum' => 'Waka Kurikulum',
            'waka_kesiswaan' => 'Waka Kesiswaan',
            'waka_sdm'       => 'Waka SDM',
            'satpam'         => 'Satpam Gerbang',
            'kepala_sekolah' => 'Kepala Sekolah',
            'orang_tua'      => 'Orang Tua',
            default          => ucfirst($this->role),
        };
    }
}
