@extends('layouts.admin')

@section('title', 'Master Data - Mapel — Jurnal ESEMKITA')

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

    .main-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 24px;
    }

    @media (max-width: 1100px) {
        .main-grid {
            grid-template-columns: 1fr;
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

    .btn-submit {
        background: #2b395b;
        color: white;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        box-shadow: 0 4px 12px rgba(43, 57, 91, 0.25);
        transition: all 0.2s ease;
    }
    .btn-submit:hover {
        background: #1e2942;
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

    /* Detail Card Specific Styles (Matching Screenshot) */
    .detail-mapel-card {
        background: #fdfbf7;
        border: 1.5px solid #f3ebd7;
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.02);
    }

    .detail-mapel-card h3 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 16px;
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
</style>
@endsection

@section('content')

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

    <div class="main-grid">

        <!-- SISI KIRI: Tabel Daftar Mapel + Bar Pencarian -->
        <div>
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
                        <input type="text" name="search" class="form-control" style="padding-left:36px;" value="{{ $search ?? '' }}" placeholder="Cari Nama / Kode Mapel..">
                        <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                    </div>

                    <button type="submit" class="btn-filter">Cari</button>
                    <a href="{{ route('mapel.index') }}" class="btn-reset">Reset</a>
                </form>

                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th style="width: 50px;">NO</th>
                                <th>KODE</th>
                                <th>NAMA MAPEL</th>
                                <th style="text-align:center;">JUMLAH PENGAMPU</th>
                                <th style="text-align:center; min-width: 220px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mapels as $index => $m)
                                <tr class="{{ isset($selectedMapel) && $selectedMapel->id_mapel == $m->id_mapel ? 'active-row' : '' }}">
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
                                            <!-- 1. LIHAT DETAIL - Disebelah kiri Edit & Hapus -->
                                            <a href="{{ route('mapel.index', ['search' => $search, 'selected_id' => $m->id_mapel]) }}" class="btn-action btn-view" title="Lihat Detail Mapel & Guru Pengampu">
                                                <i class="fa-solid fa-eye"></i> Lihat Detail
                                            </a>

                                            <!-- 2. EDIT - Disebelah kiri Hapus -->
                                            <a href="{{ route('mapel.edit', $m->id_mapel) }}" class="btn-action btn-edit" title="Edit Data Mapel">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>

                                            <!-- 3. HAPUS - Paling kanan -->
                                            <form action="{{ route('mapel.destroy', $m->id_mapel) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin memindahkan {{ addslashes($m->nama_mapel) }} ke tempat sampah?')" title="Hapus Mapel">
                                                    <i class="fa-solid fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center; padding:36px; color:#94a3b8;">
                                        <i class="fa-solid fa-folder-open" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                        Belum ada data Mata Pelajaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SISI KANAN: Card Form Tambah Mapel + Panel Detail Mapel -->
        <div>

            <!-- Card 1: Form Tambah Mapel -->
            <div class="card">
                <h2 style="font-size:18px; font-weight:800; color:#0f172a; margin-bottom:16px;">
                    <i class="fa-solid fa-square-plus" style="color:#2563eb;"></i> Tambah Mapel
                </h2>

                <form id="formTambahMapel" action="{{ route('mapel.store') }}" method="POST" onsubmit="return validateMapelForm(event)">
                    @csrf

                    <div class="form-group">
                        <label for="kode_mapel">Kode Mapel <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="kode_mapel" name="kode_mapel" value="{{ old('kode_mapel') }}" class="form-control @error('kode_mapel') is-invalid @enderror" placeholder="Contoh: ING-10" required>
                        @error('kode_mapel')
                            <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_mapel">Nama Mapel <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="nama_mapel" name="nama_mapel" value="{{ old('nama_mapel') }}" class="form-control @error('nama_mapel') is-invalid @enderror" placeholder="Masukkan Nama Mapel" required>
                        @error('nama_mapel')
                            <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Mapel
                    </button>
                </form>
            </div>

            <script>
                function validateMapelForm(e) {
                    const kodeMapel = document.getElementById('kode_mapel').value.trim();
                    const namaMapel = document.getElementById('nama_mapel').value.trim();

                    let errors = [];
                    if (!kodeMapel) {
                        errors.push('Kode Mapel wajib diisi!');
                    } else if (kodeMapel.length > 15) {
                        errors.push('Kode Mapel maksimal 15 karakter!');
                    }

                    if (!namaMapel) {
                        errors.push('Nama Mapel wajib diisi!');
                    } else if (namaMapel.length > 100) {
                        errors.push('Nama Mapel maksimal 100 karakter!');
                    }

                    if (errors.length > 0) {
                        e.preventDefault();
                        alert('⚠️ PERINGATAN VALIDASI DATA:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
                        if (!kodeMapel) document.getElementById('kode_mapel').focus();
                        else if (!namaMapel) document.getElementById('nama_mapel').focus();
                        return false;
                    }
                    return true;
                }
            </script>

            <!-- Card 2: Panel Detail Mapel (Sesuai Screenshot User) -->
            @if(isset($selectedMapel))
                <div class="detail-mapel-card">
                    <h3>Detail Mapel</h3>

                    <div class="detail-row">
                        <span class="label">Nama Mapel :</span>
                        <span class="badge-highlight-yellow">{{ $selectedMapel->nama_mapel }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="label">Kode Mapel :</span>
                        <span style="font-family:monospace; font-weight:700; color:#3b5490;">{{ $selectedMapel->kode_mapel }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="label">Jumlah Pengampu :</span>
                        <span class="badge-pink-pill">{{ $selectedMapel->gurus_count ?? count($selectedMapel->gurus) }}</span>
                    </div>

                    <div class="pengampu-header">
                        <span class="title">Daftar Pengampu :</span>
                        <span class="badge-semua">Semua</span>
                    </div>

                    @if(isset($selectedMapel->gurus) && count($selectedMapel->gurus) > 0)
                        @foreach($selectedMapel->gurus as $guru)
                            <div class="teacher-item-card">
                                <div>
                                    <i class="fa-solid fa-user-tie" style="margin-right:6px; opacity:0.8;"></i>
                                    {{ $guru->nama_guru }}
                                </div>
                                <a href="{{ route('guru.show', $guru->id_guru) }}" style="color:#ffffff; opacity:0.9; text-decoration:none; font-size:12px;" title="Lihat Profil Guru">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div style="background:#f1f5f9; color:#64748b; padding:16px; border-radius:14px; text-align:center; font-size:13px; font-weight:600;">
                            <i class="fa-solid fa-info-circle" style="margin-right:4px;"></i> Belum ada guru pengampu untuk mata pelajaran ini.
                        </div>
                    @endif

                    <div style="margin-top:20px; text-align:right;">
                        <a href="{{ route('mapel.show', $selectedMapel->id_mapel) }}" style="color:#2563eb; font-size:13px; font-weight:700; text-decoration:none;">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i> Halaman Detail Lengkap &rarr;
                        </a>
                    </div>
                </div>
            @endif

        </div>

    </div>

@endsection
