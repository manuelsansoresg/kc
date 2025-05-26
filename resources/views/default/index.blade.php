@extends('layouts.default')

@section('hero')
    <div class="hero-wrap hero-wrap-2 section-space kc">
        <div class="container">
            <div class="row align-items-center flex-md-row-reverse justify-content-between">
                <div class="col-lg-5 col-12 col-md-6">
                    <div class="row justify-content-center">
                        <div class="hero-image col-8 col-md-12 d-none d-md-block">
                            <img src="images/tuyyo.png" alt="" class="">
                            
                        </div>
                        <div class="col-12">
                            <p class="text-center text-elije"></p>
                        </div>
                    </div>
                </div><!-- end col-lg-5 -->
                <div class="col-lg-6 col-md-6 text-center text-md-start mt-n3 mt-md-0">
                    <div class="hero-content pb-0 pt-md-0 pe-lg-4">
                        <h1 class="hero-title mb-4 color-primary">
                            Le damos crédito a tus necesidades.
                        </h1>
                        <p class="hero-text mb-4 pb-4">
                            <b>Selecciona una opción y tramita desde tu teléfono.</b>
                        </p>
                        <!-- button group -->
                        <div class="row mt-n2 mt-md-0">
                            <div class="col-12 col-md-12">
                                <a href="https://api.whatsapp.com/send?phone=+529999208020&text=Hola, quiero Salario OnDemand"  class="btn col-12 btn-highlight btn-block">
                                    <span class="text-decoration-underline">Salario On-Demand</span> 
                                    <br>
                                    <span class="text-small">Cobra tus días trabajados antes del día de pago</span>
                                </a>
                               {{--  <div class="mt-0 mt-md-3 text-center">
                                    <small class="text-muted text-center">
                                        
                                    </small>
                                </div> --}}
                            </div>
                            <div class="col-12 col-md-12 mt-3">
                                <a href=": https://api.whatsapp.com/send?phone=+529999208020&text=Hola, quiero reducir mi deuda actual"  class="btn col-12 btn-dark btn-block">
                                    <span class="text-decoration-underline">Reduce tu deuda actual</span>
                                    <br>
                                     <span class="text-small">Cámbiate a un mejor crédito </span>
                                </a>
                            </div>
                         
                            <div class="col-12 col-md-12 mt-3">
                                <a href="https://api.whatsapp.com/send?phone=+529999208020&text=Hola, quiero un crédito nuevo"  class="btn col-12 btn-highlight-two btn-block">
                                    <span class="text-decoration-underline">Crédito personal</span>
                                    <br>
                                     <span class="text-small">Obtén un crédito con las mejores condiciones </span>
                                </a>
                            </div>
                            <div class="hero-image col-12 d-block d-md-none">
                                <img src="images/tuyyo.png" alt="" class="">
                                
                            </div>
                           {{--  <div class="col-12 col-md-12">
                                <a href="https://api.whatsapp.com/send?phone=+529999208020&text=Hola, quiero reducir mi deuda"  class="btn col-12 btn-highlight btn-block">Crédito personal</a>
                                <div class="mt-0 mt-md-3 text-center">
                                    <small class="text-muted text-center">Obtén un crédito con las mejores condiciones</small>
                                </div>
                            </div> --}}
                           {{--  <div class="d-flex col-12 text-center text-md-start">
                             <a href="https://kaaxclub.com/hola"  class="btn col-8 col-md-6  btn-dark btn-block">Quiero reducir mi deuda</a>
                             
                             <a href="https://kaaxclub.com/hola"  class="btn col-8 col-md-6  btn-dark btn-block ml-2">Quiero un crédito nuevo</a>
                            </div> --}}
                        </div>
                        <div class="row justify-content-center mt-4">
                            <div class="col-12 col-md-8 text-center">
                                {{-- <p class="mt-3 h3 text-center text-md-start">
                                    Fácil, rápido y <span class="text-decoration-underline">gratis</span>.
                                    <span class="h4">
                                        <i
                                        class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                        title="Nuestro servicio siempre será sin costo para ti. Nadie debe cobrarte por solicitar y/o tramitar un crédito.">
                                    </i>
                                    </span>
                                </p> --}}
                            </div>
                        </div>
                    </div><!-- hero-content -->
                </div><!-- col-lg-6 -->
            </div><!-- end row -->
        </div><!-- .container-->
    </div><!-- end hero-wrap -->
@endsection

