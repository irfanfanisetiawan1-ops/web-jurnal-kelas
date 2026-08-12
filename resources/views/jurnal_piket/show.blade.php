@extends('layouts.admin')

@section('title', 'Detail Jurnal Piket — EduJournal')
@section('header_title', 'Detail Jurnal Guru Piket')
@section('header_subtitle', 'Rincian laporan piket dan suasana sekolah')

@section('content')

    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; max-width: 600px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <div style="margin-bottom: 16px;">
            <span style="font-size: 12px; color: #64748b; font-weight: 700;">TANGGAL & JAM PIKET</span>
            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a;">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d F Y') }} ({{ $jurnal->jam_piket }})</h3>
        </div>

        <div style="margin-bottom: 16px;">
            <span style="font-size: 12px; color: #64748b; font-weight: 700;">PETUGAS GURU PIKET</span>
            <p style="font-size: 15px; font-weight: 700; color: #1e293b;">{{ $jurnal->nama_petugas_piket }}</p>
        </div>

        <div style="margin-bottom: 16px;">
            <span style="font-size: 12px; color: #64748b; font-weight: 700;">STATUS SUASANA</span><br>
            <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 12px; font-weight: 700; font-size: 12px;">{{ $jurnal->status_suasana }}</span>
        </div>

        <div style="margin-bottom: 24px;">
            <span style="font-size: 12px; color: #64748b; font-weight: 700;">CATATAN KEJADIAN</span>
            <p style="background: #f8fafc; padding: 12px; border-radius: 8px; font-size: 13px; color: #334155; margin-top: 4px; white-space: pre-line;">{{ $jurnal->catatan_kejadian ?? 'Tidak ada catatan khusus.' }}</p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('jurnal-piket.index') }}" style="background: #f1f5f9; color: #475569; padding: 10px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none;">Kembali</a>
            <a href="{{ route('jurnal-piket.edit', $jurnal->id_jurnal_piket) }}" style="background: #4f46e5; color: white; padding: 10px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none;">
                <i class="fa-solid fa-pen"></i> Edit Jurnal Piket
            </a>
        </div>
    </div>

@endsection
