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
        if (!Schema::hasColumn('jurnal_mengajar', 'pertemuan_ke')) {
            Schema::table('jurnal_mengajar', function (Blueprint $table) {
                $table->string('pertemuan_ke', 20)->nullable()->after('materi');
                $table->string('kondisi_kelas', 50)->default('Kondusif')->after('catatan');
                $table->boolean('is_draft')->default(false)->after('kondisi_kelas');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('jurnal_mengajar', 'pertemuan_ke')) {
            Schema::table('jurnal_mengajar', function (Blueprint $table) {
                $table->dropColumn(['pertemuan_ke', 'kondisi_kelas', 'is_draft']);
            });
        }
    }
};
