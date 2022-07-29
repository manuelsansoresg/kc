<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id' ,
        'note_id' ,
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function note()
    {
        return $this->belongsTo(Note::class, 'note_id');
    }

}
