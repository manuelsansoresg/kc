<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_person_id',
        'product_id',
        'financial_id',
        'agreement_id',
        'origin_id',
        'channel_id',
        'type_id',
        'asesor_id',
    ];

    public function creditClientPerson()
    {
        return $this->belongsTo(ClientPerson::class, 'client_person_id');
    }

    public function creditProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
