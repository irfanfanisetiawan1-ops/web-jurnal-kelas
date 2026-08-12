@extends('layouts.guru')

@php
    $isPiket = Auth::check() && Auth::user()->isGuruPiket();
@endphp

@section('title', $isPiket ? 'Dashboard Piket — Jurnal ESEMKITA' : 'Dashboard Guru — Jurnal ESEMKITA')
@section('header_title', $isPiket ? 'Pantauan Kelas Real-time (' . $hariIni . ')' : 'Jadwal Mengajar Hari Ini (' . $hariIni . ')')

@section('styles')
<style>
    .card-schedule {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .card-schedule h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 20px;
        letter-spacing: -0.01em;
    }

    .table-schedule {
        width: 100%;
        border-collapse: collapse;
        margin-top: 6px;
    }

    .table-schedule th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        padding: 14px 18px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-schedule td {
        padding: 16px 18px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .time-badge {
        font-size: 12px;
        color: #475569;
        font-weight: 600;
        margin-top: 4px;
    }
</style>
@endsection

@section('content')

    <div class="card-schedule">
        @if($isPiket)
            <h2>Jadwal & Status Kelas Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</h2>
        @endif

        <div style="overflow-x: auto;">
            <table class="table-schedule">
                <thead>
                    @if($isPiket)
                        <tr>
                            <th style="width: 160px;">JAM KE-</th>
                            <th style="width: 140px;">KELAS</th>
                            <th>GURU dan Mapel</th>
                            <th style="width: 180px;">STATUS KELAS</th>
                            <th style="width: 180px;">DETAIL JURNAL/SURAT</th>
                        </tr>
                    @else
                        <tr>
                            <th style="width: 180px;">JAM KE-</th>
                            <th style="width: 160px;">KELAS</th>
                            <th>MAPEL</th>
                            <th>RUANGAN</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @forelse($jadwals as $j)
                        @php
                            $jamTimes = [
                                1 => ['07:00', '07:45'],
                                2 => ['07:45', '08:30'],
                                3 => ['08:30', '09:15'],
                                4 => ['09:30', '10:15'],
                                5 => ['10:15', '11:00'],
                                6 => ['11:00', '11:45'],
                                7 => ['12:30', '13:15'],
                                8 => ['13:15', '14:00'],
                                9 => ['14:00', '14:45'],
                                10 => ['14:45', '15:30'],
                            ];

                            $mulaiJam   = $j->id_jam_mulai ?? 1;
                            $selesaiJam = $j->id_jam_selesai ?? $mulaiJam;
                            
                            $waktuMulai   = $jamTimes[$mulaiJam][0] ?? '07:00';
                            $waktuSelesai = $jamTimes[$selesaiJam][1] ?? '15:30';
                        @endphp
                        <tr>
                            <td>
                                <strong>
                                    {{ $j->jam_range }}
                                </strong>
                                <br>
                                <div class="time-badge">
                                    {{ $waktuMulai }} - {{ $waktuSelesai }}
                                </div>
                            </td>
                            <td><strong>{{ $j->kelas->nama_kelas ?? '-' }}</strong></td>
                            
                            @if($isPiket)
                                <td>
                                    <strong>{{ $j->guru->nama_guru ?? 'Rifkotin Na\'imah, S.Pd' }}</strong>
                                    <br>
                                    <span style="color: #64748b; font-size: 13px; font-weight: 500;">
                                        {{ $j->mapel->nama_mapel ?? 'Dasar TKI' }}
                                    </span>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: #475569;">Belum Mulai</span>
                                </td>
                                <td>-</td>
                            @else
                                <td><strong>{{ $j->mapel->nama_mapel ?? '-' }}</strong></td>
                                <td>{{ $j->ruangan->nama_ruangan ?? '-' }}</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <strong>2 - 3</strong><br>
                                <div class="time-badge">07:40 - 09:00</div>
                            </td>
                            <td><strong>X AK 1</strong></td>
                            @if($isPiket)
                                <td>
                                    <strong>Rifkotin Na'imah, S.Pd</strong><br>
                                    <span style="color:#64748b; font-size:13px;">Dasar TKI</span>
                                </td>
                                <td><span style="font-weight: 600; color: #475569;">Belum Mulai</span></td>
                                <td>-</td>
                            @else
                                <td><strong>Koding dan Kecerdasan Artifisial</strong></td>
                                <td>Lab. AK ATAS</td>
                            @endif
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
