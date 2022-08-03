@extends('layouts.infokc')
@section('title', 'Contraseña')

@section('content')
<section class="author-section section-space">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 d-none">
                <div class="sidebar mb-5 mb-xl-0 row">
                    <div class="col-md-6 col-lg-6 col-xl-12 sidebar-widget">
                        <h3 class="mb-3">About Me</h3>
                        <p class="sidebar-text mb-3">I make art with the simple goal of giving you something pleasing to look at for a few seconds.</p>
                        <p class="sidebar-text text-dark-gray">
                            <span class="me-4"><strong class="text-black">30</strong> Following</span>
                            <span><strong class="text-black">371</strong> Followers</span>
                        </p>
                        <div class="follow-wrap mt-3">
                            <p class="mb-1 text-black fw-semibold">Followed by</p>
                            <div class="avatar-group mb-3">
                                <a href="author.html" class="avatar-group-avatar"><img src="images/thumb/avatar.jpg" alt=""></a>
                                <a href="author.html" class="avatar-group-avatar"><img src="images/thumb/avatar-2.jpg" alt=""></a>
                                <a href="author.html" class="avatar-group-avatar"><img src="images/thumb/avatar-3.jpg" alt=""></a>
                                <a href="author.html" class="avatar-group-avatar"><img src="images/thumb/avatar-4.jpg" alt=""></a>
                                <a href="author.html" class="avatar-group-avatar"><img src="images/thumb/avatar-5.jpg" alt=""></a>
                            </div>
                            <a href="#" class="btn-link sidebar-btn-link" data-bs-toggle="modal" data-bs-target="#followersModal">View All</a>
                        </div>
                    </div><!-- end col -->
                    <div class="col-md-6 col-lg-6 col-xl-12 sidebar-widget">
                        <h3 class="mb-3">Links</h3>
                        <ul class="social-links">
                            <li><a href="#"><span class="ni ni-globe icon"></span>kamran.bd.com</a></li>
                            <li><a href="#"><span class="ni ni-facebook-f icon"></span>Facebook</a></li>
                            <li><a href="#"><span class="ni ni-twitter icon"></span>Twitter</a></li>
                            <li><a href="#"><span class="ni ni-instagram icon"></span>Instagram</a></li>
                        </ul>
                    </div><!-- end col -->
                    <div class="col-md-6 col-lg-6 col-xl-12 sidebar-widget">
                        <h3 class="mb-2">Joined</h3>
                        <p class="sidebar-text">Septermber 13, 2021</p>
                    </div><!-- end col -->
                </div><!-- end sidebar -->
            </div><!-- end col -->
            <div class="col-xl-6 ps-xl-4 offset-md-3">
                <div class="author-items-wrap">
                    <h3>Introduce tu contraseña</h3>
                    <div class="form-group">
                        <label class="form-label" for="frm-user-admin-name">Contraseña</label>
                        <div class="form-control-wrap">
                            <input type="password" name="razon_social" class="form-control" id="razon_social"
                                value="">
                        </div>
                        <div class="col-12 mt-3">
                            <div class="col-12">
                                <button class="btn btn-primary pull-right">Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="gap-2x"></div><!-- end gap -->
                  
                </div><!-- end author-items-wrap -->
            </div><!-- end col-lg-8 -->
        </div><!-- end row -->
    </div><!-- .container -->
</section><!-- end author-section -->
@endsection