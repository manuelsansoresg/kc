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
  

  if (document.getElementById('alcance_beneficios')) {
    refreshListComplementary();
  }

  function refreshListComplementary()
  {
    let product_id = $('#product_id').val();
    
    axios
        .get("/panel/product-complementary/list/"+product_id+"/refresh", )
        .then(function (response) {
            let result = response.data;       
            // Asignar valores al select de alcance_beneficios
            let alcanceSelect = document.getElementById('alcance_beneficios');
            alcanceSelect.innerHTML = ''; // Limpia el select actual
            result.complementary_alcance.forEach(function (alcance) {
                let option = document.createElement('option');
                option.value = alcance.description;
                option.text = alcance.description;
                alcanceSelect.appendChild(option);
            });

            const alcanceBeneficiosArray = result.my_product.alcance_beneficios.split(',');
            $('#alcance_beneficios').val(alcanceBeneficiosArray).trigger('change');
            // Repite el mismo proceso para los otros selects (restriccion_exclusion, programa_educacion_financiera, referencia_comparativa)

            // Asignar valores al select de restriccion_exclusion
            let restriccionSelect = document.getElementById('restriccion_exclusion');
            restriccionSelect.innerHTML = '';
            result.complementary_restricciones.forEach(function (restriccion) {
                let option = document.createElement('option');
                option.value = restriccion.description;
                option.text = restriccion.description;
                restriccionSelect.appendChild(option);
            });
            const alcanceRestriccionArray = result.my_product.restriccion_exclusion.split(',');
            $('#restriccion_exclusion').val(alcanceRestriccionArray).trigger('change');
            // Asignar valores al select de programa_educacion_financiera
            let programaSelect = document.getElementById('programa_educacion_financiera');
            programaSelect.innerHTML = '';
            result.complementary_programas.forEach(function (programa) {
                let option = document.createElement('option');
                option.value = programa.description;
                option.text = programa.description;
                programaSelect.appendChild(option);
            });

            const alcanceProgramaArray = result.my_product.programa_educacion_financiera.split(',');
            $('#programa_educacion_financiera').val(alcanceProgramaArray).trigger('change');

            // Asignar valores al select de referencia_comparativa
            let referenciaSelect = document.getElementById('referencia_comparativa');
            referenciaSelect.innerHTML = '';
            result.complementary_referencias.forEach(function (referencia) {
                let option = document.createElement('option');
                option.value = referencia.description;
                option.text = referencia.description;
                referenciaSelect.appendChild(option);
            });     

            const ReferenciaArray = result.my_product.referencia_comparativa.split(',');
            $('#referencia_comparativa').val(ReferenciaArray).trigger('change');
        })
        .catch(e => {
            
        });
  }
 /*  alcance_beneficios
restriccion_exclusion
programa_educacion_financiera
referencia_comparativa */


  window.modalComplementary = function(type)
  {
    // Definir un arreglo con los títulos correspondientes a cada tipo
    var titles = [
        'ALCANCE O BENEFICIOS',
        'RESTRICCIONES O EXCLUSIONES',
        'PROGRAMAS DE EDUCACIÓN FINANCIERA',
        'REFERENCIAS CORPORATIVAS'
    ];
    let product_id = $('#product_id').val();
    // Verificar que el tipo esté dentro del rango válido
    if (type >= 1 && type <= titles.length) {
        // Asignar el valor del título al elemento con ID 'title-complementary'
        document.getElementById('title-complementary').textContent = titles[type - 1];
        
        $('#type-complementary-service').val(type);
        $('#product-complementary-service').val(product_id);
        
        showContentComplementary();
    } else {
        // Tratamiento para tipos fuera del rango válido
        document.getElementById('title-complementary').textContent = 'Título no válido';
    }

    $('#modal-complementary').modal('show');
  }

  $( "#frm-complementary" ).submit(function( event ) {
    event.preventDefault();
    const new_form = document.getElementById("frm-complementary");
    const data = new FormData(new_form);

    axios
        .post("/panel/product-complementary", data)
        .then(function (response) {
            // Resetea el formulario
            $('#product-complementary-description').val('');
            $('#product-complementary-id').val('');
            refreshListComplementary();
            showContentComplementary();
            
        })
        .catch(e => {
            
        });
  });

  function showContentComplementary()
  {
    let product_id = $('#product_id').val();
    let type = $('#type-complementary-service').val();

    axios
        .get("/panel/product-complementary/"+product_id+'/'+type)
        .then(function (response) {
            let result = response.data;
            $('#content-complementary').html(result);
            
        })
        .catch(e => {
            
        });
  }

  window.deleteComplementary = function(complementary_id)
  {
    Swal.fire({
        title: '¿Estás seguro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, elimina',
        cancelButtonText: 'Mejor no'
    }).then(function (result) {
        if (result.value) {
            axios
            .delete("/panel/product-complementary/"+complementary_id)
            .then(function (response) {
                showContentComplementary();
            })
            .catch(e => {
                
            });
        }
    });
  }

  window.editComplementary = function(complementary_id, description)
  {

    $('#product-complementary-description').val(description);
    $('#product-complementary-id').val(complementary_id);
    let type = $('#type-complementary-service').val();
    modalComplementary(type);

  }

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