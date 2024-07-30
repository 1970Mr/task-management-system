<?php

namespace App\Enums;

use App\Traits\EnumValues;

enum TaskPriority: string
{
    use EnumValues;

    case High = 'high';
    case Medium = 'medium';
    case Low = 'low';
}
