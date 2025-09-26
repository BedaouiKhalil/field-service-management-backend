<?php

namespace App\Constants;

class Roles
{
    public const SUPPORT_AGENT = 'support_agent';
    public const ADMIN = 'admin';

    public static function labels(): array
    {
        return [
            self::SUPPORT_AGENT => 'Support Agent',
            self::ADMIN => 'Admin',
        ];
    }

    public static function label(string $role): string
    {
        return self::labels()[$role] ?? ucfirst(str_replace('_', ' ', $role));
    }
}
