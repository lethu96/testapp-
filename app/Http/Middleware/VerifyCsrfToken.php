<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/members/{id}/update',
        'members/{id}/update',
        'project/update',
        'project/create',
        'project/destroy',
        'members/destroy',
        'members/create',
        'members/update',
        'member_projects/create',
        'member_projects/update',
        'member_projects/destroy',
    ];
}
