@extends('layouts.admin')

@section('title', 'Detail Jam Pelajaran — ' . $jamPelajaran->jam_ke)

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

    .detail-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        padding-bottom: 24px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .avatar-large {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        background: linear-gradient(135deg, #3b5490, #2563eb);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        font-weight: 800;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
    }

    .profile-info h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .time-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #e0e7ff;
        color: #3730a3;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 13.5px;
        font-weight: 800;
        font-family: monospace;
        border: 1px solid #c7d2fe;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .info-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        border-radius: 14px;
    }

    .info-item .label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 6px;
    }

    .info-item .value {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    .action-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
    }

    .btn-act {
        padding: 11px 22px;
        font-size: 13.5px;
        font-weight: 700;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.15s ease;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .btn-act-back {
        background: #f1f5f9;
        color: #475569;
        border-color: #cbd5e1;
    }
    .btn-act-back:hover { background: #e2e8f0; }

    .btn-act-edit {
        background: #fef3c7;
        color: #b45309;
        border-color: #fde68a;
    }
    .btn-act-edit:hover { background: #d97706; color: #ffffff; }

    .btn-act-delete {
        background: #ffe4e6;
        color: #be123c;
        border-color: #fecdd3;
    }
    .btn-act-delete:hover { background: #e11d48; color: #ffffff; }

    .table-responsive {
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        padding: 14px 16px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
</style>
@endsection

@section('content')

    <div class="breadcrumb-text">
        <a href="{{ route('jam-pelajaran.index') }}"><i class="fa-regular fa-clock"></i> Master Jam Pelajaran</a>
        <i class="fa-solid fa-chevron-right" style="font-size:11px; color:#94a3b8;"></i>
        <span>Detail Sesi Jam</span>
    </div>

    <div class="detail-card">
        <div class="profile-header">
            <div class="avatar-large"><i class="fa-regular fa-clock"></i></div>
            <div class="profile-info">
                <h1>{{ $jamPelajaran->jam_ke }}</h1>
                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:6px;">
                    @if($jamPelajaran->waktu_senin_kamis !== '-')
                        <span class="time-pill" style="background:#f1f5f9; color:#1e293b; border-color:#cbd5e1;">
                            <i class="fa-solid fa-calendar-days"></i> Senin-Kamis: {{ $jamPelajaran->waktu_senin_kamis }} WIB (40m)
                        </span>
                    @endif
                    <span class="time-pill" style="background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe;">
                        <i class="fa-solid fa-calendar-days"></i> Jumat: {{ $jamPelajaran->waktu_jumat }} WIB (30m)
                    </span>
                </div>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="label">Label Sesi Jam</div>
                <div class="value" style="font-weight:800; color:#0f172a;">{{ $jamPelajaran->jam_ke }}</div>
            </div>

            <div class="info-item">
                <div class="label">Waktu Senin - Kamis (1 Jam = 40m)</div>
                <div class="value" style="font-family:monospace; color:#1e293b; font-weight:800;">{{ $jamPelajaran->waktu_senin_kamis }} WIB</div>
            </div>

            <div class="info-item">
                <div class="label">Waktu Hari Jumat (1 Jam = 30m)</div>
                <div class="value" style="font-family:monospace; color:#2563eb; font-weight:800;">{{ $jamPelajaran->waktu_jumat }} WIB</div>
            </div>

            <div class="info-item">
                <div class="label">Keterangan / Catatan Sesi</div>
                <div class="value">{{ $jamPelajaran->keterangan ?? 'Pembelajaran Reguler' }}</div>
            </div>
        </div>

        <div class="action-row">
            <a href="{{ route('jam-pelajaran.index') }}" class="btn-act btn-act-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Master Jam
            </a>
            <a href="{{ route('jam-pelajaran.edit', $jamPelajaran->id_jam) }}" class="btn-act btn-act-edit">
                <i class="fa-solid fa-pen-to-square"></i> Edit Sesi Jam
            </a>
            <form action="{{ route('jam-pelajaran.destroy', $jamPelajaran->id_jam) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-act btn-act-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus jam pelajaran {{ addslashes($jamPelajaran->jam_ke) }}?')">
                    <i class="fa-solid fa-trash-can"></i> Hapus Jam
                </button>
            </form>
        </div>
    </div>

    <!-- Daftar Jadwal yang Berlangsung pada Jam Ini -->
    <div class="detail-card">
        @php
            $activeJadwals = $jadwals ?? ($jamPelajaran->jadwals_active ?? collect());
        @endphp
        <h2 style="font-size:18px; font-weight:800; color:#0f172a; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-calendar-days" style="color:#2563eb;"></i> Jadwal Pelajaran Terdaftar ({{ count($activeJadwals) }})
        </h2>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>HARI</th>
                        <th>RENTANG JAM</th>
                        <th>KELAS</th>
                        <th>MATA PELAJARAN</th>
                        <th>GURU PENGAMPU</th>
                        <th>RUANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeJadwals as $j)
                        <tr>
                            <td><strong>{{ $j->hari ?? '-' }}</strong></td>
                            <td><span style="background:#e0e7ff; color:#3730a3; padding:4px 10px; border-radius:8px; font-weight:700; font-size:12px;">{{ $j->jam_range_formatted }}</span></td>
                            <td><strong>{{ $j->kelas->nama_kelas ?? '-' }}</strong></td>
                            <td><strong>{{ $j->mapel->nama_mapel ?? '-' }}</strong></td>
                            <td>{{ $j->guru->nama_guru ?? '-' }}</td>
                            <td>{{ $j->ruangan->nama_ruangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:32px; color:#94a3b8;">
                                Belum ada jadwal kelas yang terdaftar pada sesi jam ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
