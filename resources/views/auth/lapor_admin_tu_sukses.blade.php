<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Berhasil Terkirim — EDU JOURNAL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary:       #2563eb;
            --primary-hover: #1d4ed8;
            --text-dark:     #0f172a;
            --text-body:     #334155;
            --text-muted:    #64748b;
            --bg-page:       #f8fafc;
            --border-color:  #e2e8f0;
        }

        body {
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #eff6ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: var(--text-body);
        }

        .success-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 40px -15px rgba(37, 99, 235, 0.15), 0 0 1px 1px rgba(226, 232, 240, 0.8);
            max-width: 560px;
            width: 100%;
            padding: 40px 36px;
            text-align: center;
            position: relative;
        }

        .success-icon-badge {
            width: 76px;
            height: 76px;
            background: #dcfce7;
            border: 3px solid #bbf7d0;
            color: #16a34a;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin-bottom: 20px;
            box-shadow: 0 8px 20px -6px rgba(22, 163, 74, 0.3);
        }

        .success-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .success-desc {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .ticket-box {
            background: #f1f5f9;
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 18px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .ticket-info {
            text-align: left;
        }

        .ticket-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .ticket-code {
            font-size: 19px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 0.04em;
        }

        .btn-copy-ticket {
            padding: 8px 14px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            color: var(--text-dark);
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-copy-ticket:hover {
            background: #e2e8f0;
        }

        .detail-summary {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 16px 18px;
            text-align: left;
            margin-bottom: 28px;
            font-size: 13px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #edf2f7;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-k {
            color: var(--text-muted);
            font-weight: 600;
        }

        .detail-v {
            font-weight: 700;
            color: var(--text-dark);
        }

        .btn-action-primary {
            display: block;
            width: 100%;
            height: 48px;
            line-height: 48px;
            background: var(--primary);
            color: #ffffff;
            font-size: 14px;
            font-weight: 800;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 10px;
        }

        .btn-action-primary:hover {
            background: var(--primary-hover);
        }

        .btn-action-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            text-decoration: none;
            padding: 8px 14px;
        }

        .btn-action-secondary:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

    <div class="success-card">
        <div class="success-icon-badge">
            <i class="fa-solid fa-check"></i>
        </div>

        <h2 class="success-title">Laporan Berhasil Dikirim!</h2>
        <p class="success-desc">
            Terima kasih <strong>{{ $laporan->nama_pelapor }}</strong>, laporan Anda telah diterima oleh sistem dan diteruskan secara langsung ke Administrator Tata Usaha (TU).
        </p>

        <div class="ticket-box">
            <div class="ticket-info">
                <div class="ticket-label">Nomor Tiket Laporan Anda</div>
                <div class="ticket-code" id="ticketCodeText">{{ $laporan->ticket_code }}</div>
            </div>
            <button type="button" class="btn-copy-ticket" onclick="copyTicket()">
                <i class="fa-regular fa-copy" id="copyIcon"></i>
                <span id="copyBtnText">Salin Tiket</span>
            </button>
        </div>

        <div class="detail-summary">
            <div class="detail-row">
                <span class="detail-k">Role Pengguna</span>
                <span class="detail-v">{{ $laporan->role_label }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-k">Kategori Masalah</span>
                <span class="detail-v">{{ $laporan->kategori_kendala }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-k">Judul Laporan</span>
                <span class="detail-v">{{ $laporan->judul_laporan }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-k">Nomor WhatsApp</span>
                <span class="detail-v">{{ $laporan->no_wa }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-k">Waktu Lapor</span>
                <span class="detail-v">{{ $laporan->created_at->format('d/m/Y - H:i') }} WIB</span>
            </div>
        </div>

        <a href="{{ route('login') }}" class="btn-action-primary">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Login
        </a>

        <a href="{{ route('lapor.admin-tu') }}" class="btn-action-secondary">
            <i class="fa-solid fa-file-pen"></i> Buat Laporan Baru Lainnya
        </a>
    </div>

    <script>
        function copyTicket() {
            const ticket = document.getElementById('ticketCodeText').innerText;
            navigator.clipboard.writeText(ticket).then(() => {
                const btnText = document.getElementById('copyBtnText');
                const icon = document.getElementById('copyIcon');
                btnText.textContent = 'Tersalin!';
                icon.className = 'fa-solid fa-check';
                setTimeout(() => {
                    btnText.textContent = 'Salin Tiket';
                    icon.className = 'fa-regular fa-copy';
                }, 2000);
            });
        }
    </script>
</body>
</html>
