<?php

namespace App\Models;

use App\Strategies\Values\TemplateValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'investor_id',
        'transaction_type',
        'amount',
        'capital',
        'interest',
        'iva',
        'bank_transfer_type',
        'operation_number',
        'operation_status',
    ];

    public static function getTotalCapital($investorId)
    {
        $investor = Investor::find($investorId);
        $total =  Transaction::where(['investor_id' => $investorId, 'operation_status' => 1])
        ->selectRaw('SUM(amount) AS total_available')
        ->first();

        if ($total != null && $investor != null) {
            Investor::where('id', $investorId)
            ->update([
                'total_available' => $total->total_available - $investor->total_capital + $investor->total_collected,
            ]);
        }
        return $total;
    }

    public static function setTotalCapital($investorId)
    {
        $total = self::getTotalCapital($investorId);
        
        if ($total != null) {
            $investor = Investor::selectRaw('LEAST(total_available, lendable) AS loan_available')
                        ->selectRaw('total_available')
                        ->where('id', $investorId)->first();
            
            $getInvestorProducts = InvestorProduct::where('investor_id', $investorId)->get();
            $financialProductIds         = array();
            $investorsIds         = array();
                        
            Investor::where('id', $investorId)
                    ->update(
                    [
                        'loan_available' => $investor->loan_available,
                        'withdraw_available' => $investor->total_available - $investor->loan_available  ,
                    ]
            );
           /*  foreach ($getInvestorProducts as $getInvestorProducts) {

                $investorLoan = Investor::selectRaw('SUM(loan_available) as loan_available')
                            ->where('loan_active', 1)
                            ->where('id', $getInvestorProducts->investor_id)
                            ->first();
                
                $financialProductId = $getInvestorProducts->financial_products_id;
                $investorId         = $getInvestorProducts->investor_id;

                if (!in_array($financialProductId, $financialProductIds)) {
                    $financialProductIds[] = $financialProductId;
                }
            
                if (!in_array($investorId, $investorsIds)) {
                    $investorsIds[] = $investorId;
                }

                
            } */
            $getProductIds = InvestorProduct::where('investor_id', $investorId)->get();
            $financialProductInvestorsIds = array();
            foreach ($getProductIds as $getProductId) {
                $financialProductId = $getProductId->financial_products_id;
                if (!in_array($financialProductId, $financialProductInvestorsIds)) {
                    $financialProductInvestorsIds[] = $financialProductId;
                }
            }
            $getProducts = InvestorProduct::whereIn('financial_products_id', $financialProductInvestorsIds)->get();
            
            foreach ($getProducts as $getProduct) {

                $financialProductId = $getProduct->financial_products_id;
                $investorId         = $getProduct->investor_id;

                if (!in_array($financialProductId, $financialProductIds)) {
                    $financialProductIds[] = $financialProductId;
                }
                if (!in_array($investorId, $investorsIds)) {
                    $investorsIds[] = $investorId;
                }
            }
            //*actualizar  loan_available  de financial_products
            $investorLoan = Investor::selectRaw('SUM(loan_available) as loan_available')
                            ->where('loan_active', 1)
                            ->whereIn('id', $investorsIds)
                            ->first();

            if ($investorLoan != null) {
                $loanActive = $investorLoan->loan_available < 100 ? 0 : 1;
                FinancialProduct::whereIn('id', $financialProductIds)
                                ->update([
                                    'loan_available' => $investorLoan->loan_available,
                                    
                                ]);
                Investor::where('id', $investorId)->update([
                    'loan_active'=> $loanActive
                ]);
               

            }
            
        }

    }

    public static function saveEdit($request, $is_down = false)
    {
        $data = $request->transaction;
        if (isset($data['transaction_type']) && $data['transaction_type'] == 2) {
            $data['amount'] = -$data['amount'];
        }
        if ($request->id_rel == null)
        {
            $transaction = Transaction::create($data);
            if ($is_down == false) {
                HistoryLog::move($transaction->id, HistoryLog::KC_WALLET, HistoryLog::KC_WALLET);
                $getTransaction = HistoryLog::move($transaction->id, HistoryLog::KC_WALLET_ADD_FORM, HistoryLog::KC_WALLET_ADD_FORM);
                HistoryLog::updateStatusProgress(HistoryLog::KC_WALLET_ADD_FORM, $transaction->id, 1);
            } else {
                HistoryLog::move($transaction->id, HistoryLog::KC_DOWN_WALLET, HistoryLog::KC_DOWN_WALLET);
                $getTransaction = HistoryLog::move($transaction->id, HistoryLog::KC_DOWN_WALLET_ADD_FORM, HistoryLog::KC_DOWN_WALLET_ADD_FORM);
                HistoryLog::updateStatusProgress(HistoryLog::KC_DOWN_WALLET_ADD_FORM, $transaction->id, 1);
            }
           
        } else {
             Transaction::where('id', $request->id_rel)
                            ->update($data);
            $getTransaction =Transaction::where('id', $request->id_rel)->first();
            $transaction = $getTransaction;
        }
        return array('transaction' => $transaction, 'getTransaction' => $getTransaction);
    }

    public static function listDatatable($status)
    {
        $is_investor = Auth::user()->hasRole('Cliente inversionista');
        $userIdInvestor = null;
        if ($is_investor === true) {
            $getInvestor = Investor::where('user_id', Auth::user()->id)->first();
            $userIdInvestor = $getInvestor != null ? $getInvestor->id : null;
        }
        $get_list    = HistoryLog::getByStatus($status);
        $transactions        = array();
        //dd($userIdInvestor);
        foreach ($get_list as $history) {

            $transaction =  Transaction::find($history->id_rel);
            if (($transaction != null && $is_investor === true && $transaction->investor_id === $userIdInvestor) || ($is_investor === false && $transaction != null) ) {
                $investor = Investor::find($transaction->investor_id);
                $getOrdenante = $investor != null ? User::find($investor->user_id) : null;
                $ordenante =  $getOrdenante != null ?  $getOrdenante->name.' '. $getOrdenante->last_name.' '. $getOrdenante->second_last_name : null;
                $model            = HistoryLog::$name_model[$history->status_id];
                $templateStrategy = TemplateValues::STRATEGY[$model];
                $percent          = (new $templateStrategy)->getPercent($history);
                $progress_bar     = \View::make('panel.module.checkup.progressbar', [ 'client' => null, 'percent' => $percent])->render();
                $in_progress      = (new $templateStrategy)->getPercent($history, true);
                $dead_line        = (new $templateStrategy)->moduleDeadline($history);
                $menu_options          = (new $templateStrategy)->menuPrincipalOptions($history);
                $option               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['options']])->render();
    
                $transactions[] = array(
                    'id' => $transaction->id,
                    'date' => date('Y-m-d', strtotime($transaction->created_at)),
                    'ordenante' => $ordenante,
                    'importe' => format_price($transaction->amount),
                    'progress' => $progress_bar,
                    'in_progress' => $in_progress,
                    'deadline' => $dead_line,
                    'options' => $option
                );
            }
        }
        return $transactions;
    }
}

