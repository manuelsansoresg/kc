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
            'client_person',
            'name',
            'client_person',
            'last_name',
            'client_person',
            'second_last_name',
            'client_person',
            'cellphone',
            'client_person',
            'validated_clabe',
            'client_person',
            'email',
            'client_person',
            'birth_date',
            'client_person',
            'rfc',
            'client_person',
            'curp',
            'client_person',
            'bank_name',
            'client_person',
            'bank_acount_number',
            'client_person',
            'bank_clabe',
            'client_person',
            'client_postal_code',
            'client_person',
            'client_street',
            'client_person',
            'client_home_external_number',
            'client_person',
            'client_home_internal_number',
            'client_person',
            'client_colony',
            'client_person',
            'client_city',
            'client_person',
            'client_state',
            'client_person',
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
