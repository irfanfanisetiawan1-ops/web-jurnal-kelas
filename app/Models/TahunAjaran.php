<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Setting;

class TahunAjaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'periode_label',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_aktif',
        'buka_jurnal',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'is_aktif'        => 'boolean',
        'buka_jurnal'     => 'boolean',
    ];

    /**
     * Scope untuk mengambil hanya data tahun ajaran aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_aktif', true);
    }

    /**
     * Dapatkan instance Tahun Ajaran yang sedang aktif saat ini
     */
    public static function getActive()
    {
        $active = static::where('is_aktif', true)->first();

        if (!$active) {
            // Coba ambil dari setting jika belum ada di database
            $settingTa  = Setting::getByKey('tahun_ajaran_aktif', '2026/2027');
            $settingSem = Setting::getByKey('semester_aktif', 'Ganjil');

            $active = static::where('tahun_ajaran', $settingTa)
                ->where('semester', $settingSem)
                ->first();

            if ($active) {
                $active->update(['is_aktif' => true]);
            }
        }

        return $active;
    }

    /**
     * Mengaktifkan tahun ajaran ini dan menonaktifkan seluruh tahun ajaran lainnya,
     * serta memperbarui pengaturan global sistem pada tabel settings.
     */
    public function activate(): bool
    {
        // Nonaktifkan semua tahun ajaran lain
        static::where('id', '!=', $this->id)->update(['is_aktif' => false]);

        // Aktifkan tahun ajaran ini
        $this->is_aktif = true;
        $saved = $this->save();

        if ($saved) {
            // Sinkronkan ke tabel settings
            Setting::setByKey('tahun_ajaran_aktif', $this->tahun_ajaran, 'academic', 'Tahun Ajaran Aktif');
            Setting::setByKey('semester_aktif', $this->semester, 'academic', 'Semester Aktif');
        }

        return $saved;
    }

    /**
     * Label semester formatted: "Ganjil (Sem 1)" / "Genap (Sem 2)"
     */
    public function getSemesterFormattedAttribute(): string
    {
        return $this->semester === 'Ganjil' ? 'Ganjil (Sem 1)' : 'Genap (Sem 2)';
    }

    /**
     * Nama periode lengkap: "2026/2027 Semester Ganjil"
     */
    public function getNamaLengkapAttribute(): string
    {
        return "{$this->tahun_ajaran} - Semester {$this->semester}";
    }

    /**
     * Hitung durasi hari kalender dari tanggal mulai ke selesai
     */
    public function getDurasiHariAttribute(): ?int
    {
        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            return $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
        }
        return null;
    }
}