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
        $encoded_email = urlencode($email);
        $email = str_replace('%40', '@', $encoded_email);
        $record = TokenForms
                    ::where('email', $email)
                    ->where('token', $token)->first();
        
        if ($record == null) {
            return false;
        }

        // Checar si han pasado 30 minutos o más desde que se creó el registro
        if (Carbon::parse($record->updated_at)->addMinutes(14400)->isPast()) {
            return false;
        }

        return true;
    }
}
