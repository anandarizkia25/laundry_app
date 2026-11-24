<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('customer.index', absolute: false));
    }

    public function test_admins_are_redirected_to_the_dashboard_after_login(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_admin_can_logout(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_logout_button_is_rendered_for_customer_on_customer_page(): void
    {
        $user = User::factory()->create(['name' => 'Budi Customer']);

        $response = $this->actingAs($user)->get(route('customer.index'));

        $response->assertOk()
            ->assertSee('Budi Customer')
            ->assertSee('Pelanggan')
            ->assertSee('Keluar (Log Out)');
    }

    public function test_logout_button_is_rendered_for_admin_on_dashboard(): void
    {
        $admin = User::factory()->admin()->create(['name' => 'Super Admin']);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertOk()
            ->assertSee('Log Out');
    }

    public function test_logout_button_is_rendered_for_authenticated_user_on_welcome_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertOk()
            ->assertSee('Log Out');
    }
}
