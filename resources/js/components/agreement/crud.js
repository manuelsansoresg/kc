import { showInfo } from '../utilities';

window.deleteAgreement = function (agreement) {
    axios
        .get("panel/agreement/"+agreement+"/delete")
        .then(function (response) {
            showInfo(2, 'dt-agreement');
        })
        .catch(e => {
            
        });
}

$().ready(function () {
    $("#frm-agreement").validate({
        rules: {
            'data[name]': {
                required: true,
            },
           
            'data[status]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const new_form = document.getElementById("frm-agreement");
            const data = new FormData(new_form);

            axios
                .post("/panel/agreement", data)
                .then(function (response) {
                    let result = response.data;
                    showInfo(2, 'dt-agreement');
                    window.location = '/panel/agreement';
                })
                .catch(e => {
                });

        }
    });

});
