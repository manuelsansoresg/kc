var history_id;
if (document.getElementById('dt-check-up-steps')) {
    history_id = $('#history_id').val();
    model = $('#model').val();
    document.addEventListener('DOMContentLoaded', function () {
        let table = NioApp.DataTable('#dt-check-up-steps', {
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
            ajax: '/panel/template/list/'+model+'/'+history_id+'/show',
            columns: [
                { data: 'name'},
                { data: 'step' },
                { data: 'status' },
                { data: 'progress' },
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
}
