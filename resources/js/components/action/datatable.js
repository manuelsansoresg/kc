document.addEventListener('DOMContentLoaded', function () {
    let status = $('#dt-action-status').val();
    let table = NioApp.DataTable('#dt-acctions', {
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