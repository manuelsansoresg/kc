<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadAdvisor extends Model
{
    use HasFactory;
    protected $fillable = [
        'lead_id',
        'advisor_id'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function history()
    {
        return $this->hasOne(HistoryLog::class);
    }
}
