@extends('layouts.admin')

@section('title', 'Master Data Siswa — EDU JOURNAL')

@section('styles')
<!-- Tailwind CSS v3 with Plugins -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Tailwind Custom Configuration -->
<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#eff6ff',
              100: '#dbeafe',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8',
              800: '#1e40af',
              900: '#1e3a8a',
            }
          },
          fontFamily: {
            sans: ['Inter', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'sans-serif'],
          }
        }
      }
    }
</script>
<style>
    /* Custom Scrollbars */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 9999px;
    }
<<<<<<< HEAD

    .card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
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

    .btn-alumni {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
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
    .btn-alumni:hover {
        background: #bae6fd;
        color: #0284c7;
    }
    .btn-alumni .badge-count {
        background: #0284c7;
        color: #ffffff;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 20px;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        width: 100%;
        box-sizing: border-box;
    }

    .form-group {
        margin-bottom: 16px;
        min-width: 0;
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
=======
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    /* Date picker indicator styling */
    input[type="date"]::-webkit-calendar-picker-indicator {
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        cursor: pointer;
        opacity: 0.6;
    }
    input[type="date"]::-webkit-calendar-picker-indicator:hover {
        opacity: 1;
    }

    /* Soft Select Styling */
    .filter-select-custom {
        transition: all 0.2s ease;
    }
    .filter-select-custom.has-value {
        color: #0f172a !important;
        font-weight: 700 !important;
        border-color: #2563eb !important;
    }

<<<<<<< HEAD
    /* Table Custom */
    .table-responsive {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-sizing: border-box;
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

    .badge-jk {
        padding: 3px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
    }
    .badge-jk-l {
        background: #e0f2fe;
        color: #0369a1;
    }
    .badge-jk-p {
        background: #fce7f3;
        color: #be185d;
    }

    .badge-kelas {
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    /* Alert Styling */
    .alert-custom {
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
=======
    /* Header Controls Final Dimensions */
    .header-controls {
        width: fit-content;
        flex: 0 0 auto;
        margin-left: auto;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .header-control {
        flex: 0 0 auto;
        box-sizing: border-box;
    }
    .ta-selector.academic-year.header-control {
        width: 220px;
        min-width: 220px;
        max-width: 220px;
        flex: 0 0 220px;
        box-sizing: border-box;
    }
    .live-lesson-hour-card.kbm-status.header-control {
        width: 170px;
        min-width: 170px;
        max-width: 170px;
        flex: 0 0 170px;
        box-sizing: border-box;
    }
    .live-clock-card.date-time.header-control {
        width: 220px;
        min-width: 220px;
        max-width: 220px;
        flex: 0 0 220px;
        box-sizing: border-box;
    }
    .live-clock-wrapper {
        display: contents;
    }

    @media (max-width: 640px) {
        .page-header-main-title {
            font-size: 18px !important;
            white-space: normal !important;
        }
        .page-header-sub-title {
            font-size: 11px !important;
            white-space: normal !important;
        }
    }

    /* Toggle Switch ON/OFF Real-time Styling */
    .siswa-status-switch-wrapper {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        user-select: none;
    }

    .siswa-toggle-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
        margin: 0;
        cursor: pointer;
    }

    .siswa-toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }

    .siswa-toggle-slider {
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

    .siswa-toggle-slider:before {
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

    .siswa-toggle-switch input:checked + .siswa-toggle-slider {
        background-color: #22c55e;
    }

    .siswa-toggle-switch input:focus + .siswa-toggle-slider {
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2), inset 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    .siswa-toggle-switch input:checked + .siswa-toggle-slider:before {
        transform: translateX(20px);
    }

    .siswa-toggle-switch input:disabled + .siswa-toggle-slider {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .siswa-status-label {
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.2px;
        transition: color 0.2s;
        min-width: 48px;
        text-align: left;
    }

    .siswa-status-label.status-on {
        color: #16a34a;
    }

    .siswa-status-label.status-off {
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
        background: #1e293b;
        color: #ffffff;
        border-radius: 14px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.2);
        font-size: 13.5px;
        font-weight: 600;
        opacity: 0;
        transform: translateY(20px);
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        max-width: 420px;
    }

    .realtime-toast.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
</style>
@endsection

@section('topbar_left')
<div class="title-header-wrapper" style="display: flex; flex-direction: column; justify-content: center; min-width: 0; flex: 0 1 auto;">
    <h1 class="page-header-main-title" style="font-size: 17px; font-weight: 700; color: #0f2744; letter-spacing: -0.01em; line-height: 1.2; margin: 0; white-space: nowrap;">
        Manajemen Data Siswa
    </h1>
    <p class="page-header-sub-title" style="font-size: 11px; color: #64748b; font-weight: 500; margin: 1px 0 0 0; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 520px;">
        Data Induk Siswa &bull; Validasi NISN &bull; Distribusi Kelas &amp; Riwayat Pendaftaran
    </p>
</div>
@endsection

@section('content')

<!-- BEGIN: ActionPillNav & Auxiliary Buttons -->
<section class="flex items-center justify-between flex-wrap gap-2.5 mb-4" data-purpose="action-navigation-bar">
    <!-- Action Navigation Buttons (3 Tabs) -->
    <div class="flex items-center gap-1 bg-slate-200/60 p-1 rounded-xl border border-slate-300/40">
        <!-- Tab 1: Tambah Manual -->
        <button class="tab-button inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-brand-700 text-white shadow-sm transition-all cursor-pointer" id="tab-btn-manual" onclick="switchInputTab('manual')" type="button">
            <span class="material-symbols-outlined text-[16px]">person_add</span>
            <span>Tambah Manual</span>
        </button>
        <!-- Tab 2: Import File Excel -->
        <button class="tab-button inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-700 hover:text-brand-700 hover:bg-white/80 transition-all cursor-pointer" id="tab-btn-excel" onclick="switchInputTab('excel')" type="button">
            <span class="material-symbols-outlined text-[16px] text-emerald-600">upload_file</span>
            <span>Import File Excel</span>
        </button>
        <!-- Tab 3: Input Cepat & Massal -->
        <button class="tab-button inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-700 hover:text-brand-700 hover:bg-white/80 transition-all cursor-pointer" id="tab-btn-massal" onclick="switchInputTab('massal')" type="button">
            <span class="material-symbols-outlined text-[16px] text-indigo-600">playlist_add</span>
            <span>Input Cepat &amp; Massal</span>
        </button>
    </div>

    <!-- Auxiliary Actions: Alumni & Tong Sampah -->
    <div class="flex items-center gap-2">
        <a href="{{ route('siswa.alumni') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-brand-700 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition-all no-underline shadow-sm">
            <span class="material-symbols-outlined text-[16px]">group</span>
            <span>Data Siswa Alumni</span>
            @if(isset($alumniCount) && $alumniCount > 0)
                <span class="bg-brand-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ml-0.5">{{ $alumniCount }}</span>
            @endif
        </a>
        <a href="{{ route('siswa.trash') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition-all no-underline shadow-sm">
            <span class="material-symbols-outlined text-[16px]">delete_outline</span>
            <span>Lihat Tong Sampah</span>
            @if(isset($trashedCount) && $trashedCount > 0)
                <span class="bg-amber-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ml-0.5">{{ $trashedCount }}</span>
            @endif
        </a>
    </div>
</section>
<!-- END: ActionPillNav -->

<!-- BEGIN: Panel 1 - Tambah Manual -->
<section class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-sm transition-all mb-4" data-purpose="form-manual-entry" id="panel-manual">
    <!-- Form Header -->
    <div class="flex items-start gap-3 pb-3.5 border-b border-slate-100 justify-between">
        <div class="flex items-start gap-3">
            <div class="p-2 bg-brand-50 text-brand-600 rounded-xl">
                <span class="material-symbols-outlined text-xl">person_add</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Tambah Siswa Baru</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Masukkan detail data siswa untuk pendaftaran siswa baru.</p>
            </div>
<<<<<<< HEAD
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('siswa.alumni') }}" class="btn-alumni">
                    <i class="fa-solid fa-user-graduate"></i> Data Siswa Alumni
                    @if(isset($alumniCount) && $alumniCount > 0)
                        <span class="badge-count">{{ $alumniCount }}</span>
                    @endif
                </a>
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

        <form id="formSiswaIndex" action="{{ route('siswa.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-grid-3">
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nis" style="margin-bottom: 0;">NIS (Nomor Induk Siswa) <span style="color:#ef4444;">*</span></label>
                        <span id="nisCounter" style="font-size: 12px; font-weight: 700; color: #ef4444;">0/10 digit</span>
                    </div>
                    <input type="text" id="nis" name="nis" value="{{ old('nis') }}"
                        class="form-control @error('nis') is-invalid @enderror"
                        placeholder="Contoh: 123 atau 2122100001" maxlength="10" minlength="3" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateDigitCounter(this, 'nisCounter', 10, 'nisMsg', true);"
                        required>
                    <small id="nisMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi 3 hingga 10 digit angka.</small>
                    @error('nis')
                        <small style="color:#ef4444; font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nisn" style="margin-bottom: 0;">NISN <span style="color:#ef4444;">*</span></label>
                        <span id="nisnCounter" style="font-size: 12px; font-weight: 700; color: #ef4444;">0/10 digit</span>
                    </div>
                    <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}"
                        class="form-control @error('nisn') is-invalid @enderror"
                        placeholder="Contoh: 0051234567" maxlength="10" minlength="10" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateDigitCounter(this, 'nisnCounter', 10, 'nisnMsg');"
                        required>
                    <small id="nisnMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi tepat 10 digit angka.</small>
                    @error('nisn')
                        <small style="color:#ef4444; font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_siswa">Nama Lengkap Siswa <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" class="form-control @error('nama_siswa') is-invalid @enderror" placeholder="Nama Lengkap Siswa" required>
                    @error('nama_siswa')
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
                    <label for="id_kelas">Kelas <span style="color:#ef4444;">*</span></label>
                    <select id="id_kelas" name="id_kelas" class="form-control @error('id_kelas') is-invalid @enderror" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelass as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('id_kelas')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kota_lahir">Kota Lahir <span style="color:#64748b; font-size:11px; font-weight:600;">(Opsional)</span></label>
                    <input type="text" id="kota_lahir" name="kota_lahir" value="{{ old('kota_lahir') }}" class="form-control @error('kota_lahir') is-invalid @enderror" placeholder="Kota/Tempat Lahir (boleh dikosongkan)">
                    <small style="font-size:11.5px; color:#94a3b8; margin-top:3px; display:block;"><i class="fa-solid fa-circle-info"></i> Opsional — boleh tidak diisi jika belum diketahui.</small>
                    @error('kota_lahir')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir <span style="color:#ef4444;">*</span></label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control @error('tanggal_lahir') is-invalid @enderror" required>
                    @error('tanggal_lahir')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="alamat_lengkap">Alamat Lengkap <span style="color:#64748b; font-size:11px; font-weight:600;">(Opsional)</span></label>
                    <textarea id="alamat_lengkap" name="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror" rows="2" placeholder="Masukkan Alamat Lengkap Siswa (boleh dikosongkan)">{{ old('alamat_lengkap') }}</textarea>
                    <small style="font-size:11.5px; color:#94a3b8; margin-top:3px; display:block;"><i class="fa-solid fa-circle-info"></i> Opsional — boleh tidak diisi jika belum diketahui.</small>
                    @error('alamat_lengkap')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="btn-submit-container" style="display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap; gap: 12px;">
                <button type="button" onclick="resetSingleSiswaForm()" class="btn-reset" style="background:#fbbf24; color:#78350f; border-color:#fde68a; padding:10px 20px; border-radius:10px; font-weight:700; margin:0;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-submit" style="margin:0;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data Siswa
                </button>
            </div>
        </form>
    </div>

    <!-- Card 1.25: Fitur Tambah Siswa Baru via Import File (Multi-Format: PDF, Word, Excel, CSV) -->
    <div class="card" style="border-top: 4px solid #0d9488; background: #ffffff; box-shadow: 0 4px 20px rgba(13, 148, 136, 0.08); border-radius: 16px;">
        <div class="card-top-header" style="padding-bottom: 14px; border-bottom: 1px solid #f1f5f9; margin-bottom: 18px;">
            <div>
                <h2 style="font-size: 19px; font-weight: 800; color: #0f172a; margin: 0;">
                    Tambah Siswa Baru via Import File
                </h2>
            </div>
        </div>

        <!-- Feedback Alert Banner Pasca Proses File (JS Generated) -->
        <div id="excelProcessAlert" class="alert-custom" style="display: none; margin-bottom: 20px;">
            <div style="display:flex; align-items:flex-start; gap:12px; width: 100%;">
                <i id="excelAlertIcon" class="fa-solid fa-circle-check" style="font-size:22px; flex-shrink:0; margin-top:2px;"></i>
                <div style="flex: 1;">
                    <h4 id="excelAlertTitle" style="font-size:15px; font-weight:800; margin:0 0 4px 0;"></h4>
                    <p id="excelAlertMsg" style="margin:0; font-size:13.5px; line-height:1.5;"></p>
                    <ul id="excelAlertDetails" style="margin: 6px 0 0 18px; padding: 0; font-size: 12.5px; line-height: 1.5; display: none;"></ul>
                </div>
                <button type="button" onclick="document.getElementById('excelProcessAlert').style.display='none'" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div id="importFileLoading" style="display:none; text-align:center; padding:20px; background:#f0fdfa; border-radius:12px; border:1px solid #99f6e4; margin-bottom:16px;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size:28px; color:#0d9488;"></i>
            <p id="importFileLoadingMsg" style="margin:10px 0 0; color:#0f766e; font-weight:700; font-size:14px;">Sedang membaca file data siswa...</p>
        </div>

        <!-- Form Import Controls Container -->
        <div class="form-grid-3" style="align-items: flex-end; background: #f8fafc; padding: 20px; border-radius: 14px; border: 1px dashed #cbd5e1;">
            <!-- 1. Pilih File -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="excel_file_input" style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                    Pilih File Data Siswa <span style="color:#ef4444;">*</span>
                </label>
                <input type="file" id="excel_file_input" accept=".xlsx,.xls,.csv,.pdf,.doc,.docx" class="form-control" style="padding: 9px; background: #ffffff; cursor: pointer; border-color: #94a3b8;" onchange="onSiswaFileSelected(this)">
                <small id="importFileTypeHint" style="display:block; font-size:11.5px; color:#64748b; margin-top:4px;">
                    Format: <strong>.pdf, .docx, .doc, .xlsx, .xls, .csv</strong> (Maks: 10MB)
                </small>
            </div>

            <!-- 2. Pilih Kelas Target (Opsional) -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="excel_target_kelas" style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                    Pilih Kelas Target (Opsional)
                </label>
                <select id="excel_target_kelas" onchange="syncTargetKelasToBulk(this.value)" class="form-control" style="background: #ffffff; border-color: #0284c7; font-weight: 600; color: #0369a1;">
                    <option value="">-- Otomatis Dari File / Ikuti Pilihan Bulk --</option>
                    @foreach($kelass as $k)
                        <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} (Estimasi Kapasitas: {{ $k->jumlah_siswa }} Siswa)</option>
                    @endforeach
                </select>
                <small style="display:block; font-size:11.5px; color:#64748b; margin-top:4px;">
                    Jika dipilih, memaksa seluruh data siswa masuk ke kelas ini.
                </small>
            </div>

            <!-- 3. Mode Masukkan Data -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="excel_import_mode" style="font-size: 13.5px; font-weight: 800; color: #0f172a;">
                    Mode Masukkan Data
                </label>
                <select id="excel_import_mode" class="form-control" style="background: #ffffff; border-color: #8b5cf6; font-weight: 600; color: #6d28d9;">
                    <option value="replace">Ganti / Timpa Seluruh Baris Tabel</option>
                    <option value="append">Tambahkan ke Baris Tabel yang Ada</option>
                </select>
                <small style="display:block; font-size:11.5px; color:#64748b; margin-top:4px;">
                    Pilih apakah data file menggantikan atau menambahkan baris.
                </small>
            </div>
        </div>

        <div style="margin-top: 20px; display: flex; justify-content: flex-end; align-items: center; gap: 12px; flex-wrap: wrap;">
            <button type="button" onclick="clearExcelFileInput()" class="btn-reset" style="padding: 10px 20px; border-radius: 10px; background: #fbbf24; color: #78350f; border: 1px solid #fde68a; font-weight: 700; margin:0;">
                <i class="fa-solid fa-rotate-left"></i> Reset File
            </button>
            <button type="button" id="btnProcessExcel" onclick="processExcelFile()" class="btn-submit" style="background: #2563eb; padding: 11px 24px; border-radius: 10px; font-size: 13.5px; font-weight: 700; margin:0;">
                <i class="fa-solid fa-file-import"></i> Proses File Data Siswa
            </button>
=======
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </div>
    </div>

    <!-- Alert Banner Alasan Gagal Simpan (JS Client Validation) -->
    <div id="formErrorReasonBanner" class="hidden mt-3 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start justify-between gap-3">
        <div class="flex items-start gap-2.5">
            <span class="material-symbols-outlined text-rose-600 text-lg shrink-0 mt-0.5">warning</span>
            <div>
                <h4 class="font-bold text-xs text-rose-900">Data belum bisa disimpan! Silakan perbaiki pengisian berikut:</h4>
                <ul id="formErrorReasonList" class="list-disc list-inside mt-1 text-[11px] text-rose-700 space-y-0.5"></ul>
            </div>
        </div>
        <button type="button" onclick="document.getElementById('formErrorReasonBanner').classList.add('hidden')" class="text-rose-500 hover:text-rose-700 cursor-pointer">
            <span class="material-symbols-outlined text-base">close</span>
        </button>
    </div>

    <form id="formSiswaIndex" action="{{ route('siswa.store') }}" method="POST" class="mt-4 space-y-3.5" novalidate>
        @csrf

        <!-- Row 1: NIS, NISN, Nama Lengkap, Jenis Kelamin, Kelas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-12 gap-3">
            <!-- NIS -->
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-1">
                    <label for="nis" class="text-[11px] font-semibold text-slate-700">NIS <span class="text-rose-500">*</span></label>
                    <span id="nisCounter" class="text-[10px] font-bold text-rose-500">0/10 digit</span>
                </div>
                <input type="text" id="nis" name="nis" value="{{ old('nis') }}"
                    class="w-full text-xs rounded-lg border-slate-200 px-2.5 py-1.5 focus:border-brand-500 focus:ring-brand-500 @error('nis') border-rose-500 @enderror"
                    placeholder="Contoh: 123 / 2122100001" maxlength="10" minlength="3" inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateDigitCounter(this, 'nisCounter', 10, 'nisMsg', true);"
                    required>
                <small id="nisMsg" class="block text-[10px] font-medium text-rose-500 mt-0.5">Wajib diisi 3 hingga 10 digit angka.</small>
                @error('nis')
                    <small class="text-rose-500 font-semibold text-[10.5px] block mt-0.5"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                @enderror
            </div>

            <!-- NISN -->
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-1">
                    <label for="nisn" class="text-[11px] font-semibold text-slate-700">NISN <span class="text-rose-500">*</span></label>
                    <span id="nisnCounter" class="text-[10px] font-bold text-rose-500">0/10 digit</span>
                </div>
                <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}"
                    class="w-full text-xs rounded-lg border-slate-200 px-2.5 py-1.5 focus:border-brand-500 focus:ring-brand-500 @error('nisn') border-rose-500 @enderror"
                    placeholder="Contoh: 0051234567" maxlength="10" minlength="10" inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateDigitCounter(this, 'nisnCounter', 10, 'nisnMsg');"
                    required>
                <small id="nisnMsg" class="block text-[10px] font-medium text-rose-500 mt-0.5">Wajib diisi tepat 10 digit angka.</small>
                @error('nisn')
                    <small class="text-rose-500 font-semibold text-[10.5px] block mt-0.5"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                @enderror
            </div>

            <!-- Nama Lengkap -->
            <div class="sm:col-span-2 md:col-span-3 lg:col-span-4">
                <label for="nama_siswa" class="block text-[11px] font-semibold text-slate-700 mb-1">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                <input type="text" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}"
                    class="w-full text-xs rounded-lg border-slate-200 px-2.5 py-1.5 focus:border-brand-500 focus:ring-brand-500 @error('nama_siswa') border-rose-500 @enderror"
                    placeholder="Nama Lengkap Siswa" required>
                @error('nama_siswa')
                    <small class="text-rose-500 font-semibold text-[10.5px] block mt-0.5">{{ $message }}</small>
                @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div class="lg:col-span-2">
                <label for="jenis_kelamin" class="block text-[11px] font-semibold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                <select id="jenis_kelamin" name="jenis_kelamin"
                    class="w-full text-xs rounded-lg border-slate-200 px-2.5 py-1.5 focus:border-brand-500 focus:ring-brand-500 text-slate-700 @error('jenis_kelamin') border-rose-500 @enderror" required>
                    <option value="">-- Pilih JK --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                </select>
                @error('jenis_kelamin')
                    <small class="text-rose-500 font-semibold text-[10.5px] block mt-0.5">{{ $message }}</small>
                @enderror
            </div>

            <!-- Kelas -->
            <div class="lg:col-span-2">
                <label for="id_kelas" class="block text-[11px] font-semibold text-slate-700 mb-1">Kelas <span class="text-rose-500">*</span></label>
                <select id="id_kelas" name="id_kelas"
                    class="w-full text-xs rounded-lg border-slate-200 px-2.5 py-1.5 focus:border-brand-500 focus:ring-brand-500 text-slate-700 @error('id_kelas') border-rose-500 @enderror" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelass as $k)
                        <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                @error('id_kelas')
                    <small class="text-rose-500 font-semibold text-[10.5px] block mt-0.5">{{ $message }}</small>
                @enderror
            </div>
        </div>

