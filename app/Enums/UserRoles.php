<?php

namespace App\Enums;

enum UserRoles: string
{
    case Admin = 'admin';
    case Collaborator = 'collaborator';
    case Viewer = 'viewer';

    public static function values(): array
    {
        return array_map(static fn ($item) => $item->value, self::cases());
    }
}
