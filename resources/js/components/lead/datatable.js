document.addEventListener('DOMContentLoaded', function () {
    let route = $('#route_datatable').val();
    let  module_id = null;

    if (document.getElementById('module_id')) {
        module_id = $('#module_id').val();
    }


    let table = NioApp.DataTable('#dt-lead', {
        processing: true,
        responsive: {
            details: {
                renderer: function ( api, rowIdx, columns ) {
                    let total = columns.length -1;
                    var data = $.map( columns, function ( col, i ) {
                       if (total == i) {
                            return col.hidden ?
                            '<tr class="py-3 " colspan="2">'+
                            '<td class="">'+col.data+'</td>'+
                            '</tr>' :
                            '';
                       } else {
                            return col.hidden ?
                            '<tr class="py-3" data-dt-row="'+col.rowIndex+'">'+
                                '<td class="px-3 "><strong>'+col.title+'</strong></td> '+
                                '<td class="w-100">'+col.data+'</td>'+
                            '</tr>' :
                            '';
                       }
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
            { data: 'reason' },
            { data: 'advisor' },
            { data: 'options', }
        ],
        columnDefs: [
            { className: "nk-tb-col", targets: "_all" },
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass("nk-tb-item odd");

        },
        
    },);
    
    let table__dinamic_archive = NioApp.DataTable('#dt-lead-dinamic-archive', {
        processing: true,
        ajax: '/panel/archive/lead/list/'+module_id+'/show',
        columns: [
            { data: 'name' },
            { data: 'date' },
            { data: 'product' },
            { data: 'origin' },
            { data: 'reason' },
            { data: 'advisor' },
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