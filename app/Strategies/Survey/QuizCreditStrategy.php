<?php

namespace App\Strategies\Survey;

use App\Lib\Manychat;
use App\Models\Credit;
use App\Models\HistoryLog;
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
            'surevey_recomendacion_amigos' => $request->surevey_recomendacion_amigos,
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
        $get_survey = Survey::where($data_survey)->count();
        if ($get_survey == 0) {
            $survey = new Survey($data_survey);
            $survey->save();
            HistoryLog::move($request->credit_id, HistoryLog::KC_AFTER_MARKET_ARCHIVE, HistoryLog::KC_AFTER_MARKET_ARCHIVE);
            HistoryLog::where(['id_rel' => $request->credit_id, 'status_id' => HistoryLog::KC_AFTER_MARKET, 'status' => 1])
                        ->update(['status' => 0]);
            HistoryLog::updateStatusProgress(HistoryLog::KC_AFTER_FORM, $request->credit_id, 1);

            $credit             = Credit::find($request->credit_id);
            $manychat_id = $credit->manychat_id;
            if ($manychat_id  != null) {
                $many_chat = new Manychat();
                $many_chat->addTag('EncuestaRespondida', $manychat_id);
            }
            
        }
    }

    public function get($credit_id)
    {
        $data_survey = array(
            'credit_id' => $credit_id,
            'id_survey' => 1,
            'origin' => 1,
        );
        $get_survey = Survey::where($data_survey)->first();
        if ($get_survey != null) {
            $answer = json_decode($get_survey->answer);
            return array(
                'surevey_credit_delivery' => $answer->surevey_credit_delivery,
                'surevey_kc_attention' => $answer->surevey_kc_attention,
                'surevey_financial_attention' => $answer->surevey_financial_attention,
                'surevey_recomendacion_amigos' => $answer->surevey_recomendacion_amigos,
                'survey_note' => $answer->survey_note,
            );
        }
        return null;
    }
}
