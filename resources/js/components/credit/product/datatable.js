document.addEventListener('DOMContentLoaded', function () {
    let status = $('#status').val();
    let table = NioApp.DataTable('#dt-product-credit', {
        processing: true,
        responsive: {
            details: {
                renderer: function ( api, rowIdx, columns ) {
                    let total = columns.length -1;
                    var data = $.map( columns, function ( col, i ) {
                       if (total == i) {
                            return col.hidden ?
                            '<tr class="py-3">'+
                            '<td colspan="2" class="w-100">'+col.data+'</td>'+
                            '</tr>' :
                            '';
                       } else {
                            return col.hidden ?
                            '<tr class="py-3" data-dt-row="'+col.rowIndex+'">'+
                                '<td class="px-3">'+col.title+'</td> '+
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
        ajax: '/panel/credit/product/'+status+'/list',
        columns: [
            { data: 'id' },
            { data: 'product' },
            { data: 'reason' },
            { data: 'date' },
            { data: 'client' },
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