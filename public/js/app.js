/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/components/action/credit.js":
/*!**************************************************!*\
  !*** ./resources/js/components/action/credit.js ***!
  \**************************************************/
/***/ (() => {

window.modalCreditTag = function (credit_id) {
  $('#modal-credit-tag-tag').val(null).trigger('change');
  $('#lead-financial_id').val('').trigger('change');
  $('#modal-credit-credit_id').val(credit_id);
  $('#modal-credit-tag').modal('show');
};

$("#frm-credit-tag").submit(function (event) {
  event.preventDefault();
  var lead_id = $('#modal-tag-lead_id').val();
  var new_form = document.getElementById("frm-credit-tag");
  var data = new FormData(new_form);
  axios.post("/panel/credit/tag/store", data).then(function (response) {
    $('#modal-credit-tag').modal('hide');
    creditRefresh(creditRefresh);
  })["catch"](function (e) {});
});

if (document.getElementById('frm-credit-tag')) {
  getTags();
  getNotes();
}

function getTags() {
  $('#content-tag').html('');
  var credit_id = $('#credit-profile-credit_id').val();
  axios.get("/panel/credit/tag/" + credit_id + "/get-all").then(function (response) {
    var result = response.data;
    $('#content-tag').html(result.tags);
  })["catch"](function (e) {});
}

function getNotes() {
  $('#content-note').html('');
  var credit_id = $('#credit-profile-credit_id').val();
  axios.get("/panel/credit/note/" + credit_id + "/get-all").then(function (response) {
    var result = response.data;
    $('#content-note').html(result.tags);
  })["catch"](function (e) {});
}

window.creditRefresh = function () {
  $('#modal-note').modal('hide');
  getTags();
  getNotes();
};

window.deleteTag = function (tag_id) {
  axios.get("/panel/credit/tag/" + tag_id + "/drop").then(function (response) {
    var result = response.data;
    getTags();
  })["catch"](function (e) {});
};

$(document).ready(function () {
  if (document.getElementById('action-model')) {
    var clearPreviewFiles = function clearPreviewFiles() {
      var model = $('#action-model').val();
      var id_rel = $('#action-id_rel').val();
      return new Promise(function (resolve, reject) {
        var step = $('#step').val();
        axios.get("/panel/files/images/" + model + '/' + id_rel + '/get/config?step=' + step).then(function (response) {
          var result = response.data;
          var config_files = result.config_files;

          for (var key in config_files) {
            if (config_files.hasOwnProperty.call(config_files, key)) {
              var element = config_files[key];
              $('#' + key + '-files-action-preview').html('');
            }
          }

          resolve();
        })["catch"](function (e) {
          reject(e);
        });
      });
    };

    var model = $('#action-model').val();
    var id_rel = $('#action-id_rel').val();
    var step = $('#step').val();
    console.log('model' + model);

    if (model == '') {
      model = null;
    } //*get configuration in template


    if (model == 'controlDesk') {
      $('.myDropzone').each(function () {
        // Obtener el ID del elemento actual
        var key = $(this).attr('id');
        console.log(key);

        if (key) {
          // Crear dinámicamente una instancia de Dropzone
          NioApp.Dropzone('#' + key, {
            url: "/panel/files/images/" + model + '/' + id_rel + '/' + key + '?step=' + step,
            init: function init() {
              this.on("sending", function (file, xhr, formData) {});
              this.on("success", function (file, message) {
                getData();
              });
              this.on("complete", function (file) {
                this.removeAllFiles(true);
              });
            }
          });
        }
      });
    }

    if (model != 'controlDesk') {
      axios.get("/panel/files/images/" + model + '/' + id_rel + '/get/config?step=' + step).then(function (response) {
        var result = response.data;
        var config_files = result.config_files;

        var _loop = function _loop(key) {
          if (config_files.hasOwnProperty.call(config_files, key)) {
            var element = config_files[key]; //create dinamic dropzone element

            NioApp.Dropzone('#' + key + '-dropzone-action', {
              url: "/panel/files/images/" + model + '/' + id_rel + '/' + key,
              init: function init() {
                this.on("sending", function (file, xhr, formData) {
                  var date_file = null;

                  if (document.getElementById(key + '-date_file')) {
                    date_file = $('#' + key + '-date_file').val();
                  }

                  formData.append("date_file", date_file);
                });
                this.on("success", function (file, message) {
                  getData();
                });
                this.on("complete", function (file) {
                  this.removeAllFiles(true);
                });
              }
            });
          }
        };

        for (var key in config_files) {
          _loop(key);
        } //

      })["catch"](function (e) {});
    }

    window.deleteFileTemplate = function (model, id) {
      $('#frm-register-action-preview').html('');
      axios.get("/panel/temp/images/" + id + "/delete").then(function (response) {
        getData();
        showToast('Archivos', 'Archivo borrado', 'success');
      })["catch"](function (e) {});
    }; //* get data saved 


    window.getData = function () {
      var model = $('#action-model').val();
      var id_rel = $('#action-id_rel').val();
      clearPreviewFiles().then(function () {
        var step = $('#step').val();
        axios.get("/panel/files/template/" + model + "/" + id_rel + "/show?step=" + step).then(function (response) {
          var result = response.data;
          var files = result.files;
          var file_dates = result.file_date;

          for (var key in file_dates) {
            if (file_dates.hasOwnProperty.call(file_dates, key)) {
              var element_date_file = file_dates[key]; //console.log(element_date_file.template_config_id);

              $('#' + element_date_file.template_config_id + '-date_file').val(element_date_file.date_file);
            }
          }

          for (var key_file in files) {
            if (files.hasOwnProperty.call(files, key_file)) {
              var element_file = files[key_file];
              $('#' + element_file.template_config_id + '-files-action-preview').append(element_file.preview);
            }
          }
        })["catch"](function (e) {
          console.error(e);
        });
      })["catch"](function (e) {
        console.error(e);
      });
    };
  }

  $().ready(function () {
    getData();
    $("#frm-action-files").validate({
      rules: {
        'date_file[]': {
          required: true
        }
      },
      submitHandler: function submitHandler(form, event) {
        event.preventDefault();
        var new_form = document.getElementById("frm-action-files");
        var data = new FormData(new_form); // Extract the step value from the URL

        var urlParams = new URLSearchParams(window.location.search);
        var step = urlParams.get('step'); // Add the step value to the FormData

        data.append('step', step);
        axios.post("/panel/files/template/date", data).then(function (response) {
          var result = response.data;
          var url_redirect = null;
          url_redirect = $('#url_redirect').val();
          window.location = url_redirect;
        })["catch"](function (e) {});
      }
    });
  });

  if (document.getElementById('pruebaDropZone')) {
    var _model = 'prueba';
    var _id_rel = 1;
    var key = 1;
    NioApp.Dropzone('#pruebaDropZone', {
      url: "/panel/files/images/" + _model + '/' + _id_rel + '/' + key,
      init: function init() {
        this.on("sending", function (file, xhr, formData) {});
        this.on("success", function (file, message) {});
        this.on("complete", function (file) {});
      }
    });
  }
});

/***/ }),

/***/ "./resources/js/components/action/crud.js":
/*!************************************************!*\
  !*** ./resources/js/components/action/crud.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");


window.actionModal = function (id, is_new, is_lead) {
  var model = is_lead == true ? 'lead' : 'credit';
  var section = is_lead == true ? 1 : 2;
  resetAction();
  getAdvisorLead(model, id);
  $('#modal-action-id-rel').val(id);
  $('#modal-action-id-section').val(section);

  if (is_new == 'true') {
    $('#modal-action-id-action').val(null);
  }

  $('#modal-action').modal('show');
};

window.addActionIntoActions = function (id, is_new, is_lead) {
  $('#modal-list-actions').modal('hide');
  var model = is_lead == true ? 'lead' : 'credit';
  var section = is_lead == true ? 1 : 2;
  resetAction();
  getAdvisorLead(model, id);
  $('#modal-action-id-rel').val(id);
  $('#modal-action-id-section').val(section);

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

function getAdvisorLead(model, id_rel) {
  axios.get("/panel/" + model + "/" + id_rel + '/advisor/show').then(function (response) {
    var result = response.data;
    var advisor = result.advisor;

    if (advisor != null) {
      var name_advisor = advisor.name + ' ' + advisor.last_name;
      $("#lead-asesor-id").prepend("<option value='" + advisor.id + "' selected='selected'> " + name_advisor + "</option>");
      $("#lead-asesor-id").prop("disabled", true);
    }
  })["catch"](function (e) {});
}
/* function getPerson(lead_id) {
    axios
        .get("/panel/lead/" + lead_id)
        .then(function (response) {
            let result = response.data;
            let lead = result.lead;
            let lead_name = lead.name + ' ' + lead.last_name;
            $("#modal-action-id-rel-lead").prepend("<option value='" + lead.id + "' selected='selected'> " + lead_name + "</option>");
        })
        .catch(e => {

        });
} */


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
      },
      'data[start_time]': {
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

          if (document.getElementById('is_refresh')) {
            location.reload(); // Recargar la página
          }

          if (refresh_dt != 'null') {
            (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, refresh_dt, 'Datos actualizados', 'Registro guardado');
          } else {
            refreshListActions();
          }
        } //refreshListActions();

      })["catch"](function (e) {});
    }
  });
});

function resetAction() {
  $('#frm-action input, textarea, select').removeAttr('disabled');
  $('#modal-action-save').show();
  $("#modal-action-type").val('').trigger('change');
  $('#modal-action-subject').val('');
  $('#modal-action-start_date').val('');
  $('#modal-action-end_date').val('');
  $('#modal-action-description').val('');
  $('#modal-action-id-action').val('null');
  $('#modal-action-complete-pending').prop("checked", true);
  $("#lead-asesor-id").val('').trigger('change');
  $("#lead-asesor-id").prop("disabled", false);
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
          /* showInfo(2, refresh_dt, 'Datos actualizados', 'Registro guardado');
          refreshListActions(); */
          location.reload();
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
      refreshListActions();
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
    if (document.getElementById('modal-list-actions')) {
      location.reload(); // Recargar la página
    }

    if (refresh_dt != 'null') {
      (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, refresh_dt, 'Datos actualizados', 'Registro guardado');
    } else {
      refreshListActions();
    }
  })["catch"](function (e) {});
};
/* window.editModalAction = function(action_id, disabled) {
    setModalAction(action_id, disabled);
    $('#modal-action').modal('show');
} */


window.setModalAction = function (action_id, disabled, section) {
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
      var lead_name = lead != null ? lead.name + ' ' + lead.last_name : null;
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
      $('#modal-action').modal('show');
      $('#lead-asesor-id').val(action.advisor_id).trigger("change");

      if (action.status == 1) {
        $('#modal-action-complete-active').prop("checked", true);
        $('#modal-action-complete-pending').prop("checked", false);
      } else {
        $('#modal-action-complete-active').prop("checked", false);
        $('#modal-action-complete-pending').prop("checked", true);
      }

      $('#modal-action').modal('show');
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
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/action/' + status + '/dt/show',
    columns: [{
      data: 'type'
    }, {
      data: 'subject'
    },
    /* { data: 'section' }, */
    {
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
document.addEventListener('DOMContentLoaded', function () {
  var status = $('#dt-action-status').val();
  var model = $('#model').val();
  var table = NioApp.DataTable('#dt-actions', {
    processing: true,
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/action/' + status + '/' + model + '/dt/show',
    columns: [{
      data: 'type'
    },
    /* { data: 'section' }, */
    {
      data: 'name'
    }, {
      data: 'date_in'
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

/***/ "./resources/js/components/action/datatablemodule.js":
/*!***********************************************************!*\
  !*** ./resources/js/components/action/datatablemodule.js ***!
  \***********************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var name_status = $('#name_status').val();
  var table = NioApp.DataTable('#dt-acctions-module', {
    processing: true,
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/action/module/' + name_status + '/list',
    columns: [{
      data: 'action'
    }, {
      data: 'subject'
    }, {
      data: 'module'
    }, {
      data: 'name'
    }, {
      data: 'deadline'
    }, {
      data: 'advisor'
    }, {
      data: 'responsable'
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

  if (document.getElementById('frm-agreement') && $('#agreement_id').val() != 'null') {
    var agreement_id = $('#agreement_id').val();
    axios.get("/panel/agreement/" + agreement_id).then(function (response) {
      var result = response.data;
      var agreement = result.agreement;
      var financials = result.financials;
      $('#agreement-name').val(agreement.name);
      $('#agreement-description').val(agreement.description);
      $('#agreement_term').val(agreement.agreement_term); // Limpia las selecciones actuales en el select múltiple

      $('#agreement-financials').val(null).trigger('change');
      $('#agreement-status').val(agreement.status).trigger("change"); // Itera sobre periodicities y selecciona las opciones en product_periodicity_id

      var financialValues = financials.map(function (item) {
        return item.id;
      }); // Seleccionar los valores correspondientes en los selects

      $('#agreement-financials').val(financialValues).trigger('change'); //$('#agreement-status option[value="' + agreement.status + '"]').trigger("change");
    })["catch"](function (e) {
      $('#admin_email-error-exist').show();
    });
  }

  function getProductComision(product_id) {
    $('#content-costo-contratacion').html('');
    $('#comisiones').html('');
    axios.get("/panel/product-fee/" + product_id).then(function (response) {
      var result = response.data;
      $('#content-costo-contratacion').html(result.costoContratacion);
      $('#comisiones').html(result.comisiones);
    })["catch"](function (e) {
      $('#admin_email-error-exist').show();
    });
  }

  window.editProductFee = function (productFee, product_id, type) {
    $('#frm-product-fees')[0].reset();
    $('#product_fee').val(productFee);
    $('#financial_product_id').val(product_id);
    $('#comision_type').val(type);
    axios.get("/panel/product-fee/" + productFee + '/showproductFee').then(function (response) {
      var result = response.data;

      if (result != null) {
        $('#concepto').val(result.concepto);
        $('#periodicidad').val(result.periodicidad);
        $('#moneda').val(result.moneda);

        if (result.is_valor_fijo == 1) {
          $('#type_active').prop('checked', true).click();
        } else {
          $('#type_pending').prop('checked', true).click();
        }

        $('#valor').val(result.valor);
        $('#porcentaje').val(result.porcentaje);
        $('#referencia').val(result.referencia);
        $('#modal-product-fees').modal('show');
      }
    })["catch"](function (e) {});
  };
  /* borrar comisiones */


  window.deleteProductFee = function (product_fee_id) {
    var product_id = $('#product_id').val();
    Swal.fire({
      title: '¿Estás seguro?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, elimina',
      cancelButtonText: 'Mejor no'
    }).then(function (result) {
      if (result.value) {
        axios["delete"]("/panel/product-fee/" + product_fee_id).then(function (response) {
          getProductComision(product_id);
        })["catch"](function (e) {});
      }
    });
  };
  /* borrar comisiones */


  if (document.getElementById('financial_product_id')) {
    var product_id = $('#product_id').val();
    getProductComision(product_id);
  }

  $("#frm-product-fees").validate({
    rules: {
      'data[concepto]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var product_id = $('#financial_product_id').val();
      var new_form = document.getElementById("frm-product-fees");
      var data = new FormData(new_form);
      axios.post("/panel/product-fee", data).then(function (response) {
        getProductComision(product_id);
        $('#modal-product-fees').modal('hide');
        new_form.reset();
      })["catch"](function (e) {});
    }
  }); //modal productfee

  window.modalProductComision = function (product_fee, product_id, type) {
    $('#product_fee').val(product_fee);
    $('#financial_product_id').val(product_id);
    $('#comision_type').val(type);
    $('#modal-product-fees').modal('show');
  };

  window.showValorFijo = function (show_fijo) {
    $('#content-valor-fijo').hide();
    $('#content-no-valor-fijo').hide();

    if (show_fijo) {
      $('#content-valor-fijo').show();
    } else {
      $('#content-no-valor-fijo').show();
    }
  };
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
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
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

/***/ "./resources/js/components/clients/crud.js":
/*!*************************************************!*\
  !*** ./resources/js/components/clients/crud.js ***!
  \*************************************************/
/***/ (() => {

$().ready(function () {
  $("#frm-client").validate({
    rules: {
      'data[name]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var new_form = document.getElementById("frm-client");
      var data = new FormData(new_form);
      axios.post("/panel/clients", data).then(function (response) {
        window.location = '/panel/clients';
      })["catch"](function (e) {});
    }
  });

  function setData() {
    var client_id = $('#client_id').val();

    if (client_id != '') {
      console.log(client_id);
      axios.get("/panel/clients/" + client_id).then(function (response) {
        var result = response.data;
        var client = result.client;
        $('#client-name').val(client.name);
        $('#client-last_name').val(client.last_name);
        $('#client-second_last_name').val(client.second_last_name);
        $('#client-cellphone').val(client.cellphone);
        $('#client-email').val(client.email);
        $('#client-rfc').val(client.rfc);
        $('#lead-email').val(client.email);
        $('#client-daily_income').val(client.daily_income);
        $('#client-agreement').val(client.agreement_id).trigger("change");
        var clientStatusElement = document.getElementById("client-status");

        if (client.active == 1 && clientStatusElement) {
          clientStatusElement.click();
        }

        $('#client-status').val(client.active);
      })["catch"](function (e) {
        $('#admin_email-error-exist').show();
      });
    }
  }

  if (document.getElementById('client_id')) {
    setData();
  }
});

/***/ }),

/***/ "./resources/js/components/clients/datatable.js":
/*!******************************************************!*\
  !*** ./resources/js/components/clients/datatable.js ***!
  \******************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var route = $('#route_datatable').val();
  var module_id = null;

  if (document.getElementById('module_id')) {
    module_id = $('#module_id').val();
  }

  var table_lead = NioApp.DataTable('#dt-clients', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/clients/list/show',
    columns: [{
      data: 'id'
    }, {
      data: 'name'
    }, {
      data: 'agreement'
    }, {
      data: 'cellphone'
    },
    /* { data: 'organizacion' }, */
    {
      data: 'rfc'
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
  }); // Expand table rows on click

  $('#dt-clients tbody').on('click', 'td', function () {
    var row = table_lead.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});

/***/ }),

/***/ "./resources/js/components/clients/datatable_colaboradores.js":
/*!********************************************************************!*\
  !*** ./resources/js/components/clients/datatable_colaboradores.js ***!
  \********************************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var table_lead = NioApp.DataTable('#dt-colaboradores', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/clients/list/ListColaboradores',
    columns: [{
      data: 'id'
    }, {
      data: 'name'
    }, {
      data: 'agreement'
    }, {
      data: 'cellphone'
    },
    /* { data: 'organizacion' }, */
    {
      data: 'rfc'
    }, {
      data: 'estatus'
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
  }); // Expand table rows on click

  $('#dt-colaboradores tbody').on('click', 'td', function () {
    var row = table_lead.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});

/***/ }),

/***/ "./resources/js/components/credit/datatable_in_progress.js":
/*!*****************************************************************!*\
  !*** ./resources/js/components/credit/datatable_in_progress.js ***!
  \*****************************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var status = $('#status').val();
  var table = NioApp.DataTable('#dt-in_progress', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/credit/product/' + status + '/list',
    columns: [{
      data: 'id'
    }, {
      data: 'product'
    }, {
      data: 'module'
    }, {
      data: 'client'
    }, {
      data: 'advisor'
    }, {
      data: 'progress'
    }, {
      data: 'deadline'
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
  }); // Expand table rows on click

  $('#dt-in_progress tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});

/***/ }),

/***/ "./resources/js/components/credit/product/datatable.js":
/*!*************************************************************!*\
  !*** ./resources/js/components/credit/product/datatable.js ***!
  \*************************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var status = $('#status').val();
  var table = NioApp.DataTable('#dt-product-credit', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/credit/product/' + status + '/list',
    columns: [{
      data: 'id'
    }, {
      data: 'product'
    }, {
      data: 'reason'
    }, {
      data: 'date'
    }, {
      data: 'client'
    }, {
      data: 'advisor'
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
  }); // Expand table rows on click

  $('#dt-product-credit tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});

/***/ }),

/***/ "./resources/js/components/credit/profile/datatable.js":
/*!*************************************************************!*\
  !*** ./resources/js/components/credit/profile/datatable.js ***!
  \*************************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var credit_id = $('#credit-profile-credit_id').val();
  var table = NioApp.DataTable('#dt-acctions-profile', {
    processing: true,
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/credit/action/' + credit_id + '/list',
    columns: [{
      data: 'action'
    }, {
      data: 'subject'
    }, {
      data: 'module'
    }, {
      data: 'deadline'
    }, {
      data: 'status',
      orderData: 'desc'
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

/***/ "./resources/js/components/crm.js":
/*!****************************************!*\
  !*** ./resources/js/components/crm.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utilities */ "./resources/js/components/utilities.js");


function move(id, form, modal, datatable, title, msg) {
  var new_form = document.getElementById(form);
  var data = new FormData(new_form);
  var statusid = $('#statusid').val();
  var old_status_id = $('#old_status_id').val();
  axios.post("/panel/action/" + id + "/" + statusid + "/" + old_status_id + "/move", data).then(function (response) {
    $('#' + modal).modal('hide');
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, datatable, title, msg);
  })["catch"](function (e) {});
}

window.moveCrm = function (creditId, statusid, old_status_id, redirect) {
  axios.post("/panel/action/" + creditId + "/" + statusid + "/" + old_status_id + "/move").then(function (response) {
    window.location = redirect;
  })["catch"](function (e) {});
};

window.deliveryFinish = function (id, statusid, urlredirect, is_modal) {
  if (is_modal == true) {
    Swal.fire({
      title: '¿Estás seguro?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí',
      cancelButtonText: 'Mejor no'
    }).then(function (result) {
      if (result.value) {
        actionDeliveryFinish(id, statusid, urlredirect);
      }
    });
  } else {
    actionDeliveryFinish(id, statusid, urlredirect);
  }
};

function actionDeliveryFinish(id, statusid, urlredirect) {
  axios.get("/panel/action/" + id + "/" + statusid + "/finish").then(function (response) {
    window.location = urlredirect;
  })["catch"](function (e) {});
}

window.moveModal = function (title, id, statusid, old_status_id, dt) {
  $('#frm-archive').trigger("reset");
  $('#modal_archive_id_rel').val(id);
  $('#statusid').val(statusid);
  $('#title').val('Crédito');
  $('#old_status_id').val(old_status_id);
  $('#dt').val(dt);
  $('#modal-archive-title').html(title);
  getReason(title);

  if (title == 'Archivar' || title == 'Cancelar') {
    $('#content-lead').show();
  }

  $('#modal-archive').modal('show');
};

window.moveModalLead = function (title, id, statusid, old_status_id, dt) {
  $('#frm-archive').trigger("reset");
  $('#modal_archive_id_rel').val(id);
  $('#statusid').val(statusid);
  $('#title').val('Prospecto');
  $('#old_status_id').val(old_status_id);
  $('#dt').val(dt);
  $('#modal-archive-title').html(title);
  getReason('ArchivarLead');
  $('#content-lead').show();
  $('#modal-archive').modal('show');
};

if (document.getElementById('frm-archive')) {
  NioApp.Select2('#modal-reason-id', {
    dropdownParent: $('#modal-archive')
  });
}

window.concluir = function (history_id) {
  axios.get('/panel/action/' + history_id + '/complete').then(function (response) {
    var result = response.data;
    window.location = result.url;
  })["catch"](function (e) {});
};

$("#frm-archive").submit(function (event) {
  event.preventDefault();
  var id_rel = $('#modal_archive_id_rel').val();
  var dt = $('#dt').val();
  var msg = 'Cambios aplicados correctamente';
  var title = $('#title').val();
  move(id_rel, 'frm-archive', 'modal-archive', dt, title, msg);
});

window.modalValidate = function (id, model) {
  $('#modal-validate-content').html('');
  axios.get('/panel/' + id + '/' + model + '/validate/show').then(function (response) {
    var result = response.data;
    $('#modal-validate-content').html(result);
    $('#modal-validate').modal('show');
  })["catch"](function (e) {});
};

window.desition = function (history_id, credit_id, financial_id, type, status_id, is_elegir) {
  var url_redirect = type == 1 ? '/panel/kc-check-up' : '/panel/kc-swap';
  var param_get = is_elegir == 0 ? '?is_notify=true' : '?is_notify=false';
  Swal.fire({
    title: '¿Estás seguro?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí',
    cancelButtonText: 'Mejor no'
  }).then(function (result) {
    if (result.value) {
      axios.get("/panel/kc-check-up/report/desition/" + credit_id + "/" + financial_id + "/" + type + "/accept" + param_get).then(function (response) {
        var reason = response.data;

        if (is_elegir == 0) {
          deliveryFinish(history_id, status_id, url_redirect, false);
        } else {
          window.location = url_redirect;
        }
      })["catch"](function (e) {});
    }
  });
};

