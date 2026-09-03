<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiswaDispen;
use App\Models\SiswaSuratIzin;
use App\Models\LaporSiswa;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\User;
use App\Models\JurnalPiket;
use Carbon\Carbon;

class SatpamController extends Controller
{
    public function dashboard(Request $request)
    {
        $today = Carbon::today()->toDateString();
        
        $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $now = Carbon::now('Asia/Jakarta');
        $formattedDate = $hariIndo[$now->dayOfWeek] . ', ' . $now->day . ' ' . $bulanIndo[$now->month] . ' ' . $now->year;

        // Approved data remains active on Satpam portal even if Guru Piket soft-deletes it from Piket list.
        $dispenList = SiswaDispen::withTrashed()
            ->with(['siswa', 'kelas', 'wakaUser', 'guruPiketUser'])
            ->whereDate('tanggal', $today)
            ->where(function($q) {
                $q->where('status_waka', 'approved')
                  ->orWhere('status_wali_kelas', 'approved');
            })
            ->where('status_satpam', '!=', 'ditolak')
            ->orderBy('updated_at', 'desc')
            ->get();

        $totalIzinKeluarHariIni = SiswaDispen::withTrashed()
            ->whereDate('tanggal', $today)
            ->where(function($q) {
                $q->where('status_waka', 'approved')
                  ->orWhere('status_wali_kelas', 'approved');
            })->count();

        $totalMenungguValidasi = SiswaDispen::withTrashed()
            ->whereDate('tanggal', $today)
            ->where(function($q) {
                $q->where('status_waka', 'approved')
                  ->orWhere('status_wali_kelas', 'approved');
            })
            ->where('status_satpam', 'belum_keluar')
            ->count();

        $totalSesiHariIni = $dispenList->count();

        return view('satpam.dashboard', compact(
            'dispenList',
            'today',
            'formattedDate',
            'totalIzinKeluarHariIni',
            'totalMenungguValidasi',
            'totalSesiHariIni'
        ));
    }

    public function validasi(Request $request)
    {
        $today = Carbon::today()->toDateString();
        
        $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $now = Carbon::now('Asia/Jakarta');
        $formattedDate = $hariIndo[$now->dayOfWeek] . ', ' . $now->day . ' ' . $bulanIndo[$now->month] . ' ' . $now->year;

        $query = SiswaDispen::withTrashed()
            ->with(['siswa', 'kelas', 'wakaUser', 'guruPiketUser'])
            ->whereDate('tanggal', $today)
            ->where(function($q) {
                $q->where('status_waka', 'approved')
                  ->orWhere('status_wali_kelas', 'approved');
            });

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function($sub) use ($q) {
                $sub->where('kode_dispen', 'LIKE', "%{$q}%")
                    ->orWhereHas('siswa', function($s) use ($q) {
                        $s->where('nama_siswa', 'LIKE', "%{$q}%")
                          ->orWhere('nisn', 'LIKE', "%{$q}%");
                    });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'belum_keluar') {
                $query->where('status_satpam', 'belum_keluar');
            } elseif ($request->status === 'dizinkan_keluar') {
                $query->where('status_satpam', 'dizinkan_keluar');
            } elseif ($request->status === 'sudah_kembali') {
                $query->where('status_satpam', 'sudah_kembali');
            } elseif ($request->status === 'ditolak') {
                $query->where('status_satpam', 'ditolak');
            }
        } else {
            $query->where('status_satpam', '!=', 'ditolak');
        }

        $totalMenungguValidasi = SiswaDispen::whereDate('tanggal', $today)
            ->where(function($q) {
                $q->where('status_waka', 'approved')
                  ->orWhere('status_wali_kelas', 'approved');
            })
            ->where('status_satpam', 'belum_keluar')
            ->count();

        $dispenList = $query->orderBy('updated_at', 'desc')->get();

