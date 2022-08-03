<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="Sortnio">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">
    <meta name="description" content="EnftyMart - NFT Marketplace html Template">
    <meta name="keywords" content="nft, crypto, html5 template">
    <title> @yield('title') </title>
    <!-- Favicon -->
    <link rel="icon" sizes="16x16" href="/images/favicon.png">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/vendor.bundle.css?ver=100">
    <link rel="stylesheet" href="/assets/css/style.css?ver=100">
</head>

<body>
    <div class="page-wrap">
        <header class="header-section has-header-main">
            <div class="header-main is-sticky">
                <div class="container">
                    <div class="header-wrap">
                        <div class="header-logo">
                            <a href="index.html" class="logo-link">
                                <img class="logo-dark logo-img" src="images/logo-black.png" alt="logo">
                                <img class="logo-light logo-img" src="images/logo-white.png" alt="logo">
                            </a>
                        </div><!-- .header-logo -->
                        <div class="header-mobile-action">
                            <div class="header-search-mobile dropdown me-2">
                                <a class="icon-btn" href="#" data-bs-toggle="dropdown">
                                    <em class="ni ni-search"></em>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end card-generic">
                                    <div class="input-group">
                                        <input type="search" class="form-control form-control-s1" placeholder="Search item here...">
                                        <a href="#" class="btn btn-sm btn-outline-secondary"><em class="ni ni-search"></em></a>
                                    </div>
                                </div>
                            </div><!-- end header-search-mobile -->
                            <div class="header-mobile-user-menu dropdown me-2">
                                <button type="button" class="icon-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                    <em class="ni ni-user"></em>
                                </button>
                                <ul class="dropdown-menu card-generic card-generic-s3 dropdown-menu-end mt-2">
                                    <li>
                                        <h6 class="dropdown-header">Hello kamran!</h6>
                                    </li>
                                    <li><a class="dropdown-item card-generic-item" href="profile.html"><em class="ni ni-user me-2"></em> Profile</a></li>
                                    <li><a class="dropdown-item card-generic-item" href="offers.html"><em class="ni ni-dashboard me-2"></em> Dashboard</a></li>
                                    <li><a class="dropdown-item card-generic-item" href="account.html"><em class="ni ni-setting me-2"></em> Account Settings</a></li>
                                    <li><a class="dropdown-item card-generic-item" href="contact.html"><em class="ni ni-question-alt me-2"></em> Help center</a></li>
                                    <li><a href="#" class="dropdown-item card-generic-item theme-toggler" title="Toggle Dark/Light mode"><em class="ni ni-moon me-2"></em> Dark Mode</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item card-generic-item" href="index.html"><em class="ni ni-power me-2"></em> Logout</a></li>
                                </ul>
                            </div><!-- end header-mobile-user-menu -->
                            <div class="header-toggle">
                                <button class="menu-toggler">
                                    <em class="menu-on menu-icon ni ni-menu"></em>
                                    <em class="menu-off menu-icon ni ni-cross"></em>
                                </button>
                            </div><!-- .header-toggle -->
                        </div><!-- end header-mobile-action -->
                        <div class="header-search-form header-search-form-s2">
                            <input type="search" class="form-control form-control-s1" placeholder="Search item here...">
                        </div>
                        <nav class="header-menu menu nav">
                            <ul class="menu-list ms-lg-auto">
                                <li class="menu-item has-sub">
                                    <a href="#" class="menu-link menu-toggle">Home</a>
                                    <div class="menu-sub">
                                        <ul class="menu-list">
                                            <li class="menu-item"><a href="index.html" class="menu-link">Home Page 1</a></li>
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
                            <ul class="menu-btns menu-btns-2">
                                <li class="d-none d-lg-inline-block"><a href="wallet.html" class="icon-btn icon-btn-s1" title="Wallet"><em class="ni ni-wallet"></em></a></li>
                                <li class="d-none d-lg-inline-block dropdown">
                                    <button type="button" class="icon-btn icon-btn-s1" data-bs-toggle="dropdown"><em class="ni ni-user"></em></button>
                                    <ul class="dropdown-menu card-generic card-generic-s3 dropdown-menu-end mt-2">
                                        <li>
                                            <h6 class="dropdown-header">Hello kamran!</h6>
                                        </li>
                                        <li><a class="dropdown-item card-generic-item" href="profile.html"><em class="ni ni-user me-2"></em> Profile</a></li>
                                        <li><a class="dropdown-item card-generic-item" href="offers.html"><em class="ni ni-dashboard me-2"></em> Dashboard</a></li>
                                        <li><a class="dropdown-item card-generic-item" href="account.html"><em class="ni ni-setting me-2"></em> Account Settings</a></li>
                                        <li><a class="dropdown-item card-generic-item" href="contact.html"><em class="ni ni-question-alt me-2"></em> Help center</a></li>
                                        <li><a href="#" class="dropdown-item card-generic-item theme-toggler" title="Toggle Dark/Light mode"><em class="ni ni-moon me-2"></em> Dark Mode</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item card-generic-item" href="index.html"><em class="ni ni-power me-2"></em> Logout</a></li>
                                    </ul>
                                </li>
                                <li class="d-lg-none"><a href="wallet.html" class="btn btn-lg btn-dark">Connect Wallet</a></li>
                            </ul>
                        </nav><!-- .header-menu -->
                        <div class="header-overlay"></div>
                    </div><!-- .header-warp-->
                </div><!-- .container-->
            </div><!-- .header-main-->
            <div class="hero-wrap sub-header" style="background-image: url('images/thumb/bread-bg-2.jpg')">
                <div class="overlay"></div>
                <div class="container">
                    <div class="hero-content py-0 d-flex align-items-center">
                       {{--  <div class="avatar avatar-3 flex-shrink-0">
                            <img src="images/thumb/avatar.jpg" alt="avatar">
                        </div><!-- end avatar --> --}}
                        <div class="author-hero-content-wrap d-flex flex-wrap justify-content-between ms-3 flex-grow-1">
                            <div class="author-hero-content me-3">
                                <h4 class="hero-author-title mb-1 text-white"> {{ $lead->name }} {{ $lead->last_name }} {{ $lead->second_last_name }} </h4>
                                <p class="hero-author-username mb-1 text-white">{{ $lead->email }}</p>
                                {{-- <div class="d-flex align-items-center">
                                    <input type="text" class="copy-input text-white" value="0x76669f...a0e9ca" id="copy-input" readonly>
                                    <div class="tooltip-s1">
                                        <button data-clipboard-target="#copy-input" class="copy-text text-white ms-2" type="button">
                                            <span class="tooltip-s1-text tooltip-text">Copy</span>
                                            <em class="ni ni-copy"></em>
                                        </button>
                                    </div>
                                </div> --}}
                            </div><!-- end author-hero-content -->
                           {{--  <div class="hero-action-wrap d-flex align-items-center my-2">
                                <a href="account.html" class="btn btn-light">Edit Profile</a>
                            </div> --}}
                        </div><!-- end author-hero-content-wrap -->
                    </div><!-- hero-content -->
                </div><!-- .container-->
            </div><!-- end hero-wrap -->
        </header><!-- end header-section -->
        @yield('content')
        <footer class="footer-section bg-dark on-dark">
            <div class="container">
                <div class="section-space-sm">
                    <div class="row">
                        <div class="col-lg-3 col-md-9 me-auto">
                            <div class="footer-item mb-5 mb-lg-0">
                                <a href="index.html" class="footer-logo-link logo-link">
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
    </div><!-- end page-wrap -->
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="images/thumb/exclamation-circle-solid.svg" alt="" class="mb-3">
                    <h4 class="modal-tilte mb-2">Your item will be deleted permanently!</h4>
                    <p class="modal-text">Are you sure you want to delete your item?</p>
                </div><!-- end modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Ok Delete</button>
                </div>
            </div><!-- end modal-content -->
        </div><!-- end modal-dialog -->
    </div><!-- end modal-->
    <!-- Modal -->
    <div class="modal fade" id="followersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <ul class="nav nav-tabs nav-tabs-s1 nav-tabs--s1" id="myTabTwo" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="following-tab" data-bs-toggle="tab" data-bs-target="#following" type="button" role="tab" aria-controls="following" aria-selected="false"> Following </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab" aria-controls="followers" aria-selected="true"> Followers </button>
                        </li>
                    </ul>
                    <button type="button" class="btn-close icon-btn" data-bs-dismiss="modal" aria-label="Close">
                        <em class="ni ni-cross"></em>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="myTabContentTwo">
                        <div class="tab-pane fade" id="following" role="tabpanel" aria-labelledby="following-tab">
                            <div class="item-detail-tab-wrap">
                                <div class="card-follow d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="avatar flex-shrink-0 me-2">
                                            <img src="images/thumb/avatar-2.jpg" alt="avatar">
                                        </a>
                                        <div class="flex-grow-1">
                                            <p class="fw-semibold fs-14 lh"><a href="#" class="text-black">Alex Smith</a></p>
                                            <span class="d-block fw-medium fs-15">@alex_smith</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light btn-show">Follow</button>
                                    <button type="button" class="btn btn-sm btn-light btn-hide"><em class="ni ni-user-add"></em></button>
                                </div><!-- end card-follow -->
                                <div class="card-follow d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="avatar flex-shrink-0 me-2">
                                            <img src="images/thumb/avatar-5.jpg" alt="avatar">
                                        </a>
                                        <div class="flex-grow-1">
                                            <p class="fw-semibold fs-14 lh"><a href="#" class="text-black">Digital Monkey</a></p>
                                            <span class="d-block fw-medium fs-15">@digital_monkey</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light btn-show">Follow</button>
                                    <button type="button" class="btn btn-sm btn-light btn-hide"><em class="ni ni-user-add"></em></button>
                                </div><!-- end card-follow -->
                                <div class="card-follow d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="avatar flex-shrink-0 me-2">
                                            <img src="images/thumb/avatar-4.jpg" alt="avatar">
                                        </a>
                                        <div class="flex-grow-1">
                                            <p class="fw-semibold fs-14 lh"><a href="#" class="text-black">Beejaey</a></p>
                                            <span class="d-block fw-medium fs-15">@Beejaey</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light btn-show">Follow</button>
                                    <button type="button" class="btn btn-sm btn-light btn-hide"><em class="ni ni-user-add"></em></button>
                                </div><!-- end card-follow -->
                                <div class="card-follow d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="avatar flex-shrink-0 me-2">
                                            <img src="images/thumb/avatar-3.jpg" alt="avatar">
                                        </a>
                                        <div class="flex-grow-1">
                                            <p class="fw-semibold fs-14 lh"><a href="#" class="text-black">Tom Dracula</a></p>
                                            <span class="d-block fw-medium fs-15">@tom_dracula</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light btn-show">Follow</button>
                                    <button type="button" class="btn btn-sm btn-light btn-hide"><em class="ni ni-user-add"></em></button>
                                </div><!-- end card-follow -->
                                <div class="card-follow d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="avatar flex-shrink-0 me-2">
                                            <img src="images/thumb/avatar.jpg" alt="avatar">
                                        </a>
                                        <div class="flex-grow-1">
                                            <p class="fw-semibold fs-14 lh"><a href="#" class="text-black">Kevin Martin</a></p>
                                            <span class="d-block fw-medium fs-15">@kevin_martin</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light btn-show">Follow</button>
                                    <button type="button" class="btn btn-sm btn-light btn-hide"><em class="ni ni-user-add"></em></button>
                                </div><!-- end card-follow -->
                            </div><!-- end item-detail-tab-wrap -->
                        </div><!-- end tab-pane -->
                        <div class="tab-pane fade show active" id="followers" role="tabpanel" aria-labelledby="followers-tab">
                            <div class="item-detail-tab-wrap">
                                <div class="card-follow d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="avatar flex-shrink-0 me-2">
                                            <img src="images/thumb/avatar.jpg" alt="avatar">
                                        </a>
                                        <div class="flex-grow-1">
                                            <p class="fw-semibold fs-14 lh"><a href="#" class="text-black">Digital Monkey</a></p>
                                            <span class="d-block fw-medium fs-15">@digital_monkey</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light btn-show">Follow</button>
                                    <button type="button" class="btn btn-sm btn-light btn-hide"><em class="ni ni-user-add"></em></button>
                                </div><!-- end card-follow -->
                                <div class="card-follow d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="avatar flex-shrink-0 me-2">
                                            <img src="images/thumb/avatar-2.jpg" alt="avatar">
                                        </a>
                                        <div class="flex-grow-1">
                                            <p class="fw-semibold fs-14 lh"><a href="#" class="text-black">Beejaey</a></p>
                                            <span class="d-block fw-medium fs-15">@Beejaey</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light btn-show">Follow</button>
                                    <button type="button" class="btn btn-sm btn-light btn-hide"><em class="ni ni-user-add"></em></button>
                                </div><!-- end card-follow -->
                                <div class="card-follow d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="avatar flex-shrink-0 me-2">
                                            <img src="images/thumb/avatar-3.jpg" alt="avatar">
                                        </a>
                                        <div class="flex-grow-1">
                                            <p class="fw-semibold fs-14 lh"><a href="#" class="text-black">Tom Dracula</a></p>
                                            <span class="d-block fw-medium fs-15">@tom_dracula</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light btn-show">Follow</button>
                                    <button type="button" class="btn btn-sm btn-light btn-hide"><em class="ni ni-user-add"></em></button>
                                </div><!-- end card-follow -->
                                <div class="card-follow d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="avatar flex-shrink-0 me-2">
                                            <img src="images/thumb/avatar-4.jpg" alt="avatar">
                                        </a>
                                        <div class="flex-grow-1">
                                            <p class="fw-semibold fs-14 lh"><a href="#" class="text-black">Alex Smith</a></p>
                                            <span class="d-block fw-medium fs-15">@alex_smith</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light btn-show">Follow</button>
                                    <button type="button" class="btn btn-sm btn-light btn-hide"><em class="ni ni-user-add"></em></button>
                                </div><!-- end card-follow -->
                                <div class="card-follow d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="avatar flex-shrink-0 me-2">
                                            <img src="images/thumb/avatar-5.jpg" alt="avatar">
                                        </a>
                                        <div class="flex-grow-1">
                                            <p class="fw-semibold fs-14 lh"><a href="#" class="text-black">Kevin Martin</a></p>
                                            <span class="d-block fw-medium fs-15">@kevin_martin</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light btn-show">Follow</button>
                                    <button type="button" class="btn btn-sm btn-light btn-hide"><em class="ni ni-user-add"></em></button>
                                </div><!-- end card-follow -->
                            </div><!-- end item-detail-tab-wrap -->
                        </div><!-- end tab-pane -->
                    </div>
                </div><!-- end modal-body -->
            </div><!-- end modal-content -->
        </div><!-- end modal-dialog -->
    </div><!-- end modal-->
    <!-- Scripts -->
    <script src="assets/js/bundle.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>