<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\JurnalMengajar;
use App\Models\JurnalDetailKetidakhadiran;
use App\Models\GuruIzin;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Ruangan;
use App\Models\JamPelajaran;
use App\Models\Pengumuman;
use App\Models\PenugasanGuruPengganti;
use App\Models\JadwalGuruPiket;
use App\Models\User;
use App\Services\JadwalPiketImportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class WakaKurikulumController extends Controller
{
    /**
     * Dashboard Waka Kurikulum
     */
    public function dashboard(Request $request = null)
    {
        // Guard pengalihan role jika pengguna adalah Waka Kesiswaan atau Waka SDM
        if (Auth::check()) {
            if (Auth::user()->isWakaKesiswaan()) {
                return redirect()->route('waka.dashboard');
            }
            if (Auth::user()->isWakaSdm()) {
                return redirect()->route('waka-sdm.dashboard');
            }
        }

        $today = Carbon::today('Asia/Jakarta');
        $todayDate = $today->toDateString();
        $hariInggris = $today->format('l');
        $mapHari = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];
        $hariIni = $mapHari[$hariInggris] ?? 'Senin';

        // 1. Statistik Kartu Metrik Utama Kurikulum
        $totalJadwal = Jadwal::count();
        $totalGuruPengajar = Jadwal::distinct('id_guru')->count('id_guru');
        if ($totalGuruPengajar === 0) {
            $totalGuruPengajar = Guru::count();
        }
        $totalMapel = Mapel::count();
        $totalKelas = Kelas::count();

        // Jadwal & Keterisian Jurnal KBM Hari Ini
        $jadwalHariIniCount = Jadwal::where('hari', $hariIni)->count();
        $jurnalHariIniCount = JurnalMengajar::whereDate('tanggal', $todayDate)->count();
        
        $persenKbmHariIni = $jadwalHariIniCount > 0 
            ? min(100, round(($jurnalHariIniCount / $jadwalHariIniCount) * 100, 1))
            : ($jurnalHariIniCount > 0 ? 100 : 0);

        // 2. Data Terhubung: Permintaan Izin Guru (Role Waka Kurikulum Approver)
        // Ambil izin yang MENUNGGU persetujuan Waka Kurikulum (pending)
        $pendingIzinList = GuruIzin::with(['guru.mapel', 'guruPiket'])
            ->where(function($q) {
                $q->where('status_waka', 'pending')
                  ->orWhereNull('status_waka');
            })
            ->orderBy('id_guru_izin', 'desc')
            ->get();

        // Riwayat Izin yang sudah pernah direspon Waka Kurikulum (approved / rejected)
        $historyIzinList = GuruIzin::with(['guru.mapel', 'guruPiket'])
            ->whereIn('status_waka', ['approved', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->take(15)
            ->get();

        // Semua Izin Aktif / Pengajuan untuk Filter Tab
        $semuaIzinList = GuruIzin::with(['guru.mapel', 'guruPiket'])
            ->orderBy('id_guru_izin', 'desc')
            ->take(30)
            ->get();

        // Hitung Metrik Perizinan Pendidik
        $totalPendingIzinWaka = $pendingIzinList->count();

        // Guru Izin Resmi Hari Ini (disetujui waka / kepsek / final)
        $guruIzinTodayRecords = GuruIzin::with(['guru.mapel'])
            ->whereDate('tanggal_mulai', '<=', $todayDate)
            ->whereDate('tanggal_selesai', '>=', $todayDate)
            ->where(function($q) {
                $q->whereIn('status_waka', ['approved', 'Disetujui'])
                  ->orWhereIn('status_kepsek', ['approved', 'Disetujui'])
                  ->orWhereIn('status_final', ['approved', 'Disetujui']);
            })
            ->get();

        $totalIzinHariIni = $guruIzinTodayRecords->count();
        $guruIzinTodayIds = $guruIzinTodayRecords->pluck('id_guru')->toArray();

        // 3. Data Terhubung: Daftar Resmi Guru Izin Tidak Hadir (Sinkron dengan Guru Piket)
        $guruIzinResmiList = GuruIzin::with(['guru.mapel', 'guruPiket'])
            ->where(function($q) {
                $q->where(function($sub) {
                    $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                        ->whereIn('status_kepsek', ['approved', 'Disetujui']);
                })->orWhereIn('status_final', ['approved', 'Disetujui']);
            })
            ->orderBy('id_guru_izin', 'desc')
            ->get();

        // Attach info status penugasan guru pengganti dari piket & masa berlaku
        $totalPerluPengganti = 0;
        $activeSubstitutionsMap = []; // [id_guru_tidak_hadir => PenugasanGuruPengganti]

        foreach ($guruIzinResmiList as $item) {
            $tglSelesai = $item->tanggal_selesai ?? $item->tanggal_mulai;
            $item->is_expired = ($tglSelesai < $todayDate);
            $item->status_masa_berlaku = $item->is_expired ? 'selesai' : 'aktif';

            // Cek Penugasan Guru Pengganti aktif oleh Piket
            $penugasans = PenugasanGuruPengganti::with('guruPengganti')
                ->where('id_guru_tidak_hadir', $item->id_guru)
                ->whereDate('tanggal', '>=', $item->tanggal_mulai)
                ->whereDate('tanggal', '<=', $item->tanggal_selesai)
                ->where('status', 'aktif')
                ->get();

            $item->has_penugasan = $penugasans->isNotEmpty();
            $item->penugasans_list = $penugasans;
            $item->nama_guru_pengganti = $penugasans->first()?->guruPengganti?->nama_guru;

            if (!$item->is_expired && !$item->has_penugasan) {
                $totalPerluPengganti++;
            }

            // Simpan penugasan aktif hari ini untuk lookup di Live Monitoring KBM
            foreach ($penugasans as $p) {
                if ($p->tanggal === $todayDate && $p->guruPengganti) {
                    $activeSubstitutionsMap[$item->id_guru] = $p->guruPengganti->nama_guru;
                }
            }
        }

        // Total Penugasan Pengganti Aktif Hari Ini oleh Piket
        $totalPenggantiAktif = PenugasanGuruPengganti::where('status', 'aktif')
            ->whereDate('tanggal', $todayDate)
            ->count();

        // 4. Live Monitoring KBM Hari Ini (Terhubung dengan Guru Pengganti & Jurnal)
        $jadwalHariIniList = Jadwal::with(['kelas', 'mapel', 'guru', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->where('hari', $hariIni)
            ->orderBy('id_jam_mulai')
            ->get();

        // ID jadwal yang sudah terisi jurnal hari ini & info siapa yang mengisi
        $jurnalTodayList = JurnalMengajar::with('guruPengganti')
            ->whereDate('tanggal', $todayDate)
            ->get();

        $jurnalTodayJadwalIds = $jurnalTodayList->pluck('id_jadwal')->toArray();
        $jurnalTodayMap = $jurnalTodayList->keyBy('id_jadwal');

        // Sematkan metadata status realtime pada setiap jadwal KBM hari ini
        foreach ($jadwalHariIniList as $j) {
            $j->is_terisi = in_array($j->id_jadwal, $jurnalTodayJadwalIds);
            $j->is_guru_izin = in_array($j->id_guru, $guruIzinTodayIds);
            $j->guru_pengganti_piket = $activeSubstitutionsMap[$j->id_guru] ?? null;
            
            if ($j->is_terisi) {
                $jrn = $jurnalTodayMap[$j->id_jadwal] ?? null;
                $j->jurnal_materi = $jrn?->materi ?? null;
                $j->jurnal_diisi_pengganti = $jrn && $jrn->id_guru_pengganti ? true : false;
                $j->jurnal_nama_pengisi = $j->jurnal_diisi_pengganti ? ($jrn->guruPengganti->nama_guru ?? 'Guru Pengganti') : ($j->guru->nama_guru ?? 'Guru Asli');
            } else {
                $j->jurnal_materi = null;
                $j->jurnal_diisi_pengganti = false;
                $j->jurnal_nama_pengisi = null;
            }
        }

        // 5. Aktivitas Jurnal Mengajar Guru Terbaru
        $jurnalTerbaruList = JurnalMengajar::with(['jadwal.guru', 'jadwal.kelas', 'jadwal.mapel', 'guruPengganti'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id_jurnal', 'desc')
            ->take(8)
            ->get();

        // 6. Grafik Capaian KBM Mingguan (Senin s/d Jumat)
        $startOfWeek = $today->copy()->startOfWeek();
        $hariLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'];
        $hariFullLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $rekapMingguan = [];

        foreach ($hariFullLabels as $idx => $namaHari) {
            $tglHari = $startOfWeek->copy()->addDays($idx)->toDateString();
            $targetSesi = Jadwal::where('hari', $namaHari)->count();
            $realisasiSesi = JurnalMengajar::whereDate('tanggal', $tglHari)->count();
            
            $rekapMingguan[] = [
                'label'      => $hariLabels[$idx],
                'full_label' => $namaHari,
                'target'     => $targetSesi,
                'realisasi'  => $realisasiSesi,
                'is_today'   => ($namaHari === $hariIni),
            ];
        }

        return view('waka_kurikulum.dashboard', compact(
            'totalJadwal',
            'totalGuruPengajar',
            'totalMapel',
            'totalKelas',
            'jadwalHariIniCount',
            'jurnalHariIniCount',
            'persenKbmHariIni',
            'hariIni',
            'todayDate',
            'pendingIzinList',
            'historyIzinList',
            'semuaIzinList',
            'totalPendingIzinWaka',
            'totalIzinHariIni',
            'totalPerluPengganti',
            'totalPenggantiAktif',
            'guruIzinResmiList',
            'jadwalHariIniList',
            'jurnalTodayJadwalIds',
            'guruIzinTodayIds',
            'jurnalTerbaruList',
            'rekapMingguan'
        ));
    }

    /**
     * [ACTION] Setujui Permintaan Izin Guru oleh Waka Kurikulum
     */
    public function approveIzin(Request $request, $id)
    {
        $izin = GuruIzin::with('guru')->findOrFail($id);
        $user = Auth::user();
        $catatan = trim($request->input('catatan', ''));
        if (empty($catatan)) {
            $catatan = 'Disetujui oleh Waka Kurikulum (' . ($user->name ?? 'Kurikulum') . ')';
        }

        $izin->status_waka = 'approved';
        $izin->catatan_waka = $catatan;

        // Evaluasi status final: jika Kepala Sekolah sudah menyetujui sebelumnya
        if ($izin->status_kepsek === 'approved') {
            $izin->status_final = 'approved';
        } elseif ($izin->status_waka_sdm === 'approved' && $izin->status_kepsek === 'approved') {
            $izin->status_final = 'approved';
        } else {
            $izin->status_final = 'pending';
        }

        $izin->save();

        $namaGuru = $izin->guru->nama_guru ?? 'Guru';
        return redirect()->back()->with('success', "Permintaan izin {$namaGuru} berhasil DISETUJUI oleh Waka Kurikulum. Data telah diteruskan ke Guru Piket dan Kepala Sekolah.");
    }

    /**
     * [ACTION] Tolak Permintaan Izin Guru oleh Waka Kurikulum
     */
    public function rejectIzin(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string|min:3|max:500'
        ], [
            'catatan.required' => 'Alasan atau catatan penolakan wajib diisi agar guru bersangkutan mendapatkan kepastian.',
            'catatan.min'      => 'Alasan penolakan minimal 3 karakter.'
        ]);

        $izin = GuruIzin::with('guru')->findOrFail($id);

        $izin->status_waka = 'rejected';
        $izin->status_final = 'rejected';
        $izin->catatan_waka = $request->catatan;
        $izin->save();

        $namaGuru = $izin->guru->nama_guru ?? 'Guru';
        return redirect()->back()->with('success', "Permintaan izin {$namaGuru} telah DITOLAK oleh Waka Kurikulum dengan catatan: {$request->catatan}");
    }

    /**
     * [ACTION] Setujui Massal (Batch Approve) Izin Guru oleh Waka Kurikulum
     */
    public function batchApproveIzin(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu pengajuan izin guru untuk disetujui secara massal.');
        }

        $user = Auth::user();
        $catatan = 'Disetujui serentak oleh Waka Kurikulum (' . ($user->name ?? 'Kurikulum') . ')';

        $updatedCount = 0;
        foreach ($ids as $id) {
            $izin = GuruIzin::find($id);
            if ($izin && ($izin->status_waka === 'pending' || empty($izin->status_waka))) {
                $izin->status_waka = 'approved';
                $izin->catatan_waka = $catatan;
                if ($izin->status_kepsek === 'approved') {
                    $izin->status_final = 'approved';
                }
                $izin->save();
                $updatedCount++;
            }
        }

        return redirect()->back()->with('success', "Sebanyak {$updatedCount} permintaan izin guru berhasil disetujui sekaligus oleh Waka Kurikulum.");
    }

    /**
     * Halaman Persetujuan Izin Guru (Waka Kurikulum)
     */
    public function persetujuanIzin(Request $request)
    {
        $activeTab    = $request->query('tab', 'pending');
        $search       = $request->query('search') ?? $request->query('q');
        $filterStatus = $request->query('status', 'all');
        $kategori     = $request->query('kategori');
        $tanggal      = $request->query('tanggal');
        $today        = Carbon::today('Asia/Jakarta')->toDateString();

        // 1. Metrik Statistik Utama Persetujuan Izin Kurikulum
        $totalPengajuan = GuruIzin::count();
        $totalPendingIzinWaka = GuruIzin::where(function($q) {
            $q->where('status_waka', 'pending')
              ->orWhereNull('status_waka');
        })->count();

        $totalIzinResmi = GuruIzin::where(function($q) {
            $q->where(function($sub) {
                $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                    ->whereIn('status_kepsek', ['approved', 'Disetujui']);
            })->orWhereIn('status_final', ['approved', 'Disetujui']);
        })->count();

        $totalHistoryWaka = GuruIzin::whereIn('status_waka', ['approved', 'rejected'])->count();

        $totalIzinHariIni = GuruIzin::whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->where(function($q) {
                $q->whereIn('status_waka', ['approved', 'Disetujui'])
                  ->orWhereIn('status_kepsek', ['approved', 'Disetujui'])
                  ->orWhereIn('status_final', ['approved', 'Disetujui']);
            })
            ->count();

        $trashedCount = GuruIzin::onlyTrashed()->count();

        // 2. Query Tab 1: Menunggu Persetujuan Waka (Pending)
        $pendingQuery = GuruIzin::with(['guru.mapel', 'guruPiket'])
            ->where(function($q) {
                $q->where('status_waka', 'pending')
                  ->orWhereNull('status_waka');
            });

        if ($search) {
            $pendingQuery->where(function($q) use ($search) {
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
            $pendingQuery->where('kategori_izin', $kategori);
        }
        if ($tanggal) {
            $pendingQuery->whereDate('tanggal_mulai', '<=', $tanggal)
                         ->whereDate('tanggal_selesai', '>=', $tanggal);
        }
        $pendingIzinList = $pendingQuery->orderBy('id_guru_izin', 'desc')->get();

        // 3. Query Tab 2: Izin Resmi Disetujui (Sinkron dengan Guru Piket & Kepsek)
        $resmiQuery = GuruIzin::with(['guru.mapel', 'guruPiket'])
            ->where(function($q) {
                $q->where(function($sub) {
                    $sub->whereIn('status_waka', ['approved', 'Disetujui'])
                        ->whereIn('status_kepsek', ['approved', 'Disetujui']);
                })->orWhereIn('status_final', ['approved', 'Disetujui']);
            });

        if ($search) {
            $resmiQuery->where(function($q) use ($search) {
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
            $resmiQuery->where('kategori_izin', $kategori);
        }
        if ($tanggal) {
            $resmiQuery->whereDate('tanggal_mulai', '<=', $tanggal)
                       ->whereDate('tanggal_selesai', '>=', $tanggal);
        }
        $guruIzinResmiList = $resmiQuery->orderBy('id_guru_izin', 'desc')->get();

        // Lampirkan data penugasan pengganti dari Guru Piket
        $totalPerluPengganti = 0;
        foreach ($guruIzinResmiList as $item) {
            $tglSelesai = $item->tanggal_selesai ?? $item->tanggal_mulai;
            $item->is_expired = ($tglSelesai < $today);
            $item->status_masa_berlaku = $item->is_expired ? 'selesai' : 'aktif';

            $penugasans = PenugasanGuruPengganti::with('guruPengganti')
                ->where('id_guru_tidak_hadir', $item->id_guru)
                ->whereDate('tanggal', '>=', $item->tanggal_mulai)
                ->whereDate('tanggal', '<=', $item->tanggal_selesai)
                ->where('status', 'aktif')
                ->get();

            $item->has_penugasan = $penugasans->isNotEmpty();
            $item->penugasans_list = $penugasans;
            $item->nama_guru_pengganti = $penugasans->first()?->guruPengganti?->nama_guru;

            if (!$item->is_expired && !$item->has_penugasan) {
                $totalPerluPengganti++;
            }
        }

        $totalPenggantiAktif = PenugasanGuruPengganti::where('status', 'aktif')
            ->whereDate('tanggal', $today)
            ->count();

        // 4. Query Tab 3: Riwayat Keputusan Waka Kurikulum (Disetujui / Ditolak)
        $historyQuery = GuruIzin::with(['guru.mapel', 'guruPiket'])
            ->whereIn('status_waka', ['approved', 'rejected']);

        if ($search) {
            $historyQuery->where(function($q) use ($search) {
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
        if ($filterStatus === 'approved') {
            $historyQuery->where('status_waka', 'approved');
        } elseif ($filterStatus === 'rejected') {
            $historyQuery->where('status_waka', 'rejected');
        }
        if ($kategori && $kategori !== 'all') {
            $historyQuery->where('kategori_izin', $kategori);
        }
        if ($tanggal) {
            $historyQuery->whereDate('tanggal_mulai', '<=', $tanggal)
                         ->whereDate('tanggal_selesai', '>=', $tanggal);
        }
        $historyIzinList = $historyQuery->orderBy('updated_at', 'desc')->get();

        // 5. Query Tab 4: Semua Pengajuan Izin
        $allQuery = GuruIzin::with(['guru.mapel', 'guruPiket']);

        if ($search) {
            $allQuery->where(function($q) use ($search) {
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
        if ($filterStatus === 'pending') {
            $allQuery->where(function($q) {
                $q->where('status_waka', 'pending')->orWhereNull('status_waka');
            });
        } elseif ($filterStatus === 'approved') {
            $allQuery->where('status_waka', 'approved');
        } elseif ($filterStatus === 'rejected') {
            $allQuery->where('status_waka', 'rejected');
        } elseif ($filterStatus === 'final_approved') {
            $allQuery->where('status_final', 'approved');
        }
        if ($kategori && $kategori !== 'all') {
            $allQuery->where('kategori_izin', $kategori);
        }
        if ($tanggal) {
            $allQuery->whereDate('tanggal_mulai', '<=', $tanggal)
                     ->whereDate('tanggal_selesai', '>=', $tanggal);
        }
        $semuaIzinList = $allQuery->orderBy('id_guru_izin', 'desc')->paginate(15)->withQueryString();

        return view('waka_kurikulum.persetujuan_izin', compact(
            'activeTab',
            'search',
            'filterStatus',
            'kategori',
            'tanggal',
            'today',
            'totalPengajuan',
            'totalPendingIzinWaka',
            'totalIzinResmi',
            'totalHistoryWaka',
            'totalIzinHariIni',
            'trashedCount',
            'totalPerluPengganti',
            'totalPenggantiAktif',
            'pendingIzinList',
            'guruIzinResmiList',
            'historyIzinList',
            'semuaIzinList'
        ));
    }

    /**
     * [ACTION] Hapus Izin Guru (Soft Delete)
     */
    public function destroyIzin($id)
    {
        $izin = GuruIzin::findOrFail($id);
        $namaGuru = $izin->guru->nama_guru ?? 'Guru';
        $izin->delete();

        return redirect()->back()->with('success', "Data pengajuan izin {$namaGuru} berhasil dipindahkan ke kotak sampah.");
    }

    /**
     * [ACTION] Hapus Massal Izin Guru (Batch Soft Delete)
     */
    public function batchDeleteIzin(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu data izin guru untuk dihapus.');
        }

        $count = GuruIzin::whereIn('id_guru_izin', $ids)->delete();

        return redirect()->back()->with('success', "Sebanyak {$count} data izin guru berhasil dipindahkan ke kotak sampah.");
    }

    /**
     * [PAGE] Kotak Sampah Izin Guru (Trash Management Waka Kurikulum)
     */
    public function trashIzin()
    {
        $trashedList = GuruIzin::onlyTrashed()
            ->with(['guru.mapel', 'guruPiket'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);

        return view('waka_kurikulum.persetujuan_izin_trash', compact('trashedList'));
    }

    /**
     * [ACTION] Pulihkan Izin Guru dari Trash
     */
    public function restoreIzin($id)
    {
        $izin = GuruIzin::onlyTrashed()->findOrFail($id);
        $namaGuru = $izin->guru->nama_guru ?? 'Guru';
        $izin->restore();

        return redirect()->route('waka-kurikulum.persetujuan-izin.trash')->with('success', "Data izin {$namaGuru} berhasil dipulihkan dari kotak sampah.");
    }

    /**
     * [ACTION] Pulihkan Massal Izin Guru dari Trash
     */
    public function batchRestoreIzin(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu data izin guru untuk dipulihkan.');
        }

        $count = GuruIzin::onlyTrashed()->whereIn('id_guru_izin', $ids)->restore();

        return redirect()->route('waka-kurikulum.persetujuan-izin.trash')->with('success', "Sebanyak {$count} data izin guru berhasil dipulihkan dari kotak sampah.");
    }

    /**
     * [ACTION] Hapus Permanen Izin Guru (Force Delete)
     */
    public function forceDeleteIzin($id)
    {
        $izin = GuruIzin::onlyTrashed()->findOrFail($id);
        $namaGuru = $izin->guru->nama_guru ?? 'Guru';
        $izin->forceDelete();

        return redirect()->route('waka-kurikulum.persetujuan-izin.trash')->with('success', "Data izin {$namaGuru} telah dihapus permanen dari sistem.");
    }

    /**
     * [ACTION] Kosongkan Kotak Sampah Izin Guru
     */
    public function emptyTrashIzin()
    {
        $count = GuruIzin::onlyTrashed()->forceDelete();

        return redirect()->route('waka-kurikulum.persetujuan-izin.trash')->with('success', "Seluruh kotak sampah perizinan guru ({$count} data) telah dikosongkan secara permanen.");
    }

    /**
     * [API/AJAX] Ambil Detail Lengkap Izin & Jadwal Terdampak dalam format JSON untuk Modal Interaktif
     */
    public function detailIzinJson($id)
    {
        $izin = GuruIzin::with(['guru.mapel', 'guruPiket'])->findOrFail($id);

        // Ambil Jadwal Mengajar Guru ini yang terdampak
        $jadwalsTerdampak = Jadwal::with(['kelas', 'mapel', 'jamMulai', 'jamSelesai', 'ruangan'])
            ->where('id_guru', $izin->id_guru)
            ->get();

        // Ambil info penugasan guru pengganti oleh piket jika ada
        $penugasan = PenugasanGuruPengganti::with('guruPengganti')
            ->where('id_guru_tidak_hadir', $izin->id_guru)
            ->whereDate('tanggal', '>=', $izin->tanggal_mulai)
            ->whereDate('tanggal', '<=', $izin->tanggal_selesai)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => [
                'id_guru_izin'        => $izin->id_guru_izin,
                'nama_guru'           => $izin->guru->nama_guru ?? '-',
                'nip'                 => $izin->guru->nip ?? '-',
                'mapel'               => $izin->guru->mapel->nama_mapel ?? '-',
                'no_hp'               => $izin->guru->no_hp ?? '-',
                'kategori_izin'       => ucfirst($izin->kategori_izin ?? 'biasa'),
                'tanggal_mulai'       => Carbon::parse($izin->tanggal_mulai)->translatedFormat('d F Y'),
                'tanggal_selesai'     => Carbon::parse($izin->tanggal_selesai)->translatedFormat('d F Y'),
                'durasi'              => $izin->durasi_formatted ?? ($izin->durasi ?? '1 Hari'),
                'alasan'              => $izin->alasan ?? '-',
                'keterangan_khusus'   => $izin->keterangan_khusus ?? '-',
                'materi_dititipkan'   => $izin->materi_dititipkan ?? '-',
                'tugas_dititipkan'    => $izin->tugas_dititipkan ?? '-',
                'file_tugas'          => $izin->file_tugas,
                'file_tugas_url'      => $izin->file_tugas_url ?? ($izin->file_tugas ? asset('uploads/tugas_pengganti/' . $izin->file_tugas) : null),
                'foto_surat'          => $izin->foto_surat,
                'foto_surat_url'      => $izin->foto_url ?? ($izin->foto_surat ? asset('uploads/guru_izin/' . $izin->foto_surat) : null),
                'token_approval'      => $izin->token_approval,
                'approval_url'        => route('approval.guru-izin.show', $izin->token_approval),
                'status_waka'         => $izin->status_waka ?? 'pending',
                'catatan_waka'        => $izin->catatan_waka ?? '-',
                'status_waka_sdm'     => $izin->status_waka_sdm ?? 'pending',
                'status_kepsek'       => $izin->status_kepsek ?? 'pending',
                'catatan_kepsek'      => $izin->catatan_kepsek ?? '-',
                'status_final'        => $izin->status_final ?? 'pending',
                'nama_guru_piket'     => $izin->guruPiket->nama_guru ?? ($izin->nama_guru_piket ?? '-'),
                'jadwals_terdampak'   => $jadwalsTerdampak->map(function($j) {
                    return [
                        'hari'        => $j->hari,
                        'kelas'       => $j->kelas->nama_kelas ?? '-',
                        'mapel'       => $j->mapel->nama_mapel ?? '-',
                        'jam_ke'      => 'Jam ke-' . ($j->jam_mulai_ke ?? '-') . ' s/d ' . ($j->jam_selesai_ke ?? '-'),
                        'waktu'       => ($j->jamMulai->waktu_mulai ?? '07:00') . ' - ' . ($j->jamSelesai->waktu_selesai ?? '08:20'),
                        'ruangan'     => $j->ruangan->nama_ruangan ?? 'Ruang Kelas',
                    ];
                }),
                'penugasan_pengganti' => $penugasan->map(function($p) {
                    return [
                        'tanggal'         => Carbon::parse($p->tanggal)->translatedFormat('d F Y'),
                        'guru_pengganti'  => $p->guruPengganti->nama_guru ?? '-',
                        'nip_pengganti'   => $p->guruPengganti->nip ?? '-',
                        'status'          => $p->status,
                    ];
                }),
            ]
        ]);
    }

    /**
     * Manajemen Jadwal Pelajaran (Role Waka Kurikulum)
     */
    public function jadwal(Request $request)
    {
        $search        = $request->query('search');
        $hariFilter    = $request->query('hari');
        $tingkatFilter = $request->query('tingkat');
        $kelasFilter   = $request->query('id_kelas');
        $guruFilter    = $request->query('id_guru');
        $mapelFilter   = $request->query('id_mapel');
        $ruanganFilter = $request->query('id_ruangan');
        $viewMode      = $request->query('view_mode', 'table');
        $selectedKelas = $request->query('selected_kelas', $kelasFilter);
        $selectedGuru  = $request->query('selected_guru', $guruFilter);

        // 1. Stat cards
        $totalJadwal         = Jadwal::count();
        $totalKelasTerjadwal = Jadwal::distinct('id_kelas')->count('id_kelas');
        $totalGuruMengajar   = Jadwal::distinct('id_guru')->count('id_guru');
        $totalRuangan        = Jadwal::distinct('id_ruangan')->count('id_ruangan');
        $trashedCount        = Jadwal::onlyTrashed()->count();

        $stats = [
            'total'             => $totalJadwal,
            'kelas_terjadwal'   => $totalKelasTerjadwal,
            'guru_mengajar'     => $totalGuruMengajar,
            'ruangan_digunakan' => $totalRuangan,
            'trashed'           => $trashedCount,
        ];

        // 2. Dropdown Lists
        $kelasList   = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $guruList    = Guru::with('mapel')->orderBy('nama_guru')->get();
        $mapelList   = Mapel::orderBy('nama_mapel')->get();
        $ruanganList = Ruangan::orderBy('nama_ruangan')->get();
        $jamList     = JamPelajaran::orderBy('jam_ke')->get();

        // 3. Query Builder for Table View
        $query = Jadwal::with(['kelas', 'mapel', 'guru', 'ruangan', 'jamMulai', 'jamSelesai']);

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->whereHas('mapel', function($m) use ($search) {
                    $m->where('nama_mapel', 'like', "%{$search}%")
                      ->orWhere('kode_mapel', 'like', "%{$search}%");
                })
                ->orWhereHas('guru', function($g) use ($search) {
                    $g->where('nama_guru', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%");
                })
                ->orWhereHas('kelas', function($k) use ($search) {
                    $k->where('nama_kelas', 'like', "%{$search}%");
                })
                ->orWhereHas('ruangan', function($r) use ($search) {
                    $r->where('nama_ruangan', 'like', "%{$search}%");
                });
            });
        }

        if (!empty($hariFilter)) {
            $query->where('hari', $hariFilter);
        }

        if (!empty($tingkatFilter)) {
            $query->whereHas('kelas', function($k) use ($tingkatFilter) {
                $k->where('tingkat', $tingkatFilter);
            });
        }

        if (!empty($kelasFilter)) {
            $query->where('id_kelas', $kelasFilter);
        }

        if (!empty($guruFilter)) {
            $query->where('id_guru', $guruFilter);
        }

        if (!empty($mapelFilter)) {
            $query->where('id_mapel', $mapelFilter);
        }

        if (!empty($ruanganFilter)) {
            $query->where('id_ruangan', $ruanganFilter);
        }

        $jadwals = $query->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('id_jam_mulai')
            ->paginate(15)
            ->withQueryString();

        // 4. Matriks Kelas View Data
        $selectedKelasObj = null;
        $matriksKelasData = [];
        $maxJamKelas      = 10;

        if ($viewMode === 'matriks_kelas') {
            if (empty($selectedKelas) && $kelasList->isNotEmpty()) {
                $selectedKelas = $kelasList->first()->id_kelas;
            }

            if (!empty($selectedKelas)) {
                $selectedKelasObj = Kelas::with('jurusan')->find($selectedKelas);
                $kelasJadwals = Jadwal::with(['mapel', 'guru', 'ruangan', 'jamMulai', 'jamSelesai'])
                    ->where('id_kelas', $selectedKelas)
                    ->get();

                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                foreach ($days as $d) {
                    $matriksKelasData[$d] = [];
                }

                foreach ($kelasJadwals as $j) {
                    $start = (int) $j->jam_mulai_ke;
                    $end   = (int) $j->jam_selesai_ke;
                    for ($jam = $start; $jam <= $end; $jam++) {
                        if (isset($matriksKelasData[$j->hari])) {
                            $matriksKelasData[$j->hari][$jam] = $j;
                        }
                    }
                }
            }
        }

        // 5. Matriks Guru View Data
        $selectedGuruObj = null;
        $matriksGuruData = [];
        $maxJamGuru      = 10;

        if ($viewMode === 'matriks_guru') {
            if (empty($selectedGuru) && $guruList->isNotEmpty()) {
                $selectedGuru = $guruList->first()->id_guru;
            }

            if (!empty($selectedGuru)) {
                $selectedGuruObj = Guru::with('mapel')->find($selectedGuru);
                $guruJadwals = Jadwal::with(['kelas', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai'])
                    ->where('id_guru', $selectedGuru)
                    ->get();

                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                foreach ($days as $d) {
                    $matriksGuruData[$d] = [];
                }

                foreach ($guruJadwals as $j) {
                    $start = (int) $j->jam_mulai_ke;
                    $end   = (int) $j->jam_selesai_ke;
                    for ($jam = $start; $jam <= $end; $jam++) {
                        if (isset($matriksGuruData[$j->hari])) {
                            $matriksGuruData[$j->hari][$jam] = $j;
                        }
                    }
                }
            }
        }

        return view('waka_kurikulum.jadwal', compact(
            'jadwals',
            'stats',
            'kelasList',
            'guruList',
            'mapelList',
            'ruanganList',
            'jamList',
            'search',
            'hariFilter',
            'tingkatFilter',
            'kelasFilter',
            'guruFilter',
            'mapelFilter',
            'ruanganFilter',
            'viewMode',
            'selectedKelas',
            'selectedGuru',
            'selectedKelasObj',
            'selectedGuruObj',
            'matriksKelasData',
            'matriksGuruData',
            'maxJamKelas',
            'maxJamGuru'
        ));
    }

    /**
     * Tambah Jadwal Pelajaran Baru (Waka Kurikulum)
     */
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'id_kelas'       => 'required|exists:kelas,id_kelas',
            'id_guru'        => 'required|exists:guru,id_guru',
            'id_mapel'       => 'required|exists:mapel,id_mapel',
            'id_ruangan'     => 'nullable|exists:ruangan,id_ruangan',
            'hari'           => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'id_jam_mulai'   => 'required|exists:jam_pelajaran,id_jam',
            'id_jam_selesai' => 'required|exists:jam_pelajaran,id_jam',
        ]);

        $jamMulai = JamPelajaran::find($request->id_jam_mulai);
        $jamSelesai = JamPelajaran::find($request->id_jam_selesai);

        if ((int)$jamMulai->jam_ke > (int)$jamSelesai->jam_ke) {
            return back()->withInput()->with('error', 'Jam selesai tidak boleh lebih awal dari jam mulai.');
        }

        // Cek Bentrok Guru di Hari & Jam yang Sama
        $bentrokGuru = Jadwal::where('hari', $request->hari)
            ->where('id_guru', $request->id_guru)
            ->where(function($q) use ($jamMulai, $jamSelesai) {
                $q->whereBetween('id_jam_mulai', [$jamMulai->id_jam, $jamSelesai->id_jam])
                  ->orWhereBetween('id_jam_selesai', [$jamMulai->id_jam, $jamSelesai->id_jam]);
            })->exists();

        if ($bentrokGuru) {
            return back()->withInput()->with('error', 'Guru yang bersangkutan sudah memiliki jadwal mengajar di kelas lain pada hari dan jam tersebut.');
        }

        // Cek Bentrok Kelas di Hari & Jam yang Sama
        $bentrokKelas = Jadwal::where('hari', $request->hari)
            ->where('id_kelas', $request->id_kelas)
            ->where(function($q) use ($jamMulai, $jamSelesai) {
                $q->whereBetween('id_jam_mulai', [$jamMulai->id_jam, $jamSelesai->id_jam])
                  ->orWhereBetween('id_jam_selesai', [$jamMulai->id_jam, $jamSelesai->id_jam]);
            })->exists();

        if ($bentrokKelas) {
            return back()->withInput()->with('error', 'Kelas ini sudah memiliki jadwal mata pelajaran lain pada hari dan jam tersebut.');
        }

        Jadwal::create([
            'id_kelas'       => $request->id_kelas,
            'id_guru'        => $request->id_guru,
            'id_mapel'       => $request->id_mapel,
            'id_ruangan'     => $request->id_ruangan,
            'hari'           => $request->hari,
            'id_jam_mulai'   => $request->id_jam_mulai,
            'id_jam_selesai' => $request->id_jam_selesai,
        ]);

        return redirect()->route('waka-kurikulum.jadwal')->with('success', 'Jadwal pelajaran berhasil ditambahkan ke sistem kurikulum.');
    }

    /**
     * Input Batch Jadwal Pelajaran (Waka Kurikulum)
     */
    public function storeBatchJadwal(Request $request)
    {
        $rows = $request->input('jadwals', []);
        if (empty($rows) || !is_array($rows)) {
            return back()->with('error', 'Data input batch jadwal kosong.');
        }

        $berhasil = 0;
        $gagal = 0;

        foreach ($rows as $row) {
            if (empty($row['id_kelas']) || empty($row['id_guru']) || empty($row['id_mapel']) || empty($row['hari']) || empty($row['id_jam_mulai']) || empty($row['id_jam_selesai'])) {
                continue;
            }

            try {
                Jadwal::create([
                    'id_kelas'       => $row['id_kelas'],
                    'id_guru'        => $row['id_guru'],
                    'id_mapel'       => $row['id_mapel'],
                    'id_ruangan'     => $row['id_ruangan'] ?? null,
                    'hari'           => $row['hari'],
                    'id_jam_mulai'   => $row['id_jam_mulai'],
                    'id_jam_selesai' => $row['id_jam_selesai'],
                ]);
                $berhasil++;
            } catch (\Exception $e) {
                $gagal++;
            }
        }

        return redirect()->route('waka-kurikulum.jadwal')->with('success', "Proses input batch selesai. {$berhasil} jadwal berhasil disimpan" . ($gagal > 0 ? ", {$gagal} jadwal dilewati." : "."));
    }

    /**
     * Perbarui Data Jadwal Pelajaran (Waka Kurikulum)
     */
    public function updateJadwal(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'id_kelas'       => 'required|exists:kelas,id_kelas',
            'id_guru'        => 'required|exists:guru,id_guru',
            'id_mapel'       => 'required|exists:mapel,id_mapel',
            'id_ruangan'     => 'nullable|exists:ruangan,id_ruangan',
            'hari'           => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'id_jam_mulai'   => 'required|exists:jam_pelajaran,id_jam',
            'id_jam_selesai' => 'required|exists:jam_pelajaran,id_jam',
        ]);

        $jamMulai = JamPelajaran::find($request->id_jam_mulai);
        $jamSelesai = JamPelajaran::find($request->id_jam_selesai);

        if ((int)$jamMulai->jam_ke > (int)$jamSelesai->jam_ke) {
            return back()->withInput()->with('error', 'Jam selesai tidak boleh lebih awal dari jam mulai.');
        }

        $jadwal->update([
            'id_kelas'       => $request->id_kelas,
            'id_guru'        => $request->id_guru,
            'id_mapel'       => $request->id_mapel,
            'id_ruangan'     => $request->id_ruangan,
            'hari'           => $request->hari,
            'id_jam_mulai'   => $request->id_jam_mulai,
            'id_jam_selesai' => $request->id_jam_selesai,
        ]);

        return redirect()->route('waka-kurikulum.jadwal')->with('success', 'Data jadwal pelajaran berhasil diperbarui.');
    }

    /**
     * Hapus Jadwal (Soft Delete)
     */
    public function destroyJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('waka-kurikulum.jadwal')->with('success', 'Jadwal pelajaran berhasil dipindahkan ke kotak sampah.');
    }

    /**
     * Batch Delete Jadwal
     */
    public function batchDeleteJadwal(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (!empty($ids)) {
            Jadwal::whereIn('id_jadwal', $ids)->delete();
            return redirect()->route('waka-kurikulum.jadwal')->with('success', count($ids) . ' jadwal pelajaran berhasil dipindahkan ke kotak sampah.');
        }

        return back()->with('error', 'Tidak ada jadwal yang dipilih.');
    }

    /**
     * Kotak Sampah Jadwal (Trash)
     */
    public function trashJadwal()
    {
        $trashedJadwals = Jadwal::onlyTrashed()
            ->with(['kelas', 'mapel', 'guru', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);

        return view('waka_kurikulum.jadwal_trash', compact('trashedJadwals'));
    }

    /**
     * Restore Jadwal
     */
    public function restoreJadwal($id)
    {
        $jadwal = Jadwal::onlyTrashed()->findOrFail($id);
        $jadwal->restore();

        return redirect()->route('waka-kurikulum.jadwal.trash')->with('success', 'Jadwal pelajaran berhasil dipulihkan.');
    }

    /**
     * Batch Restore Jadwal
     */
    public function batchRestoreJadwal(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (!empty($ids)) {
            Jadwal::onlyTrashed()->whereIn('id_jadwal', $ids)->restore();
            return redirect()->route('waka-kurikulum.jadwal.trash')->with('success', count($ids) . ' jadwal pelajaran berhasil dipulihkan.');
        }

        return back()->with('error', 'Tidak ada jadwal yang dipilih.');
    }

    /**
     * Force Delete Jadwal
     */
    public function forceDeleteJadwal($id)
    {
        $jadwal = Jadwal::onlyTrashed()->findOrFail($id);
        $jadwal->forceDelete();

        return redirect()->route('waka-kurikulum.jadwal.trash')->with('success', 'Jadwal pelajaran telah dihapus secara permanen.');
    }

    /**
     * Kosongkan Seluruh Kotak Sampah Jadwal
     */
    public function emptyTrashJadwal()
    {
        Jadwal::onlyTrashed()->forceDelete();

        return redirect()->route('waka-kurikulum.jadwal.trash')->with('success', 'Seluruh kotak sampah jadwal pelajaran telah dikosongkan.');
    }

    /**
     * Export CSV Jadwal Pelajaran
     */
    public function exportJadwalCsv(Request $request)
    {
        $query = Jadwal::with(['kelas', 'mapel', 'guru', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('id_jam_mulai');

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }
        if ($request->filled('id_kelas')) {
            $query->where('id_kelas', $request->id_kelas);
        }
        if ($request->filled('id_guru')) {
            $query->where('id_guru', $request->id_guru);
        }

        $data = $query->get();

        $filename = 'Jadwal_Pelajaran_Kurikulum_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // BOM UTF-8

            fputcsv($file, ['No', 'Hari', 'Jam Ke', 'Waktu KBM', 'Kelas', 'Mata Pelajaran', 'Kode Mapel', 'Guru Pengampu', 'NIP Guru', 'Ruangan']);

            $no = 1;
            foreach ($data as $item) {
                $jamStr = 'Jam ke-' . ($item->jamMulai->jam_ke ?? '-') . ' s/d ' . ($item->jamSelesai->jam_ke ?? '-');
                $waktuStr = ($item->jamMulai->jam_mulai ?? '-') . ' - ' . ($item->jamSelesai->jam_selesai ?? '-') . ' WIB';

                fputcsv($file, [
                    $no++,
                    $item->hari,
                    $jamStr,
                    $waktuStr,
                    $item->kelas->nama_kelas ?? '-',
                    $item->mapel->nama_mapel ?? '-',
                    $item->mapel->kode_mapel ?? '-',
                    $item->guru->nama_guru ?? '-',
                    $item->guru->nip ?? '-',
                    $item->ruangan->nama_ruangan ?? 'Kelas Reguler',
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Cetak Jadwal Pelajaran Umum
     */
    public function printJadwal(Request $request)
    {
        $query = Jadwal::with(['kelas', 'mapel', 'guru', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('id_jam_mulai');

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }
        if ($request->filled('id_kelas')) {
            $query->where('id_kelas', $request->id_kelas);
        }
        if ($request->filled('id_guru')) {
            $query->where('id_guru', $request->id_guru);
        }

        $jadwals = $query->get();

        return view('waka.jadwal_print', compact('jadwals'));
    }

    /**
     * Cetak Jadwal Per Kelas
     */
    public function printJadwalKelas($id)
    {
        $kelas = Kelas::with('jurusan')->findOrFail($id);
        $jadwals = Jadwal::with(['mapel', 'guru', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->where('id_kelas', $id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('id_jam_mulai')
            ->get();

        return view('waka.jadwal_print_kelas', compact('kelas', 'jadwals'));
    }

    /**
     * Direktori Mata Pelajaran Kurikulum (Waka Kurikulum)
     */
    public function mapel(Request $request)
    {
        $search = $request->query('search');
        $query = Mapel::query();

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nama_mapel', 'like', "%{$search}%")
                  ->orWhere('kode_mapel', 'like', "%{$search}%")
                  ->orWhere('kelompok', 'like', "%{$search}%");
            });
        }

        $totalMapel = Mapel::count();
        $totalJadwal = Jadwal::count();
        $mapelList = $query->orderBy('nama_mapel')->paginate(15)->withQueryString();

        return view('waka_kurikulum.mapel', compact('mapelList', 'totalMapel', 'totalJadwal', 'search'));
    }

    /**
     * Monitoring & Rekap Jurnal Mengajar KBM (Waka Kurikulum)
     */
    public function rekapJurnal(Request $request)
    {
        $search         = $request->query('search') ?? $request->query('q');
        $tanggal        = $request->query('tanggal');
        $tanggalMulai   = $request->query('tanggal_mulai');
        $tanggalSelesai = $request->query('tanggal_selesai');
        $idKelas        = $request->query('id_kelas');
        $idGuru         = $request->query('id_guru');
        $idMapel        = $request->query('id_mapel');
        $statusPiket    = $request->query('status_piket');

        $today = Carbon::today('Asia/Jakarta')->toDateString();

        // 1. Statistik Cards
        $totalJurnal         = JurnalMengajar::count();
        $todayJurnal         = JurnalMengajar::whereDate('tanggal', $today)->count();
        $totalKetidakhadiran = JurnalDetailKetidakhadiran::count();
        $kondusifCount       = JurnalMengajar::where('kondisi_kelas', 'like', '%Kondusif%')->count();
        $kondusifPercentage  = $totalJurnal > 0 ? round(($kondusifCount / $totalJurnal) * 100) : 100;

        $stats = [
            'total'               => $totalJurnal,
            'today'               => $todayJurnal,
            'total_absen'         => $totalKetidakhadiran,
            'kondusif_persen'     => $kondusifPercentage,
        ];

        // 2. Dropdown Lists
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $guruList  = Guru::with('mapel')->orderBy('nama_guru')->get();
        $mapelList = Mapel::orderBy('nama_mapel')->get();

        // 3. Query Builder
        $query = JurnalMengajar::with([
            'jadwal.guru',
            'jadwal.kelas.jurusan',
            'jadwal.mapel',
            'jadwal.ruangan',
            'jadwal.jamMulai',
            'jadwal.jamSelesai',
            'guruPengganti',
            'detailKetidakhadiran'
        ]);

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('materi', 'like', "%{$search}%")
                  ->orWhere('catatan', 'like', "%{$search}%")
                  ->orWhereHas('jadwal.guru', function($g) use ($search) {
                      $g->where('nama_guru', 'like', "%{$search}%");
                  })
                  ->orWhereHas('jadwal.mapel', function($m) use ($search) {
                      $m->where('nama_mapel', 'like', "%{$search}%");
                  })
                  ->orWhereHas('jadwal.kelas', function($k) use ($search) {
                      $k->where('nama_kelas', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($tanggal)) {
            $query->whereDate('tanggal', $tanggal);
        }

        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            $query->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        }

        if (!empty($idKelas)) {
            $query->whereHas('jadwal', function($q) use ($idKelas) {
                $q->where('id_kelas', $idKelas);
            });
        }

        if (!empty($idGuru)) {
            $query->whereHas('jadwal', function($q) use ($idGuru) {
                $q->where('id_guru', $idGuru);
            });
        }

        if (!empty($idMapel)) {
            $query->whereHas('jadwal', function($q) use ($idMapel) {
                $q->where('id_mapel', $idMapel);
            });
        }

        $jurnalList = $query->orderBy('tanggal', 'desc')
            ->orderBy('id_jurnal', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('waka_kurikulum.rekap_jurnal', compact(
            'jurnalList',
            'stats',
            'kelasList',
            'guruList',
            'mapelList',
            'search',
            'tanggal',
            'tanggalMulai',
            'tanggalSelesai',
            'idKelas',
            'idGuru',
            'idMapel',
            'statusPiket'
        ));
    }

    /**
     * Detail Jurnal Mengajar (Modal JSON)
     */
    public function detailRekapJurnalJson($id)
    {
        $jurnal = JurnalMengajar::with([
            'jadwal.guru',
            'jadwal.kelas.jurusan',
            'jadwal.mapel',
            'jadwal.ruangan',
            'jadwal.jamMulai',
            'jadwal.jamSelesai',
            'guruPengganti',
            'detailKetidakhadiran.siswa.kelas'
        ])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => [
                'id_jurnal'       => $jurnal->id_jurnal,
                'tanggal'         => $jurnal->tanggal ? Carbon::parse($jurnal->tanggal)->translatedFormat('l, d F Y') : '-',
                'tanggal_raw'     => $jurnal->tanggal,
                'hari'            => $jurnal->jadwal->hari ?? Carbon::parse($jurnal->tanggal)->translatedFormat('l'),
                'jam_pelajaran'   => 'Jam ke-' . ($jurnal->jadwal->jam_mulai_ke ?? '-') . ' s/d ' . ($jurnal->jadwal->jam_selesai_ke ?? '-'),
                'guru_pengajar'   => $jurnal->jadwal->guru->nama_guru ?? '-',
                'nip_guru'        => $jurnal->jadwal->guru->nip ?? '-',
                'guru_pengganti'  => $jurnal->guruPengganti->nama_guru ?? null,
                'nip_pengganti'   => $jurnal->guruPengganti->nip ?? null,
                'mata_pelajaran'  => $jurnal->jadwal->mapel->nama_mapel ?? '-',
                'kode_mapel'      => $jurnal->jadwal->mapel->kode_mapel ?? '-',
                'kelas'           => $jurnal->jadwal->kelas->nama_kelas ?? '-',
                'ruangan'         => $jurnal->jadwal->ruangan->nama_ruangan ?? 'Kelas Reguler',
                'materi'          => $jurnal->materi ?? '-',
                'kegiatan'        => $jurnal->catatan ?? '-',
                'kondisi_kelas'   => $jurnal->kondisi_kelas ?? 'Kondusif',
                'status_jurnal'   => ($jurnal->is_draft == 1) ? 'Draft' : 'Selesai',
                'status_guru'     => ucfirst($jurnal->status_kehadiran_guru ?? 'Hadir'),
                'ketidakhadiran'  => $jurnal->detailKetidakhadiran->map(function($d) {
                    return [
                        'nama_siswa' => $d->siswa->nama_siswa ?? 'Siswa',
                        'nis'        => $d->siswa->nis ?? '-',
                        'status'     => strtoupper($d->status ?? 'A'),
                        'keterangan' => $d->keterangan ?? '-',
                    ];
                }),
            ]
        ]);
    }

    /**
     * Export CSV Rekap Jurnal Mengajar
     */
    public function exportRekapJurnal(Request $request)
    {
        $query = JurnalMengajar::with([
            'jadwal.guru',
            'jadwal.kelas',
            'jadwal.mapel',
            'jadwal.ruangan',
            'jadwal.jamMulai',
            'jadwal.jamSelesai',
            'guruPengganti',
        ])->orderBy('tanggal', 'desc');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->filled('id_kelas')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('id_kelas', $request->id_kelas);
            });
        }
        if ($request->filled('id_guru')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('id_guru', $request->id_guru);
            });
        }

        $data = $query->get();

        $filename = 'Rekap_Jurnal_Mengajar_Kurikulum_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, ['No', 'Tanggal', 'Jam Ke', 'Kelas', 'Mata Pelajaran', 'Guru Pengajar', 'Guru Pengganti', 'Materi Pembelajaran', 'Kondisi Kelas', 'Status Kehadiran Guru', 'Status Jurnal']);

            $no = 1;
            foreach ($data as $item) {
                $jamStr = 'Jam ke-' . ($item->jadwal->jam_mulai_ke ?? '-') . ' s/d ' . ($item->jadwal->jam_selesai_ke ?? '-');

                fputcsv($file, [
                    $no++,
                    $item->tanggal,
                    $jamStr,
                    $item->jadwal->kelas->nama_kelas ?? '-',
                    $item->jadwal->mapel->nama_mapel ?? '-',
                    $item->jadwal->guru->nama_guru ?? '-',
                    $item->guruPengganti->nama_guru ?? '-',
                    $item->materi ?? '-',
                    $item->kondisi_kelas ?? 'Kondusif',
                    ucfirst($item->status_kehadiran_guru ?? 'Hadir'),
                    ($item->is_draft == 1) ? 'Draft' : 'Selesai',
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Cetak Rekap Jurnal Mengajar
     */
    public function printRekapJurnal(Request $request)
    {
        $query = JurnalMengajar::with([
            'jadwal.guru',
            'jadwal.kelas',
            'jadwal.mapel',
            'jadwal.ruangan',
            'jadwal.jamMulai',
            'jadwal.jamSelesai',
            'guruPengganti',
        ])->orderBy('tanggal', 'desc');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->filled('id_kelas')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('id_kelas', $request->id_kelas);
            });
        }
        if ($request->filled('id_guru')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('id_guru', $request->id_guru);
            });
        }

        $jurnals = $query->get();
        $waka = Guru::where('nip', Auth::user()->nip)->first() 
             ?? Guru::where('nama_guru', Auth::user()->name)->first();

        return view('waka_kurikulum.rekap_jurnal_print', compact('jurnals', 'waka'));
    }

    /**
     * Pengumuman Kurikulum & Akademik
     */
    public function pengumuman(Request $request)
    {
        $search   = $request->query('search');
        $kategori = $request->query('kategori');
        $status   = $request->query('status');

        $query = Pengumuman::with(['pembuat', 'kelas', 'reads.user'])
            ->where(function($q) {
                $q->whereNull('kategori')
                  ->orWhereNotIn('kategori', ['Siswa Telat', 'siswa telat', 'siswa_telat']);
            })
            ->where('judul', 'not like', '%Pemberitahuan Siswa Terlambat%');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        if (!empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $pengumumanList = $query->orderBy('tanggal', 'desc')
            ->orderBy('id_pengumuman', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Statistics (excluding Siswa Telat)
        $baseCountQuery = Pengumuman::where(function($q) {
                $q->whereNull('kategori')
                  ->orWhereNotIn('kategori', ['Siswa Telat', 'siswa telat', 'siswa_telat']);
            })
            ->where('judul', 'not like', '%Pemberitahuan Siswa Terlambat%');

        $totalCount   = (clone $baseCountQuery)->count();
        $activeCount  = (clone $baseCountQuery)->where('status', 'aktif')->count();
        $selesaiCount = (clone $baseCountQuery)->where('status', 'selesai')->count();

        $baseTrashedQuery = Pengumuman::onlyTrashed()
            ->where(function($q) {
                $q->whereNull('kategori')
                  ->orWhereNotIn('kategori', ['Siswa Telat', 'siswa telat', 'siswa_telat']);
            })
            ->where('judul', 'not like', '%Pemberitahuan Siswa Terlambat%');

        $trashedCount = (clone $baseTrashedQuery)->count();
        $trashedList  = (clone $baseTrashedQuery)->with('pembuat')->orderBy('deleted_at', 'desc')->get();

        return view('waka_kurikulum.pengumuman', compact(
            'pengumumanList',
            'totalCount',
            'activeCount',
            'selesaiCount',
            'trashedCount',
            'trashedList',
            'search',
            'kategori',
            'status'
        ));
    }

    /**
     * Simpan Pengumuman Kurikulum
     */
    public function storePengumuman(Request $request)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'isi'        => 'required|string',
            'kategori'   => 'required|string|max:50',
            'tanggal'    => 'required|date',
            'status'     => 'required|in:aktif,selesai',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Cari ID guru dari akun pengguna yang login
        $guru = Guru::where('nip', Auth::user()->nip)->first() 
             ?? Guru::where('nama_guru', Auth::user()->name)->first();
        $guruId = $guru ? $guru->id_guru : (Auth::user()->id_guru ?? null);

        Pengumuman::create([
            'judul'      => $request->judul,
            'isi'        => $request->isi,
            'kategori'   => $request->kategori,
            'tanggal'    => $request->tanggal,
            'status'     => $request->status,
            'keterangan' => $request->keterangan ?? 'Waka Kurikulum',
            'id_guru'    => $guruId,
        ]);

        return redirect()->route('waka-kurikulum.pengumuman')->with('success', 'Pengumuman kurikulum berhasil dipublikasikan.');
    }

    /**
     * Detail Pengumuman JSON (untuk Modal AJAX)
     */
    public function detailPengumumanJson($id)
    {
        $pengumuman = Pengumuman::withTrashed()->with(['pembuat', 'kelas', 'reads.user'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => [
                'id_pengumuman' => $pengumuman->id_pengumuman,
                'judul'         => $pengumuman->judul,
                'isi'           => $pengumuman->isi,
                'kategori'      => $pengumuman->kategori ?? 'Umum',
                'status'        => $pengumuman->status ?? 'aktif',
                'tanggal'       => $pengumuman->tanggal ? Carbon::parse($pengumuman->tanggal)->translatedFormat('d F Y') : '-',
                'tanggal_raw'   => $pengumuman->tanggal ? Carbon::parse($pengumuman->tanggal)->format('Y-m-d') : date('Y-m-d'),
                'created_at'    => $pengumuman->created_at ? $pengumuman->created_at->format('d/m/Y H:i') : '-',
                'pembuat_nama'  => $pengumuman->pembuat->nama_guru ?? ($pengumuman->keterangan ?? 'Waka Kurikulum'),
                'pembuat_nip'   => $pengumuman->pembuat->nip ?? '-',
                'keterangan'    => $pengumuman->keterangan ?? '-',
                'total_dibaca'  => $pengumuman->reads->count(),
                'reads_users'   => $pengumuman->reads->map(function($r) {
                    return [
                        'user_name' => $r->user->name ?? 'Pengguna',
                        'read_at'   => $r->read_at ? Carbon::parse($r->read_at)->format('d/m/Y H:i') : ($r->created_at ? $r->created_at->format('d/m/Y H:i') : '-'),
                    ];
                }),
                'is_trashed'    => $pengumuman->trashed(),
            ]
        ]);
    }

    /**
     * Perbarui Pengumuman Kurikulum
     */
    public function updatePengumuman(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $request->validate([
            'judul'      => 'required|string|max:255',
            'isi'        => 'required|string',
            'kategori'   => 'required|string|max:50',
            'tanggal'    => 'required|date',
            'status'     => 'required|in:aktif,selesai',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $pengumuman->update([
            'judul'      => $request->judul,
            'isi'        => $request->isi,
            'kategori'   => $request->kategori,
            'tanggal'    => $request->tanggal,
            'status'     => $request->status,
            'keterangan' => $request->keterangan ?? $pengumuman->keterangan,
        ]);

        return redirect()->route('waka-kurikulum.pengumuman')->with('success', 'Pengumuman kurikulum berhasil diperbarui.');
    }

    /**
     * Hapus Pengumuman Kurikulum (Soft Delete)
     */
    public function destroyPengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('waka-kurikulum.pengumuman')->with('success', 'Pengumuman berhasil dipindahkan ke kotak sampah.');
    }

    /**
     * Batch Delete Pengumuman
     */
    public function batchDeletePengumuman(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (!empty($ids)) {
            Pengumuman::whereIn('id_pengumuman', $ids)->delete();
            return redirect()->route('waka-kurikulum.pengumuman')->with('success', count($ids) . ' pengumuman berhasil dipindahkan ke kotak sampah.');
        }

        return redirect()->route('waka-kurikulum.pengumuman')->with('error', 'Tidak ada pengumuman yang dipilih.');
    }

    /**
     * Restore Pengumuman Kurikulum
     */
    public function restorePengumuman($id)
    {
        $pengumuman = Pengumuman::onlyTrashed()->findOrFail($id);
        $pengumuman->restore();

        return redirect()->route('waka-kurikulum.pengumuman')->with('success', 'Pengumuman berhasil dipulihkan.');
    }

    /**
     * Batch Restore Pengumuman
     */
    public function batchRestorePengumuman(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (!empty($ids)) {
            Pengumuman::onlyTrashed()->whereIn('id_pengumuman', $ids)->restore();
            return redirect()->route('waka-kurikulum.pengumuman')->with('success', count($ids) . ' pengumuman berhasil dipulihkan dari kotak sampah.');
        }

        return redirect()->route('waka-kurikulum.pengumuman')->with('error', 'Tidak ada pengumuman yang dipilih.');
    }

    /**
     * Force Delete Pengumuman Kurikulum
     */
    public function forceDeletePengumuman($id)
    {
        $pengumuman = Pengumuman::onlyTrashed()->findOrFail($id);
        $pengumuman->forceDelete();

        return redirect()->route('waka-kurikulum.pengumuman')->with('success', 'Pengumuman telah dihapus secara permanen.');
    }

    /**
     * Kosongkan Kotak Sampah Pengumuman Kurikulum
     */
    /**
     * Kosongkan Kotak Sampah Pengumuman Kurikulum
     */
    public function emptyTrashPengumuman()
    {
        Pengumuman::onlyTrashed()->forceDelete();

        return redirect()->route('waka-kurikulum.pengumuman')->with('success', 'Seluruh kotak sampah pengumuman telah dibersihkan.');
    }

    /**
     * Halaman Alokasi Jam Pelajaran (Waka Kurikulum)
     */
    public function jamPelajaran(Request $request)
    {
        $search = $request->query('search');
        $query  = JamPelajaran::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('jam_ke', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhere('jam_mulai', 'like', "%{$search}%")
                  ->orWhere('jam_selesai', 'like', "%{$search}%")
                  ->orWhere('jam_mulai_jumat', 'like', "%{$search}%")
                  ->orWhere('jam_selesai_jumat', 'like', "%{$search}%");
            });
        }

        $jamList      = $query->orderBy('id_jam', 'asc')->get();
        $totalJam     = JamPelajaran::count();
        $trashedCount = JamPelajaran::onlyTrashed()->count();

        // Hitung statistik alokasi KBM
        $totalSesiSeninKamis = JamPelajaran::whereNotNull('jam_mulai')->count();
        $totalSesiJumat      = JamPelajaran::whereNotNull('jam_mulai_jumat')->count();

        return view('waka_kurikulum.jam_pelajaran', compact(
            'jamList',
            'search',
            'totalJam',
            'trashedCount',
            'totalSesiSeninKamis',
            'totalSesiJumat'
        ));
    }

    /**
     * Perbarui Alokasi Jam Pelajaran (Waka Kurikulum)
     */
    public function updateJamPelajaran(Request $request, $id)
    {
        $jam = JamPelajaran::findOrFail($id);

        $request->validate([
            'jam_mulai'         => 'nullable|string',
            'jam_selesai'       => 'nullable|string',
            'jam_mulai_jumat'   => 'nullable|string',
            'jam_selesai_jumat' => 'nullable|string',
            'keterangan'        => 'nullable|string|max:255',
        ]);

        $jam->update([
            'jam_mulai'         => $request->jam_mulai ? trim($request->jam_mulai) : null,
            'jam_selesai'       => $request->jam_selesai ? trim($request->jam_selesai) : null,
            'jam_mulai_jumat'   => $request->jam_mulai_jumat ? trim($request->jam_mulai_jumat) : null,
            'jam_selesai_jumat' => $request->jam_selesai_jumat ? trim($request->jam_selesai_jumat) : null,
            'keterangan'        => $request->keterangan ? trim($request->keterangan) : null,
        ]);

        return redirect()->route('waka-kurikulum.jam-pelajaran')->with('success', "Alokasi Jam Pelajaran {$jam->jam_ke} berhasil diperbarui.");
    }

    /**
     * Export CSV Alokasi Jam Pelajaran
     */
    public function exportJamPelajaranCsv()
    {
        $fileName = 'alokasi_jam_pelajaran_smkn1boyolangu_' . date('Y-m-d') . '.csv';
        $jamList = JamPelajaran::orderBy('id_jam', 'asc')->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($jamList) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['No', 'Label Sesi Jam', 'Waktu Senin - Kamis', 'Waktu Jumat', 'Keterangan']);

            foreach ($jamList as $idx => $item) {
                $waktuSK = ($item->jam_mulai && $item->jam_selesai) 
                    ? substr($item->jam_mulai, 0, 5) . ' - ' . substr($item->jam_selesai, 0, 5) . ' WIB'
                    : '-';
                $waktuJum = ($item->jam_mulai_jumat && $item->jam_selesai_jumat) 
                    ? substr($item->jam_mulai_jumat, 0, 5) . ' - ' . substr($item->jam_selesai_jumat, 0, 5) . ' WIB'
                    : '-';

                fputcsv($file, [
                    $idx + 1,
                    $item->jam_ke,
                    $waktuSK,
                    $waktuJum,
                    $item->keterangan ?? '-'
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Cetak Printable Alokasi Jam Pelajaran
     */
    public function printJamPelajaran()
    {
        $jamList = JamPelajaran::orderBy('id_jam', 'asc')->get();

        return view('waka_kurikulum.print_jam_pelajaran', compact('jamList'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // MANAJEMEN JADWAL GURU PIKET (WAKA KURIKULUM)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Halaman Utama Penjadwalan Guru Piket Bulanan
     */
    public function jadwalPiket(Request $request)
    {
        $selectedBulan = (int) ($request->query('bulan') ?? Carbon::now('Asia/Jakarta')->format('n'));
        $selectedTahun = (int) ($request->query('tahun') ?? Carbon::now('Asia/Jakarta')->format('Y'));

        if ($selectedBulan < 1 || $selectedBulan > 12) {
            $selectedBulan = (int) Carbon::now('Asia/Jakarta')->format('n');
        }
        if ($selectedTahun < 2020 || $selectedTahun > 2035) {
            $selectedTahun = (int) Carbon::now('Asia/Jakarta')->format('Y');
        }

        $daftarBulan = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $mapHariIndo = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        // Buat daftar tanggal kerja (Senin s.d Jumat) pada bulan & tahun terpilih
        $daysInMonth = Carbon::createFromDate($selectedTahun, $selectedBulan, 1, 'Asia/Jakarta')->daysInMonth;
        $workDays = [];

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $cDate = Carbon::createFromDate($selectedTahun, $selectedBulan, $d, 'Asia/Jakarta');
            // Libur hari Sabtu dan Minggu (kecualikan)
            if ($cDate->dayOfWeek !== Carbon::SATURDAY && $cDate->dayOfWeek !== Carbon::SUNDAY) {
                $workDays[] = [
                    'tanggal'        => $cDate->format('Y-m-d'),
                    'hari'           => $mapHariIndo[$cDate->format('l')] ?? '',
                    'tanggal_format' => $cDate->format('d/m/Y'),
                    'tanggal_indo'   => $cDate->format('j') . ' ' . ($daftarBulan[$selectedBulan] ?? '') . ' ' . $selectedTahun,
                    'day_num'        => $d,
                ];
            }
        }

        // Ambil matriks jadwal yang sudah tersimpan di database: [tanggal][slot_ke] => id_guru, nama_guru, nip
        $jadwalMatrix = JadwalGuruPiket::getJadwalBulan($selectedBulan, $selectedTahun);

        // Ambil seluruh guru aktif (seluruh role guru: guru mengajar atau wali kelas)
        $gurus = Guru::with(['mapel', 'user'])
            ->where(function($q) {
                $q->where('is_active', true)->orWhereNull('is_active');
            })
            ->orderBy('nama_guru', 'asc')
            ->get();

        // Hitung statistik keterisian
        $totalHariKerja = count($workDays);
        $totalSlotTersedia = $totalHariKerja * 8;
        $totalSlotTerisi = 0;
        $guruTerlibatIds = [];

        foreach ($workDays as $wd) {
            $tgl = $wd['tanggal'];
            for ($s = 1; $s <= 8; $s++) {
                if (!empty($jadwalMatrix[$tgl][$s]['id_guru'])) {
                    $totalSlotTerisi++;
                    $guruTerlibatIds[$jadwalMatrix[$tgl][$s]['id_guru']] = true;
                }
            }
        }

        $totalGuruTerlibat = count($guruTerlibatIds);
        $persenKeterisian = $totalSlotTersedia > 0 ? round(($totalSlotTerisi / $totalSlotTersedia) * 100, 1) : 0;

        return view('waka_kurikulum.jadwal_piket', compact(
            'selectedBulan',
            'selectedTahun',
            'daftarBulan',
            'workDays',
            'jadwalMatrix',
            'gurus',
            'totalHariKerja',
            'totalSlotTersedia',
            'totalSlotTerisi',
            'totalGuruTerlibat',
            'persenKeterisian'
        ));
    }

    /**
     * Import Jadwal Guru Piket dari File (Word, PDF, Excel, CSV)
     */
    public function importJadwalPiket(Request $request, JadwalPiketImportService $importService)
    {
        $hasFile = $request->hasFile('file_jadwal') || $request->hasFile('file');
        if (!$hasFile) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan pilih file jadwal (Word, PDF, Excel, atau CSV) terlebih dahulu.',
            ], 422);
        }

        $request->validate([
            'file_jadwal' => 'nullable|file|mimes:pdf,docx,doc,xlsx,xls,csv,txt|max:20480',
            'file'        => 'nullable|file|mimes:pdf,docx,doc,xlsx,xls,csv,txt|max:20480',
            'bulan'       => 'required|integer|min:1|max:12',
            'tahun'       => 'required|integer|min:2020|max:2035',
        ], [
            'file_jadwal.mimes' => 'Format file harus berupa Microsoft Word (.docx, .doc), PDF (.pdf), Microsoft Excel (.xlsx, .xls), atau CSV (.csv).',
            'file.mimes'        => 'Format file harus berupa Microsoft Word (.docx, .doc), PDF (.pdf), Microsoft Excel (.xlsx, .xls), atau CSV (.csv).',
            'file_jadwal.max'   => 'Ukuran file maksimal 20 MB.',
            'file.max'          => 'Ukuran file maksimal 20 MB.',
        ]);

        $file = $request->file('file_jadwal') ?? $request->file('file');
        $bulan = (int) $request->input('bulan');
        $tahun = (int) $request->input('tahun');

        try {
            $result = $importService->parseAndMatch($file, $bulan, $tahun);

            if (!$result['success'] || $result['matched_slots_count'] === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menemukan atau mencocokkan data jadwal guru piket dari file yang diunggah. Pastikan file memuat nama hari, tanggal, atau nama guru yang sesuai.',
                ], 422);
            }

            $msg = "Berhasil membaca dan mencocokkan {$result['matched_slots_count']} dari {$result['total_slots']} slot penugasan guru piket.";
            if ($result['unmatched_count'] > 0) {
                $msg .= " Terdapat {$result['unmatched_count']} slot yang kosong atau guru tidak terdaftar di sistem.";
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'             => true,
                    'message'             => $msg,
                    'matched_slots_count' => $result['matched_slots_count'],
                    'total_slots'         => $result['total_slots'],
                    'total_work_days'     => $result['total_work_days'],
                    'unmatched_count'     => $result['unmatched_count'],
                    'unmatched_samples'   => $result['unmatched_samples'] ?? [],
                    'schedule_matrix'     => $result['schedule_matrix'],
                    'preview_data'        => $result['preview_data'],
                ]);
            }

            return redirect()->route('waka-kurikulum.jadwal-piket', ['bulan' => $bulan, 'tahun' => $tahun])
                ->with('success', "File berhasil diimpor! Ditemukan {$result['matched_slots_count']} penugasan guru piket. Silakan tinjau dan klik 'Simpan Jadwal'.");
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membaca file: ' . $e->getMessage(),
                ], 422);
            }

            return back()->with('error', 'Gagal memproses file impor: ' . $e->getMessage());
        }
    }

    /**
     * Simpan / Perbarui Massal Jadwal Guru Piket Satu Bulan
     */
    public function simpanJadwalPiket(Request $request)
    {
        $bulan = (int) $request->input('bulan');
        $tahun = (int) $request->input('tahun');

        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2035',
        ]);

        $mapHariIndo = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $jadwalData = $request->input('jadwal', []);

        DB::beginTransaction();
        try {
            foreach ($jadwalData as $tanggal => $slots) {
                $cDate = Carbon::parse($tanggal);
                $hari = $mapHariIndo[$cDate->format('l')] ?? 'Senin';

                for ($slot = 1; $slot <= 8; $slot++) {
                    $idGuru = !empty($slots[$slot]) ? (int)$slots[$slot] : null;

                    if ($idGuru) {
                        JadwalGuruPiket::updateOrCreate(
                            [
                                'tanggal' => $tanggal,
                                'slot_ke' => $slot,
                            ],
                            [
                                'hari'    => $hari,
                                'bulan'   => $bulan,
                                'tahun'   => $tahun,
                                'id_guru' => $idGuru,
                            ]
                        );
                    } else {
                        // Jika slot dikosongkan, hapus data slot tersebut atau set null
                        JadwalGuruPiket::where('tanggal', $tanggal)
                            ->where('slot_ke', $slot)
                            ->delete();
                    }
                }
            }

            DB::commit();

            $daftarBulan = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $namaBulan = $daftarBulan[$bulan] ?? $bulan;

            return redirect()->route('waka-kurikulum.jadwal-piket', ['bulan' => $bulan, 'tahun' => $tahun])
                ->with('success', "Seluruh jadwal guru piket bulan {$namaBulan} {$tahun} berhasil disimpan dan diperbarui!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan jadwal guru piket: ' . $e->getMessage());
        }
    }

    /**
     * Ekspor Jadwal Guru Piket Bulanan ke Format CSV
     */
    public function exportJadwalPiket(Request $request)
    {
        $bulan = (int) ($request->query('bulan') ?? Carbon::now('Asia/Jakarta')->format('n'));
        $tahun = (int) ($request->query('tahun') ?? Carbon::now('Asia/Jakarta')->format('Y'));

        $daftarBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $namaBulan = $daftarBulan[$bulan] ?? $bulan;

        $mapHariIndo = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Jakarta')->daysInMonth;
        $workDays = [];

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $cDate = Carbon::createFromDate($tahun, $bulan, $d, 'Asia/Jakarta');
            if ($cDate->dayOfWeek !== Carbon::SATURDAY && $cDate->dayOfWeek !== Carbon::SUNDAY) {
                $workDays[] = [
                    'tanggal' => $cDate->format('Y-m-d'),
                    'hari'    => $mapHariIndo[$cDate->format('l')] ?? '',
                    'label'   => $cDate->format('j') . ' ' . $namaBulan . ' ' . $tahun,
                ];
            }
        }

        $jadwalMatrix = JadwalGuruPiket::getJadwalBulan($bulan, $tahun);

        $filename = "Jadwal_Guru_Piket_{$namaBulan}_{$tahun}.csv";
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($workDays, $jadwalMatrix) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8

            fputcsv($file, [
                'No',
                'Hari',
                'Tanggal',
                'Guru Piket 1',
                'Guru Piket 2',
                'Guru Piket 3',
                'Guru Piket 4',
                'Guru Piket 5',
                'Guru Piket 6',
                'Guru Piket 7',
                'Guru Piket 8',
            ]);

            foreach ($workDays as $idx => $wd) {
                $tgl = $wd['tanggal'];
                $row = [
                    $idx + 1,
                    $wd['hari'],
                    $wd['label'],
                ];

                for ($s = 1; $s <= 8; $s++) {
                    $row[] = $jadwalMatrix[$tgl][$s]['nama_guru'] ?? '-';
                }

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Cetak Lembar Jadwal Guru Piket Bulanan
     */
    public function printJadwalPiket(Request $request)
    {
        $bulan = (int) ($request->query('bulan') ?? Carbon::now('Asia/Jakarta')->format('n'));
        $tahun = (int) ($request->query('tahun') ?? Carbon::now('Asia/Jakarta')->format('Y'));

        $daftarBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $namaBulan = $daftarBulan[$bulan] ?? $bulan;

        $mapHariIndo = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Jakarta')->daysInMonth;
        $workDays = [];

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $cDate = Carbon::createFromDate($tahun, $bulan, $d, 'Asia/Jakarta');
            if ($cDate->dayOfWeek !== Carbon::SATURDAY && $cDate->dayOfWeek !== Carbon::SUNDAY) {
                $workDays[] = [
                    'tanggal' => $cDate->format('Y-m-d'),
                    'hari'    => $mapHariIndo[$cDate->format('l')] ?? '',
                    'label'   => $cDate->format('j') . ' ' . $namaBulan . ' ' . $tahun,
                ];
            }
        }

        $jadwalMatrix = JadwalGuruPiket::getJadwalBulan($bulan, $tahun);

        return view('waka_kurikulum.jadwal_piket_print', compact(
            'bulan',
            'tahun',
            'namaBulan',
            'workDays',
            'jadwalMatrix'
        ));
    }
}


