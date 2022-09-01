<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_config_id',
        'date_file',
        'id_rel',
        'model'
    ];

    protected $table = 'template_file';

    public static function saveTemplate($request)
    {
        $dates = $request->date_file;
        $models = File::MODEL;
        foreach ($dates as $key => $date) {
            $data = array(
                'template_config_id' => $key,
                'date_file' => $date,
                'id_rel' => $request->id_rel,
                'model' => $models[$request->model],
            );
           TemplateFile :: create($data);
        }
    }
}
