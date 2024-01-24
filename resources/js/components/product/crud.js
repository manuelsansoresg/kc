import { showInfo } from '../utilities';

window.modalProduct = function (type, product_id) {
    let route_datatable = $('#route_datatable').val();

    $('#frm-product').trigger("reset");
    if (type === 1) {
        $('#product-title').html('Crear producto');
        $('#product_id').val(null);

    } else {
        $('#product-title').html('Editar producto');
        $('#product_id').val(product_id);
        setDataUser(product_id);

    }

    $('#modal-product').modal('show');
}

function setDataUser(product_id) {
    axios
        .get("/panel/product/" + product_id)
        .then(function (response) {
            let result = response.data;
            //$('#c_product_id option[value="' + result.c_product_id + '"]').attr("selected", "selected");
            $('#c_service_id option[value="' + result.c_service_id + '"]').attr("selected", "selected");
            $('#status option[value="' + result.status + '"]').attr("selected", "selected");
            $('#comment').val(result.comment);
            $('#product-alias').val(result.alias);

        })
        .catch(e => {
            $('#admin_email-error-exist').show();
        });
}


window.deleteProduct = function (product_id) {
    axios
        .get("panel/product/"+product_id+"/delete")
        .then(function (response) {
            showInfo(2, 'dt-product', 'Datos actualizados', 'Información actualizada correctamente');
        })
        .catch(e => {
            
        });
}


$().ready(function () {
    $("#frm-product").validate({
        rules: {
            alias: {
                required: true,
            },
            c_product_id: {
                required: true,
            },
            c_service_id: {
                required: true,
            },
            status: {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const new_form = document.getElementById("frm-product");
            const data = new FormData(new_form);

            axios
                .post("/panel/product", data)
                .then(function (response) {
                    let result = response.data;
                    showInfo(2, 'dt-product', 'Datos actualizados', 'Información actualizada correctamente');
                    $('#modal-product').modal('hide');
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
        submitHandler: function (form, event) {
            event.preventDefault();

            const new_form = document.getElementById("frmpassword");
            const data = new FormData(new_form);
            let route_datatable = $('#route_datatable').val();

            axios
                .post("/panel/user/" + route_datatable + "/password/update", data)
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