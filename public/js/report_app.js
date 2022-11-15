/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************************!*\
  !*** ./resources/js/report/report_app.js ***!
  \*******************************************/
function confetti() {
  $.each($(".particletext.confetti"), function () {
    var confetticount = $(this).width() / 50 * 10;

    for (var i = 0; i <= confetticount; i++) {
      $(this).append('<span class="particle c' + $.rnd(1, 2) + '" style="top:' + $.rnd(10, 50) + '%; left:' + $.rnd(0, 100) + '%;width:' + $.rnd(6, 8) + 'px; height:' + $.rnd(3, 4) + 'px;animation-delay: ' + $.rnd(0, 30) / 10 + 's;"></span>');
    }
  });
}

jQuery.rnd = function (m, n) {
  m = parseInt(m);
  n = parseInt(n);
  return Math.floor(Math.random() * (n - m + 1)) + m;
};

$(document).ready(function () {
  confetti();
});

window.desition = function (credit_id, financial_id) {
  Swal.fire({
    title: '¿Estás seguro?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí',
    cancelButtonText: 'Mejor no'
  }).then(function (result) {
    if (result.value) {
      axios.get("/panel/kc-check-up/report/desition/" + credit_id + "/" + financial_id + "/accept").then(function (response) {
        var reason = response.data; //window.location = '/panel/kc-control-desk';
      })["catch"](function (e) {});
    }
  });
};
/******/ })()
;