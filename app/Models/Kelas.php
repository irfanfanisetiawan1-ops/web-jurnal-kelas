<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;

    protected $table      = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $fillable   = ['nama_kelas', 'id_jurusan', 'wali_kelas', 'id_ruangan', 'jumlah_siswa'];
    public    $timestamps = false;

    protected $dates = ['deleted_at'];

    /**
     * Relasi ke Jurusan
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    /**
     * Relasi ke Ruangan Utama Kelas
     */
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    /**
     * Relasi ke Guru (Wali Kelas) berdasarkan NIP
     */
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas', 'nip');
    }

    /**
     * Relasi ke Siswa yang terdaftar di kelas ini
     */
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'id_kelas', 'id_kelas');
    }

    /**
     * Mendapatkan jumlah siswa riil yang terdaftar / tersambung di kelas ini
     */
    public function getJumlahSiswaRealAttribute()
    {
        if (isset($this->attributes['siswas_count']) && $this->attributes['siswas_count'] > 0) {
            return (int) $this->attributes['siswas_count'];
        }
        if ($this->relationLoaded('siswas') && $this->siswas->count() > 0) {
            return $this->siswas->count();
        }
        return (int) ($this->attributes['jumlah_siswa'] ?? 0);
    }
}
