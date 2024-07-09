<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadExport implements FromArray, WithHeadings
{
    public $lead;

    public function __construct($lead)
    {
        $this->lead = $lead;
    }

    public function headings(): array
    {
        return [
            'name',
            'last_name',
            'second_last_name',
            'cellphone',
            'email',
            'rfc',
            'servicio',
            'organizacion',
            'producto_financiero',
            'productos_financieros',
            'importe_solicitado',
            'income',
            'banco',
            'consulta_buro',
            'aval_garantia',
        ];
    }

    public function array(): array
    {
        return $this->lead;
    }

}
