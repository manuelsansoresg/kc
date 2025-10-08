import { showInfo } from '../utilities';
import RfcFacil from 'rfc-facil'

window.setRfc = function () {
    const nacimiento = $('#lead-birth_date').val()
    const my_lastname = $('#lead-last_name').val()
    const my_secondlastname = $('#lead-second_last_name').val()
    const my_name = $('#lead-name').val()
  
    const [my_year, my_month, my_day] = nacimiento.split('-');

   
  
    const rfc = RfcFacil.forNaturalPerson({
      name: my_name,
      firstLastName: my_lastname,
      secondLastName: my_secondlastname,
      day: my_day,
      month: my_month,
      year: my_year
    })
    return rfc
  }

  window.createRfc = function()
  {
    var rfc = setRfc();
    $('#lead-rfc').val(rfc);
    checkDataLeadExist(document.getElementById('lead-rfc'), 'rfc'); // Call check after setting value
  }

$('.js-select2').select2({
    placeholder: "Escribe para buscar..",
    allowClear: true
});
$('.select2multiple').select2({
    placeholder: "Escribe para buscar..",
});
//onchangeOrganization
window.organizationChange = function(lead_agreement_id, financial_id, other, applied_financial_product){
    
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
        getFinancialByAgreement(lead_agreement, applied_financial_product);
    }
}

window.productChange = function(lead_product_id){
    $('#content-importe-solicitado').hide();
    /* $('#content-banco_nomina').hide(); */
    //$('#content-tipo-credito').hide();
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
        /* $('#content-banco_nomina').hide(); */
        $('#content-producto-financiero').show();
        $('#content-consulta-buro-credito').hide();
        $('#content-aval-o-garantia').hide();
        $('#content-ingreso-mensual').show();
    }
    
    if (product_id == 1) { // credito nomina
        /* $('#content-banco_nomina').hide(); */
        $('#content-importe-solicitado').show();
        $('#content-producto-financiero').show();
        $('#content-tipo_tramite').show();
        $('#content-tipo-credito').show();
        $('#content-consulta-buro-credito').hide();
        $('#content-aval-o-garantia').hide();
        $('#content-ingreso-mensual').show();
    }
    if (product_id == 4) { // on-demand
        $('#content-producto-financiero').show();
        $('#content-ingreso-mensual').hide();
    }
    if (product_id == 3) { //Asesoria
        
        $('#content-comment').show();
        $('#content-aval-o-garantia').hide();
    }
}

function getFinancialByAgreement(agreementId, applied_financial_product)
{
    const selectElement = document.getElementById('applied_financial_product');
    selectElement.options.length = 0; // Limpiar el select

    axios
        .get("/panel/agreement/" + agreementId + "/financial-product/show")
        .then(function (response) {
            let financialProducts = response.data;
            Object.keys(financialProducts).forEach(key => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = financialProducts[key];
                selectElement.appendChild(option);
            });
            
            if (applied_financial_product != 'null') {
                $('#applied_financial_product').val(applied_financial_product).trigger("change");
            }
        })
        .catch(e => {
        });
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



window.validateLeadEdit = function(lead_id)
{
    let cellphone = $('#lead-cellphone').val();
    let rfc = $('#lead-rfc').val();
    axios
        .get("/panel/lead/"+cellphone+"/"+rfc+ "/"+lead_id +"/get/validate")
        .then(function (response) {
            let result = response.data;
            let isValidate = result.isValidate;
            let contentValidaciones = result.msg;

            

            let client_person_id = $('#client_person_id').val();
            if (isValidate == true) {
                $('#is_viability').val(1);
                $('#content-servicio-kc').show();
                $('#prospecto-valido').val('Prospecto válido');
                $('#content-validaciones').show();
                $('#content-validaciones').html(contentValidaciones);
            } else {
                $('#content-validaciones').html(contentValidaciones);
                $('#is_viability').val(0);
                $('#content-servicio-kc').hide()
                $('#prospecto-valido').val('');
            }
            showContentIsValidate();
        })
    .catch(e => {

    });
}

window.showContentIsValidate = function()
{
    let is_viability   = $('#is_viability').val();
    let clientPersonId = $('#client_person_id').val();
    //perfil-cliente
    
    if (is_viability == 1) {
        $('.perfil-cliente').each(function() {
            $(this).attr('href', '/panel/client/' + clientPersonId);
        });
    }
}

