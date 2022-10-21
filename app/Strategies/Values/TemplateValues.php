<?php

namespace App\Strategies\Values;

use App\Strategies\Templates\ControlDeskStrategyTemplate;
use App\Strategies\Templates\DebtCreditStrategyTemplate;
use App\Strategies\Templates\LeadStrategyTemplate;
use App\Strategies\Templates\NewCreditStrategyTemplate;

final class TemplateValues
{
    const STRATEGY = [
        'lead' => LeadStrategyTemplate::class,
        'newCredit' => NewCreditStrategyTemplate::class,
        'debtCredit' =>DebtCreditStrategyTemplate::class,
        'controlDesk' =>ControlDeskStrategyTemplate::class,
    ];
}
