import { showInfo } from '../utilities';

$().ready(function () {
    $("#frm-tag").validate({
        rules: {
            'data[name]': {
                required: true,
            },
            'data[type_id]': {
                required: true,
            },
            'data[section_id]': {
                required: true,
            },
           
            'data[status]': {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            $('#frm-tag-name-unique-error').html('');
            $('#frm-tag-name-unique-error').hide();
            const new_form = document.getElementById("frm-tag");
            const data = new FormData(new_form);

            axios
                .post("/panel/tag", data)
                .then(function (response) {
                   window.location = '/panel/tag';
                })
                .catch(e => {
                    let response = e.response;
                    let data_errors = response.data.errors; 
                    $('#frm-tag-name-unique-error').html('Este campo ya se encuentra registrado.');
                    $('#frm-tag-name-unique-error').show();
                });

        }
    });

    if (document.getElementById('frm-tag') && $('#tag_id').val() != null) {
        let tag_id =  $('#tag_id').val();
        axios
        .get("/panel/tag/"+tag_id)
        .then(function (response) {
           let result = response.data;
           $('#frm-tag-name').val(result.name);
           $('#frm-tag-type_id option[value="' + result.type_id + '"]').attr("selected", "selected");
           $('#frm-tag-section_id option[value="' + result.type_id + '"]').attr("selected", "selected");
           $('#frm-tag-comment').val(result.name);
           $('#frm-tag-status option[value="' + result.status + '"]').attr("selected", "selected");
        })
        .catch(e => {
          
        });
    }

});

window.deleteTag = function (id) {
    axios
    .delete("/panel/tag/"+id)
    .then(function (response) {
        showInfo(2, 'dt-tag', 'Datos actualizados', 'Registro guardado');
    })
    .catch(e => {
    });
}

window.alerDelete = function (id) {
   
    Swal.fire({
        title: '¿Estás seguro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, elimina',
        cancelButtonText: 'Mejor no'
    }).then(function (result) {
        if (result.value) {
            deleteTag(id);
        }
    });
}