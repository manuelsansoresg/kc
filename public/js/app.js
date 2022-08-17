/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/components/action/crud.js":
/*!************************************************!*\
  !*** ./resources/js/components/action/crud.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");


window.actionModal = function (id, is_new) {
  if (document.getElementById('modal-action-id-rel-lead')) {
    getPerson(id);
  }

  resetAction();
  $('#modal-action-id-rel').val(id);

  if (is_new == 'true') {
    $('#modal-action-id-action').val(null);
  }

  $('#modal-action').modal('show');
};

if (document.getElementById('frm-action')) {
  $('#modal-action-type').select2({
    dropdownParent: $('#modal-action'),
    placeholder: "Escribe para buscar..",
    allowClear: true
  });
}

function getPerson(lead_id) {
  axios.get("/panel/lead/" + lead_id).then(function (response) {
    var result = response.data;
    var lead = result.lead;
    var lead_name = lead.name + ' ' + lead.last_name;
    $("#modal-action-id-rel-lead").prepend("<option value='" + lead.id + "' selected='selected'> " + lead_name + "</option>");
  })["catch"](function (e) {});
}

$().ready(function () {
  $("#frm-action").validate({
    rules: {
      'data[type]': {
        required: true
      },
      'data[start_date]': {
        required: true
      },
      'data[advisor_id]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var new_form = document.getElementById("frm-action");
      var data = new FormData(new_form);
      var refresh_dt = $('#refresh-dt').val();
      axios.post("/panel/action", data).then(function (response) {
        var result = response.data;
        var status = $('#modal-action-status').val();
        var id_action = $('#modal-action-id-action').val();
        console.log(status);

        if (status == 1 && result != null) {
          //*se marco como completada
          $('#register-action-id-rel').val(result.id);
          $('#modal-action').modal('hide');
          resetRegisterAction();

          if (id_action == 'null') {
            $('#modal-register-action').modal('show');
          }
        } else {
          $('#modal-action').modal('hide');

          if (refresh_dt != 'null') {
            (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, refresh_dt, 'Datos actualizados', 'Registro guardado');
          }
        } //refreshListActions();

      })["catch"](function (e) {});
    }
  });
});

function resetAction() {
  $("#modal-action-type").val('').trigger('change');
  $('#modal-action-subject').val('');
  $('#modal-action-start_date').val('');
  $('#modal-action-end_date').val('');
  $('#modal-action-description').val('');
  $('#modal-action-complete-active').prop("checked", true);
}

function resetRegisterAction() {
  $("#frm-register-action-state").val('').trigger('change');
  $('#frm-register-action-comment').val('');
  $('#frm-register-action-preview').html(''); //myDropzone.removeAllFiles(true); 
}

window.deleteFile = function (model, id) {
  $('#frm-register-action-preview').html('');
  axios.get("/panel/temp/images/" + id + "/delete").then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-lead', 'Archivos', 'Archivo borrado');
    reloadFile(model);
  })["catch"](function (e) {});
};

function reloadFile(model) {
  axios.get("/panel/temp/images/" + model + '/show').then(function (response) {
    $('#frm-register-action-preview').html(response.data);
  })["catch"](function (e) {});
}

$('#frm-action input').on('change', function () {
  var status = $('input[name=status]:checked', '#frm-action').val();
  $('#modal-action-status').val(status);
}); //*form register action

$().ready(function () {
  $("#frm-register-action").validate({
    rules: {
      'data[state]': {
        required: true
      },
      'data[comment]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var new_form = document.getElementById("frm-register-action");
      var data = new FormData(new_form);
      var refresh_dt = $('#refresh-dt').val();
      axios.post("/panel/register-action", data).then(function (response) {
        var result = response.data;
        $('#modal-register-action').modal('hide');

        if (refresh_dt != 'null') {
          (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, refresh_dt, 'Datos actualizados', 'Registro guardado');
        } else {
          refreshListActions();
        }
      })["catch"](function (e) {});
    }
  });
});

window.modalRegisterAction = function (model, id) {
  resetRegisterAction();
  axios.get("/panel/register-action/set-id/" + id + '/set').then(function (response) {})["catch"](function (e) {});
  axios.get("/panel/register-action/set-model/" + model + '/set').then(function (response) {})["catch"](function (e) {});
  $('#register-action-model').val(model);
  $('#register-action-id-rel').val(id);
  $('#modal-register-action').modal('show');
};

window.setIdRel = function () {};

window.deleteRegisterAction = function (action_id) {
  var refresh_dt = $('#refresh-dt').val();
  axios["delete"]("/panel/register-action/" + action_id).then(function (response) {
    if (refresh_dt != 'null') {
      (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, refresh_dt, 'Datos actualizados', 'Registro guardado');
    } else {
      refreshListActions();
    }
  })["catch"](function (e) {});
};

window.alerDeleteAction = function (id) {
  Swal.fire({
    title: '¿Estás seguro?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, elimina',
    cancelButtonText: 'Mejor no'
  }).then(function (result) {
    if (result.value) {
      deleteAction(id);
    }
  });
};

window.deleteAction = function (id) {
  var refresh_dt = $('#refresh-dt').val();
  axios["delete"]("/panel/action/" + id).then(function (response) {
    if (refresh_dt != 'null') {
      (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, refresh_dt, 'Datos actualizados', 'Registro guardado');
    } else {
      refreshListActions();
    }
  })["catch"](function (e) {});
};

window.setModalAction = function (action_id, disabled) {
  if (disabled == true) {
    $('#frm-action input, textarea, select').attr('disabled', 'disabled');
    $('#modal-action-save').hide();
  }

  axios.get("/panel/action/" + action_id).then(function (response) {
    var result = response.data;
    var action = result.action;
    var advisor = result.advisor;
    var lead = result.lead; //*set value form action

    if (result != null) {
      var lead_name = lead.name + ' ' + lead.last_name;
      $("#modal-action-type").val(action.type).trigger('change');
      $("#modal-action-subject").val(action.subject);
      $("#modal-action-id-action").val(action_id);
      $("#modal-action-subject").val(action.subject);
      $("#modal-action-id-section").val(action.section);
      $("#modal-action-status").val(action.status);
      $("#modal-action-start_date").val(action.start_date);
      $("#modal-action-start_time").val(action.start_time);
      $("#modal-action-end_date").val(action.end_date);
      $("#modal-action-description").val(action.description);
      $("#modal-action-id-rel").val(action.id_rel);
      $("#lead-asesor-id").val(advisor.id).trigger('change');
      $("#modal-action-id-rel-lead").prepend("<option value='" + lead.id + "' selected='selected'> " + lead_name + "</option>");
      $('#modal-action').modal('show');

      if (action.status == 1) {
        $('#modal-action-complete-active').prop("checked", true);
        $('#modal-action-complete-pending').prop("checked", false);
      } else {
        $('#modal-action-complete-active').prop("checked", false);
        $('#modal-action-complete-pending').prop("checked", true);
      }
    }
  })["catch"](function (e) {});
};

window.refreshAction = function (id, model, status, content) {
  $('#' + content + '').html();
  axios.get("/panel/action/list/" + id + "/" + model + "/" + status).then(function (response) {
    $('#' + content + '').html(response.data);
  })["catch"](function (e) {});
};

window.refreshListActions = function () {
  var id_rel = $('#id-rel-action').val();
  var model = $('#model-action').val();
  refreshAction(id_rel, model, 'in_progress', 'content-profile-in_progress');
  refreshAction(id_rel, model, 'completed', 'content-profile-completed');
};

if (document.getElementById('content-profile-in_progress')) {
  refreshListActions();
}

/***/ }),

