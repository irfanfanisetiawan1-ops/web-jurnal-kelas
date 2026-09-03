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
     * Accessor untuk format tanggal Indonesia (e.g. 2026-07-28 -> 28 Juli 2026)
     */
    public function getTanggalFormattedAttribute()
    {
        if (!$this->tanggal) return '-';
        return date('d-m-Y', strtotime($this->tanggal));
    }
}