@section('content')
    <section class="section-space-b feature-section">
        <div class="container">
            <div class="section-head text-center">
                <h2 class="mb-3 color-primary">Beneficios</h2>
                <p>Trámite fácil y rápido</p>
            </div><!-- end section-head -->
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card  card-bordered  px-2 py-2">
                        <h6 class="text-center mt-3 color-primary">Adelanto de nómina</h6>
                        <hr>
                        <ul class="ul-primary">
                            <li>Acceso a su salario ya trabajado</li>
                            <li>Paga de imprevistos</li>
                            <li>No es un crédito</li>
                            <li>No genera intereses</li>
                            <li>Costo fijo y transparente</li>
                        </ul>
                        
                    </div>
                   
                </div>
                <div class="col-12 col-md-4">
                    <div class="card  card-bordered  px-2 py-2">
                        <h6 class="text-center mt-3 color-primary">Reduce tu deuda actual</h6>
                        <hr>
                        <ul class="ul-primary">
                            <li>Menos pagos mensuales</li>
                            <li>Menos interés</li>
                            <li>Mayor capacidad de ahorro</li>
                            <li>Menos estrés</li>
                        </ul>
                        <br>
                    </div>
                </div>
                
                <div class="col-12 col-md-4">
                    <div class="card  card-bordered  px-2 py-2">
                        <h6 class="text-center mt-3 color-primary">Crédito personal</h6>
                        <hr>
                        <ul class="ul-primary">
                            <li>Mejor tasa de interés</li>
                            <li>Mayor capacidad de crédito</li>
                            <li>Mayor tranquilidad</li>
                            <li>Ahorro a largo plazo</li>
                        </ul>
                        <br>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <section class="section-space-b feature-section">
        <div class="container">
            <div class="section-head text-center">
                <h2 class="mb-3 color-primary">Cómo funciona</h2>
                <p>Asesoría y atención personal
                </p>
            </div><!-- end section-head -->
         <div class="row">
            <div class="col-12 col-md-6 text-center">
                <img src="{{ asset('images/01_mano.png') }}" id="img-cell" alt="">
              </div>
              <div class="col-12 col-md-6 d-flex flex-column">
                <h5 class="mt-4"> <span class="span-h5 color-primary"> 1. </span> Comunícate con nosotros</h5>
                <h5 class="mt-4"> <span class="span-h5 color-primary"> 2. </span> Elige el servicio que más te convenga</h5>
                <h5 class="mt-4"> <span class="span-h5 color-primary"> 3. </span> Recibe el dinero en tu cuenta</h5>
                <h5 class="mt-4"> <span class="span-h5 color-primary"> 4. </span> Paga automáticamente desde tu nómina</h5>
              </div>
         </div>
           

        </div><!-- end container -->
    </section><!-- end feature-section-->

   {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5">
            <a href="https://api.whatsapp.com/send?phone=+529999208020&text=Hola quiero reducir mi deuda"  class="btn col-12 btn-highlight btn-block">Quiero reducir mi deuda</a>
            <div class="mt-3 text-center">
                <small class="text-muted">Te ayudamos a cambiarte a una mejor opción</small>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <a href="https://api.whatsapp.com/send?phone=+529999208020&text=Hola quiero un crédito nuevo"  class="btn col-12 btn-dark btn-block">Quiero un crédito nuevo</a>
            <div class="mt-3 text-center">
                <small class="text-muted">¿No tienes un crédito? Te ayudamos a encontrar el mejor</small>
            </div>
        </div>
       </div>
   </div> --}}
    

    <section class="section-space how-it-work-section">
        <div class="container">
            <div class="section-head text-center">
               {{--  <h2 class="mb-3">Ahorra hasta un X %
                </h2> --}}
                
            </div><!-- end section-head -->
            <div class="row g-gs justify-content-center">
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3">
                            {{-- <span
                                class="icon ni ni-wallet icon-md icon-circle icon-wbg me-3 text-blue bg-blue-100"></span> --}}
                            <img class="iconimg" src="/images/01_menor_tasa.png" alt="">

                            <h5>Menor tasa de interés</h5>
                        </div>
                      
                    </div>
                </div><!-- end col -->
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3">
                            <img class="iconimg" src="/images/02_mejores_opciones.png" alt="">
                            <h5>Mejores opciones</h5>
                        </div>
                       {{--  <p class="card-text-s1">Click <a href="profile.html" class="btn-link">My Collections</a> and set up
                            your collection. Add social links, a description of item.</p> --}}
                    </div>
                </div><!-- end col -->
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3">
                            <img class="iconimg" src="/images/03_poder_de_negociacion.png" alt="">
                            <h5>Poder de negociación</h5>
                        </div>
                    
                    </div>
                </div><!-- end col -->
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3">
                            <img class="iconimg" src="/images/04_expande_límites.png" alt="">
                            <h5>Expande tus limites</h5>
                        </div>
                       
                    </div>
                </div><!-- end col -->
                <div class="col-12 text-center">
                    <p>KaaxClub es un servicio exclusivo para las empresas afiliadas.</p>
                </div>
            </div>
        </div><!-- end container -->
    </section><!-- end how-it-work-section -->
@endsection
