import { showInfo } from '../../utilities';

$().ready(function () {
    $("#frm-product-info").validate({
        rules: {
            'name': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            $('#product-name-unique-error').html('');
            $('#product-name-unique-error').hide();
            const new_form = document.getElementById("frm-product-info");
            const data = new FormData(new_form);

            axios
                .post("/panel/financial-product", data)
                .then(function (response) {
                    let result = response.data;
                    window.location = '/panel/financial-product/'+result.id+'/edit';
                })
                .catch(e => {
                    let response = e.response;
                    let data_errors = response.data.errors; 
                    $('#product-name-unique-error').html('Este campo ya se encuentra registrado.');
                    $('#product-name-unique-error').show();
                });

        }
    });

 

});

$( "#frm-financial-buro" ).submit(function( event ) {
    event.preventDefault();
    const new_form = document.getElementById("frm-financial-buro");
    const data = new FormData(new_form);

    axios
        .post("/panel/financial-product", data)
        .then(function (response) {
            let result = response.data;
            showToast('Producto', 'Datos guardados', 'success');
            
        })
        .catch(e => {
            
        });
  });

  $( "#frm-financial-comision" ).submit(function( event ) {
    event.preventDefault();
    const new_form = document.getElementById("frm-financial-comision");
    const data = new FormData(new_form);

    axios
        .post("/panel/financial-product", data)
        .then(function (response) {
            let result = response.data;
            showToast('Producto', 'Datos guardados', 'success');
            
        })
        .catch(e => {
            
        });
  });

  $( "#frm-financial-contact" ).submit(function( event ) {
    event.preventDefault();
    const new_form = document.getElementById("frm-financial-contact");
    const data = new FormData(new_form);

    axios
        .post("/panel/financial-product", data)
        .then(function (response) {
            let result = response.data;
            showToast('Producto', 'Datos guardados', 'success');
            
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