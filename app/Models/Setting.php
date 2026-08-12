<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
    ];

    /**
     * Helper static untuk mengambil nilai setting berdasarkan key.
     */
    public static function getByKey(string $key, ?string $default = null): ?string
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Helper static untuk menyimpan/meng-update nilai setting berdasarkan key.
     */
    public static function setByKey(string $key, ?string $value, string $group = 'general', ?string $label = null): static
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'label' => $label ?? ucfirst(str_replace('_', ' ', $key)),
            ]
        );
    }
}
