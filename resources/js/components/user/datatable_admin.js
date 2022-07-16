document.addEventListener('DOMContentLoaded', function () {
    let route = $('#route_datatable').val();
    let table = new DataTable('#dt-admin', {
        processing: true,
        ajax: '/panel/user/'+route+'/list/show',
        columns: [
            { data: 'name' },
            { data: 'last_name' },
            { data: 'second_last_name' },
            { data: 'cellphone' },
            { data: 'email' },
            { data: 'status' },
            { data: 'options',}
        ],
    } );
} );