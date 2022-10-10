@extends('layouts.report')

@section('content')
    <!--::Hero Default::-->
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
                    <h1 class="display-4 mb-5 text-white"> {{ $client->name }}, estas son las opciones de crédito. </h1>
                    <p class="mb-5 lead text-white text-opacity-75 mx-auto w-lg-80">Te presentamos las <b>5</b>
                        financieras que te ofrecen crédito vía descuento de nómina para ti que laboras en la <b>SEP
                            Yucatán.</b> </p>


                </div>
            </div>
        </div>
    </section>
    <!--::/End hero default/::-->

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
                    <h1 class="display-4 mb-0">Calificación de KaaxClub</h1>
                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        Hemos analizado a detalle cada financiera y cada crédito para crear una puntuación que te ayude a tomar una mejor decisión.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="position-relative">
        <div class="container-fluid pb-9 pb-lg-11 position-relative mt-n12">
            <div class="bg-body shadow-lg rounded-4 py-5">
                <div class="container mb-9 mb-lg-11">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-4 col-sm-10 mx-auto" data-aos="fade-up"
                            data-aos-delay="100">
                            <div class="card mb-4 mb-lg-0 shadow-lg rounded-4 border-0 overflow-hidden">
                                <div class="px-4 py-4">
                                    <h1 class="mb-2">Financiera 1</h1>
                                    <p class="mb-0 text-muted"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h1 class="display-5"><span class="fw-light small"></span>Score: 4.8</h1><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button
                                        type="button" class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>CAT REAL: 4.7</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Comisiones: 5</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Contrato 4.9</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Privacidad datos: 4.3</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-10 mx-auto" data-aos="fade-up">
                            <div class="card mb-4 mb-lg-0 shadow-lg rounded-4 border-0 overflow-hidden"><span
                                    class="badge bg-warning rounded-bottom-0 py-3 fs-6">Mejor opción</span>
                                <div class="px-4 py-4">
                                    <h1 class="mb-2">Financiera</h1>
                                    <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h1 class="display-5"><span class="fw-light small"></span>Score: 5</h1><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button
                                        type="button" class="w-100 btn btn-lg btn-gradient-primary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>CAT REAL: 5</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Comisiones: 5</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Contrato 5</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Privacidad datos: 5</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-10 mx-auto" data-aos="fade-up"
                            data-aos-delay="150">
                            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                                <div class="px-4 py-4">
                                    <h1 class="mb-2">Financiera 3</h1>
                                    <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h1 class="display-5"><span class="fw-light small"></span>Score: 3</h1><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button
                                        type="button" class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>CAT REAL: 3</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Comisiones: 3.2</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Contrato 3</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Privacidad datos: 3</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-10 mx-auto mt-5" data-aos="fade-up"
                            data-aos-delay="150">
                            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                                <div class="px-4 py-4">
                                    <h1 class="mb-2">Financiera 4</h1>
                                    <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h1 class="display-5"><span class="fw-light small"></span>Score: 2</h1><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button
                                        type="button" class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>CAT REAL: 2</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Comisiones: 3.2</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Contrato 3</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Privacidad datos: 3</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-10 mx-auto mt-5" data-aos="fade-up"
                            data-aos-delay="150">
                            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                                <div class="px-4 py-4">
                                    <h1 class="mb-2">Financiera 5</h1>
                                    <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h1 class="display-5"><span class="fw-light small"></span>Score: 2</h1><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button
                                        type="button" class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>CAT REAL: 2</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Comisiones: 2</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Contrato 3</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">circle</span>Privacidad datos: 3</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <section class="position-relative bg-style-1">
        <div class="container py-9 py-lg-11 position-relative z-index-1">
            <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50">
                <h6 class="bg-primary bg-opacity-25 text-primary d-table mx-auto rounded-pill px-3 py-2 mb-4"
                    data-aos="fade-up">CAT Real</h6>

            </div>
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
                                        El <b>CAT real</b> es el verdadero costo que tiene un crédito. Incluye el
                                        interés, comisiones y cargos del crédito; Es una de la información más
                                        importante.
                                    </p>
                                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">Lorem
                                        En algunos lugares encontrarás términos confusos como "CAT promedio" o "CAT para
                                        fines informativos”

                                    </p>
                                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">Lorem
                                        En KaaxClub te decimos el <b>CAT Real.</b> Sin rodeos.

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

    {{-- intereses --}}
    <section class="position-relative bg-dark">
        <div class="container py-9 py-lg-11 position-relative z-index-1">
            <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50">
                <h6 class="bg-primary bg-opacity-25 text-primary d-table mx-auto rounded-pill px-3 py-2 mb-4"
                    data-aos="fade-up">Intereses</h6>

            </div>
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
                                                data-aos="fade-up"> Pago de interés
                                            </h2>
                                            <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                                El interés es el costo del dinero. Aquí te decimos cuánto interés se
                                                paga para el siguiente ejemplo:
                                            </p>
                                            <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                                Para un crédito de $10,000 a 1 año; pagarías el siguiente interés.
                                            </p>

                                            <ul class="list-unstyled mb-4 mb-lg-5" data-aos="fade-up"
                                                data-aos-delay="200">
                                                <li class="d-flex mb-3 align-items-start"><span
                                                        class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Financiera
                                                    1: $4,000 de interés.

                                                </li>
                                                <li class="d-flex mb-3 align-items-start"><span
                                                        class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Financiera
                                                    2: $4,900 de interés.
                                                </li>
                                                <li class="d-flex mb-3 align-items-start"><span
                                                        class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Financiera
                                                    3: $6,000 de interés.

                                                </li>
                                                <li class="d-flex mb-3 align-items-start"><span
                                                        class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Financiera
                                                    4: $5,900 de interés.


                                                </li>
                                                <li class="d-flex mb-3 align-items-start"><span
                                                        class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Financiera
                                                    5: $7,000 de interés.


                                                </li>
                                            </ul>

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

    {{-- plazo --}}
    <section class="position-relative bg-style-1">
        <div class="container py-9 py-lg-11 position-relative z-index-1">
            <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50">
                <h6 class="bg-primary bg-opacity-25 text-primary d-table mx-auto rounded-pill px-3 py-2 mb-4"
                    data-aos="fade-up">Plazo</h6>

            </div>
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
                                        En ocasiones, una buena estrategia para adquirir un crédito es solicitar el
                                        plazo máximo para obtener un pago menor y realizar pagos anticipados (abono a
                                        capital) cada vez que sea posible. De ese modo, pagarás menos interés.


                                    </p>
                                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">Lorem
                                        Si tienes dudas sobre cómo realizar pagos adelantados (abono a capital),
                                        contacta un asesor. Con gusto atenderá.

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
   
@endsection