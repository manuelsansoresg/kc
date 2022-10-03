document.addEventListener('DOMContentLoaded', function () {
    let name_status = $('#name_status').val();
    let table = NioApp.DataTable('#dt-acctions-module', {
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
        ajax: '/panel/action/module/'+name_status+'/list',
        columns: [
            { data: 'action' },
            { data: 'module' },
            { data: 'name' },
            { data: 'deadline' },
            { data: 'advisor' },
            { data: 'responsable' },
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