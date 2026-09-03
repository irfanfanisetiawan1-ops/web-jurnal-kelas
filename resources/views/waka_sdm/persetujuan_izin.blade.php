@extends('layouts.waka_sdm')

@section('title', 'Persetujuan Izin Guru — Waka SDM')
@section('page-header', 'Persetujuan Izin Guru & SDM')
@section('page-subheader', 'Kelola persetujuan izin tidak masuk / cuti / tugas dinas pendidik dan tenaga kependidikan')

@section('styles')
<style>
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 22px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    .filter-form {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .form-input-sm {
        padding: 9px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
        font-family: inherit;
        color: #0f172a;
        background: #ffffff;
        outline: none;
    }

    .form-input-sm:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .tab-item {
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .tab-item:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .tab-item.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    .card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 14px 16px;
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }

    .custom-table td {
        padding: 16px;
        font-size: 13.5px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }

    .badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        display: inline-block;
    }

    .badge-pending { background: #fef3c7; color: #b45309; }
    .badge-approved { background: #dcfce7; color: #15803d; }
    .badge-rejected { background: #fee2e2; color: #b91c1c; }

    .btn-action {
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-approve { background: #16a34a; color: #ffffff; }
    .btn-approve:hover { background: #15803d; }

    .btn-reject { background: #dc2626; color: #ffffff; }
    .btn-reject:hover { background: #b91c1c; }

    .pagination-wrapper {
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<!-- Search & Filter Card -->
<div class="filter-card">
    <form action="{{ route('waka-sdm.persetujuan-izin') }}" method="GET" class="filter-form">
        <input type="hidden" name="status" value="{{ $filterStatus }}">

        <div class="filter-group">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama guru, NIP, atau alasan..." class="form-input-sm" style="width: 260px;">

            <select name="kategori" class="form-input-sm">
                <option value="all" {{ $kategori === 'all' || !$kategori ? 'selected' : '' }}>-- Semua Kategori Izin --</option>
                <option value="biasa" {{ $kategori === 'biasa' ? 'selected' : '' }}>Biasa</option>
                <option value="cuti" {{ $kategori === 'cuti' ? 'selected' : '' }}>Cuti / Izin Khusus</option>
                <option value="dinas" {{ $kategori === 'dinas' ? 'selected' : '' }}>Tugas Dinas</option>
                <option value="sakit" {{ $kategori === 'sakit' ? 'selected' : '' }}>Sakit</option>
            </select>

            <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-input-sm" title="Filter Tanggal Izin">

            <button type="submit" class="btn-action" style="background: #2563eb; color: #ffffff;">
                <i class="fa-solid fa-magnifying-glass"></i> Cari & Filter
            </button>

            @if($search || ($kategori && $kategori !== 'all') || $tanggal)
                <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => $filterStatus]) }}" class="btn-action" style="background: #64748b; color: #ffffff;" title="Reset Pencarian & Filter">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </a>
            @endif
        </div>

        <div class="filter-group">
            <button type="button" id="btnBatchDelete" onclick="submitBatchDelete()" class="btn-action btn-reject" disabled style="opacity: 0.6; cursor: not-allowed;">
                <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
            </button>

            <a href="{{ route('waka-sdm.izin.trash') }}" class="btn-action" style="background: #ea580c; color: #ffffff;" title="Lihat Fitur Sampah">
                <i class="fa-solid fa-trash-arrow-up"></i> Fitur Sampah ({{ $trashedCount }})
            </a>
        </div>
    </form>
</div>

<!-- Filter Status Tabs -->
<div class="filter-tabs">
    <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => 'all', 'search' => $search, 'kategori' => $kategori, 'tanggal' => $tanggal]) }}" class="tab-item {{ $filterStatus === 'all' ? 'active' : '' }}">
        <i class="fa-solid fa-list"></i> Semua Pengajuan
    </a>
    <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => 'pending', 'search' => $search, 'kategori' => $kategori, 'tanggal' => $tanggal]) }}" class="tab-item {{ $filterStatus === 'pending' ? 'active' : '' }}">
        <i class="fa-solid fa-clock"></i> Menunggu Waka SDM ({{ $countPending }})
    </a>
    <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => 'approved', 'search' => $search, 'kategori' => $kategori, 'tanggal' => $tanggal]) }}" class="tab-item {{ $filterStatus === 'approved' ? 'active' : '' }}">
        <i class="fa-solid fa-circle-check"></i> Disetujui ({{ $countApproved }})
    </a>
    <a href="{{ route('waka-sdm.persetujuan-izin', ['status' => 'rejected', 'search' => $search, 'kategori' => $kategori, 'tanggal' => $tanggal]) }}" class="tab-item {{ $filterStatus === 'rejected' ? 'active' : '' }}">
        <i class="fa-solid fa-circle-xmark"></i> Ditolak ({{ $countRejected }})
    </a>