        return view('satpam.validasi', compact('dispenList', 'today', 'formattedDate', 'totalMenungguValidasi'));
    }

    public function logAktivitas(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $now = Carbon::now('Asia/Jakarta');
        $formattedDate = $hariIndo[$now->dayOfWeek] . ', ' . $now->day . ' ' . $bulanIndo[$now->month] . ' ' . $now->year;

        $totalSesiHariIni = SiswaDispen::withTrashed()->whereDate('tanggal', $today)->count();

        $query = SiswaDispen::withTrashed()->with(['siswa', 'kelas', 'wakaUser', 'guruPiketUser']);

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function($sub) use ($q) {
                $sub->where('kode_dispen', 'LIKE', "%{$q}%")
                    ->orWhereHas('siswa', function($s) use ($q) {
                        $s->where('nama_siswa', 'LIKE', "%{$q}%")
                          ->orWhere('nisn', 'LIKE', "%{$q}%");
                    });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'selesai') {
                $query->whereIn('status_satpam', ['dizinkan_keluar', 'sudah_kembali']);
            } elseif ($request->status === 'ditolak') {
                $query->where(function($s) {
                    $s->where('status_satpam', 'ditolak')
                      ->orWhere('status_waka', 'rejected')
                      ->orWhere('status_wali_kelas', 'rejected');
                });
            } elseif ($request->status === 'pending') {
                $query->where('status_satpam', 'belum_keluar')
                      ->where(function($sub) {
                          $sub->where('status_waka', 'approved')
                              ->orWhere('status_wali_kelas', 'approved');
                      });
            } elseif ($request->status === 'pending_waka') {
                $query->where('status_satpam', 'belum_keluar')
                      ->where(function($sub) {
                          $sub->whereNull('status_waka')
                              ->orWhere('status_waka', 'pending');
                      });
            }
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('satpam.log_aktivitas', compact('logs', 'totalSesiHariIni', 'formattedDate', 'today'));
    }

    public function search(Request $request)
    {
        $query = trim($request->input('q'));
        
        $dispen = SiswaDispen::withTrashed()
            ->with(['siswa', 'kelas'])
            ->where(function($q) use ($query) {
                $q->where('kode_dispen', $query)
                  ->orWhereHas('siswa', function($s) use ($query) {
                      $s->where('nama_siswa', 'LIKE', "%{$query}%")
                        ->orWhere('nisn', $query);
                  });
            })
            ->whereDate('tanggal', Carbon::today())
            ->where(function($q) {
                $q->where('status_waka', 'approved')
                  ->orWhere('status_wali_kelas', 'approved');
            })
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$dispen) {
            return response()->json([
                'success' => false,
                'message' => 'Data dispen siswa tidak ditemukan atau belum disetujui Waka.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'id_siswa_dispen'      => $dispen->id_siswa_dispen,
                'kode_dispen'          => $dispen->kode_dispen,
                'nama_siswa'           => $dispen->siswa->nama_siswa ?? '-',
                'nisn'                 => $dispen->siswa->nisn ?? '-',
                'kelas'                => $dispen->kelas->nama_kelas ?? '-',
                'alasan'               => $dispen->alasan,
                'tanggal'              => Carbon::parse($dispen->tanggal)->format('d-m-Y'),
                'jam_keluar'           => $dispen->jam_keluar ?? '-',
                'jam_kembali'          => $dispen->jam_kembali ?? '-',
                'nama_waka'            => $dispen->nama_waka ?? ($dispen->wakaUser->name ?? '-'),
                'nip_waka'             => $dispen->nip_waka ?? '-',
                'waktu_approval_waka'  => $dispen->waktu_approval_waka ? Carbon::parse($dispen->waktu_approval_waka)->format('d-m-Y H:i') : '-',
                'status_wali_kelas'    => $dispen->status_waka ?? $dispen->status_wali_kelas,
                'status_satpam'        => $dispen->status_satpam,
                'waktu_scan_satpam'    => $dispen->waktu_scan_satpam ? Carbon::parse($dispen->waktu_scan_satpam)->format('d-m-Y H:i:s') : null,
                'foto_kartu_identitas' => $dispen->foto_kartu_identitas ? asset($dispen->foto_kartu_identitas) : null,
                'foto_surat_dispen'    => $dispen->foto_surat_dispen ? asset($dispen->foto_surat_dispen) : null,
                'boleh_keluar'         => ($dispen->status_waka === 'approved' || $dispen->status_wali_kelas === 'approved'),
                'barcode_status'       => $dispen->status_satpam === 'belum_keluar' ? 'aktif' : 'terpakai',
                'barcode_label'        => $dispen->status_satpam === 'belum_keluar' ? 'AKTIF (BELUM DIGUNAKAN)' : 'SUDAH TERPAKAI / KADALUARSA',
            ]
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_satpam' => 'required|in:dizinkan_keluar,sudah_kembali,ditolak',
            'catatan'       => 'nullable|string|max:255',
        ]);

        $dispen = SiswaDispen::withTrashed()->findOrFail($id);
        
        $isApproved = ($dispen->status_waka === 'approved' || $dispen->status_wali_kelas === 'approved');
        if (!$isApproved && $request->status_satpam !== 'ditolak') {
            return redirect()->back()->with('error', 'Gagal! Waka belum menyetujui izin dispen siswa ini.');
        }

        $dispen->status_satpam = $request->status_satpam;
        $dispen->waktu_scan_satpam = now();
        if ($request->filled('catatan')) {
            $dispen->catatan_satpam = $request->catatan;
        }
        $dispen->save();

        return redirect()->back()->with('success', 'Data dispensasi siswa berhasil divalidasi! Siswa diizinkan keluar dan barcode telah kadaluarsa (tidak dapat digunakan lagi).');
    }

    public function livePoll()
    {
        $today = Carbon::today()->toDateString();
        
        $approvedToday = SiswaDispen::withTrashed()
            ->with(['siswa', 'kelas'])
            ->whereDate('tanggal', $today)
            ->where(function($q) {
                $q->where('status_waka', 'approved')
                  ->orWhere('status_wali_kelas', 'approved');
            })
            ->where('status_satpam', '!=', 'ditolak')
            ->orderBy('updated_at', 'desc')
            ->get();

        $totalIzinKeluar = SiswaDispen::withTrashed()
            ->whereDate('tanggal', $today)
            ->where(function($q) {
                $q->where('status_waka', 'approved')
                  ->orWhere('status_wali_kelas', 'approved');
            })->count();

        $totalMenunggu = SiswaDispen::withTrashed()
            ->whereDate('tanggal', $today)
            ->where(function($q) {
                $q->where('status_waka', 'approved')
                  ->orWhere('status_wali_kelas', 'approved');
            })
            ->where('status_satpam', 'belum_keluar')
            ->count();

        return response()->json([
            'count'               => $approvedToday->count(),
            'total_izin_keluar'   => $totalIzinKeluar,
            'total_menunggu'      => $totalMenunggu,
            'data'                => $approvedToday,
        ]);
    }

    public function laporSiswa(Request $request)
    {
        $today = Carbon::today()->toDateString();
        
        $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $now = Carbon::now('Asia/Jakarta');
        $formattedDate = $hariIndo[$now->dayOfWeek] . ', ' . $now->day . ' ' . $bulanIndo[$now->month] . ' ' . $now->year;

        // Dispen siswa aktif hari ini (Prioritas utama)
        $dispenTodayList = SiswaDispen::withTrashed()
            ->with(['siswa.kelas'])
            ->whereDate('tanggal', $today)
            ->where(function($q) {
                $q->where('status_waka', 'approved')
                  ->orWhere('status_wali_kelas', 'approved');
            })
            ->where('status_satpam', '!=', 'ditolak')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Semua data siswa dari TU (untuk pencarian komprehensif)
        $allSiswaList = Siswa::with('kelas')
            ->orderBy('nama_siswa', 'asc')
            ->get();

        // Riwayat laporan yang telah dibuat oleh satpam
        $laporanList = LaporSiswa::with(['siswa', 'kelas', 'satpamUser', 'siswaDispen'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $selectedIdSiswa = $request->query('id_siswa');

        return view('satpam.lapor_siswa', compact(
            'dispenTodayList',
            'allSiswaList',
            'laporanList',
            'today',
            'formattedDate',
            'selectedIdSiswa'
        ));
    }

    public function getSiswaLaporDetails($id_siswa)
    {
        $siswa = Siswa::with('kelas')->find($id_siswa);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        $today = Carbon::today()->toDateString();

        // Detail Wali Kelas
        $waliKelasData = [
            'nama'      => 'Belum Diatur',
            'nip'       => '-',
            'no_hp'     => '-',
            'no_hp_wa'  => '',
            'title'     => 'Wali Kelas ' . ($siswa->kelas->nama_kelas ?? ''),
        ];

        if ($siswa->kelas && !empty($siswa->kelas->wali_kelas)) {
            $nipWali = trim($siswa->kelas->wali_kelas);
            $guruWali = Guru::where('nip', $nipWali)->first();
            $userWali = User::where('nip', $nipWali)->first();

            $namaWali = $guruWali->nama_guru ?? ($userWali->name ?? 'Wali Kelas ' . $siswa->kelas->nama_kelas);
            $noHpWali = $guruWali->no_hp ?? ($userWali->no_hp ?? '');

            $waliKelasData['nama']     = $namaWali;
            $waliKelasData['nip']      = $nipWali;
            $waliKelasData['no_hp']    = $noHpWali ?: '-';
            $waliKelasData['no_hp_wa'] = $this->formatWaNumber($noHpWali);
        }

        // Detail Guru Piket Hari Ini
        $guruPiketData = [
            'nama'      => 'Guru Piket Hari Ini',
            'nip'       => '-',
            'no_hp'     => '-',
            'no_hp_wa'  => '',
            'title'     => 'Guru Piket Hari Ini',
        ];

        // Cari petugas piket dari User role piket / guru_piket
        $piketUser = User::whereIn('role', ['piket', 'guru_piket'])->whereNull('deleted_at')->first();
        if (!$piketUser) {
            $jurnalPiketHariIni = JurnalPiket::whereDate('tanggal', $today)->with('guru')->first();
            if ($jurnalPiketHariIni && $jurnalPiketHariIni->guru) {
                $guruPiketData['nama']     = $jurnalPiketHariIni->guru->nama_guru;
                $guruPiketData['nip']      = $jurnalPiketHariIni->guru->nip ?? '-';
                $guruPiketData['no_hp']    = $jurnalPiketHariIni->guru->no_hp ?? '-';
                $guruPiketData['no_hp_wa'] = $this->formatWaNumber($jurnalPiketHariIni->guru->no_hp);
            }
        } else {
            $guruPiketData['nama']     = $piketUser->name;
            $guruPiketData['nip']      = $piketUser->nip ?? '-';
            $guruPiketData['no_hp']    = $piketUser->no_hp ?? '-';
            $guruPiketData['no_hp_wa'] = $this->formatWaNumber($piketUser->no_hp);
        }

        // Dispen aktif siswa hari ini
        $dispen = SiswaDispen::withTrashed()
            ->where('id_siswa', $id_siswa)
            ->whereDate('tanggal', $today)
            ->orderBy('created_at', 'desc')
            ->first();

        $dispenData = null;
        if ($dispen) {
            $dispenData = [
                'id_siswa_dispen' => $dispen->id_siswa_dispen,
                'kode_dispen'     => $dispen->kode_dispen,
                'jam_keluar'      => $dispen->jam_keluar ?? '08.00',
                'jam_kembali'     => $dispen->jam_kembali ?? '10.00',
                'alasan'          => $dispen->alasan ?? 'Izin Keluar',
                'status_satpam'   => $dispen->status_satpam,
            ];
        }

        return response()->json([
            'success'    => true,
            'siswa'      => [
                'id_siswa'   => $siswa->id_siswa,
                'nama_siswa' => $siswa->nama_siswa,
                'nisn'       => $siswa->nisn ?? '-',
                'id_kelas'   => $siswa->id_kelas,
                'nama_kelas' => $siswa->kelas->nama_kelas ?? '-',
            ],
            'wali_kelas' => $waliKelasData,
            'guru_piket' => $guruPiketData,
            'dispen'     => $dispenData,
        ]);
    }

    public function storeLaporSiswa(Request $request)
    {
        $request->validate([
            'id_siswa'       => 'required|exists:siswa,id_siswa',
            'jenis_kejadian' => 'required|string|max:100',
            'catatan'        => 'nullable|string|max:1000',
        ]);

        $siswa = Siswa::with('kelas')->findOrFail($request->id_siswa);
        $today = Carbon::today()->toDateString();

        $dispen = SiswaDispen::withTrashed()
            ->where('id_siswa', $siswa->id_siswa)
            ->whereDate('tanggal', $today)
            ->orderBy('created_at', 'desc')
            ->first();

        $isDraft = $request->boolean('is_draft');
        $statusReport = $isDraft ? 'draft' : 'terkirim';

        $lapor = LaporSiswa::create([
            'id_siswa'        => $siswa->id_siswa,
            'id_kelas'        => $siswa->id_kelas,
            'id_siswa_dispen' => $dispen ? $dispen->id_siswa_dispen : null,
            'id_satpam'       => auth()->id(),
            'jenis_kejadian'  => $request->jenis_kejadian,
            'catatan'         => $request->catatan,
            'send_wali_kelas' => $request->has('send_wali_kelas'),
            'send_guru_piket' => $request->has('send_guru_piket'),
            'status'          => $statusReport,
        ]);

        // Siapkan Data Penerima & URL WhatsApp
        $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $now = Carbon::now('Asia/Jakarta');
        $tglText = $hariIndo[$now->dayOfWeek] . ', ' . $now->day . ' ' . $bulanIndo[$now->month] . ' ' . $now->year;
        $pelaporName = auth()->user()->name ?? 'Satpam Sekolah';

        $jamIzinText = '-';
        if ($dispen && $dispen->jam_keluar) {
            $jamIzinText = $dispen->jam_keluar . ($dispen->jam_kembali ? ' - ' . $dispen->jam_kembali : '');
        }

        $waMessage = "🚨 *LAPORAN KEJADIAN / KETERLAMBATAN SISWA*\n"
            . "*PORTAL SATPAM SMEA*\n\n"
            . "Halo Bapak/Ibu, berikut laporan dari petugas Satpam sekolah:\n\n"
            . "👤 *Nama Siswa:* " . $siswa->nama_siswa . "\n"
            . "🏫 *Kelas:* " . ($siswa->kelas->nama_kelas ?? '-') . "\n"
            . "⚠️ *Jenis Kejadian:* " . $request->jenis_kejadian . "\n"
            . "⏰ *Waktu Izin:* " . $jamIzinText . "\n"
            . "📝 *Catatan Kejadian:* " . ($request->catatan ?: '-') . "\n\n"
            . "📅 *Tanggal:* " . $tglText . "\n"
            . "👮 *Pelapor:* " . $pelaporName . " (Satpam)\n\n"
            . "Mohon dapat ditindaklanjuti. Terima kasih.";

        $waUrlEncoded = rawurlencode($waMessage);

        // Ambil Kontak WA Wali Kelas
        $waWaliUrl = null;
        $noWaliWa = '';
        if ($siswa->kelas && !empty($siswa->kelas->wali_kelas)) {
            $nipWali = trim($siswa->kelas->wali_kelas);
            $guruWali = Guru::where('nip', $nipWali)->first();
            $userWali = User::where('nip', $nipWali)->first();
            $noWali = $guruWali->no_hp ?? ($userWali->no_hp ?? '');
            $noWaliWa = $this->formatWaNumber($noWali);
            if (!empty($noWaliWa)) {
                $waWaliUrl = "https://wa.me/{$noWaliWa}?text={$waUrlEncoded}";
            }
        }

        // Ambil Kontak WA Guru Piket
        $waPiketUrl = null;
        $noPiketWa = '';
        $piketUser = User::whereIn('role', ['piket', 'guru_piket'])->whereNull('deleted_at')->first();
        if ($piketUser && !empty($piketUser->no_hp)) {
            $noPiketWa = $this->formatWaNumber($piketUser->no_hp);
        } else {
            $jPiket = JurnalPiket::whereDate('tanggal', $today)->with('guru')->first();
            if ($jPiket && $jPiket->guru && !empty($jPiket->guru->no_hp)) {
                $noPiketWa = $this->formatWaNumber($jPiket->guru->no_hp);
            }
        }
        if (!empty($noPiketWa)) {
            $waPiketUrl = "https://wa.me/{$noPiketWa}?text={$waUrlEncoded}";
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'message'      => $isDraft ? 'Laporan berhasil disimpan sebagai draft!' : 'Laporan berhasil dibuat!',
                'wa_wali_url'  => $request->has('send_wali_kelas') ? $waWaliUrl : null,
                'wa_piket_url' => $request->has('send_guru_piket') ? $waPiketUrl : null,
                'wa_message'   => $waMessage,
            ]);
        }

        return redirect()->route('satpam.lapor-siswa')->with([
            'success'      => $isDraft ? 'Laporan berhasil disimpan sebagai draft!' : 'Laporan kejadian siswa berhasil dibuat & disimpan!',
            'wa_wali_url'  => $request->has('send_wali_kelas') ? $waWaliUrl : null,
            'wa_piket_url' => $request->has('send_guru_piket') ? $waPiketUrl : null,
            'wa_message'   => $waMessage,
        ]);
    }

    public function destroyLaporSiswa($id)
    {
        $lapor = LaporSiswa::findOrFail($id);
        $lapor->delete();

        return redirect()->back()->with('success', 'Riwayat laporan siswa berhasil dihapus.');
    }

    private function formatWaNumber($phone)
    {
        if (empty($phone)) return '';
        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (empty($clean)) return '';
        if (str_starts_with($clean, '0')) {
            return '62' . substr($clean, 1);
        }
        if (str_starts_with($clean, '62')) {
            return $clean;
        }
        return '62' . $clean;
    }
}


