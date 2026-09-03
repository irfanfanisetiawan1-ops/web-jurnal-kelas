@extends('layouts.admin')

@section('title', 'Daftar Wali Kelas — EDU JOURNAL')

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

    /* Teacher Quick Selection Box (Design Enhanced) */
    .teacher-select-box {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1.5px solid #93c5fd;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.05);
        transition: all 0.25s ease;
    }
    .teacher-select-box:hover {
        border-color: #3b82f6;
        box-shadow: 0 6px 16px rgba(2, 132, 199, 0.1);
    }
    .teacher-select-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 12px;
    }
    .teacher-select-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14.5px;
        font-weight: 700;
        color: #0369a1;
    }
    .teacher-select-title-icon {
        background: #ffffff;
        color: #0284c7;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.15);
    }
    .badge-status {
        font-size: 12px;
        padding: 5px 14px;
        border-radius: 20px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .badge-status-manual {
        background: #e2e8f0;
        color: #475569;
        border: 1px solid #cbd5e1;
    }
    .badge-status-autofill {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #93c5fd;
    }
    .teacher-select-control {
        background: #ffffff !important;
        border: 1.5px solid #93c5fd !important;
        font-weight: 600;
        color: #0369a1 !important;
        border-radius: 12px !important;
        padding: 12px 16px !important;
        font-size: 14px !important;
        width: 100%;
        outline: none;
        transition: all 0.2s ease;
    }
    .teacher-select-control:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15) !important;
    }
    .teacher-info-text {
        margin-top: 10px;
        font-size: 12.5px;
        color: #0369a1;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        line-height: 1.5;
        background: rgba(255, 255, 255, 0.7);
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px dashed #bae6fd;
    }

    /* Auto-fill Lock Notice Banner */
    .autofill-notice-banner {
        display: none;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        padding: 12px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
        font-size: 13px;
        font-weight: 600;
        align-items: center;
        gap: 10px;
        animation: fadeInNotice 0.3s ease;
    }
    @keyframes fadeInNotice {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Modern 2-Column Form Layout */
    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    @media (max-width: 768px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 7px;
    }
    .form-group label i {
        color: #0284c7;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        background: #ffffff;
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
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    }

    .btn-submit-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-submit {
        background: linear-gradient(135deg, #0284c7, #2563eb);
        color: white;
        padding: 12px 32px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }
    .btn-submit:hover {
        opacity: 0.95;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
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
            <h1>Navigasi & Pemetaan Wali Kelas</h1>
            <p>Kelola penugasan dan pemetaan guru sebagai wali kelas per rombel</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <i class="fa-solid fa-id-card-clip" style="color:#0284c7;"></i>
        <span>Navigasi & Pemetaan Wali Kelas</span>
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

    <!-- Card 1: Form Tambah & Penugasan Wali Kelas Baru -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-user-plus" style="color:#0284c7;"></i> Tambah & Penugasan Wali Kelas Baru</h2>
                <p>Pilih kelas bimbingan dan tentukan Wali Kelas baik dari daftar guru terdaftar maupun data guru baru.</p>
            </div>
            <a href="{{ route('admin.wali-kelas.trash') }}" class="btn-trash">
                <i class="fa-solid fa-trash-can"></i> Lihat Tong Sampah
                @if(isset($trashedCount) && $trashedCount > 0)
                    <span class="badge-count">{{ $trashedCount }}</span>
                @endif
            </a>
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

        <form id="formWaliKelas" action="{{ route('admin.wali-kelas.store') }}" method="POST" novalidate>
            @csrf
            <!-- Box Pilihan Guru Terdaftar & Terverifikasi -->
            <div class="teacher-select-box">
                <div class="teacher-select-header">
                    <div class="teacher-select-title">
                        <div class="teacher-select-title-icon">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <span>Pilih Guru Terdaftar & Terverifikasi</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span id="guru_match_count" style="font-size:11.5px; font-weight:700; color:#0284c7;"></span>
                        <span id="badge_mode_status" class="badge-status badge-status-manual">
                            <i class="fa-solid fa-pen-to-square"></i> Input Manual
                        </span>
                    </div>
                </div>

                {{-- Fitur Cari Berdasarkan NIP atau Nama --}}
                <div style="position:relative; margin-top:10px; margin-bottom:8px;">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px;"></i>
                    <input type="text" id="search_guru_nip" class="form-control" 
                           placeholder="Cari berdasarkan NIP atau Nama Guru..." 
                           oninput="filterGuruWaliSelect(this.value)"
                           style="padding-left:36px; font-size:13px; background:#ffffff; border-color:#cbd5e1;">
                </div>

                <select id="select_id_guru" name="id_guru" class="teacher-select-control">
                    <option value="">-- Pilih Guru Terdaftar (Atau Input Manual Di Bawah) --</option>
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
                                style="{{ $isAssigned ? 'color:#94a3b8; background-color:#f1f5f9; font-style:italic;' : '' }}">
                            {{ $g->nama_guru }} (NIP: {{ $g->nip }})
                            @if($isAssigned)
                                — [Sudah Menjadi Wali Kelas: {{ $assignedClassName }}]
                            @elseif($g->jenis_kelamin)
                                - [{{ $g->jenis_kelamin_teks }}]
                            @endif
                        </option>
                    @endforeach
                </select>

                <div id="info_auto_fill" class="teacher-info-text">
                    <i class="fa-solid fa-circle-info" style="color:#0284c7; font-size:15px; flex-shrink:0; margin-top:2px;"></i>
                    <span>Pilih guru dari daftar untuk mengaktifkan pengisian data otomatis, atau pilih opsi default jika ingin menginput data guru baru secara manual.</span>
                </div>
            </div>

            <!-- Banner Notifikasi Saat Auto-Fill Aktif -->
            <div id="autofill_lock_notice" class="autofill-notice-banner">
                <i class="fa-solid fa-lock" style="color:#2563eb; font-size:16px;"></i>
                <span>Data NIP, Nama, Jenis Kelamin, dan HP terisi otomatis dari database guru. Pilih opsi default di atas untuk kembali ke mode manual.</span>
            </div>

            <!-- Form Inputs Grid (2 Columns) -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label for="id_kelas"><i class="fa-solid fa-chalkboard"></i> Kelas Bimbingan <span style="color:#ef4444;">*</span></label>
                    <select id="id_kelas" name="id_kelas" class="form-control @error('id_kelas') is-invalid @enderror" required>
                        <option value="">-- Pilih Kelas Bimbingan --</option>
                        @foreach($kelases as $kls)
                            @php
                                $hasWali = !empty($kls->wali_kelas);
                                $namaWaliKelas = $kls->waliKelas->nama_guru ?? ($hasWali ? 'NIP: '.$kls->wali_kelas : null);
                            @endphp
                            <option value="{{ $kls->id_kelas }}"
                                    {{ old('id_kelas') == $kls->id_kelas ? 'selected' : '' }}
                                    {{ $hasWali ? 'disabled' : '' }}
                                    style="{{ $hasWali ? 'color:#94a3b8; background-color:#f1f5f9; font-style:italic;' : '' }}">
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
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nip" style="margin-bottom: 0;"><i class="fa-solid fa-id-card"></i> NIP Wali Kelas (18 Digit) <span style="color:#ef4444;">*</span></label>
                        <span id="nipCounter" style="font-size: 12px; font-weight: 700; color: #ef4444;">0/18 digit</span>
                    </div>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                        class="form-control @error('nip') is-invalid @enderror"
                        placeholder="Masukkan NIP Wali Kelas (18 Digit)" maxlength="18" minlength="18" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18); updateNipCounter(this, 18, 'nipMsg');"
                        required>
                    <small id="nipMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi tepat 18 digit angka.</small>
                    @error('nip')
                        <small style="color:#ef4444; font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name"><i class="fa-solid fa-user-pen"></i> Nama Lengkap Wali Kelas <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap Wali Kelas" required>
                    @error('name')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin"><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="no_hp"><i class="fa-solid fa-phone"></i> Nomor HP / WhatsApp</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                        class="form-control @error('no_hp') is-invalid @enderror"
                        placeholder="Contoh: 081234567890" maxlength="15" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);">
                    @error('no_hp')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password"><i class="fa-solid fa-key"></i> Password Baru (Opsional)</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Default: 123456 (bila diisi, minimal 6 karakter)"
                        oninput="checkPasswordMinLength(this, 'passwordMsg');">
                    <small id="passwordMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#64748b;">Opsional. Default: 123456 (minimal 6 karakter jika diisi).</small>
                    @error('password')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="btn-submit-container" style="gap:12px;">
                <button type="button" class="btn-reset" onclick="resetWaliKelasForm()" style="cursor:pointer; border:none;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan & Penugasan Wali Kelas
                </button>
            </div>
        </form>
    </div>

    <!-- Card FITUR BARU: Penugasan Wali Kelas Baru Secara Cepat dan Banyak -->
    <div class="card" style="border: 1.5px solid #0284c7; background: #ffffff;">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-bolt" style="color:#0284c7;"></i> Penugasan Wali Kelas Baru Secara Cepat dan Banyak</h2>
                <p>Tentukan penugasan Wali Kelas untuk seluruh rombel/kelas bimbingan sekaligus dalam satu kali simpan.</p>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <span class="badge-status" style="background:#e0f2fe; color:#0369a1; border:1px solid #7dd3fc;">
                    <i class="fa-solid fa-layer-group"></i> Penugasan Massal (Bulk Assignment)
                </span>
            </div>
        </div>

        <!-- Alert Peringatan Bentrokan Guru (JS Real-time Validation) -->
        <div id="bulkConflictAlert" class="alert-custom alert-error" style="display: none; margin-bottom: 20px; border-left: 5px solid #dc2626;">
            <div style="display:flex; align-items:flex-start; gap:12px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:24px; color:#dc2626; flex-shrink:0; margin-top:2px;"></i>
                <div>
                    <h4 style="font-size:15px; font-weight:800; margin:0 0 4px 0; color:#9f1239;">Perhatian: Terjadi Bentrokan Guru Wali Kelas!</h4>
                    <p style="margin:0 0 6px 0; font-size:13px; color:#881337;">Satu guru hanya dapat menjadi Wali Kelas untuk 1 kelas saja. Silakan perbaiki pilihan guru berikut:</p>
                    <ul id="bulkConflictList" style="margin: 0 0 0 18px; padding: 0; font-size: 13px; color: #9f1239; font-weight:700;"></ul>
                </div>
            </div>
        </div>

        <!-- Filter Controls untuk Penugasan Cepat -->
        <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom:20px; background:#f0f9ff; padding:14px 18px; border-radius:14px; border:1px solid #bae6fd;">
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                <div style="display:flex; align-items:center; gap:6px;">
                    <label style="font-size:13px; font-weight:700; color:#0369a1; margin:0;"><i class="fa-solid fa-filter"></i> Jurusan:</label>
                    <select id="bulkFilterJurusan" onchange="filterBulkClassesTable()" class="form-control" style="width: 170px; background:#ffffff; border-color:#7dd3fc;">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id_jurusan }}">{{ $j->kode_jurusan ?? $j->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex; align-items:center; gap:6px;">
                    <label style="font-size:13px; font-weight:700; color:#0369a1; margin:0;"><i class="fa-solid fa-graduation-cap"></i> Tingkat Kelas:</label>
                    <select id="bulkFilterTingkat" onchange="filterBulkClassesTable()" class="form-control" style="width: 150px; background:#ffffff; border-color:#7dd3fc;">
                        <option value="">Semua Tingkat</option>
                        <option value="X">Kelas X</option>
                        <option value="XI">Kelas XI</option>
                        <option value="XII">Kelas XII</option>
                    </select>
                </div>

                <div style="position:relative;">
                    <input type="text" id="bulkSearchKelas" oninput="filterBulkClassesTable()" class="form-control" style="width:200px; padding-left:34px; background:#ffffff; border-color:#7dd3fc;" placeholder="Cari nama kelas...">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#0284c7;"></i>
                </div>
            </div>

            <div style="display:flex; align-items:center; gap:10px;">
                <span id="bulkClassCounterBadge" style="font-size:12.5px; font-weight:800; color:#0369a1; background:#ffffff; padding:6px 14px; border-radius:20px; border:1px solid #7dd3fc;">
                    Menampilkan {{ count($kelases) }} Kelas
                </span>
            </div>
        </div>

        <form id="formBulkWaliKelas" action="{{ route('admin.wali-kelas.bulk-assign') }}" method="POST" onsubmit="return validateBulkWaliFormSubmission(event)">
            @csrf
            <div class="table-responsive" style="max-height: 480px; overflow-y: auto;">
                <table class="table-custom" id="tableBulkWaliKelas">
                    <thead style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th style="width:40px; text-align:center;">NO</th>
                            <th style="width:200px;">NAMA KELAS / ROMBEL</th>
                            <th style="width:180px;">JURUSAN</th>
                            <th style="width:220px;">WALI KELAS SAAT INI</th>
                            <th>PILIH GURU WALI KELAS BARU (TERDAFTAR & TERVERIFIKASI)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelases as $idx => $kls)
                            @php
                                $currentWaliNip  = $kls->wali_kelas;
                                $currentWaliGuru = $kls->waliKelas;
                                $tingkatStr = '';
                                if (preg_match('/^(X|XI|XII)\b/i', trim($kls->nama_kelas), $m)) {
                                    $tingkatStr = strtoupper($m[1]);
                                }
                            @endphp
                            <tr class="bulk-class-row" 
                                data-id-kelas="{{ $kls->id_kelas }}"
                                data-jurusan="{{ $kls->id_jurusan }}"
                                data-tingkat="{{ $tingkatStr }}"
                                data-nama="{{ strtolower($kls->nama_kelas) }}">
                                <td style="text-align:center;"><strong>{{ $idx + 1 }}</strong></td>
                                <td>
                                    <strong style="color:#0f172a; font-size:14px;">{{ $kls->nama_kelas }}</strong>
                                </td>
                                <td>
                                    <span style="font-size:12.5px; color:#475569; font-weight:600;">
                                        {{ $kls->jurusan->nama_jurusan ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($currentWaliGuru)
                                        <div style="display:flex; align-items:center; gap:6px;">
                                            <i class="fa-solid fa-user-shield" style="color:#0284c7;"></i>
                                            <span style="font-weight:700; color:#0369a1; font-size:13px;">{{ $currentWaliGuru->nama_guru }}</span>
                                        </div>
                                        <small style="color:#64748b; font-family:monospace;">NIP: {{ $currentWaliNip }}</small>
                                    @elseif($currentWaliNip)
                                        <span style="font-family:monospace; font-weight:700; color:#3b5490;">NIP: {{ $currentWaliNip }}</span>
                                    @else
                                        <span style="color:#94a3b8; font-style:italic; font-size:12.5px;">(Belum Ada Wali)</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="position:relative;">
                                        <select name="bulk_assignments[{{ $kls->id_kelas }}]" 
                                                class="form-control bulk-teacher-select"
                                                data-id-kelas="{{ $kls->id_kelas }}"
                                                data-nama-kelas="{{ $kls->nama_kelas }}"
                                                data-original-value="{{ $currentWaliGuru ? $currentWaliGuru->id_guru : '' }}"
                                                onchange="onBulkWaliTeacherChange(this)"
                                                style="border-color:#93c5fd; font-weight:600;">
                                            <option value="none">-- Tetap (Tidak Ada Perubahan) --</option>
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
                                                        style="{{ $isAssignedElsewhere ? 'color:#64748b; background:#f1f5f9;' : '' }}">
                                                    {{ $g->nama_guru }} (NIP: {{ $g->nip }})
                                                    @if($isCurrentWali)
                                                        ✓ [Wali Kelas Saat Ini]
                                                    @elseif($isAssignedElsewhere)
                                                        — [Sudah Menjadi Wali: {{ $assignedClassName }}]
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="bulk-field-error" style="display:none; color:#ef4444; font-size:11.5px; font-weight:700; margin-top:4px;"></div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding:30px; color:#94a3b8;">
                                    Belum ada kelas terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="btn-submit-container" style="gap:12px; margin-top:20px; background:#f8fafc; padding:16px 20px; border-radius:14px; border:1px solid #e2e8f0;">
                <button type="button" class="btn-reset" onclick="confirmResetBulkWaliForm()" style="cursor:pointer; border:none;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </button>
                <button type="submit" id="btnSubmitBulkWali" class="btn-submit" style="background: linear-gradient(135deg, #059669, #10b981); box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                </button>
            </div>
        </form>
    </div>

    <!-- Card 3: Daftar Pemetaan Wali Kelas Per Rombel -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-chalkboard-user" style="color:#0284c7;"></i> Daftar Pemetaan Wali Kelas Per Rombel ({{ count($kelases) }})</h2>
                <p>Memantau penugasan Wali Kelas pada tiap rombel/kelas bimbingan serta jumlah siswa.</p>
            </div>
        </div>

        <form action="{{ route('admin.wali-kelas-list') }}" method="GET" style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom:20px; background:#f8fafc; padding:14px 18px; border-radius:14px; border:1px solid #cbd5e1;">
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" style="width:220px; padding-left:36px; background:#ffffff;" placeholder="Cari kelas / nama wali / NIP...">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                </div>

                <select name="id_jurusan" class="form-control" style="width: 160px; background:#ffffff;">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id_jurusan }}" {{ (isset($id_jurusan) && $id_jurusan == $j->id_jurusan) ? 'selected' : '' }}>{{ $j->kode_jurusan ?? $j->nama_jurusan }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto;">
                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('admin.wali-kelas-list') }}" class="btn-reset">Reset</a>
                <button type="button" id="btnBulkDelete" class="btn-action btn-delete" style="padding: 10px 18px; border-radius: 12px; font-size: 13.5px; opacity: 0.5; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(225,29,72,0.15); border: none;" disabled onclick="confirmBulkDelete()" title="Pilih wali kelas dengan mencentang checkbox untuk menghapus secara massal">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="bulkDeleteCount">0</span>)
                </button>
            </div>
        </form>

        <form id="formBulkDelete" action="{{ route('admin.wali-kelas.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllWaliKelas" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" title="Pilih Semua (Select All)">
                            </th>
                            <th style="width:50px;">NO</th>
                            <th>NAMA KELAS / ROMBEL</th>
                            <th>WALI KELAS BIMBINGAN</th>
                            <th>NIP WALI KELAS</th>
                            <th>JUMLAH SISWA</th>
                            <th style="text-align:center; min-width: 180px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelases as $index => $k)
                            @php
                                $hasWali = !empty($k->wali_kelas);
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    @if($hasWali)
                                        <input type="checkbox" name="ids[]" value="{{ $k->id_kelas }}" class="wali-select-checkbox" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" onchange="updateBulkDeleteState()">
                                    @else
                                        <input type="checkbox" disabled style="width: 17px; height: 17px; opacity: 0.3; cursor: not-allowed;" title="Belum Ada Wali Kelas">
                                    @endif
                                </td>
                                <td><strong>{{ $index + 1 }}</strong></td>
                                <td>
                                    <strong>{{ $k->nama_kelas }}</strong>
                                    <div style="font-size:12px; color:#64748b; margin-top:2px;">Jurusan: {{ $k->jurusan->nama_jurusan ?? '-' }}</div>
                                </td>
                                <td>
                                    @if($k->waliKelas)
                                        <strong style="color:#0369a1;"><i class="fa-solid fa-user-shield"></i> {{ $k->waliKelas->nama_guru }}</strong>
                                    @else
                                        <span style="color:#94a3b8; font-style:italic;">Belum Ditentukan</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-family:monospace; font-weight:700; color:#3b5490;">{{ $k->wali_kelas ?? '-' }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('kelas.show', $k->id_kelas) }}" style="text-decoration:none;">
                                        <span style="background:#e0f2fe; color:#0369a1; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:5px;">
                                            <i class="fa-solid fa-graduation-cap"></i> {{ $k->jumlah_siswa_real }} Siswa
                                        </span>
                                    </a>
                                </td>
                                <td style="text-align:center;">
                                    <div class="action-buttons">
                                        <a href="{{ route('kelas.edit', $k->id_kelas) }}" class="btn-action btn-edit" title="Edit Wali Kelas">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>

                                        @if($hasWali)
                                            <button type="button" class="btn-action btn-delete" onclick="deleteSingleWaliKelas({{ $k->id_kelas }}, '{{ addslashes($k->waliKelas->nama_guru ?? $k->wali_kelas) }}')" title="Soft Delete Wali Kelas">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:36px; color:#94a3b8;">
                                    <i class="fa-solid fa-folder-open" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                    Belum ada data kelas terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <form id="singleWaliDeleteForm" action="" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Modal Confirm Bulk Delete -->
    <div class="modal-bg" id="modalConfirmBulkDelete">
        <div class="modal-box">
            <div class="modal-icon-wrap">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h3>Konfirmasi Hapus Terpilih</h3>
            <p>Apakah Anda yakin ingin memindahkan <strong id="modalBulkCountText" style="color:#e11d48;">0 penugasan wali kelas</strong> yang dicentang ke Tempat Sampah?</p>
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeBulkDeleteModal()">Batal</button>
                <button type="button" class="btn-m-confirm" onclick="submitBulkDelete()">Ya, Hapus Data</button>
            </div>
        </div>
    </div>

    <script>
        function deleteSingleWaliKelas(id, nama) {
            if (confirm(`Apakah Anda yakin ingin memindahkan data Wali Kelas ${nama} ke tempat sampah?`)) {
                const form = document.getElementById('singleWaliDeleteForm');
                form.action = "{{ url('/admin/wali-kelas') }}/" + id;
                form.submit();
            }
        }

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

        function checkPasswordMinLength(input, msgId = 'passwordMsg') {
            const msgEle = document.getElementById(msgId);
            if (!msgEle) return;
            const len = input.value.length;
            if (len > 0 && len < 6) {
                msgEle.textContent = 'Password terlalu pendek, baru ' + len + ' karakter (minimal 6 karakter).';
                msgEle.style.color = '#ef4444';
            } else if (len >= 6) {
                msgEle.textContent = '✓ Password memenuhi syarat (minimal 6 karakter).';
                msgEle.style.color = '#10b981';
            } else {
                msgEle.textContent = 'Opsional. Default: 123456 (minimal 6 karakter jika diisi).';
                msgEle.style.color = '#64748b';
            }
        }

        function filterGuruWaliSelect(query) {
            const select = document.getElementById('select_id_guru');
            const badge = document.getElementById('guru_match_count');
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

                const nip = (opt.getAttribute('data-nip') || '').toLowerCase();
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
            if (selectGuru) {
                selectGuru.value = '';
            }

            const selectKelas = document.getElementById('id_kelas');
            if (selectKelas) {
                selectKelas.value = '';
            }

            const inputNip = document.getElementById('nip');
            if (inputNip) {
                inputNip.value = '';
                updateNipCounter(inputNip, 18, 'nipMsg');
            }

            const inputName = document.getElementById('name');
            if (inputName) {
                inputName.value = '';
            }

            const selectJk = document.getElementById('jenis_kelamin');
            if (selectJk) {
                selectJk.value = '';
            }

            const inputNoHp = document.getElementById('no_hp');
            if (inputNoHp) {
                inputNoHp.value = '';
            }

            const passInput = document.getElementById('password');
            if (passInput) {
                passInput.value = '';
            }

            const fieldsToUnlock = [inputNip, inputName, selectJk, inputNoHp];
            fieldsToUnlock.forEach(field => {
                if (field) {
                    field.readOnly = false;
                    field.style.backgroundColor = '#ffffff';
                    field.style.color = '#1e293b';
                    field.style.cursor = field.tagName === 'SELECT' ? 'default' : 'text';
                    if (field.tagName === 'SELECT') {
                        field.style.pointerEvents = 'auto';
                        field.removeAttribute('tabindex');
                    }
                }
            });

            const badgeStatus = document.getElementById('badge_mode_status');
            if (badgeStatus) {
                badgeStatus.innerHTML = '<i class="fa-solid fa-pen-to-square"></i> Input Manual';
                badgeStatus.className = 'badge-status badge-status-manual';
            }

            const autofillBanner = document.getElementById('autofill_lock_notice');
            if (autofillBanner) {
                autofillBanner.style.display = 'none';
            }

            const errorBanner = document.getElementById('formErrorReasonBanner');
            if (errorBanner) {
                errorBanner.style.display = 'none';
            }
        }

        function updateBulkDeleteState() {
            const checkedBoxes = document.querySelectorAll('.wali-select-checkbox:checked');
            const totalBoxes   = document.querySelectorAll('.wali-select-checkbox');
            const count        = checkedBoxes.length;
            const btnBulkDelete= document.getElementById('btnBulkDelete');
            const countSpan    = document.getElementById('bulkDeleteCount');
            const selectAll    = document.getElementById('selectAllWaliKelas');

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
                modal.classList.add('active');
            } else {
                if (confirm(`Apakah Anda yakin ingin memindahkan ${count} penugasan wali kelas yang dipilih ke Tempat Sampah?`)) {
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
            const inputNip = document.getElementById('nip');
            if (inputNip) updateNipCounter(inputNip, 18, 'nipMsg');

            const selectGuru     = document.getElementById('select_id_guru');
            const inputName      = document.getElementById('name');
            const selectJk       = document.getElementById('jenis_kelamin');
            const inputNoHp      = document.getElementById('no_hp');
            const badgeStatus    = document.getElementById('badge_mode_status');
            const autofillBanner = document.getElementById('autofill_lock_notice');

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
                        field.style.backgroundColor = '#f1f5f9';
                        field.style.color = '#64748b';
                        field.style.cursor = 'not-allowed';
                        if (field.tagName === 'SELECT') {
                            field.style.pointerEvents = 'none';
                            field.setAttribute('tabindex', '-1');
                        }
                    } else {
                        field.style.backgroundColor = '#ffffff';
                        field.style.color = '#1e293b';
                        field.style.cursor = field.tagName === 'SELECT' ? 'default' : 'text';
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
                        badgeStatus.innerHTML = '<i class="fa-solid fa-lock"></i> Mode Auto-fill (Terkunci)';
                        badgeStatus.className = 'badge-status badge-status-autofill';
                    }

                    if (autofillBanner) {
                        autofillBanner.style.display = 'flex';
                    }
                } else {
                    setFieldLockState(inputNip, false);
                    setFieldLockState(inputName, false);
                    setFieldLockState(selectJk, false);
                    setFieldLockState(inputNoHp, false);
                    updateNipCounter(inputNip, 18, 'nipMsg');

                    if (badgeStatus) {
                        badgeStatus.innerHTML = '<i class="fa-solid fa-pen-to-square"></i> Input Manual';
                        badgeStatus.className = 'badge-status badge-status-manual';
                    }

                    if (autofillBanner) {
                        autofillBanner.style.display = 'none';
                    }
                }
            }

            if (selectGuru) {
                selectGuru.addEventListener('change', handleGuruSelection);
                if (selectGuru.value) {
                    handleGuruSelection();
                }
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
                        banner.style.display = 'flex';
                        banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        banner.style.display = 'none';
                    }
                });
            }
        });

        /* --- FITUR BARU: PENUGASAN WALI KELAS BARU SECARA CEPAT DAN BANYAK (BULK) --- */
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

            // 1. Group selects by teacherId (ignore 'none' and empty '')
            selects.forEach(sel => {
                const val = sel.value;
                // Reset errors first
                sel.style.borderColor = '#93c5fd';
                sel.style.backgroundColor = '#ffffff';
                const errDiv = sel.parentNode.querySelector('.bulk-field-error');
                if (errDiv) errDiv.style.display = 'none';

                if (val && val !== 'none') {
                    if (!teacherMap[val]) teacherMap[val] = [];
                    teacherMap[val].push(sel);
                }
            });

            // 2. Identify duplicate teacher assignments in the bulk table
            Object.keys(teacherMap).forEach(teacherId => {
                const selList = teacherMap[teacherId];
                if (selList.length > 1) {
                    const selectedOpt = selList[0].options[selList[0].selectedIndex];
                    const namaGuru = selectedOpt ? selectedOpt.getAttribute('data-nama') || selectedOpt.text : 'Guru ID ' + teacherId;
                    const kelasNames = selList.map(s => s.getAttribute('data-nama-kelas')).join(', ');

                    conflicts.push(`Guru <strong>${namaGuru}</strong> dipilih untuk ${selList.length} kelas sekaligus (${kelasNames}). Satu guru hanya dapat menjadi Wali Kelas di 1 kelas.`);

                    selList.forEach(s => {
                        s.style.borderColor = '#ef4444';
                        s.style.backgroundColor = '#fef2f2';
                        const errDiv = s.parentNode.querySelector('.bulk-field-error');
                        if (errDiv) {
                            errDiv.textContent = '⚠️ Bentrok! Guru ini juga dipilih di kelas lain.';
                            errDiv.style.display = 'block';
                        }
                    });
                }
            });

            // 3. Update alert banner and submit button state
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
                if (alertBanner) alertBanner.style.display = 'flex';
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.5';
                    submitBtn.style.cursor = 'not-allowed';
                }
            } else {
                if (alertBanner) alertBanner.style.display = 'none';
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.style.cursor = 'pointer';
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
    </script>
@endsection