</div>

<div class="card">
    <form id="formBatchDelete" action="{{ route('waka-sdm.izin.batch-delete') }}" method="POST">
        @csrf
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckboxes" onclick="toggleSelectAll(this)" style="cursor: pointer; width: 16px; height: 16px;" title="Pilih Semua Data">
                        </th>
                        <th>No</th>
                        <th>Nama Pendidik / NIP</th>
                        <th>Tanggal Izin</th>
                        <th>Alasan & Keterangan</th>
                        <th>Status Waka Kur</th>
                        <th>Status Waka SDM</th>
                        <th>Status Kepsek</th>
                        <th>Status Final</th>
                        <th>Aksi Waka SDM</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftarIzin as $index => $izin)
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" name="ids[]" value="{{ $izin->id_guru_izin }}" class="cb-izin-item" onchange="updateBatchDeleteButton()" style="cursor: pointer; width: 16px; height: 16px;">
                            </td>
                            <td>{{ $daftarIzin->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $izin->guru->nama_guru ?? 'Guru' }}</strong>
                                <div style="font-size: 11px; color: #64748b;">NIP: {{ $izin->guru->nip ?? '-' }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 700;">{{ $izin->tanggal_formatted }}</div>
                                <span style="font-size: 11px; color: #64748b;">{{ $izin->durasi_formatted }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #2563eb;">{{ $izin->kategori_izin ?? 'Izin' }}</div>
                                <div style="font-size: 12.5px;">{{ $izin->alasan }}</div>
                                @if($izin->materi_dititipkan)
                                    <div style="font-size: 11px; color: #475569; margin-top: 4px;">
                                        <i class="fa-solid fa-book"></i> Materi: {{ $izin->materi_dititipkan }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($izin->status_waka === 'approved')
                                    <span class="badge badge-approved">Disetujui</span>
                                @elseif($izin->status_waka === 'rejected')
                                    <span class="badge badge-rejected">Ditolak</span>
                                @else
                                    <span class="badge badge-pending">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if($izin->status_waka_sdm === 'approved')
                                    <span class="badge badge-approved">Disetujui</span>
                                @elseif($izin->status_waka_sdm === 'rejected')
                                    <span class="badge badge-rejected">Ditolak</span>
                                @else
                                    <span class="badge badge-pending">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if($izin->status_kepsek === 'approved')
                                    <span class="badge badge-approved">Disetujui</span>
                                @elseif($izin->status_kepsek === 'rejected')
                                    <span class="badge badge-rejected">Ditolak</span>
                                @else
                                    <span class="badge badge-pending">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if($izin->status_final === 'approved')
                                    <span class="badge badge-approved">Disetujui Resmi</span>
                                @elseif($izin->status_final === 'rejected')
                                    <span class="badge badge-rejected">Ditolak</span>
                                @else
                                    <span class="badge badge-pending">Dalam Proses</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $sdmGiDetailData = [
                                        'nama_guru' => $izin->guru->nama_guru ?? 'Guru Tidak Ditemukan',
                                        'nip' => $izin->guru->nip ?? '-',
                                        'tanggal' => ($izin->tanggal_mulai === $izin->tanggal_selesai || !$izin->tanggal_selesai) ? \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d-m-Y') : \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d-m-Y'),
                                        'durasi' => $izin->durasi ?? '1 Hari Full',
                                        'kategori_izin' => $izin->kategori_izin ?? 'biasa',
                                        'alasan' => $izin->alasan ?? '-',
                                        'keterangan_khusus' => $izin->keterangan_khusus ?? '-',
                                        'materi' => $izin->materi_dititipkan ?? '-',
                                        'foto_url' => $izin->foto_surat ? asset('uploads/guru_izin/' . $izin->foto_surat) : null,
                                        'status_waka' => ucfirst($izin->status_waka ?? 'pending'),
                                        'status_waka_sdm' => ucfirst($izin->status_waka_sdm ?? 'pending'),
                                        'status_kepsek' => ucfirst($izin->status_kepsek ?? 'pending'),
                                        'status_final' => ucfirst($izin->status_final ?? 'pending'),
                                        'catatan_waka' => $izin->catatan_waka ?? '-',
                                        'catatan_kepsek' => $izin->catatan_kepsek ?? '-',
                                    ];
                                @endphp
                                <div style="display: flex; gap: 4px; align-items: center; flex-wrap: wrap;">
                                    <button type="button" class="btn-action" style="background:#475569; color:white;" onclick='openGuruIzinDetailModal(@json($sdmGiDetailData))' title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>
                                    @if($izin->status_waka_sdm === 'pending')
                                        <form action="{{ route('waka-sdm.izin.approve', $izin->id_guru_izin) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-approve" onclick="return confirm('Setujui pengajuan izin guru ini?')" title="Setujui Izin">
                                                <i class="fa-solid fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('waka-sdm.izin.reject', $izin->id_guru_izin) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-reject" onclick="return confirm('Tolak pengajuan izin guru ini?')" title="Tolak Izin">
                                                <i class="fa-solid fa-xmark"></i> Tolak
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Single Delete (Soft Delete) -->
                                    <form action="{{ route('waka-sdm.izin.destroy', $izin->id_guru_izin) }}" method="POST" style="display:inline;" onsubmit="return confirm('Pindahkan data izin guru {{ $izin->guru->nama_guru ?? '' }} ke Sampah (Soft Delete)?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action" style="background: #ef4444; color: #ffffff;" title="Hapus ke Sampah">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; color: #94a3b8; padding: 40px;">
                                <i class="fa-solid fa-inbox" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                Tidak ada data pengajuan izin guru untuk kriteria filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    @if($daftarIzin->hasPages())
        {{ $daftarIzin->links('partials.custom-pagination') }}
    @endif
</div>

<!-- Modal Detail Izin Guru -->
<div id="modalDetailGuruIzin" class="waka-modal-backdrop">
    <div class="waka-modal-card">
        <div class="waka-modal-header" style="background: #2563eb;">
            <h3><i class="fa-solid fa-file-signature"></i> Detail Permohonan Izin Guru & SDM</h3>
            <button type="button" onclick="closeGuruIzinDetailModal()" style="background:none; border:none; color:white; font-size:18px; cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="waka-modal-body">
            <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                <div class="info-label">Nama Pendidik</div>
                <div id="gi_nama_guru" class="info-val"></div>
                <div id="gi_nip" style="font-size: 12px; color: #64748b; font-weight: 600;"></div>
            </div>

            <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                <div class="info-label">Tanggal Izin & Durasi</div>
                <div id="gi_tanggal_durasi" class="info-val"></div>
            </div>

            <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                <div class="info-label">Alasan Izin</div>
                <div id="gi_alasan" style="font-size: 13.5px; color: #1e293b; margin-top: 4px; background: #f8fafc; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-weight: 600;"></div>
            </div>

            <div id="gi_ket_khusus_box" style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; display: none;">
                <div class="info-label" style="color: #c2410c;">Keterangan Khusus Cuti</div>
                <div id="gi_ket_khusus" style="font-size: 13.5px; color: #9a3412; margin-top: 4px; background: #fff7ed; padding: 10px 14px; border-radius: 8px; border: 1px solid #fed7aa; font-weight: 600;"></div>
            </div>

            <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                <div class="info-label">Titipan Materi / Tugas Siswa</div>
                <div id="gi_materi" class="info-val" style="font-size: 13.5px; color: #334155;"></div>
            </div>

            <!-- Foto Dokumen Bukti (Pratinjau) -->
            <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                <div class="info-label" style="margin-bottom: 8px;">Foto Surat Keterangan / Dokumen Bukti</div>
                <div id="gi_foto_box" style="background: #f8fafc; padding: 12px; border-radius: 12px; border: 1px solid #cbd5e1; text-align: center;">
                    <img id="gi_foto_img" src="" alt="Dokumen Surat Keterangan" style="max-width: 100%; max-height: 260px; border-radius: 10px; object-fit: contain; border: 1px solid #cbd5e1;">
                    <div style="margin-top: 8px;">
                        <a id="gi_foto_link" href="#" target="_blank" style="color: #2563eb; font-size: 12.5px; font-weight: 700; text-decoration: none;">
                            <i class="fa-solid fa-up-right-from-square"></i> Buka Foto Ukuran Penuh (Full Size)
                        </a>
                    </div>
                </div>
                <div id="gi_no_foto_box" style="display: none; color: #94a3b8; font-size: 13px; font-style: italic;">
                    Tidak ada foto dokumen bukti yang diunggah.
                </div>
            </div>

            <div style="margin-bottom: 10px;">
                <div class="info-label" style="margin-bottom: 6px;">Status Persetujuan Berjenjang</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 12.5px; font-weight: 700;">
                    <div>Waka Kurikulum: <span id="gi_status_waka" style="color: #2563eb;"></span></div>
                    <div>Waka SDM: <span id="gi_status_waka_sdm" style="color: #2563eb;"></span></div>
                    <div>Kepala Sekolah: <span id="gi_status_kepsek" style="color: #2563eb;"></span></div>
                    <div>Status Final: <span id="gi_status_final" style="color: #16a34a;"></span></div>
                </div>
            </div>
        </div>
        <div class="waka-modal-footer">
            <button type="button" class="btn-action" onclick="closeGuruIzinDetailModal()" style="background:#64748b; color:white; padding: 8px 18px; font-size: 12.5px;">Tutup</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .waka-modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
        padding: 16px;
    }
    .waka-modal-card {
        background: #ffffff;
        border-radius: 18px;
        width: 100%;
        max-width: 540px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    }
    .waka-modal-header {
        padding: 16px 20px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top-left-radius: 18px;
        border-top-right-radius: 18px;
    }
    .waka-modal-header h3 {
        font-size: 15px;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .waka-modal-body {
        padding: 20px;
    }
    .waka-modal-footer {
        padding: 14px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        text-align: right;
        border-bottom-left-radius: 18px;
        border-bottom-right-radius: 18px;
    }
    .info-label {
        font-size: 11.5px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-val {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2px;
    }
</style>

<script>
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.cb-izin-item');
        checkboxes.forEach(cb => cb.checked = master.checked);
        updateBatchDeleteButton();
    }

    function updateBatchDeleteButton() {
        const checked = document.querySelectorAll('.cb-izin-item:checked');
        const btn = document.getElementById('btnBatchDelete');
        const countLabel = document.getElementById('selectedCount');
        
        countLabel.innerText = checked.length;
        if (checked.length > 0) {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
        } else {
            btn.disabled = true;
            btn.style.opacity = '0.6';
            btn.style.cursor = 'not-allowed';
        }
    }

    function submitBatchDelete() {
        const checked = document.querySelectorAll('.cb-izin-item:checked');
        if (checked.length === 0) {
            alert('Silakan pilih minimal satu data yang ingin dihapus!');
            return;
        }

        if (confirm('Apakah Anda yakin ingin memindahkan ' + checked.length + ' data izin guru yang dipilih ke Sampah (Soft Delete)?')) {
            document.getElementById('formBatchDelete').submit();
        }
    }

    function openGuruIzinDetailModal(data) {
        document.getElementById('gi_nama_guru').innerText = data.nama_guru || '-';
        document.getElementById('gi_nip').innerText = 'NIP: ' + (data.nip || '-');
        document.getElementById('gi_tanggal_durasi').innerText = (data.tanggal || '-') + ' (' + (data.durasi || '1 Hari') + ')';
        document.getElementById('gi_alasan').innerText = '"' + (data.alasan || '-') + '"';
        document.getElementById('gi_materi').innerText = data.materi || '-';
        document.getElementById('gi_status_waka').innerText = data.status_waka || 'Pending';
        document.getElementById('gi_status_waka_sdm').innerText = data.status_waka_sdm || 'Pending';
        document.getElementById('gi_status_kepsek').innerText = data.status_kepsek || 'Pending';
        document.getElementById('gi_status_final').innerText = data.status_final || 'Pending';

        const ketKhususBox = document.getElementById('gi_ket_khusus_box');
        if (data.kategori_izin === 'cuti' && data.keterangan_khusus && data.keterangan_khusus !== '-') {
            document.getElementById('gi_ket_khusus').innerText = data.keterangan_khusus;
            ketKhususBox.style.display = 'block';
        } else {
            ketKhususBox.style.display = 'none';
        }

        const fotoBox = document.getElementById('gi_foto_box');
        const noFotoBox = document.getElementById('gi_no_foto_box');
        if (data.foto_url) {
            document.getElementById('gi_foto_img').src = data.foto_url;
            document.getElementById('gi_foto_link').href = data.foto_url;
            fotoBox.style.display = 'block';
            noFotoBox.style.display = 'none';
        } else {
            fotoBox.style.display = 'none';
            noFotoBox.style.display = 'block';
        }

        document.getElementById('modalDetailGuruIzin').style.display = 'flex';
    }

    function closeGuruIzinDetailModal() {
        document.getElementById('modalDetailGuruIzin').style.display = 'none';
    }
</script>
@endsection
