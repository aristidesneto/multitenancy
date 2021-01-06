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
        <p class="h5 my-0 me-md-auto fw-normal">Multitenancy - {{ session('current_tenant')['name'] }}</p>
        @tenantmain
            <nav class="my-2 my-md-0 me-md-3">
                <a class="p-2 text-dark" href="{{ route('tenant.index') }}">Tenants</a>
            </nav>
            <a class="btn btn-outline-primary" href="{{ route('tenant.create') }}">Novo tenant</a>
        @endtenantmain
    </header>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>
