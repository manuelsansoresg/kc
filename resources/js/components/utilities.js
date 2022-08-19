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

export function addEmptySelectSearch(id) {
    var data = {
        id: '',
        text: ''
    };
    
    var newOption = new Option(data.text, data.id, false, false);
    $('#'+id).append(newOption).trigger('change');
   
    $('#'+id).val('');
    $('#'+id).trigger("change");
    
}