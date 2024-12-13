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
    ];

    public static function saveEdit($creditId, $request, $validate, $mandatory =1)
    {
        $idvalue  = Str::slug($validate);
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
        if ($getExist->count() == 0) {
            CreditsControlDesk::create($dataCredit);
        } else {
            $getExist->update($dataCredit);
        }
    }
}
