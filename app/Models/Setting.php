<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'label', 'description', 'type', 'group'];

    /** @var array<string,mixed> */
    protected static array $cache = [];

    /**
     * Get a setting value by key, with an optional fallback default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, static::$cache)) {
            return static::$cache[$key];
        }

        $setting = static::where('key', $key)->first();
        $value = $setting ? $setting->value : $default;

        static::$cache[$key] = $value;

        return $value;
    }

    /**
     * Set (upsert) a setting value by key.
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::$cache[$key] = $value;
    }

    /**
     * Flush the in-memory cache (useful in tests or after bulk updates).
     */
    public static function flushCache(): void
    {
        static::$cache = [];
    }
}
