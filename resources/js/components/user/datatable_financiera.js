document.addEventListener('DOMContentLoaded', function () {
    let route = $('#route_datatable').val();
    let table = NioApp.DataTable('#dt-financiera', {
        processing: true,
        ajax: '/panel/user/'+route+'/list/show',
        columns: [
            { data: 'financial' },
            { data: 'type_person' },
            { data: 'name' },
            { data: 'email' },
            { data: 'cellphone' },
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