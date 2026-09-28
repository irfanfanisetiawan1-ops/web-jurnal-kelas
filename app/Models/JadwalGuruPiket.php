<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JadwalGuruPiket extends Model
{
    use HasFactory;

    protected $table = 'jadwal_guru_piket';

    protected $fillable = [
        'tanggal',
        'hari',
        'bulan',
        'tahun',
        'slot_ke',
        'id_guru',
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
        'bulan'   => 'integer',
        'tahun'   => 'integer',
        'slot_ke' => 'integer',
        'id_guru' => 'integer',
    ];

    /**
     * Relasi ke model Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    /**
     * Cek apakah guru tertentu terjadwal piket pada tanggal tertentu (default hari ini)
     */
    public static function isGuruPiketHariIni($guruId, $date = null): bool
    {
        if (!$guruId) {
            return false;
        }

        $targetDate = $date ?? Carbon::today('Asia/Jakarta')->toDateString();

        return self::whereDate('tanggal', $targetDate)
            ->where('id_guru', $guruId)
            ->exists();
    }

    /**
     * Cek apakah user (berdasarkan nip atau id_guru) terjadwal piket hari ini
     */
    public static function isUserPiketHariIni($user, $date = null): bool
    {
        if (!$user) {
            return false;
        }

        $targetDate = $date ?? Carbon::today('Asia/Jakarta')->toDateString();

        $guruId = $user->id_guru;
        if (!$guruId && !empty($user->nip)) {
            $guru = Guru::where('nip', $user->nip)->first();
            if ($guru) {
                $guruId = $guru->id_guru;
            }
        }
        if (!$guruId && $user->guru) {
            $guruId = $user->guru->id_guru;
        }

        if ($guruId) {
            return self::whereDate('tanggal', $targetDate)
                ->where('id_guru', $guruId)
                ->exists();
        }

        return false;
    }

    /**
     * Dapatkan informasi detail slot penugasan guru piket pada tanggal tertentu
     */
    public static function getSlotPiketHariIni($user, $date = null): array
    {
        $default = [
            'slot_ke'     => 1,
            'slot_label'  => 'Piket 1',
            'sesi'        => 'Pagi',
            'waktu_label' => '07.00 - 11.00 WIB',
            'badge_text'  => 'Terjadwal Hari Ini: P1 (07.00 - 15.00 WIB)',
        ];

        if (!$user) {
            return $default;
        }

        $targetDate = $date ?? Carbon::today('Asia/Jakarta')->toDateString();

        $guruId = $user->id_guru;
        if (!$guruId && !empty($user->nip)) {
            $guru = Guru::where('nip', $user->nip)->first();
            if ($guru) {
                $guruId = $guru->id_guru;
            }
        }
        if (!$guruId && $user->guru) {
            $guruId = $user->guru->id_guru;
        }

        if (!$guruId) {
            return $default;
        }

        $piketRecord = self::whereDate('tanggal', $targetDate)
            ->where('id_guru', $guruId)
            ->orderBy('slot_ke', 'asc')
            ->first();

        if (!$piketRecord) {
            return $default;
        }

        $slot = (int) $piketRecord->slot_ke;
        $slotNames = [
            1 => ['name' => 'Piket 1', 'sesi' => 'Pagi', 'waktu' => '07.00 - 11.00 WIB'],
            2 => ['name' => 'Piket 2', 'sesi' => 'Pagi', 'waktu' => '07.00 - 11.00 WIB'],
            3 => ['name' => 'Piket 3', 'sesi' => 'Pagi', 'waktu' => '07.00 - 11.00 WIB'],
            4 => ['name' => 'Koord. Pagi', 'sesi' => 'Pagi', 'waktu' => '07.00 - 11.00 WIB'],
            5 => ['name' => 'Piket 4', 'sesi' => 'Siang', 'waktu' => '11.00 - 15.00 WIB'],
            6 => ['name' => 'Piket 5', 'sesi' => 'Siang', 'waktu' => '11.00 - 15.00 WIB'],
            7 => ['name' => 'Piket 6', 'sesi' => 'Siang', 'waktu' => '11.00 - 15.00 WIB'],
            8 => ['name' => 'Koord. Siang', 'sesi' => 'Siang', 'waktu' => '11.00 - 15.00 WIB'],
        ];

        $info = $slotNames[$slot] ?? ['name' => "Piket {$slot}", 'sesi' => 'Harian', 'waktu' => '07.00 - 15.00 WIB'];

        return [
            'slot_ke'     => $slot,
            'slot_label'  => $info['name'],
            'sesi'        => $info['sesi'],
            'waktu_label' => $info['waktu'],
            'badge_text'  => "Terjadwal Hari Ini: {$info['name']} ({$info['waktu']})",
        ];
    }

    /**
     * Ambil seluruh data penugasan piket pada tanggal tertentu
     */
    public static function getGuruPiketHariIni($date = null)
    {
        $targetDate = $date ?? Carbon::today('Asia/Jakarta')->toDateString();

        return self::with('guru.mapel')
            ->whereDate('tanggal', $targetDate)
            ->whereNotNull('id_guru')
            ->orderBy('slot_ke', 'asc')
            ->get();
    }

    /**
     * Ambil jadwal satu bulan dan kelompokkan berdasarkan tanggal: [tanggal][slot_ke] = id_guru
     */
    public static function getJadwalBulan($bulan, $tahun)
    {
        $records = self::with('guru')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        $matrix = [];
        foreach ($records as $row) {
            $tglKey = Carbon::parse($row->tanggal)->format('Y-m-d');
            $matrix[$tglKey][$row->slot_ke] = [
                'id_guru'   => $row->id_guru,
                'nama_guru' => $row->guru->nama_guru ?? null,
                'nip'       => $row->guru->nip ?? null,
            ];
        }

        return $matrix;
    }
}
