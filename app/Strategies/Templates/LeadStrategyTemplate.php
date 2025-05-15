<?php

namespace App\Strategies\Templates;

use App\Lib\Manychat;
use App\Models\Agreement;
use App\Models\Bank;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\CreditNotes;
use App\Models\CreditPayOff;
use App\Models\CurrentFinancialProduct;
use App\Models\File;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Investor;
use App\Models\InvestorsCredit;
use App\Models\Lead;
use App\Models\Product;
use App\Models\SodScheduleDate;
use App\Strategies\TemplateInterface;
use App\Strategies\Values\SendNotificationsValues;
use stdClass;

class LeadStrategyTemplate implements TemplateInterface
{
    public function move($id, $is_report = false, $is_origin_api = false)
    {
        $get_lead = Lead::find($id);
        self::setCustomFieldsManyChat($get_lead->id);

        $lead = Lead::find($id);
        $history_id = null;
        $history = null;
        if ($lead !== null) {
            $product = $lead->productLead;
            //* add clientslog archive conversion
            $request = new stdClass();
            $request->data = array(
                'reason' => 4 //* enums reason_archive
            );
            HistoryLog::move($lead->id, HistoryLog::LEAD_ARCHIVE, HistoryLog::CREATE_PROSPECT, $request);

            //* create client_person
            $data_client_person = array(
                'name' => $lead->name,
                'last_name' => $lead->last_name,
                'second_last_name' => $lead->second_last_name,
                'cellphone' => $lead->cellphone,
                'email' => $lead->email,
                'agreement_id' => $lead->agreement_id,
                'rfc' => $lead->rfc,
            );
            // know if exist client person

            if (ClientPerson::where('cellphone', $lead->cellphone)->count() == 0 && ClientPerson::where('rfc', $lead->rfc)->count() == 0) {
                $client_person = ClientPerson::create($data_client_person);
            } else {
                ClientPerson::where('rfc', $lead->rfc)
                            ->update($data_client_person);
                $client_person = ClientPerson::where('rfc', $lead->rfc)->first();
            }

            if ($is_origin_api === true) {
                Lead::where('id', $lead->id)->update([
                    'client_person_id' => $client_person->id,
                ]);
            }
            
            $financialProduct = FinancialProduct::find($lead->financial_product_id);
            $productTypeId = $financialProduct ? $financialProduct->type_product_id : null;

            //* create credit
            $data_lead = array(
                'client_person_id' => $client_person->id,
                'product_id' => $productTypeId,
                'financial_id' => $lead->financial_id,
                'agreement_id' => $lead->agreement_id,
                'origin_id' => $lead->origin_id,
                'channel_id' => $lead->channel_id,
                'type_id' => $lead->type_id,
                'asesor_id' => $lead->asesor_id,
                'importe_solicitado' => $lead->importe_solicitado,
                'applied_import' => $lead->selected_loan,
                'bank_id' => $lead->bank_id,
                'tipo_credito' => $lead->tipo_credito,
                'consulta_buro' => $lead->consulta_buro,
                'applied_financial_product' => $lead->financial_product_id,
                'is_vincular_banco' => $lead->is_vincular_banco,
                'status_si_no' => $lead->status_si_no,
                'aval_o_garantia' => $lead->aval_o_garantia,
                'consulta_buro' => $lead->consulta_buro,
                'manychat_id' => $lead->manychat_id,
                'lead_id' => $lead->id,
                'income' => $lead->income,
                'applied_loan_type' => $lead->applied_loan_type,
                'tramit_type' => $lead->tramit_type,
            );

            // Si el producto es SOD (product_id = 3)
            if ($lead->product_id == 3) {
                $sod_schedule = Agreement::where('sod_schedule_id', $lead->agreement_id)->first();

                if ($sod_schedule) {
                    $scheduleColumn = 'schedule_' . $sod_schedule->sod_schedule_id;
                    $today = date('Y-m-d');

                    $getSchedule = SodScheduleDate::whereDate('fecha', '>=', $today)
                        ->where($scheduleColumn, 2)
                        ->orderBy('fecha', 'asc')
                        ->first();

                    if ($getSchedule) {
                        $data_lead['collection_date'] = $getSchedule->fecha;
                    }
                }

                $financial_product_id = $lead->financial_product_id;
                $getFinancial = FinancialProduct::find($financial_product_id);

                // Aplicar las modificaciones solicitadas
                $data_lead['product_id'] = $lead->product_id; 
                $data_lead['applied_financial_product'] = $lead->financial_product_id; 
                $data_lead['applied_import'] = $lead->sod_withdraw_amount; // Cambio aquí
                $data_lead['applied_term'] = 1; // Cambio aquí
                $data_lead['applied_periodicity'] = $getFinancial ? $getFinancial->periodicity_id : null;
                $data_lead['applied_payment'] = $lead->sod_total_payment; 
                $data_lead['applied_loan_total_amount'] = $lead->sod_total_payment; 
                $data_lead['applied_interest_rate'] = 0; 
                $data_lead['applied_CAT'] = 0; 
                $data_lead['opening_Commission_percentage'] = 0; 
                $data_lead['net_amount'] = $lead->sod_withdraw_amount; 
                $data_lead['sod_commission'] = $lead->sod_commision_amount; 
                $data_lead['opening_commission'] = 0; 
            }

            //validar que el credito no exista con los mismos datos
            $credit = Credit::create($data_lead);
            
            CreditPayOff::where('lead_id', $lead->id)->update([
                'new_kc_credit_id' => $credit->id
            ]);
            //obtener las notas de los prospectos
            $leadNotes = $lead->leadNotes;
            foreach ($leadNotes as $leadNote) {
                $dataCreditNote = array(
                    'credit_id' => $credit->id,
                    'note_id' => $leadNote->note_id
                );
                CreditNotes::create($dataCreditNote);
            }

            CurrentFinancialProduct::moveToLead($lead->id, $credit->id);
            //*desactivar acciones prospectos
            Lead::deleteActions($lead->id);
            //* create history in client person
            $history_id = HistoryLog::move($client_person->id, HistoryLog::LEAD_CONVERT, HistoryLog::LEAD_CONVERT);
            //* create history in credit
            HistoryLog::move($credit->id, HistoryLog::CREATE_CLIENT_PERSON, HistoryLog::CREATE_CLIENT_PERSON);
            //*in progress
            HistoryLog::move($credit->id, HistoryLog::CREDIT_IN_PROGRESS, HistoryLog::CREDIT_IN_PROGRESS);
            

            //* con el nuevo cambio todo pasara primero a control desk

            $history = HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK, HistoryLog::KC_CONTROL_DESK);
            $notification   = SendNotificationsValues::STRATEGY['pushCreditKcControlDesk'];
            (new $notification)->send($credit->id);
            
            //* enter module kc-checkup and list actions
            
            /* if ($product->c_product_id = 1 && $product->c_service_id == 1) {
                $history = HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP, HistoryLog::KC_CHECK_UP);
                $notification   = SendNotificationsValues::STRATEGY['pushNewCreditKcCheckUp'];
                (new $notification)->send($credit->id);
            } elseif ($product->c_product_id = 1 && $product->c_service_id == 2) {
                $history = HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION);
                $notification   = SendNotificationsValues::STRATEGY['pushNewCreditKcCheckUp'];
                (new $notification)->send($credit->id);
            } */

            //*create account automatically
            Lead::createClientPerson($lead->id, $is_report, $history->id);
            InvestorsCredit::saveEdit($credit->id);
            $getInvestors = InvestorsCredit::where('credit_id', $credit->id)->get();
            foreach ($getInvestors as $getInvestor) {
                //Transaction::setTotalCapital($getInvestor->investor_id);
                Investor::updateInvestorData($getInvestor->investor_id);
            }
        }
        return $history;
    }

    public function setCustomFieldsManyChat($lead_id)
    {
        $lead = Lead::find($lead_id);
        $manychat_id = $lead->manychat_id;
        $manychat = new Manychat();
        $info = json_decode($manychat->getInfoUser($manychat_id));
        $status = $info->status;
        $data_lead = array();
        if ($status != 'error') {
            $data = $info->data;
            $custom_fields = $data->custom_fields;
            foreach ($custom_fields as $key => $custom_field) {
                
                if ($lead->asesor_id == null && $custom_field->name == 'Asesor') {
                    $data_lead['asesor_id'] = $custom_field->value;
                }
                
                if ($lead->aval_o_garantia == null && $custom_field->name == 'Aval o garantía') {
                    $data_lead['aval_o_garantia'] = $custom_field->value == true ? 1 : 0;
                }
                
                if ($lead->bank_id == null && $custom_field->name == 'Banco') {
                    $get_bank = Bank::where('name', $custom_field->value)->first();
                    $data_lead['bank_id'] = $get_bank->id;
                }
                
                if ($lead->channel_id == null && $custom_field->name == 'Canal') {
                    $channel_id = config('enums.channel_asesor')[$custom_field->value];
                    $data_lead['channel_id'] = $channel_id;
                }
                
                if ($lead->consulta_buro == null && $custom_field->name == 'Consulta buró') {
                    $channel_id = config('enums.channel_asesor')[$custom_field->value];
                    $data_lead['consulta_buro'] = $custom_field->value == true ? 1 : 0;
                }
                
                if ($lead->consulta_buro == null && $custom_field->name == 'Organización') {
                    $agreement = Agreement::where('name', $custom_field->value)->first();
                    $data_lead['agreement_id'] = $agreement->id;
                }
                
                if ($lead->origin_id == null && $custom_field->name == 'Origen') {
                    $data_lead['origin_id'] = 2;
                }
                
                if ($lead->product_id == null && $custom_field->name == 'Servicio KC') {
                    $get_product = Product::where('alias', $custom_field->value)->first();
                    $data_lead['product_id'] = $get_product->id;
                }
                
                
                if ($lead->tipo_credito == null && $custom_field->name == 'Tipo de crédito') {
                    $type_products = config('financial_enums.type_products')[$custom_field->value];
                    $data_lead['tipo_credito'] = $type_products;
                }

            }
            $lead->update($data_lead);
        }

    }

    public function breadcrumb($history, $type = null)
    {
        return null;
    }

    public function setTitle()
    {
        return 'Acción formulario';
    }
}
