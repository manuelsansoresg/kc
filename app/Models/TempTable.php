<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempTable extends Model
{
    use HasFactory;
    protected $table = 'temp';
    protected $fillable = ['data'];
    public $timestamps = false;
    
    const CREATED_AT = null;
    const UPDATED_AT = null;
}
