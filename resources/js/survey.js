window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

$(document).ready(function() {
    let count_steeper = 0;
    //*Initialize AOS
    AOS.init();
    //* SURVEY LEAD
    window.startSteppersurvey = function() {
        /* $('#content-leyend-start').hide(); */
        $('#content-survey-flex').hide();
        /* $('#content-survey-flex').removeClass('justify-content-center'); */

        $("#frm-survey").show("slide", {
            direction: "down"
        }, 500);
    }

    //*animate stepper when click button continuar or regresar
    function animateStepper() {
        $("#frm-survey").hide();
        $("#frm-survey").show("slide", {
            direction: "down"
        }, 500);
    }

    window.continueStepper = function() {
        count_steeper = count_steeper + 1;
        console.log(count_steeper);
        $('#number_step_survey').val(count_steeper);
        if (count_steeper == 3) {
            $('#btn-back').hide();
            $('#btn-finish').hide();
        }
        if (count_steeper == 4) {
            console.log('ejecutar guardado');
            var btnBack = document.getElementById("btnBack");
            btnBack.style.display = "none";
            saveSurvey();
        }
        animateStepper();
        
    }
    window.backStepper = function() {
        count_steeper = count_steeper - 1;
        console.log(count_steeper);
        $('#number_step_survey').val(count_steeper);
        /* animateStepper(); */
    }

    $('.form-control').on('keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    });


    window.saveSurvey = function () {
    
        const new_form = document.getElementById("frm-survey");
        const data = new FormData(new_form);
        axios
            .post("survey", data)
            .then(function (response) {
                /* window.location = '/panel/kc-aftermarket'; // TODO: volver dinamico de donde provenga */
            })
            .catch(e => {
                let response = e.response;
            });
    }

    $(".stepper-progress-count").text(function(index, currentText) {
        return currentText.replace("of", "de");
    });

});

