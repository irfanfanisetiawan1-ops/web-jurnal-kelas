<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // Insert default initial settings data
        DB::table('settings')->insert([
            [
                'key' => 'cs_whatsapp',
                'value' => '6281234567890',
                'group' => 'cs',
                'label' => 'Nomor WhatsApp CS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'cs_email',
                'value' => 'cs.jurnal@edujournal.sch.id',
                'group' => 'cs',
                'label' => 'Email Customer Service',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'cs_jam_kerja',
                'value' => 'Senin - Jumat (07:00 - 15:30 WIB)',
                'group' => 'cs',
                'label' => 'Jam Operasional CS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'app_name',
                'value' => 'EDU JOURNAL',
                'group' => 'general',
                'label' => 'Nama Aplikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'tahun_ajaran_aktif',
                'value' => '2025/2026',
                'group' => 'academic',
                'label' => 'Tahun Ajaran Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'semester_aktif',
                'value' => 'Genap',
                'group' => 'academic',
                'label' => 'Semester Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
