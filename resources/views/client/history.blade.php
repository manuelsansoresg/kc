@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    <h4>Historial de cambios - {{ $client->name }} {{ $client->last_name }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Campo</th>
                                    <th>Valor Anterior</th>
                                    <th>Valor Nuevo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $record)
                                    <tr>
                                        <td>{{ $record->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ $record->user->name ?? 'N/A' }}</td>
                                        <td>
                                            @switch($record->field_name)
                                                @case('name')
                                                    Nombre
                                                    @break
                                                @case('last_name')
                                                    Apellido Paterno
                                                    @break
                                                @case('second_last_name')
                                                    Apellido Materno
                                                    @break
                                                @case('email')
                                                    Correo Electrónico
                                                    @break
                                                @case('cellphone')
                                                    Teléfono Celular
                                                    @break
                                                @case('active')
                                                    Estado
                                                    @break
                                                @default
                                                    {{ $record->field_name }}
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($record->field_name === 'active')
                                                {{ $record->old_value == 1 ? 'Activo' : 'Inactivo' }}
                                            @else
                                                {{ $record->old_value }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($record->field_name === 'active')
                                                {{ $record->new_value == 1 ? 'Activo' : 'Inactivo' }}
                                            @else
                                                {{ $record->new_value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endpush 