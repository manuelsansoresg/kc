<div class="table-responsive mt-5">
    <table class="table">
    
        
        @foreach ($fees as $key => $fees)
            @if ($key == 0)
            <thead>
                <tr>
                <th>Concepto</th>
                <th>Periodicidad</th>
                @if ($fees->type == 1)
                <th>Valor</th>
                @else
                <th>Porcentaje</th>
                @endif
                <th></th>
                </tr>
            </thead>
            <tbody>
            @endif
            <tr>
                <td>{{ $fees->concepto }}</td>
                <td>  {{ isset(config('enums.periodicity')[$fees->periodicidad]) ? config('enums.periodicity')[$fees->periodicidad] : null }}</td>
                @if ($fees->type == 1)
                <td> {{ $fees->valor }}</td>
                @else
                <td>{{ $fees->porcentaje }}</td>
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