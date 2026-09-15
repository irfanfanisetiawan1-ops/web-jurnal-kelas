<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\GuruIzin;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\JurnalMengajar;
use App\Models\JurnalDetailKetidakhadiran;
use App\Models\Pengumuman;
use App\Models\PenugasanGuruPengganti;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\JamPelajaran;
use Carbon\Carbon;

class WakaSdmController extends Controller
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
        return $days[Carbon::now('Asia/Jakarta')->format('l')] ?? 'Selasa';
    }

    /**
     * Dashboard Waka SDM (Sumber Daya Manusia / Kepegawaian)
     */
    public function dashboard(Request $request)
    {
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();
        $selectedDate = $request->query('tanggal', $today);
        $selectedHari = $request->query('hari', $this->getHariIndo());
        $selectedKelas = $request->query('id_kelas');

        // 1. Antrean Approval Izin Guru yang Menunggu Waka SDM (status_waka_sdm = pending)
        $pendingGuruIzin = GuruIzin::with(['guru.mapel', 'guruPiket'])
            ->where('status_waka_sdm', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Ringkasan Statistik Utama SDM
        $totalGuru = Guru::count();
        $guruAktifCount = Guru::has('user')->count();
        if ($guruAktifCount === 0) {
            $guruAktifCount = $totalGuru;
        }

        // Hitung pengajuan izin menunggu Waka SDM
        $countPendingApproval = $pendingGuruIzin->count();

        // Hitung izin disetujui bulan ini
        $countApprovedBulanIni = GuruIzin::whereMonth('tanggal_mulai', $now->month)
            ->whereYear('tanggal_mulai', $now->year)
            ->where(function($q) {
                $q->where('status_waka_sdm', 'approved')
                  ->orWhere('status_final', 'approved');
            })
            ->count();

        // Hitung izin ditolak bulan ini
        $countRejectedBulanIni = GuruIzin::whereMonth('tanggal_mulai', $now->month)
            ->whereYear('tanggal_mulai', $now->year)
            ->where(function($q) {
                $q->where('status_waka_sdm', 'rejected')
                  ->orWhere('status_final', 'rejected');
            })
            ->count();

        // Guru yang sedang izin / tidak hadir pada tanggal terpilih (aktif dan tidak ditolak)
        $guruIzinHariIni = GuruIzin::with(['guru.mapel'])
            ->whereDate('tanggal_mulai', '<=', $selectedDate)
            ->whereDate('tanggal_selesai', '>=', $selectedDate)
            ->where('status_final', '!=', 'rejected')
            ->where('status_waka_sdm', '!=', 'rejected')
            ->get();

        $guruIzinHariIniCount = $guruIzinHariIni->count();

        // Attach info penugasan guru pengganti & jadwal terdampak untuk masing-masing guru izin
        foreach ($guruIzinHariIni as $item) {
            $tglSelesai = $item->tanggal_selesai ?? $item->tanggal_mulai;
            $item->is_expired = ($tglSelesai < $today);
            $item->status_masa_berlaku = $item->is_expired ? 'selesai' : 'aktif';

            $penugasans = PenugasanGuruPengganti::with(['guruPengganti.mapel', 'kelas'])
                ->where('id_guru_tidak_hadir', $item->id_guru)
                ->whereDate('tanggal', '>=', $item->tanggal_mulai)
                ->whereDate('tanggal', '<=', $item->tanggal_selesai)
                ->where('status', 'aktif')
                ->get();

            $item->has_penugasan = $penugasans->isNotEmpty();
            $item->penugasans_list = $penugasans;

            $jadwals = Jadwal::with(['kelas', 'mapel', 'jamMulai', 'jamSelesai'])
                ->where('id_guru', $item->id_guru)
                ->get();
            $item->jadwals_list = $jadwals;
        }

        // Penugasan Guru Pengganti Aktif pada tanggal terpilih (Sinkronisasi Guru Piket)
        $penugasanGuruPengganti = PenugasanGuruPengganti::with([
                'guruTidakHadir.mapel',
                'guruPengganti.mapel',
                'kelas',
                'jadwal.jamMulai',
                'jadwal.jamSelesai'
            ])
            ->whereDate('tanggal', $selectedDate)
            ->orderBy('id_penugasan', 'desc')
            ->get();

        $guruPenggantiHariIni = $penugasanGuruPengganti->count();

        // Jadwal KBM pada hari terpilih (Sinkronisasi TU & Piket)
        $jadwalQuery = Jadwal::with(['kelas', 'mapel', 'guru', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->where('hari', $selectedHari);

        if ($selectedKelas) {
            $jadwalQuery->where('id_kelas', $selectedKelas);
        }

        $jadwalList = $jadwalQuery->orderBy('id_jam_mulai')->get();
        $totalJadwalHariIni = $jadwalList->count();

        // Hitung jurnal mengajar yang sudah terisi pada tanggal terpilih
        $jurnalTerisiQuery = JurnalMengajar::whereDate('tanggal', $selectedDate);
        $jurnalTerisiHariIni = $jurnalTerisiQuery->distinct('id_jadwal')->count();

        // Guru yang hadir / mengajar hari ini (berdasarkan jurnal terisi atau guru aktif terjadwal dikurangi izin)
        $guruTerjadwalHariIni = Jadwal::where('hari', $selectedHari)->distinct('id_guru')->count();
        $guruHadirMengajarCount = JurnalMengajar::whereDate('tanggal', $selectedDate)
            ->with('jadwal')
            ->get()
            ->map(function($j) {
                return $j->id_guru_pengganti ?: ($j->jadwal ? $j->jadwal->id_guru : null);
            })
            ->filter()
            ->unique()
            ->count();

        if ($guruHadirMengajarCount === 0 && $guruTerjadwalHariIni > 0) {
            $guruHadirHariIni = max(0, $guruTerjadwalHariIni - $guruIzinHariIniCount);
        } else {
            $guruHadirHariIni = $guruHadirMengajarCount;
        }

        // Persentase KBM terisi hari ini
        $persentaseKbm = $totalJadwalHariIni > 0 
            ? min(100, round(($jurnalTerisiHariIni / $totalJadwalHariIni) * 100)) 
            : 0;

        // Tandai status pengisian jurnal pada setiap jadwal
        foreach ($jadwalList as $jItem) {
            $jItem->is_jurnal_diisi = JurnalMengajar::where('id_jadwal', $jItem->id_jadwal)
                ->whereDate('tanggal', $selectedDate)
                ->exists();
        }

        // 3. Rekap Riwayat Pengajuan Izin Terbaru (Multi-Approval Status)
        $riwayatPengajuan = GuruIzin::with(['guru.mapel', 'guruPiket'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // 4. Seluruh Permintaan Izin Masuk (Sinkronisasi Guru Piket)
        $permintaanIzinSemua = GuruIzin::with(['guru.mapel', 'guruPiket'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // 5. Data Master Jam Pelajaran Lengkap (Sinkronisasi TU)
        $jamPelajaranList = JamPelajaran::orderBy('jam_ke')->get();

        // 6. Monitoring Realtime KBM & Jurnal Hari Ini
        $jurnalMonitoring = JurnalMengajar::with([
                'jadwal.guru',
                'jadwal.kelas',
                'jadwal.mapel',
                'guruPengganti'
            ])
            ->whereDate('tanggal', $selectedDate)
            ->orderBy('id_jurnal', 'desc')
            ->limit(8)
            ->get();

        // 7. Pengumuman SDM & Sekolah Terbaru
        $pengumumanTerbaru = Pengumuman::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Master List untuk Filter
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapelList = Mapel::orderBy('nama_mapel')->get();

        return view('waka_sdm.dashboard', compact(
            'pendingGuruIzin',
            'totalGuru',
            'guruAktifCount',
            'guruIzinHariIni',
            'guruIzinHariIniCount',
            'guruHadirHariIni',
            'guruPenggantiHariIni',
            'penugasanGuruPengganti',
            'countPendingApproval',
            'countApprovedBulanIni',
            'countRejectedBulanIni',
            'totalJadwalHariIni',
            'jurnalTerisiHariIni',
            'persentaseKbm',
            'riwayatPengajuan',
            'permintaanIzinSemua',
            'jadwalList',
            'jamPelajaranList',
            'jurnalMonitoring',
            'pengumumanTerbaru',
            'kelasList',
            'mapelList',
            'selectedDate',
            'selectedHari',
            'selectedKelas',
            'today'
        ));
    }

    /**
     * Halaman Persetujuan Izin Guru (Waka SDM)
     */
    public function persetujuanIzin(Request $request)
    {
        $filterStatus = $request->query('status', 'all');
        $search       = $request->query('search');
        $kategori     = $request->query('kategori');
        $tanggal      = $request->query('tanggal');
        $today        = Carbon::today('Asia/Jakarta')->toDateString();

        $query = GuruIzin::with(['guru.mapel', 'guruPiket']);

        if ($filterStatus === 'pending') {
            $query->where(function($q) {
                $q->where('status_waka_sdm', 'pending')->orWhereNull('status_waka_sdm');
            });
        } elseif ($filterStatus === 'approved') {
            $query->where('status_waka_sdm', 'approved');
        } elseif ($filterStatus === 'rejected') {
            $query->where('status_waka_sdm', 'rejected');
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('guru', function($gq) use ($search) {
                    $gq->where('nama_guru', 'like', "%{$search}%")
                       ->orWhere('nip', 'like', "%{$search}%")
                       ->orWhereHas('mapel', function($mq) use ($search) {
                           $mq->where('nama_mapel', 'like', "%{$search}%");
                       });
                })
                ->orWhere('alasan', 'like', "%{$search}%")
                ->orWhere('materi_dititipkan', 'like', "%{$search}%");
            });
        }

        if ($kategori && $kategori !== 'all') {
            $query->where('kategori_izin', $kategori);
        }

        if ($tanggal) {
            $query->whereDate('tanggal_mulai', '<=', $tanggal)
                  ->whereDate('tanggal_selesai', '>=', $tanggal);
        }

        $daftarIzin = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        $totalPengajuan      = GuruIzin::count();
        $countPending        = GuruIzin::where(function($q) {
            $q->where('status_waka_sdm', 'pending')->orWhereNull('status_waka_sdm');
        })->count();
        $countApproved       = GuruIzin::where('status_waka_sdm', 'approved')->count();
        $countRejected       = GuruIzin::where('status_waka_sdm', 'rejected')->count();
        $countDisetujuiResmi = GuruIzin::where('status_final', 'approved')->count();
        $countIzinHariIni    = GuruIzin::whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->where('status_waka_sdm', '!=', 'rejected')
            ->where('status_final', '!=', 'rejected')
            ->count();
        $trashedCount        = GuruIzin::onlyTrashed()->count();

        return view('waka_sdm.persetujuan_izin', compact(
            'daftarIzin',
            'filterStatus',
            'search',
            'kategori',
            'tanggal',
            'totalPengajuan',
            'countPending',
            'countApproved',
            'countRejected',
            'countDisetujuiResmi',
            'countIzinHariIni',
            'trashedCount'
        ));
    }

    /**
     * Setujui Permintaan Izin Guru (Waka SDM)
     */
    public function approve(Request $request, $id)
    {
        $izin = GuruIzin::findOrFail($id);
        $catatan = $request->input('catatan', 'Disetujui oleh Waka SDM');

        $izin->status_waka_sdm = 'approved';
        $izin->status_waka     = 'approved';
        if ($catatan) {
            $izin->catatan_waka = $catatan;
        }

        if ($izin->status_kepsek === 'approved') {
            $izin->status_final = 'approved';
        } else {
            $izin->status_final = 'pending';
        }
        $izin->save();

        return redirect()->back()->with('success', 'Pengajuan izin guru berhasil disetujui oleh Waka SDM.');
    }

    /**
     * Tolak Permintaan Izin Guru (Waka SDM)
     */
    public function reject(Request $request, $id)
    {
        $izin = GuruIzin::findOrFail($id);
        $catatan = $request->input('catatan', 'Ditolak oleh Waka SDM');

        $izin->status_waka_sdm = 'rejected';
        $izin->status_waka     = 'rejected';
        $izin->status_final    = 'rejected';
        $izin->catatan_waka    = $catatan;
        $izin->save();

        return redirect()->back()->with('success', 'Pengajuan izin guru berhasil ditolak oleh Waka SDM.');
    }

    /* =========================================================================
     * MANAJEMEN SOFT DELETE & TRASH: GURU IZIN (WAKA SDM)
     * ========================================================================= */

    public function destroy($id)
    {
        $izin = GuruIzin::findOrFail($id);
        $izin->delete();

        return redirect()->back()->with('success', 'Data izin guru berhasil dipindahkan ke sampah (Soft Delete).');
    }

    public function batchDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Tidak ada data izin guru yang dipilih.');
        }

        GuruIzin::whereIn('id_guru_izin', $ids)->delete();

        return redirect()->back()->with('success', count($ids) . ' data izin guru berhasil dipindahkan ke sampah.');
    }

    public function trash()
    {
        $guruIzinList = GuruIzin::onlyTrashed()->with('guru')->orderBy('deleted_at', 'desc')->get();
        return view('waka_sdm.persetujuan_izin_trash', compact('guruIzinList'));
    }

    public function restore($id)
    {
        $izin = GuruIzin::onlyTrashed()->findOrFail($id);
        $izin->restore();

        return redirect()->route('waka-sdm.izin.trash')->with('success', 'Data izin guru berhasil dipulihkan dari sampah.');
    }

    public function batchRestore(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Tidak ada data izin guru yang dipilih.');
        }

        GuruIzin::onlyTrashed()->whereIn('id_guru_izin', $ids)->restore();

        return redirect()->route('waka-sdm.izin.trash')->with('success', count($ids) . ' data izin guru berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $izin = GuruIzin::onlyTrashed()->findOrFail($id);
        if ($izin->foto_surat && file_exists(public_path('uploads/guru_izin/' . $izin->foto_surat))) {
            @unlink(public_path('uploads/guru_izin/' . $izin->foto_surat));
        }
        $izin->forceDelete();

        return redirect()->route('waka-sdm.izin.trash')->with('success', 'Data izin guru berhasil dihapus secara permanen.');
    }

    public function emptyTrash()
    {
        $trashed = GuruIzin::onlyTrashed()->get();
        foreach ($trashed as $iz) {
            if ($iz->foto_surat && file_exists(public_path('uploads/guru_izin/' . $iz->foto_surat))) {
                @unlink(public_path('uploads/guru_izin/' . $iz->foto_surat));
            }
            $iz->forceDelete();
        }

        return redirect()->route('waka-sdm.izin.trash')->with('success', 'Seluruh sampah izin guru telah dikosongkan.');
    }

    /**
     * Monitoring Kehadiran Guru & KBM (Role Waka SDM)
     * Sinkronisasi data multi-role: Guru Piket, TU (Jadwal & Jam Pelajaran), Guru Izin, Guru Pengganti & Jurnal Mengajar
     */
    public function kehadiranGuru(Request $request)
    {
        $tab           = $request->query('tab', 'harian');
        $tanggal       = $request->query('tanggal', Carbon::today('Asia/Jakarta')->toDateString());
        $bulan         = (int) $request->query('bulan', Carbon::now('Asia/Jakarta')->month);
        $tahun         = (int) $request->query('tahun', Carbon::now('Asia/Jakarta')->year);
        $idKelasFilter = $request->query('id_kelas');
        $idGuruFilter  = $request->query('id_guru');
        $idMapelFilter = $request->query('id_mapel');
        $statusFilter  = $request->query('status');
        $search        = $request->query('q') ?? $request->query('search');

        // Master dropdowns
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $guruList  = Guru::orderBy('nama_guru')->get();
        $mapelList = Mapel::orderBy('nama_mapel')->get();

        // 1. DATA HARIAN
        $dailyData = $this->getKehadiranHarianData($tanggal, $search, $idGuruFilter, $idMapelFilter, $idKelasFilter, $statusFilter);

        // 2. DATA REKAP & TREN BULANAN
        $monthlyData = $this->getRekapBulananData($bulan, $tahun, $search, $idMapelFilter);

        return view('waka_sdm.kehadiran_guru', array_merge([
            'tab'           => $tab,
            'tanggal'       => $tanggal,
            'bulan'         => $bulan,
            'tahun'         => $tahun,
            'idKelasFilter' => $idKelasFilter,
            'idGuruFilter'  => $idGuruFilter,
            'idMapelFilter' => $idMapelFilter,
            'statusFilter'  => $statusFilter,
            'search'        => $search,
            'kelasList'     => $kelasList,
            'guruList'      => $guruList,
            'mapelList'     => $mapelList,
        ], $dailyData, $monthlyData));
    }

    /**
     * Helper: Hitung & Susun Data Presensi & KBM Harian
     */
    private function getKehadiranHarianData($tanggal, $search = null, $idGuruFilter = null, $idMapelFilter = null, $idKelasFilter = null, $statusFilter = null)
    {
        $carbonDate = Carbon::parse($tanggal);
        $daysIndo = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu'
        ];
        $hariTeks = $daysIndo[$carbonDate->format('l')] ?? 'Senin';

        // 1. Jadwal Pelajaran Hari Ini
        $jadwalQuery = Jadwal::with(['guru', 'kelas', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->where('hari', $hariTeks);

        $allJadwals = $jadwalQuery->orderBy('id_jam_mulai', 'asc')->get();

        // 2. Guru Izin / Tidak Hadir aktif pada tanggal ini
        $guruIzinList = GuruIzin::with('guru')
            ->whereDate('tanggal_mulai', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal)
            ->get();
        $guruIzinKeyed = $guruIzinList->keyBy('id_guru');

        // 3. Penugasan Guru Pengganti (Inval) aktif pada tanggal ini
        $penugasanList = PenugasanGuruPengganti::with(['guruUtama', 'guruPengganti', 'jadwal.kelas', 'jadwal.mapel'])
            ->whereDate('tanggal', $tanggal)
            ->get();
        $penugasanKeyed = $penugasanList->keyBy('id_jadwal');

        // 4. Jurnal Mengajar pada tanggal ini
        $jurnalList = JurnalMengajar::with(['jadwal.guru', 'jadwal.kelas', 'jadwal.mapel', 'guruPengganti'])
            ->whereDate('tanggal', $tanggal)
            ->get();
        $jurnalKeyed = $jurnalList->keyBy('id_jadwal');

        // 5. Proses baris sesi KBM harian
        $processedRows = collect();
        $statHadir = 0;
        $statIzin = 0;
        $statTidakHadir = 0;
        $statDigantikan = 0;

        foreach ($allJadwals as $jadwal) {
            $penugasan = $penugasanKeyed->get($jadwal->id_jadwal);
            $guruIzin  = $guruIzinKeyed->get($jadwal->id_guru);
            $jurnal    = $jurnalKeyed->get($jadwal->id_jadwal);

            $jamKeText = 'Jam ke ' . ($jadwal->id_jam_mulai ?? 1) . ($jadwal->id_jam_selesai && $jadwal->id_jam_selesai != $jadwal->id_jam_mulai ? ' - ' . $jadwal->id_jam_selesai : '');
            $waktuMulai = $jadwal->waktu_mulai_effective ?? '07:00';
            $waktuSelesai = $jadwal->waktu_selesai_effective ?? '08:30';
            $jamFormatted = substr($waktuMulai, 0, 5) . ' - ' . substr($waktuSelesai, 0, 5) . ' WIB';

            $statusTeks = 'Hadir';
            $statusKey = 'hadir';
            $keterangan = '-';
            $guruPenggantiNama = null;

            if ($penugasan && $penugasan->guruPengganti) {
                $statusTeks = 'Digantikan';
                $statusKey = 'digantikan';
                $guruPenggantiNama = $penugasan->guruPengganti->nama_guru;
                $keterangan = 'Digantikan oleh: ' . $guruPenggantiNama . ($guruIzin ? ' (' . ($guruIzin->kategori_izin ?: ($guruIzin->jenis_izin ?? 'Izin')) . ')' : '');
                $statDigantikan++;
            } elseif ($jurnal && $jurnal->id_guru_pengganti && $jurnal->guruPengganti) {
                $statusTeks = 'Digantikan';
                $statusKey = 'digantikan';
                $guruPenggantiNama = $jurnal->guruPengganti->nama_guru;
                $keterangan = 'Digantikan oleh: ' . $guruPenggantiNama;
                $statDigantikan++;
            } elseif ($guruIzin) {
                $alasanRaw = $guruIzin->alasan ?: '';
                $alasanClean = trim(preg_replace('/^biasa:\s*/i', '', $alasanRaw));
                $kategori = strtolower($guruIzin->kategori_izin ?: ($guruIzin->jenis_izin ?: ''));
                $isSakit = str_contains($kategori, 'sakit') || str_contains(strtolower($alasanClean), 'sakit') || str_contains($kategori, 'alpa');
                $isCuti = str_contains($kategori, 'cuti') || str_contains(strtolower($alasanClean), 'cuti');
                $isDinas = str_contains(strtolower($alasanClean), 'dinas') || str_contains(strtolower($alasanClean), 'workshop') || str_contains(strtolower($alasanClean), 'tugas');

                if ($isSakit) {
                    $statusTeks = 'Tidak Hadir';
                    $statusKey = 'tidak_hadir';
                    $keterangan = $alasanClean ?: 'Sakit';
                    $statTidakHadir++;
                } elseif ($isCuti) {
                    $statusTeks = 'Izin (Cuti)';
                    $statusKey = 'izin';
                    $keterangan = $alasanClean ?: 'Cuti';
                    $statIzin++;
                } elseif ($isDinas) {
                    $statusTeks = 'Tugas Dinas';
                    $statusKey = 'izin';
                    $keterangan = $alasanClean ?: 'Tugas Dinas';
                    $statIzin++;
                } else {
                    $statusTeks = 'Izin';
                    $statusKey = 'izin';
                    $keterangan = $alasanClean ?: 'Izin Pribadi';
                    $statIzin++;
                }
            } elseif ($jurnal && $jurnal->status_kehadiran_guru && $jurnal->status_kehadiran_guru !== 'Hadir') {
                if (in_array($jurnal->status_kehadiran_guru, ['Sakit', 'Tanpa Keterangan', 'Alpa'])) {
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
                $statusTeks = $jurnal ? 'Hadir (Terisi)' : 'Hadir';
                $statusKey = 'hadir';
                $keterangan = ($jurnal && $jurnal->catatan) ? $jurnal->catatan : '-';
                $statHadir++;
            }

            $item = (object)[
                'id_jadwal'           => $jadwal->id_jadwal,
                'id_guru'             => $jadwal->id_guru,
                'guru_nama'           => $jadwal->guru->nama_guru ?? 'Guru Pengampu',
                'guru_nip'            => $jadwal->guru->nip ?? '-',
                'guru_hp'             => $jadwal->guru->no_hp ?? null,
                'id_mapel'            => $jadwal->id_mapel,
                'mapel_nama'          => $jadwal->mapel->nama_mapel ?? 'Mata Pelajaran',
                'id_kelas'            => $jadwal->id_kelas,
                'kelas_nama'          => $jadwal->kelas->nama_kelas ?? 'Kelas',
                'ruangan_nama'        => $jadwal->ruangan->nama_ruangan ?? 'Ruang Kelas',
                'jam_ke'              => $jamKeText,
                'jam'                 => $jamFormatted,
                'status_teks'         => $statusTeks,
                'status_key'          => $statusKey,
                'keterangan'          => $keterangan,
                'guru_pengganti_nama' => $guruPenggantiNama,
                'has_jurnal'          => $jurnal ? true : false,
                'jurnal'              => $jurnal,
                'materi'              => $jurnal->materi ?? ($penugasan->materi_dititipkan ?? '-'),
            ];

            $processedRows->push($item);
        }

        // Terapkan Filter
        $filteredRows = $processedRows->filter(function($r) use ($search, $idGuruFilter, $idMapelFilter, $idKelasFilter, $statusFilter) {
            if ($idGuruFilter && $r->id_guru != $idGuruFilter) return false;
            if ($idMapelFilter && $r->id_mapel != $idMapelFilter) return false;
            if ($idKelasFilter && $r->id_kelas != $idKelasFilter) return false;
            if ($statusFilter && $r->status_key != $statusFilter) return false;
            if ($search) {
                $needle = strtolower($search);
                $haystack = strtolower($r->guru_nama . ' ' . $r->mapel_nama . ' ' . $r->kelas_nama . ' ' . $r->ruangan_nama . ' ' . $r->materi . ' ' . ($r->guru_pengganti_nama ?? ''));
                if (!str_contains($haystack, $needle)) return false;
            }
            return true;
        })->values();

        // Paginate Sesi Harian
        $page = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $pagedSesi = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredRows->slice(($page - 1) * $perPage, $perPage)->values(),
            $filteredRows->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $totalGuru = Guru::count();
        $guruIzinCount = $guruIzinList->count();
        $guruHadirCount = max(0, $totalGuru - $guruIzinCount);
        $jurnalTerisiCount = $jurnalList->count();
        $totalSesi = $allJadwals->count();
        $persenKBM = $totalSesi > 0 ? round(($jurnalTerisiCount / $totalSesi) * 100) : 0;

        $dailyStats = [
            'totalGuru'          => $totalGuru,
            'guruHadirCount'     => $guruHadirCount,
            'guruIzinCount'      => $guruIzinCount,
            'guruPenggantiCount' => $penugasanList->count(),
            'jurnalTerisiCount'  => $jurnalTerisiCount,
            'totalSesi'          => $totalSesi,
            'sesiHadir'          => $statHadir,
            'sesiIzin'           => $statIzin,
            'sesiTidakHadir'     => $statTidakHadir,
            'sesiDigantikan'     => $statDigantikan,
            'persenKBM'          => $persenKBM,
        ];

        return [
            'hariTeks'      => $hariTeks,
            'sesiList'      => $pagedSesi,
            'allSesiRows'   => $filteredRows,
            'guruIzin'      => $guruIzinList,
            'guruPengganti' => $penugasanList,
            'dailyStats'    => $dailyStats,
            'stats'         => $dailyStats, // Fallback alias
        ];
    }

    /**
     * Helper: Hitung & Susun Data Rekap & Tren Bulanan SDM
     */
    private function getRekapBulananData($bulan, $tahun, $search = null, $idMapelFilter = null)
    {
        $carbonMonth = Carbon::createFromDate($tahun, $bulan, 1);
        $startOfMonth = $carbonMonth->copy()->startOfMonth()->toDateString();
        $endOfMonth   = $carbonMonth->copy()->endOfMonth()->toDateString();
        $daysInMonth  = $carbonMonth->daysInMonth;

        // 1. Data Izin pada bulan tersebut
        $izinBulan = GuruIzin::where(function($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
              ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();

        // 2. Data Jurnal Mengajar pada bulan tersebut
        $jurnalBulan = JurnalMengajar::with(['jadwal.guru', 'jadwal.mapel'])
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->get();

        // 3. Matrix Kehadiran per Guru
        $guruQuery = Guru::with(['mapel', 'jadwals']);
        if ($idMapelFilter) {
            $guruQuery->where('id_mapel', $idMapelFilter);
        }
        if ($search) {
            $guruQuery->where('nama_guru', 'like', "%{$search}%");
        }
        $gurus = $guruQuery->orderBy('nama_guru', 'asc')->get();

        $guruMatrix = collect();
        $totalHadirBulan = 0;
        $totalIzinBulan = 0;
        $totalSakitBulan = 0;

        foreach ($gurus as $g) {
            // Hitung jurnal terisi oleh guru ini di bulan terpilih
            $jurnalCount = $jurnalBulan->filter(function($j) use ($g) {
                return ($j->id_guru == $g->id_guru) || ($j->jadwal && $j->jadwal->id_guru == $g->id_guru);
            })->count();

            // Hitung izin oleh guru ini
            $izinGuru = $izinBulan->where('id_guru', $g->id_guru);
            $izinCount = 0;
            $sakitCount = 0;
            foreach ($izinGuru as $iz) {
                $kat = strtolower($iz->kategori_izin ?: ($iz->jenis_izin ?: ($iz->alasan ?: 'izin')));
                if (str_contains($kat, 'sakit')) {
                    $sakitCount++;
                } else {
                    $izinCount++;
                }
            }

            $totalHadirBulan += $jurnalCount;
            $totalIzinBulan += $izinCount;
            $totalSakitBulan += $sakitCount;

            $totalAktivitas = $jurnalCount + $izinCount + $sakitCount;
            $persenHadir = $totalAktivitas > 0 ? round(($jurnalCount / $totalAktivitas) * 100) : ($jurnalCount > 0 ? 100 : 0);

            $statusPredikat = 'Sangat Baik';
            $badgeColor = '#16a34a';
            if ($persenHadir < 75 && $totalAktivitas > 0) {
                $statusPredikat = 'Perlu Pembinaan';
                $badgeColor = '#dc2626';
            } elseif ($persenHadir < 90 && $totalAktivitas > 0) {
                $statusPredikat = 'Cukup Baik';
                $badgeColor = '#d97706';
            }

            $guruMatrix->push((object)[
                'guru'           => $g,
                'total_jurnal'   => $jurnalCount,
                'total_izin'     => $izinCount,
                'total_sakit'    => $sakitCount,
                'persen_hadir'   => $persenHadir,
                'predikat'       => $statusPredikat,
                'badge_color'    => $badgeColor,
            ]);
        }

        // 4. Trend 6 Bulan Terakhir
        $trendLabels = [];
        $trendHadir = [];
        $trendIzin = [];
        $now = Carbon::now('Asia/Jakarta');

        for ($i = 5; $i >= 0; $i--) {
            $m = $now->copy()->subMonths($i);
            $mStart = $m->copy()->startOfMonth()->toDateString();
            $mEnd   = $m->copy()->endOfMonth()->toDateString();
            
            $trendLabels[] = $m->translatedFormat('M Y');
            $trendHadir[]  = JurnalMengajar::whereBetween('tanggal', [$mStart, $mEnd])->count();
            $trendIzin[]   = GuruIzin::where(function($q) use ($mStart, $mEnd) {
                $q->whereBetween('tanggal_mulai', [$mStart, $mEnd])
                  ->orWhereBetween('tanggal_selesai', [$mStart, $mEnd]);
            })->count();
        }

        $monthlyStats = [
            'totalHadir'     => $totalHadirBulan,
            'totalIzin'      => $totalIzinBulan,
            'totalSakit'     => $totalSakitBulan,
            'daysInMonth'    => $daysInMonth,
            'totalAktivitas' => $totalHadirBulan + $totalIzinBulan + $totalSakitBulan,
        ];

        return [
            'monthlyStats' => $monthlyStats,
            'guruMatrix'   => $guruMatrix,
            'trendLabels'  => $trendLabels,
            'trendHadir'   => $trendHadir,
            'trendIzin'    => $trendIzin,
            'namaBulan'    => $carbonMonth->translatedFormat('F Y'),
        ];
    }

    /**
     * Export Rekap Kehadiran Guru & KBM to CSV
     */
    public function exportKehadiran(Request $request)
    {
        $tanggal       = $request->query('tanggal', Carbon::today('Asia/Jakarta')->toDateString());
        $idKelasFilter = $request->query('id_kelas');
        $idGuruFilter  = $request->query('id_guru');
        $idMapelFilter = $request->query('id_mapel');
        $statusFilter  = $request->query('status');
        $search        = $request->query('q') ?? $request->query('search');

        $data = $this->getKehadiranHarianData($tanggal, $search, $idGuruFilter, $idMapelFilter, $idKelasFilter, $statusFilter);
        $rows = $data['allSesiRows'];
        $hari = $data['hariTeks'];

        $filename = "rekap_kehadiran_sdm_" . $tanggal . "_" . date('His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($rows, $tanggal, $hari) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM
            fputcsv($file, ['REKAPITULASI KEHADIRAN GURU & MONITORING KBM — WAKA SDM']);
            fputcsv($file, ['Tanggal', $tanggal, 'Hari', $hari]);
            fputcsv($file, []);
            fputcsv($file, ['No', 'Nama Pendidik', 'NIP', 'Mata Pelajaran', 'Kelas', 'Ruangan', 'Sesi Jam', 'Waktu Mengajar', 'Status Kehadiran', 'Guru Pengganti', 'Materi / Keterangan']);

            $no = 1;
            foreach ($rows as $r) {
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
                    $r->materi . ($r->keterangan !== '-' ? ' | ' . $r->keterangan : ''),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak Laporan Resmi Kehadiran & KBM Waka SDM
     */
    public function printKehadiran(Request $request)
    {
        $tanggal       = $request->query('tanggal', Carbon::today('Asia/Jakarta')->toDateString());
        $idKelasFilter = $request->query('id_kelas');
        $idGuruFilter  = $request->query('id_guru');
        $idMapelFilter = $request->query('id_mapel');
        $statusFilter  = $request->query('status');
        $search        = $request->query('q') ?? $request->query('search');

        $data = $this->getKehadiranHarianData($tanggal, $search, $idGuruFilter, $idMapelFilter, $idKelasFilter, $statusFilter);
        $user = Auth::user();

        return view('waka_sdm.kehadiran_guru_print', array_merge($data, [
            'tanggal'      => $tanggal,
            'wakaSdmNama'  => $user->name ?? 'Waka SDM & Kepegawaian',
            'wakaSdmNip'   => $user->nip ?? ($user->guru->nip ?? '-'),
        ]));
    }

    /**
     * Data Master Pendidik & Tenaga Kependidikan (Direktori SDM)
     */
    public function dataGuru(Request $request)
    {
        $search       = $request->query('search') ?? $request->query('q');
        $jkFilter     = $request->query('jenis_kelamin');
        $mapelFilter  = $request->query('id_mapel');
        $roleFilter   = $request->query('role');
        $statusFilter = $request->query('status');

        $query = Guru::with([
            'user',
            'mapel',
            'kelasWali',
            'jadwals.kelas',
            'jadwals.mapel',
            'jadwals.jamMulai',
            'jadwals.jamSelesai'
        ]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhereHas('mapel', function($m) use ($search) {
                      $m->where('nama_mapel', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($jkFilter)) {
            $query->where('jenis_kelamin', $jkFilter);
        }

        if (!empty($mapelFilter)) {
            $query->where('id_mapel', $mapelFilter);
        }

        if (!empty($roleFilter)) {
            $query->whereHas('user', function($u) use ($roleFilter) {
                $u->where('role', $roleFilter);
            });
        }

        if ($statusFilter === 'active') {
            $query->where(function($q) {
                $q->where('is_active', 1)->orWhereNull('is_active');
            });
        } elseif ($statusFilter === 'inactive') {
            $query->where('is_active', 0);
        } elseif ($statusFilter === 'has_account') {
            $query->has('user');
        } elseif ($statusFilter === 'no_account') {
            $query->doesntHave('user');
        }

        $guruList  = $query->orderBy('nama_guru', 'asc')->paginate(15)->withQueryString();
        $mapelList = Mapel::orderBy('nama_mapel')->get();

        $stats = [
            'totalGuru'      => Guru::count(),
            'totalLaki'      => Guru::where('jenis_kelamin', 'L')->count(),
            'totalPerempuan' => Guru::where('jenis_kelamin', 'P')->count(),
            'totalAkun'      => Guru::has('user')->count(),
            'totalWali'      => Kelas::whereNotNull('wali_kelas')->where('wali_kelas', '!=', '')->count(),
        ];

        return view('waka_sdm.data_guru', compact(
            'guruList',
            'mapelList',
            'stats',
            'search',
            'jkFilter',
            'mapelFilter',
            'roleFilter',
            'statusFilter'
        ));
    }

    /**
     * Export Direktori SDM & Pendidik to CSV
     */
    public function exportDataGuru(Request $request)
    {
        $search       = $request->query('search') ?? $request->query('q');
        $jkFilter     = $request->query('jenis_kelamin');
        $mapelFilter  = $request->query('id_mapel');
        $roleFilter   = $request->query('role');
        $statusFilter = $request->query('status');

        $query = Guru::with(['user', 'mapel', 'kelasWali']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhereHas('mapel', function($m) use ($search) {
                      $m->where('nama_mapel', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($jkFilter)) $query->where('jenis_kelamin', $jkFilter);
        if (!empty($mapelFilter)) $query->where('id_mapel', $mapelFilter);
        if (!empty($roleFilter)) {
            $query->whereHas('user', function($u) use ($roleFilter) {
                $u->where('role', $roleFilter);
            });
        }

        $gurus = $query->orderBy('nama_guru', 'asc')->get();
        $filename = "direktori_sdm_pendidik_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($gurus) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM
            fputcsv($file, ['DIREKTORI MASTER DATA PENDIDIK & SDM — SMKN 1 BOYOLANGU']);
            fputcsv($file, ['Tanggal Ekspor', Carbon::now('Asia/Jakarta')->translatedFormat('d F Y H:i') . ' WIB']);
            fputcsv($file, []);
            fputcsv($file, ['No', 'Nama Pendidik & SDM', 'NIP', 'Jenis Kelamin', 'No. HP / WhatsApp', 'Email Akun', 'Peran Sistem', 'Mata Pelajaran', 'Tugas Wali Kelas', 'Status Akun']);

            $no = 1;
            foreach ($gurus as $g) {
                fputcsv($file, [
                    $no++,
                    $g->nama_guru,
                    $g->nip ?? '-',
                    $g->jenis_kelamin === 'L' ? 'Laki-laki' : ($g->jenis_kelamin === 'P' ? 'Perempuan' : '-'),
                    $g->no_hp ?? '-',
                    $g->email ?? ($g->user ? $g->user->email : '-'),
                    $g->user ? $g->user->role_label : 'Master Guru',
                    $g->mapel ? $g->mapel->nama_mapel : 'Guru Mata Pelajaran',
                    $g->kelasWali && $g->kelasWali->count() > 0 ? $g->kelasWali->pluck('nama_kelas')->join(', ') : '-',
                    $g->user ? 'Terverifikasi (Aktif)' : 'Belum Ada Akun',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak Dokumen Resmi Direktori SDM & Pendidik
     */
    public function printDataGuru(Request $request)
    {
        $search       = $request->query('search') ?? $request->query('q');
        $jkFilter     = $request->query('jenis_kelamin');
        $mapelFilter  = $request->query('id_mapel');
        $roleFilter   = $request->query('role');
        $statusFilter = $request->query('status');

        $query = Guru::with(['user', 'mapel', 'kelasWali']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhereHas('mapel', function($m) use ($search) {
                      $m->where('nama_mapel', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($jkFilter)) $query->where('jenis_kelamin', $jkFilter);
        if (!empty($mapelFilter)) $query->where('id_mapel', $mapelFilter);
        if (!empty($roleFilter)) {
            $query->whereHas('user', function($u) use ($roleFilter) {
                $u->where('role', $roleFilter);
            });
        }

        $gurus = $query->orderBy('nama_guru', 'asc')->get();
        $user = Auth::user();

        return view('waka_sdm.data_guru_print', [
            'guruList'    => $gurus,
            'totalGuru'   => $gurus->count(),
            'wakaSdmNama' => $user->name ?? 'Waka SDM & Kepegawaian',
            'wakaSdmNip'  => $user->nip ?? ($user->guru->nip ?? '-'),
        ]);
    }

    /**
     * Halaman Manajemen Pengumuman SDM & Sekolah (Role Waka SDM)
     */
    public function pengumuman(Request $request)
    {
        $todayDate = Carbon::now('Asia/Jakarta')->toDateString();

        $search         = $request->input('q');
        $tanggalFilter  = $request->input('tanggal');
        $idKelasFilter  = $request->input('id_kelas');
        $idMapelFilter  = $request->input('id_mapel');
        $statusFilter   = $request->input('status');
        $kategoriFilter = $request->input('kategori');

        // Dynamic Stat Counts from DB
        $hasStatusCol = Schema::hasColumn('pengumuman', 'status');
        $totalPengumuman   = Pengumuman::where('kategori', '!=', 'Siswa Telat')->count();
        $pengumumanAktif   = $hasStatusCol ? Pengumuman::where('kategori', '!=', 'Siswa Telat')->whereIn('status', ['aktif', 'Aktif'])->count() : $totalPengumuman;
        $pengumumanSelesai = $hasStatusCol ? Pengumuman::where('kategori', '!=', 'Siswa Telat')->whereIn('status', ['selesai', 'Selesai'])->count() : 0;

        $stats = [
            'totalPengumuman'   => $totalPengumuman,
            'pengumumanAktif'   => $pengumumanAktif,
            'pengumumanSelesai' => $pengumumanSelesai,
        ];

        $query = Pengumuman::where('kategori', '!=', 'Siswa Telat')->with(['kelas', 'pembuat'])->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if (!empty($tanggalFilter)) {
            $query->whereDate('tanggal', $tanggalFilter);
        }

        if (!empty($idKelasFilter)) {
            $query->where('id_kelas', $idKelasFilter);
        }

        if (!empty($statusFilter)) {
            $query->whereIn('status', [strtolower($statusFilter), ucfirst(strtolower($statusFilter))]);
        }

        if (!empty($kategoriFilter)) {
            $query->where('kategori', $kategoriFilter);
        }

        $pengumumanList   = $query->get();
        $kelasList        = Kelas::orderBy('nama_kelas')->get();
        $mapelList        = Mapel::orderBy('nama_mapel')->get();
        $jamPelajaranList = JamPelajaran::orderBy('jam_ke')->get();

        // Data Sampah / Soft Deleted
        $trashPengumuman  = Pengumuman::onlyTrashed()->where('kategori', '!=', 'Siswa Telat')->with(['kelas', 'pembuat'])->orderBy('deleted_at', 'desc')->get();
        $trashCount       = $trashPengumuman->count();

        return view('waka_sdm.pengumuman', compact(
            'pengumumanList',
            'kelasList',
            'mapelList',
            'jamPelajaranList',
            'trashPengumuman',
            'trashCount',
            'stats',
            'search',
            'tanggalFilter',
            'idKelasFilter',
            'idMapelFilter',
            'statusFilter',
            'kategoriFilter',
            'todayDate'
        ));
    }

    /**
     * Simpan Pengumuman Baru (Waka SDM)
     */
    public function storePengumuman(Request $request)
    {
        $request->validate([
            'judul'               => 'required|string|max:255',
            'isi'                 => 'required|string',
            'kategori'            => 'required|string|max:100',
            'id_kelas'            => 'nullable|integer',
            'jam_mengajar_select' => 'required|string',
            'jam_mengajar_custom' => 'required_if:jam_mengajar_select,custom|nullable|string|max:100',
            'status'              => 'required|string|in:aktif,selesai,arsip',
            'keterangan'          => 'required|string|max:255',
            'tanggal'             => 'required|date',
        ], [
            'judul.required'               => 'Judul pengumuman wajib diisi.',
            'isi.required'                 => 'Isi pengumuman wajib diisi.',
            'kategori.required'            => 'Kategori pengumuman wajib dipilih.',
            'jam_mengajar_select.required' => 'Pilihan jam / waktu mengajar wajib dipilih.',
            'jam_mengajar_custom.required_if' => 'Waktu kustom / Keterangan jam wajib diisi jika memilih waktu kustom.',
            'tanggal.required'             => 'Tanggal berlaku wajib diisi.',
            'status.required'              => 'Status pengumuman wajib dipilih.',
            'status.in'                    => 'Status pengumuman harus Aktif, Selesai, atau Arsip.',
            'keterangan.required'          => 'Keterangan / Catatan wajib diisi.',
        ]);

        $jamMengajar = '-';
        if ($request->jam_mengajar_select === 'custom') {
            if (empty(trim($request->jam_mengajar_custom))) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['jam_mengajar_custom' => 'Waktu Kustom / Keterangan Jam wajib diisi jika Anda memilih waktu kustom.']);
            }
            $jamMengajar = trim($request->jam_mengajar_custom);
        } elseif (!empty($request->jam_mengajar_select)) {
            $jamMengajar = trim($request->jam_mengajar_select);
        } elseif (!empty($request->jam_mengajar)) {
            $jamMengajar = trim($request->jam_mengajar);
        }

        $user = auth()->user();
        $guruId = $user->id_guru ?? null;

        if (!$guruId && $user && $user->nip) {
            $guruByNip = Guru::where('nip', $user->nip)->first();
            if ($guruByNip) {
                $guruId = $guruByNip->id_guru;
            }
        }

        if (!$guruId && $user) {
            $guruByName = Guru::where('nama_guru', 'like', "%{$user->name}%")->first();
            if ($guruByName) {
                $guruId = $guruByName->id_guru;
            }
        }

        if (!$guruId) {
            $guruId = Guru::first()->id_guru ?? null;
        }

        Pengumuman::create([
            'judul'        => trim($request->judul),
            'isi'          => trim($request->isi),
            'kategori'     => $request->kategori ?? 'SDM / Kepegawaian',
            'id_kelas'     => $request->id_kelas ?: null,
            'jam_mengajar' => $jamMengajar,
            'status'       => strtolower($request->status ?? 'aktif'),
            'keterangan'   => trim($request->keterangan),
            'id_guru'      => $guruId,
            'tanggal'      => $request->tanggal ?? Carbon::now('Asia/Jakarta')->toDateString(),
        ]);

        return redirect()->route('waka-sdm.pengumuman')
            ->with('success', 'Pengumuman baru berhasil dibuat dan diterbitkan oleh Waka SDM!');
    }

    /**
     * Update Pengumuman (Waka SDM)
     */
    public function updatePengumuman(Request $request, $id)
    {
        $request->validate([
            'judul'               => 'required|string|max:255',
            'isi'                 => 'required|string',
            'kategori'            => 'required|string|max:100',
            'id_kelas'            => 'nullable|integer',
            'jam_mengajar_select' => 'required|string',
            'jam_mengajar_custom' => 'required_if:jam_mengajar_select,custom|nullable|string|max:100',
            'status'              => 'required|string|in:aktif,selesai,arsip',
            'keterangan'          => 'required|string|max:255',
            'tanggal'             => 'required|date',
        ], [
            'judul.required'               => 'Judul pengumuman wajib diisi.',
            'isi.required'                 => 'Isi pengumuman wajib diisi.',
            'kategori.required'            => 'Kategori pengumuman wajib dipilih.',
            'jam_mengajar_select.required' => 'Pilihan jam / waktu mengajar wajib dipilih.',
            'jam_mengajar_custom.required_if' => 'Waktu kustom / Keterangan jam wajib diisi jika memilih waktu kustom.',
            'tanggal.required'             => 'Tanggal berlaku wajib diisi.',
            'status.required'              => 'Status pengumuman wajib dipilih.',
            'status.in'                    => 'Status pengumuman harus Aktif, Selesai, atau Arsip.',
            'keterangan.required'          => 'Keterangan / Catatan wajib diisi.',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        $jamMengajar = $pengumuman->jam_mengajar;
        if ($request->jam_mengajar_select === 'custom') {
            if (empty(trim($request->jam_mengajar_custom))) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['jam_mengajar_custom' => 'Waktu Kustom / Keterangan Jam wajib diisi jika Anda memilih waktu kustom.']);
            }
            $jamMengajar = trim($request->jam_mengajar_custom);
        } elseif (!empty($request->jam_mengajar_select)) {
            $jamMengajar = trim($request->jam_mengajar_select);
        } elseif (!empty($request->jam_mengajar)) {
            $jamMengajar = trim($request->jam_mengajar);
        }

        $pengumuman->update([
            'judul'        => trim($request->judul),
            'isi'          => trim($request->isi),
            'kategori'     => $request->kategori ?? 'SDM / Kepegawaian',
            'id_kelas'     => $request->id_kelas ?: null,
            'jam_mengajar' => $jamMengajar,
            'status'       => strtolower($request->status ?? 'aktif'),
            'keterangan'   => trim($request->keterangan),
            'tanggal'      => $request->tanggal ?? $pengumuman->tanggal,
        ]);

        return redirect()->route('waka-sdm.pengumuman')
            ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Hapus Pengumuman ke Sampah (Soft Delete - Waka SDM)
     */
    public function destroyPengumuman($id)
    {
        $pengumuman = Pengumuman::find($id);
        if ($pengumuman) {
            $pengumuman->deleted_by = Auth::id();
            $pengumuman->save();
            $pengumuman->delete();
        }

        return redirect()->route('waka-sdm.pengumuman')
            ->with('success', 'Pengumuman berhasil dipindahkan ke Sampah.');
    }

    /**
     * Pulihkan Pengumuman dari Sampah (Waka SDM)
     */
    public function restorePengumuman($id)
    {
        $pengumuman = Pengumuman::onlyTrashed()->find($id);
        if ($pengumuman) {
            $pengumuman->deleted_by = null;
            $pengumuman->save();
            $pengumuman->restore();
        }

        return redirect()->route('waka-sdm.pengumuman')
            ->with('success', 'Pengumuman berhasil dipulihkan dari Sampah.');
    }

    /**
     * Hapus Permanen Pengumuman dari Sampah (Waka SDM)
     */
    public function forceDeletePengumuman($id)
    {
        $pengumuman = Pengumuman::onlyTrashed()->find($id);
        if ($pengumuman) {
            $pengumuman->forceDelete();
        }

        return redirect()->route('waka-sdm.pengumuman')
            ->with('success', 'Pengumuman telah dihapus permanen.');
    }

    /**
     * Kosongkan Seluruh Sampah Pengumuman (Waka SDM)
     */
    public function emptyTrashPengumuman()
    {
        $trashed = Pengumuman::onlyTrashed()->where('kategori', '!=', 'Siswa Telat')->get();
        foreach ($trashed as $p) {
            $p->forceDelete();
        }

        return redirect()->route('waka-sdm.pengumuman')
            ->with('success', 'Seluruh sampah pengumuman berhasil dikosongkan.');
    }
}
