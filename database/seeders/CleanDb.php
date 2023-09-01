<?php

namespace Database\Seeders;

use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\HistoryLog;
use Illuminate\Database\Seeder;

class CleanDb extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = array(
            6,
            10,
            21,
            30,
            36,
            37,
            49
        );
        $history = HistoryLog::whereIn('status_id', $status)->where('status', 1)->get();
        foreach ($history as $history) {
            $credit = Credit::find($history->id_rel);
            if ($credit!= null) {
                $client = ClientPerson::find($credit->client_person_id)->delete();
            }
            HistoryLog::find($history->id)->delete();
        }
    }
}
