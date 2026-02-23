<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * جستجو در صفحات راهنما برای ویجت راهنما در همان صفحه.
 * در حالت context=admin ورودی‌های پیش‌فرض (لینک به بخش‌های ادمین) هم برگردانده می‌شوند.
 */
class GuideSearchController extends Controller
{
    /** ورودی‌های پیش‌فرض راهنما برای پنل ادمین سایت مشتری (تنظیمات، ماژول‌ها، لایسنس و ...) */
    protected function defaultAdminGuideEntries(): array
    {
        $entries = [
            ['title' => 'داشبورد', 'url' => route('admin.dashboard')],
            ['title' => 'صفحات سایت', 'url' => route('admin.pages.index')],
            ['title' => 'تنظیمات سایت', 'url' => route('admin.settings.index')],
            ['title' => 'لایسنس و اتصال به پلتفرم', 'url' => route('admin.license.index')],
        ];
        if (\App\Helpers\SiteHelper::shopEnabled()) {
            $entries[] = ['title' => 'محصولات و فروشگاه', 'url' => route('admin.products.index')];
            $entries[] = ['title' => 'سفارشات', 'url' => route('admin.orders.index')];
        }
        $entries[] = ['title' => 'مشاهده سایت', 'url' => url('/')];
        return $entries;
    }

    public function index(Request $request): JsonResponse
    {
        $q = trim((string) $request->input('q', ''));
        $contextAdmin = $request->input('context') === 'admin';
        $query = Page::published();

        if ($q !== '') {
            $query->where(function ($qb) use ($q) {
                $qb->where('title', 'like', '%' . $q . '%')
                    ->orWhere('body', 'like', '%' . $q . '%');
            });
        }

        $pages = $query->orderBy('order')->orderBy('title')->limit(100)->get(['id', 'title', 'slug']);

        $items = $pages->map(function ($page) {
            return [
                'title' => $page->title,
                'slug' => $page->slug,
                'url' => route('page.show', $page->slug),
            ];
        })->values()->all();

        if ($contextAdmin) {
            $defaults = $this->defaultAdminGuideEntries();
            if ($q !== '') {
                $qLower = mb_strtolower($q);
                $defaults = array_filter($defaults, function ($e) use ($qLower) {
                    return mb_strpos(mb_strtolower($e['title']), $qLower) !== false;
                });
            }
            $items = array_merge($defaults, $items);
        }

        return response()->json(['pages' => $items]);
    }
}
