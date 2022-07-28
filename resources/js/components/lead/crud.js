import { showInfo } from '../utilities';


NioApp.Select2.init();

  $("#lead-agreement" ).change(function() {
    let lead_agreement = $("#lead-agreement" ).val();
    $('#lead-content-agreement').hide();
    if (lead_agreement == 0) {
        $('#lead-content-agreement').show('slow');
    }
  });
  
  $("#lead-origin" ).change(function() {
    let origin_id = $("#lead-origin" ).val();
    $('#lead-channel').empty();
    axios
        .get("/panel/lead/"+origin_id+"/origin/")
        .then(function (response) {
            let result = response.data;
            if (result != null) {
                var lead_channel = $('#lead-channel');
                for (const key in result) {
                    const element = result[key];
                    if (element != 'Selecciona una opción') {
                        var option = new Option(element, key, true, true);
                        lead_channel.append(option).trigger('change');
                    }
                    
                }
            }

        })
        .catch(e => {
            $('#admin_email-error-exist').show();
        });
  });

function setData() {
    let lead_id = $('#lead_id').val();
    $('#lead-channel').empty();

    axios
        .get("/panel/lead/" + lead_id)
        .then(function (response) {
            let result = response.data;
            let lead = result.lead;
            let channel = result.channel;

            $('#lead-agreement option[value="' + lead.agreement_id + '"]').attr("selected", "selected");
            $('#lead-product-id option[value="' + lead.product_id + '"]').attr("selected", "selected");
            $('#lead-origin option[value="' + lead.origin_id + '"]').attr("selected", "selected");
            $('#lead-asesor-id option[value="' + lead.asesor_id + '"]').attr("selected", "selected");
            $('#lead-temperature-id option[value="' + lead.temperature_id + '"]').attr("selected", "selected");
            
            $('#lead-name').val(lead.name); 
            $('#lead-last_name').val(lead.last_name); 
            $('#lead-second_last_name').val(lead.second_last_name); 
            $('#lead-cellphone').val(lead.cellphone); 
            $('#lead-email').val(lead.email); 

            if (channel != null) {
                var lead_channel = $('#lead-channel');
                for (const key in channel) {
                    const element = channel[key];
                    if (element != 'Selecciona una opción') {
                        var option = new Option(element, key, true, true);
                        lead_channel.append(option).trigger('change');
                    }
                    
                }
            }


        })
        .catch(e => {
            $('#admin_email-error-exist').show();
        });
}

window.deleteProduct = function (product_id) {
    axios
        .get("panel/product/"+product_id+"/delete")
        .then(function (response) {
            showInfo(2, 'dt-lead');
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

function resolveTextSetting() {
    return new Promise(resolve => {
      setTimeout(() => {
        setData();
      }, 3000);
    });
  }
  $(document).ready(function(){

    resolveTextSetting();
    
  })

