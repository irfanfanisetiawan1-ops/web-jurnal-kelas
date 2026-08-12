@extends('layouts.admin')

@section('title', 'Profil & Password Admin — EduJournal Admin')
@section('header_title', 'Pengaturan Profil & Keamanan Admin')
@section('header_subtitle', 'Perbarui data identitas dan ubah password kata sandi Administrator')

@section('content')

    <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; max-width: 600px; padding: 28px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Email Administrator</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;">
            </div>

            <hr style="margin: 24px 0; border: 0; border-top: 1px solid #e2e8f0;">

            <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin-bottom: 14px;">Ubah Password (Kosongkan jika tidak ingin diubah)</h4>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Password Baru</label>
                <input type="password" name="password" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;" placeholder="••••••••">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;" placeholder="••••••••">
            </div>

            <button type="submit" style="background: #4f46e5; color: white; border: none; padding: 12px 20px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer;">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Profil
            </button>
        </form>
    </div>

@endsection
