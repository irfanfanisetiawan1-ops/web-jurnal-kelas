<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
    use SoftDeletes;

    protected $table      = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $fillable   = ['id_kelas', 'id_guru', 'id_mapel', 'id_ruangan', 'id_jam', 'hari', 'id_jam_mulai', 'id_jam_selesai'];
    public    $timestamps = false;

    protected $dates = ['deleted_at'];

    public function jamPelajaran()
    {
        return $this->belongsTo(JamPelajaran::class, 'id_jam', 'id_jam');
    }

    public function jamMulai()
    {
        return $this->belongsTo(JamPelajaran::class, 'id_jam_mulai', 'id_jam');
    }

    public function jamSelesai()
    {
        return $this->belongsTo(JamPelajaran::class, 'id_jam_selesai', 'id_jam');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas')->withTrashed();
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru')->withTrashed();
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel')->withTrashed();
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan')->withTrashed();
    }

    /**
     * Accessor: Format jam mulai (nomor jam ke-) untuk ditampilkan
     */
    public function getJamMulaiFormattedAttribute()
    {
        return $this->id_jam_mulai;
    }

    /**
     * Accessor: Format jam selesai (nomor jam ke-) untuk ditampilkan
     */
    public function getJamSelesaiFormattedAttribute()
    {
        return $this->id_jam_selesai;
    }

    /**
     * Accessor: Display range jam (e.g. "2 - 5" or "1 - 3")
     */
    public function getJamRangeAttribute()
    {
        if ($this->jamMulai && $this->jamSelesai) {
            $lblMulai   = str_ireplace('Jam Ke-', '', $this->jamMulai->jam_ke);
            $lblSelesai = str_ireplace('Jam Ke-', '', $this->jamSelesai->jam_ke);
            if ($lblMulai === $lblSelesai) {
                return $lblMulai;
            }
            return "{$lblMulai} - {$lblSelesai}";
        }

        if ($this->id_jam_mulai && $this->id_jam_selesai) {
            if ($this->id_jam_mulai == $this->id_jam_selesai) {
                return (string) $this->id_jam_mulai;
            }
            return "{$this->id_jam_mulai} - {$this->id_jam_selesai}";
        }
        return (string) ($this->id_jam_mulai ?? '-');
    }

    /**
     * Accessor: Jam Mulai Time String (e.g. "07:00")
     */
    public function getJamMulaiTimeAttribute()
    {
        if (!$this->jamMulai) return null;
        $isJumat = strtolower(trim($this->hari ?? '')) === 'jumat';
        $time = $isJumat ? $this->jamMulai->jam_mulai_jumat : $this->jamMulai->jam_mulai;
        return $time ? substr($time, 0, 5) : null;
    }

    /**
     * Accessor: Jam Selesai Time String (e.g. "08:20")
     */
    public function getJamSelesaiTimeAttribute()
    {
        if (!$this->jamSelesai) return null;
        $isJumat = strtolower(trim($this->hari ?? '')) === 'jumat';
        $time = $isJumat ? $this->jamSelesai->jam_selesai_jumat : $this->jamSelesai->jam_selesai;
        return $time ? substr($time, 0, 5) : null;
    }

    /**
     * Accessor: Time range from master jam_pelajaran (e.g. "07:00 - 09:15 WIB")
     */
    public function getWaktuRangeAttribute()
    {
        $mulai   = $this->jam_mulai_time;
        $selesai = $this->jam_selesai_time;

        if ($mulai && $selesai) {
            return "{$mulai} - {$selesai} WIB";
        }
        return '-';
    }

    /**
     * Accessor: Full range display (e.g. "Jam ke-1 s/d ke-3 (07:00 - 09:15 WIB)")
     */
    public function getJamRangeFormattedAttribute()
    {
        $label = $this->jam_range;
        $waktu = $this->waktu_range;
        if ($waktu !== '-') {
            return "Jam ke-{$label} ({$waktu})";
        }
        return "Jam ke-{$label}";
    }
}

