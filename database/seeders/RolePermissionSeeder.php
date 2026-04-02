<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Constants\Roles;
use App\Constants\Permissions;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::findByName(Roles::ADMIN);
        $admin->syncPermissions(array_keys(Permissions::labels()));
    }
}
