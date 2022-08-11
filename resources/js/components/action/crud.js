import { showInfo } from '../utilities';

window.actionModal = function(id)
{
    if (document.getElementById('modal-action-id-rel-lead')) {
        getPerson(id);
    }
    resetAction();
    $('#modal-action-id-rel').val(id);
    $('#modal-action').modal('show');

}

if (document.getElementById('frm-action')) {
    $('#modal-action-type').select2({
        dropdownParent: $('#modal-action'),
        placeholder: "Escribe para buscar..",
        allowClear: true
    });
}
function getPerson(lead_id) {
    axios
    .get("/panel/lead/"+lead_id)
    .then(function (response) {
        let result = response.data;
        let lead = result.lead;
        let lead_name = lead.name+' '+lead.last_name;
        $("#modal-action-id-rel-lead").prepend("<option value='"+lead.id+"' selected='selected'> "+lead_name+"</option>");
    })
    .catch(e => {
        
    });
}

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
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const new_form = document.getElementById("frm-action");
            const data = new FormData(new_form);

            axios
                .post("/panel/action", data)
                .then(function (response) {
                    let result    = response.data;
                    let status    = $('#modal-action-status').val();
                    if (status == 1 && result != null) { //*se marco como completada
                        $('#register-action-id-rel').val(result.id);
                        $('#modal-action').modal('hide');
                        $('#modal-register-action').modal('show');
                    } else {
                        $('#modal-action').modal('hide');
                        showInfo(2, 'dt-lead', 'Datos actualizados', 'Registro guardado');
                    }
                })
                .catch(e => {
                });

        }
    });
});

function resetAction() {
    $("#modal-action-type").val('').trigger('change');
    $('#modal-action-subject').val('');
    $('#modal-action-start_date').val('');
    $('#modal-action-end_date').val('');
    $('#modal-action-description').val('');
}



$('#frm-action input').on('change', function() {
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

            axios
                .post("/panel/register-action", data)
                .then(function (response) {
                    let result    = response.data;
                    $('#modal-register-action').modal('hide');
                    showInfo(2, 'dt-lead', 'Datos actualizados', 'Registro guardado');
                })
                .catch(e => {
                });

        }
    });
});