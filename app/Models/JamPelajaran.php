<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JamPelajaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'jam_pelajaran';
    protected $primaryKey = 'id_jam';

    protected $fillable = [
        'jam_ke',
        'jam_mulai',
        'jam_selesai',
        'jam_mulai_jumat',
        'jam_selesai_jumat',
        'keterangan',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_jam_mulai', 'id_jam');
    }

    public function getJadwalsActiveAttribute()
    {
        return Jadwal::where('id_jam_mulai', '<=', $this->id_jam)
            ->where('id_jam_selesai', '>=', $this->id_jam)
            ->with(['kelas', 'mapel', 'guru', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->get();
    }

    /**
     * Waktu Belajar Senin - Kamis (1 Jam = 40 Menit)
     */
    public function getWaktuSeninKamisAttribute()
    {
        if ($this->jam_mulai && $this->jam_selesai) {
            return substr($this->jam_mulai, 0, 5) . ' - ' . substr($this->jam_selesai, 0, 5);
        }
        return '-';
    }

    /**
     * Waktu Belajar Hari Jumat (1 Jam = 30 Menit)
     */
    public function getWaktuJumatAttribute()
    {
        if ($this->jam_mulai_jumat && $this->jam_selesai_jumat) {
            return substr($this->jam_mulai_jumat, 0, 5) . ' - ' . substr($this->jam_selesai_jumat, 0, 5);
        }
        return '-';
    }

    public function getRangeFormatAttribute()
    {
        $seninKamis = $this->waktu_senin_kamis;
        $jumat      = $this->waktu_jumat;

        if ($seninKamis !== '-') {
            return "Senin-Kamis: {$seninKamis} | Jumat: {$jumat}";
        }
        return "Jumat: {$jumat}";
    }
}
