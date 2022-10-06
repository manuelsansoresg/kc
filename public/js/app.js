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
  $('#modal-lead-note').modal('hide');
  getTags();
  getNotes();
};

window.deleteTag = function (tag_id) {
  axios.get("/panel/credit/tag/" + tag_id + "/drop").then(function (response) {
    var result = response.data;
    getTags();
  })["catch"](function (e) {});
};

if (document.getElementById('action-model')) {
  //* get data saved 
  var getData = function getData() {
    clearPreviewFiles();
    axios.get("/panel/files/template/" + model + "/" + id_rel + "/show").then(function (response) {
      var result = response.data;
      var files = result.files;
      var file_dates = result.file_date;

      for (var key in file_dates) {
        if (file_dates.hasOwnProperty.call(file_dates, key)) {
          var element_date_file = file_dates[key];
          $('#' + element_date_file.template_config_id + '-date_file').val(element_date_file.date_file);
        }
      }

      for (var key_file in files) {
        if (files.hasOwnProperty.call(files, key_file)) {
          var element_file = files[key_file];
          $('#' + element_file.template_config_id + '-files-action-preview').append(element_file.preview);
        }
      }
    })["catch"](function (e) {});
  };

  var clearPreviewFiles = function clearPreviewFiles() {
    axios.get("/panel/files/images/" + model + '/' + id_rel + '/get/config').then(function (response) {
      var result = response.data;
      var config_files = result.config_files;

      for (var key in config_files) {
        if (config_files.hasOwnProperty.call(config_files, key)) {
          var element = config_files[key]; //create dinamic dropzone element

          $('#' + key + '-files-action-preview').html('');
        }
      }
    })["catch"](function (e) {});
  };

  var model = $('#action-model').val();
  var id_rel = $('#action-id_rel').val();

  if (model == '') {
    model = null;
  } //*get configuration in template


  axios.get("/panel/files/images/" + model + '/' + id_rel + '/get/config').then(function (response) {
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

  window.deleteFileTemplate = function (model, id) {
    $('#frm-register-action-preview').html('');
    axios.get("/panel/temp/images/" + id + "/delete").then(function (response) {
      getData();
      showToast('Archivos', 'Archivo borrado', 'success');
    })["catch"](function (e) {});
  };

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
        var data = new FormData(new_form);
        axios.post("/panel/files/template/date", data).then(function (response) {
          var result = response.data;
          window.history.back();
        })["catch"](function (e) {});
      }
    });
  });
}

/***/ }),

/***/ "./resources/js/components/action/crud.js":
/*!************************************************!*\
  !*** ./resources/js/components/action/crud.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");


window.actionModal = function (id, is_new) {
  /*  if (document.getElementById('modal-action-id-rel-lead')) {
       getPerson(id);
    } */
  resetAction();
  getAdvisorLead(id);
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

function getAdvisorLead(lead_id) {
  axios.get("/panel/lead/" + lead_id).then(function (response) {
    var result = response.data;
    var lead = result.lead;
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
  $('#modal-action-complete-active').prop("checked", true);
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
/* window.editModalAction = function(action_id, disabled) {
    setModalAction(action_id, disabled);
    $('#modal-action').modal('show');
} */


window.setModalAction = function (action_id, disabled) {
  if (disabled == true) {
    $('#frm-action input, textarea, select').attr('disabled', 'disabled');
    $('#modal-action-save').hide();
  }

  axios.get("/panel/action/" + action_id).then(function (response) {
    var result = response.data;
    console.log(result);
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
      alert(action.id_rel); //$("#lead-asesor-id").val(advisor.id).trigger('change');

      /* if (lead != null) {
          $("#modal-action-id-rel-lead").prepend("<option value='" + lead.id + "' selected='selected'> " + lead_name + "</option>");
      }  */

      $('#modal-action').modal('show');

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
      $('#agreement-financials').val(financials);
      $('#agreement-financials').trigger("change");
      $('#agreement-status').val(agreement.status).trigger("change"); //$('#agreement-status option[value="' + agreement.status + '"]').trigger("change");
    })["catch"](function (e) {
      $('#admin_email-error-exist').show();
    });
  }
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
      data: 'module'
    }, {
      data: 'deadline'
    }, {
      data: 'responsable'
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

window.moveModal = function (title, id, statusid, old_status_id, dt) {
  $('#frm-archive').trigger("reset");
  $('#id_rel').val(id);
  $('#statusid').val(statusid);
  $('#old_status_id').val(old_status_id);
  $('#dt').val(dt);
  $('#modal-archive-title').html(title);
  getReason(title);
  $('#modal-archive').modal('show');
};

window.moveModalLead = function (title, id, statusid, old_status_id, dt) {
  $('#frm-archive').trigger("reset");
  $('#id_rel').val(id);
  $('#statusid').val(statusid);
  $('#old_status_id').val(old_status_id);
  $('#dt').val(dt);
  $('#modal-archive-title').html(title);
  getReason('ArchivarLead');
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
  var dt = $('#dt').val();
  var msg = 'registro archivado exitosamente';
  move(id_rel, 'frm-archive', 'modal-archive', dt, 'Registro', msg);
});

window.modalValidate = function (id, model) {
  $('#modal-validate-content').html('');
  axios.get('/panel/' + id + '/' + model + '/validate/show').then(function (response) {
    var result = response.data;
    $('#modal-validate-content').html(result);
    $('#modal-validate').modal('show');
  })["catch"](function (e) {});
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

    if (financials != null) {}
  })["catch"](function (e) {});
}

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

