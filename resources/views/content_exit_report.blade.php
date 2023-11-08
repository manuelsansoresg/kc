@extends('layouts.report')
@section('title', 'Reporte')

@section('header')
    @if (!isset($_GET['is_app']))
        @include('layouts.content_report_nav2')
    @endif
    
@endsection

@section('content')

@php
    $lnk_app = isset($_GET['is_app']) ? '?is_app=true' : null;
    $is_app = isset($_GET['is_app']) ? true : false;
    $type = isset($_GET['type']) ? true : false;

    $text1 = 'Debido a las características de este tipo de crédito, no podemos ayudarte con el trámite, pero podemos apoyarte a resolver las dudas que tengas.';
    $text2 = 'Un asesor de nuestro equipo te contactará a la brevedad posible para iniciar el trámite de tu crédito.';
    if ($type == true) {
        $text1 = 'Debido a las características de este tipo de crédito, no podemos ayudarte con el trámite, pero podemos apoyarte a resolver las dudas que tengas.';
        $text2 = 'Debido a las características de este tipo de crédito, no podemos ayudarte con el trámite, pero podemos apoyarte a resolver las dudas que tengas.';
    }
    $text3 = 'Si tienes alguna duda, no dudes en contactarnos. <i class="fas fa-smile-beam text-warning "></i>';
@endphp
{{-- hero --}}
<section class="position-relative">
    <div class="container {{ $is_app == false ? 'py-9 py-lg-11' : 'py-0 py-lg-11' }} position-relative z-index-1">
        <div class="mb-6 mb-lg-9 mx-auto text-center w-lg-50">
        </div>
        <div class="row justify-content-between align-items-start">
            <div class="col-12">

                <section class="position-relative">
                    <div class="bg-dark w-100 h-50 bottom-0 start-0 position-absolute"></div>
                    <div class="container position-relative">
                        <div class="px-4 {{ $is_app == false ? 'py-7 py-lg-9' : 'py-0 py-lg-9' }} rounded-4 position-relative z-index-1 overflow-hidden text-white bg-secondary">
                            <div class="row position-relative">
                                <div class="col-lg-9 col-md-10 mx-auto text-center">
                                    @if ($is_app == false)
                                    <h2 class="mb-4 aos-init aos-animate display-1" data-aos="fade-up">
                                        <img style="width: 40px" src="{{ asset('images/7626666.png') }}" alt="">
                                        @if ($type == 1)
                                        ¡Listo!
                                        @else
                                        ¡Genial!
                                        @endif
                                        
                                        <img style="width: 40px" src="{{ asset('images/7626666left.png') }}" alt="">
                                     </h2>
                                    @else
                                    <h2 class="mb-4 aos-init aos-animate display-1 mt-3" data-aos="fade-up">
                                        <img style="width: 40px" src="{{ asset('images/7626666.png') }}" alt="">
                                        @if ($type == 1)
                                        ¡Listo!
                                        @else
                                        ¡Genial!
                                        @endif
                                        <img style="width: 40px" src="{{ asset('images/7626666left.png') }}" alt="">

                                    </h2>
                                    @endif
                                    
                                    @php
                                        $currentDateTime = date('l H:i');
                                        $dayOK = (date('l') == 'Monday' || date('l') == 'Tuesday' 
                                                || date('l') == 'Wednesday' || date('l') == 'Thursday' 
                                                || date('l') == 'Friday');
                                        $timeOK = (date('H:i', strtotime($currentDateTime)) >= '09:00' 
                                                && date('H:i', strtotime($currentDateTime)) <= '18:00');
                                        
                                    @endphp 
                                    @if ($dayOK && $timeOK)
                                        @if ($is_app == false)
                                        <h2 class="display-7 mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                                            {{ $text1 }}
                                            
                                        </h2>

                                        @else
                                        <h6 class="mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                                            {{ $text1 }}
                                            
                                        </h6>
                                        <div class="row">
                                            <div class="col-12" style="text-align: left">
                                                <h6 class="mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                                                    <br><br>
                                                    {!! $product!= null ?  $product->proceso_tramite : null !!}
                                                </h6>
                                            </div>
                                        </div>
                                        @endif
                                    @else
                                        @if ($is_app == false)
                                        <h2 class="display-7 mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100"> 
                                            {{ $text2 }}
                                        </h2>
                                        @else
                                        <h6 class="mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100"> 
                                            {{ $text2 }}
                                        </h6>
                                        @endif
                                   
                                    @endif
                                    
                                    @if ($is_app == false)
                                    <h2 class="h3 mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100"> 
                                        {!! $text3  !!}
                                    </h2>
                                    @else
                                    <h6 class="mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100"> 
                                        {!! $text3  !!}
                                    </h6>
                                    @endif
                                   
                                    @if ($is_app == false)
                                        @if ($dayOK && $timeOK)
                                        <div class="d-flex flex-wrap justify-content-center">
                                            <div data-aos="fade-up" data-aos-delay="150" class="aos-init aos-animate">
                                                <a target="_blank" href="https://api.whatsapp.com/send?phone=+529999208020&text=Hola" class="btn btn-primary hover-lift me-3 btn-block mt-2 col-12"
                                                >Contacto 
                                                <img width="18" class="mt-n2" src="/images/whatsapp-logo-1-1.png" alt="">
                                            </a>
                                                        <a class="btn btn-primary hover-lift me-3 btn-block mt-2 col-12 " href="https://kaaxclub.com/">Salir 
                                                </a>
                                            </div>
                                        </div>
                                            
                                        @else
                                        <div class="d-flex flex-wrap justify-content-center">
                                            <div data-aos="fade-up" data-aos-delay="150" class="aos-init aos-animate">
                                                <a class="btn btn-primary hover-lift me-3 btn-block mt-2 col-12  iframe-link" href="https://kaaxclub.com" style="text-transform: inherit">OK 
                                                </a>
                                                <a target="_blank" href="https://api.whatsapp.com/send?phone=+529999208020&text=Hola" class="btn btn-primary hover-lift me-3 btn-block mt-2 col-12"
                                                    >Contacto 
                                                    <img width="18" class="mt-n2" src="/images/whatsapp-logo-1-1.png" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    @else
                                    <div class="d-flex flex-wrap justify-content-center pb-3">
                                        <div data-aos="fade-up" data-aos-delay="150" class="aos-init aos-animate">
                                            <a class="btn btn-primary hover-lift me-3 btn-block mt-2 col-12  iframe-link" href="https://kaaxclub.com" style="text-transform: inherit">OK 
                                            </a>
                                            <a target="_blank" href="https://api.whatsapp.com/send?phone=+529999208020&text=Hola" class="btn btn-primary hover-lift me-3 btn-block mt-2 col-12"
                                                >Contacto 
                                                <img width="18" class="mt-n2" src="/images/whatsapp-logo-1-1.png" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    @endif

                                    
                                </div>
                            </div>
                            <p class="mt-4 text-center">
                                El otorgamiento del crédito está sujeto a las políticas de la financiera. El monto, el plazo y la tasa de interés pueden variar dependiendo de la capacidad crediticia del solicitante.
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
{{-- hero --}}

    

  
@endsection
