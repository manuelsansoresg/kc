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
        '/panel/user/search',
        '/action/manychat/wa-complete/lead/store',
        '/api/credit/{credit}/{s2_credit_id}/{tipo}/set',
        '/api/investor/{financial_product_id}/setTotalCapital',
        '/api/credit/{creditId}/pago/setData',
        '/validate-phone',
    ];
}
