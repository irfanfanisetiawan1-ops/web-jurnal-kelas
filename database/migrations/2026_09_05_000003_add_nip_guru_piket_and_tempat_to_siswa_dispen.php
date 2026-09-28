<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa_dispen', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa_dispen', 'id_user_waka')) {
                $table->unsignedBigInteger('id_user_waka')->nullable()->after('id_jurnal_piket');
            }
            if (!Schema::hasColumn('siswa_dispen', 'nama_waka')) {
                $table->string('nama_waka', 100)->nullable();
            }
            if (!Schema::hasColumn('siswa_dispen', 'nip_waka')) {
                $table->string('nip_waka', 50)->nullable();
            }
            if (!Schema::hasColumn('siswa_dispen', 'no_hp_waka')) {
                $table->string('no_hp_waka', 30)->nullable();
            }
            if (!Schema::hasColumn('siswa_dispen', 'tempat')) {
                $table->string('tempat', 255)->nullable()->after('alasan');
            }
            if (!Schema::hasColumn('siswa_dispen', 'status_waka')) {
                $table->enum('status_waka', ['pending', 'approved', 'rejected'])->default('pending');
            }
            if (!Schema::hasColumn('siswa_dispen', 'catatan_waka')) {
                $table->text('catatan_waka')->nullable();
            }
            if (!Schema::hasColumn('siswa_dispen', 'waktu_approval_waka')) {
                $table->timestamp('waktu_approval_waka')->nullable();
            }
            if (!Schema::hasColumn('siswa_dispen', 'id_guru_piket')) {
                $table->unsignedBigInteger('id_guru_piket')->nullable();
            }
            if (!Schema::hasColumn('siswa_dispen', 'nama_guru_piket')) {
                $table->string('nama_guru_piket', 100)->nullable();
            }
            if (!Schema::hasColumn('siswa_dispen', 'nip_guru_piket')) {
                $table->string('nip_guru_piket', 50)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswa_dispen', function (Blueprint $table) {
            $cols = [
                'id_user_waka', 'nama_waka', 'nip_waka', 'no_hp_waka',
                'tempat', 'status_waka', 'catatan_waka', 'waktu_approval_waka',
                'id_guru_piket', 'nama_guru_piket', 'nip_guru_piket'
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('siswa_dispen', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
