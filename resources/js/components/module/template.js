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
            'url_redirect_next': {
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
           /*  'credit[applied_financial_product]': {
                required: true,
            },
            'credit[applied_loan_type]': {
                required: true,
            }, */

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
            let input_loan = $('#input_loan').val();
            let applied_import = $('#applied_import').val();
            if (input_loan != '' && parseFloat(applied_import) > parseFloat(input_loan)) {
                Swal.fire({
                    text: 'El importe solicitado no puede ser mayor al disponible',
                    icon: 'warning',
                })
            } else {
                saveForm('frm-template_control_desk_step2', 'controlDesk');
            }
        }
    });
    
    $("#frm-template_control_desk_step2_task1").validate({
        rules: {
          

            'client_person[ID_primer_apellido]': {
                required: true,
            },
            'client_person[ID_segundo_apellido]': {
                required: true,
            },
            'client_person[ID_nombres]': {
                required: true,
            },
            'client_person[ID_vigencia]': {
                required: true,
            },
            


        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_control_desk_step2_task1', 'controlDesk');
        }
    });
    
    $("#frm-template_control_desk_step2_task2").validate({
        rules: {
          

            'client_person[ID_CIC]': {
                required: true,
                number: true,
                minlength: 9,
                maxlength:9
            },
            'client_person[ID_IDC]': {
                required: true,
                number: true,
                minlength: 9,
                maxlength:9
            },
            
            


        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_control_desk_step2_task2', 'controlDesk');
        }
    });
    
    $("#frm-template_control_desk_step2_task3").validate({
        
        rules: {
          

            'client_person[payroll_date]': {
                required: true,
            },
            'client_person[payroll_total]': {
                number: true,
                required: true,
            },
            
            


        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_control_desk_step2_task3', 'controlDesk');
        }
    });
    
    $("#frm-template_control_desk_dynamic_step2").validate({
        
        rules: {
            'pay_off[deadline_date]': {
                required: true,
            },
            'pay_off[ammount]': {
                number: true,
                required: true,
            },
            'pay_off[bank_clabe]': {
                required: true,
                number: true,
                minlength: 18,
                maxlength:18
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_control_desk_dynamic_step2', 'controlDesk');
        }
    });
    

    $("#frm-template_control_desk_step3_task3").validate({
        
        rules: {
            'credit[payroll_payment_capacity]': {
                required: true,
                required: true,
            },
           
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_control_desk_step3_task3', 'controlDesk');
        }
    });


    $("#frm-template_control_desk_step3_task").submit(function (event) {
        event.preventDefault();
        saveForm('frm-template_control_desk_step3_task', 'controlDesk');
    });


    window.getLoanAvailableByProduct = function(product) {
        $('#text-loan').html('');
        $('#input_loan').val('');
        let productId = product.value;
        

        $('#applied_loan_total_amount').val('');
        $('#applied_payment').val('');

        $('#applied_term').val('');
        $('#applied_interest_rate').val('');
        $('#applied_CAT').val('');
        
        axios
          .get("/panel/financial-product/" + productId)
          .then(function (response) {
            let result = response.data;
      
            if (result != null) {
              // Use Intl.NumberFormat for locale-aware currency formatting
              const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD', // Replace with your desired currency code
                minimumFractionDigits: 2, // Ensure at least two decimal places
              });
              let loan_available = result.loan_available == null || undefined ? 0 : result.loan_available;
              const formattedAmount = formatter.format(loan_available);
              $('#text-loan').html('Disponible: ' + formattedAmount);
              $('#input_loan').val(loan_available);
              $('#comision').val(result.sod_commission_amount);
              $('#producto').val(result.type_product_id);
              if (result.type_product_id == 6) {
                  $('#applied_term').val(1);
                  $('#applied_interest_rate').val(0);
                  $('#applied_CAT').val(0);
              }

              setBajoDemanda();
            }
          })
          .catch(e => {
            console.error('Error fetching loan available:', e);
          });
          
      };
      
      window.setBajoDemanda = function () {
        let comision = parseFloat($('#comision').val());
        
        const inputAppliedImport = document.getElementById('applied_import');
      
        inputAppliedImport.addEventListener('input', function() {
          let importeSolicitado = parseFloat(inputAppliedImport.value);
          let productId = $('#producto').val();
          if (productId == 6) {
            $('#applied_loan_total_amount').val(importeSolicitado + comision);
            $('#applied_payment').val(importeSolicitado + comision);
          }
        });
      };
      
    
    $("#frm-template_control_desk_step3_1").validate({
        rules: {
            'client_person[sex]': {
                required: true,
            },
            'client_person[rfc]': {
                required: true,
                minlength: 13,
                maxlength:13
            },
            
            'client_person[curp]': {
                required: false,
                minlength: 18,
                maxlength:18
            },
            'client_person[client_postal_code]': {
                required: false,
                number: true,
                minlength: 5,
                maxlength:5
            },
            'client_person[bank_name]': {
                required: true,
            },
           
            'client_person[bank_card_number]': {
                number: true,
                minlength: 16,
                maxlength:16
            },
            'client_person[bank_acount_number]': {
                number: true,
                minlength: 10,
                maxlength:10
            },
            'client_person[bank_clabe]': {
                number: true,
                minlength: 18,
                maxlength:18,
                required: true,
            },
            'client_person[monthly_income]': {
                required: false,
                number: true,
            },
            'client_person[workplace_postal_code]': {
                required: false,
                number: true,
                minlength: 5,
                maxlength:5
            },
            


        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_control_desk_step3_1', 'controlDesk');
        }
    });
    
    $("#frm-template_control_desk_step3_2").validate({
        rules: {
            'credit[interviewer]': {
                required: true,
            },
            /* domicilio */

            'client_person[client_postal_code]': {
                required: true,
                number: true,
                minlength: 5,
                maxlength:5
            },
            
            'client_person[client_street]': {
                required: true,
            },
            'client_person[client_home_external_number]': {
                required: true,
            },
            
            'client_person[client_colony]': {
                required: true,
            },
            'client_person[client_city]': {
                required: true,
            },
            'client_person[client_state]': {
                required: true,
            },
            'client_person[client_country]': {
                required: true,
            },

            'client_person[relative_local_phone]': {
                number: true,
                minlength: 10,
                maxlength:10
            },
            'client_person[relative_cel_phone]': {
                number: true,
                minlength: 10,
                maxlength:10
            },

            'client_person[home_time_living]': {
                number: true,
            },
            'client_person[propety_ownnership_amount]': {
                number: true,
            },
            'client_person[propety_ownnership_value]': {
                number: true,
            },
            'client_person[vehicle_ownnership_amount]': {
                number: true,
            },
            'client_person[vehicle_ownnership_value]': {
                number: true,
            },
            'client_person[economic_dependents]': {
                number: true,
            },
            'client_person[aditional_labor_income]': {
                number: true,
            },
            'client_person[workplace_local_phone]': {
                number: true,
                minlength: 10,
                maxlength:10
            },
            'client_person[workplace_cel_phone]': {
                number: true,
                minlength: 10,
                maxlength:10
            },
            'client_person[workplace_local_phone_extension]': {
                number: true,
            },
            
            'client_person[bank_card_number]': {
                number: true,
                minlength: 16,
                maxlength:16
            },
            'client_person[bank_acount_number]': {
                number: true,
                minlength: 10,
                maxlength:10
            },
            'client_person[bank_clabe]': {
                number: true,
                minlength: 18,
                maxlength:18
            },
            'client_person[monthly_income]': {
                required: true,
                number: true,
            },
            'client_person[workplace_postal_code]': {
                required: true,
                number: true,
                minlength: 5,
                maxlength:5
            },
            'client_person[workplace_street]': {
                required: true,
            },
            'client_person[workplace_home_external_number]': {
                required: true,
            },
            'client_person[workplace_home_internal_number]': {
                required: true,
            },
            'client_person[workplace_colony]': {
                required: true,
            },
            'client_person[workplace_city]': {
                required: true,
            },
            'client_person[workplace_state]': {
                required: true,
            },
            'client_person[workplace_country]': {
                required: true,
            },


        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_control_desk_step3_2', 'controlDesk');
        }
    });

    if (document.getElementById('frm-template_control_desk_step4')) {
        const form_control_desk_step4 = document.getElementById('frm-template_control_desk_step4');

        // Maneja el evento submit del formulario
        form_control_desk_step4.addEventListener('submit', (event) => {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente
        saveForm('frm-template_control_desk_step4', 'controlDesk');
        
        });
    }
   
    if (document.getElementById('frm-template_control_desk_step3_task4')) {
        const form_control_desk_step4 = document.getElementById('frm-template_control_desk_step3_task4');

        // Maneja el evento submit del formulario
        form_control_desk_step4.addEventListener('submit', (event) => {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente
        saveForm('frm-template_control_desk_step3_task4', 'controlDesk');
        
        });
    }
    
    if (document.getElementById('frm-template_control_desk_step3_task5')) {
        const form_control_desk_step4 = document.getElementById('frm-template_control_desk_step3_task5');

        // Maneja el evento submit del formulario
        form_control_desk_step4.addEventListener('submit', (event) => {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente
        saveForm('frm-template_control_desk_step3_task5', 'controlDesk');
        
        });
    }
    
    if (document.getElementById('frm-template_control_desk_dynamic_step3')) {
        const form_control_desk_step4 = document.getElementById('frm-template_control_desk_dynamic_step3');

        // Maneja el evento submit del formulario
        form_control_desk_step4.addEventListener('submit', (event) => {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente
        saveForm('frm-template_control_desk_dynamic_step3', 'controlDesk');
        
        });
    }

   

    
    
    if (document.getElementById('frm-template_control_desk_step4_task1')) {
        const form_control_desk_step4 = document.getElementById('frm-template_control_desk_step4_task1');

        // Maneja el evento submit del formulario
        form_control_desk_step4.addEventListener('submit', (event) => {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente
        saveForm('frm-template_control_desk_step4_task1', 'controlDesk');
        
        });
    }
    if (document.getElementById('frm-template_control_desk_step4_task2')) {
        const form_control_desk_step4 = document.getElementById('frm-template_control_desk_step4_task2');

        // Maneja el evento submit del formulario
        form_control_desk_step4.addEventListener('submit', (event) => {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente
        saveForm('frm-template_control_desk_step4_task2', 'controlDesk');
        
        });
    }

    window.openModalValidateControlDesk = function(creditId)
    {
        axios
            .get("/panel/template/validate/"+creditId+"/controlDesk")
            .then(function (response) {
                let result = response.data;
                $('#content-validate-control-desk').html(result);
                $('#modalValidateControlDesk').modal('show');
    
            })
            .catch(e => {
            });
    }
    


    $("#frm-template_control_desk_step5").validate({
        rules: {
            'credit[financial_user_assigned]': {
                required: true,
            },
            'credit[commission]': {
                required: true,
                number: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            TotalCredits();
            
        }
    });

    function TotalCredits()
    {
        let creditId = $('#id_rel').val();
        axios
        .get("/panel/client/" + creditId+"/credit/total")
        .then(function (response) {
            let result = response.data;
            let total = result.total;

            if (total > 1) {
                saveForm('frm-template_control_desk_step5', 'controlDesk');
            } else {
                Swal.fire({
                    title: 'Este es un cliente nuevo',
                    text : 'Confirmo que se incluyó el contrato de comisión mercantil para un cliente nuevo',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar'
                  }).then(function (result) {
                    if (result.value) {
                        saveForm('frm-template_control_desk_step5', 'controlDesk');
                    }
                  });
            }
        })
        .catch(e => {
        });

        
    }

    $("#frm-template_control_desk_step5_2").validate({
        rules: {
            'credit[signed]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_control_desk_step5_2', 'controlDesk');
        }
    });

    $("#frm-template_delivery_step2").validate({
        rules: {
            'credit[changed_commission]': {
                number: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_delivery_step2', 'delivery');
        }
    });
    
    $("#frm-template_delivery_task1_step1").validate({
        rules: {
            'credit[delivered]': {
                required: true,
            },
            'credit[delivered_date]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_delivery_task1_step1', 'delivery');
        }
    });

    if (document.getElementById('frm-template_delivery_step2_task1')) {
        const form_control_desk_step4 = document.getElementById('frm-template_delivery_step2_task1');

        // Maneja el evento submit del formulario
        form_control_desk_step4.addEventListener('submit', (event) => {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente
        saveForm('frm-template_delivery_step2_task1', 'delivery');
        
        });
    }
    
    if (document.getElementById('frm-template_delivery_step2_task2')) {
        const form_control_desk_step4 = document.getElementById('frm-template_delivery_step2_task2');

        // Maneja el evento submit del formulario
        form_control_desk_step4.addEventListener('submit', (event) => {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente
        saveForm('frm-template_delivery_step2_task2', 'delivery');
        
        });
    }
    
    $("#frm-template_delivery_dynamic_task_step1").validate({
        rules: {
            'credit_pay_off[delivered]': {
                required: true,
            },
            'credit_pay_off[delivered_date]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_delivery_dynamic_task_step1', 'delivery');
        }
    });
    
    $("#frm-template_payment_step2").validate({
        rules: {
            'credit[changed_commission]': {
                number: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_payment_step2', 'payment');
        }
    });
    
    
    $("#frm-template_delivery_step3").validate({
        rules: {
            'credit[payment_check]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_delivery_step3', 'delivery');
        }
    });
    
    $("#frm-template_payment_step3").validate({
        rules: {
            'credit[payment_check]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_payment_step3', 'payment');
        }
    });
   
    $("#frm-template_swap_step1").validate({
        rules: {
            'client_person[name]': {
                required: true,
            },
            'client_person[last_name]': {
                required: true,
            },
            'client_person[second_last_name]': {
                required: true,
            },
            'client_person[cellphone]': {
                required: true,
            },
            'client_person[email]': {
                required: true,
            },
            'client_person[rfc]': {
                required: true,
                minlength: 13,
                maxlength:13
            },
            'credit[id_number]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_swap_step1', 'swap');
        }
    });
    
    $("#frm-template_swap_step2").validate({
        rules: {
            'credit[url_sign]': {
                required: true,
                url: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_swap_step2', 'swap');
        }
    });
    
    $("#frm-template_swap_step2-2").validate({
        rules: {
            'credit[signed]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_swap_step2-2', 'swap');
        }
    });
    
    $("#frm-template_swap_step2-3").validate({
        rules: {
            'financial[email]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_swap_step2-3', 'swap');
        }
    });
   
    $("#frm-template_swap_step3").validate({
        rules: {
            'credit[termination_number]': {
                required: true,
            },
            'credit[termination_bank_name]': {
                required: true,
            },
            'credit[termination_bank_account_holder]': {
                required: true,
            },
            'credit[termination_bank_clabe]': {
                required: true,
            },
            'credit[termination_bank_reference]': {
                required: true,
            },
            'credit[termination_amount]': {
                required: true,
            },
            'credit[termination_deadline]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_swap_step3', 'swap');
        }
    });


    /* wallet */

    $("#frm-template_wallet_step1").validate({
        rules: {
            'transaction[investor_id]': {
                required: true,
            },
            'transaction[bank_transfer_type]': {
                required: true,
            },
            'transaction[amount]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_wallet_step1', 'wallet');
        }
    });

    //if exist implement onchange select
    window.getValue = function(get)
    {
        $('#content-legend').html('');
        let ordenante = get.value;
        axios
            .get("/panel/kc-wallet/" + ordenante+"/investor/get")
            .then(function (response) {
                let result = response.data;
                $('#content-legend').html(result);
            })
            .catch(e => {
            });
    }

    /* if (document.getElementById('type_form') && $('#type_form').val() == '66') {
        $('#content-legend-kc-down-bank').show();
    } */

    if(document.getElementById('frm-template_wallet_step1'))
    {
        const investorIdInput = document.getElementById('investor_id');
        // Check if investor_id element exists and is a hidden input
        if (investorIdInput && investorIdInput.type === 'hidden') {
            getValue(investorIdInput);
        
        }
    }
    
    $("#frm-template_wallet_step1_2").validate({
        rules: {
            'transaction[operation_status]': {
                required: true,
            },
           
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_wallet_step1_2', 'wallet');
        }
    });



    //* wallet-down
    $("#frm-template_wallet_down_step1").validate({
        rules: {
            'transaction[investor_id]': {
                required: true,
            },
            'transaction[amount]': {
                required: true,
            },
            
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            let withdraw_available = $('#withdraw_available').val();
            let amount = $('#amount').val();
            if (withdraw_available != '' && parseFloat(amount) > parseFloat(withdraw_available)) {
                Swal.fire({
                    text: 'El importe a retirar debe ser menor  al disponible para el retiro',
                    icon: 'warning',
                })
            } else {
                saveForm('frm-template_wallet_down_step1', 'kc-down-wallet');
            }
        }
    });

    $("#frm-template_wallet_down_step2").validate({
        rules: {
            'transaction[operation_status]': {
                required: true,
            },
           
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            saveForm('frm-template_wallet_down_step2', 'kc-down-wallet');
        }
    });
    

    //*get data
    if (document.getElementById('id_rel')) {
        let id_rel = $('#id_rel').val();
        let type_form = $('#type_form').val();
        
        if (id_rel != '') {
            axios
                .get("/panel/action-form/" + id_rel+"/"+type_form+'/form/get')
                .then(function (response) {
                    let result = response.data;
                    let credit = result.credit;
                    let client = result.client;
                    let transaction = result.transaction;
                    

                    if (type_form == 8) { //checkup
                        organizationChange(credit.agreement_id, null);
                        $('#name').val(client.name);
                        $('#last_name').val(client.last_name);
                        $('#second_last_name').val(client.second_last_name);
                        $('#cellphone').val(client.cellphone);
                    }

                    if (type_form == 12) //reduccion
                    {
                        
                        getFinancialProduct(credit.id, 2);
                        organizationChange(credit.agreement_id, credit.financial_id);
                        $('#name').val(client.name);
                        $('#last_name').val(client.last_name);
                        $('#second_last_name').val(client.second_last_name);
                        $('#cellphone').val(client.cellphone);
                        $('#current_payment').val(credit.current_payment / 100);
                        $('#current_periodicity').val(credit.current_periodicity).trigger("change");
                        $('#current_loan').val(credit.current_loan / 100);
                        $('#current_term').val(credit.current_term);
                        $('#current_principal_balance').val(credit.current_principal_balance / 100);
                        $('#current_total_balance').val(credit.current_total_balance / 100);
                        $('#tipo_credito').val(credit.tipo_credito).trigger("change");
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
                    if (type_form == 26) //form kc-desktop step3 - 1
                    {
                        $('#work_email').val(client.work_email);
                        $('#sex').val(client.sex).trigger("change");
                        $('#rfc').val(client.rfc);
                        $('#nationality').val(client.nationality);
                        $('#birth_state').val(client.birth_state);
                        $('#curp').val(client.curp);
                        $('#client_postal_code').val(client.client_postal_code);
                        $('#client_street').val(client.client_street);
                        $('#client_home_external_number').val(client.client_home_external_number);
                        $('#client_home_internal_number').val(client.client_home_internal_number);
                        $('#client_colony').val(client.client_colony);
                        $('#client_city').val(client.client_city);
                        $('#client_state').val(client.client_state);
                        $('#client_country').val(client.client_country);
                        $('#bank_name').val(client.bank_name);
                        $('#bank_card_number').val(client.bank_card_number);
                        $('#bank_acount_number').val(client.bank_acount_number);
                        $('#bank_clabe').val(client.bank_clabe);
                        $('#employee_number').val(client.employee_number);
                        $('#monthly_income').val(client.monthly_income);
                        $('#workplace_postal_code').val(client.workplace_postal_code);
                        $('#workplace_street').val(client.workplace_street);
                        $('#workplace_home_external_number').val(client.workplace_home_external_number);
                        $('#workplace_home_internal_number').val(client.workplace_home_internal_number);
                        $('#workplace_colony').val(client.workplace_colony);
                        $('#workplace_city').val(client.workplace_city);
                        $('#workplace_state').val(client.workplace_state);
                        $('#workplace_country').val(client.workplace_country);
                        
                        
                        
                    }

                    if (type_form == 27) //form kc-desktop step3 - 2
                    {
                        $('#marital_status').val(client.marital_status).trigger("change");
                        $('#education_level').val(client.education_level).trigger("change");
                        $('#profession').val(client.profession);
                        $('#client_contact_time').val(client.client_contact_time);
                        $('#relative_lastname').val(client.relative_lastname);
                        $('#relative_second_lastname').val(client.relative_second_lastname);
                        $('#relative_names').val(client.relative_names);
                        $('#relative_local_phone').val(client.relative_local_phone);
                        $('#relative_cel_phone').val(client.relative_cel_phone);
                        $('#relative_contact_time').val(client.relative_contact_time);
                        $('#home_type').val(client.home_type).trigger("change");
                        $('#home_time_living').val(client.home_time_living);
                        $('#home_note').val(client.home_note);
                        $('#propety_ownnership_amount').val(client.propety_ownnership_amount);
                        $('#propety_ownnership_value').val(client.propety_ownnership_value);
                        $('#vehicle_ownnership_amount').val(client.vehicle_ownnership_amount);
                        $('#vehicle_ownnership_value').val(client.vehicle_ownnership_value);
                        $('#economic_dependents').val(client.economic_dependents);
                        $('#workplace_name').val(client.workplace_name);
                        $('#admission_date').val(client.admission_date);
                        $('#employee_area').val(client.employee_area);
                        $('#employee_position').val(client.employee_position);
                        $('#aditional_labor_source').val(client.aditional_labor_source);
                        $('#aditional_labor_income').val(client.aditional_labor_income);
                        $('#workplace_local_phone').val(client.workplace_local_phone);
                        $('#workplace_cel_phone').val(client.workplace_cel_phone);
                        $('#workplace_code').val(client.workplace_code);
                        $('#workplace_local_phone_extension').val(client.workplace_local_phone_extension);
                        selectRadio(credit.client_public_servant, 'client_public_servant');
                        $('#client_public_servant_position').val(credit.client_public_servant_position);
                        $('#client_public_servant_period').val(credit.client_public_servant_period);
                        selectRadio(credit.relative_public_servant, 'relative_public_servant');
                        $('#relative_public_servant_lastname').val(credit.relative_public_servant_lastname);
                        $('#relative_public_servant_second_lastname').val(credit.relative_public_servant_second_lastname);
                        $('#relative_public_servant_names').val(credit.relative_public_servant_names);
                        $('#relative_public_servant_relationship').val(credit.relative_public_servant_relationship);
                        $('#relative_public_servant_position').val(credit.relative_public_servant_position);
                        $('#relative_public_servant_period').val(credit.relative_public_servant_period);
                        selectRadio(credit.prepaid, 'prepaid');
                        selectPrepadMethod(credit.prepad_method, 'prepad_method');
                        $('#prepaid_frequency').val(credit.prepaid_frequency);
                        $('#prepaid_source').val(credit.prepaid_source);
                        selectRadio(credit.endorsement, 'endorsement');
                        selectRadio(credit.real_beneficiary, 'real_beneficiary');
                        selectRadio(credit.soruce_provider, 'soruce_provider');
                        selectRadio(credit.real_propetary, 'real_propetary');
                        $('#notes').val(credit.notes);

                        $('#client_postal_code').val(client.client_postal_code);
                        $('#client_street').val(client.client_street);
                        $('#client_home_external_number').val(client.client_home_external_number);
                        $('#client_home_internal_number').val(client.client_home_internal_number);
                        $('#client_colony').val(client.client_colony);
                        $('#client_city').val(client.client_city);
                        $('#client_state').val(client.client_state);
                        $('#client_country').val(client.client_country);
                    }

                    if (type_form == 29) //form kc-desktop step 5
                    {
                        $('#financial_user_assigned').val(credit.financial_user_assigned).trigger("change");
                        $('#commission').val(credit.commission);
                        $('#commission_note').val(credit.commission_note);
                    }
                    
                    if (type_form == 32) //form kc-ddelivery step 2
                    {
                        $('#changed_commission').val(credit.changed_commission/100);
                        $('#changed_commission_note').val(credit.changed_commission_note);
                    }
                    if (type_form == 34) //form kc-ddelivery step 3
                    {
                        $('#payment_check').val(credit.payment_check).trigger("change");
                        $('#payment_check_note').val(credit.payment_check_note);
                    }
                    
                    if (type_form == 39) //form kc-swap step 1
                    {
                        $('#name').val(client.name);
                        $('#last_name').val(client.last_name);
                        $('#second_last_name').val(client.second_last_name);
                        $('#cellphone').val(client.cellphone);
                        $('#email').val(client.email);
                        $('#rfc').val(client.rfc);
                        $('#id_number').val(credit.id_number);
                        $('#current_credit_number').val(credit.current_credit_number);
                        
                        $('#current_payment').val(credit.current_payment / 100);
                        $('#current_periodicity').val(credit.current_periodicity).trigger("change");
                        $('#current_loan').val(credit.current_loan / 100);
                        $('#current_term').val(credit.current_term);
                        $('#current_principal_balance').val(credit.current_principal_balance / 100);
                        $('#current_total_balance').val(credit.current_total_balance / 100);
                    }

                    if (type_form == 40) //form kc-swap step 2
                    {
                        $('#url_sign').val(credit.url_sign);
                    }
                    
                    if (type_form == 41) //form kc-swap step 2 form 2
                    {
                        $('#signed').val(credit.signed).trigger("change");
                    }

                    if (type_form == 61) //form kc-wallet step1
                    {
                         
                        $('#investor_id').val(transaction.investor_id).trigger("change");
                        $('#bank_transfer_type').val(transaction.bank_transfer_type).trigger("change");
                        $('#operation_number').val(transaction.operation_number);
                        $('#amount').val(transaction.amount);
                    }
                    
                    if (type_form == 63) //form kc-wallet step2
                    {
                        $('#operation_status').val(transaction.operation_status).trigger("change");
                    }
                    
                    if (type_form == 67) //form kc-wallet step2
                    {
                        $('#operation_status').val(transaction.operation_status).trigger("change");
                    }
                    if (type_form == 66) //form kc-wallet step1
                    {
                        $('#investor_id').val(transaction.investor_id).trigger("change");
                        $('#transaction_type').val(transaction.transaction_type);
                        $('#amount').val(Math.abs(transaction.amount));
                    }

                })
                .catch(e => {
                });
        }
    }

 

    
});

