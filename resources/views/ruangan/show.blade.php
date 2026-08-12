<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ruangan — Jurnal Kelas</title>
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
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 50%, #14b8a6 100%);
            z-index: 0;
        }

        .container {
            max-width: 800px;
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
            padding: 32px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .ruangan-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding-bottom: 24px;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
        }
        .ruangan-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .ruangan-icon-large {
            width: 56px; height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, #0d9488, #14b8a6);
            color: #ffffff;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 16px -4px rgba(13, 148, 136, 0.35);
        }
        .ruangan-title-wrap h1 { font-size: 22px; font-weight: 800; color: #0f172a; }
        .ruangan-title-wrap p { font-size: 13.5px; color: #64748b; margin-top: 2px; }

        .badge-jenis {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
        }
        .badge-kelas-biasa { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-lab { background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }
        .badge-ruang-praktik { background: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
        .badge-lainnya { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

        .action-bar {
            display: flex;
            gap: 10px;
        }
        .btn-edit-head {
            background: #ccfbf1;
            color: #0f766e;
            border: 1px solid #99f6e4;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s ease;
        }
        .btn-edit-head:hover { background: #99f6e4; color: #115e59; }

        .section-title {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            margin-top: 24px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }
        thead { background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        th {
            padding: 12px 16px;
            font-size: 11.5px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        td { padding: 14px 16px; color: #334155; border-bottom: 1px solid #f1f5f9; }
        tbody tr:last-child td { border-bottom: none; }

        .empty-jadwal {
            text-align: center;
            padding: 40px 20px;
            color: #64748b;
            font-size: 13.5px;
        }
    </style>
</head>
<body>

<div class="bg-banner"></div>

<div class="container">

    <a href="{{ route('ruangan.index') }}" class="back-link">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Data Ruangan
    </a>

    <div class="card">
        <div class="ruangan-header-row">
            <div class="ruangan-info">
                <div class="ruangan-icon-large">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                </div>
                <div class="ruangan-title-wrap">
                    <h1>{{ $ruangan->nama_ruangan }}</h1>
                    <p>ID Ruangan: #{{ $ruangan->id_ruangan }}</p>
                </div>
            </div>
            <div class="action-bar">
                @php
                    $badgeClass = match($ruangan->jenis_ruangan) {
                        'Kelas Biasa'   => 'badge-kelas-biasa',
                        'Lab'           => 'badge-lab',
                        'Ruang Praktik' => 'badge-ruang-praktik',
                        default         => 'badge-lainnya'
                    };
                @endphp
                <span class="badge-jenis {{ $badgeClass }}">{{ $ruangan->jenis_ruangan }}</span>
                <a href="{{ route('ruangan.edit', $ruangan->id_ruangan) }}" class="btn-edit-head">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit Ruangan
                </a>
            </div>
        </div>

        <h3 class="section-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="color:#0d9488;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Jadwal Pemakaian Ruangan ({{ count($ruangan->jadwals) }})
        </h3>

        @if($ruangan->jadwals->isEmpty())
            <div class="empty-jadwal">
                Belum ada jadwal yang menggunakan ruangan ini.
            </div>
        @else
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>HARI</th>
                            <th>KELAS</th>
                            <th>MATA PELAJARAN</th>
                            <th>GURU PENGAMPU</th>
                            <th>JAM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruangan->jadwals as $jadwal)
                            <tr>
                                <td style="font-weight:700;">{{ $jadwal->hari }}</td>
                                <td>{{ $jadwal->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $jadwal->mapel->nama_mapel ?? '-' }}</td>
                                <td>{{ $jadwal->guru->nama_guru ?? '-' }}</td>
                                <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

</div>

</body>
</html>
