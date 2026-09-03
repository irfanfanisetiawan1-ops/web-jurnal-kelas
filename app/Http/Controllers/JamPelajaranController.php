<?php

namespace App\Http\Controllers;

use App\Models\JamPelajaran;
use Illuminate\Http\Request;

class JamPelajaranController extends Controller
{
    /**
     * [READ] Menampilkan daftar master jam pelajaran
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query  = JamPelajaran::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('jam_ke', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhere('jam_mulai', 'like', "%{$search}%")
                  ->orWhere('jam_selesai', 'like', "%{$search}%");
            });
        }

        $jamList      = $query->orderBy('id_jam', 'asc')->get();
        $trashedCount = JamPelajaran::onlyTrashed()->count();

        return view('jam_pelajaran.index', compact('jamList', 'search', 'trashedCount'));
    }

    /**
     * [CREATE] Menampilkan form tambah jam pelajaran baru
     */
    public function create()
    {
        return view('jam_pelajaran.create');
    }

    /**
     * [STORE] Memproses & menyimpan data jam pelajaran baru ke database
     */
    public function store(Request $request)
    {
        // Resolusi input jam_ke (jika memilih opsi custom)
        $jamKe = $request->jam_ke === 'custom' ? trim($request->jam_ke_custom ?? '') : trim($request->jam_ke ?? '');
        $request->merge(['jam_ke_resolved' => $jamKe]);

        $request->validate([
            'jam_ke_resolved' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    $exists = JamPelajaran::whereNull('deleted_at')
                        ->whereRaw('LOWER(jam_ke) = ?', [mb_strtolower($value)])
                        ->exists();
                    if ($exists) {
                        $fail("Label Jam '{$value}' sudah terdaftar pada Daftar Sesi Jam Pelajaran. Silakan gunakan label lain.");
                    }
                }
            ],
            'jam_mulai'         => 'nullable|string',
            'jam_selesai'       => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->jam_mulai && $value && $value <= $request->jam_mulai) {
                        $fail('Waktu selesai Senin-Kamis harus lebih akhir daripada waktu mulai.');
                    }
                }
            ],
            'jam_mulai_jumat'   => 'nullable|string',
            'jam_selesai_jumat' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->jam_mulai_jumat && $value && $value <= $request->jam_mulai_jumat) {
                        $fail('Waktu selesai Hari Jumat harus lebih akhir daripada waktu mulai.');
                    }
                }
            ],
            'keterangan'        => 'nullable|string|max:255',
        ], [
            'jam_ke_resolved.required' => 'Label Jam wajib dipilih atau diisi.',
            'jam_ke_resolved.max'      => 'Label Jam maksimal 50 karakter.',
        ]);

        if (empty($request->jam_mulai) && empty($request->jam_mulai_jumat)) {
            return back()->withInput()->withErrors([
                'jam_mulai' => 'Minimal tentukan rentang waktu untuk Senin-Kamis atau Hari Jumat.'
            ]);
        }

        JamPelajaran::create([
            'jam_ke'            => $jamKe,
            'jam_mulai'         => $request->jam_mulai ? trim($request->jam_mulai) : null,
            'jam_selesai'       => $request->jam_selesai ? trim($request->jam_selesai) : null,
            'jam_mulai_jumat'   => $request->jam_mulai_jumat ? trim($request->jam_mulai_jumat) : null,
            'jam_selesai_jumat' => $request->jam_selesai_jumat ? trim($request->jam_selesai_jumat) : null,
            'keterangan'        => $request->keterangan ? trim($request->keterangan) : null,
        ]);

        return redirect()->route('jam-pelajaran.index')
                         ->with('success', "Master Jam Pelajaran '{$jamKe}' berhasil ditambahkan!");
    }

    /**
     * [SHOW] Menampilkan detail data 1 sesi jam pelajaran beserta daftar jadwalnya
     */
    public function show($id)
    {
        $jamPelajaran = JamPelajaran::findOrFail($id);
        $jadwals = \App\Models\Jadwal::with(['kelas', 'mapel', 'guru', 'ruangan', 'jamMulai', 'jamSelesai'])
            ->where('id_jam_mulai', '<=', $id)
            ->where('id_jam_selesai', '>=', $id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('id_jam_mulai')
            ->get();

        return view('jam_pelajaran.show', compact('jamPelajaran', 'jadwals'));
    }

    /**
     * [EDIT] Menampilkan form edit data jam pelajaran
     */
    public function edit($id)
    {
        $jamPelajaran = JamPelajaran::findOrFail($id);

        return view('jam_pelajaran.edit', compact('jamPelajaran'));
    }

    /**
     * [UPDATE] Memproses perubahan data jam pelajaran di database
     */
    public function update(Request $request, $id)
    {
        $jam = JamPelajaran::findOrFail($id);

        // Resolusi input jam_ke (jika memilih opsi custom)
        $jamKe = $request->jam_ke === 'custom' ? trim($request->jam_ke_custom ?? '') : trim($request->jam_ke ?? '');
        $request->merge(['jam_ke_resolved' => $jamKe]);

        $request->validate([
            'jam_ke_resolved' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = JamPelajaran::whereNull('deleted_at')
                        ->where('id_jam', '!=', $id)
                        ->whereRaw('LOWER(jam_ke) = ?', [mb_strtolower($value)])
                        ->exists();
                    if ($exists) {
                        $fail("Label Jam '{$value}' sudah digunakan oleh sesi lain. Data ganda tidak diperbolehkan.");
                    }
                }
            ],
            'jam_mulai'         => 'nullable|string',
            'jam_selesai'       => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->jam_mulai && $value && $value <= $request->jam_mulai) {
                        $fail('Waktu selesai Senin-Kamis harus lebih akhir daripada waktu mulai.');
                    }
                }
            ],
            'jam_mulai_jumat'   => 'nullable|string',
            'jam_selesai_jumat' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->jam_mulai_jumat && $value && $value <= $request->jam_mulai_jumat) {
                        $fail('Waktu selesai Hari Jumat harus lebih akhir daripada waktu mulai.');
                    }
                }
            ],
            'keterangan'        => 'nullable|string|max:255',
        ], [
            'jam_ke_resolved.required' => 'Label Jam wajib dipilih atau diisi.',
            'jam_ke_resolved.max'      => 'Label Jam maksimal 50 karakter.',
        ]);

        if (empty($request->jam_mulai) && empty($request->jam_mulai_jumat)) {
            return back()->withInput()->withErrors([
                'jam_mulai' => 'Minimal tentukan rentang waktu untuk Senin-Kamis atau Hari Jumat.'
            ]);
        }

        $jam->update([
            'jam_ke'            => $jamKe,
            'jam_mulai'         => $request->jam_mulai ? trim($request->jam_mulai) : null,
            'jam_selesai'       => $request->jam_selesai ? trim($request->jam_selesai) : null,
            'jam_mulai_jumat'   => $request->jam_mulai_jumat ? trim($request->jam_mulai_jumat) : null,
            'jam_selesai_jumat' => $request->jam_selesai_jumat ? trim($request->jam_selesai_jumat) : null,
            'keterangan'        => $request->keterangan ? trim($request->keterangan) : null,
        ]);

        return redirect()->route('jam-pelajaran.index')
                         ->with('success', "Data Master Jam Pelajaran '{$jamKe}' berhasil diperbarui!");
    }

    /**
     * [SOFT DELETE] Tandai jam pelajaran sebagai dihapus (mengisi deleted_at)
     */
    public function destroy($id)
    {
        $jam = JamPelajaran::findOrFail($id);
        $name = $jam->jam_ke;
        $jam->delete();

        return redirect()->route('jam-pelajaran.index')
                         ->with('success', "Jam Pelajaran '$name' berhasil dipindahkan ke tempat sampah.");
    }

    /**
     * [DESTROY BATCH] Hapus banyak sesi jam pelajaran sekaligus (Soft Delete)
     */
    public function destroyBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:jam_pelajaran,id_jam',
        ], [
            'ids.required' => 'Silakan pilih minimal satu data sesi jam pelajaran untuk dihapus.',
            'ids.min'      => 'Silakan pilih minimal satu data sesi jam pelajaran untuk dihapus.',
            'ids.*.exists' => 'Data jam pelajaran yang dipilih tidak valid atau tidak ditemukan.',
        ]);

        $count = JamPelajaran::whereIn('id_jam', $request->ids)->delete();

        return redirect()->route('jam-pelajaran.index')
                         ->with('success', "Berhasil memindahkan {$count} data sesi jam pelajaran terpilih ke Tempat Sampah.");
    }

    /**
     * [TRASH] Menampilkan daftar jam pelajaran yang di-soft-delete (Recycle Bin)
     */
    public function trash()
    {
        $trashedJam = JamPelajaran::onlyTrashed()->orderBy('deleted_at', 'desc')->get();

        return view('jam_pelajaran.trash', compact('trashedJam'));
    }

    /**
     * [RESTORE] Pulihkan data jam pelajaran yang ada di tempat sampah
     */
    public function restore($id)
    {
        $jam = JamPelajaran::onlyTrashed()->findOrFail($id);
        $jam->restore();

        return redirect()->route('jam-pelajaran.trash')
                         ->with('success', "Jam Pelajaran '{$jam->jam_ke}' berhasil dipulihkan!");
    }

    /**
     * [FORCE DELETE] Hapus permanen dari database
     */
    public function forceDelete($id)
    {
        $jam = JamPelajaran::onlyTrashed()->findOrFail($id);
        $name = $jam->jam_ke;
        $jam->forceDelete();

        return redirect()->route('jam-pelajaran.trash')
                         ->with('success', "Jam Pelajaran '{$name}' telah dihapus secara permanen dari database.");
    }
}
