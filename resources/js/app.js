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
require('./components/toastr');
require('./components/crm');
require('./components/action/datatable');
require('./components/action/crud');
require('./components/module/datatable');

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
