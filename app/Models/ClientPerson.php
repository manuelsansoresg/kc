<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPerson extends Model
{
    use HasFactory;
    protected $table = 'client_person';

    protected $fillable = [
        'name',
        'last_name',
        'second_last_name',
        'cellphone',
        'email',
        'agreement_id',
    ];

    public function credit()
    {
        return $this->hasMany(Credit::class);
    }
}
