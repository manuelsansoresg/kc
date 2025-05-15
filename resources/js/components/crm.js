
import { showInfo } from './utilities';


function move(id, form, modal, datatable, title, msg){

    const new_form = document.getElementById(form);
    const data = new FormData(new_form);
    
    let statusid = $('#statusid').val();
    let old_status_id = $('#old_status_id').val();

    axios
    .post("/panel/action/"+id+"/"+statusid+"/"+old_status_id+"/move", data)
    .then(function (response) {
        $('#'+modal).modal('hide');
        showInfo(2, datatable, title, msg);
    })
    .catch(e => {
        
    });
}

window.moveCrm = function (creditId, statusid, old_status_id, redirect){


    axios
    .post("/panel/action/"+creditId+"/"+statusid+"/"+old_status_id+"/move")
    .then(function (response) {
        window.location = redirect;
    })
    .catch(e => {
        
    });
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

window.moveModal = function(title, id, statusid, old_status_id, dt) {
    $('#frm-archive').trigger("reset");
    $('#modal_archive_id_rel').val(id);
    $('#statusid').val(statusid);
    $('#title').val('Crédito');
    $('#old_status_id').val(old_status_id);
    $('#dt').val(dt);
    $('#modal-archive-title').html(title);
    getReason(title);
    if (title == 'Archivar' || title ==  'Cancelar') {
        $('#content-lead').show();
    }
    $('#modal-archive').modal('show');
}

window.moveModalLead = function(title, id, statusid, old_status_id, dt) {
    $('#frm-archive').trigger("reset");
    $('#modal_archive_id_rel').val(id);
    $('#statusid').val(statusid);
    $('#title').val('Prospecto');
    $('#old_status_id').val(old_status_id);
    $('#dt').val(dt);
    $('#modal-archive-title').html(title);
    getReason('ArchivarLead');
    $('#content-lead').show();
    $('#modal-archive').modal('show');
}


if (document.getElementById('frm-archive')) {
    NioApp.Select2('#modal-reason-id', {
        dropdownParent: $('#modal-archive')
    });
}

window.concluir = function (history_id) {
    axios
    .get('/panel/action/'+history_id+'/complete')
    .then(function (response) {
        let result = response.data;
       window.location = result.url;
    })
    .catch(e => {
        
    });
}

$( "#frm-archive" ).submit(function( event ) {
    event.preventDefault();
    
    let id_rel = $('#modal_archive_id_rel').val();
    let dt = $('#dt').val();
    let msg = 'Cambios aplicados correctamente';
    let title = $('#title').val();
    move(id_rel, 'frm-archive', 'modal-archive', dt, title, msg);
});


window.modalValidate = function(id, model){
    $('#modal-validate-content').html('');
    axios
    .get('/panel/'+id+'/'+model+'/validate/show')
    .then(function (response) {
        let html = response.data.table;
        $('#modal-validate-content').html(html);
        $('#modal-validate').modal('show');
    })
    .catch(e => {
        
    });
}



window.desition = function(history_id, credit_id, financial_id, type, status_id, is_elegir) {
    let url_redirect = type == 1 ? '/panel/kc-check-up' : '/panel/kc-swap';
    let param_get =  is_elegir == 0 ? '?is_notify=true' : '?is_notify=false';
    
    Swal.fire({
        title: '¿Estás seguro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'Mejor no'
    }).then(function (result) {
        if (result.value) {
            axios
            .get("/panel/kc-check-up/report/desition/"+credit_id+"/"+financial_id+ "/" +type+"/accept"+param_get)
            .then(function (response) {
                let reason = response.data;
                if (is_elegir == 0) {
                    deliveryFinish(history_id, status_id, url_redirect,  false);
                } else {
                    window.location = url_redirect;
                }
            })
            .catch(e => {
                
            });
        }
    });
}

function getReason(type) {
    $('#modal-reason-id').empty();
    axios
    .get("/panel/reason/"+type+"/list")
    .then(function (response) {
        let reason = response.data;
        var modal_reason_id = $('#modal-reason-id');
        for (const key in reason) {
            const element = reason[key];
            var option = new Option(element, key, true, true);
            modal_reason_id.append(option).trigger('change');
            
        }
        $('#modal-reason-id').val('').trigger('change');
        if (financials != null) {
        }
    })
    .catch(e => {
        
    });
}

$(document).ready(function(){
    var pathArray = window.location;
    const params = new URLSearchParams(pathArray.search)
    let param_cancel = params.get("swap_cancel");
    if (param_cancel != null) {
        moveModal('Cancelar', param_cancel, 17, 37, 'dt-product-credit');
    }
})