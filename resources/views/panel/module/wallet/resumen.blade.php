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
                            <div class="col-12 text-end">
                                <a href="#" class="btn btn-xl btn-primary"  data-bs-toggle="modal"
                                data-bs-target="#modalPrestar">Prestar</a>
                            </div>
                            <div class="col-12 mt-5">
                                <div class="card card-bordered  vh-50">
                                    <div class="card-inner">
                                        @php
                                            $valorCuenta = $investor->account_value;
                                            $disponiblePrestar = $investor->withdraw_available;
                                        @endphp
                                        <input type="hidden" id="iValorCuenta" value="{{ $valorCuenta}}">
                                        <input type="hidden" id="iTotalCredit" value="{{ $valorCuenta + $investor->total_balance}}">
                                        <div class="analytic-ov d-none d-md-block">
                                            <div class="analytic-data-group analytic-ov-group g-3">
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Valor de cuenta</div>
                                                    <div class="amount">${{ format_price($valorCuenta) }}</div>
                                                    <div class="change up">
                                                        <a href="#"  data-bs-toggle="modal"
                                                        data-bs-target="#modalDetalle">Ver detalle</a>
                                                    </div>
                                                </div>
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Disponible para prestar o retirar </div>
                                                    <div class="amount">${{ format_price($disponiblePrestar) }} <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-disponible"></em></div>
                                                    <div class="change up">
                                                    </div>
                                                </div>
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Apartado para ser prestado &nbsp; </div>
                                                    <div class="amount">${{ format_price($investor->loan_available) }} <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-proceso"></em></div>
                                                    <div class="change down"><a href="#"  data-bs-toggle="modal"
                                                        data-bs-target="#modalPrestar">Editar</a></div>
                                                </div>
                                                
                                               
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Préstamos en créditos activos</div>
                                                    <div class="amount">${{ format_price($investor->placed_capital) }} <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-prestamo"></em></div>
                                                    <div class="change down"></div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="d-block d-md-none">
                                            <div class="row">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td>Valor de cuenta</td>
                                                        <td><b>${{ format_price($valorCuenta) }}</b>
                                                            <br>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDetalle">Ver detalle</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Disponible para prestar o retirar <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-disponible"></em></td>
                                                        <td><b>${{ format_price($disponiblePrestar) }}</b>
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"><hr></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Apartado para ser prestado   <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-proceso"></em></td>
                                                        <td class="text-start">
                                                            <b>${{ format_price($investor->loan_available) }}</b>
                                                            <br>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalPrestar">Editar</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Préstamos en créditos activos <em class="icon ni ni-info active-tooltip text-gray" data-template="tooltip-prestamo"></em></td>
                                                        <td>
                                                            <b>${{ format_price($investor->placed_capital) }}</b>
                                                            
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
                                            
                                            <div id="tooltip-prestamo">
                                                <b>Préstamos en créditos activos.
                                                </b>
                                                <br><br>
                                                Es la suma de todos los préstamos que has realizado y cuyo principal o capital está pendiente de pago. Ej. Si has prestado $10,000 en total, pero ya se amortizaron o pagaron $2,000 de capital, este valor será de $8,000. Los intereses pagados no disminuyen este valor.	
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
                                                    <td>Intereses cobrados</td>
                                                    <td>${{ format_price($interesesCobrados) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>IVA de intereses cobrados</td>
                                                    <td>${{ format_price($IvainteresesCobrados) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Recuperación de cartera vencida</td>
                                                    <td>${{ format_price($recuperacionCarteraVencida) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <hr>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Comisiones pagadas a KaaxClub</td>
                                                    <td>${{ format_price($comisionesPagadasKaax) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Pérdidas por cartera vencida</td>
                                                    <td>${{ format_price($perdidasCarteraVencida) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>IVA de comisiones</td>
                                                    <td>${{ format_price($ivaComisiones) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <hr>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="h5 text-primary">Resultados netos totales</span></td>
                                                    <td><span class="h5 text-primary">${{ format_price($resultadosNetosTotales) }}</span></td>
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
                                                $disponiblePrestaroRetirar = $investor != null ? $investor->total_available  + $investor->loan_available : 0;
                                                $procesoPrestado = $investor != null ? $investor->loan_available : 0;
                                                $prestamoCreditosActivos = $investor != null ? $investor->placed_capital : 0;
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
                            <div class="col-6">
                                
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
                            <b>Disponible: {!! $totalAvailable > 0 ? '$'.format_price($totalAvailable) : '$0.00 <a href="/panel/kc-wallet" class="link-primary" style="font-weight: normal; text-decoration: underline"> Agrega fondos </a>' !!}</b>
                        </p>
                        <input type="number" min="201" name="lendable" id="lendable" max="{{ $totalAvailable }}" class="form-control" value="{{ $investor->lendable }}">
                        <div class="col-12 mt-3">
                            
                            <p style="color: #526484 !important;">
                                Advertencias:
                                <ul style="list-style: none; padding-left: 0;">
                                    <li style="position: relative; padding-left: 1.5em; line-height: 1.4;">
                                      <i class="fas fa-circle" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); font-size: 0.6em; color: #526484;"></i>
                                      El importe no debe ser mayor al dinero disponible
                                    </li>
                                    <li style="position: relative; padding-left: 1.5em; line-height: 1.4;">
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
                                <td>{{  '$'.format_price($recursosFondeados) }}</td>
                            </tr>
                            <tr>
                                <td>Pagos recibidos</td>
                                <td>{{ '$'.format_price($totalCollected)  }}</td>
                            </tr>
                            <tr>
                                <td> <span class="h5 text-success">Total Ingresos</span> </td>
                                <td> <span class="h5 text-success"> {{ '$'.format_price($totalIngresos) }} </span> </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td>Préstamos realizados</td>
                                <td>{{ '$'.format_price($prestamosRealizados) }}</td>
                            </tr>
                            <tr>
                                <td>Comisiones pagadas</td>
                                <td>{{ '$'.format_price($comisionesPagadas) }}</td>
                            </tr>
                            <tr>
                                <td>Recursos retirados de tu cuenta</td>
                                <td>{{ '$'.format_price($recursosRetirados) }}</td>
                            </tr>
                            <tr>
                                <td>Pérdidas por cartera vencida</td>
                                <td>{{ '$'.format_price($perdidasporCarteraVencida) }}</td>
                            </tr>
                            <tr>
                                <td> <span class="h5 text-danger">Total Egresos</span> </td>
                                <td> <span class="h5 text-danger">{{ '$'.format_price($totalEgresos) }}</span> </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td>Ingresos -  Egreso</td>
                                <td>{{ '$'.format_price($ingresoEgreso) }}</td>
                            </tr>
                            <tr>
                                <td>Capital prestado pendiente de pago</td>
                                <td>{{ '$'.format_price($capitalPrestadoPendientePago) }}</td>
                            </tr>
                            <tr>
                                <td> <span class="h5 text-primary">Valor de tu cuenta</span> </td>
                                <td> <span class="h5 text-primary">{{ '$'.format_price($valorCuenta) }}</span> </td>
                            </tr>
                        </table>
                      
                    <hr>
                  
                   </form>
                </div>
            </div>
        </div>
    </div>

@endsection
