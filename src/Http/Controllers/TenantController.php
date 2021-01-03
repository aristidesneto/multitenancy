<?php

namespace Aristides\Multitenancy\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Aristides\Multitenancy\Models\Tenant;
use Aristides\Multitenancy\Tenant\TenantManager;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::get();

        return view('tenants', [
            'tenants' => $tenants
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
