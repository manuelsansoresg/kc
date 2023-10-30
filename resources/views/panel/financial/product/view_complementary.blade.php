<br>
<table class="table table-borderless mt-5">
    
    
    @foreach ($query as $query)
        <tr>
            <td> {{ $query->description }} </td>
            <td class="float-end">
                <a onclick="editComplementary({{$query->id}}, '{{  $query->description }}')" class="btn btn-outline-primary">Editar</a>
                <a onclick="deleteComplementary({{ $query->id }})" class="btn btn-outline-danger">Borrar</a>
            </td>
        </tr>
    @endforeach

</table>