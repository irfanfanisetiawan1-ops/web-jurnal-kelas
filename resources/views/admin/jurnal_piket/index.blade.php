@extends('layouts.admin')

@section('title', '12. Jurnal Guru Piket — EduJournal Admin')
@section('header_title', '12. Monitoring & Pengelolaan Jurnal Guru Piket')
@section('header_subtitle', 'Kelola catatan harian petugas piket sekolah, kejadian khusus, dan rekapitulasi presensi')

@section('styles')
<style>
    /* Stats & KPI Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .kpi-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    }

    .kpi-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .kpi-icon.indigo { background: #e0e7ff; color: #4f46e5; }
    .kpi-icon.emerald { background: #d1fae5; color: #059669; }
    .kpi-icon.rose    { background: #ffe4e6; color: #e11d48; }
    .kpi-icon.amber   { background: #fef3c7; color: #d97706; }

    .kpi-info { flex: 1; }
    .kpi-info .val { font-size: 22px; font-weight: 800; color: #0f172a; line-height: 1.2; }
    .kpi-info .lbl { font-size: 12px; font-weight: 600; color: #64748b; margin-top: 2px; }

    /* Action & Filter Card */
    .card-filter {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .filter-header h3 {
        font-size: 15px;
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
        align-items: end;
    }

    .form-group { margin-bottom: 0; }
    .form-group label {
        display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 6px;
    }
    .form-control {
        width: 100%;
        padding: 9px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        outline: none;
        background: #ffffff;
        color: #1e293b;
    }
    .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    /* Top Toolbar Buttons */
    .btn-create {
        background: #4f46e5; color: white; border: none; padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: all 0.2s;
    }
    .btn-create:hover { background: #4338ca; color: white; }

    .btn-trash {
        background: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 9px 18px;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-trash:hover {
        background: #fde68a;
        color: #78350f;
    }

    .btn-trash .badge-count {
        background: #d97706;
        color: #ffffff;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 20px;
    }

    .btn-export {
        background: #0284c7; color: white; border: none; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;
    }
    .btn-export:hover { background: #0369a1; color: white; }

    .btn-print {
        background: #059669; color: white; border: none; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;
    }
    .btn-print:hover { background: #047857; color: white; }

    .btn-submit {
        background: #3b82f6; color: white; border: none; padding: 9px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-reset {
        background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 9px 14px; border-radius: 8px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    }

    /* Table & Badges */
    .table-card {
        background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); overflow: hidden;
    }

    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th {
        font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b; background: #f8fafc; padding: 14px 18px; font-weight: 700; text-align: left; border-bottom: 1px solid #e2e8f0;
    }
    .custom-table td {
        padding: 16px 18px; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #334155; vertical-align: middle;
    }

    .badge-suasana { padding: 5px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }
    .badge-kondusif { background: #d1fae5; color: #065f46; }
    .badge-kejadian { background: #fee2e2; color: #991b1b; }
    .badge-lainnya  { background: #fef3c7; color: #92400e; }

    /* Action Buttons With Text Labels (Keterangan Aksi) */
    .btn-action-pill {
        padding: 6px 12px;
        border-radius: 8px;
        border: none;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-action-view { background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .btn-action-view:hover { background: #c7d2fe; color: #312e81; }

    .btn-action-edit { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .btn-action-edit:hover { background: #fde68a; color: #78350f; }

    .btn-action-delete { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
    .btn-action-delete:hover { background: #fca5a5; color: #7f1d1d; }

    /* Modal Overlay */
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);
        display: none; align-items: center; justify-content: center; z-index: 1000;
        padding: 20px;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: #ffffff; width: 100%; max-width: 580px; border-radius: 20px; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2); max-height: 90vh; overflow-y: auto;
    }

    .modal-header {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 14px;
    }
    .modal-header h3 { font-size: 16px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px; }
    .modal-close { background: none; border: none; font-size: 22px; color: #94a3b8; cursor: pointer; }
    .modal-close:hover { color: #0f172a; }

    .form-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;
    }
    .form-grid.full { grid-template-columns: 1fr; }
</style>
@endsection

@section('content')

    <!-- KPI Summary Stat Cards -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon indigo"><i class="fa-solid fa-clipboard-check"></i></div>
            <div class="kpi-info">
                <div class="val">{{ number_format($totalPiket) }}</div>
                <div class="lbl">Total Entri Piket</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon emerald"><i class="fa-solid fa-circle-check"></i></div>
            <div class="kpi-info">
                <div class="val">{{ number_format($kondusifCount) }}</div>
                <div class="lbl">Kondisi Kondusif</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon rose"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="kpi-info">
                <div class="val">{{ number_format($kejadianCount) }}</div>
                <div class="lbl">Catatan Kejadian</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon amber"><i class="fa-solid fa-user-clock"></i></div>
            <div class="kpi-info">
                <div class="val">{{ number_format($petugasHariIni) }}</div>
                <div class="lbl">Piket Hari Ini</div>
            </div>
        </div>
    </div>

    <!-- Toolbar & Filter Card -->
    <div class="card-filter">
        <div class="filter-header">
            <h3><i class="fa-solid fa-sliders"></i> Filter & Fitur Aksi Pengelolaan Jurnal Piket</h3>
            <div class="action-buttons">
                <button onclick="openCreateModal()" class="btn-create" title="Tambah entri jurnal piket baru">
                    <i class="fa-solid fa-plus"></i> Catat Jurnal Piket
                </button>
                <a href="{{ route('admin.jurnal-piket.trash') }}" class="btn-trash" title="Lihat Tempat Sampah Jurnal Piket">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Lihat Sampah Jurnal Piket</span>
                    <span class="badge-count">{{ $trashedCount ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.jurnal-piket.export', request()->query()) }}" class="btn-export" title="Unduh laporan jurnal piket ke format CSV/Excel">
                    <i class="fa-solid fa-file-csv"></i> Ekspor CSV
                </a>
                <a href="{{ route('admin.jurnal-piket.print', request()->query()) }}" target="_blank" class="btn-print" title="Buka format cetak laporan jurnal piket">
                    <i class="fa-solid fa-print"></i> Cetak Laporan
                </a>
            </div>
        </div>

        <form action="{{ route('admin.jurnal-piket') }}" method="GET" class="filter-grid">
            <div class="form-group">
                <label for="search">Cari Petugas / Catatan</label>
                <input type="text" id="search" name="search" value="{{ $search }}" class="form-control" placeholder="Kata kunci...">
            </div>

            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ $tanggal_mulai ?? $tanggal }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ $tanggal_selesai }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="status_suasana">Status Suasana</label>
                <select name="status_suasana" id="status_suasana" class="form-control">
                    <option value="">-- Semua Status --</option>
                    <option value="Kondusif" {{ $status_suasana == 'Kondusif' ? 'selected' : '' }}>Kondusif</option>
                    <option value="Ada Kejadian" {{ $status_suasana == 'Ada Kejadian' ? 'selected' : '' }}>Ada Kejadian</option>
                    <option value="Lainnya" {{ $status_suasana == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn-submit"><i class="fa-solid fa-filter"></i> Filter</button>
                @if($search || $tanggal || $tanggal_mulai || $tanggal_selesai || $status_suasana)
                    <a href="{{ route('admin.jurnal-piket') }}" class="btn-reset">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO</th>
                        <th>TANGGAL</th>
                        <th>JAM TUGAS</th>
                        <th>PETUGAS GURU PIKET</th>
                        <th>KONDISI / SUASANA</th>
                        <th>RINGKASAN CATATAN KEJADIAN</th>
                        <th style="text-align: center; width: 230px;">KETERANGAN AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnalsPiket as $index => $jp)
                        <tr>
                            <td style="font-weight: 700; color: #64748b;">{{ $jurnalsPiket->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($jp->tanggal)->format('d M Y') }}</strong>
                                <div style="font-size: 11px; color: #94a3b8;">{{ \Carbon\Carbon::parse($jp->tanggal)->translatedFormat('l') }}</div>
                            </td>
                            <td><code>{{ $jp->jam_piket }}</code></td>
                            <td>
                                <strong>{{ $jp->nama_petugas_piket }}</strong>
                                @if($jp->guru)
                                    <div style="font-size: 11px; color: #64748b;">NIP: {{ $jp->guru->nip ?? '-' }}</div>
                                @endif
                            </td>
                            <td>
                                @if($jp->status_suasana == 'Kondusif')
                                    <span class="badge-suasana badge-kondusif"><i class="fa-solid fa-circle-check"></i> Kondusif</span>
                                @elseif($jp->status_suasana == 'Ada Kejadian')
                                    <span class="badge-suasana badge-kejadian"><i class="fa-solid fa-triangle-exclamation"></i> Ada Kejadian</span>
                                @else
                                    <span class="badge-suasana badge-lainnya"><i class="fa-solid fa-circle-info"></i> {{ $jp->status_suasana }}</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($jp->catatan_kejadian ?? 'Tidak ada catatan khusus.', 55) }}</td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                                    <button class="btn-action-pill btn-action-view" onclick="openDetailModal({{ $jp->id_jurnal_piket }})" title="Lihat detail rincian piket dan catatan">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>
                                    <button class="btn-action-pill btn-action-edit" onclick="openEditModal({{ $jp->id_jurnal_piket }})" title="Ubah atau perbarui data piket">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.jurnal-piket.destroy', $jp->id_jurnal_piket) }}" method="POST" onsubmit="return confirm('Pindahkan data jurnal piket petugas {{ addslashes($jp->nama_petugas_piket) }} (Tanggal: {{ \Carbon\Carbon::parse($jp->tanggal)->format('d/m/Y') }}) ke Tempat Sampah?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-pill btn-action-delete" title="Pindahkan data ini ke Sampah">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 40px 20px;">
                                <i class="fa-solid fa-clipboard-list" style="font-size: 40px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                                <strong>Tidak ada entri jurnal guru piket yang ditemukan.</strong>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jurnalsPiket->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9;">
                {{ $jurnalsPiket->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Tambah Jurnal Piket -->
    <div class="modal-overlay" id="createModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3><i class="fa-solid fa-plus-circle" style="color: #4f46e5;"></i> Catat Jurnal Piket Baru</h3>
                <button class="modal-close" onclick="closeCreateModal()">&times;</button>
            </div>
            <form action="{{ route('admin.jurnal-piket.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="create_tanggal">Tanggal Piket <span style="color:#ef4444;">*</span></label>
                        <input type="date" id="create_tanggal" name="tanggal" value="{{ date('Y-m-d') }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="create_jam_piket">Jam Tugas Piket <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="create_jam_piket" name="jam_piket" value="07:00 - 15:00" class="form-control" required placeholder="Contoh: 07:00 - 15:00">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="create_id_guru">Pilih Guru Piket (Database)</label>
                        <select name="id_guru" id="create_id_guru" class="form-control" onchange="autoFillNamaGuru(this, 'create_nama_petugas_piket')">
                            <option value="">-- Pilih Guru Dari Database --</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}">{{ $g->nama_guru }} (NIP: {{ $g->nip ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="create_nama_petugas_piket">Nama Petugas Piket <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="create_nama_petugas_piket" name="nama_petugas_piket" class="form-control" required placeholder="Nama lengkap petugas piket...">
                    </div>
                </div>

                <div class="form-grid full">
                    <div class="form-group">
                        <label for="create_status_suasana">Kondisi / Suasana Sekolah <span style="color:#ef4444;">*</span></label>
                        <select name="status_suasana" id="create_status_suasana" class="form-control" required>
                            <option value="Kondusif" selected>Kondusif (Aman & Lancar)</option>
                            <option value="Ada Kejadian">Ada Kejadian / Insiden Khusus</option>
                            <option value="Lainnya">Lainnya / Catatan Khusus</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid full" style="margin-bottom: 20px;">
                    <div class="form-group">
                        <label for="create_catatan_kejadian">Rincian Catatan / Kejadian Hari Ini</label>
                        <textarea id="create_catatan_kejadian" name="catatan_kejadian" rows="4" class="form-control" placeholder="Tuliskan catatan presensi, keterlambatan siswa/guru, penanganan kesehatan, atau kejadian penting lainnya..."></textarea>
                    </div>
                </div>

                <div style="text-align: right; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeCreateModal()" class="btn-reset">Batal</button>
                    <button type="submit" class="btn-create"><i class="fa-solid fa-save"></i> Simpan Jurnal Piket</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Jurnal Piket -->
    <div class="modal-overlay" id="editModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3><i class="fa-solid fa-pen-to-square" style="color: #d97706;"></i> Edit Data Jurnal Piket</h3>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit_tanggal">Tanggal Piket <span style="color:#ef4444;">*</span></label>
                        <input type="date" id="edit_tanggal" name="tanggal" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_jam_piket">Jam Tugas Piket <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="edit_jam_piket" name="jam_piket" class="form-control" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit_id_guru">Pilih Guru Piket</label>
                        <select name="id_guru" id="edit_id_guru" class="form-control" onchange="autoFillNamaGuru(this, 'edit_nama_petugas_piket')">
                            <option value="">-- Tanpa Guru Spesifik --</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_nama_petugas_piket">Nama Petugas Piket <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="edit_nama_petugas_piket" name="nama_petugas_piket" class="form-control" required>
                    </div>
                </div>

                <div class="form-grid full">
                    <div class="form-group">
                        <label for="edit_status_suasana">Kondisi / Suasana Sekolah <span style="color:#ef4444;">*</span></label>
                        <select name="status_suasana" id="edit_status_suasana" class="form-control" required>
                            <option value="Kondusif">Kondusif (Aman & Lancar)</option>
                            <option value="Ada Kejadian">Ada Kejadian / Insiden Khusus</option>
                            <option value="Lainnya">Lainnya / Catatan Khusus</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid full" style="margin-bottom: 20px;">
                    <div class="form-group">
                        <label for="edit_catatan_kejadian">Rincian Catatan / Kejadian Hari Ini</label>
                        <textarea id="edit_catatan_kejadian" name="catatan_kejadian" rows="4" class="form-control"></textarea>
                    </div>
                </div>

                <div style="text-align: right; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeEditModal()" class="btn-reset">Batal</button>
                    <button type="submit" class="btn-create" style="background:#d97706;"><i class="fa-solid fa-save"></i> Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail Kejadian -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3><i class="fa-solid fa-circle-info" style="color: #4f46e5;"></i> Rincian & Keterangan Jurnal Piket</h3>
                <button class="modal-close" onclick="closeDetailModal()">&times;</button>
            </div>
            <div id="detailModalContent" style="font-size:13.5px; color:#334155; line-height:1.6;">
                <div style="text-align:center; padding:30px; color:#94a3b8;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;"></i> Memuat data...
                </div>
            </div>
            <div style="margin-top:20px; text-align:right;">
                <button onclick="closeDetailModal()" class="btn-reset">Tutup</button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openCreateModal() {
        document.getElementById('createModal').classList.add('active');
    }
    function closeCreateModal() {
        document.getElementById('createModal').classList.remove('active');
    }

    function openEditModal(id) {
        fetch(`{{ url('/admin/jurnal-piket-admin') }}/${id}/detail`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const data = res.data;
                    document.getElementById('editForm').action = `{{ url('/admin/jurnal-piket-admin') }}/${id}/update`;
                    document.getElementById('edit_tanggal').value = data.tanggal;
                    document.getElementById('edit_jam_piket').value = data.jam_piket;
                    document.getElementById('edit_id_guru').value = data.id_guru || '';
                    document.getElementById('edit_nama_petugas_piket').value = data.nama_petugas_piket;
                    document.getElementById('edit_status_suasana').value = data.status_suasana;
                    document.getElementById('edit_catatan_kejadian').value = data.catatan_kejadian !== 'Tidak ada catatan khusus.' ? data.catatan_kejadian : '';
                    
                    document.getElementById('editModal').classList.add('active');
                }
            })
            .catch(err => {
                alert('Gagal mengambil data jurnal piket.');
            });
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }

    function openDetailModal(id) {
        document.getElementById('detailModal').classList.add('active');
        document.getElementById('detailModalContent').innerHTML = `
            <div style="text-align:center; padding:30px; color:#94a3b8;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:24px;"></i> Memuat data...
            </div>
        `;

        fetch(`{{ url('/admin/jurnal-piket-admin') }}/${id}/detail`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const d = res.data;
                    let badgeClass = 'badge-kondusif';
                    if (d.status_suasana === 'Ada Kejadian') badgeClass = 'badge-kejadian';
                    else if (d.status_suasana === 'Lainnya') badgeClass = 'badge-lainnya';

                    const html = `
                        <div style="background:#f8fafc; padding:16px; border-radius:12px; margin-bottom:16px; border:1px solid #e2e8f0;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                <span style="font-size:12px; font-weight:700; color:#64748b;">TANGGAL PIKET</span>
                                <span class="badge-suasana ${badgeClass}">${d.status_suasana}</span>
                            </div>
                            <h4 style="font-size:16px; font-weight:800; color:#0f172a; margin-bottom:4px;">${d.tanggal_formatted}</h4>
                            <div style="font-size:13px; color:#475569;"><i class="fa-regular fa-clock"></i> Jam Tugas: <code>${d.jam_piket}</code></div>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                            <div style="background:#ffffff; border:1px solid #e2e8f0; padding:12px; border-radius:10px;">
                                <div style="font-size:11px; font-weight:700; color:#64748b;">PETUGAS PIKET</div>
                                <div style="font-weight:700; color:#1e293b; font-size:14px; margin-top:2px;">${d.nama_petugas_piket}</div>
                            </div>
                            <div style="background:#ffffff; border:1px solid #e2e8f0; padding:12px; border-radius:10px;">
                                <div style="font-size:11px; font-weight:700; color:#64748b;">NIP GURU</div>
                                <div style="font-weight:700; color:#1e293b; font-size:14px; margin-top:2px;">${d.nip}</div>
                            </div>
                        </div>

                        <div style="margin-bottom:16px;">
                            <label style="font-size:12px; font-weight:700; color:#475569; display:block; margin-bottom:6px;">RINCIAN CATATAN / KEJADIAN:</label>
                            <div style="background:#f1f5f9; padding:14px; border-radius:10px; font-size:13px; color:#1e293b; white-space:pre-line; border:1px solid #cbd5e1;">
                                ${d.catatan_kejadian}
                            </div>
                        </div>

                        <div style="background:#f8fafc; padding:10px 14px; border-radius:8px; font-size:11.5px; color:#64748b; border:1px solid #e2e8f0; display:flex; justify-content:space-between;">
                            <span><i class="fa-regular fa-calendar-check"></i> Dicatat Pada: <strong>${d.created_at_formatted}</strong></span>
                            <span>ID Jurnal: <code>#${d.id_jurnal_piket}</code></span>
                        </div>
                    `;
                    document.getElementById('detailModalContent').innerHTML = html;
                }
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('active');
    }

    function autoFillNamaGuru(selectEl, targetId) {
        const selectedText = selectEl.options[selectEl.selectedIndex].text;
        if (selectEl.value && selectedText) {
            const namaClean = selectedText.split(' (NIP:')[0];
            document.getElementById(targetId).value = namaClean;
        }
    }
</script>
@endsection
