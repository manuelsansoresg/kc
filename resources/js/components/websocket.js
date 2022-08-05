import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'abcb59ca67abeb8745bb',
    wsHost: window.location.hostname,
    wsPort: 8080,
    wssPort: 8080,
    //forceTLS: true,
    disableStats: true,
    enabledTransports:['ws', 'wss']
});

