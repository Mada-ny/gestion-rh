<x-app-layout>
    <x-mary-header title="Congés" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator>
        @role('drh')
            <x-slot:actions>
                <x-button label="Nouvelle période" icon="o-plus-circle" class="btn-outline btn-primary font-semibold" link="{{ route('conges.create') }}" />
            </x-slot:actions>
        @endrole
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
            <div class="w-full text-center">
                @role('employe')
                    <h2 class="text-3xl font-bold mb-2">Mes congés</h2>
                    @if ($mesConges->isEmpty())
                        <h3 class="text-xl font-semibold">
                            Vous n'avez pas de congés pour le moment
                        </h3>
                        @else
                            @foreach ($mesConges as $conge)
                                <h3 class="text-xl font-semibold">
                                    Du {{ $conge->date_debut->translatedFormat('d F Y') }} au {{ $conge->date_fin->translatedFormat('d F Y') }}
                                </h3> 
                            @endforeach
                    @endif
                @endrole
                @role('drh|directeur')
                    <h2 class="text-3xl font-bold mb-2">Liste des congés</h2>
                    <div class="mb-6">
                        <form action="{{ route('conges.index') }}" method="GET" class="flex items-center">
                            <x-text-input id="search" name="search" type="text" class="mt-1 block w-full bg-secondary focus:ring-primary focus:border-primary" :value="request()->input('search')" placeholder="Rechercher par nom, prénom ou mois en format numérique (ex : Mai = 5)" autocomplete="off" />
                                <button type="submit" class="ml-3 text-primary hover:text-info">
                                    <x-icon name="o-magnifying-glass" class="w-6 h-6" />
                                </button>
                            <button href="{{ route('conges.index') }}" class="ml-3 text-primary hover:text-info">
                                <x-icon name="o-arrow-path" class="w-6 h-6" />
                            </button>
                        </form>
                    </div>
                    
                    @if ($conges->isEmpty())
                        <div>
                            <x-alert icon="o-exclamation-triangle" class="alert-warning">
                                Aucun congé trouvé
                            </x-alert>
                        </div>
                    @else
                        <table id="rounded" class="min-w-full divide-y divide-info-content">
                            <thead class="bg-base-300">
                                <tr>
                                    <th class="px-6 py-3 text-center text-primary text-sm font-bold uppercase tracking-wider">Employé</th>
                                    <th class="px-6 py-3 text-center text-primary text-sm font-bold uppercase tracking-wider">Période de congés</th>
                                    @role('directeur')
                                    <th class="px-6 py-3 text-center text-primary text-sm font-bold uppercase tracking-wider"></th>
                                    @endrole
                                    @can('gérer congés')
                                        <th class="px-6 py-3 text-center text-primary text-sm font-bold uppercase tracking-wider">Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody id="absences-table" class="bg-secondary divide-y divide-info">
                                @foreach ($conges as $conge)
                                    <tr data-status="{{ $conge->employe->nom }}">
                                        <td class="text-center px-6 py-4 whitespace-nowrap">{{ $conge->employe->nom }} {{ $conge->employe->prénom }}</td>
                                        <td class="text-center px-6 py-4 whitespace-nowrap">Du {{ $conge->date_debut->translatedFormat('d F Y')}} au {{ $conge->date_fin->translatedFormat('d F Y') }}</td>
                                        <td class="text-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @can('gérer congés')
                                                <x-button label="Modifier" icon="o-pencil" class="text-lg btn-ghost font-bold mr-2" link="{{ route('conges.edit', $conge) }}" responsive />
                                                <form action="{{ route('conges.destroy', $conge) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button label="Supprimer" type="icon" icon="o-trash" class="text-lg btn-ghost font-bold" onclick="return confirm('Êtes-vous sûr de vouloir retirer cette période ?')" responsive />
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <div id="no-absences-message" class="mt-4 text-center text-info hidden">
                        Aucun congé trouvé. <br>
                        Pour les dates, entrer le mois souhaité au format numérique (Ex: 5 pour Mai), puis effectuez une recherche complète
                        en cliquant sur l'icône de loupe.
                    </div>
                @endrole
            </div>
        </x-card>

        <x-card class="mt-10 p-6 shadow-lg">
            <div class="w-full text-center">
                <h2 class="text-3xl font-bold mb-2">Calendrier des congés</h2>
                <div id="calendar"></div>
            </div>
        </x-card>

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
                    dayHeaderClassNames: 'bg-accent text-accent-content text-xl font-bold',
                    dayCellClassNames: 'bg-secondary text-primary font-semibold',
                    initialView: 'dayGridMonth',
                    events: '{{ route('conges.calendar') }}',
                    eventColor: '#4CAF50',
                    eventTextColor: '#121316',
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
</x-app-layout>