function setData(is_change_origen, isChange, isChangeBirthDay) {

            let lead_id = $('#lead_id').val();

            axios
                .get("/panel/lead/" + lead_id)
                .then(function (response) {
                    let result        = response.data;
                    let lead          = result.lead;
                    let is_viability  = lead.is_viability;
                    let is_viability_credit = lead.is_viability_credit;
                    $('#tramit_type').prop('disabled', true);
                    setTimeout(() => {
                        console.log('finish');
                        $('#tramit_type').prop('disabled', false);
                        $('#tramit_type').val(lead.tramit_type).trigger("change");
                    }, 7000);
                    //productChange(product_id);
                    //organizationChange(lead.agreement_id, lead.financial_id, other, lead.applied_financial_product);
                    $('#lead-origin-agreement').val(lead.agreement_id);

                    getProductsByAgreementId(lead.agreement_id, lead.financial_product_id);
                    
                    //getFinancialProduct(lead.id, 1);

                    if (is_change_origen == true) {
                        $('#lead-origin').val(lead.origin_id);
                        $('#lead-origin').trigger("change");
                    }

                    $('#lead-asesor-id').val(lead.asesor_id);
                    $('#lead-asesor-id').trigger("change");


                    /* $('#lead-type_id').val(lead.type_id);
                    $('#lead-type_id').trigger("change"); */

                    $('#lead-name').val(lead.name);
                    if (isChangeBirthDay == true) {
                        $('#lead-birth_date').val(lead.birth_date);
                    }
                    $('#lead-last_name').val(lead.last_name);
                    $('#lead-second_last_name').val(lead.second_last_name);
                    
                    $('#lead-cellphone').val(lead.cellphone);
                    
                    $('#lead-email').val(lead.email);
                    

                    $('#lead-rfc').val(lead.rfc);
                    


                    if (document.getElementById('lead-manychat_id')) {
                        $('#lead-manychat_id').val(lead.manychat_id);
                    }
                    $('#lead-comment').val(lead.comment);
                    $('#client_person_id').val(lead.client_person_id);
                    validateLeadEdit(lead_id); // Luego ejecuta validateLeadEdit
                    
                    //changeOrigen(lead.channel_id);
                    
                    
                    $('#lead-temperature-id').val(lead.financial_id).trigger("change");
                    
                    $('#importe_solicitado').val(lead.importe_solicitado);
                    $('#income').val(lead.income);
                    $('#bank_id').val(lead.bank_id).trigger("change");
                    $('#tipo_credito').val(lead.tipo_credito).trigger("change");
                    $('#consulta_buro').val(lead.consulta_buro).trigger("change");
                    $('#lead-agreement').val(lead.agreement_id).trigger("change");
                    

                    if (isChange == true) {
                        checkDataLeadExist(document.getElementById('lead-cellphone'), 'cellphone'); // Call check after setting value
                        checkDataLeadExist(document.getElementById('lead-email'), 'email'); // Call check after setting value
                        checkDataLeadExist(document.getElementById('lead-rfc'), 'rfc'); // Call check after setting value
                        
                    }
                    $('#applied_loan_type').val(lead.applied_loan_type).trigger("change");

                    // Get the checkbox elements
                    let checkboxViability = document.getElementById('is_viability');
                    let checkboxViabilityCredit = document.getElementById('is_viability_credit');

                    // Set the checked property based on the variables
                    checkboxViability.checked = is_viability === 1;
                    checkboxViabilityCredit.checked = is_viability_credit === 1;
                    
                    

        })
        .catch(e => {
            $('#admin_email-error-exist').show();
        });
    
}

window.checkDataLeadExist = function (valInput, id)
{
    let getValue = valInput.value;
    let messageElement = document.getElementById(id+'-msg');
    let lead_id = $('#lead_id').val() || null;
    
    $('#content-validaciones').html('');
    if (getValue != '') {
        messageElement.textContent = "";
        axios
        .get("/panel/lead/"+getValue+"/"+id+"/"+lead_id+"/check")
        .then(function (response) {
            
            let result = response.data;
            let isExist = result.exist;
            let clientPerson = result.clientPerson;
            let isValidate = result.isValidate;
            let creditStatus = result.creditStatus;

            $('#lead_id').val(result.lead.id);
            getLeadValidations();
            $('#isNew').val(0);
            
            

            if (id == 'cellphone') {
                $('#content-validaciones-phone').html(result.contentValidaciones);
            } else{
                $('#content-validaciones-rfc').html(result.contentValidaciones);
            }
            //$('#content-validaciones').html(result.contentValidaciones);
            if (typeof clientPerson !== 'undefined' && clientPerson && clientPerson.id) {
             
                $('.perfil-cliente').each(function() {
                    $(this).attr('href', '/panel/client/' + clientPerson.id);
                });
            }
            if (isExist > 0 && isValidate == true) {
                $('#client_person_id').val(clientPerson.id);

                $('#content-servicio-kc').show();
                getProductsByAgreementId(clientPerson.agreement_id, null)


                messageElement.classList.remove("text-danger");
                messageElement.classList.add("text-primary");
                messageElement.textContent = "Validación exitosa";
                $('#is_viability').val(1);
                //$('#lead_id').val(clientPerson.id);
                $('#prospecto-valido').val('Prospecto válido');
                
                
                $('#lead-origin-agreement').val(clientPerson.agreement_id);
                if (id == 'cellphone') {
                    $('#isValidateCellphone').val(result.isValidate);
                    $('#cellphone_validated').val(1);
                    $('#rfc_validated').val(0);
                }
                
                if (id == 'rfc') {
                    $('#cellphone_validated').val(0);
                    $('#rfc_validated').val(1);
                }
                
                $('#lead-name').val(clientPerson.name);
                $('#lead-last_name').val(clientPerson.last_name);
                $('#lead-second_last_name').val(clientPerson.second_last_name);
                $('#lead-birth_date').val(clientPerson.birth_date);
                $('#lead-rfc').val(clientPerson.rfc);
                $('#lead-email').val(clientPerson.email);
                $('#lead-agreement').val(clientPerson.agreement_id).trigger("change");
                
                if (id == 'cellphone') {
                    $('#content-validaciones-phone').html('');
                } else{
                    $('#content-validaciones-rfc').html('');
                }
                
            } else {
                
                messageElement.classList.remove("text-primary");
                messageElement.classList.add("text-danger");
                messageElement.textContent = "Validación fallida";
                $('#content-servicio-kc').hide();
                $('#prospecto-valido').val('');
                $('#is_viability').val(0);
            }

            

        })
        .catch(e => {
    
        });
    }
}

