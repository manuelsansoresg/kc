<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadClient extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'client_person_id',
        'status'
    ];
}
