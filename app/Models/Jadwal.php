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
     * Accessor: Nomor jam ke- mulai (integer)
     */
    public function getJamMulaiKeAttribute()
    {
        if ($this->jamMulai) {
            $num = (int) preg_replace('/\D/', '', $this->jamMulai->jam_ke);
            return $num ?: (int) $this->id_jam_mulai;
        }
        return (int) ($this->id_jam_mulai ?? 1);
    }

    /**
     * Accessor: Nomor jam ke- selesai (integer)
     */
    public function getJamSelesaiKeAttribute()
    {
        if ($this->jamSelesai) {
            $num = (int) preg_replace('/\D/', '', $this->jamSelesai->jam_ke);
            return $num ?: (int) $this->id_jam_selesai;
        }
        return (int) ($this->id_jam_selesai ?? $this->id_jam_mulai ?? 1);
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

    /**
     * Dapatkan jumlah JP (Jam Pelajaran) yang dialokasikan pada jadwal ini
     */
    public function getJumlahJpAttribute()
    {
        $mulai = (int) ($this->id_jam_mulai ?? 1);
        $selesai = (int) ($this->id_jam_selesai ?? $mulai);
        return max(1, ($selesai - $mulai + 1));
    }

    /**
     * Dapatkan waktu mulai efektif (HH:MM)
     */
    public function getWaktuMulaiEffectiveAttribute()
    {
        $time = $this->jam_mulai_time;
        if ($time) return $time;

        $isJumat = strtolower(trim($this->hari ?? '')) === 'jumat';
        
        if ($isJumat) {
            $jamTimesJumat = [
                1 => '07:00', 2 => '07:30', 3 => '08:00', 4 => '08:30', 5 => '09:00',
                6 => '09:50', 7 => '10:20', 8 => '10:50', 9 => '13:00', 10 => '13:30',
                11 => '14:00', 12 => '14:30', 13 => '15:00',
            ];
            return $jamTimesJumat[$this->id_jam_mulai] ?? '07:00';
        }

        $jamTimes = [
            1 => '07:00', 2 => '07:40', 3 => '08:20',
            4 => '09:00', 5 => '10:00', 6 => '10:35',
            7 => '11:10', 8 => '13:15', 9 => '13:50', 10 => '14:25',
        ];
        return $jamTimes[$this->id_jam_mulai] ?? '07:00';
    }

    /**
     * Dapatkan waktu selesai efektif (HH:MM)
     */
    public function getWaktuSelesaiEffectiveAttribute()
    {
        $time = $this->jam_selesai_time;
        if ($time) return $time;

        $isJumat = strtolower(trim($this->hari ?? '')) === 'jumat';
        $idx = $this->id_jam_selesai ?? $this->id_jam_mulai;

        if ($isJumat) {
            $jamTimesJumat = [
                1 => '07:30', 2 => '08:00', 3 => '08:30', 4 => '09:00', 5 => '09:30',
                6 => '10:20', 7 => '10:50', 8 => '11:20', 9 => '13:30', 10 => '14:00',
                11 => '14:30', 12 => '15:00', 13 => '15:35',
            ];
            return $jamTimesJumat[$idx] ?? '15:35';
        }

        $jamTimes = [
            1 => '07:40', 2 => '08:20', 3 => '09:00',
            4 => '09:40', 5 => '10:35', 6 => '11:10',
            7 => '11:45', 8 => '13:50', 9 => '14:25', 10 => '15:00',
        ];
        return $jamTimes[$idx] ?? '15:00';
    }

    /**
     * Cek apakah jadwal ini sudah memasuki jam pelajaran pada hari ini
     */
    public function getSudahMasukJamAttribute()
    {
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $currentTimeStr = $now->format('H:i');
        
        $daysInIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $todayIndo = $daysInIndo[$now->format('l')] ?? '';
        
        // Jika hari jadwal tidak sama dengan hari ini, maka belum jam-nya
        if (strtolower(trim($this->hari ?? '')) !== strtolower(trim($todayIndo))) {
            return false;
        }

        return $currentTimeStr >= $this->waktu_mulai_effective;
    }

    /**
     * Cek apakah jurnal untuk jadwal ini sudah diisi hari ini
     */
    public function isDiisiHariIni()
    {
        $today = \Carbon\Carbon::today('Asia/Jakarta')->toDateString();
        return $this->isDiisiPadaTanggal($today);
    }

    /**
     * Cek apakah jurnal untuk jadwal ini sudah diisi pada tanggal tertentu
     */
    public function isDiisiPadaTanggal($tanggal)
    {
        return \App\Models\JurnalMengajar::where('id_jadwal', $this->id_jadwal)
            ->whereDate('tanggal', $tanggal)
            ->exists();
    }

    /**
     * Dapatkan catatan jurnal pada tanggal tertentu (jika ada)
     */
    public function getJurnalPadaTanggal($tanggal)
    {
        return \App\Models\JurnalMengajar::with('detailKetidakhadiran.siswa')
            ->where('id_jadwal', $this->id_jadwal)
            ->whereDate('tanggal', $tanggal)
            ->first();
    }

    /**
     * Hitung sisa menit sampai jam pelajaran berakhir hari ini
     */
    public function getSisaMenitSelesaiAttribute()
    {
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $daysInIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $todayIndo = $daysInIndo[$now->format('l')] ?? '';
        
        // Jika jadwal bukan untuk hari ini, sisa menit = 0
        if (strtolower(trim($this->hari ?? '')) !== strtolower(trim($todayIndo))) {
            return 0;
        }

        $selesaiStr = $this->waktu_selesai_effective;

        try {
            $selesaiTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $now->toDateString() . ' ' . $selesaiStr, 'Asia/Jakarta');
            $diffSeconds = $now->diffInSeconds($selesaiTime, false);
            if ($diffSeconds <= 0) return 0;
            return (int) ceil($diffSeconds / 60);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Peringatan 5 menit sebelum jam selesai dan jurnal belum diisi
     */
    public function getHampirHabisAttribute()
    {
        // Peringatan 5 menit hanya aktif jika:
        // 1. Hari ini dan jam pelajaran SEDANG BERLANGSUNG
        // 2. Jurnal belum diisi hari ini
        // 3. Sisa waktu antara 1 s/d 5 menit
        if (!$this->is_sedang_berlangsung) {
            return false;
        }
        if ($this->isDiisiHariIni()) {
            return false;
        }
        $sisa = $this->sisa_menit_selesai;
        return ($sisa > 0 && $sisa <= 5);
    }

    /**
     * Cek apakah jam pelajaran jadwal ini SEDANG BERLANGSUNG hari ini
     */
    public function getIsSedangBerlangsungAttribute()
    {
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $currentTimeStr = $now->format('H:i');
        
        $daysInIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $todayIndo = $daysInIndo[$now->format('l')] ?? '';
        
        if (strtolower(trim($this->hari ?? '')) !== strtolower(trim($todayIndo))) {
            return false;
        }

        return ($currentTimeStr >= $this->waktu_mulai_effective && $currentTimeStr < $this->waktu_selesai_effective);
    }

    /**
     * Cek apakah jam pelajaran jadwal ini SUDAH BERAKHIR/HABIS hari ini
     */
    public function getIsJamSudahSelesaiAttribute()
    {
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $currentTimeStr = $now->format('H:i');
        
        $daysInIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $todayIndo = $daysInIndo[$now->format('l')] ?? '';
        
        // Hanya berlaku untuk jadwal yang jatuh pada hari ini
        if (strtolower(trim($this->hari ?? '')) !== strtolower(trim($todayIndo))) {
            return false;
        }

        return ($currentTimeStr >= $this->waktu_selesai_effective);
    }

    /**
     * Helper cek status jam pelajaran untuk tanggal tertentu
     */
    public function isJamSudahSelesaiPadaTanggal($tanggal = null)
    {
        $today = \Carbon\Carbon::today('Asia/Jakarta')->toDateString();
        $target = $tanggal ?? $today;
        
        if ($target < $today) {
            return true; // Hari kemarin sudah pasti berakhir
        }
        if ($target > $today) {
            return false; // Hari esok belum dimulai
        }
        return $this->is_jam_sudah_selesai;
    }

    /**
     * Relasi ke Jurnal Mengajar
     */
    public function jurnalMengajars()
    {
        return $this->hasMany(JurnalMengajar::class, 'id_jadwal', 'id_jadwal');
    }

    /**
     * Dapatkan catatan jurnal hari ini (jika ada)
     */
    public function getJurnalHariIniAttribute()
    {
        $today = \Carbon\Carbon::today('Asia/Jakarta')->toDateString();
        return \App\Models\JurnalMengajar::with('detailKetidakhadiran.siswa')
            ->where('id_jadwal', $this->id_jadwal)
            ->where('tanggal', $today)
            ->first();
    }
}