/***/ "./resources/js/components/action/datatable.js":
/*!*****************************************************!*\
  !*** ./resources/js/components/action/datatable.js ***!
  \*****************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var status = $('#dt-action-status').val();
  var table = NioApp.DataTable('#dt-acctions', {
    processing: true,
    responsive: {
      details: true
    },
    ajax: '/panel/action/' + status + '/dt/show',
    columns: [{
      data: 'type'
    }, {
      data: 'subject'
    }, {
      data: 'section'
    }, {
      data: 'name'
    }, {
      data: 'date_in'
    }, {
      data: 'date_fin'
    }, {
      data: 'advisor'
    }, {
      data: 'options',
      className: 'nk-tb-col-tools text-end'
    }],
    columnDefs: [{
      className: "nk-tb-col",
      targets: "_all"
    }],
    createdRow: function createdRow(row, data, dataIndex) {
      $(row).addClass("nk-tb-item odd");
    }
  });
});

/***/ }),

/***/ "./resources/js/components/agreement/crud.js":
/*!***************************************************!*\
  !*** ./resources/js/components/agreement/crud.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");


window.deleteAgreement = function (agreement) {
  axios.get("panel/agreement/" + agreement + "/delete").then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-agreement', 'Datos actualizados', 'Información actualizada correctamente');
  })["catch"](function (e) {});
};

$().ready(function () {
  $("#frm-agreement").validate({
    rules: {
      'data[name]': {
        required: true
      },
      'data[status]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var new_form = document.getElementById("frm-agreement");
      var data = new FormData(new_form);
      axios.post("/panel/agreement", data).then(function (response) {
        var result = response.data;
        (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-agreement', 'Datos actualizados', 'Información actualizada correctamente');
        window.location = '/panel/agreement';
      })["catch"](function (e) {});
    }
  });
});

/***/ }),

/***/ "./resources/js/components/agreement/datatable.js":
/*!********************************************************!*\
  !*** ./resources/js/components/agreement/datatable.js ***!
  \********************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var route = $('#route_datatable').val();
  var table = NioApp.DataTable('#dt-agreement', {
    processing: true,
    ajax: '/panel/agreement/list/show',
    columns: [{
      data: 'name'
    }, {
      data: 'description'
    }, {
      data: 'status'
    }, {
      data: 'options'
    }],
    columnDefs: [{
      className: "nk-tb-col",
      targets: "_all"
    }],
    createdRow: function createdRow(row, data, dataIndex) {
      $(row).addClass("nk-tb-item");
    }
  });
});

/***/ }),

/***/ "./resources/js/components/crm.js":
/*!****************************************!*\
  !*** ./resources/js/components/crm.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utilities */ "./resources/js/components/utilities.js");


function move(id, path, route, form, modal, datatable, title, msg) {
  var new_form = document.getElementById(form);
  var data = new FormData(new_form);
  axios.post("panel/" + path + "/" + id + "/move/" + route, data).then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, datatable, title, msg);
    $('#' + modal).modal('hide');
  })["catch"](function (e) {});
}

