<?php
namespace App\Strategies\ValidateStages;

use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\LeadClient;
use App\Models\LeadValidation;
use App\Models\SodScheduleName;
use App\Strategies\ValidateStagesInterface;

class LeadStrategy implements ValidateStagesInterface
{
    public function getValidate($lead_id)
    {
        $validate = LeadValidation::getValidationsByLeadId($lead_id);
        return $validate;
    }

    public function listValidate($lead_id)
    {
        $lead             = Lead::find($lead_id);
        $client_person_id = $lead->client_person_id;
        $financial_product_id = $lead->financial_product_id;
        $agreement_id = $lead->agreement_id;
        $clientPerson = ClientPerson::find($lead->client_person_id);
        $getSodName = SodScheduleName::find($agreement_id);
        $financialProduct = FinancialProduct::find($financial_product_id);
        $validateSod = Lead::validateSod($clientPerson, $financialProduct);
        
        $statusTramites = array(
            HistoryLog::KC_CHECK_UP ,
            HistoryLog::CREDIT_IN_PROGRESS ,
            HistoryLog::NEW_CREDIT_KC_CHECK_UP ,
            HistoryLog::KC_CONTROL_DESK ,
            HistoryLog::KC_DELIVERY ,
            HistoryLog::KC_SWAP ,
            HistoryLog::KC_PAYMENT
        );
        $getStatus = $clientPerson != null ? Credit::where('client_person_id', $clientPerson->id)->whereIn('credit_status', $statusTramites)->count() : 0;
        $creditStatus =  $getStatus > 0 ? false : true;
        $nombreCliente = $clientPerson!= null ? $clientPerson->name.' '.$clientPerson->last_name.' '.$clientPerson->second_last_name : null;

        $errors =  \View::make('panel.lead.list_validate', ['lead' => $lead, 'nombreCliente' => $nombreCliente, 'clientPerson' => $clientPerson, 'getSodName' => $getSodName, 'creditStatus' => $creditStatus, 'financialProduct' => $financialProduct, 'validateSod' => $validateSod])->render();
        
        return $errors;
    }
}
