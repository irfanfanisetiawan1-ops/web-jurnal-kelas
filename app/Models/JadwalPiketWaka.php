<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JadwalPiketWaka extends Model
{
    use HasFactory;

    protected $table = 'jadwal_piket_waka';

    protected $fillable = [
        'tanggal',
        'hari',
        'bulan',
        'tahun',
        'id_guru',
        'id_user',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
        'bulan'   => 'integer',
        'tahun'   => 'integer',
        'id_guru' => 'integer',
        'id_user' => 'integer',
    ];

    /**
     * Relasi ke master Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    /**
     * Relasi ke User akun login guru
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Dapatkan data Piket Waka untuk tanggal tertentu
     */
    public static function getPiketWakaByDate($date = null)
    {
        $targetDate = $date ?? Carbon::today('Asia/Jakarta')->toDateString();

        return self::with(['guru', 'user'])
            ->whereDate('tanggal', $targetDate)
            ->first();
    }

    /**
     * Cek apakah user tertentu bertugas sebagai Piket Waka pada tanggal tertentu
     */
    public static function isUserPiketWaka($user, $date = null): bool
    {
        if (!$user) {
            return false;
        }

        $targetDate = $date ?? Carbon::today('Asia/Jakarta')->toDateString();
        $userId = $user->id ?? null;
        $guruId = $user->id_guru ?? ($user->guru->id_guru ?? null);

        if (!$guruId && !empty($user->nip)) {
            $guru = Guru::where('nip', $user->nip)->first();
            if ($guru) {
                $guruId = $guru->id_guru;
            }
        }

        return self::whereDate('tanggal', $targetDate)
            ->where(function ($query) use ($userId, $guruId) {
                if ($userId) {
                    $query->where('id_user', $userId);
                }
                if ($guruId) {
                    $query->orWhere('id_guru', $guruId);
                }
            })
            ->exists();
    }
}
