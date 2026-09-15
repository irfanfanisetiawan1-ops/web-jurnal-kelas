<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Eksekutif Kehadiran Guru & KBM — SMKN 1 Boyolangu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 landscape;
            margin: 14mm 10mm 14mm 10mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 10px;
            font-size: 10.5pt;
            line-height: 1.25;
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
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 14px;
            position: relative;
        }

        .kop-logo {
            position: absolute;
            left: 10px;
            top: 5px;
            width: 65px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            width: 100%;
        }

        .kop-text h3 { margin: 0; font-size: 12pt; font-weight: normal; }
        .kop-text h2 { margin: 2px 0; font-size: 15pt; font-weight: bold; }
        .kop-text p { margin: 1px 0; font-size: 9pt; font-family: Arial, sans-serif; }

        .doc-title {
            text-align: center;
            margin-bottom: 14px;
        }

        .doc-title h3 {
            margin: 0;
            font-size: 13pt;
            text-decoration: underline;
            text-transform: uppercase;
        }

        /* KPI Box Print */
        .kpi-print-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 16px;
            font-family: Arial, sans-serif;
        }

        .kpi-print-box {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: center;
            background: #f8fafc;
        }

        .kpi-print-box .val {
            font-size: 14pt;
            font-weight: bold;
            margin-top: 2px;
        }

        .kpi-print-box .lbl {
            font-size: 8.5pt;
            text-transform: uppercase;
            font-weight: bold;
            color: #334155;
        }

        /* Tables */
        .rekap-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-bottom: 16px;
        }

        .rekap-table th, .rekap-table td {
            border: 1px solid #000;
            padding: 5px 6px;
            vertical-align: middle;
        }

        .rekap-table th {
            background-color: #f1f5f9;
            text-align: center;
            font-weight: bold;
        }

        .text-center { text-align: center; }

        .signature-container {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
            page-break-inside: avoid;
            font-size: 10pt;
        }

        .signature-box {
            width: 280px;
            text-align: center;
        }

        .signature-space {
            height: 65px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 4px;
        }

        @media print {
            .no-print-bar { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <div>
            <strong><i class="fa-solid fa-print"></i> Mode Cetak Laporan Eksekutif Kehadiran Guru & KBM</strong>
            <span style="opacity: 0.8; margin-left: 10px;">Periode: {{ $bulanFilter ? "Bulan {$bulanFilter}" : "Semester Ganjil" }} Tahun {{ $tahunFilter }}</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="btn-print"><i class="fa-solid fa-print"></i> Cetak / Simpan PDF</button>
            <button onclick="window.close()" class="btn-close">Tutup</button>
        </div>
    </div>

    <!-- Kop Surat Resmi -->
    <div class="kop-surat">
        <img src="{{ asset('assets/images/logo_smk.png') }}" alt="Logo SMK" class="kop-logo" onerror="this.style.display='none'">
        <div class="kop-text">
            <h3>PEMERINTAH PROVINSI JAWA TIMUR</h3>
            <h3>DINAS PENDIDIKAN</h3>
            <h2>SEKOLAH MENENGAH KEJURUAN NEGERI 1 BOYOLANGU</h2>
            <p>Jalan Ki Mangunsarkoro Gg. VI/3 Tulungagung 66233 | Telp. (0355) 321854</p>
            <p>Website: www.smkn1boyolangu.sch.id | Email: smkn1boyolangu@yahoo.co.id</p>
        </div>
    </div>

    <div class="doc-title">
        <h3>LAPORAN EKSEKUTIF KEHADIRAN GURU & EVALUASI KBM</h3>
        <div style="font-size: 9.5pt; font-family: Arial, sans-serif; margin-top: 2px;">
            Tahun Ajaran 2026/2027 — Semester Ganjil &nbsp;|&nbsp; Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB
        </div>
    </div>

    <!-- KPI Metrics Box -->
    <div class="kpi-print-grid">
        <div class="kpi-print-box">
            <div class="lbl">Tingkat Kehadiran Guru</div>
            <div class="val">{{ $kehadiranGuruPct }}%</div>
        </div>
        <div class="kpi-print-box">
            <div class="lbl">Realisasi Sesi KBM</div>
            <div class="val">{{ $totalSesiJurnal }} Sesi</div>
        </div>
        <div class="kpi-print-box">
            <div class="lbl">Sesi Hadir Terlaksana</div>
            <div class="val">{{ $sesiHadir }} Sesi</div>
        </div>
        <div class="kpi-print-box">
            <div class="lbl">Total Guru Aktif</div>
            <div class="val">{{ $totalGuruCount }} Guru</div>
        </div>
    </div>

    <div style="font-size: 10.5pt; font-weight: bold; margin-bottom: 6px; text-transform: uppercase;">
        I. Rekapitulasi Kehadiran & Kinerja Guru Mengajar
    </div>

    <table class="rekap-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>Nama Guru</th>
                <th style="width: 130px;">NIP</th>
                <th>Mata Pelajaran</th>
                <th style="width: 70px;">Total Sesi</th>
                <th style="width: 55px;">Hadir</th>
                <th style="width: 55px;">Izin</th>
                <th style="width: 70px;">Digantikan</th>
                <th style="width: 110px;">Status Evaluasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapGuruList as $idx => $rg)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td><strong>{{ $rg->nama_guru }}</strong></td>
                <td class="text-center">{{ $rg->nip }}</td>
                <td>{{ $rg->nama_mapel }}</td>
                <td class="text-center">{{ $rg->total_sesi }} Sesi</td>
                <td class="text-center">{{ $rg->hadir }}</td>
                <td class="text-center">{{ $rg->izin }}</td>
                <td class="text-center">{{ $rg->digantikan }}</td>
                <td class="text-center"><strong>{{ $rg->evaluasi }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 14px;">Tidak ada data guru yang tercatat pada filter ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="font-size: 10.5pt; font-weight: bold; margin-bottom: 6px; text-transform: uppercase;">
        II. Rekapitulasi Keterlaksanaan KBM per Rombongan Belajar (Kelas)
    </div>

    <table class="rekap-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>Nama Kelas</th>
                <th style="width: 130px;">Total Jurnal KBM</th>
                <th style="width: 160px;">Verifikasi Guru Piket</th>
                <th style="width: 140px;">Siswa Tidak Hadir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapKelasList as $idx => $rk)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td><strong>{{ $rk->nama_kelas }}</strong></td>
                <td class="text-center">{{ $rk->total_jurnal }} Sesi</td>
                <td class="text-center">{{ $rk->terverifikasi }} / {{ $rk->total_jurnal }} Sesi</td>
                <td class="text-center">{{ $rk->siswa_absen > 0 ? ($rk->siswa_absen . ' Siswa') : 'Lengkap (Nihil)' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 14px;">Tidak ada data kelas yang tercatat pada filter ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Block -->
    <div class="signature-container">
        <div class="signature-box">
            <div>Mengetahui,</div>
            <div>Kepala SMKN 1 Boyolangu</div>
            <div class="signature-space"></div>
            <div class="signature-name">Trisno Wibowo, S.Pd., M.M.</div>
            <div>NIP. 198101152003121003</div>
        </div>

        <div class="signature-box">
            <div>Tulungagung, {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}</div>
            <div>Waka Bidang Kurikulum & KBM,</div>
            <div class="signature-space"></div>
            <div class="signature-name">................................................</div>
            <div>NIP. ................................................</div>
        </div>
    </div>

</body>
</html>