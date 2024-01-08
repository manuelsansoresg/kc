import Swal from 'sweetalert2';

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

function confetti() {
    $.each($(".particletext.confetti"), function(){
       var confetticount = ($(this).width()/50)*10;
       for(var i = 0; i <= confetticount; i++) {
          $(this).append('<span class="particle c' + $.rnd(1,2) + '" style="top:' + $.rnd(10,50) + '%; left:' + $.rnd(0,100) + '%;width:' + $.rnd(6,8) + 'px; height:' + $.rnd(3,4) + 'px;animation-delay: ' + ($.rnd(0,30)/10) + 's;"></span>');
       }
    });
 }

 jQuery.rnd = function(m,n) {
    m = parseInt(m);
    n = parseInt(n);
    return Math.floor( Math.random() * (n - m + 1) ) + m;
}


 $( document ).ready(function() {
    confetti();
});

window.showReportOtherBanks = function()
{
    $('#new_banks').show();
}

window.changeCreditBank = function(credit_id, id)
{

    let bank_id = id;
    if (id == null) {
        bank_id = $('#report-bank-id').val();
    }

    axios
    .post('/panel/credit/storeBank', {credit_id:credit_id, bank_id:bank_id})
    .then(function (response) {
        let result = response.data;
        window.location.reload();

    })
    .catch(e => {
        // Manejar errores
    });

}

window.closeCreditBank = function(credit_id, id)
{
    
}

window.deliveryFinish = function(id, statusid, urlredirect,  is_modal) 
{
    if (is_modal == true) {
        Swal.fire({
            title: '¿Estás seguro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'Mejor no'
        }).then(function (result) {
            if (result.value) {
                actionDeliveryFinish(id, statusid, urlredirect);
            }
        });
    } else {
        actionDeliveryFinish(id, statusid, urlredirect);
    }
    
}

function actionDeliveryFinish(id, statusid, urlredirect) {
    axios
    .get("/panel/action/"+id+"/"+statusid+"/finish")
    .then(function (response) {
       window.location = urlredirect;
    })
    .catch(e => {
        
    });
}

function verifificarTramitar(history_id, status_id,  credit_id, financial_id, type, is_tramitar)
{
    $('#content-bank').html('');
    $('#new_banks').hide();
    axios
    .get('/panel/kc-check-up/'+credit_id+'/'+type+'/report/verify')
    .then(function (response) {
        let result = response.data;
        let status = result.status;
        let banks = result.banks;
        if (status == 200) {
            let is_app = $('#is_app').val();
            axios
                .get("/panel/kc-check-up/report/desition/"+credit_id+"/"+financial_id+ "/" +type+"/accept")
                .then(function (response) {
                    console.log(response.data);
                    if (is_tramitar == 1) {
                        window.location = '/reporte/'+credit_id+'/status/finish?is_app='+is_app+'&is_tramitar=true';
                    } else {
                        //window.location = '/reporte/'+credit_id+'/status/finish?is_app='+is_app+'&type=1';
                        deliveryFinish(history_id, status_id, '/reporte/'+credit_id+'/status/finish?is_app='+is_app+'&type=1',  false)
                    }
                    
                })
                .catch(e => {
                });
        } else {
            $('#content-bank').html(banks);
            $('#modal-bank').modal('show');
        }
        
    })
    .catch(e => {
        
    });
}

window.desitionReport = function(credit_id, financial_id, type, is_tramitar) {
    verifificarTramitar(credit_id, financial_id, type, is_tramitar);
}

// Agregar un controlador de eventos a todos los enlaces dentro del iframe
var iframeLinks = document.querySelectorAll('.iframe-link');
for (var i = 0; i < iframeLinks.length; i++) {
  iframeLinks[i].addEventListener('click', function(event) {
    // Prevenir que el enlace se abra en el iframe
    event.preventDefault();
    // Redirigir al usuario fuera del iframe
    window.top.location.href = this.href;
  });
}

window.changeFilterReport = function(status, tipo, id)
{
    console.log(status);
    let titulo1 = ['Se mostrarán créditos que "SI" consultan buró de crédito', 'Se mostrarán créditos que "NO" consultan buró de crédito'];
    let titulo2 = ['Se mostrarán créditos que "SI" soliciten aval', 'Se mostrarán créditos que "NO" soliciten aval'];

    let titulo = titulo1[status];

    if (tipo == 2) {
        titulo = titulo2[status];
    }

    Swal.fire({
        title: titulo,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
      }).then(function (result) {
        if (result.value) {
            // Obtén referencia al formulario por su ID
            var form = document.getElementById('frm-filter');
            // Crea un objeto FormData con los datos del formulario
            var formData = new FormData(form);

            axios
                .post('/reporte/products/store', formData)
                .then(function (response) {
                    let result = response.data;
                    // Recargar la página
                    window.location.reload();

                })
                .catch(e => {
                    // Manejar errores
                });
        } else {
            //cancelar
            $("#" + id).prop("checked", !$("#" + id).prop("checked"));
        }
      });

    
}

window.infoFinanciera = function(product_id, section)
{
    axios
    .get('/reporte/'+product_id+'/info?section='+section)
    .then(function (response) {
        let result = response.data;
       $('#content-info').html(result.caracteristicas);
       $('#tabTramite').hide();
       $('#modal-info').modal('show');

    })
    .catch(e => {
        // Manejar errores
    });
}

$( "#frm-report-email" ).submit(function( event ) {
    event.preventDefault();
    // Obtén referencia al formulario por su ID
    var form = document.getElementById('frm-report-email');
    // Crea un objeto FormData con los datos del formulario
    var formData = new FormData(form);

    axios
        .post('/reporte/product/email/update', formData)
        .then(function (response) {
            let result = response.data;
            let credit_id = $('#credit_id').val();
            let is_app = $('#is_app').val();
            let is_email_update = $('#is_email_update').val();
            // Recargar la página
            window.location= '/reporte/'+credit_id+ '/status/finish?is_app='+is_app+'&is_email_update=true';

        })
        .catch(e => {
            // Manejar errores
        });
});

$(document).ready(function() {
    $('.select2multiple').select2({
        theme: "bootstrap-5",
        placeholder: "Escribe para buscar..",
        
    });
    
    if (document.getElementById('is_validate_modal_product')) {
        

        let is_validate_modal_product = $('#is_validate_modal_product').val();
        if (is_validate_modal_product == '0') {
            //$('#modal-product').modal('show');
        }
    }

    window.cancelModalProduct = function()
    {
        axios
            .get('/reporte/product/credit/notFound')
            .then(function (response) {
                window.location.reload();

            })
            .catch(e => {
                // Manejar errores
            });
    }

    window.continueModalProduct = function()
    {
        // Obtén referencia al formulario por su ID
        var form = document.getElementById('frm-modal-product');
        // Crea un objeto FormData con los datos del formulario
        var formData = new FormData(form);

        axios
            .post('/reporte/product/credit/update', formData)
            .then(function (response) {
                window.location.reload();

            })
            .catch(e => {
                // Manejar errores
            });
    }
});

