@extends('layouts.guru')

@section('title', 'Sampah Surat Izin Siswa — EDU JOURNAL')

@section('styles')
<style>
    .surat-trash-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-left h1 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0;
    }

    .header-left p {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
        margin-bottom: 0;
    }

    /* Form & Cards */
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
    }

    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
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
        transition: border-color 0.15s ease;
    }

    .filter-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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
        transition: all 0.15s ease;
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
        transition: all 0.15s ease;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #0f172a; }

    .btn-trash-pink {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .btn-trash-pink:hover { background: #fca5a5; color: #7f1d1d; }

    /* Student Cell */
    .student-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .student-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #64748b;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        flex-shrink: 0;
    }

    .student-info .name {
        font-weight: 700;
        font-size: 13.5px;
        color: #0f172a;
    }

    .student-info .sub {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 600;
    }

    /* Badges */
    .badge-kategori {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 800;
        text-transform: capitalize;
    }

    .badge-kategori.sakit {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .badge-kategori.izin {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .badge-kategori.dispen {
        background: #f3e8ff;
        color: #6d28d9;
        border: 1px solid #ddd6fe;
    }

    .durasi-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #e0e7ff;
        color: #3730a3;
        font-size: 11px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 12px;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        font-size: 13px;
    }

    .btn-action-icon.btn-restore { background: #d1fae5; color: #059669; }
    .btn-action-icon.btn-restore:hover { background: #a7f3d0; color: #047857; }
    .btn-action-icon.btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-action-icon.btn-delete:hover { background: #fca5a5; color: #991b1b; }
    .btn-action-icon.btn-preview { background: #f3e8ff; color: #7c3aed; }
    .btn-action-icon.btn-preview:hover { background: #ddd6fe; color: #6d28d9; }

    /* Custom Table Styling */
    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-custom th {
        background: #f8fafc;
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #cbd5e1;
    }

    .table-custom td {
        padding: 14px 16px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background: #f8fafc;
    }

    /* Lightbox Modal */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-box {
        background: #ffffff;
        border-radius: 20px;
        max-width: 600px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .modal-body {
        padding: 24px;
    }

    .btn-close-modal {
        background: #f1f5f9;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        cursor: pointer;
        font-size: 14px;
    }
    .btn-close-modal:hover { background: #e2e8f0; color: #0f172a; }
</style>
@endsection

@section('content')
<div class="surat-trash-container">
    
    <!-- Page Header -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1><i class="fa-solid fa-trash-can" style="color: #ef4444; margin-right: 8px;"></i>Sampah Surat Izin Siswa</h1>
            <p>Arsip data surat izin siswa yang telah dihapus sementara (Soft Delete). Anda dapat memulihkan kembali atau menghapusnya secara permanen.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('piket.surat-izin-siswa') }}" class="btn-filter-dark" style="padding: 10px 20px; font-size: 13px; border-radius: 10px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Utama
            </a>
            @if($suratIzinList->total() > 0)
                <form action="{{ route('piket.surat-izin-siswa.empty-trash') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGOSONGKAN SELURUH SAMPAH surat izin siswa? Data dan foto bukti akan terhapus permanen!');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-trash-pink" style="padding: 10px 20px; font-size: 13px; border-radius: 10px;">
                        <i class="fa-solid fa-dumpster"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Alert Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Main Card Container -->
    <div class="card-custom">
        <!-- Card Header Title -->
        <div class="card-custom-header">
            <div>
                <h2><i class="fa-solid fa-folder-minus" style="color: #ef4444; margin-right: 8px;"></i>Arsip Tempat Sampah Surat Izin Siswa</h2>
                <span style="font-size: 12px; color: #64748b; font-weight: 600;">Menampilkan data yang berada di tempat sampah</span>
            </div>
        </div>

        <!-- Filter Bar inside Trash -->
        <div class="filter-bar-container">
            <form action="{{ route('piket.surat-izin-siswa.trash') }}" method="GET" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; width: 100%;">
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari nama siswa / keterangan..." style="width: 260px;">

                <select name="id_kelas" class="filter-input">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter Sampah
                </button>

                @if(request()->hasAny(['q', 'id_kelas']))
                    <a href="{{ route('piket.surat-izin-siswa.trash') }}" class="btn-reset-light">
                        <i class="fa-solid fa-rotate-left"></i> Reset Filter
                    </a>
                @endif
            </form>
        </div>

        <!-- Trash Table -->
        <div style="overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>SISWA</th>
                        <th>KELAS</th>
                        <th style="width: 130px; text-align: center;">KATEGORI</th>
                        <th style="width: 170px;">TANGGAL &amp; RENTANG</th>
                        <th style="width: 80px; text-align: center;">DURASI</th>
                        <th>KETERANGAN / ALASAN</th>
                        <th style="width: 100px; text-align: center;">BUKTI FOTO</th>
                        <th style="width: 140px;">WAKTU DIHAPUS</th>
                        <th style="width: 120px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratIzinList as $index => $item)
                        @php
                            $namaSiswa = $item->siswa->nama_siswa ?? 'Siswa';
                            $namaKelas = $item->kelas->nama_kelas ?? '-';
                            $nameParts = explode(' ', trim($namaSiswa));
                            $initials  = count($nameParts) >= 2 
                                ? strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1))
                                : strtoupper(substr($namaSiswa, 0, 2));

                            $katClass = match($item->kategori) {
                                'Sakit' => 'sakit',
                                'Izin'  => 'izin',
                                default => 'dispen'
                            };

                            $tglMulaiFmt   = \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y');
                            $tglSelesaiFmt = $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : $tglMulaiFmt;
                            $rentangFmt    = ($tglMulaiFmt === $tglSelesaiFmt) ? $tglMulaiFmt : "{$tglMulaiFmt} s/d {$tglSelesaiFmt}";
                            $durasiText    = ($item->durasi_hari > 0 ? $item->durasi_hari : 1) . ' Hari';
                        @endphp
                        <tr>
                            <td style="font-weight: 700; color: #64748b;">
                                {{ $suratIzinList->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="student-cell">
                                    <div class="student-avatar">{{ $initials }}</div>
                                    <div class="student-info">
                                        <div class="name">{{ $namaSiswa }}</div>
                                        <div class="sub">NIS: {{ $item->siswa->nis ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-weight: 800; color: #384972;">{{ $namaKelas }}</td>
                            <td style="text-align: center;">
                                <span class="badge-kategori {{ $katClass }}">
                                    @if($item->kategori == 'Sakit')
                                        <i class="fa-solid fa-notes-medical"></i> Sakit
                                    @elseif($item->kategori == 'Izin')
                                        <i class="fa-solid fa-envelope"></i> Izin
                                    @else
                                        <i class="fa-solid fa-award"></i> Dispen Luar
                                    @endif
                                </span>
                            </td>
                            <td style="font-weight: 700; font-size: 12.5px;">{{ $rentangFmt }}</td>
                            <td style="text-align: center;">
                                <span class="durasi-pill">{{ $durasiText }}</span>
                            </td>
                            <td style="color: #475569; font-size: 12.5px;">{{ $item->keterangan ?? '-' }}</td>
                            <td style="text-align: center;">
                                @if($item->foto_url)
                                    <button type="button" class="btn-action-icon btn-preview" onclick="showFotoModal('{{ $item->foto_url }}', '{{ $namaSiswa }} - {{ $item->kategori }}')" title="Lihat Bukti Foto">
                                        <i class="fa-solid fa-image"></i>
                                    </button>
                                @else
                                    <span style="font-size: 11.5px; color: #94a3b8; font-style: italic;">Tanpa foto</span>
                                @endif
                            </td>
                            <td style="color: #ef4444; font-size: 12px; font-weight: 700;">
                                {{ $item->deleted_at ? $item->deleted_at->diffForHumans() : '-' }}
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <!-- Tombol Pulihkan -->
                                    <form action="{{ route('piket.surat-izin-siswa.restore', $item->id_surat_izin) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action-icon btn-restore" title="Pulihkan Surat Izin ke Daftar Utama">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </button>
                                    </form>

                                    <!-- Tombol Hapus Permanen -->
                                    <form action="{{ route('piket.surat-izin-siswa.force-delete', $item->id_surat_izin) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen data ini beserta foto buktinya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-icon btn-delete" title="Hapus Permanen">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fa-solid fa-trash-can-arrow-up" style="font-size: 32px; margin-bottom: 10px; display: block; color: #cbd5e1;"></i>
                                Tempat sampah kosong. Tidak ada data surat izin siswa yang dihapus.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratIzinList->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
                {{ $suratIzinList->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Preview Foto Bukti (Lightbox) -->
<div id="fotoModal" class="modal-overlay" onclick="closeFotoModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 id="modalFotoTitle">Bukti Surat / Dokumen Siswa</h3>
            <button type="button" class="btn-close-modal" onclick="closeFotoModalDirect()">&times;</button>
        </div>
        <div class="modal-body" style="text-align: center;">
            <img id="modalFotoImg" src="" alt="Bukti Surat Izin Siswa" style="max-width: 100%; max-height: 70vh; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        </div>
    </div>
</div>

<script>
    function showFotoModal(imgUrl, title) {
        document.getElementById('modalFotoImg').src = imgUrl;
        document.getElementById('modalFotoTitle').textContent = title;
        document.getElementById('fotoModal').classList.add('active');
    }

    function closeFotoModal(e) {
        if (e.target.id === 'fotoModal') closeFotoModalDirect();
    }

    function closeFotoModalDirect() {
        document.getElementById('fotoModal').classList.remove('active');
    }
</script>
@endsection
