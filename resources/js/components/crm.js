
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

window.moveModal = function(title, id, statusid, old_status_id, dt) {
    $('#frm-archive').trigger("reset");
    $('#id_rel').val(id);
    $('#statusid').val(statusid);
    $('#title').val('Crédito');
    $('#old_status_id').val(old_status_id);
    $('#dt').val(dt);
    $('#modal-archive-title').html(title);
    getReason(title);
    $('#modal-archive').modal('show');
}

window.moveModalLead = function(title, id, statusid, old_status_id, dt) {
    $('#frm-archive').trigger("reset");
    $('#id_rel').val(id);
    $('#statusid').val(statusid);
    $('#title').val('Prospecto');
    $('#old_status_id').val(old_status_id);
    $('#dt').val(dt);
    $('#modal-archive-title').html(title);
    getReason('ArchivarLead');
    $('#modal-archive').modal('show');
}


if (document.getElementById('frm-archive')) {
    NioApp.Select2('#modal-reason-id', {
        dropdownParent: $('#modal-archive')
    });
}


$( "#frm-archive" ).submit(function( event ) {
    event.preventDefault();
    
    let id_rel = $('#id_rel').val();
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
        let result = response.data;
        $('#modal-validate-content').html(result);
        $('#modal-validate').modal('show');
    })
    .catch(e => {
        
    });
}

window.desition = function(credit_id, financial_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'Mejor no'
    }).then(function (result) {
        if (result.value) {
            axios
            .get("/panel/kc-check-up/report/desition/"+credit_id+"/"+financial_id+"/accept")
            .then(function (response) {
                let reason = response.data;
                window.location = '/panel/kc-check-up';
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