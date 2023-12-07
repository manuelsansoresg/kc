export function showInfo(redirect, idDatatable, title, msg) {
    showToast(title, msg, 'success');
    if (redirect == 1) { //*redirect back
        window.history.back();
    }
    if (idDatatable == null) {
        location.reload();
    } else {
        $('#'+idDatatable).DataTable().ajax.reload();
    }

}

window.showNotes = function(id_rel, is_lead)
{
    let model = is_lead == true ? 'lead' : 'credit';
    axios
    .get('/panel/'+model+'/'+id_rel+'/notes/list')
    .then(function (response) {
        let result = response.data;
        $('#content-notes').html(result);
        $('#modal-list-note').modal('show');
    })
    .catch(e => {
        
    });
}

window.showModalActions = function(lead_id, is_lead)
{
    let model = is_lead == true ? 'lead' : 'credit';
    refreshAction(lead_id, model, 'in_progress', 'content-profile-in_progress')
    refreshAction(lead_id, model, 'completed', 'content-profile-completed')

    $('#modal-list-actions').modal('show');
}

/* window.searchClient = function (event)
{
    if (event.key === 'Enter') {
        //event.preventDefault();
        let query = $('#query').val();
        axios
            .post('/panel/user/search', {query:query})
            .then(function (response) {
                let result = response.data;
                console.log(result);
            })
            .catch(e => {
                
            });
    }
} */