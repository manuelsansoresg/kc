import { showInfo } from '../utilities';



$('.js-select2').select2({
    placeholder: "Escribe para buscar..",
    allowClear: true
});
$('.select2multiple').select2({
    placeholder: "Escribe para buscar..",
});
//onchangeOrganization
window.organizationChange = function(lead_agreement_id, financial_id, other){
    
    if (other != null) {
        lead_agreement_id = 0;
        $('#new_agreement').val(other);
    }
    //alert(lead_agreement_id);
    if (lead_agreement_id != null) {
        $('#lead-agreement').val(lead_agreement_id).trigger("change");
    }

    let lead_agreement = $("#lead-agreement").val();

    $('#lead-content-agreement').hide();
    if (lead_agreement == 0) {
        $('#lead-content-agreement').show('slow');
    }
    if (typeof lead_agreement === 'string' && lead_agreement.trim().length == 0) {
        $('#lead-content-agreement').hide();
    } else {
        getFinancial(lead_agreement, financial_id);
    }
}

window.productChange = function(lead_product_id){
    $('#content-importe-solicitado').hide();
    $('#content-banco_nomina').hide();
    $('#content-tipo-credito').hide();
    $('#content-consulta-buro-credito').hide();
    $('#content-financial_product_id').hide();
    $('#content-aval-o-garantia').hide();
    $('#content-comment').hide();

    $('#lead-financial_id').val(null).trigger('change');
    if (lead_product_id != null) {
        $('#lead-product-id').val(lead_product_id).trigger("change");
    }
    let product_id = $("#lead-product-id").val();
    
    if (product_id == 2) { //portabilidad
        $('#content-financial_product_id').show();
        $('#content-importe-solicitado').show();
        $('#content-banco_nomina').show();
        $('#content-tipo-credito').show();
        $('#content-consulta-buro-credito').show();
        $('#content-aval-o-garantia').show();
    }
    
    if (product_id == 1) { //credito nuevo
        $('#content-importe-solicitado').show();
        $('#content-banco_nomina').show();
        $('#content-tipo-credito').show();
        $('#content-consulta-buro-credito').show();
        $('#content-aval-o-garantia').show();
    }

    if (product_id == 3) { //Asesoria
        
        $('#content-comment').show();
        $('#content-aval-o-garantia').hide();
    }
}



function getFinancial(lead_id, financial_id) {
    $('#lead-financial_id').empty();
    axios
        .get("/panel/lead/financial/" + lead_id + "/show")
        .then(function (response) {
            let result = response.data;
            $('#lead-financial_id').empty();
            if (result != null) {
                var lead_financial = $('#lead-financial_id');

                for (const key in result) {
                    const element = result[key];
                    var option = new Option(element.commercial_name, element.id, true, true);
                    lead_financial.append(option).trigger('change');

                }

                let lead_id = $("#lead_id").val();
                let history_id = $("#history_id").val();
                if (financial_id == null) {
                    $('#lead-financial_id').val(null).trigger('change');
                } else {
                    $('#lead-financial_id').val(financial_id).trigger('change');
                }
            }
        })
        .catch(e => {
            $('#admin_email-error-exist').show();
        });
}

window.getFinancialProduct = function(id, type) {
    axios
        .get("/panel/action/financial/product/" + id + "/"+type+'/show')
        .then(function (response) {
            let result    = response.data;
            let financials   = result.financials;
            console.log(financials);
            let financialValues = financials.map(item => item.product_id);
             // Limpia las selecciones actuales en el select múltiple
             $('#lead-financial-product-id').val(null).trigger('change');
             // Seleccionar los valores correspondientes en los selects
            $('#lead-financial-product-id').val(financialValues).trigger('change');
        })
        .catch(e => {
          
        });
}


window.setChannel = function(origin_id) {
    $('#lead-channel').empty();
    var lead_channel = $('#lead-channel');
    axios
        .get("/panel/lead/" + origin_id + "/origin/")
        .then(function (response) {
            let result = response.data;
            if (result != null) {
                for (const key in result) {
                    const element = result[key];
                    if (element != 'Selecciona una opción') {
                        var option = new Option(element, key, true, true);
                        lead_channel.append(option).trigger('change');
                    }
                }
            }

            $('#lead-channel').val(null).trigger('change');
            $('#lead-channel').val(change_channel).trigger("change");
            

        })
        .catch(e => {
            $('#admin_email-error-exist').show();
        });
}