function selectRadio(val, id) {
    if (val == 1) {
        document.querySelector('#'+id+'_1').checked = true;
    } else {
        document.querySelector('#'+id+'_2').checked = true;
    }
}

function selectPrepadMethod(val, id) {
    if (val == 1) {
        document.querySelector('#'+id+'_1').checked = true;
    } else if(val == 2){
        document.querySelector('#'+id+'_2').checked = true;
    } else if(val == 3){
        document.querySelector('#'+id+'_3').checked = true;
   } else if(val == 4){
        document.querySelector('#'+id+'_4').checked = true;
    }
}

window.swapContinue = function (credit_id) {
    axios
        .get("/panel/action-form")
        .then(function (response) {
            let result = response.data;
        })
        .catch(e => {
        });
}

window.swapCancel = function (id_form, model) {
    axios
        .get("/panel/action-form")
        .then(function (response) {
            let result = response.data;
        })
        .catch(e => {
        });
}

function saveForm(id_form, model) {
    const new_form    = document.getElementById(id_form);
    const data        = new FormData(new_form);
    let id_rel        = $('#id_rel').val();
    let url_redirect  = null;
    let is_redirect_document  = null;

    if (document.getElementById('url_redirect')) {
        url_redirect = $('#url_redirect').val();
    }
    
    console.log(model);
   
    data.append('model', model);
    data.append('id_rel', id_rel);
    axios
        .post("/panel/action-form", data)
        .then(function (response) {
            let result = response.data;
            
            if (url_redirect == null) {
                window.history.back();
            }
            if (document.getElementById('url_redirect_finish')) {
                // Obtener el valor de "id"
                const id = result.id;
              
                // Obtener el elemento "url_redirect_finish"
                const urlRedirectFinishElement = document.getElementById('url_redirect_finish');
              
                // Obtener el valor actual de data-redirect
                const currentDataRedirect = urlRedirectFinishElement.getAttribute('data-redirect');
              
                // Reemplazar {history_id} con el valor de "id"
                const updatedDataRedirect = currentDataRedirect.replace('{history_id}', id);
              
                // Actualizar el valor de data-redirect
                urlRedirectFinishElement.setAttribute('data-redirect', updatedDataRedirect);
                
                /* window.location = updatedDataRedirect; */
                url_redirect = updatedDataRedirect;
                if (url_redirect.includes('{id}')) {
                    url_redirect = url_redirect.replace('{id}', result.id);
                }
            }
              
            window.location = url_redirect;
        })
        .catch(e => {
        });
}

