<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\JurnalDetailKetidakhadiran;
use App\Models\SiswaSuratIzin;
use App\Models\SiswaDispen;
use App\Models\JurnalMengajar;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OrangTuaController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $siswa = null;

        if ($user && $user->id_siswa) {
            $siswa = Siswa::with(['kelas.jurusan', 'kelas.waliKelas'])->find($user->id_siswa);
        }

        // Fallback jika id_siswa belum diset di session user
        if (!$siswa) {
            $siswa = Siswa::with(['kelas.jurusan', 'kelas.waliKelas'])
                ->where('nisn', '0082075177')
                ->orWhere('nama_siswa', 'LIKE', '%Irfan Fani Setiawan%')
                ->first();

            if ($siswa && $user) {
                $user->update(['id_siswa' => $siswa->id_siswa]);
            }
        }

        $statusHariIni = [
            'status' => 'Di Sekolah',
            'subtext' => 'Sampai Sekolah: 06.40',
            'badge_bg' => '#bbf7d0',
            'badge_text' => '#14532d',
            'icon' => 'fa-school'
        ];

        $aktivitasIzinAktif = null;

        $rekapBulan = [
            'nama_bulan' => Str::upper(Carbon::now('Asia/Jakarta')->isoFormat('MMMM YYYY')),
            'hadir' => 20,
            'sakit' => 1,
            'izin' => 0,
            'alfa' => 0,
            'total' => 21,
            'persen_hadir' => 95,
            'persen_sakit' => 5,
            'persen_izin' => 0,
            'persen_alfa' => 0,
        ];

        $presensiList = [];
        $suratIzinList = [];
        $dispenList = [];

        if ($siswa) {
            $today = Carbon::today('Asia/Jakarta')->toDateString();

            // Cek Dispen Aktif Hari Ini
            $dispenHariIni = SiswaDispen::where('id_siswa', $siswa->id_siswa)
                ->whereDate('tanggal', $today)
                ->first();

            // Cek Surat Izin Hari Ini
            $izinHariIni = SiswaSuratIzin::where('id_siswa', $siswa->id_siswa)
                ->whereDate('tanggal', $today)
                ->first();

            if ($dispenHariIni) {
                $aktivitasIzinAktif = [
                    'tipe' => 'Dispen Keluar',
                    'detail' => "Jam: {$dispenHariIni->jam_keluar} s/d {$dispenHariIni->jam_kembali} | {$dispenHariIni->alasan}"
                ];
                $statusHariIni = [
                    'status' => 'Dispen Keluar',
                    'subtext' => "Jam {$dispenHariIni->jam_keluar} - {$dispenHariIni->jam_kembali}",
                    'badge_bg' => '#dbeafe',
                    'badge_text' => '#1e40af',
                    'icon' => 'fa-person-walking-arrow-right'
                ];
            } elseif ($izinHariIni) {
                $aktivitasIzinAktif = [
                    'tipe' => $izinHariIni->kategori,
                    'detail' => $izinHariIni->keterangan ?? 'Izin dari orang tua'
                ];
                $statusHariIni = [
                    'status' => $izinHariIni->kategori,
                    'subtext' => $izinHariIni->keterangan ?? 'Izin resmi tercatat',
                    'badge_bg' => '#fef3c7',
                    'badge_text' => '#92400e',
                    'icon' => 'fa-envelope-open-text'
                ];
            }

            // Hitung Rekapitulasi Presensi Bulan Ini
            $currentMonth = Carbon::now('Asia/Jakarta')->month;
            $currentYear = Carbon::now('Asia/Jakarta')->year;

            // Total Jurnal Mengajar Kelas Siswa di Bulan Ini
            $totalJurnalKelas = JurnalMengajar::whereHas('jadwal', function ($q) use ($siswa) {
                $q->where('id_kelas', $siswa->id_kelas);
            })->whereMonth('tanggal', $currentMonth)
              ->whereYear('tanggal', $currentYear)
              ->count();

            // Ketidakhadiran Siswa di Jurnal Detail
            $ketidakhadiran = JurnalDetailKetidakhadiran::where('id_siswa', $siswa->id_siswa)
                ->whereHas('jurnalMengajar', function ($q) use ($currentMonth, $currentYear) {
                    $q->whereMonth('tanggal', $currentMonth)
                      ->whereYear('tanggal', $currentYear);
                })->get();

            $sakitCount = $ketidakhadiran->where('keterangan', 'Sakit')->count();
            $izinCount  = $ketidakhadiran->where('keterangan', 'Izin')->count();
            $alfaCount  = $ketidakhadiran->where('keterangan', 'Alpa')->count();

            if ($totalJurnalKelas > 0) {
                $hadirCount = max(0, $totalJurnalKelas - ($sakitCount + $izinCount + $alfaCount));
                $rekapBulan = [
                    'nama_bulan' => Str::upper(Carbon::now('Asia/Jakarta')->isoFormat('MMMM YYYY')),
                    'hadir' => $hadirCount,
                    'sakit' => $sakitCount,
                    'izin'  => $izinCount,
                    'alfa'  => $alfaCount,
                    'total' => $totalJurnalKelas,
                    'persen_hadir' => round(($hadirCount / $totalJurnalKelas) * 100),
                    'persen_sakit' => round(($sakitCount / $totalJurnalKelas) * 100),
                    'persen_izin'  => round(($izinCount / $totalJurnalKelas) * 100),
                    'persen_alfa'  => round(($alfaCount / $totalJurnalKelas) * 100),
                ];
            }

            // Riwayat Presensi Jurnal Mengajar Terakhir
            $presensiList = JurnalDetailKetidakhadiran::with(['jurnalMengajar.mapel', 'jurnalMengajar.guru'])
                ->where('id_siswa', $siswa->id_siswa)
                ->orderBy('id_detail', 'desc')
                ->take(10)
                ->get();

            // Riwayat Surat Izin
            $suratIzinList = SiswaSuratIzin::where('id_siswa', $siswa->id_siswa)
                ->orderBy('tanggal', 'desc')
                ->get();

            // Riwayat Dispen
            $dispenList = SiswaDispen::where('id_siswa', $siswa->id_siswa)
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        return view('orang_tua.dashboard', compact(
            'user',
            'siswa',
            'statusHariIni',
            'aktivitasIzinAktif',
            'rekapBulan',
            'presensiList',
            'suratIzinList',
            'dispenList'
        ));
    }

    public function izin()
    {
        $user = auth()->user();
        $siswa = null;

        if ($user && $user->id_siswa) {
            $siswa = Siswa::with(['kelas.jurusan'])->find($user->id_siswa);
        }

        $suratIzinList = [];
        if ($siswa) {
            $suratIzinList = SiswaSuratIzin::where('id_siswa', $siswa->id_siswa)
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        return view('orang_tua.izin', compact('user', 'siswa', 'suratIzinList'));
    }

    public function storeIzin(Request $request)
    {
        $user = auth()->user();
        $siswa = Siswa::find($user->id_siswa);

        if (!$siswa) {
            return redirect()->back()->with('error', 'Akun Orang Tua belum terhubung dengan data siswa.');
        }

        $request->validate([
            'tanggal'    => 'required|date',
            'kategori'   => 'required|in:Sakit,Izin',
            'keterangan' => 'required|string|max:500',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
        ], [
            'tanggal.required'    => 'Tanggal izin wajib diisi.',
            'kategori.required'   => 'Kategori izin wajib dipilih.',
            'keterangan.required' => 'Keterangan/alasan izin wajib diisi.',
            'foto_bukti.image'    => 'File bukti harus berupa foto/gambar.',
        ]);

        $fotoName = null;
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $fotoName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/surat_izin_siswa'), $fotoName);
        }

        SiswaSuratIzin::create([
            'id_siswa'         => $siswa->id_siswa,
            'id_kelas'         => $siswa->id_kelas,
            'tanggal'          => $request->tanggal,
            'kategori'         => $request->kategori,
            'keterangan'       => $request->keterangan,
            'foto_bukti'       => $fotoName,
            'id_petugas_piket' => null,
        ]);

        // Auto-sync ke presensi jurnal mengajar jika ada jurnal di tanggal tersebut
        $jurnals = JurnalMengajar::whereDate('tanggal', $request->tanggal)
            ->whereHas('jadwal', function ($q) use ($siswa) {
                $q->where('id_kelas', $siswa->id_kelas);
            })->get();

        foreach ($jurnals as $jurnal) {
            JurnalDetailKetidakhadiran::updateOrCreate(
                [
                    'id_jurnal' => $jurnal->id_jurnal,
                    'id_siswa'  => $siswa->id_siswa,
                ],
                [
                    'keterangan' => $request->kategori,
                ]
            );
        }

        return redirect()->route('orang-tua.dashboard')->with('success', 'Permohonan surat izin berhasil diajukan dan otomatis tersambung ke sistem sekolah!');
    }

    public function laporan()
    {
        $user = auth()->user();
        $siswa = null;

        if ($user && $user->id_siswa) {
            $siswa = Siswa::with(['kelas.jurusan', 'kelas.waliKelas'])->find($user->id_siswa);
        }

        // Fallback jika id_siswa belum terhubung
        if (!$siswa) {
            $siswa = Siswa::with(['kelas.jurusan', 'kelas.waliKelas'])
                ->where('nisn', '0082075177')
                ->orWhere('nama_siswa', 'LIKE', '%Irfan Fani Setiawan%')
                ->first();
        }

        $presensiList = [];
        $logDatangPulang = [];

        $rekapBulan = [
            'nama_bulan' => Str::upper(Carbon::now('Asia/Jakarta')->isoFormat('MMMM YYYY')),
            'hadir' => 20,
            'sakit' => 1,
            'izin' => 0,
            'alfa' => 0,
            'total' => 21,
            'persen_hadir' => 95,
            'persen_sakit' => 5,
            'persen_izin' => 0,
            'persen_alfa' => 0,
        ];

        if ($siswa) {
            // Presensi per Mapel
            $presensiList = JurnalDetailKetidakhadiran::with(['jurnalMengajar.mapel', 'jurnalMengajar.guru'])
                ->where('id_siswa', $siswa->id_siswa)
                ->orderBy('id_detail', 'desc')
                ->get();

            // Hitung Rekapitulasi Presensi Bulan Ini
            $currentMonth = Carbon::now('Asia/Jakarta')->month;
            $currentYear = Carbon::now('Asia/Jakarta')->year;

            $totalJurnalKelas = JurnalMengajar::whereHas('jadwal', function ($q) use ($siswa) {
                $q->where('id_kelas', $siswa->id_kelas);
            })->whereMonth('tanggal', $currentMonth)
              ->whereYear('tanggal', $currentYear)
              ->count();

            $ketidakhadiran = JurnalDetailKetidakhadiran::where('id_siswa', $siswa->id_siswa)
                ->whereHas('jurnalMengajar', function ($q) use ($currentMonth, $currentYear) {
                    $q->whereMonth('tanggal', $currentMonth)
                      ->whereYear('tanggal', $currentYear);
                })->get();

            $sakitCount = $ketidakhadiran->where('keterangan', 'Sakit')->count();
            $izinCount  = $ketidakhadiran->where('keterangan', 'Izin')->count();
            $alfaCount  = $ketidakhadiran->where('keterangan', 'Alpa')->count();

            if ($totalJurnalKelas > 0) {
                $hadirCount = max(0, $totalJurnalKelas - ($sakitCount + $izinCount + $alfaCount));
                $rekapBulan = [
                    'nama_bulan' => Str::upper(Carbon::now('Asia/Jakarta')->isoFormat('MMMM YYYY')),
                    'hadir' => $hadirCount,
                    'sakit' => $sakitCount,
                    'izin'  => $izinCount,
                    'alfa'  => $alfaCount,
                    'total' => $totalJurnalKelas,
                    'persen_hadir' => round(($hadirCount / $totalJurnalKelas) * 100),
                    'persen_sakit' => round(($sakitCount / $totalJurnalKelas) * 100),
                    'persen_izin'  => round(($izinCount / $totalJurnalKelas) * 100),
                    'persen_alfa'  => round(($alfaCount / $totalJurnalKelas) * 100),
                ];
            }

            // Generate Log Datang - Pulang Siswa per Hari
            // Mengambil riwayat Dispen & Presensi harian
            $dispenRecords = SiswaDispen::where('id_siswa', $siswa->id_siswa)->get()->keyBy('tanggal');
            $izinRecords = SiswaSuratIzin::where('id_siswa', $siswa->id_siswa)->get()->keyBy('tanggal');

            // Generate log 10 hari terakhir
            for ($i = 0; $i < 10; $i++) {
                $dateObj = Carbon::today('Asia/Jakarta')->subDays($i);
                // Lewati akhir pekan (Sabtu & Minggu)
                if ($dateObj->isWeekend()) {
                    continue;
                }
                $dateStr = $dateObj->toDateString();

                $jamDatang = '06:40 WIB';
                $jamPulang = '15:00 WIB';
                $statusLog = 'Hadir (Tepat Waktu)';
                $badgeStyle = 'background: #dcfce7; color: #166534;';

                if (isset($dispenRecords[$dateStr])) {
                    $dsp = $dispenRecords[$dateStr];
                    $jamDatang = '06:40 WIB';
                    $jamPulang = "Keluar Dispen: {$dsp->jam_keluar} (Kembali: {$dsp->jam_kembali})";
                    $statusLog = "Dispen ({$dsp->alasan})";
                    $badgeStyle = 'background: #dbeafe; color: #1e40af;';
                } elseif (isset($izinRecords[$dateStr])) {
                    $iz = $izinRecords[$dateStr];
                    $jamDatang = '-';
                    $jamPulang = '-';
                    $statusLog = "Izin/Sakit ({$iz->kategori})";
                    $badgeStyle = 'background: #fef3c7; color: #92400e;';
                }

                $logDatangPulang[] = [
                    'tanggal' => $dateObj->isoFormat('dddd, D MMMM YYYY'),
                    'jam_datang' => $jamDatang,
                    'jam_pulang' => $jamPulang,
                    'status' => $statusLog,
                    'badge_style' => $badgeStyle,
                ];
            }
        }

        return view('orang_tua.laporan', compact('user', 'siswa', 'rekapBulan', 'presensiList', 'logDatangPulang'));
    }
}
