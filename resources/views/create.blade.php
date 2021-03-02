<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cadastro de Tenant
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Novo Tenant</h3>
                                    <p class="mt-3 text-sm text-gray-600">
                                        <strong>Subdomínio: </strong> Informe o subdomínio do tenant.
                                    </p>
                                    <p class="mt-3 text-sm text-gray-600">
                                        <strong>Nome do tenant: </strong> Um nome de identificação do tenant, usado apenas para uso de gerenciamento.
                                    </p>
                                    <p class="mt-3 text-sm text-gray-600">
                                        <strong>Hostname: </strong> Informe o endereço IP do servidor de banco de dados ou se preferir insira o domínio do mesmo.
                                    </p>

                                    <p class="mt-3 text-sm text-gray-600">
                                        <strong>Database: </strong> Informe o nome do banco de dados. O mesmo será criado caso não exista.
                                    </p>
                                    <p class="mt-3 text-sm text-gray-600">
                                        <strong>Usuário: </strong> Informe o usuário do banco de dados (esse usuário será criado se a opção de criar database estiver marcado).
                                    </p>
                                    <p class="mt-3 text-sm text-gray-600">
                                        <strong>Senha: </strong> Informe a senha do usuário do banco de dados. Deixe em branco para utilizar a senha informada no arquivo <strong>.env</strong>.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <form action="{{ route('tenants.store') }}" method="post">
                                    @csrf
                                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                            <div class="col-span-4 sm:col-span-4">
                                                <label for="price" class="block text-sm font-medium text-gray-700">Subdomínio</label>
                                                <div class="mt-1 relative rounded-md shadow-sm">
                                                    <input type="text" name="subdomain" id="subdomain" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md">
                                                    <div class="absolute bg-gray-100 p-2 inset-y-0 right-0 flex items-center text-gray-600 pr-3">
                                                        {{ $domain }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-span-6 sm:col-span-4">
                                                <label for="name" class="block text-sm font-medium text-gray-700">Nome do tenant</label>
                                                <input type="text" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6 sm:col-span-4">
                                                <label for="database_host" class="block text-sm font-medium text-gray-700">Hostname</label>
                                                <input type="text" name="database_host" id="database_host" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6 sm:col-span-4">
                                                <label for="database_name" class="block text-sm font-medium text-gray-700">Database</label>
                                                <input type="text" name="database_name" id="database_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6 sm:col-span-4">
                                                <label for="database_user" class="block text-sm font-medium text-gray-700">Usuário</label>
                                                <input type="text" name="database_user" id="database_user" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6 sm:col-span-4">
                                                <label for="database_password" class="block text-sm font-medium text-gray-700">Senha</label>
                                                <input type="password" name="database_password" id="database_password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <fieldset>
                                                <div class="mt-4 space-y-4">
                                                    <div class="flex items-start">
                                                        <div class="flex items-center h-5">
                                                            <input id="create_database" name="create_database" type="checkbox" checked class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                        </div>
                                                        <div class="ml-3 text-sm">
                                                            <label for="create_database" class="font-medium text-gray-700">Criar banco de dados</label>
                                                            <p class="text-gray-500">Ao selecionar essa opção será criado o banco de dados e será executado a migration para o novo tenant.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                              </fieldset>
                                        </div>
                                        <div class="px-4 py-3 bg-gray-5 sm:px-6">
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Cadastrar
                                            </button>

                                            <a href={{ route('tenants.index') }} class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                Voltar
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
