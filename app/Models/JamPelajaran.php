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
        'jam_mulai_default',
        'jam_selesai_default',
        'is_active_senin_kamis',
        'jam_mulai_jumat',
        'jam_selesai_jumat',
        'jam_mulai_jumat_default',
        'jam_selesai_jumat_default',
        'is_active_jumat',
        'keterangan',
    ];

    protected $casts = [
        'is_active_senin_kamis' => 'boolean',
        'is_active_jumat'       => 'boolean',
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
     * Waktu Default Senin - Kamis
     */
    public function getWaktuSeninKamisDefaultAttribute()
    {
        if ($this->jam_mulai_default && $this->jam_selesai_default) {
            return substr($this->jam_mulai_default, 0, 5) . ' - ' . substr($this->jam_selesai_default, 0, 5);
        }
        return '-';
    }

    /**
     * Waktu Default Hari Jumat
     */
    public function getWaktuJumatDefaultAttribute()
    {
        if ($this->jam_mulai_jumat_default && $this->jam_selesai_jumat_default) {
            return substr($this->jam_mulai_jumat_default, 0, 5) . ' - ' . substr($this->jam_selesai_jumat_default, 0, 5);
        }
        return '-';
    }

    /**
     * Cek apakah jam pelajaran Senin-Kamis sedang maju dari jadwal defaultnya
     */
    public function getIsShiftedSeninKamisAttribute(): bool
    {
        if (!$this->is_active_senin_kamis || empty($this->jam_mulai) || empty($this->jam_mulai_default)) {
            return false;
        }
        return substr($this->jam_mulai, 0, 5) !== substr($this->jam_mulai_default, 0, 5);
    }

    /**
     * Cek apakah jam pelajaran Jumat sedang maju dari jadwal defaultnya
     */
    public function getIsShiftedJumatAttribute(): bool
    {
        if (!$this->is_active_jumat || empty($this->jam_mulai_jumat) || empty($this->jam_mulai_jumat_default)) {
            return false;
        }
        return substr($this->jam_mulai_jumat, 0, 5) !== substr($this->jam_mulai_jumat_default, 0, 5);
    }

    /**
     * Hitung Ulang dan Geser (Maju) Jam Pelajaran Berdasarkan Sesi Aktif
     *
     * @param string|null $dayType 'senin_kamis', 'jumat', atau null untuk keduanya
     */
    public static function recalculateSchedules(?string $dayType = null): void
    {
        // 1. Hitung ulang Senin - Kamis
        if ($dayType === null || $dayType === 'senin_kamis') {
            $allSK = self::whereNotNull('jam_mulai_default')->orderBy('id_jam', 'asc')->get();

            // Kumpulkan slot waktu default berurutan
            $availableSlotsSK = [];
            foreach ($allSK as $item) {
                if ($item->jam_mulai_default && $item->jam_selesai_default) {
                    $availableSlotsSK[] = [
                        'mulai'   => $item->jam_mulai_default,
                        'selesai' => $item->jam_selesai_default,
                    ];
                }
            }

            // Tetapkan slot secara berurutan ke setiap sesi yang aktif
            $slotIdx = 0;
            foreach ($allSK as $item) {
                if ($item->is_active_senin_kamis) {
                    if (isset($availableSlotsSK[$slotIdx])) {
                        $item->jam_mulai   = $availableSlotsSK[$slotIdx]['mulai'];
                        $item->jam_selesai = $availableSlotsSK[$slotIdx]['selesai'];
                        $slotIdx++;
                    } else {
                        $item->jam_mulai   = null;
                        $item->jam_selesai = null;
                    }
                } else {
                    // Nonaktif: waktu dikosongkan (dilewati sehingga sesi berikutnya maju)
                    $item->jam_mulai   = null;
                    $item->jam_selesai = null;
                }
                $item->save();
            }
        }

        // 2. Hitung ulang Hari Jumat
        if ($dayType === null || $dayType === 'jumat') {
            $allFri = self::whereNotNull('jam_mulai_jumat_default')->orderBy('id_jam', 'asc')->get();

            // Kumpulkan slot waktu default Jumat berurutan
            $availableSlotsFri = [];
            foreach ($allFri as $item) {
                if ($item->jam_mulai_jumat_default && $item->jam_selesai_jumat_default) {
                    $availableSlotsFri[] = [
                        'mulai'   => $item->jam_mulai_jumat_default,
                        'selesai' => $item->jam_selesai_jumat_default,
                    ];
                }
            }

            // Tetapkan slot secara berurutan ke setiap sesi Jumat yang aktif
            $slotIdx = 0;
            foreach ($allFri as $item) {
                if ($item->is_active_jumat) {
                    if (isset($availableSlotsFri[$slotIdx])) {
                        $item->jam_mulai_jumat   = $availableSlotsFri[$slotIdx]['mulai'];
                        $item->jam_selesai_jumat = $availableSlotsFri[$slotIdx]['selesai'];
                        $slotIdx++;
                    } else {
                        $item->jam_mulai_jumat   = null;
                        $item->jam_selesai_jumat = null;
                    }
                } else {
                    // Nonaktif: waktu dikosongkan (dilewati sehingga sesi berikutnya maju)
                    $item->jam_mulai_jumat   = null;
                    $item->jam_selesai_jumat = null;
                }
                $item->save();
            }
        }
    }

    /**
     * Kembalikan Semua Sesi ke Jadwal Normal / Standar
     */
    public static function resetToDefault(?string $dayType = null): void
    {
        if ($dayType === null || $dayType === 'senin_kamis') {
            self::whereNotNull('jam_mulai_default')->update([
                'is_active_senin_kamis' => 1,
            ]);
        }

        if ($dayType === null || $dayType === 'jumat') {
            self::whereNotNull('jam_mulai_jumat_default')->update([
                'is_active_jumat' => 1,
            ]);
        }

        self::recalculateSchedules($dayType);
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

        // Cek Hari Libur Sekolah / Nasional yang sedang aktif
        $activeHoliday = null;
        try {
            $activeHoliday = \App\Models\HariLibur::getActiveHolidayForDate($now);
        } catch (\Throwable $e) {
            $activeHoliday = null;
        }

        if ($activeHoliday) {
            return [
                'status' => 'off',
                'label'  => 'Luar Jam KBM',
                'detail' => 'Libur: ' . $activeHoliday->keterangan,
                'icon'   => 'fa-calendar-xmark',
                'color'  => '#e11d48',
                'bg'     => '#ffe4e6',
                'border' => '#fecdd3',
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