function getReason(type) {
  $('#modal-reason-id').empty();
  axios.get("/panel/reason/" + type + "/list").then(function (response) {
    var reason = response.data;
    var modal_reason_id = $('#modal-reason-id');

    for (var key in reason) {
      var element = reason[key];
      var option = new Option(element, key, true, true);
      modal_reason_id.append(option).trigger('change');
    }

    $('#modal-reason-id').val('').trigger('change');

    if (financials != null) {}
  })["catch"](function (e) {});
}

$(document).ready(function () {
  var pathArray = window.location;
  var params = new URLSearchParams(pathArray.search);
  var param_cancel = params.get("swap_cancel");

  if (param_cancel != null) {
    moveModal('Cancelar', param_cancel, 17, 37, 'dt-product-credit');
  }
});

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

/***/ "./resources/js/components/financial/crud.js":
/*!***************************************************!*\
  !*** ./resources/js/components/financial/crud.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");

$().ready(function () {
  $("#frm-financial").validate({
    rules: {
      'commercial_name': {
        required: true
      },
      'company_name': {
        required: true
      },
      'email': {
        email: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      $('#financial-commercial_name-unique-error').html('');
      $('#financial-commercial_name-unique-error').hide();
      var new_form = document.getElementById("frm-financial");
      var data = new FormData(new_form);
      axios.post("/panel/financial", data).then(function (response) {
        var result = response.data;
        window.location = '/panel/financial/' + result.id + '/edit?tab=privacidad_de_datos';
      })["catch"](function (e) {
        var response = e.response;
        var data_errors = response.data.errors;
        $('#financial-commercial_name-unique-error').html('Este campo ya se encuentra registrado.');
        $('#financial-commercial_name-unique-error').show();
      });
    }
  });
});
$("#frm-financial-data-pricacy").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById("frm-financial-data-pricacy");
  var data = new FormData(new_form);
  axios.post("/panel/financial", data).then(function (response) {
    var result = response.data;
    showToast('Financiera', 'Datos guardados', 'success');
  })["catch"](function (e) {});
});
$("#frm-financial-buro").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById("frm-financial-buro");
  var data = new FormData(new_form);
  axios.post("/panel/financial", data).then(function (response) {
    var result = response.data;
    showToast('Financiera', 'Datos guardados', 'success');
  })["catch"](function (e) {});
});

if (document.getElementById('alcance_beneficios')) {
  refreshListComplementary();
}

function refreshListComplementary() {
  var product_id = $('#product_id').val();
  axios.get("/panel/product-complementary/list/" + product_id + "/refresh").then(function (response) {
    var result = response.data; // Asignar valores al select de alcance_beneficios

    var alcanceSelect = document.getElementById('alcance_beneficios');
    alcanceSelect.innerHTML = ''; // Limpia el select actual

    result.complementary_alcance.forEach(function (alcance) {
      var option = document.createElement('option');
      option.value = alcance.description;
      option.text = alcance.description;
      alcanceSelect.appendChild(option);
    });
    var alcanceBeneficiosArray = result.my_product.alcance_beneficios.split(',');
    $('#alcance_beneficios').val(alcanceBeneficiosArray).trigger('change'); // Repite el mismo proceso para los otros selects (restriccion_exclusion, programa_educacion_financiera, referencia_comparativa)
    // Asignar valores al select de restriccion_exclusion

    var restriccionSelect = document.getElementById('restriccion_exclusion');
    restriccionSelect.innerHTML = '';
    result.complementary_restricciones.forEach(function (restriccion) {
      var option = document.createElement('option');
      option.value = restriccion.description;
      option.text = restriccion.description;
      restriccionSelect.appendChild(option);
    });
    var alcanceRestriccionArray = result.my_product.restriccion_exclusion.split(',');
    $('#restriccion_exclusion').val(alcanceRestriccionArray).trigger('change'); // Asignar valores al select de programa_educacion_financiera

    var programaSelect = document.getElementById('programa_educacion_financiera');
    programaSelect.innerHTML = '';
    result.complementary_programas.forEach(function (programa) {
      var option = document.createElement('option');
      option.value = programa.description;
      option.text = programa.description;
      programaSelect.appendChild(option);
    });
    var alcanceProgramaArray = result.my_product.programa_educacion_financiera.split(',');
    $('#programa_educacion_financiera').val(alcanceProgramaArray).trigger('change'); // Asignar valores al select de referencia_comparativa

    var referenciaSelect = document.getElementById('referencia_comparativa');
    referenciaSelect.innerHTML = '';
    result.complementary_referencias.forEach(function (referencia) {
      var option = document.createElement('option');
      option.value = referencia.description;
      option.text = referencia.description;
      referenciaSelect.appendChild(option);
    });
    var ReferenciaArray = result.my_product.referencia_comparativa.split(',');
    $('#referencia_comparativa').val(ReferenciaArray).trigger('change');
    var bankIdsArray = result.my_product.bank_ids.split(',');
    $('#bank_ids').val(bankIdsArray).trigger('change');
  })["catch"](function (e) {});
}
/*  alcance_beneficios
restriccion_exclusion
programa_educacion_financiera
referencia_comparativa */


window.modalComplementary = function (type) {
  // Definir un arreglo con los títulos correspondientes a cada tipo
  var titles = ['ALCANCE O BENEFICIOS', 'RESTRICCIONES O EXCLUSIONES', 'PROGRAMAS DE EDUCACIÓN FINANCIERA', 'REFERENCIAS CORPORATIVAS'];
  var product_id = $('#product_id').val(); // Verificar que el tipo esté dentro del rango válido

  if (type >= 1 && type <= titles.length) {
    // Asignar el valor del título al elemento con ID 'title-complementary'
    document.getElementById('title-complementary').textContent = titles[type - 1];
    $('#type-complementary-service').val(type);
    $('#product-complementary-service').val(product_id);
    showContentComplementary();
  } else {
    // Tratamiento para tipos fuera del rango válido
    document.getElementById('title-complementary').textContent = 'Título no válido';
  }

  $('#modal-complementary').modal('show');
};

$("#frm-complementary").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById("frm-complementary");
  var data = new FormData(new_form);
  axios.post("/panel/product-complementary", data).then(function (response) {
    // Resetea el formulario
    $('#product-complementary-description').val('');
    $('#product-complementary-id').val('');
    refreshListComplementary();
    showContentComplementary();
  })["catch"](function (e) {});
});

function showContentComplementary() {
  var product_id = $('#product_id').val();
  var type = $('#type-complementary-service').val();
  axios.get("/panel/product-complementary/" + product_id + '/' + type).then(function (response) {
    var result = response.data;
    $('#content-complementary').html(result);
  })["catch"](function (e) {});
}

window.deleteComplementary = function (complementary_id) {
  Swal.fire({
    title: '¿Estás seguro?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, elimina',
    cancelButtonText: 'Mejor no'
  }).then(function (result) {
    if (result.value) {
      axios["delete"]("/panel/product-complementary/" + complementary_id).then(function (response) {
        showContentComplementary();
      })["catch"](function (e) {});
    }
  });
};

window.editComplementary = function (complementary_id, description) {
  $('#product-complementary-description').val(description);
  $('#product-complementary-id').val(complementary_id);
  var type = $('#type-complementary-service').val();
  modalComplementary(type);
};

$("#frm-financial-billing").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById("frm-financial-billing");
  var data = new FormData(new_form);
  axios.post("/panel/financial", data).then(function (response) {
    var result = response.data;
    showToast('Financiera', 'Datos guardados', 'success');
  })["catch"](function (e) {});
});

window.deleteFinancial = function (id) {
  axios["delete"]("/panel/financial/" + id).then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-financial', 'Datos actualizados', 'Registro borrado');
  })["catch"](function (e) {});
};

window.alerFinancialDelete = function (id) {
  Swal.fire({
    title: '¿Estás seguro?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, elimina',
    cancelButtonText: 'Mejor no'
  }).then(function (result) {
    if (result.value) {
      deleteFinancial(id);
    }
  });
};

/***/ }),

/***/ "./resources/js/components/financial/datatable.js":
/*!********************************************************!*\
  !*** ./resources/js/components/financial/datatable.js ***!
  \********************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-financial', {
    processing: true,
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/financial/list/show',
    columns: [{
      data: 'commercial_name'
    }, {
      data: 'company_name'
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

/***/ "./resources/js/components/financial/product/crud.js":
/*!***********************************************************!*\
  !*** ./resources/js/components/financial/product/crud.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../utilities */ "./resources/js/components/utilities.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return generator._invoke = function (innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; }(innerFn, self, context), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; this._invoke = function (method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, "throw" === context.method) { if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel; context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (object) { var keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }


var isLoaded = false;
$().ready(function () {
  $("#frm-product-info").validate({
    rules: {
      'name': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      $('#product-name-unique-error').html('');
      $('#product-name-unique-error').hide();
      var new_form = document.getElementById("frm-product-info");
      var data = new FormData(new_form);
      axios.post("/panel/financial-product", data).then(function (response) {
        var result = response.data; //window.location = '/panel/financial/'+result.id+'/edit';

        window.history.back();
      })["catch"](function (e) {
        var response = e.response;
        var data_errors = response.data.errors;
        $('#product-name-unique-error').html('Este campo ya se encuentra registrado.');
        $('#product-name-unique-error').show();
      });
    }
  });

  if (document.getElementById('frm-product-info') && $('#product_id').val() != 'null') {
    var product_id = $('#product_id').val(); // Limpia las selecciones actuales en los selects

    $('#product_periodicity_id').val(null).trigger('change');
    $('#product-principal_pay').val(null).trigger('change');
    axios.get("/panel/financial-product/" + product_id + '/getPeriodicityAndPaymentMethod').then( /*#__PURE__*/function () {
      var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(response) {
        var result, periodicities, payments, periodicityValues, paymentValues;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                // Usa async/await aquí
                result = response.data;
                periodicities = result.periodicities;
                payments = result.payments; // Itera sobre periodicities y selecciona las opciones en product_periodicity_id

                periodicityValues = periodicities.map(function (item) {
                  return item.periodicity_id;
                });
                paymentValues = payments.map(function (item) {
                  return item.payment_method_id;
                }); // Seleccionar los valores correspondientes en los selects

                $('#product_periodicity_id').val(periodicityValues).trigger('change');
                $('#product-principal_pay').val(paymentValues).trigger('change');

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }));

      return function (_x) {
        return _ref.apply(this, arguments);
      };
    }())["catch"](function (e) {
      console.error(e);
    });
  }
});
var previouslyLoadedTerms = []; // Almacena los términos previamente cargados

window.setFPTerms = function () {
  var product_id = $('#product_id').val();
  $('#fp_terms').val(null).trigger('change'); // Realiza la solicitud AJAX para obtener los términos

  var periodicityId = $('#product_periodicity_id').val();
  var select = document.getElementById("fp_terms"); // Limpia el select antes de agregar opciones

  select.innerHTML = ""; // Realiza la solicitud AJAX para obtener los términos

  return axios.get("/panel/financial-product/" + periodicityId + '/' + product_id + '/terms/get').then(function (response) {
    var result = response.data;
    var terms = result.terms;
    var getTerms = result.getTerms; // Llena el select con las opciones de terms

    terms.forEach(function (term) {
      var option = document.createElement("option");
      option.value = term.id; // El valor será el id

      option.text = term.term; // El texto será el term

      select.appendChild(option);
    }); // Si se pasaron términos seleccionados, se seleccionan aquí

    if (getTerms != null) {
      var termValues = getTerms.map(function (item) {
        return item.id;
      });
      $('#fp_terms').val(termValues).trigger('change');
    }
  })["catch"](function (e) {
    console.error(e);
  });
};

$("#frm-financial-buro").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById("frm-financial-buro");
  var data = new FormData(new_form);
  axios.post("/panel/financial-product", data).then(function (response) {
    var result = response.data;
    showToast('Producto', 'Datos guardados', 'success');
  })["catch"](function (e) {});
});

window.showBank = function (is_show) {
  $('#content-bank').hide();

  if (is_show == true) {
    $('#content-bank').show();
  }
};

$("#frm-financial-comision").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById("frm-financial-comision");
  var data = new FormData(new_form);
  axios.post("/panel/financial-product", data).then(function (response) {
    var result = response.data;
    showToast('Producto', 'Datos guardados', 'success');
  })["catch"](function (e) {});
});
$("#frm-financial-contact").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById("frm-financial-contact");
  var data = new FormData(new_form);
  axios.post("/panel/financial-product", data).then(function (response) {
    var result = response.data;
    showToast('Producto', 'Datos guardados', 'success');
  })["catch"](function (e) {});
});
$("#frm-financial-requisitos").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById("frm-financial-requisitos");
  var data = new FormData(new_form);
  axios.post("/panel/financial-product", data).then(function (response) {
    var result = response.data;
    showToast('Financiera', 'Datos guardados', 'success');
  })["catch"](function (e) {});
});
$("#frm-financial-rate").submit(function (event) {
  event.preventDefault(); // Obtener los valores de los campos, si se ingresaron

  var rate_kc = $("#rate_kc").val() !== '' ? parseFloat($("#rate_kc").val()) : null;
  var rate_cat = $("#rate_cat").val() !== '' ? parseFloat($("#rate_cat").val()) : null;
  var rate_comision = $("#rate_comision").val() !== '' ? parseFloat($("#rate_comision").val()) : null;
  var rate_deadline = $("#rate_deadline").val() !== '' ? parseFloat($("#rate_deadline").val()) : null;
  var rate_contract = $("#rate_contract").val() !== '' ? parseFloat($("#rate_contract").val()) : null;
  var rate_privacity = $("#rate_privacity").val() !== '' ? parseFloat($("#rate_privacity").val()) : null; // Función para validar que un valor esté dentro del rango de 0 a 5

  function isValidValue(value) {
    return value === null || !isNaN(value) && value >= 0 && value <= 5;
  } // Validar que los valores estén dentro del rango permitido


  if (!isValidValue(rate_kc) || !isValidValue(rate_cat) || !isValidValue(rate_comision) || !isValidValue(rate_deadline) || !isValidValue(rate_contract) || !isValidValue(rate_privacity)) {
    Swal.fire({
      title: 'Por favor, ingrese valores numéricos entre 0 y 5',
      icon: 'warning',
      showCancelButton: true
    });
  } else {
    var new_form = document.getElementById("frm-financial-rate");
    var data = new FormData(new_form);
    axios.post("/panel/financial-product", data).then(function (response) {
      var result = response.data;
      showToast('Producto', 'Datos guardados', 'success');
    })["catch"](function (e) {// Manejar errores si es necesario
    });
  }
});
$("#frm-financial-chart").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById("frm-financial-chart");
  var data = new FormData(new_form);
  axios.post("/panel/financial-product", data).then(function (response) {
    var result = response.data;
    showToast('Producto', 'Datos guardados', 'success');
  })["catch"](function (e) {});
});

if (document.getElementById('tramite-proceso_tramite')) {
  var ckeditor = CKEDITOR.replace('tramite-proceso_tramite', {
    toolbar: [{
      name: 'basicstyles',
      items: ['Bold', 'Italic', 'Font', 'FontSize', 'TextColor', 'BGColor', 'RemoveFormat']
    }, {
      name: 'paragraph',
      items: ['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
    }, {
      name: 'insert',
      items: ['Table']
    }],
    language: 'es-mx'
  }); //*axios que devuelva el valor proceso_tramite

  var product_id = $('#product_id').val();
  setTimeout(function () {
    axios.get("/panel/financial-product/" + product_id + "/getTramite").then(function (response) {
      var result = response.data;
      CKEDITOR.instances['tramite-proceso_tramite'].setData(result.proceso_tramite);
    })["catch"](function (e) {// Manejar errores aquí
    });
  }, 2000); // 2000 milisegundos = 2 segundos
}

$("#frm-financial-tramite").submit(function (event) {
  event.preventDefault();
  var desc = CKEDITOR.instances['tramite-proceso_tramite'].getData();
  $('#tramite-proceso_tramite').val(desc);
  var new_form = document.getElementById("frm-financial-tramite");
  var data = new FormData(new_form);
  axios.post("/panel/financial-product", data).then(function (response) {
    var result = response.data;
    showToast('Producto', 'Datos guardados', 'success');
  })["catch"](function (e) {});
});
$("#frm-comisioneskc").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById("frm-comisioneskc");
  var data = new FormData(new_form);
  axios.post("/panel/financial-product", data).then(function (response) {
    var result = response.data;
    showToast('Producto', 'Datos guardados', 'success');
  })["catch"](function (e) {});
});

window.deleteFinancialProduct = function (id) {
  axios["delete"]("/panel/financial-product/" + id).then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-financial-product', 'Producto', 'Registro borrado');
  })["catch"](function (e) {});
};

window.alerDeleteFinancialProduct = function (id) {
  Swal.fire({
    title: '¿Estás seguro?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, elimina',
    cancelButtonText: 'Mejor no'
  }).then(function (result) {
    if (result.value) {
      deleteFinancialProduct(id);
    }
  });
};

/***/ }),

/***/ "./resources/js/components/financial/product/datatable.js":
/*!****************************************************************!*\
  !*** ./resources/js/components/financial/product/datatable.js ***!
  \****************************************************************/
