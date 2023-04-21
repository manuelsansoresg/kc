@inject('m_agreement', 'App\Models\Agreement')
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
    <link rel="stylesheet" href="/assets_admin/css/dashlite.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="/assets_admin/css/theme.css?ver=3.0.3">
    {{-- aditional css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
        integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="/css/survey.css?ver=1.0.0">

</head>
@php
    $currentDateTime = date('l H:i');
    $dayOK = date('l') == 'Monday' || date('l') == 'Tuesday' || date('l') == 'Wednesday' || date('l') == 'Thursday' || date('l') == 'Friday';
    $timeOK = date('H:i', strtotime($currentDateTime)) >= '09:00' && date('H:i', strtotime($currentDateTime)) <= '18:00';
@endphp

<body class="nk-body bg-transparent npc-general pg-survey text-white">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content" id="content-lead-flex">
                    <div class="d-flex justify-content-center align-items-center vh-100">
                        <div class="bg-transparent is-dark p-5 text-center">
                            <a href="/" class="logo-link nk-sidebar-logo">
                                <img class="logo-light logo-img" src="{{ asset('images/logo-dark.png') }}"
                                    alt="logo" data-aos="fade-up"
                                    data-aos-duration="5000">
                            
                            </a>
                            <div class="text-block">
                                <p class="mt-5">
                                    <h3 class="text-white" data-aos="fade-up" data-aos-duration="9000">
                                        El trámite es fácil y rápido.
                                    </h3>
                                </p>
                                <p class="mt-5">
                                    <div class="row justify-content-center">
                                        <div class="col-12 col-md-6">
                                            <a onclick="startStepperLead()" id="btn-next-init"
                                                class="btn btn-primary btn-lg btn-block py-3 pointer"
                                                data-aos="fade-up" data-aos-duration="5000">Adelante &nbsp; <i
                                                class="fas fa-smile-beam text-warning"></i>
                                            </a>
                                        </div>
                                    </div>

                                </p>

                            </div>

                        </div><!-- .nk-split-content -->

                    </div><!-- .nk-split -->
                </div>
               <div class="container">
                <form class="nk-stepper stepper-init is-alter" action="#" id="frm-survey">
                    <div class="nk-content  p-5" id="content-lead-form" style="display: none">
                        <div class="d-flex  align-items-center vh-100">
                            <div class="wide-xs-fix col-12 col-md-6 offset-md-1">
                                <a href="/" class="logo-link nk-sidebar-logo">
                                    <img class="logo-light logo-img" src="{{ asset('images/logo-dark.png') }}"
                                    alt="logo" data-aos="fade-up"
                                    data-aos-duration="5000">
                                </a>
    
                                
                                <div class="nk-stepper-content">
                                    <div class="nk-stepper-progress stepper-progress mb-4">
                                        <div class="stepper-progress-count mb-2"></div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar stepper-progress-bar"></div>
                                        </div>
                                    </div>
                                    <div class="nk-stepper-steps stepper-steps">
                                       
    
                                        <div class="nk-stepper-step">
                                            <h5 class="title mb-3 mt-5">En caso de que necesitemos enviarte un mensaje
                                                por WhatsApp, ¿nos das tu número de celular?</h5>
                                            <div class="form-group"><label class="form-label text-white"
                                                    for="sv1-cellphone">
                                                </label>
                                                <div class="form-control-wrap"><input type="number"
                                                        class="form-control" id="sv1-cellphone" name="data[cellphone]"
                                                        minlength="10" maxlength="10" pattern="[0-9]{10}"
                                                        placeholder="Por favor, escribe tu número de celular"
                                                        required="">
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $agreements = $m_agreement::all();
                                        @endphp
    
                                        <div class="nk-stepper-step">
                                            <h5 class="title mb-3 mt-5"><span class="span-name"> </span> ¿En dónde
                                                trabajas?</h5>
                                            <div class="form-group"><label class="form-label text-white"
                                                    for="sv1-cellphone">
                                                </label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" id="agreement"
                                                        name="data[agreement_id]" data-placeholder="Select Position"
                                                        required="" data-select2-id="sv2-select-position"
                                                        tabindex="-1" aria-hidden="true">
                                                        <option value="">Seleccione una opción</option>
                                                        
                                                        @foreach ($agreements as $agreement)
                                                            <option value="{{ $agreement->id }}">{{ $agreement->name }}
                                                            </option>
                                                        @endforeach
                                                        <option value="00">Otro</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
    
    
                                        <div class="nk-stepper-step">
                                            <h5 class="title mb-3 mt-5"><span class="span-name"> </span> y por último
                                                ¿Cómo podemos ayudarte?</h5>
                                            <div class="form-group"><label class="form-label text-white"
                                                    for="sv1-cellphone">
                                                    Te ayudamos a encontrar la mejor opción
                                                </label>
                                                <ul class="custom-control-group custom-control-vertical custom-control-stacked w-100">
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                            <input type="radio" class="custom-control-input" id="surevey_kc_attention-s5" name="data[product_id]" value="1" onclick="chooseOptionCredit()">
                                                            <label class="custom-control-label bg-dark" for="surevey_kc_attention-s5">
                                                                <span class="user-card"> <span class="sq_icon">
                                                                    Quiero un crédito nuevo </span>
                                                                   </span> </label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="custom-control custom-control-sm custom-radio custom-control-pro">
                                                            <input type="radio" class="custom-control-input" id="surevey_kc_attention-s6" name="data[product_id]" value="2" onclick="chooseOptionCredit()">
                                                            <label class="custom-control-label bg-dark" for="surevey_kc_attention-s6">
                                                                <span class="user-card"> <span class="sq_icon">
                                                                    Ya tengo un crédito, quiero mejorarlo </span>
                                                                   </span> </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                                {{-- <a onclick="chooseOptionCredit(1)" class="btn btn-primary btn-lg" style="cursor: pointer;">Quiero un crédito nuevo</a>
                                                <a onclick="chooseOptionCredit(2)" class="btn btn-primary btn-lg" style="cursor: pointer;">Ya tengo un crédito, quiero mejorarlo</a> --}}
                                            </div>
                                        </div>
    
                                        <div class="nk-stepper-step">
                                            <div class="pt-4 pb-2">
                                                <em
                                                    class="icon icon-circle icon-circle-xxl mb-4 ni ni-check bg-primary-dim"></em>
                                                <h5 class="title mb-2">Genial!</h5>
                                                <p>Hemos generado un reporte con las opciones de crédito disponibles para tí.
                                                   
                                                </p>
                                                <div class="row justify-content-center mt-3">
                                                    <div class="col-12 col-md-6">
                                                        <a href="" id="lnk_show_report" class="btn btn-primary btn-lg btn-block py-3 pointer my-3 btn-block"
                                                            data-aos="fade-up" data-aos-duration="5000">Ver reporte</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class=text-danger id="msg-error" style="display: none">Error en el sistema</p>
                                    <ul class="nk-stepper-pagination pt-4 gx-4 gy-2 stepper-pagination">
                                        <li class="step-prev"><button class="btn btn-dim btn-primary btn-lg py-3"
                                                onclick="backStepper()" id="btn-back">Regresar</button></li>
                                        <li class="step-next"><button class="btn btn-primary btn-lg py-3"
                                                onclick="continueStepper()" id="continue">Continuar </button>
                                        </li>
                                        <li class="step-submit" onclick="saveSurvey()"><button
                                                class="btn btn-primary btn-lg py-3" id="btn-finish">Enviar</button>
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>
                    </div><!-- .nk-split-content -->
    
                    <div class="nk-content  p-5" id="content-lead-work" style="display:none">
                        <div class="d-flex  align-items-center vh-100">
                            <div class="wide-xs-fix col-12 col-md-6 offset-md-1">
                                <a href="/" class="logo-link nk-sidebar-logo">
                                    <img class="logo-light logo-img" src="{{ asset('images/logo-dark.png') }}"
                                    alt="logo" data-aos="fade-up"
                                    data-aos-duration="5000">
                                </a>
                                <p class="mt-5">
                                <h3 class="text-white" data-aos="fade-up" data-aos-duration="5000">
                                    Lo sentimos <i class="fas fa-sad-tear text-warning"></i>
                                </h3>
                                </p>
                                <p class="mt-5">
                                    Aún no contamos con servicio para el lugar donde trabajas
                                    <br>
                                    Por favor, dinos dónde trabajas para poder ofrecerte nuestro servicio próximamente.
                                </p>
                                <div class="form-group">
                                    <label class="form-label text-white" for="sv1-email">   </label>
                                    <div class="form-control-wrap"><input type="text" class="form-control"
                                            id="sv1-email" name="data[other]" placeholder="Por favor, escribe tu respuesta"
                                            required="">
                                    </div>
                                </div>
                                <input type="hidden" name="key_user" value="{{ $_GET['token'] }}">
                                <input type="hidden" name="key_email" value="{{ $_GET['email'] }}">
                                
                                <button type="button"
                                                    class="btn btn-primary btn-lg py-3" onclick="saveLead(true)">Terminar</button>
                            </div>
                        </div>
                    </div>
    
                    <!-- wrap @e -->
                    <input type="hidden" id="lead_id" name="lead_id">
                    <input type="hidden" id="number_step" name="number_step">
                </form>
               </div>
            </div>

            <footer class="fixed-bottom text-center">
                <p>&copy; Equipo de KaaxClub</p>
            </footer>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="/assets_admin/js/bundle.js?ver=3.0.3"></script>
    <script src="/assets_admin/js/scripts.js?ver=3.0.3"></script>
    <script src="/js/survey.js?ver=1"></script>

    <!-- Adding jQuery with CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Adding AOS JS Library -->
    <script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>

    <script>
        $(document).ready(function() {
            let count_steeper = 0;
            //*Initialize AOS
            AOS.init();
            //* SURVEY LEAD
            window.startStepperLead = function() {
                /* $('#content-leyend-start').hide(); */
                $('#content-lead-flex').hide();
                /* $('#content-lead-flex').removeClass('justify-content-center'); */

                $("#content-lead-form").show("slide", {
                    direction: "down"
                }, 500);
            }

            //* Assing value to the span with ID 'span-name' when typing in the input field with ID 'name'
            $('#name').on('input', function() {
                $('.span-name').text($(this).val());
            });
            //*animate stepper when click button continuar or regresar
            function animateStepper() {
                $("#content-lead-form").hide();
                $("#content-lead-form").show("slide", {
                    direction: "down"
                }, 500);
            }
            window.continueStepper = function() {
                count_steeper = count_steeper + 1;
                console.log(count_steeper);
                $('#number_step').val(count_steeper);
                if (count_steeper == 3) {
                    $('#btn-back').hide();
                    $('#btn-finish').hide();
                }
                if (count_steeper > 0) {
                    console.log('ejecutar guardado');
                    saveLead(false);
                }
                animateStepper();
                
            }

            window.backStepper = function() {
                count_steeper = count_steeper - 1;
                console.log(count_steeper);
                $('#number_step').val(count_steeper);
                animateStepper();
            }

            $('.form-control').on('keydown', function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                }
            });


            $('#agreement').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue == '00') {
                    $("#content-lead-form").hide();
                    $("#content-lead-work").show("slide", {
                    direction: "down"
                }, 500);
                    
                } else {
                    $('#continue').click();
                }
            });

            window.chooseOptionCredit = function() {
                $('#continue').click();
            }

            window.saveLead = function (is_redirect) {
                $('#msg-error').hide();
                const form = document.getElementById('frm-survey');
                const formData = new FormData(form);

                axios.post('/lead/form/store', formData)
                .then(function(response) {
                    let result = response.data;
                    let lead = result.lead;
                    let credit_id = result.credit_id;

                    let lnk_show_report = document.getElementById('lnk_show_report');
                    lnk_show_report.href = '/app/reporte/null/'+credit_id;


                    $('#lead_id').val(lead.id);
                    if (is_redirect == true) {
                        window.location = 'https://kaaxclub.com';
                    }
                })
                .catch(function(error) {
                    /* $('#msg-error').show(); */
                });
                
            }

            $(".stepper-progress-count").text(function(index, currentText) {
            return currentText.replace("of", "de");
            });

        });
    </script>


</html>
