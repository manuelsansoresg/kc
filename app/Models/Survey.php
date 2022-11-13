<?php

namespace App\Models;

use App\Strategies\Values\SurveyValues;
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

    public function getQuiz($credit_id)
    {
        $strategy_survey    = SurveyValues::STRATEGY['credit'];
        $get_survey         = (new $strategy_survey)->get($credit_id);
        return $get_survey;
    }

    public function surveyCredit()
    {
        return $this->belongsTo(Credit::class, 'credit_id');
    }
}
