<?php
namespace App\Lib;

class Manychat
{

    private $token = '861553:f8756129f4f78730b10f9acdeaacf5bd';
    private $tags = array(
        'Prospecto' => 40308012
    );

    private function setCurl($path, $data = null , $method = 'POST')
    {
        $url = 'https://api.manychat.com/fb/'.$path;
        $json_data = json_encode($data);

        // Configuración de la solicitud cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data != null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $this->token"
        ]);
    
        // Ejecutar la solicitud cURL y obtener la respuesta
        $response = curl_exec($ch);
    
        // Verificar si hubo algún error
        if (curl_errno($ch)) {
            echo 'Error en la solicitud cURL: ' . curl_error($ch);
        }
    
        // Cerrar la sesión cURL
        curl_close($ch);
    
        // Retornar la respuesta de la API
        return $response;
    }


    public function findByName ($name)
    {
        $encodedName = urlencode($name);
        $get_info =  json_decode(self::setCurl('subscriber/findByName?name='.$encodedName, null, 'GET'));
        if ($get_info->status == 'success' && count($get_info->data)> 0) {
            return $get_info->data;
        }
        return false;
    }

    public function altaUsuario($data) {
        
         return self::setCurl('subscriber/createSubscriber', $data);
    }

    public function setCustomFields($data, $subscriber_id)
    {
        $fields = array();
        foreach ($data as $key => $data) {
            $fields[] = array(
                'field_id' => config('enums.custom_fields_many_chat')[$key],
                'field_name' => $key,
                'field_value' => $data,
            );
        }
        
        $data = array(
            'subscriber_id' => $subscriber_id,
            'fields' => $fields,
        );
        return self::setCurl('subscriber/setCustomFields', $data);
    }

    
    
    public function addTag($tag, $subscriber_id)
    {
        $data = array(
            'subscriber_id' => $subscriber_id,
            'tag_id' => $this->tags[$tag],
        );
        return self::setCurl('subscriber/addTag', $data);
    }
    
    public function removeTag($tag, $subscriber_id)
    {
        $data = array(
            'subscriber_id' => $subscriber_id,
            'tag_id' => $this->tags[$tag],
        );
        return self::setCurl('subscriber/removeTag', $data);
    }
}
