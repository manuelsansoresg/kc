import { showInfo } from '../../utilities';
let isLoaded = false;


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
                    showToast('Producto', 'Datos guardados', 'success');
                })
                .catch(e => {
                    let response = e.response;
                    let data_errors = response.data.errors; 
                    $('#product-name-unique-error').html('Este campo ya se encuentra registrado.');
                    $('#product-name-unique-error').show();
                });

        }
    });

    if (document.getElementById('frm-product-info') && $('#product_id').val() != 'null' ) {


        let product_id = $('#product_id').val();
        
        // Limpia las selecciones actuales en los selects
        $('#product_periodicity_id').val(null).trigger('change');
        $('#product-principal_pay').val(null).trigger('change');
        

        axios
            .get("/panel/financial-product/" + product_id + '/getPeriodicityAndPaymentMethod')
            .then(async function (response) {  // Usa async/await aquí
                let result = response.data;
                let periodicities = result.periodicities;
                let payments = result.payments;
                

                // Itera sobre periodicities y selecciona las opciones en product_periodicity_id
                let periodicityValues = periodicities.map(item => item.periodicity_id);
                let paymentValues = payments.map(item => item.payment_method_id);
                

                // Seleccionar los valores correspondientes en los selects
                $('#product_periodicity_id').val(periodicityValues).trigger('change');
                $('#product-principal_pay').val(paymentValues).trigger('change');
               
            })
            .catch(e => {
                console.error(e);
            });

    }
 

});
let previouslyLoadedTerms = []; // Almacena los términos previamente cargados

window.setFPTerms = function()
{
    let product_id = $('#product_id').val();

    $('#fp_terms').val(null).trigger('change');
    // Realiza la solicitud AJAX para obtener los términos

    let periodicityId = $('#product_periodicity_id').val();
    let select = document.getElementById("fp_terms");

    // Limpia el select antes de agregar opciones
    select.innerHTML = "";

    // Realiza la solicitud AJAX para obtener los términos
    return axios
        .get("/panel/financial-product/" + periodicityId + '/'+product_id+ '/terms/get')
        .then(function (response) {
            let result = response.data;
            let terms = result.terms;
            let getTerms = result.getTerms;
            // Llena el select con las opciones de terms
            terms.forEach(function (term) {
                let option = document.createElement("option");
                option.value = term.id;  // El valor será el id
                option.text = term.term; // El texto será el term
                select.appendChild(option);
            });

            // Si se pasaron términos seleccionados, se seleccionan aquí
            if (getTerms != null) {
                let termValues = getTerms.map(item => item.id);
                $('#fp_terms').val(termValues).trigger('change');
            }
            
        })
        .catch(e => {
            console.error(e);
        });


    


}



$( "#frm-financial-chart" ).submit(function( event ) {
    event.preventDefault();
    const new_form = document.getElementById("frm-financial-chart");
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

  if (document.getElementById('tramite-proceso_tramite')) {
    let ckeditor = CKEDITOR.replace('tramite-proceso_tramite', {
        toolbar: [
           { name: 'basicstyles', items: ['Bold', 'Italic', 'Font', 'FontSize', 'TextColor', 'BGColor', 'RemoveFormat'] },
           { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
           { name: 'insert', items: [ 'Table'] }
       ],
       language: 'es-mx',
   });

   //*axios que devuelva el valor proceso_tramite
   
   let product_id = $('#product_id').val();
   setTimeout(function () {
    axios
        .get("/panel/financial-product/" + product_id + "/getTramite")
        .then(function (response) {
            let result = response.data;
            CKEDITOR.instances['tramite-proceso_tramite'].setData(result.proceso_tramite);
        })
        .catch(e => {
            // Manejar errores aquí
        });
}, 2000); // 2000 milisegundos = 2 segundos

  }

  $( "#frm-financial-tramite" ).submit(function( event ) {
    event.preventDefault();
    var desc = CKEDITOR.instances['tramite-proceso_tramite'].getData();
    $('#tramite-proceso_tramite').val(desc);

    const new_form = document.getElementById("frm-financial-tramite");
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


  $( "#frm-comisioneskc" ).submit(function( event ) {
    event.preventDefault();
    const new_form = document.getElementById("frm-comisioneskc");
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
            deleteFinancialProduct(id);
        }
    });
}
if (document.getElementById('is_tramitar_active')) {

    document.addEventListener('DOMContentLoaded', function() {
        // Obtener referencias a los radio buttons
        const radioSi = document.getElementById('is_tramitar_active');
        const radioNo = document.getElementById('is_tramitar_pending');
        
        // Obtener todos los elementos con la clase 'tramitable'
        const tramitables = document.querySelectorAll('.tramitable');
        
        // Función para mostrar u ocultar elementos tramitables
        function toggleTramitables() {
            // Si el radio "Sí" está seleccionado, mostrar todos los elementos tramitables
            if (radioSi.checked) {
                tramitables.forEach(function(element) {
                    element.style.display = ''; // Muestra el elemento (valor por defecto)
                });
            } 
            // Si el radio "No" está seleccionado, ocultar todos los elementos tramitables
            else if (radioNo.checked) {
                tramitables.forEach(function(element) {
                    element.style.display = 'none'; // Oculta el elemento
                });
            }
        }
        
        // Añadir event listeners a los radio buttons
        radioSi.addEventListener('change', toggleTramitables);
        radioNo.addEventListener('change', toggleTramitables);
        
        // Ejecutar la función al cargar la página para establecer el estado inicial
        toggleTramitables();
    });
}