window.archiveModal = function (id) {
  $('#frm-archive').trigger("reset");
  $('#id_rel').val(id);
  $('#modal-archive-title').html('Archivar');
  $('#modal-archive').modal('show');
};

if (document.getElementById('frm-archive')) {
  NioApp.Select2('#modal-reason-id', {
    dropdownParent: $('#modal-archive')
  });
}

$("#frm-archive").submit(function (event) {
  event.preventDefault();
  var id_rel = $('#id_rel').val();
  var msg = 'registro archivado exitosamente';
  move(id_rel, 'lead', 'archive', 'frm-archive', 'modal-archive', 'dt-lead', 'Archivo', msg);
});

window.modalValidate = function (id, model) {
  $('#modal-validate-content').html('');
  axios.get('/panel/' + id + '/' + model + '/validate/show').then(function (response) {
    var result = response.data;
    $('#modal-validate-content').html(result);
    $('#modal-validate').modal('show');
  })["catch"](function (e) {});
};

/***/ }),

/***/ "./resources/js/components/datatable.js":
/*!**********************************************!*\
  !*** ./resources/js/components/datatable.js ***!
  \**********************************************/
/***/ (() => {

/* $(document).ready(function () {
    $('.datatable').DataTable(
        {
            "language": 
            {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "infoThousands": ",",
                "loadingRecords": "Cargando...",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": "Copiar",
                    "colvis": "Visibilidad",
                    "collection": "Colección",
                    "colvisRestore": "Restaurar visibilidad",
                    "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                    "copySuccess": {
                        "1": "Copiada 1 fila al portapapeles",
                        "_": "Copiadas %ds fila al portapapeles"
                    },
                    "copyTitle": "Copiar al portapapeles",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Mostrar todas las filas",
                        "_": "Mostrar %d filas"
                    },
                    "pdf": "PDF",
                    "print": "Imprimir",
                    "renameState": "Cambiar nombre",
                    "updateState": "Actualizar",
                    "createState": "Crear Estado",
                    "removeAllStates": "Remover Estados",
                    "removeState": "Remover",
                    "savedStates": "Estados Guardados",
                    "stateRestore": "Estado %d"
                },
                "autoFill": {
                    "cancel": "Cancelar",
                    "fill": "Rellene todas las celdas con <i>%d<\/i>",
                    "fillHorizontal": "Rellenar celdas horizontalmente",
                    "fillVertical": "Rellenar celdas verticalmentemente"
                },
                "decimal": ",",
                "searchBuilder": {
                    "add": "Añadir condición",
                    "button": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "clearAll": "Borrar todo",
                    "condition": "Condición",
                    "conditions": {
                        "date": {
                            "after": "Despues",
                            "before": "Antes",
                            "between": "Entre",
                            "empty": "Vacío",
                            "equals": "Igual a",
                            "notBetween": "No entre",
                            "notEmpty": "No Vacio",
                            "not": "Diferente de"
                        },
                        "number": {
                            "between": "Entre",
                            "empty": "Vacio",
                            "equals": "Igual a",
                            "gt": "Mayor a",
                            "gte": "Mayor o igual a",
                            "lt": "Menor que",
                            "lte": "Menor o igual que",
                            "notBetween": "No entre",
                            "notEmpty": "No vacío",
                            "not": "Diferente de"
                        },
                        "string": {
                            "contains": "Contiene",
                            "empty": "Vacío",
                            "endsWith": "Termina en",
                            "equals": "Igual a",
                            "notEmpty": "No Vacio",
                            "startsWith": "Empieza con",
                            "not": "Diferente de",
                            "notContains": "No Contiene",
                            "notStarts": "No empieza con",
                            "notEnds": "No termina con"
                        },
                        "array": {
                            "not": "Diferente de",
                            "equals": "Igual",
                            "empty": "Vacío",
                            "contains": "Contiene",
                            "notEmpty": "No Vacío",
                            "without": "Sin"
                        }
                    },
                    "data": "Data",
                    "deleteTitle": "Eliminar regla de filtrado",
                    "leftTitle": "Criterios anulados",
                    "logicAnd": "Y",
                    "logicOr": "O",
                    "rightTitle": "Criterios de sangría",
                    "title": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "value": "Valor"
                },
                "searchPanes": {
                    "clearMessage": "Borrar todo",
                    "collapse": {
                        "0": "Paneles de búsqueda",
                        "_": "Paneles de búsqueda (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Sin paneles de búsqueda",
                    "loadMessage": "Cargando paneles de búsqueda",
                    "title": "Filtros Activos - %d",
                    "showMessage": "Mostrar Todo",
                    "collapseMessage": "Colapsar Todo"
                },
                "select": {
                    "cells": {
                        "1": "1 celda seleccionada",
                        "_": "%d celdas seleccionadas"
                    },
                    "columns": {
                        "1": "1 columna seleccionada",
                        "_": "%d columnas seleccionadas"
                    },
                    "rows": {
                        "1": "1 fila seleccionada",
                        "_": "%d filas seleccionadas"
                    }
                },
                "thousands": ".",
                "datetime": {
                    "previous": "Anterior",
                    "next": "Proximo",
                    "hours": "Horas",
                    "minutes": "Minutos",
                    "seconds": "Segundos",
                    "unknown": "-",
                    "amPm": [
                        "AM",
                        "PM"
                    ],
                    "months": {
                        "0": "Enero",
                        "1": "Febrero",
                        "10": "Noviembre",
                        "11": "Diciembre",
                        "2": "Marzo",
                        "3": "Abril",
                        "4": "Mayo",
                        "5": "Junio",
                        "6": "Julio",
                        "7": "Agosto",
                        "8": "Septiembre",
                        "9": "Octubre"
                    },
                    "weekdays": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mie",
                        "Jue",
                        "Vie",
                        "Sab"
                    ]
                },
                "editor": {
                    "close": "Cerrar",
                    "create": {
                        "button": "Nuevo",
                        "title": "Crear Nuevo Registro",
                        "submit": "Crear"
                    },
                    "edit": {
                        "button": "Editar",
                        "title": "Editar Registro",
                        "submit": "Actualizar"
                    },
                    "remove": {
                        "button": "Eliminar",
                        "title": "Eliminar Registro",
                        "submit": "Eliminar",
                        "confirm": {
                            "_": "¿Está seguro que desea eliminar %d filas?",
                            "1": "¿Está seguro que desea eliminar 1 fila?"
                        }
                    },
                    "error": {
                        "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                    },
                    "multi": {
                        "title": "Múltiples Valores",
                        "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                        "restore": "Deshacer Cambios",
                        "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                    }
                },
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "stateRestore": {
                    "creationModal": {
                        "button": "Crear",
                        "name": "Nombre:",
                        "order": "Clasificación",
                        "paging": "Paginación",
                        "search": "Busqueda",
                        "select": "Seleccionar",
                        "columns": {
                            "search": "Búsqueda de Columna",
                            "visible": "Visibilidad de Columna"
                        },
                        "title": "Crear Nuevo Estado",
                        "toggleLabel": "Incluir:"
                    },
                    "emptyError": "El nombre no puede estar vacio",
                    "removeConfirm": "¿Seguro que quiere eliminar este %s?",
                    "removeError": "Error al eliminar el registro",
                    "removeJoiner": "y",
                    "removeSubmit": "Eliminar",
                    "renameButton": "Cambiar Nombre",
                    "renameLabel": "Nuevo nombre para %s",
                    "duplicateError": "Ya existe un Estado con este nombre.",
                    "emptyStates": "No hay Estados guardados",
                    "removeTitle": "Remover Estado",
                    "renameTitle": "Cambiar Nombre Estado"
                }
            }  
        }
    );
}); */

/***/ }),

