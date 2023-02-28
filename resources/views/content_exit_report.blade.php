@extends('layouts.report')
@section('title', 'Reporte')

@section('header')
@include('layouts.content_report_nav2')
@endsection

@section('content')


{{-- hero --}}
<section class="position-relative">
    <div class="container py-9 py-lg-11 position-relative z-index-1">
        <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50">
        </div>
        <div class="row justify-content-between align-items-start">
            <div class="col-12">

                <section class="position-relative">
                    <div class="bg-dark w-100 h-50 bottom-0 start-0 position-absolute"></div>
                    <div class="container position-relative">
                        <div class="px-4 py-7 py-lg-9 rounded-4 position-relative z-index-1 overflow-hidden text-white bg-secondary">
                            <div class="row position-relative">
                                <div class="col-lg-9 col-md-10 mx-auto text-center">
                                    <h2 class="mb-4 aos-init aos-animate display-2" data-aos="fade-up"> ¡Genial! </h2>
                                    <h2 class="display-7 mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100"> Un asesor de nuestro equipo te contactará en unos minutos para iniciar el trámite de tu crédito.
                                    </h2>
                                    
                                    <h2 class="h3 mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100"> Puedes darle seguimiento al trámite desde la App. 
                                    </h2>

                                    <div class="d-flex flex-wrap justify-content-center">
                                        <div data-aos="fade-up" data-aos-delay="150" class="aos-init aos-animate">
                                            <a class="btn btn-primary btn-lg hover-lift me-3" href="https://app.kaaxclub.com/" style="text-transform: inherit">Ir a la App <span class="material-symbols-rounded fs-5 ms-2 align-middle lh-1">arrow_forward</span>
                                            <a class="btn btn-primary btn-lg hover-lift me-3" href="#!">Contactar asesor <span class="material-symbols-rounded fs-5 ms-2 align-middle lh-1">arrow_forward</span>
                                            <a class="btn btn-primary btn-lg hover-lift me-3" href="#!">Ayuda <span class="material-symbols-rounded fs-5 ms-2 align-middle lh-1">arrow_forward</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
{{-- hero --}}

    

  
@endsection
