@extends('layouts.default')

@section('content')
<section class="about-section pt-5 mt-3">
    <div class="container">
        <div class="row align-items-center flex-lg-row-reverse">
            <div class="col-lg-6 mb-5 mb-lg-0 col-sm-9 ps-xl-5">
                <img src="images/thumb/nft-img-2.png" alt="" class="img-fluid">
            </div><!-- end col-lg-6 -->
            <div class="col-lg-6 pe-lg-5">
                <div class="section-content-block">
                    <h2 class="mb-4">Acerca de</h2>
                    <p class="mb-3">
                        Nuestro servicio está diseñado para ayudar a las personas que buscan obtener un crédito nuevo o reducir uno existente, a encontrar y tramitar la mejor opción disponible en el mercado. Nosotros te asistiremos en cada paso del proceso para asegurarnos de que obtengas el mejor crédito posible.
                    </p>
                   
                    <h2 class="mb-4">Misión</h2>
                    <p class="mb-3">
                        Nuestra misión es ayudar a las personas a obtener el crédito adecuado mediante una asesoría personalizada y un servicio calificado para encontrar y tramitar la mejor opción disponible en el mercado.
                    </p>
                    
                    <h2 class="mb-4">Visión</h2>
                    <p class="mb-3">
                        Nuestra visión es ser el servicio (opción) que cambie la forma en que las personas buscan y mejoran sus créditos, proporcionando soluciones financieras de última generación y una experiencia personalizada excepcional, a través de nuestra tecnología y equipo altamente capacitado. Nos esforzamos por liderar el mercado y ser los impulsores del cambio en la industria financiera.
                    </p>
                </div>
            </div><!-- end col-lg-6 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end about-section -->
<section class="cta-section section-space-b bg-pattern mt-5">
    <div class="container">
        <div class="cta-box text-center">
            <h1 class="cta-title mb-3">¿Tienes alguna duda?</h1>
            <p class="cta-text mb-4">Ponte en contacto con nosotros</p>
            <a href="/contacto" class="btn btn-lg btn-dark">Contacto</a>
        </div><!-- end cta-box -->
    </div><!-- .container -->
</section><!-- end cta-section -->
@endsection
