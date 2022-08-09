<?php

namespace App\Strategies\Values;

use App\Strategies\Notifications\PushLeadAddProspect;
use App\Strategies\Notifications\PushLeadNewProspect;

final class SendNotificationsValues
{
    const STRATEGY = [
        'leadNewProspect' => PushLeadNewProspect::class,
        'leadAddProspect' => PushLeadAddProspect::class,
    ];
}
