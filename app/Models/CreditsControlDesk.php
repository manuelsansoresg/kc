<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditsControlDesk extends Model
{
    use HasFactory;
    protected $table = 'credits_control_desk';
    protected $fillable = [
        'credit_id',
        'id_validation',
        'status',
        'mandatory',
    ];

    public static $label_status = [
        1 => 'id_valid',

        1 => 'payroll_ownership',
        
        1 => 'last_payroll_validity',
        
        1 => 'payroll_payment_capacity',
        
        1 => 'credit_viability',
        
        1 => 'clabe_ownership',
        
        1 => 'payoff_on_time_«ID»',
        
        1 => 'payoff_ownership_«ID»',

    ];
}
