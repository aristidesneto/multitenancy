@extends('multitenancy::layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 fw-normal">Migrations</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('tenant.migration') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success mb-3">Executar migrations para todas as bases</button>
                </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tenant</th>
                            <th scope="col">Domínio</th>
                            <th scope="col">Hostname</th>
                            <th scope="col">Database</th>
                            <th scope="col">Migração</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tenants as $tenant)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $tenant->name }}</td>
                                <td>{{ $tenant->domain }}</td>
                                <td>{{ $tenant->db_host }}</td>
                                <td>{{ $tenant->db_name }}</td>
                                <td>{{ $tenant->migrated ? 'Ok' : 'Pendente' }}</td>
                                <td>{{ $tenant->production ? 'Em produção' : 'Em desenvolvimento' }}</td>
                                <td>
                                    @if (!$tenant->production)
                                        <a href="{{ route('tenant.production', ['uuid' => $tenant->uuid]) }}" class="btn btn-success btn-sm">Producão</a>
                                        <a href="{{ route('tenant.migration.uuid', ['uuid' => $tenant->uuid, 'action' => 'fresh']) }}" class="btn btn-danger btn-sm">Fresh</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
