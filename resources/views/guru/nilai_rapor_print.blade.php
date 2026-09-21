<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ledger Nilai Siswa — {{ $kelas->nama_kelas ?? 'Kelas' }} — {{ $mapel->nama_mapel ?? 'Mapel' }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            padding: 25px 35px;
            color: #000;
            background: #fff;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2.5px double #000;
            padding-bottom: 8px;
            margin-bottom: 18px;
        }
        .header h2 { margin: 0; font-size: 16px; font-weight: bold; text-transform: uppercase; }
        .header h3 { margin: 3px 0; font-size: 15px; font-weight: bold; text-transform: uppercase; }
        .header p { margin: 0; font-size: 11px; }
        
        .doc-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 14px;
            letter-spacing: 0.5px;
        }
        
        .meta-table {
            width: 100%;
            margin-bottom: 14px;
            font-size: 12px;
        }
        .meta-table td {
            padding: 2px 4px;
            vertical-align: top;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 11px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #000;
            padding: 6px 5px;
        }
        table.data-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        
        .summary-box {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            font-size: 11.5px;
        }
        .summary-table {
            border-collapse: collapse;
            width: 45%;
        }
        .summary-table td {
            padding: 3px 6px;
            border: 1px solid #999;
        }
        
        .signatures {
            margin-top: 30px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            page-break-inside: avoid;
        }
        .sign-col {
            width: 30%;
            text-align: center;
        }
        
        @media print {
            .no-print { display: none !important; }
            body { padding: 15px; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 15px; display: flex; gap: 10px;">
        <button onclick="window.print()" style="padding: 8px 18px; background: #2563eb; color: #fff; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
            🖨️ Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" style="padding: 8px 18px; background: #64748b; color: #fff; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
            ✖ Tutup
        </button>
    </div>

    <!-- Kop Sekolah -->
    <div class="header">
        <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
        <h2>DINAS PENDIDIKAN</h2>
        <h3>SMK NEGERI 1 BOYOLANGU</h3>
        <p>Jl. Ki Mangunsarkoro No. 1, Boyolangu, Kabupaten Tulungagung | Telp. (0355) 321746 | Email: info@smkn1boyolangu.sch.id</p>
    </div>

    <div class="doc-title">LEDGER NILAI HASIL CAPAIAN BELAJAR SISWA</div>

    <!-- Metadata Informasi -->
    <table class="meta-table">
        <tr>
            <td style="width: 18%;"><strong>Kelas</strong></td>
            <td style="width: 32%;">: {{ $kelas->nama_kelas ?? '-' }}</td>
            <td style="width: 18%;"><strong>Semester</strong></td>
            <td style="width: 32%;">: {{ $semester == '1' ? '1 (Ganjil)' : '2 (Genap)' }}</td>
        </tr>
        <tr>
            <td><strong>Mata Pelajaran</strong></td>
            <td>: {{ $mapel->nama_mapel ?? '-' }}</td>
            <td><strong>Tahun Ajaran</strong></td>
            <td>: {{ $tahunAjaran ?? '2026/2027' }}</td>
        </tr>
        <tr>
            <td><strong>Guru Pengampu</strong></td>
            <td>: {{ $guru->nama_guru ?? (Auth::user()->name ?? '-') }}</td>
            <td><strong>Standar KKM</strong></td>
            <td>: <strong>{{ $kkm ?? 75 }}</strong></td>
        </tr>
    </table>

    <!-- Tabel Nilai -->
    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 30px;">No</th>
                <th rowspan="2" style="width: 75px;">NIS/NISN</th>
                <th rowspan="2">Nama Siswa</th>
                <th colspan="4">Komponen Nilai</th>
                <th rowspan="2" style="width: 55px;">Nilai Akhir</th>
                <th rowspan="2" style="width: 40px;">Predikat</th>
                <th rowspan="2" style="width: 65px;">Status</th>
                <th rowspan="2">Catatan Guru</th>
            </tr>
            <tr>
                <th style="width: 45px;">Tugas<br>(20%)</th>
                <th style="width: 45px;">UH<br>(20%)</th>
                <th style="width: 45px;">UTS<br>(30%)</th>
                <th style="width: 45px;">UAS<br>(30%)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totNA = 0;
                $countTuntas = 0;
                $countBelum = 0;
                $totalSiswa = count($siswas);
            @endphp
            @forelse($siswas as $idx => $s)
                @php
                    $val = $existingNilai->get($s->id_siswa);
                    $nTugas = $val ? floatval($val->nilai_tugas) : 0;
                    $nHarian = $val ? floatval($val->nilai_harian) : 0;
                    $nUts = $val ? floatval($val->nilai_uts) : 0;
                    $nUas = $val ? floatval($val->nilai_uas) : 0;
                    $nAkhir = $val ? floatval($val->nilai_akhir) : 0;
                    $predikat = $val ? $val->predikat : '-';
                    $catatan = $val ? $val->catatan : '-';

                    if ($nAkhir >= $kkm && $nAkhir > 0) {
                        $countTuntas++;
                        $statusText = 'TUNTAS';
                    } elseif ($nAkhir > 0) {
                        $countBelum++;
                        $statusText = 'BELUM';
                    } else {
                        $statusText = '-';
                    }
                    $totNA += $nAkhir;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td style="text-align: center;">{{ $s->nis ?? $s->nisn ?? '-' }}</td>
                    <td><strong>{{ $s->nama_siswa }}</strong></td>
                    <td style="text-align: center;">{{ $nTugas > 0 ? $nTugas : '-' }}</td>
                    <td style="text-align: center;">{{ $nHarian > 0 ? $nHarian : '-' }}</td>
                    <td style="text-align: center;">{{ $nUts > 0 ? $nUts : '-' }}</td>
                    <td style="text-align: center;">{{ $nUas > 0 ? $nUas : '-' }}</td>
                    <td style="text-align: center; font-weight: bold; background: #fafafa;">{{ $nAkhir > 0 ? $nAkhir : '-' }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $predikat }}</td>
                    <td style="text-align: center; font-weight: bold; color: {{ $statusText == 'TUNTAS' ? '#15803d' : ($statusText == 'BELUM' ? '#b91c1c' : '#555') }};">
                        {{ $statusText }}
                    </td>
                    <td><small>{{ $catatan ?: '-' }}</small></td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center; padding: 15px;">Tidak ada data siswa ditemukan untuk kelas ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Ringkasan Statistik Bawah -->
    @php
        $avgClass = $totalSiswa > 0 ? round($totNA / $totalSiswa, 1) : 0;
        $persenTuntas = $totalSiswa > 0 ? round(($countTuntas / $totalSiswa) * 100, 1) : 0;
    @endphp
    <div style="margin-top: 15px; font-size: 11.5px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 50%; vertical-align: top; border: none; padding: 0;">
                    <table class="summary-table">
                        <tr style="background: #f8f9fa;">
                            <td><strong>Total Siswa</strong></td>
                            <td style="text-align: center;"><strong>{{ $totalSiswa }} Siswa</strong></td>
                        </tr>
                        <tr>
                            <td>Rata-rata Nilai Akhir Kelas</td>
                            <td style="text-align: center;">{{ $avgClass }}</td>
                        </tr>
                        <tr>
                            <td>Siswa Tuntas (≥ KKM {{ $kkm }})</td>
                            <td style="text-align: center;">{{ $countTuntas }} Siswa ({{ $persenTuntas }}%)</td>
                        </tr>
                        <tr>
                            <td>Siswa Belum Tuntas (< KKM)</td>
                            <td style="text-align: center;">{{ $countBelum }} Siswa</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top; border: none; padding: 0 0 0 20px;">
                    <div style="border: 1px solid #ccc; padding: 8px; font-size: 11px; background: #fafafa;">
                        <strong>Keterangan Skala Nilai:</strong><br>
                        • Predikat A (Sangat Baik) : 88 - 100<br>
                        • Predikat B (Baik) : 78 - 87<br>
                        • Predikat C (Cukup) : 68 - 77<br>
                        • Predikat D (Perlu Bimbingan) : &lt; 68
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Tanda Tangan -->
    <div class="signatures">
        <div class="sign-col">
            Mengetahui,<br>
            Wali Kelas {{ $kelas->nama_kelas ?? '' }}<br><br><br><br>
            <strong><u>{{ $waliKelas->nama_guru ?? '....................................' }}</u></strong><br>
            NIP. {{ $waliKelas->nip ?? '....................................' }}
        </div>

        <div class="sign-col">
            Mengetahui,<br>
            Kepala Sekolah<br><br><br><br>
            <strong><u>Drs. Suyitno, M.Pd.</u></strong><br>
            NIP. 196805121994121002
        </div>

        <div class="sign-col">
            Boyolangu, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            Guru Mata Pelajaran,<br><br><br><br>
            <strong><u>{{ $guru->nama_guru ?? (Auth::user()->name ?? '....................................') }}</u></strong><br>
            NIP. {{ $guru->nip ?? (Auth::user()->nip ?? '....................................') }}
        </div>
    </div>

</body>
</html>