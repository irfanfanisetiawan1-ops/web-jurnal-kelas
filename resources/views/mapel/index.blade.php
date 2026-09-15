@extends('layouts.admin')

@section('title', 'Master Data - Mapel — EDU JOURNAL')

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

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
            gap: 12px;
        }
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
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 14px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        padding: 11px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }
    .btn-submit:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        transform: translateY(-1px);
    }

    .btn-reset-form {
        background: #fbbf24;
        color: #78350f;
        border: 1px solid #fde68a;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(251, 191, 36, 0.2);
        transition: all 0.2s ease;
    }
    .btn-reset-form:hover {
        background: #f59e0b;
        color: #78350f;
        transform: translateY(-1px);
    }

    /* Auto Generate & Realtime Validation Elements */
    .btn-auto-gen {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 3px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
    }
    .btn-auto-gen:hover {
        background: #dbeafe;
        border-color: #93c5fd;
        color: #1d4ed8;
        transform: translateY(-1px);
    }
    .field-feedback {
        font-size: 12px;
        font-weight: 600;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
        line-height: 1.4;
    }
    .field-feedback.is-valid {
        color: #16a34a;
    }
    .field-feedback.is-invalid {
        color: #dc2626;
    }
    .field-feedback.is-warning {
        color: #d97706;
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

    .table-custom tr.active-row td {
        background: #fef9c3;
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

    /* Detail Mapel Modal Specific Styles (Matching Screenshot) */
    .modal-detail-box {
        background: #fdfbf7;
        border: 1.5px solid #f3ebd7;
        border-radius: 24px;
        padding: 26px 28px;
        max-width: 460px;
        width: 90%;
        box-shadow: 0 25px 50px rgba(15, 23, 42, 0.3);
        text-align: left;
        position: relative;
        animation: modalFadeIn 0.2s ease-out;
        max-height: 88vh;
        display: flex;
        flex-direction: column;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .modal-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1.5px solid #f3ebd7;
    }

    .modal-detail-header h3 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .btn-close-modal {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #64748b;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.15s ease;
    }
    .btn-close-modal:hover {
        background: #e2e8f0;
        color: #0f172a;
        transform: scale(1.05);
    }

    .modal-detail-body {
        overflow-y: auto;
        padding-right: 4px;
        flex: 1;
    }

    .modal-detail-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1.5px solid #f3ebd7;
        gap: 12px;
        flex-wrap: wrap;
    }

    .detail-row {
        margin-bottom: 14px;
        font-size: 14.5px;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .detail-row .label {
        font-weight: 600;
        color: #1e293b;
    }

    .badge-highlight-yellow {
        background: #fef08a;
        color: #713f12;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 12px;
        font-size: 14px;
        display: inline-block;
    }

    .badge-pink-pill {
        background: #f43f5e;
        color: #ffffff;
        font-weight: 800;
        padding: 5px 16px;
        border-radius: 12px;
        font-size: 14px;
        display: inline-block;
    }

    .pengampu-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 12px;
    }

    .pengampu-header .title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
    }

    .badge-semua {
        background: #ffffff;
        color: #0f172a;
        font-weight: 700;
        padding: 4px 14px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        font-size: 13px;
    }

    .teacher-item-card {
        background: #d8cbb9;
        color: #ffffff;
        padding: 12px 18px;
        border-radius: 14px;
        margin-bottom: 10px;
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
    }
    .teacher-item-card:hover {
        background: #cbb9a3;
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
            <h1>Master Data — Mata Pelajaran</h1>
            <p>Kelola daftar kurikulum mata pelajaran dan kelompok mapel sekolah</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <i class="fa-solid fa-book"></i>
        <span>Master Data - Mapel</span>
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

    <!-- Card 1 (Atas): Form Tambah Mapel -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-book-medical" style="color:#3b5490;"></i> Tambah Mapel</h2>
                <p>Input data mata pelajaran baru ke dalam kurikulum dengan validasi anti-bentrok.</p>
            </div>
            <div>
                <span style="font-size:12px; background:#eff6ff; color:#1d4ed8; font-weight:700; padding:6px 14px; border-radius:12px; border:1px solid #bfdbfe; display:inline-flex; align-items:center; gap:6px;">
                    Validasi Anti-Bentrok
                </span>
            </div>
        </div>

        <form id="formTambahMapel" action="{{ route('mapel.store') }}" method="POST" onsubmit="return validateMapelForm(event)">
            @csrf

            <div class="form-grid-2">
                <!-- Nama Mapel -->
                <div class="form-group">
                    <label for="nama_mapel">Nama Mata Pelajaran <span style="color:#ef4444;">*</span></label>
                    <input
                        type="text"
                        id="nama_mapel"
                        name="nama_mapel"
                        value="{{ old('nama_mapel') }}"
                        class="form-control @error('nama_mapel') is-invalid @enderror"
                        placeholder="Contoh: Bahasa Indonesia, Matematika"
                        maxlength="100"
                        required
                        autocomplete="off"
                        oninput="handleNamaMapelInput(this.value)"
                    >
                    <div id="namaMapelFeedback" class="field-feedback"></div>
                    @error('nama_mapel')
                        <small style="color:#ef4444; font-weight:600; display:block; margin-top:4px;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Kode Mapel -->
                <div class="form-group">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                        <label for="kode_mapel" style="margin-bottom:0;">Kode Mapel <span style="color:#ef4444;">*</span></label>
                        <button type="button" id="btnAutoKode" class="btn-auto-gen" onclick="triggerManualGenerateKode()" title="Generate ulang kode otomatis">
                            Generate Otomatis
                        </button>
                    </div>
                    <input
                        type="text"
                        id="kode_mapel"
                        name="kode_mapel"
                        value="{{ old('kode_mapel') }}"
                        class="form-control @error('kode_mapel') is-invalid @enderror"
                        placeholder="Contoh: BIN-01, MAT-01, INF-01"
                        maxlength="15"
                        required
                        autocomplete="off"
                        style="text-transform:uppercase; font-family:monospace; font-weight:700; letter-spacing:0.5px;"
                        oninput="handleKodeMapelInput(this.value)"
                    >
                    <div id="kodeMapelFeedback" class="field-feedback"></div>
                    @error('kode_mapel')
                        <small style="color:#ef4444; font-weight:600; display:block; margin-top:4px;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="btn-submit-container">
                <button type="button" onclick="resetFormTambahMapel()" class="btn-reset-form" title="Kosongkan Isian Form">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-submit" id="btnSubmitMapel">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Mapel
                </button>
            </div>
        </form>
    </div>

    <!-- Card 2 (Bawah): Master Data - Mapel -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-book-bookmark" style="color:#3b5490;"></i> Master Data - Mapel</h2>
                <p>Pengelolaan mata pelajaran dan daftar guru pengampu.</p>
            </div>

            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                <a href="{{ route('mapel.trash') }}" class="btn-trash">
                    <i class="fa-solid fa-trash-can"></i> Lihat Sampah Mapel
                    @if(isset($trashedCount) && $trashedCount > 0)
                        <span class="badge-count">{{ $trashedCount }}</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Form Pencarian -->
        <form action="{{ route('mapel.index') }}" method="GET" style="display:flex; align-items:center; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
            @if(isset($selected_id))
                <input type="hidden" name="selected_id" value="{{ $selected_id }}">
            @endif
            <div style="position:relative; flex:1; min-width:220px;">
                <input type="text" name="search" class="form-control" style="padding-left:36px; background:#ffffff;" value="{{ $search ?? '' }}" placeholder="Cari Nama / Kode Mapel..">
                <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
            </div>

            <button type="submit" class="btn-filter">Cari</button>
            <a href="{{ route('mapel.index') }}" class="btn-reset">Reset</a>
            <button type="button" id="btnBulkDelete" class="btn-action btn-delete" style="padding: 10px 18px; border-radius: 12px; font-size: 13.5px; opacity: 0.5; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(225,29,72,0.15); border: none;" disabled onclick="confirmBulkDelete()" title="Pilih mapel dengan mencentang checkbox untuk menghapus secara massal">
                <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="bulkDeleteCount">0</span>)
            </button>
        </form>

        <form id="formBulkDelete" action="{{ route('mapel.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllMapel" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" title="Pilih Semua (Select All)">
                            </th>
                            <th style="width: 50px;">NO</th>
                            <th>KODE</th>
                            <th>NAMA MAPEL</th>
                            <th style="text-align:center;">JUMLAH PENGAMPU</th>
                            <th style="text-align:center; min-width: 220px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mapels as $index => $m)
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $m->id_mapel }}" class="mapel-select-checkbox" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" onchange="updateBulkDeleteState()">
                                </td>
                                <td><strong>{{ $index + 1 }}</strong></td>
                                <td><span style="font-family:monospace; font-weight:700; color:#3b5490;">{{ $m->kode_mapel ?? '-' }}</span></td>
                                <td><strong>{{ $m->nama_mapel }}</strong></td>
                                <td style="text-align:center;">
                                    <span style="background:#fce7f3; color:#be185d; font-weight:800; padding:4px 12px; border-radius:10px; font-size:12px;">
                                        {{ $m->gurus_count ?? count($m->gurus) }}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <div class="action-buttons">
                                        <!-- 1. LIHAT DETAIL - Pop up Modal -->
                                        <button type="button" class="btn-action btn-view" onclick="openDetailModal({{ $m->id_mapel }})" title="Lihat Detail Mapel & Guru Pengampu">
                                            <i class="fa-solid fa-eye"></i> Lihat Detail
                                        </button>

                                        <!-- 2. EDIT - Disebelah kiri Hapus -->
                                        <a href="{{ route('mapel.edit', $m->id_mapel) }}" class="btn-action btn-edit" title="Edit Data Mapel">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>

                                        <!-- 3. HAPUS - Paling kanan -->
                                        <button type="button" class="btn-action btn-delete" onclick="if(confirm('Apakah Anda yakin ingin memindahkan {{ addslashes($m->nama_mapel) }} ke tempat sampah?')) { document.getElementById('singleDeleteForm-{{ $m->id_mapel }}').submit(); }" title="Hapus Mapel">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center; padding:36px; color:#94a3b8;">
                                    <i class="fa-solid fa-folder-open" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                    Belum ada data Mata Pelajaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @foreach($mapels as $m)
            <form id="singleDeleteForm-{{ $m->id_mapel }}" action="{{ route('mapel.destroy', $m->id_mapel) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    </div>

    <script>
                const existingMapels = @json($existingMapelsList ?? []);
                let userHasManuallyEditedKode = false;

                // Kamus Singkatan Baku Mapel Sekolah Indonesia
                const knownMapelPrefixes = {
                    'BAHASA INDONESIA': 'BIN',
                    'BAHASA INGGRIS': 'BIG',
                    'BAHASA JAWA': 'BJAW',
                    'BAHASA JEPANG': 'BJEP',
                    'BAHASA JERMAN': 'BJER',
                    'BAHASA ARAB': 'BARB',
                    'BAHASA MANDARIN': 'BMND',
                    'MATEMATIKA': 'MAT',
                    'PENDIDIKAN AGAMA ISLAM': 'PAI',
                    'PENDIDIKAN AGAMA KRISTEN': 'PAK',
                    'PENDIDIKAN AGAMA KATOLIK': 'PKAT',
                    'PENDIDIKAN AGAMA HINDU': 'PAH',
                    'PENDIDIKAN AGAMA BUDDHA': 'PAB',
                    'PENDIDIKAN AGAMA KHONGHUCU': 'PAKH',
                    'PENDIDIKAN PANCASILA': 'PPKN',
                    'PENDIDIKAN KEWARGANEGARAAN': 'PKN',
                    'PENDIDIKAN JASMANI': 'PJOK',
                    'PENJASKES': 'PJOK',
                    'SENI BUDAYA': 'SEN',
                    'SENI RUPA': 'SRUP',
                    'SENI MUSIK': 'SMUS',
                    'SENI TARI': 'STAR',
                    'SENI TEATER': 'STEA',
                    'SEJARAH': 'SEJ',
                    'INFORMATIKA': 'INF',
                    'BIMBINGAN KONSELING': 'BK',
                    'PROJEK ILMU PENGETAHUAN ALAM DAN SOSIAL': 'IPAS',
                    'ILMU PENGETAHUAN ALAM': 'IPA',
                    'ILMU PENGETAHUAN SOSIAL': 'IPS',
                    'KODING DAN KECERDASAN ARTIFISIAL': 'KDK',
                    'KREATIVITAS, INOVASI, DAN KEWIRAUSAHAAN': 'PKK',
                    'KONSENTRASI KEAHLIAN': 'KKA'
                };

                function calculateAutoKode(nama) {
                    if (!nama || !nama.trim()) return '';
                    const cleanName = nama.trim().toUpperCase();

                    let prefix = null;
                    for (const [key, code] of Object.entries(knownMapelPrefixes)) {
                        if (cleanName.includes(key)) {
                            prefix = code;
                            break;
                        }
                    }

                    if (!prefix) {
                        const words = cleanName.split(/[\s,\-_]+/);
                        if (words.length >= 2) {
                            let acronym = '';
                            const stopWords = ['DAN', 'YANG', 'UNTUK', 'DI', 'KE', 'DARI', 'BUDI', 'PEKERTI', 'KELAS', 'TINGKAT'];
                            for (const w of words) {
                                if (!stopWords.includes(w) && w.length > 0) {
                                    acronym += w.charAt(0);
                                }
                            }
                            if (acronym.length >= 2 && acronym.length <= 6) {
                                prefix = acronym;
                            } else {
                                prefix = words[0].substring(0, 3);
                            }
                        } else {
                            const alphanumeric = cleanName.replace(/[^A-Z0-9]/g, '');
                            prefix = alphanumeric.substring(0, Math.min(4, alphanumeric.length));
                        }
                    }

                    prefix = (prefix || 'MPL').replace(/[^A-Z0-9]/g, '');
                    if (!prefix) prefix = 'MPL';

                    // Ambil list kode yang sudah ada di database
                    const usedCodes = existingMapels.map(m => (m.kode || '').toUpperCase());

                    let index = 1;
                    let candidate = '';
                    do {
                        candidate = prefix + '-' + String(index).padStart(2, '0');
                        index++;
                    } while (usedCodes.includes(candidate) && index < 1000);

                    return candidate;
                }

                function handleNamaMapelInput(val) {
                    const namaInput = document.getElementById('nama_mapel');
                    const kodeInput = document.getElementById('kode_mapel');
                    const namaFeedback = document.getElementById('namaMapelFeedback');

                    val = val.trim();

                    // 1. Validasi Nama Mapel
                    if (!val) {
                        namaFeedback.innerHTML = '';
                        namaInput.classList.remove('is-invalid');
                    } else {
                        const valLower = val.toLowerCase();
                        const duplicate = existingMapels.find(m => m.nama_lower === valLower);
                        if (duplicate) {
                            namaInput.classList.add('is-invalid');
                            if (duplicate.is_trash) {
                                namaFeedback.className = 'field-feedback is-warning';
                                namaFeedback.innerHTML = `Nama mapel ini ada di Tempat Sampah (Kode: ${duplicate.kode}).`;
                            } else {
                                namaFeedback.className = 'field-feedback is-invalid';
                                namaFeedback.innerHTML = `Nama mapel sudah terdaftar dengan kode <strong>${duplicate.kode}</strong>.`;
                            }
                        } else if (val.length < 2) {
                            namaInput.classList.add('is-invalid');
                            namaFeedback.className = 'field-feedback is-invalid';
                            namaFeedback.innerHTML = `Nama mapel minimal 2 karakter.`;
                        } else {
                            namaInput.classList.remove('is-invalid');
                            namaFeedback.className = 'field-feedback is-valid';
                            namaFeedback.innerHTML = `Nama mata pelajaran valid &amp; tersedia.`;
                        }
                    }

                    // 2. Auto-generate kode jika user belum edit manual kode
                    if (!userHasManuallyEditedKode && val) {
                        const autoCode = calculateAutoKode(val);
                        kodeInput.value = autoCode;
                        handleKodeMapelInput(autoCode, false);
                    } else if (!val && !userHasManuallyEditedKode) {
                        kodeInput.value = '';
                        document.getElementById('kodeMapelFeedback').innerHTML = '';
                        kodeInput.classList.remove('is-invalid');
                    }
                }

                function triggerManualGenerateKode() {
                    const nama = document.getElementById('nama_mapel').value;
                    const autoCode = calculateAutoKode(nama || 'Mapel');
                    const kodeInput = document.getElementById('kode_mapel');
                    kodeInput.value = autoCode;
                    userHasManuallyEditedKode = false;
                    handleKodeMapelInput(autoCode, false);
                }

                function handleKodeMapelInput(val, isManual = true) {
                    if (isManual) {
                        userHasManuallyEditedKode = true;
                    }

                    const kodeInput = document.getElementById('kode_mapel');
                    const feedback = document.getElementById('kodeMapelFeedback');

                    val = (val || '').trim().toUpperCase();
                    kodeInput.value = val;

                    if (!val) {
                        feedback.innerHTML = '';
                        kodeInput.classList.remove('is-invalid');
                        return;
                    }

                    // Cek format kriteria kode
                    const validFormat = /^[A-Z0-9\-_]+$/.test(val);
                    if (!validFormat) {
                        kodeInput.classList.add('is-invalid');
                        feedback.className = 'field-feedback is-invalid';
                        feedback.innerHTML = `Hanya boleh huruf kapital, angka, (-) dan (_).`;
                        return;
                    }

                    if (val.length < 2) {
                        kodeInput.classList.add('is-invalid');
                        feedback.className = 'field-feedback is-invalid';
                        feedback.innerHTML = `Kode minimal 2 karakter.`;
                        return;
                    }

                    if (val.length > 15) {
                        kodeInput.classList.add('is-invalid');
                        feedback.className = 'field-feedback is-invalid';
                        feedback.innerHTML = `Kode maksimal 15 karakter.`;
                        return;
                    }

                    // Cek duplikasi di existingMapels
                    const duplicate = existingMapels.find(m => m.kode === val);
                    if (duplicate) {
                        kodeInput.classList.add('is-invalid');
                        if (duplicate.is_trash) {
                            feedback.className = 'field-feedback is-warning';
                            feedback.innerHTML = `Kode ada pada mapel "${duplicate.nama}" di Tempat Sampah.`;
                        } else {
                            feedback.className = 'field-feedback is-invalid';
                            feedback.innerHTML = `Kode sudah dipakai oleh <strong>${duplicate.nama}</strong>.`;
                        }
                    } else {
                        kodeInput.classList.remove('is-invalid');
                        feedback.className = 'field-feedback is-valid';
                        feedback.innerHTML = `Kode Mapel valid &amp; siap digunakan.`;
                    }
                }

                function validateMapelForm(e) {
                    const kodeInput = document.getElementById('kode_mapel');
                    const namaInput = document.getElementById('nama_mapel');
                    const kodeMapel = kodeInput.value.trim().toUpperCase();
                    const namaMapel = namaInput.value.trim();

                    let errors = [];

                    if (!namaMapel) {
                        errors.push('Nama Mata Pelajaran wajib diisi!');
                    } else if (namaMapel.length < 2) {
                        errors.push('Nama Mata Pelajaran minimal 2 karakter!');
                    } else if (namaMapel.length > 100) {
                        errors.push('Nama Mata Pelajaran maksimal 100 karakter!');
                    }

                    // Cek bentrok nama
                    const dupName = existingMapels.find(m => m.nama_lower === namaMapel.toLowerCase());
                    if (dupName) {
                        if (dupName.is_trash) {
                            errors.push(`Mata Pelajaran "${dupName.nama}" sudah ada di Tempat Sampah. Silakan pulihkan data.`);
                        } else {
                            errors.push(`Mata Pelajaran "${dupName.nama}" sudah terdaftar dengan kode ${dupName.kode}!`);
                        }
                    }

                    if (!kodeMapel) {
                        // Jika kosong, isi otomatis
                        const autoCode = calculateAutoKode(namaMapel);
                        kodeInput.value = autoCode;
                    } else {
                        if (kodeMapel.length < 2) {
                            errors.push('Kode Mapel minimal 2 karakter!');
                        } else if (kodeMapel.length > 15) {
                            errors.push('Kode Mapel maksimal 15 karakter!');
                        } else if (!/^[A-Z0-9\-_]+$/.test(kodeMapel)) {
                            errors.push('Kode Mapel hanya boleh berisi huruf kapital, angka, strip (-), dan garis bawah (_)!');
                        }

                        // Cek bentrok kode
                        const dupCode = existingMapels.find(m => m.kode === kodeMapel);
                        if (dupCode) {
                            if (dupCode.is_trash) {
                                errors.push(`Kode Mapel "${kodeMapel}" sudah terdaftar pada data di Tempat Sampah ("${dupCode.nama}")!`);
                            } else {
                                errors.push(`Kode Mapel "${kodeMapel}" sudah digunakan oleh mata pelajaran "${dupCode.nama}"!`);
                            }
                        }
                    }

                    if (errors.length > 0) {
                        e.preventDefault();
                        alert('⚠️ PERINGATAN VALIDASI MAPEL:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
                        if (!namaMapel) namaInput.focus();
                        else if (!kodeMapel) kodeInput.focus();
                        return false;
                    }

                    const btn = document.getElementById('btnSubmitMapel');
                    if (btn) {
                        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...';
                        btn.style.opacity = '0.75';
                        btn.style.pointerEvents = 'none';
                    }
                    return true;
                }

                function resetFormTambahMapel() {
                    const form = document.getElementById('formTambahMapel');
                    if (form) form.reset();
                    userHasManuallyEditedKode = false;

                    const namaInput = document.getElementById('nama_mapel');
                    const kodeInput = document.getElementById('kode_mapel');
                    const namaFeedback = document.getElementById('namaMapelFeedback');
                    const kodeFeedback = document.getElementById('kodeMapelFeedback');

                    if (namaInput) {
                        namaInput.value = '';
                        namaInput.classList.remove('is-invalid');
                    }
                    if (kodeInput) {
                        kodeInput.value = '';
                        kodeInput.classList.remove('is-invalid');
                    }
                    if (namaFeedback) {
                        namaFeedback.innerHTML = '';
                        namaFeedback.className = 'field-feedback';
                    }
                    if (kodeFeedback) {
                        kodeFeedback.innerHTML = '';
                        kodeFeedback.className = 'field-feedback';
                    }
                }
            </script>

    <!-- Pop-up Modal Detail Mapel -->
    <div class="modal-bg" id="modalDetailMapel" role="dialog" aria-modal="true" aria-labelledby="modalDetailTitle">
        <div class="modal-detail-box">
            <div class="modal-detail-header">
                <h3 id="modalDetailTitle">Detail Mapel</h3>
                <button type="button" class="btn-close-modal" onclick="closeDetailModal()" title="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-detail-body">
                <div class="detail-row">
                    <span class="label">Nama Mapel :</span>
                    <span class="badge-highlight-yellow" id="modalDetailNama">-</span>
                </div>

                <div class="detail-row">
                    <span class="label">Kode Mapel :</span>
                    <span style="font-family:monospace; font-weight:700; color:#3b5490;" id="modalDetailKode">-</span>
                </div>

                <div class="detail-row">
                    <span class="label">Jumlah Pengampu :</span>
                    <span class="badge-pink-pill" id="modalDetailJumlah">0</span>
                </div>

                <div class="pengampu-header">
                    <span class="title">Daftar Pengampu :</span>
                    <span class="badge-semua">Semua</span>
                </div>

                <div id="modalDetailGuruList">
                    <!-- Guru items dynamically inserted here -->
                </div>
            </div>

            <div class="modal-detail-footer">
                <button type="button" class="btn-m-cancel" style="padding: 9px 18px; font-size: 13px; max-width: 110px;" onclick="closeDetailModal()">
                    Tutup
                </button>
                <a href="#" id="modalDetailLinkFull" style="color:#2563eb; font-size:13.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    Halaman Detail Lengkap &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Confirm Bulk Delete -->
    <div class="modal-bg" id="modalConfirmBulkDelete">
        <div class="modal-box">
            <div class="modal-icon-wrap">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h3>Konfirmasi Hapus Terpilih</h3>
            <p>Apakah Anda yakin ingin memindahkan <strong id="modalBulkCountText" style="color:#e11d48;">0 data mapel</strong> yang dicentang ke Tempat Sampah?</p>
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeBulkDeleteModal()">Batal</button>
                <button type="button" class="btn-m-confirm" onclick="submitBulkDelete()">Ya, Hapus Data</button>
            </div>
        </div>
    </div>

    <script>
        const allMapelsData = @json($mapels);
        const selectedIdOnLoad = {{ isset($selected_id) && $selected_id ? $selected_id : 'null' }};

        function escapeHtml(text) {
            if (!text) return '';
            return String(text)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function openDetailModal(id) {
            const mapel = allMapelsData.find(m => m.id_mapel == id);
            if (!mapel) return;

            document.getElementById('modalDetailNama').textContent = mapel.nama_mapel;
            document.getElementById('modalDetailKode').textContent = mapel.kode_mapel || '-';
            const count = (mapel.gurus_count !== undefined && mapel.gurus_count !== null)
                ? mapel.gurus_count
                : (mapel.gurus ? mapel.gurus.length : 0);
            document.getElementById('modalDetailJumlah').textContent = count;

            const guruList = document.getElementById('modalDetailGuruList');
            guruList.innerHTML = '';

            const gurus = mapel.gurus || [];
            if (gurus.length > 0) {
                gurus.forEach(g => {
                    const item = document.createElement('div');
                    item.className = 'teacher-item-card';
                    item.innerHTML = `
                        <div>
                            <i class="fa-solid fa-user-tie" style="margin-right:6px; opacity:0.8;"></i>
                            ${escapeHtml(g.nama_guru)}
                        </div>
                        <a href="/guru/${g.id_guru}" style="color:#ffffff; opacity:0.9; text-decoration:none; font-size:12px;" title="Lihat Profil Guru">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                    `;
                    guruList.appendChild(item);
                });
            } else {
                guruList.innerHTML = `
                    <div style="background:#f1f5f9; color:#64748b; padding:16px; border-radius:14px; text-align:center; font-size:13px; font-weight:600;">
                        <i class="fa-solid fa-info-circle" style="margin-right:4px;"></i> Belum ada guru pengampu untuk mata pelajaran ini.
                    </div>
                `;
            }

            const linkFull = document.getElementById('modalDetailLinkFull');
            if (linkFull) {
                linkFull.href = '/mapel/' + mapel.id_mapel;
            }

            const modal = document.getElementById('modalDetailMapel');
            if (modal) modal.classList.add('active');
        }

        function closeDetailModal() {
            const modal = document.getElementById('modalDetailMapel');
            if (modal) modal.classList.remove('active');
        }

        function updateBulkDeleteState() {
            const checkedBoxes = document.querySelectorAll('.mapel-select-checkbox:checked');
            const totalBoxes   = document.querySelectorAll('.mapel-select-checkbox');
            const count        = checkedBoxes.length;
            const btnBulkDelete= document.getElementById('btnBulkDelete');
            const countSpan    = document.getElementById('bulkDeleteCount');
            const selectAll    = document.getElementById('selectAllMapel');

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
            const checkedBoxes = document.querySelectorAll('.mapel-select-checkbox:checked');
            const count = checkedBoxes.length;

            if (count === 0) {
                alert('Silakan pilih minimal 1 data mapel yang ingin dihapus dengan mencentang kotak centang (checkbox).');
                return;
            }

            const modalCountText = document.getElementById('modalBulkCountText');
            if (modalCountText) {
                modalCountText.textContent = count + ' data mapel';
            }

            const modal = document.getElementById('modalConfirmBulkDelete');
            if (modal) {
                modal.classList.add('active');
            } else {
                if (confirm(`Apakah Anda yakin ingin memindahkan ${count} data mapel yang dipilih ke Tempat Sampah?`)) {
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
            const selectAll = document.getElementById('selectAllMapel');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.mapel-select-checkbox');
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateBulkDeleteState();
                });
            }

            const modalDetail = document.getElementById('modalDetailMapel');
            if (modalDetail) {
                modalDetail.addEventListener('click', function(e) {
                    if (e.target === this) closeDetailModal();
                });
            }

            const modalBulk = document.getElementById('modalConfirmBulkDelete');
            if (modalBulk) {
                modalBulk.addEventListener('click', function(e) {
                    if (e.target === this) closeBulkDeleteModal();
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeDetailModal();
                    closeBulkDeleteModal();
                }
            });

            // Jika ada query parameter selected_id, buka modal otomatis
            if (selectedIdOnLoad) {
                openDetailModal(selectedIdOnLoad);
            }
        });
    </script>

@endsection
