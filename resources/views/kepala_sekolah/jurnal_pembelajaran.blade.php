@extends('layouts.kepala_sekolah')

@section('title', 'Jurnal Pembelajaran — Jurnal SMEA')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Page Header Banner -->
    <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 6px;">
                DATA MASTER <i class="fa-solid fa-chevron-right" style="font-size: 10px; margin: 0 4px;"></i> <span style="color: #1e293b; font-weight: 700;">Jurnal pembelajaran</span>
            </div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0;">
                <i class="fa-solid fa-book-bookmark" style="color: #384972; margin-right: 8px;"></i> Master Rekapitulasi Jurnal Pembelajaran Guru
            </h1>
            <p style="margin: 4px 0 0 0; color: #64748b; font-size: 13px; font-weight: 500;">
                Pemberkasan dan audit jurnal mengajar harian guru di seluruh kelas.
            </p>
        </div>

        <form method="GET" action="{{ route('kepala-sekolah.jurnal-pembelajaran') }}" style="display: flex; gap: 10px;">
            <select name="id_kelas" style="padding: 8px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; outline: none; font-family: inherit;">
                <option value="">-- Semua Kelas --</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" style="padding: 8px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; outline: none; font-family: inherit;">
            <button type="submit" style="background: #384972; color: #fff; border: none; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 12.5px; cursor: pointer; font-family: inherit;">
                Cari Jurnal
            </button>
        </form>
    </div>

    <!-- Table Jurnal Pembelajaran -->
    <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #f1f5f9; color: #475569; border-bottom: 1px solid #cbd5e1;">
                        <th style="padding: 12px;">Tanggal</th>
                        <th style="padding: 12px;">Kelas</th>
                        <th style="padding: 12px;">Guru Pengajar</th>
                        <th style="padding: 12px;">Mata Pelajaran</th>
                        <th style="padding: 12px;">Materi / Ringkasan Pembelajaran</th>
                        <th style="padding: 12px;">Kondisi Kelas</th>
                        <th style="padding: 12px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $j)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px; font-weight: 700; color: #384972;">{{ $j->tanggal }}</td>
                        <td style="padding: 12px; font-weight: 800; color: #0f172a;">{{ $j->kelas->nama_kelas ?? '-' }}</td>
                        <td style="padding: 12px; color: #0f172a; font-weight: 700;">{{ $j->guru->nama_guru ?? '-' }}</td>
                        <td style="padding: 12px; color: #334155; font-weight: 700;">{{ $j->mapel->nama_mapel ?? '-' }}</td>
                        <td style="padding: 12px; color: #475569;">{{ $j->materi }}</td>
                        <td style="padding: 12px;">
                            <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 11px;">
                                {{ $j->kondisi_kelas ?? 'Kondusif' }}
                            </span>
                        </td>
                        <td style="padding: 12px;">
                            <a href="{{ route('kepala-sekolah.jurnal-pembelajaran.detail', $j->id_jurnal_mengajar) }}" style="background: #384972; color: #fff; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 11px;">
                                <i class="fa-solid fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #64748b;">Belum ada data jurnal mengajar yang sesuai filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 16px;">
            {{ $jurnals->links() }}
        </div>
    </div>

</div>
@endsection
