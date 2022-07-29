<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'user_id'];

    public function leadNote()
    {
        return $this->hasOne(LeadNote::class);
    }

    public function userNote()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
