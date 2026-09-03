<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiswaTelat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'siswa_telat';
    protected $primaryKey = 'id_siswa_telat';

    protected $fillable = [
        'id_siswa',
        'id_kelas',
        'id_guru_mengajar',
        'id_jadwal',
        'id_guru_piket',
        'id_pengumuman',
        'tanggal',
        'jam_terlambat',
        'alasan',
        'tindakan_hukuman',
        'status_notifikasi',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa')->withTrashed();
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas')->withTrashed();
    }

    public function guruMengajar()
    {
        return $this->belongsTo(Guru::class, 'id_guru_mengajar', 'id_guru')->withTrashed();
    }

    public function guruPiket()
    {
        return $this->belongsTo(User::class, 'id_guru_piket', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal')->withTrashed();
    }

    public function pengumuman()
    {
        return $this->belongsTo(Pengumuman::class, 'id_pengumuman', 'id_pengumuman');
    }
}
