<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember('settings', 3600, function () {
            return self::pluck('value', 'key')->toArray();
        });
        return $settings[$key] ?? $default;
    }

    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) || is_object($value) ? json_encode($value) : $value, 'group' => $group]
        );
        Cache::forget('settings');
    }

    public static function getMany(array $keys): array
    {
        $all = self::whereIn('key', $keys)->pluck('value', 'key')->toArray();
        $result = [];
        foreach ($keys as $k) {
            $result[$k] = $all[$k] ?? null;
        }
        return $result;
    }
}
