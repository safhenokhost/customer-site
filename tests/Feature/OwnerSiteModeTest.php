<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerSiteModeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['site.owner_site' => false]);
    }

    public function test_home_returns_200_when_owner_site_and_no_license(): void
    {
        config(['site.owner_site' => true]);
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_license_page_shows_owner_notice_when_owner_site(): void
    {
        config(['site.owner_site' => true]);
        $user = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($user)->get(route('admin.license.index'));
        $response->assertStatus(200);
        $response->assertSee('سایت مالک');
        $response->assertSee('لایسنس اختیاری');
    }

    public function test_license_update_accepts_empty_key_when_owner_site(): void
    {
        config(['site.owner_site' => true]);
        $user = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($user)->post(route('admin.license.update'), [
            'license_key' => '',
            'domain' => '',
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_license_update_requires_key_when_not_owner_site(): void
    {
        config(['site.owner_site' => false]);
        $user = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($user)->post(route('admin.license.update'), [
            'license_key' => '',
            'domain' => '',
        ]);
        $response->assertSessionHasErrors('license_key');
    }
}