window.alerDelete = function (id) {
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
        var result = response.data;
        window.location = '/panel/financial-product/' + result.id + '/edit';
      })["catch"](function (e) {
        var response = e.response;
        var data_errors = response.data.errors;
        $('#product-name-unique-error').html('Este campo ya se encuentra registrado.');
        $('#product-name-unique-error').show();
      });
    }
  });
});
$("#frm-financial-buro").submit(function (event) {
  event.preventDefault();
  var new_form = document.getElementById("frm-financial-buro");
  var data = new FormData(new_form);
  axios.post("/panel/financial-product", data).then(function (response) {
    var result = response.data;
    showToast('Producto', 'Datos guardados', 'success');
  })["catch"](function (e) {});
});
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

window.deleteProduct = function (id) {
  axios["delete"]("/panel/financial-product/" + id).then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-financial-product', 'Producto', 'Registro borrado');
  })["catch"](function (e) {});
};

window.alerDeleteProduct = function (id) {
  Swal.fire({
    title: '¿Estás seguro?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, elimina',
    cancelButtonText: 'Mejor no'
  }).then(function (result) {
    if (result.value) {
      deleteProduct(id);
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
  $('#modal-lead-note').modal('show');
};

var refresh = {
  'credit': creditRefresh
};
$("#frm-lead-note").submit(function (event) {
  event.preventDefault();
  var model_note = $('#model_note').val();
  var refresh_dt = $('#refresh-dt').val();
  var new_form = document.getElementById("frm-lead-note");
  var data = new FormData(new_form);
  axios.post("/panel/" + model_note + "/note", data).then(function (response) {
    if (refresh_dt != 'null') {
      (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-lead', 'Datos actualizados', 'Información actualizada correctamente');
      $('#modal-lead-note').modal('hide');
    } else {
      refresh[model_note]();
    }
  })["catch"](function (e) {});
});

window.copyToClipBoardReport = function () {
  var content = document.getElementById('url_report').value;
  navigator.clipboard.writeText(content).then(function () {
    showToast('', 'URL copiada en el portapapeles', 'success');
  })["catch"](function (err) {
    console.log('Something went wrong', err);
  });
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

$('.js-select2').select2({
  placeholder: "Escribe para buscar..",
  allowClear: true
});
$('.select2multiple').select2({
  placeholder: "Escribe para buscar.."
});
$("#lead-agreement").change(function () {
  var lead_agreement = $("#lead-agreement").val();
  getFinancial(lead_agreement);
  $('#lead-content-agreement').hide();

  if (lead_agreement == 0) {
    $('#lead-content-agreement').show('slow');
  }
});

function getFinancial(lead_id) {
  $('#lead-financial_id').empty();
  axios.get("/panel/lead/financial/" + lead_id + "/show").then(function (response) {
    var result = response.data;

    if (result != null) {
      var lead_financial = $('#lead-financial_id');

      for (var key in result) {
        var element = result[key];
        var option = new Option(element.commercial_name, element.id, true, true);
        lead_financial.append(option).trigger('change');
      }
    }
  })["catch"](function (e) {
    $('#admin_email-error-exist').show();
  });
}

$("#lead-origin").change(function () {
  var origin_id = $("#lead-origin").val();
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
  })["catch"](function (e) {
    $('#admin_email-error-exist').show();
  });
});

function setData() {
  var lead_id = $('#lead_id').val();
  axios.get("/panel/lead/" + lead_id).then(function (response) {
    var result = response.data;
    var lead = result.lead;
    var channel = result.channel;
    var financials = result.financials;
    $('#lead-agreement').val(lead.agreement_id);
    $('#lead-agreement').trigger("change");
    $('#lead-product-id').val(lead.product_id);
    $('#lead-product-id').trigger("change");
    $('#lead-origin').val(lead.origin_id);
    $('#lead-origin').trigger("change");
    $('#lead-asesor-id').val(lead.asesor_id);
    $('#lead-asesor-id').trigger("change");
    $('#lead-type_id').val(lead.type_id);
    $('#lead-type_id').trigger("change");
    $('#lead-name').val(lead.name);
    $('#lead-last_name').val(lead.last_name);
    $('#lead-second_last_name').val(lead.second_last_name);
    $('#lead-cellphone').val(lead.cellphone);
    $('#lead-email').val(lead.email);

    if (channel != null) {
      $('#lead-channel').empty();
      var lead_channel = $('#lead-channel');

      for (var key in channel) {
        var element = channel[key];

        if (element != 'Selecciona una opción') {
          /*  var option = new Option(element, key, true, true);
           lead_channel.append(option).trigger('change'); */
        }
      }
    }

    if (financials != null) {
      var lead_financial = $('#lead-financial_id');

      for (var _key in result) {
        var _element = result[_key];
        var option = new Option(_element.commercial_name, _element.id, true, true);
        lead_financial.append(option).trigger('change');
      }
    }

    $('#lead-channel').val(lead.channel_id).trigger("change");
    $('#lead-financial_id').val(lead.financial_id).trigger("change");
    $('#lead-temperature-id').val(lead.financial_id).trigger("change");
  })["catch"](function (e) {
    $('#admin_email-error-exist').show();
  });
}

window.deleteLead = function (lead_id) {
  axios.get("panel/lead/" + lead_id + "/delete").then(function (response) {
    (0,_utilities__WEBPACK_IMPORTED_MODULE_0__.showInfo)(2, 'dt-lead', 'Datos actualizados', 'Información actualizada correctamente');
  })["catch"](function (e) {});
};

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

$(document).ready(function () {
  if (document.getElementById('lead-channel')) {
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
    ajax: '/panel/lead/list/show',
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
      $(row).addClass("nk-tb-item odd");
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

if (document.getElementById('dt-check-up-actions')) {
  history_id = $('#history_id').val();
  model = $('#model').val();
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
    ajax: '/panel/template/actions/list/' + model + '/' + history_id + '/show',
    columns: [{
      data: 'name'
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

/***/ "./resources/js/components/module/template.js":
/*!****************************************************!*\
  !*** ./resources/js/components/module/template.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utilities */ "./resources/js/components/utilities.js");

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
        required: true,
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
        required: true,
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
  }); //*get data

  if (document.getElementById('id_rel')) {
    var id_rel = $('#id_rel').val();

    if (id_rel != '') {
      axios.get("/panel/action-form/" + id_rel).then(function (response) {
        var result = response.data;
        var credit = result.credit;
        var client = result.client;
        $('#lead-agreement').val(credit.agreement_id).trigger("change");
        $('#name').val(client.name);
        $('#last_name').val(client.last_name);
        $('#second_last_name').val(client.second_last_name);
        $('#cellphone').val(client.cellphone);

        if (document.getElementById('current_principal_balance')) {
          $('#current_payment').val(credit.current_payment / 100);
          $('#current_periodicity').val(credit.current_periodicity).trigger("change");
          $('#current_loan').val(credit.current_loan / 100);
          $('#current_term').val(credit.current_term);
          $('#current_principal_balance').val(credit.current_principal_balance / 100);
          $('#current_total_balance').val(credit.current_total_balance / 100);
        }
      })["catch"](function (e) {});
    }
  }
});

function saveForm(id_form, model) {
  var new_form = document.getElementById(id_form);
  var data = new FormData(new_form);
  var id_rel = $('#id_rel').val();
  data.append('model', model);
  data.append('id_rel', id_rel);
  axios.post("/panel/action-form", data).then(function (response) {
    var result = response.data;
    window.history.back();
  })["catch"](function (e) {});
}

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
    $('#is_access_config option[value="' + result.is_access_config + '"]').attr("selected", "selected");
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
  var model = data.model; //$('#content-toast').empty();

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

__webpack_require__(/*! ./components/product/datatable_product */ "./resources/js/components/product/datatable_product.js");

__webpack_require__(/*! ./components/product/crud */ "./resources/js/components/product/crud.js");

__webpack_require__(/*! ./components/agreement/datatable */ "./resources/js/components/agreement/datatable.js");

__webpack_require__(/*! ./components/agreement/crud */ "./resources/js/components/agreement/crud.js");

__webpack_require__(/*! ./components/lead/datatable */ "./resources/js/components/lead/datatable.js");

__webpack_require__(/*! ./components/lead/crud */ "./resources/js/components/lead/crud.js");

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

__webpack_require__(/*! ./components/module/kc_check_up/datatable */ "./resources/js/components/module/kc_check_up/datatable.js");

__webpack_require__(/*! ./components/module/kc_check_up/action/datatable */ "./resources/js/components/module/kc_check_up/action/datatable.js");

__webpack_require__(/*! ./components/module/kc_check_up/action/datatable_report */ "./resources/js/components/module/kc_check_up/action/datatable_report.js");

__webpack_require__(/*! ./components/action/datatablemodule */ "./resources/js/components/action/datatablemodule.js");

__webpack_require__(/*! ./components/credit/profile/datatable */ "./resources/js/components/credit/profile/datatable.js");

__webpack_require__(/*! ./components/credit/product/datatable */ "./resources/js/components/credit/product/datatable.js");

__webpack_require__(/*! ./components/credit/datatable_in_progress */ "./resources/js/components/credit/datatable_in_progress.js");

window.moveElement = function (section, id, idDatatable) {
  axios.get("/panel/" + section + "/" + id + "/move").then(function (response) {
    if (idDatatable == null) {
      location.reload();
    } else {
      $('#' + idDatatable).DataTable().ajax.reload();
    }
  })["catch"](function (e) {});
};

__webpack_require__(/*! ./components/websocket */ "./resources/js/components/websocket.js");
})();

/******/ })()
;