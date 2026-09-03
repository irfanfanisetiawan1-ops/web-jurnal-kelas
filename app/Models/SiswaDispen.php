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
        'foto_surat_dispen',
        'foto_kartu_identitas',
        'status_waka',
        'catatan_waka',
        'waktu_approval_waka',
        'id_guru_piket',
        'nama_guru_piket',
        'status_wali_kelas',
        'status_satpam',
        'waktu_scan_satpam',
        'catatan_satpam',
    ];

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
}
