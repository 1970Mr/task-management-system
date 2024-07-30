<?php

namespace App\Traits;

trait EnumValues
{
    public static function values(): array
    {
        return array_map(static fn ($item) => $item->value, self::cases());
    }
}
