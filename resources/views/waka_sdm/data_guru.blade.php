@extends('layouts.waka_sdm')

@section('title', 'Direktori SDM & Pendidik — Waka SDM')
@section('page-header', 'Direktori SDM & Pendidik')
@section('page-subheader', 'Master data pendidik, status kepegawaian, kontak WhatsApp, dan informasi tugas kedinasan')

@section('styles')
<style>
    .direktori-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* 4 Stat Cards Grid */
    .stat-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #e2e8f0;
    }

    .stat-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-icon-blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon-indigo { background: #e0e7ff; color: #4338ca; }
    .stat-icon-pink   { background: #fce7f3; color: #db2777; }
    .stat-icon-green  { background: #d1fae5; color: #059669; }

    .stat-details {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #94a3b8;
    }

    .stat-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    /* Filter Bar Container & Inputs */
    .filter-bar-container {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 16px 20px;
        background: #f8fafc;
        border-radius: 14px;
        border: 1px solid #cbd5e1;
        margin-bottom: 18px;
    }

    .filter-bar-container form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
    }

    .filter-input {
        padding: 9px 14px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
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
        background: #2b3957;
        color: #ffffff;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-filter-dark:hover { background: #1e293b; color: #ffffff; }

    .btn-reset-light {
        background: #e2e8f0;
        color: #475569;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-reset-light:hover { background: #cbd5e1; color: #0f172a; }

    /* Card Panel Base */
    .card-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    /* Table Design */
    .table-responsive {
        overflow-x: auto;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table-custom th {
        background: #f8fafc;
        padding: 14px 16px;
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-custom td {
        padding: 16px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .user-avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: #2563eb;
        color: #ffffff;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .badge-role {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        display: inline-block;
        text-transform: uppercase;
    }
    .badge-role-guru           { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .badge-role-waka           { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .badge-role-waka_sdm       { background: #ede9fe; color: #6d28d9; border: 1px solid #ddd6fe; }
    .badge-role-admin          { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
    .badge-role-kepala_sekolah { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }

    .btn-wa {
        background: #25d366;
        color: #ffffff;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: background 0.15s ease;
    }
    .btn-wa:hover { background: #128c7e; color: #ffffff; }

    .btn-act {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .btn-act-view { background: #f1f5f9; color: #475569; }
    .btn-act-view:hover { background: #e2e8f0; color: #0f172a; }

    /* Modals Backdrop & Card */
    .modal-backdrop-custom {
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

    .modal-card-custom {
        background: #ffffff;
        border-radius: 18px;
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .modal-header-custom {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header-custom h3 {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-body-custom {
        padding: 24px;
    }

    .modal-footer-custom {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    @media (max-width: 768px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
        .form-grid-2 { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="direktori-container">
    <!-- 4 Stat Cards Grid -->
    <div class="stat-grid-4">
        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-blue">
                <i class="fa-solid fa-users-gear"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Total Pendidik &amp; SDM</span>
                <span class="stat-val">{{ $stats['totalGuru'] ?? 0 }} Guru</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-indigo">
                <i class="fa-solid fa-person"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Guru Laki-Laki</span>
                <span class="stat-val">{{ $stats['totalLaki'] ?? 0 }} Guru</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-pink">
                <i class="fa-solid fa-person-dress"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Guru Perempuan</span>
                <span class="stat-val">{{ $stats['totalPerempuan'] ?? 0 }} Guru</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrapper stat-icon-green">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Akun Terverifikasi</span>
                <span class="stat-val">{{ $stats['totalAkun'] ?? 0 }} Akun</span>
            </div>
        </div>
    </div>

    <!-- Card Main Panel -->
    <div class="card-panel">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
            <h2 style="font-size: 18px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-address-book" style="color: #2563eb;"></i> Direktori Data Pendidik &amp; Kepegawaian
            </h2>
        </div>

        <!-- Filter Bar Form -->
        <div class="filter-bar-container">
            <form action="{{ route('waka-sdm.data-guru') }}" method="GET">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama, NIP, HP, atau Email..." class="filter-input" style="flex: 1; min-width: 220px;">
                
                <select name="jenis_kelamin" class="filter-input">
                    <option value="">Gender: Semua</option>
                    <option value="L" {{ $jkFilter == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $jkFilter == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>

                <select name="id_mapel" class="filter-input">
                    <option value="">Mapel: Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id_mapel }}" {{ $mapelFilter == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>

                <select name="role" class="filter-input">
                    <option value="">Peran: Semua Role</option>
                    <option value="guru" {{ $roleFilter == 'guru' ? 'selected' : '' }}>Guru Mengajar</option>
                    <option value="waka" {{ $roleFilter == 'waka' ? 'selected' : '' }}>Waka Kurikulum</option>
                    <option value="waka_sdm" {{ $roleFilter == 'waka_sdm' ? 'selected' : '' }}>Waka SDM</option>
                    <option value="admin" {{ $roleFilter == 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="kepala_sekolah" {{ $roleFilter == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                </select>

                <button type="submit" class="btn-filter-dark">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <a href="{{ route('waka-sdm.data-guru') }}" class="btn-reset-light">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </form>
        </div>

        <!-- Table Data -->
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Pendidik &amp; SDM</th>
                        <th>NIP</th>
                        <th>L/P</th>
                        <th>Kontak &amp; WhatsApp</th>
                        <th>Peran Sistem</th>
                        <th>Mapel / Wali Kelas</th>
                        <th style="text-align: center; width: 70px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruList as $index => $guru)
                        <tr>
                            <td>{{ $guruList->firstItem() + $index }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="user-avatar-circle">
                                        {{ strtoupper(substr($guru->nama_guru, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong style="font-size: 14px; color: #0f172a;">{{ $guru->nama_guru }}</strong>
                                        <div style="font-size: 12px; color: #64748b;">
                                            <i class="fa-regular fa-envelope" style="font-size: 11px;"></i> {{ $guru->email ?? ($guru->user ? $guru->user->email : '-') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-weight: 700; color: #334155;">{{ $guru->nip }}</td>
                            <td>
                                @if($guru->jenis_kelamin === 'L')
                                    <span style="color: #2563eb; font-weight: 700;"><i class="fa-solid fa-mars"></i> L</span>
                                @elseif($guru->jenis_kelamin === 'P')
                                    <span style="color: #db2777; font-weight: 700;"><i class="fa-solid fa-venus"></i> P</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span>{{ $guru->no_hp ?? '-' }}</span>
                                    @if(!empty($guru->no_hp))
                                        @php
                                            $cleanHp = preg_replace('/[^0-9]/', '', $guru->no_hp);
                                            if(str_starts_with($cleanHp, '0')) {
                                                $cleanHp = '62' . substr($cleanHp, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanHp }}?text=Halo%20{{ urlencode($guru->nama_guru) }}" target="_blank" class="btn-wa" title="Kirim Pesan WhatsApp">
                                            <i class="fa-brands fa-whatsapp"></i> Chat
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($guru->user)
                                    @php $r = strtolower($guru->user->role ?? 'guru'); @endphp
                                    <span class="badge-role badge-role-{{ $r }}">
                                        {{ $guru->user->role_label }}
                                    </span>
                                @else
                                    <span style="font-size: 11.5px; color: #94a3b8; font-weight: 600;">Terdaftar Master</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <strong style="color: #1e293b; font-size: 13px;">{{ $guru->mapel ? $guru->mapel->nama_mapel : 'Guru Mata Pelajaran' }}</strong>
                                </div>
                                @if($guru->kelasWali && $guru->kelasWali->count() > 0)
                                    <div style="font-size: 11.5px; color: #16a34a; font-weight: 700;">
                                        <i class="fa-solid fa-user-shield"></i> Wali: {{ $guru->kelasWali->pluck('nama_kelas')->join(', ') }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; justify-content: center;">
                                    <button type="button" class="btn-act btn-act-view" onclick='openModalDetailGuru(@json($guru))' title="Detail SDM">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 40px;">
                                <i class="fa-solid fa-id-badge" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                Belum ada data pendidik yang sesuai dengan kriteria filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($guruList->hasPages())
            {{ $guruList->links('partials.custom-pagination') }}
        @endif
    </div>
</div>

<!-- MODAL DETAIL GURU -->
<div id="modalDetailGuru" class="modal-backdrop-custom">
    <div class="modal-card-custom">
        <div class="modal-header-custom">
            <h3><i class="fa-solid fa-address-card" style="color: #2563eb;"></i> Detail Profil Pendidik &amp; SDM</h3>
            <button type="button" onclick="closeModalDetailGuru()" style="background:none; border:none; color:#64748b; font-size:18px; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body-custom">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px; background: #f8fafc; padding: 16px; border-radius: 14px; border: 1px solid #e2e8f0;">
                <div class="user-avatar-circle" style="width: 54px; height: 54px; font-size: 22px;" id="dt_avatar">
                    G
                </div>
                <div>
                    <h2 id="dt_nama" style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;"></h2>
                    <div style="font-size: 12.5px; color: #64748b; margin-top: 2px;">NIP: <strong id="dt_nip" style="color: #334155;"></strong></div>
                </div>
            </div>

            <div class="form-grid-2" style="font-size: 13px; line-height: 1.8;">
                <div><strong>Jenis Kelamin:</strong> <span id="dt_jk"></span></div>
                <div><strong>No HP / WA:</strong> <span id="dt_hp"></span></div>
                <div><strong>Email Sistem:</strong> <span id="dt_email"></span></div>
                <div><strong>Peran Sistem:</strong> <span id="dt_role"></span></div>
                <div><strong>Mata Pelajaran:</strong> <span id="dt_mapel"></span></div>
                <div><strong>Tugas Wali Kelas:</strong> <span id="dt_wali"></span></div>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" onclick="closeModalDetailGuru()" class="btn-reset-light">Tutup</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModalDetailGuru(data) {
        document.getElementById('dt_avatar').innerText = (data.nama_guru || 'G').substring(0, 1).toUpperCase();
        document.getElementById('dt_nama').innerText = data.nama_guru || '-';
        document.getElementById('dt_nip').innerText = data.nip || '-';
        document.getElementById('dt_jk').innerText = data.jenis_kelamin === 'L' ? 'Laki-laki' : (data.jenis_kelamin === 'P' ? 'Perempuan' : '-');
        document.getElementById('dt_hp').innerText = data.no_hp || '-';
        document.getElementById('dt_email').innerText = data.email || (data.user ? data.user.email : '-');
        
        let roleLabel = 'Guru Mengajar';
        if (data.user && data.user.role_label) {
            roleLabel = data.user.role_label;
        }
        document.getElementById('dt_role').innerText = roleLabel;
        document.getElementById('dt_mapel').innerText = data.mapel ? data.mapel.nama_mapel : 'Guru Mata Pelajaran';
        
        let waliInfo = '-';
        if (data.kelas_wali && data.kelas_wali.length > 0) {
            waliInfo = data.kelas_wali.map(k => k.nama_kelas).join(', ');
        }
        document.getElementById('dt_wali').innerText = waliInfo;

        document.getElementById('modalDetailGuru').style.display = 'flex';
    }

    function closeModalDetailGuru() {
        document.getElementById('modalDetailGuru').style.display = 'none';
    }
</script>
@endsection
