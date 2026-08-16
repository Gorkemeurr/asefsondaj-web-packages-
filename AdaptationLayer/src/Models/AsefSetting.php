<?php

namespace AsefSondaj\AdaptationLayer\Models;

use Illuminate\Database\Eloquent\Model;

class AsefSetting extends Model
{
    protected $table = 'asef_settings';

    protected $fillable = ['key', 'group', 'label', 'value', 'type', 'help', 'sort'];

    /**
     * Get a setting value by key, with fallback.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        try {
            $s = static::where('key', $key)->first();
            return $s?->value ?? $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }
}
