@extends('layouts.guru')

<<<<<<< HEAD
@section('title', 'Jurnal Mengajar Guru — Guru Piket')
@section('header_title', 'Jurnal Mengajar Guru')

@section('styles')
<style>
    /* Main Layout & Colors (Kombinasi Abu-abu, Biru, Putih, Abu-abu Muda Cerah) */
    .jurnal-mengajar-container {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .page-header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 4px;
    }

    .page-title-group h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }

    .page-title-group p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
        font-weight: 600;
    }

    .btn-header-action {
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
    }

    .btn-header-primary {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }
    .btn-header-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-header-navy {
        background: #2b3957;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(43, 57, 87, 0.25);
    }
    .btn-header-navy:hover {
        background: #1e293b;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-header-secondary {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .btn-header-secondary:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    /* 4 Stat Cards Grid */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }

    .stat-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-icon-blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon-green  { background: #f0fdf4; color: #16a34a; }
    .stat-icon-amber  { background: #fffbeb; color: #d97706; }
    .stat-icon-slate  { background: #f1f5f9; color: #384972; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .stat-val {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }

    .stat-subtext {
        font-size: 11.5px;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 3px;
    }

    /* Verification & Signature Status Banner (Modern Card: Gray, Blue, White, Light Gray) */
    .verification-banner-box {
        background: #ffffff;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
        border: 1px solid #e2e8f0;
        transition: all 0.25s ease;
    }

    .verification-verified {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-left: 4px solid #16a34a;
    }

    .verification-ready {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-left: 4px solid #2563eb;
    }

    .verification-locked {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #94a3b8;
    }

    .verification-future {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #cbd5e1;
    }

    .verif-left-content {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .verif-icon-circle {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .verif-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .btn-signature-action {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 11px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }

    .btn-signature-action:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
    }

    .btn-signature-locked {
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px solid #cbd5e1;
        padding: 11px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        cursor: not-allowed;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* Main Table Panel */
    .main-table-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .table-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Filter Form Styling */
    .filter-bar-container {
        margin-bottom: 22px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
    }

    .filter-grid-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-input-text {
        flex: 1.6;
        min-width: 220px;
        position: relative;
    }

    .filter-input-text input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        color: #1e293b;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-input-text input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .filter-input-text i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .filter-select {
        flex: 1;
        min-width: 150px;
        padding: 10px 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-filter-submit {
        background: #2b3957;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease, transform 0.15s ease;
    }

    .btn-filter-submit:hover {
        background: #1e293b;
        transform: translateY(-1px);
    }

    .btn-filter-reset {
        background: #ffffff;
        color: #64748b;
        border: 1px solid #cbd5e1;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-filter-reset:hover {
        background: #f1f5f9;
        color: #334155;
    }

    /* Custom Table Styling (Clean Slate Header) */
    .custom-jurnal-table {
=======
@section('title', 'Jurnal Mengajar — Guru Piket')
@section('header_title', 'Jurnal Mengajar')

@section('styles')
<style>
    /* Root Page Layout */
    .jurnal-page-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        max-width: 100%;
    }

    /* 1. Welcome Greeting Header Banner */
    .welcome-greeting-card {
        background: linear-gradient(135deg, #eef6ff 0%, #f0f4ff 50%, #f6f8fe 100%);
        border: 1px solid rgba(219, 234, 254, 0.9);
        border-radius: 18px;
        padding: 22px 28px;
        box-shadow: 0 4px 15px -3px rgba(37, 99, 235, 0.04);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .welcome-greeting-card::before {
        content: '';
        position: absolute;
        top: -30px;
        right: 15%;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(191, 219, 254, 0.35) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .greeting-title-group h1 {
        font-size: 26px;
        font-weight: 800;
        color: #1e3a8a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .greeting-title-group p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 5px;
        margin-bottom: 0;
    }

    .wave-hand {
        display: inline-block;
        animation: wave 2.2s infinite;
        transform-origin: 70% 70%;
    }

    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        20%, 60% { transform: rotate(14deg); }
        40%, 80% { transform: rotate(-8deg); }
    }

    /* 2. 4 Stat Cards Grid */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        width: 100%;
    }

    .stat-metric-card {
        border-radius: 20px;
        padding: 16px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px -3px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -4px rgba(0, 0, 0, 0.06);
    }

    /* Card Themes */
    .card-theme-blue {
        background: linear-gradient(135deg, #ffffff 0%, #f8fbff 50%, #eff6ff 100%);
        border: 1px solid rgba(219, 234, 254, 0.7);
    }
    .icon-box-blue {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    }
    .text-theme-blue {
        color: #2563eb;
    }
    .wave-theme-blue {
        color: #bfdbfe;
        opacity: 0.75;
    }

    .card-theme-emerald {
        background: linear-gradient(135deg, #ffffff 0%, #f9fdfa 50%, #f0fdf4 100%);
        border: 1px solid rgba(209, 250, 229, 0.7);
    }
    .icon-box-emerald {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    }
    .text-theme-emerald {
        color: #059669;
    }
    .wave-theme-emerald {
        color: #bbf7d0;
        opacity: 0.7;
    }

    .card-theme-amber {
        background: linear-gradient(135deg, #ffffff 0%, #fffcf7 50%, #fff7ed 100%);
        border: 1px solid rgba(255, 237, 213, 0.7);
    }
    .icon-box-amber {
        background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%);
    }
    .text-theme-amber {
        color: #ea580c;
    }
    .wave-theme-amber {
        color: #fed7aa;
        opacity: 0.7;
    }

    .card-theme-purple {
        background: linear-gradient(135deg, #ffffff 0%, #faf8ff 50%, #f5f3ff 100%);
        border: 1px solid rgba(237, 233, 254, 0.7);
    }
    .icon-box-purple {
        background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
    }
    .text-theme-purple {
        color: #7c3aed;
    }
    .wave-theme-purple {
        color: #ddd6fe;
        opacity: 0.75;
    }

    /* Icon Box */
    .stat-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    /* Info Content Stack */
    .stat-info {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 0;
        position: relative;
        z-index: 2;
    }

    .stat-info-label {
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .stat-info-value-wrap {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }

    .stat-info-value {
        font-size: 26px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .stat-info-unit {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    .stat-info-subtext {
        font-size: 10px;
        font-weight: 500;
        color: #94a3b8;
        margin-top: 3px;
        letter-spacing: -0.015em;
        line-height: 1.25;
    }

    /* Decorative Corner Elements */
    .stat-corner-elem {
        position: absolute;
        top: 13px;
        right: 14px;
        z-index: 2;
        pointer-events: none;
    }

    /* Decorative Bottom-Right Wave */
    .stat-card-wave {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 96px;
        height: 52px;
        pointer-events: none;
        z-index: 1;
    }

    /* 3. Main Data Panel */
    .main-data-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 22px 24px;
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        width: 100%;
        box-sizing: border-box;
    }

    .main-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 20px;
    }

    .main-card-title-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .main-card-icon-badge {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .main-card-title-group h2 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }

    .main-card-title-group p {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        margin: 2px 0 0 0;
    }

    .btn-action-export {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        padding: 8px 16px;
        border-radius: 11px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    }

    .btn-action-export:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    /* Filter & Search Bar Form */
    .filter-section {
        margin-bottom: 22px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
    }

    .filter-row-top {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-row-bottom {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-input-search-wrap {
        flex: 1.8;
        min-width: 240px;
        position: relative;
    }

    .filter-input-search-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .filter-input-search {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .filter-input-search:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-input-select-wrap {
        flex: 1.1;
        min-width: 150px;
        position: relative;
    }

    .filter-input-select-wrap i.select-icon-left {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
    }

    .filter-select {
        width: 100%;
        padding: 9px 28px 9px 34px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        color: #334155;
        font-weight: 600;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 8px center;
        background-repeat: no-repeat;
        background-size: 16px 16px;
        transition: all 0.2s ease;
        box-sizing: border-box;
        cursor: pointer;
    }

    .filter-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-date-input {
        width: 100%;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        font-size: 12.5px;
        font-family: inherit;
        color: #334155;
        font-weight: 600;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .filter-date-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-input-mapel-wrap {
        flex: 0 0 220px;
        max-width: 260px;
    }

    .filter-actions-row {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-filter-submit {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        font-size: 12.5px;
        font-weight: 700;
        padding: 8px 18px;
        border-radius: 10px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-filter-submit:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    .btn-filter-reset {
        background: #ffffff;
        color: #64748b;
        border: 1px solid #e2e8f0;
        font-size: 12.5px;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-filter-reset:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #cbd5e1;
    }

    /* 4. Table Styling */
    .table-responsive-box {
        width: 100%;
        overflow-x: auto;
        border-radius: 12px;
    }

    .table-jurnal-custom {
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 12.5px;
        min-width: 880px;
    }

<<<<<<< HEAD
    .custom-jurnal-table th {
        background: #f1f5f9;
        color: #334155;
        font-weight: 800;
        padding: 13px 14px;
        text-align: left;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .custom-jurnal-table th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; border-left: 1px solid #e2e8f0; }
    .custom-jurnal-table th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; text-align: center; border-right: 1px solid #e2e8f0; }

    .custom-jurnal-table td {
        padding: 14px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
=======
    .table-jurnal-custom thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 11px 10px;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
        white-space: nowrap;
    }

    .table-jurnal-custom thead th:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        border-left: 1px solid #e2e8f0;
    }

    .table-jurnal-custom thead th:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        border-right: 1px solid #e2e8f0;
        text-align: center;
    }

    .table-jurnal-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-jurnal-custom tbody tr:hover {
        background-color: #fafbfd;
    }

    .table-jurnal-custom tbody td {
        padding: 11px 10px;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        font-size: 12.5px;
    }

<<<<<<< HEAD
    .custom-jurnal-table tbody tr:hover td {
        background-color: #f8fafc;
    }

    .date-cell {
        display: flex;
        gap: 8px;
=======
    /* Date Cell with Left Accent Colored Bar */
    .date-column-cell {
        display: flex;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        align-items: center;
        gap: 8px;
        position: relative;
        padding-left: 8px;
    }

    .date-accent-indicator {
        position: absolute;
        left: 0;
        top: 1px;
        bottom: 1px;
        width: 3.5px;
        border-radius: 4px;
    }

    .date-day-large {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .date-my-group {
        display: flex;
        flex-direction: column;
        font-size: 9px;
        font-weight: 800;
        color: #94a3b8;
        line-height: 1.1;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

<<<<<<< HEAD
    .badge-status-pill {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-terlaksana {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .badge-belum-terlaksana {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .badge-verif-yes {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .badge-verif-no {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-action-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
=======
    /* Pastel Mapel Badges */
    .mapel-pill-badge {
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-block;
        white-space: nowrap;
    }

    /* Status Badges */
    .status-badge-terlaksana {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
        padding: 4px 11px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .status-badge-belum {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        padding: 4px 11px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    /* Table Action Buttons */
    .table-actions-cluster {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-icon-table-action {
        width: 29px;
        height: 29px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        cursor: pointer;
        transition: all 0.15s ease;
    }

<<<<<<< HEAD
    .btn-action-icon:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    }

    /* Modal Overlay & Box */
    .custom-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }

    .custom-modal-box {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 680px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid #e2e8f0;
        animation: modalPop 0.2s ease-out;
    }

    @keyframes modalPop {
        0% { opacity: 0; transform: scale(0.96); }
        100% { opacity: 1; transform: scale(1); }
    }

    .modal-header-styled {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        border-radius: 20px 20px 0 0;
    }

    .modal-body-styled {
        padding: 24px;
    }

    .modal-footer-styled {
        padding: 16px 24px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 0 0 20px 20px;
=======
    .btn-icon-table-action:hover {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }

    /* Table Footer & Pagination */
    .table-pagination-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pagination-records-info {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .pagination-pills-list {
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

<<<<<<< HEAD
    /* Signature Canvas Area */
    .signature-pad-wrapper {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        position: relative;
        touch-action: none;
        overflow: hidden;
    }

    .signature-canvas {
        width: 100%;
        height: 180px;
        display: block;
        cursor: crosshair;
    }

    .signature-placeholder-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
        font-weight: 600;
        text-align: center;
=======
    .pagination-pill-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .pagination-pill-btn:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #cbd5e1;
    }

    .pagination-pill-btn.active {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        font-weight: 800;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    /* Responsive Breakpoints */
    @media (max-width: 1200px) {
        .stat-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
<<<<<<< HEAD
        .stat-grid { grid-template-columns: 1fr; }
        .verification-banner-box { flex-direction: column; align-items: flex-start; }
        .verif-actions { width: 100%; justify-content: flex-start; }
=======
        .stat-cards-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .jurnal-page-wrapper {
            gap: 14px;
            min-width: 0;
            max-width: 100%;
            overflow: hidden;
        }

        .welcome-greeting-card {
            padding: 14px 16px;
            border-radius: 14px;
        }

        .welcome-greeting-card::before {
            display: none;
        }

        .greeting-title-group h1 {
            font-size: 18px;
            gap: 6px;
        }

        .greeting-title-group p {
            font-size: 11.5px;
            margin-top: 3px;
        }

        .stat-cards-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 10px;
        }

        .stat-metric-card {
            padding: 12px 14px;
            border-radius: 14px;
            gap: 12px;
            min-width: 0;
        }

        .stat-icon-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
        }

        .stat-icon-box svg {
            width: 22px;
            height: 22px;
        }

        .stat-info-value {
            font-size: 22px;
        }

        .stat-info-unit {
            font-size: 12px;
        }

        .stat-info-label {
            font-size: 11px;
        }

        .stat-info-subtext {
            font-size: 10px;
        }

        .main-data-card {
            padding: 14px 12px;
            border-radius: 14px;
            min-width: 0;
            max-width: 100%;
            overflow: hidden;
        }

        .main-card-header {
            margin-bottom: 14px;
            gap: 10px;
            align-items: center;
            justify-content: space-between;
        }

        .main-card-title-group {
            gap: 8px;
            min-width: 0;
            flex: 1;
        }

        .main-card-icon-badge {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            font-size: 14px;
            flex-shrink: 0;
        }

        .main-card-title-group h2 {
            font-size: 14.5px;
        }

        .main-card-title-group p {
            font-size: 11px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .btn-action-export {
            padding: 6px 12px;
            font-size: 11px;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .filter-section {
            margin-bottom: 16px;
            gap: 8px;
        }

        .filter-row-top,
        .filter-row-bottom {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            width: 100%;
        }

        .filter-input-search-wrap,
        .filter-input-select-wrap,
        .filter-input-mapel-wrap {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            flex: none !important;
            height: auto !important;
        }

        .filter-input-search,
        .filter-select,
        .filter-date-input {
            height: 38px;
            padding: 8px 12px 8px 34px;
            font-size: 12px;
            border-radius: 9px;
        }

        .filter-date-input {
            padding-left: 12px;
        }

        .filter-actions-row {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        .btn-filter-submit,
        .btn-filter-reset {
            flex: 1;
            height: 38px;
            justify-content: center;
            border-radius: 9px;
            font-size: 12px;
            padding: 0;
        }

        .table-responsive-box {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
            border: 1px solid #f1f5f9;
        }

        .table-jurnal-custom {
            min-width: 680px;
            font-size: 11.5px;
        }

        .table-jurnal-custom thead th {
            padding: 9px 8px;
            font-size: 10px;
        }

        .table-jurnal-custom tbody td {
            padding: 9px 8px;
            font-size: 11.5px;
        }

        .date-day-large {
            font-size: 15px;
        }

        .date-my-group {
            font-size: 8.5px;
        }

        .table-pagination-footer {
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-align: center;
            padding-top: 12px;
            margin-top: 12px;
        }

        .pagination-records-info {
            font-size: 11px;
        }

        .pagination-pills-list {
            gap: 3px;
        }

        .pagination-pill-btn {
            width: 28px;
            height: 28px;
            font-size: 11px;
            border-radius: 7px;
        }

        .detail-modal-card {
            padding: 16px !important;
            border-radius: 16px !important;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-info-grid {
            grid-template-columns: 1fr !important;
            gap: 8px !important;
        }
    }

    /* Desktop vs Mobile View toggling */
    .mobile-jurnal-view {
        display: none;
    }
    .desktop-jurnal-view {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
    }

    @media (max-width: 768px) {
        .desktop-jurnal-view {
            display: none !important;
        }
        .mobile-jurnal-view {
            display: flex !important;
            flex-direction: column;
            gap: 14px;
            width: 100%;
        }

        /* Mobile Carousel Banner */
        .mobile-carousel-container {
            position: relative;
            width: 100%;
            border-radius: 18px;
            overflow: hidden;
            touch-action: pan-y;
            background: transparent;
        }
        .mobile-carousel-track {
            display: flex;
            transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1);
            width: 100%;
        }
        .mobile-carousel-slide {
            flex: 0 0 100%;
            width: 100%;
            padding: 18px 24px 18px 24px;
            border-radius: 18px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 140px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px -3px rgba(0, 0, 0, 0.03), 0 2px 6px -1px rgba(0, 0, 0, 0.02);
        }

        /* Slide Themes - Matching Desktop Exactly */
        .m-slide-welcome {
            background: linear-gradient(135deg, #eef6ff 0%, #f0f4ff 50%, #f6f8fe 100%);
            border: 1px solid rgba(219, 234, 254, 0.9);
            box-shadow: 0 4px 15px -3px rgba(37, 99, 235, 0.04);
        }
        .m-slide-welcome-circle {
            position: absolute;
            top: -20px;
            right: 15%;
            width: 110px;
            height: 110px;
            background: radial-gradient(circle, rgba(191, 219, 254, 0.4) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .m-slide-welcome .m-slide-pill {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        .m-slide-welcome .m-slide-title {
            color: #1e3a8a;
            font-size: 19px;
            font-weight: 800;
            margin: 0;
            line-height: 1.25;
            letter-spacing: -0.02em;
        }
        .m-slide-welcome .m-slide-subtitle {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            margin: 5px 0 0 0;
            line-height: 1.38;
        }

        .m-slide-blue {
            background: linear-gradient(135deg, #ffffff 0%, #f8fbff 50%, #eff6ff 100%);
            border: 1px solid rgba(219, 234, 254, 0.75);
        }
        .m-slide-blue .m-slide-pill {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        .m-slide-blue .m-slide-label {
            color: #2563eb;
            font-size: 12.5px;
            font-weight: 700;
        }

        .m-slide-emerald {
            background: linear-gradient(135deg, #ffffff 0%, #f9fdfa 50%, #f0fdf4 100%);
            border: 1px solid rgba(209, 250, 229, 0.75);
        }
        .m-slide-emerald .m-slide-pill {
            background: #dcfce7;
            color: #065f46;
            border: 1px solid #bbf7d0;
        }
        .m-slide-emerald .m-slide-label {
            color: #059669;
            font-size: 12.5px;
            font-weight: 700;
        }

        .m-slide-amber {
            background: linear-gradient(135deg, #ffffff 0%, #fffcf7 50%, #fff7ed 100%);
            border: 1px solid rgba(255, 237, 213, 0.75);
        }
        .m-slide-amber .m-slide-pill {
            background: #ffedd5;
            color: #9a3412;
            border: 1px solid #fed7aa;
        }
        .m-slide-amber .m-slide-label {
            color: #ea580c;
            font-size: 12.5px;
            font-weight: 700;
        }

        .m-slide-purple {
            background: linear-gradient(135deg, #ffffff 0%, #faf8ff 50%, #f5f3ff 100%);
            border: 1px solid rgba(237, 233, 254, 0.75);
        }
        .m-slide-purple .m-slide-pill {
            background: #ede9fe;
            color: #5b21b6;
            border: 1px solid #ddd6fe;
        }
        .m-slide-purple .m-slide-label {
            color: #7c3aed;
            font-size: 12.5px;
            font-weight: 700;
        }

        .m-slide-pill {
            font-size: 10.5px;
            font-weight: 700;
            padding: 2.5px 9px;
            border-radius: 9999px;
            display: inline-block;
        }

        /* Carousel Navigation Arrows - Hidden by default, reveal on hover/cursor approach */
        .m-carousel-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #ffffff;
            color: #475569;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            z-index: 5;
            opacity: 0;
            pointer-events: none;
            visibility: hidden;
            transition: opacity 0.25s ease, transform 0.2s ease, visibility 0.25s ease;
        }
        .mobile-carousel-container:hover .m-carousel-arrow,
        .mobile-carousel-container.is-hovered .m-carousel-arrow {
            opacity: 1;
            pointer-events: auto;
            visibility: visible;
        }
        .m-carousel-arrow:hover,
        .m-carousel-arrow:active {
            color: #2563eb;
            background: #f8fafc;
            transform: translateY(-50%) scale(0.92);
        }
        .m-carousel-prev {
            left: 8px;
        }
        .m-carousel-next {
            right: 8px;
        }

        /* Carousel Indicator Dots */
        .mobile-carousel-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        .m-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #cbd5e1;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .m-dot.active {
            width: 20px;
            height: 6px;
            border-radius: 9999px;
            background: #2563eb;
        }

        /* Mobile Card "Daftar Jurnal Mengajar" */
        .mobile-search-filter-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 16px;
            padding: 14px 16px;
            box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .mobile-search-filter-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .m-card-icon-wrap {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }
        .m-btn-export {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            color: #334155;
            text-decoration: none;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            transition: all 0.15s ease;
        }
        .m-btn-export:hover,
        .m-btn-export:active {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a;
        }
        .mobile-search-filter-bottom {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }
        .m-search-form {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }
        .m-search-input-box {
            position: relative;
            flex: 1;
            min-width: 0;
        }
        .m-search-input-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
            pointer-events: none;
        }
        .m-search-input {
            width: 100%;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            padding: 0 12px 0 34px;
            font-size: 12.5px;
            color: #1e293b;
            font-weight: 500;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }
        .m-search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .m-btn-filter-trigger {
            height: 38px;
            padding: 0 16px;
            border-radius: 10px;
            background: #2563eb;
            color: #ffffff;
            border: none;
            font-size: 12.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
            flex-shrink: 0;
            transition: background 0.15s ease;
        }
        .m-btn-filter-trigger:hover,
        .m-btn-filter-trigger:active {
            background: #1d4ed8;
        }

        /* Mobile Journal Card Items */
        .mobile-jurnal-cards-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }
        .mobile-jurnal-card-item {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: stretch;
            padding: 12px 14px 12px 10px;
            position: relative;
            overflow: hidden;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .mobile-jurnal-card-item.card-terlaksana {
            border-color: #e2e8f0;
            background: #ffffff;
        }
        .mobile-jurnal-card-item.card-belum {
            border-color: #fecdd3;
            background: #fffcfc;
        }

        /* Date Column Left */
        .mobile-card-date-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 54px;
            padding: 2px 10px 2px 4px;
            border-right: 1px solid #f1f5f9;
            flex-shrink: 0;
        }
        .date-terlaksana .m-date-day {
            font-size: 20px;
            font-weight: 800;
            color: #1e3a8a;
            line-height: 1;
        }
        .date-terlaksana .m-date-month {
            font-size: 10px;
            font-weight: 800;
            color: #2563eb;
            margin-top: 2px;
            text-transform: uppercase;
        }
        .date-terlaksana .m-date-year {
            font-size: 9.5px;
            font-weight: 600;
            color: #94a3b8;
        }

        .date-belum .m-date-day {
            font-size: 20px;
            font-weight: 800;
            color: #e11d48;
            line-height: 1;
        }
        .date-belum .m-date-month {
            font-size: 10px;
            font-weight: 800;
            color: #e11d48;
            margin-top: 2px;
            text-transform: uppercase;
        }
        .date-belum .m-date-year {
            font-size: 9.5px;
            font-weight: 600;
            color: #94a3b8;
        }

        /* Card Content Right */
        .mobile-card-content {
            flex: 1;
            min-width: 0;
            padding-left: 12px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            justify-content: center;
        }
        .m-badge-status {
            font-weight: 700;
            font-size: 11px;
            padding: 3px 9px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }
        .m-badge-terlaksana {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .m-badge-belum {
            background: #ffe4e6;
            color: #e11d48;
            border: 1px solid #fecdd3;
        }
        .m-badge-mapel {
            font-size: 11px;
            font-weight: 700;
            padding: 2.5px 8px;
            border-radius: 6px;
            white-space: nowrap;
            max-width: 140px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .m-btn-lihat-detail {
            font-size: 11.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            white-space: nowrap;
        }
        .btn-detail-blue {
            color: #2563eb;
        }
        .btn-detail-red {
            color: #e11d48;
        }

        /* Mobile Pagination Card */
        .mobile-pagination-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .m-pagination-pills {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .m-pag-btn {
            min-width: 28px;
            height: 28px;
            padding: 0 6px;
            border-radius: 7px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #64748b;
            font-size: 11.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        .m-pag-btn.active {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        }

        /* Filter Modal Card */
        .mobile-filter-modal-card {
            background: #ffffff;
            width: 100%;
            max-width: 440px;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
            border: 1px solid #e2e8f0;
            animation: modalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            margin: auto;
        }
        .m-filter-field {
            width: 100%;
            height: 38px;
            border-radius: 9px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            padding: 0 12px;
            font-size: 12px;
            font-weight: 600;
            color: #334155;
            outline: none;
            box-sizing: border-box;
        }
        .m-filter-field:focus {
            border-color: #2563eb;
            background: #ffffff;
        }
        .m-btn-filter-reset {
            flex: 1;
            height: 38px;
            border-radius: 9px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
        }
        .m-btn-filter-submit {
            flex: 1.5;
            height: 38px;
            border-radius: 9px;
            border: none;
            background: #2563eb;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        }
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }
</style>
@endsection

@section('content')
<<<<<<< HEAD

@php
    $daysMapIndo = [
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu',
        'Sunday'    => 'Minggu'
    ];
    $monthsMapIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    if (!empty($tanggalFilter)) {
        $cFilter = \Carbon\Carbon::parse($tanggalFilter);
        $filterDayIndo = $daysMapIndo[$cFilter->format('l')] ?? $cFilter->format('l');
        $filterDateFormatted = $filterDayIndo . ', ' . $cFilter->day . ' ' . $monthsMapIndo[$cFilter->month] . ' ' . $cFilter->year;
    } else {
        $filterDateFormatted = 'Semua Tanggal';
    }

    $cSig = \Carbon\Carbon::parse($dateForSignature);
    $sigDayIndo = $daysMapIndo[$cSig->format('l')] ?? 'Senin';
    $sigDateFormatted = $sigDayIndo . ', ' . $cSig->day . ' ' . $monthsMapIndo[$cSig->month] . ' ' . $cSig->year;
@endphp

<div class="jurnal-mengajar-container">

    <!-- Header Top Bar -->
    <div class="page-header-container">
        <div class="page-title-group">
            <h1>Jurnal Mengajar Guru</h1>
            <p>Monitoring, evaluasi, dan pengesahan tanda tangan jurnal mengajar harian guru</p>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('piket.jurnal-mengajar.cetak-harian', ['tanggal' => $dateForSignature]) }}" target="_blank" class="btn-header-action btn-header-navy">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Rekap Harian</span>
            </a>
            <a href="{{ route('piket.jurnal-mengajar.export', request()->query()) }}" class="btn-header-action btn-header-secondary">
                <i class="fa-solid fa-download"></i>
                <span>Export CSV</span>
            </a>
        </div>
    </div>

    <!-- 1. Stat Cards (4 Cards) Dinamis dari Database -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-blue">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Total Pertemuan</span>
                <span class="stat-val">{{ $stats['totalPertemuan'] }} Pertemuan</span>
                <span class="stat-subtext">{{ !empty($tanggalFilter) ? 'Pada ' . \Carbon\Carbon::parse($tanggalFilter)->translatedFormat('d M Y') : 'Seluruh periode terpilih' }}</span>
=======
<div class="jurnal-page-wrapper">

    <!-- ==================== DESKTOP VIEW ==================== -->
    <div class="desktop-jurnal-view">

        <!-- 1. Top Welcome Greeting Header Banner -->
    <div class="welcome-greeting-card">
        <div class="greeting-title-group">
            <h1>
                <span>Halo, {{ Auth::user()->name ?? 'Petugas Piket' }}!</span>
                <span class="wave-hand">👋</span>
            </h1>
            <p>Pantau dan kelola seluruh aktivitas jurnal mengajar di sini.</p>
        </div>
    </div>

    <!-- 2. 4 Stat Cards Metric Overview -->
    <div class="stat-cards-grid">
        <!-- Card 1: Total Pertemuan -->
        <div class="stat-metric-card card-theme-blue">
            <div class="stat-icon-box icon-box-blue">
                <svg width="27" height="27" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3.5" y="5.5" width="21" height="18.5" rx="5" stroke="#2563eb" stroke-width="2.3"/>
                    <path d="M3.5 11.5H24.5" stroke="#2563eb" stroke-width="2.3" stroke-linecap="round"/>
                    <path d="M8.5 3.5V6.5" stroke="#2563eb" stroke-width="2.3" stroke-linecap="round"/>
                    <path d="M19.5 3.5V6.5" stroke="#2563eb" stroke-width="2.3" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-info-label text-theme-blue">Total Pertemuan</span>
                <div class="stat-info-value-wrap">
                    <span class="stat-info-value">{{ $stats['totalPertemuan'] }}</span>
                    <span class="stat-info-unit">Pertemuan</span>
                </div>
                <span class="stat-info-subtext">Seluruh pertemuan pada periode ini</span>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
            </div>
            <!-- Loop Doodle -->
            <div class="stat-corner-elem">
                <svg width="34" height="22" viewBox="0 0 36 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 18 C 10 18, 16 10, 20 6 C 24 2, 28 4, 28 8 C 28 13, 23 16, 18 14 C 15 12, 16 7, 21 5 C 26 3, 31 8, 33 11" stroke="#60a5fa" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" opacity="0.85"/>
                </svg>
            </div>
            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-theme-blue" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

        <!-- Card 2: Terlaksana -->
        <div class="stat-metric-card card-theme-emerald">
            <div class="stat-icon-box icon-box-emerald">
                <svg width="27" height="27" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="14" cy="14" r="10.5" stroke="#059669" stroke-width="2.3"/>
                    <path d="M9.5 14L12.5 17L18.5 11" stroke="#059669" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
<<<<<<< HEAD
            <div class="stat-details">
                <span class="stat-label">Terlaksana</span>
                <span class="stat-val">{{ $stats['terlaksana'] }} Pertemuan</span>
                <span class="stat-subtext">KBM guru hadir / pengganti</span>
=======
            <div class="stat-info">
                <span class="stat-info-label text-theme-emerald">Terlaksana</span>
                <div class="stat-info-value-wrap">
                    <span class="stat-info-value">{{ $stats['terlaksana'] }}</span>
                    <span class="stat-info-unit">Pertemuan</span>
                </div>
                <span class="stat-info-subtext">Seluruh pertemuan pada periode ini</span>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
            </div>
            <!-- Sparkles -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: flex-start; color: #34d399;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>
            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-theme-emerald" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

<<<<<<< HEAD
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-amber">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Belum Terlaksana</span>
                <span class="stat-val">{{ $stats['belumTerlaksana'] }} Pertemuan</span>
                <span class="stat-subtext">{{ $stats['pctBelum'] }}% dari total sesi</span>
=======
        <!-- Card 3: Belum Terlaksana -->
        <div class="stat-metric-card card-theme-amber">
            <div class="stat-icon-box icon-box-amber">
                <svg width="27" height="27" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="14" cy="14" r="10.5" stroke="#ea580c" stroke-width="2.3"/>
                    <path d="M14 8.5V14H18" stroke="#ea580c" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-info-label text-theme-amber">Belum Terlaksana</span>
                <div class="stat-info-value-wrap">
                    <span class="stat-info-value">{{ $stats['belumTerlaksana'] }}</span>
                    <span class="stat-info-unit">Pertemuan</span>
                </div>
                <span class="stat-info-subtext"><strong style="color: #ea580c; font-weight: 700;">{{ $stats['pctBelum'] }}%</strong> dari total pertemuan</span>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
            </div>
            <!-- Sparkles -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: flex-start; color: #fb923c;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>
            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-theme-amber" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>

<<<<<<< HEAD
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-slate">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Guru Aktif</span>
                <span class="stat-val">{{ $stats['guruAktif'] }} Guru</span>
                <span class="stat-subtext">Mengajar pada filter ini</span>
=======
        <!-- Card 4: Guru Aktif -->
        <div class="stat-metric-card card-theme-purple">
            <div class="stat-icon-box icon-box-purple">
                <svg width="27" height="27" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="14" cy="9.5" r="4.5" stroke="#7c3aed" stroke-width="2.3"/>
                    <path d="M6 22C6 18.134 9.58172 15 14 15C18.4183 15 22 18.134 22 22" stroke="#7c3aed" stroke-width="2.3" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-info-label text-theme-purple">Guru Aktif</span>
                <div class="stat-info-value-wrap">
                    <span class="stat-info-value">{{ $stats['guruAktif'] }}</span>
                    <span class="stat-info-unit">Guru</span>
                </div>
                <span class="stat-info-subtext">Mengajar pada periode ini</span>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
            </div>
            <!-- Sparkles -->
            <div class="stat-corner-elem" style="display: flex; gap: 3px; align-items: flex-start; color: #a78bfa;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 5px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
            </div>
            <!-- Bottom-right wave -->
            <svg class="stat-card-wave wave-theme-purple" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
            </svg>
        </div>
    </div>

<<<<<<< HEAD
    <!-- 2. CARD STATUS TANDA TANGAN & VERIFIKASI GURU PIKET HARIAN (Ringkas & Harmonis) -->
    @if($verifikasiHariIni)
        <!-- Kondisi 1: Jurnal Sudah Ditandatangani & Diverifikasi Resmi -->
        <div class="verification-banner-box verification-verified">
            <div class="verif-left-content">
                <div class="verif-icon-circle" style="background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7;">
                    <i class="fa-solid fa-file-circle-check"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span style="font-size: 14.5px; font-weight: 800; color: #0f172a;">
                            Jurnal Mengajar Tanggal {{ $sigDateFormatted }}
                        </span>
                        <span style="background: #f0fdf4; color: #15803d; border: 1px solid #86efac; font-size: 11px; font-weight: 800; padding: 2.5px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-circle-check"></i> Terverifikasi
                        </span>
                    </div>
                    <div style="font-size: 12.5px; color: #475569; margin-top: 3px; font-weight: 500;">
                        Divalidasi oleh <strong>{{ $verifikasiHariIni->nama_guru_piket }}</strong> pada {{ \Carbon\Carbon::parse($verifikasiHariIni->waktu_verifikasi)->format('d/m/Y H:i') }} WIB ({{ $verifikasiHariIni->total_jurnal_diverifikasi }} jurnal sah).
                        @if($verifikasiHariIni->catatan)
                            <span style="color: #64748b; font-style: italic;">• Catatan: "{{ $verifikasiHariIni->catatan }}"</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="verif-actions">
                <button type="button" onclick="showSignaturePreviewModal()" class="btn-header-action btn-header-navy" style="padding: 8px 14px; font-size: 12.5px;">
                    <i class="fa-solid fa-eye"></i>
                    <span>Lihat TTD</span>
                </button>
                <a href="{{ route('piket.jurnal-mengajar.cetak-harian', ['tanggal' => $dateForSignature]) }}" target="_blank" class="btn-header-action btn-header-primary" style="padding: 8px 14px; font-size: 12.5px;">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Ber-TTD</span>
                </a>
                <form action="{{ route('piket.jurnal-mengajar.batal-tanda-tangan') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan tanda tangan verifikasi untuk tanggal ini? Anda dapat menandatangani ulang kembali setelahnya.')" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="tanggal" value="{{ $dateForSignature }}">
                    <button type="submit" style="background: #ffffff; color: #dc2626; border: 1px solid #fecaca; padding: 8px 13px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s ease;">
                        <i class="fa-solid fa-rotate-left"></i> Batal TTD
                    </button>
                </form>
            </div>
        </div>

    @elseif($isJamSekolahSelesai)
        <!-- Kondisi 2: Jam KBM Selesai & Siap Ditandatangani Guru Piket -->
        <div class="verification-banner-box verification-ready">
            <div class="verif-left-content">
                <div class="verif-icon-circle" style="background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe;">
                    <i class="fa-solid fa-signature"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span style="font-size: 14.5px; font-weight: 800; color: #0f172a;">
                            Jurnal Mengajar Tanggal {{ $sigDateFormatted }}
                        </span>
                        <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 800; padding: 2.5px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-pen-fancy"></i> Siap Ditandatangani
                        </span>
                    </div>
                    <div style="font-size: 12.5px; color: #475569; margin-top: 3px; font-weight: 500;">
                        KBM telah selesai (Pukul {{ $jamSelesaiSekolah }} WIB). Silakan periksa data KBM lalu bubuhkan tanda tangan verifikasi harian.
                    </div>
                </div>
            </div>

            <div class="verif-actions">
                <button type="button" onclick="openSignatureModal()" class="btn-signature-action" style="padding: 9px 18px; font-size: 13px;">
                    <i class="fa-solid fa-pen-nib"></i>
                    <span>Tanda Tangani Jurnal Harian</span>
                </button>
                <a href="{{ route('piket.jurnal-mengajar.cetak-harian', ['tanggal' => $dateForSignature]) }}" target="_blank" class="btn-header-action btn-header-navy" style="padding: 9px 16px; font-size: 13px;">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Rekap</span>
                </a>
            </div>
        </div>

    @elseif($isTodayDate)
        <!-- Kondisi 3: KBM Masih Berlangsung Hari Ini -->
        <div class="verification-banner-box verification-locked">
            <div class="verif-left-content">
                <div class="verif-icon-circle" style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span style="font-size: 14.5px; font-weight: 800; color: #0f172a;">
                            Jam Pembelajaran KBM Masih Berlangsung
                        </span>
                        <span style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 11px; font-weight: 800; padding: 2.5px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-lock"></i> Belum Dibuka
                        </span>
                    </div>
                    <div style="font-size: 12.5px; color: #64748b; margin-top: 3px; font-weight: 500;">
                        Tanda tangan verifikasi dibuka setelah jam pembelajaran berakhir (Pukul <strong>{{ $jamSelesaiSekolah }} WIB</strong>).
                    </div>
                </div>
            </div>

            <div class="verif-actions">
                <button type="button" class="btn-signature-locked" style="padding: 9px 16px; font-size: 12.5px;" disabled title="Tanda tangan baru aktif setelah jam KBM sekolah berakhir pukul {{ $jamSelesaiSekolah }} WIB">
                    <i class="fa-solid fa-lock"></i> Dibuka Pukul {{ $jamSelesaiSekolah }} WIB
                </button>
            </div>
        </div>

    @else
        <!-- Kondisi 4: Tanggal Depan -->
        <div class="verification-banner-box verification-future">
            <div class="verif-left-content">
                <div class="verif-icon-circle" style="background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                    <i class="fa-regular fa-calendar-xmark"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span style="font-size: 14.5px; font-weight: 800; color: #475569;">
                            Tanggal Pembelajaran Mendatang
                        </span>
                        <span style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; font-size: 11px; font-weight: 800; padding: 2.5px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-regular fa-calendar"></i> Belum Berlangsung
                        </span>
                    </div>
                    <div style="font-size: 12.5px; color: #64748b; margin-top: 3px; font-weight: 500;">
                        Tanda tangan verifikasi hanya tersedia untuk tanggal yang telah selesai KBM.
                    </div>
                </div>
            </div>
            <div class="verif-actions">
                <button type="button" class="btn-signature-locked" style="padding: 9px 16px; font-size: 12.5px;" disabled>
                    <i class="fa-regular fa-calendar-xmark"></i> Belum Berlangsung
                </button>
            </div>
        </div>
    @endif

    <!-- 3. Main Table Panel: Daftar Jurnal Mengajar -->
    <div class="main-table-panel">
        <div class="table-panel-header">
            <div class="table-panel-title">
                <i class="fa-solid fa-book-open-reader" style="color: #2563eb;"></i>
                <span>Daftar Jurnal Mengajar Guru</span>
                <span style="font-size: 12.5px; background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; padding: 2px 10px; border-radius: 20px; font-weight: 800;">
                    Total: {{ $jurnals->total() }} Sesi
                </span>
            </div>

            <div style="font-size: 13px; color: #64748b; font-weight: 600;">
                Menampilkan tanggal: <strong style="color: #0f172a;">{{ $filterDateFormatted }}</strong>
            </div>
        </div>

        <!-- Filter & Pencarian -->
        <div class="filter-bar-container">
            <form action="{{ route('piket.jurnal-mengajar') }}" method="GET">
                <div class="filter-grid-row">
                    <div class="filter-input-text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari Mata Pelajaran / Guru / Kelas...">
                    </div>

                    <div>
                        <input type="date" name="tanggal" value="{{ $tanggalFilter }}" class="filter-select" title="Filter Tanggal Spesifik">
                    </div>

                    <div>
                        <select name="id_guru" class="filter-select">
                            <option value="">👤 Semua Guru</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}" {{ $idGuruFilter == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="id_kelas" class="filter-select">
                            <option value="">🏫 Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="id_mapel" class="filter-select">
                            <option value="">📖 Semua Mapel</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="status" class="filter-select">
                            <option value="">Status KBM</option>
                            <option value="terlaksana" {{ $statusFilter === 'terlaksana' ? 'selected' : '' }}>Terlaksana</option>
                            <option value="belum" {{ $statusFilter === 'belum' ? 'selected' : '' }}>Belum Terlaksana</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-filter-submit">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>

                    <a href="{{ route('piket.jurnal-mengajar') }}" class="btn-filter-reset">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabel Data Jurnal -->
        <div style="overflow-x: auto;">
            <table class="custom-jurnal-table">
                <thead>
                    <tr>
                        <th style="width: 100px;">Tanggal</th>
                        <th>Mata Pelajaran</th>
                        <th style="width: 115px;">Kelas &amp; Ruang</th>
                        <th>Guru Pengampu</th>
                        <th>Materi Pembelajaran</th>
                        <th style="width: 85px;">Pertemuan</th>
                        <th style="width: 110px; text-align: center;">Status KBM</th>
                        <th style="width: 125px; text-align: center;">Verifikasi Piket</th>
                        <th style="width: 85px; text-align: center;">Aksi</th>
=======
    <!-- 3. Main Data Panel (Daftar Jurnal Mengajar) -->
    <div class="main-data-card">
        <!-- Panel Header -->
        <div class="main-card-header">
            <div class="main-card-title-group">
                <div class="main-card-icon-badge">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
                <div>
                    <h2>Daftar Jurnal Mengajar</h2>
                    <p>Berikut adalah daftar kegiatan mengajar pada periode yang dipilih.</p>
                </div>
            </div>

            <a href="{{ route('piket.jurnal-mengajar.export', request()->query()) }}" class="btn-action-export" title="Ekspor data ke CSV">
                <i class="fa-solid fa-download"></i>
                <span>Export</span>
            </a>
        </div>

        <!-- Search & Filter Form Bar -->
        <form action="{{ route('piket.jurnal-mengajar') }}" method="GET" class="filter-section">
            <!-- Row 1: Search, Date, Guru, Kelas -->
            <div class="filter-row-top">
                <div class="filter-input-search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="q" value="{{ $search }}" class="filter-input-search" placeholder="Cari Mata Pelajaran / Guru / Kelas...">
                </div>

                <div class="filter-input-select-wrap" style="flex: 1; min-width: 140px;">
                    <input type="date" name="tgl_mulai" value="{{ $tglMulai }}" class="filter-date-input" title="Filter Tanggal Mulai">
                </div>

                <div class="filter-input-select-wrap">
                    <i class="fa-solid fa-user-tie select-icon-left"></i>
                    <select name="id_guru" class="filter-select">
                        <option value="">Semua Guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ $idGuruFilter == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-input-select-wrap">
                    <i class="fa-solid fa-school select-icon-left"></i>
                    <select name="id_kelas" class="filter-select">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 2: Mapel, Filter Submit & Reset -->
            <div class="filter-row-bottom">
                <div class="filter-input-select-wrap filter-input-mapel-wrap">
                    <i class="fa-solid fa-book select-icon-left"></i>
                    <select name="id_mapel" class="filter-select">
                        <option value="">Semua Mapel</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-actions-row">
                    <button type="submit" class="btn-filter-submit">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filter</span>
                    </button>

                    <a href="{{ route('piket.jurnal-mengajar') }}" class="btn-filter-reset">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset</span>
                    </a>
                </div>
            </div>
        </form>

        <!-- 4. Table Jurnal Mengajar -->
        <div class="table-responsive-box">
            <table class="table-jurnal-custom">
                <thead>
                    <tr>
                        <th style="width: 85px;">TANGGAL <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 145px;">MATA PELAJARAN <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 75px;">KELAS <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 160px;">GURU <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th>MATERI <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 95px;">PERTEMUAN <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 130px;">STATUS <span style="color:#94a3b8; font-size:10px;">↕</span></th>
                        <th style="width: 80px; text-align: center;">AKSI</th>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Palet warna pastel untuk variasi per baris / mapel sesuai screenshot
                        $colorPalette = [
                            ['bar' => '#38bdf8', 'bg' => '#e0f2fe', 'text' => '#0284c7'], // Blue / Sky (Dasar TKI)
                            ['bar' => '#f472b6', 'bg' => '#fce7f3', 'text' => '#db2777'], // Pink (Bahasa Inggris)
                            ['bar' => '#4ade80', 'bg' => '#dcfce7', 'text' => '#16a34a'], // Green (Pendidikan Pancasila)
                            ['bar' => '#a78bfa', 'bg' => '#ede9fe', 'text' => '#7c3aed'], // Purple (Bahasa Indonesia)
                            ['bar' => '#fb923c', 'bg' => '#ffedd5', 'text' => '#ea580c'], // Orange (Informatika)
                        ];
                    @endphp

                    @forelse($jurnals as $index => $row)
                        @php
<<<<<<< HEAD
                            $tgl = $row->tanggal ? \Carbon\Carbon::parse($row->tanggal) : null;
                            $dayStr = $tgl ? $tgl->format('d') : '-';
                            $monthStr = $tgl ? strtoupper($tgl->translatedFormat('M Y')) : '-';
                            
                            $isTerlaksana = ($row->status_kehadiran_guru ?? 'Hadir') === 'Hadir';
                            $verifRecord = $row->verifikasiPiket;
                            $isVerified = ($verifRecord && $verifRecord->status === 'terverifikasi');
=======
                            $tgl = !empty($row->tanggal) ? \Carbon\Carbon::parse($row->tanggal) : null;
                            $dayStr = $row->tanggal_formatted_day ?? ($tgl ? $tgl->format('d') : sprintf('%02d', $index + 1));
                            
                            $monthOnly = $tgl ? strtoupper($tgl->format('M')) : 'AUG';
                            $yearOnly  = $tgl ? $tgl->format('Y') : '2026';
                            if (!empty($row->tanggal_formatted_month)) {
                                $parts = explode(' ', trim($row->tanggal_formatted_month));
                                $monthOnly = $parts[0] ?? 'AUG';
                                $yearOnly  = $parts[1] ?? '2026';
                            }

                            $mapelNama = $row->mapel_nama ?? ($row->jadwal->mapel->nama_mapel ?? 'Mata Pelajaran');
                            $kelasNama = $row->kelas_nama ?? ($row->jadwal->kelas->nama_kelas ?? 'Kelas');
                            $guruNama  = $row->guru_nama ?? ($row->jadwal->guru->nama_guru ?? 'Guru Mengajar');
                            $materi    = $row->materi ?? '-';
                            $pertemuan = $row->pertemuan_ke ?? '12 / 36';
                            $statusText = $row->status_teks ?? ($row->status_kehadiran_guru ?? 'Terlaksana');
                            $isTerlaksana = in_array(strtolower($statusText), ['terlaksana', 'hadir', 'terisi']);

                            // Tentukan warna aksen berdasarkan hash mapel agar konsisten
                            $themeIndex = abs(crc32($mapelNama)) % count($colorPalette);
                            $theme = $colorPalette[$themeIndex];
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                        @endphp
                        <tr>
                            <!-- 1. TANGGAL dengan left accent colored bar -->
                            <td>
                                <div class="date-column-cell">
                                    <div class="date-accent-indicator" style="background-color: {{ $theme['bar'] }};"></div>
                                    <span class="date-day-large">{{ $dayStr }}</span>
                                    <div class="date-my-group">
                                        <span>{{ $monthOnly }}</span>
                                        <span>{{ $yearOnly }}</span>
                                    </div>
                                </div>
                            </td>

<<<<<<< HEAD
                            <td>
                                <strong style="color: #0f172a; font-size: 13.5px;">{{ $row->jadwal->mapel->nama_mapel ?? ($row->mapel_nama ?? '-') }}</strong>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                    Jam ke-{{ $row->jadwal->jam_range ?? ($row->jam_ke ?? '-') }} &bull; {{ $row->jadwal->waktu_mulai_effective ?? '07:00' }} - {{ $row->jadwal->waktu_selesai_effective ?? '08:20' }} WIB
                                </div>
                            </td>

                            <td>
                                <strong style="color: #1e293b;">{{ $row->jadwal->kelas->nama_kelas ?? ($row->kelas_nama ?? '-') }}</strong>
                                <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                    <i class="fa-solid fa-location-dot" style="font-size: 10px; color: #3b82f6;"></i> {{ $row->jadwal->ruangan->nama_ruangan ?? 'Ruang Kelas' }}
                                </div>
                            </td>

                            <td>
                                @if($row->id_guru_pengganti && $row->guruPengganti)
                                    <strong style="color: #0f172a;">{{ $row->guruPengganti->nama_guru }}</strong>
                                    <div style="font-size: 10.5px; color: #2563eb; font-weight: 700; margin-top: 1px;">
                                        <i class="fa-solid fa-user-shield"></i> Guru Pengganti
                                    </div>
                                    <div style="font-size: 10px; color: #64748b;">(Guru Utama: {{ $row->jadwal->guru->nama_guru ?? '-' }})</div>
                                @else
                                    <strong style="color: #0f172a;">{{ $row->jadwal->guru->nama_guru ?? ($row->guru_nama ?? '-') }}</strong>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 1px;">
                                        NIP: {{ $row->jadwal->guru->nip ?? '-' }}
                                    </div>
                                @endif
                            </td>

                            <td style="max-width: 260px;">
                                <div style="font-weight: 600; color: #1e293b; line-height: 1.35;">
                                    {{ Str::limit($row->materi ?? '-', 75) }}
                                </div>
                                @if($row->kondisi_kelas)
                                    <span style="font-size: 10.5px; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 1px 6px; border-radius: 4px; display: inline-block; margin-top: 3px;">
                                        Kondisi: {{ $row->kondisi_kelas }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                <span style="font-weight: 800; color: #0f172a;">{{ $row->pertemuan_ke ?? 'Ke-1' }}</span>
                                <div style="font-size: 11px; color: #64748b;">
                                    {{ $row->jadwal->jumlah_jp ?? 2 }} JP
                                </div>
                            </td>

                            <td style="text-align: center;">
                                <span class="badge-status-pill {{ $isTerlaksana ? 'badge-terlaksana' : 'badge-belum-terlaksana' }}">
                                    <i class="fa-solid {{ $isTerlaksana ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                    {{ $isTerlaksana ? 'Terlaksana' : 'Belum' }}
                                </span>
                            </td>

                            <td style="text-align: center;">
                                @if($isVerified)
                                    <span class="badge-status-pill badge-verif-yes" title="Diverifikasi oleh: {{ $verifRecord->nama_guru_piket }}">
                                        <i class="fa-solid fa-signature"></i> Terverifikasi
                                    </span>
                                @else
                                    <span class="badge-status-pill badge-verif-no">
                                        <i class="fa-solid fa-hourglass-half"></i> Menunggu TTD
=======
                            <!-- 2. MATA PELAJARAN dengan pastel pill badge -->
                            <td>
                                <span class="mapel-pill-badge" style="background-color: {{ $theme['bg'] }}; color: {{ $theme['text'] }};">
                                    {{ $mapelNama }}
                                </span>
                            </td>

                            <!-- 3. KELAS -->
                            <td>
                                <span style="font-weight: 600; color: #475569;">{{ $kelasNama }}</span>
                            </td>

                            <!-- 4. GURU -->
                            <td>
                                <span style="font-weight: 600; color: #1e293b;">{{ $guruNama }}</span>
                            </td>

                            <!-- 5. MATERI -->
                            <td>
                                <span style="color: #64748b; font-size: 12px; font-weight: 500; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;" title="{{ $materi }}">
                                    {{ $materi }}
                                </span>
                            </td>

                            <!-- 6. PERTEMUAN -->
                            <td>
                                <span style="font-weight: 600; color: #475569; font-size: 12px;">{{ $pertemuan }}</span>
                            </td>

                            <!-- 7. STATUS -->
                            <td>
                                @if($isTerlaksana)
                                    <span class="status-badge-terlaksana">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>Terlaksana</span>
                                    </span>
                                @else
                                    <span class="status-badge-belum">
                                        <i class="fa-regular fa-clock"></i>
                                        <span>Belum Terlaksana</span>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                                    </span>
                                @endif
                            </td>

<<<<<<< HEAD
                            <td style="text-align: center;">
                                <button type="button" class="btn-action-icon" onclick="openJurnalDetailModal({{ $row->id_jurnal }})" title="Lihat Detail Lengkap Jurnal & Presensi">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
=======
                            <!-- 8. AKSI -->
                            <td style="text-align: center;">
                                <div class="table-actions-cluster">
                                    <button type="button" class="btn-icon-table-action" 
                                            onclick="openDetailModal('{{ $row->id_jurnal ?? $index }}', '{{ addslashes($guruNama) }}', '{{ addslashes($mapelNama) }}', '{{ addslashes($kelasNama) }}', '{{ addslashes($dayStr . ' ' . $monthOnly . ' ' . $yearOnly) }}', '{{ addslashes($materi) }}', '{{ $isTerlaksana ? 'Terlaksana' : 'Belum Terlaksana' }}')" 
                                            title="Lihat Detail Jurnal">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn-icon-table-action" 
                                            onclick="openDetailModal('{{ $row->id_jurnal ?? $index }}', '{{ addslashes($guruNama) }}', '{{ addslashes($mapelNama) }}', '{{ addslashes($kelasNama) }}', '{{ addslashes($dayStr . ' ' . $monthOnly . ' ' . $yearOnly) }}', '{{ addslashes($materi) }}', '{{ $isTerlaksana ? 'Terlaksana' : 'Belum Terlaksana' }}')"
                                            title="Opsi Lainnya">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                </div>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                            </td>
                        </tr>
                    @empty
                        <tr>
<<<<<<< HEAD
                            <td colspan="9" style="text-align: center; color: #94a3b8; padding: 45px 20px;">
                                <i class="fa-regular fa-folder-open" style="font-size: 38px; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                                Tidak ada data jurnal mengajar yang sesuai dengan filter pencarian.
=======
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 36px 20px;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <i class="fa-regular fa-folder-open" style="font-size: 32px; color: #cbd5e1;"></i>
                                    <span style="font-weight: 600; font-size: 13.5px;">Tidak ada data jurnal mengajar yang sesuai filter.</span>
                                    <a href="{{ route('piket.jurnal-mengajar') }}" class="btn-filter-reset" style="margin-top: 6px;">Reset Filter</a>
                                </div>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

<<<<<<< HEAD
        <!-- Pagination -->
        <div style="margin-top: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div style="font-size: 13px; color: #64748b; font-weight: 600;">
                Menampilkan {{ $jurnals->firstItem() ?? 0 }} - {{ $jurnals->lastItem() ?? 0 }} dari {{ $jurnals->total() }} data jurnal
            </div>
            <div>
                {{ $jurnals->links() }}
=======
        <!-- 5. Table Footer & Pagination -->
        <div class="table-pagination-footer">
            <div class="pagination-records-info">
                Menampilkan 1 - {{ min(count($jurnals), 10) }} dari {{ $stats['totalPertemuan'] ?? count($jurnals) }} data
            </div>

            <div class="pagination-pills-list">
                <a href="#" class="pagination-pill-btn" title="Halaman Pertama">&laquo;</a>
                <a href="#" class="pagination-pill-btn" title="Halaman Sebelumnya">&lsaquo;</a>
                <a href="#" class="pagination-pill-btn active">1</a>
                <a href="#" class="pagination-pill-btn">2</a>
                <a href="#" class="pagination-pill-btn">3</a>
                <a href="#" class="pagination-pill-btn">4</a>
                <a href="#" class="pagination-pill-btn">5</a>
                <a href="#" class="pagination-pill-btn" title="Halaman Berikutnya">&rsaquo;</a>
                <a href="#" class="pagination-pill-btn" title="Halaman Terakhir">&raquo;</a>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
            </div>
        </div>
    </div>

    </div>
    <!-- ==================== END DESKTOP VIEW ==================== -->

    <!-- ==================== MOBILE VIEW ==================== -->
    <div class="mobile-jurnal-view">

        <!-- ─── MOBILE TOPBAR (TITLE + CSV EXPORT PILL) ─── -->
        <div class="mobile-page-topbar">
            <div class="mobile-topbar-title-wrap">
                <h1 class="mobile-topbar-title">Jurnal Mengajar</h1>
                <span class="mobile-topbar-sub">Pantau dan kelola seluruh aktivitas jurnal mengajar</span>
            </div>
            <div class="mobile-topbar-right">
                <a href="{{ route('piket.jurnal-mengajar.export') }}" class="m-btn-pill-action" title="Ekspor CSV">
                    <i class="fa-solid fa-file-arrow-down" style="color: #2563eb;"></i>
                    <span>CSV</span>
                </a>
            </div>
        </div>

        <!-- 1. Banner Carousel "Halo, Petugas Piket!" (5 Slides with Exact Desktop Themes) -->
        <div class="mobile-carousel-container">
            <div class="mobile-carousel-track" id="mobileCarouselTrack">
                <!-- Slide 1: Welcome Greeting -->
                <div class="mobile-carousel-slide m-slide-welcome">
                    <div style="position: relative; z-index: 2;">
                        <span class="m-slide-pill">Petugas Piket</span>
                        <h1 class="m-slide-title">Halo, {{ Auth::user()->name ?? 'Petugas Piket' }}! <span class="wave-hand">👋</span></h1>
                        <p class="m-slide-subtitle">Pantau dan kelola seluruh aktivitas jurnal mengajar di sini.</p>
                    </div>
                    <div class="m-slide-welcome-circle"></div>
                </div>

                <!-- Slide 2: Total Pertemuan (Blue Theme) -->
                <div class="mobile-carousel-slide m-slide-blue">
                    <div style="position: relative; z-index: 2;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                            <span class="m-slide-pill">Statistik KBM</span>
                            <span class="m-slide-label">Total Pertemuan</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px; margin-top: 2px;">
                            <div class="stat-icon-box icon-box-blue" style="width: 42px; height: 42px; border-radius: 13px;">
                                <svg width="22" height="22" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="3.5" y="5.5" width="21" height="18.5" rx="5" stroke="#2563eb" stroke-width="2.3"/>
                                    <path d="M3.5 11.5H24.5" stroke="#2563eb" stroke-width="2.3" stroke-linecap="round"/>
                                    <path d="M8.5 3.5V6.5" stroke="#2563eb" stroke-width="2.3" stroke-linecap="round"/>
                                    <path d="M19.5 3.5V6.5" stroke="#2563eb" stroke-width="2.3" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div>
                                <div style="display: flex; align-items: baseline; gap: 5px;">
                                    <span style="font-size: 25px; font-weight: 800; color: #1e293b; line-height: 1.1;">{{ $stats['totalPertemuan'] }}</span>
                                    <span style="font-size: 12.5px; font-weight: 600; color: #64748b;">Pertemuan</span>
                                </div>
                                <div style="font-size: 10.5px; font-weight: 500; color: #94a3b8; margin-top: 2px;">Seluruh pertemuan pada periode ini</div>
                            </div>
                        </div>
                    </div>
                    <div class="stat-corner-elem" style="top: 10px; right: 12px;">
                        <svg width="30" height="20" viewBox="0 0 36 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 18 C 10 18, 16 10, 20 6 C 24 2, 28 4, 28 8 C 28 13, 23 16, 18 14 C 15 12, 16 7, 21 5 C 26 3, 31 8, 33 11" stroke="#60a5fa" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" opacity="0.85"/>
                        </svg>
                    </div>
                    <svg class="stat-card-wave wave-theme-blue" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
                    </svg>
                </div>

                <!-- Slide 3: Terlaksana (Emerald Theme) -->
                <div class="mobile-carousel-slide m-slide-emerald">
                    <div style="position: relative; z-index: 2;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                            <span class="m-slide-pill">Statistik KBM</span>
                            <span class="m-slide-label">Terlaksana</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px; margin-top: 2px;">
                            <div class="stat-icon-box icon-box-emerald" style="width: 42px; height: 42px; border-radius: 13px;">
                                <svg width="22" height="22" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="14" r="10.5" stroke="#059669" stroke-width="2.3"/>
                                    <path d="M9.5 14L12.5 17L18.5 11" stroke="#059669" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div>
                                <div style="display: flex; align-items: baseline; gap: 5px;">
                                    <span style="font-size: 25px; font-weight: 800; color: #1e293b; line-height: 1.1;">{{ $stats['terlaksana'] }}</span>
                                    <span style="font-size: 12.5px; font-weight: 600; color: #64748b;">Pertemuan</span>
                                </div>
                                <div style="font-size: 10.5px; font-weight: 500; color: #94a3b8; margin-top: 2px;">Seluruh pertemuan pada periode ini</div>
                            </div>
                        </div>
                    </div>
                    <div class="stat-corner-elem" style="top: 10px; right: 12px; display: flex; gap: 3px; color: #34d399;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                        <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 4px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    </div>
                    <svg class="stat-card-wave wave-theme-emerald" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
                    </svg>
                </div>

                <!-- Slide 4: Belum Terlaksana (Amber Theme) -->
                <div class="mobile-carousel-slide m-slide-amber">
                    <div style="position: relative; z-index: 2;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                            <span class="m-slide-pill">Perlu Perhatian</span>
                            <span class="m-slide-label">Belum Terlaksana</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px; margin-top: 2px;">
                            <div class="stat-icon-box icon-box-amber" style="width: 42px; height: 42px; border-radius: 13px;">
                                <svg width="22" height="22" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="14" r="10.5" stroke="#ea580c" stroke-width="2.3"/>
                                    <path d="M14 8.5V14H18" stroke="#ea580c" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div>
                                <div style="display: flex; align-items: baseline; gap: 5px;">
                                    <span style="font-size: 25px; font-weight: 800; color: #1e293b; line-height: 1.1;">{{ $stats['belumTerlaksana'] }}</span>
                                    <span style="font-size: 12.5px; font-weight: 600; color: #64748b;">Pertemuan</span>
                                </div>
                                <div style="font-size: 10.5px; font-weight: 500; color: #94a3b8; margin-top: 2px;"><strong style="color: #ea580c; font-weight: 700;">{{ $stats['pctBelum'] }}%</strong> dari total pertemuan</div>
                            </div>
                        </div>
                    </div>
                    <div class="stat-corner-elem" style="top: 10px; right: 12px; display: flex; gap: 3px; color: #fb923c;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                        <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 4px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    </div>
                    <svg class="stat-card-wave wave-theme-amber" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
                    </svg>
                </div>

                <!-- Slide 5: Guru Aktif (Purple Theme) -->
                <div class="mobile-carousel-slide m-slide-purple">
                    <div style="position: relative; z-index: 2;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                            <span class="m-slide-pill">Tenaga Pendidik</span>
                            <span class="m-slide-label">Guru Aktif</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px; margin-top: 2px;">
                            <div class="stat-icon-box icon-box-purple" style="width: 42px; height: 42px; border-radius: 13px;">
                                <svg width="22" height="22" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="9.5" r="4.5" stroke="#7c3aed" stroke-width="2.3"/>
                                    <path d="M6 22C6 18.134 9.58172 15 14 15C18.4183 15 22 18.134 22 22" stroke="#7c3aed" stroke-width="2.3" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div>
                                <div style="display: flex; align-items: baseline; gap: 5px;">
                                    <span style="font-size: 25px; font-weight: 800; color: #1e293b; line-height: 1.1;">{{ $stats['guruAktif'] }}</span>
                                    <span style="font-size: 12.5px; font-weight: 600; color: #64748b;">Guru</span>
                                </div>
                                <div style="font-size: 10.5px; font-weight: 500; color: #94a3b8; margin-top: 2px;">Mengajar pada periode ini</div>
                            </div>
                        </div>
                    </div>
                    <div class="stat-corner-elem" style="top: 10px; right: 12px; display: flex; gap: 3px; color: #a78bfa;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                        <svg width="8" height="8" viewBox="0 0 24 24" fill="currentColor" style="margin-top: 4px;"><path d="M12 0L14.5 9.5L24 12L14.5 14.5L12 24L9.5 14.5L0 12L9.5 9.5L12 0Z"/></svg>
                    </div>
                    <svg class="stat-card-wave wave-theme-purple" viewBox="0 0 140 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <path d="M0 70 C 45 70, 70 48, 90 30 C 110 12, 125 4, 140 0 L 140 70 Z" fill="currentColor"/>
                    </svg>
                </div>
            </div>

            <!-- Navigation Arrows (Always visible and tap-able on mobile) -->
            <button type="button" class="m-carousel-arrow m-carousel-prev" onclick="moveCarousel(-1)" aria-label="Slide Sebelumnya">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button type="button" class="m-carousel-arrow m-carousel-next" onclick="moveCarousel(1)" aria-label="Slide Berikutnya">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <!-- Carousel Indicator Dots -->
        <div class="mobile-carousel-dots" id="carouselDots">
            <span class="m-dot active" onclick="jumpToSlide(0)"></span>
            <span class="m-dot" onclick="jumpToSlide(1)"></span>
            <span class="m-dot" onclick="jumpToSlide(2)"></span>
            <span class="m-dot" onclick="jumpToSlide(3)"></span>
            <span class="m-dot" onclick="jumpToSlide(4)"></span>
        </div>

        <!-- 2. Card "Daftar Jurnal Mengajar" -->
        <div class="mobile-search-filter-card">
            <!-- Row 1: Title + Export -->
            <div class="mobile-search-filter-top">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div class="m-card-icon-wrap">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </div>
                    <h2 style="font-size: 14.5px; font-weight: 800; color: #0f172a; margin: 0;">Daftar Jurnal Mengajar</h2>
                </div>
                <a href="{{ route('piket.jurnal-mengajar.export', request()->query()) }}" class="m-btn-export" title="Ekspor data ke CSV">
                    <i class="fa-solid fa-download"></i>
                    <span>Export</span>
                </a>
            </div>

            <!-- Row 2: Search Input + Blue Filter Button -->
            <div class="mobile-search-filter-bottom">
                <form action="{{ route('piket.jurnal-mengajar') }}" method="GET" class="m-search-form">
                    @if($tglMulai)<input type="hidden" name="tgl_mulai" value="{{ $tglMulai }}">@endif
                    @if($idGuruFilter)<input type="hidden" name="id_guru" value="{{ $idGuruFilter }}">@endif
                    @if($idKelasFilter)<input type="hidden" name="id_kelas" value="{{ $idKelasFilter }}">@endif
                    @if($idMapelFilter)<input type="hidden" name="id_mapel" value="{{ $idMapelFilter }}">@endif

                    <div class="m-search-input-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari Mapel / Guru / Kelas..." class="m-search-input">
                    </div>
                    <button type="button" class="m-btn-filter-trigger" onclick="openMobileFilterModal()">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filter</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- 3. List of Journal Cards -->
        <div class="mobile-jurnal-cards-list">
            @php
                // Palet warna pastel untuk variasi per baris / mapel persis sesuai tabel desktop
                $colorPalette = [
                    ['bar' => '#38bdf8', 'bg' => '#e0f2fe', 'text' => '#0284c7'], // Blue / Sky (Dasar TKI)
                    ['bar' => '#f472b6', 'bg' => '#fce7f3', 'text' => '#db2777'], // Pink (Bahasa Inggris)
                    ['bar' => '#4ade80', 'bg' => '#dcfce7', 'text' => '#16a34a'], // Green (Pendidikan Pancasila)
                    ['bar' => '#a78bfa', 'bg' => '#ede9fe', 'text' => '#7c3aed'], // Purple (Bahasa Indonesia)
                    ['bar' => '#fb923c', 'bg' => '#ffedd5', 'text' => '#ea580c'], // Orange (Informatika)
                ];
            @endphp

            @forelse($jurnals as $index => $row)
                @php
                    $tgl = !empty($row->tanggal) ? \Carbon\Carbon::parse($row->tanggal) : null;
                    $dayStr = $row->tanggal_formatted_day ?? ($tgl ? $tgl->format('d') : sprintf('%02d', $index + 1));
                    
                    $monthOnly = $tgl ? strtoupper($tgl->format('M')) : 'AUG';
                    $yearOnly  = $tgl ? $tgl->format('Y') : '2026';
                    if (!empty($row->tanggal_formatted_month)) {
                        $parts = explode(' ', trim($row->tanggal_formatted_month));
                        $monthOnly = $parts[0] ?? 'AUG';
                        $yearOnly  = $parts[1] ?? '2026';
                    }

                    $mapelNama = $row->mapel_nama ?? ($row->jadwal->mapel->nama_mapel ?? 'Mata Pelajaran');
                    $kelasNama = $row->kelas_nama ?? ($row->jadwal->kelas->nama_kelas ?? 'Kelas');
                    $guruNama  = $row->guru_nama ?? ($row->jadwal->guru->nama_guru ?? 'Guru Mengajar');
                    $materi    = $row->materi ?? '-';
                    $pertemuan = $row->pertemuan_ke ?? '12 / 36';
                    $statusText = $row->status_teks ?? ($row->status_kehadiran_guru ?? 'Terlaksana');
                    $isTerlaksana = in_array(strtolower($statusText), ['terlaksana', 'hadir', 'terisi']);

                    // Tentukan warna aksen berdasarkan hash mapel identik dengan tabel desktop
                    $themeIndex = abs(crc32($mapelNama)) % count($colorPalette);
                    $theme = $colorPalette[$themeIndex];
                @endphp

                <div class="mobile-jurnal-card-item {{ $isTerlaksana ? 'card-terlaksana' : 'card-belum' }}" style="border-left: 3.5px solid {{ $isTerlaksana ? $theme['bar'] : '#e11d48' }};">
                    <!-- Left: Large Stacked Date -->
                    <div class="mobile-card-date-col {{ $isTerlaksana ? 'date-terlaksana' : 'date-belum' }}">
                        <span class="m-date-day">{{ $dayStr }}</span>
                        <span class="m-date-month">{{ $monthOnly }}</span>
                        <span class="m-date-year">{{ $yearOnly }}</span>
                    </div>

                    <!-- Right: Details Stack -->
                    <div class="mobile-card-content">
                        <!-- Row 1: Status badge & Mapel badge (Identical to Desktop) -->
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px;">
                            @if($isTerlaksana)
                                <span class="status-badge-terlaksana">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Terlaksana</span>
                                </span>
                            @else
                                <span class="status-badge-belum">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>Belum Terlaksana</span>
                                </span>
                            @endif

                            <span class="mapel-pill-badge" style="background-color: {{ $theme['bg'] }}; color: {{ $theme['text'] }};">
                                {{ $mapelNama }}
                            </span>
                        </div>

                        <!-- Row 2: Kelas & Pertemuan -->
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px; font-size: 12px; margin-top: 2px;">
                            <div>
                                <span style="color: #64748b; font-weight: 600;">Kelas:</span>
                                <strong style="color: #2563eb; font-weight: 700; margin-left: 2px;">{{ $kelasNama }}</strong>
                            </div>
                            <div style="color: #64748b; font-size: 11.5px; font-weight: 600;">
                                Pertemuan <strong style="color: #1e293b; font-weight: 700;">{{ $pertemuan }}</strong>
                            </div>
                        </div>

                        <!-- Row 3: Teacher Icon + Name & Lihat Detail link -->
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px; font-size: 11.5px; margin-top: 2px;">
                            <div style="display: flex; align-items: center; gap: 5px; color: #1e293b; min-width: 0; flex: 1;">
                                <i class="fa-regular fa-user" style="color: #94a3b8; font-size: 11px; flex-shrink: 0;"></i>
                                <span style="font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #1e293b;">{{ $guruNama }}</span>
                            </div>
                            <button type="button" class="m-btn-lihat-detail {{ $isTerlaksana ? 'btn-detail-blue' : 'btn-detail-red' }}" 
                                    onclick="openDetailModal('{{ $row->id_jurnal ?? $index }}', '{{ addslashes($guruNama) }}', '{{ addslashes($mapelNama) }}', '{{ addslashes($kelasNama) }}', '{{ addslashes($dayStr . ' ' . $monthOnly . ' ' . $yearOnly) }}', '{{ addslashes($materi) }}', '{{ $isTerlaksana ? 'Terlaksana' : 'Belum Terlaksana' }}')">
                                <span>Lihat Detail</span>
                                <i class="fa-solid fa-chevron-right" style="font-size: 9.5px; margin-left: 2px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 30px 16px; text-align: center; color: #94a3b8;">
                    <i class="fa-regular fa-folder-open" style="font-size: 28px; color: #cbd5e1; margin-bottom: 8px;"></i>
                    <p style="font-size: 12.5px; font-weight: 600; margin: 0;">Tidak ada data jurnal mengajar.</p>
                </div>
            @endforelse
        </div>

        <!-- 4. Mobile Pagination Card -->
        <div class="mobile-pagination-card">
            <div style="font-size: 12px; color: #64748b; font-weight: 600;">
                Data <strong style="color: #0f172a;">1 - {{ min(count($jurnals), 5) }}</strong> dari <strong style="color: #0f172a;">{{ $stats['totalPertemuan'] ?? count($jurnals) }}</strong>
            </div>
            <div class="m-pagination-pills">
                <a href="#" class="m-pag-btn" title="Sebelumnya">&lsaquo;</a>
                <a href="#" class="m-pag-btn active">1</a>
                <a href="#" class="m-pag-btn">2</a>
                <a href="#" class="m-pag-btn">3</a>
                <a href="#" class="m-pag-btn" title="Berikutnya">&rsaquo;</a>
            </div>
        </div>

    </div>
    <!-- ==================== END MOBILE VIEW ==================== -->

</div>

<<<<<<< HEAD
<!-- ========================================================================= -->
<!-- MODAL 1: TANDA TANGAN GURU PIKET HARIAN (CANVAS SIGNATURE PAD INTERAKTIF) -->
<!-- ========================================================================= -->
<div id="signatureModal" class="custom-modal-backdrop">
    <div class="custom-modal-box">
        <div class="modal-header-styled">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 17px;">
                    <i class="fa-solid fa-pen-nib"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">Tanda Tangan Pengesahan Guru Piket</h3>
                    <p style="margin: 0; font-size: 12px; color: #64748b;">Pengesahan resmi seluruh jurnal mengajar pada tanggal terpilih</p>
                </div>
            </div>
            <button type="button" onclick="closeSignatureModal()" style="background: none; border: none; font-size: 22px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form action="{{ route('piket.jurnal-mengajar.tanda-tangan') }}" method="POST" id="formSignaturePiket" onsubmit="return validateSignatureSubmit()">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $dateForSignature }}">
            <input type="hidden" name="tanda_tangan" id="inputTandaTanganBase64">

            <div class="modal-body-styled">
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 12px 16px; margin-bottom: 18px; font-size: 12.5px; color: #1e40af; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-info" style="font-size: 18px; flex-shrink: 0;"></i>
                    <span>Tanda tangan ini berlaku untuk <strong>seluruh {{ $stats['totalPertemuan'] }} Jurnal Mengajar</strong> yang terkirim pada hari <strong>{{ $sigDateFormatted }}</strong>.</span>
                </div>

                <!-- 1. Pilihan Guru Piket yang Menandatangani -->
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                        Pilih Guru Piket yang Menandatangani <span style="color: #dc2626;">*</span>
                    </label>
                    <select name="id_guru" id="selectGuruPiketTtd" required style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; font-weight: 600; color: #0f172a; outline: none; background: #fff;">
                        <option value="">-- Pilih Guru Piket --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}" {{ ($defaultGuruPiket && $defaultGuruPiket->id_guru == $g->id_guru) ? 'selected' : '' }}>
                                {{ $g->nama_guru }} {{ $g->nip ? '(NIP: ' . $g->nip . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 2. Interactive Signature Pad Canvas -->
                <div style="margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                        <label style="font-size: 13px; font-weight: 700; color: #1e293b;">
                            Bubuhkan Tanda Tangan Digital <span style="color: #dc2626;">*</span>
                        </label>
                        <button type="button" onclick="clearSignatureCanvas()" style="background: none; border: none; font-size: 12px; color: #dc2626; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-rotate-left"></i> Bersihkan
                        </button>
                    </div>

                    <div class="signature-pad-wrapper" id="sigPadWrapper">
                        <canvas id="sigCanvas" class="signature-canvas"></canvas>
                        <div class="signature-placeholder-text" id="sigPlaceholder">
                            <i class="fa-solid fa-signature"></i> Gambar tanda tangan Anda di sini menggunakan mouse / sentuhan jari
                        </div>
                    </div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                        Goreskan pena tanda tangan secara langsung di dalam kotak di atas.
                    </div>
                </div>

                <!-- 3. Catatan Evaluasi Pembelajaran Hari Ini -->
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                        Catatan Evaluasi KBM Guru Piket (Opsional)
                    </label>
                    <textarea name="catatan" rows="3" placeholder="Contoh: KBM terlaksana tertib, kelas XI RPL 1 didampingi guru pengganti karena guru pengampu izin dinas luar..." style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 13px; outline: none; box-sizing: border-box; resize: vertical; font-family: inherit; color: #1e293b;"></textarea>
                </div>

                <!-- 4. Checkbox Pernyataan Keabsahan Dokumen -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
                    <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-size: 12.5px; color: #334155; line-height: 1.4;">
                        <input type="checkbox" id="checkPernyataanSah" required style="margin-top: 2px; cursor: pointer;">
                        <span>Dengan ini saya menyatakan sebagai <strong>Guru Piket</strong> telah memeriksa, memvalidasi, dan memastikan kebenaran seluruh laporan Jurnal Mengajar pada tanggal ini sebagai dokumen administrasi sekolah resmi.</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer-styled">
                <button type="button" onclick="closeSignatureModal()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #475569; padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer;">Batal</button>
                <button type="submit" class="btn-signature-action">
                    <i class="fa-solid fa-check"></i> Simpan &amp; Sahkan Tanda Tangan
=======
<!-- Modal Modern Filter Jurnal Mengajar (Mobile) -->
<div id="mobileFilterModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(3px); z-index: 9999; align-items: center; justify-content: center; padding: 16px;">
    <div class="mobile-filter-modal-card">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 34px; height: 34px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                    <i class="fa-solid fa-filter"></i>
                </div>
                <div>
                    <h3 style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 0;">Filter Jurnal Mengajar</h3>
                    <p style="font-size: 11.5px; color: #64748b; margin: 2px 0 0 0;">Sesuaikan kriteria data yang ingin ditampilkan</p>
                </div>
            </div>
            <button type="button" onclick="closeMobileFilterModal()" style="background: #f1f5f9; border: none; width: 30px; height: 30px; border-radius: 8px; font-size: 16px; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form action="{{ route('piket.jurnal-mengajar') }}" method="GET" style="display: flex; flex-direction: column; gap: 12px;">
            @if($search)<input type="hidden" name="q" value="{{ $search }}">@endif
            
            <div>
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 5px;">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" value="{{ $tglMulai }}" class="m-filter-field">
            </div>

            <div>
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 5px;">Guru Pengajar</label>
                <select name="id_guru" class="m-filter-field">
                    <option value="">Semua Guru</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id_guru }}" {{ $idGuruFilter == $g->id_guru ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 5px;">Mata Pelajaran</label>
                <select name="id_mapel" class="m-filter-field">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}" {{ $idMapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 5px;">Kelas</label>
                <select name="id_kelas" class="m-filter-field">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id_kelas }}" {{ $idKelasFilter == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 8px; margin-top: 6px;">
                <a href="{{ route('piket.jurnal-mengajar') }}" class="m-btn-filter-reset">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Reset</span>
                </a>
                <button type="submit" class="m-btn-filter-submit">
                    <i class="fa-solid fa-filter"></i>
                    <span>Terapkan</span>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
                </button>
            </div>
        </form>
    </div>
</div>

<<<<<<< HEAD
<!-- ========================================================================= -->
<!-- MODAL 2: DETAIL LENGKAP JURNAL MENGAJAR (AJAX COMPREHENSIVE VIEW)        -->
<!-- ========================================================================= -->
<div id="jurnalDetailModal" class="custom-modal-backdrop">
    <div class="custom-modal-box" style="max-width: 720px;">
        <div class="modal-header-styled">
            <div>
                <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: #0f172a;" id="mdMapelKelas">-</h3>
                <p style="margin: 0; font-size: 12px; color: #64748b;" id="mdTanggalJam">-</p>
            </div>
            <button type="button" onclick="closeJurnalDetailModal()" style="background: none; border: none; font-size: 22px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <div class="modal-body-styled" id="mdLoadingState" style="text-align: center; padding: 40px;">
            <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 32px; color: #2563eb;"></i>
            <div style="margin-top: 10px; font-size: 13px; color: #64748b; font-weight: 600;">Memuat data lengkap jurnal mengajar...</div>
        </div>

        <div class="modal-body-styled" id="mdContentState" style="display: none;">
            
            <!-- Grid Data KBM -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 18px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b;">GURU PENGAMPU</div>
                    <div style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 2px;" id="mdGuru">-</div>
                    <div style="font-size: 11px; color: #64748b;" id="mdNipGuru">NIP: -</div>
                    <div id="mdBadgeGuruPengganti" style="display: none; margin-top: 4px;">
                        <span style="font-size: 10.5px; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 2px 6px; border-radius: 4px; font-weight: 700;">
                            <i class="fa-solid fa-user-shield"></i> Guru Pengganti: <span id="mdNamaPengganti">-</span>
                        </span>
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b;">ALOKASI WAKTU &amp; KELAS</div>
                    <div style="font-size: 14px; font-weight: 800; color: #0f172a; margin-top: 2px;" id="mdAlokasi">-</div>
                    <div style="font-size: 11px; color: #64748b;" id="mdRuangan">Ruangan: -</div>
                    <div style="margin-top: 4px;">
                        <span id="mdBadgeStatusKbm" class="badge-status-pill badge-terlaksana">Terlaksana</span>
                    </div>
                </div>
            </div>

            <!-- Materi & Catatan Pembelajaran -->
            <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 18px; background: #ffffff;">
                <div style="margin-bottom: 10px;">
                    <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Materi yang Diajarkan:</div>
                    <div style="font-size: 14.5px; font-weight: 700; color: #0f172a; margin-top: 2px;" id="mdMateri">-</div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; padding-top: 10px; border-top: 1px dashed #e2e8f0;">
                    <div>
                        <div style="font-size: 11px; font-weight: 700; color: #64748b;">KONDISI KELAS:</div>
                        <div style="font-size: 13px; font-weight: 700; color: #1e293b;" id="mdKondisiKelas">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 700; color: #64748b;">CATATAN GURU:</div>
                        <div style="font-size: 12.5px; color: #334155;" id="mdCatatanGuru">-</div>
                    </div>
                </div>
            </div>

            <!-- Foto Kehadiran Live Kamera -->
            <div id="mdFotoWrap" style="margin-bottom: 18px; display: none;">
                <div style="font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">
                    <i class="fa-solid fa-camera" style="color: #2563eb;"></i> Foto Kehadiran KBM (Live Kamera)
                </div>
                <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 8px; background: #f8fafc; text-align: center;">
                    <img id="mdFotoImg" src="" alt="Foto Kehadiran" style="max-height: 220px; max-width: 100%; border-radius: 8px; object-fit: contain;">
                </div>
            </div>

            <!-- Presensi Siswa -->
            <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 18px; background: #ffffff;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <div style="font-size: 13px; font-weight: 800; color: #0f172a;">
                        <i class="fa-solid fa-users" style="color: #2563eb;"></i> Presensi Kehadiran Siswa
                    </div>
                    <div style="font-size: 12px; color: #64748b; font-weight: 600;" id="mdTotalSiswaTeks">
                        Total: 0 Siswa
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 12px;">
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 8px; text-align: center;">
                        <div style="font-size: 11px; color: #166534; font-weight: 700;">HADIR</div>
                        <div style="font-size: 18px; font-weight: 800; color: #15803d;" id="mdHadirCount">0</div>
                    </div>
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 8px; text-align: center;">
                        <div style="font-size: 11px; color: #1e40af; font-weight: 700;">SAKIT</div>
                        <div style="font-size: 18px; font-weight: 800; color: #2563eb;" id="mdSakitCount">0</div>
                    </div>
                    <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 8px; text-align: center;">
                        <div style="font-size: 11px; color: #92400e; font-weight: 700;">IZIN</div>
                        <div style="font-size: 18px; font-weight: 800; color: #d97706;" id="mdIzinCount">0</div>
                    </div>
                    <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 8px; text-align: center;">
                        <div style="font-size: 11px; color: #991b1b; font-weight: 700;">ALPA</div>
                        <div style="font-size: 18px; font-weight: 800; color: #dc2626;" id="mdAlpaCount">0</div>
                    </div>
                </div>

                <div id="mdDaftarAbsenWrap" style="display: none;">
                    <div style="font-size: 11.5px; font-weight: 700; color: #64748b; margin-bottom: 6px;">Daftar Siswa Tidak Hadir:</div>
                    <div style="max-height: 120px; overflow-y: auto; border: 1px solid #f1f5f9; border-radius: 8px;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                            <tbody id="mdDaftarAbsenTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Status Verifikasi & Tanda Tangan Guru Piket -->
            <div style="border: 1.5px solid #86efac; background: #f0fdf4; border-radius: 12px; padding: 16px; display: flex; align-items: center; justify-content: space-between; gap: 16px;" id="mdVerifSectionYes">
                <div>
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 800; color: #166534;">
                        <i class="fa-solid fa-circle-check"></i> Jurnal Terverifikasi &amp; Ditandatangani Guru Piket
                    </div>
                    <div style="font-size: 12px; color: #15803d; margin-top: 2px;" id="mdVerifGuruPiketTeks">
                        Oleh: -
                    </div>
                    <div style="font-size: 11px; color: #475569; margin-top: 1px;" id="mdVerifWaktuTeks">
                        Waktu: -
                    </div>
                </div>
                <div id="mdVerifTtdThumbWrap" style="text-align: right;">
                    <img id="mdVerifTtdImg" src="" alt="Tanda Tangan Piket" style="max-height: 55px; max-width: 140px; border: 1px solid #bbf7d0; background: #fff; border-radius: 6px; padding: 3px;">
                </div>
            </div>

            <div style="border: 1px solid #cbd5e1; background: #f8fafc; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 12px;" id="mdVerifSectionNo">
                <i class="fa-solid fa-hourglass-half" style="font-size: 20px; color: #94a3b8;"></i>
                <div>
                    <div style="font-size: 13px; font-weight: 700; color: #334155;">Belum Ditandatangani Guru Piket</div>
                    <div style="font-size: 11.5px; color: #64748b;">Pengesahan tanda tangan harian dilakukan oleh Guru Piket setelah seluruh jam KBM hari ini selesai.</div>
                </div>
            </div>

        </div>

        <div class="modal-footer-styled">
            <button type="button" onclick="closeJurnalDetailModal()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer;">Tutup</button>
=======
<!-- Modal Modern Detail Jurnal Mengajar -->
<div id="detailModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(3px); z-index: 999; align-items: center; justify-content: center; padding: 16px;">
    <div class="detail-modal-card" style="background: #ffffff; width: 100%; max-width: 520px; border-radius: 20px; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0; animation: modalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
        <!-- Modal Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">Detail Jurnal Mengajar</h3>
                    <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Informasi aktivitas KBM guru pengajar</p>
                </div>
            </div>
            <button onclick="closeDetailModal()" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 8px; font-size: 16px; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s ease;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">&times;</button>
        </div>

        <!-- Modal Content Grid -->
        <div class="modal-info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 12.5px; margin-bottom: 16px;">
            <div style="background: #f8fafc; padding: 10px 14px; border-radius: 12px; border: 1px solid #f1f5f9;">
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Guru Pengajar</span>
                <div id="modalGuru" style="font-weight: 700; color: #0f172a; margin-top: 3px;">-</div>
            </div>

            <div style="background: #f8fafc; padding: 10px 14px; border-radius: 12px; border: 1px solid #f1f5f9;">
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Mata Pelajaran</span>
                <div id="modalMapel" style="font-weight: 700; color: #0f172a; margin-top: 3px;">-</div>
            </div>

            <div style="background: #f8fafc; padding: 10px 14px; border-radius: 12px; border: 1px solid #f1f5f9;">
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Kelas</span>
                <div id="modalKelas" style="font-weight: 700; color: #0f172a; margin-top: 3px;">-</div>
            </div>

            <div style="background: #f8fafc; padding: 10px 14px; border-radius: 12px; border: 1px solid #f1f5f9;">
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Tanggal</span>
                <div id="modalTanggal" style="font-weight: 700; color: #0f172a; margin-top: 3px;">-</div>
            </div>
        </div>

        <div style="background: #f8fafc; padding: 12px 14px; border-radius: 12px; border: 1px solid #f1f5f9; margin-bottom: 14px;">
            <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Materi Pembelajaran</span>
            <p id="modalMateri" style="margin: 4px 0 0 0; color: #334155; font-size: 13px; font-weight: 600; line-height: 1.5;">-</p>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: #ecfdf5; border-radius: 12px; border: 1px solid #d1fae5; margin-bottom: 20px;">
            <span style="font-size: 12px; font-weight: 700; color: #065f46;">Status Pelaksanaan:</span>
            <span id="modalStatusBadge" class="status-badge-terlaksana">
                <i class="fa-solid fa-circle-check"></i>
                <span id="modalStatusText">Terlaksana</span>
            </span>
        </div>

        <!-- Modal Footer -->
        <div style="display: flex; justify-content: flex-end; gap: 8px;">
            <button onclick="closeDetailModal()" style="background: #2563eb; color: #ffffff; border: none; padding: 9px 20px; border-radius: 10px; font-size: 12.5px; font-weight: 700; cursor: pointer; transition: background 0.15s ease;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                Tutup
            </button>
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
        </div>
    </div>
</div>

<<<<<<< HEAD
<!-- ========================================================================= -->
<!-- MODAL 3: PREVIEW TANDA TANGAN GURU PIKET                                 -->
<!-- ========================================================================= -->
@if($verifikasiHariIni)
<div id="previewSigModal" class="custom-modal-backdrop">
    <div class="custom-modal-box" style="max-width: 480px;">
        <div class="modal-header-styled">
            <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #0f172a;">Tanda Tangan Guru Piket Resmi</h3>
            <button type="button" onclick="closeSignaturePreviewModal()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>
        <div class="modal-body-styled" style="text-align: center;">
            <div style="border: 2px dashed #bbf7d0; background: #f8fafc; border-radius: 12px; padding: 20px; margin-bottom: 16px;">
                <img src="{{ $verifikasiHariIni->tanda_tangan }}" alt="Tanda Tangan Guru Piket" style="max-height: 120px; max-width: 100%;">
            </div>
            <div style="font-size: 16px; font-weight: 800; color: #0f172a;">{{ $verifikasiHariIni->nama_guru_piket }}</div>
            <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">NIP: {{ $verifikasiHariIni->nip_guru_piket ?? '-' }}</div>
            <div style="font-size: 11.5px; color: #166534; background: #dcfce7; display: inline-block; padding: 3px 10px; border-radius: 20px; font-weight: 700; margin-top: 8px;">
                Diverifikasi pada: {{ \Carbon\Carbon::parse($verifikasiHariIni->waktu_verifikasi)->translatedFormat('l, d F Y H:i') }} WIB
            </div>
            @if($verifikasiHariIni->catatan)
                <div style="margin-top: 14px; font-size: 12.5px; color: #334155; background: #f1f5f9; padding: 10px; border-radius: 8px; text-align: left;">
                    <strong>Catatan Evaluasi:</strong><br>
                    {{ $verifikasiHariIni->catatan }}
                </div>
            @endif
        </div>
        <div class="modal-footer-styled">
            <button type="button" onclick="closeSignaturePreviewModal()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 12.5px; cursor: pointer;">Tutup</button>
        </div>
    </div>
</div>
@endif

<!-- ========================================================================= -->
<!-- JAVASCRIPT: SIGNATURE CANVAS & MODAL SCRIPTS                             -->
<!-- ========================================================================= -->
<script>
    /* === 1. SIGNATURE PAD CANVAS LOGIC === */
    let canvas = null;
    let ctx = null;
    let isDrawing = false;
    let hasDrawn = false;
    let lastX = 0;
    let lastY = 0;

    function initSignaturePad() {
        canvas = document.getElementById('sigCanvas');
        if (!canvas) return;
        ctx = canvas.getContext('2d');

        // Set proper internal canvas resolution based on display size
        const rect = canvas.getBoundingClientRect();
        canvas.width = rect.width * 2;
        canvas.height = rect.height * 2;
        ctx.scale(2, 2);

        ctx.strokeStyle = '#1e3a8a';
        ctx.lineWidth = 2.5;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        // Mouse Event Listeners
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseleave', stopDrawing);

        // Touch Event Listeners
        canvas.addEventListener('touchstart', handleTouchStart, { passive: false });
        canvas.addEventListener('touchmove', handleTouchMove, { passive: false });
        canvas.addEventListener('touchend', stopDrawing);
=======
<style>
    @keyframes modalPop {
        0% { transform: scale(0.95); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    function openDetailModal(id, guru, mapel, kelas, tanggal, materi, status) {
        document.getElementById('modalGuru').textContent = guru || '-';
        document.getElementById('modalMapel').textContent = mapel || '-';
        document.getElementById('modalKelas').textContent = kelas || '-';
        document.getElementById('modalTanggal').textContent = tanggal || '-';
        document.getElementById('modalMateri').textContent = materi || '-';

        const statusBadge = document.getElementById('modalStatusBadge');
        const statusText = document.getElementById('modalStatusText');
        statusText.textContent = status;

        if (status === 'Terlaksana') {
            statusBadge.className = 'status-badge-terlaksana';
            statusBadge.innerHTML = '<i class="fa-solid fa-circle-check"></i> <span>Terlaksana</span>';
        } else {
            statusBadge.className = 'status-badge-belum';
            statusBadge.innerHTML = '<i class="fa-regular fa-clock"></i> <span>Belum Terlaksana</span>';
        }

        document.getElementById('detailModal').style.display = 'flex';
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
    }

    function getMousePos(e) {
        const rect = canvas.getBoundingClientRect();
        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        };
    }

<<<<<<< HEAD
    function startDrawing(e) {
        isDrawing = true;
        const pos = getMousePos(e);
        lastX = pos.x;
        lastY = pos.y;
        document.getElementById('sigPlaceholder').style.display = 'none';
    }

    function draw(e) {
        if (!isDrawing) return;
        const pos = getMousePos(e);

        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();

        lastX = pos.x;
        lastY = pos.y;
        hasDrawn = true;
    }

    function stopDrawing() {
        isDrawing = false;
    }

    function handleTouchStart(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        lastX = touch.clientX - rect.left;
        lastY = touch.clientY - rect.top;
        isDrawing = true;
        document.getElementById('sigPlaceholder').style.display = 'none';
    }

    function handleTouchMove(e) {
        if (!isDrawing) return;
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        const x = touch.clientX - rect.left;
        const y = touch.clientY - rect.top;

        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.stroke();

        lastX = x;
        lastY = y;
        hasDrawn = true;
    }

    function clearSignatureCanvas() {
        if (!canvas || !ctx) return;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        hasDrawn = false;
        document.getElementById('sigPlaceholder').style.display = 'block';
        document.getElementById('inputTandaTanganBase64').value = '';
    }

    function openSignatureModal() {
        document.getElementById('signatureModal').style.display = 'flex';
        setTimeout(() => {
            initSignaturePad();
        }, 150);
    }

    function closeSignatureModal() {
        document.getElementById('signatureModal').style.display = 'none';
        clearSignatureCanvas();
    }

    function validateSignatureSubmit() {
        if (!hasDrawn) {
            alert('Silakan bubuhkan goresan tanda tangan digital Anda di dalam kotak canvas.');
            return false;
        }

        const selGuru = document.getElementById('selectGuruPiketTtd').value;
        if (!selGuru) {
            alert('Silakan pilih nama Guru Piket yang bertugas menandatangani.');
            return false;
        }

        const chkSah = document.getElementById('checkPernyataanSah').checked;
        if (!chkSah) {
            alert('Silakan centang persetujuan pernyataan keabsahan dokumen jurnal.');
            return false;
        }

        // Export canvas image to base64
        const dataUrl = canvas.toDataURL('image/png');
        document.getElementById('inputTandaTanganBase64').value = dataUrl;
        return true;
    }

    function showSignaturePreviewModal() {
        const modal = document.getElementById('previewSigModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeSignaturePreviewModal() {
        const modal = document.getElementById('previewSigModal');
        if (modal) modal.style.display = 'none';
    }

    /* === 2. AJAX DETAIL MODAL LOGIC === */
    function openJurnalDetailModal(idJurnal) {
        const modal = document.getElementById('jurnalDetailModal');
        const loading = document.getElementById('mdLoadingState');
        const content = document.getElementById('mdContentState');

        modal.style.display = 'flex';
        loading.style.display = 'block';
        content.style.display = 'none';

        fetch(`/guru-piket/jurnal-mengajar/detail/${idJurnal}`)
            .then(res => res.json())
            .then(res => {
                if (!res.success) {
                    alert('Gagal mengambil data detail jurnal.');
                    closeJurnalDetailModal();
                    return;
                }

                const d = res.data;

                // Header
                document.getElementById('mdMapelKelas').textContent = `${d.mapel} (${d.kelas})`;
                document.getElementById('mdTanggalJam').textContent = `${d.hari}, ${d.tanggal_formatted} • Jam ke-${d.jam_ke} (${d.waktu_kbm})`;

                // Guru
                document.getElementById('mdGuru').textContent = d.guru;
                document.getElementById('mdNipGuru').textContent = `NIP: ${d.nip_guru}`;

                const badgePengganti = document.getElementById('mdBadgeGuruPengganti');
                if (d.is_guru_pengganti && d.guru_pengganti) {
                    badgePengganti.style.display = 'block';
                    document.getElementById('mdNamaPengganti').textContent = d.guru_pengganti;
                } else {
                    badgePengganti.style.display = 'none';
                }

                // Waktu & Ruang
                document.getElementById('mdAlokasi').textContent = `${d.jumlah_jp} (${d.waktu_kbm})`;
                document.getElementById('mdRuangan').textContent = `Ruangan: ${d.ruangan}`;

                const badgeStatus = document.getElementById('mdBadgeStatusKbm');
                badgeStatus.textContent = d.status_kehadiran_guru;
                badgeStatus.className = 'badge-status-pill ' + (d.status_kehadiran_guru === 'Hadir' ? 'badge-terlaksana' : 'badge-belum-terlaksana');

                // Materi & Kondisi
                document.getElementById('mdMateri').textContent = d.materi || '-';
                document.getElementById('mdKondisiKelas').textContent = d.kondisi_kelas || 'Kondusif';
                document.getElementById('mdCatatanGuru').textContent = d.catatan || 'Tidak ada catatan tambahan.';

                // Foto Dokumentasi
                const fotoWrap = document.getElementById('mdFotoWrap');
                const fotoImg = document.getElementById('mdFotoImg');
                if (d.dokumentasi_url) {
                    fotoImg.src = d.dokumentasi_url;
                    fotoWrap.style.display = 'block';
                } else {
                    fotoWrap.style.display = 'none';
                }

                // Presensi Siswa
                document.getElementById('mdTotalSiswaTeks').textContent = `Total: ${d.total_siswa} Siswa`;
                document.getElementById('mdHadirCount').textContent = d.hadir_count;
                document.getElementById('mdSakitCount').textContent = d.sakit_count;
                document.getElementById('mdIzinCount').textContent = d.izin_count;
                document.getElementById('mdAlpaCount').textContent = d.alpa_count;

                // Daftar Siswa Absen
                const absenWrap = document.getElementById('mdDaftarAbsenWrap');
                const absenTbody = document.getElementById('mdDaftarAbsenTable');
                absenTbody.innerHTML = '';

                if (d.daftar_absen && d.daftar_absen.length > 0) {
                    absenWrap.style.display = 'block';
                    d.daftar_absen.forEach((item, idx) => {
                        const tr = document.createElement('tr');
                        tr.style.borderBottom = '1px solid #f1f5f9';
                        tr.innerHTML = `
                            <td style="padding: 6px 10px; width: 24px; color: #64748b;">${idx + 1}.</td>
                            <td style="padding: 6px 10px; font-weight: 700; color: #0f172a;">${item.nama_siswa}</td>
                            <td style="padding: 6px 10px; color: #64748b;">NISN: ${item.nisn}</td>
                            <td style="padding: 6px 10px; text-align: right;">
                                <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 4px; ${item.keterangan === 'Sakit' ? 'background: #eff6ff; color: #2563eb;' : (item.keterangan === 'Izin' ? 'background: #fffbeb; color: #d97706;' : 'background: #fef2f2; color: #dc2626;')}">
                                    ${item.keterangan}
                                </span>
                            </td>
                        `;
                        absenTbody.appendChild(tr);
                    });
                } else {
                    absenWrap.style.display = 'none';
                }

                // Verifikasi Piket
                const vYes = document.getElementById('mdVerifSectionYes');
                const vNo = document.getElementById('mdVerifSectionNo');

                if (d.verifikasi_piket && d.verifikasi_piket.is_verified) {
                    vYes.style.display = 'flex';
                    vNo.style.display = 'none';
                    document.getElementById('mdVerifGuruPiketTeks').textContent = `Oleh: ${d.verifikasi_piket.nama_guru_piket} (NIP: ${d.verifikasi_piket.nip_guru_piket})`;
                    document.getElementById('mdVerifWaktuTeks').textContent = `Waktu Verifikasi: ${d.verifikasi_piket.waktu_verifikasi}`;
                    document.getElementById('mdVerifTtdImg').src = d.verifikasi_piket.tanda_tangan;
                } else {
                    vYes.style.display = 'none';
                    vNo.style.display = 'flex';
                }

                loading.style.display = 'none';
                content.style.display = 'block';
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat memuat data jurnal.');
                closeJurnalDetailModal();
            });
    }

    function closeJurnalDetailModal() {
        document.getElementById('jurnalDetailModal').style.display = 'none';
    }

    // Close modals on backdrop click
    window.onclick = function(e) {
        const sigModal = document.getElementById('signatureModal');
        const detModal = document.getElementById('jurnalDetailModal');
        const prevModal = document.getElementById('previewSigModal');

        if (e.target === sigModal) closeSignatureModal();
        if (e.target === detModal) closeJurnalDetailModal();
        if (e.target === prevModal) closeSignaturePreviewModal();
    };
=======
    /* Mobile Filter Modal */
    function openMobileFilterModal() {
        const modal = document.getElementById('mobileFilterModal');
        if (modal) modal.style.display = 'flex';
    }

    function closeMobileFilterModal() {
        const modal = document.getElementById('mobileFilterModal');
        if (modal) modal.style.display = 'none';
    }

    /* Mobile Carousel Banner (5 Slides, 5-Min Timer, Swipe, Manual Arrows) */
    let currentSlideIndex = 0;
    const totalSlides = 5;
    let carouselAutoTimer = null;

    function updateCarouselUI() {
        const track = document.getElementById('mobileCarouselTrack');
        if (track) {
            track.style.transform = `translateX(-${currentSlideIndex * 100}%)`;
        }
        const dots = document.querySelectorAll('#carouselDots .m-dot');
        dots.forEach((dot, idx) => {
            if (idx === currentSlideIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function resetCarouselTimer() {
        if (carouselAutoTimer) clearInterval(carouselAutoTimer);
        carouselAutoTimer = setInterval(() => {
            moveCarousel(1);
        }, 300000); // Auto slide every 5 minutes (300,000 ms)
    }

    function moveCarousel(direction) {
        currentSlideIndex = (currentSlideIndex + direction + totalSlides) % totalSlides;
        updateCarouselUI();
        resetCarouselTimer();
    }

    function jumpToSlide(index) {
        currentSlideIndex = index;
        updateCarouselUI();
        resetCarouselTimer();
    }

    // Touch Swipe, Cursor Hover & Modal Backdrop Click
    document.addEventListener('DOMContentLoaded', function() {
        const carouselElem = document.querySelector('.mobile-carousel-container');
        if (carouselElem) {
            // Hover/cursor approach: show navigation arrows
            carouselElem.addEventListener('mouseenter', function() {
                carouselElem.classList.add('is-hovered');
            });
            carouselElem.addEventListener('mouseleave', function() {
                carouselElem.classList.remove('is-hovered');
            });

            // Touch gestures for swipe navigation
            let touchStartX = 0;
            let touchEndX = 0;

            carouselElem.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            carouselElem.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                const diff = touchEndX - touchStartX;
                if (Math.abs(diff) > 40) {
                    if (diff < 0) {
                        moveCarousel(1);
                    } else {
                        moveCarousel(-1);
                    }
                }
            }, { passive: true });
        }
        resetCarouselTimer();
    });

    // Tutup modal jika klik di luar box
    window.addEventListener('click', function(e) {
        const detailModal = document.getElementById('detailModal');
        if (e.target === detailModal) {
            closeDetailModal();
        }
        const filterModal = document.getElementById('mobileFilterModal');
        if (e.target === filterModal) {
            closeMobileFilterModal();
        }
    });
>>>>>>> 7a968c27e3d468e5c768f019b11e2e45639eb857
</script>
@endsection