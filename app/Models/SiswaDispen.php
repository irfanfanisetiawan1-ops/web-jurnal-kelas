<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiswaDispen extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswa_dispen';
    protected $primaryKey = 'id_siswa_dispen';

    protected $fillable = [
        'id_siswa',
        'id_kelas',
        'id_jurnal_piket',
        'id_user_waka',
        'nama_waka',
        'nip_waka',
        'no_hp_waka',
        'kode_dispen',
        'token_wali_kelas',
        'tanggal',
        'jam_keluar',
        'jam_kembali',
        'alasan',
        'tempat',
        'foto_surat_dispen',
        'foto_kartu_identitas',
        'foto_siswa_live',
        'ttd_siswa',
        'ttd_guru_piket',
        'status_waka',
        'catatan_waka',
        'waktu_approval_waka',
        'id_guru_piket',
        'nama_guru_piket',
        'nip_guru_piket',
        'status_wali_kelas',
        'status_satpam',
        'waktu_scan_satpam',
        'catatan_satpam',
    ];

    protected $appends = [
        'foto_surat_url',
        'foto_kartu_url',
        'foto_siswa_live_url',
        'ttd_siswa_url',
        'ttd_piket_url',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id_kelas) && !empty($model->id_siswa)) {
                $siswa = Siswa::find($model->id_siswa);
                if ($siswa && !empty($siswa->id_kelas)) {
                    $model->id_kelas = $siswa->id_kelas;
                }
            }
            if (empty($model->kode_dispen)) {
                $model->kode_dispen = 'DSP-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5));
            }
            if (empty($model->token_wali_kelas)) {
                $model->token_wali_kelas = \Illuminate\Support\Str::random(40);
            }
        });
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function jurnalPiket()
    {
        return $this->belongsTo(JurnalPiket::class, 'id_jurnal_piket', 'id_jurnal_piket');
    }

    public function wakaUser()
    {
        return $this->belongsTo(User::class, 'id_user_waka', 'id');
    }

    public function guruPiketUser()
    {
        return $this->belongsTo(User::class, 'id_guru_piket', 'id');
    }

    public function getFotoSuratUrlAttribute(): ?string
    {
        if ($this->foto_surat_dispen) {
            if (str_starts_with($this->foto_surat_dispen, 'http://') || str_starts_with($this->foto_surat_dispen, 'https://') || str_starts_with($this->foto_surat_dispen, 'data:image')) {
                return $this->foto_surat_dispen;
            }
            $cleanPath = ltrim($this->foto_surat_dispen, '/');
            if (file_exists(public_path($cleanPath))) {
                return asset($cleanPath);
            }
            if (file_exists(public_path('uploads/dispensasi/' . $cleanPath))) {
                return asset('uploads/dispensasi/' . $cleanPath);
            }
            return asset($cleanPath);
        }
        return null;
    }

    public function getFotoKartuUrlAttribute(): ?string
    {
        if ($this->foto_kartu_identitas) {
            if (str_starts_with($this->foto_kartu_identitas, 'http://') || str_starts_with($this->foto_kartu_identitas, 'https://') || str_starts_with($this->foto_kartu_identitas, 'data:image')) {
                return $this->foto_kartu_identitas;
            }
            $cleanPath = ltrim($this->foto_kartu_identitas, '/');
            if (file_exists(public_path($cleanPath))) {
                return asset($cleanPath);
            }
            if (file_exists(public_path('uploads/dispensasi/' . $cleanPath))) {
                return asset('uploads/dispensasi/' . $cleanPath);
            }
            return asset($cleanPath);
        }
        return null;
    }

    public function getFotoSiswaLiveUrlAttribute(): ?string
    {
        if ($this->foto_siswa_live) {
            if (str_starts_with($this->foto_siswa_live, 'http://') || str_starts_with($this->foto_siswa_live, 'https://') || str_starts_with($this->foto_siswa_live, 'data:image')) {
                return $this->foto_siswa_live;
            }
            $cleanPath = ltrim($this->foto_siswa_live, '/');
            if (file_exists(public_path($cleanPath))) {
                return asset($cleanPath);
            }
            if (file_exists(public_path('uploads/dispensasi/' . $cleanPath))) {
                return asset('uploads/dispensasi/' . $cleanPath);
            }
            if (file_exists(public_path('uploads/dispensasi/siswa/' . $cleanPath))) {
                return asset('uploads/dispensasi/siswa/' . $cleanPath);
            }
            return asset($cleanPath);
        }
        return null;
    }

    public function getTtdSiswaUrlAttribute(): ?string
    {
        if ($this->ttd_siswa) {
            if (str_starts_with($this->ttd_siswa, 'data:image')) {
                return $this->ttd_siswa;
            }
            if (file_exists(public_path($this->ttd_siswa))) {
                return asset($this->ttd_siswa);
            }
            if (file_exists(public_path('uploads/dispensasi/signatures/' . $this->ttd_siswa))) {
                return asset('uploads/dispensasi/signatures/' . $this->ttd_siswa);
            }
        }
        return null;
    }

    public function getTtdPiketUrlAttribute(): ?string
    {
        if ($this->ttd_guru_piket) {
            if (str_starts_with($this->ttd_guru_piket, 'data:image')) {
                return $this->ttd_guru_piket;
            }
            if (file_exists(public_path($this->ttd_guru_piket))) {
                return asset($this->ttd_guru_piket);
            }
            if (file_exists(public_path('uploads/dispensasi/signatures/' . $this->ttd_guru_piket))) {
                return asset('uploads/dispensasi/signatures/' . $this->ttd_guru_piket);
            }
        }
        return null;
    }
}
