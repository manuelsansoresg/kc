@inject('m_agreement', 'App\Models\Agreement')
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../../">
    <meta charset="utf-8">
    <meta name="author" content="kaaxclub">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Tu mejor decisión. Fácil y rápido">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="/images/favicon-32x32.png">
    <!-- Page Title  -->
    <title>KaaxClub - Hola </title>
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
@php
    $currentDateTime = date('l H:i');
    $dayOK = date('l') == 'Monday' || date('l') == 'Tuesday' || date('l') == 'Wednesday' || date('l') == 'Thursday' || date('l') == 'Friday';
    $timeOK = date('H:i', strtotime($currentDateTime)) >= '09:00' && date('H:i', strtotime($currentDateTime)) <= '18:00';
@endphp

<body class="nk-body bg-dark npc-general pg-survey text-white">
    <div class=" mt-5">
        <div class="col-12 text-center">
            <a href="/" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('images/logo-dark.png') }}"
                    alt="logo" data-aos="fade-up"
                    data-aos-duration="5000">
            
            </a>
        </div>
    </div>
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content" id="content-lead-flex">
                    <div class="d-flex justify-content-center align-items-center vh-100">
                        <div class="bg-dark is-dark p-5 ">
                            
                            <div class="text-block">
                                <h1 style="color: #6576ff !important;"> Hola </h1>
                                <p class="">
                                    @if ($dayOK && $timeOK)
                                        <h6 class="text-white" data-aos="fade-up" data-aos-duration="5000" >
                                            Vamos a analizar y calificar tus opciones para generar un reporte y puedas elegir tu mejor opción.
                                            <br><br>
                                            Después  de que elijas, te ayudaremos con el trámite para que todo salga bien.
                                            <br><br>
                                            Contacta un asesor para que genere tu reporte comparativo. O si
                                            lo
                                            prefieres lo puedes generar tú mismo.
                                        </h6>
                                    @else
                                        <h6 class="text-white" data-aos="fade-up" data-aos-duration="9000">
                                            Vamos a analizar y calificar tus opciones para generar un reporte y puedas elegir tu mejor opción.
                                            <br><br>
                                            Después  de que elijas, te ayudaremos con el trámite para que todo salga bien.
                                           
                                        </h6>
                                    @endif
                                </p>
                                <div class="mt-5" data-aos="fade-up" data-aos-duration="5000">
                                    @if ($dayOK && $timeOK)
                                    <div class="row justify-content-center mt-3" >
                                        <div class="col-12 col-md-6">
                                            <a target="_blank" href="https://api.whatsapp.com/send?phone=+529999208020&text=Hola, quiero información." class="btn btn-primary btn-lg btn-block py-3 pointer"
                                                >Contactar asesor &nbsp;
                                                <img width="18" src="/images/whatsapp-logo-1-1.png" alt="">
                                            </a>
                                        </div>
                                    </div>
                                        <div class="row justify-content-center mt-3">
                                            <div class="col-12 col-md-6">
                                                <a onclick="startStepperLead()" id="btn-next-init"
                                                    class="btn btn-primary btn-lg btn-block py-3 pointer"
                                                    >Hazlo tú mismo &nbsp; <i
                                                    class="fas fa-smile-beam text-warning"></i>
                                                </a>
                                            </div>
                                        </div>
                                       
                                    @else
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-md-6">
                                                <a onclick="startStepperLead()"
                                                    class="btn btn-primary btn-lg btn-block py-3 pointer"
                                                    >Adelante &nbsp; <i
                                                    class="fas fa-smile-beam text-warning"></i></a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row justify-content-center mt-5">
                                        <div class="col-12 text-center">
                                           <img width="20" src="/images/01_seguridad.png" alt="">
                                           &nbsp; <span class="text-muted text-ssl">Certificado SSL de seguridad y protección de datos</small>
                                        </div>
                                    </div>
                                    </div>

                            </div>

                        </div><!-- .nk-split-content -->

                    </div><!-- .nk-split -->
                </div>
               <div class="container">
                <form class="nk-stepper stepper-init is-alter" action="#" id="frm-survey">
                    <div class="nk-content  p-5" id="content-lead-form" style="display: none">
                        <div class="d-flex  align-items-center vh-100">
                            <div class="wide-xs-fix col-12 col-md-6 offset-md-1">
                                
                                <div class="nk-stepper-content">
                                    <div class="nk-stepper-progress stepper-progress mb-4">
                                        <div class="stepper-progress-count mb-2"></div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar stepper-progress-bar"></div>
                                        </div>
                                    </div>
                                    <div class="nk-stepper-steps stepper-steps">
                                        <div class="nk-stepper-step">
                                            <h5 class="title mb-3 mt-5">¿Cómo te llamas?</h5>
                                            <div class="form-group"><label class="form-label text-white"
                                                    for="sv1-first-name">
                                                </label>
                                                <div class="form-control-wrap"><input type="text"
                                                        class="form-control" id="name" name="data[name]"
                                                        placeholder="Por favor, escribe tu primer nombre"
                                                        required=""></div>
                                            </div>
                                        </div>
                                        <div class="nk-stepper-step">
                                            <h5 class="title mb-3 mt-5">Gracias <span class="span-name"></span> ¿y
                                                tu
                                                primer apellido?</h5>
                                            <div class="form-group"><label class="form-label text-white"
                                                    for="sv1-last-name">
                                                </label>
                                                <div class="form-control-wrap"><input type="text"
                                                        class="form-control" id="sv1-last-name" name="data[last_name]"
                                                        placeholder="Por favor, escribe tu respuesta" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-stepper-step">
                                            <h5 class="title mb-3 ">Nos gusta la comunicación tradicional, pero ¿qué
                                                tal si nos das tu email para mantenernos en contacto?</h5>
                                            <div class="form-group"><label class="form-label text-white"
                                                    for="sv1-email"> No enviamos spam. ¡Lo prometemos! <i
                                                        class="fas fa-smile-beam text-warning"></i>
                                                </label>
                                                <div class="form-control-wrap mt-5"><input type="email"
                                                        class="form-control" id="sv1-email" name="data[email]"
                                                        placeholder="Por favor, escribe tu email" required="">
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="nk-stepper-step">
                                            <h5 class="title mb-3 mt-5">En caso de que necesitemos enviarte un mensaje
                                                por WhatsApp ¿nos das tu número de celular?</h5>
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
                                            <h5 class="title mb-3 mt-5"><span class="span-name"> </span> ¿en dónde
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
                                            <h5 class="title mb-3 mt-5"><span class="span-name"> </span>, por último
                                                dinos qué es lo que deseas</h5>
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
                                                                    Quiero reducir mi deuda </span>
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
                                                <h3 class="text-center mb-4">Analizando tus opciones y generando reporte</h3>
                                                <div class="progress">
                                                    <div id="loading-bar" class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-stepper-step">
                                            <div class="pt-4 pb-2">
                                                <h5 class="title mb-2 fw-bold">¡Genial! Aquí está tu reporte.</h5>
                                                <p>
                                                    Una vez que elijas la mejor opción, te ayudaremos con el trámite.
                                                </p>
                                                @if ($dayOK && $timeOK)
                                                <div class="row justify-content-center mt-3">
                                                    <div class="col-12 col-md-6">
                                                        <a href="#" id="url_report" class="btn btn-primary btn-lg btn-block pointer my-3 btn-block"
                                                            >Ver reporte &nbsp;  <img width="18" src="/images/rocket.png" alt=""> </a>
                                                    </div>
                                                </div>
    
                                                    
                                                
                                                @else
                                                
                                                <div class="row justify-content-center mt-3">
                                                    <div class="col-12 col-md-6">
                                                        <a href="https://kaaxclub.com/"
                                                            class="btn btn-primary btn-lg btn-block pointer btn-block"
                                                                >Salir</a>
                                                    </div>
                                                </div>
                                                
                                                @endif
                                                <div class="row justify-content-center mt-3">
                                                    <div class="col-12 col-md-6">
                                                        <a href="https://kaaxclub.com/ayuda" id="btn-next-init"
                                                            class="btn btn-primary btn-lg btn-block pointer btn-block"
                                                            data-aos="fade-up" data-aos-duration="5000">Ayuda
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="row justify-content-center mt-3">
                                                    <div class="col-12">
                                                       <p class="text-muted font-italic" style="font-style: italic;">
                                                        También te lo enviamos por email, si no lo ves, consulta la bandeja de spam
                                                       </p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
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
    <style>
        #loading-bar {
        width: 10%;
        height: 20px;
        background-color: #0d6efd;
        -webkit-transition: width 5s ease;  /* Chrome, Safari, Opera */
        transition: width 5s ease;
    }
    </style>
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
                if (count_steeper == 6) {
                    $('#btn-back').hide();
                    $('#btn-finish').hide();
                    $('#continue').hide();
                    loading();
                }
               
                if (count_steeper == 4) {
                    saveLead(false);
                }
                
                if (count_steeper > 3) {
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
                const form = document.getElementById('frm-survey');
                const formData = new FormData(form);

                axios.post('/lead/store', formData)
                .then(function(response) {
                    let result = response.data;
                    let lead = result.lead;
                    let history = result.history;
                    $('#lead_id').val(lead.id);
                    if (history != null) {
                        //*cambiar URL a produccion
                        let resultReport = 'https://test.kaaxclub.com/reporte/' + history.id;
                        document.getElementById('url_report').setAttribute('href', resultReport);
                        
                    }
                    /* axios.get('/reporte/survey/getURL')
                    .then(function(response) {
                    }) */
                    
                    if (is_redirect == true) {
                        window.location = 'https://kaaxclub.com';
                    }
                })
                .catch(function(error) {
                });
                
            }

            $(".stepper-progress-count").text(function(index, currentText) {
            return currentText.replace("of", "de");
            });

            window.loading = function() {

                let i = 10;
                let interval = setInterval(() => {
                    document.getElementById("loading-bar").style.width = i + "%";
                    document.getElementById("loading-bar").setAttribute("aria-valuenow", i);
                    if (i >= 100) {
                        document.getElementById("continue").click();
                        clearInterval(interval);
                    } else {
                    i += 10;
                    }
                }, 500);
            }

        });
    </script>


</html>
