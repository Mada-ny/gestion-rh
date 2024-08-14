<x-app-layout>
    <x-mary-header title="Tableau de bord" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator/>
    <h3 class="text-lg font-semibold px-4 ml-5">Bienvenue, {{ Auth::user()->prénom }} !</h3>
    <div class="max-w-7xl mx-auto p-4">
        @role('employe')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <x-card title="Total des demandes" class="bg-info text-secondary">
                        <p class="text-2xl font-bold">{{ isset($data['total_demandes']) ? $data['total_demandes'] : 0 }}</p>
                    </x-card>
                </div>
                <div>
                    <x-card title="Demandes en cours" class="bg-info text-secondary">
                        <p class="text-2xl font-bold">{{ isset($data['demandes_en_cours']) ? $data['demandes_en_cours'] : 0 }}</p>
                    </x-card>
                </div>
                <div>
                    <x-card title="Dernière demande" class="bg-info text-secondary">
                        <p class="text-2xl font-bold">
                            @if (isset($data['derniere_demande']) && $data['derniere_demande'])
                                {{ $data['derniere_demande']->created_at->format('d/m/Y') }} -
                                @switch($data['derniere_demande']->statut)
                                    @case('en_attente')
                                        {{ 'En attente' }}
                                        @break
                                    @case('approuvee')
                                        {{ 'Approuvée' }}
                                        @break
                                    @case('refusee')
                                        {{ 'Refusée' }}
                                        @break
                                @endswitch
                            @else
                                <p>Aucune</p>
                            @endif
                            </p>
                    </x-card>
                </div>
            </div>
        @endrole

        @role('drh')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-card title="Total des employés" class="bg-info text-secondary">
                        <p class="text-2xl font-bold">{{ $data['total_employes'] }}</p>
                    </x-card>
                </div>
                <div>
                    <x-card title="Employés absents" class="bg-info text-secondary">
                        <p class="text-2xl font-bold">
                            {{ $data['employes_en_conge'] }}
                        </p>
                    </x-card>
                </div>
            </div>
        @endrole

        @role('directeur')
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <x-card title="Demandes en attente" class="bg-info text-secondary h-full">
                        <p class="text-2xl font-bold">{{ $data['demandes_en_attente'] }}</p>
                    </x-card>
                </div>
                <div>
                    <x-card title="Dernière demande" class="bg-info text-secondary h-full">
                        <p class="text-2xl font-bold">
                            @if ($data['derniere_demande'])
                                {{ $data['derniere_demande']->created_at->format('d/m/Y') }}<br> ({{ $data['derniere_demande']->employe->nom }} {{ $data['derniere_demande']->employe->prénom }})
                            @else
                                Aucune
                            @endif
                        </p>
                    </x-card>
                </div>
                <div>
                    <x-card title="Demandes approuvées (ce mois)" class="bg-info text-secondary h-full">
                        <p class="text-2xl font-bold">{{ $data['demandes_approuvees'] }}</p>
                    </x-card>
                </div>
                <div>
                    <x-card title="Demandes refusées (ce mois)" class="bg-info text-secondary h-full">
                        <p class="text-2xl font-bold">{{ $data['demandes_refusees'] }}</p>
                    </x-card>
                </div>
            </div>
        @endrole
    </div>
</x-app-layout>