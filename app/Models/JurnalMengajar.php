<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JurnalMengajar extends Model
{
    use SoftDeletes;

    protected $table      = 'jurnal_mengajar';
    protected $primaryKey = 'id_jurnal';
    public    $timestamps = false;

    protected $dates = ['deleted_at', 'dicatat_pada'];

    protected $fillable = [
        'id_jadwal',
        'id_guru_pengganti',
        'tanggal',
        'materi',
        'pertemuan_ke',
        'status_kehadiran_guru',
        'catatan',
        'kondisi_kelas',
        'is_draft',
        'dokumentasi',
        'jam_ke',
        'dicatat_pada'
    ];

    /**
     * Relasi ke model Jadwal
     */
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    /**
     * Relasi ke Guru Pengganti (jika ada)
     */
    public function guruPengganti()
    {
        return $this->belongsTo(Guru::class, 'id_guru_pengganti', 'id_guru');
    }

    /**
     * Relasi ke detail ketidakhadiran siswa
     */
    public function detailKetidakhadiran()
    {
        return $this->hasMany(JurnalDetailKetidakhadiran::class, 'id_jurnal', 'id_jurnal');
    }

    /**
     * Helper Accessor: Guru
     */
    public function getGuruAttribute()
    {
        return $this->jadwal->guru ?? $this->guruPengganti ?? null;
    }

    /**
     * Helper Accessor: Kelas
     */
    public function getKelasAttribute()
    {
        return $this->jadwal->kelas ?? null;
    }

    /**
     * Helper Accessor: Mapel
     */
    public function getMapelAttribute()
    {
        return $this->jadwal->mapel ?? null;
    }

    protected $appends = ['dokumentasi_url'];

    /**
     * Accessor untuk format tanggal Indonesia (e.g. 2026-07-28 -> 28 Juli 2026)
     */
    public function getTanggalFormattedAttribute()
    {
        if (!$this->tanggal) return '-';
        return date('d-m-Y', strtotime($this->tanggal));
    }

    /**
     * Accessor untuk URL foto dokumentasi / kehadiran
     */
    public function getDokumentasiUrlAttribute()
    {
        if (!$this->dokumentasi) return null;

        if (str_starts_with($this->dokumentasi, 'http://') || str_starts_with($this->dokumentasi, 'https://')) {
            return $this->dokumentasi;
        }

        if (file_exists(public_path('uploads/dokumentasi/' . $this->dokumentasi))) {
            return asset('uploads/dokumentasi/' . $this->dokumentasi);
        }

        if (file_exists(public_path('storage/' . $this->dokumentasi))) {
            return asset('storage/' . $this->dokumentasi);
        }

        if (file_exists(storage_path('app/public/' . $this->dokumentasi))) {
            return asset('storage/' . $this->dokumentasi);
        }

        return asset('uploads/dokumentasi/' . $this->dokumentasi);
    }

    /**
     * Relasi ke Verifikasi & Tanda Tangan Guru Piket Harian
     */
    public function verifikasiPiket()
    {
        return $this->hasOne(VerifikasiJurnalPiket::class, 'tanggal', 'tanggal');
    }
}
