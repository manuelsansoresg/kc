window.modalUserAdmin = function (type) {
    if (type === 1) {
        $('#user-admin-title').html('Crear usuario');
    } else {
        $('#user-admin-title').html('Editar usuario');
    }
    $('#modal-user-admin').modal('show');
}


$("#frm-modal-user-admin").validate();