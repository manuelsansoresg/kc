

window.modalCreditTag = function (credit_id) {
    $('#modal-credit-tag-tag').val(null).trigger('change');
    $('#lead-financial_id').val('').trigger('change');

    $('#modal-credit-credit_id').val(credit_id);
    $('#modal-credit-tag').modal('show');
}


$("#frm-credit-tag").submit(function (event) {
    event.preventDefault();
    let lead_id = $('#modal-tag-lead_id').val();
    const new_form = document.getElementById("frm-credit-tag");
    const data = new FormData(new_form);

    axios
        .post("/panel/credit/tag/store", data)
        .then(function (response) {
            $('#modal-credit-tag').modal('hide');
            creditRefresh(creditRefresh)
        })
        .catch(e => {

        });
});

if (document.getElementById('frm-credit-tag')) {
    getTags();
    getNotes();
}

function getTags() {
    $('#content-tag').html('');
    let credit_id = $('#credit-profile-credit_id').val();
    axios
        .get("/panel/credit/tag/" + credit_id + "/get-all")
        .then(function (response) {
            let result = response.data;
            $('#content-tag').html(result.tags);

        })
        .catch(e => {

        });
}

function getNotes() {
    $('#content-note').html('');
    let credit_id = $('#credit-profile-credit_id').val();
    axios
        .get("/panel/credit/note/" + credit_id + "/get-all")
        .then(function (response) {
            let result = response.data;
            $('#content-note').html(result.tags);

        })
        .catch(e => {

        });
}

window.creditRefresh = function () {
    $('#modal-note').modal('hide');
    getTags();
    getNotes();
}

window.deleteTag = function (tag_id) {
    axios
        .get("/panel/credit/tag/" + tag_id + "/drop")
        .then(function (response) {
            let result = response.data;
            getTags();
        })
        .catch(e => {

        });
}

$(document).ready(function () {
if (document.getElementById('action-model')) {

    let model   = $('#action-model').val();
    let id_rel  = $('#action-id_rel').val();
    let step    = $('#step').val();

    if (model == '') {
        model = null;
    }
    //*get configuration in template
    axios
        .get("/panel/files/images/" + model + '/' + id_rel + '/get/config?step='+step)
        .then(function (response) {
            let result = response.data;
            let config_files = result.config_files;

            for (const key in config_files) {
                if (config_files.hasOwnProperty.call(config_files, key)) {
                    const element = config_files[key];
                    //create dinamic dropzone element
                    NioApp.Dropzone('#' + key + '-dropzone-action', {
                        url: "/panel/files/images/" + model + '/' + id_rel + '/' + key,
                        init: function () {
                            this.on("sending", function (file, xhr, formData) {
                                let date_file = null;
                                if (document.getElementById(key + '-date_file')) {
                                    date_file = $('#' + key + '-date_file').val();
                                }
                                formData.append("date_file", date_file);
                            });

                            this.on("success", function (file, message) {
                                getData();
                            });
                            this.on("complete", function (file) {
                                this.removeAllFiles(true);
                            })
                        }
                    }
                    );

                }
            }
            //
        })
        .catch(e => {

        });

    

    window.deleteFileTemplate = function (model, id) {
        $('#frm-register-action-preview').html('');
        axios
            .get("/panel/temp/images/" + id + "/delete")
            .then(function (response) {
                getData();
                showToast('Archivos', 'Archivo borrado', 'success');

            })
            .catch(e => {
            });
    }

    //* get data saved 
    function getData() {
        clearPreviewFiles();
        let step    = $('#step').val();
        axios
            .get("/panel/files/template/" + model + "/" + id_rel + "/show?step="+step)
            .then(function (response) {
                let result = response.data;
                let files = result.files;
                let file_dates = result.file_date;
                for (const key in file_dates) {
                    if (file_dates.hasOwnProperty.call(file_dates, key)) {
                        const element_date_file = file_dates[key];
                        $('#' + element_date_file.template_config_id + '-date_file').val(element_date_file.date_file);

                    }
                }

                for (const key_file in files) {
                    if (files.hasOwnProperty.call(files, key_file)) {
                        const element_file = files[key_file];
                        $('#' + element_file.template_config_id + '-files-action-preview').append(element_file.preview);
                    }
                }

            })
            .catch(e => {

            });
    }

    function clearPreviewFiles() {
        let step    = $('#step').val();
        axios
            .get("/panel/files/images/" + model + '/' + id_rel + '/get/config?step='+step)
            .then(function (response) {
                let result = response.data;
                let config_files = result.config_files;

                for (const key in config_files) {
                    if (config_files.hasOwnProperty.call(config_files, key)) {
                        const element = config_files[key];
                        //create dinamic dropzone element
                        $('#' + key + '-files-action-preview').html('');

                    }
                }
            })
            .catch(e => {

            });
    }

    $().ready(function () {
        getData();
        $("#frm-action-files").validate({
            rules: {
                'date_file[]': {
                    required: true,
                },
            },
            submitHandler: function (form, event) {
                event.preventDefault();
  
                const new_form = document.getElementById("frm-action-files");
                const data = new FormData(new_form);
  
                // Extract the step value from the URL
                const urlParams = new URLSearchParams(window.location.search);
                const step = urlParams.get('step');
  
                // Add the step value to the FormData
                data.append('step', step);
  
                axios
                    .post("/panel/files/template/date", data)
                    .then(function (response) {
                        let result = response.data;
                        let url_redirect = null;
  
                        url_redirect = $('#url_redirect').val();
                        window.location = url_redirect;
                    })
                    .catch(e => {
                    });
            }
        });
    });
  
}

});
