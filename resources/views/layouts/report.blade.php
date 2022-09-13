<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>

    <!--:Page styles:-->
    <link rel="stylesheet" href="{{ asset('/assets_report/vendor/node_modules/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets_report/vendor/node_modules/css/swiper-bundle.min.css') }}">
    <!--:AOS Animation:-->
    <link rel="stylesheet" href="{{ asset('/assets_report/vendor/node_modules/css/aos.css') }}">
    <!--:Google fonts:-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;1,400;1,500&family=Poppins:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!--:Material symbols sharp icons:-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <!--:Main style:-->
    <link rel="stylesheet" href="{{ asset('/assets_report/css/theme.min.css') }}">
</head>

<body class="dark-mode">
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-sticky navbar-dark">
        <div class="container-fluid position-relative">
            <a class="navbar-brand" href="index.html">
                <img src="{{ asset('/assets_report/img/logo-white.svg') }}" class="img-fluid" alt="">
            </a><button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbarDefault" aria-controls="offcanvasNavbarDefault" aria-expanded="false"
                aria-label="Toggle navigation"><span class="material-symbols-rounded align-middle">menu</span></button>
            <div class="offcanvas offcanvas-start" data-bs-scroll="true" id="offcanvasNavbarDefault" tabindex="-1"
                aria-labelledby="offcanvasNavbarDefaultLabel">
                <div class="offcanvas-header justify-content-end">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="me-auto navbar-nav ms-xl-4">
                        <li class="nav-item dropdown"><a class="nav-link dropdown-arrow" href="#"
                                data-bs-toggle="dropdown">Opciones<span
                                    class="material-symbols-rounded align-middle lh-1 dropdown-arrow-icon">expand_more</span></a>
                            <div class="dropdown-menu"><a class="dropdown-item" href="index.html">Regresar</a><a
                                    class="dropdown-item" href="index-signup.html">Continuar</a></div>
                        </li>


                    </ul>
                    <ul class="navbar-nav ms-xl-auto">
                        <li class="nav-item mb-3 mb-lg-0"><a class="btn btn-warning btn-sm hover-lift"
                                href="demo-request.html">Request Demo<span
                                    class="align-middle material-symbols-rounded fs-5 ms-1 d-none d-xl-inline-block">arrow_forward</span></a>
                        </li>
                        <li
                            class="mt-4 mt-lg-0 nav-item d-flex align-items-center justify-content-lg-center flex-lg-column h-100 ms-0 ms-xl-3">
                            <label
                                class="dark-mode-checkbox d-flex align-items-center justify-content-center rounded-circle nav-link p-0"
                                for="ChangeTheme"><input type="checkbox" class="appearance-none" id="ChangeTheme"><span
                                    class="dark-mode-icons size-30 d-inline-flex align-items-center justify-content-center me-2 me-lg-0"><span
                                        class="material-symbols-rounded align-middle">dark_mode</span><span
                                        class="material-symbols-rounded align-middle">light_mode</span></span><span
                                    class="ms-1 d-lg-none">Dark Mode</span></label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


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
    <section class="position-relative bg-style-1">
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

                                            <ul class="list-unstyled mb-4 mb-lg-5 d-none" data-aos="fade-up"
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
                                    <h5 class="mb-2">Financiera 1</h5>
                                    <p class="mb-0 text-muted"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h1 class="display-5"><span class="fw-light small"></span>Score: 4.8</h1><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button
                                        type="button" class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>CAT REAL: 4.7</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Comisiones: 5</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Contrato 4.9</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Privacidad datos: 4.3</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-10 mx-auto" data-aos="fade-up">
                            <div class="card mb-4 mb-lg-0 shadow-lg rounded-4 border-0 overflow-hidden"><span
                                    class="badge bg-warning rounded-bottom-0 py-3 fs-6">Mejor opción</span>
                                <div class="px-4 py-4">
                                    <h5 class="mb-2">Financiera</h5>
                                    <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h1 class="display-5"><span class="fw-light small"></span>Score: 5</h1><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button
                                        type="button" class="w-100 btn btn-lg btn-gradient-primary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>CAT REAL: 5</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Comisiones: 5</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Contrato 5</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Privacidad datos: 5</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-10 mx-auto" data-aos="fade-up"
                            data-aos-delay="150">
                            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                                <div class="px-4 py-4">
                                    <h5 class="mb-2">Financiera 3</h5>
                                    <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h1 class="display-5"><span class="fw-light small"></span>Score: 3</h1><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button
                                        type="button" class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>CAT REAL: 3</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Comisiones: 3.2</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Contrato 3</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Privacidad datos: 3</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-10 mx-auto mt-5" data-aos="fade-up"
                            data-aos-delay="150">
                            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                                <div class="px-4 py-4">
                                    <h5 class="mb-2">Financiera 4</h5>
                                    <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h1 class="display-5"><span class="fw-light small"></span>Score: 2</h1><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button
                                        type="button" class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>CAT REAL: 2</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Comisiones: 3.2</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Contrato 3</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Privacidad datos: 3</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-10 mx-auto mt-5" data-aos="fade-up"
                            data-aos-delay="150">
                            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                                <div class="px-4 py-4">
                                    <h5 class="mb-2">Financiera 5</h5>
                                    <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h1 class="display-5"><span class="fw-light small"></span>Score: 2</h1><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button
                                        type="button" class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>CAT REAL: 2</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Comisiones: 2</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Contrato 3</li>
                                    <li class="d-flex align-items-center mb-3"><span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Privacidad datos: 3</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    
    {{-- kc score --}}
    <!--:Footer:-->
    <footer class="footer bg-dark text-white position-relative overflow-hidden">
        <div class="container pt-9 pt-lg-11 pb-4 position-relative z-index-1">
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-5">
                    <div class="mb-4"><a class="text-reset d-table width-120" href="/">
                            <img src="{{ asset('/assets_report/img/logo-white.svg') }}" class="img-fluid" alt="">
                        </a>
                    </div>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pellentesque
                        efficitur turpis, vitae dictum dolor tristique in.</p>
                </div>
                <div class="col-md-3 mx-auto col-lg-2 mb-5">
                    <ul class="list-unstyled">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Career</a></li>
                        <li><a href="#">Terms</a></li>
                        <li><a href="#">Privacy</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mx-auto col-lg-2 mb-5">
                    <ul class="list-unstyled">
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Press Kit</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-5">
                    <div class="d-flex flex-wrap social-links mb-5 align-items-center"><a href="#"><svg
                                xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z">
                                </path>
                            </svg></a><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="20" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z">
                                </path>
                            </svg></a><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="20" viewBox="0 0 448 512">
                                <path fill="currentColor"
                                    d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z">
                                </path>
                            </svg></a><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="20" viewBox="0 0 448 512">
                                <path fill="currentColor"
                                    d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                                </path>
                            </svg></a><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="24px" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M391.17,103.47H352.54v109.7h38.63ZM285,103H246.37V212.75H285ZM120.83,0,24.31,91.42V420.58H140.14V512l96.53-91.42h77.25L487.69,256V0ZM449.07,237.75l-77.22,73.12H294.61l-67.6,64v-64H140.14V36.58H449.07Z">
                                </path>
                            </svg></a></div>
                    <h6 class="mb-4 text-capitalize fw-bold">Subscribe to newsletter</h6>
                    <form class="mb-3">
                        <div class="mb-2"><input type="text"
                                class="form-control border-0 bg-white text-secondary"
                                placeholder="Enter your email address"></div>
                        <div class="d-grid"><button type="submit" class="btn btn-cta btn-primary">Subscribe</button>
                        </div>
                    </form><small class="text-muted">
                        © Copyright 2022. Saasley inc. </small>
                </div>
            </div>
        </div>
    </footer>


    <!--:Theme script:-->
    <script src="{{ asset('/assets_report/js/theme.bundle.js') }}"></script>

    <!--:Page scripts:-->
    <script src="{{ asset('/assets_report/vendor/node_modules/js/swiper-bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"
        integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.body.classList.add("dark-mode");
        checkbox.checked = true;
        sessionStorage.setItem("mode", "dark");

        var swiper = new Swiper(".swiper-partners", {
            slidesPerView: 3,
            spaceBetween: 16,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            breakpoints: {
                768: {
                    slidesPerView: 4,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 6,
                    spaceBetween: 32
                }
            }

        })
    </script>
    <script>
        const labels = [
            'Financiera 1',
            'Financiera 2',
            'Financiera 3',
            'Financiera 4',
            'Financiera 5',
        ];

        const data = {
            labels: labels,
            datasets: [{
                    label: 'Financiera1',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [80, 0, 0, 0, 0],
                    borderWidth: 2,
                    borderRadius: Number.MAX_VALUE,
                    borderSkipped: false,
                },
                {
                    label: 'Financiera2',
                    backgroundColor: 'rgb(255, 111, 0)',
                    borderColor: 'rgb(255, 111, 0)',
                    data: [0, 40, 0, 0, 0, 0],
                    borderWidth: 2,
                    borderRadius: Number.MAX_VALUE,
                    borderSkipped: false,
                },
                {
                    label: 'Financiera3',
                    backgroundColor: 'rgb(0, 34, 255)',
                    borderColor: 'rgb(0, 34, 255)',
                    data: [0, 0, 150, 0, 0],
                    borderWidth: 2,
                    borderRadius: Number.MAX_VALUE,
                    borderSkipped: false,
                },
                {
                    label: 'Financiera4',
                    backgroundColor: 'rgb(18, 255, 42)',
                    borderColor: 'rgb(18, 255, 42)',
                    data: [0, 0, 0, 100, 0],
                    borderWidth: 2,
                    borderRadius: Number.MAX_VALUE,
                    borderSkipped: false,
                },
                {
                    label: 'Financiera5',
                    backgroundColor: 'rgb(185, 18, 255)',
                    borderColor: 'rgb(185, 18, 255)',
                    data: [0, 0, 0, 0, 90],
                    borderWidth: 2,
                    borderRadius: Number.MAX_VALUE,
                    borderSkipped: false,
                },
            ]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Bar Chart'
                    }
                }
            },
        };
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        /*  intereses */
        const labels_interes = [
            'Financiera 1',
            'Financiera 2',
            'Financiera 3',
            'Financiera 4',
            'Financiera 5',
        ];

        const data_interes = {
            labels: labels_interes,
            datasets: [{
                    label: 'Financiera1',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [4000, 0, 0, 0, 0],

                },
                {
                    label: 'Financiera2',
                    backgroundColor: 'rgb(255, 111, 0)',
                    borderColor: 'rgb(255, 111, 0)',
                    data: [80, 40, 0, 0, 0, 0],
                },
                {
                    label: 'Financiera3',
                    backgroundColor: 'rgb(0, 34, 255)',
                    borderColor: 'rgb(0, 34, 255)',
                    data: [0, 0, 150, 0, 0],
                },
                {
                    label: 'Financiera4',
                    backgroundColor: 'rgb(18, 255, 42)',
                    borderColor: 'rgb(18, 255, 42)',
                    data: [0, 0, 0, 100, 0],
                },
                {
                    label: 'Financiera5',
                    backgroundColor: 'rgb(185, 18, 255)',
                    borderColor: 'rgb(185, 18, 255)',
                    data: [0, 0, 0, 0, 90],
                },
            ]
        };

        const config_interes = {
            type: 'bar',
            data: data_interes,
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Bar Chart'
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            },
        };
        const myChart_interes = new Chart(
            document.getElementById('myChartInteres'),
            config_interes
        );
        /* plazo */
        const labels_plazo = [
            'Financiera 1',
            'Financiera 2',
            'Financiera 3',
            'Financiera 4',
            'Financiera 5',
        ];

        const data_plazo = {
            labels: labels_plazo,
            datasets: [{
                    label: 'Años',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [2, 2.5, 3, 3.5, 3],

                },

            ]
        };

        const config_plazo = {
            type: 'bar',
            data: data_plazo,
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Bar Chart'
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            },
        };
        const myChart_plazo = new Chart(
            document.getElementById('myChartPlazo'),
            config_plazo
        );
    </script>

</body>

</html>
