<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    use HasFactory;
    /**
     ** type 1 = curp
     */
    protected $table = 'kyc';
    protected $fillable = [
        'credit_id',
        'answer',
        'type',
        'status'
    ];


    public static function set($credit_id, $type, $status, $answer)
    {
        $data_kyc = array('credit_id' => $credit_id, 'type' => $type);
        $kyc = Kyc::where($data_kyc)->first();
        if ($kyc == null) {
            $data_kyc['status'] = $status;
            $data_kyc['answer'] = json_encode($answer);
            Kyc::create($data_kyc);
        } else {
            $kyc->update(['answer' => json_encode($answer), 'status' => $status]);
        }
        return $kyc;
    }

    public function getCollection($credit_id, $type = 1)
    {
        $get_kyc = Kyc::where(['type' => $type, 'credit_id' => $credit_id])->first();
        if ($get_kyc != null) {
            $msg = json_decode($get_kyc->answer, true);
            return self::formatMsg($msg);
        }
        return null;
    }

    public static function formatMsg($msg)
    {
        $data_array = $msg;
        return \View::make('panel.kyc.msg', compact('data_array'))->render();
    }
}
