import { showInfo, addEmptySelectSearch } from '../utilities';


window.actionModal = function (id, is_new, is_lead) {
    let model = is_lead == true ? 'lead' : 'credit';
    let section = is_lead == true ?  1 : 2;

    resetAction();
    getAdvisorLead(model, id);
   
    $('#modal-action-id-rel').val(id);
    $('#modal-action-id-section').val(section);
    if (is_new == 'true') {
        $('#modal-action-id-action').val(null);
    }
   
    $('#modal-action').modal('show');

}

window.addActionIntoActions = function(id, is_new, is_lead)
{
    $('#modal-list-actions').modal('hide');

    let model = is_lead == true ? 'lead' : 'credit';
    let section = is_lead == true ?  1 : 2;

    resetAction();
    getAdvisorLead(model, id);
   
    $('#modal-action-id-rel').val(id);
    $('#modal-action-id-section').val(section);
    if (is_new == 'true') {
        $('#modal-action-id-action').val(null);
    }
   
    $('#modal-action').modal('show');

}


if (document.getElementById('frm-action')) {
    $('#modal-action-type').select2({
        dropdownParent: $('#modal-action'),
        placeholder: "Escribe para buscar..",
        allowClear: true
    });
   
}

function getAdvisorLead(model, id_rel) {
    axios
        .get("/panel/"+model+"/" + id_rel+'/advisor/show')
        .then(function (response) {
            let result              = response.data;
            let advisor             = result.advisor;

            if (advisor != null) {
                let name_advisor = advisor.name + ' ' + advisor.last_name;
                $("#lead-asesor-id").prepend("<option value='" + advisor.id + "' selected='selected'> " + name_advisor + "</option>");
                $("#lead-asesor-id").prop("disabled", true);

            }
            
        })
        .catch(e => {

        });
} 

/* function getPerson(lead_id) {
    axios
        .get("/panel/lead/" + lead_id)
        .then(function (response) {
            let result = response.data;
            let lead = result.lead;
            let lead_name = lead.name + ' ' + lead.last_name;
            $("#modal-action-id-rel-lead").prepend("<option value='" + lead.id + "' selected='selected'> " + lead_name + "</option>");
        })
        .catch(e => {

        });
} */

$().ready(function () {
    $("#frm-action").validate({
        rules: {
            'data[type]': {
                required: true,
            },
            'data[start_date]': {
                required: true,
            },
            'data[advisor_id]': {
                required: true,
            },
            'data[start_time]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const new_form = document.getElementById("frm-action");
            const data = new FormData(new_form);
            let refresh_dt = $('#refresh-dt').val();
            axios
                .post("/panel/action", data)
                .then(function (response) {
                    let result = response.data;
                    let status = $('#modal-action-status').val();
                    let id_action = $('#modal-action-id-action').val();
                    console.log(status);
                    if (status == 1 && result != null) { //*se marco como completada

                        $('#register-action-id-rel').val(result.id);
                        $('#modal-action').modal('hide');
                        resetRegisterAction();
                        if (id_action == 'null') {
                            $('#modal-register-action').modal('show');
                        }
                    } else {
                        $('#modal-action').modal('hide');
                        if (document.getElementById('is_refresh')) {
                            location.reload(); // Recargar la página
                        }
                        if (refresh_dt != 'null') {
                            showInfo(2, refresh_dt, 'Datos actualizados', 'Registro guardado');
                        } else {
                            refreshListActions();
                        }
                    }
                    //refreshListActions();
                })
                .catch(e => {
                });

        }
    });
});

function resetAction() {
    $('#frm-action input, textarea, select').removeAttr('disabled');
    $('#modal-action-save').show();
    $("#modal-action-type").val('').trigger('change');
    $('#modal-action-subject').val('');
    $('#modal-action-start_date').val('');
    $('#modal-action-end_date').val('');
    $('#modal-action-description').val('');
    $('#modal-action-id-action').val('null');
    $('#modal-action-complete-pending').prop("checked", true);
    
    $("#lead-asesor-id").val('').trigger('change');
    $("#lead-asesor-id").prop("disabled", false);
    
}

function resetRegisterAction() {
    $("#frm-register-action-state").val('').trigger('change');
    $('#frm-register-action-comment').val('');
    $('#frm-register-action-preview').html('');
    //myDropzone.removeAllFiles(true); 

}

window.deleteFile = function (model, id) {
    $('#frm-register-action-preview').html('');
    axios
        .get("/panel/temp/images/" + id + "/delete")
        .then(function (response) {
            showInfo(2, 'dt-lead', 'Archivos', 'Archivo borrado');
            reloadFile(model);

        })
        .catch(e => {
        });
}

function reloadFile(model) {
    axios
        .get("/panel/temp/images/" + model + '/show')
        .then(function (response) {
            $('#frm-register-action-preview').html(response.data);
        })
        .catch(e => {

        });
}

$('#frm-action input').on('change', function () {
    let status = $('input[name=status]:checked', '#frm-action').val();
    $('#modal-action-status').val(status);
});

