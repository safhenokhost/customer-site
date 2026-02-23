<?php

namespace App\Helpers;

use Illuminate\Support\Str;

/**
 * کمک برای تولید مقادیر متا و OG از مدل‌ها (صفحه، مطلب، محصول و غیره).
 */
class Seo
{
    public static function title($model): string
    {
        if ($model === null) {
            return SiteHelper::siteName();
        }
        $title = $model->meta_title ?? $model->title ?? null;
        return $title ? (string) $title : SiteHelper::siteName();
    }

    public static function description($model, int $limit = 160): string
    {
        if ($model === null) {
            return '';
        }
        $desc = $model->meta_description ?? null;
        if ($desc !== null && $desc !== '') {
            return Str::limit(strip_tags((string) $desc), $limit);
        }
        $body = $model->body ?? $model->content ?? $model->description ?? null;
        if ($body !== null) {
            return Str::limit(strip_tags((string) $body), $limit);
        }
        return '';
    }

    public static function imageUrl($model): ?string
    {
        if ($model === null) {
            return null;
        }
        $image = $model->featured_image ?? $model->image ?? $model->meta_image ?? null;
        if (empty($image)) {
            return null;
        }
        return str_starts_with($image, 'http') ? $image : asset('storage/' . ltrim($image, '/'));
    }
}
