@extends('layouts.report')

@section('content')
    <!--::Hero Default::-->
    <section class="position-relative bg-style-1 debt">
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
                                            <div class="text-top">
                                                <div>
                                                    <span class="h1">Hola</span>
                                                    <span class="h1">{{ $client->name }}</span>
                                                </div>
                                            </div>
                                            <div class="text-bottom">
                                                <div>
                                                    <div class="textcontainer">
                                                        <span class="particletext confetti h1">FELICIDADES</span>
                                                    </div>
                                                    <span class="h4"> Estas son las alternativas a tu crédito actual para ti que laboras en la SEP Yucatán.
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="text-bottom-end text-debt-bottom">
                                                <div>
                                                    @if ($is_best == true)
                                                    <span class="h4">Tienes la mejor opción</span>
                                                    @else
                                                    <span class="h4">Hemos encontrado una mejor opción a tu crédito actual</span>
                                                    @endif
                                                   
                                                </div>
                                            </div>
                                            
                                        </div>
    
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5 mx-auto" id="hero-img">
                                    
                                    <img class="img-fluid" src="https://kaaxclub.com/images/thumb/item-detail.jpg"
                                    alt="">
    
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <section class="position-relative bg-blur overflow-hidden">
       
        <div class="container pt-11 pt-lg-15 pb-9">
            <div class="row pb-8 pb-lg-11">
                <div class="col-lg-10 col-xl-8 mx-auto text-center">
                    <h1 class="display-4 mb-0">
                       
                    </h1>
                    @if ($is_best == true)
                    <h1 class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        Puedes renovar tu crédito. Nosotros te apoyamos con el trámite.
                    </h1>
                    @else
                    <h1 class="mb-4" data-aos="fade-uh1" data-aos-delay="100">
                        Si te cambias de crédito; te ahorrarías el equivalente a 500 tacos.
                    </h1>
                    @endif
                    
                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        *Basado en un crédito de $25,000 a 2 años.

                    </p>

                    @if ($is_best == false)
                        <canvas id="chartOption" class="pb-5"></canvas>
                    @endif

                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        <a class="btn btn-warning btn-sm hover-lift me-3" href="/features/animations#">
                            @if ($is_best == true)
                            Quiero renovar mi crédito
                            @else
                            Quiero cambiar mi crédito a la mejor opción 
                            @endif
                           
                            
                            <span
                                class="material-symbols-rounded fs-5 ms-2 align-middle lh-1">arrow_forward</span></a>
                                <br>
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ks score --}}
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
                        Hemos analizado a detalle cada financiera y cada crédito para crear una puntuación que te ayude a
                        tomar una mejor decisión.
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
                        <div class="col-lg-4 px-md-1 px-lg-4 col-sm-10 " data-aos="fade-up" data-aos-delay="100">
                            <div class="card mb-4 mb-lg-0 shadow-lg rounded-4 border-0 overflow-hidden">
                                @if ($financial->commercial_name == 'Financiera x1' || $financial->commercial_name == 'Financiera 1')
                                    <span
                                    class="badge bg-primary rounded-bottom-0 py-3 fs-6">Financiera actual </span>
                                @endif
                               

                                <div class="px-4 mt-4">
                                    <h3 class="mb-2">Financiera 1</h1>
                                        <p class="mb-0 text-muted"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <span class="h4 display-9"><span class="fw-light small"></span>Calificación: 4.8</span>
                                        <span
                                            class="fw-bold text-muted">/5 </span> 
                                            
                                    <small
                                        class="text-muted font-monospace mb-4 d-block"></small><button type="button"
                                        class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>CAT REAL: 4.7</span><span class="text-sm text-muted">/5 </span>
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
                                            <span>Contrato: 4</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-contrato')"> &nbsp; Ver</a>
                                        </li>
                                       
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Priv. datos: 4.3</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-priv-datos')"> &nbsp; Ver</a>
                                    </ul>
                                    <div class="text-center mt-3">
                                        <a href="#" onclick="scrollToAnchor('section-simulacion')">Ver simulación</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 px-md-1 px-lg-4 col-sm-10 " data-aos="fade-up">
                            <div class="card mb-4 mb-lg-0 shadow-lg rounded-4 border-0 overflow-hidden">
                                @if ($financial->commercial_name == 'Financiera x2' || $financial->commercial_name == 'Financiera 2')
                                <span
                                class="badge bg-primary rounded-bottom-0 py-3 fs-6">Financiera actual </span>
                                @else
                                <span
                                class="badge bg-warning rounded-bottom-0 py-3 fs-6">Mejor opción</span>
                                @endif
                               
                                <div class="px-4 py-4">
                                    <h3 class="mb-2">Financiera</h1>
                                        <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h6 class="display-9"><span class="fw-light small"></span>Calificación: 5<span
                                            class="small">/5</span></h6><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button type="button"
                                        class="w-100 btn btn-lg btn-gradient-primary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>CAT REAL: 5</span><span class="text-sm text-muted">/5 </span>
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
                                            <span>Contrato: 5</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-contrato')"> &nbsp; Ver</a>
                                        </li>
                                       
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Priv. datos: 5</span><span class="text-sm text-muted">/5 </span>
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
                                @if ($financial->commercial_name == 'Financiera x3' || $financial->commercial_name == 'Financiera 3')
                                <span
                                class="badge bg-primary rounded-bottom-0 py-3 fs-6">Financiera actual </span>
                                @endif
                                <div class="px-4 py-4">
                                    <h3 class="mb-2">Financiera 3</h1>
                                        <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h6 class="display-9"><span class="fw-light small"></span>Calificación: 3<span
                                            class="small">/5</span></h6><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button type="button"
                                        class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>CAT REAL: 3</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-cat-real')"> &nbsp; Ver</a>
                                           
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>Comisiones: 3.2</span><span class="text-sm text-muted">/5 </span>
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
                                            <span>Contrato: 3</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-contrato')"> &nbsp; Ver</a>
                                        </li>
                                       
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Priv. datos: 4.3</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-priv-datos')"> &nbsp; Ver</a>
                                    </ul>
                                    <div class="text-center mt-3">
                                        <a href="#" onclick="scrollToAnchor('section-simulacion')">Ver simulación</a>
                                    </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 px-md-1 px-lg-4 col-sm-10  mt-5" data-aos="fade-up" data-aos-delay="150">
                            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                                @if ($financial->commercial_name == 'Financiera x4' || $financial->commercial_name == 'Financiera 4')
                                <span
                                class="badge bg-primary rounded-bottom-0 py-3 fs-6">Financiera actual </span>
                                @endif
                                <div class="px-4 py-4">
                                    <h3 class="mb-2">Financiera 4</h1>
                                        <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h6 class="display-9"><span class="fw-light small"></span>Calificación: 2<span
                                            class="small">/5</span></h6><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button type="button"
                                        class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>CAT REAL: 2</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-cat-real')"> &nbsp; Ver</a>
                                           
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>Comisiones: 3.3</span><span class="text-sm text-muted">/5 </span>
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
                                            <span>Contrato: 3</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-contrato')"> &nbsp; Ver</a>
                                        </li>
                                       
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Priv. datos: 2</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-priv-datos')"> &nbsp; Ver</a>
                                    </ul>
                                    <div class="text-center mt-3">
                                        <a href="#" onclick="scrollToAnchor('section-simulacion')">Ver simulación</a>
                                    </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 px-md-1 px-lg-4 col-sm-10  mt-5" data-aos="fade-up" data-aos-delay="150">
                            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                                @if ($financial->commercial_name == 'Financiera x5' || $financial->commercial_name == 'Financiera 5')
                                <span
                                class="badge bg-primary rounded-bottom-0 py-3 fs-6">Financiera actual </span>
                                @endif
                                <div class="px-4 py-4">
                                    <h3 class="mb-2">Financiera 5</h3>
                                    <p class="text-muted mb-0"></p>
                                </div>
                                <div class="card-body pt-0 pb-4 px-4">
                                    <h6 class="display-9"><span class="fw-light small"></span>Calificación: 2<span
                                            class="small">/5</span></h6><small
                                        class="text-muted font-monospace mb-4 d-block"></small><button type="button"
                                        class="w-100 btn btn-lg btn-gradient-secondary hover-lift">Tramitar</button>
                                    <ul class="list-unstyled mb-0 pt-4">
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>CAT REAL: 2</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-cat-real')"> &nbsp; Ver</a>
                                           
                                        </li>
                                        <li class="mb-2">
                                            <span
                                                class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                                <span>Comisiones: 2</span><span class="text-sm text-muted">/5 </span>
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
                                            <span>Contrato: 2</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-contrato')"> &nbsp; Ver</a>
                                        </li>
                                       
                                        <li class="mb-2">
                                            <span
                                            class="material-symbols-rounded align-middle text-warning fs-4 me-3">fiber_manual_record</span>
                                            <span>Priv. datos: 2</span><span class="text-sm text-muted">/5 </span>
                                            <a href="#" onclick="scrollToAnchor('section-priv-datos')"> &nbsp; Ver</a>
                                    </ul>
                                    <div class="text-center mt-3">
                                        <a href="#" onclick="scrollToAnchor('section-simulacion')">Ver simulación</a>
                                    </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
  {{-- cat real --}}
  <a name="section-cat-real"/>
  <section class="position-relative bg-style-1">
      <div class="container py-9 py-lg-11 position-relative z-index-1">
          <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50">
              <h5 class="bg-primary bg-opacity-25 text-primary d-table mx-auto rounded-pill px-3 py-2 mb-4"
                  data-aos="fade-up">CAT Real</h5>

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
                          <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50" data-aos="fade-up"
                              data-aos-delay="100">
                              <h5 class="bg-primary bg-opacity-25 text-primary d-table mx-auto rounded-pill px-3 py-2 mb-4"
                                  data-aos="fade-up">Comisiones</h5>

                          </div>
                          <div class="row align-items-center">
                              <div class="col-md-6 pe-md-5 pe-lg-7 col-sm-9 mb-6 mb-lg-0">
                                  <div class="row align-items-center">
                                      <h1 class="position-relative ms-md-n3 ms-lg-0 ms-0 me-lg-n5 fs-1 mb-4"
                                          data-aos="fade-up" data-aos-delay="100">Comisiones.</h1>
                                      <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                          La <b>comisión por apertura</b> en realidad es un cobro de intereses por
                                          adelantado. Sin embargo; hay créditos que pueden ser más convenientes incluso si
                                          cobran comisión por apertura. Es mejor fijarse en el <b>CAT real</b>, el cual
                                          considera dicha comisión en su cálculo.
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
                                                      <th scope="row" class="text-start">Financiera 1</th>
                                                      <td><span class="fs-6">SÍ</span></td>
                                                  </tr>
                                                  <tr>
                                                      <th scope="row" class="text-start">Financiera 2</th>
                                                      <td><span class="fs-6">NO</span></td>
                                                  </tr>
                                                  <tr>
                                                      <th scope="row" class="text-start">Financiera 3</th>
                                                      <td><span class="fs-6">NO</span></td>
                                                  </tr>
                                                  <tr>
                                                      <th scope="row" class="text-start">Financiera 4</th>
                                                      <td><span class="fs-6">NO</span></td>
                                                  </tr>
                                                  <tr>
                                                      <th scope="row" class="text-start">Financiera 5</th>
                                                      <td><span class="fs-6">NO</span></td>
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
          <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50">
              <h5 class="bg-primary bg-opacity-25 text-primary d-table mx-auto rounded-pill px-3 py-2 mb-4"
                  data-aos="fade-up">Plazo</h5>
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
                                  <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
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
                  <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50" data-aos="fade-up" data-aos-delay="100">
                      <h5 class="bg-primary bg-opacity-25 text-primary d-table mx-auto rounded-pill px-3 py-2 mb-4"
                          data-aos="fade-up">Contrato</h5>
                  </div>
                  <p class="mb-5 lead text-white text-opacity-75 mx-auto w-lg-80" data-aos="fade-up"
                      data-aos-delay="100">Analizamos cada uno de los contratos en busca de cláusulas abusivas o
                      engañosas.
                  </p>


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
                  <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50" data-aos="fade-up" data-aos-delay="100">
                      <h5 class="bg-primary bg-opacity-25 text-primary d-table mx-auto rounded-pill px-3 py-2 mb-4"
                          data-aos="fade-up">Privacidad de datos</h5>
                  </div>
                  <p class="mb-5 lead text-white text-opacity-75 mx-auto w-lg-80" data-aos="fade-up"
                      data-aos-delay="100">
                      La protección de tus datos personales es tu derecho. Analizamos los avisos de privacidad para
                      asegurarnos de que tus datos se usen únicamente para los fines requeridos y asegurarnos que no se
                      compartan ni se vendan a empresas con otro fin ajeno.

                  </p>


              </div>
          </div>
      </div>
  </section>
  {{-- privacidad de datos --}}

  {{-- intereses --}}
  <a name="section-simulacion"/>
  <section class="position-relative  bg-style-1">
      <div class="container py-9 py-lg-11 position-relative z-index-1">
          <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50">
              <h5 class="bg-primary bg-opacity-25 text-primary d-table mx-auto rounded-pill px-3 py-2 mb-4"
                  data-aos="fade-up">Simulación</h5>

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
                                              data-aos="fade-up"> Simulación
                                          </h2>
                                          <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                                              El interés es el costo del dinero. Aquí te decimos cuánto interés y cuánta comisión  se paga en un sencillo ejemplo.

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