@extends('layouts.admin')

@section('title', 'Master Data Guru — EDU JOURNAL')

@section('styles')
<!-- Tailwind CSS CDN with Forms and Container Queries -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Google Fonts: Plus Jakarta Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#eff6ff',
              100: '#dbeafe',
              500: '#2563eb',
              600: '#1d4ed8',
              700: '#1e40af',
              800: '#1e3a8a',
              900: '#0b1c30',
            },
            surface: '#f4f6fb',
          },
          boxShadow: {
            'elevated': '0 4px 20px -2px rgba(11, 28, 48, 0.05), 0 2px 6px -1px rgba(11, 28, 48, 0.03)',
            'floating': '0 12px 32px -4px rgba(11, 28, 48, 0.08), 0 4px 12px -2px rgba(11, 28, 48, 0.03)',
          }
        }
      }
    }
</script>

<style data-purpose="custom-layout">
    /* Custom clean scrollbars */
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
=======
    ::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
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
        padding: 28px;
        max-width: 440px;
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
</style>
@endsection

@section('topbar_left')
<div class="title-header-wrapper" style="display: flex; flex-direction: column; justify-content: center; min-width: 0; flex: 0 1 auto;">
    <h1 class="page-header-main-title" style="font-size: 17px; font-weight: 700; color: #0f2744; letter-spacing: -0.01em; line-height: 1.2; margin: 0; white-space: nowrap;">
        Master Data <span style="color: #2563eb; font-weight: 800;">Guru</span>
    </h1>
    <p class="page-header-sub-title" style="font-size: 11px; color: #64748b; font-weight: 500; margin: 1px 0 0 0; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 520px;">
        Data Induk Guru &bull; Validasi NIP &bull; Informasi Pengajar &amp; Status Kepegawaian
    </p>
</div>
@endsection

@section('content')

<!-- Flash Messages -->
@if(session('success'))
    <div class="p-3.5 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between text-xs font-semibold shadow-xs">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 cursor-pointer text-base leading-none">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="p-3.5 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 flex items-center justify-between text-xs font-semibold shadow-xs">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-900 cursor-pointer text-base leading-none">&times;</button>
    </div>
@endif

<!-- BEGIN: Tabs & Action Row -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-elevated p-3 sm:p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
    <!-- Left: Tab Buttons Group -->
    <div class="flex flex-wrap items-center gap-2" id="teacher-tabs">
        <!-- Tab 1: Tambah Manual -->
        <button type="button" class="tab-btn px-4 py-2 text-xs rounded-xl active:scale-95 transition-all flex items-center gap-2 bg-white text-slate-700 border border-slate-200 font-semibold cursor-pointer" id="btn-tab-manual" onclick="switchTab('tab-manual')">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>Tambah Manual</span>
        </button>

        <!-- Tab 2: Import File Excel -->
        <button type="button" class="tab-btn px-4 py-2 text-xs rounded-xl hover:bg-slate-50 active:scale-95 transition-all flex items-center gap-2 bg-white text-slate-700 border border-slate-200 font-semibold cursor-pointer" id="btn-tab-import" onclick="switchTab('tab-import')">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>Import File Excel</span>
        </button>

        <!-- Tab 3: Input Cepat & Massal -->
        <button type="button" class="tab-btn px-4 py-2 text-xs rounded-xl hover:bg-slate-50 active:scale-95 transition-all flex items-center gap-2 bg-white text-slate-700 border border-slate-200 font-semibold cursor-pointer" id="btn-tab-massal" onclick="switchTab('tab-massal')">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>Input Cepat &amp; Massal</span>
        </button>
    </div>

    <!-- Right: Lihat Tong Sampah -->
    <div class="flex items-center gap-2">
        <a href="{{ route('guru.trash') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold rounded-xl bg-amber-50 text-amber-800 border border-amber-200/80 hover:bg-amber-100 transition no-underline shadow-xs">
            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>Lihat Tong Sampah</span>
            @if(isset($trashedCount) && $trashedCount > 0)
                <span class="bg-amber-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ml-0.5">{{ $trashedCount }}</span>
            @endif
        </a>
    </div>
</div>
<!-- END: Tabs & Action Row -->

<!-- BEGIN: TAB PANELS CONTAINER (Collapsed by Default, toggled by Tab click) -->

