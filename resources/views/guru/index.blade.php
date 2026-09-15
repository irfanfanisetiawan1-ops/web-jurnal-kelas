@extends('layouts.admin')

@section('title', 'Data Guru — EDU JOURNAL')

@section('styles')
<style>
    .breadcrumb-text {
        font-size: 14px;
        color: #475569;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .breadcrumb-text span {
        color: #0f172a;
        font-weight: 800;
    }

    .card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }

    .card-top-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .card-top-header h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-top-header p {
        font-size: 13px;
        color: #64748b;
    }

    .btn-trash {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-trash:hover {
        background: #fde68a;
        color: #78350f;
    }
    .btn-trash .badge-count {
        background: #d97706;
        color: #ffffff;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 20px;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        padding: 11px 16px;
        border-radius: 12px;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .form-control:focus {
        background: #ffffff;
        border-color: #3b5490;
        box-shadow: 0 0 0 3px rgba(59, 84, 144, 0.15);
    }

    .btn-submit-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 16px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #3b5490, #2563eb);
        color: white;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }
    .btn-submit:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }

    /* Filter & Reset Buttons */
    .btn-filter {
        background: #3b5490;
        color: #ffffff;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(59, 84, 144, 0.2);
    }
    .btn-filter:hover {
        background: #2e4375;
        color: #ffffff;
    }

    .btn-reset {
        background: #fbbf24;
        color: #78350f;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(251, 191, 36, 0.2);
    }
    .btn-reset:hover {
        background: #f59e0b;
        color: #78350f;
    }

    /* Table Custom */
    .table-responsive {
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        padding: 14px 16px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tr:hover td {
        background: #f8fafc;
    }

    /* Action Buttons Container & Pills */
    .action-buttons {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 13px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        line-height: 1.2;
    }

    /* 1. Lihat (Detail) Button - Blue/Sky */
    .btn-view {
        background: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }
    .btn-view:hover {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
        box-shadow: 0 3px 8px rgba(2, 132, 199, 0.25);
    }

    /* 2. Edit Button - Amber/Yellow */
    .btn-edit {
        background: #fef3c7;
        color: #b45309;
        border-color: #fde68a;
    }
    .btn-edit:hover {
        background: #d97706;
        color: #ffffff;
        border-color: #d97706;
        box-shadow: 0 3px 8px rgba(217, 119, 6, 0.25);
    }

    /* 3. Hapus Button - Rose/Red */
    .btn-delete {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-delete:hover {
        background: #e11d48;
        color: #ffffff;
        border-color: #e11d48;
        box-shadow: 0 3px 8px rgba(225, 29, 72, 0.25);
    }

    /* Toggle Switch ON/OFF Real-time Styling */
    .guru-status-switch-wrapper {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        user-select: none;
    }

    .guru-toggle-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
        margin: 0;
        cursor: pointer;
    }

    .guru-toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }

    .guru-toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 24px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    .guru-toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25);
    }

    .guru-toggle-switch input:checked + .guru-toggle-slider {
        background-color: #22c55e;
    }

    .guru-toggle-switch input:focus + .guru-toggle-slider {
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2), inset 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    .guru-toggle-switch input:checked + .guru-toggle-slider:before {
        transform: translateX(20px);
    }

    .guru-toggle-switch input:disabled + .guru-toggle-slider {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .guru-status-label {
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.2px;
        transition: color 0.2s;
        min-width: 48px;
        text-align: left;
    }

    .guru-status-label.status-on {
        color: #16a34a;
    }

    .guru-status-label.status-off {
        color: #64748b;
    }

    /* Floating Real-time Toast */
    .realtime-toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 999999;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        border-radius: 12px;
        background: #0f172a;
        color: #ffffff;
        font-size: 13.5px;
        font-weight: 600;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
    }

    .realtime-toast.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    .realtime-toast.toast-success {
        border-left: 5px solid #22c55e;
    }

    .realtime-toast.toast-error {
        border-left: 5px solid #ef4444;
    }

    .badge-role {
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }
    .badge-role-tu {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .badge-role-guru {
        background: #e0e7ff;
        color: #3730a3;
        border: 1px solid #c7d2fe;
    }

    .badge-jk {
        padding: 3px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
    }
    .badge-jk-l { background: #e0f2fe; color: #0369a1; }
    .badge-jk-p { background: #fce7f3; color: #be185d; }

    /* Alert Styling */
    .alert-custom {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert-error {
        background: #fff1f2;
        color: #9f1239;
        border: 1px solid #fecdd3;
    }

    /* Modal Overlay */
    .modal-bg {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px);
        z-index: 200;
        align-items: center;
        justify-content: center;
    }
    .modal-bg.active { display: flex; }
    .modal-box {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        max-width: 420px;
        width: 90%;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        text-align: center;
    }
    .modal-icon-wrap {
        width: 52px;
        height: 52px;
        background: #ffe4e6;
        color: #be123c;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
    }
    .modal-box h3 { font-size: 19px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
    .modal-box p { font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.5; }
    .modal-actions { display: flex; gap: 12px; }
    .btn-m-cancel {
        flex: 1;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 11px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
    }
    .btn-m-confirm {
        flex: 1;
        background: linear-gradient(135deg, #e11d48, #be123c);
        color: #ffffff;
        border: none;
        padding: 11px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.3);
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Master Data — Guru</h1>
            <p>Kelola data induk guru, NIP, status kepegawaian, dan informasi pengajar</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <i class="fa-solid fa-user-tie"></i>
        <span>Data Guru</span>
    </div>

    @if(session('success'))
        <div class="alert-custom alert-success">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-circle-check" style="font-size:18px;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-custom alert-error">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:18px;"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- Card 1: Form Tambah Guru -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-user-plus" style="color:#2563eb;"></i> Tambah Guru</h2>
                <p>Masukkan detail data guru untuk pendaftaran baru.</p>
            </div>
        </div>

        <!-- Alert Banner Alasan Gagal Simpan (JS Generated) -->
        <div id="formErrorReasonBanner" class="alert-custom alert-error" style="display: none; margin-bottom: 20px;">
            <div style="display:flex; align-items:flex-start; gap:12px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:22px; color:#dc2626; flex-shrink:0; margin-top:2px;"></i>
                <div>
                    <h4 style="font-size:15px; font-weight:800; margin:0 0 4px 0; color:#9f1239;">Data belum bisa disimpan! Silakan perbaiki pengisian berikut:</h4>
                    <ul id="formErrorReasonList" style="margin: 4px 0 0 18px; padding: 0; font-size: 13.5px; color: #881337; line-height: 1.6;"></ul>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('formErrorReasonBanner').style.display='none'" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form id="formGuruIndex" action="{{ route('guru.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-grid-3">
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nip" style="margin-bottom: 0;">NIP (18 Digit) <span style="color:#ef4444;">*</span></label>
                        <span id="nipCounter" style="font-size: 12px; font-weight: 700; color: #ef4444;">0/18 digit</span>
                    </div>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                        class="form-control @error('nip') is-invalid @enderror"
                        placeholder="Contoh: 198501012010011001" maxlength="18" minlength="18" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18); updateNipCounter(this, 18, 'nipMsg');"
                        required>
                    <small id="nipMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi tepat 18 digit angka.</small>
                    @error('nip')
                        <small style="color:#ef4444; font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_guru">Nama Lengkap Guru <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_guru" name="nama_guru" value="{{ old('nama_guru') }}" class="form-control @error('nama_guru') is-invalid @enderror" placeholder="Masukkan Nama Lengkap" required>
                    @error('nama_guru')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span style="color:#ef4444;">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                    @error('jenis_kelamin')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="no_hp">Nomor HP / WA <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                        class="form-control @error('no_hp') is-invalid @enderror"
                        placeholder="Contoh: 081234567890" maxlength="15" minlength="10" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15); updateNoHpCounter(this, 'noHpMsg');"
                        required>
                    <small id="noHpMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi 10 - 15 digit angka.</small>
                    @error('no_hp')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_mapel">Mata Pelajaran Utama</label>
                    <select id="id_mapel" name="id_mapel" class="form-control">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ old('id_mapel') == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="btn-submit-container" style="display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap; gap: 12px;">
                <button type="button" onclick="document.getElementById('formGuruIndex').reset(); const counter=document.getElementById('nipCounter'); if(counter) counter.textContent='0/18 digit'; const hpCounter=document.getElementById('noHpCounter'); if(hpCounter) hpCounter.textContent='0/15 digit';" class="btn-reset-form" style="background:#fbbf24; color:#78350f; border:1px solid #fde68a; padding:10px 20px; border-radius:10px; font-weight:700; margin:0;" title="Kosongkan Isian Form">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-submit" style="margin:0;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data Guru
                </button>
            </div>
        </form>
    </div>

    <!-- Card 1.25: Fitur Tambah Guru Baru via Import File (Multi-Format: PDF, Word, Excel, CSV) -->
    <div class="card" style="border-top: 4px solid #0d9488; background: #ffffff; box-shadow: 0 4px 20px rgba(13, 148, 136, 0.08); border-radius: 16px;">
        <div class="card-top-header" style="padding-bottom: 14px; border-bottom: 1px solid #f1f5f9; margin-bottom: 18px;">
            <div>
                <h2 style="font-size: 19px; font-weight: 800; color: #0f172a; margin: 0;">
                    Tambah Guru Baru via Import File
                </h2>
            </div>
        </div>

        <!-- Feedback Alert Banner Pasca Proses File (JS Generated) -->
        <div id="guruImportAlert" class="alert-custom" style="display: none; margin-bottom: 20px;">
            <div style="display:flex; align-items:flex-start; gap:12px; width: 100%;">
                <i id="guruAlertIcon" class="fa-solid fa-circle-check" style="font-size:22px; flex-shrink:0; margin-top:2px;"></i>
                <div style="flex: 1;">
                    <h4 id="guruAlertTitle" style="font-size:15px; font-weight:800; margin:0 0 4px 0;"></h4>
                    <p id="guruAlertMsg" style="margin:0; font-size:13.5px; line-height:1.5;"></p>
                    <ul id="guruAlertDetails" style="margin: 6px 0 0 18px; padding: 0; font-size: 12.5px; line-height: 1.5; display: none;"></ul>
                </div>
                <button type="button" onclick="document.getElementById('guruImportAlert').style.display='none'" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div id="guruImportLoading" style="display:none; text-align:center; padding:20px; background:#f0fdfa; border-radius:12px; border:1px solid #99f6e4; margin-bottom:16px;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size:28px; color:#0d9488;"></i>
            <p id="guruImportLoadingMsg" style="margin:10px 0 0; color:#0f766e; font-weight:700; font-size:14px;">Sedang membaca file data guru...</p>
        </div>

        <!-- Form Import Controls Container -->
        <div class="form-grid-3" style="align-items: flex-end; background: #f8fafc; padding: 20px; border-radius: 14px; border: 1px dashed #cbd5e1;">
            <!-- 1. Pilih File -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="guru_file_input" style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                    Pilih File Data Guru <span style="color:#ef4444;">*</span>
                </label>
                <input type="file" id="guru_file_input" accept=".xlsx,.xls,.csv,.pdf,.doc,.docx" class="form-control" style="padding: 9px; background: #ffffff; cursor: pointer; border-color: #94a3b8;" onchange="onGuruFileSelected(this)">
                <small id="guruFileTypeHint" style="display:block; font-size:11.5px; color:#64748b; margin-top:4px;">
                    Format: <strong>.pdf, .docx, .doc, .xlsx, .xls, .csv</strong> (Maks: 10MB)
                </small>
            </div>

            <!-- 2. Target Mapel (Opsional) -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="guru_target_mapel" style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                    Mapel Utama (Opsional)
                </label>
                <select id="guru_target_mapel" class="form-control" style="background: #ffffff; border-color: #0284c7; font-weight: 600; color: #0369a1;">
                    <option value="">-- Otomatis Dari File / Kosong --</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
                <small style="display:block; font-size:11.5px; color:#64748b; margin-top:4px;">
                    Pilih jika file tidak menyertakan kolom mapel.
                </small>
            </div>

            <!-- 3. Mode Masukkan Data -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="guru_import_mode" style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                    Mode Masukkan Data
                </label>
                <select id="guru_import_mode" class="form-control" style="background: #ffffff; border-color: #8b5cf6; font-weight: 600; color: #6d28d9;">
                    <option value="replace">Ganti / Timpa Seluruh Baris Tabel</option>
                    <option value="append">Tambahkan ke Baris Tabel yang Ada</option>
                </select>
                <small style="display:block; font-size:11.5px; color:#64748b; margin-top:4px;">
                    Pilih apakah data file menggantikan atau menambah baris.
                </small>
            </div>
        </div>

        <div style="margin-top: 20px; display: flex; justify-content: flex-end; align-items: center; gap: 12px; flex-wrap: wrap;">
            <button type="button" onclick="clearGuruFileInput()" class="btn-reset" style="padding: 10px 20px; border-radius: 10px; background: #fbbf24; color: #78350f; border: 1px solid #fde68a; font-weight: 700; margin:0;">
                <i class="fa-solid fa-rotate-left"></i> Reset File
            </button>
            <button type="button" id="btnProcessGuruFile" onclick="processGuruImportFile()" class="btn-submit" style="background: #2563eb; padding: 11px 24px; border-radius: 10px; font-size: 13.5px; font-weight: 700; margin:0;">
                <i class="fa-solid fa-file-import"></i> Proses File Data Guru
            </button>
        </div>
    </div>

    <!-- Card 1.5: Form Tambah Guru Secara Cepat dan Banyak -->
    <div class="card" style="border-top: 4px solid #10b981;">
        <div class="card-top-header">
            <div>
                <h2 style="margin: 0; font-size: 19px; font-weight: 800; color: #0f172a;">
                    Tambah Guru Secara Cepat dan Banyak
                </h2>
                <p style="margin-top: 4px; color: #64748b; font-size: 13px;">Masukkan data banyak guru sekaligus secara massal lalu simpan dalam sekali klik.</p>
            </div>
        </div>

        @if($errors->has('guru') || $errors->has('guru.*'))
            <div class="alert-custom alert-error" style="margin-bottom: 20px; background: #fef2f2; border: 1px solid #fca5a5; border-radius: 12px; padding: 16px;">
                <div style="display:flex; align-items:flex-start; gap:12px;">
                    <i class="fa-solid fa-circle-exclamation" style="font-size:20px; color:#dc2626; margin-top:2px;"></i>
                    <div>
                        <h4 style="margin:0 0 6px 0; font-size:14px; font-weight:800; color:#991b1b;">Terdapat Kesalahan Pengisian Data Guru Massal:</h4>
                        <ul style="margin:0; padding-left:18px; color:#991b1b; font-size:13px; line-height:1.5;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form id="formGuruBulk" action="{{ route('guru.store-batch') }}" method="POST">
            @csrf

            <!-- Bulk Toolbar Controls -->
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px; background:#f8fafc; padding:12px 16px; border-radius:12px; border:1px solid #e2e8f0;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <button type="button" onclick="addBulkGuruRow()" class="btn-action" style="background:#64748b; color:#ffffff; border:none; padding:8px 14px; border-radius:8px; font-size:12.5px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-plus"></i> + Tambah Baris Guru
                    </button>
                    <button type="button" onclick="addBulkGuruRows(5)" class="btn-action" style="background:#64748b; color:#ffffff; border:none; padding:8px 14px; border-radius:8px; font-size:12.5px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-layer-group"></i> + 5 Baris
                    </button>
                    <button type="button" onclick="resetAllBulkGuruFields()" class="btn-action" style="background:#fbbf24; color:#78350f; border:1px solid #fde68a; padding:8px 14px; border-radius:8px; font-size:12.5px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;" title="Kosongkan Isian Teks Tanpa Menghapus Baris">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </button>
                    <button type="button" onclick="clearBulkGuruRows()" class="btn-action" style="background:#fef2f2; color:#ef4444; border:1px solid #fca5a5; padding:8px 14px; border-radius:8px; font-size:12.5px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;" title="Kosongkan Seluruh Tabel">
                        <i class="fa-solid fa-trash"></i> Kosongkan Tabel
                    </button>
                </div>
                <div style="font-size:13px; font-weight:700; color:#475569;">
                    Total: <span id="bulkGuruRowCount" style="color:#0f172a; font-weight:800;">0</span> baris guru
                </div>
            </div>

            <!-- Table Bulk Guru -->
            <div style="overflow-x:auto; margin-bottom:20px; border:1px solid #e2e8f0; border-radius:12px;">
                <table class="table-custom" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f1f5f9; text-align:left;">
                            <th style="width:45px; text-align:center; padding:10px; font-size:12px; font-weight:800; color:#334155;">NO.</th>
                            <th style="width:200px; padding:10px; font-size:12px; font-weight:800; color:#334155;">NIP (18 DIGIT) <span style="color:#ef4444;">*</span></th>
                            <th style="padding:10px; font-size:12px; font-weight:800; color:#334155;">NAMA LENGKAP GURU <span style="color:#ef4444;">*</span></th>
                            <th style="width:140px; padding:10px; font-size:12px; font-weight:800; color:#334155;">JENIS KELAMIN <span style="color:#ef4444;">*</span></th>
                            <th style="width:160px; padding:10px; font-size:12px; font-weight:800; color:#334155;">NOMOR HP / WA <span style="color:#ef4444;">*</span></th>
                            <th style="width:200px; padding:10px; font-size:12px; font-weight:800; color:#334155;">MAPEL UTAMA (OPSIONAL)</th>
                            <th style="width:70px; text-align:center; padding:10px; font-size:12px; font-weight:800; color:#334155;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="bulkGuruTableBody">
                        <!-- Dynamic Rows Injected by JS -->
                    </tbody>
                </table>
            </div>

            <div class="btn-submit-container" style="display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap; gap: 12px;">
                <button type="button" onclick="clearBulkGuruRows(); addBulkGuruRows(3);" class="btn-reset-form" style="background:#fbbf24; color:#78350f; border:1px solid #fde68a; padding:10px 20px; border-radius:10px; font-weight:700; margin:0;" title="Kosongkan Isian Form Tabel">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-submit" style="margin:0; background:#2563eb; padding:11px 24px;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data Guru
                </button>
            </div>
        </form>
    </div>

    <!-- Card 2: Daftar Data Guru -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-users" style="color:#3b5490;"></i> Data Guru ({{ count($gurus) }})</h2>
                <p>Kelola seluruh informasi tenaga pengajar sekolah.</p>
            </div>
        </div>

        <form action="{{ route('guru.index') }}" method="GET" style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom:20px; background:#f8fafc; padding:14px 18px; border-radius:14px; border:1px solid #cbd5e1;">
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" name="search" class="form-control" style="width: 200px; padding-left:36px; background:#ffffff;" value="{{ $search ?? '' }}" placeholder="Cari Nama / NIP...">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                </div>

                <select name="id_mapel" class="form-control" style="width: 150px; background:#ffffff;">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}" {{ (isset($id_mapel) && $id_mapel == $m->id_mapel) ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>

                <select name="jenis_kelamin" class="form-control" style="width: 130px; background:#ffffff;">
                    <option value="">Semua JK</option>
                    <option value="L" {{ (isset($jenis_kelamin) && $jenis_kelamin == 'L') ? 'selected' : '' }}>Laki-laki (L)</option>
                    <option value="P" {{ (isset($jenis_kelamin) && $jenis_kelamin == 'P') ? 'selected' : '' }}>Perempuan (P)</option>
                </select>

                <select name="role" class="form-control" style="width: 140px; background:#ffffff;">
                    <option value="">Semua Role</option>
                    <option value="guru" {{ (isset($role) && $role == 'guru') ? 'selected' : '' }}>Guru</option>
                    <option value="tu" {{ (isset($role) && $role == 'tu') ? 'selected' : '' }}>TU (Admin)</option>
                    <option value="piket" {{ (isset($role) && $role == 'piket') ? 'selected' : '' }}>Piket</option>
                    <option value="wali_kelas" {{ (isset($role) && $role == 'wali_kelas') ? 'selected' : '' }}>Wali Kelas</option>
                </select>

                <select name="status" class="form-control" style="width: 140px; background:#ffffff;">
                    <option value="">Semua Status</option>
                    <option value="active" {{ (isset($status) && $status == 'active') ? 'selected' : '' }}>Aktif (ON)</option>
                    <option value="inactive" {{ (isset($status) && $status == 'inactive') ? 'selected' : '' }}>Nonaktif (OFF)</option>
                </select>
            </div>

            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto;">
                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('guru.index') }}" class="btn-reset">Reset</a>
                <a href="{{ route('guru.trash') }}" class="btn-trash" style="padding: 10px 18px; border-radius: 12px; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;" title="Lihat Data Guru di Tempat Sampah">
                    <i class="fa-solid fa-trash-can"></i> Lihat Sampah
                    @if(isset($trashedCount) && $trashedCount > 0)
                        <span class="badge-count">{{ $trashedCount }}</span>
                    @endif
                </a>
                <button type="button" id="btnBulkDelete" class="btn-action btn-delete" style="padding: 10px 18px; border-radius: 12px; font-size: 13.5px; opacity: 0.5; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(225,29,72,0.15); border: none;" disabled onclick="confirmBulkDelete()" title="Pilih guru dengan mencentang checkbox untuk menghapus secara massal">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="bulkDeleteCount">0</span>)
                </button>
            </div>
        </form>

        <form id="formBulkDelete" action="{{ route('guru.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllGuru" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" title="Pilih Semua (Select All)">
                            </th>
                            <th>NIP</th>
                            <th>NAMA GURU / PEGAWAI</th>
                            <th>JK</th>
                            <th>ROLE</th>
                            <th>NO HP</th>
                            <th>MAPEL UTAMA</th>
                            <th style="text-align:center; min-width: 130px;">STATUS</th>
                            <th style="text-align:center; min-width: 220px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $g)
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $g->id_guru }}" class="guru-select-checkbox" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" onchange="updateBulkDeleteState()">
                                </td>
                                <td><span style="font-family:monospace; font-weight:700; color:#3b5490;">{{ $g->nip }}</span></td>
                                <td><strong>{{ $g->nama_guru }}</strong></td>
                                <td>
                                    @if($g->jenis_kelamin == 'L')
                                        <span class="badge-jk badge-jk-l">Laki-laki</span>
                                    @elseif($g->jenis_kelamin == 'P')
                                        <span class="badge-jk badge-jk-p">Perempuan</span>
                                    @else
                                        <span style="color:#94a3b8;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($g->user) && $g->user->isAdmin())
                                        <span class="badge-role badge-role-tu">TU</span>
                                    @else
                                        <span class="badge-role badge-role-guru">GURU</span>
                                    @endif
                                </td>
                                <td>{{ $g->no_hp ?? '-' }}</td>
                                <td>{{ $g->mapel->nama_mapel ?? '-' }}</td>
                                <td style="text-align: center; white-space: nowrap;">
                                    <div class="guru-status-switch-wrapper" style="justify-content: center;">
                                        <label class="guru-toggle-switch" title="{{ $g->isActive() ? 'Klik untuk Menonaktifkan Data Guru ini (OFF)' : 'Klik untuk Mengaktifkan Data Guru ini (ON)' }}">
                                            <input type="checkbox" 
                                                   id="toggle-guru-{{ $g->id_guru }}" 
                                                   class="guru-active-checkbox"
                                                   {{ $g->isActive() ? 'checked' : '' }} 
                                                   onchange="handleGuruToggle(this, {{ $g->id_guru }}, '{{ addslashes($g->nama_guru) }}')">
                                            <span class="guru-toggle-slider"></span>
                                        </label>
                                        <span class="guru-status-label {{ $g->isActive() ? 'status-on' : 'status-off' }}" id="status-label-guru-{{ $g->id_guru }}">
                                            {{ $g->isActive() ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                </td>
                                <td style="text-align:center;">
                                    <div class="action-buttons">
                                        <!-- 1. LIHAT (Detail) - Disebelah kiri Edit & Hapus -->
                                        <a href="{{ route('guru.show', $g->id_guru) }}" class="btn-action btn-view" title="Lihat Detail Guru">
                                            <i class="fa-solid fa-eye"></i> Lihat
                                        </a>

                                        <!-- 2. EDIT - Disebelah kiri Hapus -->
                                        <a href="{{ route('guru.edit', $g->id_guru) }}" class="btn-action btn-edit" title="Edit Data Guru">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>

                                        <!-- 3. HAPUS - Paling kanan -->
                                        <button type="button" class="btn-action btn-delete" onclick="if(confirm('Apakah Anda yakin ingin memindahkan {{ addslashes($g->nama_guru) }} ke Tempat Sampah?')) { document.getElementById('singleDeleteForm-{{ $g->id_guru }}').submit(); }" title="Hapus Guru">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align:center; padding:36px; color:#94a3b8;">
                                    <i class="fa-solid fa-folder-open" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                    Belum ada data Guru & Pegawai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @foreach($gurus as $g)
            <form id="singleDeleteForm-{{ $g->id_guru }}" action="{{ route('guru.destroy', $g->id_guru) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    </div>

    <!-- Modal Confirm Bulk Delete -->
    <div class="modal-bg" id="modalConfirmBulkDelete">
        <div class="modal-box">
            <div class="modal-icon-wrap">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h3>Konfirmasi Hapus Terpilih</h3>
            <p>Apakah Anda yakin ingin memindahkan <strong id="modalBulkCountText" style="color:#e11d48;">0 data guru</strong> yang dicentang ke Tempat Sampah?</p>
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeBulkDeleteModal()">Batal</button>
                <button type="button" class="btn-m-confirm" onclick="submitBulkDelete()">Ya, Hapus Data</button>
            </div>
        </div>
    </div>

    <script>
        function updateNipCounter(input, targetLen = 18, msgId = 'nipMsg') {
            const counter = document.getElementById('nipCounter');
            const msgEle  = document.getElementById(msgId);
            const len     = input.value.length;

            if (counter) {
                counter.textContent = len + '/' + targetLen + ' digit';
                counter.style.color = (len === targetLen) ? '#10b981' : '#ef4444';
            }

            if (msgEle) {
                if (len === 0) {
                    msgEle.textContent = 'Wajib diisi tepat ' + targetLen + ' digit angka.';
                    msgEle.style.color = '#ef4444';
                } else if (len < targetLen) {
                    msgEle.textContent = 'Belum lengkap, baru ' + len + ' digit (kurang ' + (targetLen - len) + ' digit lagi).';
                    msgEle.style.color = '#ef4444';
                } else {
                    msgEle.textContent = '✓ Format NIP ' + targetLen + ' digit angka sudah sesuai.';
                    msgEle.style.color = '#10b981';
                }
            }
        }

        function updateNoHpCounter(input, msgId = 'noHpMsg') {
            const msgEle = document.getElementById(msgId);
            const len    = input.value.length;

            if (msgEle) {
                if (len === 0) {
                    msgEle.textContent = 'Wajib diisi 10 - 15 digit angka.';
                    msgEle.style.color = '#ef4444';
                } else if (len < 10) {
                    msgEle.textContent = 'Belum lengkap, baru ' + len + ' digit (minimal 10 digit angka).';
                    msgEle.style.color = '#ef4444';
                } else {
                    msgEle.textContent = '✓ Format Nomor HP / WA ' + len + ' digit angka sudah sesuai.';
                    msgEle.style.color = '#10b981';
                }
            }
        }

        function updateBulkDeleteState() {
            const checkedBoxes = document.querySelectorAll('.guru-select-checkbox:checked');
            const totalBoxes   = document.querySelectorAll('.guru-select-checkbox');
            const count        = checkedBoxes.length;
            const btnBulkDelete= document.getElementById('btnBulkDelete');
            const countSpan    = document.getElementById('bulkDeleteCount');
            const selectAll    = document.getElementById('selectAllGuru');

            if (countSpan) countSpan.textContent = count;

            if (selectAll && totalBoxes.length > 0) {
                selectAll.checked = (checkedBoxes.length === totalBoxes.length);
            }

            if (btnBulkDelete) {
                if (count > 0) {
                    btnBulkDelete.disabled = false;
                    btnBulkDelete.style.opacity = '1';
                    btnBulkDelete.style.cursor = 'pointer';
                } else {
                    btnBulkDelete.disabled = true;
                    btnBulkDelete.style.opacity = '0.5';
                    btnBulkDelete.style.cursor = 'not-allowed';
                }
            }
        }

        function confirmBulkDelete() {
            const checkedBoxes = document.querySelectorAll('.guru-select-checkbox:checked');
            const count = checkedBoxes.length;

            if (count === 0) {
                alert('Silakan pilih minimal 1 data guru yang ingin dihapus dengan mencentang kotak centang (checkbox).');
                return;
            }

            const modalCountText = document.getElementById('modalBulkCountText');
            if (modalCountText) {
                modalCountText.textContent = count + ' data guru';
            }

            const modal = document.getElementById('modalConfirmBulkDelete');
            if (modal) {
                modal.classList.add('active');
            } else {
                if (confirm(`Apakah Anda yakin ingin memindahkan ${count} data guru yang dipilih ke Tempat Sampah?`)) {
                    document.getElementById('formBulkDelete').submit();
                }
            }
        }

        function closeBulkDeleteModal() {
            const modal = document.getElementById('modalConfirmBulkDelete');
            if (modal) modal.classList.remove('active');
        }

        function submitBulkDelete() {
            document.getElementById('formBulkDelete').submit();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const nip  = document.getElementById('nip');
            const noHp = document.getElementById('no_hp');
            if (nip)  updateNipCounter(nip, 18, 'nipMsg');
            if (noHp) updateNoHpCounter(noHp, 'noHpMsg');

            const selectAll = document.getElementById('selectAllGuru');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.guru-select-checkbox');
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateBulkDeleteState();
                });
            }

            const modalBulk = document.getElementById('modalConfirmBulkDelete');
            if (modalBulk) {
                modalBulk.addEventListener('click', function(e) {
                    if (e.target === this) closeBulkDeleteModal();
                });
            }

            const form = document.getElementById('formGuruIndex');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const errors = [];
                    const nipVal  = document.getElementById('nip').value.trim();
                    const namaVal = document.getElementById('nama_guru').value.trim();
                    const jkVal   = document.getElementById('jenis_kelamin').value;
                    const noHpVal = document.getElementById('no_hp').value.trim();

                    if (!nipVal) {
                        errors.push('NIP wajib diisi 18 digit angka.');
                    } else if (nipVal.length !== 18) {
                        errors.push('NIP harus berisi tepat 18 digit angka (saat ini baru ' + nipVal.length + ' digit).');
                    }

                    if (!namaVal) {
                        errors.push('Nama Lengkap Guru / Pegawai wajib diisi.');
                    }

                    if (!jkVal) {
                        errors.push('Jenis Kelamin wajib dipilih (Laki-laki / Perempuan).');
                    }

                    if (!noHpVal) {
                        errors.push('Nomor HP / WA wajib diisi (10 - 15 digit angka).');
                    } else if (noHpVal.length < 10 || noHpVal.length > 15) {
                        errors.push('Nomor HP / WA harus berisi 10 hingga 15 digit angka (saat ini ' + noHpVal.length + ' digit).');
                    }

                    const banner = document.getElementById('formErrorReasonBanner');
                    const list   = document.getElementById('formErrorReasonList');

                    if (errors.length > 0) {
                        e.preventDefault();
                        list.innerHTML = '';
                        errors.forEach(function(err) {
                            const li = document.createElement('li');
                            li.textContent = err;
                            list.appendChild(li);
                        });
                        banner.style.display = 'flex';
                        banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        banner.style.display = 'none';
                    }
                });
            }
        });
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/mammoth@1.6.0/mammoth.browser.min.js"></script>

