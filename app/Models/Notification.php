<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_rel',
        'title',
        'body',
        'model',
        'status' //* 0 = enviado pero no recibido 1 = enviado y recibido
    ];

    //* constante para modelos
    const CREATE_PROSPECT         = 1;
    const ADD_PROSPECT            = 2;
    const BTN_NEXT_LEAD           = 3;

    public static function getByModel($model, $status = 0)
    {
        $notification = Notification::where(['model' => $model, 'status' => $status])->get();
        return $notification;
    }
    
}
