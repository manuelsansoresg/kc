@extends('layouts.admin')
@section('title', 'Resumen')

@section('content')

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">

                    <div class="nk-block nk-block-lg">
                        <div class="container">
                          <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                @if ($investor->pending_funding_amount > 0)
                                    <div class="d-flex align-items-center h-100">
                                        <span>Importe de créditos en espera de fondeo: {{ format_price($investor->pending_funding_amount) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-6 d-flex align-items-center justify-content-end">
                                <div class="d-flex align-items-center h-100">
                                    <a href="#" class="btn btn-xl btn-primary" data-bs-toggle="modal" data-bs-target="#modalPrestar">Prestar</a>
                                </div>
                            </div>
                            <div class="col-12 mt-5">
                                <div class="card card-bordered  vh-50">
                                    <div class="card-inner">
                                        @php
                                            $valorCuenta = $investor != null ? $investor->account_value : 0;
                                            $disponiblePrestar = $investor != null ? $investor->withdraw_available : 0;
                                            $totalAvailable = $investor != null ? $investor->total_available : 0;
                                        @endphp
                                        <input type="hidden" id="iValorCuenta" value="{{ $totalAvailable }}">
                                        <input type="hidden" id="iTotalCredit" value="{{ $valorCuenta + $investor->total_balance - $investor->placed_capital }}">
                                        <div class="analytic-ov d-none d-md-block">
                                            <div class="analytic-data-group analytic-ov-group g-3">
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Valor de cuenta </div>
                                                    <div class="amount">{{ format_price($valorCuenta) }} <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-valor-cuenta"></em></div>
                                                    <div class="change up">
                                                        <a href="#"  data-bs-toggle="modal"
                                                        data-bs-target="#modalDetalle">Ver detalle</a>
                                                    </div>
                                                </div>
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Disponible para prestar o retirar </div>
                                                    <div class="amount">{{ format_price($disponiblePrestar) }} <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-disponible"></em></div>
                                                    <div class="change up">
                                                    </div>
                                                </div>
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Apartado para ser prestado &nbsp; </div>
                                                    <div class="amount">{{ format_price($investor->loan_available) }} <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-proceso"></em></div>
                                                    <div class="change down"><a href="#"  data-bs-toggle="modal"
                                                        data-bs-target="#modalPrestar">Editar</a></div>
                                                </div>
                                                
                                               
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Dinero en créditos activos</div>
                                                    <div class="amount">{{ format_price($investor->placed_capital) }} <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-prestamo"></em></div>
                                                    <div class="change down">
                                                        <span class="text-primary">En trámites: {{ $tramites != null ? format_price($investor->loans_in_process) : 0 }} <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-tramites"></em></span>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="d-block d-md-none">
                                            <div class="row">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td>Valor de cuenta  <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-valor-cuenta"></em></td>
                                                        <td><b>{{ format_price($valorCuenta) }}</b>
                                                            <br>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDetalle">Ver detalle</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Disponible para prestar o retirar <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-disponible"></em></td>
                                                        <td><b>{{ format_price($disponiblePrestar) }}</b>
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"><hr></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Apartado para ser prestado   <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-proceso"></em></td>
                                                        <td class="text-start">
                                                            <b>{{ format_price($investor->loan_available) }}</b>
                                                            <br>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalPrestar">Editar</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Préstamos en créditos activos <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-prestamo"></em></td>
                                                        <td>
                                                            <b>{{ format_price($investor->placed_capital) }}</b>
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            
                                        </div>
                                        <div style="display: none;">
                                            <div id="tooltip-valor-cuenta">
                                                <b>Valor de cuenta</b>
                                                <br><br>
                                                Es el valor total de tu cuenta.
                                            </div>
                                           
                                            <div id="tooltip-disponible">
                                                <b>Disponible para prestar o retirar</b>
                                                <br><br>
                                                Dinero que no está prestado o no está disponible para ser prestado. Este dinero lo puedes retirar a tu cuenta bancaria o asignarlo para ser prestado.


                                            </div>
                                            <div id="tooltip-proceso">
                                                <b>Apartado para ser prestado</b>
                                                <br><br>
                                                Dinero destinado para préstamos. Este dinero no está disponible para retirar a tu cuenta a menos que modifiques la cantidad de dinero asignada para ser prestada.

                                            </div>
                                            <div id="tooltip-tramites">
                                                Dinero de créditos que están en trámite.
                                            </div>

                                            <div id="tooltip-prestamo">
                                                <b>Dinero en créditos activos.
                                                </b>
                                                <br><br>
                                                Es la suma de todos los préstamos que has realizado y cuyo principal o capital está pendiente de pago. Ej. Si has prestado $10,000 en total, pero ya se amortizaron o pagaron $2,000 de capital, este valor será de $8,000. Los intereses pagados no disminuyen este valor.	
                                                <br>
                                                También incluye créditos que están en trámite.
                                            </div>
                                            <div id="tooltip-intereses">
                                                <b>Intereses cobrados</b>
                                                <br><br>
                                                Son los intereses que has cobrado.
                                            </div>
                                            <div id="tooltip-iva-intereses">
                                                <b>IVA de intereses cobrados</b>
                                                <br><br>
                                                IVA de los intereses que has cobrado.
                                            </div>
                                            <div id="tooltip-recuperacion">
                                                <b>Recuperación de cartera vencida</b>
                                                <br><br>
                                                Dinero recuperado de la cartera vencida.
                                            </div>
                                            <div id="tooltip-comisiones">
                                                <b>Comisiones pagadas a KaaxClub</b>
                                                <br><br>
                                                Comisiones que has pagado a KaaxClub.
                                            </div>


                                            <div id="tooltip-perdidas">
                                                <b>Pérdidas por cartera vencida</b>
                                                <br><br>
                                                Dinero perdido en cartera vencida.
                                            </div>
                                            <div id="tooltip-iva-comisiones">
                                                <b>IVA de comisiones</b>
                                                <br><br>
                                                IVA de las comisiones que has pagado a KaaxClub.
                                            </div>
                                            <div id="tooltip-resultados">
                                                <b>Resultados netos totales</b>
                                                <br><br>
                                                Son tus ganancias que has obtenido.
                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>

                            </div>
                          </div>

                           <div class="row mt-5">
                                <div class="col-12 col-md-6 ">
                                    <div class="card card vh-50">
                                        <div class="card-body">
                                            <h6 class="title">Resultados obtenidos </h6>
                                            <hr>
                                            @php
                                                $interesesCobrados          = $investor != null  ? $investor->profit_collected : 0;
                                                $IvainteresesCobrados       = $investor != null  ? $investor->iva_collected : 0;
                                                $recuperacionCarteraVencida = 0;

                                                $comisionesPagadasKaax      = $investor != null  ? $investor->collection_commission : 0;
                                                $perdidasCarteraVencida     = 0;
                                                $ivaComisiones             = $investor != null  ? $investor->iva_commission : 0;

                                                $resultadosNetosTotales = $interesesCobrados + $IvainteresesCobrados + $recuperacionCarteraVencida 
                                                                        - $comisionesPagadasKaax - $perdidasCarteraVencida - $ivaComisiones;
                                            @endphp
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Intereses cobrados <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-intereses"></em></td>
                                                    <td><b>{{ format_price($interesesCobrados) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>IVA de intereses cobrados <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-iva-intereses"></em></td>
                                                    <td><b>{{ format_price($IvainteresesCobrados) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Recuperación de cartera vencida <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-recuperacion"></em></td>
                                                    <td><b>{{ format_price($recuperacionCarteraVencida) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <hr>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Comisiones pagadas a KaaxClub <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-comisiones"></em></td>
                                                    <td><b>{{ format_price($comisionesPagadasKaax) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>IVA de comisiones</td>
                                                    <td><b>{{ format_price($ivaComisiones) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Pérdidas por cartera vencida</td>
                                                    <td><b>{{ format_price($perdidasCarteraVencida) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <hr>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="h5 text-primary">Resultados netos totales <em class="icon ni ni-info active-tooltip text-primary" data-template="tooltip-resultados"></em></span></td>
                                                    <td><span class="h5 text-primary">{{ format_price($resultadosNetosTotales) }}</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 vh-50">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="title">Valor de cuenta </h6>
                                            @php
                                                $disponiblePrestaroRetirar = $investor != null ? $investor->withdraw_available : 0;
                                                $procesoPrestado = $investor != null ? $investor->loan_available : 0;
                                                $prestamoCreditosActivos = $investor != null ? $investor->placed_capital + $investor->loans_in_process : 0;
                                                $totalAvailable = $investor != null ? $investor->total_available : 0;
                                            @endphp
                                            <input type="hidden" id="disponiblePrestaroRetirar" value="{{ $disponiblePrestaroRetirar }}">
                                            <input type="hidden" id="procesoPrestado" value="{{ $procesoPrestado }}">
                                            <input type="hidden" id="prestamoCreditosActivos" value="{{ $prestamoCreditosActivos }}">
                                            <hr>
                                            <div class="traffic-channel mt-3">
                                                <div class="traffic-channel-doughnut-ck">
                                                    <canvas class="analytics-doughnut" id="TrafficChannelDoughnutData"></canvas>
                                                </div>
                                                <div class="traffic-channel-group g-2 mt-4 d-none">
                                                    <div class="traffic-channel-data">
                                                        <div class="title"><span class="dot dot-lg sq" data-bg="#9cabff"></span><span>Prestado</span></div>
                                                        <div class="amount">$4,305 </div>
                                                    </div>
                                                    <div class="traffic-channel-data">
                                                        <div class="title"><span class="dot dot-lg sq" data-bg="#b8acff"></span><span>Capital</span></div>
                                                        <div class="amount">$859 </div>
                                                    </div>
                                                    <div class="traffic-channel-data">
                                                        <div class="title"><span class="dot dot-lg sq" data-bg="#ffa9ce"></span><span>Intereses</span></div>
                                                        <div class="amount">$482 </div>
                                                    </div>
                                                  
                                                </div><!-- .traffic-channel-group -->
                                                <div class="col-12">
                                                    <br><br>
                                                </div>
                                            </div><!-- .traffic-channel -->
                                        </div>
                                    </div>
                                </div>
                           </div>
                            
                           <div class="row mt-5">
                            <div class="col-12 col-md-6">
                                
                                <div class="card">
                                    <div class="card-body">
                                        <div class="nk-block-head nk-block-head-sm">
                                            <div class="nk-block-between">
                                                <div class="nk-block-head-content">
                                                    <h6 class="title">Ingresos proyectados </h6>
                                                    <p>Ingresos en los próximos meses</p>
                                                </div><!-- .nk-block-head-content -->
                                                
                                            </div><!-- .nk-block-between -->
                                        </div><!-- .nk-block-head -->
                                        <div class="col-12 ">
                                            <div class="nk-sales-ck large pt-4">
                                                <canvas class="sales-overview-chart" id="salesOverview"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="nk-block-head nk-block-head-sm">
                                            <div class="nk-block-between">
                                                <div class="nk-block-head-content">
                                                    <h6 class="title">Ingresos proyectados </h6>
                                                    <p>Ingresos en los próximos meses</p>
                                                </div><!-- .nk-block-head-content -->
                                                
                                            </div><!-- .nk-block-between -->
                                        </div><!-- .nk-block-head -->
                                        <div class="col-12">
                                            <canvas class="bar-chart" id="barChartIngresos"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    


    <div class="modal fade" tabindex="-1" id="modalPrestar">
        <div class="modal-dialog" role="document">
            <div class="modal-content"> <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em> </a>
                <div class="modal-header">
                    <h5 class="modal-title">Apartar dinero para ser prestado</h5>
                </div>
                <div class="modal-body">
                   <form action="">
                        <p>
                            Es la cantidad de dinero que está disponible para ser prestada. Esta cantidad irá disminuyendo conforme se vayan entregando créditos.
                            El total de esta cantidad podrá verse en "Apartado para ser prestado"
                            <br> <br>
                            <b>Disponible: {!! $totalAvailable > 0 ? format_price($totalAvailable) : '$0.00 <a href="/panel/kc-wallet" class="link-primary" style="font-weight: normal; text-decoration: underline"> Agrega fondos </a>' !!}</b>
                        </p>
                        <input type="number" min="201" name="lendable" id="lendable" max="{{ $totalAvailable }}" class="form-control" value="{{ $totalAvailable }}">
                        <div class="col-12 mt-3">
                            
                            <p style="color: #526484 !important;">
                                Advertencias:
                                <ul style="list-style: none; padding-left: 0;">
                                    <li style="position: relative; padding-left: 1.5em; line-height: 1.4;">
                                      <i class="fas fa-circle" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); font-size: 0.6em; color: #526484;"></i>
                                      El importe no debe ser mayor al dinero disponible
                                    </li>
                                    <li class="d-none" style="position: relative; padding-left: 1.5em; line-height: 1.4;">
                                      <i class="fas fa-circle" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); font-size: 0.6em; color: #526484;"></i>
                                      El importe debe ser mayor a $200.00 pesos
                                    </li>
                                  </ul>
                            </p>
                        </div>
                        <input type="hidden" id="totalAvailable" value="{{ $totalAvailable }}">
                        <input type="hidden" name="investorId" id="investorId" value="{{ $investor->id }}">
                        <div class="col-12 mt-3 text-end">
                            <a href="#" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</a>
                            <button type="button" onclick="prestarInversionista()" class="btn btn-primary">Guardar</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" tabindex="-1" id="modalDetalle">
        <div class="modal-dialog" role="document">
            <div class="modal-content"> <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em> </a>
                <div class="modal-header">
                    <h5 class="modal-title">Valor de la cuenta</h5>
                </div>
                <div class="modal-body">
                   <form action="">
                        <table class="table table-borderless">
                            @php
                                $recursosFondeados = $investor != null ? $investor->funded_capital : 0;
                                $totalCollected    = $investor != null ? $investor->total_collected : 0;
                                $totalIngresos     = $recursosFondeados + $totalCollected;
                                
                                $prestamosRealizados       = $investor != null ? $investor->total_capital : 0;
                                $comisionesPagadas         = $investor != null ? $investor->collection_commission  + $investor->iva_commission : 0;
                                $recursosRetirados         = $investor != null ? $investor->withdrawn_money : 0;
                                $perdidasporCarteraVencida = 0;
                                $totalEgresos              = $prestamosRealizados + $comisionesPagadas + $recursosRetirados + $perdidasporCarteraVencida;

                                $ingresoEgreso                = $totalIngresos - $totalEgresos;
                                $capitalPrestadoPendientePago = $investor != null ? $investor->placed_capital : 0;
                                $valorCuenta                  = $ingresoEgreso + $capitalPrestadoPendientePago;
                            @endphp
                            <tr>
                                <td>Recursos fondeados</td>
                                <td>{{  format_price($recursosFondeados) }}</td>
                            </tr>
                            <tr>
                                <td>Pagos recibidos</td>
                                <td>{{ format_price($totalCollected)  }}</td>
                            </tr>
                            <tr>
                                <td> <span class="h5 text-success">Total Ingresos</span> </td>
                                <td> <span class="h5 text-success"> {{ format_price($totalIngresos) }} </span> </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td>Préstamos realizados</td>
                                <td>{{ format_price($prestamosRealizados) }}</td>
                            </tr>
                            <tr>
                                <td>Comisiones pagadas</td>
                                <td>{{ format_price($comisionesPagadas) }}</td>
                            </tr>
                            <tr>
                                <td>Recursos retirados de tu cuenta</td>
                                <td>{{ format_price($recursosRetirados) }}</td>
                            </tr>
                            <tr>
                                <td>Pérdidas por cartera vencida <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-perdidas"></em></td>
                                <td>{{ format_price($perdidasporCarteraVencida) }}</td>
                            </tr>
                            <tr>
                                <td> <span class="h5 text-danger">Total Egresos</span> </td>
                                <td> <span class="h5 text-danger">{{ format_price($totalEgresos) }}</span> </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td>Ingresos -  Egreso</td>
                                <td>{{ format_price($ingresoEgreso) }}</td>
                            </tr>
                            <tr>
                                <td>Capital prestado pendiente de pago</td>
                                <td>{{ format_price($capitalPrestadoPendientePago) }}</td>
                            </tr>
                            <tr>
                                <td> <span class="h5 text-primary">Valor de tu cuenta</span> </td>
                                <td> <span class="h5 text-primary">{{ format_price($valorCuenta) }}</span> </td>
                            </tr>
                        </table>
                      
                    <hr>
                  
                   </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/js/components/resumen.js"></script>
@endpush
