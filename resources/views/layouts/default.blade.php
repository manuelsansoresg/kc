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
    <link rel="icon" sizes="16x16" href="images/favicon.png">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/vendor.bundle.css?ver=100">
    <link rel="stylesheet" href="/assets/css/style.css?ver=100">
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
                                <li class="menu-item has-sub">
                                    <a href="#" class="menu-link menu-toggle">Home</a>
                                    <div class="menu-sub">
                                        <ul class="menu-list">
                                            <li class="menu-item"><a href="/" class="menu-link">Home Page 1</a></li>
                                            <li class="menu-item"><a href="index-2.html" class="menu-link">Home Page 2</a></li>
                                            <li class="menu-item"><a href="index-3.html" class="menu-link">Home Page 3</a></li>
                                            <li class="menu-item"><a href="index-4.html" class="menu-link">Home Page 4 <span class="badge text-primary bg-primary-50">New</span></a></li>
                                            <li class="menu-item"><a href="index-5.html" class="menu-link">Home Page 5 <span class="badge text-primary bg-primary-50">New</span></a></li>
                                            <li class="menu-item"><a href="index-6.html" class="menu-link">Home Page 6 <span class="badge text-primary bg-primary-50">New</span></a></li>
                                            <li class="menu-item"><a href="index-7.html" class="menu-link">Home Page 7 <span class="badge text-primary bg-primary-50">New</span></a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="menu-item has-sub">
                                    <a href="#" class="menu-link menu-toggle">Explore</a>
                                    <div class="menu-sub">
                                        <ul class="menu-list">
                                            <li class="menu-item"><a href="explore.html" class="menu-link">Explore</a></li>
                                            <li class="menu-item"><a href="explore-v2.html" class="menu-link">Explore v2 <span class="badge text-primary bg-primary-50">New</span></a></li>
                                            <li class="menu-item"><a href="explore-v3.html" class="menu-link">Explore v3 <span class="badge text-primary bg-primary-50">New</span></a></li>
                                            <li class="menu-item"><a href="explore-v4.html" class="menu-link">Explore v4 <span class="badge text-primary bg-primary-50">New</span></a></li>
                                            <li class="menu-item"><a href="explore-v5.html" class="menu-link">Explore v5 <span class="badge text-primary bg-primary-50">New</span></a></li>
                                            <li class="menu-item"><a href="explore-v6.html" class="menu-link">Explore v6 <span class="badge text-primary bg-primary-50">New</span></a></li>
                                            <li class="menu-item"><a href="product-details-v1.html" class="menu-link">Item Details</a></li>
                                            <li class="menu-item"><a href="product-details-v2.html" class="menu-link">Item Details v2</a></li>
                                            <li class="menu-item"><a href="product-details-v3.html" class="menu-link">Item Details v3 <span class="badge text-primary bg-primary-50">New</span></a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="menu-item has-sub">
                                    <a href="#" class="menu-link menu-toggle">Pages</a>
                                    <div class="menu-sub">
                                        <ul class="menu-list">
                                            <li class="menu-item"><a href="author.html" class="menu-link">Author Public</a></li>
                                            <li class="menu-item"><a href="about-us.html" class="menu-link">About Us</a></li>
                                            <li class="menu-item"><a href="activity.html" class="menu-link">Activity</a></li>
                                            <li class="menu-item"><a href="ranking.html" class="menu-link">Ranking</a></li>
                                            <li class="menu-item"><a href="wallet.html" class="menu-link">Wallet</a></li>
                                            <li class="menu-item"><a href="wallet-v2.html" class="menu-link">Wallet v2</a></li>
                                            <li class="menu-item has-sub">
                                                <a href="#" class="menu-link menu-toggle">Blog</a>
                                                <ul class="menu-sub">
                                                    <li class="menu-item"><a href="news.html" class="menu-link">News</a></li>
                                                    <li class="menu-item"><a href="news-detail.html" class="menu-link">News Detail</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item has-sub">
                                                <a href="#" class="menu-link menu-toggle">User</a>
                                                <ul class="menu-sub">
                                                    <li class="menu-item"><a href="login.html" class="menu-link">Login</a></li>
                                                    <li class="menu-item"><a href="login-v2.html" class="menu-link">Login v2</a></li>
                                                    <li class="menu-item"><a href="register.html" class="menu-link">Register</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item"><a href="contact.html" class="menu-link">Contact</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="menu-item has-sub">
                                    <a href="#" class="menu-link menu-toggle">User Panel</a>
                                    <div class="menu-sub menu-mega">
                                        <div class="menu-mega-row">
                                            <ul class="menu-list menu-list-mega">
                                                <li class="menu-item"><a href="offers.html" class="menu-link">Dashboard <span class="badge bg-primary">Hot</span></a></li>
                                                <li class="menu-item"><a href="activity-2.html" class="menu-link">Activity</a></li>
                                                <li class="menu-item"><a href="purchases-sales.html" class="menu-link">Sales and Purchase</a></li>
                                                <li class="menu-item"><a href="transactions.html" class="menu-link">Transactions</a></li>
                                                <li class="menu-item"><a href="display.html" class="menu-link">Display Enfties</a></li>
                                                <li class="menu-item"><a href="redeem.html" class="menu-link">Redeem Enfties</a></li>
                                                <li class="menu-item"><a href="deposit.html" class="menu-link">Deposit Enfties</a></li>
                                                <li class="menu-item"><a href="profile.html" class="menu-link">Author Personal</a></li>
                                            </ul>
                                            <ul class="menu-list menu-list-mega">
                                                <li class="menu-item"><a href="account.html" class="menu-link">Account Settings</a></li>
                                                <li class="menu-item"><a href="payment-methods.html" class="menu-link">Payment Methods</a></li>
                                                <li class="menu-item"><a href="seller-settings.html" class="menu-link">Seller Settings</a></li>
                                                <li class="menu-item"><a href="notifications.html" class="menu-link">Notifications</a></li>
                                                <li class="menu-item"><a href="security.html" class="menu-link">Security</a></li>
                                                <li class="menu-item"><a href="create.html" class="menu-link">Create</a></li>
                                                <li class="menu-item"><a href="create-single.html" class="menu-link">Create Single</a></li>
                                                <li class="menu-item"><a href="create-multiple.html" class="menu-link">Create Multiple</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul class="menu-btns">
                                <li><a href="https://app.kaaxclub.com/l" class="btn btn-dark">Ir a la App</a></li>
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
            <div class="hero-wrap hero-wrap-2 section-space">
                <div class="container">
                    <div class="row align-items-center flex-md-row-reverse justify-content-between">
                        <div class="col-lg-5 col-sm-9 col-md-6">
                            <div class="hero-image">
                                <img src="images/thumb/nft-img.png" alt="" class="w-100">
                            </div>
                        </div><!-- end col-lg-5 -->
                        <div class="col-lg-6 col-md-6">
                            <div class="hero-content pb-0 pt-md-0 pe-lg-4">
                                <h1 class="hero-title mb-4">Create, sell or collect digital items</h1>
                                <p class="hero-text mb-4 pb-1">Complete account of the system, and expound the actual teachings of the great explorer of human happiness.</p>
                                <!-- button group -->
                                <ul class="btns-group hero-btns">
                                    <li><a href="explore.html" class="btn btn-lg btn-dark">Explore</a></li>
                                    <li><a href="https://sprw.io/stt-d1fdfd" target="_blank" class="btn btn-lg btn-outline-dark">Iniciar</a></li>
                                </ul>
                            </div><!-- hero-content -->
                        </div><!-- col-lg-6 -->
                    </div><!-- end row -->
                </div><!-- .container-->
            </div><!-- end hero-wrap -->
        </header><!-- end header-section -->
        <section class="section-space-b feature-section">
            <div class="container">
                <div class="section-head text-center">
                    <h2 class="mb-3">Exclusive EnftyMart drops</h2>
                    <p>This is just a simple text made for this unique and awesome template, you can replace it with any text. It is a long established fact.</p>
                </div><!-- end section-head -->
                <div class="row g-gs">
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <a href="product-details-v1.html" class="card card-full">
                            <img src="images/thumb/art.jpg" class="card-img-top" alt="">
                            <div class="card-body p-4">
                                <h5 class="card-title card-title-effect">Seasons by AlexSmith</h5>
                                <p class="small">AlexSmith's Summer Collection featuring Time.</p>
                            </div><!-- end card-body -->
                        </a><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <a href="product-details-v1.html" class="card card-full">
                            <img src="images/thumb/art-2.jpg" class="card-img-top" alt="">
                            <div class="card-body p-4">
                                <h5 class="card-title card-title-effect">Kavin Martin EnftyMart.io</h5>
                                <p class="small">After a sold-out Art Blocks drop, Martin is back with.</p>
                            </div><!-- end card-body -->
                        </a><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <a href="product-details-v1.html" class="card card-full">
                            <img src="images/thumb/art-3.jpg" class="card-img-top" alt="">
                            <div class="card-body p-4">
                                <h5 class="card-title card-title-effect">Kavin Martin EnftyMart.io</h5>
                                <p class="small">After a sold-out Art Blocks drop, Martin is back with.</p>
                            </div><!-- end card-body -->
                        </a><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <a href="product-details-v1.html" class="card card-full">
                            <img src="images/thumb/art-4.jpg" class="card-img-top" alt="">
                            <div class="card-body p-4">
                                <h5 class="card-title card-title-effect">Tyronejkd Universe</h5>
                                <p class="small">After a sold-out Art Blocks drop, Martin is back with.</p>
                            </div><!-- end card-body -->
                        </a><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end feature-section-->
     
        <section class="section-space how-it-work-section">
            <div class="container">
                <div class="section-head text-center">
                    <h2 class="mb-3">Create and sell your NFTs</h2>
                    <p>This is just a simple text made for this unique and awesome template, you can replace it with any text. It is a long established fact.</p>
                </div><!-- end section-head -->
                <div class="row g-gs justify-content-center">
                    <div class="col-10 col-sm-6 col-md-6 col-lg-3">
                        <div class="card-htw text-center">
                            <span class="icon ni ni-wallet icon-lg icon-circle shadow-sm icon-wbg mx-auto mb-4 text-primary"></span>
                            <h4 class="mb-3">Set up your wallet</h4>
                            <p class="card-text-s1">Once you’ve set up your wallet of choice, connect it to EnftyMart by clicking the.</p>
                        </div>
                    </div><!-- end col -->
                    <div class="col-10 col-sm-6 col-md-6 col-lg-3">
                        <div class="card-htw text-center">
                            <span class="icon ni ni-setting icon-lg icon-circle shadow-sm icon-wbg mx-auto mb-4 text-danger"></span>
                            <h4 class="mb-3">Create collection</h4>
                            <p class="card-text-s1">Click <a href="profile.html" class="btn-link">My Collections</a> and set up your collection. Add social links, a description.</p>
                        </div>
                    </div><!-- end col -->
                    <div class="col-10 col-sm-6 col-md-6 col-lg-3">
                        <div class="card-htw text-center">
                            <span class="icon ni ni-camera icon-lg icon-circle shadow-sm icon-wbg mx-auto mb-4 text-info"></span>
                            <h4 class="mb-3">Add your NFTs</h4>
                            <p class="card-text-s1">Upload your work (image, video, audio, or 3D art), add a title and description.</p>
                        </div>
                    </div><!-- end col -->
                    <div class="col-10 col-sm-6 col-md-6 col-lg-3">
                        <div class="card-htw text-center">
                            <span class="icon ni ni-money icon-lg icon-circle shadow-sm icon-wbg mx-auto mb-4 text-success"></span>
                            <h4 class="mb-3">List them for sale</h4>
                            <p class="card-text-s1">Choose between auctions, fixed-price listings, and declining-price listings.</p>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end how-it-work-section -->
     
        <section class="subscibe-section section-space-sm">
            <div class="container">
                <div class="join-form-wrap">
                    <div class="row g-gs align-items-center">
                        <div class="col-lg-3">
                            <h3 class="form-title">Join Our Newsletter</h3>
                        </div><!-- end col -->
                        <div class="col-lg-3 col-md-4">
                            <input class="form-control form-control-s1" type="text" name="name" placeholder="Enter name">
                        </div><!-- end col -->
                        <div class="col-lg-3 col-md-4">
                            <input class="form-control form-control-s1" type="text" name="email" placeholder="Enter email">
                        </div><!-- end col -->
                        <div class="col-lg-3 col-md-4">
                            <a href="#" class="btn btn-dark d-md-block">Subscribe Now</a>
                        </div><!-- end col -->
                    </div><!-- row -->
                </div><!-- end join-form-wrap -->
            </div><!-- end container -->
        </section><!-- end subscibe-section -->
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