<?php
namespace App\Lib;

use Illuminate\Support\Facades\Http;

class CNubarium
{

    public function validateCurp($curp)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://curp.nubarium.com/renapo/v2/valida_curp',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_USERPWD => "nubarium:_nub4r1mp4ssw0rd",
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "documento": "0",
            "curp": "RAZR811011HVZMPB01",
            "Username: "nubarium",
            "Password: "_nub4r1mp4ssw0rd",
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
