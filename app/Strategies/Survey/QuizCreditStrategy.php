<?php

namespace App\Strategies\Survey;

use App\Models\Survey;
use App\Strategies\SurveyInterface;

class QuizCreditStrategy implements SurveyInterface
{

    public function getQuiz($request)
    {
        return array(
            'surevey_credit_delivery' => $request->surevey_credit_delivery,
            'surevey_kc_attention' => $request->surevey_kc_attention,
            'surevey_financial_attention' => $request->surevey_financial_attention,
            'survey_note' => $request->survey_note,
        );
    }

    public function add($request)
    {
        $data = self::getQuiz($request);
        $data_survey = array(
            'credit_id' => $request->credit_id,
            'answer' => json_encode($data),
            'id_survey' => 1,
            'origin' => 1,
        );
        $survey = new Survey($data_survey);
        $survey->save();
    }
}
