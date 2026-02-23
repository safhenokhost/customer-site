<?php

namespace App\Services;

use App\Models\License;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * دریافت و کش تنظیمات UX/UI پلتفرم (رنگ، فونت، لوگو، نام) از API سایت اصلی.
 * در صورت نبود لایسنس یا خطا، مقادیر پیش‌فرض مشابه پلتفرم استفاده می‌شود.
 */
class PlatformUxService
{
    public const CACHE_KEY = 'platform_ux_config';
    public const CACHE_TTL_SECONDS = 3600; // 1 ساعت

    /** پیش‌فرض‌های تم و فونت مطابق پلتفرم */
    protected const DEFAULT_THEME = [
        'theme_primary' => '#4f46e5',
        'theme_secondary' => '#6366f1',
        'theme_menu_bg' => '#ffffff',
        'theme_menu_text' => '#374151',
        'theme_menu_link_active' => '#2563eb',
        'theme_title_color' => '#111827',
        'theme_link_color' => '#4f46e5',
        'theme_link_hover' => '#4338ca',
        'theme_sidebar_bg' => '#ffffff',
        'theme_sidebar_text' => '#374151',
        'theme_sidebar_active_bg' => '#eff6ff',
        'theme_sidebar_active_text' => '#2563eb',
        'theme_button_primary_bg' => '#4f46e5',
        'theme_button_primary_text' => '#ffffff',
    ];

    protected const DEFAULT_FONT = [
        'font_body' => 'Vazirmatn, Tahoma, sans-serif',
        'font_title' => 'Vazirmatn, Tahoma, sans-serif',
        'font_size_base' => '16',
        'font_size_title' => '1.25',
        'font_custom_1_name' => '',
        'font_custom_1_url' => '',
        'font_custom_2_name' => '',
        'font_custom_2_url' => '',
        'font_custom_3_name' => '',
        'font_custom_3_url' => '',
        'font_custom_4_name' => '',
        'font_custom_4_url' => '',
        'font_custom_5_name' => '',
        'font_custom_5_url' => '',
    ];

    protected const DEFAULT_GENERAL = [
        'platform_name' => 'پلتفرم SaaS',
        'logo_url' => null,
        'registration_open' => true,
    ];

    protected const DEFAULT_GUIDE_WIDGET = [
        'guide_widget_enabled' => '1',
        'guide_widget_position' => 'bottom-right',
        'guide_widget_btn_bg' => '#2563eb',
        'guide_widget_btn_text' => '#ffffff',
        'guide_widget_panel_bg' => '#ffffff',
        'guide_widget_panel_header_bg' => '#f9fafb',
        'guide_widget_panel_text' => '#111827',
    ];

    /**
     * دریافت کل پیکربندی UX از API یا کش یا پیش‌فرض.
     */
    public function getUx(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function () {
            return $this->fetchUxFromPlatform() ?? $this->defaultUx();
        });
    }

    /**
     * فقط تم (رنگ‌ها).
     */
    public function allTheme(): array
    {
        $ux = $this->getUx();
        return array_merge(self::DEFAULT_THEME, $ux['theme'] ?? []);
    }

    /**
     * فقط فونت‌ها و اندازه.
     */
    public function allFont(): array
    {
        $ux = $this->getUx();
        return array_merge(self::DEFAULT_FONT, $ux['font'] ?? []);
    }

    /**
     * تنظیمات عمومی (نام پلتفرم، لوگو، ثبت‌نام).
     */
    public function general(): array
    {
        $ux = $this->getUx();
        return array_merge(self::DEFAULT_GENERAL, $ux['general'] ?? []);
    }

    public function platformName(): string
    {
        return (string) ($this->general()['platform_name'] ?? self::DEFAULT_GENERAL['platform_name']);
    }

    public function logoUrl(): ?string
    {
        $url = $this->general()['logo_url'] ?? null;
        return $url ? (string) $url : null;
    }

    /**
     * پاک کردن کش (مثلاً بعد از تغییر لایسنس یا برای تست).
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * درخواست به API پلتفرم برای دریافت site-config شامل ux.
     */
    protected function fetchUxFromPlatform(): ?array
    {
        if (config('site.owner_site') && !License::current()) {
            return null;
        }
        $license = License::current();
        if (!$license || empty($license->license_key)) {
            return null;
        }

        $baseUrl = config('site.platform_url');
        if (empty($baseUrl)) {
            return null;
        }

        $url = $baseUrl . '/api/site-config';
        $params = [
            'license_key' => $license->license_key,
            'domain' => $license->domain ?: request()->getHost(),
        ];

        try {
            $response = Http::timeout(10)->get($url, $params);
            if (!$response->successful()) {
                return null;
            }
            $data = $response->json();
            if (empty($data['allowed']) || empty($data['ux'])) {
                return null;
            }
            return $data['ux'];
        } catch (\Throwable $e) {
            Log::debug('PlatformUxService fetch failed', ['message' => $e->getMessage()]);
            return null;
        }
    }

    protected function defaultUx(): array
    {
        return [
            'general' => self::DEFAULT_GENERAL,
            'theme' => self::DEFAULT_THEME,
            'font' => self::DEFAULT_FONT,
            'guide_widget' => self::DEFAULT_GUIDE_WIDGET,
        ];
    }

    /**
     * تنظیمات ویجت راهنما (فعال/غیرفعال، موقعیت، پالت رنگ).
     */
    public function guideWidget(): array
    {
        $ux = $this->getUx();
        return array_merge(self::DEFAULT_GUIDE_WIDGET, $ux['guide_widget'] ?? []);
    }

    public function guideWidgetEnabled(): bool
    {
        return ((string) ($this->guideWidget()['guide_widget_enabled'] ?? '1')) === '1';
    }

    /** کلاس‌های CSS برای موقعیت دکمهٔ ویجت (fixed). */
    public function guideWidgetPositionClasses(): string
    {
        $p = (string) ($this->guideWidget()['guide_widget_position'] ?? 'bottom-right');
        $map = [
            'bottom-right' => 'bottom-6 right-6',
            'bottom-left' => 'bottom-6 left-6',
            'top-right' => 'top-6 right-6',
            'top-left' => 'top-6 left-6',
        ];
        return $map[$p] ?? 'bottom-6 right-6';
    }
}
