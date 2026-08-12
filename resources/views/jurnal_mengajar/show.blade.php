<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jurnal Mengajar — Jurnal Kelas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            padding-bottom: 50px;
        }

        .bg-banner {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 220px;
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 50%, #4f46e5 100%);
            z-index: 0;
        }

        .container {
            max-width: 860px;
            margin: 0 auto;
            padding: 24px;
            position: relative;
            z-index: 1;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 20px;
            transition: opacity 0.15s ease;
        }
        .back-link:hover { opacity: 0.85; }

        .card {
            background: #ffffff;
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
            gap: 16px;
        }
        .card-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .card-icon {
            width: 52px; height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 16px -4px rgba(79, 70, 229, 0.35);
        }
        .card-title h1 { font-size: 22px; font-weight: 800; color: #0f172a; }
        .card-title p { font-size: 13.5px; color: #64748b; margin-top: 2px; }

        .btn-edit-head {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fef08a;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.15s ease;
        }
        .btn-edit-head:hover {
            background: #fef3c7;
            color: #b45309;
        }

        /* Detail Cards Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 20px;
        }
        .info-box .label {
            font-size: 11.5px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }
        .info-box .val {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
        }
        .info-box .sub {
            font-size: 12.5px;
            color: #475569;
            font-weight: 600;
            margin-top: 2px;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 800;
        }
        .status-Hadir { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .status-Izin  { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .status-Sakit { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .status-Tanpa-Keterangan { background: #ffe4e6; color: #be123c; border: 1px solid #fecdd3; }

        /* Block Content */
        .content-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .content-card h3 {
            font-size: 14px;
            font-weight: 800;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .content-text {
            font-size: 14px;
            line-height: 1.6;
            color: #1e293b;
            font-weight: 500;
            white-space: pre-line;
        }

        /* Table Presensi Siswa */
        .absence-table-wrap {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            margin-top: 10px;
        }
        .absence-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }
        .absence-table th {
            background: #f8fafc;
            padding: 12px 16px;
            font-size: 11.5px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0;
        }
        .absence-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .absence-table tr:last-child td {
            border-bottom: none;
        }

        .badge-ket {
            display: inline-flex;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 800;
        }
        .ket-Sakit { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .ket-Izin  { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .ket-Alpa  { background: #ffe4e6; color: #be123c; border: 1px solid #fecdd3; }

        @media (max-width: 768px) {
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="bg-banner"></div>

<div class="container">

    <a href="{{ route('jurnal-mengajar.index') }}" class="back-link">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Jurnal Mengajar
    </a>

    <div class="card">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="14" y2="10"/></svg>
                </div>
                <div class="card-title">
                    <h1>Detail Jurnal Mengajar</h1>
                    <p>Rincian kegiatan pembelajaran pada {{ $jurnal->tanggal_formatted }}</p>
                </div>
            </div>
            <a href="{{ route('jurnal-mengajar.edit', $jurnal->id_jurnal) }}" class="btn-edit-head">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Jurnal
            </a>
        </div>

        @php
            $statusClass = str_replace(' ', '-', $jurnal->status_kehadiran_guru);
        @endphp

        <!-- Key Information Grid -->
        <div class="info-grid">
            <div class="info-box">
                <div class="label">Tanggal & Jadwal</div>
                <div class="val">{{ $jurnal->tanggal_formatted }}</div>
                <div class="sub">{{ $jurnal->jadwal->hari ?? '' }} ({{ $jurnal->jadwal->jam_mulai_formatted ?? '' }} - {{ $jurnal->jadwal->jam_selesai_formatted ?? '' }})</div>
            </div>
            <div class="info-box">
                <div class="label">Kelas & Ruangan</div>
                <div class="val" style="color: #4f46e5;">{{ $jurnal->jadwal->kelas->nama_kelas ?? 'N/A' }}</div>
                <div class="sub">Ruangan: {{ $jurnal->jadwal->ruangan->nama_ruangan ?? 'N/A' }}</div>
            </div>
            <div class="info-box">
                <div class="label">Status Guru</div>
                <div style="margin-top: 4px;">
                    <span class="status-badge status-{{ $statusClass }}">
                        {{ $jurnal->status_kehadiran_guru }}
                    </span>
                </div>
            </div>
        </div>

        <div class="info-grid" style="grid-template-columns: 1fr 1fr; margin-bottom: 28px;">
            <div class="info-box">
                <div class="label">Mata Pelajaran</div>
                <div class="val">{{ $jurnal->jadwal->mapel->nama_mapel ?? 'N/A' }}</div>
                <div class="sub">Kode: {{ $jurnal->jadwal->mapel->kode_mapel ?? '-' }}</div>
            </div>
            <div class="info-box">
                <div class="label">Guru Pengampu</div>
                <div class="val">{{ $jurnal->jadwal->guru->nama_guru ?? 'N/A' }}</div>
                <div class="sub">NIP: {{ $jurnal->jadwal->guru->nip ?? '-' }}</div>
            </div>
        </div>

        <!-- Materi Pembelajaran -->
        <div class="content-card">
            <h3>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                Materi Pembelajaran
            </h3>
            <div class="content-text">{{ $jurnal->materi }}</div>
        </div>

        <!-- Catatan Kelas -->
        @if($jurnal->catatan)
            <div class="content-card">
                <h3>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Catatan Pembelajaran / Kejadian
                </h3>
                <div class="content-text">{{ $jurnal->catatan }}</div>
            </div>
        @endif

        <!-- Data Ketidakhadiran Siswa -->
        <div class="content-card">
            <h3>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Rekap Ketidakhadiran Siswa ({{ $jurnal->detailKetidakhadiran->count() }})
            </h3>

            @if($jurnal->detailKetidakhadiran->count() > 0)
                <div class="absence-table-wrap">
                    <table class="absence-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">NO</th>
                                <th>NISN</th>
                                <th>NAMA SISWA</th>
                                <th>KETERANGAN ABSEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jurnal->detailKetidakhadiran as $idx => $detail)
                                <tr>
                                    <td style="font-weight: 700; color: #94a3b8;">{{ $idx + 1 }}</td>
                                    <td style="font-weight: 600; color: #64748b;">{{ $detail->siswa->nisn ?? '-' }}</td>
                                    <td style="font-weight: 700; color: #0f172a;">{{ $detail->siswa->nama_siswa ?? 'Siswa Terhapus' }}</td>
                                    <td>
                                        <span class="badge-ket ket-{{ $detail->keterangan }}">
                                            {{ $detail->keterangan }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px; padding: 14px 18px; color: #047857; font-weight: 700; font-size: 13.5px; display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Seluruh siswa hadir lengkap pada sesi pembelajaran ini.
                </div>
            @endif
        </div>

    </div>

</div>

</body>
</html>
