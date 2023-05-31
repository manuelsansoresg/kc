@extends('layouts.default')

@section('hero')
    <div class="hero-wrap hero-wrap-2 section-space">
        <div class="container">
            <div class="row align-items-center flex-md-row-reverse justify-content-between">
                <div class="col-lg-5 col-12 col-md-6">
                    <div class="row justify-content-center">
                        <div class="hero-image col-8 col-md-12">
                            <img src="images/01_mano.png" alt="" class="">
                            
                        </div>
                        <div class="col-12">
                            <p class="text-center text-elije">Elije en menos de 3 minutos</p>
                        </div>
                    </div>
                </div><!-- end col-lg-5 -->
                <div class="col-lg-6 col-md-6 text-center text-md-start">
                    <div class="hero-content pb-0 pt-md-0 pe-lg-4">
                        <h1 class="hero-title mb-4 color-primary">Compara, elige y tramita tu crédito de nómina ideal.
                        </h1>
                        <p class="hero-text mb-4 pb-1">Elegir entre todas las financieras puede ser confuso y difícil, pero no tiene que ser así.
                        </p>
                        <!-- button group -->
                        <div class="row mt-n2 mt-md-0">
                            <div class="col-12 text-center text-md-start">
                             <a href="https://kaaxclub.com/hola"  class="btn col-8 col-md-6  btn-dark btn-block">Iniciar</a>
                            </div>
                        </div>
                        <p class="mt-3 h3 text-center text-md-start">
                            Fácil, rápido, y <span class="text-decoration-underline">gratis</span>.
                            <span class="h4">
                                <i
                                class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                title="Nuestro servicio siempre será sin costo para ti. Nadie debe cobrarte por solicitar y/o tramitar un crédito.">
                            </i>
                            </span>
                        </p>
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
                <h2 class="mb-3">Imparcialidad y confianza</h2>
                <p>No tenemos afiliación con ninguna institución financiera. Nos enorgullecemos de estar completamente del lado del cliente.
                </p>
            </div><!-- end section-head -->
            
            <div class="row g-gs justify-content-center">
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3">
                            <img class="iconimg" src="/images/02_reporte.png" alt="">
                            <h5>1. Compara tus opciones</h5>
                        </div>
                      
                    </div>
                    <p class="card-text-s1">Analizamos y calificamos cada financiera</p>
                </div><!-- end col -->
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3">
                            <img class="iconimg" src="/images/02_decide.png" alt="">
                            <h5>2. Decide informado</h5>
                        </div>
                       
                    </div>
                    <p class="card-text-s1">Elija la mejor opción para ti</p>
                </div><!-- end col -->
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3">
                            <img class="iconimg" src="/images/03_tramita.png" alt="">
                            <h5>3. Tramita con nuestra ayuda</h5>
                        </div>
                        <p class="card-text-s1">Te brindamos asesoría y asistencia en el proceso</p>
                    </div>
                </div><!-- end col -->
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3">
                            <img class="iconimg" src="/images/04_recibe_dinero.png" alt="">
                            <h5>4. Recibe tú crédito</h5>
                        </div>
                        <p class="card-text-s1">Tu dinero estará listo en poco tiempo</p>
                    </div>
                </div><!-- end col -->
            </div>

        </div><!-- end container -->
    </section><!-- end feature-section-->

   <div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 text-center">
            <a href="https://kaaxclub.com/hola"  class="btn col-8 col-md-5 btn-lg btn-dark">Iniciar</a>
        </div>
       </div>
   </div>
    

    <section class="section-space how-it-work-section">
        <div class="container">
            <div class="section-head text-center">
                <h2 class="mb-3">Ahorra hasta un X %
                </h2>
                <p>This is just a simple text made for this unique and awesome template, you can replace it with any text.
                    It is a long established fact.</p>
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
            </div>
        </div><!-- end container -->
    </section><!-- end how-it-work-section -->
@endsection
