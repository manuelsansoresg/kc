@extends('layouts.default')
@section('hero')
<div class="hero-wrap sub-header">
    <div class="container">
        <div class="hero-content text-center py-0">
            <h1 class="hero-title">¿Cómo podemos ayudar?</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-s1 justify-content-center mt-3 mb-0">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="/contacto">Contacto</a>
                    </li>
                </ol>
            </nav>
        </div><!-- hero-content -->
    </div><!-- .container-->
</div><!-- end hero-wrap -->
@endsection
@section('content')
<section class="contact-section section-space-b">
    <div class="container">
        <div class="row section-space-b">
            <div class="col-lg-7">
                <section class="cta-section section-space-b bg-pattern mt-5">
                    <div class="container">
                        <div class="cta-box text-center">
                            <h1 class="cta-title color-purple mb-3">Contáctanos y con gusto te ayudaremos</h1>
                            <p class="cta-text mb-4">Haz aclaraciones, preguntas, sugerencias o quejas</p>
                            <a href="https://yalku.atlassian.net/servicedesk/customer/portal/3" target="_blank" class="btn btn-lg btn-dark">Solicitar ayuda</a>
                        </div><!-- end cta-box -->
                    </div><!-- .container -->
                </section><!-- end cta-section -->
            </div><!-- end col-lg-7 -->
            <div class="col-lg-5">
                <div class="contact-info ps-lg-4 ps-xl-5">
                    <div class="section-head-sm">
                        <h2 class="mb-2">Encuéntranos aquí</h2>
                        <p>También puedes contactarnos en.</p>
                    </div>
                    <ul class="contact-details">
                        <li class="d-flex align-items-center mb-3">
                            <em class="ni ni-whatsapp icon-btn icon-btn-s1"></em>
                            {{-- <i class="fa-brands fa-whatsapp"></i> --}}
                            <div class="ms-4">
                                <strong class="d-block text-black">
                                    
                                    WhatsApp:
                                </strong>
                                <span><a class="text-decoration-none" target="_blank" href="https://api.whatsapp.com/send?phone=+529999208020&text=Hola, necesito ayuda">9999 20 80 20</a></span>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <em class="icon ni ni-facebook-circle icon-btn icon-btn-s1"></em>
                            <div class="ms-4">
                                <strong class="d-block text-black">Facebook:</strong>
                                <a href="https://www.facebook.com/kaaxclub" target="_blank">facebook.com/kaaxclub</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <em class="ni ni-mail icon-btn icon-btn-s1"></em>
                            <div class="ms-4">
                                <strong class="d-block text-black">Email:</strong>
                                <a href="mailto:kaaxclub@gmail.com">kaaxclub@gmail.com</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end contact-section -->
@endsection
