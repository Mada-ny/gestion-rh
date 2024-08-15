<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @role('employe')
                        <h3 class="text-lg font-semibold mb-4">Bienvenue, {{ Auth::user()->prénom }} !</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-200 p-4 rounded">
                                <p class="font-bold">Total des demandes :</p>
                                <p class="text-3xl font-bold">{{ isset($data['total_demandes']) ? $data['total_demandes'] : 0 }}</p>
                            </div>
                            <div class="bg-yellow-200 p-4 rounded">
                                <p class="font-bold">Demandes en cours :</p>
                                <p class="text-3xl font-bold">{{ isset($data['demandes_en_cours']) ? $data['demandes_en_cours'] : 0 }}</p>
                            </div>
                            <div class="bg-green-200 p-4 rounded">
                                <p class="font-bold">Dernière demande :</p>
                                <p>
                                @if (isset($data['derniere_demande']) && $data['derniere_demande'])
                                    <p class="text-xl font-bold">{{ $data['derniere_demande']->created_at->format('d/m/Y') }}</p>
                                    <p class="font-semibold">Statut : {{ $data['derniere_demande']->statut }}</p>
                                @else
                                    <p>Aucune</p>
                                @endif
                                </p>
                            </div>
                        </div>
                    @endrole

                    @role('drh')
                        <h3 class="text-lg font-semibold mb-4">Bienvenue, {{ Auth::user()->prénom }} !</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-blue-200 p-4 rounded">
                                <p class="font-bold">Total des employés :</p>
                                <p class="text-3xl font-bold">{{ $data['total_employes'] }}</p>
                            </div>
                            <div class="bg-green-200 p-4 rounded">
                                <p class="font-bold">Employés en congé :</p>
                                <p class="text-3xl font-bold">{{ $data['employes_en_conge'] }}</p>
                            </div>
                        </div>
                    @endrole

                    @role('directeur')
                        <h3 class="text-lg font-semibold mb-4">Bienvenue, {{ Auth::user()->prénom }} !</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-yellow-200 p-4 rounded">
                                <p class="font-bold">Demandes en attente :</p>
                                <p class="text-3xl font-bold">{{ $data['demandes_en_attente'] }}</p>
                            </div>
                            <div class="bg-green-200 p-4 rounded">
                                <p class="font-bold">Dernière demande :</p>
                                @if ($data['derniere_demande'])
                                    <p class="text-xl font-bold">{{ $data['derniere_demande']->created_at->format('d/m/Y') }}<br> ({{ $data['derniere_demande']->employe->nom }} {{ $data['derniere_demande']->employe->prénom }})</p>
                                @else
                                    <p class="text-3xl font-bold">Aucune</p>
                                @endif
                            </div>
                            <div class="bg-blue-200 p-4 rounded">
                                <p class="font-bold">Demandes approuvées (ce mois) :</p>
                                <p class="text-3xl font-bold">{{ $data['demandes_approuvees'] }}</p>
                            </div>
                            <div class="bg-red-200 p-4 rounded">
                                <p class="font-bold">Demandes refusées (ce mois) :</p>
                                <p class="text-3xl font-bold">{{ $data['demandes_refusees'] }}</p>
                            </div>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>