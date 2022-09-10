<?php

namespace App\Strategies\Values;

use App\Strategies\Actions\CreditStrategy;
use App\Strategies\Actions\LeadStrategy;
use App\Strategies\Actions\ListStrategy;

final class ActionValues
{
    const STRATEGY = [
        'lead' => LeadStrategy::class,
        'credit' => CreditStrategy::class,
        'list' => ListStrategy::class,
    ];
}
