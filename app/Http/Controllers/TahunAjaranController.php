<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Models\Setting;
use App\Models\Jadwal;
use App\Models\JurnalMengajar;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TahunAjaranController extends Controller
{
    /**
     * [READ] Menampilkan daftar tahun ajaran & semester
     */
    public function index(Request $request)
    {
        $tab      = $request->query('tab', 'aktif'); // 'aktif' atau 'trash'
        $search   = $request->query('search');
        $semester = $request->query('semester');
        $status   = $request->query('status');

        // Statistik KPI Header Cards
        $activeTa     = TahunAjaran::getActive();
        $totalData    = TahunAjaran::count();
        $totalAktif   = TahunAjaran::where('is_aktif', true)->count();
        $totalArsip   = TahunAjaran::where('is_aktif', false)->count();
        $totalSampah  = TahunAjaran::onlyTrashed()->count();

        // Inisialisasi Query berdasarkan Tab
        if ($tab === 'trash') {
            $query = TahunAjaran::onlyTrashed();
        } else {
            $query = TahunAjaran::query();
        }

        // Filter Pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tahun_ajaran', 'like', "%{$search}%")
                  ->orWhere('semester', 'like', "%{$search}%")
                  ->orWhere('periode_label', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        // Filter Semester
        if ($semester && in_array($semester, ['Ganjil', 'Genap'])) {
            $query->where('semester', $semester);
        }

        // Filter Status
        if ($status !== null && $status !== '') {
            if ($status === 'aktif') {
                $query->where('is_aktif', true);
            } elseif ($status === 'tidak_aktif') {
                $query->where('is_aktif', false);
            }
        }

        // Urutan Data: Aktif di paling atas, kemudian tahun ajaran terbaru
        if ($tab === 'trash') {
            $tahunAjaranList = $query->orderBy('deleted_at', 'desc')->paginate(10)->withQueryString();
        } else {
            $tahunAjaranList = $query->orderBy('is_aktif', 'desc')
                                     ->orderBy('tahun_ajaran', 'desc')
                                     ->orderBy('semester', 'desc')
                                     ->paginate(10)
                                     ->withQueryString();
        }

        return view('admin.tahun_ajaran.index', compact(
            'tab',
            'search',
            'semester',
            'status',
            'activeTa',
            'totalData',
            'totalAktif',
            'totalArsip',
            'totalSampah',
            'tahunAjaranList'
        ));
    }

    /**
     * [STORE] Tambah Tahun Ajaran & Semester baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d{4}\/\d{4}$/',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = TahunAjaran::whereNull('deleted_at')
                        ->where('tahun_ajaran', $value)
                        ->where('semester', $request->semester)
                        ->exists();

                    if ($exists) {
                        $fail("Periode Tahun Ajaran '{$value}' Semester '{$request->semester}' sudah terdaftar dalam sistem.");
                    }
                }
            ],
            'semester'        => 'required|in:Ganjil,Genap',
            'periode_label'   => 'nullable|string|max:100',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_aktif'        => 'nullable|boolean',
            'buka_jurnal'     => 'nullable|boolean',
            'keterangan'      => 'nullable|string|max:500',
        ], [
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'tahun_ajaran.regex'    => 'Format tahun ajaran harus YYYY/YYYY (contoh: 2026/2027).',
            'semester.required'     => 'Semester wajib dipilih.',
            'semester.in'           => 'Pilihan semester harus Ganjil atau Genap.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        $isAktif    = $request->boolean('is_aktif');
        $bukaJurnal = $request->has('buka_jurnal') ? $request->boolean('buka_jurnal') : true;

        // Auto-generate periode label jika kosong
        $periodeLabel = $request->periode_label;
        if (empty($periodeLabel)) {
            if ($request->semester === 'Ganjil') {
                $years = explode('/', $request->tahun_ajaran);
                $y1 = $years[0] ?? date('Y');
                $periodeLabel = "Juli - Desember {$y1}";
            } else {
                $years = explode('/', $request->tahun_ajaran);
                $y2 = $years[1] ?? (date('Y') + 1);
                $periodeLabel = "Januari - Juni {$y2}";
            }
        }

        $tahunAjaran = TahunAjaran::create([
            'tahun_ajaran'    => $request->tahun_ajaran,
            'semester'        => $request->semester,
            'periode_label'   => $periodeLabel,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_aktif'        => false, // di-set lewat activate() jika dicentang
            'buka_jurnal'     => $bukaJurnal,
            'keterangan'      => $request->keterangan,
            'created_by'      => auth()->id(),
        ]);

        if ($isAktif) {
            $tahunAjaran->activate();
        }

        return redirect()->route('admin.tahun-ajaran.index')
                         ->with('success', "Tahun Ajaran '{$tahunAjaran->nama_lengkap}' berhasil ditambahkan!");
    }

    /**
     * [DETAIL JSON / API] Mengambil data detail untuk Modal
     */
    public function show($id)
    {
        $ta = TahunAjaran::withTrashed()->findOrFail($id);

        $totalJadwal = Jadwal::count();
        $totalJurnal = JurnalMengajar::count();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'id'                 => $ta->id,
                'tahun_ajaran'       => $ta->tahun_ajaran,
                'semester'           => $ta->semester,
                'semester_formatted' => $ta->semester_formatted,
                'nama_lengkap'       => $ta->nama_lengkap,
                'periode_label'      => $ta->periode_label ?? '-',
                'tanggal_mulai'      => $ta->tanggal_mulai ? $ta->tanggal_mulai->format('d M Y') : '-',
                'tanggal_selesai'    => $ta->tanggal_selesai ? $ta->tanggal_selesai->format('d M Y') : '-',
                'tanggal_mulai_raw'  => $ta->tanggal_mulai ? $ta->tanggal_mulai->format('Y-m-d') : '',
                'tanggal_selesai_raw'=> $ta->tanggal_selesai ? $ta->tanggal_selesai->format('Y-m-d') : '',
                'durasi_hari'        => $ta->durasi_hari,
                'is_aktif'           => $ta->is_aktif,
                'buka_jurnal'        => $ta->buka_jurnal,
                'keterangan'         => $ta->keterangan ?? '-',
                'created_at'         => $ta->created_at ? $ta->created_at->format('d M Y H:i') : '-',
                'is_trashed'         => $ta->trashed(),
                'total_jadwal'       => $totalJadwal,
                'total_jurnal'       => $totalJurnal,
            ]
        ]);
    }

    /**
     * [UPDATE] Memperbarui data tahun ajaran
     */
    public function update(Request $request, $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        $request->validate([
            'tahun_ajaran' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d{4}\/\d{4}$/',
                function ($attribute, $value, $fail) use ($request, $id) {
                    $exists = TahunAjaran::whereNull('deleted_at')
                        ->where('id', '!=', $id)
                        ->where('tahun_ajaran', $value)
                        ->where('semester', $request->semester)
                        ->exists();

                    if ($exists) {
                        $fail("Periode Tahun Ajaran '{$value}' Semester '{$request->semester}' sudah digunakan oleh data lain.");
                    }
                }
            ],
            'semester'        => 'required|in:Ganjil,Genap',
            'periode_label'   => 'nullable|string|max:100',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_aktif'        => 'nullable|boolean',
            'buka_jurnal'     => 'nullable|boolean',
            'keterangan'      => 'nullable|string|max:500',
        ], [
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'tahun_ajaran.regex'    => 'Format tahun ajaran harus YYYY/YYYY (contoh: 2026/2027).',
            'semester.required'     => 'Semester wajib dipilih.',
            'semester.in'           => 'Pilihan semester harus Ganjil atau Genap.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        $bukaJurnal = $request->has('buka_jurnal') ? $request->boolean('buka_jurnal') : false;

        $tahunAjaran->update([
            'tahun_ajaran'    => $request->tahun_ajaran,
            'semester'        => $request->semester,
            'periode_label'   => $request->periode_label,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'buka_jurnal'     => $bukaJurnal,
            'keterangan'      => $request->keterangan,
        ]);

        if ($request->boolean('is_aktif')) {
            $tahunAjaran->activate();
        }

        return redirect()->route('admin.tahun-ajaran.index')
                         ->with('success', "Data Tahun Ajaran '{$tahunAjaran->nama_lengkap}' berhasil diperbarui!");
    }

    /**
     * [ACTIVATE] Menetapkan tahun ajaran sebagai periode aktif berjalan di sistem
     */
    public function activate($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        $ta->activate();

        return redirect()->route('admin.tahun-ajaran.index')
                         ->with('success', "Tahun Ajaran '{$ta->nama_lengkap}' kini AKTIF sebagai periode operasional sistem SMKN 1 Boyolangu!");
    }

    /**
     * [TOGGLE AKSES JURNAL] Mengunci atau membuka akses pengisian jurnal guru
     */
    public function toggleAksesJurnal($id)
    {
        $ta = TahunAjaran::findOrFail($id);
        $ta->buka_jurnal = !$ta->buka_jurnal;
        $ta->save();

        $statusText = $ta->buka_jurnal ? 'dibuka kembali (Bisa Input)' : 'dikunci otomatis (Arsip)';

        return redirect()->route('admin.tahun-ajaran.index')
                         ->with('success', "Akses pengisian jurnal guru untuk '{$ta->nama_lengkap}' berhasil {$statusText}.");
    }

    /**
     * [SOFT DELETE] Memindahkan data tahun ajaran ke Kotak Sampah
     */
    public function destroy($id)
    {
        $ta = TahunAjaran::findOrFail($id);

        // Guard: Tahun ajaran yang sedang aktif TIDAK BOLEH dihapus ke sampah
        if ($ta->is_aktif) {
            return redirect()->route('admin.tahun-ajaran.index')
                             ->with('error', "Gagal! Tahun Ajaran '{$ta->nama_lengkap}' sedang berstatus AKTIF. Aktifkan periode lain terlebih dahulu sebelum memindahkan ke Kotak Sampah.");
        }

        $nama = $ta->nama_lengkap;
        $ta->delete();

        return redirect()->route('admin.tahun-ajaran.index')
                         ->with('success', "Tahun Ajaran '{$nama}' berhasil dipindahkan ke Kotak Sampah.");
    }

    /**
     * [DESTROY BATCH] Hapus massal beberapa tahun ajaran terpilih ke sampah
     */
    public function destroyBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:tahun_ajaran,id',
        ], [
            'ids.required' => 'Pilih minimal satu data tahun ajaran untuk dihapus.',
        ]);

        $ids = $request->ids;

        // Ambil data terpilih yang bukan aktif
        $count = 0;
        $activeExcluded = false;

        $items = TahunAjaran::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->is_aktif) {
                $activeExcluded = true;
                continue;
            }
            $item->delete();
            $count++;
        }

        $message = "Berhasil memindahkan {$count} data tahun ajaran ke Kotak Sampah.";
        if ($activeExcluded) {
            $message .= " (Catatan: Periode yang sedang aktif dilewati dan tidak dihapus).";
        }

        return redirect()->route('admin.tahun-ajaran.index')->with('success', $message);
    }

    /**
     * [TRASH] Menampilkan view Kotak Sampah secara langsung
     */
    public function trash()
    {
        return redirect()->route('admin.tahun-ajaran.index', ['tab' => 'trash']);
    }

    /**
     * [RESTORE] Memulihkan 1 data tahun ajaran dari Kotak Sampah
     */
    public function restore($id)
    {
        $ta = TahunAjaran::onlyTrashed()->findOrFail($id);
        $ta->restore();

        return redirect()->route('admin.tahun-ajaran.index', ['tab' => 'trash'])
                         ->with('success', "Tahun Ajaran '{$ta->nama_lengkap}' berhasil dipulihkan dari Kotak Sampah!");
    }

    /**
     * [RESTORE BATCH] Pulihkan massal data dari Kotak Sampah
     */
    public function restoreBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:tahun_ajaran,id',
        ], [
            'ids.required' => 'Pilih minimal satu data di kotak sampah untuk dipulihkan.',
        ]);

        $count = TahunAjaran::onlyTrashed()->whereIn('id', $request->ids)->restore();

        return redirect()->route('admin.tahun-ajaran.index', ['tab' => 'trash'])
                         ->with('success', "Berhasil memulihkan {$count} data tahun ajaran dari Kotak Sampah!");
    }

    /**
     * [FORCE DELETE] Hapus permanen 1 data tahun ajaran dari database
     */
    public function forceDelete($id)
    {
        $ta = TahunAjaran::onlyTrashed()->findOrFail($id);
        $nama = $ta->nama_lengkap;
        $ta->forceDelete();

        return redirect()->route('admin.tahun-ajaran.index', ['tab' => 'trash'])
                         ->with('success', "Tahun Ajaran '{$nama}' telah dihapus secara permanen dari database.");
    }

    /**
     * [FORCE DELETE BATCH] Hapus permanen massal data dari Kotak Sampah
     */
    public function forceDeleteBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:tahun_ajaran,id',
        ], [
            'ids.required' => 'Pilih minimal satu data di kotak sampah untuk dihapus permanen.',
        ]);

        $count = TahunAjaran::onlyTrashed()->whereIn('id', $request->ids)->forceDelete();

        return redirect()->route('admin.tahun-ajaran.index', ['tab' => 'trash'])
                         ->with('success', "Berhasil menghapus permanen {$count} data tahun ajaran dari database.");
    }

    /**
     * [EMPTY TRASH] Mengosongkan seluruh isi Kotak Sampah
     */
    public function emptyTrash()
    {
        $count = TahunAjaran::onlyTrashed()->count();
        TahunAjaran::onlyTrashed()->forceDelete();

        return redirect()->route('admin.tahun-ajaran.index', ['tab' => 'trash'])
                         ->with('success', "Kotak Sampah berhasil dikosongkan ({$count} data dihapus permanen).");
    }

    /**
     * [EXPORT CSV] Ekspor Rekapitulasi Data Tahun Ajaran
     */
    public function export(Request $request)
    {
        $data = TahunAjaran::withTrashed()
            ->orderBy('is_aktif', 'desc')
            ->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        $filename = "Rekap_Tahun_Ajaran_SMKN1_Boyolangu_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"{$filename}\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        return new StreamedResponse(function () use ($data) {
            $handle = fopen('php://output', 'w');
            // Menambahkan UTF-8 BOM agar terbaca rapi dan tidak acak di Microsoft Excel
            fputs($handle, "\xEF\xBB\xBF");

            // Header Baris Pertama
            fputcsv($handle, [
                'NO',
                'TAHUN AJARAN',
                'SEMESTER',
                'PERIODE LABEL',
                'TANGGAL MULAI',
                'TANGGAL SELESAI',
                'STATUS OPERASIONAL',
                'AKSES JURNAL GURU',
                'STATUS DATA',
                'KETERANGAN',
                'DIBUAT PADA'
            ], ';');

            $no = 1;
            foreach ($data as $row) {
                fputcsv($handle, [
                    $no++,
                    $row->tahun_ajaran,
                    $row->semester,
                    $row->periode_label ?? '-',
                    $row->tanggal_mulai ? $row->tanggal_mulai->format('d/m/Y') : '-',
                    $row->tanggal_selesai ? $row->tanggal_selesai->format('d/m/Y') : '-',
                    $row->is_aktif ? 'Aktif' : 'Tidak Aktif',
                    $row->buka_jurnal ? 'Terbuka (Bisa Input)' : 'Terkunci (Arsip)',
                    $row->trashed() ? 'Di Kotak Sampah' : 'Aktif / Arsip',
                    $row->keterangan ?? '-',
                    $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-'
                ], ';');
            }

            fclose($handle);
        }, 200, $headers);
    }
}