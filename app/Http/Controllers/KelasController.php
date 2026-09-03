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

        $assignedWali = [];
        $kelasesWithWali = Kelas::whereNotNull('wali_kelas')->get();
        foreach ($kelasesWithWali as $kls) {
            $assignedWali[$kls->wali_kelas] = $kls->nama_kelas;
            if ($kls->waliKelas && $kls->waliKelas->nama_guru) {
                $assignedWali[trim($kls->waliKelas->nama_guru)] = $kls->nama_kelas;
            }
        }

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
                  })
                  ->orWhereHas('jurusan', function($j) use ($search) {
                      $j->where('nama_jurusan', 'like', "%{$search}%")
                        ->orWhere('kode_jurusan', 'like', "%{$search}%");
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
     * Helper privat untuk memproses id_jurusan, termasuk pengisian custom/manual
     */
    private function resolveJurusanId(Request $request)
    {
        $idJurusan = $request->id_jurusan;
        $namaCustom = trim($request->nama_jurusan_custom ?? '');

        if ($idJurusan === 'custom' || (!empty($namaCustom) && ($idJurusan === 'custom' || empty($idJurusan)))) {
            if (empty($namaCustom)) {
                return null;
            }

            // Cek apakah nama jurusan sudah ada di database (case-insensitive)
            $existing = Jurusan::where('nama_jurusan', 'like', $namaCustom)->first();
            if ($existing) {
                return $existing->id_jurusan;
            }

            // Generate kode_jurusan otomatis dari inisial atau huruf awal
            $words = array_filter(explode(' ', $namaCustom));
            if (count($words) >= 2) {
                $kode = '';
                foreach ($words as $w) {
                    $kode .= strtoupper(substr($w, 0, 1));
                }
            } else {
                $kode = strtoupper(substr($namaCustom, 0, 4));
            }

            $baseKode = !empty($kode) ? $kode : 'JUR';
            $kodeCandidate = $baseKode;
            $counter = 1;
            while (Jurusan::where('kode_jurusan', $kodeCandidate)->exists()) {
                $kodeCandidate = $baseKode . $counter;
                $counter++;
            }

            $newJurusan = Jurusan::create([
                'kode_jurusan' => $kodeCandidate,
                'nama_jurusan' => $namaCustom,
            ]);

            return $newJurusan->id_jurusan;
        }

        return $idJurusan ? (int)$idJurusan : null;
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
        $rules = [
            'nama_kelas'   => 'required|string|max:20|unique:kelas,nama_kelas',
            'id_jurusan'   => 'required',
            'jumlah_siswa' => 'nullable|integer|min:0',
        ];

        $messages = [
            'nama_kelas.required' => 'Nama Kelas wajib diisi.',
            'nama_kelas.max'      => 'Nama Kelas maksimal 20 karakter.',
            'nama_kelas.unique'   => 'Nama Kelas sudah terdaftar di database.',
            'id_jurusan.required' => 'Jurusan wajib dipilih atau diisi.',
            'jumlah_siswa.integer'=> 'Jumlah Siswa harus berupa angka bulat.',
            'jumlah_siswa.min'    => 'Jumlah Siswa tidak boleh kurang dari 0.',
        ];

        if ($request->id_jurusan === 'custom') {
            $rules['nama_jurusan_custom'] = 'required|string|max:100';
            $messages['nama_jurusan_custom.required'] = 'Nama Jurusan Baru (Custom) wajib diisi.';
        }

        $request->validate($rules, $messages);

        $jurusanId = $this->resolveJurusanId($request);

        if (!$jurusanId) {
            return back()->withInput()->withErrors(['id_jurusan' => 'Jurusan wajib dipilih atau diisi dengan benar.']);
        }

        Kelas::create([
            'nama_kelas'   => trim($request->nama_kelas),
            'id_jurusan'   => $jurusanId,
            'wali_kelas'   => null,
            'id_ruangan'   => null,
            'jumlah_siswa' => $request->jumlah_siswa ?? 0,
        ]);

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

        $rules = [
            'nama_kelas'   => 'required|string|max:20|unique:kelas,nama_kelas,' . $kelas->id_kelas . ',id_kelas',
            'id_jurusan'   => 'required',
            'wali_kelas'   => 'nullable|string|exists:guru,nip',
            'id_ruangan'   => 'nullable|exists:ruangan,id_ruangan',
            'jumlah_siswa' => 'nullable|integer|min:0',
        ];

        $messages = [
            'nama_kelas.required' => 'Nama Kelas wajib diisi.',
            'nama_kelas.max'      => 'Nama Kelas maksimal 20 karakter.',
            'nama_kelas.unique'   => 'Nama Kelas sudah digunakan oleh kelas lain.',
            'id_jurusan.required' => 'Jurusan wajib dipilih atau diisi.',
            'wali_kelas.exists'   => 'Wali Kelas yang dipilih tidak valid.',
            'id_ruangan.exists'   => 'Ruangan yang dipilih tidak valid.',
            'jumlah_siswa.integer'=> 'Jumlah Siswa harus berupa angka bulat.',
            'jumlah_siswa.min'    => 'Jumlah Siswa tidak boleh kurang dari 0.',
        ];

        if ($request->id_jurusan === 'custom') {
            $rules['nama_jurusan_custom'] = 'required|string|max:100';
            $messages['nama_jurusan_custom.required'] = 'Nama Jurusan Baru (Custom) wajib diisi.';
        }

        $request->validate($rules, $messages);

        $jurusanId = $this->resolveJurusanId($request);

        if (!$jurusanId) {
            return back()->withInput()->withErrors(['id_jurusan' => 'Jurusan wajib dipilih atau diisi dengan benar.']);
        }

        // Validasi 1 Guru untuk 1 Kelas
        if ($request->filled('wali_kelas')) {
            $guru = Guru::where('nip', $request->wali_kelas)->first();
            if (!$guru) {
                return back()->withInput()->withErrors(['wali_kelas' => 'Guru yang dipilih tidak ditemukan dalam sistem.']);
            }
            if ($guru->user && $guru->user->status_verifikasi !== 'verified') {
                return back()->withInput()->withErrors(['wali_kelas' => 'Guru yang dipilih belum terverifikasi oleh Admin TU.']);
            }

            $allNipsWithSameName = Guru::where('nama_guru', 'like', trim($guru->nama_guru))->pluck('nip')->toArray();
            if (!in_array($request->wali_kelas, $allNipsWithSameName)) {
                $allNipsWithSameName[] = $request->wali_kelas;
            }

            $existingClass = Kelas::whereIn('wali_kelas', $allNipsWithSameName)
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
            'id_jurusan'   => $jurusanId,
            'wali_kelas'   => $newWaliNip,
            'id_ruangan'   => $request->id_ruangan ?: null,
            'jumlah_siswa' => $request->jumlah_siswa ?? 0,
        ]);

        // Sinkronisasi Role User (Guru Lama vs Guru Baru)
        User::syncWaliKelasRoles();

        if ($request->header('referer') && str_contains($request->header('referer'), 'admin/wali-kelas-list')) {
            return redirect()->route('admin.wali-kelas-list')
                             ->with('success', "Data Wali Kelas pada kelas '{$kelas->nama_kelas}' berhasil diperbarui!");
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

        User::syncWaliKelasRoles();

        return redirect()->route('kelas.index')
                         ->with('success', "Data kelas \"$nama\" berhasil dipindahkan ke Tempat Sampah.");
    }

    /**
     * [DESTROY BATCH] Hapus banyak kelas sekaligus (Soft Delete)
     */
    public function destroyBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:kelas,id_kelas',
        ], [
            'ids.required' => 'Silakan pilih minimal satu data kelas untuk dihapus.',
            'ids.min'      => 'Silakan pilih minimal satu data kelas untuk dihapus.',
            'ids.*.exists' => 'Data kelas yang dipilih tidak valid atau tidak ditemukan.',
        ]);

        $kelases = Kelas::whereIn('id_kelas', $request->ids)->get();
        $count   = 0;

        foreach ($kelases as $kelas) {
            $kelas->delete();
            $count++;
        }

        User::syncWaliKelasRoles();

        return redirect()->route('kelas.index')
                         ->with('success', "Berhasil memindahkan {$count} data kelas terpilih ke Tempat Sampah.");
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

        User::syncWaliKelasRoles();

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

