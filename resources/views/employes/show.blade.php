<x-app-layout>
    @role('drh|directeur')
        <x-mary-header title="Fiche de l'employé" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator>
            <x-slot:actions>
                <x-button label="Liste des employés" icon="o-arrow-left" class="btn-outline btn-primary font-semibold" link="{{ route('employes.index') }}" />
            </x-slot:actions>
        </x-mary-header>
    @endrole

    @role('employe')
        <x-mary-header title="Mes informations" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator />
    @endrole

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
                <h2 class="text-3xl font-bold">{{ $employe->prénom }} {{ $employe->nom }}</h2>
                <h3 class="text-xl font-semibold">{{ $employe->poste }} • 
                    @if ($employe->statut == 'actif')
                        <span class="text-xl font-semibold text-success">
                            Actif
                        </span>
                    @elseif ($employe->statut == 'absent')
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
                    <p class="text-xl mb-6 font-bold">Email : <span class="text-xl font-normal">{{ $employe->email }}</span></p>
                    <p class="text-xl mb-6 font-bold">Contact : <span class="text-xl font-normal">{{ $employe->contact }}</span></p>
                    <p class="text-xl mb-6 font-bold">Sexe : 
                        @if ($employe->sexe == 'masculin')
                        <span class="text-xl font-normal">
                            Masculin
                        </span>
                        @elseif ($employe->sexe == 'féminin')
                        <span class="text-xl font-normal">
                            Féminin
                        </span>
                        @endif
                    </p>
                    <p class="text-xl mb-6 font-bold">Date de naissance : <span class="text-xl font-normal">{{ $employe->date_naissance->format('d/m/Y') }}</span></p>
                    <p class="text-xl mb-6 font-bold">Département : <span class="text-xl font-normal">{{ $employe->departement->nom }}</span></p>
                    <p class="text-xl mb-6 font-bold">Date d'embauche : <span class="text-xl font-normal">{{ $employe->date_embauche->format('d/m/Y') }}</span></p>
                    <p class="text-xl mb-6 font-bold">Domicile : <span class="text-xl font-normal">{{ $employe->lieu_habitation }}</span></p>
                    <p class="text-xl font-bold">Nationalité : <span class="text-xl font-normal">{{ $employe->nationalité }}</span></p>
                    
                    @if ($employe->statut == 'absent')
                        <p class="text-xl font-bold mt-8">
                            Absent du {{ $employe->demandesAbsence->where('statut', 'approuvee')->sortByDesc('date_debut')->first()->date_debut->translatedFormat('d F Y') }} 
                            au {{ $employe->demandesAbsence->where('statut', 'approuvee')->sortByDesc('date_debut')->first()->date_fin->translatedFormat('d F Y') }}
                        </p>
                    @endif
            </div>
        </x-card>

        <div id="confirmModal" 
            class="fixed inset-0 z-50 flex items-center justify-center hidden backdrop-blur-sm">
            <x-card class="bg-secondary shadow-lg p-6 max-w-md w-full">
                <h3 class="text-xl font-bold mb-4">Désactivation</h3>
                <p class="mb-6">Voulez-vous vraiment désactiver la fiche de cet employé ?</p>
                <div class="flex justify-end">
                    <x-mary-button label="Annuler" class="btn-info mr-2" onclick="closeModal()" />
                    <form id="deleteForm" action="{{ route('employes.destroy', $employe) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-mary-button label="Désactiver" class="btn-error" type="submit" />
                    </form>
                </div>
            </x-card>
        </div>
        <div id="confirmModal2" 
            class="fixed inset-0 z-50 flex items-center justify-center hidden backdrop-blur-sm">
            <x-card class="bg-secondary shadow-lg p-6 max-w-md w-full">
                <h3 class="text-xl font-bold mb-4">Réactivation</h3>
                <p class="mb-6">Souhaitez-vous réactiver cette fiche ?</p>
                <div class="flex justify-end">
                    <x-mary-button label="Non" class="btn-error mr-2" onclick="closeModal2()" />
                    <form id="deleteForm" action="{{ route('employes.restore', $employe) }}" method="POST" class="inline">
                        @csrf
                        <x-mary-button label="Oui" class="btn-success" type="submit" />
                    </form>
                </div>
            </x-card>
        </div>

        @can('gérer employés')
            <div class="flex justify-center mt-8 gap-5">
                <x-mary-button label="Modifier les informations" link="{{ route('employes.edit', $employe) }}" class="btn-warning" icon="o-pencil" />
                @if ($employe->statut == 'actif')
                    <x-mary-button label="Désactiver la fiche" class="btn-error" icon="o-x-circle" onclick="openModal()" />
                @elseif ($employe->statut == 'inactif')
                    <x-mary-button label="Réactiver la fiche" class="btn-success" icon="o-check-circle" onclick="openModal2()" />    
                @endif

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
        
        function openModal2() {
            document.getElementById('confirmModal2').classList.remove('hidden');
        }
    
        function closeModal2() {
            document.getElementById('confirmModal2').classList.add('hidden');
        }
    </script>
</x-app-layout>
