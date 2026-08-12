@extends('layouts.admin')

@section('title', 'Detail Jurusan — EduJournal Admin')
@section('header_title', 'Detail Data Jurusan')
@section('header_subtitle', 'Rincian informasi kode dan nama jurusan')

@section('content')

    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; max-width: 600px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <div style="margin-bottom: 16px;">
            <span style="font-size: 12px; color: #64748b; font-weight: 700;">KODE JURUSAN</span>
            <h3 style="font-size: 20px; font-weight: 800; color: #4f46e5;">{{ $jurusan->kode_jurusan }}</h3>
        </div>

        <div style="margin-bottom: 24px;">
            <span style="font-size: 12px; color: #64748b; font-weight: 700;">NAMA JURUSAN / PROGRAM KEAHLIAN</span>
            <p style="font-size: 16px; font-weight: 700; color: #0f172a;">{{ $jurusan->nama_jurusan }}</p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('jurusan.index') }}" style="background: #f1f5f9; color: #475569; padding: 10px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none;">Kembali</a>
            <a href="{{ route('jurusan.edit', $jurusan->id_jurusan) }}" style="background: #4f46e5; color: white; padding: 10px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none;">
                <i class="fa-solid fa-pen"></i> Edit Jurusan
            </a>
        </div>
    </div>

@endsection