/***/ "./resources/js/components/lead/crud.js":
/*!**********************************************!*\
  !*** ./resources/js/components/lead/crud.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");

$('.js-select2').select2({
  placeholder: "Escribe para buscar..",
  allowClear: true
});
$("#lead-agreement").change(function () {
  var lead_agreement = $("#lead-agreement").val();
  $('#lead-content-agreement').hide();

  if (lead_agreement == 0) {
    $('#lead-content-agreement').show('slow');
  }
});
$("#lead-origin").change(function () {
  var origin_id = $("#lead-origin").val();
  $('#lead-channel').empty();
  axios.get("/panel/lead/" + origin_id + "/origin/").then(function (response) {
    var result = response.data;

    if (result != null) {
      var lead_channel = $('#lead-channel');

      for (var key in result) {
        var element = result[key];

        if (element != 'Selecciona una opción') {
          var option = new Option(element, key, true, true);
          lead_channel.append(option).trigger('change');
        }
      }
    }
  })["catch"](function (e) {
    $('#admin_email-error-exist').show();
  });
});

function setData() {
  var lead_id = $('#lead_id').val();
  $('#lead-channel').empty();
  axios.get("/panel/lead/" + lead_id).then(function (response) {
    var result = response.data;
    var lead = result.lead;
    var channel = result.channel;
    $('#lead-agreement option[value="' + lead.agreement_id + '"]').attr("selected", "selected");
    $('#lead-product-id option[value="' + lead.product_id + '"]').attr("selected", "selected");
    $('#lead-origin option[value="' + lead.origin_id + '"]').attr("selected", "selected");
    $('#lead-asesor-id option[value="' + lead.asesor_id + '"]').attr("selected", "selected");
    $('#lead-temperature-id option[value="' + lead.temperature_id + '"]').attr("selected", "selected");
    $('#lead-name').val(lead.name);
    $('#lead-last_name').val(lead.last_name);
    $('#lead-second_last_name').val(lead.second_last_name);
    $('#lead-cellphone').val(lead.cellphone);
    $('#lead-email').val(lead.email);

    if (channel != null) {
      var lead_channel = $('#lead-channel');

      for (var key in channel) {
        var element = channel[key];

        if (element != 'Selecciona una opción') {
          var option = new Option(element, key, true, true);
          lead_channel.append(option).trigger('change');
        }
      }
    }

    $('#lead-channel option[value="' + lead.channel_id + '"]').attr("selected", "selected");
  })["catch"](function (e) {
    $('#admin_email-error-exist').show();
  });
}

window.deleteLead = function (lead_id) {
  axios.get("panel/lead/" + lead_id + "/delete").then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-lead', 'Datos actualizados', 'Información actualizada correctamente');
  })["catch"](function (e) {});
};

window.modalNoteLead = function (note_id) {
  $('#lead_note_id').val(note_id);
  $('#modal-lead-description').val('');
  $('#modal-lead-note').modal('show');
};

$("#frm-lead-note").submit(function (event) {
  event.preventDefault();
  var lead_id = $('#lead_note_id').val();
  var description = $('#modal-lead-description').val();
  axios.post("panel/lead/" + lead_id + "/note", {
    description: description
  }).then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-lead', 'Datos actualizados', 'Información actualizada correctamente');
    $('#modal-lead-note').modal('hide');
  })["catch"](function (e) {});
});

window.modalAdvisor = function (lead_id) {
  $('#lead_advisor_id').val(lead_id);
  $('#modal-advisor').modal('show');
};

$("#frm-advisor").submit(function (event) {
  event.preventDefault();
  var asesor_id = $('#modal-advisor-id').val();
  var lead_id = $('#lead_advisor_id').val();
  axios.post("panel/lead/" + lead_id + "/advisor/store", {
    asesor_id: asesor_id
  }).then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-lead', 'Datos actualizados', 'Prospecto asignado');
    $('#modal-advisor').modal('hide');
  })["catch"](function (e) {});
});

window.createClientPerson = function (lead_id) {
  axios.post("panel/lead/" + lead_id + "/client-person/store").then(function (response) {
    var result = response.data;
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-lead', 'Datos actualizados', 'Cuenta creada');
  })["catch"](function (e) {});
};

window.modalTags = function (lead_id) {
  $('#modal-tag-lead_id').val(lead_id);
  $('#modal-tags').modal('show');
};

if (document.getElementById('frm-advisor')) {
  $('#modal-advisor-id').select2({
    dropdownParent: $('#modal-advisor'),
    placeholder: "Escribe para buscar..",
    allowClear: true
  });
}

if (document.getElementById('frm-tags')) {
  $('#modal-tags-tag').select2({
    dropdownParent: $('#modal-tags'),
    placeholder: "Escribe para buscar..",
    allowClear: true
  });
}

$("#frm-tags").submit(function (event) {
  event.preventDefault();
  var lead_id = $('#modal-tag-lead_id').val();
  var new_form = document.getElementById("frm-tags");
  var data = new FormData(new_form);
  axios.post("panel/lead/" + lead_id + "/tag/update", data).then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-lead', 'Datos actualizados', 'Etiqueta actualizada');
    $('#modal-tags').modal('hide');
  })["catch"](function (e) {});
});
$().ready(function () {
  $("#frm-lead").validate({
    rules: {
      'data[name]': {
        required: true
      },
      'data[last_name]': {
        required: true
      },
      'data[cellphone]': {
        number: true,
        minlength: 10
      },
      'data[email]': {
        required: true,
        email: true
      },
      'data[origin_id]': {
        required: true
      },
      'data[channel_id]': {
        required: true
      },
      'new_agreement': {
        required: function required(element) {
          var lead_agreement = $("#lead-agreement").val();

          if (lead_agreement == 0) {
            return true;
          } else {
            return false;
          }
        }
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var new_form = document.getElementById("frm-lead");
      var data = new FormData(new_form);
      axios.post("/panel/lead", data).then(function (response) {
        var result = response.data;
        window.location = '/panel/lead';
      })["catch"](function (e) {});
    }
  });
});

window.modalPasswod = function (user_id) {
  $('#password_user_id').val(user_id);
  $('#modal-user-password').modal('show');
}; //*id_rel is action_id


window.modalRegisterAction = function (id_rel) {
  $('#register-action-id-rel').val(id_rel);
  $('#modal-register-action').modal('show');
};
/* function resolveTextSetting() {
    return new Promise(resolve => {
      setTimeout(() => {
        setData();
      }, 3000);
    });
  } */


