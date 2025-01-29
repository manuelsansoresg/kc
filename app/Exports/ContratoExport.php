<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContratoExport implements FromArray, WithHeadings
{
    public $credit;

    public function __construct($credit)
    {
        $this->credit = $credit;
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
            'last_name',
            'second_last_name',
            'cellphone',
            'validated_clabe',
            'email',
            'birth_date',
            'rfc',
            'curp',
            'bank_name',
            'bank_acount_number',
            'bank_clabe',
            'client_postal_code',
            'client_street',
            'client_home_external_number',
            'client_home_internal_number',
            'client_colony',
            'client_city',
            'client_state',
            'client_country',
            'product_id',
            'agreement_id',
            'applied_financial_product',
            'applied_loan_type',
            'applied_import',
            'applied_term',
            'applied_periodicity',
            'applied_payment',
            'applied_total_amount',
            'applied_interest_rate',
            'applied_cat',
            'opening_commission_percentage',
            'opening_commission',
            'applied_loan_discount',
        ];
    }

    public function array(): array
    {
        return $this->credit;
    }
}
