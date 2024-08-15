<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Départements de l\'entreprise') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @can('gérer départements')
                        <div class="mb-10">
                            <a href="{{ route('departements.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Ajouter un département
                            </a>
                        </div>
                    @endcan

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre d'employés</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Employés absents</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($departements as $departement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $departement->nom }}</td>
                                    <td class="text-center px-6 py-4 whitespace-nowrap">{{ $departement->employes->count() }}</td>
                                    <td class="text-center px-6 py-4 whitespace-nowrap">{{ $departement->employes_absents }}</td>
                                    <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('departements.show', $departement) }}" class="text-lg font-semibold text-indigo-600 hover:text-indigo-900 mr-2">Voir</a>
                                        @can('gérer départements')
                                        <a href="{{ route('departements.edit', $departement) }}" class="text-lg font-semibold text-yellow-600 hover:text-yellow-900 mr-2">Modifier</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $departements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>