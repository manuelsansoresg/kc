<?php

namespace App\Strategies\Values;

use App\Strategies\Survey\QuizCreditStrategy;
use App\Strategies\ValidateStages\LeadStrategy;

final class SurveyValues
{
    const STRATEGY = [
        'credit' => QuizCreditStrategy::class,
    ];
}
