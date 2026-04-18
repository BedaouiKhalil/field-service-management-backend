<?php

namespace App\Constants;

class Permissions
{
    public const VIEW_CUSTOMER = 'view_customer';
    public const MANAGE_CUSTOMER = 'manage_customer';
    public const VIEW_USER = 'view_user';
    public const MANAGE_USER = 'manage_user';

    public static function labels(): array
    {
        return [
            self::VIEW_CUSTOMER => 'View customer',
            self::MANAGE_CUSTOMER => 'Manage customer',
            self::VIEW_USER => 'View user',
            self::MANAGE_USER => 'Manage user',
        ];
    }

    public static function label(string $permission): string
    {
        return self::labels()[$permission] ?? ucfirst(str_replace('_', ' ', $permission));
    }
}
