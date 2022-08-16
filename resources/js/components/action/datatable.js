document.addEventListener('DOMContentLoaded', function () {
    let status = $('#dt-action-status').val();
    let table = NioApp.DataTable('#dt-acctions', {
        processing: true,
        responsive: {
            details: true
        },
        ajax: '/panel/action/'+status+'/dt/show',
        columns: [
            { data: 'type' },
            { data: 'subject' },
            { data: 'section' },
            { data: 'name' },
            { data: 'date_in' },
            { data: 'date_fin' },
            { data: 'advisor' },
            { data: 'options', className: 'nk-tb-col-tools text-end' }
        ],
        columnDefs: [
            { className: "nk-tb-col", targets: "_all" },
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass("nk-tb-item odd");

        },
     
    },);

});