<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadValidation extends Model
{
    use HasFactory;
    protected $table = 'leads_validations';
    protected $fillable = [
        'lead_id',
        'validation',
        'status',
        'texto',
    ];

    public static function saveEdit($leadId, $validation, $status, $texto = null)
    {
        $getValitation = LeadValidation::where([
            'lead_id' => $leadId,
            'validation' => $validation,
        ]);

        if ($getValitation->count() == 0) {
            LeadValidation::create([
                'lead_id' => $leadId,
                'validation' => $validation,
                'status' => $status,
                'texto' => $texto,
            ]);
        } else{
            $getValitation->update([
                'status' => $status,
                'texto' => $texto,
            ]);
        }
    }

    public static function getValidationsByLeadId($leadId)
    {
        return LeadValidation::where('lead_id', $leadId)->get();
    }

    public static function getStatusByLeadId($leadId){
        $headers = array(
            'Prospecto - Celular',
            'Prospecto - RFC',
            'Prospecto - Cliente activo',
            'Crédito preautorizado - Trámite pendiente',
            'Crédito preautorizado - SOD activo', 
            'Crédito preautorizado - SOD en rango de fechas permitidas',
            'Crédito preautorizado - Crédito personal activo',
            'Crédito preautorizado - Capacidad de pago mínima',
            'Crédito seleccionado - Plazo seleccionado',
            'Crédito seleccionado - Importe seleccionado',
            'Crédito preautorizado - Trámite SOD autorizado',
            'Crédito preautorizado - Producto permite Crédito adicional',
            'Crédito preautorizado - Producto permite Refinanciamiento',
            'Crédito preautorizado - Producto permite Crédito adicional',
            'Crédito preautorizado - Producto permite Refinanciamiento',
        );

        $validations = LeadValidation::where('lead_id', $leadId)->get();
        $validateMonto = false;
        
        // Check phone or RFC validation (at least one should be valid)
        $phoneOrRfcValid = false;
        foreach ($validations as $validation) {
           /*  if ($validation->validation == 'Prospecto - Celular' || $validation->validation == 'Prospecto - RFC') {
                if ($validation->status == 1) {
                    $phoneOrRfcValid = true;
                    break;
                }
            } */
            if ($validation->validation == 'Crédito seleccionado - Importe seleccionado') {
                if ($validation->status == 1) {
                    $validateMonto = true;
                    break;
                }
            }
        }

        // Check that all existing validations have status = 1
        $allValid = true;
        foreach ($validations as $validation) {
            if ($validation->status != 1) {
                $allValid = false;
                break;
            }
        }

        return $validateMonto;
    }
}
