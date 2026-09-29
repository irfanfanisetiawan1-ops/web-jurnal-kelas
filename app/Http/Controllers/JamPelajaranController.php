<?php

namespace App\Http\Controllers;

use App\Models\JamPelajaran;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        try {
            $hariLiburList    = HariLibur::orderBy('tanggal_mulai', 'desc')->get();
            $holidayInfoToday = HariLibur::getHolidayInfoForDate();
        } catch (\Throwable $e) {
            $hariLiburList    = collect();
            $holidayInfoToday = [
                'is_holiday'     => false,
                'is_weekend'     => false,
                'holiday'        => null,
                'keterangan'     => null,
                'status_text'    => 'Hari Aktif Belajar',
                'badge_class'    => 'badge-aktif',
                'date_formatted' => Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y'),
            ];
        }

        return view('jam_pelajaran.index', compact('jamList', 'search', 'trashedCount', 'hariLiburList', 'holidayInfoToday'));
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

        $jamMulai = $request->jam_mulai ? trim($request->jam_mulai) : null;
        $jamSelesai = $request->jam_selesai ? trim($request->jam_selesai) : null;
        $jamMulaiJumat = $request->jam_mulai_jumat ? trim($request->jam_mulai_jumat) : null;
        $jamSelesaiJumat = $request->jam_selesai_jumat ? trim($request->jam_selesai_jumat) : null;

        JamPelajaran::create([
            'jam_ke'                    => $jamKe,
            'jam_mulai'                 => $jamMulai,
            'jam_selesai'               => $jamSelesai,
            'jam_mulai_default'         => $jamMulai,
            'jam_selesai_default'       => $jamSelesai,
            'is_active_senin_kamis'     => !empty($jamMulai),
            'jam_mulai_jumat'           => $jamMulaiJumat,
            'jam_selesai_jumat'         => $jamSelesaiJumat,
            'jam_mulai_jumat_default'   => $jamMulaiJumat,
            'jam_selesai_jumat_default' => $jamSelesaiJumat,
            'is_active_jumat'           => !empty($jamMulaiJumat),
            'keterangan'                => $request->keterangan ? trim($request->keterangan) : null,
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
            $hasDefault = ($jam->jam_mulai_default || $jam->jam_mulai_jumat_default);
            if (!$hasDefault) {
                return back()->withInput()->withErrors([
                    'jam_mulai' => 'Minimal tentukan rentang waktu untuk Senin-Kamis atau Hari Jumat.'
                ]);
            }
        }

        // Normalisasi format input (H:i)
        $inputMulaiSK    = $request->jam_mulai ? substr(trim($request->jam_mulai), 0, 5) : null;
        $inputSelesaiSK  = $request->jam_selesai ? substr(trim($request->jam_selesai), 0, 5) : null;
        $inputMulaiFri   = $request->jam_mulai_jumat ? substr(trim($request->jam_mulai_jumat), 0, 5) : null;
        $inputSelesaiFri = $request->jam_selesai_jumat ? substr(trim($request->jam_selesai_jumat), 0, 5) : null;

        // Nilai saat ini di database (format H:i)
        $dbDefaultMulaiSK   = ($jam->jam_mulai_default ?? $jam->jam_mulai) ? substr(($jam->jam_mulai_default ?? $jam->jam_mulai), 0, 5) : null;
        $dbDefaultSelesaiSK = ($jam->jam_selesai_default ?? $jam->jam_selesai) ? substr(($jam->jam_selesai_default ?? $jam->jam_selesai), 0, 5) : null;
        $dbMulaiSK          = $jam->jam_mulai ? substr($jam->jam_mulai, 0, 5) : null;
        $dbSelesaiSK        = $jam->jam_selesai ? substr($jam->jam_selesai, 0, 5) : null;

        $dbDefaultMulaiFri   = ($jam->jam_mulai_jumat_default ?? $jam->jam_mulai_jumat) ? substr(($jam->jam_mulai_jumat_default ?? $jam->jam_mulai_jumat), 0, 5) : null;
        $dbDefaultSelesaiFri = ($jam->jam_selesai_jumat_default ?? $jam->jam_selesai_jumat) ? substr(($jam->jam_selesai_jumat_default ?? $jam->jam_selesai_jumat), 0, 5) : null;
        $dbMulaiFri          = $jam->jam_mulai_jumat ? substr($jam->jam_mulai_jumat, 0, 5) : null;
        $dbSelesaiFri        = $jam->jam_selesai_jumat ? substr($jam->jam_selesai_jumat, 0, 5) : null;

        // 1. Deteksi apakah admin sengaja mengubah waktu Senin-Kamis
        $timeChangedSK = false;
        if ($inputMulaiSK === $dbDefaultMulaiSK && $inputSelesaiSK === $dbDefaultSelesaiSK) {
            $timeChangedSK = false;
        } elseif ($jam->is_shifted_senin_kamis && $inputMulaiSK === $dbMulaiSK && $inputSelesaiSK === $dbSelesaiSK) {
            // Sesi sedang shifted dan form mengirim jam shifted bawaan view
            $timeChangedSK = false;
        } elseif (!$jam->is_active_senin_kamis && empty($inputMulaiSK) && empty($inputSelesaiSK)) {
            // Sesi sedang nonaktif dan form kosong karena jam_mulai null
            $timeChangedSK = false;
        } else {
            $timeChangedSK = true;
        }

        // 2. Deteksi apakah admin sengaja mengubah waktu Hari Jumat
        $timeChangedFri = false;
        if ($inputMulaiFri === $dbDefaultMulaiFri && $inputSelesaiFri === $dbDefaultSelesaiFri) {
            $timeChangedFri = false;
        } elseif ($jam->is_shifted_jumat && $inputMulaiFri === $dbMulaiFri && $inputSelesaiFri === $dbSelesaiFri) {
            // Sesi sedang shifted Jumat dan form mengirim jam shifted bawaan view
            $timeChangedFri = false;
        } elseif (!$jam->is_active_jumat && empty($inputMulaiFri) && empty($inputSelesaiFri)) {
            // Sesi sedang nonaktif Jumat dan form kosong
            $timeChangedFri = false;
        } else {
            $timeChangedFri = true;
        }

        // Tentukan data yang disimpan untuk Senin-Kamis
        if ($timeChangedSK) {
            $newDefaultMulaiSK   = $request->jam_mulai ? trim($request->jam_mulai) : null;
            $newDefaultSelesaiSK = $request->jam_selesai ? trim($request->jam_selesai) : null;
            $isActiveSK          = empty($newDefaultMulaiSK) ? false : (bool) $jam->is_active_senin_kamis;
            $newMulaiSK          = $isActiveSK ? $newDefaultMulaiSK : null;
            $newSelesaiSK        = $isActiveSK ? $newDefaultSelesaiSK : null;
        } else {
            $newDefaultMulaiSK   = $jam->jam_mulai_default ?? $jam->jam_mulai;
            $newDefaultSelesaiSK = $jam->jam_selesai_default ?? $jam->jam_selesai;
            $isActiveSK          = (bool) $jam->is_active_senin_kamis;
            $newMulaiSK          = $jam->jam_mulai;
            $newSelesaiSK        = $jam->jam_selesai;
        }

        // Tentukan data yang disimpan untuk Hari Jumat
        if ($timeChangedFri) {
            $newDefaultMulaiFri   = $request->jam_mulai_jumat ? trim($request->jam_mulai_jumat) : null;
            $newDefaultSelesaiFri = $request->jam_selesai_jumat ? trim($request->jam_selesai_jumat) : null;
            $isActiveFri          = empty($newDefaultMulaiFri) ? false : (bool) $jam->is_active_jumat;
            $newMulaiFri          = $isActiveFri ? $newDefaultMulaiFri : null;
            $newSelesaiFri        = $isActiveFri ? $newDefaultSelesaiFri : null;
        } else {
            $newDefaultMulaiFri   = $jam->jam_mulai_jumat_default ?? $jam->jam_mulai_jumat;
            $newDefaultSelesaiFri = $jam->jam_selesai_jumat_default ?? $jam->jam_selesai_jumat;
            $isActiveFri          = (bool) $jam->is_active_jumat;
            $newMulaiFri          = $jam->jam_mulai_jumat;
            $newSelesaiFri        = $jam->jam_selesai_jumat;
        }

        $jam->update([
            'jam_ke'                    => $jamKe,
            'jam_mulai'                 => $newMulaiSK,
            'jam_selesai'               => $newSelesaiSK,
            'jam_mulai_default'         => $newDefaultMulaiSK,
            'jam_selesai_default'       => $newDefaultSelesaiSK,
            'is_active_senin_kamis'     => $isActiveSK,
            'jam_mulai_jumat'           => $newMulaiFri,
            'jam_selesai_jumat'         => $newSelesaiFri,
            'jam_mulai_jumat_default'   => $newDefaultMulaiFri,
            'jam_selesai_jumat_default' => $newDefaultSelesaiFri,
            'is_active_jumat'           => $isActiveFri,
            'keterangan'                => $request->keterangan ? trim($request->keterangan) : null,
        ]);

        // Hitung ulang jadwal hanya jika waktu default memang sengaja diubah oleh admin
        if ($timeChangedSK || $timeChangedFri) {
            JamPelajaran::recalculateSchedules();
        }

        return redirect()->route('jam-pelajaran.index')
                         ->with('success', "Data Master Jam Pelajaran '{$jamKe}' berhasil diperbarui!");
    }

    /**
     * [AJAX TOGGLE] Mengaktifkan / Menonaktifkan sesi jam pelajaran untuk memajukan jam
     */
    public function toggleActive(Request $request)
    {
        $request->validate([
            'id_jam'    => 'required|exists:jam_pelajaran,id_jam',
            'day_type'  => 'required|in:senin_kamis,jumat',
            'is_active' => 'required',
        ]);

        $jam = JamPelajaran::findOrFail($request->id_jam);
        $isActive = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);

        if ($request->day_type === 'senin_kamis') {
            $jam->is_active_senin_kamis = $isActive;
            $jam->save();
            JamPelajaran::recalculateSchedules('senin_kamis');
        } else {
            $jam->is_active_jumat = $isActive;
            $jam->save();
            JamPelajaran::recalculateSchedules('jumat');
        }

        // Ambil data terbaru semua sesi jam untuk update DOM
        $allJam = JamPelajaran::orderBy('id_jam', 'asc')->get()->map(function($j) {
            return [
                'id_jam'                 => $j->id_jam,
                'jam_ke'                 => $j->jam_ke,
                'waktu_senin_kamis'      => $j->waktu_senin_kamis,
                'is_active_senin_kamis'  => (bool) $j->is_active_senin_kamis,
                'is_shifted_senin_kamis' => $j->is_shifted_senin_kamis,
                'waktu_jumat'            => $j->waktu_jumat,
                'is_active_jumat'        => (bool) $j->is_active_jumat,
                'is_shifted_jumat'       => $j->is_shifted_jumat,
            ];
        });

        $actionText = $isActive ? 'diaktifkan (kembali normal)' : 'dinonaktifkan (jam pelajaran berikutnya maju 1 JP)';
        $dayLabel   = $request->day_type === 'senin_kamis' ? 'Senin – Kamis' : 'Hari Jumat';

        return response()->json([
            'success' => true,
            'message' => "Sesi {$jam->jam_ke} untuk {$dayLabel} berhasil {$actionText}!",
            'data'    => $allJam,
        ]);
    }

    /**
     * [RESET] Kembalikan semua jam pelajaran ke jadwal normal / standar
     */
    public function resetToDefault(Request $request)
    {
        $dayType = $request->input('day_type');
        if (!in_array($dayType, ['senin_kamis', 'jumat', null])) {
            $dayType = null;
        }

        JamPelajaran::resetToDefault($dayType);

        if ($request->expectsJson() || $request->ajax()) {
            $allJam = JamPelajaran::orderBy('id_jam', 'asc')->get()->map(function($j) {
                return [
                    'id_jam'                 => $j->id_jam,
                    'jam_ke'                 => $j->jam_ke,
                    'waktu_senin_kamis'      => $j->waktu_senin_kamis,
                    'is_active_senin_kamis'  => (bool) $j->is_active_senin_kamis,
                    'is_shifted_senin_kamis' => $j->is_shifted_senin_kamis,
                    'waktu_jumat'            => $j->waktu_jumat,
                    'is_active_jumat'        => (bool) $j->is_active_jumat,
                    'is_shifted_jumat'       => $j->is_shifted_jumat,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Seluruh jadwal jam pelajaran berhasil dikembalikan ke jadwal normal/standar!',
                'data'    => $allJam,
            ]);
        }

        return redirect()->route('jam-pelajaran.index')
                         ->with('success', 'Seluruh jadwal jam pelajaran berhasil dikembalikan ke jadwal normal/standar!');
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

    /**
     * [STORE BATCH HARI LIBUR] Menyimpan satu atau banyak rentang hari libur sekaligus
     */
    public function storeHariLibur(Request $request)
    {
        $request->validate([
            'holidays'                   => 'required|array|min:1',
            'holidays.*.tanggal_mulai'   => 'required|date',
            'holidays.*.tanggal_selesai' => 'required|date|after_or_equal:holidays.*.tanggal_mulai',
            'holidays.*.keterangan'      => 'required|string|max:255',
        ], [
            'holidays.required'                         => 'Minimal tentukan satu rentang jadwal hari libur.',
            'holidays.min'                              => 'Minimal tentukan satu rentang jadwal hari libur.',
            'holidays.*.tanggal_mulai.required'         => 'Tanggal mulai libur wajib diisi.',
            'holidays.*.tanggal_mulai.date'             => 'Format tanggal mulai tidak valid.',
            'holidays.*.tanggal_selesai.required'       => 'Tanggal selesai libur wajib diisi.',
            'holidays.*.tanggal_selesai.date'           => 'Format tanggal selesai tidak valid.',
            'holidays.*.tanggal_selesai.after_or_equal' => 'Tanggal selesai libur harus sama atau setelah tanggal mulai libur.',
            'holidays.*.keterangan.required'            => 'Keterangan / Nama hari libur wajib diisi.',
            'holidays.*.keterangan.max'                 => 'Keterangan hari libur maksimal 255 karakter.',
        ]);

        $createdCount = 0;
        DB::beginTransaction();
        try {
            foreach ($request->holidays as $row) {
                $tglMulai   = trim($row['tanggal_mulai'] ?? '');
                $tglSelesai = trim($row['tanggal_selesai'] ?? '');
                $keterangan = trim($row['keterangan'] ?? '');

                if ($tglMulai && $tglSelesai && $keterangan) {
                    HariLibur::create([
                        'tanggal_mulai'   => $tglMulai,
                        'tanggal_selesai' => $tglSelesai,
                        'keterangan'      => $keterangan,
                        'is_active'       => true,
                        'created_by'      => auth()->id(),
                    ]);
                    $createdCount++;
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan jadwal hari libur: ' . $e->getMessage()
                ], 500);
            }
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan jadwal hari libur: ' . $e->getMessage());
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Berhasil menyimpan {$createdCount} jadwal hari libur sekolah!",
                'data'    => $this->getFormattedHolidaysData()
            ]);
        }

        return redirect()->route('jam-pelajaran.index')
                         ->with('success', "Berhasil menyimpan {$createdCount} jadwal hari libur sekolah!");
    }

    /**
     * [TOGGLE HARI LIBUR] Mengaktifkan / Menonaktifkan jadwal libur
     */
    public function toggleHariLibur($id, Request $request)
    {
        $libur = HariLibur::findOrFail($id);
        $libur->is_active = !$libur->is_active;
        $libur->save();

        $statusText = $libur->is_active ? 'diaktifkan kembali' : 'dinonaktifkan (dibatalkan)';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Jadwal libur '{$libur->keterangan}' berhasil {$statusText}!",
                'data'    => $this->getFormattedHolidaysData()
            ]);
        }

        return redirect()->route('jam-pelajaran.index')
                         ->with('success', "Jadwal libur '{$libur->keterangan}' berhasil {$statusText}!");
    }

    /**
     * [DESTROY HARI LIBUR] Hapus data jadwal hari libur
     */
    public function destroyHariLibur($id, Request $request)
    {
        $libur = HariLibur::findOrFail($id);
        $name  = $libur->keterangan;
        $libur->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Jadwal libur '{$name}' berhasil dihapus dari sistem!",
                'data'    => $this->getFormattedHolidaysData()
            ]);
        }

        return redirect()->route('jam-pelajaran.index')
                         ->with('success', "Jadwal libur '{$name}' berhasil dihapus dari sistem!");
    }

    /**
     * [LIST HARI LIBUR] Data JSON untuk dynamic update di frontend
     */
    public function listHariLibur(Request $request)
    {
        return response()->json([
            'success' => true,
            'data'    => $this->getFormattedHolidaysData()
        ]);
    }

    /**
     * Helper internal memformat data hari libur untuk JSON
     */
    protected function getFormattedHolidaysData(): array
    {
        try {
            $all = HariLibur::orderBy('tanggal_mulai', 'desc')->get()->map(function($h) {
                return [
                    'id'                   => $h->id,
                    'keterangan'           => $h->keterangan,
                    'tanggal_mulai'        => $h->tanggal_mulai ? $h->tanggal_mulai->format('Y-m-d') : null,
                    'tanggal_selesai'      => $h->tanggal_selesai ? $h->tanggal_selesai->format('Y-m-d') : null,
                    'rentang_formatted'    => $h->rentang_formatted,
                    'durasi_hari'          => $h->durasi_hari,
                    'is_active'            => (bool) $h->is_active,
                    'is_currently_ongoing' => (bool) $h->is_currently_ongoing,
                ];
            });

            $todayInfo = HariLibur::getHolidayInfoForDate();

            return [
                'holidays'   => $all,
                'today_info' => $todayInfo,
            ];
        } catch (\Throwable $e) {
            return [
                'holidays'   => collect(),
                'today_info' => [
                    'is_holiday'     => false,
                    'is_weekend'     => false,
                    'holiday'        => null,
                    'keterangan'     => null,
                    'status_text'    => 'Hari Aktif Belajar',
                    'badge_class'    => 'badge-aktif',
                    'date_formatted' => Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y'),
                ],
            ];
        }
    }
}
