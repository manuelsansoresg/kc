import { showInfo } from '../utilities';

var refresh = {
    'newCredit': creditRefresh,
}

$().ready(function () {

    $("#frm-template_new_credit").validate({
        rules: {
            'agreement_id': {
                required: true,
            },
            'name': {
                required: true,
            },

            'last_name': {
                required: true,
            },
            'cellphone': {
                required: true,
                number: true,
                minlength: 10
            },
            'data[channel_id]': {
                required: true,
            },
            'new_agreement': {
                required: function (element) {
                    let lead_agreement = $("#lead-agreement").val();
                    if (lead_agreement == 0) {
                        return true;
                    } else {
                        return false;
                    }
                }
            },

        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_new_credit', 'newCredit');
        }
    });
    
    let id_rel = $('#id_rel').val();

    axios
    .get("/panel/action-form/"+id_rel)
    .then(function (response) {
      let result = response.data;
      let credit = result.credit;
      let client = result.client;
      $('#lead-agreement').val(credit.agreement_id).trigger("change");
      $('#name').val(client.name);
      $('#last_name').val(client.last_name);
      $('#second_last_name').val(client.second_last_name);
      $('#cellphone').val(client.cellphone);
    })
    .catch(e => {
    });
});


function saveForm(id_form, model) {
    const new_form = document.getElementById(id_form);
    const data = new FormData(new_form);
    let id_rel = $('#id_rel').val();
    data.append('model', model);
    data.append('id_rel', id_rel);
    axios
        .post("/panel/action-form", data)
        .then(function (response) {
            let result = response.data;
            window.history.back();
        })
        .catch(e => {
        });
}