@extends('layouts.admin')

@section('title', 'Edit Jurusan — EduJournal Admin')
@section('header_title', 'Edit Data Jurusan')
@section('header_subtitle', 'Perbarui informasi kode dan nama jurusan')

@section('content')

    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; max-width: 600px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <form action="{{ route('jurusan.update', $jurusan->id_jurusan) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Kode Jurusan</label>
                <input type="text" name="kode_jurusan" value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" required style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none; text-transform: uppercase;">
                @error('kode_jurusan')
                    <span style="color:#ef4444; font-size:12px; font-weight:600;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Nama Jurusan</label>
                <input type="text" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;">
                @error('nama_jurusan')
                    <span style="color:#ef4444; font-size:12px; font-weight:600;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="{{ route('jurusan.index') }}" style="background: #f1f5f9; color: #475569; padding: 11px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none;">Batal</a>
                <button type="submit" style="background: #4f46e5; color: white; border: none; padding: 11px 20px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

@endsection
