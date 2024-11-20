<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorsAgreement extends Model
{
    use HasFactory;
    protected $fillable = [
        'agreement_id',
        'investor_id'
    ];
}
