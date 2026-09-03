@extends('layouts.kepala_sekolah')

@section('title', 'Detail Jurnal Pembelajaran — Jurnal SMEA')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Page Header Banner -->
    <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 6px;">
                Jurnal Pembelajaran <i class="fa-solid fa-chevron-right" style="font-size: 10px; margin: 0 4px;"></i> <span style="color: #1e293b; font-weight: 700;">Detail Jurnal #{{ $jurnal->id_jurnal_mengajar }}</span>
            </div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0;">
                Detail Jurnal Mengajar Harian
            </h1>
        </div>

        <a href="{{ route('kepala-sekolah.jurnal-pembelajaran') }}" style="background: #f1f5f9; color: #475569; text-decoration: none; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 12.5px;">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Content Detail Card -->
    <div style="background: #ffffff; padding: 28px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <div>
            <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Tanggal Pembelajaran</div>
            <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 4px;">{{ $jurnal->tanggal }}</div>
        </div>

        <div>
            <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Kelas & Ruangan</div>
            <div style="font-size: 16px; font-weight: 800; color: #384972; margin-top: 4px;">{{ $jurnal->kelas->nama_kelas ?? '-' }}</div>
        </div>

        <div>
            <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Guru Pengajar</div>
            <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 4px;">{{ $jurnal->guru->nama_guru ?? '-' }}</div>
        </div>

        <div>
            <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Mata Pelajaran</div>
            <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 4px;">{{ $jurnal->mapel->nama_mapel ?? '-' }}</div>
        </div>

        <div style="grid-column: span 2;">
            <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Materi Pembelajaran</div>
            <div style="font-size: 15px; font-weight: 600; color: #334155; margin-top: 4px; background: #f8fafc; padding: 14px; border-radius: 10px;">
                {{ $jurnal->materi }}
            </div>
        </div>

        <div style="grid-column: span 2;">
            <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Catatan & Kondisi Kelas</div>
            <div style="font-size: 14px; color: #475569; margin-top: 4px;">
                {{ $jurnal->catatan ?? 'Pembelajaran terlaksana dengan lancar dan kondusif.' }}
            </div>
        </div>
    </div>

</div>
@endsection
