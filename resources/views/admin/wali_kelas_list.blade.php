@extends('layouts.admin')

@section('title', 'Manajemen Data Wali Kelas — EDU JOURNAL')

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
              navy: '#0f2744',
              blue: '#1d4ed8',
              accent: '#2563eb',
              light: '#f1f5f9',
            }
          },
          boxShadow: {
            'elevated': '0 4px 20px -2px rgba(11, 28, 48, 0.05), 0 2px 6px -1px rgba(11, 28, 48, 0.03)',
            'floating': '0 12px 32px -4px rgba(11, 28, 48, 0.08), 0 4px 12px -2px rgba(11, 28, 48, 0.03)',
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
        box-shadow: 0 20px 35px -8px rgba(11, 28, 48, 0.15);
        width: 100%;
        max-width: 28rem;
        overflow: hidden;
        animation: modalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes modalPop {
        from { transform: scale(0.96); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endsection

@section('topbar_left')
<div class="title-header-wrapper" style="display: flex; flex-direction: column; justify-content: center; min-width: 0; flex: 0 1 auto;">
    <h1 class="page-header-main-title" style="font-size: 17px; font-weight: 800; color: #0f2744; letter-spacing: -0.01em; line-height: 1.2; margin: 0; white-space: nowrap;">
        Manajemen Data <span style="color: #2563eb; font-weight: 800;">Wali Kelas</span>
    </h1>
    <p class="page-header-sub-title" style="font-size: 11px; color: #64748b; font-weight: 500; margin: 1px 0 0 0; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 520px;">
        Kelola penugasan dan pemetaan tenaga pendidik sebagai wali kelas per rombel.
    </p>
</div>
@endsection

@section('content')

<!-- Flash Messages -->
@if(session('success'))
    <div class="p-3.5 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between text-xs font-semibold shadow-xs">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="p-3.5 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 flex items-center justify-between text-xs font-semibold shadow-xs">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-900 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
        </button>
    </div>
@endif

@php
    $assignedWaliMap = [];
    foreach($kelases as $kls) {
        if (!empty($kls->wali_kelas)) {
            $assignedWaliMap[$kls->wali_kelas] = $kls->nama_kelas;
            if ($kls->waliKelas && $kls->waliKelas->nama_guru) {
                $assignedWaliMap[strtolower(trim($kls->waliKelas->nama_guru))] = $kls->nama_kelas;
            }
        }
    }
@endphp

<div class="space-y-5">
    <!-- BEGIN: Top Action Navigation Bar (Matching Screenshot) -->
    <div class="w-full rounded-2xl border border-slate-200/80 bg-white shadow-sm p-4 flex flex-wrap items-center justify-between gap-3">
        <!-- Left Tab Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Button 1: Tambah Manual -->
            <button type="button" id="tab-btn-manual" onclick="switchWaliTab('manual')"
                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 text-slate-600 text-xs font-bold border border-slate-200 hover:bg-slate-100 transition-all cursor-pointer">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Tambah Manual</span>
            </button>

            <!-- Button 2: Penugasan Cepat & Banyak (Default Active) -->
            <button type="button" id="tab-btn-massal" onclick="switchWaliTab('massal')"
                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold shadow-xs hover:bg-blue-700 transition-all cursor-pointer">
                <svg class="w-4 h-4 shrink-0 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Penugasan Cepat & Banyak</span>
            </button>
        </div>

        <!-- Right Action: Lihat Tong Sampah -->
        <div>
            <a href="{{ route('admin.wali-kelas.trash') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/80 rounded-xl text-xs font-bold transition-all shadow-2xs no-underline">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span>Lihat Tong Sampah</span>
                @if(isset($trashedCount) && $trashedCount > 0)
                    <span class="ml-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white">{{ $trashedCount }}</span>
                @endif
            </a>
        </div>
    </div>
    <!-- END: Top Action Navigation Bar -->

    <!-- BEGIN: Panel 1 - Tambah Manual Form -->
    <div id="panel-manual" class="hidden transition-all duration-300">
        <section class="rounded-2xl border border-slate-200/80 bg-white shadow-sm p-5 sm:p-6 space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </span>
                        <span>Tambah &amp; Penugasan Wali Kelas Baru</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Pilih tenaga pendidik dari database aktif atau buat profil penugasan wali kelas baru secara mandiri.</p>
                </div>
            </div>

            <!-- Client-side Error Banner -->
            <div id="formErrorReasonBanner" class="hidden p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-semibold shadow-xs">
                <div class="flex items-start gap-2.5">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <div class="flex-1">
                        <h4 class="font-bold text-rose-900 mb-1">Data belum bisa disimpan! Silakan perbaiki pengisian berikut:</h4>
                        <ul id="formErrorReasonList" class="list-disc list-inside space-y-0.5 text-rose-800 text-[11px] font-medium"></ul>
                    </div>
                    <button type="button" onclick="document.getElementById('formErrorReasonBanner').classList.add('hidden')" class="text-rose-600 hover:text-rose-800 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Box Pilihan Guru Terdaftar & Terverifikasi -->
            <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <label class="text-xs font-bold text-blue-700 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Pilih Guru Terdaftar &amp; Terverifikasi</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <span id="guru_match_count" class="text-[11px] font-semibold text-blue-600"></span>
                        <span id="badge_mode_status" class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-200 text-slate-700">
                            Mode Input Manual
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </span>
                        <input type="text" id="search_guru_nip" oninput="filterGuruWaliSelect(this.value)"
                            class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border-slate-200 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-800"
                            placeholder="Cari nama guru atau NIP...">
                    </div>
                    <div>
                        <select id="select_id_guru" name="id_guru" class="w-full py-2 px-3 text-xs rounded-xl border-slate-200 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-800 font-medium">
                            <option value="">-- Pilih Guru untuk Diangkat sebagai Wali Kelas --</option>
                            @foreach($gurus as $g)
                                @php
                                    $namaLower = strtolower(trim($g->nama_guru));
                                    $assignedClassName = $assignedWaliMap[$g->nip] ?? ($assignedWaliMap[$namaLower] ?? null);
                                    $isAssigned = !is_null($assignedClassName);
                                @endphp
                                <option value="{{ $g->id_guru }}"
                                        {{ old('id_guru') == $g->id_guru ? 'selected' : '' }}
                                        {{ $isAssigned ? 'disabled' : '' }}
                                        data-nip="{{ $g->nip }}"
                                        data-nama="{{ $g->nama_guru }}"
                                        data-jk="{{ $g->jenis_kelamin }}"
                                        data-nohp="{{ $g->no_hp }}"
                                        class="{{ $isAssigned ? 'text-slate-400 bg-slate-100 italic' : '' }}">
                                    {{ $g->nama_guru }} (NIP: {{ $g->nip }})
                                    @if($isAssigned)
                                        — [Sudah Menjadi Wali Kelas: {{ $assignedClassName }}]
                                    @elseif($g->jenis_kelamin)
                                        - [{{ $g->jenis_kelamin_teks }}]
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="autofill_lock_notice" class="flex items-start gap-2.5 p-3 rounded-xl bg-blue-50/70 border border-blue-100 text-slate-700 text-xs">
                    <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <p class="text-[11px] text-slate-600 leading-relaxed">
                        <span class="font-bold text-blue-700">Informasi:</span> Memilih guru dari daftar akan otomatis mengisi data NIP, Nama Lengkap, Jenis Kelamin, dan Nomor Telepon di bawah ini. Anda hanya perlu menentukan kelas bimbingan yang sesuai.
                    </p>
                </div>
            </div>

            <!-- Form Single Submit -->
            <form id="formWaliKelas" action="{{ route('admin.wali-kelas.store') }}" method="POST" novalidate>
                @csrf

                <!-- Form Fields Grid (2 Columns) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="space-y-1">
                        <label for="id_kelas" class="block text-xs font-bold text-slate-700">Kelas Bimbingan <span class="text-rose-500">*</span></label>
                        <select id="id_kelas" name="id_kelas" class="w-full text-xs rounded-xl border-slate-200 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-800" required>
                            <option value="">-- Pilih Rombongan Belajar / Kelas --</option>
                            @foreach($kelases as $kls)
                                @php
                                    $hasWali = !empty($kls->wali_kelas);
                                    $namaWaliKelas = $kls->waliKelas->nama_guru ?? ($hasWali ? 'NIP: '.$kls->wali_kelas : null);
                                @endphp
                                <option value="{{ $kls->id_kelas }}"
                                        {{ old('id_kelas') == $kls->id_kelas ? 'selected' : '' }}
                                        {{ $hasWali ? 'disabled' : '' }}
                                        class="{{ $hasWali ? 'text-slate-400 bg-slate-100 italic' : '' }}">
                                    {{ $kls->nama_kelas }}
                                    @if($hasWali)
                                        — [Sudah Ada Wali: {{ $namaWaliKelas }}]
                                    @else
                                        (Belum Ada Wali Kelas)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('id_kelas')
                            <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label for="nip" class="text-xs font-bold text-slate-700">NIP Wali Kelas (18 Digit) <span class="text-rose-500">*</span></label>
                            <span id="nipCounter" class="text-[10px] font-semibold text-rose-500 font-mono">0 / 18 digit</span>
                        </div>
                        <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                            class="w-full text-xs rounded-xl border-slate-200 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-800 font-mono"
                            placeholder="Contoh: 198501012010011001" maxlength="18" minlength="18" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18); updateNipCounter(this, 18, 'nipMsg');" required>
                        <p id="nipMsg" class="text-[10px] font-medium text-rose-500 mt-0.5">Wajib diisi tepat 18 digit angka.</p>
                        @error('nip')
                            <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="name" class="block text-xs font-bold text-slate-700">Nama Lengkap Wali Kelas <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full text-xs rounded-xl border-slate-200 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-800"
                            placeholder="Nama Lengkap Wali Kelas Beserta Gelar" required>
                        @error('name')
                            <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="jenis_kelamin" class="block text-xs font-bold text-slate-700">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="w-full text-xs rounded-xl border-slate-200 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-800">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="no_hp" class="block text-xs font-bold text-slate-700">Nomor HP / WhatsApp <span class="text-rose-500">*</span></label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                            class="w-full text-xs rounded-xl border-slate-200 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-800 font-mono"
                            placeholder="Contoh: 081234567890" maxlength="15" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);">
                        @error('no_hp')
                            <p class="text-[10px] text-rose-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label for="password" class="text-xs font-bold text-slate-700">Password Baru (Opsional)</label>
                            <span class="text-[10px] text-slate-400">Default: 123456</span>
                        </div>
                        <input type="password" id="password" name="password"
                            class="w-full text-xs rounded-xl border-slate-200 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-800 font-mono"
                            placeholder="Kosongkan jika tidak diubah" minlength="6"
                            oninput="checkPasswordMinLength(this, 'passwordMsg');">
                        <p id="passwordMsg" class="text-[10px] font-medium text-slate-400 mt-0.5">Opsional. Default: 123456 (minimal 6 karakter jika diisi).</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-slate-100">
                    <button type="button" onclick="resetWaliKelasForm()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Reset Form</span>
                    </button>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs transition-all shadow-xs cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Simpan &amp; Penugasan Wali Kelas</span>
                    </button>
                </div>
            </form>
        </section>
    </div>
    <!-- END: Panel 1 - Tambah Manual -->

    <!-- BEGIN: Panel 2 - Penugasan Cepat & Banyak (Bulk Assignment - Matching Screenshot) -->
    <div id="panel-massal" class="transition-all duration-300">
        <section class="rounded-2xl border border-slate-200/80 bg-white shadow-sm p-5 sm:p-6 space-y-4">
            <!-- Header section of bulk assignment -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h2 class="text-base font-bold text-slate-900">Penugasan Wali Kelas Baru Secara Cepat dan Banyak</h2>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold">
                                Penugasan Massal (Bulk Assignment)
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Petakan seluruh rombel tahun ajaran aktif sekaligus tanpa perlu membuka formulir per individu.</p>
                    </div>
                </div>
            </div>

            <!-- Real-time Conflict Alert Banner -->
            <div id="bulkConflictAlert" class="hidden p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-semibold shadow-xs">
                <div class="flex items-start gap-2.5">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-rose-900 mb-1">Perhatian: Terjadi Bentrokan Guru Wali Kelas!</h4>
                        <p class="text-rose-800 text-[11px] mb-1 font-medium">Satu guru hanya dapat menjadi Wali Kelas untuk 1 kelas saja. Silakan perbaiki pilihan guru berikut:</p>
                        <ul id="bulkConflictList" class="list-disc list-inside space-y-0.5 text-rose-700 text-[11px] font-bold"></ul>
                    </div>
                </div>
            </div>

            <!-- Filter Controls for Bulk Table -->
            <div class="p-3.5 rounded-xl bg-slate-50/90 border border-slate-200/70 flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-600 font-medium">Jurusan:</span>
                        <select id="bulkFilterJurusan" onchange="filterBulkClassesTable()"
                            class="py-1.5 px-3 text-xs font-medium rounded-xl border-slate-200 bg-white text-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="">Semua Konsentrasi Keahlian</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id_jurusan }}">{{ $j->kode_jurusan ?? $j->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-600 font-medium">Tingkat:</span>
                        <select id="bulkFilterTingkat" onchange="filterBulkClassesTable()"
                            class="py-1.5 px-3 text-xs font-medium rounded-xl border-slate-200 bg-white text-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="">Semua Tingkat</option>
                            <option value="X">Kelas X</option>
                            <option value="XI">Kelas XI</option>
                            <option value="XII">Kelas XII</option>
                        </select>
                    </div>

                    <div class="relative min-w-[200px]">
                        <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </span>
                        <input type="text" id="bulkSearchKelas" oninput="filterBulkClassesTable()"
                            class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border-slate-200 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder:text-slate-400"
                            placeholder="Filter rombel...">
                    </div>
                </div>

                <div class="flex items-center gap-1.5 text-xs font-semibold text-blue-700 bg-blue-50 px-3 py-1 rounded-lg border border-blue-100">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span id="bulkClassCounterBadge">Menampilkan {{ count($kelases) }} Kelas</span>
                </div>
            </div>

            <!-- Bulk Table Form -->
            <form id="formBulkWaliKelas" action="{{ route('admin.wali-kelas.bulk-assign') }}" method="POST" onsubmit="return validateBulkWaliFormSubmission(event)">
                @csrf
                <div class="overflow-x-auto rounded-xl border border-slate-200/80 max-h-[460px] overflow-y-auto">
                    <table class="w-full text-left border-collapse text-xs" id="tableBulkWaliKelas">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 text-[10px] font-bold uppercase tracking-wider sticky top-0 z-10">
                            <tr>
                                <th class="py-3 px-4 w-12 text-center">NO</th>
                                <th class="py-3 px-4">NAMA KELAS / ROMBEL</th>
                                <th class="py-3 px-4">JURUSAN</th>
                                <th class="py-3 px-4">WALI KELAS SAAT INI</th>
                                <th class="py-3 px-4 min-w-[280px]">PILIH GURU PENGGANTI / BARU (TERVERIFIKASI)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($kelases as $idx => $kls)
                                @php
                                    $currentWaliNip  = $kls->wali_kelas;
                                    $currentWaliGuru = $kls->waliKelas;
                                    $tingkatStr = '';
                                    if (preg_match('/^(X|XI|XII)\b/i', trim($kls->nama_kelas), $m)) {
                                        $tingkatStr = strtoupper($m[1]);
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition-colors bulk-class-row"
                                    data-id-kelas="{{ $kls->id_kelas }}"
                                    data-jurusan="{{ $kls->id_jurusan }}"
                                    data-tingkat="{{ $tingkatStr }}"
                                    data-nama="{{ strtolower($kls->nama_kelas) }}">
                                    <td class="py-3 px-4 text-center font-mono text-slate-400 font-medium">{{ $idx + 1 }}</td>
                                    <td class="py-3 px-4 font-bold text-blue-700 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span>{{ $kls->nama_kelas }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-600 whitespace-nowrap">
                                        {{ $kls->jurusan->nama_jurusan ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        @if($currentWaliGuru)
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                                </svg>
                                                <span class="font-semibold text-slate-800">{{ $currentWaliGuru->nama_guru }}</span>
                                            </div>
                                        @elseif($currentWaliNip)
                                            <span class="font-mono font-bold text-blue-600">NIP: {{ $currentWaliNip }}</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-bold border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Belum Ditugaskan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div>
                                            <select name="bulk_assignments[{{ $kls->id_kelas }}]"
                                                class="w-full py-1.5 px-2.5 text-xs rounded-lg border border-slate-200 bg-white focus:border-blue-600 outline-none font-medium bulk-teacher-select"
                                                data-id-kelas="{{ $kls->id_kelas }}"
                                                data-nama-kelas="{{ $kls->nama_kelas }}"
                                                data-original-value="{{ $currentWaliGuru ? $currentWaliGuru->id_guru : '' }}"
                                                onchange="onBulkWaliTeacherChange(this)">
                                                <option value="none">-- Tetap ({{ $currentWaliGuru ? $currentWaliGuru->nama_guru : 'Belum Ditugaskan' }}) --</option>
                                                <option value="" {{ empty($currentWaliNip) ? 'selected' : '' }}>-- Kosongkan / Lepas Wali Kelas --</option>
                                                @foreach($gurus as $g)
                                                    @php
                                                        $isCurrentWali = ($currentWaliNip && $g->nip == $currentWaliNip);
                                                        $namaLower = strtolower(trim($g->nama_guru));
                                                        $assignedClassName = $assignedWaliMap[$g->nip] ?? ($assignedWaliMap[$namaLower] ?? null);
                                                        $isAssignedElsewhere = !is_null($assignedClassName) && !$isCurrentWali;
                                                    @endphp
                                                    <option value="{{ $g->id_guru }}"
                                                            data-nip="{{ $g->nip }}"
                                                            data-nama="{{ $g->nama_guru }}"
                                                            {{ $isCurrentWali ? 'selected' : '' }}
                                                            class="{{ $isAssignedElsewhere ? 'text-slate-400 bg-slate-100' : '' }}">
                                                        {{ $g->nama_guru }} (NIP: {{ $g->nip }})
                                                        @if($isCurrentWali)
                                                            ✓ [Wali Kelas Saat Ini]
                                                        @elseif($isAssignedElsewhere)
                                                            — [Sudah Menjadi Wali: {{ $assignedClassName }}]
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="bulk-field-error hidden text-[10px] font-bold text-rose-500 mt-1"></div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-slate-400">
                                        Belum ada data kelas terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3">
                    <button type="button" onclick="confirmResetBulkWaliForm()"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-colors cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Reset Penugasan Massal</span>
                    </button>
                    <button type="submit" id="btnSubmitBulkWali"
                        class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 transition-all shadow-sm shadow-blue-500/20 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Simpan Perubahan Massal</span>
                    </button>
                </div>
            </form>
        </section>
    </div>
    <!-- END: Panel 2 - Penugasan Cepat & Banyak -->

    <!-- BEGIN: Card 3 - Daftar Pemetaan Wali Kelas Per Rombel (Main Table Matching Screenshot) -->
    <section class="rounded-2xl border border-slate-200/80 bg-white shadow-sm p-5 sm:p-6 space-y-4" data-purpose="tabel-pemetaan-wali-kelas">
        <!-- Table Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-base font-bold text-slate-900">Daftar Pemetaan Wali Kelas Per Rombel</h2>
                        <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[10px] font-bold">
                            {{ count($kelases) }} Rombel
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar lengkap asosiasi wali kelas aktif dengan rombel dan jumlah siswa terdaftar.</p>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar (Reset & Cari grouped on the right) -->
        <form action="{{ route('admin.wali-kelas-list') }}" method="GET" class="flex flex-wrap items-center justify-between gap-3 p-3.5 rounded-xl bg-slate-50/90 border border-slate-200/70">
            <div class="flex flex-wrap items-center gap-2.5 flex-1 min-w-[280px]">
                <!-- Search input -->
                <div class="relative flex-1 min-w-[200px]">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border-slate-200 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder:text-slate-400 text-slate-800"
                        placeholder="Cari nama rombel, guru, atau NIP...">
                </div>

                <!-- Jurusan dropdown -->
                <select name="id_jurusan" class="py-1.5 px-3 text-xs font-medium rounded-xl border-slate-200 bg-white text-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id_jurusan }}" {{ (isset($id_jurusan) && $id_jurusan == $j->id_jurusan) ? 'selected' : '' }}>
                            {{ $j->kode_jurusan ?? $j->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Right: Action Buttons (Reset & Cari grouped together on the right) -->
            <div class="flex items-center gap-2 shrink-0 ml-auto">
                <!-- Reset Button -->
                <a href="{{ route('admin.wali-kelas-list') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-900 text-xs font-bold transition shadow-xs no-underline whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Reset</span>
                </a>

                <!-- Cari Button -->
                <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-colors shadow-xs cursor-pointer whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span>Cari</span>
                </button>
            </div>
        </form>

        <!-- Contextual Selection & Bulk Action Toolbar (Active only when 1+ checkboxes are checked) -->
        <div id="bulkActionsToolbar" class="hidden p-2.5 px-4 bg-rose-50 border border-rose-200 rounded-xl items-center justify-between transition-all duration-200 shadow-2xs">
            <div class="flex items-center gap-2 text-xs font-semibold text-rose-900">
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-rose-200 text-rose-700">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                    </svg>
                </span>
                <span>
                    <strong id="bulkDeleteCount" class="font-extrabold text-rose-700">0</strong> dipilih
                </span>
                <span class="text-rose-300 mx-1">|</span>
                <button type="button" onclick="deselectAllWaliKelas()" class="text-[11px] text-rose-600 hover:text-rose-800 underline font-medium cursor-pointer transition">
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

        <!-- Bulk Delete Form & Main Table -->
        <form id="formBulkDelete" action="{{ route('admin.wali-kelas.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="overflow-x-auto rounded-xl border border-slate-200/80">
                <table class="w-full text-left border-collapse text-xs" id="waliMainTable">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 text-[10px] font-bold uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-3 w-10 text-center">
                                <input type="checkbox" id="selectAllWaliKelas" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer h-4 w-4" title="Pilih Semua (Select All)">
                            </th>
                            <th class="py-3 px-3 w-12 text-center">NO</th>
                            <th class="py-3 px-4">NAMA KELAS / ROMBEL</th>
                            <th class="py-3 px-4">WALI KELAS BIMBINGAN</th>
                            <th class="py-3 px-4">NIP WALI KELAS</th>
                            <th class="py-3 px-4 text-center">JUMLAH SISWA</th>
                            <th class="py-3 px-4 text-center w-28">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700" id="waliTableBody">
                        @forelse($kelases as $index => $k)
                            @php
                                $hasWali = !empty($k->wali_kelas);
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors wali-data-row">
                                <td class="py-3 px-3 text-center">
                                    @if($hasWali)
                                        <input type="checkbox" name="ids[]" value="{{ $k->id_kelas }}" class="wali-select-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer h-4 w-4" onchange="updateBulkDeleteState()">
                                    @else
                                        <input type="checkbox" disabled class="rounded border-slate-200 opacity-40 cursor-not-allowed h-4 w-4" title="Belum Ada Wali Kelas">
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center font-mono text-slate-400 font-medium">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $hasWali ? 'bg-blue-600' : 'bg-amber-400' }}"></span>
                                        <span>{{ $k->nama_kelas }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    @if($k->waliKelas)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <span class="font-bold text-slate-800">{{ $k->waliKelas->nama_guru }}</span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-bold border border-rose-200">
                                            <svg class="w-3 h-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            Belum Ditetapkan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-mono text-slate-600 whitespace-nowrap">
                                    {{ $k->wali_kelas ?? '-' }}
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <a href="{{ route('kelas.show', $k->id_kelas) }}" class="no-underline inline-block">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold hover:bg-emerald-100 transition shadow-2xs">
                                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            {{ $k->siswas_count ?? $k->jumlah_siswa_real }} Siswa
                                        </span>
                                    </a>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-1.5 whitespace-nowrap">
                                        <a href="{{ route('kelas.edit', $k->id_kelas) }}" class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors inline-flex items-center justify-center" title="Edit Rombel">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                        </a>

                                        @if($hasWali)
                                            <button type="button" onclick="deleteSingleWaliKelas({{ $k->id_kelas }}, '{{ addslashes($k->waliKelas->nama_guru ?? $k->wali_kelas) }}')" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition-colors inline-flex items-center justify-center cursor-pointer" title="Hapus Penugasan Wali Kelas">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-slate-400">
                                    Belum ada data kelas terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Hidden Form for Single Delete -->
        <form id="singleWaliDeleteForm" action="" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>

        <!-- Pagination / Footer Info -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2 text-xs text-slate-400 font-medium">
            <p>Menampilkan <span class="font-bold text-slate-700" id="paginationRangeText">1 sampai {{ min(count($kelases), 8) }}</span> dari <span class="font-bold text-slate-700">{{ count($kelases) }}</span> Rombongan Belajar</p>
            <div class="flex items-center gap-1 self-end sm:self-auto" id="paginationControls">
                <!-- Rendered by client-side pagination JS -->
            </div>
        </div>
    </section>
    <!-- END: Card 3 -->
</div>

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
                Apakah Anda yakin ingin memindahkan <strong id="modalBulkCountText" class="text-rose-600 font-bold">0 penugasan wali kelas</strong> yang dicentang ke Tempat Sampah?
            </p>
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-center gap-2">
            <button type="button" class="flex-1 py-2 px-3 text-xs font-semibold rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 transition cursor-pointer" onclick="closeBulkDeleteModal()">Batal</button>
            <button type="button" class="flex-1 py-2 px-3 text-xs font-bold rounded-xl bg-rose-600 hover:bg-rose-700 text-white shadow-xs transition cursor-pointer" onclick="submitBulkDelete()">Ya, Hapus Data</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    /* 1. TAB SWITCHING LOGIC */
    function switchWaliTab(tab) {
        const manualPanel = document.getElementById('panel-manual');
        const massalPanel = document.getElementById('panel-massal');
        const manualBtn   = document.getElementById('tab-btn-manual');
        const massalBtn   = document.getElementById('tab-btn-massal');

        if (tab === 'manual') {
            manualPanel.classList.remove('hidden');
            massalPanel.classList.add('hidden');
            manualBtn.className = 'flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold shadow-xs hover:bg-blue-700 transition-all cursor-pointer';
            massalBtn.className = 'flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 text-slate-600 text-xs font-bold border border-slate-200 hover:bg-slate-100 transition-all cursor-pointer';
        } else {
            manualPanel.classList.add('hidden');
            massalPanel.classList.remove('hidden');
            massalBtn.className = 'flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold shadow-xs hover:bg-blue-700 transition-all cursor-pointer';
            manualBtn.className = 'flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 text-slate-600 text-xs font-bold border border-slate-200 hover:bg-slate-100 transition-all cursor-pointer';
        }
    }

    /* 2. SINGLE DELETE */
    function deleteSingleWaliKelas(id, nama) {
        if (confirm(`Apakah Anda yakin ingin memindahkan data Wali Kelas ${nama} ke tempat sampah?`)) {
            const form = document.getElementById('singleWaliDeleteForm');
            form.action = "{{ url('/admin/wali-kelas') }}/" + id;
            form.submit();
        }
    }

    /* 3. NIP & PASSWORD HELPERS */
    function updateNipCounter(input, targetLen = 18, msgId = 'nipMsg') {
        const counter = document.getElementById('nipCounter');
        const msgEle  = document.getElementById(msgId);
        const len     = input.value.length;

        if (counter) {
            counter.textContent = len + ' / ' + targetLen + ' digit';
            counter.className = (len === targetLen) 
                ? 'text-[10px] font-semibold text-emerald-600 font-mono' 
                : 'text-[10px] font-semibold text-rose-500 font-mono';
        }

        if (msgEle) {
            if (len === 0) {
                msgEle.textContent = 'Wajib diisi tepat ' + targetLen + ' digit angka.';
                msgEle.className = 'text-[10px] font-medium text-rose-500 mt-0.5';
            } else if (len < targetLen) {
                msgEle.textContent = 'Belum lengkap, baru ' + len + ' digit (kurang ' + (targetLen - len) + ' digit lagi).';
                msgEle.className = 'text-[10px] font-medium text-rose-500 mt-0.5';
            } else {
                msgEle.textContent = '✓ Format NIP ' + targetLen + ' digit angka sudah sesuai.';
                msgEle.className = 'text-[10px] font-medium text-emerald-600 mt-0.5';
            }
        }
    }

    function checkPasswordMinLength(input, msgId = 'passwordMsg') {
        const msgEle = document.getElementById(msgId);
        if (!msgEle) return;
        const len = input.value.length;
        if (len > 0 && len < 6) {
            msgEle.textContent = 'Password terlalu pendek, baru ' + len + ' karakter (minimal 6 karakter).';
            msgEle.className = 'text-[10px] font-medium text-rose-500 mt-0.5';
        } else if (len >= 6) {
            msgEle.textContent = '✓ Password memenuhi syarat (minimal 6 karakter).';
            msgEle.className = 'text-[10px] font-medium text-emerald-600 mt-0.5';
        } else {
            msgEle.textContent = 'Opsional. Default: 123456 (minimal 6 karakter jika diisi).';
            msgEle.className = 'text-[10px] font-medium text-slate-400 mt-0.5';
        }
    }

    /* 4. TEACHER QUICK SEARCH IN SINGLE FORM */
    function filterGuruWaliSelect(query) {
        const select = document.getElementById('select_id_guru');
        const badge  = document.getElementById('guru_match_count');
        if (!select) return;

        const q = query.trim().toLowerCase();
        let count = 0;

        for (let i = 0; i < select.options.length; i++) {
            const opt = select.options[i];
            if (!opt.value) {
                opt.hidden = false;
                opt.style.display = '';
                continue;
            }

            const nip  = (opt.getAttribute('data-nip') || '').toLowerCase();
            const nama = (opt.getAttribute('data-nama') || '').toLowerCase();
            const text = (opt.text || '').toLowerCase();

            if (q === '' || nip.includes(q) || nama.includes(q) || text.includes(q)) {
                opt.hidden = false;
                opt.style.display = '';
                count++;
            } else {
                opt.hidden = true;
                opt.style.display = 'none';
            }
        }

        if (badge) {
            if (q === '') {
                badge.innerText = '';
            } else {
                badge.innerText = count > 0 ? count + ' guru cocok' : 'Tidak ditemukan';
            }
        }
    }

    function resetWaliKelasForm() {
        const searchInput = document.getElementById('search_guru_nip');
        if (searchInput) {
            searchInput.value = '';
            filterGuruWaliSelect('');
        }

        const selectGuru = document.getElementById('select_id_guru');
        if (selectGuru) selectGuru.value = '';

        const selectKelas = document.getElementById('id_kelas');
        if (selectKelas) selectKelas.value = '';

        const inputNip = document.getElementById('nip');
        if (inputNip) {
            inputNip.value = '';
            updateNipCounter(inputNip, 18, 'nipMsg');
        }

        const inputName = document.getElementById('name');
        if (inputName) inputName.value = '';

        const selectJk = document.getElementById('jenis_kelamin');
        if (selectJk) selectJk.value = '';

        const inputNoHp = document.getElementById('no_hp');
        if (inputNoHp) inputNoHp.value = '';

        const passInput = document.getElementById('password');
        if (passInput) passInput.value = '';

        const fieldsToUnlock = [inputNip, inputName, selectJk, inputNoHp];
        fieldsToUnlock.forEach(field => {
            if (field) {
                field.readOnly = false;
                field.classList.remove('bg-slate-100', 'text-slate-500', 'cursor-not-allowed');
                field.classList.add('bg-white', 'text-slate-800');
                if (field.tagName === 'SELECT') {
                    field.style.pointerEvents = 'auto';
                    field.removeAttribute('tabindex');
                }
            }
        });

        const badgeStatus = document.getElementById('badge_mode_status');
        if (badgeStatus) {
            badgeStatus.textContent = 'Mode Input Manual';
            badgeStatus.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-200 text-slate-700';
        }

        const errorBanner = document.getElementById('formErrorReasonBanner');
        if (errorBanner) errorBanner.classList.add('hidden');
    }

    /* 5. BULK DELETE FUNCTIONALITY */
    function updateBulkDeleteState() {
        const checkedBoxes = document.querySelectorAll('.wali-select-checkbox:checked');
        const totalBoxes   = document.querySelectorAll('.wali-select-checkbox');
        const count        = checkedBoxes.length;
        const toolbar      = document.getElementById('bulkActionsToolbar');
        const countSpan    = document.getElementById('bulkDeleteCount');
        const selectAll    = document.getElementById('selectAllWaliKelas');

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

    function deselectAllWaliKelas() {
        const checkboxes = document.querySelectorAll('.wali-select-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        const selectAll = document.getElementById('selectAllWaliKelas');
        if (selectAll) selectAll.checked = false;
        updateBulkDeleteState();
    }

    function confirmBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.wali-select-checkbox:checked');
        const count = checkedBoxes.length;

        if (count === 0) {
            alert('Silakan pilih minimal 1 data wali kelas yang ingin dihapus dengan mencentang kotak centang (checkbox).');
            return;
        }

        const modalCountText = document.getElementById('modalBulkCountText');
        if (modalCountText) {
            modalCountText.textContent = count + ' penugasan wali kelas';
        }

        const modal = document.getElementById('modalConfirmBulkDelete');
        if (modal) {
            modal.classList.add('show');
        } else {
            if (confirm(`Apakah Anda yakin ingin memindahkan ${count} penugasan wali kelas yang dipilih ke Tempat Sampah?`)) {
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

    /* 6. DOM INITIALIZATION */
    document.addEventListener("DOMContentLoaded", function() {
        const inputNip = document.getElementById('nip');
        if (inputNip) updateNipCounter(inputNip, 18, 'nipMsg');

        const selectGuru  = document.getElementById('select_id_guru');
        const inputName   = document.getElementById('name');
        const selectJk    = document.getElementById('jenis_kelamin');
        const inputNoHp   = document.getElementById('no_hp');
        const badgeStatus = document.getElementById('badge_mode_status');

        const selectAll = document.getElementById('selectAllWaliKelas');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.wali-select-checkbox');
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

        function setFieldLockState(field, isLocked) {
            if (field) {
                field.readOnly = isLocked;
                if (isLocked) {
                    field.classList.add('bg-slate-100', 'text-slate-500', 'cursor-not-allowed');
                    field.classList.remove('bg-white', 'text-slate-800');
                    if (field.tagName === 'SELECT') {
                        field.style.pointerEvents = 'none';
                        field.setAttribute('tabindex', '-1');
                    }
                } else {
                    field.classList.remove('bg-slate-100', 'text-slate-500', 'cursor-not-allowed');
                    field.classList.add('bg-white', 'text-slate-800');
                    if (field.tagName === 'SELECT') {
                        field.style.pointerEvents = 'auto';
                        field.removeAttribute('tabindex');
                    }
                }
            }
        }

        function handleGuruSelection() {
            if (!selectGuru) return;
            const selectedOption = selectGuru.options[selectGuru.selectedIndex];
            const guruId = selectGuru.value;

            if (guruId && selectedOption && guruId !== '') {
                const nip  = selectedOption.getAttribute('data-nip') || '';
                const nama = selectedOption.getAttribute('data-nama') || '';
                const jk   = selectedOption.getAttribute('data-jk') || '';
                const nohp = selectedOption.getAttribute('data-nohp') || '';

                inputNip.value  = nip;
                inputName.value = nama;
                if (jk) selectJk.value = jk;
                if (nohp) inputNoHp.value = nohp;
                updateNipCounter(inputNip, 18, 'nipMsg');

                setFieldLockState(inputNip, true);
                setFieldLockState(inputName, true);
                setFieldLockState(selectJk, true);
                setFieldLockState(inputNoHp, true);

                if (badgeStatus) {
                    badgeStatus.textContent = 'Mode Auto-fill (Terkunci)';
                    badgeStatus.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-800';
                }
            } else {
                setFieldLockState(inputNip, false);
                setFieldLockState(inputName, false);
                setFieldLockState(selectJk, false);
                setFieldLockState(inputNoHp, false);
                updateNipCounter(inputNip, 18, 'nipMsg');

                if (badgeStatus) {
                    badgeStatus.textContent = 'Mode Input Manual';
                    badgeStatus.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-200 text-slate-700';
                }
            }
        }

        if (selectGuru) {
            selectGuru.addEventListener('change', handleGuruSelection);
            if (selectGuru.value) handleGuruSelection();
        }

        const form = document.getElementById('formWaliKelas');
        if (form) {
            form.addEventListener('submit', function(e) {
                const errors = [];
                const klsVal  = document.getElementById('id_kelas').value;
                const nipVal  = document.getElementById('nip').value.trim();
                const namaVal = document.getElementById('name').value.trim();
                const passInput = document.getElementById('password');
                const passVal = passInput ? passInput.value : '';

                if (!klsVal) {
                    errors.push('Kelas bimbingan wajib dipilih.');
                }

                if (!nipVal) {
                    errors.push('NIP Wali Kelas wajib diisi 18 digit angka.');
                } else if (nipVal.length !== 18) {
                    errors.push('NIP Wali Kelas harus berisi tepat 18 digit angka (saat ini baru ' + nipVal.length + ' digit).');
                }

                if (!namaVal) {
                    errors.push('Nama Lengkap Wali Kelas wajib diisi.');
                }

                if (passVal.length > 0 && passVal.length < 6) {
                    errors.push('Password baru minimal 6 karakter (saat ini baru ' + passVal.length + ' karakter).');
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

        // Initialize table pagination
        setupTablePagination();
    });

    /* 7. BULK ASSIGNMENT FILTERING & VALIDATION */
    function filterBulkClassesTable() {
        const jurusanVal = document.getElementById('bulkFilterJurusan') ? document.getElementById('bulkFilterJurusan').value : '';
        const tingkatVal = document.getElementById('bulkFilterTingkat') ? document.getElementById('bulkFilterTingkat').value : '';
        const searchVal  = document.getElementById('bulkSearchKelas') ? document.getElementById('bulkSearchKelas').value.trim().toLowerCase() : '';

        const rows = document.querySelectorAll('#tableBulkWaliKelas tbody tr.bulk-class-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const rJurusan = row.getAttribute('data-jurusan') || '';
            const rTingkat = row.getAttribute('data-tingkat') || '';
            const rNama    = row.getAttribute('data-nama') || '';

            const matchJurusan = (jurusanVal === '' || rJurusan === jurusanVal);
            const matchTingkat = (tingkatVal === '' || rTingkat === tingkatVal);
            const matchSearch  = (searchVal === '' || rNama.includes(searchVal));

            if (matchJurusan && matchTingkat && matchSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const badge = document.getElementById('bulkClassCounterBadge');
        if (badge) {
            badge.textContent = 'Menampilkan ' + visibleCount + ' Kelas';
        }
    }

    function onBulkWaliTeacherChange(selectElem) {
        validateBulkWaliTeacherSelection();
    }

    function validateBulkWaliTeacherSelection() {
        const selects = document.querySelectorAll('.bulk-teacher-select');
        const teacherMap = {};
        const conflicts = [];

        selects.forEach(sel => {
            const val = sel.value;
            sel.classList.remove('border-rose-500', 'bg-rose-50');
            sel.classList.add('border-slate-200', 'bg-white');
            const errDiv = sel.parentNode.querySelector('.bulk-field-error');
            if (errDiv) errDiv.classList.add('hidden');

            if (val && val !== 'none') {
                if (!teacherMap[val]) teacherMap[val] = [];
                teacherMap[val].push(sel);
            }
        });

        Object.keys(teacherMap).forEach(teacherId => {
            const selList = teacherMap[teacherId];
            if (selList.length > 1) {
                const selectedOpt = selList[0].options[selList[0].selectedIndex];
                const namaGuru = selectedOpt ? selectedOpt.getAttribute('data-nama') || selectedOpt.text : 'Guru ID ' + teacherId;
                const kelasNames = selList.map(s => s.getAttribute('data-nama-kelas')).join(', ');

                conflicts.push(`Guru <strong>${namaGuru}</strong> dipilih untuk ${selList.length} kelas sekaligus (${kelasNames}). Satu guru hanya dapat menjadi Wali Kelas di 1 kelas.`);

                selList.forEach(s => {
                    s.classList.add('border-rose-500', 'bg-rose-50');
                    s.classList.remove('border-slate-200', 'bg-white');
                    const errDiv = s.parentNode.querySelector('.bulk-field-error');
                    if (errDiv) {
                        errDiv.textContent = '⚠️ Bentrok! Guru ini juga dipilih di kelas lain.';
                        errDiv.classList.remove('hidden');
                    }
                });
            }
        });

        const alertBanner = document.getElementById('bulkConflictAlert');
        const alertList   = document.getElementById('bulkConflictList');
        const submitBtn   = document.getElementById('btnSubmitBulkWali');

        if (conflicts.length > 0) {
            if (alertList) {
                alertList.innerHTML = '';
                conflicts.forEach(msg => {
                    const li = document.createElement('li');
                    li.innerHTML = msg;
                    alertList.appendChild(li);
                });
            }
            if (alertBanner) alertBanner.classList.remove('hidden');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                submitBtn.classList.remove('cursor-pointer');
            }
        } else {
            if (alertBanner) alertBanner.classList.add('hidden');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                submitBtn.classList.add('cursor-pointer');
            }
        }

        return conflicts.length === 0;
    }

    function validateBulkWaliFormSubmission(event) {
        const isValid = validateBulkWaliTeacherSelection();
        if (!isValid) {
            event.preventDefault();
            const alertBanner = document.getElementById('bulkConflictAlert');
            if (alertBanner) {
                alertBanner.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return false;
        }

        if (!confirm('Apakah Anda yakin ingin menyimpan seluruh data penugasan wali kelas ini?')) {
            event.preventDefault();
            return false;
        }

        return true;
    }

    function confirmResetBulkWaliForm() {
        if (confirm('Apakah Anda yakin ingin mereset semua pilihan penugasan wali kelas?')) {
            resetBulkWaliForm();
        }
    }

    function resetBulkWaliForm() {
        const selects = document.querySelectorAll('.bulk-teacher-select');
        selects.forEach(sel => {
            for (let i = 0; i < sel.options.length; i++) {
                const opt = sel.options[i];
                opt.selected = opt.defaultSelected;
            }
        });

        const fJurusan = document.getElementById('bulkFilterJurusan');
        const fTingkat = document.getElementById('bulkFilterTingkat');
        const fSearch  = document.getElementById('bulkSearchKelas');

        if (fJurusan) fJurusan.value = '';
        if (fTingkat) fTingkat.value = '';
        if (fSearch)  fSearch.value = '';

        filterBulkClassesTable();
        validateBulkWaliTeacherSelection();
    }

    /* 8. CLIENT-SIDE TABLE PAGINATION FOR MAIN TABLE */
    let currentTablePage = 1;
    const rowsPerPage = 8;

    function setupTablePagination() {
        const allRows = document.querySelectorAll('#waliTableBody tr.wali-data-row');
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
            paginationHTML += `<button type="button" onclick="goToTablePage(${currentTablePage - 1})" class="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>`;
        } else {
            paginationHTML += `<button type="button" class="p-1.5 rounded-lg border border-slate-200 text-slate-300 font-medium text-xs cursor-not-allowed" disabled><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>`;
        }

        if (totalPages <= 7) {
            for (let p = 1; p <= totalPages; p++) {
                if (p === currentTablePage) {
                    paginationHTML += `<button type="button" class="px-3 py-1 rounded-lg bg-blue-600 text-white font-bold text-xs shadow-xs">${p}</button>`;
                } else {
                    paginationHTML += `<button type="button" onclick="goToTablePage(${p})" class="px-3 py-1 rounded-lg border border-slate-200 text-slate-600 font-medium text-xs hover:bg-slate-50 transition cursor-pointer">${p}</button>`;
                }
            }
        } else {
            if (currentTablePage === 1) {
                paginationHTML += `<button type="button" class="px-3 py-1 rounded-lg bg-blue-600 text-white font-bold text-xs shadow-xs">1</button>`;
            } else {
                paginationHTML += `<button type="button" onclick="goToTablePage(1)" class="px-3 py-1 rounded-lg border border-slate-200 text-slate-600 font-medium text-xs hover:bg-slate-50 transition cursor-pointer">1</button>`;
            }

            if (currentTablePage > 3) {
                paginationHTML += `<span class="px-1 text-slate-400">...</span>`;
            }

            let startP = Math.max(2, currentTablePage - 1);
            let endP = Math.min(totalPages - 1, currentTablePage + 1);

            for (let p = startP; p <= endP; p++) {
                if (p === currentTablePage) {
                    paginationHTML += `<button type="button" class="px-3 py-1 rounded-lg bg-blue-600 text-white font-bold text-xs shadow-xs">${p}</button>`;
                } else {
                    paginationHTML += `<button type="button" onclick="goToTablePage(${p})" class="px-3 py-1 rounded-lg border border-slate-200 text-slate-600 font-medium text-xs hover:bg-slate-50 transition cursor-pointer">${p}</button>`;
                }
            }

            if (currentTablePage < totalPages - 2) {
                paginationHTML += `<span class="px-1 text-slate-400">...</span>`;
            }

            if (currentTablePage === totalPages) {
                paginationHTML += `<button type="button" class="px-3 py-1 rounded-lg bg-blue-600 text-white font-bold text-xs shadow-xs">${totalPages}</button>`;
            } else {
                paginationHTML += `<button type="button" onclick="goToTablePage(${totalPages})" class="px-3 py-1 rounded-lg border border-slate-200 text-slate-600 font-medium text-xs hover:bg-slate-50 transition cursor-pointer">${totalPages}</button>`;
            }
        }

        if (currentTablePage < totalPages) {
            paginationHTML += `<button type="button" onclick="goToTablePage(${currentTablePage + 1})" class="p-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 transition cursor-pointer"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>`;
        } else {
            paginationHTML += `<button type="button" class="p-1.5 rounded-lg border border-slate-200 text-slate-300 font-medium text-xs cursor-not-allowed" disabled><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>`;
        }

        paginationControls.innerHTML = paginationHTML;
    }

    function goToTablePage(page) {
        currentTablePage = page;
        setupTablePagination();
        updateBulkDeleteState();
    }
</script>
@endsection
