@extends('layouts.waka_sdm')

@section('title', 'Dashboard Waka SDM — EduJournal')
@section('page-header', 'Dashboard Waka SDM')
@section('page-subheader', 'Ringkasan performa kepegawaian, pengajuan izin guru, dan monitoring KBM')

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        gap: 18px;
        transition: transform 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .stat-icon.blue { background: #eff6ff; color: #2563eb; }
    .stat-icon.orange { background: #fff7ed; color: #ea580c; }
    .stat-icon.green { background: #f0fdf4; color: #16a34a; }
    .stat-icon.purple { background: #faf5ff; color: #9333ea; }

    .stat-info h3 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .stat-info p {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    .card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        margin-bottom: 24px;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .card-header h2 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header h2 i {
        color: #2563eb;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 12px 16px;
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }

    .custom-table td {
        padding: 14px 16px;
        font-size: 13.5px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        display: inline-block;
    }

    .badge-pending { background: #fef3c7; color: #b45309; }
    .badge-approved { background: #dcfce7; color: #15803d; }
    .badge-rejected { background: #fee2e2; color: #b91c1c; }

    .btn-action {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-approve { background: #16a34a; color: #ffffff; }
    .btn-approve:hover { background: #15803d; }

    .btn-reject { background: #dc2626; color: #ffffff; }
    .btn-reject:hover { background: #b91c1c; }

    .quick-links {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .quick-link-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        text-decoration: none;
        color: #0f172a;
        font-weight: 700;
        font-size: 13px;
        transition: all 0.2s;
    }

    .quick-link-item:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #2563eb;
    }

    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .content-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<!-- Statistik SDM Top Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalGuru }}</h3>
            <p>Total Pendidik & SDM</p>
        </div>
    </div>

    <div class="stat-card orange">
        <div class="stat-icon orange">
            <i class="fa-solid fa-hourglass-half"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $countPendingApproval }}</h3>
            <p>Izin Menunggu Waka SDM</p>
        </div>
    </div>

    <div class="stat-card green">
        <div class="stat-icon green">
            <i class="fa-solid fa-user-check"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $guruHadirHariIni }}</h3>
            <p>Guru Hadir Mengajar Hari Ini</p>
        </div>
    </div>

    <div class="stat-card purple">
        <div class="stat-icon purple">
            <i class="fa-solid fa-user-clock"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $guruIzinHariIni }}</h3>
            <p>Guru Izin Tidak Hadir</p>
        </div>
    </div>
</div>

<div class="content-grid">
    <!-- Antrean Persetujuan Izin Guru -->
    <div>
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fa-solid fa-clipboard-question"></i>
                    Pengajuan Izin Guru (Menunggu Approval Waka SDM)
                </h2>
                <a href="{{ route('waka-sdm.persetujuan-izin') }}" style="font-size: 12.5px; font-weight: 700; color: #2563eb; text-decoration: none;">
                    Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama Guru</th>
                            <th>Tanggal Izin</th>
                            <th>Kategori / Alasan</th>
                            <th>Status Waka SDM</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingGuruIzin as $izin)
                            <tr>
                                <td>
                                    <strong>{{ $izin->guru->nama_guru ?? 'Guru' }}</strong>
                                    <div style="font-size: 11px; color: #64748b;">NIP: {{ $izin->guru->nip ?? '-' }}</div>
                                </td>
                                <td>{{ $izin->tanggal_formatted }}</td>
                                <td>
                                    <div style="font-weight: 700;">{{ $izin->kategori_izin ?? 'Izin' }}</div>
                                    <span style="font-size: 12px; color: #64748b;">{{ Str::limit($izin->alasan, 35) }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-pending">Pending Waka SDM</span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <form action="{{ route('waka-sdm.izin.approve', $izin->id_guru_izin) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-approve" onclick="return confirm('Setujui izin guru ini?')">
                                                <i class="fa-solid fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('waka-sdm.izin.reject', $izin->id_guru_izin) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-reject" onclick="return confirm('Tolak izin guru ini?')">
                                                <i class="fa-solid fa-xmark"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 30px;">
                                    <i class="fa-solid fa-circle-check" style="font-size: 32px; color: #22c55e; margin-bottom: 8px; display: block;">
                                    </i>
                                    Tidak ada antrean pengajuan izin yang menunggu persetujuan Waka SDM saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Riwayat Pengajuan Izin Terbaru -->
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    Riwayat Persetujuan Izin Guru Terakhir
                </h2>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Guru</th>
                            <th>Tanggal</th>
                            <th>Waka Kur</th>
                            <th>Waka SDM</th>
                            <th>Kepsek</th>
                            <th>Status Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPengajuan as $r)
                            <tr>
                                <td>{{ $r->guru->nama_guru ?? 'Guru' }}</td>
                                <td>{{ $r->tanggal_formatted }}</td>
                                <td>
                                    @if($r->status_waka === 'approved')
                                        <span class="badge badge-approved">Approved</span>
                                    @elseif($r->status_waka === 'rejected')
                                        <span class="badge badge-rejected">Rejected</span>
                                    @else
                                        <span class="badge badge-pending">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($r->status_waka_sdm === 'approved')
                                        <span class="badge badge-approved">Approved</span>
                                    @elseif($r->status_waka_sdm === 'rejected')
                                        <span class="badge badge-rejected">Rejected</span>
                                    @else
                                        <span class="badge badge-pending">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($r->status_kepsek === 'approved')
                                        <span class="badge badge-approved">Approved</span>
                                    @elseif($r->status_kepsek === 'rejected')
                                        <span class="badge badge-rejected">Rejected</span>
                                    @else
                                        <span class="badge badge-pending">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($r->status_final === 'approved')
                                        <span class="badge badge-approved">Disetujui Resmi</span>
                                    @elseif($r->status_final === 'rejected')
                                        <span class="badge badge-rejected">Ditolak</span>
                                    @else
                                        <span class="badge badge-pending">Dalam Proses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada riwayat persetujuan izin.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Navigation & Broadcast Info -->
    <div>
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fa-solid fa-bolt"></i>
                    Akses Cepat SDM
                </h2>
            </div>
            <div class="quick-links">
                <a href="{{ route('waka-sdm.persetujuan-izin') }}" class="quick-link-item">
                    <span><i class="fa-solid fa-clipboard-check" style="color: #2563eb; margin-right: 8px;"></i> Persetujuan Izin Guru</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #94a3b8;"></i>
                </a>
                <a href="{{ route('waka-sdm.kehadiran-guru') }}" class="quick-link-item">
                    <span><i class="fa-solid fa-calendar-check" style="color: #16a34a; margin-right: 8px;"></i> Monitoring Kehadiran Guru</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #94a3b8;"></i>
                </a>
                <a href="{{ route('waka-sdm.data-guru') }}" class="quick-link-item">
                    <span><i class="fa-solid fa-users-gear" style="color: #9333ea; margin-right: 8px;"></i> Direktori Pendidik & SDM</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #94a3b8;"></i>
                </a>
                <a href="{{ route('waka-sdm.pengumuman') }}" class="quick-link-item">
                    <span><i class="fa-solid fa-bullhorn" style="color: #ea580c; margin-right: 8px;"></i> Broadcast Pengumuman SDM</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #94a3b8;"></i>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fa-solid fa-bullhorn"></i>
                    Pengumuman Sekolah
                </h2>
            </div>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @forelse($pengumumanTerbaru as $p)
                    <div style="padding: 12px; background: #f8fafc; border-radius: 10px; border-left: 3px solid #3b82f6;">
                        <h4 style="font-size: 13px; font-weight: 700; color: #0f172a;">{{ $p->judul }}</h4>
                        <p style="font-size: 12px; color: #64748b; margin-top: 4px;">{{ Str::limit($p->isi, 60) }}</p>
                    </div>
                @empty
                    <p style="font-size: 12.5px; color: #94a3b8; text-align: center; padding: 10px;">Belum ada pengumuman.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
