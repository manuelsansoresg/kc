<div class="row">
    @if ($tramitType == 3) {{-- refinanciable --}}
        <div class="col-12">
            <table class="table">
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Descuento</th>
                    <th>Estatus</th>
                    <th>Saldo</th>
                </tr>
                @php
                    $total = 0;
                @endphp
                @foreach ($credits as $credit)
                    @php
                        $total += $credit->saldo_insoluto_real;
                    @endphp
                    <tr>
                        <td> <input type="checkbox" name="credits[]" id="{{ $credit->id }}" value="{{ $credit->id }}" checked onchange="getMontoSolicitado()">  </td>
                        <td> {{ $credit->kc_credit_id }} </td>
                        <td> {{ date('d-m-Y', strtotime($credit->fecha_cobro)) }} </td>
                        <td> 
                            {{ $credit->descuento }} 
                        </td>
                        <td> {{ $credit->alias }} </td>
                        <td> {{ $credit->saldo_insoluto_real }}  </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-end"> Total: </td>
                    <td><span id="table-refinanciamiento-total"> {{ $total }} </span></td>
                </tr>
            </table>
        </div>
    @endif
    @if ($type_product_id == 2) {{-- compra de cartera --}}
        <div class="col-12">
            <div class="row mt-2 py-3">
                <div class="col-8">
                    <span class="preview-title-lg overline-title">Compra de cartera</span>
                </div>
                <div class="col-4">
                    <a class="pointer" onclick="showModalCompraCartera()">Agregar</a>
                </div>
                <div class="col-12">
                   
                    <div id="content-table-compra-cartera"></div>
                </div>
            </div>
        </div>
    @endif

   <div class="col-12">
    <p>¿Cuanto quieres solicitar ? </p>
   </div>
   <div class="row">
    <div class="col-md-6 mt-3">
        <div class="form-group">
            <label class="form-label">Plazo</label>
            
            <div class="form-control-wrap">
                <select class="form-select js-select2" name="data[selected_term’]" id="ref-plazo"  data-search="on" onchange="getMontoSolicitado()">
                    <option value="">Seleccione una opción</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6 mt-3">
        <div class="form-group">
            <label class="form-label">Monto solicitado</label>
            
            <div class="form-control-wrap">
                <select class="form-select js-select2" name="data[selected_loan]" id="ref-monto"  data-search="on" onchange="getResumen()">
                </select>
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
            @if ($tramitType == 3)
                <tr>
                    <td>Monto a refinanciar:</td>
                    <td>$<span id="content-monto-refinanciar"></span></td>
                </tr>
            @endif
            @if ($type_product_id == 2)
            <tr>
                <td>Monto compra cartera:</td>
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
   </div>
   <input type="hidden" id="hmonto-entregar" value="">

   <input type="hidden" id="resumen-deuda-capital" value="">
   <input type="hidden" id="resumen-kcInteres" value="">
   <input type="hidden" id="resumen-kcPagoTotal" value="">
</div>