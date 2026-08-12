@extends($layout)

@section('title', 'Customer Service & Bantuan — Jurnal ESEMKITA')
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
<div class="cs-container">
    
    <!-- Header Section -->
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 18px; padding: 28px 32px; color: #ffffff; box-shadow: 0 6px 20px rgba(37, 99, 235, 0.2); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <span style="background: rgba(255, 255, 255, 0.2); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Pusat Bantuan & Support</span>
            <h2 style="font-size: 22px; font-weight: 800; margin-top: 6px;">Customer Service Jurnal ESEMKITA</h2>
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

    <!-- Main Content Area: Form & History -->
    <div class="cs-content-grid">
        
        <!-- Left: Form Kirim Tiket CS -->
        <div class="cs-section-card">
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