//*form register action
$().ready(function () {
    $("#frm-register-action").validate({
        rules: {
            'data[state]': {
                required: true,
            },
            'data[comment]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const new_form = document.getElementById("frm-register-action");
            const data = new FormData(new_form);
            let refresh_dt = $('#refresh-dt').val();
            
            axios
                .post("/panel/register-action", data)
                .then(function (response) {
                    let result = response.data;
                    $('#modal-register-action').modal('hide');
                    if (refresh_dt != 'null') {
                        /* showInfo(2, refresh_dt, 'Datos actualizados', 'Registro guardado');
                        refreshListActions(); */
                        location.reload();
                    } else {
                        refreshListActions();
                    }
                })
                .catch(e => {
                });

        }
    });
});


window.modalRegisterAction = function (model, id) {
    resetRegisterAction();
    
    axios
    .get("/panel/register-action/set-id/"+id+'/set')
    .then(function (response) {

    })
    .catch(e => {
    });
    
    axios
    .get("/panel/register-action/set-model/"+model+'/set')
    .then(function (response) {

    })
    .catch(e => {
    });
    $('#register-action-model').val(model);
    $('#register-action-id-rel').val(id);
    $('#modal-register-action').modal('show');
}

window.setIdRel = function() {
    
}

window.deleteRegisterAction = function(action_id) {
    let refresh_dt = $('#refresh-dt').val();
    axios
    .delete("/panel/register-action/"+action_id)
    .then(function (response) {
        if (refresh_dt != 'null') {
            showInfo(2, refresh_dt, 'Datos actualizados', 'Registro guardado');
            refreshListActions();
        } else {
            refreshListActions();
        }
    })
    .catch(e => {
    });
}

window.alerDeleteAction = function (id) {
   
    Swal.fire({
        title: '¿Estás seguro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, elimina',
        cancelButtonText: 'Mejor no'
    }).then(function (result) {
        if (result.value) {
            deleteAction(id);
        }
    });
}

window.deleteAction = function (id) {
    let refresh_dt = $('#refresh-dt').val();
    axios
    .delete("/panel/action/"+id)
    .then(function (response) {

        if (document.getElementById('modal-list-actions')) {
            location.reload(); // Recargar la página
        }

        if (refresh_dt != 'null') {
            showInfo(2, refresh_dt, 'Datos actualizados', 'Registro guardado');
        } else {
            refreshListActions();
        }
    })
    .catch(e => {
    });
}


/* window.editModalAction = function(action_id, disabled) {
    setModalAction(action_id, disabled);
    $('#modal-action').modal('show');
} */

window.setModalAction = function (action_id, disabled, section) {
    
    if (disabled == true) {
        $('#frm-action input, textarea, select').attr('disabled', 'disabled');
        $('#modal-action-save').hide();
    } 
    
    axios
    .get("/panel/action/"+action_id)
    .then(function (response) {
        
        let result = response.data;
        let action = result.action;
        let advisor = result.advisor;
        let lead = result.lead;
        //*set value form action
        if (result != null) {
            let lead_name = (lead != null) ? lead.name + ' ' + lead.last_name : null;
            
            $("#modal-action-type").val(action.type).trigger('change');
            $("#modal-action-subject").val(action.subject);
            $("#modal-action-id-action").val(action_id);
            $("#modal-action-subject").val(action.subject);
            $("#modal-action-id-section").val(action.section);
            $("#modal-action-status").val(action.status);
            $("#modal-action-start_date").val(action.start_date);
            $("#modal-action-start_time").val(action.start_time);
            $("#modal-action-end_date").val(action.end_date);
            $("#modal-action-description").val(action.description);
            $("#modal-action-id-rel").val(action.id_rel);
            
            $('#modal-action').modal('show');

            $('#lead-asesor-id').val(action.advisor_id).trigger("change");
            
            if (action.status == 1) {
                $('#modal-action-complete-active').prop("checked", true);
                $('#modal-action-complete-pending').prop("checked", false);
            } else {
                $('#modal-action-complete-active').prop("checked", false);
                $('#modal-action-complete-pending').prop("checked", true);
            }
            $('#modal-action').modal('show');
        }
        
    })
    .catch(e => {
    });
}

window.refreshAction = function(id, model, status, content) {
    if (!id || !model || !status || !content) {
        // Si falta algún valor, no hacer nada
        return;
    }
    $('#' + content).html('');
    axios
        .get("/panel/action/list/" + id + "/" + model + "/" + status)
        .then(function(response) {
            $('#' + content).html(response.data);
        })
        .catch(e => {
            // Manejo de error opcional
        });
}
window.refreshListActions = function() {
    let id_rel    = $('#id-rel-action').val();
    let model     = $('#model-action').val();

    refreshAction(id_rel, model, 'in_progress', 'content-profile-in_progress')
    refreshAction(id_rel, model, 'completed', 'content-profile-completed')
}
if (document.getElementById('content-profile-in_progress')) {
    refreshListActions();
}



