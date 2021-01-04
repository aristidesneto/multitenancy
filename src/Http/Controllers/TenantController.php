<?php

namespace Aristides\Multitenancy\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Aristides\Multitenancy\Models\Tenant;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Aristides\Multitenancy\Tenant\TenantManager;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TenantController extends BaseCOntroller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $tenants = Tenant::get();

        return view('tenants', [
            'tenants' => $tenants,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['uuid'] = Uuid::uuid4();

        Tenant::create($data);

        return redirect()->route('tenant.index');
    }

    public function migration(Request $request)
    {
        Artisan::call('tenants:migrations');

        (new TenantManager())->setDefaultConnection();
        Tenant::query()->where('migrated', false)->update(['migrated' => true]);

        return redirect()->route('tenant.index');
    }

    public function migrationByUuid(string $uuid)
    {
        $tenant = Tenant::where('uuid', $uuid)->first();

        $fresh = '--fresh';
        $seed = '--seed';

        Artisan::call("tenants:migrations {$tenant->id} {$fresh} {$seed} ");

        (new TenantManager())->setDefaultConnection();

        return redirect()->route('tenant.index');
    }
}
