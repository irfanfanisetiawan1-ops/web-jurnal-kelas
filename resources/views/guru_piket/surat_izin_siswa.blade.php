@extends('layouts.guru')

@section('title', 'Surat Izin Siswa — EDU JOURNAL')

@section('styles')
<!-- Select2 CSS for Searchable Class & Student Select -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .surat-izin-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    /* Style Override Select2 & Prevent Horizontal Overflow */
    .select2-container {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
    }

    .select2-container .select2-selection--single {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        height: 42px;
        padding: 6px 12px;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--open .select2-selection--single {
        background-color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1e293b;
        font-size: 13px;
        font-weight: 600;
        line-height: normal;
        padding-left: 0;
        padding-right: 24px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
        box-sizing: border-box;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        right: 8px;
        top: 1px;
    }

    .select2-dropdown {
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        overflow: hidden;
        background: #ffffff;
    }

    .select2-search--dropdown {
        padding: 8px;
    }

    .select2-search__field {
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        padding: 7px 10px !important;
        font-size: 12.5px !important;
        outline: none !important;
        font-family: inherit !important;
        box-sizing: border-box !important;
    }

    .select2-search__field:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1) !important;
    }

    .select2-results__option {
        padding: 9px 12px;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #2563eb;
        color: #ffffff;
    }

    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
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

    /* Stats Grid */
    .stats-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card-item {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stat-card-item.dark-blue {
        background: #384972;
        color: #ffffff;
        border-color: #2b3957;
    }

    .stat-card-item.sky-blue {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-top: 3px solid #0284c7;
    }

    .stat-card-item.amber-bg {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-top: 3px solid #d97706;
    }

    .stat-card-item.purple-bg {
        background: #f5f3ff;
        border: 1px solid #ddd6fe;
        border-top: 3px solid #7c3aed;
    }

    .stat-card-item .title {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        margin-bottom: 8px;
    }

    .stat-card-item.dark-blue .title { color: #cbd5e1; }
    .stat-card-item.sky-blue .title { color: #0369a1; }
    .stat-card-item.amber-bg .title { color: #b45309; }
    .stat-card-item.purple-bg .title { color: #6d28d9; }

    .stat-card-item .number {
        font-size: 32px;
        font-weight: 800;
        line-height: 1.1;
        color: #0f172a;
    }

    .stat-card-item.dark-blue .number { color: #ffffff; }

    .stat-card-item .subtitle {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        margin-top: 4px;
    }
    .stat-card-item.dark-blue .subtitle { color: #94a3b8; }

    /* Info Alert Box */
    .alert-sync-info {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #93c5fd;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        color: #1e40af;
    }

    .alert-sync-info i {
        font-size: 24px;
        color: #2563eb;
        flex-shrink: 0;
    }

    .alert-sync-info h4 {
        font-size: 14px;
        font-weight: 800;
        margin: 0 0 2px 0;
        color: #1e3a8a;
    }

    .alert-sync-info p {
        font-size: 12.5px;
        font-weight: 600;
        margin: 0;
        color: #1e40af;
    }

    /* Form & Cards */
    .card-custom {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .card-custom-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .card-custom-header h2 {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
    }

    .card-custom-body {
        padding: 24px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    @media (max-width: 992px) {
        .form-grid { grid-template-columns: 1fr; }
        .stats-summary-grid { grid-template-columns: repeat(2, 1fr); }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label-custom {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
    }

    .form-control-custom, .select-custom, .textarea-custom {
        width: 100%;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-control-custom:focus, .select-custom:focus, .textarea-custom:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-control-custom.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    /* Wali Kelas Badge Info Box */
    .wali-kelas-badge {
        display: none;
        align-items: center;
        gap: 8px;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 12px;
        color: #0369a1;
        font-weight: 700;
        margin-top: 4px;
    }

    .wali-kelas-badge.empty {
        background: #fffbeb;
        border-color: #fde68a;
        color: #b45309;
    }

    /* Durasi Pill Badge */
    .durasi-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #e0e7ff;
        color: #3730a3;
        font-size: 11px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 12px;
        margin-left: 6px;
    }

    .date-validation-warning {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        margin-top: 10px;
        display: none;
        align-items: center;
        gap: 8px;
    }

    /* Badges */
    .badge-kategori {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        text-transform: capitalize;
    }

    .badge-kategori.sakit {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .badge-kategori.izin {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .badge-kategori.dispen {
        background: #f3e8ff;
        color: #6d28d9;
        border: 1px solid #ddd6fe;
    }

    .student-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .student-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #384972;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        flex-shrink: 0;
    }

    .student-info .name {
        font-weight: 700;
        font-size: 13.5px;
        color: #0f172a;
    }

    .student-info .sub {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        font-size: 13px;
    }

    .btn-action-icon.btn-detail { background: #eff6ff; color: #2563eb; }
    .btn-action-icon.btn-detail:hover { background: #dbeafe; color: #1d4ed8; }
    .btn-action-icon.btn-edit { background: #e0f2fe; color: #0284c7; }
    .btn-action-icon.btn-edit:hover { background: #bae6fd; color: #0369a1; }
    .btn-action-icon.btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-action-icon.btn-delete:hover { background: #fca5a5; color: #991b1b; }
    .btn-action-icon.btn-preview { background: #f3e8ff; color: #7c3aed; }
    .btn-action-icon.btn-preview:hover { background: #ddd6fe; color: #6d28d9; }

    /* Custom Table Styling */
    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-custom th {
        background: #f8fafc;
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #cbd5e1;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background: #f8fafc;
    }

    /* Modal Overlay */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-box {
        background: #ffffff;
        border-radius: 20px;
        max-width: 650px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        animation: modalSlide 0.25s ease-out;
    }

    @keyframes modalSlide {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .modal-body {
        padding: 24px;
    }

    .btn-close-modal {
        background: #f1f5f9;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        cursor: pointer;
        font-size: 14px;
    }
    .btn-close-modal:hover { background: #e2e8f0; color: #0f172a; }

    /* Detail Grid Layout inside Modal */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .detail-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
    }

    .detail-item .label {
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .detail-item .val {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }
</style>
@endsection

@section('content')
<div class="surat-izin-container">
    
    <!-- Page Header -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Surat Izin &amp; Ketidakhadiran Siswa</h1>
            <p>Input &amp; kelola surat izin (Sakit, Izin, Dispen Luar Sekolah) oleh Guru Piket dengan Auto-Sync Presensi Real-Time</p>
        </div>
    </div>

    <!-- Alert Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <strong>Gagal Menyimpan Data:</strong>
                <ul style="margin: 4px 0 0 18px; padding: 0;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Top Stat Cards -->
    <div class="stats-summary-grid" style="margin-bottom: 24px;">
        <div class="stat-card-item dark-blue">
            <div>
                <div class="title">Total Izin Hari Ini</div>
                <div class="number">{{ $totalIzinHariIni }}</div>
            </div>
            <div class="subtitle">Siswa Aktif (Sakit: {{ $sakitHariIni }}, Izin: {{ $izinHariIni }}, Dispen: {{ $dispenHariIni }})</div>
        </div>

        <div class="stat-card-item sky-blue">
            <div>
                <div class="title">Sakit</div>
                <div class="number">{{ $sakitHariIni }}</div>
            </div>
            <div class="subtitle">Surat Dokter / Orang Tua</div>
        </div>

        <div class="stat-card-item amber-bg">
            <div>
                <div class="title">Izin</div>
                <div class="number">{{ $izinHariIni }}</div>
            </div>
            <div class="subtitle">Izin Kepentingan Keluarga</div>
        </div>

        <div class="stat-card-item purple-bg">
            <div>
                <div class="title">Dispen Luar Sekolah</div>
                <div class="number">{{ $dispenHariIni }}</div>
            </div>
            <div class="subtitle">Lomba / Kegiatan Luar</div>
        </div>
    </div>

    <!-- Auto Sync Information Banner -->
    <div class="alert-sync-info">
        <i class="fa-solid fa-bolt"></i>
        <div>
            <h4>Auto-Sync Presensi Real-Time &amp; Integrasi Wali Kelas</h4>
            <p>Setiap surat izin yang di-inputkan oleh Guru Piket di halaman ini akan secara otomatis memperbarui presensi di Jurnal Mengajar (multi-hari) dan langsung masuk ke halaman monitoring <strong>Wali Kelas</strong>.</p>
        </div>
    </div>

    <!-- Form Input Surat Izin Siswa Baru -->
    <div class="card-custom">
        <div class="card-custom-header">
            <h2><i class="fa-solid fa-pen-to-square" style="color: #384972; margin-right: 8px;"></i>Form Input Surat Izin / Ketidakhadiran Siswa (Oleh Guru Piket)</h2>
        </div>
        <div class="card-custom-body">
            <form id="suratIzinInputForm" action="{{ route('piket.surat-izin-siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-grid">
                    <!-- 1. Pilih Kelas Filter Dropdown (Searchable Select2) -->
                    <div class="form-group" style="min-width: 0;">
                        <label class="form-label-custom">1. Pilih Kelas Siswa <span style="color:#ef4444;">*</span></label>
                        <select id="form_select_kelas" name="id_kelas_form" class="select-custom" style="width: 100%;" required>
                            <option value="">-- Cari / Pilih Kelas Siswa --</option>
                            @foreach($kelases as $kls)
                                @php
                                    $waliNama = $kls->waliKelas->nama_guru ?? '';
                                    $waliNip  = $kls->waliKelas->nip ?? '';
                                @endphp
                                <option value="{{ $kls->id_kelas }}" data-wali-nama="{{ $waliNama }}" data-wali-nip="{{ $waliNip }}" {{ old('id_kelas_form') == $kls->id_kelas ? 'selected' : '' }}>
                                    {{ $kls->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        <!-- Dynamic Wali Kelas Display Badge -->
                        <div id="form_wali_kelas_badge" class="wali-kelas-badge">
                            <i class="fa-solid fa-user-tie"></i>
                            <span id="form_wali_kelas_text">-- Pilih Kelas Terlebih Dahulu --</span>
                        </div>
                    </div>

                    <!-- 2. Pilih Siswa (Searchable Select2) -->
                    <div class="form-group" style="min-width: 0;">
                        <label class="form-label-custom">2. Pilih Siswa yang Izin <span style="color:#ef4444;">*</span></label>
                        <select name="id_siswa" id="form_select_siswa" class="select-custom" style="width: 100%;" required disabled>
                            <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                        </select>
                    </div>

                    <!-- 3. Tanggal Mulai Izin -->
                    <div class="form-group">
                        <label class="form-label-custom">3. Tanggal Mulai Izin <span style="color:#ef4444;">*</span></label>
                        <input type="date" name="tanggal" id="form_tgl_mulai" class="form-control-custom" value="{{ $todayDate }}" onchange="calculateDurasiLive()" required>
                    </div>

                    <!-- 4. Tanggal Selesai Izin + Auto Durasi -->
                    <div class="form-group">
                        <label class="form-label-custom">
                            4. Tanggal Selesai Izin <span style="color:#ef4444;">*</span>
                            <span id="durasiPillBadge" class="durasi-pill">1 Hari</span>
                        </label>
                        <input type="date" name="tanggal_selesai" id="form_tgl_selesai" class="form-control-custom" value="{{ $todayDate }}" onchange="calculateDurasiLive()" required>
                    </div>

                    <!-- 5. Kategori Izin -->
                    <div class="form-group">
                        <label class="form-label-custom">5. Kategori Ketidakhadiran <span style="color:#ef4444;">*</span></label>
                        <select name="kategori" class="select-custom" required>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin" selected>Izin</option>
                            <option value="Dispen Luar Sekolah">Dispen Luar Sekolah (Dispensasi dari Luar)</option>
                        </select>
                    </div>

                    <!-- 6. Foto Bukti Surat / Dokumen (WAJIB) -->
                    <div class="form-group">
                        <label class="form-label-custom">6. Foto Bukti Surat / Dokumen (WAJIB) <span style="color:#ef4444;">*</span></label>
                        <input type="file" name="foto_bukti" id="form_foto_bukti" class="form-control-custom" accept="image/jpeg,image/png,image/jpg,image/webp" required>
                        <span style="font-size: 11px; color: #64748b;">Foto bukti fisik surat / surat dokter / tugas dispen wajib diunggah. Maks 5MB.</span>
                    </div>

                    <!-- 7. Keterangan / Alasan (WAJIB) -->
                    <div class="form-group full-width">
                        <label class="form-label-custom">7. Keterangan / Detail Alasan (WAJIB) <span style="color:#ef4444;">*</span></label>
                        <textarea name="keterangan" id="form_keterangan" rows="2" class="textarea-custom" placeholder="Tuliskan keterangan detail surat izin (misal: Sakit demam tinggi dengan surat dokter Puskesmas, atau Lomba Olahraga tingkat kota)..." required></textarea>
                    </div>
                </div>

                <!-- Date Error Warning Message -->
                <div id="dateValidationWarning" class="date-validation-warning">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span id="dateValidationText">Validasi Gagal: Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin!</span>
                </div>

                <!-- Action Buttons: Reset & Submit -->
                <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" class="btn-reset-light" onclick="resetFormCustom()" style="padding: 12px 20px; border-radius: 12px; font-size: 13px;">
                        <i class="fa-solid fa-rotate-left"></i> Reset Form
                    </button>

                    <button type="submit" id="btnSubmitForm" class="btn-filter-dark" style="padding: 12px 28px; font-size: 13.5px; border-radius: 12px;">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim &amp; Ter-absenkan Otomatis</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table & Filter Bar Container -->
    <div class="card-custom">
        <!-- Table Box Title with Total Count Badge -->
        <div class="card-custom-header">
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; flex-wrap: wrap; gap: 12px;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <h2><i class="fa-solid fa-table-list" style="color: #384972; margin-right: 8px;"></i>Daftar Data Surat Izin &amp; Ketidakhadiran Siswa</h2>
                        <span style="background: #384972; color: #ffffff; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px; letter-spacing: 0.3px;">
                            Total Database: {{ $suratIzinList->total() }} Data Surat
                        </span>
                    </div>
                    <span style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px; display: block;">Data urut terbaru di atas &amp; terintegrasi ke Wali Kelas</span>
                </div>
            </div>
        </div>

        <!-- Filter Bar + Relocated Trash Button -->
        <div class="filter-bar-container">
            <form action="{{ route('piket.surat-izin-siswa') }}" method="GET" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; width: 100%;">
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari nama siswa / keterangan..." style="width: 240px;">

                <select name="id_kelas" class="filter-input">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <select name="kategori" class="filter-input">
                    <option value="">Semua Kategori</option>
                    <option value="Sakit" {{ request('kategori') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Izin" {{ request('kategori') == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Dispen Luar Sekolah" {{ request('kategori') == 'Dispen Luar Sekolah' ? 'selected' : '' }}>Dispen Luar Sekolah</option>
                </select>

                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="filter-input">

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>

                <a href="{{ route('piket.surat-izin-siswa') }}" class="btn-reset-light" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>

                <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" style="background: #ef4444; color: #ffffff; padding: 9px 16px; border-radius: 8px; font-size: 12.5px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; opacity: 0.5; pointer-events: none; transition: all 0.2s ease; white-space: nowrap; width: auto; height: auto;" title="Hapus Data Terpilih">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                </button>

                <!-- Relocated Trash Button in Filter Bar -->
                <a href="{{ route('piket.surat-izin-siswa.trash') }}" class="btn-trash-pink" style="margin-left: auto;" title="Lihat Sampah Data Izin Siswa">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Sampah</span>
                </a>
            </form>
        </div>

        <div style="overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="width: 16px; height: 16px; cursor: pointer;">
                        </th>
                        <th style="width: 50px;">NO</th>
                        <th>SISWA</th>
                        <th>KELAS</th>
                        <th style="width: 130px; text-align: center;">KATEGORI</th>
                        <th style="width: 180px;">TANGGAL &amp; RENTANG</th>
                        <th style="width: 80px; text-align: center;">DURASI</th>
                        <th>KETERANGAN / ALASAN</th>
                        <th style="width: 100px; text-align: center;">BUKTI FOTO</th>
                        <th>PETUGAS PIKET</th>
                        <th style="width: 110px; text-align: center;">STATUS</th>
                        <th style="width: 130px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratIzinList as $index => $item)
                        @php
                            $namaSiswa = $item->siswa->nama_siswa ?? 'Siswa';
                            $namaKelas = $item->kelas->nama_kelas ?? '-';
                            $waliKelasObj = $item->kelas->waliKelas ?? null;
                            $waliNama = $waliKelasObj->nama_guru ?? null;
                            $waliNip  = $waliKelasObj->nip ?? null;

                            $petugasObj  = $item->petugasPiket;
                            $petugasNama = $petugasObj->name ?? 'Petugas Piket';
                            $petugasNip  = $petugasObj->nip ?? ($petugasObj->username ?? '-');

                            $nameParts = explode(' ', trim($namaSiswa));
                            $initials  = count($nameParts) >= 2 
                                ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1))
                                : strtoupper(substr($namaSiswa, 0, 2));

                            $katClass = match($item->kategori) {
                                'Sakit' => 'sakit',
                                'Izin'  => 'izin',
                                default => 'dispen'
                            };

                            $statusBg = match($item->status) {
                                'Terverifikasi' => '#d1fae5',
                                'Ditolak'       => '#fee2e2',
                                default         => '#fef3c7',
                            };
                            $statusColor = match($item->status) {
                                'Terverifikasi' => '#065f46',
                                'Ditolak'       => '#991b1b',
                                default         => '#b45309',
                            };
                            $statusBorder = match($item->status) {
                                'Terverifikasi' => '#a7f3d0',
                                'Ditolak'       => '#fca5a5',
                                default         => '#fde68a',
                            };

                            $tglMulaiFmt   = \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y');
                            $tglSelesaiFmt = $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : $tglMulaiFmt;
                            $rentangFmt    = ($tglMulaiFmt === $tglSelesaiFmt) ? $tglMulaiFmt : "{$tglMulaiFmt} s/d {$tglSelesaiFmt}";
                            $durasiText    = ($item->durasi_hari > 0 ? $item->durasi_hari : 1) . ' Hari';

                            // Format json data for modals
                            $itemDataJson = [
                                'id_surat_izin' => $item->id_surat_izin,
                                'nama_siswa'    => $namaSiswa,
                                'nis'           => $item->siswa->nis ?? '-',
                                'nama_kelas'    => $namaKelas,
                                'wali_nama'     => $waliNama,
                                'wali_nip'      => $waliNip,
                                'tanggal'       => $item->tanggal,
                                'tanggal_selesai' => $item->tanggal_selesai ?? $item->tanggal,
                                'durasi_hari'   => $item->durasi_hari,
                                'kategori'      => $item->kategori,
                                'keterangan'    => $item->keterangan,
                                'foto_url'      => $item->foto_url,
                                'petugas_nama'  => $petugasNama,
                                'petugas_nip'   => $petugasNip,
                                'status'        => $item->status ?? 'Terverifikasi',
                                'created_at'    => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                            ];
                        @endphp
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="surat-checkbox" value="{{ $item->id_surat_izin }}" onchange="updateSelectedState()" style="width: 16px; height: 16px; cursor: pointer;">
                            </td>
                            <td style="font-weight: 700; color: #64748b;">
                                {{ $suratIzinList->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="student-cell">
                                    <div class="student-avatar">{{ $initials }}</div>
                                    <div class="student-info">
                                        <div class="name">{{ $namaSiswa }}</div>
                                        <div class="sub">NIS: {{ $item->siswa->nis ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #384972;">{{ $namaKelas }}</div>
                                @if($waliNama)
                                    <div style="font-size: 11px; color: #64748b; font-weight: 600;">Wali: {{ $waliNama }}</div>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <span class="badge-kategori {{ $katClass }}">
                                    @if($item->kategori == 'Sakit')
                                        <i class="fa-solid fa-notes-medical"></i> Sakit
                                    @elseif($item->kategori == 'Izin')
                                        <i class="fa-solid fa-envelope"></i> Izin
                                    @else
                                        <i class="fa-solid fa-award"></i> Dispen Luar
                                    @endif
                                </span>
                            </td>
                            <td style="font-weight: 700; font-size: 12.5px;">{{ $rentangFmt }}</td>
                            <td style="text-align: center;">
                                <span class="durasi-pill">{{ $durasiText }}</span>
                            </td>
                            <td style="color: #475569; font-size: 12.5px;">{{ $item->keterangan ?? '-' }}</td>
                            <td style="text-align: center;">
                                @if($item->foto_url)
                                    <button type="button" class="btn-action-icon btn-preview" onclick="showFotoModal('{{ $item->foto_url }}', '{{ $namaSiswa }} - {{ $item->kategori }}')" title="Lihat Bukti Foto">
                                        <i class="fa-solid fa-image"></i>
                                    </button>
                                @else
                                    <span style="font-size: 11.5px; color: #94a3b8; font-style: italic;">Tanpa foto</span>
                                @endif
                            </td>
                            <td style="font-size: 12px; color: #475569;">
                                <div style="font-weight: 700; color: #0f172a;">{{ $petugasNama }}</div>
                                <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">NIP: {{ $petugasNip }}</div>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge" style="background: {{ $statusBg }}; color: {{ $statusColor }}; border: 1px solid {{ $statusBorder }}; font-size: 11px; padding: 4px 10px; border-radius: 12px; font-weight: 800;">
                                    {{ $item->status ?? 'Terverifikasi' }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <!-- Tombol Lihat Detail -->
                                    <button type="button" class="btn-action-icon btn-detail" onclick="openDetailModal({{ json_encode($itemDataJson) }})" title="Lihat Detail Surat Izin">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn-action-icon btn-edit" onclick="openEditModal({{ json_encode($itemDataJson) }})" title="Edit Surat Izin">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <!-- Tombol Hapus (Soft Delete) -->
                                    <form action="{{ route('piket.surat-izin-siswa.destroy', $item->id_surat_izin) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan surat izin ini ke sampah?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-icon btn-delete" title="Hapus ke Sampah">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fa-solid fa-folder-open" style="font-size: 32px; margin-bottom: 10px; display: block; color: #cbd5e1;"></i>
                                Belum ada data surat izin siswa yang di-input.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratIzinList->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
                {{ $suratIzinList->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Detail Surat Izin Siswa -->
<div id="detailModal" class="modal-overlay" onclick="closeDetailModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-address-card" style="color:#2563eb; margin-right: 6px;"></i>Detail Informasi Surat Izin Siswa</h3>
            <button type="button" class="btn-close-modal" onclick="closeDetailModalDirect()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="detail-grid">
                <div class="detail-item" style="grid-column: 1 / -1; display: flex; align-items: center; gap: 14px; background: #f1f5f9;">
                    <div id="det_avatar" class="student-avatar" style="width: 46px; height: 46px; font-size: 16px;">--</div>
                    <div>
                        <div id="det_nama_siswa" style="font-size: 16px; font-weight: 800; color: #0f172a;">-</div>
                        <div id="det_kelas_nis" style="font-size: 12.5px; color: #64748b; font-weight: 600;">-</div>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="label">Wali Kelas</div>
                    <div class="val" id="det_wali_kelas">-</div>
                </div>

                <div class="detail-item">
                    <div class="label">Kategori Ketidakhadiran</div>
                    <div class="val" id="det_kategori">-</div>
                </div>

                <div class="detail-item">
                    <div class="label">Status Verifikasi</div>
                    <div class="val" id="det_status" style="color: #059669;">Terverifikasi</div>
                </div>

                <div class="detail-item">
                    <div class="label">Tanggal Mulai Izin</div>
                    <div class="val" id="det_tgl_mulai">-</div>
                </div>

                <div class="detail-item">
                    <div class="label">Tanggal Selesai Izin</div>
                    <div class="val" id="det_tgl_selesai">-</div>
                </div>

                <div class="detail-item" style="grid-column: 1 / -1; background: #e0e7ff; border-color: #c7d2fe;">
                    <div class="label" style="color: #3730a3;">Total Durasi Ketidakhadiran</div>
                    <div class="val" id="det_durasi" style="color: #312e81; font-size: 15px;">-</div>
                </div>

                <div class="detail-item" style="grid-column: 1 / -1;">
                    <div class="label">Keterangan / Detail Alasan (WAJIB)</div>
                    <div class="val" id="det_keterangan" style="font-weight: 600; color: #334155; line-height: 1.4;">-</div>
                </div>

                <div class="detail-item">
                    <div class="label">Petugas Piket Peng-input</div>
                    <div class="val" id="det_petugas">-</div>
                </div>

                <div class="detail-item">
                    <div class="label">Waktu Penginputan</div>
                    <div class="val" id="det_waktu_input">-</div>
                </div>

                <div class="detail-item" style="grid-column: 1 / -1; text-align: center;">
                    <div class="label" style="margin-bottom: 8px;">Foto Bukti Fisik Surat / Dokumen</div>
                    <div id="det_foto_container">
                        <img id="det_foto_img" src="" alt="Bukti Surat" style="max-width: 100%; max-height: 320px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.12);">
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
                <button type="button" class="btn-filter-dark" onclick="closeDetailModalDirect()">Tutup Detail</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Foto Bukti (Lightbox) -->
<div id="fotoModal" class="modal-overlay" onclick="closeFotoModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 id="modalFotoTitle">Bukti Surat / Dokumen Siswa</h3>
            <button type="button" class="btn-close-modal" onclick="closeFotoModalDirect()">&times;</button>
        </div>
        <div class="modal-body" style="text-align: center;">
            <img id="modalFotoImg" src="" alt="Bukti Surat Izin Siswa" style="max-width: 100%; max-height: 70vh; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        </div>
    </div>
</div>

<!-- Modal Edit Data Surat Izin -->
<div id="editModal" class="modal-overlay" onclick="closeEditModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-pen-to-square" style="color: #0284c7; margin-right: 6px;"></i>Edit Data Surat Izin Siswa</h3>
            <button type="button" class="btn-close-modal" onclick="closeEditModalDirect()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label-custom">Nama Siswa &amp; Kelas</label>
                        <input type="text" id="edit_siswa_nama" class="form-control-custom" readonly style="background: #e2e8f0; font-weight: 700;">
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Wali Kelas</label>
                        <input type="text" id="edit_wali_kelas" class="form-control-custom" readonly style="background: #f1f5f9; color: #475569; font-weight: 600;">
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Tanggal Mulai Izin</label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control-custom" onchange="calculateEditDurasi()" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">
                            Tanggal Selesai Izin
                            <span id="editDurasiPill" class="durasi-pill">1 Hari</span>
                        </label>
                        <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control-custom" onchange="calculateEditDurasi()" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Kategori Ketidakhadiran</label>
                        <select name="kategori" id="edit_kategori" class="select-custom" required>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Dispen Luar Sekolah">Dispen Luar Sekolah</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Status Verifikasi</label>
                        <select name="status" id="edit_status" class="select-custom" required>
                            <option value="Terverifikasi">Terverifikasi</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>

                    <!-- Pratinjau Foto Bukti Lama -->
                    <div class="form-group">
                        <label class="form-label-custom">Foto Bukti Surat / Dokumen</label>
                        <div id="edit_foto_preview_container" style="margin-bottom: 8px; text-align: center; background: #f8fafc; padding: 10px; border-radius: 10px; border: 1px solid #cbd5e1;">
                            <img id="edit_foto_preview_img" src="" alt="Foto Bukti Lama" style="max-height: 160px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <div id="edit_foto_none_text" style="display:none; font-size: 12px; color: #94a3b8; font-style: italic;">Belum ada foto yang diunggah.</div>
                        </div>
                        <input type="file" name="foto_bukti" class="form-control-custom" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <span style="font-size: 11px; color: #64748b;">Pilih file gambar baru jika ingin mengganti foto bukti fisik yang tersimpan.</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom">Keterangan / Detail Alasan (WAJIB) <span style="color:#ef4444;">*</span></label>
                        <textarea name="keterangan" id="edit_keterangan" rows="3" class="textarea-custom" required></textarea>
                    </div>

                    <div style="margin-top: 10px; display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" class="btn-reset-light" onclick="closeEditModalDirect()">Batal</button>
                        <button type="submit" class="btn-filter-dark">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<!-- Select2 JS & jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Master data array of all students for Select2 filtering
    const allSiswaMaster = [
        @foreach($siswas as $sis)
        {
            id: "{{ $sis->id_siswa }}",
            nama: "{{ addslashes($sis->nama_siswa) }}",
            nis: "{{ addslashes($sis->nisn ?? $sis->nis ?? '') }}",
            id_kelas: "{{ $sis->id_kelas }}",
            nama_kelas: "{{ addslashes($sis->kelas->nama_kelas ?? 'Kelas') }}"
        },
        @endforeach
    ];

    $(document).ready(function() {
        // Init Select2 for Kelas Dropdown
        $('#form_select_kelas').select2({
            placeholder: '-- Cari / Pilih Kelas Siswa --',
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            filterSiswaByKelasForm();
        });

        // Init Select2 for Siswa Dropdown
        $('#form_select_siswa').select2({
            placeholder: '-- Cari / Pilih Siswa yang Izin --',
            allowClear: true,
            width: '100%'
        });

        calculateDurasiLive();

        // Auto restore selection if old input exists (e.g. after validation error)
        const oldSiswaId = "{{ old('id_siswa') }}";
        const oldKelasId = "{{ old('id_kelas_form') }}";
        if (oldKelasId) {
            $('#form_select_kelas').val(oldKelasId).trigger('change');
            if (oldSiswaId) {
                setTimeout(() => {
                    $('#form_select_siswa').val(oldSiswaId).trigger('change');
                }, 150);
            }
        }
    });

    // Dynamic Filter Student by Class & Display Wali Kelas Info (Select2 Compatible)
    function filterSiswaByKelasForm() {
        const selectKelas = document.getElementById('form_select_kelas');
        const selectedKelasId = $('#form_select_kelas').val();

        const waliBadge = document.getElementById('form_wali_kelas_badge');
        const waliText  = document.getElementById('form_wali_kelas_text');

        if (!selectedKelasId) {
            waliBadge.style.display = 'none';
            waliBadge.className = 'wali-kelas-badge';
            waliText.textContent = '-- Pilih Kelas Terlebih Dahulu --';
        } else {
            const selectedOption = selectKelas.options[selectKelas.selectedIndex];
            const waliNama = selectedOption ? selectedOption.getAttribute('data-wali-nama') : '';
            const waliNip  = selectedOption ? selectedOption.getAttribute('data-wali-nip') : '';

            if (waliNama && waliNama.trim() !== '') {
                const nipStr = (waliNip && waliNip.trim() !== '') ? ` (NIP: ${waliNip})` : '';
                waliText.innerHTML = `Wali Kelas: <strong>${waliNama}</strong>${nipStr}`;
                waliBadge.className = 'wali-kelas-badge';
                waliBadge.style.display = 'inline-flex';
            } else {
                waliText.innerHTML = `Wali Kelas: <em>Belum Ada Wali Kelas Terdaftar</em>`;
                waliBadge.className = 'wali-kelas-badge empty';
                waliBadge.style.display = 'inline-flex';
            }
        }

        // Filter Student Select2 Dropdown
        const $siswaSelect = $('#form_select_siswa');
        $siswaSelect.empty();

        if (!selectedKelasId) {
            $siswaSelect.append(new Option('-- Pilih Kelas Terlebih Dahulu --', '', true, true));
            $siswaSelect.prop('disabled', true);
            $siswaSelect.trigger('change');
            return;
        }

        const filteredSiswa = allSiswaMaster.filter(s => String(s.id_kelas) === String(selectedKelasId));

        if (filteredSiswa.length === 0) {
            $siswaSelect.append(new Option('-- Tidak Ada Siswa Terdaftar di Kelas Ini --', '', true, true));
            $siswaSelect.prop('disabled', true);
        } else {
            $siswaSelect.prop('disabled', false);
            $siswaSelect.append(new Option('-- Cari / Pilih Siswa yang Izin --', '', true, true));
            filteredSiswa.forEach(s => {
                const label = `${s.nama} (${s.nama_kelas})${s.nis ? ' - NIS/NISN: ' + s.nis : ''}`;
                $siswaSelect.append(new Option(label, s.id));
            });
        }

        $siswaSelect.trigger('change');
    }

    // Live Calculate Durasi Hari & Strict Date Validation
    function calculateDurasiLive() {
        const tglMulaiInput = document.getElementById('form_tgl_mulai');
        const tglSelesaiInput = document.getElementById('form_tgl_selesai');
        const durasiBadge = document.getElementById('durasiPillBadge');
        const warningBox = document.getElementById('dateValidationWarning');
        const btnSubmit = document.getElementById('btnSubmitForm');

        if (!tglMulaiInput || !tglSelesaiInput) return;

        const valMulai = tglMulaiInput.value;
        const valSelesai = tglSelesaiInput.value;

        if (!valMulai || !valSelesai) return;

        const dateMulai = new Date(valMulai);
        const dateSelesai = new Date(valSelesai);

        if (dateSelesai < dateMulai) {
            tglSelesaiInput.classList.add('is-invalid');
            if (warningBox) warningBox.style.display = 'flex';
            if (durasiBadge) {
                durasiBadge.textContent = 'Invalid Date';
                durasiBadge.style.background = '#fee2e2';
                durasiBadge.style.color = '#991b1b';
            }
            if (btnSubmit) {
                btnSubmit.disabled = true;
                btnSubmit.style.opacity = '0.5';
                btnSubmit.style.cursor = 'not-allowed';
            }
        } else {
            tglSelesaiInput.classList.remove('is-invalid');
            if (warningBox) warningBox.style.display = 'none';
            if (btnSubmit) {
                btnSubmit.disabled = false;
                btnSubmit.style.opacity = '1';
                btnSubmit.style.cursor = 'pointer';
            }

            const diffTime = Math.abs(dateSelesai - dateMulai);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

            if (durasiBadge) {
                durasiBadge.textContent = diffDays + ' Hari';
                durasiBadge.style.background = '#e0e7ff';
                durasiBadge.style.color = '#3730a3';
            }
        }
    }

    function calculateEditDurasi() {
        const tglMulaiInput = document.getElementById('edit_tanggal');
        const tglSelesaiInput = document.getElementById('edit_tanggal_selesai');
        const durasiBadge = document.getElementById('editDurasiPill');

        if (!tglMulaiInput || !tglSelesaiInput) return;

        const valMulai = tglMulaiInput.value;
        const valSelesai = tglSelesaiInput.value;

        if (!valMulai || !valSelesai) return;

        const dateMulai = new Date(valMulai);
        const dateSelesai = new Date(valSelesai);

        if (dateSelesai >= dateMulai) {
            const diffTime = Math.abs(dateSelesai - dateMulai);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            if (durasiBadge) durasiBadge.textContent = diffDays + ' Hari';
        } else {
            if (durasiBadge) durasiBadge.textContent = 'Invalid';
        }
    }

    // Reset Form Custom
    function resetFormCustom() {
        document.getElementById('suratIzinInputForm').reset();
        $('#form_select_kelas').val('').trigger('change');
        filterSiswaByKelasForm();
        calculateDurasiLive();
    }

    // Open Detail Modal
    function openDetailModal(item) {
        const namaSiswa = item.nama_siswa || 'Siswa';
        const namaKelas = item.nama_kelas || '-';
        const nis       = item.nis || '-';

        const nameParts = namaSiswa.split(' ');
        const initials = nameParts.length >= 2
            ? (nameParts[0][0] + nameParts[1][0]).toUpperCase()
            : namaSiswa.substring(0, 2).toUpperCase();

        document.getElementById('det_avatar').textContent = initials;
        document.getElementById('det_nama_siswa').textContent = namaSiswa;
        document.getElementById('det_kelas_nis').textContent = `Kelas: ${namaKelas} | NIS: ${nis}`;

        // Wali Kelas Info
        const waliNama = item.wali_nama;
        const waliNip  = item.wali_nip;
        if (waliNama && waliNama.trim() !== '') {
            const nipStr = waliNip ? ` (NIP: ${waliNip})` : '';
            document.getElementById('det_wali_kelas').innerHTML = `<strong>${waliNama}</strong>${nipStr}`;
        } else {
            document.getElementById('det_wali_kelas').innerHTML = `<em style="color:#94a3b8;">Belum Ada Wali Kelas</em>`;
        }

        document.getElementById('det_kategori').textContent = item.kategori;
        
        const statusVal = item.status || 'Terverifikasi';
        const detStatusEl = document.getElementById('det_status');
        detStatusEl.textContent = statusVal;
        if (statusVal === 'Terverifikasi') {
            detStatusEl.style.color = '#059669';
        } else if (statusVal === 'Ditolak') {
            detStatusEl.style.color = '#dc2626';
        } else {
            detStatusEl.style.color = '#d97706';
        }

        const tglMulaiFmt   = formatDateIndo(item.tanggal);
        const tglSelesaiFmt = item.tanggal_selesai ? formatDateIndo(item.tanggal_selesai) : tglMulaiFmt;
        const durasiText    = (item.durasi_hari > 0 ? item.durasi_hari : 1) + ' Hari';

        document.getElementById('det_tgl_mulai').textContent = tglMulaiFmt;
        document.getElementById('det_tgl_selesai').textContent = tglSelesaiFmt;
        document.getElementById('det_durasi').textContent = `${durasiText} (${tglMulaiFmt} ${tglMulaiFmt !== tglSelesaiFmt ? 's/d ' + tglSelesaiFmt : ''})`;

        document.getElementById('det_keterangan').textContent = item.keterangan || '-';

        // Petugas Piket Info with NIP
        const petNama = item.petugas_nama || 'Guru Piket';
        const petNip  = item.petugas_nip || '-';
        document.getElementById('det_petugas').innerHTML = `<strong>${petNama}</strong> (NIP: ${petNip})`;
        
        document.getElementById('det_waktu_input').textContent = item.created_at ? formatDateIndoTime(item.created_at) : '-';

        const fotoContainer = document.getElementById('det_foto_container');
        const fotoImg = document.getElementById('det_foto_img');
        if (item.foto_url) {
            fotoImg.src = item.foto_url;
            fotoContainer.style.display = 'block';
        } else {
            fotoContainer.innerHTML = '<span style="font-size: 12px; color: #94a3b8; font-style: italic;">Tidak ada foto bukti yang terlampir.</span>';
        }

        document.getElementById('detailModal').classList.add('active');
    }

    function closeDetailModal(e) {
        if (e.target.id === 'detailModal') closeDetailModalDirect();
    }

    function closeDetailModalDirect() {
        document.getElementById('detailModal').classList.remove('active');
    }

    // Modal Foto Lightbox
    function showFotoModal(imgUrl, title) {
        document.getElementById('modalFotoImg').src = imgUrl;
        document.getElementById('modalFotoTitle').textContent = title;
        document.getElementById('fotoModal').classList.add('active');
    }

    function closeFotoModal(e) {
        if (e.target.id === 'fotoModal') closeFotoModalDirect();
    }

    function closeFotoModalDirect() {
        document.getElementById('fotoModal').classList.remove('active');
    }

    // Modal Edit
    function openEditModal(item) {
        const form = document.getElementById('editForm');
        form.action = `/guru-piket/surat-izin-siswa/${item.id_surat_izin}`;
        document.getElementById('edit_siswa_nama').value = (item.nama_siswa || 'Siswa') + ' (' + (item.nama_kelas || '-') + ')';
        
        const waliNama = item.wali_nama;
        const waliNip  = item.wali_nip;
        if (waliNama && waliNama.trim() !== '') {
            document.getElementById('edit_wali_kelas').value = waliNama + (waliNip ? ` (NIP: ${waliNip})` : '');
        } else {
            document.getElementById('edit_wali_kelas').value = 'Belum Ada Wali Kelas';
        }

        document.getElementById('edit_tanggal').value = item.tanggal;
        document.getElementById('edit_tanggal_selesai').value = item.tanggal_selesai || item.tanggal;
        document.getElementById('edit_kategori').value = item.kategori;
        document.getElementById('edit_status').value = item.status || 'Terverifikasi';
        document.getElementById('edit_keterangan').value = item.keterangan || '';

        // Existing Photo Preview in Edit Modal
        const previewImg = document.getElementById('edit_foto_preview_img');
        const noneText   = document.getElementById('edit_foto_none_text');
        if (item.foto_url) {
            previewImg.src = item.foto_url;
            previewImg.style.display = 'inline-block';
            noneText.style.display = 'none';
        } else {
            previewImg.style.display = 'none';
            noneText.style.display = 'block';
        }

        calculateEditDurasi();
        document.getElementById('editModal').classList.add('active');
    }

    function closeEditModal(e) {
        if (e.target.id === 'editModal') closeEditModalDirect();
    }

    function closeEditModalDirect() {
        document.getElementById('editModal').classList.remove('active');
    }

    // Helper Date Formatters
    function formatDateIndo(dateStr) {
        if (!dateStr) return '-';
        const d = new Date(dateStr);
        if (isNaN(d)) return dateStr;
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
    }

    function formatDateIndoTime(dateStr) {
        if (!dateStr) return '-';
        const d = new Date(dateStr);
        if (isNaN(d)) return dateStr;
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) + ' ' + d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }

    // Fitur Checkbox & Hapus Massal Surat Izin Siswa
    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.surat-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
        });
        updateSelectedState();
    }

    function updateSelectedState() {
        const checkboxes = document.querySelectorAll('.surat-checkbox');
        const checkedBoxes = document.querySelectorAll('.surat-checkbox:checked');
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
        const checkedBoxes = document.querySelectorAll('.surat-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Silakan pilih minimal satu data surat izin yang mau dihapus.');
            return;
        }

        document.getElementById('modalBulkCount').textContent = checkedBoxes.length;
        document.getElementById('bulkDeleteModal').style.display = 'flex';
    }

    function closeBulkDeleteModal() {
        document.getElementById('bulkDeleteModal').style.display = 'none';
    }

    function executeBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.surat-checkbox:checked');
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
@endsection

<!-- Form Hidden untuk Hapus Massal Surat Izin -->
<form id="bulkDeleteForm" action="{{ route('piket.surat-izin-siswa.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="bulkDeleteInputsContainer"></div>
</form>

<!-- Modal Konfirmasi Hapus Massal Surat Izin -->
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
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCount" style="color: #ef4444;">0</strong> data surat izin siswa yang dipilih ke fitur Sampah?
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
