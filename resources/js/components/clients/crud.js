$().ready(function () {
    $("#frm-client").validate({
        rules: {
            'data[last_name]': {
                required: true,
            },
            'data[second_last_name]': {
                required: true,
            },
            'data[name]': {
                required: true,
            },
            
            'data[rfc]': {
                required: true,
                minlength: 13,
                maxlength: 13
            },
            'data[bank_name]': {
                required: true,
            },
            'data[bank_clabe]': {
                required: true,
                number: true,
                minlength: 9,
                maxlength: 9
            },
            

        },
        submitHandler: function (form, event) {
            event.preventDefault();
            let origin = $('#origin').val();
            const new_form = document.getElementById("frm-client");
            const data = new FormData(new_form);

            axios
                .post("/panel/clients", data)
                .then(function (response) {
                    if (origin == 'colaboradores') {
                        window.location = '/panel/clients/colaboradores/show';
                    } else {
                        window.location = '/panel/clients';
                    }
                })
                .catch(e => {
                });

        }
    });
    //funcion  estatus
    
    function setData() {
        let client_id = $('#client_id').val();
        if (client_id != '') {
            console.log(client_id);
            axios
                .get("/panel/clients/" + client_id)
                .then(function (response) {
                    let result        = response.data;
                    let client          = result.client;
                
    
                    $('#client-name').val(client.name);
                    $('#client-last_name').val(client.last_name);
                    $('#client-second_last_name').val(client.second_last_name);
                    $('#client-cellphone').val(client.cellphone);
                    $('#client-email').val(client.email);
                    $('#client-rfc').val(client.rfc);
                    $('#lead-email').val(client.email);
                    $('#client-daily_income').val(client.daily_income);
                    
                    $('#client-agreement').val(client.agreement_id).trigger("change");
                    const clientStatusElement = document.getElementById("client-status");

                    if (client.active == 1 && clientStatusElement) {
                        clientStatusElement.click();
                    }
                    $('#client-status').val(client.active);
                
    
    
                })
                .catch(e => {
                    $('#admin_email-error-exist').show();
                });
        }
    }

    if (document.getElementById('client_id')) {
        setData();
    }

    //funcion  estatus
    function updateStatusLabel() {
        const statusCheckbox = document.getElementById('client-status');
        const statusLabel = document.querySelector('label[for="client-status"]');
        
        if (statusCheckbox.checked) {
            statusLabel.textContent = 'Activo';
        } else {
            statusLabel.textContent = 'Inactivo';
        }
    }

    // Add event listener to the status checkbox
    const statusCheckbox = document.getElementById('client-status');
    if (statusCheckbox) {
        statusCheckbox.addEventListener('change', updateStatusLabel);
        // Initial call to set the correct label
        updateStatusLabel();
    }
});