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
        $errors = array();

        if ($get_lead != null) {
            $get_account          = LeadClient::where('lead_id', $get_lead->id)->count();
            
            if ($get_lead->agreement_id === null || $get_lead->agreement_id === 0) {
                $error_organization = true;
            }
            
            if ($get_lead->product_id == null || $get_lead->product_id === 0) {
                $error_product = true;
            }
            
           
    
            if ($error_organization == true || $error_product == true) {
                $error = true;
            }

            

            $errors = array(
                'Organización' => $error_organization,
                'Producto' => $error_product,
            );
        }
        $data_error = array(
            'error' => $error,
            'table' => $errors
        );
        return $data_error;
    }
}
