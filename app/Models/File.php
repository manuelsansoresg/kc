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
}
