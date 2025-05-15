<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreditsControlDesk extends Model
{
    use HasFactory;
    protected $table = 'credits_control_desk';
    protected $fillable = [
        'credit_id',
        'validation',
        'status',
        'mandatory',
    ];

    public static $labelValidate = [
        1 => 'Validar INE',
        2 => 'Validar última nómina',
        3 => 'Determinar CP real',
        4 => 'Determinar crédito',
        5 => 'Validar clabe cliente',
        6 => 'dynamic',
        7 => 'Contrato de crédito',
        8 => 'Solicitud/Descuento SOD',
        9 => 'Firma de contrato válida',
        10 => 'Fondos suficientes',
    ];

    public static function saveEdit($creditId, $request, $validate, $task_id = null, $isOnlyCreate = false, $mandatory =1, $aliasProduct = null)
    {
        $idvalue  = Str::slug($validate).$task_id;

        if ($validate == 'dynamic') {
            $validate = $aliasProduct;
        }
        $value = $request->$idvalue;
        
        $getExist = CreditsControlDesk::where([
            'credit_id' => $creditId,
            'validation' => $validate,
        ]);

        $dataCredit = array(
            'credit_id' => $creditId,
            'validation' => $validate,
            'status' => $value,
            'mandatory' => $mandatory,
        );
        if ($isOnlyCreate == false) {
            if ($getExist->count() == 0) {
                CreditsControlDesk::create($dataCredit);
            } else {
                $getExist->update($dataCredit);
            }
        } else {
            CreditsControlDesk::create($dataCredit);
        }
    }

    public static function isValidate($creditId)
    {
         // Verifica si existe algún registro con status distinto de 1
        $hasInvalidStatus = CreditsControlDesk::where('credit_id', $creditId)
        ->where('status', '!=', 1)
        ->exists();

        // Devuelve true si NO existen registros con status distinto de 1
        return !$hasInvalidStatus;
    }
}
