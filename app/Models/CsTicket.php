<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsTicket extends Model
{
    use HasFactory;

    protected $table = 'cs_tickets';

    protected $fillable = [
        'ticket_code',
        'user_id',
        'kategori',
        'subjek',
        'pesan',
        'status',
        'tanggapan_admin',
        'responded_by',
        'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
        ];
    }

    /**
     * User pelapor yang membuat tiket.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Admin/TU yang memberikan tanggapan.
     */
    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    /**
     * Label status tiket yang ramah pengguna.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'  => '<span class="badge badge-warning" style="background:#fef3c7; color:#92400e; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:700;"><i class="fa-solid fa-clock"></i> Pending</span>',
            'diproses' => '<span class="badge badge-info" style="background:#e0f2fe; color:#075985; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:700;"><i class="fa-solid fa-spinner fa-spin"></i> Diproses</span>',
            'selesai'  => '<span class="badge badge-success" style="background:#d1fae5; color:#065f46; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:700;"><i class="fa-solid fa-circle-check"></i> Selesai</span>',
            default    => ucfirst($this->status),
        };
    }
}
