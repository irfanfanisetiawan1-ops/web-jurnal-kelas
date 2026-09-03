@extends('layouts.guru')

@section('title', 'Presensi Siswa — EDU JOURNAL')
@section('header_title', 'Presensi Siswa')

@section('styles')
<style>
    .presensi-grid {
        display: grid;
        grid-template-columns: 2.3fr 1fr;
        gap: 24px;
    }

    @media (max-width: 1100px) {
        .presensi-grid {
            grid-template-columns: 1fr;
        }
    }

    .main-presensi-box {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .btn-simpan-top {
        background: #384972;
        color: #ffffff;
        padding: 9px 20px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 13.5px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 3px 10px rgba(56, 73, 114, 0.2);
        transition: background 0.15s ease;
    }

    .btn-simpan-top:hover {
        background: #2b395a;
    }

    .student-card-item {
        background: #fdfbf7;
        border: 1px solid #f3ebe0;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .avatar-initial {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #d6ccc2;
        color: #1e293b;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .student-name {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
    }

    .student-nisn {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }

    /* SIAD Radio Buttons */
    .siad-buttons {
        display: flex;
        gap: 8px;
    }

    .siad-btn {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-weight: 800;
        font-size: 13.5px;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .siad-input { display: none; }

    /* Active colors matching mockup */
    .siad-input-s:checked + .siad-btn { background: #b5838d; color: #ffffff; border-color: #b5838d; } /* S - Sakit (Gold/Brown) */
    .siad-input-s:checked + .siad-btn-s { background: #a37c00; color: #ffffff; border-color: #a37c00; }
    .siad-input-i:checked + .siad-btn-i { background: #3b9ab2; color: #ffffff; border-color: #3b9ab2; } /* I - Izin (Teal) */
    .siad-input-a:checked + .siad-btn-a { background: #780000; color: #ffffff; border-color: #780000; } /* A - Alpa (Maroon) */
    .siad-input-d:checked + .siad-btn-d { background: #4a5568; color: #ffffff; border-color: #4a5568; } /* D - Dispen (Dark Grey) */

    /* Widgets */
    .widget-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .widget-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 14px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
    }

    .summary-row:last-child { border-bottom: none; }

    .summary-label {
        font-weight: 600;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-val {
        font-weight: 800;
        color: #0f172a;
        font-size: 15px;
    }

    .dot-bullet {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
</style>
@endsection

@section('content')

    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-user-check" style="color: #2563eb;"></i>
                Presensi Siswa
            </h1>
            <p style="font-size: 13.5px; color: #64748b; margin-top: 4px;">
                KK RPL – Kelas XI RPL • 08.30–10.00
            </p>
        </div>
        <button type="button" onclick="document.getElementById('formPresensi').submit()" class="btn-simpan-top">
            <i class="fa-solid fa-check"></i> Simpan
        </button>
    </div>

    <!-- Main Presensi Grid -->
    <div class="presensi-grid">
        
        <!-- Left: List of Students for Attendance -->
        <div class="main-presensi-box">
            <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 20px;">Daftar Siswa Yang Tidak Hadir</h2>

            <form id="formPresensi" method="POST" action="{{ route('guru.absensi-siswa.store') }}">
                @csrf
                @foreach($siswas as $idx => $s)
                    @php
                        $nameArr = explode(' ', $s->nama_siswa);
                        $initials = strtoupper(substr($nameArr[0] ?? 'S', 0, 1) . substr($nameArr[1] ?? '', 0, 1));
                        
                        // Demo selections matching mockup
                        $defaultState = '';
                        if ($idx == 0) $defaultState = 'S';
                        elseif ($idx == 1) $defaultState = 'I';
                        elseif ($idx == 2) $defaultState = 'A';
                        elseif ($idx == 3) $defaultState = 'D';
                    @endphp
                    <div class="student-card-item">
                        <div class="student-info">
                            <div class="avatar-initial">{{ $initials }}</div>
                            <div>
                                <div class="student-name">{{ $s->nama_siswa }}</div>
                                <div class="student-nisn">NISN {{ $s->nisn ?? ('2308144' . (300 + $idx)) }}</div>
                            </div>
                        </div>

                        <!-- SIAD Radio Options -->
                        <div class="siad-buttons">
                            <div>
                                <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="s_{{ $s->id_siswa }}" value="Sakit" class="siad-input siad-input-s" {{ $defaultState == 'S' ? 'checked' : '' }}>
                                <label for="s_{{ $s->id_siswa }}" class="siad-btn siad-btn-s">S</label>
                            </div>

                            <div>
                                <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="i_{{ $s->id_siswa }}" value="Izin" class="siad-input siad-input-i" {{ $defaultState == 'I' ? 'checked' : '' }}>
                                <label for="i_{{ $s->id_siswa }}" class="siad-btn siad-btn-i">I</label>
                            </div>

                            <div>
                                <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="a_{{ $s->id_siswa }}" value="Alpa" class="siad-input siad-input-a" {{ $defaultState == 'A' ? 'checked' : '' }}>
                                <label for="a_{{ $s->id_siswa }}" class="siad-btn siad-btn-a">A</label>
                            </div>

                            <div>
                                <input type="radio" name="absensi[{{ $s->id_siswa }}]" id="d_{{ $s->id_siswa }}" value="Dispen" class="siad-input siad-input-d" {{ $defaultState == 'D' ? 'checked' : '' }}>
                                <label for="d_{{ $s->id_siswa }}" class="siad-btn siad-btn-d">D</label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </form>
        </div>

        <!-- Right Side Widgets -->
        <div>
            <!-- Ringkasan Presensi -->
            <div class="widget-card">
                <div class="widget-title">Ringkasan Presensi</div>
                <div>
                    <div class="summary-row">
                        <span class="summary-label">Jumlah siswa</span>
                        <span class="summary-val">{{ $ringkasanPresensi['total'] ?? 32 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #a37c00;"></span> Sakit</span>
                        <span class="summary-val">{{ $ringkasanPresensi['sakit'] ?? 1 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #3b9ab2;"></span> Izin</span>
                        <span class="summary-val">{{ $ringkasanPresensi['izin'] ?? 1 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #780000;"></span> Alpa</span>
                        <span class="summary-val">{{ $ringkasanPresensi['alpa'] ?? 1 }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label"><span class="dot-bullet" style="background: #4a5568;"></span> Dispen</span>
                        <span class="summary-val">{{ $ringkasanPresensi['dispen'] ?? 1 }}</span>
                    </div>
                </div>
            </div>

            <!-- Riwayat Absensi Rendah -->
            <div class="widget-card">
                <div class="widget-title">Riwayat Absensi Rendah</div>
                <div>
                    @foreach($absensiRendah as $ar)
                        <div style="margin-bottom: 8px;">
                            <div style="font-size: 13.5px; font-weight: 800; color: #1e293b;">{{ $ar->nama_siswa }}</div>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">{{ $ar->keterangan }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Riwayat Absensi Tinggi -->
            <div class="widget-card">
                <div class="widget-title">Riwayat Absensi Tinggi</div>
                <div>
                    @foreach($absensiTinggi as $at)
                        <div style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9;">
                            <div style="font-size: 13.5px; font-weight: 800; color: #1e293b;">{{ $at->nama_siswa }}</div>
                            <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">{{ $at->keterangan }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

@endsection