$(document).ready(function () {
  if (document.getElementById('lead-channel')) {
    /* resolveTextSetting(); */
    setData();
  }
});
$(document).on("select2:open", function () {
  document.querySelector(".select2-container--open .select2-search__field").focus();
});

/***/ }),

/***/ "./resources/js/components/lead/datatable.js":
/*!***************************************************!*\
  !*** ./resources/js/components/lead/datatable.js ***!
  \***************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var route = $('#route_datatable').val();
  var table = NioApp.DataTable('#dt-lead', {
    processing: true,
    responsive: {
      details: true
    },
    ajax: '/panel/lead/list/show',
    columns: [{
      data: 'name'
    }, {
      data: 'date'
    }, {
      data: 'product'
    }, {
      data: 'origin'
    }, {
      data: 'label'
    }, {
      data: 'advisor'
    }, {
      data: 'status'
    }, {
      data: 'options',
      className: 'nk-tb-col-tools text-end'
    }],
    columnDefs: [{
      className: "nk-tb-col",
      targets: "_all"
    }],
    createdRow: function createdRow(row, data, dataIndex) {
      $(row).addClass("nk-tb-item odd");
    }
  });
  var table_archive = NioApp.DataTable('#dt-lead-archive', {
    processing: true,
    ajax: '/panel/archive/lead/list/show',
    columns: [{
      data: 'name'
    }, {
      data: 'date'
    }, {
      data: 'product'
    }, {
      data: 'origin'
    }, {
      data: 'label'
    }, {
      data: 'advisor'
    }, {
      data: 'status'
    }, {
      data: 'options'
    }],
    columnDefs: [{
      className: "nk-tb-col",
      targets: "_all"
    }],
    createdRow: function createdRow(row, data, dataIndex) {
      $(row).addClass("nk-tb-item odd");
    }
  });
});

/***/ }),

