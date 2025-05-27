<?php

namespace App\Enums;

enum InstallationCF: string
{
    case PUNCTUALITY = 'punctuality';
    case KNOWLEDGE_ATTITUDE = 'knowledge_attitude';
    case PRESENTATION_EXPLANATION = 'presentation_explanation';
    case OVERALL_RATINGS = 'overall_ratings';

    public function label(): string
    {
        return match($this) {
            self::PUNCTUALITY => 'Punctuality',
            self::KNOWLEDGE_ATTITUDE => 'Knowledge & Attitude',
            self::PRESENTATION_EXPLANATION => 'Presentation & Explanation',
            self::OVERALL_RATINGS => 'Overall Ratings',
        };
    }

    public static function fromKey(string $key): ?self
    {
        return self::tryFrom($key);
    }
}

