@extends('layouts.waka')

@section('title', 'Kotak Sampah Pelanggaran Siswa — Jurnal SMEA')

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
        <div>
            <h1 style="font-size:24px; font-weight:800; color:#0f172a; margin:0;">Kotak Sampah Pelanggaran Siswa</h1>
            <p style="font-size:13.5px; color:#64748b; margin:4px 0 0;">Pulihkan atau hapus permanen data pelanggaran siswa yang telah dihapus.</p>
        </div>

        <div style="display:flex; align-items:center; gap:8px;">
            <a href="{{ route('waka.pelanggaran-siswa') }}" class="btn-action-pill" style="background:#e2e8f0; color:#334155; padding:9px 16px; border-radius:10px; font-size:13px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Pelanggaran
            </a>

            @if($trashedPelanggarans->total() > 0)
                <form action="{{ route('waka.pelanggaran-siswa.empty-trash') }}" method="POST" onsubmit="return confirm('PERINGATAN: Seluruh data di kotak sampah akan dihapus secara PERMANEN! Lanjutkan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action-pill" style="background:#dc2626; color:#ffffff; padding:9px 16px; border-radius:10px; font-size:13px; font-weight:700; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-fire"></i> Kosongkan Sampah
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div style="background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; padding:14px 18px; border-radius:12px; font-size:13.5px; font-weight:700;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background:#ffffff; border-radius:18px; border:1px solid #e2e8f0; overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; text-align:left;">
                <thead>
                    <tr style="background:#f1f5f9;">
                        <th style="padding:14px 18px; font-size:13px; font-weight:700; color:#334155;">Nama Siswa</th>
                        <th style="padding:14px 18px; font-size:13px; font-weight:700; color:#334155;">Kelas</th>
                        <th style="padding:14px 18px; font-size:13px; font-weight:700; color:#334155;">Jenis Pelanggaran</th>
                        <th style="padding:14px 18px; font-size:13px; font-weight:700; color:#334155;">Tanggal Dihapus</th>
                        <th style="padding:14px 18px; font-size:13px; font-weight:700; color:#334155; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedPelanggarans as $tp)
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td style="padding:16px 18px;">
                                <strong>{{ $tp->siswa->nama_siswa ?? '-' }}</strong>
                                <div style="font-size:12px; color:#64748b;">NIS: {{ $tp->siswa->nis ?? '-' }}</div>
                            </td>
                            <td style="padding:16px 18px;">{{ $tp->kelas->nama_kelas ?? ($tp->siswa->kelas->nama_kelas ?? '-') }}</td>
                            <td style="padding:16px 18px;">
                                <span style="font-size:11px; font-weight:800; padding:2px 6px; border-radius:4px; background:#fee2e2; color:#991b1b;">{{ $tp->kategori_pelanggaran }}</span>
                                <span style="font-weight:600; color:#0f172a;">{{ $tp->jenis_pelanggaran }}</span>
                            </td>
                            <td style="padding:16px 18px; font-size:13px; color:#64748b;">{{ $tp->deleted_at ? $tp->deleted_at->format('d/m/Y H:i') : '-' }}</td>
                            <td style="padding:16px 18px; text-align:center;">
                                <div style="display:inline-flex; gap:6px;">
                                    <form action="{{ route('waka.pelanggaran-siswa.restore', $tp->id_pelanggaran) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action-icon" style="background:#dcfce7; color:#15803d; border:1px solid #bbf7d0;" title="Pulihkan Data">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('waka.pelanggaran-siswa.force-delete', $tp->id_pelanggaran) }}" method="POST" onsubmit="return confirm('Hapus data pelanggaran ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-icon" style="background:#fee2e2; color:#dc2626; border:1px solid #fecaca;" title="Hapus Permanen">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px; color:#94a3b8;">
                                Kotak sampah pelanggaran siswa kosong.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding:16px 20px; background:#ffffff; border-top:1px solid #f1f5f9;">
            {{ $trashedPelanggarans->links('partials.custom-pagination') }}
        </div>
    </div>

</div>
@endsection