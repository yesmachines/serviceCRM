<?php

namespace App\Enums;

enum TechnicianLevel: string {

    case SENIOR = 'senior';
    case JUNIOR = 'junior';

    // Human-readable label
    public function label(): string {
        return match ($this) {
            self::SENIOR => 'Senior',
            self::JUNIOR => 'Junior'
        };
    }

    // Get the array representation of the enum
    public static function toArray(): array {
        return [
            'senior' => self::SENIOR,
            'junior' => self::JUNIOR
        ];
    }

    // Static method to return the list of key-label pairs
    public static function toKeyLabelArray(): array {
        return array_map(fn($case) => [
            'key' => $case->value,
            'label' => $case->label(),
                ], self::cases());
    }

    public static function keyValueArray(): array {
        return array_reduce(
                self::cases(),
                fn($carry, $case) => $carry + [$case->value => $case->label()],
                []
        );
    }
}
