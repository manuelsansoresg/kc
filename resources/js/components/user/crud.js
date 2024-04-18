import {showInfo} from '../utilities';

window.modalUser = function (type, user_id) {
    let route_datatable = $('#route_datatable').val();
    let title = $('#title').val();
    if (document.getElementById('frmadmin')) {
        $('#frmadmin').trigger("reset");
        $('#financial_id').val("").trigger("change");;
    }
    if (document.getElementById('frmfinanciera')) {
        $('#frmfinanciera').trigger("reset");
    }
    
    if (document.getElementById('frm-inversionista')) {
        $('#frm-inversionista').trigger("reset");
    }

    if (type === 1) {
        $('#user-admin-title').html('Crear usuario '+ title);
        $('#content-password').show();
        $('#content-pass_confirm').show();
        $('#user_id').val(null);
        $('#type_user').val(route_datatable);

    } else {
        let lbluser = route_datatable;
        if (route_datatable == 'cliente-financiera') {
            lbluser = 'cliente financiera';
        }
        if (route_datatable == 'cliente-persona') {
            lbluser = 'cliente persona';
        }
        $('#user-admin-title').html('Editar usuario '+ lbluser);
        $('#content-pass_confirm').hide();
        $('#content-password').hide();
        $('#user_id').val(user_id);
        setDataUser(user_id);
        $('#type_user').val(route_datatable);

    }
    
    $('#modal-user-admin').modal('show');
}

function setDataUser(user_id) {
    let route_datatable = $('#route_datatable').val();
    axios
    .get("/panel/user/"+route_datatable+"/"+user_id)
    .then(function (response) {
        let result = response.data;
        if (document.getElementById('rol') != '') {
            //*limpiar los valores razon social
            let type_person = result.type_person;
            $('#financial_id').val(result.financial_id).trigger("change");

            $('#type_person option[value="'+result.type_person+'"]').attr("selected", "selected");
            $('#rol_id option[value="'+result.rol_id+'"]').attr("selected", "selected");
        }
        //TODO: borrar si todo funciona en pruebas
        /* if (document.getElementById('type_person')) {
            $('#financial_id option[value="'+result.financial_id+'"]').attr("selected", "selected");
            $('#type_person option[value="'+result.type_person+'"]').attr("selected", "selected");
        } */
        $('#name').val(result.name);
        $('#last_name').val(result.last_name);
        $('#second_last_name').val(result.second_last_name);
        $('#cellphone').val(result.cellphone);
        $('#email').val(result.email);
        $('#status option[value="'+result.status+'"]').attr("selected", "selected");
        if (result.agreement_id != '') {
            $('#agreement_id option[value="'+result.agreement_id+'"]').attr("selected", "selected");
            $('#bank_name').val(result.bank_name);
            $('#bank_card_number').val(result.bank_card_number);
            $('#bank_account_number').val(result.bank_account_number);
            $('#bank_clabe').val(result.bank_clabe);
            
            $('#investment_bank_name').val(result.investment_bank_name);
            $('#investment_bank_account_holder').val(result.investment_bank_account_holder);
            $('#investment_bank_account_number').val(result.investment_bank_account_number);
            $('#investment_bank_clabe').val(result.investment_bank_clabe);

        }
        $('#is_access_config option[value="'+result.is_access_config+'"]').attr("selected", "selected");
        if (document.getElementById('financial_products_id')) {
            $('#financial_products_id option[value="'+result.financial_products_id+'"]').attr("selected", "selected");
        }
        

    })
    .catch(e => {
        $('#admin_email-error-exist').show();
     });
}

window.deleteUser = function (id) {
    axios
        .get("/panel/user/administrador/"+id+"/delete")
        .then(function (response) {
            showInfo(2, 'dt-admin', 'Datos actualizados', 'Información actualizada correctamente');
        })
        .catch(e => {
            
        });
}

