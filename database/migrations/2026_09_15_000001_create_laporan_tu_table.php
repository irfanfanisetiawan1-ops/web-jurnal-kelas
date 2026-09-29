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
        Schema::create('laporan_tu', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code', 30)->unique();
            $table->string('nama_pelapor', 150);
            $table->string('role_pelapor', 50); // guru, wali_kelas, guru_piket, satpam, siswa, orang_tua, staf_tu, lainnya
            $table->string('nomor_identitas', 50)->nullable(); // NIP / NISN / NIS / No. Identitas
            $table->string('no_wa', 25);
            $table->string('email', 150)->nullable();
            $table->string('kategori_kendala', 100);
            $table->string('judul_laporan', 255);
            $table->text('deskripsi_kendala');
            $table->string('lampiran', 255)->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending');
            $table->text('tanggapan_admin')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('responded_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'created_at']);
            $table->index('ticket_code');
            $table->index('no_wa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_tu');
    }
};
