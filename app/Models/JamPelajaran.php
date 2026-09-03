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

    /**
     * Hitung & Dapatkan Status Jam Pelajaran Saat Ini berbasis Waktu Aktif
     */
    public static function getCurrentLessonStatus($carbonTime = null): array
    {
        $now = $carbonTime ? $carbonTime->copy()->setTimezone('Asia/Jakarta') : \Carbon\Carbon::now('Asia/Jakarta');
        $dayOfWeek = $now->dayOfWeek; // 0: Sun, 1: Mon, ..., 5: Fri, 6: Sat
        $timeStr   = $now->format('H:i:s');

        if ($dayOfWeek === 0 || $dayOfWeek === 6) {
            return [
                'status' => 'off',
                'label'  => 'Luar Jam KBM',
                'detail' => 'Libur Akhir Pekan',
                'icon'   => 'fa-moon',
                'color'  => '#64748b',
                'bg'     => '#f1f5f9',
                'border' => '#cbd5e1',
            ];
        }

        $allJam = self::orderBy('id_jam', 'asc')->get();
        $isJumat = ($dayOfWeek === 5);

        if ($timeStr < '07:00:00') {
            return [
                'status' => 'before',
                'label'  => 'Sebelum KBM',
                'detail' => 'KBM ' . ($isJumat ? 'Jumat ' : '') . 'Mulai 07:00 WIB',
                'icon'   => 'fa-clock',
                'color'  => '#0369a1',
                'bg'     => '#e0f2fe',
                'border' => '#93c5fd',
            ];
        }

        $activeSlot = null;
        $prevSlot   = null;

        foreach ($allJam as $j) {
            $start = $isJumat ? $j->jam_mulai_jumat : $j->jam_mulai;
            $end   = $isJumat ? $j->jam_selesai_jumat : $j->jam_selesai;

            if (empty($start) || empty($end) || $start === '-' || $end === '-') {
                continue;
            }

            if ($timeStr >= $start && $timeStr < $end) {
                $activeSlot = $j;
                break;
            }

            if ($timeStr >= $start) {
                $prevSlot = $j;
            }
        }

        if ($activeSlot) {
            $start = substr($isJumat ? $activeSlot->jam_mulai_jumat : $activeSlot->jam_mulai, 0, 5);
            $end   = substr($isJumat ? $activeSlot->jam_selesai_jumat : $activeSlot->jam_selesai, 0, 5);
            $label = str_starts_with($activeSlot->jam_ke, 'Jam Ke-') ? $activeSlot->jam_ke : 'Jam Ke-' . $activeSlot->jam_ke;
            return [
                'status' => 'active',
                'label'  => $label,
                'detail' => "{$start} - {$end} WIB",
                'icon'   => 'fa-clock-rotate-left',
                'color'  => '#15803d',
                'bg'     => '#dcfce7',
                'border' => '#86efac',
            ];
        }

        // Cek jika KBM sudah selesai
        $maxEnd = $isJumat ? '15:30:00' : '15:00:00';
        if ($timeStr >= $maxEnd) {
            return [
                'status' => 'after',
                'label'  => 'KBM Selesai',
                'detail' => 'Kegiatan KBM Hari Ini Selesai',
                'icon'   => 'fa-flag-checkered',
                'color'  => '#475569',
                'bg'     => '#f1f5f9',
                'border' => '#cbd5e1',
            ];
        }

        // Sesi Istirahat
        if ($isJumat) {
            if ($timeStr >= '11:20:00' && $timeStr < '13:00:00') {
                return [
                    'status' => 'break',
                    'label'  => 'Istirahat (Jumatan)',
                    'detail' => '11:20 - 13:00 WIB',
                    'icon'   => 'fa-mosque',
                    'color'  => '#b45309',
                    'bg'     => '#fef3c7',
                    'border' => '#fde68a',
                ];
            }
            if ($timeStr >= '09:30:00' && $timeStr < '09:50:00') {
                return [
                    'status' => 'break',
                    'label'  => 'Istirahat 1',
                    'detail' => '09:30 - 09:50 WIB',
                    'icon'   => 'fa-mug-hot',
                    'color'  => '#b45309',
                    'bg'     => '#fef3c7',
                    'border' => '#fde68a',
                ];
            }
        } else {
            if ($timeStr >= '11:45:00' && $timeStr < '13:15:00') {
                return [
                    'status' => 'break',
                    'label'  => 'Istirahat 2 (ISHOMA)',
                    'detail' => '11:45 - 13:15 WIB',
                    'icon'   => 'fa-utensils',
                    'color'  => '#b45309',
                    'bg'     => '#fef3c7',
                    'border' => '#fde68a',
                ];
            }
            if ($timeStr >= '09:40:00' && $timeStr < '10:00:00') {
                return [
                    'status' => 'break',
                    'label'  => 'Istirahat 1',
                    'detail' => '09:40 - 10:00 WIB',
                    'icon'   => 'fa-mug-hot',
                    'color'  => '#b45309',
                    'bg'     => '#fef3c7',
                    'border' => '#fde68a',
                ];
            }
        }

        return [
            'status' => 'break',
            'label'  => 'Sesi Istirahat',
            'detail' => 'Sesi Istirahat KBM',
            'icon'   => 'fa-mug-hot',
            'color'  => '#b45309',
            'bg'     => '#fef3c7',
            'border' => '#fde68a',
        ];
    }
}
