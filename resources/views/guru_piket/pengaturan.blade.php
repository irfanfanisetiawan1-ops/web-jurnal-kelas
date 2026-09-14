<style>
    /* ─── Global Styles Pengaturan Guru Piket ─── */
    .piket-settings-wrap {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
    }

    /* ─── 1. Header Banner Bersama (Gradient + Ilustrasi) ─── */
    .piket-settings-header {
        background: linear-gradient(135deg, #f0f7ff 0%, #e0f2fe 50%, #eff6ff 100%);
        border: 1px solid #bfdbfe;
        border-radius: 20px;
        padding: 24px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.04);
    }

    .piket-header-left {
        display: flex;
        align-items: center;
        gap: 18px;
        z-index: 2;
    }

    .piket-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #2563eb;
        color: #ffffff;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        flex-shrink: 0;
    }

    .piket-header-text-group {
        display: flex;
        flex-direction: column;
    }

    .piket-header-badge {
        font-size: 11.5px;
        font-weight: 750;
        color: #1e40af;
        background: #dbeafe;
        padding: 3px 10px;
        border-radius: 6px;
        display: inline-block;
        width: fit-content;
        margin-bottom: 5px;
        letter-spacing: -0.01em;
    }

    .piket-header-title {
        font-size: 22px;
        font-weight: 850;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .piket-header-subtitle {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin-top: 4px;
    }

    .piket-header-illustration {
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 1;
        opacity: 0.95;
    }

    /* ─── 2. Tab Navigation Bar (Subnav) ─── */
    .piket-subnav-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        overflow-x: auto;
    }

    .piket-tab-btn {
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        background: transparent;
        border: 1px solid transparent;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .piket-tab-btn:hover {
        background: #f8fafc;
        color: #1e293b;
    }

    .piket-tab-btn.active {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
        font-weight: 800;
        border-bottom: 3px solid #2563eb;
    }

    .piket-tab-btn i {
        font-size: 14px;
    }

    /* ─── 3. Card Container Universal ─── */
    .piket-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        margin-bottom: 20px;
    }

    .piket-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .piket-card-title-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .piket-card-title-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .piket-card-title {
        font-size: 16px;
        font-weight: 850;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.01em;
    }

    .piket-card-subtitle {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 2px;
    }

    /* ─── Form Inputs & Grid ─── */
    .piket-form-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 16px;
    }

    @media (max-width: 768px) {
        .piket-form-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .piket-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }

    .piket-form-group.full-width {
        grid-column: 1 / -1;
    }

    .piket-form-label {
        font-size: 13px;
        font-weight: 750;
        color: #334155;
        letter-spacing: -0.01em;
    }

    .piket-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .piket-input-icon {
        position: absolute;
        left: 14px;
        color: #64748b;
        font-size: 14px;
        pointer-events: none;
    }

    .piket-form-input {
        width: 100%;
        height: 44px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 14px 10px 40px;
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .piket-form-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Read-Only Fields (bg-slate-50, cursor: not-allowed) */
    .piket-form-input.readonly-field {
        background: #f8fafc !important;
        border-color: #e2e8f0 !important;
        color: #475569 !important;
        cursor: not-allowed !important;
        font-weight: 650 !important;
    }

    .piket-form-select {
        width: 100%;
        height: 44px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 14px 10px 40px;
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }

    .piket-form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .piket-form-select.readonly-field {
        background: #f8fafc !important;
        border-color: #e2e8f0 !important;
        color: #475569 !important;
        cursor: not-allowed !important;
        pointer-events: none;
    }

    /* Toggle Show/Hide Password Eye Button */
    .piket-password-toggle {
        position: absolute;
        right: 14px;
        background: transparent;
        border: none;
        color: #64748b;
        font-size: 14px;
        cursor: pointer;
        padding: 4px;
        transition: color 0.2s ease;
    }

    .piket-password-toggle:hover {
        color: #1e293b;
    }

    /* Action Buttons */
    .btn-piket-submit {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 11px 24px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s ease, transform 0.1s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .btn-piket-submit:hover {
        background: #1d4ed8;
    }

    .btn-piket-submit.gradient-purple {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.25);
    }

    .btn-piket-submit.gradient-purple:hover {
        background: linear-gradient(135deg, #4338ca 0%, #2563eb 100%);
    }

    /* Bottom Info Banner */
    .piket-bottom-info-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 13px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        font-size: 12.5px;
        color: #475569;
        font-weight: 600;
        margin-top: 14px;
    }

    .piket-bottom-info-box i.info-icon {
        color: #2563eb;
        font-size: 15px;
    }

    .profil-top-card {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 22px;
    }

    .profil-avatar-section {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .profil-avatar-wrap {
        position: relative;
        width: 82px;
        height: 82px;
        border-radius: 50%;
        border: 3px solid #3b82f6;
        box-shadow: 0 4px 14px rgba(59, 130, 246, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        background: #dbeafe;
        color: #1e40af;
        font-size: 32px;
        font-weight: 850;
        flex-shrink: 0;
        overflow: hidden;
    }

    .profil-avatar-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 26px;
        height: 26px;
        background: #2563eb;
        color: #ffffff;
        border-radius: 50%;
        border: 2px solid #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
    }

    .btn-choose-photo {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 750;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
    }

    .btn-choose-photo:hover {
        background: #1d4ed8;
    }


    /* ─── Styles Tab 3 (Preferensi & Tugas Piket) ─── */
    .piket-status-row {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 11px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        gap: 16px;
    }

    .piket-status-label {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        width: 200px;
        flex-shrink: 0;
    }

    .piket-status-val {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .badge-status-pill-green {
        background: #dcfce7;
        color: #15803d;
        font-size: 11.5px;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* 3 Stat Cards Piket */
    .piket-stat-3-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-top: 14px;
    }

    @media (max-width: 768px) {
        .piket-stat-3-grid {
            grid-template-columns: 1fr;
        }
    }

    .piket-stat-box {
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .piket-stat-box.blue {
        background: linear-gradient(180deg, #ffffff 0%, #eff6ff 100%);
        border: 1px solid #bfdbfe;
    }

    .piket-stat-box.green {
        background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
        border: 1px solid #bbf7d0;
    }

    .piket-stat-box.red {
        background: linear-gradient(180deg, #ffffff 0%, #fef2f2 100%);
        border: 1px solid #fecaca;
    }

    .piket-stat-box-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .piket-stat-box.blue .piket-stat-box-icon { background: #dbeafe; color: #2563eb; }
    .piket-stat-box.green .piket-stat-box-icon { background: #dcfce7; color: #16a34a; }
    .piket-stat-box.red .piket-stat-box-icon { background: #fee2e2; color: #dc2626; }

    .piket-stat-box-number {
        font-size: 24px;
        font-weight: 850;
        line-height: 1.1;
    }

    .piket-stat-box.blue .piket-stat-box-number { color: #1e40af; }
    .piket-stat-box.green .piket-stat-box-number { color: #166534; }
    .piket-stat-box.red .piket-stat-box-number { color: #991b1b; }

    .piket-stat-box-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-top: 2px;
    }

    /* Toggle Switch Items */
    .piket-toggle-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: 10px;
        gap: 16px;
    }

    .piket-toggle-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .piket-toggle-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .piket-toggle-title {
        font-size: 13.5px;
        font-weight: 750;
        color: #1e293b;
    }

    .piket-toggle-sub {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        margin-top: 2px;
    }

    /* iOS/Tailwind Toggle Switch */
    .switch-wrap {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 26px;
        flex-shrink: 0;
    }

    .switch-wrap input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 34px;
    }

    .switch-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }

    input:checked + .switch-slider {
        background-color: #10b981;
    }

    input:checked + .switch-slider:before {
        transform: translateX(20px);
    }

    /* Dropdown Preference Items (Card 3) */
    .piket-pref-dropdown-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: 12px;
        gap: 16px;
    }

    @media (max-width: 768px) {
        .piket-pref-dropdown-row {
            flex-direction: column;
            align-items: stretch;
        }
    }

    .piket-pref-dropdown-select {
        height: 40px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        padding: 8px 14px;
        min-width: 220px;
        outline: none;
        cursor: pointer;
    }

    .piket-pref-dropdown-select:focus {
        border-color: #2563eb;
    }

    /* Hidden tabs */
    .piket-tab-content {
        display: none;
    }

    .piket-tab-content.active {
        display: block;
    }

    /* ─── Mobile Responsive Additions (Strictly Hidden on Desktop) ─── */
    .piket-mobile-wrap {
        display: none !important;
    }

    @media (max-width: 768px) {
        .piket-desktop-wrap {
            display: none !important;
        }

        .piket-mobile-wrap {
            display: flex !important;
            flex-direction: column;
            gap: 16px;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
            padding-bottom: 28px;
        }

        /* Mobile Topbar */
        .mobile-page-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 12px 16px;
            margin-bottom: 2px;
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .mobile-back-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #1e3a8a;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        .mobile-back-btn:active {
            background: #eff6ff;
            color: #2563eb;
            transform: scale(0.95);
        }

        .mobile-topbar-title-wrap {
            flex: 1;
            min-width: 0;
        }

        .mobile-topbar-title {
            font-size: 15.5px;
            font-weight: 800;
            color: #1e3a8a;
            margin: 0;
            line-height: 1.25;
            letter-spacing: -0.01em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mobile-topbar-sub {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Profile Summary Card */
        .m-profile-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .m-profile-avatar {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 2px solid #bfdbfe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            flex-shrink: 0;
            overflow: hidden;
        }

        .m-profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .m-profile-info {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .m-profile-name {
            font-size: 14.5px;
            font-weight: 800;
            color: #1e3a8a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-profile-role-row {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .m-profile-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10.5px;
            font-weight: 750;
            padding: 2px 8px;
            border-radius: 6px;
            background: #dbeafe;
            color: #1e40af;
        }

        .m-profile-nip {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
        }

        /* ─── 5-Item Navigation Menu List (User's Exact Design System) ─── */
        .m-section-heading {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.04em;
            margin: 4px 0 -4px 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .m-menu-cards-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .m-menu-card-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
            position: relative;
        }

        .m-menu-card-item:active {
            transform: scale(0.985);
            background: #f8fafc;
        }

        /* Active Menu Item State (User's Exact Design System Spec) */
        .m-menu-card-item.active {
            background: #eff6ff;
            border-color: #bfdbfe;
            border-left: 4px solid #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        }

        .m-menu-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            min-width: 0;
        }

        .m-menu-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
            transition: all 0.15s ease;
        }

        .m-menu-card-item.active .m-menu-icon {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
        }

        .m-menu-text-wrap {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .m-menu-title {
            font-size: 14px;
            font-weight: 800;
            color: #1e3a8a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            letter-spacing: -0.01em;
        }

        .m-menu-sub {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-menu-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .m-menu-active-badge {
            font-size: 11px;
            font-weight: 800;
            color: #15803d;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            padding: 3px 9px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .m-menu-chevron {
            color: #94a3b8;
            font-size: 13px;
            transition: transform 0.15s ease;
        }

        .m-menu-card-item:hover .m-menu-chevron {
            transform: translateX(2px);
            color: #2563eb;
        }

        /* Settings Action Accordions/Cards */
        .m-settings-accordion-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }

        .m-settings-accordion-header {
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            cursor: pointer;
            user-select: none;
            background: #ffffff;
            transition: background 0.15s ease;
        }

        .m-settings-accordion-header:active {
            background: #f8fafc;
        }

        .m-settings-accordion-body {
            padding: 0 16px 16px 16px;
            display: none;
            border-top: 1px solid #f1f5f9;
            padding-top: 14px;
        }

        .m-settings-accordion-body.open {
            display: block;
        }

        .m-settings-chevron {
            font-size: 12px;
            color: #94a3b8;
            transition: transform 0.2s ease;
        }

        .m-settings-chevron.rotated {
            transform: rotate(180deg);
        }

        .m-btn-save-mobile {
            width: 100%;
            height: 42px;
            border-radius: 12px;
            background: #2563eb;
            color: #ffffff;
            font-size: 13px;
            font-weight: 800;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
            margin-top: 10px;
        }

        .m-btn-save-mobile:active {
            transform: scale(0.98);
        }

        .m-btn-logout-mobile {
            width: 100%;
            height: 42px;
            border-radius: 12px;
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
            font-size: 13px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 4px;
            transition: all 0.15s ease;
        }

        .m-btn-logout-mobile:active {
            background: #fecaca;
            transform: scale(0.98);
        }
    }
</style>

@php
    $activeTabReq = request('tab', session('active_tab', 'profile'));
    $isSecurityActive = $activeTabReq === 'security' || (isset($errors) && ($errors->has('current_password') || $errors->has('password')));
    $isPrefActive = $activeTabReq === 'preferences';
    $isProfileActive = !$isSecurityActive && !$isPrefActive;
@endphp

<div class="piket-settings-wrap">

    <!-- ═══════════════════════════════════════════════════════════════ -->
    <!-- MOBILE VIEW (<= 768px): SESUAI DESIGN SYSTEM ACUAN USER       -->
    <!-- ═══════════════════════════════════════════════════════════════ -->
    <div class="piket-mobile-wrap">
        <!-- 1. Mobile Top Bar -->
        <div class="mobile-page-topbar">
            <div class="mobile-topbar-text-group">
                <h1 class="mobile-topbar-title">Pengaturan Piket</h1>
                <p class="mobile-topbar-subtitle">Profil, Keamanan &amp; Preferensi Petugas</p>
            </div>
        </div>

        <!-- 2. Profile Summary Card -->
        <div class="m-profile-card">
            <div class="m-profile-avatar">
                @if($user->foto_url)
                    <img src="{{ $user->foto_url }}" alt="{{ $user->name }}">
                @else
                    <span>{{ strtoupper(substr($user->name ?? 'P', 0, 1)) }}</span>
                @endif
            </div>
            <div class="m-profile-info">
                <div class="m-profile-name">{{ $user->name }}</div>
                <div class="m-profile-nip">NIP: {{ $user->nip ?? ($guru->nip ?? ($user->username ?? '-')) }}</div>
                <div>
                    <span class="m-profile-badge">
                        <i class="fa-solid fa-shield-halved"></i> Petugas Piket
                    </span>
                </div>
            </div>
        </div>

        <!-- 3. Menu Guru Piket (5 Card Sesuai Design System Acuan) -->
        <div class="m-section-heading">
            <i class="fa-solid fa-bars-staggered"></i>
            <span>Menu Guru Piket</span>
        </div>
        <div class="m-menu-cards-list">
            <!-- 1. Dispensasi Siswa -->
            <a href="{{ route('piket.dispensasi-siswa') }}" class="m-menu-card-item">
                <div class="m-menu-icon-box">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div class="m-menu-content">
                    <div class="m-menu-title">Dispensasi Siswa</div>
                    <div class="m-menu-sub">Kelola izin keluar &amp; surat tugas siswa</div>
                </div>
                <i class="fa-solid fa-chevron-right m-menu-chevron"></i>
            </a>

            <!-- 2. Siswa Telat -->
            <a href="{{ route('piket.siswa-telat') }}" class="m-menu-card-item">
                <div class="m-menu-icon-box">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div class="m-menu-content">
                    <div class="m-menu-title">Siswa Telat</div>
                    <div class="m-menu-sub">Pencatatan &amp; verifikasi siswa terlambat</div>
                </div>
                <i class="fa-solid fa-chevron-right m-menu-chevron"></i>
            </a>

            <!-- 3. Jadwal Hari Ini -->
            <a href="{{ route('piket.jadwal') }}" class="m-menu-card-item">
                <div class="m-menu-icon-box">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <div class="m-menu-content">
                    <div class="m-menu-title">Jadwal Hari Ini</div>
                    <div class="m-menu-sub">Monitoring jadwal KBM &amp; guru mengajar</div>
                </div>
                <i class="fa-solid fa-chevron-right m-menu-chevron"></i>
            </a>

            <!-- 4. Rekap Kehadiran -->
            <a href="{{ route('piket.rekap-kehadiran') }}" class="m-menu-card-item">
                <div class="m-menu-icon-box">
                    <i class="fa-solid fa-clipboard-user"></i>
                </div>
                <div class="m-menu-content">
                    <div class="m-menu-title">Rekap Kehadiran</div>
                    <div class="m-menu-sub">Ringkasan presensi harian &amp; guru pengganti</div>
                </div>
                <i class="fa-solid fa-chevron-right m-menu-chevron"></i>
            </a>

            <!-- 5. Pengaturan (AKTIF - BORDER BIRU TEBAL KIRI & BADGE AKTIF) -->
            <div class="m-menu-card-item active">
                <div class="m-menu-icon-box">
                    <i class="fa-solid fa-gear"></i>
                </div>
                <div class="m-menu-content">
                    <div class="m-menu-title">Pengaturan</div>
                    <div class="m-menu-sub">Akun, keamanan &amp; preferensi piket</div>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="m-menu-active-pill">Aktif</span>
                    <i class="fa-solid fa-chevron-right m-menu-chevron"></i>
                </div>
            </div>
        </div>

        <!-- 4. Form Pengaturan Mobile Accordions -->
        <div class="m-section-heading">
            <i class="fa-solid fa-sliders"></i>
            <span>Pengaturan Akun &amp; Preferensi</span>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px;">
            <!-- ACCORDION 1: PROFIL PENGGUNA -->
            <div class="m-settings-accordion-card">
                <div class="m-settings-accordion-header" onclick="toggleMobileSettingsAccordion('m-sec-profil')">
                    <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                        <div class="m-menu-icon-box" style="width: 36px; height: 36px; font-size: 14px;">
                            <i class="fa-solid fa-user-pen"></i>
                        </div>
                        <div>
                            <div style="font-size: 13.5px; font-weight: 800; color: #1e3a8a;">Ubah Data Profil</div>
                            <div style="font-size: 11px; color: #64748b; font-weight: 500;">Nama, email, no. WhatsApp &amp; foto</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down m-settings-chevron" id="m-chevron-m-sec-profil"></i>
                </div>
                <div class="m-settings-accordion-body" id="m-sec-profil">
                    <form action="{{ route('pengaturan.update-profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Foto preview & upload -->
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
                            <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; background: #e0e7ff; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #2563eb; flex-shrink: 0; border: 2px solid #ffffff; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
                                @if($user->foto_url)
                                    <img id="piketAvatarMobileImg" src="{{ $user->foto_url }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span id="piketAvatarMobileLetter">{{ strtoupper(substr($user->name ?? 'P', 0, 1)) }}</span>
                                    <img id="piketAvatarMobileImg" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                @endif
                            </div>
                            <div>
                                <label for="piketMobileFotoInput" class="btn-choose-photo" style="font-size: 11.5px; padding: 7px 12px; cursor: pointer;">
                                    <i class="fa-solid fa-camera"></i>
                                    <span>Ganti Foto</span>
                                </label>
                                <input type="file" id="piketMobileFotoInput" name="foto" accept="image/*" style="display: none;" onchange="previewPiketMobilePhoto(this)">
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                                <div class="piket-input-wrap">
                                    <i class="fa-regular fa-user piket-input-icon"></i>
                                    <input type="text" name="name" class="piket-form-input" value="{{ old('name', $user->name) }}" required placeholder="Nama lengkap">
                                </div>
                            </div>

                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">Alamat Email</label>
                                <div class="piket-input-wrap">
                                    <i class="fa-regular fa-envelope piket-input-icon"></i>
                                    <input type="email" name="email" class="piket-form-input" value="{{ old('email', $user->email) }}" placeholder="Email akun">
                                </div>
                            </div>

                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">Nomor HP / WhatsApp</label>
                                <div class="piket-input-wrap">
                                    <i class="fa-solid fa-phone piket-input-icon"></i>
                                    <input type="text" name="no_hp" class="piket-form-input" value="{{ old('no_hp', $user->no_hp ?? ($guru->no_hp ?? '')) }}" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>

                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">Jenis Kelamin</label>
                                <div class="piket-input-wrap">
                                    <i class="fa-solid fa-venus-mars piket-input-icon"></i>
                                    <select name="jenis_kelamin" class="piket-form-select">
                                        <option value="L" {{ (old('jenis_kelamin', $user->jenis_kelamin ?? ($guru->jenis_kelamin ?? 'L')) == 'L') ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ (old('jenis_kelamin', $user->jenis_kelamin ?? ($guru->jenis_kelamin ?? '')) == 'P') ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">NIP / Username (Resmi)</label>
                                <div class="piket-input-wrap">
                                    <i class="fa-solid fa-id-badge piket-input-icon"></i>
                                    <input type="text" class="piket-form-input readonly-field" value="{{ $user->nip ?? ($guru->nip ?? ($user->username ?? '-')) }}" readonly>
                                </div>
                            </div>

                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">Mata Pelajaran Diampu</label>
                                <div class="piket-input-wrap">
                                    <i class="fa-solid fa-book-bookmark piket-input-icon"></i>
                                    <input type="text" class="piket-form-input readonly-field" value="{{ $guru && $guru->mapel ? $guru->mapel->nama_mapel : 'Bahasa Inggris' }}" readonly>
                                </div>
                            </div>

                            <button type="submit" class="m-btn-save-mobile">
                                <i class="fa-regular fa-floppy-disk"></i>
                                <span>Simpan Perubahan Profil</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ACCORDION 2: KEAMANAN PASSWORD -->
            <div class="m-settings-accordion-card">
                <div class="m-settings-accordion-header" onclick="toggleMobileSettingsAccordion('m-sec-security')">
                    <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                        <div class="m-menu-icon-box" style="width: 36px; height: 36px; font-size: 14px;">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <div style="font-size: 13.5px; font-weight: 800; color: #1e3a8a;">Keamanan &amp; Kata Sandi</div>
                            <div style="font-size: 11px; color: #64748b; font-weight: 500;">Ganti password akun login Anda</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down m-settings-chevron" id="m-chevron-m-sec-security"></i>
                </div>
                <div class="m-settings-accordion-body" id="m-sec-security">
                    <form action="{{ route('pengaturan.update-password') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">Password Saat Ini <span style="color: #ef4444;">*</span></label>
                                <div class="piket-input-wrap">
                                    <i class="fa-solid fa-lock piket-input-icon"></i>
                                    <input type="password" id="mCurrentPass" name="current_password" class="piket-form-input" required placeholder="Password saat ini">
                                    <button type="button" class="piket-password-toggle" onclick="togglePassVisibility('mCurrentPass', this)">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">Password Baru <span style="color: #ef4444;">*</span></label>
                                <div class="piket-input-wrap">
                                    <i class="fa-solid fa-lock piket-input-icon"></i>
                                    <input type="password" id="mNewPass" name="password" class="piket-form-input" required placeholder="Minimal 8 karakter">
                                    <button type="button" class="piket-password-toggle" onclick="togglePassVisibility('mNewPass', this)">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">Ulangi Password Baru <span style="color: #ef4444;">*</span></label>
                                <div class="piket-input-wrap">
                                    <i class="fa-solid fa-lock piket-input-icon"></i>
                                    <input type="password" id="mConfirmPass" name="password_confirmation" class="piket-form-input" required placeholder="Konfirmasi password">
                                    <button type="button" class="piket-password-toggle" onclick="togglePassVisibility('mConfirmPass', this)">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="m-btn-save-mobile" style="background: #4f46e5;">
                                <i class="fa-solid fa-key"></i>
                                <span>Perbarui Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ACCORDION 3: PREFERENSI TUGAS PIKET -->
            <div class="m-settings-accordion-card">
                <div class="m-settings-accordion-header" onclick="toggleMobileSettingsAccordion('m-sec-pref')">
                    <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                        <div class="m-menu-icon-box" style="width: 36px; height: 36px; font-size: 14px;">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        <div>
                            <div style="font-size: 13.5px; font-weight: 800; color: #1e3a8a;">Preferensi &amp; Tugas Piket</div>
                            <div style="font-size: 11px; color: #64748b; font-weight: 500;">Notifikasi instan &amp; alur operasional</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down m-settings-chevron" id="m-chevron-m-sec-pref"></i>
                </div>
                <div class="m-settings-accordion-body" id="m-sec-pref">
                    <form action="{{ route('pengaturan.update-preferences') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <!-- Toggles -->
                            <div class="piket-toggle-item" style="padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                                <div class="piket-toggle-info">
                                    <div>
                                        <div class="piket-toggle-title" style="font-size: 12.5px;">Notifikasi Guru Tidak Hadir</div>
                                        <div class="piket-toggle-sub" style="font-size: 11px;">Peringatan real-time pengajuan izin guru</div>
                                    </div>
                                </div>
                                <label class="switch-wrap">
                                    <input type="checkbox" name="piket_notif_guru_izin" value="1" {{ ($systemSettings['piket_notif_guru_izin'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="switch-slider"></span>
                                </label>
                            </div>

                            <div class="piket-toggle-item" style="padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                                <div class="piket-toggle-info">
                                    <div>
                                        <div class="piket-toggle-title" style="font-size: 12.5px;">Alert Jurnal Kosong</div>
                                        <div class="piket-toggle-sub" style="font-size: 11px;">Ingatkan kelas yang belum diisi jurnal</div>
                                    </div>
                                </div>
                                <label class="switch-wrap">
                                    <input type="checkbox" name="piket_notif_jurnal_kosong" value="1" {{ ($systemSettings['piket_notif_jurnal_kosong'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="switch-slider"></span>
                                </label>
                            </div>

                            <div class="piket-toggle-item" style="padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                                <div class="piket-toggle-info">
                                    <div>
                                        <div class="piket-toggle-title" style="font-size: 12.5px;">Dispensasi Siswa</div>
                                        <div class="piket-toggle-sub" style="font-size: 11px;">Notif saat ada pengajuan izin keluar</div>
                                    </div>
                                </div>
                                <label class="switch-wrap">
                                    <input type="checkbox" name="piket_notif_dispensasi" value="1" {{ ($systemSettings['piket_notif_dispensasi'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="switch-slider"></span>
                                </label>
                            </div>

                            <div class="piket-toggle-item" style="padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                                <div class="piket-toggle-info">
                                    <div>
                                        <div class="piket-toggle-title" style="font-size: 12.5px;">Ringkasan Sore</div>
                                        <div class="piket-toggle-sub" style="font-size: 11px;">Kirimkan rekap harian piket sore</div>
                                    </div>
                                </div>
                                <label class="switch-wrap">
                                    <input type="checkbox" name="piket_notif_ringkasan" value="1" {{ ($systemSettings['piket_notif_ringkasan'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="switch-slider"></span>
                                </label>
                            </div>

                            <!-- Dropdowns -->
                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">Mode Penugasan Guru Pengganti</label>
                                <div class="piket-input-wrap">
                                    <i class="fa-solid fa-user-gear piket-input-icon"></i>
                                    <select name="piket_mode_guru_pengganti" class="piket-form-select">
                                        <option value="manual" {{ ($systemSettings['piket_mode_guru_pengganti'] ?? 'manual') == 'manual' ? 'selected' : '' }}>Manual oleh Petugas Piket</option>
                                        <option value="auto" {{ ($systemSettings['piket_mode_guru_pengganti'] ?? '') == 'auto' ? 'selected' : '' }}>Otomatis Jadwal Kosong</option>
                                    </select>
                                </div>
                            </div>

                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">Format Default Cetak Dokumen</label>
                                <div class="piket-input-wrap">
                                    <i class="fa-solid fa-file-pdf piket-input-icon"></i>
                                    <select name="piket_export_format" class="piket-form-select">
                                        <option value="pdf" {{ ($systemSettings['piket_export_format'] ?? 'pdf') == 'pdf' ? 'selected' : '' }}>Dokumen PDF (.pdf)</option>
                                        <option value="excel" {{ ($systemSettings['piket_export_format'] ?? '') == 'excel' ? 'selected' : '' }}>Spreadsheet Excel (.xlsx)</option>
                                        <option value="csv" {{ ($systemSettings['piket_export_format'] ?? '') == 'csv' ? 'selected' : '' }}>File CSV (.csv)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="piket-form-group">
                                <label class="piket-form-label" style="font-size: 11.5px;">Baris Data Per Halaman</label>
                                <div class="piket-input-wrap">
                                    <i class="fa-regular fa-calendar-days piket-input-icon"></i>
                                    <select name="piket_data_per_page" class="piket-form-select">
                                        <option value="10" {{ ($systemSettings['piket_data_per_page'] ?? '25') == '10' ? 'selected' : '' }}>10 Data / Halaman</option>
                                        <option value="25" {{ ($systemSettings['piket_data_per_page'] ?? '25') == '25' ? 'selected' : '' }}>25 Data / Halaman</option>
                                        <option value="50" {{ ($systemSettings['piket_data_per_page'] ?? '25') == '50' ? 'selected' : '' }}>50 Data / Halaman</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="m-btn-save-mobile" style="background: #0284c7;">
                                <i class="fa-regular fa-floppy-disk"></i>
                                <span>Simpan Preferensi Piket</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 5. Kartu Bantuan WhatsApp CS -->
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $systemSettings['cs_whatsapp'] ?? '6281234567890') }}" target="_blank" class="m-menu-card-item" style="background: #f0fdf4; border-color: #bbf7d0; text-decoration: none; margin-top: 4px;">
            <div class="m-menu-icon-box" style="background: #dcfce7; border-color: #86efac; color: #16a34a;">
                <i class="fa-brands fa-whatsapp"></i>
            </div>
            <div class="m-menu-content">
                <div class="m-menu-title" style="color: #166534;">Bantuan Layanan Teknis</div>
                <div class="m-menu-sub" style="color: #15803d;">Hubungi admin sekolah via WhatsApp</div>
            </div>
            <i class="fa-solid fa-arrow-up-right-from-square" style="color: #16a34a; font-size: 13px;"></i>
        </a>

        <!-- 6. Tombol Keluar / Logout -->
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; width: 100%;">
            @csrf
            <button type="submit" class="m-btn-logout-mobile" onclick="return confirm('Apakah Anda yakin ingin keluar dari aplikasi?')">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Keluar dari Akun Piket</span>
            </button>
        </form>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════ -->
    <!-- DESKTOP VIEW (> 768px): TETAP UTUH 100%                         -->
    <!-- ═══════════════════════════════════════════════════════════════ -->
    <div class="piket-desktop-wrap">

        <!-- ─── 1. HEADER BANNER BERSAMA (GRADIENT + ILUSTRASI UNTUK 3 TAB) ─── -->
    <div class="piket-settings-header">
        <div class="piket-header-left">
            <div class="piket-header-icon">
                <i class="fa-solid fa-gear"></i>
            </div>
            <div class="piket-header-text-group">
                <span class="piket-header-badge">Pengaturan</span>
                <h1 class="piket-header-title">Pengaturan Akun &amp; Sistem</h1>
                <p class="piket-header-subtitle">Kelola profil pribadi, keamanan password, serta preferensi aplikasi EDU JOURNAL.</p>
            </div>
        </div>

        <div class="piket-header-illustration d-none d-md-flex">
            <!-- Decorative SVG Laptop with Shield and Plants -->
            <svg width="180" height="90" viewBox="0 0 200 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Soft cloud circles -->
                <circle cx="160" cy="50" r="40" fill="#e0f2fe" opacity="0.6"/>
                <circle cx="40" cy="60" r="30" fill="#dbeafe" opacity="0.5"/>
                <!-- Plant pot on left -->
                <path d="M40 75 L38 88 L52 88 L50 75 Z" fill="#93c5fd"/>
                <path d="M45 75 Q42 60 35 55 Q42 65 45 75 Z" fill="#10b981"/>
                <path d="M45 75 Q46 55 52 50 Q48 65 45 75 Z" fill="#34d399"/>
                <path d="M45 75 Q55 68 58 60 Q52 70 45 75 Z" fill="#059669"/>
                <!-- Laptop base -->
                <rect x="70" y="30" width="80" height="50" rx="6" fill="#1e293b"/>
                <rect x="74" y="34" width="72" height="42" rx="4" fill="#ffffff"/>
                <!-- Laptop screen illustration (shield & check) -->
                <path d="M110 42 Q110 40 106 39 Q102 40 102 42 Q102 52 106 56 Q110 52 110 42 Z" fill="#3b82f6"/>
                <path d="M104 47 L105.5 49 L108 45" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round"/>
                <!-- Laptop bottom stand -->
                <path d="M62 80 L158 80 L150 85 L70 85 Z" fill="#94a3b8"/>
                <rect x="100" y="80" width="20" height="2" rx="1" fill="#cbd5e1"/>
                <!-- Floating badge -->
                <circle cx="150" cy="32" r="9" fill="#2563eb"/>
                <path d="M150 28 L150 34 M147 31 L153 31" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </div>
    </div>

    <!-- ─── 2. SUBNAV TAB NAVIGASI ─── -->
    <div class="piket-subnav-bar">
        <button type="button" class="piket-tab-btn {{ $isProfileActive ? 'active' : '' }}" id="tabBtn-profile" onclick="switchPiketTab('profile')">
            <i class="fa-regular fa-user"></i>
            <span>Profil Saya</span>
        </button>

        <button type="button" class="piket-tab-btn {{ $isSecurityActive ? 'active' : '' }}" id="tabBtn-security" onclick="switchPiketTab('security')">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Keamanan</span>
        </button>

        <button type="button" class="piket-tab-btn {{ $isPrefActive ? 'active' : '' }}" id="tabBtn-preferences" onclick="switchPiketTab('preferences')">
            <i class="fa-solid fa-sliders"></i>
            <span>Preferensi &amp; Tugas Piket</span>
        </button>
    </div>

    <!-- Session Feedback Alerts -->
    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 10px; color: #065f46; font-size: 13.5px; font-weight: 750;">
            <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 18px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div style="background: #fff1f2; border: 1px solid #fecdd3; border-radius: 12px; padding: 14px 18px; color: #991b1b; font-size: 13px;">
            <div style="font-weight: 800; display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 16px;"></i>
                <span>Terdapat kesalahan pada input Anda:</span>
            </div>
            <ul style="margin-left: 24px; font-weight: 600;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ─────────────────────────────────────────────────────────────── -->
    <!-- TAB 1: PROFIL SAYA                                              -->
    <!-- ─────────────────────────────────────────────────────────────── -->
    <div id="piketTab-profile" class="piket-tab-content {{ $isProfileActive ? 'active' : '' }}">
        <form action="{{ route('pengaturan.update-profile') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="piket-card">
                <!-- Header Top Box: Avatar & Upload + Doodle Banner -->
                <div class="profil-top-card">
                    <div class="profil-avatar-section">
                        <div class="profil-avatar-wrap">
                            @if($user->foto_url)
                                <img id="piketAvatarImg" src="{{ $user->foto_url }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                <span id="piketAvatarLetter" style="display: none;">{{ strtoupper(substr($user->name ?? 'P', 0, 1)) }}</span>
                            @else
                                <span id="piketAvatarLetter">{{ strtoupper(substr($user->name ?? 'P', 0, 1)) }}</span>
                                <img id="piketAvatarImg" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            @endif
                            <div class="profil-avatar-badge">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <span style="font-size: 13px; font-weight: 800; color: #1e293b;">Foto Profil</span>
                            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                <label for="piketFotoInput" class="btn-choose-photo">
                                    <i class="fa-solid fa-camera"></i>
                                    <span>Pilih Foto Profil Baru</span>
                                </label>
                                <input type="file" id="piketFotoInput" name="foto" accept="image/*" style="display: none;" onchange="previewPiketPhoto(this)">

                                @if($user->foto)
                                    <label style="margin: 0; display: inline-flex; align-items: center; gap: 6px; font-size: 12px; color: #dc2626; cursor: pointer; font-weight: 700; background: #fee2e2; padding: 7px 12px; border-radius: 8px; border: 1px solid #fecaca;">
                                        <input type="checkbox" name="remove_photo" value="1">
                                        <i class="fa-solid fa-trash-can"></i> Hapus Foto
                                    </label>
                                @endif
                            </div>
                            <span style="font-size: 11.5px; color: #64748b; font-weight: 600;">
                                Ukuran file maksimal 2 MB. Format gambar yang diperbolehkan: JPG, JPEG, PNG, WEBP, GIF.
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Fields Form -->
                <!-- Row 1: Role (Read-only) & NIP (Read-only) -->
                <div class="piket-form-grid-2">
                    <div class="piket-form-group">
                        <label class="piket-form-label">Role / Jabatan</label>
                        <div class="piket-input-wrap">
                            <i class="fa-solid fa-user-check piket-input-icon"></i>
                            <input type="text" class="piket-form-input readonly-field" value="Petugas Piket" readonly title="Role Petugas Piket (Dikelola oleh Administrator)">
                        </div>
                    </div>

                    <div class="piket-form-group">
                        <label class="piket-form-label">NIP / Username</label>
                        <div class="piket-input-wrap">
                            <i class="fa-solid fa-pen-to-square piket-input-icon"></i>
                            <input type="text" class="piket-form-input readonly-field" value="{{ $user->nip ?? ($guru->nip ?? ($user->username ?? '199003032015031003')) }}" readonly title="NIP/Username resmi terdaftar di sistem">
                        </div>
                    </div>
                </div>

                <!-- Row 2: Nama Lengkap * (Editable, Full Width) -->
                <div class="piket-form-group full-width">
                    <label class="piket-form-label" for="inputName">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                    <div class="piket-input-wrap">
                        <i class="fa-regular fa-user piket-input-icon"></i>
                        <input type="text" id="inputName" name="name" class="piket-form-input @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required placeholder="Masukkan nama lengkap">
                    </div>
                </div>

                <!-- Row 3: Alamat Email (Editable) & Nomor HP / WhatsApp (Editable) -->
                <div class="piket-form-grid-2">
                    <div class="piket-form-group">
                        <label class="piket-form-label" for="inputEmail">Alamat Email</label>
                        <div class="piket-input-wrap">
                            <i class="fa-regular fa-envelope piket-input-icon"></i>
                            <input type="email" id="inputEmail" name="email" class="piket-form-input @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="piket@sekolah.sch.id">
                        </div>
                    </div>

                    <div class="piket-form-group">
                        <label class="piket-form-label" for="inputPhone">Nomor HP / WhatsApp</label>
                        <div class="piket-input-wrap">
                            <i class="fa-solid fa-phone piket-input-icon"></i>
                            <input type="text" id="inputPhone" name="no_hp" class="piket-form-input @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $user->no_hp ?? ($guru->no_hp ?? '')) }}" placeholder="085730241761">
                        </div>
                    </div>
                </div>

                <!-- Row 4: Jenis Kelamin (Editable) & Mata Pelajaran Diampu (Read-only) -->
                <div class="piket-form-grid-2">
                    <div class="piket-form-group">
                        <label class="piket-form-label">Jenis Kelamin</label>
                        <div class="piket-input-wrap">
                            <i class="fa-solid fa-venus-mars piket-input-icon"></i>
                            <select name="jenis_kelamin" class="piket-form-select">
                                <option value="L" {{ (old('jenis_kelamin', $user->jenis_kelamin ?? ($guru->jenis_kelamin ?? 'L')) == 'L') ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ (old('jenis_kelamin', $user->jenis_kelamin ?? ($guru->jenis_kelamin ?? '')) == 'P') ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="piket-form-group">
                        <label class="piket-form-label">Mata Pelajaran Diampu</label>
                        <div class="piket-input-wrap">
                            <i class="fa-solid fa-book-bookmark piket-input-icon"></i>
                            <input type="text" class="piket-form-input readonly-field" value="{{ $guru && $guru->mapel ? $guru->mapel->nama_mapel : 'Bahasa Inggris' }}" readonly title="Mapel diampu sesuai data master sekolah">
                        </div>
                    </div>
                </div>

                <!-- Row 5: Status Wali Kelas (Read-only, Full Width) -->
                <div class="piket-form-group full-width">
                    <label class="piket-form-label">Status Wali Kelas</label>
                    <div class="piket-input-wrap">
                        <i class="fa-solid fa-users piket-input-icon"></i>
                        <input type="text" class="piket-form-input readonly-field" value="{{ $kelasWali ? 'Wali Kelas ' . $kelasWali->nama_kelas : 'Bukan Wali Kelas (Petugas Piket Harian)' }}" readonly title="Status Wali Kelas">
                    </div>
                </div>

                <!-- Row 6: Cakupan Operasional Piket (Read-only, Full Width) -->
                <div class="piket-form-group full-width">
                    <label class="piket-form-label">Cakupan Operasional Piket</label>
                    <div class="piket-input-wrap">
                        <i class="fa-solid fa-shield-halved piket-input-icon"></i>
                        <input type="text" class="piket-form-input readonly-field" value="Monitoring Presensi Kelas, Penugasan Guru Pengganti, Rekap Kehadiran Guru & Izin Siswa" readonly title="Cakupan Operasional Piket">
                    </div>
                </div>

                <!-- Submit Button -->
                <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
                    <button type="submit" class="btn-piket-submit">
                        <i class="fa-regular fa-floppy-disk"></i>
                        <span>Simpan Perubahan Profil</span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 11px;"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Bottom Info Box -->
        <div class="piket-bottom-info-box">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-circle-info info-icon"></i>
                <span>Pastikan data yang Anda isi sudah benar dan terbaru agar tidak terjadi kendala pada sistem.</span>
            </div>
        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────── -->
    <!-- TAB 2: KEAMANAN                                                 -->
    <!-- ─────────────────────────────────────────────────────────────── -->
    <div id="piketTab-security" class="piket-tab-content {{ $isSecurityActive ? 'active' : '' }}">
        <form action="{{ route('pengaturan.update-password') }}" method="POST">
            @csrf

            <div class="piket-card">
                <!-- Header inside card with Shield Illustration -->
                <div class="piket-card-header">
                    <div class="piket-card-title-group">
                        <div class="piket-card-title-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h3 class="piket-card-title">Pengaturan Akun &amp; Keamanan</h3>
                            <p class="piket-card-subtitle">Ubah password dan konfirmasi password untuk menjaga keamanan akun Anda.</p>
                        </div>
                    </div>

                    <div class="d-none d-md-flex" style="opacity: 0.85;">
                        <svg width="70" height="60" viewBox="0 0 100 80" fill="none">
                            <path d="M50 15 Q75 10 85 25 Q85 55 50 75 Q15 55 15 25 Q25 10 50 15 Z" fill="#eff6ff" stroke="#bfdbfe" stroke-width="2"/>
                            <path d="M50 25 Q68 22 75 32 Q75 52 50 66 Q25 52 25 32 Q32 22 50 25 Z" fill="#3b82f6"/>
                            <rect x="42" y="40" width="16" height="12" rx="3" fill="#ffffff"/>
                            <path d="M46 40 V36 Q46 32 50 32 Q54 32 54 36 V40" stroke="#ffffff" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                </div>

                <!-- Field 1: Password Saat Ini * (Full Width) -->
                <div class="piket-form-group full-width">
                    <label class="piket-form-label" for="piketCurrentPass">Password Saat Ini <span style="color: #ef4444;">*</span></label>
                    <div class="piket-input-wrap">
                        <i class="fa-solid fa-lock piket-input-icon"></i>
                        <input type="password" id="piketCurrentPass" name="current_password" class="piket-form-input @error('current_password') is-invalid @enderror" required placeholder="Masukkan password lama Anda">
                        <button type="button" class="piket-password-toggle" onclick="togglePassVisibility('piketCurrentPass', this)" title="Lihat password">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <span style="color: #ef4444; font-size: 12px; font-weight: 700; margin-top: 4px;"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Field 2 & 3: Password Baru & Konfirmasi (2 Cols) -->
                <div class="piket-form-grid-2">
                    <div class="piket-form-group">
                        <label class="piket-form-label" for="piketNewPass">Password Baru <span style="color: #ef4444;">*</span></label>
                        <div class="piket-input-wrap">
                            <i class="fa-solid fa-lock piket-input-icon"></i>
                            <input type="password" id="piketNewPass" name="password" class="piket-form-input @error('password') is-invalid @enderror" required placeholder="Minimal 8 karakter">
                            <button type="button" class="piket-password-toggle" onclick="togglePassVisibility('piketNewPass', this)" title="Lihat password">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span style="color: #ef4444; font-size: 12px; font-weight: 700; margin-top: 4px;"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="piket-form-group">
                        <label class="piket-form-label" for="piketConfirmPass">Konfirmasi Password Baru <span style="color: #ef4444;">*</span></label>
                        <div class="piket-input-wrap">
                            <i class="fa-solid fa-lock piket-input-icon"></i>
                            <input type="password" id="piketConfirmPass" name="password_confirmation" class="piket-form-input" required placeholder="Ulangi password baru">
                            <button type="button" class="piket-password-toggle" onclick="togglePassVisibility('piketConfirmPass', this)" title="Lihat password">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
                    <button type="submit" class="btn-piket-submit gradient-purple">
                        <i class="fa-solid fa-key"></i>
                        <span>Perbarui Password</span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 11px;"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Bottom Info Box -->
        <div class="piket-bottom-info-box">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-circle-info info-icon"></i>
                <span>Pastikan password Anda kuat dan tidak mudah ditebak. Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol.</span>
            </div>
            <i class="fa-solid fa-shield-halved" style="color: #2563eb; font-size: 15px;"></i>
        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────── -->
    <!-- TAB 3: PREFERENSI & TUGAS PIKET                                 -->
    <!-- ─────────────────────────────────────────────────────────────── -->
    <div id="piketTab-preferences" class="piket-tab-content {{ $isPrefActive ? 'active' : '' }}">
        <form action="{{ route('pengaturan.update-preferences') }}" method="POST">
            @csrf

            <!-- CARD 1: Status & Informasi Petugas Piket -->
            <div class="piket-card">
                <div class="piket-card-header">
                    <div class="piket-card-title-group">
                        <div class="piket-card-title-icon">
                            <i class="fa-solid fa-id-badge"></i>
                        </div>
                        <div>
                            <h3 class="piket-card-title">Status &amp; Informasi Petugas Piket</h3>
                            <p class="piket-card-subtitle">Detail penugasan dan ringkasan operasional piket harian</p>
                        </div>
                    </div>
                </div>

                <!-- 4 Baris Status Piket Read-Only -->
                <div class="piket-status-row">
                    <span class="piket-status-label">Status Petugas</span>
                    <span class="piket-status-val">
                        <span class="badge-status-pill-green">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Aktif - Petugas Piket Harian Sekolah</span>
                        </span>
                    </span>
                </div>

                <div class="piket-status-row">
                    <span class="piket-status-label">Tanggal Piket Harian</span>
                    <span class="piket-status-val">
                        <i class="fa-regular fa-calendar-days" style="color: #64748b;"></i>
                        <span>{{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}</span>
                    </span>
                </div>

                <div class="piket-status-row">
                    <span class="piket-status-label">Cakupan Tugas</span>
                    <span class="piket-status-val">
                        <i class="fa-solid fa-list-check" style="color: #64748b;"></i>
                        <span>Monitoring Jurnal, Penugasan Guru Pengganti, Rekap Kehadiran, Verifikasi Izin</span>
                    </span>
                </div>

                <div class="piket-status-row">
                    <span class="piket-status-label">Integrasi Sistem</span>
                    <span class="piket-status-val">
                        <i class="fa-solid fa-link" style="color: #2563eb;"></i>
                        <span style="color: #2563eb; font-weight: 800;">Terhubung &amp; Tersinkronisasi Realtime</span>
                    </span>
                </div>

                <!-- 3 Stat Cards Piket Gradient -->
                @if($piketData)
                <div class="piket-stat-3-grid">
                    <div class="piket-stat-box blue">
                        <div class="piket-stat-box-icon">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="piket-stat-box-number">{{ $piketData['total_jurnal_piket'] ?? 0 }}</div>
                            <div class="piket-stat-box-label">Jurnal Harian Masuk</div>
                        </div>
                    </div>

                    <div class="piket-stat-box green">
                        <div class="piket-stat-box-icon">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div>
                            <div class="piket-stat-box-number">{{ $piketData['penugasan_aktif'] ?? 0 }}</div>
                            <div class="piket-stat-box-label">Guru Pengganti Aktif</div>
                        </div>
                    </div>

                    <div class="piket-stat-box red">
                        <div class="piket-stat-box-icon">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </div>
                        <div>
                            <div class="piket-stat-box-number">{{ $piketData['guru_tidak_hadir'] ?? 0 }}</div>
                            <div class="piket-stat-box-label">Guru Tidak Hadir Hari Ini</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- CARD 2: Notifikasi & Peringatan Instan Piket -->
            <div class="piket-card">
                <div class="piket-card-header">
                    <div class="piket-card-title-group">
                        <div class="piket-card-title-icon">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <div>
                            <h3 class="piket-card-title">Notifikasi &amp; Peringatan Instan Piket</h3>
                            <p class="piket-card-subtitle">Kelola pemberitahuan instan untuk mendukung tugas harian piket</p>
                        </div>
                    </div>
                </div>

                <!-- Toggle 1 -->
                <div class="piket-toggle-item">
                    <div class="piket-toggle-info">
                        <div class="piket-toggle-icon">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <div>
                            <div class="piket-toggle-title">Notifikasi Guru Tidak Hadir Realtime</div>
                            <div class="piket-toggle-sub">Terima notifikasi otomatis saat ada guru mengajukan izin/sakit hari ini</div>
                        </div>
                    </div>
                    <label class="switch-wrap">
                        <input type="checkbox" name="piket_notif_guru_izin" value="1" {{ ($systemSettings['piket_notif_guru_izin'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Toggle 2 -->
                <div class="piket-toggle-item">
                    <div class="piket-toggle-info">
                        <div class="piket-toggle-icon">
                            <i class="fa-regular fa-file-lines"></i>
                        </div>
                        <div>
                            <div class="piket-toggle-title">Alert Monitoring Jurnal Belum Didaftarkan</div>
                            <div class="piket-toggle-sub">Ingatkan kelas yang belum terisi jurnal mengajar setelah jam pelajaran selesai</div>
                        </div>
                    </div>
                    <label class="switch-wrap">
                        <input type="checkbox" name="piket_notif_jurnal_kosong" value="1" {{ ($systemSettings['piket_notif_jurnal_kosong'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Toggle 3 -->
                <div class="piket-toggle-item">
                    <div class="piket-toggle-info">
                        <div class="piket-toggle-icon">
                            <i class="fa-solid fa-user-group"></i>
                        </div>
                        <div>
                            <div class="piket-toggle-title">Pemberitahuan Dispensasi &amp; Surat Izin Siswa</div>
                            <div class="piket-toggle-sub">Notifikasi instan saat terdapat siswa mengajukan surat izin / dispensasi meninggalkan kelas</div>
                        </div>
                    </div>
                    <label class="switch-wrap">
                        <input type="checkbox" name="piket_notif_dispensasi" value="1" {{ ($systemSettings['piket_notif_dispensasi'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <!-- Toggle 4 -->
                <div class="piket-toggle-item">
                    <div class="piket-toggle-info">
                        <div class="piket-toggle-icon">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="piket-toggle-title">Laporan Ringkasan Harian Piket</div>
                            <div class="piket-toggle-sub">Kirimkan ringkasan harian kehadiran &amp; penugasan guru pengganti setiap sore</div>
                        </div>
                    </div>
                    <label class="switch-wrap">
                        <input type="checkbox" name="piket_notif_ringkasan" value="1" {{ ($systemSettings['piket_notif_ringkasan'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>
            </div>

            <!-- CARD 3: Preferensi Operasional Penugasan Piket -->
            <div class="piket-card">
                <div class="piket-card-header">
                    <div class="piket-card-title-group">
                        <div class="piket-card-title-icon">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        <div>
                            <h3 class="piket-card-title">Preferensi Operasional Penugasan Piket</h3>
                            <p class="piket-card-subtitle">Pengaturan mode alur penugasan dan cetak dokumen untuk Guru Piket</p>
                        </div>
                    </div>
                </div>

                <!-- Dropdown 1: Mode Penugasan Guru Pengganti -->
                <div class="piket-pref-dropdown-row">
                    <div class="piket-toggle-info">
                        <div class="piket-toggle-icon">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <div>
                            <div class="piket-toggle-title">Mode Penugasan Guru Pengganti</div>
                            <div class="piket-toggle-sub">Metode penentuan guru pengganti saat ada guru berhalangan hadir</div>
                        </div>
                    </div>
                    <select name="piket_mode_guru_pengganti" class="piket-pref-dropdown-select">
                        <option value="manual" {{ ($systemSettings['piket_mode_guru_pengganti'] ?? 'manual') == 'manual' ? 'selected' : '' }}>Pilih Manual oleh Piket</option>
                        <option value="auto" {{ ($systemSettings['piket_mode_guru_pengganti'] ?? '') == 'auto' ? 'selected' : '' }}>Penugasan Otomatis Berdasarkan Jadwal Kosong</option>
                    </select>
                </div>

                <!-- Dropdown 2: Format Default Cetak Rekap Piket -->
                <div class="piket-pref-dropdown-row">
                    <div class="piket-toggle-info">
                        <div class="piket-toggle-icon">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <div>
                            <div class="piket-toggle-title">Format Default Cetak Rekap Piket</div>
                            <div class="piket-toggle-sub">Format dokumen saat mencetak laporan rekap kehadiran &amp; jurnal piket</div>
                        </div>
                    </div>
                    <select name="piket_export_format" class="piket-pref-dropdown-select">
                        <option value="pdf" {{ ($systemSettings['piket_export_format'] ?? 'pdf') == 'pdf' ? 'selected' : '' }}>Dokumen PDF</option>
                        <option value="excel" {{ ($systemSettings['piket_export_format'] ?? '') == 'excel' ? 'selected' : '' }}>Spreadsheet Excel (.xlsx)</option>
                        <option value="csv" {{ ($systemSettings['piket_export_format'] ?? '') == 'csv' ? 'selected' : '' }}>File CSV (.csv)</option>
                    </select>
                </div>

                <!-- Dropdown 3: Jumlah Data Default Per Halaman -->
                <div class="piket-pref-dropdown-row">
                    <div class="piket-toggle-info">
                        <div class="piket-toggle-icon">
                            <i class="fa-regular fa-calendar-days"></i>
                        </div>
                        <div>
                            <div class="piket-toggle-title">Jumlah Data Default Per Halaman</div>
                            <div class="piket-toggle-sub">Jumlah baris data yang ditampilkan pada tabel rekap dan jurnal piket</div>
                        </div>
                    </div>
                    <select name="piket_data_per_page" class="piket-pref-dropdown-select">
                        <option value="10" {{ ($systemSettings['piket_data_per_page'] ?? '25') == '10' ? 'selected' : '' }}>10 Data / Hal</option>
                        <option value="25" {{ ($systemSettings['piket_data_per_page'] ?? '25') == '25' ? 'selected' : '' }}>25 Data / Hal</option>
                        <option value="50" {{ ($systemSettings['piket_data_per_page'] ?? '25') == '50' ? 'selected' : '' }}>50 Data / Hal</option>
                        <option value="100" {{ ($systemSettings['piket_data_per_page'] ?? '25') == '100' ? 'selected' : '' }}>100 Data / Hal</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div style="display: flex; justify-content: flex-end; margin-top: 14px;">
                    <button type="submit" class="btn-piket-submit">
                        <i class="fa-regular fa-floppy-disk"></i>
                        <span>Simpan Preferensi Guru Piket</span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 11px;"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div> <!-- piket-desktop-wrap -->

</div>

<script>
    function switchPiketTab(tabName) {
        // Tab Buttons
        document.querySelectorAll('.piket-tab-btn').forEach(btn => btn.classList.remove('active'));
        const activeBtn = document.getElementById('tabBtn-' + tabName);
        if (activeBtn) activeBtn.classList.add('active');

        // Tab Contents
        document.querySelectorAll('.piket-tab-content').forEach(content => content.classList.remove('active'));
        const activeContent = document.getElementById('piketTab-' + tabName);
        if (activeContent) activeContent.classList.add('active');

        // Update URL state without page reload
        const url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.replaceState({}, '', url);
    }

    function togglePassVisibility(inputId, btnEl) {
        const input = document.getElementById(inputId);
        const icon = btnEl.querySelector('i');
        if (!input) return;

        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fa-regular fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fa-regular fa-eye';
        }
    }

    function previewPiketPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('piketAvatarImg');
                const letter = document.getElementById('piketAvatarLetter');
                if (img) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                if (letter) {
                    letter.style.display = 'none';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function toggleMobileSettingsAccordion(id) {
        const body = document.getElementById(id);
        const chevron = document.getElementById('m-chevron-' + id);
        if (!body) return;
        
        const isOpen = body.classList.contains('open');
        if (isOpen) {
            body.classList.remove('open');
            if (chevron) chevron.classList.remove('rotated');
        } else {
            body.classList.add('open');
            if (chevron) chevron.classList.add('rotated');
        }
    }

    function previewPiketMobilePhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('piketAvatarMobileImg');
                const letter = document.getElementById('piketAvatarMobileLetter');
                if (img) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                if (letter) {
                    letter.style.display = 'none';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
