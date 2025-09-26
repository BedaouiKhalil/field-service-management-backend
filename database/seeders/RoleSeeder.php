<?php

namespace Database\Seeders;

use App\Constants\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ------------------------------------------------------
        // Array of roles to seed into the database
        // Each item is an associative array:
        // 'name'       => role name
        // 'guard_name' => guard ('web' or 'api')
        // ------------------------------------------------------
        $roles = [
            ['name' => Roles::SUPPORT_AGENT, 'guard_name' => 'web'],
            // To add a new role, just add a new line:
            // ['name' => 'roleName', 'guard_name' => 'guardName'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role['name'],
                'guard_name' => $role['guard_name'],
            ]);
        }
    }
}
