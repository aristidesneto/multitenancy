<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Multitenancy Multidatabase - Control Panel</title>

    <!-- CSS -->
    <link href="{{ url('vendor/multitenancy/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('vendor/multitenancy/css/style.css') }}" rel="stylesheet">
</head>
<body>

    <header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <p class="h5 my-0 me-md-auto fw-normal">Multitenancy</p>
        <nav class="my-2 my-md-0 me-md-3">
            <a class="p-2 text-dark" href="#">Tenants</a>
        </nav>
        <a class="btn btn-outline-primary" href="#">Sign up</a>
    </header>

    <div class="container">
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
                                    <span class="input-group-text" id="basic-addon2">.tenancy.test</span>
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
                                <label class="col-sm-3 col-form-label">Senha</label>
                                <div class="col-sm-9">
                                    <input type="text" name="db_pass" class="form-control" placeholder="Informe a senha do usuário">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" checked id="flexCheckDefault">
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
            <div class="col-md-6">
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
                                    <th scope="col">Database</th>
                                    <th scope="col">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tenants as $tenant)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $tenant->name }}</td>
                                        <td>{{ $tenant->db_name }}</td>
                                        <td>
                                            <a href="{{ route('tenant.migration.uuid', ['uuid' => $tenant->uuid]) }}" class="btn btn-warning btn-sm">Run</a>
                                            <a href="{{ route('tenant.migration.uuid', ['uuid' => $tenant->uuid, 'action' => 'fresh']) }}" class="btn btn-danger btn-sm">Fresh</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