$().ready(function () {

    if (document.getElementById('frmfinanciera')) {
        $('#financial_id').select2({
            dropdownParent: $('#modal-user-admin'),
            placeholder: "Escribe para buscar..",
            allowClear: true
        });
    }

    $("#frmadmin").validate({
        rules: {
            name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            
            cellphone: {
                required: true,
                number: true,
                minlength: 10
            },
            email: {
                required: true,
                email: true
            },

            password: {
                required: true,
                minlength: 8
            },

            pass_confirm: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
            status: {
                required: true,
            },
        },
        submitHandler: function(form, event){
            event.preventDefault();

            $('#admin_email-error-exist').hide();
            const new_form = document.getElementById("frmadmin");
            const data = new FormData(new_form);
    
            axios
            .post("/panel/user/administrador", data)
            .then(function (response) {
                let result = response.data;
                showInfo(2, 'dt-admin', 'Datos actualizados', 'Información actualizada correctamente');
                $('#modal-user-admin').modal('hide');
            })
            .catch(e => {
                $('#admin_email-error-exist').show();
             });
            
            }
    });
    
    $("#frmfinanciera").validate({
        rules: {
            financial_id: {
                required: true,
            },
            type_person: {
                required: true,
            },
            rol_id: {
                required: true,
            },
           
            name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            
            cellphone: {
                number: true,
                minlength: 10
            },
            email: {
                required: true,
                email: true
            },

            password: {
                required: true,
                minlength: 8
            },

            pass_confirm: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
            status: {
                required: true,
            },
        },
        submitHandler: function(form, event){
            event.preventDefault();
            $('#admin_email-error-exist').hide();
            const new_form = document.getElementById("frmfinanciera");
            const data = new FormData(new_form);
    
            axios
            .post("/panel/user/administrador", data)
            .then(function (response) {
                let result = response.data;
                showInfo(2, 'dt-financiera', 'Datos actualizados', 'Información actualizada correctamente');
                $('#modal-user-admin').modal('hide');
            })
            .catch(e => {
                let response = e.response;
                let errors =  response.data.errors;
                if (errors.email) {
                    $('#admin_email-error-exist').show();
                }
                console.log(e.response);
             });
            
            }
    });
    
    $("#frm-inversionista").validate({
        rules: {
            financial_products_id: {
                required: true,
            },
            type_person: {
                required: true,
            },
            rol_id: {
                required: true,
            },
           
            name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            
            cellphone: {
                number: true,
                minlength: 10
            },
            email: {
                required: true,
                email: true
            },

            password: {
                required: true,
                minlength: 8
            },

            pass_confirm: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
            status: {
                required: true,
            },
        },
        submitHandler: function(form, event){
            event.preventDefault();
            $('#admin_email-error-exist').hide();
            const new_form = document.getElementById("frm-inversionista");
            const data = new FormData(new_form);
    
            axios
            .post("/panel/user/administrador", data)
            .then(function (response) {
                let result = response.data;
                showInfo(2, 'dt-inversionista', 'Datos actualizados', 'Información actualizada correctamente');
                $('#modal-user-admin').modal('hide');
            })
            .catch(e => {
                let response = e.response;
                let errors =  response.data.errors;
                if (errors.email) {
                    $('#admin_email-error-exist').show();
                }
                console.log(e.response);
             });
            
            }
    });

    $("#frmpassword").validate({
        rules: {
            user_password: {
                required: true,
                minlength: 8
            },

            user_pass_confirm: {
                required: true,
                minlength: 8,
                equalTo: "#user_password"
            },
        },
        submitHandler: function(form, event){
            event.preventDefault();

            const new_form = document.getElementById("frmpassword");
            const data = new FormData(new_form);
            let route_datatable = $('#route_datatable').val();

            axios
            .post("/panel/user/"+route_datatable+"/password/update", data)
            .then(function (response) {
                let result = response.data;
                showInfo(2, 'dt-admin', 'Datos actualizados', 'Información actualizada correctamente');
                $('#modal-user-password').modal('hide');
            })
            .catch(e => {
             });
            
            }
    });

});

window.modalPasswod = function (user_id) {
    $('#password_user_id').val(user_id);
    $('#modal-user-password').modal('show');
}