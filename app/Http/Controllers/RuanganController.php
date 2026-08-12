<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * [READ] Tampilkan daftar ruangan aktif (yang belum di-soft-delete)
     */
    public function index()
    {
        $ruangans = Ruangan::withCount('jadwals')->orderBy('nama_ruangan', 'asc')->get();
        $ruangan  = $ruangans;
        $trashedCount = Ruangan::onlyTrashed()->count();

        return view('ruangan.index', compact('ruangans', 'ruangan', 'trashedCount'));
    }

    /**
     * [CREATE] Menampilkan form tambah ruangan
     */
    public function create()
    {
        $jenisOptions = ['Kelas Biasa', 'Lab', 'Ruang Praktik', 'Lainnya'];
        return view('ruangan.create', compact('jenisOptions'));
    }

    /**
     * [STORE] Memproses & menyimpan data ruangan baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan'  => 'required|string|max:50|unique:ruangan,nama_ruangan',
            'jenis_ruangan' => 'required|in:Kelas Biasa,Lab,Ruang Praktik,Lainnya',
        ], [
            'nama_ruangan.required'  => 'Nama Ruangan wajib diisi.',
            'nama_ruangan.max'       => 'Nama Ruangan maksimal 50 karakter.',
            'nama_ruangan.unique'    => 'Nama Ruangan tersebut sudah terdaftar.',
            'jenis_ruangan.required' => 'Jenis Ruangan wajib dipilih.',
            'jenis_ruangan.in'       => 'Pilihan jenis ruangan tidak valid.',
        ]);

        Ruangan::create([
            'nama_ruangan'  => trim($request->nama_ruangan),
            'jenis_ruangan' => $request->jenis_ruangan,
        ]);

        return redirect()->route('ruangan.index')
                         ->with('success', 'Data ruangan berhasil ditambahkan!');
    }

    /**
     * [SHOW] Menampilkan detail data 1 ruangan beserta jadwal pemakaiannya
     */
    public function show($id)
    {
        $ruangan = Ruangan::with(['jadwals.kelas', 'jadwals.guru', 'jadwals.mapel'])->findOrFail($id);
        return view('ruangan.show', compact('ruangan'));
    }

    /**
     * [EDIT] Menampilkan form edit data ruangan
     */
    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $jenisOptions = ['Kelas Biasa', 'Lab', 'Ruang Praktik', 'Lainnya'];
        return view('ruangan.edit', compact('ruangan', 'jenisOptions'));
    }

    /**
     * [UPDATE] Memproses perubahan data ruangan di database
     */
    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);

        $request->validate([
            'nama_ruangan'  => 'required|string|max:50|unique:ruangan,nama_ruangan,' . $ruangan->id_ruangan . ',id_ruangan',
            'jenis_ruangan' => 'required|in:Kelas Biasa,Lab,Ruang Praktik,Lainnya',
        ], [
            'nama_ruangan.required'  => 'Nama Ruangan wajib diisi.',
            'nama_ruangan.max'       => 'Nama Ruangan maksimal 50 karakter.',
            'nama_ruangan.unique'    => 'Nama Ruangan sudah digunakan oleh ruangan lain.',
            'jenis_ruangan.required' => 'Jenis Ruangan wajib dipilih.',
            'jenis_ruangan.in'       => 'Pilihan jenis ruangan tidak valid.',
        ]);

        $ruangan->update([
            'nama_ruangan'  => trim($request->nama_ruangan),
            'jenis_ruangan' => $request->jenis_ruangan,
        ]);

        return redirect()->route('ruangan.index')
                         ->with('success', 'Data ruangan berhasil diperbarui!');
    }

    /**
     * [SOFT DELETE] Tandai ruangan sebagai dihapus (mengisi deleted_at)
     */
    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $nama = $ruangan->nama_ruangan;
        $ruangan->delete();

        return redirect()->route('ruangan.index')
                         ->with('success', "Data ruangan \"$nama\" berhasil dipindahkan ke Tempat Sampah.");
    }

    /**
     * [TRASH] Menampilkan daftar ruangan yang di-soft-delete (Recycle Bin)
     */
    public function trash()
    {
        $ruangans = Ruangan::onlyTrashed()->withCount('jadwals')->orderBy('nama_ruangan')->get();
        return view('ruangan.trash', compact('ruangans'));
    }

    /**
     * [RESTORE] Pulihkan data ruangan yang ada di tempat sampah
     */
    public function restore($id)
    {
        $ruangan = Ruangan::onlyTrashed()->findOrFail($id);
        $ruangan->restore();

        return redirect()->route('ruangan.trash')
                         ->with('success', "Data ruangan \"{$ruangan->nama_ruangan}\" berhasil dipulihkan!");
    }

    /**
     * [FORCE DELETE] Hapus permanen dari database
     */
    public function forceDelete($id)
    {
        $ruangan = Ruangan::onlyTrashed()->findOrFail($id);
        $nama = $ruangan->nama_ruangan;
        $ruangan->forceDelete();

        return redirect()->route('ruangan.trash')
                         ->with('success', "Data ruangan \"$nama\" telah dihapus secara permanen dari database.");
    }
}