/***/ (() => {

/* DT PRODUCT */
if (document.getElementById('dt-financial-product')) {
  var financial_id = $('#financial_id').val();

  if (financial_id != '') {
    document.addEventListener('DOMContentLoaded', function () {
      var table = NioApp.DataTable('#dt-financial-product', {
        processing: true,
        responsive: {
          details: {
            renderer: function renderer(api, rowIdx, columns) {
              var total = columns.length - 1;
              var data = $.map(columns, function (col, i) {
                if (total == i) {
                  return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
                } else {
                  return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
                }
              }).join('');
              return data ? $('<table/>').append(data) : false;
            }
          }
        },
        ajax: '/panel/financial/product/' + financial_id + '/list/show',
        columns: [{
          data: 'id'
        }, {
          data: 'name'
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
  }
}

/***/ }),

/***/ "./resources/js/components/general.js":
/*!********************************************!*\
  !*** ./resources/js/components/general.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utilities */ "./resources/js/components/utilities.js");


window.modalNote = function (note_id, model_note) {
  $('#id_rel').val(note_id);
  $('#model_note').val(model_note);
  $('#modal-lead-description').val('');
  $('#modal-note').modal('show');
};

var refresh = {
  'credit': creditRefresh
};
$("#frm-note").submit(function (event) {
  event.preventDefault();
  var model_note = $('#model_note').val();
  var refresh_dt = $('#refresh-dt').val();
  var new_form = document.getElementById("frm-note");
  var data = new FormData(new_form);
  axios.post("/panel/" + model_note + "/note", data).then(function (response) {
    if (refresh_dt != 'null') {
      (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-lead', 'Datos actualizados', 'Información actualizada correctamente');
      $('#modal-note').modal('hide');
    } else {
      refresh[model_note]();
    }
  })["catch"](function (e) {});
});

window.copyToClipBoardReport = function () {
  var content = document.getElementById('url_report').value; // Intentar usar la API del Portapapeles (navigator.clipboard) si está disponible

  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(content).then(function () {
      showToast('', 'URL copiada en el portapapeles', 'success');
    })["catch"](function (err) {
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
};

/***/ }),

/***/ "./resources/js/components/lead/crud.js":
/*!**********************************************!*\
  !*** ./resources/js/components/lead/crud.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");
/* harmony import */ var rfc_facil__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! rfc-facil */ "./node_modules/rfc-facil/dist/rfc-facil.es5.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return generator._invoke = function (innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; }(innerFn, self, context), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; this._invoke = function (method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, "throw" === context.method) { if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel; context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (object) { var keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }




window.setRfc = function () {
  var nacimiento = $('#lead-birth_date').val();
  var my_lastname = $('#lead-last_name').val();
  var my_secondlastname = $('#lead-second_last_name').val();
  var my_name = $('#lead-name').val();

  var _nacimiento$split = nacimiento.split('-'),
      _nacimiento$split2 = _slicedToArray(_nacimiento$split, 3),
      my_year = _nacimiento$split2[0],
      my_month = _nacimiento$split2[1],
      my_day = _nacimiento$split2[2];

  var rfc = rfc_facil__WEBPACK_IMPORTED_MODULE_1__["default"].forNaturalPerson({
    name: my_name,
    firstLastName: my_lastname,
    secondLastName: my_secondlastname,
    day: my_day,
    month: my_month,
    year: my_year
  });
  return rfc;
};

window.createRfc = function () {
  var rfc = setRfc();
  $('#lead-rfc').val(rfc);
  checkDataLeadExist(document.getElementById('lead-rfc'), 'rfc'); // Call check after setting value
};

$('.js-select2').select2({
  placeholder: "Escribe para buscar..",
  allowClear: true
});
$('.select2multiple').select2({
  placeholder: "Escribe para buscar.."
}); //onchangeOrganization

window.organizationChange = function (lead_agreement_id, financial_id, other, applied_financial_product) {
  if (other != null) {
    lead_agreement_id = 0;
    $('#new_agreement').val(other);
  } //alert(lead_agreement_id);


  if (lead_agreement_id != null) {
    $('#lead-agreement').val(lead_agreement_id).trigger("change");
  }

  var lead_agreement = $("#lead-agreement").val();
  $('#lead-content-agreement').hide();

  if (lead_agreement == 0) {
    $('#lead-content-agreement').show('slow');
  }

  if (typeof lead_agreement === 'string' && lead_agreement.trim().length == 0) {
    $('#lead-content-agreement').hide();
  } else {
    getFinancial(lead_agreement, financial_id);
    getFinancialByAgreement(lead_agreement, applied_financial_product);
  }
};

window.productChange = function (lead_product_id) {
  $('#content-importe-solicitado').hide();
  /* $('#content-banco_nomina').hide(); */
  //$('#content-tipo-credito').hide();

  $('#content-consulta-buro-credito').hide();
  $('#content-financial_product_id').hide();
  $('#content-aval-o-garantia').hide();
  $('#content-comment').hide();
  $('#lead-financial_id').val(null).trigger('change');

  if (lead_product_id != null) {
    $('#lead-product-id').val(lead_product_id).trigger("change");
  }

  var product_id = $("#lead-product-id").val();

  if (product_id == 2) {
    //portabilidad
    $('#content-financial_product_id').show();
    $('#content-importe-solicitado').show();
    /* $('#content-banco_nomina').hide(); */

    $('#content-producto-financiero').show();
    $('#content-consulta-buro-credito').hide();
    $('#content-aval-o-garantia').hide();
    $('#content-ingreso-mensual').show();
  }

  if (product_id == 1) {
    // credito nomina

    /* $('#content-banco_nomina').hide(); */
    $('#content-importe-solicitado').show();
    $('#content-producto-financiero').show();
    $('#content-tipo_tramite').show();
    $('#content-tipo-credito').show();
    $('#content-consulta-buro-credito').hide();
    $('#content-aval-o-garantia').hide();
    $('#content-ingreso-mensual').show();
  }

  if (product_id == 4) {
    // on-demand
    $('#content-producto-financiero').show();
    $('#content-ingreso-mensual').hide();
  }

  if (product_id == 3) {
    //Asesoria
    $('#content-comment').show();
    $('#content-aval-o-garantia').hide();
  }
};

function getFinancialByAgreement(agreementId, applied_financial_product) {
  var selectElement = document.getElementById('applied_financial_product');
  selectElement.options.length = 0; // Limpiar el select

  axios.get("/panel/agreement/" + agreementId + "/financial-product/show").then(function (response) {
    var financialProducts = response.data;
    Object.keys(financialProducts).forEach(function (key) {
      var option = document.createElement('option');
      option.value = key;
      option.textContent = financialProducts[key];
      selectElement.appendChild(option);
    });

    if (applied_financial_product != 'null') {
      $('#applied_financial_product').val(applied_financial_product).trigger("change");
    }
  })["catch"](function (e) {});
}

function getFinancial(lead_id, financial_id) {
  $('#lead-financial_id').empty();
  axios.get("/panel/lead/financial/" + lead_id + "/show").then(function (response) {
    var result = response.data;
    $('#lead-financial_id').empty();

    if (result != null) {
      var lead_financial = $('#lead-financial_id');

      for (var key in result) {
        var element = result[key];
        var option = new Option(element.commercial_name, element.id, true, true);
        lead_financial.append(option).trigger('change');
      }

      var _lead_id = $("#lead_id").val();

      var history_id = $("#history_id").val();

      if (financial_id == null) {
        $('#lead-financial_id').val(null).trigger('change');
      } else {
        $('#lead-financial_id').val(financial_id).trigger('change');
      }
    }
  })["catch"](function (e) {
    $('#admin_email-error-exist').show();
  });
}

window.getFinancialProduct = function (id, type) {
  axios.get("/panel/action/financial/product/" + id + "/" + type + '/show').then(function (response) {
    var result = response.data;
    var financials = result.financials;
    var financialValues = financials.map(function (item) {
      return item.product_id;
    }); // Limpia las selecciones actuales en el select múltiple

    $('#lead-financial-product-id').val(null).trigger('change'); // Seleccionar los valores correspondientes en los selects

    $('#lead-financial-product-id').val(financialValues).trigger('change');
  })["catch"](function (e) {});
};

window.setChannel = function (origin_id) {
  $('#lead-channel').empty();
  var lead_channel = $('#lead-channel');
  axios.get("/panel/lead/" + origin_id + "/origin/").then(function (response) {
    var result = response.data;

    if (result != null) {
      for (var key in result) {
        var element = result[key];

        if (element != 'Selecciona una opción') {
          var option = new Option(element, key, true, true);
          lead_channel.append(option).trigger('change');
        }
      }
    }

    $('#lead-channel').val(null).trigger('change');
    $('#lead-channel').val(change_channel).trigger("change");
  })["catch"](function (e) {
    $('#admin_email-error-exist').show();
  });
};

if (document.getElementById('lead-origin-admin')) {
  setChannel(1);
}

window.changeOrigen = function (change_channel) {
  var origin_id = $("#lead-origin").val();
  var lead_id = $("#lead_id").val();
  $('#lead-channel').empty();
  var lead_channel = $('#lead-channel');
  axios.get("/panel/lead/" + origin_id + "/origin/").then(function (response) {
    var result = response.data;

    if (result != null) {
      for (var key in result) {
        var element = result[key];

        if (element != 'Selecciona una opción') {
          var option = new Option(element, key, true, true);
          lead_channel.append(option).trigger('change');
        }
      }
    }

    $('#lead-channel').val(null).trigger('change');

    if (change_channel != null) {
      $('#lead-channel').val(change_channel).trigger("change");
    }
  })["catch"](function (e) {
    $('#admin_email-error-exist').show();
  });
};
/* $("#lead-origin" ).change(function() {
  
}); */


window.validateLeadEdit = function (lead_id) {
  var cellphone = $('#lead-cellphone').val();
  var rfc = $('#lead-rfc').val();
  axios.get("/panel/lead/" + cellphone + "/" + rfc + "/" + lead_id + "/get/validate").then(function (response) {
    var result = response.data;
    var isValidate = result.isValidate;
    var contentValidaciones = result.msg;
    var client_person_id = $('#client_person_id').val();

    if (isValidate == true) {
      $('#is_viability').val(1);
      $('#content-servicio-kc').show();
      $('#prospecto-valido').val('Prospecto válido');
      $('#content-validaciones').show();
      $('#content-validaciones').html(contentValidaciones);
    } else {
      $('#content-validaciones').hide();
      $('#is_viability').val(0);
      $('#content-servicio-kc').hide();
      $('#prospecto-valido').val('');
    }

    showContentIsValidate();
  })["catch"](function (e) {});
};

window.showContentIsValidate = function () {
  var is_viability = $('#is_viability').val();
  var clientPersonId = $('#client_person_id').val(); //perfil-cliente

  if (is_viability == 1) {
    $('.perfil-cliente').each(function () {
      $(this).attr('href', '/panel/client/' + clientPersonId);
    });
  }
};

function setData(is_change_origen, isChange, isChangeBirthDay) {
  var lead_id = $('#lead_id').val();
  axios.get("/panel/lead/" + lead_id).then(function (response) {
    var result = response.data;
    var lead = result.lead;
    var is_viability = lead.is_viability;
    var is_viability_credit = lead.is_viability_credit; //productChange(product_id);
    //organizationChange(lead.agreement_id, lead.financial_id, other, lead.applied_financial_product);

    $('#lead-origin-agreement').val(lead.agreement_id);
    getProductsByAgreementId(lead.agreement_id, lead.financial_product_id); //getFinancialProduct(lead.id, 1);

    if (is_change_origen == true) {
      $('#lead-origin').val(lead.origin_id);
      $('#lead-origin').trigger("change");
    }

    $('#lead-asesor-id').val(lead.asesor_id);
    $('#lead-asesor-id').trigger("change");
    /* $('#lead-type_id').val(lead.type_id);
    $('#lead-type_id').trigger("change"); */

    $('#lead-name').val(lead.name);

    if (isChangeBirthDay == true) {
      $('#lead-birth_date').val(lead.birth_date);
    }

    $('#lead-last_name').val(lead.last_name);
    $('#lead-second_last_name').val(lead.second_last_name);
    $('#lead-cellphone').val(lead.cellphone);
    $('#lead-email').val(lead.email);
    $('#lead-rfc').val(lead.rfc);

    if (document.getElementById('lead-manychat_id')) {
      $('#lead-manychat_id').val(lead.manychat_id);
    }

    $('#lead-comment').val(lead.comment);
    $('#client_person_id').val(lead.client_person_id);
    validateLeadEdit(lead_id); // Luego ejecuta validateLeadEdit
    //changeOrigen(lead.channel_id);

    $('#lead-temperature-id').val(lead.financial_id).trigger("change");
    $('#importe_solicitado').val(lead.importe_solicitado);
    $('#income').val(lead.income);
    $('#bank_id').val(lead.bank_id).trigger("change");
    $('#tipo_credito').val(lead.tipo_credito).trigger("change");
    $('#consulta_buro').val(lead.consulta_buro).trigger("change");
    $('#lead-agreement').val(lead.agreement_id).trigger("change");

    if (isChange == true) {
      checkDataLeadExist(document.getElementById('lead-cellphone'), 'cellphone'); // Call check after setting value

      checkDataLeadExist(document.getElementById('lead-email'), 'email'); // Call check after setting value

      checkDataLeadExist(document.getElementById('lead-rfc'), 'rfc'); // Call check after setting value
    }

    $('#applied_loan_type').val(lead.applied_loan_type).trigger("change"); // Get the checkbox elements

    var checkboxViability = document.getElementById('is_viability');
    var checkboxViabilityCredit = document.getElementById('is_viability_credit'); // Set the checked property based on the variables

    checkboxViability.checked = is_viability === 1;
    checkboxViabilityCredit.checked = is_viability_credit === 1;
  })["catch"](function (e) {
    $('#admin_email-error-exist').show();
  });
}

window.checkDataLeadExist = function (valInput, id) {
  var getValue = valInput.value;
  var messageElement = document.getElementById(id + '-msg');
  $('#content-validaciones').html('');

  if (valInput != '') {
    messageElement.textContent = "";
    axios.get("/panel/lead/" + getValue + "/" + id + "/check").then(function (response) {
      var result = response.data;
      var isExist = result.exist;
      var clientPerson = result.clientPerson;
      var isValidate = result.isValidate;
      $('#content-validaciones').html(result.contentValidaciones);
      $('.perfil-cliente').each(function () {
        $(this).attr('href', '/panel/client/' + clientPerson.id);
      });

      if (isExist > 0 && isValidate == true) {
        $('#client_person_id').val(clientPerson.id);
        $('#content-servicio-kc').show();
        getProductsByAgreementId(clientPerson.agreement_id, null);
        messageElement.classList.remove("text-danger");
        messageElement.classList.add("text-primary");
        messageElement.textContent = "Validación exitosa";
        $('#is_viability').val(1); //$('#lead_id').val(clientPerson.id);

        $('#prospecto-valido').val('Prospecto válido');
        $('#lead-origin-agreement').val(clientPerson.agreement_id);

        if (id == 'cellphone') {
          $('#isValidateCellphone').val(result.isValidate);
          $('#cellphone_validated').val(1);
          $('#rfc_validated').val(0);
        }

        if (id == 'rfc') {
          $('#cellphone_validated').val(0);
          $('#rfc_validated').val(1);
        }

        $('#lead-name').val(clientPerson.name);
        $('#lead-last_name').val(clientPerson.last_name);
        $('#lead-second_last_name').val(clientPerson.second_last_name);
        $('#lead-birth_date').val(clientPerson.birth_date);
        $('#lead-rfc').val(clientPerson.rfc);
        $('#lead-email').val(clientPerson.email);
        $('#lead-agreement').val(clientPerson.agreement_id).trigger("change");
      } else {
        messageElement.classList.remove("text-primary");
        messageElement.classList.add("text-danger");
        messageElement.textContent = "Validación fallida";
        $('#content-servicio-kc').hide();
        $('#prospecto-valido').val('');
        $('#is_viability').val(0);
      }
    })["catch"](function (e) {});
  }
};

window.showModalCompraCartera = function () {
  $('#modal-compra-cartera').modal('show');
  $('#creditPayOffId').val('');
};

$("#frm-modal-compra-cartera").submit(function (event) {
  event.preventDefault();
  var leadId = document.getElementById("lead_id").value;
  var new_form = document.getElementById("frm-modal-compra-cartera");
  var data = new FormData(new_form);
  data.append("data[lead_id]", leadId);
  data.append("data[client_person_id]", document.getElementById("client_person_id").value);
  axios.post("/panel/lead/credit-pay-off", data).then(function (response) {
    $('#modal-compra-cartera').modal('hide');
    var result = response.data;
    showTableCompraCartera(leadId);
  })["catch"](function (e) {});
});

window.deleteCompraCartera = function (creditPayOffId) {
  Swal.fire({
    title: '¿Estás seguro?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, elimina',
    cancelButtonText: 'Mejor no'
  }).then(function (result) {
    if (result.value) {
      axios["delete"]("/panel/lead/credit-pay-off/" + creditPayOffId).then(function (response) {
        var leadId = document.getElementById("lead_id").value;
        showTableCompraCartera(leadId);
      })["catch"](function (e) {});
    }
  });
};

window.editCompraCartera = function (creditPayOffId) {
  axios.get("/panel/lead/credit-pay-off/" + creditPayOffId + '/data/get').then(function (response) {
    var result = response.data;
    $('#compra-cartera-financial_product_id').val(result.financial_product_id).trigger("change");
    $('#compra-cartera-ammount').val(result.ammount);
    $('#creditPayOffId').val(creditPayOffId);
    $('#modal-compra-cartera').modal('show');
  })["catch"](function (e) {});
};

function showTableCompraCartera(leadId) {
  $('#content-table-compra-cartera').html('');
  $('#resumen-deuda-capital').val(total);
  axios.get("/panel/lead/credit-pay-off/" + leadId).then(function (response) {
    var result = response.data;
    var table = result.table;
    var total = result.total;
    var montoEntregar = $('#hmonto-entregar').val();
    $('#content-monto-compra-cartera').html(total);
    $('#resumen-deuda-capital').val(total);
    $('#content-monto-entregar').html(total - montoEntregar);
    $('#content-table-compra-cartera').html(table);
  })["catch"](function (e) {
    console.log('error elementos compra de cartera');
  });
}

window.getProductsByAgreementId = function (leadId, productId) {
  var selectElement = document.getElementById('financial_product_id');
  selectElement.options.length = 0; // Limpiar el select

  axios.get("/panel/lead/" + leadId + "/getProducts").then(function (response) {
    var products = response.data;
    Object.keys(products).forEach(function (key) {
      var option = document.createElement('option');
      option.value = key;
      option.textContent = products[key];
      selectElement.appendChild(option);
    });

    if (productId != 'null') {
      $('#financial_product_id').val(productId).trigger("change");
    }
  })["catch"](function (e) {});
};

window.deleteLead = function (lead_id) {
  axios.get("panel/lead/" + lead_id + "/delete").then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-lead', 'Datos actualizados', 'Información actualizada correctamente');
  })["catch"](function (e) {});
};

window.modalAdvisor = function (lead_id) {
  $('#lead_advisor_id').val(lead_id);
  $('#type_id').val(1);
  $('#modal-advisor').modal('show');
};

window.modalAdvisorCredit = function (credit_id) {
  $('#credit_id').val(credit_id);
  $('#type_id').val(2);
  $('#modal-advisor').modal('show');
};

$("#frm-advisor").submit(function (event) {
  event.preventDefault();
  var asesor_id = $('#modal-advisor-id').val();
  var lead_id = $('#lead_advisor_id').val();
  var credit_id = $('#credit_id').val();
  var type_id = $('#type_id').val();
  var url = "panel/lead/" + lead_id + "/advisor/store";
  var dt = 'dt-lead';

  if (type_id == 2) {
    url = "panel/credit/" + credit_id + "/advisor/store";
    dt = 'dt-check-up';
  }

  axios.post(url, {
    asesor_id: asesor_id
  }).then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, dt, 'Datos actualizados', 'Prospecto asignado');
    $('#modal-advisor').modal('hide');
  })["catch"](function (e) {});
});

window.createClientPerson = function (lead_id) {
  axios.post("panel/lead/" + lead_id + "/client-person/store").then(function (response) {
    var result = response.data;
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-lead', 'Datos actualizados', 'Cuenta creada');
  })["catch"](function (e) {
    showToast('prospecto', 'Este email ya está registrado', 'warning');
  });
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

function saveLead() {
  var new_form = document.getElementById("frm-lead");
  var data = new FormData(new_form);
  axios.post("/panel/lead", data).then(function (response) {
    var getResult = response.data;
    var result = getResult.lead;
    $('#lead_id').val(result.id);
    $('#isNew').val(0);
  })["catch"](function (e) {});
}

$().ready(function () {
  $("#frm-lead").validate({
    rules: {
      'data[name]': {
        required: true
      },
      'data[last_name]': {
        required: false
      },
      'data[cellphone]': {
        number: true,
        minlength: 10
      },
      'data[email]': {
        required: false,
        email: true
      },
      'data[origin_id]': {
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
      var isExport = $('#isExport').val();
      axios.post("/panel/lead", data).then(function (response) {
        var getResult = response.data;
        var result = getResult.lead;

        if (isExport == 'true') {
          $('#lead_id').val(result.id); //exportar

          exportLead(result.id);
        } else {
          window.location = '/panel/lead';
        }
      })["catch"](function (e) {});
    }
  });

  function exportLead(_x) {
    return _exportLead.apply(this, arguments);
  }

  function _exportLead() {
    _exportLead = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(leadId) {
      var fileName, formData, response, blob, link;
      return _regeneratorRuntime().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              fileName = 'KC - Datos exportados' + leadId + '.csv'; // Replace with your logic

              formData = new FormData();
              formData.append('lead_id', leadId);
              _context.next = 5;
              return axios.post("/panel/lead/" + leadId + "/data/export", formData, {
                responseType: 'blob'
              });

            case 5:
              response = _context.sent;
              blob = new Blob(["\uFEFF", response.data], {
                type: 'text/csv;charset=utf-8'
              });

              if (window.navigator && window.navigator.msSaveOrOpenBlob) {
                window.navigator.msSaveOrOpenBlob(blob, fileName);
              } else {
                link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = fileName;
                link.click();
              }

              $('#isExport').val(false);

            case 9:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }));
    return _exportLead.apply(this, arguments);
  }
});

window.saveAndExportLead = function () {
  $('#isExport').val(true);
  document.getElementById('btnSave').click();
};
/* modal vista previa perfil */


window.modalPreviewProfile = function (lead_id) {
  $('content-preview-profile').html('');
  axios.get("/panel/lead/" + lead_id + "/preview/profile").then(function (response) {
    var result = response.data;
    $('#content-preview-profile').html(result);
    $('#modal-preview-profile').modal('show');
  })["catch"](function (e) {});
};

window.modalPasswod = function (user_id) {
  $('#password_user_id').val(user_id);
  $('#modal-user-password').modal('show');
}; //*id_rel is action_id


window.modalRegisterAction = function (id_rel) {
  $('#register-action-id-rel').val(id_rel);
  $('#modal-register-action').modal('show');
}; //llenar tipo de tramite


function setSelectTramite(clientPersonId, financialProductId, tipoTramiteId) {
  var selectElement = document.getElementById('tramit_type');
  selectElement.options.length = 0; // Limpiar el select

  $('#content-validaciones-soad-tramite').html('');
  $('#content-error-producto-preautorizado').hide();
  $('#producto-deseado').hide();
  axios.get("/panel/lead/" + clientPersonId + "/" + financialProductId + "/tramite/get").then(function (response) {
    var result = response.data;
    var sodIsTramite = result.sodIsTramite;
    var sodMessage = result.sodMessage;
    var sodTramites = result.sodTramites;

    if (sodIsTramite == true) {
      $('#content-product-select').hide();
      Object.keys(sodTramites).forEach(function (key) {
        var option = document.createElement('option');
        option.value = key;
        option.textContent = sodTramites[key];
        selectElement.appendChild(option);
      });
    } else {
      $('#content-product-select').show();
      $('#content-error-producto-preautorizado').show();
    }

    if (tipoTramiteId != 'null') {
      $('#tramit_type').val(tipoTramiteId).trigger("change");
    }

    $('#content-validaciones-soad-tramite').html(sodMessage);
  })["catch"](function (e) {});
} //contenido tramite al cambiar el select si selecciona refinanciamiento


window.changeTramite = function () {
  var tramit_type = $('#tramit_type').val();
  var clientPersonId = $('#client_person_id').val();
  var productId = $('#financial_product_id').val();
  var typeProductId = $('#typeProductId').val();
  var leadId = document.getElementById("lead_id").value;
  $('#content-product-select').hide();
  $('#content-refinanciado').hide();
  $('#product-deseado-refinanciamiento').hide();
  $('#content-product-deseado-refinanciamiento').html('');

  if (tramit_type == 3 || tramit_type == 2 || tramit_type == 1) {
    axios.get("/panel/lead/" + clientPersonId + "/" + productId + "/" + tramit_type + "/refinanciamiento/get").then(function (response) {
      var result = response.data;
      var montoMaximo = result.montoMaximo;
      var plazoMaximo = result.plazoMaximo;
      var periodicidad = result.periodicidad;
      var payment = result.payment;
      var productoDeseado = result.productoDeseado;
      var terms = result.terms;
      $('#monto-maximo').val(montoMaximo);
      $('#plazo-maximo').val(plazoMaximo);
      $('#periodicidad').val(periodicidad);
      $('#pago-periodico').val(payment);
      $('#content-refinanciado').show();
      $('#content-product-select').show();
      $('#product-deseado-refinanciamiento').show();
      $('#content-product-deseado-refinanciamiento').html(productoDeseado);
      var selectTramite = document.getElementById('ref-plazo');
      selectTramite.options.length = 0; // Limpiar el select

      var defaultOption = document.createElement('option');
      defaultOption.value = ''; // Value vacío

      defaultOption.textContent = 'Seleccione una opción'; // Texto de la opción

      selectTramite.appendChild(defaultOption);
      Object.keys(terms).forEach(function (key) {
        var option = document.createElement('option');
        option.value = key;
        option.textContent = terms[key];
        selectTramite.appendChild(option);
      });

      if (typeProductId == 2) {
        showTableCompraCartera(leadId);
      }
    })["catch"](function (e) {});
  }
};

window.graficaProspecto = function () {
  var leadId = $('#lead_id').val();
};

window.getMontoSolicitado = function () {
  var clientPersonId = $('#client_person_id').val();
  var productId = $('#financial_product_id').val();
  var plazo = $('#ref-plazo').val();
  var tramit_type = $('#tramit_type').val(); // Obtiene todos los checkboxes con nombre 'credits[]'

  var checkboxes = document.querySelectorAll('input[name="credits[]"]:checked'); // Inicializa un array para guardar los valores seleccionados

  var credits = []; // Itera sobre los checkboxes seleccionados y almacena sus valores

  checkboxes.forEach(function (checkbox) {
    credits.push(checkbox.value);
  });
  var selectMontoMaximo = document.getElementById('ref-monto');
  selectMontoMaximo.options.length = 0; // Limpiar el select

  $('#total-refinanciable').val(0);
  axios.post("/panel/lead" + '/' + clientPersonId + "/" + productId + "/" + tramit_type + "/montoMaximo/get", {
    credits: credits,
    plazo: plazo
  }).then(function (response) {
    var result = response.data;
    var maximo = result.maximo;
    var total = result.total;
    var total_price = result.total_price;
    var defaultOption = document.createElement('option');
    defaultOption.value = ''; // Value vacío

    defaultOption.textContent = 'Seleccione una opción'; // Texto de la opción

    selectMontoMaximo.appendChild(defaultOption);
    Object.keys(maximo).forEach(function (key) {
      var option = document.createElement('option');
      option.value = key;
      option.textContent = maximo[key];
      selectMontoMaximo.appendChild(option);
    });
    $('#table-refinanciamiento-total').html(total_price);
    $('#total-refinanciable').val(total);
    getResumen();
  })["catch"](function (e) {});
};

window.getResumen = function () {
  var clientPersonId = $('#client_person_id').val();
  var productId = $('#financial_product_id').val();
  var plazo = $('#ref-plazo').val();
  var monto = $('#ref-monto').val();
  var totalRefinanciable = $('#total-refinanciable').val();
  var tramit_type = $('#tramit_type').val();
  var isControlDesk = $('#isControlDesk').val();
  $('#go_ahead').val(0);
  axios.get("/panel/lead/" + productId + "/" + plazo + '/' + monto + '/' + totalRefinanciable + '/' + tramit_type + '/getResumen').then(function (response) {
    var result = response.data;
    var montoSolicitado = result.montoSolicitado;
    var montoRefinanciar = result.montoRefinanciar;
    var comision = result.comision;
    var monto_entregar = result.monto_entregar;
    var montoEntregarDecimal = result.monto_entregar_decimal;
    var periodicidad = result.periodicidad;
    var plazo = result.plazo;
    var pagoPeriodico = result.pagoPeriodico;
    var pagoTotal = result.pagoTotal;
    var tasaAnual = result.tasaAnual;
    var cat = result.cat;
    var kcInteres = result.kcInteres;
    var kcPagoTotal = result.kcPagoTotal;
    $('#content-monto-solicitado').html(montoSolicitado);
    $('#content-monto-refinanciar').html(montoRefinanciar);
    $('#content-comision-apertura').html(comision);
    $('#content-monto-entregar').html(monto_entregar);
    $('#content-monto-entregar').html(monto_entregar);
    $('#content-plazo').html(periodicidad);
    $('#content-monto').html(plazo);
    $('#content-pago-periodico').html(pagoPeriodico);
    $('#content-pago-total').html(pagoTotal);
    $('#content-tasa-anual').html(tasaAnual);
    $('#content-cat').html(cat);
    $('#hmonto-entregar').val(montoEntregarDecimal);
    getChart();
    $('#go_ahead').val(1);
  })["catch"](function (e) {});
};

function getChart() {
  var productId = $('#financial_product_id').val();
  var leadId = $('#lead_id').val();
  var plazo = $('#ref-plazo').val();
  var monto = $('#ref-monto').val();
  axios.get("/panel/lead/" + productId + "/" + leadId + "/" + plazo + "/" + monto + '/getChart').then(function (response) {
    var result = response.data;
    $('#ahorro-interes-dinero').html(result.ahorroInteresDinerom);
    $('#ahorro-interes-porcentaje').html(result.ahorroInteresPorcentaje);
    $('#lbl-kc-pago-total').html(result.deudaPagoTotalm);
    $('#lbl-kc-porcentaje-interes').html(result.deudaPorcentajeInteresm);
    $('#lbl-deuda-pago-total').html(result.kcPagoTotal);
    $('#lbl-deuda-porcentaje-interes').html(result.kcPorcentajeInteres); // Crear múltiples gráficas de ejemplo con alturas dinámicas

    crearGraficaApilada(chartsContainer, result.deudaInteres, result.deudaCapital, '#a34444', '#757575', "Interés", "Deuda total <br> de tus créditos");
    crearGraficaApilada(chartsContainer, result.kcInteres, result.kcCapital, '#7eb1a2', '#57409b', "Interés", "Kaax Club");
  })["catch"](function (e) {});
} //validar soad activo y si existe la fecha en bd


window.validateSoad = function () {
  $('#content-validaciones-soad').html('');
  $('#content-validaciones-soad-date').html('');
  $('#content-product').html('');
  $('#content_tramit_type').hide();
  $('#content-validaciones-soad-tramite').html('');
  $('#go_ahead').val(0);

  if ($('#financial_product_id').val() != null) {
    var clientPersonId = $('#client_person_id').val();
    var agreement = $('#lead-origin-agreement').val();
    var productId = $('#financial_product_id').val();
    $('#content-error-producto-preautorizado').hide();
    axios.get("/panel/lead/" + clientPersonId + "/" + agreement + "/" + productId + "/soad/get").then(function (response) {
      var result = response.data;
      var typeProductId = result.type_product_id;
      $('#typeProductId').val(typeProductId);

      if ($('#is_viability').val() == 1) {
        saveLead();
      }

      if (typeProductId == 1 || typeProductId == 2) {
        $('#content_tramit_type').show(); //llenar el arreglo de tipo de trámite

        setSelectTramite(clientPersonId, productId, null);
      }

      if (result.financialProduct == 'Salario On-Demand') {
        var TextSoad = result.TextSoad;
        var soadActive = result.soadActive;
        var isSoadDate = result.isSoadDate;
        var isSodOnDate = result.isSodOnDate;
        $('#is_free_of_active_sod').val(0);
        $('#is_sod_on_date_allowed').val(0);

        if (soadActive != 0) {
          $('#content-validaciones-soad').html(TextSoad);
          $('#is_free_of_active_sod').val(1);
        }

        $('#is_sod_on_date_allowed').val(1);
        $('#sod_max').val(result.maximoRedondeado);
        $('#sod_min').val(result.minimoRedondeado);
        $('#content-validaciones-soad-date').html(isSoadDate);

        if (isSodOnDate == true) {
          $('#content-product').html(result.contentProductSod);
          $('#producto-deseado').show();
          $('#go_ahead').val(1); //valores slider

          var slider = document.getElementById('slider');
          slider.min = result.minimoRedondeado;
          slider.max = result.maximoRedondeado;
          $('#valor-minimo').html(result.minimoRedondeado);
          $('#valor-maximo').html(result.maximoRedondeado);
          $('#valor-comision').html('$' + result.comision);
          $('#sod_commision_amount').val(result.comision);
          $('#valor-banco').html(result.bank_name);
          $('#valor-cuenta').html(result.cuenta);
          $('#content-product-select').show();
        } else {
          $('#producto-deseado').hide();
        }
      }
    })["catch"](function (e) {});
  }
};

if (document.getElementById('valor-slider')) {
  var updateSliderValue = function updateSliderValue() {
    var slider = document.getElementById('slider');
    var displayValue = document.getElementById('valor-slider'); // Obtenemos el valor actual del slider

    var sliderValue = parseFloat(slider.value); // Actualizamos el contenido del span con el valor actual del slider

    displayValue.innerHTML = '$' + sliderValue;
    $('#sod_withdraw_amount').val(sliderValue);
    var comision = parseFloat($('#sod_commision_amount').val());
    var total = sliderValue + comision;

    if (!isNaN(total)) {
      $('#sod_total_payment').val(total);
    } else {
      $('#sod_total_payment').val(0); // O puedes asignar un valor por defecto si es NaN
    }

    $('#valor-total').html('$' + sliderValue);
  }; // Agregar el listener al slider para detectar cambios


  document.getElementById('slider').addEventListener('input', updateSliderValue); // Opcional: actualizar el valor del span al cargar la página

  window.addEventListener('DOMContentLoaded', updateSliderValue);
}

$(document).ready( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
  return _regeneratorRuntime().wrap(function _callee2$(_context2) {
    while (1) {
      switch (_context2.prev = _context2.next) {
        case 0:
          if (document.getElementById('lead-channel')) {
            setData(true, false, true);
          }

        case 1:
        case "end":
          return _context2.stop();
      }
    }
  }, _callee2);
})));
$(document).on("select2:open", function () {
  document.querySelector(".select2-container--open .select2-search__field").focus();
});
/* graficas */

