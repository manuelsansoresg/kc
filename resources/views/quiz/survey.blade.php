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
    <link rel="shortcut icon" href="/assets_admin/images/favicon.png">
    <!-- Page Title  -->
    <title>Survey | Customer Satisfaction | DashLite Admin Template</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="/assets_admin/css/dashlite.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="/assets_admin/css/theme.css?ver=3.0.3">
</head>

<body class="nk-body bg-white npc-general pg-survey">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-lg">
                        <div
                            class="nk-split-content bg-dark is-dark p-5 d-flex justify-between flex-column text-center w-50">
                            <a href="html/index.html" class="logo-link nk-sidebar-logo">
                                <img class="logo-light logo-img" src="{{ asset('images/logo-dark.png') }}"
                                    srcset="./images/logo2x.png 2x" alt="logo">
                                <img class="logo-dark logo-img" src="{{ asset('images/logo-dark.png') }}"
                                    srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                            </a>
                            <div class="text-block">
                                <img class="nk-survey-gfx mb-5" src="/assets_admin/images/gfx/survey.svg"
                                    alt="">
                                <h3 class="text-white">Encuesta de satisfacción</h3>
                                <p>Tú opinion es muy importante, nos ayuda a mejorar.</p>
                            </div>
                            <p>&copy; Equipo de KaaxClub</p>
                        </div><!-- .nk-split-content -->
                        <div
                            class="nk-split-content nk-split-stretch bg-white p-5 d-flex justify-center align-center flex-column">
                            <div class="wide-xs-fix">
                                <form class="nk-stepper stepper-init is-alter" action="#" id="frm-survey">
                                    <div class="nk-stepper-content">
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
                                                                    for="surevey_credit_delivery-1">Sí lo recibí</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="surevey_credit_delivery"
                                                                    id="surevey_credit_delivery-2" required
                                                                    value="2">
                                                                <label class="custom-control-label"
                                                                    for="surevey_credit_delivery-2">Sí pero un plazo o
                                                                    monto distinto</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input"
                                                                    name="surevey_credit_delivery"
                                                                    id="surevey_credit_delivery-3" required
                                                                    value="3">
                                                                <label class="custom-control-label"
                                                                    for="surevey_credit_delivery-3">No lo recibi</label>
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
                                                <h5 class="title mb-4">¿Cómo calificarías la atención la financiera que
                                                    te otorgó el crédito?</h5>
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
                                                    class="btn btn-dim btn-primary">Regresar</button></li>
                                            <li class="step-next"><button class="btn btn-primary">Continuar</button>
                                            </li>
                                            <li class="step-submit" onclick="saveSurvey()"><button class="btn btn-primary">Enviar</button>
                                            </li>
                                            <input type="hidden" id="credit_id" name="credit_id" value="{{ $credit_id }}">
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
    <script src="/js/survey.js?ver=1"></script>
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
                                    <img src="./images/flags/arg.png" alt="" class="country-flag">
                                    <span class="country-name">Argentina</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/aus.png" alt="" class="country-flag">
                                    <span class="country-name">Australia</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/bangladesh.png" alt="" class="country-flag">
                                    <span class="country-name">Bangladesh</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/canada.png" alt="" class="country-flag">
                                    <span class="country-name">Canada <small>(English)</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/china.png" alt="" class="country-flag">
                                    <span class="country-name">Centrafricaine</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/china.png" alt="" class="country-flag">
                                    <span class="country-name">China</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/french.png" alt="" class="country-flag">
                                    <span class="country-name">France</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/germany.png" alt="" class="country-flag">
                                    <span class="country-name">Germany</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/iran.png" alt="" class="country-flag">
                                    <span class="country-name">Iran</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/italy.png" alt="" class="country-flag">
                                    <span class="country-name">Italy</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/mexico.png" alt="" class="country-flag">
                                    <span class="country-name">México</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/philipine.png" alt="" class="country-flag">
                                    <span class="country-name">Philippines</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/portugal.png" alt="" class="country-flag">
                                    <span class="country-name">Portugal</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/s-africa.png" alt="" class="country-flag">
                                    <span class="country-name">South Africa</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/spanish.png" alt="" class="country-flag">
                                    <span class="country-name">Spain</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/switzerland.png" alt="" class="country-flag">
                                    <span class="country-name">Switzerland</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/uk.png" alt="" class="country-flag">
                                    <span class="country-name">United Kingdom</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/english.png" alt="" class="country-flag">
                                    <span class="country-name">United State</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div><!-- .modal -->

</html>
