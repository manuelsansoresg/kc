<?php

namespace App\Models\kaaxSidecc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionKaaxSidecc extends Model
{
    use HasFactory;
    protected $connection = 'kaax_sidecc';
    protected $table = 'collections';
}
