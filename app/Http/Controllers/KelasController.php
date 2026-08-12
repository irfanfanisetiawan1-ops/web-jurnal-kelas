<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Helper privat untuk mengambil daftar guru terverifikasi dan peta wali kelas aktif
     */
    private function getVerifiedGurusAndAssignedWali()
    {
        $gurus = Guru::with(['user', 'kelasWali'])
            ->where(function($q) {
                $q->whereDoesntHave('user')
                  ->orWhereHas('user', function($u) {
                      $u->where('status_verifikasi', 'verified');
                  });
            })
            ->orderBy('nama_guru', 'asc')
            ->get();

        $assignedWali = Kelas::whereNotNull('wali_kelas')
            ->pluck('nama_kelas', 'wali_kelas')
            ->toArray();

        return [$gurus, $assignedWali];
    }

    /**
     * [READ] Tampilkan daftar kelas aktif (yang belum di-soft-delete)
     */
    public function index(Request $request)
    {
        $search     = $request->query('search');
        $id_jurusan = $request->query('id_jurusan');
        $id_ruangan = $request->query('id_ruangan');

        $query = Kelas::with(['waliKelas', 'jurusan', 'ruangan'])->withCount('siswas')->orderBy('nama_kelas', 'asc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_kelas', 'like', "%{$search}%")
                  ->orWhereHas('waliKelas', function($w) use ($search) {
                      $w->where('nama_guru', 'like', "%{$search}%");
                  })
                  ->orWhereHas('ruangan', function($r) use ($search) {
                      $r->where('nama_ruangan', 'like', "%{$search}%");
                  });
            });
        }

        if ($id_jurusan) {
            $query->where('id_jurusan', $id_jurusan);
        }

        if ($id_ruangan) {
            $query->where('id_ruangan', $id_ruangan);
        }

        $kelases      = $query->get();
        [$gurus, $assignedWali] = $this->getVerifiedGurusAndAssignedWali();
        $jurusans     = Jurusan::orderBy('nama_jurusan', 'asc')->get();
        $ruangans     = Ruangan::orderBy('nama_ruangan', 'asc')->get();
        $trashedCount = Kelas::onlyTrashed()->count();

        return view('kelas.index', compact('kelases', 'gurus', 'assignedWali', 'jurusans', 'ruangans', 'trashedCount', 'search', 'id_jurusan', 'id_ruangan'));
    }

    /**
     * [CREATE] Menampilkan form tambah kelas
     */
    public function create()
    {
        [$gurus, $assignedWali] = $this->getVerifiedGurusAndAssignedWali();
        $jurusans = Jurusan::orderBy('nama_jurusan', 'asc')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan', 'asc')->get();
        return view('kelas.create', compact('gurus', 'assignedWali', 'jurusans', 'ruangans'));
    }

    /**
     * [STORE] Memproses & menyimpan data kelas baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas'   => 'required|string|max:20|unique:kelas,nama_kelas',
            'id_jurusan'   => 'nullable|exists:jurusan,id_jurusan',
            'wali_kelas'   => 'nullable|string|exists:guru,nip',
            'id_ruangan'   => 'nullable|exists:ruangan,id_ruangan',
            'jumlah_siswa' => 'nullable|integer|min:0',
        ], [
            'nama_kelas.required' => 'Nama Kelas wajib diisi.',
            'nama_kelas.max'      => 'Nama Kelas maksimal 20 karakter.',
            'nama_kelas.unique'   => 'Nama Kelas sudah terdaftar di database.',
            'id_jurusan.exists'   => 'Jurusan yang dipilih tidak valid.',
            'wali_kelas.exists'   => 'Wali Kelas yang dipilih tidak valid.',
            'id_ruangan.exists'   => 'Ruangan yang dipilih tidak valid.',
            'jumlah_siswa.integer'=> 'Jumlah Siswa harus berupa angka bulat.',
            'jumlah_siswa.min'    => 'Jumlah Siswa tidak boleh kurang dari 0.',
        ]);

        // Validasi aturan: 1 Guru hanya untuk 1 Kelas & 1 Guru Terverifikasi
        if ($request->filled('wali_kelas')) {
            $guru = Guru::where('nip', $request->wali_kelas)->first();
            if (!$guru) {
                return back()->withInput()->withErrors(['wali_kelas' => 'Guru yang dipilih tidak ditemukan dalam sistem.']);
            }
            if ($guru->user && $guru->user->status_verifikasi !== 'verified') {
                return back()->withInput()->withErrors(['wali_kelas' => 'Guru yang dipilih belum terverifikasi oleh Admin TU.']);
            }

            $existingClass = Kelas::where('wali_kelas', $request->wali_kelas)->first();
            if ($existingClass) {
                return back()->withInput()->withErrors([
                    'wali_kelas' => "Guru '{$guru->nama_guru}' sudah menjadi Wali Kelas di kelas '{$existingClass->nama_kelas}'. Satu guru hanya dapat menjadi Wali Kelas untuk 1 kelas."
                ]);
            }
        }

        $kelas = Kelas::create([
            'nama_kelas'   => trim($request->nama_kelas),
            'id_jurusan'   => $request->id_jurusan ?: null,
            'wali_kelas'   => $request->wali_kelas ?: null,
            'id_ruangan'   => $request->id_ruangan ?: null,
            'jumlah_siswa' => $request->jumlah_siswa ?? 0,
        ]);

        // Update role User jika ditugaskan sebagai Wali Kelas
        if ($kelas->wali_kelas) {
            $user = User::where('nip', $kelas->wali_kelas)->first();
            if ($user && $user->role === 'guru') {
                $user->role = 'wali_kelas';
                $user->save();
            }
        }

        return redirect()->route('kelas.index')
                         ->with('success', 'Data kelas berhasil ditambahkan!');
    }

    /**
     * [SHOW] Menampilkan detail data 1 kelas beserta daftar siswanya
     */
    public function show($id)
    {
        $kelas = Kelas::with(['waliKelas', 'jurusan', 'ruangan', 'siswas'])->findOrFail($id);
        return view('kelas.show', compact('kelas'));
    }

    /**
     * [EDIT] Menampilkan form edit data kelas
     */
    public function edit($id)
    {
        $kelas    = Kelas::findOrFail($id);
        [$gurus, $assignedWali] = $this->getVerifiedGurusAndAssignedWali();
        $jurusans = Jurusan::orderBy('nama_jurusan', 'asc')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan', 'asc')->get();
        return view('kelas.edit', compact('kelas', 'gurus', 'assignedWali', 'jurusans', 'ruangans'));
    }

    /**
     * [UPDATE] Memproses perubahan data kelas di database
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $oldWaliNip = $kelas->wali_kelas;

        $request->validate([
            'nama_kelas'   => 'required|string|max:20|unique:kelas,nama_kelas,' . $kelas->id_kelas . ',id_kelas',
            'id_jurusan'   => 'nullable|exists:jurusan,id_jurusan',
            'wali_kelas'   => 'nullable|string|exists:guru,nip',
            'id_ruangan'   => 'nullable|exists:ruangan,id_ruangan',
            'jumlah_siswa' => 'nullable|integer|min:0',
        ], [
            'nama_kelas.required' => 'Nama Kelas wajib diisi.',
            'nama_kelas.max'      => 'Nama Kelas maksimal 20 karakter.',
            'nama_kelas.unique'   => 'Nama Kelas sudah digunakan oleh kelas lain.',
            'id_jurusan.exists'   => 'Jurusan yang dipilih tidak valid.',
            'wali_kelas.exists'   => 'Wali Kelas yang dipilih tidak valid.',
            'id_ruangan.exists'   => 'Ruangan yang dipilih tidak valid.',
            'jumlah_siswa.integer'=> 'Jumlah Siswa harus berupa angka bulat.',
            'jumlah_siswa.min'    => 'Jumlah Siswa tidak boleh kurang dari 0.',
        ]);

        // Validasi 1 Guru untuk 1 Kelas
        if ($request->filled('wali_kelas')) {
            $guru = Guru::where('nip', $request->wali_kelas)->first();
            if (!$guru) {
                return back()->withInput()->withErrors(['wali_kelas' => 'Guru yang dipilih tidak ditemukan dalam sistem.']);
            }
            if ($guru->user && $guru->user->status_verifikasi !== 'verified') {
                return back()->withInput()->withErrors(['wali_kelas' => 'Guru yang dipilih belum terverifikasi oleh Admin TU.']);
            }

            $existingClass = Kelas::where('wali_kelas', $request->wali_kelas)
                ->where('id_kelas', '!=', $id)
                ->first();
            if ($existingClass) {
                return back()->withInput()->withErrors([
                    'wali_kelas' => "Guru '{$guru->nama_guru}' sudah menjadi Wali Kelas di kelas '{$existingClass->nama_kelas}'. Satu guru hanya dapat menjadi Wali Kelas untuk 1 kelas."
                ]);
            }
        }

        $newWaliNip = $request->wali_kelas ?: null;

        $kelas->update([
            'nama_kelas'   => trim($request->nama_kelas),
            'id_jurusan'   => $request->id_jurusan ?: null,
            'wali_kelas'   => $newWaliNip,
            'id_ruangan'   => $request->id_ruangan ?: null,
            'jumlah_siswa' => $request->jumlah_siswa ?? 0,
        ]);

        // Sinkronisasi Role User (Guru Lama vs Guru Baru)
        if ($oldWaliNip && $oldWaliNip !== $newWaliNip) {
            $stillWali = Kelas::where('wali_kelas', $oldWaliNip)->exists();
            if (!$stillWali) {
                $userOld = User::where('nip', $oldWaliNip)->first();
                if ($userOld && $userOld->role === 'wali_kelas') {
                    $userOld->role = 'guru';
                    $userOld->save();
                }
            }
        }

        if ($newWaliNip) {
            $userNew = User::where('nip', $newWaliNip)->first();
            if ($userNew && $userNew->role === 'guru') {
                $userNew->role = 'wali_kelas';
                $userNew->save();
            }
        }

        return redirect()->route('kelas.index')
                         ->with('success', 'Data kelas berhasil diperbarui!');
    }

    /**
     * [SOFT DELETE] Tandai kelas sebagai dihapus (mengisi deleted_at)
     */
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $nama  = $kelas->nama_kelas;
        $waliNip = $kelas->wali_kelas;

        $kelas->delete();

        if ($waliNip) {
            $stillWali = Kelas::where('wali_kelas', $waliNip)->exists();
            if (!$stillWali) {
                $user = User::where('nip', $waliNip)->first();
                if ($user && $user->role === 'wali_kelas') {
                    $user->role = 'guru';
                    $user->save();
                }
            }
        }

        return redirect()->route('kelas.index')
                         ->with('success', "Data kelas \"$nama\" berhasil dipindahkan ke Tempat Sampah.");
    }

    /**
     * [TRASH] Menampilkan daftar kelas yang di-soft-delete (Recycle Bin)
     */
    public function trash()
    {
        $kelases = Kelas::onlyTrashed()->with('waliKelas')->orderBy('nama_kelas')->get();
        return view('kelas.trash', compact('kelases'));
    }

    /**
     * [RESTORE] Pulihkan data kelas yang ada di tempat sampah
     */
    public function restore($id)
    {
        $kelas = Kelas::onlyTrashed()->findOrFail($id);

        if ($kelas->wali_kelas) {
            $existingClass = Kelas::where('wali_kelas', $kelas->wali_kelas)->first();
            if ($existingClass) {
                return redirect()->route('kelas.trash')
                                 ->with('error', "Gagal memulihkan kelas: Wali Kelas pada kelas ini sudah ditugaskan di kelas '{$existingClass->nama_kelas}'. Edit atau kosongkan Wali Kelas terlebih dahulu.");
            }
        }

        $kelas->restore();

        if ($kelas->wali_kelas) {
            $user = User::where('nip', $kelas->wali_kelas)->first();
            if ($user && $user->role === 'guru') {
                $user->role = 'wali_kelas';
                $user->save();
            }
        }

        return redirect()->route('kelas.trash')
                         ->with('success', "Data kelas \"{$kelas->nama_kelas}\" berhasil dipulihkan!");
    }

    /**
     * [FORCE DELETE] Hapus permanen dari database
     */
    public function forceDelete($id)
    {
        $kelas = Kelas::onlyTrashed()->findOrFail($id);
        $nama  = $kelas->nama_kelas;
        $kelas->forceDelete();

        return redirect()->route('kelas.trash')
                         ->with('success', "Data kelas \"$nama\" telah dihapus secara permanen dari database.");
    }
}

