@extends('layouts.waka')

@section('title', 'Persetujuan Izin — Waka Portal')

@section('styles')
<style>
    .page-header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 800; color: #0f172a; }
    .card-panel { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); margin-bottom: 24px; }
    .table-custom { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-custom th { background: #f8fafc; padding: 12px 14px; text-align: left; font-weight: 800; color: #475569; border-bottom: 2px solid #e2e8f0; }
    .table-custom td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; color: #1e293b; }
    .badge-status { padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
    .badge-approved { background: #d1fae5; color: #065f46; }
    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-rejected { background: #fee2e2; color: #991b1b; }
    .btn-act { padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 11px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; transition: all 0.2s ease; }
    .btn-approve { background: #2563eb; color: #ffffff; }
    .btn-approve:hover { background: #1d4ed8; }
    .btn-reject { background: #ea580c; color: #ffffff; } /* Oranye Pekat untuk Penolakan Persetujuan */
    .btn-reject:hover { background: #c2410c; }
    .btn-delete { background: #dc2626; color: #ffffff; } /* Merah Kontras untuk Fitur Hapus */
    .btn-delete:hover { background: #b91c1c; }
    .btn-trash { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; } /* Kuning kecokelatan khas Sampah */
    .btn-trash:hover { background: #fde68a; color: #78350f; }
    .btn-trash .badge-count { background: #d97706; color: #ffffff; padding: 1px 7px; border-radius: 20px; font-size: 10px; font-weight: 800; margin-left: 4px; }
    .btn-detail { background: #475569; color: #ffffff; }
    .btn-detail:hover { background: #334155; }

    /* Modal Backdrop & Card Styling */
    .waka-modal-backdrop { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 99999; justify-content: center; align-items: center; padding: 20px; }
    .waka-modal-card { background: #ffffff; width: 100%; max-width: 620px; border-radius: 18px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); border: 1px solid #cbd5e1; overflow: hidden; display: flex; flex-direction: column; max-height: 90vh; }
    .waka-modal-header { padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #384972; color: #ffffff; }
    .waka-modal-header h3 { margin: 0; font-size: 17px; font-weight: 800; }
    .waka-modal-body { padding: 20px 24px; overflow-y: auto; color: #1e293b; }
    .waka-modal-footer { padding: 14px 24px; border-top: 1px solid #e2e8f0; text-align: right; background: #f8fafc; }
    .info-label { font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; }
    .info-val { font-size: 14px; font-weight: 700; color: #0f172a; margin-top: 2px; }
</style>
@endsection

@section('content')

    <div class="page-header-row">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: #64748b; margin-bottom: 4px;">Jurnal SMEA > <span>Persetujuan Izin</span></div>
            <h1 class="page-title">Persetujuan Izin Guru & Dispen Siswa</h1>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 10px; font-weight: 700; margin-bottom: 20px; border: 1px solid #a7f3d0;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 10px; font-weight: 700; margin-bottom: 20px; border: 1px solid #fca5a5;">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Section 1: Guru Izin -->
    <div class="card-panel">
        <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">
            <i class="fa-solid fa-user-clock" style="color: #2563eb;"></i> Riwayat & Antrean Izin Tidak Masuk Guru
        </h2>

        <!-- Form Pencarian & Filter Guru Izin -->
        <form method="GET" action="{{ route('waka.persetujuan-izin') }}" style="margin-bottom: 16px;">
            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; flex: 1;">
                    <input type="text" name="search_guru" value="{{ $searchGuru }}" placeholder="Cari nama guru, NIP, atau alasan..." style="padding: 8px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; width: 250px;">
                    <select name="status_guru" style="padding: 8px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                        <option value="all" {{ $statusGuru === 'all' || !$statusGuru ? 'selected' : '' }}>-- Semua Status Waka --</option>
                        <option value="pending" {{ $statusGuru === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                        <option value="approved" {{ $statusGuru === 'approved' ? 'selected' : '' }}>Approved (Disetujui)</option>
                        <option value="rejected" {{ $statusGuru === 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                    </select>
                    <input type="date" name="tanggal_guru" value="{{ $tanggalGuru }}" style="padding: 8px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                    <button type="submit" class="btn-act btn-approve" style="padding: 8px 14px;"><i class="fa-solid fa-magnifying-glass"></i> Filter</button>
                    @if($searchGuru || ($statusGuru && $statusGuru !== 'all') || $tanggalGuru)
                        <a href="{{ route('waka.persetujuan-izin') }}" class="btn-act btn-detail" style="padding: 8px 14px; background: #94a3b8;"><i class="fa-solid fa-rotate-left"></i> Reset Filter</a>
                    @endif
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <button type="button" class="btn-act btn-delete" onclick="submitBatchDeleteGuru()"><i class="fa-solid fa-trash-can"></i> Hapus Terpilih</button>
                    <a href="{{ route('waka.guru-izin.trash') }}" class="btn-act btn-trash" style="padding: 8px 14px;">
                        <i class="fa-solid fa-trash-can"></i> Sampah Izin Guru 
                        @if($trashedGuruIzinCount > 0) 
                            <span class="badge-count">{{ $trashedGuruIzinCount }}</span> 
                        @endif
                    </a>
                </div>
            </div>
        </form>

        <form id="formBatchGuru" method="POST" action="{{ route('waka.guru-izin.batch-delete') }}">
            @csrf
            <div style="overflow-x: auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllGuru" onclick="toggleSelectAllGuru(this)" style="cursor: pointer;">
                            </th>
                            <th>Nama Guru</th>
                            <th>Tanggal Mulai - Selesai</th>
                            <th>Alasan</th>
                            <th>Surat Bukti</th>
                            <th>Status Waka Kur</th>
                            <th>Status Waka SDM</th>
                            <th>Status Kepsek</th>
                            <th>Status Final</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruIzinList as $gi)
                            @php
                                $giDetailData = [
                                    'nama_guru' => $gi->guru->nama_guru ?? 'Guru Tidak Ditemukan',
                                    'nip' => $gi->guru->nip ?? '-',
                                    'tanggal' => ($gi->tanggal_mulai === $gi->tanggal_selesai || !$gi->tanggal_selesai) ? \Carbon\Carbon::parse($gi->tanggal_mulai)->format('d-m-Y') : \Carbon\Carbon::parse($gi->tanggal_mulai)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($gi->tanggal_selesai)->format('d-m-Y'),
                                    'durasi' => $gi->durasi ?? '1 Hari Full',
                                    'kategori_izin' => $gi->kategori_izin ?? 'biasa',
                                    'alasan' => $gi->alasan ?? '-',
                                    'keterangan_khusus' => $gi->keterangan_khusus ?? '-',
                                    'materi' => $gi->materi_dititipkan ?? '-',
                                    'foto_url' => $gi->foto_surat ? asset('uploads/guru_izin/' . $gi->foto_surat) : null,
                                    'status_waka' => ucfirst($gi->status_waka ?? 'pending'),
                                    'status_waka_sdm' => ucfirst($gi->status_waka_sdm ?? 'pending'),
                                    'status_kepsek' => ucfirst($gi->status_kepsek ?? 'pending'),
                                    'status_final' => ucfirst($gi->status_final ?? 'pending'),
                                    'catatan_waka' => $gi->catatan_waka ?? '-',
                                    'catatan_kepsek' => $gi->catatan_kepsek ?? '-',
                                ];
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $gi->id_guru_izin }}" class="cb-guru" style="cursor: pointer;">
                                </td>
                                <td style="font-weight: 700;">{{ $gi->guru->nama_guru ?? 'Guru' }}</td>
                                <td>{{ $gi->tanggal_mulai }} s/d {{ $gi->tanggal_selesai }}</td>
                                <td>{{ Str::limit($gi->alasan, 40) }}</td>
                                <td>
                                    @if($gi->foto_surat)
                                        <a href="{{ asset('uploads/guru_izin/' . $gi->foto_surat) }}" target="_blank" style="color: #2563eb; font-weight: 700; text-decoration: none;">
                                            <i class="fa-solid fa-paperclip"></i> Lihat File
                                        </a>
                                    @else
                                        <span style="color: #94a3b8;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-status {{ $gi->status_waka === 'approved' ? 'badge-approved' : ($gi->status_waka === 'rejected' ? 'badge-rejected' : 'badge-pending') }}">
                                        {{ ucfirst($gi->status_waka) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-status {{ $gi->status_waka_sdm === 'approved' ? 'badge-approved' : ($gi->status_waka_sdm === 'rejected' ? 'badge-rejected' : 'badge-pending') }}">
                                        {{ ucfirst($gi->status_waka_sdm) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-status {{ $gi->status_kepsek === 'approved' ? 'badge-approved' : ($gi->status_kepsek === 'rejected' ? 'badge-rejected' : 'badge-pending') }}">
                                        {{ ucfirst($gi->status_kepsek) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-status {{ $gi->status_final === 'approved' ? 'badge-approved' : ($gi->status_final === 'rejected' ? 'badge-rejected' : 'badge-pending') }}">
                                        {{ ucfirst($gi->status_final) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 4px; align-items: center; flex-wrap: wrap;">
                                        <button type="button" class="btn-act btn-detail" onclick='openGuruIzinDetailModal(@json($giDetailData))'>
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </button>
                                        @if($gi->status_waka === 'pending')
                                            <form action="{{ route('waka.izin.approve', $gi->id_guru_izin) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-act btn-approve"><i class="fa-solid fa-check"></i> Setujui</button>
                                            </form>
                                            <form action="{{ route('waka.izin.reject', $gi->id_guru_izin) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-act btn-reject"><i class="fa-solid fa-xmark"></i> Tolak</button>
                                            </form>
                                        @endif
                                        <button type="button" class="btn-act btn-delete" onclick="deleteSingleGuru({{ $gi->id_guru_izin }})">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align: center; padding: 20px; color: #94a3b8;">Belum ada data izin tidak masuk guru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
        <!-- Single Delete Form Guru -->
        <form id="singleDeleteGuruForm" method="POST" action="" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Section 2: Siswa Dispen -->
    <div class="card-panel">
        <h2 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 16px;">
            <i class="fa-solid fa-id-card" style="color: #d97706;"></i> Monitoring Permohonan Dispen Siswa
        </h2>

        <!-- Form Pencarian & Filter Siswa Dispen -->
        <form method="GET" action="{{ route('waka.persetujuan-izin') }}" style="margin-bottom: 16px;">
            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; flex: 1;">
                    <input type="text" name="search_dispen" value="{{ $searchDispen }}" placeholder="Cari kode dispen, siswa, kelas, alasan..." style="padding: 8px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; width: 250px;">
                    <select name="status_dispen" style="padding: 8px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                        <option value="all" {{ $statusDispen === 'all' || !$statusDispen ? 'selected' : '' }}>-- Semua Status Waka --</option>
                        <option value="pending" {{ $statusDispen === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                        <option value="approved" {{ $statusDispen === 'approved' ? 'selected' : '' }}>Approved (Disetujui)</option>
                        <option value="rejected" {{ $statusDispen === 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                    </select>
                    <input type="date" name="tanggal_dispen" value="{{ $tanggalDispen }}" style="padding: 8px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px;">
                    <button type="submit" class="btn-act btn-approve" style="padding: 8px 14px;"><i class="fa-solid fa-magnifying-glass"></i> Filter</button>
                    @if($searchDispen || ($statusDispen && $statusDispen !== 'all') || $tanggalDispen)
                        <a href="{{ route('waka.persetujuan-izin') }}" class="btn-act btn-detail" style="padding: 8px 14px; background: #94a3b8;"><i class="fa-solid fa-rotate-left"></i> Reset Filter</a>
                    @endif
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <button type="button" class="btn-act btn-delete" onclick="submitBatchDeleteDispen()"><i class="fa-solid fa-trash-can"></i> Hapus Terpilih</button>
                    <a href="{{ route('waka.siswa-dispen.trash') }}" class="btn-act btn-trash" style="padding: 8px 14px;">
                        <i class="fa-solid fa-trash-can"></i> Sampah Dispen Siswa 
                        @if($trashedSiswaDispenCount > 0) 
                            <span class="badge-count">{{ $trashedSiswaDispenCount }}</span> 
                        @endif
                    </a>
                </div>
            </div>
        </form>

        <form id="formBatchDispen" method="POST" action="{{ route('waka.siswa-dispen.batch-delete') }}">
            @csrf
            <div style="overflow-x: auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAllDispen" onclick="toggleSelectAllDispen(this)" style="cursor: pointer;">
                            </th>
                            <th>Kode Dispen</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Jam Keluar - Kembali</th>
                            <th>Alasan</th>
                            <th>Status Wali Kelas</th>
                            <th>Status Satpam</th>
                            <th>Aksi Waka</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswaDispenList as $sd)
                            @php
                                $sdDetailData = [
                                    'kode_dispen' => $sd->kode_dispen ?? '-',
                                    'nama_siswa' => $sd->siswa->nama_siswa ?? '-',
                                    'nisn' => $sd->siswa->nisn ?? '-',
                                    'kelas' => $sd->kelas->nama_kelas ?? '-',
                                    'tanggal' => $sd->tanggal ?? '-',
                                    'jam' => ($sd->jam_keluar ?? '-') . ' s/d ' . ($sd->jam_kembali ?? '-'),
                                    'alasan' => $sd->alasan ?? '-',
                                    'status_wali_kelas' => ucfirst($sd->status_wali_kelas ?? 'pending'),
                                    'status_satpam' => str_replace('_', ' ', ucfirst($sd->status_satpam ?? 'pending')),
                                    'status_waka' => ucfirst($sd->status_waka ?? 'pending'),
                                    'catatan_waka' => $sd->catatan_waka ?? '-',
                                    'foto_kartu_url' => $sd->foto_kartu_identitas ? asset($sd->foto_kartu_identitas) : null,
                                    'foto_surat_url' => $sd->foto_surat_dispen ? asset($sd->foto_surat_dispen) : null,
                                ];
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="ids[]" value="{{ $sd->id_siswa_dispen }}" class="cb-dispen" style="cursor: pointer;">
                                </td>
                                <td style="font-weight: 800; color: #2563eb;">{{ $sd->kode_dispen }}</td>
                                <td style="font-weight: 700;">{{ $sd->siswa->nama_siswa ?? '-' }}</td>
                                <td>{{ $sd->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $sd->tanggal }}</td>
                                <td>{{ $sd->jam_keluar ?? '-' }} s/d {{ $sd->jam_kembali ?? '-' }}</td>
                                <td>{{ Str::limit($sd->alasan, 35) }}</td>
                                <td>
                                    <span class="badge-status {{ $sd->status_wali_kelas === 'approved' ? 'badge-approved' : ($sd->status_wali_kelas === 'rejected' ? 'badge-rejected' : 'badge-pending') }}">
                                        {{ ucfirst($sd->status_wali_kelas) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-status {{ $sd->status_satpam === 'dizinkan_keluar' ? 'badge-approved' : ($sd->status_satpam === 'ditolak' ? 'badge-rejected' : 'badge-pending') }}">
                                        {{ str_replace('_', ' ', ucfirst($sd->status_satpam)) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 4px; align-items: center; flex-wrap: wrap;">
                                        <button type="button" class="btn-act btn-detail" onclick='openSiswaDispenDetailModal(@json($sdDetailData))'>
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </button>
                                        @if($sd->status_waka === 'pending')
                                            <form action="{{ route('waka.dispen.approve', $sd->id_siswa_dispen) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-act btn-approve"><i class="fa-solid fa-check"></i> Setujui</button>
                                            </form>
                                            <form action="{{ route('waka.dispen.reject', $sd->id_siswa_dispen) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-act btn-reject"><i class="fa-solid fa-xmark"></i> Tolak</button>
                                            </form>
                                        @endif
                                        <button type="button" class="btn-act btn-delete" onclick="deleteSingleDispen({{ $sd->id_siswa_dispen }})">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align: center; padding: 20px; color: #94a3b8;">Belum ada data permohonan dispen siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
        <!-- Single Delete Form Dispen -->
        <form id="singleDeleteDispenForm" method="POST" action="" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Modal Detail Guru Izin -->
    <div id="modalDetailGuruIzin" class="waka-modal-backdrop">
        <div class="waka-modal-card">
            <div class="waka-modal-header">
                <h3><i class="fa-solid fa-user-clock"></i> Detail Izin Tidak Masuk Guru</h3>
                <button type="button" onclick="closeGuruIzinDetailModal()" style="background:none; border:none; color:white; font-size:18px; cursor:pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="waka-modal-body">
                <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                    <div class="info-label">Nama Guru Mengajar</div>
                    <div id="gi_nama_guru" class="info-val"></div>
                    <div id="gi_nip" style="font-size: 12px; color: #64748b; font-weight: 600;"></div>
                </div>

                <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                    <div class="info-label">Tanggal Tidak Masuk & Durasi</div>
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

                <!-- Foto Dokumen Bukti (Langsung Tampil Pratinjau) -->
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
                        <div>Waka Kurikulum: <span id="gi_status_waka"></span></div>
                        <div>Waka SDM: <span id="gi_status_waka_sdm"></span></div>
                        <div>Kepala Sekolah: <span id="gi_status_kepsek"></span></div>
                        <div>Status Final: <span id="gi_status_final"></span></div>
                    </div>
                </div>
            </div>
            <div class="waka-modal-footer">
                <button type="button" class="btn-act btn-detail" onclick="closeGuruIzinDetailModal()" style="padding: 8px 18px; font-size: 12px;">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Detail Dispen Siswa -->
    <div id="modalDetailSiswaDispen" class="waka-modal-backdrop">
        <div class="waka-modal-card">
            <div class="waka-modal-header" style="background: #d97706;">
                <h3><i class="fa-solid fa-id-card"></i> Detail Permohonan Dispen Siswa</h3>
                <button type="button" onclick="closeSiswaDispenDetailModal()" style="background:none; border:none; color:white; font-size:18px; cursor:pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="waka-modal-body">
                <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div class="info-label">Kode Dispensasi</div>
                        <div id="sd_kode_dispen" class="info-val" style="color: #2563eb; font-size: 16px;"></div>
                    </div>
                    <div style="text-align: right;">
                        <div class="info-label">Tanggal</div>
                        <div id="sd_tanggal" class="info-val"></div>
                    </div>
                </div>

                <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                    <div class="info-label">Nama Siswa & Kelas</div>
                    <div id="sd_nama_siswa" class="info-val"></div>
                    <div id="sd_kelas_nisn" style="font-size: 12.5px; color: #64748b; font-weight: 600;"></div>
                </div>

                <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                    <div class="info-label">Jam Keluar s/d Kembali</div>
                    <div id="sd_jam" class="info-val" style="color: #d97706;"></div>
                </div>

                <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                    <div class="info-label">Alasan Dispensasi</div>
                    <div id="sd_alasan" style="font-size: 13.5px; color: #1e293b; margin-top: 4px; background: #f8fafc; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; font-weight: 600;"></div>
                </div>

                <!-- Pratinjau Foto Kartu Pelajar / Surat Dispen -->
                <div style="margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                    <div class="info-label" style="margin-bottom: 8px;">Foto Bukti Kartu Pelajar / Surat Dispen Resmi</div>
                    <div id="sd_foto_box" style="background: #f8fafc; padding: 12px; border-radius: 12px; border: 1px solid #cbd5e1; text-align: center;">
                        <img id="sd_foto_img" src="" alt="Dokumen Kartu Pelajar / Dispen Siswa" style="max-width: 100%; max-height: 260px; border-radius: 10px; object-fit: contain; border: 1px solid #cbd5e1;">
                        <div style="margin-top: 8px;">
                            <a id="sd_foto_link" href="#" target="_blank" style="color: #2563eb; font-size: 12.5px; font-weight: 700; text-decoration: none;">
                                <i class="fa-solid fa-up-right-from-square"></i> Buka Foto Ukuran Penuh (Full Size)
                            </a>
                        </div>
                    </div>
                    <div id="sd_no_foto_box" style="display: none; color: #94a3b8; font-size: 13px; font-style: italic;">
                        Tidak ada foto dokumen dispen yang diunggah.
                    </div>
                </div>

                <div style="margin-bottom: 10px;">
                    <div class="info-label" style="margin-bottom: 6px;">Status Persetujuan Berjenjang</div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 12.5px; font-weight: 700;">
                        <div>Status Wali Kelas: <span id="sd_status_wali"></span></div>
                        <div>Status Satpam: <span id="sd_status_satpam"></span></div>
                        <div>Status Waka: <span id="sd_status_waka"></span></div>
                    </div>
                </div>
            </div>
            <div class="waka-modal-footer">
                <button type="button" class="btn-act btn-detail" onclick="closeSiswaDispenDetailModal()" style="padding: 8px 18px; font-size: 12px;">Tutup</button>
            </div>
        </div>
    </div>

    <script>
    function openGuruIzinDetailModal(data) {
        document.getElementById('gi_nama_guru').innerText = data.nama_guru || '-';
        document.getElementById('gi_nip').innerText = 'NIP. ' + (data.nip || '-');
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

    function openSiswaDispenDetailModal(data) {
        document.getElementById('sd_kode_dispen').innerText = data.kode_dispen || '-';
        document.getElementById('sd_tanggal').innerText = data.tanggal || '-';
        document.getElementById('sd_nama_siswa').innerText = data.nama_siswa || '-';
        document.getElementById('sd_kelas_nisn').innerText = 'Kelas: ' + (data.kelas || '-') + (data.nisn && data.nisn !== '-' ? ' | NISN: ' + data.nisn : '');
        document.getElementById('sd_jam').innerText = data.jam || '-';
        document.getElementById('sd_alasan').innerText = '"' + (data.alasan || '-') + '"';
        document.getElementById('sd_status_wali').innerText = data.status_wali_kelas || 'Pending';
        document.getElementById('sd_status_satpam').innerText = data.status_satpam || 'Pending';
        document.getElementById('sd_status_waka').innerText = data.status_waka || 'Pending';

        const fotoBox = document.getElementById('sd_foto_box');
        const noFotoBox = document.getElementById('sd_no_foto_box');
        const fotoTargetUrl = data.foto_kartu_url || data.foto_surat_url;

        if (fotoTargetUrl) {
            document.getElementById('sd_foto_img').src = fotoTargetUrl;
            document.getElementById('sd_foto_link').href = fotoTargetUrl;
            fotoBox.style.display = 'block';
            noFotoBox.style.display = 'none';
        } else {
            fotoBox.style.display = 'none';
            noFotoBox.style.display = 'block';
        }

        document.getElementById('modalDetailSiswaDispen').style.display = 'flex';
    }

    function closeSiswaDispenDetailModal() {
        document.getElementById('modalDetailSiswaDispen').style.display = 'none';
    }

    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeGuruIzinDetailModal();
            closeSiswaDispenDetailModal();
        }
    });

    // Checkbox Select All & Delete Guru Izin
    function toggleSelectAllGuru(master) {
        const checkboxes = document.querySelectorAll('.cb-guru');
        checkboxes.forEach(cb => cb.checked = master.checked);
    }

    function submitBatchDeleteGuru() {
        const checked = document.querySelectorAll('.cb-guru:checked');
        if (checked.length === 0) {
            alert('Silakan pilih minimal satu data izin guru yang ingin dihapus!');
            return;
        }

        if (confirm('Apakah Anda yakin ingin memindahkan ' + checked.length + ' data izin guru yang dipilih ke Sampah (Soft Delete)?')) {
            document.getElementById('formBatchGuru').submit();
        }
    }

    function deleteSingleGuru(id) {
        if (confirm('Apakah Anda yakin ingin memindahkan data izin guru ini ke Sampah (Soft Delete)?')) {
            const form = document.getElementById('singleDeleteGuruForm');
            form.action = "{{ route('waka.guru-izin.destroy', 0) }}".replace('/0', '/' + id);
            form.submit();
        }
    }

    // Checkbox Select All & Delete Siswa Dispen
    function toggleSelectAllDispen(master) {
        const checkboxes = document.querySelectorAll('.cb-dispen');
        checkboxes.forEach(cb => cb.checked = master.checked);
    }

    function submitBatchDeleteDispen() {
        const checked = document.querySelectorAll('.cb-dispen:checked');
        if (checked.length === 0) {
            alert('Silakan pilih minimal satu data dispen siswa yang ingin dihapus!');
            return;
        }

        if (confirm('Apakah Anda yakin ingin memindahkan ' + checked.length + ' data dispen siswa yang dipilih ke Sampah (Soft Delete)?')) {
            document.getElementById('formBatchDispen').submit();
        }
    }

    function deleteSingleDispen(id) {
        if (confirm('Apakah Anda yakin ingin memindahkan data dispen siswa ini ke Sampah (Soft Delete)?')) {
            const form = document.getElementById('singleDeleteDispenForm');
            form.action = "{{ route('waka.siswa-dispen.destroy', 0) }}".replace('/0', '/' + id);
            form.submit();
        }
    }

    // Close modals on clicking outside box
    window.onclick = function(event) {
        const m1 = document.getElementById('modalDetailGuruIzin');
        const m2 = document.getElementById('modalDetailSiswaDispen');
        if (event.target === m1) m1.style.display = 'none';
        if (event.target === m2) m2.style.display = 'none';
    }
    </script>
@endsection
