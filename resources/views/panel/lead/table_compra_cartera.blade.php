@php
    $total = 0;
@endphp
<table class="table">
    <thead>
        <tr>
            <th>Producto financiero</th>
            <th>Saldo</th>
            <th></th>
        </tr>
        
        
    </thead>
    <tbody>
        @foreach ($creditPays as $creditPay)
        @php
            $total += $creditPay->ammount;
        @endphp
        <tr>
            <td>{{ $creditPay->alias }}</td>
            <td>${{ format_price($creditPay->ammount) }}</td>
            <td>
                <a class="pointer" onclick="editCompraCartera({{ $creditPay->id }})"><i class="fa-solid fa-pen"></i></a>
                <a class="pointer" onclick="deleteCompraCartera({{ $creditPay->id }})"><i class="fa-solid fa-trash"></i></a>
            </td>
        </tr>
    @endforeach
        <tr>
            <td  class="text-end">Total: </td>
            <td colspan="2">{{ format_price($total)}}</td>
        </tr>
        <tr>
            <td colspan="3" class="text-end"> <a onclick="graficaProspecto()">Ver gráfica <i class="fas fa-external-link-alt"></i> </a> </td>
        </tr>
    </tbody>
</table>
