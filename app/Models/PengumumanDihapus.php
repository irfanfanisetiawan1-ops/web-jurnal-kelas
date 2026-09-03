<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumumanDihapus extends Model
{
    use HasFactory;

    protected $table = 'pengumuman_dihapus';

    protected $fillable = [
        'id_pengumuman',
        'user_id',
    ];

    public function pengumuman()
    {
        return $this->belongsTo(Pengumuman::class, 'id_pengumuman', 'id_pengumuman');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
