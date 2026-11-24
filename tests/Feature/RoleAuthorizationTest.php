<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_regular_users_cannot_access_admin_routes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertForbidden();

        $this->actingAs($user)
            ->get(route('services.index'))
            ->assertForbidden();
    }

    public function test_admins_can_access_the_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk();
    }

    public function test_regular_users_only_see_customer_navigation_links(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('profile.edit'))
            ->assertOk()
            ->assertSee(route('customer.index'))
            ->assertDontSee(route('dashboard'))
            ->assertDontSee(route('services.index'));
    }
}
