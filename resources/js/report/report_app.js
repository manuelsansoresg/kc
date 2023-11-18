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

function verifificarTramitar(credit_id, type)
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
            let url = "/panel/kc-check-up/report/desition/"+credit_id+"/"+financial_id+ "/" +type+"/accept";
            axios
                .get(url)
                .then(function (response) {
                    let reason = response.data;
                    if (is_tramitar == 1) {
                        window.location = '/reporte/'+credit_id+'/status/finish?is_app='+is_app;
                    } else {
                        window.location = '/reporte/'+credit_id+'/status/finish?is_app='+is_app+'&type=1';
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
    verifificarTramitar(credit_id, financial_id);
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

window.changeFilterReport = function(status, tipo)
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
        }
      });

    
}

/* if (document.getElementById('content-products')) {
    refreshReportProduct();
}

function refreshReportProduct ()
{
    
    axios
        .get('/reporte/products/show')
        .then(function (response) {
            let result = response.data;
            $('#content-products').html(result.view);
            Livewire.emit('reportRefresh');
            
        })
        .catch(e => {
            
        });
} */