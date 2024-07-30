<?php

namespace App\Enums;

use App\Traits\EnumValues;

enum UserRole: string
{
    use EnumValues;

    case Admin = 'admin';
    case Collaborator = 'collaborator';
    case Viewer = 'viewer';
}
