<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditTag extends Model
{
    use HasFactory;
    protected $fillable = [
        'credit_id',
        'tag_id',
    ];
    protected $table = 'credit_tag';

    public static function saveEdit($credit_id, $request)
    {
        $tags = $request->tags;
        foreach ($tags as $key => $tag) {
            $data_financial = array(
                'credit_id' => $credit_id,
                'tag_id' => $tag ,
            );
            $new_tag = CreditTag::create($data_financial);
        }
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
