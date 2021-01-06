@extends('multitenancy::layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 fw-normal">Minha aplicação</h4>
            </div>
            <div class="card-body">
                Você acessou esta página com o tenant <strong>{{ session('current_tenant')['name'] }}</strong>!
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 fw-normal">Meus posts</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('app.store') }}" method="post">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Título</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Descrição</label>
                        <div class="col-sm-9">
                            <input type="text" name="description" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <button type="submit" class="btn btn-primary mb-3">Cadastrar</button>
                    </div>
                </form>

                <hr>

                @foreach ($posts as $post)
                    <p>Título: {{ $post->title }}</p>
                    <p>Mensagem: {{ $post->description }}</p>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
