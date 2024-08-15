<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __( 'Fiche employé' ) }}
            </h2>
            <a href="{{ route('employes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Retour
            </a>
        </div>
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
                    <h3 class="text-2xl font-semibold mb-4">{{ $employe->prénom }} {{ $employe->nom }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xl mb-6"><strong>Email :</strong> {{ $employe->email }}</p>
                            <p class="text-xl mb-6"><strong>Sexe :</strong> {{ $employe->sexe }}</p>
                            <p class="text-xl mb-6"><strong>Poste :</strong> {{ $employe->poste }}</p>
                            <p class="text-xl mb-6"><strong>Département :</strong> {{ $employe->departement->nom }}</p>
                            <p class="text-xl"><strong>Contact :</strong> {{ $employe->contact }}</p>
                        </div>
                        <div>
                            <p class="text-xl mb-6"><strong>Date de naissance :</strong> {{ $employe->date_naissance->format('d/m/Y') }}</p>
                            <p class="text-xl mb-6"><strong>Date d'embauche :</strong> {{ $employe->date_embauche->format('d/m/Y') }}</p>
                            <p class="text-xl mb-6"><strong>Statut :</strong>
                                @if ($employe->statut == 'actif')
                                    <span class="px-1 text-xl leading-5 font-semibold text-green-800">
                                        Actif
                                    </span>
                                @elseif ($employe->statut == 'absent')
                                    <span class="px-1 text-xl leading-5 font-semibold text-orange-800">
                                        Absent
                                    </span>
                                @else
                                    <span class="px-1 text-xl leading-5 font-semibold text-gray-800">
                                        Inactif
                                    </span>
                                @endif
                            </p>
                            <p class="text-xl mb-6"><strong>Lieu d'habitation :</strong> {{ $employe->lieu_habitation }}</p>
                            <p class="text-xl"><strong>Nationalité :</strong> {{ $employe->nationalité }}</p>
                        </div>
                        @if ($employe->statut == 'absent')
                            <p class="text-xl font-extrabold mt-12">
                                Absent du {{ $employe->demandesAbsence->where('statut', 'approuvee')->sortByDesc('date_debut')->first()->date_debut->translatedFormat('d F Y') }} 
                                au {{ $employe->demandesAbsence->where('statut', 'approuvee')->sortByDesc('date_debut')->first()->date_fin->translatedFormat('d F Y') }}
                            </p>
                        @endif
                    </div>
                    

                    @can('gérer employés')
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('employes.edit', $employe) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Modifier
                        </a>
                        <form action="{{ route('employes.destroy', $employe) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <a type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')">
                                Supprimer
                            </a>
                        </form>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
