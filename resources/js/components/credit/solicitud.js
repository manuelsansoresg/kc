window.modalSolicitud = function(history_id, credit_id)
{
    axios
    .get("/panel/solicitud/" + history_id+ '/modal/show')
    .then(function (response) {
        // Actualizar el href del enlace con el credit_id
        $('#link-detalle-solicitud').attr('href', '/panel/credit/' + credit_id);
        $('#content-modal-solicitud').html(response.data);

        $('#modalSolicitud').modal('show');


    })
    .catch(e => {
        
    });
}

window.denegarSolicitud = function()
{
    let client_name = $('#solicitud_client_name').val();
    let history_id = $('#solicitud_history_id').val();

    Swal.fire({
            title: 'Denegar Vo.Bo a:' ,
            text: client_name,
            icon: 'error',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .get("/panel/solicitud/" + history_id+ '/status/deny')
                    .then(function (response) {
                        window.location.reload();
                        
                    })
                .catch(e => {
                    
                });
            }
    })

    

}

window.otorgarSolicitud = function()
{
let client_name = $('#solicitud_client_name').val();
    let history_id = $('#solicitud_history_id').val();

    Swal.fire({
            title: 'Otorgar Vo.Bo a:' ,
            text: client_name,
            icon: 'success',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .get("/panel/solicitud/" + history_id+ '/status/approve')
                    .then(function (response) {
                        window.location.reload();
                        
                    })
                .catch(e => {
                    
                });
            }
    })
}
