<?php

namespace App\Models;

use App\Strategies\Values\TemplateValues;
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

        $templateStrategy  = TemplateValues::STRATEGY[$request->model];

        foreach ($dates as $key => $date) {
            $data = array(
                'template_config_id' => $key,
                'id_rel' => $request->id_rel,
                'model' => $models[$request->model],
            );
            $template = TemplateFile::where($data);
            if ($template->count() === 0) {
                $data['date_file'] = $date;
                TemplateFile :: create($data);
            } else {
                $data['date_file'] = $date;
                $template->update($data);
            }
        }

        if ($request->model == 'controlDesk') {
            $percent_form   = (new $templateStrategy)->percentFile($request->id_rel);
            if ($percent_form == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_UPLOAD, $request->id_rel, 1);
            }
        }
    }
}
