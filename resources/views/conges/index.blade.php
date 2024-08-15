<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Congés') }}
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

            @role('directeur|drh')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-10">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight mb-7">
                        {{ __('Liste des congés') }}
                    </h3>

                    @can('gérer congés')
                        <div class="mb-10">
                            <a href="{{ route('conges.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >
                                Ajouter une nouvelle période
                            </a>
                        </div>
                    @endcan

                    <div class="mb-6">
                        <form action="{{ route('conges.index') }}" method="GET" class="flex items-center">
                            <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request()->input('search')" placeholder="Rechercher par nom, prénom ou mois en format numérique (ex : Mai = 5)" />
                                <button type="submit" class="ml-3 text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            <a href="{{ route('conges.index') }}" class="ml-3 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </a>
                        </form>
                    </div>

                    @if ($conges->isEmpty())
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ __('Aucun congé trouvé.') }}
                    </div>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Employé</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Période de congés</th>
                                    @role('directeur')
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                                    @endrole
                                    @can('gérer congés')
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody id="absences-table" class="bg-white divide-y divide-gray-200">
                                @foreach ($conges as $conge)
                                    <tr data-status="{{ $conge->employe->nom }}">
                                        <td class="text-center px-6 py-4 whitespace-nowrap">{{ $conge->employe->nom }} {{ $conge->employe->prénom }}</td>
                                        <td class="text-center px-6 py-4 whitespace-nowrap">Du {{ $conge->date_debut->translatedFormat('d F Y')}} au {{ $conge->date_fin->translatedFormat('d F Y') }}</td>
                                        <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @can('gérer congés')
                                                <a href="{{ route('conges.edit', $conge) }}" class="text-lg font-semibold text-yellow-600 hover:text-yellow-900 mr-2">Modifier</a>
                                                <form action="{{ route('conges.destroy', $conge) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-lg font-semibold text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir retirer ces congés ?')">Supprimer</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <div id="no-absences-message" class="mt-4 text-center text-gray-500 hidden">
                        Aucun congé trouvé. <br>
                        Pour les dates, entrer le mois souhaité au format numérique (Ex: 5 pour Mai), puis cliquez sur "Rechercher".
                    </div>
                </div>
            </div>
            @endrole
            
            @role('employe')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-10">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight mb-5">
                        {{ __('Mes congés') }}
                    </h3>

                    {{-- Afficher la période des congés de l'employé --}}
                    @if($mesConges->isEmpty())
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ __('Vous n\'avez pas de congés pour le moment.') }}
                        </div>
                    @else
                        @foreach ($mesConges as $conge)
                            <p class="font-semibold mb-2">
                                {{ $conge->date_debut->translatedFormat('d F Y') }} - {{ $conge->date_fin->translatedFormat('d F Y') }}
                            </p>
                        @endforeach
                    @endif

                </div>
            </div>
            @endrole
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight">
                        {{ __('Calendrier des congés') }}
                    </h3>
                    <div id="calendar"></div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {
                            left: 'title',
                            right: 'prev next today'
                        },
                        locale: 'fr',
                        height: 'auto',
                        firstDay: 1,
                        buttonText: {
                            today:    'Aujourd\'hui',
                            month:    'Mois',
                            week:     'Semaine',
                            day:      'Jour',
                            list:     'Liste'
                        },
                        initialView: 'dayGridMonth',
                        events: '{{ route('conges.calendar') }}',
                        eventColor: '#4CAF50',
                        eventTextColor: '#fff',
                        eventClick: function(info) {
                            // Gérer le clic sur un événement (optionnel)
                        }
                    });
                    calendar.render();
                });
                </script>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const absencesTable = document.getElementById('absences-table');
                        const absencesRows = absencesTable.getElementsByTagName('tr');
                        const noAbsencesMessage = document.getElementById('no-absences-message');

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
        </div>
    </div>
</x-app-layout>