window.saveAndContinueTask = function(id_form)
{
    let model = $('#action-model').val(); 
    let newUrl = $('#url_redirect_next').val();
    $('#url_redirect').val(newUrl); 
    saveForm(id_form, model);
}

window.cancelTask = function()
{
    let url = $('#url_redirect').val(); 
    window.location = url;
}

//*boton saltar en swap etapa 2_3   
window.saltarSwap = function ()
{
    $('#send_email').val(0);
    $("#frm-template_swap_step2-3").submit(); // Envía el formulario
}
//TODO: alerta si detecto kyc
window.kycCreditHistory = function(history_id, type) {
    let params    = {1:'curp', 2: 'ine', 3: 'rfc', 4: 'curp'};
    let id        = params[type];
    let id_result    = params[type];
    let param     = $('#'+id).val();
    if (type == 4) {
        id_result     = 'issste';
    }
    let param2 = type == 2 ? $('#identificadorCiudadano').val() : null;
    let error = false;  

    if (type == 2 && param == '' && param2 == '') {
        error = true;
        Swal.fire({
            text: 'Campos obligatorios',
            icon: 'warning',
        })
    }
    if (error == false) {
        $('#kyc-'+id_result).html('');
        $('#kyc-'+id_result+'-msg').html('');
    
    
        axios
            .get("/panel/kc-control-desk/kc/"+history_id+"/"+param+"/"+param2+"/"+type+"/validate")
            .then(function (response) {
                let result = response.data;
                $('#kyc-'+id_result).html(result.html);
                $('#kyc-'+id_result+'-msg').val(result.msg);
                
            })
            .catch(e => {
            });
    }
}

