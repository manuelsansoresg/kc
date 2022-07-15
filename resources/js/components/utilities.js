export function showInfo(redirect) {

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
            location.reload();
        }
    })

}