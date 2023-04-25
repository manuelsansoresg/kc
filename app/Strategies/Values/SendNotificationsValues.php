<?php

namespace App\Strategies\Values;

use App\Strategies\Notifications\Notification;
use App\Strategies\Notifications\PushBtnNextLead;
use App\Strategies\Notifications\PushCreditKcControlDesk;
use App\Strategies\Notifications\PushCreditKcDelivery;
use App\Strategies\Notifications\PushCreditKcPayment;
use App\Strategies\Notifications\PushCreditKcSwap;
use App\Strategies\Notifications\PushDebtReduction;
use App\Strategies\Notifications\PushLeadAddProspect;
use App\Strategies\Notifications\PushLeadNewProspect;
use App\Strategies\Notifications\PushnewCredit;
use App\Strategies\Notifications\PushNewCreditKcCheckUp;

final class SendNotificationsValues
{
    const STRATEGY = [
        'leadNewProspect' => PushLeadNewProspect::class,
        'leadAddProspect' => PushLeadAddProspect::class,
        'btnNextLead' => PushBtnNextLead::class, // P03
        'newCredit' => PushnewCredit::class, // A01, A03
        'debtReduction' => PushDebtReduction::class, // A01, A03
        'pushNewCreditKcCheckUp' => PushNewCreditKcCheckUp::class, // M01, M02
        'pushCreditKcControlDesk' => PushCreditKcControlDesk::class, // M03, M04
        'pushCreditKcDelivery' => PushCreditKcDelivery::class, // M05, M06
        'pushCreditKcSwap' => PushCreditKcSwap::class, // M05, M06
        'pushCreditKcPayment' => PushCreditKcPayment::class, // M05, M06
    ];
}
