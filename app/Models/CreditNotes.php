<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditNotes extends Model
{
    use HasFactory;
    protected $fillable = [
        'credit_id',
        'note_id',
    ];

    public function note()
    {
        return $this->belongsTo(Note::class, 'note_id');
    }
}
