<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use SoftDeletes;

    protected $table      = 'jurusan';
    protected $primaryKey = 'id_jurusan';
    protected $fillable   = ['kode_jurusan', 'nama_jurusan'];
    public    $timestamps = false;

    protected $dates = ['deleted_at'];

    /**
     * Relasi ke Kelas
     */
    public function kelases()
    {
        return $this->hasMany(Kelas::class, 'id_jurusan', 'id_jurusan');
    }
}
