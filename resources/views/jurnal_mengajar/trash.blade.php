<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempat Sampah Jurnal Mengajar — Jurnal Kelas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
            z-index: 0;
        }

        .container {
            max-width: 1100px;
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
        }

        .card-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        .card-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .card-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: #fee2e2;
            color: #dc2626;
            display: flex; align-items: center; justify-content: center;
        }
        .card-title h1 { font-size: 20px; font-weight: 800; color: #0f172a; }
        .card-title p { font-size: 13px; color: #64748b; margin-top: 1px; }

        /* Toast Auto-Dismiss Style */
        .toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            pointer-events: none;
        }
        .toast-card {
            background: #ffffff;
            border-left: 4px solid #10b981;
            border-radius: 14px;
            padding: 14px 18px;
            box-shadow: 0 10px 30px -5px rgba(0,0,0,0.12), 0 4px 6px -2px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 700;
            color: #065f46;
            pointer-events: all;
            position: relative;
            overflow: hidden;
            animation: toastIn .35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            min-width: 320px;
            max-width: 440px;
        }
        .toast-card.hiding { animation: toastOut .4s ease forwards; }
        .toast-close-btn {
            margin-left: auto;
            background: transparent;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            border-radius: 6px;
            transition: all 0.15s ease;
        }
        .toast-close-btn:hover { color: #0f172a; background: #f1f5f9; }

        .toast-progress-bar {
            position: absolute;
            bottom: 0; left: 0;
            height: 3px;
            background: #10b981;
            animation: progressBar 3.5s linear forwards;
        }

        @keyframes toastIn { from { opacity: 0; transform: translateY(-20px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes toastOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(110%); } }
        @keyframes progressBar { from { width: 100%; } to { width: 0%; } }

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
            text-align: left;
        }
        thead {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            padding: 14px 18px;
            font-size: 11.5px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        td {
            padding: 16px 18px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        tbody tr:hover { background-color: #fff1f2; }
        tbody tr:last-child td { border-bottom: none; }

        /* Action Buttons */
        .action-flex {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-act {
            padding: 7px 13px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s ease;
            cursor: pointer;
            border: 1px solid transparent;
            font-family: inherit;
        }
        .btn-restore {
            background: #ecfdf5;
            color: #047857;
            border-color: #a7f3d0;
        }
        .btn-restore:hover {
            background: #d1fae5;
            color: #065f46;
        }
        .btn-force-delete {
            background: #fff1f2;
            color: #e11d48;
            border-color: #fecdd3;
        }
        .btn-force-delete:hover {
            background: #ffe4e6;
            color: #be123c;
        }

        .empty-state {
            padding: 48px 24px;
            text-align: center;
            color: #64748b;
        }
        .empty-state svg { margin-bottom: 12px; color: #cbd5e1; }
        .empty-state h3 { font-size: 16px; font-weight: 700; color: #334155; margin-bottom: 4px; }
        .empty-state p { font-size: 13px; }
    </style>
</head>
<body>

<div class="bg-banner"></div>

<div class="container">

    <!-- Toast Notification -->
    @if(session('success'))
    <div class="toast-container" id="toastContainer">
        <div class="toast-card" id="toastCard">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <span>{{ session('success') }}</span>
            <button type="button" class="toast-close-btn" onclick="dismissToast()" title="Tutup">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <div class="toast-progress-bar"></div>
        </div>
    </div>
    @endif

    <a href="{{ route('jurnal-mengajar.index') }}" class="back-link">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Data Jurnal Mengajar
    </a>

    <div class="card">
        <div class="card-header-row">
            <div class="card-header-left">
                <div class="card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </div>
                <div class="card-title">
                    <h1>Tempat Sampah Jurnal Mengajar</h1>
                    <p>Daftar jurnal mengajar yang sebelumnya telah dihapus (dapat dipulihkan)</p>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>TANGGAL & HARI</th>
                        <th>KELAS & MAPEL</th>
                        <th>GURU PENGAMPU</th>
                        <th>MATERI</th>
                        <th style="width: 240px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $index => $item)
                        <tr>
                            <td style="font-weight: 700; color: #94a3b8;">{{ $index + 1 }}</td>
                            <td>
                                <strong style="color: #0f172a;">{{ $item->tanggal_formatted }}</strong>
                                <br>
                                <small style="color: #64748b; font-weight: 600;">
                                    {{ $item->jadwal->hari ?? '' }} ({{ $item->jadwal->jam_mulai_formatted ?? '' }} - {{ $item->jadwal->jam_selesai_formatted ?? '' }})
                                </small>
                            </td>
                            <td>
                                <strong style="color: #ef4444; background: #fee2e2; padding: 2px 8px; border-radius: 6px; font-size: 12px; display: inline-block; margin-bottom: 3px;">
                                    {{ $item->jadwal->kelas->nama_kelas ?? 'N/A' }}
                                </strong>
                                <br>
                                <span style="font-weight: 700; color: #334155;">{{ $item->jadwal->mapel->nama_mapel ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 600;">{{ $item->jadwal->guru->nama_guru ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #334155;">{{ $item->materi }}</span>
                            </td>
                            <td>
                                <div class="action-flex">
                                    <form action="{{ route('jurnal-mengajar.restore', $item->id_jurnal) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-act btn-restore" title="Pulihkan Jurnal">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                                            Pulihkan
                                        </button>
                                    </form>

                                    <form action="{{ route('jurnal-mengajar.force-delete', $item->id_jurnal) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-act btn-force-delete" title="Hapus Permanen" onclick="confirmForceDelete(this.form, '{{ $item->jadwal->kelas->nama_kelas ?? 'Jurnal' }} - {{ $item->tanggal_formatted }}')">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                            Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    <h3>Tempat sampah kosong</h3>
                                    <p>Tidak ada data jurnal mengajar yang dihapus sementara.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
    // Toast Auto-Dismiss Logic
    let toastTimer;
    const toastCard = document.getElementById('toastCard');
    const toastContainer = document.getElementById('toastContainer');
    
    if (toastCard) {
        toastTimer = setTimeout(() => {
            dismissToast();
        }, 3500);
    }

    function dismissToast() {
        if (!toastCard) return;
        clearTimeout(toastTimer);
        toastCard.classList.add('hiding');
        setTimeout(() => {
            if (toastContainer) toastContainer.remove();
        }, 400);
    }

    function confirmForceDelete(form, name) {
        Swal.fire({
            title: 'Hapus Permanen?',
            text: `Data jurnal "${name}" akan dihapus secara PERMANEN dari database dan tidak bisa dikembalikan!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>

</body>
</html>
