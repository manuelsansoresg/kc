import { showInfo } from './utilities';

window.modalNote = function (note_id, model_note) { 
    $('#id_rel').val(note_id);
    $('#model_note').val(model_note);
    $('#modal-lead-description').val('');
    $('#modal-note').modal('show');
}

var refresh = {
    'credit': creditRefresh,
}

$( "#frm-note" ).submit(function( event ) {
    event.preventDefault();
    let model_note    = $('#model_note').val();
    let refresh_dt    = $('#refresh-dt').val();

    const new_form = document.getElementById("frm-note");
    const data = new FormData(new_form);

    axios
        .post("/panel/"+model_note+"/note", data)
        .then(function (response) {
            if (refresh_dt != 'null') {
                showInfo(2, 'dt-lead', 'Datos actualizados', 'Información actualizada correctamente');
                $('#modal-note').modal('hide');
            } else {
                refresh[model_note]()
            }
        })
        .catch(e => {
            
        });
  });


  window.copyToClipBoardReport = function() {
    var content = document.getElementById('url_report').value;

    // Intentar usar la API del Portapapeles (navigator.clipboard) si está disponible
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(content)
            .then(() => {
                showToast('', 'URL copiada en el portapapeles', 'success');
            })
            .catch(err => {
                console.log('No se pudo copiar al portapapeles con la API del Portapapeles', err);
            });
    } else {
        // Si la API del Portapapeles no está disponible, usar métodos alternativos
        var textarea = document.createElement('textarea');
        textarea.value = content;
        textarea.style.position = 'fixed'; // Para asegurarse de que sea visible
        document.body.appendChild(textarea);
        textarea.select();

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'URL copiada en el portapapeles' : 'No se pudo copiar al portapapeles';
            showToast('', msg, successful ? 'success' : 'error');
        } catch (err) {
            console.log('No se pudo copiar al portapapeles con el método alternativo', err);
        } finally {
            document.body.removeChild(textarea);
        }
    }
}

