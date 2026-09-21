<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PelanggaranSiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pelanggaran_siswa';
    protected $primaryKey = 'id_pelanggaran';

    protected $fillable = [
        'id_siswa',
        'id_kelas',
        'id_guru_pelapor',
        'id_siswa_telat',
        'kategori_pelanggaran',
        'jenis_pelanggaran',
        'poin_pelanggaran',
        'tanggal',
        'jam',
        'alasan',
        'tindakan_sanksi',
        'status',
        'foto_bukti',
        'status_notifikasi_wa',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'poin_pelanggaran' => 'integer',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa')->withTrashed();
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas')->withTrashed();
    }

    public function guruPelapor()
    {
        return $this->belongsTo(User::class, 'id_guru_pelapor', 'id');
    }

    public function siswaTelat()
    {
        return $this->belongsTo(SiswaTelat::class, 'id_siswa_telat', 'id_siswa_telat')->withTrashed();
    }
}