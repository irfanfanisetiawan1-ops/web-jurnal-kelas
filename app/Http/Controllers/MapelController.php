<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * Helper Static: Otomatis generate kode mapel yang sesuai dan unik
     */
    public static function generateKodeMapel($namaMapel, $ignoreId = null)
    {
        $nama = trim($namaMapel ?? '');
        if (empty($nama)) {
            $prefix = 'MPL';
        } else {
            $namaUpper = strtoupper($nama);

            // 1. Kamus Singkatan Mapel Baku / Umum di Sekolah
            $knownPrefixes = [
                'BAHASA INDONESIA' => 'BIN',
                'BAHASA INGGRIS'   => 'BIG',
                'BAHASA JAWA'      => 'BJAW',
                'BAHASA JEPANG'    => 'BJEP',
                'BAHASA JERMAN'    => 'BJER',
                'BAHASA ARAB'      => 'BARB',
                'BAHASA MANDARIN'  => 'BMND',
                'MATEMATIKA'       => 'MAT',
                'PENDIDIKAN AGAMA ISLAM' => 'PAI',
                'PENDIDIKAN AGAMA KRISTEN' => 'PAK',
                'PENDIDIKAN AGAMA KATOLIK' => 'PKAT',
                'PENDIDIKAN AGAMA HINDU' => 'PAH',
                'PENDIDIKAN AGAMA BUDDHA' => 'PAB',
                'PENDIDIKAN AGAMA KHONGHUCU' => 'PAKH',
                'PENDIDIKAN PANCASILA' => 'PPKN',
                'PENDIDIKAN KEWARGANEGARAAN' => 'PKN',
                'PENDIDIKAN JASMANI' => 'PJOK',
                'PENJASKES'        => 'PJOK',
                'SENI BUDAYA'      => 'SEN',
                'SENI RUPA'        => 'SRUP',
                'SENI MUSIK'       => 'SMUS',
                'SENI TARI'        => 'STAR',
                'SENI TEATER'      => 'STEA',
                'SEJARAH'          => 'SEJ',
                'INFORMATIKA'      => 'INF',
                'BIMBINGAN KONSELING' => 'BK',
                'PROJEK ILMU PENGETAHUAN ALAM DAN SOSIAL' => 'IPAS',
                'ILMU PENGETAHUAN ALAM' => 'IPA',
                'ILMU PENGETAHUAN SOSIAL' => 'IPS',
                'KODING DAN KECERDASAN ARTIFISIAL' => 'KDK',
                'KREATIVITAS, INOVASI, DAN KEWIRAUSAHAAN' => 'PKK',
                'KONSENTRASI KEAHLIAN' => 'KKA',
            ];

            $prefix = null;
            foreach ($knownPrefixes as $key => $code) {
                if (str_contains($namaUpper, $key)) {
                    $prefix = $code;
                    break;
                }
            }

            if (!$prefix) {
                $words = preg_split('/[\s,\-_]+/', $nama);
                if (count($words) >= 2) {
                    $acronym = '';
                    foreach ($words as $w) {
                        if (!in_array(strtolower($w), ['dan', 'yang', 'untuk', 'di', 'ke', 'dari', 'budi', 'pekerti', 'kelas', 'tingkat'])) {
                            $acronym .= strtoupper(substr($w, 0, 1));
                        }
                    }
                    if (strlen($acronym) >= 2 && strlen($acronym) <= 6) {
                        $prefix = $acronym;
                    } else {
                        $prefix = strtoupper(substr($words[0], 0, 3));
                    }
                } else {
                    $clean = preg_replace('/[^a-zA-Z0-9]/', '', $namaUpper);
                    $prefix = substr($clean, 0, min(4, strlen($clean)));
                }
            }
        }

        $prefix = strtoupper(preg_replace('/[^A-Z0-9]/', '', $prefix ?? 'MPL'));
        if (empty($prefix)) {
            $prefix = 'MPL';
        }

        // Ambil semua kode mapel yang sudah ada untuk menghindari tabrakan data
        $query = Mapel::withTrashed();
        if ($ignoreId) {
            $query->where('id_mapel', '!=', $ignoreId);
        }
        $existingCodes = $query->pluck('kode_mapel')
                               ->map(fn($c) => strtoupper(trim($c)))
                               ->toArray();

        // Pola penomoran: PREFIX-01, PREFIX-02, dst.
        $index = 1;
        do {
            $candidate = sprintf('%s-%02d', $prefix, $index);
            $index++;
        } while (in_array($candidate, $existingCodes) && $index < 1000);

        return $candidate;
    }

    /**
     * [READ] Tampilkan daftar mapel aktif (yang belum di-soft-delete)
     */
    public function index(Request $request)
    {
        $search      = $request->query('search');
        $selected_id = $request->query('selected_id');

        $query = Mapel::with(['gurus' => function($q) {
            $q->orderBy('nama_guru', 'asc');
        }])->withCount(['gurus as gurus_count' => function($q) {
            $q->select(\DB::raw('count(distinct jadwal.id_guru)'));
        }])->orderBy('nama_mapel', 'asc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_mapel', 'like', "%{$search}%")
                  ->orWhere('kode_mapel', 'like', "%{$search}%")
                  ->orWhereHas('gurus', function($g) use ($search) {
                      $g->where('nama_guru', 'like', "%{$search}%");
                  });
            });
        }

        $mapels       = $query->get();
        $trashedCount = Mapel::onlyTrashed()->count();

        // Selected Mapel for Detail Panel
        $selectedMapel = null;
        if ($selected_id) {
            $selectedMapel = Mapel::with(['gurus' => function($q) {
                $q->orderBy('nama_guru', 'asc');
            }])->withCount(['gurus as gurus_count' => function($q) {
                $q->select(\DB::raw('count(distinct jadwal.id_guru)'));
            }])->find($selected_id);
        }

        if (!$selectedMapel && $mapels->count() > 0) {
            $selectedMapel = $mapels->first();
        }

        // Data mapel untuk validasi instan di sisi klien
        $allMapels = Mapel::withTrashed()->get(['id_mapel', 'kode_mapel', 'nama_mapel', 'deleted_at']);
        $existingMapelsList = $allMapels->map(function($m) {
            return [
                'id'         => $m->id_mapel,
                'kode'       => strtoupper(trim($m->kode_mapel)),
                'nama'       => trim($m->nama_mapel),
                'nama_lower' => strtolower(trim($m->nama_mapel)),
                'is_trash'   => !is_null($m->deleted_at),
            ];
        })->values()->toArray();

        return view('mapel.index', compact('mapels', 'selectedMapel', 'trashedCount', 'search', 'selected_id', 'existingMapelsList'));
    }

    /**
     * API: Generate kode mapel otomatis via AJAX
     */
    public function generateKodeApi(Request $request)
    {
        $nama = $request->query('nama', '');
        $ignoreId = $request->query('ignore_id');
        $kode = self::generateKodeMapel($nama, $ignoreId);

        return response()->json([
            'success'    => true,
            'kode_mapel' => $kode,
        ]);
    }

    /**
     * API: Cek ketersediaan dan validasi data kode & nama mapel via AJAX
     */
    public function checkKodeApi(Request $request)
    {
        $kode     = trim(strtoupper($request->query('kode', '')));
        $nama     = trim($request->query('nama', ''));
        $ignoreId = $request->query('ignore_id');

        $result = [
            'kode_valid'     => true,
            'kode_available' => true,
            'kode_message'   => 'Kode Mapel tersedia.',
            'nama_valid'     => true,
            'nama_available' => true,
            'nama_message'   => 'Nama Mapel tersedia.',
        ];

        if ($kode) {
            $query = Mapel::withTrashed()->whereRaw('UPPER(TRIM(kode_mapel)) = ?', [$kode]);
            if ($ignoreId) {
                $query->where('id_mapel', '!=', $ignoreId);
            }
            $existing = $query->first();
            if ($existing) {
                $result['kode_available'] = false;
                if ($existing->deleted_at) {
                    $result['kode_message'] = "Kode '{$kode}' sudah ada pada mapel \"{$existing->nama_mapel}\" di Tempat Sampah.";
                } else {
                    $result['kode_message'] = "Kode '{$kode}' sudah digunakan oleh mata pelajaran \"{$existing->nama_mapel}\".";
                }
            }
        }

        if ($nama) {
            $queryNama = Mapel::withTrashed()->whereRaw('LOWER(TRIM(nama_mapel)) = ?', [strtolower($nama)]);
            if ($ignoreId) {
                $queryNama->where('id_mapel', '!=', $ignoreId);
            }
            $existingNama = $queryNama->first();
            if ($existingNama) {
                $result['nama_available'] = false;
                if ($existingNama->deleted_at) {
                    $result['nama_message'] = "Mata pelajaran \"{$existingNama->nama_mapel}\" berada di Tempat Sampah.";
                } else {
                    $result['nama_message'] = "Mata pelajaran \"{$existingNama->nama_mapel}\" sudah terdaftar di sistem.";
                }
            }
        }

        return response()->json($result);
    }

    /**
     * [CREATE] Menampilkan form tambah mapel
     */
    public function create()
    {
        $allMapels = Mapel::withTrashed()->get(['id_mapel', 'kode_mapel', 'nama_mapel', 'deleted_at']);
        $existingMapelsList = $allMapels->map(function($m) {
            return [
                'id'         => $m->id_mapel,
                'kode'       => strtoupper(trim($m->kode_mapel)),
                'nama'       => trim($m->nama_mapel),
                'nama_lower' => strtolower(trim($m->nama_mapel)),
                'is_trash'   => !is_null($m->deleted_at),
            ];
        })->values()->toArray();

        return view('mapel.create', compact('existingMapelsList'));
    }

    /**
     * [STORE] Memproses & menyimpan data mapel baru ke database dengan validasi anti bentrok
     */
    public function store(Request $request)
    {
        $namaMapel = trim($request->nama_mapel ?? '');
        $kodeMapel = trim(strtoupper($request->kode_mapel ?? ''));

        // Jika kode mapel kosong, generate otomatis dari nama mapel
        if (empty($kodeMapel) && !empty($namaMapel)) {
            $kodeMapel = self::generateKodeMapel($namaMapel);
            $request->merge(['kode_mapel' => $kodeMapel]);
        } else {
            $request->merge(['kode_mapel' => $kodeMapel]);
        }
        $request->merge(['nama_mapel' => $namaMapel]);

        // 1. Validasi Dasar
        $request->validate([
            'nama_mapel' => 'required|string|min:2|max:100',
            'kode_mapel' => 'required|string|min:2|max:15|regex:/^[A-Z0-9\-_]+$/',
        ], [
            'nama_mapel.required' => 'Nama Mata Pelajaran wajib diisi.',
            'nama_mapel.min'      => 'Nama Mata Pelajaran minimal 2 karakter.',
            'nama_mapel.max'      => 'Nama Mata Pelajaran maksimal 100 karakter.',
            'kode_mapel.required' => 'Kode Mapel wajib diisi.',
            'kode_mapel.min'      => 'Kode Mapel minimal 2 karakter.',
            'kode_mapel.max'      => 'Kode Mapel maksimal 15 karakter.',
            'kode_mapel.regex'    => 'Kode Mapel hanya boleh berisi huruf kapital, angka, strip (-), dan garis bawah (_).',
        ]);

        // 2. Validasi Anti-Bentrok: Cek Duplikasi Nama Mapel (Case Insensitive)
        $existingName = Mapel::withTrashed()->whereRaw('LOWER(TRIM(nama_mapel)) = ?', [strtolower($namaMapel)])->first();
        if ($existingName) {
            if ($existingName->deleted_at) {
                return redirect()->back()->withInput()->withErrors([
                    'nama_mapel' => "Mata Pelajaran \"{$existingName->nama_mapel}\" sudah ada di Tempat Sampah. Silakan pulihkan data tersebut dari menu Lihat Sampah Mapel.",
                ]);
            } else {
                return redirect()->back()->withInput()->withErrors([
                    'nama_mapel' => "Mata Pelajaran \"{$existingName->nama_mapel}\" sudah terdaftar di sistem dengan kode {$existingName->kode_mapel}.",
                ]);
            }
        }

        // 3. Validasi Anti-Bentrok: Cek Duplikasi Kode Mapel
        $existingCode = Mapel::withTrashed()->whereRaw('UPPER(TRIM(kode_mapel)) = ?', [$kodeMapel])->first();
        if ($existingCode) {
            if ($existingCode->deleted_at) {
                return redirect()->back()->withInput()->withErrors([
                    'kode_mapel' => "Kode Mapel \"{$kodeMapel}\" sudah digunakan oleh mapel \"{$existingCode->nama_mapel}\" di Tempat Sampah.",
                ]);
            } else {
                return redirect()->back()->withInput()->withErrors([
                    'kode_mapel' => "Kode Mapel \"{$kodeMapel}\" sudah digunakan oleh mata pelajaran \"{$existingCode->nama_mapel}\". Silakan gunakan kode lain atau generate otomatis.",
                ]);
            }
        }

        $mapel = Mapel::create([
            'kode_mapel' => $kodeMapel,
            'nama_mapel' => $namaMapel,
        ]);

        return redirect()->route('mapel.index', ['selected_id' => $mapel->id_mapel])
                         ->with('success', "Data mata pelajaran \"{$mapel->nama_mapel}\" (Kode: {$mapel->kode_mapel}) berhasil ditambahkan!");
    }

    /**
     * [SHOW] Menampilkan detail data 1 mapel beserta daftar guru pengampunya
     */
    public function show($id)
    {
        $mapel = Mapel::with(['gurus' => function($q) {
            $q->orderBy('nama_guru', 'asc');
        }])->withCount(['gurus as gurus_count' => function($q) {
            $q->select(\DB::raw('count(distinct jadwal.id_guru)'));
        }])->findOrFail($id);

        return view('mapel.show', compact('mapel'));
    }

    /**
     * [EDIT] Menampilkan form edit data mapel
     */
    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        $allMapels = Mapel::withTrashed()->get(['id_mapel', 'kode_mapel', 'nama_mapel', 'deleted_at']);
        $existingMapelsList = $allMapels->map(function($m) {
            return [
                'id'         => $m->id_mapel,
                'kode'       => strtoupper(trim($m->kode_mapel)),
                'nama'       => trim($m->nama_mapel),
                'nama_lower' => strtolower(trim($m->nama_mapel)),
                'is_trash'   => !is_null($m->deleted_at),
            ];
        })->values()->toArray();

        return view('mapel.edit', compact('mapel', 'existingMapelsList'));
    }

    /**
     * [UPDATE] Memproses perubahan data mapel di database dengan validasi anti bentrok
     */
    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

        $namaMapel = trim($request->nama_mapel ?? '');
        $kodeMapel = trim(strtoupper($request->kode_mapel ?? ''));

        if (empty($kodeMapel) && !empty($namaMapel)) {
            $kodeMapel = self::generateKodeMapel($namaMapel, $mapel->id_mapel);
            $request->merge(['kode_mapel' => $kodeMapel]);
        } else {
            $request->merge(['kode_mapel' => $kodeMapel]);
        }
        $request->merge(['nama_mapel' => $namaMapel]);

        $request->validate([
            'nama_mapel' => 'required|string|min:2|max:100',
            'kode_mapel' => 'required|string|min:2|max:15|regex:/^[A-Z0-9\-_]+$/',
        ], [
            'nama_mapel.required' => 'Nama Mata Pelajaran wajib diisi.',
            'nama_mapel.min'      => 'Nama Mata Pelajaran minimal 2 karakter.',
            'nama_mapel.max'      => 'Nama Mata Pelajaran maksimal 100 karakter.',
            'kode_mapel.required' => 'Kode Mapel wajib diisi.',
            'kode_mapel.min'      => 'Kode Mapel minimal 2 karakter.',
            'kode_mapel.max'      => 'Kode Mapel maksimal 15 karakter.',
            'kode_mapel.regex'    => 'Kode Mapel hanya boleh berisi huruf kapital, angka, strip (-), dan garis bawah (_).',
        ]);

        // Cek bentrok nama dengan mapel lain
        $existingName = Mapel::withTrashed()
            ->where('id_mapel', '!=', $mapel->id_mapel)
            ->whereRaw('LOWER(TRIM(nama_mapel)) = ?', [strtolower($namaMapel)])
            ->first();

        if ($existingName) {
            if ($existingName->deleted_at) {
                return redirect()->back()->withInput()->withErrors([
                    'nama_mapel' => "Mata Pelajaran \"{$existingName->nama_mapel}\" sudah ada di Tempat Sampah.",
                ]);
            } else {
                return redirect()->back()->withInput()->withErrors([
                    'nama_mapel' => "Mata Pelajaran \"{$existingName->nama_mapel}\" sudah terdaftar di sistem dengan kode {$existingName->kode_mapel}.",
                ]);
            }
        }

        // Cek bentrok kode dengan mapel lain
        $existingCode = Mapel::withTrashed()
            ->where('id_mapel', '!=', $mapel->id_mapel)
            ->whereRaw('UPPER(TRIM(kode_mapel)) = ?', [$kodeMapel])
            ->first();

        if ($existingCode) {
            if ($existingCode->deleted_at) {
                return redirect()->back()->withInput()->withErrors([
                    'kode_mapel' => "Kode Mapel \"{$kodeMapel}\" sudah digunakan oleh data mapel \"{$existingCode->nama_mapel}\" di Tempat Sampah.",
                ]);
            } else {
                return redirect()->back()->withInput()->withErrors([
                    'kode_mapel' => "Kode Mapel \"{$kodeMapel}\" sudah digunakan oleh mata pelajaran \"{$existingCode->nama_mapel}\".",
                ]);
            }
        }

        $mapel->update([
            'kode_mapel' => $kodeMapel,
            'nama_mapel' => $namaMapel,
        ]);

        return redirect()->route('mapel.index', ['selected_id' => $mapel->id_mapel])
                         ->with('success', "Data mata pelajaran \"{$mapel->nama_mapel}\" berhasil diperbarui!");
    }

    /**
     * [SOFT DELETE] Tandai mapel sebagai dihapus (mengisi deleted_at)
     */
    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $nama = $mapel->nama_mapel;
        $mapel->delete();

        return redirect()->route('mapel.index')
                         ->with('success', "Data mapel \"$nama\" berhasil dipindahkan ke Tempat Sampah.");
    }

    /**
     * [DESTROY BATCH] Hapus banyak mapel sekaligus (Soft Delete)
     */
    public function destroyBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:mapel,id_mapel',
        ], [
            'ids.required' => 'Silakan pilih minimal satu data mapel untuk dihapus.',
            'ids.min'      => 'Silakan pilih minimal satu data mapel untuk dihapus.',
            'ids.*.exists' => 'Data mapel yang dipilih tidak valid atau tidak ditemukan.',
        ]);

        $count = Mapel::whereIn('id_mapel', $request->ids)->delete();

        return redirect()->route('mapel.index')
                         ->with('success', "Berhasil memindahkan {$count} data mapel terpilih ke Tempat Sampah.");
    }

    /**
     * [TRASH] Menampilkan daftar mapel yang di-soft-delete (Recycle Bin)
     */
    public function trash()
    {
        $mapels = Mapel::onlyTrashed()->withCount(['gurus as gurus_count' => function($q) {
            $q->select(\DB::raw('count(distinct jadwal.id_guru)'));
        }])->orderBy('nama_mapel')->get();
        return view('mapel.trash', compact('mapels'));
    }

    /**
     * [RESTORE] Pulihkan data mapel yang ada di tempat sampah
     */
    public function restore($id)
    {
        $mapel = Mapel::onlyTrashed()->findOrFail($id);
        $mapel->restore();

        return redirect()->route('mapel.trash')
                         ->with('success', "Data mapel \"{$mapel->nama_mapel}\" berhasil dipulihkan!");
    }

    /**
     * [FORCE DELETE] Hapus permanen dari database
     */
    public function forceDelete($id)
    {
        $mapel = Mapel::onlyTrashed()->findOrFail($id);
        $nama = $mapel->nama_mapel;
        $mapel->forceDelete();

        return redirect()->route('mapel.trash')
                         ->with('success', "Data mapel \"$nama\" telah dihapus secara permanen dari database.");
    }
}
