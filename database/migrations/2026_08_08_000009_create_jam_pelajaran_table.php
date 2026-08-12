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
        if (!Schema::hasTable('jam_pelajaran')) {
            Schema::create('jam_pelajaran', function (Blueprint $table) {
                $table->id('id_jam');
                $table->string('jam_ke', 50); // e.g. "Jam Ke-1", "07:00 - 08:30"
                $table->time('jam_mulai')->nullable();
                $table->time('jam_selesai')->nullable();
                $table->string('keterangan', 255)->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }

        // Add id_jam to jadwal table if it doesn't exist
        if (Schema::hasTable('jadwal') && !Schema::hasColumn('jadwal', 'id_jam')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->unsignedBigInteger('id_jam')->nullable()->after('id_ruangan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('jadwal') && Schema::hasColumn('jadwal', 'id_jam')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->dropColumn('id_jam');
            });
        }
        Schema::dropIfExists('jam_pelajaran');
    }
};
