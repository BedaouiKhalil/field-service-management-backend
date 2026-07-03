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

        $supportAgent = Role::findByName(Roles::SUPPORT_AGENT);
        $supportAgent->syncPermissions([
            Permissions::VIEW_CUSTOMER,
            Permissions::MANAGE_CUSTOMER,
            Permissions::VIEW_TASK,
            Permissions::MANAGE_TASK,
        ]);

        $techician = Role::findByName(Roles::TECHNICIAN);
        $techician->syncPermissions([
            Permissions::VIEW_CUSTOMER,
            Permissions::VIEW_TASK,
            Permissions::MANAGE_TASK,
            Permissions::UPDATE_TASK_STATUS,
        ]);
    }
}
