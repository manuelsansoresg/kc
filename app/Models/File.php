<?php

namespace App\Models;

use App\Strategies\Values\TemplateValues;
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
        'debtCredit' => 10,
        'delivery' => 30,
        'swap' => 37,
        'payment' => 49,
        'wallet' => 61,
        'kc-down-wallet' => 65,
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

    public static function getAll($model, $id_rel)
    {
        $files = File::where(['model' => $model, 'id_rel' => $id_rel])->get();
        $view_files = \View::make('panel.action.dropzone_preview', ['files' => $files, 'model' => $model])->render();
        return $view_files;
    }
    
    public static function getByIdRelandModel($id_rel, $models, $template_id = null)
    {
        //dd($models);
        $files = File::where(['id_rel' => $id_rel])->whereIn('model', $models);
        if ($template_id != null) {
            $files->whereIn('template_config_id', $template_id);
        }
        $files= $files->get();
        //dd($files);
        $new_file = array();
        foreach ($files as $file) {
            $fileStrategy   = TemplateValues::STRATEGY[HistoryLog::$name_model[$file->model]];
            $get_file       = (new $fileStrategy)->getFile($file->template_config_id);
            if (isset( $get_file['name'])) {
                $new_file[] = array('name_template' => $get_file['name'], 'name' => $file->name);
            }
        }
        return $new_file;
    }

    public static function getFilesBySwap($credit_id)
    {
        $files = File::where(['id_rel' => $credit_id])->whereIn('model', [37])->whereIn('template_config_id', [1,4])->get();
        return $files;
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

    public static function updateModel($id_rel, $model, $old_models)
    {
        $get_files = File::where('id_rel', $id_rel)
        ->whereIn('model', $old_models)
        ->update(['model' => $model]);
        return $get_files;
    }
}
