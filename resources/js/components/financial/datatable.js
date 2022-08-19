document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-tag', {
        processing: true,
        ajax: '/panel/tag/list/show',
        columns: [
            { data: 'name' },
            { data: 'type' },
            { data: 'section' },
            { data: 'description' },
            { data: 'status'},
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