window.showKycCurp = function(type){
    let params    = {1:'curp', 2: 'ine', 3: 'rfc', 4: 'issste'};
    let id        = params[type];

    let msg = $('#kyc-'+id+'-msg').val();
    $('#kyc-msg').html(msg);
    $('#modal-kyc').modal('show');
}

window.deliverysendEmail = function (history_id) {
    axios
        .get("/panel/kc-delivery/"+history_id+"/send-email")
        .then(function (response) {
           
            window.location = '/panel/template/steps/delivery/'+history_id+'/show';
            

            
        })
        .catch(e => {
        });
}

window.modalReference = function(history_id, reference_id) {

    $('#modal_history_id').val(history_id);
    $('#modal_reference_id').val(reference_id);
    if (reference_id != null) {
        axios
        .get("/panel/reference/"+reference_id+"/show")
        .then(function (response) {
            let result = response.data;
            $('#last_name').val(result.last_name);
            $('#second_lastname').val(result.second_lastname);
            $('#names').val(result.names);
            $('#relationship').val(result.relationship);
            $('#relationship_time_years').val(result.relationship_time_years);
            $('#relationship_time_months').val(result.relationship_time_months);
            $('#cel_phone').val(result.cel_phone);
            $('#local_phone').val(result.local_phone);
            $('#contact_time').val(result.contact_time);
            $('#postal_code').val(result.postal_code);
            $('#street').val(result.street);
            $('#home_external_number').val(result.home_external_number);
            $('#home_internal_number').val(result.home_internal_number);
            $('#colony').val(result.colony);
            $('#city').val(result.city);
            $('#state').val(result.state);
            $('#country').val(result.country);
            $('#note').val(result.note);
        })
        .catch(e => {
        });
    }
    $('#modal-reference').modal('show');
}

window.swapCreditContinue = function(history_id) {
    let url_redirect  = null;

    if (document.getElementById('url_redirect')) {
        url_redirect = $('#url_redirect').val();
    }

    axios
        .get("/panel/kc-swap/credit/"+history_id+"/continue")
        .then(function (response) {
            let result = response.data;
            if (url_redirect == null) {
                window.history.back();
            }
            window.location = url_redirect;
        })
        .catch(e => {
        });
}

window.sendCreditActive = function(historyId)
{
    axios
        .get("/panel/kc-delivery/"+historyId+"/send/active")
        .then(function (response) {
            window.location = '/panel/kc-delivery';
        })
        .catch(e => {
        });
}

window.finishControlDesk = function(historyId)
{
    axios
        .get("/panel/kc-control-desk/"+historyId+"/send/finish")
        .then(function (response) {
            window.location = '/panel/kc-control-desk';
        })
        .catch(e => {
        });
}
