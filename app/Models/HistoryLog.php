<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_rel',
        'status_id',
        'old_status_id',
        'reason',
        'file',
        'comment',
        'status',
    ];

    public static $status = [
        'lead-archive' => 1,
    ];

    public static function move($id_rel, $status_id, $old_status_id, $request = null)
    {
        $status_id                = HistoryLog::$status[$status_id];
        $old_status_id            = HistoryLog::$status[$old_status_id];
        
        if ($request != null) {
            $data = $request->data;
        }

        $data['id_rel']           = $id_rel;
        $data['status_id']        = $status_id;
        $data['old_status_id']    = $old_status_id;
        $get_status = HistoryLog::where($data)->count();
        if ($get_status === 0) {
            $history = new HistoryLog($data);
            $history->save();
            return $history;
        }
    }

    public function historyLead()
    {
        return $this->belongsTo(Lead::class, 'id_rel');
    }
}
