<?php

namespace App\Models;

use App\Lib\Csendgrid;
use App\Strategies\Values\TemplateValues;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        'cellphone',
        'email',
        'status',
        'password',
        'financial_id',
        'type_person',
        'rol_id',
        'is_rss',
        'is_access_config',
        'tyc_accept'

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

    public static $alias_role = [
        'Administrador' => 'Admin',
        'Asesor' => 'Asesor',
        'Cliente persona' => 'Cliente',
        'Cliente financiera' => 'Financiera',
        'Sistema' => 'KaaxClub',
    ];

    public static function getUserRole($role)
    {
        $users =  User::select(
            'id',
            'name',
            'last_name',
            'second_last_name',
            'cellphone',
            'email',
            DB::raw('(CASE 
            WHEN status = "1" THEN "Sí" 
            WHEN status = "0" THEN "No" 
            END) AS status'),
            'financial_id',
            'type_person'
        )
            ->role($role)
            ->get();
        return $users;
    }

    public static function saveEdit($request)
    {
        $is_save = false;
        if ($request->user_id == null) {
            $user = new User($request->except(['_token', 'pass_confirm', 'password', 'user_id', 'type_user']));
            $user->password = bcrypt($request->password);
            $user->save();
            $is_save = true;
        } else {
            $user = User::find($request->user_id);
            $user->fill($request->except(['_token', 'pass_confirm', 'password', 'user_id', 'type_user']));
            $user->update();
        }
        $role = $request->type_user;
        
        if ($request->type_user == 'cliente-persona' ) {
            $role = 'Cliente persona';
            if ($is_save == true) {
                $to = $user->email;
                $send_grid = new Csendgrid($to, 'creacion cuenta');
                $send_grid->setTemplate('d-2e7d6583de1647f4bc12ab6410b956b2');
                $send_grid->setParams(['first_name'=> $user->name]);
                $send_grid->send();
            }
        }
        
        if ($request->type_user == 'cliente-financiera') {
            $role = 'Cliente financiera';
        }
        $user->assignRole(ucfirst($role));
    }
    public static function saveLeadClientPersona($data, $is_report = false)
    {
        $name       = explode(' ', $data['name']);
        $password   = 'hola'.$name[0];
        $lead_id    = $data['id'];
        $user       = null;
        //*Check that the email does not exist in credits
        $find_lead  = Lead::find($lead_id);
        $find_user  = User::where('email', $find_lead->email)->first();

        $token = \Str::random(64);
        $token = str_replace('/', '', $token);
        
        PasswordReset::setToken($find_lead->email, $token);
        
        if ($find_user != null) {
             //* send email new account
            if ($is_report == false) {
                $link_password = 'https://app.kaaxclub.com/password/'.$token.'/'.$find_lead->email.'/change';
                $domain = 'https://app.kaaxclub.com';
                $link_login = $domain.'/login';
                $send_grid = new Csendgrid($find_lead->email, 'creacion cuenta');
                $send_grid->setTemplate('d-ea081e65c8014113b50315a103127d13');
                $send_grid->setParams(['first_name'=> $find_lead->name, 'link_login' => $link_login, 'link_password_change' => $link_password]);
                $send_grid->send();
            }

        } else {
            $link_password = 'https://app.kaaxclub.com/password/reset/'.$token.'?email='.$find_lead->email;
            unset($data['id']);
            //*create user with leads parameters
            $user = new User($data);
            $user->password = bcrypt($password);
            $user->save();
            

            //*assign role user
            $role = 'Cliente persona';
            $user->assignRole(ucfirst($role));

            //*create relation lead to client
            $data_lead_client = array(
                'lead_id' => $lead_id,
                'client_person_id' => $user->id
            );
            $lead_client = new LeadClient($data_lead_client);
            $lead_client->save();
            //* send email new account
            $domain = 'https://app.kaaxclub.com';
            //$link_account = $domain.'/account/'.$user->id.'/password/setup';
            $body = 'Usuario: '. $user->mail. '<br> Contraseña: '.$password;
            $send_grid = new Csendgrid($data['email'], 'creacion cuenta');
            $send_grid->setTemplate('d-235b3d5c43c14184b365def8c1d1e160');
            $send_grid->setParams(['first_name'=> $data['name'], 'link_account' => $link_password, 'body' => $body]);
            $send_grid->send();
        }
        return $user;
    }
    public static function saveClientPersona($data)
    {
        $name       = $data['name'];
        $password   = 'hola'.$name;
        $email      = $data['email'];
        //*Check that the email does not exist in credits
        $find_user  = User::where('email', $email)->first();
        
        if ($find_user == null) {
            //*create user with leads parameters
            $user             = new User($data);
            $user->password   = bcrypt($password);
            $user->save();

            $to           = $user->email;
            $send_grid    = new Csendgrid($to, 'creacion cuenta');

            $send_grid->setTemplate('d-2e7d6583de1647f4bc12ab6410b956b2');
            $send_grid->setParams(['first_name'=> 'Manuel']);
            $send_grid->send();
            $find_user    = $user;
        }
        return $find_user;
    }

    public static function changePassword($request)
    {
        $user_id = $request->password_user_id;
        $user = User::find($user_id);
        $user->password = bcrypt($request->user_password);
        $user->update();
    }

    public static function listDatatable($type = 1)
    {
        if ($type == 1) {
            $get_users    = self::getUserRole('Administrador');
        } elseif ($type == 3) {
            $get_users    = self::getUserRole('Cliente persona');
        } elseif ($type == 4) {
            $get_users    = self::getUserRole('Cliente financiera');
        } else {
            $get_users    = self::getUserRole('Asesor');
        }
        

        $users        = array();
        
        foreach ($get_users as $user) {
            $client_person = ClientPerson::where('email', $user->email)->first();
            $id = isset( $client_person->id) ?  $client_person->id : null;
            $option = \View::make('panel.user.add_option_dt', [ 'type' => 2, 'user_id' => $user->id, 'id' =>$id])->render();
            $lbl_status = '<span class="text-success">Sí</span>';
            if ($user->status == 'No') {
                $lbl_status = '<span class="text-danger">No</span>';
            }
            if ($type != 4) {
                $users[] = array(
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'second_last_name' => $user->second_last_name,
                    'cellphone' => $user->cellphone,
                    'email' => $user->email,
                    'status' => $lbl_status,
                    'options' => $option
                );
            } else {
                $financial = $user->financial;
                $type_person = config('enums.type_person');
                
                $users[] = array(
                    'financial' => ($financial != null) ? $financial->commercial_name : '',
                    'type_person' => $type_person[$user->type_person],
                    'name' => $user->last_name.' '.$user->name,
                    'email' => $user->email,
                    'cellphone' => $user->cellphone,
                    'status' => $lbl_status,
                    'options' => $option
                );
            }
        }
        return $users;
    }

    public function getAccesConfig()
    {
        $user = User::find(Auth::user()->id);
        return $user->is_access_config;
    }

    public function financial()
    {
        return $this->belongsTo(Financial::class, 'financial_id');
    }

    public function lead()
    {
        return $this->hasOne(Lead::class);
    }

    public function note()
    {
        return $this->hasOne(Note::class);
    }
    
    public function credit()
    {
        return $this->hasOne(Credit::class);
    }
}