/***/ "./resources/js/components/product/crud.js":
/*!*************************************************!*\
  !*** ./resources/js/components/product/crud.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");


window.modalProduct = function (type, product_id) {
  var route_datatable = $('#route_datatable').val();
  $('#frm-product').trigger("reset");

  if (type === 1) {
    $('#product-title').html('Crear producto');
    $('#product_id').val(null);
  } else {
    $('#product-title').html('Editar producto');
    $('#product_id').val(product_id);
    setDataUser(product_id);
  }

  $('#modal-product').modal('show');
};

function setDataUser(product_id) {
  axios.get("/panel/product/" + product_id).then(function (response) {
    var result = response.data;
    $('#c_product_id option[value="' + result.c_product_id + '"]').attr("selected", "selected");
    $('#c_service_id option[value="' + result.c_service_id + '"]').attr("selected", "selected");
    $('#status option[value="' + result.status + '"]').attr("selected", "selected");
    $('#comment').val(result.comment);
    $('#product-alias').val(result.alias);
  })["catch"](function (e) {
    $('#admin_email-error-exist').show();
  });
}

window.deleteProduct = function (product_id) {
  axios.get("panel/product/" + product_id + "/delete").then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-product', 'Datos actualizados', 'Información actualizada correctamente');
  })["catch"](function (e) {});
};

$().ready(function () {
  $("#frm-product").validate({
    rules: {
      alias: {
        required: true
      },
      c_product_id: {
        required: true
      },
      c_service_id: {
        required: true
      },
      status: {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var new_form = document.getElementById("frm-product");
      var data = new FormData(new_form);
      axios.post("/panel/product", data).then(function (response) {
        var result = response.data;
        (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-product', 'Datos actualizados', 'Información actualizada correctamente');
        $('#modal-product').modal('hide');
      })["catch"](function (e) {});
    }
  });
  $("#frmpassword").validate({
    rules: {
      user_password: {
        required: true,
        minlength: 8
      },
      user_pass_confirm: {
        required: true,
        minlength: 8,
        equalTo: "#user_password"
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var new_form = document.getElementById("frmpassword");
      var data = new FormData(new_form);
      var route_datatable = $('#route_datatable').val();
      axios.post("/panel/user/" + route_datatable + "/password/update", data).then(function (response) {
        var result = response.data;
        (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-admin', 'Datos actualizados', 'Información actualizada correctamente');
        $('#modal-user-password').modal('hide');
      })["catch"](function (e) {});
    }
  });
});

window.modalPasswod = function (user_id) {
  $('#password_user_id').val(user_id);
  $('#modal-user-password').modal('show');
};

/***/ }),

/***/ "./resources/js/components/product/datatable_product.js":
/*!**************************************************************!*\
  !*** ./resources/js/components/product/datatable_product.js ***!
  \**************************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var route = $('#route_datatable').val();
  var table = NioApp.DataTable('#dt-product', {
    processing: true,
    ajax: '/panel/product/list/show',
    columns: [{
      data: 'alias'
    }, {
      data: 'name'
    }, {
      data: 'service'
    }, {
      data: 'comment'
    }, {
      data: 'status'
    }, {
      data: 'options'
    }],
    columnDefs: [{
      className: "nk-tb-col",
      targets: "_all"
    }],
    createdRow: function createdRow(row, data, dataIndex) {
      $(row).addClass("nk-tb-item");
    }
  });
});

/***/ }),

/***/ "./resources/js/components/toastr.js":
/*!*******************************************!*\
  !*** ./resources/js/components/toastr.js ***!
  \*******************************************/
/***/ (() => {

"use strict";


(function (NioApp, $) {
  'use strict'; // Uses
  // NioApp.Toast(message, type, {attr});
  // 
  // @message     = 'Your message' 
  // @type        = 'info|success|warning|error',  
  // @attr        = {position: 'bottom-right', icon: 'auto', ui: ''}
  // 
  // attr.ui used for additonal class as is-dark
  // attr.icon used for custom icon
  // attr.position used for position of the msg.
  // Example Trigger

  $('.eg-toastr-default').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for deafult toast message.', 'info');
  });
  $('.eg-toastr-bottom-center').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for bottom center toast message.', 'info', {
      position: 'bottom-center'
    });
  });
  $('.eg-toastr-bottom-right').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for bottom right toast message.', 'info');
  });
  $('.eg-toastr-bottom-left').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for bottom left toast message.', 'info', {
      position: 'bottom-left'
    });
  });
  $('.eg-toastr-bottom-full').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for bottom full width toast message.', 'info', {
      position: 'bottom-full'
    });
  });
  $('.eg-toastr-top-center').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for top center toast message.', 'info', {
      position: 'top-center'
    });
  });
  $('.eg-toastr-top-right').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for top right toast message.', 'info', {
      position: 'top-right'
    });
  });
  $('.eg-toastr-top-left').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for top left toast message.', 'info', {
      position: 'top-left'
    });
  });
  $('.eg-toastr-top-full').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for top full width toast message.', 'info', {
      position: 'top-full'
    });
  });
  $('.eg-toastr-info').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for bottom right toast message.', 'info');
  });
  $('.eg-toastr-success').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for success toast message.', 'success');
  });
  $('.eg-toastr-warning').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for warning toast message.', 'warning');
  });
  $('.eg-toastr-error').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is a note for error toast message.', 'error');
  });
  $('.eg-toastr-dark').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is dark version note of toast message.', 'info', {
      ui: 'is-dark'
    });
  });
  $('.eg-toastr-no-icon').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('This is without icon note of toast message.', 'info', {
      icon: false
    });
  });
  $('.eg-toastr-with-title').on("click", function (e) {
    e.preventDefault();
    toastr.clear();
    NioApp.Toast('<h5>Update Successfully</h5><p>Your profile has been successfully updated.</p>', 'success', {
      position: 'top-right'
    });
  });

  window.showToast = function (title, description, type) {
    toastr.clear();
    NioApp.Toast('<h5>' + title + '</h5><p>' + description + '</p>', '' + type + '', {
      position: 'top-right'
    });
  };

  window.showToastDark = function (title, description, type) {
    toastr.clear();
    NioApp.Toast('<h5>' + title + '</h5><p>' + description + '</p>', '' + type + '', {
      position: 'top-right',
      ui: 'is-dark'
    });
  };
})(NioApp, jQuery);

