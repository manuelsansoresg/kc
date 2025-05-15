<table class="table">
    <thead class="">
        <tr>
            <th>Validación</th>
            <th>Estado</th>
            <th>Texto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($validations as $validation)
            <tr>
                <td>{{ $validation->validation }}</td>
                <td>
                    @if($validation->status == 1)
                        <span class="badge bg-primary">Aprobado</span>
                    @else
                        <span class="badge bg-danger">No Aprobado</span>
                    @endif
                </td>
                <td>{{ $validation->texto }}</td>
            </tr>
        @endforeach
    </tbody>
</table> 