window.showModalCompraCartera = function() {
    let lead_id = $('#lead_id').val();
    let client_person_id = $('#client_person_id').val();
    $('#lead_id_compra_cartera').val(lead_id);
    $('#client_person_id_compra_cartera').val(client_person_id);
    $('#creditPayOffId').val('');
    document.getElementById("frm-modal-compra-cartera").reset();
    $('#frm-modal-compra-cartera .js-select2').val(null).trigger('change');

    $('#modal-compra-cartera').modal('show');
}


window.showTableCompraCartera = function (leadId)
{
    $('#content-table-compra-cartera').html('');
    $('#resumen-deuda-capital').val('');
    console.log('inicio compracartera');
    axios
    .get("/panel/lead/credit-pay-off/"+leadId)
    .then(function (response) {
        let result = response.data;
        let table = result.table;
        let total = result.total;
        let montoEntregar = $('#hmonto-entregar').val();
        console.log('axios');
        $('#content-monto-compra-cartera').html(total.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        
        $('#resumen-deuda-capital').val(total);
        $('#content-monto-entregar').html(total - montoEntregar );
        $('#content-table-compra-cartera').html(table);

        var leadIdValue = document.getElementById('lead_id').value;
        var verGraficaLink = document.getElementById('ver-grafica');
        verGraficaLink.setAttribute('href', '/grafica/' + leadIdValue);
    })
    .catch(e => {
        console.log('error elementos compra de cartera');
    });
}

$("#frm-modal-compra-cartera").submit(function (event) {
    event.preventDefault();
    const new_form = document.getElementById("frm-modal-compra-cartera");
    const data = new FormData(new_form);
    let leadId = $('#lead_id_compra_cartera').val();
    console.log(leadId);
    axios
        .post("/panel/lead/credit-pay-off", data)
        .then(function (response) {
            let result = response.data;
            $('#modal-compra-cartera').modal('hide');
            showTableCompraCartera(leadId);
            

        })
        .catch(e => {

        });
});

window.deleteCompraCartera = function(creditPayOffId)
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
            .delete("/panel/lead/credit-pay-off/"+creditPayOffId)
            .then(function (response) {
                let leadId =  document.getElementById("lead_id").value;
                showTableCompraCartera(leadId);
            }).catch(e => {
                
            });
        }
    });

       
}

window.editCompraCartera = function(creditPayOffId)
{
    axios
    .get("/panel/lead/credit-pay-off/"+creditPayOffId+'/data/get')
    .then(function (response) {
        let result = response.data;
        $('#compra-cartera-financial_product_id').val(result.financial_product_id).trigger("change");
        $('#compra-cartera-ammount').val(result.ammount);
        $('#creditPayOffId').val(creditPayOffId);
        $('#modal-compra-cartera').modal('show');
    }).catch(e => {
        
    });
}



window.getProductsByAgreementId = function(leadId, productId)
{
    let clientPersonId = $('#client_person_id').val();
    const selectElement = document.getElementById('financial_product_id');
    selectElement.options.length = 0; // Limpiar el select
    axios
    .get("/panel/lead/" + leadId + '/' + clientPersonId + "/getProducts")
    .then(function (response) {
        let products = response.data;
            Object.keys(products).forEach(key => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = products[key];
                selectElement.appendChild(option);
            });

        if (productId != 'null') {
            $('#financial_product_id').val(productId).trigger("change");
        }
        
    })
    .catch(e => {

    });
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

function getAllValidate()
{
    let clientPersonId = $('#client_person_id').val();
    let agreement = $('#lead-origin-agreement').val();
    let productId = $('#financial_product_id').val();
    let lead_id = $('#lead_id').val(result.id);
    axios
        .get("/panel/lead/"+clientPersonId+"/"+agreement+"/"+productId+'/'+lead_id+"/soad/get")
        .then(function (response) {
           
        })
        .catch(e => {
        });
}


window.saveLead = function (isFullSave)
{

    const new_form = document.getElementById("frm-lead");
    const data = new FormData(new_form);
    data.append('isFullSave', isFullSave);
    axios
        .post("/panel/lead", data)
        .then(function (response) {
            let getResult = response.data;
            let result = getResult.lead;
            $('#lead_id').val(result.id);
            $('#isNew').val(0);
            getLeadValidations();
        })
        .catch(e => {
        });
}

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
            data.append('isFullSave', 'true');
            let isExport = $('#isExport').val();

            axios
                .post("/panel/lead", data)
                .then(function (response) {
                    let getResult = response.data;
                    let result = getResult.lead;
                    if (isExport == 'true') {
                        $('#lead_id').val(result.id);
                        
                        //exportar
                        exportLead(result.id);
                        
                    } else {
                        window.location = '/panel/lead';

                    }
                })
                .catch(e => {
                });

        }
    });
    
    async function exportLead(leadId) {
        const fileName = 'KC - Datos exportados'+leadId+'.csv'; // Replace with your logic
        const formData = new FormData();
        formData.append('lead_id', leadId);
      
        const response = await axios.post("/panel/lead/"+leadId+"/data/export", formData, { responseType: 'blob' });
      
        const blob = new Blob(["\ufeff", response.data], { type: 'text/csv;charset=utf-8' });
      
        if (window.navigator && window.navigator.msSaveOrOpenBlob) {
          window.navigator.msSaveOrOpenBlob(blob, fileName);
        } else {
          const link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = fileName;
          link.click();
        }
        $('#isExport').val(false);
      }

});

window.saveAndExportLead = function ()
{
    $('#isExport').val(true);
    document.getElementById('btnSave').click();
}

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