<<<<<<< HEAD
        <!-- Form Filter Lengkap (Tingkat X, XI, XII, Jurusan, Kelas, JK, Sorting) -->
        <form action="{{ route('siswa.index') }}" method="GET" style="background:#f8fafc; padding:16px 20px; border-radius:14px; border:1px solid #cbd5e1; margin-bottom:20px;">
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom: 12px;">
                <!-- Search Input -->
                <div style="position:relative; flex: 1; min-width: 220px;">
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" style="padding-left:36px; background:#ffffff;" placeholder="Cari Siswa / NIS / NISN...">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                </div>

                <!-- Filter Tingkat (Level Kelas X, XI, XII) -->
                <div style="min-width: 140px;">
                    <select name="tingkat" id="filter_tingkat" onchange="filterKelasDropdown(this.value); updateSelectMutedState(this);" class="filter-select">
                        <option value="">Semua Tingkat (X, XI, XII)</option>
                        <option value="X" {{ (isset($tingkat) && $tingkat == 'X') ? 'selected' : '' }}>Kelas X</option>
                        <option value="XI" {{ (isset($tingkat) && $tingkat == 'XI') ? 'selected' : '' }}>Kelas XI</option>
                        <option value="XII" {{ (isset($tingkat) && $tingkat == 'XII') ? 'selected' : '' }}>Kelas XII</option>
                    </select>
                </div>

                <!-- Filter Jurusan -->
                <div style="min-width: 160px;">
                    <select name="id_jurusan" onchange="updateSelectMutedState(this);" class="filter-select">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id_jurusan }}" {{ (isset($id_jurusan) && $id_jurusan == $j->id_jurusan) ? 'selected' : '' }}>
                                {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Kelas -->
                <div style="min-width: 140px;">
                    <select name="id_kelas" id="filter_id_kelas" onchange="updateSelectMutedState(this);" class="filter-select">
                        <option value="">Semua Kelas</option>
                        @foreach($kelass as $k)
                            <option value="{{ $k->id_kelas }}" data-nama="{{ $k->nama_kelas }}" {{ (isset($id_kelas) && $id_kelas == $k->id_kelas) ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Jenis Kelamin -->
                <div style="min-width: 130px;">
                    <select name="jenis_kelamin" onchange="updateSelectMutedState(this);" class="filter-select">
                        <option value="">Semua JK</option>
                        <option value="L" {{ (isset($jenis_kelamin) && $jenis_kelamin == 'L') ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ (isset($jenis_kelamin) && $jenis_kelamin == 'P') ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>

                <!-- Filter Status (ON / OFF) -->
                <div style="min-width: 130px;">
                    <select name="status" onchange="updateSelectMutedState(this);" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="active" {{ (isset($status) && $status === 'active') ? 'selected' : '' }}>Aktif (ON)</option>
                        <option value="inactive" {{ (isset($status) && $status === 'inactive') ? 'selected' : '' }}>Nonaktif (OFF)</option>
                    </select>
                </div>

                <!-- Filter Urutan (Sorting) -->
                <div style="min-width: 140px;">
                    <select name="sort" onchange="updateSelectMutedState(this);" class="filter-select">
                        <option value="nama_asc" {{ (isset($sort) && $sort == 'nama_asc') ? 'selected' : '' }}>Nama (A - Z)</option>
                        <option value="nama_desc" {{ (isset($sort) && $sort == 'nama_desc') ? 'selected' : '' }}>Nama (Z - A)</option>
                        <option value="nis_asc" {{ (isset($sort) && $sort == 'nis_asc') ? 'selected' : '' }}>NIS Terkecil</option>
                        <option value="nis_desc" {{ (isset($sort) && $sort == 'nis_desc') ? 'selected' : '' }}>NIS Terbesar</option>
                    </select>
                </div>
            </div>

            <!-- Bar Indicator Filter Aktif & Tombol Aksi -->
            <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; border-top: 1px dashed #cbd5e1; padding-top: 10px;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; font-size:12px;">
                    <span style="font-weight:700; color:#64748b;">Filter Aktif:</span>
                    @if(!empty($search))
                        <span class="badge-kelas" style="background:#e0f2fe; color:#0369a1;"><i class="fa-solid fa-magnifying-glass"></i> "{{ $search }}"</span>
                    @endif
                    @if(!empty($tingkat))
                        <span class="badge-kelas" style="background:#dbeafe; color:#1e40af;"><i class="fa-solid fa-layer-group"></i> Kelas {{ $tingkat }}</span>
                    @endif
                    @if(!empty($id_jurusan))
                        @php $selJur = $jurusans->firstWhere('id_jurusan', $id_jurusan); @endphp
                        @if($selJur)
                            <span class="badge-kelas" style="background:#f0fdf4; color:#166534;"><i class="fa-solid fa-book"></i> {{ $selJur->kode_jurusan }}</span>
                        @endif
                    @endif
                    @if(!empty($id_kelas))
                        @php $selKls = $kelass->firstWhere('id_kelas', $id_kelas); @endphp
                        @if($selKls)
                            <span class="badge-kelas" style="background:#fef3c7; color:#92400e;"><i class="fa-solid fa-door-open"></i> {{ $selKls->nama_kelas }}</span>
                        @endif
                    @endif
                    @if(!empty($jenis_kelamin))
                        <span class="badge-kelas" style="background:#fce7f3; color:#9d174d;"><i class="fa-solid fa-venus-mars"></i> {{ $jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    @endif
                    @if(!empty($status))
                        <span class="badge-kelas" style="background:{{ $status == 'active' ? '#ecfdf5' : '#f1f5f9' }}; color:{{ $status == 'active' ? '#166534' : '#475569' }};">
                            <i class="fa-solid fa-power-off"></i> Status: {{ $status == 'active' ? 'Aktif (ON)' : 'Nonaktif (OFF)' }}
                        </span>
                    @endif
                    @if(empty($search) && empty($tingkat) && empty($id_jurusan) && empty($id_kelas) && empty($jenis_kelamin) && empty($status))
                        <span style="color:#94a3b8; font-style:italic;">Semua Data Siswa</span>
                    @endif
                </div>

                <div style="display:flex; align-items:center; gap:10px; margin-left:auto;">
                    <button type="submit" class="btn-filter" style="padding: 9px 20px;">
                        <i class="fa-solid fa-filter"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('siswa.index') }}" class="btn-reset" style="padding: 9px 18px;">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                    <a href="{{ route('siswa.trash') }}" class="btn-trash" style="padding: 9px 16px; border-radius: 12px; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;" title="Lihat Data Siswa di Tempat Sampah">
                        <i class="fa-solid fa-trash-can"></i> Lihat Sampah
                        @if(isset($trashedCount) && $trashedCount > 0)
                            <span class="badge-count">{{ $trashedCount }}</span>
                        @endif
                    </a>
                    <button type="button" id="btnBulkDelete" class="btn-action btn-delete" style="padding: 9px 16px; border-radius: 12px; font-size: 13px; opacity: 0.5; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(225,29,72,0.15); border: none;" disabled onclick="confirmBulkDelete()" title="Pilih siswa dengan mencentang checkbox untuk menghapus secara massal">
                        <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="bulkDeleteCount">0</span>)
                    </button>
                </div>
=======
        <!-- Row 2: Kota Lahir & Tanggal Lahir -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="kota_lahir" class="block text-[11px] font-semibold text-slate-700 mb-1">Kota Lahir <span class="text-slate-400 font-normal">(Opsional)</span></label>
                <input type="text" id="kota_lahir" name="kota_lahir" value="{{ old('kota_lahir') }}"
                    class="w-full text-xs rounded-lg border-slate-200 px-2.5 py-1.5 focus:border-brand-500 focus:ring-brand-500 @error('kota_lahir') border-rose-500 @enderror"
                    placeholder="Kota/Tempat Lahir (boleh dikosongkan)">
                <small class="text-[10px] text-slate-400 mt-0.5 block">Opsional — boleh tidak diisi jika belum diketahui.</small>
                @error('kota_lahir')
                    <small class="text-rose-500 font-semibold text-[10.5px] block mt-0.5">{{ $message }}</small>
                @enderror
            </div>
            <div>
                <label for="tanggal_lahir" class="block text-[11px] font-semibold text-slate-700 mb-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                    class="w-full text-xs rounded-lg border-slate-200 px-2.5 py-1.5 focus:border-brand-500 focus:ring-brand-500 text-slate-700 @error('tanggal_lahir') border-rose-500 @enderror" required>
                @error('tanggal_lahir')
                    <small class="text-rose-500 font-semibold text-[10.5px] block mt-0.5">{{ $message }}</small>
                @enderror
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
            </div>
        </div>

        <!-- Row 3: Alamat Lengkap -->
        <div>
            <label for="alamat_lengkap" class="block text-[11px] font-semibold text-slate-700 mb-1">Alamat Lengkap <span class="text-slate-400 font-normal">(Opsional)</span></label>
            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="2"
                class="w-full text-xs rounded-lg border-slate-200 px-2.5 py-1.5 focus:border-brand-500 focus:ring-brand-500 @error('alamat_lengkap') border-rose-500 @enderror"
                placeholder="Masukkan Alamat Lengkap Siswa (boleh dikosongkan)">{{ old('alamat_lengkap') }}</textarea>
            <small class="text-[10px] text-slate-400 mt-0.5 block">Opsional — boleh tidak diisi jika belum diketahui.</small>
            @error('alamat_lengkap')
                <small class="text-rose-500 font-semibold text-[10.5px] block mt-0.5">{{ $message }}</small>
            @enderror
        </div>

<<<<<<< HEAD
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllSiswa" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" title="Pilih Semua (Select All)">
                            </th>
                            <th>NIS</th>
                            <th>NISN</th>
                            <th>NAMA SISWA</th>
                            <th>JK</th>
                            <th>KELAS</th>
                            <th>TEMPAT & TGL LAHIR</th>
                            <th>ALAMAT</th>
                            <th style="text-align:center; min-width: 110px;">STATUS</th>
                            <th style="text-align:center; min-width: 220px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $s)
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $s->id_siswa }}" class="siswa-select-checkbox" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" onchange="updateBulkDeleteState()">
                                </td>
                                <td><strong>{{ $s->nis ?? '-' }}</strong></td>
                                <td><span style="font-family:monospace; font-weight:700; color:#3b5490;">{{ $s->nisn }}</span></td>
                                <td><strong>{{ $s->nama_siswa }}</strong></td>
                                <td>
                                    @if($s->jenis_kelamin == 'L')
                                        <span class="badge-jk badge-jk-l">Laki-laki</span>
                                    @elseif($s->jenis_kelamin == 'P')
                                        <span class="badge-jk badge-jk-p">Perempuan</span>
                                    @else
                                        <span style="color:#94a3b8;">-</span>
                                    @endif
                                </td>
                                <td><span class="badge-kelas">{{ $s->kelas->nama_kelas ?? '-' }}</span></td>
                                <td>
                                    @if($s->kota_lahir || $s->tanggal_lahir)
                                        {{ $s->kota_lahir ?? '' }}{{ $s->kota_lahir && $s->tanggal_lahir ? ', ' : '' }}{{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->format('d/m/Y') : '' }}
                                    @else
                                        <span style="color:#94a3b8;">-</span>
                                    @endif
                                </td>
                                <td>{{ $s->alamat_lengkap ? \Illuminate\Support\Str::limit($s->alamat_lengkap, 35) : '-' }}</td>
                                <td style="text-align:center;">
                                    <div class="siswa-status-switch-wrapper">
                                        <label class="siswa-toggle-switch" title="Klik untuk mengaktifkan / menonaktifkan data siswa">
                                            <input type="checkbox" 
                                                   id="toggle-siswa-{{ $s->id_siswa }}"
                                                   {{ ($s->is_active ?? 1) ? 'checked' : '' }} 
                                                   onchange="handleSiswaToggle(this, {{ $s->id_siswa }}, '{{ addslashes($s->nama_siswa) }}')">
                                            <span class="siswa-toggle-slider"></span>
                                        </label>
                                        <span id="status-label-siswa-{{ $s->id_siswa }}" class="siswa-status-label {{ ($s->is_active ?? 1) ? 'status-on' : 'status-off' }}">
                                            {{ ($s->is_active ?? 1) ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                </td>
                                <td style="text-align:center;">
                                    <div class="action-buttons">
                                        <!-- 1. LIHAT (Detail) - Disebelah kiri Edit & Hapus -->
                                        <a href="{{ route('siswa.show', $s->id_siswa) }}" class="btn-action btn-view" title="Lihat Detail Siswa">
                                            <i class="fa-solid fa-eye"></i> Lihat
                                        </a>

                                        <!-- 2. EDIT - Disebelah kiri Hapus -->
                                        <a href="{{ route('siswa.edit', $s->id_siswa) }}" class="btn-action btn-edit" title="Edit Data Siswa">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>

                                        <!-- 3. HAPUS - Paling kanan -->
                                        <button type="button" class="btn-action btn-delete" onclick="deleteSingleSiswa({{ $s->id_siswa }}, '{{ addslashes($s->nama_siswa) }}')" title="Hapus Siswa">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align:center; padding:36px; color:#94a3b8;">
                                    <i class="fa-solid fa-folder-open" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                    Belum ada data Siswa yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
=======
        <!-- Form Buttons -->
        <div class="flex items-center justify-between pt-1">
            <button type="button" onclick="resetSingleSiswaForm()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200/80 transition-all cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Reset Form</span>
            </button>
            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl text-xs font-semibold bg-brand-700 hover:bg-brand-800 text-white shadow-sm transition-all cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Simpan Data Siswa</span>
            </button>
        </div>
    </form>
</section>
<!-- END: Panel 1 -->

<!-- BEGIN: Panel 2 - Import File Excel (Multi-Format: PDF, Word, Excel, CSV) -->
<section class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-sm space-y-3.5 transition-all mb-4 hidden" data-purpose="form-excel-import" id="panel-excel">
    <!-- Section Header -->
    <div class="flex items-start justify-between flex-wrap gap-3 pb-3 border-b border-slate-100">
        <div class="flex items-start gap-3">
            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                <span class="material-symbols-outlined text-xl">file_upload</span>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Tambah Siswa Baru via Import File (Multi-Format)</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Unggah file (.xlsx, .xls, .csv, .pdf, atau .docx) berisi daftar siswa baru, lalu klik <span class="font-semibold text-slate-700">Proses File Data Siswa</span> untuk memasukkan ke tabel.</p>
            </div>
        </div>
        <!-- Download Template Action -->
        <a href="{{ route('siswa.download-template') }}" onclick="downloadTemplateExcelJS(event)" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-brand-700 hover:bg-brand-800 text-white shadow-sm transition-all no-underline">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>Download Template Excel (.xlsx)</span>
        </a>
    </div>

    <!-- Instructions Alert Box -->
    <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-xl p-3 flex gap-2.5 text-xs text-emerald-900 leading-relaxed">
        <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">info</span>
        <div class="space-y-0.5">
            <h4 class="font-bold text-[11px] text-emerald-800">Petunjuk Penggunaan Fitur Import File:</h4>
            <p class="text-[10.5px] text-emerald-700/90 leading-normal">
                1. Unduh template file Excel dengan menekan tombol <strong>Download Template Excel (.xlsx)</strong> di atas.<br>
                2. Sistem mendukung format: <strong>.xlsx, .xls, .csv, .pdf, .docx, .doc</strong> (Maks: 10MB).<br>
                3. Pastikan data berisi kolom: <strong>NIS, NISN, Nama Lengkap Siswa, Jenis Kelamin (L/P), Kota Lahir, Tanggal Lahir (YYYY-MM-DD), Alamat Lengkap</strong>.<br>
                4. Tentukan <strong>Kelas Target</strong> (opsional) atau biarkan sistem mendeteksi kelas secara otomatis dari file.<br>
                5. Pilih <strong>Mode Masukkan Data</strong> (Ganti / Timpa atau Tambahkan), lalu klik <strong>Proses File Data Siswa</strong>.
            </p>
        </div>
    </div>

    <!-- Feedback Alert Banner Pasca Proses File (JS Generated) -->
    <div id="excelProcessAlert" class="hidden p-3 rounded-xl border flex items-start justify-between gap-2.5 text-xs">
        <div class="flex items-start gap-2.5 w-full">
            <span id="excelAlertIcon" class="material-symbols-outlined text-lg shrink-0 mt-0.5">check_circle</span>
            <div class="flex-1">
                <h4 id="excelAlertTitle" class="font-bold text-xs"></h4>
                <p id="excelAlertMsg" class="mt-0.5 text-[11px] leading-normal"></p>
                <ul id="excelAlertDetails" class="list-disc list-inside mt-1 text-[11px] space-y-0.5 hidden"></ul>
            </div>
        </div>
        <button type="button" onclick="document.getElementById('excelProcessAlert').classList.add('hidden')" class="hover:opacity-75 cursor-pointer">
            <span class="material-symbols-outlined text-base">close</span>
        </button>
    </div>

    <!-- Loading Indicator -->
    <div id="importFileLoading" class="hidden text-center p-4 bg-teal-50 border border-teal-200 rounded-xl">
        <i class="fa-solid fa-spinner fa-spin text-xl text-teal-600 mb-1.5"></i>
        <p id="importFileLoadingMsg" class="text-xs font-bold text-teal-800">Sedang membaca file data siswa...</p>
    </div>

    <!-- Import Options Form Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <!-- File Input -->
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
            <label for="excel_file_input" class="block text-[11px] font-semibold text-slate-700 mb-1.5">Pilih File Data Siswa <span class="text-rose-500">*</span></label>
            <input type="file" id="excel_file_input" accept=".xlsx,.xls,.csv,.pdf,.doc,.docx" class="w-full text-xs text-slate-500 file:mr-2.5 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-white file:text-slate-700 hover:file:bg-slate-100 border border-slate-200 rounded-lg p-1 bg-white cursor-pointer" onchange="onSiswaFileSelected(this)">
            <p id="importFileTypeHint" class="text-[10px] text-slate-400 mt-1">Format: <strong>.pdf, .docx, .doc, .xlsx, .xls, .csv</strong> (Maks: 10MB)</p>
        </div>

        <!-- Target Class -->
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
            <label for="excel_target_kelas" class="block text-[11px] font-semibold text-slate-700 mb-1.5">Pilih Kelas Target (Opsional)</label>
            <select id="excel_target_kelas" onchange="syncTargetKelasToBulk(this.value)" class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2.5 bg-white focus:ring-brand-500 text-slate-700">
                <option value="">-- Otomatis Dari File / Ikuti Pilihan Bulk --</option>
                @foreach($kelass as $k)
                    <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} (Estimasi: {{ $k->jumlah_siswa }} Siswa)</option>
                @endforeach
            </select>
            <p class="text-[10px] text-slate-400 mt-1">Jika dipilih, otomatis mengatur Kelas Target pada seluruh data.</p>
        </div>

        <!-- Insertion Mode -->
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
            <label for="excel_import_mode" class="block text-[11px] font-semibold text-slate-700 mb-1.5">Mode Masukkan Data</label>
            <select id="excel_import_mode" class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2.5 bg-white focus:ring-brand-500 text-slate-700">
                <option value="replace">Ganti / Timpa Seluruh Baris Tabel</option>
                <option value="append">Tambahkan ke Baris yang Ada</option>
            </select>
            <p class="text-[10px] text-slate-400 mt-1">Pilih apakah data file menggantikan atau menambahkan baris.</p>
        </div>
    </div>

    <!-- Action Footer -->
    <div class="flex items-center justify-between pt-1">
        <button type="button" onclick="clearExcelFileInput()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition-all cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>Reset File</span>
        </button>
        <button type="button" id="btnProcessExcel" onclick="processImportFile()" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition-all cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>Proses File Data Siswa</span>
        </button>
    </div>
</section>
<!-- END: Panel 2 -->

<!-- BEGIN: Panel 3 - Input Cepat & Massal -->
<section class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-sm space-y-3.5 transition-all mb-4 hidden" data-purpose="form-quick-bulk-entry" id="panel-massal">
    <div class="flex items-start justify-between flex-wrap gap-3 pb-3 border-b border-slate-100">
        <div class="flex items-start gap-3">
            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                <span class="material-symbols-outlined text-xl">groups</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Tambah Siswa Baru Secara Cepat dan Banyak (Input Massal Per Kelas)</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Masukkan data banyak siswa sekaligus berdasarkan <strong>Per Kelas</strong> dalam 1 kali simpan.</p>
            </div>
        </div>
        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
            <span class="material-symbols-outlined text-[15px]">dataset</span>
            <span>Mode Input Massal Per Kelas</span>
        </div>
    </div>

    @if($errors->has('siswa') || $errors->has('id_kelas'))
        <div class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start justify-between gap-2.5 text-xs">
            <div class="flex items-start gap-2.5">
                <span class="material-symbols-outlined text-rose-600 text-lg shrink-0 mt-0.5">error</span>
                <div>
                    <h4 class="font-bold text-xs text-rose-900">Gagal Menyimpan Data Siswa Massal!</h4>
                    <p class="mt-0.5 text-[11px]">{{ $errors->first('siswa') ?? $errors->first('id_kelas') }}</p>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 cursor-pointer">
                <span class="material-symbols-outlined text-base">close</span>
            </button>
        </div>
    @endif

    <!-- Alert Banner Alasan Gagal Simpan Bulk (JS Generated) -->
    <div id="bulkErrorReasonBanner" class="hidden p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start justify-between gap-2.5 text-xs">
        <div class="flex items-start gap-2.5">
            <span class="material-symbols-outlined text-rose-600 text-lg shrink-0 mt-0.5">warning</span>
            <div>
                <h4 class="font-bold text-xs text-rose-900">Data massal belum bisa disimpan! Silakan perbaiki pengisian berikut:</h4>
                <ul id="bulkErrorReasonList" class="list-disc list-inside mt-1 text-[11px] text-rose-700 space-y-0.5"></ul>
            </div>
        </div>
        <button type="button" onclick="document.getElementById('bulkErrorReasonBanner').classList.add('hidden')" class="text-rose-500 hover:text-rose-700 cursor-pointer">
            <span class="material-symbols-outlined text-base">close</span>
        </button>
    </div>

    <form id="formSiswaBulk" action="{{ route('siswa.store-batch') }}" method="POST" class="space-y-3" novalidate>
        @csrf

        <!-- Class Selector Target -->
        <div class="max-w-xs space-y-1">
            <label for="bulk_id_kelas" class="block text-[11px] font-semibold text-slate-700">Pilih Kelas Target (Per Kelas) <span class="text-rose-500">*</span></label>
            <select id="bulk_id_kelas" name="id_kelas" class="w-full text-xs rounded-lg border-slate-200 px-2.5 py-1.5 text-slate-700 focus:ring-brand-500 @error('id_kelas') border-rose-500 @enderror" required>
                <option value="">-- Pilih Kelas Target --</option>
                @foreach($kelass as $k)
                    <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                        {{ $k->nama_kelas }} (Estimasi: {{ $k->jumlah_siswa }} Siswa)
                    </option>
                @endforeach
            </select>
            <p class="text-[10px] text-slate-400">Seluruh data siswa yang diisi di bawah akan dimasukkan langsung ke kelas ini.</p>
            @error('id_kelas')
                <small class="text-rose-500 font-semibold text-[10.5px] block mt-0.5">{{ $message }}</small>
            @enderror
        </div>

        <!-- Bulk Entry Interactive Table -->
        <div class="overflow-x-auto border border-slate-200 rounded-xl">
            <table class="w-full text-left border-collapse text-xs" id="tableBulkSiswa" style="min-width: 1050px;">
                <thead class="bg-slate-50/80 text-[10.5px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-2.5 px-2.5 w-12 text-center">NO</th>
                        <th class="py-2.5 px-2.5 w-36">NIS (3-10 DIGIT) <span class="text-rose-500">*</span></th>
                        <th class="py-2.5 px-2.5 w-36">NISN (10 DIGIT) <span class="text-rose-500">*</span></th>
                        <th class="py-2.5 px-2.5 w-48">NAMA LENGKAP SISWA <span class="text-rose-500">*</span></th>
                        <th class="py-2.5 px-2.5 w-28">JENIS KELAMIN <span class="text-rose-500">*</span></th>
                        <th class="py-2.5 px-2.5 w-36">KOTA LAHIR <span class="text-slate-400 font-normal">(Opsional)</span></th>
                        <th class="py-2.5 px-2.5 w-36">TGL LAHIR <span class="text-rose-500">*</span></th>
                        <th class="py-2.5 px-2.5">ALAMAT LENGKAP <span class="text-slate-400 font-normal">(Opsional)</span></th>
                        <th class="py-2.5 px-2.5 w-20 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody id="bulkTableBody" class="divide-y divide-slate-200/80 text-slate-700">
                    <!-- Dynamic Rows injected via JS -->
                </tbody>
            </table>
        </div>

        <!-- Bulk Action Controls & Submit -->
        <div class="flex items-center justify-between flex-wrap gap-2.5 pt-1">
            <div class="flex items-center gap-1.5 flex-wrap">
                <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-700 hover:bg-emerald-800 text-white transition-all cursor-pointer" onclick="addBulkRow()">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Tambah Baris Siswa</span>
                </button>
                <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white transition-all cursor-pointer" onclick="addMultipleBulkRows(5)">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>+5 Baris</span>
                </button>
                <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition-all cursor-pointer" onclick="resetAllBulkFields()" title="Kosongkan isian data pada seluruh baris tabel">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Reset Baris</span>
                </button>
                <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition-all cursor-pointer" onclick="clearBulkRows()" title="Hapus seluruh baris tabel siswa">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Kosongkan Tabel</span>
                </button>
                <span class="text-xs text-slate-500 font-medium ml-1">Total: <strong id="totalBulkRowsCount" class="text-slate-800">0</strong> baris siswa</span>
            </div>

            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition-all cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Simpan Data Siswa</span>
            </button>
        </div>
    </form>
</section>
<!-- END: Panel 3 -->

<!-- BEGIN: StudentListSection -->
<section class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-sm space-y-3.5" data-purpose="student-datatable-card">
    <!-- Title & Subtitle -->
    <div class="flex items-start justify-between flex-wrap gap-3 pb-1">
        <div class="flex items-start gap-3">
            <div class="p-2 bg-brand-50 text-brand-600 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Daftar Data Siswa <span class="text-brand-600">({{ count($siswas) }})</span></h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Kelola dan pantau seluruh data siswa yang terdaftar dalam sistem.</p>
            </div>
        </div>

        @if(isset($totalAktifCount) && $totalAktifCount > 0)
            <div class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-xl">
                <span>Total Siswa Aktif:</span>
                <strong class="text-brand-600 font-bold">{{ $totalAktifCount }}</strong>
            </div>
        @endif
    </div>

    <!-- Filter & Search Toolbar (GET form to route siswa.index) -->
    <form action="{{ route('siswa.index') }}" method="GET" class="bg-slate-50/80 border border-slate-200/80 rounded-xl p-3 space-y-2.5">
        <!-- Row 1: Search & Filter Selectors -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 xl:grid-cols-12 gap-2">
            <!-- Search Input -->
            <div class="relative sm:col-span-2 md:col-span-3 lg:col-span-2 xl:col-span-3">
                <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    class="w-full text-xs rounded-lg border-slate-200 pl-8 pr-2.5 py-1.5 bg-white focus:border-brand-500 focus:ring-brand-500"
                    placeholder="Cari Siswa / NIS / NISN...">
            </div>

            <!-- Filter Tingkat (X, XI, XII) -->
            <div class="sm:col-span-1 md:col-span-1 lg:col-span-1 xl:col-span-1">
                <select name="tingkat" id="filter_tingkat" onchange="filterKelasDropdown(this.value); updateSelectMutedState(this);"
                    class="filter-select-custom w-full text-xs rounded-lg border-slate-200 py-1.5 px-2 bg-white text-slate-600 focus:ring-brand-500">
                    <option value="">Semua Tingkat</option>
                    <option value="X" {{ (isset($tingkat) && $tingkat == 'X') ? 'selected' : '' }}>Kelas X</option>
                    <option value="XI" {{ (isset($tingkat) && $tingkat == 'XI') ? 'selected' : '' }}>Kelas XI</option>
                    <option value="XII" {{ (isset($tingkat) && $tingkat == 'XII') ? 'selected' : '' }}>Kelas XII</option>
                </select>
            </div>

            <!-- Filter Jurusan -->
            <div class="sm:col-span-1 md:col-span-2 lg:col-span-1 xl:col-span-2">
                <select name="id_jurusan" onchange="updateSelectMutedState(this);"
                    class="filter-select-custom w-full text-xs rounded-lg border-slate-200 py-1.5 px-2 bg-white text-slate-600 focus:ring-brand-500">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id_jurusan }}" {{ (isset($id_jurusan) && $id_jurusan == $j->id_jurusan) ? 'selected' : '' }}>
                            {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Kelas -->
            <div class="sm:col-span-1 md:col-span-1 lg:col-span-1 xl:col-span-2">
                <select name="id_kelas" id="filter_id_kelas" onchange="updateSelectMutedState(this);"
                    class="filter-select-custom w-full text-xs rounded-lg border-slate-200 py-1.5 px-2 bg-white text-slate-600 focus:ring-brand-500">
                    <option value="">Semua Kelas</option>
                    @foreach($kelass as $k)
                        <option value="{{ $k->id_kelas }}" data-nama="{{ $k->nama_kelas }}" {{ (isset($id_kelas) && $id_kelas == $k->id_kelas) ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Jenis Kelamin -->
            <div class="sm:col-span-1 md:col-span-1 lg:col-span-1 xl:col-span-2">
                <select name="jenis_kelamin" onchange="updateSelectMutedState(this);"
                    class="filter-select-custom w-full text-xs rounded-lg border-slate-200 py-1.5 px-2 bg-white text-slate-600 focus:ring-brand-500">
                    <option value="">Semua JK</option>
                    <option value="L" {{ (isset($jenis_kelamin) && $jenis_kelamin == 'L') ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ (isset($jenis_kelamin) && $jenis_kelamin == 'P') ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Sort -->
            <div class="sm:col-span-1 md:col-span-1 lg:col-span-1 xl:col-span-2">
                <select name="sort" onchange="updateSelectMutedState(this);"
                    class="filter-select-custom w-full text-xs rounded-lg border-slate-200 py-1.5 px-2 bg-white text-slate-600 focus:ring-brand-500">
                    <option value="nama_asc" {{ (isset($sort) && $sort == 'nama_asc') ? 'selected' : '' }}>A - Z</option>
                    <option value="nama_desc" {{ (isset($sort) && $sort == 'nama_desc') ? 'selected' : '' }}>Z - A</option>
                    <option value="nis_asc" {{ (isset($sort) && $sort == 'nis_asc') ? 'selected' : '' }}>NIS ↑</option>
                    <option value="nis_desc" {{ (isset($sort) && $sort == 'nis_desc') ? 'selected' : '' }}>NIS ↓</option>
                </select>
            </div>
        </div>

        <!-- Row 2: Active Filter Pills & Action Buttons -->
        <div class="flex items-center justify-between flex-wrap gap-2.5 pt-2 border-t border-slate-200/60">
            <!-- Left: Active Filter Pills -->
            <div class="flex items-center gap-1.5 flex-wrap text-xs">
                <span class="font-bold text-slate-400 uppercase text-[10px] tracking-wider mr-1">Filter Aktif:</span>
                @if(!empty($search))
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10.5px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                        <i class="fa-solid fa-magnifying-glass text-[9px]"></i> "{{ $search }}"
                    </span>
                @endif
                @if(!empty($tingkat))
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10.5px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                        <i class="fa-solid fa-layer-group text-[9px]"></i> Kelas {{ $tingkat }}
                    </span>
                @endif
                @if(!empty($id_jurusan))
                    @php $selJur = $jurusans->firstWhere('id_jurusan', $id_jurusan); @endphp
                    @if($selJur)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10.5px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <i class="fa-solid fa-book text-[9px]"></i> {{ $selJur->kode_jurusan }}
                        </span>
                    @endif
                @endif
                @if(!empty($id_kelas))
                    @php $selKls = $kelass->firstWhere('id_kelas', $id_kelas); @endphp
                    @if($selKls)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10.5px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                            <i class="fa-solid fa-door-open text-[9px]"></i> {{ $selKls->nama_kelas }}
                        </span>
                    @endif
                @endif
                @if(!empty($jenis_kelamin))
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10.5px] font-semibold bg-pink-50 text-pink-700 border border-pink-200">
                        <i class="fa-solid fa-venus-mars text-[9px]"></i> {{ $jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                @endif
                @if(empty($search) && empty($tingkat) && empty($id_jurusan) && empty($id_kelas) && empty($jenis_kelamin))
                    <span class="text-slate-400 italic text-[10.5px]">Semua Data Siswa</span>
                @endif
            </div>

            <!-- Right: Filter Actions & Bulk Delete -->
            <div class="flex items-center gap-1.5">
                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-brand-700 hover:bg-brand-800 text-white transition-all cursor-pointer shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Cari</span>
                </button>
                <a href="{{ route('siswa.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition-all no-underline">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Reset</span>
                </a>
                <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" disabled
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition-all opacity-50 cursor-not-allowed"
                    title="Pilih siswa dengan mencentang checkbox untuk menghapus secara massal">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Hapus Terpilih (<span id="bulkDeleteCount">0</span>)</span>
                </button>
            </div>
        </div>
    </form>

    <!-- Form Bulk Delete Wrapper -->
    <form id="formBulkDelete" action="{{ route('siswa.destroy-batch') }}" method="POST">
        @csrf
        @method('DELETE')

        <!-- DataTable Container -->
        <div class="overflow-x-auto border border-slate-200/80 rounded-xl">
            <table class="w-full text-left border-collapse text-xs">
                <thead class="bg-slate-50/80 text-[10.5px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200 whitespace-nowrap">
                    <tr>
                        <th class="py-2.5 px-3 w-10 text-center">
                            <input type="checkbox" id="selectAllSiswa" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500 cursor-pointer" title="Pilih Semua (Select All)">
                        </th>
                        <th class="py-2.5 px-3">NIS</th>
                        <th class="py-2.5 px-3">NISN</th>
                        <th class="py-2.5 px-3">NAMA SISWA</th>
                        <th class="py-2.5 px-3">JK</th>
                        <th class="py-2.5 px-3">KELAS</th>
                        <th class="py-2.5 px-3">TEMPAT &amp; TGL LAHIR</th>
                        <th class="py-2.5 px-3">ALAMAT</th>
                        <th class="py-2.5 px-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/70 text-slate-700">
                    @forelse($siswas as $s)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-2 px-3 text-center whitespace-nowrap">
                                <input type="checkbox" name="ids[]" value="{{ $s->id_siswa }}" class="siswa-select-checkbox rounded border-slate-300 text-brand-600 focus:ring-brand-500 cursor-pointer" onchange="updateBulkDeleteState()">
                            </td>
                            <td class="py-2 px-3 font-semibold text-slate-800 whitespace-nowrap">
                                {{ $s->nis ?? '-' }}
                            </td>
                            <td class="py-2 px-3 font-mono font-medium text-brand-600 whitespace-nowrap">
                                {{ $s->nisn }}
                            </td>
                            <td class="py-2 px-3 font-bold text-slate-900">
                                {{ $s->nama_siswa }}
                            </td>
                            <td class="py-2 px-3 whitespace-nowrap">
                                @if($s->jenis_kelamin == 'L')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10.5px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">Laki-laki</span>
                                @elseif($s->jenis_kelamin == 'P')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10.5px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">Perempuan</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-2 px-3 font-medium text-slate-800 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10.5px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $s->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="py-2 px-3 text-slate-600 whitespace-nowrap">
                                @if($s->kota_lahir || $s->tanggal_lahir)
                                    {{ $s->kota_lahir ?? '' }}{{ $s->kota_lahir && $s->tanggal_lahir ? ', ' : '' }}{{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->format('d/m/Y') : '' }}
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-2 px-3 text-slate-600 max-w-[200px] truncate" title="{{ $s->alamat_lengkap }}">
                                {{ $s->alamat_lengkap ? \Illuminate\Support\Str::limit($s->alamat_lengkap, 35) : '-' }}
                            </td>
                            <td class="py-2 px-3 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- 1. LIHAT (Detail) -->
                                    <a href="{{ route('siswa.show', $s->id_siswa) }}" class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[10.5px] font-semibold bg-sky-50 text-sky-700 hover:bg-sky-100 border border-sky-200 no-underline transition-all" title="Lihat Detail Siswa">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                        <span>Lihat</span>
                                    </a>

                                    <!-- 2. EDIT -->
                                    <a href="{{ route('siswa.edit', $s->id_siswa) }}" class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[10.5px] font-semibold bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 no-underline transition-all" title="Edit Data Siswa">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    <!-- 3. HAPUS -->
                                    <button type="button" onclick="deleteSingleSiswa({{ $s->id_siswa }}, '{{ addslashes($s->nama_siswa) }}')" class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[10.5px] font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 transition-all cursor-pointer" title="Hapus Siswa">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-10 text-slate-400">
                                <span class="material-symbols-outlined text-3xl mb-1.5 text-slate-300 block">folder_open</span>
                                <p class="text-xs font-semibold">Belum ada data Siswa yang terdaftar dalam sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    <!-- DataTable Footer -->
    <div class="flex items-center justify-between flex-wrap gap-3 pt-2 text-xs text-slate-500 border-t border-slate-100">
        <div>
            Menampilkan <strong class="text-slate-800 font-semibold">{{ count($siswas) }}</strong> data siswa
            @if(isset($totalAktifCount))
                dari total <strong class="text-slate-800 font-semibold">{{ $totalAktifCount }}</strong> siswa aktif
            @endif
        </div>
    </div>
</section>
<!-- END: StudentListSection -->

<!-- Form Delete Siswa Tunggal (Hidden) -->
<form id="singleDeleteSiswaForm" action="" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('scripts')
<!-- Library SheetJS, PDF.js, & Mammoth.js untuk Multi-Format File Reader di Sisi Client -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/mammoth@1.6.0/mammoth.browser.min.js"></script>

<script>
    if (typeof pdfjsLib !== 'undefined') {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    }

    const availableClasses = @json($kelass);

    /* =========================================================
     * 1. TAB SWITCHING FUNCTIONALITY
     * ========================================================= */
    function switchInputTab(tabKey) {
        const tabs = ['manual', 'excel', 'massal'];
        
        const activeClass = 'tab-button inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-brand-700 text-white shadow-sm transition-all cursor-pointer';
        const inactiveClass = 'tab-button inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-700 hover:text-brand-700 hover:bg-white/80 transition-all cursor-pointer';

        tabs.forEach(function(t) {
            const panel = document.getElementById('panel-' + t);
            const btn = document.getElementById('tab-btn-' + t);

            if (panel) {
                if (t === tabKey) {
                    panel.classList.remove('hidden');
                } else {
                    panel.classList.add('hidden');
                }
            }

            if (btn) {
                if (t === tabKey) {
                    btn.className = activeClass;
                } else {
                    btn.className = inactiveClass;
                }
            }
        });
    }


    /* =========================================================
     * 2. SINGLE DELETE SISWA
     * ========================================================= */
    function deleteSingleSiswa(id, nama) {
        if (confirm(`Apakah Anda yakin ingin memindahkan siswa "${nama}" ke tempat sampah?`)) {
            const form = document.getElementById('singleDeleteSiswaForm');
            form.action = "{{ url('/siswa') }}/" + id;
            form.submit();
        }
    }

    /* =========================================================
     * 3. DIGIT COUNTER FOR SINGLE STUDENT FORM
     * ========================================================= */
    function updateDigitCounter(input, counterId, targetLen, msgId, isNis = false) {
        const counter = document.getElementById(counterId);
        const msgEle  = document.getElementById(msgId);
        const len     = input.value.length;

        if (counter) {
            if (isNis) {
                counter.textContent = len + '/10 digit';
                counter.className = (len >= 3 && len <= 10) ? 'text-[10px] font-bold text-emerald-600' : 'text-[10px] font-bold text-rose-500';
            } else {
                counter.textContent = len + '/' + targetLen + ' digit';
                counter.className = (len === targetLen) ? 'text-[10px] font-bold text-emerald-600' : 'text-[10px] font-bold text-rose-500';
            }
        }

        if (msgEle) {
            if (isNis) {
                if (len === 0) {
                    msgEle.textContent = 'Wajib diisi 3 hingga 10 digit angka.';
                    msgEle.className = 'block text-[10px] font-medium text-rose-500 mt-1';
                } else if (len < 3) {
                    msgEle.textContent = 'Belum cukup, minimal 3 digit (kurang ' + (3 - len) + ' digit lagi).';
                    msgEle.className = 'block text-[10px] font-medium text-rose-500 mt-1';
                } else {
                    msgEle.textContent = '✓ Format ' + len + ' digit angka sudah sesuai.';
                    msgEle.className = 'block text-[10px] font-medium text-emerald-600 mt-1';
                }
            } else {
                if (len === 0) {
                    msgEle.textContent = 'Wajib diisi tepat ' + targetLen + ' digit angka.';
                    msgEle.className = 'block text-[10px] font-medium text-rose-500 mt-1';
                } else if (len < targetLen) {
                    msgEle.textContent = 'Belum lengkap, baru ' + len + ' digit (kurang ' + (targetLen - len) + ' digit lagi).';
                    msgEle.className = 'block text-[10px] font-medium text-rose-500 mt-1';
                } else {
                    msgEle.textContent = '✓ Format ' + targetLen + ' digit angka sudah sesuai.';
                    msgEle.className = 'block text-[10px] font-medium text-emerald-600 mt-1';
                }
            }
        }
    }

    /* =========================================================
     * 4. BULK ENTRY (INPUT MASSAL) LOGIC
     * ========================================================= */
    let bulkRowIndex = 0;

    function createBulkRowHTML(index, data = {}) {
        const nisVal     = data.nis || '';
        const nisnVal    = data.nisn || '';
        const namaVal    = data.nama_siswa || '';
        const jkVal      = data.jenis_kelamin || '';
        const kotaVal    = data.kota_lahir || '';
        const tglVal     = data.tanggal_lahir || '';
        const alamatVal  = data.alamat_lengkap || '';
        const idKelasVal = data.id_kelas || '';
        const kelasName  = data.kelas_name || '';

        let badgeKelas = '';
        if (kelasName) {
            badgeKelas = `<span class="block text-[9px] font-bold text-sky-700 bg-sky-100 px-1.5 py-0.5 rounded mt-1" title="Kelas dari file">${kelasName}</span>`;
        }

        return `
            <tr id="bulkRow_${index}" class="bulk-siswa-row hover:bg-slate-50/60 transition-colors">
                <td class="p-2 text-center font-bold text-slate-400 row-number">
                    1
                    ${badgeKelas}
                    <input type="hidden" name="siswa[${index}][id_kelas]" class="bulk-id-kelas" value="${idKelasVal}">
                </td>
                <td class="p-2">
                    <input type="text" name="siswa[${index}][nis]" value="${nisVal}"
                        class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2.5 focus:ring-brand-500 bulk-nis" placeholder="3-10 Digit" maxlength="10" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateBulkDigitCounter(this, 'counter_nis_${index}', 10, true);" required>
                    <small id="counter_nis_${index}" class="block text-[10px] font-bold text-rose-500 mt-0.5">0/10 digit</small>
                </td>
                <td class="p-2">
                    <input type="text" name="siswa[${index}][nisn]" value="${nisnVal}"
                        class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2.5 focus:ring-brand-500 bulk-nisn" placeholder="10 Digit" maxlength="10" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateBulkDigitCounter(this, 'counter_nisn_${index}', 10);" required>
                    <small id="counter_nisn_${index}" class="block text-[10px] font-bold text-rose-500 mt-0.5">0/10 digit</small>
                </td>
                <td class="p-2">
                    <input type="text" name="siswa[${index}][nama_siswa]" value="${namaVal}"
                        class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2.5 focus:ring-brand-500 bulk-nama" placeholder="Nama Lengkap Siswa" required>
                </td>
                <td class="p-2">
                    <select name="siswa[${index}][jenis_kelamin]" class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2 focus:ring-brand-500 bulk-jk text-slate-700" required>
                        <option value="">Pilih</option>
                        <option value="L" ${jkVal === 'L' ? 'selected' : ''}>Laki-laki (L)</option>
                        <option value="P" ${jkVal === 'P' ? 'selected' : ''}>Perempuan (P)</option>
                    </select>
                </td>
                <td class="p-2">
                    <input type="text" name="siswa[${index}][kota_lahir]" value="${kotaVal}"
                        class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2.5 focus:ring-brand-500 bulk-kota" placeholder="Opsional">
                </td>
                <td class="p-2">
                    <input type="date" name="siswa[${index}][tanggal_lahir]" value="${tglVal}"
                        class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2 focus:ring-brand-500 bulk-tgl text-slate-700" required>
                </td>
                <td class="p-2">
                    <input type="text" name="siswa[${index}][alamat_lengkap]" value="${alamatVal}"
                        class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2.5 focus:ring-brand-500 bulk-alamat" placeholder="Opsional">
                </td>
                <td class="p-2 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <button type="button" class="p-1 rounded text-amber-600 hover:bg-amber-50 cursor-pointer" onclick="resetSingleBulkRow(this)" title="Reset baris ini">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </button>
                        <button type="button" class="p-1 rounded text-rose-600 hover:bg-rose-50 cursor-pointer" onclick="removeBulkRow(this)" title="Hapus baris">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    function updateBulkDigitCounter(input, counterId, targetLen, isNis = false) {
        const counter = document.getElementById(counterId);
        if (!counter) return;
        const len = input.value.length;
        counter.textContent = len + '/' + targetLen + ' digit';
        if (isNis) {
            counter.className = (len >= 3 && len <= 10) ? 'block text-[10px] font-bold text-emerald-600 mt-0.5' : 'block text-[10px] font-bold text-rose-500 mt-0.5';
        } else {
            counter.className = (len === targetLen) ? 'block text-[10px] font-bold text-emerald-600 mt-0.5' : 'block text-[10px] font-bold text-rose-500 mt-0.5';
        }
    }

    function renumberBulkRows() {
        const rows = document.querySelectorAll('#bulkTableBody .bulk-siswa-row');
        rows.forEach((row, i) => {
            const numCell = row.querySelector('.row-number');
            if (numCell) {
                numCell.childNodes[0].textContent = (i + 1) + ' ';
            }
        });
        const totalSpan = document.getElementById('totalBulkRowsCount');
        if (totalSpan) totalSpan.textContent = rows.length;
    }

    function addBulkRow(data = {}) {
        const tbody = document.getElementById('bulkTableBody');
        if (!tbody) return;
        bulkRowIndex++;
        const trHTML = createBulkRowHTML(bulkRowIndex, data);
        tbody.insertAdjacentHTML('beforeend', trHTML);

        const row = document.getElementById(`bulkRow_${bulkRowIndex}`);
        if (row) {
            const nisInp = row.querySelector('.bulk-nis');
            const nisnInp = row.querySelector('.bulk-nisn');
            if (nisInp) updateBulkDigitCounter(nisInp, `counter_nis_${bulkRowIndex}`, 10, true);
            if (nisnInp) updateBulkDigitCounter(nisnInp, `counter_nisn_${bulkRowIndex}`, 10);
        }
        renumberBulkRows();
    }

    function addMultipleBulkRows(count = 5) {
        for (let i = 0; i < count; i++) {
            addBulkRow();
        }
    }

    function removeBulkRow(btn) {
        const rows = document.querySelectorAll('#bulkTableBody .bulk-siswa-row');
        if (rows.length <= 1) {
            alert('Minimal harus menyisakan 1 baris data siswa.');
            return;
        }
        const tr = btn.closest('tr');
        if (tr) {
            tr.remove();
            renumberBulkRows();
        }
    }

    function resetSingleBulkRow(btn) {
        const tr = btn.closest('tr');
        if (!tr) return;

        const nisInp    = tr.querySelector('.bulk-nis');
        const nisnInp   = tr.querySelector('.bulk-nisn');
        const namaInp   = tr.querySelector('.bulk-nama');
        const jkSel     = tr.querySelector('.bulk-jk');
        const kotaInp   = tr.querySelector('.bulk-kota');
        const tglInp    = tr.querySelector('.bulk-tgl');
        const alamatInp = tr.querySelector('.bulk-alamat');

        if (nisInp)    { nisInp.value = ''; updateBulkDigitCounter(nisInp, nisInp.nextElementSibling?.id, 10, true); }
        if (nisnInp)   { nisnInp.value = ''; updateBulkDigitCounter(nisnInp, nisnInp.nextElementSibling?.id, 10); }
        if (namaInp)   namaInp.value = '';
        if (jkSel)     jkSel.value = '';
        if (kotaInp)   kotaInp.value = '';
        if (tglInp)    tglInp.value = '';
        if (alamatInp) alamatInp.value = '';
    }

    function resetAllBulkFields() {
        const rows = document.querySelectorAll('#bulkTableBody .bulk-siswa-row');
        if (rows.length === 0) {
            alert('Belum ada baris tabel siswa yang dapat di-reset.');
            return;
        }

        if (confirm('Apakah Anda yakin ingin mengosongkan pengisian seluruh baris data siswa?')) {
            rows.forEach(tr => {
                const nisInp    = tr.querySelector('.bulk-nis');
                const nisnInp   = tr.querySelector('.bulk-nisn');
                const namaInp   = tr.querySelector('.bulk-nama');
                const jkSel     = tr.querySelector('.bulk-jk');
                const kotaInp   = tr.querySelector('.bulk-kota');
                const tglInp    = tr.querySelector('.bulk-tgl');
                const alamatInp = tr.querySelector('.bulk-alamat');

                if (nisInp)    { nisInp.value = ''; updateBulkDigitCounter(nisInp, nisInp.nextElementSibling?.id, 10, true); }
                if (nisnInp)   { nisnInp.value = ''; updateBulkDigitCounter(nisnInp, nisnInp.nextElementSibling?.id, 10); }
                if (namaInp)   namaInp.value = '';
                if (jkSel)     jkSel.value = '';
                if (kotaInp)   kotaInp.value = '';
                if (tglInp)    tglInp.value = '';
                if (alamatInp) alamatInp.value = '';
            });
        }
    }

    function clearBulkRows() {
        if (confirm('Apakah Anda yakin ingin menghapus seluruh baris dalam tabel massal?')) {
            const tbody = document.getElementById('bulkTableBody');
            if (tbody) tbody.innerHTML = '';
            bulkRowIndex = 0;
            addMultipleBulkRows(1);
        }
    }

    /* =========================================================
     * 5. BULK DELETE CHECKBOX STATE
     * ========================================================= */
    function updateBulkDeleteState() {
        const checkboxes = document.querySelectorAll('.siswa-select-checkbox');
        const checkedBoxes = document.querySelectorAll('.siswa-select-checkbox:checked');
        const selectAll = document.getElementById('selectAllSiswa');
        const btnBulkDelete = document.getElementById('btnBulkDelete');
        const countSpan = document.getElementById('bulkDeleteCount');

        const count = checkedBoxes.length;
        if (countSpan) countSpan.textContent = count;

        if (selectAll && checkboxes.length > 0) {
            selectAll.checked = (checkboxes.length === count);
        }

        if (btnBulkDelete) {
            if (count > 0) {
                btnBulkDelete.disabled = false;
                btnBulkDelete.classList.remove('opacity-50', 'cursor-not-allowed');
                btnBulkDelete.classList.add('cursor-pointer', 'shadow-sm');
            } else {
                btnBulkDelete.disabled = true;
                btnBulkDelete.classList.add('opacity-50', 'cursor-not-allowed');
                btnBulkDelete.classList.remove('cursor-pointer', 'shadow-sm');
            }
        }
    }

    function confirmBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.siswa-select-checkbox:checked');
        const count = checkedBoxes.length;

        if (count === 0) {
            alert('Silakan pilih minimal 1 data siswa yang ingin dihapus dengan mencentang kotak centang (checkbox).');
            return;
        }

        if (confirm(`Apakah Anda yakin ingin memindahkan ${count} data siswa terpilih ke tempat sampah?`)) {
            document.getElementById('formBulkDelete').submit();
        }
    }

    /* =========================================================
     * 6. FILTER DROPDOWNS & AUTO SELECTION
     * ========================================================= */
    function filterKelasDropdown(tingkat) {
        const selectKelas = document.getElementById('filter_id_kelas');
        if (!selectKelas) return;

        const options = selectKelas.querySelectorAll('option');
        options.forEach(opt => {
            if (!opt.value) {
                opt.style.display = '';
                return;
            }
            const namaKelas = opt.getAttribute('data-nama') || opt.textContent || '';
            if (!tingkat) {
                opt.style.display = '';
            } else if (namaKelas.startsWith(tingkat + ' ') || namaKelas.startsWith(tingkat + '-') || namaKelas.startsWith(tingkat)) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
            }
        });
    }

    function updateSelectMutedState(select) {
        if (!select) return;
        if (select.value && select.value !== '' && select.value !== 'nama_asc') {
            select.classList.add('has-value');
        } else {
            select.classList.remove('has-value');
        }
    }

    function syncTargetKelasToBulk(val) {
        const bulkSelect = document.getElementById('bulk_id_kelas');
        if (bulkSelect && val) {
            bulkSelect.value = val;
        }
    }

    /* =========================================================
     * 7. FILE IMPORT & MULTI-FORMAT PARSER LOGIC
     * ========================================================= */
    function downloadTemplateExcelJS(e) {
        if (e) e.preventDefault();
        if (typeof XLSX !== 'undefined') {
            const data = [
                ['NO', 'NIS (10 DIGIT)', 'NISN (10 DIGIT)', 'NAMA LENGKAP SISWA', 'JENIS KELAMIN', 'KOTA LAHIR', 'TGL LAHIR', 'ALAMAT LENGKAP'],
                [1, '2401000001', '0081234501', 'Ahmad Ridwan', 'L', 'Surabaya', '2008-05-15', 'Jl. Pemuda No. 12, Surabaya'],
                [2, '2401000002', '0081234502', 'Siti Nurhaliza', 'P', 'Sidoarjo', '2008-08-20', 'Jl. Pahlawan No. 45, Sidoarjo'],
                [3, '2401000003', '0081234503', 'Budi Santoso', 'L', 'Gresik', '2008-11-10', 'Jl. Veteran No. 78, Gresik']
            ];
            const ws = XLSX.utils.aoa_to_sheet(data);
            ws['!cols'] = [
                { wch: 6 }, { wch: 18 }, { wch: 18 }, { wch: 30 }, { wch: 15 }, { wch: 20 }, { wch: 18 }, { wch: 40 }
            ];
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Template Siswa Baru");
            XLSX.writeFile(wb, "Template_Tambah_Siswa_Baru.xlsx");
        } else {
            window.location.href = "{{ route('siswa.download-template') }}";
        }
    }

    function resetSingleSiswaForm() {
        const form = document.getElementById('formSiswaIndex');
        if (form) form.reset();

        const nisInp  = document.getElementById('nis');
        const nisnInp = document.getElementById('nisn');
        if (nisInp)  updateDigitCounter(nisInp, 'nisCounter', 10, 'nisMsg', true);
        if (nisnInp) updateDigitCounter(nisnInp, 'nisnCounter', 10, 'nisnMsg');

        const banner = document.getElementById('formErrorReasonBanner');
        if (banner) banner.classList.add('hidden');
    }

    function clearExcelFileInput() {
        const input = document.getElementById('excel_file_input');
        if (input) input.value = '';

        const excelTargetSelect = document.getElementById('excel_target_kelas');
        if (excelTargetSelect) excelTargetSelect.value = '';

        const excelModeSelect = document.getElementById('excel_import_mode');
        if (excelModeSelect) excelModeSelect.value = 'replace';

        const alertDiv = document.getElementById('excelProcessAlert');
        if (alertDiv) alertDiv.classList.add('hidden');

        const hint = document.getElementById('importFileTypeHint');
        if (hint) hint.innerHTML = 'Format: <strong>.pdf, .docx, .doc, .xlsx, .xls, .csv</strong> (Maks: 10MB)';
    }

    function showExcelAlert(type, title, message, details = []) {
        const alertDiv = document.getElementById('excelProcessAlert');
        const alertIcon = document.getElementById('excelAlertIcon');
        const alertTitle = document.getElementById('excelAlertTitle');
        const alertMsg = document.getElementById('excelAlertMsg');
        const alertDetails = document.getElementById('excelAlertDetails');

        if (!alertDiv || !alertTitle || !alertMsg) return;

        alertDiv.classList.remove('hidden', 'bg-teal-50', 'border-teal-200', 'text-teal-900', 'bg-amber-50', 'border-amber-200', 'text-amber-900', 'bg-rose-50', 'border-rose-200', 'text-rose-900');

        if (type === 'success') {
            alertDiv.classList.add('bg-teal-50', 'border-teal-200', 'text-teal-900');
            alertIcon.textContent = 'check_circle';
            alertIcon.className = 'material-symbols-outlined text-teal-600 text-xl shrink-0 mt-0.5';
            alertTitle.className = 'font-bold text-sm text-teal-950';
        } else if (type === 'warning') {
            alertDiv.classList.add('bg-amber-50', 'border-amber-200', 'text-amber-900');
            alertIcon.textContent = 'warning';
            alertIcon.className = 'material-symbols-outlined text-amber-600 text-xl shrink-0 mt-0.5';
            alertTitle.className = 'font-bold text-sm text-amber-950';
        } else {
            alertDiv.classList.add('bg-rose-50', 'border-rose-200', 'text-rose-900');
            alertIcon.textContent = 'error';
            alertIcon.className = 'material-symbols-outlined text-rose-600 text-xl shrink-0 mt-0.5';
            alertTitle.className = 'font-bold text-sm text-rose-950';
        }

        alertTitle.textContent = title;
        alertMsg.innerHTML = message;

        if (details && details.length > 0) {
            alertDetails.innerHTML = '';
            details.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                alertDetails.appendChild(li);
            });
            alertDetails.classList.remove('hidden');
        } else {
            alertDetails.classList.add('hidden');
        }

        alertDiv.classList.remove('hidden');
    }

    function parseExcelDate(raw) {
        if (!raw) return '';

        if (raw instanceof Date && !isNaN(raw)) {
            const yyyy = raw.getFullYear();
            const mm = String(raw.getMonth() + 1).padStart(2, '0');
            const dd = String(raw.getDate()).padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
        }

        if (typeof raw === 'number' || (!isNaN(raw) && !String(raw).includes('-') && !String(raw).includes('/'))) {
            const num = Number(raw);
            if (num > 25000 && num < 60000) {
                const dateObj = new Date((num - (25567 + 2)) * 86400 * 1000);
                const yyyy = dateObj.getFullYear();
                const mm = String(dateObj.getMonth() + 1).padStart(2, '0');
                const dd = String(dateObj.getDate()).padStart(2, '0');
                return `${yyyy}-${mm}-${dd}`;
            }
        }

        const str = String(raw).trim();
        if (/^\d{4}-\d{2}-\d{2}$/.test(str)) {
            return str;
        }

        const dmy = str.match(/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/);
        if (dmy) {
            const dd = dmy[1].padStart(2, '0');
            const mm = dmy[2].padStart(2, '0');
            const yyyy = dmy[3];
            return `${yyyy}-${mm}-${dd}`;
        }

        const ymd = str.match(/^(\d{4})[\/\-](\d{1,2})[\/\-](\d{1,2})$/);
        if (ymd) {
            const yyyy = ymd[1];
            const mm = ymd[2].padStart(2, '0');
            const dd = ymd[3].padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
        }

        return '';
    }

    function onSiswaFileSelected(input) {
        const hint = document.getElementById('importFileTypeHint');
        if (!input || !input.files || input.files.length === 0) return;
        const file = input.files[0];
        const ext = file.name.split('.').pop().toLowerCase();
        const sizeKB = (file.size / 1024).toFixed(1);
        const sizeMB = (file.size / (1024*1024)).toFixed(2);
        let typeLabel = '';
        let typeClass = 'text-slate-600 font-bold';

        if (ext === 'pdf') {
            typeLabel = '📄 PDF Document'; typeClass = 'text-rose-600 font-bold';
        } else if (ext === 'docx' || ext === 'doc') {
            typeLabel = '📝 Microsoft Word'; typeClass = 'text-blue-600 font-bold';
        } else if (ext === 'xlsx' || ext === 'xls') {
            typeLabel = '📊 Microsoft Excel'; typeClass = 'text-emerald-600 font-bold';
        } else if (ext === 'csv') {
            typeLabel = '📋 CSV File'; typeClass = 'text-sky-600 font-bold';
        }

        if (hint) {
            hint.innerHTML = `<span class="${typeClass}">${typeLabel}</span> — Ukuran: <strong>${sizeMB < 1 ? sizeKB + ' KB' : sizeMB + ' MB'}</strong>`;
        }
    }

    function processImportFile() {
        const input = document.getElementById('excel_file_input');
        if (!input || !input.files || input.files.length === 0) {
            showExcelAlert('error', 'Pilih File Terlebih Dahulu!', 'Silakan klik "Pilih File" dan pilih file data siswa (.pdf, .docx, .doc, .xlsx, .xls, .csv).');
            return;
        }

        const file = input.files[0];
        const fileName = file.name;
        const ext = fileName.split('.').pop().toLowerCase();

        const loadingDiv = document.getElementById('importFileLoading');
        const loadingMsg = document.getElementById('importFileLoadingMsg');
        if (loadingDiv) loadingDiv.classList.remove('hidden');
        if (loadingMsg) loadingMsg.textContent = `Sedang membaca file (${fileName})...`;

        if (ext === 'pdf') {
            processPdfSiswaFile(file);
        } else if (ext === 'docx' || ext === 'doc') {
            processWordSiswaFile(file);
        } else if (ext === 'xlsx' || ext === 'xls' || ext === 'csv') {
            processExcelSiswaFile(file);
        } else {
            if (loadingDiv) loadingDiv.classList.add('hidden');
            showExcelAlert('error', 'Format File Tidak Didukung!', 'Gunakan file dengan format .pdf, .docx, .doc, .xlsx, .xls, atau .csv');
        }
    }

    function processExcelFile() {
        processImportFile();
    }

    function processPdfSiswaFile(file) {
        const loadingDiv = document.getElementById('importFileLoading');
        const reader = new FileReader();
        reader.onload = function(e) {
            const typedarray = new Uint8Array(e.target.result);
            if (typeof pdfjsLib === 'undefined') {
                if (loadingDiv) loadingDiv.classList.add('hidden');
                showExcelAlert('error', 'Pustaka PDF.js Belum Siap!', 'Sedang mengunduh pustaka pembaca PDF, silakan coba beberapa detik lagi.');
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

                if (loadingDiv) loadingDiv.classList.add('hidden');
                parseTextLinesToSiswa(fullTextLines, file.name, '📄 PDF Document');
            }).catch(function(err) {
                if (loadingDiv) loadingDiv.classList.add('hidden');
                showExcelAlert('error', 'Gagal Membaca File PDF!', 'File PDF tidak dapat dibaca: ' + err.message);
            });
        };
        reader.readAsArrayBuffer(file);
    }

    function processWordSiswaFile(file) {
        const loadingDiv = document.getElementById('importFileLoading');
        const reader = new FileReader();
        reader.onload = function(e) {
            const arrayBuffer = e.target.result;
            if (typeof mammoth !== 'undefined') {
                mammoth.extractRawText({ arrayBuffer: arrayBuffer }).then(function(result) {
                    if (loadingDiv) loadingDiv.classList.add('hidden');
                    const lines = result.value.split('\n');
                    parseTextLinesToSiswa(lines, file.name, '📝 Microsoft Word');
                }).catch(function() {
                    if (loadingDiv) loadingDiv.classList.add('hidden');
                    const textDecoder = new TextDecoder('utf-8');
                    const text = textDecoder.decode(arrayBuffer);
                    parseTextLinesToSiswa(text.split('\n'), file.name, '📝 Microsoft Word');
                });
            } else {
                if (loadingDiv) loadingDiv.classList.add('hidden');
                const textDecoder = new TextDecoder('utf-8');
                const text = textDecoder.decode(arrayBuffer);
                parseTextLinesToSiswa(text.split('\n'), file.name, '📝 Microsoft Word');
            }
        };
        reader.readAsArrayBuffer(file);
    }

    function processExcelSiswaFile(file) {
        const loadingDiv = document.getElementById('importFileLoading');
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array', cellDates: true });

                if (!workbook.SheetNames || workbook.SheetNames.length === 0) {
                    if (loadingDiv) loadingDiv.classList.add('hidden');
                    showExcelAlert('error', 'File Excel Kosong!', 'File Excel yang Anda pilih tidak memiliki sheet.');
                    return;
                }

                const parsedStudents = [];
                const detectedClassesSet = new Set();
                let totalSheetsRead = 0;

                function cleanStr(s) {
                    return String(s || '').toLowerCase().trim().replace(/[^a-z0-9]/g, '');
                }

                function normalizeClassName(s) {
                    if (!s) return '';
                    let str = String(s).trim();
                    if (str.startsWith(':')) str = str.substring(1).trim();
                    return str;
                }

                function matchClassToDB(rawName) {
                    if (!rawName) return null;
                    const cleanInput = cleanStr(rawName);
                    if (!cleanInput) return null;

                    const normInput = cleanStr(rawName.replace(/\(.*?\)/g, ''));

                    let matched = availableClasses.find(k => {
                        const kClean = cleanStr(k.nama_kelas);
                        return kClean === cleanInput || kClean === normInput;
                    });

                    if (!matched) {
                        matched = availableClasses.find(k => {
                            const kClean = cleanStr(k.nama_kelas);
                            return kClean.includes(normInput) || normInput.includes(kClean);
                        });
                    }
                    return matched ? matched : null;
                }

                workbook.SheetNames.forEach(sheetName => {
                    const worksheet = workbook.Sheets[sheetName];
                    if (!worksheet) return;

                    const rawRowsF = XLSX.utils.sheet_to_json(worksheet, { header: 1, raw: false, defval: '' });
                    const rawRowsR = XLSX.utils.sheet_to_json(worksheet, { header: 1, raw: true, cellDates: true, defval: '' });

                    if (!rawRowsF || rawRowsF.length === 0) return;
                    totalSheetsRead++;

                    let activeClass = null;
                    let colIndices = { nis: -1, nisn: -1, nama_siswa: -1, jenis_kelamin: -1, kota_lahir: -1, tanggal_lahir: -1, alamat_lengkap: -1, kelas: -1 };

                    for (let r = 0; r < rawRowsF.length; r++) {
                        const rowF = rawRowsF[r];
                        const rowR = rawRowsR[r];
                        if (!rowF || !Array.isArray(rowF)) continue;

                        const rowStr = rowF.join(' ');
                        const rowClean = cleanStr(rowStr);

                        // 1. Detect Class Header
                        if (rowClean.includes('kelas')) {
                            for (let c = 0; c < rowF.length; c++) {
                                const cellVal = String(rowF[c] || '').trim();
                                if (cleanStr(cellVal) === 'kelas' || cleanStr(cellVal) === 'kelas:') {
                                    for (let offset = 1; offset <= 5; offset++) {
                                        const targetVal = String(rowF[c + offset] || '').trim();
                                        if (targetVal) {
                                            const normName = normalizeClassName(targetVal);
                                            const matchDB = matchClassToDB(normName);
                                            if (matchDB) {
                                                activeClass = { id_kelas: matchDB.id_kelas, nama_kelas: matchDB.nama_kelas };
                                                detectedClassesSet.add(matchDB.nama_kelas);
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        // 2. Detect Table Sub-Header
                        let tempMap = { nis: -1, nisn: -1, nama_siswa: -1, jenis_kelamin: -1, kota_lahir: -1, tanggal_lahir: -1, alamat_lengkap: -1, kelas: -1 };
                        let foundHeaderColCount = 0;

                        rowF.forEach((cell, colIdx) => {
                            const txt = cleanStr(cell);
                            if (!txt) return;

                            if (txt === 'nisn' || txt.includes('nisn') || txt.includes('nomorinduksiswanasional')) {
                                tempMap.nisn = colIdx; foundHeaderColCount++;
                            } else if (txt === 'nis' || txt === 'niss' || txt.includes('niss') || txt.includes('noinduk') || txt.includes('nomorinduk')) {
                                tempMap.nis = colIdx; foundHeaderColCount++;
                            } else if (txt.includes('nama') || txt.includes('siswa') || txt.includes('student')) {
                                tempMap.nama_siswa = colIdx; foundHeaderColCount++;
                            } else if (txt.includes('jeniskelamin') || txt.includes('jk') || txt === 'sex' || txt === 'gender' || txt.includes('kelamin') || txt === 'lp' || txt === 'l/p') {
                                tempMap.jenis_kelamin = colIdx; foundHeaderColCount++;
                            } else if (txt.includes('kotalahir') || txt.includes('tempatlahir') || txt.includes('pob')) {
                                tempMap.kota_lahir = colIdx;
                            } else if (txt.includes('tanggallahir') || txt.includes('tgllahir') || txt.includes('dob')) {
                                tempMap.tanggal_lahir = colIdx;
                            } else if (txt.includes('alamat') || txt.includes('address')) {
                                tempMap.alamat_lengkap = colIdx;
                            } else if (txt === 'kelas' || txt === 'namakelas') {
                                tempMap.kelas = colIdx;
                            }
                        });

                        if (foundHeaderColCount >= 2) {
                            colIndices = tempMap;
                            continue;
                        }

                        // 3. Skip meta/summary rows
                        if (rowClean.includes('catatan') || rowClean.includes('keterangan') || rowClean.includes('pertemuan') || rowClean.includes('pengajar') || rowClean.includes('matapelajaran') || rowClean.includes('materipokok') || rowClean.includes('kompetensidasar')) {
                            continue;
                        }

                        let nisRaw    = colIndices.nis !== -1 ? (rowF[colIndices.nis] || rowR?.[colIndices.nis] || '') : '';
                        let nisnRaw   = colIndices.nisn !== -1 ? (rowF[colIndices.nisn] || rowR?.[colIndices.nisn] || '') : '';
                        let namaRaw   = colIndices.nama_siswa !== -1 ? String(rowF[colIndices.nama_siswa] || rowR?.[colIndices.nama_siswa] || '').trim() : '';
                        let jkRaw     = colIndices.jenis_kelamin !== -1 ? String(rowF[colIndices.jenis_kelamin] || rowR?.[colIndices.jenis_kelamin] || '').trim() : '';
                        let kotaRaw   = colIndices.kota_lahir !== -1 ? String(rowF[colIndices.kota_lahir] || rowR?.[colIndices.kota_lahir] || '').trim() : '';
                        let tglRaw    = colIndices.tanggal_lahir !== -1 ? (rowR?.[colIndices.tanggal_lahir] || rowF[colIndices.tanggal_lahir] || '') : '';
                        let alamatRaw = colIndices.alamat_lengkap !== -1 ? String(rowF[colIndices.alamat_lengkap] || rowR?.[colIndices.alamat_lengkap] || '').trim() : '';
                        let kelasRaw  = colIndices.kelas !== -1 ? String(rowF[colIndices.kelas] || rowR?.[colIndices.kelas] || '').trim() : '';

                        if (!namaRaw && rowF[2] && typeof rowF[2] === 'string' && !rowF[2].includes(':')) {
                            namaRaw = String(rowF[2]).trim();
                        }
                        if (!nisnRaw && rowF[1]) {
                            nisnRaw = String(rowF[1]).trim();
                        }
                        if (!jkRaw && rowF[8]) {
                            jkRaw = String(rowF[8]).trim();
                        }

                        if (!namaRaw || namaRaw.length < 2 || namaRaw.startsWith('DAFTAR') || namaRaw.startsWith('TAHUN') || namaRaw.startsWith('Catatan') || namaRaw.startsWith('Laki') || namaRaw.startsWith('Perempuan')) {
                            continue;
                        }

                        let nis  = String(nisRaw).replace(/[^0-9]/g, '');
                        let nisn = String(nisnRaw).replace(/[^0-9]/g, '');

                        if (nisn.length > 0 && nisn.length < 10) {
                            nisn = nisn.padStart(10, '0');
                        } else if (nisn.length > 10) {
                            nisn = nisn.slice(0, 10);
                        }

                        if (nis.length > 10) {
                            nis = nis.slice(0, 10);
                        }

                        if (!nis && nisn) {
                            nis = nisn;
                        } else if (!nisn && nis) {
                            nisn = nis.padStart(10, '0');
                        }

                        if (!nis || nis.length < 3) continue;
                        if (!nisn || nisn.length !== 10) continue;

                        let jkClean = cleanStr(jkRaw);
                        let jenis_kelamin = 'L';
                        if (jkClean.startsWith('p') || jkClean.includes('perem') || jkClean.includes('wanita') || jkClean === 'female' || jkClean === 'f' || jkClean === '2') {
                            jenis_kelamin = 'P';
                        }

                        let rowClassInfo = activeClass;
                        if (kelasRaw) {
                            const rowClassMatch = matchClassToDB(kelasRaw);
                            if (rowClassMatch) {
                                rowClassInfo = { id_kelas: rowClassMatch.id_kelas, nama_kelas: rowClassMatch.nama_kelas };
                                detectedClassesSet.add(rowClassMatch.nama_kelas);
                            }
                        }

                        let tanggal_lahir = parseExcelDate(tglRaw) || '2008-01-01';
                        let kota_lahir = kotaRaw || '-';
                        let alamat_lengkap = alamatRaw || '-';

                        parsedStudents.push({
                            nis: nis,
                            nisn: nisn,
                            nama_siswa: namaRaw,
                            jenis_kelamin: jenis_kelamin,
                            kota_lahir: kota_lahir,
                            tanggal_lahir: tanggal_lahir,
                            alamat_lengkap: alamat_lengkap,
                            id_kelas: rowClassInfo ? rowClassInfo.id_kelas : '',
                            kelas_name: rowClassInfo ? rowClassInfo.nama_kelas : ''
                        });
                    }
                });

                if (loadingDiv) loadingDiv.classList.add('hidden');

                if (parsedStudents.length === 0) {
                    showExcelAlert('error', 'Tidak Ada Data Siswa Valid!', 'File yang Anda unggah tidak mengandung data siswa yang dapat dibaca. Pastikan file berisi kolom NISN, Nama Siswa, dan Jenis Kelamin.');
                    return;
                }

                populateParsedStudents(parsedStudents, file.name, '📊 Microsoft Excel / CSV', detectedClassesSet);
            } catch(err) {
                if (loadingDiv) loadingDiv.classList.add('hidden');
                console.error('Error processing Excel file:', err);
                showExcelAlert('error', 'Gagal Membaca File Excel!', 'Terjadi kesalahan saat membaca file: ' + err.message);
            }
        };
        reader.readAsArrayBuffer(file);
    }

    function parseTextLinesToSiswa(lines, fileName, fileTypeLabel) {
        const parsedStudents = [];
        const detectedClassesSet = new Set();
        let activeClass = null;

        for (let i = 0; i < lines.length; i++) {
            const line = String(lines[i] || '').trim();
            if (!line) continue;

            if (line.toLowerCase().includes('kelas')) {
                const matchDB = availableClasses.find(k => line.toLowerCase().includes(k.nama_kelas.toLowerCase()));
                if (matchDB) {
                    activeClass = { id_kelas: matchDB.id_kelas, nama_kelas: matchDB.nama_kelas };
                    detectedClassesSet.add(matchDB.nama_kelas);
                }
            }

            const nisnMatch = line.match(/\b\d{10}\b/);
            if (nisnMatch) {
                const nisn = nisnMatch[0];
                let nama = line.replace(nisn, '').replace(/\b(L|P)\b/i, '').replace(/\b\d{1,5}\b/g, '').replace(/[^a-zA-Z\s\.\,\']/g, '').trim();
                
                if (nama.length >= 3) {
                    let jk = 'L';
                    if (/\b(P|Perempuan)\b/i.test(line)) jk = 'P';

                    let nisMatch = line.match(/\b\d{3,9}\b/);
                    let nis = nisMatch ? nisMatch[0] : nisn;

                    parsedStudents.push({
                        nis: nis,
                        nisn: nisn,
                        nama_siswa: nama,
                        jenis_kelamin: jk,
                        kota_lahir: '-',
                        tanggal_lahir: '2008-01-01',
                        alamat_lengkap: '-',
                        id_kelas: activeClass ? activeClass.id_kelas : '',
                        kelas_name: activeClass ? activeClass.nama_kelas : ''
                    });
                }
            }
        }

        if (parsedStudents.length === 0) {
            showExcelAlert('error', 'Tidak Ada Data Siswa Valid!', `File ${fileTypeLabel} (${fileName}) tidak mengandung NISN 10 digit dan Nama Siswa yang dapat diekstrak.`);
            return;
        }

        populateParsedStudents(parsedStudents, fileName, fileTypeLabel, detectedClassesSet);
    }

    function populateParsedStudents(parsedStudents, fileName, fileTypeLabel, detectedClassesSet = new Set()) {
        const mode = document.getElementById('excel_import_mode').value;
        const tbody = document.getElementById('bulkTableBody');

        let existingRows = tbody.querySelectorAll('.bulk-siswa-row');
        let isAllExistingEmpty = true;
        existingRows.forEach(tr => {
            const nisVal  = tr.querySelector('.bulk-nis')?.value.trim();
            const nisnVal = tr.querySelector('.bulk-nisn')?.value.trim();
            const namaVal = tr.querySelector('.bulk-nama')?.value.trim();
            if (nisVal || nisnVal || namaVal) {
                isAllExistingEmpty = false;
            }
        });

        if (mode === 'replace' || isAllExistingEmpty) {
            tbody.innerHTML = '';
            bulkRowIndex = 0;
        }

        parsedStudents.forEach(st => {
            addBulkRow(st);
        });

        const selectedTargetKelas = document.getElementById('excel_target_kelas').value;
        const detectedClassesArr = Array.from(detectedClassesSet);

        if (selectedTargetKelas) {
            const bulkKelasSelect = document.getElementById('bulk_id_kelas');
            if (bulkKelasSelect) bulkKelasSelect.value = selectedTargetKelas;
        } else if (detectedClassesArr.length === 1) {
            const matchedKls = availableClasses.find(k => k.nama_kelas === detectedClassesArr[0]);
            if (matchedKls) {
                const bulkKelasSelect = document.getElementById('bulk_id_kelas');
                if (bulkKelasSelect) bulkKelasSelect.value = matchedKls.id_kelas;
                const excelTargetSelect = document.getElementById('excel_target_kelas');
                if (excelTargetSelect) excelTargetSelect.value = matchedKls.id_kelas;
            }
        }

        let modeLabel = (mode === 'replace' || isAllExistingEmpty) 
            ? 'Menggantikan/Menimpa isi tabel' 
            : 'Menambahkan ke akhir baris tabel yang ada';

        let classesSummary = detectedClassesArr.length > 0
            ? `Terdeteksi <strong>${detectedClassesArr.length} kelas</strong> (${detectedClassesArr.slice(0, 5).join(', ')}${detectedClassesArr.length > 5 ? '...' : ''})`
            : 'Kelas disesuaikan secara otomatis';

        const msg = `Berhasil membaca <strong>${parsedStudents.length} data siswa</strong> dari file <strong>${fileTypeLabel}</strong> (<em>${fileName}</em>) dan memasukkannya ke tabel pengisian massal.<br>`
                  + `<span class="block mt-1.5 text-xs text-slate-500">`
                  + `<strong>Summary:</strong> ${classesSummary} | <strong>Mode:</strong> ${modeLabel}`
                  + `</span>`;

        showExcelAlert('success', `Proses File ${fileTypeLabel} Berhasil!`, msg);

        // Switch to Bulk tab so user immediately sees imported rows
        switchInputTab('massal');
        const formBulk = document.getElementById('formSiswaBulk');
        if (formBulk) {
            formBulk.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

<<<<<<< HEAD
    /* Real-time Siswa Toggle Handler */
    let siswaToastTimeout = null;

    function showSiswaRealtimeToast(message, isSuccess = true) {
        const toast = document.getElementById('siswaRealtimeToast');
        const icon  = document.getElementById('siswaRealtimeToastIcon');
        const msg   = document.getElementById('siswaRealtimeToastMsg');

        if (!toast || !icon || !msg) return;

        msg.innerHTML = message;
        toast.classList.add('show');

        if (isSuccess) {
            toast.style.background = '#0f172a';
            toast.style.borderLeft = '4px solid #22c55e';
            if (icon) {
                icon.className = 'fa-solid fa-circle-check';
                icon.style.color = '#22c55e';
            }
        } else {
            toast.style.background = '#0f172a';
            toast.style.borderLeft = '4px solid #ef4444';
            if (icon) {
                icon.className = 'fa-solid fa-circle-xmark';
                icon.style.color = '#ef4444';
            }
        }

        if (siswaToastTimeout) clearTimeout(siswaToastTimeout);
        siswaToastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 3500);
    }

    async function handleSiswaToggle(checkbox, siswaId, siswaName) {
        const isChecked = checkbox.checked;
        const label = document.getElementById('status-label-siswa-' + siswaId);
        const originalChecked = !isChecked;

        // Visual feedback immediately
        if (label) {
            label.innerText = isChecked ? 'Aktif' : 'Nonaktif';
            label.className = 'siswa-status-label ' + (isChecked ? 'status-on' : 'status-off');
        }

        checkbox.disabled = true;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]') 
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                : '{{ csrf_token() }}';

            const response = await fetch(`/siswa/${siswaId}/toggle-active`, {
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
                    label.className = 'siswa-status-label ' + (data.is_active ? 'status-on' : 'status-off');
                }
                showSiswaRealtimeToast(data.message || `Data Siswa '${siswaName}' berhasil diubah menjadi ${data.is_active ? 'Aktif (ON)' : 'Nonaktif (OFF)'}.`, true);
            } else {
                checkbox.checked = originalChecked;
                if (label) {
                    label.innerText = originalChecked ? 'Aktif' : 'Nonaktif';
                    label.className = 'siswa-status-label ' + (originalChecked ? 'status-on' : 'status-off');
                }
                showSiswaRealtimeToast(data.message || 'Gagal mengubah status Data Siswa.', false);
            }
        } catch (error) {
            console.error('Error toggling siswa status:', error);
            checkbox.checked = originalChecked;
            if (label) {
                label.innerText = originalChecked ? 'Aktif' : 'Nonaktif';
                label.className = 'siswa-status-label ' + (originalChecked ? 'status-on' : 'status-off');
            }
            showSiswaRealtimeToast('Terjadi kesalahan koneksi saat mengubah status Data Siswa.', false);
        } finally {
            checkbox.disabled = false;
        }
    }
=======
    /* =========================================================
     * 8. DOM INITIALIZATION & VALIDATIONS
     * ========================================================= */
    document.addEventListener("DOMContentLoaded", function() {
        // Select All Checkbox
        const selectAll = document.getElementById('selectAllSiswa');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.siswa-select-checkbox');
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkDeleteState();
            });
        }

        // Single Form Digit Counter Initial Call
        const nis  = document.getElementById('nis');
        const nisn = document.getElementById('nisn');
        if (nis)  updateDigitCounter(nis, 'nisCounter', 10, 'nisMsg', true);
        if (nisn) updateDigitCounter(nisn, 'nisnCounter', 10, 'nisnMsg');

        // Filter Tingkat & Muted State
        const tingkatVal = document.getElementById('filter_tingkat')?.value;
        if (tingkatVal) {
            filterKelasDropdown(tingkatVal);
        }
        document.querySelectorAll('.filter-select-custom').forEach(select => {
            updateSelectMutedState(select);
        });

        // Initialize Bulk Rows from old input or default 3 rows
        const oldSiswaData = @json(old('siswa', []));
        if (Array.isArray(oldSiswaData) && oldSiswaData.length > 0) {
            oldSiswaData.forEach(item => addBulkRow(item));
            // Auto open massal tab if validation error occurred on bulk
            switchInputTab('massal');
        } else {
            addMultipleBulkRows(3);
        }

        // Auto open massal tab if bulk error
        @if($errors->has('siswa') || $errors->has('id_kelas'))
            switchInputTab('massal');
        @endif

        // Sync Target Class
        const bulkSelect = document.getElementById('bulk_id_kelas');
        if (bulkSelect) {
            bulkSelect.addEventListener('change', function() {
                const excelTargetSelect = document.getElementById('excel_target_kelas');
                if (excelTargetSelect && this.value) {
                    excelTargetSelect.value = this.value;
                }
            });
        }

        // Client-side Validation: Single Student Form (Panel 1)
        const form = document.getElementById('formSiswaIndex');
        if (form) {
            form.addEventListener('submit', function(e) {
                const errors = [];
                const nisVal   = document.getElementById('nis').value.trim();
                const nisnVal  = document.getElementById('nisn').value.trim();
                const namaVal  = document.getElementById('nama_siswa').value.trim();
                const jkVal    = document.getElementById('jenis_kelamin').value;
                const klsVal   = document.getElementById('id_kelas').value;
                const tglVal   = document.getElementById('tanggal_lahir').value;

                if (!nisVal) {
                    errors.push('NIS wajib diisi 3 hingga 10 digit angka.');
                } else if (nisVal.length < 3 || nisVal.length > 10) {
                    errors.push('NIS harus berisi 3 hingga 10 digit angka (saat ini baru ' + nisVal.length + ' digit).');
                }

                if (!nisnVal) {
                    errors.push('NISN wajib diisi 10 digit angka.');
                } else if (nisnVal.length !== 10) {
                    errors.push('NISN harus berisi tepat 10 digit angka (saat ini baru ' + nisnVal.length + ' digit).');
                }

                if (!namaVal) {
                    errors.push('Nama Lengkap Siswa wajib diisi.');
                }

                if (!jkVal) {
                    errors.push('Jenis Kelamin wajib dipilih (Laki-laki / Perempuan).');
                }

                if (!klsVal) {
                    errors.push('Kelas bimbingan siswa wajib dipilih.');
                }

                if (!tglVal) {
                    errors.push('Tanggal Lahir wajib diisi.');
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
                    banner.classList.remove('hidden');
                    banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    banner.classList.add('hidden');
                }
            });
        }

        // Client-side Validation: Bulk Students Form (Panel 3)
        const formBulk = document.getElementById('formSiswaBulk');
        if (formBulk) {
            formBulk.addEventListener('submit', function(e) {
                const errors = [];
                const klsVal = document.getElementById('bulk_id_kelas').value;

                const rows = document.querySelectorAll('#bulkTableBody .bulk-siswa-row');
                if (rows.length === 0) {
                    errors.push('Wajib mengisi minimal 1 baris data siswa baru.');
                }

                const nisSet = new Set();
                const nisnSet = new Set();

                rows.forEach((row, i) => {
                    const rowNum = i + 1;
                    const nisVal    = row.querySelector('.bulk-nis').value.trim();
                    const nisnVal   = row.querySelector('.bulk-nisn').value.trim();
                    const namaVal   = row.querySelector('.bulk-nama').value.trim();
                    const jkVal     = row.querySelector('.bulk-jk').value;
                    const rowKlsVal = row.querySelector('.bulk-id-kelas')?.value || klsVal;

                    if (!rowKlsVal && !klsVal) {
                        errors.push(`Baris ke-${rowNum}: Pilihan Kelas Target belum ditentukan.`);
                    }

                    if (!nisVal) {
                        errors.push(`Baris ke-${rowNum}: NIS wajib diisi (3-10 digit angka).`);
                    } else if (nisVal.length < 3 || nisVal.length > 10) {
                        errors.push(`Baris ke-${rowNum}: NIS harus berisi 3 hingga 10 digit angka (saat ini ${nisVal.length} digit).`);
                    } else {
                        if (nisSet.has(nisVal)) {
                            errors.push(`Baris ke-${rowNum}: NIS (${nisVal}) sudah digunakan di baris lain dalam form ini.`);
                        }
                        nisSet.add(nisVal);
                    }

                    if (!nisnVal) {
                        errors.push(`Baris ke-${rowNum}: NISN wajib diisi (10 digit angka).`);
                    } else if (nisnVal.length !== 10) {
                        errors.push(`Baris ke-${rowNum}: NISN harus berisi tepat 10 digit angka (saat ini ${nisnVal.length} digit).`);
                    } else {
                        if (nisnSet.has(nisnVal)) {
                            errors.push(`Baris ke-${rowNum}: NISN (${nisnVal}) sudah digunakan di baris lain dalam form ini.`);
                        }
                        nisnSet.add(nisnVal);
                    }

                    if (!namaVal) {
                        errors.push(`Baris ke-${rowNum}: Nama Lengkap Siswa wajib diisi.`);
                    }

                    if (!jkVal) {
                        errors.push(`Baris ke-${rowNum}: Jenis Kelamin wajib dipilih (Laki-laki / Perempuan).`);
                    }
                });

                const banner = document.getElementById('bulkErrorReasonBanner');
                const list   = document.getElementById('bulkErrorReasonList');

                if (errors.length > 0) {
                    e.preventDefault();
                    list.innerHTML = '';
                    errors.forEach(function(err) {
                        const li = document.createElement('li');
                        li.textContent = err;
                        list.appendChild(li);
                    });
                    banner.classList.remove('hidden');
                    banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    banner.classList.add('hidden');
                }
            });
        }
    });
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
</script>

<!-- Floating Real-time Toast Component -->
<div id="siswaRealtimeToast" class="realtime-toast">
    <i id="siswaRealtimeToastIcon" class="fa-solid fa-circle-check" style="font-size:18px; color:#22c55e;"></i>
    <span id="siswaRealtimeToastMsg">Status data siswa berhasil diperbarui.</span>
</div>

@endsection
