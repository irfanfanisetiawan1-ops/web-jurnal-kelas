@extends('layouts.kepala_sekolah')

@section('title', 'Kehadiran Siswa — Jurnal SMEA')

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px; padding-bottom: 40px;">

    <!-- 1. Page Header Banner (Tombol Aksi di Sebelah Kanan Atas) -->
    <div style="background: #ffffff; padding: 24px 28px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px;">
        <div style="flex: 1; min-width: 280px;">
            <div style="font-size: 12.5px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                DATA MASTER <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #94a3b8;"></i> <span style="color: #1e293b; font-weight: 800;">kehadiran siswa</span>
            </div>
            <h1 style="font-size: 23px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px; letter-spacing: -0.01em;">
                <i class="fa-solid fa-users" style="color: #384972;"></i> Kehadiran Siswa Per Kelas & Rekapitulasi Presensi
            </h1>
            <p style="margin: 6px 0 0 0; color: #64748b; font-size: 13.5px; font-weight: 500;">
                Pemantauan langsung persentase kehadiran siswa, rekap per rombel kelas, dan status ketidakhadiran (Sakit, Izin, Alpa, Dispensasi).
            </p>
        </div>

        <!-- Action Header Buttons: Terletak Rapi di Sebelah KANAN -->
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; justify-content: flex-end;">
            <button type="button" onclick="openModalCetakKehadiran()" style="background: #384972; color: #ffffff; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(56, 73, 114, 0.25); transition: all 0.2s;">
                <i class="fa-solid fa-print"></i> Cetak Rekap Presensi
            </button>
            <a href="{{ route('kepala-sekolah.kehadiran-siswa', array_merge(request()->all(), ['export' => 'csv'])) }}" style="background: #10b981; color: #ffffff; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25); transition: all 0.2s;">
                <i class="fa-solid fa-file-excel"></i> Export CSV
            </a>
            <a href="{{ route('kepala-sekolah.kehadiran-siswa') }}" title="Muat Ulang Halaman" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 10px 14px; border-radius: 10px; font-weight: 700; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>

    <!-- 2. KPI Executive Stat Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 16px;">
        <!-- Card 1: Total Siswa -->
        <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-bottom: 4px;">TOTAL SISWA TERDAFTAR</div>
                <div style="font-size: 26px; font-weight: 900; color: #0f172a;">{{ $totalSiswaReal }}</div>
                <div style="font-size: 11.5px; color: #384972; font-weight: 600; margin-top: 4px;">Di Seluruh Rombel Kelas</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #e0e7ff; color: #3730a3; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <!-- Card 2: Rata-rata Kehadiran -->
        <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-bottom: 4px;">RATA-RATA KEHADIRAN</div>
                <div style="font-size: 26px; font-weight: 900; color: #16a34a;">{{ $avgPersentase }}%</div>
                <div style="font-size: 11.5px; color: #16a34a; font-weight: 600; margin-top: 4px;">Tingkat Partisipasi Siswa</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>

        <!-- Card 3: Siswa Hadir -->
        <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-bottom: 4px;">SISWA HADIR KBM</div>
                <div style="font-size: 26px; font-weight: 900; color: #2563eb;">{{ $grandTotalHadir }}</div>
                <div style="font-size: 11.5px; color: #2563eb; font-weight: 600; margin-top: 4px;">Mengikuti Pembelajaran</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <!-- Card 4: Siswa Tidak Hadir -->
        <div style="background: #ffffff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 12.5px; font-weight: 700; color: #64748b; margin-bottom: 4px;">TIDAK HADIR TODAY</div>
                <div style="font-size: 26px; font-weight: 900; color: #d97706;">{{ $grandTotalAbsen }}</div>
                <div style="font-size: 11.5px; color: #d97706; font-weight: 600; margin-top: 4px;">Sakit, Izin, Alpa & Dispen</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-user-xmark"></i>
            </div>
        </div>
    </div>

    <!-- 3. Global Filter & Search Toolbar (Dengan Fitur Reset Permanen) -->
    <div style="background: #ffffff; padding: 18px 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <form method="GET" action="{{ route('kepala-sekolah.kehadiran-siswa') }}" id="filterFormKehadiran" style="display: flex; flex-wrap: wrap; align-items: center; gap: 14px; justify-content: space-between;">
            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 12px; flex: 1;">
                <!-- Filter Tanggal -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <label style="font-size: 13px; font-weight: 700; color: #475569; white-space: nowrap;"><i class="fa-solid fa-calendar-day" style="color: #384972;"></i> Tanggal:</label>
                    <input type="date" name="tanggal" value="{{ $filterTanggal }}" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #1e293b; background: #f8fafc;">
                </div>

                <!-- Filter Jurusan -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <label style="font-size: 13px; font-weight: 700; color: #475569; white-space: nowrap;"><i class="fa-solid fa-graduation-cap" style="color: #384972;"></i> Jurusan:</label>
                    <select name="id_jurusan" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #1e293b; background: #f8fafc; min-width: 140px;">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusanList as $jur)
                            <option value="{{ $jur->id_jurusan }}" {{ request('id_jurusan') == $jur->id_jurusan ? 'selected' : '' }}>
                                {{ $jur->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Search Input -->
                <div style="position: relative; flex: 1; min-width: 200px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                    <input type="text" name="q" id="searchKelasGlobal" value="{{ request('q') }}" placeholder="Cari nama rombel kelas, wali kelas..." style="width: 100%; padding: 8px 32px 8px 34px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #1e293b; background: #f8fafc; box-sizing: border-box;">
                    @if(request('q'))
                        <button type="button" onclick="clearSearchKelasGlobal()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 12px;">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Action Buttons: Terapkan & Reset Filter -->
            <div style="display: flex; align-items: center; gap: 8px;">
                <button type="submit" style="background: #384972; color: #ffffff; border: none; padding: 9px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(56, 73, 114, 0.2);">
                    <i class="fa-solid fa-filter"></i> Terapkan
                </button>
                <a href="{{ route('kepala-sekolah.kehadiran-siswa') }}" title="Reset Semua Filter & Pencarian" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 9px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
            </div>
        </form>
    </div>

    <!-- 4. Table Rincian Siswa Per Rombel Kelas -->
    <div style="background: #ffffff; padding: 24px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 14px; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
            <h3 style="font-size: 16.5px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-school" style="color: #384972;"></i> Data Rincian Siswa Per Rombel Kelas
                <span id="kelasCounterBadge" style="background: #e0e7ff; color: #3730a3; font-size: 12px; font-weight: 800; padding: 3px 10px; border-radius: 20px;">
                    {{ count($kelasStats) }} Kelas
                </span>
            </h3>

            <!-- Quick Filter Pills & Live Table Search -->
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div style="display: flex; gap: 6px; background: #f8fafc; padding: 4px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <button type="button" onclick="filterKelasTingkat('all')" class="tingkat-filter-btn active" data-tingkat="all" style="border: none; background: #384972; color: #fff; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer;">Semua</button>
                    <button type="button" onclick="filterKelasTingkat('X ')" class="tingkat-filter-btn" data-tingkat="X " style="border: none; background: transparent; color: #64748b; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer;">Kelas X</button>
                    <button type="button" onclick="filterKelasTingkat('XI ')" class="tingkat-filter-btn" data-tingkat="XI " style="border: none; background: transparent; color: #64748b; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer;">Kelas XI</button>
                    <button type="button" onclick="filterKelasTingkat('XII ')" class="tingkat-filter-btn" data-tingkat="XII " style="border: none; background: transparent; color: #64748b; padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; cursor: pointer;">Kelas XII</button>
                </div>

                <div style="position: relative; width: 200px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px;"></i>
                    <input type="text" id="liveSearchKelasTable" onkeyup="searchKelasTableRows()" placeholder="Cari di tabel kelas..." style="width: 100%; padding: 6px 28px 6px 28px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; color: #1e293b; background: #f8fafc; box-sizing: border-box;">
                    <button type="button" onclick="clearLiveSearchKelas()" id="btnResetLiveKelas" style="display: none; position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 11px;">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table id="tableKelas" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569; border-bottom: 1.5px solid #cbd5e1;">
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px; width: 50px; text-align: center;">No</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Nama Rombel Kelas</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Jurusan</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Wali Kelas</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px; text-align: center;">Jumlah Siswa</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Rincian Presensi</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px;">Kehadiran (%)</th>
                        <th style="padding: 14px 16px; font-weight: 800; font-size: 13px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $idx = 1; @endphp
                    @forelse($kelasStats as $st)
                        @php
                            $progressBg = '#16a34a';
                            $pctBadgeBg = '#dcfce7';
                            $pctBadgeColor = '#166534';
                            if ($st['persentase'] < 80) {
                                $progressBg = '#dc2626';
                                $pctBadgeBg = '#fee2e2';
                                $pctBadgeColor = '#991b1b';
                            } elseif ($st['persentase'] < 90) {
                                $progressBg = '#d97706';
                                $pctBadgeBg = '#fef3c7';
                                $pctBadgeColor = '#92400e';
                            }

                            $jsonDetail = json_encode([
                                'id_kelas' => $st['id_kelas'],
                                'nama_kelas' => $st['nama_kelas'],
                                'jurusan' => $st['jurusan'],
                                'wali_kelas' => $st['wali_kelas'],
                                'nip_wali_kelas' => $st['nip_wali_kelas'],
                                'tanggal' => \Carbon\Carbon::parse($filterTanggal)->translatedFormat('l, d F Y'),
                                'tanggal_raw' => $filterTanggal,
                                'total_siswa' => $st['total_siswa'],
                                'hadir' => $st['hadir'],
                                'sakit' => $st['sakit'],
                                'izin' => $st['izin'],
                                'alpa' => $st['alpa'],
                                'dispen' => $st['dispen'],
                                'persentase' => $st['persentase'],
                                'siswas' => $st['siswas']
                            ]);
                        @endphp
                        <tr class="kelas-row" data-nama="{{ $st['nama_kelas'] }}" style="border-bottom: 1px solid #e2e8f0; transition: background 0.15s;">
                            <td class="row-num" style="padding: 16px; color: #64748b; font-weight: 700; text-align: center;">{{ $idx++ }}</td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 800; color: #0f172a; font-size: 14px;">{{ $st['nama_kelas'] }}</div>
                            </td>
                            <td style="padding: 16px; color: #475569; font-weight: 600;">
                                {{ $st['jurusan'] }}
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 700; color: #1e293b;">{{ $st['wali_kelas'] }}</div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">NIP: {{ $st['nip_wali_kelas'] }}</div>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <span style="background: #eef2ff; color: #384972; padding: 4px 12px; border-radius: 8px; font-weight: 800; font-size: 13px; border: 1px solid #c7d2fe;">
                                    {{ $st['total_siswa'] }} Siswa
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <div style="display: flex; gap: 6px; flex-wrap: wrap; font-size: 11.5px; font-weight: 700;">
                                    <span style="background: #dcfce7; color: #166534; padding: 2px 7px; border-radius: 4px;" title="Hadir">H: {{ $st['hadir'] }}</span>
                                    <span style="background: #fee2e2; color: #991b1b; padding: 2px 7px; border-radius: 4px;" title="Sakit">S: {{ $st['sakit'] }}</span>
                                    <span style="background: #fef3c7; color: #92400e; padding: 2px 7px; border-radius: 4px;" title="Izin">I: {{ $st['izin'] }}</span>
                                    <span style="background: #f1f5f9; color: #475569; padding: 2px 7px; border-radius: 4px;" title="Alpa">A: {{ $st['alpa'] }}</span>
                                    @if($st['dispen'] > 0)
                                        <span style="background: #e0e7ff; color: #3730a3; padding: 2px 7px; border-radius: 4px;" title="Dispensasi">D: {{ $st['dispen'] }}</span>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 10px; min-width: 140px;">
                                    <div style="flex: 1; background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
                                        <div style="background: {{ $progressBg }}; height: 100%; width: {{ $st['persentase'] }}%;"></div>
                                    </div>
                                    <span style="background: {{ $pctBadgeBg }}; color: {{ $pctBadgeColor }}; font-weight: 800; font-size: 12px; padding: 2px 8px; border-radius: 12px;">
                                        {{ $st['persentase'] }}%
                                    </span>
                                </div>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <button type="button" onclick='showDetailPresensiKelas({!! $jsonDetail !!})' style="background: #384972; color: #ffffff; border: none; padding: 7px 14px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(56, 73, 114, 0.2); transition: all 0.2s;">
                                    <i class="fa-solid fa-list-check"></i> Lihat Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 30px; color: #64748b; font-weight: 600;">
                                <i class="fa-solid fa-folder-open" style="font-size: 28px; color: #cbd5e1; display: block; margin-bottom: 8px;"></i>
                                Belum ada data rombel kelas terdaftar yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL: DETAIL PRESENSI & DAFTAR SISWA ROMBEL KELAS                       -->
<!-- ========================================================================= -->
<div id="modalDetailKelasPresensi" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; width: 100%; max-width: 860px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden; display: flex; flex-direction: column; max-height: 92vh;">
        
        <!-- Modal Header -->
        <div style="background: linear-gradient(135deg, #1e293b, #384972); padding: 20px 24px; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.8; font-weight: 700;">
                    RINCIAN PRESENSI KELAS & DAFTAR SISWA
                </div>
                <h3 id="mdKelasTitle" style="margin: 4px 0 0 0; font-size: 19px; font-weight: 800; color: #ffffff;">
                    Nama Rombel Kelas
                </h3>
            </div>
            <button onclick="closeModal('modalDetailKelasPresensi')" style="background: rgba(255,255,255,0.15); border: none; color: #fff; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div style="padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 20px; font-size: 13.5px;">
            
            <!-- Meta Grid Info -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 14px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                    <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Wali Kelas & Program Studi</div>
                    <div id="mdKelasWali" style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 2px;">Wali: -</div>
                    <div id="mdKelasJurusan" style="font-size: 12px; color: #475569; font-weight: 600; margin-top: 2px;">Jurusan: -</div>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; text-align: center;">
                    <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase;">Persentase Kehadiran</div>
                    <div id="mdKelasPct" style="font-size: 24px; font-weight: 900; color: #16a34a; margin-top: 2px;">100%</div>
                </div>
            </div>

            <!-- Mini KPI Breakdown -->
            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px; text-align: center;">
                    <div style="font-size: 11px; color: #64748b; font-weight: 700;">TOTAL SISWA</div>
                    <div id="mdStatTotal" style="font-size: 18px; font-weight: 900; color: #384972; margin-top: 2px;">0</div>
                </div>
                <div style="background: #dcfce7; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px; text-align: center;">
                    <div style="font-size: 11px; color: #166534; font-weight: 700;">HADIR</div>
                    <div id="mdStatHadir" style="font-size: 18px; font-weight: 900; color: #166534; margin-top: 2px;">0</div>
                </div>
                <div style="background: #fee2e2; border: 1px solid #fecaca; border-radius: 10px; padding: 10px; text-align: center;">
                    <div style="font-size: 11px; color: #991b1b; font-weight: 700;">SAKIT</div>
                    <div id="mdStatSakit" style="font-size: 18px; font-weight: 900; color: #991b1b; margin-top: 2px;">0</div>
                </div>
                <div style="background: #fef3c7; border: 1px solid #fde68a; border-radius: 10px; padding: 10px; text-align: center;">
                    <div style="font-size: 11px; color: #92400e; font-weight: 700;">IZIN</div>
                    <div id="mdStatIzin" style="font-size: 18px; font-weight: 900; color: #92400e; margin-top: 2px;">0</div>
                </div>
                <div style="background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px; text-align: center;">
                    <div style="font-size: 11px; color: #475569; font-weight: 700;">ALPA</div>
                    <div id="mdStatAlpa" style="font-size: 18px; font-weight: 900; color: #475569; margin-top: 2px;">0</div>
                </div>
            </div>

            <!-- Student List Table Inside Modal with Filter Pills -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                <div style="background: #f8fafc; padding: 12px 16px; border-bottom: 1px solid #e2e8f0; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 10px;">
                    <!-- Filter Status Buttons Inside Modal -->
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        <button type="button" onclick="filterModalStatus('ALL')" class="md-status-btn active" data-st="ALL" style="border: none; background: #384972; color: #fff; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">Semua (<span id="cntModalAll">0</span>)</button>
                        <button type="button" onclick="filterModalStatus('HADIR')" class="md-status-btn" data-st="HADIR" style="border: none; background: #f1f5f9; color: #166534; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">Hadir (<span id="cntModalHadir">0</span>)</button>
                        <button type="button" onclick="filterModalStatus('SAKIT')" class="md-status-btn" data-st="SAKIT" style="border: none; background: #f1f5f9; color: #991b1b; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">Sakit (<span id="cntModalSakit">0</span>)</button>
                        <button type="button" onclick="filterModalStatus('IZIN')" class="md-status-btn" data-st="IZIN" style="border: none; background: #f1f5f9; color: #92400e; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">Izin (<span id="cntModalIzin">0</span>)</button>
                        <button type="button" onclick="filterModalStatus('ALPA')" class="md-status-btn" data-st="ALPA" style="border: none; background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">Alpa (<span id="cntModalAlpa">0</span>)</button>
                    </div>

                    <input type="text" id="modalStudentSearch" onkeyup="filterModalStudentList()" placeholder="Cari nama / NISN..." style="padding: 5px 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 12px; width: 180px;">
                </div>

                <div style="max-height: 280px; overflow-y: auto;">
                    <table id="tableModalSiswa" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 12.5px;">
                        <thead style="position: sticky; top: 0; background: #f1f5f9; border-bottom: 1px solid #cbd5e1;">
                            <tr>
                                <th style="padding: 10px 14px; width: 40px; text-align: center;">No</th>
                                <th style="padding: 10px 14px;">Nama Siswa</th>
                                <th style="padding: 10px 14px;">NISN</th>
                                <th style="padding: 10px 14px; text-align: center;">L/P</th>
                                <th style="padding: 10px 14px; text-align: center;">Status</th>
                                <th style="padding: 10px 14px;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="mdSiswaTableBody">
                            <!-- Populated via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Modal Footer -->
        <div style="background: #f8fafc; padding: 14px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <button id="btnCetakKelasIni" type="button" onclick="printSingleClass()" style="background: #2563eb; color: #ffffff; border: none; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 12.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-print"></i> Cetak Presensi Kelas Ini
            </button>
            <button onclick="closeModal('modalDetailKelasPresensi')" style="background: #384972; color: #ffffff; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: CETAK REKAP PRESENSI KELAS                                         -->
<!-- ========================================================================= -->
<div id="modalCetakKehadiran" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; width: 100%; max-width: 480px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); overflow: hidden;">
        <div style="background: #384972; padding: 18px 24px; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-print"></i> Cetak Dokumen Rekap Presensi
            </h3>
            <button onclick="closeModal('modalCetakKehadiran')" style="background: rgba(255,255,255,0.15); border: none; color: #fff; width: 28px; height: 28px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div style="padding: 20px; font-size: 13.5px; display: flex; flex-direction: column; gap: 14px;">
            <div>
                <label style="font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Pilih Tanggal Presensi:</label>
                <input type="date" id="printTanggalKehadiran" value="{{ $filterTanggal }}" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; box-sizing: border-box;">
            </div>

            <div>
                <label style="font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Pilih Cakupan Cetak:</label>
                <select id="printKelasSelect" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; box-sizing: border-box;">
                    <option value="">Semua Rombel Kelas (Rekap Global)</option>
                    @foreach($kelasList as $kls)
                        <option value="{{ $kls->id_kelas }}">{{ $kls->nama_kelas }} (Wali: {{ $kls->waliKelas->nama_guru ?? ($kls->wali_kelas ?? '-') }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div style="background: #f8fafc; padding: 14px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
            <button onclick="closeModal('modalCetakKehadiran')" style="background: #e2e8f0; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
                Batal
            </button>
            <button onclick="executePrintKehadiran()" style="background: #384972; color: #ffffff; border: none; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-print"></i> Buka Lembar Cetak
            </button>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT INTERACTIONS                                                  -->
<!-- ========================================================================= -->
<script>
let currentModalClassData = null;
let currentModalFilterStatus = 'ALL';

function openModal(id) {
    const m = document.getElementById(id);
    if (m) m.style.display = 'flex';
}

function closeModal(id) {
    const m = document.getElementById(id);
    if (m) m.style.display = 'none';
}

// Close modals on backdrop click
window.addEventListener('click', function(e) {
    ['modalDetailKelasPresensi', 'modalCetakKehadiran'].forEach(id => {
        const modal = document.getElementById(id);
        if (modal && e.target === modal) {
            modal.style.display = 'none';
        }
    });
});

// Clear Global Search
function clearSearchKelasGlobal() {
    const input = document.getElementById('searchKelasGlobal');
    if (input) {
        input.value = '';
        document.getElementById('filterFormKehadiran').submit();
    }
}

// Show Detail Presensi Kelas Modal
function showDetailPresensiKelas(data) {
    currentModalClassData = data;
    currentModalFilterStatus = 'ALL';

    document.getElementById('mdKelasTitle').textContent = `${data.nama_kelas} — Presensi ${data.tanggal}`;
    document.getElementById('mdKelasWali').textContent = `Wali Kelas: ${data.wali_kelas} (NIP: ${data.nip_wali_kelas})`;
    document.getElementById('mdKelasJurusan').textContent = `Program Keahlian: ${data.jurusan}`;
    document.getElementById('mdKelasPct').textContent = `${data.persentase}%`;

    document.getElementById('mdStatTotal').textContent = data.total_siswa;
    document.getElementById('mdStatHadir').textContent = data.hadir;
    document.getElementById('mdStatSakit').textContent = data.sakit;
    document.getElementById('mdStatIzin').textContent = data.izin;
    document.getElementById('mdStatAlpa').textContent = data.alpa;

    // Badges inside modal
    document.getElementById('cntModalAll').textContent = data.total_siswa;
    document.getElementById('cntModalHadir').textContent = data.hadir;
    document.getElementById('cntModalSakit').textContent = data.sakit;
    document.getElementById('cntModalIzin').textContent = data.izin;
    document.getElementById('cntModalAlpa').textContent = data.alpa;

    // Reset status buttons style
    document.querySelectorAll('.md-status-btn').forEach(btn => {
        if (btn.getAttribute('data-st') === 'ALL') {
            btn.style.background = '#384972';
            btn.style.color = '#ffffff';
        } else {
            btn.style.background = '#f1f5f9';
            btn.style.color = '#475569';
        }
    });

    document.getElementById('modalStudentSearch').value = '';
    renderModalStudentRows();
    openModal('modalDetailKelasPresensi');
}

// Render student rows inside modal with live filter & dynamic numbering
function renderModalStudentRows() {
    const tbody = document.getElementById('mdSiswaTableBody');
    tbody.innerHTML = '';

    if (!currentModalClassData || !currentModalClassData.siswas || currentModalClassData.siswas.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">
                    Belum ada data siswa terdaftar di kelas ini.
                </td>
            </tr>
        `;
        return;
    }

    const searchTxt = document.getElementById('modalStudentSearch').value.toLowerCase();
    let rowIdx = 1;

    currentModalClassData.siswas.forEach((s) => {
        const matchStatus = (currentModalFilterStatus === 'ALL') || (s.status_kehadiran === currentModalFilterStatus);
        const matchSearch = s.nama_siswa.toLowerCase().includes(searchTxt) || s.nisn.toLowerCase().includes(searchTxt);

        if (matchStatus && matchSearch) {
            let badgeBg = '#dcfce7';
            let badgeColor = '#166534';
            if (s.status_kehadiran === 'SAKIT') {
                badgeBg = '#fee2e2';
                badgeColor = '#991b1b';
            } else if (s.status_kehadiran === 'IZIN') {
                badgeBg = '#fef3c7';
                badgeColor = '#92400e';
            } else if (s.status_kehadiran === 'ALPA') {
                badgeBg = '#f1f5f9';
                badgeColor = '#475569';
            } else if (s.status_kehadiran === 'DISPEN') {
                badgeBg = '#e0e7ff';
                badgeColor = '#3730a3';
            }

            const tr = document.createElement('tr');
            tr.className = 'md-siswa-row';
            tr.style.borderBottom = '1px solid #f1f5f9';
            tr.innerHTML = `
                <td style="padding: 8px 14px; text-align: center; color: #64748b; font-weight: 700;">${rowIdx++}</td>
                <td style="padding: 8px 14px; font-weight: 800; color: #0f172a;">${s.nama_siswa}</td>
                <td style="padding: 8px 14px; color: #64748b; font-size: 11.5px;">${s.nisn}</td>
                <td style="padding: 8px 14px; text-align: center; font-weight: 700; color: #475569;">${s.jenis_kelamin}</td>
                <td style="padding: 8px 14px; text-align: center;">
                    <span style="background: ${badgeBg}; color: ${badgeColor}; padding: 3px 10px; border-radius: 12px; font-weight: 800; font-size: 11px;">
                        ${s.status_kehadiran}
                    </span>
                </td>
                <td style="padding: 8px 14px; color: #475569; font-size: 11.5px;">${s.keterangan}</td>
            `;
            tbody.appendChild(tr);
        }
    });

    if (rowIdx === 1) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">
                    Tidak ada siswa yang sesuai dengan filter atau kata kunci pencarian.
                </td>
            </tr>
        `;
    }
}

// Filter status inside modal
function filterModalStatus(status) {
    currentModalFilterStatus = status;
    document.querySelectorAll('.md-status-btn').forEach(btn => {
        if (btn.getAttribute('data-st') === status) {
            btn.style.background = '#384972';
            btn.style.color = '#ffffff';
        } else {
            btn.style.background = '#f1f5f9';
            btn.style.color = '#475569';
        }
    });
    renderModalStudentRows();
}

// Search student inside modal
function filterModalStudentList() {
    renderModalStudentRows();
}

// Print single class from modal
function printSingleClass() {
    if (!currentModalClassData) return;
    const url = `{{ route('kepala-sekolah.kehadiran-siswa') }}?print=true&tanggal=${currentModalClassData.tanggal_raw}&id_kelas=${currentModalClassData.id_kelas}`;
    window.open(url, '_blank');
}

// Open Global Cetak Modal
function openModalCetakKehadiran() {
    openModal('modalCetakKehadiran');
}

// Execute Print from modal
function executePrintKehadiran() {
    const tgl = document.getElementById('printTanggalKehadiran').value;
    const idKelas = document.getElementById('printKelasSelect').value;
    let url = `{{ route('kepala-sekolah.kehadiran-siswa') }}?print=true&tanggal=${tgl}`;
    if (idKelas) {
        url += `&id_kelas=${idKelas}`;
    }
    window.open(url, '_blank');
    closeModal('modalCetakKehadiran');
}

// Filter kelas tingkat pills with dynamic numbering & counter badge
function filterKelasTingkat(tingkat) {
    document.querySelectorAll('.tingkat-filter-btn').forEach(btn => {
        if (btn.getAttribute('data-tingkat') === tingkat) {
            btn.style.background = '#384972';
            btn.style.color = '#ffffff';
        } else {
            btn.style.background = 'transparent';
            btn.style.color = '#64748b';
        }
    });

    const rows = document.querySelectorAll('#tableKelas .kelas-row');
    let visibleCount = 0;

    rows.forEach(r => {
        const namaKelas = r.getAttribute('data-nama');
        const numCell = r.querySelector('.row-num');
        if (tingkat === 'all' || namaKelas.startsWith(tingkat)) {
            r.style.display = '';
            visibleCount++;
            if (numCell) numCell.textContent = visibleCount;
        } else {
            r.style.display = 'none';
        }
    });

    const badge = document.getElementById('kelasCounterBadge');
    if (badge) {
        badge.textContent = `${visibleCount} Kelas`;
    }
}

// Live search in kelas table with dynamic numbering
function searchKelasTableRows() {
    const input = document.getElementById('liveSearchKelasTable').value.toLowerCase();
    const btnReset = document.getElementById('btnResetLiveKelas');
    if (btnReset) {
        btnReset.style.display = input.length > 0 ? 'block' : 'none';
    }

    const rows = document.querySelectorAll('#tableKelas .kelas-row');
    let visibleCount = 0;

    rows.forEach(r => {
        const text = r.textContent.toLowerCase();
        const numCell = r.querySelector('.row-num');
        if (text.includes(input)) {
            r.style.display = '';
            visibleCount++;
            if (numCell) numCell.textContent = visibleCount;
        } else {
            r.style.display = 'none';
        }
    });

    const badge = document.getElementById('kelasCounterBadge');
    if (badge) {
        badge.textContent = `${visibleCount} Kelas`;
    }
}

function clearLiveSearchKelas() {
    const input = document.getElementById('liveSearchKelasTable');
    input.value = '';
    searchKelasTableRows();
}
</script>
@endsection