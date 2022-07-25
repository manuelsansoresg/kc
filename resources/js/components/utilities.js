export function showInfo(redirect, idDatatable) {
    showToast('Datos Actualziados', 'Información actualizada correctamente.', 'success');
    if (redirect == 1) { //*redirect back
        window.history.back();
    }
    if (idDatatable == null) {
        location.reload();
    } else {
        $('#'+idDatatable).DataTable().ajax.reload();
    }

}