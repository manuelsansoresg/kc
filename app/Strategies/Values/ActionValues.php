<?php

namespace App\Strategies\Values;

use App\Strategies\Actions\CreditStrategy;
use App\Strategies\Actions\LeadStrategy;

final class ActionValues
{
    const STRATEGY = [
        'lead' => LeadStrategy::class,
        'credit' => CreditStrategy::class,
    ];
}
