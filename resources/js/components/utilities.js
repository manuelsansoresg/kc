export function showInfo(redirect, idDatatable) {

    Swal.fire({
        icon: 'success',
        title: 'Información',
        text: 'Los datos han sido guardados',
        showDenyButton: false,
        confirmButtonText: 'Continuar',
        
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) { 
            if (redirect == 1) { //*redirect back
                window.history.back();
            }
            if (idDatatable == null) {
                location.reload();
            } else {
                $('#'+idDatatable).DataTable().ajax.reload();
            }
        }
    })

}