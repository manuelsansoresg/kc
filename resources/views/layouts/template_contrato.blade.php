@inject('m_user', 'App\Models\User')
@inject('m_history', 'App\Models\HistoryLog')
@inject('m_notification', 'App\Models\Notification')
@inject('Minvestor', 'App\Models\Investor')
@php
    $notifications = $m_notification->getMyNotifications(6)['list'];
@endphp
<!DOCTYPE html>
<html lang="es" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Tú mejor decisión. Fácil y rápido.">
    <!-- Fav Icon  -->
    <link href="{{ asset('images/favicon.ico') }}" rel="icon">
    <!-- Page Title  -->
    <title>KaaxClub</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="/assets_admin/css/dashlite.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="/assets_admin/css/theme.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link
        rel="stylesheet"
        href="https://unpkg.com/tippy.js@6/animations/scale.css"
        />
    
    <link rel="stylesheet" type="text/css" href="/css/app.css" />
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-F7L6QJC7RG"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-F7L6QJC7RG');
</script>
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-header nk-header-fixed is-light">
        <div class="container-fluid">
            <div class="nk-header-wrap">
                <div class="nk-menu-trigger d-xl-none ms-n1">
                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon"
                        data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                </div>
                <div class="nk-header-brand d-xl-none">
                    <a href="html/index.html" class="logo-link">
                        <img class="logo-light logo-img" src="/images/logo-dark.png"
                            srcset="/images/logo-dark.png" alt="logo">
                        <img class="logo-dark logo-img" src="/images/logo-dark.png"
                            srcset="/images/logo-dark.png" alt="logo-dark">
                    </a>
                </div><!-- .nk-header-brand -->

                @if ( Request::segment(2) != 'inversionista' &&  Request::segment(2) != 'kc-wallet' && Request::segment(2) != 'kc-down-wallet' && Request::segment(2) != 'ayuda' )
               
                @endif


                <div class="nk-header-tools">
                    <ul class="nk-quick-nav">
                        <li class="dropdown language-dropdown d-none d-sm-block me-n1">

                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-s1">
                                <ul class="language-list">
                                    <li>
                                        <a href="#" class="language-item">
                                            <img src="/assets_admin/images/flags/english.png"
                                                alt="" class="language-flag">
                                            <span class="language-name">English</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="language-item">
                                            <img src="/assets_admin/images/flags/spanish.png"
                                                alt="" class="language-flag">
                                            <span class="language-name">Español</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="language-item">
                                            <img src="/assets_admin/images/flags/french.png"
                                                alt="" class="language-flag">
                                            <span class="language-name">Français</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="language-item">
                                            <img src="/assets_admin/images/flags/turkey.png"
                                                alt="" class="language-flag">
                                            <span class="language-name">Türkçe</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li><!-- .dropdown -->
                        <li class="dropdown user-dropdown">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <div class="user-toggle">
                                    <div class="user-avatar sm">
                                        <em class="icon ni ni-user-alt"></em>
                                    </div>
                                    <div class="user-info d-none d-md-block">
                                        <div class="user-status"> {{ Auth::user()->getRoleNames()[0] }}
                                        </div>
                                        <div class="user-name dropdown-indicator"> {{ Auth::user()->name }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                                <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                    <div class="user-card">
                                        <div class="user-avatar">
                                            <span>AB</span>
                                        </div>
                                        <div class="user-info">
                                            <span class="lead-text"> {{ Auth::user()->name }}</span>
                                            <span class="sub-text"> {{ Auth::user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li><a href="/panel/user-profile/{{ Auth::user()->id }}"><em
                                                    class="icon ni ni-user-alt"></em><span>Ver
                                                    perfíl</span></a></li>
                                        <li><a href="/panel/config"><em
                                                    class="icon ni ni-setting-alt"></em><span>Configuración
                                                </span></a></li>
                                        <li><a class="dark-switch" href="#"><em
                                                    class="icon ni ni-moon"></em><span>Dark Mode</span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li>
                                            <a href="#"
                                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"><em
                                                    class="icon ni ni-signout"></em><span>Salir</span></a>
                                            <form id="logout-form" action="{{ route('logout') }}"
                                                method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li><!-- .dropdown -->
                        <li class="dropdown notification-dropdown me-n1">
                            <a href="#" class="dropdown-toggle nk-quick-nav-icon"
                                data-bs-toggle="dropdown">
                                <div class="icon-status icon-status-off" id="icon-status-notification"><em
                                        class="icon ni ni-bell"></em></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                                <div class="dropdown-head">
                                    <span class="sub-title nk-dropdown-title">Notificaciónes</span>
                                    <a class="pointer" onclick="readAllNotification()">Marcar como
                                        leidas</a>
                                </div>
                                <div class="dropdown-body">
                                    <div class="nk-notification" id="content-notification">




                                    </div><!-- .nk-notification -->
                                </div><!-- .nk-dropdown-body -->
                                <div class="dropdown-foot center">
                                    <a href="/panel/user-profile/{{ Auth::user()->id }}?tab=notification">Ver
                                        todo</a>
                                </div>
                            </div>
                        </li><!-- .dropdown -->
                    </ul><!-- .nk-quick-nav -->
                </div><!-- .nk-header-tools -->
            </div><!-- .nk-header-wrap -->
        </div><!-- .container-fliud -->
    </div>

    @yield('content')
    
    <input type="hidden" id="user_id" value="{{ isset(Auth::user()->id) ? Auth::user()->id : null }}">
    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script src="/assets_admin/js/bundle.js?ver=3.0.3"></script>
    <script src="/assets_admin/js/scripts.js?ver=3.0.3"></script>
    <script src="/assets_admin/js/charts/gd-default.js?ver=3.0.3"></script>
    {{-- <script type="text/javascript" src="/vendor/jquery-validation/dist/jquery.validate.js"></script> --}}
    <script type="text/javascript" src="/vendor/jquery-validation/dist/localization/messages_es.min.js"></script>
    <script type="text/javascript" src="/vendor/toastr/build/toastr.min.js"></script>
    {{-- <script type="text/javascript" src="/vendor/Toast/toast.js"></script> --}}
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <script src="https://cdn.ckeditor.com/4.16.1/full-all/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.1/full-all/lang/es.js"></script>

    {{-- tooltio --}}

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    <script type="text/javascript" src="/js/app.js"></script>
</body>