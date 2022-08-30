import { showInfo } from './utilities';

window.modalNote = function (note_id, model_note) { 
    $('#id_rel').val(note_id);
    $('#model_note').val(model_note);
    $('#modal-lead-description').val('');
    $('#modal-lead-note').modal('show');
}

var refresh = {
    'credit': creditRefresh,
}

$( "#frm-lead-note" ).submit(function( event ) {
    event.preventDefault();
    let model_note    = $('#model_note').val();
    let refresh_dt    = $('#refresh-dt').val();

    const new_form = document.getElementById("frm-lead-note");
    const data = new FormData(new_form);

    axios
        .post("/panel/"+model_note+"/note", data)
        .then(function (response) {
            if (refresh_dt != 'null') {
                showInfo(2, 'dt-lead', 'Datos actualizados', 'Información actualizada correctamente');
                $('#modal-lead-note').modal('hide');
            } else {
                refresh[model_note]()
            }
        })
        .catch(e => {
            
        });
  });