//llenar tipo de tramite
function setSelectTramite(clientPersonId, financialProductId, tipoTramiteId)
{
    const selectElement = document.getElementById('tramit_type');
    selectElement.options.length = 0; // Limpiar el select
    $('#content-validaciones-soad-tramite').html('');
    $('#content-error-producto-preautorizado').hide();
    let typeProductId = $('#typeProductId').val()
    let leadId = $('#lead_id').val();
    let productId = $('#financial_product_id').val();

    axios
    .get("/panel/lead/" + clientPersonId +"/"+financialProductId+"/"+leadId+"/tramite/get")
    .then(function (response) {
        let result = response.data;
        let sodIsTramite = result.sodIsTramite;
        let sodMessage = result.sodMessage;
        let sodTramites = result.sodTramites;
        
        if (sodIsTramite == true) {
            
            $('#content-product-select').hide();
            Object.keys(sodTramites).forEach(key => {
                            const option = document.createElement('option');
                            option.value = key;
                            option.textContent = sodTramites[key];
                            selectElement.appendChild(option);
                        });
        } else {
            $('#content-product-select').show();
            $('#content-error-producto-preautorizado').show();
        }

        
    
        if (tipoTramiteId != 'null') {
            $('#tramit_type').val(tipoTramiteId).trigger("change");
        }
        if (typeProductId != 3 && typeProductId != '') {
            $('#content-validaciones-soad-tramite').html(sodMessage);
        }

        
       
    })
    .catch(e => {

    });


    
}

//contenido tramite al cambiar el select si selecciona refinanciamiento
window.changeTramite = function()
{
    let tramit_type = $('#tramit_type').val();
    let clientPersonId = $('#client_person_id').val();
    let productId = $('#financial_product_id').val();
    let typeProductId = $('#typeProductId').val();
    let leadId =  document.getElementById("lead_id").value;
    
    $('#content-product-select').hide();
    $('#content-product').hide();
    $('#content-refinanciado').hide();
    $('#product-deseado-refinanciamiento').hide();
    $('#content-product-deseado-refinanciamiento').html('');

    
    if (typeProductId != 3 && typeProductId != '') {
        $('#content-validaciones-plazo').html('<p>Validar Crédito Seleccionado / Plazo seleccionado / <span class="text-danger"> Sin seleccionar  </span> </p>');
        $('#content-validaciones-monto').html('<p>Validar Crédito Seleccionado / Importe seleccionado / <span class="text-danger"> Sin seleccionar  </span> </p>');
    }
    
    
    //
    if (tramit_type == 3 || tramit_type == 2 || tramit_type == 1) {
        axios
        .get("/panel/lead/"+clientPersonId+"/"+productId+"/"+tramit_type+"/refinanciamiento/get")
        .then(function (response) {
            let result = response.data;
            let montoMaximo = result.montoMaximo;
            let plazoMaximo = result.plazoMaximo;
            let periodicidad = result.periodicidad;
            let payment = result.payment;
            let productoDeseado = result.productoDeseado;
            let terms = result.terms;
            
            
            
            

            $('#monto-maximo').val(montoMaximo);
            $('#plazo-maximo').val(plazoMaximo);
            $('#periodicidad').val(periodicidad);
            $('#periodicidad-hidden').val(result.periodicidad_id);
            $('#pago-periodico').val(payment);
            
            if (typeProductId != 3) {
                $('#content-product-select').show();
                $('#content-refinanciado').show();
            } 

            
            $('#product-deseado-refinanciamiento').show();
            $('#content-product-deseado-refinanciamiento').html(productoDeseado);

            const selectTramite = document.getElementById('ref-plazo');
            selectTramite.options.length = 0; // Limpiar el select

            const defaultOption = document.createElement('option');
            defaultOption.value = ''; // Value vacío
            defaultOption.textContent = 'Seleccione una opción'; // Texto de la opción
            selectTramite.appendChild(defaultOption);

            Object.keys(terms).forEach(key => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = terms[key];
                selectTramite.appendChild(option);
            });

            if (typeProductId == 2) {
                showTableCompraCartera(leadId);
            }
            saveLead(false);
            
        }).catch(e => {
        
        });
    }
   
}

window.graficaProspecto = function()
{
    getChart();
    $('#modal-chart').modal('show');
}




window.getMontoSolicitado = function() {
    let clientPersonId = $('#client_person_id').val();
    let productId = $('#financial_product_id').val();
    let plazo = $('#ref-plazo').val();
    let creditElement = document.getElementById('controldesk-credit_id');
    let creditId = creditElement ? creditElement.value : null;
    let tramit_type = $('#tramit_type').val();
    let typeProductId = $('#typeProductId').val();
    // Obtiene todos los checkboxes con nombre 'credits[]'
    var checkboxes = document.querySelectorAll('input[name="credits[]"]:checked');
    
    // Inicializa un array para guardar los valores seleccionados
    var credits = [];

    // Itera sobre los checkboxes seleccionados y almacena sus valores
    checkboxes.forEach(function(checkbox) {
        credits.push(checkbox.value);
    });
    const selectMontoMaximo = document.getElementById('ref-monto');
    selectMontoMaximo.options.length = 0; // Limpiar el select

    $('#total-refinanciable').val(0);

    axios
    .post("/panel/lead"+'/'+clientPersonId+"/"+productId+"/"+tramit_type+"/"+creditId+"/montoMaximo/get", { credits:credits, plazo:plazo })
    .then(function (response) {
        let result = response.data;
        let maximo = result.maximo;
        let total = result.total;
        let total_price = result.total_price;
        
        
        const defaultOption = document.createElement('option');
        defaultOption.value = ''; // Value vacío
        defaultOption.textContent = 'Seleccione una opción'; // Texto de la opción
        selectMontoMaximo.appendChild(defaultOption);
        
        Object.keys(maximo).forEach(key => {
            const option = document.createElement('option');
            option.value = key;
            option.textContent = maximo[key];
            selectMontoMaximo.appendChild(option);
        });

        $('#table-refinanciamiento-total').html(total_price);
        
        $('#total-refinanciable').val(total);
        
        if (typeProductId != 3 && typeProductId != '') {
            let plazosolicitado = $('#ref-plazo').val();
            if (plazosolicitado != '') {
                $('#content-validaciones-plazo').html('<p>Validar Crédito Seleccionado / Plazo seleccionado / <span class="text-primary"> Seleccionado  </span> </p>');
            }
        }
        
        getResumen();

    }).catch(e => {
    
    });
}

