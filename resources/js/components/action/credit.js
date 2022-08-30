

window.modalCreditTag = function(credit_id) {
    $('#modal-credit-tag-tag').val(null).trigger('change');
    $('#lead-financial_id').val('').trigger('change');

    $('#modal-credit-credit_id').val(credit_id);
    $('#modal-credit-tag').modal('show');
}


$( "#frm-credit-tag" ).submit(function( event ) {
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
        .get("/panel/credit/tag/"+credit_id+"/get-all")
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
        .get("/panel/credit/note/"+credit_id+"/get-all")
        .then(function (response) {
            let result = response.data;
            $('#content-note').html(result.tags);

        })
        .catch(e => {

        });
}

window.creditRefresh = function() {
    $('#modal-lead-note').modal('hide');
    getTags();
    getNotes();
}

window.deleteTag = function(tag_id) {   
    axios
        .get("/panel/credit/tag/"+tag_id+"/drop")
        .then(function (response) {
            let result = response.data;
            getTags();
        })
        .catch(e => {

        });
}