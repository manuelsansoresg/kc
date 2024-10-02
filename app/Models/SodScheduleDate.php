<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SodScheduleDate extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'schedule_1',
        'schedule_2',
        'schedule_3',
        'schedule_4',
    ];
}