function parseCurrency(value) {
    if (!value) return 0; // Si el valor es null, vacío o undefined, devolver 0
    let cleanValue = value.replace(/[^\d.]/g, ''); // Elimina cualquier caracter que no sea número o punto decimal
    return parseFloat(cleanValue) || 0; // Convierte a número, si falla devuelve 0
}



window.getResumen = function()
{
    
    let clientPersonId = $('#client_person_id').val();
    let productId = $('#financial_product_id').val();
    let plazo = $('#ref-plazo').val();
    let monto = $('#ref-monto').val();
    let adicional = '';
    
    if (document.getElementById('ref-monto-new')) {
        monto = $('#ref-monto-new').val();
    }

    if (document.getElementById('isControlDesk')) {
        let creditId = $('#controldesk-credit_id').val();
        adicional = '?credit_id='+creditId;
    }
    
    /* if (document.getElementById('ref-monto-new')) {
        let montoNuevo = $('#total-refinanciable').val();
        const newMontoSolicitado = Math.min(compraCartera, montoSolicitado);
    } */


    let totalRefinanciable = $('#total-refinanciable').val();
    let tramit_type = $('#tramit_type').val();
    let typeProductId = $('#typeProductId').val();
    
    $('#go_ahead').val(0);
    axios
    .get("/panel/lead/"+productId+"/"+plazo+'/'+(monto || 0)+'/'+(totalRefinanciable || 0)+'/'+tramit_type+'/getResumen'+adicional)
    .then(function (response) {
        let result = response.data;
        let montoSolicitado =  result.montoSolicitado;
        
        let montoRefinanciar =  result.montoRefinanciar;
        let comision =  result.comision;
        let monto_entregar =  result.monto_entregar;
        let montoEntregarDecimal =  null;
        let periodicidad =  result.periodicidad;
        let plazo =  result.plazo;
        let pagoPeriodico =  result.pagoPeriodico;
        let pagoPeriodicoSF =  result.pagoPeriodico_sf;
        let pagoTotal = result.pagoTotal;
        let tasaAnual = result.tasaAnual;
        let cat = result.cat;
        let kcInteres = result.kcInteres;
        let kcPagoTotal = result.kcPagoTotal;

        
        
        let productoFinanciero = $('#financial_product_id').val();
        $('#selected_term').val(plazo);
        $('#selected_loan').val(result.montoSolicitado_sf);
        $('#selected_payment').val(pagoPeriodicoSF);
        $('#selected_total_credit').val(result.pagoTotalSF);
        $('#applied_financial_product').val(productoFinanciero);

        $('#content-monto-solicitado').html(montoSolicitado);
        $('#content-monto-refinanciar').html(montoRefinanciar);
        $('#content-comision-apertura').html(result.comision);
        
        

        if (document.getElementById('total-monto-solicitado')) {
            $('#content-monto-compra-cartera').html('');
            
            $('#content-monto-compra-cartera').html($('#total-monto-solicitado_format').val());
           
            
        } 

        let cMontoSolicitado = result.montoSolicitado_sf;
        let cMontoCompraCartera = $('#content-monto-compra-cartera').length && $('#content-monto-compra-cartera').text().trim() 
                          ? parseCurrency($('#content-monto-compra-cartera').text().trim()) 
                          : 0;

        let cComisionApertura = $('#content-comision-apertura').length && $('#content-comision-apertura').text().trim() 
                                ? parseCurrency($('#content-comision-apertura').text().trim()) 
                                : 0;
        
        let cMontoRefinanciar = $('#content-monto-refinanciar').length && $('#content-monto-refinanciar').text().trim() 
        ? parseCurrency($('#content-monto-refinanciar').text().trim()) 
        : 0;

        //console.log(cMontoSolicitado + '-' + cMontoCompraCartera + '-'+cComisionApertura);
        montoEntregarDecimal = cMontoSolicitado - cMontoCompraCartera - cComisionApertura - cMontoRefinanciar;
        
        monto_entregar = montoEntregarDecimal.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        
        $('#content-monto-entregar').html(result.monto_entregar);
        $('#content-plazo').html(periodicidad);
        $('#content-monto').html(plazo);
        $('#content-pago-periodico').html(pagoPeriodico);
        
        $('#applied_payment').val(pagoPeriodicoSF);
        $('#applied_loan_total_amount').val(result.pagoTotalSF);
        $('#opening_commission').val(result.comisionSF);
        $('#net_amount').val(montoEntregarDecimal);
        
        $('#content-pago-total').html(pagoTotal);
        $('#content-tasa-anual').html(tasaAnual);
        $('#content-cat').html(cat);
        $('#hmonto-entregar').val(montoEntregarDecimal);
        
        
        getChart();

        $('#go_ahead').val(1);
     

        if (typeProductId !=  3) {
            $('#content-validaciones-plazo').html('<p>Validar Crédito Seleccionado / Plazo seleccionado / <span class="text-danger"> Sin seleccionar  </span> </p>');
            $('#content-validaciones-monto').html('<p>Validar Crédito Seleccionado / Importe seleccionado / <span class="text-danger"> Sin seleccionar  </span> </p>');   
            let plazosolicitado = $('#ref-plazo').val();
            let montosolicitado = $('#ref-monto').val();
            if (plazosolicitado != '') {
                $('#content-validaciones-plazo').html('<p>Validar Crédito Seleccionado / Plazo seleccionado / <span class="text-primary"> Seleccionado  </span> </p>');
            }
            
            if (montosolicitado != '') {
                $('#content-validaciones-monto').html('<p>Validar Crédito Seleccionado / Importe seleccionado / <span class="text-primary"> Seleccionado  </span> </p>');   
            }
        }

        if (document.getElementById('validateBtnSave') && montoEntregarDecimal <= 0) {
            $('#saveButton').hide();
        } else {
            $('#saveButton').show();
        }
        saveLead(false)
            .then(() => {
                getLeadValidations();
            })
            .catch(error => {
                console.error('Error saving lead:', error);
            });
    }).catch(e => {
    
    });
}

