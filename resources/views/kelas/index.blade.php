@extends('layouts.admin')

@section('title', 'Master Data Kelas — EDU JOURNAL')

@section('styles')
<!-- Tailwind CSS CDN with forms and container queries -->
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
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8',
              800: '#1e40af',
              900: '#1e3a8a',
              950: '#0f2744',
            }
          },
          boxShadow: {
            'card-subtle': '0 2px 10px 0 rgba(15, 23, 42, 0.04)',
            'floating': '0 10px 30px -5px rgba(22, 34, 51, 0.08), 0 4px 12px -2px rgba(22, 34, 51, 0.04)',
          }
        }
      }
    }
</script>

<style data-purpose="custom-scrollbars">
    /* Subtle custom scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #f8fafc;
    }
    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    /* Modal Backdrop & Popup */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    .modal-backdrop-custom.show {
        display: flex;
    }
    .modal-box-custom {
        background: #ffffff;
        border-radius: 1.25rem;
        max-width: 440px;
        width: 100%;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        animation: modalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .modal-box-custom.modal-detail-box {
        max-width: 520px;
    }
    @keyframes modalPop {
        0% { opacity: 0; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }
</style>
@endsection

@section('topbar_left')
<div class="flex items-center">
    <h1 class="page-header-main-title text-base font-extrabold text-slate-900 tracking-tight leading-none m-0 p-0">
        Manajemen Data Kelas
    </h1>
</div>
@endsection

@section('content')

<div class="space-y-6">

    <!-- Flash Notification Messages -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer p-1" title="Tutup Notifikasi">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 cursor-pointer p-1" title="Tutup Notifikasi">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold shadow-2xs" id="errorAlertBox">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-start gap-2.5">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <div>
                        <strong class="font-extrabold text-rose-900 block mb-1">Pengisian data belum sesuai kriteria:</strong>
                        <ul class="list-disc pl-4 space-y-0.5 font-medium text-rose-700">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" onclick="this.closest('#errorAlertBox').remove()" class="text-rose-500 hover:text-rose-700 cursor-pointer p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Client-side Validation Error Banner for Form -->
    <div id="formClientErrorBanner" class="hidden p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold shadow-2xs">
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-start gap-2.5">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <div>
                    <strong class="font-extrabold text-rose-900 block mb-1">Harap periksa isian form:</strong>
                    <ul id="formClientErrorList" class="list-disc pl-4 space-y-0.5 font-medium text-rose-700"></ul>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('formClientErrorBanner').classList.add('hidden')" class="text-rose-500 hover:text-rose-700 cursor-pointer p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </button>
        </div>
    </div>

    <!-- BEGIN: Card 1 - Tambah Kelas Baru -->
    <section class="bg-white rounded-2xl border border-slate-200/80 shadow-card-subtle overflow-hidden" data-purpose="form-tambah-kelas">
        <div class="p-5 sm:p-6 space-y-5">
            <!-- Form Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0121 17.5c-1.897 1.2-4.32 1.5-6 1.5s-4.103-.3-6-1.5a12.083 12.083 0 012.84-6.922L12 14z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-bold text-slate-900">Tambah Kelas Baru</h3>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                Rombel
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Masukkan detail rombongan belajar baru ke dalam sistem.</p>
                    </div>
                </div>
            </div>

            <!-- Form Inputs (3 Columns Grid) -->
            <form id="formTambahKelas" action="{{ route('kelas.store') }}" method="POST" onsubmit="return validateKelasForm(event)" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4.5">
                    <!-- 1. Nama Kelas Input -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5" for="nama_kelas">
                            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M7 7h10M7 11h10M7 15h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                            <span>Nama Kelas <span class="text-rose-500">*</span></span>
                        </label>
                        <input type="text" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas') }}"
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-800 placeholder-slate-400 shadow-2xs transition @error('nama_kelas') border-rose-400 bg-rose-50/50 @enderror"
                            placeholder="Contoh: X RPL 1" maxlength="20" required>
                        @error('nama_kelas')
                            <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2. Jurusan Select Dropdown -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5" for="id_jurusan">
                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                            <span>Jurusan <span class="text-rose-500">*</span></span>
                        </label>
                        <div class="relative">
                            <select id="id_jurusan" name="id_jurusan" onchange="toggleCustomJurusan(this)"
                                class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-800 bg-white shadow-2xs transition cursor-pointer pr-10 @error('id_jurusan') border-rose-400 bg-rose-50/50 @enderror"
                                required>
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($jurusans as $j)
                                    <option value="{{ $j->id_jurusan }}" {{ old('id_jurusan') == $j->id_jurusan ? 'selected' : '' }}>
                                        {{ $j->nama_jurusan }} ({{ $j->kode_jurusan ?? '-' }})
                                    </option>
                                @endforeach
                                <option value="custom" {{ (old('id_jurusan') == 'custom' || old('nama_jurusan_custom')) ? 'selected' : '' }} class="font-bold text-blue-600">
                                    + Ketik Jurusan Baru (Custom)...
                                </option>
                            </select>
                        </div>
                        @error('id_jurusan')
                            <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 3. Kapasitas / Jumlah Siswa -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700 flex items-center gap-1.5" for="jumlah_siswa">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                            <span>Jumlah Siswa (Kapasitas) <span class="text-rose-500">*</span></span>
                        </label>
                        <input type="number" id="jumlah_siswa" name="jumlah_siswa" value="{{ old('jumlah_siswa', 30) }}" min="0" max="60"
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-800 shadow-2xs transition @error('jumlah_siswa') border-rose-400 bg-rose-50/50 @enderror"
                            placeholder="30" required>
                        <p class="text-[11px] text-slate-400">Batas maksimal estimasi daya tampung kelas.</p>
                        @error('jumlah_siswa')
                            <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Custom Jurusan Field (Toggled when "custom" is selected) -->
                <div id="custom_jurusan_wrapper" style="display: {{ (old('id_jurusan') == 'custom' || old('nama_jurusan_custom')) ? 'block' : 'none' }};" class="p-4 rounded-xl bg-gradient-to-r from-blue-50/80 to-indigo-50/50 border border-blue-200/80 space-y-1.5">
                    <label for="nama_jurusan_custom" class="block text-xs font-bold text-blue-900">
                        Nama Jurusan Baru (Custom) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="nama_jurusan_custom" name="nama_jurusan_custom" value="{{ old('nama_jurusan_custom') }}"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-800 bg-white placeholder-slate-400 shadow-2xs transition"
                        placeholder="Contoh: Rekayasa Otomasi Industri">
                    <p class="text-[11px] text-blue-600 font-medium">Jurusan baru ini akan otomatis tersimpan permanen di database dan muncul di daftar pilihan jurusan.</p>
                    @error('nama_jurusan_custom')
                        <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit & Reset Button Row -->
                <div class="flex justify-end pt-3 border-t border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <button type="button" onclick="resetTambahKelasForm()"
                            class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl font-bold text-xs transition cursor-pointer">
                            <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                            <span>Reset</span>
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-bold text-xs shadow-md shadow-blue-600/20 transition-all cursor-pointer">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                            <span>Simpan Data Kelas</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- END: Card 1 -->

    <!-- BEGIN: Card 2 - Table Data Kelas -->
    <section class="bg-white rounded-2xl border border-slate-200/80 shadow-card-subtle overflow-hidden space-y-4" data-purpose="tabel-daftar-kelas">
        <!-- Table Card Header -->
        <div class="p-5 sm:p-6 pb-4 border-b border-slate-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100 mt-0.5">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M14 21v-3a2 2 0 0 0-4 0v3M18 4.933V21m-14-15l7.106-3.79a2 2 0 0 1 1.788 0L20 6M6 11l-3.52 2.147a1 1 0 0 0-.48.854V19a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a1 1 0 0 0-.48-.853L18 11M6 4.933V21" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            <circle cx="12" cy="9" r="2" stroke-width="2"></circle>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-bold text-slate-900">Data Kelas / Rombongan Belajar</h3>
                            <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[10px] font-bold">
                                {{ count($kelases) }} Rombel
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola seluruh daftar kelas, penetapan wali kelas, ruangan, dan jurusan.</p>
                    </div>
                </div>

                <!-- Trash Button on Top Right -->
                <div>
                    <a href="{{ route('kelas.trash') }}" class="inline-flex items-center gap-2 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/80 rounded-xl px-3.5 py-2 text-xs font-bold shadow-xs transition-colors shrink-0 no-underline">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Lihat Sampah Kelas</span>
                        @if(isset($trashedCount) && $trashedCount > 0)
                            <span class="ml-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white">{{ $trashedCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar (Corrected Layout: Wide Search, Jurusan, Ruangan on Left, Grouped Reset & Cari on Right) -->
        <div class="px-5 sm:px-6">
            <form action="{{ route('kelas.index') }}" method="GET" class="flex flex-wrap items-center justify-between gap-3 p-3.5 rounded-xl bg-slate-50/90 border border-slate-200/70">
                <!-- Left: Filter Inputs -->
                <div class="flex flex-wrap items-center gap-2.5 flex-1 min-w-[280px]">
                    <!-- Search Input (Wider with flex-1) -->
                    <div class="relative flex-1 min-w-[200px]">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8" stroke-width="2"></circle>
                                <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-slate-400 text-slate-800 shadow-2xs"
                            placeholder="Cari Kelas / Wali / Ruangan...">
                    </div>

                    <!-- Jurusan Dropdown Filter -->
                    <div class="relative min-w-[140px]">
                        <select name="id_jurusan" class="w-full py-1.5 px-3 text-xs font-medium rounded-xl border border-slate-200 bg-white text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-2xs cursor-pointer">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id_jurusan }}" {{ (isset($id_jurusan) && $id_jurusan == $j->id_jurusan) ? 'selected' : '' }}>
                                    {{ $j->kode_jurusan ?? $j->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ruangan Dropdown Filter -->
                    <div class="relative min-w-[140px]">
                        <select name="id_ruangan" class="w-full py-1.5 px-3 text-xs font-medium rounded-xl border border-slate-200 bg-white text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-2xs cursor-pointer">
                            <option value="">Semua Ruangan</option>
                            @foreach($ruangans as $r)
                                <option value="{{ $r->id_ruangan }}" {{ (isset($id_ruangan) && $id_ruangan == $r->id_ruangan) ? 'selected' : '' }}>
                                    {{ $r->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Right: Action Buttons Grouped (Reset & Cari) -->
                <div class="flex items-center gap-2 shrink-0 ml-auto">
                    <!-- Reset Button -->
                    <a href="{{ route('kelas.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-900 text-xs font-bold transition shadow-xs no-underline whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Reset</span>
                    </a>

                    <!-- Cari Button -->
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-colors shadow-xs cursor-pointer whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" stroke-width="2"></circle>
                            <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Cari</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Contextual Selection & Bulk Action Toolbar (Active only when 1+ checkboxes are checked) -->
        <div class="px-5 sm:px-6">
            <div id="bulkActionsToolbar" class="hidden p-2.5 px-4 bg-rose-50 border border-rose-200 rounded-xl items-center justify-between transition-all duration-200 shadow-2xs">
                <div class="flex items-center gap-2 text-xs font-semibold text-rose-900">
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-rose-200 text-rose-700">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                        </svg>
                    </span>
                    <span>
                        <strong id="bulkDeleteCount" class="font-extrabold text-rose-700">0</strong> kelas dipilih
                    </span>
                    <span class="text-rose-300 mx-1">|</span>
                    <button type="button" onclick="deselectAllKelas()" class="text-[11px] text-rose-600 hover:text-rose-800 underline font-medium cursor-pointer transition">
                        Batalkan pilihan
                    </button>
                </div>

                <button type="button" id="btnBulkDelete" onclick="confirmBulkDelete()" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-xs cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Hapus Terpilih</span>
                </button>
            </div>
        </div>

        <!-- Bulk Delete Form & Main Table -->
        <form id="formBulkDelete" action="{{ route('kelas.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="overflow-x-auto border-t border-slate-100">
                <table class="w-full text-left border-collapse text-xs" id="kelasMainTable">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4 w-10 text-center">
                                <input type="checkbox" id="selectAllKelas" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer h-4 w-4" title="Pilih Semua (Select All)">
                            </th>
                            <th class="py-3.5 px-4">Nama Kelas</th>
                            <th class="py-3.5 px-4">Jurusan</th>
                            <th class="py-3.5 px-4 text-center">Ruangan</th>
                            <th class="py-3.5 px-4">Wali Kelas</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Siswa</th>
                            <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700" id="kelasTableBody">
                        @forelse($kelases as $k)
                            @php
                                $jmlSiswa = $k->jumlah_siswa_real ?? $k->siswas_count ?? $k->jumlah_siswa ?? 0;
                                $isLargeGroup = $jmlSiswa >= 35;
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors kelas-data-row">
                                <td class="py-3.5 px-4 text-center">
                                    <input type="checkbox" name="ids[]" value="{{ $k->id_kelas }}" class="kelas-select-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer h-4 w-4" onchange="updateBulkDeleteState()">
                                </td>
                                <td class="py-3.5 px-4 font-bold text-slate-900 text-sm whitespace-nowrap">
                                    {{ $k->nama_kelas }}
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-600 whitespace-nowrap">
                                    @if($k->jurusan)
                                        <span>{{ $k->jurusan->nama_jurusan }}</span>
                                        @if(!empty($k->jurusan->kode_jurusan))
                                            <span class="text-slate-400 font-mono text-[11px]">({{ $k->jurusan->kode_jurusan }})</span>
                                        @endif
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    @if($k->ruangan)
                                        <span class="inline-flex items-center gap-1 bg-sky-50 text-sky-700 border border-sky-200/80 px-2.5 py-1 rounded-lg text-xs font-semibold">
                                            <svg class="w-3 h-3 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16M2 21h20M9 12h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>{{ $k->ruangan->nama_ruangan }}</span>
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic text-xs">Belum diatur</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($k->waliKelas)
                                        <div class="font-bold text-slate-800 text-[13px]">{{ $k->waliKelas->nama_guru }}</div>
                                        <div class="text-[11px] text-slate-400 tracking-wide font-mono">NIP: {{ $k->waliKelas->nip }}</div>
                                    @else
                                        <span class="text-slate-400 italic text-xs">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 {{ $isLargeGroup ? 'bg-emerald-50 text-emerald-700 border-emerald-200/70' : 'bg-blue-50 text-blue-700 border-blue-200/70' }} border px-2.5 py-1 rounded-full text-xs font-bold">
                                        <svg class="w-3 h-3 {{ $isLargeGroup ? 'text-emerald-600' : 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M16 3.128a4 4 0 0 1 0 7.744M22 21v-2a4 4 0 0 0-3-3.87M9 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                        <span>{{ $jmlSiswa }} Siswa</span>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                        <!-- 1. DETAIL (Modal) -->
                                        <button type="button" 
                                            onclick="openDetailKelasModal(this)"
                                            data-kelas="{{ json_encode([
                                                'id_kelas' => $k->id_kelas,
                                                'nama_kelas' => $k->nama_kelas,
                                                'nama_jurusan' => $k->jurusan->nama_jurusan ?? '-',
                                                'kode_jurusan' => $k->jurusan->kode_jurusan ?? '',
                                                'nama_ruangan' => $k->ruangan->nama_ruangan ?? 'Belum diatur',
                                                'nama_wali' => $k->waliKelas->nama_guru ?? 'Belum ditentukan',
                                                'nip_wali' => $k->waliKelas->nip ?? '-',
                                                'jumlah_siswa' => $k->jumlah_siswa ?? 30,
                                                'siswas_count' => $jmlSiswa,
                                                'url_edit' => route('kelas.edit', $k->id_kelas),
                                                'url_show' => route('kelas.show', $k->id_kelas),
                                            ]) }}"
                                            class="inline-flex items-center gap-1 bg-cyan-50 hover:bg-cyan-100 text-cyan-800 border border-cyan-200/80 px-2.5 py-1 rounded-lg text-xs font-semibold transition-colors cursor-pointer" 
                                            title="Lihat Detail Rombel">
                                            <svg class="w-3 h-3 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                                <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                                            </svg>
                                            <span>Detail</span>
                                        </button>

                                        <!-- 2. EDIT -->
                                        <a href="{{ route('kelas.edit', $k->id_kelas) }}" class="inline-flex items-center gap-1 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/80 px-2.5 py-1 rounded-lg text-xs font-semibold transition-colors no-underline cursor-pointer" title="Edit Data Kelas">
                                            <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>Edit</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12 text-slate-400">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                                    </svg>
                                    <span class="font-medium">Belum ada data Kelas yang terdaftar.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Table Footer / Pagination -->
        <div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div>
                Menampilkan <span class="font-bold text-slate-700" id="paginationRangeText">1 sampai {{ min(count($kelases), 8) }}</span> dari <span class="font-bold text-slate-700">{{ count($kelases) }}</span> Rombongan Belajar
            </div>
            <!-- Pagination Controls (Rendered by JS) -->
            <div class="flex items-center gap-1" id="paginationControls"></div>
        </div>
    </section>
    <!-- END: Card 2 -->

</div>

<!-- Hidden Form for Single Delete -->
<form id="singleKelasDeleteForm" action="" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Confirm Bulk Delete -->
<div class="modal-backdrop-custom" id="modalConfirmBulkDelete">
    <div class="modal-box-custom">
        <div class="p-5 text-center">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </div>
            <h3 class="text-sm font-bold text-slate-900 mb-1">Konfirmasi Hapus Terpilih</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCountText" class="text-rose-600 font-bold">0 data kelas</strong> yang dicentang ke Tempat Sampah?
            </p>
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-center gap-2">
            <button type="button" class="flex-1 py-2 px-3 text-xs font-semibold rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 transition cursor-pointer" onclick="closeBulkDeleteModal()">Batal</button>
            <button type="button" class="flex-1 py-2 px-3 text-xs font-bold rounded-xl bg-rose-600 hover:bg-rose-700 text-white shadow-xs transition cursor-pointer" onclick="submitBulkDelete()">Ya, Hapus Data</button>
        </div>
    </div>
</div>

<!-- Modal Detail Kelas -->
<div class="modal-backdrop-custom" id="modalDetailKelas">
    <div class="modal-box-custom modal-detail-box">
        <!-- Header -->
        <div class="p-5 bg-gradient-to-r from-blue-700 via-indigo-700 to-sky-600 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16M2 21h20M9 12h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold tracking-tight text-white">Detail Rombongan Belajar</h3>
                    <p class="text-[11px] text-blue-100 mt-0.5">Informasi lengkap kelas, wali kelas, ruangan &amp; kapasitas siswa</p>
                </div>
            </div>
            <button type="button" onclick="closeDetailKelasModal()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer" title="Tutup">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-5 space-y-4 max-h-[75vh] overflow-y-auto text-left">
            <!-- Top Headline Card -->
            <div class="flex items-center gap-3.5 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-extrabold text-sm shrink-0 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="text-base font-extrabold text-slate-800 truncate" id="modalDetailNamaKelas">-</h4>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-blue-50 text-blue-700 border border-blue-200 shrink-0" id="modalDetailBadgeJurusan">
                            -
                        </span>
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md" id="modalDetailBadgeSiswa">
                            0 / 30 Siswa
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium">Tahun Ajaran Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Jurusan / Kompetensi -->
                <div class="p-3 rounded-xl bg-slate-50/70 border border-slate-200/60">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jurusan / Kompetensi</span>
                    <span class="text-xs font-bold text-slate-800 block truncate" id="modalDetailJurusan">-</span>
                </div>

                <!-- Ruangan Kelas -->
                <div class="p-3 rounded-xl bg-slate-50/70 border border-slate-200/60">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Ruangan Kelas</span>
                    <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-sky-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16M2 21h20M9 12h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span id="modalDetailRuangan">-</span>
                    </span>
                </div>

                <!-- Wali Kelas -->
                <div class="p-3 rounded-xl bg-slate-50/70 border border-slate-200/60 col-span-1 sm:col-span-2">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Wali Kelas</span>
                            <span class="text-xs font-bold text-slate-800 block" id="modalDetailWaliNama">-</span>
                            <span class="text-[11px] font-mono text-slate-500 block mt-0.5" id="modalDetailWaliNip">NIP: -</span>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Kapasitas & Jumlah Siswa Real -->
                <div class="p-3 rounded-xl bg-slate-50/70 border border-slate-200/60 col-span-1 sm:col-span-2">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kapasitas &amp; Siswa Terdaftar</span>
                    <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                        <span id="modalDetailSiswaStat">-</span>
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Link Navigasi Lengkap ke Halaman Show / Siswa & Jurnal -->
            <a id="modalDetailShowLink" href="#" class="flex items-center justify-between p-3.5 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 hover:border-blue-200 text-blue-900 transition-colors group no-underline">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-blue-900">Buka Halaman Rombel Lengkap</div>
                        <div class="text-[11px] text-blue-600">Lihat daftar seluruh siswa dan riwayat jurnal kelas</div>
                    </div>
                </div>
                <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </a>
        </div>

        <!-- Footer: Hapus (kiri) | Edit & Tutup (kanan) -->
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
            <button type="button" onclick="triggerDeleteFromKelasDetail()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition cursor-pointer" title="Hapus Kelas">
                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Hapus Kelas</span>
            </button>
            <div class="flex items-center gap-2">
                <a id="modalDetailEditBtn" href="#" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl text-xs font-bold text-amber-800 bg-amber-100/80 hover:bg-amber-200 border border-amber-300 transition no-underline" title="Edit Data Kelas">
                    <svg class="w-3.5 h-3.5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Edit Data</span>
                </a>
                <button type="button" onclick="closeDetailKelasModal()" class="px-4 py-1.5 rounded-xl text-xs font-bold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    /* =========================================================
     * 1. FORM TAMBAH KELAS & CUSTOM JURUSAN HELPERS
     * ========================================================= */
    function toggleCustomJurusan(selectEle) {
        const wrapper = document.getElementById('custom_jurusan_wrapper');
        const customInput = document.getElementById('nama_jurusan_custom');
        if (selectEle.value === 'custom') {
            wrapper.style.display = 'block';
            if (customInput) customInput.focus();
        } else {
            wrapper.style.display = 'none';
            if (customInput) customInput.value = '';
        }
    }

    function resetTambahKelasForm() {
        const form = document.getElementById('formTambahKelas');
        if (form) form.reset();
        const wrapper = document.getElementById('custom_jurusan_wrapper');
        if (wrapper) wrapper.style.display = 'none';
        const banner = document.getElementById('formClientErrorBanner');
        if (banner) banner.classList.add('hidden');
    }

    function validateKelasForm(e) {
        const namaKelas = document.getElementById('nama_kelas').value.trim();
        const idJurusan = document.getElementById('id_jurusan').value;
        const namaJurusanCustom = document.getElementById('nama_jurusan_custom') ? document.getElementById('nama_jurusan_custom').value.trim() : '';
        const jumlahSiswa = document.getElementById('jumlah_siswa').value;

        let errors = [];
        if (!namaKelas) {
            errors.push('Nama Kelas wajib diisi dan tidak boleh hanya berupa spasi!');
        } else if (namaKelas.length > 20) {
            errors.push('Nama Kelas maksimal 20 karakter!');
        }

        if (!idJurusan) {
            errors.push('Jurusan wajib dipilih atau diisi!');
        } else if (idJurusan === 'custom' && !namaJurusanCustom) {
            errors.push('Nama Jurusan Baru (Custom) wajib diisi!');
        }

        if (jumlahSiswa === '' || parseInt(jumlahSiswa) < 0) {
            errors.push('Jumlah Siswa (Kapasitas / Estimasi) wajib diisi dan tidak boleh kurang dari 0!');
        }

        const banner = document.getElementById('formClientErrorBanner');
        const list   = document.getElementById('formClientErrorList');

        if (errors.length > 0) {
            e.preventDefault();
            if (list) {
                list.innerHTML = '';
                errors.forEach(err => {
                    const li = document.createElement('li');
                    li.textContent = err;
                    list.appendChild(li);
                });
            }
            if (banner) {
                banner.classList.remove('hidden');
                banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return false;
        }

        if (banner) banner.classList.add('hidden');
        return true;
    }

    /* =========================================================
     * 2. DETAIL MODAL FUNCTIONALITY
     * ========================================================= */
    let currentDetailKelas = null;

    function openDetailKelasModal(btn) {
        const rawData = btn.getAttribute('data-kelas');
        if (!rawData) return;
        try {
            const data = JSON.parse(rawData);
            currentDetailKelas = data;

            const elNamaKelas = document.getElementById('modalDetailNamaKelas');
            const elBadgeJurusan = document.getElementById('modalDetailBadgeJurusan');
            const elBadgeSiswa = document.getElementById('modalDetailBadgeSiswa');
            const elJurusan = document.getElementById('modalDetailJurusan');
            const elRuangan = document.getElementById('modalDetailRuangan');
            const elWaliNama = document.getElementById('modalDetailWaliNama');
            const elWaliNip = document.getElementById('modalDetailWaliNip');
            const elSiswaStat = document.getElementById('modalDetailSiswaStat');
            const elShowLink = document.getElementById('modalDetailShowLink');
            const elEditBtn = document.getElementById('modalDetailEditBtn');

            if (elNamaKelas) elNamaKelas.textContent = data.nama_kelas || '-';
            if (elBadgeJurusan) elBadgeJurusan.textContent = data.nama_jurusan || '-';
            if (elBadgeSiswa) elBadgeSiswa.textContent = `${data.siswas_count || 0} / ${data.jumlah_siswa || 30} Siswa`;
            if (elJurusan) elJurusan.textContent = data.nama_jurusan || '-';
            if (elRuangan) elRuangan.textContent = data.nama_ruangan || 'Belum diatur';
            if (elWaliNama) elWaliNama.textContent = data.nama_wali || 'Belum ditentukan';
            if (elWaliNip) elWaliNip.textContent = (data.nip_wali && data.nip_wali !== '-') ? `NIP: ${data.nip_wali}` : 'NIP: -';
            if (elSiswaStat) elSiswaStat.textContent = `${data.siswas_count || 0} Siswa Terdaftar (Kapasitas: ${data.jumlah_siswa || 30})`;

            if (elShowLink && data.url_show) elShowLink.href = data.url_show;
            if (elEditBtn && data.url_edit) elEditBtn.href = data.url_edit;

            const modal = document.getElementById('modalDetailKelas');
            if (modal) modal.style.display = 'flex';
        } catch (e) {
            console.error('Error parsing data-kelas:', e);
        }
    }

    function closeDetailKelasModal() {
        const modal = document.getElementById('modalDetailKelas');
        if (modal) modal.style.display = 'none';
    }

    function triggerDeleteFromKelasDetail() {
        if (!currentDetailKelas) return;
        const id = currentDetailKelas.id_kelas;
        const nama = currentDetailKelas.nama_kelas;
        closeDetailKelasModal();
        deleteSingleKelas(id, nama);
    }

    /* =========================================================
     * 3. SINGLE DELETE FUNCTIONALITY
     * ========================================================= */
    function deleteSingleKelas(id, nama) {
        if (confirm(`Apakah Anda yakin ingin memindahkan kelas "${nama}" ke Tempat Sampah?`)) {
            const form = document.getElementById('singleKelasDeleteForm');
            form.action = "{{ url('/kelas') }}/" + id;
            form.submit();
        }
    }

    /* =========================================================
     * 4. BULK DELETE CONTEXTUAL TOOLBAR FUNCTIONALITY
     * ========================================================= */
    function updateBulkDeleteState() {
        const checkedBoxes = document.querySelectorAll('.kelas-select-checkbox:checked');
        const totalBoxes   = document.querySelectorAll('.kelas-select-checkbox');
        const count        = checkedBoxes.length;
        const toolbar      = document.getElementById('bulkActionsToolbar');
        const countSpan    = document.getElementById('bulkDeleteCount');
        const selectAll    = document.getElementById('selectAllKelas');

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

    function deselectAllKelas() {
        const checkboxes = document.querySelectorAll('.kelas-select-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        const selectAll = document.getElementById('selectAllKelas');
        if (selectAll) selectAll.checked = false;
        updateBulkDeleteState();
    }

    function confirmBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.kelas-select-checkbox:checked');
        const count = checkedBoxes.length;

        if (count === 0) {
            alert('Silakan pilih minimal 1 data kelas yang ingin dihapus dengan mencentang kotak centang (checkbox).');
            return;
        }

        const modalCountText = document.getElementById('modalBulkCountText');
        if (modalCountText) {
            modalCountText.textContent = count + ' data kelas';
        }

        const modal = document.getElementById('modalConfirmBulkDelete');
        if (modal) {
            modal.classList.add('show');
        } else {
            if (confirm(`Apakah Anda yakin ingin memindahkan ${count} data kelas yang dipilih ke Tempat Sampah?`)) {
                document.getElementById('formBulkDelete').submit();
            }
        }
    }

    function closeBulkDeleteModal() {
        const modal = document.getElementById('modalConfirmBulkDelete');
        if (modal) modal.classList.remove('show');
    }

    function submitBulkDelete() {
        document.getElementById('formBulkDelete').submit();
    }

    /* =========================================================
     * 5. CLIENT-SIDE TABLE PAGINATION
     * ========================================================= */
    let currentTablePage = 1;
    const rowsPerPage = 8;

    function setupTablePagination() {
        const allRows = document.querySelectorAll('#kelasTableBody tr.kelas-data-row');
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

        let paginationHTML = '';
        if (currentTablePage > 1) {
            paginationHTML += `<button type="button" onclick="goToTablePage(${currentTablePage - 1})" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>`;
        } else {
            paginationHTML += `<button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed" disabled><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>`;
        }

        if (totalPages <= 7) {
            for (let p = 1; p <= totalPages; p++) {
                if (p === currentTablePage) {
                    paginationHTML += `<button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600 text-white font-bold text-xs shadow-xs">${p}</button>`;
                } else {
                    paginationHTML += `<button type="button" onclick="goToTablePage(${p})" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 font-semibold text-xs hover:bg-slate-50 transition cursor-pointer">${p}</button>`;
                }
            }
        } else {
            if (currentTablePage === 1) {
                paginationHTML += `<button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600 text-white font-bold text-xs shadow-xs">1</button>`;
            } else {
                paginationHTML += `<button type="button" onclick="goToTablePage(1)" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 font-semibold text-xs hover:bg-slate-50 transition cursor-pointer">1</button>`;
            }

            if (currentTablePage > 3) {
                paginationHTML += `<span class="px-1 text-slate-400">...</span>`;
            }

            let startP = Math.max(2, currentTablePage - 1);
            let endP = Math.min(totalPages - 1, currentTablePage + 1);

            for (let p = startP; p <= endP; p++) {
                if (p === currentTablePage) {
                    paginationHTML += `<button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600 text-white font-bold text-xs shadow-xs">${p}</button>`;
                } else {
                    paginationHTML += `<button type="button" onclick="goToTablePage(${p})" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 font-semibold text-xs hover:bg-slate-50 transition cursor-pointer">${p}</button>`;
                }
            }

            if (currentTablePage < totalPages - 2) {
                paginationHTML += `<span class="px-1 text-slate-400">...</span>`;
            }

            if (currentTablePage === totalPages) {
                paginationHTML += `<button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600 text-white font-bold text-xs shadow-xs">${totalPages}</button>`;
            } else {
                paginationHTML += `<button type="button" onclick="goToTablePage(${totalPages})" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 font-semibold text-xs hover:bg-slate-50 transition cursor-pointer">${totalPages}</button>`;
            }
        }

        if (currentTablePage < totalPages) {
            paginationHTML += `<button type="button" onclick="goToTablePage(${currentTablePage + 1})" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>`;
        } else {
            paginationHTML += `<button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed" disabled><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>`;
        }

        paginationControls.innerHTML = paginationHTML;
    }

    function goToTablePage(page) {
        currentTablePage = page;
        setupTablePagination();
        updateBulkDeleteState();
    }

    /* =========================================================
     * 6. DOM INITIALIZATION
     * ========================================================= */
    document.addEventListener("DOMContentLoaded", function() {
        const selectAll = document.getElementById('selectAllKelas');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.kelas-select-checkbox');
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkDeleteState();
            });
        }
        updateBulkDeleteState();

        const modalBulk = document.getElementById('modalConfirmBulkDelete');
        if (modalBulk) {
            modalBulk.addEventListener('click', function(e) {
                if (e.target === this) closeBulkDeleteModal();
            });
        }

        const modalDetail = document.getElementById('modalDetailKelas');
        if (modalDetail) {
            modalDetail.addEventListener('click', function(e) {
                if (e.target === this) closeDetailKelasModal();
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDetailKelasModal();
                closeBulkDeleteModal();
            }
        });

        setupTablePagination();
    });
</script>
@endsection
