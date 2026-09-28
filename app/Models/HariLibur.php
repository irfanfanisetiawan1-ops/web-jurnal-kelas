<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class HariLibur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hari_libur';

    protected $fillable = [
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date:Y-m-d',
        'tanggal_selesai' => 'date:Y-m-d',
        'is_active'       => 'boolean',
    ];

    /**
     * Relasi ke user pembuat (Admin TU)
     */
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope data aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope data pada tanggal tertentu
     */
    public function scopeOnDate($query, $date)
    {
        $dateStr = $date instanceof Carbon ? $date->format('Y-m-d') : Carbon::parse($date)->format('Y-m-d');
        return $query->where('tanggal_mulai', '<=', $dateStr)
                     ->where('tanggal_selesai', '>=', $dateStr);
    }

    /**
     * Cek apakah tanggal merupakan akhir pekan (Sabtu atau Minggu)
     */
    public static function isWeekend($carbonOrDate = null): bool
    {
        $dt = $carbonOrDate instanceof Carbon
            ? $carbonOrDate->copy()->setTimezone('Asia/Jakarta')
            : ($carbonOrDate ? Carbon::parse($carbonOrDate, 'Asia/Jakarta') : Carbon::now('Asia/Jakarta'));

        return $dt->dayOfWeek === Carbon::SATURDAY || $dt->dayOfWeek === Carbon::SUNDAY;
    }

    /**
     * Dapatkan data hari libur aktif untuk tanggal tertentu
     */
    public static function getActiveHolidayForDate($carbonOrDate = null): ?self
    {
        $dt = $carbonOrDate instanceof Carbon
            ? $carbonOrDate->copy()->setTimezone('Asia/Jakarta')
            : ($carbonOrDate ? Carbon::parse($carbonOrDate, 'Asia/Jakarta') : Carbon::now('Asia/Jakarta'));

        $dateStr = $dt->format('Y-m-d');

        return self::active()
            ->where('tanggal_mulai', '<=', $dateStr)
            ->where('tanggal_selesai', '>=', $dateStr)
            ->first();
    }

    /**
     * Cek apakah tanggal merupakan hari libur (Libur Nasional/Sekolah atau Akhir Pekan)
     */
    public static function isSchoolHoliday($carbonOrDate = null): bool
    {
        if (self::isWeekend($carbonOrDate)) {
            return true;
        }

        return self::getActiveHolidayForDate($carbonOrDate) !== null;
    }

    /**
     * Cek apakah hari ini merupakan hari libur
     */
    public static function isHolidayToday(): bool
    {
        return self::isSchoolHoliday(Carbon::now('Asia/Jakarta'));
    }

    /**
     * Dapatkan ringkasan status libur hari ini / tanggal tertentu
     */
    public static function getHolidayInfoForDate($carbonOrDate = null): array
    {
        $dt = $carbonOrDate instanceof Carbon
            ? $carbonOrDate->copy()->setTimezone('Asia/Jakarta')
            : ($carbonOrDate ? Carbon::parse($carbonOrDate, 'Asia/Jakarta') : Carbon::now('Asia/Jakarta'));

        $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $namaHari = $hariIndo[$dt->dayOfWeek] ?? '';

        if (self::isWeekend($dt)) {
            return [
                'is_holiday'     => true,
                'is_weekend'     => true,
                'type'           => 'weekend',
                'title'          => 'Libur Akhir Pekan',
                'keterangan'     => "Hari {$namaHari} merupakan Libur Akhir Pekan Sekolah",
                'holiday_record' => null,
            ];
        }

        $holiday = self::getActiveHolidayForDate($dt);
        if ($holiday) {
            return [
                'is_holiday'     => true,
                'is_weekend'     => false,
                'type'           => 'holiday',
                'title'          => 'Hari Libur Sekolah',
                'keterangan'     => $holiday->keterangan,
                'holiday_record' => $holiday,
            ];
        }

        return [
            'is_holiday'     => false,
            'is_weekend'     => false,
            'type'           => 'none',
            'title'          => 'Hari Efektif KBM',
            'keterangan'     => "Kegiatan Belajar Mengajar Berlangsung Normal",
            'holiday_record' => null,
        ];
    }

    /**
     * Durasi hari libur
     */
    public function getDurasiHariAttribute(): int
    {
        if (!$this->tanggal_mulai || !$this->tanggal_selesai) {
            return 1;
        }
        $start = Carbon::parse($this->tanggal_mulai)->startOfDay();
        $end   = Carbon::parse($this->tanggal_selesai)->startOfDay();
        return $start->diffInDays($end) + 1;
    }

    /**
     * Format rentang tanggal ramah bahasa Indonesia
     */
    public function getRentangFormattedAttribute(): string
    {
        $bulanIndo = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        $start = Carbon::parse($this->tanggal_mulai);
        $end   = Carbon::parse($this->tanggal_selesai);

        $startStr = $start->day . ' ' . $bulanIndo[$start->month] . ' ' . $start->year;
        $endStr   = $end->day . ' ' . $bulanIndo[$end->month] . ' ' . $end->year;

        if ($startStr === $endStr) {
            return $startStr;
        }

        return "{$startStr} – {$endStr}";
    }

    /**
     * Cek apakah hari libur ini sedang berlangsung saat ini
     */
    public function getIsCurrentlyOngoingAttribute(): bool
    {
        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $start = Carbon::parse($this->tanggal_mulai)->format('Y-m-d');
        $end   = Carbon::parse($this->tanggal_selesai)->format('Y-m-d');

        return ($this->is_active && $today >= $start && $today <= $end);
    }
}
