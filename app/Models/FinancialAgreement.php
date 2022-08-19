<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAgreement extends Model
{
    use HasFactory;
    protected $fillable = [
        'agreement_id',
        'financial_id',
    ];
    protected $primaryKey = 'agreement_id';

    public static function saveEdit($agreement_id, $request)
    {
        $get_configuration = FinancialAgreement::find($agreement_id);
        if ($get_configuration != null) {
            $get_configuration->delete();
        }

        $financials = $request->financials;
        foreach ($financials as $key => $financial) {
            $data_financial = array(
                'agreement_id' => $agreement_id,
                'financial_id' => $financial ,
            );
            $n_financial = FinancialAgreement::create($data_financial);
        }
    }

    public function agreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id');
    }
}
