<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * [READ] Tampilkan daftar semua siswa (yang belum dihapus)
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query  = Siswa::with('kelas')->orderBy('nama_siswa', 'asc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $siswas       = $query->get();
        $kelass       = Kelas::orderBy('nama_kelas')->get();
        $trashedCount = Siswa::onlyTrashed()->count();

        return view('siswa.index', compact('siswas', 'kelass', 'trashedCount', 'search'));
    }

    /**
     * [CREATE] Tampilkan form tambah siswa
     */
    public function create()
    {
        $kelass = Kelas::orderBy('nama_kelas')->get();
        return view('siswa.create', compact('kelass'));
    }

    /**
     * [STORE] Simpan siswa baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis'            => 'required|numeric|digits:10|unique:siswa,nis',
            'nisn'           => 'required|numeric|digits:10|unique:siswa,nisn',
            'nama_siswa'     => 'required|string|max:100',
            'jenis_kelamin'  => 'required|in:L,P',
            'id_kelas'       => 'required|exists:kelas,id_kelas',
            'kota_lahir'     => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'alamat_lengkap' => 'nullable|string',
        ], [
            'nis.required'         => 'NIS wajib diisi.',
            'nis.numeric'          => 'NIS harus berupa angka.',
            'nis.digits'           => 'NIS harus berisi tepat 10 digit angka.',
            'nis.unique'           => 'NIS sudah terdaftar di database.',
            'nisn.required'        => 'NISN wajib diisi.',
            'nisn.numeric'         => 'NISN harus berupa angka.',
            'nisn.digits'          => 'NISN harus berisi tepat 10 digit angka.',
            'nisn.unique'          => 'NISN sudah terdaftar di database.',
            'nama_siswa.required'  => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'     => 'Pilihan jenis kelamin tidak valid.',
            'id_kelas.required'    => 'Kelas wajib dipilih.',
            'id_kelas.exists'      => 'Kelas yang dipilih tidak valid.',
        ]);

        Siswa::create([
            'nis'            => $request->nis,
            'nisn'           => $request->nisn,
            'nama_siswa'     => trim($request->nama_siswa),
            'jenis_kelamin'  => $request->jenis_kelamin,
            'id_kelas'       => $request->id_kelas,
            'kota_lahir'     => $request->kota_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat_lengkap' => $request->alamat_lengkap,
        ]);

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load('kelas');
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $kelass = Kelas::orderBy('nama_kelas')->get();
        return view('siswa.edit', compact('siswa', 'kelass'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis'            => 'required|numeric|digits:10|unique:siswa,nis,' . $siswa->id_siswa . ',id_siswa',
            'nisn'           => 'required|numeric|digits:10|unique:siswa,nisn,' . $siswa->id_siswa . ',id_siswa',
            'nama_siswa'     => 'required|string|max:100',
            'jenis_kelamin'  => 'required|in:L,P',
            'id_kelas'       => 'required|exists:kelas,id_kelas',
            'kota_lahir'     => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'alamat_lengkap' => 'nullable|string',
        ], [
            'nis.required'         => 'NIS wajib diisi.',
            'nis.numeric'          => 'NIS harus berupa angka.',
            'nis.digits'           => 'NIS harus berisi tepat 10 digit angka.',
            'nis.unique'           => 'NIS sudah terdaftar di database.',
            'nisn.required'        => 'NISN wajib diisi.',
            'nisn.numeric'         => 'NISN harus berupa angka.',
            'nisn.digits'          => 'NISN harus berisi tepat 10 digit angka.',
            'nisn.unique'          => 'NISN sudah terdaftar di database.',
            'nama_siswa.required'  => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'     => 'Pilihan jenis kelamin tidak valid.',
            'id_kelas.required'    => 'Kelas wajib dipilih.',
            'id_kelas.exists'      => 'Kelas yang dipilih tidak valid.',
        ]);

        $siswa->update([
            'nis'            => $request->nis,
            'nisn'           => $request->nisn,
            'nama_siswa'     => trim($request->nama_siswa),
            'jenis_kelamin'  => $request->jenis_kelamin,
            'id_kelas'       => $request->id_kelas,
            'kota_lahir'     => $request->kota_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat_lengkap' => $request->alamat_lengkap,
        ]);

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        $nama = $siswa->nama_siswa;
        $siswa->delete();

        return redirect()->route('siswa.index')
                         ->with('success', "Siswa \"$nama\" berhasil dipindahkan ke tempat sampah.");
    }

    public function trash()
    {
        $siswas = Siswa::onlyTrashed()->with('kelas')->orderBy('nama_siswa')->get();
        return view('siswa.trash', compact('siswas'));
    }

    public function restore($id)
    {
        $siswa = Siswa::onlyTrashed()->findOrFail($id);
        $siswa->restore();

        return redirect()->route('siswa.trash')
                         ->with('success', "Siswa \"{$siswa->nama_siswa}\" berhasil dipulihkan!");
    }

    public function forceDelete($id)
    {
        $siswa = Siswa::onlyTrashed()->findOrFail($id);
        $nama  = $siswa->nama_siswa;
        $siswa->forceDelete();

        return redirect()->route('siswa.trash')
                         ->with('success', "Data siswa \"$nama\" dihapus secara permanen.");
    }
}
