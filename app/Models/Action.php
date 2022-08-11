<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'subject',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'description',
        'advisor_id',
        'id_rel',
        'section',
        'status',
    ];

    const LEAD = 1;

    public static function saveEdit($request, $id = null)
    {
        $data = $request->data;
        $data['start_time'] = date('H:i:s', strtotime($data['start_time']));
        $data['end_time'] = date('H:i:s', strtotime($data['end_time']));
        if ($id == null) {
            $action = Action::create($data);
            return $action;
        }
    }
}
