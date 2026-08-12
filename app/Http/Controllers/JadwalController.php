<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Ruangan;
use App\Models\JamPelajaran;
use Illuminate\Http\Request;

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
     * [STORE] Memproses & menyimpan data jadwal baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kelas'       => 'required|exists:kelas,id_kelas',
            'id_guru'        => 'required|exists:guru,id_guru',
            'id_mapel'       => 'required|exists:mapel,id_mapel',
            'id_ruangan'     => 'required|exists:ruangan,id_ruangan',
            'hari'           => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'id_jam_mulai'   => 'required|exists:jam_pelajaran,id_jam',
            'id_jam_selesai' => 'required|exists:jam_pelajaran,id_jam',
        ], [
            'id_kelas.required'       => 'Kelas wajib dipilih.',
            'id_kelas.exists'         => 'Kelas yang dipilih tidak valid.',
            'id_guru.required'        => 'Guru wajib dipilih.',
            'id_guru.exists'          => 'Guru yang dipilih tidak valid.',
            'id_mapel.required'       => 'Mata Pelajaran wajib dipilih.',
            'id_mapel.exists'         => 'Mata Pelajaran yang dipilih tidak valid.',
            'id_ruangan.required'     => 'Ruangan wajib dipilih.',
            'id_ruangan.exists'       => 'Ruangan yang dipilih tidak valid.',
            'hari.required'           => 'Hari wajib dipilih.',
            'hari.in'                 => 'Hari pilihan tidak valid.',
            'id_jam_mulai.required'   => 'Jam Mulai wajib dipilih.',
            'id_jam_mulai.exists'     => 'Jam Mulai yang dipilih tidak valid di Master Jam Pelajaran.',
            'id_jam_selesai.required' => 'Jam Selesai wajib dipilih.',
            'id_jam_selesai.exists'   => 'Jam Selesai yang dipilih tidak valid di Master Jam Pelajaran.',
        ]);

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
            (int) $request->id_ruangan,
            (int) $request->id_mapel
        );

        if ($conflictError) {
            return back()->withInput()->withErrors(['conflict' => $conflictError]);
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

        return redirect()->route('jadwal.index')
                         ->with('success', 'Data jadwal pelajaran berhasil ditambahkan!');
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

        $request->validate([
            'id_kelas'       => 'required|exists:kelas,id_kelas',
            'id_guru'        => 'required|exists:guru,id_guru',
            'id_mapel'       => 'required|exists:mapel,id_mapel',
            'id_ruangan'     => 'required|exists:ruangan,id_ruangan',
            'hari'           => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'id_jam_mulai'   => 'required|exists:jam_pelajaran,id_jam',
            'id_jam_selesai' => 'required|exists:jam_pelajaran,id_jam',
        ], [
            'id_kelas.required'       => 'Kelas wajib dipilih.',
            'id_kelas.exists'         => 'Kelas tidak ditemukan.',
            'id_guru.required'        => 'Guru wajib dipilih.',
            'id_guru.exists'          => 'Guru tidak ditemukan.',
            'id_mapel.required'       => 'Mata Pelajaran wajib dipilih.',
            'id_mapel.exists'         => 'Mata Pelajaran tidak ditemukan.',
            'id_ruangan.required'     => 'Ruangan wajib dipilih.',
            'id_ruangan.exists'       => 'Ruangan tidak ditemukan.',
            'hari.required'           => 'Hari wajib dipilih.',
            'hari.in'                 => 'Hari pilihan tidak valid.',
            'id_jam_mulai.required'   => 'Jam Mulai wajib dipilih.',
            'id_jam_mulai.exists'     => 'Jam Mulai yang dipilih tidak ditemukan di Master Jam Pelajaran.',
            'id_jam_selesai.required' => 'Jam Selesai wajib dipilih.',
            'id_jam_selesai.exists'   => 'Jam Selesai yang dipilih tidak ditemukan di Master Jam Pelajaran.',
        ]);

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
            (int) $request->id_ruangan,
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
            'id_ruangan'     => $request->id_ruangan,
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
