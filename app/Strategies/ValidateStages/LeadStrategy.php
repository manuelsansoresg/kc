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
        $error_product        = false;
        $error_account        = false;
        $error_adviser        = false;
        $errors = array();

        if ($get_lead != null) {
            $get_account          = LeadClient::where('lead_id', $get_lead->id)->count();
            
            if ($get_lead->agreement_id === null || $get_lead->agreement_id === 0) {
                $error_organization = true;
            }
            
            if ($get_lead->product_id == null || $get_lead->product_id === 0) {
                $error_product = true;
            }
            
            if ($get_account == 0) {
                $error_account = true;
            }

            if ($get_lead->asesor_id == null) {
                $error_adviser = true;
            }
    
            if ($error_organization == true || $error_product == true || $error_account == true  || $error_adviser == true) {
                $error = true;
            }

            

            $errors = array(
                'Organización' => $error_organization,
                'Producto' => $error_product,
                'Cuenta' => $error_account,
                'Asesor' => $error_adviser,
            );
        }
        $data_error = array(
            'error' => $error,
            'table' => $errors
        );
        return $data_error;
    }
}
