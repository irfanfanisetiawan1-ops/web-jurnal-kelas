<?php

namespace App\Http\Controllers;

use App\Models\LaporanTu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminLaporanController extends Controller
{
    /**
     * Kategori Master Pengaduan
     */
    protected function getKategoriOptions(): array
    {
        return [
            'Permintaan Pembuatan Akun Baru',
            'Lupa Kata Sandi / Reset Password',
            'Akun Terkunci / Gagal Login',
            'Perubahan Data Profil',
            'Kendala Jadwal & Presensi',
            'Kendala Teknis / Error Sistem',
        ];
    }

    /**
     * 9 Role Pengguna Master
     */
    protected function getRoleOptions(): array
    {
        return [
            'guru'            => 'Guru Mengajar',
            'wali_kelas'      => 'Wali Kelas',
            'guru_piket'      => 'Guru Piket',
            'waka_kesiswaan'  => 'Waka Kesiswaan',
            'waka_kurikulum'  => 'Waka Kurikulum',
            'waka_sdm'        => 'Waka SDM',
            'kepala_sekolah'  => 'Kepala Sekolah',
            'satpam'          => 'Satpam Gerbang',
            'orang_tua'       => 'Orang Tua',
        ];
    }

    /**
     * Tampilkan daftar seluruh laporan aktif pengguna untuk Admin TU.
     */
    public function index(Request $request)
    {
        $query = LaporanTu::with('responder')->latest();

        // Filter status
        if ($request->filled('status') && in_array($request->status, ['pending', 'diproses', 'selesai', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_kendala', $request->kategori);
        }

        // Filter role pelapor
        if ($request->filled('role')) {
            $query->where('role_pelapor', $request->role);
        }

        // Pencarian keyword (Nama, Tiket, No WA, Nomor Identitas, Judul, Deskripsi)
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('ticket_code', 'like', "%{$keyword}%")
                  ->orWhere('nama_pelapor', 'like', "%{$keyword}%")
                  ->orWhere('no_wa', 'like', "%{$keyword}%")
                  ->orWhere('nomor_identitas', 'like', "%{$keyword}%")
                  ->orWhere('judul_laporan', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi_kendala', 'like', "%{$keyword}%");
            });
        }

        $laporans = $query->paginate(15)->withQueryString();

        // Statistik Keseluruhan
        $stats = [
            'total'    => LaporanTu::count(),
            'pending'  => LaporanTu::where('status', 'pending')->count(),
            'diproses' => LaporanTu::where('status', 'diproses')->count(),
            'selesai'  => LaporanTu::where('status', 'selesai')->count(),
            'ditolak'  => LaporanTu::where('status', 'ditolak')->count(),
        ];

        $trashCount = LaporanTu::onlyTrashed()->count();
        $kategoriOptions = $this->getKategoriOptions();
        $roleOptions = $this->getRoleOptions();

        return view('admin.laporan.index', compact('laporans', 'stats', 'trashCount', 'kategoriOptions', 'roleOptions'));
    }

    /**
     * Tampilkan daftar laporan yang ada di Kotak Sampah (Soft Deleted).
     */
    public function trash(Request $request)
    {
        $query = LaporanTu::onlyTrashed()->with('responder')->latest('deleted_at');

        // Filter status
        if ($request->filled('status') && in_array($request->status, ['pending', 'diproses', 'selesai', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_kendala', $request->kategori);
        }

        // Filter role pelapor
        if ($request->filled('role')) {
            $query->where('role_pelapor', $request->role);
        }

        // Pencarian keyword
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('ticket_code', 'like', "%{$keyword}%")
                  ->orWhere('nama_pelapor', 'like', "%{$keyword}%")
                  ->orWhere('no_wa', 'like', "%{$keyword}%")
                  ->orWhere('nomor_identitas', 'like', "%{$keyword}%")
                  ->orWhere('judul_laporan', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi_kendala', 'like', "%{$keyword}%");
            });
        }

        $trashedLaporans = $query->paginate(15)->withQueryString();
        $trashCount = LaporanTu::onlyTrashed()->count();
        $activeCount = LaporanTu::count();

        $kategoriOptions = $this->getKategoriOptions();
        $roleOptions = $this->getRoleOptions();

        return view('admin.laporan.trash', compact('trashedLaporans', 'trashCount', 'activeCount', 'kategoriOptions', 'roleOptions'));
    }

    /**
     * Ambil detail laporan via JSON untuk Modal Detail (Mendukung data aktif & di sampah).
     */
    public function show($id)
    {
        $laporan = LaporanTu::withTrashed()->with('responder')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => [
                'id'                => $laporan->id,
                'ticket_code'       => $laporan->ticket_code,
                'nama_pelapor'      => $laporan->nama_pelapor,
                'role_pelapor'      => $laporan->role_pelapor,
                'role_label'        => $laporan->role_label,
                'nomor_identitas'   => $laporan->nomor_identitas ?? '-',
                'no_wa'             => $laporan->no_wa,
                'email'             => $laporan->email ?? '-',
                'kategori_kendala'  => $laporan->kategori_kendala,
                'judul_laporan'     => $laporan->judul_laporan,
                'deskripsi_kendala' => $laporan->deskripsi_kendala,
                'lampiran_url'      => $laporan->lampiran_url,
                'lampiran_name'     => $laporan->lampiran ? basename($laporan->lampiran) : null,
                'is_image'          => $laporan->is_image_lampiran,
                'status'            => $laporan->status,
                'status_badge'      => $laporan->status_badge,
                'tanggapan_admin'   => $laporan->tanggapan_admin ?? '',
                'responder_name'    => $laporan->responder->name ?? 'Admin TU',
                'responded_at'      => $laporan->responded_at ? $laporan->responded_at->format('d/m/Y H:i') : null,
                'created_at'        => $laporan->created_at->format('d/m/Y H:i'),
                'deleted_at'        => $laporan->deleted_at ? $laporan->deleted_at->format('d/m/Y H:i') : null,
                'is_trashed'        => $laporan->trashed(),
                'wa_link'           => $laporan->wa_link,
            ]
        ]);
    }

    /**
     * Update status dan tanggapan admin TU terhadap laporan.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'          => 'required|in:pending,diproses,selesai,ditolak',
            'tanggapan_admin' => 'nullable|string|max:2000',
        ], [
            'status.required' => 'Pilih status tindak lanjut.',
            'status.in'       => 'Status tidak valid.',
        ]);

        $laporan = LaporanTu::findOrFail($id);
        $laporan->update([
            'status'          => $request->status,
            'tanggapan_admin' => $request->tanggapan_admin,
            'responded_by'    => Auth::id(),
            'responded_at'    => now(),
        ]);

        return redirect()->back()->with('success', "Status laporan [{$laporan->ticket_code}] berhasil diperbarui menjadi {$laporan->status}.");
    }

    /**
     * Hapus laporan sementara (Soft Delete).
     */
    public function destroy($id)
    {
        $laporan = LaporanTu::findOrFail($id);
        $ticket = $laporan->ticket_code;
        $laporan->delete();

        return redirect()->back()->with('success', "Laporan dengan tiket [{$ticket}] berhasil dipindahkan ke kotak sampah.");
    }

    /**
     * Bulk Soft Delete laporan.
     */
    public function destroyBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:laporan_tu,id',
        ]);

        $count = count($request->ids);
        LaporanTu::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', "{$count} laporan terpilih berhasil dipindahkan ke kotak sampah.");
    }

    /**
     * Pulihkan laporan dari kotak sampah (Restore single).
     */
    public function restore($id)
    {
        $laporan = LaporanTu::onlyTrashed()->findOrFail($id);
        $ticket = $laporan->ticket_code;
        $laporan->restore();

        return redirect()->back()->with('success', "Laporan [{$ticket}] berhasil dipulihkan dari kotak sampah.");
    }

    /**
     * Bulk Restore laporan dari kotak sampah.
     */
    public function restoreBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:laporan_tu,id',
        ]);

        $count = count($request->ids);
        LaporanTu::onlyTrashed()->whereIn('id', $request->ids)->restore();

        return redirect()->back()->with('success', "{$count} laporan terpilih berhasil dipulihkan.");
    }

    /**
     * Hapus permanen laporan (Force Delete single).
     */
    public function forceDelete($id)
    {
        $laporan = LaporanTu::onlyTrashed()->findOrFail($id);
        $ticket = $laporan->ticket_code;

        // Hapus file fisik lampiran jika ada
        $this->deletePhysicalLampiran($laporan->lampiran);

        $laporan->forceDelete();

        return redirect()->back()->with('success', "Laporan [{$ticket}] berhasil dihapus secara permanen.");
    }

    /**
     * Bulk Force Delete laporan dari kotak sampah.
     */
    public function forceDeleteBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:laporan_tu,id',
        ]);

        $laporans = LaporanTu::onlyTrashed()->whereIn('id', $request->ids)->get();
        $count = $laporans->count();

        foreach ($laporans as $laporan) {
            $this->deletePhysicalLampiran($laporan->lampiran);
            $laporan->forceDelete();
        }

        return redirect()->back()->with('success', "{$count} laporan terpilih berhasil dihapus secara permanen.");
    }

    /**
     * Kosongkan seluruh kotak sampah laporan.
     */
    public function emptyTrash()
    {
        $laporans = LaporanTu::onlyTrashed()->get();
        $count = $laporans->count();

        if ($count === 0) {
            return redirect()->back()->with('error', 'Kotak sampah laporan sudah kosong.');
        }

        foreach ($laporans as $laporan) {
            $this->deletePhysicalLampiran($laporan->lampiran);
            $laporan->forceDelete();
        }

        return redirect()->back()->with('success', "Seluruh ({$count}) data di kotak sampah laporan berhasil dihapus secara permanen.");
    }

    /**
     * Helper untuk menghapus file fisik lampiran.
     */
    protected function deletePhysicalLampiran(?string $filename): void
    {
        if (!$filename) {
            return;
        }

        $path = public_path('uploads/laporan_tu/' . $filename);
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    /**
     * Export daftar laporan ke format CSV.
     */
    public function exportCsv(Request $request)
    {
        $query = LaporanTu::with('responder')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_kendala', $request->kategori);
        }
        if ($request->filled('role')) {
            $query->where('role_pelapor', $request->role);
        }

        $records = $query->get();
        $filename = 'laporan_pengguna_tu_' . date('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($records) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No. Tiket', 'Tanggal', 'Nama Pelapor', 'Role', 'No Identitas', 'No WhatsApp', 'Email', 'Kategori Kendala', 'Judul Laporan', 'Status', 'Tanggapan Admin', 'Ditanggapi Oleh', 'Waktu Ditanggapi']);

            foreach ($records as $row) {
                fputcsv($handle, [
                    $row->ticket_code,
                    $row->created_at->format('Y-m-d H:i:s'),
                    $row->nama_pelapor,
                    $row->role_label,
                    $row->nomor_identitas ?? '-',
                    $row->no_wa,
                    $row->email ?? '-',
                    $row->kategori_kendala,
                    $row->judul_laporan,
                    strtoupper($row->status),
                    $row->tanggapan_admin ?? '-',
                    $row->responder->name ?? '-',
                    $row->responded_at ? $row->responded_at->format('Y-m-d H:i:s') : '-',
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }

    /**
     * Endpoint real-time count untuk polling notifikasi Admin TU.
     */
    public function realtimeCount()
    {
        $pendingCount = LaporanTu::where('status', 'pending')->count();
        $latest = LaporanTu::latest()->first();

        return response()->json([
            'pending_count' => $pendingCount,
            'latest_id'     => $latest->id ?? 0,
            'latest_ticket' => $latest->ticket_code ?? '',
            'latest_title'  => $latest->judul_laporan ?? '',
            'latest_time'   => $latest ? $latest->created_at->diffForHumans() : '',
        ]);
    }
}
