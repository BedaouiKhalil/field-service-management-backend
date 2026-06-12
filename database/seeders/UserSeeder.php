<?php

namespace Database\Seeders;

use App\Models\User;
use App\Constants\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'first_name' => 'admin',
                'last_name' => 'admin',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole(Roles::ADMIN);

        $super_agent = User::firstOrCreate(
            ['email' => 'agent@gmail.com'],
            [
                'first_name' => 'support Agent',
                'last_name' => 'support Agent',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        $super_agent->assignRole(Roles::SUPPORT_AGENT);

        $technicians = User::factory()
            ->count(10)
            ->create();

        foreach ($technicians as $technician) {
            $technician->assignRole(Roles::TECHNICIAN);
        }
    }
}
