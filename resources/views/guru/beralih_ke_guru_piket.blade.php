@extends('layouts.guru')

@section('title', 'Beralih ke Guru Piket — EDU JOURNAL')
@section('header_title', 'Beralih ke Guru Piket')

@section('styles')
<style>
    .breadcrumb-text {
        font-size: 14px;
        color: #475569;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .breadcrumb-text span {
        color: #0f172a;
        font-weight: 800;
    }

    .card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #cbd5e1;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }

    .card-top-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .card-top-header h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-top-header p {
        font-size: 13px;
        color: #64748b;
    }

    /* Filter & Reset Buttons */
    .btn-filter {
        background: #3b5490;
        color: #ffffff;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(59, 84, 144, 0.2);
    }
    .btn-filter:hover {
        background: #2e4375;
        color: #ffffff;
    }

    .btn-reset {
        background: #fbbf24;
        color: #78350f;
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(251, 191, 36, 0.2);
    }
    .btn-reset:hover {
        background: #f59e0b;
        color: #78350f;
    }

    /* Tombol Keluar (Logout) */
    .btn-logout-custom {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.15);
    }
    .btn-logout-custom:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
    }

    /* Table Custom */
    .table-responsive {
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom th {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        padding: 14px 16px;
        text-align: left;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tr:hover td {
        background: #f8fafc;
    }

    .badge-jk {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-block;
    }
    .badge-jk-l {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }
    .badge-jk-p {
        background: #fce7f3;
        color: #be185d;
        border: 1px solid #fbcfe8;
    }

    /* Highlighting Badge NIP & Password */
    .nip-highlight-box {
        font-family: monospace;
        font-size: 14px;
        font-weight: 800;
        color: #1e40af;
        background: #eff6ff;
        padding: 6px 12px;
        border-radius: 9px;
        border: 1px solid #bfdbfe;
        display: inline-block;
        box-shadow: 0 1px 3px rgba(30, 64, 175, 0.08);
    }

    .password-highlight-box {
        font-family: monospace;
        font-size: 14px;
        font-weight: 800;
        color: #92400e;
        background: #fffbe6;
        padding: 6px 14px;
        border-radius: 9px;
        border: 1.5px solid #fcd34d;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        box-shadow: 0 1px 4px rgba(217, 119, 6, 0.12);
    }

    /* Copy Buttons */
    .copy-buttons-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-copy-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-copy-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-copy-nip {
        background: #e0f2fe;
        color: #0284c7;
        border-color: #bae6fd;
    }
    .btn-copy-nip:hover {
        background: #0284c7;
        color: #ffffff;
    }
    .btn-copy-password {
        background: #fef3c7;
        color: #d97706;
        border-color: #fde68a;
    }
    .btn-copy-password:hover {
        background: #d97706;
        color: #ffffff;
    }
    .btn-copy-both {
        background: #d1fae5;
        color: #059669;
        border-color: #a7f3d0;
    }
    .btn-copy-both:hover {
        background: #059669;
        color: #ffffff;
    }

    /* Toast Alert Notification */
    #toastNotification {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #0f172a;
        color: #ffffff;
        padding: 14px 22px;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13.5px;
        font-weight: 700;
        z-index: 9999;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
    }
    #toastNotification.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
    #toastNotification i {
        font-size: 18px;
        color: #34d399;
    }
</style>
@endsection

