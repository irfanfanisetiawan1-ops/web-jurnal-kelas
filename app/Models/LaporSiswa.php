<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporSiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lapor_siswa';
    protected $primaryKey = 'id_lapor_siswa';

    protected $fillable = [
        'id_siswa',
        'id_kelas',
        'id_siswa_dispen',
        'id_satpam',
        'jenis_kejadian',
        'catatan',
        'send_wali_kelas',
        'send_guru_piket',
        'status',
    ];

    protected $casts = [
        'send_wali_kelas' => 'boolean',
        'send_guru_piket' => 'boolean',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa')->withTrashed();
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas')->withTrashed();
    }

    public function siswaDispen()
    {
        return $this->belongsTo(SiswaDispen::class, 'id_siswa_dispen', 'id_siswa_dispen')->withTrashed();
    }

    public function satpamUser()
    {
        return $this->belongsTo(User::class, 'id_satpam', 'id')->withTrashed();
    }
}
