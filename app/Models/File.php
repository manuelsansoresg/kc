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
    ];

    const PATH = 'files_upload';
    const ACTION_LEAD = 1;

    public static function upload($model, $id_rel, $request)
    {
        if ($request->hasFile('file') != false) {
            $document   = $request->file('file');
            $name_full  = rand(1, 999).'-'.$document->getClientOriginalName();
            $path       = File::PATH;
            if ($document->move($path, $name_full)) {
                $data_file = array(
                    'name' => $name_full,
                    'model' => $model,
                    'id_rel' => $id_rel
                );
                File::create($data_file);
            }
        }
    }

    public static function getAll($model, $id_rel)
    {
        $files = File::where(['model' => $model, 'id_rel' => $id_rel])->get();
        $view_files = \View::make('panel.action.dropzone_preview', ['files' => $files, 'model' => $model])->render();
        return $view_files;
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
}
