<div class="row">
    <div class="col-6">
        <table class="table table-striped">
            <tr>
                <td>CP Real</td>
                <td>{{ $credit->payroll_payment_capacity }}</td>
            </tr>
        </table>
        
    </div>
    <div class="col-12"></div>
    <div class="col-6 mt-5">
        <span class="preview-title-lg overline-title">Compra de cartera</span>
        @php
            $total = 0;
            $totalRefinanciable = 0;
        @endphp
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Producto financiero</th>
                    <th>Saldo</th>
                    <th>Fecha límite</th>
                    <th>Tasa anual</th>
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
                    <td> {{ $creditPay->deadline_date }} </td>
                    <td> {{ $creditPay->annual_int_rate_iva }} </td>
                    <td><a class="pointer" onclick="editCompraCarteraControlDesk({{$creditPay->id}})"><i class="fa-solid fa-pen"></i></a></td>
                </tr>
            @endforeach
                <tr>
                    <td  class="text-end">Total: </td>
                    <td colspan="4">{{ format_price($total)}}</td>
                    
                </tr>
                
            </tbody>
        </table>
        <div class="col-12 mt-3">
            <span class="preview-title-lg overline-title">Refinanciamiento</span>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Producto financiero</th>
                    <th>Saldo</th>
                    <th>Fecha límite</th>
                    <th>Tasa anual</th>
                    <th></th>
                </tr>
                
                
            </thead>
            <tbody>
                @foreach ($creditRefinanced as $creditRefinanced)
                @php
                    $totalRefinanciable += $creditRefinanced->ammount;
                @endphp
                <tr>
                    <td>{{ $creditRefinanced->alias }}</td>
                    <td>${{ format_price($creditRefinanced->ammount) }}</td>
                    <td> {{ $creditRefinanced->deadline_date }} </td>
                    <td> {{ $creditRefinanced->annual_int_rate_iva }} </td>
                    <td><a class="pointer" onclick="editCompraCarteraControlDesk({{$creditRefinanced->id}})"><i class="fa-solid fa-pen"></i></a></td>
                </tr>
            @endforeach
                <tr>
                    <td  class="text-end">Total: </td>
                    <td colspan="4">{{ format_price($totalRefinanciable)}}</td>
                    
                </tr>
                
            </tbody>
        </table>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12 mt-5">
                <span class="preview-title-lg overline-title">Crédito preautorizado prospectos</span>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="form-label">Monto máximo</label>
                    
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" id="monto-maximo" value="{{ $montoMaximo }}"  disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="form-label">Plazo máximo</label>
                    
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" id="plazo-maximo" value="{{ $financialProduct != null ? $financialProduct->max_term : null}}"  disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="form-label">Periodicidad</label>
                    @php
                        $periodicidad = isset(config('enums.periodicidad_names')[$financialProduct->periodicity_id])? config('enums.periodicidad_names')[$financialProduct->periodicity_id] : null;
                    @endphp
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" id="periodicidad" value="{{ $periodicidad }}"  disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label class="form-label">Pago periodico</label>
                    
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" id="pago-periodico" value="{{ $payment }}"  disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-5">
        <span class="preview-title-lg overline-title">Producto solicitado</span>
    </div>
    <div class="col-6">
        <table class="table table-striped">
            <tr>
                <td>Plazo solicitado</td>
                <td>{{ $lead->selected_term }}
                    <input type="hidden" id="compra-cartera-plazo-solicitado" value="{{ $lead->selected_term }}">
                </td>
            </tr>
            <tr>
                <td>Monto solicitado</td>
                <td>{{ format_price($lead->selected_loan) }}</td>
            </tr>
        </table>
    </div>
    <div class="col-12 mt-5">
        <span class="preview-title-lg overline-title">¿Cuánto quieres recibir?</span>
    </div>
    <div class="col-md-12 mt-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="sumaCompraCheck">
            <label class="form-check-label" for="sumaCompraCheck">
              Suma de compra de cartera
            </label>
        </div>
    </div>

    <div class="col-md-6 mt-3">
        <div class="form-group">
            <label class="form-label">Plazo</label>
            
            <div class="form-control-wrap">
                <select class="form-select js-select2" name="credit[applied_term]" id="ref-plazo"  data-search="on" onchange="getMontoSolicitado()" required>
                    <option value="">Seleccione una opción</option>
                    @foreach ($terms as $key =>  $term)
                        <option value="{{ $key }}">{{ $term }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6 mt-3">
        <div class="form-group">
            <label class="form-label">Monto solicitado</label>
            
            <div class="form-control-wrap" id="content-select-monto-solicitado">
                <select class="form-select js-select2" name="credit[applied_import]" id="ref-monto"  data-search="on" onchange="getResumen()" required >
                </select>
            </div>
            <div id="content-select-new-monto-solicitado">
                
            </div>
            <input type="hidden" id="total-refinanciable">
        </div>
    </div>

    <div class="col-12 mt-5">
        <p class="h6">RESUMEN</p>
        <table class="table">
            <tr>
                <td>Monto solicitado:</td>
                <td>$<span id="content-monto-solicitado"></span></td>
            </tr>
            @if ($credit->tramit_type == 3)
                <tr>
                    <td>Monto a refinanciar:</td>
                    <td>$<span id="content-monto-refinanciar"></span></td>
                </tr>
            @endif
            @if ($financialProduct->type_product_id == 2)
            <tr>
                <td>Monto compra cartera:</td>
                <input type="hidden" id="total-monto-solicitado" value="{{ $totalCompraCartera }}">
                <input type="hidden" id="total-monto-solicitado_format" value="{{ format_price($totalCompraCartera) }}">
                <td>$<span id="content-monto-compra-cartera"></span></td>
                
            </tr>
            @endif
            <tr>
                <td>Comisión por apertura:</td>
                <td>$<span id="content-comision-apertura"></span></td>
            </tr>
            <tr>
                <td>Monto a entregar:</td>
                <td>$<span id="content-monto-entregar"></span></td>
            </tr>
            <tr>
                <td>Periodicidad:</td>
                <td><span id="content-plazo"></span></td>
            </tr>
            <tr>
                <td>Plazo:</td>
                <td><span id="content-monto"></span></td>
            </tr>
            <tr>
                <td>Pago periódico:</td>
                <td>$<span id="content-pago-periodico"></span></td>
            </tr>
            <tr>
                <td>Pago total:</td>
                <td>$<span id="content-pago-total"></span></td>
            </tr>
            <tr>
                <td>Tasa anual:</td>
                <td><span id="content-tasa-anual"></span>%</td>
            </tr>
            <tr>
                <td>CAT:</td>
                <td><span id="content-cat"></span>%</td>
            </tr>
        </table>
        
    </div>

    <input type="hidden" id="isControlDesk" value="true">
    <input type="hidden" id="client_person_id" value="{{ $client->id }}">
    <input type="hidden" id="controldesk-credit_id" value="{{ $credit->id }}">
    <input type="hidden" id="financial_product_id" value="{{ $financialProduct->id }}">
    <input type="hidden" id="applied_periodicity" name="credit[applied_periodicity]">
    <input type="hidden" id="applied_loan_total_amount" name="credit[applied_loan_total_amount]">
    <input type="hidden" id="opening_commission" name="credit[opening_commission]">
    <input type="hidden" id="net_amount" name="credit[net_amount]">
    <input type="hidden" id="applied_payment" name="credit[applied_payment]">
    
    <input type="hidden" id="tramit_type" value="{{ $credit->tramit_type }}">
    
    
    
    
</div>