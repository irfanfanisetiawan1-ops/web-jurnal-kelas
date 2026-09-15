<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\JurnalMengajar;
use App\Models\GuruIzin;
use App\Models\PenugasanGuruPengganti;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Pengumuman;
use App\Models\JamPelajaran;
use App\Models\SiswaDispen;
use App\Models\SiswaSuratIzin;
use App\Models\SiswaTelat;
use App\Models\JurnalDetailKetidakhadiran;
use App\Models\VerifikasiJurnalPiket;
use App\Models\User;

class GuruPiketController extends Controller
{
    /**
     * Helper nama hari Indonesia
     */
    private function getHariIndo()
    {
        $days = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];
        return $days[Carbon::now('Asia/Jakarta')->format('l')] ?? 'Kamis';
    }

    /**
     * Halaman Menu Guru Piket (Mobile & Desktop)
     */
    public function menu()
    {
        $countPendingIzinPiket = 0;
        if (\Illuminate\Support\Facades\Schema::hasColumn('guru_izin', 'is_pengajuan_guru') && \Illuminate\Support\Facades\Schema::hasColumn('guru_izin', 'status_piket')) {
            try {
                $countPendingIzinPiket = \App\Models\GuruIzin::where('is_pengajuan_guru', 1)->where('status_piket', 'pending')->count();
            } catch (\Throwable $e) {
                $countPendingIzinPiket = 0;
            }
        }

        $trashedDispenCount = 0;
        try {
            $trashedDispenCount = \App\Models\SiswaDispen::onlyTrashed()->count();
        } catch (\Throwable $e) {}

        $trashedTelatCount = 0;
        try {
            $trashedTelatCount = \App\Models\SiswaTelat::onlyTrashed()->count();
        } catch (\Throwable $e) {}

        return view('guru_piket.menu', compact('countPendingIzinPiket', 'trashedDispenCount', 'trashedTelatCount'));
    }

    /**
     * Dashboard Guru Piket
     */
    public function dashboard()
    {
        $now = Carbon::now('Asia/Jakarta');
        $hariIni = $this->getHariIndo();
        $todayDate = $now->toDateString();

        // 1. Jadwal Hari Ini untuk seluruh kelas
        $jadwalsToday = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamMulai', 'jamSelesai'])
            ->where('hari', $hariIni)
            ->orderBy('id_jam_mulai', 'asc')
            ->get();

        $totalJadwalToday = $jadwalsToday->count();

        // 2. Stat Cards Data Riil
        // Card 1: Total Jurnal Hari Ini
        $totalJurnalHariIni = JurnalMengajar::whereDate('tanggal', $todayDate)->count();

        // Card 2: Guru Tidak Hadir Resmi Hari Ini
        $guruTidakHadirCount = GuruIzin::whereDate('tanggal_mulai', '<=', $todayDate)
            ->whereDate('tanggal_selesai', '>=', $todayDate)
            ->where(function($q) {
                $q->where('status_piket', 'disetujui')
                  ->orWhere('status_waka', 'approved')
                  ->orWhere('status_kepsek', 'approved')
                  ->orWhereNull('status_piket');
            })
            ->count();

        // Card 3: Guru Pengganti Penugasan Hari Ini
        $guruPenggantiCount = PenugasanGuruPengganti::whereDate('tanggal', $todayDate)
            ->where('status', 'aktif')
            ->count();

        // Card 4: % Kelas Sudah Terisi
        $kelasTerisiPercentage = $totalJadwalToday > 0 
            ? min(100, round(($totalJurnalHariIni / $totalJadwalToday) * 100)) 
            : 0;

        // 3. Table 1: Monitoring Jurnal Mengajar Hari Ini (Riil Database)
        $monitoringJurnalToday = JurnalMengajar::with([
            'jadwal.guru', 
            'jadwal.mapel', 
            'jadwal.kelas', 
            'jadwal.jamMulai', 
            'jadwal.jamSelesai', 
            'guruPengganti'
        ])
        ->whereDate('tanggal', $todayDate)
        ->orderBy('id_jurnal', 'desc')
        ->limit(6)
        ->get();

        // 4. Table 2: Penugasan Guru Pengganti Hari Ini (Riil Database)
        $penugasanToday = PenugasanGuruPengganti::with([
            'guruTidakHadir.mapel', 
            'guruPengganti', 
            'kelas', 
            'jadwal.jamMulai', 
            'jadwal.jamSelesai'
        ])
        ->whereDate('tanggal', $todayDate)
        ->where('status', 'aktif')
        ->orderBy('id_penugasan', 'desc')
        ->limit(6)
        ->get();

        // 5. Widget Timeline Jadwal Hari Ini
        $timelineJadwal = $jadwalsToday->take(6);
        foreach ($timelineJadwal as $jItem) {
            $jItem->sudah_diisi = JurnalMengajar::where('id_jadwal', $jItem->id_jadwal)
                ->whereDate('tanggal', $todayDate)
                ->exists();
        }

        // 6. Widget Chart Jurnal Mingguan (Senin - Jumat) dari Database Riil
        $startOfWeek = $now->copy()->startOfWeek(Carbon::MONDAY)->toDateString();
        $endOfWeek   = $now->copy()->endOfWeek(Carbon::FRIDAY)->toDateString();

        $jurnalsByDay = JurnalMengajar::whereBetween('tanggal', [$startOfWeek, $endOfWeek])
            ->selectRaw('DATE(tanggal) as tgl, COUNT(*) as aggregate')
            ->groupBy('tgl')
            ->pluck('aggregate', 'tgl')
            ->toArray();

        $seninDate  = $now->copy()->startOfWeek(Carbon::MONDAY)->toDateString();
        $selasaDate = $now->copy()->startOfWeek(Carbon::MONDAY)->addDays(1)->toDateString();
        $rabuDate   = $now->copy()->startOfWeek(Carbon::MONDAY)->addDays(2)->toDateString();
        $kamisDate  = $now->copy()->startOfWeek(Carbon::MONDAY)->addDays(3)->toDateString();
        $jumatDate  = $now->copy()->startOfWeek(Carbon::MONDAY)->addDays(4)->toDateString();

        $jurnalMingguan = [
            'senin'  => $jurnalsByDay[$seninDate] ?? 0,
            'selasa' => $jurnalsByDay[$selasaDate] ?? 0,
            'rabu'   => $jurnalsByDay[$rabuDate] ?? 0,
            'kamis'  => $jurnalsByDay[$kamisDate] ?? 0,
            'jumat'  => $jurnalsByDay[$jumatDate] ?? 0,
        ];

        // Jika minggu ini belum ada jurnal, hitung akumulasi jurnal per hari dalam data riil
        if (max(array_values($jurnalMingguan)) === 0) {
            $recentDayCounts = JurnalMengajar::selectRaw('DAYNAME(tanggal) as day_name, COUNT(*) as aggregate')
                ->groupBy('day_name')
                ->pluck('aggregate', 'day_name')
                ->toArray();

            $jurnalMingguan = [
                'senin'  => $recentDayCounts['Monday'] ?? 0,
                'selasa' => $recentDayCounts['Tuesday'] ?? 0,
                'rabu'   => $recentDayCounts['Wednesday'] ?? 0,
                'kamis'  => $recentDayCounts['Thursday'] ?? 0,
                'jumat'  => $recentDayCounts['Friday'] ?? 0,
            ];
        }

        // 7. Widget Pengumuman List Riil
        $pengumumanList = Pengumuman::where('status', 'aktif')
            ->orWhereNull('status')
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // 8. Verifikasi Harian Guru Piket & Jam Selesai KBM
        $isJumat = (strtolower(trim($hariIni)) === 'jumat');
        $jamSelesaiSekolah = $isJumat ? '15:35' : '15:00';
        $isJamSekolahSelesai = ($now->format('H:i') >= $jamSelesaiSekolah);
        $verifikasiHariIni = VerifikasiJurnalPiket::where('tanggal', $todayDate)
            ->where('status', 'terverifikasi')
            ->first();

        return view('guru_piket.dashboard', compact(
            'hariIni',
            'todayDate',
            'totalJurnalHariIni',
            'totalJadwalToday',
            'guruTidakHadirCount',
            'guruPenggantiCount',
            'kelasTerisiPercentage',
            'monitoringJurnalToday',
            'penugasanToday',
            'timelineJadwal',
            'jurnalMingguan',
            'pengumumanList',
            'jamSelesaiSekolah',
            'isJamSekolahSelesai',
            'verifikasiHariIni'
        ));
    }

    /**
     * Halaman Jurnal Mengajar (Monitoring Guru Piket)
     */
    public function jurnalMengajar(Request $request)
    {
        $now = Carbon::now('Asia/Jakarta');
        $todayDate = $now->toDateString();

        $search = $request->input('q');

        // Filter tanggal: default ke hari ini jika tidak ditentukan
        // Jika user secara sengaja mengirim ?tanggal=kosong, tampilkan semua
        if ($request->has('tanggal')) {
            $tanggalFilter = $request->input('tanggal');
        } else {
            $tanggalFilter = $todayDate;
        }

        $idGuruFilter  = $request->input('id_guru');
        $idKelasFilter = $request->input('id_kelas');
        $idMapelFilter = $request->input('id_mapel');
        $statusFilter  = $request->input('status'); // 'terlaksana', 'belum', 'semua'

        // Query riil jurnal mengajar
        $query = JurnalMengajar::with([
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.kelas',
            'jadwal.ruangan',
            'jadwal.jamMulai',
            'jadwal.jamSelesai',
            'guruPengganti',
            'verifikasiPiket.guru',
            'detailKetidakhadiran.siswa'
        ]);

        if (!empty($tanggalFilter)) {
            $query->whereDate('tanggal', $tanggalFilter);
        }

        if ($idKelasFilter) {
            $query->whereHas('jadwal', function($q) use ($idKelasFilter) {
                $q->where('id_kelas', $idKelasFilter);
            });
        }

        if ($idGuruFilter) {
            $query->where(function($q) use ($idGuruFilter) {
                $q->whereHas('jadwal', function($qG) use ($idGuruFilter) {
                    $qG->where('id_guru', $idGuruFilter);
                })->orWhere('id_guru_pengganti', $idGuruFilter);
            });
        }

        if ($idMapelFilter) {
            $query->whereHas('jadwal', function($q) use ($idMapelFilter) {
                $q->where('id_mapel', $idMapelFilter);
            });
        }

        if ($statusFilter === 'terlaksana') {
            $query->where('status_kehadiran_guru', 'Hadir');
        } elseif ($statusFilter === 'belum') {
            $query->where('status_kehadiran_guru', '!=', 'Hadir');
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('materi', 'like', "%{$search}%")
                  ->orWhere('catatan', 'like', "%{$search}%")
                  ->orWhereHas('jadwal.guru', function($qG) use ($search) {
                      $qG->where('nama_guru', 'like', "%{$search}%");
                  })
                  ->orWhereHas('jadwal.mapel', function($qM) use ($search) {
                      $qM->where('nama_mapel', 'like', "%{$search}%");
                  })
                  ->orWhereHas('jadwal.kelas', function($qK) use ($search) {
                      $qK->where('nama_kelas', 'like', "%{$search}%");
                  })
                  ->orWhereHas('guruPengganti', function($qP) use ($search) {
                      $qP->where('nama_guru', 'like', "%{$search}%");
                  });
            });
        }

        // Urutkan tanggal terbaru & sesi KBM
        $jurnals = $query->orderBy('tanggal', 'desc')
                         ->orderBy('id_jurnal', 'desc')
                         ->paginate(15)
                         ->withQueryString();

        // Hitung 4 Kartu Statistik Dinamis dari Database Riil
        $statsQuery = JurnalMengajar::query();
        if (!empty($tanggalFilter)) {
            $statsQuery->whereDate('tanggal', $tanggalFilter);
            
            // Hitung total sesi jadwal KBM pada hari tersebut
            $targetCarbon = Carbon::parse($tanggalFilter);
            $daysIndo = [
                'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
            ];
            $dayNameTarget = $daysIndo[$targetCarbon->format('l')] ?? '';
            $totalJadwalHari = Jadwal::where('hari', $dayNameTarget)->count();
        } else {
            $totalJadwalHari = Jadwal::count();
        }

        $totalPertemuan = $statsQuery->count();
        $terlaksana = (clone $statsQuery)->where('status_kehadiran_guru', 'Hadir')->count();
        
        if (!empty($tanggalFilter)) {
            $belumTerlaksana = max(0, $totalJadwalHari - $terlaksana);
            $totalSesiAcuan = max($totalJadwalHari, $totalPertemuan);
        } else {
            $belumTerlaksana = (clone $statsQuery)->where('status_kehadiran_guru', '!=', 'Hadir')->count();
            $totalSesiAcuan = max($totalPertemuan, 1);
        }
        $pctBelum = $totalSesiAcuan > 0 ? round(($belumTerlaksana / $totalSesiAcuan) * 100, 1) : 0;

        // Guru Aktif
        $guruAktif = (clone $statsQuery)->with('jadwal')->get()->pluck('jadwal.id_guru')->filter()->unique()->count();

        $stats = [
            'totalPertemuan'  => $totalPertemuan,
            'terlaksana'      => $terlaksana,
            'belumTerlaksana' => $belumTerlaksana,
            'pctBelum'        => $pctBelum,
            'guruAktif'       => $guruAktif,
        ];

        // TIME GATING UNTUK TANDA TANGAN VALIDASI GURU PIKET:
        // Cek apakah jam pembelajaran sekolah pada tanggal yang dilihat telah berakhir
        // Master Jam Pelajaran TU (ALOKASI JAM KBM BARU):
        // - Senin-Kamis: Jam Ke-10 selesai pukul 15:00 WIB
        // - Jumat: Jam Ke-13 selesai pukul 15:35 WIB
        $dateForSignature = !empty($tanggalFilter) ? $tanggalFilter : $todayDate;
        $carbonSigDate = Carbon::parse($dateForSignature);
        $daysIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $dayNameSig = $daysIndo[$carbonSigDate->format('l')] ?? 'Senin';
        $isJumatSig = (strtolower(trim($dayNameSig)) === 'jumat');
        $jamSelesaiSekolah = $isJumatSig ? '15:35' : '15:00';

        $isPastDate   = ($dateForSignature < $todayDate);
        $isTodayDate  = ($dateForSignature === $todayDate);
        $isFutureDate = ($dateForSignature > $todayDate);

        if ($isPastDate) {
            $isJamSekolahSelesai = true; // Hari kemarin sudah pasti berakhir
        } elseif ($isTodayDate) {
            $currentTimeStr = $now->format('H:i');
            $isJamSekolahSelesai = ($currentTimeStr >= $jamSelesaiSekolah);
        } else {
            $isJamSekolahSelesai = false; // Tanggal depan belum dimulai
        }

        // Cek data Tanda Tangan & Verifikasi Guru Piket pada tanggal tersebut
        $verifikasiHariIni = VerifikasiJurnalPiket::with('guru')
            ->where('tanggal', $dateForSignature)
            ->where('status', 'terverifikasi')
            ->first();

        // Master lists untuk filter & form tanda tangan
        $guruList = Guru::orderBy('nama_guru')->get();
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapelList = Mapel::orderBy('nama_mapel')->get();

        // Akun Guru Piket yang sedang login (default TTD)
        $currentUser = Auth::user();
        $defaultGuruPiket = null;
        if ($currentUser && $currentUser->id_guru) {
            $defaultGuruPiket = Guru::find($currentUser->id_guru);
        } elseif ($currentUser && $currentUser->nip) {
            $defaultGuruPiket = Guru::where('nip', $currentUser->nip)->first();
        }

        return view('guru_piket.jurnal_mengajar', compact(
            'jurnals',
            'guruList',
            'kelasList',
            'mapelList',
            'stats',
            'search',
            'tanggalFilter',
            'idGuruFilter',
            'idKelasFilter',
            'idMapelFilter',
            'statusFilter',
            'dateForSignature',
            'dayNameSig',
            'jamSelesaiSekolah',
            'isJamSekolahSelesai',
            'isTodayDate',
            'isPastDate',
            'verifikasiHariIni',
            'defaultGuruPiket'
        ));
    }

    /**
     * Detail Lengkap Jurnal Mengajar (JSON API untuk Modal Detail)
     */
    public function detailJurnalMengajar($id)
    {
        $jurnal = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.ruangan',
            'jadwal.jamMulai',
            'jadwal.jamSelesai',
            'guruPengganti',
            'detailKetidakhadiran.siswa',
            'verifikasiPiket.guru'
        ])->findOrFail($id);

        $tglCarbon = Carbon::parse($jurnal->tanggal);
        $daysIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $hariTeks = $daysIndo[$tglCarbon->format('l')] ?? '-';

        // Hitung total siswa kelas
        $totalSiswaKelas = 0;
        if ($jurnal->jadwal && $jurnal->jadwal->id_kelas) {
            $totalSiswaKelas = Siswa::where('id_kelas', $jurnal->jadwal->id_kelas)->count();
        }

        $absenList = $jurnal->detailKetidakhadiran->map(function($d) {
            return [
                'id_siswa'   => $d->id_siswa,
                'nama_siswa' => $d->siswa->nama_siswa ?? 'Siswa',
                'nisn'       => $d->siswa->nisn ?? ($d->siswa->nis ?? '-'),
                'keterangan' => $d->keterangan ?? 'Izin',
            ];
        });

        $sakitCount = $absenList->where('keterangan', 'Sakit')->count();
        $izinCount  = $absenList->where('keterangan', 'Izin')->count();
        $alpaCount  = $absenList->where('keterangan', 'Alpa')->count();
        $totalAbsen = $absenList->count();
        $hadirCount = max(0, $totalSiswaKelas - $totalAbsen);

        // Verifikasi piket data
        $jurnalDateStr = Carbon::parse($jurnal->tanggal)->toDateString();
        $verif = VerifikasiJurnalPiket::where('tanggal', $jurnalDateStr)
            ->where('status', 'terverifikasi')
            ->first();
        $verifData = null;
        if ($verif) {
            $verifData = [
                'is_verified'      => true,
                'nama_guru_piket'  => $verif->nama_guru_piket,
                'nip_guru_piket'   => $verif->nip_guru_piket ?? '-',
                'waktu_verifikasi' => Carbon::parse($verif->waktu_verifikasi)->translatedFormat('d F Y, H:i') . ' WIB',
                'tanda_tangan'     => $verif->tanda_tangan,
                'catatan'          => $verif->catatan ?? '-',
            ];
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'id_jurnal'             => $jurnal->id_jurnal,
                'tanggal'               => $jurnal->tanggal,
                'hari'                  => $hariTeks,
                'tanggal_formatted'     => $tglCarbon->translatedFormat('d F Y'),
                'mapel'                 => $jurnal->jadwal->mapel->nama_mapel ?? ($jurnal->mapel_nama ?? '-'),
                'kode_mapel'            => $jurnal->jadwal->mapel->kode_mapel ?? '-',
                'kelas'                 => $jurnal->jadwal->kelas->nama_kelas ?? ($jurnal->kelas_nama ?? '-'),
                'ruangan'               => $jurnal->jadwal->ruangan->nama_ruangan ?? '-',
                'jam_ke'                => $jurnal->jadwal->jam_range ?? ($jurnal->jam_ke ?? '-'),
                'waktu_kbm'             => ($jurnal->jadwal->waktu_mulai_effective ?? '07:00') . ' - ' . ($jurnal->jadwal->waktu_selesai_effective ?? '08:20') . ' WIB',
                'jumlah_jp'             => ($jurnal->jadwal->jumlah_jp ?? 2) . ' JP',
                'guru'                  => $jurnal->jadwal->guru->nama_guru ?? '-',
                'nip_guru'              => $jurnal->jadwal->guru->nip ?? '-',
                'is_guru_pengganti'     => $jurnal->id_guru_pengganti ? true : false,
                'guru_pengganti'        => $jurnal->guruPengganti->nama_guru ?? null,
                'materi'                => $jurnal->materi ?? '-',
                'pertemuan_ke'          => $jurnal->pertemuan_ke ?? 'Ke-1',
                'catatan'               => $jurnal->catatan ?? 'Tidak ada catatan khusus.',
                'kondisi_kelas'         => $jurnal->kondisi_kelas ?? 'Kondusif',
                'status_kehadiran_guru' => $jurnal->status_kehadiran_guru ?? 'Hadir',
                'dokumentasi_url'       => $jurnal->dokumentasi_url,
                'total_siswa'           => $totalSiswaKelas,
                'hadir_count'           => $hadirCount,
                'sakit_count'           => $sakitCount,
                'izin_count'            => $izinCount,
                'alpa_count'            => $alpaCount,
                'daftar_absen'          => $absenList->values()->toArray(),
                'verifikasi_piket'      => $verifData,
            ]
        ]);
    }

    /**
     * Simpan Tanda Tangan & Validasi Harian Guru Piket
     */
    public function simpanTandaTanganPiket(Request $request)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'id_guru'      => 'required|exists:guru,id_guru',
            'tanda_tangan' => 'required|string',
            'catatan'      => 'nullable|string',
        ]);

        $now = Carbon::now('Asia/Jakarta');
        $todayDate = $now->toDateString();
        $tanggal = $request->tanggal;

        // Cek ketentuan jam KBM sekolah selesai
        $carbonDate = Carbon::parse($tanggal);
        $daysIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $dayName = $daysIndo[$carbonDate->format('l')] ?? 'Senin';
        $isJumat = (strtolower(trim($dayName)) === 'jumat');
        $jamSelesaiSekolah = $isJumat ? '15:35' : '15:00';

        if ($tanggal === $todayDate && $now->format('H:i') < $jamSelesaiSekolah) {
            return redirect()->back()->with('error', "Peringatan: Tanda tangan validasi jurnal harian oleh Guru Piket belum dapat dilakukan karena jam pembelajaran sekolah hari ini belum berakhir (KBM sekolah berakhir pukul {$jamSelesaiSekolah} WIB).");
        }

        if ($tanggal > $todayDate) {
            return redirect()->back()->with('error', "Peringatan: Tidak dapat menandatangani jurnal mengajar untuk tanggal yang belum berlangsung.");
        }

        $guru = Guru::findOrFail($request->id_guru);

        // Hitung total jurnal terkirim pada tanggal ini
        $totalJurnal = JurnalMengajar::whereDate('tanggal', $tanggal)->count();

        // Simpan atau update verifikasi tanda tangan (termasuk pemulihan jika pernah dibatalkan)
        $verif = VerifikasiJurnalPiket::withTrashed()->whereDate('tanggal', $tanggal)->first();
        if ($verif) {
            if ($verif->trashed()) {
                $verif->restore();
            }
            $verif->update([
                'id_guru'                   => $guru->id_guru,
                'nama_guru_piket'           => $guru->nama_guru,
                'nip_guru_piket'            => $guru->nip,
                'tanda_tangan'              => $request->tanda_tangan,
                'catatan'                   => $request->catatan,
                'waktu_verifikasi'          => $now,
                'ip_address'                => $request->ip(),
                'user_agent'                => $request->userAgent(),
                'total_jurnal_diverifikasi' => $totalJurnal,
                'status'                    => 'terverifikasi',
            ]);
        } else {
            VerifikasiJurnalPiket::create([
                'tanggal'                   => $tanggal,
                'id_guru'                   => $guru->id_guru,
                'nama_guru_piket'           => $guru->nama_guru,
                'nip_guru_piket'            => $guru->nip,
                'tanda_tangan'              => $request->tanda_tangan,
                'catatan'                   => $request->catatan,
                'waktu_verifikasi'          => $now,
                'ip_address'                => $request->ip(),
                'user_agent'                => $request->userAgent(),
                'total_jurnal_diverifikasi' => $totalJurnal,
                'status'                    => 'terverifikasi',
            ]);
        }

        return redirect()->route('piket.jurnal-mengajar', ['tanggal' => $tanggal])
            ->with('success', "Tanda tangan validasi dan verifikasi Guru Piket berhasil disimpan! Sebanyak {$totalJurnal} Jurnal Mengajar pada tanggal " . Carbon::parse($tanggal)->translatedFormat('d F Y') . " resmi divalidasi dan ditandatangani oleh {$guru->nama_guru}.");
    }

    /**
     * Batalkan Tanda Tangan Guru Piket (jika perlu koreksi)
     */
    public function batalTandaTanganPiket(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date'
        ]);

        $verif = VerifikasiJurnalPiket::whereDate('tanggal', $request->tanggal)->first();
        if ($verif) {
            $verif->forceDelete();
            return redirect()->route('piket.jurnal-mengajar', ['tanggal' => $request->tanggal])
                ->with('success', 'Status tanda tangan verifikasi jurnal harian untuk tanggal ' . Carbon::parse($request->tanggal)->translatedFormat('d F Y') . ' berhasil dibatalkan. Anda dapat menandatangani ulang kembali.');
        }

        return redirect()->back()->with('error', 'Data verifikasi tidak ditemukan.');
    }

    /**
     * Cetak Rekap Jurnal Harian dengan Tanda Tangan Resmi Guru Piket
     */
    public function cetakRekapHarian(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::now('Asia/Jakarta')->toDateString());
        $jurnals = JurnalMengajar::with([
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.kelas',
            'jadwal.ruangan',
            'jadwal.jamMulai',
            'jadwal.jamSelesai',
            'guruPengganti',
            'detailKetidakhadiran.siswa'
        ])
        ->whereDate('tanggal', $tanggal)
        ->orderBy('id_jurnal', 'asc')
        ->get();

        $verifikasi = VerifikasiJurnalPiket::with('guru')
            ->where('tanggal', $tanggal)
            ->where('status', 'terverifikasi')
            ->first();

        $tglCarbon = Carbon::parse($tanggal);
        $daysIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $hariTeks = $daysIndo[$tglCarbon->format('l')] ?? 'Senin';

        return view('guru_piket.jurnal_mengajar_cetak', compact('jurnals', 'verifikasi', 'tanggal', 'hariTeks', 'tglCarbon'));
    }

    /**
     * Export Jurnal Mengajar to CSV
     */
    public function exportJurnalMengajarCsv(Request $request)
    {
        $filename = "rekap_jurnal_mengajar_piket_" . date('Y-m-d_H-i') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $tanggalFilter = $request->input('tanggal');
        $idGuruFilter  = $request->input('id_guru');
        $idKelasFilter = $request->input('id_kelas');
        $idMapelFilter = $request->input('id_mapel');
        $search        = $request->input('q');

        $query = JurnalMengajar::with([
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.kelas',
            'jadwal.ruangan',
            'jadwal.jamMulai',
            'jadwal.jamSelesai',
            'guruPengganti',
            'verifikasiPiket.guru',
            'detailKetidakhadiran'
        ]);

        if (!empty($tanggalFilter)) {
            $query->whereDate('tanggal', $tanggalFilter);
        }

        if ($idKelasFilter) {
            $query->whereHas('jadwal', fn($q) => $q->where('id_kelas', $idKelasFilter));
        }

        if ($idGuruFilter) {
            $query->where(function($q) use ($idGuruFilter) {
                $q->whereHas('jadwal', fn($qG) => $qG->where('id_guru', $idGuruFilter))
                  ->orWhere('id_guru_pengganti', $idGuruFilter);
            });
        }

        if ($idMapelFilter) {
            $query->whereHas('jadwal', fn($q) => $q->where('id_mapel', $idMapelFilter));
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('materi', 'like', "%{$search}%")
                  ->orWhereHas('jadwal.guru', fn($qG) => $qG->where('nama_guru', 'like', "%{$search}%"))
                  ->orWhereHas('jadwal.mapel', fn($qM) => $qM->where('nama_mapel', 'like', "%{$search}%"))
                  ->orWhereHas('jadwal.kelas', fn($qK) => $qK->where('nama_kelas', 'like', "%{$search}%"));
            });
        }

        $jurnals = $query->orderBy('tanggal', 'desc')->get();

        $callback = function() use ($jurnals) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM
            fputcsv($file, [
                'No', 'Tanggal', 'Jam KBM', 'Waktu WIB', 'Kelas', 'Ruang', 'Mata Pelajaran',
                'Guru Pengampu', 'Guru Pengganti', 'Materi Pembelajaran', 'Pertemuan Ke',
                'Kondisi Kelas', 'Status Kehadiran Guru', 'Ketidakhadiran Siswa',
                'Status Verifikasi Piket', 'Guru Piket Pengesah', 'Waktu Verifikasi'
            ]);

            foreach ($jurnals as $index => $j) {
                $guruPengampu = $j->jadwal->guru->nama_guru ?? '-';
                $guruPengganti = $j->guruPengganti->nama_guru ?? '-';
                $verif = $j->verifikasiPiket;
                $isVerif = ($verif && $verif->status === 'terverifikasi');

                $absenCount = $j->detailKetidakhadiran->count();
                $ketAbsen = $absenCount > 0 ? "{$absenCount} Siswa Absen" : "Semua Siswa Hadir";

                fputcsv($file, [
                    $index + 1,
                    $j->tanggal,
                    $j->jadwal->jam_range ?? '-',
                    ($j->jadwal->waktu_mulai_effective ?? '07:00') . ' - ' . ($j->jadwal->waktu_selesai_effective ?? '08:20'),
                    $j->jadwal->kelas->nama_kelas ?? '-',
                    $j->jadwal->ruangan->nama_ruangan ?? '-',
                    $j->jadwal->mapel->nama_mapel ?? '-',
                    $guruPengampu,
                    $guruPengganti !== '-' ? $guruPengganti : '-',
                    $j->materi ?? '-',
                    $j->pertemuan_ke ?? 'Ke-1',
                    $j->kondisi_kelas ?? 'Kondusif',
                    $j->status_kehadiran_guru ?? 'Hadir',
                    $ketAbsen,
                    $isVerif ? 'Terverifikasi Piket' : 'Menunggu Verifikasi',
                    $isVerif ? $verif->nama_guru_piket : '-',
                    $isVerif ? Carbon::parse($verif->waktu_verifikasi)->format('Y-m-d H:i') : '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Halaman Guru Pengganti (Penugasan)
     */
    public function guruPengganti(Request $request)
    {
        $todayDate = Carbon::now('Asia/Jakarta')->toDateString();

        $todayDate = \Carbon\Carbon::now()->format('Y-m-d');

        $search = $request->input('q');
        $tanggalFilter = $request->input('tanggal');
        $idKelasFilter = $request->input('id_kelas');
        $idMapelFilter = $request->input('id_mapel');
        $statusFilter = $request->input('status');

        $query = PenugasanGuruPengganti::with(['guruTidakHadir.mapel', 'guruPengganti', 'kelas', 'jadwal']);

        if ($tanggalFilter) {
            $query->whereDate('tanggal', $tanggalFilter);
        }

        if ($idKelasFilter) {
            $query->where('id_kelas', $idKelasFilter);
        }

        if ($statusFilter) {
            $query->where('status', strtolower($statusFilter));
        }

        if ($idMapelFilter) {
            $query->where(function($q) use ($idMapelFilter) {
                $q->whereHas('jadwal', function($qJ) use ($idMapelFilter) {
                    $qJ->where('id_mapel', $idMapelFilter);
                })->orWhereHas('guruTidakHadir', function($qG) use ($idMapelFilter) {
                    $qG->where('id_mapel', $idMapelFilter);
                });
            });
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('guruTidakHadir', function($qG) use ($search) {
                    $qG->where('nama_guru', 'like', "%{$search}%");
                })
                ->orWhereHas('guruPengganti', function($qP) use ($search) {
                    $qP->where('nama_guru', 'like', "%{$search}%");
                })
                ->orWhereHas('kelas', function($qK) use ($search) {
                    $qK->where('nama_kelas', 'like', "%{$search}%");
                });
            });
        }

        $penugasans = $query->orderBy('id_penugasan', 'desc')->get();

        // Calculate 3 Stat Cards synchronized from real database tables
        $guruTidakHadirCount = GuruIzin::whereDate('tanggal_mulai', '<=', $todayDate)
            ->whereDate('tanggal_selesai', '>=', $todayDate)
            ->count();
        if ($guruTidakHadirCount === 0) {
            $guruTidakHadirCount = GuruIzin::count();
        }

        $guruPenggantiCount = PenugasanGuruPengganti::pluck('id_guru_pengganti')->filter()->unique()->count();
        $penugasanAktifCount = PenugasanGuruPengganti::where('status', 'aktif')->count();

        $stats = [
            'guruTidakHadir' => $guruTidakHadirCount,
            'guruPengganti'  => $guruPenggantiCount,
            'penugasanAktif' => $penugasanAktifCount,
        ];

        // Ambil data Master Jam Pelajaran dari database (Role TU / Admin)
        $jamPelajaranList = \App\Models\JamPelajaran::orderBy('id_jam')->get();

        // Tentukan Target Tanggal Penugasan (Default Hari Ini)
        $targetDate = $tanggalFilter ?: $todayDate;
        $selectedGuruTidakHadirId = $request->input('id_guru_tidak_hadir', $request->input('id_guru_izin'));

        $tglCarbon = Carbon::parse($targetDate);
        $daysIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $monthsIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $targetDayName = $daysIndo[$tglCarbon->format('l')] ?? '-';
        $targetDateFormatted = $targetDayName . ', ' . $tglCarbon->format('d') . ' ' . ($monthsIndo[(int)$tglCarbon->format('m')] ?? '') . ' ' . $tglCarbon->format('Y');

        // Ambil data guru piket yang terdaftar pada JadwalGuruPiket pada tanggal tersebut (Role Waka Kurikulum)
        $piketRecords = \App\Models\JadwalGuruPiket::with(['guru.mapel'])
            ->whereDate('tanggal', $targetDate)
            ->orderBy('slot_ke')
            ->get();

        $piketGuruIds = [];
        $piketSlotMap = [];
        foreach ($piketRecords as $rec) {
            if ($rec->guru) {
                $piketGuruIds[] = $rec->guru->id_guru;
                $piketSlotMap[$rec->guru->id_guru] = $rec->slot_ke;
            }
        }

        // Fallback: Jika belum ada di JadwalGuruPiket, ambil user role piket
        if (empty($piketGuruIds)) {
            $piketUsers = \App\Models\User::whereIn('role', ['piket', 'guru_piket'])->get();
            $piketUserGuruIds = $piketUsers->pluck('id_guru')->filter()->toArray();
            $piketNips = $piketUsers->pluck('nip')->filter()->toArray();
            $piketGuruIdsByNip = \App\Models\Guru::whereIn('nip', $piketNips)->pluck('id_guru')->toArray();
            $piketGuruIds = array_unique(array_merge($piketUserGuruIds, $piketGuruIdsByNip));
        }

        $guruList = Guru::with(['mapel', 'user'])
            ->where('nama_guru', '!=', 'Petugas Piket')
            ->orderBy('nama_guru')
            ->get()
            ->map(function($g) use ($piketGuruIds, $piketSlotMap) {
                $g->is_piket_today = in_array($g->id_guru, $piketGuruIds);
                $g->slot_piket = $piketSlotMap[$g->id_guru] ?? 1;
                return $g;
            });

        // Urutkan guruList agar Guru Piket muncul di paling atas
        $guruList = $guruList->sortByDesc('is_piket_today')->values();

        // Data Guru Tidak Hadir (Khusus yang terdata di GuruIzin & TELAH DISETUJUI oleh Waka dan Kepala Sekolah)
        $approvedQuery = GuruIzin::with(['guru.mapel'])
            ->whereHas('guru', function($q) {
                $q->where('nama_guru', '!=', 'Petugas Piket');
            })
            ->where(function($q) {
                $q->where(function($sub) {
                    $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                        ->whereIn('status_kepsek', ['approved', 'Disetujui']);
                })->orWhereIn('status_final', ['approved', 'Disetujui']);
            });

        $guruTidakHadirOptions = (clone $approvedQuery)
            ->whereDate('tanggal_mulai', '<=', $targetDate)
            ->whereDate('tanggal_selesai', '>=', $targetDate)
            ->get();

        // Fallback jika belum ada izin diinput pada tanggal tersebut, ambil riwayat perizinan yang disetujui di sistem
        if ($guruTidakHadirOptions->isEmpty()) {
            $guruTidakHadirOptions = (clone $approvedQuery)
                ->orderBy('id_guru_izin', 'desc')
                ->get();
        }

        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapelList = Mapel::orderBy('nama_mapel')->get();

        // Data Sampah (Soft Deleted)
        $trashPenugasans = PenugasanGuruPengganti::onlyTrashed()
            ->with(['guruTidakHadir.mapel', 'guruPengganti', 'kelas', 'jadwal'])
            ->orderBy('deleted_at', 'desc')
            ->get();
        $trashCount = $trashPenugasans->count();

        return view('guru_piket.guru_pengganti', compact(
            'penugasans',
            'trashPenugasans',
            'trashCount',
            'guruList',
            'guruTidakHadirOptions',
            'selectedGuruTidakHadirId',
            'jamPelajaranList',
            'kelasList',
            'mapelList',
            'stats',
            'search',
            'tanggalFilter',
            'idKelasFilter',
            'idMapelFilter',
            'statusFilter',
            'todayDate',
            'targetDate',
            'targetDayName',
            'targetDateFormatted'
        ));
    }

    /**
     * Helper parsing string jam pelajaran ke rentang jam (startPeriod & endPeriod) serta rentang waktu (startTime & endTime)
     */
    private function parseJamRange($jamStr)
    {
        $startPeriod = 1;
        $endPeriod = 13;
        $startTime = '00:00';
        $endTime = '23:59';

        if (empty($jamStr)) {
            return compact('startPeriod', 'endPeriod', 'startTime', 'endTime');
        }

        // Match pattern: "Jam ke-6 - 7", "Jam Ke-7", "Jam 1 - 3", "Jam Ke-1"
        if (preg_match('/Jam\s*(?:ke-?)?\s*(\d+)(?:\s*-\s*(\d+))?/i', $jamStr, $m)) {
            $startPeriod = (int)$m[1];
            $endPeriod = !empty($m[2]) ? (int)$m[2] : $startPeriod;
        }

        // Match time pattern: "(10:15 - 11:25 WIB)" or "08.00 - 09.30" or "10:50 - 11:25"
        if (preg_match('/(\d{1,2})[:.](\d{2})\s*-\s*(\d{1,2})[:.](\d{2})/', $jamStr, $m)) {
            $startTime = sprintf('%02d:%02d', $m[1], $m[2]);
            $endTime   = sprintf('%02d:%02d', $m[3], $m[4]);
        }

        return compact('startPeriod', 'endPeriod', 'startTime', 'endTime');
    }

    /**
     * Mendeteksi seluruh potensi bentrok (Guru Pengganti busy, Jadwal Utama Guru busy, Kelas & Jam Pelajaran busy)
     */
    private function checkPenugasanConflicts($idGuruPengganti, $idKelas, $tanggal, $jamPelajaranStr, $exceptId = null)
    {
        $input = $this->parseJamRange($jamPelajaranStr);
        $daysIndo = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hariIndo = $daysIndo[\Carbon\Carbon::parse($tanggal)->format('l')] ?? 'Senin';

        // 1. Cek bentrok Guru Pengganti pada Penugasan Guru Pengganti lain pada tanggal & jam/sesi overlap
        $existingPenugasans = PenugasanGuruPengganti::with(['kelas', 'guruPengganti', 'guruTidakHadir'])
            ->where('tanggal', $tanggal)
            ->where('id_guru_pengganti', $idGuruPengganti)
            ->where('status', '!=', 'dibatalkan');

        if ($exceptId) {
            $existingPenugasans->where('id_penugasan', '!=', $exceptId);
        }

        foreach ($existingPenugasans->get() as $p) {
            $pRange = $this->parseJamRange($p->jam_pelajaran);

            $periodOverlap = (max($input['startPeriod'], $pRange['startPeriod']) <= min($input['endPeriod'], $pRange['endPeriod']));
            $timeOverlap = (max($input['startTime'], $pRange['startTime']) < min($input['endTime'], $pRange['endTime']));

            if ($periodOverlap || $timeOverlap) {
                $guruP = Guru::find($idGuruPengganti);
                $kelasNama = $p->kelas ? $p->kelas->nama_kelas : 'lain';
                return "PERINGATAN BENTROK GURU PENGGANTI: Guru " . ($guruP->nama_guru ?? 'Pengganti') . " sudah ditugaskan mengajar di Kelas {$kelasNama} pada Tanggal {$tanggal} Jam '{$p->jam_pelajaran}'!";
            }
        }

        // 2. Cek bentrok Guru Pengganti pada Jadwal Mengajar Utama miliknya sendiri (Hari & Jam overlap)
        $regularJadwals = Jadwal::with(['kelas', 'mapel', 'jamMulai', 'jamSelesai'])
            ->where('id_guru', $idGuruPengganti)
            ->where('hari', $hariIndo)
            ->get();

        foreach ($regularJadwals as $j) {
            $jStart = $j->id_jam_mulai ?? 1;
            $jEnd   = $j->id_jam_selesai ?? $jStart;

            $periodOverlap = (max($input['startPeriod'], $jStart) <= min($input['endPeriod'], $jEnd));

            if ($periodOverlap) {
                $guruP = Guru::find($idGuruPengganti);
                $kelasNama = $j->kelas ? $j->kelas->nama_kelas : 'lain';
                return "PERINGATAN BENTROK JADWAL UTAMA: Guru " . ($guruP->nama_guru ?? 'Pengganti') . " sudah memiliki jadwal mengajar reguler di Kelas {$kelasNama} pada Hari {$hariIndo} ({$j->jam_range_formatted})!";
            }
        }

        // 3. Cek bentrok Kelas & Jam Pelajaran (Kelas tersebut sudah ada penugasan guru pengganti lain pada jam overlap)
        if ($idKelas) {
            $classPenugasans = PenugasanGuruPengganti::with(['guruPengganti'])
                ->where('tanggal', $tanggal)
                ->where('id_kelas', $idKelas)
                ->where('status', '!=', 'dibatalkan');

            if ($exceptId) {
                $classPenugasans->where('id_penugasan', '!=', $exceptId);
            }

            foreach ($classPenugasans->get() as $cp) {
                $cpRange = $this->parseJamRange($cp->jam_pelajaran);

                $periodOverlap = (max($input['startPeriod'], $cpRange['startPeriod']) <= min($input['endPeriod'], $cpRange['endPeriod']));
                $timeOverlap = (max($input['startTime'], $cpRange['startTime']) < min($input['endTime'], $cpRange['endTime']));

                if ($periodOverlap || $timeOverlap) {
                    $kelasC = Kelas::find($idKelas);
                    $penggantiNama = $cp->guruPengganti ? $cp->guruPengganti->nama_guru : 'lain';
                    return "PERINGATAN BENTROK KELAS & JAM: Kelas " . ($kelasC->nama_kelas ?? '') . " pada Tanggal {$tanggal} Jam '{$cp->jam_pelajaran}' sudah memiliki Guru Pengganti ({$penggantiNama})!";
                }
            }
        }

        return null; // Bebas bentrok
    }

    /**
     * Simpan Penugasan Guru Pengganti (Support Single, Checklist Multi-Sesi, & Sehari Penuh + Deteksi Bentrok)
     */
    public function storeGuruPengganti(Request $request)
    {
        $isSehariPenuh = $request->has('sehari_penuh') && ($request->sehari_penuh == '1' || $request->sehari_penuh == 'on');
        $selectedJadwalIds = $request->input('selected_jadwal_ids', []);
        if (!is_array($selectedJadwalIds)) {
            $selectedJadwalIds = array_filter(explode(',', $selectedJadwalIds));
        }
        $hasMultiJadwal = count($selectedJadwalIds) > 0;

        $rules = [
            'tanggal'             => 'required|date',
            'id_guru_tidak_hadir' => 'required|integer',
            'id_guru_pengganti'   => 'required|integer|different:id_guru_tidak_hadir',
            'catatan'             => 'nullable|string',
            'materi_dititipkan'   => 'nullable|string',
            'tugas_dititipkan'    => 'nullable|string',
            'file_tugas'          => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png,zip|max:10000',
        ];

        if (!$isSehariPenuh && !$hasMultiJadwal) {
            $rules['id_kelas']      = 'required|integer';
            $rules['jam_pelajaran'] = 'required|string';
        }

        $request->validate($rules, [
            'id_guru_pengganti.different' => 'Guru pengganti tidak boleh sama dengan guru yang tidak hadir.',
            'id_kelas.required'           => 'Kelas wajib dipilih saat pengisian manual!',
            'jam_pelajaran.required'      => 'Jam Pelajaran wajib dipilih saat pengisian manual!',
        ]);

        // Validasi Tanggal berlalu
        if (Carbon::parse($request->tanggal)->lt(Carbon::today())) {
            return redirect()->back()->withInput()->withErrors([
                'tanggal' => 'Penugasan Guru Pengganti tidak dapat dibuat untuk tanggal yang telah berlalu!'
            ]);
        }

        $fileName = null;
        if ($request->hasFile('file_tugas')) {
            $file = $request->file('file_tugas');
            $fileName = time() . '_' . \Illuminate\Support\Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/tugas_pengganti'), $fileName);
        }

        // Ambil titipan dari GuruIzin jika kosong
        $materiDititipkan = $request->materi_dititipkan;
        $tugasDititipkan  = $request->tugas_dititipkan;
        if (!$materiDititipkan || !$tugasDititipkan) {
            $guruIzin = GuruIzin::where('id_guru', $request->id_guru_tidak_hadir)
                ->whereDate('tanggal_mulai', '<=', $request->tanggal)
                ->whereDate('tanggal_selesai', '>=', $request->tanggal)
                ->first();
            if ($guruIzin) {
                if (!$materiDititipkan) $materiDititipkan = $guruIzin->materi_dititipkan;
                if (!$tugasDititipkan)  $tugasDititipkan  = $guruIzin->tugas_dititipkan;
                if (!$fileName && $guruIzin->file_tugas) $fileName = $guruIzin->file_tugas;
            }
        }

        // PROSES PENUGASAN MULTI-SESI / CHECKLIST JAM PELAJARAN
        if ($hasMultiJadwal && !$isSehariPenuh) {
            $jadwals = Jadwal::with(['kelas', 'mapel', 'jamMulai', 'jamSelesai'])
                ->whereIn('id_jadwal', $selectedJadwalIds)
                ->get();

            if ($jadwals->isEmpty()) {
                return redirect()->back()->withInput()->withErrors([
                    'jam_pelajaran' => 'Sesi jadwal yang dipilih tidak valid!'
                ]);
            }

            // Validasi bentrok untuk setiap jadwal yang dicentang sebelum simpan
            foreach ($jadwals as $j) {
                $jamStr = $j->jam_range_formatted;
                $conflict = $this->checkPenugasanConflicts($request->id_guru_pengganti, $j->id_kelas, $request->tanggal, $jamStr);
                if ($conflict) {
                    return redirect()->back()->withInput()->withErrors([
                        'id_guru_pengganti' => $conflict
                    ]);
                }
            }

            // Simpan seluruh sesi jadwal yang dicentang
            $createdCount = 0;
            foreach ($jadwals as $j) {
                $jamStr = $j->jam_range_formatted;
                PenugasanGuruPengganti::create([
                    'tanggal'             => $request->tanggal,
                    'id_jadwal'           => $j->id_jadwal,
                    'id_guru_tidak_hadir' => $request->id_guru_tidak_hadir,
                    'id_guru_pengganti'   => $request->id_guru_pengganti,
                    'id_kelas'            => $j->id_kelas,
                    'jam_pelajaran'       => $jamStr,
                    'catatan'             => $request->catatan,
                    'materi_dititipkan'   => $materiDititipkan,
                    'tugas_dititipkan'    => $tugasDititipkan,
                    'file_tugas'          => $fileName,
                    'status'              => 'aktif',
                    'id_petugas_piket'    => Auth::id(),
                ]);
                $createdCount++;
            }

            return redirect()->route('piket.guru-pengganti')
                ->with('success', "Penugasan Guru Pengganti berhasil dibuat untuk {$createdCount} sesi jam pelajaran yang dipilih!");
        }

        // PROSES PENUGASAN SEHARI PENUH (OTOMATIS MASUKKAN SEMUA JAM & KELAS SESUAI JADWAL GURU)
        if ($isSehariPenuh) {
            $daysIndo = [
                'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
            ];
            $hariIndo = $daysIndo[Carbon::parse($request->tanggal)->format('l')] ?? 'Senin';

            $jadwals = Jadwal::with(['kelas', 'mapel', 'jamMulai', 'jamSelesai'])
                ->where('id_guru', $request->id_guru_tidak_hadir)
                ->where('hari', $hariIndo)
                ->get();

            if ($jadwals->isEmpty()) {
                return redirect()->back()->withInput()->withErrors([
                    'id_guru_tidak_hadir' => "Guru yang tidak hadir tidak memiliki jadwal mengajar pada hari {$hariIndo} ({$request->tanggal})!"
                ]);
            }

            // Validasi bentrok untuk setiap jadwal sebelum simpan
            foreach ($jadwals as $j) {
                $jamStr = $j->jam_range_formatted;
                $conflict = $this->checkPenugasanConflicts($request->id_guru_pengganti, $j->id_kelas, $request->tanggal, $jamStr);
                if ($conflict) {
                    return redirect()->back()->withInput()->withErrors([
                        'id_guru_pengganti' => $conflict
                    ]);
                }
            }

            // Simpan semua sesi jadwal
            $createdCount = 0;
            foreach ($jadwals as $j) {
                $jamStr = $j->jam_range_formatted;
                PenugasanGuruPengganti::create([
                    'tanggal'             => $request->tanggal,
                    'id_jadwal'           => $j->id_jadwal,
                    'id_guru_tidak_hadir' => $request->id_guru_tidak_hadir,
                    'id_guru_pengganti'   => $request->id_guru_pengganti,
                    'id_kelas'            => $j->id_kelas,
                    'jam_pelajaran'       => $jamStr,
                    'catatan'             => $request->catatan,
                    'materi_dititipkan'   => $materiDititipkan,
                    'tugas_dititipkan'    => $tugasDititipkan,
                    'file_tugas'          => $fileName,
                    'status'              => 'aktif',
                    'id_petugas_piket'    => Auth::id(),
                ]);
                $createdCount++;
            }

            return redirect()->route('piket.guru-pengganti')
                ->with('success', "Penugasan Sehari Penuh berhasil disimpan ({$createdCount} sesi jam pelajaran otomatis terisi)!");
        }

        // PROSES PENUGASAN MANUAL (SINGLE SLOT)
        // Cek Bentrok Lengkap (Guru Pengganti, Jadwal Utama, Kelas & Jam)
        $conflict = $this->checkPenugasanConflicts($request->id_guru_pengganti, $request->id_kelas, $request->tanggal, $request->jam_pelajaran);
        if ($conflict) {
            return redirect()->back()->withInput()->withErrors([
                'id_guru_pengganti' => $conflict
            ]);
        }

        $idJadwal = $request->id_jadwal;
        if (!$idJadwal && $request->id_kelas) {
            $jadwalFound = Jadwal::where('id_guru', $request->id_guru_tidak_hadir)
                ->where('id_kelas', $request->id_kelas)
                ->first();
            if ($jadwalFound) {
                $idJadwal = $jadwalFound->id_jadwal;
            }
        }

        PenugasanGuruPengganti::create([
            'tanggal'             => $request->tanggal,
            'id_jadwal'           => $idJadwal,
            'id_guru_tidak_hadir' => $request->id_guru_tidak_hadir,
            'id_guru_pengganti'   => $request->id_guru_pengganti,
            'id_kelas'            => $request->id_kelas,
            'jam_pelajaran'       => $request->jam_pelajaran,
            'catatan'             => $request->catatan,
            'materi_dititipkan'   => $materiDititipkan,
            'tugas_dititipkan'    => $tugasDititipkan,
            'file_tugas'          => $fileName,
            'status'              => 'aktif',
            'id_petugas_piket'    => Auth::id(),
        ]);

        return redirect()->route('piket.guru-pengganti')
            ->with('success', 'Penugasan Guru Pengganti berhasil ditambahkan!');
    }

    /**
     * Update / Edit Penugasan Guru Pengganti
     */
    public function updateGuruPengganti(Request $request, $id)
    {
        $penugasan = PenugasanGuruPengganti::findOrFail($id);

        $request->validate([
            'tanggal'             => 'required|date',
            'id_guru_tidak_hadir' => 'required|integer',
            'id_guru_pengganti'   => 'required|integer|different:id_guru_tidak_hadir',
            'id_kelas'            => 'required|integer',
            'jam_pelajaran'       => 'required|string',
            'status'              => 'required|in:aktif,selesai,dibatalkan',
            'catatan'             => 'nullable|string',
            'materi_dititipkan'   => 'nullable|string',
            'tugas_dititipkan'    => 'nullable|string',
            'file_tugas'          => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png,zip|max:10000',
        ], [
            'id_guru_pengganti.different' => 'Guru pengganti tidak boleh sama dengan guru yang tidak hadir.',
        ]);

        // Cek Bentrok jika status bukan dibatalkan
        if ($request->status !== 'dibatalkan') {
            $conflict = $this->checkPenugasanConflicts($request->id_guru_pengganti, $request->id_kelas, $request->tanggal, $request->jam_pelajaran, $id);
            if ($conflict) {
                return redirect()->back()->withInput()->withErrors([
                    'id_guru_pengganti' => $conflict
                ]);
            }
        }

        $fileName = $penugasan->file_tugas;
        if ($request->hasFile('file_tugas')) {
            $file = $request->file('file_tugas');
            $fileName = time() . '_' . \Illuminate\Support\Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/tugas_pengganti'), $fileName);
        }

        $idJadwal = $penugasan->id_jadwal;
        if ($request->id_kelas) {
            $jadwalFound = Jadwal::where('id_guru', $request->id_guru_tidak_hadir)
                ->where('id_kelas', $request->id_kelas)
                ->first();
            if ($jadwalFound) {
                $idJadwal = $jadwalFound->id_jadwal;
            }
        }

        $penugasan->update([
            'tanggal'             => $request->tanggal,
            'id_jadwal'           => $idJadwal,
            'id_guru_tidak_hadir' => $request->id_guru_tidak_hadir,
            'id_guru_pengganti'   => $request->id_guru_pengganti,
            'id_kelas'            => $request->id_kelas,
            'jam_pelajaran'       => $request->jam_pelajaran,
            'status'              => $request->status,
            'catatan'             => $request->catatan,
            'materi_dititipkan'   => $request->materi_dititipkan,
            'tugas_dititipkan'    => $request->tugas_dititipkan,
            'file_tugas'          => $fileName,
        ]);

        return redirect()->route('piket.guru-pengganti')
            ->with('success', 'Penugasan Guru Pengganti berhasil diperbarui!');
    }

    /**
     * Soft Delete Penugasan Guru Pengganti
     */
    public function destroyGuruPengganti($id)
    {
        $penugasan = PenugasanGuruPengganti::findOrFail($id);
        $penugasan->delete();

        return redirect()->route('piket.guru-pengganti')
            ->with('success', 'Penugasan Guru Pengganti berhasil dipindahkan ke Sampah (Soft Delete).');
    }

    /**
     * Bulk Soft Delete Penugasan Guru Pengganti
     */
    public function bulkDestroyGuruPengganti(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu penugasan guru pengganti yang mau dihapus.');
        }

        $count = PenugasanGuruPengganti::whereIn('id_penugasan', $ids)->delete();

        return redirect()->route('piket.guru-pengganti')
            ->with('success', $count . ' penugasan guru pengganti berhasil dipindahkan ke Sampah.');
    }

    /**
     * Pulihkan Penugasan Guru Pengganti dari Sampah
     */
    public function restoreGuruPengganti($id)
    {
        $penugasan = PenugasanGuruPengganti::onlyTrashed()->findOrFail($id);
        $penugasan->restore();

        return redirect()->route('piket.guru-pengganti')
            ->with('success', 'Penugasan Guru Pengganti berhasil dipulihkan dari Sampah.');
    }

    /**
     * Hapus Permanen Penugasan Guru Pengganti
     */
    public function forceDeleteGuruPengganti($id)
    {
        $penugasan = PenugasanGuruPengganti::onlyTrashed()->findOrFail($id);
        if ($penugasan->file_tugas && file_exists(public_path('uploads/tugas_pengganti/' . $penugasan->file_tugas))) {
            @unlink(public_path('uploads/tugas_pengganti/' . $penugasan->file_tugas));
        }
        $penugasan->forceDelete();

        return redirect()->route('piket.guru-pengganti')
            ->with('success', 'Penugasan Guru Pengganti berhasil dihapus secara permanen.');
    }

    /**
     * Kosongkan Seluruh Sampah Penugasan Guru Pengganti
     */
    public function emptyTrashGuruPengganti()
    {
        $trashed = PenugasanGuruPengganti::onlyTrashed()->get();
        foreach ($trashed as $item) {
            if ($item->file_tugas && file_exists(public_path('uploads/tugas_pengganti/' . $item->file_tugas))) {
                @unlink(public_path('uploads/tugas_pengganti/' . $item->file_tugas));
            }
            $item->forceDelete();
        }

        return redirect()->route('piket.guru-pengganti')
            ->with('success', 'Seluruh data Sampah Penugasan Guru Pengganti berhasil dikosongkan secara permanen.');
    }

    /**
     * AJAX Endpoint: Ambil Jadwal Mengajar Guru Tidak Hadir pada Tanggal Tertentu (Sehari Penuh)
     */
    public function getJadwalGuruTidakHadir(Request $request)
    {
        $idGuru = $request->query('id_guru');
        $tanggal = $request->query('tanggal', Carbon::today()->toDateString());

        if (!$idGuru) {
            return response()->json(['success' => false, 'message' => 'Guru tidak valid'], 400);
        }

        $daysIndo = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hariIndo = $daysIndo[Carbon::parse($tanggal)->format('l')] ?? 'Senin';

        $jadwals = Jadwal::with(['kelas', 'mapel', 'jamMulai', 'jamSelesai'])
            ->where('id_guru', $idGuru)
            ->where('hari', $hariIndo)
            ->orderBy('id_jam_mulai', 'asc')
            ->get();

        $data = $jadwals->map(function($j) {
            return [
                'id_jadwal'    => $j->id_jadwal,
                'id_kelas'     => $j->id_kelas,
                'nama_kelas'   => $j->kelas ? $j->kelas->nama_kelas : 'Kelas',
                'nama_mapel'   => $j->mapel ? $j->mapel->nama_mapel : 'Mata Pelajaran',
                'jam_pelajaran' => $j->jam_range_formatted,
            ];
        });

        return response()->json([
            'success'   => true,
            'hari'      => $hariIndo,
            'tanggal'   => $tanggal,
            'total_sesi' => $data->count(),
            'jadwals'   => $data,
        ]);
    }

    /**
     * AJAX Endpoint: Ambil daftar Guru Piket & Guru Mengajar Lainnya berdasarkan Tanggal Penugasan
     */
    public function getPiketGuruByDate(Request $request)
    {
        $tanggal = $request->query('tanggal', Carbon::now('Asia/Jakarta')->toDateString());
        
        $tglCarbon = Carbon::parse($tanggal);
        $daysIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $monthsIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $hariTeks = $daysIndo[$tglCarbon->format('l')] ?? '-';
        $formattedDate = $hariTeks . ', ' . $tglCarbon->format('d') . ' ' . ($monthsIndo[(int)$tglCarbon->format('m')] ?? '') . ' ' . $tglCarbon->format('Y');

        // 1. Ambil data guru piket yang terdaftar pada JadwalGuruPiket pada tanggal tersebut (Role Waka Kurikulum)
        $piketRecords = \App\Models\JadwalGuruPiket::with(['guru.mapel'])
            ->whereDate('tanggal', $tanggal)
            ->orderBy('slot_ke')
            ->get();

        $piketGuruIds = [];
        $piketGurus = [];

        foreach ($piketRecords as $rec) {
            if ($rec->guru) {
                $piketGuruIds[] = $rec->guru->id_guru;
                $piketGurus[] = [
                    'id_guru'    => $rec->guru->id_guru,
                    'nama_guru'  => $rec->guru->nama_guru,
                    'nip'        => $rec->guru->nip ?? '-',
                    'mapel_nama' => $rec->guru->mapel->nama_mapel ?? 'Guru',
                    'slot_ke'    => $rec->slot_ke,
                ];
            }
        }

        // Fallback: Jika belum ada di JadwalGuruPiket, ambil user ber-role piket
        if (empty($piketGurus)) {
            $piketUsers = \App\Models\User::whereIn('role', ['piket', 'guru_piket'])->get();
            $piketUserGuruIds = $piketUsers->pluck('id_guru')->filter()->toArray();
            $piketNips = $piketUsers->pluck('nip')->filter()->toArray();
            $piketGuruIdsByNip = \App\Models\Guru::whereIn('nip', $piketNips)->pluck('id_guru')->toArray();
            $fallbackPiketIds = array_unique(array_merge($piketUserGuruIds, $piketGuruIdsByNip));

            if (!empty($fallbackPiketIds)) {
                $fallbackGurus = Guru::with('mapel')->whereIn('id_guru', $fallbackPiketIds)->where('nama_guru', '!=', 'Petugas Piket')->get();
                foreach ($fallbackGurus as $g) {
                    $piketGuruIds[] = $g->id_guru;
                    $piketGurus[] = [
                        'id_guru'    => $g->id_guru,
                        'nama_guru'  => $g->nama_guru,
                        'nip'        => $g->nip ?? '-',
                        'mapel_nama' => $g->mapel->nama_mapel ?? 'Guru',
                        'slot_ke'    => 1,
                    ];
                }
            }
        }

        // 2. Ambil seluruh data guru mengajar lainnya
        $otherGurus = Guru::with('mapel')
            ->whereNotIn('id_guru', $piketGuruIds)
            ->where('nama_guru', '!=', 'Petugas Piket')
            ->orderBy('nama_guru')
            ->get()
            ->map(function($g) {
                return [
                    'id_guru'    => $g->id_guru,
                    'nama_guru'  => $g->nama_guru,
                    'nip'        => $g->nip ?? '-',
                    'mapel_nama' => $g->mapel->nama_mapel ?? 'Guru',
                ];
            });

        return response()->json([
            'success'        => true,
            'tanggal'        => $tanggal,
            'hari'           => $hariTeks,
            'formatted_date' => $formattedDate,
            'piket_gurus'    => $piketGurus,
            'other_gurus'    => $otherGurus,
        ]);
    }

    /**
     * Halaman Jadwal Hari Ini (Monitoring Jadwal KBM Guru Piket)
     */
    public function jadwalHariIni(Request $request)
    {
        $now = Carbon::now('Asia/Jakarta');
        $todayDate = $now->toDateString();
        $currentTimeStr = $now->format('H:i');

        // Filter tanggal: default ke hari ini
        $tanggalFilter = $request->input('tanggal', $todayDate);
        if (empty($tanggalFilter)) {
            $tanggalFilter = $todayDate;
        }

        $carbonFilter = Carbon::parse($tanggalFilter);
        $daysIndo = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hariFilter = $daysIndo[$carbonFilter->format('l')] ?? 'Senin';
        $isToday = ($tanggalFilter === $todayDate);
        $isPast = ($tanggalFilter < $todayDate);
        $isFuture = ($tanggalFilter > $todayDate);

        $idKelasFilter = $request->input('id_kelas');
        $idMapelFilter = $request->input('id_mapel');
        $idGuruFilter  = $request->input('id_guru');
        $statusFilter  = $request->input('status'); // 'berlangsung', 'selesai', 'belum'
        $search        = $request->input('q');

        // Penugasan Guru Pengganti pada tanggal terpilih
        $penugasanMap = PenugasanGuruPengganti::with('guruPengganti')
            ->whereDate('tanggal', $tanggalFilter)
            ->get()
            ->keyBy('id_jadwal');

        // Query seluruh jadwal pada hari tersebut untuk perhitungan 4 stat cards & ringkasan per kelas
        $allJadwalsHari = Jadwal::with(['kelas', 'mapel', 'guru', 'ruangan', 'jamMulai', 'jamSelesai', 'jurnalMengajars' => function($q) use ($tanggalFilter) {
            $q->whereDate('tanggal', $tanggalFilter);
        }])
            ->where('hari', $hariFilter)
            ->orderBy('id_jam_mulai', 'asc')
            ->get();

        // 4 Stat Cards Calculation
        $totalJadwal = $allJadwalsHari->count();
        $sedangBerlangsung = 0;
        $sudahSelesai = 0;
        $belumDimulai = 0;

        foreach ($allJadwalsHari as $j) {
            if ($isPast) {
                $sudahSelesai++;
            } elseif ($isFuture) {
                $belumDimulai++;
            } else {
                if ($currentTimeStr >= $j->waktu_selesai_effective) {
                    $sudahSelesai++;
                } elseif ($currentTimeStr >= $j->waktu_mulai_effective) {
                    $sedangBerlangsung++;
                } else {
                    $belumDimulai++;
                }
            }
        }

        $stats = [
            'totalJadwal'       => $totalJadwal,
            'sedangBerlangsung' => $sedangBerlangsung,
            'sudahSelesai'      => $sudahSelesai,
            'belumDimulai'      => $belumDimulai,
        ];

        // Ringkasan per Kelas (Data Riil)
        $ringkasanPerKelas = Kelas::orderBy('nama_kelas')->get()->map(function($k) use ($allJadwalsHari, $isPast, $isFuture, $currentTimeStr) {
            $kelasJadwals = $allJadwalsHari->where('id_kelas', $k->id_kelas);
            $total = $kelasJadwals->count();
            if ($total === 0) return null;

            $sedang = 0; $selesai = 0; $belum = 0;
            foreach ($kelasJadwals as $j) {
                if ($isPast) {
                    $selesai++;
                } elseif ($isFuture) {
                    $belum++;
                } else {
                    if ($currentTimeStr >= $j->waktu_selesai_effective) {
                        $selesai++;
                    } elseif ($currentTimeStr >= $j->waktu_mulai_effective) {
                        $sedang++;
                    } else {
                        $belum++;
                    }
                }
            }

            return (object)[
                'id_kelas'   => $k->id_kelas,
                'nama_kelas' => $k->nama_kelas,
                'total'      => $total,
                'sedang'     => $sedang,
                'selesai'    => $selesai,
                'belum'      => $belum,
            ];
        })->filter()->values();

        // Query Daftar Jadwal yang ditampilkan (dengan filter & search)
        $query = Jadwal::with([
            'kelas',
            'mapel',
            'guru',
            'ruangan',
            'jamMulai',
            'jamSelesai',
            'jurnalMengajars' => function($q) use ($tanggalFilter) {
                $q->whereDate('tanggal', $tanggalFilter);
            }
        ])->where('hari', $hariFilter);

        if ($idKelasFilter) {
            $query->where('id_kelas', $idKelasFilter);
        }

        if ($idMapelFilter) {
            $query->where('id_mapel', $idMapelFilter);
        }

        if ($idGuruFilter) {
            $query->where('id_guru', $idGuruFilter);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('guru', function($qG) use ($search) {
                    $qG->where('nama_guru', 'like', "%{$search}%");
                })->orWhereHas('mapel', function($qM) use ($search) {
                    $qM->where('nama_mapel', 'like', "%{$search}%");
                })->orWhereHas('kelas', function($qK) use ($search) {
                    $qK->where('nama_kelas', 'like', "%{$search}%");
                })->orWhereHas('ruangan', function($qR) use ($search) {
                    $qR->where('nama_ruangan', 'like', "%{$search}%");
                });
            });
        }

        $jadwals = $query->orderBy('id_jam_mulai', 'asc')
            ->orderBy('id_kelas', 'asc')
            ->paginate(15)
            ->appends($request->query());

        // Master lists untuk dropdown filter
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapelList = Mapel::orderBy('nama_mapel')->get();
        $guruList  = Guru::orderBy('nama_guru')->get();

        // Data Widget Guru Izin & Pengganti Hari Ini
        $guruTidakHadirCount = GuruIzin::whereDate('tanggal_mulai', '<=', $tanggalFilter)
            ->whereDate('tanggal_selesai', '>=', $tanggalFilter)
            ->count();
        $guruPenggantiCount = PenugasanGuruPengganti::whereDate('tanggal', $tanggalFilter)->count();
        $guruIzinList = GuruIzin::with('guru')
            ->whereDate('tanggal_mulai', '<=', $tanggalFilter)
            ->whereDate('tanggal_selesai', '>=', $tanggalFilter)
            ->limit(3)
            ->get();

        return view('guru_piket.jadwal_hari_ini', compact(
            'jadwals',
            'ringkasanPerKelas',
            'kelasList',
            'mapelList',
            'guruList',
            'stats',
            'tanggalFilter',
            'idKelasFilter',
            'idMapelFilter',
            'idGuruFilter',
            'statusFilter',
            'search',
            'hariFilter',
            'isToday',
            'isPast',
            'isFuture',
            'currentTimeStr',
            'penugasanMap',
            'guruTidakHadirCount',
            'guruPenggantiCount',
            'guruIzinList'
        ));
    }

    /**
     * Halaman Rekap Kehadiran Guru
     */
    /**
     * Helper to process rekap kehadiran rows and stats
     */
    private function getRekapKehadiranData(Request $request)
    {
        $todayDate = Carbon::now('Asia/Jakarta')->toDateString();
        $tanggalFilter = $request->input('tanggal', $todayDate);
        $search = trim($request->input('q', ''));
        $idGuruFilter = $request->input('id_guru');
        $idMapelFilter = $request->input('id_mapel');
        $idKelasFilter = $request->input('id_kelas');
        $statusFilter = $request->input('status_filter');

        // Mapping hari dalam Bahasa Indonesia
        $cDate = Carbon::parse($tanggalFilter);
        $hariMap = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hariFilter = $hariMap[$cDate->format('l')] ?? 'Senin';

        // 1. Ambil seluruh jadwal pada hari tersebut dari database
        $allJadwals = Jadwal::with(['guru', 'mapel', 'kelas', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->where('hari', $hariFilter)
            ->orderBy('id_jam_mulai', 'asc')
            ->orderBy('id_kelas', 'asc')
            ->get();

        // 2. Ambil data Guru Izin yang disetujui / aktif pada tanggal tersebut
        $guruIzinList = GuruIzin::with('guru')
            ->whereDate('tanggal_mulai', '<=', $tanggalFilter)
            ->whereDate('tanggal_selesai', '>=', $tanggalFilter)
            ->where(function($q) {
                $q->where(function($sub) {
                    $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                        ->whereIn('status_kepsek', ['approved', 'Disetujui']);
                })
                ->orWhereIn('status_final', ['approved', 'Disetujui'])
                ->orWhereIn('status_piket', ['approved', 'Disetujui']);
            })
            ->get()
            ->keyBy('id_guru');

        // 3. Ambil data Penugasan Guru Pengganti aktif pada tanggal tersebut
        $penugasanPenggantiList = PenugasanGuruPengganti::with(['guruPengganti', 'guruTidakHadir', 'jadwal'])
            ->whereDate('tanggal', $tanggalFilter)
            ->get();

        // 4. Ambil data Jurnal Mengajar pada tanggal tersebut
        $jurnalMengajarList = JurnalMengajar::with(['guruPengganti', 'jadwal.guru'])
            ->whereDate('tanggal', $tanggalFilter)
            ->get()
            ->keyBy('id_jadwal');

        // 5. Proses setiap baris jadwal dan kalkulasi statistik presensi
        $processedRows = collect();
        $counter = 1;

        $statHadir = 0;
        $statIzin = 0;
        $statTidakHadir = 0;
        $statDigantikan = 0;

        foreach ($allJadwals as $jadwal) {
            $penugasan = $penugasanPenggantiList->first(function($p) use ($jadwal) {
                return ($p->id_jadwal && $p->id_jadwal == $jadwal->id_jadwal) || 
                       ($p->id_guru_tidak_hadir == $jadwal->id_guru && $p->id_kelas == $jadwal->id_kelas);
            });
            $guruIzin = $guruIzinList->get($jadwal->id_guru);
            $jurnal = $jurnalMengajarList->get($jadwal->id_jadwal);

            // Format jam & sesi
            $jamKeText = 'Jam ke ' . ($jadwal->id_jam_mulai ?? 1) . ($jadwal->id_jam_selesai && $jadwal->id_jam_selesai != $jadwal->id_jam_mulai ? ' - ' . $jadwal->id_jam_selesai : '');
            $waktuMulai = $jadwal->waktu_mulai_effective ?? '07:00';
            $waktuSelesai = $jadwal->waktu_selesai_effective ?? '08:30';
            $jamMengajarFormatted = substr($waktuMulai, 0, 5) . ' - ' . substr($waktuSelesai, 0, 5);

            // Logika penentuan status kehadiran
            $statusTeks = 'Hadir';
            $statusKey = 'hadir';
            $keterangan = '-';
            $guruPenggantiNama = null;

            if ($penugasan && $penugasan->guruPengganti) {
                $statusTeks = 'Digantikan';
                $statusKey = 'digantikan';
                $guruPenggantiNama = $penugasan->guruPengganti->nama_guru;
                $keterangan = 'Digantikan oleh: ' . $guruPenggantiNama . ($guruIzin ? ' (' . ($guruIzin->kategori_izin ?: 'Izin') . ')' : '');
                $statDigantikan++;
            } elseif ($jurnal && $jurnal->id_guru_pengganti && $jurnal->guruPengganti) {
                $statusTeks = 'Digantikan';
                $statusKey = 'digantikan';
                $guruPenggantiNama = $jurnal->guruPengganti->nama_guru;
                $keterangan = 'Digantikan oleh: ' . $guruPenggantiNama;
                $statDigantikan++;
            } elseif ($guruIzin) {
                $kategori = strtolower($guruIzin->kategori_izin ?: $guruIzin->alasan ?: 'izin');
                if (str_contains($kategori, 'sakit') || str_contains($kategori, 'alpa')) {
                    $statusTeks = 'Tidak Hadir';
                    $statusKey = 'tidak_hadir';
                    $keterangan = ($guruIzin->kategori_izin ?: 'Sakit') . ($guruIzin->alasan ? ': ' . $guruIzin->alasan : '');
                    $statTidakHadir++;
                } else {
                    $statusTeks = 'Izin';
                    $statusKey = 'izin';
                    $keterangan = ($guruIzin->kategori_izin ?: 'Izin') . ($guruIzin->alasan ? ': ' . $guruIzin->alasan : '');
                    $statIzin++;
                }
            } elseif ($jurnal && $jurnal->status_kehadiran_guru && $jurnal->status_kehadiran_guru !== 'Hadir') {
                if (in_array($jurnal->status_kehadiran_guru, ['Sakit', 'Tanpa Keterangan'])) {
                    $statusTeks = 'Tidak Hadir';
                    $statusKey = 'tidak_hadir';
                    $keterangan = $jurnal->status_kehadiran_guru . ($jurnal->catatan_kbm ? ': ' . $jurnal->catatan_kbm : '');
                    $statTidakHadir++;
                } else {
                    $statusTeks = 'Izin';
                    $statusKey = 'izin';
                    $keterangan = 'Izin' . ($jurnal->catatan_kbm ? ': ' . $jurnal->catatan_kbm : '');
                    $statIzin++;
                }
            } else {
                $statusTeks = 'Hadir';
                $statusKey = 'hadir';
                $keterangan = ($jurnal && $jurnal->catatan_kbm) ? $jurnal->catatan_kbm : '-';
                $statHadir++;
            }

            $item = (object)[
                'no'                   => $counter++,
                'id_jadwal'            => $jadwal->id_jadwal,
                'id_guru'              => $jadwal->id_guru,
                'guru_nama'            => $jadwal->guru->nama_guru ?? 'Guru Pengampu',
                'guru_nip'             => $jadwal->guru->nip ?? '-',
                'id_mapel'             => $jadwal->id_mapel,
                'mapel_nama'           => $jadwal->mapel->nama_mapel ?? 'Mata Pelajaran',
                'id_kelas'             => $jadwal->id_kelas,
                'kelas_nama'           => $jadwal->kelas->nama_kelas ?? 'Kelas',
                'ruangan_nama'         => $jadwal->ruangan->nama_ruangan ?? 'Ruang Kelas',
                'jam_ke'               => $jamKeText,
                'jam'                  => $jamMengajarFormatted,
                'status_teks'          => $statusTeks,
                'status_key'           => $statusKey,
                'keterangan'           => $keterangan,
                'guru_pengganti_nama'  => $guruPenggantiNama,
                'has_jurnal'           => $jurnal ? true : false,
                'jurnal'               => $jurnal,
                'materi'               => $jurnal->materi ?? ($penugasan->materi_dititipkan ?? '-'),
            ];

            $processedRows->push($item);
        }

        $stats = [
            'total'      => $allJadwals->count(),
            'hadir'      => $statHadir,
            'izin'       => $statIzin,
            'tidakHadir' => $statTidakHadir,
            'digantikan' => $statDigantikan,
        ];

        // Rekap Siswa Terkait pada Tanggal Tersebut
        $qTelat  = trim($request->input('q_telat', ''));
        $qDispen = trim($request->input('q_dispen', ''));
        $qSurat  = trim($request->input('q_surat', ''));
        $activeTab = $request->input('tab', 'guru');

        $siswaTelatQuery = SiswaTelat::with(['siswa', 'kelas'])
            ->whereDate('tanggal', $tanggalFilter);

        $siswaDispenQuery = SiswaDispen::with(['siswa', 'kelas'])
            ->whereDate('tanggal', $tanggalFilter);

        $siswaSuratIzinQuery = SiswaSuratIzin::with(['siswa', 'kelas'])
            ->whereDate('tanggal', '<=', $tanggalFilter)
            ->where(function($q) use ($tanggalFilter) {
                $q->where(function($sub) use ($tanggalFilter) {
                    $sub->whereNotNull('tanggal_selesai')
                        ->whereDate('tanggal_selesai', '>=', $tanggalFilter);
                })
                ->orWhere(function($sub) use ($tanggalFilter) {
                    $sub->whereNull('tanggal_selesai')
                        ->whereDate('tanggal', '>=', $tanggalFilter);
                });
            });

        if ($idKelasFilter) {
            $siswaTelatQuery->where(function($q) use ($idKelasFilter) {
                $q->where('id_kelas', $idKelasFilter)->orWhereHas('siswa', function($s) use ($idKelasFilter) {
                    $s->where('id_kelas', $idKelasFilter);
                });
            });
            $siswaDispenQuery->where(function($q) use ($idKelasFilter) {
                $q->where('id_kelas', $idKelasFilter)->orWhereHas('siswa', function($s) use ($idKelasFilter) {
                    $s->where('id_kelas', $idKelasFilter);
                });
            });
            $siswaSuratIzinQuery->where(function($q) use ($idKelasFilter) {
                $q->where('id_kelas', $idKelasFilter)->orWhereHas('siswa', function($s) use ($idKelasFilter) {
                    $s->where('id_kelas', $idKelasFilter);
                });
            });
        }

        $searchTelat = $qTelat ?: ($activeTab === 'siswa' ? $search : '');
        if ($searchTelat) {
            $siswaTelatQuery->where(function($q) use ($searchTelat) {
                $q->whereHas('siswa', function($s) use ($searchTelat) {
                    $s->where('nama_siswa', 'LIKE', "%{$searchTelat}%")
                      ->orWhere('nisn', 'LIKE', "%{$searchTelat}%")
                      ->orWhere('nis', 'LIKE', "%{$searchTelat}%");
                })
                ->orWhere('alasan', 'LIKE', "%{$searchTelat}%")
                ->orWhere('tindakan_hukuman', 'LIKE', "%{$searchTelat}%")
                ->orWhere('jam_terlambat', 'LIKE', "%{$searchTelat}%");
            });
        }

        $searchDispen = $qDispen ?: ($activeTab === 'siswa' ? $search : '');
        if ($searchDispen) {
            $siswaDispenQuery->where(function($q) use ($searchDispen) {
                $q->whereHas('siswa', function($s) use ($searchDispen) {
                    $s->where('nama_siswa', 'LIKE', "%{$searchDispen}%")
                      ->orWhere('nisn', 'LIKE', "%{$searchDispen}%")
                      ->orWhere('nis', 'LIKE', "%{$searchDispen}%");
                })
                ->orWhere('alasan', 'LIKE', "%{$searchDispen}%")
                ->orWhere('tempat', 'LIKE', "%{$searchDispen}%")
                ->orWhere('kode_dispen', 'LIKE', "%{$searchDispen}%");
            });
        }

        $searchSurat = $qSurat ?: ($activeTab === 'siswa' ? $search : '');
        if ($searchSurat) {
            $siswaSuratIzinQuery->where(function($q) use ($searchSurat) {
                $q->whereHas('siswa', function($s) use ($searchSurat) {
                    $s->where('nama_siswa', 'LIKE', "%{$searchSurat}%")
                      ->orWhere('nisn', 'LIKE', "%{$searchSurat}%")
                      ->orWhere('nis', 'LIKE', "%{$searchSurat}%");
                })
                ->orWhere('kategori', 'LIKE', "%{$searchSurat}%")
                ->orWhere('keterangan', 'LIKE', "%{$searchSurat}%");
            });
        }

        $siswaTelatList = $siswaTelatQuery->orderBy('id_siswa_telat', 'desc')->get();
        $siswaDispenList = $siswaDispenQuery->orderBy('id_siswa_dispen', 'desc')->get();
        $siswaSuratIzinList = $siswaSuratIzinQuery->orderBy('id_surat_izin', 'desc')->get();

        $siswaStats = [
            'telat'     => $siswaTelatList->count(),
            'dispen'    => $siswaDispenList->count(),
            'suratIzin' => $siswaSuratIzinList->count(),
        ];

        // Verifikasi Tanda Tangan Guru Piket Hari Ini
        $verifikasiPiket = VerifikasiJurnalPiket::whereDate('tanggal', $tanggalFilter)->first();

        return [
            'allRows'            => $processedRows,
            'stats'              => $stats,
            'siswaStats'         => $siswaStats,
            'siswaTelatList'     => $siswaTelatList,
            'siswaDispenList'    => $siswaDispenList,
            'siswaSuratIzinList' => $siswaSuratIzinList,
            'tanggalFilter'      => $tanggalFilter,
            'hariFilter'         => $hariFilter,
            'search'             => $search,
            'qTelat'             => $qTelat,
            'qDispen'            => $qDispen,
            'qSurat'             => $qSurat,
            'idGuruFilter'       => $idGuruFilter,
            'idMapelFilter'      => $idMapelFilter,
            'idKelasFilter'      => $idKelasFilter,
            'statusFilter'       => $statusFilter,
            'todayDate'          => $todayDate,
            'verifikasiPiket'    => $verifikasiPiket,
            'activeTab'          => $request->input('tab', 'guru'),
        ];
    }

    /**
     * Halaman Rekap Kehadiran Guru & Siswa
     */
    public function rekapKehadiran(Request $request)
    {
        $data = $this->getRekapKehadiranData($request);

        $allRows = $data['allRows'];
        $stats = $data['stats'];
        $tanggalFilter = $data['tanggalFilter'];
        $hariFilter = $data['hariFilter'];
        $search = $data['search'];
        $qTelat = $data['qTelat'];
        $qDispen = $data['qDispen'];
        $qSurat = $data['qSurat'];
        $idGuruFilter = $data['idGuruFilter'];
        $idMapelFilter = $data['idMapelFilter'];
        $idKelasFilter = $data['idKelasFilter'];
        $statusFilter = $data['statusFilter'];
        $todayDate = $data['todayDate'];
        $siswaStats = $data['siswaStats'];
        $siswaTelatList = $data['siswaTelatList'];
        $siswaDispenList = $data['siswaDispenList'];
        $siswaSuratIzinList = $data['siswaSuratIzinList'];
        $verifikasiPiket = $data['verifikasiPiket'];
        $activeTab = $data['activeTab'];

        // Filter koleksi berdasarkan input pencarian & dropdown filter
        $filteredRows = $allRows->filter(function($row) use ($search, $idGuruFilter, $idMapelFilter, $idKelasFilter, $statusFilter) {
            if ($idGuruFilter && $row->id_guru != $idGuruFilter) return false;
            if ($idMapelFilter && $row->id_mapel != $idMapelFilter) return false;
            if ($idKelasFilter && $row->id_kelas != $idKelasFilter) return false;
            if ($statusFilter && $row->status_key != $statusFilter) return false;
            if ($search) {
                $needle = strtolower($search);
                $haystack = strtolower($row->guru_nama . ' ' . $row->mapel_nama . ' ' . $row->kelas_nama . ' ' . $row->ruangan_nama . ' ' . $row->keterangan . ' ' . ($row->guru_pengganti_nama ?? ''));
                if (!str_contains($haystack, $needle)) return false;
            }
            return true;
        })->values();

        // Pagination menggunakan LengthAwarePaginator (15 item per halaman)
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $currentItems = $filteredRows->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $kehadiranList = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $filteredRows->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Master lists untuk dropdown filter
        $guruList  = Guru::orderBy('nama_guru')->get();
        $mapelList = Mapel::orderBy('nama_mapel')->get();
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('guru_piket.rekap_kehadiran', compact(
            'kehadiranList',
            'guruList',
            'mapelList',
            'kelasList',
            'stats',
            'siswaStats',
            'siswaTelatList',
            'siswaDispenList',
            'siswaSuratIzinList',
            'search',
            'qTelat',
            'qDispen',
            'qSurat',
            'tanggalFilter',
            'hariFilter',
            'idGuruFilter',
            'idMapelFilter',
            'idKelasFilter',
            'statusFilter',
            'todayDate',
            'verifikasiPiket',
            'activeTab'
        ));
    }

    /**
     * Export Rekap Kehadiran to CSV (100% Real Database)
     */
    public function exportRekapKehadiranCsv(Request $request)
    {
        $data = $this->getRekapKehadiranData($request);
        $allRows = $data['allRows'];
        $search = $data['search'];
        $idGuruFilter = $data['idGuruFilter'];
        $idMapelFilter = $data['idMapelFilter'];
        $idKelasFilter = $data['idKelasFilter'];
        $statusFilter = $data['statusFilter'];
        $tanggalFilter = $data['tanggalFilter'];
        $hariFilter = $data['hariFilter'];
        $siswaTelatList = $data['siswaTelatList'];
        $siswaDispenList = $data['siswaDispenList'];
        $siswaSuratIzinList = $data['siswaSuratIzinList'];

        // Terapkan filter yang sama
        $filteredRows = $allRows->filter(function($row) use ($search, $idGuruFilter, $idMapelFilter, $idKelasFilter, $statusFilter) {
            if ($idGuruFilter && $row->id_guru != $idGuruFilter) return false;
            if ($idMapelFilter && $row->id_mapel != $idMapelFilter) return false;
            if ($idKelasFilter && $row->id_kelas != $idKelasFilter) return false;
            if ($statusFilter && $row->status_key != $statusFilter) return false;
            if ($search) {
                $needle = strtolower($search);
                $haystack = strtolower($row->guru_nama . ' ' . $row->mapel_nama . ' ' . $row->kelas_nama . ' ' . $row->ruangan_nama . ' ' . $row->keterangan . ' ' . ($row->guru_pengganti_nama ?? ''));
                if (!str_contains($haystack, $needle)) return false;
            }
            return true;
        })->values();

        $filename = "rekap_kehadiran_guru_dan_siswa_" . $tanggalFilter . "_" . date('His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($filteredRows, $tanggalFilter, $hariFilter, $siswaTelatList, $siswaDispenList, $siswaSuratIzinList) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM
            fputcsv($file, ['REKAPITULASI KEHADIRAN GURU & SESI KBM — SMKN 1 BOYOLANGU']);
            fputcsv($file, ['Tanggal', $tanggalFilter, 'Hari', $hariFilter]);
            fputcsv($file, []);
            fputcsv($file, ['BAGIAN 1: REKAP PRESENSI GURU & SESI KBM']);
            fputcsv($file, ['No', 'Nama Guru', 'NIP', 'Mata Pelajaran', 'Kelas', 'Ruangan', 'Sesi Jam', 'Waktu Mengajar', 'Status Kehadiran', 'Guru Pengganti', 'Keterangan']);

            $no = 1;
            foreach ($filteredRows as $r) {
                fputcsv($file, [
                    $no++,
                    $r->guru_nama,
                    $r->guru_nip,
                    $r->mapel_nama,
                    $r->kelas_nama,
                    $r->ruangan_nama,
                    $r->jam_ke,
                    $r->jam,
                    $r->status_teks,
                    $r->guru_pengganti_nama ?? '-',
                    $r->keterangan,
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['BAGIAN 2: LOG SISWA TERLAMBAT']);
            fputcsv($file, ['No', 'Nama Siswa', 'Kelas', 'Jam Masuk', 'Alasan Terlambat', 'Tindakan / Sanksi']);
            $noS = 1;
            foreach ($siswaTelatList as $st) {
                fputcsv($file, [
                    $noS++,
                    $st->siswa->nama_siswa ?? 'Siswa',
                    $st->kelas->nama_kelas ?? ($st->siswa->kelas->nama_kelas ?? '-'),
                    $st->jam_masuk ?? '-',
                    $st->alasan ?? '-',
                    $st->tindakan ?? 'Diberi Izin Masuk'
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['BAGIAN 3: LOG SISWA DISPENSASI']);
            fputcsv($file, ['No', 'Nama Siswa', 'Kelas', 'Kegiatan Dispensasi', 'Waktu Dispensasi', 'Status Approval']);
            $noD = 1;
            foreach ($siswaDispenList as $sd) {
                fputcsv($file, [
                    $noD++,
                    $sd->siswa->nama_siswa ?? 'Siswa',
                    $sd->kelas->nama_kelas ?? ($sd->siswa->kelas->nama_kelas ?? '-'),
                    $sd->alasan ?? ($sd->tempat ?? '-'),
                    $sd->tanggal . ' (' . ($sd->jam_keluar ?? '07:00') . ' - ' . ($sd->jam_kembali ?? 'Selesai') . ')',
                    $sd->status_waka ?? 'Approved'
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['BAGIAN 4: LOG SURAT IZIN SISWA']);
            fputcsv($file, ['No', 'Nama Siswa', 'Kelas', 'Kategori Izin', 'Rentang Tanggal', 'Keterangan', 'Status Verification']);
            $noI = 1;
            foreach ($siswaSuratIzinList as $si) {
                fputcsv($file, [
                    $noI++,
                    $si->siswa->nama_siswa ?? 'Siswa',
                    $si->kelas->nama_kelas ?? ($si->siswa->kelas->nama_kelas ?? '-'),
                    $si->kategori ?? 'Izin',
                    $si->rentang_tanggal_text,
                    $si->keterangan ?? '-',
                    $si->status ?? 'Terverifikasi'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak Rekap Kehadiran View (100% Real Database)
     */
    public function printRekapKehadiran(Request $request)
    {
        $data = $this->getRekapKehadiranData($request);
        $allRows = $data['allRows'];
        $stats = $data['stats'];
        $search = $data['search'];
        $idGuruFilter = $data['idGuruFilter'];
        $idMapelFilter = $data['idMapelFilter'];
        $idKelasFilter = $data['idKelasFilter'];
        $statusFilter = $data['statusFilter'];
        $tanggalFilter = $data['tanggalFilter'];
        $hariFilter = $data['hariFilter'];
        $todayDate = $data['todayDate'];
        $siswaTelatList = $data['siswaTelatList'];
        $siswaDispenList = $data['siswaDispenList'];
        $siswaSuratIzinList = $data['siswaSuratIzinList'];
        $siswaStats = $data['siswaStats'];

        // Terapkan filter yang sama
        $filteredRows = $allRows->filter(function($row) use ($search, $idGuruFilter, $idMapelFilter, $idKelasFilter, $statusFilter) {
            if ($idGuruFilter && $row->id_guru != $idGuruFilter) return false;
            if ($idMapelFilter && $row->id_mapel != $idMapelFilter) return false;
            if ($idKelasFilter && $row->id_kelas != $idKelasFilter) return false;
            if ($statusFilter && $row->status_key != $statusFilter) return false;
            if ($search) {
                $needle = strtolower($search);
                $haystack = strtolower($row->guru_nama . ' ' . $row->mapel_nama . ' ' . $row->kelas_nama . ' ' . $row->ruangan_nama . ' ' . $row->keterangan . ' ' . ($row->guru_pengganti_nama ?? ''));
                if (!str_contains($haystack, $needle)) return false;
            }
            return true;
        })->values();

        // Verifikasi Tanda Tangan Guru Piket
        $verifikasiPiket = VerifikasiJurnalPiket::whereDate('tanggal', $tanggalFilter)->first();

        // Petugas Piket aktif
        $petugasPiketUser = auth()->user();
        $petugasPiketNama = $verifikasiPiket->nama_guru_piket ?? ($petugasPiketUser->guru->nama_guru ?? ($petugasPiketUser->name ?? 'Petugas Piket'));
        $petugasPiketNip  = $verifikasiPiket->nip_guru_piket ?? ($petugasPiketUser->nip ?? ($petugasPiketUser->guru->nip ?? '-'));

        return view('guru_piket.rekap_kehadiran_print', [
            'kehadiranList'      => $filteredRows,
            'stats'              => $stats,
            'siswaStats'         => $siswaStats,
            'siswaTelatList'     => $siswaTelatList,
            'siswaDispenList'    => $siswaDispenList,
            'siswaSuratIzinList' => $siswaSuratIzinList,
            'tanggalFilter'      => $tanggalFilter,
            'hariFilter'         => $hariFilter,
            'todayDate'          => $todayDate,
            'verifikasiPiket'  => $verifikasiPiket,
            'petugasPiketNama' => $petugasPiketNama,
            'petugasPiketNip'  => $petugasPiketNip,
        ]);
    }

    /**
     * Halaman Pengumuman Guru Piket
     */
    /**
     * Halaman Pengumuman Guru Piket
     */


    /**
     * Halaman Pengisian Jurnal & Presensi Siswa untuk Guru Piket (Status Aktif Guru Pengganti)
     */
    public function isiJurnalPengganti(Request $request)
    {
        $user = Auth::user();
        $todayDate = Carbon::now('Asia/Jakarta')->toDateString();

        // Cari ID Guru dari user
        $idGuru = $user->id_guru ?? null;
        if (!$idGuru && $user && $user->nip) {
            $guru = Guru::where('nip', $user->nip)->first();
            if ($guru) $idGuru = $guru->id_guru;
        }

        $activePenugasans = collect();
        if ($idGuru) {
            $activePenugasans = PenugasanGuruPengganti::with([
                'guruTidakHadir.mapel',
                'guruPengganti',
                'kelas',
                'jadwal.mapel',
                'jadwal.kelas',
                'jadwal.ruangan',
                'jadwal.jamMulai',
                'jadwal.jamSelesai'
            ])
            ->where('id_guru_pengganti', $idGuru)
            ->where('status', 'aktif')
            ->whereDate('tanggal', $todayDate)
            ->get();
        }

        $selectedId = $request->input('id_penugasan');
        $selectedPenugasan = null;
        if ($selectedId) {
            $selectedPenugasan = $activePenugasans->firstWhere('id_penugasan', $selectedId);
        }
        if (!$selectedPenugasan) {
            $selectedPenugasan = $activePenugasans->first();
        }

        // Ambil siswa untuk kelas penugasan terpilih
        $siswas = collect();
        if ($selectedPenugasan && $selectedPenugasan->id_kelas) {
            $siswas = Siswa::where('id_kelas', $selectedPenugasan->id_kelas)
                ->orderBy('nama_siswa', 'asc')
                ->get();
        }

        // Fallback siswa jika tabel siswa kosong
        if ($selectedPenugasan && $siswas->isEmpty()) {
            $idK = $selectedPenugasan->id_kelas ?? 1;
            $mockSiswas = [
                ['nis' => '23081', 'nisn' => '2308144340', 'nama_siswa' => 'Aurora Natasya', 'jenis_kelamin' => 'P', 'id_kelas' => $idK],
                ['nis' => '23082', 'nisn' => '2308211976', 'nama_siswa' => 'Carmenita Anasheila', 'jenis_kelamin' => 'P', 'id_kelas' => $idK],
                ['nis' => '23083', 'nisn' => '2308374350', 'nama_siswa' => 'Stella Reihanna', 'jenis_kelamin' => 'P', 'id_kelas' => $idK],
                ['nis' => '23084', 'nisn' => '2308452908', 'nama_siswa' => 'Jamaica Arkael', 'jenis_kelamin' => 'L', 'id_kelas' => $idK],
                ['nis' => '23085', 'nisn' => '2308561829', 'nama_siswa' => 'M. Rizky Pratama', 'jenis_kelamin' => 'L', 'id_kelas' => $idK],
            ];
            foreach ($mockSiswas as $sData) {
                Siswa::firstOrCreate(['nisn' => $sData['nisn']], $sData);
            }
            $siswas = Siswa::where('id_kelas', $idK)->orderBy('nama_siswa', 'asc')->get();
        }

        // Cek jurnal existing jika sudah pernah diisi
        $jurnalExisting = null;
        if ($selectedPenugasan) {
            $jurnalExisting = JurnalMengajar::with('detailKetidakhadiran')
                ->whereDate('tanggal', $selectedPenugasan->tanggal)
                ->where(function($q) use ($selectedPenugasan) {
                    if ($selectedPenugasan->id_jadwal) {
                        $q->where('id_jadwal', $selectedPenugasan->id_jadwal);
                    } else {
                        $q->where('id_guru_pengganti', $selectedPenugasan->id_guru_pengganti);
                    }
                })
                ->first();
        }

        return view('guru_piket.isi_jurnal_pengganti', compact(
            'activePenugasans',
            'selectedPenugasan',
            'siswas',
            'jurnalExisting',
            'todayDate'
        ));
    }

    /**
     * Simpan Jurnal & Presensi Siswa oleh Guru Piket yang Menjadi Guru Pengganti
     */
    public function simpanJurnalPengganti(Request $request)
    {
        $request->validate([
            'id_penugasan' => 'required|exists:penugasan_guru_pengganti,id_penugasan',
            'materi'       => 'required|string',
            'pertemuan_ke' => 'nullable|string',
            'catatan'      => 'nullable|string',
            'kondisi_kelas'=> 'nullable|string',
            'absensi'      => 'nullable|array',
        ], [
            'materi.required' => 'Materi pembelajaran wajib diisi!',
        ]);

        $penugasan = PenugasanGuruPengganti::with('jadwal')->findOrFail($request->id_penugasan);

        // System / Alur Logika Time Gating:
        // Cek apakah sudah memasuki jam pelajaran
        if (!$penugasan->sudah_masuk_jam) {
            return redirect()->back()->withInput()->with('error', "Peringatan Time-Gating: Jurnal & Presensi belum dapat diisi/disimpan karena belum memasuki jam pelajaran (Dimulai pukul {$penugasan->waktu_mulai_effective} WIB).");
        }

        $idJadwal = $penugasan->id_jadwal;
        if (!$idJadwal && $penugasan->id_kelas && $penugasan->id_guru_tidak_hadir) {
            $foundJadwal = Jadwal::where('id_guru', $penugasan->id_guru_tidak_hadir)
                ->where('id_kelas', $penugasan->id_kelas)
                ->first();
            if ($foundJadwal) {
                $idJadwal = $foundJadwal->id_jadwal;
            }
        }

        if (!$idJadwal) {
            $idJadwal = Jadwal::first()->id_jadwal ?? 1;
        }

        // Simpan / update JurnalMengajar
        $jurnal = JurnalMengajar::updateOrCreate(
            [
                'id_jadwal' => $idJadwal,
                'tanggal'   => $penugasan->tanggal,
            ],
            [
                'id_guru_pengganti'     => $penugasan->id_guru_pengganti,
                'materi'                => $request->materi,
                'pertemuan_ke'          => $request->pertemuan_ke ?? 'Ke-1',
                'status_kehadiran_guru' => 'Hadir',
                'catatan'               => $request->catatan,
                'kondisi_kelas'         => $request->kondisi_kelas ?? 'Kondusif',
                'is_draft'              => false,
                'dicatat_pada'          => now(),
            ]
        );

        // Simpan Detail Presensi Siswa jika ada status selain Hadir (Sakit, Izin, Alpa, Dispen)
        if ($request->has('absensi') && is_array($request->absensi)) {
            foreach ($request->absensi as $idSiswa => $status) {
                if (in_array($status, ['Sakit', 'Izin', 'Alpa', 'Dispen'])) {
                    $siswaObj = Siswa::find($idSiswa) ?? Siswa::first();
                    if ($siswaObj) {
                        JurnalDetailKetidakhadiran::updateOrCreate(
                            [
                                'id_jurnal' => $jurnal->id_jurnal,
                                'id_siswa'  => $siswaObj->id_siswa,
                            ],
                            [
                                'keterangan' => $status === 'Dispen' ? 'Izin' : $status,
                            ]
                        );
                    }
                } else {
                    JurnalDetailKetidakhadiran::where('id_jurnal', $jurnal->id_jurnal)
                        ->where('id_siswa', $idSiswa)
                        ->delete();
                }
            }
        }

        // Perbarui status penugasan guru pengganti
        $penugasan->update(['status' => 'selesai']);

        return redirect()->route('piket.isi-jurnal-pengganti', ['id_penugasan' => $penugasan->id_penugasan])
            ->with('success', 'Jurnal Mengajar & Presensi Siswa sebagai Guru Pengganti berhasil disimpan dan tersinkronisasi!');
    }

    /**
     * [READ] Tampilkan Halaman Permintaan Izin Guru (Guru Piket) dengan Filter & Search
     */
    /**
     * [READ] Tampilkan Halaman Permintaan Izin Guru (Guru Piket) dengan Filter & Search
     */
    public function permintaanIzin(Request $request)
    {
        $this->ensureGuruIzinColumnsExist();
        $guruList = Guru::orderBy('nama_guru', 'asc')->get();

        // Ambil Pengajuan Baru dari Guru Mengajar yang belum diproses piket
        $pendingRequests = GuruIzin::with('guru')
            ->where('is_pengajuan_guru', 1)
            ->where('status_piket', 'pending')
            ->orderBy('id_guru_izin', 'desc')
            ->get();

        // Main Query (Daftar Izin yang sudah diproses atau dibuat piket)
        $query = GuruIzin::with(['guru', 'guruPiket'])->where(function($q) {
            $q->where('is_pengajuan_guru', 0)
              ->orWhere('status_piket', '!=', 'pending');
        });

        // Pencarian Keyword (Nama Guru, NIP, Alasan)
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function($q) use ($keyword) {
                $q->whereHas('guru', function($g) use ($keyword) {
                    $g->where('nama_guru', 'LIKE', "%{$keyword}%")
                      ->orWhere('nip', 'LIKE', "%{$keyword}%");
                })->orWhere('alasan', 'LIKE', "%{$keyword}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $st = $request->status;
            if (in_array($st, ['pending', 'approved', 'rejected'])) {
                $query->where(function($q) use ($st) {
                    $q->where('status_waka', $st)
                      ->orWhere('status_kepsek', $st)
                      ->orWhere('status_final', $st);
                });
            }
        }

        // Filter Tanggal
        if ($request->filled('tanggal')) {
            $tgl = $request->tanggal;
            $query->where(function($q) use ($tgl) {
                $q->whereDate('tanggal_mulai', '<=', $tgl)
                  ->whereDate('tanggal_selesai', '>=', $tgl);
            });
        }

        $guruIzinList = $query->orderBy('id_guru_izin', 'desc')->get();
        $trashedCount = GuruIzin::onlyTrashed()->count();

        return view('guru_piket.permintaan_izin', compact('guruList', 'guruIzinList', 'trashedCount', 'pendingRequests'));
    }

    /**
     * Helper auto-heal schema jika kolom baru belum ada di MySQL live
     */
    private function ensureGuruIzinColumnsExist()
    {
        try {
            if (!Schema::hasColumn('guru_izin', 'kategori_izin')) {
                DB::statement("ALTER TABLE `guru_izin` ADD `kategori_izin` ENUM('biasa', 'cuti') NOT NULL DEFAULT 'biasa' AFTER `durasi` ");
            }
            if (!Schema::hasColumn('guru_izin', 'keterangan_khusus')) {
                DB::statement("ALTER TABLE `guru_izin` ADD `keterangan_khusus` TEXT NULL AFTER `alasan` ");
            }
            if (!Schema::hasColumn('guru_izin', 'is_pengajuan_guru')) {
                DB::statement("ALTER TABLE `guru_izin` ADD `is_pengajuan_guru` TINYINT(1) NOT NULL DEFAULT 0 AFTER `catatan_kepsek` ");
            }
            if (!Schema::hasColumn('guru_izin', 'status_piket')) {
                DB::statement("ALTER TABLE `guru_izin` ADD `status_piket` ENUM('pending', 'diproses', 'ditolak') NOT NULL DEFAULT 'diproses' AFTER `is_pengajuan_guru` ");
            }
            if (!Schema::hasColumn('guru_izin', 'id_guru_piket')) {
                DB::statement("ALTER TABLE `guru_izin` ADD `id_guru_piket` INT NULL AFTER `status_piket` ");
            }
            if (!Schema::hasColumn('guru_izin', 'nama_guru_piket')) {
                DB::statement("ALTER TABLE `guru_izin` ADD `nama_guru_piket` VARCHAR(255) NULL AFTER `id_guru_piket` ");
            }
            if (!Schema::hasColumn('guru_izin', 'nip_guru_piket')) {
                DB::statement("ALTER TABLE `guru_izin` ADD `nip_guru_piket` VARCHAR(50) NULL AFTER `nama_guru_piket` ");
            }
        } catch (\Exception $e) {
            // Silence exception
        }
    }

    /**
     * [CREATE/PROCESS] Simpan Permintaan Izin Guru & Generate Link Approval Waka/Kepsek
     */
    public function storePermintaanIzin(Request $request)
    {
        $this->ensureGuruIzinColumnsExist();

        $user = Auth::user();
        $piketGuruId = $user->id_guru ?? null;
        $piketNama   = $user->name ?? 'Petugas Piket';
        $piketNip    = $user->nip ?? '-';

        if ($user->id_guru) {
            $gObj = Guru::find($user->id_guru);
            if ($gObj) {
                $piketNama = $gObj->nama_guru;
                $piketNip  = $gObj->nip;
            }
        }

        $request->validate([
            'id_guru'           => 'required|exists:guru,id_guru',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'nullable|date|after_or_equal:tanggal_mulai',
            'alasan'            => 'required|string',
            'materi_dititipkan' => 'nullable|string',
            'tugas_dititipkan'  => 'nullable|string',
            'file_tugas'        => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png,zip|max:10000',
            'foto_surat'        => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'keterangan_khusus' => 'nullable|string',
        ], [
            'tanggal_selesai.after_or_equal' => 'Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin.',
        ]);

        $tglMulai   = $request->tanggal_mulai;
        $tglSelesai = $request->tanggal_selesai ?? $tglMulai;
        $diffDays   = Carbon::parse($tglMulai)->diffInDays(Carbon::parse($tglSelesai)) + 1;

        $kategoriInput = $request->input('kategori_izin', 'biasa');
        $isCuti = ($diffDays > 3 || $kategoriInput === 'cuti');

        if ($isCuti) {
            $request->validate([
                'keterangan_khusus' => 'required|string',
                'foto_surat'        => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            ], [
                'keterangan_khusus.required' => 'Keterangan khusus Cuti wajib diisi jika mengajukan izin lebih dari 3 hari.',
            ]);
            $kategoriIzin = 'cuti';
            $durasi = "Cuti / Izin Khusus ({$diffDays} Hari: " . Carbon::parse($tglMulai)->format('d/m/Y') . " s/d " . Carbon::parse($tglSelesai)->format('d/m/Y') . ")";
        } else {
            $kategoriIzin = 'biasa';
            $durasi = "{$diffDays} Hari (" . Carbon::parse($tglMulai)->format('d/m/Y') . ($tglMulai !== $tglSelesai ? " s/d " . Carbon::parse($tglSelesai)->format('d/m/Y') : "") . ")";
        }

        $idPengajuan = $request->input('id_guru_izin_pengajuan');
        $existingIzin = $idPengajuan ? GuruIzin::find($idPengajuan) : null;
        $hasExistingPhoto = $existingIzin && !empty($existingIzin->foto_surat);

        if (!$hasExistingPhoto && !$request->hasFile('foto_surat')) {
            return redirect()->back()->withErrors(['foto_surat' => 'Upload Foto Surat / Bukti Izin wajib diunggah untuk semua kategori izin.'])->withInput();
        }

        $fotoName = $existingIzin ? $existingIzin->foto_surat : null;
        if ($request->hasFile('foto_surat')) {
            $file = $request->file('foto_surat');
            $fotoName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/guru_izin'), $fotoName);
        }

        $fileName = $existingIzin ? $existingIzin->file_tugas : null;
        if ($request->hasFile('file_tugas')) {
            $fileTugas = $request->file('file_tugas');
            $fileName = time() . '_tugas_' . Str::random(8) . '.' . $fileTugas->getClientOriginalExtension();
            $fileTugas->move(public_path('uploads/tugas_pengganti'), $fileName);
        }

        if ($existingIzin) {
            $token = $existingIzin->token_approval ?: Str::random(40);
            $existingIzin->update([
                'id_guru'           => $request->id_guru,
                'tanggal_mulai'     => $tglMulai,
                'tanggal_selesai'   => $tglSelesai,
                'durasi'            => $durasi,
                'kategori_izin'     => $kategoriIzin,
                'alasan'            => $request->alasan,
                'keterangan_khusus' => $request->keterangan_khusus,
                'materi_dititipkan' => $request->materi_dititipkan,
                'tugas_dititipkan'  => $request->tugas_dititipkan,
                'file_tugas'        => $fileName,
                'foto_surat'        => $fotoName,
                'token_approval'    => $token,
                'status_piket'      => 'diproses',
                'id_guru_piket'     => $piketGuruId,
                'nama_guru_piket'   => $piketNama,
                'nip_guru_piket'    => $piketNip,
            ]);
            $izin = $existingIzin;
        } else {
            $token = Str::random(40);
            $izin = GuruIzin::create([
                'id_guru'           => $request->id_guru,
                'tanggal_mulai'     => $tglMulai,
                'tanggal_selesai'   => $tglSelesai,
                'durasi'            => $durasi,
                'kategori_izin'     => $kategoriIzin,
                'alasan'            => $request->alasan,
                'keterangan_khusus' => $request->keterangan_khusus,
                'materi_dititipkan' => $request->materi_dititipkan,
                'tugas_dititipkan'  => $request->tugas_dititipkan,
                'file_tugas'        => $fileName,
                'foto_surat'        => $fotoName,
                'token_approval'    => $token,
                'status_waka'       => 'pending',
                'status_waka_sdm'   => 'pending',
                'status_kepsek'     => 'pending',
                'status_final'      => 'pending',
                'is_pengajuan_guru' => 0,
                'status_piket'      => 'diproses',
                'id_guru_piket'     => $piketGuruId,
                'nama_guru_piket'   => $piketNama,
                'nip_guru_piket'    => $piketNip,
            ]);
        }

        $guru = Guru::find($request->id_guru);
        $namaGuru = $guru->nama_guru ?? 'Guru';
        $tglFormatted = Carbon::parse($tglMulai)->format('d-m-Y');
        if ($tglMulai !== $tglSelesai) {
            $tglFormatted .= ' s/d ' . Carbon::parse($tglSelesai)->format('d-m-Y');
        }

        $approvalUrl = url("/approval/guru-izin/{$token}");
        $waMessage = "Assalamu'alaikum Wr. Wb. Bapak/Ibu Waka Kurikulum, Waka SDM & Kepala Sekolah,\n\n"
            . "Berikut pengajuan " . ($isCuti ? "CUTI / IZIN KHUSUS (> 3 HARI)" : "IZIN TIDAK HADIR") . " mengajar:\n"
            . "• Nama Guru: {$namaGuru}\n"
            . "• Tanggal Izin: {$tglFormatted} ({$durasi})\n"
            . "• Alasan: {$request->alasan}\n";

        if ($isCuti && $request->keterangan_khusus) {
            $waMessage .= "• Keterangan Khusus Cuti: {$request->keterangan_khusus}\n";
        }

        $waMessage .= "\nMohon untuk dapat meninjau dan memilih persetujuan/penolakan melalui tautan berikut:\n\n"
            . $approvalUrl . "\n\n"
            . "Terima kasih.\n(Dikirim via Portal Guru Piket EDU JOURNAL)";

        $waUrl = "https://api.whatsapp.com/send?text=" . rawurlencode($waMessage);

        return redirect()->route('piket.permintaan-izin')->with([
            'success'      => 'Permintaan izin guru berhasil diisikan & diproses! Link persetujuan telah otomatis dibuat dan dikirim ke Waka Kurikulum, Waka SDM & Kepsek.',
            'approval_url' => $approvalUrl,
            'wa_url'       => $waUrl,
            'guru_nama'    => $namaGuru,
        ]);
    }

    /**
     * [UPDATE] Perbarui Data Permintaan Izin Guru
     */
    public function updatePermintaanIzin(Request $request, $id)
    {
        $this->ensureGuruIzinColumnsExist();
        $izin = GuruIzin::findOrFail($id);

        if (!$izin->foto_surat && !$request->hasFile('foto_surat')) {
            return redirect()->back()->withErrors(['foto_surat' => 'Upload Foto Surat / Bukti Izin wajib diunggah.'])->withInput();
        }

        $request->validate([
            'id_guru'           => 'required|exists:guru,id_guru',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'nullable|date|after_or_equal:tanggal_mulai',
            'alasan'            => 'required|string',
            'materi_dititipkan' => 'nullable|string',
            'tugas_dititipkan'  => 'nullable|string',
            'foto_surat'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
            'keterangan_khusus' => 'nullable|string',
        ]);

        $tglMulai   = $request->tanggal_mulai;
        $tglSelesai = $request->tanggal_selesai ?? $tglMulai;
        $diffDays   = Carbon::parse($tglMulai)->diffInDays(Carbon::parse($tglSelesai)) + 1;

        $kategoriInput = $request->input('kategori_izin', $izin->kategori_izin);
        $isCuti = ($diffDays > 3 || $kategoriInput === 'cuti');

        if ($isCuti) {
            $request->validate([
                'keterangan_khusus' => 'required|string',
            ], [
                'keterangan_khusus.required' => 'Keterangan khusus Cuti wajib diisi jika izin lebih dari 3 hari.',
            ]);
            $kategoriIzin = 'cuti';
            $durasi = "Cuti / Izin Khusus ({$diffDays} Hari: " . Carbon::parse($tglMulai)->format('d/m/Y') . " s/d " . Carbon::parse($tglSelesai)->format('d/m/Y') . ")";
        } else {
            $kategoriIzin = 'biasa';
            $durasi = "{$diffDays} Hari (" . Carbon::parse($tglMulai)->format('d/m/Y') . ($tglMulai !== $tglSelesai ? " s/d " . Carbon::parse($tglSelesai)->format('d/m/Y') : "") . ")";
        }

        $fotoName = $izin->foto_surat;
        if ($request->hasFile('foto_surat')) {
            if ($fotoName && file_exists(public_path('uploads/guru_izin/' . $fotoName))) {
                @unlink(public_path('uploads/guru_izin/' . $fotoName));
            }
            $file = $request->file('foto_surat');
            $fotoName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/guru_izin'), $fotoName);
        }

        $izin->update([
            'id_guru'           => $request->id_guru,
            'tanggal_mulai'     => $tglMulai,
            'tanggal_selesai'   => $tglSelesai,
            'durasi'            => $durasi,
            'kategori_izin'     => $kategoriIzin,
            'alasan'            => $request->alasan,
            'keterangan_khusus' => $request->keterangan_khusus,
            'materi_dititipkan' => $request->materi_dititipkan,
            'tugas_dititipkan'  => $request->tugas_dititipkan,
            'foto_surat'        => $fotoName,
        ]);

        return redirect()->route('piket.permintaan-izin')
            ->with('success', 'Data pengajuan izin guru berhasil diperbarui!');
    }

    /**
     * [SOFT DELETE] Hapus sementara data izin ke Sampah
     */
    public function destroyPermintaanIzin($id)
    {
        $izin = GuruIzin::findOrFail($id);
        $izin->delete();

        return redirect()->route('piket.permintaan-izin')
            ->with('success', 'Data pengajuan izin guru berhasil dipindahkan ke Sampah.');
    }

    /**
     * [BULK SOFT DELETE] Hapus Massal Data Permintaan Izin Guru ke Sampah
     */
    public function bulkDestroyPermintaanIzin(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu data permintaan izin guru yang mau dihapus.');
        }

        $count = GuruIzin::whereIn('id_guru_izin', $ids)->delete();

        return redirect()->route('piket.permintaan-izin')
            ->with('success', $count . ' data pengajuan izin guru berhasil dipindahkan ke Sampah.');
    }

    /**
     * [TRASH] Halaman Sampah Data Permintaan Izin
     */
    public function trashPermintaanIzin()
    {
        $guruIzinList = GuruIzin::onlyTrashed()
            ->with('guru')
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('guru_piket.permintaan_izin_trash', compact('guruIzinList'));
    }

    /**
     * [RESTORE] Pulihkan data dari Sampah
     */
    public function restorePermintaanIzin($id)
    {
        $izin = GuruIzin::onlyTrashed()->findOrFail($id);
        $izin->restore();

        return redirect()->route('piket.permintaan-izin.trash')
            ->with('success', 'Data pengajuan izin guru berhasil dipulihkan.');
    }

    /**
     * [FORCE DELETE] Hapus permanen data izin dari Sampah
     */
    public function forceDeletePermintaanIzin($id)
    {
        $izin = GuruIzin::onlyTrashed()->findOrFail($id);

        if ($izin->foto_surat && file_exists(public_path('uploads/guru_izin/' . $izin->foto_surat))) {
            @unlink(public_path('uploads/guru_izin/' . $izin->foto_surat));
        }

        if ($izin->file_tugas && file_exists(public_path('uploads/tugas_pengganti/' . $izin->file_tugas))) {
            @unlink(public_path('uploads/tugas_pengganti/' . $izin->file_tugas));
        }

        $izin->forceDelete();

        return redirect()->route('piket.permintaan-izin.trash')
            ->with('success', 'Data pengajuan izin guru berhasil dihapus secara permanen.');
    }

    /**
     * [EMPTY TRASH] Kosongkan seluruh data sampah izin
     */
    public function emptyTrashPermintaanIzin()
    {
        $trashed = GuruIzin::onlyTrashed()->get();
        foreach ($trashed as $iz) {
            if ($iz->foto_surat && file_exists(public_path('uploads/guru_izin/' . $iz->foto_surat))) {
                @unlink(public_path('uploads/guru_izin/' . $iz->foto_surat));
            }
            if ($iz->file_tugas && file_exists(public_path('uploads/tugas_pengganti/' . $iz->file_tugas))) {
                @unlink(public_path('uploads/tugas_pengganti/' . $iz->file_tugas));
            }
            $iz->forceDelete();
        }

        return redirect()->route('piket.permintaan-izin.trash')
            ->with('success', 'Seluruh data sampah izin guru telah berhasil dikosongkan.');
    }

    /**
     * [READ] Tampilkan Halaman Guru Izin Tidak Hadir (Resmi Disetujui Waka & Kepsek)
     */
    public function guruIzinTidakHadir(Request $request)
    {
        $todayDate = Carbon::now('Asia/Jakarta')->toDateString();

        $search = trim($request->input('q'));
        $kategoriFilter = $request->input('kategori');
        $tanggalFilter = $request->input('tanggal');
        $statusPenugasanFilter = $request->input('status_penugasan');
        $statusBerlakuFilter = $request->input('status_berlaku');

        // Query khusus perizinan yang SUDAH DISETUJU Waka & Kepsek
        $query = GuruIzin::with(['guru.mapel'])
            ->whereHas('guru', function($q) {
                $q->where('nama_guru', '!=', 'Petugas Piket');
            })
            ->where(function($q) {
                $q->where(function($sub) {
                    $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                        ->whereIn('status_kepsek', ['approved', 'Disetujui']);
                })->orWhereIn('status_final', ['approved', 'Disetujui']);
            });

        // Search Keyword (Nama Guru, NIP, Alasan)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('guru', function($g) use ($search) {
                    $g->where('nama_guru', 'LIKE', "%{$search}%")
                      ->orWhere('nip', 'LIKE', "%{$search}%");
                })->orWhere('alasan', 'LIKE', "%{$search}%")
                  ->orWhere('keterangan_khusus', 'LIKE', "%{$search}%");
            });
        }

        // Filter Kategori (biasa / cuti)
        if ($kategoriFilter) {
            $query->where('kategori_izin', $kategoriFilter);
        }

        // Filter Tanggal
        if ($tanggalFilter) {
            $query->whereDate('tanggal_mulai', '<=', $tanggalFilter)
                  ->whereDate('tanggal_selesai', '>=', $tanggalFilter);
        }

        $guruIzinApprovedList = $query->orderBy('id_guru_izin', 'desc')->get();

        // Attach info status penugasan guru pengganti, masa berlaku (Aktif/Selesai) & jadwal mengajar terdampak
        foreach ($guruIzinApprovedList as $item) {
            // Evaluasi Status Masa Berlaku (Aktif vs Selesai)
            $tglSelesai = $item->tanggal_selesai ?? $item->tanggal_mulai;
            $item->is_expired = ($tglSelesai < $todayDate);
            $item->status_masa_berlaku = $item->is_expired ? 'selesai' : 'aktif';

            // URL Foto Surat / Dokumen Izin & File Tugas
            $item->foto_url = ($item->foto_surat && file_exists(public_path('uploads/guru_izin/' . $item->foto_surat))) 
                ? asset('uploads/guru_izin/' . $item->foto_surat) 
                : null;
            $item->file_tugas_url = ($item->file_tugas && file_exists(public_path('uploads/tugas_pengganti/' . $item->file_tugas))) 
                ? asset('uploads/tugas_pengganti/' . $item->file_tugas) 
                : null;

            // Check penugasan guru pengganti aktif untuk guru ini pada rentang izin
            $penugasans = PenugasanGuruPengganti::with('guruPengganti')
                ->where('id_guru_tidak_hadir', $item->id_guru)
                ->whereDate('tanggal', '>=', $item->tanggal_mulai)
                ->whereDate('tanggal', '<=', $item->tanggal_selesai)
                ->where('status', 'aktif')
                ->get();

            $item->has_penugasan = $penugasans->isNotEmpty();
            $item->penugasans_list = $penugasans;

            // Load Jadwal Mengajar Guru ini pada hari-hari izin
            $jadwals = Jadwal::with(['kelas', 'mapel', 'jamMulai', 'jamSelesai'])
                ->where('id_guru', $item->id_guru)
                ->get();
            $item->jadwals_list = $jadwals;
        }

        // Filter Status Masa Berlaku (Aktif / Selesai)
        if ($statusBerlakuFilter === 'aktif') {
            $guruIzinApprovedList = $guruIzinApprovedList->filter(fn($i) => !$i->is_expired)->values();
        } elseif ($statusBerlakuFilter === 'selesai') {
            $guruIzinApprovedList = $guruIzinApprovedList->filter(fn($i) => $i->is_expired)->values();
        }

        // Filter Status Penugasan (Belum Ditugaskan / Sudah Ditugaskan)
        if ($statusPenugasanFilter === 'belum') {
            $guruIzinApprovedList = $guruIzinApprovedList->filter(fn($i) => !$i->has_penugasan)->values();
        } elseif ($statusPenugasanFilter === 'sudah') {
            $guruIzinApprovedList = $guruIzinApprovedList->filter(fn($i) => $i->has_penugasan)->values();
        }

        // Stat Cards Data (Berdasarkan Data Izin Disetujui)
        $totalApproved = GuruIzin::where(function($q) {
            $q->where(function($sub) {
                $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                    ->whereIn('status_kepsek', ['approved', 'Disetujui']);
            })->orWhereIn('status_final', ['approved', 'Disetujui']);
        })->count();

        $approvedHariIni = GuruIzin::where(function($q) {
            $q->where(function($sub) {
                $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                    ->whereIn('status_kepsek', ['approved', 'Disetujui']);
            })->orWhereIn('status_final', ['approved', 'Disetujui']);
        })->whereDate('tanggal_mulai', '<=', $todayDate)
          ->whereDate('tanggal_selesai', '>=', $todayDate)
          ->count();

        $totalCutiApproved = GuruIzin::where(function($q) {
            $q->where(function($sub) {
                $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                    ->whereIn('status_kepsek', ['approved', 'Disetujui']);
            })->orWhereIn('status_final', ['approved', 'Disetujui']);
        })->where('kategori_izin', 'cuti')->count();

        // Hitung berapa izin AKTIF yang belum ada penugasan guru pengganti
        $allApproved = GuruIzin::where(function($q) {
            $q->where(function($sub) {
                $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                    ->whereIn('status_kepsek', ['approved', 'Disetujui']);
            })->orWhereIn('status_final', ['approved', 'Disetujui']);
        })->whereDate('tanggal_selesai', '>=', $todayDate)->get();

        $perluPenugasanCount = 0;
        foreach ($allApproved as $aItem) {
            $assigned = PenugasanGuruPengganti::where('id_guru_tidak_hadir', $aItem->id_guru)
                ->whereDate('tanggal', '>=', $aItem->tanggal_mulai)
                ->whereDate('tanggal', '<=', $aItem->tanggal_selesai)
                ->where('status', 'aktif')
                ->exists();
            if (!$assigned) {
                $perluPenugasanCount++;
            }
        }

        $stats = [
            'totalApproved'       => $totalApproved,
            'approvedHariIni'     => $approvedHariIni,
            'totalCutiApproved'   => $totalCutiApproved,
            'perluPenugasanCount' => $perluPenugasanCount,
        ];

        $trashedCount = GuruIzin::onlyTrashed()
            ->where(function($q) {
                $q->where(function($sub) {
                    $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                        ->whereIn('status_kepsek', ['approved', 'Disetujui']);
                })->orWhereIn('status_final', ['approved', 'Disetujui']);
            })->count();

        return view('guru_piket.guru_izin_tidak_hadir', compact(
            'guruIzinApprovedList',
            'stats',
            'search',
            'kategoriFilter',
            'tanggalFilter',
            'statusPenugasanFilter',
            'statusBerlakuFilter',
            'trashedCount',
            'todayDate'
        ));
    }

    /**
     * [SOFT DELETE] Hapus data guru izin disetujui ke Sampah
     */
    public function destroyGuruIzinTidakHadir($id)
    {
        $izin = GuruIzin::findOrFail($id);
        $izin->delete();

        return redirect()->route('piket.guru-izin-tidak-hadir')
            ->with('success', 'Data guru izin tidak hadir berhasil dipindahkan ke Sampah.');
    }

    /**
     * [BULK SOFT DELETE] Hapus Massal Data Guru Izin Tidak Hadir ke Sampah
     */
    public function bulkDestroyGuruIzinTidakHadir(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu data guru izin tidak hadir yang mau dihapus.');
        }

        $count = GuruIzin::whereIn('id_guru_izin', $ids)->delete();

        return redirect()->route('piket.guru-izin-tidak-hadir')
            ->with('success', $count . ' data guru izin tidak hadir berhasil dipindahkan ke Sampah.');
    }

    /**
     * [TRASH] Halaman Sampah Data Guru Izin Tidak Hadir
     */
    public function trashGuruIzinTidakHadir()
    {
        $guruIzinList = GuruIzin::onlyTrashed()
            ->with('guru')
            ->where(function($q) {
                $q->where(function($sub) {
                    $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                        ->whereIn('status_kepsek', ['approved', 'Disetujui']);
                })->orWhereIn('status_final', ['approved', 'Disetujui']);
            })
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('guru_piket.guru_izin_tidak_hadir_trash', compact('guruIzinList'));
    }

    /**
     * [RESTORE] Pulihkan data guru izin disetujui dari Sampah
     */
    public function restoreGuruIzinTidakHadir($id)
    {
        $izin = GuruIzin::onlyTrashed()->findOrFail($id);
        $izin->restore();

        return redirect()->route('piket.guru-izin-tidak-hadir.trash')
            ->with('success', 'Data guru izin tidak hadir berhasil dipulihkan.');
    }

    /**
     * [FORCE DELETE] Hapus permanen data guru izin disetujui dari Sampah
     */
    public function forceDeleteGuruIzinTidakHadir($id)
    {
        $izin = GuruIzin::onlyTrashed()->findOrFail($id);

        if ($izin->foto_surat && file_exists(public_path('uploads/guru_izin/' . $izin->foto_surat))) {
            @unlink(public_path('uploads/guru_izin/' . $izin->foto_surat));
        }

        if ($izin->file_tugas && file_exists(public_path('uploads/tugas_pengganti/' . $izin->file_tugas))) {
            @unlink(public_path('uploads/tugas_pengganti/' . $izin->file_tugas));
        }

        $izin->forceDelete();

        return redirect()->route('piket.guru-izin-tidak-hadir.trash')
            ->with('success', 'Data guru izin tidak hadir berhasil dihapus secara permanen.');
    }

    /**
     * [EMPTY TRASH] Kosongkan seluruh data sampah guru izin disetujui
     */
    public function emptyTrashGuruIzinTidakHadir()
    {
        $trashed = GuruIzin::onlyTrashed()
            ->where(function($q) {
                $q->where(function($sub) {
                    $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                        ->whereIn('status_kepsek', ['approved', 'Disetujui']);
                })->orWhereIn('status_final', ['approved', 'Disetujui']);
            })->get();

        foreach ($trashed as $iz) {
            if ($iz->foto_surat && file_exists(public_path('uploads/guru_izin/' . $iz->foto_surat))) {
                @unlink(public_path('uploads/guru_izin/' . $iz->foto_surat));
            }
            if ($iz->file_tugas && file_exists(public_path('uploads/tugas_pengganti/' . $iz->file_tugas))) {
                @unlink(public_path('uploads/tugas_pengganti/' . $iz->file_tugas));
            }
            $iz->forceDelete();
        }

        return redirect()->route('piket.guru-izin-tidak-hadir.trash')
            ->with('success', 'Seluruh data sampah guru izin tidak hadir telah berhasil dikosongkan.');
    }

    /**
     * Fitur Halaman Dispensasi Siswa (Guru Piket)
     */
    public function dispensasiSiswa(Request $request)
    {
        $siswaList = Siswa::with('kelas.jurusan')->orderBy('nama_siswa')->get();
        $guruList  = Guru::orderBy('nama_guru')->get();
        $wakaList  = User::where('role', 'waka_kesiswaan')
            ->where(function($q) {
                $q->whereNull('status_verifikasi')->orWhere('status_verifikasi', 'verified');
            })->orderBy('name')->get();

        if ($wakaList->isEmpty()) {
            $wakaList = User::whereIn('role', ['waka_kesiswaan', 'waka'])
                ->where(function($q) {
                    $q->whereNull('status_verifikasi')->orWhere('status_verifikasi', 'verified');
                })->orderBy('name')->get();
        }

        $query = SiswaDispen::with(['siswa', 'kelas', 'wakaUser']);

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function($sub) use ($q) {
                $sub->where('kode_dispen', 'LIKE', "%{$q}%")
                    ->orWhere('alasan', 'LIKE', "%{$q}%")
                    ->orWhereHas('siswa', function($s) use ($q) {
                        $s->where('nama_siswa', 'LIKE', "%{$q}%")
                          ->orWhere('nisn', 'LIKE', "%{$q}%");
                    });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('status_waka', 'approved');
            } elseif ($request->status === 'rejected') {
                $query->where('status_waka', 'rejected');
            } elseif ($request->status === 'pending') {
                $query->where('status_waka', 'pending');
            }
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $dispenList = $query->orderBy('created_at', 'desc')->paginate(15);
        $totalPengajuan = SiswaDispen::count();

        return view('guru_piket.dispensasi_siswa', compact(
            'siswaList',
            'guruList',
            'wakaList',
            'dispenList',
            'totalPengajuan'
        ));
    }

    /**
     * Store Data Dispensasi Siswa (Guru Piket Input & Generate Link Waka)
     */
    public function storeDispensasiSiswa(Request $request)
    {
        $request->validate([
            'id_siswa'             => 'required|exists:siswa,id_siswa',
            'id_user_waka'         => 'required|exists:users,id',
            'tanggal'              => 'required|date',
            'jam_keluar'           => 'required|string',
            'jam_kembali'          => 'required|string',
            'alasan'               => 'required|string|max:500',
            'tempat'               => 'nullable|string|max:255',
            'foto_surat_dispen'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'foto_kartu_identitas' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ], [
            'id_siswa.required'             => 'Pilih siswa yang mengajukan dispensasi.',
            'id_user_waka.required'         => 'Pilih Waka tujuan untuk verifikasi dispensasi.',
            'tanggal.required'             => 'Pilih tanggal dispensasi.',
            'jam_keluar.required'          => 'Isi jam rencana keluar sekolah.',
            'jam_kembali.required'         => 'Isi jam rencana kembali ke sekolah.',
            'alasan.required'              => 'Tuliskan alasan / keperluan dispensasi siswa.',
            'foto_surat_dispen.image'      => 'Foto Surat Dispensasi Resmi harus berupa file gambar (JPG, PNG, WEBP).',
            'foto_kartu_identitas.image'   => 'Foto Kartu Identitas / Pelajar Siswa harus berupa file gambar (JPG, PNG, WEBP).',
        ]);

        // Validasi Waktu: Jam Kembali harus lebih akhir dari Jam Keluar
        $jamKeluarClean  = str_replace('.', ':', trim($request->jam_keluar));
        $jamKembaliClean = str_replace('.', ':', trim($request->jam_kembali));

        $timeStart = strtotime($jamKeluarClean);
        $timeEnd   = strtotime($jamKembaliClean);

        if ($timeStart !== false && $timeEnd !== false) {
            if ($timeEnd <= $timeStart) {
                return redirect()->back()->withInput()->withErrors([
                    'jam_kembali' => "Validasi Gagal: Rencana Jam Kembali ({$request->jam_kembali}) harus lebih akhir daripada Rencana Jam Keluar ({$request->jam_keluar})."
                ]);
            }
        }

        // Upload Foto
        $destinationPath = public_path('uploads/dispensasi');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $fotoSuratPath = null;
        if ($request->hasFile('foto_surat_dispen')) {
            $fileSurat = $request->file('foto_surat_dispen');
            $nameSurat = 'surat_' . time() . '_' . Str::random(6) . '.' . $fileSurat->getClientOriginalExtension();
            $fileSurat->move($destinationPath, $nameSurat);
            $fotoSuratPath = 'uploads/dispensasi/' . $nameSurat;
        }

        $fotoKartuPath = null;
        if ($request->hasFile('foto_kartu_identitas')) {
            $fileKartu = $request->file('foto_kartu_identitas');
            $nameKartu = 'kartu_' . time() . '_' . Str::random(6) . '.' . $fileKartu->getClientOriginalExtension();
            $fileKartu->move($destinationPath, $nameKartu);
            $fotoKartuPath = 'uploads/dispensasi/' . $nameKartu;
        }

        // Simpan Foto Siswa Live dari Kamera Perangkat (Wajib Live)
        $fotoSiswaLivePath = null;
        if ($request->filled('foto_siswa_live') && str_contains($request->foto_siswa_live, 'data:image')) {
            $liveDir = public_path('uploads/dispensasi/siswa');
            if (!file_exists($liveDir)) {
                mkdir($liveDir, 0755, true);
            }
            $dataUriParts = explode(',', $request->foto_siswa_live);
            if (isset($dataUriParts[1])) {
                $decoded = base64_decode($dataUriParts[1]);
                $fn = 'siswa_live_' . time() . '_' . Str::random(6) . '.jpg';
                file_put_contents($liveDir . '/' . $fn, $decoded);
                $fotoSiswaLivePath = 'uploads/dispensasi/siswa/' . $fn;
            }
        }

        $sigDir = public_path('uploads/dispensasi/signatures');
        if (!file_exists($sigDir)) {
            mkdir($sigDir, 0755, true);
        }

        $ttdSiswaPath = null;
        if ($request->hasFile('ttd_siswa_file')) {
            $f = $request->file('ttd_siswa_file');
            $fn = 'ttd_siswa_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
            $f->move($sigDir, $fn);
            $ttdSiswaPath = 'uploads/dispensasi/signatures/' . $fn;
        } elseif ($request->filled('ttd_siswa_data') && str_contains($request->ttd_siswa_data, 'data:image')) {
            $dataUriParts = explode(',', $request->ttd_siswa_data);
            if (isset($dataUriParts[1])) {
                $decoded = base64_decode($dataUriParts[1]);
                $fn = 'ttd_siswa_' . time() . '_' . Str::random(6) . '.png';
                file_put_contents($sigDir . '/' . $fn, $decoded);
                $ttdSiswaPath = 'uploads/dispensasi/signatures/' . $fn;
            }
        }

        $ttdGuruPiketPath = null;
        if ($request->hasFile('ttd_guru_piket_file')) {
            $f = $request->file('ttd_guru_piket_file');
            $fn = 'ttd_piket_' . time() . '_' . Str::random(6) . '.' . $f->getClientOriginalExtension();
            $f->move($sigDir, $fn);
            $ttdGuruPiketPath = 'uploads/dispensasi/signatures/' . $fn;
        } elseif ($request->filled('ttd_guru_piket_data') && str_contains($request->ttd_guru_piket_data, 'data:image')) {
            $dataUriParts = explode(',', $request->ttd_guru_piket_data);
            if (isset($dataUriParts[1])) {
                $decoded = base64_decode($dataUriParts[1]);
                $fn = 'ttd_piket_' . time() . '_' . Str::random(6) . '.png';
                file_put_contents($sigDir . '/' . $fn, $decoded);
                $ttdGuruPiketPath = 'uploads/dispensasi/signatures/' . $fn;
            }
        }

        // Validasi Wajib Tanda Tangan Guru Piket & Siswa
        if (!$ttdGuruPiketPath) {
            return redirect()->back()->withInput()->withErrors([
                'ttd_guru_piket' => 'Tanda tangan Guru Piket wajib diisi. Silakan lakukan tanda tangan digital pada kolom Guru Piket.'
            ]);
        }

        if (!$ttdSiswaPath) {
            return redirect()->back()->withInput()->withErrors([
                'ttd_siswa' => 'Tanda tangan Siswa yang mengajukan dispensasi wajib diisi. Silakan lakukan tanda tangan digital pada kolom Siswa.'
            ]);
        }

        $siswa = Siswa::with('kelas')->findOrFail($request->id_siswa);
        $waka  = User::findOrFail($request->id_user_waka);
        
        $userPiket = Auth::user();
        
        // Data Guru Piket dari Dropdown Guru TU
        $namaGuruPiket = 'Guru Piket';
        $nipGuruPiket  = '-';
        $idGuruPiket   = null;

        if ($request->filled('id_guru_piket_select')) {
            $selectedGuru = Guru::find($request->id_guru_piket_select);
            if ($selectedGuru) {
                $namaGuruPiket = $selectedGuru->nama_guru;
                $nipGuruPiket  = !empty($selectedGuru->nip) ? $selectedGuru->nip : '-';
                $idGuruPiket   = $selectedGuru->id_guru;
            }
        } elseif ($request->filled('nama_guru_piket')) {
            $namaGuruPiket = $request->nama_guru_piket;
            $nipGuruPiket  = $request->filled('nip_guru_piket') ? $request->nip_guru_piket : '-';
        } elseif ($userPiket) {
            $namaGuruPiket = $userPiket->name;
            $nipGuruPiket  = !empty($userPiket->nip) ? $userPiket->nip : '-';
            $idGuruPiket   = $userPiket->id;
        }

        $kode  = $request->filled('kode_dispen') ? trim($request->kode_dispen) : ('DSP-' . date('Ymd') . '-' . strtoupper(Str::random(4)));
        $token = Str::random(40);

        $dispen = SiswaDispen::create([
            'id_siswa'             => $siswa->id_siswa,
            'id_kelas'             => $siswa->id_kelas,
            'id_user_waka'         => $waka->id,
            'nama_waka'            => $waka->name,
            'nip_waka'             => $waka->nip,
            'no_hp_waka'           => $waka->no_hp,
            'id_guru_piket'        => $idGuruPiket,
            'nama_guru_piket'      => $namaGuruPiket,
            'nip_guru_piket'       => $nipGuruPiket,
            'kode_dispen'          => $kode,
            'token_wali_kelas'     => $token,
            'tanggal'              => $request->tanggal,
            'jam_keluar'           => $request->jam_keluar,
            'jam_kembali'          => $request->jam_kembali,
            'alasan'               => $request->alasan,
            'tempat'               => $request->tempat ?? null,
            'foto_surat_dispen'    => $fotoSuratPath,
            'foto_kartu_identitas' => $fotoKartuPath,
            'foto_siswa_live'      => $fotoSiswaLivePath,
            'ttd_siswa'            => $ttdSiswaPath,
            'ttd_guru_piket'       => $ttdGuruPiketPath,
            'status_waka'          => 'pending',
            'status_wali_kelas'    => 'pending',
            'status_satpam'        => 'belum_keluar',
        ]);

        $approvalUrl = url("/approval/dispen/{$token}");
        
        $waWakaUrl = null;
        if ($waka->no_hp) {
            $hpFormatted = preg_replace('/[^0-9]/', '', $waka->no_hp);
            if (str_starts_with($hpFormatted, '0')) {
                $hpFormatted = '62' . substr($hpFormatted, 1);
            }
            $namaSiswa = $siswa->nama_siswa;
            $namaKelas = $siswa->kelas->nama_kelas ?? '-';
            $tglIndo   = Carbon::parse($request->tanggal)->format('d-m-Y');
            
            $pesanWa = "*PERMOHONAN PERSETUJUAN DISPENSASI SISWA*\n"
                . "====================================\n\n"
                . "Halo Bapak/Ibu Waka (*{$waka->name}*),\n"
                . "Ada permohonan persetujuan dispensasi siswa dari Guru Piket:\n\n"
                . "• *Kode Dispen*: {$kode}\n"
                . "• *Nama Siswa*: {$namaSiswa}\n"
                . "• *Kelas*: {$namaKelas}\n"
                . "• *Tanggal*: {$tglIndo}\n"
                . "• *Rencana Jam*: {$request->jam_keluar} s/d {$request->jam_kembali}\n"
                . "• *Alasan*: {$request->alasan}\n";

            if ($fotoSiswaLivePath) {
                $pesanWa .= "• *Foto Siswa (Live Kamera)*: Ada (Terlampir pada link)\n";
            }
            if ($fotoKartuPath) {
                $pesanWa .= "• *Foto Kartu Identitas*: Ada (Terlampir pada link)\n";
            }
            if ($fotoSuratPath) {
                $pesanWa .= "• *Foto Surat Dispen*: Ada (Terlampir pada link)\n";
            }

            $pesanWa .= "\nMohon verifikasi NIP & Password melalui link persetujuan berikut:\n"
                . "{$approvalUrl}";
                
            $waWakaUrl = "https://api.whatsapp.com/send?phone={$hpFormatted}&text=" . urlencode($pesanWa);
        }

        return redirect()->route('piket.dispensasi-siswa')->with([
            'success'      => "Permohonan dispensasi siswa berhasil disimpan (Kode: {$kode})! Link persetujuan Waka otomatis dibuat.",
            'approval_url' => $approvalUrl,
            'wa_waka_url'  => $waWakaUrl,
            'waka_nama'    => $waka->name,
        ]);
    }

    /**
     * Update Data Dispensasi Siswa
     */
    public function updateDispensasiSiswa(Request $request, $id)
    {
        $dispen = SiswaDispen::findOrFail($id);

        $request->validate([
            'id_user_waka'         => 'required|exists:users,id',
            'tanggal'              => 'required|date',
            'jam_keluar'           => 'required|string',
            'jam_kembali'          => 'required|string',
            'alasan'               => 'required|string|max:500',
            'foto_surat_dispen'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'foto_kartu_identitas' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ], [
            'id_user_waka.required'       => 'Pilih Waka tujuan persetujuan.',
            'tanggal.required'           => 'Pilih tanggal dispensasi.',
            'jam_keluar.required'        => 'Isi jam rencana keluar.',
            'jam_kembali.required'       => 'Isi jam rencana kembali.',
            'alasan.required'            => 'Isi alasan dispensasi.',
            'foto_surat_dispen.image'    => 'Foto Surat Dispensasi Resmi harus berupa file gambar.',
            'foto_kartu_identitas.image' => 'Foto Kartu Identitas / Pelajar Siswa harus berupa file gambar.',
        ]);

        // Validasi Waktu
        $jamKeluarClean  = str_replace('.', ':', trim($request->jam_keluar));
        $jamKembaliClean = str_replace('.', ':', trim($request->jam_kembali));

        $timeStart = strtotime($jamKeluarClean);
        $timeEnd   = strtotime($jamKembaliClean);

        if ($timeStart !== false && $timeEnd !== false) {
            if ($timeEnd <= $timeStart) {
                return redirect()->back()->withInput()->withErrors([
                    'jam_kembali' => "Validasi Gagal: Rencana Jam Kembali ({$request->jam_kembali}) harus lebih akhir daripada Rencana Jam Keluar ({$request->jam_keluar})."
                ]);
            }
        }

        // Upload Foto baru jika ada
        $destinationPath = public_path('uploads/dispensasi');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        if ($request->hasFile('foto_surat_dispen')) {
            $fileSurat = $request->file('foto_surat_dispen');
            $nameSurat = 'surat_' . time() . '_' . Str::random(6) . '.' . $fileSurat->getClientOriginalExtension();
            $fileSurat->move($destinationPath, $nameSurat);
            $dispen->foto_surat_dispen = 'uploads/dispensasi/' . $nameSurat;
        }

        if ($request->hasFile('foto_kartu_identitas')) {
            $fileKartu = $request->file('foto_kartu_identitas');
            $nameKartu = 'kartu_' . time() . '_' . Str::random(6) . '.' . $fileKartu->getClientOriginalExtension();
            $fileKartu->move($destinationPath, $nameKartu);
            $dispen->foto_kartu_identitas = 'uploads/dispensasi/' . $nameKartu;
        }

        if ($request->filled('foto_siswa_live') && str_contains($request->foto_siswa_live, 'data:image')) {
            $liveDir = public_path('uploads/dispensasi/siswa');
            if (!file_exists($liveDir)) {
                mkdir($liveDir, 0755, true);
            }
            $dataUriParts = explode(',', $request->foto_siswa_live);
            if (isset($dataUriParts[1])) {
                $decoded = base64_decode($dataUriParts[1]);
                $fn = 'siswa_live_' . time() . '_' . Str::random(6) . '.jpg';
                file_put_contents($liveDir . '/' . $fn, $decoded);
                $dispen->foto_siswa_live = 'uploads/dispensasi/siswa/' . $fn;
            }
        }

        $waka = User::findOrFail($request->id_user_waka);

        $dispen->id_user_waka = $waka->id;
        $dispen->nama_waka    = $waka->name;
        $dispen->nip_waka     = $waka->nip;
        $dispen->no_hp_waka   = $waka->no_hp;
        $dispen->tanggal       = $request->tanggal;
        $dispen->jam_keluar    = $request->jam_keluar;
        $dispen->jam_kembali   = $request->jam_kembali;
        $dispen->alasan        = $request->alasan;
        $dispen->save();

        return redirect()->route('piket.dispensasi-siswa')
            ->with('success', 'Data permohonan dispensasi siswa berhasil diperbarui!');
    }

    /**
     * Hapus (Soft Delete) Data Dispensasi Siswa
     */
    public function destroyDispensasiSiswa($id)
    {
        $dispen = SiswaDispen::findOrFail($id);
        $dispen->delete();

        return redirect()->route('piket.dispensasi-siswa')
            ->with('success', 'Data dispensasi siswa berhasil dipindahkan ke Sampah.');
    }

    /**
     * Hapus Massal (Bulk Soft Delete) Data Dispensasi Siswa
     */
    public function bulkDestroyDispensasiSiswa(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu data dispensasi siswa yang mau dihapus.');
        }

        $count = SiswaDispen::whereIn('id_siswa_dispen', $ids)->delete();

        return redirect()->route('piket.dispensasi-siswa')
            ->with('success', $count . ' data dispensasi siswa berhasil dipindahkan ke Sampah.');
    }

    /**
     * Halaman Sampah Dispensasi Siswa
     */
    public function trashDispensasiSiswa(Request $request)
    {
        $dispenList = SiswaDispen::onlyTrashed()
            ->with(['siswa', 'kelas'])
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('guru_piket.dispensasi_siswa_trash', compact('dispenList'));
    }

    /**
     * Restore Data Dispensasi Siswa dari Sampah
     */
    public function restoreDispensasiSiswa($id)
    {
        $dispen = SiswaDispen::onlyTrashed()->findOrFail($id);
        $dispen->restore();

        return redirect()->route('piket.dispensasi-siswa.trash')
            ->with('success', 'Data dispensasi siswa berhasil dipulihkan.');
    }

    /**
     * Force Delete Data Dispensasi Siswa
     */
    public function forceDeleteDispensasiSiswa($id)
    {
        $dispen = SiswaDispen::onlyTrashed()->findOrFail($id);
        $dispen->forceDelete();

        return redirect()->route('piket.dispensasi-siswa.trash')
            ->with('success', 'Data dispensasi siswa berhasil dihapus secara permanen.');
    }

    /**
     * Empty Trash Dispensasi Siswa
     */
    public function emptyTrashDispensasiSiswa()
    {
        $trashed = SiswaDispen::onlyTrashed()->get();
        foreach ($trashed as $d) {
            $d->forceDelete();
        }

        return redirect()->route('piket.dispensasi-siswa.trash')
            ->with('success', 'Seluruh data sampah dispensasi siswa berhasil dikosongkan.');
    }

    /**
     * [READ] Halaman Utama Surat Izin Siswa (Input & Rekap Surat Izin oleh Guru Piket)
     */
    public function suratIzinSiswa(Request $request)
    {
        $todayDate = Carbon::now('Asia/Jakarta')->toDateString();

        $search         = trim($request->input('q'));
        $idKelasFilter  = $request->input('id_kelas');
        $kategoriFilter = $request->input('kategori');
        $tanggalFilter  = $request->input('tanggal');

        // Query Surat Izin Siswa
        // Query Surat Izin Siswa
        $query = SiswaSuratIzin::with(['siswa', 'kelas.waliKelas', 'petugasPiket']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('siswa', function($s) use ($search) {
                    $s->where('nama_siswa', 'LIKE', "%{$search}%")
                      ->orWhere('nis', 'LIKE', "%{$search}%");
                })->orWhere('keterangan', 'LIKE', "%{$search}%");
            });
        }

        if ($idKelasFilter) {
            $query->where('id_kelas', $idKelasFilter);
        }

        if ($kategoriFilter) {
            $query->where('kategori', $kategoriFilter);
        }

        if ($tanggalFilter) {
            $query->whereDate('tanggal', $tanggalFilter);
        }

        $suratIzinList = $query->orderBy('tanggal', 'desc')
            ->orderBy('id_surat_izin', 'desc')
            ->paginate(15);

        // Class & Student master data for dropdowns (with Wali Kelas loaded)
        $kelases = Kelas::with('waliKelas')->orderBy('nama_kelas', 'asc')->get();
        $siswas  = Siswa::with('kelas')->orderBy('nama_siswa', 'asc')->get();

        // Stat Card Counts (Aktif Hari Ini dalam Rentang Tanggal)
        $activeTodayQuery = function($query) use ($todayDate) {
            $query->whereDate('tanggal', '<=', $todayDate)
                  ->where(function($q) use ($todayDate) {
                      $q->whereNull('tanggal_selesai')
                        ->orWhereDate('tanggal_selesai', '>=', $todayDate);
                  });
        };

        $totalIzinHariIni = SiswaSuratIzin::where($activeTodayQuery)->count();
        $sakitHariIni     = SiswaSuratIzin::where($activeTodayQuery)->where('kategori', 'Sakit')->count();
        $izinHariIni      = SiswaSuratIzin::where($activeTodayQuery)->where('kategori', 'Izin')->count();
        $dispenHariIni    = SiswaSuratIzin::where($activeTodayQuery)->where('kategori', 'Dispen Luar Sekolah')->count();
        $totalSemuaData   = SiswaSuratIzin::count();

        return view('guru_piket.surat_izin_siswa', compact(
            'suratIzinList',
            'kelases',
            'siswas',
            'totalIzinHariIni',
            'sakitHariIni',
            'izinHariIni',
            'dispenHariIni',
            'totalSemuaData',
            'todayDate'
        ));
    }

    /**
     * [CREATE] Simpan Surat Izin Siswa Baru & Auto-Sync Presensi Kehadiran
     */
    public function storeSuratIzinSiswa(Request $request)
    {
        $request->validate([
            'id_siswa'        => 'required|exists:siswa,id_siswa',
            'tanggal'         => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal',
            'kategori'        => 'required|in:Sakit,Izin,Dispen Luar Sekolah',
            'keterangan'      => 'required|string|max:1000',
            'foto_bukti'      => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'id_siswa.required'           => 'Pilih siswa yang mengajukan izin/sakit/dispen.',
            'id_siswa.exists'             => 'Siswa yang dipilih tidak terdaftar.',
            'tanggal.required'            => 'Pilih tanggal mulai izin siswa.',
            'tanggal_selesai.required'    => 'Pilih tanggal selesai izin siswa.',
            'tanggal_selesai.after_or_equal' => 'Validasi Gagal: Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin.',
            'kategori.required'           => 'Pilih kategori izin (Sakit, Izin, atau Dispen Luar Sekolah).',
            'keterangan.required'         => 'Detail Alasan / Keterangan izin WAJIB diisi oleh Guru Piket.',
            'foto_bukti.required'         => 'Foto Bukti Surat / Dokumen WAJIB diisi dan diunggah oleh Guru Piket.',
            'foto_bukti.image'            => 'Foto Bukti Surat harus berupa file gambar (JPG, PNG, WEBP).',
            'foto_bukti.max'              => 'Ukuran foto maksimal 5 MB.',
        ]);

        $siswa = Siswa::findOrFail($request->id_siswa);

        $fotoName = null;
        if ($request->hasFile('foto_bukti')) {
            $destinationPath = public_path('uploads/surat_izin_siswa');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file = $request->file('foto_bukti');
            $fotoName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fotoName);
        }

        $tglMulai   = Carbon::parse($request->tanggal);
        $tglSelesai = Carbon::parse($request->tanggal_selesai ?? $request->tanggal);
        $durasiHari = (int) $tglMulai->diffInDays($tglSelesai) + 1;

        $surat = SiswaSuratIzin::create([
            'id_siswa'         => $siswa->id_siswa,
            'id_kelas'         => $siswa->id_kelas,
            'tanggal'          => $request->tanggal,
            'tanggal_selesai'  => $request->tanggal_selesai ?? $request->tanggal,
            'durasi_hari'      => $durasiHari,
            'kategori'         => $request->kategori,
            'keterangan'       => $request->keterangan,
            'foto_bukti'       => $fotoName,
            'id_petugas_piket' => Auth::id(),
            'status'           => 'Terverifikasi',
        ]);

        // Multi-day Auto-Sync to Jurnal Detail Ketidakhadiran for all teaching journals on that date range for that class
        $currDate = $tglMulai->copy();
        while ($currDate->lte($tglSelesai)) {
            $dStr = $currDate->toDateString();
            $jurnals = JurnalMengajar::whereDate('tanggal', $dStr)
                ->whereHas('jadwal', function($q) use ($siswa) {
                    $q->where('id_kelas', $siswa->id_kelas);
                })->get();

            foreach ($jurnals as $jurnal) {
                JurnalDetailKetidakhadiran::updateOrCreate(
                    [
                        'id_jurnal' => $jurnal->id_jurnal,
                        'id_siswa'  => $siswa->id_siswa,
                    ],
                    [
                        'keterangan' => $request->kategori,
                    ]
                );
            }
            $currDate->addDay();
        }

        $durasiInfo = $durasiHari > 1 ? "selama {$durasiHari} Hari" : "1 Hari";
        return redirect()->route('piket.surat-izin-siswa')
            ->with('success', "Surat Izin Siswa ({$siswa->nama_siswa} - {$request->kategori} {$durasiInfo}) berhasil disimpan! Presensi kelas telah otomatis diperbarui (Auto-Sync).");
    }

    /**
     * [UPDATE] Perbarui Data Surat Izin Siswa & Presensi
     */
    public function updateSuratIzinSiswa(Request $request, $id)
    {
        $surat = SiswaSuratIzin::findOrFail($id);

        $request->validate([
            'tanggal'         => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal',
            'kategori'        => 'required|in:Sakit,Izin,Dispen Luar Sekolah',
            'keterangan'      => 'required|string|max:1000',
            'status'          => 'required|in:Terverifikasi,Menunggu,Ditolak',
            'foto_bukti'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'tanggal.required'            => 'Pilih tanggal mulai izin siswa.',
            'tanggal_selesai.required'    => 'Pilih tanggal selesai izin siswa.',
            'tanggal_selesai.after_or_equal' => 'Validasi Gagal: Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin.',
            'kategori.required'           => 'Pilih kategori izin.',
            'keterangan.required'         => 'Keterangan / Detail Alasan izin WAJIB diisi.',
            'status.required'             => 'Pilih status verifikasi surat.',
            'foto_bukti.image'            => 'Foto Bukti Surat harus berupa gambar.',
        ]);

        $fotoName = $surat->foto_bukti;
        if ($request->hasFile('foto_bukti')) {
            $destinationPath = public_path('uploads/surat_izin_siswa');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            if ($fotoName && file_exists(public_path('uploads/surat_izin_siswa/' . $fotoName))) {
                @unlink(public_path('uploads/surat_izin_siswa/' . $fotoName));
            }
            $file = $request->file('foto_bukti');
            $fotoName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fotoName);
        }

        $tglMulai   = Carbon::parse($request->tanggal);
        $tglSelesai = Carbon::parse($request->tanggal_selesai ?? $request->tanggal);
        $durasiHari = (int) $tglMulai->diffInDays($tglSelesai) + 1;

        $surat->update([
            'tanggal'         => $request->tanggal,
            'tanggal_selesai' => $request->tanggal_selesai ?? $request->tanggal,
            'durasi_hari'     => $durasiHari,
            'kategori'        => $request->kategori,
            'keterangan'      => $request->keterangan,
            'status'          => $request->status,
            'foto_bukti'      => $fotoName,
        ]);

        // Re-sync multi-day to Jurnal Detail Ketidakhadiran
        $currDate = $tglMulai->copy();
        while ($currDate->lte($tglSelesai)) {
            $dStr = $currDate->toDateString();
            $jurnals = JurnalMengajar::whereDate('tanggal', $dStr)
                ->whereHas('jadwal', function($q) use ($surat) {
                    $q->where('id_kelas', $surat->id_kelas);
                })->get();

            foreach ($jurnals as $jurnal) {
                JurnalDetailKetidakhadiran::updateOrCreate(
                    [
                        'id_jurnal' => $jurnal->id_jurnal,
                        'id_siswa'  => $surat->id_siswa,
                    ],
                    [
                        'keterangan' => $request->kategori,
                    ]
                );
            }
            $currDate->addDay();
        }

        return redirect()->route('piket.surat-izin-siswa')
            ->with('success', 'Data Surat Izin Siswa berhasil diperbarui dan disinkronkan ke presensi kelas!');
    }

    /**
     * [SOFT DELETE] Hapus Surat Izin Siswa ke Sampah
     */
    public function destroySuratIzinSiswa($id)
    {
        $surat = SiswaSuratIzin::findOrFail($id);
        $surat->delete();

        return redirect()->route('piket.surat-izin-siswa')
            ->with('success', 'Surat Izin Siswa berhasil dipindahkan ke Sampah.');
    }

    /**
     * [BULK SOFT DELETE] Hapus Massal Surat Izin Siswa ke Sampah
     */
    public function bulkDestroySuratIzinSiswa(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu data surat izin siswa yang mau dihapus.');
        }

        $count = SiswaSuratIzin::whereIn('id_surat_izin', $ids)->delete();

        return redirect()->route('piket.surat-izin-siswa')
            ->with('success', $count . ' data surat izin siswa berhasil dipindahkan ke Sampah.');
    }

    /**
     * [TRASH] Halaman Sampah Surat Izin Siswa
     */
    public function trashSuratIzinSiswa(Request $request)
    {
        $search        = trim($request->input('q'));
        $idKelasFilter = $request->input('id_kelas');

        $query = SiswaSuratIzin::onlyTrashed()
            ->with(['siswa', 'kelas', 'petugasPiket']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('siswa', function($s) use ($search) {
                    $s->where('nama_siswa', 'LIKE', "%{$search}%")
                      ->orWhere('nis', 'LIKE', "%{$search}%");
                })->orWhere('keterangan', 'LIKE', "%{$search}%");
            });
        }

        if ($idKelasFilter) {
            $query->where('id_kelas', $idKelasFilter);
        }

        $suratIzinList = $query->orderBy('deleted_at', 'desc')->paginate(15);
        $kelases       = Kelas::orderBy('nama_kelas', 'asc')->get();

        return view('guru_piket.surat_izin_siswa_trash', compact('suratIzinList', 'kelases'));
    }

    /**
     * [RESTORE] Pulihkan Surat Izin Siswa dari Sampah
     */
    public function restoreSuratIzinSiswa($id)
    {
        $surat = SiswaSuratIzin::onlyTrashed()->findOrFail($id);
        $surat->restore();

        return redirect()->route('piket.surat-izin-siswa.trash')
            ->with('success', 'Surat Izin Siswa berhasil dipulihkan dari Sampah.');
    }

    /**
     * [FORCE DELETE] Hapus Permanen Surat Izin Siswa
     */
    public function forceDeleteSuratIzinSiswa($id)
    {
        $surat = SiswaSuratIzin::onlyTrashed()->findOrFail($id);
        if ($surat->foto_bukti && file_exists(public_path('uploads/surat_izin_siswa/' . $surat->foto_bukti))) {
            @unlink(public_path('uploads/surat_izin_siswa/' . $surat->foto_bukti));
        }
        $surat->forceDelete();

        return redirect()->route('piket.surat-izin-siswa.trash')
            ->with('success', 'Surat Izin Siswa berhasil dihapus secara permanen.');
    }

    /**
     * [EMPTY TRASH] Kosongkan Seluruh Sampah Surat Izin Siswa
     */
    public function emptyTrashSuratIzinSiswa()
    {
        $trashed = SiswaSuratIzin::onlyTrashed()->get();
        foreach ($trashed as $s) {
            if ($s->foto_bukti && file_exists(public_path('uploads/surat_izin_siswa/' . $s->foto_bukti))) {
                @unlink(public_path('uploads/surat_izin_siswa/' . $s->foto_bukti));
            }
            $s->forceDelete();
        }

        return redirect()->route('piket.surat-izin-siswa.trash')
            ->with('success', 'Seluruh data sampah Surat Izin Siswa berhasil dikosongkan.');
    }

    // ─────────────────────────────────────────────────
    // FITUR SISWA TELAT (ROLE GURU PIKET)
    // ─────────────────────────────────────────────────

    /**
     * Halaman Utama Siswa Telat
     */
    public function siswaTelat(Request $request)
    {
        $siswaList = Siswa::with('kelas')->orderBy('nama_siswa', 'asc')->get();
        $guruList  = Guru::with('mapel')->orderBy('nama_guru', 'asc')->get();
        $kelases   = Kelas::orderBy('nama_kelas', 'asc')->get();

        $query = SiswaTelat::with(['siswa.kelas', 'kelas', 'guruMengajar.mapel', 'guruPiket']);

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('alasan', 'LIKE', "%{$q}%")
                    ->orWhere('tindakan_hukuman', 'LIKE', "%{$q}%")
                    ->orWhereHas('siswa', function ($s) use ($q) {
                        $s->where('nama_siswa', 'LIKE', "%{$q}%")
                          ->orWhere('nis', 'LIKE', "%{$q}%")
                          ->orWhere('nisn', 'LIKE', "%{$q}%");
                    })
                    ->orWhereHas('guruMengajar', function ($g) use ($q) {
                        $g->where('nama_guru', 'LIKE', "%{$q}%");
                    });
            });
        }

        if ($request->filled('id_kelas')) {
            $query->where('id_kelas', $request->id_kelas);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $telatList = $query->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->paginate(15);

        $todayDate           = Carbon::now('Asia/Jakarta')->toDateString();
        $totalTelatToday     = SiswaTelat::whereDate('tanggal', $todayDate)->count();
        $totalTelatBulanIni  = SiswaTelat::whereMonth('tanggal', Carbon::now('Asia/Jakarta')->month)
            ->whereYear('tanggal', Carbon::now('Asia/Jakarta')->year)
            ->count();

        return view('guru_piket.siswa_telat', compact(
            'siswaList',
            'guruList',
            'kelases',
            'telatList',
            'totalTelatToday',
            'totalTelatBulanIni'
        ));
    }

    /**
     * API Endpoint: Get Siswa Info, Kelas, and Current/Today Schedule Guru
     */
    /**
     * API Endpoint: Get Siswa Info, Kelas, and Detect Guru Mengajar based on Date & Time
     */
    public function getSiswaScheduleAndGuru(Request $request, $id_siswa)
    {
        $siswa = Siswa::with('kelas')->find($id_siswa);
        if (!$siswa) {
            return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan.'], 404);
        }

        $tanggalInput = $request->input('tanggal', Carbon::now('Asia/Jakarta')->toDateString());
        $jamInput     = trim($request->input('jam_terlambat', Carbon::now('Asia/Jakarta')->format('H:i')));

        // Formatting time string HH:MM
        $jamInputClean = str_replace('.', ':', $jamInput);
        if (strlen($jamInputClean) == 4 && strpos($jamInputClean, ':') === 1) {
            $jamInputClean = '0' . $jamInputClean;
        }
        if (strlen($jamInputClean) == 5) {
            $jamInputClean .= ':00';
        }

        // Detect Day of Week from input date
        $days = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        try {
            $carbonDate = Carbon::parse($tanggalInput);
        } catch (\Exception $e) {
            $carbonDate = Carbon::now('Asia/Jakarta');
        }

        $hariIndo = $days[$carbonDate->format('l')] ?? 'Senin';

        // Retrieve schedule for student's class on that day from Master Jadwal & Master Jam Pelajaran
        $jadwals = Jadwal::with(['guru.mapel', 'mapel', 'jamMulai', 'jamSelesai', 'ruangan'])
            ->where('id_kelas', $siswa->id_kelas)
            ->where('hari', $hariIndo)
            ->orderBy('id_jam_mulai', 'asc')
            ->get();

        $isFallbackDay = false;
        if ($jadwals->isEmpty()) {
            $isFallbackDay = true;
            // Fallback checking schedules for other days if weekend/holiday
            $jadwals = Jadwal::with(['guru.mapel', 'mapel', 'jamMulai', 'jamSelesai', 'ruangan'])
                ->where('id_kelas', $siswa->id_kelas)
                ->orderBy('id_jam_mulai', 'asc')
                ->get();
        }

        // Match time range from Master Jam Pelajaran (Jam Mulai s/d Jam Selesai)
        $matchedJadwal     = null;
        $isExactTimeMatch  = false;
        $isJumat           = strtolower($hariIndo) === 'jumat';
        $checkTime         = substr($jamInputClean, 0, 5);

        foreach ($jadwals as $j) {
            $startTime = $j->waktu_mulai_effective;
            $endTime   = $j->waktu_selesai_effective;

            if ($startTime && $endTime) {
                if ($checkTime >= $startTime && $checkTime <= $endTime) {
                    $matchedJadwal    = $j;
                    $isExactTimeMatch = true;
                    break;
                }
            }
        }

        // Fallback: If no exact time match found, pick the first schedule slot of that day
        if (!$matchedJadwal && $jadwals->isNotEmpty()) {
            $matchedJadwal = $jadwals->first();
        }

        if ($matchedJadwal) {
            // Append formatted accessors for JSON response
            $matchedJadwal->append(['jam_range_formatted', 'waktu_range']);
        }

        $allGuru = Guru::with('mapel')->orderBy('nama_guru', 'asc')->get();

        return response()->json([
            'status'              => 'success',
            'siswa'               => $siswa,
            'kelas'               => $siswa->kelas,
            'hari_indo'           => $hariIndo,
            'tanggal_formatted'   => $carbonDate->translatedFormat('l, d F Y'),
            'jam_input'           => substr($jamInputClean, 0, 5),
            'matched_jadwal'      => $matchedJadwal,
            'matched_guru_id'     => $matchedJadwal ? $matchedJadwal->id_guru : null,
            'is_exact_time_match' => $isExactTimeMatch,
            'is_fallback_day'     => $isFallbackDay,
            'jadwals_today'       => $jadwals,
            'all_guru'            => $allGuru,
        ]);
    }

    /**
     * Store Data Siswa Telat & Kirim Notifikasi Sistem + WhatsApp
     */
    public function storeSiswaTelat(Request $request)
    {
        $request->validate([
            'id_siswa'          => 'required|exists:siswa,id_siswa',
            'id_guru_mengajar'  => 'required|exists:guru,id_guru',
            'tanggal'           => 'required|date',
            'jam_terlambat'     => 'required|string',
            'alasan'            => 'required|string|max:500',
            'tindakan_hukuman'  => 'nullable|string|max:500',
        ], [
            'id_siswa.required'         => 'Pilih siswa yang terlambat datang.',
            'id_guru_mengajar.required' => 'Pilih Guru Mengajar yang sedang mengajar di kelas siswa saat jam tersebut.',
            'tanggal.required'          => 'Pilih tanggal keterlambatan.',
            'jam_terlambat.required'    => 'Isi jam kedatangan / terlambat siswa.',
            'alasan.required'           => 'Isi alasan keterlambatan siswa.',
        ]);

        $siswa = Siswa::with('kelas')->findOrFail($request->id_siswa);
        $guru  = Guru::findOrFail($request->id_guru_mengajar);
        $userPiket = Auth::user();

        $jamTeks = trim($request->jam_terlambat);
        $tglIndo = Carbon::parse($request->tanggal)->translatedFormat('d F Y');

        // Validasi: Tidak boleh mendata keterlambatan di tanggal masa mendatang
        if (Carbon::parse($request->tanggal)->startOfDay()->isFuture()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['tanggal' => 'Tanggal keterlambatan tidak boleh di masa mendatang.']);
        }

        // Validasi: Cek duplikasi data keterlambatan siswa pada tanggal yang sama
        $existingTelat = SiswaTelat::where('id_siswa', $siswa->id_siswa)
            ->whereDate('tanggal', $request->tanggal)
            ->first();

        if ($existingTelat) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['id_siswa' => 'Siswa ' . $siswa->nama_siswa . ' sudah dicatat terlambat pada tanggal ' . $tglIndo . ' (Jam ' . $existingTelat->jam_terlambat . ' WIB).']);
        }

        // Auto-detect matching id_jadwal from Master Jadwal database if not passed
        $idJadwal = $request->id_jadwal ?? null;
        if (!$idJadwal && $siswa->id_kelas) {
            $days = [
                'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
            ];
            $hariIndo = $days[Carbon::parse($request->tanggal)->format('l')] ?? 'Senin';
            $matchedJ = Jadwal::where('id_kelas', $siswa->id_kelas)
                ->where('id_guru', $guru->id_guru)
                ->where('hari', $hariIndo)
                ->first();
            if ($matchedJ) {
                $idJadwal = $matchedJ->id_jadwal;
            }
        }

        // 1. Buat Notifikasi Sistem Web (Tabel Pengumuman) untuk Guru Mengajar Target
        $judulPengumuman = "Pemberitahuan Siswa Terlambat: " . $siswa->nama_siswa . " (" . ($siswa->kelas->nama_kelas ?? '-') . ")";
        $isiPengumuman   = "PEMBERITAHUAN DARI GURU PIKET:\n\n"
            . "Siswa berikut terlambat hadir di sekolah pada tanggal " . $tglIndo . " (Jam " . $jamTeks . " WIB) dan sedang tidak mengikuti kegiatan belajar mengajar (KBM) tepat waktu:\n\n"
            . "• NIS / NISN : " . ($siswa->nis ?? '-') . " / " . ($siswa->nisn ?? '-') . "\n"
            . "• Nama Lengkap : " . $siswa->nama_siswa . "\n"
            . "• Kelas : " . ($siswa->kelas->nama_kelas ?? '-') . "\n"
            . "• Jenis Kelamin : " . $siswa->jenis_kelamin_teks . "\n"
            . "• Waktu Terlambat : " . $jamTeks . " WIB\n"
            . "• Alasan Terlambat : " . $request->alasan . "\n"
            . "• Hukuman / Tindakan Piket : " . ($request->tindakan_hukuman ?: 'Sudah melapor ke Piket dan diberikan pengarahan/hukuman kedisiplinan.') . "\n\n"
            . "Pemberitahuan dari sistem web dan Guru Piket ini dikirimkan secara otomatis kepada Bapak/Ibu Guru Mengajar (" . $guru->nama_guru . ") agar Bapak/Ibu tidak mendata siswa sebagai alfa/bolos. Pengisian presensi siswa di jurnal mengajar tetap menjadi wewenang penuh Bapak/Ibu Guru Mengajar.";

        $pengumuman = Pengumuman::create([
            'judul'        => $judulPengumuman,
            'isi'          => $isiPengumuman,
            'kategori'     => 'Siswa Telat',
            'id_kelas'     => $siswa->id_kelas,
            'id_guru'      => $guru->id_guru,
            'status'       => 'aktif',
            'tanggal'      => $request->tanggal,
            'keterangan'   => 'Laporan Keterlambatan Siswa dari Petugas Piket (' . ($userPiket->name ?? 'Guru Piket') . ')',
        ]);

        // 2. Simpan Record Siswa Telat (Database Connection)
        $telat = SiswaTelat::create([
            'id_siswa'          => $siswa->id_siswa,
            'id_kelas'          => $siswa->id_kelas,
            'id_guru_mengajar'  => $guru->id_guru,
            'id_jadwal'          => $idJadwal,
            'id_guru_piket'     => $userPiket ? $userPiket->id : null,
            'id_pengumuman'     => $pengumuman->id_pengumuman,
            'tanggal'           => $request->tanggal,
            'jam_terlambat'     => $jamTeks,
            'alasan'            => $request->alasan,
            'tindakan_hukuman'  => $request->tindakan_hukuman,
            'status_notifikasi' => 'terkirim',
        ]);

        // 3. Menyiapkan Tautan Notifikasi WhatsApp
        $rawPhone = preg_replace('/[^0-9]/', '', $guru->no_hp ?? '');
        if (str_starts_with($rawPhone, '0')) {
            $rawPhone = '62' . substr($rawPhone, 1);
        }

        $waText = "*PEMBERITAHUAN SISWA TERLAMBAT (GURU PIKET)*\n\n"
            . "Assalamu'alaikum / Selamat Pagi Bapak/Ibu Guru *{$guru->nama_guru}*,\n\n"
            . "Memberitahukan bahwa siswa dari kelas Bapak/Ibu terlambat hadir di sekolah:\n"
            . "• *Nama Siswa*: {$siswa->nama_siswa}\n"
            . "• *NIS / NISN*: " . ($siswa->nis ?? '-') . " / " . ($siswa->nisn ?? '-') . "\n"
            . "• *Kelas*: " . ($siswa->kelas->nama_kelas ?? '-') . "\n"
            . "• *Jenis Kelamin*: {$siswa->jenis_kelamin_teks}\n"
            . "• *Jam Datang*: {$jamTeks} WIB\n"
            . "• *Alasan*: {$request->alasan}\n"
            . "• *Tindakan/Hukuman*: " . ($request->tindakan_hukuman ?: 'Pengarahan & kedisiplinan Guru Piket') . "\n\n"
            . "Siswa telah melapor ke Guru Piket dan diarahkan untuk memasuki kelas. Data juga sudah masuk ke *Halaman Pengumuman Web Guru*. Mohon Bapak/Ibu Guru Mengajar dapat menyesuaikan presensi siswa di kelas.\n\n"
            . "Terima kasih.\n"
            . "- Petugas Piket: " . ($userPiket->name ?? 'Guru Piket');

        $waUrl = !empty($rawPhone)
            ? "https://api.whatsapp.com/send?phone={$rawPhone}&text=" . urlencode($waText)
            : null;

        return redirect()->route('piket.siswa-telat')
            ->with('success', 'Data Siswa Telat berhasil disimpan dan pemberitahuan sistem telah dikirimkan ke Guru Mengajar (' . $guru->nama_guru . ').')
            ->with('wa_url', $waUrl)
            ->with('guru_nama', $guru->nama_guru);
    }

    /**
     * Update Data Siswa Telat
     */
    public function updateSiswaTelat(Request $request, $id)
    {
        $telat = SiswaTelat::findOrFail($id);

        $request->validate([
            'id_guru_mengajar' => 'required|exists:guru,id_guru',
            'tanggal'          => 'required|date',
            'jam_terlambat'    => 'required|string',
            'alasan'           => 'required|string|max:500',
            'tindakan_hukuman' => 'nullable|string|max:500',
        ]);

        $guru = Guru::findOrFail($request->id_guru_mengajar);

        // Auto-detect matching id_jadwal if guru_mengajar or date changed
        $idJadwal = $telat->id_jadwal;
        if ($telat->id_kelas) {
            $days = [
                'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
            ];
            $hariIndo = $days[Carbon::parse($request->tanggal)->format('l')] ?? 'Senin';
            $matchedJ = Jadwal::where('id_kelas', $telat->id_kelas)
                ->where('id_guru', $guru->id_guru)
                ->where('hari', $hariIndo)
                ->first();
            if ($matchedJ) {
                $idJadwal = $matchedJ->id_jadwal;
            }
        }

        $telat->id_guru_mengajar = $guru->id_guru;
        $telat->id_jadwal        = $idJadwal;
        $telat->tanggal          = $request->tanggal;
        $telat->jam_terlambat    = trim($request->jam_terlambat);
        $telat->alasan           = $request->alasan;
        $telat->tindakan_hukuman = $request->tindakan_hukuman;
        $telat->save();

        // Update Pengumuman terkait jika ada
        if ($telat->id_pengumuman) {
            $pengumuman = Pengumuman::find($telat->id_pengumuman);
            if ($pengumuman) {
                $siswa = $telat->siswa;
                $tglIndo = Carbon::parse($request->tanggal)->translatedFormat('d F Y');
                $userPiket = Auth::user();

                $judulPengumuman = "Pemberitahuan Siswa Terlambat: " . ($siswa->nama_siswa ?? 'Siswa') . " (" . ($telat->kelas->nama_kelas ?? '-') . ")";
                $isiPengumuman   = "PEMBERITAHUAN DARI GURU PIKET:\n\n"
                    . "Siswa berikut terlambat hadir di sekolah pada tanggal " . $tglIndo . " (Jam " . $telat->jam_terlambat . " WIB) dan sedang tidak mengikuti kegiatan belajar mengajar (KBM) tepat waktu:\n\n"
                    . "• NIS / NISN : " . ($siswa->nis ?? '-') . " / " . ($siswa->nisn ?? '-') . "\n"
                    . "• Nama Lengkap : " . ($siswa->nama_siswa ?? '-') . "\n"
                    . "• Kelas : " . ($telat->kelas->nama_kelas ?? '-') . "\n"
                    . "• Jenis Kelamin : " . ($siswa ? $siswa->jenis_kelamin_teks : '-') . "\n"
                    . "• Waktu Terlambat : " . $telat->jam_terlambat . " WIB\n"
                    . "• Alasan Terlambat : " . $request->alasan . "\n"
                    . "• Hukuman / Tindakan Piket : " . ($request->tindakan_hukuman ?: 'Sudah melapor ke Piket dan diberikan pengarahan/hukuman kedisiplinan.') . "\n\n"
                    . "Pemberitahuan dari sistem web dan Guru Piket ini dikirimkan secara otomatis kepada Bapak/Ibu Guru Mengajar (" . $guru->nama_guru . ") agar Bapak/Ibu tidak mendata siswa sebagai alfa/bolos.";

                $pengumuman->judul    = $judulPengumuman;
                $pengumuman->isi      = $isiPengumuman;
                $pengumuman->id_guru  = $guru->id_guru;
                $pengumuman->tanggal  = $request->tanggal;
                $pengumuman->save();
            }
        }

        return redirect()->route('piket.siswa-telat')
            ->with('success', 'Data Siswa Telat berhasil diperbarui.');
    }

    /**
     * Soft Delete Data Siswa Telat
     */
    public function destroySiswaTelat($id)
    {
        $telat = SiswaTelat::findOrFail($id);
        if ($telat->id_pengumuman) {
            $pengumuman = Pengumuman::find($telat->id_pengumuman);
            if ($pengumuman) {
                $pengumuman->delete();
            }
        }
        $telat->delete();

        return redirect()->route('piket.siswa-telat')
            ->with('success', 'Data Siswa Telat berhasil dipindahkan ke Sampah.');
    }

    /**
     * [DESTROY BATCH] Soft Delete Banyak Data Siswa Telat Sekaligus
     */
    public function destroyBatchSiswaTelat(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:siswa_telat,id_siswa_telat',
        ], [
            'ids.required' => 'Silakan pilih minimal satu data siswa telat untuk dihapus.',
            'ids.min'      => 'Silakan pilih minimal satu data siswa telat untuk dihapus.',
            'ids.*.exists' => 'Data siswa telat yang dipilih tidak valid atau tidak ditemukan.',
        ]);

        $ids   = $request->ids;
        $items = SiswaTelat::whereIn('id_siswa_telat', $ids)->get();

        $count = 0;
        foreach ($items as $item) {
            if ($item->id_pengumuman) {
                $pengumuman = Pengumuman::find($item->id_pengumuman);
                if ($pengumuman) {
                    $pengumuman->delete();
                }
            }
            $item->delete();
            $count++;
        }

        return redirect()->route('piket.siswa-telat')
            ->with('success', "Sebanyak {$count} data siswa telat terpilih berhasil dipindahkan ke Sampah.");
    }

    /**
     * Halaman Sampah (Trash) Siswa Telat
     */
    public function trashSiswaTelat(Request $request)
    {
        $trashedList = SiswaTelat::onlyTrashed()
            ->with(['siswa.kelas', 'kelas', 'guruMengajar', 'guruPiket'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);

        return view('guru_piket.siswa_telat_trash', compact('trashedList'));
    }

    /**
     * Restore Data Siswa Telat dari Sampah
     */
    public function restoreSiswaTelat($id)
    {
        $telat = SiswaTelat::onlyTrashed()->findOrFail($id);
        if ($telat->id_pengumuman) {
            $pengumuman = Pengumuman::onlyTrashed()->find($telat->id_pengumuman);
            if ($pengumuman) {
                $pengumuman->restore();
            }
        }
        $telat->restore();

        return redirect()->route('piket.siswa-telat.trash')
            ->with('success', 'Data Siswa Telat berhasil dipulihkan.');
    }

    /**
     * Force Delete Data Siswa Telat
     */
    public function forceDeleteSiswaTelat($id)
    {
        $telat = SiswaTelat::onlyTrashed()->findOrFail($id);
        if ($telat->id_pengumuman) {
            $pengumuman = Pengumuman::onlyTrashed()->find($telat->id_pengumuman);
            if ($pengumuman) {
                $pengumuman->forceDelete();
            }
        }
        $telat->forceDelete();

        return redirect()->route('piket.siswa-telat.trash')
            ->with('success', 'Data Siswa Telat berhasil dihapus secara permanen.');
    }

    /**
     * Kosongkan Sampah Siswa Telat
     */
    public function emptyTrashSiswaTelat()
    {
        $trashed = SiswaTelat::onlyTrashed()->get();
        foreach ($trashed as $t) {
            if ($t->id_pengumuman) {
                $pengumuman = Pengumuman::onlyTrashed()->find($t->id_pengumuman);
                if ($pengumuman) {
                    $pengumuman->forceDelete();
                }
            }
            $t->forceDelete();
        }

        return redirect()->route('piket.siswa-telat.trash')
            ->with('success', 'Seluruh data sampah Siswa Telat berhasil dikosongkan.');
    }
}

