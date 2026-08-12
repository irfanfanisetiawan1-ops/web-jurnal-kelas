<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruangan extends Model
{
    use SoftDeletes;

    protected $table      = 'ruangan';
    protected $primaryKey = 'id_ruangan';
    protected $fillable   = ['nama_ruangan', 'jenis_ruangan'];
    public    $timestamps = false;

    protected $dates = ['deleted_at'];

    /**
     * Relasi ke Jadwal yang menggunakan ruangan ini
     */
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_ruangan', 'id_ruangan');
    }
}
