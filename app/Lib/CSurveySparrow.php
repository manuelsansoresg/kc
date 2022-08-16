<?php
namespace App\Lib;

use Error;
use Illuminate\Support\Facades\Http;

require '../vendor/autoload.php';

class CSurveySparrow
{
    public $access_token;
    public $url;
    public $url_contact;
    public $url_responses;
    
    public function __construct()
    {
        $this->access_token   = 'prNO8aywMI6b5mixEQ7w8uTYe3WtqHU3ENpVxqdyRW6H9_Lj7qo9M3UkjqEc_op9YgbgZgDfWCnvX2ZFi_eoWhYQ';
        $this->url            = 'https://api.surveysparrow.com/v3/surveys';
        $this->url_contact    = 'https://api.surveysparrow.com/v3/contacts';
        $this->url_responses  = 'https://api.surveysparrow.com/v3/responses';
    }

    public function createSurvey($name)
    {
        $data = array(
            'survey_type' => 'ClassicForm',
            'name' => $name,
        );
        
        $survey = Http::withHeaders([
            'Authorization' => ' Bearer '.$this->access_token
        ])
        ->post($this->url, $data)->body();
        return $survey;
    }
    
    public function getAllContact()
    {
        $survey = Http::withHeaders([
            'Authorization' => ' Bearer '.$this->access_token
        ])
        ->get($this->url)->body();
        return $survey;
    }

    public function getAllResponse()
    {
        $data = array('survey_id' => 313345);
        $survey = Http::withHeaders([
            'Authorization' => ' Bearer '.$this->access_token
        ])
        ->get($this->url_responses, $data)->body();
        return $survey;
    }
}
