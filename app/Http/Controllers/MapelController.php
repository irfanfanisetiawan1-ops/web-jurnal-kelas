<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * [READ] Tampilkan daftar mapel aktif (yang belum di-soft-delete)
     */
    public function index(Request $request)
    {
        $search      = $request->query('search');
        $selected_id = $request->query('selected_id');

        $query = Mapel::with(['gurus' => function($q) {
            $q->orderBy('nama_guru', 'asc');
        }])->withCount(['gurus as gurus_count' => function($q) {
            $q->select(\DB::raw('count(distinct jadwal.id_guru)'));
        }])->orderBy('nama_mapel', 'asc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_mapel', 'like', "%{$search}%")
                  ->orWhere('kode_mapel', 'like', "%{$search}%");
            });
        }

        $mapels       = $query->get();
        $trashedCount = Mapel::onlyTrashed()->count();

        // Selected Mapel for Detail Panel
        $selectedMapel = null;
        if ($selected_id) {
            $selectedMapel = Mapel::with(['gurus' => function($q) {
                $q->orderBy('nama_guru', 'asc');
            }])->withCount(['gurus as gurus_count' => function($q) {
                $q->select(\DB::raw('count(distinct jadwal.id_guru)'));
            }])->find($selected_id);
        }

        if (!$selectedMapel && $mapels->count() > 0) {
            $selectedMapel = $mapels->first();
        }

        return view('mapel.index', compact('mapels', 'selectedMapel', 'trashedCount', 'search', 'selected_id'));
    }

    /**
     * [CREATE] Menampilkan form tambah mapel
     */
    public function create()
    {
        return view('mapel.create');
    }

    /**
     * [STORE] Memproses & menyimpan data mapel baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:15|unique:mapel,kode_mapel',
            'nama_mapel' => 'required|string|max:100',
        ], [
            'kode_mapel.required' => 'Kode Mapel wajib diisi.',
            'kode_mapel.max'      => 'Kode Mapel maksimal 15 karakter.',
            'kode_mapel.unique'   => 'Kode Mapel sudah terdaftar di database.',
            'nama_mapel.required' => 'Nama Mapel wajib diisi.',
            'nama_mapel.max'      => 'Nama Mapel maksimal 100 karakter.',
        ]);

        $mapel = Mapel::create([
            'kode_mapel' => trim(strtoupper($request->kode_mapel)),
            'nama_mapel' => trim($request->nama_mapel),
        ]);

        return redirect()->route('mapel.index', ['selected_id' => $mapel->id_mapel])
                         ->with('success', 'Data mapel berhasil ditambahkan!');
    }

    /**
     * [SHOW] Menampilkan detail data 1 mapel beserta daftar guru pengampunya
     */
    public function show($id)
    {
        $mapel = Mapel::with(['gurus' => function($q) {
            $q->orderBy('nama_guru', 'asc');
        }])->withCount(['gurus as gurus_count' => function($q) {
            $q->select(\DB::raw('count(distinct jadwal.id_guru)'));
        }])->findOrFail($id);

        return view('mapel.show', compact('mapel'));
    }

    /**
     * [EDIT] Menampilkan form edit data mapel
     */
    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('mapel.edit', compact('mapel'));
    }

    /**
     * [UPDATE] Memproses perubahan data mapel di database
     */
    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

        $request->validate([
            'kode_mapel' => 'required|string|max:15|unique:mapel,kode_mapel,' . $mapel->id_mapel . ',id_mapel',
            'nama_mapel' => 'required|string|max:100',
        ], [
            'kode_mapel.required' => 'Kode Mapel wajib diisi.',
            'kode_mapel.max'      => 'Kode Mapel maksimal 15 karakter.',
            'kode_mapel.unique'   => 'Kode Mapel sudah digunakan oleh mapel lain.',
            'nama_mapel.required' => 'Nama Mapel wajib diisi.',
            'nama_mapel.max'      => 'Nama Mapel maksimal 100 karakter.',
        ]);

        $mapel->update([
            'kode_mapel' => trim(strtoupper($request->kode_mapel)),
            'nama_mapel' => trim($request->nama_mapel),
        ]);

        return redirect()->route('mapel.index')
                         ->with('success', 'Data mapel berhasil diperbarui!');
    }

    /**
     * [SOFT DELETE] Tandai mapel sebagai dihapus (mengisi deleted_at)
     */
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $nama = $mapel->nama_mapel;
        $mapel->delete();

        return redirect()->route('mapel.index')
                         ->with('success', "Data mapel \"$nama\" berhasil dipindahkan ke Tempat Sampah.");
    }

    /**
     * [TRASH] Menampilkan daftar mapel yang di-soft-delete (Recycle Bin)
     */
    public function trash()
    {
        $mapels = Mapel::onlyTrashed()->withCount(['gurus as gurus_count' => function($q) {
            $q->select(\DB::raw('count(distinct jadwal.id_guru)'));
        }])->orderBy('nama_mapel')->get();
        return view('mapel.trash', compact('mapels'));
    }

    /**
     * [RESTORE] Pulihkan data mapel yang ada di tempat sampah
     */
    public function restore($id)
    {
        $mapel = Mapel::onlyTrashed()->findOrFail($id);
        $mapel->restore();

        return redirect()->route('mapel.trash')
                         ->with('success', "Data mapel \"{$mapel->nama_mapel}\" berhasil dipulihkan!");
    }

    /**
     * [FORCE DELETE] Hapus permanen dari database
     */
    public function forceDelete($id)
    {
        $mapel = Mapel::onlyTrashed()->findOrFail($id);
        $nama = $mapel->nama_mapel;
        $mapel->forceDelete();

        return redirect()->route('mapel.trash')
                         ->with('success', "Data mapel \"$nama\" telah dihapus secara permanen dari database.");
    }
}
