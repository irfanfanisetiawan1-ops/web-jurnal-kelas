<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrestasiSiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prestasi_siswa';
    protected $primaryKey = 'id_prestasi';

    protected $fillable = [
        'id_siswa',
        'id_kelas',
        'nama_prestasi',
        'kategori',
        'tingkat',
        'peringkat',
        'tanggal_prestasi',
        'penyelenggara',
        'keterangan',
        'sertifikat_foto',
    ];

    protected $casts = [
        'tanggal_prestasi' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa')->withTrashed();
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas')->withTrashed();
    }
}
