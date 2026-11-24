<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\CustomerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeding_creates_five_customers_without_duplicates_on_repeated_runs(): void
    {
        $this->seed(CustomerSeeder::class);
        $this->seed(CustomerSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'aurel@gmail.com',
            'role' => User::ROLE_USER,
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'zahra@gmail.com',
            'role' => User::ROLE_USER,
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'arjuna@gmail.com',
            'role' => User::ROLE_USER,
        ]);
    }

    public function test_all_seeded_customers_can_log_in(): void
    {
        $this->seed(CustomerSeeder::class);

        $customerEmails = [
            'aurel@gmail.com',
            'zahra@gmail.com',
            'arjuna@gmail.com',
            'rizky@gmail.com',
            'nadia@gmail.com',
        ];

        foreach ($customerEmails as $email) {
            $customer = User::query()->where('email', $email)->firstOrFail();

            $response = $this->post(route('login'), [
                'email' => $email,
                'password' => 'password123',
            ]);

            $response->assertRedirect(route('customer.index', absolute: false));
            $this->assertAuthenticatedAs($customer);

            $this->post(route('logout'));
        }
    }
}
