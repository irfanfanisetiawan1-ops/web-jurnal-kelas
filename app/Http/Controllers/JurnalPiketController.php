<?php

namespace App\Http\Controllers;

use App\Models\JurnalPiket;
use App\Models\Guru;
use Illuminate\Http\Request;

class JurnalPiketController extends Controller
{
    /**
     * [READ] Tampilkan daftar jurnal piket aktif
     */
    public function index()
    {
        $jurnals = JurnalPiket::with('guru')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id_jurnal_piket', 'desc')
            ->get();

        $trashedCount = JurnalPiket::onlyTrashed()->count();

        return view('jurnal_piket.index', compact('jurnals', 'trashedCount'));
    }

    /**
     * [CREATE] Tampilkan form tambah jurnal piket
     */
    public function create()
    {
        $guruList      = Guru::orderBy('nama_guru')->get();
        $statusOptions = ['Kondusif', 'Ada Kejadian', 'Lainnya'];

        return view('jurnal_piket.create', compact('guruList', 'statusOptions'));
    }

    /**
     * [STORE] Simpan jurnal piket baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'             => 'required|date',
            'id_guru'             => 'nullable|exists:guru,id_guru',
            'nama_petugas_piket'  => 'required|string|max:100',
            'jam_piket'           => 'required|string|max:50',
            'catatan_kejadian'    => 'nullable|string',
            'status_suasana'      => 'required|in:Kondusif,Ada Kejadian,Lainnya',
        ], [
            'tanggal.required'            => 'Tanggal wajib diisi.',
            'nama_petugas_piket.required' => 'Nama petugas piket wajib diisi.',
            'jam_piket.required'          => 'Jam piket wajib diisi.',
            'status_suasana.required'     => 'Status suasana wajib dipilih.',
            'status_suasana.in'           => 'Status suasana tidak valid.',
        ]);

        JurnalPiket::create([
            'tanggal'            => $request->tanggal,
            'id_guru'            => $request->id_guru,
            'nama_petugas_piket' => $request->nama_petugas_piket,
            'jam_piket'          => $request->jam_piket,
            'catatan_kejadian'   => $request->catatan_kejadian,
            'status_suasana'     => $request->status_suasana,
        ]);

        return redirect()->route('jurnal-piket.index')
                         ->with('success', 'Data jurnal piket berhasil ditambahkan!');
    }

    /**
     * [SHOW] Detail jurnal piket
     */
    public function show($id)
    {
        $jurnal = JurnalPiket::with('guru')->findOrFail($id);
        return view('jurnal_piket.show', compact('jurnal'));
    }

    /**
     * [EDIT] Tampilkan form edit jurnal piket
     */
    public function edit($id)
    {
        $jurnal        = JurnalPiket::with('guru')->findOrFail($id);
        $guruList      = Guru::orderBy('nama_guru')->get();
        $statusOptions = ['Kondusif', 'Ada Kejadian', 'Lainnya'];

        return view('jurnal_piket.edit', compact('jurnal', 'guruList', 'statusOptions'));
    }

    /**
     * [UPDATE] Perbarui jurnal piket
     */
    public function update(Request $request, $id)
    {
        $jurnal = JurnalPiket::findOrFail($id);

        $request->validate([
            'tanggal'             => 'required|date',
            'id_guru'             => 'nullable|exists:guru,id_guru',
            'nama_petugas_piket'  => 'required|string|max:100',
            'jam_piket'           => 'required|string|max:50',
            'catatan_kejadian'    => 'nullable|string',
            'status_suasana'      => 'required|in:Kondusif,Ada Kejadian,Lainnya',
        ], [
            'tanggal.required'            => 'Tanggal wajib diisi.',
            'nama_petugas_piket.required' => 'Nama petugas piket wajib diisi.',
            'jam_piket.required'          => 'Jam piket wajib diisi.',
            'status_suasana.required'     => 'Status suasana wajib dipilih.',
            'status_suasana.in'           => 'Status suasana tidak valid.',
        ]);

        $jurnal->update([
            'tanggal'            => $request->tanggal,
            'id_guru'            => $request->id_guru,
            'nama_petugas_piket' => $request->nama_petugas_piket,
            'jam_piket'          => $request->jam_piket,
            'catatan_kejadian'   => $request->catatan_kejadian,
            'status_suasana'     => $request->status_suasana,
        ]);

        return redirect()->route('jurnal-piket.index')
                         ->with('success', 'Data jurnal piket berhasil diperbarui!');
    }

    /**
     * [SOFT DELETE] Pindahkan ke sampah
     */
    public function destroy($id)
    {
        $jurnal = JurnalPiket::findOrFail($id);
        $info   = $jurnal->nama_petugas_piket . ' (' . $jurnal->tanggal . ')';
        $jurnal->delete();

        return redirect()->route('jurnal-piket.index')
                         ->with('success', "Jurnal piket \"$info\" dipindahkan ke Sampah.");
    }

    /**
     * [TRASH] Tampilkan daftar yang di-soft-delete
     */
    public function trash()
    {
        $jurnals = JurnalPiket::onlyTrashed()
            ->with('guru')
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('jurnal_piket.trash', compact('jurnals'));
    }

    /**
     * [RESTORE] Pulihkan dari sampah
     */
    public function restore($id)
    {
        $jurnal = JurnalPiket::onlyTrashed()->findOrFail($id);
        $jurnal->restore();

        return redirect()->route('jurnal-piket.trash')
                         ->with('success', "Jurnal piket \"{$jurnal->nama_petugas_piket}\" berhasil dipulihkan!");
    }

    /**
     * [FORCE DELETE] Hapus permanen
     */
    public function forceDelete($id)
    {
        $jurnal = JurnalPiket::onlyTrashed()->findOrFail($id);
        $nama   = $jurnal->nama_petugas_piket;
        $jurnal->forceDelete();

        return redirect()->route('jurnal-piket.trash')
                         ->with('success', "Jurnal piket \"$nama\" telah dihapus permanen.");
    }
}
