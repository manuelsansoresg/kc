<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HistoryLog extends Model
{
    use HasFactory;

    const LEAD_ARCHIVE                        = 1;
    const ADD_PROSPECT                        = 2;
    const CREATE_PROSPECT                     = 3;
    const LEAD_CONVERT                        = 4;
    const CREATE_CLIENT_PERSON                = 5;
    
    const KC_CHECK_UP                         = 6;
    const KC_CHECK_UP_ACTION_UPLOAD           = 7;
    const KC_CHECK_UP_ACTION_FORM             = 8;
    const KC_CHECK_UP_ACTION_REPORT           = 9;
    const KC_CHECK_UP_ACTION_DESITION         = 14;

    const KC_CHECK_UP_DEBT_REDUCTION          = 10;
    const KC_CHECK_UP_DEBT_REDUCTION_UPLOAD   = 11;
    const KC_CHECK_UP_DEBT_REDUCTION_FORM     = 12;
    const KC_CHECK_UP_DEBT_REDUCTION_REPORT   = 13;
    const KC_CHECK_UP_DEBT_REDUCTION_DESITION = 15;

    const CREDIT_ARCHIVE                      = 16;
    const CREDIT_CANCELED                     = 17;
    const CREDIT_REJECTED                     = 18;
    //* whenever a credit is in a module it must be in progress if it is archived, canceled or refuses to remove it
    const CREDIT_IN_PROGRESS                  = 19;
    
    const NEW_CREDIT_KC_CHECK_UP              = 20;

    const KC_CONTROL_DESK                     = 21;
    

    protected $fillable = [
        'id_rel',
        'status_id',
        'old_status_id',
        'reason',
        'file',
        'comment',
        'status',
        'user_id'
    ];

    public static $label_status = [
        1 => 'Se archivó el prospecto',
        2 => 'Se asigno el prospecto a',
        3 => 'Se créo el prospecto',
        4 => 'Se creó cliente persona desde prospecto',
        5 => 'se creó el crédito',
        6 => 'Entró a KC - Check up',
        7 => 'Carga',
        8 => 'Formulario',
        9 => 'Reporte',
        10 => 'Crédito nómina reducción',
        11 => 'Carga',
        12 => 'Formulario',
        13 => 'Reporte',
        14 => 'Decisión',
        15 => 'Decisión',
        16 => 'Archivo',
        17 => 'Cancelado',
        18 => 'Rechazado',
        19 => 'En curso',
        20 => 'Nuevo crédito en KC - Check up',
        20 => 'Entró a KC - Control desk',
    ];

    public static $name_model = [
        6 => 'newCredit',
        10 => 'debtCredit',
        21 => 'debtCredit',
    ];

    public static function move($id_rel, $status_id, $old_status_id, $request = null)
    {
        if ($request != null) {
            $data = $request->data;
        }

        $data['id_rel']           = $id_rel;
        $data['status_id']        = $status_id;
        $data['old_status_id']    = $old_status_id;
        
        $get_status = HistoryLog::where($data)->first();

        self::removeInProgress($id_rel, $status_id);
        
        //*validate if old status exist
        $data_old_status = array(
            'old_status_id' => $old_status_id,
            'id_rel' => $id_rel,
        );
        //*if exist reset to 0
        $get_old_status = HistoryLog::where($data_old_status)->first();
        if ($get_old_status != null) {
            $get_old_status->status = 0;
            $get_old_status->update();
        }
        //* if new status and old status don't exist create status
        if ($get_status === null) {
            $data['user_id']    = Auth::user()->id;
            $history = new HistoryLog($data);
            $history->save();
            return $history;
        }
    }

    public function removeInProgress($id_rel, $status_id)
    {
        if ($status_id == HistoryLog::CREDIT_ARCHIVE || $status_id == HistoryLog::CREDIT_CANCELED || $status_id == HistoryLog::CREDIT_REJECTED) {
            $where = array(
                'id_rel' => $id_rel,
                'status_id' => HistoryLog::CREDIT_IN_PROGRESS,
            );
            HistoryLog::where($where)->update(['status' => 0]);
        }
    }

    public static function getByStatus($status_id, $id_rel = null)
    {
        $history = HistoryLog::wherein('status_id', $status_id);
        if ($id_rel != null) {
            $history->where('id_rel', $id_rel);
        }
        $history = $history->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->get();
        return $history;
    }

    //TODO:create a field in credit that is the name of the module and update that
    public function getStatusCredit($credit_id)
    {
        $data_status = array(
            HistoryLog::KC_CHECK_UP,
            HistoryLog::KC_CHECK_UP_DEBT_REDUCTION,
            HistoryLog::CREDIT_ARCHIVE,
            HistoryLog::CREDIT_CANCELED,
            HistoryLog::CREDIT_REJECTED,
        );
        $status = self::getByStatus($data_status, $credit_id);
        foreach ($status as $row_status) {
            if ($row_status->status_id == HistoryLog::KC_CHECK_UP || $row_status->status_id == HistoryLog::KC_CHECK_UP_DEBT_REDUCTION) {
                $status = 'En curso';
            } else {
                $status = HistoryLog::$label_status[$row_status->status_id];
            }
            return $status;
        }
    }

    public function historyLead()
    {
        return $this->belongsTo(Lead::class, 'id_rel');
    }
    
    public function historyLeadAdvisor()
    {
        return $this->belongsTo(LeadAdvisor::class, 'id_rel');
    }

    public function historyCredit()
    {
        return $this->belongsTo(Credit::class, 'id_rel');
    }
}
