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
                 // Itera sobre los elementos de financials y los agrega al select múltiple
                for (let i = 0; i < financials.length; i++) {
                    $('#agreement-financials').append(new Option(
                        financials[i].commercial_name + '-' + financials[i].alias,
                        financials[i].id,
                        true,
                        true
                    ));
                }

                // Actualiza Select2 después de agregar las opciones
                $('#agreement-financials').trigger('change');
                
                $('#agreement-status').val(agreement.status).trigger("change");

                //$('#agreement-status option[value="' + agreement.status + '"]').trigger("change");
                
                
            })
            .catch(e => {
                $('#admin_email-error-exist').show();
            });
    }

});
