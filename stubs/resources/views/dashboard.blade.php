<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @tenantmain
                        <a href="{{ route('tenants.index') }}" class="inline-flex items-center px-4 py-2
                        bg-green-600 border border-transparent rounded-md mb-5
                        font-semibold text-xs text-white uppercase hover:bg-green-500">Gerenciar tenants</a>
                    @endtenantmain

                    @tenant
                        <a href="{{ route('app.index') }}" class="inline-flex items-center px-4 py-2
                        bg-green-600 border border-transparent rounded-md mb-5
                        font-semibold text-xs text-white uppercase hover:bg-green-500">Meus Posts</a>
                    @endtenant

                    <p>You're logged in!</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
