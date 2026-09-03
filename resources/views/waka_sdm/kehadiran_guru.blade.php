@extends('layouts.waka_sdm')

@section('title', 'Kehadiran & KBM Guru — Waka SDM')
@section('page-header', 'Kehadiran Pendidik & Monitoring KBM')
@section('page-subheader', 'Pantau keaktifan mengajar harian, guru izin, dan penugasan guru pengganti')

@section('styles')
<style>
    .kehadiran-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* 4 Stat Cards Grid */
    .stat-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .stat-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-icon-green  { background: #d1fae5; color: #059669; }
    .stat-icon-orange { background: #ffedd5; color: #ea580c; }
    .stat-icon-indigo { background: #e0e7ff; color: #4338ca; }
    .stat-icon-purple { background: #f3e8ff; color: #7e22ce; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #94a3b8;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    /* Filter Bar Container & Inputs */
    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 20px;
        background: #f8fafc;
        border-radius: 14px;
        border: 1px solid #cbd5e1;
        margin-bottom: 18px;
    }

    .filter-bar-container form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-input {
        padding: 9px 14px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: border-color 0.15s ease;
    }

    .filter-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-dark {
        background: #2b3957;
        color: #ffffff;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-filter-dark:hover { background: #1e293b; color: #ffffff; }

    .btn-reset-light {
        background: #e2e8f0;
        color: #475569;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #0f172a; }

    /* Card Panel Base */
    .card-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    /* Table Design */
    .table-responsive {
        overflow-x: auto;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table-custom th {
        background: #f8fafc;
        padding: 14px 16px;
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-custom td {
        padding: 16px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        display: inline-block;
    }
    .badge-status-disetujui { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
    .badge-status-pending   { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .badge-status-hadir     { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }

    .btn-wa {
        background: #25d366;
        color: #ffffff;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-act {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .btn-act-view { background: #f1f5f9; color: #475569; }
    .btn-act-view:hover { background: #e2e8f0; color: #0f172a; }

    /* Modals Backdrop & Card */
    .modal-backdrop-custom {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
        padding: 16px;
    }

    .modal-card-custom {
        background: #ffffff;
        border-radius: 18px;
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .modal-header-custom {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header-custom h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-body-custom {
        padding: 24px;
    }

    .modal-footer-custom {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    @media (max-width: 768px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
        .form-grid-2 { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="kehadiran-container">
    <!-- 4 Stat Cards Grid -->
    <div class="stat-grid-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-green">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Guru Hadir Mengajar</span>
                <span class="stat-val">{{ $stats['guruHadirCount'] ?? 0 }} Guru</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-orange">
                <i class="fa-solid fa-user-large-slash"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Guru Izin / Cuti</span>
                <span class="stat-val">{{ $stats['guruIzinCount'] ?? 0 }} Guru</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-indigo">
                <i class="fa-solid fa-people-arrows"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Guru Pengganti</span>
                <span class="stat-val">{{ $stats['guruPenggantiCount'] ?? 0 }} Inval</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-purple">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Jurnal KBM Terisi</span>
                <span class="stat-val">{{ $stats['jurnalTerisiCount'] ?? 0 }} Entri</span>
            </div>
        </div>
    </div>

    <!-- Filter Bar Form -->
    <div class="filter-bar-container" style="margin-bottom: 0;">
        <form action="{{ route('waka-sdm.kehadiran-guru') }}" method="GET">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 13.5px; color: #1e293b; margin-right: 8px;">
                <i class="fa-solid fa-calendar-day" style="color: #2563eb;"></i> Tanggal Pemantauan KBM:
            </div>
            <input type="date" name="tanggal" value="{{ $tanggal }}" class="filter-input" style="min-width: 160px;">

            <select name="id_kelas" class="filter-input">
                <option value="">Kelas: Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-filter-dark">
                <i class="fa-solid fa-magnifying-glass"></i> Pemantauan
            </button>
            <a href="{{ route('waka-sdm.kehadiran-guru') }}" class="btn-reset-light">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>
        </form>
    </div>

    <!-- Card 1: Daftar Guru Izin / Tidak Hadir -->
    <div class="card-panel">
        <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-user-xmark" style="color: #ea580c;"></i>
            Daftar Guru Izin / Tidak Hadir ({{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }})
        </h2>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Pendidik</th>
                        <th>NIP</th>
                        <th>Periode Izin</th>
                        <th>Kategori / Alasan</th>
                        <th>Status Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruIzin as $idx => $iz)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>
                                <strong style="font-size: 14px; color: #0f172a;">{{ $iz->guru->nama_guru ?? '-' }}</strong>
                                @if($iz->guru && !empty($iz->guru->no_hp))
                                    @php
                                        $cleanHp = preg_replace('/[^0-9]/', '', $iz->guru->no_hp);
                                        if(str_starts_with($cleanHp, '0')) $cleanHp = '62' . substr($cleanHp, 1);
                                    @endphp
                                    <div style="margin-top: 4px;">
                                        <a href="https://wa.me/{{ $cleanHp }}?text=Halo%20{{ urlencode($iz->guru->nama_guru) }}" target="_blank" class="btn-wa">
                                            <i class="fa-brands fa-whatsapp"></i> Chat WA
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td style="font-weight: 700; color: #475569;">{{ $iz->guru->nip ?? '-' }}</td>
                            <td style="font-weight: 600; color: #334155;">
                                {{ \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d M Y') }}
                                @if($iz->tanggal_mulai !== $iz->tanggal_selesai)
                                    s/d {{ \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d M Y') }}
                                @endif
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #1e293b;">{{ ucfirst($iz->jenis_izin ?? 'Izin') }}</span>
                                <div style="font-size: 12px; color: #64748b;">{{ Str::limit($iz->alasan ?? '-', 45) }}</div>
                            </td>
                            <td>
                                @if($iz->status_waka_sdm === 'approved' || $iz->status === 'disetujui')
                                    <span class="badge-status badge-status-disetujui">Resmi Disetujui</span>
                                @else
                                    <span class="badge-status badge-status-pending">Menunggu Approval</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px;">
                                Tidak ada data guru izin / tidak hadir pada tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card 2: Penugasan Guru Pengganti (Inval) -->
    @if(count($guruPengganti ?? []) > 0)
        <div class="card-panel">
            <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-people-arrows" style="color: #4338ca;"></i>
                Penugasan Guru Pengganti / Inval ({{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }})
            </h2>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Guru Tidak Hadir</th>
                            <th>Guru Pengganti</th>
                            <th>Kelas &amp; Mapel</th>
                            <th>Jam Ke</th>
                            <th>Status Penugasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guruPengganti as $idx => $gp)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td><strong style="color: #dc2626;">{{ $gp->guruUtama->nama_guru ?? '-' }}</strong></td>
                                <td><strong style="color: #16a34a;">{{ $gp->guruPengganti->nama_guru ?? '-' }}</strong></td>
                                <td>
                                    <div><strong>{{ $gp->jadwal->kelas->nama_kelas ?? '-' }}</strong></div>
                                    <div style="font-size: 12px; color: #64748b;">{{ $gp->jadwal->mapel->nama_mapel ?? '-' }}</div>
                                </td>
                                <td style="font-weight: 700; color: #334155;">Jam Ke-{{ $gp->jadwal->jam_ke ?? '-' }}</td>
                                <td><span class="badge-status badge-status-hadir">Bertugas</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Card 3: Monitoring Pengisian Jurnal KBM -->
    <div class="card-panel">
        <h2 style="font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-book-open-reader" style="color: #2563eb;"></i>
            Monitoring Pengisian Jurnal KBM ({{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }})
        </h2>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Jam Ke</th>
                        <th>Kelas &amp; Mapel</th>
                        <th>Guru Pengajar</th>
                        <th>Materi Pembelajaran</th>
                        <th>Status Kehadiran</th>
                        <th style="text-align: center; width: 70px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnalTerisi as $index => $j)
                        <tr>
                            <td>{{ $jurnalTerisi->firstItem() + $index }}</td>
                            <td style="font-weight: 800; color: #2563eb;">
                                Jam Ke-{{ $j->jam_ke ?? ($j->jadwal->jam_ke ?? '-') }}
                            </td>
                            <td>
                                <strong style="color: #0f172a;">{{ $j->kelas->nama_kelas ?? ($j->jadwal->kelas->nama_kelas ?? '-') }}</strong>
                                <div style="font-size: 12px; color: #64748b;">{{ $j->mapel->nama_mapel ?? ($j->jadwal->mapel->nama_mapel ?? '-') }}</div>
                            </td>
                            <td>
                                <strong style="color: #1e293b;">{{ $j->guru->nama_guru ?? ($j->jadwal->guru->nama_guru ?? '-') }}</strong>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #334155;">{{ Str::limit($j->materi ?? '-', 50) }}</div>
                                @if(!empty($j->kondisi_kelas))
                                    <div style="font-size: 11.5px; color: #64748b;">Catatan: {{ Str::limit($j->kondisi_kelas, 40) }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge-status badge-status-hadir"><i class="fa-solid fa-circle-check"></i> Terisi (Hadir)</span>
                            </td>
                            <td>
                                <div style="display: flex; justify-content: center;">
                                    <button type="button" class="btn-act btn-act-view" onclick='openModalDetailJurnal(@json($j))' title="Detail Jurnal">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 40px;">
                                <i class="fa-solid fa-folder-open" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                Belum ada entri jurnal KBM terisi untuk tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jurnalTerisi->hasPages())
            {{ $jurnalTerisi->links('partials.custom-pagination') }}
        @endif
    </div>
</div>

<!-- MODAL DETAIL JURNAL KBM -->
<div id="modalDetailJurnal" class="modal-backdrop-custom">
    <div class="modal-card-custom">
        <div class="modal-header-custom">
            <h3><i class="fa-solid fa-book-bookmark" style="color: #2563eb;"></i> Detail Jurnal KBM Harian</h3>
            <button type="button" onclick="closeModalDetailJurnal()" style="background:none; border:none; color:#64748b; font-size:18px; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body-custom">
            <div style="background: #f8fafc; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 16px;">
                <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Materi Pembelajaran</div>
                <div id="j_materi" style="font-size: 15px; font-weight: 800; color: #0f172a; margin-top: 4px;"></div>
            </div>

            <div class="form-grid-2" style="font-size: 13px; line-height: 1.8;">
                <div><strong>Tanggal:</strong> <span id="j_tanggal"></span></div>
                <div><strong>Jam Ke:</strong> <span id="j_jam"></span></div>
                <div><strong>Kelas:</strong> <span id="j_kelas"></span></div>
                <div><strong>Mata Pelajaran:</strong> <span id="j_mapel"></span></div>
                <div><strong>Guru Pengajar:</strong> <span id="j_guru"></span></div>
                <div><strong>Pertemuan Ke:</strong> <span id="j_pertemuan"></span></div>
                <div style="grid-column: span 2;"><strong>Kondisi Kelas &amp; Catatan:</strong> <span id="j_kondisi"></span></div>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" onclick="closeModalDetailJurnal()" class="btn-reset-light">Tutup</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModalDetailJurnal(data) {
        document.getElementById('j_materi').innerText = data.materi || '-';
        document.getElementById('j_tanggal').innerText = data.tanggal || '-';
        document.getElementById('j_jam').innerText = 'Jam Ke-' + (data.jam_ke || (data.jadwal ? data.jadwal.jam_ke : '-'));
        document.getElementById('j_kelas').innerText = data.kelas ? data.kelas.nama_kelas : (data.jadwal && data.jadwal.kelas ? data.jadwal.kelas.nama_kelas : '-');
        document.getElementById('j_mapel').innerText = data.mapel ? data.mapel.nama_mapel : (data.jadwal && data.jadwal.mapel ? data.jadwal.mapel.nama_mapel : '-');
        document.getElementById('j_guru').innerText = data.guru ? data.guru.nama_guru : (data.jadwal && data.jadwal.guru ? data.jadwal.guru.nama_guru : '-');
        document.getElementById('j_pertemuan').innerText = data.pertemuan_ke ? 'Pertemuan Ke-' + data.pertemuan_ke : '-';
        document.getElementById('j_kondisi').innerText = data.kondisi_kelas || '-';

        document.getElementById('modalDetailJurnal').style.display = 'flex';
    }

    function closeModalDetailJurnal() {
        document.getElementById('modalDetailJurnal').style.display = 'none';
    }
</script>
@endsection
