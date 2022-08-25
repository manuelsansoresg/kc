document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-check-up', {
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
        ajax: '/panel/kc-check-up/list/show',
        columns: [
            { data: 'id' },
            { data: 'product' },
            { data: 'client' },
            { data: 'advisor' },
            { data: 'progress'},
            { data: 'deadline'},
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