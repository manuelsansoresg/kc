<?php

namespace App\Strategies\Values;

use App\Strategies\Templates\AfterMarketStrategyTemplate;
use App\Strategies\Templates\ControlDeskStrategyTemplate;
use App\Strategies\Templates\DebtCreditStrategyTemplate;
use App\Strategies\Templates\DeliveryStrategyTemplate;
use App\Strategies\Templates\KCWalletAddStregegyTemplate;
use App\Strategies\Templates\LeadStrategyTemplate;
use App\Strategies\Templates\NewCreditStrategyTemplate;
use App\Strategies\Templates\PaymentStrategyTemplate;
use App\Strategies\Templates\SwapStrategyTemplate;

final class TemplateValues
{
    const STRATEGY = [
        'lead' => LeadStrategyTemplate::class,
        'newCredit' => NewCreditStrategyTemplate::class,
        'debtCredit' =>DebtCreditStrategyTemplate::class,
        'controlDesk' =>ControlDeskStrategyTemplate::class,
        'delivery' => DeliveryStrategyTemplate::class,
        'afterMarket' => AfterMarketStrategyTemplate::class,
        'swap' => SwapStrategyTemplate::class,
        'payment' => PaymentStrategyTemplate::class,
        'wallet' => KCWalletAddStregegyTemplate::class,
    ];
}
