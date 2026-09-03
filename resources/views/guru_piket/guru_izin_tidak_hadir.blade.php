@extends('layouts.guru')

@section('title', 'Guru Izin Tidak Hadir — EDU JOURNAL')

@section('styles')
<style>
    /* Container Page Fitting Fixes - Prevent Horizontal Page Scrollbar */
    .guru-izin-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    /* Dashboard Page Header Style (Matching Dashboard Guru Piket) */
    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
        width: 100%;
    }

    .header-left h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0;
    }

    .header-left p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .btn-action-primary {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-action-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-1px);
        color: #ffffff;
    }

    /* Stats Grid Cards - Fitted */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
        width: 100%;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 16px 18px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        gap: 14px;
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon.green { background: #dcfce7; color: #16a34a; }
    .stat-icon.blue  { background: #dbeafe; color: #2563eb; }
    .stat-icon.purple{ background: #f3e8ff; color: #9333ea; }
    .stat-icon.amber { background: #fef3c7; color: #d97706; }

    .stat-info h3 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }
    .stat-info p {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Filter Bar Responsive Fitting */
    .filter-bar-container {
        padding: 12px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        width: 100%;
        box-sizing: border-box;
    }

    .filter-bar-container form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-input {
        padding: 7px 12px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 12px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: border-color 0.15s ease;
        flex: 1 1 130px;
        min-width: 110px;
        max-width: 100%;
        box-sizing: border-box;
    }

    .filter-input-search {
        flex: 1.5 1 170px;
        min-width: 140px;
    }

    .btn-filter-dark {
        background: #384972;
        color: #ffffff;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-filter-dark:hover { background: #2b3957; color: #ffffff; }

    .btn-reset-light {
        background: #e2e8f0;
        color: #475569;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #0f172a; }

    .btn-trash-pink {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-trash-pink:hover { background: #fca5a5; color: #7f1d1d; }

    /* Main Table Container */
    .table-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .table-responsive {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
        text-align: left;
    }

    .custom-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 10.5px;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .custom-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
    }

    .custom-table tr:hover td {
        background: #f8fafc;
    }

    /* Styling Row Selesai / Expired */
    .row-expired td {
        background: #f8fafc;
        color: #64748b;
    }
    .row-expired .guru-name {
        color: #475569;
    }

    /* User Profile & Badges */
    .guru-profile-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .guru-avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #e0e7ff;
        color: #3730a3;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }
    .guru-avatar-circle.expired {
        background: #e2e8f0;
        color: #64748b;
    }
    .guru-name {
        font-weight: 700;
        color: #0f172a;
        font-size: 13px;
    }
    .guru-nip {
        font-size: 11px;
        color: #64748b;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 10.5px;
        font-weight: 700;
    }
    .badge-approved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-cuti     { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .badge-biasa    { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    .badge-assigned { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .badge-pending  { background: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
    
    /* Badges Status Masa Berlaku */
    .badge-active   { background: #10b981; color: #ffffff; border: 1px solid #059669; }
    .badge-expired  { background: #94a3b8; color: #ffffff; border: 1px solid #64748b; }

    /* Action Buttons Horizontal Layout */
    .action-button-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        flex-wrap: nowrap;
    }

    .btn-action-icon {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-assign { background: #2563eb; color: #ffffff; }
    .btn-assign:hover { background: #1d4ed8; color: #ffffff; }
    .btn-detail { background: #e2e8f0; color: #334155; border: 1px solid #cbd5e1; }
    .btn-detail:hover { background: #cbd5e1; color: #0f172a; }
    .btn-delete { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .btn-delete:hover { background: #fca5a5; color: #7f1d1d; }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-box {
        background: #ffffff;
        border-radius: 20px;
        width: 90%;
        max-width: 650px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 24px;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        transform: scale(0.95);
        transition: transform 0.2s ease;
    }
    .modal-overlay.active .modal-box {
        transform: scale(1);
    }
    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 14px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 16px;
    }
    .modal-header h3 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }
    .modal-close {
        background: #f1f5f9;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 16px;
        color: #64748b;
        cursor: pointer;
    }
    .modal-close:hover { background: #e2e8f0; color: #0f172a; }
</style>
@endsection

@section('content')
<div class="guru-izin-container">

    <!-- Flash Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success" style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 12px; margin-bottom: 18px; font-weight: 600; display: flex; align-items: center; gap: 8px; font-size: 13px;">
            <i class="fa-solid fa-circle-check" style="font-size: 16px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Konsisten Dashboard Page Header -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Guru Izin Tidak Hadir</h1>
            <p>Daftar resmi seluruh guru yang izin, sakit, atau cuti yang telah disetujui oleh Waka Kurikulum & SDM dan Kepala Sekolah</p>
        </div>
        <div class="header-actions-group">
            <a href="{{ route('piket.guru-pengganti') }}" class="btn-action-primary">
                <i class="fa-solid fa-user-plus"></i> Tambah Penugasan Guru Pengganti
            </a>
        </div>
    </div>

    <!-- 4 Stat Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['totalApproved'] }} Guru</h3>
                <p>Total Izin Disetujui</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['approvedHariIni'] }} Guru</h3>
                <p>Izin Tidak Hadir Hari Ini</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fa-solid fa-hospital-user"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['totalCutiApproved'] }} Pengajuan</h3>
                <p>Kategori Cuti (>3 Hari)</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon amber">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['perluPenugasanCount'] }} Perlu Pengganti</h3>
                <p>Izin Aktif Belum Ada Pengganti</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="table-card" style="margin-bottom: 20px;">
        <div class="filter-bar-container">
            <form action="{{ route('piket.guru-izin-tidak-hadir') }}" method="GET">
                <input type="text" name="q" value="{{ $search }}" class="filter-input filter-input-search" placeholder="🔍 Cari Nama Guru, NIP, Alasan...">
                
                <select name="kategori" class="filter-input">
                    <option value="">-- Kategori --</option>
                    <option value="biasa" {{ $kategoriFilter == 'biasa' ? 'selected' : '' }}>Izin Biasa (≤ 3 Hari)</option>
                    <option value="cuti" {{ $kategoriFilter == 'cuti' ? 'selected' : '' }}>Cuti (> 3 Hari)</option>
                </select>

                <select name="status_berlaku" class="filter-input">
                    <option value="">-- Status Berlaku --</option>
                    <option value="aktif" {{ isset($statusBerlakuFilter) && $statusBerlakuFilter == 'aktif' ? 'selected' : '' }}>🟢 Aktif</option>
                    <option value="selesai" {{ isset($statusBerlakuFilter) && $statusBerlakuFilter == 'selesai' ? 'selected' : '' }}>⚪ Selesai</option>
                </select>

                <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-input">

                <select name="status_penugasan" class="filter-input">
                    <option value="">-- Status Guru Pengganti --</option>
                    <option value="belum" {{ $statusPenugasanFilter == 'belum' ? 'selected' : '' }}>⚠️ Belum Ditugaskan</option>
                    <option value="sudah" {{ $statusPenugasanFilter == 'sudah' ? 'selected' : '' }}>✅ Sudah Ditugaskan</option>
                </select>

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>

                <a href="{{ route('piket.guru-izin-tidak-hadir') }}" class="btn-reset-light">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>

                <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" style="background: #ef4444; color: #ffffff; padding: 9px 16px; border-radius: 8px; font-size: 12.5px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; opacity: 0.5; pointer-events: none; transition: all 0.2s ease; white-space: nowrap; width: auto; height: auto;" title="Hapus Data Terpilih">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                </button>

                <!-- Tombol Sampah diletakkan di sebelah kanan tombol Reset -->
                <a href="{{ route('piket.guru-izin-tidak-hadir.trash') }}" class="btn-trash-pink" style="margin-left: auto;">
                    <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashedCount }})
                </a>
            </form>
        </div>

        <!-- Main Data Table -->
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="width: 16px; height: 16px; cursor: pointer;">
                        </th>
                        <th style="width: 40px;">NO</th>
                        <th>GURU TIDAK HADIR</th>
                        <th>TANGGAL & KATEGORI</th>
                        <th>ALASAN & TITIPAN MATERI</th>
                        <th>STATUS PERSETUJUAN</th>
                        <th>PENUGASAN PENGGANTI</th>
                        <th>STATUS BERLAKU</th>
                        <th style="text-align: center; width: 230px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruIzinApprovedList as $index => $item)
                        <tr class="{{ $item->is_expired ? 'row-expired' : '' }}">
                            <td style="text-align: center;">
                                <input type="checkbox" class="guru-izin-checkbox" value="{{ $item->id_guru_izin }}" onchange="updateSelectedState()" style="width: 16px; height: 16px; cursor: pointer;">
                            </td>
                            <td><strong>{{ $index + 1 }}</strong></td>
                            <td>
                                <div class="guru-profile-box">
                                    <div class="guru-avatar-circle {{ $item->is_expired ? 'expired' : '' }}">
                                        {{ strtoupper(substr($item->guru->nama_guru ?? 'G', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="guru-name">{{ $item->guru->nama_guru ?? 'Guru' }}</div>
                                        <div class="guru-nip">NIP: {{ $item->guru->nip ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;">
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}
                                    @if($item->tanggal_mulai !== $item->tanggal_selesai)
                                        s/d {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}
                                    @endif
                                </div>
                                <div style="margin-top: 4px;">
                                    @if($item->kategori_izin === 'cuti')
                                        <span class="badge-status badge-cuti">
                                            <i class="fa-solid fa-umbrella-beach"></i> Cuti / Izin Khusus
                                        </span>
                                    @else
                                        <span class="badge-status badge-biasa">
                                            <i class="fa-solid fa-calendar-check"></i> Izin Biasa
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">
                                    {{ Str::limit($item->alasan, 40) }}
                                </div>
                                @if($item->materi_dititipkan || $item->tugas_dititipkan)
                                    <div style="margin-top: 3px; font-size: 10.5px; color: #166534; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-book-bookmark"></i>Ada Titipan Materi/Tugas
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 3px;">
                                    <span class="badge-status badge-approved">
                                        <i class="fa-solid fa-circle-check"></i> Waka: Disetujui
                                    </span>
                                    <span class="badge-status badge-approved">
                                        <i class="fa-solid fa-circle-check"></i> Kepsek: Disetujui
                                    </span>
                                </div>
                            </td>
                            <td>
                                @if($item->has_penugasan)
                                    <span class="badge-status badge-assigned">
                                        <i class="fa-solid fa-user-check"></i> Sudah Ditugaskan
                                    </span>
                                    <div style="font-size: 10.5px; color: #475569; margin-top: 3px; font-weight: 600;">
                                        Guru Pengganti: {{ $item->penugasans_list->first()->guruPengganti->nama_guru ?? '-' }}
                                    </div>
                                @else
                                    <span class="badge-status badge-pending">
                                        <i class="fa-solid fa-triangle-exclamation"></i> Belum Ditugaskan
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($item->is_expired)
                                    <span class="badge-status badge-expired">
                                        <i class="fa-solid fa-circle-check"></i> Selesai
                                    </span>
                                @else
                                    <span class="badge-status badge-active">
                                        <i class="fa-solid fa-circle-play"></i> Aktif
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div class="action-button-group">
                                    @if(!$item->is_expired)
                                        <a href="{{ route('piket.guru-pengganti', ['id_guru_tidak_hadir' => $item->id_guru]) }}" class="btn-action-icon btn-assign" title="Tugaskan Guru Pengganti">
                                            <i class="fa-solid fa-user-plus"></i> Tugaskan
                                        </a>
                                    @endif

                                    <button type="button" class="btn-action-icon btn-detail" onclick="openDetailModal({{ json_encode($item) }})" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>

                                    <!-- Tombol Hapus diletakkan paling kanan dengan teks keterangan Hapus -->
                                    <form action="{{ route('piket.guru-izin-tidak-hadir.destroy', $item->id_guru_izin) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan data guru izin ini ke sampah?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-icon btn-delete" title="Hapus Data">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                                <i class="fa-solid fa-clipboard-user" style="font-size: 40px; margin-bottom: 12px; color: #cbd5e1; display: block;"></i>
                                <strong style="font-size: 15px; color: #475569;">Belum Ada Data Guru Izin Tidak Hadir yang Disetujui</strong>
                                <p style="font-size: 12.5px; margin-top: 4px;">Seluruh pengajuan izin yang disetujui Waka & Kepsek akan muncul otomatis di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Permohonan Izin Guru Disetujui -->
<div id="modalDetailIzin" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-circle-info" style="color: #2563eb;"></i> Detail Guru Izin Tidak Hadir</h3>
            <button class="modal-close" onclick="closeDetailModal()">&times;</button>
        </div>
        <div id="modalDetailContent" style="display: flex; flex-direction: column; gap: 14px; font-size: 13px;">
            <!-- Content Populated via JavaScript -->
        </div>
        <div style="margin-top: 18px; text-align: right; border-top: 1px solid #e2e8f0; padding-top: 12px;">
            <button class="btn-reset-light" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openDetailModal(item) {
        let statusMasaHtml = item.is_expired 
            ? `<span class="badge-status badge-expired"><i class="fa-solid fa-circle-check"></i> Masa Berlaku Selesai</span>`
            : `<span class="badge-status badge-active"><i class="fa-solid fa-circle-play"></i> Masa Berlaku Aktif</span>`;

        let contentHtml = `
            <div style="background: #f8fafc; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div>
                    <div style="font-size: 15px; font-weight: 800; color: #0f172a;">${item.guru ? item.guru.nama_guru : 'Guru'}</div>
                    <div style="color: #64748b; font-weight: 600;">NIP: ${item.guru ? (item.guru.nip || '-') : '-'}</div>
                </div>
                <div>${statusMasaHtml}</div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div style="background: #f1f5f9; padding: 10px 12px; border-radius: 10px;">
                    <span style="font-size: 10.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Mulai Izin</span>
                    <div style="font-weight: 800; color: #0f172a; font-size: 13px;">${item.tanggal_mulai}</div>
                </div>
                <div style="background: #f1f5f9; padding: 10px 12px; border-radius: 10px;">
                    <span style="font-size: 10.5px; color: #64748b; font-weight: 700; text-transform: uppercase;">Selesai Izin</span>
                    <div style="font-weight: 800; color: #0f172a; font-size: 13px;">${item.tanggal_selesai}</div>
                </div>
            </div>

            <div>
                <strong style="color: #475569;">Alasan Izin / Sakit / Cuti:</strong>
                <div style="background: #ffffff; border: 1px solid #cbd5e1; padding: 10px; border-radius: 8px; margin-top: 4px; color: #0f172a; font-weight: 600;">
                    ${item.alasan || '-'}
                </div>
            </div>
        `;

        if (item.keterangan_khusus) {
            contentHtml += `
                <div>
                    <strong style="color: #475569;">Keterangan Khusus:</strong>
                    <div style="background: #fffbebfb; border: 1px solid #fde68a; padding: 10px; border-radius: 8px; margin-top: 4px; color: #92400e;">
                        ${item.keterangan_khusus}
                    </div>
                </div>
            `;
        }

        // PRATINJAU FOTO SURAT / DOKUMEN BUKTI CUTI
        if (item.foto_url) {
            contentHtml += `
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px;">
                    <strong style="color: #334155; display: block; margin-bottom: 6px;">
                        <i class="fa-solid fa-file-image" style="color: #2563eb;"></i> Unggahan Foto Surat / Dokumen Bukti Izin / Cuti:
                    </strong>
                    <div style="text-align: center; background: #f8fafc; padding: 10px; border-radius: 10px; border: 1px dashed #cbd5e1;">
                        <img src="${item.foto_url}" alt="Foto Surat Bukti Izin" style="max-width: 100%; max-height: 280px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); object-fit: contain;">
                        <div style="margin-top: 8px;">
                            <a href="${item.foto_url}" target="_blank" class="btn-action-icon btn-detail" style="display: inline-flex; text-decoration: none;">
                                <i class="fa-solid fa-up-right-from-square"></i> Lihat Foto Ukuran Penuh
                            </a>
                        </div>
                    </div>
                </div>
            `;
        } else {
            contentHtml += `
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px; color: #64748b; font-size: 12px;">
                    <i class="fa-solid fa-circle-info" style="color: #94a3b8;"></i> Tidak ada unggahan foto surat / dokumen khusus untuk pengajuan ini.
                </div>
            `;
        }

        // FILE TUGAS DITITIPKAN
        if (item.file_tugas_url) {
            contentHtml += `
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 10px 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <strong style="color: #1e40af;"><i class="fa-solid fa-file-arrow-down"></i> File Tugas Titipan Guru:</strong>
                        <div style="font-size: 11.5px; color: #1e3a8a; margin-top: 2px;">${item.file_tugas || 'Lampiran Tugas'}</div>
                    </div>
                    <a href="${item.file_tugas_url}" target="_blank" class="btn-action-icon btn-assign" style="text-decoration: none;">
                        <i class="fa-solid fa-download"></i> Unduh File Tugas
                    </a>
                </div>
            `;
        }

        if (item.materi_dititipkan || item.tugas_dititipkan) {
            contentHtml += `
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 10px 12px; border-radius: 10px;">
                    <strong style="color: #166534;"><i class="fa-solid fa-book"></i> Titipan Pembelajaran:</strong>
                    <div style="margin-top: 4px; color: #15803d; font-size: 12px;">
                        <div><strong>Materi:</strong> ${item.materi_dititipkan || '-'}</div>
                        <div style="margin-top: 2px;"><strong>Tugas:</strong> ${item.tugas_dititipkan || '-'}</div>
                    </div>
                </div>
            `;
        }

        contentHtml += `
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px 12px; border-radius: 10px;">
                <strong style="color: #334155;"><i class="fa-solid fa-shield-check" style="color: #16a34a;"></i> Bukti Kelayakan Persetujuan:</strong>
                <div style="display: flex; gap: 8px; margin-top: 6px;">
                    <span class="badge-status badge-approved">✓ Waka Kurikulum (Disetujui)</span>
                    <span class="badge-status badge-approved">✓ Kepala Sekolah (Disetujui)</span>
                </div>
            </div>
        `;

        document.getElementById('modalDetailContent').innerHTML = contentHtml;
        document.getElementById('modalDetailIzin').classList.add('active');
    }

    function closeDetailModal() {
        document.getElementById('modalDetailIzin').classList.remove('active');
    }

    // Fitur Checkbox & Hapus Massal Guru Izin Tidak Hadir
    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.guru-izin-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
        });
        updateSelectedState();
    }

    function updateSelectedState() {
        const checkboxes = document.querySelectorAll('.guru-izin-checkbox');
        const checkedBoxes = document.querySelectorAll('.guru-izin-checkbox:checked');
        const btnBulk = document.getElementById('btnBulkDelete');
        const selectedCountSpan = document.getElementById('selectedCount');
        const selectAllCb = document.getElementById('selectAllCheckbox');

        const count = checkedBoxes.length;
        if (selectedCountSpan) selectedCountSpan.textContent = count;

        if (selectAllCb && checkboxes.length > 0) {
            selectAllCb.checked = (checkboxes.length === count);
        }

        if (btnBulk) {
            if (count > 0) {
                btnBulk.style.opacity = '1';
                btnBulk.style.pointerEvents = 'auto';
            } else {
                btnBulk.style.opacity = '0.5';
                btnBulk.style.pointerEvents = 'none';
            }
        }
    }

    function confirmBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.guru-izin-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Silakan pilih minimal satu data guru izin yang mau dihapus.');
            return;
        }

        document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
        document.getElementById('bulkDeleteModal').style.display = 'flex';
    }

    function closeBulkDeleteModal() {
        document.getElementById('bulkDeleteModal').style.display = 'none';
    }

    function executeBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.guru-izin-checkbox:checked');
        const container = document.getElementById('bulkDeleteInputsContainer');
        container.innerHTML = '';

        checkedBoxes.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });

        document.getElementById('bulkDeleteForm').submit();
    }
</script>

<!-- Form Hidden untuk Hapus Massal Guru Izin Tidak Hadir -->
<form id="bulkDeleteForm" action="{{ route('piket.guru-izin-tidak-hadir.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="bulkDeleteInputsContainer"></div>
</form>

<!-- Modal Konfirmasi Hapus Massal Guru Izin Tidak Hadir -->
<div id="bulkDeleteModal" class="modal-backdrop-custom" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; z-index: 9999; padding: 20px;">
    <div class="modal-card" style="background: #ffffff; border-radius: 16px; width: 100%; max-width: 450px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden;">
        <div class="modal-header" style="padding: 18px 24px; background: #ef4444; color: #ffffff; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800;"><i class="fa-solid fa-triangle-exclamation"></i> Konfirmasi Hapus Massal</h3>
            <i class="fa-solid fa-xmark" onclick="closeBulkDeleteModal()" style="cursor: pointer; font-size: 18px;"></i>
        </div>
        <div class="modal-body" style="text-align: center; padding: 24px;">
            <div style="width: 60px; height: 60px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #ef4444; font-size: 28px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Pindahkan ke Sampah?</h4>
            <p style="font-size: 13.5px; color: #64748b; font-weight: 600; margin-bottom: 20px; line-height: 1.5;">
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #ef4444;">0</strong> data guru izin tidak hadir yang dipilih ke fitur Sampah?
            </p>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" onclick="closeBulkDeleteModal()" class="btn-reset-light" style="padding: 10px 20px; font-size: 13px; font-weight: 700;">
                    Batal
                </button>
                <button type="button" onclick="executeBulkDelete()" style="padding: 10px 24px; font-size: 13px; font-weight: 800; background: #ef4444; color: #ffffff; border: none; border-radius: 8px; cursor: pointer;">
                    <i class="fa-solid fa-trash"></i> Ya, Hapus Terpilih
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
