

require('./components/toastr');
require('./components/notification/utilities');
require('./components/datatable');
require('./components/user/crud');
require('./components/user/datatable_admin');
require('./components/user/datatable_financiera');
require('./components/product/datatable_product');
require('./components/product/crud');
require('./components/agreement/datatable');
require('./components/agreement/crud');
require('./components/lead/datatable');
require('./components/lead/crud');
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
require('./components/websocket');
