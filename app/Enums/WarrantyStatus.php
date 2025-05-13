<?php

namespace App\Enums;

enum WarrantyStatus :String
{
    case Yes = 'yes';
    case No = 'no';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return collect(self::cases())->pluck('value', 'value')->toArray();
    }
}
