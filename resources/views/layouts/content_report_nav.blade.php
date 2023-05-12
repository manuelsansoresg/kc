{{-- <nav class="navbar navbar-expand-lg navbar-transparent navbar-sticky navbar-dark">
    <div class="container position-relative">
       
        <div class="text-center">
            <a class="navbar-brand" href="index.html">
                <img src="{{ asset('images/logo-dark.png') }}" class="img-fluid" alt="">
    
            </a>
        </div>
       
        <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbarDefault" aria-controls="offcanvasNavbarDefault" aria-expanded="false"
            aria-label="Toggle navigation"><span class="material-symbols-rounded align-middle">menu</span></button>
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" id="offcanvasNavbarDefault" tabindex="-1"
            aria-labelledby="offcanvasNavbarDefaultLabel">
            <div class="offcanvas-header justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav ms-xl-auto">
                    <li class="nav-item dropdown"><a class="nav-link dropdown-arrow" href="#"
                            data-bs-toggle="dropdown">Opciones<span
                                class="material-symbols-rounded align-middle lh-1 dropdown-arrow-icon">expand_more</span></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="index.html">Regresar</a>
                            <a class="dropdown-item" href="/reporte/{{ $history_id }}/metodologia">Metodología</a>
                            <a class="dropdown-item" href="index-signup.html">Continuar</a>
                        </div>
                    </li>


                </ul>
            </div>
        </div>
    </div>
</nav> --}}

<nav class="navbar navbar-expand-lg navbar-transparent navbar-sticky navbar-dark">
    <div class="container-fluid position-relative">
        <a class="navbar-brand" href="index.html">
            <img src="{{ asset('images/logo-dark.png') }}" class="img-fluid" alt="">

        </a><button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbarDefault" aria-controls="offcanvasNavbarDefault" aria-expanded="false"
            aria-label="Toggle navigation"><span class="material-symbols-rounded align-middle">menu</span></button>
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" id="offcanvasNavbarDefault" tabindex="-1"
            aria-labelledby="offcanvasNavbarDefaultLabel">
            <div class="offcanvas-header justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="me-auto navbar-nav ms-xl-4">
                    <li class="nav-item dropdown"><a class="nav-link dropdown-arrow" href="#"
                            data-bs-toggle="dropdown">Opciones<span
                                class="material-symbols-rounded align-middle lh-1 dropdown-arrow-icon">expand_more</span></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="index.html">Regresar</a>
                            <a class="dropdown-item" href="/reporte/{{ $history_id }}/metodologia">Metodología</a>
                            <a class="dropdown-item" href="index-signup.html">Continuar</a>
                        </div>
                    </li>


                </ul>
                <ul class="navbar-nav ms-xl-auto">
                    <li class="nav-item mb-3 mb-lg-0"><a class="btn btn-warning btn-sm hover-lift"
                            href="demo-request.html">Continuar<span
                                class="align-middle material-symbols-rounded fs-5 ms-1 d-none d-xl-inline-block">arrow_forward</span></a>
                    </li>
                    <li
                        class="mt-4 mt-lg-0 nav-item d-flex align-items-center justify-content-lg-center flex-lg-column h-100 ms-0 ms-xl-3">
                        <label
                            class="dark-mode-checkbox d-flex align-items-center justify-content-center rounded-circle nav-link p-0"
                            for="ChangeTheme"><input type="checkbox" class="appearance-none" id="ChangeTheme"><span
                                class="dark-mode-icons size-30 d-inline-flex align-items-center justify-content-center me-2 me-lg-0"><span
                                    class="material-symbols-rounded align-middle">dark_mode</span><span
                                    class="material-symbols-rounded align-middle">light_mode</span></span><span
                                class="ms-1 d-lg-none">Dark Mode</span></label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
