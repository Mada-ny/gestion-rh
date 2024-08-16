<x-app-layout>
    <x-mary-header title="{{ $departement->nom }}" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator>
        <x-slot:actions>
            <x-button label="Retour" icon="o-arrow-left" class="btn-outline btn-primary font-semibold" link="{{ route('departements.index') }}" />
        </x-slot:actions>
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
            <h3 class="mb-3 text-2xl text-center font-bold">Employés</h3>

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
                        <th class="px-6 py-3 text-left text-primary text-sm font-bold uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-center text-primary text-sm font-bold uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-center text-primary text-sm font-bold uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="absences-table" class="bg-secondary divide-y divide-info">
                    @foreach($employes as $employe)
                    <tr data-status="{{ $employe->statut }}">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employe->nom }} {{ $employe->prénom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employe->email }}</td>
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

            <div id="no-absences-message" class="mt-4 text-center text-gray-500 hidden">
                Aucun employé ne correspond à ce filtre.
            </div>

            <div class="mt-4">
                {{ $employes->links() }}
            </div>
        </x-card>
    </div>

    <div id="confirmModal" 
        class="fixed inset-0 z-50 flex items-center justify-center hidden backdrop-blur-sm">
        <x-card class="bg-secondary shadow-lg p-6 max-w-md w-full">
            <h3 class="text-xl font-bold mb-4">Suppression du département</h3>
            <p class="mb-6">Voulez-vous vraiment supprimer cet département ?</p>
            <div class="flex justify-end">
                <x-mary-button label="Annuler" class="btn-info mr-2" onclick="closeModal()" />
                    <form id="deleteForm" action="{{ route('departements.destroy', $departement) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-mary-button label="Supprimer" class="btn-error" type="submit" />
                    </form>
            </div>
        </x-card>
    </div>

    @can('gérer départements')
        <div class="flex justify-center mt-8 gap-5">
            <x-mary-button label="Modifier" link="{{ route('departements.edit', $departement) }}" class="btn-warning" icon="o-pencil" />
            <x-mary-button label="Supprimer le département" class="btn-error" icon="o-trash" onclick="openModal()" />
        </div>
    @endcan
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

        function openModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
        }
    
        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
</script>