<!-- TAB PANEL 1: Tambah Manual -->
<div class="tab-panel space-y-4 hidden mb-4" id="panel-tab-manual">
    <section class="bg-white rounded-2xl border border-slate-200/80 shadow-elevated p-5 sm:p-6" data-purpose="teacher-form">
        <!-- Form Header -->
        <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-5">
            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-800">Tambah Guru Baru</h2>
                <p class="text-xs text-slate-400">Masukkan detail data guru untuk pendaftaran baru.</p>
            </div>
        </div>

        <!-- Alert Banner Alasan Gagal Simpan (JS Generated) -->
        <div id="formErrorReasonBanner" class="hidden mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start justify-between gap-3 text-xs">
            <div class="flex items-start gap-2.5">
                <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <div>
                    <h4 class="font-bold text-rose-900">Data belum bisa disimpan! Silakan perbaiki pengisian berikut:</h4>
                    <ul id="formErrorReasonList" class="list-disc list-inside mt-1 text-[11px] text-rose-700 space-y-0.5"></ul>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('formErrorReasonBanner').classList.add('hidden')" class="text-rose-500 hover:text-rose-700 cursor-pointer">&times;</button>
        </div>

        <form id="formGuruIndex" action="{{ route('guru.store') }}" method="POST" class="space-y-4" novalidate>
            @csrf

            <!-- Grid Inputs: Row 1 -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- NIP Field -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-xs">
                        <label for="nip" class="font-semibold text-slate-700">NIP (18 Digit) <span class="text-red-500">*</span></label>
                        <span id="nipCounter" class="text-red-500 font-mono text-[11px]">0/18 digit</span>
                    </div>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                        class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 py-2.5 px-3 bg-slate-50/40 focus:bg-white transition @error('nip') border-red-500 @enderror"
                        maxlength="18" minlength="18" inputmode="numeric" placeholder="Contoh: 198501012010011001"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18); updateNipCounter(this, 18, 'nipMsg');" required>
                    <p id="nipMsg" class="text-[11px] text-red-500 font-medium">Wajib diisi tepat 18 digit angka.</p>
                    @error('nip')
                        <p class="text-[11px] text-red-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap Guru -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-xs">
                        <label for="nama_guru" class="font-semibold text-slate-700">Nama Lengkap Guru <span class="text-red-500">*</span></label>
                    </div>
                    <input type="text" id="nama_guru" name="nama_guru" value="{{ old('nama_guru') }}"
                        class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 py-2.5 px-3 bg-slate-50/40 focus:bg-white transition @error('nama_guru') border-red-500 @enderror"
                        placeholder="Masukkan Nama Lengkap" required>
                    @error('nama_guru')
                        <p class="text-[11px] text-red-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin Dropdown -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-xs">
                        <label for="jenis_kelamin" class="font-semibold text-slate-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                    </div>
                    <select id="jenis_kelamin" name="jenis_kelamin"
                        class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 py-2.5 px-3 bg-white text-slate-700 @error('jenis_kelamin') border-red-500 @enderror" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="text-[11px] text-red-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor HP / WA -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-xs">
                        <label for="no_hp" class="font-semibold text-slate-700">Nomor HP / WA <span class="text-red-500">*</span></label>
                    </div>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                        class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 py-2.5 px-3 bg-slate-50/40 focus:bg-white transition @error('no_hp') border-red-500 @enderror"
                        placeholder="Contoh: 081234567890" maxlength="15" minlength="10" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15); updateNoHpCounter(this, 'noHpMsg');" required>
                    <p id="noHpMsg" class="text-[11px] text-red-500 font-medium">Wajib diisi 10 - 15 digit angka.</p>
                    @error('no_hp')
                        <p class="text-[11px] text-red-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mata Pelajaran Utama -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-xs">
                        <label for="id_mapel" class="font-semibold text-slate-700">Mata Pelajaran Utama</label>
                    </div>
                    <select id="id_mapel" name="id_mapel"
                        class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 py-2.5 px-3 bg-white text-slate-700">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ old('id_mapel') == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Form Bottom Actions: Reset on Left, Simpan on Right -->
            <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                <button type="button" onclick="resetSingleGuruForm()" class="px-5 py-2.5 text-xs font-bold rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-900 transition flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Reset Form</span>
                </button>
                <button type="submit" class="px-6 py-2.5 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow-sm flex items-center gap-2 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Simpan Data Guru</span>
                </button>
            </div>
        </form>
    </section>
</div>

<!-- TAB PANEL 2: Import File Excel -->
<div class="tab-panel space-y-4 hidden mb-4" id="panel-tab-import">
    <section class="bg-white rounded-2xl border border-emerald-300 shadow-elevated p-5 sm:p-7" data-purpose="import-file-panel">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-100 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Tambah Guru Baru via Import File (Microsoft Excel)</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Unggah file Microsoft Excel (.xlsx, .xls, atau .csv) berisi daftar data guru baru, lalu klik <strong>Proses File Guru</strong> untuk memasukkan data.</p>
                </div>
            </div>
            <button type="button" onclick="downloadTemplateExcelGuru(event)" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-xs self-start sm:self-auto cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Download Template Excel (.xlsx)</span>
            </button>
        </div>

        <!-- Guidance alert box -->
        <div class="p-4 bg-emerald-50/50 border border-emerald-200 rounded-xl text-xs text-emerald-900 space-y-1 mb-5">
            <div class="flex items-center gap-2 font-bold text-emerald-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                    <path d="M12 16v-4m0-4h.01" stroke-linecap="round" stroke-width="2"></path>
                </svg>
                <span>Petunjuk Penggunaan Fitur Import Excel:</span>
            </div>
            <p class="text-[11px] text-emerald-700 pl-6 leading-relaxed">
                Unduh template file Excel dengan menekan tombol <strong>Download Template Excel (.xlsx)</strong> di atas.<br>
                Isi data guru baru pada file Excel sesuai kolom: <strong>NIP (18 Digit), Nama Lengkap Guru, Jenis Kelamin (L/P), Nomor HP/WA, Mapel Utama</strong>.<br>
                Pilih file Excel yang telah diisi, tentukan <strong>Mapel Utama Target</strong> (opsional) atau biarkan sistem membaca otomatis dari file.<br>
                Pilih <strong>Mode Masukkan Data</strong> (Ganti / Timpa atau Tambahkan), lalu klik <strong>Proses File Excel</strong>.
            </p>
        </div>

        <!-- Feedback Alert Banner Pasca Proses File (JS Generated) -->
        <div id="guruImportAlert" class="hidden mb-4 p-3.5 rounded-xl border text-xs" style="background:#f0fdfa; border-color:#99f6e4; color:#115e59;">
            <div class="flex items-start gap-2.5">
                <div id="guruAlertIcon" class="text-base shrink-0 mt-0.5 font-bold">✓</div>
                <div class="flex-1">
                    <h4 id="guruAlertTitle" class="font-bold"></h4>
                    <p id="guruAlertMsg" class="mt-0.5 leading-relaxed text-[11.5px]"></p>
                </div>
                <button type="button" onclick="document.getElementById('guruImportAlert').classList.add('hidden')" class="cursor-pointer text-base leading-none">&times;</button>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div id="guruImportLoading" class="hidden text-center p-4 bg-teal-50 border border-teal-200 rounded-xl mb-4 text-xs font-semibold text-teal-800">
            <svg class="w-6 h-6 mx-auto animate-spin text-teal-600 mb-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
            <p id="guruImportLoadingMsg">Sedang membaca file data guru...</p>
        </div>

        <!-- Form Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- File Picker -->
            <div class="p-4 bg-white border border-slate-200 rounded-xl space-y-2">
                <label for="guru_file_input" class="block text-xs font-bold text-slate-800">
                    Pilih File Data Guru (Excel / CSV) <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center bg-slate-50 border border-slate-300 rounded-xl px-2 py-1.5 text-xs">
                    <label class="cursor-pointer bg-white hover:bg-slate-100 text-slate-700 font-semibold px-3 py-1 rounded-lg border border-slate-300 text-xs transition">
                        Choose File
                        <input id="guru_file_input" accept=".xlsx,.xls,.csv,.pdf,.doc,.docx" class="hidden" type="file" onchange="onGuruFileSelected(this)">
                    </label>
                    <span id="guruFileNameDisplay" class="ml-2.5 text-slate-400 text-xs truncate">No file chosen</span>
                </div>
                <p id="guruFileTypeHint" class="text-[10px] text-slate-400">Format didukung: .xlsx, .xls, .csv, .pdf, .docx (Ukuran maks: 10MB)</p>
            </div>

            <!-- Mapel Target Field -->
            <div class="p-4 bg-white border border-slate-200 rounded-xl space-y-2">
                <label for="guru_target_mapel" class="block text-xs font-bold text-slate-800">
                    Pilih Mapel Target (Opsional)
                </label>
                <select id="guru_target_mapel" class="w-full text-xs rounded-xl border-slate-300 text-slate-700 py-2 px-3 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="">-- Ikuti Pilihan di Tabel File / Otomatis --</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
                <p class="text-[10px] text-slate-400">Jika dipilih, otomatis mengatur Mapel pada seluruh baris yang kosong.</p>
            </div>

            <!-- Mode Masukkan Data -->
            <div class="p-4 bg-white border border-slate-200 rounded-xl space-y-2">
                <label for="guru_import_mode" class="block text-xs font-bold text-slate-800">
                    Mode Masukkan Data
                </label>
                <select id="guru_import_mode" class="w-full text-xs rounded-xl border-slate-300 text-slate-700 py-2 px-3 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="replace" selected>Ganti / Timpa Seluruh Baris Tabel</option>
                    <option value="append">Tambahkan ke Data yang Sudah Ada (Append)</option>
                </select>
                <p class="text-[10px] text-slate-400">Pilih apakah data file menggantikan atau menambahkan baris.</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center mt-5 pt-3 border-t border-slate-100">
            <button type="button" onclick="clearGuruFileInput()" class="px-5 py-2.5 text-xs font-bold rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-900 shadow-xs flex items-center gap-1.5 transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Reset File Excel</span>
            </button>
            <button type="button" onclick="processGuruImportFile()" class="px-6 py-2.5 text-xs font-bold rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm flex items-center gap-2 transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Proses File Excel</span>
            </button>
        </div>
    </section>
