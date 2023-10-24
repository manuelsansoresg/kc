import { showInfo } from '../utilities';

window.deleteAgreement = function (agreement) {
    axios
        .get("panel/agreement/"+agreement+"/delete")
        .then(function (response) {
            showInfo(2, 'dt-agreement', 'Datos actualizados', 'Información actualizada correctamente');
        })
        .catch(e => {
            
        });
}

$().ready(function () {
    $("#frm-agreement").validate({
        rules: {
            'data[name]': {
                required: true,
            },
           
            'data[status]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const new_form = document.getElementById("frm-agreement");
            const data = new FormData(new_form);

            axios
                .post("/panel/agreement", data)
                .then(function (response) {
                    let result = response.data;
                    showInfo(2, 'dt-agreement', 'Datos actualizados', 'Información actualizada correctamente');
                    window.location = '/panel/agreement';
                })
                .catch(e => {
                });

        }
    });

    if (document.getElementById('frm-agreement') && $('#agreement_id').val() != 'null') {
        let agreement_id = $('#agreement_id').val();
        axios
            .get("/panel/agreement/" + agreement_id)
            .then(function (response) {
                let result    = response.data;
                let agreement = result.agreement;
                let financials   = result.financials;
                $('#agreement-name').val(agreement.name);
                $('#agreement-description').val(agreement.description);
                
                 // Limpia las selecciones actuales en el select múltiple
                $('#agreement-financials').val(null).trigger('change');

                $('#agreement-status').val(agreement.status).trigger("change");

                // Itera sobre periodicities y selecciona las opciones en product_periodicity_id
                let financialValues = financials.map(item => item.id);
                // Seleccionar los valores correspondientes en los selects
                $('#agreement-financials').val(financialValues).trigger('change');

                //$('#agreement-status option[value="' + agreement.status + '"]').trigger("change");
                
                
            })
            .catch(e => {
                $('#admin_email-error-exist').show();
            });
    }

    function getProductComision (product_id)
    {
        $('#content-costo-contratacion').html('');
        $('#comisiones').html('');
        axios
        .get("/panel/product-fee/" + product_id)
        .then(function (response) {
            let result    = response.data;
            $('#content-costo-contratacion').html(result.costoContratacion);
            $('#comisiones').html(result.comisiones);
            
        })
        .catch(e => {
            $('#admin_email-error-exist').show();
        });
    }

    if (document.getElementById('financial_product_id')) {
        let product_id = $('#product_id').val();
        getProductComision(product_id);
    }

    $("#frm-product-fees").validate({
        rules: {
            'data[concepto]': {
                required: true,
            },
            
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            let product_id = $('#financial_product_id').val();
            const new_form = document.getElementById("frm-product-fees");
            const data = new FormData(new_form);

            axios
                .post("/panel/product-fee", data)
                .then(function (response) {
                    getProductComision(product_id);
                    $('#modal-product-fees').modal('hide');
                    new_form.reset();
                    
                })
                .catch(e => {
                });

        }
    });

    //modal productfee
    window.modalProductComision = function(product_id, type)
    {
        $('#financial_product_id').val(product_id);
        $('#comision_type').val(type);
        $('#modal-product-fees').modal('show');
    }

    window.showValorFijo = function(show_fijo)
    {
        $('#content-valor-fijo').hide();
        $('#content-no-valor-fijo').hide();
        if (show_fijo) {
            $('#content-valor-fijo').show();
        } else {
            $('#content-no-valor-fijo').show();
        }
    }

});
