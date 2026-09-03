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
     * Dashboard Waka SDM (Sumber Daya Manusia / Kepegawaian)
     */
    public function dashboard()
    {
        $today = Carbon::today('Asia/Jakarta')->toDateString();

        // 1. Antrean Approval Izin Guru yang Menunggu Waka SDM (status_waka_sdm = pending)
        $pendingGuruIzin = GuruIzin::with('guru')
            ->where('status_waka_sdm', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Ringkasan Statistik SDM Guru & Tenaga Kependidikan
        $totalGuru = Guru::count();

        // Guru yang sedang izin / tidak hadir hari ini
        $guruIzinHariIni = GuruIzin::whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->where('status_final', 'approved')
            ->count();

        // Guru yang sudah mengajar hari ini
        $guruHadirHariIni = JurnalMengajar::whereDate('tanggal', $today)
            ->distinct('id_jadwal')
            ->count();

        // Guru Pengganti aktif hari ini
        $guruPenggantiHariIni = PenugasanGuruPengganti::whereDate('tanggal', $today)->count();

        // Pengajuan Menunggu Persetujuan
        $countPendingApproval = $pendingGuruIzin->count();

        // 3. Rekap Pengajuan Izin Terbaru
        $riwayatPengajuan = GuruIzin::with('guru')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // 4. Pengumuman SDM Terbaru
        $pengumumanTerbaru = Pengumuman::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('waka_sdm.dashboard', compact(
            'pendingGuruIzin',
            'totalGuru',
            'guruIzinHariIni',
            'guruHadirHariIni',
            'guruPenggantiHariIni',
            'countPendingApproval',
            'riwayatPengajuan',
            'pengumumanTerbaru'
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

        $query = GuruIzin::with(['guru', 'guruPiket']);

        if ($filterStatus === 'pending') {
            $query->where('status_waka_sdm', 'pending');
        } elseif ($filterStatus === 'approved') {
            $query->where('status_waka_sdm', 'approved');
        } elseif ($filterStatus === 'rejected') {
            $query->where('status_waka_sdm', 'rejected');
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('guru', function($gq) use ($search) {
                    $gq->where('nama_guru', 'like', "%{$search}%")
                       ->orWhere('nip', 'like', "%{$search}%");
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

        $daftarIzin = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $countPending  = GuruIzin::where('status_waka_sdm', 'pending')->count();
        $countApproved = GuruIzin::where('status_waka_sdm', 'approved')->count();
        $countRejected = GuruIzin::where('status_waka_sdm', 'rejected')->count();
        $trashedCount  = GuruIzin::onlyTrashed()->count();

        return view('waka_sdm.persetujuan_izin', compact(
            'daftarIzin',
            'filterStatus',
            'search',
            'kategori',
            'tanggal',
            'countPending',
            'countApproved',
            'countRejected',
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
        if ($catatan) {
            $izin->catatan_waka = $catatan;
        }

        if ($izin->status_waka === 'approved' && $izin->status_kepsek === 'approved') {
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
     * Monitoring Kehadiran Guru & KBM
     */
    public function kehadiranGuru(Request $request)
    {
        $tanggal       = $request->query('tanggal', Carbon::today('Asia/Jakarta')->toDateString());
        $idKelasFilter = $request->query('id_kelas');
        $statusFilter  = $request->query('status');

        // Master Kelas & Mapel
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        // Guru izin pada tanggal pilihan
        $guruIzin = GuruIzin::with('guru')
            ->whereDate('tanggal_mulai', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal)
            ->get();

        // Penugasan guru pengganti
        $guruPengganti = PenugasanGuruPengganti::with(['guruUtama', 'guruPengganti', 'jadwal.kelas', 'jadwal.mapel'])
            ->whereDate('tanggal', $tanggal)
            ->get();

        // Jurnal KBM yang terisi hari ini
        $jurnalQuery = JurnalMengajar::with(['guru', 'kelas', 'mapel', 'jadwal.guru', 'jadwal.kelas', 'jadwal.mapel'])
            ->whereDate('tanggal', $tanggal);

        if ($idKelasFilter) {
            $jurnalQuery->where(function($q) use ($idKelasFilter) {
                $q->where('id_kelas', $idKelasFilter)
                  ->orWhereHas('jadwal', function($j) use ($idKelasFilter) {
                      $j->where('id_kelas', $idKelasFilter);
                  });
            });
        }

        $jurnalTerisi = $jurnalQuery->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Realtime Monitoring Stats
        $totalGuru          = Guru::count();
        $guruIzinCount      = $guruIzin->count();
        $guruPenggantiCount = $guruPengganti->count();
        $jurnalTerisiCount  = $jurnalQuery->count();
        $guruHadirCount     = max(0, $totalGuru - $guruIzinCount);

        $stats = [
            'totalGuru'          => $totalGuru,
            'guruHadirCount'     => $guruHadirCount,
            'guruIzinCount'      => $guruIzinCount,
            'guruPenggantiCount' => $guruPenggantiCount,
            'jurnalTerisiCount'  => $jurnalTerisiCount,
        ];

        return view('waka_sdm.kehadiran_guru', compact(
            'tanggal',
            'guruIzin',
            'guruPengganti',
            'jurnalTerisi',
            'kelasList',
            'idKelasFilter',
            'statusFilter',
            'stats'
        ));
    }

    /**
     * Data Master Pendidik & Tenaga Kependidikan (SDM)
     */
    public function dataGuru(Request $request)
    {
        $search      = $request->query('search');
        $jkFilter    = $request->query('jenis_kelamin');
        $mapelFilter = $request->query('id_mapel');
        $roleFilter  = $request->query('role');

        $query = Guru::with(['user', 'mapel', 'kelasWali']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('email', 'like', "%{$search}%");
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

        $guruList  = $query->orderBy('nama_guru', 'asc')->paginate(15)->withQueryString();
        $mapelList = Mapel::orderBy('nama_mapel')->get();

        $stats = [
            'totalGuru'      => Guru::count(),
            'totalLaki'      => Guru::where('jenis_kelamin', 'L')->count(),
            'totalPerempuan' => Guru::where('jenis_kelamin', 'P')->count(),
            'totalAkun'      => Guru::has('user')->count(),
        ];

        return view('waka_sdm.data_guru', compact(
            'guruList',
            'mapelList',
            'stats',
            'search',
            'jkFilter',
            'mapelFilter',
            'roleFilter'
        ));
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
            'tanggal'             => 'required|date|after_or_equal:today',
        ], [
            'judul.required'               => 'Judul pengumuman wajib diisi.',
            'isi.required'                 => 'Isi pengumuman wajib diisi.',
            'kategori.required'            => 'Kategori pengumuman wajib dipilih.',
            'jam_mengajar_select.required' => 'Pilihan jam / waktu mengajar wajib dipilih.',
            'jam_mengajar_custom.required_if' => 'Waktu kustom / Keterangan jam wajib diisi jika memilih waktu kustom.',
            'tanggal.required'             => 'Tanggal berlaku wajib diisi.',
            'tanggal.after_or_equal'       => 'Tanggal berlaku tidak boleh sebelum tanggal hari ini (tanggal lampau).',
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
            'tanggal'             => 'required|date|after_or_equal:today',
        ], [
            'judul.required'               => 'Judul pengumuman wajib diisi.',
            'isi.required'                 => 'Isi pengumuman wajib diisi.',
            'kategori.required'            => 'Kategori pengumuman wajib dipilih.',
            'jam_mengajar_select.required' => 'Pilihan jam / waktu mengajar wajib dipilih.',
            'jam_mengajar_custom.required_if' => 'Waktu kustom / Keterangan jam wajib diisi jika memilih waktu kustom.',
            'tanggal.required'             => 'Tanggal berlaku wajib diisi.',
            'tanggal.after_or_equal'       => 'Tanggal berlaku tidak boleh sebelum tanggal hari ini (tanggal lampau).',
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
