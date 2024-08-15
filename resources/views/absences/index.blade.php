<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Absences') }}
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
                    @can('créer absence')
                        <div class="mb-10">
                            <a href="{{ route('absences.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >
                                Demander une absence
                            </a>
                        </div>
                    @endcan

                    <div class="mb-4">
                        <label for="status-filter" class="block text-sm font-medium text-gray-700">Filtrer par statut</label>
                        <select id="status-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">Toutes les demandes</option>
                            <option value="en_attente">Demandes en attente</option>
                            <option value="approuvee">Demandes approuvées</option>
                            <option value="refusee">Demandes refusées</option>
                        </select>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @can('voir employés')
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employé</th>
                                @endcan
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de début</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de fin</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="absences-table" class="bg-white divide-y divide-gray-200">
                            @foreach ($absences as $absence)
                                <tr data-status="{{ $absence->statut }}">
                                    @can('voir employés')
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absence->employe->nom }} {{ $absence->employe->prénom }}</td>
                                    @endcan
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absence->date_debut->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absence->date_fin->format('d/m/Y') }}</td>
                                    <td class="text-center px-6 py-4 whitespace-nowrap">
                                        @if($absence->statut == 'en_attente')
                                            <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                En attente
                                            </span>
                                        @elseif($absence->statut == 'approuvee')
                                            <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approuvée
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Refusée
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('absences.show', $absence) }}" class="text-lg font-semibold text-indigo-600 hover:text-indigo-900 mr-2">Voir</a>
                                        @can('créer absence')
                                            <a href="{{ route('absences.edit', $absence) }}" class="text-lg font-semibold text-yellow-600 hover:text-yellow-900 mr-2">Modifier</a>
                                            <form action="{{ route('absences.destroy', $absence) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-lg font-semibold text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir retirer votre demande ?')">Supprimer</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div id="no-absences-message" class="mt-4 text-center text-gray-500 hidden">
                        Aucune absence ne correspond à ce filtre.
                    </div>

                    <div class="mt-4">
                        {{ $absences->links() }}
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
    });
</script>
