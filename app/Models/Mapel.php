<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapel extends Model
{
    use SoftDeletes;

    protected $table      = 'mapel';
    protected $primaryKey = 'id_mapel';
    protected $fillable   = ['kode_mapel', 'nama_mapel'];
    public    $timestamps = false;

    protected $dates = ['deleted_at'];

    /**
     * Relasi ke Guru yang mengampu mata pelajaran ini (diambil dari Jadwal mengajar)
     */
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'jadwal', 'id_mapel', 'id_guru')
                    ->distinct()
                    ->whereNull('jadwal.deleted_at');
    }

    /**
     * Relasi ke Jadwal
     */
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_mapel', 'id_mapel');
    }
}