if (document.getElementById('lead-origin-admin')) {
    setChannel(1);
}

window.changeOrigen = function (change_channel) {
    let origin_id = $("#lead-origin").val();
    let lead_id = $("#lead_id").val();
    $('#lead-channel').empty();
    
    var lead_channel = $('#lead-channel');
    axios
        .get("/panel/lead/" + origin_id + "/origin/")
        .then(function (response) {
            let result = response.data;
            if (result != null) {
                for (const key in result) {
                    const element = result[key];
                    if (element != 'Selecciona una opción') {
                        var option = new Option(element, key, true, true);
                        lead_channel.append(option).trigger('change');
                    }
                }
            }

            $('#lead-channel').val(null).trigger('change');
            if (change_channel != null) {
                $('#lead-channel').val(change_channel).trigger("change");
            }

        })
        .catch(e => {
            $('#admin_email-error-exist').show();
        });
}



/* $("#lead-origin" ).change(function() {
  
}); */

function setData(is_change_origen, is_change_organization) {
    let lead_id = $('#lead_id').val();

    axios
        .get("/panel/lead/" + lead_id)
        .then(function (response) {
            let result        = response.data;
            let lead          = result.lead;
            let channel       = result.channel;
            let financials    = result.financials;
            let product_id    = lead.product_id;
            let other         = lead.other;

            console.log(product_id);
            productChange(product_id);
            organizationChange(lead.agreement_id, lead.financial_id, other);
            
            getFinancialProduct(lead.id, 1);

            if (is_change_origen == true) {
                $('#lead-origin').val(lead.origin_id);
                $('#lead-origin').trigger("change");
            }

            $('#lead-asesor-id').val(lead.asesor_id);
            $('#lead-asesor-id').trigger("change");


            $('#lead-type_id').val(lead.type_id);
            $('#lead-type_id').trigger("change");

            $('#lead-name').val(lead.name);
            $('#lead-last_name').val(lead.last_name);
            $('#lead-second_last_name').val(lead.second_last_name);
            
            $('#lead-cellphone').val(lead.cellphone);
            
            $('#lead-email').val(lead.email);
            

            $('#lead-rfc').val(lead.rfc);
            


            if (document.getElementById('lead-manychat_id')) {
                $('#lead-manychat_id').val(lead.manychat_id);
            }
            $('#lead-comment').val(lead.comment);
            
            
           
            changeOrigen(lead.channel_id);
            
            $('#lead-temperature-id').val(lead.financial_id).trigger("change");
            
            $('#importe_solicitado').val(lead.importe_solicitado);
            $('#income').val(lead.income);
            $('#bank_id').val(lead.bank_id).trigger("change");
            $('#tipo_credito').val(lead.tipo_credito).trigger("change");
            $('#consulta_buro').val(lead.consulta_buro).trigger("change");

            checkDataLeadExist(document.getElementById('lead-cellphone'), 'cellphone'); // Call check after setting value
            checkDataLeadExist(document.getElementById('lead-email'), 'email'); // Call check after setting value
            checkDataLeadExist(document.getElementById('lead-rfc'), 'rfc'); // Call check after setting value

        })
        .catch(e => {
            $('#admin_email-error-exist').show();
        });
}

window.checkDataLeadExist = function (valInput, id)
{
    let getValue = valInput.value;
    let messageElement = document.getElementById(id+'-msg');
    if (valInput != '') {
        messageElement.textContent = "";
        axios
        .get("/panel/lead/"+getValue+"/"+id+"/check")
        .then(function (response) {
            let result = response.data;
            let isExist = result.exist;
            if (isExist > 0) {
                messageElement.textContent = "Ya está en uso";
            }
        })
        .catch(e => {
    
        });
    }
}

window.deleteLead = function (lead_id) {
    axios
        .get("panel/lead/" + lead_id + "/delete")
        .then(function (response) {
            showInfo(2, 'dt-lead', 'Datos actualizados', 'Información actualizada correctamente');
        })
        .catch(e => {

        });
}


window.modalAdvisor = function (lead_id) {
    $('#lead_advisor_id').val(lead_id);
    $('#type_id').val(1);
    $('#modal-advisor').modal('show');
}

