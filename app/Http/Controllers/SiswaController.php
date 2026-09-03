<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * [READ] Tampilkan daftar semua siswa (yang belum dihapus)
     */
    public function index(Request $request)
    {
        $search        = $request->query('search');
        $tingkat       = $request->query('tingkat');
        $id_jurusan    = $request->query('id_jurusan');
        $id_kelas      = $request->query('id_kelas');
        $jenis_kelamin = $request->query('jenis_kelamin');
        $sort          = $request->query('sort', 'nama_asc');

        $query = Siswa::with('kelas.jurusan')
                      ->where(function($q) {
                          $q->where('is_alumni', 0)->orWhereNull('is_alumni');
                      });

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhereHas('kelas', fn($k) => $k->where('nama_kelas', 'like', "%{$search}%"));
            });
        }

        if ($tingkat) {
            $query->whereHas('kelas', function($q) use ($tingkat) {
                $q->where('nama_kelas', 'like', "{$tingkat} %")
                  ->orWhere('nama_kelas', 'like', "{$tingkat}-%")
                  ->orWhere('nama_kelas', 'like', "{$tingkat}%");
            });
        }

        if ($id_jurusan) {
            $query->whereHas('kelas', function($q) use ($id_jurusan) {
                $q->where('id_jurusan', $id_jurusan);
            });
        }

        if ($id_kelas) {
            $query->where('id_kelas', $id_kelas);
        }

        if ($jenis_kelamin) {
            $query->where('jenis_kelamin', $jenis_kelamin);
        }

        if ($sort === 'nama_desc') {
            $query->orderBy('nama_siswa', 'desc');
        } elseif ($sort === 'nis_asc') {
            $query->orderBy('nis', 'asc');
        } elseif ($sort === 'nis_desc') {
            $query->orderBy('nis', 'desc');
        } else {
            $query->orderBy('nama_siswa', 'asc');
        }

        $siswas          = $query->get();
        $kelass          = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $jurusans        = \App\Models\Jurusan::orderBy('kode_jurusan')->get();
        $trashedCount    = Siswa::onlyTrashed()->where(function($q) { $q->where('is_alumni', 0)->orWhereNull('is_alumni'); })->count();
        $alumniCount     = Siswa::where('is_alumni', 1)->count();
        $totalAktifCount = Siswa::where(function($q) { $q->where('is_alumni', 0)->orWhereNull('is_alumni'); })->count();

        return view('siswa.index', compact(
            'siswas', 'kelass', 'jurusans', 'trashedCount', 'alumniCount', 'totalAktifCount',
            'search', 'tingkat', 'id_jurusan', 'id_kelas', 'jenis_kelamin', 'sort'
        ));
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
            'nis'            => 'required|numeric|digits_between:3,10|unique:siswa,nis',
            'nisn'           => 'required|numeric|digits:10|unique:siswa,nisn',
            'nama_siswa'     => 'required|string|max:100',
            'jenis_kelamin'  => 'required|in:L,P',
            'id_kelas'       => 'required|exists:kelas,id_kelas',
            'kota_lahir'     => 'nullable|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'alamat_lengkap' => 'nullable|string',
        ], [
            'nis.required'            => 'NIS wajib diisi.',
            'nis.numeric'             => 'NIS harus berupa angka.',
            'nis.digits_between'      => 'NIS harus berisi 3 hingga 10 digit angka.',
            'nis.unique'              => 'NIS sudah terdaftar di database.',
            'nisn.required'           => 'NISN wajib diisi.',
            'nisn.numeric'            => 'NISN harus berupa angka.',
            'nisn.digits'             => 'NISN harus berisi tepat 10 digit angka.',
            'nisn.unique'             => 'NISN sudah terdaftar di database.',
            'nama_siswa.required'     => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required'    => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'        => 'Pilihan jenis kelamin tidak valid.',
            'id_kelas.required'       => 'Kelas wajib dipilih.',
            'id_kelas.exists'         => 'Kelas yang dipilih tidak valid.',
            'tanggal_lahir.required'    => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'        => 'Tanggal lahir harus berformat tanggal yang valid.',
        ]);

        // Validasi Kapasitas / Estimasi Siswa per Kelas
        $kelas = Kelas::findOrFail($request->id_kelas);
        $currentCount = Siswa::where('id_kelas', $kelas->id_kelas)->count();
        if ($currentCount >= $kelas->jumlah_siswa) {
            return back()->withInput()->withErrors([
                'id_kelas' => 'Data siswa untuk kelas tersebut sudah penuh,jika mau menambah siswa lagi pada kelas tersebut,edit dulu Jumlah Siswa (Kapasitas / Estimasi) pada halaman kelas(di fitur edit untuk kelas tersebut) pada role TU.'
            ]);
        }

        Siswa::create([
            'nis'            => $request->nis,
            'nisn'           => $request->nisn,
            'nama_siswa'     => trim($request->nama_siswa),
            'jenis_kelamin'  => $request->jenis_kelamin,
            'id_kelas'       => $request->id_kelas,
            'kota_lahir'     => $request->filled('kota_lahir') ? trim($request->kota_lahir) : null,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat_lengkap' => $request->filled('alamat_lengkap') ? trim($request->alamat_lengkap) : null,
        ]);

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    /**
     * [STORE BATCH] Simpan banyak siswa sekaligus per kelas
     */
    /**
     * [STORE BATCH] Simpan banyak siswa sekaligus (Per Kelas / Multi-Kelas)
     */
    public function storeBatch(Request $request)
    {
        $request->validate([
            'id_kelas'                 => 'nullable|exists:kelas,id_kelas',
            'siswa'                    => 'required|array|min:1',
            'siswa.*.id_kelas'         => 'nullable|exists:kelas,id_kelas',
            'siswa.*.nis'              => 'required|numeric|digits_between:3,10',
            'siswa.*.nisn'             => 'required|numeric|digits:10',
            'siswa.*.nama_siswa'       => 'required|string|max:100',
            'siswa.*.jenis_kelamin'    => 'required|in:L,P',
            'siswa.*.kota_lahir'       => 'nullable|string|max:100',
            'siswa.*.tanggal_lahir'    => 'nullable|date',
            'siswa.*.alamat_lengkap'   => 'nullable|string',
        ], [
            'id_kelas.exists'                => 'Kelas target yang dipilih tidak valid.',
            'siswa.required'                 => 'Data baris siswa wajib diisi minimal 1 baris.',
            'siswa.min'                      => 'Data baris siswa wajib diisi minimal 1 baris.',
            'siswa.*.id_kelas.exists'        => 'Kelas target pada baris ke-:position tidak valid.',
            'siswa.*.nis.required'           => 'NIS pada baris ke-:position wajib diisi.',
            'siswa.*.nis.numeric'            => 'NIS pada baris ke-:position harus berupa angka.',
            'siswa.*.nis.digits_between'     => 'NIS pada baris ke-:position harus 3 hingga 10 digit angka.',
            'siswa.*.nisn.required'          => 'NISN pada baris ke-:position wajib diisi.',
            'siswa.*.nisn.numeric'           => 'NISN pada baris ke-:position harus berupa angka.',
            'siswa.*.nisn.digits'            => 'NISN pada baris ke-:position harus tepat 10 digit angka.',
            'siswa.*.nama_siswa.required'    => 'Nama Siswa pada baris ke-:position wajib diisi.',
            'siswa.*.jenis_kelamin.required' => 'Jenis Kelamin pada baris ke-:position wajib dipilih.',
            'siswa.*.jenis_kelamin.in'       => 'Jenis Kelamin pada baris ke-:position tidak valid.',
        ]);

        $siswaInput = array_values($request->siswa);
        $totalInputCount = count($siswaInput);

        // Pastikan setiap baris siswa memiliki id_kelas (dari baris atau dari id_kelas global)
        $globalKelasId = $request->id_kelas;
        $classGroupCounts = [];

        foreach ($siswaInput as $idx => &$item) {
            $rowNum = $idx + 1;
            $targetKelasId = !empty($item['id_kelas']) ? $item['id_kelas'] : $globalKelasId;

            if (!$targetKelasId) {
                return back()->withInput()->withErrors([
                    'id_kelas' => "Kelas target belum ditentukan untuk baris ke-{$rowNum}. Silakan pilih Kelas Target di bagian atas atau tentukan kelas pada baris tersebut."
                ]);
            }

            $item['resolved_id_kelas'] = $targetKelasId;
            $classGroupCounts[$targetKelasId] = ($classGroupCounts[$targetKelasId] ?? 0) + 1;
        }
        unset($item);

        // Validasi Kapasitas / Estimasi Siswa per Kelas untuk setiap kelas yang berdampak
        foreach ($classGroupCounts as $klsId => $addCount) {
            $kelas = Kelas::find($klsId);
            if (!$kelas) continue;

            $currentCount = Siswa::where('id_kelas', $klsId)->count();
            $availableQuota = $kelas->jumlah_siswa - $currentCount;

            if ($availableQuota < $addCount) {
                $msg = $availableQuota <= 0 
                    ? "Data siswa untuk kelas {$kelas->nama_kelas} sudah penuh (Kapasitas: {$kelas->jumlah_siswa}, Terisi: {$currentCount}). Silakan tingkatkan kapasitas kelas terlebih dahulu di halaman Kelas."
                    : "Kapasitas kelas {$kelas->nama_kelas} hanya menyisakan {$availableQuota} kuota siswa (Kapasitas: {$kelas->jumlah_siswa}, Terisi: {$currentCount}), sedangkan Anda mencoba menambahkan {$addCount} siswa sekaligus ke kelas tersebut. Silakan tingkatkan kapasitas kelas di halaman Kelas.";
                
                return back()->withInput()->withErrors(['id_kelas' => $msg]);
            }
        }

        // Pengecekan Duplikasi NIS dan NISN di dalam batch yang dikirimkan (Intra-batch duplicate check)
        $nisArray = [];
        $nisnArray = [];
        foreach ($siswaInput as $idx => $item) {
            $rowNum = $idx + 1;
            $nis = trim($item['nis']);
            $nisn = trim($item['nisn']);

            if (in_array($nis, $nisArray)) {
                return back()->withInput()->withErrors([
                    'siswa' => "Terdapat duplikasi NIS ({$nis}) pada form input massal (baris ke-{$rowNum}). Pastikan setiap siswa memiliki NIS yang berbeda."
                ]);
            }
            $nisArray[] = $nis;

            if (in_array($nisn, $nisnArray)) {
                return back()->withInput()->withErrors([
                    'siswa' => "Terdapat duplikasi NISN ({$nisn}) pada form input massal (baris ke-{$rowNum}). Pastikan setiap siswa memiliki NISN yang berbeda."
                ]);
            }
            $nisnArray[] = $nisn;
        }

        // Pengecekan Duplikasi NIS & NISN dengan database (Termasuk soft-deleted / active)
        $existingNis = Siswa::whereIn('nis', $nisArray)->pluck('nis')->toArray();
        if (!empty($existingNis)) {
            return back()->withInput()->withErrors([
                'siswa' => "NIS " . implode(', ', $existingNis) . " sudah terdaftar di database. Silakan periksa kembali."
            ]);
        }

        $existingNisn = Siswa::whereIn('nisn', $nisnArray)->pluck('nisn')->toArray();
        if (!empty($existingNisn)) {
            return back()->withInput()->withErrors([
                'siswa' => "NISN " . implode(', ', $existingNisn) . " sudah terdaftar di database. Silakan periksa kembali."
            ]);
        }

        // Simpan dalam 1 Transaksi Database
        DB::transaction(function () use ($siswaInput) {
            foreach ($siswaInput as $item) {
                Siswa::create([
                    'nis'            => trim($item['nis']),
                    'nisn'           => trim($item['nisn']),
                    'nama_siswa'     => trim($item['nama_siswa']),
                    'jenis_kelamin'  => $item['jenis_kelamin'],
                    'id_kelas'       => $item['resolved_id_kelas'],
                    'kota_lahir'     => !empty($item['kota_lahir']) && $item['kota_lahir'] !== '-' ? trim($item['kota_lahir']) : null,
                    'tanggal_lahir'  => !empty($item['tanggal_lahir']) ? $item['tanggal_lahir'] : '2008-01-01',
                    'alamat_lengkap' => !empty($item['alamat_lengkap']) && $item['alamat_lengkap'] !== '-' ? trim($item['alamat_lengkap']) : null,
                ]);
            }
        });

        return redirect()->route('siswa.index')
                         ->with('success', "Berhasil menambahkan {$totalInputCount} data siswa baru secara cepat dan banyak!");
    }

    /**
     * [DOWNLOAD TEMPLATE] Download Template File Excel/CSV untuk Import Siswa Baru
     */
    public function downloadTemplate()
    {
        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=Template_Tambah_Siswa_Baru.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['NIS', 'NISN', 'Nama Lengkap Siswa', 'Jenis Kelamin', 'Kota Lahir', 'Tanggal Lahir', 'Alamat Lengkap'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);

            fputcsv($file, ['2401000001', '0081234501', 'Ahmad Ridwan', 'L', 'Surabaya', '2008-05-15', 'Jl. Pemuda No. 12, Surabaya']);
            fputcsv($file, ['2401000002', '0081234502', 'Siti Nurhaliza', 'P', 'Sidoarjo', '2008-08-20', 'Jl. Pahlawan No. 45, Sidoarjo']);
            fputcsv($file, ['2401000003', '0081234503', 'Budi Santoso', 'L', 'Gresik', '2008-11-10', 'Jl. Veteran No. 78, Gresik']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
            'nis'            => 'required|numeric|digits_between:3,10|unique:siswa,nis,' . $siswa->id_siswa . ',id_siswa',
            'nisn'           => 'required|numeric|digits:10|unique:siswa,nisn,' . $siswa->id_siswa . ',id_siswa',
            'nama_siswa'     => 'required|string|max:100',
            'jenis_kelamin'  => 'required|in:L,P',
            'id_kelas'       => 'required|exists:kelas,id_kelas',
            'kota_lahir'     => 'nullable|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'alamat_lengkap' => 'nullable|string',
        ], [
            'nis.required'            => 'NIS wajib diisi.',
            'nis.numeric'             => 'NIS harus berupa angka.',
            'nis.digits_between'      => 'NIS harus berisi 3 hingga 10 digit angka.',
            'nis.unique'              => 'NIS sudah terdaftar di database.',
            'nisn.required'           => 'NISN wajib diisi.',
            'nisn.numeric'            => 'NISN harus berupa angka.',
            'nisn.digits'             => 'NISN harus berisi tepat 10 digit angka.',
            'nisn.unique'             => 'NISN sudah terdaftar di database.',
            'nama_siswa.required'     => 'Nama siswa wajib diisi.',
            'jenis_kelamin.required'    => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'        => 'Pilihan jenis kelamin tidak valid.',
            'id_kelas.required'       => 'Kelas wajib dipilih.',
            'id_kelas.exists'         => 'Kelas yang dipilih tidak valid.',
            'tanggal_lahir.required'    => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'        => 'Tanggal lahir harus berformat tanggal yang valid.',
        ]);

        // Cek kapasitas jika perpindahan kelas
        if ($siswa->id_kelas != $request->id_kelas) {
            $targetKelas = Kelas::findOrFail($request->id_kelas);
            $currentCount = Siswa::where('id_kelas', $targetKelas->id_kelas)->count();
            if ($currentCount >= $targetKelas->jumlah_siswa) {
                return back()->withInput()->withErrors([
                    'id_kelas' => 'Data siswa untuk kelas tersebut sudah penuh,jika mau menambah siswa lagi pada kelas tersebut,edit dulu Jumlah Siswa (Kapasitas / Estimasi) pada halaman kelas(di fitur edit untuk kelas tersebut) pada role TU.'
                ]);
            }
        }

        $siswa->update([
            'nis'            => $request->nis,
            'nisn'           => $request->nisn,
            'nama_siswa'     => trim($request->nama_siswa),
            'jenis_kelamin'  => $request->jenis_kelamin,
            'id_kelas'       => $request->id_kelas,
            'kota_lahir'     => $request->filled('kota_lahir') ? trim($request->kota_lahir) : null,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat_lengkap' => $request->filled('alamat_lengkap') ? trim($request->alamat_lengkap) : null,
        ]);

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        $nama = $siswa->nama_siswa;
        $id   = $siswa->id_siswa;

        $siswa->delete();

        // Soft delete akun user terkait (misal akun orang tua) jika ada
        User::where('id_siswa', $id)->delete();

        return redirect()->route('siswa.index')
                         ->with('success', "Siswa \"$nama\" berhasil dipindahkan ke tempat sampah.");
    }

    /**
     * [DESTROY BATCH] Hapus banyak siswa sekaligus (Soft Delete)
     */
    public function destroyBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:siswa,id_siswa',
        ], [
            'ids.required' => 'Silakan pilih minimal satu data siswa untuk dihapus.',
            'ids.min'      => 'Silakan pilih minimal satu data siswa untuk dihapus.',
            'ids.*.exists' => 'Data siswa yang dipilih tidak valid atau tidak ditemukan.',
        ]);

        $ids   = $request->ids;
        $count = Siswa::whereIn('id_siswa', $ids)->delete();
        User::whereIn('id_siswa', $ids)->delete();

        return redirect()->route('siswa.index')
                         ->with('success', "Berhasil memindahkan {$count} data siswa terpilih ke tempat sampah.");
    }

    public function trash()
    {
        $siswas      = Siswa::withoutGlobalScope('active_student')->onlyTrashed()->where(function($q) { $q->where('is_alumni', 0)->orWhereNull('is_alumni'); })->with('kelas')->orderBy('deleted_at', 'desc')->get();
        $alumniCount = Siswa::withoutGlobalScope('active_student')->where('is_alumni', 1)->count();
        return view('siswa.trash', compact('siswas', 'alumniCount'));
    }

    public function restore($id)
    {
        $siswa = Siswa::withoutGlobalScope('active_student')->onlyTrashed()->findOrFail($id);
        $siswa->restore();

        // Pulihkan akun user terkait jika ikut terhapus sementara
        User::onlyTrashed()->where('id_siswa', $id)->restore();

        return redirect()->route('siswa.trash')
                         ->with('success', "Siswa \"{$siswa->nama_siswa}\" berhasil dipulihkan!");
    }

    public function forceDelete($id)
    {
        $siswa = Siswa::withoutGlobalScope('active_student')->withTrashed()->findOrFail($id);
        $nama  = $siswa->nama_siswa;

        // Hapus permanen akun user terkait jika ada
        User::withTrashed()->where('id_siswa', $id)->forceDelete();

        $siswa->forceDelete();

        return redirect()->back()
                         ->with('success', "Data siswa \"$nama\" dihapus secara permanen.");
    }

    /**
     * [FORCE DELETE BATCH] Hapus permanen banyak siswa yang dipilih sekaligus dari Tempat Sampah
     */
    public function forceDeleteBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:siswa,id_siswa',
        ], [
            'ids.required' => 'Silakan pilih minimal satu data siswa untuk dihapus secara permanen.',
            'ids.min'      => 'Silakan pilih minimal satu data siswa untuk dihapus secara permanen.',
            'ids.*.exists' => 'Data siswa yang dipilih tidak valid atau tidak ditemukan.',
        ]);

        $ids = $request->ids;
        User::withTrashed()->whereIn('id_siswa', $ids)->forceDelete();
        $count = Siswa::withoutGlobalScope('active_student')->withTrashed()->whereIn('id_siswa', $ids)->forceDelete();

        return redirect()->route('siswa.trash')
                         ->with('success', "Berhasil menghapus {$count} data siswa terpilih secara permanen.");
    }

    /**
     * [MOVE TO ALUMNI BATCH] Pindahkan banyak siswa terpilih dari Tempat Sampah / Aktif ke Data Siswa Alumni
     */
    public function moveToAlumniBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:siswa,id_siswa',
        ], [
            'ids.required' => 'Silakan pilih minimal satu data siswa untuk dipindahkan ke Data Siswa Alumni.',
            'ids.min'      => 'Silakan pilih minimal satu data siswa untuk dipindahkan ke Data Siswa Alumni.',
            'ids.*.exists' => 'Data siswa yang dipilih tidak valid atau tidak ditemukan.',
        ]);

        $ids    = $request->ids;
        $siswas = Siswa::withoutGlobalScope('active_student')->withTrashed()->whereIn('id_siswa', $ids)->get();
        $count  = 0;

        foreach ($siswas as $s) {
            if ($s->trashed()) {
                $s->restore();
            }
            $s->is_alumni = 1;
            $s->save();
            $count++;
        }

        return redirect()->route('siswa.trash')
                         ->with('success', "Berhasil memindahkan {$count} data siswa terpilih ke Data Siswa Alumni!");
    }

    /**
     * [MOVE TO ALUMNI SINGLE] Pindahkan 1 data siswa ke Data Siswa Alumni
     */
    public function moveToAlumni($id)
    {
        $siswa = Siswa::withoutGlobalScope('active_student')->withTrashed()->findOrFail($id);
        if ($siswa->trashed()) {
            $siswa->restore();
        }
        $siswa->is_alumni = 1;
        $siswa->save();

        return redirect()->back()
                         ->with('success', "Data siswa \"{$siswa->nama_siswa}\" berhasil dipindahkan ke Data Siswa Alumni!");
    }

    /**
     * [ALUMNI READ] Tampilkan daftar data siswa alumni
     */
    public function alumni(Request $request)
    {
        $search        = $request->query('search');
        $tingkat       = $request->query('tingkat');
        $id_jurusan    = $request->query('id_jurusan');
        $id_kelas      = $request->query('id_kelas');
        $jenis_kelamin = $request->query('jenis_kelamin');
        $sort          = $request->query('sort', 'nama_asc');

        $query = Siswa::withoutGlobalScope('active_student')
                      ->with('kelas.jurusan')
                      ->where('is_alumni', 1);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhereHas('kelas', fn($k) => $k->where('nama_kelas', 'like', "%{$search}%"));
            });
        }

        if ($tingkat) {
            $query->whereHas('kelas', function($q) use ($tingkat) {
                $q->where('nama_kelas', 'like', "{$tingkat} %")
                  ->orWhere('nama_kelas', 'like', "{$tingkat}-%")
                  ->orWhere('nama_kelas', 'like', "{$tingkat}%");
            });
        }

        if ($id_jurusan) {
            $query->whereHas('kelas', function($q) use ($id_jurusan) {
                $q->where('id_jurusan', $id_jurusan);
            });
        }

        if ($id_kelas) {
            $query->where('id_kelas', $id_kelas);
        }

        if ($jenis_kelamin) {
            $query->where('jenis_kelamin', $jenis_kelamin);
        }

        if ($sort === 'nama_desc') {
            $query->orderBy('nama_siswa', 'desc');
        } elseif ($sort === 'nis_asc') {
            $query->orderBy('nis', 'asc');
        } elseif ($sort === 'nis_desc') {
            $query->orderBy('nis', 'desc');
        } else {
            $query->orderBy('nama_siswa', 'asc');
        }

        $siswas       = $query->get();
        $kelass       = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $jurusans     = \App\Models\Jurusan::orderBy('kode_jurusan')->get();
        $trashedCount = Siswa::withoutGlobalScope('active_student')->onlyTrashed()->where(function($q) { $q->where('is_alumni', 0)->orWhereNull('is_alumni'); })->count();
        $activeCount  = Siswa::where(function($q) { $q->where('is_alumni', 0)->orWhereNull('is_alumni'); })->count();

        return view('siswa.alumni', compact(
            'siswas', 'kelass', 'jurusans', 'trashedCount', 'activeCount',
            'search', 'tingkat', 'id_jurusan', 'id_kelas', 'jenis_kelamin', 'sort'
        ));
    }

    /**
     * [ALUMNI RESTORE] Kembalikan siswa alumni menjadi siswa aktif
     */
    public function restoreFromAlumni($id)
    {
        $siswa = Siswa::withoutGlobalScope('active_student')->where('id_siswa', $id)->firstOrFail();
        $siswa->is_alumni = 0;
        $siswa->save();

        return redirect()->route('siswa.alumni')
                         ->with('success', "Siswa \"{$siswa->nama_siswa}\" berhasil dikembalikan menjadi Siswa Aktif!");
    }
}
