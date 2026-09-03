@extends('layouts.admin')

@section('title', 'Daftar Guru Piket — EDU JOURNAL')

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

    /* Action Buttons in Table */
    .action-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-action-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        line-height: 1.2;
        white-space: nowrap;
    }

    .btn-action-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }

    .btn-action-view {
        background: #e0f2fe;
        color: #0369a1;
        border-color: #bae6fd;
    }
    .btn-action-view:hover {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
    }

    .btn-action-edit {
        background: #fef3c7;
        color: #92400e;
        border-color: #fde68a;
    }
    .btn-action-edit:hover {
        background: #d97706;
        color: #ffffff;
        border-color: #d97706;
    }

    .btn-action-key {
        background: #f3e8ff;
        color: #6b21a8;
        border-color: #e9d5ff;
    }
    .btn-action-key:hover {
        background: #7e22ce;
        color: #ffffff;
        border-color: #7e22ce;
    }

    .password-input-wrapper {
        position: relative;
        width: 100%;
    }
    .password-input-wrapper input {
        padding-right: 42px !important;
    }
    .password-toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #64748b;
        cursor: pointer;
        font-size: 14px;
        padding: 4px;
        transition: color 0.2s ease;
        z-index: 10;
    }
    .password-toggle-btn:hover {
        color: #334155;
    }

    .btn-action-delete {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fecaca;
    }
    .btn-action-delete:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }

    .btn-action-approve {
        background: #d1fae5;
        color: #065f46;
        border-color: #a7f3d0;
    }
    .btn-action-approve:hover {
        background: #059669;
        color: #ffffff;
        border-color: #059669;
    }

    .btn-action-reject {
        background: #ffe4e6;
        color: #9f1239;
        border-color: #fecdd3;
    }
    .btn-action-reject:hover {
        background: #e11d48;
        color: #ffffff;
        border-color: #e11d48;
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

    /* Modal Backdrop & Box */
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
    }

    .modal-backdrop.show {
        display: flex;
    }

    .modal-box {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        animation: modalSlide 0.2s ease-out;
    }

    @keyframes modalSlide {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        padding: 20px 24px;
        background: #2b3655;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 {
        font-size: 17px;
        font-weight: 700;
    }

    .modal-close {
        background: transparent;
        border: none;
        color: #ffffff;
        font-size: 18px;
        cursor: pointer;
        opacity: 0.8;
    }
    .modal-close:hover { opacity: 1; }

    .modal-body {
        padding: 24px;
        max-height: 75vh;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn-secondary {
        background: #e2e8f0;
        color: #334155;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-primary {
        background: #4f46e5;
        color: #ffffff;
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Kelola Guru Piket</h1>
            <p>Pengaturan tugas guru piket harian dan pendaftaran akun piket sekolah</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <i class="fa-solid fa-clipboard-user" style="color:#2563eb;"></i>
        <span>Master Data Guru Piket</span>
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

    <!-- Card 1: Form Tambah Guru Piket Baru -->
    <div class="card" style="{{ count($guruPikets) > 0 ? 'background: #f8fafc; border-color: #cbd5e1;' : '' }}">
        <div class="card-top-header">
            <div>
                <h2>
                    <i class="fa-solid {{ count($guruPikets) > 0 ? 'fa-lock' : 'fa-user-plus' }}" style="color: {{ count($guruPikets) > 0 ? '#94a3b8' : '#2563eb' }};"></i> 
                    Tambah Guru Piket Baru
                    @if(count($guruPikets) > 0)
                        <span style="font-size: 11.5px; font-weight: 800; background: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 4px 10px; border-radius: 20px; margin-left: 8px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-lock"></i> FITUR TERKUNCI (Maks. 1 Akun Piket)
                        </span>
                    @endif
                </h2>
                <p>Masukkan data petugas piket untuk pendaftaran hak akses piket harian. Akun juga tersimpan di Master Data Pengguna.</p>
            </div>
            <a href="{{ route('admin.guru-piket.trash') }}" class="btn-trash">
                <i class="fa-solid fa-trash-can"></i> Lihat Tong Sampah
                @if(isset($trashedCount) && $trashedCount > 0)
                    <span class="badge-count">{{ $trashedCount }}</span>
                @endif
            </a>
        </div>

        @if(count($guruPikets) > 0)
            <!-- Lock Warning Banner -->
            <div class="alert-custom" style="background:#fffbebf0; color:#92400e; border:1px solid #fcd34d; margin-bottom:20px; display:flex; align-items:center; gap:12px;">
                <i class="fa-solid fa-lock" style="font-size:22px; color:#d97706; flex-shrink:0;"></i>
                <div>
                    <strong style="font-size:14px; font-weight:800; display:block;">Fitur Tambah Guru Piket Baru Dikunci</strong>
                    <span style="font-size:13px; font-weight:600; opacity:0.95;">
                        Sistem dirancang hanya menggunakan <strong>1 akun Guru Piket</strong>. Karena data akun Guru Piket saat ini masih terdaftar pada <strong>Daftar Petugas Piket Terdaftar</strong> di bawah, fitur Tambah Guru Piket Baru ini otomatis dikunci. Jika ingin menambah/mengganti akun baru, hapus data akun yang ada terlebih dahulu.
                    </span>
                </div>
            </div>
        @endif

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

        <form id="formGuruPiket" action="{{ route('admin.guru-piket.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-grid-3" style="{{ count($guruPikets) > 0 ? 'opacity: 0.6; pointer-events: none;' : '' }}">
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="nip" style="margin-bottom: 0;">NIP (18 Digit) <span style="color:#ef4444;">*</span></label>
                        <span id="nipCounter" style="font-size: 12px; font-weight: 700; color: #ef4444;">0/18 digit</span>
                    </div>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                        class="form-control @error('nip') is-invalid @enderror"
                        placeholder="Contoh: 198501012010011001" maxlength="18" minlength="18" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18); updateNipCounter(this, 18, 'nipMsg');"
                        {{ count($guruPikets) > 0 ? 'disabled readonly' : '' }} required>
                    <small id="nipMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi tepat 18 digit angka.</small>
                    @error('nip')
                        <small style="color:#ef4444; font-weight:600;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nama Lengkap Petugas Piket <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap Beserta Gelar" {{ count($guruPikets) > 0 ? 'disabled readonly' : '' }} required>
                    @error('name')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" {{ count($guruPikets) > 0 ? 'disabled' : '' }}>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="no_hp">Nomor HP / WhatsApp</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                        class="form-control @error('no_hp') is-invalid @enderror"
                        placeholder="Contoh: 081234567890" maxlength="15" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15);"
                        {{ count($guruPikets) > 0 ? 'disabled readonly' : '' }}>
                    @error('no_hp')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password Akun Login <span style="color:#ef4444;">*</span></label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Minimal 6 karakter" minlength="6"
                        oninput="checkPasswordMinLength(this, 'passwordMsg');"
                        {{ count($guruPikets) > 0 ? 'disabled readonly' : '' }} required>
                    <small id="passwordMsg" style="display:block; font-size:12px; font-weight:600; margin-top:4px; color:#ef4444;">Wajib diisi minimal 6 karakter.</small>
                    @error('password')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="btn-submit-container">
                @if(count($guruPikets) > 0)
                    <button type="button" class="btn-submit" style="background: #94a3b8; color: #ffffff; cursor: not-allowed; box-shadow: none;" disabled title="Fitur Tambah Guru Piket dikunci karena akun guru piket sudah terdaftar">
                        <i class="fa-solid fa-lock"></i> Fitur Dikunci (Akun Guru Piket Sudah Ada)
                    </button>
                @else
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Data Guru Piket
                    </button>
                @endif
            </div>
        </form>
    </div>

    <!-- Card 2: Daftar Data Guru Piket -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-users" style="color:#3b5490;"></i> Daftar Petugas Piket Terdaftar ({{ count($guruPikets) }})</h2>
                <p>Kelola seluruh akun petugas piket yang aktif di sistem.</p>
            </div>

            <form action="{{ route('admin.guru-piket') }}" method="GET" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" name="search" value="{{ $search }}" class="form-control" style="width:240px; padding-left:36px;" placeholder="Cari nama / NIP / username...">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                </div>
                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('admin.guru-piket') }}" class="btn-reset">Reset</a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width:50px;">NO</th>
                        <th>NAMA PETUGAS PIKET</th>
                        <th>NIP / USERNAME</th>
                        <th>JK</th>
                        <th>NO HP</th>
                        <th>STATUS VERIFIKASI</th>
                        <th style="text-align:center; min-width: 320px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruPikets as $index => $u)
                        <tr onclick="openDetailModal({{ json_encode($u) }})" style="cursor: pointer;" title="Klik baris data ini untuk melihat rincian detail akun {{ $u->name }}">
                            <td><strong>{{ $index + 1 }}</strong></td>
                            <td>
                                <strong>{{ $u->name }}</strong>
                                <div style="font-size:12px; color:#64748b; margin-top:2px;">Role: Petugas Piket</div>
                            </td>
                            <td>
                                <span style="font-family:monospace; font-weight:700; color:#3b5490;">{{ $u->nip }}</span>
                                <div style="font-size:12px; color:#64748b;">User: {{ $u->username ?? '-' }}</div>
                            </td>
                            <td>
                                @if(optional($u->guru)->jenis_kelamin == 'L')
                                    <span class="badge-jk badge-jk-l">Laki-laki</span>
                                @elseif(optional($u->guru)->jenis_kelamin == 'P')
                                    <span class="badge-jk badge-jk-p">Perempuan</span>
                                @else
                                    <span style="color:#94a3b8;">-</span>
                                @endif
                            </td>
                            <td>
                                <div>{{ optional($u->guru)->no_hp ?? '-' }}</div>
                            </td>
                            <td>
                                @if($u->status_verifikasi === 'verified')
                                    <span style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 800;">
                                        <i class="fa-solid fa-circle-check"></i> Terverifikasi
                                    </span>
                                @else
                                    <span style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 800;">
                                        <i class="fa-solid fa-clock"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td style="text-align:center;" onclick="event.stopPropagation();">
                                <div class="action-buttons">
                                    @if($u->status_verifikasi === 'pending')
                                        <form action="{{ route('admin.verifikasi-guru.approve', $u->id) }}" method="POST" style="display:inline-flex;">
                                            @csrf
                                            <button type="submit" class="btn-action-badge btn-action-approve" title="Setujui Akun Piket">
                                                <i class="fa-solid fa-circle-check"></i> <span>Setujui</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.verifikasi-guru.reject', $u->id) }}" method="POST" style="display:inline-flex;">
                                            @csrf
                                            <button type="submit" class="btn-action-badge btn-action-reject" title="Tolak Akun Piket">
                                                <i class="fa-solid fa-circle-xmark"></i> <span>Tolak</span>
                                            </button>
                                        </form>
                                    @else
                                        <!-- 1. LIHAT (Detail) -->
                                        <button type="button" class="btn-action-badge btn-action-view" onclick="openDetailModal({{ json_encode($u) }})" title="Lihat Detail Profil">
                                            <i class="fa-solid fa-eye"></i> <span>Detail</span>
                                        </button>

                                        <!-- 2. EDIT -->
                                        <button type="button" class="btn-action-badge btn-action-edit" onclick="openEditModal({{ json_encode($u) }})" title="Edit Data & Hak Akses">
                                            <i class="fa-solid fa-pen-to-square"></i> <span>Edit</span>
                                        </button>

                                        <!-- 3. UBAH PASSWORD -->
                                        <button type="button" class="btn-action-badge btn-action-key" onclick="openResetPasswordModal({{ $u->id }}, '{{ addslashes($u->name) }}')" title="Ubah Password Akun">
                                            <i class="fa-solid fa-key"></i> <span>Ubah Pass</span>
                                        </button>

                                        <!-- 4. HAPUS (Soft Delete) -->
                                        @if($u->id !== Auth::id())
                                            <form action="{{ route('admin.guru-piket.destroy', $u->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-badge btn-action-delete" onclick="return confirm('Apakah Anda yakin ingin memindahkan {{ addslashes($u->name) }} ke Tempat Sampah?')" title="Hapus Guru Piket">
                                                    <i class="fa-solid fa-trash-can"></i> <span>Hapus</span>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:36px; color:#94a3b8;">
                                <i class="fa-solid fa-folder-open" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                Belum ada data Guru Piket yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- ─────────────────────────────────────────────────────────────────────────── -->
    <!-- MODALS SECTION -->
    <!-- ─────────────────────────────────────────────────────────────────────────── -->

    <!-- Modal 1: Edit Data & Role -->
    <div class="modal-backdrop" id="modalEditUser">
        <div class="modal-box">
            <div class="modal-header">
                <h3><i class="fa-solid fa-user-pen" style="margin-right:8px;"></i> Ubah Data & Status Guru Piket</h3>
                <button class="modal-close" onclick="closeModal('modalEditUser')">&times;</button>
            </div>
            <form id="formEditUser" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>

                    <div style="display:flex; gap:12px;">
                        <div class="form-group" style="flex:1;">
                            <label>NIP *</label>
                            <input type="text" name="nip" id="edit_nip" class="form-control" maxlength="18" required>
                        </div>
                        <div class="form-group" style="flex:1;">
                            <label>Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>
                    </div>

                    <div style="display:flex; gap:12px;">
                        <div class="form-group" style="flex:1;">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="edit_jk" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group" style="flex:1;">
                            <label>Nomor HP / WA</label>
                            <input type="text" name="no_hp" id="edit_no_hp" class="form-control" placeholder="081234567890">
                        </div>
                    </div>

                    <div style="display:flex; gap:12px;">
                        <div class="form-group" style="flex:1;">
                            <label>Role Hak Akses *</label>
                            <select name="role" id="edit_role" class="form-control" required>
                                <option value="piket">Guru Piket</option>
                                <option value="guru">Guru Mapel</option>
                                <option value="wali_kelas">Wali Kelas</option>
                                <option value="tu">Admin / TU (Tata Usaha)</option>
                            </select>
                        </div>

                        <div class="form-group" style="flex:1;">
                            <label>Status Verifikasi *</label>
                            <select name="status_verifikasi" id="edit_status" class="form-control" required>
                                <option value="verified">Verified (Disetujui)</option>
                                <option value="pending">Pending (Menunggu)</option>
                                <option value="rejected">Rejected (Ditolak)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('modalEditUser')">Batal</button>
                    <button type="submit" class="btn-primary">Update Data Akun</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal 2: Ubah Password -->
    <div class="modal-backdrop" id="modalResetPassword">
        <div class="modal-box">
            <div class="modal-header" style="background:#4c1d95;">
                <h3><i class="fa-solid fa-key" style="margin-right:8px;"></i> Ubah Sandi Guru Piket</h3>
                <button class="modal-close" onclick="closeModal('modalResetPassword')">&times;</button>
            </div>
            <form id="formResetPassword" method="POST" onsubmit="return validateResetPasswordSubmit(event)">
                @csrf
                <div class="modal-body">
                    <p style="font-size:14px; color:#475569; margin-bottom:16px;">
                        Anda akan mengubah password untuk akun: <strong id="reset_user_name" style="color:#0f172a;"></strong>
                    </p>

                    <div class="form-group" style="margin-bottom:16px;">
                        <label>Password Baru *</label>
                        <div class="password-input-wrapper">
                            <input type="password" id="reset_password" name="password" class="form-control" placeholder="Minimal 6 karakter" minlength="6" required oninput="validateResetPasswordMatch()">
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('reset_password', this)" title="Tampilkan/Sembunyikan Password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:16px;">
                        <label>Konfirmasi Password Baru *</label>
                        <div class="password-input-wrapper">
                            <input type="password" id="reset_password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" minlength="6" required oninput="validateResetPasswordMatch()">
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('reset_password_confirmation', this)" title="Tampilkan/Sembunyikan Password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <small id="resetPasswordMatchMsg" style="display:none; font-size:13px; font-weight:600; margin-top:-6px; margin-bottom:12px;"></small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('modalResetPassword')">Batal</button>
                    <button type="submit" class="btn-primary" style="background:#7c3aed;">Simpan Password Baru</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal 3: View Detail -->
    <div class="modal-backdrop" id="modalDetailUser">
        <div class="modal-box">
            <div class="modal-header">
                <h3><i class="fa-solid fa-id-card" style="margin-right:8px;"></i> Detail Akun Guru Piket</h3>
                <button class="modal-close" onclick="closeModal('modalDetailUser')">&times;</button>
            </div>
            <div class="modal-body">
                <table style="width:100%; border-collapse:collapse; font-size:14px;">
                    <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Nama Lengkap:</td><td id="detail_name" style="font-weight:700; color:#0f172a;"></td></tr>
                    <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">NIP:</td><td id="detail_nip" style="font-weight:700; color:#0f172a;"></td></tr>
                    <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Jenis Kelamin:</td><td id="detail_jk" style="font-weight:700; color:#0f172a;"></td></tr>
                    <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Nomor HP / WA:</td><td id="detail_no_hp" style="font-weight:700; color:#0f172a;"></td></tr>
                    <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Username:</td><td id="detail_username"></td></tr>
                    <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Email:</td><td id="detail_email"></td></tr>
                    <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Role:</td><td id="detail_role"></td></tr>
                    <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Status Verifikasi:</td><td id="detail_status"></td></tr>
                    <tr><td style="padding:8px 0; color:#64748b; font-weight:600;">Dibuat Pada:</td><td id="detail_created_at"></td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('modalDetailUser')">Tutup</button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
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

    function checkPasswordMinLength(input, msgId = 'passwordMsg') {
        const msgEle = document.getElementById(msgId);
        if (!msgEle) return;
        const len = input.value.length;
        if (len === 0) {
            msgEle.textContent = 'Wajib diisi minimal 6 karakter.';
            msgEle.style.color = '#ef4444';
        } else if (len < 6) {
            msgEle.textContent = 'Password terlalu pendek, baru ' + len + ' karakter (minimal 6 karakter).';
            msgEle.style.color = '#ef4444';
        } else {
            msgEle.textContent = '✓ Password memenuhi syarat (minimal 6 karakter).';
            msgEle.style.color = '#10b981';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const nip = document.getElementById('nip');
        if (nip) updateNipCounter(nip, 18, 'nipMsg');

        const form = document.getElementById('formGuruPiket');
        if (form) {
            form.addEventListener('submit', function(e) {
                const errors = [];
                const nipVal  = document.getElementById('nip').value.trim();
                const namaVal = document.getElementById('name').value.trim();
                const passVal = document.getElementById('password').value;

                if (!nipVal) {
                    errors.push('NIP wajib diisi 18 digit angka.');
                } else if (nipVal.length !== 18) {
                    errors.push('NIP harus berisi tepat 18 digit angka (saat ini baru ' + nipVal.length + ' digit).');
                }

                if (!namaVal) {
                    errors.push('Nama Lengkap Petugas Piket wajib diisi.');
                }

                if (!passVal) {
                    errors.push('Password akun login wajib diisi minimal 6 karakter.');
                } else if (passVal.length < 6) {
                    errors.push('Password akun login minimal 6 karakter (saat ini baru ' + passVal.length + ' karakter).');
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

    function openModal(id) {
        document.getElementById(id).classList.add('show');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function openEditModal(user) {
        document.getElementById('formEditUser').action = '/admin/verifikasi-guru/' + user.id + '/update-role';
        document.getElementById('edit_name').value = user.name || '';
        document.getElementById('edit_nip').value = user.nip || '';
        document.getElementById('edit_email').value = user.email || '';
        document.getElementById('edit_role').value = user.role || 'piket';
        document.getElementById('edit_status').value = user.status_verifikasi || 'verified';
        
        let jkVal = (user.guru && user.guru.jenis_kelamin) ? user.guru.jenis_kelamin : (user.jenis_kelamin || '');
        let noHpVal = (user.guru && user.guru.no_hp) ? user.guru.no_hp : (user.no_hp || '');
        
        if (document.getElementById('edit_jk')) document.getElementById('edit_jk').value = jkVal;
        if (document.getElementById('edit_no_hp')) document.getElementById('edit_no_hp').value = noHpVal;

        openModal('modalEditUser');
    }

    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (!input) return;
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            if (icon) {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        } else {
            input.type = 'password';
            if (icon) {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    }

    function openResetPasswordModal(userId, userName) {
        document.getElementById('formResetPassword').action = '/admin/users/' + userId + '/reset-password';
        document.getElementById('reset_user_name').innerText = userName;

        const pass = document.getElementById('reset_password');
        const confirmPass = document.getElementById('reset_password_confirmation');
        const msg = document.getElementById('resetPasswordMatchMsg');

        if (pass) {
            pass.value = '';
            pass.type = 'password';
        }
        if (confirmPass) {
            confirmPass.value = '';
            confirmPass.type = 'password';
        }
        if (msg) {
            msg.style.display = 'none';
        }
        const toggleBtns = document.querySelectorAll('#modalResetPassword .password-toggle-btn i');
        toggleBtns.forEach(icon => {
            icon.className = 'fa-solid fa-eye';
        });

        openModal('modalResetPassword');
    }

    function validateResetPasswordMatch() {
        const pass = document.getElementById('reset_password');
        const confirmPass = document.getElementById('reset_password_confirmation');
        const msg = document.getElementById('resetPasswordMatchMsg');

        if (!pass || !confirmPass || !msg) return true;

        const passVal = pass.value;
        const confirmVal = confirmPass.value;

        if (!passVal && !confirmVal) {
            msg.style.display = 'none';
            return true;
        }

        if (passVal.length > 0 && passVal.length < 6) {
            msg.style.display = 'block';
            msg.style.color = '#ef4444';
            msg.innerHTML = '<i class="fa-solid fa-circle-xmark" style="margin-right:4px;"></i> Password minimal 6 karakter.';
            return false;
        }

        if (confirmVal.length > 0) {
            if (passVal === confirmVal) {
                msg.style.display = 'block';
                msg.style.color = '#10b981';
                msg.innerHTML = '<i class="fa-solid fa-circle-check" style="margin-right:4px;"></i> Konfirmasi password cocok.';
                return true;
            } else {
                msg.style.display = 'block';
                msg.style.color = '#ef4444';
                msg.innerHTML = '<i class="fa-solid fa-circle-xmark" style="margin-right:4px;"></i> Konfirmasi password baru tidak cocok.';
                return false;
            }
        } else {
            msg.style.display = 'none';
            return false;
        }
    }

    function validateResetPasswordSubmit(event) {
        const pass = document.getElementById('reset_password');
        const confirmPass = document.getElementById('reset_password_confirmation');

        if (pass && confirmPass) {
            if (pass.value.length < 6) {
                alert('Password minimal 6 karakter.');
                pass.focus();
                event.preventDefault();
                return false;
            }
            if (pass.value !== confirmPass.value) {
                alert('Konfirmasi Password Baru tidak cocok dengan Password Baru! Harap periksa kembali.');
                confirmPass.focus();
                event.preventDefault();
                return false;
            }
        }
        return true;
    }

    function openDetailModal(user) {
        document.getElementById('detail_name').innerText = user.name || '-';
        document.getElementById('detail_nip').innerText = user.nip || '-';
        document.getElementById('detail_username').innerText = user.username || '-';
        document.getElementById('detail_email').innerText = user.email || '-';
        document.getElementById('detail_role').innerText = user.role ? user.role.toUpperCase() : 'PIKET';
        document.getElementById('detail_status').innerText = user.status_verifikasi ? user.status_verifikasi.toUpperCase() : '-';
        document.getElementById('detail_created_at').innerText = user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID') : '-';

        let jkText = '-';
        if (user.guru && user.guru.jenis_kelamin) {
            jkText = user.guru.jenis_kelamin === 'L' ? 'Laki-laki' : (user.guru.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        } else if (user.jenis_kelamin) {
            jkText = user.jenis_kelamin === 'L' ? 'Laki-laki' : (user.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        }
        let noHpText = (user.guru && user.guru.no_hp) ? user.guru.no_hp : (user.no_hp || '-');

        if (document.getElementById('detail_jk')) document.getElementById('detail_jk').innerText = jkText;
        if (document.getElementById('detail_no_hp')) document.getElementById('detail_no_hp').innerText = noHpText;

        openModal('modalDetailUser');
    }
</script>
@endsection
