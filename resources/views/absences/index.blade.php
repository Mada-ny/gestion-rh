<x-app-layout>
    @role('employe')
        <x-mary-header title="Mes absences" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator>
            <x-slot:actions>
                <x-button label="Nouvelle absence" icon="o-plus-circle" class="btn-outline btn-primary font-semibold" link="{{ route('absences.create') }}" />
            </x-slot:actions>
        </x-mary-header>
    @endrole

    @role('drh|directeur')
        <x-mary-header title="Liste des absences" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator />
    @endrole

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
                <div class="mb-4">
                    <label for="status-filter" class="block text-md font-semibold text-base-content">Filtrer par statut</label>
                    <select id="status-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-primary bg-secondary border-info focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">Toutes les demandes</option>
                        <option value="en_attente">Demandes en attente</option>
                        <option value="approuvee">Demandes approuvées</option>
                        <option value="refusee">Demandes refusées</option>
                    </select>
                </div>

                <table id="rounded" class="min-w-full divide-y divide-info-content">
                    <thead class="bg-base-300">
                        <tr>
                            @can('voir employés')
                            <th class="px-6 py-3 text-left text-primary text-sm font-bold uppercase tracking-wider">Employé</th>
                            @endcan
                            <th class="px-6 py-3 text-left text-primary text-sm font-bold uppercase tracking-wider">Date de début</th>
                            <th class="px-6 py-3 text-left text-primary text-sm font-bold uppercase tracking-wider">Date de fin</th>
                            <th class="px-6 py-3 text-center text-primary text-sm font-bold uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-center text-primary text-sm font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="absences-table" class="bg-secondary divide-y divide-info">
                        @foreach($absences as $absence)
                        <tr data-status="{{ $absence->statut }}">
                            @can('voir employés')
                            <td class="px-6 py-4 whitespace-nowrap">{{ $absence->employe->nom }} {{ $absence->employe->prénom }}</td>
                            @endcan
                            <td class="px-6 py-4 whitespace-nowrap">{{ $absence->date_debut->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $absence->date_fin->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($absence->statut == 'en_attente')
                                    <span class="font-semibold text-warning">
                                        <x-mary-button icon="o-minus" label="En attente" class="btn-ghost text-lg pointer-events-none" responsive />
                                    </span>
                                @elseif($absence->statut == 'approuvee')
                                    <span class="font-semibold text-success">
                                        <x-mary-button icon="o-check" label="Approuvée" class="btn-ghost text-lg pointer-events-none" responsive />
                                    </span>
                                @else
                                    <span class="font-semibold text-error">
                                        <x-mary-button icon="o-x-mark" label="Refusée" class="btn-ghost text-lg pointer-events-none" responsive />
                                    </span>
                                @endif
                            </td>
                            <td class="text-center px-6 py-4 whitespace-nowrap text-lg font-medium">
                                <x-button label="Voir" icon="o-eye" class="text-lg btn-ghost font-bold mr-2" link="{{ route('absences.show', $absence) }}" responsive />
                                @can('créer absence')
                                    @if($absence->statut == 'en_attente')
                                        <x-button label="Modifier" icon="o-pencil" class="text-lg btn-ghost font-bold mr-2" link="{{ route('absences.edit', $absence) }}" responsive />
                                        <form action="{{ route('absences.destroy', $absence) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-button label="Supprimer" type="icon" icon="o-trash" class="text-lg btn-ghost font-bold" onclick="return confirm('Êtes-vous sûr de vouloir retirer votre demande ?')" responsive />
                                        </form>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div id="no-absences-message" class="mt-4 text-center text-base-content hidden">
                    Aucun absence ne correspond à ce filtre.
                </div>

                <div class="mt-4">
                    {{ $absences->links() }}
                </div>
            </div>
        </x-card>
        <div class="mt-5 w-full flex justify-end">
            <form action="{{ route('absences.export') }}" method="POST">
                @csrf
                <select name="month" class="bg-base-300 border-info focus:bg-secondary focus:outline-none focus:border-primary focus:ring-primary rounded-md">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                            {{ Str::ucfirst(Carbon\Carbon::create()->month($i)->locale('fr_FR')->monthName) }}
                        </option>
                    @endfor
                </select>
                <select name="year" class="bg-base-300 border-info focus:bg-secondary focus:outline-none focus:border-primary focus:ring-primary rounded-md">
                    @for ($i = now()->year; $i >= now()->year - 5; $i--)
                        <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <x-button type="submit" icon="o-cloud-arrow-down" class="bg-info text-info-content hover:text-secondary-content font-serif font-bold ml-2">Exporter les absences</x-button>
            </form>
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