/***/ }),

/***/ "./resources/js/components/user/crud.js":
/*!**********************************************!*\
  !*** ./resources/js/components/user/crud.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");


window.modalUser = function (type, user_id) {
  var route_datatable = $('#route_datatable').val();
  var title = $('#title').val();
  $('#frmadmin').trigger("reset");

  if (type === 1) {
    $('#user-admin-title').html('Crear usuario ' + title);
    $('#content-password').show();
    $('#content-pass_confirm').show();
    $('#user_id').val(null);
    $('#type_user').val(route_datatable);
  } else {
    $('#user-admin-title').html('Editar usuario ' + route_datatable);
    $('#content-pass_confirm').hide();
    $('#content-password').hide();
    $('#user_id').val(user_id);
    setDataUser(user_id);
    $('#type_user').val(route_datatable);
  }

  $('#modal-user-admin').modal('show');
};

function setDataUser(user_id) {
  var route_datatable = $('#route_datatable').val();
  axios.get("/panel/user/" + route_datatable + "/" + user_id).then(function (response) {
    var result = response.data;
    var razon_social = result.razon_social;

    if (razon_social != '') {
      //*limpiar los valores razon social
      $('#content-razon').hide();
      $('#razon_social').val('');
      var type_person = result.type_person;
      $('#c_financial_id option[value="' + result.c_financial_id + '"]').attr("selected", "selected");
      $('#type_person option[value="' + result.type_person + '"]').attr("selected", "selected");

      if (type_person == 2) {
        $('#razon_social').val(result.razon_social);
        $('#content-razon').show();
      }
    }

    if (document.getElementById('type_person')) {
      $('#c_financial_id option[value="' + result.c_financial_id + '"]').attr("selected", "selected");
      $('#type_person option[value="' + result.type_person + '"]').attr("selected", "selected");
    }

    $('#name').val(result.name);
    $('#last_name').val(result.last_name);
    $('#second_last_name').val(result.second_last_name);
    $('#cellphone').val(result.cellphone);
    $('#email').val(result.email);
    $('#status option[value="' + result.status + '"]').attr("selected", "selected");
  })["catch"](function (e) {
    $('#admin_email-error-exist').show();
  });
}

window.deleteUser = function (id) {
  axios.get("/panel/user/administrador/" + id + "/delete").then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-admin', 'Datos actualizados', 'Información actualizada correctamente');
  })["catch"](function (e) {});
};

$().ready(function () {
  $("#frmadmin").validate({
    rules: {
      name: {
        required: true
      },
      last_name: {
        required: true
      },
      cellphone: {
        required: true,
        number: true,
        minlength: 10
      },
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 8
      },
      pass_confirm: {
        required: true,
        minlength: 8,
        equalTo: "#password"
      },
      status: {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      $('#admin_email-error-exist').hide();
      var new_form = document.getElementById("frmadmin");
      var data = new FormData(new_form);
      axios.post("/panel/user/administrador", data).then(function (response) {
        var result = response.data;
        (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-admin', 'Datos actualizados', 'Información actualizada correctamente');
        $('#modal-user-admin').modal('hide');
      })["catch"](function (e) {
        $('#admin_email-error-exist').show();
      });
    }
  });
  $("#frmfinanciera").validate({
    rules: {
      c_financial_id: {
        required: true
      },
      type_person: {
        required: true
      },
      razon_social: {
        required: function required(element) {
          var type_person = $("#type_person").val();

          if (type_person == 2) {
            return true;
          } else {
            return false;
          }
        }
      },
      name: {
        required: true
      },
      last_name: {
        required: true
      },
      cellphone: {
        number: true,
        minlength: 10
      },
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 8
      },
      pass_confirm: {
        required: true,
        minlength: 8,
        equalTo: "#password"
      },
      status: {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      $('#admin_email-error-exist').hide();
      var new_form = document.getElementById("frmfinanciera");
      var data = new FormData(new_form);
      axios.post("/panel/user/administrador", data).then(function (response) {
        var result = response.data;
        (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-financiera', 'Datos actualizados', 'Información actualizada correctamente');
        $('#modal-user-admin').modal('hide');
      })["catch"](function (e) {});
    }
  });
  $("#frmpassword").validate({
    rules: {
      user_password: {
        required: true,
        minlength: 8
      },
      user_pass_confirm: {
        required: true,
        minlength: 8,
        equalTo: "#user_password"
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var new_form = document.getElementById("frmpassword");
      var data = new FormData(new_form);
      var route_datatable = $('#route_datatable').val();
      axios.post("/panel/user/" + route_datatable + "/password/update", data).then(function (response) {
        var result = response.data;
        (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-admin', 'Datos actualizados', 'Información actualizada correctamente');
        $('#modal-user-password').modal('hide');
      })["catch"](function (e) {});
    }
  });
});

window.modalPasswod = function (user_id) {
  $('#password_user_id').val(user_id);
  $('#modal-user-password').modal('show');
};

window.showRazon = function () {
  var type_person = $('#type_person').val();
  $('#content-razon').hide();

  if (type_person == 2) {
    $('#content-razon').show();
  }
};

/***/ }),

