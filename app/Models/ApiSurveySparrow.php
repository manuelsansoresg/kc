<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiSurveySparrow extends Model
{
    use HasFactory;
    protected $table = 'api_surveysparrows';
    protected $fillable = [
        'model_id',
        'state',
        'response',
        'status'
    ];

    const MODEL = [
        'survey' => 1,
    ];
    const STATE = [
        1 => 'Formulario alta prospecto',
    ];
}
