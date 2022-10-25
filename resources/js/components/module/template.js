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
    //* save form  control desk step 1
    $("#frm-template_control_desk_step1").validate({
        rules: {
            'credit[payment_capacity_period]': {
                required: true,
            },
            'credit[payment_capacity]': {
                required: true,
            },

            'client_person[birth_date]': {
                required: true,
            },
            'client_person[labor_old]': {
                required: true,
            },
            'client_person[employee_category]': {
                required: true,
            },


        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_control_desk_step1', 'controlDesk');
        }
    });

    $("#frm-template_control_desk_step2").validate({
        rules: {
            'credit[applied_financial_product]': {
                required: true,
            },
            'credit[applied_loan_type]': {
                required: true,
            },

            'credit[applied_import]': {
                required: true,
            },
            'credit[applied_term]': {
                required: true,
            },
            'credit[applied_periodicity]': {
                required: true,
            },
            'credit[applied_payment]': {
                required: true,
            },
            'credit[applied_loan_total_amount]': {
                required: true,
            },
            'credit[applied_interest_rate]': {
                required: true,
            },
            'credit[applied_CAT]': {
                required: true,
            },


        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_control_desk_step2', 'controlDesk');
        }
    });

    //*get data
    if (document.getElementById('id_rel')) {
        let id_rel = $('#id_rel').val();
        let type_form = $('#type_form').val();

        if (id_rel != '') {
            axios
                .get("/panel/action-form/" + id_rel)
                .then(function (response) {
                    let result = response.data;
                    let credit = result.credit;
                    let client = result.client;
                    if (type_form == 8) { //checkup
                        $('#lead-agreement').val(credit.agreement_id).trigger("change");
                        $('#name').val(client.name);
                        $('#last_name').val(client.last_name);
                        $('#second_last_name').val(client.second_last_name);
                        $('#cellphone').val(client.cellphone);
                    }

                    if (type_form == 12) //reduccion
                    {
                        $('#lead-agreement').val(credit.agreement_id).trigger("change");
                        $('#lead-financial_id').val(credit.financial_id).trigger("change");
                        $('#current_payment').val(credit.current_payment / 100);
                        $('#current_periodicity').val(credit.current_periodicity).trigger("change");
                        $('#current_loan').val(credit.current_loan / 100);
                        $('#current_term').val(credit.current_term);
                        $('#current_principal_balance').val(credit.current_principal_balance / 100);
                        $('#current_total_balance').val(credit.current_total_balance / 100);
                    }

                    if (type_form == 23) //form kc-desktop step1
                    {
                        $('#payment_capacity_period').val(credit.payment_capacity_period);
                        $('#payment_capacity').val(credit.payment_capacity);

                        $('#birth_date').val(client.birth_date);
                        $('#labor_old').val(client.labor_old);
                        $('#employee_category').val(client.employee_category);
                    }

                    if (type_form == 24) //form kc-desktop step2
                    {
                        $('#applied_financial').val(credit.applied_financial).trigger("change");
                        $('#applied_financial_product').val(credit.applied_financial_product).trigger("change");
                        $('#applied_loan_type').val(credit.applied_loan_type).trigger("change");
                        $('#applied_loan_discount').val(credit.applied_loan_discount);
                        $('#applied_sign_type').val(credit.applied_sign_type).trigger("change");
                        $('#applied_import').val(credit.applied_import);
                        $('#applied_term').val(credit.applied_term);
                        $('#applied_periodicity').val(credit.applied_periodicity).trigger("change");
                        $('#applied_payment').val(credit.applied_payment);
                        $('#applied_loan_total_amount').val(credit.applied_loan_total_amount);
                        $('#applied_interest_rate').val(credit.applied_interest_rate);
                        $('#applied_CAT').val(credit.applied_CAT);
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