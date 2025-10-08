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
        $super_agent = User::firstOrCreate(
            ['email' => 'agent@gmail.com'],
            [
                'name' => 'support Agent',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        $super_agent->assignRole(Roles::SUPPORT_AGENT);

        $field_technician = User::firstOrCreate(
            ['email' => 'technician@gmail.com'],
            [
                'name'=> 'technician',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        $field_technician->assignRole(Roles::FIELD_TECHNICIAN);
    }
}
