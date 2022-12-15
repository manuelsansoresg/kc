@inject('m_user', 'App\Models\User')
@inject('m_history', 'App\Models\HistoryLog')
@inject('m_notification', 'App\Models\Notification')
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
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="/assets_admin/images/favicon.png">
    <!-- Page Title  -->
    <title>@yield('title')</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="/assets_admin/css/dashlite.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="/assets_admin/css/theme.css?ver=3.0.3">
    <link rel="stylesheet" type="text/css" href="/css/app.css"/>
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-sidebar-brand">
                        <a href="html/index.html" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="{{ asset('images/logo-dark.png') }}" srcset="{{ asset('images/logo-dark.png') }}" alt="logo">
                            <img class="logo-dark logo-img" src="{{ asset('images/logo-dark.png') }}" srcset="{{ asset('images/logo-dark.png') }}" alt="logo-dark">
                        </a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                               


                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                        <span class="nk-menu-text">Prospectos</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        
                                        <li class="nk-menu-item">
                                            <a href="/panel/lead" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                                <span class="nk-menu-text">Persona</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                    </ul>
                                   
                                </li>
                                
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-archived"></em></span>
                                        <span class="nk-menu-text">Archivo</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        
                                        <li class="nk-menu-item">
                                            <a href="/panel/archive/lead" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                                <span class="nk-menu-text">Prospecto persona</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/archive/product" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-sign-usd-alt2"></em></span>
                                                <span class="nk-menu-text">Créditos</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                    </ul>
                                   
                                </li>

                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-check-circle-cut"></em></span>
                                        <span class="nk-menu-text">Acciones Prospectos</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        
                                        <li class="nk-menu-item">
                                            <a href="/panel/action/in_progress/lead/view" class="nk-menu-link">
                                                <span class="nk-menu-icon"> <em class="icon ni ni-circle"></em></span>
                                                <span class="nk-menu-text">En curso</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/action/completed/lead/view" class="nk-menu-link">
                                                <span class="nk-menu-icon"> <em class="icon ni ni-circle"></em></span>
                                                <span class="nk-menu-text">Concluidas</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                    </ul>
                                   
                                </li>
                                
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-check-circle-cut"></em></span>
                                        <span class="nk-menu-text">Acciones Módulos</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        
                                        <li class="nk-menu-item">
                                            <a href="/panel/action/module/in_progress" class="nk-menu-link">
                                                <span class="nk-menu-icon"> <em class="icon ni ni-circle"></em></span>
                                                <span class="nk-menu-text">En curso</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/action/module/completed" class="nk-menu-link">
                                                <span class="nk-menu-icon"> <em class="icon ni ni-circle"></em></span>
                                                <span class="nk-menu-text">Concluidas</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                    </ul>
                                   
                                </li>

                               

                                @hasrole('Administrador')
                                @if ($m_user->getAccesConfig() == 1)
                                    <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-setting-alt-fill"></em></span>
                                        <span class="nk-menu-text">Configuración</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item has-sub">
                                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                                <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                                                <span class="nk-menu-text">Usuarios</span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item">
                                                    <a href="/panel/user/administrador" class="nk-menu-link"><span class="nk-menu-text">Admin</span></a>
                                                </li>
                                                <li class="nk-menu-item">
                                                    <a href="/panel/user/asesor" class="nk-menu-link"><span class="nk-menu-text">Asesores</span></a>
                                                </li>
                                                <li class="nk-menu-item">
                                                    <a href="/panel/user/cliente-persona" class="nk-menu-link"><span class="nk-menu-text">Cliente persona</span></a>
                                                </li>
                                                <li class="nk-menu-item">
                                                    <a href="/panel/user/cliente-financiera" class="nk-menu-link"><span class="nk-menu-text">Cliente financiera</span></a>
                                                </li>
        
                                            </ul>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="/panel/product" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-card-view"></em></span>
                                                <span class="nk-menu-text">Productos</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/agreement" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-card-view"></em></span>
                                                <span class="nk-menu-text">Convenios</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/financial" class="nk-menu-link">
                                                <span class="nk-menu-icon">
                                                    <em class="icon ni ni-building"></em>
                                                </span>
                                                <span class="nk-menu-text">Financieras</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/tag" class="nk-menu-link"> 
                                                <span class="nk-menu-icon"><em class="icon ni ni-tag"></em></span>
                                                <span class="nk-menu-text">Etiquetas</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                    </ul>
                                
                                    </li>
                                @endif
                            @endhasrole

                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">MÓDULOS</h6>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="/panel/kc-check-up" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-clipboad-check"></em></span>
                                        <span class="nk-menu-text">KC- Check up</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="/panel/kc-swap" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-swap-alt"></em></span>
                                        <span class="nk-menu-text">KC- Swap</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="/panel/kc-control-desk" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-clipboad-check"></em></span>
                                        <span class="nk-menu-text">KC- Control desk</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="/panel/kc-delivery" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-clipboad-check"></em></span>
                                        <span class="nk-menu-text">KC- Delivery</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="/panel/kc-aftermarket" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-happy"></em></span>
                                        <span class="nk-menu-text">KC- Aftermarket</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">CRÉDITOS</h6>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-files"></em></span>
                                        <span class="nk-menu-text">Créditos</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        
                                        <li class="nk-menu-item">
                                            <a href="/panel/credit/product/{{ $m_history::CREDIT_IN_PROGRESS }}" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-sign-usd-alt2"></em></span>
                                                <span class="nk-menu-text">En curso</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/credit/product/{{ $m_history::CREDIT_CANCELED }}" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-sign-usd-alt2"></em></span>
                                                <span class="nk-menu-text">Cancelados</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/credit/product/{{ $m_history::CREDIT_REJECTED }}" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-sign-usd-alt2"></em></span>
                                                <span class="nk-menu-text">Rechazados</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/credit/product/{{ $m_history::CREDITS_PAID }}" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-sign-usd-alt2"></em></span>
                                                <span class="nk-menu-text">Pagados</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                    </ul>
                                   
                                </li>
                                
                                
                            </ul><!-- .nk-menu -->
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div aria-live="polite" aria-atomic="true" class="position-relative">
                    <!-- Position it: -->
                    <!-- - `.toast-container` for spacing between toasts -->
                    <!-- - `.position-absolute`, `top-0` & `end-0` to position the toasts in the upper right corner -->
                    <!-- - `.p-3` to prevent the toasts from sticking to the edge of the container  -->
                    <div class="toast-container position-absolute top-0 end-0 p-3" style="z-index: 9999">
                  
                      <!-- Then put toasts within -->
                      <div id="content-toast"></div>

                    </div>
                  </div>
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="/assets_admin/images/logo.png" srcset="/assets_admin/images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="/assets_admin/images/logo-dark.png" srcset="/assets_admin/images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                            
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown language-dropdown d-none d-sm-block me-n1">
                                       
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-s1">
                                            <ul class="language-list">
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="/assets_admin/images/flags/english.png" alt="" class="language-flag">
                                                        <span class="language-name">English</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="/assets_admin/images/flags/spanish.png" alt="" class="language-flag">
                                                        <span class="language-name">Español</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="/assets_admin/images/flags/french.png" alt="" class="language-flag">
                                                        <span class="language-name">Français</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="/assets_admin/images/flags/turkey.png" alt="" class="language-flag">
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
                                                    <div class="user-status"> {{ Auth::user()->getRoleNames()[0]}}</div>
                                                    <div class="user-name dropdown-indicator"> {{ Auth::user()->name }}</div>
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
                                                    <li><a href="/panel/user-profile/{{ Auth::user()->id }}"><em class="icon ni ni-user-alt"></em><span>Ver perfíl</span></a></li>
                                                    <li><a href="html/user-profile-setting.html"><em class="icon ni ni-setting-alt"></em><span>Configuración </span></a></li>
                                                    <li><a class="dark-switch" href="#"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li>
                                                        <a href="#" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"><em class="icon ni ni-signout"></em><span>Salir</span></a>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li><!-- .dropdown -->
                                    <li class="dropdown notification-dropdown me-n1">
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div class="icon-status icon-status-off" id="icon-status-notification"><em class="icon ni ni-bell"></em></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end dropdown-menu-s1">
                                            <div class="dropdown-head">
                                                <span class="sub-title nk-dropdown-title">Notificaciónes</span>
                                                <a class="pointer" onclick="readAllNotification()">Marcar como leidas</a>
                                            </div>
                                            <div class="dropdown-body">
                                                <div class="nk-notification" id="content-notification">
                                                    
                                                    
                                                    
                                                    
                                                </div><!-- .nk-notification -->
                                            </div><!-- .nk-dropdown-body -->
                                            <div class="dropdown-foot center">
                                                <a href="/panel/user-profile/{{ Auth::user()->id }}?tab=notification">Ver todo</a>
                                            </div>
                                        </div>
                                    </li><!-- .dropdown -->
                                </ul><!-- .nk-quick-nav -->
                            </div><!-- .nk-header-tools -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                
                @yield('content')


                
                
                  
                  


                <!-- content @e -->
                <!-- footer @s -->
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; KaaxClub
                            </div>
                            <div class="nk-footer-links">
                                <ul class="nav nav-sm">
                                    <li class="nav-item dropup">
                                        <a href="#" class="dropdown-toggle dropdown-indicator has-indicator nav-link text-base" data-bs-toggle="dropdown" data-offset="0,10"><span>English</span></a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                            <ul class="language-list">
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <span class="language-name">English</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <span class="language-name">Español</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <span class="language-name">Français</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <span class="language-name">Türkçe</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a data-bs-toggle="modal" href="#region" class="nav-link"><em class="icon ni ni-globe"></em><span class="ms-1">Select Region</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- select region modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="region">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="title mb-4">Select Your Country</h5>
                    <div class="nk-country-region">
                        <ul class="country-list text-center gy-2">
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/arg.png" alt="" class="country-flag">
                                    <span class="country-name">Argentina</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/aus.png" alt="" class="country-flag">
                                    <span class="country-name">Australia</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/bangladesh.png" alt="" class="country-flag">
                                    <span class="country-name">Bangladesh</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/canada.png" alt="" class="country-flag">
                                    <span class="country-name">Canada <small>(English)</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/china.png" alt="" class="country-flag">
                                    <span class="country-name">Centrafricaine</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/china.png" alt="" class="country-flag">
                                    <span class="country-name">China</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/french.png" alt="" class="country-flag">
                                    <span class="country-name">France</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/germany.png" alt="" class="country-flag">
                                    <span class="country-name">Germany</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/iran.png" alt="" class="country-flag">
                                    <span class="country-name">Iran</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/italy.png" alt="" class="country-flag">
                                    <span class="country-name">Italy</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/mexico.png" alt="" class="country-flag">
                                    <span class="country-name">México</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/philipine.png" alt="" class="country-flag">
                                    <span class="country-name">Philippines</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/portugal.png" alt="" class="country-flag">
                                    <span class="country-name">Portugal</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/s-africa.png" alt="" class="country-flag">
                                    <span class="country-name">South Africa</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/spanish.png" alt="" class="country-flag">
                                    <span class="country-name">Spain</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/switzerland.png" alt="" class="country-flag">
                                    <span class="country-name">Switzerland</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/uk.png" alt="" class="country-flag">
                                    <span class="country-name">United Kingdom</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/english.png" alt="" class="country-flag">
                                    <span class="country-name">United State</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div><!-- .modal -->
    <input type="hidden" id="user_id" value="{{ (isset(Auth::user()->id))? Auth::user()->id : null }}">
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


    <script type="text/javascript" src="/js/app.js"></script>

    
</body>

</html>