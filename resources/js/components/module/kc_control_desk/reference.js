$().ready(function () {
    $("#frm-credit-reference").validate({
        rules: {
            'data_reference[last_name]': {
                required: true,
            },

            'data_reference[second_lastname]': {
                required: true,
            },
            'data_reference[names]': {
                required: true,
            },
            'data_reference[relationship_time_years]': {
                number: true,
            },
            'data_reference[relationship_time_months]': {
                number: true,
            },
            'data_reference[cel_phone]': {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            'data_reference[local_phone]': {
                number: true,
                minlength: 10,
                maxlength: 10
            },
            'data_reference[postal_code]': {
                number: true,
                minlength: 5,
                maxlength: 5
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const new_form = document.getElementById("frm-credit-reference");
            const data = new FormData(new_form);
            let history_id = $('#history_id').val();
            let reference_id = $('#reference_id').val();

            axios
                .post("/panel/reference/" + history_id + "/storeReference", data)
                .then(function (response) {
                    window.history.back();

                })
                .catch(e => {
                });

        }
    });

    window.deleteReference = function (reference_id) {

        Swal.fire({
            title: '¿Estás seguro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, elimina',
            cancelButtonText: 'Mejor no'
        }).then(function (result) {
            if (result.value) {
                axios
                    .delete("/panel/reference/"+reference_id+"/delete/")
                    .then(function (response) {
                        location.reload();
                    })
                    .catch(e => {
                    });
            }
        });
    }

});