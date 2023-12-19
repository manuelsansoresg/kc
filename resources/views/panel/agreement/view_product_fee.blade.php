<div class="table-responsive mt-5">
    <table class="table">
        <thead>
            <tr>
            <th>Concepto</th>
            <th>Periodicidad</th>
            <th>Valor</th>
            
            <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($fees as $key => $fees)
            <tr>
                <td>{{ $fees->concepto }}</td>
                <td>  {{ isset(config('enums.periodicity_comision')[$fees->periodicidad]) ? config('enums.periodicity_comision')[$fees->periodicidad] : null }}</td>
                @if ($fees->is_valor_fijo == 1)
                <td> {{ $fees->valor }}</td>
                @else
                <td>{{ $fees->porcentaje }}%</td>
                @endif
                <td>
                    <a onclick="editProductFee({{ $fees->id }}, {{ $fees->financial_product_id }}, {{ $fees->type }})"  class="btn btn-primary"> <i class="fa-solid fa-pen-to-square"></i> </a>
                    <a onclick="deleteProductFee({{ $fees->id }})" class="btn btn-danger"> <i class="fa-solid fa-trash"></i> </a>
                </td>
            </tr>
            
        @endforeach
        </tbody>
    </table>
</div>