<?php

namespace Aristides\Multitenancy\Http\Controllers;

use Aristides\Multitenancy\Events\TenantCreate;
use Aristides\Multitenancy\Models\Tenant;
use Aristides\Multitenancy\Tenant\TenantManager;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TenantController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function index()
    {
        $tenants = Tenant::orderBy('name')->get();
        $domain = explode(".", config('multitenancy.base_domain'), 2);

        return view('multitenancy::index', [
            'tenants' => $tenants,
            'domain' => ".$domain[1]"
        ]);
    }

    public function create()
    {
        $domain = explode(".", config('multitenancy.base_domain'), 2);

        return view('multitenancy::create', [
            'domain' => ".$domain[1]"
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['uuid'] = Uuid::uuid4();

        DB::beginTransaction();

        $tenant = Tenant::create($data);

        if ($request->create_database) {
            if (! event(new TenantCreate($tenant))) {
                DB::rollBack();
            }
        }

        DB::commit();

        return redirect()->route('tenants.index');
    }

    public function migration()
    {
        Artisan::call('multitenancy:migrations');

        (new TenantManager())->setDefaultConnection();
        Tenant::query()->where('migrated', false)->update(['migrated' => true]);

        return redirect()->route('tenants.index');
    }

    public function migrationByUuid(string $uuid, string $action = null)
    {
        $tenant = Tenant::where('uuid', $uuid)->first();

        if ($tenant->production) {
            throw new \Exception();
        }

        $options = $action === 'fresh' ? '--fresh --seed' : '';

        Artisan::call("multitenancy:migrations {$tenant->id} {$options}");

        (new TenantManager())->setDefaultConnection();
        $tenant->migrated = true;
        $tenant->save();

        return redirect()->route('tenants.index');
    }

    public function production(string $uuid)
    {
        $tenant = Tenant::where('uuid', $uuid)->first();
        $tenant->production = true;
        $tenant->production_at = Carbon::now();
        $tenant->save();

        return redirect()->route('tenants.index');
    }
}
