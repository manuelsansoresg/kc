<?php

namespace App\Strategies\Templates;

use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Strategies\TemplateInterface;
use App\Strategies\Values\SendNotificationsValues;
use stdClass;

class LeadStrategyTemplate implements TemplateInterface
{
    public function move($id)
    {
        $lead = Lead::find($id);
        if ($lead !== null) {
            //* add clientslog archive conversion
            $request = new stdClass();
            $request->data = array(
                'reason' => 4 //* enums reason_archive
            );
            HistoryLog::move($lead->id, HistoryLog::LEAD_ARCHIVE, HistoryLog::LEAD_ARCHIVE, $request);

            //* Execute notification in add lead
            $notification_add   = SendNotificationsValues::STRATEGY['btnNextLead'];
            (new $notification_add)->send($lead->id);

            //* create client_person
            $data_client_person = array(
                'name' => $lead->name,
                'last_name' => $lead->last_name,
                'second_last_name' => $lead->second_last_name,
                'cellphone' => $lead->cellphone,
                'email' => $lead->email,
                'agreement_id' => $lead->agreement_id,
            );
            $client_person = ClientPerson::create($data_client_person);

            //* create credit
            $data_lead = array(
                'client_person_id' => $client_person->id,
                'product_id' => $lead->product_id,
                'financial_id' => $lead->financial_id,
                'agreement_id' => $lead->agreement_id,
                'origin_id' => $lead->origin_id,
                'channel_id' => $lead->channel_id,
                'type_id' => $lead->type_id,
                'asesor_id' => $lead->asesor_id,
            );
            $credit = Credit::create($data_lead);
            //* create history in client person
            HistoryLog::move($client_person->id, HistoryLog::LEAD_CONVERT, HistoryLog::LEAD_CONVERT);
            //* create history in credit
            HistoryLog::move($credit->id, HistoryLog::CREATE_CLIENT_PERSON, HistoryLog::CREATE_CLIENT_PERSON);
            //* enter module kc-checkup and list actions
            HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP, HistoryLog::KC_CHECK_UP);
            HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_ACTION_UPLOAD, HistoryLog::KC_CHECK_UP_ACTION_UPLOAD);
            HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_ACTION_FORM, HistoryLog::KC_CHECK_UP_ACTION_FORM);
        }
    }
}
