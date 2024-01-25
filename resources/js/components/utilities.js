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
        $('#content-notes').html(result.notes);
        $('#addNote').html(result.addNote);
        $('#modal-list-note').modal('show');
    })
    .catch(e => {
        
    });
}


window.AddNoteIntoNotes = function(note_id, model_note)
{
    $('#modal-list-note').modal('hide');
    $('#id_rel').val(note_id);
    $('#model_note').val(model_note);
    $('#modal-lead-description').val('');
    $('#modal-note').modal('show');
}
window.showModalActions = function(lead_id, is_lead)
{
    let model = is_lead == true ? 'lead' : 'credit';
    refreshAction(lead_id, model, 'in_progress', 'content-profile-in_progress')
    refreshAction(lead_id, model, 'completed', 'content-profile-completed')

    $('#modal-list-actions').modal('show');
    let addAction = '<a class="pointer" onclick="addActionIntoActions(' + lead_id + ', true, true)"><em class="icon ni ni-calendar-check-fill"></em><span>Agregar acción</span></a>';
    $('#addActions').html(addAction)
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