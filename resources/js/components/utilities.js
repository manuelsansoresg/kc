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