<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Siswa Izin & Dispensasi — SMKN 1 Boyolangu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 12mm 15mm 12mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 10px;
            font-size: 10.5pt;
            line-height: 1.3;
        }

        .no-print-bar {
            background: #1e293b;
            color: #fff;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-radius: 8px;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        .btn-print {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-close {
            background: #64748b;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px double #000;
            margin-bottom: 18px;
            padding-bottom: 8px;
        }

        .kop-table td {
            vertical-align: middle;
            text-align: center;
        }

        .kop-logo {
            width: 80px;
            text-align: center;
        }

        .kop-text h4 {
            margin: 0;
            font-size: 13pt;
            font-weight: normal;
            letter-spacing: 0.5px;
        }

        .kop-text h3 {
            margin: 2px 0;
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .kop-text h2 {
            margin: 2px 0;
            font-size: 16pt;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .kop-text p {
            margin: 2px 0 0 0;
            font-size: 8.5pt;
            font-style: italic;
        }

        /* Judul Dokumen */
        .doc-title {
            text-align: center;
            margin: 15px 0 12px 0;
        }

        .doc-title h3 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .doc-title p {
            margin: 4px 0 0 0;
            font-size: 10.5pt;
        }

        /* Meta Info Grid */
        .meta-box {
            width: 100%;
            margin-bottom: 16px;
            font-size: 10pt;
            border-collapse: collapse;
        }

        .meta-box td {
            padding: 3px 0;
            vertical-align: top;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
            font-size: 9.5pt;
        }

        .data-table th, .data-table td {
            border: 1px solid #333;
            padding: 6px 8px;
            vertical-align: top;
        }

        .data-table th {
            background-color: #f1f5f9 !important;
            font-weight: bold;
            text-align: center;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .section-header {
            font-size: 11pt;
            font-weight: bold;
            margin: 18px 0 8px 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Tanda Tangan */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            page-break-inside: avoid;
            font-size: 10.5pt;
        }

        .ttd-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
        }

        @media print {
            .no-print-bar {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Non-print action bar -->
    <div class="no-print-bar">
        <div>
            <strong><i class="fa-solid fa-print"></i> Mode Cetak Dokumen Rekap Siswa Izin & Dispensasi</strong>
            <div style="font-size: 11.5px; opacity: 0.8; margin-top: 2px;">
                Dokumen Resmi Pemantauan Kepala Sekolah — Format Siap Cetak A4 / PDF
            </div>
        </div>
        <div style="display: flex; gap: 8px;">
            <button onclick="window.print()" class="btn-print"><i class="fa-solid fa-print"></i> Cetak / Simpan PDF</button>
            <button onclick="window.close()" class="btn-close"><i class="fa-solid fa-times"></i> Tutup</button>
        </div>
    </div>

    <!-- Kop Surat Resmi SMKN 1 Boyolangu -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo" style="width: 15%;">
                <img src="{{ asset('images/logo-jatim.png') }}" alt="Logo Jatim" style="max-height: 75px;" onerror="this.style.display='none'">
            </td>
            <td class="kop-text" style="width: 70%;">
                <h4>PEMERINTAH PROVINSI JAWA TIMUR</h4>
                <h3>DINAS PENDIDIKAN</h3>
                <h2>SEKOLAH MENENGAH KEJURUAN NEGERI 1 BOYOLANGU</h2>
                <p>Jl. Ki Mangunsarkoro Gg. SMKN 1 Telp. (0355) 323048 Fax. (0355) 323048 Tulungagung 66233<br>
                Website: www.smkn1boyolangu.sch.id | Email: smkn1boyolangu@yahoo.com</p>
            </td>
            <td class="kop-logo" style="width: 15%;">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMEA" style="max-height: 75px;" onerror="this.style.display='none'">
            </td>
        </tr>
    </table>

    <!-- Judul Dokumen -->
    <div class="doc-title">
        <h3>REKAPITULASI DISPENSASI & IZIN SISWA</h3>
        <p>
            Periode: <strong>{{ \Carbon\Carbon::parse($filterTanggal)->translatedFormat('d F Y') }}</strong>
        </p>
    </div>

    <!-- Meta Info Ringkas -->
    <table class="meta-box">
        <tr>
            <td style="width: 20%;"><strong>Tanggal Cetak</strong></td>
            <td style="width: 30%;">: {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y - H:i') }} WIB</td>
            <td style="width: 25%;"><strong>Total Dispensasi</strong></td>
            <td style="width: 25%;">: {{ count($dispenSiswa) }} Siswa</td>
        </tr>
        <tr>
            <td><strong>Penanggung Jawab</strong></td>
            <td>: Kepala Sekolah & Guru Piket</td>
            <td><strong>Total Surat Izin</strong></td>
            <td>: {{ count($suratIzinSiswa) }} Siswa</td>
        </tr>
    </table>

    @if($printMode === 'all' || $printMode === 'dispen')
    <!-- Bagian 1: Dispensasi Siswa Keluar Gerbang -->
    <div class="section-header">
        I. DAFTAR SISWA DISPENSASI KELUAR GERBANG SEKOLAH
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 22%;">Nama Siswa / NISN</th>
                <th style="width: 10%;">Kelas</th>
                <th style="width: 14%;">Jam Keluar / Rencana</th>
                <th style="width: 26%;">Keperluan & Tempat Tujuan</th>
                <th style="width: 12%;">Petugas Piket</th>
                <th style="width: 12%;">Status Satpam</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dispenSiswa as $idx => $d)
                @php
                    $namaSiswa = $d->siswa->nama_siswa ?? 'Siswa';
                    $nisn = $d->siswa->nisn ?? '-';
                    $namaKelas = $d->kelas->nama_kelas ?? ($d->siswa->kelas->nama_kelas ?? '-');
                    $jamKeluar = $d->jam_keluar ? $d->jam_keluar . ' WIB' : ($d->created_at ? $d->created_at->format('H:i') . ' WIB' : '-');
                    $jamKembali = $d->jam_kembali ? $d->jam_kembali . ' WIB' : '-';
                    
                    $stSatpam = match($d->status_satpam) {
                        'dizinkan_keluar' => 'Dizinkan Keluar',
                        'sudah_kembali'   => 'Sudah Kembali',
                        'ditolak'         => 'Ditolak Satpam',
                        default           => 'Belum Keluar'
                    };
                    $piketName = $d->nama_guru_piket ?? ($d->guruPiketUser->nama ?? '-');
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td>
                        <strong>{{ $namaSiswa }}</strong><br>
                        <span style="font-size: 8pt; color: #555;">NISN: {{ $nisn }}</span>
                    </td>
                    <td style="text-align: center;"><strong>{{ $namaKelas }}</strong></td>
                    <td style="font-size: 8.5pt;">
                        Keluar: {{ $jamKeluar }}<br>
                        Kembali: {{ $jamKembali }}
                    </td>
                    <td>
                        {{ $d->alasan ?? '-' }}
                        @if($d->tempat)
                            <div style="font-size: 8pt; color: #444; margin-top: 2px;">📍 Tujuan: {{ $d->tempat }}</div>
                        @endif
                    </td>
                    <td style="font-size: 8.5pt;">{{ $piketName }}</td>
                    <td style="text-align: center; font-size: 8.5pt;">
                        <strong>{{ $stSatpam }}</strong>
                        @if($d->waktu_scan_satpam)
                            <div style="font-size: 7.5pt; color: #666;">{{ $d->waktu_scan_satpam }}</div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; font-style: italic; color: #666; padding: 12px;">
                        Tidak ada data permohonan dispensasi keluar sekolah untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @endif

    @if($printMode === 'all' || $printMode === 'surat_izin')
    <!-- Bagian 2: Surat Izin Tidak Masuk -->
    <div class="section-header">
        {{ ($printMode === 'all') ? 'II.' : 'I.' }} DAFTAR SISWA IZIN TIDAK MASUK SEKOLAH (SAKIT / IZIN)
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 24%;">Nama Siswa / NISN</th>
                <th style="width: 10%;">Kelas</th>
                <th style="width: 14%;">Jenis Keterangan</th>
                <th style="width: 18%;">Rentang Tanggal</th>
                <th style="width: 30%;">Alasan / Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratIzinSiswa as $idx => $s)
                @php
                    $namaSiswa = $s->siswa->nama_siswa ?? 'Siswa';
                    $nisn = $s->siswa->nisn ?? '-';
                    $namaKelas = $s->kelas->nama_kelas ?? ($s->siswa->kelas->nama_kelas ?? '-');
                    $kategori = strtoupper($s->kategori ?? 'IZIN');
                    $startDate = \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y');
                    $endDate = $s->tanggal_selesai ? \Carbon\Carbon::parse($s->tanggal_selesai)->format('d/m/Y') : $startDate;
                    $durasi = ($s->durasi_hari > 0) ? $s->durasi_hari : 1;
                    $dateText = ($startDate === $endDate) ? "$startDate ($durasi Hari)" : "$startDate s/d $endDate ($durasi Hari)";
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td>
                        <strong>{{ $namaSiswa }}</strong><br>
                        <span style="font-size: 8pt; color: #555;">NISN: {{ $nisn }}</span>
                    </td>
                    <td style="text-align: center;"><strong>{{ $namaKelas }}</strong></td>
                    <td style="text-align: center;">
                        <strong>{{ $kategori }}</strong>
                    </td>
                    <td style="font-size: 8.5pt;">{{ $dateText }}</td>
                    <td>{{ $s->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; font-style: italic; color: #666; padding: 12px;">
                        Tidak ada data surat izin tidak masuk sekolah untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @endif

    <!-- Lembar Tanda Tangan -->
    <table class="ttd-table">
        <tr>
            <td>
                Mengetahui,<br>
                Koordinator Guru Piket Harian<br><br><br><br><br>
                <strong><u>......................................................</u></strong><br>
                NIP. .................................................
            </td>
            <td>
                Tulungagung, {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}<br>
                Kepala SMKN 1 Boyolangu<br><br><br><br><br>
                <strong><u>ARIK EKO LESTARI, S.Pd</u></strong><br>
                NIP. 19780512 200501 1 008
            </td>
        </tr>
    </table>

</body>
</html>