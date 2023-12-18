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
    $is_email_update = isset($_GET['is_email_update']) ? true : false;
    $type = isset($_GET['type']) ? true : false;

    $text1          = 'Debido a las características de este tipo de crédito, no podemos ayudarte con el trámite, pero podemos apoyarte a resolver las dudas que tengas.';
    if ($is_email_update == false && $client->email != '' || ($is_email_update == true && $client->email != '') ) {
        $text1_email    = 'Te hemos enviado un email con toda la información que vez aquí.';
    }
    
    $status_correo = true;
    if ($client->email == '' && $is_email_update == false) {
        $text1_email = 'Por favor, proporciona tu dirección de correo electrónico a continuación para que podamos enviarte todos los detalles importantes. Una vez que lo hayas hecho, te enviaremos un correo electrónico con la información que estás buscando.';
    }
    if ($is_email_update ) {
        # code...
    }
    $text2          = 'Un asesor de nuestro equipo te contactará a la brevedad posible para iniciar el trámite de tu crédito.';
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
                                    <h2 class="mb-4 aos-init aos-animate display-2" data-aos="fade-up">
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
                                            @if ($status_email == true)
                                                <p class="h4 fw-bold pb-3">{{ $text1_email }}</p>
                                            @endif
                                            @if ($status_correo == true && $status_email == true && $is_email_update != true)
                                               <div class="row justify-content-center">
                                                    <div class="col-12 col-md-6">
                                                        <form action="" id="frm-report-email">
                                                            <div class="mb-3">
                                                                <input type="email" class="form-control" name="data[email]" placeholder="">
                                                            </div>
                                                            <div class="mb-3 ">
                                                                <button class="btn btn-primary">Enviar</button>
                                                            </div>
                                                            <input type="hidden" name="credit_id" id="credit_id" value="{{ $credit->id }}">
                                                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                                            <input type="hidden" id="is_app" value="{{ $is_app }}">
                                                            <input type="hidden" id="is_email_update" value="{{ $is_email_update }}">
                                                        </form>
                                                    </div>
                                               </div>
                                            @endif
                                            {{ $text1 }}
                                            
                                        </h2>

                                        @else
                                        <h6 class="mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                                            @if ($status_email == true)
                                            <p class="h4 fw-bold pb-3">{{ $text1_email }}</p>
                                            @endif
                                            @if ($status_correo == true && $status_email == true && $is_email_update != true)
                                               <div class="row justify-content-center">
                                                    <div class="col-12 col-md-6">
                                                        <form action="" id="frm-report-email">
                                                            <div class="mb-3">
                                                                <input type="email" class="form-control" name="data[email]" placeholder="">
                                                            </div>
                                                            <div class="mb-3 ">
                                                                <button class="btn btn-primary">Enviar</button>
                                                            </div>
                                                            <input type="hidden" name="credit_id" id="credit_id" value="{{ $credit->id }}">
                                                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                                            <input type="hidden" id="is_app" value="{{ $is_app }}">
                                                            <input type="hidden" id="is_email_update" value="{{ $is_email_update }}">
                                                        </form>
                                                    </div>
                                               </div>
                                            @endif
                                            {{ $text1 }}
                                            
                                        </h6>
                                       
                                        
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
                                    @if ($status_email != true)
                                        @if ($is_app == false)
                                        <h2 class="h3 mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100"> 
                                            {!! $text3  !!}
                                        </h2>
                                        @else
                                        <h6 class="mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100"> 
                                            {!! $text3  !!}
                                        </h6>
                                        @endif
                                    @endif
                                    
                                    @if ($status_email == true)
                                        <div class="col-12 py-3">
                                            {!! $view_info['caracteristicas'] !!}
                                        </div>
                                    @endif
                                   
                                    @if ($is_app == false)
                                        @if ($dayOK && $timeOK)
                                        <div class="row" data-aos="fade-up" data-aos-delay="150" class="aos-init aos-animate">
                                            <div class="col-6 text-center">
                                                <a target="_blank" href="https://api.whatsapp.com/send?phone=+529999208020&text=Hola" class="btn btn-primary hover-lift me-3 mt-2 btn-block col-12">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        Contacto 
                                                        <img width="18" class="ms-2" src="/images/whatsapp-logo-1-1.png" alt="">
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-6 text-center">
                                                <a href="https://kaaxclub.com/" class="btn btn-primary hover-lift me-3 mt-2 btn-block col-12">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        Salir 
                                                    </div>
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
                            <p class="mt-4 text-center text-sm fst-italic">
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
