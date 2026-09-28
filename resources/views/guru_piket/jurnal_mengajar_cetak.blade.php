<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Jurnal Mengajar Harian — {{ $hariTeks }}, {{ $tglCarbon->translatedFormat('d F Y') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm 12mm 15mm 12mm;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #f1f5f9;
            margin: 0;
            padding: 16px;
            font-size: 11pt;
            line-height: 1.25;
        }

        .print-document-container {
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            max-width: 1100px;
            margin: 0 auto;
        }

        .no-print-bar {
            background: #1e293b;
            color: #fff;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-radius: 10px;
            font-family: Arial, sans-serif;
            font-size: 13.5px;
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
            gap: 16px;
        }

        .no-print-bar-title {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .no-print-bar-title strong {
            font-size: 14.5px;
        }

        .no-print-bar-date {
            opacity: 0.85;
            font-size: 13px;
        }

        .no-print-bar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .btn-print {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 9px 18px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            transition: background 0.2s ease;
        }

        .btn-print:hover {
            background: #1d4ed8;
        }

        .btn-close {
            background: #475569;
            color: #fff;
            border: none;
            padding: 9px 16px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            transition: background 0.2s ease;
        }

        .btn-close:hover {
            background: #334155;
        }

        /* Kop Surat Resmi */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 16px;
            position: relative;
        }

        .kop-logo {
            position: absolute;
            left: 10px;
            top: 5px;
            width: 70px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            width: 100%;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 13pt;
            font-weight: normal;
            letter-spacing: 0.5px;
        }

        .kop-text h2 {
            margin: 2px 0;
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 9.5pt;
            font-family: Arial, sans-serif;
        }

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

        .meta-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 12px;
            font-size: 10pt;
            font-family: Arial, sans-serif;
            gap: 10px;
        }

        .meta-info-grid table {
            width: 100%;
        }

        .meta-info-grid table td {
            padding: 2px 6px 2px 0;
        }

        /* Table Style */
        .rekap-table-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 16px;
        }

        .rekap-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
        }

        .rekap-table th, .rekap-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .rekap-table th {
            background-color: #f1f5f9;
            text-align: center;
            font-weight: bold;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .table-scroll-hint {
            display: none;
        }

        /* Tanda Tangan Block */
        .signature-container {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
            page-break-inside: avoid;
            font-size: 10.5pt;
        }

        .signature-box {
            width: 280px;
            text-align: center;
        }

        .signature-img {
            max-height: 70px;
            max-width: 180px;
            margin: 4px auto;
            display: block;
        }

        .signature-space {
            height: 70px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 4px;
        }

        /* Mobile Responsive View */
        @media screen and (max-width: 768px) {
            body {
                padding: 10px 8px;
                background: #e2e8f0;
            }

            .print-document-container {
                padding: 16px 12px;
                border-radius: 12px;
            }

            /* Top Bar on Mobile */
            .no-print-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding: 14px 16px;
                margin-bottom: 12px;
                border-radius: 12px;
            }

            .no-print-bar-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
                width: 100%;
            }

            .no-print-bar-title strong {
                font-size: 16px !important;
                font-weight: 800;
                line-height: 1.3;
            }

            .no-print-bar-date {
                font-size: 12.5px;
                opacity: 0.9;
            }

            .no-print-bar-actions {
                width: 100%;
                display: flex;
                gap: 8px;
            }

            .btn-print {
                flex: 1;
                justify-content: center;
                height: 42px;
                font-size: 13.5px;
                border-radius: 8px;
            }

            .btn-close {
                flex: 0 0 80px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                height: 42px;
                font-size: 13.5px;
                border-radius: 8px;
                text-align: center;
            }

            /* Kop Surat on Mobile */
            .kop-surat {
                flex-direction: column;
                padding-bottom: 8px;
                margin-bottom: 12px;
                position: static;
            }

            .kop-logo {
                position: static;
                margin: 0 auto 6px auto;
                width: 55px;
                display: block;
            }

            .kop-text h3 {
                font-size: 11pt;
            }

            .kop-text h2 {
                font-size: 13pt;
                line-height: 1.25;
            }

            .kop-text p {
                font-size: 8.5pt;
                line-height: 1.3;
            }

            .doc-title h3 {
                font-size: 13pt;
            }

            /* Meta info on Mobile */
            .meta-info-grid {
                grid-template-columns: 1fr;
                gap: 6px;
                font-size: 9.5pt;
            }

            .meta-info-grid table[style*="text-align: right"],
            .meta-info-grid table:last-child {
                text-align: left !important;
            }

            /* Table horizontal scrolling on mobile */
            .table-scroll-hint {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 11px;
                color: #64748b;
                margin-bottom: 6px;
                font-family: Arial, sans-serif;
                font-weight: 600;
            }

            .rekap-table {
                min-width: 780px;
            }

            /* Signature block on Mobile */
            .signature-container {
                flex-direction: column;
                gap: 20px;
                align-items: center;
                margin-top: 18px;
            }

            .signature-box {
                width: 100%;
                max-width: 320px;
            }
        }

        /* Print exact styling */
        @media print {
            body {
                padding: 0;
                margin: 0;
                background: #fff;
            }

            .print-document-container {
                padding: 0;
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
                margin: 0;
            }

            .no-print-bar,
            .table-scroll-hint {
                display: none !important;
            }

            .rekap-table-wrapper {
                overflow: visible !important;
            }

            .rekap-table {
                min-width: 100% !important;
                width: 100% !important;
            }

            .signature-container {
                flex-direction: row !important;
                justify-content: space-between !important;
            }

            .signature-box {
                width: 280px !important;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <div class="no-print-bar-title">
            <strong><i class="fa-solid fa-print"></i> Mode Cetak Rekapitulasi Jurnal Harian</strong>
            <span class="no-print-bar-date">{{ $hariTeks }}, {{ $tglCarbon->translatedFormat('d F Y') }}</span>
        </div>
        <div class="no-print-bar-actions">
            <button onclick="window.print()" class="btn-print"><i class="fa-solid fa-print"></i> Cetak / Simpan PDF</button>
            <button onclick="window.close()" class="btn-close">Tutup</button>
        </div>
    </div>

    <div class="print-document-container">
        <!-- Kop Surat Resmi -->
        <div class="kop-surat">
            <img src="{{ asset('assets/images/logo_smk.png') }}" alt="Logo SMKN 1 Boyolangu" class="kop-logo" onerror="this.style.display='none'">
            <div class="kop-text">
                <h3>PEMERINTAH PROVINSI JAWA TIMUR</h3>
                <h3>DINAS PENDIDIKAN</h3>
                <h2>SEKOLAH MENENGAH KEJURUAN NEGERI 1 BOYOLANGU</h2>
                <p>Jalan Ki Mangunsarkoro Gg. VI/3 Tulungagung 66233 | Telp. (0355) 321854</p>
                <p>Website: www.smkn1boyolangu.sch.id | Email: smkn1boyolangu@yahoo.co.id</p>
            </div>
        </div>

        <div class="doc-title">
            <h3>REKAPITULASI JURNAL MENGAJAR HARIAN</h3>
            <div style="font-size: 10pt; font-family: Arial, sans-serif; margin-top: 3px;">
                Hari: <strong>{{ $hariTeks }}</strong> &nbsp;|&nbsp; Tanggal: <strong>{{ $tglCarbon->translatedFormat('d F Y') }}</strong>
            </div>
        </div>

        <div class="meta-info-grid">
            <table>
                <tr>
                    <td style="width: 140px;">Tahun Ajaran / Semester</td>
                    <td>: 2026/2027 — Ganjil</td>
                </tr>
                <tr>
                    <td>Petugas Guru Piket</td>
                    <td>: <strong>{{ $verifikasi ? $verifikasi->nama_guru_piket : 'Petugas Guru Piket SMKN 1 Boyolangu' }}</strong></td>
                </tr>
            </table>
            <table style="text-align: right;">
                <tr>
                    <td>Status Verifikasi</td>
                    <td>: {!! $verifikasi ? '<span style="color: green; font-weight: bold;">[ TERVERIFIKASI RESMI ]</span>' : '<span style="color: orange; font-weight: bold;">[ BELUM DITANDATANGANI ]</span>' !!}</td>
                </tr>
                <tr>
                    <td>Total KBM Terlaksana</td>
                    <td>: <strong>{{ $jurnals->count() }} Sesi Kelas</strong></td>
                </tr>
            </table>
        </div>

        <!-- Table Scroll Hint for Mobile View -->
        <div class="table-scroll-hint">
            <i class="fa-solid fa-arrows-left-right"></i>
            <span>Geser tabel ke samping untuk melihat seluruh kolom data</span>
        </div>

        <!-- Tabel KBM dalam Responsive Wrapper -->
        <div class="rekap-table-wrapper">
            <table class="rekap-table">
                <thead>
                    <tr>
                        <th style="width: 30px;">No</th>
                        <th style="width: 65px;">Jam Ke</th>
                        <th style="width: 85px;">Waktu</th>
                        <th style="width: 75px;">Kelas</th>
                        <th style="width: 65px;">Ruang</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru Pengampu / Pengganti</th>
                        <th>Materi Pembelajaran</th>
                        <th style="width: 70px;">Kehadiran</th>
                        <th style="width: 65px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $idx => $j)
                        @php
                            $guruTeks = $j->jadwal->guru->nama_guru ?? '-';
                            if ($j->id_guru_pengganti && $j->guruPengganti) {
                                $guruTeks .= ' (Diganti: ' . $j->guruPengganti->nama_guru . ')';
                            }
                            $absenCount = $j->detailKetidakhadiran->count();
                        @endphp
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td class="text-center"><strong>{{ $j->jadwal->jam_range ?? '-' }}</strong></td>
                            <td class="text-center">{{ $j->jadwal->waktu_mulai_effective ?? '07:00' }} - {{ $j->jadwal->waktu_selesai_effective ?? '08:20' }}</td>
                            <td class="text-center"><strong>{{ $j->jadwal->kelas->nama_kelas ?? '-' }}</strong></td>
                            <td class="text-center">{{ $j->jadwal->ruangan->nama_ruangan ?? '-' }}</td>
                            <td><strong>{{ $j->jadwal->mapel->nama_mapel ?? '-' }}</strong></td>
                            <td>{{ $guruTeks }}</td>
                            <td>{{ $j->materi ?? '-' }}</td>
                            <td class="text-center">
                                @if($absenCount > 0)
                                    <span style="color: #b91c1c; font-weight: bold;">{{ $absenCount }} Absen</span>
                                @else
                                    <span style="color: #15803d;">Lengkap</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span style="font-weight: bold; color: {{ $j->status_kehadiran_guru === 'Hadir' ? '#15803d' : '#b91c1c' }};">
                                    {{ $j->status_kehadiran_guru ?? 'Terlaksana' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center" style="padding: 20px; color: #64748b;">
                                Tidak ada laporan Jurnal Mengajar yang tersimpan pada tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

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
                <div>Tulungagung, {{ $tglCarbon->translatedFormat('d F Y') }}</div>
                <div>Petugas Guru Piket Pengesah,</div>
                
                @if($verifikasi && $verifikasi->tanda_tangan)
                    <img src="{{ $verifikasi->tanda_tangan }}" alt="Tanda Tangan Guru Piket" class="signature-img">
                @else
                    <div class="signature-space" style="display: flex; align-items: center; justify-content: center; color: #94a3b8; font-style: italic; font-size: 9pt;">
                        (Belum Ditandatangani)
                    </div>
                @endif

                <div class="signature-name">{{ $verifikasi->nama_guru_piket ?? '................................................' }}</div>
                <div>NIP. {{ $verifikasi->nip_guru_piket ?? '................................................' }}</div>
                @if($verifikasi)
                    <div style="font-size: 8pt; color: #475569; margin-top: 2px;">
                        Diverifikasi: {{ \Carbon\Carbon::parse($verifikasi->waktu_verifikasi)->format('d/m/Y H:i') }} WIB
                    </div>
                @endif
            </div>
        </div>
    </div>

</body>
</html>