function crearGraficaApilada(contenedor, valorInteres, valorDeuda) {
  var colorInteres = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : '#e57373';
  var colorDeuda = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : '#757575';
  var etiquetaInteres = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : "Interés";
  var etiquetaDeuda = arguments.length > 6 && arguments[6] !== undefined ? arguments[6] : "Deuda";
  var chartContainer = document.createElement('div');
  chartContainer.classList.add('chart-container'); // Cálculo del total y altura dinámica para cada gráfica

  var total = valorInteres + valorDeuda;
  var alturaMaxima = 400; // Altura máxima en píxeles para la gráfica con mayor valor

  var alturaGrafica = total / 16000 * alturaMaxima; // Escalado en base a un total de 16000 como máximo
  // Crear la barra de la gráfica

  var bar = document.createElement('div');
  bar.classList.add('bar');
  bar.style.height = "".concat(alturaGrafica, "px"); // Crear segmento de deuda

  var segmentoDeuda = document.createElement('div');
  segmentoDeuda.classList.add('segment', 'segment2');
  segmentoDeuda.style.backgroundColor = colorDeuda;
  segmentoDeuda.style.height = "".concat(valorDeuda / total * 100, "%");
  segmentoDeuda.innerHTML = "\n    <span style=\"font-size: 1.2em; \">$".concat(valorDeuda.toLocaleString(), "</span>\n    <span style=\"font-size: 1.2em;\">").concat(etiquetaDeuda, "</span>\n  "); // Crear segmento de interés

  var segmentoInteres = document.createElement('div');
  segmentoInteres.classList.add('segment', 'segment1');
  segmentoInteres.style.backgroundColor = colorInteres;
  segmentoInteres.style.height = "".concat(valorInteres / total * 100, "%");
  segmentoInteres.innerHTML = "\n     <span style=\"font-size: 1.2em;\">".concat(etiquetaInteres, "</span>\n    <span style=\"font-size: 1.2em;\">$").concat(valorInteres.toLocaleString(), "</span>\n   \n  "); // Añadir los segmentos a la barra (interés arriba)

  bar.appendChild(segmentoInteres);
  bar.appendChild(segmentoDeuda); // Añadir la barra al contenedor de la gráfica

  chartContainer.appendChild(bar);
  contenedor.appendChild(chartContainer); // Animación de llenado

  setTimeout(function () {
    segmentoInteres.style.opacity = 1;
    segmentoInteres.style.transform = 'scaleY(1)';
    segmentoDeuda.style.opacity = 1;
    segmentoDeuda.style.transform = 'scaleY(1)';
  }, 100); // Retraso para activar la animación
} // Selecciona el contenedor principal donde se añadirán las gráficas


var chartsContainer = document.getElementById('charts-container');

/***/ }),

