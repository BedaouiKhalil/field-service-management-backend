<?php

use App\Constants\Permissions;
use App\Constants\Roles;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = [
            Permissions::VIEW_CUSTOMER,
            Permissions::MANAGE_CUSTOMER,
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        $adminRole = Role::where('name', Roles::ADMIN)->first();

        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }
    }

    public function down(): void
    {
        $permissions = [
            Permissions::VIEW_CUSTOMER,
            Permissions::MANAGE_CUSTOMER,
        ];

        foreach ($permissions as $permission) {
            $permission = Permission::where('name', $permission)->first();

            if ($permission) {
                $permission->roles()->detach();
                $permission->delete();
            }
        }
    }
};
