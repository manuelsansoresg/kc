<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="Sortnio">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">
    <meta name="description" content="EnftyMart - NFT Marketplace html Template">
    <meta name="keywords" content="nft, crypto, html5 template">
    <title>Welcome | EnftyMart - NFT Marketplace HTML Template</title>
    <!-- Favicon -->
    <link rel="icon" sizes="16x16" href="images/favicon.ico">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/vendor.bundle.css?ver=100">
    <link rel="stylesheet" href="/assets/css/style.css?ver=100">
    <!-- Hotjar Tracking Code for https://www.kaaxclub.com -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:3046847,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
</head>

<body>
    <div class="page-wrap">
        <header class="header-section has-header-main bg-gradient-2">
            <div class="header-main is-sticky is-transparent">
                <div class="container">
                    <div class="header-wrap">
                        <div class="header-logo">
                            <a href="/" class="logo-link">
                                <img class="logo-dark logo-img" src="{{ asset('images/logo-dark.png ')}}" alt="logo">
                                <img class="logo-light logo-img" src="{{ asset('images/logo-dark.png ')}}" alt="logo">
                            </a>
                        </div><!-- .header-logo -->
                        <div class="header-mobile-action">
                            <div class="header-search-mobile dropdown me-2">
                                <a class="icon-btn" href="#" data-bs-toggle="dropdown">
                                    <em class="ni ni-search"></em>
                                </a>
                            {{--     <div class="dropdown-menu dropdown-menu-end card-generic">
                                    <div class="input-group">
                                        <input type="search" class="form-control form-control-s1" placeholder="Search item here...">
                                        <a href="#" class="btn btn-sm btn-outline-secondary"><em class="ni ni-search"></em></a>
                                    </div>
                                </div> --}}
                            </div><!-- end header-search-mobile -->
                            <div class="header-mobile-wallet me-2">
                                <a class="icon-btn" href="wallet.html">
                                    <em class="ni ni-wallet"></em>
                                </a>
                            </div><!-- end hheader-mobile-wallet -->
                            <div class="header-toggle">
                                <button class="menu-toggler">
                                    <em class="menu-on menu-icon ni ni-menu"></em>
                                    <em class="menu-off menu-icon ni ni-cross"></em>
                                </button>
                            </div><!-- .header-toggle -->
                        </div><!-- end header-mobile-action -->
                       {{--  <div class="header-search-form">
                            <input type="search" class="form-control form-control-s1" placeholder="Search item here...">
                        </div> --}}
                        <nav class="header-menu menu nav">
                            <ul class="menu-list ms-lg-auto">
                                <li class="menu-item">
                                    <a href="/" class="menu-link">Inicio</a>
                                </li>
                                <li class="menu-item">
                                    <a href="/nosotros" class="menu-link">Nosotros</a>
                                </li>
                                <li class="menu-item">
                                    <a href="/contacto" class="menu-link">Contacto</a>
                                </li>
                                <li class="menu-item">
                                    <a href="/ayuda" class="menu-link">Ayuda</a>
                                </li>
                            </ul>
                            <ul class="menu-btns">
                                <li><a href="https://app.kaaxclub.com/" class="btn btn-dark">Ir a la App</a></li>
                                <li>
                                    <a href="#" class="theme-toggler" title="Toggle Dark/Light mode">
                                        <span>
                                            <em class="ni ni-moon icon theme-toggler-show"></em>
                                            <em class="ni ni-sun icon theme-toggler-hide"></em>
                                        </span>
                                        <span class="theme-toggler-text">Dark Mode</span>
                                    </a>
                                </li>
                            </ul>
                        </nav><!-- .header-menu -->
                        <div class="header-overlay"></div>
                    </div><!-- .header-warp-->
                </div><!-- .container-->
            </div><!-- .header-main-->
            @yield('hero')
        </header><!-- end header-section -->
            @yield('content')
            <footer class="footer-section bg-dark on-dark">
                <div class="container">
                    <div class="section-space-sm">
                        <div class="row">
                            <div class="col-lg-3 col-md-9 me-auto">
                                <div class="footer-item mb-5 mb-lg-0">
                                    <a href="/" class="footer-logo-link logo-link">
                                        <img class="logo-dark logo-img" src="images/logo-black.png" alt="logo">
                                        <img class="logo-light logo-img" src="images/logo-white.png" alt="logo">
                                    </a>
                                    <p class="my-4 footer-para">The world's first and largest digital marketplace for crypto collectibles and non-fungible tokens (NFTs).</p>
                                    <ul class="styled-icon">
                                        <li><a href="#"><em class="icon ni ni-twitter"></em></a></li>
                                        <li><a href="#"><em class="icon ni ni-facebook-f"></em></a></li>
                                        <li><a href="#"><em class="icon ni ni-instagram"></em></a></li>
                                        <li><a href="#"><em class="icon ni ni-pinterest"></em></a></li>
                                    </ul>
                                </div><!-- end footer-item -->
                            </div><!-- end col-lg-3 -->
                            <div class="col-lg-8">
                                <div class="row g-gs">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="footer-item">
                                            <h5 class="mb-4">Marketplace</h5>
                                            <ul class="list-item list-item-s1">
                                                <li><a href="explore.html">All NFTs</a></li>
                                                <li><a href="explore.html">Art</a></li>
                                                <li><a href="explore.html">Music</a></li>
                                                <li><a href="explore.html">Domain Names</a></li>
                                                <li><a href="explore.html">Virtual World</a></li>
                                            </ul>
                                        </div><!-- end footer-item -->
                                    </div><!-- end col -->
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="footer-item">
                                            <h5 class="mb-4">My Account</h5>
                                            <ul class="list-item list-item-s1">
                                                <li><a href="profile.html">Profile</a></li>
                                                <li><a href="offers.html">My Offers</a></li>
                                                <li><a href="activity.html">Activity</a></li>
                                                <li><a href="purchases-sales.html">Sales & Purchase</a></li>
                                                <li><a href="payment-methods.html">Payment Methods</a></li>
                                            </ul>
                                        </div><!-- end footer-item -->
                                    </div><!-- end col-lg-3 -->
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="footer-item">
                                            <h5 class="mb-4">Company</h5>
                                            <ul class="list-item list-item-s1">
                                                <li><a href="about-us.html">About</a></li>
                                                <li><a href="news.html">Blog</a></li>
                                                <li><a href="contact.html">Contact</a></li>
                                                <li><a href="about-us.html">Careers</a></li>
                                            </ul>
                                        </div><!-- end footer-item -->
                                    </div><!-- end col-lg-3 -->
                                </div>
                            </div>
                        </div><!-- end row -->
                    </div><!-- end section-space-sm -->
                <hr class="bg-white-slim my-0">
                <div class="copyright-wrap d-flex flex-wrap py-3 align-items-center justify-content-between">
                    <p class="footer-copy-text py-2">Copyright &copy; 2022 EnftyMart. Template Made by <a href="https://themeforest.net/user/softnio/portfolio" target="_blank">Softnio</a></p>
                    <ul class="list-item list-item-s1 list-item-inline">
                        <li><a href="explore.html">Explore</a></li>
                        <li><a href="activity.html">Activity</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="wallet.html">Wallet</a></li>
                    </ul>
                </div><!-- end d-flex -->
            </div><!-- .container -->
        </footer><!-- end footer-section -->
    </div>
    <!-- Scripts -->
    <script src="/assets/js/bundle.js"></script>
    <script src="/assets/js/scripts.js"></script>
</body>

</html>