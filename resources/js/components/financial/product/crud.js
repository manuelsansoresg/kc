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
                    //window.location = '/panel/financial/'+result.id+'/edit';
                    window.history.back();
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
  
  $("#frm-financial-rate").submit(function (event) {
    event.preventDefault();

    // Obtener los valores de los campos, si se ingresaron
    const rate_kc = $("#rate_kc").val() !== '' ? parseFloat($("#rate_kc").val()) : null;
    const rate_cat = $("#rate_cat").val() !== '' ? parseFloat($("#rate_cat").val()) : null;
    const rate_comision = $("#rate_comision").val() !== '' ? parseFloat($("#rate_comision").val()) : null;
    const rate_deadline = $("#rate_deadline").val() !== '' ? parseFloat($("#rate_deadline").val()) : null;
    const rate_contract = $("#rate_contract").val() !== '' ? parseFloat($("#rate_contract").val()) : null;
    const rate_privacity = $("#rate_privacity").val() !== '' ? parseFloat($("#rate_privacity").val()) : null;

    // Función para validar que un valor esté dentro del rango de 0 a 5
    function isValidValue(value) {
        return value === null || (!isNaN(value) && value >= 0 && value <= 5);
    }

    // Validar que los valores estén dentro del rango permitido
    if (!isValidValue(rate_kc) || !isValidValue(rate_cat) || !isValidValue(rate_comision) ||
        !isValidValue(rate_deadline) || !isValidValue(rate_contract) || !isValidValue(rate_privacity)) {
            Swal.fire({
                title: 'Por favor, ingrese valores numéricos entre 0 y 5',
                icon: 'warning',
                showCancelButton: true,
            })
    } else {
        const new_form = document.getElementById("frm-financial-rate");
        const data = new FormData(new_form);

        axios
            .post("/panel/financial-product", data)
            .then(function (response) {
                let result = response.data;
                showToast('Producto', 'Datos guardados', 'success');
            })
            .catch(e => {
                // Manejar errores si es necesario
            });
    }
});


window.deleteFinancialProduct = function (id) {
    axios
    .delete("/panel/financial-product/"+id)
    .then(function (response) {
        showInfo(2, 'dt-financial-product', 'Producto', 'Registro borrado');
    })
    .catch(e => {
    });
}

window.alerDeleteFinancialProduct = function (id) {
   
    Swal.fire({
        title: '¿Estás seguro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, elimina',
        cancelButtonText: 'Mejor no'
    }).then(function (result) {
        if (result.value) {
            deleteProduct(id);
        }
    });
}