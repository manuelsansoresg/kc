<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'model',
        'id_rel',
        'template_config_id' //*id array config in templatestrategy
    ];

    const PATH = 'files_upload';
    const ACTION_LEAD = 1;
    
    const MODEL = [
        'lead' => 1,
        'newCredit' => 2,
        'controlDesk' => 21,
    ];

    public static function upload($model, $id_rel, $request, $template_config_id = null)
    {
        if ($request->hasFile('file') != false) {
            $document   = $request->file('file');
            $name_full  = rand(1, 999).'-'.$document->getClientOriginalName();
            $path       = File::PATH;
            $date_file = ($request->date_file != null)? $request->date_file : null;
            if ($document->move($path, $name_full)) {
                $data = array(
                    'name' => $name_full,
                    'model' => $model,
                    'id_rel' => $id_rel,
                    'template_config_id' => $template_config_id
                );
                
                File::create($data);
            }
        }
    }

   /*  public function FunctionName(Type $var = null)
    {
        # code...
    } */

    public static function getAll($model, $id_rel)
    {
        $files = File::where(['model' => $model, 'id_rel' => $id_rel])->get();
        $view_files = \View::make('panel.action.dropzone_preview', ['files' => $files, 'model' => $model])->render();
        return $view_files;
    }

    public static function getAllTemplate($model, $id_rel)
    {
        $files = File::where(['model' => $model, 'id_rel' => $id_rel])->get();
        $data_file = array();
        foreach ($files as $file) {
            if ($file->template_config_id != null) {
                $view_file = \View::make('panel.action.dropcone_preview_one_file', ['file' => $file, 'model' => $model])->render();
                $data_file[] = array('template_config_id' => $file->template_config_id, 'preview' => $view_file);
            }
        }
        return $data_file;
    }

    public static function deleteByModel($model, $id_rel)
    {
        $files = File::where([
            'model'=> $model,
            'id_rel' => $id_rel,
        ])->get();

        foreach ($files as $file) {
            unlink(File::PATH.'/'.$file->name);
            $get_file = File::find($file->id);
            $get_file->delete();
        }
    }

    public static function updateModel($id_rel, $model)
    {
        $get_files = File::where([
            'id_rel' => $id_rel,
            'model' => $model
        ])->update(['model' => $model]);
        return $get_files;
    }
}
