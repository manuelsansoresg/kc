<?php

namespace App\Models;

use App\Lib\Csendgrid;
use App\Models\kaaxSidecc\agreementCollection;
use App\Strategies\Values\TemplateValues;
use Facade\FlareClient\Http\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Credit extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_person_id',
        'product_id',
        'financial_id',
        'agreement_id',
        'origin_id',
        'channel_id',
        'type_id', //*atención
        'asesor_id',
        'current_payment',//*save  * 100
        'current_periodicity',
        'current_loan',//*save  * 100
        'current_term',
        'current_principal_balance',//*save  * 100
        'current_total_balance',//*save  * 100
        'applied_financial',
        'applied_financial_product',
        'applied_loan_type',
        'applied_sign_type',
        'applied_import',//*save  * 100
        'applied_term',
        'applied_periodicity',
        'applied_payment',//*save  * 100
        'applied_loan_total_amount',//*save  * 100
        'applied_delivery_method',
        'applied_loan_motive',
        'payment_capacity_period',
        'payment_capacity',
        'applied_interest_rate',
        'applied_CAT',
        'opening_Commission_percentage',
        'client_public_servant',
        'client_public_servant_position',
        'client_public_servant_period',
        'relative_public_servant',
        'relative_public_servant_lastname',
        'relative_public_servant_second_lastname',
        'relative_public_servant_names',
        'relative_public_servant_relationship',
        'relative_public_servant_position',
        'relative_public_servant_period',
        'client_public_servant',
        'prepad_method',
        'prepaid_frequency',
        'prepaid_source',
        'endorsement',
        'real_beneficiary',
        'soruce_provider',
        'real_propetary',
        'applied_loan_discount',
        'statement_delivery_method',
        'notes',
        'financial_user_assigned',
        'commission',//*save  * 100
        'commission_note',
        'changed_commission', //* save * 100
        'changed_commission_note',
        'payment_check',
        'payment_check_note',
        'id_number',
        'current_credit_number',
        'url_sign',
        'signed',
        'termination_email_sent',
        'termination_number',
        'termination_bank_name',
        'termination_bank_account_holder',
        'termination_bank_account_number',
        'termination_bank_clabe',
        'termination_bank_reference',
        'termination_note',
        'termination_amount', //* save * 100
        'termination_deadline',
        'kyc_done',
        'credit_signed',
        'approved',
        'delivered',
        'delivered_date',
        'interviewer',
        'importe_solicitado',
        'bank_id',
        'tipo_credito',
        'consulta_buro',
        'financial_product_id',
        'is_vincular_banco',
        'aval_o_garantia',
        'manychat_id',
        'lead_id',
        'date_open_report',
        'income',
        'investor_id',
        'start_period_id',
        's2_credit_id',
        'opening_commission',
        'sod_commission',
        'refinance_adjustment',
        'third_party_adjustment',
        'net_amount',
        'tramit_type',
        
        'payroll_date',
        'payroll_total',
        'payroll_payment_capacity',
        
        'credit_agreement_signed',
        'sod_agreement',
        'info_s2_sent',
        'credit_s2_active',
        'credit_status',
        'collection_date',
        'canceled',
        'status',
        'refinanciable',
        
    ];

    public static function setDataPago($creditId)
    {
        // 1) obtengo colección
        $col = agreementCollection::where('credit_id', $creditId)->first();
        if (!$col) return;

        // 2) obtengo todos los investors_credits de este crédito KAAX
        $ics = InvestorsCredit::where('credit_id', $col->kc_credit_id)->get();
        if ($ics->isEmpty()) return;

        // 3) recálculo en lote
        $ics->each(function($ic) use ($col) {
            $p  = $ic->percentage / 100;
            $totalCollected = $col->pago_acumulado_real * $p;
            $recoveredCapital = $col->abono_acumulado_real * $p;
            $profitCollected  = ($totalCollected - $recoveredCapital) / 1.16;
            $ivaCollected     = $profitCollected * 0.16;
            $placedCapital    = $col->saldo_insoluto_real * $p;
            $comRateNoIva     = $ic->commission_rate / 1.16;
            $commissionAmount = $totalCollected * $comRateNoIva;
            $ivaCommission    = $commissionAmount * 0.16;
            $newStatus        = $placedCapital > 1 ? 4 : ($recoveredCapital > 0 ? 5 : $ic->status);

            $ic->update([
                'total_collected'  => $totalCollected,
                'recovered_capital'=> $recoveredCapital,
                'profit_collected' => $profitCollected,
                'iva_collected'    => $ivaCollected,
                'placed_capital'   => $placedCapital,
                'commission_amount'=> $commissionAmount,
                'iva_commission'   => $ivaCommission,
                'total_balance'    => $col->saldo_total_real * $p,
                'credit_status'    => $col->status,
                'refinanciable'    => $col->refinanciable,
                'status'           => $newStatus,
            ]);
        });

        // 4 Llamar flags por cada crédito afectado (sin repetir)
        $ics->pluck('credit_id')->unique()->each(function ($creditId) {
            Credit::updateClientPersonCreditFlags($creditId);
        });

        // 5) vuelvo a recalcular balances de todos los inversionistas
        $ics->pluck('investor_id')->filter()->unique()
            ->each(fn($invId) => Investor::updateInvestorData($invId));
    }


    public static function setMontoEntregar($creditId)
    {
        $credit = Credit::find($creditId);
        $financialProduct = FinancialProduct::find($credit->applied_financial_product);
        //actualizar
        if ($credit!= null && $financialProduct != null) {
            $openin_commission = $credit->applied_import * ($financialProduct->opening_commission_rate / 100);
            $net_amount = $credit->applied_import - $openin_commission - $credit->refinance_adjustment - $credit->third_party_adjustment;
            $sod_commission = $financialProduct->sod_commission_amount;
            Credit::where('id', $credit->id)->update([
                'opening_commission' => $openin_commission,
                'sod_commission' => $sod_commission,
                'net_amount' => $net_amount
            ]);
        }
    }


    public static function unlockPendingCredit($creditId)
    {
        // 1. Verificar que el crédito exista
        $credit = Credit::find($creditId);
        if (!$credit) {
            return;
        }
    
        // 2. Actualizar funding_locked y status del crédito
        $credit->update([
            'funding_locked' => 0,
            'status' => 0,
        ]);
    
        // 3. Actualizar todos los investors_credits relacionados
        InvestorsCredit::where('credit_id', $creditId)->update([
            'status' => 0,
        ]);
    
        // 4. Llamar limpieza de fondeo previo para el producto financiero correspondiente
        InvestorsCredit::removeInvestorsCreditsByProduct($credit->applied_financial_product);
    }    


    public static function updateClientPersonCreditFlags($creditId)
    {
        $getCredit = Credit::find($creditId);

        if (!$getCredit) {
           return;
        }

        $clientPersonId = $getCredit->client_person_id;

        // 1. FLAGS DE ACTIVIDAD
        $hasActiveCredit = Credit::where('client_person_id', $clientPersonId)
            ->where('product_id', '!=', 3)
            ->whereIn('status', [4])
            ->where('canceled', 0)
            ->exists();

        $hasActiveSod = Credit::where('client_person_id', $clientPersonId)
            ->where('product_id', '=', 3)
            ->whereIn('status', [4])
            ->where('canceled', 0)
            ->exists();

        // 2. IMPORTES ACTIVOS
        $activeDiscount = Credit::where('client_person_id', $clientPersonId)
            ->where('product_id', '!=', 3)
            ->whereIn('status', [4])
            ->where('canceled', 0)
            ->sum('applied_payment');

        $activeSodAmount = Credit::where('client_person_id', $clientPersonId)
            ->where('product_id', '=', 3)
            ->whereIn('status', [4])
            ->where('canceled', 0)
            ->sum('applied_payment');

        // 3. FLAG DE TRÁMITES PENDIENTES
        $hasPendingTramit = Credit::where('client_person_id', $clientPersonId)
            ->whereIn('status', [1, 2, 3])
            ->where('canceled', 0)
            ->exists();

        // 4. TRÁMITES PERMITIDOS
        $client = ClientPerson::find($clientPersonId);

        $newTramitAllowed = 0;
        $additionalTramitAllowed = 0;
        $refTramitAllowed = 0;

        if ($hasActiveCredit == false) {
            // No tiene crédito activo
            $newTramitAllowed = 1;
        } else {
            // Tiene crédito activo
            $activeCredits = Credit::where('client_person_id', $clientPersonId)
                ->where('product_id', '!=', 3)
                ->whereIn('status', [4])
                ->where('canceled', 0)
                ->get();

            foreach ($activeCredits as $credit) {
                $product = FinancialProduct::where('id', $credit->applied_financial_product)
                    ->where('status', 1) // SOLO productos activos
                    ->first();

                if (!$product) {
                    continue;
                }

                if ($credit->refinanciable == 1 && $product->refinancing_allowed == 1) {
                    $refTramitAllowed = 1;
                }

                if ($product->additional_allowed == 1) {
                    $additionalTramitAllowed = 1;
                }
            }
        }

        // ❗ Bloqueo si está inactivo o tiene trámite pendiente
        if ($client->active == 0 || $hasPendingTramit) {
            $newTramitAllowed = 0;
            $additionalTramitAllowed = 0;
            $refTramitAllowed = 0;
        }

        // 5. ACTUALIZAR CAMPOS EN client_person
        $client->update([
            'credit_active'            => $hasActiveCredit ? 1 : 0,
            'sod_active'               => $hasActiveSod ? 1 : 0,
            'active_discount'          => $activeDiscount,
            'sod_active_amount'        => $activeSodAmount,
            'pending_tramit'           => $hasPendingTramit ? 1 : 0,
            'new_tramit_allowed'       => $newTramitAllowed,
            'additional_tramit_allowed'=> $additionalTramitAllowed,
            'ref_tramit_allowed'       => $refTramitAllowed,
        ]);
    }

    

    /**
     * actualizar applied_import , applied_term , applied_payment , applied_loan_total_amount 
     */
    public static function setAppliedImport($creditId)
    {
        Credit::where('id', $creditId)->update([
            'applied_import' => 0,
            'applied_term' => 0,
            'applied_payment' => 0,
            'applied_loan_total_amount' => 0,
        ]);
    }

    public static function setTotalCapitalAndMore($creditId)
    {
        Credit::setTotalCapital($creditId);
        InvestorsCredit::setPlacedCapital($creditId);
        InvestorsCredit::setComissionRateAndAmount($creditId);
    }

    public static function setTotalCapital($creditId)
    {
        $totalAppliedImport = 0;
        $getCredit = Credit::find($creditId);
        // Filter distinct credits from history_logs excluding status_id = 16
        
        $distinctCredits = Credit::select('applied_import', 'id')
        ->where('credits.applied_financial_product', $getCredit->applied_financial_product)
        ->get(); // Use distinct to avoid duplicates
        
        // Calculate the sum of applied_import for distinct credits
        foreach ($distinctCredits as $distinctCredit) {
            
            $isExistCancelled = HistoryLog::where([
                                'status_id' => HistoryLog::CREDIT_CANCELED,
                                'id_rel' => $distinctCredit->id,
                                'is_credit' => 1
                                ])->first();
            
            if ($isExistCancelled === null) {
                $totalAppliedImport = $totalAppliedImport + $distinctCredit->applied_import;
            }
        }
    
        // Update the total_capital field for the current credit
        $credit = Credit::find($creditId);
        $totalCapitalPerInvestor = InvestorsCredit::selectRaw('SUM(import) as total_capital, investor_id')
                                    ->join('investors', 'investors_credits.investor_id', '=', 'investors.id')
                                    ->groupBy('investors_credits.investor_id')
                                    ->get();
        

        foreach ($totalCapitalPerInvestor as $totalCapital) {
            Investor::where('id', $totalCapital->investor_id)
                ->update([
                    'total_capital' => $totalCapital->total_capital
                ]);
        }


        $getInvestors = InvestorProduct::where('financial_products_id', $credit->applied_financial_product)->get();

        foreach ($getInvestors as $getInvestor) {
            //Transaction::setTotalCapital($getInvestor->investor_id);
        }
        
    }
    
    public static function listDatatable($status)
    {
       
        //*restrict user financial and asesor
        $get_list    = HistoryLog::getByStatus($status);
        $users        = array();
        foreach ($get_list as $history) {
            try {
                $query            = Credit::find($history->id_rel);
                $product          = $query->creditProduct;
                $alias_product    = $product !== null ? $product->alias : null;
                $client           = $query->creditClientPerson;
                $advisor          = $query->creditAdvisor;
                $route            = self::routeShowStep()[$history->status_id];
                $model            = HistoryLog::$name_model[$history->status_id];
                $templateStrategy = TemplateValues::STRATEGY[$model];
                $percent          = (new $templateStrategy)->getPercent($history);
                $percent_form     = (new $templateStrategy)->percentForm($history);
                //dd($history->status_id);
                $hour             = $query->created_at;
                $max_hour         = 24;
                $data_deadline    = deadlineKc($hour, $max_hour);
                $in_progress      = (new $templateStrategy)->getPercent($history, true);
                $dead_line        = (new $templateStrategy)->moduleDeadline($history);
                
                $hour             = $data_deadline['lbl_hour'];
                $status_id        = $history->status_id;
                $option           = \View::make('panel.module.checkup.add_option_only_checkup_dt', ['query' => $query, 'id' => $history->id, 'client' => $client, 'percent_form' => $percent_form, 'credit_id' => $history->id_rel, 'route' => $route, 'status_id' => $status_id])->render();

                if ($history->status_id === HistoryLog::KC_AFTER_MARKET || $history->status_id === HistoryLog::KC_CONTROL_DESK || $history->status_id === HistoryLog::KC_DELIVERY || $history->status_id === HistoryLog::KC_PAYMENT) {
                    $financialProduct =  FinancialProduct::find($query->applied_financial_product);
                    $tipoCredito = $financialProduct != null  ? Product::find($financialProduct->type_product_id) : null;
                    $alias_product = $tipoCredito!= null ? $tipoCredito->alias : null;
                    $menu_options          = (new $templateStrategy)->menuPrincipalOptions($history);
                    $option               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['options']])->render();
                }

                if ($history->status_id === HistoryLog::KC_SWAP) {
                    $menu_options          = (new $templateStrategy)->menuPrincipalOptions($history);
                    $option               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['options']])->render();
                }

                $content_client   = \View::make('panel.module.checkup.content_client', [ 'client' => $client])->render();
                $progress_bar     = \View::make('panel.module.checkup.progressbar', [ 'client' => $client, 'percent' => $percent])->render();
                $content_product  = \View::make('panel.module.checkup.product', [ 'alias_product' => $alias_product])->render();
                
                $name_advisor = $advisor !== null ? $advisor->name.' '.$advisor->last_name : null;
                $is_advisor     = Auth::user()->hasRole('Asesor');
                $is_user_financial = Auth::user()->hasRole('Cliente financiera');

                if ($is_advisor === true && Auth::user()->id === $advisor->id) {
                    $users[] = array(
                        'id' => $query->id_rel,
                        'fecha' => formatDateNameMonthHour($history->created_at),
                        'product' => $content_product,
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'progress' => $progress_bar,
                        'in_progress' => $in_progress,
                        'deadline' => $dead_line,
                        'options' => $option
                    );
                } elseif ($is_user_financial === true && $query->financial_user_assigned === Auth::user()->id) {
                    $users[] = array(
                        'id' => $query->id_rel,
                        'fecha' => formatDateNameMonthHour($history->created_at),
                        'product' => $content_product,
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'progress' => $progress_bar,
                        'in_progress' => $in_progress,
                        'deadline' => $dead_line,
                        'options' => $option
                    );
                } else {
                    $users[] = array(
                        'id' => $history->id_rel,
                        'fecha' => formatDateNameMonthHour($history->created_at),
                        'product' => $content_product,
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'progress' => $progress_bar,
                        'in_progress' => $in_progress,
                        'deadline' => $dead_line,
                        'options' => $option
                    );
                }//code...
            } catch (\Exception $th) {
            }
        }
        return $users;
    }

    public static function percentApplyDecision($credit_id)
    {
        $credit   = Credit::find($credit_id);
        $desition = $credit->applied_financial != null ? 100 : 0;
        return $desition;
    }

    public static function sendEmailDelivered($creditId)
    {
        $investorCredits = InvestorsCredit::where('credit_id', $creditId)->get();
        $credit          = Credit::find($creditId);
        $client          = ClientPerson::find($credit->client_person_id);
        foreach ($investorCredits as $investorCredit) {
            $investor           = Investor::find($investorCredit->investor_id);
            $userInvestor       = User::find($investor->user_id);
            $nombreBeneficiario = $client->name.' '.$client->last_name.''.$client->second_last_name;
            $percentage         = $investorCredit->percentage * 100;
            $importePrestado    = $investorCredit->import;

            $dataParams = array(
                'creditId' => $creditId,
                'nombreBeneficiario' => $nombreBeneficiario,
                'porcentajeParticipacion' => $percentage,
                'importePrestado' => $importePrestado,
            );
            $send_grid = new Csendgrid($userInvestor->email, 'Inversionista - Aviso de nuevo crédito colocado');
            $send_grid->setTemplate('d-210b5898a0fe41f9ad746ffa3c42a3f1');
            $send_grid->setParams($dataParams);
            $send_grid->send();
            sleep(0.25);
        }
    }

    public static function listDatatableProduct($status)
    {
        $get_list    = HistoryLog::getByStatus([$status]);
        $users        = array();
        foreach ($get_list as $history) {
            $query            = Credit::find($history->id_rel);
            if ($query !== null) {
                $product          = $query->creditProduct;
                $alias_product    = $product !== null ? $product->alias : null;
                $client           = @$query->creditClientPerson;
                $advisor          = $query->creditAdvisor;
                $menu_options   = self::menuOptionCredit($history);
    
                $reason_enums = array(17 => 'credit_reason_cancel', 18 => 'credit_reason_reject', 16 => 'credit_reason_archive', 35 => 'pagado', 55 => 'delivered');
                $reason = isset(config('enums.'.$reason_enums[$history->status_id])[$history->reason]) ? config('enums.'.$reason_enums[$history->status_id])[$history->reason] : null;
    
                $option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['archive']])->render();
                $content_client   = \View::make('panel.module.checkup.content_client', [ 'client' => $client])->render();
                $content_product  = \View::make('panel.module.checkup.product', [ 'alias_product' => $alias_product])->render();
                
                $name_advisor = $advisor !== null ? $advisor->name.' '.$advisor->last_name : null;
                $is_advisor     = Auth::user()->hasRole('Asesor');
                if ($is_advisor === true && Auth::user()->id === $advisor->id) {
                    $users[] = array(
                        'id' => $query->id,
                        'product' => $content_product,
                        'reason' => $reason,
                        'date' => formatDateNameMonth($history->created_at),
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'options' => $option
                    );
                } else {
                    $users[] = array(
                        'id' => $query->id,
                        'product' => $content_product,
                        'reason' => $reason,
                        'date' => formatDateNameMonth($history->created_at),
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'options' => $option
                    );
                }
            }
        }
        return $users;
    }

    public static function listDatatableInProgress()
    {
        $get_in_progress    = HistoryLog::getByStatus([HistoryLog::CREDIT_IN_PROGRESS]);
        //$get_list    = HistoryLog::getByStatus([HistoryLog::KC_CHECK_UP, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION]);
        $users        = array();
        foreach ($get_in_progress as $history) {
            $id_rel           = $history->id_rel;

            $query            = Credit::find($history->id_rel);
            
            try {
                $product          = $query->creditProduct;
                $alias_product    = $product !== null ? $product->alias : null;
                
                $client           = $query->creditClientPerson;
                $advisor          = $query->creditAdvisor;
                $get_module       = HistoryLog::getInProgress($id_rel, true);
                $name_module       = HistoryLog::getInProgress($id_rel);
                $model            = HistoryLog::$name_model[$get_module];
                $templateStrategy = TemplateValues::STRATEGY[$model];
                $percent          = (new $templateStrategy)->getPercent($history);
                
                

                $hour             = $query->created_at;
                $max_hour         = 24;

                $modulo           = $name_module;

                $data_deadline    = deadlineKc($hour, $max_hour);
                $color_inf_credit = $data_deadline['color'];
                $hour             = $data_deadline['lbl_hour'];
                $status_id        = $history->status_id;
                
                $menu_options     = self::menuInProgressOptions($history);
                $option           = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['options']])->render();
                
                $content_client   = \View::make('panel.module.checkup.content_client', [ 'client' => $client])->render();
                $progress_bar     = \View::make('panel.module.checkup.progressbar', [ 'client' => $client, 'percent' => $percent])->render();
                $dead_line        = \View::make('panel.module.checkup.deadline', [ 'hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
                $content_product  = \View::make('panel.module.checkup.product', [ 'alias_product' => $alias_product])->render();
                
                $name_advisor = $advisor !== null ? $advisor->name.' '.$advisor->last_name : null;
                $is_advisor     = Auth::user()->hasRole('Asesor');
                if ($is_advisor === true && Auth::user()->id === $advisor->id) {
                    $users[] = array(
                        'id' => $query->id,
                        'product' => $content_product,
                        'module' => $modulo,
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'progress' => $progress_bar,
                        'deadline' => $dead_line,
                        'options' => $option
                    );
                } else {
                    $users[] = array(
                        'id' => $query->id,
                        'product' => $content_product,
                        'module' => $modulo,
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'progress' => $progress_bar,
                        'deadline' => $dead_line,
                        'options' => $option
                    );
                }
            } catch (\Exception $th) {
            }
        }
        return $users;
    }

    public function menuInProgressOptions($history)
    {
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $menu = array(
            'options' => array(
                [
                    'link' => '/panel/client/'.$client->id,
                    'onclick' => '',
                    'name' => 'Ver perfil cliente',
                    'icon' =>  'icon ni ni-user-fill'
                ],
                [
                    'link' => '/panel/credit/'.$credit->id,
                    'onclick' => '',
                    'name' => 'Ver perfil crédito',
                    'icon' => 'icon ni ni-report-profit'
                ]
            ),
        );

        return $menu;
    }

    public function menuOptionCredit($history)
    {
        $menu = array(
            'archive' => array(
                [
                    'link' => '/panel/credit/'.$history->id_rel,
                    'onclick' => '',
                    'name' => 'Ver perfíl crédito',
                ]
            ),
            'desition' => array(
                [
                    'link' => '/panel/kc-check-up/report/desition/'.$history->id.'/show/',
                    'onclick' => '',
                    'name' => 'Ver acción',
                ]
            )
        );
        return $menu;
    }

    public function routeShowStep()
    {
        $routes = array(
            6 => 'newCredit',
            10 => 'debtCredit',
            19 => 'debtCredit',
            21 => 'controlDesk',
            30 => 'delivery',
            36 => 'afterMarket',
            37 => 'swap',
            49 => 'payment',

        );
        return $routes;
    }

    


    public function investorsCredits()
    {
        return $this->hasMany(InvestorsCredit::class, 'credit_id');
    }
    
    public function advisorCredit()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function creditClientPerson()
    {
        return $this->belongsTo(ClientPerson::class, 'client_person_id');
    }

    public function creditReference()
    {
        return $this->hasMany(CreditReference::class);
    }
    
    public function creditAgreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id');
    }

    public static function getLastCredit($client_id)
    {
        return Credit::where('client_person_id', $client_id)->orderBy('id', 'DESC')->limit(1)->first();
    }
    
    public function creditFinancial()
    {
        return $this->belongsTo(Financial::class, 'financial_id');
    }
   
    public function creditAppliedFinancial()
    {
        return $this->belongsTo(Financial::class, 'applied_financial');
    }

    public function creditProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function creditAppliedProduct()
    {
        return $this->belongsTo(Product::class, 'applied_financial_product');
    }
   
    public function creditUserFinancial()
    {
        return $this->belongsTo(User::class, 'financial_user_assigned');
    }

    public function creditAdvisor()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function history()
    {
        return $this->hasOne(HistoryLog::class);
    }
   
    public function notification()
    {
        return $this->hasOne(Notification::class);
    }

    public function survey()
    {
        return $this->hasOne(Survey::class);
    }

    public function client()
    {
        return $this->belongsTo(ClientPerson::class, 'client_person_id');
    }

    public function creditNotes()
    {
        return $this->hasMany(CreditNotes::class);
    }
}
