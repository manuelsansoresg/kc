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
    const KC_CHECK_UP_DEBT_REDUCTION          = 10;
    const KC_CHECK_UP_DEBT_REDUCTION_UPLOAD   = 11;
    const KC_CHECK_UP_DEBT_REDUCTION_FORM     = 12;
    const KC_CHECK_UP_DEBT_REDUCTION_REPORT   = 13;

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
    ];

    public static $name_model = [
        6 => 'newCredit',
        10 => 'debtCredit',
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

    public static function getByStatus($status_id, $id_rel = null)
    {
        $history = HistoryLog::wherein('status_id', $status_id);
        if ($id_rel != null) {
            $history->where('id_rel', $id_rel);
        }
        $history = $history->where('status', 1)->get();
        return $history;
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
