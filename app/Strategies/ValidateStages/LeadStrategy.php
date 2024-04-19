<?php
namespace App\Strategies\ValidateStages;

use App\Models\Lead;
use App\Models\LeadClient;
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
        $error_tipo_credito   = false;
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
            
            if ($get_lead->tipo_credito === null) {
                $error_tipo_credito = true;
            }
            if ($get_lead->email === null) {
                $error_email = true;
            }
            
            if ($get_lead->rfc === null) {
                $error_rfc = true;
            }
            
    
            /* if ($error_organization == true || $error_product == true || $error_tipo_credito == true || $error_email == true) {
                $error = true;
            } */
            
            if ($error_organization == true || $error_product == true || $error_tipo_credito == true) {
                $error = true;
            }
            
            if ($get_lead->is_viability != 1 && $get_lead->is_viability_credit != 1) {
                $error_viabilidad = true;
            }

            $errors = array(
                'Servicio KC' => $error_product,
                'Tipo de  crédito' => $error_tipo_credito,
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
}
