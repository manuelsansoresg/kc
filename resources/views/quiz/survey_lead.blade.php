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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- StyleSheets  -->
    <link rel="stylesheet" href="/assets_admin/css/dashlite.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="/assets_admin/css/theme.css?ver=3.0.3">
</head>
@php
     $currentDateTime = date('l H:i');
    $dayOK = (date('l') == 'Monday' || date('l') == 'Tuesday' 
            || date('l') == 'Wednesday' || date('l') == 'Thursday' 
            || date('l') == 'Friday');
    $timeOK = (date('H:i', strtotime($currentDateTime)) >= '09:00' 
            && date('H:i', strtotime($currentDateTime)) <= '18:00');
@endphp
<body class="nk-body npc-general pg-survey bg-dark text-white">
    <div class="d-flex justify-content-center align-items-center vh-100" id="content-lead-flex">
        <div class="text-center" id="content-leyend-start">
            <img class="" src="{{ asset('images/logo-dark.png') }}"
            alt="logo"  data-aos="fade-up">
            <p class="mt-5">
                @if ($dayOK && $timeOK)
                <h3 class="text-white"  data-aos="fade-up">
                    El trámite es fácil y rápido. <br> Puedes iniciar el trámite tú mismo o si lo prefieres, un asesor te puede ayudar via WhatsApp
                </h3>
                @else
                <h3 class="text-white"  data-aos="fade-up">
                    El trámite es fácil y rápido.
                </h3>
                    
                @endif
            </p>
            <p class="mt-5">
                @if ($dayOK && $timeOK)
                <div class="row justify-content-center">
                    <div class="col-6">
                        <a onclick="startStepperLead()" id="btn-next-init" class="btn btn-primary btn-lg btn-block py-3 pointer"  data-aos="fade-up">Adelante :)</a>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-6">
                        <a href="" class="btn btn-primary btn-lg btn-block py-3 pointer"  data-aos="fade-up">Contactar asesor</a>
                    </div>
                </div>
                
                @else
                <div class="row justify-content-center">
                    <div class="col-6">
                        <a onclick="startStepperLead()" class="btn btn-primary btn-lg btn-block py-3 pointer"  data-aos="fade-up">Adelante :)</a>
                    </div>
                </div>
                @endif
               
            </p>
        </div>
        <div id="content-lead-form" class="col-12" style="display: none">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6 offset-md-1" id="animate-logo" >
                        <img class="" src="{{ asset('images/logo-dark.png') }}"
                        alt="logo">
                        <form class="nk-stepper stepper-init is-alter mt-3" action="#">
                            <div class="nk-stepper-content">
                                <div class="nk-stepper-progress stepper-progress mb-4">
                                    <div class="stepper-progress-count mb-2"></div>
                                    <div class="progress progress-md">
                                        <div class="progress-bar stepper-progress-bar"></div>
                                    </div>
                                </div>
                                <div class="nk-stepper-steps stepper-steps">
                                    <div class="nk-stepper-step">
                                        <h5 class="title mb-3 mt-5">¿Recibiste el crédito?</h5>
                                        <div class="form-control-wrap mt-4">
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
                                                            for="surevey_credit_delivery-2">Sí pero un plazo o
                                                            monto distinto.</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                            name="surevey_credit_delivery"
                                                            id="surevey_credit_delivery-3" required
                                                            value="3">
                                                        <label class="custom-control-label"
                                                            for="surevey_credit_delivery-3">No lo recibí.</label>
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
                                    {{-- <input type="hidden" id="credit_id" name="credit_id" value="{{ $credit_id }}"> --}}
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          
        </div>
    </div>
    
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="/assets_admin/js/bundle.js?ver=3.0.3"></script>
    <script src="/assets_admin/js/scripts.js?ver=3.0.3"></script>
    <script src="/js/survey.js?ver=1"></script>
    <!-- select region modal -->
    
  <!-- Adding jQuery with CDN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <!-- Adding AOS JS Library -->
  <script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>
  
    <script>
        $(document).ready(function() {
            //Initialize AOS
            AOS.init();
            //*SURVEY LEAD
            window.startStepperLead = function() {
                $('#content-leyend-start').hide();
                $('#content-lead-flex').removeClass('justify-content-center');
                
                $("#content-lead-form").show("slide", { direction: "down" }, 500);


                
                NioApp.Stepper.init = function () {
                    NioApp.Stepper('.stepper-init');
                }; // Tagify @v1.0.1
            }
           
           
            
        });
     
    </script>
</html>
