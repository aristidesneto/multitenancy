@extends('multitenancy::layouts.app')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 fw-normal">Cadastro de Tenants</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('tenant.store') }}" method="post">
                    @csrf
                    <div class="mb-3 row">
                        <div class="input-group mb-3">
                            <input type="text" name="domain" class="form-control" placeholder="Informe o subdomínio" aria-label="Informe o subdomínio" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">{{ $domain }}</span>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Nome Tenant</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" placeholder="Informe o nome do Tenant">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Hostname</label>
                        <div class="col-sm-9">
                            <input type="text" name="db_host" class="form-control" placeholder="Informe o hostname ou o IP do servidor remoto">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Database</label>
                        <div class="col-sm-9">
                            <input type="text" name="db_name" class="form-control" placeholder="Informe o nome do banco de dados">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Usuário</label>
                        <div class="col-sm-9">
                            <input type="text" name="db_user" class="form-control" placeholder="Informe o usuário do banco de dados">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="form-check">
                            <input class="form-check-input" name="create_database" type="checkbox" value="1" checked id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Criar o banco de dados e executar migrations
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <button type="submit" class="btn btn-primary mb-3">Cadastrar Tenant</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
