<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __( $departement->nom ) }}
            </h2>
            <a href="{{ route('departements.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Retour
            </a>
        </div>
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
                    <p class="text-xl font-semibold mb-3">Nombre d'employés : {{ $departement->employes->count() }}</p>
                    <p class="text-xl font-semibold mb-12">Employés absents : {{ $departement->employes_absents }}</p>
                    <p class="text-xl text-center font-semibold mb-7">Employés du département</p>

                    <div class="mb-4">
                        <label for="status-filter" class="block text-sm font-medium text-gray-700">Filtrer par statut</label>
                        <select id="status-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Tous les employés</option>
                            <option value="actif">Employés actifs</option>
                            <option value="absent">Employés absents/en congés</option>
                            <option value="inactif">Ancien employés</option>
                        </select>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom & Prénom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="absences-table" class="bg-white divide-y divide-gray-200">
                            @foreach($employes as $employe)
                            <tr data-status="{{ $employe->statut }}">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $employe->nom }} {{ $employe->prénom }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $employe->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($employe->statut == 'actif')
                                    <span class="font-semibold text-green-800">
                                        Actif
                                    </span>
                                @elseif ($employe->statut == 'absent')
                                    <span class="font-semibold text-orange-800">
                                        Absent
                                    </span>
                                @else
                                    <span class="font-semibold text-gray-800">
                                        Inactif
                                    </span>
                                @endif
                                </td>
                                <td class="text-left px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('employes.show', $employe) }}" class="text-lg font-semibold text-indigo-600 hover:text-indigo-900 mr-2">Voir</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div id="no-absences-message" class="mt-4 text-center text-gray-500 hidden">
                        Aucune employé ne correspond à ce filtre.
                    </div>

                    <div class="mt-4">
                        {{ $employes->links() }}
                    </div>

                    @can('gérer départements')
                        <div class="mt-16 flex justify-end">
                            <a href="{{ route('departements.edit', $departement) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Modifier
                            </a>
                            <form action="{{ route('departements.destroy', $departement) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?')">
                                    Supprimer département
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('status-filter');
        const absencesTable = document.getElementById('absences-table');
        const absencesRows = absencesTable.getElementsByTagName('tr');
        const noAbsencesMessage = document.getElementById('no-absences-message');
    
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            let hasVisibleRows = false;
    
            for (let i = 0; i < absencesRows.length; i++) {
                const row = absencesRows[i];
                const status = row.getAttribute('data-status');
    
                if (selectedStatus === '' || status === selectedStatus) {
                    row.style.display = 'table-row';
                    hasVisibleRows = true;
                } else {
                    row.style.display = 'none';
                }
            }

            noAbsencesMessage.style.display = hasVisibleRows ? 'none' : 'block';
        });
    });
</script>