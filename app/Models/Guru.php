<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use SoftDeletes;

    protected $table      = 'guru';
    protected $primaryKey = 'id_guru';
    protected $fillable   = ['nip', 'nama_guru', 'jenis_kelamin', 'id_mapel', 'no_hp', 'is_active'];
    public    $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function isActive(): bool
    {
        return (bool) ($this->is_active ?? true);
    }

    public function getJenisKelaminTeksAttribute()
    {
        if ($this->jenis_kelamin === 'L') return 'Laki-laki';
        if ($this->jenis_kelamin === 'P') return 'Perempuan';
        return '-';
    }

    /**
     * Relasi ke Mapel yang diampu oleh Guru ini
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

    /**
     * Relasi ke User account
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id_guru', 'id_guru');
    }

    /**
     * Relasi ke Kelas yang diampu sebagai Wali Kelas
     */
    public function kelasWali()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas', 'nip');
    }

    /**
     * Relasi ke Jurnal Piket
     */
    public function jurnalPikets()
    {
        return $this->hasMany(JurnalPiket::class, 'id_guru', 'id_guru');
    }

    public function penugasanAsTidakHadir()
    {
        return $this->hasMany(PenugasanGuruPengganti::class, 'id_guru_tidak_hadir', 'id_guru');
    }

    public function penugasanAsPengganti()
    {
        return $this->hasMany(PenugasanGuruPengganti::class, 'id_guru_pengganti', 'id_guru');
    }

    /**
     * Relasi ke Jadwal Mengajar Guru
     */
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_guru', 'id_guru');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_guru', 'id_guru');
    }
}
