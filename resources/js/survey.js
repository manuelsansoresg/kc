window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.saveSurvey = function () {
    
    const new_form = document.getElementById("frm-survey");
    const data = new FormData(new_form);
    axios
        .post("survey", data)
        .then(function (response) {
            window.location = '/panel/kc-aftermarket'; // TODO: volver dinamico de donde provenga
        })
        .catch(e => {
            let response = e.response;
        });
}