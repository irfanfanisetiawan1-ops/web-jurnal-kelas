<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JurnalPiket extends Model
{
    use SoftDeletes;

    protected $table      = 'jurnal_piket';
    protected $primaryKey = 'id_jurnal_piket';
    protected $fillable   = [
        'tanggal',
        'id_guru',
        'nama_petugas_piket',
        'jam_piket',
        'catatan_kejadian',
        'status_suasana',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }
}
