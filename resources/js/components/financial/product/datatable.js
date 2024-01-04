/* DT PRODUCT */
if (document.getElementById('dt-financial-product')) {
    var financial_id = $('#financial_id').val();
    if (financial_id != '') {
        document.addEventListener('DOMContentLoaded', function () {
            let table = NioApp.DataTable('#dt-financial-product', {
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
                ajax: '/panel/financial/product/'+financial_id+'/list/show',
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'status' },
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
    
}
