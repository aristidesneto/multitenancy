<?php

namespace Aristides\Multitenancy\Http\Controllers;

use Aristides\Multitenancy\Models\Tenant;
use Aristides\Multitenancy\Tenant\TenantManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;
use Ramsey\Uuid\Uuid;

class TenantController extends BaseCOntroller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function index()
    {
        $tenants = Tenant::get();

        return view('multitenancy::dashboard', [
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

    public function migrationByUuid(string $uuid, string $action = null)
    {
        $tenant = Tenant::where('uuid', $uuid)->first();

        $options = $action === 'fresh' ? '--fresh --seed' : '';

        Artisan::call("tenants:migrations {$tenant->id} {$options}");

        (new TenantManager())->setDefaultConnection();
        $tenant->migrated = true;
        $tenant->save();

        return redirect()->route('tenant.index');
    }
}
