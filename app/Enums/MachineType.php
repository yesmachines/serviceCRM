<?php

namespace App\Enums;

enum MachineType : string 
{

    case YM = 'YM';
    case nonYM = 'nonYM';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return collect(self::cases())->pluck('value', 'value')->toArray();
    }
   
}
