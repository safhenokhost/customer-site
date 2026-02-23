<?php

namespace App\Helpers;

use App\Services\PlatformUxService;

/**
 * دسترسی به تنظیمات UX/UI پلتفرم (هماهنگ با saas-platform) برای استفاده در ویوها.
 */
class PlatformUx
{
    protected static function service(): PlatformUxService
    {
        return app(PlatformUxService::class);
    }

    public static function platformName(): string
    {
        return self::service()->platformName();
    }

    public static function logoUrl(): ?string
    {
        return self::service()->logoUrl();
    }

    public static function allTheme(): array
    {
        return self::service()->allTheme();
    }

    public static function allFont(): array
    {
        return self::service()->allFont();
    }

    public static function general(): array
    {
        return self::service()->general();
    }

    public static function clearCache(): void
    {
        self::service()->clearCache();
    }

    public static function guideWidget(): array
    {
        return self::service()->guideWidget();
    }

    public static function guideWidgetEnabled(): bool
    {
        return self::service()->guideWidgetEnabled();
    }

    public static function guideWidgetPositionClasses(): string
    {
        return self::service()->guideWidgetPositionClasses();
    }
}
