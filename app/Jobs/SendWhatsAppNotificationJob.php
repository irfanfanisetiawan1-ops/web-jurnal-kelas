<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\GuruIzin;
use App\Models\SiswaDispen;
use App\Services\WhatsAppNotificationService;
use Illuminate\Support\Facades\Log;

class SendWhatsAppNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $type;
    public int $modelId;
    public ?string $approvalUrl;

    /**
     * Create a new job instance.
     *
     * @param string $type 'guru_izin' atau 'siswa_dispen'
     * @param int $modelId ID model yang bersangkutan
     * @param string|null $approvalUrl URL persetujuan
     */
    public function __construct(string $type, int $modelId, ?string $approvalUrl = null)
    {
        $this->type = $type;
        $this->modelId = $modelId;
        $this->approvalUrl = $approvalUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppNotificationService $service): void
    {
        try {
            if ($this->type === 'guru_izin') {
                $izin = GuruIzin::with('guru')->find($this->modelId);
                if ($izin) {
                    $service->sendNotifikasiIzinGuru($izin, $this->approvalUrl);
                } else {
                    Log::warning("[WhatsApp Job] GuruIzin dengan ID {$this->modelId} tidak ditemukan.");
                }
            } elseif ($this->type === 'siswa_dispen') {
                $dispen = SiswaDispen::with(['siswa.kelas', 'kelas', 'wakaUser'])->find($this->modelId);
                if ($dispen) {
                    $service->sendNotifikasiDispensasiSiswa($dispen, $this->approvalUrl);
                } else {
                    Log::warning("[WhatsApp Job] SiswaDispen dengan ID {$this->modelId} tidak ditemukan.");
                }
            }
        } catch (\Throwable $e) {
            Log::error("[WhatsApp Job Exception] Gagal memproses background job untuk {$this->type} #{$this->modelId}: " . $e->getMessage());
        }
    }
}