/***/ "./resources/js/components/user/datatable_admin.js":
/*!*********************************************************!*\
  !*** ./resources/js/components/user/datatable_admin.js ***!
  \*********************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var route = $('#route_datatable').val();
  var table = NioApp.DataTable('#dt-admin', {
    processing: true,
    ajax: '/panel/user/' + route + '/list/show',
    columns: [{
      data: 'name'
    }, {
      data: 'last_name'
    }, {
      data: 'second_last_name'
    }, {
      data: 'cellphone'
    }, {
      data: 'email'
    }, {
      data: 'status'
    }, {
      data: 'options'
    }],
    columnDefs: [{
      className: "nk-tb-col",
      targets: "_all"
    }],
    createdRow: function createdRow(row, data, dataIndex) {
      $(row).addClass("nk-tb-item");
    }
  });
});

/***/ }),

/***/ "./resources/js/components/user/datatable_financiera.js":
/*!**************************************************************!*\
  !*** ./resources/js/components/user/datatable_financiera.js ***!
  \**************************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var route = $('#route_datatable').val();
  var table = NioApp.DataTable('#dt-financiera', {
    processing: true,
    ajax: '/panel/user/' + route + '/list/show',
    columns: [{
      data: 'financial'
    }, {
      data: 'type_person'
    }, {
      data: 'name'
    }, {
      data: 'email'
    }, {
      data: 'cellphone'
    }, {
      data: 'status'
    }, {
      data: 'options'
    }],
    columnDefs: [{
      className: "nk-tb-col",
      targets: "_all"
    }],
    createdRow: function createdRow(row, data, dataIndex) {
      $(row).addClass("nk-tb-item");
    }
  });
});

/***/ }),

/***/ "./resources/js/components/utilities.js":
/*!**********************************************!*\
  !*** ./resources/js/components/utilities.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "showInfo": () => (/* binding */ showInfo)
/* harmony export */ });
function showInfo(redirect, idDatatable, title, msg) {
  showToast(title, msg, 'success');

  if (redirect == 1) {
    //*redirect back
    window.history.back();
  }

  if (idDatatable == null) {
    location.reload();
  } else {
    $('#' + idDatatable).DataTable().ajax.reload();
  }
}

/***/ }),

/***/ "./resources/js/components/websocket.js":
/*!**********************************************!*\
  !*** ./resources/js/components/websocket.js ***!
  \**********************************************/
/***/ (() => {

/* import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'abcb59ca67abeb8745bb',
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: true,
    disableStats: false,
    enabledTransports:['ws', 'wss']
});
 Echo.channel('trades')
            .listen('SendPush', (e) => {
                console.log(e.trade);
            })
 */
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;
var pusher = new Pusher('cb2d06fb80592c4ce5f2', {
  cluster: 'us2'
});
var channel = pusher.subscribe('kaaxclub');
channel.bind('kaaxclub-event', function (data) {
  var model = data.model;
  axios.get('/panel/notification/' + model + '/show').then(function (response) {
    var result = response.data;
    var my_user = $('#user_id').val();

    for (var index = 0; index < result.length; index++) {
      var element = result[index];
      var title = element.title;
      var body = element.body;
      var user_id = element.user_id;
      console.log(user_id);
      console.log(my_user);

      if (my_user == user_id) {
        showToastDark(title, body, 'success');
      }
    }
  });
});

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
__webpack_require__(/*! ./components/datatable */ "./resources/js/components/datatable.js");

__webpack_require__(/*! ./components/user/crud */ "./resources/js/components/user/crud.js");

__webpack_require__(/*! ./components/user/datatable_admin */ "./resources/js/components/user/datatable_admin.js");

__webpack_require__(/*! ./components/user/datatable_financiera */ "./resources/js/components/user/datatable_financiera.js");

__webpack_require__(/*! ./components/product/datatable_product */ "./resources/js/components/product/datatable_product.js");

__webpack_require__(/*! ./components/product/crud */ "./resources/js/components/product/crud.js");

__webpack_require__(/*! ./components/agreement/datatable */ "./resources/js/components/agreement/datatable.js");

__webpack_require__(/*! ./components/agreement/crud */ "./resources/js/components/agreement/crud.js");

__webpack_require__(/*! ./components/lead/datatable */ "./resources/js/components/lead/datatable.js");

__webpack_require__(/*! ./components/lead/crud */ "./resources/js/components/lead/crud.js");

__webpack_require__(/*! ./components/toastr */ "./resources/js/components/toastr.js");

__webpack_require__(/*! ./components/crm */ "./resources/js/components/crm.js");

__webpack_require__(/*! ./components/action/datatable */ "./resources/js/components/action/datatable.js");

__webpack_require__(/*! ./components/action/crud */ "./resources/js/components/action/crud.js");

__webpack_require__(/*! ./components/websocket */ "./resources/js/components/websocket.js");
})();

/******/ })()
;