</div>

<!-- TAB PANEL 3: Input Cepat & Massal -->
<div class="tab-panel space-y-4 hidden mb-4" id="panel-tab-massal">
    <section class="bg-white rounded-2xl border border-emerald-300 shadow-elevated p-5 sm:p-7" data-purpose="mass-input-panel">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-100 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Tambah Guru Baru Secara Cepat dan Banyak</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Masukkan data banyak guru sekaligus berdasarkan Mapel dalam 1 kali simpan.</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                Input Massal Per Guru
            </span>
        </div>

        @if($errors->has('guru') || $errors->has('guru.*'))
            <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
                <h4 class="font-bold text-rose-900 mb-1">Terdapat Kesalahan Pengisian Data Guru Massal:</h4>
                <ul class="list-disc list-inside space-y-0.5 text-[11px] text-rose-700">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formGuruBulk" action="{{ route('guru.store-batch') }}" method="POST">
            @csrf

            <div class="mb-4 max-w-sm">
                <label for="bulk_target_mapel" class="block text-xs font-bold text-slate-700 mb-1.5">Pilih Mapel Target (Per Guru) *</label>
                <select id="bulk_target_mapel" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="">-- Pilih Mapel Target --</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
                <p class="text-[10px] text-slate-400 mt-1">Seluruh data guru yang diisi di bawah akan dimasukkan langsung ke mapel ini jika belum memilih mapel individual.</p>
            </div>

            <!-- Bulk Spreadsheet Table -->
            <div class="overflow-x-auto border border-slate-200 rounded-xl mb-4">
                <table class="w-full text-left text-xs min-w-[880px]">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="p-3 text-center w-12">NO</th>
                            <th class="p-3 w-48">NIP (18 DIGIT) *</th>
                            <th class="p-3 w-60">NAMA LENGKAP GURU *</th>
                            <th class="p-3 w-36">JENIS KELAMIN *</th>
                            <th class="p-3 w-44">NOMOR HP / WA *</th>
                            <th class="p-3">MAPEL UTAMA *</th>
                            <th class="p-3 text-center w-20">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="bulkGuruTableBody" class="divide-y divide-slate-100 bg-white">
                        <!-- Dynamic Rows Injected by JS -->
                    </tbody>
                </table>
            </div>

            <!-- Bulk Actions Toolbar -->
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" onclick="addBulkGuruRow()" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Tambah Baris Guru</span>
                    </button>
                    <button type="button" onclick="addBulkGuruRows(5)" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer">
                        <span>+5 Baris</span>
                    </button>
                    <button type="button" onclick="resetAllBulkGuruFields()" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-amber-400 hover:bg-amber-500 text-slate-900 rounded-xl text-xs font-bold transition cursor-pointer">
                        <span>Reset Baris</span>
                    </button>
                    <button type="button" onclick="clearBulkGuruRows()" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 rounded-xl text-xs font-bold transition cursor-pointer">
                        <span>Kosongkan Tabel</span>
                    </button>
                    <span class="text-xs text-slate-400 ml-2">Total: <strong id="bulkGuruRowCount" class="text-slate-700">0</strong> baris guru</span>
                </div>
                <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </section>
</div>
<!-- END TAB PANELS CONTAINER -->

