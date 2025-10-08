<?php

namespace App\Constants;

class Roles
{
    public const ADMIN = 'admin';
    public const SUPPORT_AGENT = 'support_agent';
    public const FIELD_TECHNICIAN = 'field_technician';

    public static function labels(): array
    {
        return [
            self::ADMIN => 'Admin',
            self::SUPPORT_AGENT => 'Support Agent',
            self::FIELD_TECHNICIAN => 'field technician',
        ];
    }

    public static function label(string $role): string
    {
        return self::labels()[$role] ?? ucfirst(str_replace('_', ' ', $role));
    }
}
