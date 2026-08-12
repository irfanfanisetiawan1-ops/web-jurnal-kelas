<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempat Sampah Ruangan — Jurnal Kelas</title>
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
            background: linear-gradient(135deg, #64748b 0%, #475569 50%, #334155 100%);
            z-index: 0;
        }
        .bg-banner::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 300px; height: 300px;
            background: rgba(255, 255, 255, 0.07);
            border-radius: 50%;
            pointer-events: none;
        }
        .bg-banner::after {
            content: '';
            position: absolute;
            bottom: 20px; left: 10%;
            width: 180px; height: 180px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
            pointer-events: none;
        }

        .container {
            max-width: 1080px;
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
            opacity: 0.9;
            transition: opacity 0.15s ease;
        }
        .back-link:hover { opacity: 1; }

        /* Header Card */
        .header-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 20px 28px;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e2e8f0;
            flex-wrap: wrap;
            gap: 16px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .header-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #64748b, #475569);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            color: #ffffff;
            box-shadow: 0 6px 14px -3px rgba(71,85,105,0.35);
        }
        .header-title h1 { font-size: 20px; font-weight: 800; color: #0f172a; }
        .header-title p { font-size: 13px; color: #64748b; margin-top: 2px; }

        .btn-back {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 11px 18px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.15s ease;
        }
        .btn-back:hover { background: #e2e8f0; color: #1e293b; }

        /* Main Card */
        .main-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 10px 30px -5px rgba(0,0,0,0.04);
            border: 1px solid #e2e8f0;
        }

        .card-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
            gap: 12px;
        }
        .card-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .card-header-icon {
            width: 40px; height: 40px;
            background: #fee2e2;
            color: #ef4444;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }
        .card-header-info h2 { font-size: 17px; font-weight: 800; color: #0f172a; }
        .card-header-info p { font-size: 13px; color: #64748b; }
        .count-pill {
            background: #fee2e2;
            color: #dc2626;
            font-size: 13px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Table */
        .table-container {
            width: 100%;
            overflow-x: auto;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th {
            background: #f8fafc;
            padding: 14px 18px;
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border-bottom: 1.5px solid #e2e8f0;
        }
        td {
            padding: 16px 18px;
            font-size: 13.5px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafb; }

        .no-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px; height: 26px;
            background: #f1f5f9;
            color: #475569;
            font-weight: 700;
            font-size: 12px;
            border-radius: 8px;
        }

        .ruangan-title {
            font-weight: 700;
            color: #0f172a;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ruangan-icon-circle {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: #f1f5f9;
            color: #64748b;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* Badges for Jenis Ruangan */
        .badge-jenis {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
        }
        .badge-kelas-biasa { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-lab { background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }
        .badge-ruang-praktik { background: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
        .badge-lainnya { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

        .deleted-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fee2e2;
            color: #dc2626;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .actions-cell { display: flex; align-items: center; gap: 8px; }
        .btn-act {
            padding: 7px 14px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s ease;
            cursor: pointer;
            border: 1px solid transparent;
            font-family: inherit;
            text-decoration: none;
        }
        .btn-restore {
            background: #ecfdf5;
            color: #059669;
            border-color: #a7f3d0;
        }
        .btn-restore:hover { background: #d1fae5; }
        .btn-force-delete {
            background: #fff1f2;
            color: #e11d48;
            border-color: #fecdd3;
        }
        .btn-force-delete:hover { background: #ffe4e6; }

        /* Empty State */
        .empty-box {
            text-align: center;
            padding: 56px 20px;
        }
        .empty-icon {
            width: 64px; height: 64px;
            background: #f1f5f9;
            color: #94a3b8;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
        }
        .empty-box p { font-size: 15px; font-weight: 600; color: #475569; }
        .empty-box small { font-size: 13px; color: #94a3b8; margin-top: 4px; display: block; }

        /* Toast Auto-Dismiss */
        .toast-container { position: fixed; top: 24px; right: 24px; z-index: 9999; pointer-events: none; }
        .toast-card {
            background: #fff;
            border-left: 4px solid #10b981;
            border-radius: 14px;
            padding: 14px 18px;
            box-shadow: 0 10px 30px -5px rgba(0,0,0,0.12);
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
        .toast-close-btn { margin-left: auto; background: transparent; border: none; color: #94a3b8; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 4px; border-radius: 6px; }
        .toast-close-btn:hover { color: #0f172a; background: #f1f5f9; }
        .toast-bar { position: absolute; bottom: 0; left: 0; height: 3px; background: #10b981; animation: barOut 3.5s linear forwards; }
        @keyframes toastIn { from { opacity: 0; transform: translateY(-20px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes toastOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(110%); } }
        @keyframes barOut { from { width: 100%; } to { width: 0%; } }

        /* Modals */
        .modal-bg { display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.45); backdrop-filter: blur(5px); z-index: 900; align-items: center; justify-content: center; padding: 20px; }
        .modal-bg.active { display: flex; }
        .modal-box { background: #fff; border-radius: 24px; padding: 32px; max-width: 440px; width: 100%; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: popIn .2s ease; text-align: center; }
        @keyframes popIn { from { opacity: 0; transform: scale(.95); } to { opacity: 1; transform: scale(1); } }
        .modal-icon-wrap { width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .modal-box h3 { font-size: 19px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
        .modal-box p { font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.6; }
        .modal-actions { display: flex; gap: 12px; }
        .btn-m-cancel { flex: 1; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 12px; font-size: 13.5px; font-weight: 700; border-radius: 12px; cursor: pointer; font-family: inherit; }
        .btn-m-confirm-green { flex: 1; background: #059669; color: #fff; border: none; padding: 12px; font-size: 13.5px; font-weight: 700; border-radius: 12px; cursor: pointer; font-family: inherit; box-shadow: 0 4px 12px rgba(5,150,105,0.3); }
        .btn-m-confirm-red { flex: 1; background: #dc2626; color: #fff; border: none; padding: 12px; font-size: 13.5px; font-weight: 700; border-radius: 12px; cursor: pointer; font-family: inherit; box-shadow: 0 4px 12px rgba(220,38,38,0.3); }
    </style>
</head>
<body>

<div class="bg-banner"></div>

@if(session('success'))
<div class="toast-container" id="toastContainer">
    <div class="toast-card" id="toastCard">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
        <button type="button" class="toast-close-btn" onclick="dismissToast()" title="Tutup">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div class="toast-bar"></div>
    </div>
</div>
@endif

<div class="container">

    <a href="{{ route('ruangan.index') }}" class="back-link">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Daftar Ruangan
    </a>

    <!-- Header Card -->
    <div class="header-card">
        <div class="header-left">
            <div class="header-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </div>
            <div class="header-title">
                <h1>Tempat Sampah — Ruangan</h1>
                <p>Data ruangan yang telah dihapus sementara</p>
            </div>
        </div>
        <a href="{{ route('ruangan.index') }}" class="btn-back">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali
        </a>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header-row">
            <div class="card-header-left">
                <div class="card-header-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </div>
                <div class="card-header-info">
                    <h2>Ruangan Terhapus</h2>
                    <p>Pulihkan atau hapus permanen data ruangan</p>
                </div>
            </div>
            <div class="count-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                {{ $ruangans->count() }} Item
            </div>
        </div>

        @if($ruangans->isEmpty())
            <div class="empty-box">
                <div class="empty-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </div>
                <p>Tempat sampah kosong</p>
                <small>Tidak ada data ruangan di tempat sampah saat ini.</small>
            </div>
        @else
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 60px; text-align: center;">NO</th>
                            <th>NAMA RUANGAN</th>
                            <th style="width: 180px;">JENIS RUANGAN</th>
                            <th style="width: 200px;">TANGGAL DIHAPUS</th>
                            <th style="width: 260px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruangans as $index => $ruangan)
                            <tr>
                                <td style="text-align: center;">
                                    <span class="no-badge">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="ruangan-title">
                                        <div class="ruangan-icon-circle">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                                        </div>
                                        <span>{{ $ruangan->nama_ruangan }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($ruangan->jenis_ruangan) {
                                            'Kelas Biasa'   => 'badge-kelas-biasa',
                                            'Lab'           => 'badge-lab',
                                            'Ruang Praktik' => 'badge-ruang-praktik',
                                            default         => 'badge-lainnya'
                                        };
                                    @endphp
                                    <span class="badge-jenis {{ $badgeClass }}">
                                        {{ $ruangan->jenis_ruangan }}
                                    </span>
                                </td>
                                <td>
                                    <span class="deleted-badge">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ $ruangan->deleted_at ? $ruangan->deleted_at->format('d M Y, H:i') : '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <button type="button" class="btn-act btn-restore" onclick="confirmRestore('{{ $ruangan->id_ruangan }}', '{{ addslashes($ruangan->nama_ruangan) }}')">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><polyline points="3 3 3 8 8 8"/></svg>
                                            Pulihkan
                                        </button>

                                        <button type="button" class="btn-act btn-force-delete" onclick="confirmForceDelete('{{ $ruangan->id_ruangan }}', '{{ addslashes($ruangan->nama_ruangan) }}')">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            Hapus Permanen
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

<!-- Modal Pulihkan -->
<div class="modal-bg" id="restoreModal">
    <div class="modal-box">
        <div class="modal-icon-wrap" style="background: #d1fae5; color: #059669;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><polyline points="3 3 3 8 8 8"/></svg>
        </div>
        <h3>Pulihkan Ruangan?</h3>
        <p>Apakah Anda yakin ingin memulihkan data ruangan <strong id="restoreItemName" style="color:#0f172a;"></strong> kembali ke daftar utama?</p>
        <form id="restoreForm" method="POST" action="">
            @csrf
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeRestoreModal()">Batal</button>
                <button type="submit" class="btn-m-confirm-green">Ya, Pulihkan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Permanen -->
<div class="modal-bg" id="forceDeleteModal">
    <div class="modal-box">
        <div class="modal-icon-wrap" style="background: #fee2e2; color: #dc2626;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <h3>Hapus Permanen?</h3>
        <p>Data ruangan <strong id="forceDeleteItemName" style="color:#0f172a;"></strong> akan dihapus secara permanen dari database. Tindakan ini <strong>tidak dapat dibatalkan</strong>.</p>
        <form id="forceDeleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeForceModal()">Batal</button>
                <button type="submit" class="btn-m-confirm-red">Ya, Hapus Permanen</button>
            </div>
        </form>
    </div>
</div>

<script>
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

    function confirmRestore(id, name) {
        const modal = document.getElementById('restoreModal');
        const form = document.getElementById('restoreForm');
        const itemName = document.getElementById('restoreItemName');
        
        form.action = '/ruangan/' + id + '/restore';
        itemName.textContent = '"' + name + '"';
        modal.classList.add('active');
    }

    function closeRestoreModal() {
        document.getElementById('restoreModal').classList.remove('active');
    }

    function confirmForceDelete(id, name) {
        const modal = document.getElementById('forceDeleteModal');
        const form = document.getElementById('forceDeleteForm');
        const itemName = document.getElementById('forceDeleteItemName');
        
        form.action = '/ruangan/' + id + '/force-delete';
        itemName.textContent = '"' + name + '"';
        modal.classList.add('active');
    }

    function closeForceModal() {
        document.getElementById('forceDeleteModal').classList.remove('active');
    }

    document.getElementById('restoreModal').addEventListener('click', function(e) {
        if (e.target === this) closeRestoreModal();
    });
    document.getElementById('forceDeleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeForceModal();
    });
</script>

</body>
</html>
