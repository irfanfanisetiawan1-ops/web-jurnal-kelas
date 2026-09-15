@extends('layouts.guru')

@section('title', 'Surat Dispen Siswa — EDU JOURNAL')
@section('header_title', 'Surat Dispen Siswa')

@section('styles')
<style>
    /* Main Layout */
    .dispen-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .page-header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 4px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-title-group h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title-group p {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
        margin: 0;
    }

    /* Stat Cards Grid (4 Kolom) */
    .stat-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    @media (max-width: 1100px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .stat-grid-4 { grid-template-columns: 1fr; }
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #cbd5e1;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.05);
    }

    .stat-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon-blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon-emerald{ background: #ecfdf5; color: #059669; }
    .stat-icon-purple { background: #ede9fe; color: #7c3aed; }
    .stat-icon-amber  { background: #fffbeb; color: #d97706; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 11.5px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.2;
    }

    /* Subnav Tab Bar */
    .subnav-tabs-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        padding: 8px 12px;
        border-radius: 14px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        overflow-x: auto;
    }

    .subnav-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        background: transparent;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .subnav-tab-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .subnav-tab-btn.active {
        background: #384972;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(56, 73, 114, 0.25);
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #cbd5e1;
    }

    .filter-grid {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-input {
        padding: 9px 14px;
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        color: #1e293b;
        font-weight: 600;
        transition: border-color 0.2s, background 0.2s;
    }

    .filter-input:focus {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-dark {
        background: #384972;
        color: #ffffff;
        padding: 9px 18px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-filter-dark:hover { background: #2b3957; }

    .btn-reset-light {
        background: #f1f5f9;
        color: #475569;
        padding: 9px 15px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-reset-light:hover { background: #e2e8f0; color: #0f172a; }

    /* Selection Toolbar Bar */
    .selection-toolbar-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        padding: 10px 16px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        margin-top: -6px;
    }

    /* Dispen Cards Grid */
    .dispen-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(370px, 1fr));
        gap: 18px;
    }

    .dispen-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #cbd5e1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
    }

    .dispen-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        border-color: #94a3b8;
    }

    .dispen-card.selected {
        border-color: #2563eb;
        background: #f0f7ff;
    }

    .dispen-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        gap: 8px;
        flex-wrap: wrap;
    }

    .badge-approved {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 9px;
        border-radius: 20px;
    }

    .badge-role-tag {
        font-size: 10.5px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 7px;
    }

    .tag-wali {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .tag-mengajar {
        background: #faf5ff;
        color: #7e22ce;
        border: 1px solid #e9d5ff;
    }

    .student-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .student-avatar {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        background: linear-gradient(135deg, #384972 0%, #1e293b 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .student-info h3 {
        font-size: 14.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 2px 0;
        line-height: 1.25;
    }

    .student-info p {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        margin: 0;
    }

    .dispen-details-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        margin-bottom: 12px;
        display: flex;
        flex-direction: column;
        gap: 7px;
        font-size: 12.5px;
    }

    .detail-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .detail-label {
        color: #64748b;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .detail-val {
        color: #1e293b;
        font-weight: 700;
    }

    .alasan-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 12px;
        color: #334155;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .ttd-box-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 14px;
    }

    .ttd-card {
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        background: #f8fafc;
        padding: 8px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 75px;
    }

    .ttd-card span {
        font-size: 10px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .ttd-img {
        max-height: 48px;
        max-width: 100%;
        object-fit: contain;
    }

    .card-footer-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        gap: 8px;
    }

    .btn-card-action {
        padding: 8px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-card-print {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .btn-card-print:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-card-detail {
        background: #384972;
        color: #ffffff;
        border: none;
    }
    .btn-card-detail:hover {
        background: #2563eb;
    }

    .btn-card-delete {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
        padding: 8px 10px;
        border-radius: 9px;
        font-size: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .btn-card-delete:hover {
        background: #ef4444;
        color: #ffffff;
    }

    .custom-checkbox {
        width: 18px;
        height: 18px;
        border-radius: 5px;
        cursor: pointer;
        accent-color: #2563eb;
    }

    /* Floating Batch Toolbar */
    .floating-batch-bar {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(120px);
        background: #0f172a;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        z-index: 999;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .floating-batch-bar.show {
        transform: translateX(-50%) translateY(0);
    }

    /* Modal Backdrop */
    .modal-backdrop-custom {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 16px;
    }
    .modal-box-custom {
        background: #ffffff;
        border-radius: 20px;
        max-width: 580px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        overflow: hidden;
        animation: modalScaleIn 0.2s ease;
    }
    @keyframes modalScaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Official Letter Format Inside Modal */
    .surat-official-paper {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 22px 26px;
        font-family: 'Times New Roman', Times, serif;
        color: #000000;
        line-height: 1.45;
        font-size: 13px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 18px;
    }
    .surat-kop-header {
        text-align: center;
        line-height: 1.25;
    }
    .surat-kop-header h2 { font-size: 13px; font-weight: 700; margin: 0; text-transform: uppercase; }
    .surat-kop-header h1 { font-size: 15px; font-weight: 900; margin: 2px 0; text-transform: uppercase; }
    .surat-kop-header p { font-size: 10.5px; margin: 2px 0 0 0; color: #333; }
    .surat-kop-divider {
        border-top: 2.5px double #000;
        margin: 8px 0 14px 0;
    }
    .surat-doc-title {
        text-align: center;
        margin-bottom: 14px;
    }
    .surat-doc-title h3 {
        font-size: 14px;
        font-weight: 900;
        text-decoration: underline;
        margin: 0 0 2px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .surat-doc-title .nomor {
        font-size: 11.5px;
        font-weight: normal;
    }
    .surat-table-data {
        width: 100%;
        margin: 8px 0 12px 0;
        border-collapse: collapse;
        font-size: 12.5px;
    }
    .surat-table-data td {
        padding: 2px 0;
        vertical-align: top;
    }
    .surat-table-data td.label-col {
        width: 150px;
        font-weight: bold;
    }
    .surat-table-data td.colon {
        width: 12px;
    }
    .surat-sign-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1.2fr;
        gap: 10px;
        margin-top: 18px;
        text-align: center;
        font-size: 11.5px;
    }
    .surat-sign-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        min-height: 100px;
    }
</style>
@endsection

@section('content')
<div class="dispen-container">

    <!-- Flash Feedback -->
    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 13.5px;">
                <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #10b981;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; color: #065f46; cursor: pointer;">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 13.5px;">
                <i class="fa-solid fa-circle-xmark" style="font-size: 18px; color: #ef4444;"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; color: #991b1b; cursor: pointer;">&times;</button>
        </div>
    @endif

    <!-- Header & Page Actions -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>
                <i class="fa-solid fa-file-signature" style="color: #2563eb;"></i>
                Surat Dispen Siswa
            </h1>
            <p>Daftar surat dispensasi siswa resmi lengkap dengan lembar surat pengesahan tanda tangan siswa, guru piket, dan persetujuan Waka Kesiswaan</p>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <!-- Tombol Tempat Sampah -->
            <a href="{{ route('guru.surat-dispen.trash') }}" class="btn-reset-light" style="position: relative;" title="Buka Tempat Sampah">
                <i class="fa-solid fa-trash-can" style="color: #ef4444;"></i> Tempat Sampah
                @if(($trashedCount ?? 0) > 0)
                    <span style="background: #ef4444; color: #ffffff; font-size: 11px; font-weight: 800; padding: 2px 7px; border-radius: 20px; margin-left: 4px;">
                        {{ $trashedCount }}
                    </span>
                @endif
            </a>

            <!-- Tombol Tandai Semua Dibaca -->
            <form method="POST" action="{{ route('guru.surat-dispen.mark-all-read') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-filter-dark" style="background: #10b981;">
                    <i class="fa-solid fa-check-double"></i> Tandai Semua Dibaca
                </button>
            </form>
        </div>
    </div>

    <!-- 4 Summary Stat Cards -->
    <div class="stat-grid-4">
        <!-- Total Dispen -->
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-blue">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Total Surat Dispen</span>
                    <span class="stat-val">{{ $stats['total'] ?? 0 }} <small style="font-size: 14px; font-weight: 600; color: #64748b;">Dokumen</small></span>
                </div>
            </div>
        </div>

        <!-- Dispen Hari Ini -->
        <div class="stat-card" style="border-left: 4px solid #10b981;">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-emerald">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Dispen Hari Ini</span>
                    <span class="stat-val" style="color: #059669;">{{ $stats['hariIni'] ?? 0 }} <small style="font-size: 14px; font-weight: 600; color: #64748b;">Siswa</small></span>
                </div>
            </div>
        </div>

        <!-- Kelas Mengajar -->
        <div class="stat-card" style="border-left: 4px solid #7c3aed;">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-purple">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Kelas Mengajar</span>
                    <span class="stat-val" style="color: #7c3aed;">{{ $stats['mengajar'] ?? 0 }} <small style="font-size: 14px; font-weight: 600; color: #64748b;">Siswa</small></span>
                </div>
            </div>
        </div>

        <!-- Kelas Perwalian (Wali) -->
        <div class="stat-card" style="border-left: 4px solid #d97706;">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-amber">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-label">Kelas Perwalian (Wali)</span>
                    <span class="stat-val" style="color: #d97706;">{{ $stats['wali'] ?? 0 }} <small style="font-size: 14px; font-weight: 600; color: #64748b;">Siswa</small></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Subnav Tabs (Scope Filter) -->
    <div class="subnav-tabs-bar">
        <a href="{{ route('guru.surat-dispen', ['tab' => 'semua', 'q' => $search, 'tanggal' => $tanggalFilter, 'id_kelas' => $kelasFilter]) }}" 
           class="subnav-tab-btn {{ ($tab ?? 'semua') === 'semua' ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group"></i> Semua Surat Dispen ({{ $stats['total'] ?? 0 }})
            @if(($unreadCount ?? 0) > 0 && ($tab ?? 'semua') === 'semua')
                <span style="background: #ef4444; color: #fff; font-size: 10px; font-weight: 900; padding: 2px 6px; border-radius: 20px;">
                    {{ $unreadCount }}
                </span>
            @endif
        </a>

        <a href="{{ route('guru.surat-dispen', ['tab' => 'mengajar', 'q' => $search, 'tanggal' => $tanggalFilter, 'id_kelas' => $kelasFilter]) }}" 
           class="subnav-tab-btn {{ ($tab ?? '') === 'mengajar' ? 'active' : '' }}">
            <i class="fa-solid fa-chalkboard-user"></i> Kelas Mengajar Saya ({{ $stats['mengajar'] ?? 0 }})
        </a>

        @if($isWaliKelas && $kelasWali)
            <a href="{{ route('guru.surat-dispen', ['tab' => 'wali', 'q' => $search, 'tanggal' => $tanggalFilter, 'id_kelas' => $kelasFilter]) }}" 
               class="subnav-tab-btn {{ ($tab ?? '') === 'wali' ? 'active' : '' }}">
                <i class="fa-solid fa-user-graduate"></i> Kelas Perwalian: {{ $kelasWali->nama_kelas }} ({{ $stats['wali'] ?? 0 }})
            </a>
        @endif
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <form method="GET" action="{{ route('guru.surat-dispen') }}" class="filter-grid">
            <input type="hidden" name="tab" value="{{ $tab ?? 'semua' }}">

            <!-- Cari Siswa/NISN/Kode -->
            <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari Nama Siswa / NISN / Kode Dispen..." class="filter-input" style="flex: 2; min-width: 220px;">

            <!-- Filter Kelas -->
            <select name="id_kelas" class="filter-input" style="flex: 1; min-width: 140px;">
                <option value="">Semua Kelas</option>
                @foreach($filterKelases as $fk)
                    <option value="{{ $fk->id_kelas }}" {{ ($kelasFilter == $fk->id_kelas) ? 'selected' : '' }}>
                        {{ $fk->nama_kelas }}
                    </option>
                @endforeach
            </select>

            <!-- Filter Tanggal -->
            <input type="date" name="tanggal" value="{{ $tanggalFilter ?? '' }}" class="filter-input" style="flex: 1; min-width: 140px;">

            <!-- Actions -->
            <button type="submit" class="btn-filter-dark">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
            <a href="{{ route('guru.surat-dispen', ['tab' => $tab ?? 'semua']) }}" class="btn-reset-light">
                <i class="fa-solid fa-arrow-rotate-left"></i> Reset
            </a>
        </form>
    </div>

    <!-- Selection Toolbar Bar (Pilih Semua Checkbox) -->
    <div class="selection-toolbar-bar">
        <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #334155; cursor: pointer; user-select: none;">
            <input type="checkbox" id="masterSelectAll" class="custom-checkbox" onchange="toggleSelectAll(this)">
            <span>Pilih Semua Surat (Select All)</span>
        </label>
        <span style="font-size: 12.5px; color: #64748b; font-weight: 600;">
            Menampilkan <strong>{{ count($dispenList) }}</strong> surat dispen aktif
        </span>
    </div>

    <!-- Dispen Cards Grid -->
    <div class="dispen-cards-grid">
        @forelse($dispenList as $item)
            @php
                $isToday = ($item->tanggal == \Carbon\Carbon::now('Asia/Jakarta')->toDateString());
                $nameArr = explode(' ', trim($item->siswa->nama_siswa ?? 'S'));
                $initials = strtoupper(substr($nameArr[0] ?? 'S', 0, 1) . substr($nameArr[1] ?? '', 0, 1));
            @endphp
            <div class="dispen-card" id="card-{{ $item->id_siswa_dispen }}">
                <div>
                    <!-- Top Row: Checkbox, Kode, Tags, Badges & Delete Button -->
                    <div class="dispen-card-top">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <!-- Row Checkbox for Batch Delete -->
                            <input type="checkbox" class="custom-checkbox row-select-checkbox" value="{{ $item->id_siswa_dispen }}" onchange="handleRowCheckboxChange(this)">
                            
                            <span style="font-weight: 800; font-size: 13px; color: #2563eb;">
                                {{ $item->kode_dispen }}
                            </span>
                            @if($item->is_unread)
                                <span style="background: #ef4444; color: #ffffff; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 20px;">
                                    Baru
                                </span>
                            @endif
                        </div>

                        <div style="display: flex; align-items: center; gap: 6px;">
                            @if($item->is_wali_kelas)
                                <span class="badge-role-tag tag-wali"><i class="fa-solid fa-user-graduate"></i> Wali Kelas</span>
                            @endif
                            @if($item->is_guru_mengajar)
                                <span class="badge-role-tag tag-mengajar"><i class="fa-solid fa-chalkboard-user"></i> Mengajar</span>
                            @endif

                            <span class="badge-approved">
                                <i class="fa-solid fa-circle-check"></i> Disetujui Waka
                            </span>

                            <!-- Single Delete Button -->
                            <button type="button" onclick="openModalSingleDelete({{ $item->id_siswa_dispen }}, '{{ $item->kode_dispen }}', '{{ addslashes($item->siswa->nama_siswa ?? 'Siswa') }}')" class="btn-card-delete" title="Pindahkan ke Tempat Sampah">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Student Info Header -->
                    <div class="student-header">
                        <div class="student-avatar">
                            {{ $initials }}
                        </div>
                        <div class="student-info">
                            <h3>{{ $item->siswa->nama_siswa ?? 'Nama Siswa' }}</h3>
                            <p>Kelas: <strong>{{ $item->kelas->nama_kelas ?? ($item->siswa->kelas->nama_kelas ?? '-') }}</strong> • NISN: {{ $item->siswa->nisn ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- KBM Overlap & Schedule Details -->
                    <div class="dispen-details-box">
                        <div class="detail-row">
                            <span class="detail-label"><i class="fa-regular fa-calendar"></i> Tanggal:</span>
                            <span class="detail-val">
                                {{ $item->hari_indo }}, {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                @if($isToday)
                                    <span style="color: #059669; font-weight: 800;">(Hari Ini)</span>
                                @endif
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label"><i class="fa-regular fa-clock"></i> Jam Dispensasi:</span>
                            <span class="detail-val" style="color: #0f172a; font-weight: 800;">
                                {{ substr($item->jam_keluar, 0, 5) }} s/d {{ substr($item->jam_kembali, 0, 5) }} WIB
                            </span>
                        </div>

                        @if($item->is_guru_mengajar && $item->jadwal_terdampak && $item->jadwal_terdampak->isNotEmpty())
                            @php
                                $firstJadwal = $item->jadwal_terdampak->first();
                            @endphp
                            <div class="detail-row" style="background: #fdf4ff; border: 1px solid #f0abfc; padding: 6px 10px; border-radius: 8px; margin-top: 4px;">
                                <span class="detail-label" style="color: #86198f; font-weight: 700;">
                                    <i class="fa-solid fa-book-bookmark"></i> Mapel Mengajar Anda:
                                </span>
                                <span class="detail-val" style="color: #86198f; font-weight: 800;">
                                    {{ $firstJadwal->mapel->nama_mapel ?? 'Mapel' }} (Jam Ke {{ $firstJadwal->jamMulai->jam_ke ?? '?' }}–{{ $firstJadwal->jamSelesai->jam_ke ?? '?' }})
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Alasan / Keperluan -->
                    <div class="alasan-box">
                        <strong style="color: #0f172a; display: block; margin-bottom: 2px;">Alasan / Keperluan Dispensasi:</strong>
                        "{{ $item->alasan }}"
                    </div>

                    <!-- Digital Signatures -->
                    <div class="ttd-box-container">
                        <div class="ttd-card">
                            <span>TTD SISWA</span>
                            @if($item->ttd_siswa)
                                <img src="{{ $item->ttd_siswa }}" alt="TTD Siswa" class="ttd-img">
                            @else
                                <span style="color: #94a3b8; font-style: italic; font-weight: normal; margin-top: 6px;">Digital Verified</span>
                            @endif
                        </div>

                        <div class="ttd-card">
                            <span>TTD GURU PIKET</span>
                            @if($item->ttd_guru_piket)
                                <img src="{{ $item->ttd_guru_piket }}" alt="TTD Guru Piket" class="ttd-img">
                            @else
                                <span style="color: #94a3b8; font-style: italic; font-weight: normal; margin-top: 6px;">Digital Verified</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="card-footer-actions">
                    <div style="font-size: 11.5px; color: #64748b;">
                        Piket: <strong>{{ $item->nama_guru_piket ?: ($item->guruPiketUser->name ?? 'Petugas Piket') }}</strong>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        <!-- Tombol Cetak Lembar Surat -->
                        <a href="{{ route('guru.surat-dispen.cetak', $item->id_siswa_dispen) }}" target="_blank" class="btn-card-action btn-card-print">
                            <i class="fa-solid fa-print"></i> Cetak
                        </a>

                        <!-- Tombol Lihat Detail Modal -->
                        <button type="button" onclick="openModalDetailDispen({{ $item->id_siswa_dispen }})" class="btn-card-action btn-card-detail">
                            <i class="fa-solid fa-file-lines"></i> Lihat Surat
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; background: #ffffff; border-radius: 18px; border: 1px dashed #cbd5e1; padding: 50px 20px; text-align: center;">
                <i class="fa-solid fa-file-circle-check" style="font-size: 42px; color: #cbd5e1; margin-bottom: 12px;"></i>
                <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">Tidak Ada Surat Dispensasi Siswa</h3>
                <p style="font-size: 13px; color: #64748b; margin: 0;">Tidak ada surat dispensasi yang sesuai dengan kriteria filter atau tab yang Anda pilih.</p>
            </div>
        @endforelse
    </div>

</div>

<!-- Floating Batch Action Toolbar -->
<div id="floatingBatchBar" class="floating-batch-bar">
    <div style="font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
        <span id="selectedCountBadge" style="background: #2563eb; color: #fff; padding: 2px 9px; border-radius: 20px; font-size: 12px;">0</span>
        <span>Surat Dispen Terpilih</span>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <button type="button" onclick="openModalBatchDelete()" style="background: #ef4444; color: #fff; border: none; padding: 7px 16px; border-radius: 30px; font-size: 12.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-trash-can"></i> Hapus Terpilih
        </button>
        <button type="button" onclick="uncheckAll()" style="background: rgba(255,255,255,0.2); color: #fff; border: none; padding: 7px 14px; border-radius: 30px; font-size: 12px; font-weight: 700; cursor: pointer;">
            Batal
        </button>
    </div>
</div>

<!-- Forms for Batch & Single Delete -->
<form id="formBatchDelete" method="POST" action="{{ route('guru.surat-dispen.destroy-batch') }}" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="inputBatchDeleteIds">
</form>

<!-- Modal 1: Single Delete Confirmation -->
<div id="modalSingleDelete" class="modal-backdrop-custom">
    <div class="modal-box-custom">
        <div style="padding: 24px; text-align: center;">
            <div style="width: 56px; height: 56px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 8px;">Pindahkan Surat Dispen ke Sampah?</h3>
            <p style="font-size: 13.5px; color: #64748b; margin: 0 0 20px; line-height: 1.5;">
                Surat dispen <strong id="modalDelKode" style="color: #0f172a;"></strong> milik <strong id="modalDelNama" style="color: #0f172a;"></strong> akan dipindahkan ke Tempat Sampah dan dapat dipulihkan kapan saja.
            </p>
            <form id="formSingleDelete" method="POST" action="">
                @csrf
                @method('DELETE')
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" onclick="closeModalSingleDelete()" style="padding: 10px 20px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        Batal
                    </button>
                    <button type="submit" style="padding: 10px 20px; background: #ef4444; color: #ffffff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        Ya, Pindahkan ke Sampah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Batch Delete Confirmation -->
<div id="modalBatchDelete" class="modal-backdrop-custom">
    <div class="modal-box-custom">
        <div style="padding: 24px; text-align: center;">
            <div style="width: 56px; height: 56px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px;">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 8px;">Hapus Data Terpilih ke Sampah?</h3>
            <p style="font-size: 13.5px; color: #64748b; margin: 0 0 20px; line-height: 1.5;">
                Anda akan memindahkan <strong id="batchDeleteCountText" style="color: #ef4444;"></strong> surat dispensasi terpilih ke Tempat Sampah.
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" onclick="closeModalBatchDelete()" style="padding: 10px 20px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; border-radius: 10px; font-weight: 700; cursor: pointer;">
                    Batal
                </button>
                <button type="button" onclick="submitBatchDelete()" style="padding: 10px 20px; background: #ef4444; color: #ffffff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                    Ya, Hapus Terpilih
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: View Detail Dispen Lengkap (Lembar Surat Dispen Resmi & Lampiran Berkas) -->
<div id="modalDetailDispen" class="modal-backdrop-custom">
    <div class="modal-box-custom" style="max-width: 760px;">
        <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; background: #ffffff;">
            <div style="font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-file-contract" style="color: #2563eb;"></i>
                Surat Dispensasi Siswa Resmi
            </div>
            <button type="button" onclick="closeModalDetailDispen()" style="background: none; border: none; font-size: 22px; color: #94a3b8; cursor: pointer;">&times;</button>
        </div>

        <div style="padding: 24px; max-height: 78vh; overflow-y: auto; background: #f8fafc;">
            
            <!-- Dokumen Fisik Surat Dispensasi Resmi (Paper Sheet Format) -->
            <div class="surat-official-paper">
                <!-- Kop Sekolah -->
                <div class="surat-kop-header">
                    <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
                    <h2>DINAS PENDIDIKAN</h2>
                    <h1>SMK NEGERI 1 BOYOLANGU</h1>
                    <p>Jl. Ki Mangunsarkoro No. 1, Boyolangu, Kabupaten Tulungagung | Telp. (0355) 321746 | Email: info@smkn1boyolangu.sch.id</p>
                </div>
                <div class="surat-kop-divider"></div>

                <!-- Judul Dokumen -->
                <div class="surat-doc-title">
                    <h3>SURAT KETERANGAN DISPENSASI SISWA</h3>
                    <div class="nomor">Nomor: <strong id="dtlKode" style="color: #2563eb;"></strong></div>
                </div>

                <!-- Pengantar -->
                <p style="margin: 0 0 10px 0; text-align: justify;">
                    Kepada Yth. Bapak/Ibu Guru Pengajar / Wali Kelas,<br>
                    Dengan ini diterangkan bahwa peserta didik berikut telah diberikan izin/dispensasi resmi meninggalkan kegiatan KBM dengan rincian:
                </p>

                <!-- Tabel Rincian Siswa -->
                <table class="surat-table-data">
                    <tr>
                        <td class="label-col">Nama Siswa</td>
                        <td class="colon">:</td>
                        <td><strong id="dtlNama" style="color: #0f172a; font-size: 13.5px;"></strong></td>
                    </tr>
                    <tr>
                        <td class="label-col">NIS / NISN</td>
                        <td class="colon">:</td>
                        <td><span id="dtlNisNisn"></span></td>
                    </tr>
                    <tr>
                        <td class="label-col">Kelas & Jurusan</td>
                        <td class="colon">:</td>
                        <td><span id="dtlKelasJurusan"></span></td>
                    </tr>
                    <tr>
                        <td class="label-col">Hari, Tanggal</td>
                        <td class="colon">:</td>
                        <td><strong id="dtlTanggal"></strong></td>
                    </tr>
                    <tr>
                        <td class="label-col">Waktu / Jam Izin</td>
                        <td class="colon">:</td>
                        <td><strong id="dtlJam" style="color: #2563eb;"></strong></td>
                    </tr>
                    <tr>
                        <td class="label-col">Keperluan / Alasan</td>
                        <td class="colon">:</td>
                        <td><em id="dtlAlasan" style="color: #1e293b;"></em></td>
                    </tr>
                </table>

                <p style="margin: 10px 0 0 0; text-align: justify; font-size: 12px; color: #333;">
                    Demikian surat dispensasi ini diterbitkan untuk dipergunakan sebagaimana mestinya dan dicatat pada agenda presensi KBM kelas.
                </p>

                <!-- 3 Kolom Tanda Tangan Resmi Pengesahan -->
                <div class="surat-sign-grid">
                    <div class="surat-sign-col">
                        <span>Siswa yang Memohon,</span>
                        <div style="min-height: 48px; display: flex; align-items: center; justify-content: center;">
                            <img id="dtlTtdSiswa" src="" alt="TTD Siswa" style="max-height: 44px; max-width: 100%; object-fit: contain;">
                            <span id="dtlNoTtdSiswa" style="font-size: 10.5px; color: #94a3b8; font-style: italic; display: none;">Tervalidasi Digital</span>
                        </div>
                        <strong id="dtlNamaSignSiswa" style="text-decoration: underline; font-size: 12px;"></strong>
                    </div>

                    <div class="surat-sign-col">
                        <span>Petugas Guru Piket,</span>
                        <div style="min-height: 48px; display: flex; align-items: center; justify-content: center;">
                            <img id="dtlTtdPiket" src="" alt="TTD Piket" style="max-height: 44px; max-width: 100%; object-fit: contain;">
                            <span id="dtlNoTtdPiket" style="font-size: 10.5px; color: #94a3b8; font-style: italic; display: none;">Tervalidasi Digital</span>
                        </div>
                        <strong id="dtlNamaPiket" style="text-decoration: underline; font-size: 12px;"></strong>
                    </div>

                    <div class="surat-sign-col">
                        <span>Menyetujui,<br>Waka Kesiswaan</span>
                        <div style="min-height: 48px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <span class="badge-approved" style="font-size: 10px; padding: 2px 7px;"><i class="fa-solid fa-shield-check"></i> DISAHKAN RESMI</span>
                            <span id="dtlWaktuWaka" style="font-size: 9.5px; color: #64748b; margin-top: 3px;"></span>
                        </div>
                        <div>
                            <strong id="dtlNamaWaka" style="text-decoration: underline; font-size: 12px;"></strong>
                            <div id="dtlNipWaka" style="font-size: 10.5px; color: #555;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lampiran Berkas / Foto Surat Dispensasi & Kartu Identitas Siswa -->
            <div id="sectionLampiranSurat" style="background: #ffffff; border-radius: 12px; border: 1px solid #cbd5e1; padding: 18px; margin-bottom: 12px;">
                <div style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-paperclip" style="color: #2563eb;"></i>
                    Lampiran Berkas & Foto Surat Dispensasi Fisik
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <!-- Foto Surat Dispensasi -->
                    <div id="boxFotoSurat" style="border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px; background: #f8fafc; text-align: center;">
                        <span style="font-size: 11.5px; font-weight: 800; color: #475569; display: block; margin-bottom: 8px;">
                            <i class="fa-solid fa-file-image" style="color: #2563eb;"></i> Foto Surat Dispensasi / Undangan
                        </span>
                        <a id="linkFotoSurat" href="#" target="_blank">
                            <img id="imgFotoSurat" src="" alt="Foto Surat Dispensasi" style="max-height: 180px; width: 100%; object-fit: contain; border-radius: 6px; background: #ffffff; border: 1px solid #cbd5e1;">
                        </a>
                        <div style="font-size: 11px; color: #64748b; margin-top: 6px;">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Klik gambar untuk ukuran penuh
                        </div>
                    </div>

                    <!-- Foto Kartu Identitas / Pelajar -->
                    <div id="boxFotoKartu" style="border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px; background: #f8fafc; text-align: center;">
                        <span style="font-size: 11.5px; font-weight: 800; color: #475569; display: block; margin-bottom: 8px;">
                            <i class="fa-solid fa-id-card" style="color: #10b981;"></i> Foto Kartu Pelajar / Identitas
                        </span>
                        <a id="linkFotoKartu" href="#" target="_blank">
                            <img id="imgFotoKartu" src="" alt="Foto Kartu Identitas" style="max-height: 180px; width: 100%; object-fit: contain; border-radius: 6px; background: #ffffff; border: 1px solid #cbd5e1;">
                        </a>
                        <div style="font-size: 11px; color: #64748b; margin-top: 6px;">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Klik gambar untuk ukuran penuh
                        </div>
                    </div>
                </div>

                <div id="boxNoLampiran" style="display: none; padding: 12px; background: #f1f5f9; border-radius: 8px; text-align: center; font-size: 12px; color: #64748b; font-style: italic;">
                    <i class="fa-solid fa-info-circle"></i> Tidak ada lampiran file foto berkas fisik tambahan. Dispensasi diterbitkan secara digital langsung.
                </div>
            </div>

            <!-- Catatan Waka Kesiswaan (Jika Ada) -->
            <div id="boxCatatanWaka" style="display: none; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 12px 16px; font-size: 12.5px; color: #166534;">
                <strong style="display: block; margin-bottom: 2px;"><i class="fa-solid fa-comment-dots"></i> Catatan Waka Kesiswaan:</strong>
                <span id="dtlCatatanWakaText"></span>
            </div>
        </div>

        <div style="padding: 14px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #ffffff;">
            <a id="dtlBtnPrint" href="#" target="_blank" class="btn-card-action btn-card-print" style="background: #2563eb; color: #ffffff; border: none; padding: 9px 18px;">
                <i class="fa-solid fa-print"></i> Cetak Lembar Surat Resmi
            </a>
            <button type="button" onclick="closeModalDetailDispen()" class="btn-filter-dark" style="background: #384972; padding: 9px 20px;">
                Tutup
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Data dictionary for details
    const dispenData = {
        @foreach($dispenList as $d)
            {{ $d->id_siswa_dispen }}: {
                id: {{ $d->id_siswa_dispen }},
                kode: "{{ $d->kode_dispen }}",
                nama: "{{ addslashes($d->siswa->nama_siswa ?? 'Siswa') }}",
                kelas: "{{ addslashes($d->kelas->nama_kelas ?? ($d->siswa->kelas->nama_kelas ?? '-')) }}",
                jurusan: "{{ addslashes($d->kelas->jurusan->nama_jurusan ?? ($d->siswa->kelas->jurusan->nama_jurusan ?? 'Semua Jurusan')) }}",
                nis: "{{ $d->siswa->nis ?? '-' }}",
                nisn: "{{ $d->siswa->nisn ?? '-' }}",
                tanggal: "{{ $d->hari_indo }}, {{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('d F Y') }}",
                jam: "{{ substr($d->jam_keluar, 0, 5) }} s/d {{ substr($d->jam_kembali, 0, 5) }} WIB",
                alasan: "{{ addslashes($d->alasan) }}",
                fotoSurat: "{{ $d->foto_surat_dispen ? asset($d->foto_surat_dispen) : '' }}",
                fotoKartu: "{{ $d->foto_kartu_identitas ? asset($d->foto_kartu_identitas) : '' }}",
                ttdSiswa: "{{ $d->ttd_siswa ?: '' }}",
                ttdPiket: "{{ $d->ttd_guru_piket ?: '' }}",
                namaPiket: "{{ addslashes($d->nama_guru_piket ?: ($d->guruPiketUser->name ?? 'Petugas Guru Piket')) }}",
                waka: "{{ addslashes($d->nama_waka ?: ($d->wakaUser->name ?? 'Waka Kesiswaan')) }}",
                nipWaka: "{{ $d->nip_waka ? 'NIP. ' . $d->nip_waka : '' }}",
                catatanWaka: "{{ addslashes($d->catatan_waka ?? '') }}",
                waktuWaka: "{{ $d->waktu_approval_waka ? \Carbon\Carbon::parse($d->waktu_approval_waka)->translatedFormat('d M Y H:i') . ' WIB' : 'Tervalidasi Resmi' }}",
                printUrl: "{{ route('guru.surat-dispen.cetak', $d->id_siswa_dispen) }}",
                readUrl: "{{ route('guru.surat-dispen.mark-read', $d->id_siswa_dispen) }}"
            },
        @endforeach
    };

    // Checkbox Selection
    function toggleSelectAll(masterCb) {
        const checkboxes = document.querySelectorAll('.row-select-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = masterCb.checked;
            const card = document.getElementById('card-' + cb.value);
            if (card) {
                if (masterCb.checked) card.classList.add('selected');
                else card.classList.remove('selected');
            }
        });
        updateBatchToolbar();
    }

    function handleRowCheckboxChange(cb) {
        const card = document.getElementById('card-' + cb.value);
        if (card) {
            if (cb.checked) card.classList.add('selected');
            else card.classList.remove('selected');
        }
        updateBatchToolbar();
    }

    function updateBatchToolbar() {
        const checked = document.querySelectorAll('.row-select-checkbox:checked');
        const count = checked.length;
        const bar = document.getElementById('floatingBatchBar');
        const badge = document.getElementById('selectedCountBadge');

        badge.innerText = count;

        if (count > 0) {
            bar.classList.add('show');
        } else {
            bar.classList.remove('show');
            const master = document.getElementById('masterSelectAll');
            if (master) master.checked = false;
        }
    }

    function uncheckAll() {
        const checkboxes = document.querySelectorAll('.row-select-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = false;
            const card = document.getElementById('card-' + cb.value);
            if (card) card.classList.remove('selected');
        });
        const master = document.getElementById('masterSelectAll');
        if (master) master.checked = false;
        updateBatchToolbar();
    }

    function getSelectedIds() {
        const checked = document.querySelectorAll('.row-select-checkbox:checked');
        return Array.from(checked).map(cb => cb.value);
    }

    // Modal Single Delete
    function openModalSingleDelete(id, kode, nama) {
        document.getElementById('modalDelKode').innerText = kode;
        document.getElementById('modalDelNama').innerText = nama;
        document.getElementById('formSingleDelete').action = '/guru-surat-dispen/' + id;
        document.getElementById('modalSingleDelete').style.display = 'flex';
    }
    function closeModalSingleDelete() {
        document.getElementById('modalSingleDelete').style.display = 'none';
    }

    // Modal Batch Delete
    function openModalBatchDelete() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        document.getElementById('batchDeleteCountText').innerText = ids.length + ' data';
        document.getElementById('modalBatchDelete').style.display = 'flex';
    }
    function closeModalBatchDelete() {
        document.getElementById('modalBatchDelete').style.display = 'none';
    }
    function submitBatchDelete() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        document.getElementById('inputBatchDeleteIds').value = ids.join(',');
        document.getElementById('formBatchDelete').submit();
    }

    // Modal Detail Dispen (Lihat Surat Lengkap + Foto Lampiran)
    function openModalDetailDispen(id) {
        const data = dispenData[id];
        if (!data) return;

        document.getElementById('dtlKode').innerText = data.kode;
        document.getElementById('dtlNama').innerText = data.nama;
        document.getElementById('dtlNamaSignSiswa').innerText = data.nama;
        document.getElementById('dtlNisNisn').innerText = (data.nis && data.nis !== '-' ? data.nis + ' / ' : '') + (data.nisn || '-');
        document.getElementById('dtlKelasJurusan').innerText = data.kelas + ' (' + data.jurusan + ')';
        document.getElementById('dtlTanggal').innerText = data.tanggal;
        document.getElementById('dtlJam').innerText = data.jam;
        document.getElementById('dtlAlasan').innerText = '"' + data.alasan + '"';

        // TTD Siswa
        if (data.ttdSiswa) {
            document.getElementById('dtlTtdSiswa').src = data.ttdSiswa;
            document.getElementById('dtlTtdSiswa').style.display = 'inline-block';
            document.getElementById('dtlNoTtdSiswa').style.display = 'none';
        } else {
            document.getElementById('dtlTtdSiswa').style.display = 'none';
            document.getElementById('dtlNoTtdSiswa').style.display = 'inline-block';
        }

        // TTD Guru Piket
        if (data.ttdPiket) {
            document.getElementById('dtlTtdPiket').src = data.ttdPiket;
            document.getElementById('dtlTtdPiket').style.display = 'inline-block';
            document.getElementById('dtlNoTtdPiket').style.display = 'none';
        } else {
            document.getElementById('dtlTtdPiket').style.display = 'none';
            document.getElementById('dtlNoTtdPiket').style.display = 'inline-block';
        }
        document.getElementById('dtlNamaPiket').innerText = data.namaPiket;

        // Waka Approval
        document.getElementById('dtlNamaWaka').innerText = data.waka;
        document.getElementById('dtlNipWaka').innerText = data.nipWaka;
        document.getElementById('dtlWaktuWaka').innerText = data.waktuWaka;

        // Foto Lampiran
        let hasAnyPhoto = false;
        if (data.fotoSurat) {
            document.getElementById('imgFotoSurat').src = data.fotoSurat;
            document.getElementById('linkFotoSurat').href = data.fotoSurat;
            document.getElementById('boxFotoSurat').style.display = 'block';
            hasAnyPhoto = true;
        } else {
            document.getElementById('boxFotoSurat').style.display = 'none';
        }

        if (data.fotoKartu) {
            document.getElementById('imgFotoKartu').src = data.fotoKartu;
            document.getElementById('linkFotoKartu').href = data.fotoKartu;
            document.getElementById('boxFotoKartu').style.display = 'block';
            hasAnyPhoto = true;
        } else {
            document.getElementById('boxFotoKartu').style.display = 'none';
        }

        if (hasAnyPhoto) {
            document.getElementById('boxNoLampiran').style.display = 'none';
        } else {
            document.getElementById('boxNoLampiran').style.display = 'block';
        }

        // Catatan Waka
        if (data.catatanWaka) {
            document.getElementById('dtlCatatanWakaText').innerText = '"' + data.catatanWaka + '"';
            document.getElementById('boxCatatanWaka').style.display = 'block';
        } else {
            document.getElementById('boxCatatanWaka').style.display = 'none';
        }

        document.getElementById('dtlBtnPrint').href = data.printUrl;

        // Mark as read asynchronously
        fetch(data.readUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).catch(err => console.log(err));

        document.getElementById('modalDetailDispen').style.display = 'flex';
    }

    function closeModalDetailDispen() {
        document.getElementById('modalDetailDispen').style.display = 'none';
    }
</script>
@endsection