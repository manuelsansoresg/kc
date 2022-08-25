document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-financial', {
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