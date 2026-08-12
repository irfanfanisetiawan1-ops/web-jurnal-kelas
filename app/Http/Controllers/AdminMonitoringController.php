<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JurnalMengajar;
use App\Models\JurnalPiket;
use App\Models\JurnalDetailKetidakhadiran;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Carbon\Carbon;

class AdminMonitoringController extends Controller
{
    // Fitur 11: Jurnal Mengajar (View + Filter + Reset + Detail + Download/Print + Export + Store + Update + Destroy + Laporan Guru Alpa)
    public function jurnalMengajar(Request $request)
    {
        $search          = $request->query('search');
        $tanggal         = $request->query('tanggal');
        $tanggal_mulai   = $request->query('tanggal_mulai');
        $tanggal_selesai = $request->query('tanggal_selesai');
        $idGuru          = $request->query('id_guru');
        $idKelas         = $request->query('id_kelas');
        $idMapel         = $request->query('id_mapel');
        $status          = $request->query('status');

        $query = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.ruangan',
            'detailKetidakhadiran.siswa'
        ]);

        if ($search) {
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

        if ($tanggal_mulai && $tanggal_selesai) {
            $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
        } elseif ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($idGuru || $idKelas || $idMapel) {
            $query->whereHas('jadwal', function($q) use ($idGuru, $idKelas, $idMapel) {
                if ($idGuru)  $q->where('id_guru', $idGuru);
                if ($idKelas) $q->where('id_kelas', $idKelas);
                if ($idMapel) $q->where('id_mapel', $idMapel);
            });
        }

        if ($status) {
            if ($status === 'Terlaksana' || $status === 'Hadir') {
                $query->where('status_kehadiran_guru', 'Hadir');
            } elseif ($status === 'Belum Terlaksana') {
                $query->whereIn('status_kehadiran_guru', ['Izin', 'Sakit', 'Tanpa Keterangan']);
            } else {
                $query->where('status_kehadiran_guru', $status);
            }
        }

        // ─────────────────────────────────────────────────────────────
        // Laporan Guru Alpa (Real-Time Berdasarkan Tanggal Referensi)
        // ─────────────────────────────────────────────────────────────
        $targetTanggal = $tanggal ?? ($tanggal_selesai ?? Carbon::today()->toDateString());
        $carbonDate = Carbon::parse($targetTanggal);

        $mapHari = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Senin',
            'Sunday'    => 'Senin',
        ];
        $namaHari = $mapHari[$carbonDate->format('l')] ?? 'Senin';

        $jadwalHariIni = \App\Models\Jadwal::with(['guru', 'mapel', 'kelas', 'ruangan'])
            ->where('hari', $namaHari)
            ->get();

        $filledJadwalIds = JurnalMengajar::whereDate('tanggal', $targetTanggal)
            ->pluck('id_jadwal')
            ->toArray();

        $guruAlpaList = $jadwalHariIni->filter(function($j) use ($filledJadwalIds) {
            return !in_array($j->id_jadwal, $filledJadwalIds);
        });

        // Kalkulasi Statistik
        $totalPertemuan      = (clone $query)->count();
        $terlaksanaCount     = (clone $query)->where('status_kehadiran_guru', 'Hadir')->count();
        $belumTerlaksanaCount= (clone $query)->whereIn('status_kehadiran_guru', ['Izin', 'Sakit', 'Tanpa Keterangan'])->count();
        $guruAktifCount      = (clone $query)->join('jadwal', 'jurnal_mengajar.id_jadwal', '=', 'jadwal.id_jadwal')
                                             ->distinct('jadwal.id_guru')
                                             ->count('jadwal.id_guru');

        $jurnals   = $query->orderBy('tanggal', 'desc')->orderBy('id_jurnal', 'desc')->paginate(10)->withQueryString();
        $guruList  = Guru::orderBy('nama_guru')->get();
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapelList = Mapel::orderBy('nama_mapel')->get();

        // Data Jadwal untuk Modal Tambah Jurnal
        $jadwalList = \App\Models\Jadwal::with(['kelas', 'guru', 'mapel', 'ruangan'])
            ->orderBy('hari')
            ->orderBy('id_jam_mulai')
            ->get();

        return view('admin.jurnal_mengajar.index', compact(
            'jurnals',
            'guruList',
            'kelasList',
            'mapelList',
            'jadwalList',
            'guruAlpaList',
            'targetTanggal',
            'search',
            'tanggal',
            'tanggal_mulai',
            'tanggal_selesai',
            'idGuru',
            'idKelas',
            'idMapel',
            'status',
            'totalPertemuan',
            'terlaksanaCount',
            'belumTerlaksanaCount',
            'guruAktifCount'
        ));
    }

    public function jurnalMengajarDetail($id)
    {
        $jurnal = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.ruangan',
            'detailKetidakhadiran.siswa'
        ])->findOrFail($id);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id_jurnal'             => $jurnal->id_jurnal,
                    'tanggal'               => \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('l, d F Y'),
                    'tanggal_raw'           => $jurnal->tanggal,
                    'guru'                  => $jurnal->jadwal->guru->nama_guru ?? '-',
                    'nip'                   => $jurnal->jadwal->guru->nip ?? '-',
                    'mapel'                 => $jurnal->jadwal->mapel->nama_mapel ?? '-',
                    'kelas'                 => $jurnal->jadwal->kelas->nama_kelas ?? '-',
                    'ruangan'               => $jurnal->jadwal->ruangan->nama_ruangan ?? '-',
                    'jam_ke'                => $jurnal->jadwal->jam_range ?? '-',
                    'materi'                => $jurnal->materi ?? '-',
                    'catatan'               => $jurnal->catatan ?? '-',
                    'status_kehadiran_guru' => $jurnal->status_kehadiran_guru,
                    'dokumentasi_url'       => $jurnal->dokumentasi ? asset('storage/' . $jurnal->dokumentasi) : null,
                    'absensi_siswa'         => $jurnal->detailKetidakhadiran->map(function($d) {
                        return [
                            'nama_siswa' => $d->siswa->nama_siswa ?? 'Siswa',
                            'nis'        => $d->siswa->nisn ?? $d->siswa->nis ?? '-',
                            'keterangan' => $d->keterangan
                        ];
                    })
                ]
            ]);
        }

        return view('admin.jurnal_mengajar.detail_modal', compact('jurnal'));
    }

    public function jurnalMengajarCetakDetail($id)
    {
        $jurnal = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.ruangan',
            'detailKetidakhadiran.siswa'
        ])->findOrFail($id);

        return view('admin.jurnal_mengajar.detail_print', compact('jurnal'));
    }

    public function jurnalMengajarExport(Request $request)
    {
        $search          = $request->query('search');
        $tanggal         = $request->query('tanggal');
        $tanggal_mulai   = $request->query('tanggal_mulai');
        $tanggal_selesai = $request->query('tanggal_selesai');
        $idGuru          = $request->query('id_guru');
        $idKelas         = $request->query('id_kelas');
        $idMapel         = $request->query('id_mapel');
        $status          = $request->query('status');

        $query = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.ruangan',
            'detailKetidakhadiran.siswa'
        ]);

        if ($search) {
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

        if ($tanggal_mulai && $tanggal_selesai) {
            $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
        } elseif ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($idGuru || $idKelas || $idMapel) {
            $query->whereHas('jadwal', function($q) use ($idGuru, $idKelas, $idMapel) {
                if ($idGuru)  $q->where('id_guru', $idGuru);
                if ($idKelas) $q->where('id_kelas', $idKelas);
                if ($idMapel) $q->where('id_mapel', $idMapel);
            });
        }

        if ($status) {
            if ($status === 'Terlaksana' || $status === 'Hadir') {
                $query->where('status_kehadiran_guru', 'Hadir');
            } elseif ($status === 'Belum Terlaksana') {
                $query->whereIn('status_kehadiran_guru', ['Izin', 'Sakit', 'Tanpa Keterangan']);
            } else {
                $query->where('status_kehadiran_guru', $status);
            }
        }

        $jurnals = $query->orderBy('tanggal', 'desc')->get();

        // Check format param (csv / excel / print)
        $format = $request->query('format', 'csv');
        if ($format === 'print') {
            return view('admin.jurnal_mengajar.print', compact('jurnals', 'tanggal'));
        }

        $filename = "rekap_jurnal_mengajar_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['NO', 'TANGGAL', 'GURU', 'MATA PELAJARAN', 'KELAS', 'RUANGAN', 'JAM KE', 'MATERI', 'STATUS GURU', 'CATATAN', 'SISWA TIDAK HADIR'];

        $callback = function() use ($jurnals, $columns) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel formatting
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);

            foreach ($jurnals as $index => $j) {
                $absensiStr = '-';
                if ($j->detailKetidakhadiran && $j->detailKetidakhadiran->count() > 0) {
                    $absensiStr = $j->detailKetidakhadiran->map(function($d) {
                        return ($d->siswa->nama_siswa ?? 'Siswa') . ' (' . $d->keterangan . ')';
                    })->implode(', ');
                }

                fputcsv($file, [
                    $index + 1,
                    $j->tanggal,
                    $j->jadwal->guru->nama_guru ?? '-',
                    $j->jadwal->mapel->nama_mapel ?? '-',
                    $j->jadwal->kelas->nama_kelas ?? '-',
                    $j->jadwal->ruangan->nama_ruangan ?? '-',
                    $j->jadwal->jam_range ?? '-',
                    $j->materi ?? '-',
                    $j->status_kehadiran_guru ?? 'Hadir',
                    $j->catatan ?? '-',
                    $absensiStr
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function jurnalMengajarCetak(Request $request)
    {
        $search          = $request->query('search');
        $tanggal         = $request->query('tanggal');
        $tanggal_mulai   = $request->query('tanggal_mulai');
        $tanggal_selesai = $request->query('tanggal_selesai');
        $idGuru          = $request->query('id_guru');
        $idKelas         = $request->query('id_kelas');
        $idMapel         = $request->query('id_mapel');
        $status          = $request->query('status');

        $query = JurnalMengajar::with([
            'jadwal.kelas',
            'jadwal.guru',
            'jadwal.mapel',
            'jadwal.ruangan',
            'detailKetidakhadiran.siswa'
        ]);

        if ($search) {
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

        if ($tanggal_mulai && $tanggal_selesai) {
            $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
        } elseif ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($idGuru || $idKelas || $idMapel) {
            $query->whereHas('jadwal', function($q) use ($idGuru, $idKelas, $idMapel) {
                if ($idGuru)  $q->where('id_guru', $idGuru);
                if ($idKelas) $q->where('id_kelas', $idKelas);
                if ($idMapel) $q->where('id_mapel', $idMapel);
            });
        }

        if ($status) {
            if ($status === 'Terlaksana' || $status === 'Hadir') {
                $query->where('status_kehadiran_guru', 'Hadir');
            } elseif ($status === 'Belum Terlaksana') {
                $query->whereIn('status_kehadiran_guru', ['Izin', 'Sakit', 'Tanpa Keterangan']);
            } else {
                $query->where('status_kehadiran_guru', $status);
            }
        }

        $jurnals = $query->orderBy('tanggal', 'desc')->get();

        return view('admin.jurnal_mengajar.print', compact('jurnals', 'tanggal'));
    }

    public function jurnalMengajarStore(Request $request)
    {
        $request->validate([
            'id_jadwal'             => 'required|exists:jadwal,id_jadwal',
            'tanggal'               => 'required|date',
            'status_kehadiran_guru' => 'required|in:Hadir,Izin,Sakit,Tanpa Keterangan',
            'materi'                => 'required|string',
            'catatan'               => 'nullable|string',
            'dokumentasi'           => 'nullable|image|max:2048',
            'ketidakhadiran'        => 'nullable|array',
        ], [
            'id_jadwal.required'             => 'Jadwal pelajaran wajib dipilih.',
            'id_jadwal.exists'               => 'Jadwal pelajaran tidak valid.',
            'tanggal.required'               => 'Tanggal mengajar wajib diisi.',
            'status_kehadiran_guru.required' => 'Status kehadiran guru wajib dipilih.',
            'materi.required'                => 'Materi pembelajaran wajib diisi.',
            'dokumentasi.image'              => 'Bukti foto harus berupa berkas gambar.',
            'dokumentasi.max'                => 'Ukuran foto maksimal 2MB.'
        ]);

        $dokumentasiPath = null;
        if ($request->hasFile('dokumentasi')) {
            $file = $request->file('dokumentasi');
            $filename = 'dokumentasi_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dokumentasiPath = $file->storeAs('jurnal_mengajar', $filename, 'public');
        }

        $jurnal = JurnalMengajar::create([
            'id_jadwal'             => $request->id_jadwal,
            'tanggal'               => $request->tanggal,
            'status_kehadiran_guru' => $request->status_kehadiran_guru,
            'materi'                => $request->materi,
            'catatan'               => $request->catatan,
            'dokumentasi'           => $dokumentasiPath,
            'dicatat_pada'          => now(),
        ]);

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

        return redirect()->route('admin.jurnal-mengajar')
                         ->with('success', 'Jurnal mengajar baru berhasil ditambahkan!');
    }

    public function jurnalMengajarDestroy($id)
    {
        $jurnal = JurnalMengajar::findOrFail($id);
        $jurnal->delete();

        return redirect()->route('admin.jurnal-mengajar')
                         ->with('success', 'Data jurnal mengajar berhasil dihapus.');
    }

    // Fitur 12: Jurnal Guru Piket (Full CRUD + Stats + Filter + Detail + Trash + Cetak + Export CSV)
    public function jurnalPiket(Request $request)
    {
        $tanggal         = $request->query('tanggal');
        $tanggal_mulai   = $request->query('tanggal_mulai');
        $tanggal_selesai = $request->query('tanggal_selesai');
        $search          = $request->query('search');
        $status_suasana  = $request->query('status_suasana');

        $query = JurnalPiket::with('guru');

        if ($tanggal_mulai && $tanggal_selesai) {
            $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
        } elseif ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('catatan_kejadian', 'like', "%{$search}%")
                  ->orWhere('nama_petugas_piket', 'like', "%{$search}%")
                  ->orWhereHas('guru', function($g) use ($search) {
                      $g->where('nama_guru', 'like', "%{$search}%");
                  });
            });
        }

        if ($status_suasana) {
            $query->where('status_suasana', $status_suasana);
        }

        // Kalkulasi Statistik KPI
        $totalPiket       = (clone $query)->count();
        $kondusifCount    = (clone $query)->where('status_suasana', 'Kondusif')->count();
        $kejadianCount    = (clone $query)->whereIn('status_suasana', ['Ada Kejadian', 'Lainnya'])->count();
        $petugasHariIni   = JurnalPiket::whereDate('tanggal', Carbon::today()->toDateString())->count();

        $jurnalsPiket = $query->orderBy('tanggal', 'desc')->orderBy('id_jurnal_piket', 'desc')->paginate(10)->withQueryString();
        $guruList     = Guru::orderBy('nama_guru')->get();
        $trashedCount = JurnalPiket::onlyTrashed()->count();

        return view('admin.jurnal_piket.index', compact(
            'jurnalsPiket',
            'guruList',
            'trashedCount',
            'tanggal',
            'tanggal_mulai',
            'tanggal_selesai',
            'search',
            'status_suasana',
            'totalPiket',
            'kondusifCount',
            'kejadianCount',
            'petugasHariIni'
        ));
    }

    public function jurnalPiketStore(Request $request)
    {
        $request->validate([
            'tanggal'            => 'required|date',
            'id_guru'            => 'nullable|exists:guru,id_guru',
            'nama_petugas_piket' => 'nullable|string|max:100',
            'jam_piket'          => 'required|string|max:50',
            'catatan_kejadian'   => 'nullable|string',
            'status_suasana'     => 'required|in:Kondusif,Ada Kejadian,Lainnya',
        ], [
            'tanggal.required'        => 'Tanggal piket wajib diisi.',
            'jam_piket.required'      => 'Jam piket wajib diisi.',
            'status_suasana.required' => 'Status suasana wajib dipilih.',
            'status_suasana.in'       => 'Status suasana tidak valid.'
        ]);

        $namaPetugas = $request->nama_petugas_piket;
        if (empty($namaPetugas) && $request->id_guru) {
            $guru = Guru::find($request->id_guru);
            $namaPetugas = $guru ? $guru->nama_guru : 'Petugas Piket';
        }

        if (empty($namaPetugas)) {
            $namaPetugas = 'Petugas Piket';
        }

        JurnalPiket::create([
            'tanggal'            => $request->tanggal,
            'id_guru'            => $request->id_guru,
            'nama_petugas_piket' => $namaPetugas,
            'jam_piket'          => $request->jam_piket,
            'catatan_kejadian'   => $request->catatan_kejadian,
            'status_suasana'     => $request->status_suasana,
        ]);

        return redirect()->route('admin.jurnal-piket')
                         ->with('success', 'Entri jurnal piket baru berhasil ditambahkan!');
    }

    public function jurnalPiketDetail($id)
    {
        $jurnal = JurnalPiket::with('guru')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => [
                'id_jurnal_piket'    => $jurnal->id_jurnal_piket,
                'tanggal'            => $jurnal->tanggal,
                'tanggal_formatted'  => Carbon::parse($jurnal->tanggal)->translatedFormat('l, d F Y'),
                'created_at_formatted' => $jurnal->created_at ? Carbon::parse($jurnal->created_at)->translatedFormat('d M Y, H:i') . ' WIB' : '-',
                'id_guru'            => $jurnal->id_guru,
                'nama_guru'          => $jurnal->guru->nama_guru ?? '-',
                'nip'                => $jurnal->guru->nip ?? '-',
                'nama_petugas_piket' => $jurnal->nama_petugas_piket,
                'jam_piket'          => $jurnal->jam_piket,
                'catatan_kejadian'   => $jurnal->catatan_kejadian ?? 'Tidak ada catatan khusus.',
                'status_suasana'     => $jurnal->status_suasana,
            ]
        ]);
    }

    public function jurnalPiketUpdate(Request $request, $id)
    {
        $jurnal = JurnalPiket::findOrFail($id);

        $request->validate([
            'tanggal'            => 'required|date',
            'id_guru'            => 'nullable|exists:guru,id_guru',
            'nama_petugas_piket' => 'nullable|string|max:100',
            'jam_piket'          => 'required|string|max:50',
            'catatan_kejadian'   => 'nullable|string',
            'status_suasana'     => 'required|in:Kondusif,Ada Kejadian,Lainnya',
        ], [
            'tanggal.required'        => 'Tanggal piket wajib diisi.',
            'jam_piket.required'      => 'Jam piket wajib diisi.',
            'status_suasana.required' => 'Status suasana wajib dipilih.',
        ]);

        $namaPetugas = $request->nama_petugas_piket;
        if (empty($namaPetugas) && $request->id_guru) {
            $guru = Guru::find($request->id_guru);
            $namaPetugas = $guru ? $guru->nama_guru : $jurnal->nama_petugas_piket;
        }

        $jurnal->update([
            'tanggal'            => $request->tanggal,
            'id_guru'            => $request->id_guru,
            'nama_petugas_piket' => $namaPetugas ?: $jurnal->nama_petugas_piket,
            'jam_piket'          => $request->jam_piket,
            'catatan_kejadian'   => $request->catatan_kejadian,
            'status_suasana'     => $request->status_suasana,
        ]);

        return redirect()->route('admin.jurnal-piket')
                         ->with('success', 'Data jurnal piket berhasil diperbarui!');
    }

    public function jurnalPiketDestroy($id)
    {
        $jurnal  = JurnalPiket::findOrFail($id);
        $petugas = $jurnal->nama_petugas_piket;
        $tgl     = \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y');

        $jurnal->delete();

        return redirect()->route('admin.jurnal-piket')
                         ->with('success', "Data jurnal piket petugas '{$petugas}' (Tanggal: {$tgl}) berhasil dipindahkan ke Tempat Sampah.");
    }

    public function jurnalPiketTrash(Request $request)
    {
        $search = $request->query('search');
        $query  = JurnalPiket::onlyTrashed()->with('guru');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('catatan_kejadian', 'like', "%{$search}%")
                  ->orWhere('nama_petugas_piket', 'like', "%{$search}%")
                  ->orWhere('jam_piket', 'like', "%{$search}%");
            });
        }

        $jurnalsPiket = $query->orderBy('deleted_at', 'desc')->paginate(10)->withQueryString();
        $trashedCount = JurnalPiket::onlyTrashed()->count();

        return view('admin.jurnal_piket.trash', compact('jurnalsPiket', 'trashedCount', 'search'));
    }

    public function jurnalPiketRestore($id)
    {
        $jurnal  = JurnalPiket::onlyTrashed()->findOrFail($id);
        $petugas = $jurnal->nama_petugas_piket;
        $tgl     = \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y');

        $jurnal->restore();

        return redirect()->route('admin.jurnal-piket.trash')
                         ->with('success', "Jurnal piket petugas '{$petugas}' (Tanggal: {$tgl}) berhasil dipulihkan dari Tempat Sampah.");
    }

    public function jurnalPiketForceDelete($id)
    {
        $jurnal  = JurnalPiket::onlyTrashed()->findOrFail($id);
        $petugas = $jurnal->nama_petugas_piket;
        $tgl     = \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y');

        $jurnal->forceDelete();

        return redirect()->route('admin.jurnal-piket.trash')
                         ->with('success', "Jurnal piket petugas '{$petugas}' (Tanggal: {$tgl}) telah dihapus secara permanen dari database.");
    }

    public function jurnalPiketExport(Request $request)
    {
        $tanggal         = $request->query('tanggal');
        $tanggal_mulai   = $request->query('tanggal_mulai');
        $tanggal_selesai = $request->query('tanggal_selesai');
        $search          = $request->query('search');
        $status_suasana  = $request->query('status_suasana');

        $query = JurnalPiket::with('guru');

        if ($tanggal_mulai && $tanggal_selesai) {
            $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
        } elseif ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('catatan_kejadian', 'like', "%{$search}%")
                  ->orWhere('nama_petugas_piket', 'like', "%{$search}%")
                  ->orWhereHas('guru', function($g) use ($search) {
                      $g->where('nama_guru', 'like', "%{$search}%");
                  });
            });
        }

        if ($status_suasana) {
            $query->where('status_suasana', $status_suasana);
        }

        $jurnals = $query->orderBy('tanggal', 'desc')->get();

        $filename = "rekap_jurnal_piket_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['NO', 'TANGGAL', 'JAM PIKET', 'NAMA PETUGAS PIKET', 'NIP GURU', 'STATUS SUASANA', 'CATATAN KEJADIAN'];

        $callback = function() use ($jurnals, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM
            fputcsv($file, $columns);

            foreach ($jurnals as $index => $jp) {
                fputcsv($file, [
                    $index + 1,
                    $jp->tanggal,
                    $jp->jam_piket,
                    $jp->nama_petugas_piket,
                    $jp->guru->nip ?? '-',
                    $jp->status_suasana,
                    $jp->catatan_kejadian ?? '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function jurnalPiketCetak(Request $request)
    {
        $tanggal         = $request->query('tanggal');
        $tanggal_mulai   = $request->query('tanggal_mulai');
        $tanggal_selesai = $request->query('tanggal_selesai');
        $search          = $request->query('search');
        $status_suasana  = $request->query('status_suasana');

        $query = JurnalPiket::with('guru');

        if ($tanggal_mulai && $tanggal_selesai) {
            $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
        } elseif ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('catatan_kejadian', 'like', "%{$search}%")
                  ->orWhere('nama_petugas_piket', 'like', "%{$search}%")
                  ->orWhereHas('guru', function($g) use ($search) {
                      $g->where('nama_guru', 'like', "%{$search}%");
                  });
            });
        }

        if ($status_suasana) {
            $query->where('status_suasana', $status_suasana);
        }

        $jurnalsPiket = $query->orderBy('tanggal', 'desc')->get();

        return view('admin.jurnal_piket.print', compact('jurnalsPiket', 'tanggal', 'tanggal_mulai', 'tanggal_selesai'));
    }

    // Fitur 13: Monitoring Kehadiran (Analytics Dashboard & Charts)
    public function monitoringKehadiran(Request $request)
    {
        if (auth()->check() && auth()->user()->isTu()) {
            return redirect()->route('admin.dashboard')->with('error', 'Halaman Monitoring Kehadiran tidak dapat diakses oleh role Tata Usaha (TU).');
        }

        $filterTanggal = $request->query('tanggal', Carbon::today()->toDateString());

        // Guru Kehadiran Stats
        $guruHadirCount      = JurnalMengajar::whereDate('tanggal', $filterTanggal)->where('status_kehadiran_guru', 'Hadir')->count();
        $guruIzinCount       = JurnalMengajar::whereDate('tanggal', $filterTanggal)->where('status_kehadiran_guru', 'Izin')->count();
        $guruSakitCount      = JurnalMengajar::whereDate('tanggal', $filterTanggal)->where('status_kehadiran_guru', 'Sakit')->count();
        $guruAlpaCount       = JurnalMengajar::whereDate('tanggal', $filterTanggal)->where('status_kehadiran_guru', 'Tanpa Keterangan')->count();
        $guruTidakHadirCount = $guruIzinCount + $guruSakitCount + $guruAlpaCount;

        // Siswa Ketidakhadiran (Distinct count per id_siswa agar tidak terhitung ganda jika ada beberapa jam pelajaran)
        $siswaIzinCount  = JurnalDetailKetidakhadiran::whereHas('jurnal', function($q) use ($filterTanggal) {
            $q->whereDate('tanggal', $filterTanggal);
        })->where('keterangan', 'Izin')->distinct('id_siswa')->count('id_siswa');

        $siswaSakitCount = JurnalDetailKetidakhadiran::whereHas('jurnal', function($q) use ($filterTanggal) {
            $q->whereDate('tanggal', $filterTanggal);
        })->where('keterangan', 'Sakit')->distinct('id_siswa')->count('id_siswa');

        $siswaAlfaCount  = JurnalDetailKetidakhadiran::whereHas('jurnal', function($q) use ($filterTanggal) {
            $q->whereDate('tanggal', $filterTanggal);
        })->where('keterangan', 'Alpa')->distinct('id_siswa')->count('id_siswa');

        $siswaTidakHadirCount = $siswaIzinCount + $siswaSakitCount + $siswaAlfaCount;

        // Dapatkan list ID kelas yang menggelar pembelajaran / mengisi jurnal pada tanggal ini
        $activeKelasIds = JurnalMengajar::whereDate('tanggal', $filterTanggal)
            ->join('jadwal', 'jurnal_mengajar.id_jadwal', '=', 'jadwal.id_jadwal')
            ->pluck('jadwal.id_kelas')
            ->unique();

        if ($activeKelasIds->count() > 0) {
            $totalSiswaAktif = Siswa::whereIn('id_kelas', $activeKelasIds)->count();
        } else {
            $totalSiswaAktif = Siswa::count();
        }

        $siswaHadirCount = max(0, $totalSiswaAktif - $siswaTidakHadirCount);

        // Data Rincian Kehadiran Guru Hari Ini
        $guruAttendanceDetails = JurnalMengajar::with(['jadwal.kelas', 'jadwal.guru', 'jadwal.mapel', 'jadwal.ruangan'])
            ->whereDate('tanggal', $filterTanggal)
            ->orderBy('id_jurnal', 'desc')
            ->get();

        // Data Rincian Ketidakhadiran Siswa Hari Ini
        $siswaAbsentDetails = JurnalDetailKetidakhadiran::with([
            'siswa.kelas',
            'jurnal.jadwal.guru',
            'jurnal.jadwal.mapel'
        ])
        ->whereHas('jurnal', function($q) use ($filterTanggal) {
            $q->whereDate('tanggal', $filterTanggal);
        })
        ->get();

        // Chart Data 7 Hari Terakhir
        $datesArray = [];
        $jurnalCounts = [];
        $siswaAbsenCounts = [];

        for ($i = 6; $i >= 0; $i--) {
            $dateStr = Carbon::today()->subDays($i)->toDateString();
            $labelStr = Carbon::today()->subDays($i)->format('d M');
            $datesArray[] = $labelStr;

            $jurnalCounts[] = JurnalMengajar::whereDate('tanggal', $dateStr)->count();
            $siswaAbsenCounts[] = JurnalDetailKetidakhadiran::whereHas('jurnal', function($q) use ($dateStr) {
                $q->whereDate('tanggal', $dateStr);
            })->distinct('id_siswa')->count('id_siswa');
        }

        return view('admin.monitoring_kehadiran', compact(
            'filterTanggal',
            'guruHadirCount',
            'guruTidakHadirCount',
            'guruIzinCount',
            'guruSakitCount',
            'guruAlpaCount',
            'siswaHadirCount',
            'siswaIzinCount',
            'siswaSakitCount',
            'siswaAlfaCount',
            'totalSiswaAktif',
            'guruAttendanceDetails',
            'siswaAbsentDetails',
            'datesArray',
            'jurnalCounts',
            'siswaAbsenCounts'
        ));
    }
}
