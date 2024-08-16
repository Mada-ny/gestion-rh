<x-app-layout>
    <x-mary-header title="Liste des employés" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator>
        @can('gérer employés')
            <x-slot:actions>
                <x-mary-button label="Ajouter un employé" icon="o-plus-circle" class="btn-outline btn-primary font-semibold" link="{{ route('employes.create') }}"/>
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
                    
                    <div class="mb-6">
                        <form action="{{ route('employes.index') }}" method="GET" class="flex items-center">
                            <x-text-input id="search" name="search" type="text" class="mt-1 block w-full bg-secondary focus:ring-primary focus:border-primary" :value="request()->input('search')" placeholder="Rechercher par nom ou prénom" />
                                <x-button icon="c-arrow-path" class="btn-circle btn-ghost ml-3" link="{{ route('employes.index') }}"/>
                            </form>
                        </div>
                        
                    <div class="mb-4">
                        <label for="status-filter" class="block text-md font-semibold text-base-content">Filtrer par statut</label>
                        <select id="status-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-primary bg-secondary border-info focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                            <option value="">Tous les employés</option>
                            <option value="actif">Employés actifs</option>
                            <option value="absent">Employés absents/en congés</option>
                            <option value="inactif">Ancien employés</option>
                        </select>
                    </div>

                    <table id="rounded" class="min-w-full divide-y divide-info-content">
                        <thead class="bg-base-300">
                            <tr>
                                <th class="px-6 py-3 text-left text-primary text-sm font-bold uppercase tracking-wider">Nom & Prénom</th>
                                <th class="px-6 py-3 text-left text-primary text-sm font-bold uppercase tracking-wider">Département</th>
                                <th class="px-6 py-3 text-center text-primary text-sm font-bold uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-center text-primary text-sm font-bold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="absences-table" class="bg-secondary divide-y divide-info">
                            @foreach($employes as $employe)
                            <tr data-status="{{ $employe->statut }}">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $employe->nom }} {{ $employe->prénom }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $employe->departement->nom }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($employe->statut == 'actif')
                                        <span class="font-semibold text-success">
                                            <x-mary-button icon="o-link" label="Actif" class="btn-ghost text-lg pointer-events-none" responsive/>
                                        </span>
                                    @elseif ($employe->statut == 'absent')
                                        <span class="font-semibold text-warning">
                                            <x-mary-button icon="o-link-slash" label="Absent" class="btn-ghost text-lg pointer-events-none" responsive/>
                                        </span>
                                    @else
                                        <span class="font-semibold text-error">
                                            <x-mary-button icon="m-x-mark" label="Inactif" class="btn-ghost text-lg pointer-events-none" responsive/>
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center px-6 py-4 whitespace-nowrap text-lg font-medium">
                                    <x-button label="Voir" icon="o-eye" class="text-lg btn-ghost font-bold mr-2" link="{{ route('employes.show', $employe) }}" responsive/>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div id="no-absences-message" class="mt-4 text-center text-base-content hidden">
                        Aucun employé trouvé.
                    </div>

                    <div class="mt-4">
                        {{ $employes->links() }}
                    </div>
                </div>
            </x-card>
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