function getChart()
{
    let productId = $('#financial_product_id').val();
    let leadId = $('#lead_id').val();
    let plazo = $('#plazo-maximo').val();
    let monto = $('#monto-maximo').val();

    axios
        .get("/panel/lead/"+productId+"/"+leadId+"/"+plazo+'/getChart')
            .then(function (response) {
                let result = response.data;

                $('#ahorro-interes-dinero').html(result.ahorroInteresDinerom);
                $('#ahorro-interes-porcentaje').html(result.ahorroInteresPorcentaje);
                
                $('#lbl-kc-pago-total').html(result.deudaPagoTotalm);
                $('#lbl-kc-porcentaje-interes').html(result.deudaPorcentajeInteresm);
               
                $('#lbl-deuda-pago-total').html(result.kcPagoTotal);
                $('#lbl-deuda-porcentaje-interes').html(result.kcPorcentajeInteres);

                  
                // Crear múltiples gráficas de ejemplo con alturas dinámicas
                crearGraficaApilada(chartsContainer, result.deudaInteres, result.deudaCapital, '#a34444', '#757575', "Interés", "Deuda total <br> de tus créditos");
                crearGraficaApilada(chartsContainer, result.kcInteres, result.kcCapital, '#7eb1a2', '#57409b', "Interés", "Kaax Club");


            })
    .catch(e => {
    });
}
//validar soad activo y si existe la fecha en bd
window.validateSoad = function()
{
    $('#content-refinanciado').hide();
    $('#content-validaciones-soad').html('');
    $('#content-validaciones-soad-date').html('');
    $('#content-product').html('');
    $('#content_tramit_type').hide();
    $('#content-validaciones-soad-tramite').html('');
    $('#go_ahead').val(0);
    $('#loan_available-msg').html('');
    $('#producto-deseado').hide();

    if ($('#financial_product_id').val() != null) {
        
        let clientPersonId = $('#client_person_id').val();
        let agreement = $('#lead-origin-agreement').val();
        let productId = $('#financial_product_id').val();
        let lead_id = $('#lead_id').val();
        $('#content-error-producto-preautorizado').hide();
        axios
        .get("/panel/lead/"+clientPersonId+"/"+agreement+"/"+productId+"/"+lead_id+"/soad/get")
        .then(function (response) {
            getLeadValidations();
            let result = response.data;
            let typeProductId = result.type_product_id;
            let tramitePendiente = result.tramitePendiente;

            $('#typeProductId').val(typeProductId);
            
            $('#loan_available-msg').html(result.loan_available);
            document.getElementById('tramit_type').disabled = false;
            if (typeProductId == 3) {
                console.log('typeProductId-'+typeProductId);
                $('#producto-deseado').show();
                document.getElementById('slider').disabled = true;
                document.getElementById('tramit_type').disabled = true;
            }

            if ($('#is_viability').val() == 1 ) {
                
                
                //getAllValidate();
            }

            $('#content_tramit_type').show();
                //llenar el arreglo de tipo de trámite
                setSelectTramite(clientPersonId, productId, null);
            

            if (typeProductId == 3 ) {
                let TextSoad = result.TextSoad;
                let soadActive = result.soadActive;
                let isSoadDate = result.isSoadDate;
                let isSodOnDate = result.isSodOnDate;
                

                $('#product_id').val(typeProductId);
                
                
                $('#is_free_of_active_sod').val(0);
                $('#is_sod_on_date_allowed').val(0);
                if (soadActive != 0) {
                    $('#content-validaciones-soad').html(TextSoad);
                    $('#is_free_of_active_sod').val(1);
                    
                }
                $('#is_sod_on_date_allowed').val(1);
                $('#sod_max').val(result.maximoRedondeado);
                $('#sod_min').val(result.minimoRedondeado);
                
              
        
                $('#content-validaciones-soad-date').html(isSoadDate);
                
                if (isSodOnDate == true && tramitePendiente == true) {
                    document.getElementById('slider').disabled = false;
                    $('#content-product').html(result.contentProductSod);
                    $('#go_ahead').val(1);
                    //valores slider
                    var slider = document.getElementById('slider');
                    slider.min = result.minimoRedondeado;
                    slider.max = result.maximoRedondeado;
                    $('#valor-minimo').html(result.minimoRedondeado);
                    $('#valor-maximo').html(result.maximoRedondeado);
                    $('#valor-comision').html('$'+result.comision);
                    $('#sod_commision_amount').val(result.comision);
                    $('#valor-banco').html(result.bank_name);
                    $('#valor-cuenta').html(result.cuenta);
                    
                    $('#content-product-select').show();
                    
                    const selectElement = document.getElementById('tramit_type');
                    selectElement.options.length = 0; // Limpiar el select
                    let sodTramites = result.sodTramites;
                    Object.keys(sodTramites).forEach(key => {
                            const option = document.createElement('option');
                            option.value = key;
                            option.textContent = sodTramites[key];
                            selectElement.appendChild(option);
                        });
                    $('#content_tramit_type').show();
                    
                }
                
                
            }
        })
        .catch(e => {
        });
    }
}

