<?php

namespace Aristides\Multitenancy\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Aristides\Multitenancy\Models\Tenant;
use Aristides\Multitenancy\Tenant\TenantManager;

class TenantMiddleware
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
        $manager = app(TenantManager::class);

        $isDomainMain = $manager->isDomainMain();

        if ($isDomainMain) {
            $this->setSessionTenant([
                'name' => 'Master',
                'uuid' => null
            ]);
            return $next($request);
        }

        $tenant = $this->getTenant($request->getHost());

        if (!$tenant) {
            abort(404);
        } else if(!$isDomainMain) {
            $manager->setConnection($tenant);

            $this->setSessionTenant($tenant->only([
                'name', 'uuid',
            ]));
        }

        return $next($request);
    }

    public function getTenant($host)
    {
        return Tenant::where('domain', $host)->first();
    }

    public function setSessionTenant($tenant) : void
    {
        session()->put('current_tenant', $tenant);
    }
}
