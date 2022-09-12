<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte</title>

        <!--:Page styles:-->
        <link rel="stylesheet" href="/assets_report/vendor/node_modules/css/glightbox.min.css">
        <link rel="stylesheet" href="/assets_report/vendor/node_modules/css/swiper-bundle.min.css">
        <!--:AOS Animation:-->
        <link rel="stylesheet" href="/assets_report/vendor/node_modules/css/aos.css">
        <!--:Google fonts:-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;1,400;1,500&family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

        <!--:Material symbols sharp icons:-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
        <!--:Main style:-->
        <link rel="stylesheet" href="/assets_report/css/theme.min.css">
    </head>

    <body class="dark-mode">
        <nav
            class="navbar navbar-expand-lg navbar-transparent navbar-sticky navbar-dark">
            <div class="container-fluid position-relative">
                <a class="navbar-brand" href="index.html">
                    <img src="/assets_report/img/logo-white.svg" class="img-fluid" alt="">
                </a><button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbarDefault" aria-controls="offcanvasNavbarDefault" aria-expanded="false"
                    aria-label="Toggle navigation"><span class="material-symbols-rounded align-middle">menu</span></button>
                <div class="offcanvas offcanvas-start" data-bs-scroll="true" id="offcanvasNavbarDefault" tabindex="-1"
                    aria-labelledby="offcanvasNavbarDefaultLabel">
                    <div class="offcanvas-header justify-content-end">
                        <button type="button" class="btn-close"
                            data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
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
                        <h1 class="display-4 mb-5 text-white"> {{ $client->name}}, estas son las opciones de crédito. </h1>
                        <p class="mb-5 lead text-white text-opacity-75 mx-auto w-lg-80">Te presentamos las <b>5</b> financieras que te ofrecen crédito vía descuento de nómina para ti que laboras en la <b>SEP Yucatán.</b> </p>
                        
                        
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
                                        <p class="mb-4" data-aos="fade-up" data-aos-delay="100">Lorem
                                            El <b>CAT real</b> es el verdadero costo que tiene un crédito. Incluye el interés,  comisiones y cargos del crédito; Es una de la información más importante.
                                        </p>
                                        <p class="mb-4" data-aos="fade-up" data-aos-delay="100">Lorem
                                            En algunos lugares encontrarás términos confusos como "CAT promedio" o  "CAT para fines informativos” 

                                        </p>
                                        <p class="mb-4" data-aos="fade-up" data-aos-delay="100">Lorem
                                            En KaaxClub te decimos el <b>CAT Real.</b> Sin rodeos.

                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="messenger1" role="tabpanel">
                                <div class="row align-items-center">
                                    <div class="col-md-6 position-relative ps-md-5 ps-lg-9 col-sm-9 mb-6 mb-md-0 order-md-last mx-md-auto"
                                        data-aos="fade-up" data-aos-delay="100">
                                        <div class="row align-items-center">
                                            <div class="col-10">
                                                <div class="position-relative pb-7" data-aos="zoom-in-up">
                                                    <img src="/assets_report/img/img1.jpg" class="img-fluid rounded-3" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="position-absolute z-index-1 me-3 width-160 w-md-50 w-lg-35 h-auto end-0 bottom-0 overflow-hidden shadow-lg rounded-3"
                                            data-aos="zoom-in-down" data-aos-delay="100">
                                            <img src="/assets_report/img/shots/07.png" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 order-md-1 ms-md-auto">
                                        <h2 class="position-relative mb-4 fs-1" data-aos="fade-right">Inbuilt chat
                                            for your organization.</h2>
                                        <p class="lead mb-4" data-aos="fade-right" data-aos-delay="100">Lorem ipsum
                                            is placeholder text commonly used in the graphic, print, and publishing.</p>
                                        <ul class="list-unstyled mb-4 mb-lg-5" data-aos="fade-right"
                                            data-aos-delay="150">
                                            <li class="d-flex mb-3 align-items-start"><span
                                                    class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Laboris
                                                nisi ut aliquip ex ea commodo consequat.</li>
                                            <li class="d-flex mb-3 align-items-start"><span
                                                    class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Officia
                                                deserunt mollit anim id est laborum.</li>
                                        </ul>
                                        <div data-aos="fade-right" data-aos-delay="200" class="aos-init"><a
                                                class="fw-bold" href="/#">Learn More About Features<span
                                                    class="material-symbols-rounded fs-5 ms-2 align-middle lh-1">arrow_forward</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="deploy1" role="tabpanel">
                                <div class="row align-items-center">
                                    <div class="col-md-6 mb-6 mb-md-0" data-aos="fade-up" data-aos-delay="100">
                                        <div class="position-relative">
                                            <img src="/assets_report/img/integrations.svg" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 ms-lg-auto">
                                        <h2 class="position-relative fs-1 mb-4" data-aos="fade-up">Deploy anywhere
                                            — with any data.</h2>
                                        <p class="lead d-none d-lg-block mb-4" data-aos="fade-up" data-aos-delay="100">
                                            Lorem ipsum is
                                            placeholder text commonly used in the graphic, print,
                                            and publishing.</p>
                                        <ul class="list-unstyled mb-5" data-aos="fade-up" data-aos-delay="200">
                                            <li class="d-flex mb-3 align-items-start"><span
                                                    class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Ut
                                                enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                                aliquip ex ea
                                                commodo consequat.</li>
                                            <li class="d-flex mb-3 align-items-start"><span
                                                    class="material-symbols-rounded align-middle text-warning fs-4 me-3">check_circle</span>Excepteur
                                                sint occaecat cupidatat sunt in culpa qui officia deserunt mollit anim
                                                id est laborum.
                                            </li>
                                        </ul>
                                        <div data-aos="fade-up" data-aos-delay="300" class="aos-init"><a class="fw-bold"
                                                href="/#">Learn More<span
                                                    class="material-symbols-rounded fs-5 ms-2 align-middle lh-1">arrow_forward</span></a>
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

        <!--::Benefits::-->
        <section class="position-relative">
            <div class="container py-9 py-lg-11">
                <h6 data-aos="fade-up"
                    class="bg-warning bg-opacity-25 text-warning d-table mx-auto rounded-pill px-3 py-2 mb-4">More
                    benefits</h6>
                <h2 class="display-5 text-center mb-6 mb-lg-9" data-aos="fade-up" data-aos-delay="100">Saasley at your
                    fingertips</h2>
                <div class="row justify-content-around">
                    <div class="col-sm-6 col-xl-3 mb-6" data-aos="fade-up" data-aos-delay="150">
                        <div>
                            <div class="d-flex flex-wrap mb-3"><span class=" border-primary text-primary"><span
                                        class="material-symbols-rounded align-middle fs-3">insights</span></span>
                                <div class="flex-grow-1 ps-3">
                                    <h5 class="mb-0">Analytics</h5>
                                </div>
                            </div>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. </p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 mb-6" data-aos="fade-up" data-aos-delay="200">
                        <div>
                            <div class="d-flex flex-wrap mb-3"><span class=" border-success text-success"><span
                                        class="material-symbols-rounded align-middle fs-3">workspaces</span></span>
                                <div class="flex-grow-1 ps-3">
                                    <h5 class="mb-0">Collaboration</h5>
                                </div>
                            </div>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. </p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 mb-6" data-aos="fade-up" data-aos-delay="250">
                        <div>
                            <div class="d-flex flex-wrap mb-3"><span class=" border-warning text-warning"><span
                                        class="material-symbols-rounded align-middle fs-3">smart_toy</span></span>
                                <div class="flex-grow-1 ps-3">
                                    <h5 class="mb-0">Automation</h5>
                                </div>
                            </div>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. </p>
                        </div>
                    </div>
                    <div class="col-12 d-none d-xl-block"></div>
                    <div class="col-sm-6 col-xl-3 mb-6 mb-md-0" data-aos="fade-up" data-aos-delay="300">
                        <div>
                            <div class="d-flex flex-wrap mb-3"><span class=" border-danger text-danger"><span
                                        class="material-symbols-rounded align-middle fs-3">verified_user</span></span>
                                <div class="flex-grow-1 ps-3">
                                    <h5 class="mb-0">Secure &amp; Reliable</h5>
                                </div>
                            </div>
                            <p class="mb-0">Lorem ipsum dolor sit amet, adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. </p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 mb-6 mb-sm-0" data-aos="fade-up" data-aos-delay="350">
                        <div>
                            <div class="d-flex flex-wrap mb-3"><span class=" border-secondary text-secondary"><span
                                        class="material-symbols-rounded align-middle fs-3">credit_score</span></span>
                                <div class="flex-grow-1 ps-3">
                                    <h5 class="mb-0">Affordable</h5>
                                </div>
                            </div>
                            <p class="mb-0">Lorem ipsum dolor sit amet, adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. </p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3" data-aos="fade-up" data-aos-delay="400">
                        <div>
                            <div class="d-flex flex-wrap mb-3"><span class=" border-info text-info"><span
                                        class="material-symbols-rounded align-middle fs-3">contact_support</span></span>
                                <div class="flex-grow-1 ps-3">
                                    <h5 class="mb-0">24/7 Suupport</h5>
                                </div>
                            </div>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--::/End Benefits/::-->

        <!--::Process::-->
        <section class="overflow-hidden bg-style-1 position-relative">
            <div class="container py-9 py-lg-11">
                <h6 class="bg-primary bg-opacity-25 text-primary d-table mx-auto rounded-pill px-3 py-2 mb-4"
                    data-aos="fade-up">Our
                    Process</h6>
                <h2 class="display-5 w-lg-50 mx-auto text-center mb-6 mb-lg-7" data-aos="fade-up" data-aos-delay="100">
                    How does it work?</h2>
                <div class="row justify-content-around">
                    <div class="col-md-4 col-xl-3 mb-6 mb-md-0" data-aos="fade-up" data-aos-delay="150">
                        <div>
                            <div class="position-relative size-160 d-flex align-items-center justify-content-center">
                                <div class="position-relative w-100 h-auto">
                                    <img src="/assets_report/img/illustrations/3.svg" class="img-fluid" alt="">
                                </div>
                            </div>
                            <div class="pe-md-3">
                                <h5 class="mb-3">Create account</h5>
                                <p class="mb-0 text-muted">Lorem ipsum is placeholder text commonly used in the graphic,
                                    print, and publishing.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xl-3 mb-6 mb-md-0" data-aos="fade-up" data-aos-delay="200">
                        <div class="position-relative size-160 d-flex align-items-center justify-content-center">
                            <div class="position-relative w-100 h-auto">
                                <img src="/assets_report/img/illustrations/2.svg" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="pe-md-3">
                            <h5 class="mb-3">Select a plan</h5>
                            <p class="mb-0 text-muted">Lorem ipsum is placeholder text commonly used in the graphic,
                                print, and publishing.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-xl-3" data-aos="fade-up" data-aos-delay="250">
                        <div class="position-relative size-160 d-flex align-items-center justify-content-center">
                            <div class="position-relative w-100 h-auto">
                                <img src="/assets_report/img/illustrations/1.svg" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="pe-md-3">
                            <h5 class="mb-3">Start managing</h5>
                            <p class="mb-0 text-muted">Lorem ipsum is placeholder text commonly used in the graphic,
                                print, and publishing.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--::/End Process/::-->

        <!--::Testimonials::-->
        <section class="overflow-hidden position-relative">
            <div class="container py-9 py-lg-11">
                <h6 class="bg-warning bg-opacity-25 text-warning d-table mx-auto rounded-pill px-3 py-2 mb-4"
                    data-aos="fade-up">
                    Testimonials</h6>
                <h2 class="display-5 w-lg-50 mx-auto text-center mb-6 mb-lg-7" data-aos="fade-up" data-aos-delay="100">
                    What do customers say about Saasley?</h2>
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="150">
                        <div class="card text-center py-5 px-4 py-lg-6 hover-lift shadow-lg border-0 rounded-4">
                            <div class="mb-4 size-60 rounded-circle overflow-hidden shadow-lg mx-auto">
                                <img src="/assets_report/img/avatars/male/1.jpg" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="text-warning d-flex align-items-center justify-content-center mb-3">
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star_half</span>
                            </div>
                            <p class="fs-5 fw-normal mb-4">“ We were looking for an innovation partner that could be
                                provide all the elements that we needed. Saasley, with its abilities was a good match.”
                            </p>
                            <h5>Jason Ings</h5>
                            <p class="mb-0 text-muted">React Developer</p>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                        <div class="card text-center py-5 px-4 py-lg-6 hover-lift shadow-lg border-0 rounded-4">
                            <div class="mb-4 size-60 rounded-circle overflow-hidden shadow-lg mx-auto">
                                <img src="/assets_report/img/avatars/female/1.jpg" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="text-warning d-flex align-items-center justify-content-center mb-3">
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star</span>
                            </div>
                            <p class="fs-5 fw-normal mb-4">“ We were looking for an innovation partner that could be
                                provide all the elements that we needed. Saasley, with its abilities was a good match.”
                            </p>
                            <h5>Nikita Milner</h5>
                            <p class="mb-0 text-muted">Marketing Manager</p>
                        </div>
                    </div>
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="250">
                        <div class="card text-center py-5 px-4 py-lg-6 hover-lift shadow-lg border-0 rounded-4">
                            <div class="mb-4 size-60 rounded-circle overflow-hidden shadow-lg mx-auto">
                                <img src="/assets_report/img/avatars/male/2.jpg" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="text-warning d-flex align-items-center justify-content-center mb-3">
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star</span>
                                <span class="material-symbols-rounded">star</span>
                            </div>
                            <p class="fs-5 fw-normal mb-4">“ We were looking for an innovation partner that could be
                                provide all the elements that we needed. Saasley, with its abilities was a good match.”
                            </p>
                            <h5>Mark Otto</h5>
                            <p class="mb-0 text-muted">Full Stack Developer</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--::/End Testimonials/::-->

        <section class="bg-style-1">
            <div class="container py-9 py-lg-11">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-7 col-xl-6 mb-5 mb-md-0" data-aos="fade-up">
                        <h2 class="display-5 mb-0">Kickstart your landing project with ready-made components</h2>
                    </div>
                    <div class="col-md-5">
                        <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Join over 25000+ customers
                            worldwide</p>
                        <p class="mb-5" data-aos="fade-up" data-aos-delay="150">Saasley is a modern website template
                            perfect for marketing your SaaS products.
                            It helps to launch your products fast and grow exponentially.</p>
                        <div data-aos="fade-up" data-aos-delay="200">
                            <a class="btn btn-lg btn-primary" href="#!">Get started today<span
                                    class="material-symbols-rounded ms-2 fs-5 align-middle">arrow_forward</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--:Footer:-->
        <footer class="footer bg-dark text-white position-relative overflow-hidden">
            <div class="container pt-9 pt-lg-11 pb-4 position-relative z-index-1">
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-5">
                        <div class="mb-4"><a class="text-reset d-table width-120" href="/">
                            <img src="/assets_report/img/logo-white.svg" class="img-fluid" alt="">
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
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                        d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z">
                                    </path>
                                </svg></a><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                        d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z">
                                    </path>
                                </svg></a><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 448 512">
                                    <path fill="currentColor"
                                        d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z">
                                    </path>
                                </svg></a><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 448 512">
                                    <path fill="currentColor"
                                        d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                                    </path>
                                </svg></a><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="24px"
                                    viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                        d="M391.17,103.47H352.54v109.7h38.63ZM285,103H246.37V212.75H285ZM120.83,0,24.31,91.42V420.58H140.14V512l96.53-91.42h77.25L487.69,256V0ZM449.07,237.75l-77.22,73.12H294.61l-67.6,64v-64H140.14V36.58H449.07Z">
                                    </path>
                                </svg></a></div>
                        <h6 class="mb-4 text-capitalize fw-bold">Subscribe to newsletter</h6>
                        <form class="mb-3">
                            <div class="mb-2"><input type="text" class="form-control border-0 bg-white text-secondary"
                                    placeholder="Enter your email address"></div>
                            <div class="d-grid"><button type="submit" class="btn btn-cta btn-primary">Subscribe</button></div>
                        </form><small class="text-muted">
                            © Copyright 2022. Saasley inc. </small>
                    </div>
                </div>
            </div>
        </footer>


        <!--:Theme script:-->
        <script src="/assets_report/js/theme.bundle.js"></script>

        <!--:Page scripts:-->
        <script src="/assets_report/vendor/node_modules/js/swiper-bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
              datasets: [
                {
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
                data: [0, 40, 0, 0, 0 ,0],
                borderWidth: 2,
                borderRadius: Number.MAX_VALUE,
                borderSkipped: false,
              },
                {
                label: 'Financiera3',
                backgroundColor: 'rgb(0, 34, 255)',
                borderColor: 'rgb(0, 34, 255)',
                data: [0, 0, 150, 0 , 0],
                borderWidth: 2,
                borderRadius: Number.MAX_VALUE,
                borderSkipped: false,
              },
                {
                label: 'Financiera4',
                backgroundColor: 'rgb(18, 255, 42)',
                borderColor: 'rgb(18, 255, 42)',
                data: [0, 0, 0, 100 , 0],
                borderWidth: 2,
                borderRadius: Number.MAX_VALUE,
                borderSkipped: false,
              },
                {
                label: 'Financiera5',
                backgroundColor: 'rgb(185, 18, 255)',
                borderColor: 'rgb(185, 18, 255)',
                data: [0, 0, 0, 0 , 90],
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
          </script>
          
    </body>

</html>
