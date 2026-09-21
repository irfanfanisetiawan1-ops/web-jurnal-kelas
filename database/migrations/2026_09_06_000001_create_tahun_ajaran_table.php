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
        if (!Schema::hasTable('tahun_ajaran')) {
            Schema::create('tahun_ajaran', function (Blueprint $table) {
                $table->id();
                $table->string('tahun_ajaran', 20); // e.g. 2026/2027
                $table->enum('semester', ['Ganjil', 'Genap'])->default('Ganjil');
                $table->string('periode_label', 100)->nullable(); // e.g. Juli - Desember 2026
                $table->date('tanggal_mulai')->nullable();
                $table->date('tanggal_selesai')->nullable();
                $table->boolean('is_aktif')->default(false); // 1 = Aktif, 0 = Tidak Aktif
                $table->boolean('buka_jurnal')->default(true); // 1 = Terbuka (Bisa Input), 0 = Terkunci (Arsip)
                $table->text('keterangan')->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index(['tahun_ajaran', 'semester']);
                $table->index('is_aktif');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_ajaran');
    }
};