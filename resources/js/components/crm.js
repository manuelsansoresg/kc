
import { showInfo } from './utilities';

function move(id, path, route, form, modal, datatable, title, msg){

    const new_form = document.getElementById(form);
    const data = new FormData(new_form);

    axios
    .post("panel/"+path+"/"+id+"/move/"+route, data)
    .then(function (response) {
        showInfo(2, datatable, title, msg);
        $('#'+modal).modal('hide');
    })
    .catch(e => {
        
    });
}

window.archiveModal = function(id) {
    $('#frm-archive').trigger("reset");
    $('#id_rel').val(id);
    $('#modal-archive-title').html('Archivar');
    $('#modal-archive').modal('show');
}
if (document.getElementById('frm-archive')) {
    NioApp.Select2('#modal-reason-id', {
        dropdownParent: $('#modal-archive')
    });
}


$( "#frm-archive" ).submit(function( event ) {
    event.preventDefault();
    
    let id_rel = $('#id_rel').val();
    let msg = 'registro archivado exitosamente';
    move(id_rel, 'lead', 'archive', 'frm-archive', 'modal-archive', 'dt-lead', 'Archivo', msg);
});

window.modalValidate = function(id, model){
    $('#modal-validate-content').html('');
    axios
    .get('/panel/'+id+'/'+model+'/validate/show')
    .then(function (response) {
        let result = response.data;
        $('#modal-validate-content').html(result);
        $('#modal-validate').modal('show');
    })
    .catch(e => {
        
    });

    
    
}