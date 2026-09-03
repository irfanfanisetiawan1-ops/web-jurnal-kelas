<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiswaSuratIzin extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswa_surat_izin';
    protected $primaryKey = 'id_surat_izin';

    protected $fillable = [
        'id_siswa',
        'id_kelas',
        'tanggal',
        'tanggal_selesai',
        'durasi_hari',
        'kategori',
        'keterangan',
        'foto_bukti',
        'id_petugas_piket',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function petugasPiket()
    {
        return $this->belongsTo(User::class, 'id_petugas_piket', 'id');
    }

    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto_bukti) {
            if (str_starts_with($this->foto_bukti, 'http://') || str_starts_with($this->foto_bukti, 'https://')) {
                return $this->foto_bukti;
            }
            if (file_exists(public_path('uploads/surat_izin_siswa/' . $this->foto_bukti))) {
                return asset('uploads/surat_izin_siswa/' . $this->foto_bukti);
            }
            if (file_exists(public_path($this->foto_bukti))) {
                return asset($this->foto_bukti);
            }
        }
        return null;
    }

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'Terverifikasi' => 'success',
            'Ditolak'       => 'danger',
            default         => 'pink-badge',
        };
    }

    public function getDurasiTextAttribute(): string
    {
        $durasi = $this->durasi_hari > 0 ? $this->durasi_hari : 1;
        return $durasi . ' Hari';
    }

    public function getRentangTanggalTextAttribute(): string
    {
        $start = \Carbon\Carbon::parse($this->tanggal)->format('d/m/Y');
        $end = $this->tanggal_selesai ? \Carbon\Carbon::parse($this->tanggal_selesai)->format('d/m/Y') : $start;
        if ($start === $end) {
            return $start . ' (' . $this->durasi_text . ')';
        }
        return $start . ' s/d ' . $end . ' (' . $this->durasi_text . ')';
    }
}