if (document.getElementById('valor-slider')) {
    function updateSliderValue() {
        var slider = document.getElementById('slider');
        var displayValue = document.getElementById('valor-slider');
        
        // Obtenemos el valor actual del slider
        var sliderValue = parseFloat(slider.value);
        
        // Actualizamos el contenido del span con el valor actual del slider
        displayValue.innerHTML = '$' + sliderValue;
        $('#sod_withdraw_amount').val(sliderValue);
        let comision = parseFloat($('#sod_commision_amount').val());
        let total = sliderValue + comision;
        console.log('slider-'+sliderValue);
        console.log('comision-'+comision);  
        if (!isNaN(total)) {
            $('#sod_total_payment').val(total);
            
        } else {
            $('#sod_total_payment').val(0); // O puedes asignar un valor por defecto si es NaN
            total = 0;
        }
        $('#valor-total').html('$'+total);
    }

    // Agregar el listener al slider para detectar cambios
    document.getElementById('slider').addEventListener('input', updateSliderValue);

    // Opcional: actualizar el valor del span al cargar la página
    window.addEventListener('DOMContentLoaded', updateSliderValue);
}


$(document).ready(async function () {
    if (document.getElementById('lead-channel')) {
        setData(true, false, true);
        
    }
});



$(document).on("select2:open", () => {
    document.querySelector(".select2-container--open .select2-search__field").focus()
})

