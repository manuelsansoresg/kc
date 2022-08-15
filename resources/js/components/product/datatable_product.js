document.addEventListener('DOMContentLoaded', function () {
    let route = $('#route_datatable').val();
    let table = NioApp.DataTable('#dt-product', {
        processing: true,
        ajax: '/panel/product/list/show',
        columns: [
            { data: 'alias' },
            { data: 'name' },
            { data: 'service' },
            { data: 'comment' },
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