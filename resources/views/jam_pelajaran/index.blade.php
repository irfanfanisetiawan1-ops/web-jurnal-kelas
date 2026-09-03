@extends('layouts.admin')

@section('title', 'Master Jam Pelajaran — EDU JOURNAL')

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
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
        color: #ffffff;
        padding: 14px 16px;
        text-align: left;
        background: #2b395b;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13.5px;
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
    }

    .badge-time {
        background: #f1f5f9;
        color: #3b5490;
        font-weight: 800;
        font-family: monospace;
        font-size: 13.5px;
        padding: 5px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

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
            <h1>Master Data — Jam Pelajaran</h1>
            <p>Kelola alokasi durasi jam pelajaran harian, waktu istirahat, dan urutan JP</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <i class="fa-regular fa-clock"></i>
        <span>Master Jam Pelajaran</span>
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

    @if($errors->any())
        <div class="alert-custom alert-error" id="errorAlertBox">
            <div style="display:flex; align-items:flex-start; gap:10px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:18px; margin-top:2px;"></i>
                <div>
                    <strong style="font-weight:800;">Pengisian data belum sesuai kriteria:</strong>
                    <ul style="margin: 4px 0 0 18px; padding:0;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- Card 1: Form Tambah Jam Pelajaran Baru -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-square-plus" style="color:#2563eb;"></i> Tambah Jam Pelajaran Baru</h2>
                <p>Masukkan rentang waktu resmi KBM (Senin-Kamis & Jumat) serta label sesi pembelajaran baru.</p>
            </div>
            <a href="{{ route('jam-pelajaran.trash') }}" class="btn-trash">
                <i class="fa-solid fa-trash-can"></i> Lihat Sampah Jam
                @if(isset($trashedCount) && $trashedCount > 0)
                    <span class="badge-count">{{ $trashedCount }}</span>
                @endif
            </a>
        </div>

        <form id="formTambahJam" action="{{ route('jam-pelajaran.store') }}" method="POST" onsubmit="return validateJamForm(event)">
            @csrf

            <!-- SECTION 1: Label Jam & Custom Input -->
            <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:14px; padding:16px; margin-bottom:18px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                    <label for="jam_ke" style="font-size:14px; font-weight:800; color:#0f172a; margin:0;">
                        <i class="fa-solid fa-tag" style="color:#2563eb;"></i> 1. Label Jam & Sesi Pembelajaran <span style="color:#ef4444;">*</span>
                    </label>
                    <span id="auto_fill_badge" class="badge-time" style="display:none; background:#e0f2fe; color:#0369a1; border-color:#bae6fd; font-size:12px; font-weight:700;">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Data Ter-autofill Otomatis
                    </span>
                </div>

                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap:16px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <select id="jam_ke" name="jam_ke" class="form-control @error('jam_ke') is-invalid @enderror @error('jam_ke_resolved') is-invalid @enderror" onchange="handleJamKeChange(this)" required>
                            <option value="" disabled {{ old('jam_ke') ? '' : 'selected' }}>-- Pilih Label Jam Sesi --</option>
                            @foreach(['Jam Ke-1', 'Jam Ke-2', 'Jam Ke-3', 'Jam Ke-4', 'Jam Ke-5', 'Jam Ke-6', 'Jam Ke-7', 'Jam Ke-8', 'Jam Ke-9', 'Jam Ke-10', 'Jam Ke-11', 'Jam Ke-12', 'Jam Ke-13', 'Istirahat 1', 'Istirahat 2', 'Upacara Bendera', 'Pembiasaan Hari Jumat'] as $labelOpt)
                                <option value="{{ $labelOpt }}" {{ old('jam_ke') == $labelOpt ? 'selected' : '' }}>{{ $labelOpt }}</option>
                            @endforeach
                            <option value="custom" {{ old('jam_ke') == 'custom' ? 'selected' : '' }}>Lainnya... (Ketik Label Khusus)</option>
                        </select>

                        <div id="customJamKeWrapper" style="display: {{ old('jam_ke') == 'custom' ? 'block' : 'none' }}; margin-top: 8px;">
                            <input type="text" id="jam_ke_custom" name="jam_ke_custom" value="{{ old('jam_ke_custom') }}" class="form-control" placeholder="Contoh: Jam Matrikulasi / Sesi Khusus">
                        </div>

                        @error('jam_ke')
                            <small style="color:#ef4444; font-weight:600; display:block; margin-top:4px;">{{ $message }}</small>
                        @enderror
                        @error('jam_ke_resolved')
                            <small style="color:#ef4444; font-weight:600; display:block; margin-top:4px;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label style="font-size:12.5px; font-weight:700; color:#475569; margin-bottom:6px;">Hari Berlaku Sesi Ini:</label>
                        <div style="display:flex; align-items:center; gap:16px; margin-top:6px;">
                            <label style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:700; color:#3b5490; cursor:pointer;">
                                <input type="checkbox" id="chk_senin_kamis" checked onchange="toggleSeninKamisFields(this.checked)" style="width:16px; height:16px; accent-color:#3b5490;">
                                <span>Senin – Kamis</span>
                            </label>
                            <label style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:700; color:#2563eb; cursor:pointer;">
                                <input type="checkbox" id="chk_jumat" checked onchange="toggleJumatFields(this.checked)" style="width:16px; height:16px; accent-color:#2563eb;">
                                <span>Hari Jumat</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Grid Waktu Senin-Kamis & Waktu Jumat -->
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:18px; margin-bottom:18px;">
                
                <!-- Box Senin - Kamis -->
                <div id="box_senin_kamis" style="background:#ffffff; border:1.5px solid #3b5490; border-radius:14px; padding:16px; transition:all 0.2s ease;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; padding-bottom:8px; border-bottom:1px solid #e2e8f0;">
                        <span style="font-size:13.5px; font-weight:800; color:#3b5490; display:flex; align-items:center; gap:6px;">
                            <i class="fa-regular fa-calendar-days"></i> Waktu Senin – Kamis
                        </span>
                        <span id="durasi_senin_kamis_badge" style="font-size:11.5px; font-weight:800; background:#f1f5f9; color:#3b5490; padding:2px 8px; border-radius:12px; border:1px solid #cbd5e1;">-</span>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_mulai" style="font-size:12px; font-weight:700;">Waktu Mulai</label>
                            <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', '07:00') }}" class="form-control @error('jam_mulai') is-invalid @enderror" onchange="calculateDurations()">
                            @error('jam_mulai')
                                <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_selesai" style="font-size:12px; font-weight:700;">Waktu Selesai</label>
                            <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', '07:35') }}" class="form-control @error('jam_selesai') is-invalid @enderror" onchange="calculateDurations()">
                            @error('jam_selesai')
                                <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <small id="senin_kamis_note" style="display:block; margin-top:8px; font-size:11.5px; color:#64748b; font-style:italic;">* Kosongkan jika hari Senin-Kamis tidak ada sesi pembelajaran ini.</small>
                </div>

                <!-- Box Hari Jumat -->
                <div id="box_jumat" style="background:#ffffff; border:1.5px solid #2563eb; border-radius:14px; padding:16px; transition:all 0.2s ease;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; padding-bottom:8px; border-bottom:1px solid #e2e8f0;">
                        <span style="font-size:13.5px; font-weight:800; color:#2563eb; display:flex; align-items:center; gap:6px;">
                            <i class="fa-regular fa-calendar-days"></i> Waktu Hari Jumat
                        </span>
                        <span id="durasi_jumat_badge" style="font-size:11.5px; font-weight:800; background:#e0f2fe; color:#0284c7; padding:2px 8px; border-radius:12px; border:1px solid #bae6fd;">-</span>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_mulai_jumat" style="font-size:12px; font-weight:700; color:#1e40af;">Waktu Mulai Jumat</label>
                            <input type="time" id="jam_mulai_jumat" name="jam_mulai_jumat" value="{{ old('jam_mulai_jumat', '07:00') }}" class="form-control @error('jam_mulai_jumat') is-invalid @enderror" onchange="calculateDurations()">
                            @error('jam_mulai_jumat')
                                <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="jam_selesai_jumat" style="font-size:12px; font-weight:700; color:#1e40af;">Waktu Selesai Jumat</label>
                            <input type="time" id="jam_selesai_jumat" name="jam_selesai_jumat" value="{{ old('jam_selesai_jumat', '07:30') }}" class="form-control @error('jam_selesai_jumat') is-invalid @enderror" onchange="calculateDurations()">
                            @error('jam_selesai_jumat')
                                <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <small id="jumat_note" style="display:block; margin-top:8px; font-size:11.5px; color:#2563eb; font-style:italic;">* Sesuai alokasi resmi hari Jumat SMKN 1 Boyolangu.</small>
                </div>

            </div>

            <!-- SECTION 3: Keterangan & Quick Preset Pills -->
            <div class="form-group" style="margin-bottom:18px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px; flex-wrap:wrap; gap:8px;">
                    <label for="keterangan" style="margin-bottom:0;"><i class="fa-solid fa-align-left"></i> Keterangan Sesi Pembelajaran (Opsional)</label>
                    <span style="font-size:11.5px; color:#64748b; font-weight:600;">Pilih templat cepat di bawah ini untuk auto-fill:</span>
                </div>
                <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" class="form-control" placeholder="Contoh: Pembelajaran Reguler / Upacara / Sholat Dzuhur">
                
                <!-- Quick Preset Pills -->
                <div style="display:flex; flex-wrap:wrap; gap:6px; margin-top:8px;">
                    <button type="button" onclick="setKeterangan('Upacara / Apel (Senin) | Pembiasaan (Jumat)')" style="font-size:11px; font-weight:700; background:#f1f5f9; color:#3b5490; border:1px solid #cbd5e1; padding:4px 10px; border-radius:8px; cursor:pointer;">Upacara / Apel (Senin)</button>
                    <button type="button" onclick="setKeterangan('Sesi Pembelajaran Pagi')" style="font-size:11px; font-weight:700; background:#f1f5f9; color:#3b5490; border:1px solid #cbd5e1; padding:4px 10px; border-radius:8px; cursor:pointer;">Sesi Pembelajaran Pagi</button>
                    <button type="button" onclick="setKeterangan('Sesi Pembelajaran Siang')" style="font-size:11px; font-weight:700; background:#f1f5f9; color:#3b5490; border:1px solid #cbd5e1; padding:4px 10px; border-radius:8px; cursor:pointer;">Sesi Pembelajaran Siang</button>
                    <button type="button" onclick="setKeterangan('Istirahat 1 (20 Menit)')" style="font-size:11px; font-weight:700; background:#fef3c7; color:#b45309; border:1px solid #fde68a; padding:4px 10px; border-radius:8px; cursor:pointer;">Istirahat 1</button>
                    <button type="button" onclick="setKeterangan('Istirahat 2 (ISHOMA / Sholat Jumat)')" style="font-size:11px; font-weight:700; background:#fef3c7; color:#b45309; border:1px solid #fde68a; padding:4px 10px; border-radius:8px; cursor:pointer;">Istirahat 2 (ISHOMA)</button>
                </div>
            </div>

            <div class="btn-submit-container" style="display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap; gap: 12px;">
                <button type="button" onclick="document.getElementById('formTambahJam').reset(); if(typeof calculateDurations==='function') calculateDurations();" class="btn-reset-form" style="background:#fbbf24; color:#78350f; border:1px solid #fde68a; padding:10px 20px; border-radius:10px; font-weight:700; margin:0;" title="Kosongkan Isian Form">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-submit" style="margin:0;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Jam Pelajaran
                </button>
            </div>
        </form>
    </div>

    <script>
        const jamPresets = {
            'Jam Ke-1': { startSK: '07:00', endSK: '07:40', startFri: '07:00', endFri: '07:30', ket: 'Upacara / Apel (Senin) | Pembiasaan (Jumat)' },
            'Jam Ke-2': { startSK: '07:40', endSK: '08:20', startFri: '07:30', endFri: '08:00', ket: 'Sesi Pembelajaran Pagi' },
            'Jam Ke-3': { startSK: '08:20', endSK: '09:00', startFri: '08:00', endFri: '08:30', ket: 'Sesi Pembelajaran Pagi' },
            'Jam Ke-4': { startSK: '09:00', endSK: '09:40', startFri: '08:30', endFri: '09:00', ket: 'Sesi Pembelajaran (Sebelum Istirahat 1 Senin-Kamis)' },
            'Istirahat 1': { startSK: '09:40', endSK: '10:00', startFri: '09:30', endFri: '09:50', ket: 'Istirahat 1 (20 Menit)' },
            'Jam Ke-5': { startSK: '10:00', endSK: '10:35', startFri: '09:00', endFri: '09:30', ket: 'Sesi Pembelajaran (Setelah Istirahat 1 Senin-Kamis / Sebelum Istirahat 1 Jumat)' },
            'Jam Ke-6': { startSK: '10:35', endSK: '11:10', startFri: '09:50', endFri: '10:20', ket: 'Sesi Pembelajaran Siang (Setelah Istirahat 1 Jumat)' },
            'Jam Ke-7': { startSK: '11:10', endSK: '11:45', startFri: '10:20', endFri: '10:50', ket: 'Sesi Pembelajaran Siang (Sebelum Istirahat 2 Senin-Kamis)' },
            'Istirahat 2': { startSK: '11:45', endSK: '13:15', startFri: '11:20', endFri: '13:00', ket: 'Istirahat 2 (ISHOMA / Sholat Jumat)' },
            'Jam Ke-8': { startSK: '13:15', endSK: '13:50', startFri: '10:50', endFri: '11:20', ket: 'Sesi Pembelajaran (Setelah ISHOMA Senin-Kamis / Sebelum Jumatan Jumat)' },
            'Jam Ke-9': { startSK: '13:50', endSK: '14:25', startFri: '13:00', endFri: '13:30', ket: 'Sesi Pembelajaran Sore (Setelah ISHOMA Jumat)' },
            'Jam Ke-10': { startSK: '14:25', endSK: '15:00', startFri: '13:30', endFri: '14:00', ket: 'Sesi Pembelajaran (Senin-Kamis Pulang pkl 15:00)' },
            'Jam Ke-11': { startSK: '', endSK: '', startFri: '14:00', endFri: '14:30', ket: 'Sesi Pembelajaran Khusus Jumat' },
            'Jam Ke-12': { startSK: '', endSK: '', startFri: '14:30', endFri: '15:00', ket: 'Sesi Pembelajaran Khusus Jumat (Kelas XI Pulang pkl 15:00)' },
            'Jam Ke-13': { startSK: '', endSK: '', startFri: '15:00', endFri: '15:30', ket: 'Sesi Pembelajaran Khusus Jumat (Kelas X Pulang pkl 15:30)' },
            'Upacara Bendera': { startSK: '07:00', endSK: '07:40', startFri: '07:00', endFri: '07:30', ket: 'Upacara Bendera Hari Senin' },
            'Pembiasaan Hari Jumat': { startSK: '', endSK: '', startFri: '07:00', endFri: '07:30', ket: 'Pembiasaan & Kedisiplinan Hari Jumat' },
        };

        function handleJamKeChange(selectElem) {
            const label = selectElem.value;
            const customWrapper = document.getElementById('customJamKeWrapper');
            const customInput = document.getElementById('jam_ke_custom');
            const autoBadge = document.getElementById('auto_fill_badge');

            if (label === 'custom') {
                customWrapper.style.display = 'block';
                customInput.setAttribute('required', 'required');
                customInput.focus();
                autoBadge.style.display = 'none';
            } else {
                customWrapper.style.display = 'none';
                customInput.removeAttribute('required');
                customInput.value = '';

                // Apply Preset Auto-Fill
                if (jamPresets[label]) {
                    const preset = jamPresets[label];
                    
                    // Senin-Kamis
                    const chkSK = document.getElementById('chk_senin_kamis');
                    if (preset.startSK && preset.endSK) {
                        chkSK.checked = true;
                        toggleSeninKamisFields(true);
                        document.getElementById('jam_mulai').value = preset.startSK;
                        document.getElementById('jam_selesai').value = preset.endSK;
                    } else {
                        chkSK.checked = false;
                        toggleSeninKamisFields(false);
                    }

                    // Jumat
                    const chkFri = document.getElementById('chk_jumat');
                    if (preset.startFri && preset.endFri) {
                        chkFri.checked = true;
                        toggleJumatFields(true);
                        document.getElementById('jam_mulai_jumat').value = preset.startFri;
                        document.getElementById('jam_selesai_jumat').value = preset.endFri;
                    } else {
                        chkFri.checked = false;
                        toggleJumatFields(false);
                    }

                    // Keterangan
                    if (preset.ket) {
                        document.getElementById('keterangan').value = preset.ket;
                    }

                    calculateDurations();
                    autoBadge.style.display = 'inline-flex';
                }
            }
        }

        function toggleSeninKamisFields(enabled) {
            const box = document.getElementById('box_senin_kamis');
            const inStart = document.getElementById('jam_mulai');
            const inEnd = document.getElementById('jam_selesai');

            if (enabled) {
                box.style.opacity = '1';
                box.style.pointerEvents = 'auto';
                inStart.disabled = false;
                inEnd.disabled = false;
            } else {
                box.style.opacity = '0.45';
                box.style.pointerEvents = 'none';
                inStart.disabled = true;
                inEnd.disabled = true;
                inStart.value = '';
                inEnd.value = '';
            }
            calculateDurations();
        }

        function toggleJumatFields(enabled) {
            const box = document.getElementById('box_jumat');
            const inStart = document.getElementById('jam_mulai_jumat');
            const inEnd = document.getElementById('jam_selesai_jumat');

            if (enabled) {
                box.style.opacity = '1';
                box.style.pointerEvents = 'auto';
                inStart.disabled = false;
                inEnd.disabled = false;
            } else {
                box.style.opacity = '0.45';
                box.style.pointerEvents = 'none';
                inStart.disabled = true;
                inEnd.disabled = true;
                inStart.value = '';
                inEnd.value = '';
            }
            calculateDurations();
        }

        function setKeterangan(text) {
            document.getElementById('keterangan').value = text;
        }

        function timeToMinutes(t) {
            if (!t) return 0;
            const [h, m] = t.split(':').map(Number);
            return (h * 60) + m;
        }

        function calculateDurations() {
            // Senin-Kamis
            const skMulai = document.getElementById('jam_mulai').value;
            const skSelesai = document.getElementById('jam_selesai').value;
            const badgeSK = document.getElementById('durasi_senin_kamis_badge');
            
            if (skMulai && skSelesai && skSelesai > skMulai) {
                const diff = timeToMinutes(skSelesai) - timeToMinutes(skMulai);
                badgeSK.textContent = diff + ' Menit';
                badgeSK.style.background = '#e0f2fe';
                badgeSK.style.color = '#0369a1';
            } else {
                badgeSK.textContent = '-';
                badgeSK.style.background = '#f1f5f9';
                badgeSK.style.color = '#64748b';
            }

            // Jumat
            const friMulai = document.getElementById('jam_mulai_jumat').value;
            const friSelesai = document.getElementById('jam_selesai_jumat').value;
            const badgeFri = document.getElementById('durasi_jumat_badge');

            if (friMulai && friSelesai && friSelesai > friMulai) {
                const diff = timeToMinutes(friSelesai) - timeToMinutes(friMulai);
                badgeFri.textContent = diff + ' Menit';
                badgeFri.style.background = '#e0f2fe';
                badgeFri.style.color = '#0369a1';
            } else {
                badgeFri.textContent = '-';
                badgeFri.style.background = '#f1f5f9';
                badgeFri.style.color = '#64748b';
            }
        }

        function validateJamForm(e) {
            const selectElem = document.getElementById('jam_ke');
            const jamKeVal = selectElem.value;
            const customVal = document.getElementById('jam_ke_custom').value.trim();
            const chkSK = document.getElementById('chk_senin_kamis').checked;
            const chkFri = document.getElementById('chk_jumat').checked;

            const jamMulai = document.getElementById('jam_mulai').value;
            const jamSelesai = document.getElementById('jam_selesai').value;
            const jamMulaiJumat = document.getElementById('jam_mulai_jumat').value;
            const jamSelesaiJumat = document.getElementById('jam_selesai_jumat').value;

            let errors = [];
            if (!jamKeVal) {
                errors.push('Label Jam Sesi wajib dipilih!');
            } else if (jamKeVal === 'custom' && !customVal) {
                errors.push('Label Jam Khusus wajib diisi!');
            }

            if (!chkSK && !chkFri) {
                errors.push('Pilih minimal satu kategori hari (Senin-Kamis atau Hari Jumat) yang berlaku untuk sesi ini!');
            }

            if (chkSK) {
                if (!jamMulai) errors.push('Waktu Mulai Senin-Kamis wajib diisi!');
                if (!jamSelesai) errors.push('Waktu Selesai Senin-Kamis wajib diisi!');
                if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                    errors.push('Waktu Selesai Senin-Kamis (' + jamSelesai + ') harus lebih akhir daripada Waktu Mulai (' + jamMulai + ')!');
                }
            }

            if (chkFri) {
                if (!jamMulaiJumat) errors.push('Waktu Mulai Hari Jumat wajib diisi!');
                if (!jamSelesaiJumat) errors.push('Waktu Selesai Hari Jumat wajib diisi!');
                if (jamMulaiJumat && jamSelesaiJumat && jamSelesaiJumat <= jamMulaiJumat) {
                    errors.push('Waktu Selesai Hari Jumat (' + jamSelesaiJumat + ') harus lebih akhir daripada Waktu Mulai Hari Jumat (' + jamMulaiJumat + ')!');
                }
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert('⚠️ PERINGATAN VALIDASI DATA JAM PELAJARAN:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
                return false;
            }
            return true;
        }

        // Initialize duration calculation on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateDurations();
        });
    </script>

    <!-- Card 2: Daftar Sesi Jam Pelajaran -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-regular fa-clock" style="color:#3b5490;"></i> Daftar Sesi Jam Pelajaran ({{ count($jamList) }})</h2>
                <p>Kelola seluruh sesi jam pelajaran dan rentang waktu belajar sekolah berdasarkan pedoman <strong>jam pelajaran.png</strong> SMKN 1 Boyolangu.</p>
            </div>
        </div>

        <form action="{{ route('jam-pelajaran.index') }}" method="GET" style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom:20px; background:#f8fafc; padding:14px 18px; border-radius:14px; border:1px solid #cbd5e1;">
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" name="search" class="form-control" style="width: 240px; padding-left:36px; background:#ffffff;" value="{{ $search ?? '' }}" placeholder="Cari Jam / Waktu / Keterangan..">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                </div>
            </div>

            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto;">
                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('jam-pelajaran.index') }}" class="btn-reset">Reset</a>
                <button type="button" id="btnBulkDelete" class="btn-action btn-delete" style="padding: 10px 18px; border-radius: 12px; font-size: 13.5px; opacity: 0.5; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(225,29,72,0.15); border: none;" disabled onclick="confirmBulkDelete()" title="Pilih sesi jam pelajaran dengan mencentang checkbox untuk menghapus secara massal">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="bulkDeleteCount">0</span>)
                </button>
            </div>
        </form>

        <!-- Info Box Ketentuan Waktu KBM dari jam_pelajaran.png -->
        <div style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); border:1px solid #cbd5e1; border-left:5px solid #2563eb; border-radius:14px; padding:16px 20px; margin-bottom:20px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                <i class="fa-solid fa-circle-info" style="color:#2563eb; font-size:18px;"></i>
                <strong style="color:#0f172a; font-size:14px;">Ketentuan Waktu KBM Resmi (Sesuai Pedoman jam_pelajaran.png):</strong>
            </div>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:12px; font-size:12.5px; color:#334155; line-height:1.6;">
                <div>
                    <strong><i class="fa-regular fa-calendar-days" style="color:#3b5490;"></i> Senin s.d. Kamis:</strong><br>
                    • Jam ke-1 s/d 4 (40 Menit/JP), Jam ke-5 s/d 10 (35 Menit/JP) (07:00 - 15:00 WIB)<br>
                    • <strong>Istirahat 1</strong>: 09:40 - 10:00 WIB (20 Menit)<br>
                    • <strong>Istirahat 2 (ISHOMA)</strong>: 11:45 - 13:15 WIB (90 Menit)<br>
                    • Hari Senin jam ke-1: Upacara / Apel Bendera
                </div>
                <div>
                    <strong><i class="fa-regular fa-calendar-days" style="color:#2563eb;"></i> Hari Jumat:</strong><br>
                    • Jam ke-1 s/d 13 (30 Menit/JP) (07:00 - 15:30 WIB)<br>
                    • <strong>Istirahat 1</strong>: 09:30 - 09:50 WIB (20 Menit)<br>
                    • <strong>Istirahat 2 (Jumatan / ISHOMA)</strong>: 11:20 - 13:00 WIB (100 Menit)<br>
                    • Hari Jumat jam ke-1: Pembiasaan Hari Jumat<br>
                    • Kepulangan: Kelas XI jam ke-12 (15:00 WIB), Kelas X jam ke-13 (15:30 WIB)
                </div>
            </div>
        </div>

        <form id="formBulkDelete" action="{{ route('jam-pelajaran.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllJamPelajaran" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" title="Pilih Semua (Select All)">
                            </th>
                            <th style="width: 50px;">NO</th>
                            <th>JAM KE-</th>
                            <th>SENIN - KAMIS</th>
                            <th>HARI JUMAT</th>
                            <th>KETERANGAN</th>
                            <th style="text-align:center; min-width: 240px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jamList as $idx => $item)
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $item->id_jam }}" class="jam-select-checkbox" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" onchange="updateBulkDeleteState()">
                                </td>
                                <td><strong>{{ $idx + 1 }}</strong></td>
                                <td><strong style="color:#0f172a; font-size:14px;">{{ $item->jam_ke }}</strong></td>
                                <td>
                                    @if($item->waktu_senin_kamis !== '-')
                                        <span class="badge-time" style="background:#f1f5f9; color:#1e293b; border-color:#cbd5e1;">
                                            <i class="fa-regular fa-clock"></i> {{ $item->waktu_senin_kamis }} WIB
                                        </span>
                                    @else
                                        <span style="color:#94a3b8; font-style:italic;">- (Selesai pkl 15:00)</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-time" style="background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe;">
                                        <i class="fa-regular fa-clock"></i> {{ $item->waktu_jumat }} WIB
                                    </span>
                                </td>
                                <td>
                                    @if($item->keterangan)
                                        <span style="background:#f8fafc; color:#334155; padding:6px 12px; border-radius:8px; font-weight:600; font-size:12.5px; display:inline-block; border:1px solid #e2e8f0;">
                                            {{ $item->keterangan }}
                                        </span>
                                    @else
                                        <span style="color:#94a3b8; font-style:italic;">-</span>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    <div class="action-buttons">
                                        <!-- 1. LIHAT DETAIL - Disebelah kiri Edit & Hapus -->
                                        <a href="{{ route('jam-pelajaran.show', $item->id_jam) }}" class="btn-action btn-view" title="Lihat Detail Sesi Jam">
                                            <i class="fa-solid fa-eye"></i> Lihat Detail
                                        </a>

                                        <!-- 2. EDIT - Disebelah kiri Hapus (Hanya bisa diedit saat tombol Edit diklik!) -->
                                        <a href="{{ route('jam-pelajaran.edit', $item->id_jam) }}" class="btn-action btn-edit" title="Edit Data Jam Pelajaran">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>

                                        <!-- 3. HAPUS - Paling kanan -->
                                        <button type="button" class="btn-action btn-delete" onclick="if(confirm('Apakah Anda yakin ingin memindahkan {{ addslashes($item->jam_ke) }} ke tempat sampah?')) { document.getElementById('singleDeleteForm-{{ $item->id_jam }}').submit(); }" title="Hapus Jam Pelajaran">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:36px; color:#94a3b8;">
                                    <i class="fa-regular fa-clock" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                    Belum ada data Master Jam Pelajaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @foreach($jamList as $item)
            <form id="singleDeleteForm-{{ $item->id_jam }}" action="{{ route('jam-pelajaran.destroy', $item->id_jam) }}" method="POST" style="display:none;">
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
            <p>Apakah Anda yakin ingin memindahkan <strong id="modalBulkCountText" style="color:#e11d48;">0 data sesi jam pelajaran</strong> yang dicentang ke Tempat Sampah?</p>
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeBulkDeleteModal()">Batal</button>
                <button type="button" class="btn-m-confirm" onclick="submitBulkDelete()">Ya, Hapus Data</button>
            </div>
        </div>
    </div>

    <script>
        function updateBulkDeleteState() {
            const checkedBoxes = document.querySelectorAll('.jam-select-checkbox:checked');
            const totalBoxes   = document.querySelectorAll('.jam-select-checkbox');
            const count        = checkedBoxes.length;
            const btnBulkDelete= document.getElementById('btnBulkDelete');
            const countSpan    = document.getElementById('bulkDeleteCount');
            const selectAll    = document.getElementById('selectAllJamPelajaran');

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
            const checkedBoxes = document.querySelectorAll('.jam-select-checkbox:checked');
            const count = checkedBoxes.length;

            if (count === 0) {
                alert('Silakan pilih minimal 1 data sesi jam pelajaran yang ingin dihapus dengan mencentang kotak centang (checkbox).');
                return;
            }

            const modalCountText = document.getElementById('modalBulkCountText');
            if (modalCountText) {
                modalCountText.textContent = count + ' data sesi jam pelajaran';
            }

            const modal = document.getElementById('modalConfirmBulkDelete');
            if (modal) {
                modal.classList.add('active');
            } else {
                if (confirm(`Apakah Anda yakin ingin memindahkan ${count} data sesi jam pelajaran yang dipilih ke Tempat Sampah?`)) {
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
            const selectAll = document.getElementById('selectAllJamPelajaran');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.jam-select-checkbox');
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
        });
    </script>

@endsection
