<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditReference extends Model
{
    use HasFactory;
    protected $fillable = [
        'credit_id',
        'last_name',
        'second_lastname',
        'names',
        'relationship',
        'relationship_time_years',
        'relationship_time_months',
        'cel_phone',
        'local_phone',
        'contact_time',
        'postal_code',
        'street',
        'home_external_number',
        'home_internal_number',
        'colony',
        'city',
        'state',
        'country',
        'note',
    ];
}
