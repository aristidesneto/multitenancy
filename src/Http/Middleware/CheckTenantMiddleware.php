<?php

namespace Aristides\Multitenancy\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Aristides\Multitenancy\Tenant\TenantManager;

class CheckTenantMiddleware
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
        if (!(new TenantManager())->isTenant()) {
            abort(401);
        }

        return $next($request);
    }
}
