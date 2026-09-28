<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jurnal Mengajar — {{ $jurnal->jadwal->guru->nama_guru ?? 'Guru' }} ({{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }})</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #ffffff;
            color: #0f172a;
            padding: 30px;
            font-size: 13px;
            margin: 0;
            line-height: 1.5;
        }

        .print-action-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-print-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-print-primary {
            background: #2563eb;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        }
        .btn-print-primary:hover {
            background: #1d4ed8;
        }

        .btn-print-secondary {
            background: #64748b;
            color: #ffffff;
        }
        .btn-print-secondary:hover {
            background: #475569;
        }

        .header-print {
            border-bottom: 3px double #0f172a;
            padding-bottom: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 260px;
        }

        .header-brand img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .header-brand h1 {
            font-size: 20px;
            font-weight: 800;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 4px 0;
            line-height: 1.25;
        }

        .header-brand p {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            margin: 0;
        }

        .badge-status {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }
        .badge-hadir { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .badge-absen { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
        }

        .info-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 3px;
            letter-spacing: 0.02em;
        }

        .info-value {
            font-size: 13.5px;
            font-weight: 800;
            color: #0f172a;
            word-break: break-word;
        }

        .section-title {
            font-size: 13.5px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 8px;
            border-left: 4px solid #2563eb;
            padding-left: 10px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .content-box {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 22px;
            line-height: 1.6;
            font-size: 13px;
            color: #334155;
            word-break: break-word;
        }

        .table-responsive-print {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 22px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
        }

        .table-custom th {
            background: #1e293b;
            color: #ffffff;
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 700;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            white-space: nowrap;
        }

        .table-custom td {
            padding: 10px 14px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12.5px;
            color: #1e293b;
        }

        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        .foto-container {
            text-align: center;
            margin-bottom: 24px;
        }

        .foto-container img {
            max-width: 480px;
            width: 100%;
            max-height: 320px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            object-fit: cover;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 36px;
            padding-top: 20px;
        }

        .sig-box {
            text-align: center;
            width: 220px;
            font-size: 12.5px;
        }

        .sig-space {
            height: 60px;
        }

        /* ── RESPONSIVE MOBILE STYLES (Screen <= 768px) ── */
        @media (max-width: 768px) {
            body {
                padding: 16px 12px;
                font-size: 12.5px;
            }

            .print-action-bar {
                width: 100%;
                justify-content: stretch;
                gap: 8px;
            }

            .btn-print-action {
                flex: 1;
                padding: 10px 12px;
                font-size: 12.5px;
            }

            .header-print {
                padding-bottom: 12px;
                margin-bottom: 18px;
                gap: 10px;
            }

            .header-brand {
                gap: 10px;
                min-width: unset;
                width: 100%;
            }

            .header-brand img {
                width: 60px;
                height: 60px;
            }

            .header-brand h1 {
                font-size: 16.5px;
                margin-bottom: 2px;
            }

            .header-brand p {
                font-size: 11px;
            }

            .badge-status {
                padding: 5px 12px;
                font-size: 11px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 8px;
                margin-bottom: 18px;
            }

            .info-card {
                padding: 10px 12px;
            }

            .info-value {
                font-size: 13px;
            }

            .section-title {
                font-size: 12.5px;
                margin-bottom: 6px;
            }

            .content-box {
                padding: 12px;
                margin-bottom: 18px;
                font-size: 12px;
            }

            .table-custom {
                min-width: 480px;
            }

            .table-custom th,
            .table-custom td {
                padding: 8px 10px;
                font-size: 11.5px;
            }

            .foto-container img {
                max-width: 100%;
                max-height: 240px;
            }

            .signature-section {
                margin-top: 24px;
                padding-top: 14px;
            }

            .sig-box {
                width: 48%;
                font-size: 11px;
            }

            .sig-space {
                height: 45px;
            }
        }

        @media (max-width: 420px) {
            .header-brand h1 {
                font-size: 15px;
            }
        }

        /* ── PRINT STYLES ── */
        @media print {
            body {
                padding: 0;
                background: #ffffff;
                color: #000000;
            }
            .no-print {
                display: none !important;
            }
            .info-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .table-responsive-print {
                overflow: visible !important;
                border: none !important;
            }
            .table-custom {
                min-width: 100% !important;
            }
        }
    </style>
</head>
<body>

    <div class="no-print print-action-bar">
        <button onclick="window.print()" class="btn-print-action btn-print-primary">
            <i class="fa-solid fa-print"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
        <button onclick="window.close()" class="btn-print-action btn-print-secondary">
            <i class="fa-solid fa-xmark"></i>
            <span>Tutup</span>
        </button>
    </div>

    <div class="header-print">
        <div class="header-brand">
            <img src="{{ asset('images/logo_jurnal_baru.png') }}" alt="EDU JOURNAL Logo">
            <div>
                <h1>Jurnal Mengajar EDU JOURNAL</h1>
                <p>Bukti Pelaksanaan Kegiatan Pembelajaran dan Presensi Kelas</p>
            </div>
        </div>
        <div>
            @if($jurnal->status_kehadiran_guru === 'Hadir')
                <span class="badge-status badge-hadir">GURU HADIR</span>
            @else
                <span class="badge-status badge-absen">{{ strtoupper($jurnal->status_kehadiran_guru) }}</span>
            @endif
        </div>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <div class="info-label">Tanggal Pembelajaran</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('l, d F Y') }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Guru Pengajar</div>
            <div class="info-value">{{ $jurnal->jadwal->guru->nama_guru ?? '-' }} (NIP: {{ $jurnal->jadwal->guru->nip ?? '-' }})</div>
        </div>
        <div class="info-card">
            <div class="info-label">Mata Pelajaran</div>
            <div class="info-value">{{ $jurnal->jadwal->mapel->nama_mapel ?? '-' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Kelas & Ruangan</div>
            <div class="info-value">{{ $jurnal->jadwal->kelas->nama_kelas ?? '-' }} — Ruang {{ $jurnal->jadwal->ruangan->nama_ruangan ?? '-' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Jam Ke- / Alokasi Waktu</div>
            <div class="info-value">Jam Ke-{{ $jurnal->jadwal->jam_range ?? '-' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Waktu Pencatatan</div>
            <div class="info-value">{{ $jurnal->dicatat_pada ? \Carbon\Carbon::parse($jurnal->dicatat_pada)->format('d/m/Y H:i') . ' WIB' : '-' }}</div>
        </div>
    </div>

    <div class="section-title">Materi Pembelajaran</div>
    <div class="content-box">
        {{ $jurnal->materi ?? 'Tidak ada materi yang dicatat.' }}
    </div>

    <div class="section-title">Catatan Pembelajaran / Kejadian Kelas</div>
    <div class="content-box">
        {{ $jurnal->catatan ?? 'Tidak ada catatan tambahan.' }}
    </div>

    <div class="section-title">Daftar Ketidakhadiran Siswa</div>
    <div class="table-responsive-print">
        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center;">No</th>
                    <th>Nama Siswa</th>
                    <th>NISN / NIS</th>
                    <th style="width: 100px;">Status</th>
                    <th>Catatan / Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @if($jurnal->detailKetidakhadiran && $jurnal->detailKetidakhadiran->count() > 0)
                    @foreach($jurnal->detailKetidakhadiran as $idx => $d)
                        <tr>
                            <td style="text-align: center;">{{ $idx + 1 }}</td>
                            <td><strong>{{ $d->siswa->nama_siswa ?? 'Siswa' }}</strong></td>
                            <td>{{ $d->siswa->nisn ?? $d->siswa->nis ?? '-' }}</td>
                            <td>
                                <strong style="color: {{ $d->keterangan == 'Sakit' ? '#d97706' : ($d->keterangan == 'Izin' ? '#2563eb' : '#dc2626') }};">
                                    {{ strtoupper($d->keterangan) }}
                                </strong>
                            </td>
                            <td>{{ $d->catatan ?: '-' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center; color: #166534; font-weight: 700; padding: 15px;">
                            Semua siswa hadir (Nihil ketidakhadiran).
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if($jurnal->dokumentasi_url)
        <div class="section-title">Foto Bukti Dokumentasi</div>
        <div class="foto-container">
            <img src="{{ $jurnal->dokumentasi_url }}" alt="Foto Dokumentasi">
        </div>
    @endif

    <div class="signature-section">
        <div class="sig-box">
            <div>Mengetahui,</div>
            <div>Kepala Sekolah / Kurikulum</div>
            <div class="sig-space"></div>
            <div><strong>_________________________</strong></div>
            <div>NIP. ........................................</div>
        </div>
        <div class="sig-box">
            <div>Guru Pengajar,</div>
            <div class="sig-space"></div>
            <div><strong>{{ $jurnal->jadwal->guru->nama_guru ?? 'Guru Pengajar' }}</strong></div>
            <div>NIP. {{ $jurnal->jadwal->guru->nip ?? '........................................' }}</div>
        </div>
    </div>

</body>
</html>
