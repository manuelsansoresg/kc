<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;
    protected $fillable = [
        'commercial_name',
        'company_name',
    ];

    public function saveEdit($request)
    {
        if ($request->financial_id == null) {
            $financial = Financial::create($request->except(['_token', 'financial_id']));
        } else {
            $financial = Financial::find($request->financial_id);
            $financial->fill($request->except(['_token', 'financial_id']));
            $financial->update();
        }
        return $financial;
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
