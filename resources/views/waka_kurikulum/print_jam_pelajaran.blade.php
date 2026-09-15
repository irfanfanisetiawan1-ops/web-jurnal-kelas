<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Alokasi Jam Pelajaran KBM — SMK Negeri 1 Boyolangu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #0f172a;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 4px 0;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .header h2 {
            font-size: 14px;
            font-weight: 700;
            margin: 0 0 4px 0;
            color: #2563eb;
        }
        .header p {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }
        .info-box {
            display: flex;
            justify-content: space-between;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 20px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        th {
            background: #1e293b;
            color: #ffffff;
            font-weight: 700;
            padding: 8px 10px;
            text-align: left;
            border: 1px solid #1e293b;
            text-transform: uppercase;
            font-size: 10px;
        }
        td {
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        tr:nth-child(even) td {
            background: #f8fafc;
        }
        .badge-jam {
            font-weight: 800;
            color: #1d4ed8;
        }
        .badge-istirahat {
            background: #fef3c7;
            color: #92400e;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
        }
        .footer-signature {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .sig-box {
            width: 220px;
            text-align: center;
        }
        .sig-space {
            height: 60px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
            font-size: 13px;
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="btn-print no-print">
        <i class="fa-solid fa-print"></i> Cetak Dokumen
    </button>

    <div class="header">
        <h1>SMK NEGERI 1 BOYOLANGU</h1>
        <h2>ALOKASI JAM PELAJARAN KEGIATAN BELAJAR MENGAJAR (KBM)</h2>
        <p>Jalan Ki Mangunsarkoro VI/1 Boyolangu, Tulungagung | Tahun Ajaran 2026/2027</p>
    </div>

    <div class="info-box">
        <div>
            <strong>Dokumen Resmi:</strong> Waka Kurikulum &amp; Akademik<br>
            <strong>Standard KBM Mon–Thu:</strong> 40 Min (Jam 1–4) &amp; 35 Min (Jam 5–10)
        </div>
        <div style="text-align: right;">
            <strong>Standard KBM Friday:</strong> 30 Min (Jam 1–12) &amp; 35 Min (Jam 13)<br>
            <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 35px; text-align: center;">NO</th>
                <th style="width: 90px;">SESI JAM</th>
                <th style="width: 140px;">WAKTU SENIN – KAMIS</th>
                <th style="width: 140px;">WAKTU JUMAT</th>
                <th>KETERANGAN / RINCIAN SESI</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jamList as $idx => $jam)
                @php
                    $isIstirahat = (stripos($jam->keterangan, 'Istirahat') !== false || stripos($jam->keterangan, 'ISHOMA') !== false || stripos($jam->keterangan, 'Sholat') !== false);
                @endphp
                <tr>
                    <td style="text-align: center; font-weight: 700; color: #64748b;">{{ $idx + 1 }}</td>
                    <td class="badge-jam">
                        {{ preg_match('/^Jam\s+Ke-/i', $jam->jam_ke) ? $jam->jam_ke : 'Jam Ke-' . $jam->jam_ke }}
                    </td>
                    <td style="font-weight: 700;">
                        {{ $jam->jam_mulai ? substr($jam->jam_mulai, 0, 5) . ' - ' . substr($jam->jam_selesai, 0, 5) . ' WIB' : '-' }}
                    </td>
                    <td style="font-weight: 700;">
                        {{ $jam->jam_mulai_jumat ? substr($jam->jam_mulai_jumat, 0, 5) . ' - ' . substr($jam->jam_selesai_jumat, 0, 5) . ' WIB' : '-' }}
                    </td>
                    <td>
                        @if($isIstirahat)
                            <span class="badge-istirahat"><i class="fa-solid fa-mug-hot"></i> {{ $jam->keterangan }}</span>
                        @else
                            {{ $jam->keterangan ?: 'Kegiatan Belajar Mengajar (KBM)' }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-signature">
        <div class="sig-box">
            <p>Mengetahui,<br><strong>Kepala SMKN 1 Boyolangu</strong></p>
            <div class="sig-space"></div>
            <p>__________________________<br>NIP. -</p>
        </div>
        <div class="sig-box">
            <p>Tulungagung, {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}<br><strong>Waka Kurikulum</strong></p>
            <div class="sig-space"></div>
            <p>__________________________<br>NIP. -</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                // window.print();
            }, 500);
        };
    </script>
</body>
</html>
