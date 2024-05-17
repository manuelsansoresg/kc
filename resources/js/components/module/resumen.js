
if (document.getElementById('checkIslimit')) {
    const checkbox = document.getElementById('checkIslimit');
    const numberInput = document.getElementById('lendable');
    
    // Set initial state based on checkbox checked status
    numberInput.disabled = checkbox.checked;
    
    checkbox.addEventListener('change', function() {
      numberInput.disabled = this.checked;
    });

    $( "#frm-inversionista-prestamo" ).submit(function( event ) {
        event.preventDefault();
        let InvestorId = $('#investorId').val();
        const new_form = document.getElementById("frm-inversionista-prestamo");
        const data = new FormData(new_form);
    
        axios
            .post("/panel/inversionista", data)
            .then(function (response) {
                window.location = '/panel/inversionista/'+InvestorId;
            })
            .catch(e => {
                
            });
      });

}
