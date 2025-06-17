<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FpTerm extends Model
{
    use HasFactory;
    protected $fillable = [
        'financial_product_id',
        'term_id',
    ];
    protected $table = 'f_p_terms';
}
