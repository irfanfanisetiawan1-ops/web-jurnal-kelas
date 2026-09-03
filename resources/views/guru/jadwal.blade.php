@extends('layouts.guru')

@section('title', 'Jadwal Mengajar — EDU JOURNAL')
@section('header_title', 'Jadwal Mengajar Guru')

@section('styles')
<style>
    .jadwal-container-grid {
        display: grid;
        grid-template-columns: 2.3fr 1fr;
        gap: 24px;
    }

    @media (max-width: 1100px) {
        .jadwal-container-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Day Pills Selector */
    .day-selector-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        justify-content: flex-start;
        flex-wrap: wrap;
    }

    .day-pill {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px 24px;
        border-radius: 14px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        text-decoration: none;
        color: #475569;
        transition: all 0.2s ease;
        min-width: 90px;
    }

    .day-pill .day-name {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .day-pill .day-num {
        font-size: 18px;
        font-weight: 800;
        margin-top: 2px;
    }

    .day-pill.active {
        background: #384972;
        color: #ffffff;
        border-color: #384972;
        box-shadow: 0 4px 12px rgba(56, 73, 114, 0.25);
    }

    .day-pill:hover:not(.active) {
        background: #f1f5f9;
        color: #1e293b;
    }

    /* Table Container */
    .card-jadwal-table {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .table-schedule {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table-schedule th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #475569;
        padding: 12px 16px;
        text-align: left;
        letter-spacing: 0.5px;
    }

    .table-schedule tr.row-jadwal {
        border-radius: 12px;
        transition: transform 0.15s ease;
    }

    .table-schedule tr.row-jadwal td {
        padding: 16px;
        font-size: 13.5px;
        vertical-align: middle;
    }

    .table-schedule tr.row-jadwal td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .table-schedule tr.row-jadwal td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Status Row Styling */
    .row-selesai {
        background: #e2ebd8;
        color: #27401c;
    }

    .row-berlangsung {
        background: #fef3c7;
        color: #78350f;
    }

    .row-belum {
        background: #fee2e2;
        color: #991b1b;
    }

    .row-future {
        background: #e0f2fe;
        color: #075985;
    }

    /* Status Badges */
    .badge-status {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
    }

    .badge-status-selesai { background: #bbf7d0; color: #166534; }
    .badge-status-berlangsung { background: #d97706; color: #ffffff; }
    .badge-status-belum { background: #fca5a5; color: #991b1b; }

    /* Action Buttons */
    .btn-action-jurnal {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        transition: all 0.15s ease;
    }

    .btn-jurnal-isi { background: #384972; color: #ffffff; }
    .btn-jurnal-isi:hover { background: #2b395a; }

    .btn-jurnal-terisi { background: #ffffff; color: #166534; border: 1px solid #bbf7d0; }
    .btn-jurnal-belum { background: #ffffff; color: #94a3b8; border: 1px solid #e2e8f0; cursor: not-allowed; }

    /* Widgets */
    .widget-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .widget-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 14px;
    }

    .room-item {
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .room-item:last-child { border-bottom: none; }

    .room-name {
        font-size: 13.5px;
        font-weight: 800;
        color: #1e293b;
    }

    .room-time {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }

    .note-card {
        background: #384972;
        color: #ffffff;
        border-radius: 18px;
        padding: 20px;
    }

    .note-title {
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #cbd5e1;
        margin-bottom: 10px;
    }

    .note-text {
        font-size: 13px;
        line-height: 1.5;
        color: #f1f5f9;
        font-style: italic;
    }
</style>
@endsection

@section('content')

    <div style="margin-bottom: 20px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-calendar-days" style="color: #2563eb;"></i>
            Jadwal Mengajar
        </h1>
        <p style="font-size: 13.5px; color: #64748b; margin-top: 4px;">
            {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}
        </p>
    </div>

    <!-- Day Pills Navigation Bar -->
    @php
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $startOfWeek = $now->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
        $days = [
            'senin'  => ['name' => 'SENIN',  'num' => $startOfWeek->copy()->format('j')],
            'selasa' => ['name' => 'SELASA', 'num' => $startOfWeek->copy()->addDays(1)->format('j')],
            'rabu'   => ['name' => 'RABU',   'num' => $startOfWeek->copy()->addDays(2)->format('j')],
            'kamis'  => ['name' => 'KAMIS',  'num' => $startOfWeek->copy()->addDays(3)->format('j')],
            'jumat'  => ['name' => 'JUMAT',  'num' => $startOfWeek->copy()->addDays(4)->format('j')],
        ];
    @endphp

    <div class="day-selector-bar">
        @foreach($days as $key => $d)
            <a href="{{ route('guru.jadwal', ['hari' => $key]) }}" class="day-pill {{ strtolower($hariFilter) == $key ? 'active' : '' }}">
                <span class="day-name">{{ $d['name'] }}</span>
                <span class="day-num">{{ $d['num'] }}</span>
            </a>
        @endforeach
    </div>

    <!-- Grid Content -->
    <div class="jadwal-container-grid">
        
        <!-- Left: Schedule Table -->
        <div class="card-jadwal-table">
            <div style="overflow-x: auto;">
                <table class="table-schedule">
                    <thead>
                        <tr>
                            <th style="width: 120px;">JAM</th>
                            <th>NAMA / KELAS</th>
                            <th>MAPEL</th>
                            <th style="width: 120px;">RUANG</th>
                            <th style="width: 140px; text-align: center;">STATUS</th>
                            <th style="width: 140px; text-align: right;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $j)
                            @php
                                $sudahDiisi = $j->isDiisiHariIni();
                                $sudahMasuk = $j->sudah_masuk_jam;
                                
                                $rowClass = 'row-future';
                                $statusBadge = '<span class="badge-status badge-status-belum"><i class="fa-regular fa-clock"></i> Belum Dimulai</span>';
                                $actionBtn = '<button type="button" class="btn-action-jurnal btn-jurnal-belum" disabled style="cursor: not-allowed; opacity: 0.65; background: #e2e8f0; color: #64748b; border: 1px solid #cbd5e1;" title="Fitur isi jurnal baru bisa diisi saat jam pelajaran dimulai (Pukul ' . $j->waktu_mulai_effective . ' WIB)"><i class="fa-solid fa-lock"></i> Isi Jurnal</button>';

                                if ($sudahDiisi) {
                                    $rowClass = 'row-selesai';
                                    $statusBadge = '<span class="badge-status badge-status-selesai"><i class="fa-solid fa-circle-check"></i> Selesai</span>';
                                    $actionBtn = '<a href="' . route('guru.jurnal-harian', ['id_jadwal' => $j->id_jadwal]) . '" class="btn-action-jurnal btn-jurnal-terisi"><i class="fa-solid fa-check"></i> Jurnal Terisi</a>';
                                } elseif ($sudahMasuk) {
                                    $rowClass = 'row-berlangsung';
                                    $statusBadge = '<span class="badge-status badge-status-berlangsung"><i class="fa-solid fa-signal"></i> Berlangsung</span>';
                                    $actionBtn = '<a href="' . route('guru.jurnal-harian', ['id_jadwal' => $j->id_jadwal]) . '" class="btn-action-jurnal btn-jurnal-isi"><i class="fa-solid fa-pen-to-square"></i> Isi Jurnal</a>';
                                }
                            @endphp
                            <tr class="row-jadwal {{ $rowClass }}">
                                <td>
                                    <strong>{{ $j->waktu_mulai_effective }}</strong>
                                    <div style="font-size: 11.5px; opacity: 0.8;">{{ $j->waktu_selesai_effective }}</div>
                                </td>
                                <td>
                                    <strong>{{ $j->kelas->nama_kelas ?? 'XI RPL 1' }}</strong>
                                    <div style="font-size: 11.5px; opacity: 0.85;">{{ $j->guru->nama_guru ?? Auth::user()->name }}</div>
                                </td>
                                <td>
                                    <strong>{{ $j->mapel->nama_mapel ?? 'Konsentrasi Keahlian' }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $j->ruangan->nama_ruangan ?? 'RUANG 53' }}</strong>
                                </td>
                                <td style="text-align: center;">
                                    {!! $statusBadge !!}
                                </td>
                                <td style="text-align: right;">
                                    {!! $actionBtn !!}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 24px;">Tidak ada jadwal mengajar pada hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Widgets -->
        <div>
            <!-- Widget 1: Ringkasan Mengajar & Progres Jurnal Hari Ini -->
            <div class="widget-box" style="border-top: 4px solid #2563eb; background: #ffffff;">
                <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fa-solid fa-chart-pie" style="color: #2563eb; margin-right: 6px;"></i> Progres Jurnal Hari Ini</span>
                    <span style="font-size: 11px; background: #dcfce7; color: #15803d; padding: 3px 9px; border-radius: 6px; font-weight: 800;">
                        {{ $statsProgres['persen'] ?? 100 }}%
                    </span>
                </div>
                <div style="margin-top: 12px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px;">
                        <span>Status Terisi</span>
                        <span style="color: #0f172a;">{{ $statsProgres['terisi'] ?? 0 }} / {{ $statsProgres['total'] ?? 0 }} Kelas</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #f1f5f9; border-radius: 6px; overflow: hidden; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                        <div style="width: {{ $statsProgres['persen'] ?? 100 }}%; height: 100%; background: linear-gradient(90deg, #2563eb, #3b82f6); border-radius: 6px; transition: width 0.3s ease;"></div>
                    </div>

                    <!-- Shortcut Action Buttons -->
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <a href="{{ route('guru.jurnal-harian') }}" class="btn-action-jurnal" style="background: #2563eb; color: #ffffff; width: 100%; justify-content: center; padding: 10px; border-radius: 10px; font-weight: 800; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);">
                            <i class="fa-solid fa-pen-to-square"></i> Isi Jurnal Harian
                        </a>
                        <a href="{{ route('guru.absensi-siswa') }}" class="btn-action-jurnal" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1; width: 100%; justify-content: center; padding: 9px; border-radius: 10px; font-weight: 700; transition: background 0.15s ease;">
                            <i class="fa-solid fa-users" style="color: #2563eb;"></i> Presensi Siswa
                        </a>
                    </div>
                </div>
            </div>

            <!-- Widget 2: Beban & Rincian Jam Mengajar (JP) -->
            <div class="widget-box" style="border-top: 4px solid #0284c7; background: #ffffff;">
                <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fa-solid fa-briefcase" style="color: #0284c7; margin-right: 6px;"></i> Beban Mengajar (JP)</span>
                    <span style="font-size: 11px; background: #e0f2fe; color: #0369a1; padding: 3px 9px; border-radius: 6px; font-weight: 800;">
                        {{ $statsBeban['totalJpSeminggu'] ?? 0 }} JP / MINGGU
                    </span>
                </div>
                <div style="margin-top: 12px;">
                    <!-- Ringkasan Jam Hari Ini vs Terlaksana -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; margin-bottom: 14px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; text-align: center;">
                        <div style="border-right: 1px solid #e2e8f0;">
                            <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Jam Hari Ini</div>
                            <div style="font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 2px;">{{ $statsBeban['totalJpHariIni'] ?? 0 }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">JP</span></div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: #15803d; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">JP Terlaksana</div>
                            <div style="font-size: 20px; font-weight: 800; color: #166534; margin-top: 2px;">{{ $statsBeban['totalJpTerisiHariIni'] ?? 0 }} <span style="font-size: 11px; font-weight: 600; color: #15803d;">JP</span></div>
                        </div>
                    </div>

                    <!-- Breakdown Beban Mengajar Per Hari -->
                    <div style="font-size: 12px; font-weight: 800; color: #475569; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-regular fa-calendar-days" style="color: #0284c7;"></i> Sebaran JP Minggu Ini</span>
                        <span style="font-size: 11px; font-weight: 600; color: #64748b;">Senin – Jumat</span>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px; margin-bottom: 8px;">
                        @php
                            $daysMap = ['senin' => 'SEN', 'selasa' => 'SEL', 'rabu' => 'RAB', 'kamis' => 'KAM', 'jumat' => 'JUM'];
                        @endphp
                        @foreach($daysMap as $hKey => $hShort)
                            @php
                                $jpVal = $statsBeban['jpHarian'][$hKey] ?? 0;
                                $isCurrent = strtolower($hariFilter) === $hKey;
                            @endphp
                            <a href="{{ route('guru.jadwal', ['hari' => $hKey]) }}" style="text-decoration: none;">
                                <div style="padding: 8px 4px; border-radius: 10px; text-align: center; border: 1px solid {{ $isCurrent ? '#0284c7' : '#cbd5e1' }}; background: {{ $isCurrent ? '#0284c7' : ($jpVal > 0 ? '#f0f9ff' : '#f8fafc') }}; color: {{ $isCurrent ? '#ffffff' : ($jpVal > 0 ? '#0369a1' : '#94a3b8') }}; transition: all 0.15s ease;">
                                    <div style="font-size: 10px; font-weight: 800;">{{ $hShort }}</div>
                                    <div style="font-size: 13px; font-weight: 800; margin-top: 2px;">{{ $jpVal }}<span style="font-size: 9px; font-weight: 600;"> JP</span></div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Widget 3: Fitur Kontekstual Role (Wali Kelas / Guru Mengajar) -->
            @if(isset($isWaliKelas) && $isWaliKelas && !empty($dataWaliKelas))
                <!-- Card Khusus Role Wali Kelas -->
                <div class="widget-box" style="border-top: 4px solid #2563eb; background: #ffffff;">
                    <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-solid fa-graduation-cap" style="color: #2563eb; margin-right: 6px;"></i> Kelas Wali: {{ $dataWaliKelas['kelas']->nama_kelas ?? 'Wali Kelas' }}</span>
                        <span style="font-size: 10px; background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 6px; font-weight: 800;">WALI KELAS</span>
                    </div>
                    <div style="margin-top: 10px;">
                        <div style="font-size: 12px; color: #475569; margin-bottom: 10px;">
                            <strong>Total Siswa:</strong> {{ $dataWaliKelas['totalSiswa'] ?? 0 }} Siswa | <strong>Jurnal Terisi Hari Ini:</strong> {{ $dataWaliKelas['jurnalTerisi'] ?? 0 }} Mapel
                        </div>
                        <!-- Status Kehadiran Kelas Wali Hari Ini -->
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; text-align: center; margin-bottom: 14px;">
                            <div style="background: #dcfce7; padding: 6px 2px; border-radius: 8px; border: 1px solid #bbf7d0;">
                                <div style="font-size: 10px; font-weight: 800; color: #166534;">HADIR</div>
                                <div style="font-size: 14px; font-weight: 800; color: #15803d;">{{ $dataWaliKelas['totalHadir'] ?? 0 }}</div>
                            </div>
                            <div style="background: #fef9c3; padding: 6px 2px; border-radius: 8px; border: 1px solid #fef08a;">
                                <div style="font-size: 10px; font-weight: 800; color: #854d0e;">SAKIT</div>
                                <div style="font-size: 14px; font-weight: 800; color: #a16207;">{{ $dataWaliKelas['rekapAbsensi']['sakit'] ?? 0 }}</div>
                            </div>
                            <div style="background: #e0f2fe; padding: 6px 2px; border-radius: 8px; border: 1px solid #bae6fd;">
                                <div style="font-size: 10px; font-weight: 800; color: #075985;">IZIN</div>
                                <div style="font-size: 14px; font-weight: 800; color: #0369a1;">{{ $dataWaliKelas['rekapAbsensi']['izin'] ?? 0 }}</div>
                            </div>
                            <div style="background: #fee2e2; padding: 6px 2px; border-radius: 8px; border: 1px solid #fca5a5;">
                                <div style="font-size: 10px; font-weight: 800; color: #991b1b;">ALPA</div>
                                <div style="font-size: 14px; font-weight: 800; color: #b91c1c;">{{ $dataWaliKelas['rekapAbsensi']['alpa'] ?? 0 }}</div>
                            </div>
                        </div>

                        <a href="{{ route('guru.kehadiran-kelas') }}" class="btn-action-jurnal" style="background: #2563eb; color: #ffffff; width: 100%; justify-content: center; padding: 9.5px; border-radius: 10px; font-weight: 700; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);">
                            <i class="fa-solid fa-users-viewfinder"></i> Rekap Presensi Kelas Wali
                        </a>
                    </div>
                </div>
            @else
                <!-- Card Ringkasan Kelas Ampuhan (Guru Mengajar Regular) -->
                <div class="widget-box" style="border-top: 4px solid #384972; background: #ffffff;">
                    <div class="widget-title" style="display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-solid fa-chalkboard-user" style="color: #384972; margin-right: 6px;"></i> Ringkasan Mengajar</span>
                        <span style="font-size: 10px; background: #f1f5f9; color: #334155; padding: 3px 8px; border-radius: 6px; font-weight: 800; border: 1px solid #e2e8f0;">GURU MENGAJAR</span>
                    </div>
                    <div style="margin-top: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px;">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 11px; font-weight: 700; color: #475569; text-transform: uppercase;">Total Kelas</div>
                            <div style="font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 2px;">{{ $statsBeban['totalKelasDiajar'] ?? 0 }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Kelas</span></div>
                        </div>
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 11px; font-weight: 700; color: #475569; text-transform: uppercase;">Mata Pelajaran</div>
                            <div style="font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 2px;">{{ $statsBeban['totalMapelDiajar'] ?? 0 }} <span style="font-size: 11px; font-weight: 600; color: #64748b;">Mapel</span></div>
                        </div>
                    </div>
                    <a href="{{ route('guru.riwayat-jurnal') }}" class="btn-action-jurnal" style="background: #384972; color: #ffffff; width: 100%; justify-content: center; padding: 9.5px; border-radius: 10px; font-weight: 700; box-shadow: 0 2px 6px rgba(56, 73, 114, 0.2);">
                        <i class="fa-solid fa-book-open"></i> Lihat Riwayat Jurnal
                    </a>
                </div>
            @endif
        </div>

    </div>

@endsection
