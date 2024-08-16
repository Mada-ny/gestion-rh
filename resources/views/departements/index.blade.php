<x-app-layout>
    <x-mary-header title="Départements de l'entreprise" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator>
        @can('gérer départements')
            <x-slot:actions>
                <x-button label="Nouveau département" icon="o-plus-circle" class="btn-outline btn-primary font-semibold" link="{{ route('departements.create') }}" />
            </x-slot:actions>
        @endcan
    </x-mary-header>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="flex justify-center">
                <div class="w-2/3 mb-4 ">
                    <x-alert icon="o-check-circle" class="alert-success" dismissible>
                        {{ session('success') }}
                    </x-alert>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="flex justify-center">
                <div>
                    <x-alert icon="o-x-circle" class="alert-error" dismissible>
                        {{ session('error') }}
                    </x-alert>
                </div>
            </div>
        @endif

        <x-card class="p-6 shadow-lg">
            <div>
                <table id="rounded" class="min-w-full divide-y divide-info-content">
                    <thead class="bg-base-300">
                        <tr>
                            <th class="px-6 py-3 text-left text-primary text-sm font-bold uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-primary text-sm font-bold uppercase tracking-wider">Nombre d'employés</th>
                            <th class="px-6 py-3 text-primary text-sm font-bold uppercase tracking-wider">Employés absents</th>
                            <th class="px-6 py-3 text-center text-primary text-sm font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-secondary divide-y divide-info">
                        @foreach ($departements as $departement)
                            <tr>
                                <td class="text-lg px-6 py-4 whitespace-nowrap">{{ $departement->nom }}</td>
                                <td class="text-center text-lg px-6 py-4 whitespace-nowrap">{{ $departement->employes->count() }}</td>
                                <td class="text-center text-lg px-6 py-4 whitespace-nowrap">{{ $departement->employes_absents }}</td>
                                <td class="text-center px-6 py-4 whitespace-nowrap text-lg font-medium">
                                    <x-button label="Voir" icon="o-eye" class="text-lg btn-ghost font-bold mr-2" link="{{ route('departements.show', $departement) }}" responsive />
                                    @can('gérer départements')
                                        <x-button label="Modifier" icon="o-pencil" class="text-lg btn-ghost font-bold mr-2" link="{{ route('departements.edit', $departement) }}" responsive />
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
        </x-card>
    </div>
</x-app-layout>