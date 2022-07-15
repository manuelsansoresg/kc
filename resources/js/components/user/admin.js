import {showInfo} from '../utilities';

window.modalUserAdmin = function (type, user_id) {
    if (type === 1) {
        $('#user-admin-title').html('Crear usuario');
        $('#content-password').show();
        $('#content-pass_confirm').show();
        $('#user_id').val(null);
    } else {
        $('#user-admin-title').html('Editar usuario');
        $('#content-pass_confirm').hide();
        $('#content-password').hide();
        $('#user_id').val(user_id);
        setDataUser(user_id);
    }
    
    $('#modal-user-admin').modal('show');
}

function setDataUser(user_id) {
    axios
    .get("/panel/user/admin/"+user_id)
    .then(function (response) {
        let result = response.data;
        $('#name').val(result.name);
        $('#last_name').val(result.last_name);
        $('#cellphone').val(result.cellphone);
        $('#email').val(result.email);
        $('#status option[value="'+result.status+'"]').attr("selected", "selected");

    })
    .catch(e => {
        $('#admin_email-error-exist').show();
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
                minlength: 8
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
        },
        submitHandler: function(form, event){
            event.preventDefault();

            $('#admin_email-error-exist').hide();
            const new_form = document.getElementById("frmadmin");
            const data = new FormData(new_form);
    
            axios
            .post("/panel/user/admin", data)
            .then(function (response) {
                let result = response.data;
                showInfo(2);
            })
            .catch(e => {
                $('#admin_email-error-exist').show();
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
    
            axios
            .post("/panel/user/admin/password/update", data)
            .then(function (response) {
                let result = response.data;
                showInfo(2);
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