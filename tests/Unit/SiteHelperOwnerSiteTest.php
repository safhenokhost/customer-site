<?php

namespace Tests\Unit;

use App\Helpers\Module;
use App\Helpers\SiteHelper;
use Tests\TestCase;

class SiteHelperOwnerSiteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['site.owner_site' => false]);
        $this->resetModuleCache();
    }

    private function resetModuleCache(): void
    {
        $r = new \ReflectionClass(Module::class);
        $p = $r->getProperty('resolved');
        $p->setAccessible(true);
        $p->setValue(null);
    }

    public function test_is_owner_site_returns_true_when_config_set(): void
    {
        config(['site.owner_site' => true]);
        $this->assertTrue(SiteHelper::isOwnerSite());
    }

    public function test_is_owner_site_returns_false_when_config_not_set(): void
    {
        config(['site.owner_site' => false]);
        $this->assertFalse(SiteHelper::isOwnerSite());
    }

    public function test_blog_enabled_equals_module_when_owner_site(): void
    {
        config(['site.owner_site' => true]);
        $this->resetModuleCache();
        $this->assertSame(Module::enabled('blog'), SiteHelper::blogEnabled());
    }

    public function test_shop_enabled_equals_module_when_owner_site(): void
    {
        config(['site.owner_site' => true]);
        $this->resetModuleCache();
        $this->assertSame(Module::enabled('shop'), SiteHelper::shopEnabled());
    }
}