window.modalAdvisorCredit = function (credit_id) {
    $('#credit_id').val(credit_id);
    $('#type_id').val(2);
    $('#modal-advisor').modal('show');
}

$("#frm-advisor").submit(function (event) {
    event.preventDefault();
    let asesor_id   = $('#modal-advisor-id').val();
    let lead_id     = $('#lead_advisor_id').val();
    let credit_id   = $('#credit_id').val();
    let type_id     = $('#type_id').val();
    let url         = "panel/lead/" + lead_id + "/advisor/store";
    let dt          = 'dt-lead';

    if (type_id == 2) {
        url = "panel/credit/" + credit_id + "/advisor/store";
        dt = 'dt-check-up';
    }

    axios
        .post(url, { asesor_id: asesor_id })
        .then(function (response) {
            showInfo(2, dt, 'Datos actualizados', 'Prospecto asignado');
            $('#modal-advisor').modal('hide');
        })
        .catch(e => {

        });
});

window.createClientPerson = function (lead_id) {
    axios
        .post("panel/lead/" + lead_id + "/client-person/store")
        .then(function (response) {
            let result = response.data;
            showInfo(2, 'dt-lead', 'Datos actualizados', 'Cuenta creada');
        })
        .catch(e => {
            showToast('prospecto', 'Este email ya está registrado', 'warning');
        });
}

window.modalTags = function (lead_id) {
    $('#modal-tag-lead_id').val(lead_id);
    $('#modal-tags').modal('show');
}

if (document.getElementById('frm-advisor')) {
    $('#modal-advisor-id').select2({
        dropdownParent: $('#modal-advisor'),
        placeholder: "Escribe para buscar..",
        allowClear: true
    });
}


if (document.getElementById('frm-tags')) {
    $('#modal-tags-tag').select2({
        dropdownParent: $('#modal-tags'),
        placeholder: "Escribe para buscar..",
        allowClear: true
    });
}

$("#frm-tags").submit(function (event) {
    event.preventDefault();
    let lead_id = $('#modal-tag-lead_id').val();
    const new_form = document.getElementById("frm-tags");
    const data = new FormData(new_form);

    axios
        .post("panel/lead/" + lead_id + "/tag/update", data)
        .then(function (response) {
            showInfo(2, 'dt-lead', 'Datos actualizados', 'Etiqueta actualizada');
            $('#modal-tags').modal('hide');
        })
        .catch(e => {

        });
});

$().ready(function () {
    $("#frm-lead").validate({
        rules: {
            'data[name]': {
                required: true,
            },
            'data[last_name]': {
                required: false,
            },
            'data[cellphone]': {
                number: true,
                minlength: 10
            },
            'data[email]': {
                required: false,
                email: true
            },
            'data[origin_id]': {
                required: true,
            },
            'data[channel_id]': {
                required: true,
            },
            'new_agreement': {
                required: function (element) {
                    let lead_agreement = $("#lead-agreement").val();
                    if (lead_agreement == 0) {
                        return true;
                    } else {
                        return false;
                    }
                }
            },

        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const new_form = document.getElementById("frm-lead");
            const data = new FormData(new_form);

            axios
                .post("/panel/lead", data)
                .then(function (response) {
                    let result = response.data;
                    window.location = '/panel/lead';
                })
                .catch(e => {
                });

        }
    });



});

/* modal vista previa perfil */
window.modalPreviewProfile =  function(lead_id)
{
    $('content-preview-profile').html('');
    axios
    .get("/panel/lead/"+lead_id+"/preview/profile")
    .then(function (response) {
        let result = response.data;
        $('#content-preview-profile').html(result);
        $('#modal-preview-profile').modal('show');
    })
    .catch(e => {
    });
}

window.modalPasswod = function (user_id) {
    $('#password_user_id').val(user_id);
    $('#modal-user-password').modal('show');
}
//*id_rel is action_id
window.modalRegisterAction = function (id_rel) {
    $('#register-action-id-rel').val(id_rel);
    $('#modal-register-action').modal('show');
}

$(document).ready(function () {
    if (document.getElementById('lead-channel')) {
        setData(true, true);
    }

})

$(document).on("select2:open", () => {
    document.querySelector(".select2-container--open .select2-search__field").focus()
})