<?php

namespace App\Helpers;

class Module
{
    /** @var array<string, bool>|null */
    protected static ?array $resolved = null;

    /**
     * Whether the given module is enabled for this installation (config-based).
     */
    public static function enabled(string $key): bool
    {
        if (self::$resolved !== null && array_key_exists($key, self::$resolved)) {
            return self::$resolved[$key];
        }
        $modules = config('modules.modules', []);
        if (! isset($modules[$key])) {
            return false;
        }
        $config = $modules[$key];
        $envKey = $config['env'] ?? 'MODULE_' . strtoupper($key) . '_ENABLED';
        $default = $config['default'] ?? false;
        $value = env($envKey, $default);
        $enabled = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        if (self::$resolved === null) {
            self::$resolved = [];
        }
        self::$resolved[$key] = $enabled;
        return $enabled;
    }

    /**
     * All registered module keys with their enabled state and label.
     *
     * @return array<string, array{key: string, name: string, enabled: bool}>
     */
    public static function all(): array
    {
        $modules = config('modules.modules', []);
        $out = [];
        foreach (array_keys($modules) as $key) {
            $out[$key] = [
                'key' => $key,
                'name' => $modules[$key]['name'] ?? $key,
                'enabled' => self::enabled($key),
            ];
        }
        return $out;
    }

    /**
     * List of enabled module keys only.
     *
     * @return array<int, string>
     */
    public static function enabledKeys(): array
    {
        $keys = [];
        foreach (array_keys(config('modules.modules', [])) as $key) {
            if (self::enabled($key)) {
                $keys[] = $key;
            }
        }
        return $keys;
    }
}
