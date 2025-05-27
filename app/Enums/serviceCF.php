<?php

namespace App\Enums;

enum ServiceCF: string
{
    case PUNCTUALITY = 'punctuality';
    case KNOWLEDGE_EXPERTISE = 'knowledge_expertise';
    case PRESENTATION_EXPLANATION = 'presentation_explanation';
    case PROBLEM_SOLVING_EFFICIENCY = 'problem_solving_efficiency';
    case OVERALL_SATISFACTION = 'overall_satisfaction';

    public function label(): string
    {
        return match ($this) {
            self::PUNCTUALITY => 'Punctuality',
            self::KNOWLEDGE_EXPERTISE => 'Knowledge & Expertise',
            self::PRESENTATION_EXPLANATION => 'Presentation & Explanation',
            self::PROBLEM_SOLVING_EFFICIENCY => 'Problem Solving & Efficiency',
            self::OVERALL_SATISFACTION => 'Overall Satisfaction',
        };
    }

    public static function fromKey(string $key): ?self
    {
        return self::tryFrom($key);
    }
}
