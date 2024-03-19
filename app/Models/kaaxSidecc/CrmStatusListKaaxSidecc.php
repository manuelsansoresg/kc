<?php

namespace App\Models\kaaxSidecc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmStatusListKaaxSidecc extends Model
{
    use HasFactory;

    protected $connection = 'kaax_sidecc';
    
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $table = 'crm_status_list';
    
    protected $fillable = [
        'name', 'description', 'active', 'slug', 'alias'
    ];

    public static function getCrmStatus($name)
    {
        return CrmStatusListKaaxSidecc::where('slug', $name)->first();
    }
}
