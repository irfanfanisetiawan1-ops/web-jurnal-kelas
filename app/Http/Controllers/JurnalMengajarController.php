<?php

namespace App\Http\Controllers;

use App\Models\JurnalMengajar;
use App\Models\JurnalDetailKetidakhadiran;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurnalMengajarController extends Controller
{
    /**
     * [READ] Tampilkan daftar jurnal mengajar aktif
     */
    public function index()
    {
        $jurnals = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.ruangan',
            'detailKetidakhadiran.siswa'
        ])
        ->orderBy('tanggal', 'desc')
        ->orderBy('id_jurnal', 'desc')
        ->get();

        $trashedCount = JurnalMengajar::onlyTrashed()->count();

        return view('jurnal_mengajar.index', compact('jurnals', 'trashedCount'));
    }

    /**
     * [CREATE] Menampilkan form tambah jurnal mengajar
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $todayDate = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();

        $selectedJadwal = null;
        $penugasanPengganti = null;

        if ($request->has('id_jadwal')) {
            $selectedJadwal = Jadwal::with(['kelas', 'guru', 'mapel', 'ruangan'])->find($request->id_jadwal);
            
            if ($selectedJadwal) {
                // Cek penugasan guru pengganti aktif untuk jadwal ini
                $penugasanPengganti = \App\Models\PenugasanGuruPengganti::with(['guruTidakHadir', 'guruPengganti'])
                    ->where(function($q) use ($selectedJadwal) {
                        $q->where('id_jadwal', $selectedJadwal->id_jadwal)
                          ->orWhere(function($q2) use ($selectedJadwal) {
                              $q2->where('id_guru_tidak_hadir', $selectedJadwal->id_guru)
                                 ->where('id_kelas', $selectedJadwal->id_kelas);
                          });
                    })
                    ->whereDate('tanggal', $todayDate)
                    ->where('status', 'aktif')
                    ->first();

                // Pengecekan gating jam pelajaran jika pengguna adalah Guru biasa yang bukan guru pengganti/piket
                $isSubstitute = $penugasanPengganti && ($user->id_guru == $penugasanPengganti->id_guru_pengganti);
                if ($user && !$user->isAdmin() && !$user->isGuruPiket() && !$isSubstitute && !$selectedJadwal->sudah_masuk_jam) {
                    return redirect()->route('guru.dashboard')->with('error', "Peringatan: Jurnal Mengajar untuk mata pelajaran " . ($selectedJadwal->mapel->nama_mapel ?? 'ini') . " belum dapat diisi karena belum memasuki jam pelajaran (dimulai pukul {$selectedJadwal->waktu_mulai_effective} WIB).");
                }
            }
        }

        $jadwals = Jadwal::with(['kelas', 'guru', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('id_jam_mulai', 'asc')
            ->get();

        $statusOptions = ['Hadir', 'Izin', 'Sakit', 'Tanpa Keterangan'];

        return view('jurnal_mengajar.create', compact('jadwals', 'statusOptions', 'selectedJadwal', 'penugasanPengganti', 'todayDate'));
    }

    /**
     * API Response untuk mengambil daftar siswa berdasarkan ID Jadwal (Kelas) beserta status izin auto-sync
     */
    public function getSiswaByJadwal(Request $request, $id_jadwal)
    {
        $jadwal = Jadwal::find($id_jadwal);
        if (!$jadwal) {
            return response()->json([], 404);
        }

        $tanggalTarget = $request->input('tanggal') ?? \Carbon\Carbon::now('Asia/Jakarta')->toDateString();

        $siswas = Siswa::where('id_kelas', $jadwal->id_kelas)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        // Cek SiswaSuratIzin aktif pada tanggalTarget
        $suratIzinAktif = \App\Models\SiswaSuratIzin::where('id_kelas', $jadwal->id_kelas)
            ->where(function($q) use ($tanggalTarget) {
                $q->whereDate('tanggal', '<=', $tanggalTarget)
                  ->where(function($sq) use ($tanggalTarget) {
                      $sq->whereNull('tanggal_selesai')
                         ->orWhereDate('tanggal_selesai', '>=', $tanggalTarget);
                  });
            })
            ->whereIn('status', ['Terverifikasi', 'disetujui'])
            ->get()
            ->keyBy('id_siswa');

        // Cek SiswaDispen aktif pada tanggalTarget
        $dispenAktif = \App\Models\SiswaDispen::where('id_kelas', $jadwal->id_kelas)
            ->whereDate('tanggal', $tanggalTarget)
            ->where('status_waka', 'approved')
            ->get()
            ->keyBy('id_siswa');

        $resultSiswas = $siswas->map(function($s) use ($suratIzinAktif, $dispenAktif) {
            $defaultStatus = 'Hadir';
            $keteranganIzin = null;
            $isAutoIzin = false;

            if (isset($suratIzinAktif[$s->id_siswa])) {
                $surat = $suratIzinAktif[$s->id_siswa];
                $kat = strtolower(trim($surat->kategori ?? 'izin'));
                if (str_contains($kat, 'sakit')) {
                    $defaultStatus = 'Sakit';
                } elseif (str_contains($kat, 'dispen')) {
                    $defaultStatus = 'Izin';
                } else {
                    $defaultStatus = 'Izin';
                }
                $keteranganIzin = "Surat {$surat->kategori}: " . ($surat->keterangan ?? 'Izin Terverifikasi');
                $isAutoIzin = true;
            } elseif (isset($dispenAktif[$s->id_siswa])) {
                $dispen = $dispenAktif[$s->id_siswa];
                $defaultStatus = 'Izin';
                $keteranganIzin = "Dispensasi: " . ($dispen->alasan ?? 'Dispensasi Disetujui');
                $isAutoIzin = true;
            }

            return [
                'id_siswa'        => $s->id_siswa,
                'nama_siswa'      => $s->nama_siswa,
                'nis'             => $s->nis ?? '-',
                'nisn'            => $s->nisn ?? '-',
                'default_status'  => $defaultStatus,
                'keterangan_izin' => $keteranganIzin,
                'is_auto_izin'    => $isAutoIzin,
            ];
        });

        return response()->json([
            'kelas' => $jadwal->kelas->nama_kelas ?? '-',
            'siswas' => $resultSiswas
        ]);
    }

    /**
     * [STORE] Memproses & menyimpan data jurnal mengajar ke database
     */
    public function store(Request $request)
    {
        $activeTa = \App\Models\TahunAjaran::getActive();
        if ($activeTa && !$activeTa->buka_jurnal) {
            return back()->withInput()->with('error', "Pengisian Jurnal Mengajar untuk Tahun Ajaran '{$activeTa->nama_lengkap}' saat ini sedang dikunci (Arsip) oleh Tata Usaha.");
        }

        $request->validate([
            'id_jadwal'             => 'required|exists:jadwal,id_jadwal',
            'tanggal'               => 'required|date',
            'status_kehadiran_guru' => 'required|in:Hadir,Izin,Sakit,Tanpa Keterangan',
            'materi'                => 'required|string',
            'catatan'               => 'nullable|string',
            'ketidakhadiran'        => 'nullable|array',
            'ketidakhadiran.*.id_siswa'   => 'required|exists:siswa,id_siswa',
            'ketidakhadiran.*.keterangan' => 'required|in:Sakit,Izin,Alpa',
        ], [
            'id_jadwal.required'             => 'Jadwal pelajaran wajib dipilih.',
            'id_jadwal.exists'               => 'Jadwal yang dipilih tidak valid.',
            'tanggal.required'               => 'Tanggal wajib diisi.',
            'tanggal.date'                   => 'Format tanggal tidak valid.',
            'status_kehadiran_guru.required' => 'Status kehadiran guru wajib dipilih.',
            'status_kehadiran_guru.in'       => 'Status kehadiran guru tidak valid.',
            'materi.required'                => 'Materi pembelajaran wajib diisi.',
        ]);

        $user = Auth::user();
        $jadwal = Jadwal::find($request->id_jadwal);
        $idGuruPengganti = null;

        // Cek penugasan guru pengganti aktif untuk jadwal dan tanggal ini
        $penugasan = \App\Models\PenugasanGuruPengganti::where(function($q) use ($request, $jadwal) {
                $q->where('id_jadwal', $request->id_jadwal);
                if ($jadwal) {
                    $q->orWhere(function($q2) use ($jadwal) {
                        $q2->where('id_guru_tidak_hadir', $jadwal->id_guru)
                           ->where('id_kelas', $jadwal->id_kelas);
                    });
                }
            })
            ->whereDate('tanggal', $request->tanggal)
            ->where('status', 'aktif')
            ->first();

        if ($penugasan) {
            $idGuruPengganti = $penugasan->id_guru_pengganti;
            // Mark penugasan status as selesai
            $penugasan->update(['status' => 'selesai']);
        } elseif ($user && $user->id_guru && $jadwal && $user->id_guru != $jadwal->id_guru) {
            $idGuruPengganti = $user->id_guru;
        }

        $jurnal = JurnalMengajar::create([
            'id_jadwal'             => $request->id_jadwal,
            'id_guru_pengganti'     => $idGuruPengganti,
            'tanggal'               => $request->tanggal,
            'status_kehadiran_guru' => $request->status_kehadiran_guru,
            'materi'                => $request->materi,
            'catatan'               => $request->catatan,
            'dicatat_pada'          => now(),
        ]);

        // Simpan detail ketidakhadiran siswa jika ada
        $recordedSiswaIds = [];
        if ($request->has('ketidakhadiran') && is_array($request->ketidakhadiran)) {
            foreach ($request->ketidakhadiran as $item) {
                if (!empty($item['id_siswa']) && !empty($item['keterangan'])) {
                    JurnalDetailKetidakhadiran::create([
                        'id_jurnal'  => $jurnal->id_jurnal,
                        'id_siswa'   => $item['id_siswa'],
                        'keterangan' => $item['keterangan'],
                    ]);
                    $recordedSiswaIds[] = $item['id_siswa'];
                }
            }
        }

        // Pastikan siswa dengan surat izin/dispen aktif pada tanggal jurnal otomatis tercatat di JurnalDetailKetidakhadiran
        if ($jadwal) {
            $suratIzinAktif = \App\Models\SiswaSuratIzin::where('id_kelas', $jadwal->id_kelas)
                ->where(function($q) use ($request) {
                    $q->whereDate('tanggal', '<=', $request->tanggal)
                      ->where(function($sq) use ($request) {
                          $sq->whereNull('tanggal_selesai')
                             ->orWhereDate('tanggal_selesai', '>=', $request->tanggal);
                      });
                })
                ->whereIn('status', ['Terverifikasi', 'disetujui'])
                ->get();

            foreach ($suratIzinAktif as $surat) {
                if (!in_array($surat->id_siswa, $recordedSiswaIds)) {
                    $kat = str_contains(strtolower($surat->kategori), 'sakit') ? 'Sakit' : 'Izin';
                    JurnalDetailKetidakhadiran::firstOrCreate(
                        [
                            'id_jurnal' => $jurnal->id_jurnal,
                            'id_siswa'  => $surat->id_siswa,
                        ],
                        [
                            'keterangan' => $kat,
                        ]
                    );
                    $recordedSiswaIds[] = $surat->id_siswa;
                }
            }
        }

        $redirectRoute = ($user && $user->isGuruPiket()) ? 'piket.jurnal-mengajar' : (($user && $user->isTeacher()) ? 'guru.dashboard' : 'jurnal-mengajar.index');

        return redirect()->route($redirectRoute)
                         ->with('success', 'Data jurnal mengajar berhasil ditambahkan!');
    }

    /**
     * [SHOW] Menampilkan detail 1 jurnal mengajar
     */
    public function show($id)
    {
        $jurnal = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.ruangan',
            'detailKetidakhadiran.siswa'
        ])->findOrFail($id);

        return view('jurnal_mengajar.show', compact('jurnal'));
    }

    /**
     * [EDIT] Menampilkan form edit data jurnal mengajar
     */
    public function edit($id)
    {
        $jurnal = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.ruangan',
            'detailKetidakhadiran'
        ])->findOrFail($id);

        $jadwals = Jadwal::with(['kelas', 'guru', 'mapel', 'ruangan'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('id_jam_mulai', 'asc')
            ->get();

        $siswas = Siswa::where('id_kelas', $jurnal->jadwal->id_kelas ?? 0)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        $statusOptions = ['Hadir', 'Izin', 'Sakit', 'Tanpa Keterangan'];

        // Map detail ketidakhadiran existing: id_siswa => keterangan
        $existingKetidakhadiran = [];
        foreach ($jurnal->detailKetidakhadiran as $detail) {
            $existingKetidakhadiran[$detail->id_siswa] = $detail->keterangan;
        }

        return view('jurnal_mengajar.edit', compact(
            'jurnal',
            'jadwals',
            'siswas',
            'statusOptions',
            'existingKetidakhadiran'
        ));
    }

    /**
     * [UPDATE] Memproses perubahan data jurnal mengajar di database
     */
    public function update(Request $request, $id)
    {
        $jurnal = JurnalMengajar::findOrFail($id);

        $request->validate([
            'id_jadwal'             => 'required|exists:jadwal,id_jadwal',
            'tanggal'               => 'required|date',
            'status_kehadiran_guru' => 'required|in:Hadir,Izin,Sakit,Tanpa Keterangan',
            'materi'                => 'required|string',
            'catatan'               => 'nullable|string',
            'ketidakhadiran'        => 'nullable|array',
            'ketidakhadiran.*.id_siswa'   => 'required|exists:siswa,id_siswa',
            'ketidakhadiran.*.keterangan' => 'required|in:Sakit,Izin,Alpa',
        ], [
            'id_jadwal.required'             => 'Jadwal pelajaran wajib dipilih.',
            'id_jadwal.exists'               => 'Jadwal yang dipilih tidak valid.',
            'tanggal.required'               => 'Tanggal wajib diisi.',
            'tanggal.date'                   => 'Format tanggal tidak valid.',
            'status_kehadiran_guru.required' => 'Status kehadiran guru wajib dipilih.',
            'status_kehadiran_guru.in'       => 'Status kehadiran guru tidak valid.',
            'materi.required'                => 'Materi pembelajaran wajib diisi.',
        ]);

        $jurnal->update([
            'id_jadwal'             => $request->id_jadwal,
            'tanggal'               => $request->tanggal,
            'status_kehadiran_guru' => $request->status_kehadiran_guru,
            'materi'                => $request->materi,
            'catatan'               => $request->catatan,
        ]);

        // Hapus detail ketidakhadiran lama dan ganti dengan yang baru
        JurnalDetailKetidakhadiran::where('id_jurnal', $jurnal->id_jurnal)->delete();

        if ($request->has('ketidakhadiran') && is_array($request->ketidakhadiran)) {
            foreach ($request->ketidakhadiran as $item) {
                if (!empty($item['id_siswa']) && !empty($item['keterangan'])) {
                    JurnalDetailKetidakhadiran::create([
                        'id_jurnal'  => $jurnal->id_jurnal,
                        'id_siswa'   => $item['id_siswa'],
                        'keterangan' => $item['keterangan'],
                    ]);
                }
            }
        }

        return redirect()->route('jurnal-mengajar.index')
                         ->with('success', 'Data jurnal mengajar berhasil diperbarui!');
    }

    /**
     * [SOFT DELETE] Tandai jurnal mengajar sebagai dihapus
     */
    public function destroy($id)
    {
        $jurnal = JurnalMengajar::with(['jadwal.kelas', 'jadwal.mapel'])->findOrFail($id);
        $info   = ($jurnal->jadwal->kelas->nama_kelas ?? 'Kelas') . ' - ' . ($jurnal->jadwal->mapel->nama_mapel ?? 'Jurnal') . ' (' . $jurnal->tanggal_formatted . ')';
        $jurnal->delete();

        return redirect()->route('jurnal-mengajar.index')
                         ->with('success', "Data jurnal mengajar \"$info\" berhasil dipindahkan ke Tempat Sampah.");
    }

    /**
     * [TRASH] Menampilkan daftar jurnal mengajar yang di-soft-delete (Recycle Bin)
     */
    public function trash()
    {
        $jurnals = JurnalMengajar::onlyTrashed()
            ->with(['jadwal.kelas', 'jadwal.guru', 'jadwal.mapel', 'jadwal.ruangan'])
            ->orderBy('id_jurnal', 'desc')
            ->get();

        return view('jurnal_mengajar.trash', compact('jurnals'));
    }

    /**
     * [RESTORE] Pulihkan data jurnal mengajar dari tempat sampah
     */
    public function restore($id)
    {
        $jurnal = JurnalMengajar::onlyTrashed()->findOrFail($id);
        $jurnal->restore();

        return redirect()->route('jurnal-mengajar.trash')
                         ->with('success', "Data jurnal mengajar berhasil dipulihkan!");
    }

    /**
     * [FORCE DELETE] Hapus permanen dari database
     */
    public function forceDelete($id)
    {
        $jurnal = JurnalMengajar::onlyTrashed()->findOrFail($id);
        
        // Hapus detail ketidakhadiran siswa
        JurnalDetailKetidakhadiran::where('id_jurnal', $jurnal->id_jurnal)->delete();
        $jurnal->forceDelete();

        return redirect()->route('jurnal-mengajar.trash')
                         ->with('success', "Data jurnal mengajar telah dihapus secara permanen dari database.");
    }
}