<script>
    if (typeof pdfjsLib !== 'undefined') {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    }

    const availableMapelList = @json($mapelList);
    let bulkGuruIndex = 0;

    function addBulkGuruRow(data = {}) {
        const tbody = document.getElementById('bulkGuruTableBody');
        if (!tbody) return;

        const emptyRow = document.getElementById('emptyBulkGuruRow');
        if (emptyRow) emptyRow.remove();

        const tr = document.createElement('tr');
        tr.className = 'bulk-guru-row';

        const nipVal  = data.nip || '';
        const namaVal = data.nama_guru || '';
        const jkVal   = data.jenis_kelamin || '';
        const noHpVal = data.no_hp || '';
        const mapelVal = data.id_mapel || '';

        let mapelOptionsHtml = `<option value="">-- Pilih Mapel --</option>`;
        availableMapelList.forEach(m => {
            const selected = (String(m.id_mapel) === String(mapelVal)) ? 'selected' : '';
            mapelOptionsHtml += `<option value="${m.id_mapel}" ${selected}>${m.nama_mapel}</option>`;
        });

        tr.innerHTML = `
            <td style="text-align:center; padding:10px; font-weight:800; color:#64748b;" class="bulk-guru-no">1</td>
            <td style="padding:8px;">
                <input type="text" name="guru[${bulkGuruIndex}][nip]" value="${nipVal}" class="form-control bulk-nip" placeholder="18 Digit NIP" maxlength="18" minlength="18" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,18);" style="font-weight:600;" required>
            </td>
            <td style="padding:8px;">
                <input type="text" name="guru[${bulkGuruIndex}][nama_guru]" value="${namaVal}" class="form-control bulk-nama" placeholder="Nama Lengkap Guru" style="font-weight:600;" required>
            </td>
            <td style="padding:8px;">
                <select name="guru[${bulkGuruIndex}][jenis_kelamin]" class="form-control bulk-jk" style="font-weight:600;" required>
                    <option value="" disabled ${!jkVal ? 'selected' : ''}>-- Pilih --</option>
                    <option value="L" ${jkVal === 'L' ? 'selected' : ''}>Laki-laki (L)</option>
                    <option value="P" ${jkVal === 'P' ? 'selected' : ''}>Perempuan (P)</option>
                </select>
            </td>
            <td style="padding:8px;">
                <input type="text" name="guru[${bulkGuruIndex}][no_hp]" value="${noHpVal}" class="form-control bulk-nohp" placeholder="081234567890" maxlength="15" minlength="10" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,15);" style="font-weight:600;" required>
            </td>
            <td style="padding:8px;">
                <select name="guru[${bulkGuruIndex}][id_mapel]" class="form-control bulk-mapel" style="font-weight:600;">
                    ${mapelOptionsHtml}
                </select>
            </td>
            <td style="text-align:center; padding:8px;">
                <div style="display:flex; gap:4px; justify-content:center;">
                    <button type="button" onclick="resetBulkGuruRow(this)" style="background:#fef3c7; color:#b45309; border:1px solid #fde68a; width:28px; height:28px; border-radius:6px; cursor:pointer;" title="Reset Baris Ini"><i class="fa-solid fa-rotate-left" style="font-size:11px;"></i></button>
                    <button type="button" onclick="removeBulkGuruRow(this)" style="background:#fef2f2; color:#ef4444; border:1px solid #fca5a5; width:28px; height:28px; border-radius:6px; cursor:pointer;" title="Hapus Baris Ini"><i class="fa-solid fa-trash" style="font-size:11px;"></i></button>
                </div>
            </td>
        `;

        tbody.appendChild(tr);
        bulkGuruIndex++;
        updateBulkGuruRowCount();
    }

    function addBulkGuruRows(count = 5) {
        for (let i = 0; i < count; i++) {
            addBulkGuruRow();
        }
    }

    function removeBulkGuruRow(btn) {
        const tr = btn.closest('tr');
        if (tr) {
            tr.remove();
            updateBulkGuruRowCount();
        }
    }

    function resetBulkGuruRow(btn) {
        const tr = btn.closest('tr');
        if (tr) {
            tr.querySelectorAll('input').forEach(i => i.value = '');
            tr.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        }
    }

    function resetAllBulkGuruFields() {
        const tbody = document.getElementById('bulkGuruTableBody');
        if (!tbody) return;
        tbody.querySelectorAll('input').forEach(i => i.value = '');
        tbody.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
    }

    function clearBulkGuruRows() {
        const tbody = document.getElementById('bulkGuruTableBody');
        if (!tbody) return;
        tbody.innerHTML = `
            <tr id="emptyBulkGuruRow">
                <td colspan="7" style="text-align:center; padding:30px; color:#94a3b8; font-weight:600;">
                    Belum ada baris data guru. Klik <strong>+ Tambah Baris Guru</strong> atau <strong>Proses File Data Guru</strong> di atas.
                </td>
            </tr>
        `;
        bulkGuruIndex = 0;
        updateBulkGuruRowCount();
    }

    function updateBulkGuruRowCount() {
        const tbody = document.getElementById('bulkGuruTableBody');
        const counter = document.getElementById('bulkGuruRowCount');
        if (!tbody || !counter) return;

        const count = tbody.querySelectorAll('tr.bulk-guru-row').length;
        counter.textContent = count;

        if (count === 0 && !document.getElementById('emptyBulkGuruRow')) {
            tbody.innerHTML = `
                <tr id="emptyBulkGuruRow">
                    <td colspan="7" style="text-align:center; padding:30px; color:#94a3b8; font-weight:600;">
                        Belum ada baris data guru. Klik <strong>+ Tambah Baris Guru</strong> atau <strong>Proses File Data Guru</strong> di atas.
                    </td>
                </tr>
            `;
        }

        const rows = tbody.querySelectorAll('tr.bulk-guru-row');
        rows.forEach((r, idx) => {
            const noTd = r.querySelector('.bulk-guru-no');
            if (noTd) noTd.textContent = idx + 1;
        });
    }

    function clearGuruFileInput() {
        const input = document.getElementById('guru_file_input');
        if (input) input.value = '';
        const alert = document.getElementById('guruImportAlert');
        if (alert) alert.style.display = 'none';
        const hint = document.getElementById('guruFileTypeHint');
        if (hint) hint.innerHTML = 'Format: <strong>.pdf, .docx, .doc, .xlsx, .xls, .csv</strong> (Maks: 10MB)';
    }

    function showGuruAlert(type, title, message) {
        const alertDiv = document.getElementById('guruImportAlert');
        const alertIcon = document.getElementById('guruAlertIcon');
        const alertTitle = document.getElementById('guruAlertTitle');
        const alertMsg = document.getElementById('guruAlertMsg');

        if (!alertDiv || !alertTitle || !alertMsg) return;

        if (type === 'success') {
            alertDiv.className = 'alert-success';
            alertDiv.style.background = '#f0fdfa';
            alertDiv.style.borderColor = '#99f6e4';
            alertDiv.style.color = '#115e59';
            alertIcon.className = 'fa-solid fa-circle-check';
            alertIcon.style.color = '#0d9488';
            alertTitle.style.color = '#0f766e';
        } else {
            alertDiv.className = 'alert-danger';
            alertDiv.style.background = '#fef2f2';
            alertDiv.style.borderColor = '#fca5a5';
            alertDiv.style.color = '#991b1b';
            alertIcon.className = 'fa-solid fa-circle-exclamation';
            alertIcon.style.color = '#dc2626';
            alertTitle.style.color = '#7f1d1d';
        }

        alertTitle.textContent = title;
        alertMsg.innerHTML = message;
        alertDiv.style.display = 'block';
    }

    function onGuruFileSelected(input) {
        const hint = document.getElementById('guruFileTypeHint');
        if (!input || !input.files || input.files.length === 0) return;
        const file = input.files[0];
        const ext = file.name.split('.').pop().toLowerCase();
        const sizeKB = (file.size / 1024).toFixed(1);
        const sizeMB = (file.size / (1024*1024)).toFixed(2);
        let typeLabel = '';
        let typeColor = '#64748b';

        if (ext === 'pdf') {
            typeLabel = '📄 PDF Document'; typeColor = '#dc2626';
        } else if (ext === 'docx' || ext === 'doc') {
            typeLabel = '📝 Microsoft Word'; typeColor = '#1e40af';
        } else if (ext === 'xlsx' || ext === 'xls') {
            typeLabel = '📊 Microsoft Excel'; typeColor = '#15803d';
        } else if (ext === 'csv') {
            typeLabel = '📋 CSV File'; typeColor = '#0369a1';
        }

        if (hint) {
            hint.innerHTML = `<span style="color:${typeColor}; font-weight:700;">${typeLabel}</span> — Ukuran: <strong>${sizeMB < 1 ? sizeKB + ' KB' : sizeMB + ' MB'}</strong>`;
        }
    }

    function processGuruImportFile() {
        const input = document.getElementById('guru_file_input');
        if (!input || !input.files || input.files.length === 0) {
            showGuruAlert('error', 'Pilih File Terlebih Dahulu!', 'Silakan klik "Choose File" dan pilih file data guru (.pdf, .docx, .doc, .xlsx, .xls, .csv).');
            return;
        }

        const file = input.files[0];
        const fileName = file.name;
        const ext = fileName.split('.').pop().toLowerCase();

        const loadingDiv = document.getElementById('guruImportLoading');
        const loadingMsg = document.getElementById('guruImportLoadingMsg');
        if (loadingDiv) loadingDiv.style.display = 'block';
        if (loadingMsg) loadingMsg.textContent = `Sedang membaca file (${fileName})...`;

        if (ext === 'pdf') {
            processPdfGuruFile(file);
        } else if (ext === 'docx' || ext === 'doc') {
            processWordGuruFile(file);
        } else if (ext === 'xlsx' || ext === 'xls' || ext === 'csv') {
            processExcelGuruFile(file);
        } else {
            if (loadingDiv) loadingDiv.style.display = 'none';
            showGuruAlert('error', 'Format File Tidak Didukung!', 'Gunakan file dengan format .pdf, .docx, .doc, .xlsx, .xls, atau .csv');
        }
    }

    function processPdfGuruFile(file) {
        const loadingDiv = document.getElementById('guruImportLoading');
        const reader = new FileReader();
        reader.onload = function(e) {
            const typedarray = new Uint8Array(e.target.result);
            if (typeof pdfjsLib === 'undefined') {
                if (loadingDiv) loadingDiv.style.display = 'none';
                showGuruAlert('error', 'Pustaka PDF.js Belum Siap!', 'Sedang mengunduh pustaka PDF, silakan coba beberapa detik lagi.');
                return;
            }

            pdfjsLib.getDocument(typedarray).promise.then(async function(pdf) {
                let fullTextLines = [];
                for (let i = 1; i <= pdf.numPages; i++) {
                    const page = await pdf.getPage(i);
                    const textContent = await page.getTextContent();
                    const pageItems = textContent.items.map(item => item.str);
                    fullTextLines.push(...pageItems);
                }

                if (loadingDiv) loadingDiv.style.display = 'none';
                parseTextLinesToGuru(fullTextLines, file.name, '📄 PDF Document');
            }).catch(function(err) {
                if (loadingDiv) loadingDiv.style.display = 'none';
                showGuruAlert('error', 'Gagal Membaca File PDF!', 'File PDF tidak dapat dibaca: ' + err.message);
            });
        };
        reader.readAsArrayBuffer(file);
    }

    function processWordGuruFile(file) {
        const loadingDiv = document.getElementById('guruImportLoading');
        const reader = new FileReader();
        reader.onload = function(e) {
            const arrayBuffer = e.target.result;
            if (typeof mammoth !== 'undefined') {
                mammoth.extractRawText({ arrayBuffer: arrayBuffer }).then(function(result) {
                    if (loadingDiv) loadingDiv.style.display = 'none';
                    const lines = result.value.split('\n');
                    parseTextLinesToGuru(lines, file.name, '📝 Microsoft Word');
                }).catch(function(err) {
                    if (loadingDiv) loadingDiv.style.display = 'none';
                    const textDecoder = new TextDecoder('utf-8');
                    const text = textDecoder.decode(arrayBuffer);
                    parseTextLinesToGuru(text.split('\n'), file.name, '📝 Microsoft Word');
                });
            } else {
                if (loadingDiv) loadingDiv.style.display = 'none';
                const textDecoder = new TextDecoder('utf-8');
                const text = textDecoder.decode(arrayBuffer);
                parseTextLinesToGuru(text.split('\n'), file.name, '📝 Microsoft Word');
            }
        };
        reader.readAsArrayBuffer(file);
    }

    function processExcelGuruFile(file) {
        const loadingDiv = document.getElementById('guruImportLoading');
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array', cellDates: true });

                if (!workbook.SheetNames || workbook.SheetNames.length === 0) {
                    if (loadingDiv) loadingDiv.style.display = 'none';
                    showGuruAlert('error', 'File Excel Kosong!', 'File Excel yang Anda pilih tidak memiliki sheet.');
                    return;
                }

                const parsedGurus = [];
                const targetMapelSelect = document.getElementById('guru_target_mapel').value;

                workbook.SheetNames.forEach(sheetName => {
                    const worksheet = workbook.Sheets[sheetName];
                    if (!worksheet) return;

                    const rawRowsF = XLSX.utils.sheet_to_json(worksheet, { header: 1, raw: false, defval: '' });
                    if (!rawRowsF || rawRowsF.length === 0) return;

                    let colMap = { nip: -1, nama_guru: -1, jenis_kelamin: -1, no_hp: -1, mapel: -1 };

                    for (let r = 0; r < rawRowsF.length; r++) {
                        const rowF = rawRowsF[r];
                        if (!rowF || !Array.isArray(rowF)) continue;

                        let tempMap = { nip: -1, nama_guru: -1, jenis_kelamin: -1, no_hp: -1, mapel: -1 };
                        let headerMatches = 0;

                        rowF.forEach((cell, cIdx) => {
                            const txt = String(cell || '').toLowerCase().trim();
                            if (txt === 'nip' || txt.includes('nip')) { tempMap.nip = cIdx; headerMatches++; }
                            else if (txt.includes('nama') || txt.includes('guru') || txt.includes('pegawai')) { tempMap.nama_guru = cIdx; headerMatches++; }
                            else if (txt.includes('jk') || txt.includes('kelamin') || txt === 'l/p') { tempMap.jenis_kelamin = cIdx; headerMatches++; }
                            else if (txt.includes('hp') || txt.includes('wa') || txt.includes('telepon') || txt.includes('phone')) { tempMap.no_hp = cIdx; headerMatches++; }
                            else if (txt.includes('mapel') || txt.includes('pelajaran')) { tempMap.mapel = cIdx; headerMatches++; }
                        });

                        if (headerMatches >= 2) {
                            colMap = tempMap;
                            continue;
                        }

                        let nipRaw  = colMap.nip !== -1 ? String(rowF[colMap.nip] || '') : String(rowF[1] || rowF[0] || '');
                        let namaRaw = colMap.nama_guru !== -1 ? String(rowF[colMap.nama_guru] || '') : String(rowF[2] || rowF[1] || '');
                        let jkRaw   = colMap.jenis_kelamin !== -1 ? String(rowF[colMap.jenis_kelamin] || '') : String(rowF[3] || '');
                        let hpRaw   = colMap.no_hp !== -1 ? String(rowF[colMap.no_hp] || '') : String(rowF[4] || '');
                        let mapelRaw= colMap.mapel !== -1 ? String(rowF[colMap.mapel] || '') : String(rowF[5] || '');

                        let nipDigits = nipRaw.replace(/[^0-9]/g, '');
                        if (nipDigits.length > 0 && nipDigits.length < 18) {
                            nipDigits = nipDigits.padStart(18, '1');
                        } else if (nipDigits.length > 18) {
                            nipDigits = nipDigits.slice(0, 18);
                        }

                        let namaClean = namaRaw.trim();
                        if (!namaClean || namaClean.length < 2 || namaClean.toLowerCase().includes('nama') || namaClean.toLowerCase().includes('daftar') || namaClean.toLowerCase().includes('nip')) {
                            continue;
                        }

                        if (!nipDigits) {
                            nipDigits = '198501' + Math.floor(1000000000 + Math.random() * 9000000000);
                        }

                        let jk = 'L';
                        if (jkRaw.toLowerCase().startsWith('p') || jkRaw.toLowerCase().includes('perem')) jk = 'P';

                        let noHpDigits = hpRaw.replace(/[^0-9]/g, '');
                        if (!noHpDigits || noHpDigits.length < 10) {
                            noHpDigits = '0812' + Math.floor(10000000 + Math.random() * 90000000);
                        }

                        let matchedMapelId = targetMapelSelect || '';
                        if (!matchedMapelId && mapelRaw) {
                            const foundMapel = availableMapelList.find(m => mapelRaw.toLowerCase().includes(m.nama_mapel.toLowerCase()));
                            if (foundMapel) matchedMapelId = foundMapel.id_mapel;
                        }

                        parsedGurus.push({
                            nip: nipDigits,
                            nama_guru: namaClean,
                            jenis_kelamin: jk,
                            no_hp: noHpDigits,
                            id_mapel: matchedMapelId
                        });
                    }
                });

                if (loadingDiv) loadingDiv.style.display = 'none';

                if (parsedGurus.length === 0) {
                    showGuruAlert('error', 'Tidak Ada Data Guru Valid!', 'File Excel yang Anda unggah tidak mengandung NIP/Nama Guru yang dapat dibaca.');
                    return;
                }

                populateParsedGurus(parsedGurus, file.name, '📊 Microsoft Excel / CSV');
            } catch(err) {
                if (loadingDiv) loadingDiv.style.display = 'none';
                console.error('Error processing Excel guru file:', err);
                showGuruAlert('error', 'Gagal Membaca File Excel!', 'Terjadi kesalahan saat membaca file: ' + err.message);
            }
        };
        reader.readAsArrayBuffer(file);
    }

    function parseTextLinesToGuru(lines, fileName, fileTypeLabel) {
        const parsedGurus = [];
        const targetMapelSelect = document.getElementById('guru_target_mapel').value;

        for (let i = 0; i < lines.length; i++) {
            const line = String(lines[i] || '').trim();
            if (!line || line.length < 3) continue;

            const nipMatch = line.match(/\b\d{18}\b/);
            let nip = nipMatch ? nipMatch[0] : '';

            let nama = line.replace(/\b\d{18}\b/g, '').replace(/\b08\d{8,12}\b/g, '').replace(/\b(L|P)\b/i, '').replace(/[^a-zA-Z\s\.\,\']/g, '').trim();

            if (nama.length >= 3 && !nama.toLowerCase().includes('nama') && !nama.toLowerCase().includes('daftar')) {
                if (!nip) {
                    nip = '198501' + Math.floor(1000000000 + Math.random() * 9000000000);
                }

                let jk = 'L';
                if (/\b(P|Perempuan)\b/i.test(line)) jk = 'P';

                let hpMatch = line.match(/\b08\d{8,12}\b/);
                let noHp = hpMatch ? hpMatch[0] : '0812' + Math.floor(10000000 + Math.random() * 90000000);

                let matchedMapelId = targetMapelSelect || '';
                if (!matchedMapelId) {
                    const foundMapel = availableMapelList.find(m => line.toLowerCase().includes(m.nama_mapel.toLowerCase()));
                    if (foundMapel) matchedMapelId = foundMapel.id_mapel;
                }

                parsedGurus.push({
                    nip: nip,
                    nama_guru: nama,
                    jenis_kelamin: jk,
                    no_hp: noHp,
                    id_mapel: matchedMapelId
                });
            }
        }

        if (parsedGurus.length === 0) {
            showGuruAlert('error', 'Tidak Ada Data Guru Valid!', `File ${fileTypeLabel} (${fileName}) tidak mengandung data nama guru yang dapat diekstrak.`);
            return;
        }

        populateParsedGurus(parsedGurus, fileName, fileTypeLabel);
    }

    function populateParsedGurus(parsedGurus, fileName, fileTypeLabel) {
        const mode = document.getElementById('guru_import_mode').value;
        const tbody = document.getElementById('bulkGuruTableBody');

        let existingRows = tbody.querySelectorAll('.bulk-guru-row');
        let isAllExistingEmpty = true;
        existingRows.forEach(tr => {
            const nipVal  = tr.querySelector('.bulk-nip')?.value.trim();
            const namaVal = tr.querySelector('.bulk-nama')?.value.trim();
            if (nipVal || namaVal) {
                isAllExistingEmpty = false;
            }
        });

        if (mode === 'replace' || isAllExistingEmpty) {
            tbody.innerHTML = '';
            bulkGuruIndex = 0;
        }

        parsedGurus.forEach(g => {
            addBulkGuruRow(g);
        });

        let modeLabel = (mode === 'replace' || isAllExistingEmpty) 
            ? 'Menggantikan/Menimpa isi tabel' 
            : 'Menambahkan ke akhir baris tabel yang ada';

        const msg = `Berhasil membaca <strong>${parsedGurus.length} data guru</strong> dari file <strong>${fileTypeLabel}</strong> (<em>${fileName}</em>) dan memasukkannya ke tabel pengisian massal di bawah.<br>`
                  + `<small style="display:block; margin-top:5px; font-size:12.5px;">`
                  + `<strong>Mode:</strong> ${modeLabel}`
                  + `</small>`;

        showGuruAlert('success', `Proses File ${fileTypeLabel} Berhasil!`, msg);

        const formBulk = document.getElementById('formGuruBulk');
        if (formBulk) {
            formBulk.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tbody = document.getElementById('bulkGuruTableBody');
        if (tbody && tbody.children.length === 0) {
            addBulkGuruRows(3);
        }
    });

    let guruToastTimeout = null;
    function showGuruRealtimeToast(message, isSuccess = true) {
        const toast = document.getElementById('guruRealtimeToast');
        const toastMsg = document.getElementById('guruRealtimeToastMsg');
        const toastIcon = document.getElementById('guruRealtimeToastIcon');

        if (!toast || !toastMsg) return;

        toastMsg.innerText = message;
        if (isSuccess) {
            toast.className = 'realtime-toast show toast-success';
            if (toastIcon) {
                toastIcon.className = 'fa-solid fa-circle-check';
                toastIcon.style.color = '#22c55e';
            }
        } else {
            toast.className = 'realtime-toast show toast-error';
            if (toastIcon) {
                toastIcon.className = 'fa-solid fa-circle-exclamation';
                toastIcon.style.color = '#ef4444';
            }
        }

        if (guruToastTimeout) clearTimeout(guruToastTimeout);
        guruToastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 3500);
    }

    async function handleGuruToggle(checkbox, guruId, guruName) {
        const isChecked = checkbox.checked;
        const label = document.getElementById('status-label-guru-' + guruId);
        const originalChecked = !isChecked;

        // Visual feedback immediately
        if (label) {
            label.innerText = isChecked ? 'Aktif' : 'Nonaktif';
            label.className = 'guru-status-label ' + (isChecked ? 'status-on' : 'status-off');
        }

        checkbox.disabled = true;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]') 
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                : '{{ csrf_token() }}';

            const response = await fetch(`/guru/${guruId}/toggle-active`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    is_active: isChecked ? 1 : 0
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                checkbox.checked = data.is_active;
                if (label) {
                    label.innerText = data.is_active ? 'Aktif' : 'Nonaktif';
                    label.className = 'guru-status-label ' + (data.is_active ? 'status-on' : 'status-off');
                }
                showGuruRealtimeToast(data.message || `Data Guru '${guruName}' berhasil diubah menjadi ${data.is_active ? 'Aktif (ON)' : 'Nonaktif (OFF)'}.`, true);
            } else {
                checkbox.checked = originalChecked;
                if (label) {
                    label.innerText = originalChecked ? 'Aktif' : 'Nonaktif';
                    label.className = 'guru-status-label ' + (originalChecked ? 'status-on' : 'status-off');
                }
                showGuruRealtimeToast(data.message || 'Gagal mengubah status Data Guru.', false);
            }
        } catch (error) {
            console.error('Error toggling guru status:', error);
            checkbox.checked = originalChecked;
            if (label) {
                label.innerText = originalChecked ? 'Aktif' : 'Nonaktif';
                label.className = 'guru-status-label ' + (originalChecked ? 'status-on' : 'status-off');
            }
            showGuruRealtimeToast('Terjadi kesalahan koneksi saat mengubah status Data Guru.', false);
        } finally {
            checkbox.disabled = false;
        }
    }
</script>

<!-- Floating Real-time Toast Component -->
<div id="guruRealtimeToast" class="realtime-toast">
    <i id="guruRealtimeToastIcon" class="fa-solid fa-circle-check" style="font-size:18px; color:#22c55e;"></i>
    <span id="guruRealtimeToastMsg">Status data guru berhasil diperbarui.</span>
</div>

@endsection
