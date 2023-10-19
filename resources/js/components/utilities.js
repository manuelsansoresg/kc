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

window.showNotesLead = function(lead_id)
{
    axios
    .get('/panel/lead/'+lead_id+'/notes/list')
    .then(function (response) {
        let result = response.data;
        $('#content-lead-notes').html(result);
        $('#modal-lead-list-note').modal('show');
    })
    .catch(e => {
        
    });
}