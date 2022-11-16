<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sendgridtest extends Model
{
    use HasFactory;
    protected $table = 'sendgridtests';
    protected $fillable = [
        'body'
    ];
}
