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
}