/***/ "./resources/js/components/lead/datatable.js":
/*!***************************************************!*\
  !*** ./resources/js/components/lead/datatable.js ***!
  \***************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var route = $('#route_datatable').val();
  var module_id = null;

  if (document.getElementById('module_id')) {
    module_id = $('#module_id').val();
  }

  var table_lead = NioApp.DataTable('#dt-lead', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/lead/list/show',
    columns: [{
      data: 'id'
    }, {
      data: 'name'
    }, {
      data: 'date'
    }, {
      data: 'product'
    },
    /* { data: 'organizacion' }, */
    {
      data: 'label'
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
  }); // Expand table rows on click

  $('#dt-lead tbody').on('click', 'td', function () {
    var row = table_lead.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
  var table_archive = NioApp.DataTable('#dt-lead-archive', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/archive/lead/list/show',
    columns: [{
      data: 'id'
    }, {
      data: 'name'
    }, {
      data: 'date'
    }, {
      data: 'product'
    }, {
      data: 'origin'
    }, {
      data: 'reason'
    }, {
      data: 'advisor'
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
  }); // Expand table rows on click

  $('#dt-lead-archive tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
  var table__dinamic_archive = NioApp.DataTable('#dt-lead-dinamic-archive', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/archive/lead/list/' + module_id + '/show',
    columns: [{
      data: 'id'
    }, {
      data: 'name'
    }, {
      data: 'date'
    }, {
      data: 'product'
    }, {
      data: 'advisor'
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
  }); // Expand table rows on click

  $('#dt-lead-dinamic-archive tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});

/***/ }),

/***/ "./resources/js/components/module/datatable.js":
/*!*****************************************************!*\
  !*** ./resources/js/components/module/datatable.js ***!
  \*****************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-check-up', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/kc-check-up/list/show',
    columns: [{
      data: 'id'
    }, {
      data: 'product'
    }, {
      data: 'client'
    }, {
      data: 'advisor'
    }, {
      data: 'progress'
    }, {
      data: 'in_progress'
    }, {
      data: 'deadline'
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
  }); // Expand table rows on click

  $('#dt-check-up tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});

/***/ }),

/***/ "./resources/js/components/module/kc_check_up/action/datatable.js":
/*!************************************************************************!*\
  !*** ./resources/js/components/module/kc_check_up/action/datatable.js ***!
  \************************************************************************/
/***/ (() => {

var history_id;
var model;
var step;

if (document.getElementById('dt-check-up-actions')) {
  history_id = $('#history_id').val();
  model = $('#model').val();
  step = $('#step').val();
}

document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-check-up-actions', {
    processing: true,
    searching: false,
    ordering: false,
    paging: false,
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/template/actions/list/' + model + '/' + history_id + '/show?step=' + step,
    columns: [{
      data: 'name'
    }, {
      data: 'subject'
    }, {
      data: 'status'
    }, {
      data: 'deadline'
    }, {
      data: 'advisor'
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

/***/ "./resources/js/components/module/kc_check_up/action/datatable_report.js":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/module/kc_check_up/action/datatable_report.js ***!
  \*******************************************************************************/
/***/ (() => {

var history_id;

if (document.getElementById('dt-check-up-report-steps')) {
  history_id = $('#history_id').val();
}

document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-check-up-report-steps', {
    processing: true,
    searching: false,
    ordering: false,
    paging: false,
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/kc-check-up/report/list/' + history_id + '/show',
    columns: [{
      data: 'name'
    }, {
      data: 'subject'
    }, {
      data: 'status'
    }, {
      data: 'deadline'
    }, {
      data: 'advisor'
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

/***/ "./resources/js/components/module/kc_check_up/datatable.js":
/*!*****************************************************************!*\
  !*** ./resources/js/components/module/kc_check_up/datatable.js ***!
  \*****************************************************************/
/***/ (() => {

var history_id;

if (document.getElementById('dt-check-up-steps')) {
  history_id = $('#history_id').val();
  model = $('#model').val();
  document.addEventListener('DOMContentLoaded', function () {
    var table = NioApp.DataTable('#dt-check-up-steps', {
      processing: true,
      searching: false,
      ordering: false,
      paging: false,
      responsive: {
        details: {
          renderer: function renderer(api, rowIdx, columns) {
            var total = columns.length - 1;
            var data = $.map(columns, function (col, i) {
              if (total == i) {
                return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
              } else {
                return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
              }
            }).join('');
            return data ? $('<table/>').append(data) : false;
          }
        }
      },
      ajax: '/panel/template/list/' + model + '/' + history_id + '/show',
      columns: [{
        data: 'name'
      }, {
        data: 'step'
      }, {
        data: 'status'
      }, {
        data: 'progress'
      },
      /* { data: 'deadline'}, */
      {
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
}

/***/ }),

/***/ "./resources/js/components/module/kc_control_desk/datatable.js":
/*!*********************************************************************!*\
  !*** ./resources/js/components/module/kc_control_desk/datatable.js ***!
  \*********************************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-control-desk', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/kc-control-desk/list/show',
    columns: [{
      data: 'id'
    }, {
      data: 'fecha'
    }, {
      data: 'product'
    }, {
      data: 'client'
    }, {
      data: 'advisor'
    }, {
      data: 'progress'
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
  }); // Expand table rows on click

  $('#dt-control-desk tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});
/*  reference */

document.addEventListener('DOMContentLoaded', function () {
  var history_id = $('#history_id').val();
  var table = NioApp.DataTable('#dt-credit-reference', {
    processing: true,
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/reference/' + history_id + '/list',
    columns: [{
      data: 'id'
    }, {
      data: 'names'
    }, {
      data: 'last_name'
    }, {
      data: 'second_lastname'
    }, {
      data: 'relation'
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
document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-delivery', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/kc-delivery/list/show',
    columns: [{
      data: 'id'
    }, {
      data: 'product'
    }, {
      data: 'client'
    }, {
      data: 'advisor'
    }, {
      data: 'progress'
    }, {
      data: 'in_progress'
    }, {
      data: 'deadline'
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
  }); // Expand table rows on click

  $('#dt-delivery tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});
document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-after-market', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/kc-after-market/list/show',
    columns: [{
      data: 'id'
    }, {
      data: 'product'
    }, {
      data: 'client'
    }, {
      data: 'advisor'
    }, {
      data: 'progress'
    }, {
      data: 'in_progress'
    }, {
      data: 'deadline'
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
  }); // Expand table rows on click

  $('#dt-after-market tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});
document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-payment', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/kc-payments/list/show',
    columns: [{
      data: 'id'
    }, {
      data: 'product'
    }, {
      data: 'client'
    }, {
      data: 'advisor'
    }, {
      data: 'progress'
    }, {
      data: 'in_progress'
    }, {
      data: 'deadline'
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
  }); // Expand table rows on click

  $('#dt-payment tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});
/* wallet */

document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-wallet', {
    processing: true,
    isShowing: false,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/kc-wallet/list/show',
    columns: [{
      data: 'id'
    }, {
      data: 'date'
    }, {
      data: 'ordenante'
    }, {
      data: 'importe'
    }, {
      data: 'progress'
    }, {
      data: 'in_progress'
    }, {
      data: 'deadline'
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
  }); // Expand table rows on click

  $('#dt-wallet tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });

  if (document.getElementById('dt-wallet')) {
    var urlParams = new URLSearchParams(window.location.search);
    var alertParam = urlParams.get('alert');

    if (alertParam === 'true') {
      Swal.fire({
        title: 'Solicitud de agregar fondos',
        html: 'Hemos recibido tu Solicitud. <br> Le avisaremos y notificaremos a la brevedad',
        showCancelButton: false,
        confirmButtonText: 'ok'
      }).then(function (result) {
        if (result.value) {}
      });
    }
  }

  if (document.getElementById('dt-down-wallet')) {
    var _urlParams = new URLSearchParams(window.location.search);

    var _alertParam = _urlParams.get('alertdown');

    if (_alertParam === 'true') {
      Swal.fire({
        title: 'Solicitud de retirar fondos',
        html: 'Te avisaremos y notificaremos a la brevedad',
        showCancelButton: false,
        confirmButtonText: 'ok'
      }).then(function (result) {
        if (result.value) {}
      });
    }
  }
});
document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-down-wallet', {
    processing: true,
    isShowing: false,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/kc-down-wallet/list/show',
    columns: [{
      data: 'id'
    }, {
      data: 'date'
    }, {
      data: 'ordenante'
    }, {
      data: 'importe'
    }, {
      data: 'progress'
    }, {
      data: 'in_progress'
    }, {
      data: 'deadline'
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
  }); // Expand table rows on click

  $('#dt-down-wallet tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});
document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-wallet-history', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/kc-wallet/list/history/show',
    columns: [{
      data: 'id'
    }, {
      data: 'fecha'
    }, {
      data: 'tipo'
    }, {
      data: 'importe'
    }, {
      data: 'comision'
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
  }); // Expand table rows on click

  $('#dt-wallet-history tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});
document.addEventListener('DOMContentLoaded', function () {
  var table = NioApp.DataTable('#dt-kc-swap', {
    processing: true,
    responsive: {
      details: {
        type: 'column',
        target: 'td:not(:first-child):not(:nth-child(2))',
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr  >' + '<td style="width:100%; padding-top: 10px; padding-bottom:5px" colspan="2">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td style="padding-left: 10px; width:50%"><strong>' + col.title + '</strong></td> ' + '<td style="width:50%">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/kc-swap/list/show',
    columns: [{
      data: 'id'
    }, {
      data: 'product'
    }, {
      data: 'client'
    }, {
      data: 'advisor'
    }, {
      data: 'progress'
    }, {
      data: 'in_progress'
    }, {
      data: 'deadline'
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
  }); // Expand table rows on click

  $('#dt-kc-swap tbody').on('click', 'td', function () {
    var row = table.row($(this).closest('tr'));

    if (row.child.isShown()) {
      row.child.hide();
    } else {
      row.child.show();
    }
  });
});

/***/ }),

/***/ "./resources/js/components/module/kc_control_desk/reference.js":
/*!*********************************************************************!*\
  !*** ./resources/js/components/module/kc_control_desk/reference.js ***!
  \*********************************************************************/
/***/ (() => {

$().ready(function () {
  $("#frm-credit-reference").validate({
    rules: {
      'data_reference[last_name]': {
        required: true
      },
      'data_reference[second_lastname]': {
        required: true
      },
      'data_reference[names]': {
        required: true
      },
      'data_reference[relationship_time_years]': {
        number: true
      },
      'data_reference[relationship_time_months]': {
        number: true
      },
      'data_reference[cel_phone]': {
        required: true,
        number: true,
        minlength: 10,
        maxlength: 10
      },
      'data_reference[local_phone]': {
        number: true,
        minlength: 10,
        maxlength: 10
      },
      'data_reference[postal_code]': {
        number: true,
        minlength: 5,
        maxlength: 5
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var new_form = document.getElementById("frm-credit-reference");
      var data = new FormData(new_form);
      var history_id = $('#history_id').val();
      var reference_id = $('#reference_id').val();
      axios.post("/panel/reference/" + history_id + "/storeReference", data).then(function (response) {
        $('#dt-credit-reference').DataTable().ajax.reload();
        $('#modal-reference').modal('hide');
      })["catch"](function (e) {});
    }
  });

  window.deleteReference = function (reference_id) {
    Swal.fire({
      title: '¿Estás seguro?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, elimina',
      cancelButtonText: 'Mejor no'
    }).then(function (result) {
      if (result.value) {
        axios["delete"]("/panel/reference/" + reference_id + "/delete/").then(function (response) {
          window.history.back();
        })["catch"](function (e) {});
      }
    });
  };
});

/***/ }),

/***/ "./resources/js/components/module/resumen.js":
/*!***************************************************!*\
  !*** ./resources/js/components/module/resumen.js ***!
  \***************************************************/
/***/ (() => {

if (document.getElementById('checkIslimit')) {
  var checkbox = document.getElementById('checkIslimit');
  var numberInput = document.getElementById('lendable'); // Set initial state based on checkbox checked status

  numberInput.disabled = checkbox.checked;
  checkbox.addEventListener('change', function () {
    numberInput.disabled = this.checked;
  });
  $("#frm-inversionista-prestamo").submit(function (event) {
    event.preventDefault();
    var InvestorId = $('#investorId').val();
    var new_form = document.getElementById("frm-inversionista-prestamo");
    var data = new FormData(new_form);
    axios.post("/panel/inversionista", data).then(function (response) {
      window.location = '/panel/inversionista/' + InvestorId;
    })["catch"](function (e) {});
  });
}

/***/ }),

/***/ "./resources/js/components/module/template.js":
/*!****************************************************!*\
  !*** ./resources/js/components/module/template.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }


var refresh = {
  'newCredit': creditRefresh
};
$().ready(function () {
  $("#frm-template_new_credit").validate({
    rules: {
      'agreement_id': {
        required: true
      },
      'name': {
        required: true
      },
      'last_name': {
        required: true
      },
      'cellphone': {
        number: true,
        minlength: 10
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
      saveForm('frm-template_new_credit', 'newCredit');
    }
  }); //*form save debt credit strategy

  $("#frm-template_debt_credit").validate({
    rules: {
      'agreement_id': {
        required: true
      },
      'name': {
        required: true
      },
      'last_name': {
        required: true
      },
      'cellphone': {
        number: true,
        minlength: 10
      },
      'financial_id': {
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
      saveForm('frm-template_debt_credit', 'debtCredit');
    }
  }); //* save form  control desk step 1

  $("#frm-template_control_desk_step1").validate({
    rules: {
      'url_redirect_next': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_control_desk_step1', 'controlDesk');
    }
  });
  $("#frm-template_control_desk_step2").validate({
    rules: {
      /*  'credit[applied_financial_product]': {
           required: true,
       },
       'credit[applied_loan_type]': {
           required: true,
       }, */
      'credit[applied_import]': {
        required: true
      },
      'credit[applied_term]': {
        required: true
      },
      'credit[applied_periodicity]': {
        required: true
      },
      'credit[applied_payment]': {
        required: true
      },
      'credit[applied_loan_total_amount]': {
        required: true
      },
      'credit[applied_interest_rate]': {
        required: true
      },
      'credit[applied_CAT]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var input_loan = $('#input_loan').val();
      var applied_import = $('#applied_import').val();

      if (input_loan != '' && parseFloat(applied_import) > parseFloat(input_loan)) {
        Swal.fire({
          text: 'El importe solicitado no puede ser mayor al disponible',
          icon: 'warning'
        });
      } else {
        saveForm('frm-template_control_desk_step2', 'controlDesk');
      }
    }
  });
  $("#frm-template_control_desk_step2_task1").validate({
    rules: {
      'client_person[ID_primer_apellido]': {
        required: true
      },
      'client_person[ID_segundo_apellido]': {
        required: true
      },
      'client_person[ID_nombres]': {
        required: true
      },
      'client_person[ID_vigencia]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_control_desk_step2_task1', 'controlDesk');
    }
  });
  $("#frm-template_control_desk_step2_task2").validate({
    rules: {
      'client_person[ID_CIC]': {
        required: true,
        number: true
      },
      'client_person[ID_IDC]': {
        required: true,
        number: true,
        minlength: 9,
        maxlength: 9
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_control_desk_step2_task2', 'controlDesk');
    }
  });
  $("#frm-template_control_desk_step2_task3").validate({
    rules: {
      'client_person[payroll_date]': {
        required: true
      },
      'client_person[payroll_total]': {
        number: true,
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_control_desk_step2_task3', 'controlDesk');
    }
  });
  $("#frm-template_control_desk_dynamic_step2").validate({
    rules: {
      'pay_off[deadline_date]': {
        required: true
      },
      'pay_off[ammount]': {
        number: true,
        required: true
      },
      'pay_off[bank_clabe]': {
        required: true,
        number: true,
        minlength: 18,
        maxlength: 18
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_control_desk_dynamic_step2', 'controlDesk');
    }
  });
  $("#frm-template_control_desk_step3_task3").validate({
    rules: {
      'credit[payroll_payment_capacity]': _defineProperty({
        required: true
      }, "required", true)
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_control_desk_step3_task3', 'controlDesk');
    }
  });
  $("#frm-template_control_desk_step3_task").submit(function (event) {
    event.preventDefault();
    saveForm('frm-template_control_desk_step3_task', 'controlDesk');
  });

  window.getLoanAvailableByProduct = function (product) {
    $('#text-loan').html('');
    $('#input_loan').val('');
    var productId = product.value;
    $('#applied_loan_total_amount').val('');
    $('#applied_payment').val('');
    $('#applied_term').val('');
    $('#applied_interest_rate').val('');
    $('#applied_CAT').val('');
    axios.get("/panel/financial-product/" + productId).then(function (response) {
      var result = response.data;

      if (result != null) {
        // Use Intl.NumberFormat for locale-aware currency formatting
        var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
          // Replace with your desired currency code
          minimumFractionDigits: 2 // Ensure at least two decimal places

        });
        var loan_available = result.loan_available == null || undefined ? 0 : result.loan_available;
        var formattedAmount = formatter.format(loan_available);
        $('#text-loan').html('Disponible: ' + formattedAmount);
        $('#input_loan').val(loan_available);
        $('#comision').val(result.sod_commission_amount);
        $('#producto').val(result.type_product_id);

        if (result.type_product_id == 6) {
          $('#applied_term').val(1);
          $('#applied_interest_rate').val(0);
          $('#applied_CAT').val(0);
        }

        setBajoDemanda();
      }
    })["catch"](function (e) {
      console.error('Error fetching loan available:', e);
    });
  };

  window.setBajoDemanda = function () {
    var comision = parseFloat($('#comision').val());
    var inputAppliedImport = document.getElementById('applied_import');
    inputAppliedImport.addEventListener('input', function () {
      var importeSolicitado = parseFloat(inputAppliedImport.value);
      var productId = $('#producto').val();

      if (productId == 6) {
        $('#applied_loan_total_amount').val(importeSolicitado + comision);
        $('#applied_payment').val(importeSolicitado + comision);
      }
    });
  };

  $("#frm-template_control_desk_step3_1").validate({
    rules: {
      'client_person[sex]': {
        required: true
      },
      'client_person[rfc]': {
        required: true,
        minlength: 13,
        maxlength: 13
      },
      'client_person[curp]': {
        required: false,
        minlength: 18,
        maxlength: 18
      },
      'client_person[client_postal_code]': {
        required: false,
        number: true,
        minlength: 5,
        maxlength: 5
      },
      'client_person[bank_name]': {
        required: true
      },
      'client_person[bank_card_number]': {
        number: true,
        minlength: 16,
        maxlength: 16
      },
      'client_person[bank_acount_number]': {
        number: true,
        minlength: 10,
        maxlength: 10
      },
      'client_person[bank_clabe]': {
        number: true,
        minlength: 18,
        maxlength: 18,
        required: true
      },
      'client_person[monthly_income]': {
        required: false,
        number: true
      },
      'client_person[workplace_postal_code]': {
        required: false,
        number: true,
        minlength: 5,
        maxlength: 5
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_control_desk_step3_1', 'controlDesk');
    }
  });
  $("#frm-template_control_desk_step3_2").validate({
    rules: {
      'credit[interviewer]': {
        required: true
      },

      /* domicilio */
      'client_person[client_postal_code]': {
        required: true,
        number: true,
        minlength: 5,
        maxlength: 5
      },
      'client_person[client_street]': {
        required: true
      },
      'client_person[client_home_external_number]': {
        required: true
      },
      'client_person[client_colony]': {
        required: true
      },
      'client_person[client_city]': {
        required: true
      },
      'client_person[client_state]': {
        required: true
      },
      'client_person[client_country]': {
        required: true
      },
      'client_person[relative_local_phone]': {
        number: true,
        minlength: 10,
        maxlength: 10
      },
      'client_person[relative_cel_phone]': {
        number: true,
        minlength: 10,
        maxlength: 10
      },
      'client_person[home_time_living]': {
        number: true
      },
      'client_person[propety_ownnership_amount]': {
        number: true
      },
      'client_person[propety_ownnership_value]': {
        number: true
      },
      'client_person[vehicle_ownnership_amount]': {
        number: true
      },
      'client_person[vehicle_ownnership_value]': {
        number: true
      },
      'client_person[economic_dependents]': {
        number: true
      },
      'client_person[aditional_labor_income]': {
        number: true
      },
      'client_person[workplace_local_phone]': {
        number: true,
        minlength: 10,
        maxlength: 10
      },
      'client_person[workplace_cel_phone]': {
        number: true,
        minlength: 10,
        maxlength: 10
      },
      'client_person[workplace_local_phone_extension]': {
        number: true
      },
      'client_person[bank_card_number]': {
        number: true,
        minlength: 16,
        maxlength: 16
      },
      'client_person[bank_acount_number]': {
        number: true,
        minlength: 10,
        maxlength: 10
      },
      'client_person[bank_clabe]': {
        number: true,
        minlength: 18,
        maxlength: 18
      },
      'client_person[monthly_income]': {
        required: true,
        number: true
      },
      'client_person[workplace_postal_code]': {
        required: true,
        number: true,
        minlength: 5,
        maxlength: 5
      },
      'client_person[workplace_street]': {
        required: true
      },
      'client_person[workplace_home_external_number]': {
        required: true
      },
      'client_person[workplace_home_internal_number]': {
        required: true
      },
      'client_person[workplace_colony]': {
        required: true
      },
      'client_person[workplace_city]': {
        required: true
      },
      'client_person[workplace_state]': {
        required: true
      },
      'client_person[workplace_country]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_control_desk_step3_2', 'controlDesk');
    }
  });

  if (document.getElementById('frm-template_control_desk_step4')) {
    var form_control_desk_step4 = document.getElementById('frm-template_control_desk_step4'); // Maneja el evento submit del formulario

    form_control_desk_step4.addEventListener('submit', function (event) {
      event.preventDefault(); // Evita que el formulario se envíe automáticamente

      saveForm('frm-template_control_desk_step4', 'controlDesk');
    });
  }

  if (document.getElementById('frm-template_control_desk_step3_task4')) {
    var _form_control_desk_step = document.getElementById('frm-template_control_desk_step3_task4'); // Maneja el evento submit del formulario


    _form_control_desk_step.addEventListener('submit', function (event) {
      event.preventDefault(); // Evita que el formulario se envíe automáticamente

      saveForm('frm-template_control_desk_step3_task4', 'controlDesk');
    });
  }

  if (document.getElementById('frm-template_control_desk_step3_task5')) {
    var _form_control_desk_step2 = document.getElementById('frm-template_control_desk_step3_task5'); // Maneja el evento submit del formulario


    _form_control_desk_step2.addEventListener('submit', function (event) {
      event.preventDefault(); // Evita que el formulario se envíe automáticamente

      saveForm('frm-template_control_desk_step3_task5', 'controlDesk');
    });
  }

  if (document.getElementById('frm-template_control_desk_dynamic_step3')) {
    var _form_control_desk_step3 = document.getElementById('frm-template_control_desk_dynamic_step3'); // Maneja el evento submit del formulario


    _form_control_desk_step3.addEventListener('submit', function (event) {
      event.preventDefault(); // Evita que el formulario se envíe automáticamente

      saveForm('frm-template_control_desk_dynamic_step3', 'controlDesk');
    });
  }

  if (document.getElementById('frm-template_control_desk_step4_task1')) {
    var _form_control_desk_step4 = document.getElementById('frm-template_control_desk_step4_task1'); // Maneja el evento submit del formulario


    _form_control_desk_step4.addEventListener('submit', function (event) {
      event.preventDefault(); // Evita que el formulario se envíe automáticamente

      saveForm('frm-template_control_desk_step4_task1', 'controlDesk');
    });
  }

  if (document.getElementById('frm-template_control_desk_step4_task2')) {
    var _form_control_desk_step5 = document.getElementById('frm-template_control_desk_step4_task2'); // Maneja el evento submit del formulario


    _form_control_desk_step5.addEventListener('submit', function (event) {
      event.preventDefault(); // Evita que el formulario se envíe automáticamente

      saveForm('frm-template_control_desk_step4_task2', 'controlDesk');
    });
  }

  window.openModalValidateControlDesk = function (creditId) {
    axios.get("/panel/template/validate/" + creditId + "/controlDesk").then(function (response) {
      var result = response.data;
      $('#content-validate-control-desk').html(result);
      $('#modalValidateControlDesk').modal('show');
    })["catch"](function (e) {});
  };

  $("#frm-template_control_desk_step5").validate({
    rules: {
      'credit[financial_user_assigned]': {
        required: true
      },
      'credit[commission]': {
        required: true,
        number: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      TotalCredits();
    }
  });

  function TotalCredits() {
    var creditId = $('#id_rel').val();
    axios.get("/panel/client/" + creditId + "/credit/total").then(function (response) {
      var result = response.data;
      var total = result.total;

      if (total > 1) {
        saveForm('frm-template_control_desk_step5', 'controlDesk');
      } else {
        Swal.fire({
          title: 'Este es un cliente nuevo',
          text: 'Confirmo que se incluyó el contrato de comisión mercantil para un cliente nuevo',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Continuar',
          cancelButtonText: 'Cancelar'
        }).then(function (result) {
          if (result.value) {
            saveForm('frm-template_control_desk_step5', 'controlDesk');
          }
        });
      }
    })["catch"](function (e) {});
  }

  $("#frm-template_control_desk_step5_2").validate({
    rules: {
      'credit[signed]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_control_desk_step5_2', 'controlDesk');
    }
  });
  $("#frm-template_delivery_step2").validate({
    rules: {
      'credit[changed_commission]': {
        number: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_delivery_step2', 'delivery');
    }
  });
  $("#frm-template_payment_step2").validate({
    rules: {
      'credit[changed_commission]': {
        number: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_payment_step2', 'payment');
    }
  });
  $("#frm-template_delivery_step3").validate({
    rules: {
      'credit[payment_check]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_delivery_step3', 'delivery');
    }
  });
  $("#frm-template_payment_step3").validate({
    rules: {
      'credit[payment_check]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_payment_step3', 'payment');
    }
  });
  $("#frm-template_swap_step1").validate({
    rules: {
      'client_person[name]': {
        required: true
      },
      'client_person[last_name]': {
        required: true
      },
      'client_person[second_last_name]': {
        required: true
      },
      'client_person[cellphone]': {
        required: true
      },
      'client_person[email]': {
        required: true
      },
      'client_person[rfc]': {
        required: true,
        minlength: 13,
        maxlength: 13
      },
      'credit[id_number]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_swap_step1', 'swap');
    }
  });
  $("#frm-template_swap_step2").validate({
    rules: {
      'credit[url_sign]': {
        required: true,
        url: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_swap_step2', 'swap');
    }
  });
  $("#frm-template_swap_step2-2").validate({
    rules: {
      'credit[signed]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_swap_step2-2', 'swap');
    }
  });
  $("#frm-template_swap_step2-3").validate({
    rules: {
      'financial[email]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_swap_step2-3', 'swap');
    }
  });
  $("#frm-template_swap_step3").validate({
    rules: {
      'credit[termination_number]': {
        required: true
      },
      'credit[termination_bank_name]': {
        required: true
      },
      'credit[termination_bank_account_holder]': {
        required: true
      },
      'credit[termination_bank_clabe]': {
        required: true
      },
      'credit[termination_bank_reference]': {
        required: true
      },
      'credit[termination_amount]': {
        required: true
      },
      'credit[termination_deadline]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_swap_step3', 'swap');
    }
  });
  /* wallet */

  $("#frm-template_wallet_step1").validate({
    rules: {
      'transaction[investor_id]': {
        required: true
      },
      'transaction[bank_transfer_type]': {
        required: true
      },
      'transaction[amount]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_wallet_step1', 'wallet');
    }
  }); //if exist implement onchange select

  window.getValue = function (get) {
    $('#content-legend').html('');
    var ordenante = get.value;
    axios.get("/panel/kc-wallet/" + ordenante + "/investor/get").then(function (response) {
      var result = response.data;
      $('#content-legend').html(result);
    })["catch"](function (e) {});
  };

  if (document.getElementById('type_form') && $('#type_form').val() == '66') {
    $('#content-legend-kc-down-bank').show();
  }

  if (document.getElementById('frm-template_wallet_step1')) {
    var investorIdInput = document.getElementById('investor_id'); // Check if investor_id element exists and is a hidden input

    if (investorIdInput && investorIdInput.type === 'hidden') {
      getValue(investorIdInput);
    }
  }

  $("#frm-template_wallet_step1_2").validate({
    rules: {
      'transaction[operation_status]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_wallet_step1_2', 'wallet');
    }
  }); //* wallet-down

  $("#frm-template_wallet_down_step1").validate({
    rules: {
      'transaction[investor_id]': {
        required: true
      },
      'transaction[amount]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      var withdraw_available = $('#withdraw_available').val();
      var amount = $('#amount').val();

      if (withdraw_available != '' && parseFloat(amount) > parseFloat(withdraw_available)) {
        Swal.fire({
          text: 'El importe a retirar debe ser menor  al disponible para el retiro',
          icon: 'warning'
        });
      } else {
        saveForm('frm-template_wallet_down_step1', 'kc-down-wallet');
      }
    }
  });
  $("#frm-template_wallet_down_step2").validate({
    rules: {
      'transaction[operation_status]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      saveForm('frm-template_wallet_down_step2', 'kc-down-wallet');
    }
  }); //*get data

  if (document.getElementById('id_rel')) {
    var id_rel = $('#id_rel').val();
    var type_form = $('#type_form').val();

    if (id_rel != '') {
      axios.get("/panel/action-form/" + id_rel + "/" + type_form + '/form/get').then(function (response) {
        var result = response.data;
        var credit = result.credit;
        var client = result.client;
        var transaction = result.transaction;

        if (type_form == 8) {
          //checkup
          organizationChange(credit.agreement_id, null);
          $('#name').val(client.name);
          $('#last_name').val(client.last_name);
          $('#second_last_name').val(client.second_last_name);
          $('#cellphone').val(client.cellphone);
        }

        if (type_form == 12) //reduccion
          {
            getFinancialProduct(credit.id, 2);
            organizationChange(credit.agreement_id, credit.financial_id);
            $('#name').val(client.name);
            $('#last_name').val(client.last_name);
            $('#second_last_name').val(client.second_last_name);
            $('#cellphone').val(client.cellphone);
            $('#current_payment').val(credit.current_payment / 100);
            $('#current_periodicity').val(credit.current_periodicity).trigger("change");
            $('#current_loan').val(credit.current_loan / 100);
            $('#current_term').val(credit.current_term);
            $('#current_principal_balance').val(credit.current_principal_balance / 100);
            $('#current_total_balance').val(credit.current_total_balance / 100);
            $('#tipo_credito').val(credit.tipo_credito).trigger("change");
          }

        if (type_form == 23) //form kc-desktop step1
          {
            $('#payment_capacity_period').val(credit.payment_capacity_period);
            $('#payment_capacity').val(credit.payment_capacity);
            $('#birth_date').val(client.birth_date);
            $('#labor_old').val(client.labor_old);
            $('#employee_category').val(client.employee_category);
          }

        if (type_form == 24) //form kc-desktop step2
          {
            $('#applied_financial').val(credit.applied_financial).trigger("change");
            $('#applied_financial_product').val(credit.applied_financial_product).trigger("change");
            $('#applied_loan_type').val(credit.applied_loan_type).trigger("change");
            $('#applied_loan_discount').val(credit.applied_loan_discount);
            $('#applied_sign_type').val(credit.applied_sign_type).trigger("change");
            $('#applied_import').val(credit.applied_import);
            $('#applied_term').val(credit.applied_term);
            $('#applied_periodicity').val(credit.applied_periodicity).trigger("change");
            $('#applied_payment').val(credit.applied_payment);
            $('#applied_loan_total_amount').val(credit.applied_loan_total_amount);
            $('#applied_interest_rate').val(credit.applied_interest_rate);
            $('#applied_CAT').val(credit.applied_CAT);
          }

        if (type_form == 26) //form kc-desktop step3 - 1
          {
            $('#work_email').val(client.work_email);
            $('#sex').val(client.sex).trigger("change");
            $('#rfc').val(client.rfc);
            $('#nationality').val(client.nationality);
            $('#birth_state').val(client.birth_state);
            $('#curp').val(client.curp);
            $('#client_postal_code').val(client.client_postal_code);
            $('#client_street').val(client.client_street);
            $('#client_home_external_number').val(client.client_home_external_number);
            $('#client_home_internal_number').val(client.client_home_internal_number);
            $('#client_colony').val(client.client_colony);
            $('#client_city').val(client.client_city);
            $('#client_state').val(client.client_state);
            $('#client_country').val(client.client_country);
            $('#bank_name').val(client.bank_name);
            $('#bank_card_number').val(client.bank_card_number);
            $('#bank_acount_number').val(client.bank_acount_number);
            $('#bank_clabe').val(client.bank_clabe);
            $('#employee_number').val(client.employee_number);
            $('#monthly_income').val(client.monthly_income);
            $('#workplace_postal_code').val(client.workplace_postal_code);
            $('#workplace_street').val(client.workplace_street);
            $('#workplace_home_external_number').val(client.workplace_home_external_number);
            $('#workplace_home_internal_number').val(client.workplace_home_internal_number);
            $('#workplace_colony').val(client.workplace_colony);
            $('#workplace_city').val(client.workplace_city);
            $('#workplace_state').val(client.workplace_state);
            $('#workplace_country').val(client.workplace_country);
          }

        if (type_form == 27) //form kc-desktop step3 - 2
          {
            $('#marital_status').val(client.marital_status).trigger("change");
            $('#education_level').val(client.education_level).trigger("change");
            $('#profession').val(client.profession);
            $('#client_contact_time').val(client.client_contact_time);
            $('#relative_lastname').val(client.relative_lastname);
            $('#relative_second_lastname').val(client.relative_second_lastname);
            $('#relative_names').val(client.relative_names);
            $('#relative_local_phone').val(client.relative_local_phone);
            $('#relative_cel_phone').val(client.relative_cel_phone);
            $('#relative_contact_time').val(client.relative_contact_time);
            $('#home_type').val(client.home_type).trigger("change");
            $('#home_time_living').val(client.home_time_living);
            $('#home_note').val(client.home_note);
            $('#propety_ownnership_amount').val(client.propety_ownnership_amount);
            $('#propety_ownnership_value').val(client.propety_ownnership_value);
            $('#vehicle_ownnership_amount').val(client.vehicle_ownnership_amount);
            $('#vehicle_ownnership_value').val(client.vehicle_ownnership_value);
            $('#economic_dependents').val(client.economic_dependents);
            $('#workplace_name').val(client.workplace_name);
            $('#admission_date').val(client.admission_date);
            $('#employee_area').val(client.employee_area);
            $('#employee_position').val(client.employee_position);
            $('#aditional_labor_source').val(client.aditional_labor_source);
            $('#aditional_labor_income').val(client.aditional_labor_income);
            $('#workplace_local_phone').val(client.workplace_local_phone);
            $('#workplace_cel_phone').val(client.workplace_cel_phone);
            $('#workplace_code').val(client.workplace_code);
            $('#workplace_local_phone_extension').val(client.workplace_local_phone_extension);
            selectRadio(credit.client_public_servant, 'client_public_servant');
            $('#client_public_servant_position').val(credit.client_public_servant_position);
            $('#client_public_servant_period').val(credit.client_public_servant_period);
            selectRadio(credit.relative_public_servant, 'relative_public_servant');
            $('#relative_public_servant_lastname').val(credit.relative_public_servant_lastname);
            $('#relative_public_servant_second_lastname').val(credit.relative_public_servant_second_lastname);
            $('#relative_public_servant_names').val(credit.relative_public_servant_names);
            $('#relative_public_servant_relationship').val(credit.relative_public_servant_relationship);
            $('#relative_public_servant_position').val(credit.relative_public_servant_position);
            $('#relative_public_servant_period').val(credit.relative_public_servant_period);
            selectRadio(credit.prepaid, 'prepaid');
            selectPrepadMethod(credit.prepad_method, 'prepad_method');
            $('#prepaid_frequency').val(credit.prepaid_frequency);
            $('#prepaid_source').val(credit.prepaid_source);
            selectRadio(credit.endorsement, 'endorsement');
            selectRadio(credit.real_beneficiary, 'real_beneficiary');
            selectRadio(credit.soruce_provider, 'soruce_provider');
            selectRadio(credit.real_propetary, 'real_propetary');
            $('#notes').val(credit.notes);
            $('#client_postal_code').val(client.client_postal_code);
            $('#client_street').val(client.client_street);
            $('#client_home_external_number').val(client.client_home_external_number);
            $('#client_home_internal_number').val(client.client_home_internal_number);
            $('#client_colony').val(client.client_colony);
            $('#client_city').val(client.client_city);
            $('#client_state').val(client.client_state);
            $('#client_country').val(client.client_country);
          }

        if (type_form == 29) //form kc-desktop step 5
          {
            $('#financial_user_assigned').val(credit.financial_user_assigned).trigger("change");
            $('#commission').val(credit.commission);
            $('#commission_note').val(credit.commission_note);
          }

        if (type_form == 32) //form kc-ddelivery step 2
          {
            $('#changed_commission').val(credit.changed_commission / 100);
            $('#changed_commission_note').val(credit.changed_commission_note);
          }

        if (type_form == 34) //form kc-ddelivery step 3
          {
            $('#payment_check').val(credit.payment_check).trigger("change");
            $('#payment_check_note').val(credit.payment_check_note);
          }

        if (type_form == 39) //form kc-swap step 1
          {
            $('#name').val(client.name);
            $('#last_name').val(client.last_name);
            $('#second_last_name').val(client.second_last_name);
            $('#cellphone').val(client.cellphone);
            $('#email').val(client.email);
            $('#rfc').val(client.rfc);
            $('#id_number').val(credit.id_number);
            $('#current_credit_number').val(credit.current_credit_number);
            $('#current_payment').val(credit.current_payment / 100);
            $('#current_periodicity').val(credit.current_periodicity).trigger("change");
            $('#current_loan').val(credit.current_loan / 100);
            $('#current_term').val(credit.current_term);
            $('#current_principal_balance').val(credit.current_principal_balance / 100);
            $('#current_total_balance').val(credit.current_total_balance / 100);
          }

        if (type_form == 40) //form kc-swap step 2
          {
            $('#url_sign').val(credit.url_sign);
          }

        if (type_form == 41) //form kc-swap step 2 form 2
          {
            $('#signed').val(credit.signed).trigger("change");
          }

        if (type_form == 61) //form kc-wallet step1
          {
            $('#investor_id').val(transaction.investor_id).trigger("change");
            $('#bank_transfer_type').val(transaction.bank_transfer_type).trigger("change");
            $('#operation_number').val(transaction.operation_number);
            $('#amount').val(transaction.amount);
          }

        if (type_form == 63) //form kc-wallet step2
          {
            $('#operation_status').val(transaction.operation_status).trigger("change");
          }

        if (type_form == 67) //form kc-wallet step2
          {
            $('#operation_status').val(transaction.operation_status).trigger("change");
          }

        if (type_form == 66) //form kc-wallet step1
          {
            $('#investor_id').val(transaction.investor_id).trigger("change");
            $('#transaction_type').val(transaction.transaction_type);
            $('#amount').val(Math.abs(transaction.amount));
          }
      })["catch"](function (e) {});
    }
  }
});

function selectRadio(val, id) {
  if (val == 1) {
    document.querySelector('#' + id + '_1').checked = true;
  } else {
    document.querySelector('#' + id + '_2').checked = true;
  }
}

function selectPrepadMethod(val, id) {
  if (val == 1) {
    document.querySelector('#' + id + '_1').checked = true;
  } else if (val == 2) {
    document.querySelector('#' + id + '_2').checked = true;
  } else if (val == 3) {
    document.querySelector('#' + id + '_3').checked = true;
  } else if (val == 4) {
    document.querySelector('#' + id + '_4').checked = true;
  }
}

window.swapContinue = function (credit_id) {
  axios.get("/panel/action-form").then(function (response) {
    var result = response.data;
  })["catch"](function (e) {});
};

window.swapCancel = function (id_form, model) {
  axios.get("/panel/action-form").then(function (response) {
    var result = response.data;
  })["catch"](function (e) {});
};

function saveForm(id_form, model) {
  var new_form = document.getElementById(id_form);
  var data = new FormData(new_form);
  var id_rel = $('#id_rel').val();
  var url_redirect = null;
  var is_redirect_document = null;

  if (document.getElementById('url_redirect')) {
    url_redirect = $('#url_redirect').val();
  }

  console.log(model);
  data.append('model', model);
  data.append('id_rel', id_rel);
  axios.post("/panel/action-form", data).then(function (response) {
    var result = response.data;

    if (url_redirect == null) {
      window.history.back();
    }

    if (document.getElementById('url_redirect_finish')) {
      // Obtener el valor de "id"
      var id = result.id; // Obtener el elemento "url_redirect_finish"

      var urlRedirectFinishElement = document.getElementById('url_redirect_finish'); // Obtener el valor actual de data-redirect

      var currentDataRedirect = urlRedirectFinishElement.getAttribute('data-redirect'); // Reemplazar {history_id} con el valor de "id"

      var updatedDataRedirect = currentDataRedirect.replace('{history_id}', id); // Actualizar el valor de data-redirect

      urlRedirectFinishElement.setAttribute('data-redirect', updatedDataRedirect);
      /* window.location = updatedDataRedirect; */

      url_redirect = updatedDataRedirect;

      if (url_redirect.includes('{id}')) {
        url_redirect = url_redirect.replace('{id}', result.id);
      }
    }

    window.location = url_redirect;
  })["catch"](function (e) {});
}

window.saveAndContinueTask = function (id_form) {
  var model = $('#action-model').val();
  var newUrl = $('#url_redirect_next').val();
  $('#url_redirect').val(newUrl);
  saveForm(id_form, model);
};

window.cancelTask = function () {
  var url = $('#url_redirect').val();
  window.location = url;
}; //*boton saltar en swap etapa 2_3   


window.saltarSwap = function () {
  $('#send_email').val(0);
  $("#frm-template_swap_step2-3").submit(); // Envía el formulario
}; //TODO: alerta si detecto kyc


window.kycCreditHistory = function (history_id, type) {
  var params = {
    1: 'curp',
    2: 'ine',
    3: 'rfc',
    4: 'curp'
  };
  var id = params[type];
  var id_result = params[type];
  var param = $('#' + id).val();

  if (type == 4) {
    id_result = 'issste';
  }

  var param2 = type == 2 ? $('#identificadorCiudadano').val() : null;
  var error = false;

  if (type == 2 && param == '' && param2 == '') {
    error = true;
    Swal.fire({
      text: 'Campos obligatorios',
      icon: 'warning'
    });
  }

  if (error == false) {
    $('#kyc-' + id_result).html('');
    $('#kyc-' + id_result + '-msg').html('');
    axios.get("/panel/kc-control-desk/kc/" + history_id + "/" + param + "/" + param2 + "/" + type + "/validate").then(function (response) {
      var result = response.data;
      $('#kyc-' + id_result).html(result.html);
      $('#kyc-' + id_result + '-msg').val(result.msg);
    })["catch"](function (e) {});
  }
};

window.showKycCurp = function (type) {
  var params = {
    1: 'curp',
    2: 'ine',
    3: 'rfc',
    4: 'issste'
  };
  var id = params[type];
  var msg = $('#kyc-' + id + '-msg').val();
  $('#kyc-msg').html(msg);
  $('#modal-kyc').modal('show');
};

window.deliverysendEmail = function (history_id) {
  axios.get("/panel/kc-delivery/" + history_id + "/send-email").then(function (response) {
    window.location = '/panel/template/steps/delivery/' + history_id + '/show';
  })["catch"](function (e) {});
};

window.modalReference = function (history_id, reference_id) {
  $('#modal_history_id').val(history_id);
  $('#modal_reference_id').val(reference_id);

  if (reference_id != null) {
    axios.get("/panel/reference/" + reference_id + "/show").then(function (response) {
      var result = response.data;
      $('#last_name').val(result.last_name);
      $('#second_lastname').val(result.second_lastname);
      $('#names').val(result.names);
      $('#relationship').val(result.relationship);
      $('#relationship_time_years').val(result.relationship_time_years);
      $('#relationship_time_months').val(result.relationship_time_months);
      $('#cel_phone').val(result.cel_phone);
      $('#local_phone').val(result.local_phone);
      $('#contact_time').val(result.contact_time);
      $('#postal_code').val(result.postal_code);
      $('#street').val(result.street);
      $('#home_external_number').val(result.home_external_number);
      $('#home_internal_number').val(result.home_internal_number);
      $('#colony').val(result.colony);
      $('#city').val(result.city);
      $('#state').val(result.state);
      $('#country').val(result.country);
      $('#note').val(result.note);
    })["catch"](function (e) {});
  }

  $('#modal-reference').modal('show');
};

window.swapCreditContinue = function (history_id) {
  var url_redirect = null;

  if (document.getElementById('url_redirect')) {
    url_redirect = $('#url_redirect').val();
  }

  axios.get("/panel/kc-swap/credit/" + history_id + "/continue").then(function (response) {
    var result = response.data;

    if (url_redirect == null) {
      window.history.back();
    }

    window.location = url_redirect;
  })["catch"](function (e) {});
};

/***/ }),

/***/ "./resources/js/components/notification/utilities.js":
/*!***********************************************************!*\
  !*** ./resources/js/components/notification/utilities.js ***!
  \***********************************************************/
/***/ (() => {

window.showNotification = function () {
  $('#content-notification').html('');
  $('#icon-status-notification').removeClass('icon-status-off');
  $('#icon-status-notification').removeClass('icon-status-info');
  axios.get("/panel/notification/show").then(function (response) {
    var result = response.data;
    var is_notification = result.is_notification;
    $('#content-notification').html(result.list);

    if (is_notification == 1) {
      $('#icon-status-notification').addClass('icon-status-info');
    } else {
      $('#icon-status-notification').addClass('icon-status-off');
    }
  })["catch"](function (e) {});
};

window.readAllNotification = function () {
  $('#icon-status-notification').removeClass('icon-status-info');
  axios.get("/panel/notification/read").then(function (response) {
    var result = response.data;
    $('#icon-status-notification').addClass('icon-status-off');
  })["catch"](function (e) {});
};

$().ready(function () {
  showNotification();
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
    var result = response.data; //$('#c_product_id option[value="' + result.c_product_id + '"]').attr("selected", "selected");

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
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/product/list/show',
    columns: [{
      data: 'alias'
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

/***/ "./resources/js/components/tag/crud.js":
/*!*********************************************!*\
  !*** ./resources/js/components/tag/crud.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");

$().ready(function () {
  $("#frm-tag").validate({
    rules: {
      'data[name]': {
        required: true
      },
      'data[type_id]': {
        required: true
      },
      'data[section_id]': {
        required: true
      },
      'data[status]': {
        required: true
      }
    },
    submitHandler: function submitHandler(form, event) {
      event.preventDefault();
      $('#frm-tag-name-unique-error').html('');
      $('#frm-tag-name-unique-error').hide();
      var new_form = document.getElementById("frm-tag");
      var data = new FormData(new_form);
      axios.post("/panel/tag", data).then(function (response) {
        window.location = '/panel/tag';
      })["catch"](function (e) {
        var response = e.response;
        var data_errors = response.data.errors;
        $('#frm-tag-name-unique-error').html('Este campo ya se encuentra registrado.');
        $('#frm-tag-name-unique-error').show();
      });
    }
  });

  if (document.getElementById('frm-tag') && $('#tag_id').val() != null) {
    var tag_id = $('#tag_id').val();
    axios.get("/panel/tag/" + tag_id).then(function (response) {
      var result = response.data;
      $('#frm-tag-name').val(result.name);
      $('#frm-tag-type_id').val(result.type_id);
      $('#frm-tag-type_id').trigger("change");
      $('#frm-tag-section_id').val(result.section_id);
      $('#frm-tag-section_id').trigger("change");
      $('#frm-tag-comment').val(result.name);
      $('#frm-tag-status option[value="' + result.status + '"]').attr("selected", "selected");
    })["catch"](function (e) {});
  }
});

window.deleteTag = function (id) {
  axios["delete"]("/panel/tag/" + id).then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-tag', 'Datos actualizados', 'Registro guardado');
  })["catch"](function (e) {});
};

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
};

/***/ }),

/***/ "./resources/js/components/tag/datatable.js":
/*!**************************************************!*\
  !*** ./resources/js/components/tag/datatable.js ***!
  \**************************************************/
/***/ (() => {

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

document.addEventListener('DOMContentLoaded', function () {
  var _NioApp$DataTable;

  var table = NioApp.DataTable('#dt-tag', (_NioApp$DataTable = {
    processing: true,
    ajax: '/panel/tag/list/show'
  }, _defineProperty(_NioApp$DataTable, "processing", true), _defineProperty(_NioApp$DataTable, "responsive", {
    details: {
      renderer: function renderer(api, rowIdx, columns) {
        var total = columns.length - 1;
        var data = $.map(columns, function (col, i) {
          if (total == i) {
            return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
          } else {
            return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
          }
        }).join('');
        return data ? $('<table/>').append(data) : false;
      }
    }
  }), _defineProperty(_NioApp$DataTable, "columns", [{
    data: 'name'
  }, {
    data: 'type'
  }, {
    data: 'section'
  }, {
    data: 'description'
  }, {
    data: 'status'
  }, {
    data: 'options'
  }]), _defineProperty(_NioApp$DataTable, "columnDefs", [{
    className: "nk-tb-col",
    targets: "_all"
  }]), _defineProperty(_NioApp$DataTable, "createdRow", function createdRow(row, data, dataIndex) {
    $(row).addClass("nk-tb-item");
  }), _NioApp$DataTable));
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
      ui: 'is-dark',
      timeOut: 10000
    });
  };
  /* toast */

  /*   window.openToast = function (title, body, class_toast, subtitle) {
      $.toast({
        type: class_toast,
        title: title,
        subtitle: subtitle,
        content: body,
        delay: 5000,
        
        
    });
    } */

  /* var toastTrigger = document.getElementsByClassName('toasts')
  var toastLiveExample = document.getElementById('liveToast')
  var toast = new bootstrap.Toast(toastLiveExample) */

})(NioApp, jQuery);

$(document).ready(function () {
  $(".toast").toast({
    autohide: false
  });
});

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

  if (document.getElementById('frmadmin')) {
    $('#frmadmin').trigger("reset");
    $('#financial_id').val("").trigger("change");
    ;
  }

  if (document.getElementById('frmfinanciera')) {
    $('#frmfinanciera').trigger("reset");
  }

  if (document.getElementById('frm-inversionista')) {
    $('#frm-inversionista').trigger("reset");
  }

  if (type === 1) {
    $('#user-admin-title').html('Crear usuario ' + title);
    $('#content-password').show();
    $('#content-pass_confirm').show();
    $('#user_id').val(null);
    $('#type_user').val(route_datatable);
  } else {
    var lbluser = route_datatable;

    if (route_datatable == 'cliente-financiera') {
      lbluser = 'cliente financiera';
    }

    if (route_datatable == 'cliente-persona') {
      lbluser = 'cliente persona';
    }

    $('#user-admin-title').html('Editar usuario ' + lbluser);
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
    var data = response.data;
    var result = data.user;
    var agreements = data.agreements;
    $('#agreements').val(null).trigger('change');

    if (document.getElementById('rol') != '') {
      //*limpiar los valores razon social
      var type_person = result.type_person;
      $('#financial_id').val(result.financial_id).trigger("change");
      $('#type_person option[value="' + result.type_person + '"]').attr("selected", "selected");
      $('#rol_id option[value="' + result.rol_id + '"]').attr("selected", "selected");
    } //TODO: borrar si todo funciona en pruebas

    /* if (document.getElementById('type_person')) {
        $('#financial_id option[value="'+result.financial_id+'"]').attr("selected", "selected");
        $('#type_person option[value="'+result.type_person+'"]').attr("selected", "selected");
    } */


    $('#name').val(result.name);
    $('#last_name').val(result.last_name);
    $('#second_last_name').val(result.second_last_name);
    $('#cellphone').val(result.cellphone);
    $('#email').val(result.email);
    $('#status option[value="' + result.status + '"]').attr("selected", "selected");

    if (result.agreement_id != '') {
      $('#agreement_id option[value="' + result.agreement_id + '"]').attr("selected", "selected");
      $('#bank_name').val(result.bank_name);
      $('#bank_card_number').val(result.bank_card_number);
      $('#bank_account_number').val(result.bank_account_number);
      $('#bank_clabe').val(result.bank_clabe);
      $('#bank_account_holder').val(result.bank_account_holder);
      $('#investment_bank_name').val(result.investment_bank_name);
      $('#investment_bank_account_holder').val(result.investment_bank_account_holder);
      $('#investment_bank_account_number').val(result.investment_bank_account_number);
      $('#investment_bank_clabe').val(result.investment_bank_clabe);
    }

    $('#is_access_config option[value="' + result.is_access_config + '"]').attr("selected", "selected");

    if (document.getElementById('financial_products_id')) {
      var financial_products_id = result.financial_products_id.split(',');
      $('#financial_products_id').val(financial_products_id).trigger('change');
    }

    if (document.getElementById('agreements')) {
      // Itera sobre periodicities y selecciona las opciones en product_periodicity_id
      var agreementValues = agreements.map(function (item) {
        return item.agreement_id;
      }); // Seleccionar los valores correspondientes en los selects

      $('#agreements').val(agreementValues).trigger('change');
    }
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
  if (document.getElementById('frmfinanciera')) {
    $('#financial_id').select2({
      dropdownParent: $('#modal-user-admin'),
      placeholder: "Escribe para buscar..",
      allowClear: true
    });
  }

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
      financial_id: {
        required: true
      },
      type_person: {
        required: true
      },
      rol_id: {
        required: true
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
      })["catch"](function (e) {
        var response = e.response;
        var errors = response.data.errors;

        if (errors.email) {
          $('#admin_email-error-exist').show();
        }

        console.log(e.response);
      });
    }
  });
  $("#frm-inversionista").validate({
    rules: {
      financial_products_id: {
        required: true
      },
      type_person: {
        required: true
      },
      rol_id: {
        required: true
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
      var new_form = document.getElementById("frm-inversionista");
      var data = new FormData(new_form);
      axios.post("/panel/user/administrador", data).then(function (response) {
        var result = response.data;
        (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-inversionista', 'Datos actualizados', 'Información actualizada correctamente');
        $('#modal-user-admin').modal('hide');
      })["catch"](function (e) {
        var response = e.response;
        var errors = response.data.errors;

        if (errors.email) {
          $('#admin_email-error-exist').show();
        }
      });
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

/***/ "./resources/js/components/user/datatable_admin.js":
/*!*********************************************************!*\
  !*** ./resources/js/components/user/datatable_admin.js ***!
  \*********************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var route = $('#route_datatable').val();
  var table = NioApp.DataTable('#dt-admin', {
    processing: true,
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
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
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
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

/***/ "./resources/js/components/user/datatable_inversionista.js":
/*!*****************************************************************!*\
  !*** ./resources/js/components/user/datatable_inversionista.js ***!
  \*****************************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var route = $('#route_datatable').val();
  var table = NioApp.DataTable('#dt-inversionista', {
    processing: true,
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/user/' + route + '/list/show',
    columns: [{
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

/***/ "./resources/js/components/user/datatable_user.js":
/*!********************************************************!*\
  !*** ./resources/js/components/user/datatable_user.js ***!
  \********************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', function () {
  var queryParam = new URLSearchParams(window.location.search).get('query');
  var table = NioApp.DataTable('#dt-search-user', {
    processing: true,
    searching: false,
    responsive: {
      details: {
        renderer: function renderer(api, rowIdx, columns) {
          var total = columns.length - 1;
          var data = $.map(columns, function (col, i) {
            if (total == i) {
              return col.hidden ? '<tr class="py-3 " colspan="2">' + '<td class="">' + col.data + '</td>' + '</tr>' : '';
            } else {
              return col.hidden ? '<tr class="py-3" data-dt-row="' + col.rowIndex + '">' + '<td class="px-3 "><strong>' + col.title + '</strong></td> ' + '<td class="w-100">' + col.data + '</td>' + '</tr>' : '';
            }
          }).join('');
          return data ? $('<table/>').append(data) : false;
        }
      }
    },
    ajax: '/panel/user/search?query=' + queryParam,
    columns: [{
      data: 'id'
    }, {
      data: 'name'
    }, {
      data: 'cellphone'
    }, {
      data: 'origin'
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

window.showNotes = function (id_rel, is_lead) {
  var model = is_lead == true ? 'lead' : 'credit';
  axios.get('/panel/' + model + '/' + id_rel + '/notes/list').then(function (response) {
    var result = response.data;
    $('#content-notes').html(result.notes);
    $('#addNote').html(result.addNote);
    $('#modal-list-note').modal('show');
  })["catch"](function (e) {});
};

window.AddNoteIntoNotes = function (note_id, model_note) {
  $('#modal-list-note').modal('hide');
  $('#id_rel').val(note_id);
  $('#model_note').val(model_note);
  $('#modal-lead-description').val('');
  $('#modal-note').modal('show');
};

window.showModalActions = function (lead_id, is_lead) {
  var model = is_lead == true ? 'lead' : 'credit';
  $('#id-rel-action').val(lead_id);
  $('#model-action').val(model);
  refreshAction(lead_id, model, 'in_progress', 'content-profile-in_progress');
  refreshAction(lead_id, model, 'completed', 'content-profile-completed');
  $('#modal-list-actions').modal('show');
  var addAction = '<a class="pointer" onclick="addActionIntoActions(' + lead_id + ', true, ' + is_lead + ')"><em class="icon ni ni-calendar-check-fill"></em><span>Agregar acción</span></a>';
  $('#addActions').html(addAction);
};
/* window.searchClient = function (event)
{
    if (event.key === 'Enter') {
        //event.preventDefault();
        let query = $('#query').val();
        axios
            .post('/panel/user/search', {query:query})
            .then(function (response) {
                let result = response.data;
                console.log(result);
            })
            .catch(e => {
                
            });
    }
} */

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
      var toast = element.toast;
      $('#content-toast').empty().append(toast);
    }

    $(".toast").toast({
      autohide: false
    });
    $(".toast").toast("show");
    showNotification();
  });
});

/***/ }),

/***/ "./node_modules/rfc-facil/dist/rfc-facil.es5.js":
/*!******************************************************!*\
  !*** ./node_modules/rfc-facil/dist/rfc-facil.es5.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var map = {
    ' ': '00',
    '0': '00',
    '1': '01',
    '2': '02',
    '3': '03',
    '4': '04',
    '5': '05',
    '6': '06',
    '7': '07',
    '8': '08',
    '9': '09',
    '&': '10',
    A: '11',
    B: '12',
    C: '13',
    D: '14',
    E: '15',
    F: '16',
    G: '17',
    H: '18',
    I: '19',
    J: '21',
    K: '22',
    L: '23',
    M: '24',
    N: '25',
    O: '26',
    P: '27',
    Q: '28',
    R: '29',
    S: '32',
    T: '33',
    U: '34',
    V: '35',
    W: '36',
    X: '37',
    Y: '38',
    Z: '39',
    Ñ: '40'
};
var digits = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
function calculate(fullName) {
    var mappedFullName = '0' +
        normalize(fullName)
            .split('')
            .map(mapCharacterToTwoDigitsCode)
            .join('');
    var sum = sumPairsOfDigits(mappedFullName);
    var lastThreeDigits = sum % 1000;
    var quo = lastThreeDigits / 34;
    var reminder = lastThreeDigits % 34;
    return digits.charAt(quo) + digits.charAt(reminder);
}
// remove accents without removing the Ñ (u0303)
// and remove special characters: .'-,
function normalize(input) {
    return input
        .toUpperCase()
        .normalize('NFD')
        .replace(/[\u0300-\u0302]/g, '')
        .replace(/[\u0304-\u036f]/g, '')
        .replace(/N\u0303/g, 'Ñ')
        .replace(/[-\.',]/g, ''); // remove .'-,
}
function sumPairsOfDigits(input) {
    var sum = 0;
    for (var i = 0; i < input.length - 1; i++) {
        var firstPair = parseInt(input.substring(i, i + 2), 10);
        var secondPair = parseInt(input.substring(i + 1, i + 2), 10);
        sum += firstPair * secondPair;
    }
    return sum;
}
function mapCharacterToTwoDigitsCode(c) {
    var m = map[c];
    if (!m) {
        throw Error("No two-digit code mapping for char " + c);
    }
    return m;
}

var map$1 = {
    '0': 0,
    '1': 1,
    '2': 2,
    '3': 3,
    '4': 4,
    '5': 5,
    '6': 6,
    '7': 7,
    '8': 8,
    '9': 9,
    A: 10,
    B: 11,
    C: 12,
    D: 13,
    E: 14,
    F: 15,
    G: 16,
    H: 17,
    I: 18,
    J: 19,
    K: 20,
    L: 21,
    M: 22,
    N: 23,
    '&': 24,
    O: 25,
    P: 26,
    Q: 27,
    R: 28,
    S: 29,
    T: 30,
    U: 31,
    V: 32,
    W: 33,
    X: 34,
    Y: 35,
    Z: 36,
    ' ': 37,
    Ñ: 38
};
function calculate$1(rfc12Digits) {
    var sum = rfc12Digits
        .split('')
        .map(function (c) { return map$1[c.toUpperCase()] || 0; })
        .reduce(function (sum, current, index) { return sum + current * (13 - index); }, 0);
    var reminder = sum % 11;
    if (reminder === 0) {
        return '0';
    }
    else {
        return (11 - reminder).toString(16).toUpperCase(); // from 1 to A (hex)
    }
}

function dateCode(day, month, year) {
    return year.toString().slice(-2) + zeroPadded(month) + zeroPadded(day);
}
function zeroPadded(n) {
    return ('00' + n).slice(-2);
}

function removeAccents(input) {
    return input.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}

function naturalPersonTenDigitsCode(person) {
    return new NameCode(person).toString() + birthdayCode(person);
}
// matches any ocurrence of the special particles as a word: '^foo | foo | foo$''
var specialParticlesRegex = new RegExp('(?:' +
    ['DE', 'LA', 'LAS', 'MC', 'VON', 'DEL', 'LOS', 'Y', 'MAC', 'VAN', 'MI']
        .map(function (p) { return "^" + p + " | " + p + " | " + p + "$"; })
        .join('|') +
    ')', 'g');
function birthdayCode(person) {
    return dateCode(person.day, person.month, person.year);
}
var NameCode = /** @class */ (function () {
    function NameCode(person) {
        this.person = person;
        this.filteredPersonName = this.getFilteredPersonName();
    }
    NameCode.prototype.toString = function () {
        return this.obfuscateForbiddenWords(this.calculateCode());
    };
    NameCode.prototype.calculateCode = function () {
        if (this.isEmpty(this.person.firstLastName)) {
            return (this.normalize(this.person.secondLastName).substring(0, 2) +
                this.filteredPersonName.substring(0, 2));
        }
        else if (this.isEmpty(this.person.secondLastName)) {
            return (this.normalize(this.person.firstLastName).substring(0, 2) +
                this.filteredPersonName.substring(0, 2));
        }
        else if (this.isFirstLastNameIsTooShort()) {
            return (this.normalize(this.person.firstLastName).charAt(0) +
                this.normalize(this.person.secondLastName).charAt(0) +
                this.filteredPersonName.substring(0, 2));
        }
        else {
            return (this.normalize(this.person.firstLastName).charAt(0) +
                this.firstVowelExcludingFirstCharacterOf(this.normalize(this.person.firstLastName)) +
                this.normalize(this.person.secondLastName).charAt(0) +
                this.filteredPersonName.charAt(0));
        }
    };
    NameCode.prototype.obfuscateForbiddenWords = function (s) {
        var match = s.match(/(BUE[IY]|CAC[AO]|CAGA|KOGE|KAKA|MAME|KOJO|[KQ]ULO|CAGO|CO[GJ]E|COJO|FETO|JOTO|KA[CG]O)/) || s.match(/(MAMO|MEAR|M[EI]ON|MOCO|MULA|PED[AO]|PENE|PUT[AO]|RATA|RUIN)/);
        return match ? s.substring(0, 3) + 'X' : s;
    };
    // filter out common names (if more than one is provided)
    NameCode.prototype.getFilteredPersonName = function () {
        var normalized = this.normalize(this.person.name);
        if (this.person.name.split(' ').length > 1) {
            return normalized.replace(/^(JOSE|MARIA|MA|MA\.)\s+/i, '');
        }
        return normalized;
    };
    NameCode.prototype.normalize = function (s) {
        return removeAccents(s.toUpperCase())
            .replace(/\s+/g, '  ') // double space to allow multiple special-particles matching
            .replace(specialParticlesRegex, '')
            .replace(/\s+/g, ' ') // reset space
            .trim();
    };
    NameCode.prototype.firstVowelExcludingFirstCharacterOf = function (s) {
        var result = /[aeiou]/i.exec(s.slice(1));
        if (!result) {
            throw new Error('');
        }
        return result[0];
    };
    NameCode.prototype.isFirstLastNameIsTooShort = function () {
        return this.normalize(this.person.firstLastName).length <= 2;
    };
    NameCode.prototype.isEmpty = function (s) {
        return s === null || typeof s === 'undefined' || this.normalize(s).length === 0;
    };
    return NameCode;
}());

function createCommonjsModule(fn, module) {
	return module = { exports: {} }, fn(module, module.exports), module.exports;
}

/**
 * Merges a set of default keys with a target object
 * (Like _.defaults, but will also extend onto null/undefined)
 *
 * @param {Object} [target] The object to extend
 * @param {Object} defaults The object to default to
 * @return {Object} extendedTarget
 */

function defaults(target, defs) {
  if (target == null) target = {};
  var ret = {};
  var keys = Object.keys(defs);
  for (var i = 0, len = keys.length; i < len; i++) {
    var key = keys[i];
    ret[key] = target[key] || defs[key];
  }
  return ret;
}
var defaults_1 = defaults;

var util = {
	defaults: defaults_1
};

var util$1 = /*#__PURE__*/Object.freeze({
  default: util,
  __moduleExports: util,
  defaults: defaults_1
});

var useLongScale = false;
var baseSeparator = "-";
var unitSeparator = "and ";
var base = {
	"0": "zero",
	"1": "one",
	"2": "two",
	"3": "three",
	"4": "four",
	"5": "five",
	"6": "six",
	"7": "seven",
	"8": "eight",
	"9": "nine",
	"10": "ten",
	"11": "eleven",
	"12": "twelve",
	"13": "thirteen",
	"14": "fourteen",
	"15": "fifteen",
	"16": "sixteen",
	"17": "seventeen",
	"18": "eighteen",
	"19": "nineteen",
	"20": "twenty",
	"30": "thirty",
	"40": "forty",
	"50": "fifty",
	"60": "sixty",
	"70": "seventy",
	"80": "eighty",
	"90": "ninety"
};
var units = [
	"hundred",
	"thousand",
	"million",
	"billion",
	"trillion",
	"quadrillion",
	"quintillion",
	"sextillion",
	"septillion",
	"octillion",
	"nonillion",
	"decillion",
	"undecillion",
	"duodecillion",
	"tredecillion",
	"quattuordecillion",
	"quindecillion"
];
var unitExceptions = [
];
var en = {
	useLongScale: useLongScale,
	baseSeparator: baseSeparator,
	unitSeparator: unitSeparator,
	base: base,
	units: units,
	unitExceptions: unitExceptions
};

var en$1 = /*#__PURE__*/Object.freeze({
  useLongScale: useLongScale,
  baseSeparator: baseSeparator,
  unitSeparator: unitSeparator,
  base: base,
  units: units,
  unitExceptions: unitExceptions,
  default: en
});

var useLongScale$1 = true;
var baseSeparator$1 = " y ";
var unitSeparator$1 = "";
var base$1 = {
	"0": "cero",
	"1": "uno",
	"2": "dos",
	"3": "tres",
	"4": "cuatro",
	"5": "cinco",
	"6": "seis",
	"7": "siete",
	"8": "ocho",
	"9": "nueve",
	"10": "diez",
	"11": "once",
	"12": "doce",
	"13": "trece",
	"14": "catorce",
	"15": "quince",
	"16": "dieciséis",
	"17": "diecisiete",
	"18": "dieciocho",
	"19": "diecinueve",
	"20": "veinte",
	"21": "veintiuno",
	"22": "veintidós",
	"23": "veintitrés",
	"24": "veinticuatro",
	"25": "veinticinco",
	"26": "veintiséis",
	"27": "veintisiete",
	"28": "veintiocho",
	"29": "veintinueve",
	"30": "treinta",
	"40": "cuarenta",
	"50": "cincuenta",
	"60": "sesenta",
	"70": "setenta",
	"80": "ochenta",
	"90": "noventa",
	"100": "cien",
	"200": "doscientos",
	"300": "trescientos",
	"400": "cuatrocientos",
	"500": "quinientos",
	"600": "seiscientos",
	"700": "setecientos",
	"800": "ochocientos",
	"900": "novecientos",
	"1000": "mil"
};
var unitExceptions$1 = {
	"1": "un"
};
var units$1 = [
	{
		singular: "ciento",
		useBaseInstead: true,
		useBaseException: [
			1
		]
	},
	{
		singular: "mil",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "millón",
		plural: "millones"
	},
	{
		singular: "billón",
		plural: "billones"
	},
	{
		singular: "trillón",
		plural: "trillones"
	},
	{
		singular: "cuatrillón",
		plural: "cuatrillones"
	},
	{
		singular: "quintillón",
		plural: "quintillones"
	},
	{
		singular: "sextillón",
		plural: "sextillones"
	},
	{
		singular: "septillón",
		plural: "septillones"
	},
	{
		singular: "octillón",
		plural: "octillones"
	},
	{
		singular: "nonillón",
		plural: "nonillones"
	},
	{
		singular: "decillón",
		plural: "decillones"
	},
	{
		singular: "undecillón",
		plural: "undecillones"
	},
	{
		singular: "duodecillón",
		plural: "duodecillones"
	},
	{
		singular: "tredecillón",
		plural: "tredecillones"
	},
	{
		singular: "cuatrodecillón",
		plural: "cuatrodecillones"
	},
	{
		singular: "quindecillón",
		plural: "quindecillones"
	}
];
var es = {
	useLongScale: useLongScale$1,
	baseSeparator: baseSeparator$1,
	unitSeparator: unitSeparator$1,
	base: base$1,
	unitExceptions: unitExceptions$1,
	units: units$1
};

var es$1 = /*#__PURE__*/Object.freeze({
  useLongScale: useLongScale$1,
  baseSeparator: baseSeparator$1,
  unitSeparator: unitSeparator$1,
  base: base$1,
  unitExceptions: unitExceptions$1,
  units: units$1,
  default: es
});

var useLongScale$2 = false;
var baseSeparator$2 = " e ";
var unitSeparator$2 = "e ";
var andWhenTrailing = true;
var base$2 = {
	"0": "zero",
	"1": "um",
	"2": "dois",
	"3": "três",
	"4": "quatro",
	"5": "cinco",
	"6": "seis",
	"7": "sete",
	"8": "oito",
	"9": "nove",
	"10": "dez",
	"11": "onze",
	"12": "doze",
	"13": "treze",
	"14": "catorze",
	"15": "quinze",
	"16": "dezesseis",
	"17": "dezessete",
	"18": "dezoito",
	"19": "dezenove",
	"20": "vinte",
	"30": "trinta",
	"40": "quarenta",
	"50": "cinquenta",
	"60": "sessenta",
	"70": "setenta",
	"80": "oitenta",
	"90": "noventa",
	"100": "cem",
	"200": "duzentos",
	"300": "trezentos",
	"400": "quatrocentos",
	"500": "quinhentos",
	"600": "seiscentos",
	"700": "setecentos",
	"800": "oitocentos",
	"900": "novecentos",
	"1000": "mil"
};
var unitExceptions$2 = {
	"1": "um"
};
var units$2 = [
	{
		singular: "cento",
		useBaseInstead: true,
		useBaseException: [
			1
		],
		useBaseExceptionWhenNoTrailingNumbers: true,
		andException: true
	},
	{
		singular: "mil",
		avoidPrefixException: [
			1
		],
		andException: true
	},
	{
		singular: "milhão",
		plural: "milhões"
	},
	{
		singular: "bilhão",
		plural: "bilhões"
	},
	{
		singular: "trilhão",
		plural: "trilhões"
	},
	{
		singular: "quadrilhão",
		plural: "quadrilhão"
	},
	{
		singular: "quintilhão",
		plural: "quintilhões"
	},
	{
		singular: "sextilhão",
		plural: "sextilhões"
	},
	{
		singular: "septilhão",
		plural: "septilhões"
	},
	{
		singular: "octilhão",
		plural: "octilhões"
	},
	{
		singular: "nonilhão",
		plural: "nonilhões"
	},
	{
		singular: "decilhão",
		plural: "decilhões"
	},
	{
		singular: "undecilhão",
		plural: "undecilhões"
	},
	{
		singular: "doudecilhão",
		plural: "doudecilhões"
	},
	{
		singular: "tredecilhão",
		plural: "tredecilhões"
	}
];
var pt = {
	useLongScale: useLongScale$2,
	baseSeparator: baseSeparator$2,
	unitSeparator: unitSeparator$2,
	andWhenTrailing: andWhenTrailing,
	base: base$2,
	unitExceptions: unitExceptions$2,
	units: units$2
};

var pt$1 = /*#__PURE__*/Object.freeze({
  useLongScale: useLongScale$2,
  baseSeparator: baseSeparator$2,
  unitSeparator: unitSeparator$2,
  andWhenTrailing: andWhenTrailing,
  base: base$2,
  unitExceptions: unitExceptions$2,
  units: units$2,
  default: pt
});

var useLongScale$3 = true;
var baseSeparator$3 = " e ";
var unitSeparator$3 = "e ";
var andWhenTrailing$1 = true;
var base$3 = {
	"0": "zero",
	"1": "um",
	"2": "dois",
	"3": "três",
	"4": "quatro",
	"5": "cinco",
	"6": "seis",
	"7": "sete",
	"8": "oito",
	"9": "nove",
	"10": "dez",
	"11": "onze",
	"12": "doze",
	"13": "treze",
	"14": "catorze",
	"15": "quinze",
	"16": "dezasseis",
	"17": "dezassete",
	"18": "dezoito",
	"19": "dezanove",
	"20": "vinte",
	"30": "trinta",
	"40": "quarenta",
	"50": "cinquenta",
	"60": "sessenta",
	"70": "setenta",
	"80": "oitenta",
	"90": "noventa",
	"100": "cem",
	"200": "duzentos",
	"300": "trezentos",
	"400": "quatrocentos",
	"500": "quinhentos",
	"600": "seiscentos",
	"700": "setecentos",
	"800": "oitocentos",
	"900": "novecentos",
	"1000": "mil"
};
var unitExceptions$3 = {
	"1": "um"
};
var units$3 = [
	{
		singular: "cento",
		useBaseInstead: true,
		useBaseException: [
			1
		],
		useBaseExceptionWhenNoTrailingNumbers: true,
		andException: true
	},
	{
		singular: "mil",
		avoidPrefixException: [
			1
		],
		andException: true
	},
	{
		singular: "milhão",
		plural: "milhões"
	},
	{
		singular: "bilião",
		plural: "biliões"
	},
	{
		singular: "trilião",
		plural: "triliões"
	},
	{
		singular: "quadrilião",
		plural: "quadriliões"
	},
	{
		singular: "quintilião",
		plural: "quintiliões"
	},
	{
		singular: "sextilião",
		plural: "sextiliões"
	},
	{
		singular: "septilião",
		plural: "septiliões"
	},
	{
		singular: "octilião",
		plural: "octiliões"
	},
	{
		singular: "nonilião",
		plural: "noniliões"
	},
	{
		singular: "decilião",
		plural: "deciliões"
	}
];
var ptPT = {
	useLongScale: useLongScale$3,
	baseSeparator: baseSeparator$3,
	unitSeparator: unitSeparator$3,
	andWhenTrailing: andWhenTrailing$1,
	base: base$3,
	unitExceptions: unitExceptions$3,
	units: units$3
};

var ptPT$1 = /*#__PURE__*/Object.freeze({
  useLongScale: useLongScale$3,
  baseSeparator: baseSeparator$3,
  unitSeparator: unitSeparator$3,
  andWhenTrailing: andWhenTrailing$1,
  base: base$3,
  unitExceptions: unitExceptions$3,
  units: units$3,
  default: ptPT
});

var useLongScale$4 = false;
var baseSeparator$4 = "-";
var unitSeparator$4 = "";
var base$4 = {
	"0": "zéro",
	"1": "un",
	"2": "deux",
	"3": "trois",
	"4": "quatre",
	"5": "cinq",
	"6": "six",
	"7": "sept",
	"8": "huit",
	"9": "neuf",
	"10": "dix",
	"11": "onze",
	"12": "douze",
	"13": "treize",
	"14": "quatorze",
	"15": "quinze",
	"16": "seize",
	"17": "dix-sept",
	"18": "dix-huit",
	"19": "dix-neuf",
	"20": "vingt",
	"30": "trente",
	"40": "quarante",
	"50": "cinquante",
	"60": "soixante",
	"70": "soixante-dix",
	"80": "quatre-vingt",
	"90": "quatre-vingt-dix"
};
var units$4 = [
	{
		singular: "cent",
		plural: "cents",
		avoidInNumberPlural: true,
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "mille",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "million",
		plural: "millions"
	},
	{
		singular: "milliard",
		plural: "milliards"
	},
	{
		singular: "billion",
		plural: "billions"
	},
	{
		singular: "billiard",
		plural: "billiards"
	},
	{
		singular: "trillion",
		plural: "trillions"
	},
	{
		singular: "trilliard",
		plural: "trilliards"
	},
	{
		singular: "quadrillion",
		plural: "quadrillions"
	},
	{
		singular: "quadrilliard",
		plural: "quadrilliards"
	},
	{
		singular: "quintillion",
		plural: "quintillions"
	},
	{
		singular: "quintilliard",
		plural: "quintilliards"
	},
	{
		singular: "sextillion",
		plural: "sextillions"
	},
	{
		singular: "sextilliard",
		plural: "sextilliards"
	},
	{
		singular: "septillion",
		plural: "septillions"
	},
	{
		singular: "septilliard",
		plural: "septilliards"
	},
	{
		singular: "octillion",
		plural: "octillions"
	}
];
var unitExceptions$4 = {
	"71": "soixante et onze",
	"72": "soixante-douze",
	"73": "soixante-treize",
	"74": "soixante-quatorze",
	"75": "soixante-quinze",
	"76": "soixante-seize",
	"77": "soixante-dix-sept",
	"78": "soixante-dix-huit",
	"79": "soixante-dix-neuf",
	"80": "quatre-vingts",
	"91": "quatre-vingt-onze",
	"92": "quatre-vingt-douze",
	"93": "quatre-vingt-treize",
	"94": "quatre-vingt-quatorze",
	"95": "quatre-vingt-quinze",
	"96": "quatre-vingt-seize",
	"97": "quatre-vingt-dix-sept",
	"98": "quatre-vingt-dix-huit",
	"99": "quatre-vingt-dix-neuf"
};
var fr = {
	useLongScale: useLongScale$4,
	baseSeparator: baseSeparator$4,
	unitSeparator: unitSeparator$4,
	base: base$4,
	units: units$4,
	unitExceptions: unitExceptions$4
};

var fr$1 = /*#__PURE__*/Object.freeze({
  useLongScale: useLongScale$4,
  baseSeparator: baseSeparator$4,
  unitSeparator: unitSeparator$4,
  base: base$4,
  units: units$4,
  unitExceptions: unitExceptions$4,
  default: fr
});

var useLongScale$5 = false;
var baseSeparator$5 = " ";
var unitSeparator$5 = "";
var base$5 = {
	"0": "nulo",
	"1": "unu",
	"2": "du",
	"3": "tri",
	"4": "kvar",
	"5": "kvin",
	"6": "ses",
	"7": "sep",
	"8": "ok",
	"9": "naŭ",
	"10": "dek",
	"20": "dudek",
	"30": "tridek",
	"40": "kvardek",
	"50": "kvindek",
	"60": "sesdek",
	"70": "sepdek",
	"80": "okdek",
	"90": "naŭdek",
	"100": "cent",
	"200": "ducent",
	"300": "tricent",
	"400": "kvarcent",
	"500": "kvincent",
	"600": "sescent",
	"700": "sepcent",
	"800": "okcent",
	"900": "naŭcent"
};
var units$5 = [
	{
		useBaseInstead: true,
		useBaseException: [
		]
	},
	{
		singular: "mil",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "miliono",
		plural: "milionoj",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "miliardo",
		plural: "miliardoj",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "biliono",
		plural: "bilionoj",
		avoidPrefixException: [
			1
		]
	}
];
var unitExceptions$5 = [
];
var eo = {
	useLongScale: useLongScale$5,
	baseSeparator: baseSeparator$5,
	unitSeparator: unitSeparator$5,
	base: base$5,
	units: units$5,
	unitExceptions: unitExceptions$5
};

var eo$1 = /*#__PURE__*/Object.freeze({
  useLongScale: useLongScale$5,
  baseSeparator: baseSeparator$5,
  unitSeparator: unitSeparator$5,
  base: base$5,
  units: units$5,
  unitExceptions: unitExceptions$5,
  default: eo
});

var useLongScale$6 = false;
var baseSeparator$6 = "";
var unitSeparator$6 = "";
var generalSeparator = "";
var wordSeparator = "";
var base$6 = {
	"0": "zero",
	"1": "uno",
	"2": "due",
	"3": "tre",
	"4": "quattro",
	"5": "cinque",
	"6": "sei",
	"7": "sette",
	"8": "otto",
	"9": "nove",
	"10": "dieci",
	"11": "undici",
	"12": "dodici",
	"13": "tredici",
	"14": "quattordici",
	"15": "quindici",
	"16": "sedici",
	"17": "diciassette",
	"18": "diciotto",
	"19": "diciannove",
	"20": "venti",
	"21": "ventuno",
	"23": "ventitré",
	"28": "ventotto",
	"30": "trenta",
	"31": "trentuno",
	"33": "trentatré",
	"38": "trentotto",
	"40": "quaranta",
	"41": "quarantuno",
	"43": "quaranta­tré",
	"48": "quarantotto",
	"50": "cinquanta",
	"51": "cinquantuno",
	"53": "cinquantatré",
	"58": "cinquantotto",
	"60": "sessanta",
	"61": "sessantuno",
	"63": "sessanta­tré",
	"68": "sessantotto",
	"70": "settanta",
	"71": "settantuno",
	"73": "settantatré",
	"78": "settantotto",
	"80": "ottanta",
	"81": "ottantuno",
	"83": "ottantatré",
	"88": "ottantotto",
	"90": "novanta",
	"91": "novantuno",
	"93": "novantatré",
	"98": "novantotto",
	"100": "cento",
	"101": "centuno",
	"108": "centootto",
	"180": "centottanta",
	"201": "duecentuno",
	"301": "tre­cent­uno",
	"401": "quattro­cent­uno",
	"501": "cinque­cent­uno",
	"601": "sei­cent­uno",
	"701": "sette­cent­uno",
	"801": "otto­cent­uno",
	"901": "nove­cent­uno"
};
var unitExceptions$6 = {
	"1": "un"
};
var units$6 = [
	{
		singular: "cento",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "mille",
		plural: "mila",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "milione",
		plural: "milioni"
	},
	{
		singular: "miliardo",
		plural: "miliardi"
	},
	{
		singular: "bilione",
		plural: "bilioni"
	},
	{
		singular: "biliardo",
		plural: "biliardi"
	},
	{
		singular: "trilione",
		plural: "trilioni"
	},
	{
		singular: "triliardo",
		plural: "triliardi"
	},
	{
		singular: "quadrilione",
		plural: "quadrilioni"
	},
	{
		singular: "quadriliardo",
		plural: "quadriliardi"
	}
];
var it = {
	useLongScale: useLongScale$6,
	baseSeparator: baseSeparator$6,
	unitSeparator: unitSeparator$6,
	generalSeparator: generalSeparator,
	wordSeparator: wordSeparator,
	base: base$6,
	unitExceptions: unitExceptions$6,
	units: units$6
};

var it$1 = /*#__PURE__*/Object.freeze({
  useLongScale: useLongScale$6,
  baseSeparator: baseSeparator$6,
  unitSeparator: unitSeparator$6,
  generalSeparator: generalSeparator,
  wordSeparator: wordSeparator,
  base: base$6,
  unitExceptions: unitExceptions$6,
  units: units$6,
  default: it
});

var useLongScale$7 = false;
var baseSeparator$7 = " ";
var unitSeparator$7 = "và ";
var base$7 = {
	"0": "không",
	"1": "một",
	"2": "hai",
	"3": "ba",
	"4": "bốn",
	"5": "năm",
	"6": "sáu",
	"7": "bảy",
	"8": "tám",
	"9": "chín",
	"10": "mười",
	"15": "mười lăm",
	"20": "hai mươi",
	"21": "hai mươi mốt",
	"25": "hai mươi lăm",
	"30": "ba mươi",
	"31": "ba mươi mốt",
	"40": "bốn mươi",
	"41": "bốn mươi mốt",
	"45": "bốn mươi lăm",
	"50": "năm mươi",
	"51": "năm mươi mốt",
	"55": "năm mươi lăm",
	"60": "sáu mươi",
	"61": "sáu mươi mốt",
	"65": "sáu mươi lăm",
	"70": "bảy mươi",
	"71": "bảy mươi mốt",
	"75": "bảy mươi lăm",
	"80": "tám mươi",
	"81": "tám mươi mốt",
	"85": "tám mươi lăm",
	"90": "chín mươi",
	"91": "chín mươi mốt",
	"95": "chín mươi lăm"
};
var units$7 = [
	"trăm",
	"ngàn",
	"triệu",
	"tỷ",
	"nghìn tỷ"
];
var unitExceptions$7 = [
];
var vi = {
	useLongScale: useLongScale$7,
	baseSeparator: baseSeparator$7,
	unitSeparator: unitSeparator$7,
	base: base$7,
	units: units$7,
	unitExceptions: unitExceptions$7
};

var vi$1 = /*#__PURE__*/Object.freeze({
  useLongScale: useLongScale$7,
  baseSeparator: baseSeparator$7,
  unitSeparator: unitSeparator$7,
  base: base$7,
  units: units$7,
  unitExceptions: unitExceptions$7,
  default: vi
});

var useLongScale$8 = false;
var baseSeparator$8 = " ";
var unitSeparator$8 = "";
var base$8 = {
	"0": "sıfır",
	"1": "bir",
	"2": "iki",
	"3": "üç",
	"4": "dört",
	"5": "beş",
	"6": "altı",
	"7": "yedi",
	"8": "sekiz",
	"9": "dokuz",
	"10": "on",
	"20": "yirmi",
	"30": "otuz",
	"40": "kırk",
	"50": "elli",
	"60": "altmış",
	"70": "yetmiş",
	"80": "seksen",
	"90": "doksan"
};
var units$8 = [
	{
		singular: "yüz",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "bin",
		avoidPrefixException: [
			1
		]
	},
	"milyon",
	"milyar",
	"trilyon",
	"katrilyon",
	"kentilyon",
	"sekstilyon",
	"septilyon",
	"oktilyon",
	"nonilyon",
	"desilyon",
	"andesilyon",
	"dodesilyon",
	"tredesilyon",
	"katordesilyon",
	"kendesilyon"
];
var unitExceptions$8 = [
];
var tr = {
	useLongScale: useLongScale$8,
	baseSeparator: baseSeparator$8,
	unitSeparator: unitSeparator$8,
	base: base$8,
	units: units$8,
	unitExceptions: unitExceptions$8
};

var tr$1 = /*#__PURE__*/Object.freeze({
  useLongScale: useLongScale$8,
  baseSeparator: baseSeparator$8,
  unitSeparator: unitSeparator$8,
  base: base$8,
  units: units$8,
  unitExceptions: unitExceptions$8,
  default: tr
});

var useLongScale$9 = true;
var baseSeparator$9 = "";
var unitSeparator$9 = "és ";
var base$9 = {
	"0": "nulla",
	"1": "egy",
	"2": "kettő",
	"3": "három",
	"4": "négy",
	"5": "öt",
	"6": "hat",
	"7": "hét",
	"8": "nyolc",
	"9": "kilenc",
	"10": "tíz",
	"11": "tizenegy",
	"12": "tizenkettő",
	"13": "tizenhárom",
	"14": "tizennégy",
	"15": "tizenöt",
	"16": "tizenhat",
	"17": "tizenhét",
	"18": "tizennyolc",
	"19": "tizenkilenc",
	"20": "húsz",
	"21": "huszonegy",
	"22": "huszonkettő",
	"23": "huszonhárom",
	"24": "huszonnégy",
	"25": "huszonöt",
	"26": "huszonhat",
	"27": "huszonhét",
	"28": "huszonnyolc",
	"29": "huszonkilenc",
	"30": "harminc",
	"40": "negyven",
	"50": "ötven",
	"60": "hatvan",
	"70": "hetven",
	"80": "nyolcvan",
	"90": "kilencven",
	"100": "száz",
	"200": "kétszáz",
	"300": "háromszáz",
	"400": "négyszáz",
	"500": "ötszáz",
	"600": "hatszáz",
	"700": "hétszáz",
	"800": "nyolcszáz",
	"900": "kilencszáz",
	"1000": "ezer"
};
var unitExceptions$9 = {
	"1": "egy"
};
var units$9 = [
	{
		singular: "száz",
		useBaseInstead: true,
		useBaseException: [
			1
		]
	},
	{
		singular: "ezer",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "millió",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "milliárd",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "-billió",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "billiárd",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "trillió",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "trilliárd",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "kvadrillió",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "kvadrilliárd",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "kvintillió",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "kvintilliárd",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "szextillió",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "szeptillió",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "oktillió",
		avoidPrefixException: [
			1
		]
	},
	{
		singular: "nonillió",
		avoidPrefixException: [
			1
		]
	}
];
var hu = {
	useLongScale: useLongScale$9,
	baseSeparator: baseSeparator$9,
	unitSeparator: unitSeparator$9,
	base: base$9,
	unitExceptions: unitExceptions$9,
	units: units$9
};

var hu$1 = /*#__PURE__*/Object.freeze({
  useLongScale: useLongScale$9,
  baseSeparator: baseSeparator$9,
  unitSeparator: unitSeparator$9,
  base: base$9,
  unitExceptions: unitExceptions$9,
  units: units$9,
  default: hu
});

var useLongScale$10 = false;
var baseSeparator$10 = "-";
var unitSeparator$10 = "and ";
var base$10 = {
	"0": "zero",
	"1": "one",
	"2": "two",
	"3": "three",
	"4": "four",
	"5": "five",
	"6": "six",
	"7": "seven",
	"8": "eight",
	"9": "nine",
	"10": "ten",
	"11": "eleven",
	"12": "twelve",
	"13": "thirteen",
	"14": "fourteen",
	"15": "fifteen",
	"16": "sixteen",
	"17": "seventeen",
	"18": "eighteen",
	"19": "nineteen",
	"20": "twenty",
	"30": "thirty",
	"40": "forty",
	"50": "fifty",
	"60": "sixty",
	"70": "seventy",
	"80": "eighty",
	"90": "ninety"
};
var units$10 = {
	"2": "hundred",
	"3": "thousand",
	"5": "lakh",
	"7": "crore"
};
var unitExceptions$10 = [
];
var enIndian = {
	useLongScale: useLongScale$10,
	baseSeparator: baseSeparator$10,
	unitSeparator: unitSeparator$10,
	base: base$10,
	units: units$10,
	unitExceptions: unitExceptions$10
};

var enIndian$1 = /*#__PURE__*/Object.freeze({
  useLongScale: useLongScale$10,
  baseSeparator: baseSeparator$10,
  unitSeparator: unitSeparator$10,
  base: base$10,
  units: units$10,
  unitExceptions: unitExceptions$10,
  default: enIndian
});

var util$2 = ( util$1 && util ) || util$1;

var require$$0 = ( en$1 && en ) || en$1;

var require$$1 = ( es$1 && es ) || es$1;

var require$$2 = ( pt$1 && pt ) || pt$1;

var require$$3 = ( ptPT$1 && ptPT ) || ptPT$1;

var require$$4 = ( fr$1 && fr ) || fr$1;

var require$$5 = ( eo$1 && eo ) || eo$1;

var require$$6 = ( it$1 && it ) || it$1;

var require$$7 = ( vi$1 && vi ) || vi$1;

var require$$8 = ( tr$1 && tr ) || tr$1;

var require$$9 = ( hu$1 && hu ) || hu$1;

var require$$10 = ( enIndian$1 && enIndian ) || enIndian$1;

var lib = createCommonjsModule(function (module, exports) {
exports = module.exports = writtenNumber;


var languages = ["en", "es", "pt", "fr", "eo", "it", "vi", "tr"];
var i18n = {
  en: require$$0,
  es: require$$1,
  pt: require$$2,
  ptPT: require$$3,
  fr: require$$4,
  eo: require$$5,
  it: require$$6,
  vi: require$$7,
  tr: require$$8,
  hu: require$$9,
  enIndian: require$$10
};
exports.i18n = i18n;

var shortScale = [100];
for (var i = 1; i <= 16; i++) {
  shortScale.push(Math.pow(10, i * 3));
}

var longScale = [100, 1000];
for (i = 1; i <= 15; i++) {
  longScale.push(Math.pow(10, i * 6));
}

writtenNumber.defaults = {
  noAnd: false,
  lang: "en"
};

/**
 * Converts numbers to their written form.
 *
 * @param {Number} n The number to convert
 * @param {Object} [options] An object representation of the options
 * @return {String} writtenN The written form of `n`
 */

function writtenNumber(n, options) {
  options = options || {};
  options = util$2.defaults(options, writtenNumber.defaults);

  if (n < 0) {
    return "";
  }

  n = Math.round(+n);

  var language = typeof options.lang === "string"
    ? i18n[options.lang]
    : options.lang;
  var scale = language.useLongScale ? longScale : shortScale;
  var units = language.units;
  var unit;

  if (!(units instanceof Array)) {
    var rawUnits = units;

    units = [];
    scale = Object.keys(rawUnits);

    for (var i in scale) {
      units.push(rawUnits[scale[i]]);
      scale[i] = Math.pow(10, parseInt(scale[i]));
    }
  }

  if (!language) {
    if (languages.indexOf(writtenNumber.defaults.lang) < 0) {
      writtenNumber.defaults.lang = "en";
    }

    language = i18n[writtenNumber.defaults.lang];
  }

  var baseCardinals = language.base;

  if (language.unitExceptions[n]) return language.unitExceptions[n];
  if (baseCardinals[n]) return baseCardinals[n];
  if (n < 100)
    return handleSmallerThan100(n, language, unit, baseCardinals, options);

  var m = n % 100;
  var ret = [];

  if (m) {
    if (
      options.noAnd &&
      !(language.andException && language.andException[10])
    ) {
      ret.push(writtenNumber(m, options));
    } else {
      ret.push(language.unitSeparator + writtenNumber(m, options));
    }
  }

  var firstSignificant;

  for (var i = 0, len = units.length; i < len; i++) {
    var r = Math.floor(n / scale[i]);
    var divideBy;

    if (i === len - 1) divideBy = 1000000;
    else divideBy = scale[i + 1] / scale[i];

    r %= divideBy;

    unit = units[i];

    if (!r) continue;
    firstSignificant = scale[i];

    if (unit.useBaseInstead) {
      var shouldUseBaseException =
        unit.useBaseException.indexOf(r) > -1 &&
        (unit.useBaseExceptionWhenNoTrailingNumbers
          ? i === 0 && ret.length
          : true);
      if (!shouldUseBaseException) {
        ret.push(baseCardinals[r * scale[i]]);
      } else {
        ret.push(r > 1 && unit.plural ? unit.plural : unit.singular);
      }
      continue;
    }

    var str;
    if (typeof unit === "string") {
      str = unit;
    } else {
      str = r > 1 && unit.plural && (!unit.avoidInNumberPlural || !m)
        ? unit.plural
        : unit.singular;
    }

    if (
      unit.avoidPrefixException &&
      unit.avoidPrefixException.indexOf(r) > -1
    ) {
      ret.push(str);
      continue;
    }

    var exception = language.unitExceptions[r];
    var number =
      exception ||
      writtenNumber(
        r,
        util$2.defaults(
          {
            // Languages with and exceptions need to set `noAnd` to false
            noAnd: !((language.andException && language.andException[r]) ||
              unit.andException) && true
          },
          options
        )
      );
    n -= r * scale[i];
    ret.push(number + " " + str);
  }

  var firstSignificantN = firstSignificant * Math.floor(n / firstSignificant);
  var rest = n - firstSignificantN;

  if (
    language.andWhenTrailing &&
    firstSignificant &&
    0 < rest &&
    ret[0].indexOf(language.unitSeparator) !== 0
  ) {
    ret = [ret[0], language.unitSeparator.replace(/\s+$/, "")].concat(
      ret.slice(1)
    );
  }

  return ret.reverse().join(" ");
}

function handleSmallerThan100(n, language, unit, baseCardinals, options) {
  var dec = Math.floor(n / 10) * 10;
  unit = n - dec;
  if (unit) {
    return (
      baseCardinals[dec] + language.baseSeparator + writtenNumber(unit, options)
    );
  }
  return baseCardinals[dec];
}
});
var lib_1 = lib.i18n;

var toArabic = createCommonjsModule(function (module) {
(function () {


  /**
   * Converts a roman number to its arabic equivalent.
   *
   * Will throw TypeError on non-string inputs.
   *
   * @param {String} roman
   * @return {Number}
   */
  function toArabic (roman) {
    if (('string' !== typeof roman) && (!(roman instanceof String))) throw new TypeError('toArabic expects a string');

    // Zero is/was a special case. I'll go with Dionysius Exiguus on this one as
    // seen on http://en.wikipedia.org/wiki/Roman_numerals#Zero
    if (/^nulla$/i.test(roman) || !roman.length) return 0;

    // Ultra magical regexp to validate roman numbers!
    roman = roman.toUpperCase().match(/^(M{0,3})(CM|DC{0,3}|CD|C{0,3})(XC|LX{0,3}|XL|X{0,3})(IX|VI{0,3}|IV|I{0,3})$/);
    if (!roman) throw new Error('toArabic expects a valid roman number');
    var arabic = 0;

    // Crunching the thousands...
    arabic += roman[1].length * 1000;

    // Crunching the hundreds...
    if (roman[2] === 'CM') arabic += 900;
    else if (roman[2] === 'CD') arabic += 400;
    else arabic += roman[2].length * 100 + (roman[2][0] === 'D' ? 400 : 0);


    // Crunching the tenths
    if (roman[3] === 'XC') arabic += 90;
    else if (roman[3] === 'XL') arabic += 40;
    else arabic += roman[3].length * 10 + (roman[3][0] === 'L' ? 40 : 0);

    // Crunching the...you see where I'm going, right?
    if (roman[4] === 'IX') arabic += 9;
    else if (roman[4] === 'IV') arabic += 4;
    else arabic += roman[4].length * 1 + (roman[4][0] === 'V' ? 4 : 0);
    return arabic;
  }

  module.exports = toArabic;

})();
});

var toArabic$1 = /*#__PURE__*/Object.freeze({
  default: toArabic,
  __moduleExports: toArabic
});

var toRoman = createCommonjsModule(function (module) {
(function () {
  /**
   * Generate the roman number for the current power of tenth
   *
   * @param {Number} num
   * @param {String} one
   * @param {String} five
   * @param {String} ten
   * @return {String}
   */
  function upToTen (num, one, five, ten) {
    var value = '';
    switch (num) {
      case 0: return value;
      case 9: return one + ten;
      case 4: return one + five;
    }
    if (num >= 5) value = five, num -= 5;
    while (num-- > 0) value += one;
    return value;
  }


  /**
   * Converts an arabic number from 0 to 3999 to its roman equivalent.
   *
   * Will throw TypeError on non-number inputs (stringed numbers are accepted)
   * or NaN and Error on number under 0 or over 3999.
   *
   * @param {Number/String} arabic
   * @return {String}
   */
  function toRoman (arabic) {
    // Checking input first with type comparisons, convert Number() instances to
    // a literal, etc...
    if (arabic instanceof Number) arabic = parseInt(arabic, 10);
    if ('string' === typeof arabic || arabic instanceof String) {
      arabic = parseInt(arabic, 10);
      if (isNaN(arabic)) throw new TypeError('toArabic expects a number');
    }
    if ('number' !== typeof arabic) throw new TypeError('toArabic expects a number');

    // Rounding up "bad" numbers: NaN, negative numbers, numbers over 3999,...
    if (isNaN(arabic)) throw new TypeError('toArabic expects a real number');
    if (arabic < 0) throw new Error('toArabic cannot express negative numbers');
    if (arabic > 3999) throw new Error('toArabic cannot express numbers over 3999');

    // Zero is/was a special case. I'll go with Dionysius Exiguus on this one as
    // seen on http://en.wikipedia.org/wiki/Roman_numerals#Zero
    if (arabic === 0) return 'nulla';
    var roman = '';

    // Chomping away by the power of tenths
    roman += upToTen(Math.floor(arabic / 1000), 'M', '', ''), arabic %= 1000;
    roman += upToTen(Math.floor(arabic / 100), 'C', 'D', 'M'), arabic %= 100;
    roman += upToTen(Math.floor(arabic / 10), 'X', 'L', 'C'), arabic %= 10;
    roman += upToTen(arabic, 'I', 'V', 'X');
    return roman;
  }

  module.exports = toRoman;

})();
});

var toRoman$1 = /*#__PURE__*/Object.freeze({
  default: toRoman,
  __moduleExports: toRoman
});

var require$$0$1 = ( toArabic$1 && toArabic ) || toArabic$1;

var require$$1$1 = ( toRoman$1 && toRoman ) || toRoman$1;

var romanNumerals = createCommonjsModule(function (module) {
(function () {
  module.exports = {
    toArabic: require$$0$1,
    toRoman:require$$1$1
  };
})();
});
var romanNumerals_1 = romanNumerals.toArabic;
var romanNumerals_2 = romanNumerals.toRoman;

// higher order function
var pipe = function () {
    var ops = [];
    for (var _i = 0; _i < arguments.length; _i++) {
        ops[_i] = arguments[_i];
    }
    return ops.reduce(function (a, b) { return function (arg) { return b(a(arg)); }; });
};
// higher order function
var flatMap = function (fn) { return function (words) {
    return words.reduce(function (acc, w) {
        acc.push.apply(acc, fn(w));
        return acc;
    }, []);
}; };
var toUpperCase = function (s) { return s.toUpperCase(); };
var trim = function (s) { return s.trim(); };
var normalize$1 = pipe(toUpperCase, removeAccents, trim);
var ignoreJuristicPersonTypeAbbreviations = function (input) {
    return input
        .replace(/S\.?\s?EN\s?N\.?\s?C\.?$/g, '')
        .replace(/S\.?\s?EN\s?C\.?\s?POR\s?A\.?$/g, '')
        .replace(/S\.?\s?EN\s?C\.?$/g, '')
        .replace(/S\.?\s?DE\s?R\.?\s?L\.?$/g, '')
        .replace(/S\.?\s?DE\s?R\.?\s?L\.?\s?DE\s?C\.?\s?V\.?$/g, '')
        .replace(/S\.?\s?A\.?\s?DE\s?C\.?\s?V\.?$/g, '')
        .replace(/S\.?\s?A\.?\s?P\.?\s?I\.?\s?DE\s?C\.?\s?V\.?$/g, '')
        .replace(/S\.?\s?A\.?\s?S\.?\s?DE\s?C\.?\s?V\.?$/g, '')
        .replace(/A\.?\s?EN\s?P\.?$/g, '')
        .replace(/S\.?\s?C\.?\s?[LPS]\.?$/g, '')
        .replace(/S\.?\s?[AC]\.?$/g, '')
        .replace(/S\.?\s?N\.?\s?C\.?$/g, '')
        .replace(/A\.?\s?C\.?$/g, '');
};
var removeEmptyWords = function (w) { return w.length > 0; };
var splitWords = function (input) { return input.split(/[,\s]+/).filter(removeEmptyWords); };
/*
* This list is based on Anexo V from the official documentation
* but some words have been commented out because the examples from
* the same documentation contradict the list
*/
var forbiddenWords = [
    'EL',
    'LA',
    'DE',
    'LOS',
    'LAS',
    'Y',
    'DEL',
    'MI',
    'POR',
    'CON',
    /*'AL',*/ 'SUS',
    'E',
    'PARA',
    'EN',
    'MC',
    'VON',
    'MAC',
    'VAN',
    'COMPANIA',
    'CIA',
    'CIA.',
    'SOCIEDAD',
    'SOC',
    'SOC.',
    'COMPANY',
    'CO',
    /*'COOPERATIVA', 'COOP',*/
    'SC',
    'SCL',
    'SCS',
    'SNC',
    'SRL',
    'CV',
    'SA',
    'THE',
    'OF',
    'AND',
    'A'
];
var ignoreForbiddenWords = function (words) {
    return words.filter(function (w) { return forbiddenWords.indexOf(w) === -1; });
};
var markOneLetterAbbreviations = function (words) {
    return words.map(function (w) { return w.replace(/^([^.])\./g, '$1AABBRREEVVIIAATTIIOONN'); });
};
var expandSpecialCharactersInSingletonWord = flatMap(function (w) {
    if (w.length === 1) {
        return w
            .replace('@', 'ARROBA')
            .replace('´', 'APOSTROFE')
            .replace('%', 'PORCIENTO')
            .replace('#', 'NUMERO')
            .replace('!', 'ADMIRACION')
            .replace('.', 'PUNTO')
            .replace('$', 'PESOS')
            .replace('"', 'COMILLAS')
            .replace('-', 'GUION')
            .replace('/', 'DIAGONAL')
            .replace('+', 'SUMA')
            .replace('(', 'ABRE PARENTESIS')
            .replace(')', 'CIERRA PARENTESIS')
            .split(' ')
            .filter(removeEmptyWords);
    }
    return [w];
});
var ignoreSpecialCharactersInWords = function (words) {
    return words.map(function (w) { return w.replace(/(.+?)[@´%#!.$"-/+()](.+?)/g, '$1$2'); });
};
var splitOneLetterAbbreviations = flatMap(function (w) {
    return w.split('AABBRREEVVIIAATTIIOONN').filter(removeEmptyWords);
});
var expandSingleArabicNumeral = function (numeral) {
    return lib(parseInt(numeral, 10), { lang: 'es' })
        .toUpperCase()
        .split(/\s/)
        .filter(removeEmptyWords);
};
var expandArabicNumerals = flatMap(function (word) {
    if (word.match(/[0-9]+/)) {
        return expandSingleArabicNumeral(word);
    }
    return [word];
});
var expandRomanNumerals = flatMap(function (word) {
    if (word.match(/^(M{0,4})(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/)) {
        return expandSingleArabicNumeral(romanNumerals.toArabic(word));
    }
    return [word];
});
var threeDigitsCode = function (words) {
    if (words.length >= 3) {
        return '' + words[0].charAt(0) + words[1].charAt(0) + words[2].charAt(0);
    }
    else if (words.length === 2) {
        return '' + words[0].charAt(0) + words[1].substring(0, 2);
    }
    else {
        return firstThreeCharactersWithRightPad(words[0]);
    }
};
var firstThreeCharactersWithRightPad = function (word) {
    return word.length >= 3 ? word.substring(0, 3) : word.padEnd(3, 'X');
};
var nameCode = pipe(normalize$1, ignoreJuristicPersonTypeAbbreviations, splitWords, ignoreForbiddenWords, markOneLetterAbbreviations, expandSpecialCharactersInSingletonWord, ignoreSpecialCharactersInWords, splitOneLetterAbbreviations, expandArabicNumerals, expandRomanNumerals, threeDigitsCode);
var juristicPersonTenDigitsCode = function (person) {
    return nameCode(person.name) + dateCode(person.day, person.month, person.year);
};

var RfcFacil = /** @class */ (function () {
    function RfcFacil() {
    }
    RfcFacil.forNaturalPerson = function (person) {
        var t = naturalPersonTenDigitsCode(person);
        var h = calculate(naturalPersonFullName(person));
        var v = calculate$1(t + h);
        return t + h + v;
    };
    RfcFacil.forJuristicPerson = function (person) {
        var t = juristicPersonTenDigitsCode(person);
        var h = calculate(person.name);
        var v = calculate$1(' ' + t + h);
        return t + h + v;
    };
    return RfcFacil;
}());
function naturalPersonFullName(p) {
    return p.firstLastName + " " + p.secondLastName + " " + p.name;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (RfcFacil);
//# sourceMappingURL=rfc-facil.es5.js.map


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
__webpack_require__(/*! ./components/toastr */ "./resources/js/components/toastr.js");

__webpack_require__(/*! ./components/notification/utilities */ "./resources/js/components/notification/utilities.js");

__webpack_require__(/*! ./components/datatable */ "./resources/js/components/datatable.js");

__webpack_require__(/*! ./components/user/crud */ "./resources/js/components/user/crud.js");

__webpack_require__(/*! ./components/user/datatable_admin */ "./resources/js/components/user/datatable_admin.js");

__webpack_require__(/*! ./components/user/datatable_financiera */ "./resources/js/components/user/datatable_financiera.js");

__webpack_require__(/*! ./components/user/datatable_inversionista */ "./resources/js/components/user/datatable_inversionista.js");

__webpack_require__(/*! ./components/user/datatable_user */ "./resources/js/components/user/datatable_user.js");

__webpack_require__(/*! ./components/product/datatable_product */ "./resources/js/components/product/datatable_product.js");

__webpack_require__(/*! ./components/product/crud */ "./resources/js/components/product/crud.js");

__webpack_require__(/*! ./components/agreement/datatable */ "./resources/js/components/agreement/datatable.js");

__webpack_require__(/*! ./components/agreement/crud */ "./resources/js/components/agreement/crud.js");

__webpack_require__(/*! ./components/lead/datatable */ "./resources/js/components/lead/datatable.js");

__webpack_require__(/*! ./components/lead/crud */ "./resources/js/components/lead/crud.js");

__webpack_require__(/*! ./components/clients/datatable */ "./resources/js/components/clients/datatable.js");

__webpack_require__(/*! ./components/clients/datatable_colaboradores */ "./resources/js/components/clients/datatable_colaboradores.js");

__webpack_require__(/*! ./components/clients/crud */ "./resources/js/components/clients/crud.js");

__webpack_require__(/*! ./components/tag/datatable */ "./resources/js/components/tag/datatable.js");

__webpack_require__(/*! ./components/tag/crud */ "./resources/js/components/tag/crud.js");

__webpack_require__(/*! ./components/financial/datatable */ "./resources/js/components/financial/datatable.js");

__webpack_require__(/*! ./components/financial/crud */ "./resources/js/components/financial/crud.js");

__webpack_require__(/*! ./components/financial/product/datatable */ "./resources/js/components/financial/product/datatable.js");

__webpack_require__(/*! ./components/financial/product/crud */ "./resources/js/components/financial/product/crud.js");

__webpack_require__(/*! ./components/crm */ "./resources/js/components/crm.js");

__webpack_require__(/*! ./components/action/datatable */ "./resources/js/components/action/datatable.js");

__webpack_require__(/*! ./components/action/crud */ "./resources/js/components/action/crud.js");

__webpack_require__(/*! ./components/action/credit */ "./resources/js/components/action/credit.js");

__webpack_require__(/*! ./components/general */ "./resources/js/components/general.js");

__webpack_require__(/*! ./components/module/datatable */ "./resources/js/components/module/datatable.js");

__webpack_require__(/*! ./components/module/template */ "./resources/js/components/module/template.js");

__webpack_require__(/*! ./components/module/resumen */ "./resources/js/components/module/resumen.js");

__webpack_require__(/*! ./components/module/kc_check_up/datatable */ "./resources/js/components/module/kc_check_up/datatable.js");

__webpack_require__(/*! ./components/module/kc_check_up/action/datatable */ "./resources/js/components/module/kc_check_up/action/datatable.js");

__webpack_require__(/*! ./components/module/kc_check_up/action/datatable_report */ "./resources/js/components/module/kc_check_up/action/datatable_report.js");

__webpack_require__(/*! ./components/module/kc_control_desk/datatable */ "./resources/js/components/module/kc_control_desk/datatable.js");

__webpack_require__(/*! ./components/module/kc_control_desk/reference */ "./resources/js/components/module/kc_control_desk/reference.js");

__webpack_require__(/*! ./components/action/datatablemodule */ "./resources/js/components/action/datatablemodule.js");

__webpack_require__(/*! ./components/credit/profile/datatable */ "./resources/js/components/credit/profile/datatable.js");

__webpack_require__(/*! ./components/credit/product/datatable */ "./resources/js/components/credit/product/datatable.js");

__webpack_require__(/*! ./components/credit/datatable_in_progress */ "./resources/js/components/credit/datatable_in_progress.js");

window.moveElement = function (section, id, idDatatable) {
  // Deshabilita el botón para evitar clics múltiples
  var button = document.querySelector('.moveElement');
  button.disabled = true;
  axios.get("/panel/" + section + "/" + id + "/move").then(function (response) {
    if (idDatatable == null) {
      location.reload();
    } else {
      $('#' + idDatatable).DataTable().ajax.reload();
    }
  })["catch"](function (e) {})["finally"](function () {
    // Habilita el botón nuevamente después de que se complete la solicitud Axios
    button.disabled = false;
  });
};

window.msgProfile = function () {
  Swal.fire({
    title: 'Este usuario no tiene ningún trámite',
    icon: 'warning',
    showCancelButton: true,
    showConfirmButton: false,
    //confirmButtonText: 'Sí, elimina',
    cancelButtonText: 'Cerrar'
  });
};

window.isAccess = function () {
  axios.get("/user/tyc/validate").then(function (response) {
    var result = response.data;
    var is_block = result.is_block;

    if (is_block == true) {
      $('#modal-access').modal('show');
    } else {
      $('#modal-access').modal('hide');
    }
  })["catch"](function (e) {});
};

$("#frm-tyc").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById('frm-tyc');
  var data = new FormData(new_form);
  axios.post("/panel/user/tyc/accept", data).then(function (response) {
    $('#modal-access').modal('hide');
    isAccess();
  })["catch"](function (e) {});
});
$().ready(function () {
  isAccess();
  var myModalEl = document.getElementById('modal-access');
  myModalEl.addEventListener('hidden.bs.modal', function (event) {
    isAccess();
  });
});
/* $( "#frm-contact" ).submit(function( event ) {
    event.preventDefault();
    alert('test');
    const new_form    = document.getElementById('frm-contact');
    const data        = new FormData(new_form);
    axios.post("/contact", data)
    .then(function (response) {
        
    })
    .catch(e => {
    });
});

 */

tippy(document.querySelectorAll('.active-tooltip'), {
  content: function content(reference) {
    var id = reference.getAttribute('data-template');
    var template = document.getElementById(id);
    return template.innerHTML;
  },
  allowHTML: true
});
/* grafica dona investors */

if (document.getElementById('TrafficChannelDoughnutData')) {
  var analyticsDoughnut = function analyticsDoughnut(selector, set_data) {
    var $selector = selector ? $(selector) : $('.analytics-doughnut');
    $selector.each(function () {
      var $self = $(this),
          _self_id = $self.attr('id'),
          _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;

      var selectCanvas = document.getElementById(_self_id).getContext("2d");
      var chart_data = [];

      for (var i = 0; i < _get_data.datasets.length; i++) {
        chart_data.push({
          backgroundColor: _get_data.datasets[i].background,
          borderWidth: 2,
          borderColor: _get_data.datasets[i].borderColor,
          hoverBorderColor: _get_data.datasets[i].borderColor,
          data: _get_data.datasets[i].data
        });
      }

      var chart = new Chart(selectCanvas, {
        type: 'doughnut',
        data: {
          labels: _get_data.labels,
          datasets: chart_data
        },
        options: {
          plugins: {
            legend: {
              display: _get_data.legend ? _get_data.legend : false,
              labels: {
                boxWidth: 12,
                padding: 20,
                color: '#6783b8'
              }
            },
            tooltip: {
              enabled: true,
              rtl: NioApp.State.isRTL,
              callbacks: {
                label: function label(context) {
                  return "".concat(context.parsed, " ").concat(_get_data.dataUnit);
                }
              },
              backgroundColor: '#fff',
              borderColor: '#eff6ff',
              borderWidth: 2,
              titleFont: {
                size: 13
              },
              titleColor: '#6783b8',
              titleMarginBottom: 6,
              bodyColor: '#9eaecf',
              bodyFont: {
                size: 12
              },
              bodySpacing: 4,
              padding: 10,
              footerMarginTop: 0,
              displayColors: false
            }
          },
          rotation: -1.5,
          cutoutPercentage: 70,
          maintainAspectRatio: false
        }
      });
    });
  }; // init chart


  var disponiblePrestaroRetirar = $('#disponiblePrestaroRetirar').val();
  var procesoPrestado = $('#procesoPrestado').val();
  var prestamoCreditosActivos = $('#prestamoCreditosActivos').val();
  var TrafficChannelDoughnutData = {
    labels: ["Disponible para prestar o retirar", "En proceso de ser prestado", "Préstamos en créditos activos"],
    dataUnit: 'People',
    legend: false,
    datasets: [{
      borderColor: "#fff",
      background: ["#798bff", "#b8acff", "#ffa9ce", "#f9db7b"],
      data: [disponiblePrestaroRetirar, procesoPrestado, prestamoCreditosActivos]
    }]
  };
  NioApp.coms.docReady.push(function () {
    analyticsDoughnut();
  });
}

__webpack_require__(/*! ./components/websocket */ "./resources/js/components/websocket.js");
})();

/******/ })()
;