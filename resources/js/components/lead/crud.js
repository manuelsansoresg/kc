import { showInfo } from '../utilities';



$('.js-select2').select2({
    placeholder: "Escribe para buscar..",
    allowClear: true
});
$('.select2multiple').select2({
    placeholder: "Escribe para buscar..",
});

  $("#lead-agreement" ).change(function() {
    let lead_agreement = $("#lead-agreement" ).val();
    
    $('#lead-content-agreement').hide();
    
  
    if (lead_agreement == 0) {
        $('#lead-content-agreement').show('slow');
    }
    if (typeof lead_agreement === 'string' && lead_agreement.trim().length == 0) {
        $('#lead-content-agreement').hide();
    } else {
        getFinancial(lead_agreement);
    }
  });

  $("#lead-product-id" ).change(function() {
    let product_id = $("#lead-product-id" ).val();
    $('#content-financial').hide();
    if (product_id == 2) {
        $('#content-financial').show();
    }
  });

  function getFinancial(lead_id) {
    $('#lead-financial_id').empty();
    axios
        .get("/panel/lead/financial/"+lead_id+"/show")
        .then(function (response) {
            let result = response.data;
            if (result != null) {
                var lead_financial = $('#lead-financial_id');
                
                for (const key in result) {
                    const element = result[key];
                    var option = new Option(element.commercial_name, element.id, true, true);
                    lead_financial.append(option).trigger('change');
                    
                }
                $('#lead-financial_id').val(null).trigger('change');
            }
        })
    .catch(e => {
        $('#admin_email-error-exist').show();
    });
  }
  
  $("#lead-origin" ).change(function() {
    let origin_id = $("#lead-origin" ).val();
    $('#lead-channel').empty();
    var lead_channel = $('#lead-channel');
    axios
        .get("/panel/lead/"+origin_id+"/origin/")
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
        })
        .catch(e => {
            $('#admin_email-error-exist').show();
        });
  });

function setData() {
    let lead_id = $('#lead_id').val();
    
    axios
        .get("/panel/lead/" + lead_id)
        .then(function (response) {
            let result        = response.data;
            let lead          = result.lead;
            let channel       = result.channel;
            let financials    = result.financials;
            let product_id = lead.product_id;
            
            $('#lead-agreement').val(lead.agreement_id);
            $('#lead-agreement').trigger("change");
            
            $('#lead-product-id').val(lead.product_id);
            $('#lead-product-id').trigger("change");
            
            $('#lead-origin').val(lead.origin_id);
            $('#lead-origin').trigger("change");
            
            $('#lead-asesor-id').val(lead.asesor_id);
            $('#lead-asesor-id').trigger("change");

            
            $('#lead-type_id').val(lead.type_id);
            $('#lead-type_id').trigger("change");
            
            $('#lead-name').val(lead.name); 
            $('#lead-last_name').val(lead.last_name); 
            $('#lead-second_last_name').val(lead.second_last_name); 
            $('#lead-cellphone').val(lead.cellphone); 
            $('#lead-email').val(lead.email); 

            if (channel != null) {
                $('#lead-channel').empty();
                var lead_channel = $('#lead-channel');
                for (const key in channel) {
                    const element = channel[key];
                    if (element != 'Selecciona una opción') {
                       /*  var option = new Option(element, key, true, true);
                        lead_channel.append(option).trigger('change'); */
                    }
                    
                }
            }

            if (financials != null) {
                var lead_financial = $('#lead-financial_id');
                for (const key in result) {
                    const element = result[key];
                    var option = new Option(element.commercial_name, element.id, true, true);
                    lead_financial.append(option).trigger('change');
                    
                }
            }
            $('#content-financial').hide();
            if (product_id == 2) {
                $('#content-financial').show();
            }

            $('#lead-channel').val(lead.channel_id).trigger("change");
            $('#lead-financial_id').val(lead.financial_id).trigger("change");
            $('#lead-temperature-id').val(lead.financial_id).trigger("change");
        })
        .catch(e => {
            $('#admin_email-error-exist').show();
        });
}

window.deleteLead = function (lead_id) {
    axios
        .get("panel/lead/"+lead_id+"/delete")
        .then(function (response) {
            showInfo(2, 'dt-lead', 'Datos actualizados', 'Información actualizada correctamente');
        })
        .catch(e => {
            
        });
}


window.modalAdvisor = function (lead_id) {
    $('#lead_advisor_id').val(lead_id);
    $('#modal-advisor').modal('show');
}

$( "#frm-advisor" ).submit(function( event ) {
    event.preventDefault();
    let asesor_id   = $('#modal-advisor-id').val();
    let lead_id     = $('#lead_advisor_id').val();
    axios
        .post("panel/lead/"+lead_id+"/advisor/store", {asesor_id:asesor_id})
        .then(function (response) {
            showInfo(2, 'dt-lead', 'Datos actualizados', 'Prospecto asignado');
            $('#modal-advisor').modal('hide');
        })
        .catch(e => {
            
        });
});

window.createClientPerson = function(lead_id) {
    axios
    .post("panel/lead/"+lead_id+"/client-person/store")
    .then(function (response) {
        let result = response.data;
        showInfo(2, 'dt-lead', 'Datos actualizados', 'Cuenta creada');
    })
    .catch(e => {
        showToast('prospecto', 'Este email ya está registrado', 'warning');
    });
}

window.modalTags = function(lead_id) {
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

$( "#frm-tags" ).submit(function( event ) {
    event.preventDefault();
    let lead_id = $('#modal-tag-lead_id').val();
    const new_form = document.getElementById("frm-tags");
    const data = new FormData(new_form);

    axios
        .post("panel/lead/"+lead_id+"/tag/update", data)
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
                required: true,
            },
            'data[cellphone]': {
                number: true,
                minlength: 10
            },
            'data[email]': {
                required: true,
                email: true
            },
            'data[origin_id]': {
                required: true,
            },
            'data[channel_id]': {
                required: true,
            },
            'new_agreement': {
                required: function(element) {
                    let  lead_agreement = $("#lead-agreement").val();
                    if(lead_agreement == 0) { 
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

window.modalPasswod = function (user_id) {
    $('#password_user_id').val(user_id);
    $('#modal-user-password').modal('show');
}
//*id_rel is action_id
window.modalRegisterAction = function (id_rel) {
    $('#register-action-id-rel').val(id_rel);
    $('#modal-register-action').modal('show');
}

  $(document).ready(function(){
    if (document.getElementById('lead-channel')) {
        setData();
    }
    
  })

  $(document).on("select2:open", () => {
    document.querySelector(".select2-container--open .select2-search__field").focus()
  })