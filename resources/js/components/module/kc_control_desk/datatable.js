document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-control-desk', {
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
        ajax: '/panel/kc-control-desk/list/show',
        columns: [
            { data: 'id' },
            { data: 'product' },
            { data: 'client' },
            { data: 'advisor' },
            { data: 'progress'},
            { data: 'in_progress'},
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
    // Expand table rows on click
    $('#dt-control-desk tbody').on('click', 'td', function () {
        var row = table.row($(this).closest('tr'));
        if (row.child.isShown()) {
            row.child.hide();
        }
        else {
            row.child.show();
        }
    });

} );

/*  reference */
document.addEventListener('DOMContentLoaded', function () {
    let history_id = $('#history_id').val();

    let table = NioApp.DataTable('#dt-credit-reference', {
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
        ajax: '/panel/reference/'+history_id+'/list',
        columns: [
            { data: 'id' },
            { data: 'names' },
            { data: 'last_name' },
            { data: 'second_lastname'},
            { data: 'relation'},
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


document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-delivery', {
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
        ajax: '/panel/kc-delivery/list/show',
        columns: [
            { data: 'id' },
            { data: 'product' },
            { data: 'client' },
            { data: 'advisor' },
            { data: 'progress'},
            { data: 'in_progress'},
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
    

    // Expand table rows on click
    $('#dt-delivery tbody').on('click', 'td', function () {
        var row = table.row($(this).closest('tr'));
        if (row.child.isShown()) {
            row.child.hide();
        }
        else {
            row.child.show();
        }
    });

} );

document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-after-market', {
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
        ajax: '/panel/kc-after-market/list/show',
        columns: [
            { data: 'id' },
            { data: 'product' },
            { data: 'client' },
            { data: 'advisor' },
            { data: 'progress'},
            { data: 'in_progress'},
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
    // Expand table rows on click
    $('#dt-after-market tbody').on('click', 'td', function () {
        var row = table.row($(this).closest('tr'));
        if (row.child.isShown()) {
            row.child.hide();
        }
        else {
            row.child.show();
        }
    });

} );

document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-payment', {
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
        ajax: '/panel/kc-payments/list/show',
        columns: [
            { data: 'id' },
            { data: 'product' },
            { data: 'client' },
            { data: 'advisor' },
            { data: 'progress'},
            { data: 'in_progress'},
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
    
    // Expand table rows on click
    $('#dt-payment tbody').on('click', 'td', function () {
        var row = table.row($(this).closest('tr'));
        if (row.child.isShown()) {
            row.child.hide();
        }
        else {
            row.child.show();
        }
    });

} );

/* wallet */
document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-wallet', {
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
        ajax: '/panel/kc-wallet/list/show',
        columns: [
            { data: 'id' },
            { data: 'date' },
            { data: 'ordenante' },
            { data: 'importe' },
            { data: 'progress'},
            { data: 'in_progress'},
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
    
    // Expand table rows on click
    $('#dt-wallet tbody').on('click', 'td', function () {
        var row = table.row($(this).closest('tr'));
        if (row.child.isShown()) {
            row.child.hide();
        }
        else {
            row.child.show();
        }
    });

    if (document.getElementById('dt-wallet')) {
        const urlParams = new URLSearchParams(window.location.search);
        const alertParam = urlParams.get('alert');

        if (alertParam === 'true' || document.getElementById('dt-wallet')) {
        Swal.fire({
            title: 'Solicitud de agregar fondos',
            html: 'Hemos recibido tu Solicitud. <br> Le avisaremos y notificaremos a la brevedad',
            icon: 'info',
            showCancelButton: false,
            confirmButtonText: 'ok',
            
        }).then(function (result) {
            if (result.value) {
            
            }
        });
        }
    }

} );

document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-down-wallet', {
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
        ajax: '/panel/kc-down-wallet/list/show',
        columns: [
            { data: 'id' },
            { data: 'date' },
            { data: 'ordenante' },
            { data: 'importe' },
            { data: 'progress'},
            { data: 'in_progress'},
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
    
    // Expand table rows on click
    $('#dt-down-wallet tbody').on('click', 'td', function () {
        var row = table.row($(this).closest('tr'));
        if (row.child.isShown()) {
            row.child.hide();
        }
        else {
            row.child.show();
        }
    });

} );
document.addEventListener('DOMContentLoaded', function () {
    let table = NioApp.DataTable('#dt-kc-swap', {
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
        ajax: '/panel/kc-swap/list/show',
        columns: [
            { data: 'id' },
            { data: 'product' },
            { data: 'client' },
            { data: 'advisor' },
            { data: 'progress'},
            { data: 'in_progress'},
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
    // Expand table rows on click
    $('#dt-kc-swap tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));
    if (row.child.isShown()) {
        row.child.hide();
    }
    else {
        row.child.show();
    }
});

} );