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
            'email': {
                email: true,
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
                    let result = response.data;
                    window.location = '/panel/financial/'+result.id+'/edit?tab=privacidad_de_datos';
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

$( "#frm-financial-data-pricacy" ).submit(function( event ) {
    event.preventDefault();
    const new_form = document.getElementById("frm-financial-data-pricacy");
    const data = new FormData(new_form);

    axios
        .post("/panel/financial", data)
        .then(function (response) {
            let result = response.data;
            showToast('Financiera', 'Datos guardados', 'success');
            
        })
        .catch(e => {
            
        });
  });

  $( "#frm-financial-buro" ).submit(function( event ) {
    event.preventDefault();
    const new_form = document.getElementById("frm-financial-buro");
    const data = new FormData(new_form);

    axios
        .post("/panel/financial", data)
        .then(function (response) {
            let result = response.data;
            showToast('Financiera', 'Datos guardados', 'success');
            
        })
        .catch(e => {
            
        });
  });

  $( "#frm-financial-billing" ).submit(function( event ) {
    event.preventDefault();
    const new_form = document.getElementById("frm-financial-billing");
    const data = new FormData(new_form);

    axios
        .post("/panel/financial", data)
        .then(function (response) {
            let result = response.data;
            showToast('Financiera', 'Datos guardados', 'success');
            
        })
        .catch(e => {
            
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

window.alerFinancialDelete = function (id) {
   
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