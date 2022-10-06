window.showNotification = function() {
    $('#content-notification').html('');

    axios
    .get("/panel/notification/show")
    .then(function (response) {
        let result = response.data;
        $('#content-notification').html(result.list);
    })
    .catch(e => {
    });
}

$().ready(function () {
    showNotification();
});

require('./components/datatable');
require('./components/user/crud');
require('./components/user/datatable_admin');
require('./components/user/datatable_financiera');
require('./components/product/datatable_product');
require('./components/product/crud');
require('./components/agreement/datatable');
require('./components/agreement/crud');
require('./components/lead/datatable');
require('./components/lead/crud');
require('./components/tag/datatable');
require('./components/tag/crud');
require('./components/financial/datatable');
require('./components/financial/crud');
require('./components/financial/product/datatable');
require('./components/financial/product/crud');
require('./components/toastr');
require('./components/crm');
require('./components/action/datatable');
require('./components/action/crud');
require('./components/action/credit');
require('./components/general');
require('./components/module/datatable');
require('./components/module/template');
require('./components/module/kc_check_up/datatable');
require('./components/module/kc_check_up/action/datatable');
require('./components/module/kc_check_up/action/datatable_report');
require('./components/action/datatablemodule');
require('./components/credit/profile/datatable');
require('./components/credit/product/datatable');
require('./components/credit/datatable_in_progress');


window.moveElement = function (section, id, idDatatable) {
    axios
    .get("/panel/"+section+"/"+id+"/move")
    .then(function (response) {
        if (idDatatable == null) {
            location.reload();
        } else {
            $('#'+idDatatable).DataTable().ajax.reload();
        }
    })
    .catch(e => {
    });
}





require('./components/websocket');
