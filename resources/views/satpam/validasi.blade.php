@extends('layouts.guru')

@section('title', 'Validasi Presensi & Dispen — Portal Satpam Jurnal SMEA')

@section('content')
<div class="validasi-page-wrapper">

    @if(session('success'))
        <div style="background: #dcfce7; border: 1px solid #86efac; color: #14532d; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 700; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #16a34a;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #7f1d1d; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 700; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px; color: #dc2626;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header Page Title & Subtitle matching TU style -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1>Validasi Dispensasi & Izin</h1>
            <p>{{ $formattedDate ?? \Carbon\Carbon::now()->translatedFormat('l, j F Y') }} &nbsp;•&nbsp; Scan dan validasi izin keluar/masuk siswa secara real-time</p>
        </div>
    </div>

    <!-- Main Content Card: Scan Barcode Siswa -->
    <div class="validasi-main-card">
        <div class="validasi-card-content">
            
            <!-- Large Barcode / QR Code Illustration -->
            <div class="barcode-illustration">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                    <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                    <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                    <path d="M14 14h3v3h-3z"></path>
                    <path d="M18 18h3v3h-3z"></path>
                    <path d="M18 14h3"></path>
                    <path d="M14 18v3"></path>
                </svg>
            </div>

            <!-- Title & Subtitle -->
            <h2 class="scan-heading">Scan Barcode Siswa</h2>
            <p class="scan-subheading">
                Arahkan kamera ke barcode izin keluar/masuk siswa<br>untuk melakukan validasi instan.
            </p>

            <!-- Action Button BUKA KAMERA -->
            <button type="button" class="btn-buka-kamera-validasi" id="btnToggleCameraValidasi" onclick="toggleValidasiCamera()">
                <i class="fa-solid fa-camera"></i> BUKA KAMERA
            </button>

            <!-- Camera Scanner Container (Hidden by default) -->
            <div id="validasiCameraBox" class="validasi-camera-container" style="display: none;">
                <div id="reader"></div>
                <p class="camera-info-note">
                    <i class="fa-solid fa-circle-info"></i> Pastikan kode QR berada tepat di tengah area kamera scanner.
                </p>
            </div>

            <!-- Manual Search Form -->
            <form id="validasiSearchForm" onsubmit="handleValidasiSearch(event)" class="validasi-form-search">
                <div class="search-input-group">
                    <input type="text" id="validasiQueryInput" class="validasi-input-control" placeholder="Ketik Kode Dispen / NISN / Nama Siswa..." required>
                    <button type="submit" class="btn-submit-search">
                        <i class="fa-solid fa-magnifying-glass"></i> Periksa Data
                    </button>
                    <button type="button" class="btn-reset-search-form" onclick="resetValidasiSearchResult()" title="Reset Hasil Scan & Data Input">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </button>
                </div>
            </form>

            <!-- Search Result Card -->
            <div id="validasiResultBox" class="validasi-result-card" style="display: none;">
                <div id="validasiResultContent"></div>
            </div>

        </div>
    </div>

    <!-- Section: Daftar Izin Dispen Siswa Hari Ini dengan Form Filter & Reset -->
    <div class="validasi-table-card">
        <div class="table-card-header">
            <h3 class="table-card-title">
                <i class="fa-solid fa-list-check"></i> Daftar Izin Dispen Siswa Hari Ini ({{ $today }})
            </h3>
            <div style="display: flex; align-items: center; gap: 8px;">
                @if(isset($totalMenungguValidasi) && $totalMenungguValidasi > 0)
                    <span style="background: #fee2e2; border: 1px solid #fca5a5; color: #dc2626; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 11.5px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(220, 38, 38, 0.15);">
                        <i class="fa-solid fa-circle-exclamation fa-beat"></i> {{ $totalMenungguValidasi }} Belum Divalidasi
                    </span>
                @endif
                <span class="table-count-pill">{{ $dispenList->count() }} Data</span>
            </div>
        </div>

        <!-- Filter & Search Bar untuk Tabel Validasi -->
        <div class="table-filter-bar" style="padding: 16px 24px; background: #ffffff; border-bottom: 1px solid #e2e8f0;">
            <form method="GET" action="{{ route('satpam.validasi') }}" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                <div style="position: relative; flex: 1; min-width: 220px;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px;"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Kode Dispen / Nama Siswa / NISN..." style="width: 100%; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px 8px 34px; font-size: 12.5px; outline: none; font-family: inherit;">
                </div>

                <div style="width: 200px;">
                    <select name="status" style="width: 100%; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px; font-size: 12.5px; outline: none; font-family: inherit;">
                        <option value="">-- Semua Status Satpam --</option>
                        <option value="belum_keluar" {{ request('status') == 'belum_keluar' ? 'selected' : '' }}>Belum Keluar</option>
                        <option value="dizinkan_keluar" {{ request('status') == 'dizinkan_keluar' ? 'selected' : '' }}>Dizinkan Keluar</option>
                        <option value="sudah_kembali" {{ request('status') == 'sudah_kembali' ? 'selected' : '' }}>Sudah Kembali</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <button type="submit" style="background: #2563eb; color: #ffffff; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 12.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>

                @if(request()->hasAny(['q', 'status']))
                    <a href="{{ route('satpam.validasi') }}" style="background: #e2e8f0; color: #475569; text-decoration: none; padding: 8px 14px; border-radius: 8px; font-weight: 700; font-size: 12.5px; display: inline-flex; align-items: center;">
                        <i class="fa-solid fa-rotate-left" style="margin-right: 4px;"></i> Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="satpam-custom-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jam Dispen</th>
                        <th>Persetujuan Waka</th>
                        <th>Status Satpam</th>
                        <th>Aksi Gerbang</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dispenList as $d)
                    @php
                        $isApprovedWaka = ($d->status_waka === 'approved' || $d->status_wali_kelas === 'approved');
                    @endphp
                    <tr>
                        <td class="cell-kode">{{ $d->kode_dispen }}</td>
                        <td class="cell-nama">{{ $d->siswa->nama_siswa ?? '-' }}</td>
                        <td class="cell-kelas">{{ $d->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $d->jam_keluar }} - {{ $d->jam_kembali }}</td>
                        <td>
                            @if($isApprovedWaka)
                                <span class="badge-status status-approved">
                                    <i class="fa-solid fa-circle-check"></i> Disetujui Waka
                                </span>
                            @elseif($d->status_waka === 'rejected' || $d->status_wali_kelas === 'rejected')
                                <span class="badge-status status-rejected">
                                    <i class="fa-solid fa-circle-xmark"></i> Ditolak Waka
                                </span>
                            @else
                                <span class="badge-status status-pending">
                                    <i class="fa-solid fa-clock"></i> Pending Waka
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($d->status_satpam === 'dizinkan_keluar')
                                <span class="badge-satpam satpam-keluar">Keluar Gerbang</span>
                            @elseif($d->status_satpam === 'sudah_kembali')
                                <span class="badge-satpam satpam-kembali">Sudah Kembali</span>
                            @elseif($d->status_satpam === 'ditolak')
                                <span class="badge-satpam satpam-ditolak">Ditolak</span>
                            @else
                                <span class="badge-satpam satpam-belum">Belum Keluar</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <button type="button" class="btn-detail-sm" onclick='openDetailModal(@json($d))'>
                                    <i class="fa-solid fa-eye"></i> Detail
                                </button>

                                @if($isApprovedWaka)
                                    <form action="{{ route('satpam.update-status', $d->id_siswa_dispen) }}" method="POST" class="inline-form">
                                        @csrf
                                        @if($d->status_satpam === 'belum_keluar')
                                            <button type="submit" name="status_satpam" value="dizinkan_keluar" class="btn-table-action btn-blue">
                                                <i class="fa-solid fa-door-open"></i> Izinkan Keluar
                                            </button>
                                        @elseif($d->status_satpam === 'dizinkan_keluar')
                                            <button type="submit" name="status_satpam" value="sudah_kembali" class="btn-table-action btn-purple">
                                                <i class="fa-solid fa-door-closed"></i> Konfirmasi Kembali
                                            </button>
                                        @else
                                            <span class="text-completed"><i class="fa-solid fa-circle-check"></i> Selesai</span>
                                        @endif
                                    </form>
                                @else
                                    <span class="text-hold"><i class="fa-solid fa-ban"></i> Perlu Persetujuan Waka</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center-empty">
                            Belum ada data dispen siswa yang sesuai filter pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Detail Dispen Overlay -->
