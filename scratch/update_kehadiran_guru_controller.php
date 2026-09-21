<?php

$controllerPath = 'c:/laragon/www/web-jurnal-kelas/app/Http/Controllers/KepalaSekolahController.php';
$content = file_get_contents($controllerPath);

$oldCode = <<<'CODE'
    /**
     * Halaman Monitoring Kehadiran Guru (Persis Mockup UI media_1787329513206.png)
     */
    public function kehadiranGuru(Request $request)
    {
        $this->ensureSampleGuruIzin();
        $tanggal = $request->input('tanggal', Carbon::today('Asia/Jakarta')->toDateString());
        
        $guruIzinList = GuruIzin::with('guru')->orderBy('created_at', 'desc')->get();
        $guruList = Guru::with('mapel')->orderBy('nama_guru')->get();
        $jurnalHariIni = JurnalMengajar::whereDate('tanggal', $tanggal)->get()->keyBy('id_guru');
        $izinHariIni = GuruIzin::whereDate('tanggal_mulai', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal)
            ->get()
            ->keyBy('id_guru');

        return view('kepala_sekolah.kehadiran_guru', compact('guruIzinList', 'guruList', 'jurnalHariIni', 'izinHariIni', 'tanggal'));
    }
CODE;

$newCode = <<<'CODE'
    /**
     * Halaman Monitoring Kehadiran Guru (Role Kepala Sekolah)
     */
    public function kehadiranGuru(Request $request)
    {
        Carbon::setLocale('id');
        $this->ensureSampleGuruIzin();

        $searchQuery = trim($request->input('q', ''));
        $statusFilter = $request->input('status', 'all');
        $kategoriFilter = $request->input('kategori', 'all');
        $tanggal = $request->input('tanggal', Carbon::today('Asia/Jakarta')->toDateString());
        $todayStr = Carbon::today('Asia/Jakarta')->toDateString();

        // 1. Build Query for Guru Izin Cards
        $izinQuery = GuruIzin::with(['guru.mapel', 'guruPiket'])->orderBy('created_at', 'desc');

        if (!empty($searchQuery)) {
            $izinQuery->where(function($q) use ($searchQuery) {
                $q->whereHas('guru', function($g) use ($searchQuery) {
                    $g->where('nama_guru', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('nip', 'LIKE', "%{$searchQuery}%")
                      ->orWhereHas('mapel', function($m) use ($searchQuery) {
                          $m->where('nama_mapel', 'LIKE', "%{$searchQuery}%");
                      });
                })->orWhere('alasan', 'LIKE', "%{$searchQuery}%");
            });
        }

        if ($statusFilter !== 'all') {
            if ($statusFilter === 'pending') {
                $izinQuery->where('status_kepsek', 'pending');
            } elseif ($statusFilter === 'approved') {
                $izinQuery->where('status_kepsek', 'approved');
            } elseif ($statusFilter === 'rejected') {
                $izinQuery->where('status_kepsek', 'rejected');
            }
        }

        if ($kategoriFilter !== 'all') {
            $izinQuery->where(function($q) use ($kategoriFilter) {
                $q->where('kategori_izin', 'LIKE', "%{$kategoriFilter}%")
                  ->orWhere('durasi', 'LIKE', "%{$kategoriFilter}%");
            });
        }

        if ($request->filled('tanggal_filter')) {
            $tglF = $request->input('tanggal_filter');
            $izinQuery->whereDate('tanggal_mulai', '<=', $tglF)
                      ->whereDate('tanggal_selesai', '>=', $tglF);
        }

        $guruIzinList = $izinQuery->get();

        // Calculate and format accurate data attributes for each GuruIzin
        foreach ($guruIzinList as $item) {
            $start = $item->tanggal_mulai ? Carbon::parse($item->tanggal_mulai) : null;
            $end = $item->tanggal_selesai ? Carbon::parse($item->tanggal_selesai) : $start;

            $item->durasi_days = ($start && $end) ? ($start->diffInDays($end) + 1) : 1;
            
            // Format nice duration label
            $rawKat = strtolower($item->kategori_izin ?? 'biasa');
            if (str_contains($rawKat, 'cuti')) {
                $katLabel = 'Cuti / Izin Khusus';
            } elseif (str_contains($rawKat, 'sakit')) {
                $katLabel = 'Sakit';
            } elseif (str_contains($rawKat, 'dinas')) {
                $katLabel = 'Tugas Dinas Luar';
            } else {
                $katLabel = 'Izin Biasa';
            }
            $item->kategori_label = $katLabel;

            if ($start && $end && $item->tanggal_mulai !== $item->tanggal_selesai) {
                $item->durasi_formatted_real = "{$katLabel} ({$item->durasi_days} Hari: " . $start->format('d/m/Y') . " s/d " . $end->format('d/m/Y') . ")";
            } else {
                $item->durasi_formatted_real = "{$katLabel} (1 Hari)";
            }

            // Foto URL
            $fotoUrl = null;
            if ($item->foto_surat) {
                if (file_exists(public_path('uploads/guru_izin/' . $item->foto_surat))) {
                    $fotoUrl = asset('uploads/guru_izin/' . $item->foto_surat);
                }
            }
            if (!$fotoUrl) {
                $fotoUrl = asset('uploads/guru_izin/1787625106_QJzh6X66.png');
            }
            $item->foto_url_resolved = $fotoUrl;
        }

        // 2. Metrics & Summary Statistics
        $totalGuru = Guru::count();
        $jurnalHariIni = JurnalMengajar::whereDate('tanggal', $tanggal)->with(['kelas', 'mapel'])->get()->keyBy('id_guru');
        $izinHariIni = GuruIzin::whereDate('tanggal_mulai', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal)
            ->where('status_kepsek', '!=', 'rejected')
            ->get()
            ->keyBy('id_guru');

        $guruHadirCount = $jurnalHariIni->count();
        $guruIzinCount = $izinHariIni->count();
        $pendingApprovalCount = GuruIzin::where('status_kepsek', 'pending')->count();
        $disetujuiCount = GuruIzin::where('status_kepsek', 'approved')->count();
        $kehadiranPct = $totalGuru > 0 ? round(($guruHadirCount / $totalGuru) * 100, 1) : 0;

        // 3. Guru List for Attendance & KBM Table
        $guruListQuery = Guru::with(['mapel']);
        if (!empty($searchQuery)) {
            $guruListQuery->where(function($gq) use ($searchQuery) {
                $gq->where('nama_guru', 'LIKE', "%{$searchQuery}%")
                   ->orWhere('nip', 'LIKE', "%{$searchQuery}%")
                   ->orWhereHas('mapel', function($mq) use ($searchQuery) {
                       $mq->where('nama_mapel', 'LIKE', "%{$searchQuery}%");
                   });
            });
        }
        $guruList = $guruListQuery->orderBy('nama_guru')->get();

        return view('kepala_sekolah.kehadiran_guru', compact(
            'guruIzinList', 'guruList', 'jurnalHariIni', 'izinHariIni', 'tanggal',
            'searchQuery', 'statusFilter', 'kategoriFilter',
            'totalGuru', 'guruHadirCount', 'guruIzinCount', 'pendingApprovalCount',
            'disetujuiCount', 'kehadiranPct'
        ));
    }
CODE;

$content = str_replace($oldCode, $newCode, $content);
file_put_contents($controllerPath, $content);
echo "Updated KepalaSekolahController.php kehadiranGuru successfully!\n";
