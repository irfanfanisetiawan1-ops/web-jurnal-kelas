<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class GuruIzin extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guru_izin';
    protected $primaryKey = 'id_guru_izin';

    protected $fillable = [
        'id_guru',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi',
        'kategori_izin',
        'alasan',
        'keterangan_khusus',
        'materi_dititipkan',
        'tugas_dititipkan',
        'file_tugas',
        'foto_surat',
        'token_approval',
        'status_waka',
        'status_waka_sdm',
        'status_kepsek',
        'status_final',
        'catatan_waka',
        'catatan_kepsek',
        'is_pengajuan_guru',
        'status_piket',
        'id_guru_piket',
        'nama_guru_piket',
        'nip_guru_piket',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    public function guruPiket()
    {
        return $this->belongsTo(Guru::class, 'id_guru_piket', 'id_guru');
    }

    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto_surat && file_exists(public_path('uploads/guru_izin/' . $this->foto_surat))) {
            return asset('uploads/guru_izin/' . $this->foto_surat);
        }
        return null;
    }

    public function getFileTugasUrlAttribute(): ?string
    {
        if ($this->file_tugas && file_exists(public_path('uploads/tugas_pengganti/' . $this->file_tugas))) {
            return asset('uploads/tugas_pengganti/' . $this->file_tugas);
        }
        return null;
    }

    public function getTanggalFormattedAttribute(): string
    {
        if (!$this->tanggal_mulai) return '-';
        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $c = Carbon::parse($this->tanggal_mulai);
        return sprintf('%02d - %s - %d', $c->day, $bulanIndo[$c->month] ?? '', $c->year);
    }

    public function getDurasiFormattedAttribute(): string
    {
        if ($this->durasi) {
            return $this->durasi;
        }
        if ($this->tanggal_mulai && $this->tanggal_selesai && $this->tanggal_mulai !== $this->tanggal_selesai) {
            return 'Multi Hari (' . $this->tanggal_mulai . ' s/d ' . $this->tanggal_selesai . ')';
        }
        return '1 Hari Full';
    }
}