<!-- BEGIN: Master Data Guru Table Container (Matching Master Data Siswa exactly & Screenshot) -->
<section class="bg-white rounded-2xl border border-slate-200/80 shadow-elevated p-5 sm:p-6" data-purpose="teacher-table-section">
    <!-- Table Header Section -->
    <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-5">
        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </div>
        <div>
            <h2 class="text-base font-bold text-slate-800">Daftar Data Guru <span class="text-blue-600 font-bold">({{ count($gurus) }})</span></h2>
            <p class="text-xs text-slate-400">Kelola dan pantau seluruh data guru yang terdaftar dalam sistem.</p>
        </div>
    </div>

    <!-- Search & Filter Toolbar -->
    <form action="{{ route('guru.index') }}" method="GET" class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <!-- Left: Filters Group -->
        <div class="flex flex-wrap items-center gap-2.5 flex-1 min-w-[280px]">
            <!-- Search input with rounded pill icon -->
            <div class="relative flex-1 min-w-[180px] sm:min-w-[220px] max-w-sm">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ $search ?? '' }}" class="w-full text-xs rounded-xl border-slate-200 pl-9 pr-3 py-2 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder:text-slate-400 shadow-2xs" placeholder="Cari Nama / NIP...">
            </div>

            <!-- Subject Filter -->
            <select name="id_mapel" class="text-xs rounded-xl border-slate-200 bg-white py-2 px-3 text-slate-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-2xs">
                <option value="">Semua Mapel</option>
                @foreach($mapelList as $m)
                    <option value="{{ $m->id_mapel }}" {{ (isset($id_mapel) && $id_mapel == $m->id_mapel) ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                @endforeach
            </select>

            <!-- Gender Filter -->
            <select name="jenis_kelamin" class="text-xs rounded-xl border-slate-200 bg-white py-2 px-3 text-slate-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-2xs">
                <option value="">Semua JK</option>
                <option value="L" {{ (isset($jenis_kelamin) && $jenis_kelamin == 'L') ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ (isset($jenis_kelamin) && $jenis_kelamin == 'P') ? 'selected' : '' }}>Perempuan</option>
            </select>

            <!-- Role Filter -->
            <select name="role" class="text-xs rounded-xl border-slate-200 bg-white py-2 px-3 text-slate-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-2xs">
                <option value="">Semua Role</option>
                <option value="guru" {{ (isset($role) && $role == 'guru') ? 'selected' : '' }}>GURU</option>
                <option value="tu" {{ (isset($role) && $role == 'tu') ? 'selected' : '' }}>STAF (TU)</option>
                <option value="piket" {{ (isset($role) && $role == 'piket') ? 'selected' : '' }}>PIKET</option>
                <option value="wali_kelas" {{ (isset($role) && $role == 'wali_kelas') ? 'selected' : '' }}>WALI KELAS</option>
            </select>
        </div>

        <!-- Right: Action Buttons (Reset & Cari grouped together on the right) -->
        <div class="flex items-center gap-2 shrink-0 ml-auto">
            <!-- Reset Button -->
            <a href="{{ route('guru.index') }}" class="bg-amber-400 hover:bg-amber-500 text-slate-900 text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-xs inline-flex items-center justify-center gap-1.5 no-underline whitespace-nowrap">
                <svg class="w-3.5 h-3.5 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Reset</span>
            </a>

            <!-- Cari Button -->
            <button type="submit" class="bg-blue-900 hover:bg-slate-900 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-xs inline-flex items-center justify-center gap-1.5 cursor-pointer whitespace-nowrap">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Cari</span>
            </button>
        </div>
    </form>

    <!-- Contextual Selection & Bulk Action Toolbar (Active only when 1+ checkboxes are checked) -->
    <div id="bulkActionsToolbar" class="hidden mb-3.5 p-2.5 px-4 bg-rose-50 border border-rose-200 rounded-xl items-center justify-between transition-all duration-200 shadow-2xs">
        <div class="flex items-center gap-2 text-xs font-semibold text-rose-900">
            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-rose-200 text-rose-700">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                </svg>
            </span>
            <span>
                <strong id="bulkDeleteCount" class="font-extrabold text-rose-700">0</strong> data dipilih
            </span>
            <span class="text-rose-300 mx-1">|</span>
            <button type="button" onclick="deselectAllGuru()" class="text-[11px] text-rose-600 hover:text-rose-800 underline font-medium cursor-pointer transition">
                Batalkan pilihan
            </button>
        </div>

<<<<<<< HEAD
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
=======
        <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-xs cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>Hapus Terpilih</span>
        </button>
    </div>

    <!-- Data Table Container -->
    <form id="formBulkDelete" action="{{ route('guru.destroy-batch') }}" method="POST">
        @csrf
        @method('DELETE')
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857

        <div class="overflow-x-auto border border-slate-200 rounded-xl">
            <table class="w-full text-left text-xs min-w-[880px]" id="guruMainTable">
                <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="p-3.5 text-center w-10">
                            <input type="checkbox" id="selectAllGuru" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer" title="Pilih Semua (Select All)">
                        </th>
                        <th class="p-3.5">NIP</th>
                        <th class="p-3.5">NAMA GURU / PEGAWAI</th>
                        <th class="p-3.5 text-center">JK</th>
                        <th class="p-3.5 text-center">ROLE</th>
                        <th class="p-3.5">NO HP</th>
                        <th class="p-3.5">MAPEL UTAMA</th>
                        <th class="p-3.5 text-center w-48">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium bg-white" id="guruTableBody">
                    @forelse($gurus as $g)
                        <tr class="hover:bg-blue-50/20 transition guru-data-row">
                            <td class="p-3.5 text-center">
                                <input type="checkbox" name="ids[]" value="{{ $g->id_guru }}" class="guru-select-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer" onchange="updateBulkDeleteState()">
                            </td>
                            <td class="p-3.5 font-bold font-mono text-blue-700 whitespace-nowrap">{{ $g->nip }}</td>
                            <td class="p-3.5 font-bold text-slate-800">{{ $g->nama_guru }}</td>
                            <td class="p-3.5 text-center">
                                @if($g->jenis_kelamin == 'L')
                                    <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">Laki-laki</span>
                                @elseif($g->jenis_kelamin == 'P')
                                    <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-200">Perempuan</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-3.5 text-center">
                                @if(isset($g->user) && $g->user->isAdmin())
                                    <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-800">TU</span>
                                @else
                                    <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-blue-100 text-blue-700">GURU</span>
                                @endif
                            </td>
                            <td class="p-3.5 font-mono text-slate-600 whitespace-nowrap">{{ $g->no_hp ?? '-' }}</td>
                            <td class="p-3.5 font-semibold text-slate-700">{{ $g->mapel->nama_mapel ?? '-' }}</td>
                            <td class="p-3.5">
                                <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                    <!-- 1. LIHAT (Detail) -->
                                    <a href="{{ route('guru.show', $g->id_guru) }}" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition no-underline" title="Lihat Detail Guru">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                        <span>Lihat</span>
                                    </a>

                                    <!-- 2. EDIT -->
                                    <a href="{{ route('guru.edit', $g->id_guru) }}" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold text-amber-800 bg-amber-50 hover:bg-amber-100 rounded-lg transition no-underline" title="Edit Data Guru">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    <!-- 3. HAPUS -->
                                    <button type="button" onclick="if(confirm('Apakah Anda yakin ingin memindahkan {{ addslashes($g->nama_guru) }} ke Tempat Sampah?')) { document.getElementById('singleDeleteForm-{{ $g->id_guru }}').submit(); }" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition cursor-pointer border-none" title="Hapus Guru">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-slate-400">
                                <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                <p class="text-xs font-semibold">Belum ada data Guru &amp; Pegawai yang terdaftar dalam sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    <!-- Hidden Single Delete Forms -->
    @foreach($gurus as $g)
        <form id="singleDeleteForm-{{ $g->id_guru }}" action="{{ route('guru.destroy', $g->id_guru) }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
<<<<<<< HEAD

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
=======
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </form>
    @endforeach

    <!-- Table Pagination Footer matching Stitch & Screenshot -->
    <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500">
        <div>
            <span id="paginationInfoText">Menampilkan <strong class="text-slate-800" id="paginationRangeText">1 sampai {{ min(8, count($gurus)) }}</strong> dari <strong class="text-slate-800">{{ count($gurus) }}</strong> entri guru</span>
        </div>
        <div class="inline-flex items-center gap-1.5" id="paginationControls">
            <!-- Rendered by client-side pagination JS -->
        </div>
    </div>
</section>
<!-- END: Master Data Guru Table Container -->

<!-- Modal Confirm Bulk Delete -->
<div class="modal-bg" id="modalConfirmBulkDelete">
    <div class="modal-box">
        <div class="modal-icon-wrap">
            <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-900 mb-1.5">Konfirmasi Hapus Terpilih</h3>
        <p class="text-xs text-slate-500 mb-5 leading-relaxed">Apakah Anda yakin ingin memindahkan <strong id="modalBulkCountText" class="text-rose-600 font-bold">0 data guru</strong> yang dicentang ke Tempat Sampah?</p>
        <div class="flex items-center gap-2.5">
            <button type="button" onclick="closeBulkDeleteModal()" class="flex-1 py-2 px-3 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="submitBulkDelete()" class="flex-1 py-2 px-3 text-xs font-bold rounded-xl bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition cursor-pointer">
                Ya, Hapus Data
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Library SheetJS, PDF.js, & Mammoth.js untuk Multi-Format File Reader di Sisi Client -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/mammoth@1.6.0/mammoth.browser.min.js"></script>

<script>
    if (typeof pdfjsLib !== 'undefined') {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    }

    const availableMapelList = @json($mapelList);

    /* =========================================================
     * 1. TAB SWITCHING FUNCTIONALITY (Toggleable)
     * ========================================================= */
    function switchTab(tabId) {
        const panels = document.querySelectorAll('.tab-panel');
        const targetPanel = document.getElementById('panel-' + tabId);
        const activeBtn = document.getElementById('btn-' + tabId);
        const isAlreadyOpen = targetPanel && !targetPanel.classList.contains('hidden');

        // Reset all buttons to default white inactive
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(b => {
            b.className = 'tab-btn px-4 py-2 text-xs rounded-xl hover:bg-slate-50 active:scale-95 transition-all flex items-center gap-2 bg-white text-slate-700 border border-slate-200 font-semibold cursor-pointer';
        });

        // Hide all panels
        panels.forEach(p => p.classList.add('hidden'));

        // If it wasn't already open, open it now and set button to active
        if (!isAlreadyOpen && targetPanel) {
            targetPanel.classList.remove('hidden');
            if (activeBtn) {
                activeBtn.className = 'tab-btn px-4 py-2 text-xs rounded-xl active:scale-95 transition-all flex items-center gap-2 bg-blue-600 text-white shadow-sm font-bold border border-blue-600 cursor-pointer';
            }
            targetPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    /* =========================================================
     * 2. SINGLE TEACHER FORM: COUNTERS & RESET
     * ========================================================= */
    function updateNipCounter(input, targetLen = 18, msgId = 'nipMsg') {
        const counter = document.getElementById('nipCounter');
        const msgEle  = document.getElementById(msgId);
        const len     = input.value.length;

        if (counter) {
            counter.textContent = len + '/' + targetLen + ' digit';
            counter.className = (len === targetLen) ? 'text-emerald-600 font-mono text-[11px] font-bold' : 'text-red-500 font-mono text-[11px]';
        }

        if (msgEle) {
            if (len === 0) {
                msgEle.textContent = 'Wajib diisi tepat ' + targetLen + ' digit angka.';
                msgEle.className = 'text-[11px] text-red-500 font-medium';
            } else if (len < targetLen) {
                msgEle.textContent = 'Belum lengkap, baru ' + len + ' digit (kurang ' + (targetLen - len) + ' digit lagi).';
                msgEle.className = 'text-[11px] text-red-500 font-medium';
            } else {
                msgEle.textContent = '✓ Format NIP ' + targetLen + ' digit angka sudah sesuai.';
                msgEle.className = 'text-[11px] text-emerald-600 font-medium';
            }
        }
    }

    function updateNoHpCounter(input, msgId = 'noHpMsg') {
        const msgEle = document.getElementById(msgId);
        const len    = input.value.length;

        if (msgEle) {
            if (len === 0) {
                msgEle.textContent = 'Wajib diisi 10 - 15 digit angka.';
                msgEle.className = 'text-[11px] text-red-500 font-medium';
            } else if (len < 10) {
                msgEle.textContent = 'Belum lengkap, baru ' + len + ' digit (minimal 10 digit angka).';
                msgEle.className = 'text-[11px] text-red-500 font-medium';
            } else {
                msgEle.textContent = '✓ Format Nomor HP / WA ' + len + ' digit angka sudah sesuai.';
                msgEle.className = 'text-[11px] text-emerald-600 font-medium';
            }
        }
    }

    function resetSingleGuruForm() {
        const form = document.getElementById('formGuruIndex');
        if (form) {
            form.reset();
            const nipCounter = document.getElementById('nipCounter');
            if (nipCounter) {
                nipCounter.textContent = '0/18 digit';
                nipCounter.className = 'text-red-500 font-mono text-[11px]';
            }
            const nipMsg = document.getElementById('nipMsg');
            if (nipMsg) {
                nipMsg.textContent = 'Wajib diisi tepat 18 digit angka.';
                nipMsg.className = 'text-[11px] text-red-500 font-medium';
            }
            const noHpMsg = document.getElementById('noHpMsg');
            if (noHpMsg) {
                noHpMsg.textContent = 'Wajib diisi 10 - 15 digit angka.';
                noHpMsg.className = 'text-[11px] text-red-500 font-medium';
            }
            const banner = document.getElementById('formErrorReasonBanner');
            if (banner) banner.classList.add('hidden');
        }
    }

    /* =========================================================
     * 3. BULK GURU ENTRY LOGIC
     * ========================================================= */
    let bulkGuruIndex = 0;

    function addBulkGuruRow(data = {}) {
        const tbody = document.getElementById('bulkGuruTableBody');
        if (!tbody) return;

        const emptyRow = document.getElementById('emptyBulkGuruRow');
        if (emptyRow) emptyRow.remove();

        const tr = document.createElement('tr');
        tr.className = 'bulk-guru-row hover:bg-slate-50/60 transition';

        const nipVal   = data.nip || '';
        const namaVal  = data.nama_guru || '';
        const jkVal    = data.jenis_kelamin || '';
        const noHpVal  = data.no_hp || '';
        const targetDefaultMapel = document.getElementById('bulk_target_mapel')?.value || '';
        const mapelVal = data.id_mapel || targetDefaultMapel;

        let mapelOptionsHtml = `<option value="">-- Pilih Mapel --</option>`;
        availableMapelList.forEach(m => {
            const selected = (String(m.id_mapel) === String(mapelVal)) ? 'selected' : '';
            mapelOptionsHtml += `<option value="${m.id_mapel}" ${selected}>${m.nama_mapel}</option>`;
        });

        tr.innerHTML = `
            <td class="p-3 text-center font-bold text-slate-600 bulk-guru-no">1</td>
            <td class="p-2">
                <input type="text" name="guru[${bulkGuruIndex}][nip]" value="${nipVal}" class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2.5 focus:border-blue-500 font-mono bulk-nip" maxlength="18" minlength="18" inputmode="numeric" placeholder="18 Digit NIP" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,18);" required>
            </td>
            <td class="p-2">
                <input type="text" name="guru[${bulkGuruIndex}][nama_guru]" value="${namaVal}" class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2.5 focus:border-blue-500 bulk-nama" placeholder="Nama Lengkap Guru" required>
            </td>
            <td class="p-2">
                <select name="guru[${bulkGuruIndex}][jenis_kelamin]" class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2 bg-white focus:border-blue-500 bulk-jk text-slate-700" required>
                    <option value="" disabled ${!jkVal ? 'selected' : ''}>-- Pilih --</option>
                    <option value="L" ${jkVal === 'L' ? 'selected' : ''}>Laki-laki</option>
                    <option value="P" ${jkVal === 'P' ? 'selected' : ''}>Perempuan</option>
                </select>
            </td>
            <td class="p-2">
                <input type="text" name="guru[${bulkGuruIndex}][no_hp]" value="${noHpVal}" class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2.5 focus:border-blue-500 font-mono bulk-nohp" placeholder="081234567890" maxlength="15" minlength="10" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,15);" required>
            </td>
            <td class="p-2">
                <select name="guru[${bulkGuruIndex}][id_mapel]" class="w-full text-xs rounded-lg border-slate-200 py-1.5 px-2 bg-white focus:border-blue-500 bulk-mapel text-slate-700">
                    ${mapelOptionsHtml}
                </select>
            </td>
            <td class="p-2 text-center">
                <div class="flex items-center justify-center gap-1">
                    <button type="button" onclick="removeBulkGuruRow(this)" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition cursor-pointer" title="Hapus Baris">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </button>
                    <button type="button" onclick="resetBulkGuruRow(this)" class="p-1.5 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition cursor-pointer" title="Reset Baris">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </button>
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
        const rows = document.querySelectorAll('#bulkGuruTableBody tr.bulk-guru-row');
        if (rows.length <= 1) {
            alert('Minimal harus menyisakan 1 baris data guru.');
            return;
        }
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
        if (confirm('Apakah Anda yakin ingin mengosongkan seluruh baris dalam tabel massal?')) {
            tbody.querySelectorAll('input').forEach(i => i.value = '');
            tbody.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        }
    }

    function clearBulkGuruRows() {
        const tbody = document.getElementById('bulkGuruTableBody');
        if (!tbody) return;
        if (confirm('Apakah Anda yakin ingin menghapus seluruh baris data guru dalam tabel?')) {
            tbody.innerHTML = '';
            bulkGuruIndex = 0;
            updateBulkGuruRowCount();
            addBulkGuruRows(3);
        }
    }

    function updateBulkGuruRowCount() {
        const tbody = document.getElementById('bulkGuruTableBody');
        const counter = document.getElementById('bulkGuruRowCount');
        if (!tbody || !counter) return;

        const count = tbody.querySelectorAll('tr.bulk-guru-row').length;
        counter.textContent = count;

        const rows = tbody.querySelectorAll('tr.bulk-guru-row');
        rows.forEach((r, idx) => {
            const noTd = r.querySelector('.bulk-guru-no');
            if (noTd) noTd.textContent = idx + 1;
        });
    }

    /* =========================================================
     * 4. FILE IMPORT (EXCEL, CSV, PDF, WORD)
     * ========================================================= */
    function clearGuruFileInput() {
        const input = document.getElementById('guru_file_input');
        if (input) input.value = '';
        const nameDisplay = document.getElementById('guruFileNameDisplay');
        if (nameDisplay) {
            nameDisplay.textContent = 'No file chosen';
            nameDisplay.className = 'ml-2.5 text-slate-400 text-xs truncate';
        }
        const alert = document.getElementById('guruImportAlert');
        if (alert) alert.classList.add('hidden');
        const hint = document.getElementById('guruFileTypeHint');
        if (hint) hint.innerHTML = 'Format didukung: .xlsx, .xls, .csv, .pdf, .docx (Ukuran maks: 10MB)';
    }

    function showGuruAlert(type, title, message) {
        const alertDiv = document.getElementById('guruImportAlert');
        const alertIcon = document.getElementById('guruAlertIcon');
        const alertTitle = document.getElementById('guruAlertTitle');
        const alertMsg = document.getElementById('guruAlertMsg');

        if (!alertDiv || !alertTitle || !alertMsg) return;

        if (type === 'success') {
            alertDiv.style.background = '#f0fdfa';
            alertDiv.style.borderColor = '#99f6e4';
            alertDiv.style.color = '#115e59';
            alertIcon.textContent = '✓';
            alertIcon.style.color = '#0d9488';
            alertTitle.style.color = '#0f766e';
        } else {
            alertDiv.style.background = '#fef2f2';
            alertDiv.style.borderColor = '#fca5a5';
            alertDiv.style.color = '#991b1b';
            alertIcon.textContent = '⚠';
            alertIcon.style.color = '#dc2626';
            alertTitle.style.color = '#7f1d1d';
        }

        alertTitle.textContent = title;
        alertMsg.innerHTML = message;
        alertDiv.classList.remove('hidden');
    }

    function onGuruFileSelected(input) {
        const hint = document.getElementById('guruFileTypeHint');
        const nameDisplay = document.getElementById('guruFileNameDisplay');
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

        if (nameDisplay) {
            nameDisplay.textContent = file.name;
            nameDisplay.className = 'ml-2.5 text-slate-700 font-semibold text-xs truncate';
        }

        if (hint) {
            hint.innerHTML = `<span style="color:${typeColor}; font-weight:700;">${typeLabel}</span> — Ukuran: <strong>${sizeMB < 1 ? sizeKB + ' KB' : sizeMB + ' MB'}</strong>`;
        }
    }

    function processGuruImportFile() {
        const input = document.getElementById('guru_file_input');
        if (!input || !input.files || input.files.length === 0) {
            showGuruAlert('error', 'Pilih File Terlebih Dahulu!', 'Silakan klik "Choose File" dan pilih file data guru (.xlsx, .xls, .csv, .pdf, .docx).');
            return;
        }

        const file = input.files[0];
        const fileName = file.name;
        const ext = fileName.split('.').pop().toLowerCase();

        const loadingDiv = document.getElementById('guruImportLoading');
        const loadingMsg = document.getElementById('guruImportLoadingMsg');
        if (loadingDiv) loadingDiv.classList.remove('hidden');
        if (loadingMsg) loadingMsg.textContent = `Sedang membaca file (${fileName})...`;

        if (ext === 'pdf') {
            processPdfGuruFile(file);
        } else if (ext === 'docx' || ext === 'doc') {
            processWordGuruFile(file);
        } else if (ext === 'xlsx' || ext === 'xls' || ext === 'csv') {
            processExcelGuruFile(file);
        } else {
            if (loadingDiv) loadingDiv.classList.add('hidden');
            showGuruAlert('error', 'Format File Tidak Didukung!', 'Gunakan file dengan format .xlsx, .xls, .csv, .pdf, atau .docx');
        }
    }

    function processPdfGuruFile(file) {
        const loadingDiv = document.getElementById('guruImportLoading');
        const reader = new FileReader();
        reader.onload = function(e) {
            const typedarray = new Uint8Array(e.target.result);
            if (typeof pdfjsLib === 'undefined') {
                if (loadingDiv) loadingDiv.classList.add('hidden');
                showGuruAlert('error', 'Pustaka PDF.js Belum Siap!', 'Sedang memuat pustaka PDF, silakan coba sesaat lagi.');
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
                parseTextLinesToGuru(fullTextLines, file.name, '📄 PDF Document');
            }).catch(function(err) {
                if (loadingDiv) loadingDiv.classList.add('hidden');
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
                    if (loadingDiv) loadingDiv.classList.add('hidden');
                    const lines = result.value.split('\n');
                    parseTextLinesToGuru(lines, file.name, '📝 Microsoft Word');
                }).catch(function(err) {
                    if (loadingDiv) loadingDiv.classList.add('hidden');
                    const textDecoder = new TextDecoder('utf-8');
                    const text = textDecoder.decode(arrayBuffer);
                    parseTextLinesToGuru(text.split('\n'), file.name, '📝 Microsoft Word');
                });
            } else {
                if (loadingDiv) loadingDiv.classList.add('hidden');
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
                    if (loadingDiv) loadingDiv.classList.add('hidden');
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

                if (loadingDiv) loadingDiv.classList.add('hidden');

                if (parsedGurus.length === 0) {
                    showGuruAlert('error', 'Tidak Ada Data Guru Valid!', 'File Excel yang Anda unggah tidak mengandung NIP/Nama Guru yang dapat dibaca.');
                    return;
                }

                populateParsedGurus(parsedGurus, file.name, '📊 Microsoft Excel / CSV');
            } catch(err) {
                if (loadingDiv) loadingDiv.classList.add('hidden');
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

        const msg = `Berhasil membaca <strong>${parsedGurus.length} data guru</strong> dari file <strong>${fileTypeLabel}</strong> (<em>${fileName}</em>) dan memasukkannya ke tabel pengisian massal.<br>`
                  + `<span class="block mt-1 text-[11px] text-slate-500"><strong>Mode:</strong> ${modeLabel}</span>`;

        showGuruAlert('success', `Proses File ${fileTypeLabel} Berhasil!`, msg);

        // Switch to Bulk panel so user immediately sees imported rows
        switchTab('tab-massal');
        const formBulk = document.getElementById('formGuruBulk');
        if (formBulk) {
            formBulk.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function downloadTemplateExcelGuru(e) {
        if (e) e.preventDefault();
        if (typeof XLSX === 'undefined') {
            alert('Pustaka SheetJS belum selesai dimuat, silakan coba beberapa saat lagi.');
            return;
        }

        const headers = ["NIP (18 DIGIT)", "NAMA LENGKAP GURU", "JENIS KELAMIN (L/P)", "NOMOR HP / WA", "MAPEL UTAMA"];
        const sampleData = [
            ["198501012010011001", "Budi Santoso, S.Pd", "L", "081234567890", "Matematika"],
            ["199002022015022002", "Siti Rahmawati, M.Pd", "P", "085712345678", "Bahasa Indonesia"]
        ];

        const ws = XLSX.utils.aoa_to_sheet([headers, ...sampleData]);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Template Guru");
        XLSX.writeFile(wb, "template_import_guru.xlsx");
    }

    /* =========================================================
     * 5. BULK DELETE FUNCTIONALITY
     * ========================================================= */
    function updateBulkDeleteState() {
        const checkedBoxes = document.querySelectorAll('.guru-select-checkbox:checked');
        const totalBoxes   = document.querySelectorAll('.guru-select-checkbox');
        const count        = checkedBoxes.length;
        const toolbar      = document.getElementById('bulkActionsToolbar');
        const countSpan    = document.getElementById('bulkDeleteCount');
        const selectAll    = document.getElementById('selectAllGuru');

        if (countSpan) countSpan.textContent = count;

        if (selectAll && totalBoxes.length > 0) {
            selectAll.checked = (checkedBoxes.length === totalBoxes.length);
        }

        if (toolbar) {
            if (count > 0) {
                toolbar.classList.remove('hidden');
                toolbar.classList.add('flex');
            } else {
                toolbar.classList.add('hidden');
                toolbar.classList.remove('flex');
            }
        }
    }

    function deselectAllGuru() {
        const checkboxes = document.querySelectorAll('.guru-select-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        const selectAll = document.getElementById('selectAllGuru');
        if (selectAll) selectAll.checked = false;
        updateBulkDeleteState();
    }

    function confirmBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.guru-select-checkbox:checked');
        const count = checkedBoxes.length;

        if (count === 0) {
            alert('Silakan pilih minimal 1 data guru yang ingin dihapus dengan mencentang kotak centang.');
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

    /* =========================================================
     * 6. CLIENT-SIDE PAGINATION FOR DATA TABLE
     * ========================================================= */
    let currentTablePage = 1;
    const rowsPerPage = 8; // Matching screenshot display count of 8 entries per page

    function setupTablePagination() {
        const allRows = document.querySelectorAll('#guruTableBody tr.guru-data-row');
        const totalRows = allRows.length;
        const paginationControls = document.getElementById('paginationControls');
        const paginationRangeText = document.getElementById('paginationRangeText');

        if (!paginationControls) return;

        if (totalRows === 0) {
            paginationControls.innerHTML = '';
            if (paginationRangeText) paginationRangeText.textContent = '0 dari 0';
            return;
        }

        const totalPages = Math.ceil(totalRows / rowsPerPage);
        if (currentTablePage > totalPages) currentTablePage = totalPages;
        if (currentTablePage < 1) currentTablePage = 1;

        const startIdx = (currentTablePage - 1) * rowsPerPage;
        const endIdx = Math.min(startIdx + rowsPerPage, totalRows);

        allRows.forEach((row, idx) => {
            if (idx >= startIdx && idx < endIdx) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        if (paginationRangeText) {
            paginationRangeText.textContent = `${startIdx + 1} sampai ${endIdx}`;
        }

        // Build pagination button controls
        let paginationHTML = '';

        // Previous button
        if (currentTablePage > 1) {
            paginationHTML += `<button type="button" onclick="goToTablePage(${currentTablePage - 1})" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer">Sebelumnya</button>`;
        } else {
            paginationHTML += `<button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-400 bg-slate-50 cursor-not-allowed" disabled>Sebelumnya</button>`;
        }

        // Page buttons logic with ellipsis
        if (totalPages <= 7) {
            for (let p = 1; p <= totalPages; p++) {
                if (p === currentTablePage) {
                    paginationHTML += `<button type="button" class="px-3 py-1.5 rounded-lg font-bold bg-blue-600 text-white shadow-xs cursor-default">${p}</button>`;
                } else {
                    paginationHTML += `<button type="button" onclick="goToTablePage(${p})" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer">${p}</button>`;
                }
            }
        } else {
            // First page
            if (currentTablePage === 1) {
                paginationHTML += `<button type="button" class="px-3 py-1.5 rounded-lg font-bold bg-blue-600 text-white shadow-xs cursor-default">1</button>`;
            } else {
                paginationHTML += `<button type="button" onclick="goToTablePage(1)" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer">1</button>`;
            }

            if (currentTablePage > 3) {
                paginationHTML += `<span class="px-1 text-slate-400">...</span>`;
            }

            // Middle pages around current
            let startP = Math.max(2, currentTablePage - 1);
            let endP = Math.min(totalPages - 1, currentTablePage + 1);

            for (let p = startP; p <= endP; p++) {
                if (p === currentTablePage) {
                    paginationHTML += `<button type="button" class="px-3 py-1.5 rounded-lg font-bold bg-blue-600 text-white shadow-xs cursor-default">${p}</button>`;
                } else {
                    paginationHTML += `<button type="button" onclick="goToTablePage(${p})" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer">${p}</button>`;
                }
            }

            if (currentTablePage < totalPages - 2) {
                paginationHTML += `<span class="px-1 text-slate-400">...</span>`;
            }

            // Last page
            if (currentTablePage === totalPages) {
                paginationHTML += `<button type="button" class="px-3 py-1.5 rounded-lg font-bold bg-blue-600 text-white shadow-xs cursor-default">${totalPages}</button>`;
            } else {
                paginationHTML += `<button type="button" onclick="goToTablePage(${totalPages})" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer">${totalPages}</button>`;
            }
        }

        // Next button
        if (currentTablePage < totalPages) {
            paginationHTML += `<button type="button" onclick="goToTablePage(${currentTablePage + 1})" class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer">Berikutnya</button>`;
        } else {
            paginationHTML += `<button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-400 bg-slate-50 cursor-not-allowed" disabled>Berikutnya</button>`;
        }

        paginationControls.innerHTML = paginationHTML;
    }

    function goToTablePage(page) {
        currentTablePage = page;
        setupTablePagination();
    }

    /* =========================================================
     * 7. DOM INITIALIZATION
     * ========================================================= */
    document.addEventListener("DOMContentLoaded", function() {
        const nip  = document.getElementById('nip');
        const noHp = document.getElementById('no_hp');
        if (nip)  updateNipCounter(nip, 18, 'nipMsg');
        if (noHp) updateNoHpCounter(noHp, 'noHpMsg');

        // Select All Checkbox
        const selectAll = document.getElementById('selectAllGuru');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.guru-select-checkbox');
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkDeleteState();
            });
        }
        updateBulkDeleteState();

        // Close bulk delete modal on outside click
        const modalBulk = document.getElementById('modalConfirmBulkDelete');
        if (modalBulk) {
            modalBulk.addEventListener('click', function(e) {
                if (e.target === this) closeBulkDeleteModal();
            });
        }

        // Single Form Validation
        const formSingle = document.getElementById('formGuruIndex');
        if (formSingle) {
            formSingle.addEventListener('submit', function(e) {
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
                    banner.classList.remove('hidden');
                    banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    banner.classList.add('hidden');
                }
            });
        }

        // Initialize 3 rows in bulk table
        const tbody = document.getElementById('bulkGuruTableBody');
        if (tbody && tbody.children.length === 0) {
            addBulkGuruRows(3);
        }

        // Initialize client-side pagination for main table
        setupTablePagination();
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