/* graficas */
function crearGraficaApilada(contenedor, valorInteres, valorDeuda, colorInteres = '#e57373', colorDeuda = '#757575', etiquetaInteres = "Interés", etiquetaDeuda = "Deuda") {
    const chartContainer = document.createElement('div');
    chartContainer.classList.add('chart-container');
  
    // Cálculo del total y altura dinámica para cada gráfica
    const total = valorInteres + valorDeuda;
    const alturaMaxima = 400; // Altura máxima en píxeles para la gráfica con mayor valor
    const alturaGrafica = (total / 16000) * alturaMaxima; // Escalado en base a un total de 16000 como máximo
  
    // Crear la barra de la gráfica
    const bar = document.createElement('div');
    bar.classList.add('bar');
    bar.style.height = `${alturaGrafica}px`;
  
    // Crear segmento de deuda
    const segmentoDeuda = document.createElement('div');
    segmentoDeuda.classList.add('segment', 'segment2');
    segmentoDeuda.style.backgroundColor = colorDeuda;
    segmentoDeuda.style.height = `${(valorDeuda / total) * 100}%`;
    segmentoDeuda.innerHTML = `
    <span style="font-size: 1.2em; ">$${valorDeuda.toLocaleString()}</span>
    <span style="font-size: 1.2em;">${etiquetaDeuda}</span>
  `;
  
    // Crear segmento de interés
    const segmentoInteres = document.createElement('div');
    segmentoInteres.classList.add('segment', 'segment1');
    segmentoInteres.style.backgroundColor = colorInteres;
    segmentoInteres.style.height = `${(valorInteres / total) * 100}%`;
    segmentoInteres.innerHTML = `
     <span style="font-size: 1.2em;">${etiquetaInteres}</span>
    <span style="font-size: 1.2em;">$${valorInteres.toLocaleString()}</span>
   
  `;
  
    // Añadir los segmentos a la barra (interés arriba)
    bar.appendChild(segmentoInteres);
    bar.appendChild(segmentoDeuda);
  
    // Añadir la barra al contenedor de la gráfica
    chartContainer.appendChild(bar);
    contenedor.appendChild(chartContainer);
  
    // Animación de llenado
    setTimeout(() => {
      segmentoInteres.style.opacity = 1;
      segmentoInteres.style.transform = 'scaleY(1)';
      segmentoDeuda.style.opacity = 1;
      segmentoDeuda.style.transform = 'scaleY(1)';
    }, 100); // Retraso para activar la animación
  }
  
  // Selecciona el contenedor principal donde se añadirán las gráficas
  const chartsContainer = document.getElementById('charts-container');

  /* seccion para controldesk compra de cartera */
  document.addEventListener('DOMContentLoaded', function() {
    // Obtener elementos del DOM
    const sumaCompraCheck = document.getElementById('sumaCompraCheck');
    const refPlazo = document.getElementById('ref-plazo');
    const contentMontoSolicitado = document.getElementById('content-select-monto-solicitado');
    const contentNewMontoSolicitado = document.getElementById('content-select-new-monto-solicitado');
    
    // Inicializar select2 si no está inicializado
    if ($.fn.select2) {
        $('.js-select2').select2();
    }
    
    // Escuchar cambios en el checkbox
    if (document.getElementById('compra-cartera-plazo-solicitado')) {
        
        sumaCompraCheck.addEventListener('change', function() {
            if (this.checked) {
                // Ocultar el contenedor original sin modificarlo
                contentMontoSolicitado.style.display = 'none';
                
                // Obtener el valor del plazo solicitado desde el campo oculto
                const plazoSolicitadoInput = document.getElementById('compra-cartera-plazo-solicitado');
                if (plazoSolicitadoInput && plazoSolicitadoInput.value) {
                    const plazoSolicitado = plazoSolicitadoInput.value;
                    
                    // Buscar si existe esa opción en el select de plazo y seleccionarla
                    Array.from(refPlazo.options).forEach(option => {
                        if (option.value == plazoSolicitado) {
                            refPlazo.value = option.value;
                            $(refPlazo).trigger('change'); // Trigger change para select2
                        }
                    });
                }
                
                // 1. Llamar a axios para obtener los datos de compra de cartera
                let creditId = $('#controldesk-credit_id').val();
                let plazo = $('#ref-plazo').val();
                let tramit_type = $('#tramit_type').val();
                
                axios.get('/panel/kc-control-desk/'+creditId+ '/'+tramit_type+'/'+plazo+'/compracartera/calculate')
                    .then(function(response) {
                        const data = response.data;
                        const compraCartera = data.compraCartera;
                        const montoSolicitado = data.montoSolicitado;
                        const montoRefinanciable = data.montoRefinanciable;
                        /* 
                        const newMontoSolicitado = Math.min(compraCartera, montoSolicitado); */
                        const newMontoSolicitado = compraCartera;
                        // Guardar el valor en un campo oculto para usarlo más tarde
                        document.getElementById('total-refinanciable').value = montoRefinanciable;
                        
                        // 2. Seleccionar el plazo correspondiente si existe
                        // Obtener el valor de monto solicitado correctamente usando DOM nativo
                        let montoSolicitadoText = '';
                        const tablas = document.querySelectorAll('table.table-striped');
                        
                        // Buscar en todas las tablas la fila que contiene "Monto solicitado"
                        tablas.forEach(tabla => {
                            const filas = tabla.querySelectorAll('tr');
                            filas.forEach(fila => {
                                const celdas = fila.querySelectorAll('td');
                                if (celdas.length >= 2 && celdas[0].textContent.trim() === 'Monto solicitado') {
                                    montoSolicitadoText = celdas[1].textContent.trim();
                                }
                            });
                        });
                        
                        // 3. Crear elementos en el nuevo contenedor
                        
                        agregarElementosNuevoContenedor(montoSolicitado);
                    })
                    .catch(function(error) {
                        console.error('Error al obtener datos de compra de cartera:', error);
                    });
            } else {
                // Mostrar el contenedor original sin modificarlo
                contentMontoSolicitado.style.display = '';
                
                // Limpiar el contenedor nuevo
                contentNewMontoSolicitado.innerHTML = '';
                
                // Vaciar el campo oculto de total refinanciable
                document.getElementById('total-refinanciable').value = '';
                getMontoSolicitado();
                
            }
        });
    }
    
    // Función para agregar elementos al nuevo contenedor
    function agregarElementosNuevoContenedor(monto) {
        // Limpiar el contenedor nuevo
        contentNewMontoSolicitado.innerHTML = '';
        
        // Crear un input disabled visible
        const disabledInput = document.createElement('input');
        disabledInput.type = 'text';
        disabledInput.className = 'form-control';
        disabledInput.value = formatPrice(monto);
        disabledInput.disabled = true;
        
        // Crear un input hidden con el valor real
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'credit[applied_import]';
        hiddenInput.id = 'ref-monto-new';  // ID diferente para evitar conflicto
        hiddenInput.value = monto;
        
        // Agregar los elementos al contenedor nuevo
        contentNewMontoSolicitado.appendChild(disabledInput);
        contentNewMontoSolicitado.appendChild(hiddenInput);
        
        // Disparar evento para cualquier otra función que dependa del cambio
        const event = new Event('change');
        hiddenInput.dispatchEvent(event);

        
        
        // Si getResumen es una función global, llamarla directamente
        if (typeof getResumen === 'function') {
            getResumen();
        }
    }
    
    // Función auxiliar para formatear precio similar a Laravel
    function formatPrice(amount) {
        return '$ ' + parseFloat(amount).toLocaleString('es-CO', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }
});

function getLeadValidations() {
    let leadId = $('#lead_id').val();
    $('#content-validaciones-tabla').html('');
    axios.get(`/panel/lead/validations/${leadId}`)
        .then(function (response) {
            if (response.data.success) {
                let html = response.data.table;
                
                $('#content-validaciones-tabla').html(html);
            } else {
                $('#content-validaciones-tabla').html('No se encontraron validaciones');
            }
        })
        .catch(function (error) {
            console.error('Error:', error);
            $('#content-validaciones-tabla').html('Error al obtener las validaciones');
        });
}

function getLeadValidationsLoanTerm() {
    let leadId = $('#lead_id').val();
    axios.get(`/panel/lead/validations/${leadId}/loan/term`)
        .then(function (response) {
            getLeadValidations();
        })
        .catch(function (error) {
            console.error('Error:', error);
        });
}