<table class="table table-borderless">
    <thead>
        <tr>
            <th scope="col">Concepto</th>
            <th scope="col">Valor</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($errors as $key => $error)
        <tr>
            <td>{{ $key }}</td>
            <td>
                @if ($error === true)
                <span class="badge bg-danger">Invalido</span>
                @else
                <span class="badge bg-success">Valido</span>
                @endif
            </td>
        </tr>
        @endforeach
       
        
    </tbody>
</table>
