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

        $isBaseDomain = $manager->isDomainMain();

        if ($isBaseDomain) {
            $this->setSessionTenant([
                'name' => 'Master'
            ]);

            return $next($request);
        }

        $tenant = $this->getTenant($request->getHost());

        if (! $tenant) { abort(404); }

        $manager->setConnection($tenant);
        $this->setSessionTenant([
            'name' => $tenant->name
        ]);

        return $next($request);
    }

    public function getTenant(string $host) : Tenant
    {
        $host = explode('.', $host, 2);
        
        return Tenant::where('subdomain', $host[0])->first();
    }

    public function setSessionTenant(array $tenant) : void
    {
        session()->put('current_tenant', $tenant);
    }
}
