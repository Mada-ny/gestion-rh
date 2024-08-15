<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des employés') }}
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
                    @can('gérer employés')
                    <div class="mb-10">
                        <a href="{{ route('employes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Ajouter un employé
                        </a>
                    </div>
                    @endcan

                    <div class="mb-6">
                        <form action="{{ route('employes.index') }}" method="GET" class="flex items-center">
                            <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request()->input('search')" placeholder="Rechercher par nom ou prénom" />
                        </form>
                    </div>

                    <div class="mb-4">
                        <label for="status-filter" class="block text-sm font-medium text-gray-700">Filtrer par statut</label>
                        <select id="status-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Tous les employés</option>
                            <option value="actif">Employés actifs</option>
                            <option value="absent">Employés absents/en congés</option>
                            <option value="inactif">Ancien employés</option>
                        </select>
                    </div>

                    @if ($employes->isEmpty())
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ __('Aucun employé trouvé.') }}
                    </div>
                    @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom & Prénom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Département</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="absences-table" class="bg-white divide-y divide-gray-200">
                            @foreach($employes as $employe)
                            <tr data-status="{{ $employe->statut }}">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $employe->nom }} {{ $employe->prénom }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $employe->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $employe->departement->nom }}</td>
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
                                <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('employes.show', $employe) }}" class="text-lg font-semibold text-indigo-600 hover:text-indigo-900 mr-2">Voir</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                    <div id="no-absences-message" class="mt-4 text-center text-gray-500 hidden">
                        Aucun employé trouvé.
                    </div>

                    <div class="mt-4">
                        {{ $employes->links() }}
                    </div>
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
        const searchInput = document.getElementById('search');
        searchInput.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            let hasVisibleRows = false;

            for (let i = 0; i < absencesRows.length; i++) {
                const row = absencesRows[i];
                const nomPrenom = row.getElementsByTagName('td')[0].textContent.toLowerCase();

                if (nomPrenom.includes(searchValue)) {
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