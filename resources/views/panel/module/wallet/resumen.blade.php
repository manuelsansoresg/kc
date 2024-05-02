@extends('layouts.admin')
@section('title', 'Resumen')

@section('content')

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Resumen</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item ">KC - Wallet</li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block nk-block-lg">
                        <div class="container">
                            <div class="row justify-content-center">
                                
                                @php
                                $totalDisponible =
                                    $investor != null
                                        ? $investor->total_available
                                        : 0;
                                $totalPendiente =
                                    $investor != null
                                        ? $investor->placed_capital
                                        : 0;
                                $totalPrestable = $investor != null
                                        ? $investor->loan_available
                                        : 0;
                                $total = $totalDisponible + $totalPendiente;
                                $capital = $investor != null
                                        ? $investor->placed_capital
                                        : 0;
                                $gananciaTotalGenerada = $investor != null ? $investor->profit_collected : 0;

                                $disponible = $investor != null ? $investor->withdraw_available : 0;
                                $capitalPendiente = $investor != null ? $investor->placed_capital : 0;
                                $apartadoPrestamo = $investor != null ? $investor->loan_available : 0;
                                $valorCuenta =  $disponible + $capitalPendiente + $apartadoPrestamo;
                                $lendable = $investor != null && $investor->lendable > 0 ? $investor->lendable : 0;
                            @endphp
                                {{-- first card --}}
                                <div class="col-md-6 col-lg-4">
                                    <div class="nk-wg-card is-s1 card card-bordered">
                                        <div class="card-inner">
                                            <div class="nk-iv-wg2">
                                                <div class="nk-iv-wg2-title">
                                                    <h6 class="title">Valor de la cuenta <em class="icon ni ni-info"></em></h6>
                                                </div>
                                                <div class="nk-iv-wg2-text">
                                                    <div class="nk-iv-wg2-amount">{{ '$'.format_price($valorCuenta) }} {{-- <span class="change up">
                                                        <span
                                                                class="sign"></span>2.8%</span> --}}
                                                            </div>
                                                            <p>&nbsp;</p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="nk-block">
                                        <div class="row gy-gs mt-3">
                                            <div class="col-12">
                                                <div class="nk-wg-card card card-bordered h-100">
                                                    <div class="card-inner h-100">
                                                        <div class="nk-iv-wg2">
                                                            <div class="nk-iv-wg2-title">
                                                                <h6 class="title">Resumen</h6>
                                                            </div>
                                                            <div class="nk-iv-wg2-text">
                                                               

                                                                <div class="nk-iv-wg2-amount ui-v2">
                                                                </div>
                                                                <div style="display: none;">

                                                                    <div id="tooltip-disponible">
                                                                        <b>Disponible para retiro</b>
                                                                        <br> <br>
                                                                        Corresponde al Dinero o  que no está prestado o comprometido para préstamos. Este es el dinero que puedes retirar a tu cuenta bancaria.
                                                                    </div>
                                                                    <div id="tooltip-capital-pendiente">
                                                                        <b>Capital pendiente</b>
                                                                        <br><br>
                                                                        Este monto es la suma de todos los préstamos que has realizado y cuyo principal o capital está pendiente de pago. Por ejemplo, si has prestado $10,000 en total, pero ya se armotizaron o pagaron $2,000 del capital, este valor será de $8,000. Los intereses pagados no disminuyen este valor. 
                                                                    </div>
                                                                    <div id="tooltip-apartado-prestamo">
                                                                        <b>Disponible para prestar</b>
                                                                        <br><br>
                                                                        Es el importe de tu dinero destinado para préstamos. El dinero reservado en este apartado no está disponible para retiro a menos que modifiques el “Límite máximo a prestar”
                                                                    </div>
                                                                    
                                                                    <div id="tooltip-limite-maximo-prestar">
                                                                        <b>Límite máximo a prestar.</b>
                                                                        <br><br>
                                                                        Es la cantidad máxima de dinero que estará disponible para préstamos. Ese límite puede ser mayor que el dinero que actualmente tienes disponible en tu cuenta. Por ejemplo: si estableces una cantidad mayor a tu dinero disponible, una vez que alcances este límite con las ganancias de tus préstamos, cualquier dinero adicional quedará disponible para ser retirado; si estableces una cantidad menor, siempre tendrás una parte disponible para préstamos y otra para retiro, que se irá incrementando conforme cobras tus préstamos; al fijar el límite en 0, tu dinero en APARTADO PRÉSTAMO pasará a estar disponible para retirar, así como todo lo que cobres posteriormente, y no se volverá a prestar hasta que modifiques esta configuración. Puedes ajustar este límite cuando quieras.
                                                                    </div>
                                                                </div>

                                                               
                                                                <ul class="nk-iv-wg2-list">
                                                                    <li  class="total">
                                                                        <span class="item-label" > Disponible para retiro <em class="icon ni ni-info active-tooltip" data-template="tooltip-disponible"></em> </span><span
                                                                            class="item-value">{{ '$'.format_price($disponible) }}</span>
                                                                    </li>
                                                                    <li  class="total"><span class="item-label">Capital pendiente <em class="icon ni ni-info active-tooltip" data-template="tooltip-capital-pendiente"></em> </span><span
                                                                            class="item-value">{{ '$'.format_price($capitalPendiente) }}</span>
                                                                    </li>
                                                                    <li class="total">
                                                                        <span class="item-label">
                                                                            Disponible para prestar <em class="icon ni ni-info active-tooltip" data-template="tooltip-apartado-prestamo"></em>
                                                                        </span>
                                                                        <span class="item-value">  {{ '$'.format_price($apartadoPrestamo) }} 
                                                                        
                                                                        </span>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                            <div class="nk-iv-wg2-cta">
                                                                <a href="#"
                                                                data-bs-toggle="modal" data-bs-target="#modalPrestable"
                                                                    class="btn btn-primary btn-lg btn-block text-center">
                                                                    <div class="text-center col-12">
                                                                        Prestar <br>
                                                                    <span class="text-xs">Configurar el límite máximo a prestar</span>
                                                                    </div>
                                                                    
                                                                    </a>
                                                                <a href="/panel/action-form/wallet/null/form?step=1"
                                                                    class="btn btn-primary btn-lg btn-block mt-3">Agregar
                                                                    fondos</a>
                                                                <a href="/panel/action-form/kc-down-wallet/null/form?step=1"
                                                                    class="btn btn-primary btn-lg btn-block mt-3">Retirar
                                                                    fondos</a>
                                                                {{--  <a href="#"
                                                                    class="btn btn-trans btn-block">Deposit Funds</a> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- second card --}}
                                <div class="col-md-6 col-lg-4">
                                    <div class="nk-wg-card is-dark card card-bordered">
                                        <div class="card-inner">
                                            <div class="nk-iv-wg2">
                                                <div class="nk-iv-wg2-title">
                                                    <h6 class="title text-white">Disponible para prestar 
                                                        <em class="icon ni ni-info active-tooltip" data-template="tooltip-apartado-prestamo"></em>
                                                       
                                                    </h6>
                                                </div>
                                                <div class="nk-iv-wg2-text">
                                                    <div class="nk-iv-wg2-amount  text-white">
                                                        {{ '$'.format_price($apartadoPrestamo) }} 
                                                        <span class="change up">
                                                            <a href="#"  data-bs-toggle="modal" data-bs-target="#modalPrestable">
                                                            
                                                                <i class="fa-solid fa-gear text-white"></i>
                                                            </a>
                                                            
                                                            </span>
                                                        </div>
                                                        <div class="col-12 text-white">
                                                            <p class="text-xs">Límite máximo a prestar: ${{ format_price($lendable) }} <em class="icon ni ni-info active-tooltip" data-template="tooltip-limite-maximo-prestar"></em> </p>
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
    </div>


    <div class="modal fade" id="modalPrestable" tabindex="-1" aria-labelledby="modalPrestableLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form id="frm-inversionista-prestamo">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalPrestableLabel">DISPONIBLE PARA PRESTAR</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>
                    Es el importe de tu dinero destinado para préstamos. El dinero reservado en este apartado no está disponible para retiro a menos que modifiques el <span class="text-decoration-underline">LÍMITE MÁXIMO A PRESTAR.</span> 
                    
                    <br><br> <span class="text-decoration-underline"> El LÍMITE MÁXIMO A PRESTAR </span> determina la cantidad máxima de tu cuenta que estará disponible para préstamos. Puedes establecer el límite que tú quieras, por ejemplo: si estableces una cantidad mayor a tu dinero disponible, una vez que alcances este límite con las ganancias de tus préstamos, cualquier dinero adicional quedará disponible para ser retirado; si estableces una cantidad menor, siempre tendrás una parte disponible para préstamos y otra para retiro, que se irá incrementando conforme cobras tus préstamos; al fijar el límite en 0, tu dinero en APARTADO PRÉSTAMO pasará a estar disponible para retirar, así como todo lo que cobres posteriormente, y no se volverá a prestar hasta que modifiques esta configuración.

                    Puedes ajustar este límite cuando quieras.
                  </p>
                  <div class="mb-3">
                    <label for="lendable" class="form-label">Límite máximo a prestar</label>
                    <input type="number" class="form-control" id="lendable" name="data[lendable]" value="{{ $lendable }}">
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="checkIslimit" name="checkIslimit">
                    <label class="form-check-label" for="checkIslimit">
                      Sin límite
                    </label>
                  </div>
                  <input type="hidden" id="investorId" name="investorId" value="{{ $investor->id }}">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
          </div>
        </div>
      </div>

    @endsection
