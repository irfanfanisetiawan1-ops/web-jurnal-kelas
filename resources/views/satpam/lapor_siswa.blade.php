@extends('layouts.guru')

@section('title', 'Lapor Siswa — Portal Satpam Jurnal SMEA')

@section('styles')
<style>
    .lapor-page-wrapper {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Page Header */
    .lapor-header {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .lapor-header-icon {
        width: 52px;
        height: 52px;
        background: #2563eb;
        color: #ffffff;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .lapor-header-text h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }

    .lapor-header-text p {
        font-size: 13.5px;
        color: #64748b;
        margin: 4px 0 0 0;
        font-weight: 600;
    }

    /* Main Grid Layout */
    .lapor-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .lapor-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Card Styling */
    .lapor-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .lapor-card-header-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .lapor-card-title {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Form Fields */
    .form-group-lapor {
        margin-bottom: 20px;
        position: relative;
    }

    .form-group-lapor label {
        display: block;
        font-size: 12.5px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control-lapor {
        width: 100%;
        padding: 12px 16px;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 600;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .form-control-lapor:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
    }

    .form-control-lapor.is-invalid {
        border-color: #ef4444 !important;
        background: #fef2f2 !important;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15) !important;
    }

    .form-control-lapor[readonly],
    .form-control-lapor[disabled] {
        background: #e2e8f0;
        color: #475569;
        cursor: not-allowed;
    }

    /* Custom Searchable Student Picker Component */
    .custom-select-container {
        position: relative;
        width: 100%;
    }

    .select-trigger-box {
        width: 100%;
        padding: 12px 16px;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .select-trigger-box:hover {
        background: #ffffff;
        border-color: #94a3b8;
    }

    .select-trigger-box.active {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
    }

    .trigger-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .trigger-info .placeholder-text {
        color: #64748b;
        font-weight: 600;
    }

    .arrow-icon {
        color: #64748b;
        font-size: 13px;
        transition: transform 0.2s ease;
    }

    .select-trigger-box.active .arrow-icon {
        transform: rotate(180deg);
        color: #2563eb;
    }

    .student-dropdown-menu {
        position: absolute;
        top: calc(100% + 6px);
        left: 0; right: 0;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        z-index: 100;
        display: none;
        flex-direction: column;
        overflow: hidden;
    }

    .student-dropdown-menu.show {
        display: flex;
    }

    .dropdown-search-header {
        position: relative;
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .dropdown-search-header i {
        position: absolute;
        left: 24px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .dropdown-search-header input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        outline: none;
    }

    .dropdown-search-header input:focus {
        border-color: #2563eb;
    }

    .dropdown-options-list {
        max-height: 250px;
        overflow-y: auto;
    }

    .group-header {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #2563eb;
        background: #eff6ff;
        padding: 8px 14px;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #dbeafe;
        position: sticky;
        top: 0;
        z-index: 5;
    }

    .student-item-row {
        padding: 11px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .student-item-row:hover {
        background: #eff6ff;
    }

    .student-item-row.selected {
        background: #dbeafe;
        border-left: 4px solid #2563eb;
    }

    .student-item-info .student-name {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .student-item-info .student-sub {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: 3px;
    }

    .badge-student-status {
        font-size: 10.5px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 12px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-student-status.belum-kembali { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .badge-student-status.belum-keluar { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }

    /* Pills for Jenis Kejadian */
    .kejadian-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pill-item {
        padding: 10px 18px;
        border-radius: 30px;
        border: 1.5px solid #cbd5e1;
        background: #f8fafc;
        color: #475569;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .pill-item:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    .pill-item.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    /* Recipient Cards */
    .recipient-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 24px;
    }

    .recipient-card {
        background: #f1f5f9;
        border: 1.5px solid #cbd5e1;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        transition: all 0.2s ease;
    }

    .recipient-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .recipient-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #cbd5e1;
        color: #1e293b;
        font-weight: 800;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .recipient-details .name {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .recipient-details .role-title {
        font-size: 11.5px;
        font-weight: 700;
        color: #64748b;
        margin-top: 2px;
    }

    .recipient-details .phone-no {
        font-size: 11px;
        font-weight: 700;
        color: #16a34a;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Custom Switch Toggle */
    .switch-toggle {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 24px;
        flex-shrink: 0;
    }

    .switch-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider-toggle {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #cbd5e1;
        transition: .3s;
        border-radius: 34px;
    }

    .slider-toggle:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    input:checked + .slider-toggle {
        background-color: #10b981;
    }

    input:checked + .slider-toggle:before {
        transform: translateX(22px);
    }

    /* Action Buttons Group */
    .action-buttons-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-submit-lapor {
        width: 100%;
        padding: 14px;
        background: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
    }

    .btn-submit-lapor:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-draft-lapor {
        width: 100%;
        padding: 13px;
        background: #ffffff;
        color: #475569;
        border: 1.5px solid #cbd5e1;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-draft-lapor:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .btn-reset-lapor {
        padding: 8px 16px;
        background: #f1f5f9;
        color: #64748b;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-reset-lapor:hover {
        background: #e2e8f0;
        color: #0f172a;
        border-color: #94a3b8;
    }

    /* Table History */
    .table-responsive {
        overflow-x: auto;
    }

    .table-lapor {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .table-lapor th {
        background: #f8fafc;
        padding: 12px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .table-lapor td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
        color: #1e293b;
        vertical-align: middle;
    }

    .badge-status {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }
    .badge-status.terkirim { background: #dcfce7; color: #166534; }
    .badge-status.draft { background: #fef3c7; color: #92400e; }

    /* Action Buttons in Table - Horizontal Single Line Layout */
    .table-action-inline {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .btn-wa-sm {
        padding: 7px 12px;
        border-radius: 9px;
        font-size: 11.5px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #ffffff;
        background: #25d366;
        transition: all 0.2s ease;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(37, 211, 102, 0.25);
    }
    .btn-wa-sm:hover { background: #1eb956; color: #ffffff; transform: translateY(-1px); }

    .btn-delete-sm {
        padding: 7px 10px;
        border-radius: 9px;
        font-size: 11.5px;
        font-weight: 700;
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-delete-sm:hover { background: #fca5a5; color: #7f1d1d; }

    /* Modal Send WA Notification */
    .wa-modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .wa-modal-card {
        background: #ffffff;
        border-radius: 24px;
        max-width: 500px;
        width: 100%;
        padding: 28px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        text-align: center;
        animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .wa-modal-icon {
        width: 64px;
        height: 64px;
        background: #dcfce7;
        color: #16a34a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin: 0 auto 16px auto;
    }

    .wa-action-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-wa-modal {
        width: 100%;
        padding: 12px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #ffffff;
        transition: all 0.2s ease;
    }
    .btn-wa-modal.wali { background: #2563eb; }
    .btn-wa-modal.wali:hover { background: #1d4ed8; }
    .btn-wa-modal.piket { background: #16a34a; }
    .btn-wa-modal.piket:hover { background: #15803d; }

    .btn-close-modal {
        margin-top: 10px;
        padding: 10px;
        background: transparent;
        border: none;
        color: #64748b;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }
    .btn-close-modal:hover { color: #0f172a; }

    /* Client-side Validation Alert Box */
    .validation-alert-box {
        background: #fee2e2;
        border: 1.5px solid #fca5a5;
        color: #991b1b;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 16px;
        display: none;
        align-items: center;
        gap: 10px;
    }
</style>
@endsection

@section('content')
<div class="lapor-page-wrapper">

    <!-- Flash Alert Messages -->
    @if(session('success'))
        <div style="background: #dcfce7; border: 1px solid #86efac; color: #14532d; padding: 14px 18px; border-radius: 12px; font-weight: 700; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #16a34a;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #7f1d1d; padding: 14px 18px; border-radius: 12px; font-weight: 700; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px; color: #dc2626;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header Page Title & Subtitle -->
    <div class="lapor-header">
        <div class="lapor-header-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="lapor-header-text">
            <h1>Lapor Siswa</h1>
            <p>Laporkan kejadian & kirim ke pihak terkait</p>
        </div>
    </div>

    <!-- Form Section -->
    <form action="{{ route('satpam.store-lapor-siswa') }}" method="POST" id="laporForm" onsubmit="return validateLaporForm(event)">
        @csrf
        <input type="hidden" name="is_draft" id="inputIsDraft" value="0">
        <input type="hidden" name="jenis_kejadian" id="inputJenisKejadian" value="Terlambat Kembali dari Izin">
        <input type="hidden" name="id_siswa" id="selectedSiswaId" value="{{ old('id_siswa', $selectedIdSiswa) }}">

        <div class="lapor-grid">

            <!-- Left Card: Detail Laporan -->
            <div class="lapor-card">
                <div class="lapor-card-header-flex">
                    <h2 class="lapor-card-title">
                        <i class="fa-solid fa-file-pen" style="color: #2563eb;"></i>
                        <span>Detail Laporan</span>
                    </h2>

                    <!-- Reset Form Button -->
                    <button type="button" class="btn-reset-lapor" onclick="resetLaporForm()" title="Bersihkan dan reset seluruh isian form">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset Form</span>
                    </button>
                </div>

                <!-- Client-Side Validation Alert Box -->
                <div class="validation-alert-box" id="validationAlertBox">
                    <i class="fa-solid fa-circle-exclamation" style="font-size: 16px;"></i>
                    <span id="validationAlertMessage">Mohon lengkapi data siswa yang dilaporkan terlebih dahulu.</span>
                </div>

                <!-- Custom Searchable Student Selection Component -->
                <div class="form-group-lapor">
                    <label>Nama & NISN Siswa</label>

                    <div class="custom-select-container" id="customSelectContainer">
                        
                        <!-- Trigger Box -->
                        <div class="select-trigger-box" id="selectTriggerBox" onclick="toggleStudentDropdown()">
                            <div class="trigger-info" id="triggerInfo">
                                <i class="fa-solid fa-user-graduate" style="color: #2563eb;"></i>
                                <span id="triggerText" class="placeholder-text">🔍 Cari & Pilih Siswa (Ketik Nama / NISN / Kelas)...</span>
                            </div>
                            <i class="fa-solid fa-chevron-down arrow-icon" id="arrowIcon"></i>
                        </div>

                        <!-- Dropdown Menu Box -->
                        <div class="student-dropdown-menu" id="studentDropdownMenu">
                            <!-- Search Bar inside Dropdown -->
                            <div class="dropdown-search-header">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" id="searchSiswaInput" placeholder="Ketik Nama Siswa, NISN, atau Kelas..." onkeyup="filterCustomSiswaList()">
                            </div>

                            <!-- Options List Container -->
                            <div class="dropdown-options-list" id="dropdownOptionsList">
                                
                                @if($dispenTodayList->count() > 0)
                                    <div class="group-header">⚡ SISWA IZIN DISPEN HARI INI (LOG AKTIVITAS)</div>
                                    @foreach($dispenTodayList as $d)
                                        @if($d->siswa)
                                            @php
                                                $nisnText = $d->siswa->nisn ? 'NISN: ' . $d->siswa->nisn : 'Tanpa NISN';
                                                $kelasName = $d->kelas->nama_kelas ?? 'Kelas -';
                                                
                                                // Status Indicator Badges for Dispen Students
                                                $isBelumKembali = ($d->status_satpam === 'dizinkan_keluar');
                                                $isBelumKeluar  = ($d->status_satpam === 'belum_keluar');
                                                
                                                $badgeHtml = '';
                                                if ($isBelumKembali) {
                                                    $badgeHtml = '<span class="badge-student-status belum-kembali"><i class="fa-solid fa-circle-exclamation"></i> BELUM KEMBALI</span>';
                                                } elseif ($isBelumKeluar) {
                                                    $badgeHtml = '<span class="badge-student-status belum-keluar"><i class="fa-solid fa-clock"></i> IZIN - BELUM KELUAR</span>';
                                                }
                                            @endphp
                                            <div class="student-item-row" 
                                                 data-id="{{ $d->siswa->id_siswa }}" 
                                                 data-nama="{{ $d->siswa->nama_siswa }}" 
                                                 data-nisn="{{ $d->siswa->nisn ?? '-' }}" 
                                                 data-kelas="{{ $kelasName }}" 
                                                 data-search="{{ strtolower($d->siswa->nama_siswa . ' ' . $d->siswa->nisn . ' ' . $kelasName) }}"
                                                 onclick="selectStudentItem(this)">
                                                <div class="student-item-info">
                                                    <div class="student-name">{{ $d->siswa->nama_siswa }}</div>
                                                    <div class="student-sub">{{ $nisnText }} • {{ $kelasName }}</div>
                                                </div>
                                                <div>
                                                    {!! $badgeHtml !!}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                                <!-- Clean List of All Master Students (No Header Text & No DATA TU Badge) -->
                                @foreach($allSiswaList as $s)
                                    @php
                                        $nisnText = $s->nisn ? 'NISN: ' . $s->nisn : 'Tanpa NISN';
                                        $kelasName = $s->kelas->nama_kelas ?? 'Tanpa Kelas';
                                    @endphp
                                    <div class="student-item-row" 
                                         data-id="{{ $s->id_siswa }}" 
                                         data-nama="{{ $s->nama_siswa }}" 
                                         data-nisn="{{ $s->nisn ?? '-' }}" 
                                         data-kelas="{{ $kelasName }}" 
                                         data-search="{{ strtolower($s->nama_siswa . ' ' . $s->nisn . ' ' . $kelasName) }}"
                                         onclick="selectStudentItem(this)">
                                        <div class="student-item-info">
                                            <div class="student-name">{{ $s->nama_siswa }}</div>
                                            <div class="student-sub">{{ $nisnText }} • {{ $kelasName }}</div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group-lapor">
                    <label for="inputKelas">Kelas Siswa</label>
                    <input type="text" id="inputKelas" class="form-control-lapor" placeholder="Pilih siswa terlebih dahulu..." readonly>
                </div>

                <div class="form-group-lapor">
                    <label>Jenis Kejadian</label>
                    <div class="kejadian-pills" id="kejadianPills">
                        <div class="pill-item active" onclick="setJenisKejadian('Terlambat Kembali dari Izin', this)">
                            Terlambat Kembali dari Izin
                        </div>
                        <div class="pill-item" onclick="setJenisKejadian('Keluar Tanpa Izin', this)">
                            Keluar Tanpa Izin
                        </div>
                        <div class="pill-item" onclick="setJenisKejadian('Pelanggaran Tata Tertib', this)">
                            Pelanggaran Tata Tertib
                        </div>
                        <div class="pill-item" onclick="setJenisKejadian('Lainnya', this)">
                            Lainnya
                        </div>
                    </div>
                </div>

                <div class="form-group-lapor" style="margin-bottom: 0;">
                    <label for="textareaCatatan">Catatan Kejadian</label>
                    <textarea name="catatan" id="textareaCatatan" rows="4" class="form-control-lapor" placeholder="Tuliskan kronologi singkat kejadian atau catatan keterlambatan kembali..."></textarea>
                </div>
            </div>

            <!-- Right Card: Kirim Laporan Ke -->
            <div class="lapor-card">
                <h2 class="lapor-card-title">
                    <i class="fa-solid fa-paper-plane" style="color: #2563eb;"></i>
                    <span>Kirim Laporan Ke</span>
                </h2>

                <div class="recipient-list">
                    
                    <!-- Wali Kelas Target -->
                    <div class="recipient-card" id="cardWaliKelas">
                        <div class="recipient-info">
                            <div class="recipient-avatar" id="avatarWali">WK</div>
                            <div class="recipient-details">
                                <div class="name" id="namaWaliText">Pilih Siswa...</div>
                                <div class="role-title" id="titleWaliText">Wali Kelas</div>
                                <div class="phone-no" id="phoneWaliText">
                                    <i class="fa-brands fa-whatsapp"></i> <span id="valPhoneWali">-</span>
                                </div>
                            </div>
                        </div>
                        <label class="switch-toggle" title="Aktifkan pengiriman ke Wali Kelas">
                            <input type="checkbox" name="send_wali_kelas" value="1" checked id="checkSendWali">
                            <span class="slider-toggle"></span>
                        </label>
                    </div>

                    <!-- Guru Piket Target -->
                    <div class="recipient-card" id="cardGuruPiket">
                        <div class="recipient-info">
                            <div class="recipient-avatar" id="avatarPiket" style="background: #e2e8f0; color: #0f172a;">P</div>
                            <div class="recipient-details">
                                <div class="name" id="namaPiketText">Guru Piket Hari Ini</div>
                                <div class="role-title" id="titlePiketText">Petugas Piket Sekolah</div>
                                <div class="phone-no" id="phonePiketText">
                                    <i class="fa-brands fa-whatsapp"></i> <span id="valPhonePiket">-</span>
                                </div>
                            </div>
                        </div>
                        <label class="switch-toggle" title="Aktifkan pengiriman ke Guru Piket">
                            <input type="checkbox" name="send_guru_piket" value="1" checked id="checkSendPiket">
                            <span class="slider-toggle"></span>
                        </label>
                    </div>

                </div>

                <!-- Action Buttons Group -->
                <div class="action-buttons-group">
                    <button type="submit" class="btn-submit-lapor" onclick="document.getElementById('inputIsDraft').value = '0';">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim Laporan</span>
                    </button>

                    <button type="submit" class="btn-draft-lapor" onclick="document.getElementById('inputIsDraft').value = '1';">
                        <i class="fa-solid fa-bookmark"></i>
                        <span>Simpan sebagai Draft</span>
                    </button>
                </div>
            </div>

        </div>
    </form>

    <!-- Bottom Section: Riwayat Laporan Satpam -->
    <div class="lapor-card" style="margin-top: 10px;">
        <h2 class="lapor-card-title">
            <i class="fa-solid fa-clock-rotate-left" style="color: #64748b;"></i>
            <span>Riwayat Laporan Kejadian Siswa</span>
        </h2>

        <div class="table-responsive">
            <table class="table-lapor">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Waktu & Tanggal</th>
                        <th>Siswa & NISN</th>
                        <th>Kelas</th>
                        <th>Jenis Kejadian</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th style="text-align: center; white-space: nowrap;">KIRIM WA / AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanList as $index => $item)
                        <tr>
                            <td>{{ $laporanList->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $item->created_at ? $item->created_at->format('H:i') : '-' }}</strong><br>
                                <small style="color: #64748b;">{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</small>
                            </td>
                            <td>
                                <strong>{{ $item->siswa->nama_siswa ?? 'Siswa Dihapus' }}</strong><br>
                                <small style="color: #64748b;">NISN: {{ $item->siswa->nisn ?? '-' }}</small>
                            </td>
                            <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                            <td>
                                <span style="font-weight: 700; color: #2563eb;">{{ $item->jenis_kejadian }}</span>
                            </td>
                            <td>{{ Str::limit($item->catatan ?? '-', 60) }}</td>
                            <td>
                                <span class="badge-status {{ $item->status }}">
                                    {{ $item->status === 'draft' ? 'Draft' : 'Terkirim' }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <!-- Single Horizontal Row Action Buttons Layout -->
                                <div class="table-action-inline">
                                    @php
                                        $tglText = $item->created_at ? $item->created_at->translatedFormat('l, d F Y') : '-';
                                        $msg = "🚨 *LAPORAN KEJADIAN / KETERLAMBATAN SISWA*\n*PORTAL SATPAM SMEA*\n\n"
                                            . "👤 *Nama Siswa:* " . ($item->siswa->nama_siswa ?? '-') . "\n"
                                            . "🆔 *NISN:* " . ($item->siswa->nisn ?? '-') . "\n"
                                            . "🏫 *Kelas:* " . ($item->kelas->nama_kelas ?? '-') . "\n"
                                            . "⚠️ *Jenis Kejadian:* " . $item->jenis_kejadian . "\n"
                                            . "📝 *Catatan:* " . ($item->catatan ?: '-') . "\n\n"
                                            . "📅 *Tanggal:* " . $tglText . "\n"
                                            . "👮 *Pelapor:* " . ($item->satpamUser->name ?? 'Satpam') . " (Satpam)\n\n"
                                            . "Mohon dapat ditindaklanjuti. Terima kasih.";
                                        $encodedMsg = rawurlencode($msg);

                                        // Nomor WA Wali Kelas
                                        $noWali = '';
                                        if ($item->kelas && $item->kelas->wali_kelas) {
                                            $gWali = \App\Models\Guru::where('nip', trim($item->kelas->wali_kelas))->first();
                                            $uWali = \App\Models\User::where('nip', trim($item->kelas->wali_kelas))->first();
                                            $noWali = $gWali->no_hp ?? ($uWali->no_hp ?? '');
                                        }
                                        $waWaliClean = preg_replace('/[^0-9]/', '', $noWali);
                                        if (str_starts_with($waWaliClean, '0')) $waWaliClean = '62' . substr($waWaliClean, 1);

                                        // Nomor WA Guru Piket
                                        $pUser = \App\Models\User::whereIn('role', ['piket', 'guru_piket'])->whereNull('deleted_at')->first();
                                        $noPiket = $pUser->no_hp ?? '';
                                        $waPiketClean = preg_replace('/[^0-9]/', '', $noPiket);
                                        if (str_starts_with($waPiketClean, '0')) $waPiketClean = '62' . substr($waPiketClean, 1);
                                    @endphp

                                    @if(!empty($waWaliClean))
                                        <a href="https://wa.me/{{ $waWaliClean }}?text={{ $encodedMsg }}" target="_blank" class="btn-wa-sm" title="Kirim WA ke Wali Kelas">
                                            <i class="fa-brands fa-whatsapp"></i> Wali Kelas
                                        </a>
                                    @endif

                                    @if(!empty($waPiketClean))
                                        <a href="https://wa.me/{{ $waPiketClean }}?text={{ $encodedMsg }}" target="_blank" class="btn-wa-sm" style="background: #16a34a;" title="Kirim WA ke Guru Piket">
                                            <i class="fa-brands fa-whatsapp"></i> Guru Piket
                                        </a>
                                    @endif

                                    <form action="{{ route('satpam.destroy-lapor-siswa', $item->id_lapor_siswa) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat laporan ini?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-sm" title="Hapus Laporan">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 24px;">
                                <i class="fa-solid fa-clipboard-list" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                                Belum ada riwayat laporan kejadian siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $laporanList->links() }}
        </div>
    </div>

</div>

<!-- Modal Dialog Automatic WhatsApp Sending Trigger -->
@if(session('wa_wali_url') || session('wa_piket_url'))
<div class="wa-modal-overlay" id="waModalOverlay">
    <div class="wa-modal-card">
        <div class="wa-modal-icon">
            <i class="fa-brands fa-whatsapp"></i>
        </div>
        <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Laporan Berhasil Disimpan!</h3>
        <p style="font-size: 13.5px; color: #475569; margin: 0 0 16px 0;">
            Klik tombol di bawah ini untuk langsung membuka obrolan WhatsApp dan mengirimkan pesan laporan yang sudah disiapkan:
        </p>

        <div class="wa-action-buttons">
            @if(session('wa_wali_url'))
                <a href="{{ session('wa_wali_url') }}" target="_blank" class="btn-wa-modal wali" onclick="setTimeout(() => { checkCloseModal(); }, 1000);">
                    <i class="fa-brands fa-whatsapp" style="font-size: 20px;"></i>
                    <span>Kirim WA ke Wali Kelas</span>
                </a>
            @endif

            @if(session('wa_piket_url'))
                <a href="{{ session('wa_piket_url') }}" target="_blank" class="btn-wa-modal piket" onclick="setTimeout(() => { checkCloseModal(); }, 1000);">
                    <i class="fa-brands fa-whatsapp" style="font-size: 20px;"></i>
                    <span>Kirim WA ke Guru Piket</span>
                </a>
            @endif
        </div>

        <button type="button" class="btn-close-modal" onclick="document.getElementById('waModalOverlay').style.display='none';">
            Tutup Modal
        </button>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    // Custom Student Picker JS Logic
    function toggleStudentDropdown() {
        const triggerBox = document.getElementById('selectTriggerBox');
        const menu = document.getElementById('studentDropdownMenu');
        const isOpen = menu.classList.contains('show');

        if (isOpen) {
            closeStudentDropdown();
        } else {
            triggerBox.classList.add('active');
            menu.classList.add('show');
            document.getElementById('searchSiswaInput').focus();
        }
    }

    function closeStudentDropdown() {
        const triggerBox = document.getElementById('selectTriggerBox');
        const menu = document.getElementById('studentDropdownMenu');
        triggerBox.classList.remove('active');
        menu.classList.remove('show');
    }

    // Close Dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const container = document.getElementById('customSelectContainer');
        if (container && !container.contains(e.target)) {
            closeStudentDropdown();
        }
    });

    // Filter Custom Student List Items
    function filterCustomSiswaList() {
        const query = document.getElementById('searchSiswaInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.student-item-row');

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            if (searchData.includes(query)) {
                row.style.display = 'flex';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Select Student Item Row
    function selectStudentItem(el) {
        const idSiswa = el.getAttribute('data-id');
        const namaSiswa = el.getAttribute('data-nama');
        const nisn = el.getAttribute('data-nisn');
        const kelas = el.getAttribute('data-kelas');

        // Set hidden input value
        document.getElementById('selectedSiswaId').value = idSiswa;

        // Update trigger text display
        const triggerText = document.getElementById('triggerText');
        triggerText.classList.remove('placeholder-text');
        triggerText.innerHTML = `<strong>${namaSiswa}</strong> — NISN: ${nisn} (${kelas})`;

        // Highlight selected row
        document.querySelectorAll('.student-item-row').forEach(r => r.classList.remove('selected'));
        el.classList.add('selected');

        // Close dropdown
        closeStudentDropdown();

        // Trigger AJAX fetch details
        fetchSiswaLaporDetails(idSiswa);
    }

    // AJAX Fetch Student Details
    function fetchSiswaLaporDetails(idSiswa) {
        if (!idSiswa) return;

        hideValidationAlert();
        document.getElementById('selectTriggerBox').style.borderColor = '#cbd5e1';

        fetch(`{{ url('/satpam/api/siswa-lapor') }}/${idSiswa}`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    // Update field kelas
                    document.getElementById('inputKelas').value = res.siswa.nama_kelas || '-';

                    // Update Card Wali Kelas
                    const wali = res.wali_kelas;
                    document.getElementById('namaWaliText').innerText = wali.nama || 'Belum Diatur';
                    document.getElementById('titleWaliText').innerText = wali.title || 'Wali Kelas';
                    document.getElementById('valPhoneWali').innerText = wali.no_hp || '-';
                    
                    if (wali.nama && wali.nama !== 'Belum Diatur') {
                        const initW = wali.nama.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                        document.getElementById('avatarWali').innerText = initW || 'WK';
                    } else {
                        document.getElementById('avatarWali').innerText = 'WK';
                    }

                    // Update Card Guru Piket
                    const piket = res.guru_piket;
                    document.getElementById('namaPiketText').innerText = piket.nama || 'Guru Piket Hari Ini';
                    document.getElementById('titlePiketText').innerText = piket.title || 'Petugas Piket Hari Ini';
                    document.getElementById('valPhonePiket').innerText = piket.no_hp || '-';

                    if (piket.nama) {
                        const initP = piket.nama.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                        document.getElementById('avatarPiket').innerText = initP || 'P';
                    } else {
                        document.getElementById('avatarPiket').innerText = 'P';
                    }

                    // Pre-fill Catatan jika siswa sedang izin dispen
                    if (res.dispen) {
                        const d = res.dispen;
                        const statusSatpam = d.status_satpam === 'dizinkan_keluar' ? '🔴 BELUM KEMBALI' : '⏳ IZIN KELUAR';
                        const catatanText = `[${statusSatpam}] Siswa izin keluar (${d.alasan}) pukul ${d.jam_keluar}, seharusnya kembali pukul ${d.jam_kembali}. Hingga saat ini belum kembali ke sekolah dan belum ada konfirmasi.`;
                        document.getElementById('textareaCatatan').value = catatanText;
                    } else {
                        if (!document.getElementById('textareaCatatan').value) {
                            document.getElementById('textareaCatatan').value = `Siswa terlambat kembali ke sekolah dari izin keluar dan belum memberikan konfirmasi.`;
                        }
                    }
                }
            })
            .catch(err => {
                console.error('Error fetching student details:', err);
            });
    }

    // Set Jenis Kejadian Pill
    function setJenisKejadian(val, el) {
        document.getElementById('inputJenisKejadian').value = val;
        const pills = document.querySelectorAll('#kejadianPills .pill-item');
        pills.forEach(p => p.classList.remove('active'));
        el.classList.add('active');
    }

    // Fitur Reset Form
    function resetLaporForm() {
        document.getElementById('selectedSiswaId').value = '';
        const triggerText = document.getElementById('triggerText');
        triggerText.classList.add('placeholder-text');
        triggerText.innerText = '🔍 Cari & Pilih Siswa (Ketik Nama / NISN / Kelas)...';

        document.getElementById('searchSiswaInput').value = '';
        filterCustomSiswaList();

        document.querySelectorAll('.student-item-row').forEach(r => r.classList.remove('selected'));

        document.getElementById('inputKelas').value = '';
        document.getElementById('textareaCatatan').value = '';
        document.getElementById('inputIsDraft').value = '0';

        // Reset Jenis Kejadian Pills
        const pills = document.querySelectorAll('#kejadianPills .pill-item');
        pills.forEach((p, idx) => {
            if (idx === 0) {
                p.classList.add('active');
                document.getElementById('inputJenisKejadian').value = 'Terlambat Kembali dari Izin';
            } else {
                p.classList.remove('active');
            }
        });

        // Reset Cards Wali Kelas & Guru Piket
        document.getElementById('namaWaliText').innerText = 'Pilih Siswa...';
        document.getElementById('titleWaliText').innerText = 'Wali Kelas';
        document.getElementById('valPhoneWali').innerText = '-';
        document.getElementById('avatarWali').innerText = 'WK';

        document.getElementById('namaPiketText').innerText = 'Guru Piket Hari Ini';
        document.getElementById('titlePiketText').innerText = 'Petugas Piket Sekolah';
        document.getElementById('valPhonePiket').innerText = '-';
        document.getElementById('avatarPiket').innerText = 'P';

        // Reset Checkboxes
        document.getElementById('checkSendWali').checked = true;
        document.getElementById('checkSendPiket').checked = true;

        // Reset Validation Alerts
        hideValidationAlert();
        document.getElementById('selectTriggerBox').style.borderColor = '#cbd5e1';
    }

    // Client-Side Validation Function
    function validateLaporForm(e) {
        const idSiswa = document.getElementById('selectedSiswaId').value;
        const isDraft = document.getElementById('inputIsDraft').value === '1';

        if (!idSiswa) {
            e.preventDefault();
            showValidationAlert('⚠️ Peringatan: Silakan cari dan pilih data siswa yang akan dilaporkan terlebih dahulu!');
            document.getElementById('selectTriggerBox').style.borderColor = '#ef4444';
            document.getElementById('selectTriggerBox').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }

        if (!isDraft) {
            const sendWali = document.getElementById('checkSendWali').checked;
            const sendPiket = document.getElementById('checkSendPiket').checked;

            if (!sendWali && !sendPiket) {
                const proceed = confirm('Perhatian: Anda belum mencentang target penerima (Wali Kelas / Guru Piket). Apakah Anda yakin ingin menyimpan laporan tanpa memilih target pengiriman WhatsApp?');
                if (!proceed) {
                    e.preventDefault();
                    return false;
                }
            }
        }

        return true;
    }

    function showValidationAlert(msg) {
        const box = document.getElementById('validationAlertBox');
        const msgEl = document.getElementById('validationAlertMessage');
        msgEl.innerText = msg;
        box.style.display = 'flex';
    }

    function hideValidationAlert() {
        const box = document.getElementById('validationAlertBox');
        box.style.display = 'none';
    }

    // Auto select jika terpilih dari query string
    document.addEventListener('DOMContentLoaded', function() {
        const selectedId = document.getElementById('selectedSiswaId').value;
        if (selectedId) {
            const matchRow = document.querySelector(`.student-item-row[data-id="${selectedId}"]`);
            if (matchRow) {
                selectStudentItem(matchRow);
            }
        }
    });

    let clickCount = 0;
    function checkCloseModal() {
        clickCount++;
        if (clickCount >= 2) {
            const overlay = document.getElementById('waModalOverlay');
            if (overlay) overlay.style.display = 'none';
        }
    }
</script>
@endsection
