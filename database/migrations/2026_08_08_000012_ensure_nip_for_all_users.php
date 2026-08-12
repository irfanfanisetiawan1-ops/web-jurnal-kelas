<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Give Admin/TU user a default NIP if null
        DB::table('users')
            ->whereNull('nip')
            ->where(function($q) {
                $q->where('role', 'tu')
                  ->orWhere('role', 'admin')
                  ->orWhere('username', 'admin');
            })
            ->update(['nip' => '198001012005011000']);

        // 2. Give any remaining user without NIP a generated NIP if needed
        $usersWithoutNip = DB::table('users')->whereNull('nip')->get();
        foreach ($usersWithoutNip as $idx => $usr) {
            $generatedNip = '19990101202501' . sprintf('%04d', $usr->id);
            DB::table('users')->where('id', $usr->id)->update(['nip' => $generatedNip]);
        }

        // 3. Ensure every Guru in master data has an active user account with matching NIP
        $gurus = Guru::all();
        foreach ($gurus as $guru) {
            $user = User::where('nip', $guru->nip)->orWhere('id_guru', $guru->id_guru)->first();
            if (!$user) {
                User::create([
                    'name'              => $guru->nama_guru,
                    'nip'               => $guru->nip,
                    'username'          => 'guru.' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $guru->nama_guru)[0])) . $guru->id_guru,
                    'email'             => $guru->nip . '@sekolah.sch.id',
                    'password'          => Hash::make('password123'),
                    'role'              => 'guru',
                    'status_verifikasi' => 'verified',
                    'id_guru'           => $guru->id_guru,
                ]);
            } else {
                // Ensure id_guru and NIP are linked
                $user->update([
                    'nip'     => $guru->nip,
                    'id_guru' => $guru->id_guru,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed on rollback for data fix
    }
};
