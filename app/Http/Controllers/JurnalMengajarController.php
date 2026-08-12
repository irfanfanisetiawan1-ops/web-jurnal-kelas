<?php

namespace App\Http\Controllers;

use App\Models\JurnalMengajar;
use App\Models\JurnalDetailKetidakhadiran;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;

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
    public function create()
    {
        $jadwals = Jadwal::with(['kelas', 'guru', 'mapel', 'ruangan'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('id_jam_mulai', 'asc')
            ->get();

        $statusOptions = ['Hadir', 'Izin', 'Sakit', 'Tanpa Keterangan'];

        return view('jurnal_mengajar.create', compact('jadwals', 'statusOptions'));
    }

    /**
     * API Response untuk mengambil daftar siswa berdasarkan ID Jadwal (Kelas)
     */
    public function getSiswaByJadwal($id_jadwal)
    {
        $jadwal = Jadwal::find($id_jadwal);
        if (!$jadwal) {
            return response()->json([], 404);
        }

        $siswas = Siswa::where('id_kelas', $jadwal->id_kelas)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        return response()->json([
            'kelas' => $jadwal->kelas->nama_kelas ?? '-',
            'siswas' => $siswas
        ]);
    }

    /**
     * [STORE] Memproses & menyimpan data jurnal mengajar ke database
     */
    public function store(Request $request)
    {
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

        $jurnal = JurnalMengajar::create([
            'id_jadwal'             => $request->id_jadwal,
            'tanggal'               => $request->tanggal,
            'status_kehadiran_guru' => $request->status_kehadiran_guru,
            'materi'                => $request->materi,
            'catatan'               => $request->catatan,
            'dicatat_pada'          => now(),
        ]);

        // Simpan detail ketidakhadiran siswa jika ada
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
