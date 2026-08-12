@extends('layouts.guru')

@section('title', 'Riwayat Jurnal — Jurnal ESEMKITA')
@section('header_title', 'Jadwal Mengajar Hari Ini (Jumat)')

@section('styles')
<style>
    .card-history {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .table-history {
        width: 100%;
        border-collapse: collapse;
        margin-top: 6px;
    }

    .table-history th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        padding: 14px 18px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-history td {
        padding: 16px 18px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
</style>
@endsection

@section('content')

    <div class="card-history">
        <div style="overflow-x: auto;">
            <table class="table-history">
                <thead>
                    <tr>
                        <th style="width: 120px;">TANGGAL</th>
                        <th style="width: 120px;">KELAS</th>
                        <th style="width: 160px;">MAPEL</th>
                        <th>MATERI</th>
                        <th style="width: 140px;">KEHADIRAN GURU</th>
                        <th style="width: 100px;">LAMPIRAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $j)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('Y-m-d') }}</td>
                            <td><strong>{{ $j->jadwal->kelas->nama_kelas ?? '-' }}</strong></td>
                            <td>{{ $j->jadwal->mapel->nama_mapel ?? '-' }}</td>
                            <td style="line-height: 1.5;">{{ $j->materi }}</td>
                            <td><strong>{{ $j->status_kehadiran_guru }}</strong></td>
                            <td>
                                @if($j->dokumentasi)
                                    <a href="{{ asset('storage/' . $j->dokumentasi) }}" target="_blank" style="color: #2563eb; font-weight:700;">Lihat Foto</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>2026-07-29</td>
                            <td><strong>XI RPL 1</strong></td>
                            <td>Konsentrasi RPL</td>
                            <td style="line-height: 1.5;">Pengenalan konsep Object-Oriented Programming (OOP): class, object, attribute, dan method beserta implementasi sederhana menggunakan Java.</td>
                            <td><strong>Hadir</strong></td>
                            <td>-</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
