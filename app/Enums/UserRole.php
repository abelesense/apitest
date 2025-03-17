<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case GUEST = 'guest';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
