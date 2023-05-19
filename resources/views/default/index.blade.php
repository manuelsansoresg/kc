@extends('layouts.default')

@section('hero')
    <div class="hero-wrap hero-wrap-2 section-space">
        <div class="container">
            <div class="row align-items-center flex-md-row-reverse justify-content-between">
                <div class="col-lg-5 col-sm-9 col-md-6">
                    <div class="hero-image">
                        <img src="images/01_mano.png" alt="" class="w-100">
                        <p class="text-center">Elije en menos de 3 minutos</p>
                    </div>
                </div><!-- end col-lg-5 -->
                <div class="col-lg-6 col-md-6">
                    <div class="hero-content pb-0 pt-md-0 pe-lg-4">
                        <h1 class="hero-title mb-4">Encuentra y tramita tu crédito de nómina ideal.
                        </h1>
                        <p class="hero-text mb-4 pb-1">Elegir entre todas las financieras puede ser confuso y difícil. Pero
                            no tiene que ser así.
                        </p>
                        <!-- button group -->
                       <div class="col-12 col-md-6 text-center text-md-start">
                        <a href="http://kaaxclub.com/"  class="btn col-8 col-md-5 btn-lg btn-dark">Iniciar</a>
                       </div>
                        <p class="mt-5 h3">
                            Fácil, rápido, <span class="text-decoration-underline">sin costo.</span>
                            <span class="h4">
                                <i
                                class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                title="Nuestro servicio siempre será sin costo para ti. Nadie debe cobrarte por solicitar y/0 tramitar un crédito.">
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
                <p>En KaaxClub, no estamos afiliados a ninguna institución financiera. Nos enfocamos en ti y te ofrecemos
                    opciones transparentes y honestas para que puedas tomar decisiones con confianza.
                </p>
            </div><!-- end section-head -->
            
            <div class="row g-gs justify-content-center">
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3"><span
                                class="icon ni ni-wallet icon-md icon-circle icon-wbg me-3 text-blue bg-blue-100"></span>
                            <h5>Set up your wallet</h5>
                        </div>
                        <p class="card-text-s1">Once you’ve set up your wallet of choice, connect it to EnftyMart by
                            clicking the wallet icon.</p>
                    </div>
                </div><!-- end col -->
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3"><span
                                class="icon ni ni-file-text icon-md icon-circle icon-wbg me-3 text-purple bg-purple-100"></span>
                            <h5>Create collection</h5>
                        </div>
                        <p class="card-text-s1">Click <a href="profile.html" class="btn-link">My Collections</a> and set up
                            your collection. Add social links, a description of item.</p>
                    </div>
                </div><!-- end col -->
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3"><span
                                class="icon ni ni-camera icon-md icon-circle icon-wbg me-3 text-pink bg-pink-100"></span>
                            <h5>Add your NFTs</h5>
                        </div>
                        <p class="card-text-s1">Upload your work (image, video, audio, or 3D art), add a title and
                            description to item.</p>
                    </div>
                </div><!-- end col -->
                <div class="col-10 col-sm-6 col-lg-3">
                    <div class="card-hiw card-hiw-s3">
                        <div class="d-flex align-items-center mb-3"><span
                                class="icon ni ni-money icon-md icon-circle icon-wbg me-3 text-orange bg-orange-100"></span>
                            <h5>List them for sale</h5>
                        </div>
                        <p class="card-text-s1">Choose between auctions, fixed-price listings, and declining-price listings
                            of item.</p>
                    </div>
                </div><!-- end col -->
            </div>

        </div><!-- end container -->
    </section><!-- end feature-section-->

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
