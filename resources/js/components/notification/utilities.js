window.showNotification = function() {
    $('#content-notification').html('');
    $('#icon-status-notification').removeClass('icon-status-off');
    $('#icon-status-notification').removeClass('icon-status-info');
    axios
    .get("/panel/notification/show")
    .then(function (response) {
        let result = response.data;
        let is_notification = result.is_notification;
        $('#content-notification').html(result.list);
        if (is_notification == 1) {
            $('#icon-status-notification').addClass('icon-status-info');
        } else {
            $('#icon-status-notification').addClass('icon-status-off');
        }

    })
    .catch(e => {
    });
}

window.readAllNotification = function() {
    $('#icon-status-notification').removeClass('icon-status-info');
    axios
    .get("/panel/notification/read")
    .then(function (response) {
        let result = response.data;
        $('#icon-status-notification').addClass('icon-status-off');
    })
    .catch(e => {
    });
}

$().ready(function () {
    showNotification();
});