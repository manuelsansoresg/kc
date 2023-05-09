@extends('layouts.default')
@section('hero')
<div class="hero-wrap sub-header">
    <div class="container">
        <div class="hero-content text-center py-0">
            <h1 class="hero-title">Queremos saber de tí</h1>
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
            <div class="col-lg-7 ">
                <div class="contact-form-wrap mb-5 mb-lg-0 align-items-center">
                    <div class="section-head-sm">
                        <h2 class="mb-2">Contáctanos</h2>
                        <p>¿Alguna pregunta? ¿Necesitas ayuda? No dudes en enviarnos un mensaje</p>
                    </div>
                    <form action="#" id="frm-contact">
                        <div class="row g-gs">
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputName" required>
                                    <label for="floatingInputName">Tu nombre</label>
                                </div><!-- end form-floating -->
                            </div><!-- end col -->
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="floatingInputEmail" required>
                                    <label for="floatingInputEmail">Email</label>
                                </div><!-- end form-floating -->
                            </div><!-- end col -->
                            <div class="col-lg-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputPhoneNumber" required>
                                    <label for="floatingInputPhoneNumber">Celular</label>
                                </div><!-- end form-floating -->
                            </div><!-- end col -->
                            <div class="col-lg-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" ></textarea>
                                    <label for="floatingTextarea">Escribe tu mensaje aquí...</label>
                                </div><!-- end form-floating -->
                            </div><!-- end col -->
                            <div class="col-lg-12">
                                <button class="btn btn-dark" type="submit">Enviar mensaje</button>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </form>
                </div><!-- end card -->
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
                                <span><a class="text-decoration-none" target="_blank" href="https://api.whatsapp.com/send?phone=+529999208020&text=hola">9999 20 80 20</a></span>
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
