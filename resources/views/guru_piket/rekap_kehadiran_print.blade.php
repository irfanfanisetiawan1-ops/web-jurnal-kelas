<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Rekap Kehadiran Guru & Siswa — SMKN 1 BOYOLANGU</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; padding: 25px 35px; color: #000; line-height: 1.4; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 8px; margin-bottom: 18px; }
        .header h2 { margin: 0; font-size: 17px; text-transform: uppercase; font-weight: bold; }
        .header h3 { margin: 3px 0; font-size: 15px; text-transform: uppercase; font-weight: bold; }
        .header p { margin: 0; font-size: 11px; }
        .title-doc { text-align: center; margin: 15px 0; font-size: 14px; text-transform: uppercase; font-weight: bold; text-decoration: underline; }
        .meta-table { width: 100%; border: none; margin-bottom: 15px; font-size: 12px; }
        .meta-table td { padding: 3px 0; border: none; }
        
        .stat-summary-boxes {
            display: flex;
            justify-content: space-between;
            margin-bottom: 18px;
            gap: 10px;
        }
        .stat-box {
            flex: 1;
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: center;
            font-size: 11.5px;
        }
        .stat-box strong { font-size: 14px; display: block; margin-top: 3px; }

        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        table.data-table th { background: #f2f2f2; text-align: center; font-weight: bold; }

        .footer-sign-container {
            margin-top: 35px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .footer-sign-box {
            width: 250px;
            text-align: center;
            font-size: 12px;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 8px 18px; background: #2b3957; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
            Cetak Dokumen Laporan
        </button>
    </div>

    <!-- Kop Surat Resmi -->
    <div class="header">
        <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
        <h2>DINAS PENDIDIKAN</h2>
        <h3>SMK NEGERI 1 BOYOLANGU</h3>
        <p>Jl. Ki Mangunsarkoro No. 1, Boyolangu, Kab. Tulungagung, Jawa Timur 66233 | Telp. (0355) 321746 | Email: smkn1boyolangu@yahoo.co.id</p>
    </div>

    <div class="title-doc">
        REKAPITULASI PRESENSI GURU & SESI KBM HARIAN PIKET
    </div>

    @php
        $cDate = \Carbon\Carbon::parse($tanggalFilter);
        $monthsMapIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $dateFormatted = $hariFilter . ', ' . $cDate->day . ' ' . $monthsMapIndo[$cDate->month] . ' ' . $cDate->year;
    @endphp

    <table class="meta-table">
        <tr>
            <td style="width: 18%;"><strong>Hari / Tanggal</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 45%;">{{ $dateFormatted }}</td>
            <td style="width: 15%;"><strong>Petugas Piket</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 18%;">{{ $petugasPiketNama }}</td>
        </tr>
        <tr>
            <td><strong>Semester / T.A.</strong></td>
            <td>:</td>
            <td>Ganjil (2026/2027)</td>
            <td><strong>Waktu Cetak</strong></td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB</td>
        </tr>
    </table>

    <!-- 4 Box Ringkasan Statistik -->
    <div class="stat-summary-boxes">
        <div class="stat-box">
            <span>Total Sesi KBM</span>
            <strong>{{ $stats['total'] }} Sesi</strong>
        </div>
        <div class="stat-box">
            <span>Guru Hadir</span>
            <strong>{{ $stats['hadir'] }} Sesi</strong>
        </div>
        <div class="stat-box">
            <span>Izin / Dinas</span>
            <strong>{{ $stats['izin'] }} Sesi</strong>
        </div>
        <div class="stat-box">
            <span>Tidak Hadir / Sakit</span>
            <strong>{{ $stats['tidakHadir'] }} Sesi</strong>
        </div>
        <div class="stat-box">
            <span>Digantikan</span>
            <strong>{{ $stats['digantikan'] }} Sesi</strong>
        </div>
    </div>

    <!-- Tabel Data Rekapitulasi Presensi Guru -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama Guru Pengampu</th>
                <th>Mata Pelajaran</th>
                <th style="width: 85px;">Kelas / Ruang</th>
                <th style="width: 90px;">Jam Mengajar</th>
                <th style="width: 80px;">Status</th>
                <th>Keterangan / Guru Pengganti</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kehadiranList as $idx => $row)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td>
                        <strong>{{ $row->guru_nama }}</strong>
                        @if($row->guru_nip && $row->guru_nip !== '-')
                            <br><small style="color: #444;">NIP. {{ $row->guru_nip }}</small>
                        @endif
                    </td>
                    <td>{{ $row->mapel_nama }}</td>
                    <td style="text-align: center;">{{ $row->kelas_nama }}<br><small>{{ $row->ruangan_nama }}</small></td>
                    <td style="text-align: center;">{{ $row->jam_ke }}<br><small>{{ $row->jam }}</small></td>
                    <td style="text-align: center; font-weight: bold;">{{ $row->status_teks }}</td>
                    <td>
                        @if($row->guru_pengganti_nama)
                            <strong>Digantikan: {{ $row->guru_pengganti_nama }}</strong>
                        @else
                            {{ $row->keterangan }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Ringkasan Ketidakhadiran Siswa -->
    <div style="margin-top: 22px; font-size: 12px;">
        <strong style="font-size: 13px; text-transform: uppercase;">REKAPITULASI KETIDAKHADIRAN SISWA</strong>
        <div style="margin-top: 4px; font-size: 11.5px;">
            &bull;&nbsp; Siswa Terlambat: <strong>{{ $siswaStats['telat'] }} Siswa</strong>
            &nbsp;&bull;&nbsp; Siswa Dispensasi: <strong>{{ $siswaStats['dispen'] }} Siswa</strong>
            &nbsp;&bull;&nbsp; Surat Izin Siswa: <strong>{{ $siswaStats['suratIzin'] }} Siswa</strong>
        </div>
    </div>

    @if(($siswaTelatList && $siswaTelatList->count() > 0) || ($siswaDispenList && $siswaDispenList->count() > 0) || ($siswaSuratIzinList && $siswaSuratIzinList->count() > 0))
        @if($siswaTelatList && $siswaTelatList->count() > 0)
            <div style="margin-top: 14px; font-weight: bold; font-size: 11.5px;">Daftar Siswa Terlambat:</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 30px;">No</th>
                        <th>Nama Siswa</th>
                        <th style="width: 90px;">Kelas</th>
                        <th style="width: 80px;">Jam Masuk</th>
                        <th>Alasan Terlambat</th>
                        <th>Tindakan / Sanksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswaTelatList as $sIdx => $st)
                        <tr>
                            <td style="text-align: center;">{{ $sIdx + 1 }}</td>
                            <td><strong>{{ $st->siswa->nama_siswa ?? 'Siswa' }}</strong></td>
                            <td style="text-align: center;">{{ $st->kelas->nama_kelas ?? ($st->siswa->kelas->nama_kelas ?? '-') }}</td>
                            <td style="text-align: center;">{{ $st->jam_masuk ?? '-' }}</td>
                            <td>{{ $st->alasan ?? '-' }}</td>
                            <td>{{ $st->tindakan ?? 'Diberi Izin Masuk' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if($siswaDispenList && $siswaDispenList->count() > 0)
            <div style="margin-top: 14px; font-weight: bold; font-size: 11.5px;">Daftar Siswa Dispensasi:</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 30px;">No</th>
                        <th>Nama Siswa</th>
                        <th style="width: 90px;">Kelas</th>
                        <th>Kegiatan Dispensasi</th>
                        <th style="width: 140px;">Waktu Dispensasi</th>
                        <th style="width: 80px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswaDispenList as $dIdx => $sd)
                        <tr>
                            <td style="text-align: center;">{{ $dIdx + 1 }}</td>
                            <td><strong>{{ $sd->siswa->nama_siswa ?? 'Siswa' }}</strong></td>
                            <td style="text-align: center;">{{ $sd->kelas->nama_kelas ?? ($sd->siswa->kelas->nama_kelas ?? '-') }}</td>
                            <td>{{ $sd->alasan ?? ($sd->tempat ?? '-') }}</td>
                            <td style="text-align: center;">{{ $sd->tanggal }} ({{ $sd->jam_keluar ?? '07:00' }} - {{ $sd->jam_kembali ?? 'Selesai' }})</td>
                            <td style="text-align: center;">{{ $sd->status_waka ?? 'Approved' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if($siswaSuratIzinList && $siswaSuratIzinList->count() > 0)
            <div style="margin-top: 14px; font-weight: bold; font-size: 11.5px;">Daftar Surat Izin Siswa:</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 30px;">No</th>
                        <th>Nama Siswa</th>
                        <th style="width: 90px;">Kelas</th>
                        <th style="width: 80px;">Kategori</th>
                        <th style="width: 140px;">Rentang Tanggal</th>
                        <th>Keterangan / Alasan</th>
                        <th style="width: 90px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswaSuratIzinList as $iIdx => $si)
                        <tr>
                            <td style="text-align: center;">{{ $iIdx + 1 }}</td>
                            <td><strong>{{ $si->siswa->nama_siswa ?? 'Siswa' }}</strong></td>
                            <td style="text-align: center;">{{ $si->kelas->nama_kelas ?? ($si->siswa->kelas->nama_kelas ?? '-') }}</td>
                            <td style="text-align: center;">{{ $si->kategori ?? 'Izin' }}</td>
                            <td style="text-align: center;">{{ $si->rentang_tanggal_text }}</td>
                            <td>{{ $si->keterangan ?? '-' }}</td>
                            <td style="text-align: center;">{{ $si->status ?? 'Terverifikasi' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

    <!-- Tanda Tangan Resmi -->
    <div class="footer-sign-container">
        <div class="footer-sign-box">
            Mengetahui,<br>
            Kepala SMK Negeri 1 Boyolangu<br><br><br><br><br>
            <strong><u>Trisno Wibowo, S.Pd., M.M.</u></strong><br>
            NIP. 197105151998021004
        </div>

        <div class="footer-sign-box">
            Boyolangu, {{ $cDate->day . ' ' . $monthsMapIndo[$cDate->month] . ' ' . $cDate->year }}<br>
            Petugas Guru Piket Harian,<br>
            @if($verifikasiPiket && $verifikasiPiket->signature_image)
                <div style="height: 70px; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ $verifikasiPiket->signature_image }}" alt="Tanda Tangan Piket" style="max-height: 65px; max-width: 140px;">
                </div>
            @else
                <br><br><br><br><br>
            @endif
            <strong><u>{{ $petugasPiketNama }}</u></strong><br>
            NIP. {{ $petugasPiketNip }}
        </div>
    </div>

</body>
</html>