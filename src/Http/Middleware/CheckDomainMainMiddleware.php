<?php

namespace Aristides\Multitenancy\Http\Middleware;

use Aristides\Multitenancy\Tenant\TenantManager;
use Closure;
use Illuminate\Http\Request;

class CheckDomainMainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! (new TenantManager())->isDomainMain()) {
            abort(401);
        }

        return $next($request);
    }
}
