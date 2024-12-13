<div class="row">
    <div class="col-6">
        <table class="table table-striped">
            <tr>
                <td>Primer apellido</td>
                <td>{{ $client!= null ? $client->ID_primer_apellido : null }}</td>
            </tr>
            <tr>
                <td>Segundo apellido</td>
                <td>{{ $client!= null ? $client->ID_segundo_apellido : null }}</td>
            </tr>
            <tr>
                <td>Nombres</td>
                <td>{{ $client!= null ? $client->ID_nombres : null }}</td>
            </tr>
            <tr>
                <td>Vigencia</td>
                <td>{{ $client!= null ? $client->ID_vigencia : null }}</td>
            </tr>
        </table>
    </div>
</div>