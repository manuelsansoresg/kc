<?php

namespace App\Lib;

use Illuminate\Support\Facades\Http;

class CNubarium
{

    public function setValidate($url, $params)
    {
        $curl = curl_init();
        $username = 'yalku';
        $password = 'V2.B#w_8u';
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_USERPWD => "$username:$password",
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public function validate($type, $params)
    {
        $result_validate    = null;
        $html               = null;
        $input_result       = null;
        
        switch ($type) {
            case 2:
                $data_params = '{"cic": "' . $params. '", "identificadorCiudadano": "098794022"
                }';

                $result_validate = self::setValidate('https://ine.nubarium.com/ine/v2/valida_ine', $data_params);
                $html = $result_validate->estatus == "OK" ? '<a class="text-primary" onclick="showKycCurp(2)" style="cursor:pointer"> Ver respuesta </a>' : '<span class="text-danger"> <em class="icon ni ni-alert"></em> Error verifica la información </span>';
                break;

            default:
                $data_params = '{
                    "documento": "0",
                    "curp": "' . $params. '"
                }';

                $result_validate = self::setValidate('https://curp.nubarium.com/renapo/v2/valida_curp', $data_params);
                $html = $result_validate->estatus == "OK" ? '<a class="text-primary" onclick="showKycCurp(1)" style="cursor:pointer"> Ver respuesta </a>' : '<span class="text-danger"> <em class="icon ni ni-alert"></em> Error verifica la información </span>';
                break;
        }
        
        $estatus = ($result_validate->estatus == "OK")? 0 : 1;
        $data_validate = array('html' => $html, 'estatus' => $estatus,
                            'result' => $result_validate);
        return $data_validate;
    }
}
