<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = ['license_key', 'domain', 'expires_at'];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }

    /**
     * The single active license for this installation (latest record).
     */
    public static function current(): ?self
    {
        return self::latest()->first();
    }

    /**
     * Whether the current license is valid (domain match and not expired).
     * No remote validation; local check only.
     */
    public function isValid(?string $requestHost = null): bool
    {
        if (empty($this->license_key)) {
            return false;
        }
        $host = $requestHost ?? request()->getHost();
        if (! empty($this->domain) && $this->domain !== $host) {
            return false;
        }
        if ($this->expires_at !== null && $this->expires_at->isPast()) {
            return false;
        }
        return true;
    }

    /**
     * Status label for admin display.
     */
    public function statusLabel(): string
    {
        if (empty($this->license_key)) {
            return 'تنظیم نشده';
        }
        $host = request()->getHost();
        if (! empty($this->domain) && $this->domain !== $host) {
            return 'دامنه نامطابقت';
        }
        if ($this->expires_at !== null && $this->expires_at->isPast()) {
            return 'منقضی شده';
        }
        return 'فعال';
    }

    /**
     * Mask license key for display (e.g. XXXX-XXXX-****-****).
     */
    public function maskedKey(): string
    {
        if (empty($this->license_key) || strlen($this->license_key) < 8) {
            return '—';
        }
        $len = strlen($this->license_key);
        return substr($this->license_key, 0, 4) . '-****-****-' . substr($this->license_key, -4);
    }
}
