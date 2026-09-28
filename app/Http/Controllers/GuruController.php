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
        $search        = $request->query('search');
        $id_mapel      = $request->query('id_mapel');
        $jenis_kelamin = $request->query('jenis_kelamin');
        $role          = $request->query('role');
        $status        = $request->query('status');

        $query = Guru::with(['mapel', 'user'])->orderBy('nama_guru', 'asc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhereHas('mapel', fn($m) => $m->where('nama_mapel', 'like', "%{$search}%"))
                  ->orWhereHas('user', fn($u) => $u->where('role', 'like', "%{$search}%"));
            });
        }

        if ($id_mapel) {
            $query->where('id_mapel', $id_mapel);
        }

        if ($jenis_kelamin) {
            $query->where('jenis_kelamin', $jenis_kelamin);
        }

        if ($role) {
            $query->whereHas('user', function($u) use ($role) {
                $u->where('role', $role);
            });
        }

        if ($status === 'active') {
            $query->where('is_active', 1);
        } elseif ($status === 'inactive') {
            $query->where('is_active', 0);
        }

        $gurus        = $query->get();
        $mapelList    = Mapel::orderBy('nama_mapel')->get();
        $trashedCount = Guru::onlyTrashed()->count();

        return view('guru.index', compact('gurus', 'mapelList', 'trashedCount', 'search', 'id_mapel', 'jenis_kelamin', 'role', 'status'));
    }

    /**
     * [CREATE] Menampilkan form tambah guru
     */
    public function create()
    {
        $mapelList = Mapel::orderBy('nama_mapel')->get();
        return view('guru.create', compact('mapelList'));
    }

    /**
     * [STORE] Memproses & menyimpan data guru baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip'            => 'required|numeric|digits:18|unique:guru,nip',
            'nama_guru'      => 'required|string|max:100',
            'jenis_kelamin'   => 'required|in:L,P',
            'no_hp'          => 'required|numeric|digits_between:10,15',
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
            'no_hp.required'         => 'Nomor HP / WA wajib diisi.',
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
            'no_hp'          => 'required|numeric|digits_between:10,15',
            'id_mapel'       => 'nullable|exists:mapel,id_mapel',
        ], [
            'nip.required'           => 'NIP wajib diisi.',
            'nip.numeric'            => 'NIP harus berupa angka.',
            'nip.digits'             => 'NIP harus berisi tepat 18 digit angka.',
            'nip.unique'             => 'NIP sudah terdaftar di database guru.',
            'nama_guru.required'     => 'Nama Pegawai/Guru wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Pilihan jenis kelamin tidak valid.',
            'no_hp.required'         => 'Nomor HP / WA wajib diisi.',
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

    /**
     * [DESTROY BATCH] Hapus banyak guru sekaligus (Soft Delete)
     */
    public function destroyBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:guru,id_guru',
        ], [
            'ids.required' => 'Silakan pilih minimal satu data guru untuk dihapus.',
            'ids.min'      => 'Silakan pilih minimal satu data guru untuk dihapus.',
            'ids.*.exists' => 'Data guru yang dipilih tidak valid atau tidak ditemukan.',
        ]);

        $count = Guru::whereIn('id_guru', $request->ids)->delete();

        return redirect()->route('guru.index')
                         ->with('success', "Berhasil memindahkan {$count} data guru terpilih ke Tempat Sampah.");
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

    /**
     * [STORE BATCH] Memproses & menyimpan data guru secara massal (banyak sekaligus)
     */
    public function storeBatch(Request $request)
    {
        $rawRows = $request->input('guru', []);

        // Filter baris yang valid (minimal memiliki NIP & nama_guru)
        $validRows = [];
        foreach ($rawRows as $idx => $row) {
            $nip  = trim($row['nip'] ?? '');
            $nama = trim($row['nama_guru'] ?? '');
            if (!empty($nip) || !empty($nama)) {
                $validRows[] = $row;
            }
        }

        if (count($validRows) === 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['guru' => 'Minimal 1 baris data guru harus diisi lengkap.']);
        }

        $rules = [];
        $messages = [];
        $nipSeen = [];

        foreach ($validRows as $index => $row) {
            $rowNum = $index + 1;
            $nip = trim($row['nip'] ?? '');

            $rules["guru.{$index}.nip"] = 'required|numeric|digits:18|unique:guru,nip';
            $rules["guru.{$index}.nama_guru"] = 'required|string|max:100';
            $rules["guru.{$index}.jenis_kelamin"] = 'required|in:L,P';
            $rules["guru.{$index}.no_hp"] = 'required|numeric|digits_between:10,15';
            $rules["guru.{$index}.id_mapel"] = 'nullable|exists:mapel,id_mapel';

            $messages["guru.{$index}.nip.required"] = "NIP pada baris #{$rowNum} wajib diisi.";
            $messages["guru.{$index}.nip.numeric"] = "NIP pada baris #{$rowNum} harus berupa angka.";
            $messages["guru.{$index}.nip.digits"] = "NIP pada baris #{$rowNum} harus tepat 18 digit.";
            $messages["guru.{$index}.nip.unique"] = "NIP '{$nip}' pada baris #{$rowNum} sudah terdaftar di database.";
            $messages["guru.{$index}.nama_guru.required"] = "Nama Guru pada baris #{$rowNum} wajib diisi.";
            $messages["guru.{$index}.jenis_kelamin.required"] = "Jenis kelamin pada baris #{$rowNum} wajib dipilih.";
            $messages["guru.{$index}.no_hp.required"] = "Nomor HP pada baris #{$rowNum} wajib diisi.";
            $messages["guru.{$index}.no_hp.numeric"] = "Nomor HP pada baris #{$rowNum} harus berupa angka.";
            $messages["guru.{$index}.no_hp.digits_between"] = "Nomor HP pada baris #{$rowNum} harus 10-15 digit.";

            if (!empty($nip)) {
                if (in_array($nip, $nipSeen)) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(["guru.{$index}.nip" => "NIP '{$nip}' pada baris #{$rowNum} ganda / duplikat dengan baris lain di form ini."]);
                }
                $nipSeen[] = $nip;
            }
        }

        $request->validate($rules, $messages);

        $savedCount = 0;
        \Illuminate\Support\Facades\DB::transaction(function () use ($validRows, &$savedCount) {
            foreach ($validRows as $row) {
                $nip  = trim($row['nip']);
                $nama = trim($row['nama_guru']);
                $jk   = $row['jenis_kelamin'];
                $nohp = trim($row['no_hp']);
                $mapel = !empty($row['id_mapel']) ? $row['id_mapel'] : null;

                Guru::create([
                    'nip'           => $nip,
                    'nama_guru'     => $nama,
                    'jenis_kelamin' => $jk,
                    'no_hp'         => $nohp,
                    'id_mapel'      => $mapel,
                ]);
                $savedCount++;
            }
        });

        return redirect()->route('guru.index')
            ->with('success', "Berhasil menambahkan {$savedCount} data guru sekaligus ke database!");
    }

    /**
     * Toggle status aktif / nonaktif data guru secara real-time.
     * Aturan sinkronisasi:
     * - Jika data guru dinonaktifkan, akun user milik guru tersebut otomatis dinonaktifkan (is_active = 0).
     * - Jika data guru diaktifkan, akun user milik guru tersebut otomatis diaktifkan (is_active = 1).
     */
    public function toggleActive(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        if ($request->has('is_active')) {
            $guru->is_active = $request->boolean('is_active');
        } else {
            $guru->is_active = !$guru->is_active;
        }

        $guru->save();

        // Sinkronisasi otomatis ke Akun Pengguna (User)
        $user = User::where('id_guru', $guru->id_guru)->orWhere('nip', $guru->nip)->first();
        if ($user) {
            $user->is_active = (bool) $guru->is_active;
            $user->save();
        }

        $statusText = $guru->is_active ? 'diaktifkan (ON)' : 'dinonaktifkan (OFF)';
        $syncNote   = $user ? ' dan akun penggunanya' : '';
        $message    = "Data Guru '{$guru->nama_guru}'{$syncNote} berhasil {$statusText}.";

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'is_active'    => (bool) $guru->is_active,
                'user_synced'  => (bool) ($user !== null),
                'status_label' => $guru->is_active ? 'Aktif' : 'Nonaktif',
                'guru_name'    => $guru->nama_guru,
                'message'      => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
