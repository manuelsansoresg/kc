window.prestarInversionista = function()
{
    let importe = parseFloat($('#lendable').val()) || 0; 
    let totalAvailable = parseFloat($('#totalAvailable').val()) || 0;
    let investorId = $('#investorId').val();
    let error = true;

    if (importe < 0) {
        Swal.fire({
            title: 'El importe debe ser mayor o igual a 0 pesos.',
            icon: 'warning',
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: 'Cerrar'
        });
    } else if (importe > totalAvailable) {
        Swal.fire({
            title: 'El importe debe ser menor o igual al Disponible.',
            icon: 'warning',
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: 'Cerrar'
        });
    } else {
        error = false;
    }

    if (!error) {
        axios.post("/panel/clients/investor/prestar/save", { 'lendable': importe, 'investorId':investorId })
            .then(function (response) {
                $('#modalPrestar').modal('hide');
                location.reload();
            })
            .catch(e => {
                console.error('Error en la solicitud:', e);
            });
    }


}