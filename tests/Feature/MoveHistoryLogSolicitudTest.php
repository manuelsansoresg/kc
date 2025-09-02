<?php

namespace Tests\Feature;

use App\Lib\Cemail;
use App\Models\Credit;
use App\Models\HistoryLog;
use App\Models\Investor;
use App\Models\InvestorsAgreement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MoveHistoryLogSolicitudTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // Configurar Mail fake para interceptar correos en el test
        Mail::fake();
        
        $response = $this->get('/');
        $credit = Credit::find(52);
        $client = $credit!=null ? $credit->client : null;
        $name_client = $client!=null ? $client->name.' '. $client->last_name. ' '. $client->second_last_name : null;

        $agreement_id = $credit!=null ? $credit->agreement_id : null;
        //obtener todos los creditos con la organizacion del solicitante
        // Buscar el inversor asociado al usuario
        
        $getInvestors = InvestorsAgreement::where('agreement_id', $agreement_id)->get();
        $investorIds = $getInvestors->pluck('investor_id');
        $getUserInvestor = Investor::whereIn('id', $investorIds)->get();
        $user_ids = $getUserInvestor->pluck('user_id');
        echo "inversionistas: " . $user_ids . "\n";
        $getUsers = User::whereIn('id', $user_ids)->role('Cliente inversionista')->permission('Otorgar Vo.Bo')->get();

        // disparar envio de correo
        $emails = $getUsers->pluck('email')->implode(',');
        echo "Correos a enviar: " . $emails . "\n";
        
        if (!empty($emails)) {
            $subject = 'Solicitud de Vo.Bo. - ' . $name_client;
            $data_email = array(
                'name_client' => $name_client
            );

            $sendEmail = new Cemail($emails, 'solicitud', $subject, $data_email);
            $result = $sendEmail->sendEmail();
            
            if ($result) {
                echo "Correo enviado correctamente en el test\n";
                
                // El correo se envió exitosamente según el método sendEmail()
                $this->assertTrue($result, 'El correo se envió correctamente');
            } else {
                echo "Error: No se pudo enviar el correo\n";
                $this->fail('El correo no se pudo enviar');
            }
        } else {
            echo "No hay destinatarios para enviar correo\n";
            $this->markTestSkipped('No hay usuarios con permisos para recibir el correo');
        }
        
        $response->assertStatus(200);
    }
}
