<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalDetailKetidakhadiran extends Model
{
    protected $table      = 'jurnal_detail_ketidakhadiran';
    protected $primaryKey = 'id_detail';
    public    $timestamps = false;

    protected $fillable = [
        'id_jurnal',
        'id_siswa',
        'keterangan'
    ];

    /**
     * Relasi ke Jurnal Mengajar
     */
    public function jurnal()
    {
        return $this->belongsTo(JurnalMengajar::class, 'id_jurnal', 'id_jurnal');
    }

    /**
     * Alias relasi ke Jurnal Mengajar
     */
    public function jurnalMengajar()
    {
        return $this->belongsTo(JurnalMengajar::class, 'id_jurnal', 'id_jurnal');
    }

    /**
     * Relasi ke Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
}
