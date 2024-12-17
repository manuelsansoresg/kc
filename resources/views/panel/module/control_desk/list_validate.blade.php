<table class="table table-striped">
@foreach ($creditControlDesk as $creditControlDesk)
    <tr>
        <td>{{ $creditControlDesk->validation }}</td>
        <td>
            @if ($creditControlDesk->status == 1)
                <span class="text-success">Válido</span>
                @else
                <span class="text-warning">Inválido</span>
            @endif
        </td>
    </tr>
    @endforeach
</table>