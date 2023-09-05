@extends('layouts.report')
@section('title', 'Reporte')

@section('header')
    @if (!isset($_GET['is_app']))
        @include('layouts.content_report_nav')
    @endif
@endsection

@section('content')
@php
    $is_app = isset($_GET['is_app'])? true : false;
@endphp
<input type="hidden" name="" value="{{ $is_app }}" id="is_app">
{{-- hero --}}
<section class="position-relative bg-style-1 {{ $is_app == true ? 'mt-n4' : ''}}" >
    <div class="container py-9 py-lg-11 position-relative z-index-1">
        <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50">
        </div>
        <div class="row justify-content-between align-items-start">
            <div class="col-12">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="analytics1" role="tabpanel">
                        <div class="row align-items-center">
                            <div class="col-md-6 pe-md-5 pe-lg-7 col-sm-9 mb-6 mb-lg-0" data-aos="fade-up"
                                data-aos-delay="100">
                                <div class="row align-items-center">
                                    <div class="animated-title">
                                        <div class="text-top ">
                                            <div>
                                                <span class="h1">¡Felicidades! </span>
                                                <span class="h1">{{ $client->name }}</span>
                                            </div>
                                        </div>
                                        <div class="text-bottom">
                                            <div>
                                                <span class="h4">Encontramos el mejor crédito para tí.</span>
                                            </div>
                                        </div>
                                        
                                        <div class="text-bottom-end">
                                            <div>
                                                <span class="h4">Te presentamos las <b>3</b>
                                                     Mejores</b> financieras </span>
                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6 text-end" id="hero-img">
                                <div class="col-12 pl-0 pl-md-12">
                                    <img class="img-fluid" src="/images/g683.png"
                                alt="">
                               </div>
                               


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- hero --}}

    

    {{-- kc score --}}
    <section class="position-relative bg-blur overflow-hidden">
        <svg class="position-absolute start-0 bottom-0 w-100 fill-body-bg" height="96" preserveAspectRatio="none"
            viewBox="0 0 1200 145" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M0 0L50 16.9167C100 33.8333 200 67.6667 300 77.3333C400 87 500 72.5 600 62.8333C700 53.1667 800 48.3333 900 55.5833C1000 62.8333 1100 82.1667 1150 91.8333L1200 101.5V145H1150C1100 145 1000 145 900 145C800 145 700 145 600 145C500 145 400 145 300 145C200 145 100 145 50 145H0V0Z"
                fill="currentColor"></path>
        </svg>
        <div class="container pt-11 pt-lg-15 pb-9">
            <div class="row pb-8 pb-lg-11">
                <div class="col-lg-10 col-xl-8 mx-auto text-center">
                    <h1 class="display-4 mb-0" data-aos="fade-up" data-aos-delay="100">Calificación de KaaxClub</h1>
                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        Analizamos a detalle y otorgamos una puntuación a cada financiera para ayudarte a tomar la mejor decisión.
                    </p>
                </div>
            </div>
        </div>
    </section>
    @php
        $chart1 = isset($new_financials[1])? $new_financials[1] : null ;
        $chart2 = isset($new_financials[0])? $new_financials[0] : null ;
        $chart3 = isset($new_financials[2])? $new_financials[2] : null ;
    @endphp
    <section class="position-relative">
        <div class="container-fluid pb-9 pb-lg-11 position-relative mt-n12">
            <div class="bg-body shadow-lg rounded-4 py-5">
                <div class="container mb-9 mb-lg-11">
                    <div class="row align-items-center justify-content-center">
                        @if ($new_financials != null)
                            @foreach ($new_financials as $key => $financial_product)
                            <div class="col-lg-4 px-md-1 px-lg-4 col-sm-10 " data-aos="fade-up" data-aos-delay="100">
                                <div class="card mb-4 mb-lg-0 shadow-lg rounded-4 border-0 overflow-hidden">
                                    @if ($key == 1)
                                    <span class="badge bg-warning rounded-bottom-0 py-3 fs-6">Mejor opción</span>
                                    @endif
                                    <div class="px-4 mt-4">
                                        <h3 class="mb-2">{{ $financial_product->commercial_name }}</h1>
                                            <p class="mb-0 text-muted"></p>
                                    </div>
                                    <div class="card-body pt-0 pb-4 px-4">
                                        <span class="h4 display-9"><span class="fw-light small"></span>Calificación: {{ $financial_product->rate_kc }}</span>
                                            <span
                                                class="fw-bold text-muted">/5 </span> 
                                                
                                        <small
                                            class="text-muted font-monospace mb-4 d-block"></small><button onclick="desitionReport({{ $credit->id }}, {{ $financial_product->financial_id }}, 1)" type="button"
                                            class="w-100 btn btn-lg {{ $key == 1 ? 'btn-gradient-primary' : 'btn-gradient-secondary' }} hover-lift">Tramitar</button>
                                        <ul class="list-unstyled mb-0 pt-4">
                                            <li class="mb-2">
                                                <span
                                                    class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                    <span>CAT REAL: {{ $financial_product->rate_cat }}</span><span class="text-sm text-muted">/5 </span>
                                                <a href="#" onclick="scrollToAnchor('section-cat-real')"> &nbsp; Ver</a>
                                               
                                            </li>
                                            <li class="mb-2">
                                                <span
                                                    class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                    <span>Comisiones: {{ $financial_product->rate_comision }} </span><span class="text-sm text-muted">/5 </span>
                                                <a href="#" onclick="scrollToAnchor('section-comisiones')"> &nbsp; Ver</a>
                                            </li>
                                            <li class="mb-2">
                                                <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>Plazo maximo: {{ $financial_product->rate_deadline }} </span><span class="text-sm text-muted">/5 </span>
                                                <a href="#" onclick="scrollToAnchor('section-plazo-maximo')"> &nbsp; Ver</a>
                                            </li>
                                            <li class="mb-2">
                                                <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>Contrato: {{ $financial_product->rate_contract }} </span><span class="text-sm text-muted">/5 </span>
                                                <a href="#" onclick="scrollToAnchor('section-contrato')"> &nbsp; Ver</a>
                                            </li>
                                           
                                            <li class="mb-2">
                                                <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>Priv. datos: {{ $financial_product->rate_privacity }} </span><span class="text-sm text-muted">/5 </span>
                                                <a href="#" onclick="scrollToAnchor('section-priv-datos')"> &nbsp; Ver</a>
                                        </ul>
                                        <div class="text-center mt-3">
                                            <a href="#" onclick="scrollToAnchor('section-simulacion')">Ver simulación</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        {{-- <div class="col-lg-4 px-md-1 px-lg-4 col-sm-10 " data-aos="fade-up" data-aos-delay="100">
                            <div class="card mb-4 mb-lg-0 shadow-lg rounded-4 border-0 overflow-hidden">
                                <div class="px-4 mt-4">
                                    <h3 class="mb-2">Crediplus</h1>
                                        <p class="mb-0 text-muted"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <span class="h4 display-9"><span class="fw-light small"></span>Calificación: 4.4</span>
                                        <span
                                            class="fw-bold text-muted">/5 </span> 
                                            
                                    <small
                                        class="text-muted font-monospace mb-4 d-block"></small><button onclick="desitionReport({{ $credit->id }}, 1, 1)" type="button"
                                        class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>CAT REAL: 4.1</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-cat-real')"> &nbsp; Ver</a>
                                           
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>Comisiones: 5</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-comisiones')"> &nbsp; Ver</a>
                                        </li>
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Plazo maximo: 4</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-plazo-maximo')"> &nbsp; Ver</a>
                                        </li>
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Contrato: 4.5</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-contrato')"> &nbsp; Ver</a>
                                        </li>
                                       
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Priv. datos: 4.5</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-priv-datos')"> &nbsp; Ver</a>
                                    </ul>
                                    <div class="text-center mt-3">
                                        <a href="#" onclick="scrollToAnchor('section-simulacion')">Ver simulación</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 px-md-1 px-lg-4 col-sm-10 " data-aos="fade-up">
                            <div class="card mb-4 mb-lg-0 shadow-lg rounded-4 border-0 overflow-hidden"><span
                                    class="badge bg-warning rounded-bottom-0 py-3 fs-6">Mejor opción</span>
                                <div class="px-4 py-4">
                                    <h3 class="mb-2">Consupago</h1>
                                        <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h6 class="display-9"><span class="fw-light small"></span>Calificación: 4.6<span
                                            class="small">/5</span></h6><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button onclick="desitionReport({{ $credit->id }}, 2, 1)" type="button"
                                        class="w-100 btn btn-lg btn-gradient-primary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>CAT REAL: 4.3</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-cat-real')"> &nbsp; Ver</a>
                                           
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>Comisiones: 5</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-comisiones')"> &nbsp; Ver</a>
                                        </li>
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Plazo maximo: 5</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-plazo-maximo')"> &nbsp; Ver</a>
                                        </li>
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Contrato: 4.5</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-contrato')"> &nbsp; Ver</a>
                                        </li>
                                       
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Priv. datos: 4.5</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-priv-datos')"> &nbsp; Ver</a>
                                    </ul>
                                    <div class="text-center mt-3">
                                        <a href="#" onclick="scrollToAnchor('section-simulacion')">Ver simulación</a>
                                    </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 px-md-1 px-lg-4 col-sm-10 " data-aos="fade-up" data-aos-delay="150">
                            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                                <div class="px-4 py-4">
                                    <h3 class="mb-2">Ommsa</h1>
                                        <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h6 class="display-9"><span class="fw-light small"></span>Calificación: 3.9<span
                                            class="small">/5</span></h6><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button onclick="desitionReport({{ $credit->id }}, 3, 1)" type="button"
                                        class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>CAT REAL: 3.3</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-cat-real')"> &nbsp; Ver</a>
                                           
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>Comisiones: 5</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-comisiones')"> &nbsp; Ver</a>
                                        </li>
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Plazo maximo: 3</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-plazo-maximo')"> &nbsp; Ver</a>
                                        </li>
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Contrato: 3.5</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-contrato')"> &nbsp; Ver</a>
                                        </li>
                                       
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Priv. datos: 4.5</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-priv-datos')"> &nbsp; Ver</a>
                                    </ul>
                                    <div class="text-center mt-3">
                                        <a href="#" onclick="scrollToAnchor('section-simulacion')">Ver simulación</a>
                                    </div>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                        
                        
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- cat real --}}
    <a name="section-cat-real"/>
    <section class="position-relative bg-style-1">
        <div class="container py-9 py-lg-11 position-relative z-index-1">
            <div class="row justify-content-between align-items-start">
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="analytics1" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 pe-md-5 pe-lg-7 col-sm-9 mb-6 mb-lg-0" data-aos="fade-up"
                                    data-aos-delay="100">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <canvas id="myChart"></canvas>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5 mx-auto">
                                    <h2 class="position-relative ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1 mb-4"
                                        data-aos="fade-up"> Costo Anual Total Real
                                    </h2>
                                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                        No es el famoso y confuso “CAT promedio” o “CAT para fines informativos” que te dicen en los anuncios, nosotros te decimos cuánto pagas al año por cada peso que te prestan.

                                    </p>
                                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                        El CAT real es el verdadero costo del crédito, esto incluye intereses, impuestos (IVA),  comisiones y cualquier otro cargo; Consideramos que es un factor importante, siempre es bueno pagar menos por el mismo producto.
                                    </p>
                                   



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- cat real --}}
    <a name="section-comisiones"/>
    <section class="position-relative bg-dark">
        <div class="container py-9 py-lg-11 position-relative z-index-1">
            <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50">


            </div>
            <div class="row justify-content-between align-items-start">
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="analytics1" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 pe-md-5 pe-lg-7 col-sm-9 mb-6 mb-lg-0">
                                    <div class="row align-items-center">
                                        <h1 class="position-relative ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1 mb-4"
                                            data-aos="fade-up" data-aos-delay="100">Comisiones.</h1>
                                        <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                            Las comisiones en realidad son un cobro de intereses por adelantado. Sin embargo, hay créditos que pueden ser más convenientes incluso si la cobran. Por eso es mejor fijarse en el <b>CAT real</b>, que considera dicha comisión y demás costos en su cálculo.

                                        </p>

                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5 mx-auto" data-aos="fade-up" data-aos-delay="100">

                                    <div class="container">
                                        <div class="table-responsive">
                                            <table class="table table-striped text-center text-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>
                                                            <h6 class="mb-0">Comisión x apertura
                                                            </h6>
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" class="text-start">  {{ $chart1 == null ? '' : $chart1->commercial_name}} </th>
                                                        <td><span class="fs-6">{{ $chart1 != null && $chart1->chart_comision_apertura == 1 ? 'SÍ' : 'NO'}}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">{{ $chart2 == null ? '' : $chart2->commercial_name}}</th>
                                                        <td><span class="fs-6">{{ $chart2 != null && $chart2->chart_comision_apertura == 1 ? 'SÍ' : 'NO'}}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="text-start">{{ $chart3 == null ? '' : $chart3->commercial_name}}</th>
                                                        <td><span class="fs-6">{{ $chart3 != null && $chart3->chart_comision_apertura == 1 ? 'SÍ' : 'NO'}}</span></td>
                                                    </tr>

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- comisiones --}}
    <a name="section-plazo-maximo"/>
    {{-- plazo --}}
    <section class="position-relative bg-style-1">
        <div class="container py-9 py-lg-11 position-relative z-index-1">
            <div class="row justify-content-between align-items-start">
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="analytics1" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 pe-md-5 pe-lg-7 col-sm-9 mb-6 mb-lg-0" data-aos="fade-up"
                                    data-aos-delay="100">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <canvas id="myChartPlazo"></canvas>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5 mx-auto">
                                    <h2 class="position-relative ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1 mb-4"
                                        data-aos="fade-up"> Plazo máximo
                                    </h2>
                                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                        Un mayor plazo te permite hacer pagos “chiquitos” pero al final, terminas pagando más interés..
                                        Sin embargo, en ocasiones una buena estrategia para adquirir un crédito es solicitar el plazo máximo para obtener un pago menor y realizar abonos a capital o liquidar el crédito anticipadamente. De esa forma pagarás menos interés.
                                        
                                    </p>
                                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                        Si tienes dudas sobre cómo realizar pagos adelantados (abono a capital), contacta un asesor. Con gusto atenderá. 

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- plazo --}}

    {{-- contrato --}}
    <a name="section-contrato"/>
    <section class="bg-dark position-relative">
        <div class="bg-blur position-absolute start-0 top-0 w-100 h-100 opacity-25"></div><svg
            class="position-absolute start-0 bottom-0 w-100 fill-body-bg" height="40%" preserveAspectRatio="none"
            viewBox="0 0 1200 145" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M0 0L50 16.9167C100 33.8333 200 67.6667 300 77.3333C400 87 500 72.5 600 62.8333C700 53.1667 800 48.3333 900 55.5833C1000 62.8333 1100 82.1667 1150 91.8333L1200 101.5V145H1150C1100 145 1000 145 900 145C800 145 700 145 600 145C500 145 400 145 300 145C200 145 100 145 50 145H0V0Z"
                fill="currentColor"></path>
        </svg>
        <div class="container pt-11 pt-lg-13 position-relative z-index-1">
            <div class="row pb-9 pb-lg-11 pt-lg-5">
                <div class="col-lg-11 mx-auto text-center">
                   
                    <div class="row align-items-center">
                        <div class="col-md-6 pe-md-5 pe-lg-7 col-sm-9 mb-6 mb-lg-0">
                            <div class="row align-items-center">
                                <h2 class="position-relative ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1 mb-4"
                                    data-aos="fade-up"> Contrato
                                </h2>
                                <p class="mb-5 lead text-white text-opacity-75 mx-auto w-lg-80 text-start" data-aos="fade-up"
                                    data-aos-delay="100">Revisamos por ti cada uno de los contratos, esos que nunca se leen,  en busca de cláusulas abusivas o engañosas que puedan perjudicarte.
                                </p>

                            </div>
                        </div>
                        <div class="col-md-6 col-lg-5 mx-auto" data-aos="fade-up" data-aos-delay="100">

                            <div class="container">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center text-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>
                                                    <h6 class="mb-0">Calificación
                                                    </h6>
                                                </th>
            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="text-start">{{ isset($chart1->commercial_name) ? $chart1->commercial_name : null }}</th>
                                                <td><span class="fs-6">
                                                    <span class="fw-light small"></span>Calificación: {{ isset($chart1->rate_contract) ? $chart1->rate_contract : null }}<span
                                                    class="small">/5</span>    
                                                </span></td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="text-start">{{ isset($chart2->commercial_name) ? $chart2->commercial_name : null }}</th>
                                                <td><span class="fs-6">
                                                    <span class="fw-light small"></span>Calificación: {{ isset($chart2->rate_contract) ? $chart2->rate_contract : null }}<span
                                                    class="small">/5</span>    
                                                </span></td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="text-start">{{ isset($chart3->commercial_name) ? $chart3->commercial_name : null }}</th>
                                                <td><span class="fs-6">
                                                    <span class="fw-light small"></span>Calificación: {{ isset($chart3->rate_contract) ? $chart3->rate_contract : null }}<span
                                                    class="small">/5</span>    
                                                </span></td>
                                            </tr>
                                        </tbody>
            
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- contrato --}}

    {{-- privacidad de datos --}}
    <a name="section-priv-datos"/>
    <section class="bg-dark position-relative">
        <div class="bg-blur position-absolute start-0 top-0 w-100 h-100 opacity-25"></div><svg
            class="position-absolute start-0 bottom-0 w-100 fill-body-bg" height="40%" preserveAspectRatio="none"
            viewBox="0 0 1200 145" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M0 0L50 16.9167C100 33.8333 200 67.6667 300 77.3333C400 87 500 72.5 600 62.8333C700 53.1667 800 48.3333 900 55.5833C1000 62.8333 1100 82.1667 1150 91.8333L1200 101.5V145H1150C1100 145 1000 145 900 145C800 145 700 145 600 145C500 145 400 145 300 145C200 145 100 145 50 145H0V0Z"
                fill="currentColor"></path>
        </svg>
        <div class="container pt-11 pt-lg-13 position-relative z-index-1">
            <div class="row pb-9 pb-lg-11 pt-lg-5">
                <div class="col-lg-11 mx-auto text-center">
                 

                    <div class="row align-items-center">
                        <div class="col-md-6 pe-md-5 pe-lg-7 col-sm-9 mb-6 mb-lg-0">
                            <div class="row align-items-center">
                                <div class="container">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-center text-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>
                                                        <h6 class="mb-0">Calificación
                                                        </h6>
                                                    </th>
                
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="text-start">{{ isset($chart1->commercial_name) ? $chart1->commercial_name : null }}</th>
                                                    <td><span class="fs-6">
                                                        <span class="fw-light small"></span>Calificación: {{ isset($chart1->rate_privacity) ? $chart1->rate_privacity : null }}<span
                                                        class="small">/5</span>    
                                                    </span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="text-start">{{ isset($chart2->commercial_name) ? $chart2->commercial_name : null }}</th>
                                                    <td><span class="fs-6">
                                                        <span class="fw-light small"></span>Calificación: {{ isset($chart2->rate_privacity) ? $chart2->rate_privacity : null }}<span
                                                        class="small">/5</span>    
                                                    </span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="text-start">{{ isset($chart3->commercial_name) ? $chart3->commercial_name : null }}</th>
                                                    <td><span class="fs-6">
                                                        <span class="fw-light small"></span>Calificación: {{ isset($chart3->rate_privacity) ? $chart3->rate_privacity : null }}<span
                                                        class="small">/5</span>    
                                                    </span></td>
                                                </tr>
                                            </tbody>
                
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-5 mx-auto" data-aos="fade-up" data-aos-delay="100">
                            <h2 class="position-relative ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1 mb-4"
                            data-aos="fade-up"> Privacidad de datos
                            </h2>
                            <p class="mb-5 lead text-white text-opacity-75 mx-auto w-lg-80 text-start" data-aos="fade-up"
                            data-aos-delay="100">
                            La protección de tus datos personales es tu derecho. Leemos y revisamos los avisos de privacidad para asegurarnos de que tus datos se usen de manera correcta
    
                        </p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- privacidad de datos --}}

    {{-- intereses --}}
    <a name="section-simulacion"/>
    <section class="position-relative  bg-style-1">
        <div class="container py-9 py-lg-11 position-relative z-index-1">
          
            <div class="row justify-content-between align-items-start">
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="analytics1" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 pe-md-5 pe-lg-7 col-sm-9 mb-6 mb-lg-0" data-aos="fade-up"
                                    data-aos-delay="100">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <h2 class="position-relative ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1 mb-4"
                                                data-aos="fade-up"> Simulación
                                            </h2>
                                            <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                                El interés es el costo del dinero durante el tiempo del préstamo, este, junto con las comisiones, IVA y cargos componen el CAT Real. Aquí te mostramos con un sencillo ejemplo, cuánto te cuesta tu crédito con cada finaciera. 
                                                (tip: mientras más larga la barra, mayor es el costo).
                                                

                                            </p>
                                            <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                                Para un crédito de <b class="h3">$10,000 a 1 año</b>
                                            </p>
                                           

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5 mx-auto">

                                    <canvas id="myChartInteres"></canvas>
                                </div>
                            </div>
                        </div>


                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('add_script')
    @include('layouts.script_report')
@endsection

