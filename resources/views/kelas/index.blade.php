@extends('layouts.admin')

@section('title', 'Data Kelas — EDU JOURNAL')

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

    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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

    .badge-jurusan {
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        font-size: 11px;
    }

    .badge-siswa {
        background: #e0e7ff;
        color: #3730a3;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
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
            <h1>Master Data — Kelas</h1>
            <p>Kelola daftar rombongan belajar (rombel), tingkat kelas, dan jurusan</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <i class="fa-solid fa-school"></i>
        <span>Data Kelas (Rombongan Belajar)</span>
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

    <!-- Card 1: Form Tambah Kelas Baru -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-square-plus" style="color:#2563eb;"></i> Tambah Kelas Baru</h2>
                <p>Masukkan detail rombongan belajar baru ke dalam sistem.</p>
            </div>
        </div>

        <form id="formTambahKelas" action="{{ route('kelas.store') }}" method="POST" onsubmit="return validateKelasForm(event)">
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas') }}" class="form-control @error('nama_kelas') is-invalid @enderror" placeholder="Contoh: X RPL 1" required>
                    @error('nama_kelas')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_jurusan">Jurusan <span style="color:#ef4444;">*</span></label>
                    <select id="id_jurusan" name="id_jurusan" class="form-control @error('id_jurusan') is-invalid @enderror" onchange="toggleCustomJurusan(this)" required>
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id_jurusan }}" {{ old('id_jurusan') == $j->id_jurusan ? 'selected' : '' }}>
                                {{ $j->nama_jurusan }} ({{ $j->kode_jurusan ?? '-' }})
                            </option>
                        @endforeach
                        <option value="custom" {{ (old('id_jurusan') == 'custom' || old('nama_jurusan_custom')) ? 'selected' : '' }} style="font-weight:700; color:#2563eb;">+ Ketik Jurusan Baru (Custom)...</option>
                    </select>
                    @error('id_jurusan')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group" id="custom_jurusan_wrapper" style="display: {{ (old('id_jurusan') == 'custom' || old('nama_jurusan_custom')) ? 'block' : 'none' }}; grid-column: 1 / -1;">
                    <label for="nama_jurusan_custom" style="color:#2563eb;">Nama Jurusan Baru (Custom) <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_jurusan_custom" name="nama_jurusan_custom" value="{{ old('nama_jurusan_custom') }}" class="form-control @error('nama_jurusan_custom') is-invalid @enderror" placeholder="Contoh: Rekayasa Otomasi Industri">
                    <small style="color:#64748b; font-size:12px; display:block; margin-top:4px;">Jurusan baru ini akan tersimpan permanen di database dan muncul di daftar pilihan jurusan.</small>
                    @error('nama_jurusan_custom')
                        <small style="color:#ef4444; font-weight:600;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jumlah_siswa">Jumlah Siswa (Kapasitas / Estimasi) <span style="color:#ef4444;">*</span></label>
                    <input type="number" id="jumlah_siswa" name="jumlah_siswa" value="{{ old('jumlah_siswa', 30) }}" class="form-control" min="0" placeholder="30" required>
                    <small style="color:#64748b; font-size:12px; display:block; margin-top:4px;">Batas maksimal penambahan data siswa untuk kelas ini.</small>
                </div>
            </div>

            <div class="btn-submit-container" style="display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap; gap: 12px;">
                <button type="button" onclick="document.getElementById('formTambahKelas').reset();" class="btn-reset-form" style="background:#fbbf24; color:#78350f; border:1px solid #fde68a; padding:10px 20px; border-radius:10px; font-weight:700; margin:0;" title="Kosongkan Isian Form">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-submit" style="margin:0;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data Kelas
                </button>
            </div>
        </form>
    </div>

    <script>
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

            if (errors.length > 0) {
                e.preventDefault();
                alert('⚠️ PERINGATAN VALIDASI DATA:\n\n' + errors.map((err, i) => (i + 1) + '. ' + err).join('\n'));
                if (!namaKelas) {
                    document.getElementById('nama_kelas').focus();
                } else if (!idJurusan) {
                    document.getElementById('id_jurusan').focus();
                } else if (idJurusan === 'custom' && !namaJurusanCustom) {
                    document.getElementById('nama_jurusan_custom').focus();
                }
                return false;
            }
            return true;
        }
    </script>

    <!-- Card 2: Daftar Data Kelas -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-school" style="color:#3b5490;"></i> Data Kelas / Rombongan Belajar ({{ count($kelases) }})</h2>
                <p>Kelola seluruh daftar kelas, penetapan wali kelas, ruangan, dan jurusan.</p>
            </div>
        </div>

        <form action="{{ route('kelas.index') }}" method="GET" style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom:20px; background:#f8fafc; padding:14px 18px; border-radius:14px; border:1px solid #cbd5e1;">
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" name="search" class="form-control" style="width: 200px; padding-left:36px; background:#ffffff;" value="{{ $search ?? '' }}" placeholder="Cari Kelas / Wali / Ruang...">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                </div>

                <select name="id_jurusan" class="form-control" style="width: 150px; background:#ffffff;">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id_jurusan }}" {{ (isset($id_jurusan) && $id_jurusan == $j->id_jurusan) ? 'selected' : '' }}>{{ $j->kode_jurusan ?? $j->nama_jurusan }}</option>
                    @endforeach
                </select>

                <select name="id_ruangan" class="form-control" style="width: 150px; background:#ffffff;">
                    <option value="">Semua Ruangan</option>
                    @foreach($ruangans as $r)
                        <option value="{{ $r->id_ruangan }}" {{ (isset($id_ruangan) && $id_ruangan == $r->id_ruangan) ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-left:auto;">
                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('kelas.index') }}" class="btn-reset">Reset</a>
                <a href="{{ route('kelas.trash') }}" class="btn-trash" style="padding: 10px 18px; border-radius: 12px; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;" title="Lihat Data Kelas di Tempat Sampah">
                    <i class="fa-solid fa-trash-can"></i> Lihat Sampah
                    @if(isset($trashedCount) && $trashedCount > 0)
                        <span class="badge-count">{{ $trashedCount }}</span>
                    @endif
                </a>
                <button type="button" id="btnBulkDelete" class="btn-action btn-delete" style="padding: 10px 18px; border-radius: 12px; font-size: 13.5px; opacity: 0.5; cursor: not-allowed; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(225,29,72,0.15); border: none;" disabled onclick="confirmBulkDelete()" title="Pilih kelas dengan mencentang checkbox untuk menghapus secara massal">
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="bulkDeleteCount">0</span>)
                </button>
            </div>
        </form>

        <form id="formBulkDelete" action="{{ route('kelas.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllKelas" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" title="Pilih Semua (Select All)">
                            </th>
                            <th>NAMA KELAS</th>
                            <th>JURUSAN</th>
                            <th>RUANGAN</th>
                            <th>WALI KELAS</th>
                            <th>JUMLAH SISWA</th>
                            <th style="text-align:center; min-width: 220px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelases as $k)
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $k->id_kelas }}" class="kelas-select-checkbox" style="width: 17px; height: 17px; cursor: pointer; accent-color: #e11d48;" onchange="updateBulkDeleteState()">
                                </td>
                                <td><strong style="color:#0f172a; font-size:14px;">{{ $k->nama_kelas }}</strong></td>
                                <td>
                                    @if($k->jurusan)
                                        <span class="badge-jurusan">
                                            {{ $k->jurusan->nama_jurusan }} ({{ $k->jurusan->kode_jurusan }})
                                        </span>
                                    @else
                                        <span style="color:#94a3b8;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($k->ruangan)
                                        <span style="background: #e0f2fe; color: #0369a1; font-weight: 700; padding: 4px 10px; border-radius: 8px; border: 1px solid #bae6fd; font-size: 11.5px; display: inline-flex; align-items: center; gap: 5px;">
                                            <i class="fa-solid fa-door-open" style="font-size: 10px;"></i> {{ $k->ruangan->nama_ruangan }}
                                        </span>
                                    @else
                                        <span style="color:#94a3b8; font-style:italic;">Belum diatur</span>
                                    @endif
                                </td>
                                <td>
                                    @if($k->waliKelas)
                                        <strong>{{ $k->waliKelas->nama_guru }}</strong><br>
                                        <small style="color:#64748b;">NIP: {{ $k->waliKelas->nip }}</small>
                                    @else
                                        <span style="color:#94a3b8; font-style:italic;">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-siswa">
                                        <i class="fa-solid fa-users" style="font-size:10px;"></i> {{ $k->jumlah_siswa_real }} Siswa
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <div class="action-buttons">
                                        <!-- 1. LIHAT (Detail) - Disebelah kiri Edit -->
                                        <a href="{{ route('kelas.show', $k->id_kelas) }}" class="btn-action btn-view" title="Lihat Detail Kelas">
                                            <i class="fa-solid fa-eye"></i> Lihat
                                        </a>

                                        <!-- 2. EDIT - Disebelah kiri Hapus -->
                                        <a href="{{ route('kelas.edit', $k->id_kelas) }}" class="btn-action btn-edit" title="Edit Data Kelas">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>

                                        <!-- 3. HAPUS - Paling kanan -->
                                        <button type="button" class="btn-action btn-delete" onclick="if(confirm('Apakah Anda yakin ingin memindahkan kelas {{ addslashes($k->nama_kelas) }} ke tempat sampah?')) { document.getElementById('singleDeleteForm-{{ $k->id_kelas }}').submit(); }" title="Hapus Kelas">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:36px; color:#94a3b8;">
                                    <i class="fa-solid fa-folder-open" style="font-size:32px; margin-bottom:8px; display:block;"></i>
                                    Belum ada data Kelas yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @foreach($kelases as $k)
            <form id="singleDeleteForm-{{ $k->id_kelas }}" action="{{ route('kelas.destroy', $k->id_kelas) }}" method="POST" style="display:none;">
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
            <p>Apakah Anda yakin ingin memindahkan <strong id="modalBulkCountText" style="color:#e11d48;">0 data kelas</strong> yang dicentang ke Tempat Sampah?</p>
            <div class="modal-actions">
                <button type="button" class="btn-m-cancel" onclick="closeBulkDeleteModal()">Batal</button>
                <button type="button" class="btn-m-confirm" onclick="submitBulkDelete()">Ya, Hapus Data</button>
            </div>
        </div>
    </div>

    <script>
        function updateBulkDeleteState() {
            const checkedBoxes = document.querySelectorAll('.kelas-select-checkbox:checked');
            const totalBoxes   = document.querySelectorAll('.kelas-select-checkbox');
            const count        = checkedBoxes.length;
            const btnBulkDelete= document.getElementById('btnBulkDelete');
            const countSpan    = document.getElementById('bulkDeleteCount');
            const selectAll    = document.getElementById('selectAllKelas');

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
                modal.classList.add('active');
            } else {
                if (confirm(`Apakah Anda yakin ingin memindahkan ${count} data kelas yang dipilih ke Tempat Sampah?`)) {
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
            const selectAll = document.getElementById('selectAllKelas');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.kelas-select-checkbox');
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
