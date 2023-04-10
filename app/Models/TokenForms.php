<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenForms extends Model
{
    use HasFactory;
    protected $fillable = [
        'token',
        'email',
    ];

    public static function validateToken($token, $email)
    {
        dd($email);
        $record = TokenForms
                    ::where('email', $email)
                    ->where('token', $token)->first();
        
        if ($record == null) {
            return false;
        }

        // Checar si han pasado 30 minutos o más desde que se creó el registro
        if (Carbon::parse($record->updated_at)->addMinutes(1440)->isPast()) {
            return false;
        }

        return true;
    }
}
