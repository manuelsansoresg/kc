<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="/images/favicon-32x32.png">
    <!-- Page Title  -->
    <title>KC- Encuesta de satisfacción</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
        integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/assets_admin/css/dashlite.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="/assets_admin/css/theme.css?ver=3.0.3">
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

<body class="nk-body bg-white npc-general pg-survey">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content " id="content-survey-flex">
                    <div class="nk-split nk-split-page nk-split-lg">
                        <div
                            class="nk-split-content bg-dark is-dark p-5 d-flex justify-between flex-column text-center w-50">
                            <a href="html/index.html" class="logo-link nk-sidebar-logo">
                                <img class="logo-light logo-img" src="{{ asset('images/logo-dark.png') }}"
                                    srcset="./images/logo2x.png 2x" alt="logo">
                                <img class="logo-dark logo-img" src="{{ asset('images/logo-dark.png') }}"
                                    srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                            </a>
                            <div class="text-block" data-aos="fade-up"
                            data-aos-duration="5000">
                                <div class="d-none d-md-block">
                                    <img class="nk-survey-gfx mb-5" src="{{ asset('images/apple-touch-icon.png') }}"
                                        alt="">
                                </div>
                                <h3 class="text-white">Encuesta de satisfacción</h3>
                                <p>Tú opinion es muy importante, nos ayuda a mejorar.</p>
                            </div>
                            <p>&copy; Equipo de KaaxClub</p>
                        </div><!-- .nk-split-content -->
                        <div
                            class="nk-split-content nk-split-stretch bg-white p-5 d-flex justify-center align-center flex-column">
                            <div class="wide-xs-fix">
                                <form class="nk-stepper stepper-init is-alter" action="#" id="frm-survey">
                                    <div class="nk-stepper-content" data-aos="fade-up"
                                    data-aos-duration="5000">
                                        <div class="nk-stepper-progress stepper-progress mb-4">
                                            <div class="stepper-progress-count mb-2"></div>
                                            <div class="progress progress-md">
                                                <div class="progress-bar stepper-progress-bar"></div>
                                            </div>
                                        </div>
                                        <div class="nk-stepper-steps stepper-steps">
                                            <div class="nk-stepper-step">
                                                <h5 class="title mb-3">¿Recibiste el crédito?</h5>
                                                <div class="form-control-wrap">
                                                    <ul class="custom-control-group flex-column align-start">
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="surevey_credit_delivery"
                                                                    id="surevey_credit_delivery-1" required
                                                                    value="1">
                                                                <label class="custom-control-label"
                                                                    for="surevey_credit_delivery-1">Sí lo recibí.</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="surevey_credit_delivery"
                                                                    id="surevey_credit_delivery-2" required
                                                                    value="2">
                                                                <label class="custom-control-label"
                                                                    for="surevey_credit_delivery-2">Está en trámite.</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="surevey_credit_delivery"
                                                                    id="surevey_credit_delivery-3" required
                                                                    value="3">
                                                                <label class="custom-control-label"
                                                                    for="surevey_credit_delivery-3">No lo he tramitado.</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="nk-stepper-step">
                                                <h5 class="title mb-3">¿Cómo calificarías la atención que recibiste en
                                                    KaaxClub?</h5>
                                                    <ul class="custom-control-group custom-control-vertical custom-control-stacked w-100">
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                <input type="radio" class="custom-control-input" id="surevey_kc_attention-s5" name="surevey_kc_attention" value="5">
                                                                <label class="custom-control-label" for="surevey_kc_attention-s5">
                                                                    <span class="user-card"> <span class="sq_icon">
                                                                            <img class="img-radio-survey" src="{{ asset('images/survey5.svg') }}" alt=""> </span>
                                                                        <span class="user-info"> <span class="lead-text">5
                                                                            </span> </span> </span> </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                <input type="radio" class="custom-control-input" id="surevey_kc_attention-s4" name="surevey_kc_attention" value="4">
                                                                <label class="custom-control-label" for="surevey_kc_attention-s4">
                                                                    <span class="user-card"> <span class="sq_icon">
                                                                            <img class="img-radio-survey" src="{{ asset('images/survey4.svg') }}" alt=""> </span>
                                                                        <span class="user-info"> <span class="lead-text">4</span> </span> </span> </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                <input type="radio" class="custom-control-input" id="surevey_kc_attention-s3" name="surevey_kc_attention" value="3">
                                                                <label class="custom-control-label" for="surevey_kc_attention-s3">
                                                                    <span class="user-card"> <span class="sq_icon">
                                                                            <img class="img-radio-survey" src="{{ asset('images/survey3.svg') }}" alt=""> </span>
                                                                        <span class="user-info"> <span class="lead-text">3</span> </span> </span> </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                <input type="radio" class="custom-control-input" id="surevey_kc_attention-s2" name="surevey_kc_attention" value="2">
                                                                <label class="custom-control-label" for="surevey_kc_attention-s2">
                                                                    <span class="user-card"> <span class="sq_icon">
                                                                            <img class="img-radio-survey" src="{{ asset('images/survey2.svg') }}" alt=""> </span>
                                                                        <span class="user-info"> <span class="lead-text">2</span> </span> </span> </label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                <input type="radio" class="custom-control-input" id="surevey_kc_attention-s1" name="surevey_kc_attention" value="1">
                                                                <label class="custom-control-label" for="surevey_kc_attention-s1">
                                                                    <span class="user-card"> <span class="sq_icon">
                                                                            <img class="img-radio-survey" src="{{ asset('images/survey1.svg') }}" alt=""> </span>
                                                                        <span class="user-info"> <span class="lead-text">1</span> </span> </span> </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                
                                            </div>
                                            <div class="nk-stepper-step">
                                                <h5 class="title mb-4">¿Qué tan satisfecho está con la claridad y transparencia de la información que te proporcionamos?</h5>
                                                <div class="row g-4">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <ul class="custom-control-group custom-control-vertical custom-control-stacked w-100">
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" id="surevey_financial_attention-s5" name="surevey_financial_attention" value="5">
                                                                            <label class="custom-control-label" for="surevey_financial_attention-s5">
                                                                                <span class="user-card"> <span class="sq_icon">
                                                                                        <img class="img-radio-survey" src="{{ asset('images/survey5.svg') }}" alt=""> </span>
                                                                                    <span class="user-info"> <span class="lead-text">5
                                                                                        </span> </span> </span> </label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" id="surevey_financial_attention-s4" name="surevey_financial_attention" value="4">
                                                                            <label class="custom-control-label" for="surevey_financial_attention-s4">
                                                                                <span class="user-card"> <span class="sq_icon">
                                                                                        <img class="img-radio-survey" src="{{ asset('images/survey4.svg') }}" alt=""> </span>
                                                                                    <span class="user-info"> <span class="lead-text">4</span> </span> </span> </label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" id="surevey_financial_attention-s3" name="surevey_financial_attention" value="3">
                                                                            <label class="custom-control-label" for="surevey_financial_attention-s3">
                                                                                <span class="user-card"> <span class="sq_icon">
                                                                                        <img class="img-radio-survey" src="{{ asset('images/survey3.svg') }}" alt=""> </span>
                                                                                    <span class="user-info"> <span class="lead-text">3</span> </span> </span> </label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" id="surevey_financial_attention-s2" name="surevey_financial_attention" value="2">
                                                                            <label class="custom-control-label" for="surevey_financial_attention-s2">
                                                                                <span class="user-card"> <span class="sq_icon">
                                                                                        <img class="img-radio-survey" src="{{ asset('images/survey2.svg') }}" alt=""> </span>
                                                                                    <span class="user-info"> <span class="lead-text">2</span> </span> </span> </label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" id="surevey_financial_attention-s1" name="surevey_financial_attention" value="1">
                                                                            <label class="custom-control-label" for="surevey_financial_attention-s1">
                                                                                <span class="user-card"> <span class="sq_icon">
                                                                                        <img class="img-radio-survey" src="{{ asset('images/survey1.svg') }}" alt=""> </span>
                                                                                    <span class="user-info"> <span class="lead-text">1</span> </span> </span> </label>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-stepper-step">
                                                <h5 class="title mb-4">¿En una escala del 1 al 5 ¿Qué tan probable es que nos recomiendes con un conocido?</h5>
                                                <div class="row g-4">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <ul class="custom-control-group custom-control-vertical custom-control-stacked w-100">
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" id="surevey_recomendacion_amigos-s5" name="surevey_recomendacion_amigos" value="5">
                                                                            <label class="custom-control-label" for="surevey_recomendacion_amigos-s5">
                                                                                <span class="user-card"> <span class="sq_icon">
                                                                                        <img class="img-radio-survey" src="{{ asset('images/survey5.svg') }}" alt=""> </span>
                                                                                    <span class="user-info"> <span class="lead-text">5
                                                                                        </span> </span> </span> </label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" id="surevey_recomendacion_amigos-s4" name="surevey_recomendacion_amigos" value="4">
                                                                            <label class="custom-control-label" for="surevey_recomendacion_amigos-s4">
                                                                                <span class="user-card"> <span class="sq_icon">
                                                                                        <img class="img-radio-survey" src="{{ asset('images/survey4.svg') }}" alt=""> </span>
                                                                                    <span class="user-info"> <span class="lead-text">4</span> </span> </span> </label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" id="surevey_recomendacion_amigos-s3" name="surevey_recomendacion_amigos" value="3">
                                                                            <label class="custom-control-label" for="surevey_recomendacion_amigos-s3">
                                                                                <span class="user-card"> <span class="sq_icon">
                                                                                        <img class="img-radio-survey" src="{{ asset('images/survey3.svg') }}" alt=""> </span>
                                                                                    <span class="user-info"> <span class="lead-text">3</span> </span> </span> </label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" id="surevey_recomendacion_amigos-s2" name="surevey_recomendacion_amigos" value="2">
                                                                            <label class="custom-control-label" for="surevey_recomendacion_amigos-s2">
                                                                                <span class="user-card"> <span class="sq_icon">
                                                                                        <img class="img-radio-survey" src="{{ asset('images/survey2.svg') }}" alt=""> </span>
                                                                                    <span class="user-info"> <span class="lead-text">2</span> </span> </span> </label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                                            <input type="radio" class="custom-control-input" id="surevey_recomendacion_amigos-s1" name="surevey_recomendacion_amigos" value="1">
                                                                            <label class="custom-control-label" for="surevey_recomendacion_amigos-s1">
                                                                                <span class="user-card"> <span class="sq_icon">
                                                                                        <img class="img-radio-survey" src="{{ asset('images/survey1.svg') }}" alt=""> </span>
                                                                                    <span class="user-info"> <span class="lead-text">1</span> </span> </span> </label>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-stepper-step">
                                                <h5 class="title mb-3">¿Tienes algún comentario?</h5>
                                                <div class="form-group">
                                                        
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control form-control-sm" id="survey_note" name="survey_note"
                                                            placeholder="Opcional"></textarea>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <div class="nk-stepper-step">
                                                <div class="pt-4 pb-2">
                                                    <em
                                                        class="icon icon-circle icon-circle-xxl mb-4 ni ni-check bg-primary-dim"></em>
                                                    <h5 class="title mb-2">Encuesta concluida</h5>
                                                    <p>Gracias! tu opinión nos ayuda a mejorar</p>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="nk-stepper-pagination pt-4 gx-4 gy-2 stepper-pagination">
                                            <li class="step-prev"><button
                                                    class="btn btn-dim btn-primary" id="btnBack" onclick="backStepper()">Regresar</button></li>
                                            <li class="step-next"><button class="btn btn-primary" onclick="continueStepper()">Continuar</button>
                                            </li>
                                            <li class="step-submit" onclick="">
                                                <div class="col-12">
                                                    <a href="/" class="btn btn-primary btn-block">Salir</a>
                                                </div>
                                            </li>
                                            <input type="hidden" id="credit_id" name="credit_id" value="{{ $credit_id }}">
                                            <input type="hidden" id="number_step_survey" name="number_step">
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div><!-- .nk-split-content -->
                    </div><!-- .nk-split -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="/assets_admin/js/bundle.js?ver=3.0.3"></script>
    <script src="/assets_admin/js/scripts.js?ver=3.0.3"></script>
    <script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>
    <script src="/js/survey.js?ver=1"></script>
    

</html>
