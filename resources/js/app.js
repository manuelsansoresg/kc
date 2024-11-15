

require('./components/toastr');
require('./components/notification/utilities');
require('./components/datatable');
require('./components/user/crud');
require('./components/user/datatable_admin');
require('./components/user/datatable_financiera');
require('./components/user/datatable_inversionista');
require('./components/user/datatable_user');
require('./components/product/datatable_product');
require('./components/product/crud');
require('./components/agreement/datatable');
require('./components/agreement/crud');
require('./components/lead/datatable');
require('./components/lead/crud');

require('./components/clients/datatable');
require('./components/clients/crud');

require('./components/tag/datatable');
require('./components/tag/crud');
require('./components/financial/datatable');
require('./components/financial/crud');
require('./components/financial/product/datatable');
require('./components/financial/product/crud');

require('./components/crm');
require('./components/action/datatable');
require('./components/action/crud');
require('./components/action/credit');
require('./components/general');

require('./components/module/datatable');
require('./components/module/template');
require('./components/module/resumen');
require('./components/module/kc_check_up/datatable');
require('./components/module/kc_check_up/action/datatable');
require('./components/module/kc_check_up/action/datatable_report');
require('./components/module/kc_control_desk/datatable');
require('./components/module/kc_control_desk/reference');

require('./components/action/datatablemodule');
require('./components/credit/profile/datatable');
require('./components/credit/product/datatable');
require('./components/credit/datatable_in_progress');


window.moveElement = function (section, id, idDatatable) {
     // Deshabilita el botón para evitar clics múltiples
     const button = document.querySelector('.moveElement');
     button.disabled = true;

    axios
    .get("/panel/"+section+"/"+id+"/move")
    .then(function (response) {
        if (idDatatable == null) {
            location.reload();
        } else {
            $('#'+idDatatable).DataTable().ajax.reload();
        }
    })
    .catch(e => {
    })
    .finally(() => {
        // Habilita el botón nuevamente después de que se complete la solicitud Axios
        button.disabled = false;
    });
    
}

window.msgProfile = function () {
    Swal.fire({
        title: 'Este usuario no tiene ningún trámite',
        icon: 'warning',
        showCancelButton: true,
        showConfirmButton: false,
        //confirmButtonText: 'Sí, elimina',
        cancelButtonText: 'Cerrar'
    });
}

window.isAccess = function() {
    axios
    .get("/user/tyc/validate")
    .then(function (response) {
        let result = response.data;
        let is_block = result.is_block;
        if (is_block == true) {
            $('#modal-access').modal('show');
        } else {
            $('#modal-access').modal('hide');
        }
    })
    .catch(e => {
    });
}

$( "#frm-tyc" ).submit(function( event ) {
    event.preventDefault();
    const new_form    = document.getElementById('frm-tyc');
    const data        = new FormData(new_form);

    axios.post("/panel/user/tyc/accept", data)
    .then(function (response) {
        $('#modal-access').modal('hide');
        isAccess();
        
    })
    .catch(e => {
    });
});

$().ready(function () {
   
    isAccess();
    var myModalEl = document.getElementById('modal-access')
    myModalEl.addEventListener('hidden.bs.modal', function (event) {
        isAccess();
    })

    
});

/* $( "#frm-contact" ).submit(function( event ) {
    event.preventDefault();
    alert('test');
    const new_form    = document.getElementById('frm-contact');
    const data        = new FormData(new_form);
    axios.post("/contact", data)
    .then(function (response) {
        
    })
    .catch(e => {
    });
});

 */

tippy(document.querySelectorAll('.active-tooltip'), {
    content(reference) {
      const id = reference.getAttribute('data-template');
      const template = document.getElementById(id);
      return template.innerHTML;
    },
    allowHTML: true,
  });


  /* grafica dona investors */
  if (document.getElementById('TrafficChannelDoughnutData')) {
    let disponiblePrestaroRetirar = $('#disponiblePrestaroRetirar').val();
    let procesoPrestado = $('#procesoPrestado').val();
    let prestamoCreditosActivos = $('#prestamoCreditosActivos').val();

    var TrafficChannelDoughnutData = {
      labels: ["Disponible para prestar o retirar", "En proceso de ser prestado", "Préstamos en créditos activos"],
      dataUnit: 'People',
      legend: false,
      datasets: [{
        borderColor: "#fff",
        background: ["#798bff", "#b8acff", "#ffa9ce", "#f9db7b"],
        data: [disponiblePrestaroRetirar, procesoPrestado, prestamoCreditosActivos]
      }]
    };
    function analyticsDoughnut(selector, set_data) {
      var $selector = selector ? $(selector) : $('.analytics-doughnut');
      $selector.each(function () {
        var $self = $(this),
          _self_id = $self.attr('id'),
          _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;
        var selectCanvas = document.getElementById(_self_id).getContext("2d");
        var chart_data = [];
        for (var i = 0; i < _get_data.datasets.length; i++) {
          chart_data.push({
            backgroundColor: _get_data.datasets[i].background,
            borderWidth: 2,
            borderColor: _get_data.datasets[i].borderColor,
            hoverBorderColor: _get_data.datasets[i].borderColor,
            data: _get_data.datasets[i].data
          });
        }
        var chart = new Chart(selectCanvas, {
          type: 'doughnut',
          data: {
            labels: _get_data.labels,
            datasets: chart_data
          },
          options: {
            plugins: {
              legend: {
                display: _get_data.legend ? _get_data.legend : false,
                labels: {
                  boxWidth: 12,
                  padding: 20,
                  color: '#6783b8'
                }
              },
              tooltip: {
                enabled: true,
                rtl: NioApp.State.isRTL,
                callbacks: {
                  label: function label(context) {
                    return "".concat(context.parsed, " ").concat(_get_data.dataUnit);
                  }
                },
                backgroundColor: '#fff',
                borderColor: '#eff6ff',
                borderWidth: 2,
                titleFont: {
                  size: 13
                },
                titleColor: '#6783b8',
                titleMarginBottom: 6,
                bodyColor: '#9eaecf',
                bodyFont: {
                  size: 12
                },
                bodySpacing: 4,
                padding: 10,
                footerMarginTop: 0,
                displayColors: false
              }
            },
            rotation: -1.5,
            cutoutPercentage: 70,
            maintainAspectRatio: false
          }
        });
      });
    }
    // init chart
    NioApp.coms.docReady.push(function () {
      analyticsDoughnut();
    });
  }

  require('./components/websocket');


