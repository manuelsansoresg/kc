<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/deploy/index',
        '/panel/temp/*',
        '/panel/files/images/*',
        'api/surveysparrow/*',
        'api/rrss/*',
        '/api/appkax/*',
        '/lead/store',
        '/lead/form/store',
        '/survey',
        '/api/lead',
        '/slack/notification',
        '/reporte/*',
        '/action/manychat/{section}',
        '/action/manychat/lead/store',
        '/panel/user/search'
    ];
}
