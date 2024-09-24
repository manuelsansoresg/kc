document.addEventListener('DOMContentLoaded', function () {
    let route = $('#route_datatable').val();
    let  module_id = null;

    if (document.getElementById('module_id')) {
        module_id = $('#module_id').val();
    }

    let table_lead = NioApp.DataTable('#dt-clients', {
        processing: true,
        responsive: {
            details: {
                type: 'column',
            target: 'td:not(:first-child):not(:nth-child(2))',
            renderer: function ( api, rowIdx, columns ) {
                let total = columns.length -1;
                var data = $.map( columns, function ( col, i ) {
                    if (total == i) {
                        return col.hidden ?
                        '<tr  >'+
                        '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">'+col.data+'</td>'+
                        '</tr>' :
                        '';
                   } else {
                        return col.hidden ?
                        '<tr class="py-3" data-dt-row="'+col.rowIndex+'">'+
                            '<td style="padding-left: 10px; width:50%"><strong>'+col.title+'</strong></td> '+
                            '<td style="width:50%">'+col.data+'</td>'+
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
        ajax: '/panel/clients/list/show',
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'agreement' },
            { data: 'cellphone' },
            /* { data: 'organizacion' }, */
            { data: 'rfc' },
            { data: 'options' }
        ],
        columnDefs:[
            { className: "nk-tb-col", targets: "_all" },
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass("nk-tb-item");
            
        },
        
    },

    
    );
    
    // Expand table rows on click
    $('#dt-clients tbody').on('click', 'td', function () {
        var row = table_lead.row($(this).closest('tr'));
        if (row.child.isShown()) {
            row.child.hide();
        }
        else {
            row.child.show();
        }
    });
    
    


});