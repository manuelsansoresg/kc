$().ready(function () {
    $("#frm-client").validate({
        rules: {
            'data[name]': {
                required: true,
            },
            

        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const new_form = document.getElementById("frm-client");
            const data = new FormData(new_form);

            axios
                .post("/panel/clients", data)
                .then(function (response) {
                    window.location = '/panel/clients';
                })
                .catch(e => {
                });

        }
    });
    
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

});