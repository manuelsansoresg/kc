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
            $product = $lead->productLead;
            //* add clientslog archive conversion
            $request = new stdClass();
            $request->data = array(
                'reason' => 4 //* enums reason_archive
            );
            HistoryLog::move($lead->id, HistoryLog::LEAD_ARCHIVE, HistoryLog::CREATE_PROSPECT, $request);

            //* Execute notification in add lead
           /*  $notification_add   = SendNotificationsValues::STRATEGY['btnNextLead'];
            (new $notification_add)->send($lead->id); */

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
            //*in progress
            HistoryLog::move($credit->id, HistoryLog::CREDIT_IN_PROGRESS, HistoryLog::CREDIT_IN_PROGRESS);
            
            //* enter module kc-checkup and list actions
            if ($product->c_product_id = 1 && $product->c_service_id == 1) {
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP, HistoryLog::KC_CHECK_UP);
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_ACTION_UPLOAD, HistoryLog::KC_CHECK_UP_ACTION_UPLOAD);
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_ACTION_FORM, HistoryLog::KC_CHECK_UP_ACTION_FORM);
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_ACTION_DESITION, HistoryLog::KC_CHECK_UP_ACTION_DESITION);
                //* Execute notification in new credit
                $notification   = SendNotificationsValues::STRATEGY['pushNewCreditKcCheckUp'];
                (new $notification)->send($credit->id);
            } elseif ($product->c_product_id = 1 && $product->c_service_id == 2) {
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION);
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_UPLOAD, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_UPLOAD);
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM);
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION);
                //* Execute notification in new credit
                $notification   = SendNotificationsValues::STRATEGY['pushNewCreditKcCheckUp'];
                (new $notification)->send($credit->id);
            }
        }
    }
}
