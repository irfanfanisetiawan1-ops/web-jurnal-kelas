@extends('layouts.admin')

@section('title', 'Manajemen Data Siswa — EDU JOURNAL')

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
    .breadcrumb-text a {
        color: #3b5490;
        text-decoration: none;
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

    /* Filter Select Placeholder (Samar / Soft Gray seperti input cari) */
    .filter-select {
        width: 100%;
        color: #94a3b8 !important;
        font-weight: 500 !important;
        font-size: 13.5px;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        padding: 10px 14px;
        outline: none;
        transition: all 0.2s ease;
    }
    .filter-select:focus {
        border-color: #3b5490;
        box-shadow: 0 0 0 3px rgba(59, 84, 144, 0.15);
    }
    .filter-select.has-value {
        color: #0f172a !important;
        font-weight: 700 !important;
        border-color: #3b5490;
    }
    .filter-select option {
        color: #1e293b;
        font-weight: 600;
    }
    .filter-select option[value=""] {
        color: #94a3b8;
        font-weight: 500;
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
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Master Data — Siswa</h1>
            <p>Kelola data induk siswa, NISN, status kelas, dan riwayat pendaftaran siswa</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <i class="fa-solid fa-graduation-cap"></i>
        <span>Manajemen Data Siswa</span>
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

    <!-- Card 1: Form Tambah Siswa Baru -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2>Tambah Siswa Baru</h2>
                <p>Masukkan detail data siswa untuk pendaftaran siswa baru.</p>
            </div>
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('siswa.alumni') }}" class="btn-alumni">
                    <i class="fa-solid fa-user-graduate"></i> Data Siswa Alumni
                    @if(isset($alumniCount) && $alumniCount > 0)
                        <span class="badge-count">{{ $alumniCount }}</span>
                    @endif
                </a>
                <a href="{{ route('siswa.trash') }}" class="btn-trash">
                    <i class="fa-solid fa-trash-can"></i> Lihat Tong Sampah
                    @if(isset($trashedCount) && $trashedCount > 0)
                        <span class="badge-count">{{ $trashedCount }}</span>
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
        </div>
    </div>

    <!-- Card 1.5: Form Tambah Siswa Baru Secara Cepat dan Banyak -->
    <div class="card" style="border-top: 4px solid #10b981;">
        <div class="card-top-header">
            <div>
                <h2 style="margin: 0;">Tambah Siswa Baru Secara Cepat dan Banyak</h2>
            </div>
        </div>

        @if($errors->has('siswa'))
            <div class="alert-custom alert-error" style="margin-bottom: 20px;">
                <div style="display:flex; align-items:flex-start; gap:12px;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size:22px; color:#dc2626; flex-shrink:0; margin-top:2px;"></i>
                    <div>
                        <h4 style="font-size:15px; font-weight:800; margin:0 0 4px 0; color:#9f1239;">Gagal Menyimpan Data Siswa Massal!</h4>
                        <p style="margin:0; font-size:13.5px; color:#881337;">{{ $errors->first('siswa') }}</p>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <!-- Alert Banner Alasan Gagal Simpan Bulk (JS Generated) -->
        <div id="bulkErrorReasonBanner" class="alert-custom alert-error" style="display: none; margin-bottom: 20px;">
            <div style="display:flex; align-items:flex-start; gap:12px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:22px; color:#dc2626; flex-shrink:0; margin-top:2px;"></i>
                <div>
                    <h4 style="font-size:15px; font-weight:800; margin:0 0 4px 0; color:#9f1239;">Data masal belum bisa disimpan! Silakan perbaiki pengisian berikut:</h4>
                    <ul id="bulkErrorReasonList" style="margin: 4px 0 0 18px; padding: 0; font-size: 13.5px; color: #881337; line-height: 1.6;"></ul>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('bulkErrorReasonBanner').style.display='none'" style="background:none; border:none; color:inherit; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form id="formSiswaBulk" action="{{ route('siswa.store-batch') }}" method="POST" novalidate>
            @csrf

            <!-- Selection Kelas Target (Per Kelas) -->
            <div class="form-group" style="max-width: 480px; margin-bottom: 20px;">
                <label for="bulk_id_kelas" style="font-size: 14px; font-weight: 800; color: #0f172a;">
                    Pilih Kelas Target (Per Kelas) <span style="color:#ef4444;">*</span>
                </label>
                <select id="bulk_id_kelas" name="id_kelas" class="form-control @error('id_kelas') is-invalid @enderror" required style="border-color: #10b981; font-weight: 700;">
                    <option value="">-- Pilih Kelas Target --</option>
                    @foreach($kelass as $k)
                        <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} (Estimasi Kapasitas: {{ $k->jumlah_siswa }} Siswa)
                        </option>
                    @endforeach
                </select>
                <small style="display:block; font-size:12px; color:#64748b; margin-top:4px;">
                    <i class="fa-solid fa-circle-info"></i> Seluruh data siswa yang diisi di bawah akan dimasukkan langsung ke kelas ini.
                </small>
                @error('id_kelas')
                    <small style="color:#ef4444; font-weight:600; display:block; margin-top:4px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                @enderror
            </div>

            <!-- Table Input Massal Siswa -->
            <div class="table-responsive" style="margin-bottom: 20px; border-color: #cbd5e1;">
                <table class="table-custom" id="tableBulkSiswa" style="min-width: 1100px;">
                    <thead>
                        <tr style="background: #f0fdf4;">
                            <th style="width: 45px; text-align: center;">NO</th>
                            <th style="width: 140px;">NIS (3-10 DIGIT) <span style="color:#ef4444;">*</span></th>
                            <th style="width: 140px;">NISN (10 DIGIT) <span style="color:#ef4444;">*</span></th>
                            <th style="width: 200px;">NAMA LENGKAP SISWA <span style="color:#ef4444;">*</span></th>
                            <th style="width: 130px;">JENIS KELAMIN <span style="color:#ef4444;">*</span></th>
                            <th style="width: 150px;">KOTA LAHIR <span style="color:#64748b; font-size:10px;">(Opsional)</span></th>
                            <th style="width: 150px;">TGL LAHIR <span style="color:#ef4444;">*</span></th>
                            <th>ALAMAT LENGKAP <span style="color:#64748b; font-size:10px;">(Opsional)</span></th>
                            <th style="width: 90px; text-align: center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="bulkTableBody">
                        <!-- Dynamic Rows injected via JS -->
                    </tbody>
                </table>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-top: 16px;">
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <button type="button" class="btn-filter" style="background: #64748b; margin:0; padding: 9px 16px; font-size: 12.5px;" onclick="addBulkRow()">
                        <i class="fa-solid fa-plus"></i> Tambah Baris Siswa
                    </button>
                    <button type="button" class="btn-filter" style="background: #64748b; margin:0; padding: 9px 16px; font-size: 12.5px;" onclick="addMultipleBulkRows(5)">
                        <i class="fa-solid fa-plus"></i> +5 Baris
                    </button>
                    <button type="button" class="btn-reset" onclick="resetAllBulkFields()" title="Kosongkan isian data pada seluruh baris tabel siswa" style="margin:0; padding: 9px 16px; font-size: 12.5px; background: #fbbf24; color: #78350f; border: 1px solid #fde68a; font-weight: 700;">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </button>
                    <button type="button" class="btn-reset" onclick="clearBulkRows()" title="Hapus seluruh baris tabel siswa" style="margin:0; padding: 9px 16px; font-size: 12.5px;">
                        <i class="fa-solid fa-trash-can"></i> Kosongkan Tabel
                    </button>
                    <span style="font-size: 13px; font-weight: 700; color: #475569; margin-left: 8px;">
                        Total: <span id="totalBulkRowsCount" style="color: #2563eb;">0</span> baris siswa
                    </span>
                </div>

                <div class="btn-submit-container" style="margin-top: 0;">
                    <button type="submit" class="btn-submit" style="background: #2563eb; padding: 11px 24px; font-size: 13.5px; border-radius: 10px; font-weight: 700; margin:0;">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Data Siswa
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Card 2: Daftar Data Siswa -->
    <div class="card">
        <div class="card-top-header" style="margin-bottom: 16px;">
            <div>
                <h2><i class="fa-solid fa-users" style="color:#3b5490;"></i> Daftar Data Siswa ({{ count($siswas) }})</h2>
                <p>Kelola dan pantau seluruh data siswa yang terdaftar dalam sistem.</p>
            </div>
            @if(isset($totalAktifCount) && $totalAktifCount > 0)
                <div style="font-size: 13px; font-weight: 700; color: #1e293b; background: #f1f5f9; padding: 6px 14px; border-radius: 20px; border: 1px solid #cbd5e1;">
                    Total Siswa Aktif: <strong style="color: #2563eb;">{{ $totalAktifCount }}</strong>
                </div>
            @endif
        </div>

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
                    @if(empty($search) && empty($tingkat) && empty($id_jurusan) && empty($id_kelas) && empty($jenis_kelamin))
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
                    <button type="button" id="btnBulkDelete" class="btn-action btn-delete" style="padding: 9px 16px; border-radius: 12px; font-size: 13px; opacity: 0.5; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(225,29,72,0.15); border: none;" disabled onclick="confirmBulkDelete()" title="Pilih siswa dengan mencentang checkbox untuk menghapus secara massal">
                        <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="bulkDeleteCount">0</span>)
                    </button>
                </div>
            </div>
        </form>

        <form id="formBulkDelete" action="{{ route('siswa.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

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
                                <td colspan="9" style="text-align:center; padding:36px; color:#94a3b8;">
                                    <i class="fa-solid fa-folder-open" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                    Belum ada data Siswa yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <form id="singleDeleteSiswaForm" action="" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <script>
        function deleteSingleSiswa(id, nama) {
            if (confirm(`Apakah Anda yakin ingin memindahkan ${nama} ke tempat sampah?`)) {
                const form = document.getElementById('singleDeleteSiswaForm');
                form.action = "{{ url('/siswa') }}/" + id;
                form.submit();
            }
        }

        function updateDigitCounter(input, counterId, targetLen, msgId, isNis = false) {
            const counter = document.getElementById(counterId);
            const msgEle  = document.getElementById(msgId);
            const len     = input.value.length;

            if (counter) {
                if (isNis) {
                    counter.textContent = len + '/10 digit';
                    counter.style.color = (len >= 3 && len <= 10) ? '#10b981' : '#ef4444';
                } else {
                    counter.textContent = len + '/' + targetLen + ' digit';
                    counter.style.color = (len === targetLen) ? '#10b981' : '#ef4444';
                }
            }

            if (msgEle) {
                if (isNis) {
                    if (len === 0) {
                        msgEle.textContent = 'Wajib diisi 3 hingga 10 digit angka.';
                        msgEle.style.color = '#ef4444';
                    } else if (len < 3) {
                        msgEle.textContent = 'Belum cukup, minimal 3 digit (kurang ' + (3 - len) + ' digit lagi).';
                        msgEle.style.color = '#ef4444';
                    } else {
                        msgEle.textContent = '✓ Format ' + len + ' digit angka sudah sesuai.';
                        msgEle.style.color = '#10b981';
                    }
                } else {
                    if (len === 0) {
                        msgEle.textContent = 'Wajib diisi tepat ' + targetLen + ' digit angka.';
                        msgEle.style.color = '#ef4444';
                    } else if (len < targetLen) {
                        msgEle.textContent = 'Belum lengkap, baru ' + len + ' digit (kurang ' + (targetLen - len) + ' digit lagi).';
                        msgEle.style.color = '#ef4444';
                    } else {
                        msgEle.textContent = '✓ Format ' + targetLen + ' digit angka sudah sesuai.';
                        msgEle.style.color = '#10b981';
                    }
                }
            }
        }

        /* JavaScript Fitur Input Massal Siswa Baru (Bulk) */
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
                badgeKelas = `<small style="display:block; font-size:10.5px; font-weight:800; color:#0284c7; margin-top:3px; background:#e0f2fe; padding:2px 6px; border-radius:6px;" title="Kelas dari file Excel">${kelasName}</small>`;
            }

            return `
                <tr id="bulkRow_${index}" class="bulk-siswa-row">
                    <td style="text-align:center; font-weight:700; color:#64748b;" class="row-number">
                        1
                        ${badgeKelas}
                        <input type="hidden" name="siswa[${index}][id_kelas]" class="bulk-id-kelas" value="${idKelasVal}">
                    </td>
                    <td>
                        <input type="text" name="siswa[${index}][nis]" value="${nisVal}"
                            class="form-control bulk-nis" placeholder="3-10 Digit" maxlength="10" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateBulkDigitCounter(this, 'counter_nis_${index}', 10, true);" required>
                        <small id="counter_nis_${index}" style="display:block; font-size:11px; font-weight:700; margin-top:2px; color:#ef4444;">0/10 digit</small>
                    </td>
                    <td>
                        <input type="text" name="siswa[${index}][nisn]" value="${nisnVal}"
                            class="form-control bulk-nisn" placeholder="10 Digit" maxlength="10" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); updateBulkDigitCounter(this, 'counter_nisn_${index}', 10);" required>
                        <small id="counter_nisn_${index}" style="display:block; font-size:11px; font-weight:700; margin-top:2px; color:#ef4444;">0/10 digit</small>
                    </td>
                    <td>
                        <input type="text" name="siswa[${index}][nama_siswa]" value="${namaVal}"
                            class="form-control bulk-nama" placeholder="Nama Lengkap Siswa" required>
                    </td>
                    <td>
                        <select name="siswa[${index}][jenis_kelamin]" class="form-control bulk-jk" required>
                            <option value="">-- Pilih --</option>
                            <option value="L" ${jkVal === 'L' ? 'selected' : ''}>Laki-laki</option>
                            <option value="P" ${jkVal === 'P' ? 'selected' : ''}>Perempuan</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="siswa[${index}][kota_lahir]" value="${kotaVal}"
                            class="form-control bulk-kota" placeholder="Opsional">
                    </td>
                    <td>
                        <input type="date" name="siswa[${index}][tanggal_lahir]" value="${tglVal}"
                            class="form-control bulk-tgl" required>
                    </td>
                    <td>
                        <input type="text" name="siswa[${index}][alamat_lengkap]" value="${alamatVal}"
                            class="form-control bulk-alamat" placeholder="Opsional">
                    </td>
                    <td style="text-align:center;">
                        <div style="display:flex; gap:4px; justify-content:center; align-items:center;">
                            <button type="button" class="btn-action btn-edit" style="background:#fef3c7; color:#b45309; border-color:#fde68a; padding:5px 8px; border-radius:8px;" onclick="resetSingleBulkRow(this)" title="Reset isian baris siswa ini">
                                <i class="fa-solid fa-rotate-left"></i>
                            </button>
                            <button type="button" class="btn-action btn-delete" style="padding:5px 8px; border-radius:8px;" onclick="removeBulkRow(this)" title="Hapus Baris">
                                <i class="fa-solid fa-trash-can"></i>
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
                // NIS valid: 3-10 digit
                counter.style.color = (len >= 3 && len <= 10) ? '#10b981' : '#ef4444';
            } else {
                // NISN valid: tepat 10 digit
                counter.style.color = (len === targetLen) ? '#10b981' : '#ef4444';
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

            if (nisInp)    { nisInp.value = ''; updateBulkDigitCounter(nisInp, nisInp.nextElementSibling?.id, 10); }
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
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tabel Belum Berisi Data!',
                        text: 'Belum ada baris tabel siswa yang dapat di-reset.',
                        confirmButtonColor: '#059669'
                    });
                }
                return;
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Reset Pengisian Semua Baris Siswa?',
                    text: 'Seluruh data pengisian (NIS, NISN, Nama, JK, Kota, Tgl Lahir, Alamat) pada semua baris tabel akan dikosongkan.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#fbbf24',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Reset Semua Baris!',
                    cancelButtonText: 'Batal'
                }).then((res) => {
                    if (res.isConfirmed) {
                        doResetAllBulkRowFields();
                    }
                });
            } else {
                if (confirm('Apakah Anda yakin ingin mengosongkan pengisian seluruh baris data siswa?')) {
                    doResetAllBulkRowFields();
                }
            }
        }

        function doResetAllBulkRowFields() {
            const rows = document.querySelectorAll('#bulkTableBody .bulk-siswa-row');
            rows.forEach(tr => {
                const nisInp    = tr.querySelector('.bulk-nis');
                const nisnInp   = tr.querySelector('.bulk-nisn');
                const namaInp   = tr.querySelector('.bulk-nama');
                const jkSel     = tr.querySelector('.bulk-jk');
                const kotaInp   = tr.querySelector('.bulk-kota');
                const tglInp    = tr.querySelector('.bulk-tgl');
                const alamatInp = tr.querySelector('.bulk-alamat');

                if (nisInp)    { nisInp.value = ''; updateBulkDigitCounter(nisInp, nisInp.nextElementSibling?.id, 10); }
                if (nisnInp)   { nisnInp.value = ''; updateBulkDigitCounter(nisnInp, nisnInp.nextElementSibling?.id, 10); }
                if (namaInp)   namaInp.value = '';
                if (jkSel)     jkSel.value = '';
                if (kotaInp)   kotaInp.value = '';
                if (tglInp)    tglInp.value = '';
                if (alamatInp) alamatInp.value = '';
            });
        }

        function resetBulkRows() {
            const tbody = document.getElementById('bulkTableBody');
            if (tbody) tbody.innerHTML = '';
            bulkRowIndex = 0;
            addMultipleBulkRows(3);
        }

        function clearBulkRows() {
            const tbody = document.getElementById('bulkTableBody');
            if (tbody) tbody.innerHTML = '';
            bulkRowIndex = 0;
            updateBulkRowCount();
        }

        /* JavaScript Fitur Hapus Terpilih (Bulk Delete Checkbox) */
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
            const checkedBoxes = document.querySelectorAll('.siswa-select-checkbox:checked');
            const count = checkedBoxes.length;

            if (count === 0) {
                alert('Silakan pilih minimal 1 data siswa yang ingin dihapus dengan mencentang kotak centang (checkbox).');
                return;
            }

            if (confirm(`Apakah Anda yakin ingin memindahkan ${count} data siswa yang dipilih ke tempat sampah?`)) {
                document.getElementById('formBulkDelete').submit();
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const selectAll = document.getElementById('selectAllSiswa');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.siswa-select-checkbox');
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateBulkDeleteState();
                });
            }

            const nis  = document.getElementById('nis');
            const nisn = document.getElementById('nisn');
            if (nis)  updateDigitCounter(nis, 'nisCounter', 10, 'nisMsg');
            if (nisn) updateDigitCounter(nisn, 'nisnCounter', 10, 'nisnMsg');

            // Inisialisasi Baris Input Massal (Bulk)
            const oldSiswaData = @json(old('siswa', []));
            if (Array.isArray(oldSiswaData) && oldSiswaData.length > 0) {
                oldSiswaData.forEach(item => addBulkRow(item));
            } else {
                addMultipleBulkRows(3);
            }

            // Validasi Form 1 Siswa (Card 1)
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

                    // Kota Lahir dan Alamat Lengkap bersifat opsional, tidak divalidasi

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

            // Validasi Form Massal / Bulk (Card 1.5)
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

                        // Kota Lahir dan Alamat Lengkap bersifat opsional, tidak divalidasi
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
                        banner.style.display = 'flex';
                        banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        banner.style.display = 'none';
                    }
                });
            }
        });
    </script>

    <!-- Library SheetJS untuk membaca file Excel (.xlsx, .xls, .csv) di Sisi Client -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <script>
        function syncTargetKelasToBulk(val) {
            const bulkSelect = document.getElementById('bulk_id_kelas');
            if (bulkSelect && val) {
                bulkSelect.value = val;
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const bulkSelect = document.getElementById('bulk_id_kelas');
            if (bulkSelect) {
                bulkSelect.addEventListener('change', function() {
                    const excelTargetSelect = document.getElementById('excel_target_kelas');
                    if (excelTargetSelect && this.value) {
                        excelTargetSelect.value = this.value;
                    }
                });
            }
        });

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
            if (nisInp)  updateDigitCounter(nisInp, 'nisCounter', 10, 'nisMsg');
            if (nisnInp) updateDigitCounter(nisnInp, 'nisnCounter', 10, 'nisnMsg');

            const banner = document.getElementById('formErrorReasonBanner');
            if (banner) banner.style.display = 'none';
        }

        function clearExcelFileInput() {
            const input = document.getElementById('excel_file_input');
            if (input) input.value = '';

            const excelTargetSelect = document.getElementById('excel_target_kelas');
            if (excelTargetSelect) excelTargetSelect.value = '';

            const excelModeSelect = document.getElementById('excel_import_mode');
            if (excelModeSelect) excelModeSelect.value = 'replace';

            const alertDiv = document.getElementById('excelProcessAlert');
            if (alertDiv) alertDiv.style.display = 'none';
        }

        function showExcelAlert(type, title, message, details = []) {
            const alertDiv = document.getElementById('excelProcessAlert');
            const alertIcon = document.getElementById('excelAlertIcon');
            const alertTitle = document.getElementById('excelAlertTitle');
            const alertMsg = document.getElementById('excelAlertMsg');
            const alertDetails = document.getElementById('excelAlertDetails');

            if (!alertDiv || !alertTitle || !alertMsg) return;

            if (type === 'success') {
                alertDiv.className = 'alert-custom alert-success';
                alertDiv.style.background = '#f0fdfa';
                alertDiv.style.borderColor = '#99f6e4';
                alertDiv.style.color = '#115e59';
                alertIcon.className = 'fa-solid fa-circle-check';
                alertIcon.style.color = '#0d9488';
                alertTitle.style.color = '#0f766e';
            } else if (type === 'warning') {
                alertDiv.className = 'alert-custom alert-warning';
                alertDiv.style.background = '#fffbeb';
                alertDiv.style.borderColor = '#fde68a';
                alertDiv.style.color = '#92400e';
                alertIcon.className = 'fa-solid fa-triangle-exclamation';
                alertIcon.style.color = '#f59e0b';
                alertTitle.style.color = '#78350f';
            } else {
                alertDiv.className = 'alert-custom alert-error';
                alertDiv.style.background = '#fef2f2';
                alertDiv.style.borderColor = '#fca5a5';
                alertDiv.style.color = '#991b1b';
                alertIcon.className = 'fa-solid fa-circle-exclamation';
                alertIcon.style.color = '#dc2626';
                alertTitle.style.color = '#7f1d1d';
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
                alertDetails.style.display = 'block';
            } else {
                alertDetails.style.display = 'none';
            }

            alertDiv.style.display = 'flex';
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

        function processExcelFile() {
            const fileInput = document.getElementById('excel_file_input');
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                showExcelAlert('warning', 'File Data Siswa Belum Dipilih!', 'Silakan pilih file Excel (.xlsx, .xls) atau CSV terlebih dahulu sebelum menekan tombol Proses.');
                return;
            }

            const file = fileInput.files[0];
            const fileName = file.name;

            if (typeof XLSX === 'undefined') {
                showExcelAlert('error', 'Library XLSX Belum Siap!', 'Sistem sedang memuat pustaka pembaca Excel. Silakan muat ulang halaman jika masalah berlanjut.');
                return;
            }

            const availableClasses = @json($kelass);

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

            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array', cellDates: true });

                    if (!workbook.SheetNames || workbook.SheetNames.length === 0) {
                        showExcelAlert('error', 'File Excel Kosong!', 'File Excel yang Anda pilih tidak memiliki sheet.');
                        return;
                    }

                    const parsedStudents = [];
                    const detectedClassesSet = new Set();
                    let totalSheetsRead = 0;

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

                            // 1. Detect Class Header line (e.g. "Kelas : X TKI 1" or "KELAS : XI RPL 2")
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

                            // 2. Detect Table Sub-Header line (NO., NISN, NAMA, N I S S, L/P, etc.)
                            let tempMap = { nis: -1, nisn: -1, nama_siswa: -1, jenis_kelamin: -1, kota_lahir: -1, tanggal_lahir: -1, alamat_lengkap: -1, kelas: -1 };
                            let foundHeaderColCount = 0;

                            rowF.forEach((cell, colIdx) => {
                                const txt = cleanStr(cell);
                                if (!txt) return;

                                if (txt === 'nisn' || txt.includes('nisn') || txt.includes('nomorinduksiswanasional')) {
                                    tempMap.nisn = colIdx;
                                    foundHeaderColCount++;
                                } else if (txt === 'nis' || txt === 'niss' || txt.includes('niss') || txt.includes('noinduk') || txt.includes('nomorinduk')) {
                                    tempMap.nis = colIdx;
                                    foundHeaderColCount++;
                                } else if (txt.includes('nama') || txt.includes('siswa') || txt.includes('student')) {
                                    tempMap.nama_siswa = colIdx;
                                    foundHeaderColCount++;
                                } else if (txt.includes('jeniskelamin') || txt.includes('jk') || txt === 'sex' || txt === 'gender' || txt.includes('kelamin') || txt === 'lp') {
                                    tempMap.jenis_kelamin = colIdx;
                                    foundHeaderColCount++;
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

                            // 3. Process Student Rows
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

                            if (!nis || nis.length < 5) continue;
                            if (!nisn || nisn.length !== 10) continue;

                            let jkClean = cleanStr(jkRaw);
                            let jenis_kelamin = 'L';
                            if (jkClean.startsWith('p') || jkClean.includes('perem') || jkClean.includes('wanita') || jkClean === 'female' || jkClean === 'f' || jkClean === '2') {
                                jenis_kelamin = 'P';
                            } else if (jkClean.startsWith('l') || jkClean.includes('laki') || jkClean.includes('pria') || jkClean === 'male' || jkClean === 'm' || jkClean === '1') {
                                jenis_kelamin = 'L';
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

                    if (parsedStudents.length === 0) {
                        showExcelAlert('error', 'Tidak Ada Data Siswa Valid!', 'File yang Anda unggah tidak mengandung data siswa yang dapat dibaca. Pastikan file berisi kolom NISN, Nama Siswa, dan Jenis Kelamin.');
                        return;
                    }

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

                    const msg = `Berhasil membaca <strong>${parsedStudents.length} data siswa</strong> dari ${totalSheetsRead} sheet dalam file (<em>${fileName}</em>) dan memasukkannya ke tabel pengisian massal.<br>`
                              + `<small style="display:block; margin-top:5px; font-size:12.5px;">`
                              + `<strong>Summary:</strong> ${classesSummary} | <strong>Mode:</strong> ${modeLabel}`
                              + `</small>`;

                    showExcelAlert('success', 'Proses File Data Siswa Berhasil!', msg);

                    const formBulk = document.getElementById('formSiswaBulk');
                    if (formBulk) {
                        formBulk.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }

                } catch(err) {
                    console.error('Error processing Excel file:', err);
                    showExcelAlert('error', 'Gagal Membaca File Excel / CSV!', 'Terjadi kesalahan saat membaca file: ' + err.message);
                }
            };
            reader.readAsArrayBuffer(file);
        }

        function updateSelectMutedState(select) {
            if (!select) return;
            if (select.value && select.value !== '' && select.value !== 'nama_asc') {
                select.classList.add('has-value');
            } else {
                select.classList.remove('has-value');
            }
        }

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

        document.addEventListener('DOMContentLoaded', function() {
            const tingkatVal = document.getElementById('filter_tingkat')?.value;
            if (tingkatVal) {
                filterKelasDropdown(tingkatVal);
            }
            document.querySelectorAll('.filter-select').forEach(select => {
                updateSelectMutedState(select);
            });
        });
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/mammoth@1.6.0/mammoth.browser.min.js"></script>

<script>
    if (typeof pdfjsLib !== 'undefined') {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    }

    function onSiswaFileSelected(input) {
        const hint = document.getElementById('importFileTypeHint');
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

    function processImportFile() {
        const input = document.getElementById('excel_file_input');
        if (!input || !input.files || input.files.length === 0) {
            showExcelAlert('error', 'Pilih File Terlebih Dahulu!', 'Silakan klik "Choose File" dan pilih file data siswa (.pdf, .docx, .doc, .xlsx, .xls, .csv).');
            return;
        }

        const file = input.files[0];
        const fileName = file.name;
        const ext = fileName.split('.').pop().toLowerCase();

        const loadingDiv = document.getElementById('importFileLoading');
        const loadingMsg = document.getElementById('importFileLoadingMsg');
        if (loadingDiv) loadingDiv.style.display = 'block';
        if (loadingMsg) loadingMsg.textContent = `Sedang membaca file (${fileName})...`;

        if (ext === 'pdf') {
            processPdfSiswaFile(file);
        } else if (ext === 'docx' || ext === 'doc') {
            processWordSiswaFile(file);
        } else if (ext === 'xlsx' || ext === 'xls' || ext === 'csv') {
            processExcelSiswaFile(file);
        } else {
            if (loadingDiv) loadingDiv.style.display = 'none';
            showExcelAlert('error', 'Format File Tidak Didukung!', 'Gunakan file dengan format .pdf, .docx, .doc, .xlsx, .xls, atau .csv');
        }
    }

    function processPdfSiswaFile(file) {
        const loadingDiv = document.getElementById('importFileLoading');
        const reader = new FileReader();
        reader.onload = function(e) {
            const typedarray = new Uint8Array(e.target.result);
            if (typeof pdfjsLib === 'undefined') {
                if (loadingDiv) loadingDiv.style.display = 'none';
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

                if (loadingDiv) loadingDiv.style.display = 'none';
                parseTextLinesToSiswa(fullTextLines, file.name, '📄 PDF Document');
            }).catch(function(err) {
                if (loadingDiv) loadingDiv.style.display = 'none';
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
                    if (loadingDiv) loadingDiv.style.display = 'none';
                    const lines = result.value.split('\n');
                    parseTextLinesToSiswa(lines, file.name, '📝 Microsoft Word');
                }).catch(function(err) {
                    if (loadingDiv) loadingDiv.style.display = 'none';
                    const textDecoder = new TextDecoder('utf-8');
                    const text = textDecoder.decode(arrayBuffer);
                    parseTextLinesToSiswa(text.split('\n'), file.name, '📝 Microsoft Word');
                });
            } else {
                if (loadingDiv) loadingDiv.style.display = 'none';
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
                    if (loadingDiv) loadingDiv.style.display = 'none';
                    showExcelAlert('error', 'File Excel Kosong!', 'File Excel yang Anda pilih tidak memiliki sheet.');
                    return;
                }

                const parsedStudents = [];
                const detectedClassesSet = new Set();
                let totalSheetsRead = 0;

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
                        const rowClean = String(rowStr).toLowerCase().trim();

                        if (rowClean.includes('kelas')) {
                            for (let c = 0; c < rowF.length; c++) {
                                const cellVal = String(rowF[c] || '').trim();
                                if (cellVal.toLowerCase().includes('kelas')) {
                                    for (let offset = 1; offset <= 5; offset++) {
                                        const targetVal = String(rowF[c + offset] || '').trim();
                                        if (targetVal) {
                                            const matchDB = availableClasses.find(k => k.nama_kelas.toLowerCase() === targetVal.toLowerCase() || targetVal.toLowerCase().includes(k.nama_kelas.toLowerCase()));
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

                        // Header Column Map
                        let tempMap = { nis: -1, nisn: -1, nama_siswa: -1, jenis_kelamin: -1, kota_lahir: -1, tanggal_lahir: -1, alamat_lengkap: -1, kelas: -1 };
                        let foundHeaderColCount = 0;

                        rowF.forEach((cell, colIdx) => {
                            const txt = String(cell || '').toLowerCase().trim();
                            if (!txt) return;

                            if (txt === 'nisn' || txt.includes('nisn')) {
                                tempMap.nisn = colIdx; foundHeaderColCount++;
                            } else if (txt === 'nis' || txt === 'niss' || txt.includes('niss') || txt.includes('noinduk')) {
                                tempMap.nis = colIdx; foundHeaderColCount++;
                            } else if (txt.includes('nama') || txt.includes('siswa')) {
                                tempMap.nama_siswa = colIdx; foundHeaderColCount++;
                            } else if (txt.includes('jeniskelamin') || txt.includes('jk') || txt === 'l/p' || txt === 'lp') {
                                tempMap.jenis_kelamin = colIdx; foundHeaderColCount++;
                            } else if (txt.includes('kotalahir') || txt.includes('tempatlahir')) {
                                tempMap.kota_lahir = colIdx;
                            } else if (txt.includes('tanggallahir') || txt.includes('tgllahir')) {
                                tempMap.tanggal_lahir = colIdx;
                            } else if (txt.includes('alamat')) {
                                tempMap.alamat_lengkap = colIdx;
                            } else if (txt === 'kelas') {
                                tempMap.kelas = colIdx;
                            }
                        });

                        if (foundHeaderColCount >= 2) {
                            colIndices = tempMap;
                            continue;
                        }

                        // Data Extract
                        let nisnRaw = colIndices.nisn !== -1 ? (rowF[colIndices.nisn] || rowR?.[colIndices.nisn] || '') : '';
                        let namaRaw = colIndices.nama_siswa !== -1 ? String(rowF[colIndices.nama_siswa] || rowR?.[colIndices.nama_siswa] || '').trim() : '';
                        let jkRaw   = colIndices.jenis_kelamin !== -1 ? String(rowF[colIndices.jenis_kelamin] || rowR?.[colIndices.jenis_kelamin] || '').trim() : '';
                        let nisRaw  = colIndices.nis !== -1 ? (rowF[colIndices.nis] || rowR?.[colIndices.nis] || '') : '';

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

                        if (nisn.length > 0 && nisn.length < 10) nisn = nisn.padStart(10, '0');
                        else if (nisn.length > 10) nisn = nisn.slice(0, 10);

                        if (nis.length > 10) nis = nis.slice(0, 10);
                        if (!nis && nisn) nis = nisn;
                        else if (!nisn && nis) nisn = nis.padStart(10, '0');

                        if (!nis || nis.length < 3) continue;
                        if (!nisn || nisn.length !== 10) continue;

                        let jenis_kelamin = 'L';
                        if (jkRaw.toLowerCase().startsWith('p') || jkRaw.toLowerCase().includes('perem')) jenis_kelamin = 'P';

                        let rowClassInfo = activeClass;

                        parsedStudents.push({
                            nis: nis,
                            nisn: nisn,
                            nama_siswa: namaRaw,
                            jenis_kelamin: jenis_kelamin,
                            kota_lahir: '-',
                            tanggal_lahir: '2008-01-01',
                            alamat_lengkap: '-',
                            id_kelas: rowClassInfo ? rowClassInfo.id_kelas : '',
                            kelas_name: rowClassInfo ? rowClassInfo.nama_kelas : ''
                        });
                    }
                });

                if (loadingDiv) loadingDiv.style.display = 'none';

                if (parsedStudents.length === 0) {
                    showExcelAlert('error', 'Tidak Ada Data Siswa Valid!', 'File yang Anda unggah tidak mengandung data siswa yang dapat dibaca. Pastikan file berisi kolom NISN, Nama Siswa, dan Jenis Kelamin.');
                    return;
                }

                populateParsedStudents(parsedStudents, file.name, '📊 Microsoft Excel / CSV', detectedClassesSet);
            } catch(err) {
                if (loadingDiv) loadingDiv.style.display = 'none';
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

            // Class detection
            if (line.toLowerCase().includes('kelas')) {
                const matchDB = availableClasses.find(k => line.toLowerCase().includes(k.nama_kelas.toLowerCase()));
                if (matchDB) {
                    activeClass = { id_kelas: matchDB.id_kelas, nama_kelas: matchDB.nama_kelas };
                    detectedClassesSet.add(matchDB.nama_kelas);
                }
            }

            // Extract 10-digit NISN
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

        const msg = `Berhasil membaca <strong>${parsedStudents.length} data siswa</strong> dari file <strong>${fileTypeLabel}</strong> (<em>${fileName}</em>) dan memasukkannya ke tabel pengisian massal di bawah.<br>`
                  + `<small style="display:block; margin-top:5px; font-size:12.5px;">`
                  + `<strong>Summary:</strong> ${classesSummary} | <strong>Mode:</strong> ${modeLabel}`
                  + `</small>`;

        showExcelAlert('success', `Proses File ${fileTypeLabel} Berhasil!`, msg);

        const formBulk = document.getElementById('formSiswaBulk');
        if (formBulk) {
            formBulk.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
</script>
@endsection
