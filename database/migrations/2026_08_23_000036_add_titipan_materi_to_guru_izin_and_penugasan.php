<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('guru_izin')) {
            Schema::table('guru_izin', function (Blueprint $table) {
                if (!Schema::hasColumn('guru_izin', 'materi_dititipkan')) {
                    $table->text('materi_dititipkan')->nullable()->after('alasan');
                }
                if (!Schema::hasColumn('guru_izin', 'tugas_dititipkan')) {
                    $table->text('tugas_dititipkan')->nullable()->after('materi_dititipkan');
                }
                if (!Schema::hasColumn('guru_izin', 'file_tugas')) {
                    $table->string('file_tugas', 255)->nullable()->after('tugas_dititipkan');
                }
            });
        }

        if (Schema::hasTable('penugasan_guru_pengganti')) {
            Schema::table('penugasan_guru_pengganti', function (Blueprint $table) {
                if (!Schema::hasColumn('penugasan_guru_pengganti', 'materi_dititipkan')) {
                    $table->text('materi_dititipkan')->nullable()->after('catatan');
                }
                if (!Schema::hasColumn('penugasan_guru_pengganti', 'tugas_dititipkan')) {
                    $table->text('tugas_dititipkan')->nullable()->after('materi_dititipkan');
                }
                if (!Schema::hasColumn('penugasan_guru_pengganti', 'file_tugas')) {
                    $table->string('file_tugas', 255)->nullable()->after('tugas_dititipkan');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('guru_izin')) {
            Schema::table('guru_izin', function (Blueprint $table) {
                $table->dropColumn(['materi_dititipkan', 'tugas_dititipkan', 'file_tugas']);
            });
        }

        if (Schema::hasTable('penugasan_guru_pengganti')) {
            Schema::table('penugasan_guru_pengganti', function (Blueprint $table) {
                $table->dropColumn(['materi_dititipkan', 'tugas_dititipkan', 'file_tugas']);
            });
        }
    }
};
