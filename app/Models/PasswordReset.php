<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token'
    ];

    public static function setToken($email, $token)
    {
        $get_password = PasswordReset::where('email', $email);
        
        if ($get_password->count() == 0) {
            PasswordReset::create([
                'email' => $email,
                'token' => $token,
            ]);
        } else {
            $get_password = PasswordReset::where('email', $email)
            ->update(['token' => urldecode($token)]);
        }
    }
}
