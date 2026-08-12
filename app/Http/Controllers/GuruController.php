<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /**
     * [READ] Tampilkan daftar guru aktif (yang belum di-soft-delete)
     */
    public function index(Request $request)
    {
        $search   = $request->query('search');
        $id_mapel = $request->query('id_mapel');

        $query = Guru::with(['mapel', 'user'])->orderBy('nama_guru', 'asc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if ($id_mapel) {
            $query->where('id_mapel', $id_mapel);
        }

        $gurus        = $query->get();
        $mapelList    = Mapel::orderBy('nama_mapel')->get();
        $trashedCount = Guru::onlyTrashed()->count();

        return view('guru.index', compact('gurus', 'mapelList', 'trashedCount', 'search', 'id_mapel'));
    }

    /**
     * [STORE] Memproses & menyimpan data guru baru ke database
     */
    /**
     * [STORE] Memproses & menyimpan data guru baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip'            => 'required|numeric|digits:18|unique:guru,nip',
            'nama_guru'      => 'required|string|max:100',
            'jenis_kelamin'   => 'required|in:L,P',
            'no_hp'          => 'nullable|numeric|digits_between:10,15',
            'id_mapel'       => 'nullable|exists:mapel,id_mapel',
            'role'           => 'nullable|in:guru,tu,admin,piket,wali_kelas',
            'password'       => 'nullable|string|min:6',
        ], [
            'nip.required'           => 'NIP wajib diisi.',
            'nip.numeric'            => 'NIP harus berupa angka.',
            'nip.digits'             => 'NIP harus berisi tepat 18 digit angka.',
            'nip.unique'             => 'NIP sudah terdaftar di database guru.',
            'nama_guru.required'     => 'Nama Guru wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Pilihan jenis kelamin tidak valid.',
            'no_hp.numeric'          => 'Nomor HP harus berupa angka.',
            'no_hp.digits_between'   => 'Nomor HP harus berisi antara 10 hingga 15 digit angka.',
            'id_mapel.exists'        => 'Mata pelajaran yang dipilih tidak valid.',
            'password.min'           => 'Password minimal 6 karakter.',
        ]);

        $guru = Guru::create([
            'nip'           => $request->nip,
            'nama_guru'     => trim($request->nama_guru),
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp'         => $request->no_hp,
            'id_mapel'      => $request->id_mapel,
        ]);

        // Buat akun User jika password diisi
        if ($request->filled('password')) {
            $baseName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $request->nama_guru)[0]));
            $role     = $request->role ?? 'guru';
            $username = $role . '.' . $baseName . rand(10, 99);

            User::create([
                'name'              => trim($request->nama_guru),
                'nip'               => $request->nip,
                'username'          => $username,
                'email'             => $request->nip . '@sekolah.sch.id',
                'password'          => Hash::make($request->password),
                'role'              => $role,
                'status_verifikasi' => 'verified',
                'id_guru'           => $guru->id_guru,
                'jenis_kelamin'     => $request->jenis_kelamin,
                'no_hp'             => $request->no_hp,
            ]);
        }

        return redirect()->route('guru.index')
                         ->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function show(Guru $guru)
    {
        $guru->load(['mapel', 'user', 'kelasWali']);
        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        $mapelList = Mapel::orderBy('nama_mapel')->get();
        return view('guru.edit', compact('guru', 'mapelList'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip'            => 'required|numeric|digits:18|unique:guru,nip,' . $guru->id_guru . ',id_guru',
            'nama_guru'      => 'required|string|max:100',
            'jenis_kelamin'   => 'required|in:L,P',
            'no_hp'          => 'nullable|numeric|digits_between:10,15',
            'id_mapel'       => 'nullable|exists:mapel,id_mapel',
        ], [
            'nip.required'           => 'NIP wajib diisi.',
            'nip.numeric'            => 'NIP harus berupa angka.',
            'nip.digits'             => 'NIP harus berisi tepat 18 digit angka.',
            'nip.unique'             => 'NIP sudah terdaftar di database guru.',
            'nama_guru.required'     => 'Nama Pegawai/Guru wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Pilihan jenis kelamin tidak valid.',
            'no_hp.numeric'          => 'Nomor HP harus berupa angka.',
            'no_hp.digits_between'   => 'Nomor HP harus berisi antara 10 hingga 15 digit angka.',
            'id_mapel.exists'        => 'Mata pelajaran yang dipilih tidak valid.',
        ]);

        $oldNip = $guru->nip;

        $guru->update([
            'nip'           => $request->nip,
            'nama_guru'     => trim($request->nama_guru),
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp'         => $request->no_hp,
            'id_mapel'      => $request->id_mapel,
        ]);

        // Update akun user jika terhubung via id_guru atau NIP lama
        $user = User::where('id_guru', $guru->id_guru)->orWhere('nip', $oldNip)->first();
        if ($user) {
            $user->update([
                'name'          => trim($request->nama_guru),
                'nip'           => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp'         => $request->no_hp,
                'id_guru'       => $guru->id_guru,
            ]);
        }

        return redirect()->route('guru.index')
                         ->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy(Guru $guru)
    {
        $nama = $guru->nama_guru;
        $guru->delete();

        return redirect()->route('guru.index')
                         ->with('success', "Data guru \"$nama\" berhasil dipindahkan ke Tempat Sampah.");
    }

    public function trash()
    {
        $gurus = Guru::onlyTrashed()->orderBy('nama_guru')->get();
        return view('guru.trash', compact('gurus'));
    }

    public function restore($id)
    {
        $guru = Guru::onlyTrashed()->findOrFail($id);
        $guru->restore();

        return redirect()->route('guru.trash')
                         ->with('success', "Data guru \"{$guru->nama_guru}\" berhasil dipulihkan!");
    }

    public function forceDelete($id)
    {
        $guru = Guru::onlyTrashed()->findOrFail($id);
        $nama = $guru->nama_guru;
        $guru->forceDelete();

        return redirect()->route('guru.trash')
                         ->with('success', "Data guru \"$nama\" telah dihapus secara permanen dari database.");
    }
}
