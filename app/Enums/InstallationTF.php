<?php

namespace App\Enums;

enum InstallationTF: string
{
    case INSPECTION = 'inspection';
    case TO_QUANTITY = 'to_quantity';
    case VISUAL = 'visual';
    case EXPLANATION_PRODUCTS = 'explanation_products';
    case INSTALLATION = 'installation';
    case STARTUP_TRAINING = 'startup_training';
    case DOS_DONTS = 'dos_donts';
    case SAFETY_MEASURES = 'safety_measures';

    public function label(): string
    {
        return match ($this) {
            self::INSPECTION => 'Inspection',
            self::TO_QUANTITY => 'To Quantity',
            self::VISUAL => 'Visual',
            self::EXPLANATION_PRODUCTS => 'Explanation On Products',
            self::INSTALLATION => 'Installation',
            self::STARTUP_TRAINING => 'Start up & Training',
            self::DOS_DONTS => "Do's & Don'ts",
            self::SAFETY_MEASURES => 'Safety Measures',
        };
    }

    public static function fromKey(string $key): ?self
    {
        return self::tryFrom($key);
    }
}

