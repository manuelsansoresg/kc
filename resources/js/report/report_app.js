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


window.desitionReport = function(credit_id, financial_id, type) {
    let is_app = $('#is_app').val();
    let url = "/panel/kc-check-up/report/desition/"+credit_id+"/"+financial_id+ "/" +type+"/accept";
   Swal.fire({
       title: '¿Estás seguro?',
       icon: 'warning',
       showCancelButton: true,
       confirmButtonText: 'Sí',
       cancelButtonText: 'Mejor no'
   }).then(function (result) {
    if (result.isConfirmed) {
        axios
        .get(url)
        .then(function (response) {
            let reason = response.data;
            window.location = '/reporte/'+credit_id+'/status/finish?is_app='+is_app;
        })
        .catch(e => {
            
        });
    }
   });
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

