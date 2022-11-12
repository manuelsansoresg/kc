<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $fillable = [
        'credit_id',
        'answer',
        'id_survey',
        'origin',
    ];

    public function surveyCredit()
    {
        return $this->belongsTo(Credit::class, 'credit_id');
    }
}
