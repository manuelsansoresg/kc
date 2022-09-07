<?php

namespace App\Strategies\Templates;

use App\Models\Agreement;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Strategies\TemplateInterface;
use App\Strategies\Values\SendNotificationsValues;
use stdClass;

class NewCreditStrategyTemplate implements TemplateInterface
{
    public function move($id)
    {
    }

    public function configUpload()
    {
        $elements = array(
            1 => [
                'name' => 'Identificación oficial',
                'comment' => 'INE vigente',
                'is_required' => false,
                'is_date' => false,
                'max_size' => 2, //* size in MB
                'max_file' => 2,
                'type' => 'image/*',
                'comment_date' => null
            ],

            2 => [
                'name' => 'Recibo de nómina',
                'comment' => 'Más reciente',
                'is_required' => true,
                'is_date' => true,
                'max_size' => 2,
                'max_file' => 2,
                'type' => 'image/*',
                'comment_date' => 'Establece la fecha del comprobante más antigüo'
            ]
        );
        return $elements;
    }

    public function configForm($id_rel)
    {
        $name_form = 'frm-template_new_credit';
        $options_agreement = Agreement::getAllActive();
        $elements = array(
            1 => [
                'title' => 'Organización',
                'name_field' => 'agreement_id',
                'id_field' => 'lead-agreement',
                'comment_admin' => ' Empresa donde labora el cliente',
                'comment_webApp' => ' Empresa donde laboras',
                'placeholder' => 'Escribe para buscar',
                'type' => 'select2',
                'options' => $options_agreement,
                'is_required' => true,
            ],
            2 => [
                'title' => 'Nombres',
                'name_field' => 'name',
                'id_field' => 'name',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'text',
                'options' => null,
                'is_required' => true,
            ],
            3 => [
                'title' => 'Primer apellido',
                'name_field' => 'last_name',
                'id_field' => 'last_name',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'text',
                'options' => null,
                'is_required' => true,
            ],
            4 => [
                'title' => 'Segundo apellido',
                'name_field' => 'second_last_name',
                'id_field' => 'second_last_name',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'text',
                'options' => null,
                'is_required' => false,
            ],
            5 => [
                'title' => 'Celular',
                'name_field' => 'cellphone',
                'id_field' => 'cellphone',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'number',
                'options' => null,
                'is_required' => true,
            ],
        );
        $list = \View::make('panel.module.form', [ 'elements' => $elements, 'name_form' => $name_form, 'id_rel' => $id_rel])->render();
        return $list;
    }

    public function saveForm($request)
    {
        $id_rel         = $request->id_rel;
        $agreement_id   = $request->agreement_id;

        if (isset($request->agreement_id) && $request->agreement_id == 0) { //si es  0 se insertara el nuevo agreement
            $agreement = new Agreement(['name' => $request->new_agreement, 'status' => 1]);
            $agreement->save();
            $agreement_id = $agreement->id;
        }

        $credit                 = Credit::find($id_rel);
        $credit->agreement_id   = $agreement_id;
        $credit->update();
        
        $client                 = ClientPerson::find($credit->client_person_id);
        $client->agreement_id   = $agreement_id;
        $client->name           = $request->name;
        $client->last_name      = $request->last_name;
        $client->cellphone      = $request->cellphone;
        $client->update();
    }
}
