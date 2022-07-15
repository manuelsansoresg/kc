<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'second_last_name',
        'status',
        'email',
        'password',
        'cellphone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getAdmin()
    {
        $users =  User::role('Administrador')->get();
        return $users;
    }

    public static function saveEdit($request)
    {
        if ($request->user_id == null) {
            $user = new User($request->except(['_token', 'pass_confirm', 'password', 'user_id']));
            $user->password = bcrypt($request->password);
            $user->save();
        } else {
            $user = User::find($request->user_id);
            $user->fill($request->except(['_token', 'pass_confirm', 'password', 'user_id']));
            $user->update();
        }
        $user->assignRole('Administrador');
    }

    public static function changePassword($request)
    {
        $user_id = $request->password_user_id;
        $user = User::find($user_id);
        $user->password = bcrypt($request->user_password);
        $user->update();
    }
}
