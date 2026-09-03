@extends('layouts.admin')

@section('title', '13. Monitoring Kehadiran & Analytics — EduJournal Admin')
@section('header_title', '13. Monitoring Kehadiran & Analytics Dashboard')
@section('header_subtitle', 'Grafik statistik dan rincian data kehadiran guru & siswa per hari')

@section('styles')
<style>
    .filter-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 18px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .metric-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.06);
    }

    .metric-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; flex-shrink: 0;
    }
    .metric-icon.green { background: #d1fae5; color: #059669; }
    .metric-icon.red   { background: #fee2e2; color: #dc2626; }
    .metric-icon.amber { background: #fef3c7; color: #d97706; }
    .metric-icon.blue  { background: #e0e7ff; color: #4f46e5; }

    .metric-info h3 { font-size: 22px; font-weight: 800; color: #0f172a; line-height: 1.1; }
    .metric-info p { font-size: 12px; font-weight: 600; color: #64748b; margin-top: 2px; }

    /* Chart Section */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .chart-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .chart-header h3 {
        font-size: 15px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;
    }

    /* Detail Tables Section */
    .detail-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        margin-bottom: 32px;
        overflow: hidden;
    }

    .detail-header {
        padding: 20px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .detail-header h3 {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th {
        font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b;
        background: #ffffff; padding: 14px 18px; font-weight: 700; text-align: left;
        border-bottom: 2px solid #f1f5f9;
    }
    .custom-table td {
        padding: 14px 18px; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #334155; vertical-align: middle;
    }

    .badge-status { padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; display: inline-block; }
    .badge-hadir { background: #d1fae5; color: #065f46; }
    .badge-izin { background: #fef3c7; color: #92400e; }
    .badge-sakit { background: #e0e7ff; color: #3730a3; }
    .badge-alpa { background: #fee2e2; color: #991b1b; }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Monitoring Kehadiran Siswa & Guru</h1>
            <p>Pantau statistik kehadiran, persentase presensi harian, dan grafik keaktifan</p>
        </div>
    </div>

    <!-- Date Filter Card -->
    <div class="filter-card">
        <div>
            <h3 style="font-size: 16px; font-weight: 800; color: #0f172a;">Ringkasan Kehadiran Harian</h3>
            <p style="font-size: 12.5px; color: #64748b; margin-top: 2px;">
                <i class="fa-solid fa-calendar-day" style="color: #4f46e5;"></i>
                Tanggal Terpilih: <strong>{{ \Carbon\Carbon::parse($filterTanggal)->format('d F Y') }}</strong>
            </p>
        </div>
        <form action="{{ route('admin.monitoring-kehadiran') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
            <label for="tanggal" style="font-size: 13px; font-weight: 700; color: #475569;">Pilih Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ $filterTanggal }}" class="form-control" onchange="this.form.submit()" style="padding: 9px 14px; border-radius: 10px; border: 1.5px solid #cbd5e1; font-size: 13px; outline: none; font-weight: 600;">
        </form>
    </div>

    <!-- Attendance Metrics Row 1: Guru -->
    <h4 style="font-size: 13px; font-weight: 800; color: #475569; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.8px;">
        <i class="fa-solid fa-user-tie" style="color: #4f46e5;"></i> Ringkasan Kehadiran Guru (Sesi Jurnal Mengajar)
    </h4>
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-icon green"><i class="fa-solid fa-user-check"></i></div>
            <div class="metric-info">
                <h3>{{ $guruHadirCount }}</h3>
                <p>Guru Hadir Mengajar</p>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon red"><i class="fa-solid fa-user-xmark"></i></div>
            <div class="metric-info">
                <h3>{{ $guruTidakHadirCount }}</h3>
                <p>Guru Tidak Hadir (Total)</p>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon amber"><i class="fa-solid fa-envelope-open-text"></i></div>
            <div class="metric-info">
                <h3>{{ $guruIzinCount }} / {{ $guruSakitCount }}</h3>
                <p>Guru Izin / Sakit</p>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon blue"><i class="fa-solid fa-user-clock"></i></div>
            <div class="metric-info">
                <h3>{{ $guruAlpaCount }}</h3>
                <p>Tanpa Keterangan</p>
            </div>
        </div>
    </div>

    <!-- Attendance Metrics Row 2: Siswa -->
    <h4 style="font-size: 13px; font-weight: 800; color: #475569; margin-bottom: 14px; margin-top: 24px; text-transform: uppercase; letter-spacing: 0.8px;">
        <i class="fa-solid fa-users" style="color: #059669;"></i> Ringkasan Kehadiran Siswa (Total Rombel Aktif: {{ $totalSiswaAktif }} Siswa)
    </h4>
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-icon green"><i class="fa-solid fa-circle-check"></i></div>
            <div class="metric-info">
                <h3>{{ $siswaHadirCount }}</h3>
                <p>Siswa Hadir</p>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon amber"><i class="fa-solid fa-hand"></i></div>
            <div class="metric-info">
                <h3>{{ $siswaIzinCount }}</h3>
                <p>Siswa Izin</p>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon blue"><i class="fa-solid fa-bed"></i></div>
            <div class="metric-info">
                <h3>{{ $siswaSakitCount }}</h3>
                <p>Siswa Sakit</p>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon red"><i class="fa-solid fa-circle-exclamation"></i></div>
            <div class="metric-info">
                <h3>{{ $siswaAlfaCount }}</h3>
                <p>Siswa Alfa</p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid" style="margin-top: 20px;">
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fa-solid fa-chart-pie" style="color:#4f46e5;"></i> Rekapitulasi Presensi Siswa Pada Tanggal Ini</h3>
            </div>
            <canvas id="siswaChart" height="210"></canvas>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fa-solid fa-chart-line" style="color:#059669;"></i> Tren Jurnal & Absensi Siswa (7 Hari Terakhir)</h3>
            </div>
            <canvas id="trenJurnalChart" height="210"></canvas>
        </div>
    </div>

    <!-- Detail Section 1: Rincian Kehadiran Guru Hari Ini -->
    <div class="detail-card">
        <div class="detail-header">
            <h3><i class="fa-solid fa-clipboard-user" style="color:#4f46e5;"></i> Rincian Kehadiran & Pengisian Jurnal Guru Pada Tanggal Ini</h3>
            <span style="font-size: 12px; font-weight:700; color:#64748b;">{{ $guruAttendanceDetails->count() }} Sesi Terdaftar</span>
        </div>
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Jam & Kelas</th>
                        <th>Guru Pengampu</th>
                        <th>Mata Pelajaran</th>
                        <th>Status Kehadiran Guru</th>
                        <th>Pokok Materi Pembelajaran</th>
                        <th>Ketidakhadiran Siswa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruAttendanceDetails as $j)
                        <tr>
                            <td>
                                <strong>{{ $j->jadwal->kelas->nama_kelas ?? '-' }}</strong><br>
                                <small style="color: #64748b;">{{ $j->jadwal->ruangan->nama_ruangan ?? '-' }}</small>
                            </td>
                            <td><strong>{{ $j->jadwal->guru->nama_guru ?? '-' }}</strong></td>
                            <td>{{ $j->jadwal->mapel->nama_mapel ?? '-' }}</td>
                            <td>
                                @if($j->status_kehadiran_guru == 'Hadir')
                                    <span class="badge-status badge-hadir"><i class="fa-solid fa-check"></i> Hadir</span>
                                @elseif($j->status_kehadiran_guru == 'Izin')
                                    <span class="badge-status badge-izin"><i class="fa-solid fa-envelope"></i> Izin</span>
                                @elseif($j->status_kehadiran_guru == 'Sakit')
                                    <span class="badge-status badge-sakit"><i class="fa-solid fa-bed"></i> Sakit</span>
                                @else
                                    <span class="badge-status badge-alpa"><i class="fa-solid fa-xmark"></i> {{ $j->status_kehadiran_guru }}</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($j->materi, 45) }}</td>
                            <td>
                                @if($j->detailKetidakhadiran && $j->detailKetidakhadiran->count() > 0)
                                    <span style="color:#ef4444; font-weight:700;">{{ $j->detailKetidakhadiran->count() }} Siswa Absen</span>
                                @else
                                    <span style="color:#10b981; font-weight:700;">Nihil (Hadir Semua)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 28px;">
                                <i class="fa-solid fa-folder-open" style="font-size:24px; margin-bottom:6px; color:#cbd5e1;"></i><br>
                                Belum ada jurnal mengajar guru yang terisi pada tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail Section 2: Rincian Ketidakhadiran Siswa Hari Ini -->
    <div class="detail-card">
        <div class="detail-header">
            <h3><i class="fa-solid fa-user-slash" style="color:#ef4444;"></i> Rincian Ketidakhadiran Siswa (Izin / Sakit / Alpa) Pada Tanggal Ini</h3>
            <span style="font-size: 12px; font-weight:700; color:#ef4444;">{{ $siswaAbsentDetails->count() }} Catatan Absen</span>
        </div>
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Keterangan Absen</th>
                        <th>Mata Pelajaran & Guru</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswaAbsentDetails as $detail)
                        <tr>
                            <td><code>{{ $detail->siswa->nisn ?? '-' }}</code></td>
                            <td><strong>{{ $detail->siswa->nama_siswa ?? 'Siswa ID '.$detail->id_siswa }}</strong></td>
                            <td><span style="background:#e0e7ff; color:#3730a3; padding:2px 8px; border-radius:6px; font-weight:700; font-size:12px;">{{ $detail->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td>
                                @if($detail->keterangan == 'Sakit')
                                    <span class="badge-status badge-sakit"><i class="fa-solid fa-bed"></i> Sakit</span>
                                @elseif($detail->keterangan == 'Izin')
                                    <span class="badge-status badge-izin"><i class="fa-solid fa-envelope"></i> Izin</span>
                                @else
                                    <span class="badge-status badge-alpa"><i class="fa-solid fa-circle-xmark"></i> Alpa</span>
                                @endif
                            </td>
                            <td>
                                {{ $detail->jurnal->jadwal->mapel->nama_mapel ?? '-' }}<br>
                                <small style="color:#64748b;">Pengampu: {{ $detail->jurnal->jadwal->guru->nama_guru ?? '-' }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #10b981; padding: 28px;">
                                <i class="fa-solid fa-circle-check" style="font-size:24px; margin-bottom:6px; color:#10b981;"></i><br>
                                Tidak ada ketidakhadiran siswa tercatat pada tanggal ini (Semua siswa terdata Hadir).
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // 1. Chart Siswa
    const ctxSiswa = document.getElementById('siswaChart').getContext('2d');
    new Chart(ctxSiswa, {
        type: 'doughnut',
        data: {
            labels: ['Siswa Hadir', 'Siswa Izin', 'Siswa Sakit', 'Siswa Alfa'],
            datasets: [{
                data: [{{ $siswaHadirCount }}, {{ $siswaIzinCount }}, {{ $siswaSakitCount }}, {{ $siswaAlfaCount }}],
                backgroundColor: ['#10b981', '#f59e0b', '#6366f1', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 2. Chart Tren Jurnal 7 Hari
    const ctxTren = document.getElementById('trenJurnalChart').getContext('2d');
    new Chart(ctxTren, {
        type: 'line',
        data: {
            labels: {!! json_encode($datesArray) !!},
            datasets: [
                {
                    label: 'Jurnal Terisi',
                    data: {!! json_encode($jurnalCounts) !!},
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Siswa Absen (Izin/Sakit/Alfa)',
                    data: {!! json_encode($siswaAbsenCounts) !!},
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });
</script>
@endsection
