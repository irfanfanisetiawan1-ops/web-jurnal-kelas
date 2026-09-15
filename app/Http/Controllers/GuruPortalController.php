<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Jadwal;
use App\Models\JamPelajaran;
use App\Models\JurnalMengajar;
use App\Models\JurnalDetailKetidakhadiran;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Pengumuman;
use App\Models\PengumumanDibaca;
use App\Models\NilaiSiswa;
use App\Models\SiswaSuratIzin;
use App\Models\GuruIzin;
use App\Models\User;
use App\Models\SiswaTelat;
use App\Models\PengumumanDihapus;
use App\Models\SiswaDispen;
use App\Models\SiswaDispenDibaca;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GuruPortalController extends Controller
{
    /**
     * Dashboard Guru Mengajar & Wali Kelas - Beranda
     */
    public function dashboard(Request $request)
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

        $now = Carbon::now('Asia/Jakarta');
        $todayEnglish = $now->format('l');
        $todayIndo = $daysInIndonesian[$todayEnglish] ?? 'Senin';
        $todayDate = $now->toDateString();
        $isWeekend = in_array($todayIndo, ['Sabtu', 'Minggu']);

        $user = Auth::user();
        $guru = $user ? ($user->guru ?? ($user->nip ? Guru::where('nip', $user->nip)->first() : null)) : null;
        $idGuru = $guru->id_guru ?? ($user->id_guru ?? null);

        // Deteksi Peran Wali Kelas & Data Kelas Perwalian
        $kelasWali = null;
        if ($user) {
            $nips = array_filter([$user->nip, optional($guru)->nip]);
            if (!empty($nips)) {
                $kelasWali = Kelas::with(['jurusan', 'ruangan'])->whereIn('wali_kelas', $nips)->first();
            }
        }
        $isWaliKelas = ($kelasWali !== null) || ($user && $user->isWaliKelas());

        // Tahun Ajaran Aktif
        $taAktifObj = \App\Models\TahunAjaran::getActive();
        $tahunAjaranAktif = $taAktifObj ? "{$taAktifObj->tahun_ajaran} • Semester {$taAktifObj->semester}" : '2026/2027 • Semester Ganjil';

        // Pengaturan Hari Aktif untuk Ditampilkan pada Tabel Jadwal (Default: 'semua')
        $hariRequested = $request->input('hari');
        if (!empty($hariRequested) && in_array(strtolower($hariRequested), ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu', 'semua'])) {
            $hariAktif = strtolower($hariRequested);
            $isViewingAllDays = ($hariAktif === 'semua');
        } else {
            // Default: 'semua' sesuai permintaan agar seluruh jadwal mengajar tampil secara lengkap
            $hariAktif = 'semua';
            $isViewingAllDays = true;
        }

        // Ambil SEMUA Jadwal Mengajar Guru Ini (Terurut Hari & Jam Mulai)
        $semuaJadwalGuru = collect();
        if ($idGuru) {
            $semuaJadwalGuru = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamPelajaran', 'jamMulai', 'jamSelesai'])
                ->where('id_guru', $idGuru)
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
                ->orderBy('id_jam_mulai', 'asc')
                ->get();
        }

        // Penugasan Guru Pengganti untuk Guru Ini pada Tanggal Hari Ini
        $penugasansPenggantiHariIni = collect();
        if ($idGuru) {
            $penugasansPenggantiHariIni = \App\Models\PenugasanGuruPengganti::with([
                'jadwal.kelas', 'jadwal.mapel', 'jadwal.ruangan', 'jadwal.guru', 'jadwal.jamMulai', 'jadwal.jamSelesai',
                'guruTidakHadir.mapel', 'kelas'
            ])
                ->where('id_guru_pengganti', $idGuru)
                ->whereDate('tanggal', $todayDate)
                ->whereIn('status', ['aktif', 'selesai'])
                ->get();
        }

        // Filter jadwal untuk tabel yang ditampilkan
        if ($isViewingAllDays) {
            $jadwals = $semuaJadwalGuru;
            foreach ($penugasansPenggantiHariIni as $p) {
                $jObj = $p->jadwal;
                if (!$jObj && $p->id_kelas && $p->id_guru_tidak_hadir) {
                    $jObj = Jadwal::with(['kelas', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai', 'guru'])
                        ->where('id_guru', $p->id_guru_tidak_hadir)
                        ->where('id_kelas', $p->id_kelas)
                        ->first();
                }
                if ($jObj) {
                    $jObjCopy = clone $jObj;
                    $jObjCopy->is_guru_pengganti = true;
                    $jObjCopy->penugasan_pengganti = $p;
                    $jObjCopy->guru_utama = $p->guruTidakHadir ?? $jObj->guru;
                    if (!$jadwals->contains('id_jadwal', $jObjCopy->id_jadwal)) {
                        $jadwals->push($jObjCopy);
                    }
                }
            }
        } else {
            $jadwals = $semuaJadwalGuru->filter(function($j) use ($hariAktif) {
                return strtolower(trim($j->hari)) === strtolower(trim($hariAktif));
            })->values();

            // Jika hari yang dilihat adalah hari ini, sertakan penugasan guru pengganti hari ini
            if (strtolower($hariAktif) === strtolower($todayIndo)) {
                foreach ($penugasansPenggantiHariIni as $p) {
                    $jObj = $p->jadwal;
                    if (!$jObj && $p->id_kelas && $p->id_guru_tidak_hadir) {
                        $jObj = Jadwal::with(['kelas', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai', 'guru'])
                            ->where('id_guru', $p->id_guru_tidak_hadir)
                            ->where('id_kelas', $p->id_kelas)
                            ->first();
                    }
                    if ($jObj) {
                        $jObjCopy = clone $jObj;
                        $jObjCopy->is_guru_pengganti = true;
                        $jObjCopy->penugasan_pengganti = $p;
                        $jObjCopy->guru_utama = $p->guruTidakHadir ?? $jObj->guru;
                        if (!$jadwals->contains('id_jadwal', $jObjCopy->id_jadwal)) {
                            $jadwals->push($jObjCopy);
                        }
                    }
                }
            }
        }

        // Jadwal Hari Ini Riil (Untuk Penghitungan Metrik Hari Ini)
        $jadwalsHariIniRiil = $semuaJadwalGuru->filter(function($j) use ($todayIndo) {
            return strtolower(trim($j->hari)) === strtolower(trim($todayIndo));
        })->values();

        foreach ($penugasansPenggantiHariIni as $p) {
            $jObj = $p->jadwal;
            if (!$jObj && $p->id_kelas && $p->id_guru_tidak_hadir) {
                $jObj = Jadwal::with(['kelas', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai', 'guru'])
                    ->where('id_guru', $p->id_guru_tidak_hadir)
                    ->where('id_kelas', $p->id_kelas)
                    ->first();
            }
            if ($jObj) {
                $jObjCopy = clone $jObj;
                $jObjCopy->is_guru_pengganti = true;
                $jObjCopy->penugasan_pengganti = $p;
                $jObjCopy->guru_utama = $p->guruTidakHadir ?? $jObj->guru;
                if (!$jadwalsHariIniRiil->contains('id_jadwal', $jObjCopy->id_jadwal)) {
                    $jadwalsHariIniRiil->push($jObjCopy);
                }
            }
        }

        $jadwals = $jadwals->sortBy('id_jam_mulai')->values();
        $jadwalsHariIniRiil = $jadwalsHariIniRiil->sortBy('id_jam_mulai')->values();

        // Penghitungan Jurnal Terisi Hari Ini
        $filledTodayCount = 0;
        foreach ($jadwalsHariIniRiil as $jHariIni) {
            if ($jHariIni->isDiisiHariIni()) {
                $filledTodayCount++;
            }
        }

        // Total Jurnal Terisi Bulan Ini
        $jurnalBulanIniCount = 0;
        if ($idGuru) {
            $jurnalBulanIniCount = JurnalMengajar::whereHas('jadwal', fn($q) => $q->where('id_guru', $idGuru))
                ->whereMonth('tanggal', $now->month)
                ->whereYear('tanggal', $now->year)
                ->count();
        }

        // Total Kelas Berbeda yang Diajar
        $totalKelasDiajar = $semuaJadwalGuru->pluck('id_kelas')->unique()->count();
        if ($totalKelasDiajar == 0 && $kelasWali) {
            $totalKelasDiajar = 1;
        }

        // Total Jam Pelajaran (JP) Seminggu
        $totalJpSeminggu = 0;
        foreach ($semuaJadwalGuru as $jG) {
            $mulai = $jG->id_jam_mulai ?? 1;
            $selesai = $jG->id_jam_selesai ?? $mulai;
            $totalJpSeminggu += max(1, ($selesai - $mulai + 1));
        }

        // Rata-rata Absensi Siswa Riil
        $totalAbsenBulanIni = 0;
        if ($idGuru) {
            $totalAbsenBulanIni = JurnalDetailKetidakhadiran::whereHas('jurnal', function($q) use ($idGuru) {
                $q->whereHas('jadwal', fn($qJ) => $qJ->where('id_guru', $idGuru));
            })->count();
        }
        $classIds = $semuaJadwalGuru->pluck('id_kelas')->unique();
        $totalStudentsInClasses = Siswa::whereIn('id_kelas', $classIds)->count();
        $absensiRataRata = 96; // Default standard benchmark
        if ($jurnalBulanIniCount > 0 && $totalStudentsInClasses > 0) {
            $totalSesiPresensi = max(1, $jurnalBulanIniCount * ($totalStudentsInClasses / max(1, $classIds->count())));
            $absensiRataRata = round((($totalSesiPresensi - $totalAbsenBulanIni) / $totalSesiPresensi) * 100, 1);
            $absensiRataRata = max(75, min(100, $absensiRataRata));
        }

        // Jurnal Terisi per Minggu (M1 - M5) Riil
        $jurnalPerMinggu = [
            'M1' => ['count' => 0, 'range' => '1 - 7 ' . $now->translatedFormat('M'), 'is_current' => ($now->day >= 1 && $now->day <= 7)],
            'M2' => ['count' => 0, 'range' => '8 - 14 ' . $now->translatedFormat('M'), 'is_current' => ($now->day >= 8 && $now->day <= 14)],
            'M3' => ['count' => 0, 'range' => '15 - 21 ' . $now->translatedFormat('M'), 'is_current' => ($now->day >= 15 && $now->day <= 21)],
            'M4' => ['count' => 0, 'range' => '22 - 28 ' . $now->translatedFormat('M'), 'is_current' => ($now->day >= 22 && $now->day <= 28)],
            'M5' => ['count' => 0, 'range' => '29 - 31 ' . $now->translatedFormat('M'), 'is_current' => ($now->day >= 29)],
        ];

        if ($idGuru) {
            $monthJournals = JurnalMengajar::whereHas('jadwal', fn($q) => $q->where('id_guru', $idGuru))
                ->whereMonth('tanggal', $now->month)
                ->whereYear('tanggal', $now->year)
                ->get();

            foreach ($monthJournals as $mj) {
                $day = Carbon::parse($mj->tanggal)->day;
                if ($day <= 7) $jurnalPerMinggu['M1']['count']++;
                elseif ($day <= 14) $jurnalPerMinggu['M2']['count']++;
                elseif ($day <= 21) $jurnalPerMinggu['M3']['count']++;
                elseif ($day <= 28) $jurnalPerMinggu['M4']['count']++;
                else $jurnalPerMinggu['M5']['count']++;
            }
        }

        // Jadwal Jam Berikutnya Riil
        $jadwalBerikutnya = null;
        $currentTimeStr = $now->format('H:i');
        
        // 1. Jika hari ini hari kerja (Senin - Jumat), cari jadwal hari ini yang sedang berlangsung atau belum selesai
        if (!$isWeekend && $semuaJadwalGuru->isNotEmpty()) {
            $kandidatHariIni = clone $jadwalsHariIniRiil;
            foreach ($penugasansPenggantiHariIni as $p) {
                $jObj = $p->jadwal;
                if ($jObj && !$kandidatHariIni->contains('id_jadwal', $jObj->id_jadwal)) {
                    $jObj->is_guru_pengganti = true;
                    $jObj->penugasan_pengganti = $p;
                    $kandidatHariIni->push($jObj);
                }
            }
            $kandidatHariIni = $kandidatHariIni->sortBy(fn($j) => (int)($j->id_jam_mulai ?? 1))->values();

            foreach ($kandidatHariIni as $jHariIni) {
                if ($currentTimeStr <= $jHariIni->waktu_selesai_effective) {
                    $jadwalBerikutnya = $jHariIni;
                    break;
                }
            }
        }

        // 2. Jika tidak ada jadwal tersisa hari ini (atau hari ini libur akhir pekan / seluruh jadwal hari ini sudah selesai jam selesainya),
        // cari jadwal mengajar pada hari kerja berikutnya
        if (!$jadwalBerikutnya && $semuaJadwalGuru->isNotEmpty()) {
            $dayOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
            $startIndex = array_search($todayIndo, $dayOrder);
            if ($startIndex === false) { // Sabtu atau Minggu
                $searchDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
            } else {
                $searchDays = array_merge(
                    array_slice($dayOrder, $startIndex + 1),
                    array_slice($dayOrder, 0, $startIndex + 1)
                );
            }

            foreach ($searchDays as $dayTarget) {
                $nextSchedule = $semuaJadwalGuru->filter(function($j) use ($dayTarget) {
                    return strtolower(trim($j->hari)) === strtolower(trim($dayTarget));
                })->first();

                if ($nextSchedule) {
                    $jadwalBerikutnya = $nextSchedule;
                    break;
                }
            }
        }

        // Berita & Pengumuman Sekolah (Aktif & Belum Dihapus Akun Ini)
        $userId = Auth::id();
        $deletedAnnouncementIds = PengumumanDihapus::where('user_id', $userId)->pluck('id_pengumuman');
        
        $pengumumanQuery = Pengumuman::with(['pembuat', 'kelas'])
            ->whereNotIn('id_pengumuman', $deletedAnnouncementIds)
            ->where(function($q) use ($idGuru) {
                $q->where('kategori', '!=', 'Siswa Telat')
                  ->orWhere(function($sub) use ($idGuru) {
                      $sub->where('kategori', 'Siswa Telat')
                          ->where('id_guru', $idGuru);
                  });
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(4);

        $pengumumanList = $pengumumanQuery->get();
        $totalPengumumanAktif = Pengumuman::whereNotIn('id_pengumuman', $deletedAnnouncementIds)->count();
        $readAnnouncementIds = PengumumanDibaca::where('user_id', $userId)->pluck('id_pengumuman')->toArray();

        // Data Khusus Pantauan Wali Kelas (Jika User Wali Kelas)
        $waliKelasData = null;
        if ($isWaliKelas && $kelasWali) {
            $totalSiswaWali = Siswa::where('id_kelas', $kelasWali->id_kelas)->count();
            
            // Seluruh Jadwal KBM di Kelas Perwalian (Semua Hari)
            $semuaJadwalsKelasWali = Jadwal::with(['guru', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai'])
                ->where('id_kelas', $kelasWali->id_kelas)
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
                ->orderBy('id_jam_mulai', 'asc')
                ->get();

            // Jadwal KBM di Kelas Perwalian pada hari pantau (hari ini atau Senin jika akhir pekan)
            $hariPantauWali = $isWeekend ? 'Senin' : $todayIndo;
            $jadwalsKelasWali = $semuaJadwalsKelasWali->filter(function($jw) use ($hariPantauWali) {
                return strtolower(trim($jw->hari)) === strtolower(trim($hariPantauWali));
            })->values();

            $totalJadwalWali = $jadwalsKelasWali->count();
            $jurnalWaliTerisi = 0;
            foreach ($jadwalsKelasWali as $jw) {
                if ($jw->isDiisiHariIni()) {
                    $jurnalWaliTerisi++;
                }
            }

            // Data Ketidakhadiran Siswa Perwalian Hari Ini (Deduplikasi & Detail Siswa)
            $rekapKetidakhadiranWali = ['sakit' => 0, 'izin' => 0, 'alpa' => 0, 'dispen' => 0];
            $siswaTidakHadirList = [];
            $seenSiswaAbsen = [];

            // 1. Dari Jurnal Mengajar hari ini untuk kelas perwalian
            $jurnalsTodayWali = JurnalMengajar::with(['detailKetidakhadiran.siswa', 'jadwal.mapel', 'jadwal.guru'])
                ->whereHas('jadwal', fn($q) => $q->where('id_kelas', $kelasWali->id_kelas))
                ->whereDate('tanggal', $todayDate)
                ->get();

            foreach ($jurnalsTodayWali as $jWali) {
                foreach ($jWali->detailKetidakhadiran as $detAbsen) {
                    $sId = $detAbsen->id_siswa;
                    if (!$sId) continue;
                    $ketRaw = strtolower(trim($detAbsen->keterangan ?? $detAbsen->status ?? ''));
                    $statusFormatted = 'Alpa';
                    if (str_contains($ketRaw, 'sakit')) $statusFormatted = 'Sakit';
                    elseif (str_contains($ketRaw, 'izin')) $statusFormatted = 'Izin';
                    elseif (str_contains($ketRaw, 'dispen')) $statusFormatted = 'Dispen';
                    elseif (str_contains($ketRaw, 'alpa') || str_contains($ketRaw, 'tanpa')) $statusFormatted = 'Alpa';

                    if (!isset($seenSiswaAbsen[$sId])) {
                        $seenSiswaAbsen[$sId] = $statusFormatted;
                        $rekapKetidakhadiranWali[strtolower($statusFormatted)]++;
                        $siswaTidakHadirList[] = [
                            'id_siswa'   => $sId,
                            'nama'       => $detAbsen->siswa->nama_siswa ?? 'Siswa',
                            'nisn'       => $detAbsen->siswa->nisn ?? $detAbsen->siswa->nis ?? '-',
                            'status'     => $statusFormatted,
                            'keterangan' => 'Dicatat pada KBM ' . ($jWali->jadwal->mapel->nama_mapel ?? 'Mapel') . ' (Guru: ' . ($jWali->jadwal->guru->nama_guru ?? '-') . ')',
                            'sumber'     => 'Jurnal Mengajar',
                        ];
                    }
                }
            }

            // 2. Dari Surat Izin Siswa Perwalian yang Disetujui/Terverifikasi Hari Ini (Multi-day date range support)
            $suratIzinWaliList = SiswaSuratIzin::with('siswa')
                ->where(function($q) use ($todayDate) {
                    $q->whereDate('tanggal', '<=', $todayDate)
                      ->where(function($sq) use ($todayDate) {
                          $sq->whereDate('tanggal_selesai', '>=', $todayDate)
                             ->orWhereNull('tanggal_selesai');
                      });
                })
                ->whereIn('status', ['disetujui', 'Terverifikasi', 'Menunggu'])
                ->where(function($q) use ($kelasWali) {
                    $q->where('id_kelas', $kelasWali->id_kelas)
                      ->orWhereHas('siswa', fn($sq) => $sq->where('id_kelas', $kelasWali->id_kelas));
                })
                ->get();

            foreach ($suratIzinWaliList as $sIzin) {
                $sId = $sIzin->id_siswa;
                if (!$sId) continue;
                $kat = strtolower(trim($sIzin->kategori ?? 'izin'));
                if (str_contains($kat, 'sakit')) {
                    $st = 'Sakit';
                } elseif (str_contains($kat, 'dispen')) {
                    $st = 'Dispen';
                } else {
                    $st = 'Izin';
                }
                if (!isset($seenSiswaAbsen[$sId])) {
                    $seenSiswaAbsen[$sId] = $st;
                    $rekapKetidakhadiranWali[strtolower($st)]++;
                    $siswaTidakHadirList[] = [
                        'id_siswa'   => $sId,
                        'nama'       => $sIzin->siswa->nama_siswa ?? 'Siswa',
                        'nisn'       => $sIzin->siswa->nisn ?? $sIzin->siswa->nis ?? '-',
                        'status'     => $st,
                        'keterangan' => $sIzin->keterangan ?? $sIzin->alasan ?? 'Surat Izin Disetujui',
                        'sumber'     => 'Surat Izin',
                    ];
                }
            }

            // 3. Dari Siswa Dispen Perwalian yang Disetujui Hari Ini
            $dispenWaliList = SiswaDispen::with('siswa')
                ->whereDate('tanggal', $todayDate)
                ->where('status_waka', 'approved')
                ->where('id_kelas', $kelasWali->id_kelas)
                ->get();

            foreach ($dispenWaliList as $sDispen) {
                $sId = $sDispen->id_siswa;
                if (!$sId) continue;
                if (!isset($seenSiswaAbsen[$sId])) {
                    $seenSiswaAbsen[$sId] = 'Dispen';
                    $rekapKetidakhadiranWali['dispen']++;
                    $siswaTidakHadirList[] = [
                        'id_siswa'   => $sId,
                        'nama'       => $sDispen->siswa->nama_siswa ?? 'Siswa',
                        'nisn'       => $sDispen->siswa->nisn ?? $sDispen->siswa->nis ?? '-',
                        'status'     => 'Dispen',
                        'keterangan' => $sDispen->alasan ?? $sDispen->keterangan ?? 'Dispensasi Disetujui Waka',
                        'sumber'     => 'Surat Dispensasi',
                    ];
                }
            }

            $totalTidakHadirWali = count($seenSiswaAbsen);
            $totalHadirWali = max(0, $totalSiswaWali - $totalTidakHadirWali);
            $persenHadirWali = $totalSiswaWali > 0 ? round(($totalHadirWali / $totalSiswaWali) * 100, 1) : 100;

            $waliKelasData = [
                'kelas'                 => $kelasWali,
                'totalSiswa'            => $totalSiswaWali,
                'totalHadir'            => $totalHadirWali,
                'persenHadir'           => $persenHadirWali,
                'rekapAbsen'            => $rekapKetidakhadiranWali,
                'siswaTidakHadirList'   => $siswaTidakHadirList,
                'semuaJadwals'          => $semuaJadwalsKelasWali,
                'jadwals'               => $jadwalsKelasWali,
                'totalJadwal'           => $totalJadwalWali,
                'jurnalTerisi'          => $jurnalWaliTerisi,
                'hariPantau'            => $hariPantauWali,
            ];
        }

        $stats = [
            'totalJurnalTerisi'   => $isWeekend ? "{$jurnalBulanIniCount} Jurnal" : "{$filledTodayCount}/" . max(count($jadwalsHariIniRiil), 1),
            'subTotalJurnal'      => $isWeekend ? "Terverifikasi bulan ini" : "{$jurnalBulanIniCount} terisi bulan ini",
            'totalKelasDiajar'    => "{$totalKelasDiajar} Kelas",
            'subKelasDiajar'      => $isWeekend ? "{$totalJpSeminggu} JP / Minggu aktif" : count($jadwalsHariIniRiil) . " jadwal aktif hari ini",
            'absensiRataRata'     => "{$absensiRataRata}%",
            'jurnalPerMinggu'     => $jurnalPerMinggu,
            'totalJpSeminggu'     => $totalJpSeminggu,
            'jurnalBulanIniCount' => $jurnalBulanIniCount,
        ];

        $hariIni = $todayIndo;

        return view('guru.dashboard', compact(
            'hariIni',
            'todayIndo',
            'hariAktif',
            'isWeekend',
            'isViewingAllDays',
            'jadwals',
            'semuaJadwalGuru',
            'stats',
            'currentTimeStr',
            'jadwalBerikutnya',
            'pengumumanList',
            'totalPengumumanAktif',
            'readAnnouncementIds',
            'isWaliKelas',
            'kelasWali',
            'waliKelasData',
            'tahunAjaranAktif'
        ));
    }

    /**
     * Ekspor Rekap Jurnal Mengajar Guru / Rekap Kehadiran Wali Kelas ke CSV
     */
    public function exportRekapCsv(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $idKelas = $request->input('id_kelas');
        $bulanSelected = (int) ($request->input('bulan_selected') ?? $request->input('bulan') ?? date('m'));
        $tahunSelected = (int) ($request->input('tahun_selected') ?? $request->input('tahun') ?? date('Y'));

        // Jika dipanggil dengan id_kelas atau oleh Wali Kelas
        if ($idKelas || $request->has('tab')) {
            $kelas = Kelas::find($idKelas);
            if (!$kelas) {
                $guruModel = $user->id_guru ? Guru::find($user->id_guru) : Guru::where('nip', $user->nip)->first();
                $guruNip = $guruModel ? $guruModel->nip : $user->nip;
                $kelas = Kelas::where('wali_kelas', $guruNip)->first() ?? Kelas::first();
            }

            if ($kelas) {
                $siswas = Siswa::where('id_kelas', $kelas->id_kelas)->orderBy('nama_siswa', 'asc')->get();
                $startMonth = Carbon::create($tahunSelected, $bulanSelected, 1);
                $daysInMonth = $startMonth->daysInMonth;

                $hariEfektif = 0;
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    if (!Carbon::create($tahunSelected, $bulanSelected, $d)->isWeekend()) {
                        $hariEfektif++;
                    }
                }
                $hariEfektif = max(1, $hariEfektif);

                $cleanKelasName = str_replace(' ', '_', $kelas->nama_kelas);
                $filename = "Rekap_Kehadiran_{$cleanKelasName}_{$bulanSelected}_{$tahunSelected}.csv";

                $headers = [
                    "Content-type"        => "text/csv; charset=UTF-8",
                    "Content-Disposition" => "attachment; filename=\"{$filename}\"",
                    "Pragma"              => "no-cache",
                    "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                    "Expires"             => "0"
                ];

                $callback = function() use ($siswas, $kelas, $bulanSelected, $tahunSelected, $hariEfektif) {
                    $file = fopen('php://output', 'w');
                    fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                    fputcsv($file, ["REKAP KEHADIRAN SISWA KELAS PERWALIAN"]);
                    fputcsv($file, ["Kelas", $kelas->nama_kelas]);
                    fputcsv($file, ["Bulan / Tahun", Carbon::create($tahunSelected, $bulanSelected, 1)->translatedFormat('F Y')]);
                    fputcsv($file, ["Hari Efektif Sekolah", $hariEfektif]);
                    fputcsv($file, []);

                    fputcsv($file, ['No', 'NIS', 'NISN', 'Nama Siswa', 'Hadir', 'Sakit', 'Izin', 'Alpa', 'Total Tidak Hadir', '% Kehadiran', 'Status']);

                    $no = 1;
                    foreach ($siswas as $s) {
                        $absences = JurnalDetailKetidakhadiran::where('id_siswa', $s->id_siswa)
                            ->whereHas('jurnal', function($q) use ($bulanSelected, $tahunSelected) {
                                $q->whereMonth('tanggal', $bulanSelected)->whereYear('tanggal', $tahunSelected);
                            })->get();

                        $sakit = $absences->where('keterangan', 'Sakit')->count();
                        $izin  = $absences->where('keterangan', 'Izin')->count();
                        $alpa  = $absences->whereIn('keterangan', ['Alpa', 'Tanpa Keterangan'])->count();

                        $totAbsen = $sakit + $izin + $alpa;
                        $hadirCount = max(0, $hariEfektif - $totAbsen);
                        $persenHadir = round((($hariEfektif - $totAbsen) / $hariEfektif) * 100, 1);
                        $persenHadir = max(0, min(100, $persenHadir));

                        $statusText = 'Baik';
                        if ($persenHadir < 75 || $alpa >= 3) {
                            $statusText = 'Perlu tindak lanjut';
                        } elseif ($persenHadir < 85 || $totAbsen >= 2) {
                            $statusText = 'Perlu pantau';
                        }

                        fputcsv($file, [
                            $no++,
                            $s->nis ?? '-',
                            $s->nisn ?? '-',
                            $s->nama_siswa,
                            $hadirCount,
                            $sakit,
                            $izin,
                            $alpa,
                            $totAbsen,
                            $persenHadir . '%',
                            $statusText
                        ]);
                    }

                    fclose($file);
                };

                return response()->stream($callback, 200, $headers);
            }
        }

        // Default: Ekspor Rekap Jurnal Mengajar Guru
        $guru = $user ? ($user->guru ?? ($user->nip ? Guru::where('nip', $user->nip)->first() : null)) : null;
        $idGuru = $guru->id_guru ?? ($user->id_guru ?? null);
        $guruNameSlug = $guru ? Str::slug($guru->nama_guru) : ($user ? Str::slug($user->name) : 'guru');
        $filename = "rekap_jurnal_mengajar_{$guruNameSlug}_" . date('Y-m-d_H-i') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $query = JurnalMengajar::with(['jadwal.mapel', 'jadwal.kelas', 'jadwal.ruangan', 'jadwal.guru', 'detailKetidakhadiran.siswa'])
            ->orderBy('tanggal', 'desc');

        if ($idGuru) {
            $query->where(function($q) use ($idGuru) {
                $q->whereHas('jadwal', fn($qJ) => $qJ->where('id_guru', $idGuru))
                  ->orWhere('id_guru_pengganti', $idGuru);
            });
        }

        $jurnals = $query->get();

        $callback = function() use ($jurnals) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'No', 'Tanggal', 'Hari', 'Kelas', 'Ruangan', 'Mata Pelajaran', 
                'Pertemuan Ke', 'Jam Ke', 'Status Kehadiran Guru', 'Kondisi Kelas', 
                'Materi Pembelajaran', 'Catatan Kelas', 'Jumlah Siswa Tidak Hadir'
            ]);

            $daysInIndo = [
                'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
            ];

            foreach ($jurnals as $index => $j) {
                $cDate = Carbon::parse($j->tanggal);
                $hari = $daysInIndo[$cDate->format('l')] ?? $cDate->format('l');
                $absenCount = $j->detailKetidakhadiran ? $j->detailKetidakhadiran->count() : 0;

                fputcsv($file, [
                    $index + 1,
                    $cDate->format('d/m/Y'),
                    $hari,
                    $j->jadwal && $j->jadwal->kelas ? $j->jadwal->kelas->nama_kelas : '-',
                    $j->jadwal && $j->jadwal->ruangan ? $j->jadwal->ruangan->nama_ruangan : '-',
                    $j->jadwal && $j->jadwal->mapel ? $j->jadwal->mapel->nama_mapel : '-',
                    $j->pertemuan_ke ?: '1',
                    $j->jam_ke ?: '-',
                    $j->status_kehadiran_guru ?: 'Hadir',
                    $j->kondisi_kelas ?: 'Kondusif',
                    $j->materi ?: '-',
                    $j->catatan ?: '-',
                    $absenCount . ' Siswa'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Halaman Informasi Pengumuman untuk Guru Mengajar
     */
    /**
     * Halaman Informasi Pengumuman untuk Guru Mengajar & Wali Kelas
     */
    public function pengumuman(Request $request)
    {
        $search           = $request->input('q');
        $kategoriFilter   = $request->input('kategori');
        $statusFilter     = $request->input('status');
        $tanggalFilter    = $request->input('tanggal');
        $readStatusFilter = $request->input('read_status');

        $userId = Auth::id();
        // IDs of announcements soft-deleted/hidden by THIS specific user account
        $deletedIds = PengumumanDihapus::where('user_id', $userId)->pluck('id_pengumuman');

        $query = Pengumuman::with(['kelas', 'pembuat'])
            ->whereNotIn('id_pengumuman', $deletedIds)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        if (Auth::check()) {
            $userAuth = Auth::user();
            $guruId = $userAuth->id_guru ?? null;
            if (!$guruId && $userAuth->nip) {
                $findG = Guru::where('nip', $userAuth->nip)->first();
                if ($findG) $guruId = $findG->id_guru;
            }

            if ($guruId && !$userAuth->isAdmin() && !$userAuth->isWaka()) {
                $query->where(function($q) use ($guruId) {
                    // Pengumuman Sekolah Umum (Semua Kategori selain Siswa Telat)
                    $q->where('kategori', '!=', 'Siswa Telat')
                      // ATAU Notifikasi Siswa Telat Khusus untuk Guru Mengajar ini
                      ->orWhere(function($sub) use ($guruId) {
                          $sub->where('kategori', 'Siswa Telat')
                              ->where('id_guru', $guruId);
                      });
                });
            }
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if (!empty($kategoriFilter)) {
            $query->where('kategori', $kategoriFilter);
        }

        if (!empty($statusFilter)) {
            $query->whereIn('status', [strtolower($statusFilter), ucfirst(strtolower($statusFilter))]);
        }

        if (!empty($tanggalFilter)) {
            $query->whereDate('tanggal', $tanggalFilter);
        }

        $allVisiblePengumuman = $query->get();

        // Get list of read announcement IDs for current user
        $readAnnouncementIds = PengumumanDibaca::where('user_id', $userId)->pluck('id_pengumuman')->toArray();

        // Filter by read status if user selects filter
        if ($readStatusFilter === 'unread') {
            $pengumumanList = $allVisiblePengumuman->filter(function($p) use ($readAnnouncementIds) {
                return !in_array($p->id_pengumuman, $readAnnouncementIds);
            })->values();
        } elseif ($readStatusFilter === 'read') {
            $pengumumanList = $allVisiblePengumuman->filter(function($p) use ($readAnnouncementIds) {
                return in_array($p->id_pengumuman, $readAnnouncementIds);
            })->values();
        } else {
            $pengumumanList = $allVisiblePengumuman;
        }

        // Calculate stats for view
        $totalPengumuman = $allVisiblePengumuman->count();
        $totalUnread     = $allVisiblePengumuman->filter(fn($p) => !in_array($p->id_pengumuman, $readAnnouncementIds))->count();
        $totalRead       = $allVisiblePengumuman->filter(fn($p) => in_array($p->id_pengumuman, $readAnnouncementIds))->count();

        $stats = [
            'totalPengumuman'   => $totalPengumuman,
            'totalUnread'       => $totalUnread,
            'totalRead'         => $totalRead,
            'pengumumanAktif'   => $allVisiblePengumuman->filter(fn($p) => strtolower($p->status ?? 'aktif') === 'aktif')->count(),
            'pengumumanSelesai' => $allVisiblePengumuman->filter(fn($p) => strtolower($p->status ?? '') === 'selesai')->count(),
        ];

        // Trash count isolated specifically for current logged-in user account
        $trashedCount = $deletedIds->count();

        return view('guru.pengumuman', compact(
            'pengumumanList',
            'readAnnouncementIds',
            'stats',
            'search',
            'kategoriFilter',
            'statusFilter',
            'tanggalFilter',
            'readStatusFilter',
            'trashedCount'
        ));
    }

    /**
     * Tandai Satu Pengumuman Sebagai Sudah Dibaca
     */
    public function markPengumumanRead(Request $request, $id)
    {
        $userId = Auth::id();
        PengumumanDibaca::firstOrCreate(
            [
                'id_pengumuman' => $id,
                'user_id'       => $userId,
            ],
            [
                'read_at' => now(),
            ]
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengumuman telah ditandai sebagai sudah dibaca.',
                'is_read' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Pengumuman telah ditandai sebagai sudah dibaca.');
    }

    /**
     * Toggle Tandai Pengumuman Sudah Dibaca / Belum Dibaca
     */
    public function togglePengumumanRead(Request $request, $id)
    {
        $userId = Auth::id();
        $existing = PengumumanDibaca::where('id_pengumuman', $id)->where('user_id', $userId)->first();

        if ($existing) {
            $existing->delete();
            $isRead = false;
            $msg = 'Pengumuman ditandai sebagai belum dibaca (Baru).';
        } else {
            PengumumanDibaca::create([
                'id_pengumuman' => $id,
                'user_id'       => $userId,
                'read_at'       => now(),
            ]);
            $isRead = true;
            $msg = 'Pengumuman ditandai sebagai sudah dibaca.';
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'is_read' => $isRead,
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Tandai Semua Pengumuman Sebagai Sudah Dibaca
     */
    public function markAllPengumumanRead(Request $request)
    {
        $userId = Auth::id();
        $deletedIds = PengumumanDihapus::where('user_id', $userId)->pluck('id_pengumuman');
        $query = Pengumuman::whereNotIn('id_pengumuman', $deletedIds);

        if (Auth::check()) {
            $userAuth = Auth::user();
            $guruId = $userAuth->id_guru ?? null;
            if (!$guruId && $userAuth->nip) {
                $findG = Guru::where('nip', $userAuth->nip)->first();
                if ($findG) $guruId = $findG->id_guru;
            }
            if ($guruId && !$userAuth->isAdmin() && !$userAuth->isWaka()) {
                $query->where(function($q) use ($guruId) {
                    $q->where('kategori', '!=', 'Siswa Telat')
                      ->orWhere(function($sub) use ($guruId) {
                          $sub->where('kategori', 'Siswa Telat')
                              ->where('id_guru', $guruId);
                      });
                });
            }
        }

        $allIds = $query->pluck('id_pengumuman');
        $count = 0;
        foreach ($allIds as $idPengumuman) {
            $created = PengumumanDibaca::firstOrCreate(
                [
                    'id_pengumuman' => $idPengumuman,
                    'user_id'       => $userId,
                ],
                [
                    'read_at' => now(),
                ]
            );
            if ($created->wasRecentlyCreated) {
                $count++;
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Semua pengumuman ({$allIds->count()} data) berhasil ditandai sudah dibaca.",
                'count'   => $count,
            ]);
        }

        return redirect()->back()->with('success', "Semua pengumuman ({$allIds->count()} data) berhasil ditandai sudah dibaca.");
    }

    /**
     * Soft Delete Single Pengumuman / Notifikasi Siswa Telat (Portal Guru / Isolated Per-Account)
     */
    public function destroyPengumuman($id)
    {
        $userId = Auth::id();
        
        // Hide/delete ONLY for this specific user account
        PengumumanDihapus::firstOrCreate([
            'id_pengumuman' => $id,
            'user_id'       => $userId,
        ]);

        return redirect()->route('guru.pengumuman')
            ->with('success', 'Pengumuman / Pemberitahuan berhasil dipindahkan ke Sampah akun Anda.');
    }

    /**
     * Soft Delete Batch Pengumuman / Notifikasi Siswa Telat (Portal Guru / Isolated Per-Account)
     */
    public function destroyBatchPengumuman(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:pengumuman,id_pengumuman',
        ], [
            'ids.required' => 'Silakan pilih minimal satu item pengumuman / pemberitahuan untuk dihapus.',
            'ids.min'      => 'Silakan pilih minimal satu item pengumuman / pemberitahuan untuk dihapus.',
            'ids.*.exists' => 'Data pengumuman yang dipilih tidak valid.',
        ]);

        $userId = Auth::id();
        $count = 0;
        foreach ($request->ids as $id) {
            PengumumanDihapus::firstOrCreate([
                'id_pengumuman' => $id,
                'user_id'       => $userId,
            ]);
            $count++;
        }

        return redirect()->route('guru.pengumuman')
            ->with('success', "Sebanyak {$count} item pengumuman / pemberitahuan terpilih berhasil dipindahkan ke Sampah akun Anda.");
    }

    /**
     * Halaman Sampah (Trash) Pengumuman & Pemberitahuan Siswa Telat (Portal Guru / Account Isolated)
     */
    public function trashPengumuman(Request $request)
    {
        $userId = Auth::id();
        $deletedIds = PengumumanDihapus::where('user_id', $userId)->pluck('id_pengumuman');

        $trashedList = Pengumuman::with(['kelas', 'pembuat'])
            ->whereIn('id_pengumuman', $deletedIds)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('guru.pengumuman_trash', compact('trashedList'));
    }

    /**
     * Restore Pengumuman dari Sampah (Portal Guru / Account Isolated)
     */
    public function restorePengumuman($id)
    {
        $userId = Auth::id();
        PengumumanDihapus::where('id_pengumuman', $id)
            ->where('user_id', $userId)
            ->delete();

        return redirect()->route('guru.pengumuman.trash')
            ->with('success', 'Pengumuman / Pemberitahuan berhasil dipulihkan ke halaman utama Anda.');
    }

    /**
     * Force Delete Pengumuman secara Permanen dari Akun Ini (Portal Guru / Account Isolated)
     */
    public function forceDeletePengumuman($id)
    {
        $userId = Auth::id();
        PengumumanDihapus::where('id_pengumuman', $id)
            ->where('user_id', $userId)
            ->delete();

        $pengumuman = Pengumuman::find($id);
        if ($pengumuman && $pengumuman->kategori === 'Siswa Telat' && Auth::user() && $pengumuman->id_guru == Auth::user()->id_guru) {
            $telat = SiswaTelat::where('id_pengumuman', $id)->first();
            if ($telat) $telat->delete();
            $pengumuman->delete();
        }

        return redirect()->route('guru.pengumuman.trash')
            ->with('success', 'Pengumuman / Pemberitahuan berhasil dihapus secara permanen dari akun Anda.');
    }

    /**
     * Kosongkan Seluruh Sampah Pengumuman Akun Ini (Portal Guru / Account Isolated)
     */
    public function emptyTrashPengumuman()
    {
        $userId = Auth::id();
        $userAuth = Auth::user();
        $deletedRecords = PengumumanDihapus::where('user_id', $userId)->get();

        foreach ($deletedRecords as $rec) {
            $pengumuman = Pengumuman::find($rec->id_pengumuman);
            if ($pengumuman && $pengumuman->kategori === 'Siswa Telat' && $userAuth && $pengumuman->id_guru == $userAuth->id_guru) {
                $telat = SiswaTelat::where('id_pengumuman', $rec->id_pengumuman)->first();
                if ($telat) $telat->delete();
                $pengumuman->delete();
            }
            $rec->delete();
        }

        return redirect()->route('guru.pengumuman.trash')
            ->with('success', 'Seluruh data sampah pengumuman / pemberitahuan akun Anda berhasil dikosongkan.');
    }

    /**
     * Jadwal Mengajar Guru & Wali Kelas (Jadwal Mengajar Saya & Jadwal KBM Kelas Perwalian)
     */
    public function jadwalMengajar(Request $request)
    {
        $daysInIndonesian = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Senin',
            'Sunday'    => 'Senin',
        ];

        $now = Carbon::now('Asia/Jakarta');
        $todayEnglish = $now->format('l');
        $todayIndo = $daysInIndonesian[$todayEnglish] ?? 'Senin';

        $hariFilter = strtolower($request->input('hari', $todayIndo));
        if (!in_array($hariFilter, ['semua', 'senin', 'selasa', 'rabu', 'kamis', 'jumat'])) {
            $hariFilter = strtolower($todayIndo);
        }

        $activeTab    = $request->input('tab', 'saya'); // 'saya' or 'perwalian'
        $viewMode     = $request->input('tampilan', 'tabel'); // 'tabel' or 'matriks'
        $searchQuery  = trim($request->input('q', ''));
        $statusFilter = $request->input('status_kbm', 'semua');

        // Hitung tanggal kalender Senin s/d Jumat untuk minggu aktif
        $startOfWeek = $now->isWeekend() 
            ? $now->copy()->next(Carbon::MONDAY) 
            : $now->copy()->startOfWeek(Carbon::MONDAY);

        $dayDates = [
            'senin'  => [
                'name'      => 'SENIN',
                'day_name'  => 'Senin',
                'num'       => $startOfWeek->copy()->format('j'),
                'date'      => $startOfWeek->copy()->toDateString(),
                'formatted' => $startOfWeek->copy()->translatedFormat('d M Y'),
                'full'      => $startOfWeek->copy()->translatedFormat('l, d F Y'),
                'is_today'  => $now->isSameDay($startOfWeek),
            ],
            'selasa' => [
                'name'      => 'SELASA',
                'day_name'  => 'Selasa',
                'num'       => $startOfWeek->copy()->addDays(1)->format('j'),
                'date'      => $startOfWeek->copy()->addDays(1)->toDateString(),
                'formatted' => $startOfWeek->copy()->addDays(1)->translatedFormat('d M Y'),
                'full'      => $startOfWeek->copy()->addDays(1)->translatedFormat('l, d F Y'),
                'is_today'  => $now->isSameDay($startOfWeek->copy()->addDays(1)),
            ],
            'rabu'   => [
                'name'      => 'RABU',
                'day_name'  => 'Rabu',
                'num'       => $startOfWeek->copy()->addDays(2)->format('j'),
                'date'      => $startOfWeek->copy()->addDays(2)->toDateString(),
                'formatted' => $startOfWeek->copy()->addDays(2)->translatedFormat('d M Y'),
                'full'      => $startOfWeek->copy()->addDays(2)->translatedFormat('l, d F Y'),
                'is_today'  => $now->isSameDay($startOfWeek->copy()->addDays(2)),
            ],
            'kamis'  => [
                'name'      => 'KAMIS',
                'day_name'  => 'Kamis',
                'num'       => $startOfWeek->copy()->addDays(3)->format('j'),
                'date'      => $startOfWeek->copy()->addDays(3)->toDateString(),
                'formatted' => $startOfWeek->copy()->addDays(3)->translatedFormat('d M Y'),
                'full'      => $startOfWeek->copy()->addDays(3)->translatedFormat('l, d F Y'),
                'is_today'  => $now->isSameDay($startOfWeek->copy()->addDays(3)),
            ],
            'jumat'  => [
                'name'      => 'JUMAT',
                'day_name'  => 'Jumat',
                'num'       => $startOfWeek->copy()->addDays(4)->format('j'),
                'date'      => $startOfWeek->copy()->addDays(4)->toDateString(),
                'formatted' => $startOfWeek->copy()->addDays(4)->translatedFormat('d M Y'),
                'full'      => $startOfWeek->copy()->addDays(4)->translatedFormat('l, d F Y'),
                'is_today'  => $now->isSameDay($startOfWeek->copy()->addDays(4)),
            ],
        ];

        $targetDate = ($hariFilter !== 'semua' && isset($dayDates[$hariFilter]))
            ? $dayDates[$hariFilter]['date']
            : $now->toDateString();

        $user = Auth::user();
        $guru = $user ? ($user->guru ?? ($user->nip ? Guru::where('nip', $user->nip)->first() : null)) : null;
        $idGuru = $guru ? $guru->id_guru : ($user->id_guru ?? null);

        // Deteksi Wali Kelas
        $kelasWali = null;
        if ($user) {
            $nips = array_filter([$user->nip, optional($guru)->nip]);
            if (!empty($nips)) {
                $kelasWali = Kelas::with(['jurusan', 'ruangan'])->whereIn('wali_kelas', $nips)->first();
            }
        }
        $isWaliKelas = ($kelasWali !== null) || ($user && $user->isWaliKelas());

        if ($activeTab === 'perwalian' && !$isWaliKelas) {
            $activeTab = 'saya';
        }

        // 1. Ambil SEMUA Jadwal Mengajar Guru Pribadi
        $semuaJadwalGuru = collect();
        if ($idGuru) {
            $semuaJadwalGuru = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamPelajaran', 'jamMulai', 'jamSelesai'])
                ->where('id_guru', $idGuru)
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
                ->orderBy('id_jam_mulai', 'asc')
                ->get();
        }

        // Penugasan Guru Pengganti untuk Guru Ini
        $penugasansPengganti = collect();
        if ($idGuru) {
            $penugasansPengganti = \App\Models\PenugasanGuruPengganti::with(['jadwal.kelas', 'jadwal.mapel', 'jadwal.ruangan', 'jadwal.guru', 'jadwal.jamMulai', 'jadwal.jamSelesai'])
                ->where('id_guru_pengganti', $idGuru)
                ->where('status', 'aktif')
                ->get();
        }

        // 2. Ambil Jadwal Kelas Perwalian (Jika User adalah Wali Kelas)
        $semuaJadwalPerwalian = collect();
        if ($isWaliKelas && $kelasWali) {
            $semuaJadwalPerwalian = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamPelajaran', 'jamMulai', 'jamSelesai'])
                ->where('id_kelas', $kelasWali->id_kelas)
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
                ->orderBy('id_jam_mulai', 'asc')
                ->get();
        }

        // Tentukan data source jadwal aktif berdasarkan tab yang dipilih
        if ($activeTab === 'perwalian' && $isWaliKelas) {
            $baseJadwals = clone $semuaJadwalPerwalian;
        } else {
            $baseJadwals = clone $semuaJadwalGuru;
            // Sertakan penugasan guru pengganti pada jadwal pribadi
            foreach ($penugasansPengganti as $p) {
                $jObj = $p->jadwal;
                if ($jObj && !$baseJadwals->contains('id_jadwal', $jObj->id_jadwal)) {
                    $jObj->is_guru_pengganti = true;
                    $jObj->penugasan_pengganti = $p;
                    $baseJadwals->push($jObj);
                }
            }
        }

        // Fallback jika bukan guru dan jadwal kosong
        if ($baseJadwals->isEmpty() && !$idGuru) {
            $baseJadwals = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamPelajaran', 'jamMulai', 'jamSelesai'])
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
                ->orderBy('id_jam_mulai', 'asc')
                ->limit(8)
                ->get();
        }

        // Filter berdasarkan Hari
        $filteredJadwals = $baseJadwals;
        if ($hariFilter !== 'semua') {
            $filteredJadwals = $filteredJadwals->filter(function($j) use ($hariFilter) {
                return strtolower(trim($j->hari)) === strtolower(trim($hariFilter));
            })->values();
        }

        // Filter berdasarkan Pencarian (Query Search)
        if (!empty($searchQuery)) {
            $qLower = strtolower($searchQuery);
            $filteredJadwals = $filteredJadwals->filter(function($j) use ($qLower) {
                $kelasName = strtolower($j->kelas->nama_kelas ?? '');
                $mapelName = strtolower($j->mapel->nama_mapel ?? '');
                $guruName  = strtolower($j->guru->nama_guru ?? '');
                $ruangName = strtolower($j->ruangan->nama_ruangan ?? '');
                return str_contains($kelasName, $qLower) 
                    || str_contains($mapelName, $qLower) 
                    || str_contains($guruName, $qLower) 
                    || str_contains($ruangName, $qLower);
            })->values();
        }

        // Filter berdasarkan Status KBM
        if (!empty($statusFilter) && $statusFilter !== 'semua') {
            $filteredJadwals = $filteredJadwals->filter(function($j) use ($statusFilter, $dayDates, $now) {
                $hKey = strtolower(trim($j->hari));
                $tDate = $dayDates[$hKey]['date'] ?? $now->toDateString();
                $isTargetToday = ($dayDates[$hKey]['is_today'] ?? false);
                $isPast = ($tDate < $now->toDateString());
                $sudahDiisi = $j->isDiisiPadaTanggal($tDate);
                $sudahMasuk = $j->sudah_masuk_jam;
                $isSedangBerlangsung = $isTargetToday && $j->is_sedang_berlangsung;

                if ($statusFilter === 'selesai') {
                    return $sudahDiisi;
                } elseif ($statusFilter === 'berlangsung') {
                    return !$sudahDiisi && $isSedangBerlangsung;
                } elseif ($statusFilter === 'belum_mulai') {
                    return !$sudahDiisi && !$isPast && !$sudahMasuk;
                } elseif ($statusFilter === 'terlewat') {
                    return !$sudahDiisi && ($isPast || ($isTargetToday && $j->is_jam_sudah_selesai));
                }
                return true;
            })->values();
        }

        $jadwals = $filteredJadwals;

        // Siapkan struktur matriks mingguan (Timetable Grid by Day & Hour 1..13)
        $jadwalsMatrixByDay = [
            'Senin'  => collect(),
            'Selasa' => collect(),
            'Rabu'   => collect(),
            'Kamis'  => collect(),
            'Jumat'  => collect(),
        ];
        foreach ($baseJadwals as $jItem) {
            $hCapital = ucfirst(strtolower(trim($jItem->hari)));
            if (isset($jadwalsMatrixByDay[$hCapital])) {
                $jadwalsMatrixByDay[$hCapital]->push($jItem);
            }
        }

        // Master Jam Pelajaran untuk Grid Matriks
        $masterJamList = JamPelajaran::orderBy('id_jam', 'asc')->get();

        // 3. Ringkasan & Statistik Progres Jurnal
        $totalJadwalTarget = $jadwals->count();
        $terisiCount = 0;
        foreach ($jadwals as $jCheck) {
            $hKey = strtolower(trim($jCheck->hari));
            $tDate = $dayDates[$hKey]['date'] ?? $targetDate;
            if ($jCheck->isDiisiPadaTanggal($tDate)) {
                $terisiCount++;
            }
        }
        $persenTerisi = $totalJadwalTarget > 0 ? (int) round(($terisiCount / $totalJadwalTarget) * 100) : 100;
        $statsProgres = [
            'total'  => $totalJadwalTarget,
            'terisi' => $terisiCount,
            'persen' => $persenTerisi,
        ];

        // 4. Beban Mengajar Guru (JP)
        $totalJpSeminggu = 0;
        $jpHarianBreakdown = ['senin' => 0, 'selasa' => 0, 'rabu' => 0, 'kamis' => 0, 'jumat' => 0];

        foreach ($semuaJadwalGuru as $jG) {
            $jpCount = $jG->jumlah_jp;
            $totalJpSeminggu += $jpCount;

            $hLower = strtolower(trim($jG->hari));
            if (isset($jpHarianBreakdown[$hLower])) {
                $jpHarianBreakdown[$hLower] += $jpCount;
            }
        }

        $totalJpHariIni = 0;
        $totalJpTerisiHariIni = 0;
        $jadwalsHariIniGuru = $semuaJadwalGuru->filter(fn($j) => strtolower(trim($j->hari)) === strtolower(trim($todayIndo)));
        foreach ($jadwalsHariIniGuru as $jItem) {
            $jpCount = $jItem->jumlah_jp;
            $totalJpHariIni += $jpCount;
            if ($jItem->isDiisiHariIni()) {
                $totalJpTerisiHariIni += $jpCount;
            }
        }

        $statsBeban = [
            'totalJpSeminggu'      => $totalJpSeminggu,
            'totalJpHariIni'       => $totalJpHariIni,
            'totalJpTerisiHariIni' => $totalJpTerisiHariIni,
            'jpHarian'             => $jpHarianBreakdown,
            'totalKelasDiajar'     => $semuaJadwalGuru->pluck('id_kelas')->unique()->count(),
            'totalMapelDiajar'     => $semuaJadwalGuru->pluck('id_mapel')->unique()->count(),
        ];

        // 5. Data Khusus Wali Kelas
        $dataWaliKelas = null;
        if ($isWaliKelas && $kelasWali) {
            $totalSiswaWali = Siswa::where('id_kelas', $kelasWali->id_kelas)->count();
            
            // Cari Jurnal Mengajar untuk kelas wali pada tanggal terpilih
            $jurnalWali = JurnalMengajar::whereHas('jadwal', function($q) use ($kelasWali) {
                    $q->where('id_kelas', $kelasWali->id_kelas);
                })
                ->whereDate('tanggal', $targetDate)
                ->get();

            $rekapKetidakhadiran = [
                'sakit' => 0,
                'izin'  => 0,
                'alpa'  => 0,
                'dispen'=> 0,
            ];

            if ($jurnalWali->isNotEmpty()) {
                $jurnalIds = $jurnalWali->pluck('id_jurnal');
                $details = JurnalDetailKetidakhadiran::whereIn('id_jurnal', $jurnalIds)->get();

                $seen = [];
                foreach ($details as $d) {
                    $sId = $d->id_siswa;
                    if (!$sId || isset($seen[$sId])) continue;
                    $ket = strtolower(trim($d->keterangan ?? $d->status ?? ''));
                    if (str_contains($ket, 'sakit')) {
                        $rekapKetidakhadiran['sakit']++;
                        $seen[$sId] = true;
                    } elseif (str_contains($ket, 'dispen')) {
                        $rekapKetidakhadiran['dispen']++;
                        $seen[$sId] = true;
                    } elseif (str_contains($ket, 'izin')) {
                        $rekapKetidakhadiran['izin']++;
                        $seen[$sId] = true;
                    } elseif (str_contains($ket, 'alpa') || str_contains($ket, 'tanpa')) {
                        $rekapKetidakhadiran['alpa']++;
                        $seen[$sId] = true;
                    }
                }
            }

            // Gabungkan surat izin siswa perwalian (Multi-day date range support)
            $suratIzinList = SiswaSuratIzin::where(function($q) use ($targetDate) {
                    $q->whereDate('tanggal', '<=', $targetDate)
                      ->where(function($sq) use ($targetDate) {
                          $sq->whereDate('tanggal_selesai', '>=', $targetDate)
                             ->orWhereNull('tanggal_selesai');
                      });
                })
                ->whereIn('status', ['disetujui', 'Terverifikasi', 'Menunggu'])
                ->where(function($q) use ($kelasWali) {
                    $q->where('id_kelas', $kelasWali->id_kelas)
                      ->orWhereHas('siswa', fn($sq) => $sq->where('id_kelas', $kelasWali->id_kelas));
                })
                ->get();

            foreach ($suratIzinList as $sIzin) {
                $kat = strtolower(trim($sIzin->kategori ?? 'izin'));
                if (str_contains($kat, 'sakit')) $rekapKetidakhadiran['sakit']++;
                elseif (str_contains($kat, 'dispen')) $rekapKetidakhadiran['dispen']++;
                else $rekapKetidakhadiran['izin']++;
            }

            // Gabungkan dispen siswa perwalian
            $dispenCount = SiswaDispen::whereDate('tanggal', $targetDate)
                ->where('status_waka', 'approved')
                ->where('id_kelas', $kelasWali->id_kelas)
                ->count();
            $rekapKetidakhadiran['dispen'] += $dispenCount;

            $totalTidakHadir = array_sum($rekapKetidakhadiran);
            $totalHadir = max(0, $totalSiswaWali - $totalTidakHadir);

            $dataWaliKelas = [
                'kelas'           => $kelasWali,
                'totalSiswa'      => $totalSiswaWali,
                'totalHadir'      => $totalHadir,
                'rekapAbsensi'    => $rekapKetidakhadiran,
                'jurnalTerisi'    => $jurnalWali->count(),
                'totalJadwalHari' => $semuaJadwalPerwalian->filter(fn($j) => strtolower(trim($j->hari)) === strtolower(trim($hariFilter !== 'semua' ? $hariFilter : $todayIndo)))->count(),
                'hariNama'        => $dayDates[$hariFilter]['day_name'] ?? ucfirst($hariFilter),
                'tanggalFmt'      => $dayDates[$hariFilter]['formatted'] ?? '',
            ];
        }

        return view('guru.jadwal', compact(
            'jadwals',
            'semuaJadwalGuru',
            'semuaJadwalPerwalian',
            'jadwalsMatrixByDay',
            'masterJamList',
            'hariFilter',
            'todayIndo',
            'activeTab',
            'viewMode',
            'searchQuery',
            'statusFilter',
            'statsProgres',
            'statsBeban',
            'isWaliKelas',
            'kelasWali',
            'dataWaliKelas',
            'dayDates'
        ));
    }

    /**
     * Detail Rincian Jurnal Mengajar (JSON API untuk Modal Quick View Jadwal/Riwayat)
     */
    public function detailJurnalJson($id)
    {
        $jurnal = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.ruangan',
            'jadwal.jamMulai',
            'jadwal.jamSelesai',
            'guruPengganti',
            'detailKetidakhadiran.siswa'
        ])->find($id);

        if (!$jurnal) {
            return response()->json([
                'success' => false,
                'message' => 'Data jurnal tidak ditemukan.'
            ], 404);
        }

        $tglCarbon = Carbon::parse($jurnal->tanggal);
        $daysIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $hariTeks = $daysIndo[$tglCarbon->format('l')] ?? '-';

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
        $dispenCount = $absenList->filter(fn($a) => str_contains(strtolower($a['keterangan']), 'dispen'))->count();
        $totalAbsen = $absenList->count();
        $hadirCount = max(0, $totalSiswaKelas - $totalAbsen);

        return response()->json([
            'success' => true,
            'data'    => [
                'id_jurnal'         => $jurnal->id_jurnal,
                'tanggal'           => $jurnal->tanggal,
                'hari'              => $hariTeks,
                'tanggal_formatted' => $tglCarbon->translatedFormat('d F Y'),
                'mapel'             => $jurnal->jadwal->mapel->nama_mapel ?? ($jurnal->mapel_nama ?? '-'),
                'kode_mapel'        => $jurnal->jadwal->mapel->kode_mapel ?? '-',
                'kelas'             => $jurnal->jadwal->kelas->nama_kelas ?? ($jurnal->kelas_nama ?? '-'),
                'ruangan'           => $jurnal->jadwal->ruangan->nama_ruangan ?? '-',
                'jam_ke'            => $jurnal->jadwal->jam_range ?? ($jurnal->jam_ke ?? '-'),
                'waktu_kbm'         => ($jurnal->jadwal->waktu_mulai_effective ?? '07:00') . ' - ' . ($jurnal->jadwal->waktu_selesai_effective ?? '08:20') . ' WIB',
                'jumlah_jp'         => ($jurnal->jadwal->jumlah_jp ?? 2) . ' JP',
                'guru'              => $jurnal->jadwal->guru->nama_guru ?? '-',
                'nip_guru'          => $jurnal->jadwal->guru->nip ?? '-',
                'is_guru_pengganti' => $jurnal->id_guru_pengganti ? true : false,
                'guru_pengganti'    => $jurnal->guruPengganti->nama_guru ?? null,
                'materi'            => $jurnal->materi ?? '-',
                'pertemuan_ke'      => $jurnal->pertemuan_ke ?? '1',
                'catatan'           => $jurnal->catatan ?? 'Tidak ada catatan khusus.',
                'kondisi_kelas'     => $jurnal->kondisi_kelas ?? 'Kondusif',
                'status_kehadiran_guru' => $jurnal->status_kehadiran_guru ?? 'Hadir',
                'statistik_kehadiran' => [
                    'total_siswa' => $totalSiswaKelas,
                    'hadir'       => $hadirCount,
                    'sakit'       => $sakitCount,
                    'izin'        => $izinCount,
                    'alpa'        => $alpaCount,
                    'dispen'      => $dispenCount,
                    'total_absen' => $totalAbsen,
                ],
                'daftar_absen'      => $absenList->values(),
            ]
        ]);
    }

    /**
     * Ekspor Jadwal Mengajar Guru / Jadwal Kelas Perwalian ke CSV
     */
    public function exportJadwalCsv(Request $request)
    {
        $user = Auth::user();
        $guru = $user ? ($user->guru ?? ($user->nip ? Guru::where('nip', $user->nip)->first() : null)) : null;
        $idGuru = $guru ? $guru->id_guru : ($user->id_guru ?? null);
        $tab = $request->input('tab', 'saya');

        $query = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamMulai', 'jamSelesai'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('id_jam_mulai', 'asc');

        if ($tab === 'perwalian' && $user && $user->isWaliKelas()) {
            $nips = array_filter([$user->nip, optional($guru)->nip]);
            $kelasWali = Kelas::whereIn('wali_kelas', $nips)->first();
            if ($kelasWali) {
                $query->where('id_kelas', $kelasWali->id_kelas);
                $title = "Jadwal_KBM_Kelas_{$kelasWali->nama_kelas}_" . date('Ymd_His') . ".csv";
            } else {
                $title = "Jadwal_KBM_Kelas_" . date('Ymd_His') . ".csv";
            }
        } else {
            if ($idGuru) {
                $query->where('id_guru', $idGuru);
            }
            $guruNameSlug = $guru ? Str::slug($guru->nama_guru) : 'guru';
            $title = "Jadwal_Mengajar_{$guruNameSlug}_" . date('Ymd_His') . ".csv";
        }

        $jadwals = $query->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$title}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($jadwals) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM

            fputcsv($file, ['No', 'Hari', 'Jam Ke', 'Waktu KBM (WIB)', 'Alokasi (JP)', 'Kelas', 'Mata Pelajaran', 'Guru Pengampu', 'Ruangan']);

            foreach ($jadwals as $idx => $j) {
                fputcsv($file, [
                    $idx + 1,
                    $j->hari,
                    $j->jam_range,
                    $j->waktu_range,
                    $j->jumlah_jp . ' JP',
                    $j->kelas->nama_kelas ?? '-',
                    $j->mapel->nama_mapel ?? '-',
                    $j->guru->nama_guru ?? '-',
                    $j->ruangan->nama_ruangan ?? '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak Lembar Resmi Jadwal Mengajar Guru / Jadwal Kelas Perwalian
     */
    public function printJadwal(Request $request)
    {
        $user = Auth::user();
        $guru = $user ? ($user->guru ?? ($user->nip ? Guru::where('nip', $user->nip)->first() : null)) : null;
        $idGuru = $guru ? $guru->id_guru : ($user->id_guru ?? null);
        $tab = $request->input('tab', 'saya');

        $kelasWali = null;
        if ($user) {
            $nips = array_filter([$user->nip, optional($guru)->nip]);
            if (!empty($nips)) {
                $kelasWali = Kelas::whereIn('wali_kelas', $nips)->first();
            }
        }
        $isWaliKelas = ($kelasWali !== null) || ($user && $user->isWaliKelas());

        if ($tab === 'perwalian' && $kelasWali) {
            $jadwals = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamMulai', 'jamSelesai'])
                ->where('id_kelas', $kelasWali->id_kelas)
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
                ->orderBy('id_jam_mulai', 'asc')
                ->get();
            $titleDoc = "JADWAL KELAS " . strtoupper($kelasWali->nama_kelas);
        } else {
            $jadwals = Jadwal::with(['kelas', 'mapel', 'ruangan', 'guru', 'jamMulai', 'jamSelesai'])
                ->where('id_guru', $idGuru)
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
                ->orderBy('id_jam_mulai', 'asc')
                ->get();
            $titleDoc = "JADWAL MENGAJAR GURU: " . strtoupper($guru->nama_guru ?? $user->name);
        }

        $masterJamList = JamPelajaran::orderBy('id_jam', 'asc')->get();

        $jadwalsByDay = [
            'Senin'  => $jadwals->filter(fn($j) => strtolower(trim($j->hari)) === 'senin')->values(),
            'Selasa' => $jadwals->filter(fn($j) => strtolower(trim($j->hari)) === 'selasa')->values(),
            'Rabu'   => $jadwals->filter(fn($j) => strtolower(trim($j->hari)) === 'rabu')->values(),
            'Kamis'  => $jadwals->filter(fn($j) => strtolower(trim($j->hari)) === 'kamis')->values(),
            'Jumat'  => $jadwals->filter(fn($j) => strtolower(trim($j->hari)) === 'jumat')->values(),
        ];

        $totalJp = $jadwals->sum('jumlah_jp');

        return view('guru.jadwal_cetak', compact(
            'guru',
            'user',
            'tab',
            'kelasWali',
            'jadwals',
            'jadwalsByDay',
            'masterJamList',
            'totalJp',
            'titleDoc'
        ));
    }

    /**
     * Jurnal Harian Guru - Form & Status Live
     */
    public function jurnalHarian(Request $request)
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

        $todayCarbon = Carbon::now('Asia/Jakarta');
        $todayEnglish = $todayCarbon->format('l');
        $hariIni = $daysInIndonesian[$todayEnglish] ?? 'Kamis';
        $todayDate = $todayCarbon->toDateString();
        $user = Auth::user();

        // 1. Jadwal Mengajar Hari Ini
        $query = Jadwal::with(['kelas', 'mapel', 'ruangan', 'jamPelajaran', 'jamMulai', 'jamSelesai'])
            ->where('hari', $hariIni);

        if ($user && $user->id_guru) {
            $query->where('id_guru', $user->id_guru);
        }

        $jadwalsHariIni = $query->orderBy('id_jam_mulai', 'asc')->get();

        // Penugasan Guru Pengganti Hari Ini
        if ($user && $user->id_guru) {
            $penugasans = \App\Models\PenugasanGuruPengganti::with([
                'jadwal.kelas', 'jadwal.mapel', 'jadwal.ruangan', 'jadwal.guru', 'jadwal.jamMulai', 'jadwal.jamSelesai',
                'guruTidakHadir.mapel', 'kelas'
            ])
                ->where('id_guru_pengganti', $user->id_guru)
                ->whereDate('tanggal', $todayDate)
                ->whereIn('status', ['aktif', 'selesai'])
                ->get();

            foreach ($penugasans as $p) {
                $jObj = $p->jadwal;
                if (!$jObj && $p->id_kelas && $p->id_guru_tidak_hadir) {
                    $jObj = Jadwal::with(['kelas', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai', 'guru'])
                        ->where('id_guru', $p->id_guru_tidak_hadir)
                        ->where('id_kelas', $p->id_kelas)
                        ->first();
                }
                if ($jObj) {
                    $jObjCopy = clone $jObj;
                    $jObjCopy->is_guru_pengganti = true;
                    $jObjCopy->penugasan_pengganti = $p;
                    $jObjCopy->guru_utama = $p->guruTidakHadir ?? $jObj->guru;
                    if (!$jadwalsHariIni->contains('id_jadwal', $jObjCopy->id_jadwal)) {
                        $jadwalsHariIni->push($jObjCopy);
                    }
                }
            }
            $jadwalsHariIni = $jadwalsHariIni->sortBy('id_jam_mulai')->values();
        }

        if ($jadwalsHariIni->isEmpty() && (!$user || !$user->id_guru)) {
            $jadwalsHariIni = Jadwal::with(['kelas', 'mapel', 'ruangan', 'jamPelajaran', 'jamMulai', 'jamSelesai'])
                ->limit(5)->get();
        }

        // 2. Selected Schedule for Form Entry
        $selectedJadwalId = $request->input('id_jadwal');
        if ($selectedJadwalId) {
            $selectedJadwal = $jadwalsHariIni->firstWhere('id_jadwal', $selectedJadwalId);
            if (!$selectedJadwal) {
                $selectedJadwal = Jadwal::with(['kelas', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai'])->find($selectedJadwalId);
            }
            if ($selectedJadwal && empty($selectedJadwal->is_guru_pengganti) && strtolower(trim($selectedJadwal->hari)) !== strtolower(trim($hariIni))) {
                return redirect()->route('guru.jurnal-harian')
                    ->with('error', "Jadwal " . ($selectedJadwal->mapel->nama_mapel ?? 'Mata Pelajaran') . " (" . ($selectedJadwal->kelas->nama_kelas ?? 'Kelas') . ") adalah jadwal untuk hari {$selectedJadwal->hari}. Pengisian Jurnal Harian hanya dapat dilakukan pada jadwal hari ini ({$hariIni}) saat jam pelajaran berlangsung.");
            }
        } else {
            $selectedJadwal = $jadwalsHariIni->first(fn($j) => $j->is_sedang_berlangsung && !$j->isDiisiHariIni()) 
                ?? $jadwalsHariIni->first(fn($j) => $j->is_sedang_berlangsung)
                ?? $jadwalsHariIni->first(fn($j) => !$j->sudah_masuk_jam)
                ?? $jadwalsHariIni->first(fn($j) => !$j->isDiisiHariIni())
                ?? $jadwalsHariIni->first();
        }

        // 3. Existing Journal for selected schedule today (if already saved or draft)
        $existingJurnal = null;
        $existingAbsensi = [];
        $autoPertemuanKe = 'Ke-1';

        if ($selectedJadwal) {
            $existingJurnal = JurnalMengajar::with('detailKetidakhadiran')
                ->where('id_jadwal', $selectedJadwal->id_jadwal)
                ->whereDate('tanggal', $todayDate)
                ->first();

            if ($existingJurnal) {
                foreach ($existingJurnal->detailKetidakhadiran as $det) {
                    $existingAbsensi[$det->id_siswa] = $det->keterangan ?? $det->status;
                }
            } else {
                $prevCount = JurnalMengajar::where('id_jadwal', $selectedJadwal->id_jadwal)->count();
                $autoPertemuanKe = 'Ke-' . ($prevCount + 1);
            }
        }

        // 4. Students in selected class + check approved Surat Izin today
        $siswas = [];
        $suratIzinMap = [];
        $dispenMap = [];
        $siswaTelatMap = [];

        if ($selectedJadwal && $selectedJadwal->id_kelas) {
            $siswas = Siswa::where('id_kelas', $selectedJadwal->id_kelas)
                ->orderBy('nama_siswa', 'asc')->get();

            $suratIzinList = SiswaSuratIzin::where(function($q) use ($todayDate) {
                    $q->whereDate('tanggal', '<=', $todayDate)
                      ->where(function($sq) use ($todayDate) {
                          $sq->whereDate('tanggal_selesai', '>=', $todayDate)
                             ->orWhereNull('tanggal_selesai');
                      });
                })
                ->whereIn('status', ['disetujui', 'Terverifikasi', 'Menunggu'])
                ->where(function($q) use ($selectedJadwal) {
                    $q->where('id_kelas', $selectedJadwal->id_kelas)
                      ->orWhereHas('siswa', fn($sq) => $sq->where('id_kelas', $selectedJadwal->id_kelas));
                })
                ->get();

            foreach ($suratIzinList as $sIzin) {
                $kat = strtolower(trim($sIzin->kategori ?? 'izin'));
                $jenis = str_contains($kat, 'sakit') ? 'Sakit' : (str_contains($kat, 'dispen') ? 'Dispen' : 'Izin');
                $suratIzinMap[$sIzin->id_siswa] = [
                    'jenis'      => $jenis,
                    'keterangan' => $sIzin->keterangan ?? $sIzin->alasan ?? 'Surat Izin Disetujui',
                ];
            }

            // Approved Surat Dispen hari ini untuk kelas ini (Disetujui Waka Kesiswaan)
            $dispenList = SiswaDispen::whereDate('tanggal', $todayDate)
                ->whereIn('status_waka', ['approved', 'Disetujui'])
                ->where(function($q) use ($selectedJadwal) {
                    $q->where('id_kelas', $selectedJadwal->id_kelas)
                      ->orWhereHas('siswa', fn($sq) => $sq->where('id_kelas', $selectedJadwal->id_kelas));
                })
                ->get();

            $dispenMap = [];
            foreach ($dispenList as $dp) {
                $jamRange = '';
                if ($dp->jam_keluar && $dp->jam_kembali) {
                    $jamRange = " (" . substr($dp->jam_keluar, 0, 5) . " - " . substr($dp->jam_kembali, 0, 5) . " WIB)";
                } elseif ($dp->jam_keluar) {
                    $jamRange = " (Pukul " . substr($dp->jam_keluar, 0, 5) . " WIB)";
                }
                $dispenMap[$dp->id_siswa] = [
                    'id_siswa_dispen' => $dp->id_siswa_dispen,
                    'alasan'          => $dp->alasan ?? $dp->tempat ?? 'Dispensasi Resmi Disetujui',
                    'jam'             => $jamRange,
                    'kode_dispen'     => $dp->kode_dispen ?? null,
                ];
            }

            // Siswa Telat pada tanggal hari ini untuk kelas / jadwal guru ini
            $siswaTelatList = SiswaTelat::whereDate('tanggal', $todayDate)
                ->where(function($q) use ($selectedJadwal) {
                    $q->where('id_kelas', $selectedJadwal->id_kelas)
                      ->orWhere('id_guru_mengajar', $selectedJadwal->id_guru);
                })
                ->with(['guruPiket', 'guruMengajar'])
                ->get();

            $siswaTelatMap = [];
            foreach ($siswaTelatList as $st) {
                $siswaTelatMap[$st->id_siswa] = [
                    'id_siswa_telat'   => $st->id_siswa_telat,
                    'jam_terlambat'    => $st->jam_terlambat,
                    'alasan'           => $st->alasan,
                    'tindakan_hukuman' => $st->tindakan_hukuman,
                    'guru_piket'       => $st->guruPiket->name ?? 'Guru Piket',
                ];
            }
        }

        // 5. Riwayat Jurnal Hari Ini (Dynamic for today's schedules)
        $riwayatHariIni = [];
        foreach ($jadwalsHariIni as $jToday) {
            $jurnalEntry = JurnalMengajar::where('id_jadwal', $jToday->id_jadwal)
                ->whereDate('tanggal', $todayDate)
                ->first();

            $riwayatHariIni[] = (object) [
                'jadwal'     => $jToday,
                'is_terisi'  => $jurnalEntry ? true : false,
                'is_draft'   => $jurnalEntry ? ($jurnalEntry->is_draft ?? false) : false,
                'jurnal'     => $jurnalEntry,
            ];
        }

        // 6. Monthly Progress Stats (Dynamic calculation)
        $startOfMonth = $todayCarbon->copy()->startOfMonth()->toDateString();
        $endOfMonth   = $todayCarbon->copy()->endOfMonth()->toDateString();

        $monthJurnalCount = 0;
        if ($user && $user->id_guru) {
            $monthJurnalCount = JurnalMengajar::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                ->where(function($q) use ($user) {
                    $q->whereHas('jadwal', fn($sq) => $sq->where('id_guru', $user->id_guru))
                      ->orWhere('id_guru_pengganti', $user->id_guru);
                })
                ->count();
        } else {
            $monthJurnalCount = JurnalMengajar::whereBetween('tanggal', [$startOfMonth, $endOfMonth])->count();
        }

        $totalJadwalSeminggu = 0;
        if ($user && $user->id_guru) {
            $totalJadwalSeminggu = Jadwal::where('id_guru', $user->id_guru)->count();
        }
        $targetBulanan = max(10, $totalJadwalSeminggu * 4);

        $weeksPassed = max(1, (int) ceil($todayCarbon->day / 7));
        $rataMinggu = round($monthJurnalCount / $weeksPassed, 1);

        $progresBulanan = [
            'terisi'      => $monthJurnalCount,
            'target'      => $targetBulanan,
            'rata_minggu' => $rataMinggu,
        ];

        return view('guru.jurnal_harian', compact(
            'jadwalsHariIni',
            'selectedJadwal',
            'siswas',
            'existingJurnal',
            'existingAbsensi',
            'autoPertemuanKe',
            'suratIzinMap',
            'dispenMap',
            'siswaTelatMap',
            'riwayatHariIni',
            'progresBulanan',
            'hariIni',
            'todayCarbon'
        ));
    }

    /**
     * Simpan Jurnal Harian Mengajar (Store / Draft / Update)
     */
    public function simpanJurnalHarian(Request $request)
    {
        $request->validate([
            'id_jadwal'    => 'required|exists:jadwal,id_jadwal',
            'materi'       => 'required|string',
            'pertemuan_ke' => 'nullable|string',
            'catatan'      => 'nullable|string',
            'kondisi_kelas'=> 'nullable|string',
        ]);

        $user = Auth::user();
        $jadwal = Jadwal::find($request->id_jadwal);
        $todayDate = Carbon::now('Asia/Jakarta')->toDateString();

        // Check if user is substitute teacher for this schedule today
        $penugasanPengganti = null;
        if ($user && $user->id_guru) {
            $penugasanPengganti = \App\Models\PenugasanGuruPengganti::where('id_jadwal', $request->id_jadwal)
                ->where('id_guru_pengganti', $user->id_guru)
                ->whereDate('tanggal', $todayDate)
                ->first();
            if (!$penugasanPengganti && $jadwal) {
                $penugasanPengganti = \App\Models\PenugasanGuruPengganti::where('id_kelas', $jadwal->id_kelas)
                    ->where('id_guru_pengganti', $user->id_guru)
                    ->whereDate('tanggal', $todayDate)
                    ->first();
            }
        }
        $isGuruPengganti = ($penugasanPengganti !== null);

        // Check if journal entry already exists and is submitted (not draft)
        $existingEntry = JurnalMengajar::where('id_jadwal', $request->id_jadwal)
            ->whereDate('tanggal', $todayDate)
            ->first();

        $isSubmittedFinal = ($existingEntry && !$existingEntry->is_draft);

        $isAdminPiket = ($user && ($user->isAdmin() || $user->isGuruPiket() || $isGuruPengganti));

        // Validasi hari jadwal KBM
        $daysInIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $todayIndo = $daysInIndo[Carbon::now('Asia/Jakarta')->format('l')] ?? '';
        $isHariSesuai = ($jadwal && strtolower(trim($jadwal->hari ?? '')) === strtolower(trim($todayIndo)));

        if ($jadwal && !$isAdminPiket && !$isHariSesuai) {
            return redirect()->back()->with('error', "Peringatan: Jadwal " . ($jadwal->mapel->nama_mapel ?? 'Mapel') . " (" . ($jadwal->kelas->nama_kelas ?? 'Kelas') . ") adalah jadwal untuk hari {$jadwal->hari}. Pengisian Jurnal Harian hanya dapat dilakukan saat jam pelajaran berlangsung pada hari tersebut.");
        }

        // Strict time gate check: Guru cannot submit journal if class time hasn't started yet
        if ($jadwal && !$isAdminPiket && !$jadwal->sudah_masuk_jam) {
            return redirect()->back()->with('error', "Peringatan: Jurnal Mengajar untuk mata pelajaran " . ($jadwal->mapel->nama_mapel ?? 'ini') . " belum dapat diisi/disimpan karena belum memasuki jam pelajaran (Dimulai pukul {$jadwal->waktu_mulai_effective} WIB).");
        }

        // Strict time gate check: Guru cannot submit or update journal if class time has ended
        if ($jadwal && !$isAdminPiket && $jadwal->is_jam_sudah_selesai) {
            $msg = $isSubmittedFinal
                ? "Maaf, jam pelajaran untuk " . ($jadwal->mapel->nama_mapel ?? 'Mata Pelajaran') . " telah berakhir (Pukul {$jadwal->waktu_selesai_effective} WIB). Data Jurnal Mengajar yang telah dikirim sudah terkunci final dan tidak dapat diubah lagi."
                : "Maaf, jam pelajaran untuk " . ($jadwal->mapel->nama_mapel ?? 'Mata Pelajaran') . " telah berakhir (Pukul {$jadwal->waktu_selesai_effective} WIB). Pengisian jurnal telah ditutup karena jam pelajaran KBM telah selesai sesuai master jadwal dan alokasi jam pelajaran TU.";
            return redirect()->back()->with('error', $msg);
        }

        $isDraft = $request->input('action') === 'draft';
        $todayDate = Carbon::now('Asia/Jakarta')->toDateString();

        // Handle Foto Kehadiran Live Kamera / Dokumentasi
        $dokumentasiName = $existingEntry ? $existingEntry->dokumentasi : null;

        // Cek jika user meminta menghapus foto
        if ($request->input('hapus_dokumentasi') == '1') {
            if ($dokumentasiName && file_exists(public_path('uploads/dokumentasi/' . $dokumentasiName))) {
                @unlink(public_path('uploads/dokumentasi/' . $dokumentasiName));
            }
            $dokumentasiName = null;
        }

        // Cek jika ada jepretan foto live dari kamera (Base64 dataURL)
        if ($request->filled('foto_kehadiran_kamera')) {
            $base64Data = $request->input('foto_kehadiran_kamera');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $type)) {
                $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
                $ext = strtolower($type[1]);
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $ext = 'jpg';
                }
                $imageData = base64_decode($base64Data);

                if ($imageData !== false) {
                    $uploadDir = public_path('uploads/dokumentasi');
                    if (!file_exists($uploadDir)) {
                        @mkdir($uploadDir, 0755, true);
                    }

                    // Hapus file lama jika diganti foto baru
                    if ($dokumentasiName && file_exists($uploadDir . '/' . $dokumentasiName)) {
                        @unlink($uploadDir . '/' . $dokumentasiName);
                    }

                    $newFileName = 'jurnal_kbm_' . $request->id_jadwal . '_' . time() . '_' . uniqid() . '.' . $ext;
                    file_put_contents($uploadDir . '/' . $newFileName, $imageData);
                    $dokumentasiName = $newFileName;
                }
            }
        } elseif ($request->hasFile('dokumentasi')) {
            $file = $request->file('dokumentasi');
            $uploadDir = public_path('uploads/dokumentasi');
            if (!file_exists($uploadDir)) {
                @mkdir($uploadDir, 0755, true);
            }
            if ($dokumentasiName && file_exists($uploadDir . '/' . $dokumentasiName)) {
                @unlink($uploadDir . '/' . $dokumentasiName);
            }
            $newFileName = 'jurnal_kbm_' . $request->id_jadwal . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $newFileName);
            $dokumentasiName = $newFileName;
        }

        $jurnal = JurnalMengajar::updateOrCreate(
            [
                'id_jadwal' => $request->id_jadwal,
                'tanggal'   => $todayDate,
            ],
            [
                'id_guru_pengganti'     => $isGuruPengganti ? $user->id_guru : ($existingEntry->id_guru_pengganti ?? null),
                'materi'                => $request->materi,
                'pertemuan_ke'          => $request->pertemuan_ke ?? 'Ke-1',
                'status_kehadiran_guru' => 'Hadir',
                'catatan'               => $request->catatan,
                'kondisi_kelas'         => $request->kondisi_kelas ?? 'Kondusif',
                'dokumentasi'           => $dokumentasiName,
                'jam_ke'                => $jadwal ? $jadwal->jam_range : null,
                'is_draft'              => $isDraft,
                'dicatat_pada'          => now(),
            ]
        );

        if ($penugasanPengganti && !$isDraft) {
            $penugasanPengganti->update(['status' => 'selesai']);
        }
        if ($user && $user->id_guru && !$isDraft) {
            \App\Models\PenugasanGuruPengganti::where('id_guru_pengganti', $user->id_guru)
                ->whereDate('tanggal', $todayDate)
                ->where(function($q) use ($request, $jadwal) {
                    $q->where('id_jadwal', $request->id_jadwal);
                    if ($jadwal && $jadwal->id_kelas) {
                        $q->orWhere('id_kelas', $jadwal->id_kelas);
                    }
                })
                ->update(['status' => 'selesai']);
        }

        // Clear previous detail records for this journal entry to keep data clean
        JurnalDetailKetidakhadiran::where('id_jurnal', $jurnal->id_jurnal)->delete();

        // Simpan detail ketidakhadiran siswa jika ada
        if ($request->has('ketidakhadiran') && is_array($request->ketidakhadiran)) {
            foreach ($request->ketidakhadiran as $item) {
                if (!empty($item['id_siswa']) && !empty($item['keterangan']) && in_array($item['keterangan'], ['Sakit', 'Izin', 'Alpa', 'Dispen', 'Dispensasi'])) {
                    $ketNormalized = ($item['keterangan'] === 'Dispensasi') ? 'Dispen' : $item['keterangan'];
                    JurnalDetailKetidakhadiran::create([
                        'id_jurnal'  => $jurnal->id_jurnal,
                        'id_siswa'   => $item['id_siswa'],
                        'keterangan' => $ketNormalized,
                        'status'     => $ketNormalized,
                    ]);
                }
            }
        }

        $msg = $isDraft ? 'Draft Jurnal Harian berhasil disimpan!' : 'Jurnal Harian berhasil disimpan & dikirim!';
        return redirect()->route('guru.jurnal-harian', ['id_jadwal' => $request->id_jadwal])->with('success', $msg);
    }

    /**
     * Batal Kirim Jurnal Mengajar (Hanya dapat dilakukan saat jam pelajaran berlangsung)
     */
    public function batalKirimJurnal(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal,id_jadwal',
        ]);

        $user = Auth::user();
        $todayDate = Carbon::now('Asia/Jakarta')->toDateString();
        $jadwal = Jadwal::with(['mapel', 'kelas'])->find($request->id_jadwal);

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal pelajaran tidak ditemukan.');
        }

        // Time condition: Check if class time has ALREADY ENDED today
        if ($jadwal->is_jam_sudah_selesai && (!$user || (!$user->isAdmin() && !$user->isGuruPiket()))) {
            return redirect()->back()->with('error', "Maaf, pengiriman Jurnal Mengajar untuk " . ($jadwal->mapel->nama_mapel ?? 'Mata Pelajaran') . " tidak dapat dibatalkan karena jam pelajaran (Pukul {$jadwal->waktu_selesai_effective} WIB) telah berakhir.");
        }

        // Find all journal records for this schedule today and delete them cleanly
        $jurnals = JurnalMengajar::where('id_jadwal', $jadwal->id_jadwal)
            ->where('tanggal', $todayDate)
            ->get();

        foreach ($jurnals as $jurnal) {
            if ($jurnal->dokumentasi && file_exists(public_path('uploads/dokumentasi/' . $jurnal->dokumentasi))) {
                @unlink(public_path('uploads/dokumentasi/' . $jurnal->dokumentasi));
            }
            JurnalDetailKetidakhadiran::where('id_jurnal', $jurnal->id_jurnal)->delete();
            $jurnal->delete();
        }

        // Fallback direct delete by id_jadwal and tanggal to guarantee complete deletion
        JurnalMengajar::where('id_jadwal', $jadwal->id_jadwal)->where('tanggal', $todayDate)->delete();

        return redirect()->route('guru.jurnal-harian', ['id_jadwal' => $jadwal->id_jadwal])
            ->with('success', 'Pengiriman Jurnal Mengajar berhasil dibatalkan! Data jurnal yang barusan diisi dan dikirim telah terhapus, formulir dikosongkan kembali, dan status mengajar kelas ini kembali menjadi Belum Diisi.');
    }

    /**
     * Presensi Siswa Guru & Wali Kelas
     */
    public function absensiSiswa(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
        $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);

        // Check if teacher is Wali Kelas
        $isWaliKelas = ($user && $user->isWaliKelas()) || ($guru && Kelas::where('wali_kelas', $guru->nip)->exists());
        $kelasWali = null;
        if ($isWaliKelas) {
            $kelasWali = Kelas::where('wali_kelas', $guru->nip ?? ($user->nip ?? ''))->first()
                         ?? ($user->id_kelas ? Kelas::find($user->id_kelas) : null);
        }

        // Schedules taught by this teacher
        $jadwals = Jadwal::with(['kelas', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->where('id_guru', $guruId)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('id_jam_mulai')
            ->get();

        // Target Date resolution
        $targetDate = $request->input('tanggal', Carbon::now('Asia/Jakarta')->toDateString());
        try {
            $targetCarbon = Carbon::parse($targetDate, 'Asia/Jakarta');
        } catch (\Exception $e) {
            $targetCarbon = Carbon::now('Asia/Jakarta');
            $targetDate = $targetCarbon->toDateString();
        }

        $daysInIndo = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $hariTarget = $daysInIndo[$targetCarbon->format('l')] ?? 'Senin';

        // Resolve active schedule & class
        $idJadwal = $request->input('id_jadwal');
        $idKelas = $request->input('id_kelas');
        $isModeWali = false;
        $selectedJadwal = null;
        $kelasAktif = null;

        if ($idJadwal === 'wali') {
            $isModeWali = true;
            $kelasAktif = $kelasWali;
        } elseif ($idJadwal && is_numeric($idJadwal)) {
            $selectedJadwal = Jadwal::with(['kelas', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai'])->find($idJadwal);
            if ($selectedJadwal) {
                $kelasAktif = $selectedJadwal->kelas;
            } elseif ($kelasWali) {
                $isModeWali = true;
                $kelasAktif = $kelasWali;
            }
        } elseif ($idKelas) {
            $kelasAktif = Kelas::find($idKelas);
            if ($kelasWali && $kelasAktif && $kelasAktif->id_kelas === $kelasWali->id_kelas) {
                $isModeWali = true;
            } else {
                $selectedJadwal = $jadwals->firstWhere('id_kelas', $idKelas);
            }
        } else {
            // Default selection: schedule today, or first schedule, or wali class
            $matchingDayJadwals = $jadwals->where('hari', $hariTarget);
            if ($matchingDayJadwals->isNotEmpty()) {
                $selectedJadwal = $matchingDayJadwals->first();
                $kelasAktif = $selectedJadwal->kelas;
            } elseif ($jadwals->isNotEmpty()) {
                $selectedJadwal = $jadwals->first();
                $kelasAktif = $selectedJadwal->kelas;
            } elseif ($kelasWali) {
                $isModeWali = true;
                $kelasAktif = $kelasWali;
            } else {
                $kelasAktif = Kelas::first();
            }
        }

        if (!$kelasAktif) {
            $kelasAktif = Kelas::first();
        }
        $idKelasSelected = $kelasAktif ? $kelasAktif->id_kelas : null;

        // Subtitle info
        if ($selectedJadwal) {
            $jamMulai = $selectedJadwal->jamMulai ? substr($selectedJadwal->jamMulai->jam_mulai, 0, 5) : '';
            $jamSelesai = $selectedJadwal->jamSelesai ? substr($selectedJadwal->jamSelesai->jam_selesai, 0, 5) : '';
            $jamText = ($jamMulai && $jamSelesai) ? " • {$jamMulai}–{$jamSelesai}" : '';
            $ruangText = ($selectedJadwal->ruangan && $selectedJadwal->ruangan->nama_ruangan) ? " • " . $selectedJadwal->ruangan->nama_ruangan : '';
            $mapelNama = $selectedJadwal->mapel->nama_mapel ?? 'Mata Pelajaran';
            $kelasNama = $kelasAktif ? $kelasAktif->nama_kelas : 'Kelas';
            $subJudul = "{$mapelNama} – Kelas {$kelasNama}{$jamText}{$ruangText}";
        } elseif ($isModeWali && $kelasWali) {
            $subJudul = "Kelas Wali: {$kelasWali->nama_kelas} • Presensi Harian Perwalian";
        } else {
            $subJudul = "Kelas " . ($kelasAktif->nama_kelas ?? '-') . " • Presensi Siswa";
        }

        // Students in active class
        $siswas = $idKelasSelected
            ? Siswa::where('id_kelas', $idKelasSelected)->orderBy('nama_siswa', 'asc')->get()
            : collect();

        // Existing JurnalMengajar & Ketidakhadiran
        $existingJurnal = null;
        if ($selectedJadwal) {
            $existingJurnal = JurnalMengajar::where('id_jadwal', $selectedJadwal->id_jadwal)
                ->whereDate('tanggal', $targetDate)
                ->first();
        } elseif ($isModeWali && $idKelasSelected) {
            $existingJurnal = JurnalMengajar::whereHas('jadwal', fn($q) => $q->where('id_kelas', $idKelasSelected))
                ->whereDate('tanggal', $targetDate)
                ->first();
        }

        $existingPresensiMap = [];
        if ($existingJurnal) {
            $details = JurnalDetailKetidakhadiran::where('id_jurnal', $existingJurnal->id_jurnal)->get();
            foreach ($details as $d) {
                $statusNormalized = $d->keterangan;
                if ($statusNormalized === 'Dispensasi') $statusNormalized = 'Dispen';
                $existingPresensiMap[$d->id_siswa] = $statusNormalized;
            }
        }

        // Approved Surat Izin for target date (multi-day date range support & category mapping)
        $suratIzinList = SiswaSuratIzin::where(function($q) use ($targetDate) {
                $q->whereDate('tanggal', '<=', $targetDate)
                  ->where(function($sq) use ($targetDate) {
                      $sq->whereDate('tanggal_selesai', '>=', $targetDate)
                         ->orWhereNull('tanggal_selesai');
                  });
            })
            ->whereIn('status', ['disetujui', 'Terverifikasi', 'Menunggu'])
            ->where(function($q) use ($idKelasSelected) {
                $q->where('id_kelas', $idKelasSelected)
                  ->orWhereHas('siswa', fn($sq) => $sq->where('id_kelas', $idKelasSelected));
            })
            ->get();

        $suratIzinMap = [];
        foreach ($suratIzinList as $iz) {
            $kat = strtolower(trim($iz->kategori ?? 'izin'));
            $jenis = str_contains($kat, 'sakit') ? 'Sakit' : (str_contains($kat, 'dispen') ? 'Dispen' : 'Izin');
            
            $suratIzinMap[$iz->id_siswa] = [
                'id_surat_izin' => $iz->id_surat_izin,
                'jenis'         => $jenis,
                'kategori'      => $iz->kategori,
                'keterangan'    => $iz->keterangan ?? $iz->alasan ?? 'Surat Izin Disetujui',
                'rentang'       => $iz->rentang_tanggal_text,
                'status'        => $iz->status,
                'source'        => $iz->id_petugas_piket ? 'Guru Piket' : 'Orang Tua',
            ];
        }

        // Approved Surat Dispen for target date
        $dispenList = SiswaDispen::whereDate('tanggal', $targetDate)
            ->where('status_waka', 'approved')
            ->whereHas('siswa', fn($q) => $q->where('id_kelas', $idKelasSelected))
            ->get();
        $dispenMap = [];
        foreach ($dispenList as $dp) {
            $jamRange = '';
            if ($dp->jam_keluar && $dp->jam_kembali) {
                $jamRange = " (" . substr($dp->jam_keluar, 0, 5) . " - " . substr($dp->jam_kembali, 0, 5) . ")";
            }
            $dispenMap[$dp->id_siswa] = [
                'alasan' => $dp->keperluan ?? $dp->alasan ?? 'Dispensasi resmi disetujui',
                'jam'    => $jamRange,
            ];
        }

        // Siswa Telat pada target date
        $siswaTelatList = SiswaTelat::whereDate('tanggal', $targetDate)
            ->where(function($q) use ($idKelasSelected, $selectedJadwal) {
                if ($idKelasSelected) {
                    $q->where('id_kelas', $idKelasSelected);
                }
                if ($selectedJadwal && $selectedJadwal->id_guru) {
                    $q->orWhere('id_guru_mengajar', $selectedJadwal->id_guru);
                }
            })
            ->with(['guruPiket', 'guruMengajar'])
            ->get();

        $siswaTelatMap = [];
        foreach ($siswaTelatList as $st) {
            $siswaTelatMap[$st->id_siswa] = [
                'id_siswa_telat'   => $st->id_siswa_telat,
                'jam_terlambat'    => $st->jam_terlambat,
                'alasan'           => $st->alasan,
                'tindakan_hukuman' => $st->tindakan_hukuman,
                'guru_piket'       => $st->guruPiket->name ?? 'Guru Piket',
            ];
        }

        // Counts
        $sakitCount = 0;
        $izinCount = 0;
        $alpaCount = 0;
        $dispenCount = 0;

        foreach ($siswas as $s) {
            $st = '';
            if (isset($existingPresensiMap[$s->id_siswa])) {
                $st = $existingPresensiMap[$s->id_siswa];
            } elseif (isset($suratIzinMap[$s->id_siswa])) {
                $st = $suratIzinMap[$s->id_siswa]['jenis'];
            } elseif (isset($dispenMap[$s->id_siswa])) {
                $st = 'Dispen';
            }

            $s->status_presensi = $st; // 'Sakit', 'Izin', 'Alpa', 'Dispen', or '' (Hadir)
            $s->surat_izin_info = $suratIzinMap[$s->id_siswa] ?? null;
            $s->dispen_info = $dispenMap[$s->id_siswa] ?? null;
            $s->telat_info = $siswaTelatMap[$s->id_siswa] ?? null;

            if ($st === 'Sakit') $sakitCount++;
            elseif ($st === 'Izin') $izinCount++;
            elseif ($st === 'Alpa') $alpaCount++;
            elseif ($st === 'Dispen') $dispenCount++;
        }

        $totalSiswa = $siswas->count();
        $hadirCount = max(0, $totalSiswa - ($sakitCount + $izinCount + $alpaCount + $dispenCount));

        $ringkasanPresensi = [
            'total'  => $totalSiswa,
            'hadir'  => $hadirCount,
            'sakit'  => $sakitCount,
            'izin'   => $izinCount,
            'alpa'   => $alpaCount,
            'dispen' => $dispenCount,
        ];

        // Monthly absence stats
        $startOfMonth = $targetCarbon->copy()->startOfMonth()->toDateString();
        $endOfMonth   = $targetCarbon->copy()->endOfMonth()->toDateString();

        $monthlyDetails = JurnalDetailKetidakhadiran::whereHas('jurnal', function($q) use ($startOfMonth, $endOfMonth) {
                $q->whereBetween('tanggal', [$startOfMonth, $endOfMonth]);
            })
            ->whereHas('siswa', function($q) use ($idKelasSelected) {
                $q->where('id_kelas', $idKelasSelected);
            })
            ->with('siswa')
            ->get();

        $grouped = [];
        foreach ($monthlyDetails as $md) {
            $idS = $md->id_siswa;
            if (!isset($grouped[$idS])) {
                $grouped[$idS] = [
                    'nama_siswa' => $md->siswa ? $md->siswa->nama_siswa : 'Siswa',
                    'sakit'      => 0,
                    'izin'       => 0,
                    'alpa'       => 0,
                    'total'      => 0,
                ];
            }
            $ket = strtolower($md->keterangan);
            if (str_contains($ket, 'sakit')) $grouped[$idS]['sakit']++;
            elseif (str_contains($ket, 'izin') || str_contains($ket, 'dispen')) $grouped[$idS]['izin']++;
            elseif (str_contains($ket, 'alpa') || str_contains($ket, 'tanpa')) $grouped[$idS]['alpa']++;
            $grouped[$idS]['total']++;
        }

        $studentStats = [];
        foreach ($grouped as $idS => $g) {
            $parts = [];
            if ($g['alpa'] > 0) $parts[] = "{$g['alpa']}× alpa";
            if ($g['sakit'] > 0) $parts[] = "{$g['sakit']}× sakit";
            if ($g['izin'] > 0) $parts[] = "{$g['izin']}× izin";
            $ketStr = implode(' & ', $parts) . ' bulan ini';

            $studentStats[] = (object)[
                'nama_siswa' => $g['nama_siswa'],
                'keterangan' => $ketStr,
                'total'      => $g['total'],
            ];
        }

        usort($studentStats, fn($a, $b) => $b->total <=> $a->total);

        $absensiTinggi = array_values(array_filter($studentStats, fn($s) => $s->total >= 3));
        $absensiRendah = array_values(array_filter($studentStats, fn($s) => $s->total > 0 && $s->total < 3));

        return view('guru.absensi_siswa', compact(
            'jadwals',
            'selectedJadwal',
            'kelasAktif',
            'isModeWali',
            'kelasWali',
            'isWaliKelas',
            'subJudul',
            'siswas',
            'targetDate',
            'hariTarget',
            'idKelasSelected',
            'ringkasanPresensi',
            'absensiRendah',
            'absensiTinggi',
            'existingJurnal'
        ));
    }

    /**
     * Simpan Presensi Siswa Guru Mengajar & Wali Kelas
     */
    public function simpanPresensiSiswa(Request $request)
    {
        $user = Auth::user();
        $targetDate = $request->input('tanggal', Carbon::now('Asia/Jakarta')->toDateString());
        $idJadwal = $request->input('id_jadwal');
        $idKelas = $request->input('id_kelas');
        $absensi = $request->input('absensi', []);

        // Resolve schedule ID
        $jadwalObj = null;
        if ($idJadwal && $idJadwal !== 'wali' && is_numeric($idJadwal)) {
            $jadwalObj = Jadwal::with('kelas')->find($idJadwal);
        }

        if (!$jadwalObj && $idKelas) {
            $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
            if ($guru) {
                $jadwalObj = Jadwal::with('kelas')->where('id_guru', $guru->id_guru)->where('id_kelas', $idKelas)->first();
            }
            if (!$jadwalObj) {
                $jadwalObj = Jadwal::with('kelas')->where('id_kelas', $idKelas)->first();
            }
        }

        if (!$jadwalObj) {
            $jadwalObj = Jadwal::with('kelas')->first();
        }

        $resolvedJadwalId = $jadwalObj ? $jadwalObj->id_jadwal : 1;

        // Get or create Jurnal Mengajar
        $jurnal = JurnalMengajar::firstOrCreate(
            [
                'id_jadwal' => $resolvedJadwalId,
                'tanggal'   => $targetDate,
            ],
            [
                'materi'                => 'Presensi Kehadiran Siswa',
                'status_kehadiran_guru' => 'Hadir',
                'catatan'               => 'Presensi kehadiran siswa dicatat melalui Portal Presensi Guru.',
                'dicatat_pada'          => Carbon::now('Asia/Jakarta'),
                'kondisi_kelas'         => 'Kondusif',
            ]
        );

        // Delete old detail records for this jurnal
        JurnalDetailKetidakhadiran::where('id_jurnal', $jurnal->id_jurnal)->delete();

        $savedCount = 0;
        if (is_array($absensi)) {
            foreach ($absensi as $idSiswa => $status) {
                if (in_array($status, ['Sakit', 'Izin', 'Alpa', 'Dispen', 'Dispensasi'])) {
                    if (Siswa::where('id_siswa', $idSiswa)->exists()) {
                        JurnalDetailKetidakhadiran::create([
                            'id_jurnal'  => $jurnal->id_jurnal,
                            'id_siswa'   => $idSiswa,
                            'keterangan' => ($status === 'Dispen') ? 'Dispen' : $status,
                        ]);
                        $savedCount++;
                    }
                }
            }
        }

        $kelasNama = $jadwalObj && $jadwalObj->kelas ? $jadwalObj->kelas->nama_kelas : 'Kelas';

        return redirect()->route('guru.absensi-siswa', [
            'id_jadwal' => $idJadwal,
            'id_kelas'  => $idKelas,
            'tanggal'   => $targetDate,
        ])->with('success', "Presensi siswa {$kelasNama} tanggal {$targetDate} berhasil disimpan! Terdata {$savedCount} siswa tidak hadir / berhalangan.");
    }

    /**
     * Nilai Siswa Guru & Wali Kelas (dengan Filter Kelas, Mapel, Semester, Tahun Ajaran, Search, Real-time Stats, dan Kalkulasi Otomatis)
     */
    public function nilaiRapor(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
        $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);

        $isWaliKelas = ($user && $user->isWaliKelas()) || ($guru && Kelas::where('wali_kelas', $guru->nip)->exists());
        $kelasWali = null;
        if ($isWaliKelas) {
            $kelasWali = Kelas::where('wali_kelas', $guru->nip ?? ($user->nip ?? ''))->first()
                         ?? ($user->id_kelas ? Kelas::find($user->id_kelas) : null);
        }

        $idKelas = $request->input('id_kelas');
        $idMapel = $request->input('id_mapel');
        $semester = $request->input('semester', '1');
        $tahunAjaran = $request->input('tahun_ajaran', '2026/2027');
        $kkm = intval($request->input('kkm', 75));
        $search = trim($request->input('q', ''));
        $filterStatus = $request->input('status', 'semua');

        // Fetch classes & mapel taught by teacher
        $jadwals = Jadwal::with(['kelas', 'mapel']);
        if ($guruId) {
            $jadwals->where('id_guru', $guruId);
        }
        $jadwalList = $jadwals->get();

        $teacherClasses = $jadwalList->pluck('kelas')->filter()->unique('id_kelas');
        if ($isWaliKelas && $kelasWali) {
            $teacherClasses = $teacherClasses->push($kelasWali)->unique('id_kelas');
        }

        if ($teacherClasses->isEmpty()) {
            $kelases = Kelas::orderBy('nama_kelas', 'asc')->get();
        } else {
            $kelases = $teacherClasses->sortBy('nama_kelas')->values();
        }

        $teacherMapels = $jadwalList->pluck('mapel')->filter()->unique('id_mapel');
        if ($teacherMapels->isEmpty()) {
            $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        } else {
            $mapels = $teacherMapels->sortBy('nama_mapel')->values();
        }

        $selectedKelasId = $idKelas ? intval($idKelas) : ($kelases->first()->id_kelas ?? null);
        $selectedMapelId = $idMapel ? intval($idMapel) : ($mapels->first()->id_mapel ?? null);

        $selectedKelas = Kelas::find($selectedKelasId) ?? $kelases->first();
        $selectedMapel = Mapel::find($selectedMapelId) ?? $mapels->first();

        // Get all active students in selected class
        $allSiswasQuery = Siswa::where('id_kelas', $selectedKelasId)
            ->where(function ($q) {
                $q->whereNull('is_alumni')->orWhere('is_alumni', 0);
            });

        $allSiswasInClass = $allSiswasQuery->orderBy('nama_siswa', 'asc')->get();

        // Get stored grades
        $existingNilai = NilaiSiswa::where('id_kelas', $selectedKelasId)
            ->where('id_mapel', $selectedMapelId)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_siswa');

        // Calculate comprehensive statistics on all students
        $totalSiswa = $allSiswasInClass->count();
        $totalNilaiAkhir = 0;
        $countSiswaDinilai = 0;
        $diAtasKkm = 0;
        $diBawahKkm = 0;
        $nilaiTertinggi = 0;
        $nilaiTerendah = 100;
        $distribusiPredikat = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0];

        foreach ($allSiswasInClass as $s) {
            $val = $existingNilai->get($s->id_siswa);
            if ($val && ($val->nilai_akhir > 0 || $val->nilai_tugas > 0 || $val->nilai_harian > 0 || $val->nilai_uts > 0 || $val->nilai_uas > 0)) {
                $countSiswaDinilai++;
                $na = floatval($val->nilai_akhir);
                $totalNilaiAkhir += $na;
                if ($na >= $kkm) {
                    $diAtasKkm++;
                } else {
                    $diBawahKkm++;
                }
                if ($na > $nilaiTertinggi) $nilaiTertinggi = $na;
                if ($na < $nilaiTerendah) $nilaiTerendah = $na;
                $p = strtoupper($val->predikat ?? 'C');
                if (isset($distribusiPredikat[$p])) {
                    $distribusiPredikat[$p]++;
                }
            }
        }

        if ($countSiswaDinilai == 0) {
            $nilaiTerendah = 0;
        }

        $rataRataKelas = $countSiswaDinilai > 0 ? round($totalNilaiAkhir / $countSiswaDinilai, 1) : 0;
        $persenKetuntasan = $totalSiswa > 0 ? round(($diAtasKkm / $totalSiswa) * 100, 1) : 0;
        $belumDinilaiCount = $totalSiswa - $countSiswaDinilai;

        $ringkasanRapor = [
            'total_siswa'         => $totalSiswa,
            'sudah_dinilai'       => $countSiswaDinilai,
            'belum_dinilai'       => $belumDinilaiCount,
            'rata_rata'           => $rataRataKelas,
            'di_atas_kkm'         => $diAtasKkm,
            'di_bawah_kkm'        => $diBawahKkm,
            'persen_tuntas'       => $persenKetuntasan,
            'nilai_tertinggi'     => $nilaiTertinggi,
            'nilai_terendah'      => $nilaiTerendah,
            'distribusi_predikat' => $distribusiPredikat,
        ];

        // Apply search keyword and status filter on displayed list
        $siswas = $allSiswasInClass;
        if (!empty($search)) {
            $siswas = $siswas->filter(function ($s) use ($search) {
                return (stripos($s->nama_siswa, $search) !== false) ||
                       (stripos((string)($s->nis ?? ''), $search) !== false) ||
                       (stripos((string)($s->nisn ?? ''), $search) !== false);
            })->values();
        }

        if ($filterStatus === 'tuntas') {
            $siswas = $siswas->filter(function ($s) use ($existingNilai, $kkm) {
                $val = $existingNilai->get($s->id_siswa);
                return $val && floatval($val->nilai_akhir) >= $kkm && floatval($val->nilai_akhir) > 0;
            })->values();
        } elseif ($filterStatus === 'belum_tuntas') {
            $siswas = $siswas->filter(function ($s) use ($existingNilai, $kkm) {
                $val = $existingNilai->get($s->id_siswa);
                return !$val || floatval($val->nilai_akhir) < $kkm;
            })->values();
        }

        return view('guru.nilai_rapor', compact(
            'guru',
            'isWaliKelas',
            'kelasWali',
            'kelases',
            'mapels',
            'selectedKelasId',
            'selectedMapelId',
            'selectedKelas',
            'selectedMapel',
            'semester',
            'tahunAjaran',
            'kkm',
            'search',
            'filterStatus',
            'siswas',
            'allSiswasInClass',
            'existingNilai',
            'ringkasanRapor'
        ));
    }

    /**
     * Simpan Data Nilai Siswa
     */
    public function simpanNilai(Request $request)
    {
        $request->validate([
            'id_kelas'     => 'required|integer',
            'id_mapel'     => 'required|integer',
            'semester'     => 'required|string',
            'tahun_ajaran' => 'nullable|string',
            'kkm'          => 'nullable|numeric',
            'nilai'        => 'required|array',
        ]);

        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
        $idGuru = $guru ? $guru->id_guru : ($user->id_guru ?? 1);
        $tahunAjaran = $request->input('tahun_ajaran', '2026/2027');

        $savedCount = 0;
        foreach ($request->nilai as $idSiswa => $n) {
            $nTugas  = min(100, max(0, floatval($n['tugas'] ?? 0)));
            $nHarian = min(100, max(0, floatval($n['harian'] ?? 0)));
            $nUts    = min(100, max(0, floatval($n['uts'] ?? 0)));
            $nUas    = min(100, max(0, floatval($n['uas'] ?? 0)));

            // Formula: 20% Tugas + 20% UH/Formatif + 30% UTS + 30% UAS
            $nAkhir  = round(($nTugas * 0.2) + ($nHarian * 0.2) + ($nUts * 0.3) + ($nUas * 0.3), 2);

            $predikat = 'D';
            if ($nAkhir >= 88) $predikat = 'A';
            elseif ($nAkhir >= 78) $predikat = 'B';
            elseif ($nAkhir >= 68) $predikat = 'C';

            NilaiSiswa::updateOrCreate(
                [
                    'id_siswa'     => $idSiswa,
                    'id_kelas'     => $request->id_kelas,
                    'id_mapel'     => $request->id_mapel,
                    'semester'     => $request->semester,
                    'tahun_ajaran' => $tahunAjaran,
                ],
                [
                    'id_guru'      => $idGuru,
                    'nilai_tugas'  => $nTugas,
                    'nilai_harian' => $nHarian,
                    'nilai_uts'    => $nUts,
                    'nilai_uas'    => $nUas,
                    'nilai_akhir'  => $nAkhir,
                    'predikat'     => $predikat,
                    'catatan'      => $n['catatan'] ?? null,
                ]
            );
            $savedCount++;
        }

        return redirect()->route('guru.nilai-rapor', [
            'id_kelas'     => $request->id_kelas,
            'id_mapel'     => $request->id_mapel,
            'semester'     => $request->semester,
            'tahun_ajaran' => $tahunAjaran,
            'kkm'          => $request->input('kkm', 75),
        ])->with('success', "Data nilai {$savedCount} siswa berhasil disimpan dengan sukses!");
    }

    /**
     * Export Rekap Nilai Siswa ke CSV
     */
    public function exportNilaiCsv(Request $request)
    {
        $idKelas = $request->input('id_kelas');
        $idMapel = $request->input('id_mapel');
        $semester = $request->input('semester', '1');
        $tahunAjaran = $request->input('tahun_ajaran', '2026/2027');
        $kkm = intval($request->input('kkm', 75));

        $kelas = Kelas::find($idKelas) ?? Kelas::first();
        $mapel = Mapel::find($idMapel) ?? Mapel::first();

        $siswas = Siswa::where('id_kelas', $kelas->id_kelas ?? 0)
            ->where(function ($q) {
                $q->whereNull('is_alumni')->orWhere('is_alumni', 0);
            })
            ->orderBy('nama_siswa', 'asc')
            ->get();

        $existingNilai = NilaiSiswa::where('id_kelas', $kelas->id_kelas ?? 0)
            ->where('id_mapel', $mapel->id_mapel ?? 0)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_siswa');

        $cleanKelasName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $kelas->nama_kelas ?? 'Kelas');
        $cleanMapelName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $mapel->nama_mapel ?? 'Mapel');
        $fileName = "Rekap_Nilai_{$cleanKelasName}_{$cleanMapelName}_Sem{$semester}.csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($siswas, $existingNilai, $kkm) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            fputcsv($file, ['No', 'NIS', 'NISN', 'Nama Siswa', 'Tugas (20%)', 'UH/Formatif (20%)', 'UTS (30%)', 'UAS (30%)', 'Nilai Akhir', 'Predikat', 'KKM', 'Status', 'Catatan Guru']);

            foreach ($siswas as $idx => $s) {
                $val = $existingNilai->get($s->id_siswa);
                $nTugas = $val ? floatval($val->nilai_tugas) : 0;
                $nHarian = $val ? floatval($val->nilai_harian) : 0;
                $nUts = $val ? floatval($val->nilai_uts) : 0;
                $nUas = $val ? floatval($val->nilai_uas) : 0;
                $nAkhir = $val ? floatval($val->nilai_akhir) : 0;
                $predikat = $val ? $val->predikat : '-';
                $status = ($nAkhir >= $kkm && $nAkhir > 0) ? 'TUNTAS' : ($nAkhir > 0 ? 'BELUM TUNTAS' : 'BELUM DINILAI');
                $catatan = $val ? ($val->catatan ?? '') : '';

                fputcsv($file, [
                    $idx + 1,
                    $s->nis ?? '-',
                    $s->nisn ?? '-',
                    $s->nama_siswa,
                    $nTugas,
                    $nHarian,
                    $nUts,
                    $nUas,
                    $nAkhir,
                    $predikat,
                    $kkm,
                    $status,
                    $catatan,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak Ledger Nilai Siswa
     */
    public function printNilai(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);

        $idKelas = $request->input('id_kelas');
        $idMapel = $request->input('id_mapel');
        $semester = $request->input('semester', '1');
        $tahunAjaran = $request->input('tahun_ajaran', '2026/2027');
        $kkm = intval($request->input('kkm', 75));

        $kelas = Kelas::find($idKelas) ?? Kelas::first();
        $mapel = Mapel::find($idMapel) ?? Mapel::first();

        $siswas = Siswa::where('id_kelas', $kelas->id_kelas ?? 0)
            ->where(function ($q) {
                $q->whereNull('is_alumni')->orWhere('is_alumni', 0);
            })
            ->orderBy('nama_siswa', 'asc')
            ->get();

        $existingNilai = NilaiSiswa::where('id_kelas', $kelas->id_kelas ?? 0)
            ->where('id_mapel', $mapel->id_mapel ?? 0)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahunAjaran)
            ->get()
            ->keyBy('id_siswa');

        $waliKelas = null;
        if ($kelas && $kelas->wali_kelas) {
            $waliKelas = Guru::where('nip', $kelas->wali_kelas)->first();
        }

        return view('guru.nilai_rapor_print', compact(
            'guru',
            'kelas',
            'mapel',
            'semester',
            'tahunAjaran',
            'kkm',
            'siswas',
            'existingNilai',
            'waliKelas'
        ));
    }

    /**
     * Riwayat Jurnal Guru & Wali Kelas (dengan Search, Filter, Multi-select, dan Trash)
     */
    public function riwayatJurnal(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
        $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);

        $isWaliKelas = ($user && $user->isWaliKelas()) || ($guru && Kelas::where('wali_kelas', $guru->nip)->exists());
        $kelasWali = null;
        if ($isWaliKelas) {
            $kelasWali = Kelas::where('wali_kelas', $guru->nip ?? ($user->nip ?? ''))->first()
                         ?? ($user->id_kelas ? Kelas::find($user->id_kelas) : null);
        }

        // Base query with eager loaded relations
        $query = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.mapel',
            'jadwal.guru',
            'jadwal.ruangan',
            'guruPengganti',
            'detailKetidakhadiran.siswa',
        ]);

        // Filter by scope (All vs Saya vs Wali)
        $scope = $request->input('scope', 'all');
        if ($isWaliKelas && $kelasWali) {
            if ($scope === 'saya') {
                $query->whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId));
            } elseif ($scope === 'wali') {
                $query->whereHas('jadwal', fn($q) => $q->where('id_kelas', $kelasWali->id_kelas));
            } else { // 'all'
                $query->where(function($q) use ($guruId, $kelasWali) {
                    $q->whereHas('jadwal', fn($q2) => $q2->where('id_guru', $guruId))
                      ->orWhereHas('jadwal', fn($q2) => $q2->where('id_kelas', $kelasWali->id_kelas));
                });
            }
        } elseif ($guruId) {
            $query->whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId));
        }

        // Filter: Kelas
        if ($request->filled('id_kelas')) {
            $query->whereHas('jadwal', fn($q) => $q->where('id_kelas', $request->id_kelas));
        }

        // Filter: Mapel
        if ($request->filled('id_mapel')) {
            $query->whereHas('jadwal', fn($q) => $q->where('id_mapel', $request->id_mapel));
        }

        // Filter: Status Kehadiran Guru
        if ($request->filled('status_kehadiran')) {
            $query->where('status_kehadiran_guru', $request->status_kehadiran);
        }

        // Filter: Rentang Tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        // Filter: Bulan
        if ($request->filled('bulan') && is_numeric($request->bulan)) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter: Pencarian Q
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function($q) use ($keyword) {
                $q->where('materi', 'LIKE', "%{$keyword}%")
                  ->orWhere('catatan', 'LIKE', "%{$keyword}%")
                  ->orWhere('pertemuan_ke', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('jadwal.mapel', fn($q2) => $q2->where('nama_mapel', 'LIKE', "%{$keyword}%"))
                  ->orWhereHas('jadwal.kelas', fn($q2) => $q2->where('nama_kelas', 'LIKE', "%{$keyword}%"))
                  ->orWhereHas('jadwal.guru', fn($q2) => $q2->where('nama_guru', 'LIKE', "%{$keyword}%"));
            });
        }

        $jurnals = $query->orderBy('tanggal', 'desc')->orderBy('id_jurnal', 'desc')->get();

        // Classes list for filter
        $kelasesQuery = Kelas::query();
        if ($isWaliKelas && $kelasWali) {
            $kelasesQuery->where(function($q) use ($guruId, $kelasWali) {
                $q->whereHas('jadwals', fn($q2) => $q2->where('id_guru', $guruId))
                  ->orWhere('id_kelas', $kelasWali->id_kelas);
            });
        } elseif ($guruId) {
            $kelasesQuery->whereHas('jadwals', fn($q) => $q->where('id_guru', $guruId));
        }
        $kelases = $kelasesQuery->orderBy('nama_kelas')->get();

        // Mapels list for filter
        $mapelsQuery = Mapel::query();
        if ($guruId) {
            $mapelsQuery->whereHas('jadwals', fn($q) => $q->where('id_guru', $guruId));
        }
        $mapels = $mapelsQuery->orderBy('nama_mapel')->get();

        // Trashed count query
        $trashedQuery = JurnalMengajar::onlyTrashed();
        if ($isWaliKelas && $kelasWali) {
            $trashedQuery->where(function($q) use ($guruId, $kelasWali) {
                $q->whereHas('jadwal', fn($q2) => $q2->where('id_guru', $guruId))
                  ->orWhereHas('jadwal', fn($q2) => $q2->where('id_kelas', $kelasWali->id_kelas));
            });
        } elseif ($guruId) {
            $trashedQuery->whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId));
        }
        $trashedCount = $trashedQuery->count();

        // Statistics
        $totalJurnalCount = $jurnals->count();
        $hadirGuruCount = $jurnals->where('status_kehadiran_guru', 'Hadir')->count();
        $currentMonth = Carbon::now('Asia/Jakarta')->month;
        $jurnalBulanIniCount = $jurnals->filter(fn($j) => Carbon::parse($j->tanggal)->month === $currentMonth)->count();

        return view('guru.riwayat_jurnal', compact(
            'jurnals',
            'kelases',
            'mapels',
            'trashedCount',
            'totalJurnalCount',
            'hadirGuruCount',
            'jurnalBulanIniCount',
            'isWaliKelas',
            'kelasWali'
        ));
    }

    /**
     * Soft delete riwayat jurnal (Pindahkan ke Sampah)
     */
    public function destroyRiwayatJurnal($id)
    {
        $jurnal = JurnalMengajar::findOrFail($id);
        $jurnal->delete();

        return redirect()->route('guru.riwayat-jurnal')
            ->with('success', 'Data jurnal mengajar berhasil dipindahkan ke Sampah.');
    }

    /**
     * Bulk Soft delete riwayat jurnal (Pindahkan data terpilih ke Sampah)
     */
    public function destroyBatchRiwayatJurnal(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        $ids = array_filter(array_map('intval', (array)$ids));

        if (!empty($ids)) {
            $count = JurnalMengajar::whereIn('id_jurnal', $ids)->delete();
            return redirect()->route('guru.riwayat-jurnal')
                ->with('success', "{$count} data jurnal mengajar berhasil dipindahkan ke Sampah.");
        }

        return redirect()->route('guru.riwayat-jurnal')
            ->with('error', 'Tidak ada data jurnal yang dipilih untuk dihapus.');
    }

    /**
     * Halaman Sampah Riwayat Jurnal
     */
    public function trashRiwayatJurnal(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
        $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);

        $isWaliKelas = ($user && $user->isWaliKelas()) || ($guru && Kelas::where('wali_kelas', $guru->nip)->exists());
        $kelasWali = null;
        if ($isWaliKelas) {
            $kelasWali = Kelas::where('wali_kelas', $guru->nip ?? ($user->nip ?? ''))->first()
                         ?? ($user->id_kelas ? Kelas::find($user->id_kelas) : null);
        }

        $query = JurnalMengajar::onlyTrashed()->with([
            'jadwal.kelas',
            'jadwal.mapel',
            'jadwal.guru',
            'jadwal.ruangan',
            'guruPengganti',
            'detailKetidakhadiran.siswa',
        ]);

        if ($isWaliKelas && $kelasWali) {
            $query->where(function($q) use ($guruId, $kelasWali) {
                $q->whereHas('jadwal', fn($q2) => $q2->where('id_guru', $guruId))
                  ->orWhereHas('jadwal', fn($q2) => $q2->where('id_kelas', $kelasWali->id_kelas));
            });
        } elseif ($guruId) {
            $query->whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId));
        }

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function($q) use ($keyword) {
                $q->where('materi', 'LIKE', "%{$keyword}%")
                  ->orWhere('catatan', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('jadwal.mapel', fn($q2) => $q2->where('nama_mapel', 'LIKE', "%{$keyword}%"))
                  ->orWhereHas('jadwal.kelas', fn($q2) => $q2->where('nama_kelas', 'LIKE', "%{$keyword}%"));
            });
        }

        $trashedJurnals = $query->orderBy('deleted_at', 'desc')->get();

        return view('guru.riwayat_jurnal_trash', compact('trashedJurnals'));
    }

    /**
     * Pulihkan data jurnal dari Sampah
     */
    public function restoreRiwayatJurnal($id)
    {
        $jurnal = JurnalMengajar::onlyTrashed()->findOrFail($id);
        $jurnal->restore();

        return redirect()->route('guru.riwayat-jurnal.trash')
            ->with('success', 'Data jurnal mengajar berhasil dipulihkan.');
    }

    /**
     * Pulihkan batch data jurnal terpilih dari Sampah
     */
    public function restoreBatchRiwayatJurnal(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_filter(array_map('intval', (array)$ids));

        if (!empty($ids)) {
            $count = JurnalMengajar::onlyTrashed()->whereIn('id_jurnal', $ids)->restore();
            return redirect()->route('guru.riwayat-jurnal.trash')
                ->with('success', "{$count} data jurnal mengajar berhasil dipulihkan.");
        }

        return redirect()->route('guru.riwayat-jurnal.trash')
            ->with('error', 'Tidak ada data jurnal yang dipilih untuk dipulihkan.');
    }

    /**
     * Pulihkan semua data jurnal dari Sampah
     */
    public function restoreAllRiwayatJurnal()
    {
        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
        $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);

        $isWaliKelas = ($user && $user->isWaliKelas()) || ($guru && Kelas::where('wali_kelas', $guru->nip)->exists());
        $kelasWali = null;
        if ($isWaliKelas) {
            $kelasWali = Kelas::where('wali_kelas', $guru->nip ?? ($user->nip ?? ''))->first()
                         ?? ($user->id_kelas ? Kelas::find($user->id_kelas) : null);
        }

        $query = JurnalMengajar::onlyTrashed();
        if ($isWaliKelas && $kelasWali) {
            $query->where(function($q) use ($guruId, $kelasWali) {
                $q->whereHas('jadwal', fn($q2) => $q2->where('id_guru', $guruId))
                  ->orWhereHas('jadwal', fn($q2) => $q2->where('id_kelas', $kelasWali->id_kelas));
            });
        } elseif ($guruId) {
            $query->whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId));
        }

        $count = $query->restore();

        return redirect()->route('guru.riwayat-jurnal.trash')
            ->with('success', "Seluruh data jurnal ({$count} data) berhasil dipulihkan.");
    }

    /**
     * Hapus permanen data jurnal
     */
    public function forceDeleteRiwayatJurnal($id)
    {
        $jurnal = JurnalMengajar::onlyTrashed()->findOrFail($id);

        if ($jurnal->dokumentasi && file_exists(public_path('uploads/dokumentasi/' . $jurnal->dokumentasi))) {
            @unlink(public_path('uploads/dokumentasi/' . $jurnal->dokumentasi));
        }

        JurnalDetailKetidakhadiran::where('id_jurnal', $jurnal->id_jurnal)->delete();
        $jurnal->forceDelete();

        return redirect()->route('guru.riwayat-jurnal.trash')
            ->with('success', 'Data jurnal mengajar berhasil dihapus permanen.');
    }

    /**
     * Hapus permanen batch data jurnal terpilih
     */
    public function forceDeleteBatchRiwayatJurnal(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_filter(array_map('intval', (array)$ids));

        if (!empty($ids)) {
            $count = 0;
            foreach ($ids as $id) {
                $j = JurnalMengajar::onlyTrashed()->find($id);
                if ($j) {
                    if ($j->dokumentasi && file_exists(public_path('uploads/dokumentasi/' . $j->dokumentasi))) {
                        @unlink(public_path('uploads/dokumentasi/' . $j->dokumentasi));
                    }
                    JurnalDetailKetidakhadiran::where('id_jurnal', $j->id_jurnal)->delete();
                    $j->forceDelete();
                    $count++;
                }
            }
            return redirect()->route('guru.riwayat-jurnal.trash')
                ->with('success', "{$count} data jurnal berhasil dihapus secara permanen.");
        }

        return redirect()->route('guru.riwayat-jurnal.trash')
            ->with('error', 'Tidak ada data yang dipilih untuk dihapus permanen.');
    }

    /**
     * Kosongkan Sampah Riwayat Jurnal
     */
    public function emptyTrashRiwayatJurnal()
    {
        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
        $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);

        $isWaliKelas = ($user && $user->isWaliKelas()) || ($guru && Kelas::where('wali_kelas', $guru->nip)->exists());
        $kelasWali = null;
        if ($isWaliKelas) {
            $kelasWali = Kelas::where('wali_kelas', $guru->nip ?? ($user->nip ?? ''))->first()
                         ?? ($user->id_kelas ? Kelas::find($user->id_kelas) : null);
        }

        $query = JurnalMengajar::onlyTrashed();
        if ($isWaliKelas && $kelasWali) {
            $query->where(function($q) use ($guruId, $kelasWali) {
                $q->whereHas('jadwal', fn($q2) => $q2->where('id_guru', $guruId))
                  ->orWhereHas('jadwal', fn($q2) => $q2->where('id_kelas', $kelasWali->id_kelas));
            });
        } elseif ($guruId) {
            $query->whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId));
        }

        $trashedList = $query->get();
        $count = $trashedList->count();

        foreach ($trashedList as $j) {
            if ($j->dokumentasi && file_exists(public_path('uploads/dokumentasi/' . $j->dokumentasi))) {
                @unlink(public_path('uploads/dokumentasi/' . $j->dokumentasi));
            }
            JurnalDetailKetidakhadiran::where('id_jurnal', $j->id_jurnal)->delete();
            $j->forceDelete();
        }

        return redirect()->route('guru.riwayat-jurnal.trash')
            ->with('success', "Sampah riwayat jurnal berhasil dikosongkan ({$count} data dihapus permanen).");
    }

    /**
     * Presensi & Perkembangan Kelas (Role Wali Kelas)
     */
    /**
     * Presensi & Perkembangan Kelas (Role Wali Kelas)
     */
     public function kehadiranKelas(Request $request)
     {
         $user = Auth::user();
 
         if (!$user || (!$user->isWaliKelas() && !$user->isAdmin() && !$user->isTu())) {
             return redirect()->route('guru.dashboard')
                 ->with('error', 'Halaman Presensi & Perkembangan Kelas hanya dapat diakses oleh Guru yang bertugas sebagai Wali Kelas.');
         }
 
         $alasan = $request->input('alasan');
         $minggu = $request->input('minggu');
         $search = $request->input('q');
         $idKelasReq = $request->input('id_kelas');

         $bulanInput = $request->input('bulan_selected') ?? $request->input('bulan');
         $tahunInput = $request->input('tahun_selected') ?? $request->input('tahun');

         $nowJakarta = Carbon::now('Asia/Jakarta');
         $curYear = (int) $nowJakarta->year;
         $curMonth = (int) $nowJakarta->month;

         if ($bulanInput && str_contains((string)$bulanInput, '-')) {
             $parts = explode('-', (string)$bulanInput);
             $bulanSelected = (int) $parts[0];
             $tahunSelected = (int) $parts[1];
         } else {
             $bulanSelected = $bulanInput ? (int) $bulanInput : $curMonth;
             $tahunSelected = $tahunInput ? (int) $tahunInput : $curYear;
         }

         // Enforce boundary: Restrict strictly to year 2026 and months up to current month
         if ($tahunSelected !== $curYear || $bulanSelected > $curMonth || $bulanSelected < 1) {
             $bulanSelected = $curMonth;
             $tahunSelected = $curYear;
         }

         $bulan = $bulanSelected;
         $tahun = $tahunSelected;
 
         // 1. Resolve Wali Kelas Assigned Class
         $guruModel = null;
         if ($user->id_guru) {
             $guruModel = Guru::find($user->id_guru);
         }
         if (!$guruModel && $user->nip) {
             $guruModel = Guru::where('nip', $user->nip)->first();
         }
         $guruNip = $guruModel ? $guruModel->nip : $user->nip;
 
         // Kelas yang bisa diakses
         if ($user->isAdmin() || $user->isTu()) {
             $kelases = Kelas::with(['jurusan', 'ruangan'])->orderBy('nama_kelas', 'asc')->get();
         } else {
             $kelases = Kelas::with(['jurusan', 'ruangan'])->where('wali_kelas', $guruNip)->orderBy('nama_kelas', 'asc')->get();
             if ($kelases->isEmpty() && $user->id_kelas) {
                 $kDef = Kelas::find($user->id_kelas);
                 if ($kDef) $kelases = collect([$kDef]);
             }
         }
 
         $kelasAktif = null;
         if ($idKelasReq) {
             $kelasAktif = Kelas::find($idKelasReq);
         }
         if (!$kelasAktif && $kelases->isNotEmpty()) {
             $kelasAktif = $kelases->first();
         }
         if (!$kelasAktif) {
             // Fallback kelas default jika belum ada
             $kelasAktif = Kelas::where('nama_kelas', 'XI RPL 1')->first() ?? Kelas::first();
         }
 
         if (!$kelasAktif) {
             return redirect()->route('guru.dashboard')
                 ->with('error', 'Data kelas perwalian belum tersedia di sistem.');
         }
 
         $idKelasSelected = $kelasAktif->id_kelas;
         $namaKelas = $kelasAktif->nama_kelas;
         if ($kelases->isEmpty()) {
             $kelases = collect([$kelasAktif]);
         }
 
         // 2. Query Siswa in Selected Class
         $siswasQuery = Siswa::where('id_kelas', $idKelasSelected);
         if ($search) {
             $siswasQuery->where(function($q) use ($search) {
                 $q->where('nama_siswa', 'like', "%{$search}%")
                   ->orWhere('nis', 'like', "%{$search}%")
                   ->orWhere('nisn', 'like', "%{$search}%");
             });
         }
         $siswas = $siswasQuery->orderBy('nama_siswa', 'asc')->get();
         $totalSiswa = $siswas->count();
         if ($totalSiswa == 0) {
             // Ambil jumlah siswa dari data kelas jika belum ada siswa terdaftar
             $totalSiswa = (int) ($kelasAktif->jumlah_siswa ?? 0);
         }
 
         // 3. Calculate Today's Attendance Summary Stat Cards
         $todayDate = Carbon::now('Asia/Jakarta')->toDateString();
 
         $absensiHariIni = JurnalDetailKetidakhadiran::whereHas('siswa', function($q) use ($idKelasSelected) {
             $q->where('id_kelas', $idKelasSelected);
         })->whereHas('jurnal', function($q) use ($todayDate) {
             $q->where('tanggal', $todayDate);
         })->get();
 
         $sakitHariIni = $absensiHariIni->where('keterangan', 'Sakit')->count();
         $izinHariIni  = $absensiHariIni->where('keterangan', 'Izin')->count();
         $alpaHariIni  = $absensiHariIni->whereIn('keterangan', ['Alpa', 'Tanpa Keterangan'])->count();
 
         $totalAbsenHariIni = $sakitHariIni + $izinHariIni + $alpaHariIni;
         $hadirHariIni = max(0, $totalSiswa - $totalAbsenHariIni);
         $persenHadirHariIni = $totalSiswa > 0 ? round(($hadirHariIni / $totalSiswa) * 100, 2) : 100;
 
         // 4. Calculate Weekly Attendance Percentages (M1, M2, M3, M4)
         $currentMonth = (int) ($bulan ?? Carbon::now('Asia/Jakarta')->month);
         $currentYear = (int) Carbon::now('Asia/Jakarta')->year;
         
         // Real calculations per week of the month
         $startOfMonth = Carbon::create($currentYear, $currentMonth, 1);
         $weeksData = [];
         for ($w = 1; $w <= 4; $w++) {
             $wStart = (clone $startOfMonth)->addDays(($w - 1) * 7);
             $wEnd = (clone $wStart)->addDays(6);
             if ($wEnd->month != $currentMonth) {
                 $wEnd = (clone $startOfMonth)->endOfMonth();
             }
             
             $absWeekCount = JurnalDetailKetidakhadiran::whereHas('siswa', function($q) use ($idKelasSelected) {
                 $q->where('id_kelas', $idKelasSelected);
             })->whereHas('jurnal', function($q) use ($wStart, $wEnd) {
                 $q->whereBetween('tanggal', [$wStart->toDateString(), $wEnd->toDateString()]);
             })->count();
             
             $expectedPresenceWeek = max(1, $totalSiswa * 5);
             $actualPresenceWeek = max(0, $expectedPresenceWeek - $absWeekCount);
             $persenW = round(($actualPresenceWeek / $expectedPresenceWeek) * 100);
             if ($persenW > 100) $persenW = 100;
             
             $weeksData["M{$w}"] = [
                 'label' => "Minggu {$w}",
                 'persen' => $persenW,
             ];
         }
         $persentaseMingguan = $weeksData;
 
         // 5. Daily Attendance Breakdown Matrix (Current Week: SEN, SEL, RAB, KAM, JUM)
         $startOfWeek = Carbon::now('Asia/Jakarta')->startOfWeek(); // Monday
         $daysOfWeek = [];
         for ($i = 0; $i < 5; $i++) {
             $dateObj = (clone $startOfWeek)->addDays($i);
             $daysOfWeek[] = [
                 'day_name' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'][$i],
                 'short'    => ['SEN', 'SEL', 'RAB', 'KAM', 'JUM'][$i],
                 'date'     => $dateObj->toDateString(),
             ];
         }
 
         // Build per-student attendance summary & daily matrix
         $rekapSiswa = [];
         foreach ($siswas as $siswa) {
            $absencesQuery = JurnalDetailKetidakhadiran::where('id_siswa', $siswa->id_siswa);
            $absencesQuery->whereHas('jurnal', function($q) use ($bulanSelected, $tahunSelected) {
                $q->whereMonth('tanggal', $bulanSelected)->whereYear('tanggal', $tahunSelected);
            });
            $listAbsen = $absencesQuery->get();
 
             $sakit = $listAbsen->where('keterangan', 'Sakit')->count();
             $izin  = $listAbsen->where('keterangan', 'Izin')->count();
             $alpa  = $listAbsen->whereIn('keterangan', ['Alpa', 'Tanpa Keterangan'])->count();
 
             $totAbsen = $sakit + $izin + $alpa;

             // Hitung hari efektif sekolah (non-weekend) dalam bulan yang dipilih
             $hariEfektifSiswa = 0;
             $startCalc = Carbon::create($tahunSelected, $bulanSelected, 1);
             $daysInMonthCalc = $startCalc->daysInMonth;
             for ($dc = 1; $dc <= $daysInMonthCalc; $dc++) {
                 $dayCheck = Carbon::create($tahunSelected, $bulanSelected, $dc);
                 if (!$dayCheck->isWeekend()) {
                     $hariEfektifSiswa++;
                 }
             }
             $hariEfektifSiswa = max(1, $hariEfektifSiswa);
             $hadirCount = max(0, $hariEfektifSiswa - $totAbsen);
             $persenKehadiran = round(($hadirCount / $hariEfektifSiswa) * 100, 1);
             $persenKehadiran = max(0, min(100, $persenKehadiran));
 
             $statusText = 'Baik';
             $statusClass = 'success';
             if ($persenKehadiran < 75 || $alpa >= 3) {
                 $statusText = 'Perlu tindak lanjut';
                 $statusClass = 'danger';
             } elseif ($persenKehadiran < 85 || $totAbsen >= 2) {
                 $statusText = 'Perlu pantau';
                 $statusClass = 'warning';
             }
 
             // Daily status (SEN - JUM)
             $harianGrid = [];
             foreach ($daysOfWeek as $dayInfo) {
                 $dDate = $dayInfo['date'];
                 $dayAbsen = JurnalDetailKetidakhadiran::where('id_siswa', $siswa->id_siswa)
                     ->whereHas('jurnal', function($q) use ($dDate) {
                         $q->where('tanggal', $dDate);
                     })->first();
 
                 if ($dayAbsen) {
                     $st = strtoupper(substr($dayAbsen->keterangan, 0, 1));
                     $harianGrid[$dayInfo['short']] = $st; // S, I, A
                 } else {
                     $harianGrid[$dayInfo['short']] = 'H';
                 }
             }
 
             if ($alasan) {
                if ($alasan == 'Sakit' && $sakit == 0) continue;
                if ($alasan == 'Izin' && $izin == 0) continue;
                if ($alasan == 'Alpa' && $alpa == 0) continue;
            }

            $rekapSiswa[] = [
                'siswa'      => $siswa,
                'harian'     => $harianGrid,
                'sakit'      => $sakit,
                'izin'       => $izin,
                'alpa'       => $alpa,
                'total'      => $totAbsen,
                'kehadiran'  => $persenKehadiran,
                'statusText' => $statusText,
                'statusClass'=> $statusClass,
            ];
        }
 
         // 6. Detailed Absence Records Table
         $detailQuery = JurnalDetailKetidakhadiran::with([
             'siswa',
             'jurnal.jadwal.mapel',
             'jurnal.jadwal.guru'
         ])->whereHas('siswa', function($q) use ($idKelasSelected) {
             $q->where('id_kelas', $idKelasSelected);
         });
 
         if ($alasan) {
             $detailQuery->where('keterangan', $alasan);
         }
 
         if ($bulanSelected) {
             $detailQuery->whereHas('jurnal', function($q) use ($bulanSelected, $tahunSelected) {
                 $q->whereMonth('tanggal', $bulanSelected)->whereYear('tanggal', $tahunSelected);
             });
         }
 
         if ($search) {
             $detailQuery->whereHas('siswa', function($q) use ($search) {
                 $q->where('nama_siswa', 'like', "%{$search}%");
             });
         }
 
         $rincianAbsen = $detailQuery->orderBy('id_detail', 'desc')->get();
 
         // 7. Student Permission Letters (Surat Izin / Sakit)
         $suratIzinList = SiswaSuratIzin::with(['siswa', 'petugasPiket'])
             ->where('id_kelas', $idKelasSelected)
             ->orderBy('tanggal', 'desc')
             ->get();
 
         // 8. Prepare Student Grid Cards for "Kelas Perwalian" view (Tab 2)
         $tab = $request->input('tab', 'dashboard');
         $statusFilter = $request->input('status');
 
         $studentCards = [];
         foreach ($rekapSiswa as $rItem) {
             $s = $rItem['siswa'];
             $nameParts = explode(' ', trim($s->nama_siswa));
             $initials = count($nameParts) >= 2
                 ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1))
                 : strtoupper(substr($s->nama_siswa, 0, 2));
 
             $studentCards[] = [
                 'siswa'       => $s,
                 'initials'    => $initials,
                 'persen'      => $rItem['kehadiran'],
                 'statusText'  => $rItem['statusText'],
                 'statusClass' => $rItem['statusClass'],
                 'sakit'       => $rItem['sakit'],
                 'izin'        => $rItem['izin'],
                 'alpa'        => $rItem['alpa'],
                 'total'       => $rItem['total'],
             ];
         }
 
         // 9. Monthly Rekap Kehadiran & Calendar Heatmap Grid (Tab 3)
         $curYear = (int) Carbon::now('Asia/Jakarta')->year;
         $curMonth = (int) Carbon::now('Asia/Jakarta')->month;

         $dateCarbon = Carbon::create($tahunSelected, $bulanSelected, 1);
         $namaBulanIndo = [
             1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
             5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
             9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
         ];
         $namaBulanTahun = ($namaBulanIndo[$bulanSelected] ?? $dateCarbon->translatedFormat('F')) . ' ' . $tahunSelected;

         $prevCarbon = (clone $dateCarbon)->subMonth();
         $nextCarbon = (clone $dateCarbon)->addMonth();

         $prevBulan = $prevCarbon->month;
         $prevTahun = $prevCarbon->year;
         $nextBulan = $nextCarbon->month;
         $nextTahun = $nextCarbon->year;

         $canGoNextMonth = ($nextCarbon->year === $curYear && $nextCarbon->month <= $curMonth);

         // Build available Month & Year options (Only for year 2026 up to current month)
         $availableMonthYears = [];
         for ($m = $curMonth; $m >= 1; $m--) {
             $availableMonthYears[] = [
                 'month'       => $m,
                 'year'        => $curYear,
                 'val'         => "{$m}-{$curYear}",
                 'label'       => $namaBulanIndo[$m] . ' ' . $curYear,
                 'is_selected' => ($m === $bulanSelected && $tahunSelected === $curYear),
             ];
         }
 
         // Monthly Stats for Selected Month
         $monthlyAbsences = JurnalDetailKetidakhadiran::whereHas('siswa', function($q) use ($idKelasSelected) {
             $q->where('id_kelas', $idKelasSelected);
         })->whereHas('jurnal', function($q) use ($bulanSelected, $tahunSelected) {
             $q->whereMonth('tanggal', $bulanSelected)->whereYear('tanggal', $tahunSelected);
         })->get();
 
         $totalSakitBulan = $monthlyAbsences->where('keterangan', 'Sakit')->count();
         $totalIzinBulan  = $monthlyAbsences->where('keterangan', 'Izin')->count();
         $totalAlpaBulan  = $monthlyAbsences->whereIn('keterangan', ['Alpa', 'Tanpa Keterangan'])->count();
         $totalKetidakhadiranBulan = $totalSakitBulan + $totalIzinBulan + $totalAlpaBulan;
 
         // Days Heatmap Grid 1 - daysInMonth
         $daysInMonth = $dateCarbon->daysInMonth;
         $calendarHeatmap = [];
         $schoolDaysCount = 0;
         $totalDailyRateSum = 0;
         $nowJakarta = Carbon::now('Asia/Jakarta');
         $todayDateStr = $nowJakarta->toDateString();

         for ($d = 1; $d <= $daysInMonth; $d++) {
             $curDayDate = Carbon::create($tahunSelected, $bulanSelected, $d);
             $curDateStr = $curDayDate->toDateString();
             $isWeekend = $curDayDate->isWeekend();
             $isToday = ($curDateStr === $todayDateStr);
             $isFuture = ($curDateStr > $todayDateStr);

             if ($isWeekend) {
                 $type = 'holiday';
                 $dayRate = 0;
             } elseif ($isFuture) {
                 // Tanggal hari kerja yang belum dilalui / masa depan: abu-abu muda
                 $type = 'heat-future';
                 $dayRate = null;
             } else {
                 $schoolDaysCount++;
                 $dayAbsCount = JurnalDetailKetidakhadiran::whereHas('siswa', function($q) use ($idKelasSelected) {
                    $q->where('id_kelas', $idKelasSelected);
                })->whereHas('jurnal', function($q) use ($curDateStr) {
                    $q->where('tanggal', $curDateStr);
                })->pluck('id_siswa')->unique()->count();

                 $dayRate = $totalSiswa > 0 ? max(0, round((($totalSiswa - $dayAbsCount) / $totalSiswa) * 100)) : 100;
                 $totalDailyRateSum += $dayRate;

                 if ($dayRate >= 95) {
                     $type = 'heat-95';
                 } elseif ($dayRate >= 85) {
                     $type = 'heat-85';
                 } elseif ($dayRate >= 70) {
                     $type = 'heat-70';
                 } else {
                     $type = 'heat-red';
                 }
             }

             $calendarHeatmap[] = [
                 'day'       => $d,
                 'type'      => $type,
                 'rate'      => $dayRate,
                 'date'      => $curDateStr,
                 'is_work'   => !$isWeekend,
                 'is_today'  => $isToday,
                 'is_future' => $isFuture,
                 'is_weekend'=> $isWeekend,
             ];
         }

         $hariEfektif = max(1, $schoolDaysCount);
         $rataRataHadirBulan = $schoolDaysCount > 0 ? round($totalDailyRateSum / $schoolDaysCount) : 100;
 
         // 10. Data Laporan Bulanan (Tab 4)
         $siswaPerluTindakLanjutCount = collect($studentCards)->where('statusText', 'Perlu tindak lanjut')->count();
         
         // Top Ranked students needing attention
         $sortedForAttention = collect($rekapSiswa)->sortBy('kehadiran')->take(5)->values();
         $perluPerhatianList = [];
         $rank = 1;
         foreach ($sortedForAttention as $item) {
             $sObj = $item['siswa'];
             $nameParts = explode(' ', trim($sObj->nama_siswa));
             $ini = count($nameParts) >= 2
                 ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1))
                 : strtoupper(substr($sObj->nama_siswa, 0, 2));
 
             $reason = "{$item['total']}x ketidakhadiran bulan ini";
             if ($item['alpa'] > 0) $reason = "{$item['alpa']}x alpa bulan ini";
             elseif ($item['sakit'] > 0) $reason = "{$item['sakit']}x sakit bulan ini";
             elseif ($item['izin'] > 0) $reason = "{$item['izin']}x izin bulan ini";
 
             $perluPerhatianList[] = [
                'id_siswa' => $sObj->id_siswa,
                'rank'     => $rank++,
                'initials' => $ini,
                'nama'     => $sObj->nama_siswa,
                'subtext'  => $reason,
                'persen'   => "{$item['kehadiran']}%",
            ];
         }
 
         $attentionNames = collect($perluPerhatianList)->take(3)->pluck('nama')->implode(', ');
         $catatanWaliKelasDefault = "Kehadiran kelas {$namaKelas} bulan {$namaBulanTahun} rata-rata berada pada angka {$rataRataHadirBulan}%. " .
             ($attentionNames ? "Siswa yang memerlukan pemantauan intensif dan koordinasi dengan orang tua: {$attentionNames}." : "Seluruh siswa menunjukkan kedisiplinan kehadiran yang sangat baik.");
 
         // 11. Data Surat Izin & Sakit (Tab 5)
         $menungguVerifikasiCount = SiswaSuratIzin::where('id_kelas', $idKelasSelected)->where('status', 'Menunggu')->count();
         $terverifikasiCount      = SiswaSuratIzin::where('id_kelas', $idKelasSelected)->where('status', 'Terverifikasi')->count();
         $tanpaKeteranganCount    = $alpaHariIni;
         $suratIzinTrashCount     = SiswaSuratIzin::onlyTrashed()->where('id_kelas', $idKelasSelected)->count();
         $suratIzinTrashList      = SiswaSuratIzin::onlyTrashed()->with(['siswa', 'petugasPiket'])->where('id_kelas', $idKelasSelected)->orderBy('deleted_at', 'desc')->get();
 
         $suratPengajuanList = [];
         foreach ($suratIzinList as $suratItem) {
             $sObj = $suratItem->siswa;
             $nama = $sObj ? $sObj->nama_siswa : 'Siswa';
             $nis = $sObj ? ($sObj->nis ?? $sObj->nisn ?? '-') : '-';
             $nameParts = explode(' ', trim($nama));
             $initials = count($nameParts) >= 2
                 ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1))
                 : strtoupper(substr($nama, 0, 2));
 
             $suratPengajuanList[] = [
                 'id_surat_izin' => $suratItem->id_surat_izin,
                 'initials'    => $initials,
                 'nama'        => $nama,
                 'nis'         => $nis,
                 'jenis'       => $suratItem->kategori,
                 'tgl_absen'   => $suratItem->rentang_tanggal_text,
                 'diajukan'    => $suratItem->created_at ? $suratItem->created_at->format('d M, H:i') : '-',
                 'lampiran'    => $suratItem->foto_bukti ? 'Ada Foto Bukti Surat' : 'Catatan Izin',
                 'foto_url'    => $suratItem->foto_url,
                 'status'      => $suratItem->status ?? 'Terverifikasi',
                 'statusClass' => $suratItem->status_badge_class,
                 'keterangan'  => $suratItem->keterangan ?? '-',
                 'petugas'     => $suratItem->petugasPiket->name ?? 'Guru Piket',
             ];
         }
 
         // 12. Data Surat Dispen Siswa (Tab 6)
        $dispenList = SiswaDispen::with(['siswa', 'kelas', 'guruPiketUser', 'wakaUser'])
            ->where('id_kelas', $idKelasSelected)
            ->orderBy('tanggal', 'desc')
            ->get();

        $dispenTotalCount     = $dispenList->count();
        $dispenDisetujuiCount = $dispenList->where('status_waka', 'approved')->count();
        $dispenMenungguCount  = $dispenList->where('status_waka', 'pending')->count();
        $dispenDitolakCount   = $dispenList->where('status_waka', 'rejected')->count();
        $dispenTrashCount     = SiswaDispen::onlyTrashed()->where('id_kelas', $idKelasSelected)->count();
        $dispenTrashList      = SiswaDispen::onlyTrashed()->with(['siswa', 'kelas', 'guruPiketUser', 'wakaUser'])->where('id_kelas', $idKelasSelected)->orderBy('deleted_at', 'desc')->get();
 
         // 13. Data Pengaturan & Akun (Tab 7)
         $guruNama  = $guruModel ? $guruModel->nama_guru : $user->name;
         $guruNip   = $guruModel ? $guruModel->nip : ($user->nip ?? '-');
         $guruEmail = $user->email ?? (strtolower(str_replace([' ', ',', '.'], '', $guruNama)) . '@edujournal.sch.id');
         $guruNoHp  = $user->no_hp ?? ($guruModel->no_hp ?? '081234567890');
         
         $taAktifObj = \App\Models\TahunAjaran::getActive();
         $tahunAjaranAktif = $taAktifObj ? "{$taAktifObj->tahun_ajaran} • Semester {$taAktifObj->semester}" : '2026/2027 • Semester Ganjil';
 
         return view('guru.kehadiran_kelas', compact(
             'kelases',
             'kelasAktif',
             'namaKelas',
             'idKelasSelected',
             'siswas',
             'totalSiswa',
             'hadirHariIni',
             'persenHadirHariIni',
             'sakitHariIni',
             'izinHariIni',
             'alpaHariIni',
             'persentaseMingguan',
             'daysOfWeek',
             'rekapSiswa',
             'rincianAbsen',
             'suratIzinList',
             'studentCards',
             'tab',
             'statusFilter',
             'alasan',
             'bulan',
             'minggu',
             'search',
             'bulanSelected',
             'tahunSelected',
             'namaBulanTahun',
             'prevBulan',
             'prevTahun',
             'nextBulan',
             'nextTahun',
             'rataRataHadirBulan',
             'totalSakitBulan',
             'totalIzinBulan',
             'totalAlpaBulan',
             'calendarHeatmap',
             'hariEfektif',
             'totalKetidakhadiranBulan',
             'siswaPerluTindakLanjutCount',
             'perluPerhatianList',
             'catatanWaliKelasDefault',
             'menungguVerifikasiCount',
             'terverifikasiCount',
             'tanpaKeteranganCount',
             'suratIzinTrashCount',
             'suratIzinTrashList',
             'suratPengajuanList',
             'dispenList',
             'dispenTotalCount',
             'dispenDisetujuiCount',
             'dispenMenungguCount',
             'dispenDitolakCount',
             'dispenTrashCount',
             'dispenTrashList',
             'guruNama',
             'guruNip',
             'guruEmail',
             'guruNoHp',
             'tahunAjaranAktif',
             'availableMonthYears',
             'canGoNextMonth'
         ));
     }
 
     /**
      * Detail Siswa Lengkap untuk Modal Wali Kelas (JSON API)
      */
     public function detailSiswaWaliJson($id)
     {
         $siswa = Siswa::with('kelas')->find($id);
         if (!$siswa) {
             return response()->json(['success' => false, 'message' => 'Data siswa tidak ditemukan.'], 404);
         }
 
         $userSiswa = User::where('id_siswa', $id)->first();
 
         $absensiRecords = JurnalDetailKetidakhadiran::with(['jurnal.jadwal.mapel', 'jurnal.jadwal.guru'])
             ->where('id_siswa', $id)
             ->orderBy('id_detail', 'desc')
             ->get();
 
         $sakitCount = $absensiRecords->where('keterangan', 'Sakit')->count();
         $izinCount  = $absensiRecords->where('keterangan', 'Izin')->count();
         $alpaCount  = $absensiRecords->whereIn('keterangan', ['Alpa', 'Tanpa Keterangan'])->count();
         $totalAbsen = $sakitCount + $izinCount + $alpaCount;

         // Hitung hari efektif bulan ini
         $bulanSekarang = (int) Carbon::now('Asia/Jakarta')->month;
         $tahunSekarang = (int) Carbon::now('Asia/Jakarta')->year;
         $startCalcDetail = Carbon::create($tahunSekarang, $bulanSekarang, 1);
         $hariEfektifDetail = 0;
         for ($dcd = 1; $dcd <= $startCalcDetail->daysInMonth; $dcd++) {
             if (!Carbon::create($tahunSekarang, $bulanSekarang, $dcd)->isWeekend()) {
                 $hariEfektifDetail++;
             }
         }
         $hariEfektifDetail = max(1, $hariEfektifDetail);
         $persenHadirDetail = round((($hariEfektifDetail - $totalAbsen) / $hariEfektifDetail) * 100, 1);
         $persenHadirDetail = max(0, min(100, $persenHadirDetail));
 
         $suratIzins = SiswaSuratIzin::where('id_siswa', $id)->orderBy('tanggal', 'desc')->get();
         $dispens = SiswaDispen::where('id_siswa', $id)->orderBy('tanggal', 'desc')->get();
 
         $fotoUrl = null;
         if ($userSiswa && $userSiswa->foto) {
             $fotoUrl = asset('storage/' . $userSiswa->foto);
         }
 
         return response()->json([
             'success' => true,
             'data' => [
                 'id_siswa'       => $siswa->id_siswa,
                 'nama_siswa'     => $siswa->nama_siswa,
                 'nis'            => $siswa->nis,
                 'nisn'           => $siswa->nisn,
                 'jenis_kelamin'  => $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                 'tempat_lahir'   => $siswa->kota_lahir ?? '-',
                 'tanggal_lahir'  => $siswa->tanggal_lahir ? Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-',
                 'nama_kelas'     => $siswa->kelas->nama_kelas ?? '-',
                 'nama_wali'      => $userSiswa->name ?? 'Orang Tua / Wali Siswa',
                 'no_hp_wali'     => $userSiswa->no_hp ?? '081234567890',
                 'alamat'         => $siswa->alamat_lengkap ?? '-',
                 'foto_url'       => $fotoUrl,
                 'sakit'          => $sakitCount,
                 'izin'           => $izinCount,
                 'alpa'           => $alpaCount,
                 'total_absen'    => $totalAbsen,
                 'persen_hadir'   => $persenHadirDetail,
                 'riwayat_absen'  => $absensiRecords->map(fn($a) => [
                     'tanggal'    => optional($a->jurnal)->tanggal ? Carbon::parse($a->jurnal->tanggal)->translatedFormat('d M Y') : '-',
                     'mapel'      => optional(optional($a->jurnal)->jadwal)->mapel->nama_mapel ?? '-',
                     'keterangan' => $a->keterangan,
                     'catatan'    => $a->catatan ?? '-',
                 ]),
                 'riwayat_surat'  => $suratIzins->map(fn($s) => [
                     'kategori'   => $s->kategori,
                     'tanggal'    => $s->rentang_tanggal_text,
                     'status'     => $s->status,
                 ]),
                 'riwayat_dispen' => $dispens->map(fn($d) => [
                    'kategori'   => $d->alasan ?? 'Dispensasi',
                    'tanggal'    => $d->tanggal ? Carbon::parse($d->tanggal)->translatedFormat('d M Y') : '-',
                    'status'     => $d->status_waka == 'approved' ? 'Disetujui' : 'Menunggu',
                ]),
             ]
         ]);
     }

    /**
     * Halaman Pengajuan Izin Tidak Masuk untuk Guru Mengajar
     */
    /**
     * Halaman Pengajuan Izin Tidak Masuk untuk Guru Mengajar (dengan Filter & Search & Trash)
     */
    public function permintaanIzin(Request $request)
    {
        $this->ensureGuruIzinColumnsExist();
        $user = Auth::user();
        $guru = null;
        if ($user && $user->id_guru) {
            $guru = Guru::find($user->id_guru);
        } elseif ($user && $user->nip) {
            $guru = Guru::where('nip', $user->nip)->first();
        }

        $query = GuruIzin::with(['guru', 'guruPiket']);
        if ($guru) {
            $query->where('id_guru', $guru->id_guru);
        }

        // Pencarian Keyword (Alasan, Materi)
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function($q) use ($keyword) {
                $q->where('alasan', 'LIKE', "%{$keyword}%")
                  ->orWhere('materi_dititipkan', 'LIKE', "%{$keyword}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $st = $request->status;
            if ($st === 'pending') {
                $query->where('status_piket', 'pending');
            } elseif ($st === 'approved') {
                $query->where('status_final', 'approved');
            } elseif ($st === 'rejected') {
                $query->where(function($q) {
                    $q->where('status_waka', 'rejected')
                      ->orWhere('status_kepsek', 'rejected')
                      ->orWhere('status_final', 'rejected');
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

        $myIzinList = $query->orderBy('id_guru_izin', 'desc')->get();
        $guruList = Guru::orderBy('nama_guru', 'asc')->get();
        $piketUsers = \App\Models\User::where('role', 'piket')->get();

        $trashedQuery = GuruIzin::onlyTrashed();
        if ($guru) {
            $trashedQuery->where('id_guru', $guru->id_guru);
        }
        $trashedCount = $trashedQuery->count();

        return view('guru.permintaan_izin', compact('guru', 'myIzinList', 'guruList', 'piketUsers', 'trashedCount'));
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
     * Simpan Pengajuan Izin dari Guru Mengajar
     */
    public function storePermintaanIzin(Request $request)
    {
        $this->ensureGuruIzinColumnsExist();

        $user = Auth::user();
        $idGuru = $request->id_guru;

        if (!$idGuru && $user && $user->id_guru) {
            $idGuru = $user->id_guru;
        }

        $request->validate([
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'nullable|date|after_or_equal:tanggal_mulai',
            'alasan'            => 'required|string',
            'materi_dititipkan' => 'nullable|string',
            'tugas_dititipkan'  => 'nullable|string',
            'file_tugas'        => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png,zip|max:10000',
            'foto_surat'        => 'required|image|mimes:jpeg,png,jpg,webp|max:5000',
            'keterangan_khusus' => 'nullable|string',
        ], [
            'tanggal_selesai.after_or_equal' => 'Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin.',
            'foto_surat.required' => 'Foto Surat / Bukti Izin wajib diunggah untuk semua kategori izin.',
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
                'keterangan_khusus.required' => 'Keterangan khusus Cuti wajib diisi jika izin lebih dari 3 hari.',
            ]);
            $kategoriIzin = 'cuti';
            $durasi = "Cuti / Izin Khusus ({$diffDays} Hari: " . Carbon::parse($tglMulai)->format('d/m/Y') . " s/d " . Carbon::parse($tglSelesai)->format('d/m/Y') . ")";
        } else {
            $kategoriIzin = 'biasa';
            $durasi = "{$diffDays} Hari (" . Carbon::parse($tglMulai)->format('d/m/Y') . ($tglMulai !== $tglSelesai ? " s/d " . Carbon::parse($tglSelesai)->format('d/m/Y') : "") . ")";
        }

        $fotoName = null;
        if ($request->hasFile('foto_surat')) {
            $file = $request->file('foto_surat');
            $fotoName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/guru_izin'), $fotoName);
        }

        $fileName = null;
        if ($request->hasFile('file_tugas')) {
            $fileTugas = $request->file('file_tugas');
            $fileName = time() . '_tugas_' . Str::random(8) . '.' . $fileTugas->getClientOriginalExtension();
            $fileTugas->move(public_path('uploads/tugas_pengganti'), $fileName);
        }

        $token = Str::random(40);

        $newIzin = GuruIzin::create([
            'id_guru'           => $idGuru,
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
            'status_kepsek'     => 'pending',
            'status_final'      => 'pending',
            'is_pengajuan_guru' => 1,
            'status_piket'      => 'pending',
        ]);

        $guru = Guru::find($idGuru);
        $guruNama = $guru->nama_guru ?? ($user->name ?? 'Guru Mengajar');
        $guruNip  = $guru->nip ?? ($user->nip ?? '-');

        $piketLink = url('/guru-piket/permintaan-izin');
        $tglFormatted = Carbon::parse($tglMulai)->format('d-m-Y') . ($tglMulai !== $tglSelesai ? ' s/d ' . Carbon::parse($tglSelesai)->format('d-m-Y') : '');
        $katTeks = $isCuti ? 'Cuti / Izin Khusus (>3 Hari)' : 'Izin Biasa (1-3 Hari)';

        $waMessage = "*PERMINTAAN IZIN GURU MENGAJAR*\n"
            . "----------------------------------\n"
            . "*Pengaju:* {$guruNama} (NIP. {$guruNip})\n"
            . "*Kategori:* {$katTeks}\n"
            . "*Tanggal:* {$tglFormatted}\n"
            . "*Alasan:* {$request->alasan}\n";

        if ($request->materi_dititipkan) {
            $waMessage .= "*Titipan Materi/Tugas:* {$request->materi_dititipkan}\n";
        }

        $waMessage .= "----------------------------------\n"
            . "Mohon Bapak/Ibu Guru Piket dapat mengecek, memvalidasi, dan mengisikan data izin melalui sistem Web EDU JOURNAL pada tautan berikut:\n"
            . $piketLink . "\n\n"
            . "Terima kasih.";

        $targetPhone = $request->input('wa_target_phone');
        if ($targetPhone) {
            $cleanPhone = preg_replace('/[^0-9]/', '', $targetPhone);
            if (str_starts_with($cleanPhone, '0')) {
                $cleanPhone = '62' . substr($cleanPhone, 1);
            }
            $waUrl = "https://api.whatsapp.com/send?phone={$cleanPhone}&text=" . rawurlencode($waMessage);
        } else {
            $waUrl = "https://api.whatsapp.com/send?text=" . rawurlencode($waMessage);
        }

        return redirect()->route('guru.permintaan-izin')->with([
            'success'      => 'Permintaan izin tidak hadir mengajar berhasil terkirim ke sistem Guru Piket!',
            'piket_link'   => $piketLink,
            'wa_url'       => $waUrl,
            'guru_nama'    => $guruNama,
            'guru_nip'     => $guruNip,
            'new_izin_id'  => $newIzin->id_guru_izin,
        ]);
    }

    /**
     * Detail Presensi Harian Kelas untuk Modal Peta Kehadiran (JSON API)
     */
    public function detailKehadiranHarianJson(Request $request)
    {
        $idKelas = $request->input('id_kelas');
        $tanggal = $request->input('tanggal', Carbon::now('Asia/Jakarta')->toDateString());

        $kelas = Kelas::with(['jurusan', 'ruangan', 'waliKelas'])->find($idKelas);
        if (!$kelas) {
            $user = Auth::user();
            $guruModel = $user && $user->id_guru ? Guru::find($user->id_guru) : ($user && $user->nip ? Guru::where('nip', $user->nip)->first() : null);
            $guruNip = $guruModel ? $guruModel->nip : ($user ? $user->nip : null);
            $kelas = Kelas::where('wali_kelas', $guruNip)->first() ?? Kelas::first();
        }

        if (!$kelas) {
            return response()->json(['success' => false, 'message' => 'Kelas tidak ditemukan.'], 404);
        }

        $dateCarbon = Carbon::parse($tanggal);
        $isWeekend = $dateCarbon->isWeekend();
        $todayDate = Carbon::now('Asia/Jakarta')->toDateString();
        $isToday = ($tanggal === $todayDate);
        $isFuture = ($tanggal > $todayDate);

        $siswas = Siswa::where('id_kelas', $kelas->id_kelas)->orderBy('nama_siswa', 'asc')->get();
        $totalSiswa = $siswas->count();

        // 1. Ketidakhadiran dari Jurnal Mengajar pada tanggal tersebut
        $absensiRecords = JurnalDetailKetidakhadiran::with(['siswa', 'jurnal.jadwal.mapel', 'jurnal.jadwal.guru'])
            ->whereHas('siswa', function($q) use ($kelas) {
                $q->where('id_kelas', $kelas->id_kelas);
            })
            ->whereHas('jurnal', function($q) use ($tanggal) {
                $q->where('tanggal', $tanggal);
            })
            ->get();

        // 2. Surat Izin yang berlaku pada tanggal tersebut
        $suratIzins = SiswaSuratIzin::with('siswa')
            ->where('id_kelas', $kelas->id_kelas)
            ->whereDate('tanggal', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal)
            ->get();

        // 3. Siswa Dispen pada tanggal tersebut
        $dispens = SiswaDispen::with('siswa')
            ->where('id_kelas', $kelas->id_kelas)
            ->whereDate('tanggal', $tanggal)
            ->get();

        // 4. Jurnal KBM yang berlangsung pada kelas tersebut di hari tersebut
        $jurnals = JurnalMengajar::with(['jadwal.mapel', 'jadwal.guru', 'jadwal.jamMulai', 'jadwal.jamSelesai', 'jadwal.ruangan'])
            ->whereHas('jadwal', function($q) use ($kelas) {
                $q->where('id_kelas', $kelas->id_kelas);
            })
            ->where('tanggal', $tanggal)
            ->orderBy('id_jurnal', 'asc')
            ->get();

        // Hitung statistik harian
        $sakitCount = $absensiRecords->where('keterangan', 'Sakit')->pluck('id_siswa')->unique()->count();
        $izinCount  = $absensiRecords->where('keterangan', 'Izin')->pluck('id_siswa')->unique()->count();
        $alpaCount  = $absensiRecords->whereIn('keterangan', ['Alpa', 'Tanpa Keterangan'])->pluck('id_siswa')->unique()->count();
        
        foreach ($suratIzins as $si) {
            if (!$absensiRecords->contains('id_siswa', $si->id_siswa)) {
                if ($si->kategori === 'Sakit') $sakitCount++;
                else $izinCount++;
            }
        }

        $dispenCount = $dispens->count();
        $totalAbsenUnique = $absensiRecords->pluck('id_siswa')->unique()->count();
        $hadirCount = max(0, $totalSiswa - $totalAbsenUnique);
        $ratePersen = $totalSiswa > 0 ? round(($hadirCount / $totalSiswa) * 100, 1) : 100;

        // Daftar Siswa Tidak Hadir
        $daftarTidakHadir = [];
        $recordedSiswaIds = [];

        foreach ($absensiRecords as $ar) {
            $s = $ar->siswa;
            if (!$s) continue;
            $daftarTidakHadir[] = [
                'id_siswa'   => $s->id_siswa,
                'nama_siswa' => $s->nama_siswa,
                'nis'        => $s->nis ?? '-',
                'keterangan' => $ar->keterangan,
                'badge_class'=> $ar->keterangan === 'Sakit' ? 'warning' : ($ar->keterangan === 'Izin' ? 'success' : 'danger'),
                'sumber'     => 'Jurnal: ' . (optional(optional($ar->jurnal)->jadwal)->mapel->nama_mapel ?? 'Mapel KBM'),
                'guru'       => optional(optional($ar->jurnal)->jadwal)->guru->nama_guru ?? '-',
                'catatan'    => $ar->catatan ?? '-',
            ];
            $recordedSiswaIds[] = $s->id_siswa;
        }

        foreach ($suratIzins as $si) {
            $s = $si->siswa;
            if (!$s || in_array($s->id_siswa, $recordedSiswaIds)) continue;
            $daftarTidakHadir[] = [
                'id_siswa'   => $s->id_siswa,
                'nama_siswa' => $s->nama_siswa,
                'nis'        => $s->nis ?? '-',
                'keterangan' => $si->kategori,
                'badge_class'=> $si->kategori === 'Sakit' ? 'warning' : 'info',
                'sumber'     => 'Surat Izin / Sakit (' . $si->status . ')',
                'guru'       => 'Wali Murid / Petugas Piket',
                'catatan'    => $si->keterangan ?? '-',
            ];
            $recordedSiswaIds[] = $s->id_siswa;
        }

        foreach ($dispens as $dp) {
            $s = $dp->siswa;
            if (!$s || in_array($s->id_siswa, $recordedSiswaIds)) continue;
            $daftarTidakHadir[] = [
                'id_siswa'   => $s->id_siswa,
                'nama_siswa' => $s->nama_siswa,
                'nis'        => $s->nis ?? '-',
                'keterangan' => 'Dispensasi',
                'badge_class'=> 'primary',
                'sumber'     => 'Surat Dispen: ' . ($dp->alasan ?? 'Dispen Sekolah'),
                'guru'       => 'Waka / Petugas Piket',
                'catatan'    => 'Jam: ' . ($dp->jam_keluar ?? '-') . ' s/d ' . ($dp->jam_kembali ?? '-'),
            ];
        }

        // Format data Jurnal Mengajar pada tanggal tersebut
        $daftarJurnal = $jurnals->map(function($j) {
            return [
                'id_jurnal'    => $j->id_jurnal,
                'mapel'        => optional($j->jadwal)->mapel->nama_mapel ?? '-',
                'guru'         => optional($j->jadwal)->guru->nama_guru ?? '-',
                'jam'          => (optional(optional($j->jadwal)->jamMulai)->nama_jam ?? '') . ' - ' . (optional(optional($j->jadwal)->jamSelesai)->nama_jam ?? ''),
                'materi'       => $j->materi ?? $j->catatan ?? '-',
                'status_guru'  => $j->status_kehadiran_guru ?? 'Hadir',
                'status_badge' => ($j->status_kehadiran_guru ?? 'Hadir') === 'Hadir' ? 'success' : 'warning',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'tanggal'          => $tanggal,
                'tanggal_formatted'=> $dateCarbon->translatedFormat('l, d F Y'),
                'nama_kelas'       => $kelas->nama_kelas,
                'is_weekend'       => $isWeekend,
                'is_today'         => $isToday,
                'is_future'        => $isFuture,
                'total_siswa'      => $totalSiswa,
                'hadir'            => $hadirCount,
                'sakit'            => $sakitCount,
                'izin'             => $izinCount,
                'alpa'             => $alpaCount,
                'dispen'           => $dispenCount,
                'rate_persen'      => $ratePersen,
                'daftar_tidak_hadir' => $daftarTidakHadir,
                'daftar_jurnal'    => $daftarJurnal,
            ]
        ]);
    }

    /**
     * Update Permintaan Izin Guru Mengajar
     */
    public function updatePermintaanIzin(Request $request, $id)
    {
        $this->ensureGuruIzinColumnsExist();
        $izin = GuruIzin::findOrFail($id);

        if (!$izin->foto_surat && !$request->hasFile('foto_surat')) {
            return redirect()->back()->withErrors(['foto_surat' => 'Upload Foto Surat / Bukti Izin wajib diunggah.'])->withInput();
        }

        $request->validate([
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'nullable|date|after_or_equal:tanggal_mulai',
            'alasan'            => 'required|string',
            'materi_dititipkan' => 'nullable|string',
            'tugas_dititipkan'  => 'nullable|string',
            'foto_surat'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
            'keterangan_khusus' => 'nullable|string',
        ], [
            'tanggal_selesai.after_or_equal' => 'Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin.',
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

        $fileName = $izin->file_tugas;
        if ($request->hasFile('file_tugas')) {
            if ($fileName && file_exists(public_path('uploads/tugas_pengganti/' . $fileName))) {
                @unlink(public_path('uploads/tugas_pengganti/' . $fileName));
            }
            $fileTugas = $request->file('file_tugas');
            $fileName = time() . '_tugas_' . Str::random(8) . '.' . $fileTugas->getClientOriginalExtension();
            $fileTugas->move(public_path('uploads/tugas_pengganti'), $fileName);
        }

        $izin->update([
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
        ]);

        return redirect()->route('guru.permintaan-izin')
            ->with('success', 'Data permintaan izin Anda berhasil diperbarui!');
    }

    /**
     * Soft Delete (Pindahkan data izin ke Sampah)
     */
    public function destroyPermintaanIzin($id)
    {
        $izin = GuruIzin::findOrFail($id);
        $izin->delete();

        return redirect()->route('guru.permintaan-izin')
            ->with('success', 'Data pengajuan izin berhasil dipindahkan ke Sampah.');
    }

    /**
     * Batch Soft Delete
     */
    public function destroyBatchPermintaanIzin(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_filter(array_map('trim', (array) $ids));

        if (empty($ids)) {
            return redirect()->route('guru.permintaan-izin')
                ->with('error', 'Tidak ada data izin yang dipilih untuk dihapus.');
        }

        $user = Auth::user();
        $guru = null;
        if ($user && $user->id_guru) {
            $guru = Guru::find($user->id_guru);
        } elseif ($user && $user->nip) {
            $guru = Guru::where('nip', $user->nip)->first();
        }

        $query = GuruIzin::whereIn('id_guru_izin', $ids);
        if ($guru) {
            $query->where('id_guru', $guru->id_guru);
        }
        $count = $query->count();
        $query->delete();

        return redirect()->route('guru.permintaan-izin')
            ->with('success', "Sebanyak {$count} data pengajuan izin berhasil dipindahkan ke Sampah.");
    }

    /**
     * Halaman Sampah Data Permintaan Izin Saya
     */
    public function trashPermintaanIzin(Request $request)
    {
        $user = Auth::user();
        $guru = null;
        if ($user && $user->id_guru) {
            $guru = Guru::find($user->id_guru);
        } elseif ($user && $user->nip) {
            $guru = Guru::where('nip', $user->nip)->first();
        }

        $query = GuruIzin::onlyTrashed()->with('guru');
        if ($guru) {
            $query->where('id_guru', $guru->id_guru);
        }

        // Pencarian Keyword di Sampah
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function($q) use ($keyword) {
                $q->where('alasan', 'LIKE', "%{$keyword}%")
                  ->orWhere('materi_dititipkan', 'LIKE', "%{$keyword}%")
                  ->orWhere('keterangan_khusus', 'LIKE', "%{$keyword}%");
            });
        }

        // Filter Tanggal di Sampah
        if ($request->filled('tanggal')) {
            $tgl = $request->tanggal;
            $query->where(function($q) use ($tgl) {
                $q->whereDate('tanggal_mulai', '<=', $tgl)
                  ->whereDate('tanggal_selesai', '>=', $tgl);
            });
        }

        $guruIzinList = $query->orderBy('deleted_at', 'desc')->get();

        return view('guru.permintaan_izin_trash', compact('guruIzinList', 'guru'));
    }

    /**
     * Pulihkan data dari Sampah
     */
    public function restorePermintaanIzin($id)
    {
        $izin = GuruIzin::onlyTrashed()->findOrFail($id);
        $izin->restore();

        return redirect()->route('guru.permintaan-izin.trash')
            ->with('success', 'Data pengajuan izin berhasil dipulihkan.');
    }

    /**
     * Batch Pulihkan data dari Sampah
     */
    public function restoreBatchPermintaanIzin(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_filter(array_map('trim', (array) $ids));

        if (empty($ids)) {
            return redirect()->route('guru.permintaan-izin.trash')
                ->with('error', 'Tidak ada data izin yang dipilih untuk dipulihkan.');
        }

        $user = Auth::user();
        $guru = null;
        if ($user && $user->id_guru) {
            $guru = Guru::find($user->id_guru);
        } elseif ($user && $user->nip) {
            $guru = Guru::where('nip', $user->nip)->first();
        }

        $query = GuruIzin::onlyTrashed()->whereIn('id_guru_izin', $ids);
        if ($guru) {
            $query->where('id_guru', $guru->id_guru);
        }
        $count = $query->count();
        $query->restore();

        return redirect()->route('guru.permintaan-izin.trash')
            ->with('success', "Sebanyak {$count} data pengajuan izin berhasil dipulihkan.");
    }

    /**
     * Pulihkan Semua Data dari Sampah
     */
    public function restoreAllPermintaanIzin()
    {
        $user = Auth::user();
        $guru = null;
        if ($user && $user->id_guru) {
            $guru = Guru::find($user->id_guru);
        } elseif ($user && $user->nip) {
            $guru = Guru::where('nip', $user->nip)->first();
        }

        $query = GuruIzin::onlyTrashed();
        if ($guru) {
            $query->where('id_guru', $guru->id_guru);
        }
        $count = $query->count();
        $query->restore();

        return redirect()->route('guru.permintaan-izin.trash')
            ->with('success', "Seluruh ({$count}) data pengajuan izin berhasil dipulihkan.");
    }

    /**
     * Hapus permanen data izin
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

        return redirect()->route('guru.permintaan-izin.trash')
            ->with('success', 'Data pengajuan izin berhasil dihapus secara permanen.');
    }

    /**
     * Batch Hapus Permanen
     */
    public function forceDeleteBatchPermintaanIzin(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_filter(array_map('trim', (array) $ids));

        if (empty($ids)) {
            return redirect()->route('guru.permintaan-izin.trash')
                ->with('error', 'Tidak ada data izin yang dipilih untuk dihapus permanen.');
        }

        $user = Auth::user();
        $guru = null;
        if ($user && $user->id_guru) {
            $guru = Guru::find($user->id_guru);
        } elseif ($user && $user->nip) {
            $guru = Guru::where('nip', $user->nip)->first();
        }

        $query = GuruIzin::onlyTrashed()->whereIn('id_guru_izin', $ids);
        if ($guru) {
            $query->where('id_guru', $guru->id_guru);
        }

        $items = $query->get();
        $count = $items->count();
        foreach ($items as $item) {
            if ($item->foto_surat && file_exists(public_path('uploads/guru_izin/' . $item->foto_surat))) {
                @unlink(public_path('uploads/guru_izin/' . $item->foto_surat));
            }
            if ($item->file_tugas && file_exists(public_path('uploads/tugas_pengganti/' . $item->file_tugas))) {
                @unlink(public_path('uploads/tugas_pengganti/' . $item->file_tugas));
            }
            $item->forceDelete();
        }

        return redirect()->route('guru.permintaan-izin.trash')
            ->with('success', "Sebanyak {$count} data pengajuan izin berhasil dihapus secara permanen.");
    }

    /**
     * Kosongkan Sampah
     */
    public function emptyTrashPermintaanIzin()
    {
        $user = Auth::user();
        $guru = null;
        if ($user && $user->id_guru) {
            $guru = Guru::find($user->id_guru);
        } elseif ($user && $user->nip) {
            $guru = Guru::where('nip', $user->nip)->first();
        }

        $query = GuruIzin::onlyTrashed();
        if ($guru) {
            $query->where('id_guru', $guru->id_guru);
        }

        $trashedItems = $query->get();
        $count = $trashedItems->count();
        foreach ($trashedItems as $item) {
            if ($item->foto_surat && file_exists(public_path('uploads/guru_izin/' . $item->foto_surat))) {
                @unlink(public_path('uploads/guru_izin/' . $item->foto_surat));
            }
            if ($item->file_tugas && file_exists(public_path('uploads/tugas_pengganti/' . $item->file_tugas))) {
                @unlink(public_path('uploads/tugas_pengganti/' . $item->file_tugas));
            }
            $item->forceDelete();
        }

        return redirect()->route('guru.permintaan-izin.trash')
            ->with('success', "Sampah data permintaan izin ({$count} data) berhasil dikosongkan.");
    }

    /**
     * Halaman Beralih ke Guru Piket (Role Guru Mengajar)
     * Menampilkan data akun pengguna Guru Piket yang tersambung dari role TU
     */
    public function beralihKeGuruPiket(Request $request)
    {
        return redirect()->route('guru.dashboard');
    }

    /**
     * Parse string jam (format 08:00, 08.00, 08:00:00, 08:00 WIB) menjadi total menit dari jam 00:00
     */
    public static function parseTimeToMinutes($timeStr)
    {
        if (empty($timeStr)) return null;
        $clean = trim($timeStr);
        $clean = str_replace('.', ':', $clean);
        $clean = preg_replace('/\s*(wib|wita|wit)\s*/i', '', $clean);
        $clean = trim($clean);

        $timestamp = strtotime($clean);
        if ($timestamp === false) {
            if (preg_match('/^(\d{1,2}):(\d{2})/', $clean, $m)) {
                return ((int)$m[1]) * 60 + ((int)$m[2]);
            }
            return null;
        }
        return ((int)date('H', $timestamp)) * 60 + ((int)date('i', $timestamp));
    }

    /**
     * Dapatkan rentang jam mulai & jam selesai jadwal pelajaran dalam satuan menit dari tengah malam
     */
    public static function getJadwalMinutes($jadwal, $hari)
    {
        $isJumat = (strcasecmp(trim($hari), 'Jumat') === 0);
        $mObj = $jadwal->jamMulai;
        $sObj = $jadwal->jamSelesai ?: $mObj;
        $mStr = $mObj ? ($isJumat ? ($mObj->jam_mulai_jumat ?: $mObj->jam_mulai) : $mObj->jam_mulai) : null;
        $sStr = $sObj ? ($isJumat ? ($sObj->jam_selesai_jumat ?: $sObj->jam_selesai) : $sObj->jam_selesai) : null;

        if (empty($sStr) && !$isJumat && ($jadwal->id_jam_selesai >= 10 || ($sObj && $sObj->jam_ke >= 10))) {
            $sStr = '15:00:00';
        }

        return [self::parseTimeToMinutes($mStr), self::parseTimeToMinutes($sStr)];
    }

    /**
     * Ambil daftar jadwal guru yang bersinggungan langsung dengan tanggal, hari, kelas, dan jam dispensasi siswa
     */
    public static function getOverlappingJadwalsForDispen($dispen, $guruId, $jadwalsGuru = null)
    {
        if (!$guruId) {
            return collect();
        }

        if ($jadwalsGuru === null) {
            $jadwalsGuru = Jadwal::with(['kelas', 'mapel', 'jamMulai', 'jamSelesai'])
                ->where('id_guru', $guruId)
                ->get();
        }

        $daysMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        $hariDispen = $daysMap[Carbon::parse($dispen->tanggal)->format('l')] ?? null;
        if (!$hariDispen) {
            return collect();
        }

        $dStart = self::parseTimeToMinutes($dispen->jam_keluar);
        $dEnd   = self::parseTimeToMinutes($dispen->jam_kembali);

        // Fallback rentang jam dispen
        if ($dStart === null) $dStart = 7 * 60; // 07:00
        if ($dEnd === null)   $dEnd   = 16 * 60; // 16:00
        if ($dEnd <= $dStart) $dEnd   = $dStart + 60; // minimal rentang 1 jam

        return $jadwalsGuru->filter(function($j) use ($dispen, $hariDispen, $dStart, $dEnd) {
            // 1. Harus kelas yang sama dengan siswa dispen
            if ($j->id_kelas != $dispen->id_kelas) {
                return false;
            }

            // 2. Harus hari yang sama
            if (strcasecmp(trim($j->hari), trim($hariDispen)) !== 0) {
                return false;
            }

            // 3. Rentang jam pelajaran harus bersinggungan dengan rentang jam dispen
            list($jStart, $jEnd) = self::getJadwalMinutes($j, $hariDispen);
            if ($jStart === null || $jEnd === null) {
                return false;
            }

            return (max($dStart, $jStart) < min($dEnd, $jEnd));
        });
    }

    /**
     * Cek apakah guru mengajar di kelas siswa dispen pada jam yang bersinggungan
     */
    public static function isDispenTeachingOverlap($dispen, $guruId, $jadwalsGuru = null)
    {
        return self::getOverlappingJadwalsForDispen($dispen, $guruId, $jadwalsGuru)->isNotEmpty();
    }

    /**
     * Helper: Cek apakah surat dispen relevan untuk guru (Wali Kelas ATAU Guru Mengajar yang jam & harinya terdampak langsung)
     */
    public static function isDispenRelevantForGuru($dispen, $guruId, $kelasWaliId, $jadwalsGuru = null)
    {
        // 1. Jika guru adalah Wali Kelas dari siswa tersebut
        if ($kelasWaliId && $dispen->id_kelas == $kelasWaliId) {
            return true;
        }

        // 2. Jika guru mengajar di kelas siswa tersebut pada hari & jam yang bersinggungan
        if ($guruId && self::isDispenTeachingOverlap($dispen, $guruId, $jadwalsGuru)) {
            return true;
        }

        return false;
    }

    /**
     * Halaman Surat Dispen Siswa (Role Guru Mengajar & Wali Kelas)
     * Menampilkan surat dispensasi resmi siswa (dengan tanda tangan siswa, guru piket, dan persetujuan Waka Kesiswaan)
     * Otomatis terkirim setelah disetujui Waka Kesiswaan sesuai wali kelas dan guru yang mengajar di kelas tersebut
     */
    public function suratDispen(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
        $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);

        // 1. Identifikasi Kelas Perwalian (Wali Kelas)
        $kelasWali = null;
        $nips = array_filter([$user->nip, optional($guru)->nip]);
        if (!empty($nips)) {
            $kelasWali = Kelas::whereIn('wali_kelas', $nips)->first();
        }
        $isWaliKelas = !is_null($kelasWali);
        $kelasWaliId = $kelasWali ? $kelasWali->id_kelas : null;

        // 2. Identifikasi Jadwal Mengajar (Guru Mengajar)
        $jadwalsGuru = Jadwal::with(['kelas', 'mapel', 'jamMulai', 'jamSelesai'])
            ->when($guruId, fn($q) => $q->where('id_guru', $guruId))
            ->get();
        $kelasMengajarIds = $jadwalsGuru->pluck('id_kelas')->unique()->filter()->values()->toArray();

        // Gabungan kelas kandidat (Wali Kelas + Semua Kelas yang Diajar)
        $accessibleKelasIds = array_unique(array_filter(array_merge([$kelasWaliId], $kelasMengajarIds)));

        // 3. Query Surat Dispen yang telah DISETUJUI oleh Waka Kesiswaan
        $query = SiswaDispen::with(['siswa.kelas.jurusan', 'kelas.jurusan', 'wakaUser', 'guruPiketUser'])
            ->where('status_waka', 'approved');

        // Batasi akses di tingkat DB hanya untuk kelas yang diajar atau kelas perwalian (kecuali Admin/Waka)
        if (!$user->isAdmin() && !$user->isWaka()) {
            if (empty($accessibleKelasIds)) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('id_kelas', $accessibleKelasIds);
            }
        }

        // Filter Pencarian
        $search = $request->input('q');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kode_dispen', 'like', "%{$search}%")
                  ->orWhere('alasan', 'like', "%{$search}%")
                  ->orWhereHas('siswa', function($s) use ($search) {
                      $s->where('nama_siswa', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                  })
                  ->orWhereHas('kelas', function($k) use ($search) {
                      $k->where('nama_kelas', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Tanggal
        $tanggalFilter = $request->input('tanggal');
        if ($tanggalFilter) {
            $query->whereDate('tanggal', $tanggalFilter);
        }

        // Filter Kelas Spesifik
        $kelasFilter = $request->input('id_kelas');
        if ($kelasFilter) {
            $query->where('id_kelas', $kelasFilter);
        }

        $allDispen = $query->orderBy('tanggal', 'desc')->orderBy('id_siswa_dispen', 'desc')->get();

        // Hari dalam Bahasa Indonesia
        $daysMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        $todayDate = Carbon::now('Asia/Jakarta')->toDateString();

        // Ambil ID yang sudah dibaca user
        $readIds = SiswaDispenDibaca::where('user_id', $user->id)->pluck('id_siswa_dispen')->toArray();

        // 4. Analisis & Tautkan dengan Jadwal Pelajaran / Jam Pelajaran Guru Mengajar yang Bersinggungan
        $mappedDispen = $allDispen->map(function($item) use ($daysMap, $jadwalsGuru, $kelasWaliId, $guruId, $readIds) {
            $carbonDate = Carbon::parse($item->tanggal);
            $dayEnglish = $carbonDate->format('l');
            $hariNama = $daysMap[$dayEnglish] ?? 'Senin';

            $item->hari_indo = $hariNama;
            $item->is_wali_kelas = ($kelasWaliId && $item->id_kelas == $kelasWaliId);

            // Cek jadwal mengajar guru di kelas ini yang jam pelajarannya BERSINGGUNGAN dengan jam dispen siswa
            $overlappingJadwal = self::getOverlappingJadwalsForDispen($item, $guruId, $jadwalsGuru);
            $item->jadwal_terdampak = $overlappingJadwal;
            $item->is_guru_mengajar = $overlappingJadwal->isNotEmpty();
            $item->is_unread = !in_array($item->id_siswa_dispen, $readIds);

            return $item;
        });

        // Batasi dispen yang dapat dilihat:
        // Admin / Waka dapat melihat semua dispen yang lolos query.
        // Guru biasa HANYA dapat melihat jika:
        // (a) Menjadi Wali Kelas siswa tersebut, ATAU
        // (b) Menjadi Guru yang mengajar di kelas siswa tersebut pada jam pelajaran yang BERSINGGUNGAN dengan jam dispen.
        $accessibleDispen = $mappedDispen->filter(function($item) use ($user) {
            if ($user->isAdmin() || $user->isWaka()) {
                return true;
            }
            return $item->is_wali_kelas || $item->is_guru_mengajar;
        });

        // 5. Hitung Statistik Ringkasan (Berdasarkan surat yang sah diakses pengguna)
        $totalSuratDispen = $accessibleDispen->count();
        $dispenHariIni    = $accessibleDispen->filter(fn($d) => $d->tanggal == $todayDate)->count();
        $dispenMengajar   = $accessibleDispen->filter(fn($d) => $d->is_guru_mengajar)->count();
        $dispenWali       = $accessibleDispen->filter(fn($d) => $d->is_wali_kelas)->count();
        $unreadCount      = $accessibleDispen->filter(fn($d) => $d->is_unread)->count();

        $stats = [
            'total'    => $totalSuratDispen,
            'hariIni'  => $dispenHariIni,
            'mengajar' => $dispenMengajar,
            'wali'     => $dispenWali,
            'unread'   => $unreadCount,
        ];

        // 6. Filter Berdasarkan Tab yang Aktif
        $tab = $request->input('tab', 'semua');
        if ($tab === 'mengajar') {
            // Hanya surat dispen di mana guru sedang mengajar pada jam dispen
            $dispenList = $accessibleDispen->filter(fn($d) => $d->is_guru_mengajar);
        } elseif ($tab === 'wali') {
            // Hanya surat dispen untuk kelas perwalian guru sebagai wali kelas
            $dispenList = $accessibleDispen->filter(fn($d) => $d->is_wali_kelas);
        } else {
            // Tab 'semua': seluruh surat dispen yang relevan bagi guru (wali kelas atau guru mengajar)
            $dispenList = $accessibleDispen;
        }

        // Daftar kelas untuk opsi filter
        $filterKelasIds = $accessibleDispen->pluck('id_kelas')->unique()->filter()->values()->toArray();
        if (empty($filterKelasIds)) {
            $filterKelasIds = $accessibleKelasIds;
        }
        $filterKelases = Kelas::whereIn('id_kelas', $filterKelasIds)->orderBy('nama_kelas')->get();

        // Hitung jumlah data di Tempat Sampah
        $trashedCountQuery = SiswaDispen::onlyTrashed()->where('status_waka', 'approved');
        if (!$user->isAdmin() && !$user->isWaka()) {
            if (empty($accessibleKelasIds)) {
                $trashedCountQuery->whereRaw('1 = 0');
            } else {
                $trashedCountQuery->whereIn('id_kelas', $accessibleKelasIds);
            }
        }
        $trashedCount = $trashedCountQuery->count();

        return view('guru.surat_dispen', compact(
            'dispenList',
            'stats',
            'isWaliKelas',
            'kelasWali',
            'tab',
            'search',
            'tanggalFilter',
            'kelasFilter',
            'filterKelases',
            'unreadCount',
            'trashedCount'
        ));
    }

    /**
     * Soft delete Surat Dispen Siswa (Pindahkan ke Sampah)
     */
    public function destroySuratDispen($id)
    {
        $dispen = SiswaDispen::findOrFail($id);
        $namaSiswa = $dispen->siswa->nama_siswa ?? 'Siswa';
        $dispen->delete();

        if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'guru-kehadiran-kelas')) {
            return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_dispen'])
                ->with('success', "Surat dispensasi siswa \"{$namaSiswa}\" berhasil dipindahkan ke Sampah.");
        }

        return redirect()->route('guru.surat-dispen')
            ->with('success', "Surat dispensasi siswa \"{$namaSiswa}\" berhasil dipindahkan ke Tempat Sampah.");
    }

    /**
     * Bulk Soft delete Surat Dispen Siswa (Pindahkan data terpilih ke Sampah)
     */
    public function destroyBatchSuratDispen(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        $ids = array_filter(array_map('intval', (array)$ids));

        if (!empty($ids)) {
            $count = SiswaDispen::whereIn('id_siswa_dispen', $ids)->delete();
            if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'guru-kehadiran-kelas')) {
                return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_dispen'])
                    ->with('success', "{$count} data surat dispensasi siswa berhasil dipindahkan ke Sampah.");
            }
            return redirect()->route('guru.surat-dispen')
                ->with('success', "{$count} surat dispensasi siswa berhasil dipindahkan ke Tempat Sampah.");
        }

        if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'guru-kehadiran-kelas')) {
            return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_dispen'])
                ->with('error', 'Tidak ada surat dispensasi yang dipilih untuk dihapus.');
        }

        return redirect()->route('guru.surat-dispen')
            ->with('error', 'Tidak ada surat dispensasi yang dipilih untuk dihapus.');
    }

    /**
     * Halaman Tempat Sampah Surat Dispen Siswa
     */
    public function trashSuratDispen(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
        $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);

        // Identifikasi Kelas Perwalian & Mengajar
        $kelasWali = null;
        $nips = array_filter([$user->nip, optional($guru)->nip]);
        if (!empty($nips)) {
            $kelasWali = Kelas::whereIn('wali_kelas', $nips)->first();
        }
        $isWaliKelas = !is_null($kelasWali);
        $kelasWaliId = $kelasWali ? $kelasWali->id_kelas : null;

        $jadwalsGuru = Jadwal::with(['kelas', 'mapel', 'jamMulai', 'jamSelesai'])
            ->when($guruId, fn($q) => $q->where('id_guru', $guruId))
            ->get();
        $kelasMengajarIds = $jadwalsGuru->pluck('id_kelas')->unique()->filter()->values()->toArray();
        $accessibleKelasIds = array_unique(array_filter(array_merge([$kelasWaliId], $kelasMengajarIds)));

        $query = SiswaDispen::onlyTrashed()
            ->with(['siswa.kelas.jurusan', 'kelas.jurusan', 'wakaUser', 'guruPiketUser'])
            ->where('status_waka', 'approved');

        if (!$user->isAdmin() && !$user->isWaka()) {
            if (empty($accessibleKelasIds)) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('id_kelas', $accessibleKelasIds);
            }
        }

        $search = $request->input('q');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kode_dispen', 'like', "%{$search}%")
                  ->orWhere('alasan', 'like', "%{$search}%")
                  ->orWhereHas('siswa', function($s) use ($search) {
                      $s->where('nama_siswa', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                  })
                  ->orWhereHas('kelas', function($k) use ($search) {
                      $k->where('nama_kelas', 'like', "%{$search}%");
                  });
            });
        }

        $trashedDispen = $query->orderBy('deleted_at', 'desc')->get();

        return view('guru.surat_dispen_trash', compact('trashedDispen', 'search'));
    }

    /**
     * Pulihkan Surat Dispen dari Sampah
     */
    public function restoreSuratDispen($id)
    {
        $dispen = SiswaDispen::onlyTrashed()->findOrFail($id);
        $namaSiswa = $dispen->siswa->nama_siswa ?? 'Siswa';
        $dispen->restore();

        if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'guru-kehadiran-kelas')) {
            return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_dispen'])
                ->with('success', "Surat dispensasi siswa \"{$namaSiswa}\" berhasil dipulihkan dari Sampah.");
        }

        return redirect()->route('guru.surat-dispen.trash')
            ->with('success', 'Surat dispensasi siswa berhasil dipulihkan.');
    }

    /**
     * Bulk Restore Surat Dispen dari Sampah
     */
    public function batchRestoreSuratDispen(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        $ids = array_filter(array_map('intval', (array)$ids));

        if (!empty($ids)) {
            $count = SiswaDispen::onlyTrashed()->whereIn('id_siswa_dispen', $ids)->restore();
            if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'guru-kehadiran-kelas')) {
                return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_dispen'])
                    ->with('success', "{$count} data surat dispensasi siswa berhasil dipulihkan dari Sampah.");
            }
            return redirect()->route('guru.surat-dispen.trash')
                ->with('success', "{$count} surat dispensasi siswa berhasil dipulihkan.");
        }

        if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'guru-kehadiran-kelas')) {
            return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_dispen'])
                ->with('error', 'Tidak ada data yang dipilih untuk dipulihkan.');
        }

        return redirect()->route('guru.surat-dispen.trash')
            ->with('error', 'Tidak ada data yang dipilih untuk dipulihkan.');
    }

    public function restoreBatchSuratDispen(Request $request)
    {
        return $this->batchRestoreSuratDispen($request);
    }

    /**
     * Pulihkan Semua Surat Dispen dari Sampah
     */
    public function restoreAllSuratDispen(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
        $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);

        $idKelasParam = $request->input('id_kelas');
        $kelasWaliId = $idKelasParam ?? Kelas::whereIn('wali_kelas', array_filter([$user->nip, optional($guru)->nip]))->value('id_kelas');
        $jadwalsGuru = Jadwal::where('id_guru', $guruId)->get();
        $kelasMengajarIds = $jadwalsGuru->pluck('id_kelas')->unique()->filter()->toArray();
        $accessibleKelasIds = array_unique(array_filter(array_merge([$kelasWaliId], $kelasMengajarIds)));

        $query = SiswaDispen::onlyTrashed();
        if ($idKelasParam) {
            $query->where('id_kelas', $idKelasParam);
        } else {
            $query->where('status_waka', 'approved');
            if (!$user->isAdmin() && !$user->isWaka()) {
                if (!empty($accessibleKelasIds)) {
                    $query->whereIn('id_kelas', $accessibleKelasIds);
                } else {
                    $query->whereRaw('1 = 0');
                }
            }
        }

        $count = $query->restore();

        if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'guru-kehadiran-kelas')) {
            return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_dispen'])
                ->with('success', "Seluruh data sampah surat dispensasi ({$count} data) berhasil dipulihkan.");
        }

        return redirect()->route('guru.surat-dispen.trash')
            ->with('success', "Semua surat dispensasi ({$count} data) berhasil dipulihkan.");
    }

    /**
     * Hapus Permanen Surat Dispen dari Sampah
     */
    public function forceDeleteSuratDispen($id)
    {
        $dispen = SiswaDispen::onlyTrashed()->findOrFail($id);
        
        if ($dispen->foto_surat_dispen && file_exists(public_path($dispen->foto_surat_dispen))) {
            @unlink(public_path($dispen->foto_surat_dispen));
        }
        if ($dispen->foto_kartu_identitas && file_exists(public_path($dispen->foto_kartu_identitas))) {
            @unlink(public_path($dispen->foto_kartu_identitas));
        }
        if ($dispen->foto_siswa_live && file_exists(public_path($dispen->foto_siswa_live))) {
            @unlink(public_path($dispen->foto_siswa_live));
        }

        $dispen->forceDelete();

        if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'guru-kehadiran-kelas')) {
            return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_dispen'])
                ->with('success', 'Surat Dispensasi Siswa berhasil dihapus secara permanen dari sistem.');
        }

        return redirect()->route('guru.surat-dispen.trash')
            ->with('success', 'Surat dispensasi siswa berhasil dihapus secara permanen.');
    }

    /**
     * Bulk Force Delete Surat Dispen
     */
    public function forceDeleteBatchSuratDispen(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        $ids = array_filter(array_map('intval', (array)$ids));

        if (!empty($ids)) {
            $dispens = SiswaDispen::onlyTrashed()->whereIn('id_siswa_dispen', $ids)->get();
            $count = 0;
            foreach ($dispens as $d) {
                if ($d->foto_surat_dispen && file_exists(public_path($d->foto_surat_dispen))) {
                    @unlink(public_path($d->foto_surat_dispen));
                }
                if ($d->foto_kartu_identitas && file_exists(public_path($d->foto_kartu_identitas))) {
                    @unlink(public_path($d->foto_kartu_identitas));
                }
                if ($d->foto_siswa_live && file_exists(public_path($d->foto_siswa_live))) {
                    @unlink(public_path($d->foto_siswa_live));
                }
                $d->forceDelete();
                $count++;
            }

            if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'guru-kehadiran-kelas')) {
                return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_dispen'])
                    ->with('success', "{$count} data surat dispensasi berhasil dihapus secara permanen.");
            }

            return redirect()->route('guru.surat-dispen.trash')
                ->with('success', "{$count} surat dispensasi siswa berhasil dihapus secara permanen.");
        }

        if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'guru-kehadiran-kelas')) {
            return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_dispen'])
                ->with('error', 'Tidak ada data yang dipilih untuk dihapus permanen.');
        }

        return redirect()->route('guru.surat-dispen.trash')
            ->with('error', 'Tidak ada data yang dipilih untuk dihapus permanen.');
    }

    /**
     * Kosongkan Seluruh Tempat Sampah Surat Dispen
     */
    public function emptyTrashSuratDispen(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
        $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);

        $idKelasParam = $request->input('id_kelas');
        $kelasWaliId = $idKelasParam ?? Kelas::whereIn('wali_kelas', array_filter([$user->nip, optional($guru)->nip]))->value('id_kelas');
        $jadwalsGuru = Jadwal::where('id_guru', $guruId)->get();
        $kelasMengajarIds = $jadwalsGuru->pluck('id_kelas')->unique()->filter()->toArray();
        $accessibleKelasIds = array_unique(array_filter(array_merge([$kelasWaliId], $kelasMengajarIds)));

        $query = SiswaDispen::onlyTrashed();
        if ($idKelasParam) {
            $query->where('id_kelas', $idKelasParam);
        } else {
            $query->where('status_waka', 'approved');
            if (!$user->isAdmin() && !$user->isWaka()) {
                if (!empty($accessibleKelasIds)) {
                    $query->whereIn('id_kelas', $accessibleKelasIds);
                } else {
                    $query->whereRaw('1 = 0');
                }
            }
        }

        $dispens = $query->get();
        $count = 0;
        foreach ($dispens as $d) {
            if ($d->foto_surat_dispen && file_exists(public_path($d->foto_surat_dispen))) {
                @unlink(public_path($d->foto_surat_dispen));
            }
            if ($d->foto_kartu_identitas && file_exists(public_path($d->foto_kartu_identitas))) {
                @unlink(public_path($d->foto_kartu_identitas));
            }
            if ($d->foto_siswa_live && file_exists(public_path($d->foto_siswa_live))) {
                @unlink(public_path($d->foto_siswa_live));
            }
            $d->forceDelete();
            $count++;
        }

        if (request()->headers->get('referer') && str_contains(request()->headers->get('referer'), 'guru-kehadiran-kelas')) {
            return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_dispen'])
                ->with('success', "Sampah surat dispensasi ({$count} data) telah berhasil dikosongkan secara permanen.");
        }

        return redirect()->route('guru.surat-dispen.trash')
            ->with('success', "Tempat sampah berhasil dikosongkan ({$count} data dihapus permanen).");
    }

    /**
     * Tandai Surat Dispen Sudah Dibaca
     */
    public function markSuratDispenRead(Request $request, $id)
    {
        $user = Auth::user();
        if ($user) {
            SiswaDispenDibaca::firstOrCreate([
                'user_id' => $user->id,
                'id_siswa_dispen' => $id,
            ]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }

    /**
     * Tandai Semua Surat Dispen Sudah Dibaca
     */
    public function markAllSuratDispenRead(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
            $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);

            $kelasWaliId = Kelas::whereIn('wali_kelas', array_filter([$user->nip, optional($guru)->nip]))->value('id_kelas');
            $jadwalsGuru = Jadwal::with(['jamMulai', 'jamSelesai'])->where('id_guru', $guruId)->get();
            $kelasMengajarIds = $jadwalsGuru->pluck('id_kelas')->unique()->filter()->toArray();
            $allKIds = array_unique(array_filter(array_merge([$kelasWaliId], $kelasMengajarIds)));

            $query = SiswaDispen::where('status_waka', 'approved');
            if (!$user->isAdmin() && !$user->isWaka()) {
                if (!empty($allKIds)) {
                    $query->whereIn('id_kelas', $allKIds);
                } else {
                    $query->whereRaw('1 = 0');
                }
            }

            $candidateDispen = $query->get();
            foreach ($candidateDispen as $d) {
                if ($user->isAdmin() || $user->isWaka() || self::isDispenRelevantForGuru($d, $guruId, $kelasWaliId, $jadwalsGuru)) {
                    SiswaDispenDibaca::firstOrCreate([
                        'user_id' => $user->id,
                        'id_siswa_dispen' => $d->id_siswa_dispen,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Semua surat dispensasi siswa telah ditandai sebagai sudah dibaca.');
    }

    /**
     * Cetak Lembar Surat Dispensasi Resmi Siswa (Format Printable)
     */
    public function cetakSuratDispen($id)
    {
        $dispen = SiswaDispen::with(['siswa.kelas.jurusan', 'kelas.jurusan', 'wakaUser', 'guruPiketUser'])->findOrFail($id);

        $user = Auth::user();
        if ($user && !$user->isAdmin() && !$user->isWaka()) {
            $guru = Guru::where('nip', $user->nip)->first() ?? ($user->id_guru ? Guru::find($user->id_guru) : null);
            $guruId = $guru ? $guru->id_guru : ($user->id_guru ?? null);
            $kelasWaliId = Kelas::whereIn('wali_kelas', array_filter([$user->nip, optional($guru)->nip]))->value('id_kelas');
            if (!self::isDispenRelevantForGuru($dispen, $guruId, $kelasWaliId)) {
                abort(403, 'Anda tidak memiliki wewenang untuk melihat atau mencetak surat dispensasi ini.');
            }
        }

        $daysMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        $carbonDate = Carbon::parse($dispen->tanggal);
        $hariIndo = $daysMap[$carbonDate->format('l')] ?? 'Senin';
        $tanggalIndo = $carbonDate->translatedFormat('d F Y');

        return view('guru.surat_dispen_cetak', compact('dispen', 'hariIndo', 'tanggalIndo'));
    }

    /**
     * [SOFT DELETE] Hapus Surat Izin Siswa Kelas Perwalian (Wali Kelas)
     */
    public function destroySuratIzinWali($id)
    {
        $surat = SiswaSuratIzin::findOrFail($id);
        $surat->delete();

        return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_izin'])
            ->with('success', 'Surat Izin Siswa berhasil dipindahkan ke Sampah.');
    }

    /**
     * [BULK SOFT DELETE] Hapus Massal Surat Izin Siswa Kelas Perwalian (Wali Kelas)
     */
    public function destroyBatchSuratIzinWali(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids) || count($ids) === 0) {
            return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_izin'])
                ->with('error', 'Pilih setidaknya satu data surat izin siswa yang ingin dihapus.');
        }

        $count = SiswaSuratIzin::whereIn('id_surat_izin', $ids)->delete();

        return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_izin'])
            ->with('success', "{$count} data surat izin siswa berhasil dipindahkan ke Sampah.");
    }

    /**
     * [RESTORE] Pulihkan Surat Izin Siswa dari Sampah (Wali Kelas)
     */
    public function restoreSuratIzinWali($id)
    {
        $surat = SiswaSuratIzin::onlyTrashed()->findOrFail($id);
        $surat->restore();

        return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_izin'])
            ->with('success', 'Surat Izin Siswa berhasil dipulihkan dari Sampah.');
    }

    /**
     * [RESTORE BATCH] Pulihkan Massal Surat Izin Siswa dari Sampah (Wali Kelas)
     */
    public function restoreBatchSuratIzinWali(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids) || count($ids) === 0) {
            return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_izin'])
                ->with('error', 'Pilih setidaknya satu data surat izin siswa untuk dipulihkan.');
        }

        $count = SiswaSuratIzin::onlyTrashed()->whereIn('id_surat_izin', $ids)->restore();

        return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_izin'])
            ->with('success', "{$count} data surat izin siswa berhasil dipulihkan dari Sampah.");
    }

    /**
     * [RESTORE ALL] Pulihkan Semua Surat Izin Siswa dari Sampah (Wali Kelas)
     */
    public function restoreAllSuratIzinWali(Request $request)
    {
        $idKelas = $request->input('id_kelas');
        $query = SiswaSuratIzin::onlyTrashed();
        if ($idKelas) {
            $query->where('id_kelas', $idKelas);
        }
        $count = $query->restore();

        return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_izin'])
            ->with('success', "Seluruh data sampah surat izin siswa ({$count} data) berhasil dipulihkan.");
    }

    /**
     * [FORCE DELETE] Hapus Permanen Surat Izin Siswa (Wali Kelas)
     */
    public function forceDeleteSuratIzinWali($id)
    {
        $surat = SiswaSuratIzin::onlyTrashed()->findOrFail($id);
        if ($surat->foto_bukti && file_exists(public_path('uploads/surat_izin_siswa/' . $surat->foto_bukti))) {
            @unlink(public_path('uploads/surat_izin_siswa/' . $surat->foto_bukti));
        }
        $surat->forceDelete();

        return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_izin'])
            ->with('success', 'Surat Izin Siswa berhasil dihapus secara permanen dari sistem.');
    }

    /**
     * [FORCE DELETE BATCH] Hapus Permanen Massal Surat Izin Siswa (Wali Kelas)
     */
    public function forceDeleteBatchSuratIzinWali(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids) || count($ids) === 0) {
            return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_izin'])
                ->with('error', 'Pilih setidaknya satu data surat izin siswa untuk dihapus permanen.');
        }

        $trashed = SiswaSuratIzin::onlyTrashed()->whereIn('id_surat_izin', $ids)->get();
        $count = 0;
        foreach ($trashed as $s) {
            if ($s->foto_bukti && file_exists(public_path('uploads/surat_izin_siswa/' . $s->foto_bukti))) {
                @unlink(public_path('uploads/surat_izin_siswa/' . $s->foto_bukti));
            }
            $s->forceDelete();
            $count++;
        }

        return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_izin'])
            ->with('success', "{$count} data surat izin siswa berhasil dihapus secara permanen.");
    }

    /**
     * [EMPTY TRASH] Kosongkan Seluruh Sampah Surat Izin Siswa (Wali Kelas)
     */
    public function emptyTrashSuratIzinWali(Request $request)
    {
        $idKelas = $request->input('id_kelas');
        $query = SiswaSuratIzin::onlyTrashed();
        if ($idKelas) {
            $query->where('id_kelas', $idKelas);
        }
        $trashed = $query->get();
        $count = 0;
        foreach ($trashed as $s) {
            if ($s->foto_bukti && file_exists(public_path('uploads/surat_izin_siswa/' . $s->foto_bukti))) {
                @unlink(public_path('uploads/surat_izin_siswa/' . $s->foto_bukti));
            }
            $s->forceDelete();
            $count++;
        }

        return redirect()->route('guru.kehadiran-kelas', ['tab' => 'surat_izin'])
            ->with('success', "Sampah surat izin siswa ({$count} data) telah berhasil dikosongkan secara permanen.");
    }

    /**
     * [API DETAIL JSON] Detail Lengkap Surat Izin Siswa untuk Modal View
     */
    public function detailSuratIzinWaliJson($id)
    {
        $surat = SiswaSuratIzin::withTrashed()->with(['siswa.kelas', 'petugasPiket'])->find($id);
        if (!$surat) {
            return response()->json(['success' => false, 'message' => 'Data surat izin tidak ditemukan.'], 404);
        }

        $s = $surat->siswa;
        return response()->json([
            'success' => true,
            'data' => [
                'id_surat_izin'     => $surat->id_surat_izin,
                'nama_siswa'        => $s->nama_siswa ?? 'Siswa',
                'nis'               => $s->nis ?? '-',
                'nisn'              => $s->nisn ?? '-',
                'nama_kelas'        => $surat->kelas->nama_kelas ?? ($s->kelas->nama_kelas ?? '-'),
                'kategori'          => $surat->kategori,
                'tanggal_mulai'     => \Carbon\Carbon::parse($surat->tanggal)->translatedFormat('d F Y'),
                'tanggal_selesai'   => $surat->tanggal_selesai ? \Carbon\Carbon::parse($surat->tanggal_selesai)->translatedFormat('d F Y') : \Carbon\Carbon::parse($surat->tanggal)->translatedFormat('d F Y'),
                'rentang_tanggal'   => $surat->rentang_tanggal_text,
                'durasi_hari'       => $surat->durasi_text,
                'keterangan'        => $surat->keterangan ?? '-',
                'foto_url'          => $surat->foto_url,
                'has_foto'          => !empty($surat->foto_url),
                'petugas'           => $surat->petugasPiket->name ?? 'Guru Piket / TU',
                'status'            => $surat->status ?? 'Terverifikasi',
                'status_class'      => $surat->status_badge_class,
                'diajukan_pada'     => $surat->created_at ? $surat->created_at->translatedFormat('d F Y • H:i') : '-',
                'is_trashed'        => $surat->trashed(),
            ]
        ]);
    }

    /**
     * [API DETAIL JSON] Detail Lengkap Surat Dispensasi untuk Modal View Wali Kelas
     */
    public function detailSuratDispenWaliJson($id)
    {
        $dispen = SiswaDispen::withTrashed()->with(['siswa.kelas', 'kelas', 'guruPiketUser', 'wakaUser'])->find($id);
        if (!$dispen) {
            return response()->json(['success' => false, 'message' => 'Data dispensasi tidak ditemukan.'], 404);
        }

        $s = $dispen->siswa;
        $namaSiswa = $s->nama_siswa ?? 'Siswa';
        $nis = $s->nis ?? ($s->nisn ?? '-');
        $namaKelas = $dispen->kelas->nama_kelas ?? ($s->kelas->nama_kelas ?? '-');

        // Status Waka Label & Badge
        $statusWakaLabel = 'Menunggu Persetujuan';
        $statusWakaClass = 'status-pill warning';
        if ($dispen->status_waka === 'approved') {
            $statusWakaLabel = 'Disetujui Waka Kesiswaan';
            $statusWakaClass = 'status-pill success';
        } elseif ($dispen->status_waka === 'rejected') {
            $statusWakaLabel = 'Ditolak Waka Kesiswaan';
            $statusWakaClass = 'status-pill danger';
        }

        // Status Satpam Label & Badge
        $statusSatpamLabel = 'Belum Keluar Gerbang';
        $statusSatpamClass = 'status-pill';
        if ($dispen->status_satpam === 'sudah_keluar') {
            $statusSatpamLabel = 'Sudah Keluar Gerbang';
            $statusSatpamClass = 'status-pill warning';
        } elseif ($dispen->status_satpam === 'sudah_kembali') {
            $statusSatpamLabel = 'Sudah Kembali ke Sekolah';
            $statusSatpamClass = 'status-pill success';
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id_siswa_dispen'     => $dispen->id_siswa_dispen,
                'kode_dispen'         => $dispen->kode_dispen ?? ('DSP-' . str_pad($dispen->id_siswa_dispen, 5, '0', STR_PAD_LEFT)),
                'nama_siswa'          => $namaSiswa,
                'nis'                 => $nis,
                'nama_kelas'          => $namaKelas,
                'tanggal'             => $dispen->tanggal ? \Carbon\Carbon::parse($dispen->tanggal)->translatedFormat('d F Y') : '-',
                'jam_keluar'          => $dispen->jam_keluar ? substr($dispen->jam_keluar, 0, 5) . ' WIB' : '-',
                'jam_kembali'         => $dispen->jam_kembali ? substr($dispen->jam_kembali, 0, 5) . ' WIB' : '-',
                'rentang_jam'         => ($dispen->jam_keluar ? substr($dispen->jam_keluar, 0, 5) : '07:00') . ' - ' . ($dispen->jam_kembali ? substr($dispen->jam_kembali, 0, 5) : '15:00') . ' WIB',
                'tempat'              => $dispen->tempat ?? '-',
                'alasan'              => $dispen->alasan ?? '-',
                'status_waka'         => $dispen->status_waka,
                'status_waka_label'   => $statusWakaLabel,
                'status_waka_class'   => $statusWakaClass,
                'nama_waka'           => $dispen->nama_waka ?? ($dispen->wakaUser->name ?? 'Waka Kesiswaan'),
                'nip_waka'            => $dispen->nip_waka ?? ($dispen->wakaUser->nip ?? '-'),
                'catatan_waka'        => $dispen->catatan_waka ?? '-',
                'waktu_approval_waka' => $dispen->waktu_approval_waka ? \Carbon\Carbon::parse($dispen->waktu_approval_waka)->translatedFormat('d F Y • H:i') : '-',
                'nama_guru_piket'     => $dispen->nama_guru_piket ?? ($dispen->guruPiketUser->name ?? 'Guru Piket'),
                'nip_guru_piket'      => $dispen->nip_guru_piket ?? ($dispen->guruPiketUser->nip ?? '-'),
                'status_satpam'       => $dispen->status_satpam,
                'status_satpam_label' => $statusSatpamLabel,
                'status_satpam_class' => $statusSatpamClass,
                'waktu_scan_satpam'   => $dispen->waktu_scan_satpam ? \Carbon\Carbon::parse($dispen->waktu_scan_satpam)->translatedFormat('d F Y • H:i') : '-',
                'catatan_satpam'      => $dispen->catatan_satpam ?? '-',
                'foto_surat_url'      => $dispen->foto_surat_url,
                'foto_kartu_url'      => $dispen->foto_kartu_url,
                'foto_siswa_live_url' => $dispen->foto_siswa_live_url,
                'ttd_siswa_url'       => $dispen->ttd_siswa_url,
                'ttd_piket_url'       => $dispen->ttd_piket_url,
                'created_at'          => $dispen->created_at ? $dispen->created_at->translatedFormat('d F Y • H:i') : '-',
                'is_trashed'          => $dispen->trashed(),
            ]
        ]);
    }
}
