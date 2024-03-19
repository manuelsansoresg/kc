<?php

namespace App\Models\kaaxSidecc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsLogKaaxSidecc extends Model
{
    use HasFactory;

    protected $connection = 'kaax_sidecc';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $table = 'clients_log';

    protected $fillable = [
        'log_id',  'user_id', 'status_id', 'old_status_id', 'active',  'tipo' , 'status_is_pago'
    ];

    public static function addCrmLog($log_id, $section, $old_section)
    {
        $status_id = CrmStatusListKaaxSidecc::getCrmStatus($section)->id;
        $old_section_id = CrmStatusListKaaxSidecc::getCrmStatus($old_section)->id;

        $get_client = ClientsLogKaaxSidecc::where(['log_id' => $log_id, 'old_status_id' => $old_section, 'active' => 1])->first();
        $client_log = null;
        

        if ($get_client == null) {
            $data_client = ['log_id' => $log_id, 'status_id' => $status_id, 'old_status_id' => $old_section_id, 'active' => 1];
            $client_log = new ClientsLogKaaxSidecc($data_client);
            $client_log->save();
        } else {
            $is_new_log = ClientsLogKaaxSidecc::where(['log_id' => $log_id, 'status_id' => $status_id, 'active' => 1])->first();
            if ($is_new_log == null) {
                $data_client = ['log_id' => $log_id, 'status_id' => $status_id, 'old_status_id' => $old_section_id, 'active' => 1];
                $client_log = new ClientsLogKaaxSidecc($data_client);
                $client_log->save();

                $get_client->active = 0;
                $get_client = $get_client->update();
            }
        }
    }
}
