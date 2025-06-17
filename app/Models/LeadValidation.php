<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadValidation extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'validation',
        'status',
    ];

    public static function saveEdit($leadId, $text, $status)
    {
        $getValitation = LeadValidation::where([
            'lead_id' => $leadId,
            'validation' => $text,
        ]);

        if ($getValitation->count() == 0) {
            LeadValidation::create([
                'lead_id' => $leadId,
                'validation' => $text,
                'status' => $status,
            ]);
        } else{
            $getValitation->update([
                'status' => $status,
            ]);
        }
    }
}
