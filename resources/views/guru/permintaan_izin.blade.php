@extends('layouts.guru')

@section('title', 'Permintaan Izin Saya — EDU JOURNAL')

@section('styles')
<style>
    .page-title-box {
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title-box h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }

    .page-title-box p {
        font-size: 13.5px;
        color: #64748b;
        margin: 0;
        font-weight: 500;
    }

    .card-custom {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .card-custom-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .card-custom-header h2 {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.01em;
    }

    .card-custom-body {
        padding: 24px;
    }

    .form-label-custom {
        font-size: 12.5px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }

    .form-control-custom {
        width: 100%;
        padding: 11px 14px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13.5px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control-custom:focus {
        background: #ffffff;
        border-color: #384972;
        box-shadow: 0 0 0 3px rgba(56, 73, 114, 0.12);
    }

    /* Tombol Kirim Permintaan Izin */
    .btn-kirim-izin {
        background: #384972;
        color: #ffffff;
        border: none;
        padding: 11px 24px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(56, 73, 114, 0.25);
    }

    .btn-kirim-izin:hover {
        background: #2b3957;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(56, 73, 114, 0.35);
    }

    /* Tombol Reset Form */
    .btn-reset-form {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 11px 20px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-reset-form:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    /* Filter Bar Container Layout */
    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
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
        border-radius: 8px;
        font-size: 12.5px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
    }

    .filter-input:focus {
        border-color: #384972;
    }

    .btn-filter-dark {
        background: #384972;
        color: #ffffff;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-filter-dark:hover { background: #2b3957; color: #ffffff; }

    .btn-reset-light {
        background: #e2e8f0;
        color: #475569;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #1e293b; }

    .btn-trash-pink {
        background: #fce7f3;
        color: #db2777;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        border: 1px solid #fbcfe8;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        margin-left: auto;
        transition: all 0.2s ease;
    }
    .btn-trash-pink:hover { background: #fbcfe8; color: #be185d; }

    /* Floating Pop-up Batch Toolbar */
    .floating-batch-bar {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(120px);
        background: #0f172a;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        z-index: 999;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .floating-batch-bar.show {
        transform: translateX(-50%) translateY(0);
    }

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
        padding: 14px 18px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-custom td {
        padding: 16px 18px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background: #f8fafc;
    }

    .custom-checkbox {
        width: 18px;
        height: 18px;
        border-radius: 4px;
        cursor: pointer;
        accent-color: #2563eb;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-badge.disetujui, .status-badge.approved { background: #dcfce7; color: #15803d; }
    .status-badge.menunggu, .status-badge.pending { background: #fef3c7; color: #b45309; }
    .status-badge.ditolak, .status-badge.rejected { background: #fee2e2; color: #b91c1c; }
    .status-badge.diproses { background: #e0f2fe; color: #0369a1; }

    .piket-notif-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 10px 14px;
        margin-top: 8px;
        font-size: 12px;
        color: #166534;
        line-height: 1.4;
    }

    .piket-pending-box {
        background: #fffbe6;
        border: 1px solid #ffe58f;
        border-radius: 12px;
        padding: 10px 14px;
        margin-top: 8px;
        font-size: 12px;
        color: #873800;
        line-height: 1.4;
    }

    /* Action Buttons */
    .btn-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .btn-action-wa { background: #dcfce7; color: #166534; border-color: #bbf7d0; }
    .btn-action-wa:hover { background: #bbf7d0; color: #14532d; }

    .btn-action-chatbot { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
    .btn-action-chatbot:hover { background: #10b981; color: #ffffff; border-color: #059669; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25); }

    .btn-action-copy { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .btn-action-copy:hover { background: #dbeafe; }

    .btn-action-detail { background: #f8fafc; color: #475569; border-color: #cbd5e1; }
    .btn-action-detail:hover { background: #e2e8f0; color: #0f172a; }

    .btn-action-edit { background: #fef3c7; color: #b45309; border-color: #fde68a; }
    .btn-action-edit:hover { background: #fde68a; color: #92400e; }

    .btn-action-delete { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }
    .btn-action-delete:hover { background: #fca5a5; color: #991b1b; }

    /* Modal Backdrop & Card */
    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 16px;
        max-width: 680px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        overflow: hidden;
        animation: fadeInModal 0.2s ease;
    }

    @keyframes fadeInModal {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header {
        background: #384972;
        color: #ffffff;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 { margin: 0; font-size: 16.5px; font-weight: 800; letter-spacing: -0.01em; }

    .modal-body {
        padding: 24px;
        max-height: 75vh;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Mobile Responsive Optimizations */
    @media (max-width: 768px) {
        .page-title-box {
            margin-bottom: 18px !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
        }

        .page-title-box h1 {
            font-size: 28px !important;
            line-height: 1.25 !important;
            font-weight: 800 !important;
        }

        .page-title-box p {
            font-size: 13px !important;
            margin-top: 6px !important;
        }

        .card-custom {
            border-radius: 14px !important;
            margin-bottom: 18px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
        }

        .card-custom-header {
            padding: 14px 16px !important;
            gap: 8px !important;
        }

        .card-custom-header h2 {
            font-size: 15px !important;
        }

        .card-custom-body {
            padding: 16px 14px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .form-row-2col {
            grid-template-columns: 1fr !important;
            gap: 14px !important;
            margin-bottom: 14px !important;
        }

        .form-actions-bar {
            flex-direction: column-reverse !important;
            align-items: stretch !important;
            gap: 10px !important;
            width: 100% !important;
        }

        .form-actions-bar button,
        .form-actions-bar a {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 11px 16px !important;
            box-sizing: border-box !important;
        }

        .filter-bar-container {
            padding: 14px 14px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .filter-bar-container form {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            width: 100% !important;
        }

        .filter-bar-container form > div,
        .filter-bar-container form > a,
        .filter-bar-container form > button {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            box-sizing: border-box !important;
        }

        .filter-input {
            width: 100% !important;
            box-sizing: border-box !important;
            font-size: 13px !important;
            padding: 10px 12px !important;
        }

        .btn-filter-dark,
        .btn-reset-light,
        .btn-trash-pink {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 10px 14px !important;
            font-size: 13px !important;
            box-sizing: border-box !important;
            margin-left: 0 !important;
        }

        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .table-custom {
            min-width: 750px !important;
            width: 100% !important;
        }

        .table-custom th,
        .table-custom td {
            padding: 12px 14px !important;
        }

        .floating-batch-bar {
            width: calc(100% - 32px) !important;
            flex-direction: column !important;
            border-radius: 16px !important;
            padding: 14px !important;
            bottom: 16px !important;
            gap: 10px !important;
            box-sizing: border-box !important;
        }

        .floating-batch-bar > div {
            width: 100% !important;
            justify-content: space-between !important;
        }

        .modal-backdrop {
            padding: 12px !important;
        }

        .modal-card {
            border-radius: 14px !important;
            max-width: 100% !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .modal-header {
            padding: 14px 16px !important;
        }

        .modal-body {
            padding: 16px 14px !important;
            max-height: 72vh !important;
            box-sizing: border-box !important;
        }

        .modal-footer {
            padding: 12px 14px !important;
            flex-direction: column-reverse !important;
            align-items: stretch !important;
            gap: 8px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .modal-footer button,
        .modal-footer a {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 10px 14px !important;
            box-sizing: border-box !important;
        }

        .piket-success-actions {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
            width: 100% !important;
        }

        .piket-success-actions > * {
            width: 100% !important;
            justify-content: center !important;
            text-align: center !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
        }

        .desktop-table-wrapper {
            display: none !important;
        }

        .mobile-cards-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            padding: 12px 10px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
    }

    /* Desktop vs Mobile Toggle */
    .desktop-table-wrapper {
        display: block;
        width: 100%;
    }

    .mobile-cards-wrapper {
        display: none;
    }

    .mobile-select-all-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 4px;
    }

    .mobile-izin-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        overflow: hidden;
        margin-bottom: 12px;
        transition: all 0.2s ease;
        width: 100%;
        box-sizing: border-box;
    }

    .mobile-izin-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .mobile-izin-header {
        padding: 12px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .mobile-izin-body {
        padding: 14px;
    }

    .mobile-approval-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        background: #f8fafc;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #f1f5f9;
        margin-top: 10px;
    }

    .mobile-approval-item {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    .mobile-approval-label {
        font-size: 10px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        line-height: 1.2;
    }

    .mobile-izin-footer {
        padding: 12px 14px;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
    }

    @media (max-width: 480px) {
        .page-title-box h1 {
            font-size: 25px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="permintaan-izin-page" style="width: 100%; max-width: 100%; min-width: 0; box-sizing: border-box; overflow-x: clip;">
<div class="page-title-box">
    <div>
        <h1>Permintaan Izin Saya</h1>
        <p>Pengisian data izin tidak hadir mengajar untuk diverifikasi, diisikan, dan dikirimkan oleh Guru Piket ke Waka & Kepala Sekolah</p>
    </div>
</div>

@if(session('piket_link') || session('chatbot_msg') || session('new_izin_id'))
    <div style="background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; box-shadow: 0 4px 16px rgba(16, 185, 129, 0.12);">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 12px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="background: #10b981; color: #fff; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                    <i class="fa-solid fa-circle-check"></i>
                </span>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #065f46;">
                        {{ session('success') ?? 'Permintaan izin/cuti berhasil diproses' }}
                    </h3>
                    <p style="margin: 2px 0 0 0; font-size: 13px; color: #047857; font-weight: 600;">
                        Data izin telah otomatis tersimpan ke sistem Guru Piket dan siap diverifikasi & diisikan oleh Guru Piket.
                    </p>
                </div>
            </div>
        </div>

        @if(session('chatbot_msg'))
            <div style="background: {{ session('chatbot_sent') ? '#dcfce7' : '#fffbeb' }}; border: 1px solid {{ session('chatbot_sent') ? '#86efac' : '#fde68a' }}; border-radius: 12px; padding: 14px 18px; margin-top: 10px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: {{ session('chatbot_sent') ? '#16a34a' : '#d97706' }}; color: #ffffff; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;">
                        <i class="fa-solid fa-robot"></i>
                    </span>
                    <div>
                        <div style="font-size: 11.5px; font-weight: 800; color: {{ session('chatbot_sent') ? '#166534' : '#92400e' }}; text-transform: uppercase; letter-spacing: 0.04em;">
                            Notifikasi ChatBot WhatsApp Otomatis:
                        </div>
                        <div style="font-size: 13.5px; font-weight: 700; color: {{ session('chatbot_sent') ? '#14532d' : '#78350f' }}; margin-top: 2px;">
                            {{ session('chatbot_msg') }}
                        </div>
                    </div>
                </div>

                @if(session('new_izin_id'))
                    <button type="button" onclick="resendChatbotFromAlert('{{ session('new_izin_id') }}', '{{ session('chatbot_phone') }}')" style="padding: 9px 16px; font-size: 12.5px; border-radius: 8px; font-weight: 700; background: #10b981; color: #ffffff; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);">
                        <i class="fa-solid fa-rotate-right"></i> Kirim Ulang via ChatBot WA
                    </button>
                @endif
            </div>
        @endif

        @if(session('piket_link'))
            <div style="background: #ffffff; border: 1px solid #6ee7b7; border-radius: 12px; padding: 16px 20px; margin-top: 10px;">
                <label style="font-size: 12px; font-weight: 800; color: #065f46; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 8px;">
                    <i class="fa-solid fa-link"></i> Link Akses Halaman Guru Piket (Otomatis Terbuat):
                </label>
                <div class="piket-success-actions" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <input type="text" id="piketAccessUrlInput" value="{{ session('piket_link') }}" readonly style="flex: 1; min-width: 260px; padding: 11px 14px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 13.5px; color: #0f172a; font-weight: 700; font-family: monospace;">
                    
                    <button type="button" onclick="copyPiketLinkDirect('{{ session('piket_link') }}')" style="padding: 11px 18px; font-size: 13px; border-radius: 10px; font-weight: 700; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-copy"></i> Salin Link
                    </button>

                    @if(session('wa_url'))
                        <a href="{{ session('wa_url') }}" target="_blank" style="padding: 11px 20px; font-size: 13px; border-radius: 10px; font-weight: 700; background: #25d366; color: #ffffff; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);">
                            <i class="fa-brands fa-whatsapp" style="font-size: 17px;"></i> Cadangan Buka WhatsApp Manual
                        </a>
                    @endif
                </div>
                <small style="color: #047857; font-weight: 600; display: block; margin-top: 10px; font-size: 12px;">
                    <i class="fa-solid fa-circle-info"></i> Tautan di atas telah otomatis terlampir dalam pesan ChatBot WhatsApp dan juga dapat Anda buka secara manual sewaktu-waktu.
                </small>
            </div>
        @endif
    </div>
@endif

@if($errors->any())
    <div style="background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 700;">
        <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
    </div>
@endif

<!-- Form Buat Permintaan Izin -->
<div class="card-custom">
    <div class="card-custom-header">
        <h2>Buat Permintaan Izin / Cuti Guru</h2>
    </div>
    <div class="card-custom-body">
        <form id="formIzinGuru" action="{{ route('guru.permintaan-izin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-row-2col" style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 18px;">
                <div>
                    <label class="form-label-custom">Guru yang meminta izin</label>

                    @if($guru)
                        <input type="hidden" name="id_guru" id="inputIdGuru" value="{{ $guru->id_guru }}">
                        <input type="text" class="form-control-custom" value="[NIP. {{ $guru->nip ?? '-' }}] {{ $guru->nama_guru }}" readonly style="background: #f1f5f9; font-weight: 700; color: #1e293b;">
                    @else
                        <select name="id_guru" id="selectIdGuru" class="form-control-custom" required style="width: 100%;">
                            <option value="">Pilih NIP atau Nama Guru...</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}">
                                     @if($g->nip) [NIP. {{ $g->nip }}] @endif {{ $g->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <div>
                    <label class="form-label-custom">Kategori Izin</label>
                    <select name="kategori_izin" id="selectKategoriIzin" class="form-control-custom" onchange="checkDurationCategory()" required>
                        <option value="biasa">Izin Biasa (1 s/d 3 Hari)</option>
                        <option value="cuti">Cuti / Izin Khusus (> 3 Hari)</option>
                    </select>
                </div>
            </div>

            <div class="form-row-2col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 18px;">
                <div>
                    <label class="form-label-custom">Tanggal Mulai Izin</label>
                    <input type="date" name="tanggal_mulai" id="inputTglMulai" class="form-control-custom" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" onchange="checkDurationCategory()" required>
                </div>
                <div>
                    <label class="form-label-custom">Tanggal Selesai Izin</label>
                    <input type="date" name="tanggal_selesai" id="inputTglSelesai" class="form-control-custom" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" onchange="checkDurationCategory()">
                </div>
            </div>

            <!-- Banner Notifikasi Cuti (> 3 Hari) -->
            <div id="bannerCutiWarning" style="display: none; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; padding: 12px 16px; margin-bottom: 18px; color: #c2410c; font-size: 13px; font-weight: 700;">
                <i class="fa-solid fa-triangle-exclamation"></i> Deteksi Izin > 3 Hari (Cuti/Izin Khusus): Wajib mengisi Keterangan Khusus & mengunggah Dokumen Bukti Resmi Cuti!
            </div>

            <div style="margin-bottom: 18px;">
                <label class="form-label-custom">Alasan Umum Izin</label>
                <textarea name="alasan" id="alasan" class="form-control-custom" rows="3" placeholder="Tuliskan alasan umum tidak dapat mengajar..." required></textarea>
            </div>

            <!-- Container Keterangan Khusus Cuti (Wajib jika > 3 Hari / Kategori Cuti) -->
            <div id="keteranganKhususContainer" style="display: none; margin-bottom: 18px; background: #fff7ed; padding: 16px; border-radius: 12px; border: 1px solid #fed7aa;">
                <label class="form-label-custom" style="color: #c2410c; font-size: 13px;">
                    Keterangan Khusus Cuti / Izin Khusus (> 3 Hari) <span style="color: #dc2626;">*Wajib Diisi</span>
                </label>
                <small style="color: #ea580c; display: block; margin-bottom: 8px;">
                    Tuliskan rincian penjelasan mengapa permohonan izin dilakukan lebih dari 3 hari (Cuti) agar Waka & Kepsek mengetahui dengan tepat alasannya.
                </small>
                <textarea name="keterangan_khusus" id="inputKeteranganKhusus" class="form-control-custom" rows="3" placeholder="Tuliskan penjelasan khusus permohonan Cuti / Izin Khusus..."></textarea>
            </div>

            <!-- Opsi Titipan & Lampiran Surat -->
            <div class="form-row-2col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label class="form-label-custom">Titipan Materi / Tugas (Opsional)</label>
                    <input type="text" name="materi_dititipkan" id="materi_dititipkan" class="form-control-custom" placeholder="Contoh: Kerjakan Bab 3 Halaman 45">
                </div>
                <div>
                    <label class="form-label-custom" id="labelFotoSurat">Upload Foto Surat / Bukti Izin</label>
                    <input type="file" name="foto_surat" id="inputFotoSurat" class="form-control-custom" accept="image/*" required>
                </div>
            </div>

            <!-- Opsi File Tugas & Tujuan Guru Piket WA -->
            <div class="form-row-2col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                <div>
                    <label class="form-label-custom">Upload File Tugas (Opsional)</label>
                    <input type="file" name="file_tugas" id="inputFileTugas" class="form-control-custom">
                </div>
                <div>
                    <label class="form-label-custom" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 4px;">
                        <span>Tujuan Guru Piket (Notifikasi Otomatis ChatBot WA)</span>
                        <span style="font-size: 11px; font-weight: 700; color: #16a34a; background: #dcfce7; padding: 2px 7px; border-radius: 6px;">
                            <i class="fa-solid fa-robot"></i> Auto-Send via ChatBot
                        </span>
                    </label>
                    <select name="wa_target_phone" id="wa_target_phone" class="form-control-custom">
                        <option value="">-- Otomatis (Guru Piket Hari Ini & Petugas Piket Sistem) --</option>
                        @if(isset($piketUsers) && count($piketUsers) > 0)
                            <optgroup label="Akun Petugas Piket">
                                @foreach($piketUsers as $pu)
                                    @if(!empty($pu->no_hp))
                                        <option value="{{ $pu->no_hp }}">{{ $pu->name }} (Akun Resmi Piket) - {{ $pu->no_hp }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        @endif
                        @if(isset($piketOptions))
                            @php
                                $todayPiketOpts = collect($piketOptions)->where('group', 'Guru Piket Terjadwal Hari Ini');
                            @endphp
                            @if($todayPiketOpts->isNotEmpty())
                                <optgroup label="Guru Piket Terjadwal Hari Ini">
                                    @foreach($todayPiketOpts as $opt)
                                        <option value="{{ $opt['phone'] }}">{{ $opt['label'] }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endif
                    </select>
                </div>
            </div>

            <!-- Action Buttons: Rata Kanan -->
            <div class="form-actions-bar" style="display: flex; justify-content: flex-end; align-items: center; gap: 12px; margin-top: 10px; flex-wrap: wrap;">
                <button type="button" class="btn-reset-form" onclick="resetFormIzin()">
                    <i class="fa-solid fa-rotate-left"></i> Reset Form
                </button>
                <button type="submit" class="btn-kirim-izin">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Permintaan Izin ke Guru Piket
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Riwayat & Status Permintaan Izin Saya -->
<div class="card-custom">
    <div class="card-custom-header" style="border-bottom: none;">
        <h2>Status Permintaan Izin Saya</h2>
        <span style="font-size: 12.5px; font-weight: 600; color: #64748b;">Total {{ $myIzinList->count() }} Pengajuan</span>
    </div>

    <!-- Filter & Search Bar + Reset + Sampah -->
    <div class="filter-bar-container">
        <form action="{{ route('guru.permintaan-izin') }}" method="GET">
            <div style="flex: 2; min-width: 220px;">
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari Alasan, Titipan Materi..." style="width: 100%;">
            </div>

            <div>
                <select name="status" class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="filter-input" title="Filter Tanggal">
            </div>

            <button type="submit" class="btn-filter-dark">
                <i class="fa-solid fa-magnifying-glass"></i> Filter
            </button>

            <a href="{{ route('guru.permintaan-izin') }}" class="btn-reset-light">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>

            <a href="{{ route('guru.permintaan-izin.trash') }}" class="btn-trash-pink">
                <i class="fa-solid fa-trash-can"></i> Tempat Sampah ({{ $trashedCount }})
            </a>
        </form>
    </div>

    <div class="card-custom-body" style="padding: 0;">
        <!-- Desktop Table View (Tampil Khusus di Layar Desktop/Laptop) -->
        <div class="desktop-table-wrapper">
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAll" class="custom-checkbox" onchange="toggleSelectAll(this)" title="Pilih Semua (Select All)">
                            </th>
                            <th>TANGGAL & KATEGORI</th>
                            <th>ALASAN & MATERI</th>
                            <th>STATUS PROSES PIKET</th>
                            <th>STATUS WAKA</th>
                            <th>STATUS WAKA SDM</th>
                            <th>STATUS KEPSEK</th>
                            <th>STATUS FINAL</th>
                            <th style="text-align: center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $chatbotDataMap = [];
                            $detailDataMap = [];
                        @endphp
                        @forelse($myIzinList as $iz)
                        @php
                            $piketAccessUrl = url('/guru-piket/permintaan-izin');
                            $tglFormat = ($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai)
                                ? \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y')
                                : \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y');
                            
                            $waText = "*PERMINTAAN IZIN GURU MENGAJAR*\n"
                                . "----------------------------------\n"
                                . "*Pengaju:* " . ($iz->guru->nama_guru ?? Auth::user()->name) . " (NIP. " . ($iz->guru->nip ?? Auth::user()->nip ?? '-') . ")\n"
                                . "*Kategori:* " . ucfirst($iz->kategori_izin) . "\n"
                                . "*Tanggal:* " . $tglFormat . "\n"
                                . "*Alasan:* " . $iz->alasan . "\n"
                                . ($iz->materi_dititipkan ? "*Titipan Materi:* " . $iz->materi_dititipkan . "\n" : "")
                                . "----------------------------------\n"
                                . "Mohon Bapak/Ibu Guru Piket dapat mengecek, memvalidasi, dan mengisikan data izin melalui sistem Web EDU JOURNAL pada tautan berikut:\n"
                                . $piketAccessUrl;

                            $waSendUrl = "https://api.whatsapp.com/send?text=" . rawurlencode($waText);

                            $isRejectedRow = ($iz->status_waka === 'rejected' || $iz->status_waka_sdm === 'rejected' || $iz->status_kepsek === 'rejected' || $iz->status_final === 'rejected');
                            $isApprovedFullRow = ($iz->status_waka === 'approved' && $iz->status_waka_sdm === 'approved' && $iz->status_kepsek === 'approved');

                            $targetPiketNama = $iz->nama_guru_piket ?? ($iz->guruPiket->nama_guru ?? 'Petugas Guru Piket');
                            $targetPiketPhone = $iz->guruPiket->no_hp ?? ($iz->no_wa_guru_piket ?? '');

                            $detailData = [
                                'id_guru_izin' => $iz->id_guru_izin,
                                'id_guru' => $iz->id_guru,
                                'nama_guru' => $iz->guru->nama_guru ?? Auth::user()->name,
                                'nip' => $iz->guru->nip ?? Auth::user()->nip ?? '-',
                                'tanggal' => $tglFormat,
                                'tanggal_mulai' => $iz->tanggal_mulai,
                                'tanggal_selesai' => $iz->tanggal_selesai,
                                'durasi' => $iz->durasi,
                                'kategori_izin' => $iz->kategori_izin,
                                'alasan' => $iz->alasan,
                                'keterangan_khusus' => $iz->keterangan_khusus,
                                'materi' => $iz->materi_dititipkan,
                                'foto_url' => $iz->foto_url,
                                'file_tugas_url' => $iz->file_tugas_url,
                                'status_piket' => $iz->status_piket,
                                'nama_guru_piket' => $targetPiketNama,
                                'nip_guru_piket' => $iz->nip_guru_piket ?? ($iz->guruPiket->nip ?? '-'),
                                'status_waka' => ucfirst($iz->status_waka ?? 'pending'),
                                'status_waka_sdm' => ucfirst($iz->status_waka_sdm ?? 'pending'),
                                'status_kepsek' => ucfirst($iz->status_kepsek ?? 'pending'),
                                'catatan_waka' => $iz->catatan_waka,
                                'catatan_kepsek' => $iz->catatan_kepsek,
                                'status_final' => $isRejectedRow ? 'Ditolak' : ($isApprovedFullRow ? 'Disetujui Full' : 'Dalam Proses'),
                                'piket_url' => $piketAccessUrl,
                            ];

                            $chatbotData = [
                                'id_guru_izin' => $iz->id_guru_izin,
                                'id_guru' => $iz->id_guru,
                                'nama_guru' => $iz->guru->nama_guru ?? Auth::user()->name,
                                'nip' => $iz->guru->nip ?? Auth::user()->nip ?? '-',
                                'kategori' => ($iz->kategori_izin === 'cuti' || str_contains(strtolower($iz->durasi ?? ''), 'cuti')) ? 'Cuti / Izin Khusus (>3 Hari)' : 'Izin Biasa (1 s/d 3 Hari)',
                                'tanggal' => $tglFormat,
                                'tanggal_mulai' => $iz->tanggal_mulai,
                                'alasan' => $iz->alasan,
                                'materi' => $iz->materi_dititipkan ?: ($iz->tugas_dititipkan ?: '-'),
                                'piket_url' => $piketAccessUrl,
                                'wa_message' => $waText,
                                'wa_direct_url' => $waSendUrl,
                                'target_piket_nama' => $targetPiketNama,
                                'target_phone' => $targetPiketPhone,
                            ];

                            $chatbotDataMap[$iz->id_guru_izin] = $chatbotData;
                            $detailDataMap[$iz->id_guru_izin] = $detailData;
                        @endphp
                        <tr id="row_izin_{{ $iz->id_guru_izin }}">
                            <td style="text-align: center;">
                                <input type="checkbox" class="izin-checkbox custom-checkbox" value="{{ $iz->id_guru_izin }}" onchange="handleItemCheckboxChange('{{ $iz->id_guru_izin }}')">
                            </td>
                            <td style="white-space: nowrap;">
                                <div style="font-weight: 700; color: #1e293b;">
                                    {{ $tglFormat }}
                                </div>
                                <div style="margin-top: 4px;">
                                    @if($iz->kategori_izin === 'cuti')
                                        <span style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                            Cuti (>3 Hari)
                                        </span>
                                    @else
                                        <span style="background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                            Izin Biasa
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="color: #1e293b; font-weight: 600;">{{ $iz->alasan }}</div>
                                @if($iz->materi_dititipkan)
                                    <div style="font-size: 11.5px; color: #475569; margin-top: 3px;">
                                        <i class="fa-solid fa-book"></i> Titipan: {{ $iz->materi_dititipkan }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($iz->status_piket === 'pending')
                                    <span class="status-badge pending">
                                        <i class="fa-solid fa-clock-rotate-left"></i> Menunggu Diproses Guru Piket
                                    </span>
                                    <div class="piket-pending-box">
                                        <i class="fa-solid fa-circle-info"></i> Menunggu Guru Piket memvalidasi & mengisikan data ke sistem.
                                    </div>
                                @else
                                    <span class="status-badge disetujui">
                                        <i class="fa-solid fa-circle-check"></i> Sudah Diisikan Guru Piket
                                    </span>
                                    <div class="piket-notif-box">
                                        <i class="fa-solid fa-user-shield"></i> Data izin telah diisikan & dikirim ke Waka/Kepsek oleh Guru Piket: <strong>{{ $iz->nama_guru_piket ?? ($iz->guruPiket->nama_guru ?? 'Petugas Piket') }}</strong> @if($iz->nip_guru_piket || ($iz->guruPiket->nip ?? null)) (NIP. {{ $iz->nip_guru_piket ?? $iz->guruPiket->nip }}) @endif.
                                    </div>
                                @endif
                            </td>
                            <!-- Status Waka Kurikulum -->
                            <td>
                                @if($iz->status_waka === 'approved')
                                    <span class="status-badge disetujui"><i class="fa-solid fa-check"></i> Disetujui</span>
                                @elseif($iz->status_waka === 'rejected')
                                    <span class="status-badge ditolak"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                    @if($iz->catatan_waka)
                                        <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">Ket: {{ $iz->catatan_waka }}</div>
                                    @endif
                                @else
                                    <span class="status-badge menunggu"><i class="fa-solid fa-clock"></i> Menunggu</span>
                                @endif
                            </td>
                            <!-- Status Waka SDM -->
                            <td>
                                @if($iz->status_waka_sdm === 'approved')
                                    <span class="status-badge disetujui"><i class="fa-solid fa-check"></i> Disetujui</span>
                                @elseif($iz->status_waka_sdm === 'rejected')
                                    <span class="status-badge ditolak"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                @else
                                    <span class="status-badge menunggu"><i class="fa-solid fa-clock"></i> Menunggu</span>
                                @endif
                            </td>
                            <!-- Status Kepsek -->
                            <td>
                                @if($iz->status_kepsek === 'approved')
                                    <span class="status-badge disetujui"><i class="fa-solid fa-check"></i> Disetujui</span>
                                @elseif($iz->status_kepsek === 'rejected')
                                    <span class="status-badge ditolak"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                                    @if($iz->catatan_kepsek)
                                        <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">Ket: {{ $iz->catatan_kepsek }}</div>
                                    @endif
                                @else
                                    <span class="status-badge menunggu"><i class="fa-solid fa-clock"></i> Menunggu</span>
                                @endif
                            </td>
                            <!-- Status Final -->
                            <td>
                                @if($isRejectedRow)
                                    <span class="status-badge ditolak"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                                @elseif($isApprovedFullRow)
                                    <span class="status-badge disetujui"><i class="fa-solid fa-circle-check"></i> Disetujui Full</span>
                                @else
                                    <span class="status-badge menunggu"><i class="fa-solid fa-hourglass-half"></i> Dalam Proses</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; flex-wrap: wrap; justify-content: center;">
                                    <button type="button" onclick="triggerSendChatbotFromAction('{{ $iz->id_guru_izin }}')" class="btn-action-btn btn-action-chatbot" title="Kirim Notifikasi via ChatBot WhatsApp">
                                        <i class="fa-solid fa-robot"></i> ChatBot WA
                                    </button>

                                    <a href="{{ $waSendUrl }}" target="_blank" class="btn-action-btn btn-action-wa" title="Cadangan Manual Link WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i> WA Manual
                                    </a>

                                    <button type="button" onclick="copyPiketLinkDirect('{{ $piketAccessUrl }}')" class="btn-action-btn btn-action-copy" title="Salin Link Guru Piket">
                                        <i class="fa-solid fa-copy"></i> Salin Link
                                    </button>

                                    <button type="button" onclick="openDetailModalById('{{ $iz->id_guru_izin }}')" class="btn-action-btn btn-action-detail" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>

                                    <button type="button" onclick="openEditModalById('{{ $iz->id_guru_izin }}')" class="btn-action-btn btn-action-edit" title="Edit Data">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>

                                    <button type="button" onclick="confirmSingleDelete({{ $iz->id_guru_izin }})" class="btn-action-btn btn-action-delete" title="Hapus ke Sampah">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 36px; color: #94a3b8; font-weight: 600;">
                                <i class="fa-solid fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                                Belum ada data permintaan izin tidak hadir.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Cards View (Tampil Khusus di Layar Mobile HP) -->
        <div class="mobile-cards-wrapper">
            @if($myIzinList->isNotEmpty())
                <div class="mobile-select-all-bar">
                    <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #334155; cursor: pointer; margin: 0;">
                        <input type="checkbox" id="selectAllMobile" class="custom-checkbox" onchange="toggleSelectAll(this)" title="Pilih Semua Data Izin">
                        <span>Pilih Semua Data Izin</span>
                    </label>
                    <span style="font-size: 12px; font-weight: 700; color: #64748b;">{{ $myIzinList->count() }} Data</span>
                </div>
            @endif

            @forelse($myIzinList as $iz)
            @php
                $piketAccessUrl = url('/guru-piket/permintaan-izin');
                $tglFormat = ($iz->tanggal_mulai === $iz->tanggal_selesai || !$iz->tanggal_selesai)
                    ? \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y')
                    : \Carbon\Carbon::parse($iz->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($iz->tanggal_selesai)->format('d-m-Y');
                
                $waText = "*PERMINTAAN IZIN GURU MENGAJAR*\n"
                    . "----------------------------------\n"
                    . "*Pengaju:* " . ($iz->guru->nama_guru ?? Auth::user()->name) . " (NIP. " . ($iz->guru->nip ?? Auth::user()->nip ?? '-') . ")\n"
                    . "*Kategori:* " . ucfirst($iz->kategori_izin) . "\n"
                    . "*Tanggal:* " . $tglFormat . "\n"
                    . "*Alasan:* " . $iz->alasan . "\n"
                    . ($iz->materi_dititipkan ? "*Titipan Materi:* " . $iz->materi_dititipkan . "\n" : "")
                    . "----------------------------------\n"
                    . "Mohon Bapak/Ibu Guru Piket dapat mengecek, memvalidasi, dan mengisikan data izin melalui sistem Web EDU JOURNAL pada tautan berikut:\n"
                    . $piketAccessUrl;

                $waSendUrl = "https://api.whatsapp.com/send?text=" . rawurlencode($waText);

                $isRejectedRow = ($iz->status_waka === 'rejected' || $iz->status_waka_sdm === 'rejected' || $iz->status_kepsek === 'rejected' || $iz->status_final === 'rejected');
                $isApprovedFullRow = ($iz->status_waka === 'approved' && $iz->status_waka_sdm === 'approved' && $iz->status_kepsek === 'approved');

                $detailData = [
                    'id_guru_izin' => $iz->id_guru_izin,
                    'id_guru' => $iz->id_guru,
                    'nama_guru' => $iz->guru->nama_guru ?? Auth::user()->name,
                    'nip' => $iz->guru->nip ?? Auth::user()->nip ?? '-',
                    'tanggal' => $tglFormat,
                    'tanggal_mulai' => $iz->tanggal_mulai,
                    'tanggal_selesai' => $iz->tanggal_selesai,
                    'durasi' => $iz->durasi,
                    'kategori_izin' => $iz->kategori_izin,
                    'alasan' => $iz->alasan,
                    'keterangan_khusus' => $iz->keterangan_khusus,
                    'materi' => $iz->materi_dititipkan,
                    'foto_url' => $iz->foto_url,
                    'file_tugas_url' => $iz->file_tugas_url,
                    'status_piket' => $iz->status_piket,
                    'nama_guru_piket' => $iz->nama_guru_piket ?? ($iz->guruPiket->nama_guru ?? 'Petugas Piket'),
                    'nip_guru_piket' => $iz->nip_guru_piket ?? ($iz->guruPiket->nip ?? '-'),
                    'status_waka' => ucfirst($iz->status_waka ?? 'pending'),
                    'status_waka_sdm' => ucfirst($iz->status_waka_sdm ?? 'pending'),
                    'status_kepsek' => ucfirst($iz->status_kepsek ?? 'pending'),
                    'catatan_waka' => $iz->catatan_waka,
                    'catatan_kepsek' => $iz->catatan_kepsek,
                    'status_final' => $isRejectedRow ? 'Ditolak' : ($isApprovedFullRow ? 'Disetujui Full' : 'Dalam Proses'),
                    'piket_url' => $piketAccessUrl,
                ];

                $targetPiketNama = $iz->nama_guru_piket ?? ($iz->guruPiket->nama_guru ?? 'Petugas Guru Piket');
                $targetPiketPhone = $iz->guruPiket->no_hp ?? ($iz->no_wa_guru_piket ?? '');

                $chatbotData = [
                    'id_guru_izin' => $iz->id_guru_izin,
                    'id_guru' => $iz->id_guru,
                    'nama_guru' => $iz->guru->nama_guru ?? Auth::user()->name,
                    'nip' => $iz->guru->nip ?? Auth::user()->nip ?? '-',
                    'kategori' => ($iz->kategori_izin === 'cuti' || str_contains(strtolower($iz->durasi ?? ''), 'cuti')) ? 'Cuti / Izin Khusus (>3 Hari)' : 'Izin Biasa (1 s/d 3 Hari)',
                    'tanggal' => $tglFormat,
                    'tanggal_mulai' => $iz->tanggal_mulai,
                    'alasan' => $iz->alasan,
                    'materi' => $iz->materi_dititipkan ?: ($iz->tugas_dititipkan ?: '-'),
                    'piket_url' => $piketAccessUrl,
                    'wa_message' => $waText,
                    'wa_direct_url' => $waSendUrl,
                    'target_piket_nama' => $targetPiketNama,
                    'target_phone' => $targetPiketPhone,
                ];

                $chatbotDataMap[$iz->id_guru_izin] = $chatbotData;
                $detailDataMap[$iz->id_guru_izin] = $detailData;
            @endphp
            <div class="mobile-izin-card" id="card_izin_{{ $iz->id_guru_izin }}">
                <!-- Card Header -->
                <div class="mobile-izin-header">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" class="izin-checkbox custom-checkbox" value="{{ $iz->id_guru_izin }}" onchange="handleItemCheckboxChange('{{ $iz->id_guru_izin }}')">
                        <div>
                            <div style="font-weight: 800; font-size: 14px; color: #0f172a;">
                                {{ $tglFormat }}
                            </div>
                            <div style="margin-top: 3px;">
                                @if($iz->kategori_izin === 'cuti')
                                    <span style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 800;">
                                        Cuti (>3 Hari)
                                    </span>
                                @else
                                    <span style="background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 800;">
                                        Izin Biasa
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        @if($isRejectedRow)
                            <span class="status-badge ditolak" style="font-size: 11px; padding: 4px 10px;">
                                <i class="fa-solid fa-circle-xmark"></i> Ditolak
                            </span>
                        @elseif($isApprovedFullRow)
                            <span class="status-badge disetujui" style="font-size: 11px; padding: 4px 10px;">
                                <i class="fa-solid fa-circle-check"></i> Disetujui Full
                            </span>
                        @else
                            <span class="status-badge menunggu" style="font-size: 11px; padding: 4px 10px;">
                                <i class="fa-solid fa-hourglass-half"></i> Dalam Proses
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Card Body -->
                <div class="mobile-izin-body">
                    <div style="margin-bottom: 12px;">
                        <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px;">
                            Alasan Permohonan Izin:
                        </div>
                        <div style="font-size: 13.5px; font-weight: 700; color: #1e293b; line-height: 1.45;">
                            {{ $iz->alasan }}
                        </div>
                        @if($iz->materi_dititipkan)
                            <div style="font-size: 12px; color: #334155; margin-top: 6px; background: #f8fafc; padding: 8px 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-weight: 600;">
                                <i class="fa-solid fa-book" style="color: #384972;"></i> <strong style="color: #0f172a;">Titipan Materi:</strong> {{ $iz->materi_dititipkan }}
                            </div>
                        @endif
                        @if($iz->keterangan_khusus)
                            <div style="font-size: 12px; color: #c2410c; margin-top: 6px; background: #fff7ed; padding: 8px 10px; border-radius: 8px; border: 1px solid #fed7aa; font-weight: 600;">
                                <i class="fa-solid fa-note-sticky"></i> <strong style="color: #9a3412;">Ket. Khusus Cuti:</strong> {{ $iz->keterangan_khusus }}
                            </div>
                        @endif
                    </div>

                    <!-- Status Piket Notif Box -->
                    <div style="margin-bottom: 10px;">
                        @if($iz->status_piket === 'pending')
                            <div class="piket-pending-box" style="margin-top: 0; padding: 8px 10px;">
                                <div style="font-weight: 800; display: flex; align-items: center; gap: 6px; margin-bottom: 3px;">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Menunggu Diproses Guru Piket
                                </div>
                                <span style="font-size: 11.5px;">Menunggu Guru Piket memvalidasi & mengisikan data ke sistem.</span>
                            </div>
                        @else
                            <div class="piket-notif-box" style="margin-top: 0; padding: 8px 10px;">
                                <div style="font-weight: 800; display: flex; align-items: center; gap: 6px; margin-bottom: 3px;">
                                    <i class="fa-solid fa-circle-check"></i> Sudah Diisikan Guru Piket
                                </div>
                                <span style="font-size: 11.5px;">
                                    Diisikan & dikirim oleh Guru Piket: <strong>{{ $iz->nama_guru_piket ?? ($iz->guruPiket->nama_guru ?? 'Petugas Piket') }}</strong> @if($iz->nip_guru_piket || ($iz->guruPiket->nip ?? null)) (NIP. {{ $iz->nip_guru_piket ?? $iz->guruPiket->nip }}) @endif.
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Approval Grid: 3 Kolom -->
                    <div class="mobile-approval-grid">
                        <div class="mobile-approval-item">
                            <span class="mobile-approval-label">Waka Kurikulum</span>
                            @if($iz->status_waka === 'approved')
                                <span class="status-badge disetujui" style="font-size: 10.5px; padding: 2px 6px;"><i class="fa-solid fa-check"></i> Disetujui</span>
                            @elseif($iz->status_waka === 'rejected')
                                <span class="status-badge ditolak" style="font-size: 10.5px; padding: 2px 6px;"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                            @else
                                <span class="status-badge menunggu" style="font-size: 10.5px; padding: 2px 6px;"><i class="fa-solid fa-clock"></i> Menunggu</span>
                            @endif
                            @if($iz->catatan_waka)
                                <small style="font-size: 10px; color: #dc2626; display: block; line-height: 1.2;">{{ $iz->catatan_waka }}</small>
                            @endif
                        </div>

                        <div class="mobile-approval-item">
                            <span class="mobile-approval-label">Waka SDM</span>
                            @if($iz->status_waka_sdm === 'approved')
                                <span class="status-badge disetujui" style="font-size: 10.5px; padding: 2px 6px;"><i class="fa-solid fa-check"></i> Disetujui</span>
                            @elseif($iz->status_waka_sdm === 'rejected')
                                <span class="status-badge ditolak" style="font-size: 10.5px; padding: 2px 6px;"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                            @else
                                <span class="status-badge menunggu" style="font-size: 10.5px; padding: 2px 6px;"><i class="fa-solid fa-clock"></i> Menunggu</span>
                            @endif
                        </div>

                        <div class="mobile-approval-item">
                            <span class="mobile-approval-label">Kepala Sekolah</span>
                            @if($iz->status_kepsek === 'approved')
                                <span class="status-badge disetujui" style="font-size: 10.5px; padding: 2px 6px;"><i class="fa-solid fa-check"></i> Disetujui</span>
                            @elseif($iz->status_kepsek === 'rejected')
                                <span class="status-badge ditolak" style="font-size: 10.5px; padding: 2px 6px;"><i class="fa-solid fa-xmark"></i> Ditolak</span>
                            @else
                                <span class="status-badge menunggu" style="font-size: 10.5px; padding: 2px 6px;"><i class="fa-solid fa-clock"></i> Menunggu</span>
                            @endif
                            @if($iz->catatan_kepsek)
                                <small style="font-size: 10px; color: #dc2626; display: block; line-height: 1.2;">{{ $iz->catatan_kepsek }}</small>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card Footer (Action Buttons) -->
                <div class="mobile-izin-footer">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; width: 100%; margin-bottom: 8px;">
                        <button type="button" onclick="triggerSendChatbotFromAction('{{ $iz->id_guru_izin }}')" class="btn-action-btn btn-action-chatbot" style="justify-content: center; width: 100%; box-sizing: border-box; padding: 8px 10px; font-size: 12px;">
                            <i class="fa-solid fa-robot"></i> ChatBot WA
                        </button>
                        <a href="{{ $waSendUrl }}" target="_blank" class="btn-action-btn btn-action-wa" style="justify-content: center; width: 100%; box-sizing: border-box; padding: 8px 10px; font-size: 12px;">
                            <i class="fa-brands fa-whatsapp"></i> WA Manual
                        </a>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 6px; width: 100%;">
                        <button type="button" onclick="copyPiketLinkDirect('{{ $piketAccessUrl }}')" class="btn-action-btn btn-action-copy" style="justify-content: center; width: 100%; box-sizing: border-box; padding: 8px 4px; font-size: 11.5px;">
                            <i class="fa-solid fa-copy"></i> Salin
                        </button>
                        <button type="button" onclick="openDetailModalById('{{ $iz->id_guru_izin }}')" class="btn-action-btn btn-action-detail" style="justify-content: center; width: 100%; box-sizing: border-box; padding: 8px 4px; font-size: 11.5px;">
                            <i class="fa-solid fa-eye"></i> Detail
                        </button>
                        <button type="button" onclick="openEditModalById('{{ $iz->id_guru_izin }}')" class="btn-action-btn btn-action-edit" style="justify-content: center; width: 100%; box-sizing: border-box; padding: 8px 4px; font-size: 11.5px;">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                        <button type="button" onclick="confirmSingleDelete({{ $iz->id_guru_izin }})" class="btn-action-btn btn-action-delete" style="justify-content: center; width: 100%; box-sizing: border-box; padding: 8px 4px; font-size: 11.5px;">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 36px 16px; color: #94a3b8; font-weight: 600; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px;">
                <i class="fa-solid fa-inbox" style="font-size: 28px; margin-bottom: 8px; display: block; color: #cbd5e1;"></i>
                Belum ada data permintaan izin tidak hadir.
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Floating Pop-up Batch Toolbar -->
<div id="floatingBatchBar" class="floating-batch-bar">
    <div style="font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
        <span id="selectedCountBadge" style="background: #2563eb; color: #fff; padding: 2px 9px; border-radius: 20px; font-size: 12px; font-weight: 800;">0</span>
        <span>Permintaan Izin Terpilih</span>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <button type="button" onclick="openBatchDeleteModal()" style="background: #ef4444; color: #fff; border: none; padding: 7px 16px; border-radius: 30px; font-size: 12.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease;">
            <i class="fa-solid fa-trash-can"></i> Hapus Terpilih
        </button>
        <button type="button" onclick="uncheckAll()" style="background: rgba(255,255,255,0.2); color: #fff; border: none; padding: 7px 14px; border-radius: 30px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s ease;">
            Batal
        </button>
    </div>
</div>

<!-- Modal Detail Permintaan Izin -->
<div id="detailModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Detail Permintaan Izin Saya</h3>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <div class="modal-body">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 14px; border-radius: 12px; margin-bottom: 16px;">
                <div style="font-size: 14px; font-weight: 800; color: #0f172a;" id="dt_nama_guru">-</div>
                <div style="font-size: 12px; color: #64748b;" id="dt_nip">-</div>
            </div>

            <table style="width: 100%; border-collapse: collapse; font-size: 13px; color: #334155;">
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; width: 150px; color: #64748b;">Tanggal Izin:</td>
                    <td style="padding: 8px 0; font-weight: 700; color: #0f172a;" id="dt_tanggal_durasi">-</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; color: #64748b;">Alasan Umum:</td>
                    <td style="padding: 8px 0;" id="dt_alasan">-</td>
                </tr>
                <tr id="dt_keterangan_khusus_container" style="display: none;">
                    <td style="padding: 8px 0; font-weight: 700; color: #c2410c;">Keterangan Cuti:</td>
                    <td style="padding: 8px 0; color: #c2410c; font-weight: 600;" id="dt_keterangan_khusus">-</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; color: #64748b;">Titipan Materi:</td>
                    <td style="padding: 8px 0;" id="dt_materi">-</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; color: #64748b;">Status Guru Piket:</td>
                    <td style="padding: 8px 0; font-weight: 700;" id="dt_status_piket">-</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; color: #64748b;">Status Waka Kurikulum:</td>
                    <td style="padding: 8px 0;" id="dt_status_waka">-</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; color: #64748b;">Status Waka SDM:</td>
                    <td style="padding: 8px 0;" id="dt_status_waka_sdm">-</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 700; color: #64748b;">Status Kepala Sekolah:</td>
                    <td style="padding: 8px 0;" id="dt_status_kepsek">-</td>
                </tr>
            </table>

            <div id="dt_foto_container" style="display: none; margin-top: 16px; border-top: 1px solid #e2e8f0; padding-top: 14px;">
                <label style="font-weight: 700; font-size: 12.5px; color: #475569; display: block; margin-bottom: 8px;">Dokumen / Foto Surat Bukti:</label>
                <a id="dt_foto_link" href="#" target="_blank" style="display: inline-block;">
                    <img id="dt_foto_img" src="" alt="Foto Surat Bukti" style="max-width: 100%; max-height: 200px; border-radius: 10px; border: 1px solid #cbd5e1; object-fit: contain;">
                </a>
            </div>

            <div id="dt_file_container" style="display: none; margin-top: 12px;">
                <label style="font-weight: 700; font-size: 12.5px; color: #475569; display: block; margin-bottom: 4px;">File Tugas Pengganti Terlampir:</label>
                <a id="dt_file_link" href="#" target="_blank" style="color: #2563eb; font-weight: 700; text-decoration: underline; font-size: 13px;">
                    <i class="fa-solid fa-file-arrow-down"></i> Unduh File Tugas Terlampir
                </a>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeDetailModal()" class="btn-reset-light">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Edit Permintaan Izin -->
<div id="editModal" class="modal-backdrop">
    <div class="modal-card" style="max-width: 680px;">
        <div class="modal-header">
            <h3>Edit Permintaan Izin Saya</h3>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <form id="editForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <!-- Guru yang Meminta Izin (Readonly) -->
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Guru yang meminta izin</label>
                    <input type="text" id="edit_nama_guru" class="form-control-custom" readonly style="background: #f1f5f9; font-weight: 700; color: #1e293b;">
                </div>

                <!-- Kategori Izin -->
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Kategori Izin</label>
                    <select name="kategori_izin" id="edit_kategori_izin" class="form-control-custom" onchange="checkEditDurationCategory()" required>
                        <option value="biasa">Izin Biasa (1 s/d 3 Hari)</option>
                        <option value="cuti">Cuti / Izin Khusus (> 3 Hari)</option>
                    </select>
                </div>

                <!-- Tanggal Mulai & Selesai -->
                <div class="form-row-2col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label class="form-label-custom">Tanggal Mulai Izin</label>
                        <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control-custom" onchange="checkEditDurationCategory()" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Tanggal Selesai Izin</label>
                        <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control-custom" onchange="checkEditDurationCategory()">
                    </div>
                </div>

                <!-- Banner Notifikasi Cuti (> 3 Hari) -->
                <div id="edit_bannerCutiWarning" style="display: none; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; color: #c2410c; font-size: 13px; font-weight: 700;">
                    <i class="fa-solid fa-triangle-exclamation"></i> Deteksi Izin > 3 Hari (Cuti/Izin Khusus): Wajib mengisi Keterangan Khusus & mengunggah Dokumen Bukti Resmi Cuti!
                </div>

                <!-- Alasan Umum Izin -->
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Alasan Umum Izin</label>
                    <textarea name="alasan" id="edit_alasan" class="form-control-custom" rows="2" placeholder="Tuliskan alasan umum..." required></textarea>
                </div>

                <!-- Container Keterangan Khusus Cuti -->
                <div id="edit_keteranganKhususContainer" style="display: none; margin-bottom: 16px; background: #fff7ed; padding: 16px; border-radius: 12px; border: 1px solid #fed7aa;">
                    <label class="form-label-custom" style="color: #c2410c; font-size: 13px;">
                        Keterangan Khusus Cuti / Izin Khusus (> 3 Hari) <span style="color: #dc2626;">*Wajib Diisi</span>
                    </label>
                    <small style="color: #ea580c; display: block; margin-bottom: 8px;">
                        Tuliskan rincian penjelasan mengapa permohonan izin dilakukan lebih dari 3 hari (Cuti) agar Waka & Kepsek mengetahui dengan tepat alasannya.
                    </small>
                    <textarea name="keterangan_khusus" id="edit_keterangan_khusus" class="form-control-custom" rows="2" placeholder="Tuliskan penjelasan khusus permohonan Cuti / Izin Khusus..."></textarea>
                </div>

                <!-- Opsi Titipan & Upload Foto Surat -->
                <div class="form-row-2col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label class="form-label-custom">Titipan Materi / Tugas (Opsional)</label>
                        <input type="text" name="materi_dititipkan" id="edit_materi_dititipkan" class="form-control-custom" placeholder="Contoh: Kerjakan Bab 3 Halaman 45">
                    </div>
                    <div>
                        <label class="form-label-custom" id="edit_labelFotoSurat">Upload Foto Surat / Bukti Izin Baru</label>
                        <input type="file" name="foto_surat" id="edit_inputFotoSurat" class="form-control-custom" accept="image/*">
                        
                        <!-- Pratinjau Foto Bukti Terlampir -->
                        <div id="edit_foto_preview_container" style="display: none; margin-top: 10px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 10px 14px;">
                            <small style="font-size: 11.5px; font-weight: 800; color: #1e40af; text-transform: uppercase; display: block; margin-bottom: 6px;">
                                Foto Surat / Bukti Terlampir Saat Ini:
                            </small>
                            <a id="edit_foto_link" href="#" target="_blank">
                                <img id="edit_foto_img" src="" alt="Pratinjau Foto" style="max-height: 130px; border-radius: 8px; border: 1px solid #93c5fd; object-fit: contain; display: block;">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Upload File Tugas -->
                <div style="margin-bottom: 16px;">
                    <label class="form-label-custom">Upload File Tugas Baru (Opsional)</label>
                    <input type="file" name="file_tugas" class="form-control-custom">

                    <div id="edit_file_preview_container" style="display: none; margin-top: 8px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px;">
                        <small style="font-size: 12px; color: #1e293b; font-weight: 700;">
                            <i class="fa-solid fa-file-arrow-down" style="color: #2563eb;"></i> File Tugas Saat Ini: <a id="edit_file_link" href="#" target="_blank" style="color: #2563eb; text-decoration: underline; font-weight: 700;">Unduh File Tugas</a>
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeEditModal()" class="btn-reset-light">Batal</button>
                <button type="submit" class="btn-kirim-izin">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Satuan -->
<div id="singleDeleteModal" class="modal-backdrop">
    <div class="modal-card" style="max-width: 460px;">
        <div class="modal-header" style="background: #ef4444;">
            <h3>Konfirmasi Hapus Data</h3>
            <button type="button" onclick="closeSingleDeleteModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <form id="singleDeleteForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body" style="text-align: center; padding: 28px 24px;">
                <div style="width: 56px; height: 56px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px auto;">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 800; color: #1e293b;">Pindahkan Data ke Sampah?</h4>
                <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                    Data permohonan izin ini akan dipindahkan ke Sampah. Notifikasi di akun Guru Piket akan otomatis dibersihkan. Anda dapat memulihkannya kembali sewaktu-waktu dari menu Sampah.
                </p>
            </div>
            <div class="modal-footer" style="justify-content: center; gap: 12px;">
                <button type="button" onclick="closeSingleDeleteModal()" class="btn-reset-light" style="padding: 10px 20px;">Batal</button>
                <button type="submit" class="btn-action-btn" style="background: #dc2626; color: #fff; border-radius: 10px; padding: 10px 20px; font-size: 13px;">
                    <i class="fa-solid fa-trash-can"></i> Ya, Pindahkan ke Sampah
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Terpilih (Batch) -->
<div id="batchDeleteModal" class="modal-backdrop">
    <div class="modal-card" style="max-width: 480px;">
        <div class="modal-header" style="background: #ef4444;">
            <h3>Hapus Banyak Data Izin</h3>
            <button type="button" onclick="closeBatchDeleteModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <form id="batchDeleteForm" action="{{ route('guru.permintaan-izin.destroy-batch') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="ids" id="batchDeleteIds">
            <div class="modal-body" style="text-align: center; padding: 28px 24px;">
                <div style="width: 56px; height: 56px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px auto;">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 800; color: #1e293b;">Hapus <span id="batchModalCount">0</span> Data Terpilih?</h4>
                <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                    Semua data izin yang Anda centang akan dipindahkan ke Tempat Sampah secara bersamaan. Anda tetap bisa memulihkan data tersebut dari menu Tempat Sampah.
                </p>
            </div>
            <div class="modal-footer" style="justify-content: center; gap: 12px;">
                <button type="button" onclick="closeBatchDeleteModal()" class="btn-reset-light" style="padding: 10px 20px;">Batal</button>
                <button type="submit" class="btn-action-btn" style="background: #dc2626; color: #fff; border-radius: 10px; padding: 10px 20px; font-size: 13px;">
                    <i class="fa-solid fa-trash-can"></i> Ya, Pindahkan Semua ke Sampah
                </button>
            </div>
        </form>
<!-- Modal Interaktif Kirim Notifikasi via ChatBot WhatsApp ke Guru Piket -->
<div id="chatbotWaModal" class="modal-backdrop" onclick="closeChatbotWaModal(event)">
    <div class="modal-card" style="max-width: 600px;" onclick="event.stopPropagation()">
        <div class="modal-header" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
            <h3 style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-robot" style="font-size: 20px;"></i>
                Kirim Pemberitahuan via ChatBot WhatsApp
            </h3>
            <button type="button" onclick="closeChatbotWaModalDirect()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <div class="modal-body" style="padding: 22px;">
            <!-- Informasi Pengaju Izin -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 6px; margin-bottom: 6px;">
                    <div style="font-size: 14px; font-weight: 800; color: #0f172a;" id="cb_modal_guru_nama">-</div>
                    <span id="cb_modal_kategori_badge" style="font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 12px; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">-</span>
                </div>
                <div style="font-size: 12px; color: #475569; font-weight: 600;">
                    <i class="fa-solid fa-calendar-day" style="color: #64748b; margin-right: 4px;"></i> Rentang Tanggal: <strong id="cb_modal_tanggal" style="color: #0f172a;">-</strong>
                </div>
                <div style="font-size: 12px; color: #475569; font-weight: 600; margin-top: 4px;">
                    <i class="fa-solid fa-circle-question" style="color: #64748b; margin-right: 4px;"></i> Alasan: <span id="cb_modal_alasan" style="color: #334155; font-weight: 700;">-</span>
                </div>
            </div>

            <!-- Pilihan Nomor WhatsApp Guru Piket Penerima -->
            <div style="margin-bottom: 16px;">
                <label class="form-label-custom" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                    <span>Tujuan Nomor WhatsApp Guru Piket:</span>
                    <span style="font-size: 11px; font-weight: 700; color: #16a34a; background: #dcfce7; padding: 2px 7px; border-radius: 6px;">
                        <i class="fa-solid fa-check"></i> Gateway Aktif
                    </span>
                </label>
                <div>
                    <select id="cb_modal_target_select" class="form-control-custom" onchange="onChatbotTargetSelectChange(this)" style="font-size: 13px; font-weight: 600;">
                        <option value="">-- Otomatis (Guru Piket Hari Ini & Petugas Piket) --</option>
                        @if(isset($piketUsers) && count($piketUsers) > 0)
                            <optgroup label="Akun Petugas Piket">
                                @foreach($piketUsers as $pu)
                                    @if(!empty($pu->no_hp))
                                        <option value="{{ $pu->no_hp }}" data-name="{{ $pu->name }}">{{ $pu->name }} (Akun Resmi Piket) - {{ $pu->no_hp }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        @endif
                        @if(isset($piketOptions))
                            @php
                                $todayPiketOpts = collect($piketOptions)->where('group', 'Guru Piket Terjadwal Hari Ini');
                            @endphp
                            @if($todayPiketOpts->isNotEmpty())
                                <optgroup label="Guru Piket Terjadwal Hari Ini">
                                    @foreach($todayPiketOpts as $opt)
                                        <option value="{{ $opt['phone'] }}" data-name="{{ $opt['name'] }}">{{ $opt['label'] }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endif
                    </select>
                </div>
                <div style="margin-top: 6px; display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 11.5px; color: #64748b; font-weight: 600; white-space: nowrap;">Atau no HP lain:</span>
                    <input type="text" id="cb_modal_custom_phone" class="form-control-custom" placeholder="Contoh: 081234567890" style="padding: 6px 10px; font-size: 12px;" oninput="updateChatbotPreviewMessage()">
                </div>
            </div>

            <!-- Tautan Halaman Akses Guru Piket -->
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 10px 14px; margin-bottom: 16px;">
                <div style="font-size: 11px; font-weight: 800; color: #166534; text-transform: uppercase; margin-bottom: 3px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-link" style="color: #16a34a;"></i> Tautan Sistem Guru Piket yang Terlampir pada Chat:
                </div>
                <div style="word-break: break-all; font-size: 12px;">
                    <a id="cb_modal_link" href="#" target="_blank" style="color: #15803d; font-weight: 700; text-decoration: underline;">-</a>
                </div>
            </div>

            <!-- Pratinjau Teks Pesan WhatsApp Chatbot -->
            <label class="form-label-custom" style="margin-bottom: 4px; display: block; font-size: 12px;">
                <i class="fa-solid fa-comment-dots"></i> Pratinjau Pesan yang Dikirimkan ChatBot WhatsApp:
            </label>
            <textarea id="cb_modal_text" rows="6" class="form-control-custom" readonly style="font-size: 11.5px; font-family: monospace; background: #f8fafc; resize: vertical; line-height: 1.4; margin-bottom: 14px;"></textarea>

            <!-- Alert Response Status -->
            <div id="cb_status_alert" style="display: none; padding: 12px 14px; border-radius: 10px; margin-bottom: 14px; font-size: 12.5px; font-weight: 700;"></div>
        </div>
        <div class="modal-footer" style="background: #f8fafc; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <button type="button" id="btn_submit_chatbot" class="btn-action-btn" style="background: #10b981; color: #ffffff; border-radius: 8px; padding: 9px 16px; font-size: 13px; font-weight: 800;" onclick="submitSendChatbotWa()">
                    <i class="fa-solid fa-robot"></i> <span>Kirim via ChatBot WA</span>
                </button>
                <a id="cb_modal_manual_link" href="#" target="_blank" class="btn-action-btn btn-action-wa" style="border-radius: 8px; padding: 9px 14px; font-size: 12.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-brands fa-whatsapp"></i> Cadangan Manual WA
                </a>
                <button type="button" class="btn-action-btn btn-action-copy" style="border-radius: 8px; padding: 9px 12px; font-size: 12.5px; font-weight: 700;" onclick="copyChatbotWaText()">
                    <i class="fa-solid fa-copy"></i> Salin Teks
                </button>
            </div>
            <button type="button" onclick="closeChatbotWaModalDirect()" class="btn-reset-light" style="padding: 9px 16px; font-size: 12.5px;">
                Tutup
            </button>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    const izinChatbotMap = @json($chatbotDataMap ?? []);
    const izinDetailMap = @json($detailDataMap ?? []);

    function openDetailModalById(id) {
        if (izinDetailMap && izinDetailMap[id]) {
            openDetailModal(izinDetailMap[id]);
        }
    }

    function openEditModalById(id) {
        if (izinDetailMap && izinDetailMap[id]) {
            openEditModal(izinDetailMap[id]);
        }
    }

    function openChatbotModalById(id) {
        if (izinChatbotMap && izinChatbotMap[id]) {
            openChatbotModal(izinChatbotMap[id]);
        }
    }

    function triggerSendChatbotFromAction(id) {
        const data = (izinChatbotMap && izinChatbotMap[id]) ? izinChatbotMap[id] : null;
        if (!data) {
            executeSendChatbot(id, '');
            return;
        }

        const namaPengaju = data.nama_guru || 'Guru';
        const rentangTgl = data.tanggal || '';
        const namaPiket = data.target_piket_nama || (data.nama_guru_piket || 'Petugas Guru Piket');
        const noPiket = data.target_phone || '';

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Kirim via ChatBot WhatsApp?',
                html: `
                    <div style="text-align: left; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; margin: 12px 0; font-size: 13px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; color: #047857; font-weight: 800;">
                            <i class="fa-solid fa-robot" style="font-size: 18px;"></i> Notifikasi ChatBot WhatsApp
                        </div>
                        <div style="color: #334155; margin-bottom: 4px;">
                            <strong>Pengaju:</strong> ${namaPengaju}
                        </div>
                        <div style="color: #334155; margin-bottom: 4px;">
                            <strong>Rentang Izin:</strong> ${rentangTgl}
                        </div>
                        <div style="color: #0f172a; margin-top: 6px; padding-top: 6px; border-top: 1px dashed #cbd5e1;">
                            <strong>Tujuan Guru Piket:</strong> ${namaPiket} ${noPiket ? '(<span style="color:#0284c7; font-weight:700;">' + noPiket + '</span>)' : ''}
                        </div>
                    </div>
                    <p style="font-size: 12.5px; color: #64748b; margin: 0;">
                        Sistem ChatBot WhatsApp akan mengirimkan notifikasi resmi permohonan izin ini ke nomor WhatsApp Guru Piket.
                    </p>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fa-solid fa-paper-plane"></i> Ya, Kirim Sekarang',
                cancelButtonText: 'Batal',
                showDenyButton: true,
                denyButtonText: '<i class="fa-solid fa-sliders"></i> Opsi / Preview',
                denyButtonColor: '#0284c7'
            }).then((result) => {
                if (result.isConfirmed) {
                    executeSendChatbot(id, noPiket);
                } else if (result.isDenied) {
                    openChatbotModalById(id);
                }
            });
        } else {
            if (confirm('Kirimkan notifikasi Permintaan Izin ke WhatsApp Guru Piket (' + namaPiket + ')?')) {
                executeSendChatbot(id, noPiket);
            }
        }
    }

    function executeSendChatbot(id, targetPhone) {
        if (!id) return;

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Mengirim ChatBot WA...',
                html: `
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px; margin-top: 8px;">
                        <div style="font-size: 13.5px; color: #334155; font-weight: 600;">
                            Sedang menghubungkan ke gateway dan mengirimkan notifikasi izin ke Guru Piket...
                        </div>
                        <div style="font-size: 12px; color: #64748b;">
                            Mohon tunggu beberapa saat.
                        </div>
                    </div>
                `,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        fetch("{{ url('/guru-permintaan-izin') }}/" + id + "/send-chatbot", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                target_phone: targetPhone || ''
            })
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'ChatBot Berhasil Terkirim!',
                        html: `
                            <div style="font-size: 14px; color: #14532d; font-weight: 700; margin-bottom: 8px;">
                                ${response.message || 'Pemberitahuan izin berhasil dikirimkan via ChatBot WhatsApp ke Guru Piket.'}
                            </div>
                            <div style="font-size: 12.5px; color: #475569;">
                                Guru Piket dapat langsung mengakses tautan verifikasi permohonan izin melalui pesan WhatsApp tersebut.
                            </div>
                        `,
                        confirmButtonColor: '#10b981',
                        confirmButtonText: '<i class="fa-solid fa-check"></i> Selesai'
                    });
                } else {
                    alert(response.message || 'Pemberitahuan izin berhasil dikirimkan via ChatBot WhatsApp ke Guru Piket.');
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pengiriman ChatBot Belum Berhasil',
                        html: `
                            <div style="font-size: 13.5px; color: #991b1b; font-weight: 700; margin-bottom: 8px;">
                                ${response.message || 'Gagal mengirim pesan via ChatBot WhatsApp.'}
                            </div>
                            <div style="font-size: 12.5px; color: #475569;">
                                Anda dapat memilih nomor tujuan alternatif melalui modal atau gunakan cadangan manual WA.
                            </div>
                        `,
                        confirmButtonColor: '#f59e0b',
                        confirmButtonText: 'Tutup',
                        showCancelButton: true,
                        cancelButtonText: '<i class="fa-solid fa-sliders"></i> Buka Opsi ChatBot',
                        cancelButtonColor: '#0284c7'
                    }).then((res) => {
                        if (res.dismiss === Swal.DismissReason.cancel) {
                            openChatbotModalById(id);
                        }
                    });
                } else {
                    alert(response.message || 'Gagal mengirim pesan via ChatBot WhatsApp.');
                }
            }
        })
        .catch(err => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem / Jaringan',
                    text: 'Terjadi kesalahan jaringan saat memproses pengiriman notifikasi ChatBot WhatsApp.',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            } else {
                alert('Terjadi kesalahan saat memproses ChatBot WhatsApp.');
            }
        });
    }

    // Reset Form Izin function
    function resetFormIzin() {
        const form = document.getElementById('formIzinGuru');
        if (form) {
            form.reset();
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('inputTglMulai').value = today;
            document.getElementById('inputTglSelesai').value = today;
            document.getElementById('selectKategoriIzin').value = 'biasa';
            checkDurationCategory();
            if (typeof updateTargetPiketOptionsByDate === 'function') {
                updateTargetPiketOptionsByDate('wa_target_phone', today, true);
            }
        }
    }

    function checkDurationCategory() {
        const tMulai = document.getElementById('inputTglMulai').value;
        let tSelesai = document.getElementById('inputTglSelesai').value;
        const selectKat = document.getElementById('selectKategoriIzin');
        const bannerWarning = document.getElementById('bannerCutiWarning');
        const containerKhusus = document.getElementById('keteranganKhususContainer');
        const inputKhusus = document.getElementById('inputKeteranganKhusus');
        const labelFoto = document.getElementById('labelFotoSurat');
        const inputFoto = document.getElementById('inputFotoSurat');

        if (tMulai && tSelesai && tSelesai < tMulai) {
            alert('Peringatan: Tanggal Selesai Izin (' + tSelesai + ') tidak boleh lebih awal dari Tanggal Mulai Izin (' + tMulai + ')!');
            document.getElementById('inputTglSelesai').value = tMulai;
            tSelesai = tMulai;
        }

        let diffDays = 1;
        if (tMulai && tSelesai) {
            const d1 = new Date(tMulai);
            const d2 = new Date(tSelesai);
            const diffTime = Math.abs(d2 - d1);
            diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        }

        if (inputFoto) {
            inputFoto.setAttribute('required', 'required');
        }

        if (diffDays > 3 || selectKat.value === 'cuti') {
            selectKat.value = 'cuti';
            bannerWarning.style.display = 'block';
            containerKhusus.style.display = 'block';
            inputKhusus.setAttribute('required', 'required');
            labelFoto.innerHTML = 'Upload Foto Surat / Dokumen Bukti Cuti';
        } else {
            bannerWarning.style.display = 'none';
            containerKhusus.style.display = 'none';
            inputKhusus.removeAttribute('required');
            labelFoto.innerHTML = 'Upload Foto Surat / Bukti Izin';
        }
    }

    function checkEditDurationCategory() {
        const tMulai = document.getElementById('edit_tanggal_mulai').value;
        let tSelesai = document.getElementById('edit_tanggal_selesai').value || tMulai;
        const selectKat = document.getElementById('edit_kategori_izin');
        const bannerWarning = document.getElementById('edit_bannerCutiWarning');
        const containerKhusus = document.getElementById('edit_keteranganKhususContainer');
        const inputKhusus = document.getElementById('edit_keterangan_khusus');
        const labelFoto = document.getElementById('edit_labelFotoSurat');

        if (tMulai && tSelesai && tSelesai < tMulai) {
            alert('Peringatan: Tanggal Selesai Izin (' + tSelesai + ') tidak boleh lebih awal dari Tanggal Mulai Izin (' + tMulai + ')!');
            document.getElementById('edit_tanggal_selesai').value = tMulai;
            tSelesai = tMulai;
        }

        let diffDays = 1;
        if (tMulai && tSelesai) {
            const d1 = new Date(tMulai);
            const d2 = new Date(tSelesai);
            const diffTime = Math.abs(d2 - d1);
            diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        }

        const hasFotoPreview = document.getElementById('edit_foto_preview_container') && document.getElementById('edit_foto_preview_container').style.display !== 'none';

        if (diffDays > 3 || selectKat.value === 'cuti') {
            selectKat.value = 'cuti';
            if (bannerWarning) bannerWarning.style.display = 'block';
            if (containerKhusus) containerKhusus.style.display = 'block';
            if (inputKhusus) inputKhusus.setAttribute('required', 'required');
            if (labelFoto) {
                labelFoto.innerHTML = hasFotoPreview 
                    ? 'Upload Foto Surat / Dokumen Bukti Cuti Baru <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span>'
                    : 'Upload Foto Surat / Dokumen Bukti Cuti Baru';
            }
        } else {
            if (bannerWarning) bannerWarning.style.display = 'none';
            if (containerKhusus) containerKhusus.style.display = 'none';
            if (inputKhusus) inputKhusus.removeAttribute('required');
            if (labelFoto) {
                labelFoto.innerHTML = hasFotoPreview 
                    ? 'Upload Foto Surat / Bukti Izin Baru <span style="color: #10b981; font-weight: 700;">(Foto Terlampir)</span>'
                    : 'Upload Foto Surat / Bukti Izin Baru';
            }
        }
    }

    // Checkbox and Floating Pop-up Batch Selection Logic
    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.izin-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
        });
        const selectAllDesktop = document.getElementById('selectAll');
        const selectAllMobile = document.getElementById('selectAllMobile');
        if (selectAllDesktop) selectAllDesktop.checked = masterCheckbox.checked;
        if (selectAllMobile) selectAllMobile.checked = masterCheckbox.checked;
        updateFloatingBatchBar();
    }

    function handleItemCheckboxChange(id) {
        if (id) {
            const matches = document.querySelectorAll('.izin-checkbox[value="' + id + '"]');
            const targetState = (window.event && window.event.target) ? window.event.target.checked : (matches[0] ? matches[0].checked : false);
            matches.forEach(cb => { cb.checked = targetState; });
        }
        
        const allIds = Array.from(new Set(Array.from(document.querySelectorAll('.izin-checkbox')).map(cb => cb.value)));
        const checkedIds = Array.from(new Set(Array.from(document.querySelectorAll('.izin-checkbox:checked')).map(cb => cb.value)));
        
        const isAllChecked = (allIds.length > 0 && checkedIds.length === allIds.length);
        const selectAllDesktop = document.getElementById('selectAll');
        const selectAllMobile = document.getElementById('selectAllMobile');
        if (selectAllDesktop) selectAllDesktop.checked = isAllChecked;
        if (selectAllMobile) selectAllMobile.checked = isAllChecked;
        
        updateFloatingBatchBar();
    }

    function uncheckAll() {
        const checkboxes = document.querySelectorAll('.izin-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = false;
        });
        const selectAllDesktop = document.getElementById('selectAll');
        const selectAllMobile = document.getElementById('selectAllMobile');
        if (selectAllDesktop) selectAllDesktop.checked = false;
        if (selectAllMobile) selectAllMobile.checked = false;
        updateFloatingBatchBar();
    }

    function updateFloatingBatchBar() {
        const checkedUnique = Array.from(new Set(Array.from(document.querySelectorAll('.izin-checkbox:checked')).map(cb => cb.value)));
        const count = checkedUnique.length;
        const bar = document.getElementById('floatingBatchBar');
        const badge = document.getElementById('selectedCountBadge');

        if (count > 0) {
            bar.classList.add('show');
            badge.innerText = count;
        } else {
            bar.classList.remove('show');
        }
    }

    function openBatchDeleteModal() {
        const checkedUnique = Array.from(new Set(Array.from(document.querySelectorAll('.izin-checkbox:checked')).map(cb => cb.value)));
        const count = checkedUnique.length;
        if (count === 0) {
            alert('Silakan pilih minimal 1 data izin yang ingin dihapus.');
            return;
        }
        document.getElementById('batchDeleteIds').value = checkedUnique.join(',');
        document.getElementById('batchModalCount').innerText = count;
        document.getElementById('batchDeleteModal').style.display = 'flex';
    }

    function closeBatchDeleteModal() {
        document.getElementById('batchDeleteModal').style.display = 'none';
    }

    function confirmSingleDelete(id) {
        document.getElementById('singleDeleteForm').action = "{{ url('/guru-permintaan-izin') }}/" + id;
        document.getElementById('singleDeleteModal').style.display = 'flex';
    }

    function closeSingleDeleteModal() {
        document.getElementById('singleDeleteModal').style.display = 'none';
    }

    function copyPiketLinkDirect(text) {
        let tempTextArea = document.createElement("textarea");
        tempTextArea.value = text;
        tempTextArea.style.position = "fixed";
        tempTextArea.style.left = "-9999px";
        tempTextArea.style.top = "-9999px";
        document.body.appendChild(tempTextArea);
        tempTextArea.focus();
        tempTextArea.select();
        tempTextArea.setSelectionRange(0, 99999);

        try {
            let successful = document.execCommand('copy');
            if (successful) {
                alert('Link Akses Masuk Halaman Guru Piket berhasil disalin ke clipboard!');
            } else {
                prompt('Salin link berikut secara manual:', text);
            }
        } catch (err) {
            prompt('Salin link berikut secara manual:', text);
        }

        document.body.removeChild(tempTextArea);
    }

    function openDetailModal(data) {
        document.getElementById('dt_nama_guru').innerText = data.nama_guru || '-';
        document.getElementById('dt_nip').innerText = 'NIP. ' + (data.nip || '-');
        document.getElementById('dt_tanggal_durasi').innerText = (data.tanggal || '-') + ' (' + (data.durasi || '1 Hari Full') + ')';
        document.getElementById('dt_alasan').innerText = '"' + (data.alasan || '-') + '"';
        document.getElementById('dt_materi').innerText = data.materi || '-';
        
        if (data.status_piket === 'pending') {
            document.getElementById('dt_status_piket').innerHTML = '<span style="color: #b45309; font-weight: 700;">Menunggu Diproses Guru Piket</span>';
        } else {
            document.getElementById('dt_status_piket').innerHTML = '<span style="color: #15803d; font-weight: 700;">Sudah Diisikan oleh ' + (data.nama_guru_piket || 'Guru Piket') + ' (NIP. ' + (data.nip_guru_piket || '-') + ')</span>';
        }

        document.getElementById('dt_status_waka').innerText = (data.status_waka || 'Pending') + (data.catatan_waka ? ' (Ket: ' + data.catatan_waka + ')' : '');
        document.getElementById('dt_status_waka_sdm').innerText = (data.status_waka_sdm || 'Pending');
        document.getElementById('dt_status_kepsek').innerText = (data.status_kepsek || 'Pending') + (data.catatan_kepsek ? ' (Ket: ' + data.catatan_kepsek + ')' : '');

        const ketKhususContainer = document.getElementById('dt_keterangan_khusus_container');
        if (data.kategori_izin === 'cuti' && data.keterangan_khusus) {
            document.getElementById('dt_keterangan_khusus').innerText = data.keterangan_khusus;
            ketKhususContainer.style.display = 'table-row';
        } else {
            ketKhususContainer.style.display = 'none';
        }

        const fotoContainer = document.getElementById('dt_foto_container');
        if (data.foto_url) {
            document.getElementById('dt_foto_img').src = data.foto_url;
            document.getElementById('dt_foto_link').href = data.foto_url;
            fotoContainer.style.display = 'block';
        } else {
            fotoContainer.style.display = 'none';
        }

        const fileContainer = document.getElementById('dt_file_container');
        if (data.file_tugas_url) {
            document.getElementById('dt_file_link').href = data.file_tugas_url;
            fileContainer.style.display = 'block';
        } else {
            fileContainer.style.display = 'none';
        }

        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    function openEditModal(data) {
        document.getElementById('editForm').action = "{{ url('/guru-permintaan-izin') }}/" + data.id_guru_izin;
        document.getElementById('edit_nama_guru').value = '[NIP. ' + (data.nip || '-') + '] ' + (data.nama_guru || 'Guru Mengajar');
        document.getElementById('edit_kategori_izin').value = data.kategori_izin || 'biasa';
        document.getElementById('edit_tanggal_mulai').value = data.tanggal_mulai;
        document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai || data.tanggal_mulai;
        document.getElementById('edit_alasan').value = data.alasan;
        document.getElementById('edit_keterangan_khusus').value = data.keterangan_khusus || '';
        document.getElementById('edit_materi_dititipkan').value = data.materi || '';

        // Handle foto preview
        const fotoPreviewContainer = document.getElementById('edit_foto_preview_container');
        if (data.foto_url) {
            document.getElementById('edit_foto_img').src = data.foto_url;
            document.getElementById('edit_foto_link').href = data.foto_url;
            fotoPreviewContainer.style.display = 'block';
        } else {
            fotoPreviewContainer.style.display = 'none';
        }

        // Handle file tugas preview
        const filePreviewContainer = document.getElementById('edit_file_preview_container');
        if (data.file_tugas_url) {
            document.getElementById('edit_file_link').href = data.file_tugas_url;
            filePreviewContainer.style.display = 'block';
        } else {
            filePreviewContainer.style.display = 'none';
        }

        checkEditDurationCategory();
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // ==========================================
    // CHATBOT WHATSAPP MODAL & AJAX FUNCTIONS
    // ==========================================
    window.jadwalPiketByDateMap = @json($jadwalPiketByDate ?? []);
    window.piketUsersList = @json($piketUsers ?? []);
    let currentChatbotData = null;

    /**
     * Update dropdown pilihan tujuan Guru Piket hanya menampilkan:
     * 1. Akun Guru Piket (resmi dari role piket)
     * 2. Guru yang sedang dijadwalkan menjadi guru piket pada tanggal/hari tersebut saja
     */
    function updateTargetPiketOptionsByDate(selectId, dateStr, allowAutoOption = true) {
        const selectEl = document.getElementById(selectId);
        if (!selectEl) return;

        const currentValue = selectEl.value;
        selectEl.innerHTML = '';

        // Opsi Default Otomatis
        if (allowAutoOption) {
            const autoOpt = document.createElement('option');
            autoOpt.value = '';
            autoOpt.textContent = '-- Otomatis (Guru Piket Hari Ini & Petugas Piket Sistem) --';
            selectEl.appendChild(autoOpt);
        }

        // 1. Akun Petugas Piket Resmi
        if (window.piketUsersList && window.piketUsersList.length > 0) {
            const grpPiket = document.createElement('optgroup');
            grpPiket.label = 'Akun Petugas Piket';
            window.piketUsersList.forEach(u => {
                if (u.no_hp) {
                    const opt = document.createElement('option');
                    opt.value = u.no_hp;
                    opt.dataset.name = u.name;
                    opt.textContent = `${u.name} (Akun Resmi Piket) - ${u.no_hp}`;
                    grpPiket.appendChild(opt);
                }
            });
            selectEl.appendChild(grpPiket);
        }

        // 2. Guru Piket Terjadwal pada Tanggal / Hari saat itu saja
        if (dateStr && window.jadwalPiketByDateMap && window.jadwalPiketByDateMap[dateStr]) {
            const scheduledList = window.jadwalPiketByDateMap[dateStr];
            if (scheduledList && scheduledList.length > 0) {
                const grpJadwal = document.createElement('optgroup');
                const hariTeks = scheduledList[0].hari ? ` (${scheduledList[0].hari})` : '';

                const parts = dateStr.split('-');
                const tglFmt = (parts.length === 3) ? `${parts[2]}/${parts[1]}/${parts[0]}` : dateStr;

                grpJadwal.label = `Guru Piket Terjadwal${hariTeks} - ${tglFmt}`;

                scheduledList.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.phone;
                    opt.dataset.name = s.name;
                    opt.textContent = `${s.name} (Piket) - ${s.phone}`;
                    grpJadwal.appendChild(opt);
                });
                selectEl.appendChild(grpJadwal);
            }
        }

        if (currentValue) {
            selectEl.value = currentValue;
        }
    }

    function openChatbotModal(data) {
        currentChatbotData = data;
        document.getElementById('cb_modal_guru_nama').textContent = data.nama_guru + ' (NIP. ' + (data.nip || '-') + ')';
        document.getElementById('cb_modal_kategori_badge').textContent = data.kategori || 'Izin Biasa';
        document.getElementById('cb_modal_tanggal').textContent = data.tanggal;
        document.getElementById('cb_modal_alasan').textContent = data.alasan;

        const linkEl = document.getElementById('cb_modal_link');
        linkEl.href = data.piket_url;
        linkEl.textContent = data.piket_url;

        // Reset target select & custom input
        document.getElementById('cb_modal_target_select').value = '';
        document.getElementById('cb_modal_custom_phone').value = '';

        // Update pilihan nomor Guru Piket di modal hanya untuk tanggal pengajuan izin
        updateTargetPiketOptionsByDate('cb_modal_target_select', data.tanggal_mulai, true);

        if (data.target_phone) {
            const sel = document.getElementById('cb_modal_target_select');
            let found = false;
            for (let i = 0; i < sel.options.length; i++) {
                if (sel.options[i].value === data.target_phone) {
                    sel.selectedIndex = i;
                    found = true;
                    break;
                }
            }
            if (!found) {
                document.getElementById('cb_modal_custom_phone').value = data.target_phone;
            }
        }

        // Reset alert
        const alertBox = document.getElementById('cb_status_alert');
        alertBox.style.display = 'none';
        alertBox.textContent = '';

        // Update preview text & manual link
        updateChatbotPreviewMessage();

        document.getElementById('chatbotWaModal').style.display = 'flex';
    }

    function closeChatbotWaModal(event) {
        if (event.target === document.getElementById('chatbotWaModal')) {
            closeChatbotWaModalDirect();
        }
    }

    function closeChatbotWaModalDirect() {
        document.getElementById('chatbotWaModal').style.display = 'none';
    }

    function onChatbotTargetSelectChange(selectEl) {
        if (selectEl.value) {
            document.getElementById('cb_modal_custom_phone').value = selectEl.value;
        }
        updateChatbotPreviewMessage();
    }

    function updateChatbotPreviewMessage() {
        if (!currentChatbotData) return;

        const customPhone = document.getElementById('cb_modal_custom_phone').value.trim();
        const selectedPhone = document.getElementById('cb_modal_target_select').value;
        const targetPhone = customPhone || selectedPhone || '';

        // Target sapaan nama jika dipilih dari select
        const sel = document.getElementById('cb_modal_target_select');
        let namaPiket = 'Petugas Guru Piket';
        if (sel.selectedIndex > 0) {
            const opt = sel.options[sel.selectedIndex];
            if (opt && opt.dataset.name) {
                namaPiket = opt.dataset.name;
            }
        }

        const msg = "*[EDU JOURNAL - PEMBERITAHUAN PERMINTAAN IZIN GURU]*\n\n"
            + `Yth. Bapak/Ibu *${namaPiket}* (Guru Piket),\n\n`
            + "Pemberitahuan bahwa terdapat permohonan izin tidak hadir mengajar baru yang diajukan oleh Guru Mengajar / Wali Kelas dan memerlukan verifikasi serta pengisian data oleh Guru Piket ke sistem.\n\n"
            + "Berikut adalah detail permohonan izin:\n"
            + `• Nama Pengaju : *${currentChatbotData.nama_guru}*\n`
            + `• NIP          : ${currentChatbotData.nip || '-'}\n`
            + `• Kategori     : ${currentChatbotData.kategori}\n`
            + `• Rentang Waktu: ${currentChatbotData.tanggal}\n`
            + `• Alasan       : ${currentChatbotData.alasan}\n`
            + `• Titipan Tugas: ${currentChatbotData.materi || '-'}\n\n`
            + "Mohon Bapak/Ibu Guru Piket dapat mengecek, memvalidasi, dan mengisikan data izin tersebut ke sistem Web EDU JOURNAL melalui tautan berikut:\n\n"
            + `${currentChatbotData.piket_url}\n\n`
            + "Terima kasih.\n"
            + "-- ChatBot WhatsApp EDU Journal --";

        document.getElementById('cb_modal_text').value = msg;

        // Manual WA link
        let cleanPhone = targetPhone.replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }
        const manualLink = document.getElementById('cb_modal_manual_link');
        if (cleanPhone) {
            manualLink.href = `https://api.whatsapp.com/send?phone=${cleanPhone}&text=` + encodeURIComponent(msg);
        } else {
            manualLink.href = `https://api.whatsapp.com/send?text=` + encodeURIComponent(msg);
        }
    }

    function copyChatbotWaText() {
        const textVal = document.getElementById('cb_modal_text').value;
        if (!textVal) return;
        navigator.clipboard.writeText(textVal).then(() => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Teks Berhasil Disalin',
                    text: 'Teks pesan ChatBot WhatsApp telah disalin ke clipboard.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                alert('Teks pesan WhatsApp berhasil disalin!');
            }
        });
    }

    function submitSendChatbotWa() {
        if (!currentChatbotData || !currentChatbotData.id_guru_izin) return;

        const customPhone = document.getElementById('cb_modal_custom_phone').value.trim();
        const selectedPhone = document.getElementById('cb_modal_target_select').value;
        const targetPhone = customPhone || selectedPhone || '';

        const btn = document.getElementById('btn_submit_chatbot');
        const alertBox = document.getElementById('cb_status_alert');

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Mengirim via ChatBot...</span>';
        alertBox.style.display = 'none';

        fetch("{{ url('/guru-permintaan-izin') }}/" + currentChatbotData.id_guru_izin + "/send-chatbot", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                target_phone: targetPhone
            })
        })
        .then(res => res.json())
        .then(response => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-robot"></i> <span>Kirim via ChatBot WA</span>';

            alertBox.style.display = 'block';
            if (response.success) {
                alertBox.style.background = '#dcfce7';
                alertBox.style.color = '#14532d';
                alertBox.style.border = '1px solid #86efac';
                alertBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + (response.message || 'Pemberitahuan berhasil dikirimkan via ChatBot WhatsApp ke Guru Piket!');
            } else {
                alertBox.style.background = '#fee2e2';
                alertBox.style.color = '#991b1b';
                alertBox.style.border = '1px solid #fca5a5';
                alertBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + (response.message || 'Gagal mengirim pesan via ChatBot WhatsApp.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-robot"></i> <span>Kirim via ChatBot WA</span>';

            alertBox.style.display = 'block';
            alertBox.style.background = '#fee2e2';
            alertBox.style.color = '#991b1b';
            alertBox.style.border = '1px solid #fca5a5';
            alertBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Terjadi kesalahan jaringan saat memproses ChatBot WhatsApp.';
        });
    }

    function resendChatbotFromAlert(id, phone) {
        if (!id) return;
        const btn = (typeof event !== 'undefined' && event) ? event.currentTarget : null;
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
        }

        fetch("{{ url('/guru-permintaan-izin') }}/" + id + "/send-chatbot", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                target_phone: phone || ''
            })
        })
        .then(res => res.json())
        .then(response => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-rotate-right"></i> Kirim Ulang via ChatBot WA';
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: response.success ? 'success' : 'warning',
                    title: response.success ? 'ChatBot Berhasil Terkirim' : 'Info Pengiriman',
                    text: response.message,
                    confirmButtonColor: '#10b981'
                });
            } else {
                alert(response.message);
            }
        })
        .catch(err => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-rotate-right"></i> Kirim Ulang via ChatBot WA';
            }
            alert('Gagal menghubungi server untuk pengiriman ChatBot.');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        checkDurationCategory();

        const inputTglMulai = document.getElementById('inputTglMulai');
        if (inputTglMulai) {
            inputTglMulai.addEventListener('change', function() {
                updateTargetPiketOptionsByDate('wa_target_phone', this.value, true);
            });
            if (inputTglMulai.value) {
                updateTargetPiketOptionsByDate('wa_target_phone', inputTglMulai.value, true);
            }
        }

        const mainForm = document.getElementById('formIzinGuru');
        if (mainForm) {
            mainForm.addEventListener('submit', function(e) {
                const tMulai = document.getElementById('inputTglMulai').value;
                const tSelesai = document.getElementById('inputTglSelesai').value;
                if (tMulai && tSelesai && tSelesai < tMulai) {
                    e.preventDefault();
                    alert('Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin.');
                    return false;
                }
            });
        }

        const editForm = document.getElementById('editForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                const tMulai = document.getElementById('edit_tanggal_mulai').value;
                const tSelesai = document.getElementById('edit_tanggal_selesai').value;
                if (tMulai && tSelesai && tSelesai < tMulai) {
                    e.preventDefault();
                    alert('Tanggal Selesai Izin tidak boleh lebih awal dari Tanggal Mulai Izin.');
                    return false;
                }
            });
        }
    });
</script>
@endsection