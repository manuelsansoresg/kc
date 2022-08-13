<?php
namespace App\Strategies\Actions;

use App\Models\Action;
use App\Models\Lead;
use App\Models\User;
use App\Strategies\ActionInterface;
use Illuminate\Support\Facades\DB;

class LeadStrategy implements ActionInterface
{
    public $lead;
    public $advisor;

    public function get($id)
    {
        $action = Action::select(
            'id',
            'type',
            'subject',
            'start_date',
            DB::raw('TIME_FORMAT(start_time, "%h:%i %p") as start_time'),
            'end_date',
            DB::raw('TIME_FORMAT(end_time, "%h:%i %p") as end_time'),
            'description',
            'advisor_id',
            'id_rel',
            'section',
            'status',
        )->where('id', $id)->first();
        if ($action != null) {
            $this->advisor = User::find($action->advisor_id);
            $this->lead = Lead::find($action->id_rel);
        }
        return $action;
    }

    public function getAdvisor($advisor_id)
    {
        return $this->advisor;
    }

    public function getLead($lead_id)
    {
        return $this->lead;
    }
}
