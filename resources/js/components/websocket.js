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
    let model = data.model;
    //$('#content-toast').empty();
    $(".toast").toast({autohide: false});
    axios.get('/panel/notification/' + model + '/show')
        .then(function (response) {
            let result = response.data;
            let my_user = $('#user_id').val();
            
            for (let index = 0; index < result.length; index++) {
                const element   = result[index];
                let title             = element.title;
                let body              = element.body;
                let user_id           = element.user_id;
                let is_add_adviser    = element.is_add_adviser;
                let toast    = element.toast;
                if (my_user == user_id && is_add_adviser == false) {
                    $('#content-toast').empty().append(toast);
                }
                
            }
            $(".toast").toast("show");
        })
});