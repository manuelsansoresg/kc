<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPersonHistory extends Model
{
    use HasFactory;

    protected $table = 'client_person_history';

    protected $fillable = [
        'client_person_id',
        'user_id',
        'field_name',
        'old_value',
        'new_value'
    ];

    public function clientPerson()
    {
        return $this->belongsTo(ClientPerson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 