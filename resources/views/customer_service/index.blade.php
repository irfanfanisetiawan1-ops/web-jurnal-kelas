@extends($layout)

@section('title', 'Customer Service & Bantuan — EDU JOURNAL')
@section('header_title', 'Customer Service')

@section('styles')
<style>
    .cs-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Cards Top Grid */
    .cs-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .cs-contact-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: flex-start;
        gap: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .cs-contact-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .cs-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .cs-icon-wa { background: #dcfce7; color: #16a34a; }
    .cs-icon-email { background: #e0f2fe; color: #0284c7; }
    .cs-icon-hours { background: #fef3c7; color: #d97706; }

    .cs-contact-info h4 {
        font-size: 15px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .cs-contact-info p {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 12px;
    }

    .btn-wa-direct {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #25d366;
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        transition: all 0.2s ease;
    }

    .btn-wa-direct:hover {
        background: #1eb956;
        color: #ffffff;
        transform: scale(1.02);
    }

    /* ── ChatBot Styles (Clean Typography, No Icons/Emojis) ── */
    .chatbot-card-wrapper {
        border: 1px solid #cbd5e1;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.08);
        border-radius: 18px;
        overflow: hidden;
        background: #ffffff;
    }

    .chatbot-header-bar {
        background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);
        padding: 16px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .bot-avatar-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .user-role-badge {
        font-size: 12px;
        font-weight: 700;
        background: #dbeafe;
        color: #1e40af;
        padding: 6px 14px;
        border-radius: 20px;
        display: inline-block;
    }

    .btn-reset-chat {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #64748b;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-reset-chat:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .quick-topics-wrapper {
        padding: 12px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .quick-pills-scroll {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding: 2px 0 6px 0;
        white-space: nowrap;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .quick-pills-scroll::-webkit-scrollbar {
        display: none;
    }

    .quick-topic-pill {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 7px 16px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .quick-topic-pill:hover {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }

    .chatbot-messages-body {
        padding: 24px;
        max-height: 420px;
        height: 380px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 16px;
        background: #ffffff;
        scroll-behavior: smooth;
    }

    .chat-message {
        display: flex;
        gap: 12px;
        max-width: 85%;
    }

    .chat-message.user-message {
        margin-left: auto;
        flex-direction: row-reverse;
    }

    .chat-message.bot-message {
        margin-right: auto;
    }

    .bot-msg-avatar {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #2563eb;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
        margin-top: 4px;
    }

    .user-msg-avatar {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #475569;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
        margin-top: 4px;
    }

    .bot-msg-content {
        background: #f1f5f9;
        color: #1e293b;
        padding: 14px 18px;
        border-radius: 16px;
        border-top-left-radius: 4px;
        font-size: 13.5px;
        line-height: 1.55;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }

    .user-msg-content {
        background: #2563eb;
        color: #ffffff;
        padding: 12px 18px;
        border-radius: 16px;
        border-top-right-radius: 4px;
        font-size: 13.5px;
        line-height: 1.5;
        box-shadow: 0 3px 10px rgba(37, 99, 235, 0.2);
    }

    .bot-name {
        font-size: 11px;
        font-weight: 800;
        color: #2563eb;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-bot-action-link {
        display: inline-block;
        background: #2563eb;
        color: #ffffff !important;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        margin-top: 10px;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-bot-action-link:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .bot-suggestions-group {
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid #cbd5e1;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .bot-sub-pill {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 5px 12px;
        border-radius: 14px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .bot-sub-pill:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .chatbot-input-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    .chatbot-input-field {
        flex: 1;
        padding: 12px 18px;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        font-size: 13.5px;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .chatbot-input-field:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .btn-send-chat {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-send-chat:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    /* Typing indicator animation */
    .typing-dots {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 6px 0;
    }

    .typing-dots span {
        width: 7px;
        height: 7px;
        background: #64748b;
        border-radius: 50%;
        animation: typingBounce 1.4s infinite ease-in-out both;
    }

    .typing-dots span:nth-child(1) { animation-delay: -0.32s; }
    .typing-dots span:nth-child(2) { animation-delay: -0.16s; }

    @keyframes typingBounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }

    /* Layout Content Grid */
    .cs-content-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 24px;
    }

    .cs-section-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .cs-section-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .cs-section-header h3 {
        font-size: 16.5px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cs-section-body {
        padding: 24px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }

    .form-control {
        width: 100%;
        padding: 11px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13.5px;
        font-family: inherit;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .btn-send-ticket {
        width: 100%;
        background: #2563eb;
        color: #ffffff;
        padding: 12px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .btn-send-ticket:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    /* Table Styles */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .cs-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .cs-table th {
        background: #f8fafc;
        padding: 12px 16px;
        text-align: left;
        font-weight: 800;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .cs-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: top;
        color: #334155;
    }

    .cs-table tr:hover {
        background: #f8fafc;
    }

    .ticket-code {
        font-family: monospace;
        font-weight: 800;
        color: #1e293b;
        background: #f1f5f9;
        padding: 3px 8px;
        border-radius: 6px;
    }

    .response-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 10px 12px;
        margin-top: 6px;
        font-size: 12.5px;
        color: #166534;
    }

    .response-box strong {
        color: #14532d;
    }

    /* Modal Admin Response */
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-backdrop.open {
        display: flex;
    }

    .modal-content {
        background: #ffffff;
        border-radius: 16px;
        max-width: 550px;
        width: 100%;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        animation: modalSlide 0.25s ease-out;
    }

    @keyframes modalSlide {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        padding: 20px 24px;
        background: #1e293b;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h4 {
        font-size: 16px;
        font-weight: 800;
    }

    .modal-close {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 18px;
        cursor: pointer;
    }

    .modal-close:hover { color: #ffffff; }

    .modal-body {
        padding: 24px;
    }

    @media (max-width: 992px) {
        .cs-cards-grid {
            grid-template-columns: 1fr;
        }
        .cs-content-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<!-- Header Top Bar -->
<div class="page-header-container">
    <div class="page-title-group">
        <h1>Customer Service & Bantuan</h1>
        <p>Layanan bantuan teknis, pelaporan kendala sistem, dan pusat panduan</p>
    </div>
</div>
<div class="cs-container">
    
    <!-- Header Section -->
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 18px; padding: 28px 32px; color: #ffffff; box-shadow: 0 6px 20px rgba(37, 99, 235, 0.2); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <span style="background: rgba(255, 255, 255, 0.2); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Pusat Bantuan & Support</span>
            <h2 style="font-size: 22px; font-weight: 800; margin-top: 6px;">Customer Service EDU JOURNAL</h2>
            <p style="font-size: 13.5px; color: #dbeafe; margin-top: 4px;">Kami siap membantu kendala penggunaan sistem presensi dan portal mengajar Anda.</p>
        </div>
        <div>
            <a href="{{ $waLink }}" target="_blank" class="btn-wa-direct" style="padding: 12px 20px; font-size: 14px;">
                <i class="fa-brands fa-whatsapp" style="font-size: 18px;"></i> Live Chat WhatsApp CS
            </a>
        </div>
    </div>

    <!-- Contact Cards Top Grid -->
    <div class="cs-cards-grid">
        <div class="cs-contact-card">
            <div class="cs-icon-wrapper cs-icon-wa">
                <i class="fa-brands fa-whatsapp"></i>
            </div>
            <div class="cs-contact-info">
                <h4>Hotline WhatsApp</h4>
                <p>{{ $csInfo['whatsapp'] }}</p>
                <a href="{{ $waLink }}" target="_blank" class="btn-wa-direct">
                    <i class="fa-brands fa-whatsapp"></i> Hubungi CS Sekarang
                </a>
            </div>
        </div>

        <div class="cs-contact-card">
            <div class="cs-icon-wrapper cs-icon-email">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="cs-contact-info">
                <h4>Email Support</h4>
                <p>{{ $csInfo['email'] }}</p>
                <a href="mailto:{{ $csInfo['email'] }}" style="color: #0284c7; font-size: 12.5px; font-weight: 700; text-decoration: none;">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Email
                </a>
            </div>
        </div>

        <div class="cs-contact-card">
            <div class="cs-icon-wrapper cs-icon-hours">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="cs-contact-info">
                <h4>Jam Operasional CS</h4>
                <p>{{ $csInfo['jam_kerja'] }}</p>
                <span style="font-size: 11.5px; color: #16a34a; font-weight: 700; background: #dcfce7; padding: 3px 8px; border-radius: 12px;">
                    <i class="fa-solid fa-circle" style="font-size: 8px;"></i> CS Online
                </span>
            </div>
        </div>
    </div>

    <!-- Asisten Virtual CS (Murni Tanpa Emoji & Bentuk) -->
    <div class="chatbot-card-wrapper" id="chatbot-section">
        <div class="chatbot-header-bar">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div class="bot-avatar-icon">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: #0f172a;">
                        Asisten Virtual CS <span style="background: linear-gradient(135deg, #2563eb, #7c3aed); color: #fff; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 700; margin-left: 6px;">AI Chat Bot</span>
                    </h3>
                    <p style="margin: 2px 0 0 0; font-size: 12.5px; color: #64748b;">
                        Online 24/7 — Siap menjawab panduan, alur sistem & solusi masalah untuk <strong>{{ $user->role_label }}</strong>
                    </p>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span class="user-role-badge">
                    Role: {{ $user->role_label }}
                </span>
                <button type="button" class="btn-reset-chat" onclick="resetChatBot()" title="Reset Percakapan">
                    Reset Chat
                </button>
            </div>
        </div>

        <!-- Quick Recommended Topics Pills (Teks Bersih Murni Tanpa Emoji & Bentuk) -->
        <div class="quick-topics-wrapper">
            <span style="font-size: 12px; font-weight: 800; color: #475569; display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                Topik Cepat:
            </span>
            <div class="quick-pills-scroll">
                @foreach($quickTopics as $topic)
                    <button type="button" class="quick-topic-pill" onclick="sendQuickQuery('{{ addslashes($topic['query']) }}')">
                        {{ $topic['label'] }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Chat Messages Body -->
        <div class="chatbot-messages-body" id="chatbot-messages">
            <!-- Initial Welcome Bot Message -->
            <div class="chat-message bot-message">
                <div class="bot-msg-avatar">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <div class="bot-msg-content">
                    <div class="bot-name">Asisten CS EDU JOURNAL</div>
                    <div class="bot-text">
                        Halo <strong>{{ $user->name }}</strong>,<br>
                        Saya adalah Asisten Virtual CS EDU JOURNAL. Sebagai <strong>{{ $user->role_label }}</strong>, Anda dapat menanyakan tentang panduan fitur, alur kerja sistem, atau cara mengatasi kendala teknis yang terjadi pada sistem.<br><br>
                        Silakan pilih <strong>Topik Cepat</strong> di atas atau ketikkan pertanyaan/masalah Anda pada kolom di bawah ini.
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Input Footer -->
        <div class="chatbot-input-footer">
            <form id="chatbotForm" onsubmit="handleChatSubmit(event)" style="display: flex; gap: 10px; width: 100%;">
                <input type="text" id="chatbotInput" class="chatbot-input-field" placeholder="Ketikkan pertanyaan atau kendala Anda di sini... (contoh: cara isi jurnal, reset password, barcode kadaluarsa)" autocomplete="off">
                <button type="submit" class="btn-send-chat" id="btnSendChat">
                    <span>Kirim</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Area: Form & History -->
    <div class="cs-content-grid">
        
        <!-- Left: Form Kirim Kendala CS -->
        <div class="cs-section-card" id="form-tiket-cs">
            <div class="cs-section-header">
                <h3><i class="fa-solid fa-pen-to-square" style="color: #2563eb;"></i> Form Kirim Kendala</h3>
            </div>
            <div class="cs-section-body">
                <form action="{{ route('customer-service.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kategori">Kategori Kendala <span style="color: #ef4444;">*</span></label>
                        <select id="kategori" name="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Kendala Presensi">Kendala Presensi / Jurnal Mengajar</option>
                            <option value="Masalah Akun / Password">Masalah Akun / Reset Password</option>
                            <option value="Pertanyaan Sistem">Pertanyaan / Panduan Sistem</option>
                            <option value="Saran & Masukan">Saran & Masukan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subjek">Subjek Kendala <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="subjek" name="subjek" class="form-control" placeholder="Contoh: Tidak bisa menyimpan jurnal kelas X RPL 1" required>
                    </div>

                    <div class="form-group">
                        <label for="pesan">Rincian Pesan & Kendala <span style="color: #ef4444;">*</span></label>
                        <textarea id="pesan" name="pesan" class="form-control" rows="5" placeholder="Jelaskan secara rinci kendala yang Anda alami..." required></textarea>
                    </div>

                    <button type="submit" class="btn-send-ticket">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Tiket Bantuan
                    </button>
                </form>
            </div>
        </div>

        <!-- Right: Tabel Riwayat Tiket CS Saya -->
        <div class="cs-section-card">
            <div class="cs-section-header">
                <h3><i class="fa-solid fa-ticket" style="color: #059669;"></i> Riwayat Tiket Bantuan Saya</h3>
                <span style="font-size: 12px; font-weight: 700; color: #64748b;">Total: {{ $myTickets->count() }} Tiket</span>
            </div>
            <div class="cs-section-body" style="padding: 0;">
                @if($myTickets->isEmpty())
                    <div style="padding: 40px; text-align: center; color: #64748b;">
                        <i class="fa-solid fa-clipboard-check" style="font-size: 40px; color: #cbd5e1; margin-bottom: 12px;"></i>
                        <p style="font-weight: 700; font-size: 14px;">Belum Ada Tiket Bantuan</p>
                        <p style="font-size: 12.5px;">Jika ada kendala, kirimkan pertanyaan melalui form di samping.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="cs-table">
                            <thead>
                                <tr>
                                    <th>Kode & Tanggal</th>
                                    <th>Kategori & Subjek</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myTickets as $ticket)
                                    <tr>
                                        <td>
                                            <span class="ticket-code">{{ $ticket->ticket_code }}</span>
                                            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                                                <i class="fa-regular fa-clock"></i> {{ $ticket->created_at->format('d M Y H:i') }}
                                            </div>
                                        </td>
                                        <td>
                                            <strong style="color: #1e293b;">{{ $ticket->subjek }}</strong>
                                            <div style="font-size: 12px; color: #64748b;">Kategori: {{ $ticket->kategori }}</div>
                                            <div style="font-size: 12.5px; color: #475569; margin-top: 4px; font-style: italic;">
                                                "{{ Str::limit($ticket->pesan, 80) }}"
                                            </div>

                                            @if($ticket->tanggapan_admin)
                                                <div class="response-box">
                                                    <strong><i class="fa-solid fa-reply"></i> Tanggapan Tim CS:</strong>
                                                    <div>{{ $ticket->tanggapan_admin }}</div>
                                                    <div style="font-size: 11px; color: #15803d; margin-top: 2px;">
                                                        Oleh: {{ $ticket->responder->name ?? 'Admin CS' }} ({{ $ticket->responded_at ? $ticket->responded_at->format('d M Y H:i') : '-' }})
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            {!! $ticket->status_badge !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($user->isAdmin())
    <!-- Panel Pengelolaan Tiket CS Pengguna (Khusus Admin/TU) -->
    <div class="cs-section-card" style="margin-top: 10px;">
        <div class="cs-section-header">
            <h3><i class="fa-solid fa-headset" style="color: #4f46e5;"></i> Kelola Tiket Masuk Pengguna (Administrator Panel)</h3>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('customer-service.index') }}" class="btn-filter {{ !request('status') ? 'active' : '' }}" style="padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; background: {{ !request('status') ? '#1e293b' : '#f1f5f9' }}; color: {{ !request('status') ? '#fff' : '#475569' }};">Semua</a>
                <a href="{{ route('customer-service.index', ['status' => 'pending']) }}" style="padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; background: {{ request('status') == 'pending' ? '#92400e' : '#fef3c7' }}; color: {{ request('status') == 'pending' ? '#fff' : '#92400e' }};">Pending</a>
                <a href="{{ route('customer-service.index', ['status' => 'diproses']) }}" style="padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; background: {{ request('status') == 'diproses' ? '#075985' : '#e0f2fe' }}; color: {{ request('status') == 'diproses' ? '#fff' : '#075985' }};">Diproses</a>
                <a href="{{ route('customer-service.index', ['status' => 'selesai']) }}" style="padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; background: {{ request('status') == 'selesai' ? '#065f46' : '#d1fae5' }}; color: {{ request('status') == 'selesai' ? '#fff' : '#065f46' }};">Selesai</a>
            </div>
        </div>

        <div class="cs-section-body" style="padding: 0;">
            @if($allTickets->isEmpty())
                <div style="padding: 30px; text-align: center; color: #64748b;">
                    <p style="font-weight: 700;">Tidak ada tiket masuk dari pengguna.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="cs-table">
                        <thead>
                            <tr>
                                <th>Kode & Pelapor</th>
                                <th>Kategori & Kendala</th>
                                <th>Status saat ini</th>
                                <th>Tanggapan Admin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allTickets as $t)
                                <tr>
                                    <td>
                                        <span class="ticket-code">{{ $t->ticket_code }}</span>
                                        <div style="font-weight: 800; color: #1e293b; margin-top: 4px;">{{ $t->user->name ?? 'Pengguna' }}</div>
                                        <div style="font-size: 11px; color: #64748b;">Role: {{ $t->user->role_label ?? '-' }}</div>
                                        <div style="font-size: 11px; color: #94a3b8;"><i class="fa-regular fa-clock"></i> {{ $t->created_at->format('d M Y H:i') }}</div>
                                    </td>
                                    <td>
                                        <strong style="color: #1e293b;">{{ $t->subjek }}</strong>
                                        <div style="font-size: 12px; color: #2563eb;">Kategori: {{ $t->kategori }}</div>
                                        <div style="font-size: 12.5px; color: #475569; margin-top: 4px; background: #f8fafc; padding: 8px; border-radius: 8px; border: 1px solid #e2e8f0;">
                                            {{ $t->pesan }}
                                        </div>
                                    </td>
                                    <td>
                                        {!! $t->status_badge !!}
                                    </td>
                                    <td>
                                        @if($t->tanggapan_admin)
                                            <div class="response-box">
                                                <div>{{ $t->tanggapan_admin }}</div>
                                                <div style="font-size: 10.5px; color: #15803d; margin-top: 2px;">
                                                    Oleh: {{ $t->responder->name ?? 'Admin' }} ({{ $t->responded_at ? $t->responded_at->format('d M Y H:i') : '-' }})
                                                </div>
                                            </div>
                                        @else
                                            <span style="color: #94a3b8; font-style: italic; font-size: 12px;">Belum ditanggapi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn-wa-direct" style="padding: 6px 12px; font-size: 12px; background: #3b82f6;" onclick="openRespondModal('{{ $t->id }}', '{{ $t->ticket_code }}', '{{ $t->status }}', '{{ addslashes($t->tanggapan_admin ?? '') }}')">
                                            <i class="fa-solid fa-reply"></i> Balas / Status
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="padding: 16px 24px;">
                    {{ $allTickets->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Respond Admin -->
    <div id="respondModal" class="modal-backdrop">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modalTicketCode">Tanggapi Tiket CS</h4>
                <button type="button" class="modal-close" onclick="closeRespondModal()">&times;</button>
            </div>
            <form id="respondForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modalStatus">Update Status Tiket <span style="color: #ef4444;">*</span></label>
                        <select id="modalStatus" name="status" class="form-control" required>
                            <option value="pending">Pending (Menunggu)</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai (Resolved)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="modalResponse">Tanggapan / Jawaban Admin</label>
                        <textarea id="modalResponse" name="tanggapan_admin" class="form-control" rows="4" placeholder="Tuliskan balasan atau instruksi penyelesaian untuk pelapor..."></textarea>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                        <button type="button" onclick="closeRespondModal()" style="padding: 10px 18px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #475569; font-weight: 700; cursor: pointer;">Batal</button>
                        <button type="submit" class="btn-send-ticket" style="width: auto; padding: 10px 20px;">Simpan Tanggapan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    const CSRF_TOKEN = '{{ csrf_token() }}';
    const CHATBOT_URL = '{{ route("customer-service.chatbot.ask") }}';

    function sendQuickQuery(queryText) {
        document.getElementById('chatbotInput').value = queryText;
        processChatQuery(queryText);
    }

    function handleChatSubmit(e) {
        e.preventDefault();
        const input = document.getElementById('chatbotInput');
        const queryText = input.value.trim();
        if (!queryText) return;
        processChatQuery(queryText);
        input.value = '';
    }

    function processChatQuery(queryText) {
        const messagesContainer = document.getElementById('chatbot-messages');

        // Gelembung Pesan Pengguna
        const userMsgHtml = `
            <div class="chat-message user-message">
                <div class="user-msg-avatar"><i class="fa-solid fa-user"></i></div>
                <div class="user-msg-content">${escapeHtml(queryText)}</div>
            </div>
        `;
        messagesContainer.insertAdjacentHTML('beforeend', userMsgHtml);
        scrollToBottom();

        // Indikator Mengetik
        const typingId = 'typing-' + Date.now();
        const typingHtml = `
            <div class="chat-message bot-message" id="${typingId}">
                <div class="bot-msg-avatar"><i class="fa-solid fa-robot"></i></div>
                <div class="bot-msg-content">
                    <div class="bot-name">Asisten CS EDU JOURNAL</div>
                    <div class="typing-dots"><span></span><span></span><span></span></div>
                </div>
            </div>
        `;
        messagesContainer.insertAdjacentHTML('beforeend', typingHtml);
        scrollToBottom();

        // Request AJAX ke Backend
        fetch(CHATBOT_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ query: queryText })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById(typingId)?.remove();

            let actionBtnHtml = '';
            if (data.action_button) {
                if (data.action_button.trigger_form) {
                    actionBtnHtml = `<br><button type="button" class="btn-bot-action-link" onclick="triggerTicketForm('${escapeHtml(data.topic)}')">
                        ${data.action_button.label}
                    </button>`;
                } else {
                    actionBtnHtml = `<br><a href="${data.action_button.url}" class="btn-bot-action-link">
                        ${data.action_button.label}
                    </a>`;
                }
            }

            let suggestionsHtml = '';
            if (data.quick_suggestions && data.quick_suggestions.length > 0) {
                suggestionsHtml = `<div class="bot-suggestions-group">
                    <span style="font-size: 11px; color: #64748b; font-weight: 700; width: 100%; margin-bottom: 2px;">Tanya topik terkait:</span>
                    ${data.quick_suggestions.map(s => `<button type="button" class="bot-sub-pill" onclick="sendQuickQuery('${escapeHtml(s)}')">${escapeHtml(s)}</button>`).join('')}
                </div>`;
            }

            const botMsgHtml = `
                <div class="chat-message bot-message">
                    <div class="bot-msg-avatar"><i class="fa-solid fa-robot"></i></div>
                    <div class="bot-msg-content">
                        <div class="bot-name">Asisten CS — ${escapeHtml(data.topic)}</div>
                        <div class="bot-text">${data.reply} ${actionBtnHtml} ${suggestionsHtml}</div>
                    </div>
                </div>
            `;
            messagesContainer.insertAdjacentHTML('beforeend', botMsgHtml);
            scrollToBottom();
        })
        .catch(err => {
            document.getElementById(typingId)?.remove();
            const errorHtml = `
                <div class="chat-message bot-message">
                    <div class="bot-msg-avatar" style="background:#ef4444;"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div class="bot-msg-content" style="background:#fef2f2; color:#991b1b;">
                        <div class="bot-name" style="color:#dc2626;">Sistem Gangguan</div>
                        Maaf, terjadi kesalahan koneksi saat memproses pertanyaan Anda. Silakan coba lagi atau kirimkan tiket bantuan melalui form di bawah.
                    </div>
                </div>
            `;
            messagesContainer.insertAdjacentHTML('beforeend', errorHtml);
            scrollToBottom();
        });
    }

    function scrollToBottom() {
        const container = document.getElementById('chatbot-messages');
        container.scrollTop = container.scrollHeight;
    }

    function resetChatBot() {
        const container = document.getElementById('chatbot-messages');
        container.innerHTML = `
            <div class="chat-message bot-message">
                <div class="bot-msg-avatar"><i class="fa-solid fa-robot"></i></div>
                <div class="bot-msg-content">
                    <div class="bot-name">Asisten CS EDU JOURNAL</div>
                    <div class="bot-text">
                        Percakapan telah di-reset. Silakan pilih topik rekomendasi di atas atau ketikkan pertanyaan baru Anda.
                    </div>
                </div>
            </div>
        `;
    }

    function triggerTicketForm(subjekPreset) {
        const kategoriSelect = document.getElementById('kategori');
        const subjekInput = document.getElementById('subjek');
        const pesanInput = document.getElementById('pesan');

        if (subjekInput) {
            subjekInput.value = 'Kendala: ' + subjekPreset;
        }
        if (kategoriSelect) {
            kategoriSelect.value = 'Pertanyaan Sistem';
        }
        if (pesanInput) {
            pesanInput.focus();
        }

        document.getElementById('kategori')?.scrollIntoView({ behavior: 'smooth' });
    }

    function escapeHtml(text) {
        if (!text) return '';
        return String(text)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function openRespondModal(ticketId, ticketCode, currentStatus, currentResponse) {
        const modal = document.getElementById('respondModal');
        const form = document.getElementById('respondForm');
        const codeHeader = document.getElementById('modalTicketCode');
        const statusSelect = document.getElementById('modalStatus');
        const responseText = document.getElementById('modalResponse');

        form.action = `/customer-service/${ticketId}/respond`;
        codeHeader.innerText = `Tanggapi Tiket: ${ticketCode}`;
        statusSelect.value = currentStatus;
        responseText.value = currentResponse;

        modal.classList.add('open');
    }

    function closeRespondModal() {
        document.getElementById('respondModal').classList.remove('open');
    }
</script>
@endsection
