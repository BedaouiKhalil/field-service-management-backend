<?php

namespace App\Constants;

class Permissions
{
    public const VIEW_CUSTOMER = 'view_customer';
    public const MANAGE_CUSTOMER = 'manage_customer';

    public static function labels(): array
    {
        return [
            self::VIEW_CUSTOMER => 'View Customer',
            self::MANAGE_CUSTOMER => 'Manage Customer',
        ];
    }

    public static function label(string $permission): string
    {
        return self::labels()[$permission] ?? ucfirst(str_replace('_', ' ', $permission));
    }
}
