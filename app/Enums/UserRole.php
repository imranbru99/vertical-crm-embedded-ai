<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case Manager = 'manager';
    case Staff = 'staff';
    case Client = 'client';
    case Demo = 'demo';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Admin => 'Admin',
            self::Manager => 'Manager',
            self::Staff => 'Staff',
            self::Client => 'Client',
            self::Demo => 'Demo',
        };
    }

    public function canAccessAdmin(): bool
    {
        return in_array($this, [
            self::SuperAdmin,
            self::Admin,
            self::Manager,
            self::Staff,
            self::Demo,
        ], true);
    }
}
