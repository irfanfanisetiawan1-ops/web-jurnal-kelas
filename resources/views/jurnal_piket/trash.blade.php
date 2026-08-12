@extends('layouts.admin')

@section('title', 'Sampah Jurnal Piket — EduJournal')
@section('header_title', 'Recycle Bin Jurnal Guru Piket')
@section('header_subtitle', 'Daftar entri jurnal piket yang dihapus sementara.')

@section('content')

    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc; text-align: left; font-size: 11px; text-transform: uppercase; color: #64748b;">
                        <th style="padding: 14px 18px;">Tanggal</th>
                        <th style="padding: 14px 18px;">Petugas Piket</th>
                        <th style="padding: 14px 18px;">Jam Piket</th>
                        <th style="padding: 14px 18px;">Dihapus Pada</th>
                        <th style="padding: 14px 18px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurnals as $jp)
                        <tr style="border-bottom: 1px solid #f1f5f9; font-size: 13px;">
                            <td style="padding: 14px 18px;">{{ \Carbon\Carbon::parse($jp->tanggal)->format('d/m/Y') }}</td>
                            <td style="padding: 14px 18px;"><strong>{{ $jp->nama_petugas_piket }}</strong></td>
                            <td style="padding: 14px 18px;"><code>{{ $jp->jam_piket }}</code></td>
                            <td style="padding: 14px 18px;">{{ $jp->deleted_at ? $jp->deleted_at->format('d M Y, H:i') : '-' }}</td>
                            <td style="padding: 14px 18px;">
                                <form action="{{ route('jurnal-piket.restore', $jp->id_jurnal_piket) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" style="background: #d1fae5; color: #065f46; border: none; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer;">
                                        <i class="fa-solid fa-rotate-left"></i> Pulihkan
                                    </button>
                                </form>
                                <form action="{{ route('jurnal-piket.force-delete', $jp->id_jurnal_piket) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #fee2e2; color: #991b1b; border: none; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer;" onclick="return confirm('Hapus PERMANEN entri piket ini?')">
                                        <i class="fa-solid fa-trash"></i> Hapus Permanen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 32px;">
                                Tidak ada entri jurnal piket di tempat sampah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
