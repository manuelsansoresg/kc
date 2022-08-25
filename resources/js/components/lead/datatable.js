document.addEventListener('DOMContentLoaded', function () {
    let route = $('#route_datatable').val();
    let table = NioApp.DataTable('#dt-lead', {
        processing: true,
        responsive: {
            details: {
                renderer: function ( api, rowIdx, columns ) {
                    var data = $.map( columns, function ( col, i ) {
                        return col.hidden ?
                            '<tr class="py-3" data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                '<td class="px-3">'+col.title+'</td> '+
                                '<td>'+col.data+'</td>'+
                            '</tr>' :
                            '';
                    } ).join('');
 
                    return data ?
                        $('<table/>').append( data ) :
                        false;
                }
            }
        
        },
        ajax: '/panel/lead/list/show',
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'date' },
            { data: 'product' },
            { data: 'origin' },
            { data: 'label' },
            { data: 'advisor' },
            { data: 'status' },
            { data: 'options', className: 'nk-tb-col-tools text-end' }
        ],
        columnDefs: [
            { className: "nk-tb-col", targets: "_all" },
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass("nk-tb-item odd");

        },
     
    },);

    
    let table_archive = NioApp.DataTable('#dt-lead-archive', {
        processing: true,
        ajax: '/panel/archive/lead/list/show',
        columns: [
            { data: 'name' },
            { data: 'date' },
            { data: 'product' },
            { data: 'origin' },
            { data: 'label' },
            { data: 'advisor' },
            { data: 'status' },
            { data: 'options', }
        ],
        columnDefs: [
            { className: "nk-tb-col", targets: "_all" },
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass("nk-tb-item odd");

        },
        
    },);

});