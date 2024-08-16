<x-app-layout>
    <x-mary-header title="Demande d'absence" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator>
        <x-slot:actions>
            <x-button label="Retour" icon="o-arrow-left" class="btn-outline btn-primary font-semibold" link="{{ route('absences.index') }}" />
        </x-slot:actions>
    </x-mary-header>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-40">
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
                <h2 class="text-3xl font-bold">{{ $absence->employe->prénom }} {{ $absence->employe->nom }}</h2>
                <h3 class="text-xl font-semibold">{{ $absence->employe->poste }} • 
                    @if ($absence->employe->statut == 'actif')
                        <span class="text-xl font-semibold text-success">
                            Actif
                        </span>
                    @elseif ($absence->employe->statut == 'absent')
                        <span class="text-xl font-semibold text-warning">
                            Absent
                        </span>
                    @else
                        <span class="text-xl font-semibold text-error">
                            Inactif
                        </span>
                    @endif
                </h3>
            </div>
            <div class="w-full text-center mt-10">
                    <p class="text-xl mb-6 font-bold">Date de début : <span class="text-xl font-normal">{{ $absence->date_debut->format('d/m/Y') }}</span></p>
                    <p class="text-xl mb-6 font-bold">Date de fin : <span class="text-xl font-normal">{{ $absence->date_fin->format('d/m/Y') }}</span></p>
                    <p class="text-xl mb-6 font-bold">Motif : <span class="text-xl font-normal">{{ $absence->motif }}</span></p>
                    <p class="text-xl mb-6 font-bold">Statut : 
                        @if ($absence->statut == 'en_attente')
                        <span class="text-xl font-normal text-warning">
                            En attente
                        </span>
                        @elseif ($absence->statut == 'approuvee')
                        <span class="text-xl font-normal text-success">
                            Approuvée
                        </span>
                        @elseif ($absence->statut == 'refusee')
                        <span class="text-xl font-normal text-error">
                            Refusée
                        </span>
                        @endif
                    </p>
            </div>
        </x-card>

        <div id="confirmModal" 
            class="fixed inset-0 z-50 flex items-center justify-center hidden backdrop-blur-sm">
            <x-card class="bg-secondary shadow-lg p-6 max-w-md w-full">
                <h3 class="text-xl font-bold mb-4">Suppression</h3>
                <p class="mb-6">Voulez-vous vraiment retirer cette demande ?</p>
                <div class="flex justify-end">
                    <x-mary-button label="Annuler" class="btn-info mr-2" onclick="closeModal()" />
                    <form id="deleteForm" action="{{ route('absences.destroy', $absence) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-mary-button label="Retirer" class="btn-error" type="submit" />
                    </form>
                </div>
            </x-card>
        </div>

        @can('créer absence')
            @if($absence->statut == 'en_attente')
                <div class="flex justify-center mt-8 gap-5">
                    <x-mary-button label="Modifier" link="{{ route('absences.edit', $absence) }}" class="btn-warning" icon="o-pencil" />
                    <x-mary-button label="Retirer la demande" class="btn-error" icon="o-x-circle" onclick="openModal()" />
                </div>
            @endif
        @endcan

        @can('approuver absences')
            <div class="flex justify-center mt-8 gap-5">
                <form action="{{ route('absences.approve', $absence) }}" method="POST" class="inline-block">
                    @csrf
                    <x-mary-button label="Approuver" type="submit" class="btn-success" icon="o-hand-thumb-up" />
                </form>
                <form action="{{ route('absences.reject', $absence) }}" method="POST" class="inline-block">
                    @csrf
                    <x-mary-button label="Refuser" type="submit" class="btn-error" icon="o-hand-thumb-down" />
                </form>
            </div>
        @endcan
    </div>

    <script>
        function openModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
        }
    
        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
    </script>
</x-app-layout>