import {showInfo} from '../utilities';

window.modalUser = function (type, user_id) {
    let route_datatable = $('#route_datatable').val();
    let title = $('#title').val();
    $('#frmadmin').trigger("reset");
    if (type === 1) {
        $('#user-admin-title').html('Crear usuario '+ title);
        $('#content-password').show();
        $('#content-pass_confirm').show();
        $('#user_id').val(null);
        $('#type_user').val(route_datatable);

    } else {
        $('#user-admin-title').html('Editar usuario '+ route_datatable);
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
        let razon_social = result.razon_social;
        if (razon_social != '') {
            //*limpiar los valores razon social
            $('#content-razon').hide();
            $('#razon_social').val('');

            let type_person = result.type_person;
            $('#c_financial_id option[value="'+result.c_financial_id+'"]').attr("selected", "selected");
            $('#type_person option[value="'+result.type_person+'"]').attr("selected", "selected");
            if (type_person == 2) {
                $('#razon_social').val(result.razon_social);
                $('#content-razon').show();
            }
        }
        if (document.getElementById('type_person')) {
            $('#c_financial_id option[value="'+result.c_financial_id+'"]').attr("selected", "selected");
            $('#type_person option[value="'+result.type_person+'"]').attr("selected", "selected");
        }
        $('#name').val(result.name);
        $('#last_name').val(result.last_name);
        $('#second_last_name').val(result.second_last_name);
        $('#cellphone').val(result.cellphone);
        $('#email').val(result.email);
        $('#status option[value="'+result.status+'"]').attr("selected", "selected");

    })
    .catch(e => {
        $('#admin_email-error-exist').show();
     });
}

window.deleteUser = function (id) {
    axios
        .get("/panel/user/administrador/"+id+"/delete")
        .then(function (response) {
            showInfo(2, 'dt-admin', 'Información actualizada correctamente');
        })
        .catch(e => {
            
        });
}

$().ready(function () {
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
                showInfo(2, 'dt-admin', 'Información actualizada correctamente');
                $('#modal-user-admin').modal('hide');
            })
            .catch(e => {
                $('#admin_email-error-exist').show();
             });
            
            }
    });
    
    $("#frmfinanciera").validate({
        rules: {
            c_financial_id: {
                required: true,
            },
            type_person: {
                required: true,
            },
            razon_social: {
                required: function(element) {
                    let  type_person = $("#type_person").val();
                    if(type_person == 2) { 
                        return true;
                    } else {
                        return false;
                    }
                }
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
                showInfo(2, 'dt-financiera', 'Información actualizada correctamente');
                $('#modal-user-admin').modal('hide');
            })
            .catch(e => {
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
                showInfo(2, 'dt-admin', 'Información actualizada correctamente');
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

window.showRazon = function () {
    let type_person = $('#type_person').val();
    $('#content-razon').hide();
    if (type_person == 2) {
        $('#content-razon').show();
    }
}