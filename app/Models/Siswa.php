<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use SoftDeletes;

    protected $table      = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $fillable   = ['nis', 'nisn', 'nama_siswa', 'jenis_kelamin', 'id_kelas', 'kota_lahir', 'tanggal_lahir', 'alamat_lengkap'];
    public    $timestamps = false;

    // Beritahu Laravel kolom soft delete di tabel ini
    protected $dates = ['deleted_at'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function getJenisKelaminTeksAttribute()
    {
        if ($this->jenis_kelamin === 'L') return 'Laki-laki';
        if ($this->jenis_kelamin === 'P') return 'Perempuan';
        return '-';
    }
}
