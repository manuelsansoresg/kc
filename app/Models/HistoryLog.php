<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryLog extends Model
{
    use HasFactory;

    const LEAD_ARCHIVE    = 1;
    const ADD_PROSPECT    = 2;
    const CREATE_PROSPECT = 3;

    protected $fillable = [
        'id_rel',
        'status_id',
        'old_status_id',
        'reason',
        'file',
        'comment',
        'status',
    ];

    public static $label_status = [
        1 => 'Se archivó el prospecto',
        2 => 'Se asigno el prospecto a',
        3 => 'Se créo el prospecto',
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
            $history = new HistoryLog($data);
            $history->save();
            return $history;
        }
    }

    public function getByStatus($status)
    {
        return HistoryLog::wherein('status', $status)->where('status', 1)->get();
    }

    public function historyLead()
    {
        return $this->belongsTo(Lead::class, 'id_rel');
    }
    
    public function historyLeadAdvisor()
    {
        return $this->belongsTo(LeadAdvisor::class, 'id_rel');
    }
}
