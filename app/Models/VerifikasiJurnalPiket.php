<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerifikasiJurnalPiket extends Model
{
    use SoftDeletes;

    protected $table = 'verifikasi_jurnal_piket';
    protected $primaryKey = 'id_verifikasi';

    protected $fillable = [
        'tanggal',
        'id_guru',
        'nama_guru_piket',
        'nip_guru_piket',
        'tanda_tangan',
        'catatan',
        'waktu_verifikasi',
        'ip_address',
        'user_agent',
        'total_jurnal_diverifikasi',
        'status',
    ];

    protected $casts = [
        'tanggal'          => 'string',
        'waktu_verifikasi' => 'datetime',
    ];

    /**
     * Relasi ke Master Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru')->withTrashed();
    }

    /**
     * Relasi ke seluruh Jurnal Mengajar pada tanggal ini
     */
    public function jurnalMengajars()
    {
        return $this->hasMany(JurnalMengajar::class, 'tanggal', 'tanggal');
    }
}