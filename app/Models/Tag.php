<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type_id',
        'section_id',
        'comment',
        'status',
    ];

    public static function saveEdit($request)
    {
        $data = $request->data;
        if ($request->tag_id == 'null') {
            $action = Tag::create($data);
        } else {
            $action = Tag::find($request->tag_id);
            $action->fill($data);
            $action->update();
        }
        return $action;
    }

    public static function listDatatable()
    {
       
        
        $get_list    = Tag::all();
        $users        = array();
        foreach ($get_list as $query) {
            $types = config('enums.type_tags');
            $sections = config('enums.type_section');
            $option = \View::make('panel.tag.add_option_dt', [ 'type' => 2, 'id' => $query->id])->render();
            
            $lbl_status = '<span class="text-success">Sí</span>';
            if ($query->status == 0) {
                $lbl_status = '<span class="text-danger">No</span>';
            }
            
            $users[] = array(
                'name' => $query->name,
                'type' => $types[$query->type_id],
                'section' =>$sections[$query->section_id],
                'description' => $query->comment,
                'status' => $lbl_status,
                'options' => $option
            );
        }
        return $users;
    }
}
