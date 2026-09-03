<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenugasanGuruPengganti extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penugasan_guru_pengganti';
    protected $primaryKey = 'id_penugasan';

    protected $fillable = [
        'tanggal',
        'id_jadwal',
        'id_guru_tidak_hadir',
        'id_guru_pengganti',
        'id_kelas',
        'jam_pelajaran',
        'catatan',
        'materi_dititipkan',
        'tugas_dititipkan',
        'file_tugas',
        'status',
        'id_petugas_piket',
    ];

    public function guruTidakHadir()
    {
        return $this->belongsTo(Guru::class, 'id_guru_tidak_hadir', 'id_guru');
    }

    public function guruPengganti()
    {
        return $this->belongsTo(Guru::class, 'id_guru_pengganti', 'id_guru');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    /**
     * Waktu mulai efektif (HH:MM)
     */
    public function getWaktuMulaiEffectiveAttribute()
    {
        if ($this->jadwal) {
            return $this->jadwal->waktu_mulai_effective;
        }
        if (preg_match('/(\d{1,2})[:.](\d{2})/', $this->jam_pelajaran ?? '', $m)) {
            return sprintf('%02d:%02d', $m[1], $m[2]);
        }
        return '07:00';
    }

    /**
     * Waktu selesai efektif (HH:MM)
     */
    public function getWaktuSelesaiEffectiveAttribute()
    {
        if ($this->jadwal) {
            return $this->jadwal->waktu_selesai_effective;
        }
        if (preg_match('/-\s*(\d{1,2})[:.](\d{2})/', $this->jam_pelajaran ?? '', $m)) {
            return sprintf('%02d:%02d', $m[1], $m[2]);
        }
        return '15:30';
    }

    /**
     * Cek apakah sudah memasuki jam pelajaran pada hari ini
     */
    public function getSudahMasukJamAttribute()
    {
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $todayStr = $now->toDateString();
        $currentTimeStr = $now->format('H:i');

        // Jika penugasan bukan untuk hari ini (misal demo/penugasan tanggal lain), loloskan
        if ($this->tanggal && $this->tanggal !== $todayStr) {
            return true;
        }

        return $currentTimeStr >= $this->waktu_mulai_effective;
    }

    /**
     * Hitung sisa menit sampai jam pelajaran berakhir
     */
    public function getSisaMenitSelesaiAttribute()
    {
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $selesaiStr = $this->waktu_selesai_effective;

        try {
            $selesaiTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $now->toDateString() . ' ' . $selesaiStr, 'Asia/Jakarta');
            return $now->diffInMinutes($selesaiTime, false);
        } catch (\Exception $e) {
            return 60;
        }
    }

    /**
     * Deteksi kondisi peringatan 5 menit sebelum jam selesai dan jurnal belum diisi
     */
    public function getHampirHabisAttribute()
    {
        if (!$this->sudah_masuk_jam) {
            return false;
        }
        if ($this->is_diisi_hari_ini) {
            return false;
        }
        $sisa = $this->sisa_menit_selesai;
        // Peringatan aktif jika sisa menit antara 0 s/d 5 menit (atau jika jam sudah lewat sedikit tapi jurnal belum diisi)
        return $sisa <= 5;
    }

    /**
     * Cek apakah jurnal sudah diisi untuk penugasan ini
     */
    public function getIsDiisiHariIniAttribute()
    {
        $query = \App\Models\JurnalMengajar::whereDate('tanggal', $this->tanggal);

        if ($this->id_jadwal) {
            $query->where('id_jadwal', $this->id_jadwal);
        } else {
            $query->where('id_guru_pengganti', $this->id_guru_pengganti)
                  ->whereHas('jadwal', function($q) {
                      $q->where('id_kelas', $this->id_kelas);
                  });
        }

        return $query->exists();
    }
}
