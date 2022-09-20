<?php

namespace App\Strategies\Values;

use App\Strategies\Notifications\PushBtnNextLead;
use App\Strategies\Notifications\PushDebtReduction;
use App\Strategies\Notifications\PushLeadAddProspect;
use App\Strategies\Notifications\PushLeadNewProspect;
use App\Strategies\Notifications\PushnewCredit;

final class SendNotificationsValues
{
    const STRATEGY = [
        'leadNewProspect' => PushLeadNewProspect::class,
        'leadAddProspect' => PushLeadAddProspect::class,
        'btnNextLead' => PushBtnNextLead::class,
        'newCredit' => PushnewCredit::class,
        'debtReduction' => PushDebtReduction::class,
    ];
}
