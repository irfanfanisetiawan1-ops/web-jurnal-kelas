@extends('layouts.admin')

@section('title', 'Tambah Jurnal Piket — EduJournal')
@section('header_title', 'Input Jurnal Guru Piket')
@section('header_subtitle', 'Catat laporan piket harian, waktu piket, dan kejadian khusus sekolah')

@section('content')

    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; max-width: 650px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <form action="{{ route('jurnal-piket.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Tanggal Piket</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Nama Petugas Piket</label>
                <input type="text" name="nama_petugas_piket" value="{{ old('nama_petugas_piket', Auth::user()->name ?? '') }}" required style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Jam Piket (Misal: 07:00 - 12:00)</label>
                <input type="text" name="jam_piket" value="{{ old('jam_piket', '07:00 - 14:00') }}" required style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Status Suasana Sekolah</label>
                <select name="status_suasana" required style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;">
                    @foreach($statusOptions as $opt)
                        <option value="{{ $opt }}" {{ old('status_suasana') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Catatan / Kejadian Khusus</label>
                <textarea name="catatan_kejadian" rows="4" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;" placeholder="Tuliskan catatan kejadian penting atau keterangan piket...">{{ old('catatan_kejadian') }}</textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="{{ route('jurnal-piket.index') }}" style="background: #f1f5f9; color: #475569; padding: 11px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none;">Batal</a>
                <button type="submit" style="background: #4f46e5; color: white; border: none; padding: 11px 20px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer;">
                    <i class="fa-solid fa-plus"></i> Simpan Jurnal Piket
                </button>
            </div>
        </form>
    </div>

@endsection
