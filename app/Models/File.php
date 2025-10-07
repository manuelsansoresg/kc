<?php

namespace App\Models;

use App\Strategies\Values\TemplateValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'model',
        'id_rel',
        'client_id',
        'step',
        'template_config_id', //*id array config in templatestrategy
        'dynamic_status_id',
    ];

    const PATH = 'files_upload';
    const ACTION_LEAD = 1;
    
    const MODEL = [
        'lead' => 1,
        'newCredit' => 2,
        'controlDesk' => 21,
        'controlDeskFirmaContrato' => 74,
        'debtCredit' => 10,
        'delivery' => 30,
        'swap' => 37,
        'payment' => 49,
        'wallet' => 61,
        'kc-down-wallet' => 65,
    ];

    /**
     * Genera una cadena aleatoria de la longitud especificada.
     *
     * @param int $length La longitud de la cadena aleatoria.
     * @return string
     */
    private static function generateRandomString($length = 3)
    {
        return Str::random($length);
    }


    public static function saveCep($request, $creditId, $step_file = '3_5')
    {
        $getCredit = Credit::where('id', $creditId)->first();
        $client = ClientPerson::where('id', $getCredit->client_person_id)->first();
        $client_id = $client->id;

        $model = 21;
        $id_rel = $creditId;
        $template_config_id = 4;

        if ($request->hasFile('cep') != false) {
            $document   = $request->file('cep');
            $originalExtension = $document->getClientOriginalExtension();
            // Genera una cadena aleatoria de 3 caracteres
            $randomString = self::generateRandomString(3);
            // Construye el nombre completo del archivo con la cadena aleatoria
            $name_full = $id_rel . '-' . $client->name . $client->last_name . $client->second_last_name . 'CEP_' . $randomString . '.' . $originalExtension;

            $path       = File::PATH;
            
            if ($document->move($path, $name_full)) {
                $data = array(
                    'name' => $name_full,
                    'model' => $model,
                    'id_rel' => $id_rel,
                    'template_config_id' => $template_config_id,
                    'step' => $step_file,
                    'client_id' => $client_id,
                );
                
                File::create($data);
            }
        }
    }

    public static function isExistCep($creditId)
    {
        $getCredit = Credit::where('id', $creditId)->first();
        $client = ClientPerson::where('id', $getCredit->client_person_id)->first();
        $client_id = $client->id;
        return File::where('id_rel', $creditId)->where('template_config_id', 4)->where('step', '3_5')->where('client_id', $client_id)->count() > 0 ? true : false;

    }

    public static function upload($model, $id_rel, $request, $template_config_id = null)
    {
        $step = isset($request->step)? $request->step : null;
        if ($request->hasFile('file') != false) {
            $document   = $request->file('file');
            
            $name_full  = rand(1, 999).'-'.$document->getClientOriginalName();
            if (isset($_GET['nameField'])) {
                $uniquePrefix = uniqid(); 
                $name_full = $id_rel.'-'.$_GET['nameField'] . '-'.$uniquePrefix. '.' . $document->getClientOriginalExtension();
            }
            $path       = File::PATH;
            $date_file = ($request->date_file != null)? $request->date_file : null;
            
            if ($document->move($path, $name_full)) {
                $data = array(
                    'name' => $name_full,
                    'model' => $model,
                    'id_rel' => $id_rel,
                    'template_config_id' => $template_config_id,
                    'step' => $step,
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
    

    public static function getFileClients($clientId)
    {
        $files = File::where('client_id', $clientId)->get();
        return $files;
    }
    
    public static function getByIdRelandModel($id_rel, $models, $template_id = null)
    {
        //dd($models);
        $files = File::where(['id_rel' => $id_rel])->whereIn('model', $models)->where('client_id', null);
        if ($template_id != null) {
            $files->whereIn('template_config_id', $template_id);
        }
        $files= $files->get();
        //dd($files);
        $new_file = array();
        foreach ($files as $file) {
            $fileStrategy   = TemplateValues::STRATEGY[HistoryLog::$name_model[$file->model]];
            $get_file       = (new $fileStrategy)->getFile($file->template_config_id, $file->id_rel, $file->step);
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

    public static function getAllTemplate($model, $id_rel, $step = null)
    {
        $files = File::where(['model' => $model, 'id_rel' => $id_rel]);
        if ($step != null) {
            $files->where('step', $step);
        }
        
        $files = $files->get();
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
