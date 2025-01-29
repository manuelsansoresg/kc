<?php
namespace App\Strategies\ValidateStages;

use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\LeadClient;
use App\Models\SodScheduleName;
use App\Strategies\ValidateStagesInterface;

class LeadStrategy implements ValidateStagesInterface
{
    public function getValidate($lead_id)
    {
        $get_lead             = Lead::find($lead_id);
        $error                = false;
        $error_organization   = false;
        $error_email          = false;
        $error_rfc          = false;
        $error_product        = false;
        $error_tipo_producto   = false;
        $error_viabilidad   = false;

        $errors = array();

        if ($get_lead != null) {
            $get_account          = LeadClient::where('lead_id', $get_lead->id)->count();
            
            if ($get_lead->agreement_id === null || $get_lead->agreement_id === 0) {
                $error_organization = true;
            }
            
            if ($get_lead->product_id == null || $get_lead->product_id === 0) {
                $error_product = true;
            }
            
            if ($get_lead->applied_financial_product === null) {
                $error_tipo_producto = true;
            }
            if ($get_lead->email === null) {
                $error_email = true;
            }
            
            if ($get_lead->rfc === null) {
                $error_rfc = true;
            }
            
    
            /* if ($error_organization == true || $error_product == true || $error_tipo_producto == true || $error_email == true) {
                $error = true;
            } */
            
            if ($error_organization == true || $error_product == true || $error_tipo_producto == true) {
                $error = true;
            }
            
            if ($get_lead->is_viability !== 1 || $get_lead->is_viability_credit  !== 1) {
                $error_viabilidad = true;
            }

            //dd($get_lead->is_viability, $get_lead->is_viability_credit, $error_viabilidad);

            $errors = array(
                'Servicio KC' => $error_product,
                'Producto financiero' => $error_tipo_producto,
                'Organización' => $error_organization,
                'Email' => $error_email,
                'RFC' => $error_rfc,
                'Viabilidad' => $error_viabilidad,
            );
        }
        $data_error = array(
            'error' => $error,
            'table' => $errors
        );
        return $data_error;
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
