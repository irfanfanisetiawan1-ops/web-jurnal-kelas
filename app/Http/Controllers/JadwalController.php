<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Ruangan;
use App\Models\JamPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    /**
     * [READ] Tampilkan daftar jadwal aktif (yang belum di-soft-delete)
     */
    /**
     * [READ] Tampilkan daftar jadwal aktif (yang belum di-soft-delete)
     */
    public function index(Request $request)
    {
        $search      = $request->query('search');
        $selected_id = $request->query('selected_id');

        $query = Jadwal::with(['kelas.waliKelas', 'kelas.jurusan', 'guru.user', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai']);

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        if ($request->filled('id_kelas')) {
            $query->where('id_kelas', $request->id_kelas);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('guru', function($g) use ($search) {
                    $g->where('nama_guru', 'like', "%{$search}%");
                })->orWhereHas('mapel', function($m) use ($search) {
                    $m->where('nama_mapel', 'like', "%{$search}%");
                })->orWhereHas('ruangan', function($r) use ($search) {
                    $r->where('nama_ruangan', 'like', "%{$search}%");
                })->orWhereHas('kelas', function($k) use ($search) {
                    $k->where('nama_kelas', 'like', "%{$search}%");
                });
            });
        }

        $jadwals = $query->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('id_jam_mulai', 'asc')
            ->paginate(50)
            ->withQueryString();

        $jadwal  = $jadwals;
        $trashedCount = Jadwal::onlyTrashed()->count();
        $jamPelajarans = JamPelajaran::orderBy('id_jam')->get();
        $kelases  = Kelas::orderBy('nama_kelas')->get();
        $gurus    = Guru::with(['user', 'mapel'])
            ->where(function($q) {
                $q->whereDoesntHave('user')
                  ->orWhereHas('user', function($u) {
                      $u->where('status_verifikasi', 'verified');
                  });
            })
            ->orderBy('nama_guru', 'asc')
            ->get();
        $mapels   = Mapel::orderBy('nama_mapel')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        // Selected Jadwal for Detail Panel (Matching Mapel Page design)
        $selectedJadwal = null;
        if ($selected_id) {
            $selectedJadwal = Jadwal::with(['kelas.waliKelas', 'kelas.jurusan', 'guru.user', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai'])->find($selected_id);
        }

        if (!$selectedJadwal && $jadwals->count() > 0) {
            $selectedJadwal = $jadwals->first();
        }

        return view('jadwal.index', compact('jadwals', 'jadwal', 'selectedJadwal', 'selected_id', 'trashedCount', 'jamPelajarans', 'kelases', 'gurus', 'mapels', 'ruangans'));
    }

    /**
     * [CREATE] Menampilkan form tambah jadwal
     */
    public function create()
    {
        $kelases  = Kelas::orderBy('nama_kelas')->get();
        $gurus    = Guru::with(['user', 'mapel'])
            ->where(function($q) {
                $q->whereDoesntHave('user')
                  ->orWhereHas('user', function($u) {
                      $u->where('status_verifikasi', 'verified');
                  });
            })
            ->orderBy('nama_guru', 'asc')
            ->get();
        $mapels   = Mapel::orderBy('nama_mapel')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        $jamPelajarans = JamPelajaran::orderBy('id_jam')->get();
        $hariOptions = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('jadwal.create', compact('kelases', 'gurus', 'mapels', 'ruangans', 'hariOptions', 'jamPelajarans'));
    }

    /**
     * Helper privat untuk memproses id_ruangan, termasuk opsi custom / ketik manual
     */
    private function resolveRuanganId(Request $request)
    {
        $idRuangan = $request->id_ruangan;
        $namaCustom = trim($request->nama_ruangan_custom ?? '');

        if ($idRuangan === 'custom' || (!empty($namaCustom) && ($idRuangan === 'custom' || empty($idRuangan)))) {
            if (empty($namaCustom)) {
                return null;
            }

            // Cek apakah nama ruangan sudah ada di database (case-insensitive)
            $existing = Ruangan::where('nama_ruangan', 'like', $namaCustom)->first();
            if ($existing) {
                return $existing->id_ruangan;
            }

            // Buat ruangan baru jika belum ada
            $newRuangan = Ruangan::create([
                'nama_ruangan'  => $namaCustom,
                'jenis_ruangan' => 'Kelas Biasa',
            ]);

            return $newRuangan->id_ruangan;
        }

        return $idRuangan ? (int)$idRuangan : null;
    }

    /**
     * [STORE] Memproses & menyimpan data jadwal baru ke database
     */
    public function store(Request $request)
    {
        $rules = [
            'id_kelas'       => 'required|exists:kelas,id_kelas',
            'id_guru'        => 'required|exists:guru,id_guru',
            'id_mapel'       => 'required|exists:mapel,id_mapel',
            'id_ruangan'     => 'required',
            'hari'           => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'id_jam_mulai'   => 'required|exists:jam_pelajaran,id_jam',
            'id_jam_selesai' => 'required|exists:jam_pelajaran,id_jam',
        ];

        $messages = [
            'id_kelas.required'       => 'Kelas wajib dipilih.',
            'id_kelas.exists'         => 'Kelas yang dipilih tidak valid.',
            'id_guru.required'        => 'Guru wajib dipilih.',
            'id_guru.exists'          => 'Guru yang dipilih tidak valid.',
            'id_mapel.required'       => 'Mata Pelajaran wajib dipilih.',
            'id_mapel.exists'         => 'Mata Pelajaran yang dipilih tidak valid.',
            'id_ruangan.required'     => 'Ruangan wajib dipilih atau diisi.',
            'hari.required'           => 'Hari wajib dipilih.',
            'hari.in'                 => 'Hari pilihan tidak valid.',
            'id_jam_mulai.required'   => 'Jam Mulai wajib dipilih.',
            'id_jam_mulai.exists'     => 'Jam Mulai yang dipilih tidak valid di Master Jam Pelajaran.',
            'id_jam_selesai.required' => 'Jam Selesai wajib dipilih.',
            'id_jam_selesai.exists'   => 'Jam Selesai yang dipilih tidak valid di Master Jam Pelajaran.',
        ];

        if ($request->id_ruangan === 'custom') {
            $rules['nama_ruangan_custom'] = 'required|string|max:50';
            $messages['nama_ruangan_custom.required'] = 'Nama Ruangan Baru (Custom) wajib diisi.';
        }

        $request->validate($rules, $messages);

        $ruanganId = $this->resolveRuanganId($request);
        if (!$ruanganId) {
            return back()->withInput()->withErrors(['id_ruangan' => 'Ruangan wajib dipilih atau diisi dengan benar.']);
        }

        if ((int) $request->id_jam_selesai < (int) $request->id_jam_mulai) {
            return back()->withInput()->withErrors(['id_jam_selesai' => 'Jam selesai tidak boleh lebih kecil dari jam mulai.']);
        }

        if (in_array($request->hari, ['Senin', 'Selasa', 'Rabu', 'Kamis'])) {
            if ((int) $request->id_jam_mulai > 10 || (int) $request->id_jam_selesai > 10) {
                return back()->withInput()->withErrors(['id_jam_selesai' => "Untuk hari {$request->hari}, jam pelajaran maksimal adalah Jam Ke-10 (sampai pukul 15:00 WIB). Jam ke-11 s/d 13 hanya berlaku pada hari Jumat."]);
            }
        }

        // Cek Bentrok (Conflict Check) & Duplikasi Persis
        $conflictError = $this->checkConflict(
            $request->hari,
            (int) $request->id_jam_mulai,
            (int) $request->id_jam_selesai,
            (int) $request->id_guru,
            (int) $request->id_kelas,
            (int) $ruanganId,
            (int) $request->id_mapel
        );

        if ($conflictError) {
            return back()->withInput()->withErrors(['conflict' => $conflictError]);
        }

        Jadwal::create([
            'id_kelas'       => $request->id_kelas,
            'id_guru'        => $request->id_guru,
            'id_mapel'       => $request->id_mapel,
            'id_ruangan'     => $ruanganId,
            'hari'           => $request->hari,
            'id_jam_mulai'   => $request->id_jam_mulai,
            'id_jam_selesai' => $request->id_jam_selesai,
        ]);

        return redirect()->route('jadwal.index')
                         ->with('success', 'Data jadwal pelajaran berhasil ditambahkan!');
    }

    /**
     * [DOWNLOAD TEMPLATE] Download Template File Excel/CSV untuk Import Jadwal Pelajaran Baru
     */
    public function downloadTemplate()
    {
        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=Template_Tambah_Jadwal_Pelajaran.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['NO', 'HARI', 'JAM MULAI (KE-)', 'JAM SELESAI (KE-)', 'GURU PENGAMPU', 'MATA PELAJARAN', 'RUANGAN', 'KELAS TARGET'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);

            fputcsv($file, [1, 'Senin', 1, 3, 'Eko Saputro, S.Pd', 'Pemrograman Web', 'Lab. RPL 1', 'X RPL 1']);
            fputcsv($file, [2, 'Senin', 4, 6, 'Diana Hartanti, S.T., M.Pd', 'Basis Data', 'Lab. RPL 1', 'X RPL 1']);
            fputcsv($file, [3, 'Senin', 7, 10, 'Budi Santoso, S.Pd', 'Matematika', 'Ruang Teori 04', 'X RPL 1']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * [STORE BATCH] Memproses & menyimpan banyak data jadwal sekaligus (berdasarkan per kelas)
     */
    public function storeBatch(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'items'    => 'required|array|min:1',
            'items.*.hari'           => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'items.*.id_jam_mulai'   => 'required|exists:jam_pelajaran,id_jam',
            'items.*.id_jam_selesai' => 'required|exists:jam_pelajaran,id_jam',
            'items.*.id_guru'        => 'required|exists:guru,id_guru',
            'items.*.id_mapel'       => 'required|exists:mapel,id_mapel',
            'items.*.id_ruangan'     => 'required',
        ], [
            'id_kelas.required' => 'Kelas target wajib dipilih.',
            'items.required'    => 'Minimal harus ada 1 baris data jadwal yang diisi.',
            'items.min'         => 'Minimal harus ada 1 baris data jadwal yang diisi.',
            'items.*.hari.required' => 'Hari wajib dipilih pada setiap baris.',
            'items.*.id_jam_mulai.required' => 'Jam Mulai wajib dipilih pada setiap baris.',
            'items.*.id_jam_selesai.required' => 'Jam Selesai wajib dipilih pada setiap baris.',
            'items.*.id_guru.required' => 'Guru Pengampu wajib dipilih pada setiap baris.',
            'items.*.id_mapel.required' => 'Mata Pelajaran wajib dipilih pada setiap baris.',
            'items.*.id_ruangan.required' => 'Ruangan wajib dipilih pada setiap baris.',
        ]);

        $idKelas = (int) $request->id_kelas;
        $kelas = Kelas::find($idKelas);
        $namaKelas = $kelas ? $kelas->nama_kelas : 'Kelas';

        $items = $request->items;
        $processedItems = [];
        $errors = [];
        $internalEntries = [];

        foreach ($items as $idx => $item) {
            $rowNum = $idx + 1;
            $hari = $item['hari'];
            $idJamMulai = (int) $item['id_jam_mulai'];
            $idJamSelesai = (int) $item['id_jam_selesai'];
            $idGuru = (int) $item['id_guru'];
            $idMapel = (int) $item['id_mapel'];
            $idRuanganRaw = $item['id_ruangan'];
            $namaRuanganCustom = trim($item['nama_ruangan_custom'] ?? '');

            // Resolve custom ruangan if selected
            $ruanganId = null;
            if ($idRuanganRaw === 'custom' || (!empty($namaRuanganCustom) && ($idRuanganRaw === 'custom' || empty($idRuanganRaw)))) {
                if (empty($namaRuanganCustom)) {
                    $errors[] = "Baris ke-{$rowNum}: Nama Ruangan Baru (Custom) wajib diisi jika memilih opsi custom.";
                    continue;
                }
                $existingR = Ruangan::where('nama_ruangan', 'like', $namaRuanganCustom)->first();
                if ($existingR) {
                    $ruanganId = $existingR->id_ruangan;
                } else {
                    $newR = Ruangan::create([
                        'nama_ruangan'  => $namaRuanganCustom,
                        'jenis_ruangan' => 'Kelas Biasa',
                    ]);
                    $ruanganId = $newR->id_ruangan;
                }
            } else {
                $ruanganId = (int) $idRuanganRaw;
            }

            // Validate Jam Selesai >= Jam Mulai
            if ($idJamSelesai < $idJamMulai) {
                $errors[] = "Baris ke-{$rowNum}: Jam Selesai (Ke-{$idJamSelesai}) tidak boleh lebih kecil dari Jam Mulai (Ke-{$idJamMulai}).";
                continue;
            }

            // Validate Monday-Thursday max Jam Ke-10
            if (in_array($hari, ['Senin', 'Selasa', 'Rabu', 'Kamis'])) {
                if ($idJamMulai > 10 || $idJamSelesai > 10) {
                    $errors[] = "Baris ke-{$rowNum}: Hari {$hari} jam pelajaran maksimal adalah Jam Ke-10 (07:00 - 15:00 WIB).";
                    continue;
                }
            }

            // Internal check against other rows in the SAME submitted batch
            foreach ($internalEntries as $prevIdx => $prev) {
                if ($prev['hari'] === $hari) {
                    if ($idJamMulai <= $prev['id_jam_selesai'] && $idJamSelesai >= $prev['id_jam_mulai']) {
                        $errors[] = "Baris ke-{$rowNum} bentrok dengan Baris ke-" . ($prevIdx + 1) . ": Terdapat tumpang tindih waktu jam pelajaran pada hari {$hari} (Jam Ke-{$idJamMulai} s/d {$idJamSelesai} dengan Jam Ke-{$prev['id_jam_mulai']} s/d {$prev['id_jam_selesai']}).";
                        if ($prev['id_guru'] == $idGuru) {
                            $errors[] = "Baris ke-{$rowNum} bentrok dengan Baris ke-" . ($prevIdx + 1) . ": Guru yang sama diinput pada jam & hari yang bersamaan.";
                        }
                        if ($prev['id_ruangan'] == $ruanganId) {
                            $errors[] = "Baris ke-{$rowNum} bentrok dengan Baris ke-" . ($prevIdx + 1) . ": Ruangan yang sama diinput pada jam & hari yang bersamaan.";
                        }
                    }
                }
            }

            // External check against database records
            $conflictError = $this->checkConflict(
                $hari,
                $idJamMulai,
                $idJamSelesai,
                $idGuru,
                $idKelas,
                $ruanganId,
                $idMapel
            );

            if ($conflictError) {
                $errors[] = "Baris ke-{$rowNum} (Hari {$hari}, Jam Ke-{$idJamMulai} s/d {$idJamSelesai}): " . $conflictError;
            }

            $internalEntries[] = [
                'hari'           => $hari,
                'id_jam_mulai'   => $idJamMulai,
                'id_jam_selesai' => $idJamSelesai,
                'id_guru'        => $idGuru,
                'id_ruangan'     => $ruanganId,
            ];

            $processedItems[] = [
                'id_kelas'       => $idKelas,
                'id_guru'        => $idGuru,
                'id_mapel'       => $idMapel,
                'id_ruangan'     => $ruanganId,
                'hari'           => $hari,
                'id_jam_mulai'   => $idJamMulai,
                'id_jam_selesai' => $idJamSelesai,
            ];
        }

        if (!empty($errors)) {
            return back()->withInput()->withErrors(['batch_errors' => $errors]);
        }

        // Save atomically in database transaction
        DB::transaction(function () use ($processedItems) {
            foreach ($processedItems as $itemData) {
                Jadwal::create($itemData);
            }
        });

        $totalAdded = count($processedItems);
        return redirect()->route('jadwal.index')
                         ->with('success', "Berhasil menambahkan {$totalAdded} data jadwal pelajaran secara cepat untuk {$namaKelas}!");
    }

    /**
     * [SHOW] Menampilkan detail data 1 jadwal
     */
    public function show($id)
    {
        $jadwal = Jadwal::with(['kelas.waliKelas', 'kelas.jurusan', 'guru.user', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai'])->findOrFail($id);
        return view('jadwal.show', compact('jadwal'));
    }

    /**
     * [EDIT] Menampilkan form edit data jadwal
     */
    public function edit($id)
    {
        $jadwal   = Jadwal::with(['jamMulai', 'jamSelesai'])->findOrFail($id);
        $kelases  = Kelas::orderBy('nama_kelas')->get();
        $gurus    = Guru::with(['user', 'mapel'])
            ->where(function($q) {
                $q->whereDoesntHave('user')
                  ->orWhereHas('user', function($u) {
                      $u->where('status_verifikasi', 'verified');
                  });
            })
            ->orderBy('nama_guru', 'asc')
            ->get();
        $mapels   = Mapel::orderBy('nama_mapel')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        $jamPelajarans = JamPelajaran::orderBy('id_jam')->get();
        $hariOptions = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('jadwal.edit', compact('jadwal', 'kelases', 'gurus', 'mapels', 'ruangans', 'hariOptions', 'jamPelajarans'));
    }

    /**
     * [UPDATE] Memproses perubahan data jadwal di database
     */
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $rules = [
            'id_kelas'       => 'required|exists:kelas,id_kelas',
            'id_guru'        => 'required|exists:guru,id_guru',
            'id_mapel'       => 'required|exists:mapel,id_mapel',
            'id_ruangan'     => 'required',
            'hari'           => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'id_jam_mulai'   => 'required|exists:jam_pelajaran,id_jam',
            'id_jam_selesai' => 'required|exists:jam_pelajaran,id_jam',
        ];

        $messages = [
            'id_kelas.required'       => 'Kelas wajib dipilih.',
            'id_kelas.exists'         => 'Kelas tidak ditemukan.',
            'id_guru.required'        => 'Guru wajib dipilih.',
            'id_guru.exists'          => 'Guru tidak ditemukan.',
            'id_mapel.required'       => 'Mata Pelajaran wajib dipilih.',
            'id_mapel.exists'         => 'Mata Pelajaran tidak ditemukan.',
            'id_ruangan.required'     => 'Ruangan wajib dipilih atau diisi.',
            'hari.required'           => 'Hari wajib dipilih.',
            'hari.in'                 => 'Hari pilihan tidak valid.',
            'id_jam_mulai.required'   => 'Jam Mulai wajib dipilih.',
            'id_jam_mulai.exists'     => 'Jam Mulai yang dipilih tidak ditemukan di Master Jam Pelajaran.',
            'id_jam_selesai.required' => 'Jam Selesai wajib dipilih.',
            'id_jam_selesai.exists'   => 'Jam Selesai yang dipilih tidak ditemukan di Master Jam Pelajaran.',
        ];

        if ($request->id_ruangan === 'custom') {
            $rules['nama_ruangan_custom'] = 'required|string|max:50';
            $messages['nama_ruangan_custom.required'] = 'Nama Ruangan Baru (Custom) wajib diisi.';
        }

        $request->validate($rules, $messages);

        $ruanganId = $this->resolveRuanganId($request);
        if (!$ruanganId) {
            return back()->withInput()->withErrors(['id_ruangan' => 'Ruangan wajib dipilih atau diisi dengan benar.']);
        }

        if ((int) $request->id_jam_selesai < (int) $request->id_jam_mulai) {
            return back()->withInput()->withErrors(['id_jam_selesai' => 'Jam selesai tidak boleh lebih kecil dari jam mulai.']);
        }

        if (in_array($request->hari, ['Senin', 'Selasa', 'Rabu', 'Kamis'])) {
            if ((int) $request->id_jam_mulai > 10 || (int) $request->id_jam_selesai > 10) {
                return back()->withInput()->withErrors(['id_jam_selesai' => "Untuk hari {$request->hari}, jam pelajaran maksimal adalah Jam Ke-10 (sampai pukul 15:00 WIB). Jam ke-11 s/d 13 hanya berlaku pada hari Jumat."]);
            }
        }

        // Cek Bentrok (Conflict Check), me-exclude ID jadwal saat ini
        $conflictError = $this->checkConflict(
            $request->hari,
            (int) $request->id_jam_mulai,
            (int) $request->id_jam_selesai,
            (int) $request->id_guru,
            (int) $request->id_kelas,
            (int) $ruanganId,
            (int) $request->id_mapel,
            (int) $id
        );

        if ($conflictError) {
            return back()->withInput()->withErrors(['conflict' => $conflictError]);
        }

        $jadwal->update([
            'id_kelas'       => $request->id_kelas,
            'id_guru'        => $request->id_guru,
            'id_mapel'       => $request->id_mapel,
            'id_ruangan'     => $ruanganId,
            'hari'           => $request->hari,
            'id_jam_mulai'   => $request->id_jam_mulai,
            'id_jam_selesai' => $request->id_jam_selesai,
        ]);

        return redirect()->route('jadwal.index')
                         ->with('success', 'Data jadwal pelajaran berhasil diperbarui!');
    }

    /**
     * Private Helper: Memeriksa bentrok jadwal (Guru, Kelas, Ruangan, Duplikat)
     */
    private function checkConflict($hari, $jamMulai, $jamSelesai, $idGuru, $idKelas, $idRuangan, $idMapel = null, $excludeId = null)
    {
        // 0. Pengecekan Data Ganda Persis
        $exactQuery = Jadwal::where('hari', $hari)
            ->where('id_kelas', $idKelas)
            ->where('id_guru', $idGuru)
            ->where('id_ruangan', $idRuangan)
            ->where('id_jam_mulai', $jamMulai)
            ->where('id_jam_selesai', $jamSelesai);
        
        if ($idMapel) {
            $exactQuery->where('id_mapel', $idMapel);
        }

        if ($excludeId) {
            $exactQuery->where('id_jadwal', '!=', $excludeId);
        }

        if ($exactQuery->exists()) {
            return "Data Ganda: Jadwal pelajaran dengan kriteria yang sama persis sudah ada pada Daftar Jadwal. Tidak boleh ada data ganda.";
        }

        $baseQuery = Jadwal::with(['kelas', 'guru', 'mapel', 'ruangan'])
            ->where('hari', $hari)
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->where('id_jam_mulai', '<=', $jamSelesai)
                  ->where('id_jam_selesai', '>=', $jamMulai);
            });

        if ($excludeId) {
            $baseQuery->where('id_jadwal', '!=', $excludeId);
        }

        // 1. Bentrok Guru
        $guruConflict = (clone $baseQuery)->where('id_guru', $idGuru)->first();
        if ($guruConflict) {
            $namaGuru = $guruConflict->guru->nama_guru ?? 'Guru';
            $namaKelas = $guruConflict->kelas->nama_kelas ?? 'Kelas';
            return "Bentrok Guru: {$namaGuru} sudah memiliki jadwal di kelas {$namaKelas} pada hari {$hari} (Jam ke-{$guruConflict->id_jam_mulai} s/d ke-{$guruConflict->id_jam_selesai}).";
        }

        // 2. Bentrok Kelas
        $kelasConflict = (clone $baseQuery)->where('id_kelas', $idKelas)->first();
        if ($kelasConflict) {
            $namaKelas = $kelasConflict->kelas->nama_kelas ?? 'Kelas';
            $namaMapel = $kelasConflict->mapel->nama_mapel ?? 'Mapel';
            return "Bentrok Kelas: {$namaKelas} sudah memiliki jadwal pelajaran {$namaMapel} pada hari {$hari} (Jam ke-{$kelasConflict->id_jam_mulai} s/d ke-{$kelasConflict->id_jam_selesai}).";
        }

        // 3. Bentrok Ruangan
        $ruanganConflict = (clone $baseQuery)->where('id_ruangan', $idRuangan)->first();
        if ($ruanganConflict) {
            $namaRuangan = $ruanganConflict->ruangan->nama_ruangan ?? 'Ruangan';
            $namaKelas   = $ruanganConflict->kelas->nama_kelas ?? 'Kelas';
            return "Bentrok Ruangan: {$namaRuangan} sedang digunakan oleh {$namaKelas} pada hari {$hari} (Jam ke-{$ruanganConflict->id_jam_mulai} s/d ke-{$ruanganConflict->id_jam_selesai}).";
        }

        return null;
    }

    /**
     * [SOFT DELETE] Tandai jadwal sebagai dihapus
     */
    public function destroy($id)
    {
        $jadwal = Jadwal::with(['kelas', 'mapel'])->findOrFail($id);
        $info   = ($jadwal->kelas->nama_kelas ?? 'Kelas') . ' - ' . ($jadwal->mapel->nama_mapel ?? 'Mapel');
        $jadwal->delete();

        return redirect()->route('jadwal.index')
                         ->with('success', "Data jadwal \"$info\" berhasil dipindahkan ke Tempat Sampah.");
    }

    /**
     * [SOFT DELETE BATCH] Tandai banyak jadwal sekaligus sebagai dihapus (Recycle Bin)
     */
    public function destroyBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:jadwal,id_jadwal',
        ], [
            'ids.required' => 'Pilih minimal 1 data jadwal yang ingin dihapus.',
            'ids.min'      => 'Pilih minimal 1 data jadwal yang ingin dihapus.',
        ]);

        $ids = $request->ids;
        $count = count($ids);

        Jadwal::whereIn('id_jadwal', $ids)->delete();

        return redirect()->route('jadwal.index')
                         ->with('success', "Berhasil memindahkan {$count} data jadwal pelajaran pilihan ke Tempat Sampah.");
    }

    /**
     * [TRASH] Menampilkan daftar jadwal yang di-soft-delete (Recycle Bin)
     */
    public function trash()
    {
        $jadwals = Jadwal::onlyTrashed()
            ->with(['kelas.waliKelas', 'guru.user', 'mapel', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->orderBy('deleted_at', 'desc')
            ->get();
        return view('jadwal.trash', compact('jadwals'));
    }

    /**
     * [RESTORE] Pulihkan data jadwal dari tempat sampah
     */
    public function restore($id)
    {
        $jadwal = Jadwal::onlyTrashed()->with(['kelas', 'mapel'])->findOrFail($id);
        $info   = ($jadwal->kelas->nama_kelas ?? 'Kelas') . ' - ' . ($jadwal->mapel->nama_mapel ?? 'Mapel');

        $conflictError = $this->checkConflict(
            $jadwal->hari,
            (int) $jadwal->id_jam_mulai,
            (int) $jadwal->id_jam_selesai,
            (int) $jadwal->id_guru,
            (int) $jadwal->id_kelas,
            (int) $jadwal->id_ruangan,
            (int) $jadwal->id_mapel,
            (int) $jadwal->id_jadwal
        );

        if ($conflictError) {
            return redirect()->route('jadwal.trash')
                             ->with('error', "Gagal memulihkan jadwal: " . $conflictError);
        }

        $jadwal->restore();

        return redirect()->route('jadwal.trash')
                         ->with('success', "Data jadwal \"$info\" berhasil dipulihkan!");
    }

    /**
     * [FORCE DELETE] Hapus permanen dari database
     */
    public function forceDelete($id)
    {
        $jadwal = Jadwal::onlyTrashed()->with(['kelas', 'mapel'])->findOrFail($id);
        $info   = ($jadwal->kelas->nama_kelas ?? 'Kelas') . ' - ' . ($jadwal->mapel->nama_mapel ?? 'Mapel');
        $jadwal->forceDelete();

        return redirect()->route('jadwal.trash')
                         ->with('success', "Data jadwal \"$info\" telah dihapus secara permanen dari database.");
    }
}
