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
        Schema::create('jurnal_piket', function (Blueprint $table) {
            $table->id('id_jurnal_piket');
            $table->date('tanggal');
            $table->integer('id_guru')->nullable();
            $table->string('nama_petugas_piket', 100);
            $table->string('jam_piket', 50)->default('07:00 - 15:00');
            $table->text('catatan_kejadian')->nullable();
            $table->enum('status_suasana', ['Kondusif', 'Ada Kejadian', 'Lainnya'])->default('Kondusif');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_piket');
    }
};
