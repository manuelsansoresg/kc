import { showInfo } from '../utilities';

$().ready(function () {
    $("#frm-financial").validate({
        rules: {
            'commercial_name': {
                required: true,
            },
            'company_name': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            $('#financial-commercial_name-unique-error').html('');
            $('#financial-commercial_name-unique-error').hide();
            const new_form = document.getElementById("frm-financial");
            const data = new FormData(new_form);

            axios
                .post("/panel/financial", data)
                .then(function (response) {
                   window.location = '/panel/financial';
                })
                .catch(e => {
                    let response = e.response;
                    let data_errors = response.data.errors; 
                    $('#financial-commercial_name-unique-error').html('Este campo ya se encuentra registrado.');
                    $('#financial-commercial_name-unique-error').show();
                });

        }
    });

 

});

window.deleteFinancial = function (id) {
    axios
    .delete("/panel/financial/"+id)
    .then(function (response) {
        showInfo(2, 'dt-financial', 'Datos actualizados', 'Registro borrado');
    })
    .catch(e => {
    });
}

window.alerDelete = function (id) {
   
    Swal.fire({
        title: '¿Estás seguro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, elimina',
        cancelButtonText: 'Mejor no'
    }).then(function (result) {
        if (result.value) {
            deleteFinancial(id);
        }
    });
}