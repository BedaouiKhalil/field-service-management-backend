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
        $superAgent = User::firstOrCreate(
            ['email' => 'agent@gmail.com'],
            [
                'name' => 'support Agent',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        $superAgent->assignRole(Roles::SUPPORT_AGENT);
    }
}
