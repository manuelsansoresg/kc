/******/ (() => { // webpackBootstrap
/*!*****************************************************!*\
  !*** ./resources/js/components/credit/solicitud.js ***!
  \*****************************************************/
var currentCreditId = null;
var currentHistoryId = null;
var currentAction = null;

// Función para abrir el modal de solicitud
function modalSolicitud(creditId, historyId) {
  currentCreditId = creditId;
  currentHistoryId = historyId;

  // Cargar información de la solicitud
  axios.get("/panel/solicitud/".concat(creditId, "/info")).then(function (response) {
    document.getElementById('modalSolicitudBody').innerHTML = response.data.html;

    // Mostrar el modal
    var modal = new bootstrap.Modal(document.getElementById('modalSolicitud'));
    modal.show();
  })["catch"](function (error) {
    console.error('Error al cargar información:', error);
    alert('Error al cargar la información de la solicitud');
  });
}

// Event listeners para los botones del modal
document.addEventListener('DOMContentLoaded', function () {
  // Botón Ver Detalles
  document.getElementById('btnVerDetalles').addEventListener('click', function () {
    if (currentCreditId) {
      window.open("/panel/credit/".concat(currentCreditId), '_blank');
    }
  });

  // Botón Denegar Vo.Bo
  document.getElementById('btnDenegarVoBo').addEventListener('click', function () {
    currentAction = 'denegar';
    mostrarModalConfirmacion('Denegar Vo.Bo');
  });

  // Botón Otorgar Vo.Bo
  document.getElementById('btnOtorgarVoBo').addEventListener('click', function () {
    currentAction = 'otorgar';
    mostrarModalConfirmacion('Otorgar Vo.Bo');
  });

  // Botón Confirmar Acción
  document.getElementById('btnConfirmarAccion').addEventListener('click', function () {
    if (currentAction && currentCreditId && currentHistoryId) {
      procesarAccion();
    }
  });
});

// Función para mostrar modal de confirmación
function mostrarModalConfirmacion(accion) {
  var _document$querySelect;
  // Obtener nombre del cliente del modal actual
  var clienteNombre = ((_document$querySelect = document.querySelector('#modalSolicitudBody .cliente-nombre')) === null || _document$querySelect === void 0 ? void 0 : _document$querySelect.textContent) || 'Cliente';
  var mensaje = "\xBFEst\xE1 seguro que desea ".concat(accion.toLowerCase(), " el Vo.Bo para ").concat(clienteNombre, "?");
  document.getElementById('modalConfirmacionBody').innerHTML = "\n        <p>".concat(mensaje, "</p>\n    ");
  document.getElementById('modalConfirmacionLabel').textContent = "Confirmar ".concat(accion);

  // Cerrar modal de solicitud y abrir modal de confirmación
  var modalSolicitud = bootstrap.Modal.getInstance(document.getElementById('modalSolicitud'));
  modalSolicitud.hide();
  setTimeout(function () {
    var modalConfirmacion = new bootstrap.Modal(document.getElementById('modalConfirmacion'));
    modalConfirmacion.show();
  }, 300);
}

// Función para procesar la acción (otorgar/denegar)
function procesarAccion() {
  var url = "/panel/solicitud/".concat(currentCreditId, "/vobo");
  var data = {
    action: currentAction,
    history_id: currentHistoryId,
    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  };
  axios.post(url, data).then(function (response) {
    if (response.data.success) {
      // Cerrar modal de confirmación
      var modalConfirmacion = bootstrap.Modal.getInstance(document.getElementById('modalConfirmacion'));
      modalConfirmacion.hide();

      // Mostrar mensaje de éxito
      alert(response.data.message || 'Acción realizada correctamente');

      // Refrescar la página
      location.reload();
    } else {
      alert(response.data.message || 'Error al procesar la acción');
    }
  })["catch"](function (error) {
    console.error('Error al procesar acción:', error);
    alert('Error al procesar la acción');
  });
}

// Función global para ser llamada desde el DataTable
window.modalSolicitud = modalSolicitud;
/******/ })()
;