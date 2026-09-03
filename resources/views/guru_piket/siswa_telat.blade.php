@extends('layouts.guru')

@section('title', 'Siswa Telat — EDU JOURNAL')

@section('styles')
<!-- Select2 CSS for Searchable Student & Guru Select -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .guru-izin-container {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    .dashboard-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
        width: 100%;
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

    .stat-grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .stat-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon-amber  { background: #fef3c7; color: #d97706; }
    .stat-icon-purple { background: #f3e8ff; color: #7e22ce; }
    .stat-icon-blue   { background: #dbeafe; color: #1d4ed8; }

    .stat-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #64748b;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
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
    }

    .card-custom-body {
        padding: 24px;
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

    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    textarea.form-control-custom {
        width: 100% !important;
        min-height: 75px;
        resize: vertical;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-family: inherit;
        font-size: 13px;
        color: #1e293b;
        box-sizing: border-box;
    }

    .form-control-custom:focus,
    textarea.form-control-custom:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

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
    }

    .btn-add-primary {
        background: #f59e0b;
        color: #ffffff;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
        transition: all 0.2s ease;
    }
    .btn-add-primary:hover {
        background: #d97706;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table-custom th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        text-align: left;
        padding: 12px 16px;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .table-custom td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .table-custom tr:hover {
        background-color: #f8fafc;
    }

    .badge-telat {
        background: #fef3c7;
        color: #b45309;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-system-ok {
        background: #d1fae5;
        color: #065f46;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .badge-wa-ok {
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none;
    }

    .btn-wa-action { background: #25d366; color: #ffffff; }
    .btn-wa-action:hover { background: #128c7e; color: #ffffff; }

    .btn-edit-action { background: #e0e7ff; color: #3730a3; }
    .btn-edit-action:hover { background: #c7d2fe; }

    .btn-delete-action { background: #fee2e2; color: #991b1b; }
    .btn-delete-action:hover { background: #fca5a5; }

    /* Modal Overlay & Card */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 20px;
    }

    .modal-card {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 650px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
    }

    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .student-preview-card {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 14px 18px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        font-size: 12.5px;
    }

    .student-preview-card div span {
        color: #64748b;
        font-weight: 600;
        display: block;
        font-size: 11px;
    }
    .student-preview-card div strong {
        color: #0f172a;
        font-weight: 800;
        font-size: 13px;
    }

    /* Select2 custom tweak */
    .select2-container--default .select2-selection--single {
        height: 42px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        padding: 6px 10px !important;
        background: #f8fafc !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        font-weight: 600 !important;
    }
</style>
@endsection

@section('content')
<div class="guru-izin-container">

    <!-- Page Header -->
    <div class="dashboard-page-header">
        <div class="header-left">
            <h1><i class="fa-solid fa-user-clock" style="color: #d97706; margin-right: 8px;"></i> Siswa Telat</h1>
            <p>Pendataan siswa terlambat & pengiriman pemberitahuan otomatis ke Guru Mengajar (Sistem Web & WhatsApp)</p>
        </div>
        <button type="button" class="btn-add-primary" onclick="openAddModal()">
            <i class="fa-solid fa-plus-circle"></i> Tambah Data Siswa Telat
        </button>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; font-weight: 700; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}
            </div>
            @if(session('wa_url'))
                <a href="{{ session('wa_url') }}" target="_blank" class="badge-wa-ok" style="font-size: 12px; padding: 6px 12px;">
                    <i class="fa-brands fa-whatsapp" style="font-size: 15px;"></i> Kirim WA Ke {{ session('guru_nama') }}
                </a>
            @endif
        </div>
    @endif

    @if($errors->any())
        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600;">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Stat Cards Grid -->
    <div class="stat-grid-3">
        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-amber">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <div class="stat-label">Terlambat Hari Ini</div>
                    <div class="stat-val">{{ $totalTelatToday }} Siswa</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-purple">
                    <i class="fa-solid fa-calendar-week"></i>
                </div>
                <div>
                    <div class="stat-label">Terlambat Bulan Ini</div>
                    <div class="stat-val">{{ $totalTelatBulanIni }} Siswa</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-left">
                <div class="stat-icon-wrapper stat-icon-blue">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div class="stat-label">Total Data Siswa</div>
                    <div class="stat-val">{{ $siswaList->count() }} Siswa</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card-custom">
        <!-- Filter Bar -->
        <div class="filter-bar-container">
            <form action="{{ route('piket.siswa-telat') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; width: 100%; align-items: center;">
                <input type="text" name="q" value="{{ request('q') }}" class="filter-input" placeholder="Cari Nama Siswa / NIS / Alasan..." style="flex: 1; min-width: 200px;">
                
                <select name="id_kelas" class="filter-input">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="filter-input" title="Filter Tanggal">

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                </button>

                <a href="{{ route('piket.siswa-telat') }}" class="btn-reset-light">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>

                <!-- Tombol Hapus Terpilih (Batch Delete) -->
                <button type="button" id="btnBatchDelete" class="btn-trash-pink" onclick="confirmBatchDelete()" style="opacity: 0.5; cursor: not-allowed;" disabled>
                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                </button>

                @php
                    $trashedCount = \App\Models\SiswaTelat::onlyTrashed()->count();
                @endphp
                <a href="{{ route('piket.siswa-telat.trash') }}" class="btn-trash-pink" style="margin-left: auto;">
                    <i class="fa-solid fa-trash-can"></i> Sampah ({{ $trashedCount }})
                </a>
            </form>
        </div>

        <!-- Form Tersembunyi untuk Batch Delete -->
        <form id="formBatchDelete" action="{{ route('piket.siswa-telat.destroy-batch') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
            <div id="batchDeleteInputsContainer"></div>
        </form>

        <div class="card-custom-body" style="padding: 0; overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckboxes" title="Pilih Semua (Select All)" style="width: 16px; height: 16px; cursor: pointer;">
                        </th>
                        <th style="width: 45px; text-align: center;">No</th>
                        <th>Waktu & Tanggal</th>
                        <th>Data Siswa (TU)</th>
                        <th>Guru Mengajar Target</th>
                        <th>Alasan & Hukuman Piket</th>
                        <th style="text-align: center;">Pemberitahuan</th>
                        <th style="text-align: center; width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($telatList as $index => $row)
                        @php
                            $siswaObj = $row->siswa;
                            $kelasObj = $row->kelas ?? ($siswaObj ? $siswaObj->kelas : null);
                            $guruObj  = $row->guruMengajar;

                            // Format WA Direct Link
                            $rawHp = preg_replace('/[^0-9]/', '', $guruObj->no_hp ?? '');
                            if (str_starts_with($rawHp, '0')) {
                                $rawHp = '62' . substr($rawHp, 1);
                            }

                            $waTextMsg = "*PEMBERITAHUAN SISWA TERLAMBAT (GURU PIKET)*\n\n"
                                . "Assalamu'alaikum / Selamat Pagi Bapak/Ibu Guru *".($guruObj->nama_guru ?? 'Guru')."*,\n\n"
                                . "Memberitahukan bahwa siswa dari kelas Bapak/Ibu terlambat hadir di sekolah:\n"
                                . "• *Nama Siswa*: ".($siswaObj->nama_siswa ?? '-')."\n"
                                . "• *NIS / NISN*: ".($siswaObj->nis ?? '-')." / ".($siswaObj->nisn ?? '-')."\n"
                                . "• *Kelas*: ".($kelasObj->nama_kelas ?? '-')."\n"
                                . "• *Jenis Kelamin*: ".($siswaObj ? $siswaObj->jenis_kelamin_teks : '-')."\n"
                                . "• *Jam Datang*: {$row->jam_terlambat} WIB\n"
                                . "• *Alasan*: {$row->alasan}\n"
                                . "• *Tindakan/Hukuman*: ".($row->tindakan_hukuman ?: 'Pengarahan & kedisiplinan Piket')."\n\n"
                                . "Siswa saat ini telah melapor ke Guru Piket dan diarahkan memasuki kelas. Notifikasi web sistem telah dikirimkan. Mohon Bapak/Ibu Guru Mengajar dapat menyesuaikan presensi siswa di kelas.\n\n"
                                . "Terima kasih.\n- Petugas Piket";

                            $waDirectUrl = !empty($rawHp) ? "https://api.whatsapp.com/send?phone={$rawHp}&text=" . urlencode($waTextMsg) : null;
                        @endphp
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" value="{{ $row->id_siswa_telat }}" class="item-checkbox" style="width: 16px; height: 16px; cursor: pointer;" onchange="updateBatchState()">
                            </td>
                            <td style="text-align: center; font-weight: 700; color: #64748b;">
                                {{ $telatList->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a;">
                                    <i class="fa-regular fa-calendar-check" style="color: #384972; margin-right: 4px;"></i>
                                    {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}
                                </div>
                                <div class="badge-telat" style="margin-top: 4px;">
                                    <i class="fa-solid fa-clock"></i> {{ $row->jam_terlambat }} WIB
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #0f172a; font-size: 14px;">
                                    {{ $siswaObj->nama_siswa ?? 'Siswa Terhapus' }}
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                    <span style="background: #e2e8f0; padding: 2px 6px; border-radius: 4px; font-weight: 700; color: #334155;">
                                        {{ $kelasObj->nama_kelas ?? 'Kelas -' }}
                                    </span>
                                    • NIS: {{ $siswaObj->nis ?? '-' }} / NISN: {{ $siswaObj->nisn ?? '-' }}
                                    • ({{ $siswaObj ? $siswaObj->jenis_kelamin_teks : '-' }})
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #1e293b;">
                                    <i class="fa-solid fa-user-tie" style="color: #475569; margin-right: 4px;"></i>
                                    {{ $guruObj->nama_guru ?? 'Guru Tidak Terpilih' }}
                                </div>
                                <div style="font-size: 11.5px; color: #64748b;">
                                    Mapel: {{ $guruObj->mapel->nama_mapel ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;">
                                    <i class="fa-solid fa-comment-dots" style="color: #f59e0b; margin-right: 4px;"></i>
                                    {{ $row->alasan }}
                                </div>
                                @if($row->tindakan_hukuman)
                                    <div style="font-size: 12px; color: #991b1b; background: #fff1f2; padding: 4px 8px; border-radius: 6px; margin-top: 4px; border: 1px solid #fecdd3;">
                                        <strong>Hukuman/Tindakan:</strong> {{ $row->tindakan_hukuman }}
                                    </div>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; flex-direction: column; gap: 4px; align-items: center;">
                                    <span class="badge-system-ok">
                                        <i class="fa-solid fa-globe"></i> Sistem Web OK
                                    </span>
                                    @if($waDirectUrl)
                                        <a href="{{ $waDirectUrl }}" target="_blank" class="badge-wa-ok" title="Klik untuk kirim pesan WA ke Guru">
                                            <i class="fa-brands fa-whatsapp"></i> Kirim WA
                                        </a>
                                    @else
                                        <span style="font-size: 10.5px; color: #94a3b8;">(No WA Guru Kosong)</span>
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    @if($waDirectUrl)
                                        <a href="{{ $waDirectUrl }}" target="_blank" class="btn-action-icon btn-wa-action" title="Kirim WA ke Guru">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    @endif

                                    <button type="button" class="btn-action-icon btn-edit-action" onclick='openEditModal(@json($row), @json($siswaObj), @json($kelasObj))' title="Edit Data">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <form action="{{ route('piket.siswa-telat.destroy', $row->id_siswa_telat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan data siswa telat ini ke Sampah?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-icon btn-delete-action" title="Hapus ke Sampah">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fa-solid fa-user-clock" style="font-size: 40px; margin-bottom: 12px; color: #cbd5e1; display: block;"></i>
                                <p style="font-weight: 700; font-size: 14px; margin: 0; color: #64748b;">Belum ada data siswa telat yang dicatat hari ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($telatList->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0;">
                {{ $telatList->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Tambah Siswa Telat -->
<div id="addSiswaTelatModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>
                <i class="fa-solid fa-user-clock" style="color: #f59e0b;"></i> Tambah & Kirim Pemberitahuan Siswa Telat
            </h3>
            <button type="button" onclick="closeAddModal()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form action="{{ route('piket.siswa-telat.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                
                <!-- 1. Pilih Siswa (Data Master TU) -->
                <div>
                    <label class="form-label-custom">Pilih Siswa (Data Master TU / Database) <span style="color: #ef4444;">*</span></label>
                    <select name="id_siswa" id="add_id_siswa" class="form-control-custom select2-siswa" style="width: 100%;" required onchange="onSiswaSelected(this.value)">
                        <option value="">-- Cari Nama Siswa / NIS / NISN / Kelas --</option>
                        @foreach($siswaList as $s)
                            <option value="{{ $s->id_siswa }}">
                                {{ $s->nama_siswa }} — Kelas {{ $s->kelas->nama_kelas ?? '-' }} (NIS: {{ $s->nis ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Preview Identitas Siswa -->
                <div id="studentPreviewContainer" class="student-preview-card" style="display: none;">
                    <div>
                        <span>Nama Lengkap Siswa:</span>
                        <strong id="prev_nama_siswa">-</strong>
                    </div>
                    <div>
                        <span>Kelas Siswa:</span>
                        <strong id="prev_kelas_siswa" style="color: #2563eb;">-</strong>
                    </div>
                    <div>
                        <span>NIS / NISN:</span>
                        <strong id="prev_nis_siswa">-</strong>
                    </div>
                    <div>
                        <span>Jenis Kelamin:</span>
                        <strong id="prev_jk_siswa">-</strong>
                    </div>
                </div>

                <!-- 2. Pilih Guru Mengajar saat Jam Pelajaran -->
                <div>
                    <label class="form-label-custom">
                        Guru Mengajar di Kelas Saat Ini (Target Pemberitahuan) <span style="color: #ef4444;">*</span>
                    </label>
                    <div style="font-size: 11.5px; color: #64748b; margin-bottom: 6px;" id="scheduleHelpText">
                        Pemberitahuan akan masuk ke Halaman Pengumuman Guru Mengajar tersebut & pesan WhatsApp.
                    </div>
                    <input type="hidden" name="id_jadwal" id="add_id_jadwal" value="">
                    <select name="id_guru_mengajar" id="add_id_guru_mengajar" class="form-control-custom select2-guru" style="width: 100%;" required>
                        <option value="">-- Pilih Guru Mengajar (Cari Nama / NIP) --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">
                                {{ $g->nama_guru }} (NIP: {{ $g->nip ?: '-' }}) — {{ $g->mapel->nama_mapel ?? 'Guru Pengampu' }} (No WA: {{ $g->no_hp ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label class="form-label-custom">Tanggal Keterlambatan <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="tanggal" id="add_tanggal" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->toDateString() }}" class="form-control-custom" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Jam Kedatangan / Terlambat <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="jam_terlambat" value="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }}" class="form-control-custom" placeholder="Contoh: 07:25" required>
                    </div>
                </div>

                <div>
                    <label class="form-label-custom">Alasan Keterlambatan Siswa <span style="color: #ef4444;">*</span></label>
                    <textarea name="alasan" rows="2" class="form-control-custom" placeholder="Contoh: Ban sepeda motor bocor di jalan, bangun kesiangan..." required></textarea>
                </div>

                <div>
                    <label class="form-label-custom">Tindakan / Hukuman Piket (Opsional)</label>
                    <textarea name="tindakan_hukuman" rows="2" class="form-control-custom" placeholder="Contoh: Membersihkan halaman sekolah & lari keliling lapangan 2 kali..."></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeAddModal()" class="btn-reset-light">Batal</button>
                <button type="submit" class="btn-add-primary">
                    <i class="fa-solid fa-paper-plane"></i> Simpan & Kirim Pemberitahuan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Siswa Telat -->
<div id="editSiswaTelatModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>
                <i class="fa-solid fa-pen-to-square" style="color: #3b82f6;"></i> Edit Data Siswa Telat
            </h3>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form id="editFormSiswaTelat" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                
                <div class="student-preview-card" style="display: grid;">
                    <div>
                        <span>Nama Siswa:</span>
                        <strong id="edit_nama_siswa">-</strong>
                    </div>
                    <div>
                        <span>Kelas:</span>
                        <strong id="edit_kelas_siswa" style="color: #2563eb;">-</strong>
                    </div>
                </div>

                <div>
                    <label class="form-label-custom">Guru Mengajar Target <span style="color: #ef4444;">*</span></label>
                    <select name="id_guru_mengajar" id="edit_id_guru_mengajar" class="form-control-custom select2-guru-edit" style="width: 100%;" required>
                        <option value="">-- Pilih Guru Mengajar (Cari Nama / NIP) --</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id_guru }}">
                                {{ $g->nama_guru }} (NIP: {{ $g->nip ?: '-' }}) — {{ $g->mapel->nama_mapel ?? 'Guru Pengampu' }} (No WA: {{ $g->no_hp ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label class="form-label-custom">Tanggal Keterlambatan <span style="color: #ef4444;">*</span></label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control-custom" required>
                    </div>
                    <div>
                        <label class="form-label-custom">Jam Terlambat <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="jam_terlambat" id="edit_jam_terlambat" class="form-control-custom" required>
                    </div>
                </div>

                <div>
                    <label class="form-label-custom">Alasan Terlambat <span style="color: #ef4444;">*</span></label>
                    <textarea name="alasan" id="edit_alasan" rows="2" class="form-control-custom" required></textarea>
                </div>

                <div>
                    <label class="form-label-custom">Tindakan / Hukuman Piket</label>
                    <textarea name="tindakan_hukuman" id="edit_tindakan_hukuman" rows="2" class="form-control-custom"></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" onclick="closeEditModal()" class="btn-reset-light">Batal</button>
                <button type="submit" class="btn-filter-dark" style="background: #2563eb;">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2-siswa').select2({
            dropdownParent: $('#addSiswaTelatModal'),
            placeholder: '-- Cari Nama Siswa / NIS / Kelas --'
        });

        $('.select2-guru').select2({
            dropdownParent: $('#addSiswaTelatModal'),
            placeholder: '-- Pilih Guru Mengajar (Cari Nama / NIP) --'
        });

        $('.select2-guru-edit').select2({
            dropdownParent: $('#editSiswaTelatModal'),
            placeholder: '-- Pilih Guru Mengajar (Cari Nama / NIP) --'
        });

        $('#selectAllCheckboxes').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.item-checkbox').prop('checked', isChecked);
            updateBatchState();
        });

        $('#add_tanggal, input[name="jam_terlambat"]').on('change keyup', function() {
            const idSiswa = $('#add_id_siswa').val();
            if (idSiswa) {
                triggerScheduleLookup(idSiswa);
            }
        });

        @if(session('wa_url'))
            // Auto open WhatsApp direct URL link if flash session present
            window.open("{{ session('wa_url') }}", "_blank");
        @endif
    });

    function updateBatchState() {
        const checkedItems = $('.item-checkbox:checked');
        const count = checkedItems.length;
        const totalItems = $('.item-checkbox').length;

        $('#selectedCount').text(count);

        if (totalItems > 0 && count === totalItems) {
            $('#selectAllCheckboxes').prop('checked', true);
        } else {
            $('#selectAllCheckboxes').prop('checked', false);
        }

        const btn = $('#btnBatchDelete');
        if (count > 0) {
            btn.prop('disabled', false)
               .css({ opacity: 1, cursor: 'pointer', background: '#fee2e2', color: '#991b1b', border: '1px solid #fca5a5' });
        } else {
            btn.prop('disabled', true)
               .css({ opacity: 0.5, cursor: 'not-allowed' });
        }
    }

    function confirmBatchDelete() {
        const checkedItems = $('.item-checkbox:checked');
        const count = checkedItems.length;

        if (count === 0) {
            alert('Silakan centang minimal satu data siswa telat yang ingin dihapus.');
            return;
        }

        if (confirm('Apakah Anda yakin ingin memindahkan ' + count + ' data siswa telat terpilih ke Sampah?')) {
            const container = $('#batchDeleteInputsContainer');
            container.empty();
            checkedItems.each(function() {
                container.append('<input type="hidden" name="ids[]" value="' + $(this).val() + '">');
            });
            $('#formBatchDelete').submit();
        }
    }

    function openAddModal() {
        document.getElementById('addSiswaTelatModal').style.display = 'flex';
    }

    function closeAddModal() {
        document.getElementById('addSiswaTelatModal').style.display = 'none';
    }

    function openEditModal(row, siswa, kelas) {
        document.getElementById('editFormSiswaTelat').action = "/guru-piket/siswa-telat/" + row.id_siswa_telat;
        document.getElementById('edit_nama_siswa').innerText = siswa ? siswa.nama_siswa : '-';
        document.getElementById('edit_kelas_siswa').innerText = kelas ? kelas.nama_kelas : '-';
        $('#edit_id_guru_mengajar').val(row.id_guru_mengajar).trigger('change');
        document.getElementById('edit_tanggal').value = row.tanggal ? row.tanggal.substring(0, 10) : '';
        document.getElementById('edit_jam_terlambat').value = row.jam_terlambat;
        document.getElementById('edit_alasan').value = row.alasan;
        document.getElementById('edit_tindakan_hukuman').value = row.tindakan_hukuman || '';
        document.getElementById('editSiswaTelatModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editSiswaTelatModal').style.display = 'none';
    }

    function onSiswaSelected(idSiswa) {
        triggerScheduleLookup(idSiswa);
    }

    // AJAX helper to lookup schedule based on student ID, selected date, and time
    function triggerScheduleLookup(idSiswa) {
        if (!idSiswa) {
            document.getElementById('studentPreviewContainer').style.display = 'none';
            return;
        }

        const tgl = document.getElementById('add_tanggal') ? document.getElementById('add_tanggal').value : '';
        const jam = document.querySelector('#addSiswaTelatModal input[name="jam_terlambat"]') ? document.querySelector('#addSiswaTelatModal input[name="jam_terlambat"]').value : '';

        const url = "/guru-piket/api/siswa-schedule-guru/" + idSiswa + "?tanggal=" + encodeURIComponent(tgl) + "&jam_terlambat=" + encodeURIComponent(jam);

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const s = data.siswa;
                    const k = data.kelas;
                    const matchedJadwal = data.matched_jadwal;

                    document.getElementById('prev_nama_siswa').innerText = s.nama_siswa || '-';
                    document.getElementById('prev_kelas_siswa').innerText = k ? k.nama_kelas : '-';
                    document.getElementById('prev_nis_siswa').innerText = (s.nis || '-') + " / " + (s.nisn || '-');
                    const jkTeks = s.jenis_kelamin_teks ? s.jenis_kelamin_teks : (s.jenis_kelamin === 'L' ? 'Laki-laki' : (s.jenis_kelamin === 'P' ? 'Perempuan' : '-'));
                    document.getElementById('prev_jk_siswa').innerText = jkTeks;
                    document.getElementById('studentPreviewContainer').style.display = 'grid';

                    // Auto-select Guru Mengajar matched by date and time & set id_jadwal
                    if (data.matched_guru_id) {
                        $('#add_id_guru_mengajar').val(data.matched_guru_id).trigger('change');
                    }

                    if (matchedJadwal && matchedJadwal.id_jadwal) {
                        document.getElementById('add_id_jadwal').value = matchedJadwal.id_jadwal;
                    } else {
                        document.getElementById('add_id_jadwal').value = '';
                    }

                    // Display informative schedule status badge
                    if (matchedJadwal) {
                        const gNama = matchedJadwal.guru ? matchedJadwal.guru.nama_guru : 'Guru';
                        const gNip  = matchedJadwal.guru && matchedJadwal.guru.nip ? matchedJadwal.guru.nip : '-';
                        const mMapel = matchedJadwal.mapel ? matchedJadwal.mapel.nama_mapel : 'Pelajaran';
                        const jRange = matchedJadwal.jam_range_formatted ? matchedJadwal.jam_range_formatted : '';

                        if (data.is_exact_time_match) {
                            document.getElementById('scheduleHelpText').innerHTML = 
                                `<span style="color: #059669; font-weight: 700;"><i class="fa-solid fa-circle-check"></i> Jadwal Pelajaran Ditemukan (${data.hari_indo}, Waktu ${data.jam_input} WIB): <strong>${gNama}</strong> (NIP: ${gNip}) — Mapel ${mMapel} [${jRange}]</span>`;
                        } else {
                            document.getElementById('scheduleHelpText').innerHTML = 
                                `<span style="color: #d97706; font-weight: 700;"><i class="fa-solid fa-circle-info"></i> Jadwal Pelajaran (${data.hari_indo}): <strong>${gNama}</strong> (NIP: ${gNip}) — Mapel ${mMapel} [${jRange}]</span>`;
                        }
                    } else {
                        document.getElementById('scheduleHelpText').innerHTML = 
                            `<span style="color: #64748b; font-weight: 600;"><i class="fa-solid fa-circle-exclamation"></i> Tidak ada jadwal pelajaran di kelas siswa pada ${data.hari_indo}. Silakan pilih Guru Mengajar secara manual.</span>`;
                    }
                }
            })
            .catch(err => console.error("Error fetching student schedule:", err));
    }
</script>
@endsection
