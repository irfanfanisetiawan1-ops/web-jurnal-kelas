<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengumuman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengumuman';
    protected $primaryKey = 'id_pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'kategori',
        'id_kelas',
        'jam_mengajar',
        'status',
        'keterangan',
        'id_guru',
        'tanggal',
        'deleted_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function pembuat()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    public function reads()
    {
        return $this->hasMany(PengumumanDibaca::class, 'id_pengumuman', 'id_pengumuman');
    }
}
