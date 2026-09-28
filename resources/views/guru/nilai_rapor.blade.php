@extends('layouts.guru')

@section('title', 'Nilai Siswa — EDU JOURNAL')
@section('header_title', 'Nilai Siswa')

@section('styles')
<style>
    /* Palette & Color Scheme */
    :root {
        --primary-blue: #2563eb;
        --primary-hover: #1d4ed8;
        --slate-dark: #384972;
        --slate-text: #0f172a;
        --muted-text: #64748b;
        --border-color: #cbd5e1;
        --border-light: #e2e8f0;
        --card-bg: #ffffff;
        --light-grey-bg: #f8fafc;
    }

    /* Top Summary Metric Cards */
    .stat-summary-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    @media (max-width: 1200px) {
        .stat-summary-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .stat-summary-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .stat-summary-grid { grid-template-columns: 1fr; }
    }

    .stat-metric-card {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 16px 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.05);
    }

    .stat-metric-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .stat-metric-label {
        font-size: 11.5px;
        font-weight: 800;
        color: var(--muted-text);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-metric-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .stat-metric-value {
        font-size: 23px;
        font-weight: 900;
        color: var(--slate-text);
        line-height: 1.1;
    }

    .stat-metric-subtext {
        font-size: 11.5px;
        color: var(--muted-text);
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Main Content Layout Grid */
    .nilai-layout-grid {
        display: grid;
        grid-template-columns: 2.85fr 1.15fr;
        gap: 22px;
    }

    @media (max-width: 1200px) {
        .nilai-layout-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Filter & Search Panel */
    .filter-card-container {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 18px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .filter-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex: 1;
        min-width: 140px;
    }

    .filter-group label {
        font-size: 11.5px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-select-custom, .form-input-custom {
        height: 40px;
        padding: 0 12px;
        border-radius: 9px;
        border: 1px solid var(--border-color);
        background: var(--light-grey-bg);
        color: #1e293b;
        font-size: 13px;
        font-weight: 600;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s;
        width: 100%;
    }

    .form-select-custom:focus, .form-input-custom:focus {
        border-color: var(--primary-blue);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    /* Main Table Container */
    .main-nilai-box {
        background: var(--card-bg);
        border-radius: 18px;
        border: 1px solid var(--border-color);
        padding: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.03);
    }

    .box-header-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .box-header-title h2 {
        font-size: 16px;
        font-weight: 800;
        color: var(--slate-text);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table-nilai-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-nilai-custom thead th {
        background: #f8fafc;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        padding: 10px 8px;
        text-align: center;
        letter-spacing: 0.5px;
        border-top: 1px solid var(--border-light);
        border-bottom: 2px solid var(--border-color);
        white-space: nowrap;
    }

    .table-nilai-custom tbody td {
        padding: 10px 8px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-nilai-custom tbody tr:hover {
        background: #f8fafc;
    }

    .student-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar-initial {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        background: #e2e8f0;
        color: #1e3a8a;
        font-weight: 800;
        font-size: 12.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .student-name {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.25;
    }

    .student-subinfo {
        font-size: 11px;
        color: #64748b;
        margin-top: 2px;
        font-weight: 500;
    }

    /* Score Input Badges */
    .input-score-control {
        width: 58px;
        height: 36px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 13px;
        text-align: center;
        border: 1.5px solid var(--border-color);
        background: #f8fafc;
        color: #1e293b;
        outline: none;
        transition: all 0.2s;
    }

    .input-score-control:focus {
        border-color: var(--primary-blue);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .score-high {
        background: #ecfdf5 !important;
        border-color: #a7f3d0 !important;
        color: #065f46 !important;
    }

    .score-medium {
        background: #eff6ff !important;
        border-color: #bfdbfe !important;
        color: #1e40af !important;
    }

    .score-low {
        background: #fef2f2 !important;
        border-color: #fecaca !important;
        color: #991b1b !important;
    }

    .badge-predikat {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 7px;
        font-weight: 900;
        font-size: 12.5px;
    }

    .predikat-A { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .predikat-B { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .predikat-C { background: #fef9c3; color: #854d0e; border: 1px solid #fef08a; }
    .predikat-D { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

    .badge-status-tuntas {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 800;
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .badge-status-belum {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 800;
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .badge-status-empty {
        display: inline-flex;
        align-items: center;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 10.5px;
        font-weight: 600;
        background: #f1f5f9;
        color: #64748b;
    }

    /* Reset Row Button (Replacing Detail View) */
    .btn-reset-row {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12.5px;
        transition: all 0.2s ease;
    }

    .btn-reset-row:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #dc2626;
        transform: rotate(-45deg);
    }

    /* Right Widgets */
    .widget-card {
        background: var(--card-bg);
        border-radius: 18px;
        border: 1px solid var(--border-color);
        padding: 18px;
        margin-bottom: 18px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.03);
    }

    .widget-title {
        font-size: 14px;
        font-weight: 800;
        color: var(--slate-text);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rapor-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        border-radius: 9px;
        background: #f8fafc;
        margin-bottom: 7px;
        font-size: 12.5px;
        font-weight: 700;
        border: 1px solid #f1f5f9;
    }

    .rapor-row.green-bg { background: #f0fdf4; border-color: #dcfce7; }
    .rapor-row.blue-bg  { background: #eff6ff; border-color: #dbeafe; }
    .rapor-row.red-bg   { background: #fef2f2; border-color: #fee2e2; }

    /* Action Buttons */
    .btn-action-primary {
        background: var(--primary-blue);
        color: #ffffff;
        padding: 9px 20px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 13px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        box-shadow: 0 3px 10px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }

    .btn-action-primary:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(37, 99, 235, 0.35);
    }

    .btn-action-secondary {
        background: #ffffff;
        color: #334155;
        border: 1px solid var(--border-color);
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 12.5px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-action-secondary:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 16px;
    }
    .modal-content-box {
        background: #ffffff;
        border-radius: 20px;
        max-width: 540px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        overflow: hidden;
        animation: modalScaleIn 0.2s ease;
    }
    @keyframes modalScaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Mobile Nilai Cards View */
    .mobile-nilai-cards-wrapper {
        display: none;
        flex-direction: column;
        gap: 14px;
    }

    .mobile-student-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .mobile-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
    }

    .mobile-result-banner {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .mobile-result-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        flex: 1;
    }

    .mobile-result-label {
        font-size: 9.5px;
        font-weight: 800;
        color: #64748b;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .mobile-scores-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .mobile-score-box {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .mobile-score-box label {
        font-size: 11px;
        font-weight: 800;
        color: #475569;
    }

    .mobile-score-box input {
        height: 40px;
        font-size: 14px;
        width: 100%;
        text-align: center;
    }

    /* Responsive Media Queries */
    @media (max-width: 768px) {
        .page-title-group h1 {
            font-size: 28px !important;
            line-height: 1.25;
        }

        .page-header-container {
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
            margin-bottom: 18px;
        }

        .page-header-actions {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            width: 100%;
        }

        .page-header-actions button,
        .page-header-actions a {
            justify-content: center;
            padding: 10px 12px;
            font-size: 12.5px;
        }

        .page-header-actions .btn-action-primary {
            grid-column: 1 / -1;
            padding: 11px 16px;
            font-size: 13.5px;
        }

        .stat-summary-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px;
            margin-bottom: 18px;
        }

        .filter-card-container {
            padding: 14px;
            margin-bottom: 16px;
        }

        .filter-row {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .filter-group {
            width: 100% !important;
            min-width: 100% !important;
        }

        .filter-row > div:last-child {
            padding-top: 6px !important;
            width: 100%;
        }

        .filter-row > div:last-child button {
            flex: 1;
            justify-content: center;
            height: 40px;
        }

        .filter-row > div:last-child a {
            height: 40px;
            width: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nilai-layout-grid {
            grid-template-columns: 1fr !important;
            gap: 16px;
        }

        .main-nilai-box {
            padding: 16px;
            border-radius: 16px;
        }

        .box-header-title {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 14px;
        }

        .box-header-title > div:last-child {
            flex-wrap: wrap;
            gap: 6px;
        }

        /* Show mobile cards, hide table */
        .desktop-table-wrapper {
            display: none !important;
        }

        .mobile-nilai-cards-wrapper {
            display: flex !important;
        }

        /* Modal Quick Fill */
        .modal-content-box {
            max-width: 100% !important;
            border-radius: 16px;
            margin: 0;
        }

        .modal-content-box > div:first-child {
            padding: 14px 16px !important;
        }

        .modal-content-box > div:last-child {
            padding: 16px 14px !important;
        }

        .modal-content-box > div:last-child > div:last-child {
            flex-direction: column-reverse;
            gap: 8px !important;
        }

        .modal-content-box > div:last-child > div:last-child > div {
            width: 100%;
            display: flex;
            gap: 8px;
        }

        .modal-content-box button {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .page-title-group h1 {
            font-size: 25px !important;
        }

        .stat-summary-grid {
            grid-template-columns: 1fr !important;
            gap: 10px;
        }

        .stat-metric-card {
            padding: 14px 16px;
        }

        .mobile-scores-grid {
            grid-template-columns: 1fr !important;
            gap: 8px;
        }
    }
</style>
@endsection

@section('content')

    <!-- Top Page Header -->
    <div class="page-header-container" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
        <div class="page-title-group">
            <h1 style="font-size: 23px; font-weight: 900; color: #0f172a; display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fa-solid fa-graduation-cap" style="color: #2563eb;"></i>
                Nilai Siswa
            </h1>
            <p style="font-size: 13px; color: #64748b; margin-top: 4px; margin-bottom: 0;">
                Kelas: <strong>{{ $selectedKelas->nama_kelas ?? '-' }}</strong> • Mapel: <strong>{{ $selectedMapel->nama_mapel ?? '-' }}</strong> • Standar KKM: <strong>{{ $kkm }}</strong>
            </p>
        </div>

        <!-- Header Actions -->
        <div class="page-header-actions" style="display: flex; align-items: center; gap: 9px; flex-wrap: wrap;">
            <!-- Tombol Quick Fill -->
            <button type="button" onclick="openQuickFillModal()" class="btn-action-secondary">
                <i class="fa-solid fa-wand-magic-sparkles" style="color: #6366f1;"></i> Isi Cepat
            </button>

            <!-- Export CSV -->
            <a href="{{ route('guru.nilai-rapor.export', ['id_kelas' => $selectedKelasId, 'id_mapel' => $selectedMapelId, 'semester' => $semester, 'tahun_ajaran' => $tahunAjaran, 'kkm' => $kkm]) }}" class="btn-action-secondary">
                <i class="fa-solid fa-file-csv" style="color: #10b981;"></i> Export CSV
            </a>

            <!-- Cetak Ledger -->
            <a href="{{ route('guru.nilai-rapor.print', ['id_kelas' => $selectedKelasId, 'id_mapel' => $selectedMapelId, 'semester' => $semester, 'tahun_ajaran' => $tahunAjaran, 'kkm' => $kkm]) }}" target="_blank" class="btn-action-secondary">
                <i class="fa-solid fa-print" style="color: #0284c7;"></i> Cetak Ledger
            </a>

            <!-- Simpan Nilai Primary Button -->
            <button type="button" onclick="submitNilaiForm()" class="btn-action-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Nilai
            </button>
        </div>
    </div>

    <!-- Top Summary Stat Grid -->
    <div class="stat-summary-grid">
        <!-- Rata-rata Kelas -->
        <div class="stat-metric-card">
            <div class="stat-metric-header">
                <span class="stat-metric-label">Rata-rata Kelas</span>
                <div class="stat-metric-icon" style="background: #eff6ff; color: #2563eb;">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <div class="stat-metric-value" id="cardAvgScore">{{ $ringkasanRapor['rata_rata'] ?? '0' }}</div>
            <div class="stat-metric-subtext">
                <span style="color: {{ ($ringkasanRapor['rata_rata'] ?? 0) >= $kkm ? '#16a34a' : '#dc2626' }}; font-weight: 700;">
                    {{ ($ringkasanRapor['rata_rata'] ?? 0) >= $kkm ? 'Di atas Standar' : 'Di bawah Standar' }}
                </span> (KKM {{ $kkm }})
            </div>
        </div>

        <!-- Siswa Tuntas -->
        <div class="stat-metric-card">
            <div class="stat-metric-header">
                <span class="stat-metric-label">Siswa Tuntas</span>
                <div class="stat-metric-icon" style="background: #ecfdf5; color: #10b981;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="stat-metric-value" style="color: #065f46;" id="cardTuntasCount">{{ $ringkasanRapor['di_atas_kkm'] ?? '0' }} <span style="font-size: 14px; font-weight: 700; color: #64748b;">Siswa</span></div>
            <div class="stat-metric-subtext">
                <span class="badge-status-tuntas" style="padding: 2px 7px; font-size: 10.5px;" id="cardTuntasPct">{{ $ringkasanRapor['persen_tuntas'] ?? '0' }}% Tuntas</span>
            </div>
        </div>

        <!-- Siswa Belum Tuntas -->
        <div class="stat-metric-card">
            <div class="stat-metric-header">
                <span class="stat-metric-label">Belum Tuntas</span>
                <div class="stat-metric-icon" style="background: #fef2f2; color: #ef4444;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
            <div class="stat-metric-value" style="color: #991b1b;" id="cardBelumCount">{{ $ringkasanRapor['di_bawah_kkm'] ?? '0' }} <span style="font-size: 14px; font-weight: 700; color: #64748b;">Siswa</span></div>
            <div class="stat-metric-subtext">
                Nilai akhir di bawah {{ $kkm }}
            </div>
        </div>

        <!-- Progres Input Nilai -->
        <div class="stat-metric-card">
            <div class="stat-metric-header">
                <span class="stat-metric-label">Progres Input</span>
                <div class="stat-metric-icon" style="background: #f8fafc; color: #64748b;">
                    <i class="fa-solid fa-list-check"></i>
                </div>
            </div>
            <div class="stat-metric-value" id="cardInputProgress">{{ $ringkasanRapor['sudah_dinilai'] ?? 0 }} <span style="font-size: 14px; font-weight: 700; color: #64748b;">/ {{ $ringkasanRapor['total_siswa'] ?? 0 }}</span></div>
            <div class="stat-metric-subtext">
                <span>{{ $ringkasanRapor['belum_dinilai'] ?? 0 }} Siswa Belum Diisi</span>
            </div>
        </div>

        <!-- Rentang Nilai Tertinggi & Terendah -->
        <div class="stat-metric-card">
            <div class="stat-metric-header">
                <span class="stat-metric-label">Rentang Nilai</span>
                <div class="stat-metric-icon" style="background: #fdf4ff; color: #a855f7;">
                    <i class="fa-solid fa-arrows-up-down"></i>
                </div>
            </div>
            <div class="stat-metric-value" style="font-size: 19px;">
                <span style="color: #15803d;" id="cardMaxScore">{{ $ringkasanRapor['nilai_tertinggi'] ?? 0 }}</span> <span style="font-size: 13px; color: #94a3b8;">/</span> <span style="color: #b91c1c;" id="cardMinScore">{{ $ringkasanRapor['nilai_terendah'] ?? 0 }}</span>
            </div>
            <div class="stat-metric-subtext">
                Tertinggi & Terendah Kelas
            </div>
        </div>
    </div>

    <!-- Filter & Search Panel -->
    <div class="filter-card-container">
        <form method="GET" action="{{ route('guru.nilai-rapor') }}" id="filterForm">
            <div class="filter-row">
                <!-- Dropdown Kelas -->
                <div class="filter-group" style="min-width: 150px; flex: 1.1;">
                    <label><i class="fa-solid fa-chalkboard-user"></i> Pilih Kelas</label>
                    <select name="id_kelas" class="form-select-custom" onchange="document.getElementById('filterForm').submit()">
                        @foreach($kelases as $k)
                            <option value="{{ $k->id_kelas }}" {{ $selectedKelasId == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Mapel -->
                <div class="filter-group" style="min-width: 180px; flex: 1.3;">
                    <label><i class="fa-solid fa-book-open"></i> Mata Pelajaran</label>
                    <select name="id_mapel" class="form-select-custom" onchange="document.getElementById('filterForm').submit()">
                        @foreach($mapels as $m)
                            <option value="{{ $m->id_mapel }}" {{ $selectedMapelId == $m->id_mapel ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Semester -->
                <div class="filter-group" style="min-width: 160px; flex: 1;">
                    <label><i class="fa-solid fa-calendar-check"></i> Semester</label>
                    <select name="semester" class="form-select-custom" onchange="document.getElementById('filterForm').submit()">
                        <option value="1" {{ $semester == '1' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                        <option value="2" {{ $semester == '2' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                    </select>
                </div>

                <!-- Tahun Ajaran -->
                <div class="filter-group" style="min-width: 140px; flex: 0.9;">
                    <label><i class="fa-solid fa-calendar"></i> Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="form-select-custom" onchange="document.getElementById('filterForm').submit()">
                        <option value="2026/2027" {{ $tahunAjaran == '2026/2027' ? 'selected' : '' }}>2026/2027</option>
                        <option value="2025/2026" {{ $tahunAjaran == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                        <option value="2024/2025" {{ $tahunAjaran == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                    </select>
                </div>

                <!-- KKM Standar -->
                <div class="filter-group" style="min-width: 85px; flex: 0.5;">
                    <label><i class="fa-solid fa-award"></i> KKM</label>
                    <input type="number" name="kkm" id="kkmInput" value="{{ $kkm }}" class="form-input-custom" min="1" max="100" onchange="updateAllCalculations()">
                </div>

                <!-- Cari Siswa -->
                <div class="filter-group" style="min-width: 170px; flex: 1.2;">
                    <label><i class="fa-solid fa-magnifying-glass"></i> Cari Siswa</label>
                    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Nama / NIS / NISN..." class="form-input-custom">
                </div>

                <!-- Status Filter -->
                <div class="filter-group" style="min-width: 135px; flex: 0.9;">
                    <label><i class="fa-solid fa-filter"></i> Status</label>
                    <select name="status" class="form-select-custom" onchange="document.getElementById('filterForm').submit()">
                        <option value="semua" {{ ($filterStatus ?? 'semua') == 'semua' ? 'selected' : '' }}>Semua Siswa</option>
                        <option value="tuntas" {{ ($filterStatus ?? '') == 'tuntas' ? 'selected' : '' }}>Tuntas (≥ KKM)</option>
                        <option value="belum_tuntas" {{ ($filterStatus ?? '') == 'belum_tuntas' ? 'selected' : '' }}>Belum Tuntas (< KKM)</option>
                    </select>
                </div>

                <!-- Action Filter Buttons -->
                <div style="display: flex; gap: 8px; align-items: flex-end; padding-top: 20px;">
                    <button type="submit" class="btn-action-primary" style="padding: 9px 15px; font-size: 12.5px;">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>
                    <a href="{{ route('guru.nilai-rapor', ['id_kelas' => $selectedKelasId, 'id_mapel' => $selectedMapelId]) }}" class="btn-action-secondary" style="padding: 9px 13px;" title="Reset Filter">
                        <i class="fa-solid fa-arrow-rotate-left"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Main Content Layout Grid -->
    <div class="nilai-layout-grid">
        
        <!-- Left: Main Table Box -->
        <div class="main-nilai-box">
            <div class="box-header-title">
                <div>
                    <h2>
                        <i class="fa-solid fa-table-list" style="color: #2563eb;"></i>
                        Daftar Nilai Peserta Didik
                    </h2>
                    <span style="font-size: 12px; color: #64748b;">
                        Menampilkan <strong>{{ count($siswas) }}</strong> siswa terdaftar di {{ $selectedKelas->nama_kelas ?? 'Kelas' }}
                    </span>
                </div>

                <div style="display: flex; align-items: center; gap: 8px; font-size: 11.5px; color: #64748b;">
                    <span style="display: inline-block; width: 9px; height: 9px; background: #22c55e; border-radius: 50%;"></span> ≥ 85 (Sangat Baik)
                    <span style="display: inline-block; width: 9px; height: 9px; background: #3b82f6; border-radius: 50%; margin-left: 6px;"></span> 75-84 (Baik)
                    <span style="display: inline-block; width: 9px; height: 9px; background: #ef4444; border-radius: 50%; margin-left: 6px;"></span> &lt; 70 (Remidial)
                </div>
            </div>

            <!-- Form Nilai Utama -->
            <form id="formNilai" method="POST" action="{{ route('guru.nilai-rapor.store') }}">
                @csrf
                <input type="hidden" name="id_kelas" value="{{ $selectedKelasId }}">
                <input type="hidden" name="id_mapel" value="{{ $selectedMapelId }}">
                <input type="hidden" name="semester" value="{{ $semester }}">
                <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">
                <input type="hidden" name="kkm" id="hiddenKkm" value="{{ $kkm }}">

                <!-- Desktop Table View (>= 769px) -->
                <div class="desktop-table-wrapper" style="overflow-x: auto;">
                    <table class="table-nilai-custom" id="tableNilai">
                        <thead>
                            <tr>
                                <th style="width: 35px;">NO</th>
                                <th style="text-align: left; min-width: 190px;">INFORMASI SISWA</th>
                                <th style="width: 70px;" title="Bobot 20%">TUGAS<br><span style="font-size: 9.5px; color: #94a3b8;">(20%)</span></th>
                                <th style="width: 70px;" title="Bobot 20%">UH / FORM.<br><span style="font-size: 9.5px; color: #94a3b8;">(20%)</span></th>
                                <th style="width: 70px;" title="Bobot 30%">UTS<br><span style="font-size: 9.5px; color: #94a3b8;">(30%)</span></th>
                                <th style="width: 70px;" title="Bobot 30%">UAS / PAS<br><span style="font-size: 9.5px; color: #94a3b8;">(30%)</span></th>
                                <th style="width: 75px;" title="Kalkulasi Otomatis">NILAI AKHIR<br><span style="font-size: 9.5px; color: #2563eb;">(100%)</span></th>
                                <th style="width: 40px;">PRED.</th>
                                <th style="width: 90px;">STATUS</th>
                                <th style="min-width: 130px; text-align: left;">CATATAN GURU</th>
                                <th style="width: 45px;" title="Reset Nilai Baris Ini">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $idx => $s)
                                @php
                                    $nameArr = explode(' ', trim($s->nama_siswa));
                                    $initials = strtoupper(substr($nameArr[0] ?? 'S', 0, 1) . substr($nameArr[1] ?? '', 0, 1));
                                    $val = $existingNilai->get($s->id_siswa);

                                    $tugas = ($val && $val->nilai_tugas > 0) ? (floatval($val->nilai_tugas) == intval($val->nilai_tugas) ? intval($val->nilai_tugas) : floatval($val->nilai_tugas)) : '';
                                    $uh    = ($val && $val->nilai_harian > 0) ? (floatval($val->nilai_harian) == intval($val->nilai_harian) ? intval($val->nilai_harian) : floatval($val->nilai_harian)) : '';
                                    $uts   = ($val && $val->nilai_uts > 0) ? (floatval($val->nilai_uts) == intval($val->nilai_uts) ? intval($val->nilai_uts) : floatval($val->nilai_uts)) : '';
                                    $uas   = ($val && $val->nilai_uas > 0) ? (floatval($val->nilai_uas) == intval($val->nilai_uas) ? intval($val->nilai_uas) : floatval($val->nilai_uas)) : '';
                                    $catatan = $val ? $val->catatan : '';

                                    $hasVal = ($tugas !== '' || $uh !== '' || $uts !== '' || $uas !== '');
                                    $nAkhir = $hasVal ? round((floatval($tugas)*0.2) + (floatval($uh)*0.2) + (floatval($uts)*0.3) + (floatval($uas)*0.3), 1) : 0;

                                    $predikat = 'D';
                                    if ($nAkhir >= 88) $predikat = 'A';
                                    elseif ($nAkhir >= 78) $predikat = 'B';
                                    elseif ($nAkhir >= 68) $predikat = 'C';
                                @endphp
                                <tr class="student-row" data-siswa-id="{{ $s->id_siswa }}" data-nama="{{ $s->nama_siswa }}" data-nis="{{ $s->nis ?? '-' }}">
                                    <td style="text-align: center; color: #94a3b8; font-weight: 700;">{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="student-cell">
                                            <div class="avatar-initial">{{ $initials }}</div>
                                            <div>
                                                <div class="student-name">{{ $s->nama_siswa }}</div>
                                                <div class="student-subinfo">NIS: {{ $s->nis ?? '-' }} • NISN: {{ $s->nisn ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Nilai Tugas -->
                                    <td style="text-align: center;">
                                        <input type="number" step="0.1" min="0" max="100" 
                                               name="nilai[{{ $s->id_siswa }}][tugas]" 
                                               value="{{ $tugas !== '' ? $tugas : '' }}" 
                                               class="input-score-control score-input score-tugas desktop-input-score" 
                                               placeholder="-"
                                               data-siswa-id="{{ $s->id_siswa }}"
                                               data-field="tugas"
                                               oninput="handleScoreInput(this, false)">
                                    </td>

                                    <!-- Nilai UH / Formatif -->
                                    <td style="text-align: center;">
                                        <input type="number" step="0.1" min="0" max="100" 
                                               name="nilai[{{ $s->id_siswa }}][harian]" 
                                               value="{{ $uh !== '' ? $uh : '' }}" 
                                               class="input-score-control score-input score-uh desktop-input-score" 
                                               placeholder="-"
                                               data-siswa-id="{{ $s->id_siswa }}"
                                               data-field="harian"
                                               oninput="handleScoreInput(this, false)">
                                    </td>

                                    <!-- Nilai UTS -->
                                    <td style="text-align: center;">
                                        <input type="number" step="0.1" min="0" max="100" 
                                               name="nilai[{{ $s->id_siswa }}][uts]" 
                                               value="{{ $uts !== '' ? $uts : '' }}" 
                                               class="input-score-control score-input score-uts desktop-input-score" 
                                               placeholder="-"
                                               data-siswa-id="{{ $s->id_siswa }}"
                                               data-field="uts"
                                               oninput="handleScoreInput(this, false)">
                                    </td>

                                    <!-- Nilai UAS -->
                                    <td style="text-align: center;">
                                        <input type="number" step="0.1" min="0" max="100" 
                                               name="nilai[{{ $s->id_siswa }}][uas]" 
                                               value="{{ $uas !== '' ? $uas : '' }}" 
                                               class="input-score-control score-input score-uas desktop-input-score" 
                                               placeholder="-"
                                               data-siswa-id="{{ $s->id_siswa }}"
                                               data-field="uas"
                                               oninput="handleScoreInput(this, false)">
                                    </td>

                                    <!-- Nilai Akhir Live Display -->
                                    <td style="text-align: center;">
                                        <span class="cell-score-na" style="font-size: 14.5px; font-weight: 900; color: #0f172a;">
                                            {{ $hasVal && $nAkhir > 0 ? $nAkhir : '-' }}
                                        </span>
                                    </td>

                                    <!-- Predikat Live Display -->
                                    <td style="text-align: center;">
                                        @if($hasVal && $nAkhir > 0)
                                            <span class="badge-predikat predikat-{{ $predikat }} cell-predikat">{{ $predikat }}</span>
                                        @else
                                            <span class="badge-predikat cell-predikat" style="background: #f1f5f9; color: #94a3b8;">-</span>
                                        @endif
                                    </td>

                                    <!-- Status Ketuntasan Live Display -->
                                    <td style="text-align: center;">
                                        @if($hasVal && $nAkhir > 0)
                                            @if($nAkhir >= $kkm)
                                                <span class="badge-status-tuntas cell-status"><i class="fa-solid fa-circle-check"></i> Tuntas</span>
                                            @else
                                                <span class="badge-status-belum cell-status"><i class="fa-solid fa-circle-xmark"></i> Remidi</span>
                                            @endif
                                        @else
                                            <span class="badge-status-empty cell-status">Belum Diisi</span>
                                        @endif
                                    </td>

                                    <!-- Catatan Guru -->
                                    <td>
                                        <input type="text" name="nilai[{{ $s->id_siswa }}][catatan]" 
                                               value="{{ $catatan }}" 
                                               placeholder="Catatan perkembangan..." 
                                               class="form-input-custom desktop-input-catatan" 
                                               data-siswa-id="{{ $s->id_siswa }}"
                                               data-field="catatan"
                                               style="height: 34px; font-size: 12px; padding: 0 9px;"
                                               oninput="handleScoreInput(this, false)">
                                    </td>

                                    <!-- Aksi: Fitur Reset Nilai Baris Ini -->
                                    <td style="text-align: center;">
                                        <button type="button" onclick="resetRowScore(this)" class="btn-reset-row" title="Reset Nilai Siswa Ini">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" style="text-align: center; color: #94a3b8; padding: 36px;">
                                        <i class="fa-solid fa-user-slash" style="font-size: 30px; margin-bottom: 8px; color: #cbd5e1; display: block;"></i>
                                        Tidak ada data siswa ditemukan untuk kelas ini atau kriteria pencarian yang diberikan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards View (<= 768px) -->
                <div class="mobile-nilai-cards-wrapper">
                    @forelse($siswas as $idx => $s)
                        @php
                            $nameArr = explode(' ', trim($s->nama_siswa));
                            $initials = strtoupper(substr($nameArr[0] ?? 'S', 0, 1) . substr($nameArr[1] ?? '', 0, 1));
                            $val = $existingNilai->get($s->id_siswa);

                            $tugas = ($val && $val->nilai_tugas > 0) ? (floatval($val->nilai_tugas) == intval($val->nilai_tugas) ? intval($val->nilai_tugas) : floatval($val->nilai_tugas)) : '';
                            $uh    = ($val && $val->nilai_harian > 0) ? (floatval($val->nilai_harian) == intval($val->nilai_harian) ? intval($val->nilai_harian) : floatval($val->nilai_harian)) : '';
                            $uts   = ($val && $val->nilai_uts > 0) ? (floatval($val->nilai_uts) == intval($val->nilai_uts) ? intval($val->nilai_uts) : floatval($val->nilai_uts)) : '';
                            $uas   = ($val && $val->nilai_uas > 0) ? (floatval($val->nilai_uas) == intval($val->nilai_uas) ? intval($val->nilai_uas) : floatval($val->nilai_uas)) : '';
                            $catatan = $val ? $val->catatan : '';

                            $hasVal = ($tugas !== '' || $uh !== '' || $uts !== '' || $uas !== '');
                            $nAkhir = $hasVal ? round((floatval($tugas)*0.2) + (floatval($uh)*0.2) + (floatval($uts)*0.3) + (floatval($uas)*0.3), 1) : 0;

                            $predikat = 'D';
                            if ($nAkhir >= 88) $predikat = 'A';
                            elseif ($nAkhir >= 78) $predikat = 'B';
                            elseif ($nAkhir >= 68) $predikat = 'C';
                        @endphp
                        <div class="mobile-student-card student-row" id="mobile-card-{{ $s->id_siswa }}" data-siswa-id="{{ $s->id_siswa }}" data-nama="{{ $s->nama_siswa }}" data-nis="{{ $s->nis ?? '-' }}">
                            <!-- Header: No, Avatar, Name, NISN & Reset -->
                            <div class="mobile-card-header">
                                <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                                    <span style="font-size: 13px; font-weight: 800; color: #94a3b8; min-width: 20px;">#{{ $idx + 1 }}</span>
                                    <div class="avatar-initial">{{ $initials }}</div>
                                    <div style="min-width: 0;">
                                        <div class="student-name" style="word-break: break-word;">{{ $s->nama_siswa }}</div>
                                        <div class="student-subinfo">NIS: {{ $s->nis ?? '-' }} • NISN: {{ $s->nisn ?? '-' }}</div>
                                    </div>
                                </div>
                                <button type="button" onclick="resetStudentScoreById({{ $s->id_siswa }})" class="btn-reset-row" title="Reset Nilai Siswa Ini">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </button>
                            </div>

                            <!-- Live Result Banner -->
                            <div class="mobile-result-banner">
                                <div class="mobile-result-item">
                                    <span class="mobile-result-label">NILAI AKHIR</span>
                                    <span class="cell-score-na" style="font-size: 17px; font-weight: 900; color: #0f172a;">
                                        {{ $hasVal && $nAkhir > 0 ? $nAkhir : '-' }}
                                    </span>
                                </div>
                                <div class="mobile-result-item">
                                    <span class="mobile-result-label">PREDIKAT</span>
                                    @if($hasVal && $nAkhir > 0)
                                        <span class="badge-predikat predikat-{{ $predikat }} cell-predikat">{{ $predikat }}</span>
                                    @else
                                        <span class="badge-predikat cell-predikat" style="background: #f1f5f9; color: #94a3b8;">-</span>
                                    @endif
                                </div>
                                <div class="mobile-result-item" style="flex: 1.2;">
                                    <span class="mobile-result-label">STATUS</span>
                                    @if($hasVal && $nAkhir > 0)
                                        @if($nAkhir >= $kkm)
                                            <span class="badge-status-tuntas cell-status"><i class="fa-solid fa-circle-check"></i> Tuntas</span>
                                        @else
                                            <span class="badge-status-belum cell-status"><i class="fa-solid fa-circle-xmark"></i> Remidi</span>
                                        @endif
                                    @else
                                        <span class="badge-status-empty cell-status">Belum Diisi</span>
                                    @endif
                                </div>
                            </div>

                            <!-- 4 Score Inputs Grid -->
                            <div class="mobile-scores-grid">
                                <div class="mobile-score-box">
                                    <label>Tugas (20%)</label>
                                    <input type="number" step="0.1" min="0" max="100" 
                                           name="nilai[{{ $s->id_siswa }}][tugas]" 
                                           value="{{ $tugas !== '' ? $tugas : '' }}" 
                                           class="form-input-custom input-score-control score-input score-tugas mobile-input-score" 
                                           placeholder="-"
                                           data-siswa-id="{{ $s->id_siswa }}"
                                           data-field="tugas"
                                           oninput="handleScoreInput(this, true)">
                                </div>
                                <div class="mobile-score-box">
                                    <label>UH / Form. (20%)</label>
                                    <input type="number" step="0.1" min="0" max="100" 
                                           name="nilai[{{ $s->id_siswa }}][harian]" 
                                           value="{{ $uh !== '' ? $uh : '' }}" 
                                           class="form-input-custom input-score-control score-input score-uh mobile-input-score" 
                                           placeholder="-"
                                           data-siswa-id="{{ $s->id_siswa }}"
                                           data-field="harian"
                                           oninput="handleScoreInput(this, true)">
                                </div>
                                <div class="mobile-score-box">
                                    <label>UTS (30%)</label>
                                    <input type="number" step="0.1" min="0" max="100" 
                                           name="nilai[{{ $s->id_siswa }}][uts]" 
                                           value="{{ $uts !== '' ? $uts : '' }}" 
                                           class="form-input-custom input-score-control score-input score-uts mobile-input-score" 
                                           placeholder="-"
                                           data-siswa-id="{{ $s->id_siswa }}"
                                           data-field="uts"
                                           oninput="handleScoreInput(this, true)">
                                </div>
                                <div class="mobile-score-box">
                                    <label>UAS / PAS (30%)</label>
                                    <input type="number" step="0.1" min="0" max="100" 
                                           name="nilai[{{ $s->id_siswa }}][uas]" 
                                           value="{{ $uas !== '' ? $uas : '' }}" 
                                           class="form-input-custom input-score-control score-input score-uas mobile-input-score" 
                                           placeholder="-"
                                           data-siswa-id="{{ $s->id_siswa }}"
                                           data-field="uas"
                                           oninput="handleScoreInput(this, true)">
                                </div>
                            </div>

                            <!-- Catatan Guru -->
                            <div style="margin-top: 4px;">
                                <label style="font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 4px; display: block;">Catatan Guru (Opsional):</label>
                                <input type="text" name="nilai[{{ $s->id_siswa }}][catatan]" 
                                       value="{{ $catatan }}" 
                                       placeholder="Catatan perkembangan siswa..." 
                                       class="form-input-custom mobile-input-catatan" 
                                       data-siswa-id="{{ $s->id_siswa }}"
                                       data-field="catatan"
                                       style="height: 38px; font-size: 12.5px; padding: 0 10px;"
                                       oninput="handleScoreInput(this, true)">
                            </div>
                        </div>
                    @empty
                        <div style="background: #ffffff; border-radius: 16px; border: 1px dashed #cbd5e1; padding: 36px 16px; text-align: center;">
                            <i class="fa-solid fa-user-slash" style="font-size: 30px; margin-bottom: 8px; color: #cbd5e1; display: block;"></i>
                            <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0 0 4px;">Tidak Ada Data Siswa</h3>
                            <p style="font-size: 12.5px; color: #64748b; margin: 0;">Tidak ada data siswa ditemukan untuk kelas ini atau kriteria pencarian yang diberikan.</p>
                        </div>
                    @endforelse
                </div>
            </form>
        </div>

        <!-- Right Side Widgets & Information -->
        <div>
            <!-- Komposisi Penilaian Box -->
            <div class="widget-card">
                <div class="widget-title">
                    <i class="fa-solid fa-chart-pie" style="color: #2563eb;"></i>
                    Komposisi Bobot Penilaian
                </div>
                <div>
                    <div style="margin-bottom: 11px;">
                        <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                            <span>Tugas Terstruktur</span>
                            <span>20%</span>
                        </div>
                        <div style="height: 6px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                            <div style="width: 20%; height: 100%; background: #3b82f6;"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 11px;">
                        <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                            <span>Ulangan Harian (Formatif)</span>
                            <span>20%</span>
                        </div>
                        <div style="height: 6px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                            <div style="width: 20%; height: 100%; background: #06b6d4;"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 11px;">
                        <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                            <span>Penilaian Tengah Semester (UTS)</span>
                            <span>30%</span>
                        </div>
                        <div style="height: 6px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                            <div style="width: 30%; height: 100%; background: #8b5cf6;"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 11px;">
                        <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                            <span>Penilaian Akhir Semester (UAS/PAS)</span>
                            <span>30%</span>
                        </div>
                        <div style="height: 6px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                            <div style="width: 30%; height: 100%; background: #f59e0b;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skala & Distribusi Predikat -->
            <div class="widget-card">
                <div class="widget-title">
                    <i class="fa-solid fa-ribbon" style="color: #f59e0b;"></i>
                    Distribusi Predikat Kelas
                </div>
                <div>
                    <div class="rapor-row green-bg">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="badge-predikat predikat-A" style="width: 24px; height: 24px; font-size: 11px;">A</span>
                            <span style="color: #166534;">Sangat Baik (88 - 100)</span>
                        </div>
                        <span style="font-size: 13px; font-weight: 800; color: #166534;" id="distA">{{ $ringkasanRapor['distribusi_predikat']['A'] ?? 0 }} Siswa</span>
                    </div>

                    <div class="rapor-row blue-bg">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="badge-predikat predikat-B" style="width: 24px; height: 24px; font-size: 11px;">B</span>
                            <span style="color: #1e40af;">Baik (78 - 87)</span>
                        </div>
                        <span style="font-size: 13px; font-weight: 800; color: #1e40af;" id="distB">{{ $ringkasanRapor['distribusi_predikat']['B'] ?? 0 }} Siswa</span>
                    </div>

                    <div class="rapor-row" style="background: #fefce8; border-color: #fef08a;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="badge-predikat predikat-C" style="width: 24px; height: 24px; font-size: 11px;">C</span>
                            <span style="color: #854d0e;">Cukup (68 - 77)</span>
                        </div>
                        <span style="font-size: 13px; font-weight: 800; color: #854d0e;" id="distC">{{ $ringkasanRapor['distribusi_predikat']['C'] ?? 0 }} Siswa</span>
                    </div>

                    <div class="rapor-row red-bg">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="badge-predikat predikat-D" style="width: 24px; height: 24px; font-size: 11px;">D</span>
                            <span style="color: #991b1b;">Perlu Bimbingan (&lt; 68)</span>
                        </div>
                        <span style="font-size: 13px; font-weight: 800; color: #991b1b;" id="distD">{{ $ringkasanRapor['distribusi_predikat']['D'] ?? 0 }} Siswa</span>
                    </div>
                </div>
            </div>

            <!-- Panduan Pengisian Card -->
            <div class="widget-card" style="background: #fafafa;">
                <div class="widget-title" style="font-size: 13px; color: #475569;">
                    <i class="fa-solid fa-circle-info" style="color: #0284c7;"></i>
                    Petunjuk Pengisian & Aksi
                </div>
                <ul style="margin: 0; padding-left: 16px; font-size: 11.5px; color: #64748b; line-height: 1.6;">
                    <li>Nilai diinput dalam skala <strong>0 - 100</strong>.</li>
                    <li>Nilai Akhir dan Predikat terhitung otomatis secara <em>real-time</em>.</li>
                    <li>Gunakan tombol <i class="fa-solid fa-rotate-left" style="color: #dc2626;"></i> pada kolom <strong>AKSI</strong> untuk mengosongkan/mereset nilai siswa tertentu.</li>
                    <li>Klik <strong>Simpan Nilai</strong> di bagian atas setelah selesai mengisi.</li>
                </ul>
            </div>
        </div>

    </div>

    <!-- MODAL: Quick Fill / Isi Cepat & Reset Masal -->
    <div id="quickFillModal" class="modal-overlay">
        <div class="modal-content-box">
            <div style="padding: 18px 22px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                <div style="font-size: 15px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-wand-magic-sparkles" style="color: #6366f1;"></i>
                    Isi Cepat & Pengaturan Nilai
                </div>
                <button type="button" onclick="closeQuickFillModal()" style="background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer;">&times;</button>
            </div>
            <div style="padding: 22px;">
                <p style="font-size: 12.5px; color: #64748b; margin-top: 0; margin-bottom: 15px;">
                    Masukkan nilai standar untuk diterapkan ke siswa, atau kosongkan seluruh tabel penilaian.
                </p>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 16px;">
                    <div>
                        <label style="font-size: 11.5px; font-weight: 700; color: #475569;">Nilai Tugas Standar</label>
                        <input type="number" id="qfTugas" class="form-input-custom" value="85" min="0" max="100">
                    </div>
                    <div>
                        <label style="font-size: 11.5px; font-weight: 700; color: #475569;">Nilai UH Standar</label>
                        <input type="number" id="qfUh" class="form-input-custom" value="82" min="0" max="100">
                    </div>
                    <div>
                        <label style="font-size: 11.5px; font-weight: 700; color: #475569;">Nilai UTS Standar</label>
                        <input type="number" id="qfUts" class="form-input-custom" value="80" min="0" max="100">
                    </div>
                    <div>
                        <label style="font-size: 11.5px; font-weight: 700; color: #475569;">Nilai UAS Standar</label>
                        <input type="number" id="qfUas" class="form-input-custom" value="85" min="0" max="100">
                    </div>
                </div>

                <div style="margin-bottom: 18px; background: #f8fafc; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <label style="font-size: 11.5px; font-weight: 800; color: #475569; display: block; margin-bottom: 6px;">Target Pengisian</label>
                    <label style="font-size: 12.5px; color: #334155; display: flex; align-items: center; gap: 8px; margin-bottom: 6px; cursor: pointer;">
                        <input type="radio" name="qfTarget" value="empty_only" checked> Hanya untuk kolom nilai yang masih kosong
                    </label>
                    <label style="font-size: 12.5px; color: #334155; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="qfTarget" value="all"> Timpa seluruh siswa di kelas ini
                    </label>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                    <button type="button" onclick="resetAllScoresConfirm()" class="btn-action-secondary" style="color: #dc2626; border-color: #fca5a5; background: #fef2f2;">
                        <i class="fa-solid fa-trash-can"></i> Kosongkan Semua Nilai
                    </button>

                    <div style="display: flex; gap: 8px;">
                        <button type="button" onclick="closeQuickFillModal()" class="btn-action-secondary">Batal</button>
                        <button type="button" onclick="applyQuickFill()" class="btn-action-primary" style="background: #6366f1;">
                            <i class="fa-solid fa-check"></i> Terapkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // Handle Score Input & Synchronize Between Desktop Table & Mobile Cards
    function handleScoreInput(inputEl, isMobile) {
        const siswaId = inputEl.dataset.siswaId;
        const field = inputEl.dataset.field;

        // Synchronize opposite input if exists
        const counterpartSelector = isMobile 
            ? `.desktop-table-wrapper [data-siswa-id="${siswaId}"][data-field="${field}"]`
            : `.mobile-nilai-cards-wrapper [data-siswa-id="${siswaId}"][data-field="${field}"]`;
        const counterpart = document.querySelector(counterpartSelector);
        if (counterpart && counterpart.value !== inputEl.value) {
            counterpart.value = inputEl.value;
            colorizeInput(counterpart);
        }

        colorizeInput(inputEl);
        calcStudentScore(siswaId);
    }

    // Live Calculation Function for Each Student (Updates Both Desktop & Mobile DOM)
    function calcStudentScore(siswaId) {
        const desktopRow = document.querySelector(`.desktop-table-wrapper .student-row[data-siswa-id="${siswaId}"]`);
        const mobileCard = document.querySelector(`.mobile-nilai-cards-wrapper .student-row[data-siswa-id="${siswaId}"]`);

        const tugasInput = document.querySelector(`[data-siswa-id="${siswaId}"][data-field="tugas"]`);
        const uhInput    = document.querySelector(`[data-siswa-id="${siswaId}"][data-field="harian"]`);
        const utsInput   = document.querySelector(`[data-siswa-id="${siswaId}"][data-field="uts"]`);
        const uasInput   = document.querySelector(`[data-siswa-id="${siswaId}"][data-field="uas"]`);

        if (!tugasInput) return;

        const tugas = parseFloat(tugasInput.value) || 0;
        const uh    = parseFloat(uhInput.value) || 0;
        const uts   = parseFloat(utsInput.value) || 0;
        const uas   = parseFloat(uasInput.value) || 0;

        const hasAnyValue = (tugasInput.value.trim() !== '' || uhInput.value.trim() !== '' || utsInput.value.trim() !== '' || uasInput.value.trim() !== '');
        const kkm = parseFloat(document.getElementById('kkmInput').value) || 75;

        const targets = [desktopRow, mobileCard].filter(Boolean);

        targets.forEach(target => {
            const cellNA = target.querySelector('.cell-score-na');
            const cellPred = target.querySelector('.cell-predikat');
            const cellStatus = target.querySelector('.cell-status');

            if (hasAnyValue) {
                // Formula: 20% Tugas + 20% UH + 30% UTS + 30% UAS
                const na = Math.round(((tugas * 0.2) + (uh * 0.2) + (uts * 0.3) + (uas * 0.3)) * 10) / 10;
                if (cellNA) cellNA.innerText = na.toFixed(1);

                let pred = 'D';
                if (na >= 88) pred = 'A';
                else if (na >= 78) pred = 'B';
                else if (na >= 68) pred = 'C';

                if (cellPred) {
                    cellPred.innerText = pred;
                    cellPred.className = 'badge-predikat predikat-' + pred + ' cell-predikat';
                    cellPred.style.background = '';
                    cellPred.style.color = '';
                }

                if (cellStatus) {
                    if (na >= kkm) {
                        cellStatus.innerHTML = '<i class="fa-solid fa-circle-check"></i> Tuntas';
                        cellStatus.className = 'badge-status-tuntas cell-status';
                    } else {
                        cellStatus.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Remidi';
                        cellStatus.className = 'badge-status-belum cell-status';
                    }
                }
            } else {
                if (cellNA) cellNA.innerText = '-';
                if (cellPred) {
                    cellPred.innerText = '-';
                    cellPred.className = 'badge-predikat cell-predikat';
                    cellPred.style.background = '#f1f5f9';
                    cellPred.style.color = '#94a3b8';
                }
                if (cellStatus) {
                    cellStatus.innerHTML = 'Belum Diisi';
                    cellStatus.className = 'badge-status-empty cell-status';
                }
            }
        });

        updateTopSummaryCards();
    }

    function colorizeInput(el) {
        if (!el) return;
        const val = parseFloat(el.value);
        el.classList.remove('score-high', 'score-medium', 'score-low');
        if (el.value.trim() === '' || isNaN(val)) return;

        if (val >= 85) el.classList.add('score-high');
        else if (val >= 70) el.classList.add('score-medium');
        else el.classList.add('score-low');
    }

    // Reset Specific Student Row / Card
    function resetStudentScoreById(siswaId) {
        ['tugas', 'harian', 'uts', 'uas', 'catatan'].forEach(field => {
            const inputs = document.querySelectorAll(`[data-siswa-id="${siswaId}"][data-field="${field}"]`);
            inputs.forEach(inp => {
                inp.value = '';
                colorizeInput(inp);
            });
        });

        calcStudentScore(siswaId);

        const card = document.getElementById('mobile-card-' + siswaId);
        if (card) {
            card.style.transition = 'background-color 0.3s ease';
            card.style.backgroundColor = '#fef2f2';
            setTimeout(() => { card.style.backgroundColor = ''; }, 400);
        }
        const row = document.querySelector(`.desktop-table-wrapper .student-row[data-siswa-id="${siswaId}"]`);
        if (row) {
            row.style.transition = 'background-color 0.3s ease';
            row.style.backgroundColor = '#fef2f2';
            setTimeout(() => { row.style.backgroundColor = ''; }, 400);
        }
    }

    function resetRowScore(btn) {
        const row = btn.closest('.student-row');
        if (!row) return;
        const siswaId = row.dataset.siswaId;
        resetStudentScoreById(siswaId);
    }

    function updateAllCalculations() {
        const kkm = document.getElementById('kkmInput').value;
        document.getElementById('hiddenKkm').value = kkm;
        const uniqueSiswaIds = Array.from(new Set(Array.from(document.querySelectorAll('.student-row')).map(r => r.dataset.siswaId)));
        uniqueSiswaIds.forEach(siswaId => {
            calcStudentScore(siswaId);
        });
    }

    function updateTopSummaryCards() {
        // Use desktop rows for calculating unique summary (since one row per student)
        const rows = document.querySelectorAll('.desktop-table-wrapper .student-row');
        const kkm = parseFloat(document.getElementById('kkmInput').value) || 75;
        let totalNA = 0;
        let countFilled = 0;
        let tuntasCount = 0;
        let maxScore = 0;
        let minScore = 100;
        let dist = { A: 0, B: 0, C: 0, D: 0 };

        rows.forEach(row => {
            const naText = row.querySelector('.cell-score-na').innerText.trim();
            const na = parseFloat(naText);
            if (!isNaN(na) && naText !== '-') {
                countFilled++;
                totalNA += na;
                if (na >= kkm) tuntasCount++;
                if (na > maxScore) maxScore = na;
                if (na < minScore) minScore = na;

                const predText = row.querySelector('.cell-predikat').innerText.trim();
                if (dist[predText] !== undefined) dist[predText]++;
            }
        });

        if (countFilled === 0) minScore = 0;

        const avg = countFilled > 0 ? (totalNA / countFilled).toFixed(1) : 0;
        const totalStudents = rows.length;
        const tuntasPct = totalStudents > 0 ? Math.round((tuntasCount / totalStudents) * 100) : 0;
        const belumCount = totalStudents - tuntasCount;

        // Update card DOM
        const avgEl = document.getElementById('cardAvgScore');
        if (avgEl) avgEl.innerText = avg;
        const tuntasEl = document.getElementById('cardTuntasCount');
        if (tuntasEl) tuntasEl.innerHTML = `${tuntasCount} <span style="font-size: 14px; font-weight: 700; color: #64748b;">Siswa</span>`;
        const pctEl = document.getElementById('cardTuntasPct');
        if (pctEl) pctEl.innerText = `${tuntasPct}% Tuntas`;
        const belumEl = document.getElementById('cardBelumCount');
        if (belumEl) belumEl.innerHTML = `${belumCount} <span style="font-size: 14px; font-weight: 700; color: #64748b;">Siswa</span>`;
        const progEl = document.getElementById('cardInputProgress');
        if (progEl) progEl.innerHTML = `${countFilled} <span style="font-size: 14px; font-weight: 700; color: #64748b;">/ ${totalStudents}</span>`;
        const maxEl = document.getElementById('cardMaxScore');
        if (maxEl) maxEl.innerText = maxScore;
        const minEl = document.getElementById('cardMinScore');
        if (minEl) minEl.innerText = minScore;

        const distA = document.getElementById('distA');
        if (distA) distA.innerText = `${dist.A} Siswa`;
        const distB = document.getElementById('distB');
        if (distB) distB.innerText = `${dist.B} Siswa`;
        const distC = document.getElementById('distC');
        if (distC) distC.innerText = `${dist.C} Siswa`;
        const distD = document.getElementById('distD');
        if (distD) distD.innerText = `${dist.D} Siswa`;
    }

    // Submit handler - disables inactive viewport inputs to guarantee clean payload
    function submitNilaiForm() {
        const isMobile = window.innerWidth <= 768;
        if (isMobile) {
            document.querySelectorAll('.desktop-table-wrapper input').forEach(i => i.disabled = true);
            document.querySelectorAll('.mobile-nilai-cards-wrapper input').forEach(i => i.disabled = false);
        } else {
            document.querySelectorAll('.mobile-nilai-cards-wrapper input').forEach(i => i.disabled = true);
            document.querySelectorAll('.desktop-table-wrapper input').forEach(i => i.disabled = false);
        }
        const form = document.getElementById('formNilai');
        form.submit();
    }

    // Quick Fill Modal logic
    function openQuickFillModal() {
        document.getElementById('quickFillModal').style.display = 'flex';
    }
    function closeQuickFillModal() {
        document.getElementById('quickFillModal').style.display = 'none';
    }

    function applyQuickFill() {
        const qfTugas = parseFloat(document.getElementById('qfTugas').value) || 85;
        const qfUh    = parseFloat(document.getElementById('qfUh').value) || 82;
        const qfUts   = parseFloat(document.getElementById('qfUts').value) || 80;
        const qfUas   = parseFloat(document.getElementById('qfUas').value) || 85;
        const targetMode = document.querySelector('input[name="qfTarget"]:checked').value;

        const uniqueSiswaIds = Array.from(new Set(Array.from(document.querySelectorAll('.student-row')).map(r => r.dataset.siswaId)));

        uniqueSiswaIds.forEach(siswaId => {
            const inTugas = document.querySelectorAll(`[data-siswa-id="${siswaId}"][data-field="tugas"]`);
            const inUh    = document.querySelectorAll(`[data-siswa-id="${siswaId}"][data-field="harian"]`);
            const inUts   = document.querySelectorAll(`[data-siswa-id="${siswaId}"][data-field="uts"]`);
            const inUas   = document.querySelectorAll(`[data-siswa-id="${siswaId}"][data-field="uas"]`);

            const currentTugasVal = inTugas[0] ? inTugas[0].value.trim() : '';

            if (targetMode === 'all') {
                inTugas.forEach(i => { i.value = qfTugas; colorizeInput(i); });
                inUh.forEach(i => { i.value = qfUh; colorizeInput(i); });
                inUts.forEach(i => { i.value = qfUts; colorizeInput(i); });
                inUas.forEach(i => { i.value = qfUas; colorizeInput(i); });
                calcStudentScore(siswaId);
            } else if (targetMode === 'empty_only') {
                if (currentTugasVal === '') {
                    inTugas.forEach(i => { i.value = qfTugas; colorizeInput(i); });
                    inUh.forEach(i => { i.value = qfUh; colorizeInput(i); });
                    inUts.forEach(i => { i.value = qfUts; colorizeInput(i); });
                    inUas.forEach(i => { i.value = qfUas; colorizeInput(i); });
                    calcStudentScore(siswaId);
                }
            }
        });

        closeQuickFillModal();
    }

    function resetAllScoresConfirm() {
        if (confirm('Apakah Anda yakin ingin mengosongkan seluruh nilai pada tabel ini?')) {
            const uniqueSiswaIds = Array.from(new Set(Array.from(document.querySelectorAll('.student-row')).map(r => r.dataset.siswaId)));
            uniqueSiswaIds.forEach(siswaId => {
                resetStudentScoreById(siswaId);
            });
            closeQuickFillModal();
        }
    }

    // Initialize styling on page load
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.score-input').forEach(input => {
            colorizeInput(input);
        });
    });
</script>
@endsection