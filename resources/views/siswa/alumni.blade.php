@extends('layouts.admin')

@section('title', 'Data Siswa Alumni — EDU JOURNAL')

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

    .btn-header-action {
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

    .btn-back-main {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }
    .btn-back-main:hover { background: #e2e8f0; }

    .btn-trash-link {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .btn-trash-link:hover {
        background: #fde68a;
        color: #78350f;
    }
    .btn-trash-link .badge-count {
        background: #d97706;
        color: #ffffff;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 20px;
    }

    /* Filter Card */
    .filter-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 20px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 14px;
        align-items: end;
    }

    .form-group-custom label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control-custom {
        width: 100%;
        padding: 9px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        color: #1e293b;
        outline: none;
        background: #ffffff;
        transition: border 0.15s ease;
    }
    .form-control-custom:focus {
        border-color: #3b5490;
        box-shadow: 0 0 0 3px rgba(59, 84, 144, 0.12);
    }
    select.form-control-custom {
        color: #94a3b8;
        font-weight: 500;
    }
    select.form-control-custom:has(option:checked:not([value=""])) {
        color: #0f172a;
        font-weight: 700;
    }
    select.form-control-custom option {
        color: #1e293b;
        font-weight: 600;
    }
    select.form-control-custom option[value=""] {
        color: #94a3b8;
        font-weight: 500;
    }

    .btn-filter {
        background: #3b5490;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.15s ease;
    }
    .btn-filter:hover { background: #2d4274; }

    .btn-reset-filter {
        background: #e2e8f0;
        color: #475569;
        border: none;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.15s ease;
    }
    .btn-reset-filter:hover { background: #cbd5e1; color: #1e293b; }

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
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .badge-alumni {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-act {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s ease;
        line-height: 1.2;
    }

    .btn-restore-active {
        background: #dcfce7;
        color: #15803d;
        border-color: #bbf7d0;
    }
    .btn-restore-active:hover {
        background: #16a34a;
        color: #ffffff;
    }

    .btn-delete-trash {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-delete-trash:hover {
        background: #dc2626;
        color: #ffffff;
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
    }
    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
</style>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Data Siswa Alumni</h1>
            <p>Daftar data siswa alumni yang telah lulus atau dipindahkan ke daftar alumni</p>
        </div>
    </div>

    <div class="breadcrumb-text">
        <a href="{{ route('siswa.index') }}"><i class="fa-solid fa-graduation-cap"></i> Data Siswa</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Data Siswa Alumni</span>
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

    <div class="card">
        <div class="card-top-header">
            <div>
                <h2><i class="fa-solid fa-user-graduate" style="color:#0284c7;"></i> Data Siswa Alumni ({{ count($siswas) }})</h2>
                <p>Daftar seluruh siswa alumni yang tersimpan dalam sistem.</p>
            </div>
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('siswa.trash') }}" class="btn-header-action btn-trash-link">
                    <i class="fa-solid fa-trash-can"></i> Lihat Tong Sampah
                    @if(isset($trashedCount) && $trashedCount > 0)
                        <span class="badge-count">{{ $trashedCount }}</span>
                    @endif
                </a>
                <a href="{{ route('siswa.index') }}" class="btn-header-action btn-back-main">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Siswa
                </a>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="filter-box">
            <form action="{{ route('siswa.alumni') }}" method="GET" class="filter-grid">
                <div class="form-group-custom">
                    <label>Pencarian</label>
                    <input type="text" name="search" class="form-control-custom" placeholder="Cari Nama, NIS, NISN..." value="{{ request('search') }}">
                </div>

                <div class="form-group-custom">
                    <label>Tingkat Kelas</label>
                    <select name="tingkat" class="form-control-custom">
                        <option value="">-- Semua Tingkat --</option>
                        <option value="X" {{ request('tingkat') == 'X' ? 'selected' : '' }}>Kelas X</option>
                        <option value="XI" {{ request('tingkat') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                        <option value="XII" {{ request('tingkat') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                    </select>
                </div>

                <div class="form-group-custom">
                    <label>Jurusan</label>
                    <select name="id_jurusan" class="form-control-custom">
                        <option value="">-- Semua Jurusan --</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id_jurusan }}" {{ request('id_jurusan') == $j->id_jurusan ? 'selected' : '' }}>
                                {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-custom">
                    <label>Kelas Terakhir</label>
                    <select name="id_kelas" class="form-control-custom">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelass as $k)
                            <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-custom">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control-custom">
                        <option value="">-- Semua JK --</option>
                        <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>

                <div class="form-group-custom">
                    <label>Urutan</label>
                    <select name="sort" class="form-control-custom">
                        <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama (A - Z)</option>
                        <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama (Z - A)</option>
                        <option value="nis_asc" {{ request('sort') == 'nis_asc' ? 'selected' : '' }}>NIS Terkecil</option>
                        <option value="nis_desc" {{ request('sort') == 'nis_desc' ? 'selected' : '' }}>NIS Terbesar</option>
                    </select>
                </div>

                <div style="display:flex; gap:8px;">
                    <button type="submit" class="btn-filter"><i class="fa-solid fa-magnifying-glass"></i> Filter</button>
                    @if(request('search') || request('tingkat') || request('id_jurusan') || request('id_kelas') || request('jenis_kelamin') || request('sort'))
                        <a href="{{ route('siswa.alumni') }}" class="btn-reset-filter"><i class="fa-solid fa-rotate-left"></i> Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>NAMA SISWA</th>
                        <th>JENIS KELAMIN</th>
                        <th>KELAS TERAKHIR</th>
                        <th>STATUS</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $s)
                        <tr>
                            <td><strong>{{ $s->nis ?? '-' }}</strong></td>
                            <td><span style="font-family:monospace; color:#3b5490;">{{ $s->nisn }}</span></td>
                            <td><strong>{{ $s->nama_siswa }}</strong></td>
                            <td>{{ $s->jenis_kelamin_teks }}</td>
                            <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                            <td>
                                <span class="badge-alumni">
                                    <i class="fa-solid fa-graduation-cap"></i> Alumni
                                </span>
                            </td>
                            <td style="text-align:center;">
                                <div style="display:inline-flex; gap:6px; flex-wrap:wrap; justify-content:center;">
                                    <form action="{{ route('siswa.restore-from-alumni', $s->id_siswa) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn-act btn-restore-active" onclick="return confirm('Kembalikan {{ addslashes($s->nama_siswa) }} menjadi Siswa Aktif?')" title="Kembalikan ke Siswa Aktif">
                                            <i class="fa-solid fa-rotate-left"></i> Kembalikan ke Siswa Aktif
                                        </button>
                                    </form>

                                    <form action="{{ route('siswa.force-delete', $s->id_siswa) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-act btn-delete-trash" onclick="return confirm('Hapus PERMANEN siswa {{ addslashes($s->nama_siswa) }}? Data tidak bisa dikembalikan lagi!')" title="Hapus Permanen">
                                            <i class="fa-solid fa-skull"></i> Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:36px; color:#94a3b8;">
                                <i class="fa-solid fa-user-graduate" style="font-size:32px; margin-bottom:8px; display:block; color:#cbd5e1;"></i>
                                Belum ada data siswa alumni yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
