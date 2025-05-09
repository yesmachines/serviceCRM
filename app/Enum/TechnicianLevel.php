<?php

namespace App\Enum;

enum TechnicianLevel: string
{
    case Senior = 'senior';
    case Junior = 'junior';

    public static function options(): array
    {
        return [
            self::Senior->value => 'Senior',
            self::Junior->value => 'Junior',
        ];
    }
}
