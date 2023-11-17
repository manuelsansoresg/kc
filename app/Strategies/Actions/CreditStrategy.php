<?php
namespace App\Strategies\Actions;

use App\Models\Action;
use App\Models\Credit;
use App\Models\CreditNotes;
use App\Models\CreditTag;
use App\Models\Lead;
use App\Models\LeadNote;
use App\Models\Note;
use App\Models\User;
use App\Strategies\ActionInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreditStrategy implements ActionInterface
{

    public $advisor;
    
    public function get($id)
    {
    }

    
    public function listAction($id, $model, $status)
    {
        $status   = Action::STATUS[$status];
        $model    = Action::MODEL[$model];
        $actions   = Action::getByModel($id, $model, $status);
        $list = \View::make('panel.action.list_action', [ 'actions' => $actions, 'status' => $status, 'model' => $model])->render();
        return $list;
    }

    public function getAdvisor()
    {
        return $this->advisor;
    }

    public function listDt($status, $model_action)
    {
        $credit           = Credit::find($model_action->id_rel);
        $client = $credit->creditClientPerson;
        $advisor        = User::find($model_action->advisor_id);
        $type_actions   = config('enums.type_actions');
        $data_option = array(
            'status' => $status,
            'model' => $model_action,
            'lead' => null,
            'credit' => $credit,
        );
        $option         = \View::make('panel.action.add_option_dt', $data_option)->render();
        $name = $client !== null ? $client->name.' '.$client->last_name : null;
        $date = ($model_action->start_date != null) ? formatDateNameMonth(date('Y-m-d H:i:s', strtotime($model_action->start_date.' '. $model_action->start_time))): null;
        $data = array(
            'type' => $type_actions[$model_action->type],
            'subject' => $model_action->subject,
            'section' => Action::NAME_MODEL[$model_action->section],
            'name' => $name,
            'date_in' => $date,
            'date_fin' => formatDateNameMonth($model_action->end_date),
            'advisor' => ($advisor!= null)?$advisor->name. ' '. $advisor->last_name : '',
            'options' => $option
        );
        return $data;
    }


    public function saveNote($request)
    {
        $user_id        = Auth::user()->id;
        $note           = Note::create(['description' => $request->description, 'user_id' => $user_id]);
        $credit_note    = CreditNotes::create(['credit_id' => $request->id_rel, 'note_id'=> $note->id]);
    }

    public function saveTag($request)
    {
        CreditTag::saveEdit($request->credit_id, $request);
    }

    public function getTags($credit_id)
    {
        $tags = CreditTag::where('credit_id', $credit_id)->get();
        $list = \View::make('panel.credit.tags', [ 'tags' => $tags])->render();
        return ['tags' => $list];
    }

    public function deleteTag($tag_id)
    {
        $tag = CreditTag::find($tag_id);
        $tag->delete();
    }
    
    public function getNotes($credit_id)
    {
        $notes = CreditNotes::where('credit_id', $credit_id)->get();
        $list = \View::make('panel.credit.notes', [ 'notes' => $notes])->render();
        return ['tags' => $list];
    }
}