@section('content')
<div class="content-body">
    <!-- Breadcrumb Navigasi -->
    <div class="breadcrumb-text">
        <i class="fa-solid fa-house"></i>
        <span>Portal Guru</span>
        <i class="fa-solid fa-chevron-right" style="font-size:10px; color:#94a3b8;"></i>
        <span>Beralih ke Guru Piket</span>
    </div>

    <!-- Header Halaman & Logout Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin-bottom:4px; display:flex; align-items:center; gap:12px;">
                <i class="fa-solid fa-right-left" style="color:#2563eb;"></i> Beralih ke Guru Piket
            </h1>
            <p style="font-size:13.5px; color:#64748b; font-weight:600; margin:0;">
                Kelola seluruh akun petugas piket yang aktif di sistem beserta informasi login.
            </p>
        </div>

        <!-- Tombol Keluar (Log Out) -->
        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="btn-logout-custom" title="Keluar dari akun yang sedang digunakan saat ini" onclick="return confirm('Apakah Anda yakin ingin keluar / log out dari akun ini?')">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar (Log Out)
            </button>
        </form>
    </div>

    <!-- Card: Daftar Data Guru Piket -->
    <div class="card">
        <div class="card-top-header">
            <div>
                <h2>
                    <i class="fa-solid fa-users" style="color:#3b5490;"></i> 
                    Daftar Petugas Piket Terdaftar ({{ count($guruPikets) }})
                </h2>
                <p>Kelola seluruh akun petugas piket yang aktif di sistem.</p>
            </div>

            <!-- Form Filter Search -->
            <form action="{{ route('guru.beralih-ke-guru-piket') }}" method="GET" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" name="search" value="{{ $search }}" class="form-control" style="width:260px; padding:9px 14px 9px 36px; border-radius:12px; border:1.5px solid #cbd5e1; font-size:13px;" placeholder="Cari nama / NIP / username...">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                </div>
                <button type="submit" class="btn-filter">Cari</button>
                <a href="{{ route('guru.beralih-ke-guru-piket') }}" class="btn-reset">Reset</a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width:50px;">NO</th>
                        <th>NAMA PETUGAS PIKET</th>
                        <th>NIP / USERNAME</th>
                        <th>PASSWORD AKUN</th>
                        <th>JK</th>
                        <th>NO HP</th>
                        <th>STATUS VERIFIKASI</th>
                        <th style="text-align:center; min-width:300px;">FITUR SALIN AKUN OTOMATIS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruPikets as $index => $u)
                        @php
                            $nipVal  = $u->nip ?? '199003032015031003';
                            $passVal = $u->display_password;
                            $comboVal = "NIP = ( {$nipVal} ) & Password = ( {$passVal} )";
                        @endphp
                        <tr>
                            <td><strong>{{ $index + 1 }}</strong></td>
                            <td>
                                <strong>{{ $u->name }}</strong>
                                <div style="font-size:12px; color:#64748b; margin-top:2px;">Role: Petugas Piket</div>
                            </td>
                            <td>
                                <div class="nip-highlight-box">{{ $nipVal }}</div>
                                <div style="font-size:12px; color:#64748b; margin-top:4px;">User: {{ $u->username ?? 'piket' }}</div>
                            </td>
                            <td>
                                <div class="password-highlight-box" title="Password akun Guru Piket">
                                    <i class="fa-solid fa-key" style="color:#d97706;"></i>
                                    <span>{{ $passVal }}</span>
                                </div>
                            </td>
                            <td>
                                @if(optional($u->guru)->jenis_kelamin == 'L' || $u->jenis_kelamin == 'L')
                                    <span class="badge-jk badge-jk-l">Laki-laki</span>
                                @elseif(optional($u->guru)->jenis_kelamin == 'P' || $u->jenis_kelamin == 'P')
                                    <span class="badge-jk badge-jk-p">Perempuan</span>
                                @else
                                    <span class="badge-jk badge-jk-l">Laki-laki</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight:600;">{{ optional($u->guru)->no_hp ?? ($u->no_hp ?? '085730241761') }}</div>
                            </td>
                            <td>
                                @if($u->status_verifikasi === 'verified')
                                    <span style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; display:inline-flex; align-items:center; gap:5px;">
                                        <i class="fa-solid fa-circle-check"></i> Terverifikasi
                                    </span>
                                @else
                                    <span style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; display:inline-flex; align-items:center; gap:5px;">
                                        <i class="fa-solid fa-clock"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <div class="copy-buttons-container">
                                    <!-- Tombol Salin NIP -->
                                    <button type="button" class="btn-copy-action btn-copy-nip" onclick="copyToClipboard('{{ $nipVal }}', 'NIP ({{ $nipVal }})')" title="Klik untuk salin NIP saja secara otomatis">
                                        <i class="fa-solid fa-copy"></i> Salin NIP
                                    </button>

                                    <!-- Tombol Salin Password -->
                                    <button type="button" class="btn-copy-action btn-copy-password" onclick="copyToClipboard('{{ $passVal }}', 'Password ({{ $passVal }})')" title="Klik untuk salin Password saja secara otomatis">
                                        <i class="fa-solid fa-key"></i> Salin Password
                                    </button>

                                    <!-- Tombol Salin NIP + Password Sekaligus -->
                                    <button type="button" class="btn-copy-action btn-copy-both" onclick="copyToClipboard('{{ $comboVal }}', 'NIP & Password Sekaligus')" title="Klik untuk salin NIP dan Password sekaligus secara otomatis">
                                        <i class="fa-solid fa-paste"></i> Salin NIP + Password
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:40px; color:#64748b;">
                                <i class="fa-solid fa-folder-open" style="font-size:40px; color:#cbd5e1; margin-bottom:12px; display:block;"></i>
                                Data akun Guru Piket tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Toast Popup Notification -->
<div id="toastNotification">
    <i class="fa-solid fa-circle-check"></i>
    <span id="toastMessage">Teks berhasil disalin ke clipboard!</span>
</div>
@endsection

@section('scripts')
<script>
    /**
     * Fitur Salin Otomatis ke Clipboard 1-Klik dengan Fallback
     */
    function copyToClipboard(text, label) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function() {
                showToast(label + ' Berhasil Disalin!');
            }).catch(function(err) {
                fallbackCopy(text, label);
            });
        } else {
            fallbackCopy(text, label);
        }
    }

    function fallbackCopy(text, label) {
        const tempInput = document.createElement('textarea');
        tempInput.value = text;
        tempInput.style.position = 'fixed';
        tempInput.style.opacity = '0';
        document.body.appendChild(tempInput);
        tempInput.focus();
        tempInput.select();
        try {
            document.execCommand('copy');
            showToast(label + ' Berhasil Disalin!');
        } catch (err) {
            alert('Gagal menyalin secara otomatis. Silakan salin secara manual.');
        }
        document.body.removeChild(tempInput);
    }

    /**
     * Tampilkan Toast Notification Animated
     */
    let toastTimeout;
    function showToast(message) {
        const toast = document.getElementById('toastNotification');
        const msgSpan = document.getElementById('toastMessage');
        msgSpan.innerText = message;

        toast.classList.add('show');

        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
</script>
@endsection
