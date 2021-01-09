<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-800 leading-tight">
            Você está acessando o tenant: <strong>{{ session('current_tenant')['name'] }}</strong>!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="mt-5 md:mt-0 md:col-span-1">
                                <form action="{{ route('app.store') }}" method="post">
                                    @csrf
                                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                            <div class="col-span-6 sm:col-span-4">
                                                <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                                                <input type="text" name="title" id="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6 sm:col-span-4">
                                                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                                                <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                            </div>
                                        </div>
                                        <div class="px-4 py-3 bg-gray-5 sm:px-6">
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Cadastrar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="md:col-span-2">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Meus Posts</h3>

                                    @foreach ($posts as $post)
                                        <p class="mt-3 text-sm text-gray-600">
                                            <strong>Título: </strong> {{ $post->title }}
                                        </p>
                                        <p class="mt-3 text-sm text-gray-600">
                                            <strong>description: </strong> {{ $post->description }}
                                        </p>
                                        <hr class="m-5">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
