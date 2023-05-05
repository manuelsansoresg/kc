@extends('layouts.default')
@section('hero')
<div class="hero-wrap sub-header">
    <div class="container">
        <div class="hero-content text-center py-0">
            <h1 class="hero-title">How can we help?</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-s1 justify-content-center mt-3 mb-0">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact</li>
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
                            <h1 class="cta-title mb-3">Interested in joining us?</h1>
                            <p class="cta-text mb-4">Hop aboard and view our open positions</p>
                            <a href="contact.html" class="btn btn-lg btn-dark">See open roles</a>
                        </div><!-- end cta-box -->
                    </div><!-- .container -->
                </section><!-- end cta-section -->
            </div><!-- end col-lg-7 -->
            <div class="col-lg-5">
                <div class="contact-info ps-lg-4 ps-xl-5">
                    <div class="section-head-sm">
                        <h2 class="mb-2">Find Us There</h2>
                        <p>Collaboratively administrate channels whereas virtual. Objectively seize scalable metrics whereas proactive e-services.</p>
                    </div>
                    <ul class="contact-details">
                        <li class="d-flex align-items-center mb-3">
                            <em class="ni ni-mobile icon-btn icon-btn-s1"></em>
                            <div class="ms-4">
                                <strong class="d-block text-black">Phone:</strong>
                                <span>(123) 123-456 </span>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <em class="ni ni-globe icon-btn icon-btn-s1"></em>
                            <div class="ms-4">
                                <strong class="d-block text-black">Web:</strong>
                                <a href="https://softnio.com/" target="_blank">www.softnio.com</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <em class="ni ni-mail icon-btn icon-btn-s1"></em>
                            <div class="ms-4">
                                <strong class="d-block text-black">Email:</strong>
                                <a href="#">office@softnio.com</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end contact-section -->
@endsection
