@extends('layouts.waka_kurikulum')

@section('title', 'Mata Pelajaran Kurikulum — Waka Kurikulum')

@section('styles')
<style>
    .mapel-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        box-sizing: border-box;
    }

    .page-header-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        width: 100%;
    }

    .page-main-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .page-sub-title {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin-top: 3px;
    }

    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        width: 100%;
    }

    .stat-card-item {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .stat-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .icon-purple { background: #faf5ff; color: #9333ea; }
    .icon-blue   { background: #eff6ff; color: #2563eb; }

    .stat-title { font-size: 12px; font-weight: 700; color: #64748b; }
    .stat-count { font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 1px; }

    .table-wrapper-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .filter-bar {
        padding: 16px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input {
        padding: 8px 14px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        width: 280px;
    }

    .search-input:focus { border-color: #2563eb; }

    .mapel-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 750px;
    }

    .mapel-table th {
        background: #f8fafc;
        padding: 12px 14px;
        text-align: left;
        font-weight: 800;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
    }

    .mapel-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .mapel-table tr:hover td { background: #f8fafc; }

    .badge-code {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 800;
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .badge-group {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        background: #f1f5f9;
        color: #475569;
    }
</style>
@endsection

@section('content')
<div class="mapel-container">

    {{-- Page Header --}}
    <div class="page-header-box">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">
                Jurnal SMEA &gt; Portal Kurikulum &gt; <span style="color: #2563eb;">Struktur Mata Pelajaran</span>
            </div>
            <h1 class="page-main-title">Mata Pelajaran Kurikulum</h1>
            <p class="page-sub-title">SMK Negeri 1 Boyolangu — Struktur Kurikulum Mata Pelajaran, Kelompok Muatan &amp; Distribusi Jam</p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="stat-cards-grid">
        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-purple">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <div style="display: flex; flex-direction: column;">
                <span class="stat-title">Total Mata Pelajaran</span>
                <span class="stat-count">{{ number_format($totalMapel, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="stat-card-item">
            <div class="stat-icon-wrapper icon-blue">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div style="display: flex; flex-direction: column;">
                <span class="stat-title">Total Sesi KBM Terjadwal</span>
                <span class="stat-count">{{ number_format($totalJadwal, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="table-wrapper-card">
        <div class="filter-bar">
            <form method="GET" action="{{ route('waka-kurikulum.mapel') }}" style="display: flex; gap: 8px;">
                <input type="text" name="search" value="{{ $search }}" class="search-input" placeholder="Cari nama mapel / kode / kelompok...">
                <button type="submit" style="padding: 8px 14px; border-radius: 8px; background: #2563eb; color: #ffffff; border: none; font-weight: 700; cursor: pointer;">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                </button>
                @if(!empty($search))
                    <a href="{{ route('waka-kurikulum.mapel') }}" style="padding: 8px 14px; border-radius: 8px; background: #f1f5f9; color: #475569; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center;">
                        Reset
                    </a>
                @endif
            </form>
            <span style="font-size: 12.5px; color: #64748b; font-weight: 600;">
                Menampilkan {{ $mapelList->count() }} dari {{ $mapelList->total() }} Mata Pelajaran
            </span>
        </div>

        <div style="overflow-x: auto;">
            <table class="mapel-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th style="width: 130px;">KODE MAPEL</th>
                        <th>NAMA MATA PELAJARAN</th>
                        <th>KELOMPOK / MUATAN</th>
                        <th style="text-align: center; width: 140px;">ALOKASI JAM</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapelList as $index => $m)
                        <tr>
                            <td style="font-weight: 700; color: #64748b;">
                                {{ $mapelList->firstItem() + $index }}
                            </td>
                            <td>
                                <span class="badge-code">{{ $m->kode_mapel ?? 'MPL' }}</span>
                            </td>
                            <td style="font-weight: 800; color: #0f172a;">
                                {{ $m->nama_mapel }}
                            </td>
                            <td>
                                <span class="badge-group">
                                    {{ $m->kelompok ?? 'Muatan Kejuruan / Umum' }}
                                </span>
                            </td>
                            <td style="text-align: center; font-weight: 700; color: #2563eb;">
                                {{ $m->jumlah_jam ?? 2 }} JP / Minggu
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 36px; color: #94a3b8;">
                                <i class="fa-solid fa-book" style="font-size: 32px; margin-bottom: 8px;"></i>
                                <p style="font-weight: 700;">Tidak ada mata pelajaran yang ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9;">
            {{ $mapelList->links('partials.custom-pagination') }}
        </div>
    </div>

</div>
@endsection
