var history_id;
var model;
var step;
if (document.getElementById('dt-check-up-actions')) {
    history_id = $('#history_id').val();
    model = $('#model').val();
    step = $('#step').val();
}
document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-check-up-actions', {
        processing: true,
        searching: false,
        ordering:  false,
        paging: false,
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
        ajax: '/panel/template/actions/list/'+model+ '/'+history_id+ '/show?step='+step,
        columns: [
            { data: 'name'},
            { data: 'subject'},
            { data: 'status' },
            { data: 'deadline'},
            { data: 'advisor'},
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