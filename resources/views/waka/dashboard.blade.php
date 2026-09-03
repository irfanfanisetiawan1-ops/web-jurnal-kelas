@extends('layouts.waka')

@section('title', 'Dashboard Wakil Kepala — Jurnal SMEA')

@section('styles')
<style>
    /* Page Header Bar */
    .page-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .breadcrumb-text {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 4px;
    }

    .breadcrumb-text span {
        color: #0f172a;
    }

    .page-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-top: 2px;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-header-outline {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        transition: all 0.15s ease;
    }

    .btn-header-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .btn-header-primary {
        background: #2563eb;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        border: none;
        transition: all 0.15s ease;
    }

    .btn-header-primary:hover {
        background: #1d4ed8;
    }

    /* Stat Cards Grid (4 Columns) */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .stat-card-item {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stat-card-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
    }

    .card-green::before { background: #22c55e; }
    .card-orange::before { background: #f97316; }
    .card-yellow::before { background: #eab308; }
    .card-red::before { background: #ef4444; }

    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-title {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        margin-top: 8px;
        line-height: 1;
    }

    .stat-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        align-self: flex-end;
    }

    .badge-green { background: #f0fdf4; color: #166534; }
    .badge-orange { background: #fff7ed; color: #c2410c; }
    .badge-yellow { background: #fefce8; color: #854d0e; }
    .badge-red { background: #fef2f2; color: #991b1b; }

    /* Middle Section Layout (2 Columns) */
    .middle-section-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 20px;
    }

    .card-panel {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .card-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .card-panel-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
    }

    .link-see-all {
        font-size: 12.5px;
        font-weight: 700;
        color: #2563eb;
        text-decoration: none;
    }

    .link-see-all:hover {
        text-decoration: underline;
    }

    /* Approval List Items */
    .approval-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .approval-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        gap: 12px;
    }

    .approval-item-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #cbd5e1;
        color: #334155;
        font-weight: 800;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .user-details-text .name {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
    }

    .user-details-text .subtext {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
    }

    .reason-text {
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
    }

    .approval-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-action-reject {
        background: #f1f5f9;
        color: #dc2626;
        border: 1px solid #fecdd3;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-action-reject:hover {
        background: #fee2e2;
    }

    .btn-action-approve {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
        transition: all 0.15s ease;
    }

    .btn-action-approve:hover {
        background: #1d4ed8;
    }

    /* Monitoring Progress Bars */
    .progress-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top: 10px;
    }

    .progress-item-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13.5px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .progress-bar-bg {
        width: 100%;
        height: 10px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: #2b3957;
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    @media (max-width: 1100px) {
        .stat-cards-grid { grid-template-columns: repeat(2, 1fr); }
        .middle-section-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

    <!-- Flash Alert Success -->
    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Page Header Row -->
    <div class="page-header-row">
        <div>
            <div class="breadcrumb-text">Jurnal SMEA > <span>Dashboard Wakil Kepala</span></div>
            <h1 class="page-title">Dashboard Wakil Kepala</h1>
            <p class="page-subtitle">Ringkasan operasional dan persetujuan hari ini.</p>
        </div>

        <div class="header-actions">
            <a href="{{ route('waka.export-rekap') }}" class="btn-header-outline">
                <i class="fa-solid fa-download"></i> Ekspor Rekap
            </a>
            <a href="{{ route('waka.jadwal') }}" class="btn-header-primary">
                <i class="fa-solid fa-plus"></i> Tambah Jadwal
            </a>
        </div>
    </div>

    <!-- Stat Summary Cards Row -->
    <div class="stat-cards-grid">
        <!-- Card 1: TOTAL HADIR -->
        <div class="stat-card-item card-green">
            <div class="stat-card-header">
                <span class="stat-title">TOTAL HADIR</span>
            </div>
            <div class="stat-value">{{ $totalHadir }}</div>
            <span class="stat-badge badge-green">
                <i class="fa-solid fa-arrow-up"></i> 95%
            </span>
        </div>

        <!-- Card 2: SAKIT / IZIN -->
        <div class="stat-card-item card-orange">
            <div class="stat-card-header">
                <span class="stat-title">SAKIT / IZIN</span>
            </div>
            <div class="stat-value">{{ $sakitIzinCount }}</div>
            <span class="stat-badge badge-orange">
                2%
            </span>
        </div>

        <!-- Card 3: MENUNGGU PERSETUJUAN -->
        <div class="stat-card-item card-yellow">
            <div class="stat-card-header">
                <span class="stat-title">MENUNGGU PERSETUJUAN</span>
            </div>
            <div class="stat-value">{{ $menungguPersetujuan }}</div>
            <span class="stat-badge badge-yellow">
                Hari ini
            </span>
        </div>

        <!-- Card 4: TANPA KETERANGAN -->
        <div class="stat-card-item card-red">
            <div class="stat-card-header">
                <span class="stat-title">TANPA KETERANGAN</span>
            </div>
            <div class="stat-value">{{ $tanpaKeterangan }}</div>
            <span class="stat-badge badge-red">
                <i class="fa-solid fa-triangle-exclamation"></i> Perhatian
            </span>
        </div>
    </div>

    <!-- Middle Section Grid -->
    <div class="middle-section-grid">
        
        <!-- Left: Antrean Persetujuan -->
        <div class="card-panel">
            <div class="card-panel-header">
                <h2 class="card-panel-title">Antrean Persetujuan</h2>
                <a href="{{ route('waka.persetujuan-izin') }}" class="link-see-all">Lihat Semua</a>
            </div>

            <div class="approval-list">
                @forelse($antreanPersetujuan as $item)
                    <div class="approval-item">
                        <div class="approval-item-left">
                            <div class="user-avatar-circle">{{ $item->initials }}</div>
                            <div class="user-details-text">
                                <div class="name">{{ $item->nama }}</div>
                                <div class="subtext">{{ $item->subtext }}</div>
                            </div>
                        </div>

                        <div class="reason-text">
                            {{ $item->alasan }}
                        </div>

                        <div class="approval-actions">
                            @if($item->type === 'guru_izin')
                                <form action="{{ route('waka.izin.reject', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-action-reject">Tolak</button>
                                </form>
                                <form action="{{ route('waka.izin.approve', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-action-approve">Setujui</button>
                                </form>
                            @else
                                <form action="{{ route('waka.dispen.reject', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-action-reject">Tolak</button>
                                </form>
                                <form action="{{ route('waka.dispen.approve', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-action-approve">Setujui</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <!-- Sample Fallback Items matching UI Mockup if no database pending items -->
                    <div class="approval-item">
                        <div class="approval-item-left">
                            <div class="user-avatar-circle">UK</div>
                            <div class="user-details-text">
                                <div class="name">Umi Kulsum</div>
                                <div class="subtext">Kelas XI PSPT 2</div>
                            </div>
                        </div>
                        <div class="reason-text">Dispensasi Lomba</div>
                        <div class="approval-actions">
                            <button class="btn-action-reject">Tolak</button>
                            <button class="btn-action-approve">Setujui</button>
                        </div>
                    </div>

                    <div class="approval-item">
                        <div class="approval-item-left">
                            <div class="user-avatar-circle">SR</div>
                            <div class="user-details-text">
                                <div class="name">Sri Subekti</div>
                                <div class="subtext">Kelas X MP 1</div>
                            </div>
                        </div>
                        <div class="reason-text">Izin Sakit (Lampiran Surat)</div>
                        <div class="approval-actions">
                            <button class="btn-action-reject">Tolak</button>
                            <button class="btn-action-approve">Setujui</button>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Monitoring Kehadiran -->
        <div class="card-panel">
            <div class="card-panel-header">
                <h2 class="card-panel-title">Monitoring Kehadiran</h2>
            </div>

            <div class="progress-list">
                <!-- Grade X -->
                <div>
                    <div class="progress-item-label">
                        <span>Kelas X</span>
                        <span>{{ $monitoringKehadiran['kelas_x'] ?? 96 }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $monitoringKehadiran['kelas_x'] ?? 96 }}%;"></div>
                    </div>
                </div>

                <!-- Grade XI -->
                <div>
                    <div class="progress-item-label">
                        <span>Kelas XI</span>
                        <span>{{ $monitoringKehadiran['kelas_xi'] ?? 93 }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $monitoringKehadiran['kelas_xi'] ?? 93 }}%;"></div>
                    </div>
                </div>

                <!-- Grade XII -->
                <div>
                    <div class="progress-item-label">
                        <span>Kelas XII</span>
                        <span>{{ $monitoringKehadiran['kelas_xii'] ?? 91 }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $monitoringKehadiran['kelas_xii'] ?? 91 }}%;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
