@extends('layouts.admin')

@section('title', 'Tambah Mapel Baru — Jurnal ESEMKITA')

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

    .create-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }

    .create-header-row {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .create-header-row h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .create-header-row p {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .form-group {
        margin-bottom: 18px;
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
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        padding: 11px 16px;
        border-radius: 12px;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    .error-msg {
        color: #dc2626;
        font-size: 12px;
        font-weight: 600;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-save {
        background: linear-gradient(135deg, #2563eb, #3b5490);
        color: #ffffff;
        border: none;
        padding: 12px 28px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }
    .btn-save:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.15s;
    }
    .btn-cancel:hover { background: #e2e8f0; }
</style>
@endsection

@section('content')

    <div class="breadcrumb-text">
        <a href="{{ route('mapel.index') }}"><i class="fa-solid fa-book"></i> Master Mapel</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Tambah Mapel</span>
    </div>

    <div class="create-card">
        <div class="create-header-row">
            <h2><i class="fa-solid fa-square-plus" style="color:#2563eb;"></i> Form Tambah Data Mapel Baru</h2>
            <p>Lengkapi formulir di bawah ini untuk menambahkan mata pelajaran baru ke sistem.</p>
        </div>

        <form action="{{ route('mapel.store') }}" method="POST">
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="kode_mapel">Kode Mapel <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="kode_mapel" name="kode_mapel" value="{{ old('kode_mapel') }}"
                        class="form-control {{ $errors->has('kode_mapel') ? 'is-invalid' : '' }}" placeholder="Contoh: ING-10" required>
                    @error('kode_mapel')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_mapel">Nama Mata Pelajaran <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="nama_mapel" name="nama_mapel" value="{{ old('nama_mapel') }}"
                        class="form-control {{ $errors->has('nama_mapel') ? 'is-invalid' : '' }}" placeholder="Contoh: Bahasa Inggris" required>
                    @error('nama_mapel')
                        <p class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('mapel.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data Mapel
                </button>
            </div>
        </form>
    </div>

@endsection
