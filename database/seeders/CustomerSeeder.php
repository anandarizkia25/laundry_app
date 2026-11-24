<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['name' => 'Aurellia Kalila', 'email' => 'aurel@gmail.com'],
            ['name' => 'Zahra Millan', 'email' => 'zahra@gmail.com'],
            ['name' => 'Arjuna Haidar', 'email' => 'arjuna@gmail.com'],
            ['name' => 'Nur Rizky', 'email' => 'rizky@gmail.com'],
            ['name' => 'Nadia Miranti', 'email' => 'nadia@gmail.com'],
            // Akun testing compatibility
            ['name' => 'Budi Santoso', 'email' => 'customer1@example.com'],
            ['name' => 'Siti Aminah', 'email' => 'customer2@example.com'],
            ['name' => 'Andi Wijaya', 'email' => 'customer3@example.com'],
            ['name' => 'Dewi Lestari', 'email' => 'customer4@example.com'],
            ['name' => 'Rudi Hartono', 'email' => 'customer5@example.com'],
        ];

        foreach ($customers as $customerData) {
            $customer = User::updateOrCreate(
                ['email' => $customerData['email']],
                [
                    'name' => $customerData['name'],
                    'password' => 'password123',
                ],
            );

            $customer->role = User::ROLE_USER;
            $customer->email_verified_at = now();
            $customer->save();
        }
    }
}
