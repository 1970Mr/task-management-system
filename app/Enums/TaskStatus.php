<?php

namespace App\Enums;

use App\Traits\EnumValues;

enum TaskStatus: string
{
    use EnumValues;

    case Active = 'active';
    case Completed = 'completed';
    case Inactive = 'inactive';
}
