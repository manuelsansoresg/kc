<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterAction extends Model
{
    use HasFactory;
    protected $fillable = [
        'action_id',
        'state',
        'comment',
    ];
    protected $primaryKey = 'action_id';
}
