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
        // 1. Upgrade 'kelas' table: Add id_jurusan and Foreign Keys
        Schema::table('kelas', function (Blueprint $table) {
            if (!Schema::hasColumn('kelas', 'id_jurusan')) {
                $table->integer('id_jurusan')->nullable()->after('nama_kelas');
            }
        });

        Schema::table('kelas', function (Blueprint $table) {
            // Check index/fk before adding
            $table->foreign('id_jurusan', 'fk_kelas_jurusan')
                  ->references('id_jurusan')->on('jurusan')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });

        // 2. Upgrade 'users' table: Ensure id_guru foreign key
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'id_guru')) {
                $table->foreign('id_guru', 'fk_users_guru')
                      ->references('id_guru')->on('guru')
                      ->onDelete('set null')
                      ->onUpdate('cascade');
            }
        });

        // 3. Upgrade 'jurnal_piket' table: Foreign key for id_guru
        Schema::table('jurnal_piket', function (Blueprint $table) {
            if (Schema::hasColumn('jurnal_piket', 'id_guru')) {
                $table->foreign('id_guru', 'fk_jurnal_piket_guru')
                      ->references('id_guru')->on('guru')
                      ->onDelete('set null')
                      ->onUpdate('cascade');
            }
        });

        // 4. Upgrade 'jurnal_mengajar' table: Add substitute teacher, documentation image, jam_ke
        Schema::table('jurnal_mengajar', function (Blueprint $table) {
            if (!Schema::hasColumn('jurnal_mengajar', 'id_guru_pengganti')) {
                $table->integer('id_guru_pengganti')->nullable()->after('id_jadwal');
                $table->foreign('id_guru_pengganti', 'fk_jurnal_guru_pengganti')
                      ->references('id_guru')->on('guru')
                      ->onDelete('set null')
                      ->onUpdate('cascade');
            }
            if (!Schema::hasColumn('jurnal_mengajar', 'dokumentasi')) {
                $table->string('dokumentasi', 255)->nullable()->after('catatan');
            }
            if (!Schema::hasColumn('jurnal_mengajar', 'jam_ke')) {
                $table->string('jam_ke', 20)->nullable()->after('dokumentasi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurnal_mengajar', function (Blueprint $table) {
            $table->dropForeign('fk_jurnal_guru_pengganti');
            $table->dropColumn(['id_guru_pengganti', 'dokumentasi', 'jam_ke']);
        });

        Schema::table('jurnal_piket', function (Blueprint $table) {
            $table->dropForeign('fk_jurnal_piket_guru');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('fk_users_guru');
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign('fk_kelas_jurusan');
            $table->dropColumn('id_jurusan');
        });
    }
};