<div id="modalDetailDispen" class="modal-backdrop-custom" onclick="if(event.target === this) closeDetailModal()">
    <div class="modal-card-detail">
        <div class="modal-detail-header">
            <h3><i class="fa-solid fa-id-card-clip"></i> Detail Presensi & Izin Siswa</h3>
            <button type="button" class="modal-detail-close" onclick="closeDetailModal()">&times;</button>
        </div>
        <div class="modal-detail-body" id="modalDetailBody">
            <!-- Dynamic content populated via JS -->
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Header Box Card matching TU style */
    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-left h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .header-left p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }

    .validasi-page-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #0f172a;
    }

    /* Main Center Card */
    .validasi-main-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        padding: 40px 32px;
        margin-bottom: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .validasi-card-content {
        width: 100%;
        max-width: 520px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .barcode-illustration, .qr-code-illustration {
        color: #0f172a;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .scan-heading {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px 0;
    }

    .scan-subheading {
        font-size: 12.5px;
        color: #64748b;
        margin: 0 0 20px 0;
        line-height: 1.5;
    }

    .btn-buka-kamera-validasi {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37,99,235,0.25);
        transition: all 0.2s ease;
        margin-bottom: 16px;
    }
    .btn-buka-kamera-validasi:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .validasi-camera-container {
        width: 100%;
        margin-bottom: 16px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        padding: 10px;
    }

    .camera-info-note {
        font-size: 11px;
        color: #64748b;
        margin-top: 8px;
        font-weight: 600;
    }

    .validasi-form-search {
        width: 100%;
    }

    .search-input-group {
        display: flex;
        gap: 8px;
        width: 100%;
    }

    .validasi-input-control {
        flex: 1;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 13px;
        outline: none;
        font-family: inherit;
        color: #1e293b;
        transition: all 0.2s ease;
    }
    .validasi-input-control:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-submit-search {
        background: #384972;
        color: #ffffff;
        border: none;
        padding: 0 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s ease;
    }
    .btn-submit-search:hover {
        background: #2563eb;
    }

    .btn-reset-search-form {
        background: #e2e8f0;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 0 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }
    .btn-reset-search-form:hover {
        background: #cbd5e1;
        color: #0f172a;
    }

    .validasi-result-card {
        width: 100%;
        margin-top: 14px;
        text-align: left;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 14px;
    }

    /* Table Section */
    .validasi-table-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .table-card-header {
        padding: 20px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-card-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-count-pill {
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #bfdbfe;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .satpam-custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .satpam-custom-table th {
        background: #f1f5f9;
        color: #475569;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.05em;
        padding: 14px 18px;
        border-bottom: 1px solid #e2e8f0;
    }

    .satpam-custom-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
    }

    .cell-kode {
        font-family: monospace;
        font-weight: 800;
        color: #2563eb;
    }

    .cell-nama {
        font-weight: 700;
        color: #0f172a;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
    }
    .status-approved { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
    .status-rejected { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .status-pending  { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

    .badge-satpam {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
    }
    .satpam-keluar  { background: #dcfce7; color: #166534; }
    .satpam-kembali { background: #f3e8ff; color: #6b21a8; }
    .satpam-ditolak { background: #fee2e2; color: #991b1b; }
    .satpam-belum   { background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; }

    .btn-detail-sm {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .btn-detail-sm:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .btn-table-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 800;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-blue { background: #2563eb; color: #ffffff; }
    .btn-blue:hover { background: #1d4ed8; }
    .btn-purple { background: #7c3aed; color: #ffffff; }
    .btn-purple:hover { background: #6d28d9; }

    .text-completed { font-size: 12px; color: #16a34a; font-weight: 800; }
    .text-hold { font-size: 11.5px; color: #c2410c; font-weight: 700; }
    .text-center-empty { text-align: center; padding: 30px; color: #94a3b8; font-weight: 600; }

    /* Custom Styling Override untuk Camera Scanner & File Upload HTML5-QRCode */
    #reader {
        border: 2px dashed #3b82f6 !important;
        border-radius: 14px !important;
        background: #ffffff !important;
        padding: 16px !important;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03) !important;
    }
    #reader button {
        background: #2563eb !important;
        color: #ffffff !important;
        border: none !important;
        padding: 10px 18px !important;
        border-radius: 10px !important;
        font-weight: 800 !important;
        font-size: 13px !important;
        cursor: pointer !important;
        margin: 6px 4px !important;
        font-family: inherit !important;
        transition: background 0.15s ease !important;
    }
    #reader button:hover {
        background: #1d4ed8 !important;
    }
    #reader a {
        color: #2563eb !important;
        font-weight: 800 !important;
        text-decoration: none !important;
        font-size: 13px !important;
        display: inline-block !important;
        margin-top: 8px !important;
    }
    #reader select {
        padding: 8px 12px !important;
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
    }

    /* Modal Detail Dispen Custom Overlay */
    .modal-backdrop-custom {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999999 !important;
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-card-detail {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 620px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        max-height: 90vh;
        animation: modalFadeIn 0.2s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-detail-header {
        padding: 18px 24px;
        background: #384972;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-detail-header h3 {
        font-size: 16.5px;
        font-weight: 800;
        margin: 0;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-detail-close {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: #ffffff;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s;
    }

    .modal-detail-close:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .modal-detail-body {
        padding: 24px;
        overflow-y: auto;
        flex: 1;
    }

    .detail-section-title {
        font-size: 11.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #64748b;
        margin: 16px 0 10px 0;
        padding-bottom: 4px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-section-title:first-child {
        margin-top: 0;
    }

    .detail-item-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 9px 0;
        font-size: 13px;
        border-bottom: 1px dashed #f1f5f9;
        gap: 12px;
    }

    .detail-item-row .lbl {
        color: #64748b;
        font-weight: 600;
        min-width: 140px;
    }

    .detail-item-row .val {
        color: #0f172a;
        font-weight: 700;
        text-align: right;
    }

    .badge-code {
        background: #f1f5f9;
        padding: 3px 8px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 12.5px;
        color: #1e293b;
        border: 1px solid #cbd5e1;
    }

    .detail-image-box {
        display: flex;
        gap: 12px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .detail-image-box img {
        max-width: 100%;
        max-height: 180px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        object-fit: cover;
    }
</style>
@endsection

@section('scripts')
<!-- Include HTML5 QR Code Library -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScannerValidasi = null;
    let cameraActiveValidasi = false;

    // Helper untuk format URL gambar agar terhindar dari broken link
    function formatImageUrl(path) {
        if (!path) return '';
        if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('data:image')) return path;
        if (path.startsWith('/')) return path;
        return '{{ asset("") }}' + path;
    }

    function toggleValidasiCamera() {
        const box = document.getElementById('validasiCameraBox');
        const btn = document.getElementById('btnToggleCameraValidasi');

        if (!cameraActiveValidasi) {
            box.style.display = 'block';
            btn.innerHTML = '<i class="fa-solid fa-stop"></i> TUTUP KAMERA';
            btn.style.background = '#dc2626';

            if (!html5QrcodeScannerValidasi) {
                html5QrcodeScannerValidasi = new Html5QrcodeScanner("reader", { 
                    fps: 10, 
                    qrbox: { width: 250, height: 250 } 
                }, false);
            }
            html5QrcodeScannerValidasi.render(onScanSuccessValidasi);
            startIndonesianScannerTranslationValidasi();
            cameraActiveValidasi = true;
        } else {
            if (html5QrcodeScannerValidasi) {
                try { html5QrcodeScannerValidasi.clear(); } catch(e) {}
            }
            if (scannerTranslateTimerValidasi) clearInterval(scannerTranslateTimerValidasi);
            box.style.display = 'none';
            btn.innerHTML = '<i class="fa-solid fa-camera"></i> BUKA KAMERA';
            btn.style.background = '#2563eb';
            cameraActiveValidasi = false;
        }
    }

    function triggerNativeCameraValidasi() {
        let nativeInput = document.getElementById('nativeCameraInputValidasi');
        if (!nativeInput) {
            nativeInput = document.createElement('input');
            nativeInput.type = 'file';
            nativeInput.id = 'nativeCameraInputValidasi';
            nativeInput.accept = 'image/*';
            nativeInput.setAttribute('capture', 'environment');
            nativeInput.style.display = 'none';
            nativeInput.onchange = handleNativeCameraUploadValidasi;
            document.body.appendChild(nativeInput);
        }
        nativeInput.click();
    }

    function handleNativeCameraUploadValidasi(event) {
        const file = event.target.files[0];
        if (!file) return;

        const resBox = document.getElementById('validasiResultBox');
        const content = document.getElementById('validasiResultContent');
        if (resBox && content) {
            resBox.style.display = 'block';
            content.innerHTML = '<div style="color: #2563eb; font-weight: 700; padding: 14px; text-align: center;"><i class="fa-solid fa-spinner fa-spin"></i> Membaca data barcode dari kamera...</div>';
        }

        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.scanFile(file, true)
            .then(decodedText => {
                document.getElementById('validasiQueryInput').value = decodedText;
                doSearchQueryValidasi(decodedText);
            })
            .catch(err => {
                if (resBox && content) {
                    content.innerHTML = `
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 11px; font-weight: 800; color: #dc2626; text-transform: uppercase;">Hasil Scan Kamera</span>
                            <button type="button" onclick="resetValidasiSearchResult()" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer;">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </button>
                        </div>
                        <div style="color: #dc2626; font-weight: 700;"><i class="fa-solid fa-circle-xmark"></i> Barcode tidak dapat dibaca dari foto kamera. Pastikan posisi barcode terang & tidak buram, lalu coba foto kembali!</div>
                    `;
                }
            });
    }

    let scannerTranslateTimerValidasi = null;
    function startIndonesianScannerTranslationValidasi() {
        if (scannerTranslateTimerValidasi) clearInterval(scannerTranslateTimerValidasi);
        scannerTranslateTimerValidasi = setInterval(function() {
            const fileBtn = document.getElementById('html5-qrcode-button-file-selection');
            if (fileBtn && (fileBtn.innerText.includes('Choose Image') || fileBtn.innerText.includes('Choose Another') || fileBtn.innerText.includes('chosen'))) {
                fileBtn.innerText = '📁 Pilih Foto Barcode / QR Code';
            }

            const permBtn = document.getElementById('html5-qrcode-button-camera-permission');
            if (permBtn) {
                if (permBtn.innerText.includes('Request')) {
                    permBtn.innerText = '🎥 Izinkan Akses Kamera Satpam';
                }
                // Jika lingkungan HTTP (non-secure context), alihkan klik ke Kamera Perangkat
                if (!window.isSecureContext) {
                    permBtn.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        triggerNativeCameraValidasi();
                    };
                }
            }

            const startBtn = document.getElementById('html5-qrcode-button-camera-start');
            if (startBtn && startBtn.innerText.includes('Start')) {
                startBtn.innerText = '▶ Mulai Kamera Scanner';
            }

            const stopBtn = document.getElementById('html5-qrcode-button-camera-stop');
            if (stopBtn && stopBtn.innerText.includes('Stop')) {
                stopBtn.innerText = '⏹ Hentikan Kamera Scanner';
            }

            const anchor = document.getElementById('html5-qrcode-anchor-scan-type-change');
            if (anchor) {
                if (anchor.innerText.includes('camera directly') || anchor.innerText.includes('camera')) {
                    anchor.innerText = '📷 Ganti ke Mode Kamera Scanner Langsung';
                } else if (anchor.innerText.includes('file') || anchor.innerText.includes('image') || anchor.innerText.includes('Scan an Image File')) {
                    anchor.innerText = '🖼 Ganti ke Mode Upload File Foto Barcode';
                }
            }

            const readerDiv = document.getElementById('reader');
            if (readerDiv) {
                const allElements = readerDiv.querySelectorAll('div, span, p, label');
                allElements.forEach(el => {
                    if (el.children.length === 0 && el.innerText.includes('Or drop an image to scan')) {
                        el.innerText = 'Atau seret & lepas file gambar barcode di sini';
                    }
                    if (el.children.length === 0 && (el.innerText.includes('secure context') || el.innerText.includes('https or localhost'))) {
                        el.parentNode.innerHTML = `
                            <div style="background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; padding: 12px 16px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin-bottom: 12px; text-align: center;">
                                <i class="fa-solid fa-camera-retro" style="color: #10b981; font-size: 18px; margin-bottom: 4px;"></i><br>
                                Mode Kamera Perangkat Siap Digunakan!<br>
                                <span style="font-size: 11.5px; font-weight: 600; color: #047857;">Sistem mendeteksi akses jaringan HTTP. Klik tombol hijau di bawah untuk mengambil foto barcode langsung dengan kamera HP/Perangkat.</span>
                            </div>
                            <button type="button" onclick="triggerNativeCameraValidasi()" style="width: 100%; background: #16a34a; color: white; border: none; padding: 12px 18px; border-radius: 12px; font-weight: 800; font-size: 13.5px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(22,163,74,0.3);">
                                <i class="fa-solid fa-camera-retro"></i> AMBIL FOTO BARCODE KAMERA
                            </button>
                        `;
                    }
                });
            }
        }, 150);
    }

    function onScanSuccessValidasi(decodedText, decodedResult) {
        document.getElementById('validasiQueryInput').value = decodedText;
        doSearchQueryValidasi(decodedText);
    }

    function handleValidasiSearch(e) {
        e.preventDefault();
        const query = document.getElementById('validasiQueryInput').value;
        doSearchQueryValidasi(query);
    }

    function resetValidasiSearchResult() {
        // 1. Reset input value
        const input = document.getElementById('validasiQueryInput');
        if (input) input.value = '';

        // 2. Sembunyikan & bersihkan kotak hasil pencarian
        const resBox = document.getElementById('validasiResultBox');
        const resContent = document.getElementById('validasiResultContent');
        if (resBox) resBox.style.display = 'none';
        if (resContent) resContent.innerHTML = '';

        // 3. Reset input file foto barcode
        const fileInputs = document.querySelectorAll('#reader input[type="file"]');
        fileInputs.forEach(fileInput => { fileInput.value = ''; });

        // 4. Reset scanner DOM & re-render jika sedang aktif
        if (html5QrcodeScannerValidasi) {
            try {
                html5QrcodeScannerValidasi.clear().then(() => {
                    if (cameraActiveValidasi) {
                        html5QrcodeScannerValidasi = new Html5QrcodeScanner("reader", { 
                            fps: 10, 
                            qrbox: { width: 250, height: 250 } 
                        }, false);
                        html5QrcodeScannerValidasi.render(onScanSuccessValidasi);
                        startIndonesianScannerTranslationValidasi();
                    }
                }).catch(err => {
                    if (cameraActiveValidasi) {
                        const readerElem = document.getElementById('reader');
                        if (readerElem) readerElem.innerHTML = '';
                        html5QrcodeScannerValidasi = new Html5QrcodeScanner("reader", { 
                            fps: 10, 
                            qrbox: { width: 250, height: 250 } 
                        }, false);
                        html5QrcodeScannerValidasi.render(onScanSuccessValidasi);
                        startIndonesianScannerTranslationValidasi();
                    }
                });
            } catch (e) {
                if (cameraActiveValidasi) {
                    const readerElem = document.getElementById('reader');
                    if (readerElem) readerElem.innerHTML = '';
                    html5QrcodeScannerValidasi = new Html5QrcodeScanner("reader", { 
                        fps: 10, 
                        qrbox: { width: 250, height: 250 } 
                    }, false);
                    html5QrcodeScannerValidasi.render(onScanSuccessValidasi);
                    startIndonesianScannerTranslationValidasi();
                }
            }
        }

        if (input) input.focus();
    }

    function doSearchQueryValidasi(query) {
        fetch('{{ route("satpam.search") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ q: query })
        })
        .then(res => res.json())
        .then(data => {
            const resBox = document.getElementById('validasiResultBox');
            const content = document.getElementById('validasiResultContent');
            resBox.style.display = 'block';

            if (!data.success) {
                content.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span style="font-size: 11px; font-weight: 800; color: #dc2626; text-transform: uppercase;">Hasil Scan Barcode</span>
                        <button type="button" onclick="resetValidasiSearchResult()" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer;">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </button>
                    </div>
                    <div style="color: #dc2626; font-weight: 700;"><i class="fa-solid fa-circle-xmark"></i> ${data.message}</div>
                `;
                return;
            }

            const d = data.data;
            let barcodeBadge = '';
            if (d.barcode_status === 'aktif') {
                barcodeBadge = `
                    <div style="background: #dcfce7; border: 1px solid #86efac; color: #14532d; padding: 10px 14px; border-radius: 10px; font-weight: 800; font-size: 12.5px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #16a34a;"></i>
                        <div>
                            <div>BARCODE AKTIF (Bisa Di-scan & Diperiksa)</div>
                            <div style="font-size: 11px; font-weight: 600; color: #166534;">Telah disetujui Waka (${d.nama_waka}). Klik 'Validasi Data Sesuai' di bawah untuk memproses izin keluar.</div>
                        </div>
                    </div>
                `;
            } else {
                barcodeBadge = `
                    <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #7f1d1d; padding: 10px 14px; border-radius: 10px; font-weight: 800; font-size: 12.5px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-lock" style="font-size: 18px; color: #dc2626;"></i>
                        <div>
                            <div>BARCODE TELAH DIVALIDASI & TIDAK DAPAT DIGUNAKAN LAGI</div>
                            <div style="font-size: 11px; font-weight: 600; color: #991b1b;">Waktu Validasi: ${d.waktu_scan_satpam || 'Sudah divalidasi Satpam'}. Barcode telah kadaluarsa.</div>
                        </div>
                    </div>
                `;
            }

            let fotoSiswaLiveSrc = d.foto_siswa_live ? formatImageUrl(d.foto_siswa_live) : null;
            let fotoKartuSrc = d.foto_kartu_identitas ? formatImageUrl(d.foto_kartu_identitas) : null;

            let photosGridHtml = `
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 12px; margin-top: 14px; margin-bottom: 14px;">
                    <!-- 1. Foto Kartu Identitas / Pelajar Siswa -->
                    <div style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 12px; text-align: center; display: flex; flex-direction: column; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                        <div style="font-size: 11px; font-weight: 800; color: #334155; text-transform: uppercase; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-address-card" style="color: #10b981; font-size: 13px;"></i> Foto Kartu Identitas / Pelajar Siswa
                        </div>
                        ${fotoKartuSrc ? `
                            <a href="${fotoKartuSrc}" target="_blank" title="Klik untuk memperbesar Foto Kartu Identitas">
                                <img src="${fotoKartuSrc}" style="width: 100%; max-height: 180px; object-fit: contain; border-radius: 8px; border: 1px solid #cbd5e1; background: #f8fafc;" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=Kartu+Pelajar+Tidak+Ditemukan';">
                            </a>
                            <div style="font-size: 10.5px; color: #059669; margin-top: 6px; font-weight: 700;">
                                <i class="fa-solid fa-shield-halved"></i> Periksa & cocokkan fisik kartu ini di gerbang
                            </div>
                        ` : `
                            <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; width: 100%; padding: 22px 10px; color: #94a3b8; font-size: 12px; font-weight: 600;">
                                <i class="fa-solid fa-id-card" style="font-size: 24px; color: #cbd5e1; margin-bottom: 6px;"></i><br>
                                Tidak ada Foto Kartu Identitas
                            </div>
                        `}
                    </div>

                    <!-- 2. Foto Siswa (Live Kamera) -->
                    <div style="background: #eff6ff; border: 1.5px solid #93c5fd; border-radius: 12px; padding: 12px; text-align: center; display: flex; flex-direction: column; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(37,99,235,0.05);">
                        <div style="font-size: 11px; font-weight: 800; color: #1e40af; text-transform: uppercase; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-camera-retro" style="color: #2563eb; font-size: 13px;"></i> Foto Siswa (Live Kamera)
                        </div>
                        ${fotoSiswaLiveSrc ? `
                            <a href="${fotoSiswaLiveSrc}" target="_blank" title="Klik untuk memperbesar Foto Live Siswa">
                                <img src="${fotoSiswaLiveSrc}" style="width: 100%; max-height: 180px; object-fit: contain; border-radius: 8px; border: 1px solid #bfdbfe; background: #ffffff;" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=Foto+Live+Tidak+Ditemukan';">
                            </a>
                            <div style="font-size: 10.5px; color: #1d4ed8; margin-top: 6px; font-weight: 700;">
                                <i class="fa-solid fa-circle-check"></i> Foto Live saat pengajuan di Pos Piket
                            </div>
                        ` : `
                            <div style="background: #ffffff; border: 1px dashed #bfdbfe; border-radius: 8px; width: 100%; padding: 22px 10px; color: #94a3b8; font-size: 12px; font-weight: 600;">
                                <i class="fa-solid fa-camera-slash" style="font-size: 24px; color: #93c5fd; margin-bottom: 6px;"></i><br>
                                Tidak ada Foto Siswa (Live Kamera)
                            </div>
                        `}
                    </div>
                </div>
            `;

            let actionForm = '';
            if (d.barcode_status === 'aktif') {
                const updateUrl = `{{ url('/satpam/update-status') }}/${d.id_siswa_dispen}`;
                actionForm = `
                    <form action="${updateUrl}" method="POST" style="margin-top: 14px;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="status_satpam" value="dizinkan_keluar">
                        <button type="submit" style="width: 100%; background: #16a34a; color: white; border: none; padding: 12px 16px; border-radius: 12px; font-weight: 800; font-size: 13.5px; cursor: pointer; transition: background 0.15s ease;" onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                            <i class="fa-solid fa-shield-check"></i> VALIDASI DATA SESUAI & IZINKAN KELUAR
                        </button>
                    </form>
                `;
            }

            content.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 6px; border-bottom: 1px solid #e2e8f0;">
                    <span style="font-size: 11.5px; font-weight: 800; color: #3b82f6; text-transform: uppercase;"><i class="fa-solid fa-qrcode"></i> Hasil Pemindaian Barcode</span>
                    <button type="button" onclick="resetValidasiSearchResult()" style="background: #e2e8f0; color: #475569; border: none; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="fa-solid fa-rotate-left"></i> Reset Scan
                    </button>
                </div>
                ${barcodeBadge}
                <h4 style="margin: 0; color: #1e293b; font-size: 16px; font-weight: 800;">${d.nama_siswa} (${d.kelas})</h4>
                <p style="margin: 4px 0; font-size: 13px; color: #64748b;">Kode: <strong>${d.kode_dispen}</strong> | Tanggal: <strong>${d.tanggal || '-'}</strong></p>
                <p style="margin: 4px 0; font-size: 13px; color: #64748b;">Jam Dispen: <strong>${d.jam_keluar} s/d ${d.jam_kembali} WIB</strong></p>
                <p style="margin: 4px 0; font-size: 13px; color: #64748b;">Disetujui Waka: <strong>${d.nama_waka}</strong> (${d.waktu_approval_waka})</p>
                <p style="margin: 4px 0 12px; font-size: 13px; color: #64748b;">Alasan: "${d.alasan}"</p>
                ${photosGridHtml}
                ${actionForm}
            `;
        })
        .catch(err => {
            console.error("Validasi search error:", err);
            const resBox = document.getElementById('validasiResultBox');
            const content = document.getElementById('validasiResultContent');
            if (resBox && content) {
                resBox.style.display = 'block';
                content.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span style="font-size: 11px; font-weight: 800; color: #dc2626; text-transform: uppercase;">Error Sistem</span>
                        <button type="button" onclick="resetValidasiSearchResult()" style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer;">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </button>
                    </div>
                    <div style="color: #dc2626; font-weight: 700;"><i class="fa-solid fa-circle-xmark"></i> Terjadi kesalahan saat memeriksa data. Silakan coba lagi.</div>
                `;
            }
        });
    }

    // Detail Modal Functionality
    function openDetailModal(item) {
        if (typeof item === 'string') {
            try { item = JSON.parse(item); } catch(e) {}
        }
        let isApprovedWaka = (item.status_waka === 'approved' || item.status_wali_kelas === 'approved');
        let wakaBadgeText = isApprovedWaka 
            ? '<span class="badge-status status-approved"><i class="fa-solid fa-circle-check"></i> Disetujui Waka</span>' 
            : '<span class="badge-status status-pending"><i class="fa-solid fa-clock"></i> Menunggu Persetujuan Waka</span>';
        
        let approverName = item.nama_waka || (item.waka_user ? item.waka_user.name : (item.nama_guru_piket || '-'));

        let satpamBadgeText = '';
        if (item.status_satpam === 'sudah_kembali') {
            satpamBadgeText = '<span class="badge-satpam satpam-kembali"><i class="fa-solid fa-check-double"></i> Sudah Kembali</span>';
        } else if (item.status_satpam === 'dizinkan_keluar') {
            satpamBadgeText = '<span class="badge-satpam satpam-keluar"><i class="fa-solid fa-door-open"></i> Dizinkan Keluar</span>';
        } else if (item.status_satpam === 'ditolak') {
            satpamBadgeText = '<span class="badge-satpam satpam-ditolak"><i class="fa-solid fa-xmark"></i> Ditolak</span>';
        } else {
            satpamBadgeText = '<span class="badge-satpam satpam-belum"><i class="fa-solid fa-clock"></i> Belum Keluar (Menunggu Validasi Gate)</span>';
        }

        let fotoSiswaLiveSrc = item.foto_siswa_live_url || (item.foto_siswa_live ? formatImageUrl(item.foto_siswa_live) : null);
        let fotoKartuSrc = item.foto_kartu_url || (item.foto_kartu_identitas ? formatImageUrl(item.foto_kartu_identitas) : null);
        let fotoSuratSrc = item.foto_surat_url || (item.foto_surat_dispen ? formatImageUrl(item.foto_surat_dispen) : null);
        let fotoSiswaSrc = (item.siswa && item.siswa.foto) ? formatImageUrl('uploads/profile_photos/' + item.siswa.foto) : null;

        let bodyHtml = `
            <div class="detail-grid">
                <div class="detail-section-title"><i class="fa-solid fa-user-graduate"></i> Data Informasi Siswa</div>
                <div class="detail-item-row">
                    <span class="lbl">Nama Siswa</span>
                    <span class="val font-bold">${item.siswa ? item.siswa.nama_siswa : '-'}</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">NISN / Kelas</span>
                    <span class="val">${item.siswa ? item.siswa.nisn : '-'} &bull; ${item.kelas ? item.kelas.nama_kelas : '-'}</span>
                </div>

                <div class="detail-section-title"><i class="fa-solid fa-clipboard-list"></i> Detail Perizinan / Dispensasi</div>
                <div class="detail-item-row">
                    <span class="lbl">Kode Dispen</span>
                    <span class="val badge-code">${item.kode_dispen || '-'}</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">Tanggal</span>
                    <span class="val">${item.tanggal || '-'}</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">Rencana Keluar - Kembali</span>
                    <span class="val">${item.jam_keluar || '-'} s/d ${item.jam_kembali || '-'} WIB</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">Alasan Izin</span>
                    <span class="val">${item.alasan || '-'}</span>
                </div>

                <div class="detail-section-title"><i class="fa-solid fa-user-check"></i> Status Approval & Validasi Gate</div>
                <div class="detail-item-row">
                    <span class="lbl">Persetujuan Waka</span>
                    <span class="val">${wakaBadgeText}</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">Nama Penyetuju Waka</span>
                    <span class="val">${approverName}</span>
                </div>
                <div class="detail-item-row">
                    <span class="lbl">Status Satpam (Gate)</span>
                    <span class="val">${satpamBadgeText}</span>
                </div>
                ${item.waktu_scan_satpam ? `
                <div class="detail-item-row">
                    <span class="lbl">Waktu Scan Satpam</span>
                    <span class="val">${item.waktu_scan_satpam}</span>
                </div>` : ''}
                ${item.catatan_satpam ? `
                <div class="detail-item-row">
                    <span class="lbl">Catatan Satpam</span>
                    <span class="val">${item.catatan_satpam}</span>
                </div>` : ''}

                ${(fotoSiswaLiveSrc || fotoKartuSrc || fotoSuratSrc || fotoSiswaSrc) ? `
                <div class="detail-section-title"><i class="fa-solid fa-image"></i> Lampiran & Bukti Foto Pengajuan</div>
                <div class="detail-image-box">
                    ${fotoKartuSrc ? `<div><div style="font-size:11px; color:#059669; margin-bottom:4px; font-weight:800;"><i class="fa-solid fa-address-card"></i> Foto Kartu Identitas / Pelajar:</div><a href="${fotoKartuSrc}" target="_blank"><img src="${fotoKartuSrc}" alt="Foto Identitas" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x120?text=Gambar+Identitas';"></a></div>` : ''}
                    ${fotoSiswaLiveSrc ? `<div><div style="font-size:11px; color:#1d4ed8; margin-bottom:4px; font-weight:800;"><i class="fa-solid fa-camera"></i> Foto Siswa (Live Kamera):</div><a href="${fotoSiswaLiveSrc}" target="_blank" title="Klik untuk perbesar Foto Live Siswa"><img src="${fotoSiswaLiveSrc}" alt="Foto Siswa Live" style="border: 2px solid #3b82f6; border-radius: 8px;" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x120?text=Foto+Live';"></a></div>` : ''}
                    ${fotoSuratSrc ? `<div><div style="font-size:11px; color:#64748b; margin-bottom:4px; font-weight:700;"><i class="fa-solid fa-file-lines"></i> Surat Dispen:</div><a href="${fotoSuratSrc}" target="_blank"><img src="${fotoSuratSrc}" alt="Surat Dispen" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x120?text=Surat+Dispen';"></a></div>` : ''}
                    ${fotoSiswaSrc ? `<div><div style="font-size:11px; color:#64748b; margin-bottom:4px; font-weight:700;"><i class="fa-solid fa-user"></i> Foto Profil Siswa:</div><a href="${fotoSiswaSrc}" target="_blank"><img src="${fotoSiswaSrc}" alt="Foto Profil Siswa" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x120?text=Foto+Siswa';"></a></div>` : ''}
                </div>` : ''}
            </div>
        `;

        if (isApprovedWaka) {
            let updateUrl = `{{ url('/satpam/update-status') }}/${item.id_siswa_dispen}`;
            let csrfToken = `{{ csrf_token() }}`;
            
            if (item.status_satpam === 'belum_keluar') {
                bodyHtml += `
                    <form action="${updateUrl}" method="POST" style="margin-top: 20px;">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="status_satpam" value="dizinkan_keluar">
                        <button type="submit" class="btn-table-action btn-blue" style="width: 100%; justify-content: center; padding: 10px 16px; font-size: 13px; font-weight: 800; border-radius: 10px;">
                            <i class="fa-solid fa-door-open"></i> Izinkan Keluar Sekolah
                        </button>
                    </form>
                `;
            } else if (item.status_satpam === 'dizinkan_keluar') {
                bodyHtml += `
                    <form action="${updateUrl}" method="POST" style="margin-top: 20px;">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="status_satpam" value="sudah_kembali">
                        <button type="submit" class="btn-table-action btn-purple" style="width: 100%; justify-content: center; padding: 10px 16px; font-size: 13px; font-weight: 800; border-radius: 10px;">
                            <i class="fa-solid fa-door-closed"></i> Konfirmasi Sudah Kembali
                        </button>
                    </form>
                `;
            }
        }

        document.getElementById('modalDetailBody').innerHTML = bodyHtml;
        document.getElementById('modalDetailDispen').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('modalDetailDispen').style.display = 'none';
    }
</script>
@endsection
