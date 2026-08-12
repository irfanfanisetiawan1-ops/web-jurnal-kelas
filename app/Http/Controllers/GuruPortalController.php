<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\JurnalMengajar;
use App\Models\JurnalDetailKetidakhadiran;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Guru;
use Carbon\Carbon;

class GuruPortalController extends Controller
{
    /**
     * Dashboard Guru - Jadwal Mengajar Hari Ini
     */
    public function dashboard()
    {
        $daysInIndonesian = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        $todayEnglish = Carbon::now()->format('l');
        $hariIni = $daysInIndonesian[$todayEnglish] ?? 'Jumat';

        $user = Auth::user();

        // If Piket, get schedule for ALL classes today!
        if ($user && $user->isGuruPiket()) {
            $jadwals = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamPelajaran'])
                ->where('hari', $hariIni)
                ->get();

            if ($jadwals->isEmpty()) {
                $jadwals = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamPelajaran'])
                    ->whereIn('hari', ['Jumat', 'Senin'])
                    ->get();
            }

            return view('guru.dashboard', compact('hariIni', 'jadwals'));
        }

        // For regular Guru, get schedule for logged-in teacher
        $query = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamPelajaran'])
            ->where('hari', $hariIni);

        if ($user && $user->id_guru) {
            $query->where('id_guru', $user->id_guru);
        }

        $jadwals = $query->get();

        if ($jadwals->isEmpty()) {
            $jadwals = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamPelajaran'])
                ->whereIn('hari', ['Jumat', 'Senin'])
                ->limit(5)
                ->get();
        }

        return view('guru.dashboard', compact('hariIni', 'jadwals'));
    }

    /**
     * Riwayat Jurnal Guru
     */
    public function riwayatJurnal()
    {
        $user = Auth::user();
        
        $query = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.mapel',
            'jadwal.guru',
            'jadwal.ruangan'
        ])->orderBy('tanggal', 'desc');

        if ($user && $user->id_guru) {
            $query->whereHas('jadwal', function($q) use ($user) {
                $q->where('id_guru', $user->id_guru);
            });
        }

        $jurnals = $query->limit(20)->get();

        return view('guru.riwayat_jurnal', compact('jurnals'));
    }

    /**
     * Kehadiran Kelas (WALI)
     */
    public function kehadiranKelas(Request $request)
    {
        $user = Auth::user();
        $alasan = $request->input('alasan');
        $bulan  = $request->input('bulan');

        // Determine class managed by Wali Kelas
        $kelasWali = null;
        if ($user) {
            if ($user->id_guru) {
                $guru = Guru::find($user->id_guru);
                if ($guru) {
                    $kelasWali = Kelas::where('wali_kelas', $guru->nip)->first();
                }
            }

            if (!$kelasWali && $user->nip) {
                $kelasWali = Kelas::where('wali_kelas', $user->nip)->first();
            }
        }

        // Fallback to XI RPL 1 if no assigned class found
        if (!$kelasWali) {
            $kelasWali = Kelas::where('nama_kelas', 'like', '%XI RPL 1%')->first() 
                ?? Kelas::first();
        }

        $namaKelas = $kelasWali ? $kelasWali->nama_kelas : 'XI RPL 1';
        $idKelas   = $kelasWali ? $kelasWali->id_kelas : null;

        // Query students in this class
        $siswas = Siswa::where('id_kelas', $idKelas)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        // Calculate absence totals per student
        $rekapSiswa = [];
        foreach ($siswas as $siswa) {
            $absences = JurnalDetailKetidakhadiran::where('id_siswa', $siswa->id_siswa);

            if ($bulan) {
                $absences->whereHas('jurnal', function($q) use ($bulan) {
                    $q->whereMonth('tanggal', $bulan);
                });
            }

            $list = $absences->get();

            $sakit = $list->where('keterangan', 'Sakit')->count();
            $izin  = $list->where('keterangan', 'Izin')->count();
            $alpa  = $list->whereIn('keterangan', ['Alpa', 'Tanpa Keterangan'])->count();

            $rekapSiswa[] = [
                'siswa' => $siswa,
                'sakit' => $sakit,
                'izin'  => $izin,
                'alpa'  => $alpa,
                'total' => $sakit + $izin + $alpa,
            ];
        }

        // Detailed list of absences
        $detailQuery = JurnalDetailKetidakhadiran::with([
            'siswa',
            'jurnal.jadwal.mapel',
            'jurnal.jadwal.guru'
        ])->whereHas('siswa', function($q) use ($idKelas) {
            $q->where('id_kelas', $idKelas);
        });

        if ($alasan) {
            $detailQuery->where('keterangan', $alasan);
        }

        if ($bulan) {
            $detailQuery->whereHas('jurnal', function($q) use ($bulan) {
                $q->whereMonth('tanggal', $bulan);
            });
        }

        $rincianAbsen = $detailQuery->orderBy('id_detail', 'desc')->get();

        return view('guru.kehadiran_kelas', compact(
            'namaKelas',
            'siswas',
            'rekapSiswa',
            'rincianAbsen',
            'alasan',
            'bulan'
        ));
    }
}
