document.addEventListener('DOMContentLoaded', function () {
    let route = $('#route_datatable').val();
    let table = NioApp.DataTable('#dt-agreement', {
        processing: true,
        ajax: '/panel/agreement/list/show',
        columns: [
            { data: 'name' },
            { data: 'description' },
            { data: 'status' },
            { data: 'options',}
        ],
        columnDefs:[
            { className: "nk-tb-col", targets: "_all" },
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass("nk-tb-item");
            
        },
      
    },
    );
} );