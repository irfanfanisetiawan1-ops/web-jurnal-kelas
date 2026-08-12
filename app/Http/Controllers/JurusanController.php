<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * [READ] Tampilkan daftar jurusan aktif
     */
    public function index()
    {
        $jurusans     = Jurusan::orderBy('nama_jurusan')->get();
        $trashedCount = Jurusan::onlyTrashed()->count();

        return view('jurusan.index', compact('jurusans', 'trashedCount'));
    }

    /**
     * [CREATE] Tampilkan form tambah jurusan
     */
    public function create()
    {
        return view('jurusan.create');
    }

    /**
     * [STORE] Simpan jurusan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required|string|max:20|unique:jurusan,kode_jurusan',
            'nama_jurusan' => 'required|string|max:100',
        ], [
            'kode_jurusan.required' => 'Kode jurusan wajib diisi.',
            'kode_jurusan.unique'   => 'Kode jurusan sudah digunakan.',
            'nama_jurusan.required' => 'Nama jurusan wajib diisi.',
        ]);

        Jurusan::create([
            'kode_jurusan' => strtoupper($request->kode_jurusan),
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('jurusan.index')
                         ->with('success', 'Data jurusan berhasil ditambahkan!');
    }

    /**
     * [SHOW] Detail jurusan
     */
    public function show(Jurusan $jurusan)
    {
        return view('jurusan.show', compact('jurusan'));
    }

    /**
     * [EDIT] Form edit jurusan
     */
    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    /**
     * [UPDATE] Perbarui data jurusan
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'kode_jurusan' => 'required|string|max:20|unique:jurusan,kode_jurusan,' . $jurusan->id_jurusan . ',id_jurusan',
            'nama_jurusan' => 'required|string|max:100',
        ], [
            'kode_jurusan.required' => 'Kode jurusan wajib diisi.',
            'kode_jurusan.unique'   => 'Kode jurusan sudah digunakan oleh jurusan lain.',
            'nama_jurusan.required' => 'Nama jurusan wajib diisi.',
        ]);

        $jurusan->update([
            'kode_jurusan' => strtoupper($request->kode_jurusan),
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('jurusan.index')
                         ->with('success', 'Data jurusan berhasil diperbarui!');
    }

    /**
     * [SOFT DELETE] Pindahkan ke sampah
     */
    public function destroy(Jurusan $jurusan)
    {
        $nama = $jurusan->nama_jurusan;
        $jurusan->delete();

        return redirect()->route('jurusan.index')
                         ->with('success', "Jurusan \"$nama\" dipindahkan ke Sampah.");
    }

    /**
     * [TRASH] Tampilkan daftar yang di-soft-delete
     */
    public function trash()
    {
        $jurusans = Jurusan::onlyTrashed()->orderBy('nama_jurusan')->get();
        return view('jurusan.trash', compact('jurusans'));
    }

    /**
     * [RESTORE] Pulihkan dari sampah
     */
    public function restore($id)
    {
        $jurusan = Jurusan::onlyTrashed()->findOrFail($id);
        $jurusan->restore();

        return redirect()->route('jurusan.trash')
                         ->with('success', "Jurusan \"{$jurusan->nama_jurusan}\" berhasil dipulihkan!");
    }

    /**
     * [FORCE DELETE] Hapus permanen
     */
    public function forceDelete($id)
    {
        $jurusan = Jurusan::onlyTrashed()->findOrFail($id);
        $nama    = $jurusan->nama_jurusan;
        $jurusan->forceDelete();

        return redirect()->route('jurusan.trash')
                         ->with('success', "Jurusan \"$nama\" telah dihapus permanen.");
    }
}
