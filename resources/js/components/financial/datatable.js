document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-financial', {
        processing: true,
        ajax: '/panel/financial/list/show',
        columns: [
            { data: 'commercial_name' },
            { data: 'company_name' },
            { data: 'options'},
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