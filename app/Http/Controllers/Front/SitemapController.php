<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Helpers\SiteHelper;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public const SITEMAP_CACHE_KEY = 'sitemap_xml';
    public const SITEMAP_CACHE_TTL = 3600; // 1 ساعت

    /**
     * خروجی sitemap.xml برای موتورهای جستجو (کش ۱ ساعته).
     */
    public function index(): Response
    {
        $xml = Cache::remember(self::SITEMAP_CACHE_KEY, self::SITEMAP_CACHE_TTL, function () {
            return $this->buildSitemapXml();
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    private function buildSitemapXml(): string
    {
        $base = url('/');
        $entries = [];

        $entries[] = [
            'loc' => $base,
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        foreach (Page::published()->get() as $page) {
            $entries[] = [
                'loc' => route('page.show', $page->slug),
                'lastmod' => $page->updated_at?->toW3cString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        }

        if (SiteHelper::blogEnabled()) {
            $entries[] = [
                'loc' => route('blog.index'),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ];
            foreach (Category::orderBy('order')->get() as $cat) {
                $entries[] = [
                    'loc' => route('blog.category', $cat->slug),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }
            foreach (Post::published()->get() as $post) {
                $entries[] = [
                    'loc' => route('blog.show', $post->slug),
                    'lastmod' => ($post->updated_at ?? $post->published_at)?->toW3cString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }
        }

        if (SiteHelper::shopEnabled()) {
            $entries[] = [
                'loc' => route('shop.index'),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ];
            foreach (Product::active()->orderBy('order')->get() as $product) {
                $entries[] = [
                    'loc' => route('shop.show', $product->slug),
                    'lastmod' => $product->updated_at?->toW3cString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }
        }

        return $this->buildXml($entries);
    }

    private function buildXml(array $entries): string
    {
        $out = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $out .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($entries as $e) {
            $out .= '  <url>' . "\n";
            $out .= '    <loc>' . htmlspecialchars($e['loc'], ENT_XML1, 'UTF-8') . '</loc>' . "\n";
            if (! empty($e['lastmod'])) {
                $out .= '    <lastmod>' . htmlspecialchars($e['lastmod'], ENT_XML1, 'UTF-8') . '</lastmod>' . "\n";
            }
            if (! empty($e['changefreq'])) {
                $out .= '    <changefreq>' . htmlspecialchars($e['changefreq'], ENT_XML1, 'UTF-8') . '</changefreq>' . "\n";
            }
            if (isset($e['priority'])) {
                $out .= '    <priority>' . htmlspecialchars((string) $e['priority'], ENT_XML1, 'UTF-8') . '</priority>' . "\n";
            }
            $out .= '  </url>' . "\n";
        }
        $out .= '</urlset>';
        return $out;
    }
}
