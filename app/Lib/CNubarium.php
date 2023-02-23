<?php
namespace App\Lib;

use Illuminate\Support\Facades\Http;

class CNubarium
{

    public function validateCurp($curp)
    {
        $curl = curl_init();
        $username = 'yalku';
        $password = 'V2.B#w_8u';
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://curp.nubarium.com/renapo/v2/valida_curp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_USERPWD => "$username:$password",
            CURLOPT_POSTFIELDS =>'{
              "documento": "0",
              "curp": "'.$curp.'"
          }',
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json'
            ),
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);
          return json_decode($response);
    }
}
