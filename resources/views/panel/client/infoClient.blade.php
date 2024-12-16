@if (!isset($step))
    
    @if ($taskId == 1)
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
    @endif

    @if ($taskId == 2)
    <div class="row">
        <div class="col-6">
            <table class="table table-striped">
                <tr>
                    <td>Fecha nómina</td>
                    <td>{{ $credit!= null ? $credit->payroll_date : null }}</td>
                </tr>
                <tr>
                    <td>Total nómina</td>
                    <td>{{ $credit!= null ? $credit->payroll_total : null }}</td>
                </tr>
            
            </table>
        </div>
    </div>
    @endif

    @if ($taskId == 3)
    <div class="row">
        <div class="col-6">
            <table class="table table-striped">
                <tr>
                    <td>CP nominal</td>
                    <td>{{ $credit!= null ? $credit->payment_capacity : null }}</td>
                </tr>
                <tr>
                    <td>Fecha nómina</td>
                    <td>{{ $credit!= null ? $credit->payroll_date : null }}</td>
                </tr>
                <tr>
                    <td>Total nómina</td>
                    <td>{{ $credit!= null ? $credit->payroll_total : null }}</td>
                </tr>
            
            </table>
        </div>
    </div>
    @endif

    @if ($taskId == 5)
    <div class="row">
        <div class="col-6">
            <table class="table table-striped">
                <tr>
                    <td>Clabe</td>
                    <td>{{ $client!= null ? $client->bank_clabe : null }}</td>
                </tr>
                <tr>
                    <td>Banco</td>
                    <td>{{ $client!= null ? $client->bank_name : null }}</td>
                </tr>
                <tr>
                    <td>Pertenencia de clabe</td>
                    <td>{{ config('enums.pertenencia_clabe')[$client->clabe_ownership] }}</td>
                </tr>
                <tr>
                    <td>Clabe validada</td>
                    <td>{{ $client!= null ? $client->validated_clabe : null }}</td>
                </tr>
            
            </table>
        </div>
    </div>
    @endif

    @if ($taskId > 5)
    <div class="row">
        <div class="col-6">
            <table class="table table-striped">
                <tr>
                    <td>Fecha límite de pago</td>
                    <td>{{ $payOff!= null ? $payOff->deadline_date : null }}</td>
                </tr>
                <tr>
                    <td>Importe</td>
                    <td>{{ $payOff!= null ? $payOff->ammount : null }}</td>
                </tr>
                <tr>
                    <td>Clabe</td>
                    <td>{{ $payOff!= null ? $payOff->bank_clabe : null }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endif
@endif

@if (isset($step) && $taskId === 1)
<div class="row">
    <div class="col-6">
        <table class="table table-striped">
            <tr>
                <td>Contrato CM firmado</td>
                <td>{{ $client!= null && $client->cm_agreement == 1 ? 'Válido' : 'Inválido' }}</td>
            </tr>
            <tr>
                <td>URL contrato</td>
                <td><a href="/client/contratocm/{{ $client->id }}" target="_blank">Ver</a></td>
            </tr>
            
        </table>
    </div>
</div>
@endif