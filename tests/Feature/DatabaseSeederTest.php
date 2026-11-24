<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder as DatabaseSeederClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_assigns_admin_and_user_roles(): void
    {
        $this->seed(DatabaseSeederClass::class);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@gmail.com',
            'role' => User::ROLE_ADMIN,
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'aurel@gmail.com',
            'role' => User::ROLE_USER,
        ]);
    }

    public function test_seeded_admin_can_log_in_to_the_admin_dashboard(): void
    {
        $this->seed(DatabaseSeederClass::class);

        $response = $this->post(route('login'), [
            'email' => 'admin@gmail.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $this->get(route('dashboard'))->assertOk();
    }
}
