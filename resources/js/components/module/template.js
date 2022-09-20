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
    //*form save debt credit strategy
    $("#frm-template_debt_credit").validate({
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
            'financial_id': {
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
            saveForm('frm-template_debt_credit', 'debtCredit');
        }
    });

    //*get data
    if (document.getElementById('id_rel')) {
        let id_rel = $('#id_rel').val();
        if (id_rel != '') {
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
              if (document.getElementById('current_principal_balance'))
              {
                $('#current_payment').val(credit.current_payment/100);
                $('#current_periodicity').val(credit.current_periodicity).trigger("change");
                $('#current_loan').val(credit.current_loan/100);
                $('#current_term').val(credit.current_term);
                $('#current_principal_balance').val(credit.current_principal_balance/100);
                $('#current_total_balance').val(credit.current_total_balance/100);
              }
            })
            .catch(e => {
            });
        }
    }
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