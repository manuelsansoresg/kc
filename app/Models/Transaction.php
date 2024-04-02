<?php

namespace App\Models;

use App\Strategies\Values\TemplateValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function saveEdit($request, $is_down = false)
    {
        $data = $request->transaction;
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
            $getTransaction = Transaction::where('id', $request->id_rel)
                            ->update($data);
        }
        return $getTransaction;
    }

    public static function listDatatable($status)
    {
        $get_list    = HistoryLog::getByStatus($status);
        $transactions        = array();
        foreach ($get_list as $history) {
            $transaction = Transaction::find($history->id_rel);
            $getOrdenante = User::find($transaction->investor_id);
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
                'id' => $history->id_rel,
                'date' => date('Y-m-d', strtotime($transaction->created_at)),
                'ordenante' => $ordenante,
                'importe' => format_price($transaction->amount),
                'progress' => $progress_bar,
                'in_progress' => $in_progress,
                'deadline' => $dead_line,
                'options' => $option
            );
        }
        return $transactions;
    }
}

