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
    <meta name="description"
        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="/assets_admin/images/favicon.png">
    <!-- Page Title  -->
    <title>@yield('title')</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="/assets_admin/css/dashlite.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="/assets_admin/css/theme.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" type="text/css" href="/css/app.css" />
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none"
                            data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex"
                            data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-sidebar-brand">
                        <a href="/panel/lead" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="{{ asset('images/logo-dark.png') }}"
                                srcset="{{ asset('images/logo-dark.png') }}" alt="logo">
                            <img class="logo-dark logo-img" src="{{ asset('images/logo-dark.png') }}"
                                srcset="{{ asset('images/logo-dark.png') }}" alt="logo-dark">
                        </a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                @hasrole('Administrador|Asesor')
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
                                @endhasrole

                                @hasrole('Administrador|Asesor')
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
                                @endhasrole
                                @hasrole('Administrador|Asesor')
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
                                @endhasrole

                                @hasrole('Administrador')
                                    @if ($m_user->getAccesConfig() == 1)
                                        <li class="nk-menu-item has-sub">
                                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                                <span class="nk-menu-icon"><em
                                                        class="icon ni ni-setting-alt-fill"></em></span>
                                                <span class="nk-menu-text">Configuración</span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item has-sub">
                                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                                        <span class="nk-menu-icon"><em
                                                                class="icon ni ni-users-fill"></em></span>
                                                        <span class="nk-menu-text">Usuarios</span>
                                                    </a>
                                                    <ul class="nk-menu-sub">
                                                        <li class="nk-menu-item">
                                                            <a href="/panel/user/administrador" class="nk-menu-link"><span
                                                                    class="nk-menu-text">Admin</span></a>
                                                        </li>
                                                        <li class="nk-menu-item">
                                                            <a href="/panel/user/asesor" class="nk-menu-link"><span
                                                                    class="nk-menu-text">Asesores</span></a>
                                                        </li>
                                                        <li class="nk-menu-item">
                                                            <a href="/panel/user/cliente-persona"
                                                                class="nk-menu-link"><span class="nk-menu-text">Cliente
                                                                    persona</span></a>
                                                        </li>
                                                        <li class="nk-menu-item">
                                                            <a href="/panel/user/cliente-financiera"
                                                                class="nk-menu-link"><span class="nk-menu-text">Cliente
                                                                    financiera</span></a>
                                                        </li>

                                                    </ul>
                                                </li>
                                                <li class="nk-menu-item">
                                                    <a href="/panel/product" class="nk-menu-link">
                                                        <span class="nk-menu-icon"><em
                                                                class="icon ni ni-card-view"></em></span>
                                                        <span class="nk-menu-text">Productos</span>
                                                    </a>
                                                </li><!-- .nk-menu-item -->
                                                <li class="nk-menu-item">
                                                    <a href="/panel/agreement" class="nk-menu-link">
                                                        <span class="nk-menu-icon"><em
                                                                class="icon ni ni-card-view"></em></span>
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
                                @hasrole('Administrador|Cliente financiera|Asesor')
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">MÓDULOS</h6>
                                </li><!-- .nk-menu-item -->
                                @endhasrole
                                @hasrole('Administrador|Asesor')
                                <li class="nk-menu-item">
                                    <a href="/panel/kc-check-up" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-clipboad-check"></em></span>
                                        <span class="nk-menu-text">KC- Check up</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                @endhasrole
                                @hasrole('Administrador|Asesor')
                                <li class="nk-menu-item">
                                    <a href="/panel/kc-swap" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-swap-alt"></em></span>
                                        <span class="nk-menu-text">KC- Swap</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                @endhasrole
                                @hasrole('Administrador|Asesor')
                                <li class="nk-menu-item">
                                    <a href="/panel/kc-control-desk" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-clipboad-check"></em></span>
                                        <span class="nk-menu-text">KC- Control desk</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                @endhasrole
                                @hasrole('Administrador|Cliente financiera|Asesor')
                                <li class="nk-menu-item">
                                    <a href="/panel/kc-delivery" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-clipboad-check"></em></span>
                                        <span class="nk-menu-text">KC- Delivery</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                @endhasrole
                                @hasrole('Administrador|Asesor')
                                <li class="nk-menu-item">
                                    <a href="/panel/kc-aftermarket" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-happy"></em></span>
                                        <span class="nk-menu-text">KC- Aftermarket</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                @endhasrole
                                @hasrole('Administrador|Asesor')
                                <li class="nk-menu-item">
                                    <a href="/panel/kc-payments" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="fa-solid fa-money-check-dollar"></em></span>
                                        <span class="nk-menu-text">KC- Payments</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                @endhasrole
                                @hasrole('Administrador|Asesor')
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">CRÉDITOS</h6>
                                </li><!-- .nk-menu-item -->
                                @endhasrole
                                @hasrole('Administrador|Asesor')
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-files"></em></span>
                                        <span class="nk-menu-text">Créditos</span>
                                    </a>
                                    <ul class="nk-menu-sub">

                                        <li class="nk-menu-item">
                                            <a href="/panel/credit/product/{{ $m_history::CREDIT_IN_PROGRESS }}"
                                                class="nk-menu-link">
                                                <span class="nk-menu-icon"><em
                                                        class="icon ni ni-sign-usd-alt2"></em></span>
                                                <span class="nk-menu-text">En curso</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/credit/product/{{ $m_history::CREDIT_CANCELED }}"
                                                class="nk-menu-link">
                                                <span class="nk-menu-icon"><em
                                                        class="icon ni ni-sign-usd-alt2"></em></span>
                                                <span class="nk-menu-text">Cancelados</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/credit/product/{{ $m_history::CREDIT_REJECTED }}"
                                                class="nk-menu-link">
                                                <span class="nk-menu-icon"><em
                                                        class="icon ni ni-sign-usd-alt2"></em></span>
                                                <span class="nk-menu-text">Rechazados</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="/panel/credit/product/{{ $m_history::CREDITS_PAID }}"
                                                class="nk-menu-link">
                                                <span class="nk-menu-icon"><em
                                                        class="icon ni ni-sign-usd-alt2"></em></span>
                                                <span class="nk-menu-text">Pagados</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                    </ul>

                                </li>
                                @endhasrole
                                @hasrole('Administrador|Asesor')
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
                                                <span class="nk-menu-icon"><em
                                                        class="icon ni ni-sign-usd-alt2"></em></span>
                                                <span class="nk-menu-text">Créditos</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item has-sub">
                                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                                <span class="nk-menu-icon"><em class="fa-solid fa-money-check-dollar"></em></span>
                                                <span class="nk-menu-text">KC- Payments</span>
                                            </a>
                                            <ul class="nk-menu-sub">

                                                <li class="nk-menu-item">
                                                    <a href="/panel/archive/lead" class="nk-menu-link">
                                                        <span class="nk-menu-icon"><em class="fa-solid fa-money-check-dollar"></em></span>
                                                        <span class="nk-menu-text">Pagado</span>
                                                    </a>
                                                </li><!-- .nk-menu-item -->
                                                <li class="nk-menu-item">
                                                    <a href="/panel/archive/lead" class="nk-menu-link">
                                                        <span class="nk-menu-icon"><em class="fa-solid fa-money-check-dollar"></em></span>
                                                        <span class="nk-menu-text">No pagado</span>
                                                    </a>
                                                </li><!-- .nk-menu-item -->
                                            </ul>
                                        </li>
                                    </ul>

                                </li>
                                @endhasrole
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
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon"
                                    data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="/assets_admin/images/logo.png"
                                        srcset="/assets_admin/images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="/assets_admin/images/logo-dark.png"
                                        srcset="/assets_admin/images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->

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
                                                    <li><a href="html/user-profile-setting.html"><em
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
                                        <a href="#"
                                            class="dropdown-toggle dropdown-indicator has-indicator nav-link text-base"
                                            data-bs-toggle="dropdown" data-offset="0,10"><span>English</span></a>
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
                                        <a data-bs-toggle="modal" href="#region" class="nav-link"><em
                                                class="icon ni ni-globe"></em><span class="ms-1">Select
                                                Region</span></a>
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
    {{-- modal restriccion --}}
    <div id="modal-access" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-access-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-access-title">Terminos y condiciones</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm-tyc">
                        <div class="form-check">
                                <input class="form-check-input" type="checkbox"  id="tyc" name="tyc" value="1">
                                <label class="form-check-label form-check-label-s1" for="tyc"> Acepto los terminos y
                                    condiciones </label>
                        </div>
                            <div class="tyc mt-2 px-2">
                            
                                <p class="text-center mt-3">
                                    Términos y Condiciones de uso del Sitio
                                </p>
                                <p>
                                    Este contrato describe los términos y condiciones generales (Términos y Condiciones)
                                    aplicables a la utilización de la presente página web, sitio web o página de internet y
                                    al uso de los servicios (los Servicios), cuyo nombre de dominio es www.kaaxclub.mx, así
                                    como cualquier subdominio o página referenciada propiedad de YALKU SERVICIOS, S.A.P.I.
                                    de C.V., (KaaxClub). KaaxClub le otorga al público en general la condición de “Usuario”
                                    e implica la aceptación, plena e incondicional, de todas y cada una de las condiciones
                                    generales y particulares incluidas en los presentes términos y condiciones, en el
                                    momento mismo en que el Usuario acceda al Sitio. Cualquier persona que desee acceder y/o
                                    usar el Sitio o los Servicios podrá hacerlo sujetándose a los Términos y Condiciones,
                                    junto con todas las demás políticas y principios que rigen a KaaxClub y que son
                                    incorporados al presente por referencia.
                                    <br><br>
                                    Cualquier persona que no acepte los términos y condiciones, los cuales tienen un
                                    carácter obligatorio y vinculante, deberá abstenerse de utilizar el sitio y/o los
                                    servicios. Los términos y condiciones no están sujetos a negociación o modificación de
                                    ninguna índole, por lo que se entienden aceptados en su totalidad por el simple hecho de
                                    ingresar al sitio.
                                    <br><br>
                                    El Usuario del Sitio debe leer, entender y aceptar todas las condiciones establecidas en
                                    los Términos y Condiciones, en el Aviso de Privacidad, así como en los demás documentos
                                    incorporados a los mismos por referencia, previamente a su inscripción como Usuario del
                                    Sitio y reconoce que el uso efectivo y/o registro exitoso de alguna operación de un
                                    Usuario, presume la aceptación de los Términos y Condiciones del Sitio, de conformidad
                                    con lo establecido en el Artículo 80 del Código de Comercio y en términos de lo
                                    dispuesto por el artículo 1803 del Código Civil Federal.
                                    <br><br>
                                    Capacidad <br><br>
                                    Únicamente podrán ser Usuarios las personas que tengan capacidad legal para contratar.
                                    Por lo anterior, no podrán utilizar el Sitio las personas que no tengan esa capacidad
                                    incluyendo a los menores de edad.
                                    <br><br>Inscripción<br><br>
                                    Para poder estar en posibilidades de utilizar el Sitio será obligatorio completar el
                                    formulario de inscripción en todos sus campos con datos válidos. El Usuario deberá
                                    completarlo con su información personal de manera exacta, precisa y verdadera ("Datos
                                    Personales"). En este sentido, KaaxClub no se responsabiliza por la certeza de los Datos
                                    Personales provistos por sus Usuarios, razón por la cual los propios Usuarios garantizan
                                    y responden, en cualquier caso, de la veracidad, exactitud, vigencia y autenticidad de
                                    los datos personales ingresados y provistos.
                                    <br><br>
                                    Los Datos Personales que los usuarios proporcionen al momento de su ingreso y/o registro
                                    al sitio, tienen como finalidad el crear un expediente y facilitar el acceso a su
                                    cuenta, así como a su configuración, como el cargar y descargar videos, fotos, sonidos,
                                    etc. La recopilación de datos, se llevará a cabo única y exclusivamente a través de los
                                    formularios publicados en la web y podrán verificarse vía telefónica o por medios
                                    electrónicos.
                                    <br><br>
                                    KaaxClub se reserva el derecho de solicitar a los Usuarios algún comprobante y/o dato
                                    adicional a efectos de corroborar los datos personales, así como de suspender temporal o
                                    definitivamente a aquellos Usuarios cuyos datos no hayan podido ser confirmados.
                                    <br><br>
                                    En caso de no contar con los datos señalados, KaaxClub no estaría en posibilidad de
                                    proporcionar los datos que se solicitan son indispensables para dar acceso y uso a la
                                    página web.
                                    <br><br>El Usuario accederá a su cuenta personal ("Cuenta") que será única e
                                    intransferible, mediante el ingreso con una Contraseña personal elegida ("Contraseña"),
                                    misma que se obliga a mantener en absoluta confidencialidad.
                                    <br><br>El Usuario será el único responsable por todas las operaciones efectuadas en su
                                    Cuenta, pues el acceso a la misma está restringido al ingreso y uso de su Contraseña la
                                    cual es de conocimiento exclusivo del Usuario. Derivado de lo anterior, el Usuario se
                                    compromete a notificar a KaaxClub en forma inmediata y por medio idóneo y fehaciente,
                                    cualquier uso no autorizado de su Cuenta, así como el ingreso por terceros no
                                    autorizados a la misma.
                                    KaaxClub se reserva el derecho de rechazar cualquier solicitud de inscripción o de
                                    cancelar una inscripción previamente aceptada, sin que esté obligado a comunicar o
                                    exponer las razones de su decisión y sin que ello genere algún derecho a indemnización o
                                    resarcimiento a favor del Usuario. Así como bloquear el acceso o remover en forma
                                    parcial o total toda información, comunicación o material que a su exclusivo juicio
                                    pueda resultar: i) abusivo, difamatorio u obsceno; ii) fraudulento, artificioso o
                                    engañoso; iii) violatorio de derechos de autor, marcas, confidencialidad, secretos
                                    industriales o cualquier derecho de propiedad intelectual de un tercero; iv) ofensivo o;
                                    v) que de cualquier forma contravenga lo establecido en los Términos y Condiciones
                                    <br><br>El Usuario declara y garantiza, bajo protesta de decir verdad, que es mayor de
                                    edad y que cuenta con la capacidad jurídica necesaria para realizar las actividades que
                                    se contienen en el Sitio, así como que toda la información y documentación que ha
                                    proporcionado y/o proporcione en relación con cualquier actividad que se promueva en el
                                    Sitio, es verdadera, completa y correcta, quedando, por ende, obligada a indemnizar y
                                    sacar en paz y a salvo a KaaxClub de cualquier daño, perjuicio, demanda y/o acción que
                                    dicha omisión o falsedad le provoque.
                                    <br><br>El Usuario reconoce que KaaxClub solamente actuará, en su caso, como mandante
                                    para prestar los recursos del Usuario a nombre y por cuenta del mismo, a terceros
                                    interesados en obtener créditos. Por ende, cualquier monto que sea prestado a cualquier
                                    persona por virtud de las actividades contenidas en el Sitio, es a la exclusiva cuenta y
                                    riesgo del Usuario. Dichos recursos de ninguna forma y en ningún momento serán propiedad
                                    de KaaxClub. KaaxClub por ningún motivo y bajo ninguna causa o circunstancia será
                                    responsable, obligado solidario o de forma alguna responderá por el pago que deberán
                                    hacer los terceros que reciban recursos del Usuario por virtud de las actividades
                                    contenidas en el Sitio.
                                    <br><br>
                                    Modificaciones del Acuerdo<br><br>
        
                                    Los presentes Términos y Condiciones no están sujetos a negociación o modificación de
                                    ninguna especie, por lo que se entienden aceptadas en su totalidad por los Usuarios.
                                    KaaxClub se reserva el derecho a modificar los Términos y Condiciones en cualquier
                                    momento, situación que la dará a conocer a través del Sitio. Una vez que se publique en
                                    el Sitio, entrará en vigor automáticamente y deberá dar estricto cumplimiento al texto.
        
                                    <br><br>Privacidad de la Información<br><br>
                                    Para utilizar los Servicios ofrecidos por KaaxClub y el Sitio, el Usuario deberá
                                    proporcionar determinados datos de carácter personal. Su información personal se
                                    procesará y almacenará en servidores o medios magnéticos que mantienen altos estándares
                                    de seguridad y protección tanto física como tecnológica. Para mayor información sobre la
                                    privacidad de los datos personales y casos en los que será revelada la información
                                    personal, se puede consultar nuestro Aviso de Privacidad a través del siguiente link:
                                    <br><br>www.kaaxclub.com/avisodeprivacidad<br><br>
                                    En caso de que el Usuario revele la Información Confidencial deberá indemnizar a
                                    KaaxClub de cualquier pérdida, daño, perjuicio, cargo o gastos (incluyendo honorarios de
                                    abogados) que resulten. KaaxClub tiene la convicción de proteger la Información
                                    Confidencial proporcionada por el Usuario y es el responsable de su tratamiento cuando
                                    sea recabada a través del Sitio.
                                    <br><br>El Usuario, otorga su consentimiento para: i) que KaaxClub comparta y/o
                                    proporcione la información financiera, comercial, operativa y personal del Usuario, así
                                    como la relativa a cualquier actividad que se promueve en el sitio; ii) que su
                                    información pueda ser utilizada con fines mercadotécnicos y/o publicitarios; iii)
                                    recibir en su domicilio particular y/o laboral, correos electrónicos personales y/o
                                    laborales, teléfonos fijos particulares y/o laborales, teléfonos móviles particulares
                                    y/o laborales o, por cualquier otro medio, publicidad de los bienes, productos y/o
                                    servicios, y; iv) que KaaxClub y/o la persona que designe, en caso de ser necesario,
                                    realicen llamadas a cualquier teléfono y/o visitas a cualquier domicilio del Usuario y/o
                                    en relación con cualquier referencia que sea ofrecida por el Usuario, además de los días
                                    hábiles, en días que sean declarados como inhábiles y, a cualquier hora, para el efecto
                                    de requerirle el o los pagos que a su cargo se lleguen a establecer por virtud de las
                                    actividades que se promueven en el sitio.
        
                                    <br><br>Propiedad intelectual.
        
                                    Los contenidos de las pantallas relativas a los servicios de KaaxClub así como los
                                    programas, bases de datos, redes, archivos, los logotipos y todo el material que aparece
                                    en dicho Sitio que permiten a los Usuarios acceder y usar su Cuenta, son de propiedad de
                                    KaaxClub y están protegidas por las leyes y los tratados internacionales de derecho de
                                    autor, marcas, patentes, modelos y diseños industriales. El uso indebido y la
                                    reproducción total o parcial de dichos contenidos quedan prohibidos, salvo autorización
                                    expresa y por escrito de KaaxClub.
                                    <br><br>El Sitio puede contener enlaces a otros sitios web lo cual no indica que sean
                                    propiedad u operados por KaaxClub. En virtud que KaaxClub no tiene control sobre tales
                                    sitios, no será responsable por los contenidos, materiales, acciones y/o servicios
                                    prestados por los mismos, ni por daños o pérdidas ocasionadas por la utilización de los
                                    mismos, sean causadas directa o indirectamente. La presencia de enlaces a otros sitios
                                    web no implica una sociedad, relación, aprobación, respaldo de KaaxClub a dichos sitios
                                    y sus contenidos.
                                    <br><br><br><br>En caso que KaaxClub sospeche que se está cometiendo o se ha cometido
                                    una actividad ilícita o infractora de derechos de propiedad intelectual o industrial,
                                    KaaxClub se reserva el derecho de adoptar todas las medidas legales que estime
                                    pertinentes.
                                    <br><br>Notificaciones de Derechos de Autor<br><br>
                                    KaaxClub podrá, a su discreción, cancelar la cuenta de los Usuarios que infrinjan los
                                    derechos de propiedad intelectual de terceros. KaaxClub eliminará los materiales
                                    transgresores de acuerdo con las leyes mexicanas relacionadas con la propiedad
                                    industrial o cualquier otra ley aplicable, si se le notifica conforme lo establecido que
                                    cierto contenido infringe los derechos de autor.
                                    <br><br>Anexos<br><br>
                                    <br><br>Forman parte integral e inseparable de los Términos y Condiciones Generales, los
                                    siguientes documentos y/o secciones de KaaxClub incorporados por referencia. Los mismos
                                    se podrán consultar dentro del sitio mediante el enlace abajo provisto o accediendo
                                    directamente a las páginas correspondientes:
                                <ul>
                                    <li> - Aviso de Privacidad</li>
                                    <li> - Domicilios</li>
                                </ul>
                                <br><br>
                                Este acuerdo estará regido en todos sus puntos por las leyes vigentes en la República
                                Mexicana, en particular respecto de mensajes de datos, contratación electrónica y comercio
                                electrónico se regirá por lo dispuesto por la legislación federal respectiva. Cualquier
                                controversia derivada del presente acuerdo, su existencia, validez, interpretación, alcance
                                o cumplimiento, será sometida a las leyes aplicables y a los Tribunales competentes.
                                <br><br>Para la interpretación, cumplimiento y ejecución del presente contrato, las partes
                                expresamente se someten a la jurisdicción de los tribunales competentes de la Ciudad de
                                Mérida, Yucatán, renunciando en consecuencia a cualquier fuero que en razón de su domicilio
                                presente o futuro pudiera corresponderles.
                                <br><br>El Usuario reconoce que ha leído, reconoce y acepta los términos y condiciones del
                                Sitio.
                                <br><br>El Usuario, otorga su consentimiento para:<br><br>
                                <ul class="dashed-list">
                                    <li>
                                        - Que KaaxClub comparta y/o proporcione la información financiera, comercial,
                                        operativa y personal del Usuario, así como la relativa a cualquier actividad que se
                                        promueve en el sitio,
                                    </li>
                                    <li>
                                        - Que su información pueda ser utilizada por KaaxClub con fines mercadotécnicos y/o
                                        publicitarios,
                                    </li>
                                    <li>
                                        - Recibir en su domicilio particular y/o laboral, correos electrónicos personales
                                        y/o laborales, teléfonos fijos particulares y/o laborales, teléfonos móviles
                                        particulares y/o laborales o, por cualquier otro medio, publicidad de los bienes,
                                        productos y/o servicios, y,
                                    </li>
                                    <li>
                                        - Que KaaxClub y/o la persona que designe, realicen llamadas a cualquier teléfono
                                        y/o visitas a cualquier domicilio del Usuario y/o en relación con cualquier
                                        referencia que sea ofrecida por el Usuario, además de los días hábiles, en días que
                                        sean declarados como inhábiles y, a cualquier hora, para el efecto de requerirle el
                                        o los pagos que a su cargo se lleguen a establecer por virtud de las actividades que
                                        se promueven en el sitio.
                                    </li>
                                </ul>
        
                                Los Datos Personales que los usuarios proporcionen al momento de su ingreso y/o registro al
                                sitio, tienen como finalidad el crear un expediente y facilitar el acceso a su cuenta, así
                                como a su configuración, como el cargar y descargar videos, fotos, sonidos, etc. La
                                recopilación de datos, se llevará a cabo única y exclusivamente a través de los formularios
                                publicados en la web y podrán verificarse vía telefónica o por medios electrónicos.
                                <br><br>En caso de no contar con los datos señalados, KaaxClub no estaría en posibilidad de
                                proporcionar los datos que se solicitan son indispensables para dar acceso y uso a la página
                                web.
                                <br><br>KaaxClub se reserva el derecho de modificar en cualquier momento el contenido de la
                                presente Política de Privacidad. Cualquier cambio en la Política de Privacidad le será
                                informado a sus usuarios a través de
                                <br><br>Una vez que se publique el Aviso de Privacidad en el Sitio, entrará en vigor
                                automáticamente y deberá dar estricto cumplimiento al texto.
        
                                </p>
        
                        </div>
                        <button class="btn btn-primary float-end mt-2">Aceptar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal restriccion --}}
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
                                    <img src="/assets_admin/images/flags/arg.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">Argentina</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/aus.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">Australia</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/bangladesh.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">Bangladesh</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/canada.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">Canada <small>(English)</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/china.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">Centrafricaine</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/china.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">China</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/french.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">France</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/germany.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">Germany</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/iran.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">Iran</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/italy.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">Italy</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/mexico.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">México</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/philipine.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">Philippines</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/portugal.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">Portugal</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/s-africa.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">South Africa</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/spanish.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">Spain</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="/assets_admin/images/flags/switzerland.png" alt=""
                                        class="country-flag">
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
                                    <img src="/assets_admin/images/flags/english.png" alt=""
                                        class="country-flag">
                                    <span class="country-name">United State</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div><!-- .modal -->
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


    <script type="text/javascript" src="/js/app.js"></script>


</body>

</html>
